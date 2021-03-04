<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class cad_cob extends Model
{
    public function insertCob($data){
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
            'idadm'=>$data['idadm'], 
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

    public function search($totalPage, $data = null){
        if(auth()->user()->nivel =='CEO'){
            if(isset($data["data"]) && $data["data"]!=null){
                return $this
                ->select('cad_cobs.*')
                ->where('cad_cobs.status', '=',"A")
                ->where('cad_adms.status', '=',"A")
                ->where('cad_admasters.status', '=',"A")
                ->where('cad_ceos.status', '=',"A")
                ->where('cad_ceos.id', '=',auth()->user()->idceo)
                ->leftJoin('cad_adms', 'cad_cobs.idadm','=','cad_adms.id')
                ->leftJoin('cad_admasters','cad_adms.idmaster','=','cad_admasters.id')
                ->leftJoin('cad_ceos','cad_admasters.idceo','=','cad_ceos.id')
                ->where(function($query)use($data) {
                    $query
                        ->where('cad_cobs.nome', 'like', '%'.$data["data"]."%")
                        ->orWhere('cad_cobs.fnome', 'like', '%'.$data["data"]."%")
                        ->orWhere('cad_cobs.razsoc', 'like', '%'.$data["data"]."%");
                })
                ->paginate($totalPage);
            }else{
                return $this
                ->select('cad_cobs.*')
                ->where('cad_cobs.status', '=',"A")
                ->where('cad_adms.status', '=',"A")
                ->where('cad_admasters.status', '=',"A")
                ->where('cad_ceos.status', '=',"A")
                ->where('cad_ceos.id', '=',auth()->user()->idceo)
                ->leftJoin('cad_adms', 'cad_cobs.idadm','=','cad_adms.id')
                ->leftJoin('cad_admasters','cad_adms.idmaster','=','cad_admasters.id')
                ->leftJoin('cad_ceos','cad_admasters.idceo','=','cad_ceos.id')
                ->paginate($totalPage);
            }
        }else{
            if(auth()->user()->nivel =='MAS'){
                if(isset($data["data"]) && $data["data"]!=null){
                    return $this
                    ->select('cad_cobs.*')
                    ->where('cad_cobs.status', '=',"A")
                    ->where('cad_adms.status', '=',"A")
                    ->where('cad_admasters.status', '=',"A")
                    ->where('cad_admasters.id', '=',auth()->user()->idmas)
                    ->leftJoin('cad_adms', 'cad_cobs.idadm','=','cad_adms.id')
                    ->leftJoin('cad_admasters','cad_adms.idmaster','=','cad_admasters.id')
                    ->where(function($query)use($data) {
                        $query
                            ->where('cad_cobs.nome', 'like', '%'.$data["data"]."%")
                            ->orWhere('cad_cobs.fnome', 'like', '%'.$data["data"]."%")
                            ->orWhere('cad_cobs.razsoc', 'like', '%'.$data["data"]."%");
                    })
                    ->paginate($totalPage);
                }else{
                    return $this
                    ->select('cad_cobs.*')
                    ->where('cad_cobs.status', '=',"A")
                    ->where('cad_adms.status', '=',"A")
                    ->where('cad_admasters.status', '=',"A")
                    ->where('cad_admasters.id', '=',auth()->user()->idmas)
                    ->leftJoin('cad_adms', 'cad_cobs.idadm','=','cad_adms.id')
                    ->leftJoin('cad_admasters','cad_adms.idmaster','=','cad_admasters.id')
                    ->paginate($totalPage);
                }
            }else{
                if(isset($data["data"]) && $data["data"]!=null){
                    return $this
                    ->select('cad_cobs.*')
                    ->where('cad_cobs.status', '=',"A")
                    ->where('cad_adms.status', '=',"A")
                    ->where('cad_adms.id', '=',auth()->user()->idadm)
                    ->leftJoin('cad_adms', 'cad_cobs.idadm','=','cad_adms.id')
                    ->where(function($query)use($data) {
                        $query
                            ->where('cad_cobs.nome', 'like', '%'.$data["data"]."%")
                            ->orWhere('cad_cobs.fnome', 'like', '%'.$data["data"]."%")
                            ->orWhere('cad_cobs.razsoc', 'like', '%'.$data["data"]."%");
                    })
                    ->paginate($totalPage);
                }else{
                    return $this
                    ->select('cad_cobs.*')
                    ->where('cad_cobs.status', '=',"A")
                    ->where('cad_adms.status', '=',"A")
                    ->where('cad_adms.id', '=',auth()->user()->idadm)
                    ->leftJoin('cad_adms', 'cad_cobs.idadm','=','cad_adms.id')
                    ->paginate($totalPage);
                }
            }
        }
    }

    public function searchSelect(){
        if(auth()->user()->nivel =='CEO'){
            return $this
            ->select('cad_cobs.*')
            ->where('cad_cobs.status', '=',"A")
            ->where('cad_adms.status', '=',"A")
            ->where('cad_admasters.status', '=',"A")
            ->where('cad_ceos.status', '=',"A")
            ->where('cad_ceos.id', '=',auth()->user()->idceo)
            ->leftJoin('cad_adms', 'cad_cobs.idadm','=','cad_adms.id')
            ->leftJoin('cad_admasters','cad_adms.idmaster','=','cad_admasters.id')
            ->leftJoin('cad_ceos','cad_admasters.idceo','=','cad_ceos.id')
            ->get();
        }else{
            if(auth()->user()->nivel =='MAS'){
                return $this
                ->select('cad_cobs.*')
                ->where('cad_cobs.status', '=',"A")
                ->where('cad_adms.status', '=',"A")
                ->where('cad_admasters.status', '=',"A")
                ->where('cad_admasters.id', '=',auth()->user()->idmas)
                ->leftJoin('cad_adms', 'cad_cobs.idadm','=','cad_adms.id')
                ->leftJoin('cad_admasters','cad_adms.idmaster','=','cad_admasters.id')
                ->get();
            }else{
                    return $this
                    ->select('cad_cobs.*')
                    ->where('cad_cobs.status', '=',"A")
                    ->where('cad_adms.status', '=',"A")
                    ->where('cad_adms.id', '=',auth()->user()->idadm)
                    ->leftJoin('cad_adms', 'cad_cobs.idadm','=','cad_adms.id')
                    ->get();
            }
        }
    }

    public function porId($id){
        return $this
                    ->select([
                        'cad_cobs.bairro',
                        'cad_cobs.cel',
                        'cad_cobs.cep',
                        'cities.name as cidade',
                        'cad_cobs.cnpj',
                        'cad_cobs.cpf',
                        'cad_cobs.email',
                        'cad_cobs.endereco',
                        'states.name as estado',
                        'cad_cobs.fnome',
                        'cad_cobs.fone',
                        'cad_admasters.nome as nomeadm',
                        'cad_admasters.fnome as fnomeadm',
                        'cad_cobs.nome',
                        'cad_cobs.numero',
                        'cad_cobs.pessoa',
                        'cad_cobs.razsoc',
                        'cad_cobs.image',

                    ])
                    ->where('cad_cobs.id','=',$id)
                    ->leftjoin('cities','cad_cobs.cidade','=','cities.id')
                    ->join('states','cad_cobs.estado', '=', 'states.id')
                    ->join('cad_admasters','cad_cobs.idadm','=','cad_admasters.id')
                    ->get();
    }
    
    public function deleteCob($id){
        return $this
                ->where('cad_cobs.id','=',$id)
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
