(window["webpackJsonp"] = window["webpackJsonp"] || []).push([[6],{

/***/ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/Admin/Super/Detail/component/FamousBrandSelect.vue?vue&type=script&lang=js&":
/*!**********************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib??ref--4-0!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/Admin/Super/Detail/component/FamousBrandSelect.vue?vue&type=script&lang=js& ***!
  \**********************************************************************************************************************************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @babel/runtime/regenerator */ "./node_modules/@babel/runtime/regenerator/index.js");
/* harmony import */ var _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var _Modules_helper__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ../../../../Modules/helper */ "./resources/js/Modules/helper.js");
/* harmony import */ var _NamesAndDescription__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./NamesAndDescription */ "./resources/js/Admin/Super/Detail/component/NamesAndDescription.vue");
/* harmony import */ var _NewBrandProp__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! ./NewBrandProp */ "./resources/js/Admin/Super/Detail/component/NewBrandProp.js");


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
//
//
//
//
//
//
//
//
//
//
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
  components: {
    NamesAndDescription: _NamesAndDescription__WEBPACK_IMPORTED_MODULE_2__["default"]
  },
  mixins: [_NewBrandProp__WEBPACK_IMPORTED_MODULE_3__["default"]],
  //ここにオブジェクト、setter,getterを詰め込んでいる
  props: {
    editMode: String,
    category_id: Number,
    middle_id: Number,
    selectedBrand: null //初期値をここにぶっこむとdataに反映される(はず)
    //initialCategory:null,
    //initialMiddle:null,

  },
  data: function data() {
    return {
      //first:null,
      brands: null
    };
  },
  created: function created() {
    var _this = this;

    return _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default.a.mark(function _callee() {
      var _yield$axios$post, list;

      return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default.a.wrap(function _callee$(_context) {
        while (1) {
          switch (_context.prev = _context.next) {
            case 0:
              _context.next = 2;
              return axios.post("http://127.0.0.1:8000" + '/api/getBrandListWithCategory');

            case 2:
              _yield$axios$post = _context.sent;
              list = _yield$axios$post.data.result.Brands;
              _this.brands = list;

            case 5:
            case "end":
              return _context.stop();
          }
        }
      }, _callee);
    }))();
  },
  computed: {
    selectedBrandValue: {
      get: function get() {
        return this.selectedBrand;
      },
      set: function set(value) {
        this.$emit('update:selectedBrand', value);
      }
    },

    /*
                select_category:function(){
                    return Helper.aiu(Helper.narrow(this.categories,this.first),"name",true);
                },
    
                select_category_label:function() {
                    if(this.select_category === undefined || 0 === Object.keys(this.select_category).length){return}
    
                    return this.select_category.map(v => ({
                        label: v.name + "(" + v.name_eng + ")",
                        value: v.id,
                    }))
                },*/
    select_brand: function select_brand() {
      var _this2 = this;

      //選択可能なラベルとvalue値の組み合わせを絞り込む
      if (!this.brands) {
        return {};
      }

      var brandsList;

      if (this.editMode == "Middle") {
        brandsList = this.brands.filter(function (element) {
          if (_this2.middle_id) {
            //ミドルカテゴリの有名な銘柄選択時。もしミドルカテゴリが存在していたら、そこで絞り込む。
            //「メインカテゴリが同じ」で、かつ「同じミドルカテゴリIDが割り当てられているか、またはまだどこにも属していなければ」OK
            return _this2.category_id == element.category_id && (element.middle_id == _this2.middle_id || element.middle_id == null);
          } else {
            //ミドルカテゴリの有名な銘柄選択で、ミドルIDがない＝新規作成の場合
            //メインカテゴリが同一で、かつすでに他のミドルカテゴリに属していない銘柄を表示する
            return element.middle_id == null && element.category_id == _this2.category_id;
          }
        });
      } else if (this.editMode == "Category") {
        if (this.category_id) {
          //メインカテゴリの有名な銘柄選択時。メインカテゴリが同一であればなんでもいい。
          brandsList = this.brands.filter(function (element) {
            return element.category_id == _this2.category_id;
          });
        } else {//メインカテゴリの新規作成時。
          //これは銘柄は新規作成せざるを得ない。スルー。
        }
      }

      if (!brandsList) {
        //空だったらそれで終わりでいい
        return {};
      }

      brandsList.push({
        id: null,
        name: "",
        name_eng: "新しく作成する"
      });
      return _Modules_helper__WEBPACK_IMPORTED_MODULE_1__["default"].aiu(brandsList, "name", true);
    },
    select_brand_label: function select_brand_label() {
      //select_brand(ラベルとvalueを格納した配列)からラベルとvalueのセットを作成する
      if (!this.select_brand || 0 === Object.keys(this.select_brand).length) {
        return null;
      }

      return this.select_brand.map(function (v) {
        return {
          label: v.name + "(" + v.name_eng + ")",
          value: v.id
        };
      });
    },
    validateObj: function validateObj() {
      var data = {
        selectedBrand: this.selectedBrand
      };
      var rules = {
        selectedBrand: 'required'
      };
      var v = new Validator(data, rules);
      v.fails(); //ここでバリデーションを実行しオブジェクトの状態を更新しているみたい

      return v;
    },
    validateObjAccess: function validateObjAccess() {
      //親のバリデーションオブジェクト参照先。つまり状況に応じて返すオブジェクトを変える。
      if (this.selectedBrand === null || this.selectedBrand.value == null) {
        //ブランドを新規登録する場合(フォームが表示されている場合)
        return this.$refs.newBrand.validateObj;
      } else {
        //ブランド指定が存在する場合
        return this.validateObj;
      }
    }
  },
  methods: {
    /* delete_first(is_keep){
         //inputを消す。[is_keep(bool)] : 現在の状態をキープするか
         this.first=null;
         if (!is_keep){
             change_input()
         }
     },*/

    /*
    keypush(){
        if(this.first==null){
            //文字を空にしたんなら
            console.log("delete_change_input")
            this.change_input()
        }else{
            //なにか文字を打ち込んだ
            console.log("hit_change_input")
            this.change_input()
        }
    },
     change_input(){
         //inputを変えたら全部消す
             this.selectedCategoryValue=null;
             this.selectedMiddleValue=null
     },
     */

    /*change_middle(){
    },*/

    /*
    clearMiddle:function(){
        //親カテゴリが手によって(@Select)変えられたら、ミドルカテゴリは消してしまう
        this.selectedMiddleValue=null
        //this.$emit('selectedMiddle',null);//なんかwatch効かないんだけど...
    }*/
    emitDetail: function emitDetail() {}
  }
});

