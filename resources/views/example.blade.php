@extends('adminlte::page')

@section('title', 'Aba Nome')

@section('content_header')
    <h1>Título da Página</h1>

    <ol class="breadcrumb">
        <li class="breadcrumb-item"> breadcrumb1</li>
        <li class="breadcrumb-item"> breadcrumb2</li>
        <li class="breadcrumb-item active" aria-current="page"> breadcrumb Current Page</li>
    </ol>
@stop

@section('content')
    <div class="box">
        <div class="box-header">
            <h3>Exemplo Box Header</h3>
        </div>
        <div class="box-body">
            Exemplo Box Body
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
@stop