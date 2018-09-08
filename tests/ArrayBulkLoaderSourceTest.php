<?php

namespace ilateral\SilverStripe\ImportExport\Tests;

use SilverStripe\Dev\SapphireTest;
use ilateral\SilverStripe\ImportExport\BulkLoader\Sources\ArrayBulkLoaderSource;

class ArrayBulkLoaderSourceTest extends SapphireTest
{
    
    public function testIterator()
    {
        $data = array(
            array("First" => 1),
            array("First" => 2)
        );
        $source = new ArrayBulkLoaderSource($data);
        $iterator = $source->getIterator();
        $count = 0;
        foreach ($iterator as $record) {
            $this->assertEquals($data[$count], $record);
            $count++;
        }
    }
}