/***/ }),

/***/ "./node_modules/css-loader/dist/cjs.js!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/src/index.js?!./node_modules/sass-loader/dist/cjs.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/Admin/Super/Detail/component/FamousBrandSelect.vue?vue&type=style&index=0&id=f17193ac&scoped=true&lang=scss&":
/*!*********************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/css-loader/dist/cjs.js!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/src??ref--7-2!./node_modules/sass-loader/dist/cjs.js??ref--7-3!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/Admin/Super/Detail/component/FamousBrandSelect.vue?vue&type=style&index=0&id=f17193ac&scoped=true&lang=scss& ***!
  \*********************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

// Imports
var ___CSS_LOADER_API_IMPORT___ = __webpack_require__(/*! ../../../../../../node_modules/css-loader/dist/runtime/api.js */ "./node_modules/css-loader/dist/runtime/api.js");
exports = ___CSS_LOADER_API_IMPORT___(false);
// Module
exports.push([module.i, "input.first[data-v-f17193ac] {\n  max-width: 2em;\n  border: 1px solid #222;\n}\nselect.category[data-v-f17193ac] {\n  border: 1px solid #222;\n}", ""]);
// Exports
module.exports = exports;


/***/ }),

/***/ "./node_modules/style-loader/index.js!./node_modules/css-loader/dist/cjs.js!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/src/index.js?!./node_modules/sass-loader/dist/cjs.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/Admin/Super/Detail/component/FamousBrandSelect.vue?vue&type=style&index=0&id=f17193ac&scoped=true&lang=scss&":
/*!*************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/style-loader!./node_modules/css-loader/dist/cjs.js!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/src??ref--7-2!./node_modules/sass-loader/dist/cjs.js??ref--7-3!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/Admin/Super/Detail/component/FamousBrandSelect.vue?vue&type=style&index=0&id=f17193ac&scoped=true&lang=scss& ***!
  \*************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {


var content = __webpack_require__(/*! !../../../../../../node_modules/css-loader/dist/cjs.js!../../../../../../node_modules/vue-loader/lib/loaders/stylePostLoader.js!../../../../../../node_modules/postcss-loader/src??ref--7-2!../../../../../../node_modules/sass-loader/dist/cjs.js??ref--7-3!../../../../../../node_modules/vue-loader/lib??vue-loader-options!./FamousBrandSelect.vue?vue&type=style&index=0&id=f17193ac&scoped=true&lang=scss& */ "./node_modules/css-loader/dist/cjs.js!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/src/index.js?!./node_modules/sass-loader/dist/cjs.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/Admin/Super/Detail/component/FamousBrandSelect.vue?vue&type=style&index=0&id=f17193ac&scoped=true&lang=scss&");

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

