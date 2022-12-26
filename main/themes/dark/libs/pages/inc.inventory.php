<?php AccountLoginControl(false); ?>
<link rel="stylesheet" href="/main/includes/packages/layouts/inventory/css/themes/dark/style.css?v=<?php echo $_CONFIG["VERSION_NUMBER"]-74; ?>">
<?php
$inventoryAscLimit = $readAccount["inventorySlot"];
$searchInventoryItem = $db->prepare("SELECT * FROM accountsInventory WHERE userID = ? ORDER BY id ASC LIMIT $inventoryAscLimit");
$searchInventoryItem->execute(array($readAccount["id"]));
$privateSlot = 30 - $readAccount["inventorySlot"];
$nullSlot = $readAccount["inventorySlot"] - $searchInventoryItem->rowCount();
?>
<div class="container-fluid">
    <div class="row">
        <div class="col-12 p-0">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <nav aria-label="breadcrumb" class="pt-lg-5 pt-4">
                            <ol class="breadcrumb rounded-none bg-dark--5 font-size-6">
                                <li class="breadcrumb-item"><a href="#" class="text-white font-100"><?php echo languageVariables("home", "words", $languageType); ?></a></li>
                                <li class="breadcrumb-item active"><a class="text-white font-100"><?php echo languageVariables("inventory", "words", $languageType); ?></a></li>
                            </ol>
                        </nav>
                    </div>
                    <div class="col-lg-12 col-12 pt-3 pb-5">
                        <div class="bg-dark--3 p-5">
                            <div class="d-flex mb-3 justify-content-between align-items-center">
                                <h3 class="text-secondary mb-0 font-100 font-size-6 letter-spacing-1 text-uppercase">
                                <?php echo languageVariables("items", "words", $languageType); ?>
                                </h3>
                                <a onclick="inventoryCheckAll();" class="btn float-right text-white m-0 line-height-1 text-uppercase letter-spacing-1 font-100 font-size-6 btn-outline-primary">
                                    <i class="fas fa-plus fa-sm mr-2 btn-icon"></i>
                                    <span class="btn-text">
                                    <?php echo languageVariables("allCheck", "words", $languageType); ?>
                                    </span>
                                </a>
                            </div>
                            <div class="inventory">
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
        </div>
    </div>
</div>