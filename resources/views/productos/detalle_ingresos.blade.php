<div class="row">
	
					<div class="col-md-6">
						<strong>N° Factura:</strong> {{$ingreso->factura}}
					</div>
					<div class="col-md-6">
						<strong>Fecha de Factura:</strong> {{$ingreso->fecha}}
					</div>
		
</div>

<div class="row">
	
					<div class="col-md-12">
						<strong>Observación:</strong> {{$ingreso->observacion}}
					</div>
					
		
</div>

<br>

<div class="row">
<div class="col-md-12">
<strong>Productos en el Ingreso:</strong> 
</div>					
</div>

<br>


<div class="row">
<div class="col-md-12">

<table class="table table-sm">
                  <thead>
                    <tr>
                      <th>Producto</th>
                      <th>Cantidad</th>
                      <th>Vence</th>
                      <th style="width: 40px">Precio</th>
                    </tr>
                  </thead>
                  <tbody>
                  @foreach($detalle as $d)

                    <tr>
                      <td>{{$d->nompro}}</td>
                      <td>{{$d->cantidad}}</td>
                      <td>{{$d->vence}}</td>
                      <td>{{$d->precio}}</td>
                    </tr>

                    @endforeach
                    
                  </tbody>
                </table>
                </div>					
</div>
