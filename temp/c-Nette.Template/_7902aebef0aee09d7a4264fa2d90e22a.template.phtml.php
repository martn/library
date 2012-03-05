<?php //netteCache[01]000244a:2:{s:4:"time";s:21:"0.43436700 1295909371";s:9:"callbacks";a:1:{i:0;a:3:{i:0;a:2:{i:0;s:6:"NCache";i:1;s:9:"checkFile";}i:1;s:88:"C:\Users\Martin\Web\library\root\app\components\MapBased\NavigatorControl/template.phtml";i:2;i:1263639682;}}}?><?php
// file C:\Users\Martin\Web\library\root\app\components\MapBased\NavigatorControl/template.phtml
//

$_cb = NLatteMacros::initRuntime($template, NULL, '4df9227acb'); unset($_extends);

if (NSnippetHelper::$outputAllowed) {
?>
<div class="pageNavigator">
<?php NLatteMacros::includeTemplate("template_body.phtml", array('data'=>$data) + $template->getParams(), $_cb->templates['4df9227acb'])->render() ?>
</div><?php
}
