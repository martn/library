<?php //netteCache[01]000238a:2:{s:4:"time";s:21:"0.14116700 1315299482";s:9:"callbacks";a:1:{i:0;a:3:{i:0;a:2:{i:0;s:6:"NCache";i:1;s:9:"checkFile";}i:1;s:82:"/Users/martin/Web/library/root/www/../app/FrontModule/templates/Maps/newItem.phtml";i:2;i:1294334582;}}}?><?php
// file …/FrontModule/templates/Maps/newItem.phtml
//

$_cb = NLatteMacros::initRuntime($template, true, '82ec4259e0'); unset($_extends);


//
// block left
//
if (!function_exists($_cb->blocks['left'][] = '_cbb450328c1fa_left')) { function _cbb450328c1fa_left($_args) { extract($_args)
?>
    <h1><?php echo $template->translate("Nová položka mapy") ?></h1>

<?php $control->getWidget("formNewItem")->render() ;
}}

//
// end of blocks
//

if ($_cb->extends) { ob_start(); }

if (NSnippetHelper::$outputAllowed) {
$_cb->extends = '../@doublepanel.phtml' ; 
}

if ($_cb->extends) { ob_end_clean(); NLatteMacros::includeTemplate($_cb->extends, get_defined_vars(), $template)->render(); }
