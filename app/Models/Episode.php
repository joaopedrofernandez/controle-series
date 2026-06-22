<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;

class Episode extends Model
{
    protected $table = 'episodes';
    public $timestamps = false;
    protected $fillable = ['number'];
    // protected $casts = ['watched' => 'boolean'];

    public function season()
    {
        return $this->belongsTo(Season::class);
    }

    // A exibição de watched e interpretada como bool
    // n ideal usar esta função para este caso
    //Eloquent: Mutators & Casting
    // link: https://laravel.com/docs/13.x/eloquent-mutators#attribute-casting
    protected function watched(): Attribute
    {
        return new Attribute(
            get: function ($watched) {
                return (bool)$watched;
            }
        );
    }

    public function scopeWatched(Builder $query)
    {
        $query->whereWatched(true);
    }
}