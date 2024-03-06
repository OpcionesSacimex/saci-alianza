const inputNombre = document.getElementById('nombre');
const inputTelefono = document.getElementById('telefono');
const inputCreditoMaximo = document.getElementById('credito-maximo');
const inputPrestamoSolicitado = document.getElementById('prestamo-solicitado');

const validarNombre = () => {
    let regex = /^[a-zA-Z\s]+$/;

    if(inputNombre.value.trim() === '') return {valido: false, error: "Debe rellenar este espacio."};

    if(inputNombre.value.length < 8) return {valido: false, error: "El nombre debe contener al menos 8 caracteres."};

    if(!regex.test(inputNombre.value)) return {valido: false, error: "El nombre sólo puede contener letras y espacios."};
    
    return {valido: true, error: ""};
};

const validarTelefono = () => {
    let regex = /^\d+$/;

    if(inputTelefono.value.trim() === '') return {valido: false, error: "Complete este espacio."};

    if(!regex.test(inputTelefono.value)) return {valido: false, error: "El teléfono sólo puede contener números."};

    if(inputTelefono.value.length !== 10) return {valido: false, error: "El teléfono debe contener 10 dígitos."};

    return {valido: true, error: ""};
};

const validarQuincena = () => {
    let regex = /^\d+$/;

    if(inputTotalQuincena.value.trim() === '') return {valido: false, error: "Complete este espacio."};

    if(!regex.test(inputTotalQuincena.value)) return {valido: false, error: "Este campo sólo puede contener números."};

    if(inputTotalQuincena.value.length < 2) return {valido: false, error: "La cifra debe contener al menos 2 dígitos."};

    return {valido: true, error: ""};
};

const validarDisponible = () => {
    const quincena = parseInt(inputTotalQuincena.value);
    const disponible = parseInt(inputMontoDisponible.value);

    let regex = /^\d+$/;

    if(inputMontoDisponible.value.trim() === '') return {valido: false, error: "Complete este espacio."};

    if(!regex.test(inputMontoDisponible.value)) return {valido: false, error: "Este campo sólo puede contener números."};

    if(inputMontoDisponible.value.length < 2) return {valido: false, error: "La cifra debe contener al menos 2 dígitos."};

    if(disponible > quincena) return {valido: false, error: `Según los datos. El monto no puede ser mayor a $ ${quincena}.00`};

    return {valido: true, error: ""};
};

const validarPrestamoSolicitado = () => {
    const creditoMaximo = parseInt(inputCreditoMaximo.value);
    const prestamoSolicitado = parseInt(inputPrestamoSolicitado.value);

    let regex = /^\d+$/;

    if(inputPrestamoSolicitado.value.trim() === '') return {valido: false, error: "Complete este espacio."};

    if(!regex.test(inputPrestamoSolicitado.value)) return {valido: false, error: "Este campo sólo puede contener números."};

    if(inputPrestamoSolicitado.value.length < 3) return {valido: false, error: "La cifra debe contener al menos 3 dígitos."};

    if(prestamoSolicitado > creditoMaximo) return {valido: false, error: `El monto no puede ser mayor a $ ${creditoMaximo}.00`};

    return {valido: true, error: ""};
};

inputTelefono.addEventListener('input', () => {
    const maxLength = parseInt(inputTelefono.getAttribute('maxlength'));
    if (inputTelefono.value.length > maxLength) {
        inputTelefono.value = inputTelefono.value.slice(0, maxLength);
    }
});