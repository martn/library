<?php //netteCache[01]000224a:2:{s:4:"time";s:21:"0.94287500 1295909695";s:9:"callbacks";a:1:{i:0;a:3:{i:0;a:2:{i:0;s:6:"NCache";i:1;s:9:"checkFile";}i:1;s:68:"C:\Users\Martin\Web\library\root\app\components\QuickMenu/menu.phtml";i:2;i:1267095748;}}}?><?php
// file C:\Users\Martin\Web\library\root\app\components\QuickMenu/menu.phtml
//

$_cb = NLatteMacros::initRuntime($template, NULL, '46a70c0f33'); unset($_extends);

if (NSnippetHelper::$outputAllowed) {
?>
<div class="quickmenu <?php echo NTemplateHelpers::escapeHtml($class) ?>">
<ul>
<?php foreach ($iterator = $_cb->its[] = new NSmartCachingIterator($data) as $item): ?>
<li><?php echo $item['element'] ?></li>
<?php endforeach; array_pop($_cb->its); $iterator = end($_cb->its) ?>
</ul>
</div><?php
}
