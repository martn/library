<?php //netteCache[01]000222a:2:{s:4:"time";s:21:"0.79702400 1314727401";s:9:"callbacks";a:1:{i:0;a:3:{i:0;a:2:{i:0;s:6:"NCache";i:1;s:9:"checkFile";}i:1;s:66:"/Users/martin/Web/library/root/app/components/QuickMenu/menu.phtml";i:2;i:1267117348;}}}?><?php
// file /Users/martin/Web/library/root/app/components/QuickMenu/menu.phtml
//

$_cb = NLatteMacros::initRuntime($template, NULL, '93ba6e5c35'); unset($_extends);

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
