<?php //netteCache[01]000231a:2:{s:4:"time";s:21:"0.99914300 1315125203";s:9:"callbacks";a:1:{i:0;a:3:{i:0;a:2:{i:0;s:6:"NCache";i:1;s:9:"checkFile";}i:1;s:75:"/Users/martin/Web/library/root/app/components/Tables/GroupDsTable/row.phtml";i:2;i:1295408290;}}}?><?php
// file /Users/martin/Web/library/root/app/components/Tables/GroupDsTable/row.phtml
//

$_cb = NLatteMacros::initRuntime($template, NULL, '11040f9fc5'); unset($_extends);

if (NSnippetHelper::$outputAllowed) {
?>
<tr class="tr">
	<td class="first"><div class="innerDiv"><?php echo $actions ?>&nbsp;</div></td>
<?php foreach ($iterator = $_cb->its[] = new NSmartCachingIterator($columns) as $col): ?>
	<td <?php if ($iterator->first): ?>class="first"<?php endif ?>>
	<div class="innerDiv"><?php echo $control->renderCell($data, $col, $iterator) ?></div>
	</td>
<?php endforeach; array_pop($_cb->its); $iterator = end($_cb->its) ?>
</tr>  
<tr><td colspan="500"><?php $control->renderList() ?>

    <br/>
    <hr/>
    <br/>
    </td></tr>

 <?php
}
