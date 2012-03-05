<?php //netteCache[01]000240a:2:{s:4:"time";s:21:"0.71678400 1295942399";s:9:"callbacks";a:1:{i:0;a:3:{i:0;a:2:{i:0;s:6:"NCache";i:1;s:9:"checkFile";}i:1;s:84:"C:\Users\Martin\Web\library\root\www/../app/FrontModule/templates/Maps/default.phtml";i:2;i:1294312932;}}}?><?php
// file …/FrontModule/templates/Maps/default.phtml
//

$_cb = NLatteMacros::initRuntime($template, true, 'fb440c1dc8'); unset($_extends);


//
// block left
//
if (!function_exists($_cb->blocks['left'][] = '_cbb2027e2eaa5_left')) { function _cbb2027e2eaa5_left($_args) { extract($_args)
?>
    <h1><?php echo $template->translate("Mapy") ?></h1>

<?php $control->getWidget("mapsList")->render() ?>

<?php
}}


//
// block right
//
if (!function_exists($_cb->blocks['right'][] = '_cbbf05ef159ae_right')) { function _cbbf05ef159ae_right($_args) { extract($_args)
?>
<h2><?php echo $template->translate("možnosti") ?></h2>

<?php $control->getWidget("defaultActionsMenu")->render() ?>

<?php
}}

//
// end of blocks
//

if ($_cb->extends) { ob_start(); }

if (NSnippetHelper::$outputAllowed) {
$_cb->extends = '../@doublepanel.phtml' ;  
}

if ($_cb->extends) { ob_end_clean(); NLatteMacros::includeTemplate($_cb->extends, get_defined_vars(), $template)->render(); }
