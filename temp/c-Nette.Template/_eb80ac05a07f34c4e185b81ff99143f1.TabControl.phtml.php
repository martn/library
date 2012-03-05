<?php //netteCache[01]000231a:2:{s:4:"time";s:21:"0.40190600 1295918298";s:9:"callbacks";a:1:{i:0;a:3:{i:0;a:2:{i:0;s:6:"NCache";i:1;s:9:"checkFile";}i:1;s:75:"C:\Users\Martin\Web\library\root\app\components\TabControl/TabControl.phtml";i:2;i:1295188888;}}}?><?php
// file C:\Users\Martin\Web\library\root\app\components\TabControl/TabControl.phtml
//

$_cb = NLatteMacros::initRuntime($template, NULL, 'a42d1e9655'); unset($_extends);

if (NSnippetHelper::$outputAllowed) {
} if ($_cb->foo = NSnippetHelper::create($control, "content")) { $_cb->snippets[] = $_cb->foo ?>
	<?php
	   $control->tabContainer->addClass("ui-tabs ui-widget ui-widget-content ui-corner-all");
	   $control->tabContainer->id = $control->DOMtabsID	?>
	<?php echo $control->tabContainer->startTag() ?>

				<ul class="ui-tabs-nav ui-helper-reset ui-helper-clearfix ui-widget-header ui-corner-all" id="<?php echo NTemplateHelpers::escapeHtml($control->getSnippetId('div_ul')) ?>">
<?php foreach ($iterator = $_cb->its[] = new NSmartCachingIterator($control->tabs) as $name => $tab): ?>
				<?php
				  $li = NHtml::el("li")->class("ui-tabs-panel ui-widget-content ui-state-default ui-corner-top");
				  $li->id = $control->getSnippetId("div_ul_li__".$name);
				  if($activeTab->getName() == $name)
					  $li->addClass("ui-tabs-selected ui-state-active");
				  else
					  $li->addClass("ui-state-default")	?>
				<?php echo $li->startTag() ?>

				<a id="<?php echo NTemplateHelpers::escapeHtml($control->getSnippetId('div_ul_li_a__'.$name)) ?>" href="<?php echo NTemplateHelpers::escapeHtml($component->generateSelectLink($name)) ?>">
					   <span><?php echo $tab->header ?></span>
					</a>
				<?php echo $li->endTag() ?>

<?php endforeach; array_pop($_cb->its); $iterator = end($_cb->its) ?>
		</ul>

				<?php } foreach ($iterator = $_cb->its[] = new NSmartCachingIterator($control->tabs) as $name => $tab): if (NSnippetHelper::$outputAllowed) { ?>
						<?php } 
				$container = NHtml::el("div")->addClass("ui-tabs-panel ui-widget-content ui-corner-bottom");
				if($activeTab->getName() != $name)
					$container->addClass("ui-tabs-hide"); if (NSnippetHelper::$outputAllowed) { } if ($_cb->foo = NSnippetHelper::create($control, $name, $container)) { $_cb->snippets[] = $_cb->foo ?>
				<?php } if (isSet($component->tabsForDraw[$name])): if (NSnippetHelper::$outputAllowed) { ?>
					<?php }  $tab->renderContent(); if (NSnippetHelper::$outputAllowed) { ?>
				<?php } endif ;if (NSnippetHelper::$outputAllowed) { ?>
				<div class="ui-helper-clearfix"></div>
<?php array_pop($_cb->snippets)->finish(); } if (NSnippetHelper::$outputAllowed) { ?>
		<?php } endforeach; array_pop($_cb->its); $iterator = end($_cb->its) ;if (NSnippetHelper::$outputAllowed) { ?>
	<?php echo $control->tabContainer->endTag() ?>


	<?php } if ($control->mode !== TabControl::MODE_NO_AJAX): if (NSnippetHelper::$outputAllowed) { ?>
		<script type="text/JavaScript">
			$(function(){

<?php if (is_string($control->loaderText)): foreach ($iterator = $_cb->its[] = new NSmartCachingIterator($control->components) as $name => $tab): if ($activeTab->getName() != $name): ?>
					$("#"+<?php echo NTemplateHelpers::escapeJs($control->getSnippetId($name)) ?>).each(function(){
						$(this).html(<?php echo NTemplateHelpers::escapeJs($control->loaderText) ?>);
					});
<?php endif ;endforeach; array_pop($_cb->its); $iterator = end($_cb->its) ;endif ?>

<?php foreach ($iterator = $_cb->its[] = new NSmartCachingIterator($control->tabs) as $name => $tab): ?>
						$("#"+<?php echo NTemplateHelpers::escapeJs($control->getSnippetId('div_ul_li_a__'.$name)) ?>).each(function(){
							var jThis = $(this);
							jThis.attr("url",jThis.attr("href"));
							jThis.attr("href","#"+<?php echo NTemplateHelpers::escapeJs($control->getSnippetId($name)) ?>);
							jThis.get(0).jTab = $("#"+<?php echo NTemplateHelpers::escapeJs($control->getSnippetId($name)) ?>)
							jThis.get(0).jTab.get(0).jAnchor = jThis;

<?php if ($control->mode == TabControl::MODE_PRELOAD): if ($activeTab->getName() != $name): ?>
									$.getJSON(<?php echo NTemplateHelpers::escapeJs($control->link("preload", array('tab'=>$name))) ?>);
<?php endif ;endif ?>

							$("#"+<?php echo NTemplateHelpers::escapeJs($control->DOMtabsID) ?>).bind("tabsselect",function(event,ui){
								if(ui.panel.id === <?php echo NTemplateHelpers::escapeJs($control->getSnippetId($name)) ?>){
									var panel = $(ui.panel);

<?php if ($control->mode == TabControl::MODE_LAZY): ?>
										if(panel.html() == <?php echo NTemplateHelpers::escapeJs($control->loaderText) ?>){
											$.getJSON(jThis.attr("url"));
										}
<?php endif ?>

<?php if ($control->mode == TabControl::MODE_RELOAD): if (is_string($control->loaderText)): ?>
											jThis.get(0).jTab.html(<?php echo NTemplateHelpers::escapeJs($control->loaderText) ?>);
<?php endif ?>
										$.getJSON(jThis.attr("url"));
<?php endif ?>
								}
							})
						});
<?php endforeach; array_pop($_cb->its); $iterator = end($_cb->its) ?>

				/* Tohle by bylo fajn, ale nevím jak změnit persistentní parametr v průběhu renderování
<?php if ($control->mode === TabControl::MODE_PRELOAD): ?>
					$.getJSON(<?php echo NTemplateHelpers::escapeJs($control->link("preload!")) ?>);
<?php endif ?>
				*/
		// Zavoláme jQueryUI Tabs
				$("#"+<?php echo NTemplateHelpers::escapeJs($control->DOMtabsID) ?>).tabs(<?php echo $component->jQueryTabsOptions ?>);

		// Přeřazování tabů
<?php if ($control->sortable): ?>
			var options = {
				axis: 'x',
				stop: function(e,ui){
					// Workaround for Opera: http://forum.nettephp.com/cs/viewtopic.php?pid=15968#p15968
					$(ui.item).css('left','auto');
					$(ui.item).css('top','auto');

					$.post(
						<?php echo NTemplateHelpers::escapeJs($control->link("saveTabsOrder")) ?>,
						{
							"<?php echo $component->getParamId('order') ?>[]": $(this).sortable("toArray")
						},
						null, // Callback
						"json" // Datatype
					);
				}
			};

			// V IE jinak označí TabControl jako text
			if(!$.browser.msie) {
				options.distance = 25;
			}

			$("#"+<?php echo NTemplateHelpers::escapeJs($control->DOMtabsID) ?>)
			.find(".ui-tabs-nav")
			.sortable(options);
		<?php endif ?>;
			})
		</script>
<?php } if ($_cb->foo = NSnippetHelper::create($control, "JavaScript")) { $_cb->snippets[] = $_cb->foo ?>
			<script type="text/JavaScript">
				$(function(){
					var tabs = $("#"+<?php echo NTemplateHelpers::escapeJs($control->DOMtabsID) ?>)
<?php foreach ($iterator = $_cb->its[] = new NSmartCachingIterator($control->javaScript) as $code): ?>
						<?php echo $code ?>

<?php endforeach; array_pop($_cb->its); $iterator = end($_cb->its) ?>
				});
			</script>
<?php array_pop($_cb->snippets)->finish(); } if (NSnippetHelper::$outputAllowed) { ?>
	<?php } endif ;if (NSnippetHelper::$outputAllowed) { array_pop($_cb->snippets)->finish(); } if (NSnippetHelper::$outputAllowed) { 
}
