<?php //netteCache[01]000272a:2:{s:4:"time";s:21:"0.68510200 1295912875";s:9:"callbacks";a:1:{i:0;a:3:{i:0;a:2:{i:0;s:6:"NCache";i:1;s:9:"checkFile";}i:1;s:115:"C:\Users\Martin\Web\library\root\libs\Nette.Extras\MultipleFileUpload\UserInterface\Interfaces\Swfupload/html.phtml";i:2;i:1295866369;}}}?><?php
// file C:\Users\Martin\Web\library\root\libs\Nette.Extras\MultipleFileUpload\UserInterface\Interfaces\Swfupload/html.phtml
//

$_cb = NLatteMacros::initRuntime($template, NULL, '0b9a895ab5'); unset($_extends);

if (NSnippetHelper::$outputAllowed) {
?>
<div class="swfuflashupload" id="<?php echo $swfuId ?>">
<div class="fieldset swfuflash" id="<?php echo $swfuId ?>progress">
    <span class="legend">Fronta souborů: </span>
    <span id="<?php echo $swfuId ?>placeHolder"></span>
</div>
<div class="divStatus">0 Files Uploaded</div>
<input id="<?php echo NTemplateHelpers::escapeHtml($swfuId) ?>btnCancel" type="button" value="Přerušit nahrávání" onclick="$('#<?php echo $swfuId ?>').swfupload('cancelQueue');" disabled="disabled" />
</div><?php
}
