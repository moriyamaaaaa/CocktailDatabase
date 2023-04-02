(window["webpackJsonp"] = window["webpackJsonp"] || []).push([[28],{

/***/ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/Admin/Super/BrandList.vue?vue&type=script&lang=js&":
/*!*********************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib??ref--4-0!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/Admin/Super/BrandList.vue?vue&type=script&lang=js& ***!
  \*********************************************************************************************************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @babel/runtime/regenerator */ "./node_modules/@babel/runtime/regenerator/index.js");
/* harmony import */ var _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var _ListComponent__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./ListComponent */ "./resources/js/Admin/Super/ListComponent.vue");


function asyncGeneratorStep(gen, resolve, reject, _next, _throw, key, arg) { try { var info = gen[key](arg); var value = info.value; } catch (error) { reject(error); return; } if (info.done) { resolve(value); } else { Promise.resolve(value).then(_next, _throw); } }

function _asyncToGenerator(fn) { return function () { var self = this, args = arguments; return new Promise(function (resolve, reject) { var gen = fn.apply(self, args); function _next(value) { asyncGeneratorStep(gen, resolve, reject, _next, _throw, "next", value); } function _throw(err) { asyncGeneratorStep(gen, resolve, reject, _next, _throw, "throw", err); } _next(undefined); }); }; }

//
//
//
//
//
//

/* harmony default export */ __webpack_exports__["default"] = ({
  props: {
    category_id: {
      type: Number,
      "default": null
    },
    middle_id: {
      type: Number,
      "default": null
    }
  },
  data: function data() {
    return {
      brands: null
    };
  },
  components: {
    ListComponent: _ListComponent__WEBPACK_IMPORTED_MODULE_1__["default"]
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
              _context.next = 2;
              return axios.post("http://127.0.0.1:8000" + '/api/getBrandListWithCategory', this.whereIds);

            case 2:
              _ref = _context.sent;
              list = _ref.data.result.Brands;
              this.brands = list;

            case 5:
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
  computed: {
    whereIds: function whereIds() {
      return {
        category_id: this.category_id,
        middle_id: this.middle_id
      };
    }
  }
});

/***/ }),

/***/ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/Admin/Super/Detail/MiddleEdit.vue?vue&type=script&lang=js&":
/*!*****************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib??ref--4-0!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/Admin/Super/Detail/MiddleEdit.vue?vue&type=script&lang=js& ***!
  \*****************************************************************************************************************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @babel/runtime/regenerator */ "./node_modules/@babel/runtime/regenerator/index.js");
