<div class="relative h-72 flex overflow-hidden shadow bg-cover bg-center" style="background-image: url('<?php echo $themeDefaultVariables["storeImage"]; ?>')">
  <div class="absolute top-0 left-0 w-full h-full bg-black/50"></div>
  <div class="relative flex justify-between z-10 p-4 mt-auto w-full">
    <div class="container mx-auto">
      <h1 class="text-white font-semibold text-2xl dark:text-green-300"><?php echo str_replace("&serverName", $rSettings["serverName"], languageVariables("heroTitle", "store", $languageType)); ?></h1>
      <p class="text-white/75 text-sm max-w-3xl dark:text-green-300/75"><?php echo languageVariables("heroText", "store", $languageType); ?></p>
    </div>
  </div>
</div>
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
      $searchProductPostersTwo = $db->prepare("SELECT * FROM productPosters WHERE productID = ? ORDER BY id ASC");
      $searchProductPostersTwo->execute(array($readProduct["id"]));
      $safeProductPrice = $readProduct["price"];
      if ($readProduct["productType"] == 1 && $readProduct["productDiscount"] > 0) {
        $productDiscount = floor($readProduct["price"]*(100-$readProduct["productDiscount"])/100);
        $readProduct["price"] = "<del style=\"color: #fe2203;\">".$readProduct["price"]."</del> ".$productDiscount;
      } else if ($readModule["storeDiscountStatus"] == "1" && $readModule["storeDiscount"] > 0) {
        $productDiscount = floor($readProduct["price"]*(100-$readModule["storeDiscount"])/100);
        $readProduct["price"] = "<del style=\"color: #fe2203;\">".$readProduct["price"]."</del> ".$productDiscount;
      }
