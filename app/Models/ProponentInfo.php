<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProponentInfo extends Model
{
    use HasFactory;

    protected $table = 'proponent_info';
    protected $guarded = array();

    public function facility() {
        return $this->belongsTo(Facility::class, 'facility_id','id');
    }
}