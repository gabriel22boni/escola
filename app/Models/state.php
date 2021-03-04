<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class state extends Model
{
    public function sigla($idstate)
    {
        $siglas=['0'=>'Vazio'];
        $states = $this->all();
        foreach($states as $state)
        {
            array_push($siglas, $state->abbreviation);
        }
        return $siglas[$idstate];
    }
}
