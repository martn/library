<?php //netteCache[01]000237a:2:{s:4:"time";s:21:"0.75449400 1314727401";s:9:"callbacks";a:1:{i:0;a:3:{i:0;a:2:{i:0;s:6:"NCache";i:1;s:9:"checkFile";}i:1;s:81:"/Users/martin/Web/library/root/app/components/MapBased/MenuControl/mainmenu.phtml";i:2;i:1263681448;}}}?><?php
// file /Users/martin/Web/library/root/app/components/MapBased/MenuControl/mainmenu.phtml
//

$_cb = NLatteMacros::initRuntime($template, NULL, 'b8ae2cfabf'); unset($_extends);

if (NSnippetHelper::$outputAllowed) {
?>
<div id="menu">
	<div class="hdrwrpr">
<?php NLatteMacros::includeTemplate("mainmenu_body.phtml", array('data'=>$data, 'level'=>0) + $template->getParams(), $_cb->templates['b8ae2cfabf'])->render() ?>
	</div>
</div><?php
}
