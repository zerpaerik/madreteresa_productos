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
		<center><strong>REPORTE DETALLADO DE PRODUCTOS USADOS</strong> </center>
		@if($productosi->almacen == 7)
		<center><strong>CANTO REY</strong> </center>
		@elseif($productosi->almacen == 8)
		<center><strong>VIDA FELIZ</strong> </center>
		@elseif($productosi->almacen == 2)
		<center><strong>RECEPCIÒN</strong> </center>
		@elseif($productosi->almacen == 3)
		<center><strong>OBSTETRA</strong> </center>
		@elseif($productosi->almacen == 4)
		<center><strong>RAYOS X</strong> </center>
		@elseif($productosi->almacen == 9)
		<center><strong>ZARATE</strong> </center>
		@elseif($productosi->almacen == 11)
		<center><strong>LABORATORIO</strong> </center>
		@else
		@endif

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

<div style="font-weight: bold; font-size: 14px">
		MOVIMIENTOS
</div>

<div style="background: #eaeaea;">
	<table>
		<tr>
		    <th style="padding: 0;width: 5%;text-overflow: ellipsis;">FECHA</th>
			<th style="padding: 0;width: 15%;text-overflow: ellipsis;">PRODUCTO</th>
            <th style="padding: 0;width: 5%;text-overflow: ellipsis;">MEDIDA</th>
			<th style="padding: 0;width: 5%;text-overflow: ellipsis;">CANT</th>
			<th style="padding: 0;width: 5%;text-overflow: ellipsis;">PRECIO</th>
			<th style="padding: 0;width: 10%;text-overflow: ellipsis;">USUARIO</th>

		

		</tr>
		@foreach($productos as $ingreso)
		<tr>
		    <td style="padding: 0;width: 5%;text-overflow: ellipsis;"> {{ $ingreso->created_at }}</td>
			<td style="padding: 0;width: 15%;text-overflow: ellipsis;">{{ $ingreso->nompro }}</td>
            <td style="padding: 0;width: 5%;text-overflow: ellipsis;">{{ $ingreso->medida }}</td>
			<td style="padding: 0;width: 5%;text-overflow: ellipsis;">{{ $ingreso->cantidad }}</td>
			<td style="padding: 0;width: 5%;text-overflow: ellipsis;">{{ $ingreso->precio }}</td>
			<td style="padding: 0;width: 10%;text-overflow: ellipsis;">{{ $ingreso->user }}</td>

		
			
		</tr>
		@endforeach
	</table>

    <strong>CANTIDAD TOTAL:</strong>{{ $productosi->cant }}<br>
    <strong>TOTAL SOLES:</strong> {{number_format((float)$productosi->preciototal, 2, '.', '')}}<br>

</div>
<br>






