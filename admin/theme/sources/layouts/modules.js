var ChangeThemes = (function() {
  var $select = $('[themes="changeThemes"]');
  
  var $successAlert = $("#connectAlertSuccess");
  var $errorAlert = $("#connectAlertError");
  
  if ($select.length) {
    $select.each(function() {
      var $select = $(this);
      $select.on("change", function() {
        var $theme = $select.attr("theme-id");
        var $value = $select.val();
        if ($value == "1") {
          $.ajax({
            type: "POST",
            url: "/admin/libs/includes/packages/ajax/theme.php?action=change",
            data: {themeID: $theme},
            success: function(result) {
              var ajaxData = JSON.parse(result);
              if (ajaxData.code == "__SUCCESSYFULL__") {
                $successAlert.css("display", "block");
                $errorAlert.css("display", "none");
                setTimeout(() => {
                  location.reload();
                }, 2000);
              } else {
                $errorAlert.css("display", "block");
                $successAlert.css("display", "none");
                setTimeout(() => {
                  location.reload();
                }, 2000);
              }
            }
          });
        } else {
          return false;
        }
      });
    });
  }
})();

var WebhooksStatus = (function() {
  var $select = $('[webhooks="status"]');
  var $input = $('[webhooks="input"]');
  
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

$("#webhooksConnectControl").on("click", function() {
  var $webhooksType, $webhooksImage, $webhooksName, $webhooksAPI, $webhooksTitle, $webhooksContent, $webhooksSignature, $connectButton, $successAlert, $errorAlert, $ajaxUrl;
  
  // DATA
  $ajaxUrl = "/admin/libs/includes/packages/ajax/webhooks.php?action=control";
  $successAlert = $("#connectAlertSuccess");
  $errorAlert = $("#connectAlertError");
  $connectButton = $("#webhooksConnectControl");
  
  // DATA
  $webhooksType = $('[data-toggle="webhooksType"]').val();
  $webhooksName = $('[data-toggle="webhooksName"]').val();
  $webhooksAPI = $('[data-toggle="webhooksAPI"]').val();
  $webhooksImage = $('[data-toggle="webhooksImage"]').val();
  $webhooksTitle = $('[data-toggle="webhooksTitle"]').val();
  $webhooksContent = $('[data-toggle="webhooksContent"]').val();
  $webhooksSignature = $('[data-toggle="webhooksSignature"]').val();
  if ($webhooksImage == "") {
    $webhooksImage = 0;
  }
  
  $connectButton.html("<span class=\"spinner-border spinner-border-sm\" role=\"status\" aria-hidden=\"true\"></span><span class=\"sr-only\">" + $languages["controlLoading"] + "</span>").addClass("disabled").attr("disabled", "disabled").css("cursor", "no-drop");
  
  // INIT
  $.ajax({
    type: "POST",
    url: $ajaxUrl,
    data: {webhooksType: $webhooksType, webhooksName: $webhooksName, webhooksAPI: $webhooksAPI, webhooksImage: $webhooksImage, webhooksTitle: $webhooksTitle, webhooksContent: $webhooksContent, webhooksSignature: $webhooksSignature},
    success: function(result) {
      var ajaxData = JSON.parse(result);
      if (ajaxData.code == "__SUCCESSYFULL__") {
        $successAlert.css("display", "block");
        $errorAlert.css("display", "none");
        $connectButton.html($languages["success"]).removeClass("disabled").removeAttr("disabled", "disabled").css("cursor", "pointer");
      } else {
        $errorAlert.css("display", "block");
        $successAlert.css("display", "none");
        $connectButton.html($languages["error"]).removeClass("disabled").removeAttr("disabled", "disabled").css("cursor", "pointer");
      }
    }
  });
});

function dec2hex (dec)
{
  return dec.toString(16).padStart(2, "0")
}

function generateID (len)
{
  var number = new Uint8Array((len || 40) / 2)
  window.crypto.getRandomValues(number)
  return Array.from(number, dec2hex).join('')
}

var RemoveTableItem = (function() {
  var $button = $('[remove-item="button"]');
  
  if ($button.length) {
    $button.each(function() {
      $(this).on("click", function() {
        var $removeID = $(this).attr("remove-id");
        $("#removeID-" + $removeID).html("");
      });
    });
  }
})();

var AddItemCredit = (function() {
  var $button = $('[add-item="credit"]');
  var $table = $('[data-toggle="itemTable"]');
  
  if ($button.length) {
    $button.each(function() {
      $(this).on("click", function() {
        var $elementID = generateID();
        var $type = $(this).attr("item-type");
        
        if ($type == "coupon") {
          $table.append('<tr id="removeID-' + $elementID + '">  <td class="ml-2">    <div class="input-group">      <input type="hidden" name="couponItemTypes[]" value="0"><input type="text" class="form-control" placeholder="' + $languages["modulesRewardType"] + '" value="' + $languages["credit"] + '" readonly>    </div>  </td>  <td class="text-center align-middle">    <div class="input-group input-group-merge">      <div class="input-group-prepend">        <div class="input-group-text">          <span class="fa fa-dollar-sign"></span>        </div>      </div>      <input type="text" class="form-control form-control-prepended" name="couponItemRewards[]" placeholder="' + $languages["modulesRewardAmount"] + '">    </div>  </td>  <td class="text-center align-middle">    <button type="button" class="btn btn-danger btn-icon" remove-item="button" remove-id="' + $elementID + '">      <span class="far fa-trash-alt"></span>    </button>  </td></tr>');
        } else if ($type == "card") {
          $table.append('<tr id="removeID-' + $elementID + '">  <td class="ml-2">    <div class="input-group">      <input type="hidden" name="cardGameItemTypes[]" value="1"><input type="text" class="form-control" placeholder="' + $languages["modulesRewardType"] + '" value="' + $languages["credit"] + '" readonly>    </div>  </td>  <td class="text-center align-middle">    <div class="form-group row">      <div class="col-sm-12">        <input type="text" class="form-control" name="cardGameItemTitle[]" placeholder="' + $languages["modulesRewardTitle"] + '">      </div>    </div>  </td>  <td class="text-center align-middle">    <div class="form-group row">      <div class="col-sm-12">        <div class="input-group input-group-merge">          <div class="input-group-prepend">            <div class="input-group-text">              <span class="fa fa-dollar-sign"></span>            </div>          </div>          <input type="number" class="form-control" name="cardGameItemRewards[]" placeholder="' + $languages["modulesRewardAmount"] + '">        </div>      </div>    </div>  </td>  <td class="text-center align-middle">    <div class="form-group row">      <div class="col-sm-12">        <div class="input-group input-group-merge">          <div class="input-group-prepend">            <div class="input-group-text">              <span class="fa fa-percent"></span>            </div>          </div>          <input type="number" class="form-control" name="cardGameItemChance[]" placeholder="' + $languages["modulesRewardImage"] + '">        </div>      </div>    </div>  </td>  <td class="text-center align-middle">    <div class="form-group row">      <div class="col-sm-12">        <input type="text" class="form-control" name="cardGameItemImage[]" placeholder="' + $languages["modulesRewardImage"] + '">      </div>    </div>  </td>  <td class="text-center align-middle">    <button type="button" class="btn btn-danger btn-icon" remove-item="button" remove-id="' + $elementID + '">      <span class="far fa-trash-alt"></span>    </button>  </td></tr>');
        }
        
        var $removeButton = $('[remove-item="button"]');
        
        if ($removeButton.length) {
          $removeButton.each(function() {
            $(this).on("click", function() {
              var $removeID = $(this).attr("remove-id");
              $("#removeID-" + $removeID).remove();
            });
          });
        }
      });
    });
  }
})();

var AddItemProduct= (function() {
  var $button = $('[add-item="product"]');
  var $table = $('[data-toggle="itemTable"]');
  var $products;
  
  $.ajax({
    type: "POST",
    url: "/admin/libs/includes/packages/ajax/coupon.php",
    data: {},
    success: function(result) {
      $products = result;
    }
  });
  
  if ($button.length) {
    $button.each(function() {
      $(this).on("click", function() {
        var $elementID = generateID();
        var $type = $(this).attr("item-type");
        
        if ($type == "coupon") {
          $table.append('<tr id="removeID-' + $elementID + '">  <td class="ml-2">    <div class="input-group">      <input type="hidden" name="couponItemTypes[]" value="1"><input type="text" class="form-control" placeholder="' + $languages["modulesRewardType"] + '" value="' + $languages["product"] + '" readonly>    </div>  </td>  <td class="text-center align-middle">    <div class="form-group row">      <div class="col-sm-12">        <select class="form-control" name="couponItemRewards[]">' + $products + '</select>      </div>    </div>  </td>  <td class="text-center align-middle">    <button type="button" class="btn btn-danger btn-icon" remove-item="button" remove-id="' + $elementID + '">      <span class="far fa-trash-alt"></span>    </button>  </td></tr>');
        } else if ($type == "card") {
          $table.append('<tr id="removeID-' + $elementID + '">  <td class="ml-2">    <div class="input-group">      <input type="hidden" name="cardGameItemTypes[]" value="2"><input type="text" class="form-control" placeholder="' + $languages["modulesRewardType"] + '" value="' + $languages["product"] + '" readonly>    </div>  </td>  <td class="text-center align-middle">    <div class="form-group row">      <div class="col-sm-12">        <input type="text" class="form-control" name="cardGameItemTitle[]" placeholder="' + $languages["modulesRewardTitle"] + '">      </div>    </div>  </td>  <td class="text-center align-middle">    <div class="form-group row">      <div class="col-sm-12">        <select class="form-control" name="cardGameItemRewards[]">        ' + $products + '        </select>      </div>    </div>  </td>  <td class="text-center align-middle">    <div class="form-group row">      <div class="col-sm-12">        <div class="input-group input-group-merge">          <div class="input-group-prepend">            <div class="input-group-text">              <span class="fa fa-percent"></span>            </div>          </div>          <input type="number" class="form-control" name="cardGameItemChance[]" placeholder="' + $languages["modulesRewardChance"] + '">        </div>      </div>    </div>  </td>  <td class="text-center align-middle">    <div class="form-group row">      <div class="col-sm-12">        <input type="text" class="form-control" name="cardGameItemImage[]" placeholder="' + $languages["modulesRewardImage"] + '">      </div>    </div>  </td>  <td class="text-center align-middle">    <button type="button" class="btn btn-danger btn-icon" remove-item="button" remove-id="' + $elementID + '">      <span class="far fa-trash-alt"></span>    </button>  </td></tr>');
        }
        
        var $removeButton = $('[remove-item="button"]');
        
        if ($removeButton.length) {
          $removeButton.each(function() {
            $(this).on("click", function() {
              var $removeID = $(this).attr("remove-id");
              $("#removeID-" + $removeID).remove();
            });
          });
        }
      });
    });
  }
})();

var AddItemRust = (function() {
  var $button = $('[add-item="rust"]');
  var $table = $('[data-toggle="itemTable"]');
  
  if ($button.length) {
    $button.each(function() {
      $(this).on("click", function() {
        var $elementID = generateID();
        var $type = $(this).attr("item-type");
        
        if ($type == "card") {
          $table.append('<tr id="removeID-' + $elementID + '">  <td class="ml-2">    <div class="input-group">      <input type="hidden" name="cardGameItemTypes[]" value="0"><input type="text" class="form-control" placeholder="' + $languages["modulesRewardType"] + '" value="' + $languages["modulesRewardNone"] + '" readonly>    </div>  </td>  <td class="text-center align-middle">    <div class="form-group row">      <div class="col-sm-12">        <input type="text" class="form-control" name="cardGameItemTitle[]" placeholder="' + $languages["modulesRewardTitle"] + '">      </div>    </div>  </td>  <td class="text-center align-middle">    <div class="form-group row">      <label class="col-sm-12 col-form-label">' + $languages["modulesNotReward"] + '</label><input type="hidden" name="cardGameItemRewards[]" value="0">    </div>  </td>  <td class="text-center align-middle">    <div class="form-group row">      <div class="col-sm-12">        <div class="input-group input-group-merge">          <div class="input-group-prepend">            <div class="input-group-text">              <span class="fa fa-percent"></span>            </div>          </div>          <input type="number" class="form-control" name="cardGameItemChance[]" placeholder="' + $languages["modulesRewardChance"] + '">        </div>      </div>    </div>  </td>  <td class="text-center align-middle">    <div class="form-group row">      <div class="col-sm-12">        <input type="text" class="form-control" name="cardGameItemImage[]" placeholder="' + $languages["modulesRewardImage"] + '">      </div>    </div>  </td>  <td class="text-center align-middle">    <button type="button" class="btn btn-danger btn-icon" remove-item="button" remove-id="' + $elementID + '">      <span class="far fa-trash-alt"></span>    </button>  </td></tr>');
        }
        
        var $removeButton = $('[remove-item="button"]');
        
        if ($removeButton.length) {
          $removeButton.each(function() {
            $(this).on("click", function() {
              var $removeID = $(this).attr("remove-id");
              $("#removeID-" + $removeID).remove();
            });
          });
        }
      });
    });
  }
})();

var CouponType = (function() {
  var $select = $('[data-toggle="couponTypeStatus"]');
  var $input = $('[data-toggle="couponCountInput"]');
  
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

var CardGameType = (function() {
  var $select = $('[data-toggle="cardTypeStatus"]');
  var $hoursInput = $('[data-toggle="cardGameHoursInput"]');
  var $priceInput = $('[data-toggle="cardGamePriceInput"]');
  
  $select.on("change", function() {
    var $status = $select.val();
    if ($status == 0) {
      $hoursInput.css("display", "block");
      $priceInput.css("display", "none");
    } else if ($status == 1) {
      $hoursInput.css("display", "none");
      $priceInput.css("display", "block");
    } else {
      $hoursInput.css("display", "block");
      $priceInput.css("display", "none");
    }
  });
})();

var Colors = (function() {
  $button = $('[theme="colorChange"]');

  if ($button.length) {
    $button.each(function() {
      $(this).on("click", function() {
        $colorName = $(this).attr("themeColorName");
        if ($colorName == "Slate") {
          $('[themeColor="50"]').val("#F8FAFC");
          $('[themeColor="100"]').val("#F1F5F9");
          $('[themeColor="200"]').val("#E2E8F0");
          $('[themeColor="300"]').val("#CBD5E1");
          $('[themeColor="400"]').val("#94A3B8");
          $('[themeColor="500"]').val("#64748B");
          $('[themeColor="600"]').val("#475569");
          $('[themeColor="700"]').val("#334155");
          $('[themeColor="800"]').val("#1E293B");
          $('[themeColor="900"]').val("#0F172A");
        } else if ($colorName == "Gray") {
          $('[themeColor="50"]').val("#F9FAFB");
          $('[themeColor="100"]').val("#F3F4F6");
          $('[themeColor="200"]').val("#E5E7EB");
          $('[themeColor="300"]').val("#D1D5DB");
          $('[themeColor="400"]').val("#9CA3AF");
          $('[themeColor="500"]').val("#6B7280");
          $('[themeColor="600"]').val("#4B5563");
          $('[themeColor="700"]').val("#374151");
          $('[themeColor="800"]').val("#1F2937");
          $('[themeColor="900"]').val("#111827");
        } else if ($colorName == "Zinc") {
          $('[themeColor="50"]').val("#FAFAFA");
          $('[themeColor="100"]').val("#F4F4F5");
          $('[themeColor="200"]').val("#E4E4E7");
          $('[themeColor="300"]').val("#D4D4D8");
          $('[themeColor="400"]').val("#A1A1AA");
          $('[themeColor="500"]').val("#71717A");
          $('[themeColor="600"]').val("#52525B");
          $('[themeColor="700"]').val("#3F3F46");
          $('[themeColor="800"]').val("#27272A");
          $('[themeColor="900"]').val("#18181B");
        } else if ($colorName == "Neutral") {
          $('[themeColor="50"]').val("#FAFAFA");
          $('[themeColor="100"]').val("#F5F5F5");
          $('[themeColor="200"]').val("#E5E5E5");
          $('[themeColor="300"]').val("#D4D4D4");
          $('[themeColor="400"]').val("#A3A3A3");
          $('[themeColor="500"]').val("#737373");
          $('[themeColor="600"]').val("#525252");
          $('[themeColor="700"]').val("#404040");
          $('[themeColor="800"]').val("#262626");
          $('[themeColor="900"]').val("#171717");
        } else if ($colorName == "Stone") {
          $('[themeColor="50"]').val("#FAFAF9");
          $('[themeColor="100"]').val("#F5F5F4");
          $('[themeColor="200"]').val("#E7E5E4");
          $('[themeColor="300"]').val("#D6D3D1");
          $('[themeColor="400"]').val("#A8A29E");
          $('[themeColor="500"]').val("#78716C");
          $('[themeColor="600"]').val("#57534E");
          $('[themeColor="700"]').val("#44403C");
          $('[themeColor="800"]').val("#292524");
          $('[themeColor="900"]').val("#1C1917");
        } else if ($colorName == "Red") {
          $('[themeColor="50"]').val("#FEF2F2");
          $('[themeColor="100"]').val("#FEE2E2");
          $('[themeColor="200"]').val("#FECACA");
          $('[themeColor="300"]').val("#FCA5A5");
          $('[themeColor="400"]').val("#F87171");
          $('[themeColor="500"]').val("#EF4444");
          $('[themeColor="600"]').val("#DC2626");
          $('[themeColor="700"]').val("#B91C1C");
          $('[themeColor="800"]').val("#991B1B");
          $('[themeColor="900"]').val("#7F1D1D");
        } else if ($colorName == "Bold Red") {
          $('[themeColor="50"]').val("#FEF2F2");
          $('[themeColor="100"]').val("#FEE2E2");
          $('[themeColor="200"]').val("#FECACA");
          $('[themeColor="300"]').val("#FCA5A5");
          $('[themeColor="400"]').val("#db4646");
          $('[themeColor="500"]').val("#c82f2f");
          $('[themeColor="600"]').val("#bd2121");
          $('[themeColor="700"]').val("#9f1818");
          $('[themeColor="800"]').val("#7c1616");
          $('[themeColor="900"]').val("#691818");
        } else if ($colorName == "Extra Bold Red") {
          $('[themeColor="50"]').val("#FEF2F2");
          $('[themeColor="100"]').val("#FEE2E2");
          $('[themeColor="200"]').val("#FECACA");
          $('[themeColor="300"]').val("#FCA5A5");
          $('[themeColor="400"]').val("#bc2222");
          $('[themeColor="500"]').val("#9b1515");
          $('[themeColor="600"]').val("#8d1414");
          $('[themeColor="700"]').val("#771111");
          $('[themeColor="800"]').val("#5a1010");
          $('[themeColor="900"]').val("#3a0d0d");
        } else if ($colorName == "Orange") {
          $('[themeColor="50"]').val("#FFF7ED");
          $('[themeColor="100"]').val("#FFEDD5");
          $('[themeColor="200"]').val("#FED7AA");
          $('[themeColor="300"]').val("#FDBA74");
          $('[themeColor="400"]').val("#FB923C");
          $('[themeColor="500"]').val("#F97316");
          $('[themeColor="600"]').val("#EA580C");
          $('[themeColor="700"]').val("#C2410C");
          $('[themeColor="800"]').val("#9A3412");
          $('[themeColor="900"]').val("#7C2D12");
        } else if ($colorName == "Bold Orange") {
          $('[themeColor="50"]').val("#FFF7ED");
          $('[themeColor="100"]').val("#FFEDD5");
          $('[themeColor="200"]').val("#FED7AA");
          $('[themeColor="300"]').val("#FDBA74");
          $('[themeColor="400"]').val("#c36c25");
          $('[themeColor="500"]').val("#b15618");
          $('[themeColor="600"]').val("#933f13");
          $('[themeColor="700"]').val("#83310f");
          $('[themeColor="800"]').val("#5d220f");
          $('[themeColor="900"]').val("#3e180b");
        } else if ($colorName == "Extra Bold Orange") {
          $('[themeColor="50"]').val("#FFF7ED");
          $('[themeColor="100"]').val("#FFEDD5");
          $('[themeColor="200"]').val("#FED7AA");
          $('[themeColor="300"]').val("#FDBA74");
          $('[themeColor="400"]').val("#884106");
          $('[themeColor="500"]').val("#632d08");
          $('[themeColor="600"]').val("#652707");
          $('[themeColor="700"]').val("#441a08");
          $('[themeColor="800"]').val("#341105");
          $('[themeColor="900"]').val("#1d0902");
        } else if ($colorName == "Amber") {
          $('[themeColor="50"]').val("#FFFBEB");
          $('[themeColor="100"]').val("#FEF3C7");
          $('[themeColor="200"]').val("#FDE68A");
          $('[themeColor="300"]').val("#FCD34D");
          $('[themeColor="400"]').val("#FBBF24");
          $('[themeColor="500"]').val("#F59E0B");
          $('[themeColor="600"]').val("#D97706");
          $('[themeColor="700"]').val("#B45309");
          $('[themeColor="800"]').val("#92400E");
          $('[themeColor="900"]').val("#78350F");
        } else if ($colorName == "Yellow") {
          $('[themeColor="50"]').val("#FEFCE8");
          $('[themeColor="100"]').val("#FEF9C3");
          $('[themeColor="200"]').val("#FEF08A");
          $('[themeColor="300"]').val("#FDE047");
          $('[themeColor="400"]').val("#FACC15");
          $('[themeColor="500"]').val("#EAB308");
          $('[themeColor="600"]').val("#CA8A04");
          $('[themeColor="700"]').val("#A16207");
          $('[themeColor="800"]').val("#854D0E");
          $('[themeColor="900"]').val("#713F12");
        } else if ($colorName == "Bold Yellow") {
          $('[themeColor="50"]').val("#FEFCE8");
          $('[themeColor="100"]').val("#f7f3cf");
          $('[themeColor="200"]').val("#f9f1b4");
          $('[themeColor="300"]').val("#dfcd77");
          $('[themeColor="400"]').val("#a0830f");
          $('[themeColor="500"]').val("#725a0f");
          $('[themeColor="600"]').val("#573e07");
          $('[themeColor="700"]').val("#492e05");
          $('[themeColor="800"]').val("#422506");
          $('[themeColor="900"]').val("#391e07");
        } else if ($colorName == "Lime") {
          $('[themeColor="50"]').val("#F7FEE7");
          $('[themeColor="100"]').val("#ECFCCB");
          $('[themeColor="200"]').val("#D9F99D");
          $('[themeColor="300"]').val("#BEF264");
          $('[themeColor="400"]').val("#A3E635");
          $('[themeColor="500"]').val("#84CC16");
          $('[themeColor="600"]').val("#65A30D");
          $('[themeColor="700"]').val("#4D7C0F");
          $('[themeColor="800"]').val("#3F6212");
          $('[themeColor="900"]').val("#365314");
        } else if ($colorName == "Green") {
          $('[themeColor="50"]').val("#F0FDF4");
          $('[themeColor="100"]').val("#DCFCE7");
          $('[themeColor="200"]').val("#BBF7D0");
          $('[themeColor="300"]').val("#86EFAC");
          $('[themeColor="400"]').val("#4ADE80");
          $('[themeColor="500"]').val("#22C55E");
          $('[themeColor="600"]').val("#16A34A");
          $('[themeColor="700"]').val("#15803D");
          $('[themeColor="800"]').val("#166534");
          $('[themeColor="900"]').val("#14532D");
        } else if ($colorName == "Bold Green") {
          $('[themeColor="50"]').val("#F0FDF4");
          $('[themeColor="100"]').val("#DCFCE7");
          $('[themeColor="200"]').val("#BBF7D0");
          $('[themeColor="300"]').val("#86EFAC");
          $('[themeColor="400"]').val("#1ebb57");
          $('[themeColor="500"]').val("#119341");
          $('[themeColor="600"]').val("#0f7534");
          $('[themeColor="700"]').val("#0f642f");
          $('[themeColor="800"]').val("#105028");
          $('[themeColor="900"]').val("#0b3e1f");
        } else if ($colorName == "Extra Bold Green") {
          $('[themeColor="50"]').val("#F0FDF4");
          $('[themeColor="100"]').val("#DCFCE7");
          $('[themeColor="200"]').val("#BBF7D0");
          $('[themeColor="300"]').val("#86EFAC");
          $('[themeColor="400"]').val("#077a30");
          $('[themeColor="500"]').val("#055924");
          $('[themeColor="600"]').val("#094c21");
          $('[themeColor="700"]').val("#0b4421");
          $('[themeColor="800"]').val("#0b361b");
          $('[themeColor="900"]').val("#051d0f");
        } else if ($colorName == "Emerald") {
          $('[themeColor="50"]').val("#ECFDF5");
          $('[themeColor="100"]').val("#D1FAE5");
          $('[themeColor="200"]').val("#A7F3D0");
          $('[themeColor="300"]').val("#6EE7B7");
          $('[themeColor="400"]').val("#34D399");
          $('[themeColor="500"]').val("#10B981");
          $('[themeColor="600"]').val("#059669");
          $('[themeColor="700"]').val("#047857");
          $('[themeColor="800"]').val("#065F46");
          $('[themeColor="900"]').val("#064E3B");
        } else if ($colorName == "Teal") {
          $('[themeColor="50"]').val("#F0FDFA");
          $('[themeColor="100"]').val("#CCFBF1");
          $('[themeColor="200"]').val("#99F6E4");
          $('[themeColor="300"]').val("#5EEAD4");
          $('[themeColor="400"]').val("#2DD4BF");
          $('[themeColor="500"]').val("#14B8A6");
          $('[themeColor="600"]').val("#0D9488");
          $('[themeColor="700"]').val("#0F766E");
          $('[themeColor="800"]').val("#115E59");
          $('[themeColor="900"]').val("#134E4A");
        } else if ($colorName == "Cyan") {
          $('[themeColor="50"]').val("#ECFEFF");
          $('[themeColor="100"]').val("#CFFAFE");
          $('[themeColor="200"]').val("#A5F3FC");
          $('[themeColor="300"]').val("#67E8F9");
          $('[themeColor="400"]').val("#22D3EE");
          $('[themeColor="500"]').val("#06B6D4");
          $('[themeColor="600"]').val("#0891B2");
          $('[themeColor="700"]').val("#0E7490");
          $('[themeColor="800"]').val("#155E75");
          $('[themeColor="900"]').val("#164E63");
        } else if ($colorName == "Sky") {
          $('[themeColor="50"]').val("#F0F9FF");
          $('[themeColor="100"]').val("#E0F2FE");
          $('[themeColor="200"]').val("#BAE6FD");
          $('[themeColor="300"]').val("#7DD3FC");
          $('[themeColor="400"]').val("#38BDF8");
          $('[themeColor="500"]').val("#0EA5E9");
          $('[themeColor="600"]').val("#0284C7");
          $('[themeColor="700"]').val("#0369A1");
          $('[themeColor="800"]').val("#075985");
          $('[themeColor="900"]').val("#0C4A6E");
        } else if ($colorName == "Blue") {
          $('[themeColor="50"]').val("#EFF6FF");
          $('[themeColor="100"]').val("#DBEAFE");
          $('[themeColor="200"]').val("#BFDBFE");
          $('[themeColor="300"]').val("#93C5FD");
          $('[themeColor="400"]').val("#60A5FA");
          $('[themeColor="500"]').val("#3B82F6");
          $('[themeColor="600"]').val("#2563EB");
          $('[themeColor="700"]').val("#1D4ED8");
          $('[themeColor="800"]').val("#1E40AF");
          $('[themeColor="900"]').val("#1E3A8A");
        } else if ($colorName == "Bold Blue") {
          $('[themeColor="50"]').val("#EFF6FF");
          $('[themeColor="100"]').val("#DBEAFE");
          $('[themeColor="200"]').val("#BFDBFE");
          $('[themeColor="300"]').val("#93C5FD");
          $('[themeColor="400"]').val("#3273c3");
          $('[themeColor="500"]').val("#2158b3");
          $('[themeColor="600"]').val("#1b4cb7");
          $('[themeColor="700"]').val("#1339a1");
          $('[themeColor="800"]').val("#163085");
          $('[themeColor="900"]').val("#112150");
        } else if ($colorName == "Extra Bold Blue") {
          $('[themeColor="50"]').val("#EFF6FF");
          $('[themeColor="100"]').val("#DBEAFE");
          $('[themeColor="200"]').val("#BFDBFE");
          $('[themeColor="300"]').val("#93C5FD");
          $('[themeColor="400"]').val("#113f77");
          $('[themeColor="500"]').val("#082e6d");
          $('[themeColor="600"]').val("#0c2a6d");
          $('[themeColor="700"]').val("#0c2871");
          $('[themeColor="800"]').val("#0c1e57");
          $('[themeColor="900"]').val("#080f26");
        } else if ($colorName == "Indigo") {
          $('[themeColor="50"]').val("#EEF2FF");
          $('[themeColor="100"]').val("#E0E7FF");
          $('[themeColor="200"]').val("#d4ddfe");
          $('[themeColor="300"]').val("#b2befc");
          $('[themeColor="400"]').val("#818CF8");
          $('[themeColor="500"]').val("#6366F1");
          $('[themeColor="600"]').val("#4F46E5");
          $('[themeColor="700"]').val("#4338CA");
          $('[themeColor="800"]').val("#3730A3");
          $('[themeColor="900"]').val("#312E81");
        } else if ($colorName == "Bold Indigo") {
          $('[themeColor="50"]').val("#EEF2FF");
          $('[themeColor="100"]').val("#E0E7FF");
          $('[themeColor="200"]').val("#d4ddfe");
          $('[themeColor="300"]').val("#b2befc");
          $('[themeColor="400"]').val("#4552cd");
          $('[themeColor="500"]').val("#3c3eb2");
          $('[themeColor="600"]').val("#332d9c");
          $('[themeColor="700"]').val("#2c258a");
          $('[themeColor="800"]').val("#211c68");
          $('[themeColor="900"]').val("#1b1846");
        } else if ($colorName == "Extra Bold Indigo") {
          $('[themeColor="50"]').val("#EEF2FF");
          $('[themeColor="100"]').val("#E0E7FF");
          $('[themeColor="200"]').val("#d4ddfe");
          $('[themeColor="300"]').val("#b2befc");
          $('[themeColor="400"]').val("#2d3795");
          $('[themeColor="500"]').val("#2d2e7b");
          $('[themeColor="600"]').val("#1f1a76");
          $('[themeColor="700"]').val("#201a6e");
          $('[themeColor="800"]').val("#191550");
          $('[themeColor="900"]').val("#100f2c");
        } else if ($colorName == "Violet") {
          $('[themeColor="50"]').val("#F5F3FF");
          $('[themeColor="100"]').val("#EDE9FE");
          $('[themeColor="200"]').val("#DDD6FE");
          $('[themeColor="300"]').val("#C4B5FD");
          $('[themeColor="400"]').val("#A78BFA");
          $('[themeColor="500"]').val("#8B5CF6");
          $('[themeColor="600"]').val("#7C3AED");
          $('[themeColor="700"]').val("#6D28D9");
          $('[themeColor="800"]').val("#5B21B6");
          $('[themeColor="900"]').val("#4C1D95");
        } else if ($colorName == "Purple") {
          $('[themeColor="50"]').val("#FAF5FF");
          $('[themeColor="100"]').val("#F3E8FF");
          $('[themeColor="200"]').val("#E9D5FF");
          $('[themeColor="300"]').val("#D8B4FE");
          $('[themeColor="400"]').val("#C084FC");
          $('[themeColor="500"]').val("#A855F7");
          $('[themeColor="600"]').val("#9333EA");
          $('[themeColor="700"]').val("#7E22CE");
          $('[themeColor="800"]').val("#6B21A8");
          $('[themeColor="900"]').val("#581C87");
        } else if ($colorName == "Fuchsia") {
          $('[themeColor="50"]').val("#FDF4FF");
          $('[themeColor="100"]').val("#FAE8FF");
          $('[themeColor="200"]').val("#F5D0FE");
          $('[themeColor="300"]').val("#F0ABFC");
          $('[themeColor="400"]').val("#E879F9");
          $('[themeColor="500"]').val("#D946EF");
          $('[themeColor="600"]').val("#C026D3");
          $('[themeColor="700"]').val("#A21CAF");
          $('[themeColor="800"]').val("#86198F");
          $('[themeColor="900"]').val("#701A75");
        } else if ($colorName == "Pink") {
          $('[themeColor="50"]').val("#FDF2F8");
          $('[themeColor="100"]').val("#FCE7F3");
          $('[themeColor="200"]').val("#FBCFE8");
          $('[themeColor="300"]').val("#F9A8D4");
          $('[themeColor="400"]').val("#F472B6");
          $('[themeColor="500"]').val("#EC4899");
          $('[themeColor="600"]').val("#DB2777");
          $('[themeColor="700"]').val("#BE185D");
          $('[themeColor="800"]').val("#9D174D");
          $('[themeColor="900"]').val("#831843");
        } else if ($colorName == "Rose") {
          $('[themeColor="50"]').val("#FFF1F2");
          $('[themeColor="100"]').val("#FFE4E6");
          $('[themeColor="200"]').val("#FECDD3");
          $('[themeColor="300"]').val("#FDA4AF");
          $('[themeColor="400"]').val("#FB7185");
          $('[themeColor="500"]').val("#F43F5E");
          $('[themeColor="600"]').val("#E11D48");
          $('[themeColor="700"]').val("#BE123C");
          $('[themeColor="800"]').val("#9F1239");
          $('[themeColor="900"]').val("#881337");
        } else if ($colorName == "Bold Rose") {
          $('[themeColor="50"]').val("#FFF1F2");
          $('[themeColor="100"]').val("#f0babe");
          $('[themeColor="200"]').val("#f09ea8");
          $('[themeColor="300"]').val("#e66f7e");
          $('[themeColor="400"]').val("#cb384e");
          $('[themeColor="500"]').val("#bc1b36");
          $('[themeColor="600"]').val("#b71236");
          $('[themeColor="700"]').val("#8d0f2e");
          $('[themeColor="800"]').val("#7f0e2d");
          $('[themeColor="900"]').val("#640d28");
        }
      });
    });
  }
})();

var LotteryStatus = (function() {
  var $select = $('[data-toggle="lotteryStatus"]');
  var $input = $('[data-toggle="lotteryStatusInput"]');
  
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

var LotteryGiftStatus = (function() {
  var $select = $('[data-toggle="lotteryExtraGifts"]');
  var $input = $('[data-toggle="lotteryExtraGiftsInput"]');
  
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