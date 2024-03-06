const changeSection = ele => {
  $('#client-section').removeClass('IMaNtA');
  $('#labor-section').removeClass('IMaNtA');
  $('#spouse-section').removeClass('IMaNtA');
  $('#references-section').removeClass('LIciDE');
  $('#pld-section').removeClass('IMaNtA');

  $('#client-section').addClass('meNtIC');
  $('#labor-section').addClass('meNtIC');
  $('#spouse-section').addClass('meNtIC');
  $('#references-section').addClass('DIONfu');
  $('#pld-section').addClass('meNtIC');
          
  switch(ele.id){
    case 'menu-button-1': 
      $('#client-section').addClass('IMaNtA');
      $('#client-section').removeClass('meNtIC');
    break;
    case 'menu-button-2': 
      $('#labor-section').addClass('IMaNtA');
      $('#labor-section').removeClass('meNtIC');
    break;
    case 'menu-button-3': 
      $('#spouse-section').addClass('IMaNtA');
      $('#spouse-section').removeClass('meNtIC');
    break;
    case 'menu-button-4': 
      $('#references-section').addClass('LIciDE');
      $('#references-section').removeClass('DIONfu');
    break;
    case 'menu-button-5': 
      $('#pld-section').addClass('IMaNtA');
      $('#pld-section').removeClass('meNtIC');
    break;
  };
};

const changeClientToLabor = ev => {
  ev.preventDefault();
  $('#client-section').removeClass('IMaNtA');
  $('#labor-section').removeClass('meNtIC');
  $('#client-section').addClass('meNtIC');
  $('#labor-section').addClass('IMaNtA');
  $('#menu-button-1').removeClass('JDDzRY');
  $('#menu-button-2').removeClass('LicxeC');
  $('#menu-button-1').addClass('LicxeC');
  $('#menu-button-2').addClass('JDDzRY');
};

const changeLaborToSpouse = ev => {
  ev.preventDefault();
  $('#labor-section').removeClass('IMaNtA');
  $('#spouse-section').removeClass('meNtIC');
  $('#labor-section').addClass('meNtIC');
  $('#spouse-section').addClass('IMaNtA');
  $('#menu-button-2').removeClass('JDDzRY');
  $('#menu-button-3').removeClass('LicxeC');
  $('#menu-button-2').addClass('LicxeC');
  $('#menu-button-3').addClass('JDDzRY');
};

const changeSpouseToReferences = ev => {
  ev.preventDefault();
  $('#spouse-section').removeClass('IMaNtA');
  $('#references-section').removeClass('DIONfu');
  $('#spouse-section').addClass('meNtIC');
  $('#references-section').addClass('LIciDE');
  $('#menu-button-3').removeClass('JDDzRY');
  $('#menu-button-4').removeClass('LicxeC');
  $('#menu-button-3').addClass('LicxeC');
  $('#menu-button-4').addClass('JDDzRY');
};

const changeReferencesToPLD = ev => {
  ev.preventDefault();
  $('#references-section').removeClass('LIciDE');
  $('#pld-section').removeClass('meNtIC');
  $('#references-section').addClass('DIONfu');
  $('#pld-section').addClass('IMaNtA');
  $('#menu-button-4').removeClass('JDDzRY');
  $('#menu-button-5').removeClass('LicxeC');
  $('#menu-button-4').addClass('LicxeC');
  $('#menu-button-5').addClass('JDDzRY');
};

$('#next-button_client-section').on('click', ev => changeClientToLabor(ev));
$('#next-button_labor-section').on('click', ev => changeLaborToSpouse(ev));
$('#next-button_spouse-section').on('click', ev => changeSpouseToReferences(ev));
$('#next-button_references-section').on('click', ev => changeReferencesToPLD(ev));