<?php //netteCache[01]000238a:2:{s:4:"time";s:21:"0.52896200 1315211403";s:9:"callbacks";a:1:{i:0;a:3:{i:0;a:2:{i:0;s:6:"NCache";i:1;s:9:"checkFile";}i:1;s:82:"/Users/martin/Web/library/root/www/../app/FrontModule/templates/Default/edit.phtml";i:2;i:1295937146;}}}?><?php
// file …/FrontModule/templates/Default/edit.phtml
//

$_cb = NLatteMacros::initRuntime($template, true, 'aa11ee07ff'); unset($_extends);


//
// block left
//
if (!function_exists($_cb->blocks['left'][] = '_cbb163c7707ed_left')) { function _cbb163c7707ed_left($_args) { extract($_args)
;if (NSnippetHelper::$outputAllowed) { ?>
<h1><?php echo $template->translate("Úprava položky") ?> - <?php echo NTemplateHelpers::escapeHtml($data->name) ?></h1>

<?php } if ($_cb->foo = NSnippetHelper::create($control, "formSnippet")) { $_cb->snippets[] = $_cb->foo ;$control->getWidget("formEdit")->render() ;array_pop($_cb->snippets)->finish(); } if (NSnippetHelper::$outputAllowed) { } 
}}


//
// block right
//
if (!function_exists($_cb->blocks['right'][] = '_cbbe00f09e34c_right')) { function _cbbe00f09e34c_right($_args) { extract($_args)
;if (NSnippetHelper::$outputAllowed) { ?>
<h2><?php echo $template->translate("Info") ?></h2>

<?php $control->getWidget("infoPanel")->render() ?>

<h2>Soubory:</h2>

<?php } if ($_cb->foo = NSnippetHelper::create($control, "filesTable")) { $_cb->snippets[] = $_cb->foo ;$control->getWidget("fileTableEdit")->render() ;array_pop($_cb->snippets)->finish(); } if (NSnippetHelper::$outputAllowed) { ?>

<?php } 
}}

//
// end of blocks
//

if ($_cb->extends) { ob_start(); }

if (NSnippetHelper::$outputAllowed) {
} $_cb->extends = '../@doublepanel.phtml' ;if (NSnippetHelper::$outputAllowed) { }  if (NSnippetHelper::$outputAllowed) { ?>

<?php }  if (NSnippetHelper::$outputAllowed) { 
}

if ($_cb->extends) { ob_end_clean(); NLatteMacros::includeTemplate($_cb->extends, get_defined_vars(), $template)->render(); }
