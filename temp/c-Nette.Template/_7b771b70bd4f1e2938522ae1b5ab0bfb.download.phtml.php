<?php //netteCache[01]000241a:2:{s:4:"time";s:21:"0.50789700 1295909441";s:9:"callbacks";a:1:{i:0;a:3:{i:0;a:2:{i:0;s:6:"NCache";i:1;s:9:"checkFile";}i:1;s:85:"C:\Users\Martin\Web\library\root\www/../app/FrontModule/templates/File/download.phtml";i:2;i:1295909438;}}}?><?php
// file …/FrontModule/templates/File/download.phtml
//

$_cb = NLatteMacros::initRuntime($template, true, 'f596c6ebad'); unset($_extends);


//
// block panel
//
if (!function_exists($_cb->blocks['panel'][] = '_cbb05ebab79d5_panel')) { function _cbb05ebab79d5_panel($_args) { extract($_args)
;if (NSnippetHelper::$outputAllowed) { ?>
<h1><?php echo $template->translate("Stažení souboru") ?></h1>

<?php } 
}}

//
// end of blocks
//

if ($_cb->extends) { ob_start(); }

if (NSnippetHelper::$outputAllowed) {
} $_cb->extends = '../@singlepanel.phtml' ;if (NSnippetHelper::$outputAllowed) { }  if (NSnippetHelper::$outputAllowed) { 
}

if ($_cb->extends) { ob_end_clean(); NLatteMacros::includeTemplate($_cb->extends, get_defined_vars(), $template)->render(); }
