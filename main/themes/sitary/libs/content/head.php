<?php $themeSitaryVariables = json_decode($readTheme["sitaryVariables"], true);?>
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
  <?php if ($incRequirePage == "profile") { ?>
  <link rel="stylesheet" href="/main/includes/packages/layouts/dropimage/css/dropimage.min.css">
  <?php } ?>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/8.11.8/sweetalert2.min.css">
  <style type="text/css">:root {--sitary-primary-400: <?php echo $themeSitaryVariables["color"]["400"]; ?>;--sitary-primary-500: <?php echo $themeSitaryVariables["color"]["500"]; ?>;}</style>
  <link rel="stylesheet" href="/main/themes/sitary/theme/assets/css/vendor/bootstrap.min.css">
  <link rel="stylesheet" href="/main/themes/sitary/theme/assets/css/style.min.css?v=<?php echo $_CONFIG["VERSION_NUMBER"]."72"; ?>">
  <link rel="stylesheet" href="/main/themes/sitary/theme/assets/css/responsive.css?v=<?php echo $_CONFIG["VERSION_NUMBER"]; ?>">
  <link rel="stylesheet" href="/main/themes/sitary/theme/assets/css/vendor/simplebar.min.css?v=<?php echo $_CONFIG["VERSION_NUMBER"]; ?>">
  <link rel="stylesheet" href="/main/themes/sitary/theme/assets/css/vendor/tiny-slider.min.css?v=<?php echo $_CONFIG["VERSION_NUMBER"]; ?>">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css" integrity="sha512-xh6O/CkQoPOWDdYTDqeRdPCVd1SpvCA9XXcUnZS2FmJNp1coAFzvtCN9BmamE+4aHK8yyUHUSCcJHgXloTyT2A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
  <link rel="stylesheet" type="text/css" href="https://cdn.materialdesignicons.com/3.5.95/css/materialdesignicons.min.css" />
</head>
<style type="text/css">
<?php if ($themeSitaryVariables["bodyType"] == "0") { ?>
body {
    background-image: url('<?php echo $themeSitaryVariables["bodyImage"]; ?>');
    background-repeat: no-repeat;
    background-position: center center;
    background-attachment: fixed;
    background-size: cover;
}
<?php } else if ($themeSitaryVariables["bodyType"] == "1") { ?>
body {
    background: url('<?php echo $themeSitaryVariables["bodyImage"]; ?>') repeat;
    background-size: 250px;
}
<?php } ?>
<?php echo $readTheme["CSS"]; ?>
.select-none{-webkit-user-select:none;-moz-user-select:none;-ms-user-select:none;user-select:none}
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
    <div class="page-loader-indicator">
      <div class="loader">
        <div class="loader-shap"></div>
        <div class="loader-shap"></div>
        <div class="loader-shap"></div>
      </div>
    </div>
  </div>
  <?php } ?>