/***/ "./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/Admin/Super/Detail/component/FamousBrandSelect.vue?vue&type=template&id=f17193ac&scoped=true&":
/*!**************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/Admin/Super/Detail/component/FamousBrandSelect.vue?vue&type=template&id=f17193ac&scoped=true& ***!
  \**************************************************************************************************************************************************************************************************************************************************/
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
    { staticClass: "pt-3", staticStyle: { "border-top": "double 3px #399" } },
    [
      _c("div", { staticClass: "flexdiv" }, [
        _vm.select_brand_label != null
          ? _c(
              "div",
              { staticStyle: { flex: "1" } },
              [
                _c("v-select", {
                  attrs: {
                    items: _vm.select_brand_label,
                    label: "有名な銘柄",
                    "item-text": "label",
                    "item-value": "value",
                    dense: "",
                    "return-object": ""
                  },
                  on: { change: _vm.emitDetail },
                  model: {
                    value: _vm.selectedBrandValue,
                    callback: function($$v) {
                      _vm.selectedBrandValue = $$v
                    },
                    expression: "selectedBrandValue"
                  }
                })
              ],
              1
            )
          : _c("div", { staticClass: "pt-2" }, [
              _vm._v("\n            -有名な銘柄を入力して下さい-\n        ")
            ])
      ]),
      _vm._v(" "),
      !_vm.selectedBrand || _vm.selectedBrand.value == null
        ? _c("NamesAndDescription", {
            ref: "newBrand",
            attrs: {
              "edit-mode": "Brand",
              parent_id: _vm.category_id,
              name: _vm.brand_name,
              name_eng: _vm.brand_name_eng,
              strength: _vm.brand_strength,
              description: _vm.brand_description,
              youtube: _vm.brand_youtube,
              youtube_time_hour: _vm.brand_youtube_time_hour,
              youtube_time_minute: _vm.brand_youtube_time_minute,
              youtube_time_second: _vm.brand_youtube_time_second,
              link_txt: _vm.brand_link_txt,
              link_url: _vm.brand_link_url,
              is_major: _vm.brand_is_major,
              is_like: _vm.brand_is_like,
              input_image: _vm.brand_input_image,
              uploadImageUrl: _vm.brand_uploadImageUrl
            },
            on: {
              "update:name": function($event) {
                return _vm.$emit("update:brand_name", $event)
              },
              "update:name_eng": function($event) {
                return _vm.$emit("update:brand_name_eng", $event)
              },
              "update:strength": function($event) {
                return _vm.$emit("update:brand_strength", $event)
              },
              "update:description": function($event) {
                return _vm.$emit("update:brand_description", $event)
              },
              "update:youtube": function($event) {
                return _vm.$emit("update:brand_youtube", $event)
              },
              "update:youtube_time_hour": function($event) {
                return _vm.$emit("update:brand_youtube_time_hour", $event)
              },
              "update:youtube_time_minute": function($event) {
                return _vm.$emit("update:brand_youtube_time_minute", $event)
              },
              "update:youtube_time_second": function($event) {
                return _vm.$emit("update:brand_youtube_time_second", $event)
              },
              "update:link_txt": function($event) {
                return _vm.$emit("update:brand_link_txt", $event)
              },
              "update:link_url": function($event) {
                return _vm.$emit("update:brand_link_url", $event)
              },
              "update:is_major": function($event) {
                return _vm.$emit("update:brand_is_major", $event)
              },
              "update:is_like": function($event) {
                return _vm.$emit("update:brand_is_like", $event)
              },
              "update:input_image": function($event) {
                return _vm.$emit("update:brand_input_image", $event)
              },
              "update:uploadImageUrl": function($event) {
                return _vm.$emit("update:brand_uploadImageUrl", $event)
              }
            }
          })
        : _vm._e()
    ],
    1
  )
}
var staticRenderFns = []
render._withStripped = true



