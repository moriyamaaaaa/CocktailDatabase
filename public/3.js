(window["webpackJsonp"] = window["webpackJsonp"] || []).push([[3],{

/***/ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/Admin/Super/Detail/component/NamesAndDescription.vue?vue&type=script&lang=js&":
/*!************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib??ref--4-0!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/Admin/Super/Detail/component/NamesAndDescription.vue?vue&type=script&lang=js& ***!
  \************************************************************************************************************************************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @babel/runtime/regenerator */ "./node_modules/@babel/runtime/regenerator/index.js");
/* harmony import */ var _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var _Modules_helper__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ../../../../Modules/helper */ "./resources/js/Modules/helper.js");
/* harmony import */ var vuex__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! vuex */ "./node_modules/vuex/dist/vuex.esm.js");


function asyncGeneratorStep(gen, resolve, reject, _next, _throw, key, arg) { try { var info = gen[key](arg); var value = info.value; } catch (error) { reject(error); return; } if (info.done) { resolve(value); } else { Promise.resolve(value).then(_next, _throw); } }

function _asyncToGenerator(fn) { return function () { var self = this, args = arguments; return new Promise(function (resolve, reject) { var gen = fn.apply(self, args); function _next(value) { asyncGeneratorStep(gen, resolve, reject, _next, _throw, "next", value); } function _throw(err) { asyncGeneratorStep(gen, resolve, reject, _next, _throw, "throw", err); } _next(undefined); }); }; }

function _toConsumableArray(arr) { return _arrayWithoutHoles(arr) || _iterableToArray(arr) || _unsupportedIterableToArray(arr) || _nonIterableSpread(); }

function _nonIterableSpread() { throw new TypeError("Invalid attempt to spread non-iterable instance.\nIn order to be iterable, non-array objects must have a [Symbol.iterator]() method."); }

function _unsupportedIterableToArray(o, minLen) { if (!o) return; if (typeof o === "string") return _arrayLikeToArray(o, minLen); var n = Object.prototype.toString.call(o).slice(8, -1); if (n === "Object" && o.constructor) n = o.constructor.name; if (n === "Map" || n === "Set") return Array.from(o); if (n === "Arguments" || /^(?:Ui|I)nt(?:8|16|32)(?:Clamped)?Array$/.test(n)) return _arrayLikeToArray(o, minLen); }

function _iterableToArray(iter) { if (typeof Symbol !== "undefined" && Symbol.iterator in Object(iter)) return Array.from(iter); }

function _arrayWithoutHoles(arr) { if (Array.isArray(arr)) return _arrayLikeToArray(arr); }

function _arrayLikeToArray(arr, len) { if (len == null || len > arr.length) len = arr.length; for (var i = 0, arr2 = new Array(len); i < len; i++) { arr2[i] = arr[i]; } return arr2; }

function ownKeys(object, enumerableOnly) { var keys = Object.keys(object); if (Object.getOwnPropertySymbols) { var symbols = Object.getOwnPropertySymbols(object); if (enumerableOnly) symbols = symbols.filter(function (sym) { return Object.getOwnPropertyDescriptor(object, sym).enumerable; }); keys.push.apply(keys, symbols); } return keys; }

function _objectSpread(target) { for (var i = 1; i < arguments.length; i++) { var source = arguments[i] != null ? arguments[i] : {}; if (i % 2) { ownKeys(Object(source), true).forEach(function (key) { _defineProperty(target, key, source[key]); }); } else if (Object.getOwnPropertyDescriptors) { Object.defineProperties(target, Object.getOwnPropertyDescriptors(source)); } else { ownKeys(Object(source)).forEach(function (key) { Object.defineProperty(target, key, Object.getOwnPropertyDescriptor(source, key)); }); } } return target; }

function _defineProperty(obj, key, value) { if (key in obj) { Object.defineProperty(obj, key, { value: value, enumerable: true, configurable: true, writable: true }); } else { obj[key] = value; } return obj; }

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
//
//
//
//



var Validator = __webpack_require__(/*! validatorjs */ "./node_modules/validatorjs/src/validator.js");

