<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class cad_cli extends Model
{
    public function insertCli($data){
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
            'idcob'=>$data['idcob'], 
            'email'=>$data['email'],
            'limite'=>$data['limite'],
            'pessoa'=>$data['pessoa'],
            'endereco'=>$data['endereco'],
            'numero'=>$data['numero'],
            'bairro'=>$data['bairro'],
            'cel'=>$data['cel'],
            'fone'=>$data['fone'],
            'cep'=>$data['cep'],
            'cidade'=>$data['cidade'],
            'estado'=>$data['estado'],
            'image'=>$data['image'],
            'password'=>bcrypt($data['password']),
            'saldo_dev'=>0,
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

    public function search($totalPage, $data=null){
        
        
        if(auth()->user()->nivel == "CEO"){
            if(isset($data['data']) && $data['data']!=null){
                return $this
                ->select('cad_clis.*')
                ->where('cad_clis.status', '=',"A")
                ->where('cad_cobs.status', '=',"A")
                ->where('cad_adms.status', '=',"A")
                ->where('cad_admasters.status', '=',"A")
                ->where('cad_ceos.status', '=',"A")
                ->where('cad_ceos.id', '=',auth()->user()->idceo)
                ->leftJoin('cad_cobs','cad_clis.idcob','=','cad_cobs.id')
                ->leftJoin('cad_adms', 'cad_cobs.idadm','=','cad_adms.id')
                ->leftJoin('cad_admasters','cad_adms.idmaster','=','cad_admasters.id')
                ->leftJoin('cad_ceos','cad_admasters.idceo','=','cad_ceos.id')
                ->where(function($query)use($data) {
                    $query
                            ->where('cad_clis.nome', 'like', '%'.$data["data"]."%")
                            ->orWhere('cad_clis.fnome', 'like', '%'.$data["data"]."%")
                            ->orWhere('cad_clis.razsoc', 'like', '%'.$data["data"]."%");
                })
                ->paginate($totalPage);
            }else{
                return $this
                ->select('cad_clis.*')
                ->where('cad_clis.status', '=',"A")
                ->where('cad_cobs.status', '=',"A")
                ->where('cad_adms.status', '=',"A")
                ->where('cad_admasters.status', '=',"A")
                ->where('cad_ceos.status', '=',"A")
                ->where('cad_ceos.id', '=',auth()->user()->idceo)
                ->leftJoin('cad_cobs','cad_clis.idcob','=','cad_cobs.id')
                ->leftJoin('cad_adms', 'cad_cobs.idadm','=','cad_adms.id')
                ->leftJoin('cad_admasters','cad_adms.idmaster','=','cad_admasters.id')
                ->leftJoin('cad_ceos','cad_admasters.idceo','=','cad_ceos.id')
                ->paginate($totalPage);
            }
        }else{
            if(auth()->user()->nivel == "MAS"){
                if(isset($data['data']) && $data['data']!=null){
                    return $this
                    ->select('cad_clis.*')
                    ->where('cad_clis.status', '=',"A")
                    ->where('cad_cobs.status', '=',"A")
                    ->where('cad_adms.status', '=',"A")
                    ->where('cad_admasters.status', '=',"A")
                    >where('cad_admasters.id', '=',auth()->user()->idmas)
                    ->leftJoin('cad_cobs','cad_clis.idcob','=','cad_cobs.id')
                    ->leftJoin('cad_adms', 'cad_cobs.idadm','=','cad_adms.id')
                    ->leftJoin('cad_admasters','cad_adms.idmaster','=','cad_admasters.id')
                    ->where(function($query)use($data) {
                        $query
                            ->where('cad_clis.nome', 'like', '%'.$data["data"]."%")
                            ->orWhere('cad_clis.fnome', 'like', '%'.$data["data"]."%")
                            ->orWhere('cad_clis.razsoc', 'like', '%'.$data["data"]."%");
                    })
                    ->paginate($totalPage);
                }else{
                    return $this
                    ->select('cad_clis.*')
                    ->where('cad_clis.status', '=',"A")
                    ->where('cad_cobs.status', '=',"A")
                    ->where('cad_adms.status', '=',"A")
                    ->where('cad_admasters.status', '=',"A")
                    ->where('cad_admasters.id', '=',auth()->user()->idmas)
                    ->leftJoin('cad_cobs','cad_clis.idcob','=','cad_cobs.id')
                    ->leftJoin('cad_adms', 'cad_cobs.idadm','=','cad_adms.id')
                    ->leftJoin('cad_admasters','cad_adms.idmaster','=','cad_admasters.id')
                    ->paginate($totalPage);
                }
            }else{
                if(auth()->user()->nivel == "ADM"){
                    if(isset($data['data']) && $data['data']!=null){
                        return $this
                        ->select('cad_clis.*')
                        ->where('cad_clis.status', '=',"A")
                        ->where('cad_cobs.status', '=',"A")
                        ->where('cad_adms.status', '=',"A")
                        ->where('cad_adms.id', '=',auth()->user()->idadm)
                        ->leftJoin('cad_cobs','cad_clis.idcob','=','cad_cobs.id')
                        ->leftJoin('cad_adms', 'cad_cobs.idadm','=','cad_adms.id')
                        ->where(function($query)use($data) {
                            $query
                                ->where('cad_clis.nome', 'like', '%'.$data["data"]."%")
                                ->orWhere('cad_clis.fnome', 'like', '%'.$data["data"]."%")
                                ->orWhere('cad_clis.razsoc', 'like', '%'.$data["data"]."%");
                        })
                        ->paginate($totalPage);
                    }else{
                        return $this
                        ->select('cad_clis.*')
                        ->where('cad_clis.status', '=',"A")
                        ->where('cad_cobs.status', '=',"A")
                        ->where('cad_adms.status', '=',"A")
                        ->where('cad_adms.id', '=',auth()->user()->idadm)
                        ->leftJoin('cad_cobs','cad_clis.idcob','=','cad_cobs.id')
                        ->leftJoin('cad_adms', 'cad_cobs.idadm','=','cad_adms.id')
                        ->paginate($totalPage);
                    }
                }else{
                    if(isset($data['data']) && $data['data']!=null){
                        return $this
                        ->select('cad_clis.*')
                        ->where('cad_clis.status', '=',"A")
                        ->where('cad_cobs.status', '=',"A")
                        ->where('cad_cobs.id', '=',auth()->user()->idcob)
                        ->leftJoin('cad_cobs','cad_clis.idcob','=','cad_cobs.id')
                        ->where(function($query)use($data) {
                            $query
                                ->where('cad_clis.nome', 'like', '%'.$data["data"]."%")
                                ->orWhere('cad_clis.fnome', 'like', '%'.$data["data"]."%")
                                ->orWhere('cad_clis.razsoc', 'like', '%'.$data["data"]."%");
                        })
                        ->paginate($totalPage);
                    }else{
                        return $this
                        ->select('cad_clis.*')
                        ->where('cad_clis.status', '=',"A")
                        ->where('cad_cobs.status', '=',"A")
                        ->where('cad_cobs.id', '=',auth()->user()->idcob)
                        ->leftJoin('cad_cobs','cad_clis.idcob','=','cad_cobs.id')
                        ->paginate($totalPage);
                    }
                }
            }
        }
    }

    public function porId($id){
        switch(true){
            case auth()->user()->nivel == "CEO":
                return $this->select([
                    'cad_clis.bairro',
                    'cad_clis.cel',
                    'cad_clis.cep',
                    'cities.name as cidade',
                    'cad_clis.cnpj',
                    'cad_clis.cpf',
                    'cad_clis.email',
                    'cad_clis.endereco',
                    'states.name as estado',
                    'cad_clis.fnome',
                    'cad_clis.fone',
                    'cad_cobs.nome as nomecob',
                    'cad_cobs.fnome as fnomecob',
                    'cad_clis.limite',
                    'cad_clis.nome',
                    'cad_clis.numero',
                    'cad_clis.pessoa',
                    'cad_clis.razsoc',
                    'cad_clis.image',
                ])
                ->where('cad_clis.id','=',$id)
                ->where('cad_clis.status', '=',"A")
                ->where('cad_cobs.status', '=',"A")
                ->where('cad_adms.status', '=',"A")
                ->where('cad_admasters.status', '=',"A")
                ->where('cad_ceos.status', '=',"A")
                ->where('cad_ceos.id', '=',auth()->user()->idceo)
                ->leftJoin('cities','cad_clis.cidade','=','cities.id')
                ->leftJoin('states','cad_clis.estado', '=', 'states.id')
                ->leftJoin('cad_cobs','cad_clis.idcob','=','cad_cobs.id')
                ->leftJoin('cad_adms', 'cad_cobs.idadm','=','cad_adms.id')
                ->leftJoin('cad_admasters','cad_adms.idmaster','=','cad_admasters.id')
                ->leftJoin('cad_ceos','cad_admasters.idceo','=','cad_ceos.id')
                ->get();
                break;
            case auth()->user()->nivel == "MAS":
                return $this->select([
                    'cad_clis.bairro',
                    'cad_clis.cel',
                    'cad_clis.cep',
                    'cities.name as cidade',
                    'cad_clis.cnpj',
                    'cad_clis.cpf',
                    'cad_clis.email',
                    'cad_clis.endereco',
                    'states.name as estado',
                    'cad_clis.fnome',
                    'cad_clis.fone',
                    'cad_cobs.nome as nomecob',
                    'cad_cobs.fnome as fnomecob',
                    'cad_clis.limite',
                    'cad_clis.nome',
                    'cad_clis.numero',
                    'cad_clis.pessoa',
                    'cad_clis.razsoc',
                    'cad_clis.image',
                ])
                ->where('cad_clis.id','=',$id)
                ->where('cad_clis.status', '=',"A")
                ->where('cad_cobs.status', '=',"A")
                ->where('cad_adms.status', '=',"A")
                ->where('cad_admasters.status', '=',"A")
                ->where('cad_admasters.id', '=',auth()->user()->idmas)
                ->leftJoin('cities','cad_clis.cidade','=','cities.id')
                ->leftJoin('states','cad_clis.estado', '=', 'states.id')
                ->leftJoin('cad_cobs','cad_clis.idcob','=','cad_cobs.id')
                ->leftJoin('cad_adms', 'cad_cobs.idadm','=','cad_adms.id')
                ->leftJoin('cad_admasters','cad_adms.idmaster','=','cad_admasters.id')
                ->get();
                break;
            case auth()->user()->nivel == "ADM":
                return $this->select([
                    'cad_clis.bairro',
                    'cad_clis.cel',
                    'cad_clis.cep',
                    'cities.name as cidade',
                    'cad_clis.cnpj',
                    'cad_clis.cpf',
                    'cad_clis.email',
                    'cad_clis.endereco',
                    'states.name as estado',
                    'cad_clis.fnome',
                    'cad_clis.fone',
                    'cad_cobs.nome as nomecob',
                    'cad_cobs.fnome as fnomecob',
                    'cad_clis.limite',
                    'cad_clis.nome',
                    'cad_clis.numero',
                    'cad_clis.pessoa',
                    'cad_clis.razsoc',
                    'cad_clis.image',
                ])
                ->where('cad_clis.id','=',$id)
                ->where('cad_clis.status', '=',"A")
                ->where('cad_cobs.status', '=',"A")
                ->where('cad_adms.status', '=',"A")
                ->where('cad_adms.id', '=',auth()->user()->idadm)
                ->leftJoin('cities','cad_clis.cidade','=','cities.id')
                ->leftJoin('states','cad_clis.estado', '=', 'states.id')
                ->leftJoin('cad_cobs','cad_clis.idcob','=','cad_cobs.id')
                ->leftJoin('cad_adms', 'cad_cobs.idadm','=','cad_adms.id')
                ->get();
                break;
            case auth()->user()->nivel == "COB":
                return $this->select([
                    'cad_clis.bairro',
                    'cad_clis.cel',
                    'cad_clis.cep',
                    'cities.name as cidade',
                    'cad_clis.cnpj',
                    'cad_clis.cpf',
                    'cad_clis.email',
                    'cad_clis.endereco',
                    'states.name as estado',
                    'cad_clis.fnome',
                    'cad_clis.fone',
                    'cad_cobs.nome as nomecob',
                    'cad_cobs.fnome as fnomecob',
                    'cad_clis.limite',
                    'cad_clis.nome',
                    'cad_clis.numero',
                    'cad_clis.pessoa',
                    'cad_clis.razsoc',
                    'cad_clis.image',
                ])
                ->where('cad_clis.id','=',$id)
                ->where('cad_clis.status', '=',"A")
                ->where('cad_cobs.status', '=',"A")
                ->where('cad_cobs.id', '=',auth()->user()->idcob)
                ->leftJoin('cities','cad_clis.cidade','=','cities.id')
                ->leftJoin('states','cad_clis.estado', '=', 'states.id')
                ->leftJoin('cad_cobs','cad_clis.idcob','=','cad_cobs.id')
                ->get();
                break;
        }
        
        
        
    }
    
    public function deleteCli($id){
        return $this
                ->where('cad_clis.id','=',$id)
                ->update(['status' => 'I']);
    }

    public function updateReg($data){
        $id = $data['id'];
        unset($data['id']);
        
            $this
                ->where('id', $id)
                ->update($data);
    }

    public function updateSaldo($id, $valor){
        $saldodevAtual = $this
                        ->where('id',$id)
                        ->select('saldo_dev')
                        ->get();
        
        $saldoDevNovo = $saldodevAtual[0]['saldo_dev']+$valor;
        $this
            ->where('id',$id)
            ->update([
                'saldo_dev'=>$saldoDevNovo,
            ]);
    }

    public function verSaldo($id){
        $saldoAtual = $this
                        ->where('id',$id)
                        ->select('saldo_dev','limite')
                        ->get();
        
        return ($saldoAtual[0]['limite']-$saldoAtual[0]['saldo_dev']);
        
    }

    public function baixaFatura($dataBaixa){
        
        $saldoDev = (
            $this
                ->select('cad_clis.saldo_dev')
                ->leftJoin('emprestimos','emprestimos.idcli','=','cad_clis.id')
                ->leftJoin('faturas','faturas.idEmprestimo','=','emprestimos.id')
                ->where('faturas.id',$dataBaixa['id'])
                ->get()
            )[0]['saldo_dev'];
            
        $saldoDevAtualizado = $saldoDev-$dataBaixa['valorBaixa'];
        
        $this
            ->leftJoin('emprestimos','emprestimos.idcli','=','cad_clis.id')
            ->leftJoin('faturas','faturas.idEmprestimo','=','emprestimos.id')
            ->where('faturas.id',$dataBaixa['id'])
            ->update(['cad_clis.saldo_dev' => $saldoDevAtualizado]);
    }
}