/***/ }),

/***/ "./resources/js/Admin/Super/Detail/component/FamousBrandSelect.vue":
/*!*************************************************************************!*\
  !*** ./resources/js/Admin/Super/Detail/component/FamousBrandSelect.vue ***!
  \*************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _FamousBrandSelect_vue_vue_type_template_id_f17193ac_scoped_true___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./FamousBrandSelect.vue?vue&type=template&id=f17193ac&scoped=true& */ "./resources/js/Admin/Super/Detail/component/FamousBrandSelect.vue?vue&type=template&id=f17193ac&scoped=true&");
/* harmony import */ var _FamousBrandSelect_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./FamousBrandSelect.vue?vue&type=script&lang=js& */ "./resources/js/Admin/Super/Detail/component/FamousBrandSelect.vue?vue&type=script&lang=js&");
/* empty/unused harmony star reexport *//* harmony import */ var _FamousBrandSelect_vue_vue_type_style_index_0_id_f17193ac_scoped_true_lang_scss___WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./FamousBrandSelect.vue?vue&type=style&index=0&id=f17193ac&scoped=true&lang=scss& */ "./resources/js/Admin/Super/Detail/component/FamousBrandSelect.vue?vue&type=style&index=0&id=f17193ac&scoped=true&lang=scss&");
/* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! ../../../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");






/* normalize component */

var component = Object(_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_3__["default"])(
  _FamousBrandSelect_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__["default"],
  _FamousBrandSelect_vue_vue_type_template_id_f17193ac_scoped_true___WEBPACK_IMPORTED_MODULE_0__["render"],
  _FamousBrandSelect_vue_vue_type_template_id_f17193ac_scoped_true___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"],
  false,
  null,
  "f17193ac",
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/Admin/Super/Detail/component/FamousBrandSelect.vue"
/* harmony default export */ __webpack_exports__["default"] = (component.exports);

/***/ }),

/***/ "./resources/js/Admin/Super/Detail/component/FamousBrandSelect.vue?vue&type=script&lang=js&":
/*!**************************************************************************************************!*\
  !*** ./resources/js/Admin/Super/Detail/component/FamousBrandSelect.vue?vue&type=script&lang=js& ***!
  \**************************************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_FamousBrandSelect_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../../node_modules/babel-loader/lib??ref--4-0!../../../../../../node_modules/vue-loader/lib??vue-loader-options!./FamousBrandSelect.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/Admin/Super/Detail/component/FamousBrandSelect.vue?vue&type=script&lang=js&");
/* empty/unused harmony star reexport */ /* harmony default export */ __webpack_exports__["default"] = (_node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_FamousBrandSelect_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__["default"]); 

/***/ }),

/***/ "./resources/js/Admin/Super/Detail/component/FamousBrandSelect.vue?vue&type=style&index=0&id=f17193ac&scoped=true&lang=scss&":
/*!***********************************************************************************************************************************!*\
  !*** ./resources/js/Admin/Super/Detail/component/FamousBrandSelect.vue?vue&type=style&index=0&id=f17193ac&scoped=true&lang=scss& ***!
  \***********************************************************************************************************************************/
