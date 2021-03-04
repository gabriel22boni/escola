@extends('adminlte::page')

@section('title', 'Cadastros - pesquisa')

@section('content_header')
    <h1>Professor</h1>

    <ol class="breadcrumb">
        <li class="breadcrumb-item">Home</li>
        <li class="breadcrumb-item">Cadastros</li>
        <li class="breadcrumb-item active" aria-current="page">Professor</li>
    </ol>
@stop

@section('content')

    <div class="card card-success" style="position: relative; left: 0px; top: 0px;">
        <div class="card-header border-0 ui-sortable-handle" style="cursor: move;">
            <h3 class="card-title">
                <i class="fas fa-th mr-1"></i>
                Pesquisas Cadastrados
            </h3>

            <div class="card-tools">
                <button type="button" class="btn btn-sm" data-card-widget="collapse">
                    <i class="fas fa-minus"></i>
                </button>
                <button type="button" class="btn btn-sm" data-card-widget="remove">
                    <i class="fas fa-times"></i>
                </button>
            </div>
        </div>

        <div class="card-body" style="display: block;">
            <div class="card">
                <div class="card-header">
                    <div class="col-sm-5 float-left">
                        <form action="{{ route('cadastros.pesquisa.search') }}" method="POST" class="form form-inline">
                            {!! csrf_field() !!}
                            <input name="data" type="text" class="form-control" placeholder="Nome">
                            &nbsp&nbsp&nbsp<button $type="submit" class="btn btn-primary">Filtrar</button>
                        </form>
                        
                    </div>
                    <div class="card-tools float-right">
                        @if(isset($dataForm))
                            {!! $cadPesqs->appends($dataForm ?? '')->links() !!} 
                        @else
                            {!! $cadPesqs->links() !!}     
                        @endif
                    </div>
                </div>
                <div class="card-body p-0">
                    <table class="table">
                        <thead>
                            <tr>
                                <th style="width: 10px">ID</th>
                                <th>Nome</th>
                                <th style="width:40px"></th>
                                <th style="width:40px"></th>
                                <th style="width:40px"></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($cadPesqs as $cadPesq)
                                <tr id="pesquisaRow{{$cadPesq->id}}">
                                    <td>{{$cadPesq->id}}.</td>
                                    <td>{{$cadPesq->nome}}</td>
                                    <td>
                                        <center>
                                            <button onclick="modalDados({{$cadPesq->id}})" type="button" class="btn btn-primary" style="width:100px;">
                                                Ver
                                            </button>
                                        </center>
                                    </td>
                                    <td>
                                        <center>
                                            <button onclick="modalEditar({{$cadPesq->id}})" type="button" class="btn btn-secondary" style="width:100px;">
                                                Editar
                                            </button>
                                        </center>
                                    </td>
                                    <td>
                                        <center>
                                            <button onclick="modalDel({{$cadPesq->id}},'confirm')" type="button" class="btn btn-danger" style="width:100px;">
                                                Excluir
                                            </button>
                                        </center>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="card card-success" style="position: relative; left: 0px; top: 0px;">
        <div class="card-header border-0 ui-sortable-handle" style="cursor: move;">
            <h3 class="card-title">
                <i class="fas fa-plus"></i>
                Cadastrar Pesquisa
            </h3>

            <div class="card-tools">
                <button type="button" class="btn  btn-sm" data-card-widget="collapse">
                    <i class="fas fa-minus"></i>
                </button>
                <button type="button" class="btn  btn-sm" data-card-widget="remove">
                    <i class="fas fa-times"></i>
                </button>
            </div>
        </div>

        <div class="card-body" style="display: block;">
            <form action="" method="POST" id="formCadastro" >
                <div class="row">
                    @if(
                        auth()->user()->nivel=='CEO'
                    )
                    <div class="form-group col-sm-8">
                        <label for="nome">Nome</label>
                        <input type="text" class="form-control formData" id="nome" name="nome" placeholder="Nome">
                    </div>
                    <div class="form-group col-sm-4">
                        <label for="idmaster">Escola</label>
                        <select name="idmaster" class="form-control formData" id="idmaster">
                            <option value="">-- Escola --</option>
                            @foreach($cadAdmasters as $cadAdmaster)
                                <option value="{{$cadAdmaster->id}}">{{$cadAdmaster->nome ?? $cadAdmaster->fnome}}</option>
                            @endforeach
                        </select>
                    </div>
                    @else
                        <div class="form-group col-sm-12">
                            <label for="nome">Nome</label>
                            <input type="text" class="form-control formData" id="nome" name="nome" placeholder="Nome">
                            <input style="display:none" type="text" class="form-control formData" id="idmaster" name="idmaster" value="{{auth()->user()->idmas}}">
                        </div>
                    @endif
                </div>
                <div class="row">
                    <div class="form-group col-sm-12">
                        <label for="idmaster">Endereço da Pesquisa:</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text">minhaescola.izebanc.com.br/pesquisa/</span>
                            </div>
                            <input type="text" class="form-control formData" id="urlpesq" name="urlpesq">
                        </div>
                    </div>
                </div>
            </form>
            <div class="card-footer">
                <button type="submit" class="btn btn-secondary float-left" onclick="resetForm('F')">Limpar</button>
                <button type="submit" class="btn btn-primary float-right" onclick="formSubmit()">Cadastrar</button>    
            </div>
        </div>
    </div>
    
    <div class="modal fade" id="modalSuccessCadastro" style="display: none;" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Sucesso!</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="swal2-icon swal2-success swal2-animate-success-icon" style="display: flex;">
                        <div class="swal2-success-circular-line-left" style="background-color: rgb(255, 255, 255);">
                        </div>
                        <span class="swal2-success-line-tip">
                        </span>
                        <span class="swal2-success-line-long">
                        </span>
                        <div class="swal2-success-ring">
                        </div> 
                        <div class="swal2-success-fix" style="background-color: rgb(255, 255, 255);">
                        </div>
                        <div class="swal2-success-circular-line-right" style="background-color: rgb(255, 255, 255);">
                        </div>
                    </div>
                    <center><p>Pesquisa Cadastrada com sucesso.</p></center>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default float-rigth" data-dismiss="modal" onclick="pageRefresh()">Close</button>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div>

    <div class="modal fade" id="modalVer" style="display: none;" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                <div class="float-left">
                    <h4 class="modal-title">Visualizar Cadastro</h4>
                </div>
                <div class="float-right">
                    <button type="button" id="btnAtualizarDados" class="btn btn-success">Atualizar Dados</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
                </div>
                <div class="modal-body">

                        <div class="card">
                            <div class="card-header">
                                <div class="float-left">
                                    <h3>Qtde. Respostas: <span id="respostasQTD"></span></h3>
                                </div>
                                <div class="float-right">
                                    <span class="nav-link"><button type="button" class="btn btn-info float-right" data-toggle="modal" data-target="#modalAddPergunda" onclick="numeroOpts(2)">Adicionar Pergunta</button></span>
                                </div>
                            </div>
                            <div class="card-body">
                                <form action="" method="POST">
                                    <div class="row">
                                        <div class="form-group col-sm-8">
                                            <label for="nomeVer">Nome</label>
                                            <input type="text" class="form-control formDataVer" id="nomeVer" name="nomeVer" placeholder="Nome" disabled="">
                                        </div>
                                        <div class="form-group col-sm-4">
                                            <label for="idmasterVer">Escola</label>
                                            <select class="form-control" disabled="">
                                                <option name="idmasterVer" class="formDataVer" id="idmasterVer">Escola Nome</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="form-group col-sm-12">
                                            <label for="idmaster">Endereço da Pesquisa:</label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text">minhaescola.izebanc.com.br/pesquisa/</span>
                                                </div>
                                                <input type="text" class="form-control formDataVer" id="urlpesqVer" name="urlpesqVer" disabled="">
                                            </div>
                                        </div>
                                    </div>
                                    <hr>
                                    <div id="formVerDados">
                                    </div>
                                </form>
                            </div>
                        </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modalEdit" style="display: none;" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-body">
                    <form action="" method="POST" id="formAlterPesq" >
                        <div class="card-header">
                            <div class="float-left">
                                <h4 class="modal-title">Editar Cadastro</h4>
                            </div>
                            <div class="float-right">
                                <td style="width: 100px">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal" onclick="modalEditF()">Cancelar</button>
                                </td>
                                <td style="width: 100px">
                                    <button type="button" class="btn btn-success" onclick="ModalConfAlter()">Salvar</button>
                                </td>
                            </div>
                        </div>
                        <div class="card-body">
                            <input type="text" class="form-control formDataEdit" id="idEdit" name="idEdit" style="display:none">
                            <div class="row">
                                @if(
                                    auth()->user()->nivel=='CEO'
                                )
                                    <div class="form-group col-sm-8">
                                        <label for="nomeEdit">Nome</label>
                                        <input type="text" class="form-control formDataEdit" id="nomeEdit" name="nomeEdit" placeholder="Nome">
                                    </div>
                                    <div class="form-group col-sm-4">
                                        <label for="idmasterEdit">Escola</label>
                                        <select name="idmasterEditSelect" id="idmasterEditSelect" class="form-control formDataEditSelect">
                                            <option name="idmasterEdit" class="formDataEdit" id="idmasterEdit" value="">Escola</option>
                                            @foreach($cadAdmasters as $cadAdmaster)
                                                <option value="{{$cadAdmaster->id}}">{{$cadAdmaster->nome ?? $cadAdmaster->fnome}}</option>
                                            @endforeach                       
                                        </select>
                                    </div>
                                    <div class="form-group col-sm-3">
                                    </div>
                                @else
                                    <div class="form-group col-sm-12">
                                        <label for="nomeEdit">Nome</label>
                                        <input type="text" class="form-control formDataEdit" id="nomeEdit" name="nomeEdit" placeholder="Nome">
                                    </div>
                                    <div class="form-group col-sm-4" style="display:none">
                                        <label for="idmasterEdit">Escola</label>
                                        <select name="idmasterEditSelect" id="idmasterEditSelect" class="form-control formDataEditSelect">
                                            <option name="idmasterEdit" class="formDataEdit" id="idmasterEdit" value="">Escola</option>
                                        </select>
                                    </div>
                                    
                                @endif
                            </div>
                            <div class="row">
                                <div class="form-group col-sm-12">
                                    <label for="idmaster">Endereço da Pesquisa:</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">minhaescola.izebanc.com.br/pesquisa/</span>
                                        </div>
                                        <input type="text" class="form-control formDataEdit" id="urlpesqEdit" name="urlpesqEdit">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modalDelConfirm" style="display: none;" aria-hidden="true">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Atenção!</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    Deseja realmente excluir esta Pesquisa?
                        <strong>id: </strong> <span id="idDel" class="dadosModalDel"></span></br>
                        <strong>Nome: </strong> <span id="NomeDel" class="dadosModalDel"></span></br>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal"  data-toggle="modal" data-target="#modalDelCancel">Cancelar</button>
                    <button type="button" class="btn btn-primary dadosModalDel" data-dismiss="modal">Sim, Excluir</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modalDelCancel" style="display: none;" aria-hidden="true">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Exclusão Cancelada!</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <strong>Operação Cancelada: </strong>Nenhum dado foi excluido.
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default float-right" data-dismiss="modal">OK</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modalDel" style="display: none;" aria-hidden="true">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Sucesso!</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    Pesquisa excluída com sucesso.
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default float-right" data-dismiss="modal">OK</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="ModalConfAlt" style="display: none;" aria-hidden="true">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Sucesso!</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    Dados Atualizados.
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default float-right" data-dismiss="modal" onclick="pageRefresh()">OK</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="ModalVazio" style="display: none;" aria-hidden="true">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Oops!</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    Nenhum dado a Atualizar.
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default float-right" data-dismiss="modal">OK</button>
                </div>
            </div>
        </div>
    </div>
    
    <div class="modal fade" id="modalAddPergunda" style="display: none;" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Adicionar Pergunta</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>Informe o tipo de Pergunta:</p>
                    <div class="form-group">
                        <div class="custom-control custom-radio"onclick="perguntaTipo(1)">
                            <input class="custom-control-input" type="radio" id="customRadio1" name="customRadio" checked="">
                            <label for="customRadio1" class="custom-control-label">Escolha Única</label>
                        </div>
                        <div class="custom-control custom-radio"onclick="perguntaTipo(2)">
                            <input class="custom-control-input" type="radio" id="customRadio2" name="customRadio" >
                            <label for="customRadio2" class="custom-control-label">Multipla Escola</label>
                        </div>
                        <div class="custom-control custom-radio"onclick="perguntaTipo(3)">
                            <input class="custom-control-input" type="radio" id="customRadio3" name="customRadio" >
                            <label for="customRadio3" class="custom-control-label">Sim/Não</label>
                        </div>
                        <div class="custom-control custom-radio"onclick="perguntaTipo(4)" style="display:none">
                            <input class="custom-control-input" type="radio" id="customRadio4" name="customRadio" >
                            <label for="customRadio4" class="custom-control-label">Resposta em Texto</label>
                        </div>
                        <div class="custom-control custom-radio"onclick="perguntaTipo(5)">
                            <input class="custom-control-input" type="radio" id="customRadio5" name="customRadio" >
                            <label for="customRadio5" class="custom-control-label">0 a 10</label>
                        </div>
                    </div>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal" data-toggle="modal" data-target="#modalAddPergundaCancelar">Cancelar</button>
                    <button type="button" class="btn btn-primary" id="botaoNewQuest" data-dismiss="modal" onclick="modalNewQuest(1)">Próximo >></button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modalAddPergundaEscolhaUnica" tabindex="-1" style="display: none;" aria-hidden="true" role="dialog" aria-labelledby="modalAddPergundaEscolhaUnica_Title">
        <div class="modal-dialog modal-dialog-scrollable modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <div class="float-left">
                        <h4 class="modal-title float-left" id="modalAddPergundaEscolhaUnica_Title">Adicionar Pergunta (Escolha Única)</h4>
                    </div>
                    <div class="float-right">
                        <button type="button" class="btn btn-default" data-dismiss="modal" data-toggle="modal" data-target="#modalAddPergundaCancelar">Cancelar</button>
                        <button type="button" class="btn btn-primary botaoNewQuest">Adicionar</button>
                    </div>
                </div>
                <div class="modal-body">
                    <form action="" id="formPergundaEscolhaUnica">
                        <div class="form-group">
                            <label>Enunciado:</label>
                            <textarea class="form-control EscolhaUnica" rows="3" placeholder="Enunciado ..."></textarea>
                            <div class="alert alert-danger dadosValidacao" style="display:none" role="alert">
                                Favor Preencher o Enunciado!
                            </div>
                        </div>
                        <label>N. de opções:</label>
                        <div class="form-group clearfix">
                            <div class="icheck-primary d-inline">
                                <input class="optsr" type="radio" id="radioPrimary1" name="r1" value="2" checked=""  onclick="numeroOpts(2)">
                                <label for="radioPrimary1">2</label>
                            </div>
                            <div class="icheck-primary d-inline">
                                <input class="optsr" type="radio" id="radioPrimary2" name="r1" value="3"  onclick="numeroOpts(3)">
                                <label for="radioPrimary2">3</label>
                            </div>
                            <div class="icheck-primary d-inline">
                                <input class="optsr" type="radio" id="radioPrimary3" name="r1" value="4"  onclick="numeroOpts(4)">
                                <label for="radioPrimary3">4</label>
                            </div>
                            <div class="icheck-primary d-inline">
                                <input class="optsr" type="radio" id="radioPrimary4" name="r1" value="5"  onclick="numeroOpts(5)">
                                <label for="radioPrimary4">5</label>
                            </div>

                        </div>
                        <label>Opções:</label>
                        <div class="form-group" multiple="" >
                            <div class="form-group">
                                <label for="opt1">Opção 1:</label>
                                <input type="text" class="form-control EscolhaUnica" id="opt1" placeholder="Opção 1">
                                <div class="alert alert-danger dadosValidacao" style="display:none" role="alert">
                                    Favor Preencher a Opção 1!
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="opt2">Opção 2:</label>
                                <input type="text" class="form-control EscolhaUnica" id="opt2" placeholder="Opção 2">
                                <div class="alert alert-danger dadosValidacao" style="display:none" role="alert">
                                    Favor Preencher a Opção 2!
                                </div>
                            </div>
                            <div class="form-group opts" style="display:none;">
                                <label for="opt3">Opção 3:</label>
                                <input type="text" class="form-control EscolhaUnica opcoes" id="opt3" placeholder="Opção 3">
                                <div class="alert alert-danger dadosValidacao" style="display:none" role="alert">
                                    Favor Preencher a Opção 3!
                                </div>
                            </div>
                            <div class="form-group opts" style="display:none;">
                                <label for="opt4">Opção 4:</label>
                                <input type="text" class="form-control EscolhaUnica opcoes" id="opt4" placeholder="Opção 4">
                                <div class="alert alert-danger dadosValidacao" style="display:none" role="alert">
                                    Favor Preencher a Opção 4!
                                </div>
                            </div>
                            <div class="form-group opts" style="display:none;">
                                <label for="opt5">Opção 5:</label>
                                <input type="text" class="form-control EscolhaUnica opcoes" id="opt5" placeholder="Opção 5">
                                <div class="alert alert-danger dadosValidacao" style="display:none" role="alert">
                                    Favor Preencher a Opção 5!
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modalAddPergundaMultiplaEscolha" tabindex="-1" style="display: none;" aria-hidden="true" role="dialog" aria-labelledby="modalAddPergundaMultiplaEscolha_Title">
        <div class="modal-dialog modal-dialog-scrollable modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <div class="float-left">
                        <h4 class="modal-title float-left" id="modalAddPergundaMultiplaEscolha_Title">Adicionar Pergunta (Multipla Escolha)</h4>
                    </div>
                    <div class="float-right">
                        <button type="button" class="btn btn-default" data-dismiss="modal" data-toggle="modal" data-target="#modalAddPergundaCancelar">Cancelar</button>
                        <button type="button" class="btn btn-primary botaoNewQuest">Adicionar</button>
                    </div>
                </div>
                <div class="modal-body">
                    <form action=""  id="formPergundaMultiplaEscolha">
                        <div class="form-group">
                            <label>Enunciado:</label>
                            <textarea class="form-control MultiplaEscolha" rows="3" placeholder="Enunciado ..."></textarea>
                            <div class="alert alert-danger dadosValidacaoME" style="display:none" role="alert">
                                Favor Preencher o Enunciado!
                            </div>
                        </div>
                        <label>N. de opções:</label>
                        <div class="form-group clearfix">
                            <div class="icheck-primary d-inline">
                                <input class="optsr" type="radio" id="radioPrimaryME1" name="r2" value="2" checked=""  onclick="numeroOpts(2)">
                                <label for="radioPrimaryME1">2</label>
                            </div>
                            <div class="icheck-primary d-inline">
                                <input class="optsr" type="radio" id="radioPrimaryME2" name="r2" value="3"  onclick="numeroOpts(3)">
                                <label for="radioPrimaryME2">3</label>
                            </div>
                            <div class="icheck-primary d-inline">
                                <input class="optsr" type="radio" id="radioPrimaryME3" name="r2" value="4"  onclick="numeroOpts(4)">
                                <label for="radioPrimaryME3">4</label>
                            </div>
                            <div class="icheck-primary d-inline">
                                <input class="optsr" type="radio" id="radioPrimaryME4" name="r2" value="5"  onclick="numeroOpts(5)">
                                <label for="radioPrimaryME4">5</label>
                            </div>

                        </div>
                        <label>Opções:</label>
                        <div class="form-group" multiple="" >
                            <div class="form-group">
                                <label for="optME1">Opção 1:</label>
                                <input type="text" class="form-control MultiplaEscolha" id="optME1" placeholder="Opção 1">
                                <div class="alert alert-danger dadosValidacaoME" style="display:none" role="alert">
                                    Favor Preencher a Opção 1!
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="optME2">Opção 2:</label>
                                <input type="text" class="form-control MultiplaEscolha" id="optME2" placeholder="Opção 2">
                                <div class="alert alert-danger dadosValidacaoME" style="display:none" role="alert">
                                    Favor Preencher a Opção 2!
                                </div>
                            </div>
                            <div class="form-group opts" style="display:none;">
                                <label for="optME3">Opção 3:</label>
                                <input type="text" class="form-control MultiplaEscolha opcoes" id="optME3" placeholder="Opção 3">
                                <div class="alert alert-danger dadosValidacaoME" style="display:none" role="alert">
                                    Favor Preencher a Opção 3!
                                </div>
                            </div>
                            <div class="form-group opts" style="display:none;">
                                <label for="optME4">Opção 4:</label>
                                <input type="text" class="form-control MultiplaEscolha opcoes" id="optME4" placeholder="Opção 4">
                                <div class="alert alert-danger dadosValidacaoME" style="display:none" role="alert">
                                    Favor Preencher a Opção 4!
                                </div>
                            </div>
                            <div class="form-group opts" style="display:none;">
                                <label for="optME5">Opção 5:</label>
                                <input type="text" class="form-control MultiplaEscolha opcoes" id="optME5" placeholder="Opção 5">
                                <div class="alert alert-danger dadosValidacaoME" style="display:none" role="alert">
                                    Favor Preencher a Opção 5!
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modalAddPergundaSN" tabindex="-1" style="display: none;" aria-hidden="true" role="dialog" aria-labelledby="modalAddPergundaSN_Title">
        <div class="modal-dialog modal-dialog-scrollable modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <div class="float-left">
                        <h4 class="modal-title float-left" id="modalAddPergundaSN_Title">Adicionar Pergunta (Sim/Não)</h4>
                    </div>
                    <div class="float-right">
                        <button type="button" class="btn btn-default" data-dismiss="modal" data-toggle="modal" data-target="#modalAddPergundaCancelar">Cancelar</button>
                        <button type="button" class="btn btn-primary botaoNewQuest">Adicionar</button>
                    </div>
                </div>
                <div class="modal-body">
                    <form action="" id="formPergundaSN">
                        <div class="form-group">
                            <label>Enunciado:</label>
                            <textarea class="form-control EnunciadoSN" rows="3" placeholder="Enunciado ..."></textarea>
                            <div class="alert alert-danger dadosValidacaoSN" style="display:none" role="alert">
                                Favor Preencher o Enunciado!
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modalAddPergundaRespTexto" tabindex="-1" style="display: none;" aria-hidden="true" role="dialog" aria-labelledby="modalAddPergundaRespTexto_Title">
        <div class="modal-dialog modal-dialog-scrollable modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <div class="float-left">
                        <h4 class="modal-title float-left" id="modalAddPergundaRespTexto_Title">Adicionar Pergunta (Resposta em Texto)</h4>
                    </div>
                    <div class="float-right">
                        <button type="button" class="btn btn-default" data-dismiss="modal" data-toggle="modal" data-target="#modalAddPergundaCancelar">Cancelar</button>
                        <button type="button" class="btn btn-primary botaoNewQuest">Adicionar</button>
                    </div>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label>Enunciado:</label>
                        <textarea class="form-control" rows="3" placeholder="Enunciado ..."></textarea>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="modal fade" id="modalAddPergunda0a10" tabindex="-1" style="display: none;" aria-hidden="true" role="dialog" aria-labelledby="modalAddPergunda0a10_Title">
        <div class="modal-dialog modal-dialog-scrollable modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <div class="float-left">
                        <h4 class="modal-title float-left" id="modalAddPergunda0a10_Title">Adicionar Pergunta (Escala de Zero a Dez)</h4>
                    </div>
                    <div class="float-right">
                        <button type="button" class="btn btn-default" data-dismiss="modal" data-toggle="modal" data-target="#modalAddPergundaCancelar">Cancelar</button>
                        <button type="button" class="btn btn-primary botaoNewQuest">Adicionar</button>
                    </div>
                </div>
                <div class="modal-body">
                    <form action="" id="formPergundaZD">
                        <div class="form-group">
                            <label>Enunciado:</label>
                            <textarea class="form-control EnunciadoZD" rows="3" placeholder="Enunciado ..."></textarea>
                            <div class="alert alert-danger dadosValidacaoZD" style="display:none" role="alert">
                                Favor Preencher o Enunciado!
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modalAddPergundaCancelar" style="display: none;" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Operação Cancelada</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    Nenhuma Pergunta foi adicionada a sua pesquisa.
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default float-right" data-dismiss="modal">Ok</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modalAddPergundaSuccess" style="display: none;" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Concluido!</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    Pergunta adicionada.
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default float-right" data-dismiss="modal">Ok</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modalEditPergundaEscolhaUnica" tabindex="-1" style="display: none;" aria-hidden="true" role="dialog" aria-labelledby="modalEditPergundaEscolhaUnica_Title">
        <div class="modal-dialog modal-dialog-scrollable modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <div class="float-left">
                        <h4 class="modal-title float-left" id="modalEditPergundaEscolhaUnica_Title">Editar Pergunta (Escolha Única)</h4>
                    </div>
                    <div class="float-right">
                        <button type="button" class="btn btn-default" data-dismiss="modal" data-toggle="modal" data-target="#modalEditPergundaCancelar">Cancelar</button>
                        <button type="button" class="btn btn-primary botaoEditQuest">Salvar Alterações</button>
                    </div>
                </div>
                <div class="modal-body">
                    <form action="" id="formPergundaEscolhaUnicaEdit">
                        <div class="form-group">
                            <label>Enunciado:</label>
                            <textarea id="enunciadoEditPerguntaEU" class="form-control EscolhaUnicaEdit" rows="3" placeholder="Enunciado ..."></textarea>
                            <div class="alert alert-danger dadosValidacao" style="display:none" role="alert">
                                Favor Preencher o Enunciado!
                            </div>
                        </div>
                        <label>N. de opções:</label>
                        <div class="form-group clearfix">
                            <div class="icheck-primary d-inline">
                                <input class="optsr" type="radio" id="radioPrimary1" name="r3" value="2" checked=""  onclick="numeroOpts(2)">
                                <label for="radioPrimary1">2</label>
                            </div>
                            <div class="icheck-primary d-inline">
                                <input class="optsr" type="radio" id="radioPrimary2" name="r3" value="3"  onclick="numeroOpts(3)">
                                <label for="radioPrimary2">3</label>
                            </div>
                            <div class="icheck-primary d-inline">
                                <input class="optsr" type="radio" id="radioPrimary3" name="r3" value="4"  onclick="numeroOpts(4)">
                                <label for="radioPrimary3">4</label>
                            </div>
                            <div class="icheck-primary d-inline">
                                <input class="optsr" type="radio" id="radioPrimary4" name="r3" value="5"  onclick="numeroOpts(5)">
                                <label for="radioPrimary4">5</label>
                            </div>

                        </div>
                        <label>Opções:</label>
                        <div class="form-group" multiple="" >
                            <div class="form-group">
                                <label for="opt1">Opção 1:</label>
                                <input type="text" class="form-control EscolhaUnicaEdit EscolhaUnicaEditOpt" id="opt1" placeholder="Opção 1">
                                <div class="alert alert-danger dadosValidacao" style="display:none" role="alert">
                                    Favor Preencher a Opção 1!
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="opt2">Opção 2:</label>
                                <input type="text" class="form-control EscolhaUnicaEdit EscolhaUnicaEditOpt" id="opt2" placeholder="Opção 2">
                                <div class="alert alert-danger dadosValidacao" style="display:none" role="alert">
                                    Favor Preencher a Opção 2!
                                </div>
                            </div>
                            <div class="form-group opts" style="display:none;">
                                <label for="opt3">Opção 3:</label>
                                <input type="text" class="form-control EscolhaUnicaEdit EscolhaUnicaEditOpt opcoes" id="opt3" placeholder="Opção 3">
                                <div class="alert alert-danger dadosValidacao" style="display:none" role="alert">
                                    Favor Preencher a Opção 3!
                                </div>
                            </div>
                            <div class="form-group opts" style="display:none;">
                                <label for="opt4">Opção 4:</label>
                                <input type="text" class="form-control EscolhaUnicaEdit EscolhaUnicaEditOpt opcoes" id="opt4" placeholder="Opção 4">
                                <div class="alert alert-danger dadosValidacao" style="display:none" role="alert">
                                    Favor Preencher a Opção 4!
                                </div>
                            </div>
                            <div class="form-group opts" style="display:none;">
                                <label for="opt5">Opção 5:</label>
                                <input type="text" class="form-control EscolhaUnicaEdit EscolhaUnicaEditOpt opcoes" id="opt5" placeholder="Opção 5">
                                <div class="alert alert-danger dadosValidacao" style="display:none" role="alert">
                                    Favor Preencher a Opção 5!
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modalEditPergundaMultiplaEscolha" tabindex="-1" style="display: none;" aria-hidden="true" role="dialog" aria-labelledby="modalEditPergundaMultiplaEscolha_Title">
        <div class="modal-dialog modal-dialog-scrollable modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <div class="float-left">
                        <h4 class="modal-title float-left" id="modalEditPergundaMultiplaEscolha_Title">Editar Pergunta (Multipla Escolha)</h4>
                    </div>
                    <div class="float-right">
                        <button type="button" class="btn btn-default" data-dismiss="modal" data-toggle="modal" data-target="#modalEditPergundaCancelar">Cancelar</button>
                        <button type="button" class="btn btn-primary botaoEditQuest">Salvar Alterações</button>
                    </div>
                </div>
                <div class="modal-body">
                    <form action=""  id="formPergundaMultiplaEscolhaEdit">
                        <div class="form-group">
                            <label>Enunciado:</label>
                            <textarea id="enunciadoEditPerguntaME" class="form-control MultiplaEscolhaEdit" rows="3" placeholder="Enunciado ..."></textarea>
                            <div class="alert alert-danger dadosValidacaoME" style="display:none" role="alert">
                                Favor Preencher o Enunciado!
                            </div>
                        </div>
                        <label>N. de opções:</label>
                        <div class="form-group clearfix">
                            <div class="icheck-primary d-inline">
                                <input class="optsr" type="radio" id="radioPrimaryME1" name="r4" value="2" checked=""  onclick="numeroOpts(2)">
                                <label for="radioPrimaryME1">2</label>
                            </div>
                            <div class="icheck-primary d-inline">
                                <input class="optsr" type="radio" id="radioPrimaryME2" name="r4" value="3"  onclick="numeroOpts(3)">
                                <label for="radioPrimaryME2">3</label>
                            </div>
                            <div class="icheck-primary d-inline">
                                <input class="optsr" type="radio" id="radioPrimaryME3" name="r4" value="4"  onclick="numeroOpts(4)">
                                <label for="radioPrimaryME3">4</label>
                            </div>
                            <div class="icheck-primary d-inline">
                                <input class="optsr" type="radio" id="radioPrimaryME4" name="r4" value="5"  onclick="numeroOpts(5)">
                                <label for="radioPrimaryME4">5</label>
                            </div>

                        </div>
                        <label>Opções:</label>
                        <div class="form-group" multiple="" >
                            <div class="form-group">
                                <label for="optME1">Opção 1:</label>
                                <input type="text" class="form-control MultiplaEscolhaEdit multiplaEscolhaEditOpt" id="optME1" placeholder="Opção 1">
                                <div class="alert alert-danger dadosValidacaoME" style="display:none" role="alert">
                                    Favor Preencher a Opção 1!
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="optME2">Opção 2:</label>
                                <input type="text" class="form-control MultiplaEscolhaEdit multiplaEscolhaEditOpt" id="optME2" placeholder="Opção 2">
                                <div class="alert alert-danger dadosValidacaoME" style="display:none" role="alert">
                                    Favor Preencher a Opção 2!
                                </div>
                            </div>
                            <div class="form-group opts" style="display:none;">
                                <label for="optME3">Opção 3:</label>
                                <input type="text" class="form-control MultiplaEscolhaEdit multiplaEscolhaEditOpt opcoes" id="optME3" placeholder="Opção 3">
                                <div class="alert alert-danger dadosValidacaoME" style="display:none" role="alert">
                                    Favor Preencher a Opção 3!
                                </div>
                            </div>
                            <div class="form-group opts" style="display:none;">
                                <label for="optME4">Opção 4:</label>
                                <input type="text" class="form-control MultiplaEscolhaEdit multiplaEscolhaEditOpt opcoes" id="optME4" placeholder="Opção 4">
                                <div class="alert alert-danger dadosValidacaoME" style="display:none" role="alert">
                                    Favor Preencher a Opção 4!
                                </div>
                            </div>
                            <div class="form-group opts" style="display:none;">
                                <label for="optME5">Opção 5:</label>
                                <input type="text" class="form-control MultiplaEscolhaEdit multiplaEscolhaEditOpt opcoes" id="optME5" placeholder="Opção 5">
                                <div class="alert alert-danger dadosValidacaoME" style="display:none" role="alert">
                                    Favor Preencher a Opção 5!
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modalEditPergundaSN" tabindex="-1" style="display: none;" aria-hidden="true" role="dialog" aria-labelledby="modalEditPergundaSN_Title">
        <div class="modal-dialog modal-dialog-scrollable modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <div class="float-left">
                        <h4 class="modal-title float-left" id="modalEditPergundaSN_Title">Editar Pergunta (Sim/Não)</h4>
                    </div>
                    <div class="float-right">
                        <button type="button" class="btn btn-default" data-dismiss="modal" data-toggle="modal" data-target="#modalEditPergundaCancelar">Cancelar</button>
                        <button type="button" class="btn btn-primary botaoEditQuest">Salvar Alterações</button>
                    </div>
                </div>
                <div class="modal-body">
                    <form action="" id="formPergundaSNEdit">
                        <div class="form-group">
                            <label>Enunciado:</label>
                            <textarea id="enunciadoEditPerguntaSN" class="form-control EnunciadoSN" rows="3" placeholder="Enunciado ..."></textarea>
                            <div class="alert alert-danger dadosValidacaoSN" style="display:none" role="alert">
                                Favor Preencher o Enunciado!
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modalEditPergunda0a10" tabindex="-1" style="display: none;" aria-hidden="true" role="dialog" aria-labelledby="modalEditPergunda0a10_Title">
        <div class="modal-dialog modal-dialog-scrollable modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <div class="float-left">
                        <h4 class="modal-title float-left" id="modalEditPergunda0a10_Title">Editar Pergunta (Escala de Zero a Dez)</h4>
                    </div>
                    <div class="float-right">
                        <button type="button" class="btn btn-default" data-dismiss="modal" data-toggle="modal" data-target="#modalEditPergundaCancelar">Cancelar</button>
                        <button type="button" class="btn btn-primary botaoEditQuest">Salvar Alterações</button>
                    </div>
                </div>
                <div class="modal-body">
                    <form action="" id="formPergundaZDEdit">
                        <div class="form-group">
                            <label>Enunciado:</label>
                            <textarea id="enunciadoEditPerguntaZD" class="form-control EnunciadoZD" rows="3" placeholder="Enunciado ..."></textarea>
                            <div class="alert alert-danger dadosValidacaoZD" style="display:none" role="alert">
                                Favor Preencher o Enunciado!
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modalEditPergundaCancelar" style="display: none;" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Operação Cancelada</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    Nenhuma Pergunta foi Alterada em sua pesquisa.
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default float-right" data-dismiss="modal">Ok</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modalDelPergunda" style="display: none;" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <div class="float-left">
                        <h4 class="modal-title">Atenção!</h4>
                    </div>
                    <div class="float-right">
                        <button type="button" id="btnDelConf" class="btn btn-danger float-right" style="margin-left:5px;">Sim, Excluir</button>
                        <button type="button" class="btn btn-secondary float-right" data-dismiss="modal" data-toggle="modal" data-target="#modalDelPergundaCancelar">Cancelar</button>
                    </div>
                </div>
                <div class="modal-body">
                    <h4>Deseja realmente excluir a pergunta a seguir?</h4>
                    <p>dados da pergunta:</p>
                    <hr>
                    <div id="divperguntaDelSN" class="divperguntaDel">
                        <h5 id="enunciadoDelSN">Enunciado: SN</h5>
                        <div class="form-group">
                            <div class="form-check">
                                <input class="form-check-input" type="radio" disabled="">
                                <label class="form-check-label">SIM</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" disabled="">
                                <label class="form-check-label">NÂO</label>
                            </div>
                        </div>
                    </div>
                    <div id="divperguntaDelZD"  class="divperguntaDel">
                        <h5 id="enunciadoDelZD">Enunciado: ZD</h5>
                        <div class="form-group">
                            <div class="form-check">
                                <input class="form-check-input" type="radio" disabled="">
                                <label class="form-check-label">0</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" disabled="">
                                <label class="form-check-label">1</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" disabled="">
                                <label class="form-check-label">2</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" disabled="">
                                <label class="form-check-label">3</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" disabled="">
                                <label class="form-check-label">4</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" disabled="">
                                <label class="form-check-label">5</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" disabled="">
                                <label class="form-check-label">6</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" disabled="">
                                <label class="form-check-label">7</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" disabled="">
                                <label class="form-check-label">8</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" disabled="">
                                <label class="form-check-label">9</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" disabled="">
                                <label class="form-check-label">10</label>
                            </div>
                        </div>
                    </div>
                    <div id="divperguntaDelME"  class="divperguntaDel">
                        <h5 id="enunciadoDelME">Enunciado: ME</h5>
                        <div class="form-group">
                            <div class="custom-control custom-checkbox optDelME">
                                <input id="customCheckbox1" class="custom-control-input" type="checkbox" disabled="">
                                <label class="custom-control-label">123</label>
                            </div>
                            <div class="custom-control custom-checkbox optDelME">
                                <input id="customCheckbox1" class="custom-control-input" type="checkbox" disabled="">
                                <label class="custom-control-label">123</label>
                            </div>
                            <div class="custom-control custom-checkbox optDelME">
                                <input id="customCheckbox1" class="custom-control-input" type="checkbox" disabled="">
                                <label class="custom-control-label">123</label>
                            </div>
                            <div class="custom-control custom-checkbox optDelME">
                                <input id="customCheckbox1" class="custom-control-input" type="checkbox" disabled="">
                                <label class="custom-control-label">123</label>
                            </div>
                            <div class="custom-control custom-checkbox optDelME">
                                <input id="customCheckbox1" class="custom-control-input" type="checkbox" disabled="">
                                <label class="custom-control-label">123</label>
                            </div>
                        </div>
                    </div>
                    <div id="divperguntaDelEU"  class="divperguntaDel">
                        <h5 id="enunciadoDelEU">Enunciado: EU</h5>
                        <div class="form-group">
                            <div class="form-check optDelEU">
                                <input class="form-check-input" type="radio" disabled="">
                                <label class="form-check-label">1231</label>
                            </div>
                            <div class="form-check optDelEU">
                                <input class="form-check-input" type="radio" disabled="">
                                <label class="form-check-label">1231</label>
                            </div>
                            <div class="form-check optDelEU">
                                <input class="form-check-input" type="radio" disabled="">
                                <label class="form-check-label">1231</label>
                            </div>
                            <div class="form-check optDelEU">
                                <input class="form-check-input" type="radio" disabled="">
                                <label class="form-check-label">1231</label>
                            </div>
                            <div class="form-check optDelEU">
                                <input class="form-check-input" type="radio" disabled="">
                                <label class="form-check-label">1231</label>
                            </div>
                        </div>
                    </div>
                    <hr>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modalDelPergundaCancelar" style="display: none;" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Operação Cancelada</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    Nenhuma Pergunta foi Alterada em sua pesquisa.
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default float-right" data-dismiss="modal">Ok</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modalDelPergundaSuccess" style="display: none;" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Concluido!</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    Pergunta excluída com sucesso.
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default float-right" data-dismiss="modal">Ok</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="ModalConfAltQuest" style="display: none;" aria-hidden="true">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Sucesso!</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    Dados Atualizados.
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default float-right" data-dismiss="modal">OK</button>
                </div>
            </div>
        </div>
    </div>

