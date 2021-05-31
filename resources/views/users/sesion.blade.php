<div class="card-header">
                <h3 class="card-title">Datos para Inicio de Sesión</h3>
              </div>
<div class="row">
                  <div class="col-md-4">
                    <label for="exampleInputEmail1">Contraseña</label>
                    <input type="password" class="form-control" id="password" name="password" placeholder="Contraseña de acceso">
                  </div>
                  <div class="col-md-4">
                    <label for="exampleInputEmail1">Rol</label>
                    <select class="form-control" data-placeholder="Seleccione" style="width: 100%;" name="rol">
                   @foreach($roles as $r)
                   <option value="{{$r->id}}">{{$r->nombre}}</option>
                    @endforeach
                  </select>                  
                  </div>
                 
                  
                  </div>