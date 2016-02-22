<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Match
 *
 * @property integer $matchId
 * @property integer $timestamp
 * @property integer $winner
 * @property string $season
 * @property string $region
 * @property string $version
 * @property mixed $data
 */
class Match extends Model
{
    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'matches';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'matchId',
        'timestamp',
        'winner',
        'season',
        'version',
        'data',
        'region'
    ];

    /**
     * The attributes included in the model's JSON form.
     *
     * @var array
     */
    protected $visible = [
        'matchId',
        'timestamp',
        'winner',
        'season',
        'version',
        'data',
        'region'
    ];

    public function toArray() {
        return json_decode($this->data);
    }
}
