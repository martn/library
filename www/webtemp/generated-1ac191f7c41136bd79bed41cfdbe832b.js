/**
 * @author Daniel Robenek
 * @license MIT
 */

/**
 * 	$(document).ready(function() {
 *		$.dependentselectbox.initialize();
 *	});
 *
 *	Add to jquery.nette.js at the end of $.nette.success:
 *	$.dependentselectbox.hideSubmits();
 *
 */
jQuery.extend({
    dependentselectbox: {
        controlClass: 'dependentControl',

        buttonSuffix: '_submit',

        hideSubmits: function() {
            // Here hide all you want. Default is to hide <tr> of button
            //$('.'+$.dependentselectbox.controlClass+$.dependentselectbox.buttonSuffix).parent().parent().hide();
            $('.'+$.dependentselectbox.controlClass+$.dependentselectbox.buttonSuffix).parent().parent().hide();
        },

        initialize: function() {
            $.dependentselectbox.hideSubmits();
            $('.'+$.dependentselectbox.controlClass).live('change', function() {
                $('#'+($(this).attr('id'))+$.dependentselectbox.buttonSuffix).ajaxSubmit($.dependentselectbox.jsonResponse);
            });
        },

        updateSelectBox: function(id, selectedKey, items) {
            $("#" + id + " option").remove();
            var select = $("#" + id);
            for(var i in items) {
                var item = $("<option></option>").attr("value", i).html(items[i]);
                if(i == selectedKey)
                    item.attr("selected", "selected");
                if(i == "")
                    select.prepend(item);
                else
                    select.append(item);
            }
        },

        jsonResponse: function(payload) {
            if(!(payload["type"] && payload["type"] == "JsonDependentSelectBoxResponse")) {
                $.nette.success(payload);
                return;
            }
            var items = payload["items"];
            for(var i in items) {
                $.dependentselectbox.updateSelectBox(i, items[i]["selected"], items[i]["items"]);
            }
        }
    }
});

$(document).ready(function() {
    $.dependentselectbox.initialize();
});