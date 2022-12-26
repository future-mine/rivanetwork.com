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
<section class="py-16">
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
            <a href="<?php echo urlConverter("vote", $languageType); ?>" class="ml-4 text-sm font-medium text-gray-500 hover:text-gray-700"><?php echo languageVariables("vote", "words", $languageType); ?></a>
          </div>
        </li>
      </ol>
    </nav>
  </div>
  <div class="container mx-auto grid lg:grid-cols-10 gap-16 px-4 md:px-0 mt-10">
    <div class="lg:col-span-3 flex flex-col gap-12">
      <div>
        <div class="mt-10 card">
          <div class="border-b-2 border-gray-200/50 py-4 px-6">
            <div class="rounded-2xl flex items-center justify-center bg-indigo-400/25 w-14 h-14 absolute -top-5 -right-5">
              <i class="fas fa-check-to-slot !text-indigo-700 fs-5"></i>
            </div>
            <p class="text-gray-500 fw-medium"><?php echo languageVariables("lastHistoryTitle", "vote", $languageType); ?></p>
          </div>
          <div class="">
            <?php $searchVotes = json_decode(file_get_contents("https://minecraft-mp.com/api/?object=servers&element=votes&key=".$voteServerKey."&format=json&limit=5"), true); ?>
            <?php if(!empty($searchVotes["votes"])) { ?>
            <?php $voteID = 0; ?>
            <div class="overflow-x-auto w-full">
              <table class="w-full text-left relative z-10">
                <thead>
                  <tr class="bg-indigo-400/25 !text-indigo-700">
                    <th class="py-4 px-3 relative z-10">ID</th>
                    <th class="py-4 px-3 relative z-10"><?php echo languageVariables("username", "words", $languageType); ?></th>
                    <th class="py-4 px-3 relative z-10"><?php echo languageVariables("vote", "words", $languageType); ?></th>
                    <th class="py-4 px-3 relative z-10"><?php echo languageVariables("date", "words", $languageType); ?></th>
                  </tr>
                </thead>
                <tbody class="text-gray-500 dark:text-green-400/75 text-sm">
                <?php foreach($searchVotes["votes"] as $readVotes) { ?>
                  <?php $voteID = $voteID+1; ?>
                  <tr class="hover:bg-gray-100">
                    <td class="font-normal p-3">#<?php echo $voteID; ?></td>
                    <td class="font-normal p-3 w-100"><?php echo $readVotes["nickname"]; ?></td>
                    <td class="font-normal p-3"><?php echo languageVariables("thanks", "words", $languageType); ?></td>
                    <td class="font-normal p-3"><?php echo substr(checkTime(date('d.m.Y H:i', $readVotes["timestamp"]), 2, true), 0, -6); ?></td>
                  </tr>
                  <?php } ?>
                </tbody>
              </table>
            </div>
            <?php } else { echo alert(languageVariables("historyAlert", "vote", $languageType), "danger", "0", "/"); } ?>
          </div>
        </div>
      </div>
    </div>
    <div class="card lg:col-span-4 flex flex-col gap-16">
      <div class="px-6 py-8">
        <h3 class="text-gray-800 fw-bold fs-5"><?php echo languageVariables("cardTitle", "vote", $languageType); ?></h3>
        <div class="text-gray-400 mt-4">
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
            <div class="grid">
              <label for="title" class="pl-2 text-gray-700 fw-bolder"><?php echo languageVariables("username", "words", $languageType); ?></label>
              <input id="title" type="text" name="accountName" class="w-full mt-2 form-control" placeholder="<?php echo languageVariables("username", "words", $languageType); ?>" <?php if (isset($_SESSION["incAccountLogin"])) { echo 'value="'.$readAccount["username"].'" readonly'; } ?>>
            </div>
            <?php echo $safeCsrfToken->input("checkVoteToken"); ?>
            <div class="mt-8 border-t-2 border-gray-200/50 pt-5 flex justify-center items-center">
              <button type="submit" name="checkVote" class="btn btn-primary"><?php echo languageVariables("query", "words", $languageType); ?></button>
            </div>
          </form>
        </div>
      </div>
    </div>
    <div class="lg:col-span-3 flex flex-col gap-12">
      <div>
        <div class="mt-10 card">
          <div class="border-b-2 border-gray-200/50 py-4 px-6">
            <div class="rounded-2xl flex items-center justify-center bg-indigo-400/25 w-14 h-14 absolute -top-5 -right-5">
              <i class="fas fa-check-to-slot !text-indigo-700 fs-5"></i>
            </div>
            <p class="text-gray-500 fw-medium"><?php echo languageVariables("topHistoryTitle", "vote", $languageType); ?></p>
          </div>
          <div class="">
            <?php $searchTopVotes = json_decode(file_get_contents("https://minecraft-mp.com/api/?object=servers&element=voters&key=".$voteServerKey."&month=".date("Ym")."&format=json&limit=5"), true); ?>
            <?php if(!empty($searchTopVotes["voters"])) { ?>
            <?php $topVoteID = 0; ?>
            <div class="overflow-x-auto w-full">
              <table class="w-full text-left relative z-10">
                <thead>
                  <tr class="bg-indigo-400/25 !text-indigo-700">
                    <th class="py-4 px-3 relative z-10">ID</th>
                    <th class="py-4 px-3 relative z-10"><?php echo languageVariables("username", "words", $languageType); ?></th>
                    <th class="py-4 px-3 relative z-10"><?php echo languageVariables("vote", "words", $languageType); ?></th>
                    <th class="py-4 px-3 relative z-10"><?php echo languageVariables("date", "words", $languageType); ?></th>
                  </tr>
                </thead>
                <tbody class="text-gray-500 dark:text-green-400/75 text-sm">
                  <?php foreach ($searchTopVotes["voters"] as $readTopVotes) { ?>
                  <?php $topVoteID = $topVoteID+1; ?>
                  <tr class="hover:bg-gray-100">
                    <td class="font-normal p-3">#<?php echo $topVoteID; ?></td>
                    <td class="font-normal p-3 w-100"><?php echo $readTopVotes["nickname"]; ?></td>
                    <td class="font-normal p-3"><?php echo $readTopVotes["votes"]." ".languageVariables("vote", "words", $languageType); ?></td>
                    <td class="font-normal p-3"><?php echo checkMonth(date('m'))." ".date("Y"); ?></td>
                  </tr>
                  <?php } ?>
                </tbody>
              </table>
            </div>
            <?php } else { echo alert(languageVariables("historyAlert", "vote", $languageType), "danger", "0", "/"); } ?>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>