?>
<?php $searchCategoryF = $db->prepare("SELECT * FROM serverCategory WHERE serverID = ? AND status = ? ORDER BY id ASC"); ?>
<?php $searchCategoryF->execute(array($readServer["id"], 1)); ?>
<?php if ($searchCategoryF->rowCount() > 1) { ?>
<section class="bg-indigo-100/75">
  <div class="container mx-auto grid grid-cols-2 lg:grid-cols-8">
  <?php foreach ($searchCategoryF as $readCategoryF) { ?>
  <?php $countProductS = $db->prepare("SELECT * FROM categoryProduct WHERE categoryID = ?"); ?>
  <?php $countProductS->execute(array($readCategoryF["id"])); ?>
    <a href="<?php echo urlConverter("store", $languageType); ?>/<?php echo createSlug($readServer["name"])."/".createSlug($readCategoryF["name"])."/".$readCategoryF["id"]; ?>" class="<?php echo (($readCategory["id"] == $readCategoryF["id"]) ? "relative py-8 flex flex-col items-center justify-center bg-indigo-500" : "relative py-8 flex flex-col items-center justify-center transition hover:bg-indigo-500 group"); ?>">
      <p class="<?php echo (($readCategory["id"] == $readCategoryF["id"]) ? "fw-bold text-white relative bottom-2" : "fw-bold text-primary transition-all group-hover:text-white relative bottom-0 group-hover:bottom-2"); ?>"><?php echo $readCategoryF["name"]; ?></p>
      <span class="<?php echo (($readCategory["id"] == $readCategoryF["id"]) ? "absolute text-white/75 fw-medium bottom-4" : "absolute -bottom-6 text-white/75 fw-medium group-hover:bottom-4 transition-all"); ?>"><?php echo $countProductS->rowCount()." ".languageVariables("product", "words", $languageType); ?></span>
      <?php if ($readCategory["id"] == $readCategoryF["id"]) { ?>
      <div class="absolute items-center w-6 overflow-hidden inline-block" style="top: 4.7rem;">
        <div class="h-4 w-6 rounded-sm shadow-sm rotate-45 transform origin-bottom-left">
          <div class="w-full h-full bg-indigo-200"><span class="absolute top-0 left-0 w-full h-full bg-indigo-600/50"></span></div>
        </div>
      </div>
      <?php } ?>
    </a>
  <?php } ?>
  </div>
</section>
<?php } ?>
<section class="py-16">
  <div class="container mx-auto px-4 md:px-0">
    <nav class="card flex" aria-label="Breadcrumb">
      <ol class="w-full mx-auto px-4 flex space-x-4 sm:px-6 lg:px-8 overflow-x-hdn">
        <li class="flex">
          <div class="flex items-center">
            <a href="/" class="text-gray-400 hover:text-gray-500">
              <i class="fas fa-home"></i>
              <span class="sr-only"><?php echo languageVariables("home", "words", $languageType); ?></span>
            </a>
          </div>
        </li>
        <li class="flex">
          <div class="flex items-center py-1">
            <svg class="flex-shrink-0 w-6 h-full text-gray-200" viewBox="0 0 24 44" preserveAspectRatio="none" fill="currentColor" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
              <path d="M.293 0l22 22-22 22h1.414l22-22-22-22H.293z"></path>
            </svg>
            <a href="<?php echo urlConverter("store", $languageType); ?>" class="ml-4 text-sm font-medium text-gray-500 hover:text-gray-700"><?php echo languageVariables("store", "words", $languageType); ?></a>
          </div>
        </li>
        <li class="flex">
          <div class="flex items-center py-1">
            <svg class="flex-shrink-0 w-6 h-full text-gray-200" viewBox="0 0 24 44" preserveAspectRatio="none" fill="currentColor" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
              <path d="M.293 0l22 22-22 22h1.414l22-22-22-22H.293z"></path>
            </svg>
            <a href="<?php echo urlConverter("store", $languageType); ?>/<?php echo createSlug($readServer["name"])."/".$readServer["id"]; ?>" class="ml-4 text-sm font-medium text-gray-500 hover:text-gray-700"><?php echo $readServer["name"]; ?></a>
          </div>
        </li>
        <li class="flex">
          <div class="flex items-center py-1">
            <svg class="flex-shrink-0 w-6 h-full text-gray-200" viewBox="0 0 24 44" preserveAspectRatio="none" fill="currentColor" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
              <path d="M.293 0l22 22-22 22h1.414l22-22-22-22H.293z"></path>
            </svg>
            <a href="<?php echo urlConverter("store", $languageType); ?>/<?php echo (($readProduct["categoryID"] == "0") ? createSlug($readServer["name"])."/".$readServer["id"] : createSlug($readServer["name"])."/".createSlug($readCategory["name"])."/".$readCategory["id"]); ?>" class="ml-4 text-sm font-medium text-gray-500 hover:text-gray-700"><?php echo $readCategory["name"]; ?></a>
          </div>
        </li>
        <li class="flex">
          <div class="flex items-center py-1">
            <svg class="flex-shrink-0 w-6 h-full text-gray-200" viewBox="0 0 24 44" preserveAspectRatio="none" fill="currentColor" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
              <path d="M.293 0l22 22-22 22h1.414l22-22-22-22H.293z"></path>
            </svg>
            <a href="" class="ml-4 text-sm font-medium text-gray-500 hover:text-gray-700"><?php echo $readProduct["name"]; ?></a>
          </div>
        </li>
      </ol>
    </nav>
  </div>
  <div class="container mx-auto grid lg:grid-cols-12 gap-10 mt-20 px-4 md:px-0">
    <div class="card lg:col-span-8 h-fit">
      <?php if ($readProduct["posters"] == 1 && $searchProductPosters->rowCount() > 0) { ?>
      <div class="flex items-center justify-center">
        <div class="owl-carousel owl-theme owl-loaded min-h-[34rem] relative overflow-hidden owl-absolute">
          <div class="owl-stage-outer min-h-[34rem] !absolute">
            <div class="owl-stage">
              <?php foreach ($searchProductPosters as $productPoster) { ?>
              <div class="owl-item not-before">
                <img class="w-full" src="<?php echo $productPoster["image"]; ?>" alt="<?php echo $readProduct["name"]; ?>">
              </div>
              <?php } ?>
            </div>
          </div>
        </div>
      </div>
      <?php } ?>
      <div class="mt-4 px-6 py-8 border-t-2 border-gray-100">
        <h3 class="text-gray-800 fw-bold fs-5"><?php echo languageVariables("productDesc", "store", $languageType); ?></h3>
        <div class="text-gray-400 mt-4">
          <?php echo $readProduct["text"]; ?>
        </div>
      </div>
    </div>
    <div class="lg:col-span-4">
      <div class="bg-white relative overflow-hidden rounded-xl border border-gray-200/50 flex flex-col">
        <h3 class="text-gray-800 font-bold fs-5 text-center p-4"><?php echo languageVariables("payment", "words", $languageType); ?></h3>
        <div class="p-4 mb-10 bg-gray-100/25 border-t border-gray-100/25 space-y-4">
          <div class="fs-6 text-gray-600 flex justify-between items-center px-2 fw-medium">
            <?php echo languageVariables("countPrice", "words", $languageType); ?>
            <span class="fs-5 fw-bold text-gray-800"><span class="currency"><?php echo languageVariables("currencyIcon", "words", $languageType); ?></span> <?php echo $safeProductPrice; ?></span>
          </div>
          <?php if ($readProduct["productDiscount"] > 0) { ?>
          <div class="fs-6 text-gray-600 flex justify-between items-center px-2 fw-medium">
            <?php echo languageVariables("discount", "words", $languageType); ?>
            <span class="fs-7 rounded-lg bg-emerald-400/10 py-1 px-3 text-emerald-500">%<?php echo $readProduct["productDiscount"]; ?></span>
          </div>
          <?php } ?>
          <div class="fs-6 text-gray-600 flex justify-between items-center px-2 fw-medium">
            <?php echo languageVariables("payAmount", "words", $languageType); ?>
            <span class="fs-5 fw-bold text-gray-800"><span class="currency"><?php echo languageVariables("currencyIcon", "words", $languageType); ?></span> <?php echo $readProduct["price"]; ?></span>
          </div>
        </div>
        <div class="mt-auto">
          <div class="flex gap-3 p-4 bg-gray-100/25 border-t-2 border-indigo-100/25">
            <a onclick="store('directBuy', '<?php echo $readProduct["id"]; ?>');" class="btn btn-primary font-bold fs-6 w-full"><?php echo languageVariables("buy", "words", $languageType); ?></a>
            <a onclick="store('addCart', '<?php echo $readProduct["id"]; ?>');" class="btn btn-light font-bold fs-6 w-full"><?php echo languageVariables("shoppingCartAdd", "words", $languageType); ?></a>
          </div>
        </div>
      </div>
      <div class="">
        <div class="card mt-4">
          <div class="p-6 grid grid-cols-2 gap-6">
            <a onclick="store('starVote', '<?php echo $readProduct["id"]; ?>');" class="col-span-2 btn btn-warning !fw-bold"><?php echo languageVariables("starAdd", "words", $languageType); ?></a>
            <div class="flex flex-col justify-center items-center">
              <span class="fs-2 text-dark fw-extrabold"><?php echo $countProductSales->rowCount(); ?></span>
              <small class="text-gray-400"><?php echo languageVariables("sales", "words", $languageType); ?></small>
            </div>
            <div class="flex flex-col justify-center items-center border-l-2 border-gray-200/50">
              <span class="fs-2 text-dark fw-extrabold"><?php echo $countProductRates->rowCount(); ?></span>
              <div class="flex gap-2">
                <i class="fas fa-star text-yellow-500 fs-7"></i>
                <i class="fas fa-star text-yellow-500 fs-7"></i>
                <i class="fas fa-star text-yellow-500 fs-7"></i>
                <i class="fas fa-star text-yellow-500 fs-7"></i>
                <i class="fas fa-star text-yellow-500 fs-7"></i>
              </div>
            </div>
          </div>
          <div class="p-6">
            <h5 class="fs-5 text-dark fw-bold"><?php echo languageVariables("productInfo", "words", $languageType); ?></h5>
            <div class="grid grid-cols-3 gap-2 mt-2 pt-2 border-t-2 border-gray-200/50">
              <dt class="text-gray-700 fw-bolder fs-6">
                <?php echo languageVariables("publishDate", "words", $languageType); ?>
              </dt>
              <dd class="text-gray-500 mt-2 col-span-2 fs-7">
                <?php echo checkTime($readProduct["date"], 2, true); ?>
              </dd>
            </div>
            <div class="grid grid-cols-3 gap-2 mt-2 pt-2 border-t border-gray-100/50">
              <dt class="text-gray-700 fw-bolder fs-6">
                <?php echo languageVariables("server", "words", $languageType); ?>
              </dt>
              <dd class="text-gray-500 mt-2 col-span-2 fs-7">
                <a href="<?php echo urlConverter("store", $languageType); ?>/<?php echo createSlug($readServer["name"])."/".$readServer["id"]; ?>"><?php echo $readServer["name"]; ?></a>
              </dd>
            </div>
            <div class="grid grid-cols-3 gap-2 mt-2 pt-2 border-t border-gray-100/50">
              <dt class="text-gray-700 fw-bolder fs-6">
                <?php echo languageVariables("category", "words", $languageType); ?>
              </dt>
              <dd class="text-gray-500 mt-2 col-span-2 fs-7">
                <?php if ($readProduct["categoryID"] > 0) { ?><a href="<?php echo urlConverter("store", $languageType); ?>/<?php echo createSlug($readServer["name"])."/".createSlug($readCategory["name"])."/".$readCategory["id"]; ?>"><?php echo $readCategory["name"]; ?></a><?php } else { ?><?php echo languageVariables("notCategory", "words", $languageType); ?><?php } ?>
              </dd>
            </div>
            <div class="grid grid-cols-3 gap-2 mt-2 pt-2 border-t border-gray-100/50">
              <dt class="text-gray-700 fw-bolder fs-6">
                <?php echo languageVariables("price", "words", $languageType); ?>
              </dt>
              <dd class="text-gray-500 mt-2 col-span-2 fs-7">
                <span class="bold"><?php echo $readProduct["price"]." ".languageVariables("credi", "words", $languageType); ?></span>
              </dd>
            </div>
            <div class="grid grid-cols-3 gap-2 mt-2 pt-2 border-t border-gray-100/50">
              <dt class="text-gray-700 fw-bolder fs-6">
                <?php echo languageVariables("duration", "words", $languageType); ?>
              </dt>
              <dd class="text-gray-500 mt-2 col-span-2 fs-7">
                <?php if ($readProduct["productTime"] > 0) { echo $readProduct["productTime"]." ".languageVariables("day", "words", $languageType); } else { echo languageVariables("unlimited", "words", $languageType); } ?>
              </dd>
            </div>
            <?php $searchProductStockHistory = $db->prepare("SELECT * FROM productStockHistory WHERE productID = ?"); ?>
            <?php $searchProductStockHistory->execute(array($readProduct["id"])); ?>
            <div class="grid grid-cols-3 gap-2 mt-2 pt-2 border-t border-gray-100/50">
              <dt class="text-gray-700 fw-bolder fs-6">
                <?php echo languageVariables("stock", "words", $languageType); ?>
              </dt>
              <dd class="text-gray-500 mt-2 col-span-2 fs-7">
                <?php if ($readProduct["productCount"] > 0) { $productCountPiece = $readProduct["productCount"] - $searchProductStockHistory->rowCount(); echo (($productCountPiece == "0") ? languageVariables("soldOut", "words", $languageType) : $productCountPiece." ".languageVariables("count", "words", $languageType)); } else { echo languageVariables("unlimited", "words", $languageType); } ?>
              </dd>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
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
<?php if ($searchServerF->rowCount() > 1) { ?>
<section class="bg-indigo-100/75">
  <div class="container mx-auto grid grid-cols-2 lg:grid-cols-8">
  <?php foreach ($searchServerF as $readServerF) { ?>
  <?php $countProductS = $db->prepare("SELECT * FROM categoryProduct WHERE serverID = ?"); ?>
  <?php $countProductS->execute(array($readServerF["id"])); ?>
    <a href="<?php echo urlConverter("store", $languageType); ?>/<?php echo createSlug($readServerF["name"])."/".$readServerF["id"]; ?>" class="<?php echo (($readServer["id"] == $readServerF["id"]) ? "relative py-8 flex flex-col items-center justify-center bg-indigo-500" : "relative py-8 flex flex-col items-center justify-center transition hover:bg-indigo-500 group"); ?>">
      <p class="<?php echo (($readServer["id"] == $readServerF["id"]) ? "fw-bold text-white relative bottom-2" : "fw-bold text-primary transition-all group-hover:text-white relative bottom-0 group-hover:bottom-2"); ?>"><?php echo $readServerF["name"]; ?></p>
      <span class="<?php echo (($readServer["id"] == $readServerF["id"]) ? "absolute text-white/75 fw-medium bottom-4" : "absolute -bottom-6 text-white/75 fw-medium group-hover:bottom-4 transition-all"); ?>"><?php echo $countProductS->rowCount()." ".languageVariables("product", "words", $languageType); ?></span>
      <?php if ($readServer["id"] == $readServerF["id"]) { ?>
      <div class="absolute items-center w-6 overflow-hidden inline-block" style="top: 4.7rem;">
        <div class="h-4 w-6 rounded-sm shadow-sm rotate-45 transform origin-bottom-left">
          <div class="w-full h-full bg-indigo-200"><span class="absolute top-0 left-0 w-full h-full bg-indigo-600/50"></span></div>
        </div>
      </div>
      <?php } ?>
    </a>
  <?php } ?>
  </div>
</section>
<?php } ?>
<section class="py-16">
  <div class="container mx-auto px-4 md:px-0">
    <nav class="card flex" aria-label="Breadcrumb">
      <ol class=" w-full mx-auto px-4 flex space-x-4 sm:px-6 lg:px-8 overflow-x-hdn">
        <li class="flex">
          <div class="flex items-center">
            <a href="/" class="text-gray-400 hover:text-gray-500">
              <i class="fas fa-home"></i>
              <span class="sr-only"><?php echo languageVariables("home", "words", $languageType); ?></span>
            </a>
          </div>
        </li>
        <li class="flex">
          <div class="flex items-center py-1">
            <svg class="flex-shrink-0 w-6 h-full text-gray-200" viewBox="0 0 24 44" preserveAspectRatio="none" fill="currentColor" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
              <path d="M.293 0l22 22-22 22h1.414l22-22-22-22H.293z"></path>
            </svg>
            <a href="<?php echo urlConverter("store", $languageType); ?>" class="ml-4 text-sm font-medium text-gray-500 hover:text-gray-700"><?php echo languageVariables("store", "words", $languageType); ?></a>
          </div>
        </li>
        <li class="flex">
          <div class="flex items-center py-1">
            <svg class="flex-shrink-0 w-6 h-full text-gray-200" viewBox="0 0 24 44" preserveAspectRatio="none" fill="currentColor" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
              <path d="M.293 0l22 22-22 22h1.414l22-22-22-22H.293z"></path>
            </svg>
            <a href="<?php echo urlConverter("store", $languageType); ?>/<?php echo createSlug($readServer["name"])."/".$readServer["id"]; ?>" class="ml-4 text-sm font-medium text-gray-500 hover:text-gray-700"><?php echo $readServer["name"]; ?></a>
          </div>
        </li>
        <li class="flex">
          <div class="flex items-center py-1">
            <svg class="flex-shrink-0 w-6 h-full text-gray-200" viewBox="0 0 24 44" preserveAspectRatio="none" fill="currentColor" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
              <path d="M.293 0l22 22-22 22h1.414l22-22-22-22H.293z"></path>
            </svg>
            <a href="<?php echo urlConverter("store", $languageType); ?>/<?php echo createSlug($readServer["name"])."/".createSlug($readCategory["name"])."/".$readCategory["id"]; ?>" class="ml-4 text-sm font-medium text-gray-500 hover:text-gray-700"><?php echo $readCategory["name"]; ?></a>
          </div>
        </li>
      </ol>
    </nav>
  </div>
  <div class="container px-4 md:px-0 mx-auto lg:grid grid-cols-10 space-y-12 lg:space-y-0 gap-12 mt-10">
    <div class="col-span-3 flex flex-col gap-8">
      <?php if ($searchCategoryF->rowCount() > 0) { ?>
      <div>
        <div class="grid bg-indigo-100 rounded-2xl overflow-hidden relative divide-y divide-indigo-400/25">
          <?php foreach ($searchCategoryF as $readCategoryF) { ?>
          <?php $countProduct = $db->prepare("SELECT * FROM categoryProduct WHERE categoryID = ?"); ?>
          <?php $countProduct->execute(array($readCategoryF["id"])); ?>
          <?php if ($readCategory["id"] == $readCategoryF["id"]) { ?>
          <a href="<?php echo urlConverter("store", $languageType); ?>/<?php echo createSlug($readServer["name"])."/".createSlug($readCategoryF["name"])."/".$readCategoryF["id"]; ?>" class="relative py-8 flex flex-col items-center justify-center bg-indigo-500">
            <p class="fw-bold text-white relative bottom-2"><?php echo $readCategoryF["name"]; ?></p>
            <span class="absolute text-white/75 fw-medium bottom-4"><span class="number"><?php echo $countProduct->rowCount(); ?></span> <?php echo languageVariables("product", "words", $languageType); ?></span>
          </a>
          <?php } else { ?>
          <a href="<?php echo urlConverter("store", $languageType); ?>/<?php echo createSlug($readServer["name"])."/".createSlug($readCategoryF["name"])."/".$readCategoryF["id"]; ?>" class="relative py-8 flex flex-col items-center justify-center transition hover:bg-indigo-500 group overflow-hidden">
            <p class="fw-bold text-primary transition-all group-hover:text-white relative bottom-0 group-hover:bottom-2"><?php echo $readCategoryF["name"]; ?></p>
            <span class="absolute -bottom-6 text-white/75 fw-medium group-hover:bottom-4 transition-all"><span class="number"><?php echo $countProduct->rowCount(); ?></span> <?php echo languageVariables("product", "words", $languageType); ?></span>
          </a>
          <?php } ?>
          <?php } ?>
        </div>
      </div>
      <?php } ?>
      <div class="filter-bar">
        <div class="card p-6 flex flex-col gap-5 items-center">
          <div class="border-b-2 border-gray-200/50 py-4 px-6">
            <div class="rounded-2xl flex items-center justify-center bg-indigo-400/25 w-14 h-14 absolute -top-5 -right-5">
              <i class="fas fa-search !text-indigo-700 fs-5"></i>
            </div>
            <p class="text-gray-500 fw-medium"><?php echo languageVariables("filters", "words", $languageType); ?></p>
          </div>
          <input id="filter-search" type="search" class="form-control w-full" placeholder="<?php echo languageVariables("searchMake", "words", $languageType); ?>">
          <div class="absolute -top-4 left-4 w-6 overflow-hidden inline-block md:hidden lg:inline-block">
            <div class="h-4 w-6 rounded-sm bg-white border-gray-200/50 rotate-45 transform origin-bottom-left"></div>
          </div>
        </div>
      </div>
    </div>
    <?php $searchProduct = $db->prepare("SELECT * FROM categoryProduct WHERE categoryID = ? AND serverID = ? AND status = ? ORDER BY id ASC"); ?>
    <?php $searchProduct->execute(array($readCategory["id"], $readServer["id"], 1)); ?>
    <div class="col-span-7 <?php echo (($searchProduct->rowCount() > 0) ? "lg:grid grid-cols-3" : ""); ?> gap-6 space-y-6 lg:space-y-0 filter-category" style="align-items: self-start;">
      <?php if ($searchProduct->rowCount() > 0) { ?>
      <?php foreach ($searchProduct as $readProduct) { ?>
      <?php
        if ($readProduct["productType"] == 1 && $readProduct["productDiscount"] > 0) {
          $productDiscount = floor($readProduct["price"]*(100-$readProduct["productDiscount"])/100);
          $readProduct["price"] = '<span><del class="text-secondary">'.$readProduct["price"].'</del><span class="filter-item--price"> '.$productDiscount.'</span></span>';
        } else if ($readModule["storeDiscountStatus"] == "1" && $readModule["storeDiscount"] > 0) {
          $productDiscount = floor($readProduct["price"]*(100-$readModule["storeDiscount"])/100);
          $readProduct["price"] = '<span><del class="text-secondary">'.$readProduct["price"].'</del><span class="filter-item--price"> '.$productDiscount.'</span></span>';
        } else {
          $readProduct["price"] = '<span class="filter-item--price">'.$readProduct["price"].'</span>';
        }
      ?>
      <div class="bg-white rounded-2xl p-4 flex flex-col border border-gray-200/50 shadow filter-item">
        <div class="relative flex flex-col justify-center select-none items-center">
          <?php $searchProductStockHistory = $db->prepare("SELECT * FROM productStockHistory WHERE productID = ?"); ?>
          <?php $searchProductStockHistory->execute(array($readProduct["id"])); ?>
          <?php 
            if ($readProduct["productCount"] > 0) {
              $productCountPiece = $readProduct["productCount"] - $searchProductStockHistory->rowCount();
              echo (($productCountPiece == "0") ? "<div class=\"absolute top-0 left-0 w-full text-center fw-bolder text-red-400 fs-6 py-1 px-3\">".languageVariables("soldOut", "words", $languageType)."</div>" : "<div class=\"absolute top-0 left-0 bg-yellow-400 rounded-lg text-white fs-7 py-1 px-3\">".str_replace("&count", $productCountPiece, languageVariables("productLimitedText", "store", $languageType))."</div>");
            }
          ?>
          <?php if ($readProduct["productType"] == 1 && $readProduct["productDiscount"] > 0) { ?>
            <div class="absolute top-0 right-0 bg-emerald-400 rounded-lg text-white fs-7 py-1 px-3">%<?php echo $readProduct["productDiscount"]; ?></div>
          <?php } ?>
          <img class="w-48 py-6 relative z-20" src="<?php echo $readProduct["image"]; ?>" alt="<?php echo languageVariables("store", "words", $languageType); ?> - <?php echo $readProduct["name"]; ?> <?php echo languageVariables("product", "words", $languageType); ?>">
          <img class="w-60 py-6 absolute z-10 blur-[30px] opacity-50 select-none" src="<?php echo $readProduct["image"]; ?>" alt="<?php echo languageVariables("store", "words", $languageType); ?> - <?php echo $readProduct["name"]; ?> <?php echo languageVariables("product", "words", $languageType); ?>">
          <div class="w-1/2 h-2 bg-<?php echo (($readProduct["productCount"] > 0 && $productCountPiece == "0") ? "red" : (($readProduct["productType"] == 1 && $readProduct["productDiscount"] > 0) ? "emerald" : "indigo")); ?>-100 rounded-full"></div>
        </div>
        <div class="flex flex-col px-3 pt-4 grow">
          <div class="flex justify-between mb-4">
            <p class="fw-bold fs-5 text-gray-800 filter-item--name"><?php echo $readProduct["name"]; ?></p>
            <div class="text-gray-500"><?php echo languageVariables("currencyIcon", "words", $languageType); ?><span class="fw-bold fs-5 text-gray-800 filter-item--price"><?php echo $readProduct["price"]; ?></span></div>
          </div>
          <div class="mt-auto">
            <a href="<?php echo urlConverter("store", $languageType); ?>/<?php echo createSlug($readServer["name"])."/".createSlug($readCategory["name"])."/".createSlug($readProduct["name"])."/".$readProduct["id"]; ?>" class="btn btn-<?php echo (($readProduct["productCount"] > 0 && $productCountPiece == "0") ? "danger" : (($readProduct["productType"] == 1 && $readProduct["productDiscount"] > 0) ? "success" : "primary")); ?> fw-medium w-full"><?php echo languageVariables("buy", "words", $languageType); ?></a>
          </div>
        </div>
      </div>
      <?php } } else { echo alert(languageVariables("serverNotCategoryProductAlert", "store", $languageType), "danger", "0", "/"); } ?>
    </div>
  </div>
