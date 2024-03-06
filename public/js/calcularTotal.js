const inputDiasMes = document.getElementById('días-mes');
const botonMasDias = document.getElementById('boton-mas-dias');
const botonMenosDias = document.getElementById('boton-menos-dias');
const montoMinimo = document.getElementById("montoMinimo").innerText;
let tasaReal = parseFloat(document.getElementById("tasa").innerText);
tasaReal = (tasaReal/12)/100;
//console.log(tasaReal);
const tasa = tasaReal;
const iva = 1.16;
const maximoPermitido = parseFloat(document.getElementById("montoMaximo").innerText);
const tasaIva = tasa * iva;

const calcularCreditoMaximo = () => {
    var meses = parseFloat(inputMeses.value);
    const pagoQuincenal = parseFloat(inputNumberRange.value);
    const pagoMensual = pagoQuincenal * 2;
    const potencia = Math.pow(1 + tasaIva, meses);
    const va = parseInt(pagoMensual * ((potencia - 1) / (tasaIva * potencia)));
    if(va<parseFloat(montoMinimo))
    {
        meses +=1;
        inputMeses.value=meses;
        //calcularPlazoMinimo(plazoMinimo.innerText);
        document.getElementById('number-meses').value=meses;
        //plazoMinimo.innerText=meses;

        calcularCreditoMaximo();
    }else{
        //plazoMinimo.innerText=plazoMinimoVal;
    }
    calcularPlazoMinimo(plazoMinimo.innerText);
    //plazoMinimo.innerText=plazoMinimoVal;

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

function restarMes()
{
    var meses = parseFloat(inputMeses.value)-1;
    const pagoQuincenal = parseFloat(inputNumberRange.value);
    const pagoMensual = pagoQuincenal * 2;
    const potencia = Math.pow(1 + tasaIva, meses);
    const va = parseInt(pagoMensual * ((potencia - 1) / (tasaIva * potencia)));
    if(va<parseFloat(montoMinimo)||meses<plazoMinimo.innerText)
    {
        return false;
    }
    return true;
}

botonMasDias.addEventListener('mousedown', () => manejarMouseDown(sumarDias));
botonMasDias.addEventListener('mouseup', manejarMouseUp);
botonMasDias.addEventListener('mouseleave', manejarMouseUp);
botonMenosDias.addEventListener('mousedown', () => manejarMouseDown(restarDias));
botonMenosDias.addEventListener('mouseup', manejarMouseUp);
botonMenosDias.addEventListener('mouseleave', manejarMouseUp);