<?php //netteCache[01]000241a:2:{s:4:"time";s:21:"0.23637500 1295918992";s:9:"callbacks";a:1:{i:0;a:3:{i:0;a:2:{i:0;s:6:"NCache";i:1;s:9:"checkFile";}i:1;s:85:"C:\Users\Martin\Web\library\root\www/../app/FrontModule/templates/Login/default.phtml";i:2;i:1292601278;}}}?><?php
// file …/FrontModule/templates/Login/default.phtml
//

$_cb = NLatteMacros::initRuntime($template, true, 'cf5f179a9e'); unset($_extends);


//
// block panel
//
if (!function_exists($_cb->blocks['panel'][] = '_cbb82796e155d_panel')) { function _cbb82796e155d_panel($_args) { extract($_args)
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
