<!DOCTYPE html>
<html lang="pt">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Relatório de Alugueis</title>
    <link rel="stylesheet" type="text/css" href="{{ asset('css/paper.css') }}">
    <style>
        @page {
            size: A4 landscape
        }

        table{
            width: 100%;
            margin-bottom: 1rem;
            border-collapse: collapse;
        }

        table th, table td {
        padding: 0.30rem;
        vertical-align: top;
        border-top: 1px solid #dee2e6;
        text-align:left;
        }

        table thead.dotted{
            border-top: 2px dashed #999;
            border-bottom: 2px dashed #999;
        }

        .nrpagina{
            text-align:right;
            margin-bottom: 10px;
        }

        .cabecalho{
            text-align: center;
            margin-bottom: 10px;
        }

        .totalGeral{
            text-align: right;
            border-top: 2px dotted #999;
            border-bottom: 2px dotted #999;
           
            padding: 5px 20px;
            
        }

    </style>

</head>

<body class="A4 landscape">
    <?php
        use App\Helpers\UtilHelper;
        $paginas=$relatorio->getItemsPaginados();
        $totalPaginas=$paginas->count();
    ?>


    @foreach($paginas as $key=>$lista)
    <section class="sheet padding-10mm">
        <div class="nrpagina">
           {{date('d/m/Y')}} - Página {{$key+1}}/{{$totalPaginas}}
        </div>        
       
        @if($key==0)
            <div class="cabecalho">
                <b>Relatório de Alugueis </b>
                @if(request('data_saida1') ||request('data_saida2') )
                  - Data de Saída
                @endif
                @if(request('data_saida1'))
                 a partir de {{UtilHelper::dateBr(request('data_saida1'))}}
                @endif
                @if(request('data_saida2'))
                 até {{UtilHelper::dateBr(request('data_saida2'))}}
                @endif


              @if(request('data_retorno1') ||request('data_retorno2') )
                - Data Retorno
                @endif
                @if(request('data_retorno1'))
                a partir de {{UtilHelper::dateBr(request('data_retorno1'))}}
                @endif
                @if(request('data_retorno2'))
                até {{UtilHelper::dateBr(request('data_retorno2'))}}
                @endif



                @if(is_numeric(request('status')))
                  -  Status {{request('status')?"Devolvido":"Aberto"}}
                @endif
            </div>
        @endif
        <table cellspacing="0" cellpadding=0 > 
            <thead class="dotted">
                <th>Cód Aluguel</th>
                <th>Status</th>
                <th>Cliente</th>
                <th>Data Saída</th>
                <th>Data Retorno</th>
                <th>Total</th>

            </thead>
            <tbody>
                @foreach($lista as $item)
                <tr>
                    <td>{{$item->id}}</td>
                    <td>{{$item->getNomeStatus(false)}}</td>
                    <td>{{$item->nome}}</td>
                    <td>{{$item->data_saida}}</td>
                    <td>{{$item->data_retorno}}</td>
                    <td>{{UtilHelper::moneyToBr($item->total)}}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
        @if($key==$paginas->keys()->last())
        <div class="totalGeral">
            Total Geral : <b>{{UtilHelper::moneyToBr($relatorio->total_rent)}}</b>
        </div>
        @endif

    </section>
    @endforeach

    {{-- <script>
        window.onload=function(){
            window.print();
        }
    </script> --}}


</body>

</html>