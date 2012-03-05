<?php //netteCache[01]000240a:2:{s:4:"time";s:21:"0.99111800 1295920085";s:9:"callbacks";a:1:{i:0;a:3:{i:0;a:2:{i:0;s:6:"NCache";i:1;s:9:"checkFile";}i:1;s:84:"C:\Users\Martin\Web\library\root\www/../app/FrontModule/templates/Account/edit.phtml";i:2;i:1292602012;}}}?><?php
// file …/FrontModule/templates/Account/edit.phtml
//

$_cb = NLatteMacros::initRuntime($template, true, '4ed530e076'); unset($_extends);


//
// block left
//
if (!function_exists($_cb->blocks['left'][] = '_cbb863089f2c2_left')) { function _cbb863089f2c2_left($_args) { extract($_args)
?>
    <h1>Úprava účtu - <?php echo NTemplateHelpers::escapeHtml($userdata->name) ?> <?php echo NTemplateHelpers::escapeHtml($userdata->surname) ?></h1>
    
<?php $control->getWidget("formEdit")->render() ;
}}

//
// end of blocks
//

if ($_cb->extends) { ob_start(); }

if (NSnippetHelper::$outputAllowed) {
$_cb->extends = '../@doublepanel.phtml' ; 
}

if ($_cb->extends) { ob_end_clean(); NLatteMacros::includeTemplate($_cb->extends, get_defined_vars(), $template)->render(); }
