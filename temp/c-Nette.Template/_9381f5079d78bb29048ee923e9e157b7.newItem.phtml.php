<?php //netteCache[01]000241a:2:{s:4:"time";s:21:"0.49709000 1295942251";s:9:"callbacks";a:1:{i:0;a:3:{i:0;a:2:{i:0;s:6:"NCache";i:1;s:9:"checkFile";}i:1;s:85:"C:\Users\Martin\Web\library\root\www/../app/FrontModule/templates/Menus/newItem.phtml";i:2;i:1294234860;}}}?><?php
// file …/FrontModule/templates/Menus/newItem.phtml
//

$_cb = NLatteMacros::initRuntime($template, true, '586e9c3f4c'); unset($_extends);


//
// block left
//
if (!function_exists($_cb->blocks['left'][] = '_cbbb3331c4420_left')) { function _cbbb3331c4420_left($_args) { extract($_args)
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
