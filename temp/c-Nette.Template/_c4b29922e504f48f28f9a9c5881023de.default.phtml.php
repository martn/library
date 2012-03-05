<?php //netteCache[01]000242a:2:{s:4:"time";s:21:"0.73648900 1295917701";s:9:"callbacks";a:1:{i:0;a:3:{i:0;a:2:{i:0;s:6:"NCache";i:1;s:9:"checkFile";}i:1;s:86:"C:\Users\Martin\Web\library\root\www/../app/FrontModule/templates/Groups/default.phtml";i:2;i:1294336050;}}}?><?php
// file …/FrontModule/templates/Groups/default.phtml
//

$_cb = NLatteMacros::initRuntime($template, true, '7f2067dd8c'); unset($_extends);


//
// block left
//
if (!function_exists($_cb->blocks['left'][] = '_cbb9a2d8f14ca_left')) { function _cbb9a2d8f14ca_left($_args) { extract($_args)
;if (NSnippetHelper::$outputAllowed) { ?>
    <h1><?php echo $template->translate("Uživatelské skupiny") ?></h1>

   <?php } $control->getWidget("groupsTable")->render() ;if (NSnippetHelper::$outputAllowed) { ?>
    
<?php } 
}}


//
// block right
//
if (!function_exists($_cb->blocks['right'][] = '_cbb59a94dc9fb_right')) { function _cbb59a94dc9fb_right($_args) { extract($_args)
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