/* harmony import */ var _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var _component_CategorySelect__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./component/CategorySelect */ "./resources/js/Admin/Super/Detail/component/CategorySelect.vue");
/* harmony import */ var _component_NamesAndDescription__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./component/NamesAndDescription */ "./resources/js/Admin/Super/Detail/component/NamesAndDescription.vue");
/* harmony import */ var _component_FamousBrandSelect__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! ./component/FamousBrandSelect */ "./resources/js/Admin/Super/Detail/component/FamousBrandSelect.vue");
/* harmony import */ var _component_validationComponent__WEBPACK_IMPORTED_MODULE_4__ = __webpack_require__(/*! ./component/validationComponent */ "./resources/js/Admin/Super/Detail/component/validationComponent.js");
/* harmony import */ var _component_newBrandObjDatat__WEBPACK_IMPORTED_MODULE_5__ = __webpack_require__(/*! ./component/newBrandObjDatat */ "./resources/js/Admin/Super/Detail/component/newBrandObjDatat.js");
/* harmony import */ var _BrandList__WEBPACK_IMPORTED_MODULE_6__ = __webpack_require__(/*! ./../BrandList */ "./resources/js/Admin/Super/BrandList.vue");


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
  mixins: [_component_validationComponent__WEBPACK_IMPORTED_MODULE_4__["default"], _component_newBrandObjDatat__WEBPACK_IMPORTED_MODULE_5__["default"]],
  components: {
    CategorySecelt: _component_CategorySelect__WEBPACK_IMPORTED_MODULE_1__["default"],
    NameAndDrescription: _component_NamesAndDescription__WEBPACK_IMPORTED_MODULE_2__["default"],
    FamousBrand: _component_FamousBrandSelect__WEBPACK_IMPORTED_MODULE_3__["default"],
    BrandList: _BrandList__WEBPACK_IMPORTED_MODULE_6__["default"]
  },
  props: {
    middle_id: Number
  },
  data: function data() {
    return {
      editMode: "Middle",
      selectedCategory: null,
      selectedBrand: null,
      //initialCategoryId:null,
      //initialMiddleId:null,
      detailEditObj: {
        name: "",
        name_eng: "",
        description: "",
        youtube: "",
        youtube_time_hour: null,
        youtube_time_minute: null,
        youtube_time_second: null,
        link_txt: "",
        link_url: "",
        is_major: false,
        is_like: false,
        is_powder: false,
        input_image: null,
        uploadImageUrl: null
      }
    };
  },
  created: function () {
    var _created = _asyncToGenerator(
    /*#__PURE__*/
    _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default.a.mark(function _callee() {
      var _ref, middle;

      return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default.a.wrap(function _callee$(_context) {
        while (1) {
          switch (_context.prev = _context.next) {
            case 0:
              if (this.middle_id) {
                _context.next = 2;
                break;
              }

              return _context.abrupt("return");

            case 2:
              _context.prev = 2;
              _context.next = 5;
              return axios.post("http://127.0.0.1:8000" + '/Cocktail/admin/get/middle', {
                id: this.middle_id
              });

            case 5:
              _ref = _context.sent;
              middle = _ref.data.result.middle;
              _context.next = 12;
              break;

            case 9:
              _context.prev = 9;
              _context.t0 = _context["catch"](2);
              console.log(_context.t0);

            case 12:
              this.detailEditObj.name = middle.name;
              this.detailEditObj.name_eng = middle.name_eng;
              this.detailEditObj.description = middle.description;
              this.detailEditObj.youtube = middle.youtube;
              this.detailEditObj.youtube_time_hour = middle.y_hour;
              this.detailEditObj.youtube_time_minute = middle.y_minute;
              this.detailEditObj.youtube_time_second = middle.y_second;
              this.detailEditObj.link_txt = middle.image_txt;
              this.detailEditObj.link_url = middle.image_url;
              this.detailEditObj.is_major = middle.is_major;
              this.detailEditObj.is_like = middle.is_like;
              this.detailEditObj.is_powder = middle.is_powder;
              this.detailEditObj.uploadImageUrl = middle.image;
              this.selectedCategory = {
                value: middle.category || null,
                label: ""
              };
              this.selectedBrand = {
                value: middle.famous_brand_id || null,
                label: ""
              };

            case 27:
            case "end":
              return _context.stop();
          }
        }
      }, _callee, this, [[2, 9]]);
    }));

    function created() {
      return _created.apply(this, arguments);
    }

    return created;
  }(),
  computed: {
    sendObj: function sendObj() {
      var _this = this;

      var data = _objectSpread({
        id: this.middle_id ? this.middle_id : null,
        category: this.selectedCategory.value
      }, this.detailEditObj); //銘柄データを付与する


      if (this.selectedBrand && this.selectedBrand.value != null) {
        //銘柄が選択されている
        data.brand_id = this.selectedBrand.value;
      } else {
        //銘柄も同時に新規作成している
        Object.keys(this.newBrandObj).forEach(function (key) {
          data[key] = _this.newBrandObj[key];
        });
      }

      if (data.uploadImageUrl) {
        delete data.uploadImageUrl; //特に必要のないデータ
      }

      if (data.brand && data.brand.brand_uploadImageUrl) {
        delete data.brand.brand_uploadImageUrl; //特に必要のないデータ
      }

      return data;
    },
    //mixinに退避したらなんかおかしくなったから仕方なく。たぶん引数でsendObjを渡さないといけないんじゃないかな。
    formdata: function formdata() {
      var _this2 = this;

      var bodyFormData = new FormData();
      Object.keys(this.sendObj).forEach(function (key) {
        bodyFormData.append(key, _this2.sendObj[key]);
      });
      return bodyFormData;
    }
  },
  methods: {
    send: function () {
      var _send = _asyncToGenerator(
      /*#__PURE__*/
      _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default.a.mark(function _callee2() {
        var array, _ref2, is_kind5, result;

        return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default.a.wrap(function _callee2$(_context2) {
          while (1) {
            switch (_context2.prev = _context2.next) {
              case 0:
                //データを送信する
                //データのバリデーション
                array = [this.$refs.categorySelect.validateObj, this.$refs.middleForm.validateObj]; //もし「親カテゴリ」がその他だった場合は、この部分のバリデーションが不要になる

                _context2.next = 3;
                return axios.post("http://127.0.0.1:8000" + '/Cocktail/iskind5/check', {
                  id: this.selectedCategory.value
                });

              case 3:
                _ref2 = _context2.sent;
                is_kind5 = _ref2.data.result.is_kind5;

                if (!is_kind5 && this.$refs.famousBrand) {
                  array.push(this.$refs.famousBrand.validateObjAccess);
                } //「その他」カテゴリの場合でも、何かしら記入されてたらバリデーションを行う


                if (is_kind5 && (this.newBrandObj.brand_name || this.newBrandObj.brand_name_eng || this.newBrandObj.brand_description || this.newBrandObj.brand_strength)) {
                  array.push(this.$refs.famousBrand.validateObjAccess);
                }

                if (this.is_validation(array)) {
                  _context2.next = 9;
                  break;
                }

                return _context2.abrupt("return");

              case 9:
                _context2.prev = 9;
                _context2.next = 12;
                return axios.post("http://127.0.0.1:8000" + '/Cocktail/admin/submit/middle/', this.formdata, {
                  headers: {
                    'Content-Type': 'multipart/form-data'
                  }
                });

              case 12:
                result = _context2.sent;
                _context2.next = 18;
                break;

              case 15:
                _context2.prev = 15;
                _context2.t0 = _context2["catch"](9);
                console.log(_context2.t0);

              case 18:
                //特に更新終了を待つ必要はないので、さっさとトップ画面に戻ってしまう
                this.$router.push({
                  name: 'AdminHome'
                }); //結果表示画面に飛ばす

              case 19:
              case "end":
                return _context2.stop();
            }
          }
        }, _callee2, this, [[9, 15]]);
      }));

      function send() {
        return _send.apply(this, arguments);
      }

      return send;
    }()
  }
});

