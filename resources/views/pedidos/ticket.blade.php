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
	
	   <p style="margin-top: -20px;"><strong>NÚMERO DE RECIBO ELECTRÓNICO:{{$ped->id}}</strong></p>

	</div>
    <br><br>
    <br><br>


    <div  style="font-size: 15px; text-align: left;margin-bottom:-60px;margin-top: -30px;">
    <p><strong>FECHA:</strong> {{$ped->created_at}} </p>
		<p><strong>HUESPED:</strong> {{$cli->nombre}} {{$cli->responsable}}</p>
	
	</div>
  <br><br><br>

    <table width="100%" class="table-main">
      <thead>
        <tr>
          <th style="font-size: 15px"><center>Cant.<center></th>
          <th style="font-size: 15px"><center>Desc.<center></th>
          <th style="font-size: 15px"><center>P.Unit.<center></th>
          <th style="font-size: 15px"><center>Total<center></th>
        </tr>
      </thead>
      <tbody>
        @foreach($pedidos as $line)
          <tr>
            <td style="font-size: 15px; line-height: 30px;" align="center">1</td>
            <td style="font-size: 15px; line-height: 30px;" align="center">{{$line->descripcion}}</td>
            <td style="font-size: 15px; line-height: 30px;" align="center">{{$line->monto}}</td>
            <td style="font-size: 15px; line-height: 30px;" align="center">{{$line->monto}}</td>
          </tr>
        @endforeach
      </tbody>
    </table>

    <br>

    <table width="100%">
      <tbody>
        <tr>
          <td style="width: 100%;">
            <table width="100%">
              <tbody>
                   

                    <tr>
                      <td align="left" style="font-size: 15px">VALOR TOTAL</td>
                      <td align="right" style="font-size: 15px">{{$ped->monto}}</td>
                    </tr>
              </tbody>
            </table>
          </td>
        </tr>
      </tbody>
    </table>

    

    </body>
