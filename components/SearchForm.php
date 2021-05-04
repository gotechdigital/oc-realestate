<?php namespace Awebsome\Realestate\Components;
/**
*@Author Awebsome
*@url https://gotech.ar
*/
use Str;
use Lang;
use Redirect;
use Cms\Classes\ComponentBase;
use Awebsome\Realestate\Models\Realty;
use Awebsome\Realestate\Models\Category;
use Awebsome\Realestate\Models\Settings;

class SearchForm extends ComponentBase
{
    public
        /**
         * Category page name
         * @var string
         */
            $categoryPage = '',
        /**
         * Eloquent\Collection Object
         * @var null
         */
            $categories = null,
        /**
         * Buy, Rent, Sold
         * @var array
         */
            $status     = [],

            $langs      = null;


    public function componentDetails()
    {
        return [
            'name'        => 'awebsome.realestate::lang.components.searchForm',
            'description' => 'awebsome.realestate::lang.components.searchFormDesc'
        ];
    }

    public function init()
    {
        parent::init();

        $settings                   = Settings::instance();
        $this->page['categoryPage'] =
        $this->categoryPage         = $settings->category_page;

        $this->page['status']       =
        $this->status               = (new Realty())->getStatusOptions();

        $this->page['categories']   =
        $this->categories           = Category::orderBy("sort_order","asc")->get();

        $this->langs                = new \stdClass();

        $this->page['placeholder']  =
        $this->langs->placeholder   = Lang::get('awebsome.realestate::lang.components.searchPlaceHolder');

        $settings->_imported($this);
    }

}