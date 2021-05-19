<?php namespace Awebsome\Realestate\Models;

use Model;

/**
 * Model
 */
class Feature extends Model
{
    use \October\Rain\Database\Traits\Validation;
    use \October\Rain\Database\Traits\Sortable;

    /**
     * @var mixed
     */
    public $timestamps = true;

    /**
     * @var string
     */
    public $table = 'awebsome_realestate_features';
    /**
     * @var array
     */
    public $implement = ['@RainLab.Translate.Behaviors.TranslatableModel'];

    /**
     * @var array
     */
    public $rules = [
        'title' => 'required',
        'slug'  => ['required', 'regex:/^[a-z0-9\/\:_\-\*\[\]\+\?\|]*$/i', 'unique:awebsome_realestate_features'],
    ];

    /**
     * @var array
     */
    public $belongsToMany = [
        'realty' => [
            'Awebsome\Realestate\Models\Realty',
            'table' => 'awebsome_realestate_realty_feature',
            'order' => 'awebsome_realestate_realty.updated_at desc',
        ],
    ];

    /**
     * @var array
     */
    public $translatable = ['title'];

    public function afterDelete()
    {
        $this->realty()->detach();
    }

    /**
     * @param $pageName
     * @param $controller
     * @return mixed
     */
    public function setUrl($pageName, $controller)
    {
        $params = [
            'id'   => $this->id,
            'slug' => $this->slug,
        ];

        return $this->url = $controller->pageUrl($pageName, $params);
    }

    /**
     * @return mixed
     */
    public function getCountRealtyAttribute()
    {
        return $this->realty->count();
    }
}
