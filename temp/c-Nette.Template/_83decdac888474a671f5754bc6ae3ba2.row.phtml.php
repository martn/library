<?php //netteCache[01]000253a:2:{s:4:"time";s:21:"0.92907600 1295909695";s:9:"callbacks";a:1:{i:0;a:3:{i:0;a:2:{i:0;s:6:"NCache";i:1;s:9:"checkFile";}i:1;s:97:"C:\Users\Martin\Web\library\root\app\components\Tables\TableBase\StructureRendererTable/row.phtml";i:2;i:1292940316;}}}?><?php
// file C:\Users\Martin\Web\library\root\app\components\Tables\TableBase\StructureRendererTable/row.phtml
//

$_cb = NLatteMacros::initRuntime($template, NULL, 'aa141751eb'); unset($_extends);

if (NSnippetHelper::$outputAllowed) {
?>
<tr class="tr<?php echo NTemplateHelpers::escapeHtml($control->getRowNumber()) ?>">
<?php foreach ($iterator = $_cb->its[] = new NSmartCachingIterator($columns) as $col): ?>
	<td <?php if ($iterator->first): ?>class="first"<?php endif ?>>
	<div class="innerDiv"><?php echo $control->renderCell($data, $col, $iterator) ?></div>
	</td>
<?php endforeach; array_pop($_cb->its); $iterator = end($_cb->its) ?>
	<td class="last"><div class="innerDiv"><?php echo $actions ?>&nbsp;</div></td>
</tr>    <?php
}
