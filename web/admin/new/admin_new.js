/*
 * arrive.js
 * v2.4.1
 * https://github.com/uzairfarooq/arrive
 * MIT licensed
 *
 * Copyright (c) 2014-2017 Uzair Farooq
 */

var Arrive=function(e,t,n){"use strict";function r(e,t,n){l.addMethod(t,n,e.unbindEvent),l.addMethod(t,n,e.unbindEventWithSelectorOrCallback),l.addMethod(t,n,e.unbindEventWithSelectorAndCallback)}function i(e){e.arrive=f.bindEvent,r(f,e,"unbindArrive"),e.leave=d.bindEvent,r(d,e,"unbindLeave")}if(e.MutationObserver&&"undefined"!=typeof HTMLElement){var o=0,l=function(){var t=HTMLElement.prototype.matches||HTMLElement.prototype.webkitMatchesSelector||HTMLElement.prototype.mozMatchesSelector||HTMLElement.prototype.msMatchesSelector;return{matchesSelector:function(e,n){return e instanceof HTMLElement&&t.call(e,n)},addMethod:function(e,t,r){var i=e[t];e[t]=function(){return r.length==arguments.length?r.apply(this,arguments):"function"==typeof i?i.apply(this,arguments):n}},callCallbacks:function(e,t){t&&t.options.onceOnly&&1==t.firedElems.length&&(e=[e[0]]);for(var n,r=0;n=e[r];r++)n&&n.callback&&n.callback.call(n.elem,n.elem);t&&t.options.onceOnly&&1==t.firedElems.length&&t.me.unbindEventWithSelectorAndCallback.call(t.target,t.selector,t.callback)},checkChildNodesRecursively:function(e,t,n,r){for(var i,o=0;i=e[o];o++)n(i,t,r)&&r.push({callback:t.callback,elem:i}),i.childNodes.length>0&&l.checkChildNodesRecursively(i.childNodes,t,n,r)},mergeArrays:function(e,t){var n,r={};for(n in e)e.hasOwnProperty(n)&&(r[n]=e[n]);for(n in t)t.hasOwnProperty(n)&&(r[n]=t[n]);return r},toElementsArray:function(t){return n===t||"number"==typeof t.length&&t!==e||(t=[t]),t}}}(),c=function(){var e=function(){this._eventsBucket=[],this._beforeAdding=null,this._beforeRemoving=null};return e.prototype.addEvent=function(e,t,n,r){var i={target:e,selector:t,options:n,callback:r,firedElems:[]};return this._beforeAdding&&this._beforeAdding(i),this._eventsBucket.push(i),i},e.prototype.removeEvent=function(e){for(var t,n=this._eventsBucket.length-1;t=this._eventsBucket[n];n--)if(e(t)){this._beforeRemoving&&this._beforeRemoving(t);var r=this._eventsBucket.splice(n,1);r&&r.length&&(r[0].callback=null)}},e.prototype.beforeAdding=function(e){this._beforeAdding=e},e.prototype.beforeRemoving=function(e){this._beforeRemoving=e},e}(),a=function(t,r){var i=new c,o=this,a={fireOnAttributesModification:!1};return i.beforeAdding(function(n){var i,l=n.target;(l===e.document||l===e)&&(l=document.getElementsByTagName("html")[0]),i=new MutationObserver(function(e){r.call(this,e,n)});var c=t(n.options);i.observe(l,c),n.observer=i,n.me=o}),i.beforeRemoving(function(e){e.observer.disconnect()}),this.bindEvent=function(e,t,n){t=l.mergeArrays(a,t);for(var r=l.toElementsArray(this),o=0;o<r.length;o++)i.addEvent(r[o],e,t,n)},this.unbindEvent=function(){var e=l.toElementsArray(this);i.removeEvent(function(t){for(var r=0;r<e.length;r++)if(this===n||t.target===e[r])return!0;return!1})},this.unbindEventWithSelectorOrCallback=function(e){var t,r=l.toElementsArray(this),o=e;t="function"==typeof e?function(e){for(var t=0;t<r.length;t++)if((this===n||e.target===r[t])&&e.callback===o)return!0;return!1}:function(t){for(var i=0;i<r.length;i++)if((this===n||t.target===r[i])&&t.selector===e)return!0;return!1},i.removeEvent(t)},this.unbindEventWithSelectorAndCallback=function(e,t){var r=l.toElementsArray(this);i.removeEvent(function(i){for(var o=0;o<r.length;o++)if((this===n||i.target===r[o])&&i.selector===e&&i.callback===t)return!0;return!1})},this},s=function(){function e(e){var t={attributes:!1,childList:!0,subtree:!0};return e.fireOnAttributesModification&&(t.attributes=!0),t}function t(e,t){e.forEach(function(e){var n=e.addedNodes,i=e.target,o=[];null!==n&&n.length>0?l.checkChildNodesRecursively(n,t,r,o):"attributes"===e.type&&r(i,t,o)&&o.push({callback:t.callback,elem:i}),l.callCallbacks(o,t)})}function r(e,t){return l.matchesSelector(e,t.selector)&&(e._id===n&&(e._id=o++),-1==t.firedElems.indexOf(e._id))?(t.firedElems.push(e._id),!0):!1}var i={fireOnAttributesModification:!1,onceOnly:!1,existing:!1};f=new a(e,t);var c=f.bindEvent;return f.bindEvent=function(e,t,r){n===r?(r=t,t=i):t=l.mergeArrays(i,t);var o=l.toElementsArray(this);if(t.existing){for(var a=[],s=0;s<o.length;s++)for(var u=o[s].querySelectorAll(e),f=0;f<u.length;f++)a.push({callback:r,elem:u[f]});if(t.onceOnly&&a.length)return r.call(a[0].elem,a[0].elem);setTimeout(l.callCallbacks,1,a)}c.call(this,e,t,r)},f},u=function(){function e(){var e={childList:!0,subtree:!0};return e}function t(e,t){e.forEach(function(e){var n=e.removedNodes,i=[];null!==n&&n.length>0&&l.checkChildNodesRecursively(n,t,r,i),l.callCallbacks(i,t)})}function r(e,t){return l.matchesSelector(e,t.selector)}var i={};d=new a(e,t);var o=d.bindEvent;return d.bindEvent=function(e,t,r){n===r?(r=t,t=i):t=l.mergeArrays(i,t),o.call(this,e,t,r)},d},f=new s,d=new u;t&&i(t.fn),i(HTMLElement.prototype),i(NodeList.prototype),i(HTMLCollection.prototype),i(HTMLDocument.prototype),i(Window.prototype);var h={};return r(f,h,"unbindAllArrive"),r(d,h,"unbindAllLeave"),h}}(window,"undefined"==typeof jQuery?null:jQuery,void 0);
/*! hotkeys-js v3.8.7 | MIT (c) 2021 kenny wong <wowohoo@qq.com> | http://jaywcjlove.github.io/hotkeys */
!function(e,t){"object"==typeof exports&&"undefined"!=typeof module?module.exports=t():"function"==typeof define&&define.amd?define(t):(e="undefined"!=typeof globalThis?globalThis:e||self).hotkeys=t()}(this,function(){"use strict";var e="undefined"!=typeof navigator&&0<navigator.userAgent.toLowerCase().indexOf("firefox");function u(e,t,n){e.addEventListener?e.addEventListener(t,n,!1):e.attachEvent&&e.attachEvent("on".concat(t),function(){n(window.event)})}function p(e,t){for(var n=t.slice(0,t.length-1),o=0;o<n.length;o++)n[o]=e[n[o].toLowerCase()];return n}function d(e){for(var t=(e=(e="string"!=typeof e?"":e).replace(/\s/g,"")).split(","),n=t.lastIndexOf("");0<=n;)t[n-1]+=",",t.splice(n,1),n=t.lastIndexOf("");return t}for(var t={backspace:8,tab:9,clear:12,enter:13,return:13,esc:27,escape:27,space:32,left:37,up:38,right:39,down:40,del:46,delete:46,ins:45,insert:45,home:36,end:35,pageup:33,pagedown:34,capslock:20,num_0:96,num_1:97,num_2:98,num_3:99,num_4:100,num_5:101,num_6:102,num_7:103,num_8:104,num_9:105,num_multiply:106,num_add:107,num_enter:108,num_subtract:109,num_decimal:110,num_divide:111,"\u21ea":20,",":188,".":190,"/":191,"`":192,"-":e?173:189,"=":e?61:187,";":e?59:186,"'":222,"[":219,"]":221,"\\":220},y={"\u21e7":16,shift:16,"\u2325":18,alt:18,option:18,"\u2303":17,ctrl:17,control:17,"\u2318":91,cmd:91,command:91},h={16:"shiftKey",18:"altKey",17:"ctrlKey",91:"metaKey",shiftKey:16,ctrlKey:17,altKey:18,metaKey:91},m={16:!1,18:!1,17:!1,91:!1},g={},n=1;n<20;n++)t["f".concat(n)]=111+n;var v=[],o="all",w=[],k=function(e){return t[e.toLowerCase()]||y[e.toLowerCase()]||e.toUpperCase().charCodeAt(0)};function r(e){o=e||"all"}function O(){return o||"all"}function f(e){var i=e.scope,r=e.method,t=e.splitKey,f=void 0===t?"+":t;d(e.key).forEach(function(e){var t,n=e.split(f),o=n.length,e=n[o-1],e="*"===e?"*":k(e);g[e]&&(i=i||O(),t=1<o?p(y,n):[],g[e]=g[e].map(function(e){return r&&e.method!==r||e.scope!==i||!function(e,t){for(var n=e.length<t.length?t:e,o=e.length<t.length?e:t,i=!0,r=0;r<n.length;r++)~o.indexOf(n[r])||(i=!1);return i}(e.mods,t)?e:{}}))})}function K(e,t,n){var o;if(t.scope===n||"all"===t.scope){for(var i in o=0<t.mods.length,m)Object.prototype.hasOwnProperty.call(m,i)&&(!m[i]&&~t.mods.indexOf(+i)||m[i]&&!~t.mods.indexOf(+i))&&(o=!1);(0!==t.mods.length||m[16]||m[18]||m[17]||m[91])&&!o&&"*"!==t.shortcut||!1===t.method(e,t)&&(e.preventDefault?e.preventDefault():e.returnValue=!1,e.stopPropagation&&e.stopPropagation(),e.cancelBubble&&(e.cancelBubble=!0))}}function b(n){var e=g["*"],t=n.keyCode||n.which||n.charCode;if(x.filter.call(this,n)){if(~v.indexOf(t=93===t||224===t?91:t)||229===t||v.push(t),["ctrlKey","altKey","shiftKey","metaKey"].forEach(function(e){var t=h[e];n[e]&&!~v.indexOf(t)?v.push(t):!n[e]&&~v.indexOf(t)?v.splice(v.indexOf(t),1):"metaKey"===e&&n[e]&&3===v.length&&(n.ctrlKey||n.shiftKey||n.altKey||(v=v.slice(v.indexOf(t))))}),t in m){for(var o in m[t]=!0,y)y[o]===t&&(x[o]=!0);if(!e)return}for(var i in m)Object.prototype.hasOwnProperty.call(m,i)&&(m[i]=n[h[i]]);n.getModifierState&&(!n.altKey||n.ctrlKey)&&n.getModifierState("AltGraph")&&(~v.indexOf(17)||v.push(17),~v.indexOf(18)||v.push(18),m[17]=!0,m[18]=!0);var r=O();if(e)for(var f=0;f<e.length;f++)e[f].scope===r&&("keydown"===n.type&&e[f].keydown||"keyup"===n.type&&e[f].keyup)&&K(n,e[f],r);if(t in g)for(var a=0;a<g[t].length;a++)if(("keydown"===n.type&&g[t][a].keydown||"keyup"===n.type&&g[t][a].keyup)&&g[t][a].key){for(var c=g[t][a],l=c.key.split(c.splitKey),s=[],u=0;u<l.length;u++)s.push(k(l[u]));s.sort().join("")===v.sort().join("")&&K(n,c,r)}}}function x(e,t,n){v=[];var o=d(e),i=[],r="all",f=document,a=0,c=!1,l=!0,s="+";for(void 0===n&&"function"==typeof t&&(n=t),"[object Object]"===Object.prototype.toString.call(t)&&(t.scope&&(r=t.scope),t.element&&(f=t.element),t.keyup&&(c=t.keyup),void 0!==t.keydown&&(l=t.keydown),"string"==typeof t.splitKey&&(s=t.splitKey)),"string"==typeof t&&(r=t);a<o.length;a++)i=[],1<(e=o[a].split(s)).length&&(i=p(y,e)),(e="*"===(e=e[e.length-1])?"*":k(e))in g||(g[e]=[]),g[e].push({keyup:c,keydown:l,scope:r,mods:i,shortcut:o[a],method:n,key:o[a],splitKey:s});void 0!==f&&(t=f,!~w.indexOf(t))&&window&&(w.push(f),u(f,"keydown",function(e){b(e)}),u(window,"focus",function(){v=[]}),u(f,"keyup",function(e){b(e),function(e){var t=e.keyCode||e.which||e.charCode,n=v.indexOf(t);if(n<0||v.splice(n,1),e.key&&"meta"==e.key.toLowerCase()&&v.splice(0,v.length),(t=93===t||224===t?91:t)in m)for(var o in m[t]=!1,y)y[o]===t&&(x[o]=!1)}(e)}))}var i,a,c={setScope:r,getScope:O,deleteScope:function(e,t){var n,o,i;for(i in e=e||O(),g)if(Object.prototype.hasOwnProperty.call(g,i))for(n=g[i],o=0;o<n.length;)n[o].scope===e?n.splice(o,1):o++;O()===e&&r(t||"all")},getPressedKeyCodes:function(){return v.slice(0)},isPressed:function(e){return"string"==typeof e&&(e=k(e)),!!~v.indexOf(e)},filter:function(e){var t=e.target||e.srcElement,e=t.tagName;return!t.isContentEditable&&("INPUT"!==e&&"TEXTAREA"!==e&&"SELECT"!==e||t.readOnly)?!0:!1},unbind:function(e){if(e){if(Array.isArray(e))e.forEach(function(e){e.key&&f(e)});else if("object"==typeof e)e.key&&f(e);else if("string"==typeof e){for(var t=arguments.length,n=Array(1<t?t-1:0),o=1;o<t;o++)n[o-1]=arguments[o];var i=n[0],r=n[1];"function"==typeof i&&(r=i,i=""),f({key:e,scope:i,method:r,splitKey:"+"})}}else Object.keys(g).forEach(function(e){return delete g[e]})}};for(i in c)Object.prototype.hasOwnProperty.call(c,i)&&(x[i]=c[i]);return"undefined"!=typeof window&&(a=window.hotkeys,x.noConflict=function(e){return e&&window.hotkeys===x&&(window.hotkeys=a),x},window.hotkeys=x),x});
(function(funcName, baseObj) {
    // The public function name defaults to window.docReady
    // but you can pass in your own object and own function name and those will be used
    // if you want to put them in a different namespace
    funcName = funcName || "docReady";
    baseObj = baseObj || window;
    var readyList = [];
    var readyFired = false;
    var readyEventHandlersInstalled = false;

    // call this when the document is ready
    // this function protects itself against being called more than once
    function ready() {
        if (!readyFired) {
            // this must be set to true before we start calling callbacks
            readyFired = true;
            for (var i = 0; i < readyList.length; i++) {
                // if a callback here happens to add new ready handlers,
                // the docReady() function will see that it already fired
                // and will schedule the callback to run right after
                // this event loop finishes so all handlers will still execute
                // in order and no new ones will be added to the readyList
                // while we are processing the list
                readyList[i].fn.call(window, readyList[i].ctx);
            }
            // allow any closures held by these functions to free
            readyList = [];
        }
    }

    function readyStateChange() {
        if ( document.readyState === "complete" ) {
            ready();
        }
    }

    // This is the one public interface
    // docReady(fn, context);
    // the context argument is optional - if present, it will be passed
    // as an argument to the callback
    baseObj[funcName] = function(callback, context) {
        if (typeof callback !== "function") {
            throw new TypeError("callback for docReady(fn) must be a function");
        }
        // if ready has already fired, then just schedule the callback
        // to fire asynchronously, but right away
        if (readyFired) {
            setTimeout(function() {callback(context);}, 1);
            return;
        } else {
            // add the function and context to the list
            readyList.push({fn: callback, ctx: context});
        }
        // if document already ready to go, schedule the ready function to run
        if (document.readyState === "complete") {
            setTimeout(ready, 1);
        } else if (!readyEventHandlersInstalled) {
            // otherwise if we don't have event handlers installed, install them
            if (document.addEventListener) {
                // first choice is DOMContentLoaded event
                document.addEventListener("DOMContentLoaded", ready, false);
                // backup is window load event
                window.addEventListener("load", ready, false);
            } else {
                // must be IE
                document.attachEvent("onreadystatechange", readyStateChange);
                window.attachEvent("onload", ready);
            }
            readyEventHandlersInstalled = true;
        }
    }
})("docReady", window);

