<?php namespace Awebsome\Realestate\Models;

use Model;

/**
 * Model
 */
class Tag extends Model
{
    use \October\Rain\Database\Traits\Validation;

    /**
     * @var string The database table used by the model.
     */
    public $table = 'awebsome_realestate_tags';

    public $fillable = ['title'];

    /*
     * Validation
     */
    public $rules = [
        'title' => 'required|unique:awebsome_realestate_tags'
    ];

    public $customMessages = [
        'title.required'    => 'A tag title is required.',
        'title.unique'      => 'A tag by that title already exists.',
    ];

    public $belongsToMany = [
        'realty' => [
            'Awebsome\Realestate\Models\Realty',
            'table' => 'awebsome_realestate_realty_tag',
            'order' => 'awebsome_realestate_realty.updated_at desc'
        ],
        'items_count' => [
            'Awebsome\Realestate\Models\Realty',
            'table' => 'awebsome_realestate_realty_tag',
            'count' => true
        ]
    ];

    public function setTitleAttribute($value)
    {
        $this->attributes['title'] = strtolower($value);
    }

    public function scopeSearch($query, $tags)
    {
        if(is_array($tags)){
            $query->where("title", "like", "%".$tags[0]."%");
            for($i = 1; $i < count($tags); $i++){
                $query->orWhere("title", "like", "%".$tags[$i]."%");
            }
        }else{
            $query->where("title", "like", "%$tags%");
        }
    }

}