$('#session-button').on('click', () => {
  if($('#session-options').attr('class') === 'lmhoLI'){
    $('#session-options').addClass('ERysiV');
    $('#session-options').removeClass('lmhoLI');
    $('#close-menu').addClass('ArdYlu');
    $('#close-menu').removeClass('tereIN');
  } else {
    $('#session-options').removeClass('ERysiV');
    $('#session-options').addClass('lmhoLI');
    $('#close-menu').removeClass('ArdYlu');
    $('#close-menu').addClass('tereIN');
  };
});

$('#close-menu').on('click', () => {
  $('#session-options').removeClass('ERysiV');
  $('#session-options').addClass('lmhoLI');
  $('#close-menu').removeClass('ArdYlu');
  $('#close-menu').addClass('tereIN');
});