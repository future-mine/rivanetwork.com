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
<div class="container-fluid">
  <div class="row">
    <div class="col-12 p-0">
      <div class="bg-dark--1">
        <div class="container">
          <div class="row">
            <div class="col-12">
              <nav aria-label="breadcrumb" class="pt-lg-5 pt-4">
                <ol class="breadcrumb rounded-none bg-dark--3 font-size-6">
                  <li class="breadcrumb-item"><a href="<?php echo urlConverter("home", $languageType); ?>" class="text-white font-100"><?php echo languageVariables("home", "words", $languageType); ?></a></li>
                  <li class="breadcrumb-item active"><a class="text-white font-100"><?php echo languageVariables("vote", "words", $languageType); ?></a></li>
                </ol>
              </nav>
            </div>
          </div>
        </div>
      </div>
      <section class="leaderboards bg-dark--1 p-1 py-5">
      <div class="container">
          <div class="row">
            <div class="col-12 col-lg-4 p-0 pr-lg-5 pt-lg-5">
              <div class="card-header font-size-7 line-height-1  text-lowercase font-100 text-secondary text-center w-50 mb-4 mx-auto">
                <?php echo languageVariables("lastHistoryTitle", "vote", $languageType); ?>
              </div>
              <div class="card-wrapper w-100 mx-auto mt-5 row">
                <?php $searchVotes = json_decode(file_get_contents("https://minecraft-mp.com/api/?object=servers&element=votes&key=".$voteServerKey."&format=json&limit=5"), true); ?>
                <?php if(!empty($searchVotes["votes"])) { ?>
                <?php foreach($searchVotes["votes"] as $readVotes) { ?>
                <div class="col-12 p-1">
                  <div class="card text-white card-leaderboard pt-5">
                    <div class="card-body bg-dark--2 p-0 pt-5 d-flex flex-column font-100">
                      <div class="mc-skin position-absolute mb-4 center">
                        <div class="mc-skin-img-wrapper mx-auto js-mirror">
                          <div class="mc-skin-img">
                            <img src="https://minotar.net/body/<?php echo $readVotes["nickname"]; ?>/100.png" alt="<?php echo $readStoreHistory["username"]; ?>">
                          </div>
                        </div>
                      </div>
                      <h5 class="card-title pt-4 text-center font-100 mb-0"><?php echo $readVotes["nickname"]; ?></h5>
                      <p class="card-text font-size-7 text-center mt-n1 mb-3 text-secondary"><?php echo languageVariables("thanks", "words", $languageType); ?></p>
                      <div class="details font-size-6 d-flex justify-content-between bg-dark--3 px-3 py-2">
                        <div class="id position-relative font-900 text-secondary">
                          <span>
                            1
                          </span>
                        </div>
                        <div class="date text-secondary">
                          <?php echo substr(checkTime(date('d.m.Y H:i', $readVotes["timestamp"]), 2, true), 0, -6); ?>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <?php } } else { echo alert(languageVariables("historyAlert", "vote", $languageType), "danger", "0", "/"); } ?>
              </div>
            </div>
            <div class="col-12 col-lg-4 pb-5 pt-3">
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
              <form action="" method="post">
                <div class="bg-dark--2 p-5">
                  <h3 class="text-secondary mb-3 font-100 font-size-6 letter-spacing-1 text-uppercase">
                    <?php echo languageVariables("cardTitle", "vote", $languageType); ?>
                  </h3>
                  <div class="input-group mb-3 flex-column bg-dark--4 border col-12 p-0 placeholder <?php if (isset($_SESSION["incAccountLogin"])) { echo "input-focused"; } ?>">
                    <label for="name" class="o-100 d-block mb-0 text-white font-size-6 font-100 position-absolute"><i class="fas fa-user fa-xs mr-1"></i><?php echo languageVariables("username", "words", $languageType); ?></label>
                    <input type="text" placeholder="<?php echo languageVariables("username", "words", $languageType); ?>" class="form-control pt-4 text-white font-size-7 py-2 w-100 font-100 rounded-none" aria-label="<?php echo languageVariables("username", "words", $languageType); ?>" id="name" aria-describedby="name" name="accountName" <?php if (isset($_SESSION["incAccountLogin"])) { echo 'value="'.$readAccount["username"].'" readonly'; } ?>>
                  </div>
                  <?php echo $safeCsrfToken->input("checkVoteToken"); ?>
                  <button type="submit" name="checkVote" class="btn float-right text-white col-12 m-0 line-height-1 text-uppercase letter-spacing-1 font-100 font-size-6 btn-outline-primary">
                    <span class="btn-text">
                      <?php echo languageVariables("query", "words", $languageType); ?>
                    </span>
                  </button>
                </div>
              </form>
            </div>
            <div class="col-12 col-lg-4 p-0 pl-lg-5 pt-5">
              <div class="card-header font-size-7 line-height-1  text-lowercase font-100 text-secondary text-center w-50 mb-4 mx-auto">
                <?php echo languageVariables("topHistoryTitle", "vote", $languageType); ?>
              </div>
              <div class="card-wrapper w-100 mx-auto mt-5 row">
              <?php $searchTopVotes = json_decode(file_get_contents("https://minecraft-mp.com/api/?object=servers&element=voters&key=".$voteServerKey."&month=".date("Ym")."&format=json&limit=5"), true); ?>
              <?php if(!empty($searchTopVotes["voters"])) { ?>
                <?php foreach ($searchTopVotes["voters"] as $readTopVotes) { ?>
                <div class="col-12 p-1">
                  <div class="card text-white card-leaderboard pt-5">
                    <div class="card-body bg-dark--2 p-0 pt-5 d-flex flex-column font-100">
                      <div class="mc-skin position-absolute mb-4 center">
                        <div class="mc-skin-img-wrapper mx-auto js-mirror">
                          <div class="mc-skin-img">
                            <img src="https://minotar.net/body/<?php echo $readTopVotes["nickname"]; ?>/100.png" alt="<?php echo $readTopVotes["nickname"]; ?>">
                          </div>
                        </div>
                      </div>
                      <h5 class="card-title pt-4 text-center font-100 mb-0"><?php echo $readTopVotes["nickname"]; ?></h5>
                      <p class="card-text font-size-7 text-center mt-n1 mb-3 text-secondary"><?php echo $readTopVotes["votes"]." ".languageVariables("vote", "words", $languageType); ?></p>
                      <div class="details font-size-6 d-flex justify-content-between bg-dark--3 px-3 py-2">
                        <div class="id position-relative font-900 text-secondary">
                          <span>
                            1
                          </span>
                        </div>
                        <div class="date text-secondary">
                          <?php echo checkMonth(date('m'))." ".date("Y"); ?>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <?php } } else { echo alert(languageVariables("historyAlert", "vote", $languageType), "danger", "0", "/"); } ?>
              </div>
            </div>
          </div>
        </div>
      </section>
    </div>
  </div>
</div>
</div>