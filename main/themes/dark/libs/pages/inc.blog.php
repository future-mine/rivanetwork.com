<?php
$searchNews = $db->prepare("SELECT * FROM newsList WHERE id = ?");
$searchNews->execute(array(get("news")));
if ($searchNews->rowCount() > 0) {
    require_once(__DR__ . "/main/includes/packages/class/csrf/class.php");
    $safeCsrfToken = new CSRF('csrf-sessions', 'csrf-token');
    $readNews = $searchNews->fetch();
    if (!isset($_COOKIE["news-" . $readNews["id"]])) {
        $newNewsDisplay = $readNews["newsDisplay"] + 1;
        $updateNewsDisplay = $db->prepare("UPDATE newsList SET newsDisplay = ? WHERE id = ?");
        $updateNewsDisplay->execute(array($newNewsDisplay, $readNews["id"]));
        setcookie("news-" . $readNews["id"], "view");
    }
?>
    <div class="container-fluid">
        <div class="row">
            <div class="col-12 p-0">
                <div class="container">
                    <div class="row">
                        <div class="col-12">
                            <nav aria-label="breadcrumb" class="pt-lg-5 pt-4">
                                <ol class="breadcrumb rounded-none bg-dark--5 font-size-6">
                                    <li class="breadcrumb-item"><a href="<?php echo urlConverter("home", $languageType); ?>" class="text-white font-100"><?php echo languageVariables("home", "words", $languageType); ?></a></li>
                                    <li class="breadcrumb-item"><a href="#" class="text-white font-100"><?php echo languageVariables("news", "words", $languageType); ?></a></li>
                                    <li class="breadcrumb-item active" aria-current="page"><?php echo $readNews['title'] ?></li>
                                </ol>
                            </nav>
                        </div>
                        <div class="col-12 pb-5 pt-3">
                            <div class="blog-header bg-dark--4 p-5 d-flex align-items-sm-end justify-content-sm-start justify-content-end flex-sm-row flex-column" style="background-image: linear-gradient(to top, rgba(19, 19, 19, .99), rgba(19, 19, 19, .3)), url('<?php echo $readNews["image"]; ?>')">
                                <div class="blog-header-img mr-4">
                                    <img src="<?php echo $readNews["image"]; ?>" alt="">
                                </div>
                                <div class="blog-header-text mt-sm-0 mt-3">
                                    <div class="blog-header-author">
                                        <h3 class="text-secondary mb-1 font-100 font-size-6 letter-spacing-1 text-uppercase">
                                            <span class="o-50"><?php echo languageVariables("author", "words", $languageType); ?>:</span>
                                            <span class="author">
                                                <?php echo $readNews["newsAuthor"]; ?>
                                            </span>
                                        </h3>
                                    </div>
                                    <div class="blog-header-title text-white row p-0 m-0">
                                        <h1 class="p-0 m-0 font-size-14 col-lg-8 col-md-10 col-12 p-0 m-0">
                                            <?php echo $readNews["title"]; ?>
                                        </h1>
                                    </div>
                                </div>
                            </div>
                            <div class="blog-info border-top text-white font-size-7 font-100 bg-dark--5 px-5 py-3 line-height-1 d-flex flex-sm-row flex-column justify-content-center justify-content-sm-between">
                                <div class="details">

                                    <span class="category font-size-6 font-800 text-uppercase letter-spacing-1 mr-4" lang="en">
                                        <?php echo $readNews["categoryName"]; ?>
                                    </span>
                                    <span class="view mr-4 font-size-6">
                                        <i class="fas fa-eye fa-xs mr-1 o-75"></i>
                                        <span><?php echo $readNews["newsDisplay"]; ?></span>
                                    </span>
                                    <?php $searchNewsComments = $db->prepare("SELECT * FROM comments WHERE newsID = ? AND status = ?"); ?>
                                    <?php $searchNewsComments->execute(array($readNews["id"], 1)); ?>
                                    <?php $newsCommentsRow = $searchNewsComments->rowCount(); ?>
                                    <span class="comment font-size-6">
                                        <i class="fas fa-comment fa-xs mr-1 o-75"></i>
                                        <span><?php echo $newsCommentsRow; ?></span>
                                    </span>

                                </div>
                                <div class="date p-0 m-0 o-50 mt-sm-0 mt-2">
                                    <span><?php echo checkTime($readNews["date"]); ?></span>
                                </div>
                            </div>
                            <div class="blog-body text-white font-size-7 font-100 bg-dark--3">
                                <div class="block p-5">
                                    <p class="text-secondary">
                                        <?php echo $readNews["text"]; ?>
                                    </p>
                                </div>
                            </div>
                            <div class="blog-footer text-white font-size-7 font-100 bg-dark--5">
                                <h3 class="text-secondary px-5 py-4 border-bottom m-0 font-100 font-size-6 letter-spacing-1 text-uppercase d-flex flex-wrap">
                                    <span class="ml-1 mb-3"><?php echo languageVariables("tags", "words", $languageType); ?>:</span>
                                    <span class="tags d-flex flex-wrap">
                                        <?php $searchNewsTags = $db->prepare("SELECT * FROM newsTags WHERE newsID = ?"); ?>
                                        <?php $searchNewsTags->execute(array($readNews["id"])); ?>
                                        <?php if ($searchNewsTags->rowCount() > 0) : ?>
                                            <?php foreach ($searchNewsTags as $readNewsTags) : ?>
                                                <a href="<?php echo urlConverter("news_category", $languageType); ?>/<?php echo createSlug($readNews["categoryName"]); ?>" class="tag badge m-1 d-inline badge-warning font-900"><?php echo $readNewsTags["name"]; ?></a>
                                            <?php endforeach; ?>
                                        <?php endif; ?>

                                    </span>
                                </h3>
                                <div class="comments px-5 py-4 bg-dark--6">
                                    <?php if ($rSettings["commentsStatus"] == "1" && $readNews["commentStatus"] == "1") : ?>
                                        <?php
                                        $searchNewsComment = $db->prepare("SELECT * FROM comments WHERE newsID = ? AND status = ?");
                                        $searchNewsComment->execute(array($readNews["id"], 1));
                                        ?>
                                        <?php if (isset($_SESSION["incAccountLogin"])) { ?>
                                            <?php
                                            if (isset($_POST["commentMessage"])) {
                                                if ($safeCsrfToken->validate('commentsToken')) {
                                                    if (!empty($_POST["commentMessage"])) {
                                                        $bannedQuery = $db->prepare("SELECT * FROM banned WHERE username = ? AND type = ? AND (bannedDate > ? OR bannedDate = ?)");
                                                        $bannedQuery->execute(array($readAccount["username"], "comment", date("Y-m-d H:i:s"), "1000-01-01 00:00:00"));
                                                        if ($bannedQuery->rowCount() == 0) {
                                                            $insertComment = $db->prepare("INSERT INTO comments SET username = ?, message = ?, date = ?, newsID = ?, status = ?");
                                                            $insertComment->execute(array($readAccount["username"], $_POST["commentMessage"], date("d.m.Y H:i:s"), $readNews["id"], 0));
                                                            $webhookDescription = str_replace(array("[username]", "[url]"), array($readAccount["username"], $siteURL . urlConverter("blog", $languageType)."/" . createSlug($readNews["title"]) . "/" . $readNews["id"]), $readWebhooks["webhookCommentDescription"]);
                                                            $hookObject = json_encode([
                                                                "username" => str_replace("[username]", $readAccount["username"], $readWebhooks["webhookCommentName"]),
                                                                "avatar_url" => avatarAPI($readAccount["username"], 100),
                                                                "tts" => false,
                                                                "embeds" => [
                                                                    [
                                                                        "title" => $readWebhooks["webhookCommentTitle"],
                                                                        "type" => "rich",
                                                                        "image" => ($readWebhooks["webhookCommentImage"] !== "0") ? [
                                                                            "url" => $readWebhooks["webhookCommentImage"]
                                                                        ] : [],
                                                                        "description" => $webhookDescription,
                                                                        "color" => hexdec(rand_color()),
                                                                        "footer" => ($readWebhooks["webhookCommentSignature"] == "1") ? [
                                                                            "text" => "Powered by MineXON",
                                                                            "icon_url" => "https://www.minexon.net/main/theme/assets/images/brand/favicon.png"
                                                                        ] : []
                                                                    ]
                                                                ]
                                                            ], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
                                                            $sendWebhook = (($readWebhooks["webhookCommentStatus"] == "1") ? webhooks($readWebhooks["webhookCommentAPI"], $hookObject) : "OK");
                                                            echo alert(languageVariables("alertSuccess", "blog", $languageType), "success", "3", "");
                                                        } else {
                                                            $readBanned = $bannedQuery->fetch();
                                                            if ($readBanned["bannedDate"] == "1000-01-01 00:00:00") {
                                                                $userBannedBackDate = languageVariables("indefinite", "words", $languageType);
                                                            } else {
                                                                $userBannedBackDate = max(round((strtotime($readBanned["bannedDate"]) - strtotime(date("Y-m-d H:i:s"))) / 86400), 0) . ' gün';
                                                            }
                                                            echo alert(str_replace(["&reason","&date"], [$readBanned["reason"],$userBannedBackDate], languageVariables("alertBan", "blog", $languageType)), "danger", "0", "/");
                                                        }
                                                    } else {
                                                        echo alert(languageVariables("alertNone", "blog", $languageType), "warning", "0", "/");
                                                    }
                                                } else {
                                                    echo alert(languageVariables("alertSystem", "blog", $languageType), "danger", "0", "/");
                                                }
                                            }
                                            ?>
                                            <form action="" method="POST" class="mb-5">
                                                <h3 class="text-secondary mb-3 font-100 font-size-6 letter-spacing-1 text-uppercase">
                                                    <?php echo languageVariables("comment", "blog", $languageType); ?>
                                                    <span class="comment-count o-50">
                                                    </span>
                                                </h3>
                                                <div class="input-group mb-3 flex-column bg-dark--5 border col-12 p-0 textarea-wrapper">
                                                    <label for="comment" class="o-100 d-block mb-0 text-white font-size-6 font-100 position-absolute"><i class="fas fa-envelope-open-text fa-xs mr-1"></i><?php echo languageVariables("commentMessage", "blog", $languageType); ?></label>
                                                    <input name="commentMessage" class="form-control mt-3 pt-0 text-white font-size-7 py-2 w-100 font-100 rounded-none" id="comment" rows="3">
                                                </div>
                                                <?php echo $safeCsrfToken->input("commentsToken"); ?>
                                                <button type="submit" class="btn text-white col-12 m-0 d-block line-height-1 text-uppercase letter-spacing-1 font-100 font-size-6 btn-outline-primary">
                                                    <i class="fas fa-paper-plane fa-sm mr-2 btn-icon"></i>
                                                    <span class="btn-text">
                                                      <?php echo languageVariables("send", "words", $languageType); ?>
                                                    </span>
                                                </button>
                                            </form>
                                        <?php } else { ?>
                                            <?php echo alert(languageVariables("alertLogin", "blog", $languageType), "warning", "0", "/"); ?>
                                        <?php } ?>
                                        <div class="comments-sent">
                                            <?php if ($searchNewsComment->rowCount() > 0) : ?>
                                                <?php foreach ($searchNewsComment as $readNewsComment) : ?>

                                                    <div class="mb-3 w-100 ticket-message text-white font-100 font-size-7">
                                                        <div class="ticket-message-header bg-dark--5 d-flex align-items-center position-relative overflow-hidden">
                                                            <div class="mc-skin left mr-0 pl-3 pt-3 ticket-skin">
                                                                <div class="mc-skin-img-wrapper js-mirror">
                                                                    <div class="mc-skin-img">
                                                                        <img src="https://minotar.net/body/<?php echo $readNewsComment["username"]; ?>/100.png" alt="<?php echo $readNewsComment["username"]; ?>">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="user-info d-flex flex-column flex-lg-row justify-content-lg-between align-items-lg-center w-100 px-4 py-3 mb-1">
                                                                <div class="block">
                                                                    <span class="d-block username font-size-8"><?php echo $readNewsComment["username"]; ?></span>
                                                                </div>
                                                                <span class="d-block date font-size-6 mr-lg-3 mt-2 mt-lg-0 o-25"><?php echo checkTime($readNewsComment["date"]); ?></span>
                                                            </div>
                                                        </div>
                                                        <div class="ticket-message-body p-3 bg-dark--4">
                                                            <p class="p-0 px-md-2 px-lg-1 m-0 font-size-7 font-100"><?php echo $readNewsComment["message"]; ?></p>
                                                        </div>
                                                    </div>
                                                <?php endforeach; ?>
                                            <?php else : ?>
                                                <?php echo alert(languageVariables("alertComment", "blog", $languageType), "warning", "0", "/"); ?>
                                            <?php endif; ?>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php } ?>