<?php namespace Awebsome\Realestate\Components;
/**
*@Author Awebsome
*@url https://gotech.ar
*/
use Str;
use Lang;
use Redirect;
use Cms\Classes\Page;
use Cms\Classes\ComponentBase;
use Awebsome\Realestate\Models\Realty;
use Awebsome\Realestate\Models\Category;
use Awebsome\Realestate\Models\Settings;
use Illuminate\Support\Facades\Input;
class Realtydetail extends ComponentBase
{

    public  $categoryPage,
            $item;

    public function componentDetails()
    {
        return [
            'name'        => 'awebsome.realestate::lang.components.detailName',
            'description' => 'awebsome.realestate::lang.components.detailDesc'
        ];
    }

    public function defineProperties()
    {
        $settings             = Settings::instance();
        return [
            'slug' => [
                'title'       => 'awebsome.realestate::lang.realty.slug',
                'default'     => '{{ :slug }}',
                'type'        => 'string'
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
        ];
    }

    public function getCategoryPageOptions()
    {
        return Page::sortBy('baseFileName')->lists('baseFileName', 'baseFileName');
    }

    public function onRun()
    {

            $settings = Settings::instance();
            $this->currency = $this->page['currency'] = $settings->currency;
            $this->categoryPage = $this->page['categoryPage'] = $this->property('categoryPage');
            $this->item = $this->page['item'] = $this->loadItem();

            $this->updateItemViewCount();

            $settings->_imported($this);

    }

    protected function loadItem()
    {
        $slug = $this->property('slug');
        $item = Realty::isPublished()->where('slug', $slug)->first();

        if(!empty($item->category))
        {
            $item->category->setUrl($this->categoryPage, $this->controller);
        }

        return $item;
    }

    protected function updateItemViewCount()
    {
        if (empty($this->item->id)) { return; }

        //save vaidate error
//        $this->item->update([
//            'views' => intval($this->item->views) + 1
//        ]);

        $this->item->increment('views');

    }

}