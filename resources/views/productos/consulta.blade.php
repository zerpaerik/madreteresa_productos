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
    <center><img src="hotel.jpeg" class="img-circle elevation-2" alt="User Image" width="150"></center>
	<center><strong>HOTEL MadreTeresa</strong> </center>
		<center><strong>LISTADO DE PRODUCTOS</strong> </center>

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

<br><br>
<br>




<div style="background: #eaeaea;">
	<table>
		<tr>
			<th style="padding: 0;width: 5%;text-overflow: ellipsis;">NOMBRE</th>
			<th style="padding: 0;width: 10%;text-overflow: ellipsis;">DESCRIPCIÓN</th>
			<th style="padding: 0;width: 5%;text-overflow: ellipsis;">PRECIO</th>
			<th style="padding: 0;width: 5%;text-overflow: ellipsis;">FOTO</th>




		</tr>
		@foreach($productos as $p)
		<tr>
			<td style="padding: 0;width: 5%;text-overflow: ellipsis;">{{ $p->nombre }}</td>
			<td style="padding: 0;width: 5%;text-overflow: ellipsis;">{{ $p->descripcion }}</td>
			<td style="padding: 0;width: 5%;text-overflow: ellipsis;">{{ $p->precio }}</td>
			@if($p->foto != null)
			<td style="padding: 0;width: 5%;text-overflow: ellipsis;"><img src="fotos/{{$p->foto}}" alt="User Image" width="100"></td>
			@else
			<td style="padding: 0;width: 5%;text-overflow: ellipsis;">SIN FOTO</td>
			@endif
			
		</tr>
		@endforeach
	</table>


</div>
<br>



