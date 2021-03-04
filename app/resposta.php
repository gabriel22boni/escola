<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class resposta extends Model
{
    public function QuestDel($data){
        $respsdel = $this
                ->where('idpesq',$data['id'])
                ->where('questnum', '=', $data['questnum'])
                ->update(['status'=>'I']);

        $resps = $this
        ->where('idpesq',$data['id'])
        ->where('questnum', '>', $data['questnum'])
        ->where('status','A')
        ->get();

        for($i=0;$i< count($resps);$i++ ){
        $newQuestNum = $data['questnum']+$i;
                $this
                ->where('idpesq',$data['id'])
                ->where('questnum',$resps[$i]['questnum'])
                ->update(['questnum' => $newQuestNum]);
        }
    }

    public function addPesquisa($respostas){
        foreach($respostas as $resposta){
            switch($resposta['TIPO']){
                case 'EU':
                    $InsertData = [   
                        'TIPO'=>'EU',
                        'questnum'=> $resposta['questnum'], 
                        'idpesq'=>$resposta['idpesq'], 
                        'RespEu'=>$resposta['RespEU'],
                        'status'=>'A',
                    ];
                    $this->insert($InsertData);
                break;
                case 'ME':
                    $Resp1ME = '';
                    $Resp2ME = '';
                    $Resp3ME = '';
                    $Resp4ME = '';
                    $Resp5ME = '';
                    foreach($resposta['RespME'] as $resp){
                        switch($resp){
                            case 1:
                                $Resp1ME = '1';
                            break;
                            case 2:
                                $Resp2ME = '1';
                            break;
                            case 3:
                                $Resp3ME = '1';
                            break;
                            case 4:
                                $Resp4ME = '1';
                            break;
                            case 5:
                                $Resp5ME = '1';
                            break;
                        }
                    }
                    $InsertData = [   
                        'TIPO'=>'ME', 
                        'questnum'=> $resposta['questnum'], 
                        'idpesq'=>$resposta['idpesq'], 
                        'Resp1ME'=>$Resp1ME,
                        'Resp2ME'=>$Resp2ME,
                        'Resp3ME'=>$Resp3ME,
                        'Resp4ME'=>$Resp4ME,
                        'Resp5ME'=>$Resp5ME,
                        'status'=>'A',
                    ];
                    $this->insert($InsertData);
                break;
                case 'SN':
                    $InsertData = [   
                        'TIPO'=>'SN', 
                        'questnum'=> $resposta['questnum'], 
                        'idpesq'=>$resposta['idpesq'], 
                        'RespSN'=>$resposta['RespSN'],
                        'status'=>'A',
                    ];
                    $this->insert($InsertData);
                break;
                case 'ZD':
                    $InsertData = [   
                        'TIPO'=>'ZD', 
                        'questnum'=> $resposta['questnum'], 
                        'idpesq'=>$resposta['idpesq'], 
                        'RespZD'=>$resposta['RespZD'],
                        'status'=>'A',
                    ];
                    $this->insert($InsertData);
                break;
            }
        }
    }

    public function porcent($data){
        switch($data['tipoP']){
            case 'EU':
                $total = count($this
                    ->where('questnum',$data['questNumP'])
                    ->where('idpesq',$data['idpesqP'])
                    ->get());

                $resp = count($this
                    ->where('questnum',$data['questNumP'])
                    ->where('idpesq',$data['idpesqP'])
                    ->where('RespEu',$data['op'])
                    ->get());

                $percent = $resp/$total*100;
                $percent = number_format($percent, 2, ',','');

                $retorno[0] = $percent.'%';
                $retorno[1] = $resp;
                $retorno[2] = $data['ret'];
            break;
            case 'ME':
                $total = count($this
                    ->where('questnum',$data['questNumP'])
                    ->where('idpesq',$data['idpesqP'])
                    ->get());

                switch($data['op']){
                    case 1:
                        $resp = count($this
                        ->where('questnum',$data['questNumP'])
                        ->where('idpesq',$data['idpesqP'])
                        ->where('Resp1ME',1)
                        ->get()); 
                    break;
                    case 2:
                        $resp = count($this
                        ->where('questnum',$data['questNumP'])
                        ->where('idpesq',$data['idpesqP'])
                        ->where('Resp2ME',1)
                        ->get()); 
                    break;
                    case 3:
                        $resp = count($this
                        ->where('questnum',$data['questNumP'])
                        ->where('idpesq',$data['idpesqP'])
                        ->where('Resp3ME',1)
                        ->get()); 
                    break;
                    case 4:
                        $resp = count($this
                        ->where('questnum',$data['questNumP'])
                        ->where('idpesq',$data['idpesqP'])
                        ->where('Resp4ME',1)
                        ->get()); 
                    break;
                    case 5:
                        $resp = count($this
                        ->where('questnum',$data['questNumP'])
                        ->where('idpesq',$data['idpesqP'])
                        ->where('Resp5ME',1)
                        ->get()); 
                    break;
                }
                    

                $percent = $resp/$total*100;
                $percent = number_format($percent, 2, ',','');

                $retorno[0] = $percent.'%';
                $retorno[1] = $resp;
                $retorno[2] = $data['ret'];
                $retorno[3] = $total;
            break;
            case 'SN':
                $total = count($this
                    ->where('questnum',$data['questNumP'])
                    ->where('idpesq',$data['idpesqP'])
                    ->get());

                $resp = count($this
                    ->where('questnum',$data['questNumP'])
                    ->where('idpesq',$data['idpesqP'])
                    ->where('RespSN',$data['op'])
                    ->get());

                $percent = $resp/$total*100;
                $percent = number_format($percent, 2, ',','');

                $retorno[0] = $percent.'%';
                $retorno[1] = $resp;
                $retorno[2] = $data['ret'];
            break;
            case 'ZD':
                $total = count($this
                    ->where('questnum',$data['questNumP'])
                    ->where('idpesq',$data['idpesqP'])
                    ->get());

                $resp = count($this
                    ->where('questnum',$data['questNumP'])
                    ->where('idpesq',$data['idpesqP'])
                    ->where('RespZD',$data['op'])
                    ->get());

                $percent = $resp/$total*100;
                $percent = number_format($percent, 2, ',','');

                $retorno[0] = $percent.'%';
                $retorno[1] = $resp;
                $retorno[2] = $data['ret'];
            break;
        }
        
        
        return $retorno;

    }
}
