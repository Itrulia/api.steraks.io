<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Summoner extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'followers';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'summonerId',
        'region'
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = [];

    /**
     * The attributes included in the model's JSON form.
     *
     * @var array
     */
    protected $visible = [
        'summonerId',
        'region',
        'user_id',
        'created_at'
    ];

    /**
     * The relations to eager load on every query.
     *
     * @var array
     */
    protected $with = [];
}
