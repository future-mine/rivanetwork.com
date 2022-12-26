var StoreDiscountChange = (function() {
  var $select = $('[store-discount="status"]');
  var $input = $('[store-discount="input"]');
  
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

var StoreExtraCreditChange = (function() {
  var $select = $('[store-extra-credit="status"]');
  var $input = $('[store-extra-credit="input"]');
  
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

var StoreProductTimeEndCommandsTable = (function() {
  var $tableitems = $("#storeProductTimeEndCommandsTable");
  
  if ($tableitems.length) {
    $tableitems.each(function() {
      $(this).tableitems();
	});
  }
})();

var StoreProductDiscount = (function() {
  var $select = $('[data-toggle="productDiscountStatus"]');
  var $input = $('[data-toggle="storeProductDiscountInput"]');
  
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

var StoreProductDiscount = (function() {
  var $select = $('[data-toggle="storeCouponCountType"]');
  var $input = $('[data-toggle="storeCouponCountInput"]');
  
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

var StoreProductCount = (function() {
  var $select = $('[data-toggle="productCountStatus"]');
  var $input = $('[data-toggle="storeProductCountInput"]');
  
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

var StoreProductTime = (function() {
  var $select = $('[data-toggle="storeProductTimeStatus"]');
  var $input = $('[data-toggle="storeProductTimeInput"]');
  
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

var StoreProductServerTypes = (function() {
  var $select = $('[data-toggle="productServerTypes"]');
  var $singleInput = $('[data-toggle="storeProductServerTypeOne"]');
  var $multipleInput = $('[data-toggle="storeProductServerTypeMultiple"]');
  
  $select.on("change", function() {
    var $status = $select.val();
    if ($status == "single") {
      $singleInput.css("display", "block");
      $multipleInput.css("display", "none");
    } else if ($status == "multiple") {
      $singleInput.css("display", "none");
      $multipleInput.css("display", "block");
    } else {
      $singleInput.css("display", "block");
      $multipleInput.css("display", "none");
    }
  });
})();

function storeCheckCategoryProduct()
{
    var $select = $('[data-toggle="categorySelect"]');
    var $productLoader = $('[data-toggle="productLoader"]');
    var $productSelect = $('[data-toggle="productSelect"]');
    var $categoryID = $select.val();
    
    $productSelect.css("display", "none");
    $productLoader.css("display", "block");
    
    if ($categoryID >= 0) {
      $.ajax({
        type: "POST",
        url: "/admin/libs/includes/packages/ajax/products.php",
        data: {categoryID: $categoryID},
        success: function(result) {
          $productSelect.html(result);
          $productSelect.css("display", "block");
          $productLoader.css("display", "none");
        }
	  });
    }
}

var CheckServerCategory = (function() {
  var $select = $('[data-toggle="productServerID"]');
  var $categoryLoader = $('[data-toggle="categoryLoader"]');
  
  if ($select.length) {
    $select.each(function() {
      $(this).on("change", function() {
        var $categorySelectName = $(this).attr("product-category-name");
        var $categorySelect = $('[product-category="' + $categorySelectName + '"]');
        var $serverID = $(this).val();
        $categorySelect.css("display", "none");
        $categoryLoader.css("display", "block");
        if ($serverID > 0) {
          $.ajax({
            type: "POST",
            url: "/admin/libs/includes/packages/ajax/categories.php",
            data: {serverID: $serverID},
            success: function(result) {
              $categorySelect.html(result);
              storeCheckCategoryProduct();
              $categorySelect.css("display", "block");
              $categoryLoader.css("display", "none");
            }
	      });
        }
      });
    });
  }
})();

var CheckCategoryProduct = (function() {
  var $categorySelect = $('[data-toggle="categorySelect"]');

  $categorySelect.on("change", function() {
    storeCheckCategoryProduct();
  });
})();

$("#serverConnectControl").on("click", function() {
  var $connectButton, $connectIP, $connectPort, $connectPassword, $connectType, $successAlert, $errorAlert, $ajaxUrl;
  
  // DATA
  $ajaxUrl = "/admin/libs/includes/packages/ajax/server.php?action=connect";
  $successAlert = $("#connectAlertSuccess");
  $errorAlert = $("#connectAlertError");
  $connectButton = $("#serverConnectControl");
  
  // DATA
  $connectIP = $('[data-toggle="connectIP"]').val();
  $connectPort = $('[data-toggle="connectPort"]').val();
  $connectPassword = $('[data-toggle="connectPassword"]').val();
  $connectType = $('[data-toggle="connectType"]').val();
  
  $connectButton.html("<span class=\"spinner-border spinner-border-sm\" role=\"status\" aria-hidden=\"true\"></span><span class=\"sr-only\">" + $languages["controlLoading"] + "</span>").addClass("disabled").attr("disabled", "disabled").css("cursor", "no-drop");
  
  // INIT
  $.ajax({
    type: "POST",
    url: $ajaxUrl,
    data: {connectIP: $connectIP, connectPort: $connectPort, connectPassword: $connectPassword, connectType: $connectType},
    success: function(result) {
      var ajaxData = JSON.parse(result);
      if (ajaxData.code == "__SUCCESSYFULL__") {
        $successAlert.css("display", "block");
        $errorAlert.css("display", "none");
        $connectButton.html($languages["success"]).removeClass("disabled").removeAttr("disabled", "disabled").css("cursor", "pointer");
      } else {
        $errorAlert.css("display", "block");
        $successAlert.css("display", "none");
        $connectButton.html(ajaxData.reason).removeClass("disabled").removeAttr("disabled", "disabled").css("cursor", "pointer");
      }
    }
  });
});