Validator.useLang('ja');
/* harmony default export */ __webpack_exports__["default"] = ({
  props: {
    editMode: String,
    //detailEditObj:Object,
    parent_id: Number,
    name: String,
    name_eng: String,
    strength: null,
    //""じゃなくて0を送れ！ってWarnがウザいから消した
    description: String,
    note: String,
    youtube: String,
    youtube_time_hour: Number,
    youtube_time_minute: Number,
    youtube_time_second: Number,
    link_txt: String,
    link_url: String,
    is_major: Boolean,
    is_like: Boolean,
    is_powder: {
      type: Boolean,
      "default": false
    },
    ice: {
      type: Number,
      "default": null
    },
    method: {
      type: Number,
      "default": null
    },
    glass: {
      type: Number,
      "default": null
    },
    rate: {
      type: Number,
      "default": null
    },
    sweet_degree: {
      type: Number,
      "default": null
    },
    input_image: null,
    uploadImageUrl: String
  },
  data: function data() {
    return {
      valid: false,
      is_hasDuplicate_name: false,
      is_hasDuplicate_name_eng: false
    };
  },
  computed: _objectSpread(_objectSpread({}, Object(vuex__WEBPACK_IMPORTED_MODULE_2__["mapState"])("cocktailEdit", {
    glasses: function glasses(state) {
      return state.glasses;
    },
    ices: function ices(state) {
      return state.ices;
    },
    methods: function methods(state) {
      return state.methods;
    }
  })), {}, {
    wordurl: function wordurl() {
      return "https://www.google.co.jp/search?q=" + this.name + " カクテル言葉";
    },
    meanurl: function meanurl() {
      return "https://www.google.co.jp/search?q=" + this.name_eng + " %E6%84%8F%E5%91%B3";
    },
    glassLabel: function glassLabel() {
      if (!this.glasses) {
        return [];
      }

      return _Modules_helper__WEBPACK_IMPORTED_MODULE_1__["default"].append_null_select(this.glasses.map(function (v) {
        return {
          label: v.name + "(" + v.name_eng + ")",
          value: v.id
        };
      }));
    },
    iceLabel: function iceLabel() {
      if (!this.ices) {
        return [];
      }

      return _Modules_helper__WEBPACK_IMPORTED_MODULE_1__["default"].append_null_select(this.ices.map(function (v) {
        return {
          label: v.name,
          value: v.id
        };
      }));
    },
    methodLabel: function methodLabel() {
      if (!this.ices) {
        return [];
      }

      return this.methods.map(function (v) {
        return {
          label: v.name + "(" + v.name_eng + ")",
          value: v.id
        };
      });
    },
    iceValue: {
      get: function get() {
        return this.ice;
      },
      set: function set(value) {
        this.$emit('update:ice', value);
      }
    },
    glassValue: {
      get: function get() {
        return this.glass;
      },
      set: function set(value) {
        this.$emit('update:glass', value);
      }
    },
    methodValue: {
      get: function get() {
        return this.method;
      },
      set: function set(value) {
        this.$emit('update:method', value);
      }
    },
    rateValue: {
      get: function get() {
        return this.rate;
      },
      set: function set(value) {
        this.$emit('update:rate', value);
      }
    },
    sweetDegreeValue: {
      get: function get() {
        return this.sweet_degree;
      },
      set: function set(value) {
        this.$emit('update:sweet_degree', value);
      }
    },
    rateLabel: function rateLabel() {
      return _Modules_helper__WEBPACK_IMPORTED_MODULE_1__["default"].append_null_select([5, 4, 3, 2, 1].map(function (v) {
        return {
          label: v,
          value: v
        };
      }));
    },
    sweetdegreeLabel: function sweetdegreeLabel() {
      if (!this.ices) {
        return [];
      }

      return _Modules_helper__WEBPACK_IMPORTED_MODULE_1__["default"].append_null_select(_toConsumableArray(Array(21).keys()).map(function (i) {
        return i - 10;
      }).map(function (v) {
        return {
          label: v,
          value: v
        };
      }));
    },
    //バリデーション定義
    validateObj: function validateObj() {
      var data = {
        name: this.name,
        name_eng: this.name_eng,
        strength: this.strength,
        description: this.description,
        method: this.method
      };
      var rules = {
        name: 'required',
        name_eng: 'required',
        //変な文字も通したいので、alphabetは使わない
        strength: this.editMode == "Brand" ? 'required|numeric' : "numeric",
        description: this.editMode != "Cocktail" ? 'required' : "string",
        method: this.editMode == "Cocktail" ? 'required' : ""
      };
      var v = new Validator(data, rules);
      v.setAttributeNames({
        name: this.editMode + '_name',
        name_eng: this.editMode + '_name_eng',
        strength: this.editMode + '_strength',
        description: this.editMode + '_description'
      });
      v.fails(); //ここでバリデーションを実行しオブジェクトの状態を更新しているみたい

      return v;
    }
  }),
  methods: {
    big_to_hankaku: function big_to_hankaku(str) {
      return _Modules_helper__WEBPACK_IMPORTED_MODULE_1__["default"].Big_to_hankaku(str);
    },
    onlyNumberAndDot: function onlyNumberAndDot(str) {
      var newValue = _Modules_helper__WEBPACK_IMPORTED_MODULE_1__["default"].onlyNumberAndDot(str);
      return newValue;
    },
    onlyNumber2digit: function onlyNumber2digit(str) {
      //2桁までしか許容しない＆小数点削除
      return Number(_Modules_helper__WEBPACK_IMPORTED_MODULE_1__["default"].onlyNumberAndDot(str).toString().replace(/[\.]/g, '').slice(0, 2));
    },
    onlyNumber1digit: function onlyNumber1digit(str) {
      //2桁までしか許容しない＆小数点削除
      return Number(_Modules_helper__WEBPACK_IMPORTED_MODULE_1__["default"].onlyNumberAndDot(str).toString().replace(/[\.]/g, '').slice(0, 1));
    },
    is_hasDuplicate_name_method: function is_hasDuplicate_name_method() {
      var a = this.checkDuplicateName(this.name, false);
    },
    is_hasDuplicate_name_eng_method: function is_hasDuplicate_name_eng_method(event) {
      return this.checkDuplicateName(event, true);
    },
    checkDuplicateName: function checkDuplicateName(str, is_eng) {
      var _this = this;

      return _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default.a.mark(function _callee() {
        var _yield$axios$post, result;

        return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default.a.wrap(function _callee$(_context) {
          while (1) {
            switch (_context.prev = _context.next) {
              case 0:
                if (str) {
                  _context.next = 2;
                  break;
                }

                return _context.abrupt("return", false);

              case 2:
                //空白ならスルー
                console.log(str);
                _context.prev = 3;
                _context.next = 6;
                return axios.post("http://127.0.0.1:8000" + '/Cocktail/duplicate/check', {
                  command: _this.editMode,
                  is_eng: is_eng,
                  str: str,
                  parent: _this.editMode == "Middle" || _this.editMode == "Brand" ? _this.parent_id : null
                });

              case 6:
                _yield$axios$post = _context.sent;
                result = _yield$axios$post.data.result.is_duplicate;
                _context.next = 13;
                break;

              case 10:
                _context.prev = 10;
                _context.t0 = _context["catch"](3);
                console.log(_context.t0);

              case 13:
                if (is_eng) {
                  _this.is_hasDuplicate_name_eng = result;
                } else {
                  _this.is_hasDuplicate_name = result;
                }

                return _context.abrupt("return");

              case 15:
              case "end":
                return _context.stop();
            }
          }
        }, _callee, null, [[3, 10]]);
      }))();
    },
    change_name_eng: function change_name_eng(event) {
      this.$emit('update:name_eng', event ? this.big_to_hankaku(event) : '');
      this.is_hasDuplicate_name_eng_method(event);
    },
    onImagePicked: function onImagePicked(file) {
      var _this2 = this;

      if (file !== undefined && file !== null) {
        if (file.name.lastIndexOf('.') <= 0) {
          return;
        }

        var fr = new FileReader();
        fr.readAsDataURL(file);
        fr.addEventListener('load', function () {
          _this2.$emit('update:uploadImageUrl', fr.result);

          _this2.$emit('update:input_image', file);
        });
      } else {
        this.$emit('update:uploadImageUrl', '');
        this.$emit('update:input_image', null);
      }
    }
  }
});

