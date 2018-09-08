<?php

namespace ilateral\SilverStripe\ImportExport\Tests\Model;

use SilverStripe\Dev\TestOnly;
use SilverStripe\ORM\DataObject;

//primary object we are loading records into
class CourseSelection extends DataObject implements TestOnly
{
    private static $table_name = "CourseSelection";

    private static $db = array(
        "Term" => "Int"
    );

    private static $has_one = array(
        "Course" => Course::class
    );
}