(function() {
	function reportError(err) {
		throw new Error(err);
	}
	function getDataAttribute(elm, attr) {
		if (elm.getAttribute) {
			if (elm.getAttribute("data-" + attr)) {
				return elm.getAttribute("data-" + attr);
			} else {
				return '';
			}
		}
	}
	function addClass(elm, c) {
		try {
			if (!elm.hasAttribute('class')) {
				elm.setAttribute('class', c);
			} else {
				elm.setAttribute('class', 
					elm.getAttribute('class') + ' ' + c);
			}
		} catch(err) {
			reportError('Failed to add class ' + c);
		}
	}
	function removeClass(elm, c) {
		try {
			if (!elm.hasAttribute('class')) {
				reportError('Cannot remove a class from an element lacking one!');
			} else if (elm.getAttribute('class') == c) {
				elm.removeAttribute('class');
			} else {
				elm.setAttribute('class', 
					elm.getAttribute('class')
					.replaceAll(' ' + c, ''));
			}
		} catch(err) {
			reportError('Failed to remove class ' + c);
		}
	}
	
	function isSelected(elm) {
		if (elm.getAttribute('class').search('selected') > -1) {
			return true;
		} else {
			return false;
		}
	}
	function softChangeUrl(url, replace = false) {
		try {
			if (replace == true) {
				window.history.replaceState(null, '', url);
			} else {
				window.history.pushState(null, '', url);
			}
		} catch(err) {
			reportError('Failed to change URL to ' + url);
		}
	}
	function updatePanelManagerHtml(panel, html) {
		try {
			panel.querySelector(".manage").innerHTML = html;
		} catch(err) {
			reportError('Could not update panel manager HTML: ' + err);
		}
	}
	function failPanelManagerUpdate(err, panel, callerElm) {
		removeClass(panel, 'managing');
		var inputbox = callerElm.parentNode;
		if (!inputbox.querySelector('.error')) {
			inputbox.insertAdjacentHTML('beforeend', '<div class="error"></div>');
		}
		inputbox.querySelector('.error').innerHTML = err;
	}
	function updatePanelManager(api, query, callerElm) {
		var panel = document.querySelector('.admin-container .' + navGetActivePanelId());
		try {
			updatePanelManagerHtml(panel, window.sr.getConfig('LOADING_HTML'));
			addClass(panel, 'managing');
			$.ajax({
				url: "/admin/new/" + api,
				method: "POST",
				data: {"username": query}
			})
				.done((res) => {
					if (!res.error) {
						updatePanelManagerHtml(panel, res.content_html);
					} else {
						failPanelManagerUpdate(res.error, panel, callerElm);
					}
				})
				.fail((a,b,err) => failPanelManagerUpdate(err, panel, callerElm));
		} catch(err) {
			failPanelManagerUpdate('Unknown error: ' + err, panel, callerElm);
		}
	}
	function handleFormSubmit(e) {
		try {
			const formValue = e.target[0].value;
			if (formValue == "") {
				return null;
			}
			var form = e.target;
			const formType = getDataAttribute(form, 'form-type');
			switch (formType) {
				case 'manage-ajax':
					updatePanelManager(getDataAttribute(form, 'api'),
						formValue, form);
					break;
			}
		} catch(err) {
			reportError('Failed to handle form submission: ' + err);
		}
	}
	function navGetActivePanelId() {
		var a = navGetActiveTab();
		return getDataAttribute(a, "panel-id");
	}
	function navHandleKbdShortcut(panelId) {
		const tab = document.querySelector('.nav-item[data-panel-id=' + panelId + ']');
		navSwitchTab(tab);
	}
	function navOnKbdShortcut(key) {
		var a = navGetTabs();
		for (var i = 0, j = a.length; i < j; i++) {
			var shortcuts = getDataAttribute(a[i], 'shortcut').split('');
			for (var y = 0, u = shortcuts.length; y < u; y++) {
				if (key == shortcuts[y]) {
					navHandleKbdShortcut(getDataAttribute(a[i], 'panel-id'));
				}
			}
		}
	}
	function navInitKbdShortcuts() {
		hotkeys('*', function(e, h) {
			navOnKbdShortcut(e.key);
		});
	}
	function navGetSetActiveTabVar(set = false) {
		if (typeof window.sr.config_.ADMIN_ACTIVE_TAB == 'undefined' || set) {
			var active = getDataAttribute(document.querySelector(".nav-item.selected"),
				'panel-id').replace('admin-', '');
			window.sr.setConfig('ADMIN_ACTIVE_TAB', 'active');
			return active;
		} else {
			return window.sr.getConfig('ADMIN_ACTIVE_TAB');
		}
	}
	function navPostSwitchFocus(activePanel) {
		try {
			if (activePanel.querySelector(".admin-autofocus")) {
				var a = setTimeout(function() {
					activePanel.querySelector(".admin-autofocus").focus()
				}, 50);
			}
		} catch(err) {
			reportError('Failed to focus on autofocus element');
		}
	}
	function navPostSwitchEvent(activePanel) {
		navPostSwitchFocus(activePanel);
	}
	function navSelect(input) {
		if (!Array.isArray(input)) {
			addClass(input, 'selected');
		} else {
			for (var i = 0, j = input.length; i < j; i++) {
				addClass(input[i], 'selected');
			}
		}
	}
	function navDeselectAll() {
		var a = navGetTabs();
		var b = document.querySelectorAll(".admin-panel");
		// There is absolutely a better way to do this,
		// but this works well enough.
		for (var i = 0, j = a.length; i < j; i++) {
			removeClass(a[i], 'selected');
		}
		for (var i = 0, j = b.length; i < j; i++) {
			removeClass(b[i], 'selected');
		}
	}
	function navSwitchTab(elm, ignoreUrl = false) {
		if (!isSelected(elm)) {
			const panelId = navGetPanelId(elm);
			const panel = document.querySelector('.' + panelId);
			const href = elm.getAttribute('href');
			if (!ignoreUrl) {
				softChangeUrl(href);
			}
			navDeselectAll();
			navSelect([elm, panel]);
			navGetSetActiveTabVar(true);
			navPostSwitchEvent(panel);
		}
	}
	function navRegisterClickEvent(elm) {
		try {
			elm.onclick = function(e) {e.preventDefault();};
			elm.addEventListener("click", (e) => navSwitchTab(e.target));
		} catch(err) {
			reportError('Failed to register click event');
		}
	}
	function navGetTabByHref(href) {
		var a = navGetTabs();
		for (var i = 0, j = a.length; i < j; i++) {
			if (a[i].getAttribute("href") == href) {
				return a[i];
			} else if (i == j) {
				return null;
			}
		}
	}
	function navGetTabs() {
		return document.querySelector(".admin-nav").children;
	}
	function navGetActiveTab() {
		return document.querySelector(".admin-nav .nav-item.selected");
	}
	function navGetPanelId(elm) {
		return getDataAttribute(elm, 'panel-id');
	}
	function registerNav() {
		var a = navGetTabs();
		for (var i = 0, j = a.length; i < j; i++) {
			navRegisterClickEvent(a[i]);
		}
		navGetSetActiveTabVar();
		navPostSwitchEvent(document.querySelector('.' + navGetPanelId(navGetActiveTab())));
		navInitKbdShortcuts();
	}
	function registerForm(elm) {
		try {
			elm.addEventListener("submit", (e) => {
				e.preventDefault();
				handleFormSubmit(e);
			});
		} catch (err) {
			reportError('Failed to register submit event');
		}
	}
	function initForms() {
		var a = document.querySelectorAll('.admin-container form');
		for (var i = 0, j = a.length; i < j; i++) {
			registerForm(a[i]);
		}
	}
	function handleHistoryPop() {
		try {
			var newPath = window.location.pathname;
			var tab = navGetTabByHref(newPath);
			if (tab != null) {
				navSwitchTab(tab, true);
			}
		} catch(err) {
			reportError('Failed to handle history pop event')
		}
	}
	function init() {
		registerNav();
		initForms();
		document.querySelector(".admin-nav").arrive(".nav-item", () => navRegisterClickEvent(this));
		window.addEventListener('popstate', (e) => {
			handleHistoryPop();
		});
	}
	docReady(init);
})();