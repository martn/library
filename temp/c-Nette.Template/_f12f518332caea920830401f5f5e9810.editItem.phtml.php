<?php //netteCache[01]000241a:2:{s:4:"time";s:21:"0.52282500 1295942409";s:9:"callbacks";a:1:{i:0;a:3:{i:0;a:2:{i:0;s:6:"NCache";i:1;s:9:"checkFile";}i:1;s:85:"C:\Users\Martin\Web\library\root\www/../app/FrontModule/templates/Maps/editItem.phtml";i:2;i:1294312958;}}}?><?php
// file …/FrontModule/templates/Maps/editItem.phtml
//

$_cb = NLatteMacros::initRuntime($template, true, 'ebd5694e9b'); unset($_extends);


//
// block left
//
if (!function_exists($_cb->blocks['left'][] = '_cbbfcaaecd225_left')) { function _cbbfcaaecd225_left($_args) { extract($_args)
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
