function proccessChest(productID)
{
  var $ajaxUrl = "/main/includes/packages/layouts/chest/php/proccess.php?action=check";
  var $productID = productID;
  
  function serverConnect(ajaxUrl, productID) {
      swal.fire({
        title: $languages["warning"],
        html: $languages["chestJSActiveInfoText"] + '<br><br><div class="loader-bars"><div class="loader-bar"></div><div class="loader-bar"></div><div class="loader-bar"></div><div class="loader-bar"></div><div class="loader-bar"></div><div class="loader-bar"></div><div class="loader-bar"></div><div class="loader-bar"></div></div><br>',
        type: "warning",
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
              type: "success",
              confirmButtonColor: "#02b875",
              confirmButtonText: $languages["okey"]
            }).then(function() {
              window.location = $links["chest"];
            });
          } else if (result == "notData" || result == "notProduct" || result == "") {
            swal.fire({
              title: $languages["error"],
              text: $languages["systemError"],
              type: "error",
              confirmButtonColor: "#02b875",
              confirmButtonText: $languages["okey"]
            }).then(function() {
              window.location = $links["chest"];
            });
          } else if (result == "notLogin") {
            swal.fire({
              title: $languages["error"],
              text: $languages["chestJSActiveLoginError"],
              type: "error",
              confirmButtonColor: "#02b875",
              confirmButtonText: $languages["login"]
            }).then(function() {
              window.location = $links["login"];
            });
         } else if (result == "notConnect") {
            swal.fire({
              title: $languages["error"],
              text: $languages["chestJSActiveConnectError"],
              type: "error",
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
    type: "warning",
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
        type: "warning",
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
              type: "success",
              confirmButtonColor: "#02b875",
              confirmButtonText: $languages["okey"]
            }).then(function() {
              window.location = $links["chest"];
            });
          } else if (result == "notData" || result == "notProduct" || result == "") {
            swal.fire({
              title: $languages["error"],
              text: $languages["systemError"],
              type: "error",
              confirmButtonColor: "#02b875",
              confirmButtonText: $languages["okey"]
            }).then(function() {
              window.location = $links["chest"];
            });
          } else if (result == "notLogin") {
            swal.fire({
              title: $languages["error"],
              text: $languages["chestJSGiftLoginError"],
              type: "error",
              confirmButtonColor: "#02b875",
              confirmButtonText: $languages["login"]
            }).then(function() {
              window.location = $links["login"];
            });
          } else if (result == "transferDisabled") {
            swal.fire({
              title: $languages["error"],
              text: $languages["chestJSGiftStatusError"],
              type: "error",
              confirmButtonColor: "#02b875",
              confirmButtonText: $languages["okey"]
            }).then(function() {
              window.location = $links["chest"];
            });
          } else if (result == "checkProduct") {
            swal.fire({
              title: $languages["error"],
              text: $languages["chestJSGiftActiveProductError"],
              type: "error",
              confirmButtonColor: "#02b875",
              confirmButtonText: $languages["okey"]
            }).then(function() {
              window.location = $links["chest"];
            });
         } else if (result == "notAccount") {
            swal.fire({
              title: $languages["error"],
              text: $languages["chestJSGiftNotUserError"],
              type: "error",
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
              type: "error",
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
              type: "error",
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
    html: '<div class="input-group mb-3 flex-column bg-dark--5 border col-12 p-0 input-focused"> <label for="productGiftName" class="o-100 d-block mb-0 text-white font-size-6 font-100 position-absolute">' + $languages["product"] + '</label> <input type="text" placeholder="' + $languages["product"] + '" class="form-control pt-4 text-white font-size-7 py-2 w-100 font-100 rounded-none" aria-label="' + $languages["product"] + '" id="productGiftName" aria-describedby="productGiftName" name="product" value="' + $productName + '" readonly/></div><div class="input-group mb-3 flex-column bg-dark--5 border col-12 p-0 input-focused"> <label for="productGiftUserName" class="o-100 d-block mb-0 text-white font-size-6 font-100 position-absolute">' + $languages["username"] + '</label> <input type="text" placeholder="' + $languages["username"] + '" class="form-control pt-4 text-white font-size-7 py-2 w-100 font-100 rounded-none" aria-label="' + $languages["username"] + '" id="productGiftUserName" aria-describedby="productGiftUserName" name="username"/></div>',
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
          type: "warning",
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
          html: $languages["chestJSGiftSendSure"].replace("&productName", $productName).replace("&username", $username),
          type: "warning",
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