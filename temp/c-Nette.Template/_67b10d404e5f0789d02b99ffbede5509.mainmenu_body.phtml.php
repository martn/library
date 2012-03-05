<?php //netteCache[01]000242a:2:{s:4:"time";s:21:"0.76501600 1314727401";s:9:"callbacks";a:1:{i:0;a:3:{i:0;a:2:{i:0;s:6:"NCache";i:1;s:9:"checkFile";}i:1;s:86:"/Users/martin/Web/library/root/app/components/MapBased/MenuControl/mainmenu_body.phtml";i:2;i:1263682754;}}}?><?php
// file /Users/martin/Web/library/root/app/components/MapBased/MenuControl/mainmenu_body.phtml
//

$_cb = NLatteMacros::initRuntime($template, NULL, '42f4465749'); unset($_extends);

if (NSnippetHelper::$outputAllowed) {
if ($data!=null): if ($level==0): ?>
	<ul id="topnav">
<?php foreach ($iterator = $_cb->its[] = new NSmartCachingIterator($data) as $child): ?>
		<li class="<?php if ($child->countChilds()>0): ?>nav_press<?php else: ?>unsub<?php endif ?>">
	    	<a href="<?php echo NTemplateHelpers::escapeHtml($presenter->link($child->link)) ?>" class="nav_item"><?php echo $template->translate($child->name) ?></a>
<?php if ($child->countChilds()>0): NLatteMacros::includeTemplate("mainmenu_body.phtml", array('data'=>$child->getChilds(), 'level'=>1) + $template->getParams(), $_cb->templates['42f4465749'])->render() ;endif ?>
		</li>
<?php endforeach; array_pop($_cb->its); $iterator = end($_cb->its) ?>
	</ul>
<?php endif ;if ($level==1): ?>
		<div class="menu">
        	<div class="sub_nav_begin">&nbsp;</div>
         	<ul class="sub_nav">
<?php foreach ($iterator = $_cb->its[] = new NSmartCachingIterator($data) as $child): ?>
				<li>
			    	<a href="<?php echo NTemplateHelpers::escapeHtml($presenter->link($child->link)) ?>"><?php echo $template->translate($child->name) ?></a>
				</li>
<?php endforeach; array_pop($_cb->its); $iterator = end($_cb->its) ?>
            </ul>
            <div class="sub_nav_end">&nbsp;</div>
            <div class="clear">&nbsp;</div>
        </div>
         
<?php endif ;endif ;
}
