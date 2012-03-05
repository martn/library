<?php //netteCache[01]000238a:2:{s:4:"time";s:21:"0.02953500 1295942245";s:9:"callbacks";a:1:{i:0;a:3:{i:0;a:2:{i:0;s:6:"NCache";i:1;s:9:"checkFile";}i:1;s:82:"C:\Users\Martin\Web\library\root\www/../app/FrontModule/templates/Menus/edit.phtml";i:2;i:1294234938;}}}?><?php
// file …/FrontModule/templates/Menus/edit.phtml
//

$_cb = NLatteMacros::initRuntime($template, true, 'd214508306'); unset($_extends);


//
// block left
//
if (!function_exists($_cb->blocks['left'][] = '_cbbcc98bcfb62_left')) { function _cbbcc98bcfb62_left($_args) { extract($_args)
?>
    <h1><?php echo $template->translate("Úprava menu") ?></h1>
    
<?php $control->getWidget("formEdit")->render() ?>

<?php $control->getWidget("mapItemsTable")->render() ;
}}


//
// block right
//
if (!function_exists($_cb->blocks['right'][] = '_cbb7ee410ab8f_right')) { function _cbb7ee410ab8f_right($_args) { extract($_args)
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
