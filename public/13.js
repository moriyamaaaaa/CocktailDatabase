(window["webpackJsonp"] = window["webpackJsonp"] || []).push([[13],{

/***/ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/Admin/Super/Detail/BrandEdit.vue?vue&type=script&lang=js&":
/*!****************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib??ref--4-0!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/Admin/Super/Detail/BrandEdit.vue?vue&type=script&lang=js& ***!
  \****************************************************************************************************************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @babel/runtime/regenerator */ "./node_modules/@babel/runtime/regenerator/index.js");
/* harmony import */ var _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var _component_CategorySelect__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./component/CategorySelect */ "./resources/js/Admin/Super/Detail/component/CategorySelect.vue");
/* harmony import */ var _component_NamesAndDescription__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./component/NamesAndDescription */ "./resources/js/Admin/Super/Detail/component/NamesAndDescription.vue");
/* harmony import */ var _component_validationComponent__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! ./component/validationComponent */ "./resources/js/Admin/Super/Detail/component/validationComponent.js");


function ownKeys(object, enumerableOnly) { var keys = Object.keys(object); if (Object.getOwnPropertySymbols) { var symbols = Object.getOwnPropertySymbols(object); if (enumerableOnly) symbols = symbols.filter(function (sym) { return Object.getOwnPropertyDescriptor(object, sym).enumerable; }); keys.push.apply(keys, symbols); } return keys; }

function _objectSpread(target) { for (var i = 1; i < arguments.length; i++) { var source = arguments[i] != null ? arguments[i] : {}; if (i % 2) { ownKeys(Object(source), true).forEach(function (key) { _defineProperty(target, key, source[key]); }); } else if (Object.getOwnPropertyDescriptors) { Object.defineProperties(target, Object.getOwnPropertyDescriptors(source)); } else { ownKeys(Object(source)).forEach(function (key) { Object.defineProperty(target, key, Object.getOwnPropertyDescriptor(source, key)); }); } } return target; }

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




var Validator = __webpack_require__(/*! validatorjs */ "./node_modules/validatorjs/src/validator.js");