/***/ }),

/***/ "./node_modules/css-loader/dist/cjs.js!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/src/index.js?!./node_modules/sass-loader/dist/cjs.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/Admin/Super/Detail/MiddleEdit.vue?vue&type=style&index=0&id=a4f701ca&scoped=true&lang=scss&":
/*!****************************************************************************************************************************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/css-loader/dist/cjs.js!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/src??ref--7-2!./node_modules/sass-loader/dist/cjs.js??ref--7-3!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/Admin/Super/Detail/MiddleEdit.vue?vue&type=style&index=0&id=a4f701ca&scoped=true&lang=scss& ***!
  \****************************************************************************************************************************************************************************************************************************************************************************************************************************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

exports = module.exports = __webpack_require__(/*! ../../../../../node_modules/css-loader/dist/runtime/api.js */ "./node_modules/css-loader/dist/runtime/api.js")(false);
// Module
exports.push([module.i, "div#container[data-v-a4f701ca] {\n  max-width: 800px;\n  margin: auto;\n}", ""]);


/***/ }),

/***/ "./node_modules/style-loader/index.js!./node_modules/css-loader/dist/cjs.js!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/src/index.js?!./node_modules/sass-loader/dist/cjs.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/Admin/Super/Detail/MiddleEdit.vue?vue&type=style&index=0&id=a4f701ca&scoped=true&lang=scss&":
/*!********************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/style-loader!./node_modules/css-loader/dist/cjs.js!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/src??ref--7-2!./node_modules/sass-loader/dist/cjs.js??ref--7-3!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/Admin/Super/Detail/MiddleEdit.vue?vue&type=style&index=0&id=a4f701ca&scoped=true&lang=scss& ***!
  \********************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {


var content = __webpack_require__(/*! !../../../../../node_modules/css-loader/dist/cjs.js!../../../../../node_modules/vue-loader/lib/loaders/stylePostLoader.js!../../../../../node_modules/postcss-loader/src??ref--7-2!../../../../../node_modules/sass-loader/dist/cjs.js??ref--7-3!../../../../../node_modules/vue-loader/lib??vue-loader-options!./MiddleEdit.vue?vue&type=style&index=0&id=a4f701ca&scoped=true&lang=scss& */ "./node_modules/css-loader/dist/cjs.js!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/src/index.js?!./node_modules/sass-loader/dist/cjs.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/Admin/Super/Detail/MiddleEdit.vue?vue&type=style&index=0&id=a4f701ca&scoped=true&lang=scss&");

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

