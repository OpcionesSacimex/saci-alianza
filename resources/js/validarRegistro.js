const emailInput = document.getElementById('email');
const contrasenaInput = document.getElementById('password');
const confirmacionInput = document.getElementById('confirmar');
const alertaEmail = document.getElementById('alerta-email');
const alertaContrasena = document.getElementById('alerta-contrasena');
const alertaConfirmacion = document.getElementById('alerta-confirmar');
const botonRegistrar = document.getElementById('boton-registrar');
const checkbox = document.getElementById('checkbox');
const ojoImagen = document.getElementById('ojo');

const validarEmail = () => {
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
  
    if(emailInput.value.trim() === '') return {valido : false, error: "Complete este espacio"};
  
    if(!emailRegex.test(emailInput.value)) return {valido : false, error : 'Escriba un correo válido'};
  
    return {valido : true, error : ''};
};

const validarContrasena = () => {
    const regexMinuscula = /[a-z]/;
    const regexMayuscula = /[A-Z]/;
    const regexNumero = /\d/;

    if(contrasenaInput.value.trim() === '') return {valido : false, error: 'Complete este espacio'};

    if(!regexMinuscula.test(contrasenaInput.value)) return {valido : false, error : 'La contraseña debe contener al menos una minúscula.'};
  
    if(!regexMayuscula.test(contrasenaInput.value)) return {valido : false, error : 'La contraseña debe contener al menos una mayúscula.'};

    if(!regexNumero.test(contrasenaInput.value)) return {valido : false, error : 'La contraseña debe contener al menos un número.'};

    if(contrasenaInput.value.length < 8) return {valido : false, error: 'La contraseña debe contener al menos un 8 caracteres.'};

    return {valido : true, error : ''};
};

const validarConfirmacion = () => {
    if(confirmacionInput.value !== contrasenaInput.value) return {valido :  false, error : 'Las contraseñas no coinciden.'};

    return {valido : true, error : ''};
};

botonRegistrar.addEventListener('click', ev =>{

    if(validarEmail().valido && validarContrasena.valido && validarConfirmacion.valido){
      alertaEmail.textContent = '';
      alertaConvenio.textContent = '';
    }else {
      ev.preventDefault();
      alertaEmail.textContent = validarEmail().error;
      alertaContrasena.textContent = validarContrasena().error;
      alertaConfirmacion.textContent = validarConfirmacion().error;
    };
});

confirmacionInput.addEventListener('input', () => {
    alertaConfirmacion.textContent = validarConfirmacion().error;
});

checkbox.addEventListener("change", function () {
    ojoImagen.src = this.checked ? "hide.png" : "view.png";
    contrasenaInput.type = this.checked ? "text" : "password";
    confirmacionInput.type = this.checked ? "text" : "password";
});