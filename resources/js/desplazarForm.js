const formContenedor = document.getElementById('contenedor-form');
const botonDesplazarSig = document.getElementById('btn-desp-sig');
const botonDesplazarAtr = document.getElementById('btn-desp-atr');
const tituloDePasos = document.getElementById('titulo-paso');
const alertaNombre = document.getElementById('alerta-nombre');
const alertaTelefono = document.getElementById('alerta-telefono');
const alertaQuincena = document.getElementById('alerta-quincena');
const alertaDisponible = document.getElementById('alerta-disponible');
const textoMeses = document.getElementById('meses-etq');
const alertaSolicitado = document.getElementById('alerta-solicitado');

let numPaso = 1;

const colorBotonAtras = () =>{
    const scroll = formContenedor.scrollLeft;

    if(scroll === 0) botonDesplazarAtr.classList.add('oculto');
    else botonDesplazarAtr.classList.remove('oculto');
};

const desplazarAtras = () => {

    const tamanoFormContenedor = formContenedor.offsetWidth;

    formContenedor.scroll({
        left: formContenedor.scrollLeft - tamanoFormContenedor,
        behavior: 'smooth'
    });
    cambiarDePaso(-1);
    cambiarTitulo();
};

const desplazarSiguiente = () => {

    const tamanoFormContenedor = formContenedor.offsetWidth;
    const desplazamiento = Math.ceil(formContenedor.scrollLeft);

    switch(numPaso){
        case 1 :
            if(validarNombre().valido && validarTelefono().valido){
                formContenedor.scroll({
                    left: tamanoFormContenedor,
                    behavior: 'smooth'
                });                
                cambiarDePaso(1);
                cambiarTitulo();
            }else{
                alertaTelefono.textContent = validarTelefono().error;
                alertaNombre.textContent = validarNombre().error;

                setTimeout(() => {
                    alertaTelefono.textContent = "";
                    alertaNombre.textContent = "";
                }, 5000);
            };
        break;

        case 2 :
            if(validarQuincena().valido && validarDisponible().valido){
                formContenedor.scroll({
                    left: formContenedor.scrollLeft + tamanoFormContenedor,
                    behavior: 'smooth'
                });
                tituloDePasos.textContent = 'Paso 2. Ingrese sus datos personales.';
                cambiarDePaso(1);
                cambiarTitulo();
            }else{
                alertaQuincena.textContent = validarQuincena().error;
                alertaDisponible.textContent = validarDisponible().error;

                setTimeout(() => {
                    alertaQuincena.textContent = "";
                    alertaDisponible.textContent = "";
                }, 5000);
            };
        break;
        
        case 3 :
            formContenedor.scroll({
                left: 1500,
                behavior: 'smooth'
            });
    
            cambiarDePaso(1);
            cambiarTitulo();
            calcularCreditoMaximo();
        break;

        case 4 :
            if(validarPrestamoSolicitado().valido ){
                console.log('si');
            }else{
                alertaSolicitado.textContent = validarPrestamoSolicitado().error;

                setTimeout(() => {
                    alertaSolicitado.textContent = "";
                }, 5000);
            };
        break;
    };
};

const cambiarTitulo = () => {
    switch(numPaso){
        case 1 : tituloDePasos.textContent = 'Paso 1. Ingrese sus datos personales.';
        break;
        case 2 : tituloDePasos.textContent = 'Paso 2. Ingrese sus datos financieros.';
        break;
        case 3 : tituloDePasos.textContent = 'Paso 3. Seleccione sus preferencias.';
        break;
        case 4 : tituloDePasos.textContent = 'Paso 4. Escriba el monto deseado.';
        break;
    }
};

const cambiarDePaso = paso => {

    if(numPaso === 1 && paso < 0) numPaso = 1;
    else if(numPaso === 4 && paso > 0) numPaso = 4;
    else numPaso += paso;
};

botonDesplazarAtr.addEventListener('click', desplazarAtras);

botonDesplazarSig.addEventListener('click', desplazarSiguiente);

formContenedor.addEventListener('scroll', () => {
    colorBotonAtras();
});