</section>
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
<?php $searchCategoryF = $db->prepare("SELECT * FROM serverCategory WHERE serverID = ? AND status = ? ORDER BY id ASC"); ?>
<?php $searchCategoryF->execute(array($readCategory["serverID"], 1)); ?>
<section class="py-16">
  <div class="container mx-auto px-4 md:px-0">
    <nav class="card flex" aria-label="Breadcrumb">
      <ol class=" w-full mx-auto px-4 flex space-x-4 sm:px-6 lg:px-8 overflow-x-hdn">
        <li class="flex">
          <div class="flex items-center">
            <a href="/" class="text-gray-400 hover:text-gray-500">
              <i class="fas fa-home"></i>
              <span class="sr-only"><?php echo languageVariables("home", "words", $languageType); ?></span>
            </a>
          </div>
        </li>
        <li class="flex">
          <div class="flex items-center py-1">
            <svg class="flex-shrink-0 w-6 h-full text-gray-200" viewBox="0 0 24 44" preserveAspectRatio="none" fill="currentColor" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
              <path d="M.293 0l22 22-22 22h1.414l22-22-22-22H.293z"></path>
            </svg>
            <a href="<?php echo urlConverter("store", $languageType); ?>" class="ml-4 text-sm font-medium text-gray-500 hover:text-gray-700"><?php echo languageVariables("store", "words", $languageType); ?></a>
          </div>
        </li>
        <li class="flex">
          <div class="flex items-center py-1">
            <svg class="flex-shrink-0 w-6 h-full text-gray-200" viewBox="0 0 24 44" preserveAspectRatio="none" fill="currentColor" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
              <path d="M.293 0l22 22-22 22h1.414l22-22-22-22H.293z"></path>
            </svg>
            <a href="<?php echo urlConverter("store", $languageType); ?>/<?php echo createSlug($readServer["name"])."/".$readServer["id"]; ?>" class="ml-4 text-sm font-medium text-gray-500 hover:text-gray-700"><?php echo $readServer["name"]; ?></a>
          </div>
        </li>
      </ol>
    </nav>
  </div>
  <div class="container px-4 md:px-0 mx-auto lg:grid grid-cols-10 space-y-12 lg:space-y-0 gap-12 mt-10">
    <div class="col-span-3 flex flex-col gap-8">
      <?php if ($searchServerF->rowCount() > 0) { ?>
      <div>
        <div class="grid bg-indigo-100 rounded-2xl overflow-hidden relative divide-y divide-indigo-400/25">
          <?php foreach ($searchServerF as $readServerF) { ?>
          <?php $countProduct = $db->prepare("SELECT * FROM categoryProduct WHERE serverID = ?"); ?>
          <?php $countProduct->execute(array($readServerF["id"])); ?>
          <?php if ($readServer["id"] == $readServerF["id"]) { ?>
          <a href="<?php echo urlConverter("store", $languageType); ?>/<?php echo createSlug($readServerF["name"])."/".$readServerF["id"]; ?>" class="relative py-8 flex flex-col items-center justify-center bg-indigo-500">
            <p class="fw-bold text-white relative bottom-2"><?php echo $readServerF["name"]; ?></p>
            <span class="absolute text-white/75 fw-medium bottom-4"><span class="number"><?php echo $countProduct->rowCount(); ?></span> <?php echo languageVariables("product", "words", $languageType); ?></span>
          </a>
          <?php } else { ?>
          <a href="<?php echo urlConverter("store", $languageType); ?>/<?php echo createSlug($readServerF["name"])."/".$readServerF["id"]; ?>" class="relative py-8 flex flex-col items-center justify-center transition hover:bg-indigo-500 group overflow-hidden">
            <p class="fw-bold text-primary transition-all group-hover:text-white relative bottom-0 group-hover:bottom-2"><?php echo $readServerF["name"]; ?></p>
            <span class="absolute -bottom-6 text-white/75 fw-medium group-hover:bottom-4 transition-all"><span class="number"><?php echo $countProduct->rowCount(); ?></span> <?php echo languageVariables("product", "words", $languageType); ?></span>
          </a>
          <?php } ?>
          <?php } ?>
        </div>
      </div>
      <?php } ?>
      <div class="filter-bar">
        <div class="card p-6 flex flex-col gap-5 items-center">
          <div class="border-b-2 border-gray-200/50 py-4 px-6">
            <div class="rounded-2xl flex items-center justify-center bg-indigo-400/25 w-14 h-14 absolute -top-5 -right-5">
              <i class="fas fa-search !text-indigo-700 fs-5"></i>
            </div>
            <p class="text-gray-500 fw-medium"><?php echo languageVariables("filters", "words", $languageType); ?></p>
          </div>
          <input id="filter-search" type="search" class="form-control w-full" placeholder="<?php echo languageVariables("searchMake", "words", $languageType); ?>">
          <div class="absolute -top-4 left-4 w-6 overflow-hidden inline-block md:hidden lg:inline-block">
            <div class="h-4 w-6 rounded-sm bg-white border-gray-200/50 rotate-45 transform origin-bottom-left"></div>
          </div>
        </div>
      </div>
    </div>
    <div class="col-span-7 gap-6 space-y-6 lg:space-y-0 filter-category" style="align-items: self-start;">
      <div class="lg:grid grid-cols-12 gap-8">
        <?php if ($searchCategory->rowCount() > 0) { ?>
        <?php foreach ($searchCategory as $readCategory) { ?>
        <?php $countProduct = $db->prepare("SELECT * FROM categoryProduct WHERE categoryID = ?"); ?>
        <?php $countProduct->execute(array($readCategory["id"])); ?>
        <div class="lg:col-span-6 mt-3">
          <div class="card flex gap-3 group shadow">
            <div class="flex flex-col justify-center select-none items-center p-4 relative overflow-hidden">
              <img class="h-40 py-6 relative z-10 transition-all transform group-hover:scale-110" src="<?php echo $readCategory["image"]; ?>" alt="<?php echo $readCategory["name"]; ?>">
            </div>
            <div class="flex flex-col py-6 px-10">
              <dt class="fw-bold fs-5 text-gray-800">
                <?php echo $readCategory["name"]; ?>
              </dt>
              <dd class="text-gray-400 mt-2"><?php echo $countProduct->rowCount(); ?> <?php echo languageVariables("product", "words", $languageType); ?></dd>
              <div class="mt-auto">
                <a href="<?php echo urlConverter("store", $languageType); ?>/<?php echo createSlug($readServer["name"])."/".createSlug($readCategory["name"])."/".$readCategory["id"]; ?>" class="btn btn-primary fw-medium w-full"><?php echo languageVariables("categoryGo", "words", $languageType); ?></a>
              </div>
            </div>
          </div>
        </div>
        <?php } } else { echo "<div class=\"col-span-12\">".alert(languageVariables("notCategoryAlert", "store", $languageType), "danger", "0", "/")."</div>"; } ?>
      </div>
      <?php $searchProduct = $db->prepare("SELECT * FROM categoryProduct WHERE serverID = ? AND categoryID = ? AND status = ? ORDER BY id DESC"); ?>
      <?php $searchProduct->execute(array($readServer["id"], 0, 1)); ?>
      <div class="<?php echo (($searchProduct->rowCount() > 0) ? "lg:grid grid-cols-3" : ""); ?>" style="margin-top: 3rem;">
        <?php if ($searchProduct->rowCount() > 0) { ?>
        <?php foreach ($searchProduct as $readProduct) { ?>
        <?php
          if ($readProduct["productType"] == 1 && $readProduct["productDiscount"] > 0) {
            $productDiscount = floor($readProduct["price"]*(100-$readProduct["productDiscount"])/100);
            $readProduct["price"] = '<span><del class="text-secondary">'.$readProduct["price"].'</del><span class="filter-item--price"> '.$productDiscount.'</span></span>';
          } else if ($readModule["storeDiscountStatus"] == "1" && $readModule["storeDiscount"] > 0) {
            $productDiscount = floor($readProduct["price"]*(100-$readModule["storeDiscount"])/100);
            $readProduct["price"] = '<span><del class="text-secondary">'.$readProduct["price"].'</del><span class="filter-item--price"> '.$productDiscount.'</span></span>';
          } else {
            $readProduct["price"] = '<span class="filter-item--price">'.$readProduct["price"].'</span>';
          }
        ?>
        <div class="bg-white rounded-2xl p-4 flex flex-col border border-gray-200/50 shadow filter-item">
          <div class="relative flex flex-col justify-center select-none items-center">
            <?php $searchProductStockHistory = $db->prepare("SELECT * FROM productStockHistory WHERE productID = ?"); ?>
            <?php $searchProductStockHistory->execute(array($readProduct["id"])); ?>
            <?php 
              if ($readProduct["productCount"] > 0) {
                $productCountPiece = $readProduct["productCount"] - $searchProductStockHistory->rowCount();
                echo (($productCountPiece == "0") ? "<div class=\"absolute top-0 left-0 w-full text-center fw-bolder text-red-400 fs-6 py-1 px-3\">".languageVariables("soldOut", "words", $languageType)."</div>" : "<div class=\"absolute top-0 left-0 bg-yellow-400 rounded-lg text-white fs-7 py-1 px-3\">".str_replace("&count", $productCountPiece, languageVariables("productLimitedText", "store", $languageType))."</div>");
              }
            ?>
            <?php if ($readProduct["productType"] == 1 && $readProduct["productDiscount"] > 0) { ?>
              <div class="absolute top-0 right-0 bg-emerald-400 rounded-lg text-white fs-7 py-1 px-3">%<?php echo $readProduct["productDiscount"]; ?></div>
            <?php } ?>
            <img class="w-48 py-6 relative z-20" src="<?php echo $readProduct["image"]; ?>" alt="<?php echo languageVariables("store", "words", $languageType); ?> - <?php echo $readProduct["name"]; ?> <?php echo languageVariables("product", "words", $languageType); ?>">
            <img class="w-60 py-6 absolute z-10 blur-[30px] opacity-50 select-none" src="<?php echo $readProduct["image"]; ?>" alt="<?php echo languageVariables("store", "words", $languageType); ?> - <?php echo $readProduct["name"]; ?> <?php echo languageVariables("product", "words", $languageType); ?>">
            <div class="w-1/2 h-2 bg-<?php echo (($readProduct["productCount"] > 0 && $productCountPiece == "0") ? "red" : (($readProduct["productType"] == 1 && $readProduct["productDiscount"] > 0) ? "emerald" : "indigo")); ?>-100 rounded-full"></div>
          </div>
          <div class="flex flex-col px-3 pt-4 grow">
            <div class="flex justify-between mb-4">
              <p class="fw-bold fs-5 text-gray-800 filter-item--name"><?php echo $readProduct["name"]; ?></p>
              <div class="text-gray-500"><?php echo languageVariables("currencyIcon", "words", $languageType); ?><span class="fw-bold fs-5 text-gray-800 filter-item--price"><?php echo $readProduct["price"]; ?></span></div>
            </div>
            <div class="mt-auto">
              <a href="<?php echo urlConverter("store", $languageType); ?>/<?php echo createSlug($readServer["name"])."/none/".createSlug($readProduct["name"])."/".$readProduct["id"]; ?>" class="btn btn-<?php echo (($readProduct["productCount"] > 0 && $productCountPiece == "0") ? "danger" : (($readProduct["productType"] == 1 && $readProduct["productDiscount"] > 0) ? "success" : "primary")); ?> fw-medium w-full"><?php echo languageVariables("buy", "words", $languageType); ?></a>
            </div>
          </div>
        </div>
        <?php } } ?>
      </div>
    </div>
  </div>
