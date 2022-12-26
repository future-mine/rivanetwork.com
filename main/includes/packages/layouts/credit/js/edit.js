if ($('[credit="salesAgreement"]').length) {
  $('[credit="salesAgreement"]').each(function() {
    $(this).on("click", function() {
      if ($('[credit="salesAgreementInput"]').val() == "1") {
        $('[credit="salesAgreementInput"]').val('0');
      } else {
        $('[credit="salesAgreementInput"]').val('1');
      }
    });
  });
}

$('[credit="upload"]').on("click", function() {
    var $ajaxURLProccess = "/main/includes/packages/layouts/credit/php/proccess.php";
    var $ajaxURLPay = "/main/includes/packages/payments/pay.php";
  
    var $paymentData, $amount, $method, $api, $userID, $name, $surname, $phoneNumber, $salesAgreement;
    $paymentData = $('[credit="method"]').val().split("-");
    $amount      = $('[credit="amount"]').val();
    $method      = $paymentData[1];
    $api         = $paymentData[0];
    $userID      = $('[credit="userID"]').val();
    $name        = $('[credit="name"]').val();
    $surname     = $('[credit="surname"]').val();
    $phoneNumber = $('[credit="phoneNumber"]').val();
    $salesAgreement = "no";
    if ($('[credit="salesAgreementInput"]').val() == "1") {
      $salesAgreement = "yes";
    }
  
    swal.fire({
      title: $languages["warning"],
      html: $languages["alertControl"] + '<br><br><div class="loader-bars"><div class="loader-bar"></div><div class="loader-bar"></div><div class="loader-bar"></div><div class="loader-bar"></div><div class="loader-bar"></div><div class="loader-bar"></div><div class="loader-bar"></div><div class="loader-bar"></div></div><br>',
      icon: "warning",
      allowOutsideClick: false,
      showConfirmButton: false
    });
  
    $.ajax({
      type: "POST",
      url: $ajaxURLProccess,
      data: {salesAgreement: $salesAgreement, amount: $amount, method: $method, api: $api, userID: $userID, firstName: $name, surName: $surname, phoneNumber: $phoneNumber},
      success: function(data) {
        var $returnData = jQuery.parseJSON(data);
        if ($returnData.status == true) {
          $.ajax({
            type: "POST",
            url: $ajaxURLPay,
            data: {amount: $returnData.amount, method: $method, api: $api, userID: $returnData.userID},
            success: function(dataPay) {
              var $returnDataPay = jQuery.parseJSON(dataPay);
              if ($returnDataPay.status == true) {
                if ($returnDataPay.type == "print_r") {
                  $('[credit="html"]').html($returnDataPay.redirect);
                } else {
                  window.location = $returnDataPay.redirect;
                }
              } else {
                if ($returnDataPay.type == "print_r") {
                  $('[credit="html"]').html($returnDataPay.reason);
                } else {
                  swal.fire({
                    title: $languages["error"],
                    text: $returnDataPay.reason,
                    icon: "error",
                    confirmButtonColor: "#02b875",
                    confirmButtonText: $languages["okey"],
                    reverseButtons: true
                  });
                }
              }
            }
          });
        } else {
          if ($returnData.type == "print_r") {
            $('[credit="html"]').html($returnData.reason);
          } else {
            swal.fire({
              title: $languages["error"],
              text: $returnData.reason,
              icon: "error",
              confirmButtonColor: "#02b875",
              confirmButtonText: $languages["okey"],
              reverseButtons: true
            });
          }
        }
      }
    });
  });