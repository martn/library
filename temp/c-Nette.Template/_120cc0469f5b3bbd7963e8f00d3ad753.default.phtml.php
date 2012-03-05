<?php //netteCache[01]000241a:2:{s:4:"time";s:21:"0.58141700 1295942241";s:9:"callbacks";a:1:{i:0;a:3:{i:0;a:2:{i:0;s:6:"NCache";i:1;s:9:"checkFile";}i:1;s:85:"C:\Users\Martin\Web\library\root\www/../app/FrontModule/templates/Menus/default.phtml";i:2;i:1294255270;}}}?><?php
// file …/FrontModule/templates/Menus/default.phtml
//

$_cb = NLatteMacros::initRuntime($template, true, '87877f296a'); unset($_extends);


//
// block left
//
if (!function_exists($_cb->blocks['left'][] = '_cbbd1f053a588_left')) { function _cbbd1f053a588_left($_args) { extract($_args)
?>
    <h1><?php echo $template->translate("Menu") ?></h1>
    
<?php $control->getWidget("mapsList")->render() ?>
   
<?php
}}


//
// block right
//
if (!function_exists($_cb->blocks['right'][] = '_cbb92e44d8472_right')) { function _cbb92e44d8472_right($_args) { extract($_args)
?>
<h2><?php echo $template->translate("možnosti") ?></h2>

<?php $control->getWidget("defaultActionsMenu")->render() ?>

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
