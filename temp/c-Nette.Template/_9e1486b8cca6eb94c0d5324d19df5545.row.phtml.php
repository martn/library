<?php //netteCache[01]000251a:2:{s:4:"time";s:21:"0.15754600 1314728131";s:9:"callbacks";a:1:{i:0;a:3:{i:0;a:2:{i:0;s:6:"NCache";i:1;s:9:"checkFile";}i:1;s:95:"/Users/martin/Web/library/root/app/components/Tables/TableBase/StructureRendererTable/row.phtml";i:2;i:1292961916;}}}?><?php
// file /Users/martin/Web/library/root/app/components/Tables/TableBase/StructureRendererTable/row.phtml
//

$_cb = NLatteMacros::initRuntime($template, NULL, 'dc69e47480'); unset($_extends);

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
