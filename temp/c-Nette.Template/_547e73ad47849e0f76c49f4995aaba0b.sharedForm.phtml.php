<?php //netteCache[01]000247a:2:{s:4:"time";s:21:"0.31616900 1315125204";s:9:"callbacks";a:1:{i:0;a:3:{i:0;a:2:{i:0;s:6:"NCache";i:1;s:9:"checkFile";}i:1;s:91:"/Users/martin/Web/library/root/www/../app/FrontModule/templates/Types/Tabs/sharedForm.phtml";i:2;i:1295366166;}}}?><?php
// file …/FrontModule/templates/Types/Tabs/sharedForm.phtml
//

$_cb = NLatteMacros::initRuntime($template, NULL, 'afe8ba27bb'); unset($_extends);

if (NSnippetHelper::$outputAllowed) {
 $form->render('begin') ;echo $table ?>

<br/><br/>
<?php echo $form['ok']->getControl() ?>

<?php  $form->render('end') ;
}
