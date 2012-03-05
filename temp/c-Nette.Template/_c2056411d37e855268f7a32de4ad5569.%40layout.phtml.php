<?php //netteCache[01]000244a:2:{s:4:"time";s:21:"0.43778700 1315313031";s:9:"callbacks";a:1:{i:0;a:3:{i:0;a:2:{i:0;s:6:"NCache";i:1;s:9:"checkFile";}i:1;s:88:"/Users/martin/Web/library/root/www/../app/FrontModule/templates/Account/../@layout.phtml";i:2;i:1295946698;}}}?><?php
// file …/FrontModule/templates/Account/../@layout.phtml
//

$_cb = NLatteMacros::initRuntime($template, NULL, '9074a1c115'); unset($_extends);

if (NSnippetHelper::$outputAllowed) {
$control->getWidget("header")->renderBegin() ;$control->getWidget("header")->renderCss('ajax.css', 'tabcontrol.css','controls.css','smoothness/jquery-ui-1.8.9.custom.css','template.css','lytebox.css','menustyle.css','uploadify.css','prettyForms.css','tipsy.css','alerts/jquery.alerts.css','screen.css') ?>

    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.4/jquery.min.js"></script>
    <script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.9/jquery-ui.min.js"></script>

<?php $control->getWidget("header")->renderJs('jquery.livequery.js', 'jquery.alerts.js', 'jquery.nette.dependentselectbox.js', 'jquery.tipsy.js', 'jquery.nette.js', 'jquery.ajaxform.js', 'common.js','MultipleFileUpload/MFUFallbackController.js') ?>
    <?php echo MultipleFileUpload::getHead() ?>

<?php $control->getWidget("header")->renderEnd() ?>
<body>

<div id="wraper">
<div id="main">
<div id="headerPanel">
<div id="logo"></div>
<!-- ========== MENU ========================--> <?php $control->getWidget("mainMenu")->render() ?> <!-- ========== MENU END ============ -->
</div>
<!-- ========== TOP PANEL ============ -->
<div id="topPanel">
<div class="right">
<?php if ($userAuthenticated): ?>
		<a href="<?php echo NTemplateHelpers::escapeHtml($presenter->link("account:default")) ?>"><?php echo NTemplateHelpers::escapeHtml($user->name) ?></a> | 
		<a href="<?php echo NTemplateHelpers::escapeHtml($presenter->link("account:logout")) ?>">odhlásit</a> 
<?php else: ?>
		<a href="<?php echo NTemplateHelpers::escapeHtml($presenter->link("login:default")) ?>">přihlásit</a> 
<?php endif ?>
</div>
<div class="left"><?php $control->getWidget("pageNavigator")->render() ?></div>
</div>
<!-- ========== TOP PANEL END ============ --> <!-- ========== MAIN PANEL ============ -->
<div id="mainPanel">
	<?php } NLatteMacros::callBlock($_cb->blocks, 'content', get_defined_vars()) ;if (NSnippetHelper::$outputAllowed) { ?>
</div>
<!-- ========== MAIN END ============ --></div>
<div id="footWrap">
<div id="footPanel">
<p>© Copyright All rights reserved</p>
<p>Designed By: <a href="http://www.templateworld.com">Template World</a></p>
</div>
</div>
</div>
<!-- ========== WRAP END ============ -->
    </body>
</html>



<?php
}
