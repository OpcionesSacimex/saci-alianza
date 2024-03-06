const verifyClientSection = () => {
  if($('#name_client-section').val().trim() === '') return false;
  if($('#lastname_client-section').val().trim() === '') return false;
  if($('#birthdate_client-section').val().trim() === '') return false;
  if($('#entity-birth_client-section').val().trim() === '') return false;
  if(!($('#gender-f_client-section').is(':checked') || $('#gender-m_client-section').is(':checked'))) return false;
  if($('#age_client-section').val().trim() === '') return false;
  if($('#street_client-section').val().trim() === '') return false;
  if($('#outdoor-number_client-section').val().trim() === '') return false;
  if($('#colony_client-section').val().trim() === '') return false;
  if($('#municipality_client-section').val().trim() === '') return false;
  if($('#phone-number_client-section').val().trim() === '') return false;
  if($('#email_client-section').val().trim() === '') return false;

  return true;
};

const verifyLaborSection = () => {
  if($('#occupation_labor-section').val().trim() === '') return false;
  if(!($('#contract-confianza_labor-section').is(':checked') || $('#contract-base_labor-section').is(':checked'))) return false;
  if($('#contract-age_labor-section').val().trim() === '') return false;
  if($('#workplace_labor-section').val().trim() === '') return false;
  if($('#adress_labor-section').val().trim() === '') return false;

  return true;
};

const verifySpouseSection = () => {
  const value = $('#civil-status_client-section').val();

  if(value === 'Soltero' || value === 'Divorciado') {
    $('#full-name_spouse-section').val('');
    $('#birthdate_spouse-section').val('');
    $('#phone-number_spouse-section').val('');
    $('#comercial-activity_spouse-section').val('');

    if($('#home-value_spouse-section').val().trim() === '') return false;
    if($('#economic-dependents_spouse-section').val().trim() === '') return false;

    return true;
  };

  if(value === 'Casado' || value === 'Unión libre'){
    if($('#full-name_spouse-section').val().trim() === '') return false;
    if($('#birthdate_spouse-section').val().trim() === '') return false;
    if($('#phone-number_spouse-section').val().trim() === '') return false;
    if($('#comercial-activity_spouse-section').val().trim() === '') return false;
    if($('#home-value_spouse-section').val().trim() === '') return false;
    if($('#economic-dependents_spouse-section').val().trim() === '') return false;

    return true;
  };
};

const verifyReferencesSection = () => {
  if($('#full-name_reference-1_references-section').val().trim() === '') return false;
  if($('#adress_reference-1_references-section').val().trim() === '') return false;
  if($('#phone-number_reference-1_references-section').val().trim() === '') return false;
  if($('#relationship_reference-1_references-section').val().trim() === '') return false;
  if($('#full-name_reference-2_references-section').val().trim() === '') return false;
  if($('#adress_reference-2_references-section').val().trim() === '') return false;
  if($('#phone-number_reference-2_references-section').val().trim() === '') return false;
  if($('#relationship_reference-2_references-section').val().trim() === '') return false;
  if($('#full-name_beneficiary_references-section').val().trim() === '') return false;
  if($('#birthdate_beneficiary_references-section').val().trim() === '') return false;
  if($('#project_beneficiary_references-section').val().trim() === '') return false;
  if($('#amount_beneficiary_references-section').val().trim() === '') return false;
  if($('#term_beneficiary_references-section').val().trim() === '') return false;
  if($('#salary_beneficiary_references-section').val().trim() === '') return false;
  if($('#bills_beneficiary_references-section').val().trim() === '') return false;

  return true;
};

const verifyPLDSection = () => {
  if(!($('#pld-1-si_pld-section').is(':checked') || $('#pld-1-no_pld-section').is(':checked'))) return false;
  if(!($('#pld-2-si_pld-section').is(':checked') || $('#pld-2-no_pld-section').is(':checked'))) return false;
  if(!($('#pld-3-si_pld-section').is(':checked') || $('#pld-3-no_pld-section').is(':checked'))) return false;
  if(!($('#pld-4-si_pld-section').is(':checked') || $('#pld-4-no_pld-section').is(':checked'))) return false;
  if(!($('#pld-5-si_pld-section').is(':checked') || $('#pld-5-no_pld-section').is(':checked'))) return false;
  if($('#pld-4-si_pld-section').is(':checked')){
    if($('#pld-4-text_pld-section').val().trim() === '') return false;
  };
  if($('#pld-5-si_pld-section').is(':checked')){
    if($('#pld-5-text_pld-section').val().trim() === '') return false;
  };

  return true;
};

