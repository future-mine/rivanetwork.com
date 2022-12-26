function inventorySlotBuy(playerSlot)
{
    function proccessSlotBuy(ajaxUrl, slotNumber)
    {
        swal.fire({
          title: $languages["warning"],
          html: $languages["inventoryJSBuySlotLoading"] + '<br><br><div class="loader-bars"><div class="loader-bar"></div><div class="loader-bar"></div><div class="loader-bar"></div><div class="loader-bar"></div><div class="loader-bar"></div><div class="loader-bar"></div><div class="loader-bar"></div><div class="loader-bar"></div></div><br>',
          type: "warning",
          allowOutsideClick: false,
          showConfirmButton: false
        });
        $.ajax({
          type: "POST",
          url: ajaxUrl + "?action=buy",
          data: {buySlot: slotNumber},
          success: function(result) {
            var ajaxData = JSON.parse(result);
            if (ajaxData.code == "successyfull") {
              swal.fire({
                title: $languages["success"],
                text: $languages["inventoryJSBuySlotSuccess"].replaceAll("&slotNumber", slotNumber),
                type: "success",
                confirmButtonColor: "#02b875",
                confirmButtonText: $languages["okey"]
              }).then(function() {
                window.location = $links["inventory"];
              });
            } else if (ajaxData.code == "notCredit") {
              swal.fire({
                title: $languages["error"],
                text: $languages["inventoryJSBuySlotCreditError"],
                type: "error",
                confirmButtonColor: "#02b875",
                confirmButtonText: $languages["creditUpload"]
              }).then(function() {
                window.location = $links["credit_upload"];
              });
            } else if (ajaxData.code == "notLogin") {
              swal.fire({
                title: $languages["error"],
                text: $languages["inventoryJSBuySlotLoginError"],
                type: "error",
                confirmButtonColor: "#02b875",
                confirmButtonText: $languages["login"]
              }).then(function() {
                window.location = $links["login"];
              });
            } else if (ajaxData.code == "fullSlot") {
              swal.fire({
                title: $languages["error"],
                text: $languages["inventoryJSBuySlotFullError"],
                type: "error",
                confirmButtonColor: "#02b875",
                confirmButtonText: $languages["okey"]
              });
            } else if (ajaxData.code == "") {
              swal.fire({
                title: $languages["error"],
                text: $languages["systemError"],
                type: "error",
                confirmButtonColor: "#02b875",
                confirmButtonText: $languages["okey"]
              });
            }
          }
        });
    }
    
    var $playerSlot = playerSlot;
    var $ajaxUrl = "/main/includes/packages/layouts/inventory/php/proccess.php";
    if ($playerSlot == "12") {
      var $buyText = '<div class="form-item"><div class="form-select"><label for="inventory-slotSwal">' + $languages["inventoryJSSlotNumber"] + '</label><select id="inventory-slotSwal" style="color: #545454;"><option style="background-color: #111; border-color: #212121; color: #545454;" value="6" selected>' + $languages["inventoryJSSlotNumberText"].replaceAll("&number", "+6").replaceAll("&credit", "24") + '</option><option style="background-color: #161616; border-color: #161616; color: #545454;" value="12" >' + $languages["inventoryJSSlotNumberText"].replaceAll("&number", "+12").replaceAll("&credit", "42") + '</option><option style="background-color: #161616; border-color: #161616; color: #545454;" value="18" >' + $languages["inventoryJSSlotNumberText"].replaceAll("&number", "+18").replaceAll("&credit", "70") + '</option></select><svg class="form-select-icon icon-small-arrow"><use xlink:href="#svg-small-arrow"></use></svg></div></div>';
    } else if ($playerSlot == "18") {
      var $buyText = '<div class="form-item"><div class="form-select"><label for="inventory-slotSwal">' + $languages["inventoryJSSlotNumber"] + '</label><select id="inventory-slotSwal" style="color: #545454;"><option style="background-color: #161616; border-color: #161616; color: #545454;" value="6" selected>' + $languages["inventoryJSSlotNumberText"].replaceAll("&number", "+6").replaceAll("&credit", "24") + '</option><option style="background-color: #161616; border-color: #161616; color: #545454;" value="12" >' + $languages["inventoryJSSlotNumberText"].replaceAll("&number", "+12").replaceAll("&credit", "42") + '</option></select><svg class="form-select-icon icon-small-arrow"><use xlink:href="#svg-small-arrow"></use></svg></div></div>';
    } else if ($playerSlot == "24") {
      var $buyText = '<div class="form-item"><div class="form-select"><label for="inventory-slotSwal">' + $languages["inventoryJSSlotNumber"] + '</label><select id="inventory-slotSwal" style="color: #545454;"><option style="background-color: #161616; border-color: #161616; color: #545454;" value="6" selected>' + $languages["inventoryJSSlotNumberText"].replaceAll("&number", "+6").replaceAll("&credit", "24") + '</option></select><svg class="form-select-icon icon-small-arrow"><use xlink:href="#svg-small-arrow"></use></svg></div></div>';
    } else {
      var $buyText = '<div class="form-item"><div class="form-select"><label for="inventory-slotSwal">' + $languages["inventoryJSSlotNumber"] + '</label><select id="inventory-slotSwal" style="color: #545454;"><option style="background-color: #161616; border-color: #161616; color: #545454;" value="0" selected>' + $languages["inventoryJSBuySlotFullError"] + '</option></select><svg class="form-select-icon icon-small-arrow"><use xlink:href="#svg-small-arrow"></use></svg></div></div>';
    }
    swal.fire({
      title: $languages["inventoryJSBuySlotText"],
      html: $buyText,
      showCancelButton: true,
      confirmButtonColor: "#02b875",
      cancelButtonColor: "#f5365c",
      confirmButtonText: $languages["buy"],
      cancelButtonText: $languages["giveUp"],
      reverseButtons: true
    }).then(function(isAccepted) {
      if (isAccepted.value) {
        var $slotNumber = $('#inventory-slotSwal').val();
        if ($slotNumber == "0") {
          swal.fire({
            title: $languages["error"],
            html: $languages["inventoryJSBuySlotFullError"],
            type: "error",
            confirmButtonColor: "#f5365c",
            confirmButtonText: $languages["close"]
          });
        } else {
          swal.fire({
            title: $languages["areYouSure"],
            html: $languages["inventoryJSBuySlotAreYouSure"].replaceAll("&slotNumber", $slotNumber),
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#02b875",
            cancelButtonColor: "#f5365c",
            confirmButtonText: $languages["approve"],
            cancelButtonText: $languages["giveUp"],
            reverseButtons: true
          }).then(function(isAccepted) {
            if (isAccepted.value) {
              proccessSlotBuy($ajaxUrl, $slotNumber);
            }
          });
        }
      }
    });
}
function inventoryCheckAll()
{
    function inventCheckAll(ajaxUrl)
    {
        swal.fire({
          title: $languages["warning"],
          html: $languages["inventoryJSActiveIvent"] + '<br><br><div class="loader-bars"><div class="loader-bar"></div><div class="loader-bar"></div><div class="loader-bar"></div><div class="loader-bar"></div><div class="loader-bar"></div><div class="loader-bar"></div><div class="loader-bar"></div><div class="loader-bar"></div></div><br>',
          type: "warning",
          allowOutsideClick: false,
          showConfirmButton: false
        });
        $.ajax({
          type: "POST",
          url: ajaxUrl + "?action=checkAll",
          data: {proccess: "checkAll"},
          success: function(result) {
            var ajaxData = JSON.parse(result);
            if (ajaxData.code == "successyfull") {
              swal.fire({
                title: $languages["success"],
                text: $languages["inventoryJSFullActiveIventSuccess"],
                type: "success",
                confirmButtonColor: "#02b875",
                confirmButtonText: $languages["okey"]
              }).then(function() {
                window.location = $links["inventory"];
              });
            } else if (ajaxData.code == "notItem") {
              swal.fire({
                title: $languages["error"],
                text: $languages["inventoryJSNotIvent"],
                type: "error",
                confirmButtonColor: "#02b875",
                confirmButtonText: $languages["okey"]
              });
            } else if (ajaxData.code == "notData" || ajaxData.code == "") {
              swal.fire({
                title: $languages["error"],
                text: $languages["systemError"],
                type: "error",
                confirmButtonColor: "#02b875",
                confirmButtonText: $languages["okey"]
              });
            }
          }
        });
    }
    var $ajaxUrl = "/main/includes/packages/layouts/inventory/php/proccess.php";
    
    swal.fire({
      title: $languages["areYouSure"],
      html: $languages["inventoryJSFullInventoryCheckAreYouSure"],
      type: "warning",
      showCancelButton: true,
      confirmButtonColor: "#02b875",
      cancelButtonColor: "#f5365c",
      confirmButtonText: $languages["approve"],
      cancelButtonText: $languages["giveUp"],
      reverseButtons: true
    }).then(function(isAccepted) {
      if (isAccepted.value) {
        inventCheckAll($ajaxUrl);
      }
    });
}

