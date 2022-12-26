<?php if (AccountPermControl($readAccount["id"], "modules") == "PERMISSION_NOT_FOUND") { go(urlConverter("admin_perm_error", $languageType)); } ?>
<?php if (get("action") == "cardGame") { ?>
<?php if (AccountPermControl($readAccount["id"], "modules_card_game") == "PERMISSION_NOT_FOUND") { go(urlConverter("admin_perm_error", $languageType)); } ?>
  <?php if (get("target") == "create") { ?>
  <div class="page-content">
  <nav class="page-breadcrumb">
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="<?php echo urlConverter("admin_home", $languageType); ?>"><?php echo languageVariables("dashboard", "words", $languageType); ?></a></li>
      <li class="breadcrumb-item"><a href="#"><?php echo languageVariables("modules", "words", $languageType); ?></a></li>
      <li class="breadcrumb-item"><a href="<?php echo urlConverter("admin_modules_card_game", $languageType); ?>"><?php echo languageVariables("cardGame", "words", $languageType); ?></a></li>
      <li class="breadcrumb-item active" aria-current="page"><?php echo languageVariables("add", "words", $languageType); ?></li>
    </ol>
  </nav>
  <div class="row">
    <div class="col-md-12 grid-margin stretch-card">
      <div class="card">
        <div class="card-body">
          <h6 class="card-title"><?php echo languageVariables("cardGameCardAddTitle", "modules", $languageType); ?></h6>
          <?php
          require_once(__DR__."/main/includes/packages/class/csrf/class.php");
          $safeCsrfToken = new CSRF('csrf-sessions', 'csrf-token'); 
          if (isset($_POST["create"])) {
            if ($safeCsrfToken->validate('createToken')) {
              if (post("cardAddName") !== "" && (post("cardAddType") == "0" || post("cardAddPrice") !== "") && (post("cardAddType") == "1" || post("cardAddHours") !== "")) {
                if (isset($_POST["cardGameItemTypes"])) {
                  $cardGameChance = 0;
                  foreach($_POST['cardGameItemChance'] as $key => $value){
                    $cardGameChance += $_POST['cardGameItemChance'][$key];
                  }
                  if ($cardGameChance == "100") {
                    if (post("cardAddType") == "0") {
                      $cardGameHours = post("cardAddHours");
                      $cardGamePrice = "0";
                    } else if (post("cardAddType") == "1") {
                      $cardGameHours = "0";
                      $cardGamePrice = post("cardAddPrice");
                    }
                    $insertCardGame = $db->prepare("INSERT INTO cardGame (`name`, `type`, `hours`, `price`, `date`) VALUES (?,?,?,?,?)");
                    $insertCardGame->execute(array(post("cardAddName"), post("cardAddType"), $cardGameHours, $cardGamePrice, date("d.m.Y H:i:s")));
                    $insertCardGameStatus = true;
                    if ($insertCardGame) {
                      $searchCardGame = $db->query("SELECT * FROM cardGame ORDER BY id DESC LIMIT 1");
                      if (mysqlCount($searchCardGame) > 0) {
                        $readCardGame = fetch($searchCardGame);
                        foreach($_POST['cardGameItemRewards'] as $key => $value){
                          $insertCardGameItem = $db->prepare("INSERT INTO cardGameItem (`cardID`, `name`, `reward`, `type`, `image`, `chance`) VALUES (?, ?, ?, ?, ?, ?)");
                          $insertCardGameItem->execute(array($readCardGame["id"], $_POST['cardGameItemTitle'][$key], $_POST['cardGameItemRewards'][$key], $_POST['cardGameItemTypes'][$key], $_POST['cardGameItemImage'][$key], $_POST['cardGameItemChance'][$key]));
                        }
                      } else {
                        echo alert(languageVariables("alertSystem", "modules", $languageType), "danger", "0", "/");
                        $insertCardGameStatus = false;
                      }
                    } else {
                      echo alert(languageVariables("alertSystem", "modules", $languageType), "danger", "0", "/");
                      $insertCardGameStatus = false;
                    }
                    if ($insertCardGameStatus == true) {
                      echo alert(languageVariables("alertCardGameAddSuccess", "modules", $languageType), "success", "2", urlConverter("admin_modules_card_game", $languageType));
                    } else {
                      echo alert(languageVariables("alertSystem", "modules", $languageType), "danger", "0", "/");
                    }
                  } else {
                    echo alert(languageVariables("alertCardGameAddChance", "modules", $languageType), "danger", "0", "/");
                  }
                } else {
                  echo alert(languageVariables("alertCardGameAddRewardNone", "modules", $languageType), "danger", "0", "/");
                }
              } else {
                echo alert(languageVariables("alertNone", "modules", $languageType), "warning", "0", "/");
              }
            } else {
              echo alert(languageVariables("alertSystem", "modules", $languageType), "danger", "0", "/");
            }
          }
          ?>
          <form class="forms-sample" action="" method="POST" enctype="multipart/form-data">
            <div class="form-group row">
              <label for="modules-card-add-code" class="col-sm-3 col-form-label"><?php echo languageVariables("cardGameTitle", "modules", $languageType); ?></label>
              <div class="col-sm-9">
                <input type="text" class="form-control" id="modules-coupon-add-code" name="cardAddName" placeholder="<?php echo languageVariables("cardGameTitlePlaceholder", "modules", $languageType); ?>">
              </div>
            </div>
            <div class="form-group row">
              <label for="modules-card-add-type" class="col-sm-3 col-form-label"><?php echo languageVariables("cardGameType", "modules", $languageType); ?></label>
              <div class="col-sm-9">
                <select class="form-control" id="modules-card-add-type" name="cardAddType" data-toggle="cardTypeStatus">
                  <option value="0" selected><?php echo languageVariables("cardGameTypeOption0", "modules", $languageType); ?></option>
                  <option value="1"><?php echo languageVariables("cardGameTypeOption1", "modules", $languageType); ?></option>
                </select>
              </div>
            </div>
            <div style="display: block;" data-toggle="cardGameHoursInput">
              <div class="form-group row">
                <label for="modules-card-add-time" class="col-sm-3 col-form-label"><?php echo languageVariables("cardGameHours", "modules", $languageType); ?></label>
                <div class="col-sm-9">
                  <div class="input-group input-group-merge">
                    <div class="input-group-prepend">
                      <div class="input-group-text">
                        <span class="far fa-clock"></span>
                      </div>
                    </div>
                    <input type="number" class="form-control" id="modules-card-add-time" name="cardAddHours" placeholder="<?php echo languageVariables("cardGameHoursPlaceholder", "modules", $languageType); ?>">
                  </div>
                </div>
                <span class="col-sm-12 mt-2"><?php echo languageVariables("cardGameHoursNote", "modules", $languageType); ?></span>
              </div>
            </div>
            <div style="display: none;" data-toggle="cardGamePriceInput">
              <div class="form-group row">
                <label for="modules-card-add-price" class="col-sm-3 col-form-label"><?php echo languageVariables("cardGamePrice", "modules", $languageType); ?></label>
                <div class="col-sm-9">
                  <div class="input-group input-group-merge">
                    <div class="input-group-prepend">
                      <div class="input-group-text">
                        <span class="fa fa-lira-sign"></span>
                      </div>
                    </div>
                    <input type="number" class="form-control" id="modules-card-add-price" name="cardAddPrice" placeholder="<?php echo languageVariables("cardGamePricePlaceholder", "modules", $languageType); ?>">
                  </div>
                </div>
              </div>
            </div>
            <div class="form-group row">
              <label for="modules-coupon-add-rewards" class="col-sm-3 col-form-label"><?php echo languageVariables("cardGameRewards", "modules", $languageType); ?></label>
              <div class="col-sm-9">
                <div class="table-responsive">
                  <table class="table table-sm table-hover table-nowrap array-table">
                    <thead>
                      <tr>
                        <th class="text-center align-middle"><?php echo languageVariables("cardGameRewardType", "modules", $languageType); ?></th>
                        <th class="text-center align-middle"><?php echo languageVariables("cardGameRewardTitle", "modules", $languageType); ?></th>
                        <th class="text-center align-middle"><?php echo languageVariables("cardGameReward", "modules", $languageType); ?></th>
                        <th class="text-center align-middle"><?php echo languageVariables("cardGameRewardChance", "modules", $languageType); ?></th>
                        <th class="text-center align-middle"><?php echo languageVariables("cardGameRewardImage", "modules", $languageType); ?></th>
                        <th class="text-center align-middle">
                          <button type="button" class="btn btn-primary btn-icon" add-item="credit" item-type="card">
                            <i data-feather="plus-square"></i>
                          </button>
                          <button type="button" class="btn btn-danger btn-icon ml-2" add-item="product" item-type="card">
                            <i data-feather="gift"></i>
                          </button>
                          <button type="button" class="btn btn-warning btn-icon text-white ml-2" add-item="rust" item-type="card">
                            <i data-feather="compass"></i>
                          </button>
                        </th>
                      </tr>
                    </thead>
                    <tbody data-toggle="itemTable">
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
            <div style="float: right;">
              <?php echo $safeCsrfToken->input("createToken"); ?>
              <button type="submit" class="btn btn-primary mr-2" name="create"><?php echo languageVariables("add", "words", $languageType); ?></button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
  <?php } else if (get("target") == "update") { ?>
    <?php if (isset($_GET["cardID"])) { ?>
      <?php 
        $searchCardGame = $db->prepare("SELECT * FROM cardGame WHERE id = ?");
        $searchCardGame->execute(array(get("cardID")));
        if (mysqlCount($searchCardGame) > 0) {
          $readCardGame = fetch($searchCardGame);
      ?>
<div class="page-content">
  <nav class="page-breadcrumb">
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="<?php echo urlConverter("admin_home", $languageType); ?>"><?php echo languageVariables("dashboard", "words", $languageType); ?></a></li>
      <li class="breadcrumb-item"><a href="#"><?php echo languageVariables("modules", "words", $languageType); ?></a></li>
      <li class="breadcrumb-item"><a href="<?php echo urlConverter("admin_modules_card_game", $languageType); ?>"><?php echo languageVariables("cardGame", "words", $languageType); ?></a></li>
      <li class="breadcrumb-item active" aria-current="page"><?php echo $readCardGame["id"]."# ".$readCardGame["name"]; ?></li>
    </ol>
  </nav>
  <div class="row">
    <div class="col-md-12 grid-margin stretch-card">
      <div class="card">
        <div class="card-body">
          <h6 class="card-title"><?php echo languageVariables("cardGameTypeOption1", "modules", $languageType); ?></h6>
          <?php
          require_once(__DR__."/main/includes/packages/class/csrf/class.php");
          $safeCsrfToken = new CSRF('csrf-sessions', 'csrf-token'); 
          if (isset($_POST["update"])) {
            if ($safeCsrfToken->validate('updateToken')) {
              if (post("cardEditName") !== "" && (post("cardEditType") == "0" || post("cardEditPrice") !== "") && (post("cardEditType") == "1" || post("cardEditHours") !== "")) {
                if (isset($_POST["cardGameItemTypes"])) {
                  $cardGameChance = 0;
                  foreach($_POST['cardGameItemChance'] as $key => $value){
                    $cardGameChance += $_POST['cardGameItemChance'][$key];
                  }
                  if ($cardGameChance == "100") {
                    if (post("cardEditType") == "0") {
                      $cardGameHours = post("cardEditHours");
                      $cardGamePrice = "0";
                    } else if (post("cardEditType") == "1") {
                      $cardGameHours = "0";
                      $cardGamePrice = post("cardEditPrice");
                    }
                    $updateCardGame = $db->prepare("UPDATE cardGame SET name = ?, type = ?, hours = ?, price = ? WHERE id = ?");
                    $updateCardGame->execute(array(post("cardEditName"), post("cardEditType"), $cardGameHours, $cardGamePrice, $readCardGame["id"]));
                    $removeCardGameItem = $db->prepare("DELETE FROM cardGameItem WHERE cardID = ?");
                    $removeCardGameItem->execute(array($readCardGame["id"]));
                    foreach($_POST['cardGameItemRewards'] as $key => $value){
                      $insertCardGameItem = $db->prepare("INSERT INTO cardGameItem (`cardID`, `name`, `reward`, `type`, `image`, `chance`) VALUES (?, ?, ?, ?, ?, ?)");
                      $insertCardGameItem->execute(array($readCardGame["id"], $_POST['cardGameItemTitle'][$key], $_POST['cardGameItemRewards'][$key], $_POST['cardGameItemTypes'][$key], $_POST['cardGameItemImage'][$key], $_POST['cardGameItemChance'][$key]));
                    }
                    echo alert(languageVariables("alertSaveChanges", "modules", $languageType), "success", "2", "");
                  } else {
                    echo alert(languageVariables("alertCardGameAddChance", "modules", $languageType), "danger", "0", "/");
                  }
                } else {
                  echo alert(languageVariables("alertCardGameAddRewardNone", "modules", $languageType), "danger", "0", "/");
                }
              } else {
                echo alert(languageVariables("alertNone", "modules", $languageType), "warning", "0", "/");
              }
            } else {
              echo alert(languageVariables("alertSystem", "modules", $languageType), "danger", "0", "/");
            }
          }
          ?>
          <form class="forms-sample" action="" method="POST" enctype="multipart/form-data">
            <div class="form-group row">
              <label for="modules-card-add-code" class="col-sm-3 col-form-label"><?php echo languageVariables("cardGameTypeOption1", "modules", $languageType); ?></label>
              <div class="col-sm-9">
                <input type="text" class="form-control" id="modules-coupon-add-code" name="cardEditName" placeholder="<?php echo languageVariables("cardGameTypeOption1", "modules", $languageType); ?>" value="<?php echo $readCardGame["name"]; ?>">
              </div>
            </div>
            <div class="form-group row">
              <label for="modules-card-add-type" class="col-sm-3 col-form-label"><?php echo languageVariables("cardGameTypeOption1", "modules", $languageType); ?></label>
              <div class="col-sm-9">
                <select class="form-control" id="modules-card-add-type" name="cardEditType" data-toggle="cardTypeStatus">
                  <option value="0" <?php if ($readCardGame["type"] == "0") { echo "selected"; } ?>><?php echo languageVariables("cardGameTypeOption1", "modules", $languageType); ?></option>
                  <option value="1" <?php if ($readCardGame["type"] == "1") { echo "selected"; } ?>><?php echo languageVariables("cardGameTypeOption1", "modules", $languageType); ?></option>
                </select>
              </div>
            </div>
            <div <?php if ($readCardGame["type"] == "1") { echo "style=\"display: none;\""; } ?> data-toggle="cardGameHoursInput">
              <div class="form-group row">
                <label for="modules-card-add-time" class="col-sm-3 col-form-label"><?php echo languageVariables("cardGameTypeOption1", "modules", $languageType); ?></label>
                <div class="col-sm-9">
                  <div class="input-group input-group-merge">
                    <div class="input-group-prepend">
                      <div class="input-group-text">
                        <span class="far fa-clock"></span>
                      </div>
                    </div>
                    <input type="number" class="form-control" id="modules-card-add-time" name="cardEditHours" placeholder="<?php echo languageVariables("cardGameTypeOption1", "modules", $languageType); ?>" value="<?php if ($readCardGame["type"] == "0") { echo $readCardGame["hours"]; } ?>">
                  </div>
                </div>
                <span class="col-sm-12 mt-2"><?php echo languageVariables("cardGameTypeOption1", "modules", $languageType); ?></span>
              </div>
            </div>
            <div <?php if ($readCardGame["type"] == "0") { echo "style=\"display: none;\""; } ?> data-toggle="cardGamePriceInput">
              <div class="form-group row">
                <label for="modules-card-add-price" class="col-sm-3 col-form-label"><?php echo languageVariables("cardGameTypeOption1", "modules", $languageType); ?></label>
                <div class="col-sm-9">
                  <div class="input-group input-group-merge">
                    <div class="input-group-prepend">
                      <div class="input-group-text">
                        <span class="fa fa-lira-sign"></span>
                      </div>
                    </div>
                    <input type="number" class="form-control" id="modules-card-add-price" name="cardEditPrice" placeholder="<?php echo languageVariables("cardGameTypeOption1", "modules", $languageType); ?>" value="<?php if ($readCardGame["type"] == "1") { echo $readCardGame["price"]; } ?>">
                  </div>
                </div>
              </div>
            </div>
            <div class="form-group row">
              <label for="modules-coupon-add-rewards" class="col-sm-3 col-form-label"><?php echo languageVariables("cardGameTypeOption1", "modules", $languageType); ?></label>
              <div class="col-sm-9">
                <div class="table-responsive">
                  <table class="table table-sm table-hover table-nowrap array-table">
                    <thead>
                      <tr>
                        <th class="text-center align-middle"><?php echo languageVariables("cardGameTypeOption1", "modules", $languageType); ?></th>
                        <th class="text-center align-middle"><?php echo languageVariables("cardGameTypeOption1", "modules", $languageType); ?></th>
                        <th class="text-center align-middle"><?php echo languageVariables("cardGameTypeOption1", "modules", $languageType); ?></th>
                        <th class="text-center align-middle"><?php echo languageVariables("cardGameTypeOption1", "modules", $languageType); ?></th>
                        <th class="text-center align-middle"><?php echo languageVariables("cardGameTypeOption1", "modules", $languageType); ?></th>
                        <th class="text-center align-middle">
                          <button type="button" class="btn btn-primary btn-icon" add-item="credit" item-type="card">
                            <i data-feather="plus-square"></i>
                          </button>
                          <button type="button" class="btn btn-danger btn-icon ml-2" add-item="product" item-type="card">
                            <i data-feather="gift"></i>
                          </button>
                          <button type="button" class="btn btn-warning btn-icon text-white ml-2" add-item="rust" item-type="card">
                            <i data-feather="compass"></i>
                          </button>
                        </th>
                      </tr>
                    </thead>
                    <tbody data-toggle="itemTable">
                    <?php $searchCardGameItem = $db->prepare("SELECT * FROM cardGameItem WHERE cardID = ? ORDER BY id ASC"); ?>
                    <?php $searchCardGameItem->execute(array($readCardGame["id"])); ?>
                    <?php foreach ($searchCardGameItem as $readCardGameItem) { ?>
                      <?php if ($readCardGameItem["type"] == "0") { ?>
                      <tr id="removeID-<?php echo $readCardGameItem["id"]; ?>">
                        <td class="ml-2">
                          <div class="input-group">
                            <input type="hidden" name="cardGameItemTypes[]" value="0"><input type="text" class="form-control" placeholder="<?php echo languageVariables("modulesRewardType", "javascript", $languageType); ?>" value="<?php echo languageVariables("modulesRewardNone", "javascript", $languageType); ?>" readonly>
                          </div>
                        </td>
                        <td class="text-center align-middle">
                          <div class="form-group row">
                            <div class="col-sm-12">
                              <input type="text" class="form-control" name="cardGameItemTitle[]" placeholder="<?php echo languageVariables("modulesRewardTitle", "javascript", $languageType); ?>" value="<?php echo $readCardGameItem["name"]; ?>">
                            </div>
                          </div>
                        </td>
                        <td class="text-center align-middle">
                          <div class="form-group row">
                            <label class="col-sm-12 col-form-label"><?php echo languageVariables("modulesNotReward", "javascript", $languageType); ?></label>
                            <input type="hidden" name="cardGameItemRewards[]" value="0">
                          </div>
                        </td>
                        <td class="text-center align-middle">
                          <div class="form-group row">
                            <div class="col-sm-12">
                              <div class="input-group input-group-merge">
                                <div class="input-group-prepend">
                                  <div class="input-group-text">
                                    <span class="fa fa-percent"></span>
                                  </div>
                                </div>
                                <input type="number" class="form-control" name="cardGameItemChance[]" placeholder="<?php echo languageVariables("modulesRewardChance", "javascript", $languageType); ?>" value="<?php echo $readCardGameItem["chance"]; ?>">
                              </div>
                            </div>
                          </div>
                        </td>
                        <td class="text-center align-middle">
                          <div class="form-group row">
                            <div class="col-sm-12">
                              <input type="text" class="form-control" name="cardGameItemImage[]" placeholder="<?php echo languageVariables("modulesRewardChance", "javascript", $languageType); ?>" value="<?php echo $readCardGameItem["image"]; ?>">
                            </div>
                          </div>
                        </td>
                        <td class="text-center align-middle">
                          <button type="button" class="btn btn-danger btn-icon" remove-item="button" remove-id="<?php echo $readCardGameItem["id"]; ?>">
                            <span class="far fa-trash-alt"></span>
                          </button>
                        </td>
                      </tr>
                      <?php } else if ($readCardGameItem["type"] == "1") { ?>
                      <tr id="removeID-<?php echo $readCardGameItem["id"]; ?>">
                        <td class="ml-2">
                          <div class="input-group">
                            <input type="hidden" name="cardGameItemTypes[]" value="1"><input type="text" class="form-control" placeholder="<?php echo languageVariables("modulesRewardType", "javascript", $languageType); ?>" value="<?php echo languageVariables("credit", "words", $languageType); ?>" readonly>
                          </div>
                        </td>
                        <td class="text-center align-middle">
                          <div class="form-group row">
                            <div class="col-sm-12">
                              <input type="text" class="form-control" name="cardGameItemTitle[]" placeholder="<?php echo languageVariables("modulesRewardTitle", "javascript", $languageType); ?>" value="<?php echo $readCardGameItem["name"]; ?>">
                            </div>
                          </div>
                        </td>
                        <td class="text-center align-middle">
                          <div class="input-group input-group-merge">
                            <div class="input-group-prepend"> 
                              <div class="input-group-text"> 
                                <span class="fa fa-lira-sign"></span>
                              </div>
                            </div>
                            <input type="text" class="form-control form-control-prepended" name="cardGameItemRewards[]" placeholder="<?php echo languageVariables("modulesRewardAmount", "javascript", $languageType); ?>" value="<?php echo $readCardGameItem["reward"]; ?>">
                          </div>
                        </td>
                        <td class="text-center align-middle">
                          <div class="form-group row">
                            <div class="col-sm-12">
                              <div class="input-group input-group-merge">
                                <div class="input-group-prepend">
                                  <div class="input-group-text">
                                    <span class="fa fa-percent"></span>
                                  </div>
                                </div>
                                <input type="number" class="form-control" name="cardGameItemChance[]" placeholder="<?php echo languageVariables("modulesRewardChance", "javascript", $languageType); ?>" value="<?php echo $readCardGameItem["chance"]; ?>">
                              </div>
                            </div>
                          </div>
                        </td>
                        <td class="text-center align-middle">
                          <div class="form-group row">
                            <div class="col-sm-12">
                              <input type="text" class="form-control" name="cardGameItemImage[]" placeholder="<?php echo languageVariables("modulesRewardChance", "javascript", $languageType); ?>" value="<?php echo $readCardGameItem["image"]; ?>">
                            </div>
                          </div>
                        </td>
                        <td class="text-center align-middle">
                          <button type="button" class="btn btn-danger btn-icon" remove-item="button" remove-id="<?php echo $readCardGameItem["id"]; ?>">
                            <span class="far fa-trash-alt"></span>
                          </button>
                        </td>
                      </tr>
                      <?php } else if ($readCardGameItem["type"] == "2") { ?>
                      <tr id="removeID-<?php echo $readCardGameItem["id"]; ?>">
                        <td class="ml-2">
                          <div class="input-group">
                            <input type="hidden" name="cardGameItemTypes[]" value="2"><input type="text" class="form-control" placeholder="<?php echo languageVariables("modulesRewardType", "javascript", $languageType); ?>" value="<?php echo languageVariables("product", "words", $languageType); ?>" readonly>
                          </div>
                        </td>
                        <td class="text-center align-middle">
                          <div class="form-group row">
                            <div class="col-sm-12">
                              <input type="text" class="form-control" name="cardGameItemTitle[]" placeholder="<?php echo languageVariables("modulesRewardTitle", "javascript", $languageType); ?>" value="<?php echo $readCardGameItem["name"]; ?>">
                            </div>
                          </div>
                        </td>
                        <td class="text-center align-middle">
                          <div class="form-group row">
                            <div class="col-sm-12">
                              <select class="form-control" name="cardGameItemRewards[]">
                                <?php $searchServers = $db->query("SELECT * FROM serverList ORDER BY id ASC"); ?>
                                <?php if (mysqlCount($searchServers) > 0): ?>
                                  <?php foreach ($searchServers as $readServer): ?>
                                    <?php
                                      $searchCategories = $db->prepare("SELECT * FROM serverCategory WHERE serverID = ? ORDER BY id ASC");
                                      $searchCategories->execute(array($readServer["id"]));
                                    ?>
                                    <?php if (mysqlCount($searchCategories) > 0): ?>
                                      <?php foreach ($searchCategories as $readCategory): ?>
                                        <?php echo "<optgroup label=\"".$readServer["name"]." - ".$readCategory["name"]."\">"; ?>
                                        <?php
                                          $searchProducts = $db->prepare("SELECT * FROM categoryProduct WHERE categoryID = ? ORDER BY id ASC");
                                          $searchProducts->execute(array($readCategory["id"]));
                                        ?>
                                        <?php if (mysqlCount($searchProducts) > 0): ?>
                                          <?php foreach ($searchProducts as $readProduct): ?>
                                            <?php if ($readCardGameItem["reward"] == $readProduct["id"]): ?>
                                              <?php echo "<option value=\"".$readProduct["id"]."\" selected>".$readProduct["name"]."</option>"; ?>
                                            <?php else: ?>
                                              <?php echo "<option value=\"".$readProduct["id"]."\">".$readProduct["name"]."</option>"; ?>
                                            <?php endif; ?>
                                          <?php endforeach; ?>
                                        <?php endif; ?>
                                        <?php echo "</optgroup>"; ?>
                                      <?php endforeach; ?>
                                    <?php endif; ?>
                                  <?php endforeach; ?>
                                <?php else: ?>
                                  <?php echo "<option value=\"0\">".languageVariables("ajaxNotServerAlert", "javascript", $languageType)."</option>"; ?>
                                <?php endif; ?>
                              </select>
                            </div>
                          </div>
                        </td>
                        <td class="text-center align-middle">
                          <div class="form-group row">
                            <div class="col-sm-12">
                              <div class="input-group input-group-merge">
                                <div class="input-group-prepend">
                                  <div class="input-group-text">
                                    <span class="fa fa-percent"></span>
                                  </div>
                                </div>
                                <input type="number" class="form-control" name="cardGameItemChance[]" placeholder="<?php echo languageVariables("modulesRewardChance", "javascript", $languageType); ?>" value="<?php echo $readCardGameItem["chance"]; ?>">
                              </div>
                            </div>
                          </div>
                        </td>
                        <td class="text-center align-middle">
                          <div class="form-group row">
                            <div class="col-sm-12">
                              <input type="text" class="form-control" name="cardGameItemImage[]" placeholder="<?php echo languageVariables("modulesRewardChance", "javascript", $languageType); ?>" value="<?php echo $readCardGameItem["image"]; ?>">
                            </div>
                          </div>
                        </td>
                        <td class="text-center align-middle">
                          <button type="button" class="btn btn-danger btn-icon" remove-item="button" remove-id="<?php echo $readCardGameItem["id"]; ?>">
                            <span class="far fa-trash-alt"></span>
                          </button>
                        </td>
                      </tr>
                      <?php } ?>
                    <?php } ?>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
            <div style="float: right;">
              <?php echo $safeCsrfToken->input("updateToken"); ?>
              <button type="submit" class="btn btn-primary mr-2" name="update"><?php echo languageVariables("saveChanges", "words", $languageType); ?></button>
              <button type="button" class="btn btn-danger btn-icon" confirm-element="confirm" confirm-text="<?php echo languageVariables("deleteAlert", "words", $languageType); ?>" direct-href="<?php echo urlConverter("admin_modules_card_game_delete", $languageType); ?>/<?php echo $readCardGame["id"]; ?>" data-toggle="tooltip" data-placement="top" title="<?php echo languageVariables("remove", "words", $languageType); ?>"><i data-feather="trash-2"></i></button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
      <?php } else { go(urlConverter("admin_modules_card_game", $languageType)); } ?>
    <?php } else { ?>
      <?php 
      if (isset($_GET["pageNumber"])) {
        if (!is_numeric(get("pageNumber"))) {
          $_GET["pageNumber"] = 1;
        }
        $pageNumber = intval(get("pageNumber"));
      } else {
        $pageNumber = 1;
      }

      $pageSubCount = 50;
      $pageItemCount = pageItemCount("cardGame", $pageSubCount);

      if ($pageNumber > $pageItemCount) {
        $pageNumber = 1;
      }

      $queryPageItemCount = $pageNumber * $pageSubCount - $pageSubCount;
      $maxPageItemCount = 5;
    ?>
      <?php $searchCardGame = $db->query("SELECT * FROM cardGame ORDER BY id DESC LIMIT $queryPageItemCount, $pageSubCount"); ?>
<div class="page-content">
  <div class="row">
    <div class="col">
      <nav class="page-breadcrumb">
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="<?php echo urlConverter("admin_home", $languageType); ?>"><?php echo languageVariables("dashboard", "words", $languageType); ?></a></li>
          <li class="breadcrumb-item"><a href="#"><?php echo languageVariables("modules", "words", $languageType); ?></a></li>
          <li class="breadcrumb-item"><a href="<?php echo urlConverter("admin_modules_card_game", $languageType); ?>"><?php echo languageVariables("cardGame", "words", $languageType); ?></a></li>
          <li class="breadcrumb-item active" aria-current="page"><?php echo languageVariables("edit", "words", $languageType); ?></li>
        </ol>
      </nav>
    </div>
    <div class="col-auto">
      <nav aria-label="Page navigation example" style="floatt: right;">
        <ul class="pagination">
          <li class="page-item <?php echo (($pageNumber == "1") ? "disabled" : ""); ?>"><a class="page-link" href="<?php echo urlConverter("admin_modules_card_game_p", $languageType)."/".($pageNumber-1); ?>"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-left"><polyline points="15 18 9 12 15 6"></polyline></svg></a></li>
          <?php 
            for ($i = $pageNumber - $maxPageItemCount; $i < $pageNumber + $maxPageItemCount + 1; $i++) {
					    if ($i > 0 && $i <= $pageItemCount) {
          ?>
          <li class="page-item <?php echo (($pageNumber == $i) ? "active" : ""); ?>"><a class="page-link" href="<?php echo urlConverter("admin_modules_card_game_p", $languageType)."/".$i; ?>"><?php echo $i; ?></a></li>
          <?php } } ?>
          <li class="page-item <?php echo (($pageItemCount == $pageNumber) ? "disabled" : ""); ?>"><a class="page-link" href="<?php echo urlConverter("admin_modules_card_game_p", $languageType)."/".($pageNumber+1); ?>"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-right"><polyline points="9 18 15 12 9 6"></polyline></svg></a></li>
        </ul>
      </nav>
    </div>
  </div>
  <div class="row">
    <div class="col-md-12">
    <?php if (mysqlCount($searchCardGame) > 0) { ?>
      <div class="card" data-toggle="lists" data-lists-values='["cardID", "cardName", "cardType", "cardExpiry", "cardDate"]'>
        <div class="card-header">
          <div class="row align-items-center">
            <div class="col">
              <div class="row align-items-center">
                <div class="col-auto pr-0">
                  <span data-feather="search"></span>
                </div>
                <div class="col">
                  <input type="search" class="form-control search" style="border: 0; background: none;" name="search" placeholder="<?php echo languageVariables("search", "words", $languageType); ?>">
                </div>
              </div>
            </div>
            <div class="col-auto">
              <a class="btn btn-sm btn-primary" href="<?php echo urlConverter("admin_modules_card_game_add", $languageType); ?>"><?php echo languageVariables("add", "words", $languageType); ?></a>
            </div>
          </div>
        </div>
        <div class="card-body p-0">
          <div class="table-responsive">
            <table class="table table-hover">
              <thead>
                <tr>
                  <th class="text-center" style="width: 40px;"><a href="#" class="text-muted sort" data-sort="cardID">#ID</a></th>
                  <th class="text-center"><a href="#" class="text-muted sort" data-sort="cardName"><?php echo languageVariables("cardGameTableCardName", "modules", $languageType); ?></a></th>
                  <th class="text-center"><a href="#" class="text-muted sort" data-sort="cardType"><?php echo languageVariables("cardGameTableCardType", "modules", $languageType); ?></a></th>
                  <th class="text-center"><a href="#" class="text-muted sort" data-sort="cardExpriy"><?php echo languageVariables("cardGameTableCardPaid", "modules", $languageType); ?></a></th>
                  <th class="text-center"><a href="#" class="text-muted sort" data-sort="cardDate"><?php echo languageVariables("cardGameTableCardCreateDate", "modules", $languageType); ?></a></th>
                  <th class="text-right">&nbsp;</th>
                </tr>
              </thead>
              <tbody class="list">
               <?php foreach ($searchCardGame as $readCardGame) { ?>
                <tr>
                  <td class="cardID text-center" style="width: 40px;"><a href="<?php echo urlConverter("admin_modules_card_game", $languageType); ?>/<?php echo $readCardGame["id"]; ?>">#<?php echo $readCardGame["id"]; ?></a></td>
                  <td class="cardName text-center"><a href="<?php echo urlConverter("admin_modules_card_game", $languageType); ?>/<?php echo $readCardGame["id"]; ?>"><?php echo $readCardGame["name"]; ?></a></td>
                  <td class="cardType text-center"><?php if ($readCardGame["type"] == "0") { echo languageVariables("cardGameTypeOption0", "modules", $languageType); } else { echo languageVariables("cardGameTypeOption0", "modules", $languageType); } ?></td>
                  <td class="cardExpriy text-center"><?php if ($readCardGame["type"] == "0") { echo $readCardGame["hours"]." ".languageVariables("cardGameHoursCount", "modules", $languageType); } else { echo $readCardGame["price"]." ".languageVariables("credit", "words", $languageType); } ?></td>
                  <td class="cardDate text-center"><?php echo checkTime($readCardGame["date"]); ?></td>
                  <td class="text-right">
                    <button type="button" class="btn btn-success btn-icon" direct-element="direct" direct-href="<?php echo urlConverter("admin_modules_card_game", $languageType); ?>/<?php echo $readCardGame["id"]; ?>" data-toggle="tooltip" data-placement="top" title="<?php echo languageVariables("edit", "words", $languageType); ?>"><i data-feather="edit-2"></i></button>
                    <button type="button" class="btn btn-danger btn-icon" confirm-element="confirm" confirm-text="<?php echo languageVariables("deleteAlert", "words", $languageType); ?>" direct-href="<?php echo urlConverter("admin_modules_card_game_delete", $languageType); ?>/<?php echo $readCardGame["id"]; ?>" data-toggle="tooltip" data-placement="top" title="<?php echo languageVariables("remove", "words", $languageType); ?>"><i data-feather="trash-2"></i></button>
                  </td>
                </tr>
              <?php } ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    <?php } else { echo alert(languageVariables("alertPageNone", "modules", $languageType), "danger", "0", "/"); } ?>
    </div>
  </div>
</div>
    <?php } ?>
  <?php } else if (get("target") == "history") { ?>
    <?php if (isset($_GET["historyID"])) { ?>
      <?php
        $removeHistory = $db->prepare("DELETE FROM cardGameHistory WHERE id = ?");
        $removeHistory->execute(array(get("historyID")));
        go(urlConverter("admin_modules_card_game_history", $languageType));
      ?>
    <?php } else { ?>
      <?php 
      if (isset($_GET["pageNumber"])) {
        if (!is_numeric(get("pageNumber"))) {
          $_GET["pageNumber"] = 1;
        }
        $pageNumber = intval(get("pageNumber"));
      } else {
        $pageNumber = 1;
      }

      $pageSubCount = 50;
      $pageItemCount = pageItemCount("cardGameHistory", $pageSubCount);

      if ($pageNumber > $pageItemCount) {
        $pageNumber = 1;
      }

      $queryPageItemCount = $pageNumber * $pageSubCount - $pageSubCount;
      $maxPageItemCount = 5;
    ?>
      <?php $searchCardGameHistory = $db->query("SELECT * FROM cardGameHistory ORDER BY id DESC LIMIT $queryPageItemCount, $pageSubCount"); ?>
<div class="page-content">
  <div class="row">
    <div class="col">
      <nav class="page-breadcrumb">
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="<?php echo urlConverter("admin_home", $languageType); ?>"><?php echo languageVariables("dashboard", "words", $languageType); ?></a></li>
          <li class="breadcrumb-item"><a href="#"><?php echo languageVariables("modules", "words", $languageType); ?></a></li>
          <li class="breadcrumb-item"><a href="<?php echo urlConverter("admin_modules_card_game", $languageType); ?>"><?php echo languageVariables("cardGame", "words", $languageType); ?></a></li>
          <li class="breadcrumb-item active" aria-current="page"><?php echo languageVariables("history", "words", $languageType); ?></li>
        </ol>
      </nav>
    </div>
    <div class="col-auto">
      <nav aria-label="Page navigation example" style="floatt: right;">
        <ul class="pagination">
          <li class="page-item <?php echo (($pageNumber == "1") ? "disabled" : ""); ?>"><a class="page-link" href="<?php echo urlConverter("admin_modules_card_game_history_p", $languageType)."/".($pageNumber-1); ?>"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-left"><polyline points="15 18 9 12 15 6"></polyline></svg></a></li>
          <?php 
            for ($i = $pageNumber - $maxPageItemCount; $i < $pageNumber + $maxPageItemCount + 1; $i++) {
					    if ($i > 0 && $i <= $pageItemCount) {
          ?>
          <li class="page-item <?php echo (($pageNumber == $i) ? "active" : ""); ?>"><a class="page-link" href="<?php echo urlConverter("admin_modules_card_game_history_p", $languageType)."/".$i; ?>"><?php echo $i; ?></a></li>
          <?php } } ?>
          <li class="page-item <?php echo (($pageItemCount == $pageNumber) ? "disabled" : ""); ?>"><a class="page-link" href="<?php echo urlConverter("admin_modules_card_game_history_p", $languageType)."/".($pageNumber+1); ?>"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-right"><polyline points="9 18 15 12 9 6"></polyline></svg></a></li>
        </ul>
      </nav>
    </div>
  </div>
  <div class="row">
    <div class="col-md-12">
    <?php if (mysqlCount($searchCardGameHistory) > 0) { ?>
      <div class="card" data-toggle="lists" data-lists-values='["historiesID", "historiesUserName", "historiesRewards", "historiesGameName", "historiesStatus", "historiesDate"]'>
        <div class="card-header">
          <div class="row align-items-center">
            <div class="col">
              <div class="row align-items-center">
                <div class="col-auto pr-0">
                  <span data-feather="search"></span>
                </div>
                <div class="col">
                  <input type="search" class="form-control search" style="border: 0; background: none;" name="search" placeholder="<?php echo languageVariables("search", "words", $languageType); ?>">
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="card-body p-0">
          <div class="table-responsive">
            <table class="table table-hover">
              <thead>
                <tr>
                  <th class="text-center" style="width: 40px;"><a href="#" class="text-muted sort" data-sort="historiesID">#ID</a></th>
                  <th class="text-center"><a href="#" class="text-muted sort" data-sort="historiesUserName"><?php echo languageVariables("username", "words", $languageType); ?></a></th>
                  <th class="text-center"><a href="#" class="text-muted sort" data-sort="historiesRewards"><?php echo languageVariables("cardGameHistoryRewards", "modules", $languageType); ?></a></th>
                  <th class="text-center"><a href="#" class="text-muted sort" data-sort="historiesGameName"><?php echo languageVariables("cardGameHistoryGameName", "modules", $languageType); ?></a></th>
                  <th class="text-center"><a href="#" class="text-muted sort" data-sort="historiesStatus"><?php echo languageVariables("status", "words", $languageType); ?></a></th>
                  <th class="text-center"><a href="#" class="text-muted sort" data-sort="historiesDate"><?php echo languageVariables("date", "words", $languageType); ?></a></th>
                  <th class="text-right">&nbsp;</th>
                </tr>
              </thead>
              <tbody class="list">
               <?php foreach ($searchCardGameHistory as $readCardGameHistory) { ?>
               <?php $searchCardGame = $db->prepare("SELECT * FROM cardGame WHERE id = ?"); ?>
               <?php $searchCardGame->execute(array($readCardGameHistory["cardID"])); ?>
               <?php if (mysqlCount($searchCardGame) > 0) { ?>
               <?php $readCardGame = fetch($searchCardGame); ?>
                <tr>
                  <td class="historiesID text-center" style="width: 40px;"><a href="<?php echo urlConverter("admin_player", $languageType); ?>/<?php echo $readCardGameHistory["username"]; ?>">#<?php echo $readCardGameHistory["id"]; ?></a></td>
                  <td class="historiesUserName text-center"><a href="<?php echo urlConverter("admin_player", $languageType); ?>/<?php echo $readCardGameHistory["username"]; ?>"><?php echo $readCardGameHistory["username"]; ?></a></td>
                  <td class="historiesRewards text-center"><?php echo $readCardGameHistory["reward"]; ?></td>
                  <td class="historiesGameName text-center"><?php echo $readCardGame["name"]." (". (($readCardGame["type"] == "0") ? languageVariables("cardGameTypeOption0", "modules", $languageType) : languageVariables("cardGameTypeOption1", "modules", $languageType)) .")"; ?></td>
                  <td class="historiesStatus text-center"><?php if ($readCardGameHistory["rewardType"] == "winner") { echo languageVariables("cardGameWon", "modules", $languageType); } else { echo languageVariables("cardGameLoser", "modules", $languageType); } ?></td>
                  <td class="historiesDate text-center"><?php echo checkTime($readCardGameHistory["date"]); ?></td>
                  <td class="text-right">
                    <button type="button" class="btn btn-danger btn-icon" style="border-radius: 250px;" confirm-element="confirm" confirm-text="<?php echo languageVariables("deleteAlert", "words", $languageType); ?>" direct-href="<?php echo urlConverter("admin_modules_card_game_delete", $languageType); ?>/<?php echo $readCardGameHistory["id"]; ?>" data-toggle="tooltip" data-placement="top" title="<?php echo languageVariables("remove", "words", $languageType); ?>"><i class="fas fa-trash-alt"></i></button>
                  </td>
                </tr>
              <?php } ?>
              <?php } ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    <?php } else { echo alert(languageVariables("alertPageNone", "modules", $languageType), "danger", "0", "/"); } ?>
    </div>
  </div>
</div>
    <?php } ?>
  <?php } else if (get("target") == "remove" && isset($_GET["cardID"])) { ?>
    <?php
      $removeCardGame = $db->prepare("DELETE FROM cardGame WHERE id = ?");
      $removeCardGame->execute(array(get("cardID")));
      $removeCardGameItem = $db->prepare("DELETE FROM cardGameItem WHERE cardID = ?");
      $removeCardGameItem->execute(array(get("cardID")));
      $removeCardGameHistory = $db->prepare("DELETE FROM cardGameHistory WHERE cardID = ?");
      $removeCardGameHistory->execute(array(get("cardID")));
      go(urlConverter("admin_modules_card_game", $languageType));
    ?>
  <?php } ?>
<?php } else if (get("action") == "coupon") { ?>
<?php if (AccountPermControl($readAccount["id"], "modules_gift_coupon") == "PERMISSION_NOT_FOUND") { go(urlConverter("admin_perm_error", $languageType)); } ?>
  <?php if (get("target") == "create") { ?>
<div class="page-content">
  <nav class="page-breadcrumb">
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="<?php echo urlConverter("admin_home", $languageType); ?>"><?php echo languageVariables("dashboard", "words", $languageType); ?></a></li>
      <li class="breadcrumb-item"><a href="#"><?php echo languageVariables("modules", "words", $languageType); ?></a></li>
      <li class="breadcrumb-item"><a href="<?php echo urlConverter("admin_modules_gift_coupon", $languageType); ?>"><?php echo languageVariables("giftCoupon", "words", $languageType); ?></a></li>
      <li class="breadcrumb-item active" aria-current="page"><?php echo languageVariables("add", "words", $languageType); ?></li>
    </ol>
  </nav>
  <div class="row">
    <div class="col-md-12 grid-margin stretch-card">
      <div class="card">
        <div class="card-body">
          <h6 class="card-title"><?php echo languageVariables("giftCouponCardAddTitle", "modules", $languageType); ?></h6>
          <?php
          require_once(__DR__."/main/includes/packages/class/csrf/class.php");
          $safeCsrfToken = new CSRF('csrf-sessions', 'csrf-token'); 
          if (isset($_POST["create"])) {
            if ($safeCsrfToken->validate('createToken')) {
              if (post("couponAddCode") !== "" && (post("couponAddType") == "0" || post("couponAddCount") !== "")) {
                if (isset($_POST["couponItemTypes"])) {
                  $searchCodes = $db->prepare("SELECT * FROM coupon WHERE code = ?");
                  $searchCodes->execute(array(post("couponAddCode")));
                  if (mysqlCount($searchCodes) == "0") {
                    if (post("couponAddType") == "0") {
                      $couponCount = "0";
                    } else if (post("couponAddType") == "1") {
                      $couponCount = post("couponAddCount");
                    }
                    $insertCoupon = $db->prepare("INSERT INTO coupon (`code`, `type`, `custom`, `date`) VALUES (?,?,?,?)");
                    $insertCoupon->execute(array(post("couponAddCode"), post("couponAddType"), $couponCount, date("d.m.Y H:i:s")));
                    $insertCouponStatus = true;
                    if ($insertCoupon) {
                      $searchCoupon = $db->query("SELECT * FROM coupon ORDER BY id DESC LIMIT 1");
                      if (mysqlCount($searchCoupon) > 0) {
                        $readCoupon = fetch($searchCoupon);
                        foreach($_POST['couponItemRewards'] as $key => $value){
                          $insertCouponItem = $db->prepare("INSERT INTO couponItem (`couponID`, `couponCode`, `type`, `reward`) VALUES (?, ?, ?, ?)");
                          $insertCouponItem->execute(array($readCoupon["id"], $readCoupon["code"], $_POST['couponItemTypes'][$key], $_POST['couponItemRewards'][$key]));
                        }
                      } else {
                        echo alert(languageVariables("alertSystem", "modules", $languageType), "danger", "0", "/");
                        $insertCouponStatus = false;
                      }
                    } else {
                      echo alert(languageVariables("alertSystem", "modules", $languageType), "danger", "0", "/");
                      $insertCouponStatus = false;
                    }
                    if ($insertCouponStatus == true) {
                      echo alert(languageVariables("alertCouponAddSuccess", "modules", $languageType), "success", "2", urlConverter("admin_modules_gift_coupon", $languageType));
                    } else {
                      echo alert(languageVariables("alertSystem", "modules", $languageType), "danger", "0", "/");
                    }
                  } else {
                    echo alert(languageVariables("alertCouponAlreadyCode", "modules", $languageType), "danger", "0", "/");
                  }
                } else {
                  echo alert(languageVariables("alertCouponRewardsNone", "modules", $languageType), "danger", "0", "/");
                }
              } else {
                echo alert(languageVariables("alertNone", "modules", $languageType), "warning", "0", "/");
              }
            } else {
              echo alert(languageVariables("alertSystem", "modules", $languageType), "danger", "0", "/");
            }
          }
          ?>
          <form class="forms-sample" action="" method="POST" enctype="multipart/form-data">
            <div class="form-group row">
              <label for="modules-coupon-add-code" class="col-sm-3 col-form-label"><?php echo languageVariables("giftCouponCode", "modules", $languageType); ?></label>
              <div class="col-sm-9">
                <input type="text" class="form-control" id="modules-coupon-add-code" name="couponAddCode" placeholder="<?php echo languageVariables("giftCouponCodePlaceholder", "modules", $languageType); ?>">
              </div>
            </div>
            <div class="form-group row">
              <label for="modules-coupon-add-type" class="col-sm-3 col-form-label"><?php echo languageVariables("giftCouponType", "modules", $languageType); ?></label>
              <div class="col-sm-9">
                <select class="form-control" id="modules-coupon-add-type" name="couponAddType" data-toggle="couponTypeStatus">
                  <option value="0" selected><?php echo languageVariables("giftCouponTypeOption0", "modules", $languageType); ?></option>
                  <option value="1"><?php echo languageVariables("giftCouponTypeOption1", "modules", $languageType); ?></option>
                </select>
              </div>
            </div>
            <div style="display: none;" data-toggle="couponCountInput">
              <div class="form-group row">
                <label for="modules-coupon-add-count" class="col-sm-3 col-form-label"><?php echo languageVariables("giftCouponCount", "modules", $languageType); ?></label>
                <div class="col-sm-9">
                  <input type="number" class="form-control" id="modules-coupon-add-count" name="couponAddCount" placeholder="<?php echo languageVariables("giftCouponCountPlaceholder", "modules", $languageType); ?>">
                </div>
              </div>
            </div>
            <div class="form-group row">
              <label for="modules-coupon-add-rewards" class="col-sm-3 col-form-label"><?php echo languageVariables("giftCouponRewards", "modules", $languageType); ?></label>
              <div class="col-sm-9">
                <div class="table-responsive">
                  <table class="table table-sm table-hover table-nowrap array-table">
                    <thead>
                      <tr>
                        <th class="text-center align-middle"><?php echo languageVariables("giftCouponRewardType", "modules", $languageType); ?></th>
                        <th class="text-center align-middle"><?php echo languageVariables("giftCouponReward", "modules", $languageType); ?></th>
                        <th class="text-center align-middle">
                          <button type="button" class="btn btn-primary btn-icon" add-item="credit" item-type="coupon">
                            <i data-feather="plus-square"></i>
                          </button>
                          <button type="button" class="btn btn-danger btn-icon ml-2" add-item="product" item-type="coupon">
                            <i data-feather="gift"></i>
                          </button>
                        </th>
                      </tr>
                    </thead>
                    <tbody data-toggle="itemTable">
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
            <div style="float: right;">
              <?php echo $safeCsrfToken->input("createToken"); ?>
              <button type="submit" class="btn btn-primary mr-2" name="create"><?php echo languageVariables("add", "words", $languageType); ?></button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
  <?php } else if (get("target") == "update") { ?>
    <?php if (isset($_GET["couponID"])) { ?>
      <?php 
        $searchCoupon = $db->prepare("SELECT * FROM coupon WHERE id = ?");
        $searchCoupon->execute(array(get("couponID")));
        if (mysqlCount($searchCoupon) > 0) {
          $readCoupon = fetch($searchCoupon);
      ?>
<div class="page-content">
  <nav class="page-breadcrumb">
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="<?php echo urlConverter("admin_home", $languageType); ?>"><?php echo languageVariables("dashboard", "words", $languageType); ?></a></li>
      <li class="breadcrumb-item"><a href="#"><?php echo languageVariables("modules", "words", $languageType); ?></a></li>
      <li class="breadcrumb-item"><a href="<?php echo urlConverter("admin_modules_gift_coupon", $languageType); ?>"><?php echo languageVariables("giftCoupon", "words", $languageType); ?></a></li>
      <li class="breadcrumb-item active" aria-current="page"><?php echo $readCoupon["id"]."# ".$readCoupon["code"]; ?></li>
    </ol>
  </nav>
  <div class="row">
    <div class="col-md-12 grid-margin stretch-card">
      <div class="card">
        <div class="card-body">
          <h6 class="card-title"><?php echo languageVariables("giftCouponCardEditTitle", "modules", $languageType); ?></h6>
          <?php
          require_once(__DR__."/main/includes/packages/class/csrf/class.php");
          $safeCsrfToken = new CSRF('csrf-sessions', 'csrf-token'); 
          if (isset($_POST["update"])) {
            if ($safeCsrfToken->validate('updateToken')) {
              if (post("couponEditCode") !== "" && (post("couponEditType") == "0" || post("couponEditCount") !== "")) {
                if (isset($_POST["couponItemTypes"])) {
                  $searchCodes = $db->prepare("SELECT * FROM coupon WHERE code = ?");
                  $searchCodes->execute(array(post("couponEditCode")));
                  if ($readCoupon["code"] == post("couponEditCode") || mysqlCount($searchCodes) == "0") {
                    if (post("couponEditType") == "0") {
                      $couponCount = "0";
                    } else if (post("couponEditType") == "1") {
                      $couponCount = post("couponEditCount");
                    }
                    $updateCoupon = $db->prepare("UPDATE coupon SET code = ?, type = ?, custom = ? WHERE id = ?");
                    $updateCoupon->execute(array(post("couponEditCode"), post("couponEditType"), $couponCount, $readCoupon["id"]));
                    $removeCouponItem = $db->prepare("DELETE FROM couponItem WHERE couponID = ?");
                    $removeCouponItem->execute(array($readCoupon["id"]));
                    foreach($_POST['couponItemRewards'] as $key => $value){
                      $insertCouponItem = $db->prepare("INSERT INTO couponItem (`couponID`, `couponCode`, `type`, `reward`) VALUES (?, ?, ?, ?)");
                      $insertCouponItem->execute(array($readCoupon["id"], $readCoupon["code"], $_POST['couponItemTypes'][$key], $_POST['couponItemRewards'][$key]));
                    }
                    echo alert(languageVariables("alertCouponEditSuccess", "modules", $languageType), "success", "2", "");
                  } else {
                    echo alert(languageVariables("alertCouponAlreadyCode", "modules", $languageType), "danger", "0", "/");
                  }
                } else {
                  echo alert(languageVariables("alertCouponRewardsNone", "modules", $languageType), "danger", "0", "/");
                }
              } else {
                echo alert(languageVariables("alertNone", "modules", $languageType), "warning", "0", "/");
              }
            } else {
              echo alert(languageVariables("alertSystem", "modules", $languageType), "danger", "0", "/");
            }
          }
          ?>
          <form class="forms-sample" action="" method="POST" enctype="multipart/form-data">
            <div class="form-group row">
              <label for="modules-coupon-edit-code" class="col-sm-3 col-form-label"><?php echo languageVariables("giftCouponCode", "modules", $languageType); ?></label>
              <div class="col-sm-9">
                <input type="text" class="form-control" id="modules-coupon-edit-code" name="couponEditCode" placeholder="<?php echo languageVariables("giftCouponCodePlaceholder", "modules", $languageType); ?>" value="<?php echo $readCoupon["code"]; ?>">
              </div>
            </div>
            <div class="form-group row">
              <label for="modules-coupon-edit-type" class="col-sm-3 col-form-label"><?php echo languageVariables("giftCouponType", "modules", $languageType); ?></label>
              <div class="col-sm-9">
                <select class="form-control" id="modules-coupon-edit-type" name="couponEditType" data-toggle="couponTypeStatus">
                  <option value="0" <?php if ($readCoupon["type"] == "0") { echo "selected"; } ?>><?php echo languageVariables("giftCouponTypeOption0", "modules", $languageType); ?></option>
                  <option value="1" <?php if ($readCoupon["type"] == "1") { echo "selected"; } ?>><?php echo languageVariables("giftCouponTypeOption1", "modules", $languageType); ?></option>
                </select>
              </div>
            </div>
            <div <?php if ($readCoupon["type"] == "0") { echo "style=\"display: none;\""; } ?> data-toggle="couponCountInput">
              <div class="form-group row">
                <label for="modules-coupon-edit-count" class="col-sm-3 col-form-label"><?php echo languageVariables("giftCouponCount", "modules", $languageType); ?></label>
                <div class="col-sm-9">
                  <input type="number" class="form-control" id="modules-coupon-edit-count" name="couponEditCount" placeholder="<?php echo languageVariables("giftCouponCountPlaceholder", "modules", $languageType); ?>" value="<?php if ($readCoupon["type"] == "1") { echo $readCoupon["custom"]; } ?>">
                </div>
              </div>
            </div>
            <div class="form-group row">
              <label for="modules-coupon-edit-rewards" class="col-sm-3 col-form-label"><?php echo languageVariables("giftCouponRewards", "modules", $languageType); ?></label>
              <div class="col-sm-9">
                <div class="table-responsive">
                  <table class="table table-sm table-hover table-nowrap array-table">
                    <thead>
                      <tr>
                        <th class="text-center align-middle"><?php echo languageVariables("giftCouponRewardType", "modules", $languageType); ?></th>
                        <th class="text-center align-middle"><?php echo languageVariables("giftCouponReward", "modules", $languageType); ?></th>
                        <th class="text-center align-middle">
                          <button type="button" class="btn btn-primary btn-icon" add-item="credit" item-type="coupon">
                            <i data-feather="plus-square"></i>
                          </button>
                          <button type="button" class="btn btn-danger btn-icon ml-2" add-item="product" item-type="coupon">
                            <i data-feather="gift"></i>
                          </button>
                        </th>
                      </tr>
                    </thead>
                    <tbody data-toggle="itemTable">
                    <?php $searchCouponItem = $db->prepare("SELECT * FROM couponItem WHERE couponID = ? ORDER BY id ASC"); ?>
                    <?php $searchCouponItem->execute(array($readCoupon["id"])); ?>
                    <?php foreach ($searchCouponItem as $readCouponItem) { ?>
                      <?php if ($readCouponItem["type"] == "0") { ?>
                      <tr id="removeID-<?php echo $readCouponItem["id"]; ?>">
                        <td class="ml-2">
                          <div class="input-group">
                            <input type="hidden" name="couponItemTypes[]" value="0">
                            <input type="text" class="form-control" placeholder="<?php echo languageVariables("giftCouponRewardType", "modules", $languageType); ?>" value="<?php echo languageVariables("credit", "words", $languageType); ?>" readonly>
                          </div>
                        </td>
                        <td class="text-center align-middle">
                          <div class="input-group input-group-merge">
                            <div class="input-group-prepend"> 
                              <div class="input-group-text"> 
                                <span class="fa fa-lira-sign"></span>
                              </div>
                            </div>
                            <input type="text" class="form-control form-control-prepended" name="couponItemRewards[]" placeholder="<?php echo languageVariables("modulesRewardAmount", "modules", $languageType); ?>" value="<?php echo $readCouponItem["reward"]; ?>">
                          </div>
                        </td>
                        <td class="text-center align-middle">
                          <button type="button" class="btn btn-danger btn-icon" remove-item="button" remove-id="<?php echo $readCouponItem["id"]; ?>">
                            <span class="far fa-trash-alt"></span>
                          </button>
                        </td>
                      </tr>
                      <?php } else { ?>
                      <tr id="removeID-<?php echo $readCouponItem["id"]; ?>">
                        <td class="ml-2">
                          <div class="input-group">
                            <input type="hidden" name="couponItemTypes[]" value="1">
                            <input type="text" class="form-control" placeholder="<?php echo languageVariables("giftCouponRewardType", "modules", $languageType); ?>" value="<?php echo languageVariables("product", "words", $languageType); ?>" readonly>
                          </div>
                        </td>
                        <td class="text-center align-middle">
                          <div class="form-group row">
                            <div class="col-sm-12">
                              <select class="form-control" name="couponItemRewards[]">
                                <?php $searchServers = $db->query("SELECT * FROM serverList ORDER BY id ASC"); ?>
                                <?php if (mysqlCount($searchServers) > 0): ?>
                                  <?php foreach ($searchServers as $readServer): ?>
                                    <?php
                                      $searchCategories = $db->prepare("SELECT * FROM serverCategory WHERE serverID = ? ORDER BY id ASC");
                                      $searchCategories->execute(array($readServer["id"]));
                                    ?>
                                    <?php if (mysqlCount($searchCategories) > 0): ?>
                                      <?php foreach ($searchCategories as $readCategory): ?>
                                        <?php echo "<optgroup label=\"".$readServer["name"]." - ".$readCategory["name"]."\">"; ?>
                                        <?php
                                          $searchProducts = $db->prepare("SELECT * FROM categoryProduct WHERE categoryID = ? ORDER BY id ASC");
                                          $searchProducts->execute(array($readCategory["id"]));
                                        ?>
                                        <?php if (mysqlCount($searchProducts) > 0): ?>
                                          <?php foreach ($searchProducts as $readProduct): ?>
                                            <?php if ($readCouponItem["reward"] == $readProduct["id"]): ?>
                                              <?php echo "<option value=\"".$readProduct["id"]."\" selected>".$readProduct["name"]."</option>"; ?>
                                            <?php else: ?>
                                              <?php echo "<option value=\"".$readProduct["id"]."\">".$readProduct["name"]."</option>"; ?>
                                            <?php endif; ?>
                                          <?php endforeach; ?>
                                        <?php endif; ?>
                                        <?php echo "</optgroup>"; ?>
                                      <?php endforeach; ?>
                                    <?php endif; ?>
                                  <?php endforeach; ?>
                                <?php else: ?>
                                  <?php echo "<option value=\"0\">".languageVariables("ajaxNotServerAlert", "modules", $languageType)."</option>"; ?>
                                <?php endif; ?>
                              </select>
                            </div>
                          </div>
                        </td>
                        <td class="text-center align-middle">
                          <button type="button" class="btn btn-danger btn-icon" remove-item="button" remove-id="<?php echo $readCouponItem["id"]; ?>">
                            <span class="far fa-trash-alt"></span>
                          </button>
                        </td>
                      </tr>
                      <?php } ?>
                    <?php } ?>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
            <div style="float: right;">
              <?php echo $safeCsrfToken->input("updateToken"); ?>
              <button type="submit" class="btn btn-primary mr-2" name="update"><?php echo languageVariables("saveChanges", "words", $languageType); ?></button>
              <button type="button" class="btn btn-danger btn-icon" confirm-element="confirm" confirm-text="<?php echo languageVariables("deleteAlert", "words", $languageType); ?>" direct-href="<?php echo urlConverter("admin_modules_gift_coupon_delete", $languageType); ?>/<?php echo $readCoupon["id"]; ?>" data-toggle="tooltip" data-placement="top" title="<?php echo languageVariables("remove", "words", $languageType); ?>"><i data-feather="trash-2"></i></button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
      <?php } else { go(urlConverter("admin_modules_gift_coupon", $languageType)); } ?>
    <?php } else { ?>
      <?php 
      if (isset($_GET["pageNumber"])) {
        if (!is_numeric(get("pageNumber"))) {
          $_GET["pageNumber"] = 1;
        }
        $pageNumber = intval(get("pageNumber"));
      } else {
        $pageNumber = 1;
      }

      $pageSubCount = 50;
      $pageItemCount = pageItemCount("coupon", $pageSubCount);

      if ($pageNumber > $pageItemCount) {
        $pageNumber = 1;
      }

      $queryPageItemCount = $pageNumber * $pageSubCount - $pageSubCount;
      $maxPageItemCount = 5;
    ?>
      <?php $searchCoupons = $db->query("SELECT * FROM coupon ORDER BY id DESC LIMIT $queryPageItemCount, $pageSubCount"); ?>
<div class="page-content">
  <div class="row">
    <div class="col">
      <nav class="page-breadcrumb">
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="<?php echo urlConverter("admin_home", $languageType); ?>"><?php echo languageVariables("dashboard", "words", $languageType); ?></a></li>
          <li class="breadcrumb-item"><a href="#"><?php echo languageVariables("modules", "words", $languageType); ?></a></li>
          <li class="breadcrumb-item"><a href="<?php echo urlConverter("admin_modules_gift_coupon", $languageType); ?>"><?php echo languageVariables("giftCoupon", "words", $languageType); ?></a></li>
          <li class="breadcrumb-item active" aria-current="page"><?php echo languageVariables("edit", "words", $languageType); ?></li>
        </ol>
      </nav>
    </div>
    <div class="col-auto">
      <nav aria-label="Page navigation example" style="floatt: right;">
        <ul class="pagination">
          <li class="page-item <?php echo (($pageNumber == "1") ? "disabled" : ""); ?>"><a class="page-link" href="<?php echo urlConverter("admin_modules_gift_coupon_p", $languageType)."/".($pageNumber-1); ?>"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-left"><polyline points="15 18 9 12 15 6"></polyline></svg></a></li>
          <?php 
            for ($i = $pageNumber - $maxPageItemCount; $i < $pageNumber + $maxPageItemCount + 1; $i++) {
					    if ($i > 0 && $i <= $pageItemCount) {
          ?>
          <li class="page-item <?php echo (($pageNumber == $i) ? "active" : ""); ?>"><a class="page-link" href="<?php echo urlConverter("admin_modules_gift_coupon_p", $languageType)."/".$i; ?>"><?php echo $i; ?></a></li>
          <?php } } ?>
          <li class="page-item <?php echo (($pageItemCount == $pageNumber) ? "disabled" : ""); ?>"><a class="page-link" href="<?php echo urlConverter("admin_modules_gift_coupon_p", $languageType)."/".($pageNumber+1); ?>"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-right"><polyline points="9 18 15 12 9 6"></polyline></svg></a></li>
        </ul>
      </nav>
    </div>
  </div>
  <div class="row">
    <div class="col-md-12">
    <?php if (mysqlCount($searchCoupons) > 0) { ?>
      <div class="card" data-toggle="lists" data-lists-values='["couponID", "couponCode", "couponGift", "couponCount", "couponRemainingCount", "couponDate"]'>
        <div class="card-header">
          <div class="row align-items-center">
            <div class="col">
              <div class="row align-items-center">
                <div class="col-auto pr-0">
                  <span data-feather="search"></span>
                </div>
                <div class="col">
                  <input type="search" class="form-control search" style="border: 0; background: none;" name="search" placeholder="<?php echo languageVariables("search", "words", $languageType); ?>">
                </div>
              </div>
            </div>
            <div class="col-auto">
              <a class="btn btn-sm btn-primary" href="<?php echo urlConverter("admin_modules_gift_coupon_add", $languageType); ?>"><?php echo languageVariables("add", "words", $languageType); ?></a>
            </div>
          </div>
        </div>
        <div class="card-body p-0">
          <div class="table-responsive">
            <table class="table table-hover">
              <thead>
                <tr>
                  <th class="text-center" style="width: 40px;"><a href="#" class="text-muted sort" data-sort="couponID">#ID</a></th>
                  <th class="text-center"><a href="#" class="text-muted sort" data-sort="couponCode"><?php echo languageVariables("giftCouponTableCode", "modules", $languageType); ?></a></th>
                  <th class="text-center"><a href="#" class="text-muted sort" data-sort="couponGift"><?php echo languageVariables("giftCouponTableRewards", "modules", $languageType); ?></a></th>
                  <th class="text-center"><a href="#" class="text-muted sort" data-sort="couponCount"><?php echo languageVariables("giftCouponTableCount", "modules", $languageType); ?></a></th>
                  <th class="text-center"><a href="#" class="text-muted sort" data-sort="couponRemainingCount"><?php echo languageVariables("giftCouponTableReCount", "modules", $languageType); ?></a></th>
                  <th class="text-center"><a href="#" class="text-muted sort" data-sort="couponDate"><?php echo languageVariables("giftCouponTableCreateDate", "modules", $languageType); ?></a></th>
                  <th class="text-right">&nbsp;</th>
                </tr>
              </thead>
              <tbody class="list">
               <?php foreach ($searchCoupons as $readCoupon) { ?>
               <?php $searchCouponItem = $db->prepare("SELECT * FROM couponItem WHERE couponID = ?"); ?>
               <?php $searchCouponItem->execute(array($readCoupon["id"])); ?>
               <?php $couponItemRow = mysqlCount($searchCouponItem); ?>
               <?php $activeCouponCount = $db->prepare("SELECT * FROM couponHistory WHERE couponID = ?"); ?>
               <?php $activeCouponCount->execute(array($readCoupon["id"])); ?>
                <tr>
                  <td class="couponID text-center" style="width: 40px;"><a href="<?php echo urlConverter("admin_modules_gift_coupon", $languageType); ?>/<?php echo $readCoupon["id"]; ?>">#<?php echo $readCoupon["id"]; ?></a></td>
                  <td class="couponCode text-center"><a href="<?php echo urlConverter("admin_modules_gift_coupon", $languageType); ?>/<?php echo $readCoupon["id"]; ?>"><?php echo $readCoupon["code"]; ?></a></td>
                  <td class="couponGift text-center">
                  <?php 
                    foreach($searchCouponItem as $readCouponItem) {
                      if ($readCouponItem["type"] == "0") {
                        if ($couponItemRow > 1) {
                          echo $readCouponItem["reward"]." ".languageVariables("creditAnd", "words", $languageType)." ";
                        } else {
                          echo $readCouponItem["reward"]." ".languageVariables("credit", "words", $languageType);
                        }
                      } else if ($readCouponItem["type"] == "1") {
                        $searchCouponProduct = $db->prepare("SELECT * FROM categoryProduct WHERE id = ?");
                        $searchCouponProduct->execute(array($readCouponItem["reward"]));
                        $readCouponProduct = fetch($searchCouponProduct);
                        if ($couponItemRow > 2) {
                          echo $readCouponProduct["name"]." ".languageVariables("productAnd", "words", $languageType)." ";
                        } else {
                          echo $readCouponProduct["name"]." ".languageVariables("product", "words", $languageType);
                        }
                      }
                    }
                  ?>
                  </td>
                  <td class="couponCount text-center"><?php if ($readCoupon["type"] == "0") { echo languageVariables("giftCouponTypeOption0", "modules", $languageType); } else { echo $readCoupon["custom"]; } ?></td>
                  <td class="couponRemainingCount text-center"><?php if ($readCoupon["type"] == "0") { echo languageVariables("giftCouponTypeOption0", "modules", $languageType); } else { echo $readCoupon["custom"] - mysqlCount($activeCouponCount); } ?></td>
                  <td class="couponDate text-center"><?php echo checkTime($readCoupon["date"]); ?></td>
                  <td class="text-right">
                    <button type="button" class="btn btn-success btn-icon" direct-element="direct" direct-href="<?php echo urlConverter("admin_modules_gift_coupon", $languageType); ?>/<?php echo $readCoupon["id"]; ?>" data-toggle="tooltip" data-placement="top" title="<?php echo languageVariables("edit", "words", $languageType); ?>"><i data-feather="edit-2"></i></button>
                    <button type="button" class="btn btn-danger btn-icon" confirm-element="confirm" confirm-text="<?php echo languageVariables("deleteAlert", "words", $languageType); ?>" direct-href="<?php echo urlConverter("admin_modules_gift_coupon_delete", $languageType); ?>/<?php echo $readCoupon["id"]; ?>" data-toggle="tooltip" data-placement="top" title="<?php echo languageVariables("remove", "words", $languageType); ?>"><i data-feather="trash-2"></i></button>
                  </td>
                </tr>
              <?php } ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    <?php } else { echo alert(languageVariables("alertPageNone", "modules", $languageType), "danger", "0", "/"); } ?>
    </div>
  </div>
</div>
    <?php } ?>
  <?php } else if (get("target") == "history") { ?>
    <?php if (isset($_GET["historyID"])) { ?>
      <?php
        $removeHistory = $db->prepare("DELETE FROM couponHistory WHERE id = ?");
        $removeHistory->execute(array(get("historyID")));
        go(urlConverter("admin_modules_gift_coupon_history", $languageType));
      ?>
    <?php } else { ?>
      <?php 
      if (isset($_GET["pageNumber"])) {
        if (!is_numeric(get("pageNumber"))) {
          $_GET["pageNumber"] = 1;
        }
        $pageNumber = intval(get("pageNumber"));
      } else {
        $pageNumber = 1;
      }

      $pageSubCount = 50;
      $pageItemCount = pageItemCount("couponHistory", $pageSubCount);

      if ($pageNumber > $pageItemCount) {
        $pageNumber = 1;
      }

      $queryPageItemCount = $pageNumber * $pageSubCount - $pageSubCount;
      $maxPageItemCount = 5;
    ?>
      <?php $searchCouponHistory = $db->query("SELECT * FROM couponHistory ORDER BY id DESC LIMIT $queryPageItemCount, $pageSubCount"); ?>
<div class="page-content">
  <div class="row">
    <div class="col">
      <nav class="page-breadcrumb">
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="<?php echo urlConverter("admin_home", $languageType); ?>"><?php echo languageVariables("dashboard", "words", $languageType); ?></a></li>
          <li class="breadcrumb-item"><a href="#"><?php echo languageVariables("modules", "words", $languageType); ?></a></li>
          <li class="breadcrumb-item"><a href="<?php echo urlConverter("admin_modules_gift_coupon", $languageType); ?>"><?php echo languageVariables("giftCoupon", "words", $languageType); ?></a></li>
          <li class="breadcrumb-item active" aria-current="page"><?php echo languageVariables("history", "words", $languageType); ?></li>
        </ol>
      </nav>
    </div>
    <div class="col-auto">
      <nav aria-label="Page navigation example" style="floatt: right;">
        <ul class="pagination">
          <li class="page-item <?php echo (($pageNumber == "1") ? "disabled" : ""); ?>"><a class="page-link" href="<?php echo urlConverter("admin_modules_gift_coupon_history_p", $languageType)."/".($pageNumber-1); ?>"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-left"><polyline points="15 18 9 12 15 6"></polyline></svg></a></li>
          <?php 
            for ($i = $pageNumber - $maxPageItemCount; $i < $pageNumber + $maxPageItemCount + 1; $i++) {
					    if ($i > 0 && $i <= $pageItemCount) {
          ?>
          <li class="page-item <?php echo (($pageNumber == $i) ? "active" : ""); ?>"><a class="page-link" href="<?php echo urlConverter("admin_modules_gift_coupon_history_p", $languageType)."/".$i; ?>"><?php echo $i; ?></a></li>
          <?php } } ?>
          <li class="page-item <?php echo (($pageItemCount == $pageNumber) ? "disabled" : ""); ?>"><a class="page-link" href="<?php echo urlConverter("admin_modules_gift_coupon_history_p", $languageType)."/".($pageNumber+1); ?>"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-right"><polyline points="9 18 15 12 9 6"></polyline></svg></a></li>
        </ul>
      </nav>
    </div>
  </div>
  <div class="row">
    <div class="col-md-12">
    <?php if (mysqlCount($searchCouponHistory) > 0) { ?>
      <div class="card" data-toggle="lists" data-lists-values='["historiesID", "historiesUserName", "historiesRewards", "historiesCouponCode", "historiesDate"]'>
        <div class="card-header">
          <div class="row align-items-center">
            <div class="col">
              <div class="row align-items-center">
                <div class="col-auto pr-0">
                  <span data-feather="search"></span>
                </div>
                <div class="col">
                  <input type="search" class="form-control search" style="border: 0; background: none;" name="search" placeholder="<?php echo languageVariables("search", "words", $languageType); ?>">
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="card-body p-0">
          <div class="table-responsive">
            <table class="table table-hover">
              <thead>
                <tr>
                  <th class="text-center" style="width: 40px;"><a href="#" class="text-muted sort" data-sort="historiesID">#ID</a></th>
                  <th class="text-center"><a href="#" class="text-muted sort" data-sort="historiesUserName"><?php echo languageVariables("username", "words", $languageType); ?></a></th>
                  <th class="text-center"><a href="#" class="text-muted sort" data-sort="historiesRewards"><?php echo languageVariables("giftCouponTableRewards", "modules", $languageType); ?></a></th>
                  <th class="text-center"><a href="#" class="text-muted sort" data-sort="historiesCouponCode"><?php echo languageVariables("giftCouponTableCode", "modules", $languageType); ?></a></th>
                  <th class="text-center"><a href="#" class="text-muted sort" data-sort="historiesDate"><?php echo languageVariables("date", "words", $languageType); ?></a></th>
                  <th class="text-right">&nbsp;</th>
                </tr>
              </thead>
              <tbody class="list">
               <?php foreach ($searchCouponHistory as $readCouponHistory) { ?>
               <?php $searchCouponItem = $db->prepare("SELECT * FROM couponItem WHERE couponID = ?"); ?>
               <?php $searchCouponItem->execute(array($readCouponHistory["couponID"])); ?>
               <?php $couponItemRow = mysqlCount($searchCouponItem); ?>
                <tr>
                  <td class="historiesID text-center" style="width: 40px;"><a href="<?php echo urlConverter("admin_player", $languageType); ?>/<?php echo $readCouponHistory["username"]; ?>">#<?php echo $readCouponHistory["id"]; ?></a></td>
                  <td class="historiesUserName text-center"><a href="<?php echo urlConverter("admin_player", $languageType); ?>/<?php echo $readCouponHistory["username"]; ?>"><?php echo $readCouponHistory["username"]; ?></a></td>
                  <td class="historiesRewards text-center">
                  <?php 
                    foreach($searchCouponItem as $readCouponItem) {
                      if ($readCouponItem["type"] == "0") {
                        if ($couponItemRow > 1) {
                          echo $readCouponItem["reward"]." ".languageVariables("creditAnd", "words", $languageType)." ";
                        } else {
                          echo $readCouponItem["reward"]." ".languageVariables("credit", "words", $languageType);
                        }
                      } else if ($readCouponItem["type"] == "1") {
                        $searchCouponProduct = $db->prepare("SELECT * FROM categoryProduct WHERE id = ?");
                        $searchCouponProduct->execute(array($readCouponItem["reward"]));
                        $readCouponProduct = fetch($searchCouponProduct);
                        if ($couponItemRow > 2) {
                          echo $readCouponProduct["name"]." ".languageVariables("productAnd", "words", $languageType)." ";
                        } else {
                          echo $readCouponProduct["name"]." ".languageVariables("product", "words", $languageType);
                        }
                      }
                    }
                  ?>
                  </td>
                  <td class="historiesCouponCode text-center"><?php echo $readCouponHistory["couponCode"]; ?></td>
                  <td class="historiesDate text-center"><?php echo checkTime($readCouponHistory["date"]); ?></td>
                  <td class="text-right">
                    <button type="button" class="btn btn-danger btn-icon" style="border-radius: 250px;" confirm-element="confirm" confirm-text="<?php echo languageVariables("deleteAlert", "words", $languageType); ?>" direct-href="<?php echo urlConverter("admin_modules_gift_coupon_history_delete", $languageType); ?>/<?php echo $readCouponHistory["id"]; ?>" data-toggle="tooltip" data-placement="top" title="<?php echo languageVariables("remove", "words", $languageType); ?>"><i class="fas fa-trash-alt"></i></button>
                  </td>
                </tr>
              <?php } ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    <?php } else { echo alert(languageVariables("alertPageNone", "modules", $languageType), "danger", "0", "/"); } ?>
    </div>
  </div>
</div>
    <?php } ?>
  <?php } else if (get("target") == "remove" && isset($_GET["couponID"])) { ?>
    <?php
      $removeCoupon = $db->prepare("DELETE FROM coupon WHERE id = ?");
      $removeCoupon->execute(array(get("couponID")));
      $removeCouponItem = $db->prepare("DELETE FROM couponItem WHERE couponID = ?");
      $removeCouponItem->execute(array(get("couponID")));
      $removeCouponHistory = $db->prepare("DELETE FROM couponHistory WHERE couponID = ?");
      $removeCouponHistory->execute(array(get("couponID")));
      go(urlConverter("admin_modules_gift_coupon", $languageType));
    ?>
  <?php } ?>
<?php } else if (get("action") == "theme") { ?>
<?php if (AccountPermControl($readAccount["id"], "modules_theme") == "PERMISSION_NOT_FOUND") { go(urlConverter("admin_perm_error", $languageType)); } ?>
  <?php if (get("target") == "css") { ?>
<div class="page-content">
  <nav class="page-breadcrumb">
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="<?php echo urlConverter("admin_home", $languageType); ?>"><?php echo languageVariables("dashboard", "words", $languageType); ?></a></li>
      <li class="breadcrumb-item"><a href="#"><?php echo languageVariables("modules", "words", $languageType); ?></a></li>
      <li class="breadcrumb-item"><a href="<?php echo urlConverter("admin_modules_theme_edit", $languageType); ?>"><?php echo languageVariables("theme", "words", $languageType); ?></a></li>
      <li class="breadcrumb-item active" aria-current="page">CSS</li>
    </ol>
  </nav>
  <div class="row">
    <div class="col-md-12 grid-margin stretch-card">
      <div class="card">
        <div class="card-body">
          <h6 class="card-title">CSS</h6>
          <?php
          require_once(__DR__."/main/includes/packages/class/csrf/class.php");
          $safeCsrfToken = new CSRF('csrf-sessions', 'csrf-token'); 
          if (isset($_POST["saveChanges"])) {
            if ($safeCsrfToken->validate('saveChangesToken')) {
              $saveChanges = $db->prepare("UPDATE theme SET CSS = ? WHERE id = ?");
              $saveChanges->execute(array($_POST["modulesThemeCSS"], 0));
              echo alert(languageVariables("alertSaveChanges", "modules", $languageType), "success", "2", "");
            } else {
              echo alert(languageVariables("alertSystem", "modules", $languageType), "danger", "0", "/");
            }
          }
          ?>
          <form class="forms-sample" action="" method="POST" enctype="multipart/form-data">
            <div class="form-group row">
              <div class="col-sm-12">
                <textarea type="text" class="form-control" id="modules-theme-css" name="modulesThemeCSS" data-toggle="codeMirror"><?php echo $readTheme["CSS"]; ?></textarea>
              </div>
            </div>
            <div style="float: right;">
              <?php echo $safeCsrfToken->input("saveChangesToken"); ?>
              <button type="submit" class="btn btn-primary mr-2" name="saveChanges"><?php echo languageVariables("saveChanges", "words", $languageType); ?></button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
  <?php } else if (get("target") == "change") { ?>
    <?php if (isset($_GET["theme"])) { ?>
      <?php if (get("theme") == "default") { ?>
      <?php $readDefaultVariables = json_decode($readTheme["defaultVariables"], true); ?>
<div class="page-content">
  <div class="row">
    <div class="col">
      <nav class="page-breadcrumb">
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="<?php echo urlConverter("admin_home", $languageType); ?>"><?php echo languageVariables("dashboard", "words", $languageType); ?></a></li>
          <li class="breadcrumb-item"><a href="#"><?php echo languageVariables("modules", "words", $languageType); ?></a></li>
          <li class="breadcrumb-item"><a href="<?php echo urlConverter("admin_modules_theme_edit", $languageType); ?>"><?php echo languageVariables("theme", "words", $languageType); ?></a></li>
          <li class="breadcrumb-item active" aria-current="page">Default</li>
        </ol>
      </nav>
    </div>
  </div>
  <div class="row">
    <div class="col-md-12 grid-margin stretch-card">
      <div class="card">
        <div class="card-body">
          <h6 class="card-title"><?php echo languageVariables("edit", "words", $languageType); ?></h6>
          <?php
          require_once(__DR__."/main/includes/packages/class/csrf/class.php");
          $safeCsrfToken = new CSRF('csrf-sessions', 'csrf-token');
          if (isset($_POST["editTheme"])) {
            if ($safeCsrfToken->validate('editThemeToken')) {
              if (post("themeColor50") !== "" && post("themeColor100") !== "" && post("themeColor200") !== "" && post("themeColor300") !== "" && post("themeColor400") !== "" && post("themeColor500") !== "" && post("themeColor600") !== "" && post("themeColor700") !== "" && post("themeColor800") !== "" && post("themeColor900") !== "") {
                $defaultVariables = array();
                $proccessStatus = true;
                if ($_FILES["defaultBodyImage"]["size"] != null) {
                  $imageUploadBody = imageUpload($_FILES["defaultBodyImage"], "/assets/uploads/images/landing/images/default/");
                  if ($imageUploadBody !== false) {
                    unlink(__DR__.$readDefaultVariables["bodyImage"]);
                    $defaultVariables["bodyImage"] = "/assets/uploads/images/landing/images/default/".$imageUploadBody["name"];
                  } else {
                    $proccessStatus = false;
                  }
                } else {
                  $defaultVariables["bodyImage"] = $readDefaultVariables["bodyImage"];
                }

                if ($_FILES["defaultHeaderImage"]["size"] != null) {
                  $imageUploadHeader = imageUpload($_FILES["defaultHeaderImage"], "/assets/uploads/images/landing/images/default/");
                  if ($imageUploadHeader !== false) {
                    unlink(__DR__.$readDefaultVariables["headerImage"]);
                    $defaultVariables["headerImage"] = "/assets/uploads/images/landing/images/default/".$imageUploadHeader["name"];
                  } else {
                    $proccessStatus = false;
                  }
                } else {
                  $defaultVariables["headerImage"] = $readDefaultVariables["headerImage"];
                }

                if ($_FILES["defaultFooterImage"]["size"] != null) {
                  $imageUploadFooter = imageUpload($_FILES["defaultFooterImage"], "/assets/uploads/images/landing/images/default/");
                  if ($imageUploadFooter !== false) {
                    unlink(__DR__.$readDefaultVariables["footerImage"]);
                    $defaultVariables["footerImage"] = "/assets/uploads/images/landing/images/default/".$imageUploadFooter["name"];
                  } else {
                    $proccessStatus = false;
                  }
                } else {
                  $defaultVariables["footerImage"] = $readDefaultVariables["footerImage"];
                }

                if ($_FILES["defaultStoreImage"]["size"] != null) {
                  $imageUploadStore = imageUpload($_FILES["defaultStoreImage"], "/assets/uploads/images/landing/images/default/");
                  if ($imageUploadStore !== false) {
                    unlink(__DR__.$readDefaultVariables["storeImage"]);
                    $defaultVariables["storeImage"] = "/assets/uploads/images/landing/images/default/".$imageUploadStore["name"];
                  } else {
                    $proccessStatus = false;
                  }
                } else {
                  $defaultVariables["storeImage"] = $readDefaultVariables["storeImage"];
                }

                if ($proccessStatus == true) {
                  $defaultVariables["bodyType"] = post("themeBodyImageType");
                  $defaultVariables["navbarType"] = post("themeNavbarType");
                  $defaultVariables["headerBlur"] = post("themeHeaderType");
                  $defaultVariables["headerParticles"] = post("themeHeaderPType");
                  $defaultVariables["color"] = array(
                    "50" => post("themeColor50"),
                    "100" => post("themeColor100"),
                    "200" => post("themeColor200"),
                    "300" => post("themeColor300"),
                    "400" => post("themeColor400"),
                    "500" => post("themeColor500"),
                    "600" => post("themeColor600"),
                    "700" => post("themeColor700"),
                    "800" => post("themeColor800"),
                    "900" => post("themeColor900")
                  );
                  $updateTheme = $db->prepare("UPDATE theme SET defaultVariables = ? WHERE id = ?");
                  $updateTheme->execute(array(json_encode($defaultVariables), 0));
                  echo alert(languageVariables("alertThemeEditSuccess", "modules", $languageType), "success", "2", "");
                } else {
                  echo alert(languageVariables("alertImageUploadFail", "modules", $languageType), "danger", "0", "/");
                }
              } else {
                echo alert(languageVariables("alertNone", "modules", $languageType), "warning", "0", "/");
              }
            } else {
              echo alert(languageVariables("alertSystem", "modules", $languageType), "danger", "0", "/");
            }
          }
          ?>
          <form class="forms-sample" action="" method="POST" enctype="multipart/form-data">
            <div class="form-group row">
              <label for="modules-theme-default-colors" class="col-sm-3 col-form-label"><?php echo languageVariables("themeColors", "modules", $languageType); ?></label>
              <div class="col-sm-9" style="display: flex; flex-direction: row; flex-wrap: wrap;">
                <div class="shadow-sm color-parent" style="background-color: rgb(100 116 139);" data-toggle="tooltip" data-placement="top" title="Slate" theme="colorChange" themeColorName="Slate"></div>
                <div class="shadow-sm color-parent" style="background-color: rgb(107 114 128);" data-toggle="tooltip" data-placement="top" title="Gray" theme="colorChange" themeColorName="Gray"></div>
                <div class="shadow-sm color-parent" style="background-color: rgb(113 113 122);" data-toggle="tooltip" data-placement="top" title="Zinc" theme="colorChange" themeColorName="Zinc"></div>
                <div class="shadow-sm color-parent" style="background-color: rgb(115 115 115);" data-toggle="tooltip" data-placement="top" title="Neutral" theme="colorChange" themeColorName="Neutral"></div>
                <div class="shadow-sm color-parent" style="background-color: rgb(120 113 108);" data-toggle="tooltip" data-placement="top" title="Stone" theme="colorChange" themeColorName="Stone"></div>
                <div class="shadow-sm color-parent" style="background-color: rgb(239 68 68);" data-toggle="tooltip" data-placement="top" title="Red" theme="colorChange" themeColorName="Red"></div>
                <div class="shadow-sm color-parent" style="background-color: rgb(200 47 47);" data-toggle="tooltip" data-placement="top" title="Bold Red" theme="colorChange" themeColorName="Bold Red"></div>
                <div class="shadow-sm color-parent" style="background-color: rgb(155 21 21);" data-toggle="tooltip" data-placement="top" title="Extra Bold Red" theme="colorChange" themeColorName="Extra Bold Red"></div>
                <div class="shadow-sm color-parent" style="background-color: rgb(249 115 22);" data-toggle="tooltip" data-placement="top" title="Orange" theme="colorChange" themeColorName="Orange"></div>
                <div class="shadow-sm color-parent" style="background-color: rgb(177 86 24);" data-toggle="tooltip" data-placement="top" title="Bold Orange" theme="colorChange" themeColorName="Bold Orange"></div>
                <div class="shadow-sm color-parent" style="background-color: rgb(99	45 8);" data-toggle="tooltip" data-placement="top" title="Extra Bold Orange" theme="colorChange" themeColorName="Extra Bold Orange"></div>
                <div class="shadow-sm color-parent" style="background-color: rgb(245 158 11);" data-toggle="tooltip" data-placement="top" title="Amber" theme="colorChange" themeColorName="Amber"></div>
                <div class="shadow-sm color-parent" style="background-color: rgb(234 179 8);" data-toggle="tooltip" data-placement="top"  title="Yellow" theme="colorChange" themeColorName="Yellow"></div>
                <div class="shadow-sm color-parent" style="background-color: rgb(114 90 15);" data-toggle="tooltip" data-placement="top"  title="Bold Yellow" theme="colorChange" themeColorName="Bold Yellow"></div>
                <div class="shadow-sm color-parent" style="background-color: rgb(132 204 22);" data-toggle="tooltip" data-placement="top" title="Lime" theme="colorChange" themeColorName="Lime"></div>
                <div class="shadow-sm color-parent" style="background-color: rgb(34 197 94);" data-toggle="tooltip" data-placement="top" title="Green" theme="colorChange" themeColorName="Green"></div>
                <div class="shadow-sm color-parent" style="background-color: rgb(17	147	65);" data-toggle="tooltip" data-placement="top" title="Bold Green" theme="colorChange" themeColorName="Bold Green"></div>
                <div class="shadow-sm color-parent" style="background-color: rgb(5 89 36);" data-toggle="tooltip" data-placement="top" title="Extra Bold Green" theme="colorChange" themeColorName="Extra Bold Green"></div>
                <div class="shadow-sm color-parent" style="background-color: rgb(16 185 129);" data-toggle="tooltip" data-placement="bottom" title="Emerald" theme="colorChange" themeColorName="Emerald"></div>
                <div class="shadow-sm color-parent" style="background-color: rgb(20 184 166);" data-toggle="tooltip" data-placement="bottom" title="Teal" theme="colorChange" themeColorName="Teal"></div>
                <div class="shadow-sm color-parent" style="background-color: rgb(6 182 212);" data-toggle="tooltip" data-placement="bottom" title="Cyan" theme="colorChange" themeColorName="Cyan"></div>
                <div class="shadow-sm color-parent" style="background-color: rgb(14 165 233);" data-toggle="tooltip" data-placement="bottom" title="Sky" theme="colorChange" themeColorName="Sky"></div>
                <div class="shadow-sm color-parent" style="background-color: rgb(59 130 246);" data-toggle="tooltip" data-placement="bottom" title="Blue" theme="colorChange" themeColorName="Blue"></div>
                <div class="shadow-sm color-parent" style="background-color: rgb(33	88 179);" data-toggle="tooltip" data-placement="bottom" title="Bold Blue" theme="colorChange" themeColorName="Bold Blue"></div>
                <div class="shadow-sm color-parent" style="background-color: rgb(8 46 109);" data-toggle="tooltip" data-placement="bottom" title="Extra Bold Blue" theme="colorChange" themeColorName="Extra Bold Blue"></div>
                <div class="shadow-sm color-parent" style="background-color: rgb(99 102 241);" data-toggle="tooltip" data-placement="bottom" title="Indigo" theme="colorChange" themeColorName="Indigo"></div>
                <div class="shadow-sm color-parent" style="background-color: rgb(60	62 178);" data-toggle="tooltip" data-placement="bottom" title="Bold Indigo" theme="colorChange" themeColorName="Bold Indigo"></div>
                <div class="shadow-sm color-parent" style="background-color: rgb(45	46 123);" data-toggle="tooltip" data-placement="bottom" title="Extra Bold Indigo" theme="colorChange" themeColorName="Extra Bold Indigo"></div>
                <div class="shadow-sm color-parent" style="background-color: rgb(139 92 246);" data-toggle="tooltip" data-placement="bottom" title="Violet" theme="colorChange" themeColorName="Violet"></div>
                <div class="shadow-sm color-parent" style="background-color: rgb(168 85 247);" data-toggle="tooltip" data-placement="bottom" title="Purple" theme="colorChange" themeColorName="Purple"></div>
                <div class="shadow-sm color-parent" style="background-color: rgb(217 70 239);" data-toggle="tooltip" data-placement="bottom" title="Fuchsia" theme="colorChange" themeColorName="Fuchsia"></div>
                <div class="shadow-sm color-parent" style="background-color: rgb(236 72 153);" data-toggle="tooltip" data-placement="bottom" title="Pink" theme="colorChange" themeColorName="Pink"></div>
                <div class="shadow-sm color-parent" style="background-color: rgb(244 63 94);" data-toggle="tooltip" data-placement="bottom" title="Rose" theme="colorChange" themeColorName="Rose"></div>
                <div class="shadow-sm color-parent" style="background-color: rgb(188 27 54);" data-toggle="tooltip" data-placement="bottom" title="Bold Rose" theme="colorChange" themeColorName="Bold Rose"></div>
              </div>
            </div>
            <div class="form-group row">
              <label for="modules-theme-default-color-50" class="col-sm-3 col-form-label">Color 50:</label>
              <div class="col-sm-9">
                <div id="colorPicker" class="colorpicker-component input-group input-group-merge mb-3" data-toggle="colorPicker">
                  <input type="text" class="form-control form-control-appended" id="modules-theme-default-color-50" name="themeColor50" placeholder="<?php echo languageVariables("themeColorPlaceholder", "modules", $languageType); ?>" value="<?php echo $readDefaultVariables["color"]["50"]; ?>" themeColor="50">
                  <div class="input-group-append">
                    <div class="input-group-text input-group-addon">
                      <i></i>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="form-group row">
              <label for="modules-theme-default-color-100" class="col-sm-3 col-form-label">Color 100:</label>
              <div class="col-sm-9">
                <div id="colorPicker" class="colorpicker-component input-group input-group-merge mb-3" data-toggle="colorPicker">
                  <input type="text" class="form-control form-control-appended" id="modules-theme-default-color-100" name="themeColor100" placeholder="<?php echo languageVariables("themeColorPlaceholder", "modules", $languageType); ?>" value="<?php echo $readDefaultVariables["color"]["100"]; ?>" themeColor="100">
                  <div class="input-group-append">
                    <div class="input-group-text input-group-addon">
                      <i></i>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="form-group row">
              <label for="modules-theme-default-color-200" class="col-sm-3 col-form-label">Color 200:</label>
              <div class="col-sm-9">
                <div id="colorPicker" class="colorpicker-component input-group input-group-merge mb-3" data-toggle="colorPicker">
                  <input type="text" class="form-control form-control-appended" id="modules-theme-default-color-200" name="themeColor200" placeholder="<?php echo languageVariables("themeColorPlaceholder", "modules", $languageType); ?>" value="<?php echo $readDefaultVariables["color"]["200"]; ?>" themeColor="200">
                  <div class="input-group-append">
                    <div class="input-group-text input-group-addon">
                      <i></i>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="form-group row">
              <label for="modules-theme-default-color-300" class="col-sm-3 col-form-label">Color 300:</label>
              <div class="col-sm-9">
                <div id="colorPicker" class="colorpicker-component input-group input-group-merge mb-3" data-toggle="colorPicker">
                  <input type="text" class="form-control form-control-appended" id="modules-theme-default-color-300" name="themeColor300" placeholder="<?php echo languageVariables("themeColorPlaceholder", "modules", $languageType); ?>" value="<?php echo $readDefaultVariables["color"]["300"]; ?>" themeColor="300">
                  <div class="input-group-append">
                    <div class="input-group-text input-group-addon">
                      <i></i>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="form-group row">
              <label for="modules-theme-default-color-400" class="col-sm-3 col-form-label">Color 400:</label>
              <div class="col-sm-9">
                <div id="colorPicker" class="colorpicker-component input-group input-group-merge mb-3" data-toggle="colorPicker">
                  <input type="text" class="form-control form-control-appended" id="modules-theme-default-color-400" name="themeColor400" placeholder="<?php echo languageVariables("themeColorPlaceholder", "modules", $languageType); ?>" value="<?php echo $readDefaultVariables["color"]["400"]; ?>" themeColor="400">
                  <div class="input-group-append">
                    <div class="input-group-text input-group-addon">
                      <i></i>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="form-group row">
              <label for="modules-theme-default-color-500" class="col-sm-3 col-form-label">Color 500:</label>
              <div class="col-sm-9">
                <div id="colorPicker" class="colorpicker-component input-group input-group-merge mb-3" data-toggle="colorPicker">
                  <input type="text" class="form-control form-control-appended" id="modules-theme-default-color-500" name="themeColor500" placeholder="<?php echo languageVariables("themeColorPlaceholder", "modules", $languageType); ?>" value="<?php echo $readDefaultVariables["color"]["500"]; ?>" themeColor="500">
                  <div class="input-group-append">
                    <div class="input-group-text input-group-addon">
                      <i></i>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="form-group row">
              <label for="modules-theme-default-color-600" class="col-sm-3 col-form-label">Color 600:</label>
              <div class="col-sm-9">
                <div id="colorPicker" class="colorpicker-component input-group input-group-merge mb-3" data-toggle="colorPicker">
                  <input type="text" class="form-control form-control-appended" id="modules-theme-default-color-600" name="themeColor600" placeholder="<?php echo languageVariables("themeColorPlaceholder", "modules", $languageType); ?>" value="<?php echo $readDefaultVariables["color"]["600"]; ?>" themeColor="600">
                  <div class="input-group-append">
                    <div class="input-group-text input-group-addon">
                      <i></i>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="form-group row">
              <label for="modules-theme-default-color-700" class="col-sm-3 col-form-label">Color 700:</label>
              <div class="col-sm-9">
                <div id="colorPicker" class="colorpicker-component input-group input-group-merge mb-3" data-toggle="colorPicker">
                  <input type="text" class="form-control form-control-appended" id="modules-theme-default-color-700" name="themeColor700" placeholder="<?php echo languageVariables("themeColorPlaceholder", "modules", $languageType); ?>" value="<?php echo $readDefaultVariables["color"]["700"]; ?>" themeColor="700">
                  <div class="input-group-append">
                    <div class="input-group-text input-group-addon">
                      <i></i>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="form-group row">
              <label for="modules-theme-default-color-800" class="col-sm-3 col-form-label">Color 800:</label>
              <div class="col-sm-9">
                <div id="colorPicker" class="colorpicker-component input-group input-group-merge mb-3" data-toggle="colorPicker">
                  <input type="text" class="form-control form-control-appended" id="modules-theme-default-color-800" name="themeColor800" placeholder="<?php echo languageVariables("themeColorPlaceholder", "modules", $languageType); ?>" value="<?php echo $readDefaultVariables["color"]["800"]; ?>" themeColor="800">
                  <div class="input-group-append">
                    <div class="input-group-text input-group-addon">
                      <i></i>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="form-group row">
              <label for="modules-theme-default-color-900" class="col-sm-3 col-form-label">Color 900:</label>
              <div class="col-sm-9">
                <div id="colorPicker" class="colorpicker-component input-group input-group-merge mb-3" data-toggle="colorPicker">
                  <input type="text" class="form-control form-control-appended" id="modules-theme-default-color-900" name="themeColor900" placeholder="<?php echo languageVariables("themeColorPlaceholder", "modules", $languageType); ?>" value="<?php echo $readDefaultVariables["color"]["900"]; ?>" themeColor="900">
                  <div class="input-group-append">
                    <div class="input-group-text input-group-addon">
                      <i></i>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="form-group row">
              <label for="modules-theme-default-alert-modal-status" class="col-sm-3 col-form-label"><?php echo languageVariables("themeDefaultAlertModalStatus", "modules", $languageType); ?></label>
              <div class="col-sm-9">
                <select class="form-control" id="modules-theme-default-alert-modal-status" name="alertModalStatus">
                  <option value="0" <?php echo (($readDefaultVariables["alertModalStatus"] == "0") ? "selected" : ""); ?>><?php echo languageVariables("disable", "words", $languageType); ?></option>
                  <option value="1" <?php echo (($readDefaultVariables["alertModalStatus"] == "1") ? "selected" : ""); ?>><?php echo languageVariables("active", "words", $languageType); ?></option>
                </select>
              </div>
            </div>
            <div class="form-group row">
              <label for="modules-theme-default-alert-modal" class="col-sm-3 col-form-label"><?php echo languageVariables("themeDefaultAlertModalContent", "modules", $languageType); ?></label>
              <div class="col-sm-9">
                <textarea name="alertModal" id="modules-theme-default-alert-modal" rows="50" class="form-control" data-toggle="codeMirror"><?php echo $readDefaultVariables["alertModal"]; ?></textarea>
              </div>
            </div>
            <div class="form-group row">
              <label for="modules-theme-default-navbar-type" class="col-sm-3 col-form-label"><?php echo languageVariables("themeNavbarDivider", "modules", $languageType); ?></label>
              <div class="col-sm-9">
                <select class="form-control" id="modules-theme-default-navbar-type" name="themeNavbarType">
                  <option value="0" <?php echo (($readDefaultVariables["navbarType"] == "0") ? "selected" : ""); ?>><?php echo languageVariables("disable", "words", $languageType); ?></option>
                  <option value="1" <?php echo (($readDefaultVariables["navbarType"] == "1") ? "selected" : ""); ?>><?php echo languageVariables("active", "words", $languageType); ?></option>
                </select>
              </div>
            </div>
            <div class="form-group row">
              <label for="modules-theme-default-header-type" class="col-sm-3 col-form-label"><?php echo languageVariables("themeHeaderBlur", "modules", $languageType); ?></label>
              <div class="col-sm-9">
                <select class="form-control" id="modules-theme-default-header-type" name="themeHeaderType">
                  <option value="0" <?php echo (($readDefaultVariables["headerBlur"] == "0") ? "selected" : ""); ?>><?php echo languageVariables("disable", "words", $languageType); ?></option>
                  <option value="1" <?php echo (($readDefaultVariables["headerBlur"] == "1") ? "selected" : ""); ?>><?php echo languageVariables("active", "words", $languageType); ?></option>
                </select>
              </div>
            </div>
            <div class="form-group row">
              <label for="modules-theme-default-header-p-type" class="col-sm-3 col-form-label"><?php echo languageVariables("themeHeaderParticles", "modules", $languageType); ?></label>
              <div class="col-sm-9">
                <select class="form-control" id="modules-theme-default-header-p-type" name="themeHeaderPType">
                  <option value="0" <?php echo (($readDefaultVariables["headerParticles"] == "0") ? "selected" : ""); ?>><?php echo languageVariables("disable", "words", $languageType); ?></option>
                  <option value="1" <?php echo (($readDefaultVariables["headerParticles"] == "1") ? "selected" : ""); ?>><?php echo languageVariables("active", "words", $languageType); ?></option>
                </select>
              </div>
            </div>
            <div class="form-group row">
              <label for="modules-theme-default-body-image-type" class="col-sm-3 col-form-label"><?php echo languageVariables("themeBodyImageType", "modules", $languageType); ?></label>
              <div class="col-sm-9">
                <select class="form-control" id="modules-theme-default-body-image-type" name="themeBodyImageType">
                  <option value="0" <?php echo (($readDefaultVariables["bodyType"] == "0") ? "selected" : ""); ?>><?php echo languageVariables("themethemeBodyImageTypeOption0", "modules", $languageType); ?></option>
                  <option value="1" <?php echo (($readDefaultVariables["bodyType"] == "1") ? "selected" : ""); ?>><?php echo languageVariables("themethemeBodyImageTypeOption1", "modules", $languageType); ?></option>
                  <option value="2" <?php echo (($readDefaultVariables["bodyType"] == "2") ? "selected" : ""); ?>><?php echo languageVariables("themethemeBodyImageTypeOption2", "modules", $languageType); ?></option>
                </select>
              </div>
            </div>
            <div class="form-group row">
              <label for="modules-theme-default-body-image" class="col-sm-3 col-form-label"><?php echo languageVariables("themeBodyImage", "modules", $languageType); ?></label>
              <div class="col-sm-9">
                <div data-toggle="dropimage" class="dropimage active">
                  <div class="di-thumbnail">
                    <img src="<?php echo $readDefaultVariables["bodyImage"]; ?>" alt="<?php echo languageVariables("preview", "words", $languageType); ?>">
                  </div>
                  <div class="di-select">
                    <label for="modules-theme-default-body-image"><?php echo languageVariables("imageUploadImagePlaceholder", "modules", $languageType); ?></label>
                    <input type="file" id="modules-theme-default-body-image" name="defaultBodyImage" accept="image/*">
                  </div>
                </div>
              </div>
            </div>
            <div class="form-group row">
              <label for="modules-theme-default-header-image" class="col-sm-3 col-form-label"><?php echo languageVariables("themeHeaderImage", "modules", $languageType); ?></label>
              <div class="col-sm-9">
                <div data-toggle="dropimage" class="dropimage active">
                  <div class="di-thumbnail">
                    <img src="<?php echo $readDefaultVariables["headerImage"]; ?>" alt="<?php echo languageVariables("preview", "words", $languageType); ?>">
                  </div>
                  <div class="di-select">
                    <label for="modules-theme-default-header-image"><?php echo languageVariables("imageUploadImagePlaceholder", "modules", $languageType); ?></label>
                    <input type="file" id="modules-theme-default-header-image" name="defaultHeaderImage" accept="image/*">
                  </div>
                </div>
              </div>
            </div>
            <div class="form-group row">
              <label for="modules-theme-default-footer-image" class="col-sm-3 col-form-label"><?php echo languageVariables("themeFooterImage", "modules", $languageType); ?></label>
              <div class="col-sm-9">
                <div data-toggle="dropimage" class="dropimage active">
                  <div class="di-thumbnail">
                    <img src="<?php echo $readDefaultVariables["footerImage"]; ?>" alt="<?php echo languageVariables("preview", "words", $languageType); ?>">
                  </div>
                  <div class="di-select">
                    <label for="modules-theme-default-footer-image"><?php echo languageVariables("imageUploadImagePlaceholder", "modules", $languageType); ?></label>
                    <input type="file" id="modules-theme-default-footer-image" name="defaultFooterImage" accept="image/*">
                  </div>
                </div>
              </div>
            </div>
            <div class="form-group row">
              <label for="modules-theme-default-store-image" class="col-sm-3 col-form-label"><?php echo languageVariables("themeStoreImage", "modules", $languageType); ?></label>
              <div class="col-sm-9">
                <div data-toggle="dropimage" class="dropimage active">
                  <div class="di-thumbnail">
                    <img src="<?php echo $readDefaultVariables["storeImage"]; ?>" alt="<?php echo languageVariables("preview", "words", $languageType); ?>">
                  </div>
                  <div class="di-select">
                    <label for="modules-theme-default-store-image"><?php echo languageVariables("imageUploadImagePlaceholder", "modules", $languageType); ?></label>
                    <input type="file" id="modules-theme-default-store-image" name="defaultStoreImage" accept="image/*">
                  </div>
                </div>
              </div>
            </div>
            <div style="float: right;">
              <?php echo $safeCsrfToken->input("editThemeToken"); ?>
              <button type="submit" class="btn btn-primary mr-2" name="editTheme"><?php echo languageVariables("saveChanges", "words", $languageType); ?></button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
      <?php } else if (get("theme") == "south") { ?>
        <?php $readSouthVariables = json_decode($readTheme["southVariables"], true); ?>
<div class="page-content">
  <div class="row">
    <div class="col">
      <nav class="page-breadcrumb">
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="<?php echo urlConverter("admin_home", $languageType); ?>"><?php echo languageVariables("dashboard", "words", $languageType); ?></a></li>
          <li class="breadcrumb-item"><a href="#"><?php echo languageVariables("modules", "words", $languageType); ?></a></li>
          <li class="breadcrumb-item"><a href="<?php echo urlConverter("admin_modules_theme_edit", $languageType); ?>"><?php echo languageVariables("theme", "words", $languageType); ?></a></li>
          <li class="breadcrumb-item active" aria-current="page">South</li>
        </ol>
      </nav>
    </div>
  </div>
  <div class="row">
    <div class="col-md-12 grid-margin stretch-card">
      <div class="card">
        <div class="card-body">
          <h6 class="card-title"><?php echo languageVariables("edit", "words", $languageType); ?></h6>
          <?php
          require_once(__DR__."/main/includes/packages/class/csrf/class.php");
          $safeCsrfToken = new CSRF('csrf-sessions', 'csrf-token');
          if (isset($_POST["editTheme"])) {
            if ($safeCsrfToken->validate('editThemeToken')) {
              if (isset($_POST)) {
                $southVariables = array();
                $proccessStatus = true;
                if ($_FILES["southBodyImage"]["size"] != null) {
                  $imageUploadBody = imageUpload($_FILES["southBodyImage"], "/assets/uploads/images/landing/images/sitary/");
                  if ($imageUploadBody !== false) {
                    unlink(__DR__.$readSouthVariables["bodyImage"]);
                    $southVariables["bodyImage"] = "/assets/uploads/images/landing/images/sitary/".$imageUploadBody["name"];
                  } else {
                    $proccessStatus = false;
                  }
                } else {
                  $southVariables["bodyImage"] = $readSouthVariables["bodyImage"];
                }

                if ($_FILES["southFooterImage"]["size"] != null) {
                  $imageUploadFooter = imageUpload($_FILES["southFooterImage"], "/assets/uploads/images/landing/images/sitary/");
                  if ($imageUploadFooter !== false) {
                    unlink(__DR__.$readSouthVariables["footerImage"]);
                    $southVariables["footerImage"] = "/assets/uploads/images/landing/images/sitary/".$imageUploadFooter["name"];
                  } else {
                    $proccessStatus = false;
                  }
                } else {
                  $southVariables["footerImage"] = $readSouthVariables["footerImage"];
                }

                if ($proccessStatus == true) {
                  $southVariables["bodyType"] = post("themeBodyImageType");
                  $southVariables["defaultColor"] = post("themeDefaultColor");
                  $updateModule = $db->prepare("UPDATE module SET personalizationMode = ?, generalChatStatus = ? WHERE id = ?");
                  $updateModule->execute(array(post("themePersonalizationMode"), post("themeFooterChat"), 0));
                  $updateTheme = $db->prepare("UPDATE theme SET southVariables = ?, themeColor = ? WHERE id = ?");
                  $updateTheme->execute(array(json_encode($southVariables), post("themeDarkColor"), 0));
                  echo alert(languageVariables("alertThemeEditSuccess", "modules", $languageType), "success", "2", "");
                } else {
                  echo alert(languageVariables("alertImageUploadFail", "modules", $languageType), "danger", "0", "/");
                }
              } else {
                echo alert(languageVariables("alertNone", "modules", $languageType), "warning", "0", "/");
              }
            } else {
              echo alert(languageVariables("alertSystem", "modules", $languageType), "danger", "0", "/");
            }
          }
          ?>
          <form class="forms-sample" action="" method="POST" enctype="multipart/form-data">
            <div class="form-group row">
              <label for="modules-theme-south-default-color" class="col-sm-3 col-form-label"><?php echo languageVariables("themeDefaultColor", "modules", $languageType); ?></label>
              <div class="col-sm-9">
                <select class="form-control" id="modules-theme-south-default-color" name="themeDefaultColor">
                  <option value="dark" <?php if ($readSouthVariables["defaultColor"] == "dark") { echo "selected"; } ?>><?php echo languageVariables("themeDefaultColorOption0", "modules", $languageType); ?></option>
                  <option value="light" <?php if ($readSouthVariables["defaultColor"] == "light") { echo "selected"; } ?>><?php echo languageVariables("themeDefaultColorOption1", "modules", $languageType); ?></option>
                </select>
              </div>
            </div>
            <div class="form-group row">
              <label for="modules-theme-south-dark-color" class="col-sm-3 col-form-label"><?php echo languageVariables("themeDarkColor", "modules", $languageType); ?></label>
              <div class="col-sm-9">
                <select class="form-control" id="modules-theme-south-dark-color" name="themeDarkColor">
                  <option value="0" <?php if ($readTheme["themeColor"] == "0") { echo "selected"; } ?>><?php echo languageVariables("themeDarkColorOption0", "modules", $languageType); ?></option>
                  <option value="1" <?php if ($readTheme["themeColor"] == "1") { echo "selected"; } ?>><?php echo languageVariables("themeDarkColorOption1", "modules", $languageType); ?></option>
                </select>
              </div>
            </div>
            <div class="form-group row">
              <label for="modules-theme-south-personalization-mode" class="col-sm-3 col-form-label"><?php echo languageVariables("themePersonalizationMode", "modules", $languageType); ?></label>
              <div class="col-sm-9">
                <select class="form-control" id="modules-theme-south-personalization-mode" name="themePersonalizationMode">
                  <option value="0" <?php if ($readModule["personalizationMode"] == "0") { echo "selected"; } ?>><?php echo languageVariables("disable", "words", $languageType); ?></option>
                  <option value="1" <?php if ($readModule["personalizationMode"] == "1") { echo "selected"; } ?>><?php echo languageVariables("active", "words", $languageType); ?></option>
                </select>
              </div>
            </div>
            <div class="form-group row">
              <label for="modules-theme-south-footer-chat" class="col-sm-3 col-form-label"><?php echo languageVariables("themeGeneralChat", "modules", $languageType); ?></label>
              <div class="col-sm-9">
                <select class="form-control" id="modules-theme-south-footer-chat" name="themeFooterChat">
                  <option value="0" <?php if ($readModule["generalChatStatus"] == "0") { echo "selected"; } ?>><?php echo languageVariables("disable", "words", $languageType); ?></option>
                  <option value="1" <?php if ($readModule["generalChatStatus"] == "1") { echo "selected"; } ?>><?php echo languageVariables("active", "words", $languageType); ?></option>
                </select>
              </div>
            </div>
            <div class="form-group row">
              <label for="modules-theme-south-body-image-type" class="col-sm-3 col-form-label"><?php echo languageVariables("themeBodyImageType", "modules", $languageType); ?></label>
              <div class="col-sm-9">
                <select class="form-control" id="modules-theme-south-body-image-type" name="themeBodyImageType">
                  <option value="0" <?php echo (($readSouthVariables["bodyType"] == "0") ? "selected" : ""); ?>><?php echo languageVariables("themethemeBodyImageTypeOption0", "modules", $languageType); ?></option>
                  <option value="1" <?php echo (($readSouthVariables["bodyType"] == "1") ? "selected" : ""); ?>><?php echo languageVariables("themethemeBodyImageTypeOption1", "modules", $languageType); ?></option>
                  <option value="2" <?php echo (($readSouthVariables["bodyType"] == "2") ? "selected" : ""); ?>><?php echo languageVariables("themethemeBodyImageTypeOption2", "modules", $languageType); ?></option>
                </select>
              </div>
            </div>
            <div class="form-group row">
              <label for="modules-theme-south-body-image" class="col-sm-3 col-form-label"><?php echo languageVariables("themeBodyImage", "modules", $languageType); ?></label>
              <div class="col-sm-9">
                <div data-toggle="dropimage" class="dropimage active">
                  <div class="di-thumbnail">
                    <img src="<?php echo $readSouthVariables["bodyImage"]; ?>" alt="<?php echo languageVariables("preview", "words", $languageType); ?>">
                  </div>
                  <div class="di-select">
                    <label for="modules-theme-south-body-image"><?php echo languageVariables("imageUploadImagePlaceholder", "modules", $languageType); ?></label>
                    <input type="file" id="modules-theme-south-body-image" name="southBodyImage" accept="image/*">
                  </div>
                </div>
              </div>
            </div>
            <div class="form-group row">
              <label for="modules-theme-south-footer-image" class="col-sm-3 col-form-label"><?php echo languageVariables("themeFooterImage", "modules", $languageType); ?></label>
              <div class="col-sm-9">
                <div data-toggle="dropimage" class="dropimage active">
                  <div class="di-thumbnail">
                    <img src="<?php echo $readSouthVariables["footerImage"]; ?>" alt="<?php echo languageVariables("preview", "words", $languageType); ?>">
                  </div>
                  <div class="di-select">
                    <label for="modules-theme-south-footer-image"><?php echo languageVariables("imageUploadImagePlaceholder", "modules", $languageType); ?></label>
                    <input type="file" id="modules-theme-south-footer-image" name="southFooterImage" accept="image/*">
                  </div>
                </div>
              </div>
            </div>
            <div style="float: right;">
              <?php echo $safeCsrfToken->input("editThemeToken"); ?>
              <button type="submit" class="btn btn-primary mr-2" name="editTheme"><?php echo languageVariables("saveChanges", "words", $languageType); ?></button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
      <?php } else if (get("theme") == "sitary") { ?>
        <?php $readSitaryVariables = json_decode($readTheme["sitaryVariables"], true); ?>
<div class="page-content">
  <div class="row">
    <div class="col">
      <nav class="page-breadcrumb">
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="<?php echo urlConverter("admin_home", $languageType); ?>"><?php echo languageVariables("dashboard", "words", $languageType); ?></a></li>
          <li class="breadcrumb-item"><a href="#"><?php echo languageVariables("modules", "words", $languageType); ?></a></li>
          <li class="breadcrumb-item"><a href="<?php echo urlConverter("admin_modules_theme_edit", $languageType); ?>"><?php echo languageVariables("theme", "words", $languageType); ?></a></li>
          <li class="breadcrumb-item active" aria-current="page">Sitary</li>
        </ol>
      </nav>
    </div>
  </div>
  <div class="row">
    <div class="col-md-12 grid-margin stretch-card">
      <div class="card">
        <div class="card-body">
          <h6 class="card-title"><?php echo languageVariables("edit", "words", $languageType); ?></h6>
          <?php
          require_once(__DR__."/main/includes/packages/class/csrf/class.php");
          $safeCsrfToken = new CSRF('csrf-sessions', 'csrf-token');
          if (isset($_POST["editTheme"])) {
            if ($safeCsrfToken->validate('editThemeToken')) {
              if (post("themeColor400") !== "" && post("themeColor500") !== "") {
                $sitaryVariables = array();
                $proccessStatus = true;
                if ($_FILES["sitaryBodyImage"]["size"] != null) {
                  $imageUploadBody = imageUpload($_FILES["sitaryBodyImage"], "/assets/uploads/images/landing/images/sitary/");
                  if ($imageUploadBody !== false) {
                    unlink(__DR__.$readSitaryVariables["bodyImage"]);
                    $sitaryVariables["bodyImage"] = "/assets/uploads/images/landing/images/sitary/".$imageUploadBody["name"];
                  } else {
                    $proccessStatus = false;
                  }
                } else {
                  $sitaryVariables["bodyImage"] = $readSitaryVariables["bodyImage"];
                }

                if ($_FILES["sitaryHeaderImage"]["size"] != null) {
                  $imageUploadHeader = imageUpload($_FILES["sitaryHeaderImage"], "/assets/uploads/images/landing/images/sitary/");
                  if ($imageUploadHeader !== false) {
                    unlink(__DR__.$readSitaryVariables["headerImage"]);
                    $sitaryVariables["headerImage"] = "/assets/uploads/images/landing/images/sitary/".$imageUploadHeader["name"];
                  } else {
                    $proccessStatus = false;
                  }
                } else {
                  $sitaryVariables["headerImage"] = $readSitaryVariables["headerImage"];
                }

                if ($_FILES["sitaryFooterImage"]["size"] != null) {
                  $imageUploadFooter = imageUpload($_FILES["sitaryFooterImage"], "/assets/uploads/images/landing/images/sitary/");
                  if ($imageUploadFooter !== false) {
                    unlink(__DR__.$readSitaryVariables["footerImage"]);
                    $sitaryVariables["footerImage"] = "/assets/uploads/images/landing/images/sitary/".$imageUploadFooter["name"];
                  } else {
                    $proccessStatus = false;
                  }
                } else {
                  $sitaryVariables["footerImage"] = $readSitaryVariables["footerImage"];
                }

                if ($proccessStatus == true) {
                  $sitaryVariables["bodyType"] = post("themeBodyImageType");
                  $sitaryVariables["color"] = array(
                    "400" => post("themeColor400"),
                    "500" => post("themeColor500")
                  );
                  $updateModule = $db->prepare("UPDATE module SET homeBarType = ? WHERE id = ?");
                  $updateModule->execute(array(post("themeHomeBarType"), 0));
                  $updateTheme = $db->prepare("UPDATE theme SET sitaryVariables = ? WHERE id = ?");
                  $updateTheme->execute(array(json_encode($sitaryVariables), 0));
                  echo alert(languageVariables("alertThemeEditSuccess", "modules", $languageType), "success", "2", "");
                } else {
                  echo alert(languageVariables("alertImageUploadFail", "modules", $languageType), "danger", "0", "/");
                }
              } else {
                echo alert(languageVariables("alertNone", "modules", $languageType), "warning", "0", "/");
              }
            } else {
              echo alert(languageVariables("alertSystem", "modules", $languageType), "danger", "0", "/");
            }
          }
          ?>
          <form class="forms-sample" action="" method="POST" enctype="multipart/form-data">
            <div class="form-group row">
              <label for="modules-theme-default-colors" class="col-sm-3 col-form-label">Renkler:</label>
              <div class="col-sm-9" style="display: flex; flex-direction: row; flex-wrap: wrap;">
                <div class="shadow-sm color-parent" style="background-color: rgb(100 116 139);" data-toggle="tooltip" data-placement="top" title="Slate" theme="colorChange" themeColorName="Slate"></div>
                <div class="shadow-sm color-parent" style="background-color: rgb(107 114 128);" data-toggle="tooltip" data-placement="top" title="Gray" theme="colorChange" themeColorName="Gray"></div>
                <div class="shadow-sm color-parent" style="background-color: rgb(113 113 122);" data-toggle="tooltip" data-placement="top" title="Zinc" theme="colorChange" themeColorName="Zinc"></div>
                <div class="shadow-sm color-parent" style="background-color: rgb(115 115 115);" data-toggle="tooltip" data-placement="top" title="Neutral" theme="colorChange" themeColorName="Neutral"></div>
                <div class="shadow-sm color-parent" style="background-color: rgb(120 113 108);" data-toggle="tooltip" data-placement="top" title="Stone" theme="colorChange" themeColorName="Stone"></div>
                <div class="shadow-sm color-parent" style="background-color: rgb(239 68 68);" data-toggle="tooltip" data-placement="top" title="Red" theme="colorChange" themeColorName="Red"></div>
                <div class="shadow-sm color-parent" style="background-color: rgb(200 47 47);" data-toggle="tooltip" data-placement="top" title="Bold Red" theme="colorChange" themeColorName="Bold Red"></div>
                <div class="shadow-sm color-parent" style="background-color: rgb(155 21 21);" data-toggle="tooltip" data-placement="top" title="Extra Bold Red" theme="colorChange" themeColorName="Extra Bold Red"></div>
                <div class="shadow-sm color-parent" style="background-color: rgb(249 115 22);" data-toggle="tooltip" data-placement="top" title="Orange" theme="colorChange" themeColorName="Orange"></div>
                <div class="shadow-sm color-parent" style="background-color: rgb(177 86 24);" data-toggle="tooltip" data-placement="top" title="Bold Orange" theme="colorChange" themeColorName="Bold Orange"></div>
                <div class="shadow-sm color-parent" style="background-color: rgb(99	45 8);" data-toggle="tooltip" data-placement="top" title="Extra Bold Orange" theme="colorChange" themeColorName="Extra Bold Orange"></div>
                <div class="shadow-sm color-parent" style="background-color: rgb(245 158 11);" data-toggle="tooltip" data-placement="top" title="Amber" theme="colorChange" themeColorName="Amber"></div>
                <div class="shadow-sm color-parent" style="background-color: rgb(234 179 8);" data-toggle="tooltip" data-placement="top"  title="Yellow" theme="colorChange" themeColorName="Yellow"></div>
                <div class="shadow-sm color-parent" style="background-color: rgb(114 90 15);" data-toggle="tooltip" data-placement="top"  title="Bold Yellow" theme="colorChange" themeColorName="Bold Yellow"></div>
                <div class="shadow-sm color-parent" style="background-color: rgb(132 204 22);" data-toggle="tooltip" data-placement="top" title="Lime" theme="colorChange" themeColorName="Lime"></div>
                <div class="shadow-sm color-parent" style="background-color: rgb(34 197 94);" data-toggle="tooltip" data-placement="top" title="Green" theme="colorChange" themeColorName="Green"></div>
                <div class="shadow-sm color-parent" style="background-color: rgb(17	147	65);" data-toggle="tooltip" data-placement="top" title="Bold Green" theme="colorChange" themeColorName="Bold Green"></div>
                <div class="shadow-sm color-parent" style="background-color: rgb(5 89 36);" data-toggle="tooltip" data-placement="top" title="Extra Bold Green" theme="colorChange" themeColorName="Extra Bold Green"></div>
                <div class="shadow-sm color-parent" style="background-color: rgb(16 185 129);" data-toggle="tooltip" data-placement="bottom" title="Emerald" theme="colorChange" themeColorName="Emerald"></div>
                <div class="shadow-sm color-parent" style="background-color: rgb(20 184 166);" data-toggle="tooltip" data-placement="bottom" title="Teal" theme="colorChange" themeColorName="Teal"></div>
                <div class="shadow-sm color-parent" style="background-color: rgb(6 182 212);" data-toggle="tooltip" data-placement="bottom" title="Cyan" theme="colorChange" themeColorName="Cyan"></div>
                <div class="shadow-sm color-parent" style="background-color: rgb(14 165 233);" data-toggle="tooltip" data-placement="bottom" title="Sky" theme="colorChange" themeColorName="Sky"></div>
                <div class="shadow-sm color-parent" style="background-color: rgb(59 130 246);" data-toggle="tooltip" data-placement="bottom" title="Blue" theme="colorChange" themeColorName="Blue"></div>
                <div class="shadow-sm color-parent" style="background-color: rgb(33	88 179);" data-toggle="tooltip" data-placement="bottom" title="Bold Blue" theme="colorChange" themeColorName="Bold Blue"></div>
                <div class="shadow-sm color-parent" style="background-color: rgb(8 46 109);" data-toggle="tooltip" data-placement="bottom" title="Extra Bold Blue" theme="colorChange" themeColorName="Extra Bold Blue"></div>
                <div class="shadow-sm color-parent" style="background-color: rgb(99 102 241);" data-toggle="tooltip" data-placement="bottom" title="Indigo" theme="colorChange" themeColorName="Indigo"></div>
                <div class="shadow-sm color-parent" style="background-color: rgb(60	62 178);" data-toggle="tooltip" data-placement="bottom" title="Bold Indigo" theme="colorChange" themeColorName="Bold Indigo"></div>
                <div class="shadow-sm color-parent" style="background-color: rgb(45	46 123);" data-toggle="tooltip" data-placement="bottom" title="Extra Bold Indigo" theme="colorChange" themeColorName="Extra Bold Indigo"></div>
                <div class="shadow-sm color-parent" style="background-color: rgb(139 92 246);" data-toggle="tooltip" data-placement="bottom" title="Violet" theme="colorChange" themeColorName="Violet"></div>
                <div class="shadow-sm color-parent" style="background-color: rgb(168 85 247);" data-toggle="tooltip" data-placement="bottom" title="Purple" theme="colorChange" themeColorName="Purple"></div>
                <div class="shadow-sm color-parent" style="background-color: rgb(217 70 239);" data-toggle="tooltip" data-placement="bottom" title="Fuchsia" theme="colorChange" themeColorName="Fuchsia"></div>
                <div class="shadow-sm color-parent" style="background-color: rgb(236 72 153);" data-toggle="tooltip" data-placement="bottom" title="Pink" theme="colorChange" themeColorName="Pink"></div>
                <div class="shadow-sm color-parent" style="background-color: rgb(244 63 94);" data-toggle="tooltip" data-placement="bottom" title="Rose" theme="colorChange" themeColorName="Rose"></div>
                <div class="shadow-sm color-parent" style="background-color: rgb(188 27 54);" data-toggle="tooltip" data-placement="bottom" title="Bold Rose" theme="colorChange" themeColorName="Bold Rose"></div>
              </div>
            </div>
            <div class="form-group row">
              <label for="modules-theme-sitary-color-400" class="col-sm-3 col-form-label">Color 400:</label>
              <div class="col-sm-9">
                <div id="colorPicker" class="colorpicker-component input-group input-group-merge mb-3" data-toggle="colorPicker">
                  <input type="text" class="form-control form-control-appended" id="modules-theme-sitary-color-400" name="themeColor400" placeholder="<?php echo languageVariables("themeColorPlaceholder", "modules", $languageType); ?>" value="<?php echo $readSitaryVariables["color"]["400"]; ?>" themeColor="400">
                  <div class="input-group-append">
                    <div class="input-group-text input-group-addon">
                      <i></i>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="form-group row">
              <label for="modules-theme-sitary-color-500" class="col-sm-3 col-form-label">Color 500:</label>
              <div class="col-sm-9">
                <div id="colorPicker" class="colorpicker-component input-group input-group-merge mb-3" data-toggle="colorPicker">
                  <input type="text" class="form-control form-control-appended" id="modules-theme-sitary-color-500" name="themeColor500" placeholder="<?php echo languageVariables("themeColorPlaceholder", "modules", $languageType); ?>" value="<?php echo $readSitaryVariables["color"]["500"]; ?>" themeColor="500">
                  <div class="input-group-append">
                    <div class="input-group-text input-group-addon">
                      <i></i>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="form-group row">
              <label for="modules-theme-sitary-home-type" class="col-sm-3 col-form-label"><?php echo languageVariables("themeHomeBarType", "modules", $languageType); ?></label>
              <div class="col-sm-9">
                <select class="form-control" id="modules-theme-sitary-home-type" name="themeHomeBarType">
                  <option value="0" <?php if ($readModule["homeBarType"] == "0") { echo "selected"; } ?>><?php echo languageVariables("themeHomeBarTypeOption0", "modules", $languageType); ?></option>
                  <option value="1" <?php if ($readModule["homeBarType"] == "1") { echo "selected"; } ?>><?php echo languageVariables("themeHomeBarTypeOption1", "modules", $languageType); ?></option>
                </select>
              </div>
            </div>
            <div class="form-group row">
              <label for="modules-theme-sitary-body-image-type" class="col-sm-3 col-form-label"><?php echo languageVariables("themeBodyImageType", "modules", $languageType); ?></label>
              <div class="col-sm-9">
                <select class="form-control" id="modules-theme-sitary-body-image-type" name="themeBodyImageType">
                  <option value="0" <?php echo (($readSitaryVariables["bodyType"] == "0") ? "selected" : ""); ?>><?php echo languageVariables("themethemeBodyImageTypeOption0", "modules", $languageType); ?></option>
                  <option value="1" <?php echo (($readSitaryVariables["bodyType"] == "1") ? "selected" : ""); ?>><?php echo languageVariables("themethemeBodyImageTypeOption1", "modules", $languageType); ?></option>
                  <option value="2" <?php echo (($readSitaryVariables["bodyType"] == "2") ? "selected" : ""); ?>><?php echo languageVariables("themethemeBodyImageTypeOption2", "modules", $languageType); ?></option>
                </select>
              </div>
            </div>
            <div class="form-group row">
              <label for="modules-theme-sitary-body-image" class="col-sm-3 col-form-label"><?php echo languageVariables("themeBodyImage", "modules", $languageType); ?></label>
              <div class="col-sm-9">
                <div data-toggle="dropimage" class="dropimage active">
                  <div class="di-thumbnail">
                    <img src="<?php echo $readSitaryVariables["bodyImage"]; ?>" alt="<?php echo languageVariables("preview", "words", $languageType); ?>">
                  </div>
                  <div class="di-select">
                    <label for="modules-theme-sitary-body-image"><?php echo languageVariables("imageUploadImagePlaceholder", "modules", $languageType); ?></label>
                    <input type="file" id="modules-theme-sitary-body-image" name="sitaryBodyImage" accept="image/*">
                  </div>
                </div>
              </div>
            </div>
            <div class="form-group row">
              <label for="modules-theme-sitary-header-image" class="col-sm-3 col-form-label"><?php echo languageVariables("themeHeaderImage", "modules", $languageType); ?></label>
              <div class="col-sm-9">
                <div data-toggle="dropimage" class="dropimage active">
                  <div class="di-thumbnail">
                    <img src="<?php echo $readSitaryVariables["headerImage"]; ?>" alt="<?php echo languageVariables("preview", "words", $languageType); ?>">
                  </div>
                  <div class="di-select">
                    <label for="modules-theme-sitary-header-image"><?php echo languageVariables("imageUploadImagePlaceholder", "modules", $languageType); ?></label>
                    <input type="file" id="modules-theme-sitary-header-image" name="sitaryHeaderImage" accept="image/*">
                  </div>
                </div>
              </div>
            </div>
            <div class="form-group row">
              <label for="modules-theme-sitary-footer-image" class="col-sm-3 col-form-label"><?php echo languageVariables("themeFooterImage", "modules", $languageType); ?></label>
              <div class="col-sm-9">
                <div data-toggle="dropimage" class="dropimage active">
                  <div class="di-thumbnail">
                    <img src="<?php echo $readSitaryVariables["footerImage"]; ?>" alt="<?php echo languageVariables("preview", "words", $languageType); ?>">
                  </div>
                  <div class="di-select">
                    <label for="modules-theme-sitary-footer-image"><?php echo languageVariables("imageUploadImagePlaceholder", "modules", $languageType); ?></label>
                    <input type="file" id="modules-theme-sitary-footer-image" name="sitaryFooterImage" accept="image/*">
                  </div>
                </div>
              </div>
            </div>
            <div style="float: right;">
              <?php echo $safeCsrfToken->input("editThemeToken"); ?>
              <button type="submit" class="btn btn-primary mr-2" name="editTheme"><?php echo languageVariables("saveChanges", "words", $languageType); ?></button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
      <?php } ?>
    <?php } else { ?>
      <?php $searchThemes = $db->query("SELECT * FROM themes ORDER BY id ASC"); ?>
<div class="page-content">
  <div class="row">
    <div class="col">
      <nav class="page-breadcrumb">
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="<?php echo urlConverter("admin_home", $languageType); ?>"><?php echo languageVariables("dashboard", "words", $languageType); ?></a></li>
          <li class="breadcrumb-item"><a href="#"><?php echo languageVariables("modules", "words", $languageType); ?></a></li>
          <li class="breadcrumb-item"><a href="<?php echo urlConverter("admin_modules_theme_edit", $languageType); ?>"><?php echo languageVariables("theme", "words", $languageType); ?></a></li>
          <li class="breadcrumb-item active" aria-current="page"><?php echo languageVariables("themes", "words", $languageType); ?></li>
        </ol>
      </nav>
    </div>
    <div class="col-auto">
      <a class="btn btn-sm btn-primary" href="<?php echo urlConverter("admin_modules_theme_add", $languageType); ?>"><?php echo languageVariables("add", "words", $languageType); ?></a>
    </div>
  </div>
  <div class="row">
    <div class="col-md-12">
      <div id="connectAlertSuccess" style="display: none;">
        <div class="alert alert-icon-success" role="alert">
          <i data-feather="disc"></i>
          <?php echo languageVariables("alertThemeChangeSuccess", "modules", $languageType); ?>
        </div>
      </div>
      <div id="connectAlertError" style="display: none;">
        <div class="alert alerot-icon-danger" role="alert">
          <i data-feather="x-circle"></i>
          <?php echo languageVariables("alertSystem", "modules", $languageType); ?>
        </div>
      </div>
    </div>
    <?php foreach ($searchThemes as $readThemes) { ?>
    <div class="col-md-4 mb-3">
      <div class="card">
        <img src="<?php echo $readThemes["image"]; ?>" class="card-img-top" alt="Default Photo">
        <div class="card-body">
          <h5 class="card-title text-center"><?php echo $readThemes["name"]; ?></h5>
          <p class="card-text"><?php echo $readThemes["text"]; ?></p>
          <div class="form-group row mt-3 text-center">
            <div class="col-sm-12">
              <select class="form-control" themes="changeThemes" theme-id="<?php echo $readThemes["id"]; ?>" <?php if ($readThemes["themesStatus"] == "0") { echo "disabled"; } ?>>
                <option value="0" <?php if ($readThemes["status"] == "0") { echo "selected"; } ?>><?php echo languageVariables("disable", "words", $languageType); ?></option>
                <option value="1" <?php if ($readThemes["status"] == "1") { echo "selected"; } ?>><?php echo languageVariables("active", "words", $languageType); ?></option>
              </select>
            </div>
          </div>
        </div>
      </div>
    </div>
    <?php } ?>
  </div>
</div>
    <?php } ?>
  <?php } else if (get("target") == "add") { ?>
<div class="page-content">
  <nav class="page-breadcrumb">
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="<?php echo urlConverter("admin_home", $languageType); ?>"><?php echo languageVariables("dashboard", "words", $languageType); ?></a></li>
      <li class="breadcrumb-item"><a href="#"><?php echo languageVariables("modules", "words", $languageType); ?></a></li>
      <li class="breadcrumb-item"><a href="<?php echo urlConverter("admin_modules_theme_edit", $languageType); ?>"><?php echo languageVariables("theme", "words", $languageType); ?></a></li>
      <li class="breadcrumb-item active" aria-current="page"><?php echo languageVariables("add", "words", $languageType); ?></li>
    </ol>
  </nav>
  <div class="row">
    <div class="col-md-12 grid-margin stretch-card">
      <div class="card">
        <div class="card-body">
          <h6 class="card-title"><?php echo languageVariables("add", "words", $languageType); ?></h6>
          <?php
          require_once(__DR__."/main/includes/packages/class/csrf/class.php");
          $safeCsrfToken = new CSRF('csrf-sessions', 'csrf-token');
          if (isset($_POST["addTheme"])) {
            if ($safeCsrfToken->validate('addThemeToken')) {
              if (post("themeTitle") !== "" && post("themeDescription") !== "") {
                if ($_FILES["themeImage"]["size"] !== null) {
                  if ($_FILES["themeFile"]["size"] !== null) {
                    $themeFileName = $_FILES['themeFile']['name'];
                    $themeFileSize = $_FILES['themeFile']['size'];
                    $themeFileTmpName  = $_FILES['themeFile']['tmp_name'];
                    $themeFileType = $_FILES['themeFile']['type'];
                    $themeFileExtension = strtolower(end(explode('.',$themeFileName)));
                    $filesName = rand(1,10000000) . "-" . createSlug(basename($themeFileName));
                    $directory = __DR__ . "/themes/files/" . $filesName;

                    if ($themeFileExtension == "zip") {
                      if (15000000 > $themeFileSize) {
                        $imageUpload = imageUpload($_FILES["themeImage"], "/assets/uploads/images/landing/themes/");
                        if ($imageUpload !== false) {
                          $fileUpload = move_uploaded_file($themeFileTmpName, $directory);
                          if ($fileUpload) {
                            $zipArchive = new ZipArchive;
                            $zipResponse = $zipArchive->open(__DR__."/themes/files/".$filesName);
                            if ($zipResponse === TRUE) {
                              $filesExtract = $zipArchive->extractTo(__DR__."/");
                              $zipArchive->close();
                              if ($filesExtract) {
                                $insertTheme = $db->prepare("INSERT INTO themes (`name`, `text`, `code`, `image`, `fileSlug`, `date`, `status`, `themesStatus`) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
                                $insertTheme->execute(array(post("themeTitle"), post("themeDescription"), createSlug(post("themeTitle").rand(100,200)), "/assets/uploads/images/landing/themes/".$imageUpload["name"], post("themeCode"), date("d.m.Y H:i:s"), 0, 1));
                                echo alert(languageVariables("alertThemeAddSuccess", "modules", $languageType), "success", "2", urlConverter("admin_modules_theme_edit", $languageType));
                                unlink(__DR__."/themes/files/".$filesName);
                              } else {
                                echo alert(languageVariables("alertThemeAddFileExtractError", "modules", $languageType), "danger", "0", "/");
                                unlink(__DR__."/themes/files/".$filesName);
                              }
                            } else {
                              echo alert(languageVariables("alertThemeAddFileExtractError", "modules", $languageType)." (CODE: ZIP)", "danger", "0", "/");
                              unlink(__DR__."/themes/files/".$filesName);
                            }
                          } else {
                            echo alert(languageVariables("alertThemeAddFileExtractError", "modules", $languageType)." (CODE: UPLOAD)", "danger", "0", "/");
                          }
                        } else {
                          echo alert(languageVariables("alertImageUploadFail", "modules", $languageType), "danger", "0", "/");
                        }
                      } else {
                        echo alert(languageVariables("alertThemeAddFileExtractError", "modules", $languageType)." (CODE: SIZE)", "danger", "0", "/");
                      }
                    } else {
                      echo alert(languageVariables("alertThemeAddFileExtractError", "modules", $languageType)." (CODE: EXTENSION)", "danger", "0", "/");
                    }
                  } else {
                    echo alert(languageVariables("alertThemeAddFileUrlError", "modules", $languageType), "danger", "0", "/");
                  }
                } else {
                  echo alert(languageVariables("alertImageNone", "modules", $languageType), "warning", "0", "/");
                }
              } else {
                echo alert(languageVariables("alertNone", "modules", $languageType), "warning", "0", "/");
              }
            } else {
              echo alert(languageVariables("alertSystem", "modules", $languageType), "danger", "0", "/");
            }
          }
          ?>
          <form class="forms-sample" action="" method="POST" enctype="multipart/form-data">
            <div class="form-group row">
              <label for="modules-theme-title" class="col-sm-3 col-form-label"><?php echo languageVariables("themeTitle", "modules", $languageType); ?></label>
              <div class="col-sm-9">
                <input type="text" class="form-control" id="modules-theme-title" name="themeTitle" placeholder="<?php echo languageVariables("themeTitlePlaceholder", "modules", $languageType); ?>">
              </div>
            </div>
            <div class="form-group row">
              <label for="modules-theme-desc" class="col-sm-3 col-form-label"><?php echo languageVariables("themeDescription", "modules", $languageType); ?></label>
              <div class="col-sm-9">
                <input type="text" class="form-control" id="modules-theme-desc" name="themeDescription" placeholder="<?php echo languageVariables("themeDescriptionPlaceholder", "modules", $languageType); ?>">
              </div>
            </div>
            <div class="form-group row">
              <label for="modules-theme-file-code" class="col-sm-3 col-form-label"><?php echo languageVariables("themeFileCode", "modules", $languageType); ?></label>
              <div class="col-sm-9">
                <input type="text" class="form-control" id="modules-theme-file-code" name="themeCode" placeholder="<?php echo languageVariables("themeFileCodePlaceholder", "modules", $languageType); ?>">
              </div>
            </div>
            <div class="form-group row">
              <label for="modules-theme-file" class="col-sm-3 col-form-label"><?php echo languageVariables("themeUrl", "modules", $languageType); ?></label>
              <div class="col-sm-9">
                <input type="file" class="form-control" id="modules-theme-file" name="themeFile">
              </div>
            </div>
            <div class="form-group row">
              <label for="modules-theme-image" class="col-sm-3 col-form-label"><?php echo languageVariables("image", "words", $languageType); ?>:</label>
              <div class="col-sm-9">
                <div data-toggle="dropimage" class="dropimage">
                  <div class="di-thumbnail">
                    <img src="" alt="<?php echo languageVariables("preview", "words", $languageType); ?>">
                  </div>
                  <div class="di-select">
                    <label for="modules-theme-image"><?php echo languageVariables("imageUploadImagePlaceholder", "modules", $languageType); ?></label>
                    <input type="file" id="modules-theme-image" name="themeImage" accept="image/*">
                  </div>
                </div>
              </div>
            </div>
            <div style="float: right;">
              <?php echo $safeCsrfToken->input("addThemeToken"); ?>
              <button type="submit" class="btn btn-primary mr-2" name="addTheme"><?php echo languageVariables("add", "words", $languageType); ?></button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
  <?php } ?>
<?php } else if (get("action") == "webhooks") { ?>
<?php if (AccountPermControl($readAccount["id"], "modules_webhooks") == "PERMISSION_NOT_FOUND") { go(urlConverter("admin_perm_error", $languageType)); } ?>
  <?php $searchWebhooks = $db->query("SELECT * FROM webhooks ORDER BY id ASC"); ?>
  <?php $readWebhooks = fetch($searchWebhooks); ?>
  <?php if (get("target") == "credit") { ?>
<div class="page-content">
  <nav class="page-breadcrumb">
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="<?php echo urlConverter("admin_home", $languageType); ?>"><?php echo languageVariables("dashboard", "words", $languageType); ?></a></li>
      <li class="breadcrumb-item"><a href="#"><?php echo languageVariables("modules", "words", $languageType); ?></a></li>
      <li class="breadcrumb-item"><a href="<?php echo urlConverter("admin_modules_webhook_credit", $languageType); ?>"><?php echo languageVariables("webhooks", "words", $languageType); ?></a></li>
      <li class="breadcrumb-item active" aria-current="page"><?php echo languageVariables("credit", "words", $languageType); ?></li>
    </ol>
  </nav>
  <div class="row">
    <div class="col-md-12 grid-margin stretch-card">
      <div class="card">
        <div class="card-body">
          <h6 class="card-title"><?php echo languageVariables("creditUpload", "words", $languageType); ?></h6>
          <?php
          require_once(__DR__."/main/includes/packages/class/csrf/class.php");
          $safeCsrfToken = new CSRF('csrf-sessions', 'csrf-token');
          if (isset($_POST["saveChanges"])) {
            if ($safeCsrfToken->validate('saveChangesToken')) {
              if (post("webhooksCreditStatus") == 0 || (post("webhooksCreditAPI") !== "" && post("webhooksCreditTitle") !== "" && post("webhooksCreditText") !== "")) {
                $creditImage = ((post("webhooksCreditImage") !== "") ? post("webhooksCreditImage") : "0");
                $saveChanges = $db->prepare("UPDATE webhooks SET webhookCreditStatus = ?, webhookCreditName = ?, webhookCreditImage = ?, webhookCreditAPI = ?, webhookCreditTitle = ?, webhookCreditDescription = ?, webhookCreditSignature = ? WHERE id = ?");
                $saveChanges->execute(array(post("webhooksCreditStatus"), post("webhooksCreditName"), $creditImage, post("webhooksCreditAPI"), post("webhooksCreditTitle"), $_POST["webhooksCreditText"], post("webhooksCreditSignature"), $readWebhooks["id"]));
                echo alert(languageVariables("alertSaveChanges", "modules", $languageType), "success", "2", "");
              } else {
                echo alert(languageVariables("alertNone", "modules", $languageType), "warning", "0", "/");
              }
            } else {
              echo alert(languageVariables("alertSystem", "modules", $languageType), "danger", "0", "/");
            }
          }
          ?>
            <form class="forms-sample" action="" method="POST" enctype="multipart/form-data">
              <input type="hidden" data-toggle="webhooksType" value="<?php echo get("target"); ?>">
              <div class="form-group row">
                <label for="modules-webhooks-credit-status" class="col-sm-3 col-form-label"><?php echo languageVariables("webhookStatus", "modules", $languageType); ?></label>
                <div class="col-sm-9">
                  <select class="form-control" id="modules-webhooks-credit-status" name="webhooksCreditStatus" webhooks="status">
                    <option value="0" <?php if ($readWebhooks["webhookCreditStatus"] == "0") { echo "selected"; } ?>><?php echo languageVariables("disable", "words", $languageType); ?></option>
                    <option value="1" <?php if ($readWebhooks["webhookCreditStatus"] == "1") { echo "selected"; } ?>><?php echo languageVariables("active", "words", $languageType); ?></option>
                  </select>
                </div>
              </div>
              <div webhooks="input" <?php if ($readWebhooks["webhookCreditStatus"] == "0") { echo "style=\"display: none;\""; } ?>>
                <div class="form-group row">
                  <label for="modules-webhooks-credit-api" class="col-sm-3 col-form-label"><?php echo languageVariables("webhookUrl", "modules", $languageType); ?></label>
                  <div class="col-sm-9">
                    <input type="text" name="webhooksCreditAPI" id="modules-webhooks-credit-api" placeholder="<?php echo languageVariables("webhookUrlPlaceholder", "modules", $languageType); ?>" class="form-control" value="<?php echo $readWebhooks["webhookCreditAPI"]; ?>" data-toggle="webhooksAPI" required>
                  </div>
                </div>
                <div class="form-group row">
                  <label for="modules-webhooks-credit-name" class="col-sm-3 col-form-label"><?php echo languageVariables("webhookName", "modules", $languageType); ?></label>
                  <div class="col-sm-9">
                    <input type="text" name="webhooksCreditName" id="modules-webhooks-credit-name" placeholder="<?php echo languageVariables("webhookNamePlaceholder", "modules", $languageType); ?>" class="form-control" value="<?php echo $readWebhooks["webhookCreditName"]; ?>" data-toggle="webhooksName" required>
                  </div>
                </div>
                <div class="form-group row">
                  <label for="modules-webhooks-credit-image" class="col-sm-3 col-form-label"><?php echo languageVariables("webhookImageUrl", "modules", $languageType); ?></label>
                  <div class="col-sm-9">
                    <input type="text" name="webhooksCreditImage" id="modules-webhooks-credit-image" placeholder="<?php echo languageVariables("webhookImageUrlPlaceholder", "modules", $languageType); ?>" class="form-control" value="<?php echo (($readWebhooks["webhookCreditImage"] == "0") ? "" : $readWebhooks["webhookCreditImage"]); ?>" data-toggle="webhooksImage" required>
                  </div>
                </div>
                <div class="form-group row">
                  <label for="modules-webhooks-credit-title" class="col-sm-3 col-form-label"><?php echo languageVariables("webhookTitle", "modules", $languageType); ?></label>
                  <div class="col-sm-9">
                    <input type="text" name="webhooksCreditTitle" id="modules-webhooks-credit-title" placeholder="<?php echo languageVariables("webhookTitlePlaceholder", "modules", $languageType); ?>" class="form-control" value="<?php echo $readWebhooks["webhookCreditTitle"]; ?>" data-toggle="webhooksTitle" required>
                  </div>
                </div>
                <div class="form-group row">
                  <label for="modules-webhooks-credit-text" class="col-sm-3 col-form-label"><?php echo languageVariables("webhookContent", "modules", $languageType); ?></label>
                  <div class="col-sm-9">
                    <textarea name="webhooksCreditText" id="modules-webhooks-credit-text" class="form-control" rows="6" data-toggle="webhooksContent"><?php echo $readWebhooks['webhookCreditDescription']; ?></textarea>
                    <small class="form-text text-muted">
                      <?php echo languageVariables("webhookCreditContentJoker0", "modules", $languageType); ?>
                    </small>
                    <small class="form-text text-muted">
                      <?php echo languageVariables("webhookCreditContentJoker1", "modules", $languageType); ?>
                    </small>
                  </div>
                </div>
                <div class="form-group row">
                  <label for="modules-webhooks-credit-signature" class="col-sm-3 col-form-label"><?php echo languageVariables("webhookSignature", "modules", $languageType); ?></label>
                  <div class="col-sm-9">
                    <select class="form-control" id="modules-webhooks-credit-signature" name="webhooksCreditSignature" data-toggle="webhooksSignature">
                      <option value="0" <?php if($readWebhooks['webhookCreditSignature'] == "0"){ echo 'selected'; } ?>><?php echo languageVariables("disable", "words", $languageType); ?></option>
                      <option value="1" <?php if($readWebhooks['webhookCreditSignature'] == "1"){ echo 'selected'; } ?>><?php echo languageVariables("active", "words", $languageType); ?></option>
                    </select>
                  </div>
                </div>
              </div>
              <div id="connectAlertSuccess" style="display: none;">
                <div class="alert alert-icon-success" role="alert">
                  <i data-feather="disc"></i>
                  <?php echo languageVariables("alertWebhookControlSuccess", "modules", $languageType); ?>
                </div>
              </div>
              <div id="connectAlertError" style="display: none;">
                <div class="alert alert-icon-danger" role="alert">
                  <i data-feather="x-circle"></i>
                  <?php echo languageVariables("alertWebhookControlFail", "modules", $languageType); ?>
                </div>
              </div>
              <div style="float: right;">
                <?php echo $safeCsrfToken->input("saveChangesToken"); ?>
                <button type="submit" class="btn btn-primary mr-2" name="saveChanges"><?php echo languageVariables("saveChanges", "words", $languageType); ?></button>
                <button type="button" class="btn btn-light" id="webhooksConnectControl"><?php echo languageVariables("control", "words", $languageType); ?></button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
</div>
  <?php } else if (get("target") == "store") { ?>
<div class="page-content">
  <nav class="page-breadcrumb">
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="<?php echo urlConverter("admin_home", $languageType); ?>"><?php echo languageVariables("dashboard", "words", $languageType); ?></a></li>
      <li class="breadcrumb-item"><a href="#"><?php echo languageVariables("modules", "words", $languageType); ?></a></li>
      <li class="breadcrumb-item"><a href="<?php echo urlConverter("admin_modules_webhook_store", $languageType); ?>"><?php echo languageVariables("webhooks", "words", $languageType); ?></a></li>
      <li class="breadcrumb-item active" aria-current="page"><?php echo languageVariables("store", "words", $languageType); ?></li>
    </ol>
  </nav>
  <div class="row">
    <div class="col-md-12 grid-margin stretch-card">
      <div class="card">
        <div class="card-body">
          <h6 class="card-title"><?php echo languageVariables("storeCheck", "words", $languageType); ?></h6>
          <?php
          require_once(__DR__."/main/includes/packages/class/csrf/class.php");
          $safeCsrfToken = new CSRF('csrf-sessions', 'csrf-token');
          if (isset($_POST["saveChanges"])) {
            if ($safeCsrfToken->validate('saveChangesToken')) {
              if (post("webhooksStoreStatus") == 0 || (post("webhooksStoreAPI") !== "" && post("webhooksStoreTitle") !== "" && post("webhooksStoreText") !== "")) {
                $storeImage = ((post("webhooksStoreImage") !== "") ? post("webhooksStoreImage") : "0");
                $saveChanges = $db->prepare("UPDATE webhooks SET webhookStoreStatus = ?, webhookStoreName = ?, webhookStoreImage = ?, webhookStoreAPI = ?, webhookStoreTitle = ?, webhookStoreDescription = ?, webhookStoreSignature = ? WHERE id = ?");
                $saveChanges->execute(array(post("webhooksStoreStatus"), post("webhooksStoreName"), $storeImage, post("webhooksStoreAPI"), post("webhooksStoreTitle"), $_POST["webhooksStoreText"], post("webhooksStoreSignature"), $readWebhooks["id"]));
                echo alert(languageVariables("alertSaveChanges", "modules", $languageType), "success", "2", "");
              } else {
                echo alert(languageVariables("alertNone", "modules", $languageType), "warning", "0", "/");
              }
            } else {
              echo alert(languageVariables("alertSystem", "modules", $languageType), "danger", "0", "/");
            }
          }
          ?>
            <form class="forms-sample" action="" method="POST" enctype="multipart/form-data">
              <input type="hidden" data-toggle="webhooksType" value="<?php echo get("target"); ?>">
              <div class="form-group row">
                <label for="modules-webhooks-store-status" class="col-sm-3 col-form-label"><?php echo languageVariables("webhookStatus", "modules", $languageType); ?></label>
                <div class="col-sm-9">
                  <select class="form-control" id="modules-webhooks-store-status" name="webhooksStoreStatus" webhooks="status">
                    <option value="0" <?php if ($readWebhooks["webhookStoreStatus"] == "0") { echo "selected"; } ?>><?php echo languageVariables("disable", "words", $languageType); ?></option>
                    <option value="1" <?php if ($readWebhooks["webhookStoreStatus"] == "1") { echo "selected"; } ?>><?php echo languageVariables("active", "words", $languageType); ?></option>
                  </select>
                </div>
              </div>
              <div webhooks="input" <?php if ($readWebhooks["webhookStoreStatus"] == "0") { echo "style=\"display: none;\""; } ?>>
                <div class="form-group row">
                  <label for="modules-webhooks-store-api" class="col-sm-3 col-form-label"><?php echo languageVariables("webhookUrl", "modules", $languageType); ?></label>
                  <div class="col-sm-9">
                    <input type="text" name="webhooksStoreAPI" id="modules-webhooks-store-api" placeholder="<?php echo languageVariables("webhookUrlPlaceholder", "modules", $languageType); ?>" class="form-control" value="<?php echo $readWebhooks["webhookStoreAPI"]; ?>" data-toggle="webhooksAPI" required>
                  </div>
                </div>
                <div class="form-group row">
                  <label for="modules-webhooks-store-name" class="col-sm-3 col-form-label"><?php echo languageVariables("webhookName", "modules", $languageType); ?></label>
                  <div class="col-sm-9">
                    <input type="text" name="webhooksStoreName" id="modules-webhooks-store-name" placeholder="<?php echo languageVariables("webhookNamePlaceholder", "modules", $languageType); ?>" class="form-control" value="<?php echo $readWebhooks["webhookStoreName"]; ?>" data-toggle="webhooksName" required>
                  </div>
                </div>
                <div class="form-group row">
                  <label for="modules-webhooks-store-image" class="col-sm-3 col-form-label"><?php echo languageVariables("webhookImageUrl", "modules", $languageType); ?></label>
                  <div class="col-sm-9">
                    <input type="text" name="webhooksStoreImage" id="modules-webhooks-store-image" placeholder="<?php echo languageVariables("webhookImageUrlPlaceholder", "modules", $languageType); ?>" class="form-control" value="<?php echo (($readWebhooks["webhookStoreImage"] == "0") ? "" : $readWebhooks["webhookStoreImage"]); ?>" data-toggle="webhooksImage" required>
                  </div>
                </div>
                <div class="form-group row">
                  <label for="modules-webhooks-store-title" class="col-sm-3 col-form-label"><?php echo languageVariables("webhookTitle", "modules", $languageType); ?></label>
                  <div class="col-sm-9">
                    <input type="text" name="webhooksStoreTitle" id="modules-webhooks-store-title" placeholder="<?php echo languageVariables("webhookTitlePlaceholder", "modules", $languageType); ?>" class="form-control" value="<?php echo $readWebhooks["webhookStoreTitle"]; ?>" data-toggle="webhooksTitle" required>
                  </div>
                </div>
                <div class="form-group row">
                  <label for="modules-webhooks-store-text" class="col-sm-3 col-form-label"><?php echo languageVariables("webhookContent", "modules", $languageType); ?></label>
                  <div class="col-sm-9">
                    <textarea name="webhooksStoreText" id="modules-webhooks-store-text" class="form-control" rows="6" data-toggle="webhooksContent"><?php echo $readWebhooks['webhookStoreDescription']; ?></textarea>
                    <small class="form-text text-muted">
                    <?php echo languageVariables("webhookStoreContentJoker0", "modules", $languageType); ?>
                    </small>
                    <small class="form-text text-muted">
                    <?php echo languageVariables("webhookStoreContentJoker1", "modules", $languageType); ?>
                    </small>
                    <small class="form-text text-muted">
                    <?php echo languageVariables("webhookStoreContentJoker2", "modules", $languageType); ?>
                    </small>
                  </div>
                </div>
                <div class="form-group row">
                  <label for="modules-webhooks-store-signature" class="col-sm-3 col-form-label"><?php echo languageVariables("webhookSignature", "modules", $languageType); ?></label>
                  <div class="col-sm-9">
                    <select class="form-control" id="modules-webhooks-store-signature" name="webhooksStoreSignature" data-toggle="webhooksSignature">
                      <option value="0" <?php if($readWebhooks['webhookStoreSignature'] == "0"){ echo 'selected'; } ?>><?php echo languageVariables("disable", "words", $languageType); ?></option>
                      <option value="1" <?php if($readWebhooks['webhookStoreSignature'] == "1"){ echo 'selected'; } ?>><?php echo languageVariables("active", "words", $languageType); ?></option>
                    </select>
                  </div>
                </div>
              </div>
              <div id="connectAlertSuccess" style="display: none;">
                <div class="alert alert-icon-success" role="alert">
                  <i data-feather="disc"></i>
                  <?php echo languageVariables("alertWebhookControlSuccess", "modules", $languageType); ?>
                </div>
              </div>
              <div id="connectAlertError" style="display: none;">
                <div class="alert alert-icon-danger" role="alert">
                  <i data-feather="x-circle"></i>
                  <?php echo languageVariables("alertWebhookControlFail", "modules", $languageType); ?>
                </div>
              </div>
              <div style="float: right;">
                <?php echo $safeCsrfToken->input("saveChangesToken"); ?>
                <button type="submit" class="btn btn-primary mr-2" name="saveChanges"><?php echo languageVariables("saveChanges", "words", $languageType); ?></button>
                <button type="button" class="btn btn-light" id="webhooksConnectControl"><?php echo languageVariables("control", "words", $languageType); ?></button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
</div>
  <?php } else if (get("target") == "news") { ?>
<div class="page-content">
  <nav class="page-breadcrumb">
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="<?php echo urlConverter("admin_home", $languageType); ?>"><?php echo languageVariables("dashboard", "words", $languageType); ?></a></li>
      <li class="breadcrumb-item"><a href="#"><?php echo languageVariables("modules", "words", $languageType); ?></a></li>
      <li class="breadcrumb-item"><a href="<?php echo urlConverter("admin_modules_webhook_news", $languageType); ?>"><?php echo languageVariables("webhooks", "words", $languageType); ?></a></li>
      <li class="breadcrumb-item active" aria-current="page"><?php echo languageVariables("news", "words", $languageType); ?></li>
    </ol>
  </nav>
  <div class="row">
    <div class="col-md-12 grid-margin stretch-card">
      <div class="card">
        <div class="card-body">
          <h6 class="card-title"><?php echo languageVariables("newsRelease", "words", $languageType); ?></h6>
          <?php
          require_once(__DR__."/main/includes/packages/class/csrf/class.php");
          $safeCsrfToken = new CSRF('csrf-sessions', 'csrf-token');
          if (isset($_POST["saveChanges"])) {
            if ($safeCsrfToken->validate('saveChangesToken')) {
              if (post("webhooksNewsStatus") == 0 || (post("webhooksNewsAPI") !== "" && post("webhooksNewsTitle") !== "" && post("webhooksNewsText") !== "")) {
                $newsImage = ((post("webhooksNewsImage") !== "") ? post("webhooksNewsImage") : "0");
                $saveChanges = $db->prepare("UPDATE webhooks SET webhookNewsStatus = ?, webhookNewsName = ?, webhookNewsImage = ?, webhookNewsAPI = ?, webhookNewsTitle = ?, webhookNewsDescription = ?, webhookNewsSignature = ? WHERE id = ?");
                $saveChanges->execute(array(post("webhooksNewsStatus"), post("webhooksNewsName"), $newsImage, post("webhooksNewsAPI"), post("webhooksNewsTitle"), $_POST["webhooksNewsText"], post("webhooksNewsSignature"), $readWebhooks["id"]));
                echo alert(languageVariables("alertSaveChanges", "modules", $languageType), "success", "2", "");
              } else {
                echo alert(languageVariables("alertNone", "modules", $languageType), "warning", "0", "/");
              }
            } else {
              echo alert(languageVariables("alertSystem", "modules", $languageType), "danger", "0", "/");
            }
          }
          ?>
            <form class="forms-sample" action="" method="POST" enctype="multipart/form-data">
              <input type="hidden" data-toggle="webhooksType" value="<?php echo get("target"); ?>">
              <div class="form-group row">
                <label for="modules-webhooks-news-status" class="col-sm-3 col-form-label"><?php echo languageVariables("webhookStatus", "modules", $languageType); ?></label>
                <div class="col-sm-9">
                  <select class="form-control" id="modules-webhooks-news-status" name="webhooksNewsStatus" webhooks="status">
                    <option value="0" <?php if ($readWebhooks["webhookNewsStatus"] == "0") { echo "selected"; } ?>><?php echo languageVariables("disable", "words", $languageType); ?></option>
                    <option value="1" <?php if ($readWebhooks["webhookNewsStatus"] == "1") { echo "selected"; } ?>><?php echo languageVariables("active", "words", $languageType); ?></option>
                  </select>
                </div>
              </div>
              <div webhooks="input" <?php if ($readWebhooks["webhookNewsStatus"] == "0") { echo "style=\"display: none;\""; } ?>>
                <div class="form-group row">
                  <label for="modules-webhooks-news-api" class="col-sm-3 col-form-label"><?php echo languageVariables("webhookUrl", "modules", $languageType); ?></label>
                  <div class="col-sm-9">
                    <input type="text" name="webhooksNewsAPI" id="modules-webhooks-news-api" placeholder="<?php echo languageVariables("webhookUrlPlaceholder", "modules", $languageType); ?>" class="form-control" value="<?php echo $readWebhooks["webhookNewsAPI"]; ?>" data-toggle="webhooksAPI" required>
                  </div>
                </div>
                <div class="form-group row">
                  <label for="modules-webhooks-news-name" class="col-sm-3 col-form-label"><?php echo languageVariables("webhookName", "modules", $languageType); ?></label>
                  <div class="col-sm-9">
                    <input type="text" name="webhooksNewsName" id="modules-webhooks-news-name" placeholder="<?php echo languageVariables("webhookNamePlaceholder", "modules", $languageType); ?>" class="form-control" value="<?php echo $readWebhooks["webhookNewsName"]; ?>" data-toggle="webhooksName" required>
                  </div>
                </div>
                <div class="form-group row">
                  <label for="modules-webhooks-news-image" class="col-sm-3 col-form-label"><?php echo languageVariables("webhookImageUrl", "modules", $languageType); ?></label>
                  <div class="col-sm-9">
                    <input type="text" name="webhooksNewsImage" id="modules-webhooks-news-image" placeholder="<?php echo languageVariables("webhookImageUrlPlaceholder", "modules", $languageType); ?>" class="form-control" value="<?php echo (($readWebhooks["webhookNewsImage"] == "0") ? "" : $readWebhooks["webhookNewsImage"]); ?>" data-toggle="webhooksImage" required>
                  </div>
                </div>
                <div class="form-group row">
                  <label for="modules-webhooks-news-title" class="col-sm-3 col-form-label"><?php echo languageVariables("webhookTitle", "modules", $languageType); ?></label>
                  <div class="col-sm-9">
                    <input type="text" name="webhooksNewsTitle" id="modules-webhooks-news-title" placeholder="<?php echo languageVariables("webhookTitlePlaceholder", "modules", $languageType); ?>" class="form-control" value="<?php echo $readWebhooks["webhookNewsTitle"]; ?>" data-toggle="webhooksTitle" required>
                  </div>
                </div>
                <div class="form-group row">
                  <label for="modules-webhooks-news-text" class="col-sm-3 col-form-label"><?php echo languageVariables("webhookContent", "modules", $languageType); ?></label>
                  <div class="col-sm-9">
                    <textarea name="webhooksNewsText" id="modules-webhooks-news-text" class="form-control" rows="6" data-toggle="webhooksContent"><?php echo $readWebhooks['webhookNewsDescription']; ?></textarea>
                    <small class="form-text text-muted">
                      <?php echo languageVariables("webhookNewsContentJoker0", "modules", $languageType); ?>
                    </small>
                    <small class="form-text text-muted">
                      <?php echo languageVariables("webhookNewsContentJoker1", "modules", $languageType); ?>
                    </small>
                    <small class="form-text text-muted">
                      <?php echo languageVariables("webhookNewsContentJoker2", "modules", $languageType); ?>
                    </small>
                  </div>
                </div>
                <div class="form-group row">
                  <label for="modules-webhooks-news-signature" class="col-sm-3 col-form-label"><?php echo languageVariables("webhookSignature", "modules", $languageType); ?></label>
                  <div class="col-sm-9">
                    <select class="form-control" id="modules-webhooks-news-signature" name="webhooksNewsSignature" data-toggle="webhooksSignature">
                      <option value="0" <?php if($readWebhooks['webhookNewsSignature'] == "0"){ echo 'selected'; } ?>><?php echo languageVariables("disable", "words", $languageType); ?></option>
                      <option value="1" <?php if($readWebhooks['webhookNewsSignature'] == "1"){ echo 'selected'; } ?>><?php echo languageVariables("active", "words", $languageType); ?></option>
                    </select>
                  </div>
                </div>
              </div>
              <div id="connectAlertSuccess" style="display: none;">
                <div class="alert alert-icon-success" role="alert">
                  <i data-feather="disc"></i>
                  <?php echo languageVariables("alertWebhookControlSuccess", "modules", $languageType); ?>
                </div>
              </div>
              <div id="connectAlertError" style="display: none;">
                <div class="alert alert-icon-danger" role="alert">
                  <i data-feather="x-circle"></i>
                  <?php echo languageVariables("alertWebhookControlFail", "modules", $languageType); ?>
                </div>
              </div>
              <div style="float: right;">
                <?php echo $safeCsrfToken->input("saveChangesToken"); ?>
                <button type="submit" class="btn btn-primary mr-2" name="saveChanges"><?php echo languageVariables("saveChanges", "words", $languageType); ?></button>
                <button type="button" class="btn btn-light" id="webhooksConnectControl"><?php echo languageVariables("control", "words", $languageType); ?></button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
</div>
  <?php } else if (get("target") == "comment") { ?>
<div class="page-content">
  <nav class="page-breadcrumb">
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="<?php echo urlConverter("admin_home", $languageType); ?>"><?php echo languageVariables("dashboard", "words", $languageType); ?></a></li>
      <li class="breadcrumb-item"><a href="#"><?php echo languageVariables("modules", "words", $languageType); ?></a></li>
      <li class="breadcrumb-item"><a href="<?php echo urlConverter("admin_modules_webhook_comment", $languageType); ?>"><?php echo languageVariables("webhooks", "words", $languageType); ?></a></li>
      <li class="breadcrumb-item active" aria-current="page"><?php echo languageVariables("comment", "words", $languageType); ?></li>
    </ol>
  </nav>
  <div class="row">
    <div class="col-md-12 grid-margin stretch-card">
      <div class="card">
        <div class="card-body">
          <h6 class="card-title"><?php echo languageVariables("comment", "words", $languageType); ?></h6>
          <?php
          require_once(__DR__."/main/includes/packages/class/csrf/class.php");
          $safeCsrfToken = new CSRF('csrf-sessions', 'csrf-token');
          if (isset($_POST["saveChanges"])) {
            if ($safeCsrfToken->validate('saveChangesToken')) {
              if (post("webhooksCommentStatus") == 0 || (post("webhooksCommentAPI") !== "" && post("webhooksCommentTitle") !== "" && post("webhooksCommentText") !== "")) {
                $commentImage = ((post("webhooksCommentImage") !== "") ? post("webhooksCommentImage") : "0");
                $saveChanges = $db->prepare("UPDATE webhooks SET webhookCommentStatus = ?, webhookCommentName = ?, webhookCommentImage = ?, webhookCommentAPI = ?, webhookCommentTitle = ?, webhookCommentDescription = ?, webhookCommentSignature = ? WHERE id = ?");
                $saveChanges->execute(array(post("webhooksCommentStatus"), post("webhooksCommentName"), $commentImage, post("webhooksCommentAPI"), post("webhooksCommentTitle"), $_POST["webhooksCommentText"], post("webhooksCommentSignature"), $readWebhooks["id"]));
                echo alert(languageVariables("alertSaveChanges", "modules", $languageType), "success", "2", "");
              } else {
                echo alert(languageVariables("alertNone", "modules", $languageType), "warning", "0", "/");
              }
            } else {
              echo alert(languageVariables("alertSystem", "modules", $languageType), "danger", "0", "/");
            }
          }
          ?>
           <form class="forms-sample" action="" method="POST" enctype="multipart/form-data">
              <input type="hidden" data-toggle="webhooksType" value="<?php echo get("target"); ?>">
              <div class="form-group row">
                <label for="modules-webhooks-comment-status" class="col-sm-3 col-form-label"><?php echo languageVariables("webhookStatus", "modules", $languageType); ?></label>
                <div class="col-sm-9">
                  <select class="form-control" id="modules-webhooks-comment-status" name="webhooksCommentStatus" webhooks="status">
                    <option value="0" <?php if ($readWebhooks["webhookCommentStatus"] == "0") { echo "selected"; } ?>><?php echo languageVariables("disable", "words", $languageType); ?></option>
                    <option value="1" <?php if ($readWebhooks["webhookCommentStatus"] == "1") { echo "selected"; } ?>><?php echo languageVariables("active", "words", $languageType); ?></option>
                  </select>
                </div>
              </div>
              <div webhooks="input" <?php if ($readWebhooks["webhookCommentStatus"] == "0") { echo "style=\"display: none;\""; } ?>>
                <div class="form-group row">
                  <label for="modules-webhooks-comment-api" class="col-sm-3 col-form-label"><?php echo languageVariables("webhookUrl", "modules", $languageType); ?></label>
                  <div class="col-sm-9">
                    <input type="text" name="webhooksCommentAPI" id="modules-webhooks-comment-api" placeholder="<?php echo languageVariables("webhookUrlPlaceholder", "modules", $languageType); ?>" class="form-control" value="<?php echo $readWebhooks["webhookCommentAPI"]; ?>" data-toggle="webhooksAPI" required>
                  </div>
                </div>
                <div class="form-group row">
                  <label for="modules-webhooks-comment-name" class="col-sm-3 col-form-label"><?php echo languageVariables("webhookName", "modules", $languageType); ?></label>
                  <div class="col-sm-9">
                    <input type="text" name="webhooksCommentName" id="modules-webhooks-comment-name" placeholder="<?php echo languageVariables("webhookNamePlaceholder", "modules", $languageType); ?>" class="form-control" value="<?php echo $readWebhooks["webhookCommentName"]; ?>" data-toggle="webhooksName" required>
                  </div>
                </div>
                <div class="form-group row">
                  <label for="modules-webhooks-comment-image" class="col-sm-3 col-form-label"><?php echo languageVariables("webhookImageUrl", "modules", $languageType); ?></label>
                  <div class="col-sm-9">
                    <input type="text" name="webhooksCommentImage" id="modules-webhooks-comment-image" placeholder="<?php echo languageVariables("webhookImageUrlPlaceholder", "modules", $languageType); ?>" class="form-control" value="<?php echo (($readWebhooks["webhookCommentImage"] == "0") ? "" : $readWebhooks["webhookCommentImage"]); ?>" data-toggle="webhooksImage" required>
                  </div>
                </div>
                <div class="form-group row">
                  <label for="modules-webhooks-comment-title" class="col-sm-3 col-form-label"><?php echo languageVariables("webhookTitle", "modules", $languageType); ?></label>
                  <div class="col-sm-9">
                    <input type="text" name="webhooksCommentTitle" id="modules-webhooks-comment-title" placeholder="<?php echo languageVariables("webhookTitlePlaceholder", "modules", $languageType); ?>" class="form-control" value="<?php echo $readWebhooks["webhookCommentTitle"]; ?>" data-toggle="webhooksTitle" required>
                  </div>
                </div>
                <div class="form-group row">
                  <label for="modules-webhooks-comment-text" class="col-sm-3 col-form-label"><?php echo languageVariables("webhookContent", "modules", $languageType); ?></label>
                  <div class="col-sm-9">
                    <textarea name="webhooksCommentText" id="modules-webhooks-comment-text" class="form-control" rows="6" data-toggle="webhooksContent"><?php echo $readWebhooks['webhookCommentDescription']; ?></textarea>
                    <small class="form-text text-muted">
                      <?php echo languageVariables("webhookCommentContentJoker0", "modules", $languageType); ?>
                    </small>
                    <small class="form-text text-muted">
                      <?php echo languageVariables("webhookCommentContentJoker1", "modules", $languageType); ?>
                    </small>
                  </div>
                </div>
                <div class="form-group row">
                  <label for="modules-webhooks-comment-signature" class="col-sm-3 col-form-label"><?php echo languageVariables("webhookSignature", "modules", $languageType); ?></label>
                  <div class="col-sm-9">
                    <select class="form-control" id="modules-webhooks-comment-signature" name="webhooksSupportSignature" data-toggle="webhooksSignature">
                      <option value="0" <?php if($readWebhooks['webhookCommentSignature'] == "0"){ echo 'selected'; } ?>><?php echo languageVariables("disable", "words", $languageType); ?></option>
                      <option value="1" <?php if($readWebhooks['webhookCommentSignature'] == "1"){ echo 'selected'; } ?>><?php echo languageVariables("active", "words", $languageType); ?></option>
                    </select>
                  </div>
                </div>
              </div>
              <div id="connectAlertSuccess" style="display: none;">
                <div class="alert alert-icon-success" role="alert">
                  <i data-feather="disc"></i>
                  <?php echo languageVariables("alertWebhookControlSuccess", "modules", $languageType); ?>
                </div>
              </div>
              <div id="connectAlertError" style="display: none;">
                <div class="alert alert-icon-danger" role="alert">
                  <i data-feather="x-circle"></i>
                  <?php echo languageVariables("alertWebhookControlFail", "modules", $languageType); ?>
                </div>
              </div>
              <div style="float: right;">
                <?php echo $safeCsrfToken->input("saveChangesToken"); ?>
                <button type="submit" class="btn btn-primary mr-2" name="saveChanges"><?php echo languageVariables("saveChanges", "words", $languageType); ?></button>
                <button type="button" class="btn btn-light" id="webhooksConnectControl"><?php echo languageVariables("control", "words", $languageType); ?></button>
              </div>
            </form>
        </div>
      </div>
    </div>
 </div>
</div>
  <?php } else if (get("target") == "support") { ?>
<div class="page-content">
  <nav class="page-breadcrumb">
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="<?php echo urlConverter("admin_home", $languageType); ?>"><?php echo languageVariables("dashboard", "words", $languageType); ?></a></li>
      <li class="breadcrumb-item"><a href="#"><?php echo languageVariables("modules", "words", $languageType); ?></a></li>
      <li class="breadcrumb-item"><a href="<?php echo urlConverter("admin_modules_webhook_support", $languageType); ?>"><?php echo languageVariables("webhooks", "words", $languageType); ?></a></li>
      <li class="breadcrumb-item active" aria-current="page"><?php echo languageVariables("support", "words", $languageType); ?></li>
    </ol>
  </nav>
  <div class="row">
    <div class="col-md-12 grid-margin stretch-card">
      <div class="card">
        <div class="card-body">
          <h6 class="card-title"><?php echo languageVariables("support", "words", $languageType); ?></h6>
          <?php
          require_once(__DR__."/main/includes/packages/class/csrf/class.php");
          $safeCsrfToken = new CSRF('csrf-sessions', 'csrf-token');
          if (isset($_POST["saveChanges"])) {
            if ($safeCsrfToken->validate('saveChangesToken')) {
              if (post("webhooksSupportStatus") == 0 || (post("webhooksSupportAPI") !== "" && post("webhooksSupportTitle") !== "" && post("webhooksSupportText") !== "")) {
                $supportImage = ((post("webhooksSupportImage") !== "") ? post("webhooksSupportImage") : "0");
                $saveChanges = $db->prepare("UPDATE webhooks SET webhookSupportStatus = ?, webhookSupportName = ?, webhookSupportImage = ?, webhookSupportAPI = ?, webhookSupportTitle = ?, webhookSupportDescription = ?, webhookSupportSignature = ? WHERE id = ?");
                $saveChanges->execute(array(post("webhooksSupportStatus"), post("webhooksSupportName"), $supportImage, post("webhooksSupportAPI"), post("webhooksSupportTitle"), $_POST["webhooksSupportText"], post("webhooksSupportSignature"), $readWebhooks["id"]));
                echo alert(languageVariables("alertSaveChanges", "modules", $languageType), "success", "2", "");
              } else {
                echo alert(languageVariables("alertNone", "modules", $languageType), "warning", "0", "/");
              }
            } else {
              echo alert(languageVariables("alertSystem", "modules", $languageType), "danger", "0", "/");
            }
          }
          ?>
           <form class="forms-sample" action="" method="POST" enctype="multipart/form-data">
              <input type="hidden" data-toggle="webhooksType" value="<?php echo get("target"); ?>">
              <div class="form-group row">
                <label for="modules-webhooks-support-status" class="col-sm-3 col-form-label"><?php echo languageVariables("webhookStatus", "modules", $languageType); ?></label>
                <div class="col-sm-9">
                  <select class="form-control" id="modules-webhooks-support-status" name="webhooksSupportStatus" webhooks="status">
                    <option value="0" <?php if ($readWebhooks["webhookSupportStatus"] == "0") { echo "selected"; } ?>><?php echo languageVariables("disable", "words", $languageType); ?></option>
                    <option value="1" <?php if ($readWebhooks["webhookSupportStatus"] == "1") { echo "selected"; } ?>><?php echo languageVariables("active", "words", $languageType); ?></option>
                  </select>
                </div>
              </div>
              <div webhooks="input" <?php if ($readWebhooks["webhookSupportStatus"] == "0") { echo "style=\"display: none;\""; } ?>>
                <div class="form-group row">
                  <label for="modules-webhooks-support-api" class="col-sm-3 col-form-label"><?php echo languageVariables("webhookUrl", "modules", $languageType); ?></label>
                  <div class="col-sm-9">
                    <input type="text" name="webhooksSupportAPI" id="modules-webhooks-support-api" placeholder="<?php echo languageVariables("webhookUrlPlaceholder", "modules", $languageType); ?>" class="form-control" value="<?php echo $readWebhooks["webhookSupportAPI"]; ?>" data-toggle="webhooksAPI" required>
                  </div>
                </div>
                <div class="form-group row">
                  <label for="modules-webhooks-support-name" class="col-sm-3 col-form-label"><?php echo languageVariables("webhookName", "modules", $languageType); ?></label>
                  <div class="col-sm-9">
                    <input type="text" name="webhooksSupportName" id="modules-webhooks-support-name" placeholder="<?php echo languageVariables("webhookNamePlaceholder", "modules", $languageType); ?>" class="form-control" value="<?php echo $readWebhooks["webhookSupportName"]; ?>" data-toggle="webhooksName" required>
                  </div>
                </div>
                <div class="form-group row">
                  <label for="modules-webhooks-support-image" class="col-sm-3 col-form-label"><?php echo languageVariables("webhookImageUrl", "modules", $languageType); ?></label>
                  <div class="col-sm-9">
                    <input type="text" name="webhooksSupportImage" id="modules-webhooks-support-image" placeholder="<?php echo languageVariables("webhookImageUrlPlaceholder", "modules", $languageType); ?>" class="form-control" value="<?php echo (($readWebhooks["webhookSupportImage"] == "0") ? "" : $readWebhooks["webhookSupportImage"]); ?>" data-toggle="webhooksImage" required>
                  </div>
                </div>
                <div class="form-group row">
                  <label for="modules-webhooks-support-title" class="col-sm-3 col-form-label"><?php echo languageVariables("webhookTitle", "modules", $languageType); ?></label>
                  <div class="col-sm-9">
                    <input type="text" name="webhooksSupportTitle" id="modules-webhooks-support-title" placeholder="<?php echo languageVariables("webhookTitlePlaceholder", "modules", $languageType); ?>" class="form-control" value="<?php echo $readWebhooks["webhookSupportTitle"]; ?>" data-toggle="webhooksTitle" required>
                  </div>
                </div>
                <div class="form-group row">
                  <label for="modules-webhooks-support-text" class="col-sm-3 col-form-label"><?php echo languageVariables("webhookContent", "modules", $languageType); ?></label>
                  <div class="col-sm-9">
                    <textarea name="webhooksSupportText" id="modules-webhooks-support-text" class="form-control" rows="6" data-toggle="webhooksContent"><?php echo $readWebhooks['webhookSupportDescription']; ?></textarea>
                    <small class="form-text text-muted">
                      <?php echo languageVariables("webhookSupportContentJoker0", "modules", $languageType); ?>
                    </small>
                    <small class="form-text text-muted">
                      <?php echo languageVariables("webhookSupportContentJoker1", "modules", $languageType); ?>
                    </small>
                    <small class="form-text text-muted">
                      <?php echo languageVariables("webhookSupportContentJoker2", "modules", $languageType); ?>
                    </small>
                  </div>
                </div>
                <div class="form-group row">
                  <label for="modules-webhooks-support-signature" class="col-sm-3 col-form-label"><?php echo languageVariables("webhookSignature", "modules", $languageType); ?></label>
                  <div class="col-sm-9">
                    <select class="form-control" id="modules-webhooks-support-signature" name="webhooksSupportSignature" data-toggle="webhooksSignature">
                      <option value="0" <?php if($readWebhooks['webhookSupportSignature'] == "0"){ echo 'selected'; } ?>><?php echo languageVariables("disable", "words", $languageType); ?></option>
                      <option value="1" <?php if($readWebhooks['webhookSupportSignature'] == "1"){ echo 'selected'; } ?>><?php echo languageVariables("active", "words", $languageType); ?></option>
                    </select>
                  </div>
                </div>
              </div>
              <div id="connectAlertSuccess" style="display: none;">
                <div class="alert alert-icon-success" role="alert">
                  <i data-feather="disc"></i>
                  <?php echo languageVariables("alertWebhookControlSuccess", "modules", $languageType); ?>
                </div>
              </div>
              <div id="connectAlertError" style="display: none;">
                <div class="alert alert-icon-danger" role="alert">
                  <i data-feather="x-circle"></i>
                  <?php echo languageVariables("alertWebhookControlFail", "modules", $languageType); ?>
                </div>
              </div>
              <div style="float: right;">
                <?php echo $safeCsrfToken->input("saveChangesToken"); ?>
                <button type="submit" class="btn btn-primary mr-2" name="saveChanges"><?php echo languageVariables("saveChanges", "words", $languageType); ?></button>
                <button type="button" class="btn btn-light" id="webhooksConnectControl"><?php echo languageVariables("control", "words", $languageType); ?></button>
              </div>
            </form>
        </div>
      </div>
    </div>
 </div>
</div>
  <?php } ?>
<?php } else if (get("action") == "images") { ?>
<?php if (AccountPermControl($readAccount["id"], "modules_image") == "PERMISSION_NOT_FOUND") { go(urlConverter("admin_perm_error", $languageType)); } ?>
  <?php if (get("target") == "create") { ?>
<div class="page-content">
  <nav class="page-breadcrumb">
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="<?php echo urlConverter("admin_home", $languageType); ?>"><?php echo languageVariables("dashboard", "words", $languageType); ?></a></li>
      <li class="breadcrumb-item"><a href="#"><?php echo languageVariables("modules", "words", $languageType); ?></a></li>
      <li class="breadcrumb-item"><a href="<?php echo urlConverter("admin_modules_image", $languageType); ?>"><?php echo languageVariables("images", "words", $languageType); ?></a></li>
      <li class="breadcrumb-item active" aria-current="page"><?php echo languageVariables("upload", "words", $languageType); ?></li>
    </ol>
  </nav>
  <div class="row">
    <div class="col-md-12 grid-margin stretch-card">
      <div class="card">
        <div class="card-body">
          <h6 class="card-title"><?php echo languageVariables("imageUpload", "words", $languageType); ?></h6>
          <?php
          require_once(__DR__."/main/includes/packages/class/csrf/class.php");
          $safeCsrfToken = new CSRF('csrf-sessions', 'csrf-token');
          if (isset($_POST["addImages"])) {
            if ($safeCsrfToken->validate('addImagesToken')) {
              if (post("imagesAddTitle") !== "") {
                if ($_FILES["imagesAddImage"]["size"] !== null) {
                  $imageUpload = imageUpload($_FILES["imagesAddImage"], "/assets/uploads/images/upload/");
                  if ($imageUpload !== false) {
                    $insertImages = $db->prepare("INSERT INTO uploadsImage (`title`, `image`, `imageName`, `date`) VALUES (?, ?, ?, ?)");
                    $insertImages->execute(array(post("imagesAddTitle"), "/assets/uploads/images/upload/".$imageUpload["name"], $imageUpload["name"], date("d.m.Y H:i:s")));
                    echo alert(languageVariables("alertImageUploadSuccess", "modules", $languageType), "success", "3", urlConverter("admin_modules_image", $languageType));
                  } else {
                    echo alert(languageVariables("alertImageUploadFail", "modules", $languageType), "danger", "0", "/");
                  }
                } else {
                  echo alert(languageVariables("alertImageNone", "modules", $languageType), "warning", "0", "/");
                }
              } else {
                echo alert(languageVariables("alertNone", "modules", $languageType), "warning", "0", "/");
              }
            } else {
              echo alert(languageVariables("alertSystem", "modules", $languageType), "danger", "0", "/");
            }
          }
          ?>
          <form class="forms-sample" action="" method="POST" enctype="multipart/form-data">
            <div class="form-group row">
              <label for="modules-images-title" class="col-sm-3 col-form-label"><?php echo languageVariables("imageUploadTitle", "modules", $languageType); ?></label>
              <div class="col-sm-9">
                <input type="text" class="form-control" id="modules-images-title" name="imagesAddTitle" placeholder="<?php echo languageVariables("imageUploadTitlePlaceholder", "modules", $languageType); ?>">
              </div>
            </div>
            <div class="form-group row">
              <label for="modules-images-image" class="col-sm-3 col-form-label"><?php echo languageVariables("imageUploadImage", "modules", $languageType); ?></label>
              <div class="col-sm-9">
                <div data-toggle="dropimage" class="dropimage">
                  <div class="di-thumbnail">
                    <img src="" alt="<?php echo languageVariables("preview", "words", $languageType); ?>">
                  </div>
                  <div class="di-select">
                    <label for="modules-images-image"><?php echo languageVariables("imageUploadImagePlaceholder", "modules", $languageType); ?></label>
                    <input type="file" id="modules-images-image" name="imagesAddImage" accept="image/*">
                  </div>
                </div>
              </div>
            </div>
            <div style="float: right;">
              <?php echo $safeCsrfToken->input("addImagesToken"); ?>
              <button type="submit" class="btn btn-primary mr-2" name="addImages"><?php echo languageVariables("upload", "words", $languageType); ?></button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
  <?php } else if (get("target") == "update") { ?>
    <?php 
      if (isset($_GET["pageNumber"])) {
        if (!is_numeric(get("pageNumber"))) {
          $_GET["pageNumber"] = 1;
        }
        $pageNumber = intval(get("pageNumber"));
      } else {
        $pageNumber = 1;
      }

      $pageSubCount = 50;
      $pageItemCount = pageItemCount("uploadsImage", $pageSubCount);

      if ($pageNumber > $pageItemCount) {
        $pageNumber = 1;
      }

      $queryPageItemCount = $pageNumber * $pageSubCount - $pageSubCount;
      $maxPageItemCount = 5;
    ?>
      <?php $searchUploadImages = $db->query("SELECT * FROM uploadsImage ORDER BY id DESC LIMIT $queryPageItemCount, $pageSubCount"); ?>
<div class="page-content">
  <div class="row">
    <div class="col">
      <nav class="page-breadcrumb">
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="<?php echo urlConverter("admin_home", $languageType); ?>"><?php echo languageVariables("dashboard", "words", $languageType); ?></a></li>
          <li class="breadcrumb-item"><a href="#"><?php echo languageVariables("modules", "words", $languageType); ?></a></li>
          <li class="breadcrumb-item"><a href="<?php echo urlConverter("admin_modules_image", $languageType); ?>"><?php echo languageVariables("images", "words", $languageType); ?></a></li>
          <li class="breadcrumb-item active" aria-current="page"><?php echo languageVariables("view", "words", $languageType); ?></li>
        </ol>
      </nav>
    </div>
    <div class="col-auto">
      <nav aria-label="Page navigation example" style="floatt: right;">
        <ul class="pagination">
          <li class="page-item <?php echo (($pageNumber == "1") ? "disabled" : ""); ?>"><a class="page-link" href="<?php echo urlConverter("admin_modules_image_p", $languageType)."/".($pageNumber-1); ?>"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-left"><polyline points="15 18 9 12 15 6"></polyline></svg></a></li>
          <?php 
            for ($i = $pageNumber - $maxPageItemCount; $i < $pageNumber + $maxPageItemCount + 1; $i++) {
					    if ($i > 0 && $i <= $pageItemCount) {
          ?>
          <li class="page-item <?php echo (($pageNumber == $i) ? "active" : ""); ?>"><a class="page-link" href="<?php echo urlConverter("admin_modules_image_p", $languageType)."/".$i; ?>"><?php echo $i; ?></a></li>
          <?php } } ?>
          <li class="page-item <?php echo (($pageItemCount == $pageNumber) ? "disabled" : ""); ?>"><a class="page-link" href="<?php echo urlConverter("admin_modules_image_p", $languageType)."/".($pageNumber+1); ?>"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-right"><polyline points="9 18 15 12 9 6"></polyline></svg></a></li>
        </ul>
      </nav>
    </div>
  </div>
  <div class="row">
    <div class="col-md-12">
    <?php if (mysqlCount($searchUploadImages) > 0) { ?>
      <div class="card" data-toggle="lists" data-lists-values='["imagesID", "imagesTitle", "imagesUrl", "imagesDate"]'>
        <div class="card-header">
          <div class="row align-items-center">
            <div class="col">
              <div class="row align-items-center">
                <div class="col-auto pr-0">
                  <span data-feather="search"></span>
                </div>
                <div class="col">
                  <input type="search" class="form-control search" style="border: 0; background: none;" name="search" placeholder="<?php echo languageVariables("search", "words", $languageType); ?>">
                </div>
              </div>
            </div>
            <div class="col-auto">
              <a class="btn btn-sm btn-primary" href="<?php echo urlConverter("admin_modules_image_upload", $languageType); ?>"><?php echo languageVariables("upload", "words", $languageType); ?></a>
            </div>
          </div>
        </div>
        <div class="card-body p-0">
          <div class="table-responsive">
            <table class="table table-hover">
              <thead>
                <tr>
                  <th class="text-center" style="width: 40px;"><a href="#" class="text-muted sort" data-sort="imagesID">#ID</a></th>
                  <th class="text-center"><a href="#" class="text-muted sort" data-sort="imagesTitle"><?php echo languageVariables("title", "words", $languageType); ?></a></th>
                  <th class="text-center"><a href="#" class="text-muted sort" data-sort="imagesUrl"><?php echo languageVariables("url", "words", $languageType); ?></a></th>
                  <th class="text-center"><a href="#" class="text-muted sort" data-sort="imagesDate"><?php echo languageVariables("date", "words", $languageType); ?></a></th>
                  <th class="text-right">&nbsp;</th>
                </tr>
              </thead>
              <tbody class="list">
              <?php
                if ((isset($_SERVER['HTTPS'])) && ($_SERVER['HTTPS'] != 'off')) {
                  $imagesUrl = 'https://'.$_SERVER['SERVER_NAME'];
                } else {
                  $imagesUrl = 'http://'.$_SERVER['SERVER_NAME'];
                }
              ?>
               <?php foreach ($searchUploadImages as $readUploadImages) { ?>
                <tr>
                  <td class="imagesID text-center" style="width: 40px;">#<?php echo $readUploadImages["id"]; ?></td>
                  <td class="imagesTitle text-center"><?php echo $readUploadImages["title"]; ?></td>
                  <td class="imagesUrl text-center"><?php echo $imagesUrl.$readUploadImages["image"]; ?></td>
                  <td class="imagesDate text-center"><?php echo checkTime($readUploadImages["date"]); ?></td>
                  <td class="text-right">
                    <button type="button" class="btn btn-danger btn-icon" style="border-radius: 250px;" confirm-element="confirm" confirm-text="<?php echo languageVariables("deleteAlert", "words", $languageType); ?>" direct-href="<?php echo urlConverter("admin_modules_image_delete", $languageType); ?>/<?php echo $readUploadImages["id"]; ?>" data-toggle="tooltip" data-placement="top" title="<?php echo languageVariables("remove", "words", $languageType); ?>"><i data-feather="trash-2"></i></button>
                  </td>
                </tr>
              <?php } ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    <?php } else { echo alert(languageVariables("alertPageNone", "modules", $languageType), "danger", "0", "/"); } ?>
    </div>
  </div>
</div>
  <?php } else if (get("target") == "remove" && isset($_GET["removeID"])) { ?>
    <?php 
      $searchImages = $db->prepare("SELECT * FROM uploadsImage WHERE id = ?");
      $searchImages->execute(array(get("removeID")));
      if (mysqlCount($searchImages) > 0) {
        $readImage = fetch($searchImages);
        unlink(__DR__."/assets/uploads/images/upload/".$readImage["imageName"]);
        $removeImageHistory = $db->prepare("DELETE FROM uploadsImage WHERE id = ?");
        $removeImageHistory->execute(array($readImage["id"]));
      }
      go(urlConverter("admin_modules_image", $languageType));
    ?>
  <?php } ?>
<?php } else if (get("action") == "backups") { ?>
<?php if (AccountPermControl($readAccount["id"], "modules_backups") == "PERMISSION_NOT_FOUND") { go(urlConverter("admin_perm_error", $languageType)); } ?>
  <?php if (get("target") == "create") { ?>
    <?php
    $backupCreate = "FAILED";
	  $backups = '[]';
	  require_once(__DR__."/backups/php/backups.php");
	  require_once(__DR__."/main/includes/packages/class/functions/backup.class.php");
	  $backups = json_decode($backups, true);
    $dateTime = time();
    $code = rand(1,1000000);
    mkdir(__DR__."/backups/files/".$dateTime."-".$code);
    $filebackupDirectory = __DR__."/backups/files/".$dateTime."-".$code."/BACKUP-FILE-".$code.".zip";
    $mysqlbackupDirectory = __DR__."/backups/files/".$dateTime."-".$code."/BACKUP-MYSQL-".$code.".sql";
	  mysqlTableBackup($db, array(), __DR__."/backups/files/".$dateTime."-".$code."/", "BACKUP-MYSQL-".$code.".sql");
	  $fileBackup = new FolderBackup();
    $folderBackup = $fileBackup->folder([
      'dir' => "../",
      'file' => __DR__."/backups/files/".$dateTime."-".$code."/BACKUP-FILE-".$code.".zip",
      'exclude' => ['backups']
    ]);
	  array_unshift($backups, array(
	    "time" => $dateTime,
		"code" => $code,
		"date" => date("d.m.Y H:i:s"),
		"directory" => "/backups/files/".$dateTime."-".$code,
		"fileDirectory" => "/backups/files/".$dateTime."-".$code."/BACKUP-FILE-".$code.".zip",
		"mysqlDirectory" => "/backups/files/".$dateTime."-".$code."/BACKUP-MYSQL-".$code.".sql",
		"creator" => $readAccount["username"]
	  ));
    $write = '<?php $backups = \''.json_encode($backups).'\'; ?>';
	
	  file_put_contents(__DR__."/backups/php/backups.php", $write);
	  $backupCreate = "SUCCESS";
    ?>
  <?php } else if (get("target") == "download" && isset($_GET["backupID"]) && isset($_GET["type"])) { ?>
    <?php
	  $backups = '[]';
	  require_once(__DR__."/backups/php/backups.php");
      foreach (json_decode($backups, true) as $readBackups) {
        if ($readBackups["code"] == get("backupID")) {
          go("/backups/php/download.php?apiKey=".$rSettings["apiKey"]."&path=".$readBackups["code"]."&type=".get("type"));
        }
      }
    ?>
  <?php } else if (get("target") == "install" && isset($_GET["backupID"])) { ?>
    <?php
      $backupInstall = "FAILED";
      $backups = '[]';
      require_once(__DR__."/backups/php/backups.php");
	  $searchOldSession = $db->prepare("SELECT * FROM accountLoginSessions");
      foreach (json_decode($backups, true) as $readBackups) {
        if ($readBackups["code"] = get("backupID")) {
            $filebackupDirectory = __DR__.$readBackups["fileDirectory"];
            $mysqlbackupDirectory = __DR__.$readBackups["mysqlDirectory"];
            $zipArchive = new ZipArchive;
            $zipResponse = $zipArchive->open(__DR__.$readBackups["fileDirectory"]);
            if ($zipResponse === TRUE) {
              $filesExtract = $zipArchive->extractTo(__DR__."/");
              $zipArchive->close();
              if ($filesExtract) {
                $mysqlBackupRestore = $db->exec(file_get_contents(__DR__.$readBackups["mysqlDirectory"]));
				foreach ($searchOldSession as $readOldSession) {
				  $insertSession = $db->prepare("INSERT INTO accountLoginSessions (`id`, `accountID`, `sessionToken`, `sessionIP`, `date`, `time`) VALUES (?, ?, ?, ?, ?, ?)");
				  $insertSession->execute(array($readOldSession["id"], $readOldSession["accountID"], $readOldSession["sessionToken"], $readOldSession["sessionIP"], $readOldSession["date"], $readOldSession["time"]));
				}
                $backupInstall = "SUCCESS";
              }
            }
        }
      }
    ?>
  <?php } else if (get("target") == "remove" && isset($_GET["removeID"])) { ?>
    <?php 
      $backupRemove = "FAILED";
      $numberBackup = 0;
      $backups = '[]';
	    require_once(__DR__."/backups/php/backups.php");
      foreach (json_decode($backups, true) as $readBackups) {
        if ($numberBackup == 0) {
          $backups = array();
        }
        $numberBackup += 1;
        if ($readBackups["code"] == get("removeID")) {
          unlink(__DR__.$readBackups["fileDirectory"]);
          unlink(__DR__.$readBackups["mysqlDirectory"]);
          rmdir(__DR__.$readBackups["directory"]);
        } else {
          array_push($backups, array(
            "time" => $readBackups["time"],
            "code" => $readBackups["code"],
            "date" => $readBackups["date"],
            "directory" => $readBackups["directory"],
            "fileDirectory" => $readBackups["fileDirectory"],
            "mysqlDirectory" => $readBackups["mysqlDirectory"],
            "creator" => $readBackups["creator"]
          ));
        }
      }
      $write = '<?php $backups = \''.json_encode($backups).'\'; ?>';
	
	  file_put_contents(__DR__."/backups/php/backups.php", $write);
      $backupRemove = "SUCCESS";
    ?>
  <?php } ?>
  <?php
    if (get("target") == "update") {
        $backups = '[]';
        require_once(__DR__."/backups/php/backups.php");
    }
  ?>
<div class="page-content">
  <div class="row">
    <div class="col">
      <nav class="page-breadcrumb">
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="<?php echo urlConverter("admin_home", $languageType); ?>"><?php echo languageVariables("dashboard", "words", $languageType); ?></a></li>
          <li class="breadcrumb-item"><a href="#"><?php echo languageVariables("modules", "words", $languageType); ?></a></li>
          <li class="breadcrumb-item"><a href="<?php echo urlConverter("admin_modules_backup", $languageType); ?>"><?php echo languageVariables("backups", "words", $languageType); ?></a></li>
          <li class="breadcrumb-item active" aria-current="page"><?php echo languageVariables("view", "words", $languageType); ?></li>
        </ol>
      </nav>
    </div>
	<?php if ($backups == "[]") { ?>
    <div class="col-auto">
      <button type="button" class="btn btn-sm btn-primary" confirm-element="confirm" confirm-text="<?php echo "Bir yedek oluşturmak istediğinize emin misiniz?"; ?>" direct-href="<?php echo urlConverter("admin_modules_backup_create", $languageType); ?>"><?php echo languageVariables("create", "words", $languageType); ?></button>
    </div>
	<?php } ?>
  </div>
  <div class="row">
    <div class="col-md-12">
    <?php
      if ($backupRemove == "SUCCESS") {
        echo alert(languageVariables("backupRemoveSuccess", "modules", $languageType), "success", "2", urlConverter("admin_modules_backup", $languageType));
      }
      if ($backupInstall == "SUCCESS") {
        echo alert(languageVariables("backupInstallSuccess", "modules", $languageType), "success", "2", urlConverter("admin_modules_backup", $languageType));
      } else if ($backupInstall == "FAILED") {
        echo alert(languageVariables("backupInstallFailed", "modules", $languageType), "danger", "2", urlConverter("admin_modules_backup", $languageType));
      }
      if ($backupCreate == "SUCCESS") {
        echo alert(languageVariables("backupCreateSuccess", "modules", $languageType), "success", "2", urlConverter("admin_modules_backup", $languageType));
      }
    ?>
    <?php if ($backups !== "[]") { ?>
      <div class="card" data-toggle="lists" data-lists-values='["backupCreator", "backupCode", "backupDate"]'>
        <div class="card-header">
          <div class="row align-items-center">
            <div class="col">
              <div class="row align-items-center">
                <div class="col-auto pr-0">
                  <span data-feather="search"></span>
                </div>
                <div class="col">
                  <input type="search" class="form-control search" style="border: 0; background: none;" name="search" placeholder="<?php echo languageVariables("search", "words", $languageType); ?>">
                </div>
              </div>
            </div>
            <div class="col-auto">
              <button type="button" class="btn btn-sm btn-primary" confirm-element="confirm" confirm-text="<?php echo "Bir yedek oluşturmak istediğinize emin misiniz?"; ?>" direct-href="<?php echo urlConverter("admin_modules_backup_create", $languageType); ?>"><?php echo languageVariables("create", "words", $languageType); ?></button>
            </div>
          </div>
        </div>
        <div class="card-body p-0">
          <div class="table-responsive">
            <table class="table table-hover">
              <thead>
                <tr>
                  <th class="text-center"><a href="#" class="text-muted sort" data-sort="backupCode">#ID</a></th>
                  <th class="text-center"><a href="#" class="text-muted sort" data-sort="backupDate"><?php echo languageVariables("date", "words", $languageType); ?></a></th>
                  <th class="text-center"><a href="#" class="text-muted sort" data-sort="backupCreator"><?php echo languageVariables("author", "words", $languageType); ?></a></th>
                  <th class="text-center"><a href="#" class="text-muted sort" data-sort="backupFolder"><?php echo languageVariables("folder", "words", $languageType); ?></a></th>
                  <th class="text-center"><a href="#" class="text-muted sort" data-sort="backupMySQL"><?php echo languageVariables("mysql", "words", $languageType); ?></a></th>
                  <th class="text-right">&nbsp;</th>
                </tr>
              </thead>
              <tbody class="list">
              <?php foreach (json_decode($backups, true) as $readBackup) { ?>
                <tr>
                  <td class="backupCode text-center"><?php echo $readBackup["code"]; ?></td>
                  <td class="backupDate text-center"><?php echo checkTime($readBackup["date"], 2, true); ?></td>
                  <td class="backupCreator text-center"><?php echo $readBackup["creator"]; ?></td>
                  <td class="backupFolder text-center"><?php echo number_format((filesize(__DR__."/".$readBackup["fileDirectory"])/1000000), 2)."MB"; ?></td>
                  <td class="backupMySQL text-center"><?php echo number_format((filesize(__DR__."/".$readBackup["mysqlDirectory"])/1000000), 2)."MB"; ?></td>
                  <td class="text-right">
                    <button type="button" class="btn btn-success btn-icon" style="border-radius: 250px;" confirm-element="confirm" confirm-text="<?php echo languageVariables("backupRestore", "words", $languageType); ?>" direct-href="<?php echo urlConverter("admin_modules_backup_install", $languageType); ?>/<?php echo $readBackup["code"]; ?>" data-toggle="tooltip" data-placement="top" title="<?php echo languageVariables("restore", "words", $languageType); ?>"><i data-feather="rotate-cw"></i></button>
                    <button type="button" class="btn btn-info btn-icon" style="border-radius: 250px;" confirm-element="confirm" confirm-text="<?php echo languageVariables("backupFolderDownload", "words", $languageType); ?>" direct-href="<?php echo urlConverter("admin_modules_backup_download", $languageType); ?>/<?php echo $readBackup["code"]; ?>/0" data-toggle="tooltip" data-placement="top" title="<?php echo languageVariables("folder", "words", $languageType); ?>"><i data-feather="folder"></i></button>
                    <button type="button" class="btn btn-info btn-icon" style="border-radius: 250px;" confirm-element="confirm" confirm-text="<?php echo languageVariables("backupMySQLDownload", "words", $languageType); ?>" direct-href="<?php echo urlConverter("admin_modules_backup_download", $languageType); ?>/<?php echo $readBackup["code"]; ?>/1" data-toggle="tooltip" data-placement="top" title="<?php echo languageVariables("mysql", "words", $languageType); ?>"><i data-feather="layers"></i></button>
                    <button type="button" class="btn btn-danger btn-icon" style="border-radius: 250px;" confirm-element="confirm" confirm-text="<?php echo languageVariables("deleteAlert", "words", $languageType); ?>" direct-href="<?php echo urlConverter("admin_modules_backup_delete", $languageType); ?>/<?php echo $readBackup["code"]; ?>" data-toggle="tooltip" data-placement="top" title="<?php echo languageVariables("remove", "words", $languageType); ?>"><i data-feather="trash-2"></i></button>
                  </td>
                </tr>
              <?php } ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>
      <?php } else { echo alert(languageVariables("alertPageNone", "modules", $languageType), "danger", "0", "/"); } ?>
    </div>
  </div>
</div>
<?php } else if (get("action") == "module") { ?>
<?php if (AccountPermControl($readAccount["id"], "modules_module") == "PERMISSION_NOT_FOUND") { go(urlConverter("admin_perm_error", $languageType)); } ?>
<div class="page-content">
  <nav class="page-breadcrumb">
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="<?php echo urlConverter("admin_home", $languageType); ?>"><?php echo languageVariables("dashboard", "words", $languageType); ?></a></li>
      <li class="breadcrumb-item"><a href="#"><?php echo languageVariables("modules", "words", $languageType); ?></a></li>
      <li class="breadcrumb-item"><a href="<?php echo urlConverter("admin_modules_module_uplaod", $languageType); ?>"><?php echo languageVariables("module", "words", $languageType); ?></a></li>
      <li class="breadcrumb-item active" aria-current="page"><?php echo languageVariables("upload", "words", $languageType); ?></li>
    </ol>
  </nav>
  <div class="row">
    <div class="col-md-12 grid-margin stretch-card">
      <div class="card">
        <div class="card-body">
          <h6 class="card-title"><?php echo languageVariables("upload", "words", $languageType); ?></h6>
          <?php
          require_once(__DR__."/main/includes/packages/class/csrf/class.php");
          $safeCsrfToken = new CSRF('csrf-sessions', 'csrf-token');
          if (isset($_POST["uploadModule"])) {
            if ($safeCsrfToken->validate('uploadModuleToken')) {
              if ($_FILES["moduleFile"]["size"] !== null) {
                $moduleFileName = $_FILES['moduleFile']['name'];
                $moduleFileSize = $_FILES['moduleFile']['size'];
                $moduleFileTmpName  = $_FILES['moduleFile']['tmp_name'];
                $moduleFileType = $_FILES['moduleFile']['type'];
                $moduleFileExtension = strtolower(end(explode('.',$moduleFileName)));
                $filesName = rand(1,10000000) . "-" . createSlug(basename($moduleFileName));
                $directory = __DR__ . "/modules/files/" . $filesName;

                if ($moduleFileExtension == "zip") {
                  if (15000000 > $moduleFileSize) {
                    $fileUpload = move_uploaded_file($moduleFileTmpName, $directory);
                    if ($fileUpload) {
                      $zipArchive = new ZipArchive;
                      $zipResponse = $zipArchive->open(__DR__."/modules/files/".$filesName);
                      if ($zipResponse === TRUE) {
                        $filesExtract = $zipArchive->extractTo(__DR__."/");
                        $zipArchive->close();
                        if ($filesExtract) {
                          include(__DR__."/modules/php/functions.php");
                          echo alert(languageVariables("alertModuleUploadSuccess", "modules", $languageType), "success", "2", urlConverter("admin_modules_module_upload", $languageType));
                          unlink(__DR__."/modules/files/".$filesName);
                        } else {
                          echo alert(languageVariables("alertThemeAddFileExtractError", "modules", $languageType), "danger", "0", "/");
                          unlink(__DR__."/modules/files/".$filesName);
                        }
                      } else {
                        echo alert(languageVariables("alertThemeAddFileExtractError", "modules", $languageType)." (CODE: ZIP)", "danger", "0", "/");
                        unlink(__DR__."/modules/files/".$filesName);
                      }
                    } else {
                      echo alert(languageVariables("alertThemeAddFileExtractError", "modules", $languageType)." (CODE: UPLOAD)", "danger", "0", "/");
                    }
                  } else {
                    echo alert(languageVariables("alertThemeAddFileExtractError", "modules", $languageType)." (CODE: SIZE)", "danger", "0", "/");
                  }
                } else {
                  echo alert(languageVariables("alertThemeAddFileExtractError", "modules", $languageType)." (CODE: EXTENSION)", "danger", "0", "/");
                }
              } else {
                echo alert(languageVariables("alertFileNone", "modules", $languageType), "danger", "0", "/");
              }
            } else {
              echo alert(languageVariables("alertSystem", "modules", $languageType), "danger", "0", "/");
            }
          }
          ?>
          <form class="forms-sample" action="" method="POST" enctype="multipart/form-data">
            <div class="form-group row">
              <label for="modules-module-file" class="col-sm-3 col-form-label"><?php echo languageVariables("moduleFile", "words", $languageType); ?> (ZIP):</label>
              <div class="col-sm-9">
                <input type="file" class="form-control" id="modules-module-file" name="moduleFile">
              </div>
            </div>
            <div style="float: right;">
              <?php echo $safeCsrfToken->input("uploadModuleToken"); ?>
              <button type="submit" class="btn btn-primary mr-2" name="uploadModule"><?php echo languageVariables("upload", "words", $languageType); ?></button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
<?php } else if (get("action") == "lottery") { ?>
<?php if (AccountPermControl($readAccount["id"], "modules") == "PERMISSION_NOT_FOUND") { go(urlConverter("admin_perm_error", $languageType)); } ?>
<?php
  $searchLottery = $db->query("SELECT * FROM lotterySettings ORDER BY id DESC LIMIT 1");
  $readLottery = $searchLottery->fetch();
  if ($readLottery["status"] == "1") {
    if (date("Y-m-d H:i:s") > $readLottery["starterDate"]) {
      $searchLotteryJoins = $db->prepare("SELECT * FROM lotteryJoins WHERE lotteryPass = ?");
      $searchLotteryJoins->execute(array($readLottery["lotteryPass"]));
      $lotteryJoins = "FALSE";
      if ($searchLotteryJoins->rowCount() > 0) {
        $lotteryJoins = "TRUE";
        $lotteryJoinsCount = $searchLotteryJoins->rowCount();
        $searchLotteryTickets = $db->prepare("SELECT SUM(tickets) AS tickets FROM lotteryJoins WHERE lotteryPass = ?");
        $searchLotteryTickets->execute(array($readLottery["lotteryPass"]));
        $readTotalTickets = $searchLotteryTickets->fetch();
        if ($readTotalTickets["tickets"] == null) {
          $readTotalTickets["tickets"] = 0;
        }
        $totalTickets = $readTotalTickets["tickets"];
      }
    }
  }
?>
  <?php if (get("target") == "update") { ?>
<div class="page-content">
  <nav class="page-breadcrumb">
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="<?php echo urlConverter("admin_home", $languageType); ?>"><?php echo languageVariables("dashboard", "words", $languageType); ?></a></li>
      <li class="breadcrumb-item"><a href="#"><?php echo languageVariables("modules", "words", $languageType); ?></a></li>
      <li class="breadcrumb-item"><a href="<?php echo urlConverter("admin_modules_lottery", $languageType); ?>"><?php echo languageVariables("lottery", "words", $languageType); ?></a></li>
      <li class="breadcrumb-item active" aria-current="page"><?php echo languageVariables("edit", "words", $languageType); ?></li>
    </ol>
  </nav>
  <div class="row">
    <div class="col-md-12 grid-margin stretch-card">
      <div class="card">
        <div class="card-body">
          <h6 class="card-title"><?php echo languageVariables("lottery", "words", $languageType); ?></h6>
          <?php
          require_once(__DR__."/main/includes/packages/class/csrf/class.php");
          $safeCsrfToken = new CSRF('csrf-sessions', 'csrf-token');
          if (isset($_POST["lotteryEdit"])) {
            if ($safeCsrfToken->validate('lotteryToken')) {
              if (post("lotteryStatus") == "0" || (post("lotteryStatus") == "1" && post("lotteryTicketPrice") !== "" && post("lotteryComission") !== "" && post("lotteryStartDate") !== "" && post("lotteryEndDate") !== "")) {
                if (post("lotteryStatus") == "1") {
                  if (post("lotteryExtraGifts") == "1") {
                    $extraGift = array();
                    foreach ($_POST['couponItemRewards'] as $key => $value) {
                      array_push($extraGift, array(
                        "type" => $_POST['couponItemTypes'][$key],
                        "reward" => $_POST['couponItemRewards'][$key]
                      ));
                    }
                    $extraGift = json_encode($extraGift);
                  } else {
                    $extraGift = "[]";
                  }
                  $updateLotterySettings = $db->prepare("UPDATE lotterySettings SET status = ?, ticketPrice = ?, comission = ?, starterDate = ?, endDate = ?, extraGiftStatus = ?, extraGift = ?");
                  $updateLotterySettings->execute(array(post("lotteryStatus"), post("lotteryTicketPrice"), post("lotteryComission"), post("lotteryStartDate"), post("lotteryEndDate"), post("lotteryExtraGifts"), $extraGift));
                  echo alert(languageVariables("lotterySaveChanges", "modules", $languageType), "success", "2", "");
                } else {
                  $updateLotterySettings = $db->prepare("UPDATE lotterySettings SET status = ?");
                  $updateLotterySettings->execute(array(0));
                  echo alert(languageVariables("lotterySaveChanges", "modules", $languageType), "success", "2", "");
                }
              } else {
                echo alert(languageVariables("alertNone", "modules", $languageType), "warning", "0", "/");
              }
            } else {
              echo alert(languageVariables("alertSystem", "modules", $languageType), "danger", "0", "/");
            }
          }
          if (isset($_POST["lotteryStart"])) {
            if ($safeCsrfToken->validate('lotteryToken')) {
              if (post("lotteryStatus") == "0" || (post("lotteryStatus") == "1" && post("lotteryTicketPrice") !== "" && post("lotteryComission") !== "" && post("lotteryStartDate") !== "" && post("lotteryEndDate") !== "")) {
                if (post("lotteryStatus") == "1") {
                  if (post("lotteryExtraGifts") == "1") {
                    $extraGift = array();
                    foreach ($_POST['couponItemRewards'] as $key => $value) {
                      array_push($extraGift, array(
                        "type" => $_POST['couponItemTypes'][$key],
                        "reward" => $_POST['couponItemRewards'][$key]
                      ));
                    }
                    $extraGift = json_encode($extraGift);
                  } else {
                    $extraGift = "[]";
                  }
                  $updateLotterySettings = $db->prepare("UPDATE lotterySettings SET status = ?, ticketPrice = ?, comission = ?, starterDate = ?, endDate = ?, extraGiftStatus = ?, extraGift = ?, lotteryPass = ?");
                  $updateLotterySettings->execute(array(post("lotteryStatus"), post("lotteryTicketPrice"), post("lotteryComission"), post("lotteryStartDate"), post("lotteryEndDate"), post("lotteryExtraGifts"), $extraGift, md5(post("lotteryStartDate").post("lotteryEndDate"))));
                  echo alert(languageVariables("lotteryRestart", "modules", $languageType), "success", "2", "");
                } else {
                  $updateLotterySettings = $db->prepare("UPDATE lotterySettings SET status = ?, lotteryPass = ?");
                  $updateLotterySettings->execute(array(0, md5(date("Y-m-d H:i:s").date("Y-m-d H:i:s"))));
                  echo alert(languageVariables("lotteryRestart", "modules", $languageType), "success", "2", "");
                }
              } else {
                echo alert(languageVariables("alertNone", "modules", $languageType), "warning", "0", "/");
              }
            } else {
              echo alert(languageVariables("alertSystem", "modules", $languageType), "danger", "0", "/");
            }
          }
          ?>
          <form class="forms-sample" action="" method="POST" enctype="multipart/form-data">
            <div class="form-group row">
              <label for="modules-lottery-status" class="col-sm-3 col-form-label"><?php echo languageVariables("lotteryStatusTitle", "modules", $languageType); ?></label>
              <div class="col-sm-9">
                <select class="form-control" id="modules-lottery-status" name="lotteryStatus" data-toggle="lotteryStatus">
                  <option value="0" <?php echo (($readLottery["status"] == "0") ? "selected" : ""); ?>><?php echo languageVariables("disable", "words", $languageType); ?></option>
                  <option value="1" <?php echo (($readLottery["status"] == "1") ? "selected" : ""); ?>><?php echo languageVariables("active", "words", $languageType); ?></option>
                </select>
              </div>
            </div>
            <div style="display: <?php echo (($readLottery["status"] == "0") ? "none" : "block"); ?>;" data-toggle="lotteryStatusInput">
              <div class="form-group row">
                <label for="modules-lottery-ticket-price" class="col-sm-3 col-form-label"><?php echo languageVariables("lotteryTicketPrice", "modules", $languageType); ?></label>
                <div class="col-sm-9">
                  <div class="input-group input-group-merge">
                    <div class="input-group-prepend">
                      <div class="input-group-text">
                        <span class="fa fa-dollar-sign"></span>
                      </div>
                    </div>
                    <input type="number" class="form-control" id="modules-lottery-ticket-price" name="lotteryTicketPrice" placeholder="<?php echo languageVariables("lotteryTicketPricePlaceholder", "modules", $languageType); ?>" value="<?php echo (($readLottery["status"] == "1") ? $readLottery["ticketPrice"] : ""); ?>">
                  </div>
                  <small><?php echo languageVariables("lotteryTicketPriceSmall", "modules", $languageType); ?></small>
                </div>
              </div>
              <div class="form-group row">
                <label for="modules-lottery-comission" class="col-sm-3 col-form-label"><?php echo languageVariables("lotteryComission", "modules", $languageType); ?></label>
                <div class="col-sm-9">
                  <div class="input-group input-group-merge">
                    <div class="input-group-prepend">
                      <div class="input-group-text">
                        <span class="fa fa-percent"></span>
                      </div>
                    </div>
                    <input type="number" class="form-control" id="modules-lottery-comission" name="lotteryComission" placeholder="<?php echo languageVariables("lotteryTicketPricePlaceholder", "modules", $languageType); ?>" value="<?php echo (($readLottery["status"] == "1") ? $readLottery["comission"] : ""); ?>">
                  </div>
                  <small><?php echo languageVariables("lotteryComissionSmall", "modules", $languageType); ?></small>
                </div>
              </div>
              <div class="form-group row">
                <label for="modules-lottery-start-date" class="col-sm-3 col-form-label"><?php echo languageVariables("lotteryStartDate", "modules", $languageType); ?></label>
                <div class="col-sm-9">
                  <input type="datetime-local" min="<?php echo (($readLottery["status"] == "1") ? $readLottery["starterDate"] : date("Y-m-d")."T".date("H:i")); ?>" value="<?php echo (($readLottery["status"] == "1") ? $readLottery["starterDate"] : date("Y-m-d")."T".date("H:i")); ?>" class="form-control" id="modules-lottery-start-date" name="lotteryStartDate" placeholder="<?php echo languageVariables("lotteryDateEnter", "modules", $languageType); ?>">
                </div>
              </div>
              <div class="form-group row">
                <label for="modules-lottery-end-date" class="col-sm-3 col-form-label"><?php echo languageVariables("lotteryEndDate", "modules", $languageType); ?></label>
                <div class="col-sm-9">
                  <input type="datetime-local" min="<?php echo (($readLottery["status"] == "1") ? $readLottery["starterDate"] : date("Y-m-d")."T".date("H:i")); ?>" value="<?php echo (($readLottery["status"] == "1") ? $readLottery["endDate"] : date("Y-m-d")."T".date("H:i")); ?>" class="form-control" id="modules-lottery-end-date" name="lotteryEndDate" placeholder="<?php echo languageVariables("lotteryDateEnter", "modules", $languageType); ?>">
                </div>
              </div>
              <div class="form-group row">
                <label for="modules-lottery-extra-rewards-status" class="col-sm-3 col-form-label"><?php echo languageVariables("lotteryExtraGift", "modules", $languageType); ?></label>
                <div class="col-sm-9">
                  <select class="form-control" id="modules-lottery-extra-rewards-status" name="lotteryExtraGifts" data-toggle="lotteryExtraGifts">
                    <option value="0" <?php echo (($readLottery["extraGiftStatus"] == "0") ? "selected" : ""); ?>><?php echo languageVariables("disable", "words", $languageType); ?></option>
                    <option value="1" <?php echo (($readLottery["extraGiftStatus"] == "1") ? "selected" : ""); ?>><?php echo languageVariables("active", "words", $languageType); ?></option>
                  </select>
                </div>
              </div>
              <div style="display: <?php echo (($readLottery["extraGiftStatus"] == "0") ? "none" : "block"); ?>;" data-toggle="lotteryExtraGiftsInput">
                <div class="form-group row">
                  <label for="modules-lottery-extra-rewards" class="col-sm-3 col-form-label"><?php echo languageVariables("lotteryGifts", "modules", $languageType); ?></label>
                  <div class="col-sm-9">
                    <div class="table-responsive">
                      <table class="table table-sm table-hover table-nowrap array-table">
                        <thead>
                          <tr>
                            <th class="text-center align-middle"><?php echo languageVariables("giftCouponRewardType", "modules", $languageType); ?></th>
                            <th class="text-center align-middle"><?php echo languageVariables("giftCouponReward", "modules", $languageType); ?></th>
                            <th class="text-center align-middle">
                              <button type="button" class="btn btn-primary btn-icon" add-item="credit" item-type="coupon">
                                <i data-feather="plus-square"></i>
                              </button>
                              <button type="button" class="btn btn-danger btn-icon ml-2" add-item="product" item-type="coupon">
                                <i data-feather="gift"></i>
                              </button>
                            </th>
                          </tr>
                        </thead>
                        <tbody data-toggle="itemTable">
                          <?php if ($readLottery["status"] == "1" && $readLottery["extraGift"] !== "[]" && $readLottery["extraGiftStatus"] == "1") { ?>
                            <?php $giftID = 0; ?>
                            <?php $searchLotteryGift = json_decode($readLottery["extraGift"], true); ?>
                            <?php foreach ($searchLotteryGift as $readLotteryGift) { ?>
                            <?php $giftID += 1; ?>
                            <?php $readLotteryGift["id"] = $giftID; ?>
                            <?php if ($readLotteryGift["type"] == "0") { ?>
                            <tr id="removeID-<?php echo $readLotteryGift["id"]; ?>">
                              <td class="ml-2">
                                <div class="input-group">
                                  <input type="hidden" name="couponItemTypes[]" value="0">
                                  <input type="text" class="form-control" placeholder="<?php echo languageVariables("giftCouponRewardType", "modules", $languageType); ?>" value="<?php echo languageVariables("credit", "words", $languageType); ?>" readonly>
                                </div>
                              </td>
                              <td class="text-center align-middle">
                                <div class="input-group input-group-merge">
                                  <div class="input-group-prepend"> 
                                    <div class="input-group-text"> 
                                      <span class="fa fa-lira-sign"></span>
                                    </div>
                                  </div>
                                  <input type="text" class="form-control form-control-prepended" name="couponItemRewards[]" placeholder="<?php echo languageVariables("modulesRewardAmount", "modules", $languageType); ?>" value="<?php echo $readLotteryGift["reward"]; ?>">
                                </div>
                              </td>
                              <td class="text-center align-middle">
                                <button type="button" class="btn btn-danger btn-icon" remove-item="button" remove-id="<?php echo $readLotteryGift["id"]; ?>">
                                  <span class="far fa-trash-alt"></span>
                                </button>
                              </td>
                            </tr>
                            <?php } else { ?>
                            <tr id="removeID-<?php echo $readLotteryGift["id"]; ?>">
                              <td class="ml-2">
                                <div class="input-group">
                                  <input type="hidden" name="couponItemTypes[]" value="1">
                                  <input type="text" class="form-control" placeholder="<?php echo languageVariables("giftCouponRewardType", "modules", $languageType); ?>" value="<?php echo languageVariables("product", "words", $languageType); ?>" readonly>
                                </div>
                              </td>
                              <td class="text-center align-middle">
                                <div class="form-group row">
                                  <div class="col-sm-12">
                                    <select class="form-control" name="couponItemRewards[]">
                                      <?php $searchServers = $db->query("SELECT * FROM serverList ORDER BY id ASC"); ?>
                                      <?php if (mysqlCount($searchServers) > 0): ?>
                                        <?php foreach ($searchServers as $readServer): ?>
                                          <?php
                                            $searchCategories = $db->prepare("SELECT * FROM serverCategory WHERE serverID = ? ORDER BY id ASC");
                                            $searchCategories->execute(array($readServer["id"]));
                                          ?>
                                          <?php if (mysqlCount($searchCategories) > 0): ?>
                                            <?php foreach ($searchCategories as $readCategory): ?>
                                              <?php echo "<optgroup label=\"".$readServer["name"]." - ".$readCategory["name"]."\">"; ?>
                                              <?php
                                                $searchProducts = $db->prepare("SELECT * FROM categoryProduct WHERE categoryID = ? ORDER BY id ASC");
                                                $searchProducts->execute(array($readCategory["id"]));
                                              ?>
                                              <?php if (mysqlCount($searchProducts) > 0): ?>
                                                <?php foreach ($searchProducts as $readProduct): ?>
                                                  <?php if ($readLotteryGift["reward"] == $readProduct["id"]): ?>
                                                    <?php echo "<option value=\"".$readProduct["id"]."\" selected>".$readProduct["name"]."</option>"; ?>
                                                  <?php else: ?>
                                                    <?php echo "<option value=\"".$readProduct["id"]."\">".$readProduct["name"]."</option>"; ?>
                                                  <?php endif; ?>
                                                <?php endforeach; ?>
                                              <?php endif; ?>
                                              <?php echo "</optgroup>"; ?>
                                            <?php endforeach; ?>
                                          <?php endif; ?>
                                        <?php endforeach; ?>
                                      <?php else: ?>
                                        <?php echo "<option value=\"0\">".languageVariables("ajaxNotServerAlert", "modules", $languageType)."</option>"; ?>
                                      <?php endif; ?>
                                    </select>
                                  </div>
                                </div>
                              </td>
                              <td class="text-center align-middle">
                                <button type="button" class="btn btn-danger btn-icon" remove-item="button" remove-id="<?php echo $readLotteryGift["id"]; ?>">
                                  <span class="far fa-trash-alt"></span>
                                </button>
                              </td>
                            </tr>
                            <?php } ?>
                          <?php } ?>
                          <?php } ?>
                        </tbody>
                      </table>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div style="float: right;">
              <?php echo $safeCsrfToken->input("lotteryToken"); ?>
              <button type="submit" class="btn btn-success mr-2" name="lotteryEdit"><?php echo languageVariables("edit", "words", $languageType); ?></button>
              <button type="submit" onclick="return confirm('<?php echo languageVariables("lotteryRestartAlert", "modules", $languageType); ?>');" class="btn btn-primary mr-2" name="lotteryStart"><?php echo languageVariables("restart", "words", $languageType); ?></button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
  <?php } else if (get("target") == "history") { ?>
    <?php
      if (isset($_GET["id"])) {
        $removeJoin = $db->prepare("DELETE FROM lotteryJoins WHERE id = ?");
        $removeJoin->execute(array(get("id")));
        go(urlConverter("admin_modules_lottery_history", $languageType));
      }
    ?>
    <?php 
      if (isset($_GET["pageNumber"])) {
        if (!is_numeric(get("pageNumber"))) {
          $_GET["pageNumber"] = 1;
        }
        $pageNumber = intval(get("pageNumber"));
      } else {
        $pageNumber = 1;
      }

      $pageSubCount = 50;
      $pageItemCount = pageItemCount("lotteryJoins WHERE lotteryPass = '".$readLottery["lotteryPass"]."'", $pageSubCount);

      if ($pageNumber > $pageItemCount) {
        $pageNumber = 1;
      }

      $queryPageItemCount = $pageNumber * $pageSubCount - $pageSubCount;
      $maxPageItemCount = 5;
    ?>
      <?php $searchLotteryJoins = $db->query("SELECT * FROM lotteryJoins WHERE lotteryPass = '".$readLottery["lotteryPass"]."' ORDER BY id DESC LIMIT $queryPageItemCount, $pageSubCount"); ?>
<div class="page-content">
  <div class="row">
    <div class="col">
      <nav class="page-breadcrumb">
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="<?php echo urlConverter("admin_home", $languageType); ?>"><?php echo languageVariables("dashboard", "words", $languageType); ?></a></li>
          <li class="breadcrumb-item"><a href="#"><?php echo languageVariables("modules", "words", $languageType); ?></a></li>
          <li class="breadcrumb-item"><a href="<?php echo urlConverter("admin_modules_lottery", $languageType); ?>"><?php echo languageVariables("lottery", "words", $languageType); ?></a></li>
          <li class="breadcrumb-item active" aria-current="page"><?php echo languageVariables("history", "words", $languageType); ?></li>
        </ol>
      </nav>
    </div>
    <div class="col-auto">
      <nav aria-label="Page navigation example" style="floatt: right;">
        <ul class="pagination">
          <li class="page-item <?php echo (($pageNumber == "1") ? "disabled" : ""); ?>"><a class="page-link" href="<?php echo urlConverter("admin_modules_lottery_history_p", $languageType)."/".($pageNumber-1); ?>"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-left"><polyline points="15 18 9 12 15 6"></polyline></svg></a></li>
          <?php 
            for ($i = $pageNumber - $maxPageItemCount; $i < $pageNumber + $maxPageItemCount + 1; $i++) {
					    if ($i > 0 && $i <= $pageItemCount) {
          ?>
          <li class="page-item <?php echo (($pageNumber == $i) ? "active" : ""); ?>"><a class="page-link" href="<?php echo urlConverter("admin_modules_lottery_history_p", $languageType)."/".$i; ?>"><?php echo $i; ?></a></li>
          <?php } } ?>
          <li class="page-item <?php echo (($pageItemCount == $pageNumber) ? "disabled" : ""); ?>"><a class="page-link" href="<?php echo urlConverter("admin_modules_lottery_history_p", $languageType)."/".($pageNumber+1); ?>"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-right"><polyline points="9 18 15 12 9 6"></polyline></svg></a></li>
        </ul>
      </nav>
    </div>
  </div>
  <div class="row">
    <div class="col-md-12">
    <?php if (mysqlCount($searchLotteryJoins) > 0) { ?>
      <div class="card" data-toggle="lists" data-lists-values='["joinID", "joinUsername", "joinTickets", "JoinChance", "joinDate"]'>
        <div class="card-header">
          <div class="row align-items-center">
            <div class="col">
              <div class="row align-items-center">
                <div class="col-auto pr-0">
                  <span data-feather="search"></span>
                </div>
                <div class="col">
                  <input type="search" class="form-control search" style="border: 0; background: none;" name="search" placeholder="<?php echo languageVariables("search", "words", $languageType); ?>">
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="card-body p-0">
          <div class="table-responsive">
            <table class="table table-hover">
              <thead>
                <tr>
                  <th class="text-center" style="width: 40px;"><a href="#" class="text-muted sort" data-sort="joinID">#ID</a></th>
                  <th class="text-center"><a href="#" class="text-muted sort" data-sort="joinUsername"><?php echo languageVariables("username", "words", $languageType); ?></a></th>
                  <th class="text-center"><a href="#" class="text-muted sort" data-sort="joinTickets"><?php echo languageVariables("ticket", "words", $languageType); ?></a></th>
                  <th class="text-center"><a href="#" class="text-muted sort" data-sort="JoinChance"><?php echo languageVariables("luckyChance", "words", $languageType); ?></a></th>
                  <th class="text-center"><a href="#" class="text-muted sort" data-sort="joinDate"><?php echo languageVariables("date", "words", $languageType); ?></a></th>
                  <th class="text-right">&nbsp;</th>
                </tr>
              </thead>
              <tbody class="list">
               <?php foreach ($searchLotteryJoins as $readLotteryJoin) { ?>
                <tr>
                  <td class="joinID text-center" style="width: 40px;"><a href="<?php echo urlConverter("admin_player", $languageType); ?>/<?php echo $readLotteryJoin["username"]; ?>">#<?php echo $readLotteryJoin["id"]; ?></a></td>
                  <td class="joinUsername text-center"><a href="<?php echo urlConverter("admin_player", $languageType); ?>/<?php echo $readLotteryJoin["username"]; ?>"><?php echo $readLotteryJoin["username"]; ?></a></td>
                  <td class="joinTickets text-center"><?php echo $readLotteryJoin["tickets"]." ".languageVariables("count", "words", $languageType); ?></td>
                  <td class="JoinChance text-center"><?php echo number_format((($readLotteryJoin["tickets"]*100)/$totalTickets), 2)."%"; ?></td>
                  <td class="joinDate text-center"><?php echo checkTime($readLotteryJoin["date"]); ?></td>
                  <td class="text-right">
                    <button type="button" class="btn btn-danger btn-icon" confirm-element="confirm" confirm-text="<?php echo languageVariables("deleteAlert", "words", $languageType); ?>" direct-href="<?php echo urlConverter("admin_modules_lottery_history_delete", $languageType); ?>/<?php echo $readLotteryJoin["id"]; ?>" data-toggle="tooltip" data-placement="top" title="<?php echo languageVariables("remove", "words", $languageType); ?>"><i data-feather="trash-2"></i></button>
                  </td>
                </tr>
              <?php } ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    <?php } else { echo alert(languageVariables("alertPageNone", "modules", $languageType), "danger", "0", "/"); } ?>
    </div>
  </div>
</div>
  <?php } else if (get("target") == "winners") { ?>
    <?php
      if (isset($_GET["id"])) {
        $removeWinner = $db->prepare("DELETE FROM lotteryWinners WHERE id = ?");
        $removeWinner->execute(array(get("id")));
        go(urlConverter("admin_modules_lottery_winners", $languageType));
      }
    ?>
    <?php 
      if (isset($_GET["pageNumber"])) {
        if (!is_numeric(get("pageNumber"))) {
          $_GET["pageNumber"] = 1;
        }
        $pageNumber = intval(get("pageNumber"));
      } else {
        $pageNumber = 1;
      }

      $pageSubCount = 50;
      $pageItemCount = pageItemCount("lotteryWinners", $pageSubCount);

      if ($pageNumber > $pageItemCount) {
        $pageNumber = 1;
      }

      $queryPageItemCount = $pageNumber * $pageSubCount - $pageSubCount;
      $maxPageItemCount = 5;
    ?>
      <?php $searchLotteryWinners = $db->query("SELECT * FROM lotteryWinners ORDER BY id DESC LIMIT $queryPageItemCount, $pageSubCount"); ?>
<div class="page-content">
  <div class="row">
    <div class="col">
      <nav class="page-breadcrumb">
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="<?php echo urlConverter("admin_home", $languageType); ?>"><?php echo languageVariables("dashboard", "words", $languageType); ?></a></li>
          <li class="breadcrumb-item"><a href="#"><?php echo languageVariables("modules", "words", $languageType); ?></a></li>
          <li class="breadcrumb-item"><a href="<?php echo urlConverter("admin_modules_lottery", $languageType); ?>"><?php echo languageVariables("lottery", "words", $languageType); ?></a></li>
          <li class="breadcrumb-item active" aria-current="page"><?php echo languageVariables("winners", "words", $languageType); ?></li>
        </ol>
      </nav>
    </div>
    <div class="col-auto">
      <nav aria-label="Page navigation example" style="floatt: right;">
        <ul class="pagination">
          <li class="page-item <?php echo (($pageNumber == "1") ? "disabled" : ""); ?>"><a class="page-link" href="<?php echo urlConverter("admin_modules_lottery_winners_p", $languageType)."/".($pageNumber-1); ?>"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-left"><polyline points="15 18 9 12 15 6"></polyline></svg></a></li>
          <?php 
            for ($i = $pageNumber - $maxPageItemCount; $i < $pageNumber + $maxPageItemCount + 1; $i++) {
					    if ($i > 0 && $i <= $pageItemCount) {
          ?>
          <li class="page-item <?php echo (($pageNumber == $i) ? "active" : ""); ?>"><a class="page-link" href="<?php echo urlConverter("admin_modules_lottery_winners_p", $languageType)."/".$i; ?>"><?php echo $i; ?></a></li>
          <?php } } ?>
          <li class="page-item <?php echo (($pageItemCount == $pageNumber) ? "disabled" : ""); ?>"><a class="page-link" href="<?php echo urlConverter("admin_modules_lottery_winners_p", $languageType)."/".($pageNumber+1); ?>"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-right"><polyline points="9 18 15 12 9 6"></polyline></svg></a></li>
        </ul>
      </nav>
    </div>
  </div>
  <div class="row">
    <div class="col-md-12">
    <?php if (mysqlCount($searchLotteryWinners) > 0) { ?>
      <div class="card" data-toggle="lists" data-lists-values='["joinID", "joinUsername", "joinTickets", "JoinChance", "joinDate"]'>
        <div class="card-header">
          <div class="row align-items-center">
            <div class="col">
              <div class="row align-items-center">
                <div class="col-auto pr-0">
                  <span data-feather="search"></span>
                </div>
                <div class="col">
                  <input type="search" class="form-control search" style="border: 0; background: none;" name="search" placeholder="<?php echo languageVariables("search", "words", $languageType); ?>">
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="card-body p-0">
          <div class="table-responsive">
            <table class="table table-hover">
              <thead>
                <tr>
                  <th class="text-center" style="width: 40px;"><a href="#" class="text-muted sort" data-sort="joinID">#ID</a></th>
                  <th class="text-center"><a href="#" class="text-muted sort" data-sort="joinUsername"><?php echo languageVariables("username", "words", $languageType); ?></a></th>
                  <th class="text-center"><a href="#" class="text-muted sort" data-sort="joinTickets"><?php echo languageVariables("amount", "words", $languageType); ?></a></th>
                  <th class="text-center"><a href="#" class="text-muted sort" data-sort="JoinChance"><?php echo languageVariables("luckyChance", "words", $languageType); ?></a></th>
                  <th class="text-center"><a href="#" class="text-muted sort" data-sort="joinDate"><?php echo languageVariables("date", "words", $languageType); ?></a></th>
                  <th class="text-right">&nbsp;</th>
                </tr>
              </thead>
              <tbody class="list">
               <?php foreach ($searchLotteryWinners as $readLotteryWinner) { ?>
                <tr>
                  <td class="joinID text-center" style="width: 40px;"><a href="<?php echo urlConverter("admin_player", $languageType); ?>/<?php echo $readLotteryWinner["username"]; ?>">#<?php echo $readLotteryWinner["id"]; ?></a></td>
                  <td class="joinUsername text-center"><a href="<?php echo urlConverter("admin_player", $languageType); ?>/<?php echo $readLotteryWinner["username"]; ?>"><?php echo $readLotteryWinner["username"]; ?></a></td>
                  <td class="joinTickets text-center"><?php echo $readLotteryWinner["amount"]." ".$rSettings["creditName"]; ?></td>
                  <td class="JoinChance text-center"><?php echo number_format($readLotteryWinner["chance"], 2)."%"; ?></td>
                  <td class="joinDate text-center"><?php echo checkTime($readLotteryWinner["date"]); ?></td>
                  <td class="text-right">
                    <button type="button" class="btn btn-danger btn-icon" confirm-element="confirm" confirm-text="<?php echo languageVariables("deleteAlert", "words", $languageType); ?>" direct-href="<?php echo urlConverter("admin_modules_lottery_winners_delete", $languageType); ?>/<?php echo $readLotteryWinner["id"]; ?>" data-toggle="tooltip" data-placement="top" title="<?php echo languageVariables("remove", "words", $languageType); ?>"><i data-feather="trash-2"></i></button>
                  </td>
                </tr>
              <?php } ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    <?php } else { echo alert(languageVariables("alertPageNone", "modules", $languageType), "danger", "0", "/"); } ?>
    </div>
  </div>
</div>
  <?php } ?>
<?php } ?>