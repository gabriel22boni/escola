<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class pesquisa extends Model
{
    public function qtde($data){
        $id = $data['retorno'][0]['id'];
        $qtde = ($this
            ->select('qtdeResps')
            ->where('id',$id)
            ->get())[0]['qtdeResps'];
        $qtde++;
        $this
            ->where('id',$id)
            ->update(['qtdeResps'=>$qtde]);
    }

    public function search($totalPage, $data = null){
        if(auth()->user()->nivel =="CEO"){
            if(isset($data["data"]) && $data["data"]!=null){
                return $this
                ->select('pesquisas.*')
                ->where('pesquisas.status', '=',"A")
                ->where('cad_admasters.status', '=',"A")
                ->where('cad_ceos.status', '=',"A")
                ->where('cad_ceos.id', '=',auth()->user()->idceo)
                ->leftJoin('cad_admasters', 'pesquisas.id_escola', '=', 'cad_admasters.id')
                ->leftJoin('cad_ceos','cad_admasters.idceo', '=', 'cad_ceos.id')
                ->where('pesquisas.nome', 'like', '%'.$data["data"]."%")
                ->paginate($totalPage);
            }else{
                return $this
                ->select('pesquisas.*')
                ->where('pesquisas.status', '=',"A")
                ->where('cad_admasters.status', '=',"A")
                ->where('cad_ceos.status', '=',"A")
                ->where('cad_ceos.id', '=',auth()->user()->idceo)
                ->leftJoin('cad_admasters', 'pesquisas.id_escola', '=', 'cad_admasters.id')
                ->leftJoin('cad_ceos','cad_admasters.idceo', '=', 'cad_ceos.id')
                ->paginate($totalPage);
            }
        }else{
            if(isset($data["data"]) && $data["data"]!=null){
                return $this
                ->select('pesquisas.*')
                ->where('pesquisas.status', '=',"A")
                ->where('cad_admasters.status', '=',"A")
                ->where('pesquisas.id_escola', '=',auth()->user()->idmas)
                ->leftJoin('cad_admasters', 'pesquisas.id_escola', '=', 'cad_admasters.id')
                ->where('pesquisas.nome', 'like', '%'.$data["data"]."%")
                ->paginate($totalPage);
            }else{
                return $this
                ->select('pesquisas.*')
                ->where('pesquisas.status', '=',"A")
                ->where('cad_admasters.status', '=',"A")
                ->where('pesquisas.id_escola', '=',auth()->user()->idmas)
                ->leftJoin('cad_admasters', 'pesquisas.id_escola', '=', 'cad_admasters.id')
                ->paginate($totalPage);
            }
        }
        
    }

    public function insertPesq($data){
        $id = $this->max('id');
        
        if(!$id){
            $id=3;
        }else{
            $id=++$id;
        }
        
        $nome=$data['nome'];

        $InsertData = [   
            'id_escola'=>$data['idmaster'], 
            'url'=>$data['url'], 
            'status'=>'A',
            'id'=>$id,
            'qtdeQuest'=>0,
            'nome'=>$nome,
        ];

        $this->insert($InsertData);
        return $InsertData;
    }

    public function porId($id){
        return $this
                    ->select([
                        'pesquisas.url',
                        'pesquisas.nome',
                        'pesquisas.qtdeResps',
                        'cad_admasters.nome as nomeadmaster',
                        'cad_admasters.fnome as fnomeadmaster',
                    ])
                    ->where('pesquisas.id','=',$id)
                    ->leftJoin('cad_admasters','pesquisas.id_escola','=','cad_admasters.id')
                    ->get();
    }

    public function deleteMat($id){
        return $this
                ->where('pesquisas.id','=',$id)
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

    public function porPesquisa($nomePesq){
        return $this
                ->select('pesquisas.*')
                ->where('pesquisas.status','A')
                ->where('pesquisas.url',$nomePesq)
                ->leftJoin('cad_admasters','pesquisas.id_escola','=','cad_admasters.id' )
                ->get();
    }

    public function addQuest($id){
        $qdeQuest = $this
                    ->select('qtdeQuest')
                    ->where('id',$id)
                    ->get();
        $qdeQuest = $qdeQuest[0]['qtdeQuest'];
        $qdeQuest++;
        $this 
            ->where('id',$id)
            ->update(['qtdeQuest' => $qdeQuest]);
            
        return $qdeQuest;
        
    }

    public function delQuest($id){
        $qdeQuest = $this
                    ->select('qtdeQuest')
                    ->where('id',$id)
                    ->get();
        
                    $qdeQuest = $qdeQuest[0]['qtdeQuest'];
        $qdeQuest--;
        $this 
            ->where('id',$id)
            ->update(['qtdeQuest' => $qdeQuest]);
    }
}