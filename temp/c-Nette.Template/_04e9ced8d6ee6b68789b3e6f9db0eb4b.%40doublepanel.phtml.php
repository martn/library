<?php //netteCache[01]000248a:2:{s:4:"time";s:21:"0.73848000 1295942399";s:9:"callbacks";a:1:{i:0;a:3:{i:0;a:2:{i:0;s:6:"NCache";i:1;s:9:"checkFile";}i:1;s:92:"C:\Users\Martin\Web\library\root\www/../app/FrontModule/templates/Maps/../@doublepanel.phtml";i:2;i:1295196004;}}}?><?php
// file …/FrontModule/templates/Maps/../@doublepanel.phtml
//

$_cb = NLatteMacros::initRuntime($template, true, '39a2a6450b'); unset($_extends);


//
// block content
//
if (!function_exists($_cb->blocks['content'][] = '_cbbbac7844a41_content')) { function _cbbbac7844a41_content($_args) { extract($_args)
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
if (!function_exists($_cb->blocks['right'][] = '_cbb1365fa81c0_right')) { function _cbb1365fa81c0_right($_args) { extract($_args)
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
