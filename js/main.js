/**
 * Application js file
 *
 * @author Georgian Dinca
 */


/**
 * Functia permite adaugarea unei valori la cookie-ul 'key', 
 * in cookie este un array
 */
jQuery.addToCookie = function (key, value) {
	var data = [];
	data = jQuery.cookie(key);
	data.push(value);
	jQuery.cookie(key, data);
}