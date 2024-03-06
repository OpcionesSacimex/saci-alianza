<!DOCTYPE html>
<html>
    <head>
        <style>
            .texto-pequeno{
                font-size: 10px;
            }
            .texto-centro{
                text-align: center;
            }
            .texto-derecha{
                text-align: right;
            }
            .texto-izquierda{
                text-align: left;
            }
            .gris{
                background: gray;
                padding-left: 20px;
                padding-right: 20px;
            }
            .clienteDatos{
                background: #eee;
                border:0;
                border-bottom: 1px solid;
            }
            .cabecera-exi{
                /*background-color: black;*/
                height: 20px;
                border: 0;
                background-color: #ffe699;
                font-weight: bold;
                font-family: Cambria, Georgia, serif;
                font-size: 8px;
            }
            .cabecera-liquida{
                /*background-color: black;*/
                height: 20px;
                border: 0;
                background-color: #fff2cc;
                font-weight: bold;
                font-family: Cambria, Georgia, serif;
                font-size: 8px;
            }
            .logo{
                width: 20%;
            }
            .grisObscuro{
                background: #808080;
                font-weight: bold;
            }
            .subrayado{
                text-decoration: underline;
            }
            .bordesolido{
                border-color: black;
                border-width: 1px;
                border-style: solid;
            }
            .tablaDato{
                width:50px;
                border-color: black;
                border-width: 1px;
                border-style: solid;
                text-align: center;
                height: 15px;
            }
            .tablaInfor{
                text-align: right;
                /*height: 120px;*/
            }
            .tablaInfor{

            }
            .contenedor{
                border-color: black;
                border-width: 1px;
                border-style: solid;
            }
            .mayuscula {
                text-transform: capitalize;
            }
            .bordeTabla {
                border: 1px solid black;
                border-collapse: collapse;
            }

            #noBordeTabla td, #noBordeTabla th {
                border: none;
                padding: 5px;
            }

            .bordeDerecho{
                border-right: 1px solid black;
                border-collapse: collapse;
            }
            .texto-blanco{
                color:white;
            }
            .derecha {
                position: absolute;
                right: 30px;
                /*top:-15px;*/
            }
            .texto-justificado{
                text-align : justify;
            }
            table {
                font-family: arial, sans-serif;
                border-collapse: collapse;
                width: 100%;
            }

            #clientes td, #clientes th {
                border: 1px solid #dddddd;
                /*text-align: left;*/
                padding: 10px;
            }

            #grupos td, #grupos th {
                border: 1px solid #dddddd;
                /*text-align: left;*/
                padding: 3px;
            }
            .texto-rojo{
                color: red;
            }
            .texto-verde{
                color: #00632F;
            }
            .texto-grande{
                font-family: Calibri, Candara, Segoe, 'Segoe UI', Optima, Arial, sans-serif;
                font-size: 30px;
                font-weight: bold;
            }
            .subrayado{
                text-decoration: underline;
            }
        </style>
    </head>
    <body style="padding-left: 15px;padding-right: 15px;">
        @php
            $dia = array("Domingo","Lunes","Martes","Miércoles","Jueves","Viernes","Sábado");
            $mes = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
            //$sucursal = Auth::user()->sucursal->nombre;
        @endphp
        <div style="font-family: Calibri, Candara, Segoe, 'Segoe UI', Optima, Arial, sans-serif;font-size: 11px;">
            <div class="texto-centro">
                <h1><strong>Simulador y evidencia de análisis de crédito - {{ date('Y') }}</strong></h1>
            </div>
            <div class="texto-derecha">
                 {{ $dia[date("w")] }}, {{ date('d') }} de {{ $mes[date("n")-1] }} de {{ date('Y') }} {{ date('H:m') }}
            </div>
        </div>
        <br>
        <div class="texto-centro" style="font-family: Calibri, Candara, Segoe, 'Segoe UI', Optima, Arial, sans-serif;">
            <strong style="color: #00632F;">DATOS DEL CLIENTE</strong>
        </div>
        <br>
        <table id="noBordeTabla" style="font-family: Calibri, Candara, Segoe, 'Segoe UI', Optima, Arial, sans-serif;">
            <tr>
                <td width="45%"> <strong>Nombre del cliente:</strong></td>
                <td width="55%" class="mayuscula">{{ $cliente->nombre }}</td>
            </tr><tr>
                <td width="45%"> <strong>Whatsapp:</strong></td>
                <td width="55%">
                    <a href="https://web.whatsapp.com/send/?phone=+52{{ $cliente->telefono }}&text=Hola." target="_blank">{{ $cliente->telefono }}</a>
                </td>
            </tr><tr>
                <td width="45%"> <strong>Ingreso quincenal:</strong></td>
                <td width="55%">$ {{ number_format($cliente->ingresoquincenal, 2, '.', ',') }}</td>
            </tr>
            <tr>
                <td valign="center"> <strong>Disponible quincenal:</strong></td>
                <td valign="center">$ {{ number_format($cliente->disponiblequincenal, 2, '.', ',') }}</td>
            </tr>
            <tr>
                <td valign="center"> <strong>Ajustes por pasivos (+ -):</strong></td>
                <td valign="center">$ {{ number_format($solicitude->ajustePasivos, 2, '.', ',') }}</td>
            </tr>
            @php
                $porcentajeUsado = 0.4*10;
            @endphp
            <tr style='text-decoration: underline'>
                <td valign="center"> <strong>Total disponible:</strong></td>
                <td valign="center"><strong>$ {{ number_format((($solicitude->ajustePasivos)+($cliente->disponiblequincenal)), 2, '.', ',') }}</strong>
                    <small>
                        @for($i=0;$i<$porcentajeUsado;$i++) 
                            {{-- * --}}
                        @endfor
                    </small>
                </td>
            </tr>
            <tr style='text-decoration: underline'>
                <td valign="center"> <strong>Disponible calculado al {{ (0.4)*(100) }}%:</strong></td>
                <td valign="center"><strong>$ {{ number_format($solicitude->pagomaximo, 2, '.', ',') }}</strong>
                    <small>
                        @for($i=0;$i<$porcentajeUsado;$i++) 
                            {{-- * --}}
                        @endfor
                    </small>
                </td>
            </tr>
        </table>
        <br>
        <div class="texto-centro" style="font-family: Calibri, Candara, Segoe, 'Segoe UI', Optima, Arial, sans-serif;">
            <strong style="color: #00632F;">DATOS DEL CRÉDITO</strong>
        </div>
        <br>
        <table id="noBordeTabla" style="font-family: Calibri, Candara, Segoe, 'Segoe UI', Optima, Arial, sans-serif;">
            <tr>
                <td width="40%"><strong>Monto del crédito:</strong></td>
                <td valign="center" class="texto-grande texto-verde">$ {{ number_format($solicitude->prestamosolicitado, 2, '.', ',') }}</td>
            </tr>
            <tr>
                <td valign="center"><strong>Plazo:</strong></td>
                <td valign="center">{{ $solicitude->plazo*2 }} quincenas / {{ $solicitude->plazo }} meses</td>
            </tr>
            <tr>
                <td valign="center"><strong>Fecha inicio:</strong></td>
                <td valign="center">{{ $solicitude->fechainicio }}</td>
            </tr>
            <tr>
                <td valign="center"><strong>Descuento quincenal:</strong></td>
                <td valign="center"><strong>$ {{ number_format($solicitude->pagoplazo*2, 2, '.', ',') }}</strong></td>
            </tr>
            <tr>
                <td valign="center"><strong>{{ $solicitude->montoretenido/$solicitude->pagoplazo }} Retenciones:</strong></td>
                <td valign="center">- $ {{ number_format($solicitude->pagoplazo, 2, '.', ',') }}</td>
            </tr>
            <tr>
                <td valign="center"><strong>Cobertura de riesgo:</strong></td>
                <td valign="center">- $ {{ number_format($solicitude->coberturariesgo, 2, '.', ',') }}</td>
            </tr>
        </table>
        <br><br>
        <table id="noBordeTabla" style="font-family: Calibri, Candara, Segoe, 'Segoe UI', Optima, Arial, sans-serif;">
            <tr>
                <td valign="center"><strong>Monto total a recibir:</strong></td>
                <td valign="center" class="texto-grande texto-verde">$ {{ number_format($solicitude->montorecibido, 2, '.', ',') }}</td>
            </tr>
        </table>
        <br><br><br>
        <table id="noBordeTabla" style="font-family: Calibri, Candara, Segoe, 'Segoe UI', Optima, Arial, sans-serif;font-size: 11px;">
            <tr>
                <td width="50%" class="texto-centro">_____________________________________________</td>
                <td width="50%" class="texto-centro">_____________________________________________</td>
            </tr>
            <tr>
                <td width="50%" class="texto-centro">ASESOR DE CRÉDITO</td>
                <td width="50%" class="texto-centro">SUB-COMITÉ DE CRÉDITO</td>
            </tr>
        </table>
        <br><br><br><br><br>
        <table id="noBordeTabla" style="font-family: Calibri, Candara, Segoe, 'Segoe UI', Optima, Arial, sans-serif;font-size: 11px;">
            <tr>
                <td width="50%" class="texto-centro"> <img width="300" height="100" src="{{storage_path()."/app/public/files/".$cliente->id."/firma/firma.png"}}" alt="firma del cliente" srcset=""> </td>
            </tr>
            <tr>
                <td width="50%" class="texto-centro mayuscula subrayado">_________________{{ $cliente->nombre }}_______________</td>
            </tr>
            <tr>
                <td width="50%" class="texto-centro">NOMBRE Y FIRMA DEL CLIENTE</td>
            </tr>
        </table>
        <div style="page-break-inside:avoid;"></div>
    </body>
</html>