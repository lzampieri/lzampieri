<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Section extends Model
{
    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'shortname',
        'title',
        'content'
    ];

    protected $primaryKey = 'shortname';
    public $incrementing = false; // Preventing cast of shortname to integer
    protected $keyType = 'string'; // Preventing cast of shortname to integer
}
