<?php


namespace App\Models;

/**
* Extend eloquent model class
* read more https://laravel.com/docs/5.1/eloquent
*/
use Illuminate\Database\Eloquent\Model;

/**
* To enable CakePHP's ORM, uncomment the line below
* Read more => https://book.cakephp.org/3.0/en/orm.html
*/

//use Cake\ORM\TableRegistry;


class Province extends Model
{
    
    //optional: define database table name if different from 'provinces'
    protected $table = 'provinces';
    public $timestamps = false;
    
    protected $fillable = [
        'id',
        'country_id',
        'code',
        'name',
    ];

    //every province has many users
    public function users()
    {
        return $this->hasMany('App\Models\User');
    }
}
