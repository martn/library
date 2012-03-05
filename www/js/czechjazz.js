// uživatelské javascriptové funkce

$(function () {
//	    $.registerAfterUpdate();

	// přiřaď všem současným i budoucím odkazům s třídou ajaxlink po kliknutí tuto funkci
	$("a.ajax").live("click", function () {
        $.get(this.href);
        return false;
    });

	
	// ajaxové odeslání na všech současných i budoucích formulářích
	$("form.ajaxform").live("submit", function() {
		$(this).netteAjaxSubmit();
		return false;
	});
	
	// ajaxové odeslání pomocí tlačítka na všech současných i budoucích formulářích
	$("form.ajaxform :submit").live("submit", function () {
		$(this).netteAjaxSubmit();
		return false;
	});
	
	// ajaxové odeslání všech současných i budoucích formulářů i pomocí změny selectboxu
	$("form.ajaxform select").live('change', function() {
		$(this.form).netteAjaxSubmit();
		return false;
	});
	
	$('<div id="ajax-spinner"></div>').ajaxStart(function () {
		$(this).show();
	}).ajaxStop(function () {
		$(this).hide();
	}).appendTo("body").hide();

});
