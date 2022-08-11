<?php

namespace Msucevan\Swapi\Models;

use Illuminate\Database\Eloquent\Model;

class Planet extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'planets';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'swapi_id',
        'name',
        'rotation_period',
        'orbital_period',
        'diameter',
        'climate',
        'gravity',
        'terrain',
        'surface_water',
        'population',
        'url',
    ];

    public function people(){
        return $this->hasMany(People::class);
    }
}
