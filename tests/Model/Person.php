<?php

namespace ilateral\SilverStripe\ImportExport\Tests\Model;

use SilverStripe\Dev\TestOnly;
use SilverStripe\ORM\DataObject;

class Person extends DataObject implements TestOnly
{
    private static $table_name = "Person";

    private static $db = array(
        "FirstName" => "Varchar",
        "Surname" => "Varchar",
        "Name" => "Varchar",
        "Age" => "Int"
    );

    private static $has_one = array(
        "Country" => Country::class,
        "Parent" => Person::class
    );

    private static $has_many = array(
        "Children" => Person::class
    );
}