<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rest extends Model
{
    use HasFactory;
    protected $fillable = [
        'stamp_id',
        'rest_start',
        'rest_end',
    ];

    public function stamp(){

        return $this->belongsTo(Stamp::class);
    }
}
