<?php
namespace ComradesYodieProxy\Models;
use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    /**
     * Define the primarykey as 'key'
     *
     * @var string
     */
     public $primarykey = 'key';

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'settings';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['key', 'values'];
    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = ['id'];
    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'values' => 'json'
    ];
}
