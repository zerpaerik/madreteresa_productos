                  <div class="col-md-12">
                    <label for="exampleInputEmail1">Habitación:</label>
                  <select class="form-control" data-placeholder="Seleccione" style="width: 100%;" name="solicitud">
                   @foreach($solicitudes as $a)
                   <option value="{{$a->id}}">{{$a->hab}} Huesped:{{$a->nompac}} {{$a->apepac}}</option>
                    @endforeach
                  </select>

                  </div>
