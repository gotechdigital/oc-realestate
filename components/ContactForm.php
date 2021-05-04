<?php namespace Awebsome\Realestate\Components;
/**
*@Author Awebsome
*@url https://gotech.ar
*/

use Lang, Session, Validator, Flash;
use Cms\Classes\ComponentBase;
use Awebsome\Realestate\Models\Message;
use Awebsome\Realestate\Models\Realty;
use Awebsome\Realestate\Models\Settings;

class ContactForm extends ComponentBase
{
    public $item, $contactMessage;

    public function componentDetails()
    {
        return [
            'name' => 'awebsome.realestate::lang.components.contactForm',
            'description' => 'awebsome.realestate::lang.components.contactFormDesc'
        ];
    }
    
    public function defineProperties()
    {
        $settings = Settings::instance();
        return [
            'slug' => [
                'title' => 'awebsome.realestate::lang.realty.slug',
                'default' => '{{ :slug }}',
                'type' => 'string'
            ]
        ];
    }

    public function onRun()
    {
        $this->item = $this->page['item'] = $this->loadItem();
        $this->contactMessage = Lang::get('awebsome.realestate::lang.contactForm.message', [ 'realty' => "ID: {$this->item->id}" ]);
    }

    protected function loadItem()
    {
        $slug = $this->property('slug');
        $item = Realty::isPublished()->where('slug', $slug)->first();

        if(!empty($item->category)) {
            $item->category->setUrl($this->categoryPage, $this->controller);
        }

        return $item;
    }

    public function onHandleForm()
    {
        $item = $this->loadItem();

        $input = post();

        if (Session::token() != post('_token')) {
            Flash::error(Lang::get('awebsome.realestate::lang.contactForm.csrf_error'));
            return false;
        }

        $validator = Validator::make($input, [
            'email' => 'required|email|max:255',
            'phone' => 'required|alpha_num|max:255',
            'name' => 'required|string|max:255',
            'message' => 'required|string|max:999'
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withInput()->withErrors($validator);
        }

        Flash::success(Lang::get('awebsome.realestate::lang.contactForm.success'));
        Session::flash('formSuccess', Lang::get('awebsome.realestate::lang.contactForm.success'));

        $item->messages()->create([
            'email' => $input['email'],
            'phone' => $input['phone'],
            'name' => $input['name'],
            'message' => $input['message']
        ]);
        
        return redirect()->back();
    }
}