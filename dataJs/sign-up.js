"use strict";

$(function () {
  // Initialize Tom Select for country/state/city
  cdp_load_countries();
  cdp_load_states();
  cdp_load_cities();
  
  // Initialize document type select
  new TomSelect('#document_type', {
    placeholder: 'Sélectionner...',
    allowEmptyOption: true
  });
});

// Store TomSelect instances
var countrySelect, stateSelect, citySelect;

function cdp_load_countries() {
  countrySelect = new TomSelect('#country', {
    placeholder: translate_search_country || 'Rechercher un pays...',
    allowEmptyOption: false,
    valueField: 'id',
    labelField: 'text',
    searchField: 'text',
    load: function(query, callback) {
      if (!query.length) return callback();
      $.ajax({
        url: 'ajax/select2_countries.php',
        data: { q: query },
        dataType: 'json',
        success: function(data) {
          callback(data);
        },
        error: function() {
          callback();
        }
      });
    },
    onChange: function(value) {
      $('#state').attr('disabled', false);
      $('#state')[0].tomselect.enable();
      $('#state')[0].tomselect.clear();
      $('#state')[0].tomselect.clearOptions();
      $('#city')[0].tomselect.disable();
      $('#city')[0].tomselect.clear();
      cdp_refresh_states(value);
    }
  });
}

function cdp_refresh_states(country) {
  var stateTs = $('#state')[0].tomselect;
  stateTs.settings.load = function(query, callback) {
    $.ajax({
      url: 'ajax/select2_states.php?id=' + country,
      data: { q: query },
      dataType: 'json',
      success: function(data) {
        callback(data);
      },
      error: function() {
        callback();
      }
    });
  };
  stateTs.load('');
}

function cdp_load_states() {
  stateSelect = new TomSelect('#state', {
    placeholder: translate_search_state || 'Rechercher un état...',
    allowEmptyOption: false,
    valueField: 'id',
    labelField: 'text',
    searchField: 'text',
    disabled: true,
    onChange: function(value) {
      $('#city').attr('disabled', false);
      $('#city')[0].tomselect.enable();
      $('#city')[0].tomselect.clear();
      $('#city')[0].tomselect.clearOptions();
      cdp_refresh_cities(value);
    }
  });
}

function cdp_refresh_cities(state) {
  var cityTs = $('#city')[0].tomselect;
  cityTs.settings.load = function(query, callback) {
    $.ajax({
      url: 'ajax/select2_cities.php?id=' + state,
      data: { q: query },
      dataType: 'json',
      success: function(data) {
        callback(data);
      },
      error: function() {
        callback();
      }
    });
  };
  cityTs.load('');
}

function cdp_load_cities() {
  citySelect = new TomSelect('#city', {
    placeholder: translate_search_city || 'Rechercher une ville...',
    allowEmptyOption: false,
    valueField: 'id',
    labelField: 'text',
    searchField: 'text',
    disabled: true
  });
}

function cdp_showError(errors) {
  Swal.fire({
    title: message_error,
    text: errors,
    icon: "error",
    allowOutsideClick: false,
    confirmButtonText: "Ok",
    confirmButtonColor: '#f27474',
  });
}

function cdp_showSuccess(messages) {
  Swal.fire({
    title: messages,
    icon: "success",
    allowOutsideClick: false,
    confirmButtonText: "Ok",
    confirmButtonColor: '#336aea',
    type: "success",
  }).then((okay) => {
    if (okay) {
      window.location.href = "index.php";
    }
  });
}

var errorMsg = document.querySelector("#error-msg");
var validMsg = document.querySelector("#valid-msg");

// here, the index maps to the error code returned from getValidationError - see readme
var errorMap = [
  "Invalid number",
  "Invalid country code",
  "Too short",
  "Too long",
  "Invalid number",
];

var input = document.querySelector("#phone_custom");
var iti = window.intlTelInput(input, {
  geoIpLookup: function (callback) {
    $.get("http://ipinfo.io", function () {}, "jsonp").always(function (resp) {
      var countryCode = resp && resp.country ? resp.country : "";
      callback(countryCode);
    });
  },
  initialCountry: "auto",
  nationalMode: true,
  separateDialCode: true,
  utilsScript: "assets/template/assets/libs/intlTelInput/utils.js",
});

