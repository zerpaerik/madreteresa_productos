<style>
	.row{
		width: 1024px;
		margin: 0 auto;
	}

	.col-12{
		width: 100%;
	}
	
	.col-6{
		width: 49%;
		float: left;
		padding: 8px 5px;
		font-size: 18px;
	}

	.text-center{
		text-align: center;
	}
	
	.text-right{
		text-align: right;
	}

	.title-header{
		font-size: 22px; 
		text-transform: uppercase; 
		padding: 12px 0;
	}
	table{
		width: 100%;
		text-align: center;
		margin: 10px 0;
	}
	
	tr th{
		font-size: 14px;
		text-transform: uppercase;
		padding: 8px 5px;
	}

	tr td{
		font-size: 14px;
		padding: 8px 5px;
	}
</style>
<head>
	<title>Requerimiento Procesado</title>
</head>

<div>
	<div class="text-center title-header col-12">
		<center><strong>REQUERIMIENTO PROCESADO</strong> </center>
	</div>
</div>
<div>
	<div class="col-6">
		Fecha de Impresión: {{ Carbon\Carbon::now()->format('d/m/Y') }}
	</div>
	<div class="col-6 text-right">
		Hora de Impresión: {{ Carbon\Carbon::now('America/Lima')->format('h:i a') }}
	</div> 
</div>



<div style="background: #eaeaea;">
	<table>
    <thead>
		<tr>
        <th style="padding: 0;width: 5%;text-overflow: ellipsis;">FECHA</th>
			<th style="padding: 0;width: 5%;text-overflow: ellipsis;">ALMAC.</th>
			<th style="padding: 0;width: 15%;text-overflow: ellipsis;">PRODUCTO</th>
            <th style="padding: 0;width: 5%;text-overflow: ellipsis;">MEDIDA</th>
			<th style="padding: 0;width: 5%;text-overflow: ellipsis;">PEDI</th>
            <th style="padding: 0;width: 5%;text-overflow: ellipsis;">ENTRE</th>
		</tr>
    </thead>
    <tbody>
    @foreach($requerimientos as $req)
    <tr>
                   <td style="padding: 0;width: 5%;text-overflow: ellipsis;">{{ Carbon\Carbon::createFromDate($req->updated_at)->format('d-m-Y')  }}</td>
            @if($req->almacen_solicita == 2)
                    <td style="padding: 0;width: 5%;text-overflow: ellipsis;">Recepción</th>
                    @elseif($req->almacen_solicita == 11)
                    <td style="padding: 0;width: 5%;text-overflow: ellipsis;">Laboratorio</th>
                    @elseif($req->almacen_solicita == 3)
                    <td style="padding: 0;width: 5%;text-overflow: ellipsis;">Obstetra</th>
                    @elseif($req->almacen_solicita == 4)
                    <td style="padding: 0;width: 5%;text-overflow: ellipsis;">Rayos X</th>
                    @elseif($req->almacen_solicita == 5)
                    <td style="padding: 0;width: 5%;text-overflow: ellipsis;">Independencia</th>
                    @elseif($req->almacen_solicita == 6)
                    <td style="padding: 0;width: 5%;text-overflow: ellipsis;">Olivos</th>
                    @elseif($req->almacen_solicita == 7)
                    <td style="padding: 0;width: 5%;text-overflow: ellipsis;">Canto Rey</th>
                    @elseif($req->almacen_solicita == 8)
                    <td style="padding: 0;width: 5%;text-overflow: ellipsis;">Vida Feliz</th>
                    @else
                    <td style="padding: 0;width: 5%;text-overflow: ellipsis;">Zarate</th>
                    @endif
			<td style="padding: 0;width: 15%;text-overflow: ellipsis;">{{$req->nompro}}</td>
            <td style="padding: 0;width: 5%;text-overflow: ellipsis;">{{$req->medida}}</td>
			<td style="padding: 0;width: 5%;text-overflow: ellipsis;">{{$req->cantidad_solicita}}</td>
            <td style="padding: 0;width: 5%;text-overflow: ellipsis;">{{$req->cantidad_despachada}}</td>
		</tr>
        @endforeach
    </tbody>


	</table>
</div>
<br><br><br>

<strong>ENTREGADO POR:</strong>________________________________________<br><br>
	<strong>RECIBIDO POR:</strong>________________________________________<br><br>
	<strong>FECHA:</strong>________________________________________





