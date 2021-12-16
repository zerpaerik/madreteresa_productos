<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('auth.login');
});



Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::get('roles', 'RolesController@index')->name('roles.index');
Route::get('roles-create', 'RolesController@create')->name('roles.create')->middleware('auth');
Route::post('roles/create', 'RolesController@store')->middleware('auth');
Route::get('roles-delete-{id}', 'RolesController@delete')->middleware('auth');
Route::get('roles-edit-{id}', 'RolesController@edit')->name('roles.edit');
Route::post('roles/edit', 'RolesController@update');

Route::get('personal', 'PersonalController@index')->name('personal.index');
Route::get('personal-create', 'PersonalController@create')->name('personal.create')->middleware('auth');
Route::post('personal/create', 'PersonalController@store')->middleware('auth');
Route::get('personal-delete-{id}', 'PersonalController@delete')->middleware('auth');
Route::get('personal-edit-{id}', 'PersonalController@edit')->name('personal.edit');
Route::post('personal/edit', 'PersonalController@update');

Route::get('centros', 'CentrosController@index')->name('centros.index');
Route::get('centros-create', 'CentrosController@create')->name('centros.create')->middleware('auth');
Route::post('centros/create', 'CentrosController@store')->middleware('auth');
Route::get('centros-delete-{id}', 'CentrosController@delete')->middleware('auth');
Route::get('centros-edit-{id}', 'CentrosController@edit')->name('centros.edit');
Route::post('centros/edit', 'CentrosController@update');

Route::get('profesionales', 'ProfesionalesController@index')->name('profesionales.index');
Route::get('profesionales-create', 'ProfesionalesController@create')->name('profesionales.create')->middleware('auth');
Route::post('profesionales/create', 'ProfesionalesController@store')->middleware('auth');
Route::get('profesionales-delete-{id}', 'ProfesionalesController@delete')->middleware('auth');
Route::get('profesionales-edit-{id}', 'ProfesionalesController@edit')->name('profesionales.edit');
Route::post('profesionales/edit', 'ProfesionalesController@update');

Route::get('laboratorio', 'LaboratorioController@index')->name('laboratorio.index');
Route::get('laboratorio-create', 'LaboratorioController@create')->name('laboratorio.create')->middleware('auth');
Route::post('laboratorio/create', 'LaboratorioController@store')->middleware('auth');
Route::get('laboratorio-delete-{id}', 'LaboratorioController@delete')->middleware('auth');
Route::get('laboratorio-edit-{id}', 'LaboratorioController@edit')->name('laboratorio.edit');
Route::post('laboratorio/edit', 'LaboratorioController@update');

Route::get('usuarios', 'UserController@index')->name('usuarios.index');
Route::get('usuarios-create', 'UserController@create')->name('usuarios.create')->middleware('auth');
Route::post('usuarios/create', 'UserController@store')->middleware('auth');
Route::get('usuarios-delete-{id}', 'UserController@delete')->middleware('auth');
Route::get('usuarios-edit-{id}', 'UserController@edit')->name('usuarios.edit');
Route::post('usuarios/edit', 'UserController@update');

Route::get('crear/sesion','UserController@sesion');
Route::get('crear/otros','UserController@otros');

Route::get('users-password-edit', 'UserController@updatepasswd')->name('users.password');
Route::post('users/updatepassw', 'UserController@updatepass');



Route::get('activos', 'EquiposController@index')->name('equipos.index');
Route::get('equipos-create', 'EquiposController@create')->name('equipos.create')->middleware('auth');
Route::post('equipos/create', 'EquiposController@store')->middleware('auth');
Route::get('equipos-delete-{id}', 'EquiposController@delete')->middleware('auth');
Route::get('equipos-edit-{id}', 'EquiposController@edit')->name('equipos.edit');
Route::post('equipos/edit', 'EquiposController@update');

