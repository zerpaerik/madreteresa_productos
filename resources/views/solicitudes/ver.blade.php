<div class="row">
	<div class="col-xs-12">
		<div class="box">
			<div class="box-header">
				<div class="box-name">					
					<span>
                        <strong>ID de Solicitud -#{{$solicitudes->id}}:</strong><br>
                        @if($solicitudes->estado == 1)
                        <strong>Estado de Solicitud <span class="badge bg-primary">Enviado</span></strong>
                        @else
                        <strong>Estado de Solicitud <span class="badge bg-success">Finalizado</span></strong>
                        @endif

					</span>
				</div>
			</div>
				<div class="row">
					<div class="col-md-4">
						<strong>Paciente:</strong> {{$solicitudes->apepac}} {{$solicitudes->nompac}}
					</div>
					<div class="col-md-4">
						<strong>Analisis:</strong> {{$solicitudes->laboratorio}}
					</div>
					<div class="col-md-4">
						<strong>Precio:</strong> {{$solicitudes->precio}}
                    </div>
                    <div class="col-md-4">
						<strong>Envio:</strong> {{$solicitudes->created_at}}
                    </div>

					<div class="col-md-6">
						<strong>Hora de toma:</strong> {{$solicitudes->hora}}
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