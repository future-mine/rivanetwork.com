function proccessChest(productID)
{
  var $ajaxUrl = "/main/includes/packages/layouts/chest/php/proccess.php?action=check";
  var $productID = productID;
  
  function serverConnect(ajaxUrl, productID) {
      swal.fire({
        title: $languages["warning"],
        html: $languages["chestJSActiveInfoText"] + '<br><br><div class="loader-bars"><div class="loader-bar"></div><div class="loader-bar"></div><div class="loader-bar"></div><div class="loader-bar"></div><div class="loader-bar"></div><div class="loader-bar"></div><div class="loader-bar"></div><div class="loader-bar"></div></div><br>',
        icon: "warning",
        allowOutsideClick: false,
        showConfirmButton: false
      });
      $.ajax({
        type: "POST",
        url: ajaxUrl,
        data: {productID: productID},
        success: function(result) {
          var ajaxData = JSON.parse(result);
		      var result = ajaxData.code;
          if (result == "successyfull") {
            swal.fire({
              title: $languages["success"],
              text: $languages["chestJSActiveSuccesAlert"],
              icon: "success",
              confirmButtonColor: "#02b875",
              confirmButtonText: $languages["okey"]
            }).then(function() {
              window.location = $links["chest"];
            });
          } else if (result == "notData" || result == "notProduct" || result == "") {
            swal.fire({
              title: $languages["error"],
              text: $languages["systemError"],
              icon: "error",
              confirmButtonColor: "#02b875",
              confirmButtonText: $languages["okey"]
            }).then(function() {
              window.location = $links["chest"];
            });
          } else if (result == "notLogin") {
            swal.fire({
              title: $languages["error"],
              text: $languages["chestJSActiveLoginError"],
              icon: "error",
              confirmButtonColor: "#02b875",
              confirmButtonText: $languages["login"]
            }).then(function() {
              window.location = $links["login"];
            });
         } else if (result == "notConnect") {
            swal.fire({
              title: $languages["error"],
              text: $languages["chestJSActiveConnectError"],
              icon: "error",
              confirmButtonColor: "#02b875",
              confirmButtonText: $languages["okey"]
            });
          }
        }
      });
  }
  
  // TRANSACTİON CONFİRMATİON
  swal.fire({
    title: $languages["warning"],
    text: $languages["chestJSActiveCheckText"],
    icon: "warning",
    showCancelButton: true,
    confirmButtonColor: "#02b875",
    cancelButtonColor: "#f5365c",
    cancelButtonText: $languages["giveUp"],
    confirmButtonText: $languages["approve"],
    reverseButtons: true
  }).then(function(isAccepted) {
    if (isAccepted.value) {
      serverConnect($ajaxUrl, $productID);
    }
  });
}

