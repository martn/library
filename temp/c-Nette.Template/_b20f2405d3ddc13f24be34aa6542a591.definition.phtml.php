<?php //netteCache[01]000244a:2:{s:4:"time";s:21:"0.14212800 1295955753";s:9:"callbacks";a:1:{i:0;a:3:{i:0;a:2:{i:0;s:6:"NCache";i:1;s:9:"checkFile";}i:1;s:88:"C:\Users\Martin\Web\library\root\www/../app/FrontModule/templates/Types/definition.phtml";i:2;i:1295954438;}}}?><?php
// file …/FrontModule/templates/Types/definition.phtml
//

$_cb = NLatteMacros::initRuntime($template, true, '716d2af56d'); unset($_extends);


//
// block left
//
if (!function_exists($_cb->blocks['left'][] = '_cbb4741f2843f_left')) { function _cbb4741f2843f_left($_args) { extract($_args)
;if (NSnippetHelper::$outputAllowed) { ?>
    <h1><?php echo $template->translate("Definice polí typu '".$typeData['name']."'") ?></h1>

<?php if (isset($add_menu)): ?>
	<div class="right"><?php echo $add_menu ?></div>
<?php endif ?>

   
    <?php } $control->getWidget("tableTypeDefinition")->render() ;if (NSnippetHelper::$outputAllowed) { ?>

    <h2>Přidat skupinu</h2>
    <?php } $control->getWidget("addGroupTabControl")->render() ;if (NSnippetHelper::$outputAllowed) { ?>
    
<?php } 
}}


//
// block right
//
if (!function_exists($_cb->blocks['right'][] = '_cbb42191548e0_right')) { function _cbb42191548e0_right($_args) { extract($_args)
;if (NSnippetHelper::$outputAllowed) { ?>
<h2>Možnosti</h2>
<?php } $control->getWidget("definitionActionsMenu")->render() ;if (NSnippetHelper::$outputAllowed) { } 
}}

//
// end of blocks
//

if ($_cb->extends) { ob_start(); }

if (NSnippetHelper::$outputAllowed) {
} $_cb->extends = '../@doublepanel.phtml' ;if (NSnippetHelper::$outputAllowed) { }  if (NSnippetHelper::$outputAllowed) { }  if (NSnippetHelper::$outputAllowed) { 
}

if ($_cb->extends) { ob_end_clean(); NLatteMacros::includeTemplate($_cb->extends, get_defined_vars(), $template)->render(); }
