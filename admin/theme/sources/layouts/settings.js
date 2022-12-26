var LiveChatStatus = (function() {
  var $select = $('[data-toggle="LiveChatStatus"]');
  var $input = $('[data-toggle="LiveChatValue"]');
  
  $select.on("change", function() {
    var $status = $select.val();
    if ($status == 0) {
      $input.css("display", "none");
    } else if ($status == 1) {
      $input.css("display", "block");
    } else {
      $input.css("display", "none");
    }
  });
})();

var VoteSystemStatus = (function() {
  var $select = $('[data-toggle="VoteSystemStatusSelect"]');
  var $input = $('[data-toggle="VoteSystemStatusInput"]');
  
  $select.on("change", function() {
    var $status = $select.val();
    if ($status == 0) {
      $input.css("display", "none");
    } else if ($status == 1) {
      $input.css("display", "block");
    } else {
      $input.css("display", "none");
    }
  });
})();

var RegisterLimit = (function() {
  var $select = $('[data-toggle="registerLimitStatus"]');
  var $input = $('[data-toggle="registerLimitValue"]');
  
  $select.on("change", function() {
    var $status = $select.val();
    if ($status == 0) {
      $input.css("display", "none");
    } else if ($status == 1) {
      $input.css("display", "block");
    } else {
      $input.css("display", "none");
    }
  });
})();

var KDVStatus = (function() {
  var $select = $('[data-toggle="KDVStatusSelect"]');
  var $input = $('[data-toggle="KDVValueInput"]');
  
  $select.on("change", function() {
    var $status = $select.val();
    if ($status == 0) {
      $input.css("display", "none");
    } else if ($status == 1) {
      $input.css("display", "block");
    } else {
      $input.css("display", "none");
    }
  });
})();

var RecaptchaStatus = (function() {
  var $select = $('[data-toggle="reCAPTCHAStatus"]');
  var $input = $('[data-toggle="reCAPTCHAValue"]');
  
  $select.on("change", function() {
    var $status = $select.val();
    if ($status == 0) {
      $input.css("display", "none");
    } else if ($status == 1) {
      $input.css("display", "block");
    } else {
      $input.css("display", "none");
    }
  });
})();

var PaymentSettings = (function() {
  var $select = $('[data-toggle="PaymentSettings"]');
  
  if ($select.length) {
    $select.each(function() {
      $(this).on("change", function() {
        var $Mobile = "none";
        var $name = $select.val();
        var $input = $('[data-toggle="' + $name + '"]');
        $input.css("display", "block");
        if ($name !== "paytr" && $Mobile !== "paytr") {
          $('[data-toggle="paytr"]').css("display", "none");
        }
        if ($name !== "paypalipn" && $Mobile !== "paypalipn") {
          $('[data-toggle="paypalipn"]').css("display", "none");
        }
        if ($name !== "paymax" && $Mobile !== "paymax") {
          $('[data-toggle="paymax"]').css("display", "none");
        }
        if ($name !== "paywant" && $Mobile !== "paywant") {
          $('[data-toggle="paywant"]').css("display", "none");
        }
        if ($name !== "shipy" && $Mobile !== "shipy") {
          $('[data-toggle="shipy"]').css("display", "none");
        }
        if ($name !== "shopier" && $Mobile !== "shopier") {
          $('[data-toggle="shopier"]').css("display", "none");
        }
        if ($name !== "batihost" && $Mobile !== "batihost") {
          $('[data-toggle="batihost"]').css("display", "none");
        }
        if ($name !== "keyubu" && $Mobile !== "keyubu") {
          $('[data-toggle="keyubu"]').css("display", "none");
        }
        if ($name !== "rabisu" && $Mobile !== "rabisu") {
          $('[data-toggle="rabisu"]').css("display", "none");
        }
        if ($name !== "stripe" && $Mobile !== "stripe") {
          $('[data-toggle="stripe"]').css("display", "none");
        }
        if ($name !== "paypal" && $Mobile !== "paypal") {
          $('[data-toggle="paypal"]').css("display", "none");
        }
        if ($name !== "anksoft" && $Mobile !== "anksoft") {
          $('[data-toggle="anksoft"]').css("display", "none");
        }
        if ($name !== "ininal" && $Mobile !== "ininal") {
          $('[data-toggle="ininal"]').css("display", "none");
        }
        if ($name !== "transfer" && $Mobile !== "transfer") {
          $('[data-toggle="transfer"]').css("display", "none");
        }
        if ($name !== "papara" && $Mobile !== "papara") {
          $('[data-toggle="papara"]').css("display", "none");
        }
        if ($name !== "tosla" && $Mobile !== "tosla") {
          $('[data-toggle="tosla"]').css("display", "none");
        }
      });
    });
  }
})();

$(document).ready(function () {
  $(".payment-types").on("change", function() {
    var $methodID = $(this).attr("method-id");
    if ($(this).val() == "paywant" || $(this).val() == "shipy" || $(this).val() == "batihost" || $(this).val() == "rabisu" || $(this).val() == "keyubu") {
      $(".payment-method[methods='"+$methodID+"'] option[value=0]").removeAttr("disabled").attr("selected", "selected");
    } else {
      $(".payment-method[methods='"+$methodID+"'] option[value=0]").attr("disabled", "disabled").removeAttr("selected");
    }
    if ($(this).val() == "paypal" || $(this).val() == "paypalipn" || $(this).val() == "stripe" || $(this).val() == "paytr" || $(this).val() == "paymax" || $(this).val() == "shopier" || $(this).val() == "paywant" || $(this).val() == "shipy" || $(this).val() == "batihost" || $(this).val() == "rabisu" || $(this).val() == "keyubu" || $(this).val() == "anksoft") {
      $(".payment-method[methods='"+$methodID+"'] option[value=1]").removeAttr("disabled").attr("selected", "selected");
    } else {
      $(".payment-method[methods='"+$methodID+"'] option[value=1]").attr("disabled", "disabled").removeAttr("selected");
    }
    if ($(this).val() == "transfer" || $(this).val() == "ininal" || $(this).val() == "papara" || $(this).val() == "tosla") {
      $(".payment-method[methods='"+$methodID+"'] option[value=2]").removeAttr("disabled").attr("selected", "selected");
    } else {
      $(".payment-method[methods='"+$methodID+"'] option[value=2]").attr("disabled", "disabled").removeAttr("selected");
    }
  });
});