Validator.useLang('ja');
/* harmony default export */ __webpack_exports__["default"] = ({
  mixins: [_component_validationComponent__WEBPACK_IMPORTED_MODULE_3__["default"]],
  components: {
    CategorySecelt: _component_CategorySelect__WEBPACK_IMPORTED_MODULE_1__["default"],
    NameAndDrescription: _component_NamesAndDescription__WEBPACK_IMPORTED_MODULE_2__["default"]
  },
  props: {
    brand_id: Number
  },
  data: function data() {
    return {
      editMode: "Brand",
      selectedCategory: null,
      selectedMiddle: null,
      //initialCategoryId:null,
      //initialMiddleId:null,
      detailEditObj: {
        name: "",
        name_eng: "",
        strength: null,
        description: "",
        youtube: "",
        youtube_time_hour: null,
        youtube_time_minute: null,
        youtube_time_second: null,
        link_txt: "",
        link_url: "",
        is_major: false,
        is_like: false,
        input_image: null,
        uploadImageUrl: null
      }
    };
  },
  created: function created() {
    var _this = this;

    return _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default.a.mark(function _callee() {
      var _yield$axios$post, brand;

      return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default.a.wrap(function _callee$(_context) {
        while (1) {
          switch (_context.prev = _context.next) {
            case 0:
              if (_this.brand_id) {
                _context.next = 2;
                break;
              }

              return _context.abrupt("return");

            case 2:
              _context.prev = 2;
              _context.next = 5;
              return axios.post("http://127.0.0.1:8000" + '/Cocktail/admin/get/brand', {
                id: _this.brand_id
              });

            case 5:
              _yield$axios$post = _context.sent;
              brand = _yield$axios$post.data.result.brand;
              _context.next = 12;
              break;

            case 9:
              _context.prev = 9;
              _context.t0 = _context["catch"](2);
              console.log(_context.t0);

            case 12:
              console.log(brand);
              _this.detailEditObj.name = brand.name;
              _this.detailEditObj.name_eng = brand.name_eng;
              _this.detailEditObj.strength = brand.strength;
              _this.detailEditObj.description = brand.description;
              _this.detailEditObj.youtube = brand.youtube;
              _this.detailEditObj.youtube_time_hour = brand.y_hour;
              _this.detailEditObj.youtube_time_minute = brand.y_minute;
              _this.detailEditObj.youtube_time_second = brand.y_second;
              _this.detailEditObj.link_txt = brand.image_txt;
              _this.detailEditObj.link_url = brand.image_url;
              _this.detailEditObj.is_major = brand.is_major;
              _this.detailEditObj.is_like = brand.is_like;
              _this.detailEditObj.uploadImageUrl = brand.image;
              _this.selectedCategory = {
                value: brand.category,
                label: ""
              };
              _this.selectedMiddle = {
                value: brand.middle_category,
                label: ""
              };

            case 28:
            case "end":
              return _context.stop();
          }
        }
      }, _callee, null, [[2, 9]]);
    }))();
  },
  computed: {
    sendObj: function sendObj() {
      //PHP側に渡すオブジェクトを整形する
      var data = _objectSpread({
        id: this.brand_id ? this.brand_id : null,
        category: this.selectedCategory.value,
        middle: this.selectedMiddle ? this.selectedMiddle.value : null
      }, this.detailEditObj);

      if (data.uploadImageUrl) {
        delete data.uploadImageUrl; //特に必要のないデータ
      }

      return data;
    },
    formdata: function formdata() {
      var _this2 = this;

      //sendObjをFormData型に変換する
      var bodyFormData = new FormData();
      Object.keys(this.sendObj).forEach(function (key) {
        bodyFormData.append(key, _this2.sendObj[key]);
      });
      return bodyFormData;
    }
  },
  methods: {
    send: function send() {
      var _this3 = this;

      return _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default.a.mark(function _callee2() {
        var result;
        return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default.a.wrap(function _callee2$(_context2) {
          while (1) {
            switch (_context2.prev = _context2.next) {
              case 0:
                if (_this3.is_validation([_this3.$refs.form.validateObj, _this3.$refs.categorySelect.validateObj])) {
                  _context2.next = 2;
                  break;
                }

                return _context2.abrupt("return");

              case 2:
                _context2.prev = 2;
                _context2.next = 5;
                return axios.post("http://127.0.0.1:8000" + '/admin/submit/brand', _this3.formdata, {
                  headers: {
                    'Content-Type': 'multipart/form-data'
                  }
                });

              case 5:
                result = _context2.sent;
                _context2.next = 12;
                break;

              case 8:
                _context2.prev = 8;
                _context2.t0 = _context2["catch"](2);
                alert(_context2.t0.response.data.message);
                return _context2.abrupt("return");

              case 12:
                //特に更新終了を待つ必要はないので、さっさとトップ画面に戻ってしまう
                _this3.$router.push({
                  name: 'AdminHome'
                }); //結果表示画面に飛ばす


              case 13:
              case "end":
                return _context2.stop();
            }
          }
        }, _callee2, null, [[2, 8]]);
      }))();
    }
  }
});

/***/ }),

/***/ "./node_modules/css-loader/dist/cjs.js!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/src/index.js?!./node_modules/sass-loader/dist/cjs.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/Admin/Super/Detail/BrandEdit.vue?vue&type=style&index=0&id=1da04105&scoped=true&lang=scss&":
/*!***************************************************************************************************************************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/css-loader/dist/cjs.js!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/src??ref--7-2!./node_modules/sass-loader/dist/cjs.js??ref--7-3!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/Admin/Super/Detail/BrandEdit.vue?vue&type=style&index=0&id=1da04105&scoped=true&lang=scss& ***!
  \***************************************************************************************************************************************************************************************************************************************************************************************************************************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

// Imports
var ___CSS_LOADER_API_IMPORT___ = __webpack_require__(/*! ../../../../../node_modules/css-loader/dist/runtime/api.js */ "./node_modules/css-loader/dist/runtime/api.js");
exports = ___CSS_LOADER_API_IMPORT___(false);
// Module
exports.push([module.i, "div#container[data-v-1da04105] {\n  max-width: 800px;\n  margin: auto;\n}", ""]);
// Exports
module.exports = exports;


/***/ }),

