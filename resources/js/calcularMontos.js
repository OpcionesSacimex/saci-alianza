const inputTotalQuincena = document.getElementById('quincena');
const inputMontoDisponible = document.getElementById('disponible');
const inputPagoMaximo = document.getElementById('pago-maximo');
const inputPagoMinimo = document.getElementById('pago-minimo');
const inputRange = document.getElementById('range');
const inputNumberRange = document.getElementById('number-range');
const inputRangeMeses = document.getElementById('range-meses');
const inputNumberMeses = document.getElementById('number-meses');

var intervaloID;

const calcularMaximo = (min, max) => {

    while(min <= max){
        min += 50;
    };

    min -= 50;

    return min;
};

const calcularMontos = (disponible) => {
    const pagoMinimo = Math.trunc(disponible * .1);
    const minimoRedondeado = Math.ceil(pagoMinimo/10) * 10;
    const pagoMaximo = Math.trunc(disponible * .4);
    
    inputPagoMinimo.value = pagoMinimo;
    inputPagoMaximo.value = pagoMaximo;
    inputRange.min = minimoRedondeado;
    inputRange.max = calcularMaximo(minimoRedondeado, pagoMaximo);
    inputRange.value = (parseInt(inputRange.max) + parseInt(inputRange.min)) / 2;
    inputNumberRange.value = inputRange.value;
};

const actualizarMontos = () => {

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

const actualizarValores = () => {
    inputNumberRange.value = inputRange.value;
};

const actualizarValoresMeses = () => {
    inputNumberMeses.value = inputRangeMeses.value;
};

inputTotalQuincena.addEventListener('keyup', actualizarMontos);
inputMontoDisponible.addEventListener('keyup', actualizarMontos);
inputRange.addEventListener('input', actualizarValores);
inputRangeMeses.addEventListener('input', actualizarValoresMeses);