/***/ }),

/***/ "./node_modules/css-loader/dist/cjs.js!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/src/index.js?!./node_modules/sass-loader/dist/cjs.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/Admin/Super/Detail/component/NamesAndDescription.vue?vue&type=style&index=0&id=152daecf&scoped=true&lang=scss&":
/*!***********************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/css-loader/dist/cjs.js!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/src??ref--7-2!./node_modules/sass-loader/dist/cjs.js??ref--7-3!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/Admin/Super/Detail/component/NamesAndDescription.vue?vue&type=style&index=0&id=152daecf&scoped=true&lang=scss& ***!
  \***********************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

// Imports
var ___CSS_LOADER_API_IMPORT___ = __webpack_require__(/*! ../../../../../../node_modules/css-loader/dist/runtime/api.js */ "./node_modules/css-loader/dist/runtime/api.js");
exports = ___CSS_LOADER_API_IMPORT___(false);
// Module
exports.push([module.i, "div.img_container[data-v-152daecf] {\n  text-align: center;\n}\ndiv.img_container img.preview[data-v-152daecf] {\n  max-height: 350px;\n  max-width: 100%;\n  margin: auto;\n}\ndiv.method[data-v-152daecf],\ndiv.rate[data-v-152daecf],\ndiv.sweet_degree[data-v-152daecf] {\n  max-width: 100px;\n}", ""]);
// Exports
module.exports = exports;


