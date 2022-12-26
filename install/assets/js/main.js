var SetupStep = (function() {
  if ($setupStep == "1") {
    $('[setup-step-current="1"]').css("display", "block");
    $('[setup-step="1"]').attr("data-wizard-state", "current");
    $('[setup-step-current="2"]').css("display", "none");
    $('[setup-step="2"]').attr("data-wizard-state", "pending");
    $('[setup-step-current="3"]').css("display", "none");
    $('[setup-step="3"]').attr("data-wizard-state", "pending");
    $('[setup-step-current="4"]').css("display", "none");
    $('[setup-step="4"]').attr("data-wizard-state", "pending");
  } else if ($setupStep == "2") {
    $('[setup-step-current="1"]').css("display", "none");
    $('[setup-step="1"]').attr("data-wizard-state", "done");
    $('[setup-step-current="2"]').css("display", "block");
    $('[setup-step="2"]').attr("data-wizard-state", "current");
    $('[setup-step-current="3"]').css("display", "none");
    $('[setup-step="3"]').attr("data-wizard-state", "pending");
    $('[setup-step-current="4"]').css("display", "none");
    $('[setup-step="4"]').attr("data-wizard-state", "pending");
  } else if ($setupStep == "3") {
    $('[setup-step-current="1"]').css("display", "none");
    $('[setup-step="1"]').attr("data-wizard-state", "done");
    $('[setup-step-current="2"]').css("display", "none");
    $('[setup-step="2"]').attr("data-wizard-state", "done");
    $('[setup-step-current="3"]').css("display", "block");
    $('[setup-step="3"]').attr("data-wizard-state", "current");
    $('[setup-step-current="4"]').css("display", "none");
    $('[setup-step="4"]').attr("data-wizard-state", "pending");
  } else if ($setupStep == "4") {
    $('[setup-step-current="1"]').css("display", "none");
    $('[setup-step="1"]').attr("data-wizard-state", "done");
    $('[setup-step-current="2"]').css("display", "none");
    $('[setup-step="2"]').attr("data-wizard-state", "done");
    $('[setup-step-current="3"]').css("display", "none");
    $('[setup-step="3"]').attr("data-wizard-state", "done");
    $('[setup-step-current="4"]').css("display", "block");
    $('[setup-step="4"]').attr("data-wizard-state", "current");
  }
})();
var SetupStepButton = (function() {
  var $stepButton = $('[setup-button="button"]');
  
  if ($stepButton.length) {
    $stepButton.each(function() {
      $(this).on("click", function () {
        var $proccessType = $(this).attr("setup-action");
        if ($proccessType == "prev") {
          var $prev = $(this).attr("setup-prev");
          if ($prev == "1") {
            $('[setup-step-current="1"]').css("display", "block");
            $('[setup-step="1"]').attr("data-wizard-state", "current");
            $('[setup-step-current="2"]').css("display", "none");
            $('[setup-step="2"]').attr("data-wizard-state", "pending");
            $('[setup-step-current="3"]').css("display", "none");
            $('[setup-step="3"]').attr("data-wizard-state", "pending");
            $('[setup-step-current="4"]').css("display", "none");
            $('[setup-step="4"]').attr("data-wizard-state", "pending");
          } else if ($prev == "2") {
            $('[setup-step-current="1"]').css("display", "none");
            $('[setup-step="1"]').attr("data-wizard-state", "done");
            $('[setup-step-current="2"]').css("display", "block");
            $('[setup-step="2"]').attr("data-wizard-state", "current");
            $('[setup-step-current="3"]').css("display", "none");
            $('[setup-step="3"]').attr("data-wizard-state", "pending");
            $('[setup-step-current="4"]').css("display", "none");
            $('[setup-step="4"]').attr("data-wizard-state", "pending");
          } else if ($prev == "3") {
            $('[setup-step-current="1"]').css("display", "none");
            $('[setup-step="1"]').attr("data-wizard-state", "done");
            $('[setup-step-current="2"]').css("display", "none");
            $('[setup-step="2"]').attr("data-wizard-state", "done");
            $('[setup-step-current="3"]').css("display", "block");
            $('[setup-step="3"]').attr("data-wizard-state", "current");
            $('[setup-step-current="4"]').css("display", "none");
            $('[setup-step="4"]').attr("data-wizard-state", "pending");
          }
        } else if ($proccessType == "next") {
          var $next = $(this).attr("setup-next");
          if ($next == "2") {
            $('[setup-step-current="1"]').css("display", "none");
            $('[setup-step="1"]').attr("data-wizard-state", "done");
            $('[setup-step-current="2"]').css("display", "block");
            $('[setup-step="2"]').attr("data-wizard-state", "current");
            $('[setup-step-current="3"]').css("display", "none");
            $('[setup-step="3"]').attr("data-wizard-state", "pending");
            $('[setup-step-current="4"]').css("display", "none");
            $('[setup-step="4"]').attr("data-wizard-state", "pending");
          } else if ($next == "3") {
            $('[setup-step-current="1"]').css("display", "none");
            $('[setup-step="1"]').attr("data-wizard-state", "done");
            $('[setup-step-current="2"]').css("display", "none");
            $('[setup-step="2"]').attr("data-wizard-state", "done");
            $('[setup-step-current="3"]').css("display", "block");
            $('[setup-step="3"]').attr("data-wizard-state", "current");
            $('[setup-step-current="4"]').css("display", "none");
            $('[setup-step="4"]').attr("data-wizard-state", "pending");
          } else if ($next == "4") {
            $('[setup-step-current="1"]').css("display", "none");
            $('[setup-step="1"]').attr("data-wizard-state", "done");
            $('[setup-step-current="2"]').css("display", "none");
            $('[setup-step="2"]').attr("data-wizard-state", "done");
            $('[setup-step-current="3"]').css("display", "none");
            $('[setup-step="3"]').attr("data-wizard-state", "done");
            $('[setup-step-current="4"]').css("display", "block");
            $('[setup-step="4"]').attr("data-wizard-state", "current");
          }
        }
      });
    });
  }
})();

$(document).ready(function() {
  $('[language="change"]').on("change", function() {
    window.location = "/install?language=" + $(this).val();
  });
  if ($(".js-example-basic-single").length) {
    $(".js-example-basic-single").select2();
  }
  if ($(".js-example-basic-multiple").length) {
    $(".js-example-basic-multiple").select2();
  }
});