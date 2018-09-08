<?php

namespace ilateral\SilverStripe\ImportExport\Tests;

use SilverStripe\Dev\TestOnly;
use SilverStripe\ORM\DataObject;
use SilverStripe\Dev\SapphireTest;
use ilateral\SilverStripe\ImportExport\Tests\Model\Person;
use ilateral\SilverStripe\ImportExport\BulkLoader\ListBulkLoader;
use ilateral\SilverStripe\ImportExport\BulkLoader\Sources\ArrayBulkLoaderSource;

class ListBulkLoaderTest extends SapphireTest
{

    protected static $extra_dataobjects = [
        Person::class
    ];

    public function testImport()
    {
        $parent = Person::create(
            ["Name" => "George", "Age" => 55]
        );
        $parent->write();

        //add one existing child
        $existingchild = Person::create(
            ["Name" => "Xavier", "Age" => 13]
        );
        $existingchild->write();
        $parent->Children()->add($existingchild);

        $loader = new ListBulkLoader($parent->Children());
        $loader->duplicateChecks = array(
            "Name"
        );

        $source = new ArrayBulkLoaderSource(array(
            array(), //skip record
            array("Name" => "Martha", "Age" => 1), //new record
            array("Name" => "Xavier", "Age" => 16), //update record
            array("Name" => "Joanna", "Age" => 3), //new record
            "" //skip record
        ));
        $loader->setSource($source);
        $result = $loader->load();
        $this->assertEquals(2, $result->SkippedCount(), "Records skipped");
        $this->assertEquals(2, $result->CreatedCount(), "Records created");
        $this->assertEquals(1, $result->UpdatedCount(), "Record updated");
        $this->assertEquals(3, $result->Count(), "Records imported");
        $this->assertEquals(4, Person::get()->count(), "Total DataObjects is now 4");
        $this->assertEquals(3, $parent->Children()->count(), "Parent has 3 children");
    }

    public function testDeleteExisting()
    {
        $this->markTestIncomplete("test deletion");
    }
}
