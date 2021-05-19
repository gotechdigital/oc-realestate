<?php namespace Awebsome\Realestate\Controllers;

use BackendMenu;
use Awebsome\Realestate\Models\Settings;
use Backend\Classes\Controller;

class Messages extends Controller
{
    public $implement = [
        'Backend.Behaviors.FormController',
        'Backend.Behaviors.ListController'
    ];

    public $formConfig = 'config_form.yaml';
    public $listConfig = 'config_list.yaml';
    
    public $requiredPermissions = [
        'awebsome.realestate.access.realty'
    ];

    public function __construct()
    {
        parent::__construct();

        BackendMenu::setContext('Awebsome.Realestate', 'estate', 'messages');
        $this->vars['relatySettings'] = Settings::instance();
    }
}
