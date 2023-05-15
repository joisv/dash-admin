<?php

namespace App\Models;

;
use App\Models\Series;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Genres extends Model
{
    use HasFactory;
    protected $guarded = ['id'];
    public function series()
    {
        return $this->belongsToMany(Series::class, 'series_genres');
    }
}