function proccessInventory(inventID)
{
    // INVENTORY CHECK
    function inventoryCheck(ajaxUrlCheck, inventIDCheck)
    {
        var $ajaxUrlCheck = ajaxUrlCheck;
        var $inventIDCheck = inventIDCheck;
        swal.fire({
          title: $languages["warning"],
          html: $languages["inventoryJSActiveIvent"] + '<br><br><div class="loader-bars"><div class="loader-bar"></div><div class="loader-bar"></div><div class="loader-bar"></div><div class="loader-bar"></div><div class="loader-bar"></div><div class="loader-bar"></div><div class="loader-bar"></div><div class="loader-bar"></div></div><br>',
          type: "warning",
          allowOutsideClick: false,
          showConfirmButton: false
        });
        $.ajax({
          type: "POST",
          url: $ajaxUrlCheck + "?action=check",
          data: {inventIDCheck: $inventIDCheck},
          success: function(result) {
            var ajaxData = JSON.parse(result);
            if (ajaxData.code == "successyfull") {
              if (ajaxData.inventType == "1") {
                swal.fire({
                  title: $languages["success"],
                  text: $languages["inventoryJSCreditActiveIventSuccess"],
                  type: "success",
                  confirmButtonColor: "#02b875",
                  confirmButtonText: $languages["okey"]
                }).then(function() {
                  window.location = $links["profile"];
                });
              } else if (ajaxData.inventType == "2") {
                swal.fire({
                  title: $languages["success"],
                  text: $languages["inventoryJSProductActiveIventSuccess"],
                  type: "success",
                  confirmButtonColor: "#02b875",
                  confirmButtonText: $languages["okey"]
                }).then(function() {
                  window.location = $links["chest"];
                });
              }
            } else if (ajaxData.code == "notData" || ajaxData.code == "") {
              swal.fire({
                title: $languages["error"],
                text: $languages["systemError"],
                type: "error",
                confirmButtonColor: "#02b875",
                confirmButtonText: $languages["okey"]
              });
            }
          }
        });
    }
    // INVENTORY GIFT
    function inventoryGift(ajaxUrlGift, inventIDGift, usernameGift)
    {
        var $ajaxUrlGift = ajaxUrlGift;
        var $inventIDGift = inventIDGift;
        var $usernameGift = usernameGift;
        swal.fire({
          title: $languages["warning"],
          html: $languages["inventoryJSSendGiftLoading"] + '<br><br><div class="loader-bars"><div class="loader-bar"></div><div class="loader-bar"></div><div class="loader-bar"></div><div class="loader-bar"></div><div class="loader-bar"></div><div class="loader-bar"></div><div class="loader-bar"></div><div class="loader-bar"></div></div><br>',
          type: "warning",
          allowOutsideClick: false,
          showConfirmButton: false
        });
        $.ajax({
          type: "POST",
          url: $ajaxUrlGift + "?action=gift",
          data: {inventIDGift: $inventIDGift, username: $usernameGift},
          success: function(result) {
            var ajaxData = JSON.parse(result);
            if (ajaxData.code == "successyfull") {
              swal.fire({
                title: $languages["success"],
                html: $languages["inventoryJSSendGiftSuccess"].replaceAll("&username", $usernameGift),
                type: "success",
                confirmButtonColor: "#02b875",
                confirmButtonText: $languages["okey"]
              }).then(function() {
                window.location = $links["inventory"];
              });
            } else if (ajaxData.code == "transferDisabled") {
              swal.fire({
                title: $languages["error"],
                text: $languages["inventoryJSSendGiftStatusError"],
                type: "error",
                confirmButtonColor: "#02b875",
                confirmButtonText: $languages["okey"]
              }).then(function() {
                window.location = $links["inventory"];
              });
            } else if (ajaxData.code == "notPlayer") {
              swal.fire({
                title: $languages["error"],
                text: $languages["inventoryJSSendGiftUsernameError"],
                type: "error",
                confirmButtonColor: "#02b875",
                confirmButtonText: $languages["okey"]
              });
            } else if (ajaxData.code == "notInventory") {
              swal.fire({
                title: $languages["error"],
                text: $languages["inventoryJSSendGiftInventorySlotError"],
                type: "error",
                confirmButtonColor: "#02b875",
                confirmButtonText: $languages["okey"]
              });
            } else if (ajaxData.code == "notGiftSelf") {
              swal.fire({
                title: $languages["error"],
                text: $languages["inventoryJSSendGiftYourselfError"],
                type: "error",
                confirmButtonColor: "#02b875",
                confirmButtonText: $languages["okey"]
              });
            } else if (ajaxData.code == "notData" || ajaxData.code == "") {
              swal.fire({
                title: $languages["error"],
                text: $languages["systemError"],
                type: "error",
                confirmButtonColor: "#02b875",
                confirmButtonText: $languages["okey"]
              });
            }
          }
        });
    }
    
    // PROCCESS INVENTORY CHECK
    function proccessInventoryCheck(ajaxUrlCheck, inventIDCheck, inventNameCheck)
    {
        var $ajaxUrlCheck = ajaxUrlCheck;
        var $inventIDCheck = inventIDCheck;
        var $inventNameCheck = inventNameCheck;
        swal.fire({
          title: $languages["areYouSure"],
          html: $languages["inventoryJSCheckIventAreYouSure"].replaceAll("&ivent", $inventNameCheck),
          type: "warning",
          showCancelButton: true,
          confirmButtonColor: "#02b875",
          cancelButtonColor: "#f5365c",
          confirmButtonText: $languages["approve"],
          cancelButtonText: $languages["giveUp"],
          reverseButtons: true
        }).then(function(isAccepted) {
          if (isAccepted.value) {
            inventoryCheck($ajaxUrlCheck, $inventIDCheck);
          }
        });
    }
    // PROCCESS INVENTORY GIFT
    function proccessInventoryGift(ajaxUrlGift, inventIDGift, inventNameGift)
    {
        var $ajaxUrlGift = ajaxUrlGift;
        var $inventIDGift = inventIDGift;
        var $inventNameGift = inventNameGift;
        swal.fire({
          title: $languages["sendGift"],
          html: '<br><div class="input-group mb-3 flex-column bg-dark--5 border col-12 p-0 input-focused"> <label for="inventory-ivent" class="o-100 d-block mb-0 text-white font-size-6 font-100 position-absolute">' + $languages["ivent"] + '</label> <input type="text" placeholder="' + $languages["ivent"] + '" class="form-control pt-4 text-white font-size-7 py-2 w-100 font-100 rounded-none" aria-label="' + $languages["ivent"] + '" id="inventory-ivent" aria-describedby="inventory-ivent" name="inventID" value="' + $inventNameGift + '" readonly/></div><div class="input-group mb-3 flex-column bg-dark--5 border col-12 p-0 input-focused"> <label for="inventory-user" class="o-100 d-block mb-0 text-white font-size-6 font-100 position-absolute">' + $languages["username"] + '</label> <input type="text" placeholder="' + $languages["useername"] + '" class="form-control pt-4 text-white font-size-7 py-2 w-100 font-100 rounded-none" aria-label="' + $languages["username"] + '" id="inventory-user" aria-describedby="inventory-user" name="inventGiftUserName"/></div>',
          showCancelButton: true,
          confirmButtonColor: "#02b875",
          cancelButtonColor: "#f5365c",
          confirmButtonText: $languages["approve"],
          cancelButtonText: $languages["giveUp"],
          reverseButtons: true
        }).then(function(isAccepted) {
          if (isAccepted.value) {
            var $username = $('#inventGiftUserName').val();
            if ($username == "") {
              swal.fire({
                title: $languages["error"],
                text: $languages["inventoryJSSendGiftUsernamePlease"],
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#02b875",
                cancelButtonColor: "#f5365c",
                confirmButtonText: $languages["tryagain"],
                cancelButtonText: $languages["close"],
                reverseButtons: true
              }).then(function(isAccepted) {
                if (isAccepted.value) {
                  proccessInventoryGift($ajaxUrlGift, $inventIDGift, $inventNameGift)
                }
              });
            } else {
              swal.fire({
                title: $languages["areYouSure"],
                html: $languages["inventoryJSSendGiftUserAreYouSure"].replaceAll("&ivent", $inventNameGift).replaceAll("&username", $username),
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#02b875",
                cancelButtonColor: "#f5365c",
                confirmButtonText: $languages["approve"],
                cancelButtonText: $languages["giveUp"],
                reverseButtons: true
              }).then(function(isAccepted) {
                if (isAccepted.value) {
                  inventoryGift($ajaxUrlGift, $inventIDGift, $username);
                }
              });
            }
          }
        });
    }
    
    // INIT
    var $ajaxUrl = "/main/includes/packages/layouts/inventory/php/proccess.php";
    var $inventID = inventID;
    
      swal.fire({
        title: $languages["warning"],
        html: $languages["inventoryJSIventControlLoading"] + '<br><br><div class="loader-bars"><div class="loader-bar"></div><div class="loader-bar"></div><div class="loader-bar"></div><div class="loader-bar"></div><div class="loader-bar"></div><div class="loader-bar"></div><div class="loader-bar"></div><div class="loader-bar"></div></div><br>',
        type: "warning",
        allowOutsideClick: false,
        showConfirmButton: false
      });
      $.ajax({
        type: "POST",
        url: $ajaxUrl + "?action=info",
        data: {inventID: inventID},
        success: function(result) {
          var ajaxData = JSON.parse(result);
          var $inventName = ajaxData.name;
          var $inventType = ajaxData.type;
          if ($inventType == "1") {
            var $inventText = $languages["inventoryJSIventValue1"].replaceAll("&ivent", $inventName);
          } else if ($inventType == "2") {
            var $inventServerName = ajaxData.serverName;
            var $inventText = $languages["inventoryJSIventValue2"].replaceAll("&ivent", $inventName).replaceAll("&serverName", $inventServerName);
          }
          if (ajaxData.code == "successyfull") {
            swal.fire({
              title: $languages["inventoryJSIventInfo"],
              html: $inventText,
              showCancelButton: true,
              confirmButtonColor: "#02b875",
              cancelButtonColor: "#f5365c",
              confirmButtonText: $languages["check"],
              cancelButtonText: $languages["sendGift"],
              reverseButtons: true
            }).then((result) => {
              if (result.dismiss === Swal.DismissReason.confirm) {
                proccessInventoryCheck($ajaxUrl, $inventID, $inventName)
              } else if (result.dismiss === Swal.DismissReason.cancel) {
                proccessInventoryGift($ajaxUrl, $inventID, $inventName);
              }
            });
		  }
        }
      });
}