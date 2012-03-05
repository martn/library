<?php //netteCache[01]000240a:2:{s:4:"time";s:21:"0.33115600 1295915549";s:9:"callbacks";a:1:{i:0;a:3:{i:0;a:2:{i:0;s:6:"NCache";i:1;s:9:"checkFile";}i:1;s:84:"C:\Users\Martin\Web\library\root\www/../app/FrontModule/templates/Default/edit.phtml";i:2;i:1295915544;}}}?><?php
// file …/FrontModule/templates/Default/edit.phtml
//

$_cb = NLatteMacros::initRuntime($template, true, '38500e19ce'); unset($_extends);


//
// block left
//
if (!function_exists($_cb->blocks['left'][] = '_cbb5ea0bce02e_left')) { function _cbb5ea0bce02e_left($_args) { extract($_args)
;if (NSnippetHelper::$outputAllowed) { ?>
<h1><?php echo $template->translate("Úprava položky") ?> - <?php echo NTemplateHelpers::escapeHtml($data->name) ?></h1>

<?php } if ($_cb->foo = NSnippetHelper::create($control, "formSnippet")) { $_cb->snippets[] = $_cb->foo ;$control->getWidget("formEdit")->render() ;array_pop($_cb->snippets)->finish(); } if (NSnippetHelper::$outputAllowed) { } 
}}


//
// block right
//
if (!function_exists($_cb->blocks['right'][] = '_cbbe3a9134613_right')) { function _cbbe3a9134613_right($_args) { extract($_args)
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
