<?php
AccountLoginControl(false);
$shoppingCart = $db->prepare("SELECT * FROM shoppingCart WHERE userID = ? ORDER BY id ASC");
$shoppingCart->execute(array($readAccount["id"]));
$searchCouponHistory = $db->prepare("SELECT * FROM discountCouponHistory WHERE userID = ? AND status = ?");
$searchCouponHistory->execute(array($readAccount["id"], 0));
if ($shoppingCart->rowCount() > 0) {
  if ($searchCouponHistory->rowCount() > 0) {
    $readCouponHistory = $searchCouponHistory->fetch();
    $searchCoupon = $db->prepare("SELECT * FROM discountCoupon WHERE id = ? AND type = ?");
    $searchCoupon->execute(array($readCouponHistory["couponID"], 1));
    if ($searchCoupon->rowCount() > 0) {
      $readCoupon = $searchCoupon->fetch();
      $couponDiscount = (100-$readCoupon["discount"])/100;
    } else {
      $couponDiscount = 0;
    }
  } else {
    $couponDiscount = 0;
  }
} else {
  $couponDiscount = 0;
}
?>
<div class="container-fluid">
  <div class="row">
    <div class="col-12 p-0">
      <div class="container">
        <div class="row">
          <div class="col-12">
            <nav aria-label="breadcrumb" class="pt-lg-5 pt-4">
              <ol class="breadcrumb rounded-none bg-dark--5 font-size-6">
                <li class="breadcrumb-item"><a href="<?php echo urlConverter("home", $languageType); ?>" class="text-white font-100"><?php echo languageVariables("home", "words", $languageType); ?></a></li>
                <li class="breadcrumb-item active" aria-current="page"><?php echo languageVariables("cart", "words", $languageType); ?></li>
              </ol>
            </nav>
          </div>
          <div class="col-12 col-lg-8 pb-5 pt-3">
            <div class="products bg-dark--3 p-5">
              <h3 class="text-secondary mb-3 font-100 font-size-6 letter-spacing-1 text-uppercase">
                <strong><?php echo languageVariables("cart", "words", $languageType); ?></strong> (<?php echo $shoppingCart->rowCount(); ?>)
              </h3>
              <?php
                require_once(__DR__."/main/includes/packages/class/csrf/class.php");
                $safeCsrfToken = new CSRF('csrf-sessions', 'csrf-token');
                if (isset($_POST["checkPromo"])) {
                  if ($safeCsrfToken->validate('checkPromoToken')) {
                    if (post("promo-code") !== "") {
                      $searchCoupons = $db->prepare("SELECT * FROM discountCoupon WHERE code = ? AND type = ?");
                      $searchCoupons->execute(array(post("promo-code"), 1));
                      if ($searchCoupons->rowCount() > 0) {
                        $readCoupons = $searchCoupons->fetch();
                        $searchCouponHistorys = $db->prepare("SELECT * FROM discountCouponHistory WHERE userID = ? AND couponID = ?");
                        $searchCouponHistorys->execute(array($readAccount["id"], $readCoupons["id"]));
                        if ($searchCouponHistorys->rowCount() == 0) {
                          $couponCount = $db->prepare("SELECT * FROM discountCouponHistory WHERE couponID = ?");
                          $couponCount->execute(array($readCoupons["id"]));
                          if ($readCoupons["couponCount"] > $couponCount->rowCount() || $readCoupons["couponCount"] == "0-0-0-0") {
                            if ($shoppingCart->rowCount() > 0) {
                              $insertCouponHistory = $db->prepare("INSERT INTO discountCouponHistory SET userID = ?, couponID = ?, status = ?, date = ?");
                              $insertCouponHistory->execute(array($readAccount["id"], $readCoupons["id"], 0, date("d.m.Y H:i:s")));
                              echo alert(str_replace(["&coupon", "&discount"], [post("promo-code"), $readCoupons["discount"]], languageVariables("couponAlertSuccess", "shopping-cart", $languageType)), "success", "2", "");
                            } else {
                              echo alert(languageVariables("couponAlertNotProduct", "shopping-cart", $languageType), "danger", "0", "/");
                            }
                          } else {
                            echo alert(languageVariables("couponAlertNotCount", "shopping-cart", $languageType), "danger", "0", "/");
                          }
                        } else {
                          echo alert(languageVariables("couponAlertAlready", "shopping-cart", $languageType), "danger", "0", "/");
                        }
                      } else {
                        echo alert(languageVariables("couponAlertNotCart", "shopping-cart", $languageType), "danger", "0", "/");
                      }
                    } else {
                      echo alert(languageVariables("couponAlertNone", "shopping-cart", $languageType), "warning", "0", "/");
                    }
                  } else {
                    echo alert(languageVariables("couponAlertSystem", "shopping-cart", $languageType), "danger", "0", "/");
                  }
                } else if (isset($_POST["removePromo"])) {
                  if ($safeCsrfToken->validate('removePromoToken')) {
                    if (post("remove-id") !== "") {
                      $searchCouponHistorys = $db->prepare("SELECT * FROM discountCouponHistory WHERE userID = ? AND id = ? AND status = ?");
                      $searchCouponHistorys->execute(array($readAccount["id"], post("remove-id"), 0));
                        if ($searchCouponHistorys->rowCount() > 0) {
                          $deletePromo = $db->prepare("DELETE FROM discountCouponHistory WHERE userID = ? AND id = ? AND status = ?");
                          $deletePromo->execute(array($readAccount["id"], post("remove-id"), 0));
                          echo alert(str_replace("&coupon", post("promo-code"), languageVariables("couponAlertRemove", "shopping-cart", $languageType)), "success", "2", "");
                        } else {
                          echo alert(languageVariables("couponAlertNotCoupon", "shopping-cart", $languageType), "danger", "0", "/");
                        }
                      } else {
                        echo alert(languageVariables("couponAlertNotCoupon", "shopping-cart", $languageType), "warning", "0", "/");
                      }
                    } else {
                      echo alert(languageVariables("couponAlertSystem", "shopping-cart", $languageType), "danger", "0", "/");
                    }
                  }
                ?>
              <?php
                  if ($shoppingCart->rowCount() > 0) {
                    if ($searchCouponHistory->rowCount() > 0) {
                      if ($searchCoupon->rowCount() > 0) {
                        $promoStatus = "_TRUE_";
                      } else {
                        $promoStatus = "_FALSE_";
                      }
                    } else {
                      $promoStatus = "_FALSE_";
                    }
                  } else {
                    $promoStatus = "_FALSE_";
                  }
                ?>
              <?php if ($promoStatus == "_TRUE_") { ?>
              <form id="loader" class="card-body p-0" action="" method="POST">
                <div id="searchBox" class="input-group mb-3">
                  <div class="input-group flex-column bg-dark--5 border col-9 p-0 input-focused">
                    <label for="cart-coupon" class="o-100 d-block mb-0 text-white font-size-6 font-100 position-absolute" style="top: 17.5px; left: 22.5px;">
                      <i class="fas fa-gift fa-xs mr-1"></i> <?php echo languageVariables("couponCode", "words", $languageType); ?>
                    </label>
                    <input type="text" id="cart-coupon" placeholder="<?php echo languageVariables("couponCode", "words", $languageType); ?>" class="form-control pt-4 text-white font-size-7 py-2 w-100 font-100 rounded-none" name="promo-code" aria-label="Kup<?php echo languageVariables("couponCode", "words", $languageType); ?>on" aria-describedby="cart-coupon" value="<?php echo $readCoupon["code"]; ?>" readonly>
                  </div>
                  <input type="hidden" name="remove-id" value="<?php echo $readCouponHistory["id"]; ?>">
                  <div class="col-3 pr-0">
                    <?php echo $safeCsrfToken->input("removePromoToken"); ?>
                    <button type="submit" id="ariaSearch" class="h-100 w-100 btn-outline-primary p-5 btn text-white m-0 line-height-1 text-uppercase letter-spacing-1 font-100 font-size-6" name="removePromo">
                      <i class="fas fa-times fa-xs mr-1"></i>
                      <span class="btn-text d-none d-sm-block">
                      <?php echo languageVariables("remove", "words", $languageType); ?>
                      </span>
                    </button>
                  </div>
                </div>
              </form>
              <?php } else { ?>
              <form id="loader" class="card-body p-0" action="" method="POST">
                <div id="searchBox" class="input-group mb-3">
                  <div class="input-group flex-column bg-dark--5 border col-9 p-0 <?php if (isset($_POST["promo-code"])) { echo "input-focused"; } ?></div>">
                    <label for="cart-coupon" class="o-100 d-block mb-0 text-white font-size-6 font-100 position-absolute" style="top: 17.5px; left: 22.5px;">
                      <i class="fas fa-gift fa-xs mr-1"></i> <?php echo languageVariables("couponCode", "words", $languageType); ?>
                    </label>
                    <input type="text" id="cart-coupon" placeholder="<?php echo languageVariables("couponCode", "words", $languageType); ?>" class="form-control pt-4 text-white font-size-7 py-2 w-100 font-100 rounded-none" name="promo-code" aria-label="Ku<?php echo languageVariables("couponCode", "words", $languageType); ?>pon" aria-describedby="cart-coupon" value="<?php if (isset($_POST["promo-code"])) { echo post("promo-code"); } ?>">
                  </div>
                  <div class="col-3 pr-0">
                    <?php echo $safeCsrfToken->input("checkPromoToken"); ?>
                    <button type="submit" id="ariaSearch" class="h-100 w-100 btn-outline-primary p-5 btn text-white m-0 line-height-1 text-uppercase letter-spacing-1 font-100 font-size-6" name="checkPromo">
                      <i class="fas fa-arrow-right fa-xs mr-1"></i>
                      <span class="btn-text d-none d-sm-block">
                      <?php echo languageVariables("check", "words", $languageType); ?>
                      </span>
                    </button>
                  </div>
                </div>
              </form>
              <?php } ?>
              <?php if ($shoppingCart->rowCount() > 0) { ?>
              <div class="tab-content">
                <div class="overflow-auto">
                  <div class="table-responsive">
                    <table class="default-table w-100 table table-hover mb-0">
                      <thead class="bg-dark--5">
                        <tr class="text-secondary font-size-6">
                          <th class="font-100 p-3 line-height-1 w-40 border-0 pl-4 "><?php echo languageVariables("product", "words", $languageType); ?></th>
                          <th class="font-100 p-3 line-height-1 w-15 border-0"><?php echo languageVariables("duration", "words", $languageType); ?></th>
                          <th class="font-100 p-3 line-height-1 w-15 border-0"><?php echo languageVariables("count", "words", $languageType); ?></th>
                          <th class="font-100 p-3 line-height-1 w-15 border-0"><?php echo languageVariables("countPrice", "words", $languageType); ?></th>
                          <th class="font-100 p-3 line-height-1 w-15 border-0"><?php echo languageVariables("totalAmount", "words", $languageType); ?></th>
                          <th class="font-100 p-3 line-height-1 w-15 border-0"></th>
                        </tr>
                      </thead>
                      <tbody class="bg-dark--4">
                      <?php
                        foreach ($shoppingCart as $readShoppingCarts) {
                          $cartProducts = $db->prepare("SELECT * FROM categoryProduct WHERE id = ?");
                          $cartProducts->execute(array($readShoppingCarts["productID"]));
                          if ($cartProducts->rowCount() > 0) {
                            $readCartProducts = $cartProducts->fetch();
                            $cartProductServers = $db->prepare("SELECT * FROM serverList WHERE id = ?");
                            $cartProductServers->execute(array($readCartProducts["serverID"]));
                            $readCartProductServers = $cartProductServers->fetch();
                            $cartProductCategorys = $db->prepare("SELECT * FROM serverList WHERE id = ?");
                            $cartProductCategorys->execute(array($readCartProducts["categoryID"]));
                            $readCartProductCategorys = $cartProductCategorys->fetch();
                            if ($readCartProducts["productType"] == 1 && $readCartProducts["productDiscount"] > 0) {
                              $productDiscount = floor($readCartProducts["price"]*(100-$readCartProducts["productDiscount"])/100);
                              $readCartProducts["price"] = "<del style=\"color: #fe2203;\">".number_format($readCartProducts["price"],2)."</del> ".number_format($productDiscount,2);
                            }  else if ($readModule["storeDiscountStatus"] == "1" && $readModule["storeDiscount"] > 0) {
                              $productDiscount = floor($readCartProducts["price"]*(100-$readModule["storeDiscount"])/100);
                              $readCartProducts["price"] = "<del style=\"color: #fe2203;\">".number_format($readCartProducts["price"],2)."</del> ".number_format($productDiscount,2);
                            } else {
                              $productDiscount = $readCartProducts["price"];
                            }
                      ?>
                        <tr class="text-white font-size-7">
                          <td class="p-3 border-bottom font-100 line-height-1 w-40 text-nowrap text-white">
                            <img class="rounded-circle mr-2" src="<?php echo $readCartProducts["image"]; ?>" alt="Sepet - <?php echo $readCartProducts["name"]; ?>" width="40" height="40">
                            <a class="text-white" rel="external" href="<?php echo urlConverter("store", $languageType)."/".createSlug($readCartProductServers["name"])."/".(($readCartProducts["categoryID"] == "0") ? "kategorisiz" : createSlug($readCartProductCategorys["name"]))."/".createSlug($readCartProducts["name"])."/".$readCartProducts["id"]; ?>"><?php echo $readCartProducts["name"]; ?></a>
                          </td>
                          <td style="vertical-align: middle;" class="p-3 border-bottom font-100 line-height-1 w-15 text-nowrap text-truncate align-middle"><?php if ($readCartProducts["productTime"] > 0) { echo $readCartProducts["productTime"]." Gün"; } else { echo "Sınırsız"; } ?></td>
                          <td style="vertical-align: middle;" class="p-3 border-bottom font-100 line-height-1 w-15 text-nowrap text-truncate align-middle"><?php echo $readShoppingCarts["productCount"]; ?></td>
                          <td style="vertical-align: middle;" class="p-3 border-bottom font-100 line-height-1 w-15 text-nowrap text-truncate align-middle turkish-lira"><?php echo $readCartProducts["price"]; ?></td>
                          <td style="vertical-align: middle;" class="p-3 border-bottom font-100 line-height-1 w-15 text-nowrap text-truncate align-middle turkish-lira"><?php echo number_format($productDiscount*$readShoppingCarts["productCount"],2); ?></td>
                          <td style="vertical-align: middle;" class="p-3 border-bottom font-100 pr-4 line-height-1 w-10 text-right align-middle">
                            <div class=" d-flex align-items-center justify-content-end">
                              <a data-toggle="tooltip" data-placement="top" title="" class="mr-2" data-original-title="<?php echo languageVariables("removeProduct", "words", $languageType); ?>" onclick="shoppingCartDelete('<?php echo $readShoppingCarts["id"]; ?>');">
                                <i class="fas fa-times-circle text-danger"></i>
                              </a>
                            </div>
                          </td>
                        </tr>
                        <?php $totalPrice = $totalPrice + ($readCartProducts["price"]*$readShoppingCarts["productCount"]); ?>
                      <?php } } ?>
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
              <?php } else { echo alert(languageVariables("cartQueryAlert", "shopping-cart", $languageType), "warning", "0", "/"); } ?>
            </div>
          </div>
          <div class="col-12 col-lg-4 pb-5 pt-3">
            <div class="bg-dark--3  px-5 pt-5 text-white border-0 rounded-none">
              <div class="modal-header p-0 border-0 flex-column mb-3">
                <h5 class="modal-title o-25 mb-3 text-uppercase font-size-6 font-800 letter-spacing-1"><?php echo languageVariables("cartInfo", "words", $languageType); ?></h5>
                <h3 class="modal-title mb-3 text-white font-size-16 font-1000 turkish-lira" style="margin-left: 5rem;"><?php if ($couponDiscount !== 0) { echo number_format($totalPrice*$couponDiscount,2); } else { echo number_format($totalPrice,2); } ?></h1>
                <table class="info-table w-100">
                  <tbody>
                    <tr class="border-bottom font-100">
                      <th class="font-size-7 font-100 py-3"><?php echo languageVariables("totalAmount", "words", $languageType); ?>:</th>
                      <td class="text-right font-size-9 turkish-lira">
                        <?php echo number_format($totalPrice,2); ?>
                      </td>
                    </tr>
                    <tr class="font-100">
                      <th class="font-size-7 font-100 py-3"><?php echo languageVariables("couponDiscount", "words", $languageType); ?>:</th>
                      <td class="text-right font-size-9 text-danger turkish-lira">
                        <?php if ($couponDiscount !== 0) { echo number_format($totalPrice-($totalPrice*$couponDiscount),2); } else { echo number_format("0",2); } ?>
                      </td>
                    </tr>
                  </tbody>
                </table>
              </div>
              <div class="modal-footer border-0 p-0 justify-content-start">
                <h5 class="modal-title o-25 m-0 mb-0 text-uppercase font-size-6 font-800 letter-spacing-1"><?php echo languageVariables("payment", "words", $languageType); ?></h5>
                <table class="info-table w-100 m-0 mb-4">
                  <tbody>
                    <tr class="font-100 border-bottom last-price">
                      <th class="font-size-7 font-100 pt-2 pb-3 pt-0"><?php echo languageVariables("payAmount", "words", $languageType); ?>:</th>
                      <td class="text-right font-size-9 turkish-lira">
                        <?php if ($couponDiscount !== 0) { echo number_format($totalPrice*$couponDiscount,2); } else { echo number_format($totalPrice,2); } ?>
                      </td>
                    </tr>
                  </tbody>
                </table>
              </div>
            </div>
            <div class="d-flex bg-dark--5 p-3 justify-content-center m-auto">
              <?php if ($shoppingCart->rowCount() > 0) { ?>
              <a class="h-100 w-100 btn-outline-primary p-5 btn text-white m-0 line-height-1 text-uppercase letter-spacing-1 font-100 font-size-6" data-toggle="tooltip" data-placement="top" title="Ödeme Yap" onclick="shoppingCartPay('<?php if ($couponDiscount !== 0) { echo $totalPrice*$couponDiscount; } else { echo $totalPrice; } ?>');">
                <i class="fas fa-arrow-right text-white mr-2"></i> <?php echo languageVariables("payCheck", "words", $languageType); ?>
              </a>
              <?php } else { ?>
              <a class="h-100 w-100 btn-outline-primary p-5 btn text-white m-0 line-height-1 text-uppercase letter-spacing-1 font-100 font-size-6" data-toggle="tooltip" data-placement="top" title="Mağazaya Git" href="<?php echo urlConverter("store", $languageType); ?>">
                <i class="fas fa-store text-white mr-2"></i> <?php echo languageVariables("goStore", "words", $languageType); ?>
              </a>
              <?php } ?>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>