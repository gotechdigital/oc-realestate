<?php namespace Awebsome\Realestate\Models;

use Model;
use Cms\Classes\Page;
use Responsiv\Currency\Models\Currency;

class Settings extends Model
{
    public $implement       = ['System.Behaviors.SettingsModel'];
    public $settingsCode    = 'awebsome_realestate_settings';
    public $settingsFields  = 'fields.yaml';

    private static
            $importVendor   = 0;

    public function getDetailPageOptions()
    {
        return Page::sortBy('baseFileName')->lists('baseFileName', 'baseFileName');
    }

    public function getCurrencyOptions()
    {
        return Currency::isEnabled()->orderBy('currency_code', 'asc')->lists('currency_code', 'currency_code');
    }

    /** This should not be here **/
    public function _imported($controller)
    {
        if(self::$importVendor > 0){
            return false;
        }
        self::$importVendor = 1;

        if($this->import_bootsrap){
            $controller->addCss('/plugins/awebsome/realestate/assets/css/bootstrap.min.css');
            $controller->addJs('/plugins/awebsome/realestate/assets/js/bootstrap.min.js');
        }

        if($this->import_owl){
            $controller->addCss('/plugins/awebsome/realestate/assets/css/owl.carousel.css');
            $controller->addCss('/plugins/awebsome/realestate/assets/css/owl.theme.css');
            $controller->addCss('/plugins/awebsome/realestate/assets/css/owl.transitions.css');
            $controller->addJs('/plugins/awebsome/realestate/assets/js/owl.carousel.min.js');
        }

        if($this->import_fa){
            $controller->addCss('/plugins/awebsome/realestate/assets/css/font-awesome.min.css');
            $controller->addCss('/plugins/awebsome/realestate/assets/css/font-awesome-v4-shims.min.css');
        }

        if($this->import_custom){
            $controller->addCss('/plugins/awebsome/realestate/assets/css/style.css');
            $controller->addJs('/plugins/awebsome/realestate/assets/js/scripts.js');
        }
    }

}
