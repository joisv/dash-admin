<?php

namespace App\Models;

;
use App\Models\Series;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Genres extends Model
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
    
    public function series()
    {
        return $this->belongsToMany(Series::class, 'series_genres');
    }
}