function productGift(productID, productName)
{
  var $ajaxUrl = "/main/includes/packages/layouts/chest/php/proccess.php?action=gift";
  var $productID = productID;
  var $productName = productName;
  
  function proccessGift(ajaxUrl, productID, username) {
      swal.fire({
        title: $languages["warning"],
        html: $languages["chestJSGiftLoadingText"] + '<br><br><div class="loader-bars"><div class="loader-bar"></div><div class="loader-bar"></div><div class="loader-bar"></div><div class="loader-bar"></div><div class="loader-bar"></div><div class="loader-bar"></div><div class="loader-bar"></div><div class="loader-bar"></div></div><br>',
        icon: "warning",
        allowOutsideClick: false,
        showConfirmButton: false
      });
      $.ajax({
        type: "POST",
        url: ajaxUrl,
        data: {productID: productID, username: username},
        success: function(result) {
          var ajaxData = JSON.parse(result);
		  var result = ajaxData.code;
          if (result == "successyfull") {
            swal.fire({
              title: $languages["success"],
              text: $languages["chestJSGiftSuccessText"],
              icon: "success",
              confirmButtonColor: "#02b875",
              confirmButtonText: $languages["okey"]
            }).then(function() {
              window.location = $links["chest"];
            });
          } else if (result == "notData" || result == "notProduct" || result == "") {
            swal.fire({
              title: $languages["error"],
              text: $languages["systemError"],
              icon: "error",
              confirmButtonColor: "#02b875",
              confirmButtonText: $languages["okey"]
            }).then(function() {
              window.location = $links["chest"];
            });
          } else if (result == "notLogin") {
            swal.fire({
              title: $languages["error"],
              text: $languages["chestJSGiftLoginError"],
              icon: "error",
              confirmButtonColor: "#02b875",
              confirmButtonText: $languages["login"]
            }).then(function() {
              window.location = $links["login"];
            });
          } else if (result == "transferDisabled") {
            swal.fire({
              title: $languages["error"],
              text: $languages["chestJSGiftStatusError"],
              icon: "error",
              confirmButtonColor: "#02b875",
              confirmButtonText: $languages["okey"]
            }).then(function() {
              window.location = $links["chest"];
            });
          } else if (result == "checkProduct") {
            swal.fire({
              title: $languages["error"],
              text: $languages["chestJSGiftActiveProductError"],
              icon: "error",
              confirmButtonColor: "#02b875",
              confirmButtonText: $languages["okey"]
            }).then(function() {
              window.location = $links["chest"];
            });
         } else if (result == "notAccount") {
            swal.fire({
              title: $languages["error"],
              text: $languages["chestJSGiftNotUserError"],
              icon: "error",
              confirmButtonColor: "#02b875",
              confirmButtonText: $languages["tryagain"],
              reverseButtons: true
            }).then(function(isAccepted) {
              if (isAccepted.value) {
                productGift($productID, $productName);
              }
            });
          } else if (result == "sendToYourself") {
            swal.fire({
              title: $languages["error"],
              text: $languages["chestJSGiftYourselfError"],
              icon: "error",
              confirmButtonColor: "#02b875",
              confirmButtonText: $languages["tryagain"],
              reverseButtons: true
            }).then(function(isAccepted) {
              if (isAccepted.value) {
                productGift($productID, $productName);
              }
            });
          } else if (result == "notSlot") {
            swal.fire({
              title: $languages["error"],
              text: $languages["chestJSGiftInventoryError"],
              icon: "error",
              confirmButtonColor: "#02b875",
              confirmButtonText: $languages["tryagain"],
              reverseButtons: true
            }).then(function(isAccepted) {
              if (isAccepted.value) {
                productGift($productID, $productName);
              }
            });
          }
        }
      });
  }
  
  swal.fire({
    title: $languages["sendGift"],
    html: '<br><div class="form-row"><div class="form-item"><div class="form-input small active"><label for="productGiftName">' + $languages["product"] + '</label><input type="text" id="productGiftName" name="product" value="' + $productName + '" readonly></div></div></div><div class="form-row"><div class="form-item"><div class="form-input small active"><label for="productGiftUserName">' + $languages["username"] + '</label><input type="text" id="productGiftUserName" name="username"></div></div></div>',
    showCancelButton: true,
    confirmButtonColor: "#02b875",
    cancelButtonColor: "#f5365c",
    confirmButtonText: $languages["approve"],
    cancelButtonText: $languages["giveUp"],
    reverseButtons: true
  }).then(function(isAccepted) {
    if (isAccepted.value) {
      var $username = $('#productGiftUserName').val();
      if ($username == "") {
        swal.fire({
          title: $languages["error"],
          text: $languages["chestJSGiftUsernameError"],
          icon: "warning",
          showCancelButton: true,
          confirmButtonColor: "#02b875",
          cancelButtonColor: "#f5365c",
          confirmButtonText: $languages["tryagain"],
          cancelButtonText: $languages["close"],
          reverseButtons: true
        }).then(function(isAccepted) {
          if (isAccepted.value) {
            productGift($productID, $productName);
          }
        });
      } else {
        swal.fire({
          title: $languages["areYouSure"],
          html: $languages["chestJSGiftSendSure"].replaceAll("&productName", $productName).replaceAll("&username", $username),
          icon: "warning",
          showCancelButton: true,
          confirmButtonColor: "#02b875",
          cancelButtonColor: "#f5365c",
          confirmButtonText: $languages["approve"],
          cancelButtonText: $languages["giveUp"],
          reverseButtons: true
        }).then(function(isAccepted) {
          if (isAccepted.value) {
            proccessGift($ajaxUrl, $productID, $username);
          }
        });
      }
    }
  });
}