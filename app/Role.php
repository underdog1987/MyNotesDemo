<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    
    /*
     * Relacion de Rol / Usuario
     */
    public function users(){
        return $this->belongsToMany("App\User")->withTimeStamps();
    }
}