var reset = function () {
  input.classList.remove("is-invalid");
  errorMsg.innerHTML = "";
  errorMsg.classList.add("hide");
  validMsg.classList.add("hide");
};

// on blur: validate
input.addEventListener("blur", function () {
  reset();
  if (input.value.trim()) {
    if (iti.isValidNumber()) {
      $("#phone").val(iti.getNumber());
      validMsg.classList.remove("hide");
    } else {
      input.classList.add("is-invalid");
      var errorCode = iti.getValidationError();
      errorMsg.innerHTML = errorMap[errorCode];
      errorMsg.classList.remove("hide");
    }
  }
});

// on keyup / change flag: reset
input.addEventListener("change", reset);
input.addEventListener("keyup", reset);


// Validación de fortaleza de la contraseña en tiempo real
  $("#pass").on("input", function () {
    var password = $(this).val();
    var strength = calculatePasswordStrength(password);
    var meter = $("#password-strength-meter");

    var text = "";
    var colorClass = "";
    if (password.length < 9) {
      text = message_error_form94;
      colorClass = "weak";
    } else if (strength < 20) {
      text = message_error_form95;
      colorClass = "weaks";
    } else if (strength < 40) {
      text = message_error_form96;
      colorClass = "medium";
    } else if (strength < 60) {
      text = message_error_form97;
      colorClass = "good";
    } else if (strength < 80) {
      text = message_error_form98;
      colorClass = "strong";
    } else {
      text = message_error_form99;
      colorClass = "very-strong";
    }

    meter.removeClass().addClass(colorClass).text(text + " (" + password.length + " "+ message_error_form100 +")");
  });

  // Validación de coincidencia de contraseñas
  $("#pass2").on("input", function () {
    var password = $("#pass").val();
    var password2 = $(this).val();
    if (password !== password2) {
      $("#passwordMatch").text(message_error_form101);
    } else {
      $("#passwordMatch").text("");
    }
  });

  // Función para calcular la fortaleza de la contraseña
  function calculatePasswordStrength(password) {
    var score = 0;
    if (password.length > 7) {
      score++;
    }
    if ((/[a-z]/.test(password)) && (/[A-Z]/.test(password))) {
      score++;
    }
    if (/[0-9]/.test(password)) {
      score++;
    }
    if (/[!@#$%^&*()_+\-=\[\]{};':"\\|,.<>\/?]/.test(password)) {
      score++;
    }
    return score * 20;
  }
  
  

$("#new_register").on("submit", function (event) {


  // Validación de la contraseña
  var password = $("#pass").val();
  var strength = calculatePasswordStrength(password);
  if (strength < 40) {
    Swal.fire({
      title: message_error_form102,
      text: message_error_form103,
      icon: 'error',
      allowOutsideClick: false,
      confirmButtonColor: "#f27474",
      confirmButtonText: "Ok",
    });
    event.preventDefault(); // Detener el envío del formulario si la contraseña es débil
    return;
  }

  // Resto del código para enviar el formulario mediante AJAX
  if (iti.isValidNumber()) {
    var parametros = $(this).serialize();
    $.ajax({
      type: "POST",
      url: "./ajax/sign_up_ajax.php",
      data: parametros,
      dataType: "json",
      beforeSend: function (objeto) {
        Swal.fire({
          title: message_loading,
          allowOutsideClick: false,
          didOpen: () => {
            Swal.showLoading();
          },
        });
      },
      success: function (data) {
        if (data.success) {
          cdp_showSuccess(data.messages);
        } else {
          cdp_showError(data.errors);
        }
      },
    });
  } else {
    input.classList.add("is-invalid");
    var errorCode = iti.getValidationError();
    errorMsg.innerHTML = errorMap[errorCode];
    errorMsg.classList.remove("hide");
    $("#phone_custom").focus();
  }
  event.preventDefault();
});