Route::get('requerimientos', 'RequerimientosController@index')->name('requerimientos.index');
Route::get('requerimientos1', 'RequerimientosController@index1')->name('requerimientos.index1');
Route::get('requerimientos2', 'RequerimientosController@index2')->name('requerimientos.index2');
Route::get('requerimientose', 'RequerimientosController@enviados')->name('requerimientos.enviados');
Route::get('requerimientos-create', 'RequerimientosController@create')->name('requerimientos.create')->middleware('auth');
Route::get('requerimientos-create1', 'RequerimientosController@create1')->name('requerimientos.create1')->middleware('auth');
Route::get('requerimientos-create-almacen-{id}', 'RequerimientosController@createa')->name('requerimientos.createa')->middleware('auth');
Route::post('requerimientos/create', 'RequerimientosController@store')->middleware('auth');
Route::post('requerimientos/create1', 'RequerimientosController@store1')->middleware('auth');
Route::post('requerimientos/createa', 'RequerimientosController@storea')->middleware('auth');
Route::get('requerimientos-reversar-{id}', 'RequerimientosController@reversar')->middleware('auth');
Route::get('requerimientos-edit', 'RequerimientosController@edit');
Route::get('requerimientos-delete-{id}', 'RequerimientosController@delete')->middleware('auth');
Route::post('requerimientos/edit', 'RequerimientosController@update');
Route::get('requerimientos/view/{id}', 'RequerimientosController@ver');
Route::get('requerimientos-ticket-{id}', 'RequerimientosController@ticket');


Route::get('material', 'MaterialController@index')->name('material.index');
Route::get('material-create', 'MaterialController@create')->name('material.create')->middleware('auth');
Route::post('material/create', 'MaterialController@store')->middleware('auth');
Route::get('material-delete-{id}', 'MaterialController@delete')->middleware('auth');
Route::get('material-edit-{id}', 'MaterialController@edit')->name('material.edit');
Route::post('material/edit', 'MaterialController@update');

Route::get('tiempo', 'TiempoController@index')->name('tiempo.index');
Route::get('tiempo-create', 'TiempoController@create')->name('tiempo.create')->middleware('auth');
Route::post('tiempo/create', 'TiempoController@store')->middleware('auth');
Route::get('tiempo-delete-{id}', 'TiempoController@delete')->middleware('auth');
Route::get('tiempo-edit-{id}', 'TiempoController@edit')->name('tiempo.edit');
Route::post('tiempo/edit', 'TiempoController@update');

Route::get('analisis', 'AnalisisController@index')->name('analisis.index');
Route::get('analisis-create', 'AnalisisController@create')->name('analisis.create')->middleware('auth');
Route::post('analisis/create', 'AnalisisController@store')->middleware('auth');
Route::get('analisis-delete-{id}', 'AnalisisController@delete')->middleware('auth');
Route::get('analisis-edit-{id}', 'AnalisisController@edit')->name('analisis.edit');
Route::post('analisis/edit', 'AnalisisController@update');
Route::get('analisis-dispon-{id}', 'AnalisisController@dispon');
Route::get('analisis-dispon1-{id}-{id2}', 'AnalisisController@dispon1');


Route::get('pacientes', 'PacientesController@index')->name('pacientes.index');
Route::get('pacientes-create', 'PacientesController@create')->name('pacientes.create')->middleware('auth');
Route::post('pacientes/create', 'PacientesController@store')->middleware('auth');
Route::get('pacientes-delete-{id}', 'PacientesController@delete')->middleware('auth');
Route::get('pacientes-edit-{id}', 'PacientesController@edit')->name('pacientes.edit');
Route::post('pacientes/edit', 'PacientesController@update');

