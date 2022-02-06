<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>MadreTeresa | Admin</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">

  <link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.6.5/css/buttons.dataTables.min.css">

  <!-- Tempusdominus Bbootstrap 4 -->
  <link rel="stylesheet" href="plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">
  <!-- iCheck -->
  <link rel="stylesheet" href="plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <!-- JQVMap -->
  <link rel="stylesheet" href="plugins/jqvmap/jqvmap.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="dist/css/adminlte.min.css">
  <!-- overlayScrollbars -->
  <link rel="stylesheet" href="plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
  <!-- Daterange picker -->
  <link rel="stylesheet" href="plugins/daterangepicker/daterangepicker.css">
  <!-- summernote -->
  <link rel="stylesheet" href="plugins/summernote/summernote-bs4.css">


  <!-- Google Font: Source Sans Pro -->
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
<!-- DataTables -->
<link rel="stylesheet" href="../../plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" href="../../plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
</head>
<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">

  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
  @include('layouts.navbar')
  </nav>
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    @include('layouts.sidebar')
    <!-- /.sidebar -->
  </aside>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Productos Usados</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Productos Usados</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">   
    @include('flash-message')

      <div class="container-fluid">
      <div class="card">
              <div class="card-header">
               
                      <form method="get" action="productos_usados">					

                    <div class="row">
                  <div class="col-md-3">
                    <label for="exampleInputEmail1">Fecha Inicio</label>
                    <input type="date" class="form-control" value="{{$f1}}" name="inicio" placeholder="Buscar por dni">
                  </div>

                  <div class="col-md-3">
                    <label for="exampleInputEmail1">Fecha Fin</label>
                    <input type="date" class="form-control" value="{{$f2}}" name="fin" placeholder="Buscar por dni">
                  </div>
                 
                 
                  <div class="col-md-2">
                    <label for="exampleInputEmail1">Almacen</label>
                    <select class="form-control" name="almacen">
                    @if($alma == 2)
                    <option value="2" selected>Recepción</option>
                    <option value="3">Obstetra</option>
                    <option value="4">Rayos X</option>
                    <option value="11">Laboratorio</option>
                  
                    @elseif($alma == 3)
                    <option value="2">Recepción</option>
                    <option value="3" selected>Obstetra</option>
                    <option value="4">Rayos X</option>
                    <option value="11">Laboratorio</option>
                  
                    @elseif($alma == 4)
                    <option value="2">Recepción</option>
                    <option value="3">Obstetra</option>
                    <option value="4" selected>Rayos X</option>
                    <option value="11">Laboratorio</option>
                 
                    @elseif($alma == 7)
                    <option value="2">Recepción</option>
                    <option value="3">Obstetra</option>
                    <option value="4">Rayos X</option>
                    <option value="11">Laboratorio</option>
              
                    @elseif($alma == 8)
                    <option value="2">Recepción</option>
                    <option value="3">Obstetra</option>
                    <option value="4">Rayos X</option>
                    <option value="11">Laboratorio</option>
                  
                    @elseif($alma == 9)
                    <option value="2">Recepción</option>
                    <option value="3">Obstetra</option>
                    <option value="4">Rayos X</option>
                    <option value="11">Laboratorio</option>
                 
                    @elseif($alma == 11)
                    <option value="2">Recepción</option>
                    <option value="3">Obstetra</option>
                    <option value="4">Rayos X</option>
                    <option value="11" selected>Laboratorio</option>
                  
                    @else
                    <option value="2">Recepción</option>
                    <option value="3">Obstetra</option>
                    <option value="4">Rayos X</option>
                    <option value="11">Laboratorio</option>
     
                    @endif
                    </select>                  
                    </div>
                    <div class="col-md-2">
                    <label for="exampleInputEmail1">Producto</label>
                    <select class="form-control" name="producto">
                    <option value="0">Todos</option>
                    @foreach($productosg as $prod)
                    <option value="{{$prod->id}}" >{{$prod->nombre}}</option>
                    @endforeach
                
                    </select>                  
                    </div>
                    <div class="col-md-2" style="margin-top: 30px;">
                  <button type="submit" class="btn btn-primary">Buscar</button>

                  </div>
                  </div>
                  <!--
                 <div class="row">

                  <div class="col-md-2">
                    <label for="exampleInputEmail1">Items</label>
                    <input type="text" disabled class="form-control" value="{{$soli->item}}" >
                  </div>
                  <div class="col-md-2">
                    <label for="exampleInputEmail1">Cantidad</label>
                    <input type="text" disabled class="form-control" value="{{$soli->cant}}" >
                  </div>
                  <div class="col-md-2">
                    <label for="exampleInputEmail1">Cantidad Total Soles</label>
                    <input type="text" disabled class="form-control" value="{{$soli->preciototal}}" >
                  </div>
                  <div class="col-md-2">
                    <label for="exampleInputEmail1">Producto Seleccionado</label>
                    <input type="text" disabled class="form-control" value="{{$producto_sel}}" >
                  </div>
                  </div>
                  </form>
              </div>––>
              <!-- /.card-header -->
              <div class="card-body">
                <table id="example" class="table table-bordered table-striped">
                  <thead>
                  <tr>
                  <th>Producto</th>
                    <th>Cantidad</th>
                    <th>Precio</th>
                    <th>Total Soles</th>
                    <th>Fecha Descarga</th>
                    <th>Almacen</th>
                    <th>Fecha</th>
                    <th>Acciones</th>
                  </tr>
                  </thead>
                  <tbody>

                  @foreach($productos as $an)
                  <tr>
                    <td>{{$an->nompro}}</td>
                    <td>{{$an->cant}}</td>
                    <td>{{$an->precio}}</td>
                    <td>{{number_format((float)$an->precio * $an->cant, 2, '.', '')}}</td>
                    <td>{{$an->fecha}}</td>
                    @if($an->almacen == 2)
                    <td>Recepción</td>
                    @elseif($an->almacen == 3)
                    <td>Obstetra</td>
                    @else
                    <td>Rayos X</td>
                    @endif
                    <td>{{$an->created_at}}</td>
                    <td>
                    @if($an->estatus == 1)
                    @if(Auth::user()->rol == 1)

                         
                          <a class="btn btn-danger btn-sm" href="productos-usados-reversar-{{$an->id}}" onclick="return confirm('¿Desea Reversar este registro?')">
                              <i class="fas fa-trash">
                              </i>
                              Reversar
                          </a>

                       
                          @endif
                          @else
                          <span class="badge bg-success">Reversado por:</span>
                          <span class="badge bg-success">{{$an->eliminado_por}}</span>



                          @endif
                          <a class="btn btn-success btn-sm" target="_blank" href="productos_usados_report/{{$an->producto}}/{{$f1}}/{{$f2}}/{{$alma}}">
                              <i class="fas fa-print">
                              </i>
                              Recibo
                          </a>
                          </td>

                  </tr>
                  @endforeach
                 
                 
               
                 
                 
                  </tbody>
                  <tfoot>
                  <tr>
                    <th>Producto</th>
                    <th>Cantidad</th>
                    <th>Precio</th>
                    <th>Total Soles</th>
                    <th>Fecha Descarga</th>
                    <th>Almacen</th>
                    <th>Fecha</th>
                    <th>Acciones</th>
                  </tr>
                  </tfoot>
                </table>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
          <!-- /.col -->
        </div>
        <!-- /.row -->
      </div>
      <!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>
  </div>
  </section>

  <!-- /.content-wrapper -->
  
  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->

