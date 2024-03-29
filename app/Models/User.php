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


class User extends Model
{
    
    //optional: define table name if different from 'users'
    protected $table = 'users';
    
    protected $fillable = [
        'id',
        'first_name',
        'last_name',
        'email',
        'password',
        'phone',
        'gender',
    ];
    
    public function setPassword($password)
    {
        $this->update([
            'password' => password_hash($password, PASSWORD_DEFAULT),
        ]);
    }
    //every user belongs to a role
    public function role()
    {
        return $this->belongsTo('App\Models\Role');
    }
    
    //every user belongs to a country
    public function country()
    {
        return $this->belongsTo('App\Models\Country');
    }

    //every user belongs to a province
    public function province()
    {
        return $this->belongsTo('App\Models\Province');
    }

    //every user belongs to many skills
    public function skills()
    {
        return $this->belongsToMany('App\Models\Skill')->withPivot('description', 'url')->withTimestamps();
        // return $this->belongsToMany('App\Models\Skill');
    }
}
