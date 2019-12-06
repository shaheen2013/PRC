/******/ (function(modules) { // webpackBootstrap
/******/ 	// The module cache
/******/ 	var installedModules = {};
/******/
/******/ 	// The require function
/******/ 	function __webpack_require__(moduleId) {
/******/
/******/ 		// Check if module is in cache
/******/ 		if(installedModules[moduleId]) {
/******/ 			return installedModules[moduleId].exports;
/******/ 		}
/******/ 		// Create a new module (and put it into the cache)
/******/ 		var module = installedModules[moduleId] = {
/******/ 			i: moduleId,
/******/ 			l: false,
/******/ 			exports: {}
/******/ 		};
/******/
/******/ 		// Execute the module function
/******/ 		modules[moduleId].call(module.exports, module, module.exports, __webpack_require__);
/******/
/******/ 		// Flag the module as loaded
/******/ 		module.l = true;
/******/
/******/ 		// Return the exports of the module
/******/ 		return module.exports;
/******/ 	}
/******/
/******/
/******/ 	// expose the modules object (__webpack_modules__)
/******/ 	__webpack_require__.m = modules;
/******/
/******/ 	// expose the module cache
/******/ 	__webpack_require__.c = installedModules;
/******/
/******/ 	// define getter function for harmony exports
/******/ 	__webpack_require__.d = function(exports, name, getter) {
/******/ 		if(!__webpack_require__.o(exports, name)) {
/******/ 			Object.defineProperty(exports, name, {
/******/ 				configurable: false,
/******/ 				enumerable: true,
/******/ 				get: getter
/******/ 			});
/******/ 		}
/******/ 	};
/******/
/******/ 	// getDefaultExport function for compatibility with non-harmony modules
/******/ 	__webpack_require__.n = function(module) {
/******/ 		var getter = module && module.__esModule ?
/******/ 			function getDefault() { return module['default']; } :
/******/ 			function getModuleExports() { return module; };
/******/ 		__webpack_require__.d(getter, 'a', getter);
/******/ 		return getter;
/******/ 	};
/******/
/******/ 	// Object.prototype.hasOwnProperty.call
/******/ 	__webpack_require__.o = function(object, property) { return Object.prototype.hasOwnProperty.call(object, property); };
/******/
/******/ 	// __webpack_public_path__
/******/ 	__webpack_require__.p = "";
/******/
/******/ 	// Load entry module and return exports
/******/ 	return __webpack_require__(__webpack_require__.s = 0);
/******/ })
/************************************************************************/
/******/ ([
/* 0 */
/***/ (function(module, exports, __webpack_require__) {

__webpack_require__(1);
module.exports = __webpack_require__(12);


/***/ }),
/* 1 */
/***/ (function(module, exports, __webpack_require__) {

Nova.booting(function (Vue, router, store) {
    Vue.component('community-list-dashboard', __webpack_require__(2));
});

/***/ }),
/* 2 */
/***/ (function(module, exports, __webpack_require__) {

var disposed = false
function injectStyle (ssrContext) {
  if (disposed) return
  __webpack_require__(3)
}
var normalizeComponent = __webpack_require__(8)
/* script */
var __vue_script__ = __webpack_require__(9)
/* template */
var __vue_template__ = __webpack_require__(11)
/* template functional */
var __vue_template_functional__ = false
/* styles */
var __vue_styles__ = injectStyle
/* scopeId */
var __vue_scopeId__ = "data-v-b9bc2c0a"
/* moduleIdentifier (server only) */
var __vue_module_identifier__ = null
var Component = normalizeComponent(
  __vue_script__,
  __vue_template__,
  __vue_template_functional__,
  __vue_styles__,
  __vue_scopeId__,
  __vue_module_identifier__
)
Component.options.__file = "resources/js/components/Card.vue"

/* hot reload */
if (false) {(function () {
  var hotAPI = require("vue-hot-reload-api")
  hotAPI.install(require("vue"), false)
  if (!hotAPI.compatible) return
  module.hot.accept()
  if (!module.hot.data) {
    hotAPI.createRecord("data-v-b9bc2c0a", Component.options)
  } else {
    hotAPI.reload("data-v-b9bc2c0a", Component.options)
  }
  module.hot.dispose(function (data) {
    disposed = true
  })
})()}

module.exports = Component.exports


/***/ }),
/* 3 */
/***/ (function(module, exports, __webpack_require__) {

// style-loader: Adds some css to the DOM by adding a <style> tag

// load the styles
var content = __webpack_require__(4);
if(typeof content === 'string') content = [[module.i, content, '']];
if(content.locals) module.exports = content.locals;
// add the styles to the DOM
var update = __webpack_require__(6)("470b3d6e", content, false, {});
// Hot Module Replacement
if(false) {
 // When the styles change, update the <style> tags
 if(!content.locals) {
   module.hot.accept("!!../../../node_modules/css-loader/index.js!../../../node_modules/vue-loader/lib/style-compiler/index.js?{\"vue\":true,\"id\":\"data-v-b9bc2c0a\",\"scoped\":true,\"hasInlineConfig\":true}!../../../node_modules/vue-loader/lib/selector.js?type=styles&index=0!./Card.vue", function() {
     var newContent = require("!!../../../node_modules/css-loader/index.js!../../../node_modules/vue-loader/lib/style-compiler/index.js?{\"vue\":true,\"id\":\"data-v-b9bc2c0a\",\"scoped\":true,\"hasInlineConfig\":true}!../../../node_modules/vue-loader/lib/selector.js?type=styles&index=0!./Card.vue");
     if(typeof newContent === 'string') newContent = [[module.id, newContent, '']];
     update(newContent);
   });
 }
 // When the module is disposed, remove the <style> tags
 module.hot.dispose(function() { update(); });
}

/***/ }),
/* 4 */
/***/ (function(module, exports, __webpack_require__) {

exports = module.exports = __webpack_require__(5)(false);
// imports


// module
exports.push([module.i, "\n.resultsBox[data-v-b9bc2c0a] {\n    border: 1px solid #7F888F;\n    border-radius: 5px;\n    height: 200px;\n    width: 200px;\n}\n.hoverShadow[data-v-b9bc2c0a]:hover {\n    -webkit-box-shadow: 0 15px 30px 0 rgba(0, 0, 0, .11), 0 5px 15px 0 rgba(0, 0, 0, .08);\n            box-shadow: 0 15px 30px 0 rgba(0, 0, 0, .11), 0 5px 15px 0 rgba(0, 0, 0, .08);\n}\n.hoverShadow[data-v-b9bc2c0a]:focus {\n    -webkit-box-shadow: 0 0 0 0;\n            box-shadow: 0 0 0 0;\n}\n", ""]);

// exports


/***/ }),
/* 5 */
/***/ (function(module, exports) {

/*
	MIT License http://www.opensource.org/licenses/mit-license.php
	Author Tobias Koppers @sokra
*/
// css base code, injected by the css-loader
module.exports = function(useSourceMap) {
	var list = [];

	// return the list of modules as css string
	list.toString = function toString() {
		return this.map(function (item) {
			var content = cssWithMappingToString(item, useSourceMap);
			if(item[2]) {
				return "@media " + item[2] + "{" + content + "}";
			} else {
				return content;
			}
		}).join("");
	};

	// import a list of modules into the list
	list.i = function(modules, mediaQuery) {
		if(typeof modules === "string")
			modules = [[null, modules, ""]];
		var alreadyImportedModules = {};
		for(var i = 0; i < this.length; i++) {
			var id = this[i][0];
			if(typeof id === "number")
				alreadyImportedModules[id] = true;
		}
		for(i = 0; i < modules.length; i++) {
			var item = modules[i];
			// skip already imported module
			// this implementation is not 100% perfect for weird media query combinations
			//  when a module is imported multiple times with different media queries.
			//  I hope this will never occur (Hey this way we have smaller bundles)
			if(typeof item[0] !== "number" || !alreadyImportedModules[item[0]]) {
				if(mediaQuery && !item[2]) {
					item[2] = mediaQuery;
				} else if(mediaQuery) {
					item[2] = "(" + item[2] + ") and (" + mediaQuery + ")";
				}
				list.push(item);
			}
		}
	};
	return list;
};

function cssWithMappingToString(item, useSourceMap) {
	var content = item[1] || '';
	var cssMapping = item[3];
	if (!cssMapping) {
		return content;
	}

	if (useSourceMap && typeof btoa === 'function') {
		var sourceMapping = toComment(cssMapping);
		var sourceURLs = cssMapping.sources.map(function (source) {
			return '/*# sourceURL=' + cssMapping.sourceRoot + source + ' */'
		});

		return [content].concat(sourceURLs).concat([sourceMapping]).join('\n');
	}

	return [content].join('\n');
}

// Adapted from convert-source-map (MIT)
function toComment(sourceMap) {
	// eslint-disable-next-line no-undef
	var base64 = btoa(unescape(encodeURIComponent(JSON.stringify(sourceMap))));
	var data = 'sourceMappingURL=data:application/json;charset=utf-8;base64,' + base64;

	return '/*# ' + data + ' */';
}


/***/ }),
/* 6 */
/***/ (function(module, exports, __webpack_require__) {

/*
  MIT License http://www.opensource.org/licenses/mit-license.php
  Author Tobias Koppers @sokra
  Modified by Evan You @yyx990803
*/

var hasDocument = typeof document !== 'undefined'

if (typeof DEBUG !== 'undefined' && DEBUG) {
  if (!hasDocument) {
    throw new Error(
    'vue-style-loader cannot be used in a non-browser environment. ' +
    "Use { target: 'node' } in your Webpack config to indicate a server-rendering environment."
  ) }
}

var listToStyles = __webpack_require__(7)

/*
type StyleObject = {
  id: number;
  parts: Array<StyleObjectPart>
}

type StyleObjectPart = {
  css: string;
  media: string;
  sourceMap: ?string
}
*/

var stylesInDom = {/*
  [id: number]: {
    id: number,
    refs: number,
    parts: Array<(obj?: StyleObjectPart) => void>
  }
*/}

var head = hasDocument && (document.head || document.getElementsByTagName('head')[0])
var singletonElement = null
var singletonCounter = 0
var isProduction = false
var noop = function () {}
var options = null
var ssrIdKey = 'data-vue-ssr-id'

// Force single-tag solution on IE6-9, which has a hard limit on the # of <style>
// tags it will allow on a page
var isOldIE = typeof navigator !== 'undefined' && /msie [6-9]\b/.test(navigator.userAgent.toLowerCase())

module.exports = function (parentId, list, _isProduction, _options) {
  isProduction = _isProduction

  options = _options || {}

  var styles = listToStyles(parentId, list)
  addStylesToDom(styles)

  return function update (newList) {
    var mayRemove = []
    for (var i = 0; i < styles.length; i++) {
      var item = styles[i]
      var domStyle = stylesInDom[item.id]
      domStyle.refs--
      mayRemove.push(domStyle)
    }
    if (newList) {
      styles = listToStyles(parentId, newList)
      addStylesToDom(styles)
    } else {
      styles = []
    }
    for (var i = 0; i < mayRemove.length; i++) {
      var domStyle = mayRemove[i]
      if (domStyle.refs === 0) {
        for (var j = 0; j < domStyle.parts.length; j++) {
          domStyle.parts[j]()
        }
        delete stylesInDom[domStyle.id]
      }
    }
  }
}

function addStylesToDom (styles /* Array<StyleObject> */) {
  for (var i = 0; i < styles.length; i++) {
    var item = styles[i]
    var domStyle = stylesInDom[item.id]
    if (domStyle) {
      domStyle.refs++
      for (var j = 0; j < domStyle.parts.length; j++) {
        domStyle.parts[j](item.parts[j])
      }
      for (; j < item.parts.length; j++) {
        domStyle.parts.push(addStyle(item.parts[j]))
      }
      if (domStyle.parts.length > item.parts.length) {
        domStyle.parts.length = item.parts.length
      }
    } else {
      var parts = []
      for (var j = 0; j < item.parts.length; j++) {
        parts.push(addStyle(item.parts[j]))
      }
      stylesInDom[item.id] = { id: item.id, refs: 1, parts: parts }
    }
  }
}

function createStyleElement () {
  var styleElement = document.createElement('style')
  styleElement.type = 'text/css'
  head.appendChild(styleElement)
  return styleElement
}

function addStyle (obj /* StyleObjectPart */) {
  var update, remove
  var styleElement = document.querySelector('style[' + ssrIdKey + '~="' + obj.id + '"]')

  if (styleElement) {
    if (isProduction) {
      // has SSR styles and in production mode.
      // simply do nothing.
      return noop
    } else {
      // has SSR styles but in dev mode.
      // for some reason Chrome can't handle source map in server-rendered
      // style tags - source maps in <style> only works if the style tag is
      // created and inserted dynamically. So we remove the server rendered
      // styles and inject new ones.
      styleElement.parentNode.removeChild(styleElement)
    }
  }

  if (isOldIE) {
    // use singleton mode for IE9.
    var styleIndex = singletonCounter++
    styleElement = singletonElement || (singletonElement = createStyleElement())
    update = applyToSingletonTag.bind(null, styleElement, styleIndex, false)
    remove = applyToSingletonTag.bind(null, styleElement, styleIndex, true)
  } else {
    // use multi-style-tag mode in all other cases
    styleElement = createStyleElement()
    update = applyToTag.bind(null, styleElement)
    remove = function () {
      styleElement.parentNode.removeChild(styleElement)
    }
  }

  update(obj)

  return function updateStyle (newObj /* StyleObjectPart */) {
    if (newObj) {
      if (newObj.css === obj.css &&
          newObj.media === obj.media &&
          newObj.sourceMap === obj.sourceMap) {
        return
      }
      update(obj = newObj)
    } else {
      remove()
    }
  }
}

var replaceText = (function () {
  var textStore = []

  return function (index, replacement) {
    textStore[index] = replacement
    return textStore.filter(Boolean).join('\n')
  }
})()

function applyToSingletonTag (styleElement, index, remove, obj) {
  var css = remove ? '' : obj.css

  if (styleElement.styleSheet) {
    styleElement.styleSheet.cssText = replaceText(index, css)
  } else {
    var cssNode = document.createTextNode(css)
    var childNodes = styleElement.childNodes
    if (childNodes[index]) styleElement.removeChild(childNodes[index])
    if (childNodes.length) {
      styleElement.insertBefore(cssNode, childNodes[index])
    } else {
      styleElement.appendChild(cssNode)
    }
  }
}

function applyToTag (styleElement, obj) {
  var css = obj.css
  var media = obj.media
  var sourceMap = obj.sourceMap

  if (media) {
    styleElement.setAttribute('media', media)
  }
  if (options.ssrId) {
    styleElement.setAttribute(ssrIdKey, obj.id)
  }

  if (sourceMap) {
    // https://developer.chrome.com/devtools/docs/javascript-debugging
    // this makes source maps inside style tags work properly in Chrome
    css += '\n/*# sourceURL=' + sourceMap.sources[0] + ' */'
    // http://stackoverflow.com/a/26603875
    css += '\n/*# sourceMappingURL=data:application/json;base64,' + btoa(unescape(encodeURIComponent(JSON.stringify(sourceMap)))) + ' */'
  }

  if (styleElement.styleSheet) {
    styleElement.styleSheet.cssText = css
  } else {
    while (styleElement.firstChild) {
      styleElement.removeChild(styleElement.firstChild)
    }
    styleElement.appendChild(document.createTextNode(css))
  }
}


/***/ }),
/* 7 */
/***/ (function(module, exports) {

/**
 * Translates the list format produced by css-loader into something
 * easier to manipulate.
 */
module.exports = function listToStyles (parentId, list) {
  var styles = []
  var newStyles = {}
  for (var i = 0; i < list.length; i++) {
    var item = list[i]
    var id = item[0]
    var css = item[1]
    var media = item[2]
    var sourceMap = item[3]
    var part = {
      id: parentId + ':' + i,
      css: css,
      media: media,
      sourceMap: sourceMap
    }
    if (!newStyles[id]) {
      styles.push(newStyles[id] = { id: id, parts: [part] })
    } else {
      newStyles[id].parts.push(part)
    }
  }
  return styles
}


/***/ }),
/* 8 */
/***/ (function(module, exports) {

/* globals __VUE_SSR_CONTEXT__ */

// IMPORTANT: Do NOT use ES2015 features in this file.
// This module is a runtime utility for cleaner component module output and will
// be included in the final webpack user bundle.

module.exports = function normalizeComponent (
  rawScriptExports,
  compiledTemplate,
  functionalTemplate,
  injectStyles,
  scopeId,
  moduleIdentifier /* server only */
) {
  var esModule
  var scriptExports = rawScriptExports = rawScriptExports || {}

  // ES6 modules interop
  var type = typeof rawScriptExports.default
  if (type === 'object' || type === 'function') {
    esModule = rawScriptExports
    scriptExports = rawScriptExports.default
  }

  // Vue.extend constructor export interop
  var options = typeof scriptExports === 'function'
    ? scriptExports.options
    : scriptExports

  // render functions
  if (compiledTemplate) {
    options.render = compiledTemplate.render
    options.staticRenderFns = compiledTemplate.staticRenderFns
    options._compiled = true
  }

  // functional template
  if (functionalTemplate) {
    options.functional = true
  }

  // scopedId
  if (scopeId) {
    options._scopeId = scopeId
  }

  var hook
  if (moduleIdentifier) { // server build
    hook = function (context) {
      // 2.3 injection
      context =
        context || // cached call
        (this.$vnode && this.$vnode.ssrContext) || // stateful
        (this.parent && this.parent.$vnode && this.parent.$vnode.ssrContext) // functional
      // 2.2 with runInNewContext: true
      if (!context && typeof __VUE_SSR_CONTEXT__ !== 'undefined') {
        context = __VUE_SSR_CONTEXT__
      }
      // inject component styles
      if (injectStyles) {
        injectStyles.call(this, context)
      }
      // register component module identifier for async chunk inferrence
      if (context && context._registeredComponents) {
        context._registeredComponents.add(moduleIdentifier)
      }
    }
    // used by ssr in case component is cached and beforeCreate
    // never gets called
    options._ssrRegister = hook
  } else if (injectStyles) {
    hook = injectStyles
  }

  if (hook) {
    var functional = options.functional
    var existing = functional
      ? options.render
      : options.beforeCreate

    if (!functional) {
      // inject component registration as beforeCreate hook
      options.beforeCreate = existing
        ? [].concat(existing, hook)
        : [hook]
    } else {
      // for template-only hot-reload because in that case the render fn doesn't
      // go through the normalizer
      options._injectStyles = hook
      // register for functioal component in vue file
      options.render = function renderWithStyleInjection (h, context) {
        hook.call(context)
        return existing(h, context)
      }
    }
  }

  return {
    esModule: esModule,
    exports: scriptExports,
    options: options
  }
}


/***/ }),
/* 9 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
Object.defineProperty(__webpack_exports__, "__esModule", { value: true });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0_animated_number_vue__ = __webpack_require__(10);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0_animated_number_vue___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_0_animated_number_vue__);
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//



/* harmony default export */ __webpack_exports__["default"] = ({
    filters: {
        capitalize: function capitalize(value) {
            if (!value) return '';
            return value.charAt(0).toUpperCase() + value.slice(1);
        }
    },
    components: {
        AnimatedNumber: __WEBPACK_IMPORTED_MODULE_0_animated_number_vue___default.a
    },
    props: {
        card: {
            required: true
        },
        resourceName: {
            type: String,
            required: true
        }
    },
    data: function data() {
        return {
            resultsAnimationDuration: 700,
            counts: {
                communities: 0,
                households: 0,
                rental: 0,
                vacant: 0,
                foreclosure: 0
            }
        };
    },
    methods: {
        postCounts: function postCounts() {
            var _this = this;

            Nova.request().post('/nova-vendor/community-list-dashboard/count', {
                filtersAreApplied: this.filtersAreApplied,
                filters: this.filters
            }).then(function (response) {
                _this.counts = response.data;
            });
        },

        formatNumber: function formatNumber(value) {
            var si = [{ value: 1, symbol: "" }, { value: 1E3, symbol: "K" }, { value: 1E6, symbol: "M" }];
            var rx = /\.0+$|(\.[0-9]*[1-9])0+$/;
            var i = void 0;
            for (i = si.length - 1; i > 0; i--) {
                if (value >= si[i].value) {
                    break;
                }
            }
            return (value / si[i].value).toFixed(1).replace(rx, "$1") + si[i].symbol;
        }
    },
    watch: {
        filters: {
            handler: function handler(val) {
                this.postCounts();
            },

            deep: true
        }
    },
    computed: {
        filters: function filters() {
            return {
                rental: this.$store.getters[this.resourceName + '/getFilter']('App\\Nova\\Filters\\CommunityRentalSalesStatus').currentValue,
                vacant: this.$store.getters[this.resourceName + '/getFilter']('App\\Nova\\Filters\\CommunityVacantSalesStatus').currentValue,
                foreclosure: this.$store.getters[this.resourceName + '/getFilter']('App\\Nova\\Filters\\CommunityForeclosureSalesStatus').currentValue,
                size: this.$store.getters[this.resourceName + '/getFilter']('App\\Nova\\Filters\\CommunitySize').currentValue,
                rm: this.$store.getters[this.resourceName + '/getFilter']('App\\Nova\\Filters\\RelationshipManager').currentValue,
                state: this.$store.getters[this.resourceName + '/getFilter']('App\\Nova\\Filters\\CommunityState').currentValue,
                county: this.$store.getters[this.resourceName + '/getFilter']('App\\Nova\\Filters\\CommunityCounty').currentValue,
                bulkId: this.$store.getters[this.resourceName + '/getFilter']('Prochamps\\BulkId\\BulkId').currentValue
            };
        },
        filtersAreApplied: function filtersAreApplied() {
            return this.$store.getters[this.resourceName + '/filtersAreApplied'];
        }
    },
    mounted: function mounted() {
        this.postCounts();
    }
});

/***/ }),
/* 10 */
/***/ (function(module, exports, __webpack_require__) {

(function(t,e){ true?module.exports=e():"function"===typeof define&&define.amd?define([],e):"object"===typeof exports?exports["AnimatedNumber"]=e():t["AnimatedNumber"]=e()})("undefined"!==typeof self?self:this,function(){return function(t){var e={};function n(r){if(e[r])return e[r].exports;var o=e[r]={i:r,l:!1,exports:{}};return t[r].call(o.exports,o,o.exports,n),o.l=!0,o.exports}return n.m=t,n.c=e,n.d=function(t,e,r){n.o(t,e)||Object.defineProperty(t,e,{configurable:!1,enumerable:!0,get:r})},n.n=function(t){var e=t&&t.__esModule?function(){return t["default"]}:function(){return t};return n.d(e,"a",e),e},n.o=function(t,e){return Object.prototype.hasOwnProperty.call(t,e)},n.p="./",n(n.s=0)}({0:function(t,e,n){t.exports=n("vgs7")},A5qe:function(t,e,n){(function(n){var r,o,a,i={scope:{}};i.defineProperty="function"==typeof Object.defineProperties?Object.defineProperty:function(t,e,n){if(n.get||n.set)throw new TypeError("ES3 does not support getters and setters.");t!=Array.prototype&&t!=Object.prototype&&(t[e]=n.value)},i.getGlobal=function(t){return"undefined"!=typeof window&&window===t?t:"undefined"!=typeof n&&null!=n?n:t},i.global=i.getGlobal(this),i.SYMBOL_PREFIX="jscomp_symbol_",i.initSymbol=function(){i.initSymbol=function(){},i.global.Symbol||(i.global.Symbol=i.Symbol)},i.symbolCounter_=0,i.Symbol=function(t){return i.SYMBOL_PREFIX+(t||"")+i.symbolCounter_++},i.initSymbolIterator=function(){i.initSymbol();var t=i.global.Symbol.iterator;t||(t=i.global.Symbol.iterator=i.global.Symbol("iterator")),"function"!=typeof Array.prototype[t]&&i.defineProperty(Array.prototype,t,{configurable:!0,writable:!0,value:function(){return i.arrayIterator(this)}}),i.initSymbolIterator=function(){}},i.arrayIterator=function(t){var e=0;return i.iteratorPrototype(function(){return e<t.length?{done:!1,value:t[e++]}:{done:!0}})},i.iteratorPrototype=function(t){return i.initSymbolIterator(),t={next:t},t[i.global.Symbol.iterator]=function(){return this},t},i.array=i.array||{},i.iteratorFromArray=function(t,e){i.initSymbolIterator(),t instanceof String&&(t+="");var n=0,r={next:function(){if(n<t.length){var o=n++;return{value:e(o,t[o]),done:!1}}return r.next=function(){return{done:!0,value:void 0}},r.next()}};return r[Symbol.iterator]=function(){return r},r},i.polyfill=function(t,e,n,r){if(e){for(n=i.global,t=t.split("."),r=0;r<t.length-1;r++){var o=t[r];o in n||(n[o]={}),n=n[o]}t=t[t.length-1],r=n[t],e=e(r),e!=r&&null!=e&&i.defineProperty(n,t,{configurable:!0,writable:!0,value:e})}},i.polyfill("Array.prototype.keys",function(t){return t||function(){return i.iteratorFromArray(this,function(t){return t})}},"es6-impl","es3");var u=this;(function(n,i){o=[],r=i,a="function"===typeof r?r.apply(e,o):r,void 0===a||(t.exports=a)})(0,function(){function t(t){if(!L.col(t))try{return document.querySelectorAll(t)}catch(t){}}function e(t,e){for(var n=t.length,r=2<=arguments.length?arguments[1]:void 0,o=[],a=0;a<n;a++)if(a in t){var i=t[a];e.call(r,i,a,t)&&o.push(i)}return o}function n(t){return t.reduce(function(t,e){return t.concat(L.arr(e)?n(e):e)},[])}function r(e){return L.arr(e)?e:(L.str(e)&&(e=t(e)||e),e instanceof NodeList||e instanceof HTMLCollection?[].slice.call(e):[e])}function o(t,e){return t.some(function(t){return t===e})}function a(t){var e,n={};for(e in t)n[e]=t[e];return n}function i(t,e){var n,r=a(t);for(n in t)r[n]=e.hasOwnProperty(n)?e[n]:t[n];return r}function s(t,e){var n,r=a(t);for(n in e)r[n]=L.und(t[n])?e[n]:t[n];return r}function f(t){t=t.replace(/^#?([a-f\d])([a-f\d])([a-f\d])$/i,function(t,e,n,r){return e+e+n+n+r+r});var e=/^#?([a-f\d]{2})([a-f\d]{2})([a-f\d]{2})$/i.exec(t);t=parseInt(e[1],16);var n=parseInt(e[2],16);e=parseInt(e[3],16);return"rgba("+t+","+n+","+e+",1)"}function c(t){function e(t,e,n){return 0>n&&(n+=1),1<n&&--n,n<1/6?t+6*(e-t)*n:.5>n?e:n<2/3?t+(e-t)*(2/3-n)*6:t}var n=/hsl\((\d+),\s*([\d.]+)%,\s*([\d.]+)%\)/g.exec(t)||/hsla\((\d+),\s*([\d.]+)%,\s*([\d.]+)%,\s*([\d.]+)\)/g.exec(t);t=parseInt(n[1])/360;var r=parseInt(n[2])/100,o=parseInt(n[3])/100;n=n[4]||1;if(0==r)o=r=t=o;else{var a=.5>o?o*(1+r):o+r-o*r,i=2*o-a;o=e(i,a,t+1/3),r=e(i,a,t);t=e(i,a,t-1/3)}return"rgba("+255*o+","+255*r+","+255*t+","+n+")"}function l(t){if(t=/([\+\-]?[0-9#\.]+)(%|px|pt|em|rem|in|cm|mm|ex|ch|pc|vw|vh|vmin|vmax|deg|rad|turn)?$/.exec(t))return t[2]}function d(t){return-1<t.indexOf("translate")||"perspective"===t?"px":-1<t.indexOf("rotate")||-1<t.indexOf("skew")?"deg":void 0}function p(t,e){return L.fnc(t)?t(e.target,e.id,e.total):t}function m(t,e){if(e in t.style)return getComputedStyle(t).getPropertyValue(e.replace(/([a-z])([A-Z])/g,"$1-$2").toLowerCase())||"0"}function y(t,e){return L.dom(t)&&o($,e)?"transform":L.dom(t)&&(t.getAttribute(e)||L.svg(t)&&t[e])?"attribute":L.dom(t)&&"transform"!==e&&m(t,e)?"css":null!=t[e]?"object":void 0}function g(t,n){var r=d(n);r=-1<n.indexOf("scale")?1:0+r;if(t=t.style.transform,!t)return r;for(var o=[],a=[],i=[],u=/(\w+)\((.+?)\)/g;o=u.exec(t);)a.push(o[1]),i.push(o[2]);return t=e(i,function(t,e){return a[e]===n}),t.length?t[0]:r}function h(t,e){switch(y(t,e)){case"transform":return g(t,e);case"css":return m(t,e);case"attribute":return t.getAttribute(e)}return t[e]||0}function v(t,e){var n=/^(\*=|\+=|-=)/.exec(t);if(!n)return t;var r=l(t)||0;switch(e=parseFloat(e),t=parseFloat(t.replace(n[0],"")),n[0][0]){case"+":return e+t+r;case"-":return e-t+r;case"*":return e*t+r}}function b(t,e){return Math.sqrt(Math.pow(e.x-t.x,2)+Math.pow(e.y-t.y,2))}function x(t){t=t.points;for(var e,n=0,r=0;r<t.numberOfItems;r++){var o=t.getItem(r);0<r&&(n+=b(e,o)),e=o}return n}function w(t){if(t.getTotalLength)return t.getTotalLength();switch(t.tagName.toLowerCase()){case"circle":return 2*Math.PI*t.getAttribute("r");case"rect":return 2*t.getAttribute("width")+2*t.getAttribute("height");case"line":return b({x:t.getAttribute("x1"),y:t.getAttribute("y1")},{x:t.getAttribute("x2"),y:t.getAttribute("y2")});case"polyline":return x(t);case"polygon":var e=t.points;return x(t)+b(e.getItem(e.numberOfItems-1),e.getItem(0))}}function S(t,e){function n(n){return n=void 0===n?0:n,t.el.getPointAtLength(1<=e+n?e+n:0)}var r=n(),o=n(-1),a=n(1);switch(t.property){case"x":return r.x;case"y":return r.y;case"angle":return 180*Math.atan2(a.y-o.y,a.x-o.x)/Math.PI}}function _(t,e){var n,r=/-?\d*\.?\d+/g;if(n=L.pth(t)?t.totalLength:t,L.col(n))if(L.rgb(n)){var o=/rgb\((\d+,\s*[\d]+,\s*[\d]+)\)/g.exec(n);n=o?"rgba("+o[1]+",1)":n}else n=L.hex(n)?f(n):L.hsl(n)?c(n):void 0;else o=(o=l(n))?n.substr(0,n.length-o.length):n,n=e&&!/\s/g.test(n)?o+e:o;return n+="",{original:n,numbers:n.match(r)?n.match(r).map(Number):[0],strings:L.str(t)||e?n.split(r):[]}}function A(t){return t=t?n(L.arr(t)?t.map(r):r(t)):[],e(t,function(t,e,n){return n.indexOf(t)===e})}function O(t){var e=A(t);return e.map(function(t,n){return{target:t,id:n,total:e.length}})}function M(t,e){var n=a(e);if(L.arr(t)){var o=t.length;2!==o||L.obj(t[0])?L.fnc(e.duration)||(n.duration=e.duration/o):t={value:t}}return r(t).map(function(t,n){return n=n?0:e.delay,t=L.obj(t)&&!L.pth(t)?t:{value:t},L.und(t.delay)&&(t.delay=n),t}).map(function(t){return s(t,n)})}function I(t,e){var n,r={};for(n in t){var o=p(t[n],e);L.arr(o)&&(o=o.map(function(t){return p(t,e)}),1===o.length&&(o=o[0])),r[n]=o}return r.duration=parseFloat(r.duration),r.delay=parseFloat(r.delay),r}function P(t){return L.arr(t)?R.apply(this,t):X[t]}function j(t,e){var n;return t.tweens.map(function(r){r=I(r,e);var o=r.value,a=h(e.target,t.name),i=n?n.to.original:a,u=(i=L.arr(o)?o[0]:i,v(L.arr(o)?o[1]:o,i));a=l(u)||l(i)||l(a);return r.from=_(i,a),r.to=_(u,a),r.start=n?n.end:t.offset,r.end=r.start+r.delay+r.duration,r.easing=P(r.easing),r.elasticity=(1e3-Math.min(Math.max(r.elasticity,1),999))/1e3,r.isPath=L.pth(o),r.isColor=L.col(r.from.original),r.isColor&&(r.round=1),n=r})}function F(t,r){return e(n(t.map(function(t){return r.map(function(e){var n=y(t.target,e.name);if(n){var r=j(e,t);e={type:n,property:e.name,animatable:t,tweens:r,duration:r[r.length-1].end,delay:r[0].delay}}else e=void 0;return e})})),function(t){return!L.und(t)})}function C(t,e,n,r){var o="delay"===t;return e.length?(o?Math.min:Math.max).apply(Math,e.map(function(e){return e[t]})):o?r.delay:n.offset+r.delay+r.duration}function k(t){var e,n=i(T,t),r=i(V,t),o=O(t.targets),a=[],u=s(n,r);for(e in t)u.hasOwnProperty(e)||"targets"===e||a.push({name:e,offset:u.offset,tweens:M(t[e],r)});return t=F(o,a),s(n,{children:[],animatables:o,animations:t,duration:C("duration",t,n,r),delay:C("delay",t,n,r)})}function E(t){function n(){return window.Promise&&new Promise(function(t){return l=t})}function r(t){return p.reversed?p.duration-t:t}function o(t){for(var n=0,r={},o=p.animations,a=o.length;n<a;){var i=o[n],u=i.animatable,s=i.tweens,f=s.length-1,c=s[f];f&&(c=e(s,function(e){return t<e.end})[0]||c);s=Math.min(Math.max(t-c.start-c.delay,0),c.duration)/c.duration;for(var l=isNaN(s)?1:c.easing(s,c.elasticity),d=(s=c.to.strings,c.round),y=(f=[],void 0),g=(y=c.to.numbers.length,0);g<y;g++){var h=void 0,v=(h=c.to.numbers[g],c.from.numbers[g]);h=c.isPath?S(c.value,l*h):v+l*(h-v);d&&(c.isColor&&2<g||(h=Math.round(h*d)/d)),f.push(h)}if(c=s.length)for(y=s[0],l=0;l<c;l++)d=s[l+1],g=f[l],isNaN(g)||(y=d?y+(g+d):y+(g+" "));else y=f[0];q[i.type](u.target,i.property,y,r,u.id),i.currentValue=y,n++}if(n=Object.keys(r).length)for(o=0;o<n;o++)N||(N=m(document.body,"transform")?"transform":"-webkit-transform"),p.animatables[o].target.style[N]=r[o].join(" ");p.currentTime=t,p.progress=t/p.duration*100}function a(t){p[t]&&p[t](p)}function i(){p.remaining&&!0!==p.remaining&&p.remaining--}function u(t){var e=p.duration,u=p.offset,m=u+p.delay,y=p.currentTime,g=p.reversed,h=r(t);if(p.children.length){var v=p.children,b=v.length;if(h>=p.currentTime)for(var x=0;x<b;x++)v[x].seek(h);else for(;b--;)v[b].seek(h)}(h>=m||!e)&&(p.began||(p.began=!0,a("begin")),a("run")),h>u&&h<e?o(h):(h<=u&&0!==y&&(o(0),g&&i()),(h>=e&&y!==e||!e)&&(o(e),g||i())),a("update"),t>=e&&(p.remaining?(f=s,"alternate"===p.direction&&(p.reversed=!p.reversed)):(p.pause(),p.completed||(p.completed=!0,a("complete"),"Promise"in window&&(l(),d=n()))),c=0)}t=void 0===t?{}:t;var s,f,c=0,l=null,d=n(),p=k(t);return p.reset=function(){var t=p.direction,e=p.loop;for(p.currentTime=0,p.progress=0,p.paused=!0,p.began=!1,p.completed=!1,p.reversed="reverse"===t,p.remaining="alternate"===t&&1===e?2:e,o(0),t=p.children.length;t--;)p.children[t].reset()},p.tick=function(t){s=t,f||(f=s),u((c+s-f)*E.speed)},p.seek=function(t){u(r(t))},p.pause=function(){var t=Y.indexOf(p);-1<t&&Y.splice(t,1),p.paused=!0},p.play=function(){p.paused&&(p.paused=!1,f=0,c=r(p.currentTime),Y.push(p),Z||B())},p.reverse=function(){p.reversed=!p.reversed,f=0,c=r(p.currentTime)},p.restart=function(){p.pause(),p.reset(),p.play()},p.finished=d,p.reset(),p.autoplay&&p.play(),p}var N,T={update:void 0,begin:void 0,run:void 0,complete:void 0,loop:1,direction:"normal",autoplay:!0,offset:0},V={duration:1e3,delay:0,easing:"easeOutElastic",elasticity:500,round:0},$="translateX translateY translateZ rotate rotateX rotateY rotateZ scale scaleX scaleY scaleZ skewX skewY perspective".split(" "),L={arr:function(t){return Array.isArray(t)},obj:function(t){return-1<Object.prototype.toString.call(t).indexOf("Object")},pth:function(t){return L.obj(t)&&t.hasOwnProperty("totalLength")},svg:function(t){return t instanceof SVGElement},dom:function(t){return t.nodeType||L.svg(t)},str:function(t){return"string"===typeof t},fnc:function(t){return"function"===typeof t},und:function(t){return"undefined"===typeof t},hex:function(t){return/(^#[0-9A-F]{6}$)|(^#[0-9A-F]{3}$)/i.test(t)},rgb:function(t){return/^rgb/.test(t)},hsl:function(t){return/^hsl/.test(t)},col:function(t){return L.hex(t)||L.rgb(t)||L.hsl(t)}},R=function(){function t(t,e,n){return(((1-3*n+3*e)*t+(3*n-6*e))*t+3*e)*t}return function(e,n,r,o){if(0<=e&&1>=e&&0<=r&&1>=r){var a=new Float32Array(11);if(e!==n||r!==o)for(var i=0;11>i;++i)a[i]=t(.1*i,e,r);return function(i){if(e===n&&r===o)return i;if(0===i)return 0;if(1===i)return 1;for(var u=0,s=1;10!==s&&a[s]<=i;++s)u+=.1;--s;s=u+(i-a[s])/(a[s+1]-a[s])*.1;var f=3*(1-3*r+3*e)*s*s+2*(3*r-6*e)*s+3*e;if(.001<=f){for(u=0;4>u;++u){if(f=3*(1-3*r+3*e)*s*s+2*(3*r-6*e)*s+3*e,0===f)break;var c=t(s,e,r)-i;s=s-c/f}i=s}else if(0===f)i=s;else{s=u,u=u+.1;var l=0;do{c=s+(u-s)/2,f=t(c,e,r)-i,0<f?u=c:s=c}while(1e-7<Math.abs(f)&&10>++l);i=c}return t(i,n,o)}}}}(),X=function(){function t(t,e){return 0===t||1===t?t:-Math.pow(2,10*(t-1))*Math.sin(2*(t-1-e/(2*Math.PI)*Math.asin(1))*Math.PI/e)}var e,n="Quad Cubic Quart Quint Sine Expo Circ Back Elastic".split(" "),r={In:[[.55,.085,.68,.53],[.55,.055,.675,.19],[.895,.03,.685,.22],[.755,.05,.855,.06],[.47,0,.745,.715],[.95,.05,.795,.035],[.6,.04,.98,.335],[.6,-.28,.735,.045],t],Out:[[.25,.46,.45,.94],[.215,.61,.355,1],[.165,.84,.44,1],[.23,1,.32,1],[.39,.575,.565,1],[.19,1,.22,1],[.075,.82,.165,1],[.175,.885,.32,1.275],function(e,n){return 1-t(1-e,n)}],InOut:[[.455,.03,.515,.955],[.645,.045,.355,1],[.77,0,.175,1],[.86,0,.07,1],[.445,.05,.55,.95],[1,0,0,1],[.785,.135,.15,.86],[.68,-.55,.265,1.55],function(e,n){return.5>e?t(2*e,n)/2:1-t(-2*e+2,n)/2}]},o={linear:R(.25,.25,.75,.75)},a={};for(e in r)a.type=e,r[a.type].forEach(function(t){return function(e,r){o["ease"+t.type+n[r]]=L.fnc(e)?e:R.apply(u,e)}}(a)),a={type:a.type};return o}(),q={css:function(t,e,n){return t.style[e]=n},attribute:function(t,e,n){return t.setAttribute(e,n)},object:function(t,e,n){return t[e]=n},transform:function(t,e,n,r,o){r[o]||(r[o]=[]),r[o].push(e+"("+n+")")}},Y=[],Z=0,B=function(){function t(){Z=requestAnimationFrame(e)}function e(e){var n=Y.length;if(n){for(var r=0;r<n;)Y[r]&&Y[r].tick(e),r++;t()}else cancelAnimationFrame(Z),Z=0}return t}();return E.version="2.2.0",E.speed=1,E.running=Y,E.remove=function(t){t=A(t);for(var e=Y.length;e--;)for(var n=Y[e],r=n.animations,a=r.length;a--;)o(t,r[a].animatable.target)&&(r.splice(a,1),r.length||n.pause())},E.getValue=h,E.path=function(e,n){var r=L.str(e)?t(e)[0]:e,o=n||100;return function(t){return{el:r,property:t,totalLength:w(r)*(o/100)}}},E.setDashoffset=function(t){var e=w(t);return t.setAttribute("stroke-dasharray",e),e},E.bezier=R,E.easings=X,E.timeline=function(t){var e=E(t);return e.pause(),e.duration=0,e.add=function(n){return e.children.forEach(function(t){t.began=!0,t.completed=!0}),r(n).forEach(function(n){var r=s(n,i(V,t||{}));r.targets=r.targets||t.targets,n=e.duration;var o=r.offset;r.autoplay=!1,r.direction=e.direction,r.offset=L.und(o)?n:v(o,n),e.began=!0,e.completed=!0,e.seek(r.offset),r=E(r),r.began=!0,r.completed=!0,r.duration>n&&(e.duration=r.duration),e.children.push(r)}),e.seek(0),e.reset(),e.autoplay&&e.restart(),e},e},E.random=function(t,e){return Math.floor(Math.random()*(e-t+1))+t},E})}).call(e,n("DuR2"))},DuR2:function(t,e){var n;n=function(){return this}();try{n=n||Function("return this")()||(0,eval)("this")}catch(t){"object"===typeof window&&(n=window)}t.exports=n},vgs7:function(t,e,n){"use strict";Object.defineProperty(e,"__esModule",{value:!0});var r=n("A5qe"),o=n.n(r),a={props:{value:{type:[Number,String],default:"0",required:!0},formatValue:{type:Function,default:function(t){return t}},easing:{type:String,default:"linear"},duration:{type:Number,default:1e3},update:Function,begin:Function,complete:Function,run:Function,delay:{type:Number,default:0},round:{default:null}},data:function(){return{animatedValue:0}},mounted:function(){this.animateValue(this.value)},watch:{value:function(t){this.animateValue(t)}},methods:{animateValue:function(t){var e=this.begin,n=this.easing,r=this.duration,a=this.complete,i=this.update,u=this.run,s=this.delay,f=this.round;o()({targets:this,animatedValue:t,duration:r,easing:n,update:i,begin:e,complete:a,run:u,delay:s,round:f})}}},i=function(){var t=this,e=t.$createElement,n=t._self._c||e;return n("span",[t._v(t._s(t.formatValue(Number(t.animatedValue))))])},u=[];function s(t,e,n,r,o,a,i,u){t=t||{};var s=typeof t.default;"object"!==s&&"function"!==s||(t=t.default);var f,c="function"===typeof t?t.options:t;if(e&&(c.render=e,c.staticRenderFns=n,c._compiled=!0),r&&(c.functional=!0),a&&(c._scopeId=a),i?(f=function(t){t=t||this.$vnode&&this.$vnode.ssrContext||this.parent&&this.parent.$vnode&&this.parent.$vnode.ssrContext,t||"undefined"===typeof __VUE_SSR_CONTEXT__||(t=__VUE_SSR_CONTEXT__),o&&o.call(this,t),t&&t._registeredComponents&&t._registeredComponents.add(i)},c._ssrRegister=f):o&&(f=u?function(){o.call(this,this.$root.$options.shadowRoot)}:o),f)if(c.functional){c._injectStyles=f;var l=c.render;c.render=function(t,e){return f.call(e),l(t,e)}}else{var d=c.beforeCreate;c.beforeCreate=d?[].concat(d,f):[f]}return{exports:t,options:c}}var f=!1,c=null,l=null,d=null,p=s(a,i,u,f,c,l,d),m=p.exports;e["default"]=m}})["default"]});
//# sourceMappingURL=AnimatedNumber.umd.min.js.map

/***/ }),
/* 11 */
/***/ (function(module, exports, __webpack_require__) {

var render = function() {
  var _vm = this
  var _h = _vm.$createElement
  var _c = _vm._self._c || _h
  return _c(
    "card",
    { staticClass: "flex flex-col items-center justify-center" },
    [
      _c(
        "div",
        { staticClass: "flex item-center justify-center flex-wrap w-full" },
        _vm._l(_vm.counts, function(count, index) {
          return _c(
            "div",
            {
              staticClass:
                "text-grey-darker text-center px-4 py-2 m-2 content-center resultsBox hoverShadow "
            },
            [
              _c("h2", { staticClass: "mt-8" }, [
                _vm._v(_vm._s(_vm._f("capitalize")(index)))
              ]),
              _vm._v(" "),
              _c("br"),
              _c("br"),
              _vm._v(" "),
              _c(
                "h1",
                [
                  _c("animated-number", {
                    attrs: {
                      value: count,
                      formatValue: _vm.formatNumber,
                      duration: _vm.resultsAnimationDuration,
                      round: true
                    }
                  })
                ],
                1
              )
            ]
          )
        }),
        0
      )
    ]
  )
}
var staticRenderFns = []
render._withStripped = true
module.exports = { render: render, staticRenderFns: staticRenderFns }
if (false) {
  module.hot.accept()
  if (module.hot.data) {
    require("vue-hot-reload-api")      .rerender("data-v-b9bc2c0a", module.exports)
  }
}

/***/ }),
/* 12 */
/***/ (function(module, exports) {

// removed by extract-text-webpack-plugin

/***/ })
/******/ ]);