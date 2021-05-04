<?php namespace Awebsome\Realestate;

use Backend;
use System\Classes\PluginBase;

class Plugin extends PluginBase
{
    public $require = ['RainLab.Translate', 'GinoPane.AwesomeIconsList'];

    public function pluginDetails()
    {
        return [
            'name'          => 'awebsome.realestate::lang.plugin.name',
            'description'   => 'awebsome.realestate::lang.plugin.description',
            'author'        => 'Awebsome',
            'icon'          => 'icon-building',
            'homepage'      => ''
        ];
    }

    public function registerComponents()
    {
        return [
            'Awebsome\Realestate\Components\SearchForm'    => 'search_form',
            'Awebsome\Realestate\Components\Realtylist'    => 'realty_list',
            'Awebsome\Realestate\Components\Realtydetail'  => 'realty_detail',
            'Awebsome\Realestate\Components\Category'      => 'realty_category',
            'Awebsome\Realestate\Components\ContactForm'   => 'contact_form',
            'Awebsome\Realestate\Components\PopularList'   => 'popular_list',
            'Awebsome\Realestate\Components\NewestList'    => 'newest_list'
        ];
    }

    public function registerPermissions()
    {
        return [
            'awebsome.realestate.access.realty' => [
                'tab'   => 'awebsome.realestate::lang.plugin.name',
                'label' => 'awebsome.realestate::lang.plugin.name'
            ]
        ];
    }

    public function registerNavigation()
    {
        return [
            'estate' => [
                'label'         => 'awebsome.realestate::lang.plugin.name',
                'url'           => Backend::url('awebsome/realestate/realties'),
                'icon'          => 'icon-building',
                'permissions'   => ['awebsome.realestate.access.realty'],

                'sideMenu' => [
                    'realty' => [
                        'label'         => 'awebsome.realestate::lang.plugin.name',
                        'url'           => Backend::url('awebsome/realestate/realties'),
                        'icon'          => 'icon-building-o',
                        'permissions'   => ['awebsome.realestate.access.realty']
                    ],
                    'category' => [
                        'label'         => 'awebsome.realestate::lang.plugin.category',
                        'url'           => Backend::url('awebsome/realestate/categories'),
                        'icon'          => 'icon-folder',
                        'permissions'   =>['awebsome.realestate.access.realty']
                    ],
                    'feature' => [
                        'label'         => 'awebsome.realestate::lang.plugin.features',
                        'url'           => Backend::url('awebsome/realestate/features'),
                        'icon'          => 'icon-check-square-o',
                        'permissions'   =>['awebsome.realestate.access.realty']
                    ],
                    'tags' => [
                        'label'         => 'awebsome.realestate::lang.tags.title',
                        'url'           => Backend::url('awebsome/realestate/tags'),
                        'icon'          => 'icon-tags',
                        'permissions'   => ['awebsome.realestate.access.realty']
                    ],
                    'setting' => [
                        'label'         => 'awebsome.realestate::lang.settings.menuLabel',
                        'url'           => Backend::url('system/settings/update/awebsome/realestate/settings'),
                        'icon'          => 'icon-cog',
                        'permissions'   => ['awebsome.realestate.access.realty']
                    ],
                    'messages' => [
                        'label'         => 'awebsome.realestate::lang.plugin.messages',
                        'url'           => Backend::url('awebsome/realestate/messages'),
                        'icon'          => 'icon-envelope',
                        'permissions'   => ['awebsome.realestate.access.realty']
                    ]
                ]
            ]
        ];
    }

    public function registerSettings()
    {
        return [
            'settings' => [
                'label'         => 'awebsome.realestate::lang.settings.menuLabel',
                'description'   => 'awebsome.realestate::lang.settings.menuDescription',
                'category'      => 'awebsome.realestate::lang.plugin.name',
                'icon'          => 'icon-cog',
                'class'         => 'Awebsome\Realestate\Models\Settings',
                'order'         => 100
            ],
        ];
    }
}
