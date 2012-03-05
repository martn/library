<?php //netteCache[01]000240a:2:{s:4:"time";s:21:"0.24494000 1295941393";s:9:"callbacks";a:1:{i:0;a:3:{i:0;a:2:{i:0;s:6:"NCache";i:1;s:9:"checkFile";}i:1;s:84:"C:\Users\Martin\Web\library\root\www/../app/FrontModule/templates/Sections/new.phtml";i:2;i:1295195960;}}}?><?php
// file …/FrontModule/templates/Sections/new.phtml
//

$_cb = NLatteMacros::initRuntime($template, true, 'dbac2450fe'); unset($_extends);


//
// block left
//
if (!function_exists($_cb->blocks['left'][] = '_cbb52b0329fa6_left')) { function _cbb52b0329fa6_left($_args) { extract($_args)
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
