<?php //netteCache[01]000250a:2:{s:4:"time";s:21:"0.02353200 1315245087";s:9:"callbacks";a:1:{i:0;a:3:{i:0;a:2:{i:0;s:6:"NCache";i:1;s:9:"checkFile";}i:1;s:94:"/Users/martin/Web/library/root/www/../app/FrontModule/templates/Sections/../@doublepanel.phtml";i:2;i:1295217604;}}}?><?php
// file …/FrontModule/templates/Sections/../@doublepanel.phtml
//

$_cb = NLatteMacros::initRuntime($template, true, '03b939537e'); unset($_extends);


//
// block content
//
if (!function_exists($_cb->blocks['content'][] = '_cbba002208ae2_content')) { function _cbba002208ae2_content($_args) { extract($_args)
;if (NSnippetHelper::$outputAllowed) { ?>
<div id="leftPanel">
<?php } if ($_cb->foo = NSnippetHelper::create($control, "flashes")) { $_cb->snippets[] = $_cb->foo ;foreach ($iterator = $_cb->its[] = new NSmartCachingIterator($flashes) as $flash): ?>
		<div class="flash flash_<?php echo NTemplateHelpers::escapeHtml($flash->type) ?>"><?php echo $flash->message ?></div>
<?php endforeach; array_pop($_cb->its); $iterator = end($_cb->its) ;array_pop($_cb->snippets)->finish(); } if (NSnippetHelper::$outputAllowed) { ?>
	<?php } NLatteMacros::callBlock($_cb->blocks, 'left', get_defined_vars()) ;if (NSnippetHelper::$outputAllowed) { ?>
</div>
<div id="rightPanel"><?php } call_user_func(reset($_cb->blocks['right']), get_defined_vars()) ;if (NSnippetHelper::$outputAllowed) { ?></div>
<?php
}}


//
// block right
//
if (!function_exists($_cb->blocks['right'][] = '_cbb36f6575ba9_right')) { function _cbb36f6575ba9_right($_args) { extract($_args)
;if (NSnippetHelper::$outputAllowed) { } 
}}

//
// end of blocks
//

if ($_cb->extends) { ob_start(); }

if (NSnippetHelper::$outputAllowed) {
} $_cb->extends = '@layout.phtml' ;if (NSnippetHelper::$outputAllowed) { }  
}

if ($_cb->extends) { ob_end_clean(); NLatteMacros::includeTemplate($_cb->extends, get_defined_vars(), $template)->render(); }
