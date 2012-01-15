/**
 * Application js file
 *
 * @author Georgian Dinca
 */


/**
 * Functia adauga o valoare la cookie-ul 'cookieKey',
 * in cookie este stocat un array
 */
jQuery.pushCookie = function (cookieKey, value) {
	console.log(value);
	console.log(cookieKey);
	var data = [];
	cookie = jQuery.cookie(cookieKey);
	console.log(cookie);
	data.concat(cookie,value);
	console.log(data);
	jQuery.cookie(cookieKey, data);
}

/**
 * Functia scoate o valoare din cookie-ul 'cookieKey' de la indexul 'popIndex',
 * in cookie este stocat un array
 */
jQuery.popCookie = function (cookieKey,popIndex) {
	var data = [];
	data = jQuery.cookie(cookieKey);
	data.splice(popIndex, 1);
	jQuery.cookie(cookieKey, data);
}

/**
 * Check type if it is array
 */
function isArray(a)
{
	return Object.prototype.toString.apply(a) === '[object Array]';
}