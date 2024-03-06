<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="{{ asset('css/input-styles.css') }}" rel="stylesheet">
    <link href="{{ asset('css/login.css') }}" rel="stylesheet">
    <script src="https://kit.fontawesome.com/56eee1d2a7.js" crossorigin="anonymous"></script>
    <link href="{{ asset('img/SacimexImagotipo.png') }}" rel="icon">
    <title>Registro</title>
    <style>
        @font-face {
            font-family: 'Presidencia Fina';
            src: url('{{asset('fonts/PresidenciaFina.otf')}}') format('opentype');
        }

        @font-face {
            font-family: 'Presidencia Firme';
            src: url('{{asset('fonts/PresidenciaFirme.otf')}}') format('opentype');
        }
    </style>
</head>
<body class="reg">
    <header>
        <div class="logo-contenedor">
            <a href="{{route('home')}}"><img src="{{ asset('img/sacimex.png') }}"></a>
        </div>
        <h2>Tu crédito de confianza.</h2>
    </header>
    <section>
    <a href="#" onclick="window.history.back()" class="kITrbH"><i class="fa-solid fa-arrow-left"></i><span>Volver</span></a>
    <form  action="{{ route('register') }}" method="POST" autocomplete="off" class="form">
        @csrf
        <h1 class="titulo">Regístrate y obtén tu pre-aprobación en minutos.</h1>
        <div class="inp-contenedor">
            <input type="text" id="email" name="email" class="inp" required>
            <label for="email" class="etq">Correo electrónico</label>
            @error('email')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
            <span class="bar"></span>
            <p id="alerta-email" class="alerta"></p>
        </div>
        <div class="inp-contenedor">
            <input type="password" id="password" name="password" class="inp" required>
            <label for="password" class="etq">Contraseña</label>
            @error('password')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
            <span class="bar"></span>
            <input id="checkbox" name="checkbox" type="checkbox" tabindex="-1">
            <label for="checkbox" class="label-checkbox"><img id="ojo" src="{{ asset('img/view.png')}}"></label>
            <p id="alerta-contrasena" class="alerta"></p>
        </div>
        <div class="inp-contenedor">
            <input type="password" id="password-confirm" name="password_confirmation" class="inp" required>
            <label for="password-confirm" class="etq">Confirmar contraseña</label>
            <span class="bar"></span>
            <p id="alerta-confirmar" class="alerta"></p>
        </div>
        @error('error')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror

        <button id="boton-registrar" type="submit"  class="btn">Registrarme</button>

        <p class="privacidad">Al dar clic en "Registrarme" aceptas los <a href="#" id="link-terminos" class="link-terminos">términos y condiciones</a> y que has leído el <a href="#" id="link-privacidad" class="link-terminos">Aviso de Privacidad de sacimex</a></p>

        <div class="lnk-contenedor">
            <p class="par">¿Ya tienes una cuenta?</p>
            <a href="{{ route('login') }}" class="lnk">Inicia sesión</a>
        </div>
    </form>
