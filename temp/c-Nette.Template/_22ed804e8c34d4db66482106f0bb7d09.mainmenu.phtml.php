<?php //netteCache[01]000239a:2:{s:4:"time";s:21:"0.34182900 1295909371";s:9:"callbacks";a:1:{i:0;a:3:{i:0;a:2:{i:0;s:6:"NCache";i:1;s:9:"checkFile";}i:1;s:83:"C:\Users\Martin\Web\library\root\app\components\MapBased\MenuControl/mainmenu.phtml";i:2;i:1263659848;}}}?><?php
// file C:\Users\Martin\Web\library\root\app\components\MapBased\MenuControl/mainmenu.phtml
//

$_cb = NLatteMacros::initRuntime($template, NULL, '11a29ffafe'); unset($_extends);

if (NSnippetHelper::$outputAllowed) {
?>
<div id="menu">
	<div class="hdrwrpr">
<?php NLatteMacros::includeTemplate("mainmenu_body.phtml", array('data'=>$data, 'level'=>0) + $template->getParams(), $_cb->templates['11a29ffafe'])->render() ?>
	</div>
</div><?php
}