const verifyAllSections = () => {
  if(!verifyClientSection()) return false;
  if(!verifyLaborSection()) return false;
  if(!verifySpouseSection()) return false;
  if(!verifyReferencesSection()) return false;
  if(!verifyPLDSection()) return false;

  return true;
};


const showButtonClientSection = () => {
  if( verifyClientSection() ){
    $('#next-button_client-section').addClass('ISHIpl');
    $('#next-button_client-section').removeClass('XiNesP');
  } else {
    $('#next-button_client-section').removeClass('ISHIpl');
    $('#next-button_client-section').addClass('XiNesP');
  };
};

const showButtonLaborSection = () => {
  if( verifyLaborSection() ){
    $('#next-button_labor-section').addClass('ISHIpl');
    $('#next-button_labor-section').removeClass('XiNesP');
  } else {
    $('#next-button_labor-section').removeClass('ISHIpl');
    $('#next-button_labor-section').addClass('XiNesP');
  };
};

const showButtonSpouseSection = () => {
  if( verifySpouseSection() ){
    $('#next-button_spouse-section').addClass('ISHIpl');
    $('#next-button_spouse-section').removeClass('XiNesP');
  } else {
    $('#next-button_spouse-section').removeClass('ISHIpl');
    $('#next-button_spouse-section').addClass('XiNesP');
  };
};

const showButtonReferencesSection = () => {
  if( verifyReferencesSection() ){
    $('#next-button_references-section').addClass('ISHIpl');
    $('#next-button_references-section').removeClass('XiNesP');
  } else {
    $('#next-button_references-section').removeClass('ISHIpl');
    $('#next-button_references-section').addClass('XiNesP');
  };
};

const showButtonSend = () => {
  if( verifyAllSections() ){
    $('#send-button').addClass('ISHIpl');
    $('#send-button').removeClass('XiNesP');
  } else {
    $('#send-button').removeClass('ISHIpl');
    $('#send-button').addClass('XiNesP');
  };
};

const handleInputsClientSection = () => {
  $('#name_client-section').on('input', () => {showButtonClientSection(); showButtonSend();});
  $('#lastname_client-section').on('input', () => {showButtonClientSection(); showButtonSend();});
  $('#birthdate_client-section').on('change', () => {showButtonClientSection(); showButtonSend();});
  $('#entity-birt_client-section').on('input', () => {showButtonClientSection(); showButtonSend();});
  $('#gender-f_client-section').on('change', () => {showButtonClientSection(); showButtonSend();});
  $('#gender-m_client-section').on('change', () => {showButtonClientSection(); showButtonSend();});
  $('#age_client-section').on('input', () => {showButtonClientSection(); showButtonSend();});
  $('#street_client-section').on('input', () => {showButtonClientSection(); showButtonSend();});
  $('#outdoor-number_client-section').on('input', () => {showButtonClientSection(); showButtonSend();});
  $('#colony_client-section').on('input', () => {showButtonClientSection(); showButtonSend();});
  $('#municipality_client-section').on('input', () => {showButtonClientSection(); showButtonSend();});
  $('#phone-number_client-section').on('input', () => {showButtonClientSection(); showButtonSend();});
  $('#email_client-section').on('input', () => {showButtonClientSection(); showButtonSend();});
  $('#civil-status_client-section').on('input', () => {showButtonSpouseSection(); showButtonSend();});
};

const handleInputsLaborSection = () => {
  $('#occupation_labor-section').on('input', () => {showButtonLaborSection(); showButtonSend();});
  $('#contract-confianza_labor-section').on('change', () => {showButtonLaborSection(); showButtonSend();});
  $('#contract-base_labor-section').on('change', () => {showButtonLaborSection(); showButtonSend();});
  $('#contract-age_labor-section').on('input', () => {showButtonLaborSection(); showButtonSend();});
  $('#workplace_labor-section').on('input', () => {showButtonLaborSection(); showButtonSend();});
  $('#adress_labor-section').on('input', () => {showButtonLaborSection(); showButtonSend();});
};