</section>
<?php } else { go(urlConverter("store", $languageType)); } ?>
<?php } else { ?>
<?php $searchServer = $db->prepare("SELECT * FROM serverList WHERE status = ? ORDER BY id ASC"); ?>
<?php $searchServer->execute(array(1)); ?>
<?php if ($searchServer->rowCount() == 1) { ?>
<?php $readServer = $searchServer->fetch(); ?>
<?php go(urlConverter("store", $languageType)."/".createSlug($readServer["name"])."/".$readServer["id"]); ?>
<?php } ?>
<section class="py-16">
  <div class="container mx-auto px-4 md:px-0">
    <nav class="card flex" aria-label="Breadcrumb">
      <ol class=" w-full mx-auto px-4 flex space-x-4 sm:px-6 lg:px-8 overflow-x-hdn">
        <li class="flex">
          <div class="flex items-center">
            <a href="/" class="text-gray-400 hover:text-gray-500">
              <i class="fas fa-home"></i>
              <span class="sr-only"><?php echo languageVariables("home", "words", $languageType); ?></span>
            </a>
          </div>
        </li>
        <li class="flex">
          <div class="flex items-center py-1">
            <svg class="flex-shrink-0 w-6 h-full text-gray-200" viewBox="0 0 24 44" preserveAspectRatio="none" fill="currentColor" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
              <path d="M.293 0l22 22-22 22h1.414l22-22-22-22H.293z"></path>
            </svg>
            <a href="<?php echo urlConverter("store", $languageType); ?>" class="ml-4 text-sm font-medium text-gray-500 hover:text-gray-700"><?php echo languageVariables("store", "words", $languageType); ?></a>
          </div>
        </li>
      </ol>
    </nav>
  </div>
  <div class="container px-4 md:px-0 mx-auto grid <?php echo (($searchServer->rowCount() > 0) ? "lg:grid-cols-12" : "lg:grid-cols-1"); ?> space-y-12 lg:space-y-0 gap-12 mt-10">
    <?php if ($searchServer->rowCount() > 0) { ?>
    <?php foreach ($searchServer as $readServer) { ?>
    <?php $countProduct = $db->prepare("SELECT * FROM categoryProduct WHERE serverID = ?"); ?>
    <?php $countProduct->execute(array($readServer["id"])); ?>
    <div class="lg:col-span-6">
      <a href="<?php echo urlConverter("store", $languageType); ?>/<?php echo createSlug($readServer["name"])."/".$readServer["id"]; ?>" class="block w-full card py-6 px-10 md:flex justify-between md:items-center group">
        <div>
          <div class="h3 text-gray-800"><?php echo $readServer["name"]; ?></div>
          <p class="mt-2 text-gray-400"><?php echo str_replace("&server", $readServer["name"], languageVariables("goServerText", "store", $languageType)); ?></p>
          <div class="block w-fit mt-6 rounded-xl py-3 px-6 text-gray-800 bg-gray-900/10 text-sm font-medium"><?php echo languageVariables("click", "words", $languageType); ?></div>
        </div>
        <div class="overflow-hidden rounded-2xl relative mt-4 md:mt-0">
          <div class="relative bg-cover bg-center rounded-2xl w-full lg:w-80 h-60 lg:h-48 transition-all scale-125 group-hover:scale-100 rotate-6 group-hover:rotate-0 duration-300" style="background-image: url('<?php echo $readServer["image"]; ?>')"></div>
        </div>
      </a>
    </div>
    <?php } } else { echo alert(languageVariables("notServerAlert", "store", $languageType), "danger", "0", "/"); } ?>
  </div>
</section>
<?php } ?>