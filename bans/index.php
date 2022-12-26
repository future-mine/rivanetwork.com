<?php
require_once './inc/page.php';

$page = new Page("index");
$page->print_title();
?>
<div class="container">
    <div class="jumbotron">
        <div style="text-align:center;">
        </div>
    </div>
</div>
<?php $page->print_footer(false); ?>
