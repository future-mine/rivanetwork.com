<?php
	define('__ROOT__', $_SERVER['DOCUMENT_ROOT']);
	require_once(__ROOT__.'/main/includes/php/settings.php');
    header("Content-type: text/xml");
	$url  = ((isset($_SERVER["HTTPS"]) && $_SERVER["HTTPS"] === 'on' ? "https" : "http")."://".$_SERVER["SERVER_NAME"]);
    $date = date('Y-m-d\TH:i:s+03:00');
?>
<?php echo "<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n"; ?>
<urlset xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:image="http://www.google.com/schemas/sitemap-image/1.1"
	xsi:schemaLocation="http://www.sitemaps.org/schemas/sitemap/0.9 http://www.sitemaps.org/schemas/sitemap/0.9/sitemap.xsd http://www.google.com/schemas/sitemap-image/1.1 http://www.google.com/schemas/sitemap-image/1.1/sitemap-image.xsd"
	xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
	<url>
		<loc><?php echo $url; ?>/anasayfa</loc>
		<lastmod><?php echo $date; ?></lastmod>
	</url>
    <url>
		<loc><?php echo $url; ?>/magaza</loc>
		<lastmod><?php echo $date; ?></lastmod>
	</url>
	<url>
		<loc><?php echo $url; ?>/kredi/yukle</loc>
		<lastmod><?php echo $date; ?></lastmod>
	</url>
    <url>
		<loc><?php echo $url; ?>/destek</loc>
		<lastmod><?php echo $date; ?></lastmod>
	</url>
	<url>
		<loc><?php echo $url; ?>/profil</loc>
		<lastmod><?php echo $date; ?></lastmod>
	</url>
	<url>
		<loc><?php echo $url; ?>/giris-yap</loc>
		<lastmod><?php echo $date; ?></lastmod>
	</url>
	<url>
		<loc><?php echo $url; ?>/kayit-ol</loc>
		<lastmod><?php echo $date; ?></lastmod>
	</url>
	<url>
		<loc><?php echo $url; ?>/sifremi-unuttum</loc>
		<lastmod><?php echo $date; ?></lastmod>
	</url>
	<?php
    $news = $db->query("SELECT * FROM newsList ORDER BY id DESC");
    ?>
	<?php if ($news->rowCount() > 0) : ?>
		<?php foreach ($news as $readNews) : ?>
			<url>
				<loc><?php echo $url; ?>/haber/<?php echo createSlug($readNews["title"])."/".$readNews["id"]; ?></loc>
				<lastmod><?php echo $date; ?></lastmod>
				<image:image>
					<image:loc><?php echo $url.$readNews["image"]; ?></image:loc>
					<image:title>
						<![CDATA[<?php echo $readNews["title"]; ?>]]>
					</image:title>
				</image:image>
			</url>
		<?php endforeach; ?>
	<?php endif; ?>
</urlset>
