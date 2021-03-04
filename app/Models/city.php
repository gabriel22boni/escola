<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class city extends Model
{
    protected $table="cities";

    public function name($idnome)
    {
        $nomes=['0'=>'Vazio'];
        $cities = $this->all();
        foreach($cities as $city)
        {
            array_push($nomes, $city->name);
        }
        return $nomes[$idnome];
    }

    public function porState($stateId)
    {
        $citylist=array();
        $cities = $this->all();
        foreach($cities as $city)
        {
            if($city->state_id == $stateId)
            {
                $cityList[] = $city;
            }          
        }
        return $cityList;
    }
}
