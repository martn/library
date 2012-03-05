<?php //netteCache[01]000242a:2:{s:4:"time";s:21:"0.75062100 1295912875";s:9:"callbacks";a:1:{i:0;a:3:{i:0;a:2:{i:0;s:6:"NCache";i:1;s:9:"checkFile";}i:1;s:86:"C:\Users\Martin\Web\library\root\libs\Nette.Extras\MultipleFileUpload\RegisterJS.phtml";i:2;i:1295867583;}}}?><?php
// file C:\Users\Martin\Web\library\root\libs\Nette.Extras\MultipleFileUpload\RegisterJS.phtml
//

$_cb = NLatteMacros::initRuntime($template, NULL, '3a07a26fed'); unset($_extends);

if (NSnippetHelper::$outputAllowed) {
?>
<script type="text/JavaScript">
new MFUFallbackController(document.getElementById(<?php echo NTemplateHelpers::escapeJs($id) ?>),<?php echo json_encode($fallbacks) ?>);
</script><?php
}
