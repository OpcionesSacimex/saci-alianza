$('#civil-status_client-section').on('change', () =>{
  const value = $('#civil-status_client-section').val();

  if(value === 'Soltero') disableInputs();
  if(value === 'Divorciado') disableInputs();
  if(value === 'Casado') enableInputs();
  if(value === 'Unión libre') enableInputs();
});

const disableInputs = () => {
  $('#full-name_spouse-section').prop('disabled', true);
  $('#matrimonial-regime_spouse-section').prop('disabled', true);
  $('#birthdate_spouse-section').prop('disabled', true);
  $('#phone-number_spouse-section').prop('disabled', true);
  $('#comercial-activity_spouse-section').prop('disabled', true);
  $('#housing_spouse-section').prop('disabled', true);
};

const enableInputs = () => {
  $('#full-name_spouse-section').prop('disabled', false);
  $('#matrimonial-regime_spouse-section').prop('disabled', false);
  $('#birthdate_spouse-section').prop('disabled', false);
  $('#phone-number_spouse-section').prop('disabled', false);
  $('#comercial-activity_spouse-section').prop('disabled', false);
  $('#housing_spouse-section').prop('disabled', false);
};