/***/ }),

/***/ "./node_modules/style-loader/index.js!./node_modules/css-loader/dist/cjs.js!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/src/index.js?!./node_modules/sass-loader/dist/cjs.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/Admin/Super/Detail/component/NamesAndDescription.vue?vue&type=style&index=0&id=152daecf&scoped=true&lang=scss&":
/*!***************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/style-loader!./node_modules/css-loader/dist/cjs.js!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/src??ref--7-2!./node_modules/sass-loader/dist/cjs.js??ref--7-3!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/Admin/Super/Detail/component/NamesAndDescription.vue?vue&type=style&index=0&id=152daecf&scoped=true&lang=scss& ***!
  \***************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {


var content = __webpack_require__(/*! !../../../../../../node_modules/css-loader/dist/cjs.js!../../../../../../node_modules/vue-loader/lib/loaders/stylePostLoader.js!../../../../../../node_modules/postcss-loader/src??ref--7-2!../../../../../../node_modules/sass-loader/dist/cjs.js??ref--7-3!../../../../../../node_modules/vue-loader/lib??vue-loader-options!./NamesAndDescription.vue?vue&type=style&index=0&id=152daecf&scoped=true&lang=scss& */ "./node_modules/css-loader/dist/cjs.js!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/src/index.js?!./node_modules/sass-loader/dist/cjs.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/Admin/Super/Detail/component/NamesAndDescription.vue?vue&type=style&index=0&id=152daecf&scoped=true&lang=scss&");

if(typeof content === 'string') content = [[module.i, content, '']];

var transform;
var insertInto;



var options = {"hmr":true}

options.transform = transform
options.insertInto = undefined;

var update = __webpack_require__(/*! ../../../../../../node_modules/style-loader/lib/addStyles.js */ "./node_modules/style-loader/lib/addStyles.js")(content, options);

if(content.locals) module.exports = content.locals;

if(false) {}

/***/ }),

