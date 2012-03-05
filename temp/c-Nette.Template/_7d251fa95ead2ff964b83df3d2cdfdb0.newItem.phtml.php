<?php //netteCache[01]000240a:2:{s:4:"time";s:21:"0.83436600 1295942432";s:9:"callbacks";a:1:{i:0;a:3:{i:0;a:2:{i:0;s:6:"NCache";i:1;s:9:"checkFile";}i:1;s:84:"C:\Users\Martin\Web\library\root\www/../app/FrontModule/templates/Maps/newItem.phtml";i:2;i:1294312982;}}}?><?php
// file …/FrontModule/templates/Maps/newItem.phtml
//

$_cb = NLatteMacros::initRuntime($template, true, '0c3a849e89'); unset($_extends);


//
// block left
//
if (!function_exists($_cb->blocks['left'][] = '_cbb8039d450c4_left')) { function _cbb8039d450c4_left($_args) { extract($_args)
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
