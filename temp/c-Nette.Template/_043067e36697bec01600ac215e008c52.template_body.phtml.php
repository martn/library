<?php //netteCache[01]000247a:2:{s:4:"time";s:21:"0.78753700 1314727401";s:9:"callbacks";a:1:{i:0;a:3:{i:0;a:2:{i:0;s:6:"NCache";i:1;s:9:"checkFile";}i:1;s:91:"/Users/martin/Web/library/root/app/components/MapBased/NavigatorControl/template_body.phtml";i:2;i:1265311222;}}}?><?php
// file /Users/martin/Web/library/root/app/components/MapBased/NavigatorControl/template_body.phtml
//

$_cb = NLatteMacros::initRuntime($template, NULL, '3275664665'); unset($_extends);

if (NSnippetHelper::$outputAllowed) {
if ($data!=null): if ($data->countChilds()>0): ?>
		 <a href="<?php echo NTemplateHelpers::escapeHtml($presenter->link($data->link)) ?>"><?php echo NTemplateHelpers::escapeHtml($data->name) ?></a> &nbsp; » &nbsp;  	
<?php NLatteMacros::includeTemplate("template_body.phtml", array('data'=>$data->lastChild()) + $template->getParams(), $_cb->templates['3275664665'])->render() ;else: ?>
		 <?php echo NTemplateHelpers::escapeHtml($data->name) ?>

<?php endif ;endif ;
}
