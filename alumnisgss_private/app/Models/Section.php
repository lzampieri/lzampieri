<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Section extends Model
{
    use HasFactory, SoftDeletes;

    protected $primaryKey = 'shortname';
    public $incrementing = false;


    public function attachments() {
        return $this->hasMany( Attachment::class );
    }
}
