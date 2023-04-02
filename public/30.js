(window["webpackJsonp"] = window["webpackJsonp"] || []).push([[30],{

/***/ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/Admin/Super/ParaPhraseList.vue?vue&type=script&lang=js&":
/*!**************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib??ref--4-0!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/Admin/Super/ParaPhraseList.vue?vue&type=script&lang=js& ***!
  \**************************************************************************************************************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @babel/runtime/regenerator */ "./node_modules/@babel/runtime/regenerator/index.js");
/* harmony import */ var _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var vuex__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! vuex */ "./node_modules/vuex/dist/vuex.esm.js");
/* harmony import */ var formvuelar__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! formvuelar */ "./node_modules/formvuelar/dist/formvuelar.common.js");
/* harmony import */ var formvuelar__WEBPACK_IMPORTED_MODULE_2___default = /*#__PURE__*/__webpack_require__.n(formvuelar__WEBPACK_IMPORTED_MODULE_2__);
/* harmony import */ var _ListComponent__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! ./ListComponent */ "./resources/js/Admin/Super/ListComponent.vue");
/* harmony import */ var _Detail_component_RecipeSelect__WEBPACK_IMPORTED_MODULE_4__ = __webpack_require__(/*! ./Detail/component/RecipeSelect */ "./resources/js/Admin/Super/Detail/component/RecipeSelect.vue");


function ownKeys(object, enumerableOnly) { var keys = Object.keys(object); if (Object.getOwnPropertySymbols) { var symbols = Object.getOwnPropertySymbols(object); if (enumerableOnly) symbols = symbols.filter(function (sym) { return Object.getOwnPropertyDescriptor(object, sym).enumerable; }); keys.push.apply(keys, symbols); } return keys; }

function _objectSpread(target) { for (var i = 1; i < arguments.length; i++) { var source = arguments[i] != null ? arguments[i] : {}; if (i % 2) { ownKeys(source, true).forEach(function (key) { _defineProperty(target, key, source[key]); }); } else if (Object.getOwnPropertyDescriptors) { Object.defineProperties(target, Object.getOwnPropertyDescriptors(source)); } else { ownKeys(source).forEach(function (key) { Object.defineProperty(target, key, Object.getOwnPropertyDescriptor(source, key)); }); } } return target; }

function _defineProperty(obj, key, value) { if (key in obj) { Object.defineProperty(obj, key, { value: value, enumerable: true, configurable: true, writable: true }); } else { obj[key] = value; } return obj; }

function asyncGeneratorStep(gen, resolve, reject, _next, _throw, key, arg) { try { var info = gen[key](arg); var value = info.value; } catch (error) { reject(error); return; } if (info.done) { resolve(value); } else { Promise.resolve(value).then(_next, _throw); } }

function _asyncToGenerator(fn) { return function () { var self = this, args = arguments; return new Promise(function (resolve, reject) { var gen = fn.apply(self, args); function _next(value) { asyncGeneratorStep(gen, resolve, reject, _next, _throw, "next", value); } function _throw(err) { asyncGeneratorStep(gen, resolve, reject, _next, _throw, "throw", err); } _next(undefined); }); }; }

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


 //import CategorySelect from "./Detail/component/CategorySelect"