<!-- jQuery -->
<script src="plugins/jquery/jquery.min.js"></script>
<!-- jQuery UI 1.11.4 -->
<script src="plugins/jquery-ui/jquery-ui.min.js"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
  $.widget.bridge('uibutton', $.ui.button)
</script>
<!-- Bootstrap 4 -->
<script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- ChartJS -->
<script src="plugins/chart.js/Chart.min.js"></script>
<!-- Sparkline -->
<script src="plugins/sparklines/sparkline.js"></script>
<!-- JQVMap -->
<script src="plugins/jqvmap/jquery.vmap.min.js"></script>
<script src="plugins/jqvmap/maps/jquery.vmap.usa.js"></script>
<!-- jQuery Knob Chart -->
<script src="plugins/jquery-knob/jquery.knob.min.js"></script>
<!-- daterangepicker -->
<script src="plugins/moment/moment.min.js"></script>
<script src="plugins/daterangepicker/daterangepicker.js"></script>
<!-- Tempusdominus Bootstrap 4 -->
<script src="plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>
<!-- Summernote -->
<script src="plugins/summernote/summernote-bs4.min.js"></script>
<!-- overlayScrollbars -->
<script src="plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
<!-- AdminLTE App -->
<script src="dist/js/adminlte.js"></script>
<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<script src="dist/js/pages/dashboard.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="dist/js/demo.js"></script>

<!-- DataTables -->
<script src="../../plugins/datatables/jquery.dataTables.min.js"></script>
<script src="../../plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="../../plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="../../plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>

<script type="text/javascript" src="https://cdn.datatables.net/buttons/1.6.1/js/dataTables.buttons.min.js"></script> 
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/buttons/1.6.1/js/buttons.html5.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/buttons/1.6.1/js/buttons.print.min.js"></script>
<!-- AdminLTE App -->
<script src="../../dist/js/adminlte.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="../../dist/js/demo.js"></script>
<!-- page script -->
<script>

$(document).ready(function() {
    $('#example').DataTable( {
        dom: 'Bfrtip',
        buttons: [
            'excel', 'pdf', 'print'
        ]
    } );
} );
</script>

<script>
  $(function () {
    $("#example1").DataTable({
      "responsive": true,
      "autoWidth": false,
      dom: 'Bfrtip',
      buttons: [
            'copy', 'csv', 'excel', 'pdf', 'print'
        ]
    });
    $('#example2').DataTable({
      "paging": true,
      "lengthChange": false,
      "searching": false,
      "ordering": true,
      "info": true,
      "autoWidth": false,
      "responsive": true,
    });
  });
</script>
</body>
</html>
