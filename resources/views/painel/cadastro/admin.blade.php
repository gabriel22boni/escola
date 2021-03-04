@extends('adminlte::page')

@section('title', 'Cadastros - Professor')

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
                Professores Cadastrados
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
                        <form action="{{ route('cadastros.admin.search') }}" method="POST" class="form form-inline">
                            {!! csrf_field() !!}
                            <input name="data" type="text" class="form-control" placeholder="Nome">
                            &nbsp&nbsp&nbsp<button $type="submit" class="btn btn-primary">Filtrar</button>
                        </form>
                        
                    </div>
                    <div class="card-tools float-right">
                        @if(isset($dataForm))
                            {!! $cadAdms->appends($dataForm ?? '')->links() !!} 
                        @else
                            {!! $cadAdms->links() !!}     
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
                            @foreach($cadAdms as $cadAdm)
                                <tr id="clienteRow{{$cadAdm->id}}">
                                    <td>{{$cadAdm->id}}.</td>
                                    <td>{{$cadAdm->nome}}</td>
                                    <td>
                                        <center>
                                            <button onclick="modalDados({{$cadAdm->id}})" type="button" class="btn btn-primary" style="width:100px;">
                                                Ver
                                            </button>
                                        </center>
                                    </td>
                                    <td>
                                        <center>
                                            <button onclick="modalEditar({{$cadAdm->id}})" type="button" class="btn btn-secondary" style="width:100px;">
                                                Editar
                                            </button>
                                        </center>
                                    </td>
                                    <td>
                                        <center>
                                            <button onclick="modalDel({{$cadAdm->id}},'confirm')" type="button" class="btn btn-danger" style="width:100px;">
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
                Cadastrar Professor
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
            <input type="text" class="form-control formData" id="image" name="image" style="display:none">
                <div class="row">
                    @if(
                        auth()->user()->nivel=='CEO'
                    )
                    <div class="form-group col-sm-8">
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
                        <div class="form-group col-sm-10">
                            <input style="display:none" type="text" class="form-control formData" id="idmaster" name="idmaster" value="{{auth()->user()->idmas}}">
                        </div>
                    @endif
                </div>
                <div class="row" id="pessoaF">
                    <div class="form-group col-sm-10">
                        <label for="nome">Nome</label>
                        <input type="text" class="form-control formData" id="nome" name="nome" placeholder="Nome">
                    </div>
                    <div class="form-group col-sm-2">
                        <label for="cpf">CPF</label>
                        <input type="text" class="form-control formData" formData id="cpf" name="cpf" placeholder="123.456.789-01">
                    </div>
                    
                </div>
                <div class="row">
                    <div class="form-group col-sm-6">
                        <label for="endereco">Endereço</label>
                        <input type="text" class="form-control formData" id="endereco" name ="endereco" placeholder="R. Bandeirantes">
                    </div>
                    <div class="form-group col-sm">
                        <label for="numero">Número</label>
                        <input type="text" class="form-control formData" id="numero" name="numero" placeholder="4301">
                    </div>
                    <div class="form-group col-sm-2">
                        <label for="cep">CEP</label>
                        <input type="text" class="form-control formData" id="cep" name="cep" placeholder="84.000-000">
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-sm-6">
                        <label for="bairro">Bairro</label>
                        <input type="text" class="form-control formData" id="bairro" name="bairro" placeholder="Santo Antônio">
                    </div>
                    <div class="form-group col-sm-3">
                        <label for="estado">Estado</label>
                        <select name="estado" class="form-control formData" onchange="display_city(this.value)" id="estado">
                            <option value="">-- Estado --</option>
                            @foreach($stateNames as $nameState)
                                <option value="{{$nameState->id}}">{{$nameState->name}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group col-sm-3">
                        <label for="cidade">Cidade</label>
                        <select name="cidade" class="form-control formData" id="cidade">
                            <option value="">-- Cidade --</option>
                        </select>
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-sm-3">
                        <label for="email">E-mail</label>
                        <input type="email" class="form-control formData" id="email" name="email" placeholder="example@email.com">
                    </div>
                    <div class="form-group col-sm-3">
                        <label for="password">Senha</label>
                        <input type="password" class="form-control formData" id="password" name="password" placeholder="********">
                    </div>
                    <div class="form-group col-sm-3">
                        <label for="fone">Telefone</label>
                        <input type="text" class="form-control formData" id="fone" name="fone" placeholder="(12) 3123-4567">
                    </div>
                    <div class="form-group col-sm-3">
                        <label for="cel">Celular</label>
                        <input type="text" class="form-control formData" id="cel" name="cel" placeholder="(12) 9 9123-4567">
                    </div>
                </div>
            </form>
            <div class="alert" id="message" style="display:none"></div>
            <div class="row">
                <div class="form-group col-sm-11">
                    <form method="post" id="upload_form" enctype="multipart/form-data">
                        {{ csrf_field() }}
                        <div class="form-group">
                            <table class="table">
                                <tr>
                                    <td width="40%" align="right"><label>Imagem:</label></td>
                                    <td width="30%"><input type="file" name="select_file"/></td>
                                    <td width="30%" align="left"><input type="submit" name="upload" id="upload" class="btn btn-primary" value="upload"></td>
                                </tr>
                            </table>
                        </div>
                    </form>
                </div>
                <div class="form-group col-sm-1">
                    <span id="uploaded_image"></span>
                </div>
            </div>
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
                    <center><p>Administrador Cadastrado com sucesso.</p></center>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default float-rigth" data-dismiss="modal" onclick="pageRefresh()">Close</button>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div>

    <div class="modal fade" id="modalVer" style="display: none;" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Visualizar Cadastro</h4>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
                <div class="modal-body">
                    <form action="" method="POST" id="formCadastro" >
                        <div class="row">
                            <div class="col-sm-12 col-md-2 col-lg-2"><!-- Coluna esquerda -->
                                <div class="row">
                                    <img src="" alt="" class=" img-thumbnail formDataVer" name="imageVer" id="imageVer"><!-- linha (imagen)-->
                                </div>
                            </div>
                            <div class="col-sm-12 col-md-10 col-lg-10"><!-- Coluna direita -->
                                <div class="row">
                                    <div class="form-group col-sm-4">
                                        <label for="idmasterVer">Escola</label>
                                        <select class="form-control" disabled="">
                                            <option name="idmasterVer" class="formDataVer" id="idmasterVer">Escola Nome</option>
                                        </select>
                                    </div>
                                    <div class="form-group col-sm-3">
                                    </div>
                                </div>
                                <div class="row" style="display:none" id="pessoaFVer">
                                    <div class="form-group col-sm-10">
                                        <label for="nomeVer">Nome</label>
                                        <input type="text" class="form-control formDataVer" id="nomeVer" name="nomeVer" placeholder="Nome" disabled="">
                                    </div>
                                    <div class="form-group col-sm-2">
                                        <label for="cpfVer">CPF</label>
                                        <input type="text" class="form-control formDataVer" formData id="cpfVer" name="cpfVer" placeholder="123.456.789-01" disabled="">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group col-sm-6">
                                        <label for="enderecoVer">Endereço</label>
                                        <input type="text" class="form-control formDataVer" id="enderecoVer" name ="enderecoVer" placeholder="R. Bandeirantes" disabled="">
                                    </div>
                                    <div class="form-group col-sm">
                                        <label for="numeroVer">Número</label>
                                        <input type="text" class="form-control formDataVer" id="numeroVer" name="numeroVer" placeholder="4301" disabled="">
                                    </div>
                                    <div class="form-group col-sm-2">
                                        <label for="cepVer">CEP</label>
                                        <input type="text" class="form-control formDataVer" id="cepVer" name="cepVer" placeholder="84.000-000" disabled="">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group col-sm-6">
                                        <label for="bairroVer">Bairro</label>
                                        <input type="text" class="form-control formDataVer" id="bairroVer" name="bairroVer" placeholder="Santo Antônio" disabled="">
                                    </div>
                                    <div class="form-group col-sm-3">
                                        <label for="estadoVer">Estado</label>
                                        <select class="form-control" onchange="display_city(this.value)" disabled="">
                                                <option name="estadoVer" id="estadoVer" class="formDataVer">Estado</option>
                                        </select>
                                    </div>
                                    <div class="form-group col-sm-3">
                                        <label for="cidadeVer">Cidade</label>
                                        <select class="form-control" disabled="">
                                            <option name="cidadeVer" id="cidadeVer" class="formDataVer" value="">Cidade</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group col-sm-6">
                                        <label for="emailVer">E-mail</label>
                                        <input type="email" class="form-control formDataVer" id="emailVer" name="emailVer" placeholder="example@email.com" disabled="">
                                    </div>
                                    <div class="form-group col-sm-3">
                                        <label for="foneVer">Telefone</label>
                                        <input type="text" class="form-control formDataVer" id="foneVer" name="foneVer" placeholder="(12) 3123-4567" disabled="">
                                    </div>
                                    <div class="form-group col-sm-3">
                                        <label for="celVer">Celular</label>
                                        <input type="text" class="form-control formDataVer" id="celVer" name="celVer" placeholder="(12) 9 9123-4567" disabled="">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modalEdit" style="display: none;" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-sm-12 col-md-2 col-lg-2">
                            <img src="" class="img-thumbnail formDataEdit" id="imageShowEdit" name="imageShowEdit">
                            <div class="alert" id="message2" style="display:none"></div>
                            <center>
                                <label for="idcobEdit">Alterar Imagem:</label>
                                <span class="btn btn-info" id="btnFileFalso">Alterar</span>
                                </br></br>
                                <span class="btn btn-primary" id="btnUpFalso">Upload</span>
                                </br>
                                <span id="fakeText" style="text-size:8px;">Nenhum Arquivo Selecionado.</span>
                            </center>
                        </div>
                        <form method="post" id="upload_form2" enctype="multipart/form-data" hidden="hidden">
                            {{ csrf_field() }}
                            Alterar Imagem:
                            <input type="file" name="select_file" name="select_file2" id="select_file2"/>
                            <input type="submit" name="upload2" id="upload2" class="btn btn-primary float-left" value="upload">
                        </form>
                        <div class="col-sm-12 col-md-10 col-lg-10">    
                            <form action="" method="POST" id="formAlterCli" >
                                <input type="text" class="form-control formDataEdit" id="imageEdit" name="imageEdit" style="display:none;" value="">
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
                                            <div class="form-group col-sm-4" style="display:none;">
                                                <label for="idmasterEdit">M. Administradorrador</label>
                                                <select name="idmasterEditSelect" id="idmasterEditSelect" class="form-control formDataEditSelect">
                                                    <option name="idmasterEdit" class="formDataEdit" id="idmasterEdit" value="">Escola</option>
                                                </select>
                                            </div>
                                            <div class="form-group col-sm-7">
                                            </div>
                                        @endif
                                    </div>
                                    <div class="row" style="display:none" id="pessoaFEdit">
                                        <div class="form-group col-sm-10">
                                            <label for="nomeEdit">Nome</label>
                                            <input type="text" class="form-control formDataEdit" id="nomeEdit" name="nomeEdit" placeholder="Nome">
                                        </div>
                                        <div class="form-group col-sm-2">
                                            <label for="cpfEdit">CPF</label>
                                            <input type="text" class="form-control formDataEdit" formData id="cpfEdit" name="cpfEdit" placeholder="123.456.789-01">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="form-group col-sm-6">
                                            <label for="enderecoEdit">Endereço</label>
                                            <input type="text" class="form-control formDataEdit" id="enderecoEdit" name ="enderecoEdit" placeholder="R. Bandeirantes">
                                        </div>
                                        <div class="form-group col-sm">
                                            <label for="numeroEdit">Número</label>
                                            <input type="text" class="form-control formDataEdit" id="numeroEdit" name="numeroEdit" placeholder="4301">
                                        </div>
                                        <div class="form-group col-sm-2">
                                            <label for="cepEdit">CEP</label>
                                            <input type="text" class="form-control formDataEdit" id="cepEdit" name="cepEdit" placeholder="84.000-000">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="form-group col-sm-6">
                                            <label for="bairroEdit">Bairro</label>
                                            <input type="text" class="form-control formDataEdit" id="bairroEdit" name="bairroEdit" placeholder="Santo Antônio">
                                        </div>
                                        <div class="form-group col-sm-3">
                                            <label for="estadoEdit">Estado</label>
                                            <select id="estadoEdit" name="estadoEdit" class="form-control formDataEdit" onchange="display_cityEdit(this.value)">
                                                <option id="estadoEditPad" name="estadoEditPad" class="formDataEditPad" value=""></option>
                                                @foreach($stateNames as $nameState)
                                                    <option value="{{$nameState->id}}">{{$nameState->name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="form-group col-sm-3">
                                            <label for="cidadeEdit">Cidade</label>
                                            <select id="selectCidadeEdit" class="form-control">
                                                <option name="cidadeEdit" id="cidadeEdit" class="formDataEdit" value="">Cidade</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="form-group col-sm-6">
                                            <label for="emailEdit">E-mail</label>
                                            <input type="email" class="form-control formDataEdit" id="emailEdit" name="emailEdit" placeholder="example@email.com">
                                        </div>
                                        <div class="form-group col-sm-3">
                                            <label for="foneEdit">Telefone</label>
                                            <input type="text" class="form-control formDataEdit" id="foneEdit" name="foneEdit" placeholder="(12) 3123-4567">
                                        </div>
                                        <div class="form-group col-sm-3">
                                            <label for="celEdit">Celular</label>
                                            <input type="text" class="form-control formDataEdit" id="celEdit" name="celEdit" placeholder="(12) 9 9123-4567">
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>                        
                    </div>
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
                    Deseja realmente excluir o cliente?
                    <div id="dadosModalDelPF">
                        <strong>id: </strong> <span id="idDel" class="dadosModalDel"></span></br>
                        <strong>Nome: </strong> <span id="NomeDel" class="dadosModalDel"></span></br>
                        <strong>CPF: </strong> <span id="CPFDel" class="dadosModalDel"></span>
                    </div>
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
                    Cliente excluído com sucesso.
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

    <div class="modal fade" id="ModalEmailDup" style="display: none;" aria-hidden="true">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Oops!</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    Email já existe, favor informar outro, ou deixar o campo vazio para manter o mesmo.
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default float-right" data-dismiss="modal">OK</button>
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
        $(document).ready(function(){
            
            $("#numero").mask("000000000");
            $("#cpf").mask("000.000.000-00");
            $("#cep").mask("00.000-000");
            $("#fone").mask("(00)0000-0000");
            $("#cel").mask("(00) 0000-00009");
            $("#cel").blur(function(event){
                if($(this).val().length == 15){
                    $("#cel").mask("(00) 00000-0009");
                }else{
                    $("#cel").mask("(00) 0000-00009");
                }
            });

            $("#numeroEdit").mask("000000000");
            $("#cpfEdit").mask("000.000.000-00");
            $("#cepEdit").mask("00.000-000");
            $("#foneEdit").mask("(00)0000-0000");
            $("#celEdit").mask("(00) 0000-00009");
            $("#celEdit").blur(function(event){
                if($(this).val().length == 15){
                    $("#celEdit").mask("(00) 00000-0009");
                }else{
                    $("#celEdit").mask("(00) 0000-00009");
                }
            });

            $('#upload_form').on('submit', function(event){
                event.preventDefault();
                $.ajax({
                    url:"{{ route('produto.upload') }}",
                    method:"post",
                    data: new FormData(this),
                    dataType:'json',
                    contentType: false,
                    cache:false,
                    processData:false,
                    success:function(data){
                        var camponome = document.getElementById('image').value = data.name;
                        $('#message').css('display', 'block');
                        $('#message').html(data.message);
                        document.getElementById('message').className = data.class_name;
                        $('#uploaded_image').html(data.uploaded_image);
                        
                    },
                })
            });

            $('#upload_form2').on('submit', function(event){
                event.preventDefault();
                $.ajax({
                    url:"{{ route('produto.upload') }}",
                    method:"post",
                    data: new FormData(this),
                    dataType:'json',
                    contentType: false,
                    cache:false,
                    processData:false,
                    success:function(data){
                        $('#message2').css('display', 'block');
                        $('#message2').html(data.message);
                        document.getElementById('message2').className = data.class_name;
                        if(data.message == 'Upload Realizado com Sucesso'){
                            document.getElementById('imageEdit').value = data.name;
                            document.getElementById('imageShowEdit').src = "/images/"+data.name;
                        }
                    },
                })
            });
        });

        var pessoa = 'F';
        
        function display_city(stateId){
            var cidades;
            $.ajax({
                type: 'post',
                dataType: 'json',
                data: {
                    "_token": "{{ csrf_token() }}",
                    stateId
                },
                url: "{{ route('search.state') }}",
                success: function(retorno){
                    cidades = retorno;
                    var select = document.getElementById("cidade");
                    select.innerHTML = "";
                    var option = document.createElement("option");
                    option.innerHTML = "-- Cidade --";
                    option.value = "";
                    select.appendChild(option);
                    for(var i=0; i < cidades.length; i++)
                    {
                        option = document.createElement("option");
                        option.innerHTML = cidades[i].name;
                        option.value = cidades[i].id;
                        select.appendChild(option);
                    }
                    var cidade = '{!! $dataForm['cidade'] ?? 'nulo' !!}';    
                    if (cidade != 'nulo') {
                        $('#select-cidade   option[value="{!! $dataForm['cidade']     ?? 'nulo' !!}"]').attr('selected', 'selected');
                    };
                },
            });
        };

        function display_cityEdit(stateId){
            var cidades;
            $.ajax({
                type: 'post',
                dataType: 'json',
                data: {
                    "_token": "{{ csrf_token() }}",
                    stateId
                },
                url: "{{ route('search.state') }}",
                success: function(retorno){
                    cidades = retorno;
                    var select = document.getElementById("selectCidadeEdit");
                    select.innerHTML = "";
                    var option = document.createElement("option");
                    option.innerHTML = "-- Cidade --";
                    option.value = "";
                    select.appendChild(option);
                    for(var i=0; i < cidades.length; i++)
                    {
                        option = document.createElement("option");
                        option.innerHTML = cidades[i].name;
                        option.value = cidades[i].id;   
                        select.appendChild(option);
                    }
                    var cidade = '{!! $dataForm['cidade'] ?? 'nulo' !!}';    
                    if (cidade != 'nulo') {
                        $('#select-cidade   option[value="{!! $dataForm['cidade']     ?? 'nulo' !!}"]').attr('selected', 'selected');
                    };
                },
            });
        };

        function formSubmit (){
            bairro = document.getElementsByClassName('formData').bairro.value,
            cidade = document.getElementsByClassName('formData').cidade.value,
            endereco = document.getElementsByClassName('formData').endereco.value,
            estado = document.getElementsByClassName('formData').estado.value,
            nome = document.getElementsByClassName('formData').nome.value,
            numero = document.getElementsByClassName('formData').numero.value,
            cpf = document.getElementsByClassName('formData').cpf.value,                        
            cep = document.getElementsByClassName('formData').cep.value,                        
            email = document.getElementsByClassName('formData').email.value,                       
            password = document.getElementsByClassName('formData').password.value,                       
            fone = document.getElementsByClassName('formData').fone.value,                       
            cel = document.getElementsByClassName('formData').cel.value,          
            image = document.getElementsByClassName('formData').image.value,
            idmaster = document.getElementsByClassName('formData').idmaster.value;        

            $.ajax({
                type: "POST",
                url: "{{ route('cadastros.admin.insert') }}",
                data: {
                    _token:'{{csrf_token()}}',
                    bairro,
                    cidade,
                    endereco,
                    estado,
                    nome,
                    numero,
                    cpf,
                    cep,
                    email,
                    password,
                    fone,
                    cel,
                    pessoa,
                    idmaster,
                    image,
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
                error:function(error){console.log(error);},
            });
            
            return false;

        };
        
        function resetForm(){
            $('#formCadastro').each (function(){
                this.reset();
            });
            pessoaAlter(pessoa);
        }

        function pageRefresh(){
            window.location.href = "{{route('cadastros.admin')}}";
        }

        function modalDados(id){
            $.ajax({
                url:"{{ route('cadastros.admin.dados') }}",
                type:"post",
                datatype:"json",
                data:{
                    _token:"{{csrf_token()}}",
                    id,
                },
                success:function(retorno){
                    var elementos = document.getElementsByClassName('formDataVer');
                    document.getElementsByClassName('formDataVer').bairroVer.value        = retorno[0].bairro;
                    document.getElementsByClassName('formDataVer').celVer.value           = retorno[0].cel;       
                    document.getElementsByClassName('formDataVer').cepVer.value           = retorno[0].cep;       
                    document.getElementsByClassName('formDataVer').cidadeVer.innerHTML    = retorno[0].cidade;          
                    document.getElementsByClassName('formDataVer').emailVer.value         = retorno[0].email;         
                    document.getElementsByClassName('formDataVer').enderecoVer.value      = retorno[0].endereco;            
                    document.getElementsByClassName('formDataVer').estadoVer.innerHTML    = retorno[0].estado;          
                    document.getElementsByClassName('formDataVer').foneVer.value          = retorno[0].fone;        
                    document.getElementsByClassName('formDataVer').numeroVer.value        = retorno[0].numero;         
                    document.getElementsByClassName('formDataVer').imageVer.src          = "/images/"+retorno[0].image;                   
                    if(retorno[0].fnomeadmaster == null){
                        document.getElementsByClassName('formDataVer').idmasterVer.innerHTML = retorno[0].nomeadmaster;         
                    }else{
                        document.getElementsByClassName('formDataVer').idmasterVer.innerHTML = retorno[0].fnomeadmaster;         
                    }       
                    document.getElementById('pessoaFVer').style = "display:;";
                    document.getElementsByClassName('formDataVer').nomeVer.value          = retorno[0].nome;        
                    document.getElementsByClassName('formDataVer').cpfVer.value           = retorno[0].cpf;       
                $('#modalVer').modal('show');
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
                    url:"{{ route('cadastros.admin.dados') }}",
                    success:function(retorno){
                        dados = document.getElementsByClassName('dadosModalDel');
                        dados[7].onclick = function(){
                            return modalDel(id);
                        };
                            var divpf = document.getElementById('dadosModalDelPF'),
                            divpj = document.getElementById('dadosModalDelPJ');
                            
                            divpf.style = "display:;";
                            dados[0].innerHTML = id;
                            dados[1].innerHTML = retorno[0].nome;
                            dados[2].innerHTML = retorno[0].cpf;
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
                    url:"{{ route('admin.delete') }}",
                    success:function(retorno){
                        rowDeleted = document.getElementById('clienteRow'+id);
                        rowDeleted.style = "display:none;";
                        $('#modalDel').modal('show');
                    },
                });
            }
        }

        function modalEditF(){
            $('#formAlterCli').each (function(){
                this.reset();
            });
        }
        
        function modalEditar(id){
            $('#message2').css('display', 'none');
            const customTxt = document.getElementById("fakeText");
            customTxt.innerHTML = "Nenhum Arquivo Selecionado.";
            modalEditF();
            $.ajax({
                url:"{{ route('cadastros.admin.dados') }}",
                type:"post",
                datatype:"json",
                data:{
                    _token:"{{csrf_token()}}",
                    id,
                },
                success:function(retorno){
                    console.log(retorno);
                    var elementos = document.getElementsByClassName('formDataEdit');
                    elementos.idEdit.value                  = id;
                    elementos.bairroEdit.placeholder        = retorno[0].bairro;
                    elementos.celEdit.placeholder           = retorno[0].cel;       
                    elementos.cepEdit.placeholder           = retorno[0].cep;       
                    elementos.cidadeEdit.innerHTML          = retorno[0].cidade;          
                    elementos.emailEdit.placeholder         = retorno[0].email;         
                    elementos.enderecoEdit.placeholder      = retorno[0].endereco;            
                    document.getElementsByClassName('formDataEditPad').estadoEditPad.innerHTML = retorno[0].estado;         
                    elementos.foneEdit.placeholder          = retorno[0].fone;        
                    elementos.numeroEdit.placeholder        = retorno[0].numero;   
                    elementos.imageShowEdit.src        = '/images/'+retorno[0].image;          
                    if(retorno[0].fnomeadmaster == null){
                        elementos.idmasterEdit.innerHTML = retorno[0].nomeadmaster;         
                    }else{
                        elementos.idmasterEdit.innerHTML = retorno[0].fnomeadmaster;         
                    }
                    document.getElementById('pessoaFEdit').style = "display:;";
                    elementos.nomeEdit.placeholder          = retorno[0].nome;        
                    elementos.cpfEdit.placeholder           = retorno[0].cpf;       
                    $('#modalEdit').modal('show');
                },
            });
        }

        function ModalConfAlter(){
            var testeeeee = 'testeeee';
            id = document.getElementsByClassName('formDataEdit').idEdit.value, 
            idmaster = document.getElementsByClassName('formDataEditSelect').idmasterEditSelect.value, 
            nome = document.getElementsByClassName('formDataEdit').nomeEdit.value,
            cpf = document.getElementsByClassName('formDataEdit').cpfEdit.value,                        
            endereco = document.getElementsByClassName('formDataEdit').enderecoEdit.value,
            numero = document.getElementsByClassName('formDataEdit').numeroEdit.value,
            cep = document.getElementsByClassName('formDataEdit').cepEdit.value,                        
            bairro = document.getElementsByClassName('formDataEdit').bairroEdit.value,
            estado = document.getElementsByClassName('formDataEdit').estadoEdit.value,
            cidade = document.getElementById('selectCidadeEdit').value,
            email = document.getElementsByClassName('formDataEdit').emailEdit.value,                       
            fone = document.getElementsByClassName('formDataEdit').foneEdit.value,                       
            cel = document.getElementsByClassName('formDataEdit').celEdit.value,          
            image = document.getElementsByClassName('formDataEdit').imageEdit.value; 

            $.ajax({
                type:"post",
                datatype:"json",
                data:{
                    _token:"{{ csrf_token() }}",
                    id,
                    idmaster,
                    nome,
                    cpf,
                    endereco,
                    numero,
                    cep,
                    bairro,
                    estado,
                    cidade,
                    email,
                    fone,
                    cel,
                    image,
                },
                url:"{{ route('admin.update') }}",
                success:function(retorno){
                    console.log(retorno);
                    if(retorno['status'] == 'mailerror'){
                        $('#ModalEmailDup').modal('show');
                    }else{
                        if(retorno['status'] == 'vazio'){
                            $('#ModalVazio').modal('show');
                        }else{
                            $('#ModalConfAlt').modal('show');
                            $('#modalEdit').modal('hide');
                        }
                        
                    }
                },
                error:function(error){
                    console.log(error);
                },
            });
            
        }

        const realFileBtn = document.getElementById("select_file2");
        const upload2 = document.getElementById("upload2");
        const customBtn = document.getElementById("btnFileFalso");
        const btnUpFalso = document.getElementById("btnUpFalso");
        const customTxt = document.getElementById("fakeText");

        btnUpFalso.addEventListener("click", function(){
            upload2.click();
        });

        customBtn.addEventListener("click", function(){
            realFileBtn.click();
        });

        realFileBtn.addEventListener("change",function(){
            if(realFileBtn.value){
                customTxt.innerHTML = realFileBtn.value.match(/[\/\\]([\w\d\s\.\-\(\)]+)$/)[1];
            }else{
                customTxt.innerHTML = "Nenhum Arquivo Selecionado.";
            }
        });
    </script>
@stop