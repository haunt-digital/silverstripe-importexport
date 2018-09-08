<?php

namespace ilateral\SilverStripe\ImportExport\Tests\Model;

use SilverStripe\Dev\TestOnly;
use SilverStripe\ORM\DataObject;

class PlayerContract extends DataObject implements TestOnly
{
    private static $db = array(
        'Amount' => 'Currency',
    );
}