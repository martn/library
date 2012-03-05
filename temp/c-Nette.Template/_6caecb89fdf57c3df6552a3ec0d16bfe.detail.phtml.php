<?php //netteCache[01]000240a:2:{s:4:"time";s:21:"0.20554600 1314776164";s:9:"callbacks";a:1:{i:0;a:3:{i:0;a:2:{i:0;s:6:"NCache";i:1;s:9:"checkFile";}i:1;s:84:"/Users/martin/Web/library/root/www/../app/FrontModule/templates/Default/detail.phtml";i:2;i:1295932670;}}}?><?php
// file …/FrontModule/templates/Default/detail.phtml
//

$_cb = NLatteMacros::initRuntime($template, true, 'ba099c67e6'); unset($_extends);


//
// block left
//
if (!function_exists($_cb->blocks['left'][] = '_cbb0b5c6c51a1_left')) { function _cbb0b5c6c51a1_left($_args) { extract($_args)
;if (NSnippetHelper::$outputAllowed) { ?>
<h1><?php echo NTemplateHelpers::escapeHtml($item->name) ?></h1>

<?php $control->getWidget("itemView")->render() ?>

<br/>

<div class="note">
<div class="label">poznámka:</div>
<em><?php echo NTemplateHelpers::escapeHtml($item->note) ?></em>
</div>

<h2>Soubory:</h2>
<?php $control->getWidget("fileTable")->render() ?>

<?php
}}


//
// block right
//
if (!function_exists($_cb->blocks['right'][] = '_cbbe1bda765f9_right')) { function _cbbe1bda765f9_right($_args) { extract($_args)
?>

<h2><?php echo $template->translate("možnosti") ?></h2>
<?php $control->getWidget("itemActionsMenu")->render() ?>


<h2><?php echo $template->translate("Info") ?></h2>
<?php $control->getWidget("infoPanel")->render() ?>

<?php
}}

//
// end of blocks
//

if ($_cb->extends) { ob_start(); }

if (NSnippetHelper::$outputAllowed) {
} $_cb->extends = '../@doublepanel.phtml' ;if (NSnippetHelper::$outputAllowed) { }   
}

if ($_cb->extends) { ob_end_clean(); NLatteMacros::includeTemplate($_cb->extends, get_defined_vars(), $template)->render(); }
