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
	   <center><strong>HOTEL MadreTeresa</strong> </center>
		<center><strong>REPORTE DE CIERRE DE CAJA</strong> </center>
		<center><strong>INICIO: {{ $caja->fecha_init }}</strong>- <strong>FIN: {{ $caja->fecha_fin }}</strong></center>


	</div>
</div>
<div>
	<div class="col-6" >
		Fecha de Impresión: {{ Carbon\Carbon::now()->format('d/m/Y') }}
	</div>
	<div class="col-6 text-right">
		Hora de Impresión: {{ Carbon\Carbon::now('America/Lima')->format('h:i a') }}
	</div> 
</div>

<div style="background: #eaeaea;">
	<table>
		<tr>
			<th style="padding: 0;width: 5%;text-overflow: ellipsis;">INGRESOS</th>
			<th style="padding: 0;width: 5%;text-overflow: ellipsis;">CANTIDAD</th>
			<th style="padding: 0;width: 5%;text-overflow: ellipsis;">MONTO</th>
		</tr>
		<tr>
			<td style="padding: 0;width: 5%;text-overflow: ellipsis;">Ingresos a Habitación</td>
			<td style="padding: 0;width: 5%;text-overflow: ellipsis;">{{ $ingresos->cantidad }}</td>
			<td style="padding: 0;width: 5%;text-overflow: ellipsis;">{{ $ingresos->monto }}</td>
		</tr>
	
		<tr>
			<td style="padding: 0;width: 5%;text-overflow: ellipsis;">Otros Ingresos</td>
			<td style="padding: 0;width: 5%;text-overflow: ellipsis;">{{ $otros->cantidad }}</td>
			<td style="padding: 0;width: 5%;text-overflow: ellipsis;">{{ $otros->monto }}</td>
		</tr>

		<tr>
			<td style="padding: 0;width: 5%;text-overflow: ellipsis;">Pedidos de Habitación</td>
			<td style="padding: 0;width: 5%;text-overflow: ellipsis;">{{ $pedido->cantidad }}</td>
			<td style="padding: 0;width: 5%;text-overflow: ellipsis;">{{ $pedido->monto }}</td>
		</tr>
		
		<tr>
			<td>TOTAL</td>
			<td></td>
			<td></td>
			<td width="80">{{$totalIngresos}}</td>
		</tr>
	</table>
</div>
<div style="font-weight: bold; font-size: 14px">
		EGRESOS
</div>
<div style="margin-top:10px; background: #eaeaea;">
	<table style="">
		<tr>
			<th style="padding: 0;width: 5%;text-overflow: ellipsis;">Descripción</th>
		    <th style="padding: 0;width: 5%;text-overflow: ellipsis;">Reistrado Por:</th>
			<th style="padding: 0;width: 5%;text-overflow: ellipsis;">Origen</th>
			<th style="padding: 0;width: 5%;text-overflow: ellipsis;">Monto</th>
		</tr>
		@foreach ($egresos as $egreso)
			<tr>
				<td style="padding: 0;width: 5%;text-overflow: ellipsis;">{{ $egreso->descripcion }}</td>
				<td style="padding: 0;width: 5%;text-overflow: ellipsis;">{{ $egreso->nombre }}</td>
				<td style="padding: 0;width: 5%;text-overflow: ellipsis;">{{ $egreso->origen }}</td>
				<td style="padding: 0;width: 5%;text-overflow: ellipsis;">{{ $egreso->monto }}</td>
			</tr>
		@endforeach
		<tr>
			<td>Total</td>
			<td></td>
			<td></td>
			<td width="80">{{$totalEgresos}}</td>
		</tr>
	</table>
</div>
<div style="font-weight: bold; font-size: 14px">
		SALDO TOTAL
</div>
<div style="margin-top:10px; background: #eaeaea;">
	<table>
		<tr>
			<th style="padding: 0;width: 5%;text-overflow: ellipsis;">Total efectivo</th>
			<th style="padding: 0;width: 5%;text-overflow: ellipsis;">Total tarjeta</th>
		</tr>
		<tr>
			<td style="padding: 0;width: 5%;text-overflow: ellipsis;">{{ $efectivo->monto }}</td>
			<td style="padding: 0;width: 5%;text-overflow: ellipsis;">{{ $tarjeta->monto }}</td>
		</tr>
		<tr>
			<td style="padding: 0;width: 5%;text-overflow: ellipsis;">Total</td>
			<td></td>
			<td width="80" style="padding: 0;width: 5%;text-overflow: ellipsis;">
			{{ $efectivo->monto + $tarjeta->monto }}

			</td>
		</tr>
	</table>
</div>
<div style="font-weight: bold; font-size: 14px">
		SALDO DEL DÍA
</div>
<div style="margin-top:10px; background: #eaeaea;">
<table>
		<tr>
			<th style="padding: 0;width: 5%;text-overflow: ellipsis;">Ingresos</th>
			<th style="padding: 0;width: 5%;text-overflow: ellipsis;">Egresos</th>
		</tr>
		<tr>
			<td style="padding: 0;width: 5%;text-overflow: ellipsis;">{{ $efectivo->monto }}</td>
			<td style="padding: 0;width: 5%;text-overflow: ellipsis;">{{ $totalEgresos }}</td>
		</tr>
		<tr>
			<td style="padding: 0;width: 5%;text-overflow: ellipsis;">Total</td>
			<td></td>
			<td width="80" style="padding: 0;width: 5%;text-overflow: ellipsis;">
				{{ $efectivo->monto - $totalEgresos }}
			</td>
		</tr>
	</table>
</div>