/**
 * AJAX Nette Framwork plugin for jQuery
 *
 * @copyright   Copyright (c) 2009 Jan Marek
 * @license     MIT
 * @link        http://nettephp.com/cs/extras/jquery-ajax
 * @version     0.2
 */

jQuery.extend({
    nette: {
        updateSnippet: function (id, html) {
            $("#" + id).html(html);
        },

        success: function (payload) {
            // redirect
            if (payload.redirect) {
                window.location.href = payload.redirect;
                return;
            }

            // snippets
            if (payload.snippets) {
                for (var i in payload.snippets) {
                    jQuery.nette.updateSnippet(i, payload.snippets[i]);
                }
            }
            $.dependentselectbox.hideSubmits();
        },

        error: function (payload) {
            alert('vnitřní chyba '+payload);
        }
    }
});

jQuery.ajaxSetup({
    success: jQuery.nette.success,
    dataType: "json"
});

/*
jQuery.nette.updateSnippet = function (id, html) {
    $("#" + id).fadeTo("fast", 0.001, function () {
        $(this).html(html).fadeTo("fast", 1);
    });
};*/


$(function () {
    // vhodně nastylovaný div vložím po načtení stránky
    $('<div id="ajax-spinner"></div>').appendTo("body").ajaxStop(function () {
        // a při události ajaxStop spinner schovám a nastavím mu původní pozici
        $(this).hide().css({
            position: "fixed",
            left: "50%",
            top: "50%"
        });
    }).hide();
});



$("a.confirm").livequery("click",function(event){
    event.preventDefault();

    href = this.href;

    jConfirm(this.title,
        "Potvrzení", function(r) {
            if(r) window.location=href;
        }
        );
});


$("a.ajax").livequery("click",function(event){
    event.preventDefault();
    ajaxGet(this.href, event);
});


$("a.ajaxconfirm").livequery("click", function(event) {
    event.preventDefault();

    href = this.href;

    jConfirm(this.title,
        "Potvrzení", function(r) {
            if(r) ajaxGet(href, event);
        }
        );
});


function ajaxGet(href, event)
{
    $.get(href);

    $("#ajax-spinner").show().css({
        position: "absolute",
        left: event.pageX + 20,
        top: event.pageY + 40
    });
}