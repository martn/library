<?php //netteCache[01]000252a:2:{s:4:"time";s:21:"0.14667300 1315299131";s:9:"callbacks";a:1:{i:0;a:3:{i:0;a:2:{i:0;s:6:"NCache";i:1;s:9:"checkFile";}i:1;s:96:"/Users/martin/Web/library/root/app/components/Tables/TableBase/StructureRendererTable/head.phtml";i:2;i:1315299127;}}}?><?php
// file /Users/martin/Web/library/root/app/components/Tables/TableBase/StructureRendererTable/head.phtml
//

$_cb = NLatteMacros::initRuntime($template, NULL, '7fb528a810'); unset($_extends);

if (NSnippetHelper::$outputAllowed) {
if ($control->paginator): ?><tr><td colspan="<?php echo NTemplateHelpers::escapeHtml($columns->count()) ?>"><?php $control->getWidget("vp")->render() ?></td></tr><?php endif ?>

<tr>
<?php foreach ($iterator = $_cb->its[] = new NSmartCachingIterator($columns) as $col): ?>
    <th <?php if ($iterator->first): ?>class="first"<?php endif ?>><?php echo NTemplateHelpers::escapeHtml($col['label']) ?></th>
<?php endforeach; array_pop($_cb->its); $iterator = end($_cb->its) ?>
    <th class="last">&nbsp;</th>
</tr><?php
}
