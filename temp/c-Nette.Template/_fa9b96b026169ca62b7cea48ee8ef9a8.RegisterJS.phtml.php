<?php //netteCache[01]000240a:2:{s:4:"time";s:21:"0.60907100 1314728156";s:9:"callbacks";a:1:{i:0;a:3:{i:0;a:2:{i:0;s:6:"NCache";i:1;s:9:"checkFile";}i:1;s:84:"/Users/martin/Web/library/root/libs/Nette.Extras/MultipleFileUpload/RegisterJS.phtml";i:2;i:1295889184;}}}?><?php
// file /Users/martin/Web/library/root/libs/Nette.Extras/MultipleFileUpload/RegisterJS.phtml
//

$_cb = NLatteMacros::initRuntime($template, NULL, 'b7d8c7aaf5'); unset($_extends);

if (NSnippetHelper::$outputAllowed) {
?>
<script type="text/JavaScript">
new MFUFallbackController(document.getElementById(<?php echo NTemplateHelpers::escapeJs($id) ?>),<?php echo json_encode($fallbacks) ?>);
</script><?php
}
