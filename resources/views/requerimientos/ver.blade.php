<div class="row">
	<div class="col-xs-12">
		<div class="box">
			<div class="box-header">
				<div class="box-name">					
					<span>
                        <strong>Datos de Ticket -#{{$req->id}}:</strong><br>
                        <strong>Estado de Ticket <span class="badge bg-success">{{$req->estado}}</span></strong>

					</span>
				</div>
			</div>
				<div class="row">
					<div class="col-md-4">
						<strong>Asunto:</strong> {{$req->asunto}}
					</div>
					<div class="col-md-4">
						<strong>Categoria:</strong> {{$req->categoria}}
					</div>
					<div class="col-md-4">
						<strong>Prioridad:</strong> {{$req->prioridad}}
                    </div>
                    <div class="col-md-4">
						<strong>Prioridad:</strong> {{$req->prioridad}}
                    </div>
                    <div class="col-md-4">
						<strong>Descripción:</strong> {{$req->descripcion}}
					</div>
                </div>

                @if($equipos)
                
                <div class="card-body">
                <table id="example1" class="table table-bordered table-striped">
                  <thead>
                  <tr>
                    <th>Nombre</th>
                    <th>Modelo</th>
                    <th>Serial</th>
                  </tr>
                  </thead>
                  <tbody>

                  @foreach($equipos as $e)
                  <tr>
                    <td>{{$e->nombre}}</td>
                    <td>{{$e->modelo}}</td>
                    <td>{{$e->serial}}</td>

                  </tr>
                  @endforeach
                  </tbody>
                  <tfoot>
                  <tr>
                  <th>Nombre</th>
                    <th>Modelo</th>
                    <th>Serial</th>
                  </tr>
                  </tfoot>
                </table>
              </div>
              @endif
               				
		</div>
	</div>
</div>