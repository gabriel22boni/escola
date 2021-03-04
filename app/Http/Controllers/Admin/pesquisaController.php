<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\pesquisa;
use App\cad_admaster;
use App\quest;
use App\resposta;

class pesquisaController extends Controller
{
    private $totalpage = 3;

    public function qtde(Request $request, pesquisa $pesquisa){
        $dataForm = $request->except('_token');
        $retorno = $pesquisa->qtde($dataForm);
        return $retorno;
    }

    public function porcentagem(Request $request, resposta $resposta){
        $dataForm = $request->except('_token');
        $retorno = $resposta->porcent($dataForm);
        return $retorno;
    }

    public function dados(Request $request, resposta $resposta){
        $dataForm = $request->except('_token');
        $retorno = $resposta->addPesquisa($dataForm['respostas']);
        return $retorno;
        
    }

    public function index($nomePesq, pesquisa $cadPesq,quest $quest){
        $retorno = $cadPesq->porPesquisa($nomePesq);
        if(isset($retorno[0])){
            $quests = $quest->porPesquisa($retorno[0]['id']);
            return view('pesquisa.index',compact('retorno','quests'));
        }else{
            $retorno = [];
            return view('pesquisa.index',compact('retorno', 'nomePesq'));
        }
    }
    
    public function pesquisaView(pesquisa $cadPesq, cad_admaster $cadAdmaster){
        $cadPesqs = $cadPesq->search($this->totalpage);
        $cadAdmasters = $cadAdmaster->searchSelect();
        return view('painel.pesquisa.pesquisa', compact('cadPesqs','cadAdmasters'));
    }

    public function pesquisaSearch  (Request $request,  pesquisa $cadPesq, cad_admaster $cadAdmaster){
        $dataForm = $request->except('_token');
        $cadPesqs = $cadPesq->search($this->totalpage, $dataForm);
        $cadAdmasters = $cadAdmaster->searchSelect();
        return view('painel.pesquisa.pesquisa', compact('cadPesqs','cadAdmasters','dataForm'));
    }

    public function pesquisaInsert  (Request $request,  pesquisa $cadPesq){
        $dataForm = $request->except('_token');
        $retorno = [
            'status' => 'success',
        ];
        $msg = [];

        if(
            auth()->user()->nivel=='CEO'
        ){
            if(!isset($dataForm['idmaster'])||!($dataForm['idmaster']>0)){
                array_push($msg, 'Favor informar a Escola');
                $retorno['status'] = 'error';
            }
        }

        
        if(!isset($dataForm['nome']))
            {
                array_push($msg, 'Favor informar Nome');
                $retorno['status'] = 'error';
            }
        
        if(!isset($dataForm['url']))
        {
            array_push($msg, 'Favor informar URL');
            $retorno['status'] = 'error';
        }
    
        

        if($retorno['status'] == 'success')
        {
            $cadPesq->insertPesq($dataForm);
        }

        array_push($retorno, $msg);
        return $retorno;
    }

    public function pesquisaDados   (Request $request,  pesquisa $cadPesq){
        $id = $request->except("_token");
        $dados = $cadPesq->porId($id);
        return $dados;
    }
    
    public function pesquisaDelete  (Request $request,  pesquisa $cadPesq){
        $id = $request->except("_token");
        $dados = $cadPesq->deleteMat($id);
        return $dados;
    }

    public function pesquisaUpdate  (Request $request,  pesquisa $cadPesq){
        $data = $request->except("_token");

        $retorno = [
            'status' => 'success',
        ];
        $msg = [];

        $campos = [1=>"id",2=>"idmaster",3=>"nome",4=>"url"];
        for($a=1;$a<=4;$a++){
            if($data[$campos[$a]]==null){
                unset($data[$campos[$a]]);
            }
        }

        if(count($data)==1){
            $retorno['status'] = 'vazio';
        }

        if($retorno['status'] == 'success')
        {
            $cadPesq->updateReg($data);
    
            return $retorno;
        }

        return $retorno;
    }

