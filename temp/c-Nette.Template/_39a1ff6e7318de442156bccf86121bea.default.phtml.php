<?php //netteCache[01]000239a:2:{s:4:"time";s:21:"0.40217400 1314728118";s:9:"callbacks";a:1:{i:0;a:3:{i:0;a:2:{i:0;s:6:"NCache";i:1;s:9:"checkFile";}i:1;s:83:"/Users/martin/Web/library/root/www/../app/FrontModule/templates/Login/default.phtml";i:2;i:1292622878;}}}?><?php
// file …/FrontModule/templates/Login/default.phtml
//

$_cb = NLatteMacros::initRuntime($template, true, 'e29b8b9643'); unset($_extends);


//
// block panel
//
if (!function_exists($_cb->blocks['panel'][] = '_cbb974abc908c_panel')) { function _cbb974abc908c_panel($_args) { extract($_args)
?>
    <h1><?php echo $template->translate("Přihlášení do systému") ?></h1>

<?php $control->getWidget("loginForm")->render() ;
}}

//
// end of blocks
//

if ($_cb->extends) { ob_start(); }

if (NSnippetHelper::$outputAllowed) {
$_cb->extends = '../@singlepanel.phtml' ; 
}

if ($_cb->extends) { ob_end_clean(); NLatteMacros::includeTemplate($_cb->extends, get_defined_vars(), $template)->render(); }