const handleInputsSpouseSection = () => {
  $('#full-name_spouse-section').on('input', () => {showButtonSpouseSection(); showButtonSend();});
  $('#birthdate_spouse-section').on('change', () => {showButtonSpouseSection(); showButtonSend();});
  $('#phone-number_spouse-section').on('input', () => {showButtonSpouseSection(); showButtonSend();});
  $('#comercial-activity_spouse-section').on('input', () => {showButtonSpouseSection(); showButtonSend();});
  $('#home-value_spouse-section').on('input', () => {showButtonSpouseSection(); showButtonSend();});
  $('#economic-dependents_spouse-section').on('input', () => {showButtonSpouseSection(); showButtonSend();});
};

const handleInputsReferencesSection = () => {
  $('#full-name_reference-1_references-section').on('input', () => {showButtonReferencesSection(); showButtonSend();});
  $('#adress_reference-1_references-section').on('input', () => {showButtonReferencesSection(); showButtonSend();});
  $('#phone-number_reference-1_references-section').on('input', () => {showButtonReferencesSection(); showButtonSend();});
  $('#relationship_reference-1_references-section').on('input', () => {showButtonReferencesSection(); showButtonSend();});
  $('#full-name_reference-2_references-section').on('input', () => {showButtonReferencesSection(); showButtonSend();});
  $('#adress_reference-2_references-section').on('input', () => {showButtonReferencesSection(); showButtonSend();});
  $('#phone-number_reference-2_references-section').on('input', () => {showButtonReferencesSection(); showButtonSend();});
  $('#relationship_reference-2_references-section').on('input', () => {showButtonReferencesSection(); showButtonSend();});
  $('#full-name_beneficiary_references-section').on('input', () => {showButtonReferencesSection(); showButtonSend();});
  $('#birthdate_beneficiary_references-section').on('change', () => {showButtonReferencesSection(); showButtonSend();});
  $('#project_beneficiary_references-section').on('input', () => {showButtonReferencesSection(); showButtonSend();});
  $('#amount_beneficiary_references-section').on('input', () => {showButtonReferencesSection(); showButtonSend();});
  $('#term_beneficiary_references-section').on('input', () => {showButtonReferencesSection(); showButtonSend();});
  $('#salary_beneficiary_references-section').on('input', () => {showButtonReferencesSection(); showButtonSend();});
  $('#bills_beneficiary_references-section').on('input', () => {showButtonReferencesSection(); showButtonSend();});
};

const handleInputsPldSection = () => {
  $('#pld-1-si_pld-section').on('change', showButtonSend);
  $('#pld-1-no_pld-section').on('change', showButtonSend);
  $('#pld-2-si_pld-section').on('change', showButtonSend);
  $('#pld-2-no_pld-section').on('change', showButtonSend);
  $('#pld-3-si_pld-section').on('change', showButtonSend);
  $('#pld-3-no_pld-section').on('change', showButtonSend);
  $('#pld-4-si_pld-section').on('change', showButtonSend);
  $('#pld-4-no_pld-section').on('change', showButtonSend);
  $('#pld-5-si_pld-section').on('change', showButtonSend);
  $('#pld-5-no_pld-section').on('change', showButtonSend);
  $('#pld-4-text_pld-section').on('input', showButtonSend);
  $('#pld-5-text_pld-section').on('input', showButtonSend);
};

handleInputsClientSection();
handleInputsLaborSection();
handleInputsSpouseSection();
handleInputsReferencesSection();
handleInputsPldSection();

$('input[name="pld-4"]').on('change', (ev) => {
  if(ev.target.value === 'si') $('#pld-4-text_pld-section').prop('disabled', false);
  if(ev.target.value === 'no') $('#pld-4-text_pld-section').prop('disabled', true);
})

$('input[name="pld-5"]').on('change', (ev) => {
  if(ev.target.value === 'si') $('#pld-5-text_pld-section').prop('disabled', false);
  if(ev.target.value === 'no') $('#pld-5-text_pld-section').prop('disabled', true);
})

$('#birthdate_client-section').on('change', (ev) => {
  let birthdate = new Date(ev.target.value + " ");
  let today = new Date();
  let year_difference = today.getFullYear() - birthdate.getFullYear();
  let one_or_zero = (today.getMonth() < birthdate.getMonth()) ||
                    (today.getMonth() === birthdate.getMonth() && today.getDate() < birthdate.getDate()) ? 1 : 0;
  let age = year_difference - one_or_zero;
  console.log(age);
  $('#age_client-section').val(age);
});