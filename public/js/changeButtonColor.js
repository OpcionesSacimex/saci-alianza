const changeButtonColor = () => {
  const buttons = document.querySelectorAll('.menu-button');

  buttons.forEach(button => {
    button.addEventListener('click', ev => {            
      buttons.forEach(b => {
        b.classList.remove('JDDzRY');
        b.classList.add('LicxeC');
      });

      ev.target.classList.add('JDDzRY');
      ev.target.classList.remove('LicxeC');

      changeSection(ev.target);
    });
  });
};