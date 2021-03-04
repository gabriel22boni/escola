<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class cad_materia extends Model
{
    public function search($totalPage, $data = null){
        if(auth()->user()->nivel =="CEO"){
            if(isset($data["data"]) && $data["data"]!=null){
                return $this
                ->select('cad_materias.*')
                ->where('cad_materias.status', '=',"A")
                ->where('cad_admasters.status', '=',"A")
                ->where('cad_ceos.status', '=',"A")
                ->where('cad_ceos.id', '=',auth()->user()->idceo)
                ->leftJoin('cad_admasters', 'cad_materias.id_escola', '=', 'cad_admasters.id')
                ->leftJoin('cad_ceos','cad_admasters.idceo', '=', 'cad_ceos.id')
                ->where('cad_materias.nome', 'like', '%'.$data["data"]."%")
                ->paginate($totalPage);
            }else{
                return $this
                ->select('cad_materias.*')
                ->where('cad_materias.status', '=',"A")
                ->where('cad_admasters.status', '=',"A")
                ->where('cad_ceos.status', '=',"A")
                ->where('cad_ceos.id', '=',auth()->user()->idceo)
                ->leftJoin('cad_admasters', 'cad_materias.id_escola', '=', 'cad_admasters.id')
                ->leftJoin('cad_ceos','cad_admasters.idceo', '=', 'cad_ceos.id')
                ->paginate($totalPage);
            }
        }else{
            if(isset($data["data"]) && $data["data"]!=null){
                return $this
                ->select('cad_materias.*')
                ->where('cad_materias.status', '=',"A")
                ->where('cad_admasters.status', '=',"A")
                ->where('cad_materias.id_escola', '=',auth()->user()->idmas)
                ->leftJoin('cad_admasters', 'cad_materias.id_escola', '=', 'cad_admasters.id')
                ->where('cad_materias.nome', 'like', '%'.$data["data"]."%")
                ->paginate($totalPage);
            }else{
                return $this
                ->select('cad_materias.*')
                ->where('cad_materias.status', '=',"A")
                ->where('cad_admasters.status', '=',"A")
                ->where('cad_materias.id_escola', '=',auth()->user()->idmas)
                ->leftJoin('cad_admasters', 'cad_materias.id_escola', '=', 'cad_admasters.id')
                ->paginate($totalPage);
            }
        }
        
    }

    public function insertMat($data){
        $id = $this->max('id');
        
        if(!$id){
            $id=3;
        }else{
            $id=++$id;
        }
        
        $nome=$data['nome'];

        $InsertData = [   
            'id_escola'=>$data['idmaster'], 
            'status'=>'A',
            'id'=>$id,
            'nome'=>$nome,
        ];

        $this->insert($InsertData);
        return $InsertData;
    }

    public function porId($id){
        return $this
                    ->select([
                        'cad_materias.nome',
                        'cad_admasters.nome as nomeadmaster',
                        'cad_admasters.fnome as fnomeadmaster',
                    ])
                    ->where('cad_materias.id','=',$id)
                    ->leftJoin('cad_admasters','cad_materias.id_escola','=','cad_admasters.id')
                    ->get();
    }

    public function deleteMat($id){
        return $this
                ->where('cad_materias.id','=',$id)
                ->update(['status' => 'I']);
    }

    public function updateReg($data){
        $id = $data['id'];
        unset($data['id']);
        if(isset($data['idmaster'])){
            $data['id_escola'] = $data['idmaster'];
            unset($data['idmaster']);
        }
            $this
                ->where('id', $id)
                ->update($data);
    }
}
