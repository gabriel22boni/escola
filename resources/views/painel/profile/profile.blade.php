@extends('adminlte::page')

@section('title', 'Meu Perfil')

@section('content_header')
    <h1>Meu Perfil</h1>

    <ol class="breadcrumb">
        <li class="breadcrumb-item">Home</li>
        <li class="breadcrumb-item">Perfil</li>
        <li class="breadcrumb-item active" aria-current="page">Editar Perfil</li>
    </ol>
@stop

@section('content')
    <div class="card">
        <div class="card-header">
            <h4>Editar Perfil</h4>
        </div>
        <div class="card-body">
            @include('painel.includes.alerts')

            <form action="{{ route('perfil.update') }}" method="POST" enctype="multipart/form-data">
                {!! csrf_field() !!}
                {{--
                <div class="form-group">
                    <label for="image">Foto do Perfil</label>
                    <input type="file" name="image" class="form-control">
                </div>
                --}}
                <div class="form-group" style="display:none;">
                    <label for="name">Nome</label>
                    <input type="text" value="{{ auth()->user()->name }}" name="name" placeholder="Nome" class="form-control">
                </div>
                <div class="form-group" style="display:none;">
                    <label for="email">E-mail</label>
                    <input type="email" value="{{ auth()->user()->email }}" name="email" placeholder="E-mail" class="form-control">
                </div>
                <div class="form-group">
                    <label for="password">Senha</label>
                    <input type="password" name="password" placeholder="Senha" class="form-control">
                </div>
                <div class="form-group">
                    <button type="submit" class="btn btn-info">Atualizar Perfil</button>
                </div>
            </form>
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


    <script> console.log('Hi!'); </script>
@stop