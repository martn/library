<?php //netteCache[01]000241a:2:{s:4:"time";s:21:"0.97236800 1295918913";s:9:"callbacks";a:1:{i:0;a:3:{i:0;a:2:{i:0;s:6:"NCache";i:1;s:9:"checkFile";}i:1;s:85:"C:\Users\Martin\Web\library\root\www/../app/FrontModule/templates/Users/default.phtml";i:2;i:1295195902;}}}?><?php
// file …/FrontModule/templates/Users/default.phtml
//

$_cb = NLatteMacros::initRuntime($template, true, '3d12b148c5'); unset($_extends);


//
// block left
//
if (!function_exists($_cb->blocks['left'][] = '_cbb831701b0db_left')) { function _cbb831701b0db_left($_args) { extract($_args)
;if (NSnippetHelper::$outputAllowed) { ?>
<h1><?php echo $template->translate("Uživatelé") ?></h1>
<?php } $control->getWidget("usersList")->render() ;if (NSnippetHelper::$outputAllowed) { } 
}}


//
// block right
//
if (!function_exists($_cb->blocks['right'][] = '_cbb8a899dedf9_right')) { function _cbb8a899dedf9_right($_args) { extract($_args)
;if (NSnippetHelper::$outputAllowed) { ?>
<h2><?php echo $template->translate("možnosti") ?></h2>
    <?php } $control->getWidget("defaultActionsMenu")->render() ;if (NSnippetHelper::$outputAllowed) { } 
}}

//
// end of blocks
//

if ($_cb->extends) { ob_start(); }

if (NSnippetHelper::$outputAllowed) {
} $_cb->extends = '../@doublepanel.phtml' ;if (NSnippetHelper::$outputAllowed) { }  if (NSnippetHelper::$outputAllowed) { ?>

<?php }  if (NSnippetHelper::$outputAllowed) { 
}

if ($_cb->extends) { ob_end_clean(); NLatteMacros::includeTemplate($_cb->extends, get_defined_vars(), $template)->render(); }