Route::get('productos_usados', 'ProductosUsadosController@index')->name('productosu.index');
Route::get('productos_usados1', 'ProductosUsadosController@index1')->name('productosu.index1');
Route::get('productos-usados-creater', 'ProductosUsadosController@creater')->name('productosu.creater')->middleware('auth');
Route::get('productos-usados-createl', 'ProductosUsadosController@createl')->name('productosu.createl')->middleware('auth');
Route::get('productos-usados-createo', 'ProductosUsadosController@createo')->name('productosu.createo')->middleware('auth');
Route::get('productos-usados-createra', 'ProductosUsadosController@createra')->name('productosu.createra')->middleware('auth');
Route::get('productos-usados-create', 'ProductosUsadosController@create')->name('productosu.create')->middleware('auth');
Route::post('productos-usados/create', 'ProductosUsadosController@store')->middleware('auth');
Route::post('productos-usados/createl', 'ProductosUsadosController@storel')->middleware('auth');
Route::post('productos-usados/creater', 'ProductosUsadosController@storer')->middleware('auth');
Route::post('productos-usados/createo', 'ProductosUsadosController@storeo')->middleware('auth');
Route::post('productos-usados/createra', 'ProductosUsadosController@storera')->middleware('auth');
Route::get('productos-usados-delete-{id}', 'ProductosUsadosController@delete')->middleware('auth');
Route::get('productos-usados-reversar-{id}', 'ProductosUsadosController@reversar')->middleware('auth');
Route::get('productos-usados-reversar1-{id}', 'ProductosUsadosController@reversar1')->middleware('auth');
Route::get('productos-usados-edit-{id}', 'ProductosUsadosController@edit')->name('productosu.edit');
Route::post('productosu/edit', 'ProductosUsadosController@update');
Route::get('productos_usados_report/{p}/{f1}/{f2}/{al}', 'ProductosUsadosController@productos_usados_report')->middleware('auth');


Route::get('crear-sesion', 'UserController@sesion')->name('sesion.create')->middleware('auth');


Route::get('solicitudes', 'SolicitudesController@index')->name('solicitudes.index');
Route::get('pagadas', 'SolicitudesController@pagadas')->name('pagadas.index');
Route::get('solicitudes1', 'SolicitudesController@index1')->name('solicitudes.index1');
Route::get('solicitudes-create', 'SolicitudesController@create')->name('solicitudes.create')->middleware('auth');
Route::post('solicitudes/create', 'SolicitudesController@store')->middleware('auth');
Route::get('solicitudes-delete-{id}', 'olicitudesController@delete')->middleware('auth');
Route::get('solicitudes-edit-{id}', 'SolicitudesController@edit')->name('solicitudes.edit');
Route::get('solicitudes-pagar-{id}', 'SolicitudesController@pagar');
Route::get('solicitudes-rev-{id}', 'SolicitudesController@reversar');
Route::post('solicitudes/edit', 'SolicitudesController@update');
Route::get('solicitudes/view/{id}', 'SolicitudesController@ver');


Route::get('ingresos', 'IngresosController@index')->name('ingresos.index');
Route::get('ingresos-create', 'IngresosController@create')->name('ingresos.create')->middleware('auth');
Route::post('ingresos/create', 'IngresosController@store')->middleware('auth');
Route::get('ingresos-delete-{id}', 'IngresosController@delete')->middleware('auth');
Route::get('ingresos-edit-{id}', 'IngresosController@edit')->name('ingresos.edit');
Route::post('ingresos/edit', 'IngresosController@update');
Route::get('ingresos-ticket-{id}', 'IngresosController@ticket');


Route::get('ingresos/siniestros','IngresosController@solicitudes');
Route::get('ingresos/otros','IngresosController@otros');



