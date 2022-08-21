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

<div>
	<div class="text-center title-header col-12">
		<center><strong>DETALLE DE REPORTE INDIVIDUAL</strong> </center>
		<center><strong>DESDE: </strong>{{ $f1 }} <strong>HASTA: </strong>{{ $f2 }}</center>

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



<br>



<div style="background: #eaeaea;">
	<table>
		<tr>
		    <th style="padding: 0;width: 80%;text-overflow: ellipsis;">PRODUCTO</th>
			<th style="padding: 0;width: 20%;text-overflow: ellipsis;">CANTIDAD</th>


		</tr>
		@foreach($requerimientos as $ingreso)
		<tr>
		    <td style="padding: 0;width: 80%;text-overflow: ellipsis;">{{$ingreso->nompro }}</td>
			<td style="padding: 0;width: 20%;text-overflow: ellipsis;">{{ $ingreso->cantidad_despachada }}</td>
		
		</tr>
		@endforeach
	</table>

	


</div>
<br>