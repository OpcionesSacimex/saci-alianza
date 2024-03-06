const emailInput = document.getElementById('email'),
      loginBoton = document.getElementById('boton-login'),
      alertaCorreo = document.getElementById('alerta-correo'),
      alertaConvenio = document.getElementById('alerta-convenio');
      inputConvenio = $('.inp-contenedor')[2];

const validarEmail = () => {
  const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

  if(emailInput.value.trim() === '') return {valido : false, error: "Complete este espacio"};

  if (!emailRegex.test(emailInput.value)) return {valido : false, error : 'Escriba un correo válido'};

  return {valido : true, error : ''};
};

const validarConvenio = () => {
  if(document.getElementById('convenio').value.trim() === '') return {valido : false, error: "Complete este espacio"};

  return {valido : true, error : ''};
};

loginBoton.addEventListener('click', ev =>{

  if(validarEmail().valido && validarConvenio().valido){
    alertaCorreo.textContent = '';
    alertaConvenio.textContent = '';
  }else {
    ev.preventDefault();
    alertaCorreo.textContent = validarEmail().error;
    alertaConvenio.textContent = validarConvenio().error;
  };
});

function quitarConveniosAdmin()
{
  let data = new FormData($('form')[0]);
  fetch('/revisarTipoUsuario', {
    method: 'POST',
    body: data
  }).then((response) => {
            return response.json();
        })
        .then((data) => {
            if(data.tipo == "Administrativo")
            {
              $('.inp-contenedor')[2].style.display='none';
              $('#convenio').val(data.convenio.toUpperCase());
            } else
            {
              $('.inp-contenedor')[2].style.display='';
            }
            console.log(data);
        }

        );
}