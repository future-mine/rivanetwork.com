<?php
if (isset($_GET["player"])) {
  $searchPlayer = $db->prepare("SELECT * FROM accounts WHERE username = ?");
  $searchPlayer->execute(array(get("player")));
  if ($searchPlayer->rowCount() > 0) {
    $readPlayer = $searchPlayer->fetch();
    $rowCountPlayerProduct = $db->prepare("SELECT * FROM userChest WHERE userID = ? AND status = ?");
    $rowCountPlayerProduct->execute(array($readPlayer["id"], "0"));
    $rowCountPlayerProduct = $rowCountPlayerProduct->rowCount();
    $rowCountPlayerInvent = $db->prepare("SELECT * FROM accountsInventory WHERE userID = ?");
    $rowCountPlayerInvent->execute(array($readPlayer["id"]));
    $rowCountPlayerInvent = $rowCountPlayerInvent->rowCount();
    $searchPlayerPermission = $db->prepare("SELECT * FROM accountsPermission WHERE id = ?");
    $searchPlayerPermission->execute(array($readPlayer["permission"]));
    $readPlayerPermission = $searchPlayerPermission->fetch();
?>
<style type="text/css">.instagram{background-color: #8a3ab9;}.twitter{background-color: #1DA1F2;}.youtube{background-color:#FF0000;}</style>
<div class="container-fluid">
  <div class="row">
    <div class="col-12 p-0">
      <div class="container">
        <div class="row">
          <div class="col-12">
            <nav aria-label="breadcrumb" class="pt-lg-5 pt-4">
              <ol class="breadcrumb rounded-none bg-dark--5 font-size-6">
                <li class="breadcrumb-item"><a href="<?php echo urlConverter("home", $languageType); ?>" class="text-white font-100"><?php echo languageVariables("home", "words", $languageType); ?></a></li>
                <li class="breadcrumb-item"><a href="<?php echo urlConverter("player", $languageType); ?>/<?php echo $readPlayer["username"]; ?>" class="text-white font-100"><?php echo languageVariables("player", "words", $languageType); ?></a></li>
                <li class="breadcrumb-item active"><a class="text-white font-100"><?php echo $readPlayer["username"]; ?></a></li>
              </ol>
            </nav>
          </div>
          <div class="col-12 pb-5 pt-3">
            <div class="row">
              <div class="col-12 col-lg-12 pr-lg-2">
                <div class="profile-header bg-dark--5 d-flex align-items-center position-relative overflow-hidden">
                  <div class="mc-skin left mr-0 pl-3 pt-3 profile-skin">
                    <div class="mc-skin-img-wrapper js-mirror">
                      <div class="mc-skin-img">
                        <img src="https://minotar.net/body/<?php echo $readPlayer["username"]; ?>/100.png" alt="<?php echo $readPlayer["username"]; ?>">
                      </div>
                    </div>
                  </div>
                  <div class="user-info d-flex flex-column flex-lg-row justify-content-lg-between align-items-lg-center w-100 px-sm-5 px-4 py-3 mb-1">
                    <div class="block">
                      <h1 class="d-block username font-size-12 text-white font-100 mb-0"><?php echo $readPlayer["username"]; ?></h1>
                      <h2 class="d-block mail font-size-7 text-white font-100 mb-2 mt-0 o-25"><?php echo languageVariables("emailProtection", "player", $languageType); ?></h2>
                      <span class="d-inline-block role font-size-6 text-uppercase">
                        <span class="badge font-100 letter-spacing-2 line-height-1" style="<?php echo "background-color: ".$readPlayerPermission["permColorBG"]."; color: ".$readPlayerPermission["permColorText"].";"; ?>" data-title="Yetki"><?php echo $readPlayerPermission["permName"]; ?></span>
                      </span>
                      <span class="d-inline-block credit font-size-6 text-uppercase">
                        <span class="badge badge-warning font-900 letter-spacing-2 line-height-1 turkish-lira"><?php echo $readPlayer["credit"]; ?></span>
                      </span>
                    </div>
                  </div>
                  <div class="details pr-5 o-75">
                    <div class="last-login text-white mb-3">
                      <span class="title font-100 font-size-6 text-right w-100 line-height-1 d-block o-25"><?php echo languageVariables("lastLogin", "player", $languageType); ?></span>
                      <span class="text-nowrap font-100 font-size-7 text-right"><?php echo checkTime($readPlayer['lastLogin']); ?></span>
                    </div>
                    <div class="reg-date text-white">
                      <span class="title font-100 font-size-6 text-right w-100 line-height-1 d-block o-25"><?php echo languageVariables("registerDate", "player", $languageType); ?></span>
                      <span class="text-nowrap font-100 font-size-7 text-right"><?php echo checkTime($readPlayer['registerDate']); ?></span>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-12 mb-2 d-flex">
                <div class="discord contact-card bg-discord text-white font-100 font-size-7 line-height-1 align-items-center" style="max-width: 166px;">
                  <i class="fab fa-discord mr-2"></i>
                  <span><?php echo $readPlayer["discord"]; ?></span>
                </div>
                <div class="skype contact-card bg-primary mb-2 text-white font-100 font-size-7 line-height-1 align-items-center position-relative overflow-hidden" style="max-width: 166px;">
                  <i class="fab fa-skype mr-2"></i>
                  <span><?php echo $readPlayer["skype"]; ?></span>
                </div>
                <div class="instagram contact-card mb-2 text-white font-100 font-size-7 line-height-1 align-items-center position-relative overflow-hidden" style="max-width: 166px;">
                  <i class="fab fa-instagram mr-2"></i>
                  <span><?php echo $readPlayer["instagram"]; ?></span>
                </div>
                <div class="twitter contact-card mb-2 text-white font-100 font-size-7 line-height-1 align-items-center position-relative overflow-hidden" style="max-width: 166px;">
                  <i class="fab fa-twitter mr-2"></i>
                  <span><?php echo $readPlayer["twitter"]; ?></span>
                </div>
                <div class="youtube contact-card mb-2 text-white font-100 font-size-7 line-height-1 align-items-center position-relative overflow-hidden" style="max-width: 166px;">
                  <i class="fab fa-youtube mr-2"></i>
                  <span><?php echo $readPlayer["youtube"]; ?></span>
                </div>
              </div>
              <div class="container-fluid">
                <div class="row">
                  <div class="col-12 p-0">
                    <div class="container">
                      <div class="row">
                        <div class="col-lg-12 col-12 pb-2 pt-3 px-3 mt-5">
                          <div class="bg-dark--3 p-5 row">
                            <h3 class="text-secondary mb-3 font-100 col-12 p-0 font-size-6 letter-spacing-1 text-uppercase">
                              <?php echo languageVariables("bannedTitle", "player", $languageType); ?>
                            </h3>
                            <div style="width: 100%">
                              <?php $searchBannedHistoryWeb = $db->prepare("SELECT * FROM banned WHERE username = ? AND type = ? AND (bannedDate > ? OR bannedDate = ?)"); ?>
                              <?php $searchBannedHistoryWeb->execute(array($readPlayer["username"], "login", date("Y-m-d H:i:s"), "1000-01-01 00:00:00")); ?>
                              <?php if ($searchBannedHistoryWeb->rowCount() > 0) { ?>
                              <?php $readBHW = $searchBannedHistoryWeb->fetch(); ?>
                              <?php if ($readBHW["bannedDate"] == "1000-01-01 00:00:00") { $userBannedBackDateWeb = "Süresiz"; } else { $userBannedBackDateWeb = max(round((strtotime($readBHW["bannedDate"]) - strtotime(date("Y-m-d H:i:s"))) / 86400), 0).' '.languageVariables("day", "words", $languageType); } ?>
                              <?php echo alert(languageVariables("webBanned", "player", $languageType),": ".$userBannedBackDateWeb." / ".$readBHW["reason"], "success", "0", "/"); ?>
                              <?php } else { echo alert(languageVariables("webNotBanned", "player", $languageType), "success", "0", "/"); } ?>
                              <?php $searchBannedHistorySupport = $db->prepare("SELECT * FROM banned WHERE username = ? AND type = ? AND (bannedDate > ? OR bannedDate = ?)"); ?>
                              <?php $searchBannedHistorySupport->execute(array($readPlayer["username"], "support", date("Y-m-d H:i:s"), "1000-01-01 00:00:00")); ?>
                              <?php if ($searchBannedHistorySupport->rowCount() > 0) { ?>
                              <?php $readBHS = $searchBannedHistorySupport->fetch(); ?>
                              <?php if ($readBHS["bannedDate"] == "1000-01-01 00:00:00") { $userBannedBackDateSupport = "Süresiz"; } else { $userBannedBackDateSupport = max(round((strtotime($readBHS["bannedDate"]) - strtotime(date("Y-m-d H:i:s"))) / 86400), 0).' '.languageVariables("day", "words", $languageType); } ?>
                              <?php echo alert(languageVariables("supportBanned", "player", $languageType).": ".$userBannedBackDateSupport." / ".$readBHS["reason"], "success", "0", "/"); ?>
                              <?php } else { echo alert(languageVariables("supportNotBanned", "player", $languageType), "success", "0", "/"); } ?>
                              <?php $searchBannedHistoryComment = $db->prepare("SELECT * FROM banned WHERE username = ? AND type = ? AND (bannedDate > ? OR bannedDate = ?)"); ?>
                              <?php $searchBannedHistoryComment->execute(array($readPlayer["username"], "comment", date("Y-m-d H:i:s"), "1000-01-01 00:00:00")); ?>
                              <?php if ($searchBannedHistoryComment->rowCount() > 0) { ?>
                              <?php $readBHC = $searchBannedHistoryComment->fetch(); ?>
                              <?php if ($readBHC["bannedDate"] == "1000-01-01 00:00:00") { $userBannedBackDateComment = "Süresiz"; } else { $userBannedBackDateComment = max(round((strtotime($readBHC["bannedDate"]) - strtotime(date("Y-m-d H:i:s"))) / 86400), 0).' '.languageVariables("day", "words", $languageType); } ?>
                              <?php echo alert(languageVariables("commentBanned", "player", $languageType).": ".$userBannedBackDateComment." / ".$readBHC["reason"], "success", "0", "/"); ?>
                              <?php } else { echo alert(languageVariables("commentNotBanned", "player", $languageType), "success", "0", "/"); } ?>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<?php
  } else {
    go("/");
  }
} else if (isset($_POST["searchPlayer"])) {
  $searchPlayer = $db->prepare("SELECT * FROM accounts WHERE username = ?");
  $searchPlayer->execute(array(post("searchPlayer")));
  if ($searchPlayer->rowCount() > 0) {
    $readPlayer = $searchPlayer->fetch();
    go(urlConverter("player", $languageType)."/".$readPlayer["username"]);
  } else {
    go("/");
  }
} else {
  go("/");
}
?>