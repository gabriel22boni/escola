<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class cad_admaster extends Model
{
    public function insertAdmaster($data){
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
            'fone'=>$data['fone'],
            'cep'=>$data['cep'],
            'image'=>$data['image'],
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

    public function searchSelect(){
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
                        'cad_admasters.bairro',
                        'cad_admasters.cel',
                        'cad_admasters.cep',
                        'cities.name as cidade',
                        'cad_admasters.cnpj',
                        'cad_admasters.cpf',
                        'cad_admasters.email',
                        'cad_admasters.endereco',
                        'states.name as estado',
                        'cad_admasters.fnome',
                        'cad_admasters.fone',
                        'cad_ceos.nome as nomeceo',
                        'cad_ceos.fnome as fnomeceo',
                        'cad_admasters.nome',
                        'cad_admasters.numero',
                        'cad_admasters.pessoa',
                        'cad_admasters.razsoc',
                        'cad_admasters.image',
                    ])
                    ->where('cad_admasters.id','=',$id)
                    ->leftjoin('cities','cad_admasters.cidade','=','cities.id')
                    ->join('states','cad_admasters.estado', '=', 'states.id')
                    ->join('cad_ceos','cad_admasters.idceo','=','cad_ceos.id')
                    ->get();
    }
    
    public function deleteAdmaster($id){
        return $this
                ->where('cad_admasters.id','=',$id)
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
