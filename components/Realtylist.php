<?php namespace Awebsome\Realestate\Components;
/**
*@Author Awebsome
*@url https://gotech.ar
*/

use October\Rain\Exception\ApplicationException;
use Str;
use Lang;
use Redirect;
use Session;
use Cms\Classes\Page;
use Cms\Classes\ComponentBase;
use Awebsome\Realestate\Models\Realty;
use Awebsome\Realestate\Models\Category;
use Awebsome\Realestate\Models\Settings;
use Illuminate\Support\Facades\Input;

class Realtylist extends ComponentBase
{
    public  $data,
            $categoryPage,
            $detailPage,
            $searchPage,

            $pageParam,
            $itemsPerPage,

            $categoryID,

            $colLg = 3, $colMd = 4, $colSm = 6, $colXs = 12;

    public function componentDetails()
    {
        return [
            'name'        => 'awebsome.realestate::lang.components.listName',
            'description' => 'awebsome.realestate::lang.components.listNameDesc'
        ];
    }

    public function defineProperties()
    {
        $settings             = Settings::instance();

        return [
            'pageNumber' => [
                'title'             => 'awebsome.realestate::lang.components.pagination',
                'description'       => 'awebsome.realestate::lang.components.pagination_description',
                'type'              => 'string',
                'default'           => '{{ :page }}',
            ],
            'categoryFilter' => [
                'title'             => 'awebsome.realestate::lang.components.categoryFilter',
                'description'       => 'awebsome.realestate::lang.components.filter_description',
                'type'              => 'string',
                'default'           => '{{ :slug }}'
            ],
            'itemsPerPage' => [
                'title'             => 'awebsome.realestate::lang.components.items_per_page',
                'type'              => 'string',
                'validationPattern' => '^[0-9]+$',
                'validationMessage' => 'awebsome.realestate::lang.components.items_per_page_validation',
                'default'           => 15,
            ],
            'categoryPage' => [
                'title'             => 'awebsome.realestate::lang.components.items_category',
                'type'              => 'dropdown',
                'default'           => $settings->category_page,
                'group'             => 'Links',
            ],
            'detailPage' => [
                'title'             => 'awebsome.realestate::lang.components.items_post',
                'type'              => 'dropdown',
                'default'           => $settings->detail_page,
                'group'             => 'Links',
                'options'           => $this->getCategoryPageOptions()
            ],
            'searchPage' => [
                'title'             => 'awebsome.realestate::lang.components.items_search',
                'type'              => 'dropdown',
                'default'           => $settings->search_page,
                'group'             => 'Links',
                'options'           => $this->getCategoryPageOptions()
            ],
            'sortField' => [
                'title'             => 'awebsome.realestate::lang.components.sortField',
                'type'              => 'dropdown',
                'default'           => 'created_at',
                'group'             => 'Ranking',
                'options'           => [
                    'created_at' => 'Created',
                    'updated_at' => 'Updated'
                ],
            ],
            'sortType' => [
                'title'             => 'awebsome.realestate::lang.components.sortType',
                'type'              => 'dropdown',
                'default'           => 'desc',
                'group'             => 'Ranking',
                'options'           => [
                    'desc' => 'Descending',
                    'asc'  => 'Ascending'
                ],
            ],
            'colLg' => [
                'title'             => 'col-lg-?',
                'description'       => 'awebsome.realestate::lang.components.column',
                'type'              => 'string',
                'default'           => 3,
                'group'             => 'Column',
            ],
            'colMd' => [
                'title'             => 'col-md-?',
                'description'       => 'awebsome.realestate::lang.components.column',
                'type'              => 'string',
                'default'           => 4,
                'group'             => 'Column',
            ],
            'colSm' => [
                'title'             => 'col-sm-?',
                'description'       => 'awebsome.realestate::lang.components.column',
                'type'              => 'string',
                'default'           => 6,
                'group'             => 'Column',
            ],
            'colXs' => [
                'title'             => 'col-xs-?',
                'description'       => 'awebsome.realestate::lang.components.column',
                'type'              => 'string',
                'default'           => 12,
                'group'             => 'Column',
            ],


        ];
    }

    public function getCategoryPageOptions()
    {
        return Page::sortBy('baseFileName')->lists('baseFileName', 'baseFileName');
    }

