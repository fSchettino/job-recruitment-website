<?php


namespace App\Models;

/**
* Extend eloquent model class
* read more https://laravel.com/docs/5.1/eloquent
*/
use Illuminate\Database\Eloquent\Model;

/**
* To enable CakePHP's ORM, uncomment the line below
* Read more => https://search.cakephp.org/3.0/en/orm.html
*/

//use Cake\ORM\TableRegistry;


class Search extends Model
{
    
    //optional: define database table name if different from 'searchs'
    protected $table = 'searches';
    
    protected $fillable = [
        'id',
        'title',
        'user_ip',
        'user_id',
    ];

    /**
    * Every search belongs to a user.
    * That is,  searchs table has a user_id column which refers to the id of the user
    * So let's define the relationship below
    */
    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }
}
