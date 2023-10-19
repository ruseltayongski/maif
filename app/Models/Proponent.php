<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Proponent extends Model
{
    use HasFactory;

    protected $table = 'proponent';
    protected $guarded = array();

    public function fundsource()
    {
        return $this->hasOne(Fundsource::class,'id','fundsource_id');
    }
}
