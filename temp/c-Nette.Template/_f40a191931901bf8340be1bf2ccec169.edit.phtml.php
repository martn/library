<?php //netteCache[01]000235a:2:{s:4:"time";s:21:"0.49673000 1315245065";s:9:"callbacks";a:1:{i:0;a:3:{i:0;a:2:{i:0;s:6:"NCache";i:1;s:9:"checkFile";}i:1;s:79:"/Users/martin/Web/library/root/www/../app/FrontModule/templates/Maps/edit.phtml";i:2;i:1294334546;}}}?><?php
// file …/FrontModule/templates/Maps/edit.phtml
//

$_cb = NLatteMacros::initRuntime($template, true, 'a09aef371f'); unset($_extends);


//
// block left
//
if (!function_exists($_cb->blocks['left'][] = '_cbb591f76b856_left')) { function _cbb591f76b856_left($_args) { extract($_args)
?>
    <h1><?php echo $template->translate("Úprava mapy") ?></h1>

<?php $control->getWidget("formEdit")->render() ?>

<?php $control->getWidget("mapItemsTable")->render() ;
}}


//
// block right
//
if (!function_exists($_cb->blocks['right'][] = '_cbb237019a951_right')) { function _cbb237019a951_right($_args) { extract($_args)
?>
<h2><?php echo $template->translate("možnosti") ?></h2>

<?php $control->getWidget("editActionsMenu")->render() ?>

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
