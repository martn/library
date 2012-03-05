<?php //netteCache[01]000232a:2:{s:4:"time";s:21:"0.88033800 1295909695";s:9:"callbacks";a:1:{i:0;a:3:{i:0;a:2:{i:0;s:6:"NCache";i:1;s:9:"checkFile";}i:1;s:76:"C:\Users\Martin\Web\library\root\app\components\Tables\TableBase/table.phtml";i:2;i:1268245288;}}}?><?php
// file C:\Users\Martin\Web\library\root\app\components\Tables\TableBase/table.phtml
//

$_cb = NLatteMacros::initRuntime($template, NULL, '8e7de9bc33'); unset($_extends);

if (NSnippetHelper::$outputAllowed) {
?>
<table cellpadding="0" cellspacing="0" class="<?php echo NTemplateHelpers::escapeHtml($class) ?>">
<?php $control->renderHead() ;$control->renderBody() ?>
</table>    <?php
}
