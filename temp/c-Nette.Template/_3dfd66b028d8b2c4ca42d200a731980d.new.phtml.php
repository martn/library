<?php //netteCache[01]000238a:2:{s:4:"time";s:21:"0.37837600 1295919679";s:9:"callbacks";a:1:{i:0;a:3:{i:0;a:2:{i:0;s:6:"NCache";i:1;s:9:"checkFile";}i:1;s:82:"C:\Users\Martin\Web\library\root\www/../app/FrontModule/templates/Groups/new.phtml";i:2;i:1293796792;}}}?><?php
// file …/FrontModule/templates/Groups/new.phtml
//

$_cb = NLatteMacros::initRuntime($template, true, 'b5181024ba'); unset($_extends);


//
// block left
//
if (!function_exists($_cb->blocks['left'][] = '_cbbea9b8f772b_left')) { function _cbbea9b8f772b_left($_args) { extract($_args)
?>
    <h1><?php echo $template->translate("Nová uživatelská skupina") ?></h1>
    
<?php $control->getWidget("formNew")->render() ;
}}

//
// end of blocks
//

if ($_cb->extends) { ob_start(); }

if (NSnippetHelper::$outputAllowed) {
$_cb->extends = '../@doublepanel.phtml' ; 
}

if ($_cb->extends) { ob_end_clean(); NLatteMacros::includeTemplate($_cb->extends, get_defined_vars(), $template)->render(); }
