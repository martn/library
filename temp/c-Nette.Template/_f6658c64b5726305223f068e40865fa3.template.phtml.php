<?php //netteCache[01]000235a:2:{s:4:"time";s:21:"0.43533500 1314729275";s:9:"callbacks";a:1:{i:0;a:3:{i:0;a:2:{i:0;s:6:"NCache";i:1;s:9:"checkFile";}i:1;s:79:"/Users/martin/Web/library/root/libs/Nette.Extras/VisualPaginator/template.phtml";i:2;i:1314729259;}}}?><?php
// file /Users/martin/Web/library/root/libs/Nette.Extras/VisualPaginator/template.phtml
//

$_cb = NLatteMacros::initRuntime($template, NULL, '974c2d941f'); unset($_extends);

if (NSnippetHelper::$outputAllowed) {
if ($paginator->pageCount > 1): ?>
<div class="paginator">
<?php if ($paginator->isFirst()): ?>
	<span class="empty">« Předchozí</span>
<?php else: ?>
	<a href="<?php echo NTemplateHelpers::escapeHtml($control->link("this", array('page' => $paginator->page - 1))) ?>">« Předchozí</a>
<?php endif ?>

<?php foreach ($iterator = $_cb->its[] = new NSmartCachingIterator($steps) as $step): if ($step == $paginator->page): ?>
		<span class="current"><?php echo NTemplateHelpers::escapeHtml($step) ?></span>
<?php else: ?>
		<a href="<?php echo NTemplateHelpers::escapeHtml($control->link("this", array('page' => $step))) ?>"><?php echo NTemplateHelpers::escapeHtml($step) ?></a>
<?php endif ?>
	<?php if ($iterator->nextValue > $step + 1): ?><span>…</span><?php endif ?>

<?php endforeach; array_pop($_cb->its); $iterator = end($_cb->its) ?>

<?php if ($paginator->isLast()): ?>
	<span class="empty">Další »</span>
<?php else: ?>
	<a href="<?php echo NTemplateHelpers::escapeHtml($control->link("this", array('page' => $paginator->page + 1))) ?>">Další »</a>
<?php endif ?>
</div>
<?php endif ;
}
