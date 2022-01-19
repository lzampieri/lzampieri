<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attachment extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'filename'
    ];

    public function section() {
        return $this->belongsTo( Section::class );
    }
}
