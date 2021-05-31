<head>
    <style type="text/css">
      {
        margin: 0;
        padding: 0;
      }
      .table-main{
       margin-left:-55px;
       margin-right:-56px;
      }
      .cl{
        margin: 0;
        padding: 0;

      }
      .truncate {
        width: 1px;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
      }
      @page {
        header: page-header;
        footer: page-footer;
      }
      footer {
        border:solid red;
      }
    </style>

    <meta charset="utf-8">

  </head>

    <body style="width:100%; position:fixed: top: 1px; ">

    <br><br>

    <div  style="font-size: 15px; text-align: center;margin-bottom:-60px;margin-top: -30px;">
		<p><strong>INVERSIONES ORIENTALES M & D S.A.C</strong></p>
		<p style="margin-top: -20px;"><strong>RUC: 20492126072</strong></p>


    <p><strong>FECHA:</strong> {{$checkin->created_at}} </p>

    <p style="margin-top: -20px;"><strong>________________________________________________________</strong>  </p>
    <p style="margin-top: -15px;font-size: 14px;text-align: center;"><strong>NÚMERO DE RECIBO ELECTRÓNICO:0000{{$checkin->id}}</strong></p>
    <p style="margin-top: -30px;"><strong>________________________________________________________</strong>  </p>


	

	</div>
    <br><br>
    <div  style="font-size: 15px; text-align: left;margin-bottom:-60px;margin-top: 20px;">
		<p style="margin-left: -40px;"><strong>CLIENTE:</strong> {{ $checkin->nompac}},{{ $checkin->apepac}}</p>
    <p style="margin-left: -40px;margin-top: -15px;"><strong>DNI:</strong> {{ $checkin->identificacion}}</p>
	
	</div>
  <br><br><br>

    <table width="100%" class="table-main">
      <thead>
        <tr>
          <th style="font-size: 15px"><center>Cantidad.<center></th>
          <th style="font-size: 15px"><center>Servicio.<center></th>
          <th style="font-size: 15px"><center>Monto.<center></th>
        </tr>
      </thead>
      <tbody>
      @foreach($items as $item)
          <tr>
            <td style="font-size: 15px; line-height: 30px;" align="center">01</td>
            @if(strpos($item->descripcion, 'HABITACION') !== false)
            <td style="font-size: 15px; line-height: 30px;" align="center">VARIOS</td>
            @else
            <td style="font-size: 15px; line-height: 30px;" align="center">{{$item->descripcion}}</td>
            @endif
            <td style="font-size: 15px; line-height: 30px;" align="center">{{$item->monto}}</td>
          </tr>
      @endforeach
      </tbody>
    </table>
    <p style="margin-left: -40px;font-size:13px;"><strong>TIPO DE PAGO:</strong> {{ $checkin->tipopago}}</p>


    <br>

    <table width="100%">
      <tbody>
        <tr>
          <td style="width: 100%;">
            <table width="100%">
              <tbody>
                   

                    <tr>
                      <td align="left" style="font-size: 15px;margin-left:150px;">MONTO TOTAL</td>
                      <td align="right" style="font-size: 15px;margin-left:150px;">{{$total->monto }}</td>
                    </tr>
              </tbody>
            </table>
          </td>
        </tr>
      </tbody>
    </table>

    

    </body>
