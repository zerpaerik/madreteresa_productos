<div class="row">
	<div class="col-xs-12">
		<div class="box">
			<div class="box-header">
				<div class="box-name">					
					<span>
                    <center> <strong>DESCARGA DE PRODUCTOS</strong></center><br>
					</span>
				</div>
			</div>

            <form method="post" action="productos/descargar">					
              {{ csrf_field() }}                
                    <div class="card-body">
                    <div class="row">
                    <div class="col-md-4">
                    <label for="exampleInputEmail1">Producto</label>
                    <input type="text" disabled class="form-control"  value="{{$productos->nompro}}" name="cantidad" placeholder="cantidad">
                  </div>
                  <div class="col-md-4">
                    <label for="exampleInputEmail1">Cantidad Actual</label>
                    <input type="text" disabled class="form-control"  value="{{$productos->cantidad}}" placeholder="cantidad">
                  </div>
                    <div class="col-md-4">
                    <label for="exampleInputEmail1">Cantidad</label>
                    <input type="number" class="form-control"  name="cant" placeholder="cantidad">
                  </div>
                  </div>
                  <br>
                </div>

                <input type="hidden" name="id" value="{{$productos->id}}">

                <!-- /.card-body -->

                <div class="card-footer">
                  <button type="submit" class="btn btn-primary">Procesar</button>
                </div>
              </form>
				

               
               				
		</div>
	</div>
</div>