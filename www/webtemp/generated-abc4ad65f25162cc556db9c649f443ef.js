$(function() {

    $('.tooltip').tipsy({
        gravity: 's'
    });
});


$(document).ready(function () {
    $("input.date").each(function () { // input[type=date] does not work in IE
        var el = $(this);
        var value = el.val();
        var date = (value ? $.datepicker.parseDate($.datepicker.W3C, value) : null);
        var dateFormat = el.data("datepicker-dateformat") || $.datepicker.W3C;

        var minDate = el.attr("min") || null;
        if (minDate) minDate = $.datepicker.parseDate($.datepicker.W3C, minDate);
        var maxDate = el.attr("max") || null;
        if (maxDate) maxDate = $.datepicker.parseDate($.datepicker.W3C, maxDate);

        el.get(0).type = "text"; // changing via jQuery is prohibited, because of IE
        el.val($.datepicker.formatDate(dateFormat, date));
        el.datepicker({
            dateFormat: dateFormat,
            minDate: minDate,
            maxDate: maxDate
        });
    });
});


function Hash()
{
    this.length = 0;
    this.items = new Array();
    for (var i = 0; i < arguments.length; i += 2) {
        if (typeof(arguments[i + 1]) != 'undefined') {
            this.items[arguments[i]] = arguments[i + 1];
            this.length++;
        }
    }
   
    this.removeItem = function(in_key)
    {
        var tmp_previous;
        if (typeof(this.items[in_key]) != 'undefined') {
            this.length--;
            var tmp_previous = this.items[in_key];
            delete this.items[in_key];
        }
	   
        return tmp_previous;
    }

    this.getItem = function(in_key) {
        return this.items[in_key];
    }

    this.setItem = function(in_key, in_value)
    {
        var tmp_previous;
        if (typeof(in_value) != 'undefined') {
            if (typeof(this.items[in_key]) == 'undefined') {
                this.length++;
            }
            else {
                tmp_previous = this.items[in_key];
            }

            this.items[in_key] = in_value;
        }
	   
        return tmp_previous;
    }

    this.hasItem = function(in_key)
    {
        return typeof(this.items[in_key]) != 'undefined';
    }

    this.clear = function()
    {
        for (var i in this.items) {
            delete this.items[i];
        }

        this.length = 0;
    }
}


     /*
$(function() {
      $("#dialog").dialog({
         autoOpen: false,
         bgiframe: true,
         resizable: false,
         height:140,
         modal: true,
         overlay: {
            backgroundColor: '#000',
            opacity: 0.5
         },
         buttons: {
            'Storno': function() {
               $(this).dialog('close');
            },
            'Ano': function() {
               $(this).dialog('close');
            }
         }
      });
   });*/