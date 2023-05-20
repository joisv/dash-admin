<?php

namespace App\Models;

use App\Models\Genres;
use App\Models\Episodes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Series extends Model
{
    use HasFactory;
    protected $guarded = ['id'];
    public function setSlugAttribute($value)
    {
        $slug = Str::slug($value);
        $originalSlug = $slug;
        $count = 2;
        
        while ($this->where('slug', $slug)->exists()) {
            $slug = $originalSlug . '-' . $count;
            $count++;
        }
        
        $this->attributes['slug'] = $slug;
    }

    public function genres()
    {
        return $this->belongsToMany(Genres::class, 'series_genres');
    }

    public function episodes()
    {
        return $this->hasMany(Episodes::class);
    }

    public function resolutions() {
        return $this->hasMany(Resolutions::class);
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }
}

