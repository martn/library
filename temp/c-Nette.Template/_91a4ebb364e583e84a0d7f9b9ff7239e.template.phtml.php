<?php //netteCache[01]000246a:2:{s:4:"time";s:21:"0.36390300 1314776164";s:9:"callbacks";a:1:{i:0;a:3:{i:0;a:2:{i:0;s:6:"NCache";i:1;s:9:"checkFile";}i:1;s:90:"/Users/martin/Web/library/root/app/components/Tables/DataView/DataBoxesView/template.phtml";i:2;i:1295923458;}}}?><?php
// file /Users/martin/Web/library/root/app/components/Tables/DataView/DataBoxesView/template.phtml
//

$_cb = NLatteMacros::initRuntime($template, NULL, '68a03c9ba9'); unset($_extends);

if (NSnippetHelper::$outputAllowed) {
?>
<div class="dataBoxes">
<?php foreach ($iterator = $_cb->its[] = new NSmartCachingIterator($data) as $group): ?>
<fieldset>
    <legend><?php echo NTemplateHelpers::escapeHtml($group->getName()) ?></legend>
<?php foreach ($iterator = $_cb->its[] = new NSmartCachingIterator($group) as $item): ?>
        <div class="item">
            <div class="label"><?php echo NTemplateHelpers::escapeHtml($item['label']) ?>:</div>
            <div class="data"><?php echo NTemplateHelpers::escapeHtml($item['data']) ?></div>
        </div>
<?php endforeach; array_pop($_cb->its); $iterator = end($_cb->its) ?>
</fieldset>
<?php endforeach; array_pop($_cb->its); $iterator = end($_cb->its) ?>
</div><?php
}
