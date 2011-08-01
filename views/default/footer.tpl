</div>

<?php echo ads_manager::get_ads_block('all_pages_down', '<div class="adv bot">', '</div>') ?>

<div class="copy"><a href="<?php echo URL ?>"><?php echo date('Y', time()) ?> &copy; <?php echo $GLOBALS['CONFIG']['system']['system_title'] ?></a><?php if (modules::is_active_module('web_version')) echo ' [<a href="'. URL .'?version=web">WEB версия</a>]' ?></div>

<?php if (!empty($GLOBALS['CONFIG']['system']['footer_codes_index']) or !empty($GLOBALS['CONFIG']['system']['footer_codes_other_pages'])): ?>
<div class="block">
<?php
if(ROUTE_MODULE == 'index_page') echo $GLOBALS['CONFIG']['system']['footer_codes_index'];
else echo $GLOBALS['CONFIG']['system']['footer_codes_other_pages'];
?>
</div>
<?php endif ?>

<!-- copyright -->

</body>
</html>