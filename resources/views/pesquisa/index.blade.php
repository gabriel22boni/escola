<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pesquisa</title>
    <link rel="stylesheet" href="/vendor/fontawesome-free/css/all.min.css">
    <link rel="stylesheet" href="/vendor/overlayScrollbars/css/OverlayScrollbars.min.css">
    <link rel="stylesheet" href="/vendor/adminlte/dist/css/adminlte.min.css">
    <link rel="stylesheet" href="/css/admin_custom.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
    <style type="text/css">
    @keyframes chartjs-render-animation{from{opacity:.99}to{opacity:1}}.chartjs-render-monitor{animation:chartjs-render-animation 1ms}.chartjs-size-monitor,.chartjs-size-monitor-expand,.chartjs-size-monitor-shrink{position:absolute;direction:ltr;left:0;top:0;right:0;bottom:0;overflow:hidden;pointer-events:none;visibility:hidden;z-index:-1}.chartjs-size-monitor-expand>div{position:absolute;width:1000000px;height:1000000px;left:0;top:0}.chartjs-size-monitor-shrink>div{position:absolute;width:200%;height:200%;left:0;top:0}</style>
</head>
<body class="layout-top-nav" style="height: auto;">
    <div class="wrapper">
        <nav class="main-header navbar navbar-expand-md navbar-light navbar-white ">
            <div class="container">
                    <a href="{{route('login')}}" class="navbar-brand">
                        <span class="brand-text font-weight-light"><strong>Minha</strong> Escola</span>
                    </a>
                    <ul class="order-1 order-md-3 navbar-nav navbar-no-expand ml-auto">
                        <li class="nav-item">
                            <a class="nav-link" data-widget="control-sidebar" data-slide="true" href="{{route('login')}}"><i class="fas fa-user-alt"></i> Login</a>
                        </li>
                    </ul>
            </div>
        </nav>
        @if( count($retorno) > 0 )
        <div lass="card">
            <div class="card-body">
                <center>
                    <h1>{{$retorno[0]->nome}}</h1>
                </center>
            </div>
        </div>
        @endif
        <div class="content-wrapper" style="min-height: 390px;">
            @if( count($retorno) > 0 )
                <div class="content">
                    <div class="container">
                        <form action="" id="formPesquisa">
                            @foreach($quests as $quest)
                                <div class="card">
                                    <div class="card-body ">
                                        <div class="row">
                                            <div class="col-12">
                                                <h class="my-2">Questão {{$quest->questnum}} 
                                                    @switch( $quest->TIPO ) 
                                                        @case('EU')
                                                        (Escolha Única):
                                                        @break
                                                        @case('ME')
                                                        (Multipla Escolha):
                                                        @break
                                                        @case('SN')
                                                        (Sim/Não):
                                                        @break
                                                        @case('ZD')
                                                        (Zero a Dez):
                                                        @break
                                                    @endswitch
                                                </h>
                                                <hr>
                                                <p style="text-indent:30px;"><font size="2">{{$quest->enunciado}}</font></p>
                                                @switch( $quest->TIPO )
                                                    @case('EU')
                                                        <div class="form-group">
                                                            @switch( $quest->qtdOps )
                                                                @case('2')
                                                                    <div class="form-check">
                                                                        <input id="customCheckbox1Quest{{ $quest->questnum }}" class="form-check-input" name="radio_opt{{ $quest->questnum }}" type="radio" value="1">
                                                                        <label class="form-check-label" for="customCheckbox1Quest{{ $quest->questnum }}">{{ $quest->op_1 }}</label>
                                                                    </div>
                                                                    <div class="form-check">
                                                                        <input id="customCheckbox2Quest{{ $quest->questnum }}" class="form-check-input" name="radio_opt{{ $quest->questnum }}" type="radio"value="2">
                                                                        <label class="form-check-label" for="customCheckbox2Quest{{ $quest->questnum }}">{{ $quest->op_2 }}</label>
                                                                    </div>
                                                                @break
                                                                @case('3')
                                                                    <div class="form-check">
                                                                        <input id="customCheckbox1Quest{{ $quest->questnum }}" class="form-check-input" name="radio_opt{{ $quest->questnum }}" type="radio" value="1">
                                                                        <label class="form-check-label" for="customCheckbox1Quest{{ $quest->questnum }}">{{ $quest->op_1 }}</label>
                                                                    </div>
                                                                    <div class="form-check">
                                                                        <input id="customCheckbox2Quest{{ $quest->questnum }}" class="form-check-input" name="radio_opt{{ $quest->questnum }}" type="radio" value="2">
                                                                        <label class="form-check-label" for="customCheckbox2Quest{{ $quest->questnum }}">{{ $quest->op_2 }}</label>
                                                                    </div>
                                                                    <div class="form-check">
                                                                        <input id="customCheckbox3Quest{{ $quest->questnum }}" class="form-check-input" name="radio_opt{{ $quest->questnum }}" type="radio" value="3">
                                                                        <label class="form-check-label" for="customCheckbox3Quest{{ $quest->questnum }}">{{ $quest->op_3 }}</label>
                                                                    </div>
                                                                @break
                                                                @case('4')
                                                                    <div class="form-check">
                                                                        <input id="customCheckbox1Quest{{ $quest->questnum }}" class="form-check-input" name="radio_opt{{ $quest->questnum }}" type="radio" value="1">
                                                                        <label class="form-check-label" for="customCheckbox1Quest{{ $quest->questnum }}">{{ $quest->op_1 }}</label>
                                                                    </div>
                                                                    <div class="form-check">
                                                                        <input id="customCheckbox2Quest{{ $quest->questnum }}" class="form-check-input" name="radio_opt{{ $quest->questnum }}" type="radio" value="2">
                                                                        <label class="form-check-label" for="customCheckbox2Quest{{ $quest->questnum }}">{{ $quest->op_2 }}</label>
                                                                    </div>
                                                                    <div class="form-check">
                                                                        <input id="customCheckbox3Quest{{ $quest->questnum }}" class="form-check-input" name="radio_opt{{ $quest->questnum }}" type="radio" value="3">
                                                                        <label class="form-check-label" for="customCheckbox3Quest{{ $quest->questnum }}">{{ $quest->op_3 }}</label>
                                                                    </div>
                                                                    <div class="form-check">
                                                                        <input id="customCheckbox4Quest{{ $quest->questnum }}" class="form-check-input" name="radio_opt{{ $quest->questnum }}" type="radio" value="4">
                                                                        <label class="form-check-label" for="customCheckbox4Quest{{ $quest->questnum }}">{{ $quest->op_4 }}</label>
                                                                    </div>
                                                                @break
                                                                @case('5')
                                                                    <div class="form-check">
                                                                        <input id="customCheckbox1Quest{{ $quest->questnum }}" class="form-check-input" name="radio_opt{{ $quest->questnum }}" type="radio" value="1">
                                                                        <label class="form-check-label" for="customCheckbox1Quest{{ $quest->questnum }}">{{ $quest->op_1 }}</label>
                                                                    </div>
                                                                    <div class="form-check">
                                                                        <input id="customCheckbox2Quest{{ $quest->questnum }}" class="form-check-input" name="radio_opt{{ $quest->questnum }}" type="radio" value="2">
                                                                        <label class="form-check-label" for="customCheckbox2Quest{{ $quest->questnum }}">{{ $quest->op_2 }}</label>
                                                                    </div>
                                                                    <div class="form-check">
                                                                        <input id="customCheckbox3Quest{{ $quest->questnum }}" class="form-check-input" name="radio_opt{{ $quest->questnum }}" type="radio" value="3">
                                                                        <label class="form-check-label" for="customCheckbox3Quest{{ $quest->questnum }}">{{ $quest->op_3 }}</label>
                                                                    </div>
                                                                    <div class="form-check">
                                                                        <input id="customCheckbox4Quest{{ $quest->questnum }}" class="form-check-input" name="radio_opt{{ $quest->questnum }}" type="radio" value="4">
                                                                        <label class="form-check-label" for="customCheckbox4Quest{{ $quest->questnum }}">{{ $quest->op_4 }}</label>
                                                                    </div>
                                                                    <div class="form-check">
                                                                        <input id="customCheckbox5Quest{{ $quest->questnum }}" class="form-check-input" name="radio_opt{{ $quest->questnum }}" type="radio" value="5">
                                                                        <label class="form-check-label" for="customCheckbox5Quest{{ $quest->questnum }}">{{ $quest->op_5 }}</label>
                                                                    </div>
                                                                @break
                                                            @endswitch
                                                        </div>
                                                    @break
                                                    @case('ME')
                                                        <div class="form-group">
                                                            @switch( $quest->qtdOps )
                                                                @case('2')
                                                                    <div class="custom-control custom-checkbox">
                                                                        <input id="customCheckbox1Quest{{ $quest->questnum }}" name="checkbox_opt{{ $quest->questnum }}" class="custom-control-input" type="checkbox" value="1">
                                                                        <label class="custom-control-label" for="customCheckbox1Quest{{ $quest->questnum }}">{{ $quest->op_1 }}</label>
                                                                    </div>
                                                                    <div class="custom-control custom-checkbox">
                                                                        <input id="customCheckbox2Quest{{ $quest->questnum }}" name="checkbox_opt{{ $quest->questnum }}" class="custom-control-input" type="checkbox" value="2">
                                                                        <label class="custom-control-label" for="customCheckbox2Quest{{ $quest->questnum }}">{{ $quest->op_2 }}</label>
                                                                    </div>
                                                                @break
                                                                @case('3')
                                                                    <div class="custom-control custom-checkbox">
                                                                        <input id="customCheckbox1Quest{{ $quest->questnum }}" name="checkbox_opt{{ $quest->questnum }}" class="custom-control-input" type="checkbox" value="1">
                                                                        <label class="custom-control-label" for="customCheckbox1Quest{{ $quest->questnum }}">{{ $quest->op_1 }}</label>
                                                                    </div>
                                                                    <div class="custom-control custom-checkbox">
                                                                        <input id="customCheckbox2Quest{{ $quest->questnum }}" name="checkbox_opt{{ $quest->questnum }}" class="custom-control-input" type="checkbox" value="2">
                                                                        <label class="custom-control-label" for="customCheckbox2Quest{{ $quest->questnum }}">{{ $quest->op_2 }}</label>
                                                                    </div>
                                                                    <div class="custom-control custom-checkbox">
                                                                        <input id="customCheckbox3Quest{{ $quest->questnum }}" name="checkbox_opt{{ $quest->questnum }}" class="custom-control-input" type="checkbox" value="3">
                                                                        <label class="custom-control-label" for="customCheckbox3Quest{{ $quest->questnum }}">{{ $quest->op_3 }}</label>
                                                                    </div>
                                                                @break
                                                                @case('4')
                                                                    <div class="custom-control custom-checkbox">
                                                                        <input id="customCheckbox1Quest{{ $quest->questnum }}" name="checkbox_opt{{ $quest->questnum }}" class="custom-control-input" type="checkbox" value="1">
                                                                        <label class="custom-control-label" for="customCheckbox1Quest{{ $quest->questnum }}">{{ $quest->op_1 }}</label>
                                                                    </div>
                                                                    <div class="custom-control custom-checkbox">
                                                                        <input id="customCheckbox2Quest{{ $quest->questnum }}" name="checkbox_opt{{ $quest->questnum }}" class="custom-control-input" type="checkbox" value="2">
                                                                        <label class="custom-control-label" for="customCheckbox2Quest{{ $quest->questnum }}">{{ $quest->op_2 }}</label>
                                                                    </div>
                                                                    <div class="custom-control custom-checkbox">
                                                                        <input id="customCheckbox3Quest{{ $quest->questnum }}" name="checkbox_opt{{ $quest->questnum }}" class="custom-control-input" type="checkbox" value="3">
                                                                        <label class="custom-control-label" for="customCheckbox3Quest{{ $quest->questnum }}">{{ $quest->op_3 }}</label>
                                                                    </div>
                                                                    <div class="custom-control custom-checkbox">
                                                                        <input id="customCheckbox4Quest{{ $quest->questnum }}" name="checkbox_opt{{ $quest->questnum }}" class="custom-control-input" type="checkbox" value="4">
                                                                        <label class="custom-control-label" for="customCheckbox4Quest{{ $quest->questnum }}">{{ $quest->op_4 }}</label>
                                                                    </div>
                                                                @break
                                                                @case('5')
                                                                    <div class="custom-control custom-checkbox">
                                                                        <input id="customCheckbox1Quest{{ $quest->questnum }}" name="checkbox_opt{{ $quest->questnum }}" class="custom-control-input" type="checkbox" value="1">
                                                                        <label class="custom-control-label" for="customCheckbox1Quest{{ $quest->questnum }}">{{ $quest->op_1 }}</label>
                                                                    </div>
                                                                    <div class="custom-control custom-checkbox">
                                                                        <input id="customCheckbox2Quest{{ $quest->questnum }}" name="checkbox_opt{{ $quest->questnum }}" class="custom-control-input" type="checkbox" value="2">
                                                                        <label class="custom-control-label" for="customCheckbox2Quest{{ $quest->questnum }}">{{ $quest->op_2 }}</label>
                                                                    </div>
                                                                    <div class="custom-control custom-checkbox">
                                                                        <input id="customCheckbox3Quest{{ $quest->questnum }}" name="checkbox_opt{{ $quest->questnum }}" class="custom-control-input" type="checkbox" value="3">
                                                                        <label class="custom-control-label" for="customCheckbox3Quest{{ $quest->questnum }}">{{ $quest->op_3 }}</label>
                                                                    </div>
                                                                    <div class="custom-control custom-checkbox">
                                                                        <input id="customCheckbox4Quest{{ $quest->questnum }}" name="checkbox_opt{{ $quest->questnum }}" class="custom-control-input" type="checkbox" value="4">
                                                                        <label class="custom-control-label" for="customCheckbox4Quest{{ $quest->questnum }}">{{ $quest->op_4 }}</label>
                                                                    </div>
                                                                    <div class="custom-control custom-checkbox">
                                                                        <input id="customCheckbox5Quest{{ $quest->questnum }}" name="checkbox_opt{{ $quest->questnum }}" class="custom-control-input" type="checkbox" value="5">
                                                                        <label class="custom-control-label" for="customCheckbox5Quest{{ $quest->questnum }}">{{ $quest->op_5 }}</label>
                                                                    </div>
                                                                @break
                                                            @endswitch
                                                        </div>
                                                    @break
                                                    @case('SN')
                                                        <div class="form-group">
                                                            <div class="form-check">
                                                                <input id="questSNum{{ $quest->questnum }}" class="form-check-input" name="radio_opt{{ $quest->questnum }}" type="radio" value="1">
                                                                <label class="form-check-label" fpr="questSNum{{ $quest->questnum }}">Sim</label>
                                                            </div>
                                                            <div class="form-check">
                                                                <input id="questnNNum{{ $quest->questnum }}" class="form-check-input" name="radio_opt{{ $quest->questnum }}" type="radio" value="2">
                                                                <label class="form-check-label" fpr="questnNNum{{ $quest->questnum }}">Não</label>
                                                            </div>
                                                        </div>
                                                    @break
                                                    @case('ZD')
                                                        <div class="form-group">
                                                            <div class="form-check">
                                                                <input id="quest0ZDop{{ $quest->questnum }}" class="form-check-input" name="radio_opt{{ $quest->questnum }}" type="radio" value="0">
                                                                <label class="form-check-label" for="quest0ZDop{{ $quest->questnum }}">0</label>
                                                            </div>
                                                            <div class="form-check">
                                                                <input id="quest1ZDop{{ $quest->questnum }}" class="form-check-input" name="radio_opt{{ $quest->questnum }}" type="radio" value="1">
                                                                <label class="form-check-label" for="quest1ZDop{{ $quest->questnum }}">1</label>
                                                            </div>
                                                            <div class="form-check">
                                                                <input id="quest2ZDop{{ $quest->questnum }}" class="form-check-input" name="radio_opt{{ $quest->questnum }}" type="radio" value="2">
                                                                <label class="form-check-label" for="quest2ZDop{{ $quest->questnum }}">2</label>
                                                            </div>
                                                            <div class="form-check">
                                                                <input id="quest3ZDop{{ $quest->questnum }}" class="form-check-input" name="radio_opt{{ $quest->questnum }}" type="radio" value="3">
                                                                <label class="form-check-label" for="quest3ZDop{{ $quest->questnum }}">3</label>
                                                            </div>
                                                            <div class="form-check">
                                                                <input id="quest4ZDop{{ $quest->questnum }}" class="form-check-input" name="radio_opt{{ $quest->questnum }}" type="radio" value="4">
                                                                <label class="form-check-label" for="quest4ZDop{{ $quest->questnum }}">4</label>
                                                            </div>
                                                            <div class="form-check">
                                                                <input id="quest5ZDop{{ $quest->questnum }}" class="form-check-input" name="radio_opt{{ $quest->questnum }}" type="radio" value="5">
                                                                <label class="form-check-label" for="quest5ZDop{{ $quest->questnum }}">5</label>
                                                            </div>
                                                            <div class="form-check">
                                                                <input id="quest6ZDop{{ $quest->questnum }}" class="form-check-input" name="radio_opt{{ $quest->questnum }}" type="radio" value="6">
                                                                <label class="form-check-label" for="quest6ZDop{{ $quest->questnum }}">6</label>
                                                            </div>
                                                            <div class="form-check">
                                                                <input id="quest7ZDop{{ $quest->questnum }}" class="form-check-input" name="radio_opt{{ $quest->questnum }}" type="radio" value="7">
                                                                <label class="form-check-label" for="quest7ZDop{{ $quest->questnum }}">7</label>
                                                            </div>
                                                            <div class="form-check">
                                                                <input id="quest8ZDop{{ $quest->questnum }}" class="form-check-input" name="radio_opt{{ $quest->questnum }}" type="radio" value="8">
                                                                <label class="form-check-label" for="quest8ZDop{{ $quest->questnum }}">8</label>
                                                            </div>
                                                            <div class="form-check">
                                                                <input id="quest1ZDop{{ $quest->questnum }}" class="form-check-input" name="radio_opt{{ $quest->questnum }}" type="radio" value="9">
                                                                <label class="form-check-label" for="quest1ZDop{{ $quest->questnum }}">9</label>
                                                            </div>
                                                            <div class="form-check">
                                                                <input id="quest1ZDop{{ $quest->questnum }}" class="form-check-input" name="radio_opt{{ $quest->questnum }}" type="radio" value="10">
                                                                <label class="form-check-label" for="quest1ZDop{{ $quest->questnum }}">10</label>
                                                            </div>
                                                        </div>
                                                    @break
                                                @endswitch
                                                <hr>
                                                <div id="error{{$quest->questnum}}" class="alert alert-danger" style="display:none" role="alert">
                                                    Favor Selecionar uma resposta!
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </form>
                        <div class="card">
                            <div class="card-footer">
                                <button class="btn btn-secondary">Limpar</button>
                                <button id="btnEnviarResp" class="btn btn-info float-right">Enviar Resposta</button>
                            </div>
                        </div>
                    </div>
                </div>
            @else
                <div class="card">
                    <div class="card-body">
                        <center>
                            <h1>Oops!</h1>
                            <p>Pesquisa não encontrada</p>
                            <p>Verifique se o endereço da pesquisa está correto:</p>
                            <strong><h1>minhaescola.izebanc.com.br/pesquisa/{{ $nomePesq }}</h1></strong>
                        </center>
                    </div>
                </div>
            @endif
        </div>
        <footer class="main-footer">
            <center>
                <font size="2">
                    Desenvolvadmino por- 
                    <strong>Minha Escola</strong>
                </font>
            </center>
        </footer>
    </div>

    <div class="modal fade" id="modalSucesso" style="display: none;" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Resposta Enviada!</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>Os dados de resposta da sua pesquisa foram salvos com sucesso, obrigado por participar!</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary float-right" data-dismiss="modal">Ok</button>
                </div>
            </div>
        </div>
    </div>

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


    <script src="/vendor/jquery/jquery.min.js"></script>
    <script src="/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="/vendor/adminlte/dist/js/adminlte.min.js"></script>
    <script type="text/javascript">
        var retorno = @json($retorno);
        if(retorno.length > 0){
            var quests = @json($quests ?? '');
            console.log(quests);
            console.log(retorno[0].qtdeQuest);
            function enviarResp(){
                
                var valida = true;
                var respostas = []; 
                for(i=0; i < retorno[0].qtdeQuest; i++){
                    respostas[i] = new Object();
                    switch(quests[i].TIPO){
                        case 'EU':
                            respostas[i].TIPO = 'EU';
                            respostas[i].questnum = i+1;
                            respostas[i].idpesq = retorno[0].id;
                            respostas[i].RespEU = $("input[name='radio_opt"+(i+1)+"']:checked").val();
                            if( respostas[i].RespEU == null ){
                                divError = document.getElementById('error'+(i+1));
                                divError.style = 'display:block;';
                                valida = false;
                            }else{
                                divError = document.getElementById('error'+(i+1));
                                divError.style = 'display:none;';
                            }
                            break;
                        case 'ME':
                            respostas[i].TIPO = 'ME';
                            respostas[i].questnum = i+1;
                            respostas[i].idpesq = retorno[0].id;
                            var checked =  new Array();
                            $("input[name='checkbox_opt"+(i+1)+"']:checked").each(function(){
                                checked.push($(this).val());
                            });
                            respostas[i].RespME = checked;
                            if( respostas[i].RespME.length == 0 ){
                                divError = document.getElementById('error'+(i+1));
                                divError.style = 'display:block;';
                                valida = false;
                            }else{
                                divError = document.getElementById('error'+(i+1));
                                divError.style = 'display:none;';
                            }
                            break;
                        case 'SN':
                            respostas[i].TIPO = 'SN';
                            respostas[i].questnum = i+1;
                            respostas[i].idpesq = retorno[0].id;
                            respostas[i].RespSN = $("input[name='radio_opt"+(i+1)+"']:checked").val();
                            if( respostas[i].RespSN == null ){
                                divError = document.getElementById('error'+(i+1));
                                divError.style = 'display:block;';
                                valida = false;
                            }else{
                                divError = document.getElementById('error'+(i+1));
                                divError.style = 'display:none;';
                            }
                            break;
                        case 'ZD':
                            respostas[i].TIPO = 'ZD';
                            respostas[i].questnum = i+1;
                            respostas[i].idpesq = retorno[0].id;
                            respostas[i].RespZD = $("input[name='radio_opt"+(i+1)+"']:checked").val();
                            if( respostas[i].RespZD == null ){
                                divError = document.getElementById('error'+(i+1));
                                divError.style = 'display:block;';
                                valida = false;
                            }else{
                                divError = document.getElementById('error'+(i+1));
                                divError.style = 'display:none;';
                            }
                            break;
                    }
                }
                if(valida == true){
                    $.ajax({
                        url:'{{ route("pesquisa.qtd") }}',
                        type:'post',
                        datatype:'json',
                        data:{
                            _token:'{{ csrf_token() }}',
                            retorno,
                        },
                        success:function(retorno){
                            console.log(retorno);
                        },
                        error:function(error){
                            console.log(error);
                        },
                    });
                    $.ajax({
                        url:'{{ route("pesquisa.dados") }}',
                        type:'post',
                        data:{
                            _token:'{{ csrf_token() }}',
                            respostas,
                        },
                    });
                    $('#modalSucesso').modal('show');
                    $('#formPesquisa').each(function(){
                        this.reset();
                    });
                }
            }
            
            btnEnviarResp = document.getElementById('btnEnviarResp');
            btnEnviarResp.onclick = function (){
                enviarResp();
            }
        }
    </script>
</body>
</html>