Route::get('checkin', 'CheckinController@index')->name('checkin.index');
Route::get('checkin-create', 'CheckinController@create')->name('ckeckin.create')->middleware('auth');
Route::post('checkin/create', 'CheckinController@store')->middleware('auth');
Route::post('checkin/recargar', 'CheckinController@recarga');
Route::get('checkin-delete-{id}', 'CheckinController@delete')->middleware('auth');
Route::get('checkin-crear-{id}', 'CheckinController@crearhome')->name('ckeckin.createhome')->middleware('auth');
Route::get('checkin-edit-{id}', 'CheckinController@edit')->name('checkin.edit');
Route::post('checkin/edit', 'CheckinController@update');
Route::get('checkin/view/{id}', 'CheckinController@ver');
Route::get('checkin-ticket-{id}', 'CheckinController@ticket');
Route::get('checkin-delete-{id}','CheckinController@delete');
Route::get('checkin-recargar-{id}', 'CheckinController@recargar');



Route::get('pedidos', 'PedidosController@index')->name('pedidos.index');
Route::get('pedidos-create', 'PedidosController@create')->name('pedidos.create')->middleware('auth');
Route::post('pedidos/create', 'PedidosController@store')->middleware('auth');
Route::get('pedidos-delete-{id}', 'PedidosController@delete')->middleware('auth');
Route::get('pedidos-edit-{id}', 'PedidosController@edit')->name('pedidos.edit');
Route::get('pedidos-pagar-{id}', 'PedidosController@pagar');
Route::get('pedidos-ticket-{id}', 'PedidosController@ticket');
Route::post('pedidos/edit', 'PedidosController@update');
Route::post('pedidos/pagar', 'PedidosController@pago');

Route::get('gastos', 'GastosController@index')->name('gastos.index');
Route::get('gastos-create', 'GastosController@create')->name('gastos.create')->middleware('auth');
Route::post('gastos/create', 'GastosController@store')->middleware('auth');
Route::get('gastos-delete-{id}', 'GastosController@delete')->middleware('auth');
Route::get('gastos-edit-{id}', 'GastosController@edit')->name('gastos.edit');
Route::post('gastos/edit', 'GastosController@update');

Route::get('siniestros', 'SiniestrosController@index')->name('siniestros.index');
Route::get('siniestros-create', 'SiniestrosController@create')->name('siniestros.create')->middleware('auth');
Route::post('siniestros/create', 'SiniestrosController@store')->middleware('auth');
Route::get('siniestros-delete-{id}', 'SiniestrosController@delete')->middleware('auth');
Route::get('siniestros-edit-{id}', 'SiniestrosController@edit')->name('siniestros.edit');
Route::post('siniestros/edit', 'SiniestrosController@update');

Route::get('consolidado', 'ReportesController@consolidado')->name('consolidado.index');
Route::get('detallado', 'ReportesController@detallado')->name('detallado.index');
Route::get('general', 'ReportesController@general')->name('general.index');
Route::post('report/consolidado', 'ReportesController@reportc');
Route::post('report/detallado', 'ReportesController@reportd');
Route::post('report/general', 'ReportesController@reportg');

Route::get('productos', 'ProductosController@index')->name('productos.index');
Route::get('recepcion', 'ProductosController@recepcion')->name('productos.recepcion');
Route::get('productos/descargar/{id}', 'ProductosController@descargar');
Route::get('productos/historial/{id}', 'ProductosController@historial');
Route::get('productos/editc/{id}', 'ProductosController@editc');
Route::get('productos/requerimiento/{id}', 'ProductosController@requerimiento');
Route::post('productos/descargar', 'ProductosController@descargarPost');
Route::post('productos/reqPost', 'ProductosController@reqPost');
Route::post('productos/editcP', 'ProductosController@editcP');
Route::get('obstetra', 'ProductosController@obstetra')->name('productos.obstetra');
Route::get('rayos', 'ProductosController@rayos')->name('productos.rayos');
Route::get('laboratorio-almacen', 'ProductosController@laboratorio')->name('productos.laboratorio');

Route::get('almacen', 'ProductosController@almacen')->name('productos.almacen');


Route::get('consultaproductos', 'ProductosController@consulta');

Route::get('productos-create', 'ProductosController@create')->name('productos.create')->middleware('auth');

