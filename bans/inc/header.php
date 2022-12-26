<?php

class Header {
/**
 * @param $page Page
 */
function __construct($page) {
    $this->page = $page;
    if ($page->settings->header_show_totals) {
        $t = $page->settings->table;
        $t_bans = $t['bans'];
        $t_mutes = $t['mutes'];
        $t_warnings = $t['warnings'];
        $t_kicks = $t['kicks'];
        try {
            $st = $page->conn->query("SELECT
            (SELECT COUNT(*) FROM $t_bans) AS c_bans,
            (SELECT COUNT(*) FROM $t_mutes) AS c_mutes,
            (SELECT COUNT(*) FROM $t_warnings) AS c_warnings,
            (SELECT COUNT(*) FROM $t_kicks) AS c_kicks");
            ($row = $st->fetch(PDO::FETCH_ASSOC)) or die('Failed to fetch row counts.');
            $st->closeCursor();
            $this->count = array(
                'bans.php'     => $row['c_bans'],
                'mutes.php'    => $row['c_mutes'],
                'warnings.php' => $row['c_warnings'],
                'kicks.php'    => $row['c_kicks'],
            );
        } catch (PDOException $ex) {
            Settings::handle_error($page->settings, $ex);
        }
    }
}

function navbar($links) {
    echo '<ul class="nav navbar-nav">';
    foreach ($links as $page => $title) {
        $li = "li";
        if ((substr($_SERVER['SCRIPT_NAME'], -strlen($page))) === $page) {
            $li .= ' class="active"';
        }
        if ($this->page->settings->header_show_totals && isset($this->count[$page])) {
            $title .= " <span class=\"badge\">";
            $title .= $this->count[$page];
            $title .= "</span>";
        }
        echo "<$li><a href=\"$page\">$title</a></li>";
    }
    echo '</ul>';
}

function autoversion($file) {
    return $file . "?" . filemtime($file);
}

function print_header() {
$settings = $this->page->settings;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="Necati Mert">
    <link rel="shortcut icon" href="inc/img/minecraft.ico">
    <link rel="stylesheet" type="text/css" href="inc/css/font-awesome.css">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:700" rel="stylesheet">
    <link href="<?php echo $this->autoversion('inc/css/bootstrap.min.css'); ?>" rel="stylesheet">
    <link href="<?php echo $this->autoversion('inc/css/custom.css'); ?>" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans" rel="stylesheet">
    <script type="text/javascript">
        function withjQuery(f) {
            if (window.jQuery) f();
            else window.setTimeout(function () {
                withjQuery(f);
            }, 100);
        }
    </script>
</head>
<div class="logo">        
    <img src="https://www.wizzardworlds.ru/assets/uploads/images/landing/logo/x4I5C8k1Z3R10.png"></img>
</div>
    <div class="navigation">
        <ul>
             <a href="index.php"><i class="fa fa-home"></i> HOME</a>
             <a href="bans.php"><i class="fa fa-ban"></i> BANS</a>
             <a href="kicks.php"><i class="fa fa-link" aria-hidden="true"></i>KICKS</a>
             <a href="mutes.php"><i class="fa fa-microphone-slash" aria-hidden="true"></i> MUTES</a>
             
       </ul>
    </div>
</div>

</header>

<?php
}
}
?>