//const inputTotalQuincena = document.getElementById('ingresoquincenal');
//const inputMontoDisponible = document.getElementById('disponiblequincenal');
const inputPagoMaximo = document.getElementById('pagomaximo');
const inputPagoMinimo = document.getElementById('pagominimo');
const inputRange = document.getElementById('range');
const inputNumberRange = document.getElementById('pagodeseado');
const botonMas = document.getElementById('boton-mas');
const botonMenos = document.getElementById('boton-menos');
const inputMeses = document.getElementById('range-meses');
const mesesNumero = document.getElementById('number-meses');
const plazoMinimo = document.getElementById('plazoMinimo');
const plazoMaximo = document.getElementById('plazoMaximo');
const plazoMinimoVal = document.getElementById('plazoMinimo').innerText;
const inputAjustes = $('#ajustePasivos');

var intervaloID;

const calcularMaximo = (min, max) => {

    while(min <= max){
        min += 50;
    };

    min -= 50;

    return min;
};

const calcularMontos = (disponible) => {
    let ajustes = (inputAjustes.val()=='')?0:inputAjustes.val();
    const pagoMinimo = Math.trunc((disponible + parseFloat(ajustes )) * .1);
    const minimoRedondeado = Math.ceil(pagoMinimo/10) * 10;
    const pagoMaximo = Math.trunc((disponible + parseFloat(ajustes )) * .4);
    
    inputPagoMinimo.value = pagoMinimo;
    inputPagoMaximo.value = pagoMaximo;
    inputRange.min = minimoRedondeado;
    inputRange.max = calcularMaximo(minimoRedondeado, pagoMaximo);
    inputRange.value = (parseInt(inputRange.max) + parseInt(inputRange.min)) / 2;
    inputNumberRange.value = inputRange.value;
    
};

const actualizarMontos = () => {

    console.log("Se estan actualizando los valores de monto minimo y monto maximo");
    const quincena = parseInt(inputTotalQuincena.value);
    const disponible = parseInt(inputMontoDisponible.value);

    if(quincena && disponible){

        if(quincena >= disponible){
            alertaDisponible.textContent = '';

            calcularMontos(disponible);
        };

        if(quincena < disponible){
            alertaDisponible.textContent = `Según los datos. El monto no puede ser mayor a $ ${quincena}.00`;
        };
    };
};

if(inputTotalQuincena.value!==""&&inputMontoDisponible.value!=="")
{
    actualizarMontos();
    //actualizarValores();
}

const actualizarValores = () => {
    inputNumberRange.value = inputRange.value;
    calcularCreditoMaximo();
};

const actualizarMeses = () => {
    mesesNumero.value = inputMeses.value;
    
};

const sumar = () => {
    if((parseInt(inputMeses.value) < plazoMaximo.innerText)&&verificarFechaTermino(parseInt(inputMeses.value))) inputMeses.value++;

    if((parseInt((inputMeses.value) === plazoMaximo.innerText)) || !verificarFechaTermino(parseInt(inputMeses.value)+1)) botonMas.classList.add('gris');
    if(parseInt(inputMeses.value) !== plazoMinimo.innerText) botonMenos.classList.remove('gris');
};

const restar = () => {
    calcularCreditoMaximo();
    //if(parseInt(inputMeses.value) > plazoMinimo.innerText) inputMeses.value--;
    if (restarMes()) inputMeses.value--;

    if(parseInt(inputMeses.value) === plazoMinimo.innerText) botonMenos.classList.add('gris');
    if(parseInt(inputMeses.value) !== plazoMaximo.innerText) botonMas.classList.remove('gris');
};

const manejarMouseDown = callback => {
    callback();

    intervaloID = setInterval(callback, 200);
};

const manejarMouseUp = () => {
    clearInterval(intervaloID);
};


//botonMas.addEventListener('mousedown', () => manejarMouseDown(sumar));
//botonMas.addEventListener('mouseup', manejarMouseUp);
inputMeses.addEventListener('input',actualizarMeses);
//botonMas.addEventListener('mouseleave', manejarMouseUp);
/*
botonMenos.addEventListener('mousedown', () => manejarMouseDown(restar));
botonMenos.addEventListener('mouseup', manejarMouseUp);
botonMenos.addEventListener('mouseleave', manejarMouseUp);
*/
inputTotalQuincena.addEventListener('change', actualizarMontos);
inputMontoDisponible.addEventListener('change', actualizarMontos);
inputRange.addEventListener('input', actualizarValores);


function verificarFechaTermino(meses)
{
    let fechaTermino = new Date(document.getElementById('fechaTermino').innerText+" ");
    //let meses = parseInt(inputMeses.value);
    let fechaActual = new Date();
    let fechaTentativa = new Date(fechaActual.setMonth(fechaActual.getMonth()+meses));
    if(fechaTentativa>fechaTermino) return false;
    return true;
}

function calcularPlazoMinimo(plazo)
{
    plazo = parseFloat(plazo);
    const pagoQuincenal = parseFloat(inputNumberRange.value);
    const pagoMensual = pagoQuincenal * 2;
    const potencia = Math.pow(1 + tasaIva, plazo);
    const va = parseInt(pagoMensual * ((potencia - 1) / (tasaIva * potencia)));
    if(va<parseFloat(montoMinimo))
    {
        plazo++;
        calcularPlazoMinimo(plazo);
    }else
    {
        inputMeses.min=plazo;
        return plazo;
    }
}