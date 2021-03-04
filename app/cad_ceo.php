<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class cad_ceo extends Model
{
    public function insertCeo($data){
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
            'idceo'=>$data['idceo'],
            'email'=>$data['email'],
            'pessoa'=>$data['pessoa'],
            'endereco'=>$data['endereco'],
            'numero'=>$data['numero'],
            'bairro'=>$data['bairro'],
            'cel'=>$data['cel'],
            'image'=>$data['image'],
            'fone'=>$data['fone'],
            'cep'=>$data['cep'],
            'cidade'=>$data['cidade'],
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

    public function searchSelect($totalPage, $data = null){
            return $this
            ->where('status', '=',"A")
            ->where('idceo', '=',auth()->user()->idceo)
            ->get();
    }

    public function search($totalPage, $data = null){
        if(isset($data["data"]) && $data["data"]!=null){
            return $this
            ->where('status', '=',"A")
            ->where('idceo', '=',auth()->user()->idceo)
            ->where(function($query)use($data) {
                $query
                    ->where('nome', 'like', '%'.$data["data"]."%")
                    ->orWhere('fnome', 'like', '%'.$data["data"]."%")
                    ->orWhere('razsoc', 'like', '%'.$data["data"]."%");
            })
            ->paginate($totalPage);
        }else{
            return $this
            ->where('status', '=',"A")
            ->where('idceo', '=',auth()->user()->idceo)
            ->paginate($totalPage);
        }
    }

    public function porId($id){
        return $this
                    ->select([
                        'cad_ceos.bairro',
                        'cad_ceos.cel',
                        'cad_ceos.cep',
                        'cities.name as cidade',
                        'cad_ceos.cnpj',
                        'cad_ceos.cpf',
                        'cad_ceos.email',
                        'cad_ceos.endereco',
                        'states.name as estado',
                        'cad_ceos.fnome',
                        'cad_ceos.fone',
                        'cad_ceos.nome',
                        'cad_ceos.numero',
                        'cad_ceos.pessoa',
                        'cad_ceos.razsoc',
                        'cad_ceos.image',
                    ])
                    ->where('cad_ceos.id','=',$id)
                    ->leftjoin('cities','cad_ceos.cidade','=','cities.id')
                    ->join('states','cad_ceos.estado', '=', 'states.id')
                    ->get();
    }
    
    public function deleteCeo($id){
        return $this
                ->where('cad_ceos.id','=',$id)
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