/***/ "./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/Admin/Super/BrandList.vue?vue&type=template&id=f99657fa&":
/*!*************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/Admin/Super/BrandList.vue?vue&type=template&id=f99657fa& ***!
  \*************************************************************************************************************************************************************************************************************/
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
      _c("list-component", {
        attrs: { items: this.brands, link_name: "AdminBrandEdit" }
      })
    ],
    1
  )
}
var staticRenderFns = []
render._withStripped = true



/***/ }),

/***/ "./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/Admin/Super/Detail/MiddleEdit.vue?vue&type=template&id=a4f701ca&scoped=true&":
/*!*********************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/Admin/Super/Detail/MiddleEdit.vue?vue&type=template&id=a4f701ca&scoped=true& ***!
  \*********************************************************************************************************************************************************************************************************************************/
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
          "selected-category": _vm.selectedCategory
        },
        on: {
          "update:selectedCategory": function($event) {
            _vm.selectedCategory = $event
          },
          "update:selected-category": function($event) {
            _vm.selectedCategory = $event
          }
        }
      }),
      _vm._v(" "),
      _c("br"),
      _vm._v(" "),
      _c(
        "NameAndDrescription",
        _vm._b(
          {
            ref: "middleForm",
            attrs: {
              "edit-mode": _vm.editMode,
              parent_id: _vm.selectedCategory
                ? _vm.selectedCategory.value
                : null
            }
          },
          "NameAndDrescription",
          _vm.detailEditObj,
          false,
          true
        )
      ),
      _vm._v(" "),
      _c("br"),
      _vm._v(" "),
      _vm.selectedCategory
        ? _c(
            "famous-brand",
            _vm._b(
              {
                ref: "famousBrand",
                attrs: {
                  "edit-mode": _vm.editMode,
                  category_id: _vm.selectedCategory.value,
                  middle_id: _vm.middle_id,
                  "selected-brand": _vm.selectedBrand
                },
                on: {
                  "update:selectedBrand": function($event) {
                    _vm.selectedBrand = $event
                  },
                  "update:selected-brand": function($event) {
                    _vm.selectedBrand = $event
                  }
                }
              },
              "famous-brand",
              _vm.newBrandObj,
              false,
              true
            )
          )
        : _c("v-alert", { attrs: { dense: "", outlined: "", type: "error" } }, [
            _vm._v("\n        先にメインカテゴリを選択して下さい\n    ")
          ]),
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
      ),
      _vm._v(" "),
      _c("br"),
      _vm._v(" "),
      _c("hr"),
      _vm._v(" "),
      _c("div", [_vm._v("登録されている銘柄の一覧")]),
      _vm._v(" "),
      _vm.middle_id
        ? _c("brand-list", { attrs: { middle_id: _vm.middle_id } })
        : _vm._e()
    ],
    1
  )
}
var staticRenderFns = []
render._withStripped = true



