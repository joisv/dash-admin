<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Resolutions extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    public function series() {
        return $this ->belongsTo(Series::class);
    }
    
    public function episodes() {
        return $this ->belongsTo(Episodes::class);
    }
}
