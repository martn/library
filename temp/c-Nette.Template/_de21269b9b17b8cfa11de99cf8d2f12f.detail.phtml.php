<?php //netteCache[01]000241a:2:{s:4:"time";s:21:"0.71405700 1295919737";s:9:"callbacks";a:1:{i:0;a:3:{i:0;a:2:{i:0;s:6:"NCache";i:1;s:9:"checkFile";}i:1;s:85:"C:\Users\Martin\Web\library\root\www/../app/FrontModule/templates/Groups/detail.phtml";i:2;i:1292625190;}}}?><?php
// file …/FrontModule/templates/Groups/detail.phtml
//

$_cb = NLatteMacros::initRuntime($template, true, '89bdefb827'); unset($_extends);


//
// block left
//
if (!function_exists($_cb->blocks['left'][] = '_cbb2c67646854_left')) { function _cbb2c67646854_left($_args) { extract($_args)
?>
    <h1><?php echo $template->translate("Uživatelská skupina") ?> <?php echo NTemplateHelpers::escapeHtml($data->name) ?></h1>

    Popis: <?php echo NTemplateHelpers::escapeHtml($data->description) ?>

    
    <br/>
    <br/>
    
    <hr/>
    <br/>
    <h2><?php echo $template->translate("Členové skupiny") ?>:</h2>
<?php $control->getWidget("usersTable")->render() ;
}}

//
// end of blocks
//

if ($_cb->extends) { ob_start(); }

if (NSnippetHelper::$outputAllowed) {
$_cb->extends = '../@doublepanel.phtml' ; 
}

if ($_cb->extends) { ob_end_clean(); NLatteMacros::includeTemplate($_cb->extends, get_defined_vars(), $template)->render(); }
