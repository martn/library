<?php //netteCache[01]000239a:2:{s:4:"time";s:21:"0.63247200 1295913124";s:9:"callbacks";a:1:{i:0;a:3:{i:0;a:2:{i:0;s:6:"NCache";i:1;s:9:"checkFile";}i:1;s:83:"C:\Users\Martin\Web\library\root\www/../app/FrontModule/templates/Default/new.phtml";i:2;i:1295809833;}}}?><?php
// file …/FrontModule/templates/Default/new.phtml
//

$_cb = NLatteMacros::initRuntime($template, true, '648876ee03'); unset($_extends);


//
// block left
//
if (!function_exists($_cb->blocks['left'][] = '_cbbb0c2371434_left')) { function _cbbb0c2371434_left($_args) { extract($_args)
;if (NSnippetHelper::$outputAllowed) { ?>
<h1><?php echo $template->translate("Nová položka typu") ?> <?php if (isset($typeData)): ?>'<?php echo NTemplateHelpers::escapeHtml($typeData->name) ?>'<?php endif ?></h1>

<?php } if ($_cb->foo = NSnippetHelper::create($control, "formSnippet")) { $_cb->snippets[] = $_cb->foo ;$control->getWidget("formNew")->render() ;array_pop($_cb->snippets)->finish(); } if (NSnippetHelper::$outputAllowed) { ?>

<?php } 
}}


//
// block right
//
if (!function_exists($_cb->blocks['right'][] = '_cbb07e9543d59_right')) { function _cbb07e9543d59_right($_args) { extract($_args)
;if (NSnippetHelper::$outputAllowed) { ?>
<h2>Možnosti</h2>
<?php $control->getWidget("newActionsMenu")->render() ;} 
}}

//
// end of blocks
//

if ($_cb->extends) { ob_start(); }

if (NSnippetHelper::$outputAllowed) {
} $_cb->extends = '../@doublepanel.phtml' ;if (NSnippetHelper::$outputAllowed) { }  if (NSnippetHelper::$outputAllowed) { }  if (NSnippetHelper::$outputAllowed) { 
}

if ($_cb->extends) { ob_end_clean(); NLatteMacros::includeTemplate($_cb->extends, get_defined_vars(), $template)->render(); }
