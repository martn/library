<?php //netteCache[01]000245a:2:{s:4:"time";s:21:"0.12755400 1295918298";s:9:"callbacks";a:1:{i:0;a:3:{i:0;a:2:{i:0;s:6:"NCache";i:1;s:9:"checkFile";}i:1;s:89:"C:\Users\Martin\Web\library\root\www/../app/FrontModule/templates/Groups/privileges.phtml";i:2;i:1295192458;}}}?><?php
// file …/FrontModule/templates/Groups/privileges.phtml
//

$_cb = NLatteMacros::initRuntime($template, true, '3041c13478'); unset($_extends);


//
// block left
//
if (!function_exists($_cb->blocks['left'][] = '_cbb410e1e9045_left')) { function _cbb410e1e9045_left($_args) { extract($_args)
;if (NSnippetHelper::$outputAllowed) { ?>
    <h1><?php echo $template->translate("Práva - skupina") ?> <?php echo NTemplateHelpers::escapeHtml($role->name) ?></h1>
    
<?php if (isset($advanced_menu)): ?>
<div class="right">
   <?php echo $advanced_menu ?>

</div>
<br/><br/>

<?php endif ?>


    <?php echo NTemplateHelpers::escapeHtml($form->render('begin')) ?>


    <?php } $control->getWidget("privilegesTabControl")->render() ;if (NSnippetHelper::$outputAllowed) { ?>

    <br/>
        <?php echo $form['id']->getControl() ?>

      <?php echo $form['ok']->getControl() ?>

      <?php echo $form['cancel']->getControl() ?>

      <?php echo NTemplateHelpers::escapeHtml($form->render('end')) ?>



<?php } 
}}


//
// block right
//
if (!function_exists($_cb->blocks['right'][] = '_cbb18a681ea9c_right')) { function _cbb18a681ea9c_right($_args) { extract($_args)
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
