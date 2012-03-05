<?php //netteCache[01]000247a:2:{s:4:"time";s:21:"0.99324300 1314728152";s:9:"callbacks";a:1:{i:0;a:3:{i:0;a:2:{i:0;s:6:"NCache";i:1;s:9:"checkFile";}i:1;s:91:"/Users/martin/Web/library/root/app/components/Tables/TableBase/ManualContentTable/row.phtml";i:2;i:1268435444;}}}?><?php
// file /Users/martin/Web/library/root/app/components/Tables/TableBase/ManualContentTable/row.phtml
//

$_cb = NLatteMacros::initRuntime($template, NULL, '6a8a7ce846'); unset($_extends);

if (NSnippetHelper::$outputAllowed) {
?>
<tr class="tr<?php echo NTemplateHelpers::escapeHtml($control->getRowNumber()) ?>">
<?php foreach ($iterator = $_cb->its[] = new NSmartCachingIterator($data) as $col): ?>
	<td <?php if ($iterator->first): ?>class="first"<?php endif ?>>
	<div class="innerDiv"><?php echo NTemplateHelpers::escapeHtml($col) ?></div>
	</td>
<?php endforeach; array_pop($_cb->its); $iterator = end($_cb->its) ;for ($i=0;$i<$overhead;$i++): ?><td>&nbsp;</td><?php endfor ?>

	<td class="last">&nbsp;</td>
</tr>    <?php
}