/***/ }),

/***/ "./resources/js/Admin/Super/BrandList.vue":
/*!************************************************!*\
  !*** ./resources/js/Admin/Super/BrandList.vue ***!
  \************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _BrandList_vue_vue_type_template_id_f99657fa___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./BrandList.vue?vue&type=template&id=f99657fa& */ "./resources/js/Admin/Super/BrandList.vue?vue&type=template&id=f99657fa&");
/* harmony import */ var _BrandList_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./BrandList.vue?vue&type=script&lang=js& */ "./resources/js/Admin/Super/BrandList.vue?vue&type=script&lang=js&");
/* empty/unused harmony star reexport *//* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");





/* normalize component */

var component = Object(_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__["default"])(
  _BrandList_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__["default"],
  _BrandList_vue_vue_type_template_id_f99657fa___WEBPACK_IMPORTED_MODULE_0__["render"],
  _BrandList_vue_vue_type_template_id_f99657fa___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"],
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/Admin/Super/BrandList.vue"
/* harmony default export */ __webpack_exports__["default"] = (component.exports);

/***/ }),

/***/ "./resources/js/Admin/Super/BrandList.vue?vue&type=script&lang=js&":
/*!*************************************************************************!*\
  !*** ./resources/js/Admin/Super/BrandList.vue?vue&type=script&lang=js& ***!
  \*************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_BrandList_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/babel-loader/lib??ref--4-0!../../../../node_modules/vue-loader/lib??vue-loader-options!./BrandList.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/Admin/Super/BrandList.vue?vue&type=script&lang=js&");
/* empty/unused harmony star reexport */ /* harmony default export */ __webpack_exports__["default"] = (_node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_BrandList_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__["default"]); 

/***/ }),

/***/ "./resources/js/Admin/Super/BrandList.vue?vue&type=template&id=f99657fa&":
/*!*******************************************************************************!*\
  !*** ./resources/js/Admin/Super/BrandList.vue?vue&type=template&id=f99657fa& ***!
  \*******************************************************************************/
/*! exports provided: render, staticRenderFns */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_BrandList_vue_vue_type_template_id_f99657fa___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../../../node_modules/vue-loader/lib??vue-loader-options!./BrandList.vue?vue&type=template&id=f99657fa& */ "./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/Admin/Super/BrandList.vue?vue&type=template&id=f99657fa&");
/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "render", function() { return _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_BrandList_vue_vue_type_template_id_f99657fa___WEBPACK_IMPORTED_MODULE_0__["render"]; });

/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "staticRenderFns", function() { return _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_BrandList_vue_vue_type_template_id_f99657fa___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"]; });



/***/ }),

/***/ "./resources/js/Admin/Super/Detail/MiddleEdit.vue":
/*!********************************************************!*\
  !*** ./resources/js/Admin/Super/Detail/MiddleEdit.vue ***!
  \********************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _MiddleEdit_vue_vue_type_template_id_a4f701ca_scoped_true___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./MiddleEdit.vue?vue&type=template&id=a4f701ca&scoped=true& */ "./resources/js/Admin/Super/Detail/MiddleEdit.vue?vue&type=template&id=a4f701ca&scoped=true&");
