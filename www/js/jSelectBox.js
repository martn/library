function returnObjById(id) {
	if (document.getElementById)
		var returnVar = document.getElementById(id);
	else if (document.all)
		var returnVar = document.all[id];
	else if (document.layers)
		var returnVar = document.layers[id];
	return returnVar;
}

function jSelectOnChange(selectedValue, childIds, data) {
	// $("#"+childId).removeOption(/./);
	// a = new Array(1 => 2, 2 => 3, 0 => 156);
	for ( var i = 0; value = childIds[i]; i++) {

		childElem = returnObjById(value);

		while (childElem.length > 0) {
			childElem.remove(0);
		}

		option = new Option('...................', 0);
		try {
			childElem.add(option, null); // standards compliant; doesn't
			// work in IE
		} catch (ex) {
			childElem.add(option); // IE only
		}
	}

	for ( var i = 0; child = data[i]; i++) {

		childElem = returnObjById(child[0]);

		options = child[1].getItem(selectedValue);

		for ( var k = 0; option = options[k]; k++) {
			try {
				childElem.add(option, null); // standards compliant; doesn't
				// work in IE
			} catch (ex) {
				childElem.add(option); // IE only
			}
		}
	}
}

/*
 * $('select.JSelectBox').change(function() { alert('Handler for .change()
 * called.'); });
 */