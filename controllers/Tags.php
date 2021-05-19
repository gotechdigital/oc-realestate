<?php namespace Awebsome\Realestate\Controllers;

use Backend\Classes\Controller;
use BackendMenu;
use Awebsome\Realestate\Models\Tag;

class Tags extends Controller
{
    public $implement = ['Backend\Behaviors\ListController'];
    
    public $listConfig = 'config_list.yaml';

    public $requiredPermissions = [
        'awebsome.realestate.access.realty' 
    ];

    public function __construct()
    {
        parent::__construct();
        BackendMenu::setContext('Awebsome.Realestate', 'estate', 'tags');
    }
}