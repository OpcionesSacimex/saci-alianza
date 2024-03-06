const emailInput = document.getElementById('email'),
      contrasenaInput = document.getElementById('password'),
      confirmacionInput = document.getElementById('password-confirm'),
      alertaEmail = document.getElementById('alerta-email'),
      alertaConfirmacion = document.getElementById('alerta-confirmar'),
      checkbox = document.getElementById('checkbox'),
      terminosContenedor = document.getElementById('terminos'),
      privacidadContenedor = document.getElementById('privacidad');

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

document.getElementById('boton-registrar').addEventListener('click', ev =>{

  if(validarEmail().valido && validarContrasena().valido && validarConfirmacion().valido){
    alertaEmail.textContent = '';
    alertaConvenio.textContent = '';
  }else {
    ev.preventDefault();
    alertaEmail.textContent = validarEmail().error;
    document.getElementById('alerta-contrasena').textContent = validarContrasena().error;
    alertaConfirmacion.textContent = validarConfirmacion().error;
  };
});

confirmacionInput.addEventListener('input', () => alertaConfirmacion.textContent = validarConfirmacion().error);

document.getElementById('link-terminos').addEventListener('click', () => terminosContenedor.classList.add('mostrar'));

terminosContenedor.addEventListener('click', () => terminosContenedor.classList.remove('mostrar'));

document.getElementById('cerrar').addEventListener('click', () => terminosContenedor.classList.remove('mostrar'));

document.getElementById('link-privacidad').addEventListener('click', () => privacidadContenedor.classList.add('mostrar'));

privacidadContenedor.addEventListener('click', () => privacidadContenedor.classList.remove('mostrar'));

document.getElementById('cerrar-privacidad').addEventListener('click', () => privacidadContenedor.classList.remove('mostrar')); 