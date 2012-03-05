<?php //netteCache[01]000242a:2:{s:4:"time";s:21:"0.04271700 1295920076";s:9:"callbacks";a:1:{i:0;a:3:{i:0;a:2:{i:0;s:6:"NCache";i:1;s:9:"checkFile";}i:1;s:86:"C:\Users\Martin\Web\library\root\www/../app/FrontModule/templates/Account/detail.phtml";i:2;i:1293909668;}}}?><?php
// file …/FrontModule/templates/Account/detail.phtml
//

$_cb = NLatteMacros::initRuntime($template, true, '3544bb2025'); unset($_extends);


//
// block left
//
if (!function_exists($_cb->blocks['left'][] = '_cbbc2037141d0_left')) { function _cbbc2037141d0_left($_args) { extract($_args)
?>
<h1><?php echo $template->translate("Uživatel") ?> - <?php echo NTemplateHelpers::escapeHtml($userdata->name) ?> <?php echo NTemplateHelpers::escapeHtml($userdata->surname) ?></h1>

<table class="data">
<tr><td> <?php echo $template->translate("jméno") ?>: </td><td class="user_info_data"><?php echo NTemplateHelpers::escapeHtml($userdata->name) ?> <?php echo NTemplateHelpers::escapeHtml($userdata->surname) ?></td></tr>
<tr><td> e-mail: </td><td class="user_info_data"><a href="mailto:<?php echo NTemplateHelpers::escapeHtml($user->mail) ?>"><?php echo NTemplateHelpers::escapeHtml($userdata->mail) ?></a> </td></tr>
<tr><td> web: </td><td class="user_info_data"><a href="http://<?php echo NTemplateHelpers::escapeHtml($user->web) ?>" target="_blank"><?php echo NTemplateHelpers::escapeHtml($userdata->web) ?></a> </td></tr>
<tr><td> <?php echo $template->translate("tel") ?>.: </td><td class="user_info_data"><?php echo NTemplateHelpers::escapeHtml($userdata->tel) ?></td></tr>
<tr><td> <?php echo $template->translate("adresa") ?>: </td><td class="user_info_data"><?php echo NTemplateHelpers::escapeHtml($userdata->adress) ?> </td></tr>
</table>

<?php
}}


//
// block right
//
if (!function_exists($_cb->blocks['right'][] = '_cbb7bdb308531_right')) { function _cbb7bdb308531_right($_args) { extract($_args)
?>
<h2><?php echo $template->translate("možnosti") ?></h2>
<?php $control->getWidget("detailActionsMenu")->render() ?>
    
<?php
}}

//
// end of blocks
//

if ($_cb->extends) { ob_start(); }

if (NSnippetHelper::$outputAllowed) {
$_cb->extends = '../@doublepanel.phtml'  ?>

<?php
}

if ($_cb->extends) { ob_end_clean(); NLatteMacros::includeTemplate($_cb->extends, get_defined_vars(), $template)->render(); }
