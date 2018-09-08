<?php

namespace ilateral\SilverStripe\ImportExport\Tests\Model;

use SilverStripe\Dev\TestOnly;
use SilverStripe\ORM\DataObject;
use ilateral\SilverStripe\ImportExport\Tests\Model\BetterBulkLoaderTest_Player;

class Team extends DataObject implements TestOnly
{
    private static $db = array(
        'Title' => 'Varchar(255)',
        'TeamSize' => 'Int',
    );
    
    private static $has_many = array(
        'Players' => Player::class,
    );
}