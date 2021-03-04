<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\city;
use App\Models\state;
use App\cad_cli;
use App\cad_cob;
use App\cad_adm;
use App\cad_admaster;
use App\cad_ceo;
use App\User;
use App\cad_produto;
use App\cad_materia;

class cadastrosController extends Controller
{
    private $totalpage = 3;

    public function cobradorView(state $state, cad_admaster $cadAdm, cad_cob $cadCob){
        $stateNames = $state->all();   
        $cadAdms = $cadAdm->searchSelect();
        $cadCobs = $cadCob->search($this->totalpage);
        return view('painel.cadastro.cobrador',compact('stateNames','cadAdms','cadCobs'));
    }

    public function cobradorSearch(state $state, cad_admaster $cadAdm, cad_cob $cadCob, Request $request){
        $dataForm = $request->except('_token');
        $stateNames = $state->all();   
        $cadAdms = $cadAdm->searchSelect();
        $cadCobs = $cadCob->search($this->totalpage, $dataForm);
        return view('painel.cadastro.cobrador',compact('stateNames','cadAdms','cadCobs','dataForm'));
    }

    public function cobradorInsert(Request $request, cad_cob $cad_cob, User $user){
        $dataForm = $request->except('_token');
        $retorno = [
            'status' => 'success',
        ];
        $msg = [];

        if(
            auth()->user()->nivel=='CEO'
            || auth()->user()->nivel=='MAS'
        ){
            if(!isset($dataForm['idadm'])||!($dataForm['idadm']>0)){
                array_push($msg, 'Favor informar a Escola');
                $retorno['status'] = 'error';
            }
        }

        
        if(!isset($dataForm['bairro']))
        {
            array_push($msg, 'Favor informar bairro');
            $retorno['status'] = 'error';
        }
        if(!isset($dataForm['cel']))
        {
            array_push($msg, 'Favor informar um celular');
            $retorno['status'] = 'error';
        }
        if(!isset($dataForm['cep']))
        {
            array_push($msg, 'Favor informar um CEP');
            $retorno['status'] = 'error';
        }
        if(!isset($dataForm['estado']))
        {
            array_push($msg, 'Favor informar Estado');
            $retorno['status'] = 'error';
        }
        if(!isset($dataForm['cidade']))
        {
            array_push($msg, 'Favor informar Cidade');
            $retorno['status'] = 'error';
        }
        if(!isset($dataForm['email']))
        {
            array_push($msg, 'Favor informar E-mail');
            $retorno['status'] = 'error';
        }else{
            $mailVer = $user->mailVer($dataForm['email']);
            if($mailVer == true){
                array_push($msg, 'Email já cadastrado');
                $retorno['status'] = 'error';
            }
        }
        if(!isset($dataForm['endereco']))
        {
            array_push($msg, 'Favor informar Endereço');
            $retorno['status'] = 'error';
        }
        if(!isset($dataForm['fone']))
        {
            array_push($msg, 'Favor informar um telefone');
            $retorno['status'] = 'error';
        }
        if(!isset($dataForm['numero']))
        {
            array_push($msg, 'Favor informar Numero');
            $retorno['status'] = 'error';
        }
        if(!isset($dataForm['password']))
        {
            array_push($msg, 'Favor informar Senha');
            $retorno['status'] = 'error';
        }
        if($dataForm['pessoa']=='F'){
            if(!isset($dataForm['nome']))
                {
                    array_push($msg, 'Favor informar Nome');
                    $retorno['status'] = 'error';
                }
            if(!isset($dataForm['cpf']))
                {
                    array_push($msg, 'Favor informar CPF');
                    $retorno['status'] = 'error';
                }
        }else{
            if(!isset($dataForm['razsoc']))
                {
                    array_push($msg, 'Favor informar Razão Social');
                    $retorno['status'] = 'error';
                }
            if(!isset($dataForm['fnome']))
                {
                    array_push($msg, 'Favor informar Nome Fantasia');
                    $retorno['status'] = 'error';
                }
            if(!isset($dataForm['cnpj']))
                {
                    array_push($msg, 'Favor informar CNPJ');
                    $retorno['status'] = 'error';
                }
        };

       
        if($retorno['status'] == 'success')
        {
            $user->insertCob($cad_cob->insertCob($dataForm));
        }

        array_push($retorno, $msg);
        return $retorno;
    }