</section>
<div id="terminos" class="terminos-contenedor">
        <i id="cerrar" class="fa-sharp fa-solid fa-x cerrar-terminos"></i>
        <div class="terminos">
            <h3>OPCIONES SACIMEX, S.A. DE C.V. SOFOM E.N.R</h3>
            <h3>TÉRMINOS Y CONDICIONES</h3>
            <h4>Datos de identificación.</h4>
            <p>Esta página web es propiedad y está operado por <b>Opciones Sacimex, S.A. de C.V. SOFOM E.N.R.</b> Estos Términos establecen los términos y condiciones bajo los cuales tú puedes usar nuestra página web y servicios ofrecidos por nosotros. Al acceder o usar la página web de nuestro servicio, usted aprueba que haya leído, entendido y aceptado estar sujeto a estos Términos:</p>
            <h4>Derechos de propiedad intelectual e Industrial.</h4>
            <p>Los derechos de propiedad intelectual respecto de los Servicios y Contenidos y los signos distintivos y dominios prestados a través de, contenidos en o atingentes a, el Portal, así como los derechos de uso y explotación de los mismos, incluyendo en forma enunciativa pero no limitativa, su divulgación, modificación, transmisión, publicación, venta o comercialización, reproducción y/o distribución, son propiedad exclusiva de <b>Opciones Sacimex, S.A. de C.V. SOFOM E.N.R</b> y están protegidas por la normativa vigente en materia de propiedad intelectual. El Usuario no adquiere derecho alguno de propiedad intelectual por el simple uso de los Servicios y Contenidos del Portal y en ningún momento dicho uso será considerado como una autorización o una licencia para utilizar los Servicios y Contenidos con fines distintos a los expresamente previstos en los presentes Términos y Condiciones de Uso. En consecuencia, el Usuario EN NINGÚN CASO estará facultado para crear nuevas versiones, distribuir, exhibir o de cualquier forma explotar, cualquiera de los Contenidos desplegados a través de este Portal y que son propiedad exclusiva de <b>Opciones Sacimex, S.A. de C.V. SOFOM E.N.R</b></p>
            <h4>Usos permitidos.</h4>
            <ul>
                <li>Salvo indicación contraria en el Portal, el Usuario estará facultado para ver, imprimir, copiar y distribuir los documentos desplegados en el mismo, siempre que cumplan con las siguientes condiciones:
                    <ol>
                        <li>Que el documento sea utilizado única y exclusivamente con propósitos informativos, personales y no-comerciales</li>
                        <li>Que cualquier copia del documento o cualquier porción del mismo, incluya en forma ostensible la información relativa a los derechos de propiedad intelectual y/o industrial de los mismos, en la misma forma en que dicha información sea expresada en el documento original desplegado en el Portal, y</li>
                        <li>Que el documento no pueda ser modificado en forma alguna.</li>
                    </ol>
                </li>
                <li><b>Opciones Sacimex, S.A. de C.V. SOFOM E.N.R.</b>, se reserva el derecho de revocar la autorización a que se refiere el número anterior en cualquier tiempo, y por tanto, el uso por parte del Usuario deberá interrumpirse inmediatamente a partir del momento en que reciba la notificación correspondiente de parte de <b>Opciones Sacimex, S.A. de C.V. SOFOM E.N.R.</b></li>
                <li>El aprovechamiento de los Servicios y Contenidos ofrecidos o desplegados en el Portal, es exclusiva responsabilidad del Usuario, quien en todo caso, deberá servirse de ellos acorde a las funcionalidades permitidas en el propio Portal y a los usos autorizados en el presente Contrato, por lo que el Usuario se obliga a utilizarlos de modo tal que no atenten contra las normas de uso y convivencia en Internet, las leyes de los Estados Unidos Mexicanos y la legislación vigente en el estado en que el Usuario se encuentre al usarlos, las buenas costumbres, la dignidad de la persona y los derechos de Terceros. El Portal es para el uso personal y del Usuario por lo que en ningún caso podrá comercializar de manera alguna los Servicios y Contenidos.</li>
            </ul>
            <h4>Usos permitidos.</h4>
            <p>El Usuario en ningún caso estará facultado para:</p>
            <ul>
                <li>Utilizar el Portal para obtener información confidencial para fines distintos que el de acceder a información respecto de los Servicios, o para fines de solicitar negocios de otros Usuarios del Portal;</li>
                <li>Revender o redistribuir la información contenida en el Portal;</li>
                <li>Promover o anunciar la habilidad de proveer productos o servicios que el Usuario no tenga la intención de proveer o que sean ilícitos o prácticamente imposibles de proveer sin contar con un plazo razonable para tales efectos;</li>
                <li>Usar este Portal o cualquiera de la información disponible en el mismo, de cualquier forma, que pudiera resultar ilícita, ilegal o que constituya una violación a las leyes de México, ya sean federales, estatales o municipales.</li>
                <li>Copiar o almacenar cualquier Contenido con propósitos diferentes de los mencionados expresamente en la sección de usos permitidos que antecede, sin contar con la autorización previa y por escrito de <b>Opciones Sacimex, S.A. de C.V. SOFOM E.N.R.</b>, o en su caso, del titular de los derechos de autor de que se trate.</li>
            </ul>
            <h4>Condiciones de uso.</h4>
            <p>Para usar nuestra página web y / o recibir nuestros servicios, debes tener al menos 18 años de edad, y poseer la autoridad legal, el derecho y la libertad para participar en estos Términos como un acuerdo vinculante.</p>
            <p>El acceso a la Página Web es gratuito salvo en lo relativo al coste de la conexión a través de la red de telecomunicaciones suministrada por el proveedor de acceso contratado por el Usuario. Con carácter general, para el acceso a los servicios y contenidos de la Página Web no será necesario el Registro del Usuario. No obstante, la utilización de determinados servicios podrá estar condicionada al Registro previo del Usuario. Los datos introducidos por el Usuario deberán ser exactos, actuales y veraces en todo momento.</p>
            <p>A título enunciativo, y en ningún caso limitativo o excluyente, el Usuario se compromete a:</p>
            <ul>
                <li>Utilizar el sitio web y todo su contenido y servicios conforme a lo establecido en la ley, la moral, el orden público y en las presentes Condiciones. Asimismo, se obliga hacer un uso adecuado de los servicios y/o contenidos de este Portal y a no emplearlos para realizar actividades ilícitas o constitutivas de delito, que atenten contra los derechos de terceros y/o que infrinjan la regulación sobre propiedad intelectual e industrial, o cualesquiera otras normas del ordenamiento jurídico aplicable.</li>
                <li>No transmitir, introducir, difundir y poner a disposición de terceros, cualquier tipo de material e información (datos, contenidos, mensajes, dibujos, archivos de sonido e imagen, fotografías, software, etc.) que sean contrarios a la ley, la moral, el orden público y las presentes Condiciones.</li>
                <li>Mantener indemne a <b>Opciones Sacimex, S.A. de C.V. SOFOM E.N.R.</b> ante cualquier posible reclamación, multa, pena o sanción que pueda venir obligada a soportar como consecuencia del incumplimiento por parte del USUARIO de cualquiera de las normas de utilización antes indicadas, reservándose, además, <b>Opciones Sacimex, S.A. de C.V. SOFOM E.N.R.</b> el derecho a solicitar la indemnización por daños y perjuicios que corresponda.</li>
            </ul>
            <h4>Limitación de responsabilidad.</h4>
            <p><b>Opciones Sacimex, S.A. de C.V. SOFOM E.N.R.</b> no realiza ningún tipo de asesoramiento al Usuario en ningún ámbito, ya sea fiscal, económico, contable, mercantil o cualquier otro. Por ello, las decisiones adoptadas por el Usuario son realizadas a título personal y en este acto exime a <b>Opciones Sacimex, S.A. de C.V. SOFOM E.N.R.</b> de toda responsabilidad en la que incurra el Usuario por la obtención de los créditos.</p>
            <p><b>Opciones Sacimex, S.A. de C.V. SOFOM E.N.R.</b> no asume ningún tipo de responsabilidad por fallos en la red de internet o por el ataque al software de cualquier hacker</p>
            <p>Usted declara ser conocedor de todos los riesgos que supone la contratación de los créditos por lo que exonera a <b>Opciones Sacimex, S.A. de C.V. SOFOM E.N.R.</b> de cualquier responsabilidad por pérdidas incurridas o mal manejo o administración de recursos.</p>
            <h4>Cookies</h4>
            <p>El Usuario que tenga acceso al Portal, acuerda recibir las Cookies que sean transmitidas por los servidores de <b>Opciones Sacimex, S.A. de C.V. SOFOM E.N.R.</b> Asimismo, el Usuario reconoce expresamente que las Cookies pueden contener información relativa a la identificación proporcionada por el Usuario o información para rastrear las Páginas que el Usuario ha visitado dentro del Portal, en el entendido, sin embargo, de que una Cookie no puede leer los datos o información del disco duro del Usuario, ni leer las Cookies creadas por otros Sitios o Páginas.</p>
            <h4>Terminación.</h4>
            <p>Nos reservamos el derecho de suspender o cancelar su Cuenta en cualquier momento sin previo aviso por alguno de los siguientes motivos:</p>
            <ul>
                <li>Tenemos razones para sospechar que usted está relacionado con actividades ilícitas o ilegales o una organización prohibida por la ley vigente,</li>
                <li>Hemos tenido conocimiento de un uso no autorizado, real o potencial, de los datos de su Cuenta u otra violación de seguridad, real o potencial, o sospechamos de otro modo que haya habido algún uso no autorizado o fraudulento de su Cuenta,</li>
                <li>Se vuelve o podría volverse ilegal o violar las leyes o regulaciones vigentes el continuar permitirle usar los Servicios.</li>
                <li>El Usuario ha incumplido estos Términos, y no ha logrado subsanar dicho incumplimiento dentro de los 15 días posteriores a la recepción de nuestra notificación, o usted ya no cumple con los criterios de registro establecido en estos Términos.</li>
                <li>Estamos obligados a tomar estas medidas según establece la ley vigente o porque nos lo indica un tribunal u otro organismo de jurisdicción competente.</li>
                <li>Cualquier sospecha de actividad ilegal puede ser motivo suficiente para cancelar la Cuenta y puede remitirse a las autoridades policiales correspondientes.</li>
            </ul>
            <p>Tras la terminación de su Cuenta, dejará de utilizar los Servicios y todos los derechos que se le otorguen en virtud de estos Términos terminarán, y eliminaremos el contenido del Usuario, por lo que comprende y acepta que podemos mantener cierta información y datos de forma anónima para desarrollar aún más los Servicios (por ejemplo, estadísticas, para entrenar algoritmos de aprendizaje automático).</p>
            <h4>Vigencia y modificaciones a los términos y condiciones.</h4>
            <p>Los Términos y Condiciones entrarán en plena vigencia para cada Usuario a partir de la fecha de su registro en la Plataforma y se mantendrán vigentes, incluyendo sus modificaciones, hasta que se produzca una razón que determine su finalización de acuerdo a los propios Términos y Condiciones o por decisión del Usuario de cancelar su suscripción como tal y dejar de usar los Servicios y la Plataforma. Opciones Sacimex, S.A. de C.V. SOFOM E.N.R. se reserva el derecho de realizar en cualquier momento las modificaciones que considere pertinentes a los Términos y Condiciones o a las Servicios, así como a cualquier información incorporada a los mismos por referencia, a fin de adaptarlos a la normatividad que les resulte aplicable o a cambios en la legislación o jurisprudencia, por una obligación legal o contractual que así lo determine, sin perjuicio de también poder modificarlos al exclusivo criterio de <b>Opciones Sacimex, S.A. de C.V. SOFOM E.N.R.</b> para adaptarse a las prácticas de la industria o a conveniencias operativas.</p>
            <p>Una vez realizadas las modificaciones, <b>Opciones Sacimex, S.A. de C.V. SOFOM E.N.R.</b> enviará una notificación vía correo electrónico a los Usuarios sobre las modificaciones y su entrada en vigor. El Usuario entiende y acepta que el uso continuado del Servicio o de la Plataforma, una vez que las modificaciones a los presentes Términos y Condiciones hayan entrado en vigor, constituye la aceptación plena de su parte respecto de dichas modificaciones. En caso de que el Usuario no esté de acuerdo con las modificaciones realizadas a los Términos y Condiciones o simplemente ya no quiera estar sujeto a estos, podrá gestionar la cancelación inmediata de su registro como Usuario sin penalización alguna, siempre y cuando no se encuentre vigente en un contrato de crédito, de lo contrario tendrá que esperar el termino de dicho contrato o realizar la liquidación de su adeudo, para proceder con la cancelación de su registro. En caso de que el Usuario no cancele su registro, a la entrada en vigor de las modificaciones correspondientes, se entenderá que está de acuerdo con las mismas. Sin perjuicio de lo anterior, las obligaciones contraídas, que se encontraban vigentes al momento de notificarse la modificación de los Términos y Condiciones, continuarán vigentes y obligatorias para las partes en los términos acordados y conforme a los Términos y Condiciones vigentes al momento de su celebración.</p>
            <h4>Aceptación.</h4>
            <p>El Usuario acepta que, durante el proceso de registro como Usuario, al marcar el cuadro con el texto que establece “Registrarme”, o en su caso aceptar los textos donde se lea la palabra “Autorizo. . . “, se obligará plenamente por estos Términos y Condiciones sin salvedad u oposición alguna, entendiéndose para tales efectos que dicha aceptación constituye una firma electrónica conforme a lo dispuesto en el Código de Comercio, y tendrá los mismos efectos que la firma autógrafa.</p>
            <h4>Protección de datos personales.</h4>
            <p>Los datos proporcionados por los Usuarios de este Portal, a manera enunciativa, y en ningún caso limitativa o excluyente, como personales, patrimoniales, financieros, son protegidos por lo dispuesto en la <b>Ley Federal de Protección de Datos Personales en Posesión de Particulares</b>, siendo <b>Opciones Sacimex, S.A. de C.V. SOFOM E.N.R.</b>, responsable del tratamiento que se tenga con ellos.</p>
            <h4>Ley aplicable y Jurisdicción.</h4>
            <p>El presente Contrato se rige por las leyes mexicanas, para la interpretación, cumplimiento y ejecución del presente Contrato, las Partes se someten a los tribunales y Juzgados competentes del Estado de Oaxaca, renunciando expresamente a cualquier otro fuero que, por razón de sus domicilios, presentes o futuros, o por cualquier otra causa, pudiere corresponderles. <b>Opciones Sacimex, S.A. de C.V. SOFOM E.N.R.</b>, no realiza declaración u otorga garantía alguna en el sentido de que la información contenida en este Portal sea apropiada o disponible para ser utilizada en todos los países o jurisdicciones, y prohíbe accesar materiales desde territorios en donde los Servicios y Contenidos del Portal sean ilícitos. Aquellos Usuarios que acceden a este Portal, lo hacen por iniciativa propia y serán responsables de cumplir con las leyes aplicables en los lugares desde los cuales acceden al Portal.</p>
        </div>
    </div>
    <div id="privacidad" class="terminos-contenedor">
        <i id="cerrar-privacidad" class="fa-sharp fa-solid fa-x cerrar-terminos"></i>
        <div class="terminos">
            <h3>AVISO DE PRIVACIDAD</h3>
            <h4>¿QUIÉN ES OPCIONES SACIMEX, S.A. de C.V. SOFOM E.N.R?</h4>
            <p>Opciones Sacimex S.A. de C.V. SOFOM E.N.R., con domicilio en calle Valerio Trujano 713, Colonia Centro, Oaxaca de Juárez, Oaxaca, México C.P. 68000, y en el portal de internet <a href="https://opcionessacimex.com/" target="_blank">www.opcionessacimex.com</a>, es una empresa responsable que se encuentra regida bajo las leyes mexicanas vigentes que se encuentra constituida el 03 de Septiembre del 2008, según Instrumento Público número 4162 Volumen 50 otorgado por el Lic. José Jorge Enrique Zárate Ramírez, Notario Público N° 84 en el Estado de Oaxaca y que para efectos del Presente aviso de privacidad tiene la calidad de responsables frente a usted, como titular de datos y que en lo sucesivo se le denominará “SACIMEX”.</p>
            <p>Los datos personales que recabaremos de usted, los utilizaremos para las siguientes finalidades que son necesarias para el servicio que solicita:</p>
            <ul>
                <li>Atender su solicitud del producto que ofrece Sacimex para formalizar y complementar una relación jurídica.</li>
                <li>Verificar y confirmar su identidad.</li>
                <li>Analizar la capacidad crediticia del titular.</li>
                <li>Administrar y operar el servicio que solicita con nosotros.</li>
                <li>Elaborar estadísticas y reportes de los servicios prestados por Sacimex con el objeto de llevar un control interno de dichos servicios, así como para dar seguimiento puntual de los mismos.</li>
                <li>La atención de requerimientos de cualquier autoridad competente siempre y cuando se encuentre por escrito y fundamentado.</li>
                <li>Podrán ser para prospección comercial y/o hacer de su conocimiento de las actividades culturales, deportivas, etc., que en su momento realice Sacimex. (actividades no lucrativas de compromiso social que tenga como objetivo promover el desarrollo de las personas, a través de proyectos educativos).</li>
                <li>Utilizarlos en cualquier acto o diligencia de cobranza judicial o extrajudicial.</li>
                <li>Contactar al titular para ofrecerle productos y servicios.</li>
            </ul>
            <p>Para el caso de que no desee que sus datos personales no sean tratados para las finalidades aquí mencionadas, usted puede presentar su solicitud a través de los siguientes mecanismos:</p>
            <ul>
                <li>Mediante escrito que presente el titular en las oficinas de Sacimex a efecto de que el responsable les dé el tratamiento necesario a sus datos personales.</li>
                <li>La negativa para el uso de sus datos personales para estas finalidades no podrá ser un motivo para que le neguemos el servicio y productos que solicita o contrata con nosotros.</li>
            </ul>
            <h4>¿Qué datos personales utilizamos para los fines anteriores?</h4>
            <p>Sacimex recabará del titular los siguientes datos personales.</p>
            <ul>
                <li><b>Datos de identificación y contacto:</b> Nombre completo, dirección, teléfono de casa, celular y/o de trabajo, estado civil, firma autógrafa, correo electrónico, R.F.C., CURP, lugar y fecha de nacimiento, edad, nombre de familiares, dependientes y beneficiarios, así como sus domicilios, entre otros.</li>
                <li><b>Datos laborales:</b> ocupación, puesto, área o departamento, domicilio, teléfono y correo electrónico de trabajo, referencias laborales y referencias personales, entre otros.</li>
                <li><b>Datos financieros o patrimoniales:</b> Bienes muebles e inmuebles, historial crediticio, ingresos y egresos, servicios contratados, entre otros.</li>
                <li><b>Perfil del cliente:</b> identificación, demográficos, referencias de localización, entre otros.</li>
            </ul>
            <p>Además de los datos personales mencionados anteriormente, para las finalidades informadas en el presente aviso de privacidad utilizaremos los siguientes datos personales considerador como sensibles, que requieren especial protección: Pertenencia a un sindicato. Los datos que aquí se mencionan son recabados siempre por su consentimiento y requisitados por usted.</p>
            <h4>¿Con quién compartimos los datos personales?</h4>
            <p>Sacimex podrá compartir sus datos personales a terceros mexicanos y que se mencionan a continuación:</p>
            <ul>
                <li>Instituciones de Fuentes de Fondeo (Financiera Nacional de Desarrollo Agropecuario, Rural, Forestal y Pesquero, PRONAFIM, Banco Multiva)</li>
                <li>Comisión Nacional Bancaria y de Valores.</li>
                <li>Comisión Nacional para la Protección y Defensa de los Usuarios de Servicios Financieros.</li>
            </ul>
            <h4>¿Cómo puede acceder, rectificar o cancelar sus datos personales u oponerse a su uso?</h4>
            <ul>
                <li><b>Acceso:</b> Usted tiene derecho a conocer qué datos personales tenemos de usted, para que los utilizamos y las condiciones del uso que les damos.</li>
                <li><b>Rectificación:</b> Es su derecho solicitar la corrección de su información personal en caso de que esté desactualizada.</li>
                <li><b>Cancelación:</b> Es su derecho solicitar la eliminación en nuestros registros o base de datos cuando considere que sus datos están siendo mal utilizadas.</li>
                <li><b>Oposición:</b> Usted tiene derecho a oponerse al uso de sus datos personales para fines específicos.</li>
            </ul>
            <p>Estos derechos son conocidos como “Derechos ARCO”.</p>
            <h4>¿Cómo puedo ejercer mis derechos ARCO?</h4>
            <p>Usted o a través de su representante legal debidamente acreditado podrá acceder, rectificar o cancelar sus datos personales o bien oponerse o revocar su consentimiento para el uso de los mismos, presentando su solicitud por escrito a la Oficina de Atención para la Protección de Datos, cuya función principal será la atención de los clientes acerca de sus derechos ARCO.</p>
            <p>De lo anterior, favor de acudir a la oficina mencionada con anterioridad en un horario de lunes a viernes de 10:00 a 14:00 horas en las oficinas ubicadas en Valerio Trujano 713, Colonia Centro, Oaxaca de Juárez, Oaxaca, o al teléfono (951) 5141208, o al Correo. <a href="mailto:atencion_a_usuarios@opcionessacimex.com">atencion_a_usuarios@opcionessacimex.com</a>, quien lo atenderá con mucho gusto.</p>
            <h4>¿COMO LE INFORMAREMOS SOBRE CAMBIOS AL PRESENTE AVISO DE PRIVACIDAD?</h4>
            <p>Para el caso de modificación del presente aviso, difundirá a través de oficio pegados al interior de las oficinas de la empresa o puede realizarlo por los medios que considere convenientes para el Titular.</p>
        </div>
    </div>
</body>
<script src="{{asset('js/validarRegistro.js')}}"></script>

<script>
    checkbox.addEventListener("change", function () {
        document.getElementById('ojo').src = this.checked ? "{{ asset('img/hide.png')}}" : "{{ asset('img/view.png')}}";
        contrasenaInput.type = this.checked ? "text" : "password";
        confirmacionInput.type = this.checked ? "text" : "password";
    });
</script>
</html>
