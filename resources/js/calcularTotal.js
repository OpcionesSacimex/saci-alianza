const inputDiasMes = document.getElementById('días-mes');
const botonMasDias = document.getElementById('boton-mas-dias');
const botonMenosDias = document.getElementById('boton-menos-dias');

const tasa = 0.022;
const iva = 1.16;
const maximoPermitido = 150000;
const tasaIva = tasa * iva;

const calcularCreditoMaximo = () => {
    const meses = parseFloat(inputNumberMeses.value);
    const pagoQuincenal = parseFloat(inputNumberRange.value);
    const pagoMensual = pagoQuincenal * 2;
    const potencia = Math.pow(1 + tasaIva, meses);
    const va = parseInt(pagoMensual * ((potencia - 1) / (tasaIva * potencia)));

    if (va > maximoPermitido){
        va = maximoPermitido;
    };

    inputCreditoMaximo.value = va;
};

const sumarDias = () => {
    if(parseInt(inputDiasMes.value) < 30) inputDiasMes.value++;

    if(parseInt(inputDiasMes.value) === 30) botonMasDias.classList.add('gris');
    if(parseInt(inputDiasMes.value) !== 1) botonMenosDias.classList.remove('gris');
};

const restarDias = () => {
    if(parseInt(inputDiasMes.value) > 1) inputDiasMes.value--;

    if(parseInt(inputDiasMes.value) === 1) botonMenosDias.classList.add('gris');
    if(parseInt(inputDiasMes.value) !== 30) botonMasDias.classList.remove('gris');
};

botonMasDias.addEventListener('mousedown', () => manejarMouseDown(sumarDias));
botonMasDias.addEventListener('mouseup', manejarMouseUp);
botonMasDias.addEventListener('mouseleave', manejarMouseUp);
botonMenosDias.addEventListener('mousedown', () => manejarMouseDown(restarDias));
botonMenosDias.addEventListener('mouseup', manejarMouseUp);
botonMenosDias.addEventListener('mouseleave', manejarMouseUp);