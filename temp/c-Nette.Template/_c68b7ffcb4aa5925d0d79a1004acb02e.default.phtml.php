<?php //netteCache[01]000239a:2:{s:4:"time";s:21:"0.78668300 1315298130";s:9:"callbacks";a:1:{i:0;a:3:{i:0;a:2:{i:0;s:6:"NCache";i:1;s:9:"checkFile";}i:1;s:83:"/Users/martin/Web/library/root/www/../app/FrontModule/templates/Menus/default.phtml";i:2;i:1294276870;}}}?><?php
// file …/FrontModule/templates/Menus/default.phtml
//

$_cb = NLatteMacros::initRuntime($template, true, '73426abd48'); unset($_extends);


//
// block left
//
if (!function_exists($_cb->blocks['left'][] = '_cbbb639fa8517_left')) { function _cbbb639fa8517_left($_args) { extract($_args)
?>
    <h1><?php echo $template->translate("Menu") ?></h1>
    
<?php $control->getWidget("mapsList")->render() ?>
   
<?php
}}


//
// block right
//
if (!function_exists($_cb->blocks['right'][] = '_cbbc7ffc42ac9_right')) { function _cbbc7ffc42ac9_right($_args) { extract($_args)
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
