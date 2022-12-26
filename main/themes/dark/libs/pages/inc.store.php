<?php if (isset($_GET["productID"])) { ?>
<?php
$searchProduct = $db->prepare("SELECT * FROM categoryProduct WHERE id = ? AND (status = ? OR status = ?)");
$searchProduct->execute(array(get("productID"), 1, 2));
if ($searchProduct->rowCount() > 0) {
  $readProduct = $searchProduct->fetch();
  $searchCategory = $db->prepare("SELECT * FROM serverCategory WHERE id = ? AND (status = ? OR status = ?)");
  $searchCategory->execute(array($readProduct["categoryID"], 1, 2));
  if ($searchCategory->rowCount() > 0 || $readProduct["categoryID"] == "0") {
    $readCategory = $searchCategory->fetch();
    $searchServer = $db->prepare("SELECT * FROM serverList WHERE id = ? AND (status = ? OR status = ?)");
    $searchServer->execute(array($readProduct["serverID"], 1, 2));
    if ($searchServer->rowCount() > 0) {
      $readServer = $searchServer->fetch();
      $countProductSales = $db->prepare("SELECT * FROM storeHistory WHERE productID = ?");
      $countProductSales->execute(array($readProduct["id"]));
      $countProductRates = $db->prepare("SELECT * FROM productRates WHERE productID = ?");
      $countProductRates->execute(array($readProduct["id"]));
      $searchProductPosters = $db->prepare("SELECT * FROM productPosters WHERE productID = ? ORDER BY id ASC");
      $searchProductPosters->execute(array($readProduct["id"]));
      if ($readProduct["productType"] == 1 && $readProduct["productDiscount"] > 0) {
        $productDiscount = floor($readProduct["price"]*(100-$readProduct["productDiscount"])/100);
        $readProduct["price"] = "<del style=\"color: #fe2203;\">".$readProduct["price"]."</del> ".$productDiscount;
      } else if ($readModule["storeDiscountStatus"] == "1" && $readModule["storeDiscount"] > 0) {
        $productDiscount = floor($readProduct["price"]*(100-$readModule["storeDiscount"])/100);
        $readProduct["price"] = "<del style=\"color: #fe2203;\">".$readProduct["price"]."</del> ".$productDiscount;
      }
?>
<style type="text/css">
@media (max-width: 1000px) {
  .swiper-slide.mobile-slider-st {
    height: 210px;
  }
}
</style>
<div class="container-fluid">
  <div class="row">
    <div class="col-12 p-0">
      <div class="container">
        <div class="row">
          <div class="col-12">
            <nav aria-label="breadcrumb" class="pt-lg-5 pt-4">
              <ol class="breadcrumb rounded-none bg-dark--5 font-size-6">
                <li class="breadcrumb-item"><a href="<?php echo urlConverter("home", $languageType); ?>" class="text-white font-100"><?php echo languageVariables("home", "words", $languageType); ?></a></li>
                <li class="breadcrumb-item"><a href="<?php echo urlConverter("store", $languageType); ?>" class="text-white font-100"><?php echo languageVariables("store", "words", $languageType); ?></a></li>
                <li class="breadcrumb-item"><a href="<?php echo urlConverter("store", $languageType); ?>/<?php echo createSlug($readServer["name"])."/".$readServer["id"]; ?>" class="text-white font-100"><?php echo $readServer["name"]; ?></a></li>
                <li class="breadcrumb-item"><a href="<?php echo urlConverter("store", $languageType); ?>/<?php echo (($readProduct["categoryID"] == "0") ? createSlug($readServer["name"])."/".$readServer["id"] : createSlug($readServer["name"])."/".createSlug($readCategory["name"])."/".$readCategory["id"]); ?>" class="text-white font-100"><?php echo (($readProduct["categoryID"] == "0") ? languageVariables("notCategory", "words", $languageType) : $readCategory["name"]); ?></a></li>
                <li class="breadcrumb-item active" aria-current="page"><?php echo $readProduct["name"]; ?></li>
              </ol>
            </nav>
          </div>
          <div class="col-lg-8 col-12 pb-5 pt-3">
            <?php if ($readProduct["posters"] == 1) { ?>
            <div id="carouselSlider" class="swiper-container hero-swiper swiper-initialized swiper-horizontal swiper-pointer-events swiper-backface-hidden">
              <div class="swiper-wrapper" id="swiper-wrapper-5c75a11afdea79ef" aria-live="off" style="transition-duration: 0ms; transform: translate3d(-839px, 0px, 0px);">
                <?php foreach ($searchProductPosters as $productPoster) { ?>
                <div class="swiper-slide position-relative mobile-slider-st" style="background: linear-gradient(rgba(25, 25, 25, 0.9) 0%, rgba(25, 25, 25, 0.9) 100%), url('<?php echo $productPoster["image"]; ?>'); background-size: 100%;" data-swiper-slide-index="0" role="group" aria-label="1 / 1">
                </div>
                <?php } ?>
              </div>
              <div class="swiper-pagination-wrapper position-relative bg-dark--3 p-2 w-100 d-flex align-items-center justify-content-between justify-content-lg-center">
                <div class="swiper-button-prev position-relative mt-0 mr-lg-3 ml-3 text-white d-flex align-items-center" tabindex="0" role="button" aria-label="Previous slide" aria-controls="swiper-wrapper-5c75a11afdea79ef">
                  <i class="fas fa-arrow-left fa-xs mr-2"></i>
                  <span class="text-uppercase font-100 line-height-1 mt-1 o-50"><?php echo languageVariables("prev", "words", $languageType); ?></span>
                </div>
                <div class="swiper-pagination position-relative font-900 line-height-1 p-2 mt-1 px-3 d-flex align-items-center text-white d-block swiper-pagination-clickable swiper-pagination-bullets swiper-pagination-horizontal"><span class="swiper-pagination-bullet swiper-pagination-bullet-active" tabindex="0" aria-current="true">01</span></div>
                <div class="swiper-button-next position-relative mt-0 ml-lg-3 mr-3 text-white d-flex align-items-center" tabindex="0" role="button" aria-label="Next slide" aria-controls="swiper-wrapper-5c75a11afdea79ef">
                  <span class="text-uppercase font-100 line-height-1 mt-1 o-50"><?php echo languageVariables("next", "words", $languageType); ?></span>
                  <i class="fas fa-arrow-right fa-xs ml-2"></i>
                </div>
              </div>
              <span class="swiper-notification" aria-live="assertive" aria-atomic="true"></span>
            </div>
            <?php } ?>
            <div class="blog-info border-top text-white font-size-7 font-100 bg-dark--5 px-5 py-3 line-height-1 d-flex flex-sm-row flex-column justify-content-center justify-content-sm-between">
              <div class="details">
                <span class="category font-size-6 font-800 text-uppercase letter-spacing-1 mr-4" lang="en">
                  <?php echo $readProduct["name"]; ?> 
                </span>
                <span class="comment font-size-6">
                  <i class="fas fa-shopping-bag fa-xs mr-1 o-75"></i>
                  <span><?php echo $countProductSales->rowCount(); ?></span>
                </span>
                <span class="comment font-size-6 ml-2">
                  <i class="fas fa-star fa-xs mr-1 o-75"></i>
                  <span><?php echo $countProductRates->rowCount(); ?></span>
                </span>
              </div>
              <div class="date p-0 m-0 o-50 mt-sm-0 mt-2">
                <span><?php echo checkTime($readProduct["date"], 2, true); ?></span>
              </div>
            </div>
            <div class="blog-body text-white font-size-7 font-100 bg-dark--3">
              <div class="block p-5">
                <p class="text-secondary">
                </p>
                <?php echo $readProduct["text"]; ?>
              </div>
            </div>
          </div>
          <div class="col-lg-4 col-12 pb-5 pt-3">
            <div class="bg-dark--3  px-5 pt-5 text-white border-0 rounded-none">
              <div class="modal-header p-0 border-0 flex-column mb-3">
                <h5 class="modal-title o-25 mb-3 text-uppercase font-size-6 font-800 letter-spacing-1"><?php echo languageVariables("productInfo", "words", $languageType); ?></h5>
                <table class="info-table w-100">
                  <tbody>
                    <tr class="border-bottom font-100">
                      <th class="font-size-7 font-100 py-3"><?php echo languageVariables("product", "words", $languageType); ?>:</th>
                      <td class="text-right font-size-9">
                        <?php echo $readProduct["name"]; ?> 
                      </td>
                    </tr>
                    <tr class="border-bottom font-100">
                      <th class="font-size-7 font-100 py-3"><?php echo languageVariables("server", "words", $languageType); ?>:</th>
                      <td class="text-right font-size-9">
                        <a href="<?php echo urlConverter("store", $languageType); ?>/<?php echo createSlug($readServer["name"])."/".$readServer["id"]; ?>"><?php echo $readServer["name"]; ?></a>
                      </td>
                    </tr>
                    <tr class="border-bottom font-100">
                      <th class="font-size-7 font-100 py-3"><?php echo languageVariables("category", "words", $languageType); ?>:</th>
                      <td class="text-right font-size-9">
                        <?php if ($readProduct["categoryID"] > 0) { ?><a href="<?php echo urlConverter("store", $languageType); ?>/<?php echo createSlug($readServer["name"])."/".createSlug($readCategory["name"])."/".$readCategory["id"]; ?>"><?php echo $readCategory["name"]; ?></a><?php } else { ?><?php echo languageVariables("notCategory", "words", $languageType); ?><?php } ?>
                      </td>
                    </tr>
                    <tr class="border-bottom font-100">
                      <th class="font-size-7 font-100 py-3"><?php echo languageVariables("price", "words", $languageType); ?>:</th>
                      <td class="text-right font-size-9">
                        <?php echo $readProduct["price"]." ".languageVariables("credi", "words", $languageType); ?>
                      </td>
                    </tr>
                    <tr class="border-bottom font-100">
                      <th class="font-size-7 font-100 py-3"><?php echo languageVariables("duration", "words", $languageType); ?>:</th>
                      <td class="text-right font-size-9">
                        <?php if ($readProduct["productTime"] > 0) { echo $readProduct["productTime"]." ".languageVariables("day", "words", $languageType); } else { echo languageVariables("indefinite", "words", $languageType); } ?>
                      </td>
                    </tr>
                    <?php $searchProductStockHistory = $db->prepare("SELECT * FROM productStockHistory WHERE productID = ?"); ?>
                    <?php $searchProductStockHistory->execute(array($readProduct["id"])); ?>
                    <tr class="border-bottom font-100">
                      <th class="font-size-7 font-100 py-3"><?php echo languageVariables("stock", "words", $languageType); ?>:</th>
                      <td class="text-right font-size-9">
                      <?php 
                        if ($readProduct["productCount"] > 0) { 
                            $productCountPiece = $readProduct["productCount"] - $searchProductStockHistory->rowCount(); 
                            echo (($productCountPiece == "0") ? languageVariables("soldOut", "words", $languageType) : $productCountPiece." ".languageVariables("count", "words", $languageType)); 
                        } else { 
                            echo languageVariables("unlimited", "words", $languageType); 
                        } 
                      ?>
                      </td>
                    </tr>
                    <tr class="font-100">
                      <th class="font-size-7 font-100 py-3"><?php echo languageVariables("publishDate", "words", $languageType); ?>:</th>
                      <td class="text-right font-size-9">
                        <?php echo checkTime($readProduct["date"], 2, true); ?>
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
                      <td class="text-right font-size-9">
                        <?php echo $readProduct["price"]." ".languageVariables("credi", "words", $languageType); ?>
                      </td>
                    </tr>
                  </tbody>
                </table>
              </div>
            </div>
            <div class="d-flex bg-dark--5 p-3 justify-content-center m-auto">
              <a class="dropdown-item btn-outline-primary mr-2 py-4 w-50 d-flex align-items-center flex-column" data-toggle="tooltip" data-placement="top" title="<?php echo languageVariables("buy", "words", $languageType); ?>" onclick="store('directBuy', '<?php echo $readProduct["id"]; ?>');">
                <i class="fas fa-store text-white fa-lg"></i>
              </a>
              <a class="dropdown-item btn-outline-primary mr-2 py-4 w-50 d-flex align-items-center flex-column" data-toggle="tooltip" data-placement="top" title="<?php echo languageVariables("shoppingCartAdd", "words", $languageType); ?>" onclick="store('addCart', '<?php echo $readProduct["id"]; ?>');">
                <i class="fas fa-shopping-bag text-white fa-lg"></i>
              </a>
              <a class="dropdown-item btn-outline-primary py-4 w-50 d-flex align-items-center flex-column" data-toggle="tooltip" data-placement="top" title="<?php echo languageVariables("starAdd", "words", $languageType); ?>" onclick="store('starVote', '<?php echo $readProduct["id"]; ?>');">
                <i class="fas fa-star text-white fa-lg"></i>
              </a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<?php } else { go(urlConverter("store", $languageType)); } ?>
<?php } else { go(urlConverter("store", $languageType)); } ?>
<?php } else { go(urlConverter("store", $languageType)); } ?>
<?php } else if (isset($_GET["categoryID"])) { ?>
<?php
$searchCategory = $db->prepare("SELECT * FROM serverCategory WHERE id = ? AND (status = ? OR status = ?)");
$searchCategory->execute(array(get("categoryID"), 1, 2));
if ($searchCategory->rowCount() > 0) {
  $readCategory = $searchCategory->fetch();
  $searchServer = $db->prepare("SELECT * FROM serverList WHERE id = ? AND (status = ? OR status = ?)");
  $searchServer->execute(array($readCategory["serverID"], 1, 2));
  if ($searchServer->rowCount() > 0) {
    $readServer = $searchServer->fetch();
?>
<?php $searchServerF = $db->prepare("SELECT * FROM serverList WHERE status = ? ORDER BY id ASC"); ?>
<?php $searchServerF->execute(array(1)); ?>
<?php $searchCategoryF = $db->prepare("SELECT * FROM serverCategory WHERE serverID = ? AND status = ? ORDER BY id ASC"); ?>
<?php $searchCategoryF->execute(array($readCategory["serverID"], 1)); ?>
<div class="container-fluid">
  <div class="row">
    <div class="col-12 p-0">
      <div class="container">
        <div class="row">
          <div class="col-12">
            <nav aria-label="breadcrumb" class="pt-lg-5 pt-4">
              <ol class="breadcrumb rounded-none bg-dark--5 font-size-6">
                <li class="breadcrumb-item"><a href="<?php echo urlConverter("home", $languageType); ?>" class="text-white font-100"><?php echo languageVariables("home", "words", $languageType); ?></a></li>
                <li class="breadcrumb-item"><a href="<?php echo urlConverter("store", $languageType); ?>" class="text-white font-100"><?php echo languageVariables("store", "words", $languageType); ?></a></li>
                <li class="breadcrumb-item"><a href="<?php echo urlConverter("store", $languageType); ?>/<?php echo createSlug($readServer["name"])."/".$readServer["id"]; ?>" class="text-white font-100"><?php echo $readServer["name"]; ?></a></li>
                <li class="breadcrumb-item active" aria-current="page"><?php echo $readCategory["name"]; ?></li>
              </ol>
            </nav>
          </div>
          <div class="col-lg-4 col-12 py-3">
            <div id="sidebar-wrapper">
              <div class="sidebar bg-dark--2 mb-4">
                <a href="<?php echo urlConverter("store", $languageType); ?>" class="text-white px-5 py-3 d-flex justify-content-center w-100 align-items-center text-uppercase font-size-7" data-toggle="tooltip" data-placement="top" title="<?php echo languageVariables("back", "words", $languageType); ?>">
                  <i class="fas fa-xs fa-arrow-left"></i>
                </a>
              </div>
              <div class="sidebar bg-dark--3 p-5 mb-4">
                <h2 class="text-white font-size-9 col-12 p-0 mb-3">
                  <span class="font-800">
                  <?php echo languageVariables("gameTypes", "words", $languageType); ?>
                  </span>
                </h2>
                <ul class="navbar-nav sidebar-nav">
                  <?php if ($searchServerF->rowCount() > 0) { ?>
                  <?php foreach ($searchServerF as $readServerF) { ?>
                  <?php $countProduct = $db->prepare("SELECT * FROM categoryProduct WHERE serverID = ?"); ?>
                  <?php $countProduct->execute(array($readServerF["id"])); ?>
                  <li class="nav-item bg-dark--2 mb-2">
                    <a href="<?php echo urlConverter("store", $languageType); ?>/<?php echo createSlug($readServerF["name"])."/".$readServerF["id"]; ?>" class="nav-link p-3 px-4 font-100 text-white d-flex align-items-center justify-content-between w-100">
                      <span class="nav-link-text">
                      <?php echo $readServerF["name"]; ?>
                      </span>
                      <span class="product-count font-size-6 o-25 mt-1 position-relative">
                        <span class="number"><?php echo $countProduct->rowCount(); ?></span> <?php echo languageVariables("product", "words", $languageType); ?>
                      </span>
                    </a>
                  </li>
                  <?php } } else { echo alert(languageVariables("notServerAlert", "store", $languageType), "warning", "0", "/"); }?>
                </ul>
              </div>
              <?php if ($searchCategoryF->rowCount() > 1) { ?>
              <div class="sidebar bg-dark--3 p-5 mb-4">
                <h2 class="text-white font-size-9 col-12 p-0 mb-3">
                  <span class="font-800">
                  <?php echo $readServer["name"]; ?> - <?php echo languageVariables("category", "words", $languageType); ?>
                  </span>
                </h2>
                <ul class="navbar-nav sidebar-nav">
                  <?php if ($searchCategoryF->rowCount() > 0) { ?>
                  <?php foreach ($searchCategoryF as $readCategoryF) { ?>
                  <?php $countProductC = $db->prepare("SELECT * FROM categoryProduct WHERE categoryID = ?"); ?>
                  <?php $countProductC->execute(array($readCategoryF["id"])); ?>
                  <li class="nav-item bg-dark--2 mb-2">
                    <a href="<?php echo urlConverter("store", $languageType); ?>/<?php echo createSlug($readServer["name"])."/".createSlug($readCategoryF["name"])."/".$readCategoryF["id"]; ?>" class="nav-link p-3 px-4 font-100 text-white d-flex align-items-center justify-content-between w-100">
                      <span class="nav-link-text">
                      <?php echo $readCategoryF["name"]; ?>
                      </span>
                      <span class="product-count font-size-6 o-25 mt-1 position-relative">
                        <span class="number"><?php echo $countProductC->rowCount(); ?></span> <?php echo languageVariables("product", "words", $languageType); ?>
                      </span>
                    </a>
                  </li>
                  <?php } } else { echo alert(languageVariables("notCategoryAlert", "store", $languageType), "warning", "0", "/"); }?>
                </ul>
              </div>
              <?php } ?>
              <div class="sidebar filter-bar bg-dark--3 p-5">
                <h2 class="text-white font-size-9 col-12 p-0 mb-3">
                  <span class="font-800">
                    <?php echo languageVariables("filters", "words", $languageType); ?>
                  </span>
                </h2>
                <div class="input-group mb-2 flex-column bg-dark--5 border col-12 p-0">
                  <label for="filter-search" class="o-100 d-block mb-0 text-white font-size-6 font-100 position-absolute">
                    <i class="fas fa-xs mr-1 fa-search"></i>
                    <?php echo languageVariables("searchHolder", "words", $languageType); ?></label>
                  <input type="search" placeholder="Bir şeyler ara" class="form-control pt-4 text-white font-size-7 py-2 w-100 font-100 rounded-none" aria-label="Bir şeyler ara" id="filter-search" aria-describedby="filter-search">
                </div>
                <div class="input-group mb-1 flex-column bg-dark--3 border col-12 p-0 select-wrapper">
                  <label for="filter-type" class="o-100 d-block mb-0 text-white font-size-6 font-100 position-absolute"><?php echo languageVariables("filterType", "words", $languageType); ?></label>
                  <select class="js-select2 w-100" id="filter-type">
                    <option value=""></option>
                    <option value="newest"><?php echo languageVariables("topNew", "words", $languageType); ?></option>
                    <option value="most-expensive"><?php echo languageVariables("topExpensive", "words", $languageType); ?></option>
                    <option value="cheapest"><?php echo languageVariables("topCheap", "words", $languageType); ?></option>
                  </select>
                </div>
              </div>
            </div>
          </div>
          <div class="col-lg-8 col-12 pb-5 pt-3">
            <div class="products bg-dark--3 p-5">
              <h3 class="text-secondary mb-3 font-100 font-size-6 letter-spacing-1 text-uppercase">
              <?php echo languageVariables("products", "words", $languageType); ?>
              </h3>
              <div class="row filter-category">
              <?php $searchProduct = $db->prepare("SELECT * FROM categoryProduct WHERE categoryID = ? AND serverID = ? AND status = ? ORDER BY id ASC"); ?>
              <?php $searchProduct->execute(array($readCategory["id"], $readServer["id"], 1)); ?>
              <?php if ($searchProduct->rowCount() > 0) { ?>
              <?php foreach ($searchProduct as $readProduct) { ?>
              <?php
                if ($readProduct["productType"] == 1 && $readProduct["productDiscount"] > 0) {
                  $productDiscount = floor($readProduct["price"]*(100-$readProduct["productDiscount"])/100);
                  $readProduct["price"] = '<div class="pt-1"><span class="discount-percent font-800">%</span><del class="text-secondary turkish-lira">'.$readProduct["price"].'</del><span class="turkish-lira filter-item--price"> '.$productDiscount.'</span></div>';
                } else if ($readModule["storeDiscountStatus"] == "1" && $readModule["storeDiscount"] > 0) {
                  $productDiscount = floor($readProduct["price"]*(100-$readModule["storeDiscount"])/100);
                  $readProduct["price"] = '<div class="pt-1"><span class="discount-percent font-800">%</span><del class="text-secondary turkish-lira">'.$readProduct["price"].'</del><span class="turkish-lira filter-item--price"> '.$productDiscount.'</span></div>';
                } else {
                  $readProduct["price"] = '<div class="turkish-lira pt-1 filter-item--price">'.$readProduct["price"].'</div>';
                }
              ?>
                <div class="col-lg-4 col-md-6 col-12 py-3 filter-item mb-3">
                  <div class="product-box overflow-hidden p-3 bg-dark--4 position-relative">
                    <?php if ($readProduct["productCount"] > 0) { ?>
                    <div class="store-card-stock have-stock">
                        <div class="product-state position-absolute mb-4 d-flex align-items-start pr-2 pt-2 justify-content-end text-center text-body">
                            <i class="fas fa-xs fa-crown text-body"></i>
                        </div>
                    </div>
                    <?php } ?>
                    <div class="product-img position-relative mb-4 mt-4">
                      <img class="mx-auto js-mirror d-block" src="<?php echo $readProduct["image"]; ?>" alt="<?php echo languageVariables("store", "words", $languageType); ?> - <?php echo $readProduct["name"]; ?> <?php echo languageVariables("product", "words", $languageType); ?>">
                    </div>
                    <div class="product-title">
                      <h6 class="text-white font-100 font-size-8 text-center filter-item--name">
                      <?php echo $readProduct["name"]; ?> </h6>
                    </div>
                    <div class="product-price bg-dark--5 text-center text-white p-2 mb-1 font-size-6 font-100 filter-item--price">
                      <?php echo $readProduct["price"]; ?>
                    </div>
                    <a href="<?php echo urlConverter("store", $languageType); ?>/<?php echo createSlug($readServer["name"])."/".createSlug($readCategory["name"])."/".createSlug($readProduct["name"])."/".$readProduct["id"]; ?>" class="btn text-white w-100 col-12 line-height-1 text-uppercase letter-spacing-1 font-100 font-size-6 btn-outline-primary stretched-link">
                      <i class="fas fa-shopping-bag fa-sm mr-2 btn-icon"></i>
                      <span class="btn-text">
                      <?php echo languageVariables("buy", "words", $languageType); ?>
                      </span>
                    </a>
                  </div>
                </div>
              <?php } } else { echo alert(languageVariables("notCategoryAlert", "store", $languageType), "warning", "0", "/"); }?>
              </div>
              <?php if ($readModule["storeExProductStatus"] == "1") { ?>
              <?php $searchProducts = $db->prepare("SELECT * FROM categoryProduct WHERE serverID = ? AND categoryID = ? AND status = ? ORDER BY id DESC LIMIT 9"); ?>
              <?php $searchProducts->execute(array($readServer["id"], 0, 1)); ?>
              <h3 class="text-secondary mb-3 font-100 font-size-6 letter-spacing-1 text-uppercase">
                <?php echo languageVariables("notCategoryProduct", "words", $languageType); ?>
              </h3>
              <div class="row filter-category">
              <?php if ($searchProducts->rowCount() > 0) { ?>
              <?php foreach ($searchProducts as $readProducts) { ?>
              <?php
                if ($readProducts["productType"] == 1 && $readProducts["productDiscount"] > 0) {
                  $productDiscount = floor($readProducts["price"]*(100-$readProducts["productDiscount"])/100);
                  $readProducts["price"] = '<div class="pt-1"><span class="discount-percent font-800">%</span><del class="text-secondary turkish-lira">'.$readProducts["price"].'</del><span class="turkish-lira filter-item--price"> '.$productDiscount.'</span></div>';
                } else if ($readModule["storeDiscountStatus"] == "1" && $readModule["storeDiscount"] > 0) {
                  $productDiscount = floor($readProducts["price"]*(100-$readModule["storeDiscount"])/100);
                  $readProducts["price"] = '<div class="pt-1"><span class="discount-percent font-800">%</span><del class="text-secondary turkish-lira">'.$readProducts["price"].'</del><span class="turkish-lira filter-item--price"> '.$productDiscount.'</span></div>';
                } else {
                  $readProducts["price"] = '<div class="turkish-lira pt-1 filter-item--price">'.$readProducts["price"].'</div>';
                }
              ?>
                <div class="col-lg-4 col-md-6 col-12 py-3 filter-item mb-3">
                  <div class="product-box overflow-hidden p-3 bg-dark--4 position-relative">
                    <?php if ($readProducts["productCount"] > 0) { ?>
                    <div class="store-card-stock have-stock">
                        <div class="product-state position-absolute mb-4 d-flex align-items-start pr-2 pt-2 justify-content-end text-center text-body">
                            <i class="fas fa-xs fa-crown text-body"></i>
                        </div>
                    </div>
                    <?php } ?>
                    <div class="product-img position-relative mb-4 mt-4">
                      <img class="mx-auto js-mirror d-block" src="<?php echo $readProducts["image"]; ?>" alt="<?php echo languageVariables("store", "words", $languageType); ?> - <?php echo $readProducts["name"]; ?> <?php echo languageVariables("product", "words", $languageType); ?>">
                    </div>
                    <div class="product-title">
                      <h6 class="text-white font-100 font-size-8 text-center filter-item--name">
                      <?php echo $readProducts["name"]; ?> </h6>
                    </div>
                    <div class="product-price bg-dark--5 text-center text-white p-2 mb-1 font-size-6 font-100">
                      <?php echo $readProducts["price"]; ?>
                    </div>
                    <a href="<?php echo urlConverter("store", $languageType); ?>/<?php echo createSlug($readServer["name"])."/"."kategorisiz"."/".createSlug($readProducts["name"])."/".$readProducts["id"]; ?>" class="btn text-white w-100 col-12 line-height-1 text-uppercase letter-spacing-1 font-100 font-size-6 btn-outline-primary stretched-link">
                      <i class="fas fa-shopping-bag fa-sm mr-2 btn-icon"></i>
                      <span class="btn-text">
                      <?php echo languageVariables("buy", "words", $languageType); ?>
                      </span>
                    </a>
                  </div>
                </div>
              <?php } } else { echo alert(languageVariables("serverNotCategoryProductAlert", "store", $languageType), "warning", "0", "/"); }?>
              </div>
              <?php } ?>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<?php } else { go(urlConverter("store", $languageType)); } ?>
<?php } else { go(urlConverter("store", $languageType)); } ?>
<?php } else if (isset($_GET["serverID"])) { ?>
<?php
$searchServer = $db->prepare("SELECT * FROM serverList WHERE id = ? AND (status = ? OR status = ?)");
$searchServer->execute(array(get("serverID"), 1, 2));
if ($searchServer->rowCount() > 0) {
  $readServer = $searchServer->fetch();
  $searchCategory = $db->prepare("SELECT * FROM serverCategory WHERE serverID = ? AND status = ? ORDER BY id ASC");
  $searchCategory->execute(array($readServer["id"], 1));
  if ($searchCategory->rowCount() == "1") {
    $readCategory = $searchCategory->fetch();
    $searchQueryProduct = $db->prepare("SELECT * FROM categoryProduct WHERE categoryID = ? AND status = ?");
    $searchQueryProduct->execute(array(0, 1));
    if ($readModule["storeExProductStatus"] == "0") {
      go(urlConverter("store", $languageType)."/".createSlug($readServer["name"])."/".createSlug($readCategory["name"])."/".$readCategory["id"]);
    } else {
      if ($searchQueryProduct->rowCount() == "0") {
        go(urlConverter("store", $languageType)."/".createSlug($readServer["name"])."/".createSlug($readCategory["name"])."/".$readCategory["id"]);
      }
    }
  }
?>
<?php $searchServerF = $db->prepare("SELECT * FROM serverList WHERE status = ? ORDER BY id ASC"); ?>
<?php $searchServerF->execute(array(1)); ?>
<div class="container-fluid">
  <div class="row">
    <div class="col-12 p-0">
      <div class="container">
        <div class="row">
          <div class="col-12">
            <nav aria-label="breadcrumb" class="pt-lg-5 pt-4">
              <ol class="breadcrumb rounded-none bg-dark--5 font-size-6">
                <li class="breadcrumb-item"><a href="<?php echo urlConverter("home", $languageType); ?>" class="text-white font-100"><?php echo languageVariables("home", "words", $languageType); ?></a></li>
                <li class="breadcrumb-item"><a href="<?php echo urlConverter("store", $languageType); ?>" class="text-white font-100"><?php echo languageVariables("store", "words", $languageType); ?></a></li>
                <li class="breadcrumb-item active" aria-current="page"><?php echo $readServer["name"]; ?></li>
              </ol>
            </nav>
          </div>
          <div class="col-lg-4 col-12 py-3">
            <div id="sidebar-wrapper">
              <div class="sidebar bg-dark--2 mb-4">
                <a href="<?php echo urlConverter("store", $languageType); ?>" class="text-white px-5 py-3 d-flex justify-content-center w-100 align-items-center text-uppercase font-size-7" data-toggle="tooltip" data-placement="top" title="<?php echo languageVariables("back", "words", $languageType); ?>">
                  <i class="fas fa-xs fa-arrow-left"></i>
                </a>
              </div>
              <div class="sidebar bg-dark--3 p-5 mb-4">
                <h2 class="text-white font-size-9 col-12 p-0 mb-3">
                  <span class="font-800">
                  <?php echo languageVariables("gameTypes", "words", $languageType); ?>
                  </span>
                </h2>
                <ul class="navbar-nav sidebar-nav">
                  <?php if ($searchServerF->rowCount() > 0) { ?>
                  <?php foreach ($searchServerF as $readServerF) { ?>
                  <?php $countProduct = $db->prepare("SELECT * FROM categoryProduct WHERE serverID = ?"); ?>
                  <?php $countProduct->execute(array($readServerF["id"])); ?>
                  <li class="nav-item bg-dark--2 mb-2">
                    <a href="<?php echo urlConverter("store", $languageType); ?>/<?php echo createSlug($readServerF["name"])."/".$readServerF["id"]; ?>" class="nav-link p-3 px-4 font-100 text-white d-flex align-items-center justify-content-between w-100">
                      <span class="nav-link-text">
                      <?php echo $readServerF["name"]; ?>
                      </span>
                      <span class="product-count font-size-6 o-25 mt-1 position-relative">
                        <span class="number"><?php echo $countProduct->rowCount(); ?></span> <?php echo languageVariables("product", "words", $languageType); ?>
                      </span>
                    </a>
                  </li>
                  <?php } } else { echo alert(languageVariables("notServerAlert", "store", $languageType), "warning", "0", "/"); }?>
                </ul>
              </div>
              <div class="sidebar filter-bar bg-dark--3 p-5">
                <h2 class="text-white font-size-9 col-12 p-0 mb-3">
                  <span class="font-800">
                  <?php echo languageVariables("filters", "words", $languageType); ?>
                  </span>
                </h2>
                <div class="input-group mb-2 flex-column bg-dark--5 border col-12 p-0">
                  <label for="filter-search" class="o-100 d-block mb-0 text-white font-size-6 font-100 position-absolute">
                    <i class="fas fa-xs mr-1 fa-search"></i>
                    <?php echo languageVariables("searchHolder", "words", $languageType); ?></label>
                  <input type="search" placeholder="Bir şeyler ara" class="form-control pt-4 text-white font-size-7 py-2 w-100 font-100 rounded-none" aria-label="Bir şeyler ara" id="filter-search" aria-describedby="filter-search">
                </div>
                <div class="input-group mb-1 flex-column bg-dark--3 border col-12 p-0 select-wrapper">
                  <label for="filter-type" class="o-100 d-block mb-0 text-white font-size-6 font-100 position-absolute"><?php echo languageVariables("filterType", "words", $languageType); ?></label>
                  <select class="js-select2 w-100" id="filter-type">
                    <option value=""></option>
                    <option value="newest"><?php echo languageVariables("topNew", "words", $languageType); ?></option>
                    <option value="most-expensive"><?php echo languageVariables("topExpensive", "words", $languageType); ?></option>
                    <option value="cheapest"><?php echo languageVariables("topCheap", "words", $languageType); ?></option>
                  </select>
                </div>
              </div>
            </div>
          </div>
          <div class="col-lg-8 col-12 pb-5 pt-3">
            <div class="products bg-dark--3 p-5">
              <h3 class="text-secondary mb-3 font-100 font-size-6 letter-spacing-1 text-uppercase">
              <?php echo languageVariables("categories", "words", $languageType); ?>
              </h3>
              <div class="row filter-category">
              <?php if ($searchCategory->rowCount() > 0) { ?>
              <?php foreach ($searchCategory as $readCategory) { ?>
                <div class="col-lg-4 col-md-6 col-12 py-3 filter-item mb-3 filter-item mb-3">
                  <div class="product-box category overflow-hidden p-3 bg-dark--5 position-relative">
                    <div class="product-img position-relative mb-4 mt-4">
                      <img class="mx-auto js-mirror d-block" src="<?php echo $readCategory["image"]; ?>" alt="<?php echo languageVariables("store", "words", $languageType); ?> - <?php echo $readCategory["name"]; ?>">
                    </div>
                    <div class="product-title mb-3">
                      <h6 class="text-white font-100 font-size-8 text-center filter-item--name">
                      <?php echo $readCategory["name"]; ?> </h6>
                    </div>
                    <a href="<?php echo urlConverter("store", $languageType); ?>/<?php echo createSlug($readServer["name"])."/".createSlug($readCategory["name"])."/".$readCategory["id"]; ?>">
                      <button type="submit" class="btn text-white w-100 col-12 line-height-1 text-uppercase letter-spacing-1 font-100 font-size-6 btn-outline-primary">
                        <i class="fas fa-arrow-right fa-sm mr-2 btn-icon"></i>
                        <span class="btn-text">
                        <?php echo languageVariables("categoryGo", "words", $languageType); ?>
                        </span>
                      </button>
                    </a>
                  </div>
                </div>
              <?php } } else { echo alert(languageVariables("serverNotCategoryAlert", "store", $languageType), "warning", "0", "/"); }?>
              </div>
              <?php if ($readModule["storeExProductStatus"] == "1") { ?>
              <?php $searchProducts = $db->prepare("SELECT * FROM categoryProduct WHERE serverID = ? AND categoryID = ? AND status = ? ORDER BY id DESC LIMIT 9"); ?>
              <?php $searchProducts->execute(array($readServer["id"], 0, 1)); ?>
              <h3 class="text-secondary mb-3 font-100 font-size-6 letter-spacing-1 text-uppercase">
                <?php echo languageVariables("notCategoryProduct", "words", $languageType); ?>
              </h3>
              <div class="row filter-category">
              <?php if ($searchProducts->rowCount() > 0) { ?>
              <?php foreach ($searchProducts as $readProducts) { ?>
              <?php
                if ($readProducts["productType"] == 1 && $readProducts["productDiscount"] > 0) {
                  $productDiscount = floor($readProducts["price"]*(100-$readProducts["productDiscount"])/100);
                  $readProducts["price"] = '<div class="pt-1"><span class="discount-percent font-800">%</span><del class="text-secondary turkish-lira">'.$readProducts["price"].'</del><span class="turkish-lira filter-item--price"> '.$productDiscount.'</span></div>';
                } else if ($readModule["storeDiscountStatus"] == "1" && $readModule["storeDiscount"] > 0) {
                  $productDiscount = floor($readProducts["price"]*(100-$readModule["storeDiscount"])/100);
                  $readProducts["price"] = '<div class="pt-1"><span class="discount-percent font-800">%</span><del class="text-secondary turkish-lira">'.$readProducts["price"].'</del><span class="turkish-lira filter-item--price"> '.$productDiscount.'</span></div>';
                } else {
                  $readProducts["price"] = '<div class="turkish-lira pt-1 filter-item--price">'.$readProducts["price"].'</div>';
                }
              ?>
                <div class="col-lg-4 col-md-6 col-12 py-3 filter-item mb-3">
                  <div class="product-box overflow-hidden p-3 bg-dark--4 position-relative">
                    <?php if ($readProducts["productCount"] > 0) { ?>
                    <div class="store-card-stock have-stock">
                        <div class="product-state position-absolute mb-4 d-flex align-items-start pr-2 pt-2 justify-content-end text-center text-body">
                            <i class="fas fa-xs fa-crown text-body"></i>
                        </div>
                    </div>
                    <?php } ?>
                    <div class="product-img position-relative mb-4 mt-4">
                      <img class="mx-auto js-mirror d-block" src="<?php echo $readProducts["image"]; ?>" alt="<?php echo languageVariables("store", "words", $languageType); ?> - <?php echo $readProducts["name"]; ?> <?php echo languageVariables("product", "words", $languageType); ?>">
                    </div>
                    <div class="product-title">
                      <h6 class="text-white font-100 font-size-8 text-center filter-item--name">
                      <?php echo $readProducts["name"]; ?> </h6>
                    </div>
                    <div class="product-price bg-dark--5 text-center text-white p-2 mb-1 font-size-6 font-100">
                      <?php echo $readProducts["price"]; ?>
                    </div>
                    <a href="<?php echo urlConverter("store", $languageType); ?>/<?php echo createSlug($readServer["name"])."/"."kategorisiz"."/".createSlug($readProducts["name"])."/".$readProducts["id"]; ?>" class="btn text-white w-100 col-12 line-height-1 text-uppercase letter-spacing-1 font-100 font-size-6 btn-outline-primary stretched-link">
                      <i class="fas fa-shopping-bag fa-sm mr-2 btn-icon"></i>
                      <span class="btn-text">
                      <?php echo languageVariables("buy", "words", $languageType); ?>
                      </span>
                    </a>
                  </div>
                </div>
              <?php } } else { echo alert(languageVariables("serverNotCategoryProductAlert", "store", $languageType), "warning", "0", "/"); }?>
              </div>
              <?php } ?>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<?php } else { go(urlConverter("store", $languageType)); } ?>
<?php } else { ?>
<?php $searchServer = $db->prepare("SELECT * FROM serverList WHERE status = ? ORDER BY id ASC"); ?>
<?php $searchServer->execute(array(1)); ?>
<?php if ($searchServer->rowCount() == 1) { ?>
<?php $readServer = $searchServer->fetch(); ?>
<?php go(urlConverter("store", $languageType)."/".createSlug($readServer["name"])."/".$readServer["id"]); ?>
<?php } ?>
<div class="container-fluid">
  <div class="row">
    <div class="col-12 p-0">
      <div class="container">
        <div class="row">
          <div class="col-12">
            <nav aria-label="breadcrumb" class="pt-lg-5 pt-4">
              <ol class="breadcrumb rounded-none bg-dark--5 font-size-6">
                <li class="breadcrumb-item"><a class="text-white font-100" href="/"><?php echo languageVariables("home", "words", $languageType); ?></a></li>
                <li class="breadcrumb-item active" aria-current="page"><?php echo languageVariables("store", "words", $languageType); ?></li>
              </ol>
            </nav>
          </div>
        </div>
        <div class="row">
        <?php if ($searchServer->rowCount() > 0) { ?>
          <?php foreach ($searchServer as $readServer) { ?>
          <div class="col-lg-4 col-12 mb-5">
            <div class="card text-white card-game pt-4 mt-1">
              <div class="card-body position-relative bg-dark--2 p-0 pt-5 d-flex flex-column justify-content-end font-100" style="background-image: linear-gradient(to top, var(--dark), transparent), url('<?php echo $readServer["image"]; ?>');">
                <h5 class="card-title font-size-12 pt-4 px-4 text-center font-900 mb-0 letter-spacing-1"><?php echo $readServer["name"]; ?></h5>
                <p class="card-text font-size-6 text-center text-white mt-1 px-5 line-height-1 font-100 o-75"><?php echo languageVariables("productsViews", "words", $languageType); ?></p>
                <div class="btn-group mb-5 w-100 px-5">
                  <a href="<?php echo urlConverter("store", $languageType); ?>/<?php echo createSlug($readServer["name"])."/".$readServer["id"]; ?>" class="btn text-white line-height-1 text-uppercase letter-spacing-1 font-100 font-size-6 btn-primary mx-lg-4">
                    <i class="fas fa-arrow-right fa-sm mr-2 btn-icon"></i>
                    <span class="btn-text">
                    <?php echo languageVariables("click", "words", $languageType); ?>
                    </span>
                  </a>
                </div>
              </div>
            </div>
          </div>
        <?php } } else { echo alert(languageVariables("notServerAlert", "store", $languageType), "warning", "0", "/"); }?>
        </div>
      </div>
    </div>
  </div>
</div>
<?php } ?>