<?php $themeSouthVariables = json_decode($readTheme["southVariables"], true);?>
<?php if (!isset($_SESSION["themeModeType"])) { $_SESSION["themeModeType"] = $themeSouthVariables["defaultColor"]; } ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <!-- META -->
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="author" content="Hasan ESKİSARAÇ">
    <title><?php echo metaTitle(); ?></title>
  <link rel="shortcut icon" href="<?php echo $rSettings['serverLogo']; ?>">
  <meta name="description" content="<?php echo $metaDescription; ?>" />
  <meta name="keywords" content="<?php echo $metaKeyword; ?>" />
  <link rel="canonical" href="<?php echo $siteURL; ?>" />
  <meta property="og:locale" content="<?php echo $languageType; ?>" />
  <meta property="og:type" content="website" />
  <meta property="og:title" content="<?php echo metaTitle(); ?>">
  <meta property="og:description" content="<?php echo $metaDescription; ?>">
  <meta property="og:url" content="<?php echo $siteURL; ?>" />
  <meta property="og:site_name" content="<?php echo $rSettings['serverName']; ?>" />
  
  <!-- STYLES -->
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.4.2/css/all.css" integrity="sha384-/rXc/GQVaYpyDdyxK+ecHPVYJSN9bmVFBvjA/9eOB+pb3F2w2N6fc5qB9Ew5yIns" crossorigin="anonymous">
  <?php if ($incRequirePage == "profile") { ?>
  <link rel="stylesheet" href="/main/includes/packages/layouts/dropimage/css/dropimage.min.css">
  <?php } ?>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/8.11.8/sweetalert2.min.css">
  
  <link rel="stylesheet" href="/main/themes/south/theme/sources/<?php echo $_SESSION["themeModeType"]; ?>/css/vendor/bootstrap.min.css">
  <link rel="stylesheet" href="/main/themes/south/theme/sources/<?php echo $_SESSION["themeModeType"]; ?>/css/<?php if ($_SESSION["themeModeType"] == "dark") { echo (($readTheme["themeColor"] == "0") ? "black-" : ""); } ?>style.min.css?v=<?php echo $_CONFIG["VERSION_NUMBER"]; ?>">
  <link rel="stylesheet" href="/main/themes/south/theme/sources/<?php echo $_SESSION["themeModeType"]; ?>/css/responsive.css?v=<?php echo $_CONFIG["VERSION_NUMBER"]; ?>">
  <link rel="stylesheet" href="/main/themes/south/theme/sources/<?php echo $_SESSION["themeModeType"]; ?>/css/vendor/simplebar.min.css?v=<?php echo $_CONFIG["VERSION_NUMBER"]; ?>">
  <link rel="stylesheet" href="/main/themes/south/theme/sources/<?php echo $_SESSION["themeModeType"]; ?>/css/vendor/tiny-slider.min.css?v=<?php echo $_CONFIG["VERSION_NUMBER"]; ?>">
</head>
<style type="text/css">
<?php if ($themeSouthVariables["bodyType"] == "0") { ?>
body {
    background-image: url('<?php echo $themeSouthVariables["bodyImage"]; ?>');
    background-repeat: no-repeat;
    background-position: center center;
    background-attachment: fixed;
    background-size: cover;
}
<?php } else if ($themeSouthVariables["bodyType"] == "1") { ?>
body {
    background: url('<?php echo $themeSouthVariables["bodyImage"]; ?>') repeat;
    background-size: 250px;
}
<?php } ?>
<?php echo $readTheme["CSS"]; ?>
.fa-lira-sign:before {content: '<?php echo languageVariables("currencyIcon", "words", $languageType); ?>' !important;}
</style>
<body>
  <?php if ($readModule["preloaderStatus"] == "1") { ?>
  <div class="page-loader">
    <div class="page-loader-decoration">
    	<img src="<?php echo $rSettings["serverLogo"]; ?>" height="40" alt="<?php echo $rSettings["serverName"]; ?>">
    </div>
    <div class="page-loader-info">
      <p class="page-loader-info-title"><?php echo $rSettings["serverName"]; ?></p>
      <p class="page-loader-info-text"><?php echo languageVariables("loading", "words", $languageType); ?></p>
    </div>
    <div class="page-loader-indicator loader-bars">
      <div class="loader-bar"></div>
      <div class="loader-bar"></div>
      <div class="loader-bar"></div>
      <div class="loader-bar"></div>
      <div class="loader-bar"></div>
      <div class="loader-bar"></div>
      <div class="loader-bar"></div>
      <div class="loader-bar"></div>
    </div>
  </div>
  <?php } ?>