    public function cobradorDados(Request $request,cad_cob $cadCob){
        $id = $request->except("_token");
        $dados = $cadCob->porId($id);
        return $dados;
    }
    
    public function cobradorDelete(Request $request,cad_cob $cadCob, User $user){
        $id = $request->except("_token");
        $dados = $cadCob->deleteCob($id);
        $user->deleteCob($id);
        return $dados;
    }

    public function cobradorUpdate(Request $request, cad_cob $cad_Cob, User $user){
        $data = $request->except("_token");

        $retorno = [
            'status' => 'success',
        ];
        $msg = [];

        $campos = [1=>"id",2=>"idadm",3=>"nome",4=>"razsoc",5=>"fnome",6=>"cpf",7=>"cnpj",8=>"endereco",9=>"numero",10=>"cep",11=>"bairro",12=>"estado",13=>"cidade",14=>"email",15=>"fone",16=>"cel",17=>"image"];
        for($a=1;$a<=17;$a++){
            if($data[$campos[$a]]==null){
                unset($data[$campos[$a]]);
            }
        }

        if(isset($data[$campos[14]])){
            $mailVer = $user->mailVer($data[$campos[14]]);
            if($mailVer == true){
                $retorno['status'] = 'mailerror';
            }
        }
        
        if(count($data)==1){
            $retorno['status'] = 'vazio';
        }

        if($retorno['status'] == 'success')
        {
            $cad_Cob->updateReg($data);
            $user->updateUsr($data);
    
            return $retorno;
        }

        return $retorno;
    }

    public function adminView(state $state, cad_admaster $cadAdmaster, cad_adm $cadAdm){
        $stateNames = $state->all();   
        $cadAdmasters = $cadAdmaster->searchSelect();
        $cadAdms = $cadAdm->search($this->totalpage);
        return view('painel.cadastro.admin',compact('stateNames','cadAdmasters','cadAdms'));
    }

    public function adminSearch(state $state, cad_admaster $cadAdmaster, cad_adm $cadAdm, Request $request){
        $dataForm = $request->except('_token');
        $stateNames = $state->all();   
        $cadAdmasters = $cadAdmaster->searchSelect();
        $cadAdms = $cadAdm->search($this->totalpage, $dataForm);
        return view('painel.cadastro.admin',compact('stateNames','cadAdmasters','cadAdms','dataForm'));
    }