/* harmony default export */ __webpack_exports__["default"] = ({
  data: function data() {
    return {
      paraphrases: null,
      name: null,
      note: null,
      command: null,
      selectedCategory: null,
      selectedMiddle: null,
      commands: [{
        label: "(未選択)",
        value: ""
      }, {
        label: "強制ホット",
        value: "hot"
      }]
    };
  },
  components: {
    ListComponent: _ListComponent__WEBPACK_IMPORTED_MODULE_3__["default"],
    CategorySelect: _Detail_component_RecipeSelect__WEBPACK_IMPORTED_MODULE_4__["default"],
    FvlForm: formvuelar__WEBPACK_IMPORTED_MODULE_2__["FvlForm"],
    FvlInput: formvuelar__WEBPACK_IMPORTED_MODULE_2__["FvlInput"]
  },
  created: function () {
    var _created = _asyncToGenerator(
    /*#__PURE__*/
    _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default.a.mark(function _callee() {
      var _ref, list;

      return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default.a.wrap(function _callee$(_context) {
        while (1) {
          switch (_context.prev = _context.next) {
            case 0:
              //カテゴリリストを取得
              this.$store.dispatch('form/getAndSetCategories'); //メインカテゴリ&ミドルカテゴリはvuexから拝借

              _context.next = 3;
              return axios.get("http://127.0.0.1:8000" + '/api/getParaphrase');

            case 3:
              _ref = _context.sent;
              list = _ref.data.result.Paraphrases;
              this.paraphrases = list;

            case 6:
            case "end":
              return _context.stop();
          }
        }
      }, _callee, this);
    }));

    function created() {
      return _created.apply(this, arguments);
    }

    return created;
  }(),
  computed: _objectSpread({}, Object(vuex__WEBPACK_IMPORTED_MODULE_1__["mapState"])("form", {
    categories: function categories(state) {
      return state.categories;
    }
  })),
  methods: {
    setForm: function () {
      var _setForm = _asyncToGenerator(
      /*#__PURE__*/
      _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default.a.mark(function _callee2(_ref2) {
        var name, converted, middle, note, command;
        return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default.a.wrap(function _callee2$(_context2) {
          while (1) {
            switch (_context2.prev = _context2.next) {
              case 0:
                name = _ref2.name, converted = _ref2.converted, middle = _ref2.middle, note = _ref2.note, command = _ref2.command;
                //子コンポーネントからパラメータを受け入れるので、更新する
                this.name = name;
                this.note = note;
                this.command = command; //convertedは文字列になっちゃってるので、探して取得

                _context2.next = 6;
                return axios.post("http://127.0.0.1:8000" + '/api/Paraphrase/serachFromWords', {
                  converted: converted,
                  middle: middle
                });

              case 6:
              case "end":
                return _context2.stop();
            }
          }
        }, _callee2, this);
      }));

      function setForm(_x) {
        return _setForm.apply(this, arguments);
      }

      return setForm;
    }(),
    forceSelect: function forceSelect(categoryStr) {//パラフレーズ用

      var categoryMiddle = arguments.length > 1 && arguments[1] !== undefined ? arguments[1] : "";
    }
  }
});

/***/ }),

/***/ "./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/Admin/Super/ParaPhraseList.vue?vue&type=template&id=9b7a52ae&":
/*!******************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/Admin/Super/ParaPhraseList.vue?vue&type=template&id=9b7a52ae& ***!
  \******************************************************************************************************************************************************************************************************************/
/*! exports provided: render, staticRenderFns */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "render", function() { return render; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "staticRenderFns", function() { return staticRenderFns; });
var render = function() {
  var _vm = this
  var _h = _vm.$createElement
  var _c = _vm._self._c || _h
  return _c("div", [
    _c(
      "div",
      { staticStyle: { "max-width": "800px", margin: "auto" } },
      [
        _vm.paraphrases
          ? _c(
              "fvl-form",
              {
                attrs: { url: "" },
                on: {
                  submit: function($event) {
                    $event.preventDefault()
                  }
                }
              },
              [
                _c("div", { staticClass: "flexdiv" }, [
                  _c(
                    "div",
                    [
                      _c("fvl-input", {
                        attrs: {
                          value: _vm.name,
                          label: "変換前",
                          name: "name"
                        },
                        on: {
                          "update:value": function($event) {
                            _vm.name = $event
                          }
                        }
                      })
                    ],
                    1
                  ),
                  _vm._v(" "),
                  _c(
                    "div",
                    { staticStyle: { width: "100px" } },
                    [
                      _c("v-select", {
                        attrs: {
                          items: _vm.commands,
                          label: "command",
                          "item-text": "label",
                          "item-value": "value",
                          dense: ""
                        },
                        model: {
                          value: _vm.command,
                          callback: function($$v) {
                            _vm.command = $$v
                          },
                          expression: "command"
                        }
                      })
                    ],
                    1
                  )
                ]),
                _vm._v(" "),
                _c("fvl-input", {
                  attrs: { value: _vm.note, label: "note", name: "note" },
                  on: {
                    "update:value": function($event) {
                      _vm.note = $event
                    }
                  }
                })
              ],
              1
            )
          : _vm._e(),
        _vm._v(" "),
        _c("CategorySelect", {
          ref: "recipe",
          attrs: {
            "edit-mode": "ParaPhrase",
            "initial-category": _vm.r.category,
            "initial-middle": _vm.r.middle,
            "initial-brand": _vm.r.brand
          }
        })
      ],
      1
    ),
    _vm._v(" "),
    _c(
      "div",
      [
        _c("list-component", {
          attrs: {
            items: this.paraphrases,
            link_name: "Nothing",
            func: _vm.setForm
          },
          on: {
            setForm: function($event) {
              return _vm.setForm($event)
            }
          }
        })
      ],
      1
    )
  ])
}
var staticRenderFns = []
render._withStripped = true



