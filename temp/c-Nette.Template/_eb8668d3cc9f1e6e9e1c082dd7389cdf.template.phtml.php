<?php //netteCache[01]000248a:2:{s:4:"time";s:21:"0.76247400 1295911179";s:9:"callbacks";a:1:{i:0;a:3:{i:0;a:2:{i:0;s:6:"NCache";i:1;s:9:"checkFile";}i:1;s:92:"C:\Users\Martin\Web\library\root\app\components\Tables\DataView\DataTableView/template.phtml";i:2;i:1295911143;}}}?><?php
// file C:\Users\Martin\Web\library\root\app\components\Tables\DataView\DataTableView/template.phtml
//

$_cb = NLatteMacros::initRuntime($template, NULL, 'f13e96f880'); unset($_extends);

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