/***/ "./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/Admin/Super/Detail/component/NamesAndDescription.vue?vue&type=template&id=152daecf&scoped=true&":
/*!****************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/Admin/Super/Detail/component/NamesAndDescription.vue?vue&type=template&id=152daecf&scoped=true& ***!
  \****************************************************************************************************************************************************************************************************************************************************/
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
  return _c(
    "div",
    [
      _vm.editMode == "Cocktail"
        ? _c(
            "div",
            { staticClass: "flexdiv", staticStyle: { "max-width": "500px" } },
            [
              _c(
                "div",
                { staticClass: "ice", staticStyle: { flex: "1" } },
                [
                  _c("v-select", {
                    attrs: {
                      items: _vm.iceLabel,
                      label: "氷の有無",
                      "item-text": "label",
                      "item-value": "value",
                      dense: ""
                    },
                    model: {
                      value: _vm.iceValue,
                      callback: function($$v) {
                        _vm.iceValue = $$v
                      },
                      expression: "iceValue"
                    }
                  })
                ],
                1
              ),
              _vm._v(" "),
              _c(
                "div",
                { staticClass: "glass", staticStyle: { flex: "1" } },
                [
                  _c("v-select", {
                    attrs: {
                      items: _vm.glassLabel,
                      label: "グラス",
                      "item-text": "label",
                      "item-value": "value",
                      dense: ""
                    },
                    model: {
                      value: _vm.glassValue,
                      callback: function($$v) {
                        _vm.glassValue = $$v
                      },
                      expression: "glassValue"
                    }
                  })
                ],
                1
              )
            ]
          )
        : _vm._e(),
      _vm._v(" "),
      _c(
        "div",
        { staticClass: "flexdiv" },
        [
          _c("v-text-field", {
            attrs: {
              value: _vm.name,
              counter: 255,
              label: "名前",
              "error-messages": _vm.is_hasDuplicate_name
                ? "[Warn]同じ名前が存在しています"
                : "",
              error: _vm.is_hasDuplicate_name,
              required: ""
            },
            on: {
              input: function($event) {
                return _vm.$emit("update:name", $event)
              },
              change: _vm.is_hasDuplicate_name_method
            }
          }),
          _vm._v(" "),
          _c("v-text-field", {
            attrs: {
              value: _vm.name_eng,
              "error-messages": _vm.is_hasDuplicate_name_eng
                ? "[Warn]同じ名前が存在しています"
                : "",
              counter: 255,
              label: "Name",
              required: ""
            },
            on: {
              change: function($event) {
                return _vm.change_name_eng($event)
              }
            }
          }),
          _vm._v(" "),
          _vm.editMode == "Brand"
            ? _c("v-text-field", {
                attrs: {
                  value: _vm.strength,
                  counter: 4,
                  label: "%",
                  required: ""
                },
                on: {
                  input: function($event) {
                    _vm.$emit(
                      "update:strength",
                      $event ? _vm.onlyNumberAndDot($event) : ""
                    )
                  }
                }
              })
            : _vm._e()
        ],
        1
      ),
      _vm._v(" "),
      _vm.editMode == "Cocktail"
        ? _c("div", { staticClass: "flexdiv" }, [
            _c("div", { staticStyle: { flex: "1" } }, [
              _c("a", { attrs: { href: _vm.meanurl, target: "_blank" } }, [
                _vm._v("意味検索")
              ])
            ]),
            _vm._v(" "),
            _c("div", { staticStyle: { flex: "1" } }, [
              _c("a", { attrs: { href: _vm.wordurl, target: "_blank" } }, [
                _vm._v("カクテル言葉検索")
              ])
            ])
          ])
        : _vm._e(),
      _vm._v(" "),
      _c("div", { staticClass: "flexdiv" }, [
        _vm.editMode == "Cocktail"
          ? _c(
              "div",
              { staticClass: "method", staticStyle: { flex: "1" } },
              [
                _c("v-select", {
                  attrs: {
                    items: _vm.methodLabel,
                    label: "製法",
                    "item-text": "label",
                    "item-value": "value",
                    dense: ""
                  },
                  model: {
                    value: _vm.methodValue,
                    callback: function($$v) {
                      _vm.methodValue = $$v
                    },
                    expression: "methodValue"
                  }
                })
              ],
              1
            )
          : _vm._e(),
        _vm._v(" "),
        _vm.editMode == "Cocktail"
          ? _c(
              "div",
              { staticClass: "rate", staticStyle: { flex: "1" } },
              [
                _c("v-select", {
                  attrs: {
                    items: _vm.rateLabel,
                    label: "評価",
                    "item-text": "label",
                    "item-value": "value",
                    dense: ""
                  },
                  model: {
                    value: _vm.rateValue,
                    callback: function($$v) {
                      _vm.rateValue = $$v
                    },
                    expression: "rateValue"
                  }
                })
              ],
              1
            )
          : _vm._e(),
        _vm._v(" "),
        _vm.editMode == "Cocktail"
          ? _c(
              "div",
              { staticClass: "sweet_degree", staticStyle: { flex: "1" } },
              [
                _c("v-select", {
                  attrs: {
                    items: _vm.sweetdegreeLabel,
                    label: "甘さ",
                    "item-text": "label",
                    "item-value": "value",
                    dense: ""
                  },
                  model: {
                    value: _vm.sweetDegreeValue,
                    callback: function($$v) {
                      _vm.sweetDegreeValue = $$v
                    },
                    expression: "sweetDegreeValue"
                  }
                })
              ],
              1
            )
          : _vm._e(),
        _vm._v(" "),
        _c("input", {
          attrs: { type: "checkbox" },
          domProps: { checked: _vm.is_major },
          on: {
            change: function($event) {
              return _vm.$emit("update:is_major", !!$event)
            }
          }
        }),
        _vm._v("メジャー\n            "),
        _vm.editMode != "Cocktail"
          ? _c("input", {
              attrs: { type: "checkbox" },
              domProps: { checked: _vm.is_like },
              on: {
                change: function($event) {
                  return _vm.$emit("update:is_like", !!$event)
                }
              }
            })
          : _vm._e(),
        _vm._v("お気に入り\n            "),
        _vm.editMode == "Middle" || _vm.editMode == "Category"
          ? _c("input", {
              attrs: { type: "checkbox" },
              domProps: { checked: _vm.is_powder },
              on: {
                change: function($event) {
                  return _vm.$emit("update:is_powder", !!$event)
                }
              }
            })
          : _vm._e(),
        _vm._v("粉もの\n        ")
      ]),
      _vm._v(" "),
      _c("v-textarea", {
        attrs: { outlined: "", value: _vm.description, label: "説明" },
        on: {
          input: function($event) {
            return _vm.$emit("update:description", $event)
          }
        }
      }),
      _vm._v(" "),
      _vm.editMode == "Cocktail"
        ? _c("v-textarea", {
            attrs: { outlined: "", value: _vm.note, label: "補足" },
            on: {
              input: function($event) {
                return _vm.$emit("update:note", $event)
              }
            }
          })
        : _vm._e(),
      _vm._v(" "),
      _c(
        "div",
        { staticClass: "flexdiv" },
        [
          _c("v-text-field", {
            attrs: { value: _vm.youtube, counter: 255, label: "Youtube" },
            on: {
              input: function($event) {
                return _vm.$emit("update:youtube", $event)
              }
            }
          }),
          _vm._v(" "),
          _c("v-text-field", {
            attrs: { value: _vm.youtube_time_hour, counter: 1, label: "時" },
            on: {
              change: function($event) {
                _vm.$emit(
                  "update:youtube_time_hour",
                  $event ? _vm.onlyNumber1digit($event) : ""
                )
              }
            }
          }),
          _vm._v(" "),
          _c("v-text-field", {
            attrs: { value: _vm.youtube_time_minute, counter: 2, label: "分" },
            on: {
              change: function($event) {
                _vm.$emit(
                  "update:youtube_time_minute",
                  $event ? _vm.onlyNumber2digit($event) : ""
                )
              }
            }
          }),
          _vm._v(" "),
          _c("v-text-field", {
            attrs: { value: _vm.youtube_time_second, counter: 2, label: "秒" },
            on: {
              change: function($event) {
                _vm.$emit(
                  "update:youtube_time_second",
                  $event ? _vm.onlyNumber2digit($event) : ""
                )
              }
            }
          })
        ],
        1
      ),
      _vm._v(" "),
      _c(
        "div",
        { staticClass: "img_container" },
        [
          _vm.uploadImageUrl
            ? _c("img", {
                staticClass: "preview",
                attrs: { src: _vm.uploadImageUrl }
              })
            : _vm._e(),
          _vm._v(" "),
          _vm.input_image !== undefined
            ? _c("v-file-input", {
                attrs: {
                  value: _vm.input_image,
                  accept: "image/*",
                  "show-size": "",
                  label: "画像ファイルをアップロードしてください",
                  "prepend-icon": "mdi-image"
                },
                on: {
                  change: function($event) {
                    return _vm.onImagePicked($event)
                  }
                }
              })
            : _vm._e()
        ],
        1
      ),
      _vm._v(" "),
      _c(
        "div",
        { staticClass: "flexdiv" },
        [
          _c("v-text-field", {
            attrs: {
              value: _vm.link_txt,
              counter: 255,
              label: "リンクテキスト"
            },
            on: {
              input: function($event) {
                return _vm.$emit("update:link_txt", $event)
              }
            }
          }),
          _vm._v(" "),
          _c("v-text-field", {
            attrs: { value: _vm.link_url, counter: 400, label: "リンクURL" },
            on: {
              input: function($event) {
                return _vm.$emit("update:link_url", $event)
              }
            }
          })
        ],
        1
      )
    ],
    1
  )
}
var staticRenderFns = []
render._withStripped = true



