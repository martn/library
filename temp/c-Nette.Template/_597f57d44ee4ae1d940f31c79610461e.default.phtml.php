<?php //netteCache[01]000244a:2:{s:4:"time";s:21:"0.32457600 1295917678";s:9:"callbacks";a:1:{i:0;a:3:{i:0;a:2:{i:0;s:6:"NCache";i:1;s:9:"checkFile";}i:1;s:88:"C:\Users\Martin\Web\library\root\www/../app/FrontModule/templates/Sections/default.phtml";i:2;i:1295195938;}}}?><?php
// file …/FrontModule/templates/Sections/default.phtml
//

$_cb = NLatteMacros::initRuntime($template, true, 'd9cb9bf8f7'); unset($_extends);


//
// block left
//
if (!function_exists($_cb->blocks['left'][] = '_cbbd4c9ce7a97_left')) { function _cbbd4c9ce7a97_left($_args) { extract($_args)
;if (NSnippetHelper::$outputAllowed) { ?>
    <h1><?php echo $template->translate("Sekce") ?></h1>
    
   
<?php } $control->getWidget("sectionsTable")->render() ;if (NSnippetHelper::$outputAllowed) { ?>
   
<?php } 
}}


//
// block right
//
if (!function_exists($_cb->blocks['right'][] = '_cbbe0dae31252_right')) { function _cbbe0dae31252_right($_args) { extract($_args)
;if (NSnippetHelper::$outputAllowed) { ?>
<h2><?php echo $template->translate("možnosti") ?></h2>

    <?php } $control->getWidget("defaultActionsMenu")->render() ;if (NSnippetHelper::$outputAllowed) { ?>
   
<?php } 
}}

//
// end of blocks
//

if ($_cb->extends) { ob_start(); }

if (NSnippetHelper::$outputAllowed) {
} $_cb->extends = '../@doublepanel.phtml' ;if (NSnippetHelper::$outputAllowed) { }  if (NSnippetHelper::$outputAllowed) { }  if (NSnippetHelper::$outputAllowed) { 
}

if ($_cb->extends) { ob_end_clean(); NLatteMacros::includeTemplate($_cb->extends, get_defined_vars(), $template)->render(); }
