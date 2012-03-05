<?php //netteCache[01]000238a:2:{s:4:"time";s:21:"0.73526500 1315245062";s:9:"callbacks";a:1:{i:0;a:3:{i:0;a:2:{i:0;s:6:"NCache";i:1;s:9:"checkFile";}i:1;s:82:"/Users/martin/Web/library/root/www/../app/FrontModule/templates/Maps/default.phtml";i:2;i:1294334532;}}}?><?php
// file …/FrontModule/templates/Maps/default.phtml
//

$_cb = NLatteMacros::initRuntime($template, true, '4699b1422f'); unset($_extends);


//
// block left
//
if (!function_exists($_cb->blocks['left'][] = '_cbbfd68820de7_left')) { function _cbbfd68820de7_left($_args) { extract($_args)
?>
    <h1><?php echo $template->translate("Mapy") ?></h1>

<?php $control->getWidget("mapsList")->render() ?>

<?php
}}


//
// block right
//
if (!function_exists($_cb->blocks['right'][] = '_cbb7f9306db32_right')) { function _cbb7f9306db32_right($_args) { extract($_args)
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
