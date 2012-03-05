<?php //netteCache[01]000254a:2:{s:4:"time";s:21:"0.89982200 1295909695";s:9:"callbacks";a:1:{i:0;a:3:{i:0;a:2:{i:0;s:6:"NCache";i:1;s:9:"checkFile";}i:1;s:98:"C:\Users\Martin\Web\library\root\app\components\Tables\TableBase\StructureRendererTable/head.phtml";i:2;i:1268245074;}}}?><?php
// file C:\Users\Martin\Web\library\root\app\components\Tables\TableBase\StructureRendererTable/head.phtml
//

$_cb = NLatteMacros::initRuntime($template, NULL, '2c3585ba2c'); unset($_extends);

if (NSnippetHelper::$outputAllowed) {
?>
<tr>
<?php foreach ($iterator = $_cb->its[] = new NSmartCachingIterator($columns) as $col): ?>
    <th <?php if ($iterator->first): ?>class="first"<?php endif ?>><?php echo NTemplateHelpers::escapeHtml($col['label']) ?></th>
<?php endforeach; array_pop($_cb->its); $iterator = end($_cb->its) ?>
    <th class="last">&nbsp;</th>
</tr><?php
}
