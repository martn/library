<?php //netteCache[01]000241a:2:{s:4:"time";s:21:"0.95782000 1295941791";s:9:"callbacks";a:1:{i:0;a:3:{i:0;a:2:{i:0;s:6:"NCache";i:1;s:9:"checkFile";}i:1;s:85:"C:\Users\Martin\Web\library\root\www/../app/FrontModule/templates/Sections/edit.phtml";i:2;i:1293916378;}}}?><?php
// file …/FrontModule/templates/Sections/edit.phtml
//

$_cb = NLatteMacros::initRuntime($template, true, '1cd96f0ba4'); unset($_extends);


//
// block left
//
if (!function_exists($_cb->blocks['left'][] = '_cbb6d0f2c321f_left')) { function _cbb6d0f2c321f_left($_args) { extract($_args)
?>
    <h1><?php echo $template->translate("Úprava sekce") ?></h1>
    
<?php $control->getWidget("formEdit")->render() ;
}}


//
// block right
//
if (!function_exists($_cb->blocks['right'][] = '_cbb51b2b15221_right')) { function _cbb51b2b15221_right($_args) { extract($_args)
?>
    <?php
}}

//
// end of blocks
//

if ($_cb->extends) { ob_start(); }

if (NSnippetHelper::$outputAllowed) {
$_cb->extends = '../@doublepanel.phtml' ;  
}

if ($_cb->extends) { ob_end_clean(); NLatteMacros::includeTemplate($_cb->extends, get_defined_vars(), $template)->render(); }