/***/ "./node_modules/style-loader/index.js!./node_modules/css-loader/dist/cjs.js!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/src/index.js?!./node_modules/sass-loader/dist/cjs.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/Admin/Super/Detail/BrandEdit.vue?vue&type=style&index=0&id=1da04105&scoped=true&lang=scss&":
/*!*******************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/style-loader!./node_modules/css-loader/dist/cjs.js!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/src??ref--7-2!./node_modules/sass-loader/dist/cjs.js??ref--7-3!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/Admin/Super/Detail/BrandEdit.vue?vue&type=style&index=0&id=1da04105&scoped=true&lang=scss& ***!
  \*******************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {


var content = __webpack_require__(/*! !../../../../../node_modules/css-loader/dist/cjs.js!../../../../../node_modules/vue-loader/lib/loaders/stylePostLoader.js!../../../../../node_modules/postcss-loader/src??ref--7-2!../../../../../node_modules/sass-loader/dist/cjs.js??ref--7-3!../../../../../node_modules/vue-loader/lib??vue-loader-options!./BrandEdit.vue?vue&type=style&index=0&id=1da04105&scoped=true&lang=scss& */ "./node_modules/css-loader/dist/cjs.js!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/src/index.js?!./node_modules/sass-loader/dist/cjs.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/Admin/Super/Detail/BrandEdit.vue?vue&type=style&index=0&id=1da04105&scoped=true&lang=scss&");

if(typeof content === 'string') content = [[module.i, content, '']];

var transform;
var insertInto;



var options = {"hmr":true}

options.transform = transform
options.insertInto = undefined;

var update = __webpack_require__(/*! ../../../../../node_modules/style-loader/lib/addStyles.js */ "./node_modules/style-loader/lib/addStyles.js")(content, options);

if(content.locals) module.exports = content.locals;

if(false) {}

/***/ }),

/***/ "./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/Admin/Super/Detail/BrandEdit.vue?vue&type=template&id=1da04105&scoped=true&":
/*!********************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/Admin/Super/Detail/BrandEdit.vue?vue&type=template&id=1da04105&scoped=true& ***!
  \********************************************************************************************************************************************************************************************************************************/
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
    { attrs: { id: "container" } },
    [
      _c("category-secelt", {
        ref: "categorySelect",
        attrs: {
          "edit-mode": _vm.editMode,
          "selected-category": _vm.selectedCategory,
          "selected-middle": _vm.selectedMiddle
        },
        on: {
          "update:selectedCategory": function($event) {
            _vm.selectedCategory = $event
          },
          "update:selected-category": function($event) {
            _vm.selectedCategory = $event
          },
          "update:selectedMiddle": function($event) {
            _vm.selectedMiddle = $event
          },
          "update:selected-middle": function($event) {
            _vm.selectedMiddle = $event
          }
        }
      }),
      _vm._v(" "),
      _c("br"),
      _vm._v(" "),
      _c(
        "NameAndDrescription",
        _vm._b(
          { ref: "form", attrs: { "edit-mode": _vm.editMode } },
          "NameAndDrescription",
          _vm.detailEditObj,
          false,
          true
        )
      ),
      _vm._v(" "),
      _c("br"),
      _vm._v(" "),
      _c(
        "v-btn",
        {
          attrs: { large: "", color: "blue darken-3", dark: "" },
          on: { click: _vm.send }
        },
        [_vm._v("送信")]
      )
    ],
    1
  )
}
var staticRenderFns = []
render._withStripped = true



/***/ }),

/***/ "./resources/js/Admin/Super/Detail/BrandEdit.vue":
/*!*******************************************************!*\
  !*** ./resources/js/Admin/Super/Detail/BrandEdit.vue ***!
  \*******************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _BrandEdit_vue_vue_type_template_id_1da04105_scoped_true___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./BrandEdit.vue?vue&type=template&id=1da04105&scoped=true& */ "./resources/js/Admin/Super/Detail/BrandEdit.vue?vue&type=template&id=1da04105&scoped=true&");
