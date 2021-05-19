<?php namespace Awebsome\Realestate\Models;

use Model;

/**
 * Model
 */
class Property extends Model
{
    use \October\Rain\Database\Traits\Validation;
    public $table = 'awebsome_realestate_realty_properties';
    public $implement = ['@RainLab.Translate.Behaviors.TranslatableModel'];

    protected $guarded = ['*'];

    public $rules = [];

    protected $fillable = ['name', 'values'];

    public $timestamps = false;

    public $translatable = ['name', 'value'];

    public $belongsTo = [
        'realty' => ['Awebsome\Realestate\Models\Realty']
    ];
}