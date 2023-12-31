<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Fundsource extends Model
{
    use HasFactory;

    protected $table = 'fundsource';
    protected $guarded = array();

    public function facility() {   
        return $this->belongsTo(Facility::class, 'facility_id','id');
    }

    
    public function proponents() {   
        return $this->hasMany(Proponent::class);
    }

    public function encoded_by() {       
        return $this->belongsTo(User::class, 'created_by','id');
    }

    public function utilization() {   
        return $this->hasMany(Utilization::class, 'fundsource_id', 'id');
    }
    public function dv(){
        return $this->hasmany(Dv::class, 'fundsource_id', 'id');
    }
}