    public function adminInsert(Request $request, cad_adm $cad_adm, User $user){
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

        
        if(!isset($dataForm['bairro']))
        {
            array_push($msg, 'Favor informar bairro');
            $retorno['status'] = 'error';
        }
        if(!isset($dataForm['cel']))
        {
            array_push($msg, 'Favor informar um celular');
            $retorno['status'] = 'error';
        }
        if(!isset($dataForm['cep']))
        {
            array_push($msg, 'Favor informar um CEP');
            $retorno['status'] = 'error';
        }
        if(!isset($dataForm['estado']))
        {
            array_push($msg, 'Favor informar Estado');
            $retorno['status'] = 'error';
        }
        if(!isset($dataForm['cidade']))
        {
            array_push($msg, 'Favor informar Cidade');
            $retorno['status'] = 'error';
        }
        if(!isset($dataForm['email']))
        {
            array_push($msg, 'Favor informar E-mail');
            $retorno['status'] = 'error';
        }else{
            $mailVer = $user->mailVer($dataForm['email']);
            if($mailVer == true){
                array_push($msg, 'Email já cadastrado');
                $retorno['status'] = 'error';
            }
        }
        if(!isset($dataForm['endereco']))
        {
            array_push($msg, 'Favor informar Endereço');
            $retorno['status'] = 'error';
        }
        if(!isset($dataForm['fone']))
        {
            array_push($msg, 'Favor informar um telefone');
            $retorno['status'] = 'error';
        }
        if(!isset($dataForm['numero']))
        {
            array_push($msg, 'Favor informar Numero');
            $retorno['status'] = 'error';
        }
        if(!isset($dataForm['password']))
        {
            array_push($msg, 'Favor informar Senha');
            $retorno['status'] = 'error';
        }
        if($dataForm['pessoa']=='F'){
            if(!isset($dataForm['nome']))
                {
                    array_push($msg, 'Favor informar Nome');
                    $retorno['status'] = 'error';
                }
            if(!isset($dataForm['cpf']))
                {
                    array_push($msg, 'Favor informar CPF');
                    $retorno['status'] = 'error';
                }
        }else{
            if(!isset($dataForm['razsoc']))
                {
                    array_push($msg, 'Favor informar Razão Social');
                    $retorno['status'] = 'error';
                }
            if(!isset($dataForm['fnome']))
                {
                    array_push($msg, 'Favor informar Nome Fantasia');
                    $retorno['status'] = 'error';
                }
            if(!isset($dataForm['cnpj']))
                {
                    array_push($msg, 'Favor informar CNPJ');
                    $retorno['status'] = 'error';
                }
        };

       
        if($retorno['status'] == 'success')
        {
            $user->insertAdm($cad_adm->insertAdm($dataForm));
        }

        array_push($retorno, $msg);
        return $retorno;
    }

    public function adminDados(Request $request,cad_adm $cadAdm){
        $id = $request->except("_token");
        $dados = $cadAdm->porId($id);
        return $dados;
    }
    
    public function adminDelete(Request $request,cad_adm $cadAdm, User $user){
        $id = $request->except("_token");
        $dados = $cadAdm->deleteAdm($id);
        $user->deleteAdm($id);
        return $dados;
    }

    public function adminUpdate(Request $request, cad_adm $cad_Adm, User $user){
        $data = $request->except("_token");

        $retorno = [
            'status' => 'success',
        ];
        $msg = [];

        $campos = [1=>"id",2=>"idmaster",3=>"nome",4=>"cpf",5=>"endereco",6=>"numero",7=>"cep",8=>"bairro",9=>"estado",10=>"cidade",11=>"email",12=>"fone",13=>"cel",14=>"image"];
        for($a=1;$a<=14;$a++){
            if($data[$campos[$a]]==null){
                unset($data[$campos[$a]]);
            }
        }

        if(isset($data[$campos[14]])){
            $mailVer = $user->mailVer($data[$campos[14]]);
            if($mailVer == true){
                $retorno['status'] = 'mailerror';
            }
        }
        
        if(count($data)==1){
            $retorno['status'] = 'vazio';
        }

        if($retorno['status'] == 'success')
        {
            $cad_Adm->updateReg($data);
            $user->updateUsr($data);
    
            return $retorno;
        }

        return $retorno;
    }

    public function masterAdminView(state $state, cad_admaster $cadAdmaster){
        $stateNames = $state->all();   
        $cadAdmasters = $cadAdmaster->search($this->totalpage);
        return view('painel.cadastro.masterAdmin',compact('stateNames','cadAdmasters'));
    }

    public function masterAdminSearch(state $state, cad_cob $cadCob, cad_admaster $cadAdmaster, Request $request){
        $dataForm = $request->except('_token');
        $stateNames = $state->all();   
        $cadAdmasters = $cadAdmaster->search($this->totalpage, $dataForm);
        return view('painel.cadastro.masterAdmin',compact('stateNames','cadAdmasters','dataForm'));
    }

