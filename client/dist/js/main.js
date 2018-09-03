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
/******/ ({

/***/ "./client/src/js/GridFieldImporter.js":
/***/ (function(module, exports, __webpack_require__) {

/* WEBPACK VAR INJECTION */(function(jQuery) {__webpack_require__("./client/src/js/uploadreducer.js");

(function ($) {
	$("div.csv-importer").entwine({
		onmatch: function onmatch() {
			this.hide();
		}
	});

	$.entwine('ss', function ($) {
		$('.ss-gridfield .btn.toggle-csv-fields').entwine({
			onclick: function onclick() {
				$('div.csv-importer').entwine('.', function ($) {
					this.toggle();
				});
			}
		});
	});
})(jQuery);
/* WEBPACK VAR INJECTION */}.call(exports, __webpack_require__("jquery")))

/***/ }),

/***/ "./client/src/js/uploadreducer.js":
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
Object.defineProperty(__webpack_exports__, "__esModule", { value: true });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0_lib_Injector__ = __webpack_require__("lib/Injector");
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0_lib_Injector___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_0_lib_Injector__);


var importExportUploadFieldReducer = function importExportUploadFieldReducer(originalReducer) {
    return function (globalState) {
        return function (state, _ref) {
            var type = _ref.type,
                payload = _ref.payload;

            switch (type) {
                case 'UPLOADFIELD_UPLOAD_SUCCESS':
                    {

                        var redirectURL = payload.json.import_url;
                        console.log(globalState);
                        if (redirectURL) {
                            window.location.href = redirectURL;
                        }
                        return originalReducer(state, { type: type, payload: payload });
                    }

                default:
                    {
                        return originalReducer(state, { type: type, payload: payload });
                    }
            }
        };
    };
};

__WEBPACK_IMPORTED_MODULE_0_lib_Injector___default.a.transform('importExportUploaderCustom', function (updater) {
    updater.reducer('assetAdmin', importExportUploadFieldReducer);
});

/***/ }),

/***/ 0:
/***/ (function(module, exports, __webpack_require__) {

module.exports = __webpack_require__("./client/src/js/GridFieldImporter.js");


/***/ }),

/***/ "jquery":
/***/ (function(module, exports) {

module.exports = jQuery;

/***/ }),

/***/ "lib/Injector":
/***/ (function(module, exports) {

module.exports = Injector;

/***/ })

/******/ });
//# sourceMappingURL=main.js.map