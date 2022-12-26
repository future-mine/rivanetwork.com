if ($supportMessageBoxReload == 1) {
  $("#support-message-box").scrollTop($("#support-message-box")[0].scrollHeight);
}

function deletedSupport(supportID)
{
  var $supportID = supportID;
  var $ajaxUrl = "/main/includes/packages/layouts/support/php/proccess.php?action=close";
  
  function proccessSupport(ajaxUrl, supportID)
  {
      swal.fire({
        title: $languages["warning"],
        html: $languages["supportJSRemoveLoading"] + '<br><br><div class="loader-bars"><div class="loader-bar"></div><div class="loader-bar"></div><div class="loader-bar"></div><div class="loader-bar"></div><div class="loader-bar"></div><div class="loader-bar"></div><div class="loader-bar"></div><div class="loader-bar"></div></div><br>',
        icon: "warning",
        allowOutsideClick: false,
        showConfirmButton: false
      });
      $.ajax({
        type: "POST",
        url: ajaxUrl,
        data: {supportID: supportID},
        success: function(result) {
          var ajaxData = JSON.parse(result);
		  var result = ajaxData.code;
          if (result == "successyfull") {
            swal.fire({
              title: $languages["success"],
              text: $languages["supportJSRemoveSuccess"],
              icon: "success",
              confirmButtonColor: "#02b875",
              confirmButtonText: $languages["okey"]
            }).then(function() {
              window.location = $links["support"];
            });
          } else if (result == "notData" || result == "") {
            swal.fire({
              title: $languages["error"],
              text: $languages["systemError"],
              icon: "error",
              confirmButtonColor: "#02b875",
              confirmButtonText: $languages["okey"]
            }).then(function() {
              window.location = $links["support"];
            });
          }
        }
      });
  }
  
  // TRANSACTİON CONFİRMATİON
  swal.fire({
    title: $languages["warning"],
    text: $languages["supportJSRemoveAreYouSure"],
    icon: "warning",
    showCancelButton: true,
    confirmButtonColor: "#02b875",
    cancelButtonColor: "#f5365c",
    cancelButtonText: $languages["giveUp"],
    confirmButtonText: $languages["approve"],
    reverseButtons: true
  }).then(function(isAccepted) {
    if (isAccepted.value) {
      proccessSupport($ajaxUrl, $supportID);
    }
  });
}