    public function masterAdminInsert(Request $request, cad_admaster $cad_admaster, User $user){
        $dataForm = $request->except('_token');
        $retorno = [
            'status' => 'success',
        ];
        $msg = [];

        if(!isset($dataForm['bairro']))
        {
            array_push($msg, 'Favor informar bairro');
            $retorno['status'] = 'error';
        }
        if(!isset($dataForm['cel']))
        {
            array_push($msg, 'Favor informar um celular');
            $retorno['status'] = 'error';
        }
        if(!isset($dataForm['cep']))
        {
            array_push($msg, 'Favor informar um CEP');
            $retorno['status'] = 'error';
        }
        if(!isset($dataForm['estado']))
        {
            array_push($msg, 'Favor informar Estado');
            $retorno['status'] = 'error';
        }
        if(!isset($dataForm['cidade']))
        {
            array_push($msg, 'Favor informar Cidade');
            $retorno['status'] = 'error';
        }
        if(!isset($dataForm['email']))
        {
            array_push($msg, 'Favor informar E-mail');
            $retorno['status'] = 'error';
        }else{
            $mailVer = $user->mailVer($dataForm['email']);
            if($mailVer == true){
                array_push($msg, 'Email já cadastrado');
                $retorno['status'] = 'error';
            }
        }
        if(!isset($dataForm['endereco']))
        {
            array_push($msg, 'Favor informar Endereço');
            $retorno['status'] = 'error';
        }
        if(!isset($dataForm['fone']))
        {
            array_push($msg, 'Favor informar um telefone');
            $retorno['status'] = 'error';
        }
        if(!isset($dataForm['numero']))
        {
            array_push($msg, 'Favor informar Numero');
            $retorno['status'] = 'error';
        }
        if(!isset($dataForm['password']))
        {
            array_push($msg, 'Favor informar Senha');
            $retorno['status'] = 'error';
        }
        if($dataForm['pessoa']=='F'){
            if(!isset($dataForm['nome']))
                {
                    array_push($msg, 'Favor informar Nome');
                    $retorno['status'] = 'error';
                }
            if(!isset($dataForm['cpf']))
                {
                    array_push($msg, 'Favor informar CPF');
                    $retorno['status'] = 'error';
                }
        }else{
            if(!isset($dataForm['razsoc']))
                {
                    array_push($msg, 'Favor informar Razão Social');
                    $retorno['status'] = 'error';
                }
            if(!isset($dataForm['fnome']))
                {
                    array_push($msg, 'Favor informar Nome Fantasia');
                    $retorno['status'] = 'error';
                }
            if(!isset($dataForm['cnpj']))
                {
                    array_push($msg, 'Favor informar CNPJ');
                    $retorno['status'] = 'error';
                }
        };

       
        if($retorno['status'] == 'success')
        {
            $user->insertAdmaster($cad_admaster->insertAdmaster($dataForm));
        }

        array_push($retorno, $msg);
        return $retorno;
    }

    public function masterAdminDados(Request $request,cad_admaster $cadAdmaster){
        $id = $request->except("_token");
        $dados = $cadAdmaster->porId($id);
        return $dados;
    }
    
    public function masterAdminDelete(Request $request,cad_admaster $cadAdmaster, User $user){
        $id = $request->except("_token");
        $dados = $cadAdmaster->deleteAdmaster($id);
        $user->deleteAdmaster($id);
        return $dados;
    }