/***/ }),

/***/ "./resources/js/Admin/Super/Detail/component/NamesAndDescription.vue":
/*!***************************************************************************!*\
  !*** ./resources/js/Admin/Super/Detail/component/NamesAndDescription.vue ***!
  \***************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _NamesAndDescription_vue_vue_type_template_id_152daecf_scoped_true___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./NamesAndDescription.vue?vue&type=template&id=152daecf&scoped=true& */ "./resources/js/Admin/Super/Detail/component/NamesAndDescription.vue?vue&type=template&id=152daecf&scoped=true&");
/* harmony import */ var _NamesAndDescription_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./NamesAndDescription.vue?vue&type=script&lang=js& */ "./resources/js/Admin/Super/Detail/component/NamesAndDescription.vue?vue&type=script&lang=js&");
/* empty/unused harmony star reexport *//* harmony import */ var _NamesAndDescription_vue_vue_type_style_index_0_id_152daecf_scoped_true_lang_scss___WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./NamesAndDescription.vue?vue&type=style&index=0&id=152daecf&scoped=true&lang=scss& */ "./resources/js/Admin/Super/Detail/component/NamesAndDescription.vue?vue&type=style&index=0&id=152daecf&scoped=true&lang=scss&");
/* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! ../../../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");






/* normalize component */

