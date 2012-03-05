<?php //netteCache[01]000238a:2:{s:4:"time";s:21:"0.53933700 1315299424";s:9:"callbacks";a:1:{i:0;a:3:{i:0;a:2:{i:0;s:6:"NCache";i:1;s:9:"checkFile";}i:1;s:82:"/Users/martin/Web/library/root/www/../app/FrontModule/templates/Sections/new.phtml";i:2;i:1295217560;}}}?><?php
// file …/FrontModule/templates/Sections/new.phtml
//

$_cb = NLatteMacros::initRuntime($template, true, '5bc95c4a93'); unset($_extends);


//
// block left
//
if (!function_exists($_cb->blocks['left'][] = '_cbb8926a2032a_left')) { function _cbb8926a2032a_left($_args) { extract($_args)
;if (NSnippetHelper::$outputAllowed) { ?>
    <h1><?php echo $template->translate("Nová sekce") ?></h1>
    
    <?php } $control->getWidget("formNew")->render() ;if (NSnippetHelper::$outputAllowed) { } 
}}

//
// end of blocks
//

if ($_cb->extends) { ob_start(); }

if (NSnippetHelper::$outputAllowed) {
} $_cb->extends = '../@doublepanel.phtml' ;if (NSnippetHelper::$outputAllowed) { }  if (NSnippetHelper::$outputAllowed) { 
}

if ($_cb->extends) { ob_end_clean(); NLatteMacros::includeTemplate($_cb->extends, get_defined_vars(), $template)->render(); }
