<?php //netteCache[01]000243a:2:{s:4:"time";s:21:"0.99514900 1295955725";s:9:"callbacks";a:1:{i:0;a:3:{i:0;a:2:{i:0;s:6:"NCache";i:1;s:9:"checkFile";}i:1;s:87:"C:\Users\Martin\Web\library\root\www/../app/FrontModule/templates/Types/signature.phtml";i:2;i:1295617288;}}}?><?php
// file …/FrontModule/templates/Types/signature.phtml
//

$_cb = NLatteMacros::initRuntime($template, true, '07aaa6d41c'); unset($_extends);


//
// block left
//
if (!function_exists($_cb->blocks['left'][] = '_cbb9ce335773f_left')) { function _cbb9ce335773f_left($_args) { extract($_args)
;if (NSnippetHelper::$outputAllowed) { ?>
    <h1><?php echo $template->translate("Signatura") ?> pro typ '<?php echo NTemplateHelpers::escapeHtml($typeData->name) ?>'</h1>
    
          
<?php $formErrors = FormMacros::begin('formSignature', $control, array())->getErrors() ?>
   
    <fieldset>

         <h3>Identifikační čísla polí, oddělené pomlčkou. Příklad: 12-45-30</h3>

   <?php FormMacros::input('signature', array()) ?>-TYP-ID
   <br/>
  
    </fieldset>
   
   <div class="right">
<?php FormMacros::input('ok', array()) ?>
   </div>
   
<?php FormMacros::end() ?>

       <br/><br/>
    
    <h2>Dostupná pole pro signaturu</h2>

<?php $control->getWidget("tableSignatureHelperList")->render() ?>


<?php } 
}}


//
// block right
//
if (!function_exists($_cb->blocks['right'][] = '_cbbdf73c512b9_right')) { function _cbbdf73c512b9_right($_args) { extract($_args)
;if (NSnippetHelper::$outputAllowed) { } 
}}

//
// end of blocks
//

if ($_cb->extends) { ob_start(); }

if (NSnippetHelper::$outputAllowed) {
} $_cb->extends = '../@doublepanel.phtml' ;if (NSnippetHelper::$outputAllowed) { }  if (NSnippetHelper::$outputAllowed) { }  if (NSnippetHelper::$outputAllowed) { 
}

if ($_cb->extends) { ob_end_clean(); NLatteMacros::includeTemplate($_cb->extends, get_defined_vars(), $template)->render(); }
