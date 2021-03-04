<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class quest extends Model
{
    public function insertQuest($data,$questNum){
        $id = $this->max('id');
        
        if(!$id){
            $id=3;
        }else{
            $id=++$id;
        }
        
        switch(true){
            case $data['tipo'] == 'EU':
                $InsertData = [   
                    'id'=>$id,
                    'questnum'=>$questNum,
                    'idpesq'=>$data['idPesq'],
                    'TIPO'=>$data['tipo'],
                    'enunciado'=>$data['enunciado'],
                    'qtdOps'=>$data['numOpts'],
                    'op_1'=>$data['op_1'],
                    'op_2'=>$data['op_2'],
                    'op_3'=>$data['op_3'],
                    'op_4'=>$data['op_4'],
                    'op_5'=>$data['op_5'],
                    'status'=>'A',
                ];
            break;
            case $data['tipo'] == 'ME':
                $InsertData = [   
                    'id'=>$id,
                    'questnum'=>$questNum,
                    'idpesq'=>$data['idPesq'],
                    'TIPO'=>$data['tipo'],
                    'enunciado'=>$data['enunciado'],
                    'qtdOps'=>$data['numOpts'],
                    'op_1'=>$data['op_1'],
                    'op_2'=>$data['op_2'],
                    'op_3'=>$data['op_3'],
                    'op_4'=>$data['op_4'],
                    'op_5'=>$data['op_5'],
                    'status'=>'A',
                ];
            break;
            case $data['tipo'] == 'SN':
                $InsertData = [   
                    'id'=>$id,
                    'questnum'=>$questNum,
                    'idpesq'=>$data['idPesq'],
                    'TIPO'=>$data['tipo'],
                    'enunciado'=>$data['enunciado'],
                    'op_1'=>'S',
                    'op_2'=>'N',
                    'status'=>'A',
                ];
            break;
            case $data['tipo'] == 'ZD':
                $InsertData = [   
                    'id'=>$id,
                    'questnum'=>$questNum,
                    'idpesq'=>$data['idPesq'],
                    'TIPO'=>$data['tipo'],
                    'enunciado'=>$data['enunciado'],
                    'status'=>'A',
                ];
            break;
            
        }

        $this->insert($InsertData);
    }

    public function porPesquisa($idPesq){
        return $this
                ->where('status','A')
                ->where('idpesq',$idPesq)
                ->get();
    }

    public function porQuest($data){
        return $this   
                ->where('idpesq',$data['id'])
                ->where('status','A')
                ->where('questnum',$data['questnum'])
                ->get();
    }

    public function QuestDel($data){
        $questsdel = $this
                ->where('idpesq',$data['id'])
                ->where('questnum', '=', $data['questnum'])
                ->update(['status'=>'I']);

        $quests = $this
        ->where('idpesq',$data['id'])
        ->where('questnum', '>', $data['questnum'])
        ->where('status','A')
        ->get();

        for($i=0;$i< count($quests);$i++ ){
        $newQuestNum = $data['questnum']+$i;
                $this
                ->where('idpesq',$data['id'])
                ->where('questnum',$quests[$i]['questnum'])
                ->update(['questnum' => $newQuestNum]);
        }
    }

    public function questUpdate($data){
        $id = $data['id'];
        unset($data['id']);

        $this
            ->where('id', $id)
            ->update($data);
        
        return $this
            ->select('idpesq')
            ->where('id', $id)
            ->get();
    }
}
