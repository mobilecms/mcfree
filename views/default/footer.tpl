</div>

<?php if (ROUTE_MODULE == 'index_page'): ?>
<?php echo ads_manager::get_ads_block('index_page_down', '<div class="adv">', '</div>') ?>
<?php else: ?>
<?php echo ads_manager::get_ads_block('other_pages_down', '<div class="adv">', '</div>') ?>
<?php endif ?>

<div class="copy"><?php echo date('Y', time()) ?> &copy; <a href="<?php echo URL ?>"><?php echo $GLOBALS['CONFIG']['system']['system_title'] ?></a></div>

<?php if (!empty($GLOBALS['CONFIG']['system']['footer_codes_index']) OR !empty($GLOBALS['CONFIG']['system']['footer_codes_other_pages'])): ?>
<div class="block">
<?php
if (ROUTE_MODULE == 'index_page') echo $GLOBALS['CONFIG']['system']['footer_codes_index'];
else echo $GLOBALS['CONFIG']['system']['footer_codes_other_pages'];
?>
</div>
<?php endif ?>

<!-- copyright -->

</body>
</html>