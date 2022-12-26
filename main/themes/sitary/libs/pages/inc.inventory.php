<?php AccountLoginControl(false); ?>
<link rel="stylesheet" href="/main/includes/packages/layouts/inventory/css/themes/sitary/style.css?v=<?php echo $_CONFIG["VERSION_NUMBER"]; ?>">
<?php
$inventoryAscLimit = $readAccount["inventorySlot"];
$searchInventoryItem = $db->prepare("SELECT * FROM accountsInventory WHERE userID = ? ORDER BY id ASC LIMIT $inventoryAscLimit");
$searchInventoryItem->execute(array($readAccount["id"]));
$privateSlot = 30-$readAccount["inventorySlot"];
$nullSlot = $readAccount["inventorySlot"]-$searchInventoryItem->rowCount();
?>
<div class="content-grid">
  <?php include(__DR__."/main/themes/sitary/libs/content/header-box.php"); ?>
    <div class="grid grid-9-3 mobile-prefer-content">
      <!-- INVENTORY -->
      <div class="grid-column">
        <div class="section-header">
          <div class="section-header-info">
            <p class="section-pretitle"><?php echo languageVariables("inventory", "words", $languageType); ?></p>
            <h2 class="section-title"><?php echo languageVariables("items", "words", $languageType); ?> (<?php echo $searchInventoryItem->rowCount()."/".$readAccount["inventorySlot"]; ?>)</h2>
          </div>
        </div>
        <div class="widget-box">
          <div class="inventory-check-all text-tooltip-tft" onclick="inventoryCheckAll();" data-title="<?php echo languageVariables("allCheck", "words", $languageType); ?>">
            <svg class="<?php if ($_SESSION["themeModeType"] == "light") { echo "icon-check"; } else if ($_SESSION["themeModeType"] == "dark") { echo "icon-youtube"; } ?>">
              <use xlink:href="#svg-check"></use>
            </svg>
          </div>
          <div class="inventory">
            <?php foreach ($searchInventoryItem as $readInventory) { ?>
            <?php $inventoryData = json_decode($readInventory["variables"],true); ?>
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
                <svg class="icon-youtube<?php if ($_SESSION["themeModeType"] == "light") { echo "s"; } ?>">
                  <use xlink:href="#svg-quests"></use>
                </svg>
              </div>
            </div>
            <?php } ?>
            <?php for ($i = 1; $i <= $privateSlot; $i++) { ?>
            <div class="inventory-card text-tooltip-tft" onclick="inventorySlotBuy('<?php echo $readAccount["inventorySlot"]; ?>');" data-title="<?php echo languageVariables("slotLock", "inventory", $languageType); ?>">
              <div class="inventory-card-content">
                <svg class="icon-youtube<?php if ($_SESSION["themeModeType"] == "light") { echo "s"; } ?>">
                  <use xlink:href="#svg-private"></use>
                </svg>
              </div>
            </div>
            <?php } ?>
          </div>
        </div>
      </div>
      <!-- /INVENTORY -->
      
      <!-- INVENTORY SLOT-->
      <div class="grid-column">
        <div class="section-header">
          <div class="section-header-info">
            <p class="section-pretitle"><?php echo languageVariables("inventory", "words", $languageType); ?></p>
            <h2 class="section-title"><?php echo languageVariables("buySlot", "inventory", $languageType); ?></h2>
          </div>
        </div>
        <div class="widget-box">
          <div class="form-item">
            <div class="form-select">
              <label for="inventory-slot"><?php echo languageVariables("slotAmount", "inventory", $languageType); ?></label>
              <select id="inventory-slot">
                <?php if ($readAccount["inventorySlot"] == "12") { ?>
                <option value="6" selected>+6 <?php echo languageVariables("slot", "words", $languageType); ?> (24 <?php echo languageVariables("credi", "words", $languageType); ?>)</option>
                <option value="12" >+12 <?php echo languageVariables("slot", "words", $languageType); ?> (42 <?php echo languageVariables("credi", "words", $languageType); ?>)</option>
                <option value="18" >+18 <?php echo languageVariables("slot", "words", $languageType); ?> (70 <?php echo languageVariables("credi", "words", $languageType); ?>)</option>
                <?php } else if ($readAccount["inventorySlot"] == "18") { ?>
                <option value="6" selected>+6 <?php echo languageVariables("slot", "words", $languageType); ?> (24 <?php echo languageVariables("credi", "words", $languageType); ?>)</option>
                <option value="12" >+12 <?php echo languageVariables("slot", "words", $languageType); ?> (42 <?php echo languageVariables("credi", "words", $languageType); ?>)</option>
                <?php } else if ($readAccount["inventorySlot"] == "24") { ?>
                <option value="6" selected>+6 <?php echo languageVariables("slot", "words", $languageType); ?> (24 <?php echo languageVariables("credi", "words", $languageType); ?>)</option>
                <?php } else if ($readAccount["inventorySlot"] == "30") { ?>
                <option value="0" selected><?php echo languageVariables("slotBuyFull", "inventory", $languageType); ?></option>
                <?php } else { ?>
                <option value="6" selected>+6 <?php echo languageVariables("slot", "words", $languageType); ?> (24 <?php echo languageVariables("credi", "words", $languageType); ?>)</option>
                <option value="12" >+12 <?php echo languageVariables("slot", "words", $languageType); ?> (42 <?php echo languageVariables("credi", "words", $languageType); ?>)</option>
                <option value="18" >+18 <?php echo languageVariables("slot", "words", $languageType); ?> (70 <?php echo languageVariables("credi", "words", $languageType); ?>)</option>
                <?php } ?>
              </select>
              <svg class="form-select-icon icon-small-arrow">
                <use xlink:href="#svg-small-arrow"></use>
              </svg>
            </div>
          </div>
          <br>
          <div class="form-row split">
            <div class="form-item active">
              <button class="button full primary" type="submit" onclick="inventorySlotBuy('<?php echo $readAccount["inventorySlot"]; ?>');"><?php echo languageVariables("buy", "words", $languageType); ?></button>
            </div>
          </div>
        </div>
      </div>
      <!-- /INVENTORY SLOT-->
    </div>
</div>