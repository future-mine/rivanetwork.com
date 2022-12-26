<?php
if ($readModule["voteSystemStatus"] == 0) {
  go("/404");
}
$voteServerKey = $readModule["voteSystemServerKey"];
function checkMonth($month) {
    if ($month === "01") { $month = languageVariables("month01", "words", $languageType); }
    if ($month === "02") { $month = languageVariables("month02", "words", $languageType); }
    if ($month === "03") { $month = languageVariables("month03", "words", $languageType); }
    if ($month === "04") { $month = languageVariables("month04", "words", $languageType); }
    if ($month === "05") { $month = languageVariables("month05", "words", $languageType); }
    if ($month === "06") { $month = languageVariables("month06", "words", $languageType); }
    if ($month === "07") { $month = languageVariables("month07", "words", $languageType); }
    if ($month === "08") { $month = languageVariables("month08", "words", $languageType); }
    if ($month === "09") { $month = languageVariables("month09", "words", $languageType); }
    if ($month === "10") { $month = languageVariables("month10", "words", $languageType); }
    if ($month === "11") { $month = languageVariables("month11", "words", $languageType); }
    if ($month === "12") { $month = languageVariables("month12", "words", $languageType); }
    return $month;
}
$readVoteServer = json_decode(file_get_contents("https://minecraft-mp.com/api/?object=servers&element=detail&key=".$voteServerKey), true);
?>
<div class="content-grid">
  <div class="grid grid-4-4-4 mobile-prefer-content">
    <div class="grid-column">
      <div class="section-header">
        <div class="section-header-info">
          <p class="section-pretitle"><?php echo languageVariables("vote", "words", $languageType); ?></p>
          <h2 class="section-title"><?php echo languageVariables("lastHistoryTitle", "vote", $languageType); ?></h2>
        </div>
      </div>
      <?php $searchVotes = json_decode(file_get_contents("https://minecraft-mp.com/api/?object=servers&element=votes&key=".$voteServerKey."&format=json&limit=5"), true); ?>
      <?php if(!empty($searchVotes["votes"])) { ?>
      <div class="widget-box">
        <div class="widget-box-content">
          <div class="user-status-list">
            <?php foreach($searchVotes["votes"] as $readVotes) { ?>
            <div class="user-status">
              <a class="user-status-avatar" href="<?php echo urlConverter("player", $languageType); ?>/<?php echo $readVotes["nickname"]; ?>">
                <img src="https://minotar.net/bust/<?php echo $readVotes["nickname"]; ?>/100.png" width="40" height="40">
              </a>
              <p class="user-status-title"><?php echo str_replace("&username", $readVotes["nickname"], languageVariables("lastHistoryText", "vote", $languageType)); ?></p>
              <p class="user-status-timestamp"><?php echo substr(checkTime(date('d.m.Y H:i', $readVotes["timestamp"]), 2, true), 0, -6); ?></p>
            </div>
            <?php } ?>
          </div>
        </div>
      </div>
      <?php } else { echo alert(languageVariables("historyAlert", "vote", $languageType), "warning", "0", "/"); } ?>
    </div>
    <div class="grid-column">
      <div class="section-header">
        <div class="section-header-info">
          <p class="section-pretitle"><?php echo languageVariables("vote", "words", $languageType); ?></p>
          <h2 class="section-title"><?php echo languageVariables("cardTitle", "vote", $languageType); ?></h2>
        </div>
      </div>
      <div class="widget-box">
        <div class="widget-box-content">
          <?php
                require_once(__DR__."/main/includes/packages/class/csrf/class.php");
                $safeCsrfToken = new CSRF('csrf-sessions', 'csrf-token');
                if (isset($_POST["checkVote"])) {
                  if ($safeCsrfToken->validate('checkVoteToken')) {
                    if (post("accountName") !== "") {
                      if (strlen(post("accountName")) >= 3 &&  16 >= strlen(post("accountName"))) {
                        $voteCheckControl = file_get_contents("https://minecraft-mp.com/api/?object=votes&element=claim&key=".$voteServerKey."&username=".post("accountName"));
                        if ($voteCheckControl == "0") {
                          echo alert(languageVariables("alert0", "vote", $languageType), "success", "2", "https://minecraft-mp.com/server/".$readVoteServer["id"]."/vote/");
                        } else {
                          if ($voteCheckControl == "1") {
                            echo alert(languageVariables("alert1", "vote", $languageType), "warning", "0", "/");
                          } else {
                            echo alert(languageVariables("alert2", "vote", $languageType), "success", "0", "/");
                          }
                        }
                      } else {
                        echo alert(languageVariables("alertUsername", "vote", $languageType), "warning", "0", "/");
                      }
                    } else {
                      echo alert(languageVariables("alertNone", "vote", $languageType), "warning", "0", "/");
                    }
                  } else {
                    echo alert(languageVariables("alertSystem", "vote", $languageType), "danger", "0", "/");
                  }
                }
            ?>
          <form action="" method="POST">
            <div class="form-row split">
              <div class="form-item">
                <div class="form-input social-input small <?php if (isset($_SESSION["incAccountLogin"])) { echo "active"; } ?>">
                  <div class="social-link no-hover patreon">
                    <svg class="icon-patreon">
                      <use xlink:href="#svg-members"></use>
                    </svg>
                  </div>
                  <label for="credit-username"><?php echo languageVariables("username", "words", $languageType); ?></label>
                  <input type="text" id="credit-username" name="accountName" <?php if (isset($_SESSION["incAccountLogin"])) { echo 'value="'.$readAccount["username"].'" readonly'; } ?>>
                </div>
              </div>
            </div>
            <div class="form-row split">
              <div class="form-item active">
                <?php echo $safeCsrfToken->input("checkVoteToken"); ?>
                <button class="button w-25 primary" style="float:right;" type="submit" name="checkVote"><?php echo languageVariables("query", "words", $languageType); ?></button>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
    <div class="grid-column">
      <div class="section-header">
        <div class="section-header-info">
          <p class="section-pretitle"><?php echo languageVariables("vote", "words", $languageType); ?></p>
          <h2 class="section-title"><?php echo languageVariables("topHistoryTitle", "vote", $languageType); ?></h2>
        </div>
      </div>
      <?php $searchTopVotes = json_decode(file_get_contents("https://minecraft-mp.com/api/?object=servers&element=voters&key=".$voteServerKey."&month=".date("Ym")."&format=json&limit=5"), true); ?>
      <?php if(!empty($searchTopVotes["voters"])) { ?>
      <div class="widget-box">
        <div class="widget-box-content">
          <div class="user-status-list">
            <?php foreach($searchTopVotes["voters"] as $readTopVotes) { ?>
            <div class="user-status">
              <a class="user-status-avatar" href="<?php echo urlConverter("player", $languageType); ?>/<?php echo $readTopVotes["nickname"]; ?>">
                <img src="https://minotar.net/bust/<?php echo $readTopVotes["nickname"]; ?>/100.png" width="40" height="40">
              </a>
              <p class="user-status-title"><?php echo str_replace(array("&username", "&count"), array($readVotes["nickname"], $readTopVotes["votes"]), languageVariables("topHistoryText", "vote", $languageType)); ?></p>
              <p class="user-status-timestamp"><?php echo checkMonth(date('m'))." ".date("Y"); ?></p>
            </div>
            <?php } ?>
          </div>
        </div>
      </div>
      <?php } else { echo alert(languageVariables("historyAlert", "vote", $languageType), "warning", "0", "/"); } ?>
    </div>
  </div>
</div>