<?php //netteCache[01]000242a:2:{s:4:"time";s:21:"0.01534500 1315245087";s:9:"callbacks";a:1:{i:0;a:3:{i:0;a:2:{i:0;s:6:"NCache";i:1;s:9:"checkFile";}i:1;s:86:"/Users/martin/Web/library/root/www/../app/FrontModule/templates/Sections/default.phtml";i:2;i:1295217538;}}}?><?php
// file …/FrontModule/templates/Sections/default.phtml
//

$_cb = NLatteMacros::initRuntime($template, true, '5c3ce29ea4'); unset($_extends);


//
// block left
//
if (!function_exists($_cb->blocks['left'][] = '_cbb2af5a8f63f_left')) { function _cbb2af5a8f63f_left($_args) { extract($_args)
;if (NSnippetHelper::$outputAllowed) { ?>
    <h1><?php echo $template->translate("Sekce") ?></h1>
    
   
<?php } $control->getWidget("sectionsTable")->render() ;if (NSnippetHelper::$outputAllowed) { ?>
   
<?php } 
}}


//
// block right
//
if (!function_exists($_cb->blocks['right'][] = '_cbbb50a0094df_right')) { function _cbbb50a0094df_right($_args) { extract($_args)
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
