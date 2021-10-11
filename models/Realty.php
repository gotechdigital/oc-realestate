<?php namespace Awebsome\Realestate\Models;

use Str;
use Lang;
use Model;
use Carbon\Carbon;
use Backend\Models\User;
use ValidationException;
use Awebsome\Realestate\Models\Settings;
use RainLab\Translate\Models\Message;
/**
 * Model
 */
class Realty extends Model
{
    use \October\Rain\Database\Traits\Validation;

    public $table       = 'awebsome_realestate_realty';
    public $implement   = ['@RainLab.Translate.Behaviors.TranslatableModel'];

    protected $fillable = ['views'];

    public $rules = [
        'title'     => 'required',
        'code'      => 'required|alpha_num|unique:awebsome_realestate_realty',
        'slug'      => ['required', 'alpha_dash', 'unique:awebsome_realestate_realty'],
        'price'     => 'required',
        'address'   => 'required|string',
    ];

    public $translatable = ['title', 'excerpt', 'description', 'address'];

    public static $allowedSortingOptions = array(
        'title'         => 'Title',
        'price'         => 'Price',
        'created_at'    => 'Created',
        'updated_at'    => 'Updated',
        'sort_order'    => 'Order',
        'random'        => 'Random',
        'address'       => 'Address',
        'views'         => 'Views'
    );

    ############################################################################################################
    # RELATIONS
    ############################################################################################################

    public $belongsTo = [
        'category' => ['Awebsome\Realestate\Models\Category']
    ];
    public $attachMany = [
        'images' => ['System\Models\File'],
        'images_360' => ['System\Models\File'],
    ];
    public $belongsToMany = [
        'tags' => [
            'Awebsome\Realestate\Models\Tag',
            'table' => 'awebsome_realestate_realty_tag',
            'order' => 'title'
        ],
        'features' => [
            'Awebsome\Realestate\Models\Feature',
            'table' => 'awebsome_realestate_realty_feature',
            'order' => 'title'
        ],
    ];

    public $hasMany = [
        'properties' => [
            'Awebsome\Realestate\Models\Property',
            'order' => 'sort_order',
        ],
        'messages' => [
            'Awebsome\Realestate\Models\Message',
            'order' => 'created_at desc'
        ]
    ];

    ############################################################################################################
    # PERMISSIONS
    ############################################################################################################

    public function canEdit(User $user)
    {
        return ($this->user_id == $user->id) || $user->hasAnyAccess(['awebsome.realestate.access.realty']);
    }

    ############################################################################################################
    # GET ATTRIBUTE
    ############################################################################################################

    public function getCategoryNameAttribute(){
        if (!$this->category) {
            return;
        }
        return $this->category->title;
    }

    public function getFormatPriceAttribute(){
        return @number_format($this->price, 2, ',', '.');
    }

    public function getRealtyimagesAttribute()
    {
        foreach ($this->images as $image) {
            return '<img src="'.$image->getThumb(110, 30, ['mode' => 'crop']).'" alt="" />';
        }
    }

    public function getSrcimageAttribute($value, $w = 250, $h = 250)
    {
        foreach ($this->images as $image) {
            return $image->getThumb($w, $h, ['mode' => 'crop']);
        }
    }

    public function getStatusOptions()
    {
        return [
            'rent' => 'awebsome.realestate::lang.realty.rent',
            'sale' => 'awebsome.realestate::lang.realty.sale',
            'sold' => 'awebsome.realestate::lang.realty.sold'
        ];
    }

    ############################################################################################################
    # SET ATTRIBUTE
    ############################################################################################################

    public function setUrl($pageName, $controller)
    {
        $params = [
            'id' => $this->id,
            'slug' => $this->slug,
        ];

        $params['category'] = null;

        return $this->url = $controller->pageUrl($pageName, $params);
    }


    ############################################################################################################
    # SCOPE
    ############################################################################################################

    public function scopeIsPublished($query)
    {
        return $query
            ->where('published', '=', 1)
            ->where('created_at', '<', Carbon::now());
    }

    public function scopeListFrontEnd($query, $options)
    {
        /*
         * Default options
         */
        extract(array_merge([
            'page'          => 1,
            'perPage'       => 30,
            'sort'          => 'created_at',
            'order'         => 'desc',
            'category'      => null,
            'status'        => null,
            'tags'          => null,
            'price'         => null,
            'address'       => null
        ], $options));

        if($perPage > 100){
            $perPage = (
                intval(Settings::instance()->maxPerPage) ?
                    intval(Settings::instance()->maxPerPage) : 100
            );
        }

        $query->isPublished();

        if(!empty($tags)){
            if(!is_array($tags)){
                if(strpos($tags, ",") !== false)
                {
                    $tags   = array_map("trim", explode(',', $tags));
                }
                else
                {
                    $tags = [$tags];
                }
            }
            $query->whereHas('tags', function($q) use ($tags) {
                $q->search($tags);
            });
        }

        if (!empty($address)) {
            $query->where('address', 'like', '%'.$address.'%');
        }

        if(!empty($category)){
            $query->where("category_id", "=", $category);
        }

        if(!empty($status) || is_numeric($status)){
            $query->where("status", "=", $status);
        }

        if(!empty($price)){
            if(is_array($price) && count($price) == 2){
                $query->whereBetween('price', [min($price), max($price)]);
            }else{
                $query->where("price", ">=", floatval($price));
            }
        }

        if(!in_array($sort, self::$allowedSortingOptions)){
            $sort = 'created_at';
        }

        if($order != 'desc'){
            $order = 'asc';
        }

        $query->orderBy($sort, $order);

        //$sql = $query->toSql();
        //foreach($query->getBindings() as $binding)
        //{
        //    $value = is_numeric($binding) ? $binding : "'".$binding."'";
        //    $sql = preg_replace('/\?/', $value, $sql, 1);
        //}
        //throw new \October\Rain\Exception\ApplicationException($sql);

        return $query->paginate($perPage, $page);
    }

    public function afterDelete()
    {
        $this->messages()->delete();
    }

}