    public function masterAdminUpdate(Request $request, cad_admaster $cad_Admaster, User $user){
        $data = $request->except("_token");

        $retorno = [
            'status' => 'success',
        ];
        $msg = [];

        $campos = [1=>"id",2=>"idceo",3=>"nome",4=>"razsoc",5=>"fnome",6=>"cpf",7=>"cnpj",8=>"endereco",9=>"numero",10=>"cep",11=>"bairro",12=>"estado",13=>"cidade",14=>"email",15=>"fone",16=>"cel",17=>"image"];
        for($a=1;$a<=17;$a++){
            if($data[$campos[$a]]==null){
                unset($data[$campos[$a]]);
            }
        }

        if(isset($data[$campos[14]])){
            $mailVer = $user->mailVer($data[$campos[14]]);
            if($mailVer == true){
                $retorno['status'] = 'mailerror';
            }
        }
        
        if(count($data)==1){
            $retorno['status'] = 'vazio';
        }

        if($retorno['status'] == 'success')
        {
            $cad_Admaster->updateReg($data);
            $user->updateUsr($data);
    
            return $retorno;
        }

        return $retorno;
    }

    public function ceoView(state $state, cad_ceo $cadCeo){
        $stateNames = $state->all();   
        $cadCeos = $cadCeo->search($this->totalpage);
        return view('painel.cadastro.ceo',compact('stateNames','cadCeos'));
    }

    public function ceoSearch(state $state, cad_ceo $cadCeo, Request $request){
        $dataForm = $request->except('_token');
        $stateNames = $state->all();   
        $cadCeos = $cadCeo->search($this->totalpage, $dataForm);
        return view('painel.cadastro.ceo',compact('stateNames','cadCeos','dataForm'));
    }

    public function ceoInsert(Request $request, cad_ceo $cad_ceo, User $user){
        $dataForm = $request->except('_token');
        $idCEO = auth()->user()->idceo;
        $dataForm += ['idceo'=>$idCEO,];
        $retorno = [
            'status' => 'success',
        ];
        $msg = [];

        if(!isset($dataForm['bairro']))
        {
            array_push($msg, 'Favor informar bairro');
            $retorno['status'] = 'error';
        }
        if(!isset($dataForm['cel']))
        {
            array_push($msg, 'Favor informar um celular');
            $retorno['status'] = 'error';
        }
        if(!isset($dataForm['cep']))
        {
            array_push($msg, 'Favor informar um CEP');
            $retorno['status'] = 'error';
        }
        if(!isset($dataForm['estado']))
        {
            array_push($msg, 'Favor informar Estado');
            $retorno['status'] = 'error';
        }
        if(!isset($dataForm['cidade']))
        {
            array_push($msg, 'Favor informar Cidade');
            $retorno['status'] = 'error';
        }
        if(!isset($dataForm['email']))
        {
            array_push($msg, 'Favor informar E-mail');
            $retorno['status'] = 'error';
        }else{
            $mailVer = $user->mailVer($dataForm['email']);
            if($mailVer == true){
                array_push($msg, 'Email já cadastrado');
                $retorno['status'] = 'error';
            }
        }
        if(!isset($dataForm['endereco']))
        {
            array_push($msg, 'Favor informar Endereço');
            $retorno['status'] = 'error';
        }
        if(!isset($dataForm['fone']))
        {
            array_push($msg, 'Favor informar um telefone');
            $retorno['status'] = 'error';
        }
        if(!isset($dataForm['numero']))
        {
            array_push($msg, 'Favor informar Numero');
            $retorno['status'] = 'error';
        }
        if(!isset($dataForm['password']))
        {
            array_push($msg, 'Favor informar Senha');
            $retorno['status'] = 'error';
        }
        if($dataForm['pessoa']=='F'){
            if(!isset($dataForm['nome']))
                {
                    array_push($msg, 'Favor informar Nome');
                    $retorno['status'] = 'error';
                }
            if(!isset($dataForm['cpf']))
                {
                    array_push($msg, 'Favor informar CPF');
                    $retorno['status'] = 'error';
                }
        }else{
            if(!isset($dataForm['razsoc']))
                {
                    array_push($msg, 'Favor informar Razão Social');
                    $retorno['status'] = 'error';
                }
            if(!isset($dataForm['fnome']))
                {
                    array_push($msg, 'Favor informar Nome Fantasia');
                    $retorno['status'] = 'error';
                }
            if(!isset($dataForm['cnpj']))
                {
                    array_push($msg, 'Favor informar CNPJ');
                    $retorno['status'] = 'error';
                }
        };

       
        if($retorno['status'] == 'success')
        {
            $user->insertCeo($cad_ceo->insertCeo($dataForm));
        }

        array_push($retorno, $msg);
        return $retorno;
    }

