<?php //netteCache[01]000249a:2:{s:4:"time";s:21:"0.98859100 1314728124";s:9:"callbacks";a:1:{i:0;a:3:{i:0;a:2:{i:0;s:6:"NCache";i:1;s:9:"checkFile";}i:1;s:93:"/Users/martin/Web/library/root/www/../app/FrontModule/templates/Default/../@singlepanel.phtml";i:2;i:1295800336;}}}?><?php
// file …/FrontModule/templates/Default/../@singlepanel.phtml
//

$_cb = NLatteMacros::initRuntime($template, true, '1108ae57c0'); unset($_extends);


//
// block content
//
if (!function_exists($_cb->blocks['content'][] = '_cbb89fdc17d4a_content')) { function _cbb89fdc17d4a_content($_args) { extract($_args)
;if (NSnippetHelper::$outputAllowed) { ?>
	<div id="panel">
	<?php } if ($_cb->foo = NSnippetHelper::create($control, "flashes")) { $_cb->snippets[] = $_cb->foo ?> <?php foreach ($iterator = $_cb->its[] = new NSmartCachingIterator($flashes) as $flash): ?>

		<div class="flash flash_<?php echo NTemplateHelpers::escapeHtml($flash->type) ?>"><?php echo $flash->message ?></div>
	<?php endforeach; array_pop($_cb->its); $iterator = end($_cb->its) ?> <?php array_pop($_cb->snippets)->finish(); } if (NSnippetHelper::$outputAllowed) { ?>

	<?php } NLatteMacros::callBlock($_cb->blocks, 'panel', get_defined_vars()) ;if (NSnippetHelper::$outputAllowed) { ?>
	</div>
<?php
}}

//
// end of blocks
//

if ($_cb->extends) { ob_start(); }

if (NSnippetHelper::$outputAllowed) {
} $_cb->extends = '@layout.phtml' ;if (NSnippetHelper::$outputAllowed) { ?> 
<?php }  
}

if ($_cb->extends) { ob_end_clean(); NLatteMacros::includeTemplate($_cb->extends, get_defined_vars(), $template)->render(); }
