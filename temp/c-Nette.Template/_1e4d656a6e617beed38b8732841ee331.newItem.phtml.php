<?php //netteCache[01]000239a:2:{s:4:"time";s:21:"0.36558400 1315306593";s:9:"callbacks";a:1:{i:0;a:3:{i:0;a:2:{i:0;s:6:"NCache";i:1;s:9:"checkFile";}i:1;s:83:"/Users/martin/Web/library/root/www/../app/FrontModule/templates/Menus/newItem.phtml";i:2;i:1294256460;}}}?><?php
// file …/FrontModule/templates/Menus/newItem.phtml
//

$_cb = NLatteMacros::initRuntime($template, true, '5f4cd1d01f'); unset($_extends);


//
// block left
//
if (!function_exists($_cb->blocks['left'][] = '_cbbd8f437cf13_left')) { function _cbbd8f437cf13_left($_args) { extract($_args)
?>
    <h1><?php echo $template->translate("Nová položka menu") ?></h1>
    
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
