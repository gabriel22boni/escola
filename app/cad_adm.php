<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class cad_adm extends Model{
    public function insertAdm($data){
        $pass = $data['password'];
        $id = $this->max('id');
        
        if(!$id){
            $id=3;
        }else{
            $id=++$id;
        }
        
        if($data['pessoa']=='J'){
            $fnome=$data['fnome'];
            $razsoc=$data['razsoc'];
            $cnpj=$data['cnpj'];
            $nome=null;
            $cpf=null;
        }else{
            $fnome=null;
            $razsoc=null;
            $cnpj=null;
            $nome=$data['nome'];
            $cpf=$data['cpf'];
        }
        $InsertData = [   
            'idmaster'=>$data['idmaster'], 
            'email'=>$data['email'],
            'pessoa'=>$data['pessoa'],
            'endereco'=>$data['endereco'],
            'numero'=>$data['numero'],
            'bairro'=>$data['bairro'],
            'cel'=>$data['cel'],
            'fone'=>$data['fone'],
            'cep'=>$data['cep'],
            'cidade'=>$data['cidade'],
            'image'=>$data['image'],
            'estado'=>$data['estado'],
            'password'=>bcrypt($data['password']),
            'status'=>'A',
            'id'=>$id,
            'fnome'=>$fnome,
            'razsoc'=>$razsoc,
            'cnpj'=>$cnpj,
            'nome'=>$nome,
            'cpf'=>$cpf,
        ];

        $this->insert($InsertData);
        return $InsertData;
    }

    public function searchSelect(){
        if(auth()->user()->nivel =="CEO"){
                return $this
                ->select('cad_adms.*')
                ->where('cad_adms.status', '=',"A")
                ->where('cad_admasters.status', '=',"A")
                ->where('cad_ceos.status', '=',"A")
                ->where('cad_ceos.id', '=',auth()->user()->idceo)
                ->leftJoin('cad_admasters', 'cad_adms.idmaster', '=', 'cad_admasters.id')
                ->leftJoin('cad_ceos','cad_admasters.idceo', '=', 'cad_ceos.id')
                ->get();
        }else{
                return $this
                ->select('cad_adms.*')
                ->where('cad_adms.status', '=',"A")
                ->where('cad_admasters.status', '=',"A")
                ->where('cad_adms.idmaster', '=',auth()->user()->idmas)
                ->leftJoin('cad_admasters', 'cad_adms.idmaster', '=', 'cad_admasters.id')
                ->get();
        }
        
    }

    public function search($totalPage, $data = null){
        if(auth()->user()->nivel =="CEO"){
            if(isset($data["data"]) && $data["data"]!=null){
                return $this
                ->select('cad_adms.*')
                ->where('cad_adms.status', '=',"A")
                ->where('cad_admasters.status', '=',"A")
                ->where('cad_ceos.status', '=',"A")
                ->where('cad_ceos.id', '=',auth()->user()->idceo)
                ->leftJoin('cad_admasters', 'cad_adms.idmaster', '=', 'cad_admasters.id')
                ->leftJoin('cad_ceos','cad_admasters.idceo', '=', 'cad_ceos.id')
                ->where(function($query)use($data) {
                    $query
                        ->where('cad_adms.nome', 'like', '%'.$data["data"]."%")
                        ->orWhere('cad_adms.fnome', 'like', '%'.$data["data"]."%")
                        ->orWhere('cad_adms.razsoc', 'like', '%'.$data["data"]."%");
                })
                ->paginate($totalPage);
            }else{
                return $this
                ->select('cad_adms.*')
                ->where('cad_adms.status', '=',"A")
                ->where('cad_admasters.status', '=',"A")
                ->where('cad_ceos.status', '=',"A")
                ->where('cad_ceos.id', '=',auth()->user()->idceo)
                ->leftJoin('cad_admasters', 'cad_adms.idmaster', '=', 'cad_admasters.id')
                ->leftJoin('cad_ceos','cad_admasters.idceo', '=', 'cad_ceos.id')
                ->paginate($totalPage);
            }
        }else{
            if(isset($data["data"]) && $data["data"]!=null){
                return $this
                ->select('cad_adms.*')
                ->where('cad_adms.status', '=',"A")
                ->where('cad_admasters.status', '=',"A")
                ->where('cad_adms.idmaster', '=',auth()->user()->idmas)
                ->leftJoin('cad_admasters', 'cad_adms.idmaster', '=', 'cad_admasters.id')
                ->where(function($query)use($data) {
                    $query
                        ->where('cad_adms.nome', 'like', '%'.$data["data"]."%")
                        ->orWhere('cad_adms.fnome', 'like', '%'.$data["data"]."%")
                        ->orWhere('cad_adms.razsoc', 'like', '%'.$data["data"]."%");
                })
                ->paginate($totalPage);
            }else{
                return $this
                ->select('cad_adms.*')
                ->where('cad_adms.status', '=',"A")
                ->where('cad_admasters.status', '=',"A")
                ->where('cad_adms.idmaster', '=',auth()->user()->idmas)
                ->leftJoin('cad_admasters', 'cad_adms.idmaster', '=', 'cad_admasters.id')
                ->paginate($totalPage);
            }
        }
        
    }

    public function porId($id){
        return $this
                    ->select([
                        'cad_adms.bairro',
                        'cad_adms.cel',
                        'cad_adms.cep',
                        'cities.name as cidade',
                        'cad_adms.cnpj',
                        'cad_adms.cpf',
                        'cad_adms.email',
                        'cad_adms.endereco',
                        'states.name as estado',
                        'cad_adms.fnome',
                        'cad_adms.fone',
                        'cad_admasters.nome as nomeadmaster',
                        'cad_admasters.fnome as fnomeadmaster',
                        'cad_adms.nome',
                        'cad_adms.numero',
                        'cad_adms.pessoa',
                        'cad_adms.razsoc',
                        'cad_adms.image',
                    ])
                    ->where('cad_adms.id','=',$id)
                    ->leftjoin('cities','cad_adms.cidade','=','cities.id')
                    ->join('states','cad_adms.estado', '=', 'states.id')
                    ->join('cad_admasters','cad_adms.idmaster','=','cad_admasters.id')
                    ->get();
    }
    
    public function deleteAdm($id){
        return $this
                ->where('cad_adms.id','=',$id)
                ->update(['status' => 'I']);
    }

    public function updateReg($data){
        $id = $data['id'];
        unset($data['id']);
        
            $this
                ->where('id', $id)
                ->update($data);
    }
}