@stop

@section('footer')
    <div class="float-right d-none d-sm-block">
      <b>Version</b> 1.0.0
    </div>
    <center>Desenvolvido por - <strong>JL Empreendimento LTDA</strong> </center>
@stop

@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
    <link rel="stylesheet" href="/vendor/sweetalert2/bootstrap-4.min.css">
@stop

@section('js')

    <!--Start of Tawk.to Script-->
    <script type="text/javascript">
    var Tawk_API=Tawk_API||{}, Tawk_LoadStart=new Date();
    (function(){
    var s1=document.createElement("script"),s0=document.getElementsByTagName("script")[0];
    s1.async=true;
    s1.src='https://embed.tawk.to/5d1fdbc322d70e36c2a460b3/default';
    s1.charset='UTF-8';
    s1.setAttribute('crossorigin','*');
    s0.parentNode.insertBefore(s1,s0);
    })();
    </script>
    <!--End of Tawk.to Script-->  


    <script src="/vendor/sweetalert2/sweetalert2.min.js"></script>
    <script src=
    "/vendor/jqueryMask/jquery.mask.min.js"></script>
    <script>
        
        function numeroOpts(num){
            dadosValidacao = document.getElementsByClassName('dadosValidacao');
            dadosValidacao[0].style = "display:none";
            dadosValidacao[1].style = "display:none";
            dadosValidacao[2].style = "display:none";
            dadosValidacao[3].style = "display:none";
            dadosValidacao[4].style = "display:none";
            dadosValidacao[5].style = "display:none";
            dadosValidacaoME = document.getElementsByClassName('dadosValidacaoME');
            dadosValidacaoME[0].style = "display:none";
            dadosValidacaoME[1].style = "display:none";
            dadosValidacaoME[2].style = "display:none";
            dadosValidacaoME[3].style = "display:none";
            dadosValidacaoME[4].style = "display:none";
            dadosValidacaoME[5].style = "display:none";
            dadosValidacaoSN = document.getElementsByClassName('dadosValidacaoSN');
            dadosValidacaoSN[0].style = "display:none";
            dadosValidacaoZD = document.getElementsByClassName('dadosValidacaoZD');
            dadosValidacaoZD[0].style = "display:none";
            var opts = document.getElementsByClassName('opts'),
            optsr = document.getElementsByClassName('optsr');
            switch(true){
                case num == 2:
                    optsr[0].checked = true;
                    optsr[1].checked = false;
                    optsr[2].checked = false;
                    optsr[3].checked = false;
                    optsr[4].checked = true;
                    optsr[5].checked = false;
                    optsr[6].checked = false;
                    optsr[7].checked = false;
                    optsr[8].checked = true;
                    optsr[9].checked = false;
                    optsr[10].checked = false;
                    optsr[11].checked = false;
                    optsr[12].checked = true;
                    optsr[13].checked = false;
                    optsr[14].checked = false;
                    optsr[15].checked = false;
                    opts[0].style = "display:none";
                    opts[1].style = "display:none";
                    opts[2].style = "display:none";
                    opts[3].style = "display:none";
                    opts[4].style = "display:none";
                    opts[5].style = "display:none";
                    opts[6].style = "display:none";
                    opts[7].style = "display:none";
                    opts[8].style = "display:none";
                    opts[9].style = "display:none";
                    opts[10].style = "display:none";
                    opts[11].style = "display:none";
                   
                    var opcoes = document.getElementsByClassName('opcoes');
                    opcoes[0].value = null;
                    opcoes[1].value = null;
                    opcoes[2].value = null;
                    opcoes[3].value = null;
                    opcoes[4].value = null;
                    opcoes[5].value = null;
                break;
                case num == 3:
                    optsr[0].checked = false;
                    optsr[1].checked = true;
                    optsr[2].checked = false;
                    optsr[3].checked = false;
                    optsr[4].checked = false;
                    optsr[5].checked = true;
                    optsr[6].checked = false;
                    optsr[7].checked = false;
                    optsr[8].checked = false;
                    optsr[9].checked = true;
                    optsr[10].checked = false;
                    optsr[11].checked = false;
                    optsr[12].checked = false;
                    optsr[13].checked = true;
                    optsr[14].checked = false;
                    optsr[15].checked = false;
                    opts[0].style = "display:block";
                    opts[1].style = "display:none";
                    opts[2].style = "display:none";
                    opts[3].style = "display:block";
                    opts[4].style = "display:none";
                    opts[5].style = "display:none";
                    opts[6].style = "display:block";
                    opts[7].style = "display:none";
                    opts[8].style = "display:none";
                    opts[9].style = "display:block";
                    opts[10].style = "display:none";
                    opts[11].style = "display:none";

                    var opcoes = document.getElementsByClassName('opcoes');
                    opcoes[1].value = null;
                    opcoes[2].value = null;
                    opcoes[4].value = null;
                    opcoes[5].value = null;
                break;
                case num == 4:
                    optsr[0].checked = false;
                    optsr[1].checked = false;
                    optsr[2].checked = true;
                    optsr[3].checked = false;
                    optsr[4].checked = false;
                    optsr[5].checked = false;
                    optsr[6].checked = true;
                    optsr[7].checked = false;
                    optsr[8].checked = false;
                    optsr[9].checked = false;
                    optsr[10].checked = true;
                    optsr[11].checked = false;
                    optsr[12].checked = false;
                    optsr[13].checked = false;
                    optsr[14].checked = true;
                    optsr[15].checked = false;
                    opts[0].style = "display:block";
                    opts[1].style = "display:block";
                    opts[2].style = "display:none";
                    opts[3].style = "display:block";
                    opts[4].style = "display:block";
                    opts[5].style = "display:none";
                    opts[6].style = "display:block";
                    opts[7].style = "display:block";
                    opts[8].style = "display:none";
                    opts[9].style = "display:block";
                    opts[10].style = "display:block";
                    opts[11].style = "display:none";

                    var opcoes = document.getElementsByClassName('opcoes');
                    opcoes[2].value = null;
                    opcoes[5].value = null;
                break;
                case num == 5:
                    optsr[0].checked = false;
                    optsr[1].checked = false;
                    optsr[2].checked = false;
                    optsr[3].checked = true;
                    optsr[4].checked = false;
                    optsr[5].checked = false;
                    optsr[6].checked = false;
                    optsr[7].checked = true;
                    optsr[8].checked = false;
                    optsr[9].checked = false;
                    optsr[10].checked = false;
                    optsr[11].checked = true;
                    optsr[12].checked = false;
                    optsr[13].checked = false;
                    optsr[14].checked = false;
                    optsr[15].checked = true;
                    opts[0].style = "display:block";
                    opts[1].style = "display:block";
                    opts[2].style = "display:block";
                    opts[3].style = "display:block";
                    opts[4].style = "display:block";
                    opts[5].style = "display:block";
                    opts[6].style = "display:block";
                    opts[7].style = "display:block";
                    opts[8].style = "display:block";
                    opts[9].style = "display:block";
                    opts[10].style = "display:block";
                    opts[11].style = "display:block";
                break;
            }
        } 

        function formSubmit (){
            nome = document.getElementsByClassName('formData').nome.value,
            idmaster = document.getElementsByClassName('formData').idmaster.value;        
            url = document.getElementsByClassName('formData').urlpesq.value;
            $.ajax({
                type: "POST",
                url: "{{ route('cadastros.pesquisa.insert') }}",
                data: {
                    _token:'{{csrf_token()}}',
                    nome,
                    idmaster,
                    url,
                },
                success: function(retorno){
                    toasts = document.getElementById('toastsContainerTopRight');
                    if(toasts != null){
                        toasts.remove();
                    }
                    
                    const Toast = Swal.mixin({
                        toast: true,
                        position: 'top-center',
                        showConfirmButton: true
                    });

                    if(retorno['status'] == 'error'){
                        retorno[0].forEach(
                            function mensagem(msg){
                                $(document).Toasts(
                                    'create', {
                                    class: 'bg-danger', 
                                    title: '',
                                    subtitle: 'Subtitle',
                                    body: msg
                                    }
                                )
                            }
                        )
                    }else{
                        $('#modalSuccessCadastro').modal('show');
                        $('#formCadastro').each (function(){
                            this.reset();
                        });
                        pessoaAlter(pessoa);
                    }
                },
                error: function(error){
                    console.log(error);
                }
            });
            
            return false;

        }
        
        function resetForm(){
            $('#formCadastro').each (function(){
                this.reset();
            });
            pessoaAlter(pessoa);
        }

        function pageRefresh(){
            window.location.href = "{{route('cadastros.pesquisa')}}";
        }

        function resetFormsEdit(){
            $('#formPergundaEscolhaUnicaEdit').each (function(){
                this.reset();
            });
            $('#formPergundaMultiplaEscolhaEdit').each (function(){
                this.reset();
            });
            $('#formPergundaSNEdit').each (function(){
                this.reset();
            });
            $('#formPergundaZDEdit').each (function(){
                this.reset();
            });
        }

        function modalEditQuest(tipo, id){
            switch(tipo){
                case 'EU':
                    var enunciado = document.getElementById('enunciadoEditPerguntaEU').value,
                    qtdOps = $("input[name='r3']:checked").val(),
                    EscolhaUnicaEditOpts = document.getElementsByClassName('EscolhaUnicaEditOpt'),
                    op_1 = EscolhaUnicaEditOpts[0].value,
                    op_2 = EscolhaUnicaEditOpts[1].value,
                    op_3 = EscolhaUnicaEditOpts[2].value,
                    op_4 = EscolhaUnicaEditOpts[3].value,
                    op_5 = EscolhaUnicaEditOpts[4].value;
                    $.ajax({
                        url:'{{ route("cadastros.pesquisa.quest.update") }}',
                        type:'post',
                        datatype:'json',
                        data:{
                            _token:"{{ csrf_token() }}",
                            tipo,
                            id,
                            enunciado,
                            qtdOps,
                            op_1,
                            op_2,
                            op_3,
                            op_4,
                            op_5,
                        },
                        success:function(retorno){
                            if(retorno['status'] == 'vazio'){
                                $('#ModalVazio').css('z-index', 3000);
                                $('#ModalVazio').modal('show');
                            }else{
                                modalDados(retorno[0].idpesq);
                                $('#modalEditPergundaEscolhaUnica').modal('hide');
                                $('#ModalConfAltQuest').modal('show');
                            }
                        },
                    });
                break;
                case 'ME':
                    enunciado = document.getElementById('enunciadoEditPerguntaME').value;
                    qtdOps = $("input[name='r4']:checked").val();
                    multiplaEscolhaEditOpt = document.getElementsByClassName('multiplaEscolhaEditOpt');
                    op_1 = multiplaEscolhaEditOpt[0].value,
                    op_2 = multiplaEscolhaEditOpt[1].value,
                    op_3 = multiplaEscolhaEditOpt[2].value,
                    op_4 = multiplaEscolhaEditOpt[3].value,
                    op_5 = multiplaEscolhaEditOpt[4].value;
                    $.ajax({
                        url:'{{ route("cadastros.pesquisa.quest.update") }}',
                        type:'post',
                        datatype:'json',
                        data:{
                            _token:"{{ csrf_token() }}",
                            tipo,
                            id,
                            enunciado,
                            qtdOps,
                            op_1,
                            op_2,
                            op_3,
                            op_4,
                            op_5,
                        },
                        success:function(retorno){
                            if(retorno['status'] == 'vazio'){
                                $('#ModalVazio').css('z-index', 3000);
                                $('#ModalVazio').modal('show');
                            }else{
                                modalDados(retorno[0].idpesq);
                                $('#modalEditPergundaMultiplaEscolha').modal('hide');
                                $('#ModalConfAltQuest').modal('show');
                            }
                        },
                    });
                break;
                case 'SN':
                    enunciado = document.getElementById('enunciadoEditPerguntaSN').value;
                    $.ajax({
                        url:'{{ route("cadastros.pesquisa.quest.update") }}',
                        type:'post',
                        datatype:'json',
                        data:{
                            _token:"{{ csrf_token() }}",
                            tipo,
                            id,
                            enunciado,
                        },
                        success:function(retorno){
                            if(retorno['status'] == 'vazio'){
                                $('#ModalVazio').css('z-index', 3000);
                                $('#ModalVazio').modal('show');
                            }else{
                                modalDados(retorno[0].idpesq);
                                $('#modalEditPergundaSN').modal('hide');
                                $('#ModalConfAltQuest').modal('show');
                            }
                        },
                    });
                break;
                case 'ZD':
                    enunciado = document.getElementById('enunciadoEditPerguntaZD').value;
                    $.ajax({
                        url:'{{ route("cadastros.pesquisa.quest.update") }}',
                        type:'post',
                        datatype:'json',
                        data:{
                            _token:"{{ csrf_token() }}",
                            tipo,
                            id,
                            enunciado,
                        },
                        success:function(retorno){
                            if(retorno['status'] == 'vazio'){
                                $('#ModalVazio').css('z-index', 3000);
                                $('#ModalVazio').modal('show');
                            }else{
                                modalDados(retorno[0].idpesq);
                                $('#modalEditPergunda0a10').modal('hide');
                                $('#ModalConfAltQuest').modal('show');
                            }
                        },
                    });
                break;
            }
        }

        function editarQuest(questipo, questnum, id){
            resetFormsEdit();
            $.ajax({
                url:"{{ route('cadastros.pesquisa.quest.get') }}",
                type:"post",
                datatype:"json",
                data:{
                    _token:"{{ csrf_token() }}",
                    id,
                    questnum,
                },
                success:function(retorno){
                    btnsEditQuest = document.getElementsByClassName('botaoEditQuest');
                    switch(questipo){
                        case 'EU':
                            enunciadoEditPerguntaEU = document.getElementById('enunciadoEditPerguntaEU');
                            enunciadoEditPerguntaEU.placeholder = retorno[0].enunciado;
                            var EscolhaUnicaEditOpt = document.getElementsByClassName('EscolhaUnicaEditOpt');
                            switch(retorno[0].qtdOps){
                                case 2:
                                    numeroOpts(2);
                                    EscolhaUnicaEditOpt[0].placeholder = retorno[0].op_1;
                                    EscolhaUnicaEditOpt[1].placeholder = retorno[0].op_2;
                                break;
                                case 3:
                                    numeroOpts(3);
                                    EscolhaUnicaEditOpt[0].placeholder = retorno[0].op_1;
                                    EscolhaUnicaEditOpt[1].placeholder = retorno[0].op_2;
                                    EscolhaUnicaEditOpt[2].placeholder = retorno[0].op_3;
                                break;
                                case 4:
                                    numeroOpts(4);
                                    EscolhaUnicaEditOpt[0].placeholder = retorno[0].op_1;
                                    EscolhaUnicaEditOpt[1].placeholder = retorno[0].op_2;
                                    EscolhaUnicaEditOpt[2].placeholder = retorno[0].op_3;
                                    EscolhaUnicaEditOpt[3].placeholder = retorno[0].op_4;
                                break;
                                case 5:
                                    numeroOpts(5);
                                    EscolhaUnicaEditOpt[0].placeholder = retorno[0].op_1;
                                    EscolhaUnicaEditOpt[1].placeholder = retorno[0].op_2;
                                    EscolhaUnicaEditOpt[2].placeholder = retorno[0].op_3;
                                    EscolhaUnicaEditOpt[3].placeholder = retorno[0].op_4;
                                    EscolhaUnicaEditOpt[4].placeholder = retorno[0].op_5;
                                break;
                            }
                            btnsEditQuest[0].onclick = function(){
                                return modalEditQuest('EU', retorno[0].id);
                            };
                            $('#modalEditPergundaEscolhaUnica').modal('show');
                        break;
                        case 'ME':
                            enunciadoEditPerguntaME = document.getElementById('enunciadoEditPerguntaME');
                            enunciadoEditPerguntaME.placeholder = retorno[0].enunciado;
                            var multiplaEscolhaEditOpt = document.getElementsByClassName('multiplaEscolhaEditOpt');
                            switch(retorno[0].qtdOps){
                                case 2:
                                    numeroOpts(2);
                                    multiplaEscolhaEditOpt[0].placeholder = retorno[0].op_1;
                                    multiplaEscolhaEditOpt[1].placeholder = retorno[0].op_2;
                                break;
                                case 3:
                                    numeroOpts(3);
                                    multiplaEscolhaEditOpt[0].placeholder = retorno[0].op_1;
                                    multiplaEscolhaEditOpt[1].placeholder = retorno[0].op_2;
                                    multiplaEscolhaEditOpt[2].placeholder = retorno[0].op_3;
                                break;
                                case 4:
                                    numeroOpts(4);
                                    multiplaEscolhaEditOpt[0].placeholder = retorno[0].op_1;
                                    multiplaEscolhaEditOpt[1].placeholder = retorno[0].op_2;
                                    multiplaEscolhaEditOpt[2].placeholder = retorno[0].op_3;
                                    multiplaEscolhaEditOpt[3].placeholder = retorno[0].op_4;
                                break;
                                case 5:
                                    numeroOpts(5);
                                    multiplaEscolhaEditOpt[0].placeholder = retorno[0].op_1;
                                    multiplaEscolhaEditOpt[1].placeholder = retorno[0].op_2;
                                    multiplaEscolhaEditOpt[2].placeholder = retorno[0].op_3;
                                    multiplaEscolhaEditOpt[3].placeholder = retorno[0].op_4;
                                    multiplaEscolhaEditOpt[4].placeholder = retorno[0].op_5;
                                break;
                            }
                            btnsEditQuest[1].onclick = function(){
                                return modalEditQuest('ME', retorno[0].id);
                            };
                            $('#modalEditPergundaMultiplaEscolha').modal('show');
                        break;
                        case 'SN':
                            enunciadoEditPerguntaSN = document.getElementById('enunciadoEditPerguntaSN');
                            enunciadoEditPerguntaSN.placeholder = retorno[0].enunciado;
                            btnsEditQuest[2].onclick = function(){
                                return modalEditQuest('SN', retorno[0].id);
                            };
                            $('#modalEditPergundaSN').modal('show');
                        break;
                        case 'ZD':
                            enunciadoEditPerguntaZD = document.getElementById('enunciadoEditPerguntaZD');
                            enunciadoEditPerguntaZD.placeholder = retorno[0].enunciado;
                            btnsEditQuest[3].onclick = function(){
                                return modalEditQuest('ZD', retorno[0].id);
                            };
                            $('#modalEditPergunda0a10').modal('show');
                        break;
                    };
                },
            });
            
        }

        function deletarQuestConf(questnum, id){
            $.ajax({
                url:"{{ route('cadastros.pesquisa.quest.del') }}",
                type:"post",
                datatype:'json',
                data:{
                    _token:'{{ csrf_token() }}',
                    questnum,
                    id,
                },
                success:function(retorno){
                    modalDados(id);
                    $('#modalDelPergunda').modal('hide');
                    $('#modalDelPergundaSuccess').modal('show');
                },
            });
        }

        function excluirQuest(questipo, questnum, id){
            divsperguntas = document.getElementsByClassName('divperguntaDel');
            for(i=0;i<divsperguntas.length;i++){
                divsperguntas[i].style = "display:none;"
            }
            $.ajax({
                url:"{{ route('cadastros.pesquisa.quest.get') }}",
                type:"post",
                datatype:"json",
                data:{
                    _token:"{{ csrf_token() }}",
                    id,
                    questnum,
                },
                success:function(retorno){
                    switch(questipo){
                        case 'EU':
                            var divpergunta = document.getElementById('divperguntaDelEU');
                            divpergunta.style = "display:block;";
                            enunciadoDelEU = document.getElementById('enunciadoDelEU');
                            enunciadoDelEU.innerHTML = retorno[0].enunciado;
                            switch(retorno[0].qtdOps){
                                case 2:
                                    optsDelEU = document.getElementsByClassName('optDelEU');
                                    optsDelEU[0].style = "display:block;";
                                    optsDelEU[0].lastElementChild.innerHTML = retorno[0].op_1; 
                                    optsDelEU[1].style = "display:block;";
                                    optsDelEU[1].lastElementChild.innerHTML = retorno[0].op_2;
                                    optsDelEU[2].style = "display:none";
                                    optsDelEU[3].style = "display:none";
                                    optsDelEU[4].style = "display:none";
                                break;
                                case 3:
                                    optsDelEU = document.getElementsByClassName('optDelEU');
                                    optsDelEU[0].style = "display:block;";
                                    optsDelEU[0].lastElementChild.innerHTML = retorno[0].op_1; 
                                    optsDelEU[1].style = "display:block;";
                                    optsDelEU[1].lastElementChild.innerHTML = retorno[0].op_2;
                                    optsDelEU[2].style = "display:block;";
                                    optsDelEU[2].lastElementChild.innerHTML = retorno[0].op_3;
                                    optsDelEU[3].style = "display:none;";
                                    optsDelEU[4].style = "display:none;";
                                break;
                                case 4:
                                    optsDelEU = document.getElementsByClassName('optDelEU');
                                    optsDelEU[0].style = "display:block;";
                                    optsDelEU[0].lastElementChild.innerHTML = retorno[0].op_1; 
                                    optsDelEU[1].style = "display:block;";
                                    optsDelEU[1].lastElementChild.innerHTML = retorno[0].op_2;
                                    optsDelEU[2].style = "display:block;";
                                    optsDelEU[2].lastElementChild.innerHTML = retorno[0].op_3;
                                    optsDelEU[3].style = "display:block;";
                                    optsDelEU[3].lastElementChild.innerHTML = retorno[0].op_4;
                                    optsDelEU[4].style = "display:none;";
                                break;
                                case 5:
                                    optsDelEU = document.getElementsByClassName('optDelEU');
                                    optsDelEU[0].style = "display:block;";
                                    optsDelEU[0].lastElementChild.innerHTML = retorno[0].op_1; 
                                    optsDelEU[1].style = "display:block;";
                                    optsDelEU[1].lastElementChild.innerHTML = retorno[0].op_2;
                                    optsDelEU[2].style = "display:block;";
                                    optsDelEU[2].lastElementChild.innerHTML = retorno[0].op_3;
                                    optsDelEU[3].style = "display:block;";
                                    optsDelEU[3].lastElementChild.innerHTML = retorno[0].op_4;
                                    optsDelEU[4].style = "display:block;";
                                    optsDelEU[4].lastElementChild.innerHTML = retorno[0].op_5;
                                break;
                            }
                        break;
                        case 'ME':
                            var divpergunta = document.getElementById('divperguntaDelME');
                            divpergunta.style = "display:block;";
                            enunciadoDelME = document.getElementById('enunciadoDelME');
                            enunciadoDelME.innerHTML = retorno[0].enunciado;
                            switch(retorno[0].qtdOps){
                                case 2:
                                    optsDelME = document.getElementsByClassName('optDelME');
                                    optsDelME[0].style = "display:block;";
                                    optsDelME[0].lastElementChild.innerHTML = retorno[0].op_1; 
                                    optsDelME[1].style = "display:block;";
                                    optsDelME[1].lastElementChild.innerHTML = retorno[0].op_2;
                                    optsDelME[2].style = "display:none";
                                    optsDelME[3].style = "display:none";
                                    optsDelME[4].style = "display:none";
                                break;
                                case 3:
                                    optsDelME = document.getElementsByClassName('optDelME');
                                    optsDelME[0].style = "display:block;";
                                    optsDelME[0].lastElementChild.innerHTML = retorno[0].op_1; 
                                    optsDelME[1].style = "display:block;";
                                    optsDelME[1].lastElementChild.innerHTML = retorno[0].op_2;
                                    optsDelME[2].style = "display:block;";
                                    optsDelME[2].lastElementChild.innerHTML = retorno[0].op_3;
                                    optsDelME[3].style = "display:none;";
                                    optsDelME[4].style = "display:none;";
                                break;
                                case 4:
                                    optsDelME = document.getElementsByClassName('optDelME');
                                    optsDelME[0].style = "display:block;";
                                    optsDelME[0].lastElementChild.innerHTML = retorno[0].op_1; 
                                    optsDelME[1].style = "display:block;";
                                    optsDelME[1].lastElementChild.innerHTML = retorno[0].op_2;
                                    optsDelME[2].style = "display:block;";
                                    optsDelME[2].lastElementChild.innerHTML = retorno[0].op_3;
                                    optsDelME[3].style = "display:block;";
                                    optsDelME[3].lastElementChild.innerHTML = retorno[0].op_4;
                                    optsDelME[4].style = "display:none;";
                                break;
                                case 5:
                                    optsDelME = document.getElementsByClassName('optDelME');
                                    optsDelME[0].style = "display:block;";
                                    optsDelME[0].lastElementChild.innerHTML = retorno[0].op_1; 
                                    optsDelME[1].style = "display:block;";
                                    optsDelME[1].lastElementChild.innerHTML = retorno[0].op_2;
                                    optsDelME[2].style = "display:block;";
                                    optsDelME[2].lastElementChild.innerHTML = retorno[0].op_3;
                                    optsDelME[3].style = "display:block;";
                                    optsDelME[3].lastElementChild.innerHTML = retorno[0].op_4;
                                    optsDelME[4].style = "display:block;";
                                    optsDelME[4].lastElementChild.innerHTML = retorno[0].op_5;
                                break;
                            }           
                        break;
                        case 'SN':
                            var divpergunta = document.getElementById('divperguntaDelSN');
                            divpergunta.style = "display:block;";    
                            enunciadoDelSN = document.getElementById('enunciadoDelSN');
                            enunciadoDelSN.innerHTML = retorno[0].enunciado;
                        break;
                        case 'ZD':
                            var divpergunta = document.getElementById('divperguntaDelZD');
                            divpergunta.style = "display:block;";  
                            enunciadoDelZD = document.getElementById('enunciadoDelZD');
                            enunciadoDelZD.innerHTML = retorno[0].enunciado;                  
                        break;
                    }
                    btnDelConf = document.getElementById('btnDelConf');
                    btnDelConf.onclick = function(){
                        deletarQuestConf(questnum, id);
                    }
                    $('#modalDelPergunda').modal('show');
                },
            });
        }

        function modalDados(id){
            var btnAtualizarDados = document.getElementById('btnAtualizarDados');
            btnAtualizarDados.onclick = function(){
                modalDados(id)
            }
            btnsNewQuest = document.getElementsByClassName('botaoNewQuest');
            btnsNewQuest[0].onclick = function(){
                return modalNewQuest('EU',id);
            };
            btnsNewQuest[1].onclick = function(){
                return modalNewQuest('ME',id);
            };
            btnsNewQuest[2].onclick = function(){
                return modalNewQuest('SN',id);
            };
            btnsNewQuest[3].onclick = function(){
                return modalNewQuest('TX',id);
            };
            btnsNewQuest[4].onclick = function(){
                return modalNewQuest('ZD',id);
            };
            $.ajax({
                url:"{{ route('cadastros.pesquisa.dados') }}",
                type:"post",
                datatype:"json",
                data:{
                    _token:"{{csrf_token()}}",
                    id,
                },
                success:function(retorno){
                    var respostasQTD = document.getElementById('respostasQTD');
                    respostasQTD.innerHTML = retorno[0].qtdeResps;
                    var elementos = document.getElementsByClassName('formDataVer');
                    document.getElementsByClassName('formDataVer').nomeVer.value          = retorno[0].nome;        
                    document.getElementsByClassName('formDataVer').urlpesqVer.value          = retorno[0].url;        
                    if(retorno[0].fnomeadmaster == null){
                        document.getElementsByClassName('formDataVer').idmasterVer.innerHTML = retorno[0].nomeadmaster;         
                    }else{
                        document.getElementsByClassName('formDataVer').idmasterVer.innerHTML = retorno[0].fnomeadmaster;         
                    }
                    $('#modalVer').modal('show');
                },
            })
            $.ajax({
                url:"{{ route('pesquisa.getQuests') }}",
                type:"post",
                datatype:"json",
                data:{
                    _token:"{{csrf_token()}}",
                    id,
                },
                success:function(retorno){
                    var form_father = document.getElementById('formVerDados');
                    form_father.innerHTML= "";
                    retorno.forEach(
                        function mensagem(data){
                            switch(true){
                                case data.TIPO == "EU":
                                    var div = document.createElement('div');
                                    div.className = "row";
                                    
                                    var div_col = document.createElement('div');
                                    div.appendChild(div_col);
                                    div_col.className = "col-12";
                                    
                                    var label = document.createElement('label');
                                    div_col.appendChild(label);
                                    label.innerHTML = "Questão "+data.questnum+"(Escolha Única):";
                                    label.for = "idmaster";

                                    var br1 = document.createElement('br');
                                    div_col.appendChild(br1);

                                    var btnEditar = document.createElement('span');
                                    div_col.appendChild(btnEditar);
                                    btnEditar.className = "btn btn-info";
                                    btnEditar.innerHTML = "Editar";
                                    btnEditar.style = "margin-right:5px;";
                                    btnEditar.onclick = function(){
                                        editarQuest(data.TIPO, data.questnum, id);
                                    };
                                    var btnExcluir = document.createElement('span');
                                    div_col.appendChild(btnExcluir);
                                    btnExcluir.className = "btn btn-danger";
                                    btnExcluir.innerHTML = "Excluir";
                                    btnExcluir.onclick = function(){
                                        excluirQuest(data.TIPO, data.questnum, id);
                                    };

                                    var enunciado = document.createElement('h5');
                                    div_col.appendChild(enunciado);
                                    enunciado.innerHTML = "Enunciado: "+data.enunciado;
                                    enunciado.id = "enunciado_"+data.questnum;
                                    
                                    var div_ops = document.createElement('div');
                                    div_col.appendChild(div_ops);
                                    div_ops.className = "form-group";

                                    var div_op1 = document.createElement('div');
                                    div_ops.appendChild(div_op1);
                                    div_op1.className = "form-check";
                                    var input1 = document.createElement('input');
                                    div_op1.appendChild(input1);
                                    input1.className = "form-check-input";
                                    input1.type = "radio";
                                    input1.disabled = "true";
                                    var labelInput1 = document.createElement('label');
                                    div_op1.appendChild(labelInput1);
                                    labelInput1.className = "form-check-label";
                                    labelInput1.innerHTML = data.op_1;
                                    var porcent1 = document.createElement('span');
                                    div_op1.appendChild(porcent1);
                                    porcent1.className = 'right badge badge-secondary float-right ';
                                    porcent1.style = 'margin-left:50px;';
                                    porcent1.id = 'op1q'+data.questnum+'pesq'+data.idpesq;
                                    var questNumP = data.questnum,
                                    idpesqP = data.idpesq,
                                    op = 1,
                                    ret = porcent1.id;
                                    tipoP = data.TIPO;
                                    $.ajax({
                                        url:'{{ route("pesquisa.porcentagem") }}',
                                        type:'post',
                                        datatype:'json',
                                        data:{
                                            _token:'{{ csrf_token() }}',
                                            questNumP,
                                            idpesqP, 
                                            op,    
                                            ret,   
                                            tipoP,
                                        },
                                        success:function(retorno){
                                            if(retorno[0] != '0,00%'){
                                                resps = '';
                                                if(retorno[1]==1){
                                                    resps = retorno[1]+' resposta';
                                                }else{
                                                    resps = retorno[1]+' respostas';
                                                } 
                                                document.getElementById(retorno[2]).innerHTML = retorno[0]+' - '+resps;
                                            }
                                        },
                                    });
                                    
                                    var div_op2 = document.createElement('div');
                                    div_ops.appendChild(div_op2);
                                    div_op2.className = "form-check";
                                    var input2 = document.createElement('input');
                                    div_op2.appendChild(input2);
                                    input2.className = "form-check-input";
                                    input2.type = "radio";
                                    input2.disabled = "true";
                                    var labelInput2 = document.createElement('label');
                                    div_op2.appendChild(labelInput2);
                                    labelInput2.className = "form-check-label";
                                    labelInput2.innerHTML = data.op_2;
                                    var porcent2 = document.createElement('span');
                                    div_op2.appendChild(porcent2);
                                    porcent2.className = 'right badge badge-secondary float-right';
                                    porcent2.style = 'margin-left:50px;';
                                    porcent2.id = 'op2q'+data.questnum+'pesq'+data.idpesq;
                                    var questNumP = data.questnum,
                                    idpesqP = data.idpesq,
                                    op = 2,
                                    ret = porcent2.id;
                                    tipoP = data.TIPO;
                                    $.ajax({
                                        url:'{{ route("pesquisa.porcentagem") }}',
                                        type:'post',
                                        datatype:'json',
                                        data:{
                                            _token:'{{ csrf_token() }}',
                                            questNumP,
                                            idpesqP, 
                                            op,    
                                            ret,   
                                            tipoP,
                                        },
                                        success:function(retorno){
                                            if(retorno[0] != '0,00%'){
                                                resps = '';
                                                if(retorno[1]==1){
                                                    resps = retorno[1]+' resposta';
                                                }else{
                                                    resps = retorno[1]+' respostas';
                                                } 
                                                document.getElementById(retorno[2]).innerHTML = retorno[0]+' - '+resps;
                                            }
                                        },
                                    });

                                    switch(true){
                                        case data.qtdOps == 3: 
                                            var div_op3 = document.createElement('div');
                                            div_ops.appendChild(div_op3);
                                            div_op3.className = "form-check";
                                            var input3 = document.createElement('input');
                                            div_op3.appendChild(input3);
                                            input3.className = "form-check-input";
                                            input3.type = "radio";
                                            input3.disabled = "true";
                                            var labelInput3 = document.createElement('label');
                                            div_op3.appendChild(labelInput3);
                                            labelInput3.className = "form-check-label";
                                            labelInput3.innerHTML = data.op_3;
                                            var porcent3 = document.createElement('span');
                                            div_op3.appendChild(porcent3);
                                            porcent3.className = 'right badge badge-secondary float-right';
                                            porcent3.style = 'margin-left:50px;'
                                            porcent3.id = 'op3q'+data.questnum+'pesq'+data.idpesq;
                                            var questNumP = data.questnum,
                                            idpesqP = data.idpesq,
                                            op = 3,
                                            ret = porcent3.id;
                                            tipoP = data.TIPO;
                                            $.ajax({
                                                url:'{{ route("pesquisa.porcentagem") }}',
                                                type:'post',
                                                datatype:'json',
                                                data:{
                                                    _token:'{{ csrf_token() }}',
                                                    questNumP,
                                                    idpesqP, 
                                                    op,    
                                                    ret,   
                                                    tipoP,
                                                },
                                                success:function(retorno){
                                                    if(retorno[0] != '0,00%'){
                                                        resps = '';
                                                        if(retorno[1]==1){
                                                            resps = retorno[1]+' resposta';
                                                        }else{
                                                            resps = retorno[1]+' respostas';
                                                        } 
                                                        document.getElementById(retorno[2]).innerHTML = retorno[0]+' - '+resps;
                                                    }
                                                },
                                            });

                                        break;
                                        case data.qtdOps == 4:
                                            var div_op3 = document.createElement('div');
                                            div_ops.appendChild(div_op3);
                                            div_op3.className = "form-check";
                                            var input3 = document.createElement('input');
                                            div_op3.appendChild(input3);
                                            input3.className = "form-check-input";
                                            input3.type = "radio";
                                            input3.disabled = "true";
                                            var labelInput3 = document.createElement('label');
                                            div_op3.appendChild(labelInput3);
                                            labelInput3.className = "form-check-label";
                                            labelInput3.innerHTML = data.op_3;
                                            var porcent3 = document.createElement('span');
                                            div_op3.appendChild(porcent3);
                                            porcent3.className = 'right badge badge-secondary float-right';
                                            porcent3.style = 'margin-left:50px;'
                                            porcent3.id = 'op3q'+data.questnum+'pesq'+data.idpesq;
                                            var questNumP = data.questnum,
                                            idpesqP = data.idpesq,
                                            op = 3,
                                            ret = porcent3.id;
                                            tipoP = data.TIPO;
                                            $.ajax({
                                                url:'{{ route("pesquisa.porcentagem") }}',
                                                type:'post',
                                                datatype:'json',
                                                data:{
                                                    _token:'{{ csrf_token() }}',
                                                    questNumP,
                                                    idpesqP, 
                                                    op,    
                                                    ret,   
                                                    tipoP,
                                                },
                                                success:function(retorno){
                                                    if(retorno[0] != '0,00%'){
                                                        resps = '';
                                                        if(retorno[1]==1){
                                                            resps = retorno[1]+' resposta';
                                                        }else{
                                                            resps = retorno[1]+' respostas';
                                                        } 
                                                        document.getElementById(retorno[2]).innerHTML = retorno[0]+' - '+resps;
                                                    }
                                                },
                                            });

                                            var div_op4 = document.createElement('div');
                                            div_ops.appendChild(div_op4);
                                            div_op4.className = "form-check";
                                            var input4 = document.createElement('input');
                                            div_op4.appendChild(input4);
                                            input4.className = "form-check-input";
                                            input4.type = "radio";
                                            input4.disabled = "true";
                                            var labelInput4 = document.createElement('label');
                                            div_op4.appendChild(labelInput4);
                                            labelInput4.className = "form-check-label";
                                            labelInput4.innerHTML = data.op_4;
                                            var porcent4 = document.createElement('span');
                                            div_op4.appendChild(porcent4);
                                            porcent4.className = 'right badge badge-secondary float-right';
                                            porcent4.style = 'margin-left:50px;'
                                            porcent4.id = 'op4q'+data.questnum+'pesq'+data.idpesq;
                                            var questNumP = data.questnum,
                                            idpesqP = data.idpesq,
                                            op = 4,
                                            ret = porcent4.id;
                                            tipoP = data.TIPO;
                                            $.ajax({
                                                url:'{{ route("pesquisa.porcentagem") }}',
                                                type:'post',
                                                datatype:'json',
                                                data:{
                                                    _token:'{{ csrf_token() }}',
                                                    questNumP,
                                                    idpesqP, 
                                                    op,    
                                                    ret,   
                                                    tipoP,
                                                },
                                                success:function(retorno){
                                                    if(retorno[0] != '0,00%'){
                                                        resps = '';
                                                        if(retorno[1]==1){
                                                            resps = retorno[1]+' resposta';
                                                        }else{
                                                            resps = retorno[1]+' respostas';
                                                        } 
                                                        document.getElementById(retorno[2]).innerHTML = retorno[0]+' - '+resps;
                                                    }
                                                },
                                            });
                                            
                                        break;
                                        case data.qtdOps == 5: 
                                            var div_op3 = document.createElement('div');
                                            div_ops.appendChild(div_op3);
                                            div_op3.className = "form-check";
                                            var input3 = document.createElement('input');
                                            div_op3.appendChild(input3);
                                            input3.className = "form-check-input";
                                            input3.type = "radio";
                                            input3.disabled = "true";
                                            var labelInput3 = document.createElement('label');
                                            div_op3.appendChild(labelInput3);
                                            labelInput3.className = "form-check-label";
                                            labelInput3.innerHTML = data.op_3;
                                            var porcent3 = document.createElement('span');
                                            div_op3.appendChild(porcent3);
                                            porcent3.className = 'right badge badge-secondary float-right';
                                            porcent3.style = 'margin-left:50px;'
                                            porcent3.id = 'op3q'+data.questnum+'pesq'+data.idpesq;
                                            var questNumP = data.questnum,
                                            idpesqP = data.idpesq,
                                            op = 3,
                                            ret = porcent3.id;
                                            tipoP = data.TIPO;
                                            $.ajax({
                                                url:'{{ route("pesquisa.porcentagem") }}',
                                                type:'post',
                                                datatype:'json',
                                                data:{
                                                    _token:'{{ csrf_token() }}',
                                                    questNumP,
                                                    idpesqP, 
                                                    op,    
                                                    ret,   
                                                    tipoP,
                                                },
                                                success:function(retorno){
                                                    if(retorno[0] != '0,00%'){
                                                        resps = '';
                                                        if(retorno[1]==1){
                                                            resps = retorno[1]+' resposta';
                                                        }else{
                                                            resps = retorno[1]+' respostas';
                                                        } 
                                                        document.getElementById(retorno[2]).innerHTML = retorno[0]+' - '+resps;
                                                    }
                                                },
                                            });
                                            
                                            var div_op4 = document.createElement('div');
                                            div_ops.appendChild(div_op4);
                                            div_op4.className = "form-check";
                                            var input4 = document.createElement('input');
                                            div_op4.appendChild(input4);
                                            input4.className = "form-check-input";
                                            input4.type = "radio";
                                            input4.disabled = "true";
                                            var labelInput4 = document.createElement('label');
                                            div_op4.appendChild(labelInput4);
                                            labelInput4.className = "form-check-label";
                                            labelInput4.innerHTML = data.op_4;
                                            var porcent4 = document.createElement('span');
                                            div_op4.appendChild(porcent4);
                                            porcent4.className = 'right badge badge-secondary float-right';
                                            porcent4.style = 'margin-left:50px;'
                                            porcent4.id = 'op4q'+data.questnum+'pesq'+data.idpesq;
                                            var questNumP = data.questnum,
                                            idpesqP = data.idpesq,
                                            op = 4,
                                            ret = porcent4.id;
                                            tipoP = data.TIPO;
                                            $.ajax({
                                                url:'{{ route("pesquisa.porcentagem") }}',
                                                type:'post',
                                                datatype:'json',
                                                data:{
                                                    _token:'{{ csrf_token() }}',
                                                    questNumP,
                                                    idpesqP, 
                                                    op,    
                                                    ret,   
                                                    tipoP,
                                                },
                                                success:function(retorno){
                                                    if(retorno[0] != '0,00%'){
                                                        resps = '';
                                                        if(retorno[1]==1){
                                                            resps = retorno[1]+' resposta';
                                                        }else{
                                                            resps = retorno[1]+' respostas';
                                                        } 
                                                        document.getElementById(retorno[2]).innerHTML = retorno[0]+' - '+resps;
                                                    }
                                                },
                                            });

                                            var div_op5 = document.createElement('div');
                                            div_ops.appendChild(div_op5);
                                            div_op5.className = "form-check";
                                            var input5 = document.createElement('input');
                                            div_op5.appendChild(input5);
                                            input5.className = "form-check-input";
                                            input5.type = "radio";
                                            input5.disabled = "true";
                                            var labelInput5 = document.createElement('label');
                                            div_op5.appendChild(labelInput5);
                                            labelInput5.className = "form-check-label";
                                            labelInput5.innerHTML = data.op_5;
                                            var porcent5 = document.createElement('span');
                                            div_op5.appendChild(porcent5);
                                            porcent5.className = 'right badge badge-secondary float-right';
                                            porcent5.style = 'margin-left:50px;'
                                            porcent5.id = 'op5q'+data.questnum+'pesq'+data.idpesq;
                                            var questNumP = data.questnum,
                                            idpesqP = data.idpesq,
                                            op = 5,
                                            ret = porcent5.id;
                                            tipoP = data.TIPO;
                                            $.ajax({
                                                url:'{{ route("pesquisa.porcentagem") }}',
                                                type:'post',
                                                datatype:'json',
                                                data:{
                                                    _token:'{{ csrf_token() }}',
                                                    questNumP,
                                                    idpesqP, 
                                                    op,    
                                                    ret,   
                                                    tipoP,
                                                },
                                                success:function(retorno){
                                                    if(retorno[0] != '0,00%'){
                                                        resps = '';
                                                        if(retorno[1]==1){
                                                            resps = retorno[1]+' resposta';
                                                        }else{
                                                            resps = retorno[1]+' respostas';
                                                        } 
                                                        document.getElementById(retorno[2]).innerHTML = retorno[0]+' - '+resps;
                                                    }
                                                },
                                            });

                                        break;
                                    }

                                    form_father.appendChild(div);
                                    
                                    var hr1 = document.createElement('hr');
                                    form_father.appendChild(hr1);


                                break; 
                                case data.TIPO == "ME":
                                    var div = document.createElement('div');
                                    div.className = "row";
                                    
                                    div_col = document.createElement('div');
                                    div.appendChild(div_col);
                                    div_col.className = "col-12";
                                    
                                    var label = document.createElement('label');
                                    div_col.appendChild(label);
                                    label.innerHTML = "Questão "+data.questnum+"(Multipla Escolha):";
                                    label.for = "idmaster";

                                    var br1 = document.createElement('br');
                                    div_col.appendChild(br1);

                                    var btnEditar = document.createElement('span');
                                    div_col.appendChild(btnEditar);
                                    btnEditar.className = "btn btn-info";
                                    btnEditar.innerHTML = "Editar";
                                    btnEditar.style = "margin-right:5px;";
                                    btnEditar.onclick = function(){
                                        editarQuest(data.TIPO, data.questnum, id);
                                    };
                                    var btnExcluir = document.createElement('span');
                                    div_col.appendChild(btnExcluir);
                                    btnExcluir.className = "btn btn-danger";
                                    btnExcluir.innerHTML = "Excluir";
                                    btnExcluir.onclick = function(){
                                        excluirQuest(data.TIPO, data.questnum, id);
                                    };
                                    
                                    var enunciado = document.createElement('h5');
                                    div_col.appendChild(enunciado);
                                    enunciado.innerHTML = "Enunciado: "+data.enunciado;
                                    enunciado.id = "enunciado_"+data.questnum;
                                    
                                    var div_ops = document.createElement('div');
                                    div_col.appendChild(div_ops);
                                    div_ops.className = "form-group";

                                    var div_op1 = document.createElement('div');
                                    div_ops.appendChild(div_op1);
                                    div_op1.className = "custom-control custom-checkbox";
                                    var input1 = document.createElement('input');
                                    div_op1.appendChild(input1);
                                    input1.id = "customCheckbox1";
                                    input1.className = "custom-control-input";
                                    input1.type = "checkbox";
                                    input1.disabled = "true";
                                    var labelInput1 = document.createElement('label');
                                    div_op1.appendChild(labelInput1);
                                    labelInput1.className = "custom-control-label";
                                    labelInput1.for = "customCheckbox1";
                                    labelInput1.innerHTML = data.op_1;
                                    var porcent1 = document.createElement('span');
                                    div_op1.appendChild(porcent1);
                                    porcent1.className = 'right badge badge-secondary float-right';
                                    porcent1.style = 'margin-left:50px;'
                                    porcent1.id = 'op1q'+data.questnum+'pesq'+data.idpesq;
                                    var questNumP = data.questnum,
                                    idpesqP = data.idpesq,
                                    op = 1,
                                    ret = porcent1.id;
                                    tipoP = data.TIPO;
                                    $.ajax({
                                        url:'{{ route("pesquisa.porcentagem") }}',
                                        type:'post',
                                        datatype:'json',
                                        data:{
                                            _token:'{{ csrf_token() }}',
                                            questNumP,
                                            idpesqP, 
                                            op,    
                                            ret,   
                                            tipoP,
                                        },
                                        success:function(retorno){
                                            console.log(retorno);
                                            if(retorno[0] != '0,00%'){
                                                resps = '';
                                                if(retorno[1]==1){
                                                    resps = retorno[1]+' resposta';
                                                }else{
                                                    resps = retorno[1]+' respostas';
                                                } 
                                                document.getElementById(retorno[2]).innerHTML = retorno[0]+' - '+resps;
                                            }
                                        },
                                    });
                                    
                                    
                                    var div_op2 = document.createElement('div');
                                    div_ops.appendChild(div_op2);
                                    div_op2.className = "custom-control custom-checkbox";
                                    var input2 = document.createElement('input');
                                    div_op2.appendChild(input2);
                                    input2.id = "customCheckbox2";
                                    input2.className = "custom-control-input";
                                    input2.type = "checkbox";
                                    input2.disabled = "true";
                                    var labelInput2 = document.createElement('label');
                                    div_op2.appendChild(labelInput2);
                                    labelInput2.className = "custom-control-label";
                                    labelInput2.for = "customCheckbox2";
                                    labelInput2.innerHTML = data.op_2;
                                    var porcent2 = document.createElement('span');
                                    div_op2.appendChild(porcent2);
                                    porcent2.className = 'right badge badge-secondary float-right';
                                    porcent2.style = 'margin-left:50px;'
                                    porcent2.id = 'op2q'+data.questnum+'pesq'+data.idpesq;
                                    var questNumP = data.questnum,
                                    idpesqP = data.idpesq,
                                    op = 2,
                                    ret = porcent2.id;
                                    tipoP = data.TIPO;
                                    $.ajax({
                                        url:'{{ route("pesquisa.porcentagem") }}',
                                        type:'post',
                                        datatype:'json',
                                        data:{
                                            _token:'{{ csrf_token() }}',
                                            questNumP,
                                            idpesqP, 
                                            op,    
                                            ret,   
                                            tipoP,
                                        },
                                        success:function(retorno){
                                            console.log(retorno);
                                            if(retorno[0] != '0,00%'){
                                                resps = '';
                                                if(retorno[1]==1){
                                                    resps = retorno[1]+' resposta';
                                                }else{
                                                    resps = retorno[1]+' respostas';
                                                } 
                                                document.getElementById(retorno[2]).innerHTML = retorno[0]+' - '+resps;
                                            }
                                        },
                                    });
                                    
                                    switch(true){
                                        case data.qtdOps == 3: 
                                            var div_op3 = document.createElement('div');
                                            div_ops.appendChild(div_op3);
                                            div_op3.className = "custom-control custom-checkbox";
                                            var input3 = document.createElement('input');
                                            div_op3.appendChild(input3);
                                            input3.id = "customCheckbox3";
                                            input3.className = "custom-control-input";
                                            input3.type = "checkbox";
                                            input3.disabled = "true";
                                            var labelInput3 = document.createElement('label');
                                            div_op3.appendChild(labelInput3);
                                            labelInput3.className = "custom-control-label";
                                            labelInput3.for = "customCheckbox3";
                                            labelInput3.innerHTML = data.op_3;
                                            var porcent3 = document.createElement('span');
                                            div_op3.appendChild(porcent3);
                                            porcent3.className = 'right badge badge-secondary float-right';
                                            porcent3.style = 'margin-left:50px;'
                                            porcent3.id = 'op3q'+data.questnum+'pesq'+data.idpesq;
                                            var questNumP = data.questnum,
                                            idpesqP = data.idpesq,
                                            op = 3,
                                            ret = porcent3.id;
                                            tipoP = data.TIPO;
                                            $.ajax({
                                                url:'{{ route("pesquisa.porcentagem") }}',
                                                type:'post',
                                                datatype:'json',
                                                data:{
                                                    _token:'{{ csrf_token() }}',
                                                    questNumP,
                                                    idpesqP, 
                                                    op,    
                                                    ret,   
                                                    tipoP,
                                                },
                                                success:function(retorno){
                                                    console.log(retorno);
                                                    if(retorno[0] != '0,00%'){
                                                        resps = '';
                                                        if(retorno[1]==1){
                                                            resps = retorno[1]+' resposta';
                                                        }else{
                                                            resps = retorno[1]+' respostas';
                                                        } 
                                                        document.getElementById(retorno[2]).innerHTML = retorno[0]+' - '+resps;
                                                    }
                                                },
                                            });
                                            
                                        break;
                                        case data.qtdOps == 4:
                                            var div_op3 = document.createElement('div');
                                            div_ops.appendChild(div_op3);
                                            div_op3.className = "custom-control custom-checkbox";
                                            var input3 = document.createElement('input');
                                            div_op3.appendChild(input3);
                                            input3.id = "customCheckbox3";
                                            input3.className = "custom-control-input";
                                            input3.type = "checkbox";
                                            input3.disabled = "true";
                                            var labelInput3 = document.createElement('label');
                                            div_op3.appendChild(labelInput3);
                                            labelInput3.className = "custom-control-label";
                                            labelInput3.for = "customCheckbox3";
                                            labelInput3.innerHTML = data.op_3;
                                            var porcent3 = document.createElement('span');
                                            div_op3.appendChild(porcent3);
                                            porcent3.className = 'right badge badge-secondary float-right';
                                            porcent3.style = 'margin-left:50px;'
                                            porcent3.id = 'op3q'+data.questnum+'pesq'+data.idpesq;
                                            var questNumP = data.questnum,
                                            idpesqP = data.idpesq,
                                            op = 3,
                                            ret = porcent3.id;
                                            tipoP = data.TIPO;
                                            $.ajax({
                                                url:'{{ route("pesquisa.porcentagem") }}',
                                                type:'post',
                                                datatype:'json',
                                                data:{
                                                    _token:'{{ csrf_token() }}',
                                                    questNumP,
                                                    idpesqP, 
                                                    op,    
                                                    ret,   
                                                    tipoP,
                                                },
                                                success:function(retorno){
                                                    console.log(retorno);
                                                    if(retorno[0] != '0,00%'){
                                                        resps = '';
                                                        if(retorno[1]==1){
                                                            resps = retorno[1]+' resposta';
                                                        }else{
                                                            resps = retorno[1]+' respostas';
                                                        } 
                                                        document.getElementById(retorno[2]).innerHTML = retorno[0]+' - '+resps;
                                                    }
                                                },
                                            });

                                            var div_op4 = document.createElement('div');
                                            div_ops.appendChild(div_op4);
                                            div_op4.className = "custom-control custom-checkbox";
                                            var input4 = document.createElement('input');
                                            div_op4.appendChild(input4);
                                            input4.id = "customCheckbox4";
                                            input4.className = "custom-control-input";
                                            input4.type = "checkbox";
                                            input4.disabled = "true";
                                            var labelInput4 = document.createElement('label');
                                            div_op4.appendChild(labelInput4);
                                            labelInput4.className = "custom-control-label";
                                            labelInput4.for = "customCheckbox4";
                                            labelInput4.innerHTML = data.op_4;
                                            var porcent4 = document.createElement('span');
                                            div_op4.appendChild(porcent4);
                                            porcent4.className = 'right badge badge-secondary float-right';
                                            porcent4.style = 'margin-left:50px;'
                                            porcent4.id = 'op4q'+data.questnum+'pesq'+data.idpesq;
                                            var questNumP = data.questnum,
                                            idpesqP = data.idpesq,
                                            op = 4,
                                            ret = porcent4.id;
                                            tipoP = data.TIPO;
                                            $.ajax({
                                                url:'{{ route("pesquisa.porcentagem") }}',
                                                type:'post',
                                                datatype:'json',
                                                data:{
                                                    _token:'{{ csrf_token() }}',
                                                    questNumP,
                                                    idpesqP, 
                                                    op,    
                                                    ret,   
                                                    tipoP,
                                                },
                                                success:function(retorno){
                                                    console.log(retorno);
                                                    if(retorno[0] != '0,00%'){
                                                        resps = '';
                                                        if(retorno[1]==1){
                                                            resps = retorno[1]+' resposta';
                                                        }else{
                                                            resps = retorno[1]+' respostas';
                                                        } 
                                                        document.getElementById(retorno[2]).innerHTML = retorno[0]+' - '+resps;
                                                    }
                                                },
                                            });

                                        break;
                                        case data.qtdOps == 5: 
                                            var div_op3 = document.createElement('div');
                                            div_ops.appendChild(div_op3);
                                            div_op3.className = "custom-control custom-checkbox";
                                            var input3 = document.createElement('input');
                                            div_op3.appendChild(input3);
                                            input3.id = "customCheckbox3";
                                            input3.className = "custom-control-input";
                                            input3.type = "checkbox";
                                            input3.disabled = "true";
                                            var labelInput3 = document.createElement('label');
                                            div_op3.appendChild(labelInput3);
                                            labelInput3.className = "custom-control-label";
                                            labelInput3.for = "customCheckbox3";
                                            labelInput3.innerHTML = data.op_3;
                                            var porcent3 = document.createElement('span');
                                            div_op3.appendChild(porcent3);
                                            porcent3.className = 'right badge badge-secondary float-right';
                                            porcent3.style = 'margin-left:50px;'
                                            porcent3.id = 'op3q'+data.questnum+'pesq'+data.idpesq;
                                            var questNumP = data.questnum,
                                            idpesqP = data.idpesq,
                                            op = 3,
                                            ret = porcent3.id;
                                            tipoP = data.TIPO;
                                            $.ajax({
                                                url:'{{ route("pesquisa.porcentagem") }}',
                                                type:'post',
                                                datatype:'json',
                                                data:{
                                                    _token:'{{ csrf_token() }}',
                                                    questNumP,
                                                    idpesqP, 
                                                    op,    
                                                    ret,   
                                                    tipoP,
                                                },
                                                success:function(retorno){
                                                    console.log(retorno);
                                                    if(retorno[0] != '0,00%'){
                                                        resps = '';
                                                        if(retorno[1]==1){
                                                            resps = retorno[1]+' resposta';
                                                        }else{
                                                            resps = retorno[1]+' respostas';
                                                        } 
                                                        document.getElementById(retorno[2]).innerHTML = retorno[0]+' - '+resps;
                                                    }
                                                },
                                            });

                                            var div_op4 = document.createElement('div');
                                            div_ops.appendChild(div_op4);
                                            div_op4.className = "custom-control custom-checkbox";
                                            var input4 = document.createElement('input');
                                            div_op4.appendChild(input4);
                                            input4.id = "customCheckbox4";
                                            input4.className = "custom-control-input";
                                            input4.type = "checkbox";
                                            input4.disabled = "true";
                                            var labelInput4 = document.createElement('label');
                                            div_op4.appendChild(labelInput4);
                                            labelInput4.className = "custom-control-label";
                                            labelInput4.for = "customCheckbox4";
                                            labelInput4.innerHTML = data.op_4;
                                            var porcent4 = document.createElement('span');
                                            div_op4.appendChild(porcent4);
                                            porcent4.className = 'right badge badge-secondary float-right';
                                            porcent4.style = 'margin-left:50px;'
                                            porcent4.id = 'op4q'+data.questnum+'pesq'+data.idpesq;
                                            var questNumP = data.questnum,
                                            idpesqP = data.idpesq,
                                            op = 4,
                                            ret = porcent4.id;
                                            tipoP = data.TIPO;
                                            $.ajax({
                                                url:'{{ route("pesquisa.porcentagem") }}',
                                                type:'post',
                                                datatype:'json',
                                                data:{
                                                    _token:'{{ csrf_token() }}',
                                                    questNumP,
                                                    idpesqP, 
                                                    op,    
                                                    ret,   
                                                    tipoP,
                                                },
                                                success:function(retorno){
                                                    console.log(retorno);
                                                    if(retorno[0] != '0,00%'){
                                                        resps = '';
                                                        if(retorno[1]==1){
                                                            resps = retorno[1]+' resposta';
                                                        }else{
                                                            resps = retorno[1]+' respostas';
                                                        } 
                                                        document.getElementById(retorno[2]).innerHTML = retorno[0]+' - '+resps;
                                                    }
                                                },
                                            });

                                            var div_op5 = document.createElement('div');
                                            div_ops.appendChild(div_op5);
                                            div_op5.className = "custom-control custom-checkbox";
                                            var input5 = document.createElement('input');
                                            div_op5.appendChild(input5);
                                            input5.id = "customCheckbox5";
                                            input5.className = "custom-control-input";
                                            input5.type = "checkbox";
                                            input5.disabled = "true";
                                            var labelInput5 = document.createElement('label');
                                            div_op5.appendChild(labelInput5);
                                            labelInput5.className = "custom-control-label";
                                            labelInput5.for = "customCheckbox5";
                                            labelInput5.innerHTML = data.op_5;
                                            var porcent5 = document.createElement('span');
                                            div_op5.appendChild(porcent5);
                                            porcent5.className = 'right badge badge-secondary float-right';
                                            porcent5.style = 'margin-left:50px;'
                                            porcent5.id = 'op5q'+data.questnum+'pesq'+data.idpesq;
                                            var questNumP = data.questnum,
                                            idpesqP = data.idpesq,
                                            op = 5,
                                            ret = porcent5.id;
                                            tipoP = data.TIPO;
                                            $.ajax({
                                                url:'{{ route("pesquisa.porcentagem") }}',
                                                type:'post',
                                                datatype:'json',
                                                data:{
                                                    _token:'{{ csrf_token() }}',
                                                    questNumP,
                                                    idpesqP, 
                                                    op,    
                                                    ret,   
                                                    tipoP,
                                                },
                                                success:function(retorno){
                                                    console.log(retorno);
                                                    if(retorno[0] != '0,00%'){
                                                        resps = '';
                                                        if(retorno[1]==1){
                                                            resps = retorno[1]+' resposta';
                                                        }else{
                                                            resps = retorno[1]+' respostas';
                                                        } 
                                                        document.getElementById(retorno[2]).innerHTML = retorno[0]+' - '+resps;
                                                    }
                                                },
                                            });

                                        break;
                                    }

                                    form_father = document.getElementById('formVerDados');
                                    form_father.appendChild(div);
                                    
                                    var hr1 = document.createElement('hr');
                                    form_father.appendChild(hr1);


                                break; 
                                case data.TIPO == "SN":
                                    var div = document.createElement('div');
                                    div.className = "row";
                                    
                                    div_col = document.createElement('div');
                                    div.appendChild(div_col);
                                    div_col.className = "col-12";
                                    
                                    var label = document.createElement('label');
                                    div_col.appendChild(label);
                                    label.innerHTML = "Questão "+data.questnum+"(Sim/Não):";
                                    label.for = "idmaster";

                                    var br1 = document.createElement('br');
                                    div_col.appendChild(br1);

                                    var btnEditar = document.createElement('span');
                                    div_col.appendChild(btnEditar);
                                    btnEditar.className = "btn btn-info";
                                    btnEditar.innerHTML = "Editar";
                                    btnEditar.style = "margin-right:5px;";
                                    btnEditar.onclick = function(){
                                        editarQuest(data.TIPO, data.questnum, id);
                                    };
                                    var btnExcluir = document.createElement('span');
                                    div_col.appendChild(btnExcluir);
                                    btnExcluir.className = "btn btn-danger";
                                    btnExcluir.innerHTML = "Excluir";
                                    btnExcluir.onclick = function(){
                                        excluirQuest(data.TIPO, data.questnum, id);
                                    };
                                    
                                    var enunciado = document.createElement('h5');
                                    div_col.appendChild(enunciado);
                                    enunciado.innerHTML = "Enunciado: "+data.enunciado;
                                    enunciado.id = "enunciado_"+data.questnum;
                                    
                                    var div_ops = document.createElement('div');
                                    div_col.appendChild(div_ops);
                                    div_ops.className = "form-group";

                                    var div_op1 = document.createElement('div');
                                    div_ops.appendChild(div_op1);
                                    div_op1.className = "form-check";
                                    var input1 = document.createElement('input');
                                    div_op1.appendChild(input1);
                                    input1.className = "form-check-input";
                                    input1.type = "radio";
                                    input1.disabled = "true";
                                    var labelInput1 = document.createElement('label');
                                    div_op1.appendChild(labelInput1);
                                    labelInput1.className = "form-check-label";
                                    labelInput1.innerHTML = "SIM";
                                    var porcent1 = document.createElement('span');
                                    div_op1.appendChild(porcent1);
                                    porcent1.className = 'right badge badge-secondary float-right';
                                    porcent1.style = 'margin-left:50px;'
                                    porcent1.id = 'op1q'+data.questnum+'pesq'+data.idpesq;
                                    var questNumP = data.questnum,
                                    idpesqP = data.idpesq,
                                    op = 1,
                                    ret = porcent1.id;
                                    tipoP = data.TIPO;
                                    $.ajax({
                                        url:'{{ route("pesquisa.porcentagem") }}',
                                        type:'post',
                                        datatype:'json',
                                        data:{
                                            _token:'{{ csrf_token() }}',
                                            questNumP,
                                            idpesqP, 
                                            op,    
                                            ret,   
                                            tipoP,
                                        },
                                        success:function(retorno){
                                            if(retorno[0] != '0,00%'){
                                                resps = '';
                                                if(retorno[1]==1){
                                                    resps = retorno[1]+' resposta';
                                                }else{
                                                    resps = retorno[1]+' respostas';
                                                } 
                                                document.getElementById(retorno[2]).innerHTML = retorno[0]+' - '+resps;
                                            }
                                        },
                                    });
                                    
                                    var div_op2 = document.createElement('div');
                                    div_ops.appendChild(div_op2);
                                    div_op2.className = "form-check";
                                    var input2 = document.createElement('input');
                                    div_op2.appendChild(input2);
                                    input2.className = "form-check-input";
                                    input2.type = "radio";
                                    input2.disabled = "true";
                                    var labelInput2 = document.createElement('label');
                                    div_op2.appendChild(labelInput2);
                                    labelInput2.className = "form-check-label";
                                    labelInput2.innerHTML = "NÂO";
                                    var porcent2 = document.createElement('span');
                                    div_op2.appendChild(porcent2);
                                    porcent2.className = 'right badge badge-secondary float-right';
                                    porcent2.style = 'margin-left:50px;'
                                    porcent2.id = 'op2q'+data.questnum+'pesq'+data.idpesq;
                                    var questNumP = data.questnum,
                                    idpesqP = data.idpesq,
                                    op = 2,
                                    ret = porcent2.id;
                                    tipoP = data.TIPO;
                                    $.ajax({
                                        url:'{{ route("pesquisa.porcentagem") }}',
                                        type:'post',
                                        datatype:'json',
                                        data:{
                                            _token:'{{ csrf_token() }}',
                                            questNumP,
                                            idpesqP, 
                                            op,    
                                            ret,   
                                            tipoP,
                                        },
                                        success:function(retorno){
                                            if(retorno[0] != '0,00%'){
                                                resps = '';
                                                if(retorno[1]==1){
                                                    resps = retorno[1]+' resposta';
                                                }else{
                                                    resps = retorno[1]+' respostas';
                                                } 
                                                document.getElementById(retorno[2]).innerHTML = retorno[0]+' - '+resps;
                                            }
                                        },
                                    });
                                    
                                    form_father = document.getElementById('formVerDados');
                                    form_father.appendChild(div);
                                    
                                    var hr1 = document.createElement('hr');
                                    form_father.appendChild(hr1);
                                break; 
                                case data.TIPO == "ZD":
                                    var div = document.createElement('div');
                                    div.className = "row";
                                    
                                    div_col = document.createElement('div');
                                    div.appendChild(div_col);
                                    div_col.className = "col-12";
                                    
                                    var label = document.createElement('label');
                                    div_col.appendChild(label);
                                    label.innerHTML = "Questão "+data.questnum+"(Zero a Dez):";
                                    label.for = "idmaster";

                                    var br1 = document.createElement('br');
                                    div_col.appendChild(br1);

                                    var btnEditar = document.createElement('span');
                                    div_col.appendChild(btnEditar);
                                    btnEditar.className = "btn btn-info";
                                    btnEditar.innerHTML = "Editar";
                                    btnEditar.style = "margin-right:5px;";
                                    btnEditar.onclick = function(){
                                        editarQuest(data.TIPO, data.questnum, id);
                                    };
                                    var btnExcluir = document.createElement('span');
                                    div_col.appendChild(btnExcluir);
                                    btnExcluir.className = "btn btn-danger";
                                    btnExcluir.innerHTML = "Excluir";
                                    btnExcluir.onclick = function(){
                                        excluirQuest(data.TIPO, data.questnum, id);
                                    };
                                    
                                    var enunciado = document.createElement('h5');
                                    div_col.appendChild(enunciado);
                                    enunciado.innerHTML = "Enunciado: "+data.enunciado;
                                    enunciado.id = "enunciado_"+data.questnum;
                                    
                                    var div_ops = document.createElement('div');
                                    div_col.appendChild(div_ops);
                                    div_ops.className = "form-group";

                                    for (a=1;a<=10;a++){
                                        var div_op = document.createElement('div');
                                        div_ops.appendChild(div_op);
                                        div_op.className = "form-check";
                                        var input = document.createElement('input');
                                        div_op.appendChild(input);
                                        input.className = "form-check-input";
                                        input.type = "radio";
                                        input.disabled = "true";
                                        var labelInput = document.createElement('label');
                                        div_op.appendChild(labelInput);
                                        labelInput.className = "form-check-label";
                                        labelInput.innerHTML = a;
                                        var porcent = document.createElement('span');
                                        div_op.appendChild(porcent);
                                        porcent.className = 'right badge badge-secondary float-right';
                                        porcent.style = 'margin-left:50px;'
                                        porcent.id = 'op'+a+'q'+data.questnum+'pesq'+data.idpesq;
                                        var questNumP = data.questnum,
                                        idpesqP = data.idpesq,
                                        op = a,
                                        ret = porcent.id;
                                        tipoP = data.TIPO;
                                        $.ajax({
                                            url:'{{ route("pesquisa.porcentagem") }}',
                                            type:'post',
                                            datatype:'json',
                                            data:{
                                                _token:'{{ csrf_token() }}',
                                                questNumP,
                                                idpesqP, 
                                                op,    
                                                ret,   
                                                tipoP,
                                            },
                                            success:function(retorno){
                                                if(retorno[0] != '0,00%'){
                                                    resps = '';
                                                    if(retorno[1]==1){
                                                        resps = retorno[1]+' resposta';
                                                    }else{
                                                        resps = retorno[1]+' respostas';
                                                    } 
                                                    document.getElementById(retorno[2]).innerHTML = retorno[0]+' - '+resps;
                                                }
                                            },
                                        });
                                    }

                                    

                                    form_father = document.getElementById('formVerDados');
                                    form_father.appendChild(div);
                                    
                                    var hr1 = document.createElement('hr');
                                    form_father.appendChild(hr1);
                                break; 
                            }
                        }
                    )
                },
            });
        }

        function modalDel(id, param){
            if(param == 'confirm'){
                $.ajax({
                    type:"post",
                    datatype:"json",
                    data:{
                        _token:"{{csrf_token()}}",
                        id,
                    },
                    url:"{{ route('cadastros.pesquisa.dados') }}",
                    success:function(retorno){
                        dados = document.getElementsByClassName('dadosModalDel');
                        dados[2].onclick = function(){
                            return modalDel(id);
                        };
                            dados[0].innerHTML = id;
                            dados[1].innerHTML = retorno[0].nome;
                        $('#modalDelConfirm').modal('show');
                    },
                });
            }else{
                $.ajax({
                    type:"post",
                    datatype:"json",
                    data:{
                        _token:"{{csrf_token()}}",
                        id,
                    },
                    url:"{{ route('pesquisa.delete') }}",
                    success:function(retorno){
                        rowDeleted = document.getElementById('pesquisaRow'+id);
                        rowDeleted.style = "display:none;";
                        $('#modalDel').modal('show');
                    },
                });
            }
        }

        function modalEditF(){
            $('#formAlterPesq').each (function(){
                this.reset();
            });
        }
        
        function modalEditar(id){
            modalEditF();
            $.ajax({
                url:"{{ route('cadastros.pesquisa.dados') }}",
                type:"post",
                datatype:"json",
                data:{
                    _token:"{{csrf_token()}}",
                    id,
                },
                success:function(retorno){
                    var elementos = document.getElementsByClassName('formDataEdit');
                    elementos.idEdit.value                  = id;
                    elementos.urlpesqEdit.placeholder                  = retorno[0].url;
                    if(retorno[0].fnomeadmaster == null){
                        elementos.idmasterEdit.innerHTML = retorno[0].nomeadmaster;         
                    }else{
                        elementos.idmasterEdit.innerHTML = retorno[0].fnomeadmaster;         
                    }
                    elementos.nomeEdit.placeholder          = retorno[0].nome;        
                    $('#modalEdit').modal('show');
                },
            });
        }

        function ModalConfAlter(){
            id = document.getElementsByClassName('formDataEdit').idEdit.value, 
            idmaster = document.getElementsByClassName('formDataEditSelect').idmasterEditSelect.value, 
            nome = document.getElementsByClassName('formDataEdit').nomeEdit.value,
            url = document.getElementsByClassName('formDataEdit').urlpesqEdit.value,
            $.ajax({
                type:"post",
                datatype:"json",
                data:{
                    _token:"{{ csrf_token() }}",
                    id,
                    idmaster,
                    nome,
                    url,
                },
                url:"{{ route('pesquisa.update') }}",
                success:function(retorno){
                    if(retorno['status'] == 'vazio'){
                        $('#ModalVazio').modal('show');
                    }else{
                        $('#ModalConfAlt').modal('show');
                        $('#modalEdit').modal('hide');
                    }
                },
            });
            
        }

        function modalNewQuest(tipo, idPesq = null){
            switch(true){
                case tipo == 1 : $('#modalAddPergundaEscolhaUnica').modal('show');
                break;
                case tipo == 2 : $('#modalAddPergundaMultiplaEscolha').modal('show');
                break;
                case tipo == 3 : $('#modalAddPergundaSN').modal('show');
                break;
                case tipo == 4 : $('#modalAddPergundaRespTexto').modal('show');
                break;
                case tipo == 5 : $('#modalAddPergunda0a10').modal('show');
                break;
                case tipo == 'EU' : 
                    data = document.getElementsByClassName('EscolhaUnica');
                    var enunciado = data[0].value,
                    op_1 = data[1].value,
                    op_2 = data[2].value,
                    op_3 = data[3].value,
                    op_4 = data[4].value,
                    op_5 = data[5].value,
                    numOpts = $("input[name='r1']:checked").val();
                    
                    $.ajax({
                        url:"{{ route('pesquisa.addQuest') }}",
                        type: 'post',
                        datatype:'json',
                        data: {
                            _token:'{{ csrf_token() }}',
                            enunciado,
                            op_1,
                            op_2,
                            op_3,
                            op_4,
                            op_5,
                            idPesq,
                            numOpts,
                            tipo,
                        },
                        success:function(retorno){
                            toasts = document.getElementById('toastsContainerTopRight');
                            if(retorno['status'] == 'error'){
                                dadosValidacao = document.getElementsByClassName('dadosValidacao');
                                dadosValidacao[0].style = "display:none";
                                dadosValidacao[1].style = "display:none";
                                dadosValidacao[2].style = "display:none";
                                dadosValidacao[3].style = "display:none";
                                dadosValidacao[4].style = "display:none";
                                dadosValidacao[5].style = "display:none";
                                retorno[0].forEach(
                                    function mensagem(msg){
                                        if(msg == 'Enunciado')  {dadosValidacao[0].style = "display:block"};
                                        if(msg == 'op1')        {dadosValidacao[1].style = "display:block"};
                                        if(msg == 'op2')        {dadosValidacao[2].style = "display:block"};
                                        if(msg == 'op3')        {dadosValidacao[3].style = "display:block"};
                                        if(msg == 'op4')        {dadosValidacao[4].style = "display:block"};
                                        if(msg == 'op5')        {dadosValidacao[5].style = "display:block"};
                                    }
                                )
                            }else{
                            
                                //criar Nova Pergunta
                                    var div = document.createElement('div');
                                    div.className = "row";
                                    
                                    div_col = document.createElement('div');
                                    div.appendChild(div_col);
                                    div_col.className = "col-12";
                                    
                                    var label = document.createElement('label');
                                    div_col.appendChild(label);
                                    label.innerHTML = "Questão "+retorno.numQuest+"(Escolha Única):";
                                    label.for = "idmaster";

                                    var br1 = document.createElement('br');
                                    div_col.appendChild(br1);

                                    var btnEditar = document.createElement('span');
                                    div_col.appendChild(btnEditar);
                                    btnEditar.className = "btn btn-info";
                                    btnEditar.innerHTML = "Editar";
                                    btnEditar.style = "margin-right:5px;";
                                    btnEditar.onclick = function(){
                                        editarQuest(tipo, retorno.numQuest, idPesq);
                                    };
                                    var btnExcluir = document.createElement('span');
                                    div_col.appendChild(btnExcluir);
                                    btnExcluir.className = "btn btn-danger";
                                    btnExcluir.innerHTML = "Excluir";
                                    btnExcluir.onclick = function(){
                                        excluirQuest(tipo, retorno.numQuest, idPesq);
                                    };
                                    
                                    var enunciadoTexto = document.createElement('h5');
                                    div_col.appendChild(enunciadoTexto);
                                    enunciadoTexto.innerHTML = "Enunciado: "+enunciado;
                                    enunciadoTexto.id = "enunciado_"+retorno.numQuest;
                                    
                                    var div_ops = document.createElement('div');
                                    div_col.appendChild(div_ops);
                                    div_ops.className = "form-group";

                                    var div_op1 = document.createElement('div');
                                    div_ops.appendChild(div_op1);
                                    div_op1.className = "form-check";
                                    var input1 = document.createElement('input');
                                    div_op1.appendChild(input1);
                                    input1.className = "form-check-input";
                                    input1.type = "radio";
                                    input1.disabled = "true";
                                    var labelInput1 = document.createElement('label');
                                    div_op1.appendChild(labelInput1);
                                    labelInput1.className = "form-check-label";
                                    labelInput1.innerHTML = op_1;
                                    
                                    var div_op2 = document.createElement('div');
                                    div_ops.appendChild(div_op2);
                                    div_op2.className = "form-check";
                                    var input2 = document.createElement('input');
                                    div_op2.appendChild(input2);
                                    input2.className = "form-check-input";
                                    input2.type = "radio";
                                    input2.disabled = "true";
                                    var labelInput2 = document.createElement('label');
                                    div_op2.appendChild(labelInput2);
                                    labelInput2.className = "form-check-label";
                                    labelInput2.innerHTML = op_2;
                                    
                                    switch(true){
                                        case numOpts == 3: 
                                            var div_op3 = document.createElement('div');
                                            div_ops.appendChild(div_op3);
                                            div_op3.className = "form-check";
                                            var input3 = document.createElement('input');
                                            div_op3.appendChild(input3);
                                            input3.className = "form-check-input";
                                            input3.type = "radio";
                                            input3.disabled = "true";
                                            var labelInput3 = document.createElement('label');
                                            div_op3.appendChild(labelInput3);
                                            labelInput3.className = "form-check-label";
                                            labelInput3.innerHTML = op_3;
                                        break;
                                        case numOpts == 4:
                                            var div_op3 = document.createElement('div');
                                            div_ops.appendChild(div_op3);
                                            div_op3.className = "form-check";
                                            var input3 = document.createElement('input');
                                            div_op3.appendChild(input3);
                                            input3.className = "form-check-input";
                                            input3.type = "radio";
                                            input3.disabled = "true";
                                            var labelInput3 = document.createElement('label');
                                            div_op3.appendChild(labelInput3);
                                            labelInput3.className = "form-check-label";
                                            labelInput3.innerHTML = op_3;
                                            
                                            var div_op4 = document.createElement('div');
                                            div_ops.appendChild(div_op4);
                                            div_op4.className = "form-check";
                                            var input4 = document.createElement('input');
                                            div_op4.appendChild(input4);
                                            input4.className = "form-check-input";
                                            input4.type = "radio";
                                            input4.disabled = "true";
                                            var labelInput4 = document.createElement('label');
                                            div_op4.appendChild(labelInput4);
                                            labelInput4.className = "form-check-label";
                                            labelInput4.innerHTML = op_4;
                                        break;
                                        case numOpts == 5: 
                                            var div_op3 = document.createElement('div');
                                            div_ops.appendChild(div_op3);
                                            div_op3.className = "form-check";
                                            var input3 = document.createElement('input');
                                            div_op3.appendChild(input3);
                                            input3.className = "form-check-input";
                                            input3.type = "radio";
                                            input3.disabled = "true";
                                            var labelInput3 = document.createElement('label');
                                            div_op3.appendChild(labelInput3);
                                            labelInput3.className = "form-check-label";
                                            labelInput3.innerHTML = op_3;
                                            
                                            var div_op4 = document.createElement('div');
                                            div_ops.appendChild(div_op4);
                                            div_op4.className = "form-check";
                                            var input4 = document.createElement('input');
                                            div_op4.appendChild(input4);
                                            input4.className = "form-check-input";
                                            input4.type = "radio";
                                            input4.disabled = "true";
                                            var labelInput4 = document.createElement('label');
                                            div_op4.appendChild(labelInput4);
                                            labelInput4.className = "form-check-label";
                                            labelInput4.innerHTML = op_4;
                                            
                                            var div_op5 = document.createElement('div');
                                            div_ops.appendChild(div_op5);
                                            div_op5.className = "form-check";
                                            var input5 = document.createElement('input');
                                            div_op5.appendChild(input5);
                                            input5.className = "form-check-input";
                                            input5.type = "radio";
                                            input5.disabled = "true";
                                            var labelInput5 = document.createElement('label');
                                            div_op5.appendChild(labelInput5);
                                            labelInput5.className = "form-check-label";
                                            labelInput5.innerHTML = op_5;
                                        break;
                                    }

                                    form_father = document.getElementById('formVerDados');
                                    form_father.appendChild(div);
                                    
                                    var hr1 = document.createElement('hr');
                                    form_father.appendChild(hr1);
                                ////////////////////////

                                $('#modalAddPergundaEscolhaUnica').modal('hide');
                                $('#modalAddPergundaSuccess').modal('show');
                                $('#formPergundaEscolhaUnica').each (function(){
                                    this.reset();
                                });
                            }
                        },
                    });
                break;
                case tipo == 'ME' : 
                    data = document.getElementsByClassName('MultiplaEscolha');
                    var enunciado = data[0].value,
                    op_1 = data[1].value,
                    op_2 = data[2].value,
                    op_3 = data[3].value,
                    op_4 = data[4].value,
                    op_5 = data[5].value,
                    numOpts = $("input[name='r2']:checked").val();
                    
                    $.ajax({
                        url:"{{ route('pesquisa.addQuest') }}",
                        type: 'post',
                        datatype:'json',
                        data: {
                            _token:'{{ csrf_token() }}',
                            enunciado,
                            op_1,
                            op_2,
                            op_3,
                            op_4,
                            op_5,
                            idPesq,
                            numOpts,
                            tipo,
                        },
                        success:function(retorno){
                            if(retorno['status'] == 'error'){
                                dadosValidacao = document.getElementsByClassName('dadosValidacaoME');
                                dadosValidacao[0].style = "display:none";
                                dadosValidacao[1].style = "display:none";
                                dadosValidacao[2].style = "display:none";
                                dadosValidacao[3].style = "display:none";
                                dadosValidacao[4].style = "display:none";
                                dadosValidacao[5].style = "display:none";
                                retorno[0].forEach(
                                    function mensagem(msg){
                                        if(msg == 'Enunciado')  {dadosValidacao[0].style = "display:block"};
                                        if(msg == 'op1')        {dadosValidacao[1].style = "display:block"};
                                        if(msg == 'op2')        {dadosValidacao[2].style = "display:block"};
                                        if(msg == 'op3')        {dadosValidacao[3].style = "display:block"};
                                        if(msg == 'op4')        {dadosValidacao[4].style = "display:block"};
                                        if(msg == 'op5')        {dadosValidacao[5].style = "display:block"};
                                    }
                                )
                            }else{
                                                            
                                //criar Nova Pergunta
                                    var div = document.createElement('div');
                                    div.className = "row";
                                    
                                    div_col = document.createElement('div');
                                    div.appendChild(div_col);
                                    div_col.className = "col-12";
                                    
                                    var label = document.createElement('label');
                                    div_col.appendChild(label);
                                    label.innerHTML = "Questão "+retorno.numQuest+"(Multipla Escolha):";
                                    label.for = "idmaster";

                                    var br1 = document.createElement('br');
                                    div_col.appendChild(br1);

                                    var btnEditar = document.createElement('span');
                                    div_col.appendChild(btnEditar);
                                    btnEditar.className = "btn btn-info";
                                    btnEditar.innerHTML = "Editar";
                                    btnEditar.style = "margin-right:5px;";
                                    btnEditar.onclick = function(){
                                        editarQuest(tipo, retorno.numQuest, idPesq);
                                    };
                                    var btnExcluir = document.createElement('span');
                                    div_col.appendChild(btnExcluir);
                                    btnExcluir.className = "btn btn-danger";
                                    btnExcluir.innerHTML = "Excluir";
                                    btnExcluir.onclick = function(){
                                        excluirQuest(tipo, retorno.numQuest, idPesq);
                                    };
                                    
                                    var enunciadoTexto = document.createElement('h5');
                                    div_col.appendChild(enunciadoTexto);
                                    enunciadoTexto.innerHTML = "Enunciado: "+enunciado;
                                    enunciadoTexto.id = "enunciado_"+retorno.numQuest;
                                    
                                    var div_ops = document.createElement('div');
                                    div_col.appendChild(div_ops);
                                    div_ops.className = "form-group";

                                    var div_op1 = document.createElement('div');
                                    div_ops.appendChild(div_op1);
                                    div_op1.className = "custom-control custom-checkbox";
                                    var input1 = document.createElement('input');
                                    div_op1.appendChild(input1);
                                    input1.id = "customCheckbox1";
                                    input1.className = "custom-control-input";
                                    input1.type = "checkbox";
                                    input1.disabled = "true";
                                    var labelInput1 = document.createElement('label');
                                    div_op1.appendChild(labelInput1);
                                    labelInput1.className = "custom-control-label";
                                    labelInput1.for = "customCheckbox1";
                                    labelInput1.innerHTML = op_1;
                                    
                                    var div_op2 = document.createElement('div');
                                    div_ops.appendChild(div_op2);
                                    div_op2.className = "custom-control custom-checkbox";
                                    var input2 = document.createElement('input');
                                    div_op2.appendChild(input2);
                                    input2.id = "customCheckbox2";
                                    input2.className = "custom-control-input";
                                    input2.type = "checkbox";
                                    input2.disabled = "true";
                                    var labelInput2 = document.createElement('label');
                                    div_op2.appendChild(labelInput2);
                                    labelInput2.className = "custom-control-label";
                                    labelInput2.for = "customCheckbox2";
                                    labelInput2.innerHTML = op_2;
                                    
                                    switch(true){
                                        case numOpts == 3: 
                                            var div_op3 = document.createElement('div');
                                            div_ops.appendChild(div_op3);
                                            div_op3.className = "custom-control custom-checkbox";
                                            var input3 = document.createElement('input');
                                            div_op3.appendChild(input3);
                                            input3.id = "customCheckbox3";
                                            input3.className = "custom-control-input";
                                            input3.type = "checkbox";
                                            input3.disabled = "true";
                                            var labelInput3 = document.createElement('label');
                                            div_op3.appendChild(labelInput3);
                                            labelInput3.className = "custom-control-label";
                                            labelInput3.for = "customCheckbox3";
                                            labelInput3.innerHTML = op_3;
                                        break;
                                        case numOpts == 4:
                                            var div_op3 = document.createElement('div');
                                            div_ops.appendChild(div_op3);
                                            div_op3.className = "custom-control custom-checkbox";
                                            var input3 = document.createElement('input');
                                            div_op3.appendChild(input3);
                                            input3.id = "customCheckbox3";
                                            input3.className = "custom-control-input";
                                            input3.type = "checkbox";
                                            input3.disabled = "true";
                                            var labelInput3 = document.createElement('label');
                                            div_op3.appendChild(labelInput3);
                                            labelInput3.className = "custom-control-label";
                                            labelInput3.for = "customCheckbox3";
                                            labelInput3.innerHTML = op_3;
                                            
                                            var div_op4 = document.createElement('div');
                                            div_ops.appendChild(div_op4);
                                            div_op4.className = "custom-control custom-checkbox";
                                            var input4 = document.createElement('input');
                                            div_op4.appendChild(input4);
                                            input4.id = "customCheckbox4";
                                            input4.className = "custom-control-input";
                                            input4.type = "checkbox";
                                            input4.disabled = "true";
                                            var labelInput4 = document.createElement('label');
                                            div_op4.appendChild(labelInput4);
                                            labelInput4.className = "custom-control-label";
                                            labelInput4.for = "customCheckbox4";
                                            labelInput4.innerHTML = op_4;
                                        break;
                                        case numOpts == 5: 
                                            var div_op3 = document.createElement('div');
                                            div_ops.appendChild(div_op3);
                                            div_op3.className = "custom-control custom-checkbox";
                                            var input3 = document.createElement('input');
                                            div_op3.appendChild(input3);
                                            input3.id = "customCheckbox3";
                                            input3.className = "custom-control-input";
                                            input3.type = "checkbox";
                                            input3.disabled = "true";
                                            var labelInput3 = document.createElement('label');
                                            div_op3.appendChild(labelInput3);
                                            labelInput3.className = "custom-control-label";
                                            labelInput3.for = "customCheckbox3";
                                            labelInput3.innerHTML = op_3;
                                            
                                            var div_op4 = document.createElement('div');
                                            div_ops.appendChild(div_op4);
                                            div_op4.className = "custom-control custom-checkbox";
                                            var input4 = document.createElement('input');
                                            div_op4.appendChild(input4);
                                            input4.id = "customCheckbox4";
                                            input4.className = "custom-control-input";
                                            input4.type = "checkbox";
                                            input4.disabled = "true";
                                            var labelInput4 = document.createElement('label');
                                            div_op4.appendChild(labelInput4);
                                            labelInput4.className = "custom-control-label";
                                            labelInput4.for = "customCheckbox4";
                                            labelInput4.innerHTML = op_4;
                                            
                                            var div_op5 = document.createElement('div');
                                            div_ops.appendChild(div_op5);
                                            div_op5.className = "custom-control custom-checkbox";
                                            var input5 = document.createElement('input');
                                            div_op5.appendChild(input5);
                                            input5.id = "customCheckbox5";
                                            input5.className = "custom-control-input";
                                            input5.type = "checkbox";
                                            input5.disabled = "true";
                                            var labelInput5 = document.createElement('label');
                                            div_op5.appendChild(labelInput5);
                                            labelInput5.className = "custom-control-label";
                                            labelInput5.for = "customCheckbox5";
                                            labelInput5.innerHTML = op_5;
                                        break;
                                    }

                                    form_father = document.getElementById('formVerDados');
                                    form_father.appendChild(div);
                                    
                                    var hr1 = document.createElement('hr');
                                    form_father.appendChild(hr1);
                                ////////////////////////

                                $('#modalAddPergundaMultiplaEscolha').modal('hide');
                                $('#modalAddPergundaSuccess').modal('show');
                                $('#formPergundaMultiplaEscolha').each (function(){
                                    this.reset();
                                });
                            }
                        },
                    });
                break;
                case tipo == 'SN' : 
                    data = document.getElementsByClassName('EnunciadoSN');
                    var enunciado = data[0].value;
                    
                    $.ajax({
                        url:"{{ route('pesquisa.addQuest') }}",
                        type: 'post',
                        datatype:'json',
                        data: {
                            _token:'{{ csrf_token() }}',
                            enunciado,
                            idPesq,
                            tipo,
                        },
                        success:function(retorno){
                            if(retorno['status'] == 'error'){
                                dadosValidacao = document.getElementsByClassName('dadosValidacaoSN');
                                dadosValidacao[0].style = "display:none";
                                retorno[0].forEach(
                                    function mensagem(msg){
                                        if(msg == 'Enunciado')  {dadosValidacao[0].style = "display:block"};
                                    }
                                )
                            }else{

                                //criar Nova Pergunta
                                var div = document.createElement('div');
                                div.className = "row";
                                
                                div_col = document.createElement('div');
                                div.appendChild(div_col);
                                div_col.className = "col-12";
                                
                                var label = document.createElement('label');
                                div_col.appendChild(label);
                                label.innerHTML = "Questão "+retorno.numQuest+"(Sim/Não):";
                                label.for = "idmaster";

                                var br1 = document.createElement('br');
                                div_col.appendChild(br1);

                                var btnEditar = document.createElement('span');
                                div_col.appendChild(btnEditar);
                                btnEditar.className = "btn btn-info";
                                btnEditar.innerHTML = "Editar";
                                btnEditar.style = "margin-right:5px;";
                                btnEditar.onclick = function(){
                                    editarQuest(tipo, retorno.numQuest, idPesq);
                                };
                                var btnExcluir = document.createElement('span');
                                div_col.appendChild(btnExcluir);
                                btnExcluir.className = "btn btn-danger";
                                btnExcluir.innerHTML = "Excluir";
                                btnExcluir.onclick = function(){
                                    excluirQuest(tipo, retorno.numQuest, idPesq);
                                };
                                
                                var enunciadoTX = document.createElement('h5');
                                div_col.appendChild(enunciadoTX);
                                enunciadoTX.innerHTML = "Enunciado: "+enunciado;
                                enunciadoTX.id = "enunciado_"+retorno.numQuest;
                                
                                var div_ops = document.createElement('div');
                                div_col.appendChild(div_ops);
                                div_ops.className = "form-group";

                                var div_op1 = document.createElement('div');
                                div_ops.appendChild(div_op1);
                                div_op1.className = "form-check";
                                var input1 = document.createElement('input');
                                div_op1.appendChild(input1);
                                input1.className = "form-check-input";
                                input1.type = "radio";
                                input1.disabled = "true";
                                var labelInput1 = document.createElement('label');
                                div_op1.appendChild(labelInput1);
                                labelInput1.className = "form-check-label";
                                labelInput1.innerHTML = "SIM";
                                
                                var div_op2 = document.createElement('div');
                                div_ops.appendChild(div_op2);
                                div_op2.className = "form-check";
                                var input2 = document.createElement('input');
                                div_op2.appendChild(input2);
                                input2.className = "form-check-input";
                                input2.type = "radio";
                                input2.disabled = "true";
                                var labelInput2 = document.createElement('label');
                                div_op2.appendChild(labelInput2);
                                labelInput2.className = "form-check-label";
                                labelInput2.innerHTML = "NÂO";
                                
                                form_father = document.getElementById('formVerDados');
                                form_father.appendChild(div);
                                
                                var hr1 = document.createElement('hr');
                                form_father.appendChild(hr1);
                                ///////////////////////


                                $('#modalAddPergundaSN').modal('hide');
                                $('#modalAddPergundaSuccess').modal('show');
                                $('#formPergundaSN').each (function(){
                                    this.reset();
                                });
                            }
                        },
                    });
                break;
                case tipo == 'ZD' :                     
                    data = document.getElementsByClassName('EnunciadoZD');
                    var enunciado = data[0].value;
                    
                    $.ajax({
                        url:"{{ route('pesquisa.addQuest') }}",
                        type: 'post',
                        datatype:'json',
                        data: {
                            _token:'{{ csrf_token() }}',
                            enunciado,
                            idPesq,
                            tipo,
                        },
                        success:function(retorno){
                            if(retorno['status'] == 'error'){
                                dadosValidacao = document.getElementsByClassName('dadosValidacaoZD');
                                dadosValidacao[0].style = "display:none";
                                retorno[0].forEach(
                                    function mensagem(msg){
                                        if(msg == 'Enunciado')  {dadosValidacao[0].style = "display:block"};
                                    }
                                )
                            }else{

                                //criar Nova Pergunta
                                var div = document.createElement('div');
                                div.className = "row";
                                
                                div_col = document.createElement('div');
                                div.appendChild(div_col);
                                div_col.className = "col-12";
                                
                                var label = document.createElement('label');
                                div_col.appendChild(label);
                                label.innerHTML = "Questão "+retorno.numQuest+"(Zero a Dez):";
                                label.for = "idmaster";

                                var br1 = document.createElement('br');
                                div_col.appendChild(br1);

                                var btnEditar = document.createElement('span');
                                div_col.appendChild(btnEditar);
                                btnEditar.className = "btn btn-info";
                                btnEditar.innerHTML = "Editar";
                                btnEditar.style = "margin-right:5px;";
                                btnEditar.onclick = function(){
                                    editarQuest(tipo, retorno.numQuest, idPesq);
                                };
                                var btnExcluir = document.createElement('span');
                                div_col.appendChild(btnExcluir);
                                btnExcluir.className = "btn btn-danger";
                                btnExcluir.innerHTML = "Excluir";
                                btnExcluir.onclick = function(){
                                    excluirQuest(tipo, retorno.numQuest, idPesq);
                                };
                                
                                var enunciadoTX = document.createElement('h5');
                                div_col.appendChild(enunciadoTX);
                                enunciadoTX.innerHTML = "Enunciado: "+enunciado;
                                enunciadoTX.id = "enunciado_"+retorno.numQuest;
                                
                                var div_ops = document.createElement('div');
                                div_col.appendChild(div_ops);
                                div_ops.className = "form-group";

                                for (a=1;a<=10;a++){
                                    var div_op = document.createElement('div');
                                    div_ops.appendChild(div_op);
                                    div_op.className = "form-check";
                                    var input = document.createElement('input');
                                    div_op.appendChild(input);
                                    input.className = "form-check-input";
                                    input.type = "radio";
                                    input.disabled = "true";
                                    var labelInput = document.createElement('label');
                                    div_op.appendChild(labelInput);
                                    labelInput.className = "form-check-label";
                                    labelInput.innerHTML = a;
                                }

                                form_father = document.getElementById('formVerDados');
                                form_father.appendChild(div);
                                
                                var hr1 = document.createElement('hr');
                                form_father.appendChild(hr1);
                                ///////////////////////

                                $('#modalAddPergunda0a10').modal('hide');
                                $('#modalAddPergundaSuccess').modal('show');
                                $('#formPergundaZD').each (function(){
                                    this.reset();
                                });
                            }
                        },
                    });
                break;
            }
        }

        function perguntaTipo(tipo){
            botao = document.getElementById('botaoNewQuest');
            botao.onclick = function(){
                return modalNewQuest(tipo);
            };
        }
  
    </script>
@stop