    public function onRun()
    {
        $this->page['filters'] = Session::get('filters');
        $this->page['realties'] = $this->getProperties();

        $this->prepareVars();
        $settings                   = Settings::instance();
        $this->data                 = $this->page['data']         = $this->loadList();

        $settings->_imported($this);
    }

    public function prepareVars()
    {
        $settings                   = Settings::instance();

        $this->pageParam            = $this->page['pageParam']    = $this->paramName('pageNumber');
        $this->itemsPerPage         = $this->page['itemsPerPage'] = $this->property('itemsPerPage');

        if($this->property("categoryFilter", null))
        {
            $this->prepareCategory();
        }

        $this->page['colLg'] = $this->colLg;
        $this->page['colMd'] = $this->colMd;
        $this->page['colSm'] = $this->colSm;
        $this->page['colXs'] = $this->colXs;

        if(intval($this->property('colLg'))){
            $this->colLg = $this->page['colLg'] = intval($this->property('colLg'));
        }
        if(intval($this->property('colMd'))){
            $this->colMd = $this->page['colMd'] = intval($this->property('colMd'));
        }
        if(intval($this->property('colSm'))){
            $this->colSm = $this->page['colSm'] = intval($this->property('colSm'));
        }
        if(intval($this->property('colXs'))){
            $this->colXs = $this->page['colXs'] = intval($this->property('colXs'));
        }

        $this->currency             = $this->page['currency']     = $settings->currency;
        $this->categoryPage         = $this->page['categoryPage'] = $this->property('categoryPage');
        $this->detailPage           = $this->page['detailPage']   = $this->property('detailPage');
        $this->searchPage           = $this->page['searchPage']   = $this->property('searchPage');
        $this->status               = $this->page['status']       = (new Realty())->getStatusOptions();

    }

    protected function prepareCategory()
    {
        $category = $this->property("categoryFilter");
        if(!is_numeric($category))
        {
            $categoryRow = Category::where("slug", "=", $category)->first();
        }
        else
        {
            $categoryRow = Category::where("id", "=", $category)->first();
        }
        if(!empty($categoryRow->id))
        {
            $this->page['category'] = $categoryRow;
            $this->categoryID       = $this->page['categoryID'] = $categoryRow->id;
        }
        else
        {
            $this->categoryID       = $this->page['categoryID'] = null;
        }
    }

    public function loadList()
    {
        $param          =[
            'page'          => $this->property("pageNumber",1),
            'perPage'       => $this->itemsPerPage,
            'sort'          => $this->property('sortField', 'created_at'),//'created_at',
            'order'         => $this->property('sortType', 'created_at'), //'desc',
            'category'      => Input::get('category', $this->categoryID),
            'status'        => Input::get('status', null),
            'tags'          => Input::get('tags', null),
            'price'         => Input::get('price', null),
            'address'       => Input::get('address', null)
        ];
        $items          = Realty::ListFrontEnd($param);

        $items->each(function($item) {
            $item->setUrl($this->detailPage, $this->controller);
        });

        return $items;
    }

    public function getProperties()
    {
        $properties = Realty::isPublished();
        $filter_condition = Session::get('filters.filter_condition');
        $order = Session::get('filters.order');
        
        if(!empty($filter_condition)) {
            $properties->where('status', $filter_condition);
        }

        // date_desc
        // date_asc
        // price_asc
        // price_desc
        
        switch ($order) {
            case 'date_desc':
                $properties->orderBy('created_at','desc');
                break;
            case 'date_asc':
                $properties->orderBy('created_at','asc');
                break;
            case 'price_asc':
                $properties->orderBy('price','asc');
                break;
            case 'price_desc':
                $properties->orderBy('price','desc');
                break;
            
            default:
                $properties->orderBy('created_at','desc');
                break;
        }

        return $properties->paginate($this->property('itemsPerPage'));
    }

    public function onFilter()
    {
        if(Input::has('filter_condition')) {
            $filter = Input::get('filter_condition');
            Session::put('filters.filter_condition', $filter);
        }
        
        if(Input::has('order')) {
            $order = Input::get('order');
            Session::put('filters.order', $order);
        }
    }

    public function getRecentProperties()
    {
        return Realty::isPublished()->orderBy('created_at', 'desc')->get();
    }

}