/* harmony import */ var _MiddleEdit_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./MiddleEdit.vue?vue&type=script&lang=js& */ "./resources/js/Admin/Super/Detail/MiddleEdit.vue?vue&type=script&lang=js&");
/* empty/unused harmony star reexport *//* harmony import */ var _MiddleEdit_vue_vue_type_style_index_0_id_a4f701ca_scoped_true_lang_scss___WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./MiddleEdit.vue?vue&type=style&index=0&id=a4f701ca&scoped=true&lang=scss& */ "./resources/js/Admin/Super/Detail/MiddleEdit.vue?vue&type=style&index=0&id=a4f701ca&scoped=true&lang=scss&");
/* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! ../../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");






/* normalize component */

var component = Object(_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_3__["default"])(
  _MiddleEdit_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__["default"],
  _MiddleEdit_vue_vue_type_template_id_a4f701ca_scoped_true___WEBPACK_IMPORTED_MODULE_0__["render"],
  _MiddleEdit_vue_vue_type_template_id_a4f701ca_scoped_true___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"],
  false,
  null,
  "a4f701ca",
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/Admin/Super/Detail/MiddleEdit.vue"
/* harmony default export */ __webpack_exports__["default"] = (component.exports);

/***/ }),

/***/ "./resources/js/Admin/Super/Detail/MiddleEdit.vue?vue&type=script&lang=js&":
/*!*********************************************************************************!*\
  !*** ./resources/js/Admin/Super/Detail/MiddleEdit.vue?vue&type=script&lang=js& ***!
  \*********************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_MiddleEdit_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../node_modules/babel-loader/lib??ref--4-0!../../../../../node_modules/vue-loader/lib??vue-loader-options!./MiddleEdit.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/Admin/Super/Detail/MiddleEdit.vue?vue&type=script&lang=js&");
/* empty/unused harmony star reexport */ /* harmony default export */ __webpack_exports__["default"] = (_node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_MiddleEdit_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__["default"]); 

/***/ }),

/***/ "./resources/js/Admin/Super/Detail/MiddleEdit.vue?vue&type=style&index=0&id=a4f701ca&scoped=true&lang=scss&":
/*!******************************************************************************************************************!*\
  !*** ./resources/js/Admin/Super/Detail/MiddleEdit.vue?vue&type=style&index=0&id=a4f701ca&scoped=true&lang=scss& ***!
  \******************************************************************************************************************/
