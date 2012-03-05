<?php //netteCache[01]000240a:2:{s:4:"time";s:21:"0.17853800 1314728275";s:9:"callbacks";a:1:{i:0;a:3:{i:0;a:2:{i:0;s:6:"NCache";i:1;s:9:"checkFile";}i:1;s:84:"/Users/martin/Web/library/root/www/../app/FrontModule/templates/Groups/default.phtml";i:2;i:1294357650;}}}?><?php
// file …/FrontModule/templates/Groups/default.phtml
//

$_cb = NLatteMacros::initRuntime($template, true, '285c824c4c'); unset($_extends);


//
// block left
//
if (!function_exists($_cb->blocks['left'][] = '_cbb82460cac42_left')) { function _cbb82460cac42_left($_args) { extract($_args)
;if (NSnippetHelper::$outputAllowed) { ?>
    <h1><?php echo $template->translate("Uživatelské skupiny") ?></h1>

   <?php } $control->getWidget("groupsTable")->render() ;if (NSnippetHelper::$outputAllowed) { ?>
    
<?php } 
}}


//
// block right
//
if (!function_exists($_cb->blocks['right'][] = '_cbba0a5fa865a_right')) { function _cbba0a5fa865a_right($_args) { extract($_args)
?>
<h2><?php echo $template->translate("možnosti") ?></h2>

<?php $control->getWidget("defaultActionsMenu")->render() ;
}}

//
// end of blocks
//

if ($_cb->extends) { ob_start(); }

if (NSnippetHelper::$outputAllowed) {
$_cb->extends = '../@doublepanel.phtml' ;}  if (NSnippetHelper::$outputAllowed) {  
}

if ($_cb->extends) { ob_end_clean(); NLatteMacros::includeTemplate($_cb->extends, get_defined_vars(), $template)->render(); }