/***/ }),

/***/ "./resources/js/Admin/Super/ParaPhraseList.vue":
/*!*****************************************************!*\
  !*** ./resources/js/Admin/Super/ParaPhraseList.vue ***!
  \*****************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _ParaPhraseList_vue_vue_type_template_id_9b7a52ae___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./ParaPhraseList.vue?vue&type=template&id=9b7a52ae& */ "./resources/js/Admin/Super/ParaPhraseList.vue?vue&type=template&id=9b7a52ae&");
/* harmony import */ var _ParaPhraseList_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./ParaPhraseList.vue?vue&type=script&lang=js& */ "./resources/js/Admin/Super/ParaPhraseList.vue?vue&type=script&lang=js&");
/* empty/unused harmony star reexport *//* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");





/* normalize component */

var component = Object(_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__["default"])(
  _ParaPhraseList_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__["default"],
  _ParaPhraseList_vue_vue_type_template_id_9b7a52ae___WEBPACK_IMPORTED_MODULE_0__["render"],
  _ParaPhraseList_vue_vue_type_template_id_9b7a52ae___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"],
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/Admin/Super/ParaPhraseList.vue"
/* harmony default export */ __webpack_exports__["default"] = (component.exports);

/***/ }),

/***/ "./resources/js/Admin/Super/ParaPhraseList.vue?vue&type=script&lang=js&":
/*!******************************************************************************!*\
  !*** ./resources/js/Admin/Super/ParaPhraseList.vue?vue&type=script&lang=js& ***!
  \******************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_ParaPhraseList_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/babel-loader/lib??ref--4-0!../../../../node_modules/vue-loader/lib??vue-loader-options!./ParaPhraseList.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/Admin/Super/ParaPhraseList.vue?vue&type=script&lang=js&");
/* empty/unused harmony star reexport */ /* harmony default export */ __webpack_exports__["default"] = (_node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_ParaPhraseList_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__["default"]); 

/***/ }),

/***/ "./resources/js/Admin/Super/ParaPhraseList.vue?vue&type=template&id=9b7a52ae&":
/*!************************************************************************************!*\
  !*** ./resources/js/Admin/Super/ParaPhraseList.vue?vue&type=template&id=9b7a52ae& ***!
  \************************************************************************************/
/*! exports provided: render, staticRenderFns */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_ParaPhraseList_vue_vue_type_template_id_9b7a52ae___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../../../node_modules/vue-loader/lib??vue-loader-options!./ParaPhraseList.vue?vue&type=template&id=9b7a52ae& */ "./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/Admin/Super/ParaPhraseList.vue?vue&type=template&id=9b7a52ae&");
/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "render", function() { return _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_ParaPhraseList_vue_vue_type_template_id_9b7a52ae___WEBPACK_IMPORTED_MODULE_0__["render"]; });

/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "staticRenderFns", function() { return _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_ParaPhraseList_vue_vue_type_template_id_9b7a52ae___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"]; });



/***/ })

}]);