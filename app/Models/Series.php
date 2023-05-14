<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Series extends Model
{
    use HasFactory;
    protected $fillable = ['title', 'slug', 'score', 'type', 'synopsis'];
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
}
