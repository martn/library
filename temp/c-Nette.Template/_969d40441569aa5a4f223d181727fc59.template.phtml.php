<?php //netteCache[01]000246a:2:{s:4:"time";s:21:"0.43276800 1314776164";s:9:"callbacks";a:1:{i:0;a:3:{i:0;a:2:{i:0;s:6:"NCache";i:1;s:9:"checkFile";}i:1;s:90:"/Users/martin/Web/library/root/app/components/Tables/DataView/DataTableView/template.phtml";i:2;i:1295932744;}}}?><?php
// file /Users/martin/Web/library/root/app/components/Tables/DataView/DataTableView/template.phtml
//

$_cb = NLatteMacros::initRuntime($template, NULL, '3f2206aa50'); unset($_extends);

if (NSnippetHelper::$outputAllowed) {
?>
<table cellpadding="0" cellspacing="0" border="0" class="dataTable">
<?php foreach ($iterator = $_cb->its[] = new NSmartCachingIterator($data) as $group): ?>
<tr><td class="group-name"><?php echo NTemplateHelpers::escapeHtml($group->getName()) ?></td></tr>
<tr>
<?php foreach ($iterator = $_cb->its[] = new NSmartCachingIterator($group) as $item): ?>
        <td class="item">
            <div class="label"><?php echo NTemplateHelpers::escapeHtml($item['label']) ?>:</div>
            <div class="data"><?php echo NTemplateHelpers::escapeHtml($item['data']) ?></div>
        </td>
<?php endforeach; array_pop($_cb->its); $iterator = end($_cb->its) ?>
</tr>
<?php endforeach; array_pop($_cb->its); $iterator = end($_cb->its) ?>
</table><?php
}
