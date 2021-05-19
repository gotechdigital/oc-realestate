<?php namespace Awebsome\Realestate\Models;

use Model;

/**
 * Message Model
 */
class Message extends Model
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
    public $table = 'awebsome_realestate_messages';

    /**
    * @var array
    */
    protected $guarded = ['id'];
   
    /**
    * @var array
    */
    public $rules = [];

    /**
    * @var array
    */
    public $translatable = ['message']; 

    ############################################################################################################
    # PERMISSIONS
    ############################################################################################################

    public function canEdit(User $user)
    {
        return ($this->user_id == $user->id) || $user->hasAnyAccess(['awebsome.realestate.access.realty']);
    }

    public $belongsTo = [
        'realty' => [ 'Awebsome\Realestate\Models\Realty', 'key' => 'realty_id', 'otherKey' => 'id' ]
    ];
}
