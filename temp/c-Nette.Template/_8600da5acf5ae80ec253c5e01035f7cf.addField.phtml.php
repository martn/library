<?php //netteCache[01]000240a:2:{s:4:"time";s:21:"0.96196200 1315125285";s:9:"callbacks";a:1:{i:0;a:3:{i:0;a:2:{i:0;s:6:"NCache";i:1;s:9:"checkFile";}i:1;s:84:"/Users/martin/Web/library/root/www/../app/FrontModule/templates/Types/addField.phtml";i:2;i:1295405874;}}}?><?php
// file …/FrontModule/templates/Types/addField.phtml
//

$_cb = NLatteMacros::initRuntime($template, true, '323d8be14a'); unset($_extends);


//
// block left
//
if (!function_exists($_cb->blocks['left'][] = '_cbb523cdc8e9d_left')) { function _cbb523cdc8e9d_left($_args) { extract($_args)
;if (NSnippetHelper::$outputAllowed) { ?>
<h1>Nové pole</h1>
    <?php } $control->getWidget("formFieldNew")->render() ;if (NSnippetHelper::$outputAllowed) { } 
}}

//
// end of blocks
//

if ($_cb->extends) { ob_start(); }

if (NSnippetHelper::$outputAllowed) {
} $_cb->extends = '../@doublepanel.phtml' ;if (NSnippetHelper::$outputAllowed) { }  if (NSnippetHelper::$outputAllowed) { ?>

<?php
}

if ($_cb->extends) { ob_end_clean(); NLatteMacros::includeTemplate($_cb->extends, get_defined_vars(), $template)->render(); }