    public function pesquisaAddQuest (Request $request, quest $quest, pesquisa $pesquisa){
        $dataForm = $request->except("_token");
        $retorno = [
            'status' => 'success',
        ];
        $msg = [];
        
        switch(true){
            case $dataForm['tipo'] == 'EU':
                if(!isset($dataForm['enunciado'])){
                    array_push($msg, 'Enunciado');
                    $retorno['status'] = 'error';
                }
                
                if(!isset($dataForm['op_1'])){
                    array_push($msg, 'op1');
                    $retorno['status'] = 'error';
                }
            
                if(!isset($dataForm['op_2'])){
                    array_push($msg, 'op2');
                    $retorno['status'] = 'error';
                }
                if($dataForm['numOpts'] >= '3'){
                    if(!isset($dataForm['op_3'])){
                        array_push($msg, 'op3');
                        $retorno['status'] = 'error';
                    }
                }
                if($dataForm['numOpts'] >= '4'){
                    if(!isset($dataForm['op_4'])){
                        array_push($msg, 'op4');
                        $retorno['status'] = 'error';
                    }
                }
                if($dataForm['numOpts'] == '5'){
                    if(!isset($dataForm['op_5'])){
                        array_push($msg, 'op5');
                        $retorno['status'] = 'error';
                    }
                }
                
        
                if($retorno['status'] == 'success')
                {
                    $qtdeQuest = $pesquisa->addQuest($dataForm['idPesq']);
                    $retorno = [
                        'numQuest' => $qtdeQuest,
                    ];
                    $quest->insertQuest($dataForm, $qtdeQuest);
                }
        
                array_push($retorno, $msg);
                return $retorno;
            break;
            case $dataForm['tipo'] == 'ME':
                if(!isset($dataForm['enunciado'])){
                    array_push($msg, 'Enunciado');
                    $retorno['status'] = 'error';
                }
                
                if(!isset($dataForm['op_1'])){
                    array_push($msg, 'op1');
                    $retorno['status'] = 'error';
                }
            
                if(!isset($dataForm['op_2'])){
                    array_push($msg, 'op2');
                    $retorno['status'] = 'error';
                }
                if($dataForm['numOpts'] >= '3'){
                    if(!isset($dataForm['op_3'])){
                        array_push($msg, 'op3');
                        $retorno['status'] = 'error';
                    }
                }
                if($dataForm['numOpts'] >= '4'){
                    if(!isset($dataForm['op_4'])){
                        array_push($msg, 'op4');
                        $retorno['status'] = 'error';
                    }
                }
                if($dataForm['numOpts'] == '5'){
                    if(!isset($dataForm['op_5'])){
                        array_push($msg, 'op5');
                        $retorno['status'] = 'error';
                    }
                }
                
        
                if($retorno['status'] == 'success')
                {
                    $qtdeQuest = $pesquisa->addQuest($dataForm['idPesq']);
                    $retorno = [
                        'numQuest' => $qtdeQuest,
                    ];
                    $quest->insertQuest($dataForm, $qtdeQuest);
                }
        
                array_push($retorno, $msg);
                return $retorno;
            break;
            case $dataForm['tipo'] == 'SN':
                if(!isset($dataForm['enunciado'])){
                    array_push($msg, 'Enunciado');
                    $retorno['status'] = 'error';
                }
        
                if($retorno['status'] == 'success')
                {
                    $qtdeQuest = $pesquisa->addQuest($dataForm['idPesq']);
                    $retorno = [
                        'numQuest' => $qtdeQuest,
                    ];
                    $quest->insertQuest($dataForm, $qtdeQuest);
                }
        
                array_push($retorno, $msg);
                return $retorno;
            break;
            case $dataForm['tipo'] == 'ZD':
                if(!isset($dataForm['enunciado'])){
                    array_push($msg, 'Enunciado');
                    $retorno['status'] = 'error';
                }
        
                if($retorno['status'] == 'success')
                {
                    $qtdeQuest = $pesquisa->addQuest($dataForm['idPesq']);
                    $retorno = [
                        'numQuest' => $qtdeQuest,
                    ];
                    $quest->insertQuest($dataForm, $qtdeQuest);
                }
        
                array_push($retorno, $msg);
                return $retorno;
            break;
        }
        
    }

    public function pesquisagetQuests(Request $request,quest $quest){
        $dataForm = $request->except("_token");
        $quests = $quest->porPesquisa($dataForm['id']);
        return $quests;
    }

    public function QuestGet(Request $request,quest $quest){
        $dataForm = $request->except("_token");
        return $quest->porQuest($dataForm);
    }

    public function QuestDel(Request $request,quest $quest,pesquisa $pesquisa, resposta $resposta){
        $dataForm = $request->except("_token");
        $pesquisa->delQuest($dataForm['id']);
        $quest->QuestDel($dataForm);
        $resposta->QuestDel($dataForm);

    }

    public function questUpdate(Request $request,quest $quest){
        $data = $request->except("_token");

        $retorno = [
            'status' => 'success',
        ];
        $msg = [];
        
        if($data['tipo']== 'EU' || $data['tipo']== 'ME' ){
            $campos = [1=>"id",2=>"tipo",3=>"enunciado",4=>"qtdOps",5=>'op_1',6=>'op_2',7=>'op_3',8=>'op_4',9=>'op_5'];
            for($a=1;$a<=9;$a++){
                if($data[$campos[$a]]==null){
                    unset($data[$campos[$a]]);
                }
                if(count($data)==3){
                    $retorno['status'] = 'vazio';
                }
            }
        }else{
            $campos = [1=>"id",2=>"tipo",3=>"enunciado"];
            for($a=1;$a<=3;$a++){
                if($data[$campos[$a]]==null){
                    unset($data[$campos[$a]]);
                }
                if(count($data)==2){
                    $retorno['status'] = 'vazio';
                }
            }
        }
        
        if($retorno['status'] == 'success')
        {
            unset($data['tipo']);
            return $quest->questUpdate($data);
        }

        return $retorno;

    }
}