/*! no static exports found */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_style_loader_index_js_node_modules_css_loader_dist_cjs_js_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_src_index_js_ref_7_2_node_modules_sass_loader_dist_cjs_js_ref_7_3_node_modules_vue_loader_lib_index_js_vue_loader_options_FamousBrandSelect_vue_vue_type_style_index_0_id_f17193ac_scoped_true_lang_scss___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../../node_modules/style-loader!../../../../../../node_modules/css-loader/dist/cjs.js!../../../../../../node_modules/vue-loader/lib/loaders/stylePostLoader.js!../../../../../../node_modules/postcss-loader/src??ref--7-2!../../../../../../node_modules/sass-loader/dist/cjs.js??ref--7-3!../../../../../../node_modules/vue-loader/lib??vue-loader-options!./FamousBrandSelect.vue?vue&type=style&index=0&id=f17193ac&scoped=true&lang=scss& */ "./node_modules/style-loader/index.js!./node_modules/css-loader/dist/cjs.js!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/src/index.js?!./node_modules/sass-loader/dist/cjs.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/Admin/Super/Detail/component/FamousBrandSelect.vue?vue&type=style&index=0&id=f17193ac&scoped=true&lang=scss&");
/* harmony import */ var _node_modules_style_loader_index_js_node_modules_css_loader_dist_cjs_js_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_src_index_js_ref_7_2_node_modules_sass_loader_dist_cjs_js_ref_7_3_node_modules_vue_loader_lib_index_js_vue_loader_options_FamousBrandSelect_vue_vue_type_style_index_0_id_f17193ac_scoped_true_lang_scss___WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_node_modules_style_loader_index_js_node_modules_css_loader_dist_cjs_js_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_src_index_js_ref_7_2_node_modules_sass_loader_dist_cjs_js_ref_7_3_node_modules_vue_loader_lib_index_js_vue_loader_options_FamousBrandSelect_vue_vue_type_style_index_0_id_f17193ac_scoped_true_lang_scss___WEBPACK_IMPORTED_MODULE_0__);
/* harmony reexport (unknown) */ for(var __WEBPACK_IMPORT_KEY__ in _node_modules_style_loader_index_js_node_modules_css_loader_dist_cjs_js_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_src_index_js_ref_7_2_node_modules_sass_loader_dist_cjs_js_ref_7_3_node_modules_vue_loader_lib_index_js_vue_loader_options_FamousBrandSelect_vue_vue_type_style_index_0_id_f17193ac_scoped_true_lang_scss___WEBPACK_IMPORTED_MODULE_0__) if(["default"].indexOf(__WEBPACK_IMPORT_KEY__) < 0) (function(key) { __webpack_require__.d(__webpack_exports__, key, function() { return _node_modules_style_loader_index_js_node_modules_css_loader_dist_cjs_js_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_src_index_js_ref_7_2_node_modules_sass_loader_dist_cjs_js_ref_7_3_node_modules_vue_loader_lib_index_js_vue_loader_options_FamousBrandSelect_vue_vue_type_style_index_0_id_f17193ac_scoped_true_lang_scss___WEBPACK_IMPORTED_MODULE_0__[key]; }) }(__WEBPACK_IMPORT_KEY__));
 /* harmony default export */ __webpack_exports__["default"] = (_node_modules_style_loader_index_js_node_modules_css_loader_dist_cjs_js_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_src_index_js_ref_7_2_node_modules_sass_loader_dist_cjs_js_ref_7_3_node_modules_vue_loader_lib_index_js_vue_loader_options_FamousBrandSelect_vue_vue_type_style_index_0_id_f17193ac_scoped_true_lang_scss___WEBPACK_IMPORTED_MODULE_0___default.a); 

/***/ }),

/***/ "./resources/js/Admin/Super/Detail/component/FamousBrandSelect.vue?vue&type=template&id=f17193ac&scoped=true&":
/*!********************************************************************************************************************!*\
  !*** ./resources/js/Admin/Super/Detail/component/FamousBrandSelect.vue?vue&type=template&id=f17193ac&scoped=true& ***!
  \********************************************************************************************************************/
/*! exports provided: render, staticRenderFns */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_FamousBrandSelect_vue_vue_type_template_id_f17193ac_scoped_true___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../../../../../node_modules/vue-loader/lib??vue-loader-options!./FamousBrandSelect.vue?vue&type=template&id=f17193ac&scoped=true& */ "./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/Admin/Super/Detail/component/FamousBrandSelect.vue?vue&type=template&id=f17193ac&scoped=true&");
/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "render", function() { return _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_FamousBrandSelect_vue_vue_type_template_id_f17193ac_scoped_true___WEBPACK_IMPORTED_MODULE_0__["render"]; });

/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "staticRenderFns", function() { return _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_FamousBrandSelect_vue_vue_type_template_id_f17193ac_scoped_true___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"]; });



/***/ }),

/***/ "./resources/js/Admin/Super/Detail/component/NewBrandProp.js":
/*!*******************************************************************!*\
  !*** ./resources/js/Admin/Super/Detail/component/NewBrandProp.js ***!
  \*******************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony default export */ __webpack_exports__["default"] = ({
  props: {
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
});

/***/ })

}]);