var component = Object(_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_3__["default"])(
  _NamesAndDescription_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__["default"],
  _NamesAndDescription_vue_vue_type_template_id_152daecf_scoped_true___WEBPACK_IMPORTED_MODULE_0__["render"],
  _NamesAndDescription_vue_vue_type_template_id_152daecf_scoped_true___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"],
  false,
  null,
  "152daecf",
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/Admin/Super/Detail/component/NamesAndDescription.vue"
/* harmony default export */ __webpack_exports__["default"] = (component.exports);

/***/ }),

/***/ "./resources/js/Admin/Super/Detail/component/NamesAndDescription.vue?vue&type=script&lang=js&":
/*!****************************************************************************************************!*\
  !*** ./resources/js/Admin/Super/Detail/component/NamesAndDescription.vue?vue&type=script&lang=js& ***!
  \****************************************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_NamesAndDescription_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../../node_modules/babel-loader/lib??ref--4-0!../../../../../../node_modules/vue-loader/lib??vue-loader-options!./NamesAndDescription.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/Admin/Super/Detail/component/NamesAndDescription.vue?vue&type=script&lang=js&");
/* empty/unused harmony star reexport */ /* harmony default export */ __webpack_exports__["default"] = (_node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_NamesAndDescription_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__["default"]); 

/***/ }),

/***/ "./resources/js/Admin/Super/Detail/component/NamesAndDescription.vue?vue&type=style&index=0&id=152daecf&scoped=true&lang=scss&":
/*!*************************************************************************************************************************************!*\
  !*** ./resources/js/Admin/Super/Detail/component/NamesAndDescription.vue?vue&type=style&index=0&id=152daecf&scoped=true&lang=scss& ***!
  \*************************************************************************************************************************************/
