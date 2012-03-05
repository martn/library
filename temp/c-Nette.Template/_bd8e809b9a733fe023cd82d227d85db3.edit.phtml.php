<?php //netteCache[01]000239a:2:{s:4:"time";s:21:"0.66663000 1295919331";s:9:"callbacks";a:1:{i:0;a:3:{i:0;a:2:{i:0;s:6:"NCache";i:1;s:9:"checkFile";}i:1;s:83:"C:\Users\Martin\Web\library\root\www/../app/FrontModule/templates/Groups/edit.phtml";i:2;i:1293796784;}}}?><?php
// file …/FrontModule/templates/Groups/edit.phtml
//

$_cb = NLatteMacros::initRuntime($template, true, '87b7b89a86'); unset($_extends);


//
// block left
//
if (!function_exists($_cb->blocks['left'][] = '_cbb9060a7829b_left')) { function _cbb9060a7829b_left($_args) { extract($_args)
?>
    <h1><?php echo $template->translate("Úprava uživatelské skupiny") ?></h1>
    
<?php $control->getWidget("formEdit")->render() ?>
    
    
<?php
}}


//
// block right
//
if (!function_exists($_cb->blocks['right'][] = '_cbb058605c1fc_right')) { function _cbb058605c1fc_right($_args) { extract($_args)
?>
    
<h2><?php echo $template->translate("možnosti") ?></h2>

<?php $control->getWidget("editActionsMenu")->render() ;
}}

//
// end of blocks
//

if ($_cb->extends) { ob_start(); }

if (NSnippetHelper::$outputAllowed) {
$_cb->extends = '../@doublepanel.phtml' ;  
}

if ($_cb->extends) { ob_end_clean(); NLatteMacros::includeTemplate($_cb->extends, get_defined_vars(), $template)->render(); }
