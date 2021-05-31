<div class="row">
	<div class="col-xs-12">
		<div class="box">
			<div class="box-header">
				<div class="box-name">					
					<span>
                        <strong>ID de Ingreso -#{{$solicitudes->id}}:</strong><br>
                        @if($solicitudes->estado == 1)
                        <strong>Estado de Ingreso <span class="badge bg-primary">Activo</span></strong>
                        @else
                        <strong>Estado de Ingreso <span class="badge bg-success">Finalizado</span></strong>
                        @endif

					</span>
				</div>
			</div>
				<div class="row">
					<div class="col-md-4">
						<strong>Huesped:</strong> {{$solicitudes->apepac}} {{$solicitudes->nompac}}
					</div>
					<div class="col-md-4">
						<strong>Habitación:</strong> {{$solicitudes->laboratorio}}
					</div>
					<div class="col-md-4">
						<strong>Precio:</strong> {{$solicitudes->precio}}
                    </div>
                    <div class="col-md-4">
						<strong>Fecha:</strong> {{$solicitudes->created_at}}
                    </div>

                    
                </div>
                <div class="row">
					
                    <div class="col-md-12">
						<strong>Observación:</strong> {{json_encode($solicitudes->observacion)}}
					</div>
                </div>

               
               				
		</div>
	</div>
</div>