Route::post('productos/create', 'ProductosController@store')->middleware('auth');
Route::get('productos-delete-{id}', 'ProductosController@delete')->middleware('auth');
Route::get('productos-edit-{id}', 'ProductosController@edit')->name('productos.edit');
Route::post('productos/edit', 'ProductosController@update');
Route::get('productos/getProducto/{id}', 'ProductosController@getProducto');
Route::get('productos/getProductoAlmacenr/{id}', 'ProductosController@getProductosAlmacenr');
Route::get('productos/getProductoAlmacenl/{id}', 'ProductosController@getProductosAlmacenl');
Route::get('productos/getProductoAlmaceno/{id}', 'ProductosController@getProductosAlmaceno');
Route::get('productos/getProductoAlmacenra/{id}', 'ProductosController@getProductosAlmacenra');
Route::get('productos/getProductoAlmacen/{id}', 'ProductosController@getProductosAlmacen');


Route::get('productosl', 'ProductoslController@index')->name('productosl.index');
Route::get('productosl-create', 'ProductoslController@create')->name('productosl.create')->middleware('auth');
Route::post('productosl/create', 'ProductoslController@store')->middleware('auth');
Route::get('productosl-delete-{id}', 'ProductoslController@delete')->middleware('auth');
Route::get('productosl-edit-{id}', 'ProductoslController@edit')->name('productosl.edit');
Route::post('productosl/edit', 'ProductoslController@update');

Route::get('ingreso-productosl', 'ProductoslController@ingproductosl')->name('ingproductosl.index');
Route::get('ingproductosl-create', 'ProductoslController@ingcreatel')->name('ingproductosl.create')->middleware('auth');
Route::post('ingreso/productosl', 'ProductoslController@storeing');
Route::get('ingreso-reversarl-{id}', 'ProductoslController@reversaring')->middleware('auth');

Route::get('salida-productos', 'ProductoslController@salida')->name('salida.index');
Route::get('salida-create', 'ProductoslController@salidacreate')->name('salida.create')->middleware('auth');
Route::post('salida/productosl', 'ProductoslController@storesal');
Route::get('salida-reversarl-{id}', 'ProductoslController@reversarsal')->middleware('auth');

Route::get('ingreso-productos', 'ProductosController@ingproductos')->name('ingproductos.index');
Route::get('ingproductos-create', 'ProductosController@ingcreate')->name('ingproductos.create')->middleware('auth');
Route::post('ingreso/productos', 'ProductosController@storeing');
Route::get('ingreso-reversar-{id}', 'ProductosController@reversar')->middleware('auth');
Route::get('ingresop-edit-{id}', 'ProductosController@editingreso')->middleware('auth');
Route::post('ingresosp/update', 'ProductosController@updateingreso');
Route::get('ingresos/view/{id}', 'ProductosController@ver')->middleware('auth');

Route::get('almacen-central', 'ProductosController@central')->name('central.index');



Route::get('cierre-caja','CajaController@index')->name('cierre.index')->middleware('auth');
Route::get('cierre-caja-reporte-{fecha}','CajaController@reporte_pdf')->name('cierre.reporte')->middleware('auth');
Route::post('cierre-caja-create','CajaController@create')->name('cierre.create')->middleware('auth');
Route::get('caja-delete-{id}','CajaController@delete');
Route::get('caja-ticket-{id}','CajaController@ticket');
Route::get('caja-cerrar-{id}','CajaController@cerrar');
Route::get('saldo/view/{id}', 'CajaController@saldo');









Route::get('/solicitudes/dataPacientes/{id}','SolicitudesController@datapac');



Route::get('storage/{archivo}', function ($archivo) {
    $public_path = public_path();
    $url = $public_path.'/storage/'.$archivo;
    //verificamos si el archivo existe y lo retornamos
    if (Storage::exists($archivo))
    {
      return response()->download($url);
    }
    //si no se encuentra lanzamos un error 404.
    abort(404);

});