/*! no static exports found */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_style_loader_index_js_node_modules_css_loader_dist_cjs_js_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_src_index_js_ref_7_2_node_modules_sass_loader_dist_cjs_js_ref_7_3_node_modules_vue_loader_lib_index_js_vue_loader_options_NamesAndDescription_vue_vue_type_style_index_0_id_152daecf_scoped_true_lang_scss___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../../node_modules/style-loader!../../../../../../node_modules/css-loader/dist/cjs.js!../../../../../../node_modules/vue-loader/lib/loaders/stylePostLoader.js!../../../../../../node_modules/postcss-loader/src??ref--7-2!../../../../../../node_modules/sass-loader/dist/cjs.js??ref--7-3!../../../../../../node_modules/vue-loader/lib??vue-loader-options!./NamesAndDescription.vue?vue&type=style&index=0&id=152daecf&scoped=true&lang=scss& */ "./node_modules/style-loader/index.js!./node_modules/css-loader/dist/cjs.js!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/src/index.js?!./node_modules/sass-loader/dist/cjs.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/Admin/Super/Detail/component/NamesAndDescription.vue?vue&type=style&index=0&id=152daecf&scoped=true&lang=scss&");
/* harmony import */ var _node_modules_style_loader_index_js_node_modules_css_loader_dist_cjs_js_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_src_index_js_ref_7_2_node_modules_sass_loader_dist_cjs_js_ref_7_3_node_modules_vue_loader_lib_index_js_vue_loader_options_NamesAndDescription_vue_vue_type_style_index_0_id_152daecf_scoped_true_lang_scss___WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_node_modules_style_loader_index_js_node_modules_css_loader_dist_cjs_js_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_src_index_js_ref_7_2_node_modules_sass_loader_dist_cjs_js_ref_7_3_node_modules_vue_loader_lib_index_js_vue_loader_options_NamesAndDescription_vue_vue_type_style_index_0_id_152daecf_scoped_true_lang_scss___WEBPACK_IMPORTED_MODULE_0__);
/* harmony reexport (unknown) */ for(var __WEBPACK_IMPORT_KEY__ in _node_modules_style_loader_index_js_node_modules_css_loader_dist_cjs_js_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_src_index_js_ref_7_2_node_modules_sass_loader_dist_cjs_js_ref_7_3_node_modules_vue_loader_lib_index_js_vue_loader_options_NamesAndDescription_vue_vue_type_style_index_0_id_152daecf_scoped_true_lang_scss___WEBPACK_IMPORTED_MODULE_0__) if(["default"].indexOf(__WEBPACK_IMPORT_KEY__) < 0) (function(key) { __webpack_require__.d(__webpack_exports__, key, function() { return _node_modules_style_loader_index_js_node_modules_css_loader_dist_cjs_js_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_src_index_js_ref_7_2_node_modules_sass_loader_dist_cjs_js_ref_7_3_node_modules_vue_loader_lib_index_js_vue_loader_options_NamesAndDescription_vue_vue_type_style_index_0_id_152daecf_scoped_true_lang_scss___WEBPACK_IMPORTED_MODULE_0__[key]; }) }(__WEBPACK_IMPORT_KEY__));
 /* harmony default export */ __webpack_exports__["default"] = (_node_modules_style_loader_index_js_node_modules_css_loader_dist_cjs_js_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_src_index_js_ref_7_2_node_modules_sass_loader_dist_cjs_js_ref_7_3_node_modules_vue_loader_lib_index_js_vue_loader_options_NamesAndDescription_vue_vue_type_style_index_0_id_152daecf_scoped_true_lang_scss___WEBPACK_IMPORTED_MODULE_0___default.a); 

/***/ }),

/***/ "./resources/js/Admin/Super/Detail/component/NamesAndDescription.vue?vue&type=template&id=152daecf&scoped=true&":
/*!**********************************************************************************************************************!*\
  !*** ./resources/js/Admin/Super/Detail/component/NamesAndDescription.vue?vue&type=template&id=152daecf&scoped=true& ***!
  \**********************************************************************************************************************/
/*! exports provided: render, staticRenderFns */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_NamesAndDescription_vue_vue_type_template_id_152daecf_scoped_true___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../../../../../node_modules/vue-loader/lib??vue-loader-options!./NamesAndDescription.vue?vue&type=template&id=152daecf&scoped=true& */ "./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/Admin/Super/Detail/component/NamesAndDescription.vue?vue&type=template&id=152daecf&scoped=true&");
/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "render", function() { return _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_NamesAndDescription_vue_vue_type_template_id_152daecf_scoped_true___WEBPACK_IMPORTED_MODULE_0__["render"]; });

/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "staticRenderFns", function() { return _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_NamesAndDescription_vue_vue_type_template_id_152daecf_scoped_true___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"]; });



/***/ })

}]);