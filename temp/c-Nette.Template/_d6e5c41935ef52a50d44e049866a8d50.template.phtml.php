<?php //netteCache[01]000242a:2:{s:4:"time";s:21:"0.78327300 1314727401";s:9:"callbacks";a:1:{i:0;a:3:{i:0;a:2:{i:0;s:6:"NCache";i:1;s:9:"checkFile";}i:1;s:86:"/Users/martin/Web/library/root/app/components/MapBased/NavigatorControl/template.phtml";i:2;i:1263661282;}}}?><?php
// file /Users/martin/Web/library/root/app/components/MapBased/NavigatorControl/template.phtml
//

$_cb = NLatteMacros::initRuntime($template, NULL, '0dd8f7cf6b'); unset($_extends);

if (NSnippetHelper::$outputAllowed) {
?>
<div class="pageNavigator">
<?php NLatteMacros::includeTemplate("template_body.phtml", array('data'=>$data) + $template->getParams(), $_cb->templates['0dd8f7cf6b'])->render() ?>
</div><?php
}
