/**
 * [blockSubmitBtn description]
 * @param  {Function} checkbox  [description]
 * @param  {[type]}   btn [description]
 * @return {[type]}       [description]
 */
function blockSubmitBtn(checkbox, btn, textClass) {

	/**
	 * [checkbox description]
	 * @type {[type]}
	 */
	var checkbox = document.getElementById(checkbox);
	var agreementText = document.getElementById(textClass);

	/**
	 * [disabled description]
	 * @type {Boolean}
	 */
	if (checkbox.checked) {
		document.getElementById(btn).disabled = false;
		document.getElementById(textClass).className = "text-primary";
	}
	else {
		document.getElementById(btn).disabled = true;
		document.getElementById(textClass).className = "text-danger";
	}
}	