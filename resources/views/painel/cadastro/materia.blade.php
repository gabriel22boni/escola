@extends('adminlte::page')

@section('title', 'Cadastros - Materia')

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
                Matérias Cadastrados
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
                        <form action="{{ route('cadastros.materia.search') }}" method="POST" class="form form-inline">
                            {!! csrf_field() !!}
                            <input name="data" type="text" class="form-control" placeholder="Nome">
                            &nbsp&nbsp&nbsp<button $type="submit" class="btn btn-primary">Filtrar</button>
                        </form>
                        
                    </div>
                    <div class="card-tools float-right">
                        @if(isset($dataForm))
                            {!! $cadMats->appends($dataForm ?? '')->links() !!} 
                        @else
                            {!! $cadMats->links() !!}     
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
                            @foreach($cadMats as $cadMat)
                                <tr id="materiaRow{{$cadMat->id}}">
                                    <td>{{$cadMat->id}}.</td>
                                    <td>{{$cadMat->nome}}</td>
                                    <td>
                                        <center>
                                            <button onclick="modalDados({{$cadMat->id}})" type="button" class="btn btn-primary" style="width:100px;">
                                                Ver
                                            </button>
                                        </center>
                                    </td>
                                    <td>
                                        <center>
                                            <button onclick="modalEditar({{$cadMat->id}})" type="button" class="btn btn-secondary" style="width:100px;">
                                                Editar
                                            </button>
                                        </center>
                                    </td>
                                    <td>
                                        <center>
                                            <button onclick="modalDel({{$cadMat->id}},'confirm')" type="button" class="btn btn-danger" style="width:100px;">
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
                Cadastrar Matéria
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
                    <center><p>Matéria Cadastrada com sucesso.</p></center>
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
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modalEdit" style="display: none;" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-body">
                    <form action="" method="POST" id="formAlterMat" >
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
                                @endif
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
                    Deseja realmente excluir esta matéria?
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
                    Matéria excluída com sucesso.
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
        
        function formSubmit (){
            nome = document.getElementsByClassName('formData').nome.value,
            idmaster = document.getElementsByClassName('formData').idmaster.value;        

            $.ajax({
                type: "POST",
                url: "{{ route('cadastros.materia.insert') }}",
                data: {
                    _token:'{{csrf_token()}}',
                    nome,
                    idmaster,
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

        }
        
        function resetForm(){
            $('#formCadastro').each (function(){
                this.reset();
            });
            pessoaAlter(pessoa);
        }

        function pageRefresh(){
            window.location.href = "{{route('cadastros.materia')}}";
        }

        function modalDados(id){
            $.ajax({
                url:"{{ route('cadastros.materia.dados') }}",
                type:"post",
                datatype:"json",
                data:{
                    _token:"{{csrf_token()}}",
                    id,
                },
                success:function(retorno){
                    var elementos = document.getElementsByClassName('formDataVer');
                    document.getElementsByClassName('formDataVer').nomeVer.value          = retorno[0].nome;        
                    if(retorno[0].fnomeadmaster == null){
                        document.getElementsByClassName('formDataVer').idmasterVer.innerHTML = retorno[0].nomeadmaster;         
                    }else{
                        document.getElementsByClassName('formDataVer').idmasterVer.innerHTML = retorno[0].fnomeadmaster;         
                    }
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
                    url:"{{ route('cadastros.materia.dados') }}",
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
                    url:"{{ route('materia.delete') }}",
                    success:function(retorno){
                        rowDeleted = document.getElementById('materiaRow'+id);
                        rowDeleted.style = "display:none;";
                        $('#modalDel').modal('show');
                    },
                });
            }
        }

        function modalEditF(){
            $('#formAlterMat').each (function(){
                this.reset();
            });
        }
        
        function modalEditar(id){
            modalEditF();
            $.ajax({
                url:"{{ route('cadastros.materia.dados') }}",
                type:"post",
                datatype:"json",
                data:{
                    _token:"{{csrf_token()}}",
                    id,
                },
                success:function(retorno){
                    var elementos = document.getElementsByClassName('formDataEdit');
                    elementos.idEdit.value                  = id;
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

            $.ajax({
                type:"post",
                datatype:"json",
                data:{
                    _token:"{{ csrf_token() }}",
                    id,
                    idmaster,
                    nome,
                },
                url:"{{ route('materia.update') }}",
                success:function(retorno){
                    console.log(retorno);
                    if(retorno['status'] == 'vazio'){
                        $('#ModalVazio').modal('show');
                    }else{
                        $('#ModalConfAlt').modal('show');
                        $('#modalEdit').modal('hide');
                    }
                },
                error:function(error){
                    console.log(error);
                },
            });
            
        }

    </script>
@stop