<?php //netteCache[01]000236a:2:{s:4:"time";s:21:"0.17453300 1314728291";s:9:"callbacks";a:1:{i:0;a:3:{i:0;a:2:{i:0;s:6:"NCache";i:1;s:9:"checkFile";}i:1;s:80:"/Users/martin/Web/library/root/www/../app/FrontModule/templates/Users/edit.phtml";i:2;i:1295940850;}}}?><?php
// file …/FrontModule/templates/Users/edit.phtml
//

$_cb = NLatteMacros::initRuntime($template, true, '8a9bcfa26d'); unset($_extends);


//
// block left
//
if (!function_exists($_cb->blocks['left'][] = '_cbbe865940fd8_left')) { function _cbbe865940fd8_left($_args) { extract($_args)
;if (NSnippetHelper::$outputAllowed) { ?>
<h1><?php echo $template->translate("Upravit uživatele") ?> - <?php echo NTemplateHelpers::escapeHtml($userdata->name) ?> <?php echo NTemplateHelpers::escapeHtml($userdata->surname) ?></h1>

<?php $control->getWidget("formEdit")->render() ;} 
}}


//
// block right
//
if (!function_exists($_cb->blocks['right'][] = '_cbbed23b29308_right')) { function _cbbed23b29308_right($_args) { extract($_args)
;if (NSnippetHelper::$outputAllowed) { ?>
<h2>Možnosti</h2>
<?php $control->getWidget("editActionsMenu")->render() ?>
    <br/>
<?php } 
}}

//
// end of blocks
//

if ($_cb->extends) { ob_start(); }

if (NSnippetHelper::$outputAllowed) {
} $_cb->extends = '../@doublepanel.phtml' ;if (NSnippetHelper::$outputAllowed) { }  if (NSnippetHelper::$outputAllowed) { }  if (NSnippetHelper::$outputAllowed) { 
}

if ($_cb->extends) { ob_end_clean(); NLatteMacros::includeTemplate($_cb->extends, get_defined_vars(), $template)->render(); }
