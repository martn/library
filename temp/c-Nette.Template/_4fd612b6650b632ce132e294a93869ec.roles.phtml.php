<?php //netteCache[01]000237a:2:{s:4:"time";s:21:"0.81980600 1314728284";s:9:"callbacks";a:1:{i:0;a:3:{i:0;a:2:{i:0;s:6:"NCache";i:1;s:9:"checkFile";}i:1;s:81:"/Users/martin/Web/library/root/www/../app/FrontModule/templates/Users/roles.phtml";i:2;i:1293666840;}}}?><?php
// file …/FrontModule/templates/Users/roles.phtml
//

$_cb = NLatteMacros::initRuntime($template, true, '17a0e682f3'); unset($_extends);


//
// block left
//
if (!function_exists($_cb->blocks['left'][] = '_cbba3468bbe58_left')) { function _cbba3468bbe58_left($_args) { extract($_args)
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
if (!function_exists($_cb->blocks['right'][] = '_cbbf32b53f333_right')) { function _cbbf32b53f333_right($_args) { extract($_args)
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