    public function ceoDados(Request $request,cad_ceo $cadCeo){
        $id = $request->except("_token");
        $dados = $cadCeo->porId($id);
        return $dados;
    }
    
    public function ceoDelete(Request $request,cad_ceo $cadCeo, User $user){
        $id = $request->except("_token");
        $dados = $cadCeo->deleteCeo($id);
        $user->deleteCeo($id);
        return $dados;
    }

    public function ceoUpdate(Request $request, cad_ceo $cad_Ceo, User $user){
        $data = $request->except("_token");

        $retorno = [
            'status' => 'success',
        ];
        $msg = [];

        $campos = [2=>"id",3=>"nome",4=>"razsoc",5=>"fnome",6=>"cpf",7=>"cnpj",8=>"endereco",9=>"numero",10=>"cep",11=>"bairro",12=>"estado",13=>"cidade",14=>"email",15=>"fone",16=>"cel",17=>"image"];
        for($a=2;$a<=17;$a++){
            if($data[$campos[$a]]==null){
                unset($data[$campos[$a]]);
            }
        }

        if(isset($data[$campos[14]])){
            $mailVer = $user->mailVer($data[$campos[14]]);
            if($mailVer == true){
                $retorno['status'] = 'mailerror';
            }
        }
        
        if(count($data)==1){
            $retorno['status'] = 'vazio';
        }

        if($retorno['status'] == 'success')
        {
            $cad_Ceo->updateReg($data);
            $user->updateUsr($data);
    
            return $retorno;
        }

        return $retorno;
    }

    public function searchState(Request $request, city $city){
        $id = $request->only('stateId');
        return $city->porState($id['stateId']);
    }

    public function materiaView(cad_materia $cadMat,cad_admaster $cadAdmaster){
        $cadMats = $cadMat->search($this->totalpage);
        $cadAdmasters = $cadAdmaster->searchSelect();
        return view('painel.cadastro.materia', compact('cadMats','cadAdmasters'));
    }

    public function materiaSearch(cad_materia $cadMat,cad_admaster $cadAdmaster,Request $request){
        $dataForm = $request->except('_token');
        $cadMats = $cadMat->search($this->totalpage, $dataForm);
        $cadAdmasters = $cadAdmaster->searchSelect();
        return view('painel.cadastro.materia', compact('cadMats','cadAdmasters','dataForm'));
    }

    public function materiaInsert(Request $request, cad_materia $cadmateria){
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
        
        if($retorno['status'] == 'success')
        {
            $cadmateria->insertMat($dataForm);
        }

        array_push($retorno, $msg);
        return $retorno;
    }

    public function materiaDados(Request $request,cad_materia $cadmateria){
        $id = $request->except("_token");
        $dados = $cadmateria->porId($id);
        return $dados;
    }
    
    public function materiaDelete(Request $request,cad_materia $cadmateria){
        $id = $request->except("_token");
        $dados = $cadmateria->deleteMat($id);
        return $dados;
    }

    public function materiaUpdate(Request $request, cad_materia $cadmateria){
        $data = $request->except("_token");

        $retorno = [
            'status' => 'success',
        ];
        $msg = [];

        $campos = [1=>"id",2=>"idmaster",3=>"nome"];
        for($a=1;$a<=3;$a++){
            if($data[$campos[$a]]==null){
                unset($data[$campos[$a]]);
            }
        }

        if(count($data)==1){
            $retorno['status'] = 'vazio';
        }

        if($retorno['status'] == 'success')
        {
            $cadmateria->updateReg($data);
    
            return $retorno;
        }

        return $retorno;
    }
}
