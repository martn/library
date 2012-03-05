<?php //netteCache[01]000241a:2:{s:4:"time";s:21:"0.66420000 1295923607";s:9:"callbacks";a:1:{i:0;a:3:{i:0;a:2:{i:0;s:6:"NCache";i:1;s:9:"checkFile";}i:1;s:85:"C:\Users\Martin\Web\library\root\www/../app/FrontModule/templates/Default/items.phtml";i:2;i:1295923598;}}}?><?php
// file …/FrontModule/templates/Default/items.phtml
//

$_cb = NLatteMacros::initRuntime($template, true, '4b3feb2bd8'); unset($_extends);


//
// block panel
//
if (!function_exists($_cb->blocks['panel'][] = '_cbb3015ff4150_panel')) { function _cbb3015ff4150_panel($_args) { extract($_args)
;if (NSnippetHelper::$outputAllowed) { ?>
<h1><?php echo $template->translate("Hledat...") ?></h1>

<div class="itemsLeft">
<?php $control->getWidget("formFilter")->render() ?>
</div>
<div class="itemsRight">
<?php $control->getWidget("resultTable")->render() ?>
</div>
<?php } 
}}

//
// end of blocks
//

if ($_cb->extends) { ob_start(); }

if (NSnippetHelper::$outputAllowed) {
} $_cb->extends = '../@singlepanel.phtml' ;if (NSnippetHelper::$outputAllowed) { }  if (NSnippetHelper::$outputAllowed) { ?>



<?php
}

if ($_cb->extends) { ob_end_clean(); NLatteMacros::includeTemplate($_cb->extends, get_defined_vars(), $template)->render(); }