/* harmony import */ var _BrandEdit_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./BrandEdit.vue?vue&type=script&lang=js& */ "./resources/js/Admin/Super/Detail/BrandEdit.vue?vue&type=script&lang=js&");
/* empty/unused harmony star reexport *//* harmony import */ var _BrandEdit_vue_vue_type_style_index_0_id_1da04105_scoped_true_lang_scss___WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./BrandEdit.vue?vue&type=style&index=0&id=1da04105&scoped=true&lang=scss& */ "./resources/js/Admin/Super/Detail/BrandEdit.vue?vue&type=style&index=0&id=1da04105&scoped=true&lang=scss&");
/* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! ../../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");






/* normalize component */

var component = Object(_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_3__["default"])(
  _BrandEdit_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__["default"],
  _BrandEdit_vue_vue_type_template_id_1da04105_scoped_true___WEBPACK_IMPORTED_MODULE_0__["render"],
  _BrandEdit_vue_vue_type_template_id_1da04105_scoped_true___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"],
  false,
  null,
  "1da04105",
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/Admin/Super/Detail/BrandEdit.vue"
/* harmony default export */ __webpack_exports__["default"] = (component.exports);

/***/ }),

/***/ "./resources/js/Admin/Super/Detail/BrandEdit.vue?vue&type=script&lang=js&":
/*!********************************************************************************!*\
  !*** ./resources/js/Admin/Super/Detail/BrandEdit.vue?vue&type=script&lang=js& ***!
  \********************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_BrandEdit_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../node_modules/babel-loader/lib??ref--4-0!../../../../../node_modules/vue-loader/lib??vue-loader-options!./BrandEdit.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/Admin/Super/Detail/BrandEdit.vue?vue&type=script&lang=js&");
/* empty/unused harmony star reexport */ /* harmony default export */ __webpack_exports__["default"] = (_node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_BrandEdit_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__["default"]); 

/***/ }),

/***/ "./resources/js/Admin/Super/Detail/BrandEdit.vue?vue&type=style&index=0&id=1da04105&scoped=true&lang=scss&":
/*!*****************************************************************************************************************!*\
  !*** ./resources/js/Admin/Super/Detail/BrandEdit.vue?vue&type=style&index=0&id=1da04105&scoped=true&lang=scss& ***!
  \*****************************************************************************************************************/
/*! no static exports found */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_style_loader_index_js_node_modules_css_loader_dist_cjs_js_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_src_index_js_ref_7_2_node_modules_sass_loader_dist_cjs_js_ref_7_3_node_modules_vue_loader_lib_index_js_vue_loader_options_BrandEdit_vue_vue_type_style_index_0_id_1da04105_scoped_true_lang_scss___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../node_modules/style-loader!../../../../../node_modules/css-loader/dist/cjs.js!../../../../../node_modules/vue-loader/lib/loaders/stylePostLoader.js!../../../../../node_modules/postcss-loader/src??ref--7-2!../../../../../node_modules/sass-loader/dist/cjs.js??ref--7-3!../../../../../node_modules/vue-loader/lib??vue-loader-options!./BrandEdit.vue?vue&type=style&index=0&id=1da04105&scoped=true&lang=scss& */ "./node_modules/style-loader/index.js!./node_modules/css-loader/dist/cjs.js!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/src/index.js?!./node_modules/sass-loader/dist/cjs.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/Admin/Super/Detail/BrandEdit.vue?vue&type=style&index=0&id=1da04105&scoped=true&lang=scss&");
/* harmony import */ var _node_modules_style_loader_index_js_node_modules_css_loader_dist_cjs_js_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_src_index_js_ref_7_2_node_modules_sass_loader_dist_cjs_js_ref_7_3_node_modules_vue_loader_lib_index_js_vue_loader_options_BrandEdit_vue_vue_type_style_index_0_id_1da04105_scoped_true_lang_scss___WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_node_modules_style_loader_index_js_node_modules_css_loader_dist_cjs_js_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_src_index_js_ref_7_2_node_modules_sass_loader_dist_cjs_js_ref_7_3_node_modules_vue_loader_lib_index_js_vue_loader_options_BrandEdit_vue_vue_type_style_index_0_id_1da04105_scoped_true_lang_scss___WEBPACK_IMPORTED_MODULE_0__);
/* harmony reexport (unknown) */ for(var __WEBPACK_IMPORT_KEY__ in _node_modules_style_loader_index_js_node_modules_css_loader_dist_cjs_js_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_src_index_js_ref_7_2_node_modules_sass_loader_dist_cjs_js_ref_7_3_node_modules_vue_loader_lib_index_js_vue_loader_options_BrandEdit_vue_vue_type_style_index_0_id_1da04105_scoped_true_lang_scss___WEBPACK_IMPORTED_MODULE_0__) if(["default"].indexOf(__WEBPACK_IMPORT_KEY__) < 0) (function(key) { __webpack_require__.d(__webpack_exports__, key, function() { return _node_modules_style_loader_index_js_node_modules_css_loader_dist_cjs_js_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_src_index_js_ref_7_2_node_modules_sass_loader_dist_cjs_js_ref_7_3_node_modules_vue_loader_lib_index_js_vue_loader_options_BrandEdit_vue_vue_type_style_index_0_id_1da04105_scoped_true_lang_scss___WEBPACK_IMPORTED_MODULE_0__[key]; }) }(__WEBPACK_IMPORT_KEY__));
 /* harmony default export */ __webpack_exports__["default"] = (_node_modules_style_loader_index_js_node_modules_css_loader_dist_cjs_js_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_src_index_js_ref_7_2_node_modules_sass_loader_dist_cjs_js_ref_7_3_node_modules_vue_loader_lib_index_js_vue_loader_options_BrandEdit_vue_vue_type_style_index_0_id_1da04105_scoped_true_lang_scss___WEBPACK_IMPORTED_MODULE_0___default.a); 

