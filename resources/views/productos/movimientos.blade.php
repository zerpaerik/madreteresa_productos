<div class="row">
	<div class="col-xs-12">
		<div class="box">
			<div class="box-header">
				<div class="box-name">					
					<span>
                    <center> <strong>HISTORIAL DE PRODUCTO</strong></center><br>
                    <center>PRODUCTO: {{$productos->nompro}}</center>
					</span>
				</div>
			</div>

              {{ csrf_field() }}                
                    <div class="card-body">
                    <div class="row">

                    <table class="table">
                  <thead>
                    <tr>
                      <th>Fecha</th>
                      <th>Acción</th>
                      <th>Cantidad</th>
                      <th>Usuario</th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach($historial as $hist)
                    <tr>
                      <td>{{$hist->created_at}}</td>
                      <td>{{$hist->accion}}</td>
                      <td>{{$hist->cantidad}}</td>
                      <td>{{$hist->name}}</td>

                    </tr>
                  @endforeach
                   
                  </tbody>
                </table>
                   
                 
                  
                  </div>
                  <br>
                </div>

       



                <!-- /.card-body -->

				

               
               				
		</div>
	</div>
</div>