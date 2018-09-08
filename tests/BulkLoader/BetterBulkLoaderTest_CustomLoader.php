<?php

namespace ilateral\SilverStripe\ImportExport\Tests\BulkLoader;

use SilverStripe\Dev\TestOnly;
use SilverStripe\Dev\CsvBulkLoader;

class BetterBulkLoaderTest_CustomLoader extends CsvBulkLoader implements TestOnly
{
    
    public function importFirstName(&$obj, $val, $record)
    {
        $obj->FirstName = "Customized {$val}";
    }

    public function updatePlayer(&$obj, $val, $record)
    {
        $obj->FirstName .= $val . '. ';
    }
}