/*! no static exports found */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_style_loader_index_js_node_modules_css_loader_dist_cjs_js_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_src_index_js_ref_7_2_node_modules_sass_loader_dist_cjs_js_ref_7_3_node_modules_vue_loader_lib_index_js_vue_loader_options_MiddleEdit_vue_vue_type_style_index_0_id_a4f701ca_scoped_true_lang_scss___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../node_modules/style-loader!../../../../../node_modules/css-loader/dist/cjs.js!../../../../../node_modules/vue-loader/lib/loaders/stylePostLoader.js!../../../../../node_modules/postcss-loader/src??ref--7-2!../../../../../node_modules/sass-loader/dist/cjs.js??ref--7-3!../../../../../node_modules/vue-loader/lib??vue-loader-options!./MiddleEdit.vue?vue&type=style&index=0&id=a4f701ca&scoped=true&lang=scss& */ "./node_modules/style-loader/index.js!./node_modules/css-loader/dist/cjs.js!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/src/index.js?!./node_modules/sass-loader/dist/cjs.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/Admin/Super/Detail/MiddleEdit.vue?vue&type=style&index=0&id=a4f701ca&scoped=true&lang=scss&");
/* harmony import */ var _node_modules_style_loader_index_js_node_modules_css_loader_dist_cjs_js_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_src_index_js_ref_7_2_node_modules_sass_loader_dist_cjs_js_ref_7_3_node_modules_vue_loader_lib_index_js_vue_loader_options_MiddleEdit_vue_vue_type_style_index_0_id_a4f701ca_scoped_true_lang_scss___WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_node_modules_style_loader_index_js_node_modules_css_loader_dist_cjs_js_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_src_index_js_ref_7_2_node_modules_sass_loader_dist_cjs_js_ref_7_3_node_modules_vue_loader_lib_index_js_vue_loader_options_MiddleEdit_vue_vue_type_style_index_0_id_a4f701ca_scoped_true_lang_scss___WEBPACK_IMPORTED_MODULE_0__);
/* harmony reexport (unknown) */ for(var __WEBPACK_IMPORT_KEY__ in _node_modules_style_loader_index_js_node_modules_css_loader_dist_cjs_js_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_src_index_js_ref_7_2_node_modules_sass_loader_dist_cjs_js_ref_7_3_node_modules_vue_loader_lib_index_js_vue_loader_options_MiddleEdit_vue_vue_type_style_index_0_id_a4f701ca_scoped_true_lang_scss___WEBPACK_IMPORTED_MODULE_0__) if(__WEBPACK_IMPORT_KEY__ !== 'default') (function(key) { __webpack_require__.d(__webpack_exports__, key, function() { return _node_modules_style_loader_index_js_node_modules_css_loader_dist_cjs_js_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_src_index_js_ref_7_2_node_modules_sass_loader_dist_cjs_js_ref_7_3_node_modules_vue_loader_lib_index_js_vue_loader_options_MiddleEdit_vue_vue_type_style_index_0_id_a4f701ca_scoped_true_lang_scss___WEBPACK_IMPORTED_MODULE_0__[key]; }) }(__WEBPACK_IMPORT_KEY__));
 /* harmony default export */ __webpack_exports__["default"] = (_node_modules_style_loader_index_js_node_modules_css_loader_dist_cjs_js_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_src_index_js_ref_7_2_node_modules_sass_loader_dist_cjs_js_ref_7_3_node_modules_vue_loader_lib_index_js_vue_loader_options_MiddleEdit_vue_vue_type_style_index_0_id_a4f701ca_scoped_true_lang_scss___WEBPACK_IMPORTED_MODULE_0___default.a); 

/***/ }),

/***/ "./resources/js/Admin/Super/Detail/MiddleEdit.vue?vue&type=template&id=a4f701ca&scoped=true&":
/*!***************************************************************************************************!*\
  !*** ./resources/js/Admin/Super/Detail/MiddleEdit.vue?vue&type=template&id=a4f701ca&scoped=true& ***!
  \***************************************************************************************************/
/*! exports provided: render, staticRenderFns */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_MiddleEdit_vue_vue_type_template_id_a4f701ca_scoped_true___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../../../../node_modules/vue-loader/lib??vue-loader-options!./MiddleEdit.vue?vue&type=template&id=a4f701ca&scoped=true& */ "./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/Admin/Super/Detail/MiddleEdit.vue?vue&type=template&id=a4f701ca&scoped=true&");
/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "render", function() { return _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_MiddleEdit_vue_vue_type_template_id_a4f701ca_scoped_true___WEBPACK_IMPORTED_MODULE_0__["render"]; });

/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "staticRenderFns", function() { return _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_MiddleEdit_vue_vue_type_template_id_a4f701ca_scoped_true___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"]; });



/***/ }),

/***/ "./resources/js/Admin/Super/Detail/component/newBrandObjDatat.js":
/*!***********************************************************************!*\
  !*** ./resources/js/Admin/Super/Detail/component/newBrandObjDatat.js ***!
  \***********************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony default export */ __webpack_exports__["default"] = ({
  data: function data() {
    return {
      newBrandObj: {
        brand_name: "",
        brand_name_eng: "",
        brand_strength: "",
        brand_description: "",
        brand_youtube: "",
        brand_youtube_time_hour: null,
        brand_youtube_time_minute: null,
        brand_youtube_time_second: null,
        brand_link_txt: "",
        brand_link_url: "",
        brand_is_major: false,
        brand_is_like: false,
        brand_input_image: null,
        brand_uploadImageUrl: null
      }
    };
  }
});

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