/***/ }),

/***/ "./resources/js/Admin/Super/Detail/BrandEdit.vue?vue&type=template&id=1da04105&scoped=true&":
/*!**************************************************************************************************!*\
  !*** ./resources/js/Admin/Super/Detail/BrandEdit.vue?vue&type=template&id=1da04105&scoped=true& ***!
  \**************************************************************************************************/
/*! exports provided: render, staticRenderFns */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_BrandEdit_vue_vue_type_template_id_1da04105_scoped_true___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../../../../node_modules/vue-loader/lib??vue-loader-options!./BrandEdit.vue?vue&type=template&id=1da04105&scoped=true& */ "./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/Admin/Super/Detail/BrandEdit.vue?vue&type=template&id=1da04105&scoped=true&");
/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "render", function() { return _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_BrandEdit_vue_vue_type_template_id_1da04105_scoped_true___WEBPACK_IMPORTED_MODULE_0__["render"]; });

/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "staticRenderFns", function() { return _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_BrandEdit_vue_vue_type_template_id_1da04105_scoped_true___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"]; });



/***/ }),

/***/ "./resources/js/Admin/Super/Detail/component/validationComponent.js":
/*!**************************************************************************!*\
  !*** ./resources/js/Admin/Super/Detail/component/validationComponent.js ***!
  \**************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony default export */ __webpack_exports__["default"] = ({
  methods: {
    objsDock: function objsDock(refObjs) {
      //フォームオブジェクト配列を受け取り、それをドッキングする
      var result = {};
      refObjs.forEach(function (obj) {
        Object.assign(result, obj.errors.all());
      });
      return result;
    },
    dockValidationMsgs: function dockValidationMsgs(array) {
      var result;
      Object.keys(array).forEach(function (key) {
        array[key].forEach(function (value) {
          result = result ? result = result.concat([value]) : [value];
        });
      });
      return result;
    },
    validateExe: function validateExe(vObjArray) {
      //validatorクラスの配列を受け取り、バリデーション結果を返す
      //まずはキーとそれに紐付いたエラーメッセージ群の配列にしたい
      var array = this.objsDock(vObjArray); //つぎにエラーメッセージ配列を展開し、エラーメッセージだけの配列にする

      var vobjMsgs = this.dockValidationMsgs(array);

      if (vobjMsgs) {
        var errormsg = "入力項目に誤りがあります";
        vobjMsgs.forEach(function (v) {
          errormsg += "\n" + v;
        });
        alert(errormsg);
      }

      return vobjMsgs;
    },
    is_validation: function is_validation(vObjArray) {
      //validatorクラスの配列を受け取り、バリデーション結果を返す
      return this.validateExe(vObjArray) ? false : true;
    }
  }
});

/***/ })

}]);