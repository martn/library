<?php //netteCache[01]000240a:2:{s:4:"time";s:21:"0.70728200 1315305963";s:9:"callbacks";a:1:{i:0;a:3:{i:0;a:2:{i:0;s:6:"NCache";i:1;s:9:"checkFile";}i:1;s:84:"/Users/martin/Web/library/root/www/../app/FrontModule/templates/Menus/editItem.phtml";i:2;i:1294273022;}}}?><?php
// file …/FrontModule/templates/Menus/editItem.phtml
//

$_cb = NLatteMacros::initRuntime($template, true, '06b64f37e9'); unset($_extends);


//
// block left
//
if (!function_exists($_cb->blocks['left'][] = '_cbb131eed25b8_left')) { function _cbb131eed25b8_left($_args) { extract($_args)
?>
    <h1><?php echo $template->translate("Upravit položku menu") ?></h1>
    
<?php $control->getWidget("formEditItem")->render() ;
}}

//
// end of blocks
//

if ($_cb->extends) { ob_start(); }

if (NSnippetHelper::$outputAllowed) {
$_cb->extends = '../@doublepanel.phtml' ; 
}

if ($_cb->extends) { ob_end_clean(); NLatteMacros::includeTemplate($_cb->extends, get_defined_vars(), $template)->render(); }
