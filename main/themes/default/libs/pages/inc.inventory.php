<?php AccountLoginControl(false); ?>
<link rel="stylesheet" href="/main/includes/packages/layouts/inventory/css/themes/default/style.css?v=<?php echo $_CONFIG["VERSION_NUMBER"]-35; ?>">
<?php
$inventoryAscLimit = $readAccount["inventorySlot"];
$searchInventoryItem = $db->prepare("SELECT * FROM accountsInventory WHERE userID = ? ORDER BY id ASC LIMIT $inventoryAscLimit");
$searchInventoryItem->execute(array($readAccount["id"]));
$privateSlot = 30 - $readAccount["inventorySlot"];
$nullSlot = $readAccount["inventorySlot"] - $searchInventoryItem->rowCount();
?>
<section class="py-16 relative overflow-hidden">
  <div class="container mx-auto px-4 md:px-0">
    <nav class="card flex" aria-label="Breadcrumb">
      <ol class=" w-full mx-auto px-4 flex space-x-4 sm:px-6 lg:px-8">
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
            <a href="<?php echo urlConverter("inventory", $languageType); ?>" class="ml-4 text-sm font-medium text-gray-500 hover:text-gray-700"><?php echo languageVariables("inventory", "words", $languageType); ?></a>
          </div>
        </li>
      </ol>
    </nav>
  </div>
  <div class="container mx-auto grid lg:grid-cols-10 gap-16 px-4 md:px-0 mt-10">
    <div class="card lg:col-span-10 flex flex-col gap-16">
      <div class="px-6 py-8">
        <h3 class="text-gray-800 fw-bold fs-5"><?php echo languageVariables("inventory", "words", $languageType); ?></h3>
        <div class="text-gray-400 mt-4">
          <div class="d-flex mb-3 justify-content-between align-items-center">
            <a onclick="inventoryCheckAll();" class="btn text-gray-500 m-0 line-height-1 text-uppercase letter-spacing-1 font-100 font-size-6" style="float: right;">
              <i class="fas fa-plus fa-sm mr-2 btn-icon"></i>
              <span class="btn-text">
                <?php echo languageVariables("allCheck", "words", $languageType); ?>
              </span>
            </a>
          </div>
          <div class="inventory" style="justify-content: center; align-items: center; text-align: center;">
            <?php foreach ($searchInventoryItem as $readInventory) { ?>
            <?php $inventoryData = json_decode($readInventory["variables"], true); ?>
            <?php if ($readInventory["type"] == "1") { ?>
            <div class="inventory-card text-tooltip-tft" onclick="proccessInventory('<?php echo $readInventory["id"]; ?>');" data-title="<?php echo languageVariables("inventory", "words", $languageType); ?> - <?php echo $inventoryData["credit"]; ?> <?php echo languageVariables("credi", "words", $languageType); ?>">
              <div class="inventory-card-content">
                <img src="<?php echo $inventoryData["image"]; ?>" alt="<?php echo languageVariables("inventory", "words", $languageType); ?> - <?php echo $inventoryData["credit"]; ?> <?php echo languageVariables("credi", "words", $languageType); ?>">
              </div>
            </div>
            <?php
            } else if ($readInventory["type"] == "2") {
              $searchProduct = $db->prepare("SELECT * FROM categoryProduct WHERE id = ?");
              $searchProduct->execute(array($inventoryData["productID"]));
              $readProduct = $searchProduct->fetch();
            ?>
            <div class="inventory-card text-tooltip-tft" onclick="proccessInventory('<?php echo $readInventory["id"]; ?>');" data-title="<?php echo languageVariables("inventory", "words", $languageType); ?> - <?php echo $readProduct["name"]; ?>">
              <div class="inventory-card-content">
                <img src="<?php echo $inventoryData["image"]; ?>" alt="<?php echo languageVariables("inventory", "words", $languageType); ?> - <?php echo $readProduct["name"]; ?>">
              </div>
            </div>
            <?php } ?>
            <?php } ?>
            <?php for ($i = 1; $i <= $nullSlot; $i++) { ?>
            <div class="inventory-card text-tooltip-tft" data-title="<?php echo languageVariables("slotNone", "inventory", $languageType); ?>">
              <div class="inventory-card-content">
                <i class="fas fa-lock-open"></i>
              </div>
            </div>
            <?php } ?>
            <?php for ($i = 1; $i <= $privateSlot; $i++) { ?>
            <div class="inventory-card text-tooltip-tft" onclick="inventorySlotBuy('<?php echo $readAccount["inventorySlot"]; ?>');" data-title="<?php echo languageVariables("slotLock", "inventory", $languageType); ?>">
              <div class="inventory-card-content">
                <i class="fas fa-lock"></i>
              </div>
            </div>
            <?php } ?>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>