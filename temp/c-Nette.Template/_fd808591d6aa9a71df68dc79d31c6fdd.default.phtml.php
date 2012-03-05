<?php //netteCache[01]000241a:2:{s:4:"time";s:21:"0.04854300 1314727401";s:9:"callbacks";a:1:{i:0;a:3:{i:0;a:2:{i:0;s:6:"NCache";i:1;s:9:"checkFile";}i:1;s:85:"/Users/martin/Web/library/root/www/../app/FrontModule/templates/Default/default.phtml";i:2;i:1295834740;}}}?><?php
// file …/FrontModule/templates/Default/default.phtml
//

$_cb = NLatteMacros::initRuntime($template, true, '064845e006'); unset($_extends);


//
// block left
//
if (!function_exists($_cb->blocks['left'][] = '_cbb565c3a443a_left')) { function _cbb565c3a443a_left($_args) { extract($_args)
;if (NSnippetHelper::$outputAllowed) { ?>
<h1><?php echo $template->translate("Knihovna") ?></h1>



<?php } 
}}


//
// block right
//
if (!function_exists($_cb->blocks['right'][] = '_cbba1456c72be_right')) { function _cbba1456c72be_right($_args) { extract($_args)
;if (NSnippetHelper::$outputAllowed) { ?>
<h2><?php echo $template->translate("možnosti") ?></h2>

<?php $control->getWidget("defaultActions")->render() ?>
    <br/>
    <hr/>
    <br/>

<?php if ($count<5): echo $template->translate("V knihovně jsou") ?> <?php echo NTemplateHelpers::escapeHtml($count) ?> <?php echo $template->translate("položky") ?>.
<?php else: echo $template->translate("V knihovně je") ?> <?php echo NTemplateHelpers::escapeHtml($count) ?> <?php echo $template->translate("položek") ?>.
<?php endif ?>

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
