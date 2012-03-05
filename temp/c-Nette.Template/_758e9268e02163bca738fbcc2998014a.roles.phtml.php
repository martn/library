<?php //netteCache[01]000239a:2:{s:4:"time";s:21:"0.14884600 1295918963";s:9:"callbacks";a:1:{i:0;a:3:{i:0;a:2:{i:0;s:6:"NCache";i:1;s:9:"checkFile";}i:1;s:83:"C:\Users\Martin\Web\library\root\www/../app/FrontModule/templates/Users/roles.phtml";i:2;i:1293645240;}}}?><?php
// file …/FrontModule/templates/Users/roles.phtml
//

$_cb = NLatteMacros::initRuntime($template, true, 'dea750d940'); unset($_extends);


//
// block left
//
if (!function_exists($_cb->blocks['left'][] = '_cbbf2e888819a_left')) { function _cbbf2e888819a_left($_args) { extract($_args)
?>

   <h1><?php echo $template->translate("Uživatelské skupiny") ?> - <?php echo NTemplateHelpers::escapeHtml($userdata->name) ?> <?php echo NTemplateHelpers::escapeHtml($userdata->surname) ?></h1>

<?php $control->getWidget("userRoles")->render() ?>
                
   <br/>                
   <br/>
   <hr/>
   <br/>
   
   <a class="button" href="<?php echo NTemplateHelpers::escapeHtml($presenter->link("default")) ?>">zavřít</a>
<?php
}}


//
// block right
//
if (!function_exists($_cb->blocks['right'][] = '_cbb3935e7eb7a_right')) { function _cbb3935e7eb7a_right($_args) { extract($_args)
?>
	<h2>Možnosti</h2>
<?php $control->getWidget("formAddUserToRole")->render() ;
}}

//
// end of blocks
//

if ($_cb->extends) { ob_start(); }

if (NSnippetHelper::$outputAllowed) {
$_cb->extends = '../@doublepanel.phtml' ;  
}

if ($_cb->extends) { ob_end_clean(); NLatteMacros::includeTemplate($_cb->extends, get_defined_vars(), $template)->render(); }
