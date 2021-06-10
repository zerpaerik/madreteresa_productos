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
            <h1 class="m-0 text-dark">Requerimientos Procesados</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Requerimientos Procesados</li>
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
               
                      <form method="get" action="requerimientos2">					

                    <div class="row">
                  <div class="col-md-2">
                    <label for="exampleInputEmail1">Inicio</label>
                    <input type="date" class="form-control" value="{{$f1}}" name="inicio" placeholder="Buscar por dni">
                  </div>
                  <div class="col-md-2">
                    <label for="exampleInputEmail1">Fin</label>
                    <input type="date" class="form-control" value="{{$f2}}" name="fin" placeholder="Buscar por dni">
                  </div>
                  <div class="col-md-3">
                    <label for="exampleInputEmail1">Productos</label>
                    <select class="form-control" name="producto">
                    <option value="">Seleccione</option>
                    @foreach($productos as $pr)
                    <option value="{{$pr->producto}}">{{$pr->nompro}}</option>
                    @endforeach
                 
                    </select>                  
                    </div>

                  <div class="col-md-2">
                    <label for="exampleInputEmail1">Almacen</label>
                    <select class="form-control" name="solicita">
                    <option value="2">Recepción</option>
                    <option value="3">Obstetra</option>
                    <option value="4">Rayos X</option>
                    <option value="11">Laboratorio</option>
                    <option value="7">Canto Rey</option>
                    <option value="8">Vida Feliz</option>
                    <option value="9">Zarate</option>
                    <option value="99">Todos</option>
                    </select>                  
                    </div>
                 
                  
                  <div class="col-md-1" style="margin-top: 30px;">
                  <button type="submit" class="btn btn-primary">Buscar</button>

                  </div>

                  <div class="row">
                  <div class="col-md-2">
                    <label for="exampleInputEmail1">Items</label>
                    <input type="text" disabled class="form-control" value="{{$soli->item}}" >
                  </div>
                  <div class="col-md-2">
                    <label for="exampleInputEmail1">Cantidad</label>
                    <input type="text" disabled class="form-control" value="{{$soli->cant}}" >
                  </div>
              

                  </div>

                  
                
                 
                  </form>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table id="example" class="table table-bordered table-striped">
                  <thead>
                  <tr>
                    <th>Producto</th>
                    <th>Medida</th>
                    <th>Solicitante</th>
                    <th>Cant.Sol</th>
                    <th>Cant.Ent</th>
                    <th>Fecha</th>
                    <th>Acciones</th>
                  </tr>
                  </thead>
                  <tbody>

                 
                  @foreach($requerimientos as $eq)
                  <tr>
                    <td>{{$eq->nompro}}</td>
                    <td>{{$eq->medida}}</td>
                    @if($eq->almacen_solicita == 2)
                    <td>Recepción</td>
                    @elseif($eq->almacen_solicita == 11)
                    <td>Laboratorio</td>
                    @elseif($eq->almacen_solicita == 3)
                    <td>Obstetra</td>
                    @elseif($eq->almacen_solicita == 4)
                    <td>Rayos X</td>
                    @elseif($eq->almacen_solicita == 5)
                    <td>Independencia</td>
                    @elseif($eq->almacen_solicita == 6)
                    <td>Olivos</td>
                    @elseif($eq->almacen_solicita == 7)
                    <td>Canto Rey</td>
                    @elseif($eq->almacen_solicita == 8)
                    <td>Vida Feliz</td>
                    @else
                    <td>Zarate</td>
                    @endif
                    
                    
                    <td>{{$eq->cantidad_solicita}}</td>
                    <td>{{$eq->cantidad_despachada}}</td>
                    <td>{{ Carbon\Carbon::createFromDate($eq->created_at)->format('d-m-Y')  }}</td>
                    <td>
                    <a class="btn btn-danger btn-sm" href="requerimientos-reversar-{{$eq->id}}" onclick="return confirm('¿Desea Reversar este registro?')">
                              <i class="fas fa-backward">
                              </i>
                              Reversar
                          </a>
                          <a target="_blank" class="btn btn-success btn-sm" href="requerimientos-ticket-{{$eq->req}}">
                              <i class="fas fa-print">
                              </i>
                              Comprobante
                          </a>

                  </td>
                  </tr>
                  @endforeach
                 
                 
               
                 
                 
                  </tbody>
                  <tfoot>
                  <tr>
                  <th>Producto</th>
                    <th>Medida</th>
                    <th>Solicitante</th>
                    <th>Cant.Sol</th>
                    <th>Cant.Ent</th>
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
