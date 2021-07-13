<div class="row">
	<div class="col-xs-12">
		<div class="box">
			<div class="box-header">
				<div class="box-name">					
					<span>
                    <center> <strong>AGREGAR REQUERIMIENTO</strong></center><br>
                    <center>PRODUCTO: {{$productos->nompro}}</center>
					</span>
				</div>
			</div>

            <form method="post" action="productos/reqPost">					
              {{ csrf_field() }}                
                    <div class="card-body">
                    <div class="row">
                   
                  <div class="col-md-6">
                    <label for="exampleInputEmail1">C.Actual</label>
                    <input type="text" disabled class="form-control"  value="{{$productos->cantidad}}" placeholder="cantidad">
                  </div>
                    <div class="col-md-6">
                    <label for="exampleInputEmail1">Cantidad a Solicitar</label>
                    <input type="number" class="form-control"  name="cantidad" placeholder="Nueva Cantidad">
                  </div>
                  
                  </div>
                  <br>
                </div>

                <input type="hidden" name="id" value="{{$productos->id}}">
                <input type="hidden" name="almacen" value="{{$productos->almacen}}">



                <!-- /.card-body -->

                <div class="card-footer">
                  <button type="submit" class="btn btn-primary">Procesar</button>
                </div>
              </form>
				

               
               				
		</div>
	</div>
</div>