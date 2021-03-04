@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h1>Página Inicial</h1>

    <ol class="breadcrumb">
        <li class="breadcrumb-item"> Home</li>
    </ol>
@stop

@section('content')
<div class="card">
    <div class="card-body">
        <h1>Bem Vindo, {{auth()->user()->name}}!</h1>
    </div>
    <div class="card-footer">
    </div>
</div>
@stop

@section('footer')
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

    <!-- ChartJS -->
    <script src="/vendor/chart.js/Chart.min.js"></script>
    <!-- (Canvas Data) -->
    <script src="/vendor/js/dashboard.js"></script>
    <script>
        $(document).ready(function(){
            (function consolee(){
                $.ajax({
                    type:"post",
                    datatype:"json",
                    data:{
                        _token:"{{csrf_token()}}",
                    },
                    url:"{{ route('painel.authenticateUsr') }}",
                    success:function(retorno){
                        if(retorno == "MAS"){
                        };
                        if(retorno == "ADM"){
                        };
                        if(retorno == "COB"){
                        };
                        if(retorno == "CLI"){
                        };
                        
                    },
                    error:function(error){
                        console.log(error);
                    },
                });
            })();
        });
    </script>
@stop