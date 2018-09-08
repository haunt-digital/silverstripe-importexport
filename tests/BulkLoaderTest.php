<?php

namespace ilateral\SilverStripe\ImportExport\Tests;

use SilverStripe\Dev\TestOnly;
use SilverStripe\ORM\DataObject;
use SilverStripe\Dev\SapphireTest;
use ilateral\SilverStripe\ImportExport\Tests\Model\Person;
use ilateral\SilverStripe\ImportExport\Tests\Model\Country;
use ilateral\SilverStripe\ImportExport\BulkLoader\BetterBulkLoader;
use ilateral\SilverStripe\ImportExport\BulkLoader\Sources\ArrayBulkLoaderSource;

class BulkLoaderTest extends SapphireTest
{
    
    protected static $fixture_file = 'fixtures/BulkLoaderTest.yaml';

    protected static $extra_dataobjects = [
        Person::class,
        Country::class
    ];

    public function testLoading()
    {
        $loader = new BetterBulkLoader(Person::class);

        $loader->columnMap = array(
            "first name" => "FirstName",
            "last name" => "Surname",
            "name" => "Name",
            "age" => "Age",
            "country" => "Country.Code",
        );

        $loader->transforms = array(
            "Name" => array(
                'callback' => function ($value, $obj) {
                    $name =  explode(" ", $value);
                    $obj->FirstName = $name[0];
                    $obj->Surname = $name[1];
                }
            ),
            "Country.Code" => array(
                "link" => true, //link up to existing relations
                "create" => false //don't create new relation objects
            )
        );

        $loader->duplicateChecks = array(
            "FirstName"
        );

        //set the source data
        $data = array(
            array("name" => "joe bloggs", "age" => "62", "country" => "NZ"),
            array("name" => "alice smith", "age" => "24", "country" => "AU")
        );
        $loader->setSource(new ArrayBulkLoaderSource($data));

        $results = $loader->load();
        $this->assertEquals($results->CreatedCount(), 2);
        $this->assertEquals($results->UpdatedCount(), 0);
        $this->assertEquals($results->DeletedCount(), 0);
        $this->assertEquals($results->SkippedCount(), 0);
        $this->assertEquals($results->Count(), 2);

        $joe = Person::get()
                ->filter("FirstName", "joe")
                ->first();

        $this->assertNotNull($joe, "joe has been created");
        $this->assertNotEquals($joe->CountryID, 0);
        //relation has been succesfully joined
        $this->assertEquals($joe->Country()->Title, "New Zealand");
        $this->assertEquals($joe->Country()->Code, "NZ");
    }

    public function testLoadUpdatesOnly()
    {
        //Set up some existing dataobjects
        $nz = Country::get()->find('Code','NZ');
        $au = Country::get()->find('Code','AU');

        Person::create(array("FirstName" => "joe", "Surname" => "Kiwi", "Age" => "62", "CountryID" => $nz->ID))->write();
        Person::create(array("FirstName" => "bruce", "Surname" => "Aussie", "Age" => "24", "CountryID" => $au->ID))->write();

        $this->assertEquals(2, Person::get()->Count(), "Two people exist in Person class");
        
        $loader = new BetterBulkLoader(Person::class);
        $loader->addNewRecords = false;  // don't add new records from source
        $loader->columnMap = array(
            "firstname" => "FirstName",
            "surname" => "Surname",
            "age" => "Age",
            "country" => "Country.Code"
        );
        $loader->transforms = array(
            "Country.Code" => array(
                "link" => true, //link up to existing relations
                "create" => false //don't create new relation objects
            )
        );
        $loader->duplicateChecks = array(
            "FirstName"
        );
        //set the source data.  Joe has aged one year and shifted to Australia.  Bruce has aged a year too, but is missing other elements, which should remain the same.
        $data = array(
            array("firstname" => "joe", "surname" => "Kiwi", "age" => "63", "country" => "AU"),
            array("firstname" => "bruce", "age" => "25"),
            array("firstname" => "NotEntered", "surname" => "should not be entered", "age" => "33", "country" => "NZ"),
            array("firstname" => "NotEntered2", "surname" => "should not be entered as well", "age" => "24", "country" => "AU")
        );
        $loader->setSource(new ArrayBulkLoaderSource($data));
        
        $results = $loader->load();
        $this->assertEquals($results->CreatedCount(), 0);
        $this->assertEquals($results->UpdatedCount(), 2);
        $this->assertEquals($results->SkippedCount(), 2);
        $this->assertEquals($results->Count(), 2);
        
        $this->assertEquals(2, Person::get()->Count(), 'Should be two instances');
        $this->assertNull(Person::get()->find('FirstName', 'NotEntered'), 'New item "NotEntered" should not be added to Person');
        $this->assertNull(Person::get()->find('FirstName', 'NotEntered2'), 'New item "NotEntered2" should not be added to Person');

        $joe = Person::get()->find('FirstName', 'joe');
        $this->assertSame('63', $joe->Age, 'Joe should have the age of 63');
        $this->assertSame('Australia', $joe->Country()->Title, 'Joe should have the CountryID assigned to Australia');

        $bruce = Person::get()->find('FirstName', 'bruce');
        $this->assertSame('25', $bruce->Age, 'Bruce should have aged by one year to 25');
        $this->assertSame('Aussie', $bruce->Surname, 'Bruce should still have the surname of Aussie');
        $this->assertSame('Australia', $bruce->Country()->Title, 'Bruce should still have the CountryID assigned for Australia');
    }

    public function testColumnMap()
    {
        $this->markTestIncomplete("Implement this");
    }

    public function testTransformCallback()
    {
        $loader = new BetterBulkLoader(Person::class);
        $data = array(
            array("FirstName" => "joe", "age" => "62", "country" => "NZ")
        );
        $loader->setSource(new ArrayBulkLoaderSource($data));
        $loader->transforms = array(
            'FirstName' => array(
                'callback' => function ($value) {
                    return strtoupper($value);
                }
            )
        );
        $results = $loader->load();
        $this->assertEquals($results->CreatedCount(), 1);
        $result = $results->Created()->first();
        $this->assertEquals("JOE", $result->FirstName, "First name has been transformed");
    }

    public function testRequiredFields()
    {
        $loader = new BetterBulkLoader(Person::class);
        $data = array(
            array("FirstName" => "joe", "Surname" => "Bloggs"), //valid
            array("FirstName" => 0, "Surname" => "Bloggs"), //invalid firstname
            array("FirstName" => null), //invalid firstname
            array("FirstName" => "", "Surname" => ""), //invalid firstname
            array("age" => "25", "Surname" => "Smith"), //invalid firstname
            array("FirstName" => "Jane"), //valid
        );
        $loader->setSource(new ArrayBulkLoaderSource($data));
        $loader->transforms = array(
            'FirstName' => array(
                'required' => true
            )
        );
        $results = $loader->load();
        $this->assertEquals(2, $results->CreatedCount(), "Created 2");
        $this->assertEquals(4, $results->SkippedCount(), "Skipped 4");
    }
}
