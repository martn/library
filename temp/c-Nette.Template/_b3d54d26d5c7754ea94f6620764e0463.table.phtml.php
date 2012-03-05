<?php //netteCache[01]000230a:2:{s:4:"time";s:21:"0.07732900 1314728125";s:9:"callbacks";a:1:{i:0;a:3:{i:0;a:2:{i:0;s:6:"NCache";i:1;s:9:"checkFile";}i:1;s:74:"/Users/martin/Web/library/root/app/components/Tables/TableBase/table.phtml";i:2;i:1268266888;}}}?><?php
// file /Users/martin/Web/library/root/app/components/Tables/TableBase/table.phtml
//

$_cb = NLatteMacros::initRuntime($template, NULL, 'e4ed49d82a'); unset($_extends);

if (NSnippetHelper::$outputAllowed) {
?>
<table cellpadding="0" cellspacing="0" class="<?php echo NTemplateHelpers::escapeHtml($class) ?>">
<?php $control->renderHead() ;$control->renderBody() ?>
</table>    <?php
}
