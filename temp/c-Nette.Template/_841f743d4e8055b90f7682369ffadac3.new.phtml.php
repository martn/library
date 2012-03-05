<?php //netteCache[01]000235a:2:{s:4:"time";s:21:"0.80893000 1315125218";s:9:"callbacks";a:1:{i:0;a:3:{i:0;a:2:{i:0;s:6:"NCache";i:1;s:9:"checkFile";}i:1;s:79:"/Users/martin/Web/library/root/www/../app/FrontModule/templates/Types/new.phtml";i:2;i:1295225434;}}}?><?php
// file …/FrontModule/templates/Types/new.phtml
//

$_cb = NLatteMacros::initRuntime($template, true, 'ebf561e433'); unset($_extends);


//
// block left
//
if (!function_exists($_cb->blocks['left'][] = '_cbb61eeda07c9_left')) { function _cbb61eeda07c9_left($_args) { extract($_args)
;if (NSnippetHelper::$outputAllowed) { ?>
    <h1><?php echo $template->translate("Nový typ položky") ?></h1>
    
<?php $control->getWidget("formNew")->render() ?>
   
<?php } 
}}

//
// end of blocks
//

if ($_cb->extends) { ob_start(); }

if (NSnippetHelper::$outputAllowed) {
} $_cb->extends = '../@doublepanel.phtml' ;if (NSnippetHelper::$outputAllowed) { }  if (NSnippetHelper::$outputAllowed) { 
}

if ($_cb->extends) { ob_end_clean(); NLatteMacros::includeTemplate($_cb->extends, get_defined_vars(), $template)->render(); }
