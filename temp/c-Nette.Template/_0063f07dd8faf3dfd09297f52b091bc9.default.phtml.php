<?php //netteCache[01]000241a:2:{s:4:"time";s:21:"0.43940100 1295955721";s:9:"callbacks";a:1:{i:0;a:3:{i:0;a:2:{i:0;s:6:"NCache";i:1;s:9:"checkFile";}i:1;s:85:"C:\Users\Martin\Web\library\root\www/../app/FrontModule/templates/Types/default.phtml";i:2;i:1295198966;}}}?><?php
// file …/FrontModule/templates/Types/default.phtml
//

$_cb = NLatteMacros::initRuntime($template, true, 'bc5c3c45d4'); unset($_extends);


//
// block left
//
if (!function_exists($_cb->blocks['left'][] = '_cbb09838b022b_left')) { function _cbb09838b022b_left($_args) { extract($_args)
;if (NSnippetHelper::$outputAllowed) { ?>
<h1><?php echo $template->translate("Definice typů") ?></h1>

<?php $control->getWidget("tableTypes")->render() ;} 
}}


//
// block right
//
if (!function_exists($_cb->blocks['right'][] = '_cbbe8caa549d8_right')) { function _cbbe8caa549d8_right($_args) { extract($_args)
;if (NSnippetHelper::$outputAllowed) { ?>
<h2>Možnosti</h2>
<?php $control->getWidget("defaultActionsMenu")->render() ;} 
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
