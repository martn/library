<?php //netteCache[01]000244a:2:{s:4:"time";s:21:"0.90048200 1314728152";s:9:"callbacks";a:1:{i:0;a:3:{i:0;a:2:{i:0;s:6:"NCache";i:1;s:9:"checkFile";}i:1;s:88:"/Users/martin/Web/library/root/www/../app/FrontModule/templates/Default/chooseType.phtml";i:2;i:1295648272;}}}?><?php
// file …/FrontModule/templates/Default/chooseType.phtml
//

$_cb = NLatteMacros::initRuntime($template, true, '7e1e1f6a58'); unset($_extends);


//
// block panel
//
if (!function_exists($_cb->blocks['panel'][] = '_cbbc6a1e1c593_panel')) { function _cbbc6a1e1c593_panel($_args) { extract($_args)
;if (NSnippetHelper::$outputAllowed) { ?>
<h1><?php echo $template->translate("Nová položka - vyberte typ") ?></h1>

<div style="width: 50%">
<?php $control->getWidget("tableChooseType")->render() ?>
</div>

<?php } 
}}

//
// end of blocks
//

if ($_cb->extends) { ob_start(); }

if (NSnippetHelper::$outputAllowed) {
} $_cb->extends = '../@singlepanel.phtml' ;if (NSnippetHelper::$outputAllowed) { }  if (NSnippetHelper::$outputAllowed) { 
}

if ($_cb->extends) { ob_end_clean(); NLatteMacros::includeTemplate($_cb->extends, get_defined_vars(), $template)->render(); }
