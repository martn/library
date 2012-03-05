<?php //netteCache[01]000237a:2:{s:4:"time";s:21:"0.74391300 1295918941";s:9:"callbacks";a:1:{i:0;a:3:{i:0;a:2:{i:0;s:6:"NCache";i:1;s:9:"checkFile";}i:1;s:81:"C:\Users\Martin\Web\library\root\www/../app/FrontModule/templates/Users/new.phtml";i:2;i:1293630638;}}}?><?php
// file …/FrontModule/templates/Users/new.phtml
//

$_cb = NLatteMacros::initRuntime($template, true, 'bfc42f89c9'); unset($_extends);


//
// block left
//
if (!function_exists($_cb->blocks['left'][] = '_cbbb768b39249_left')) { function _cbbb768b39249_left($_args) { extract($_args)
?>
<h1><?php echo $template->translate("Nový uživatel") ?> </h1>

<?php $control->getWidget("formNew")->render() ?>

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
