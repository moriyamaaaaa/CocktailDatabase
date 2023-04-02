<template>
    <div id="container">
        <category-secelt v-bind:edit-mode="editMode"
                         v-bind:selected-category.sync="selectedCategory"
                         v-bind:selected-middle.sync="selectedMiddle"

                         ref="categorySelect"
        ></category-secelt>
        <br>
        <NameAndDrescription
            v-bind:edit-mode="editMode"
            v-bind.sync="detailEditObj"

            ref="form"
        ></NameAndDrescription>
        <br>
        <v-btn large  color="blue darken-3" dark @click="send">送信</v-btn>
    </div>
</template>

<script>
    import CategorySecelt from "./component/CategorySelect"
    import NameAndDrescription from "./component/NamesAndDescription"
    import validationComponent from "./component/validationComponent"


    const Validator = require('validatorjs');
    Validator.useLang('ja');

    export default {
        mixins:[validationComponent],
        components: {
            CategorySecelt,NameAndDrescription
        },
        props:{
            brand_id:Number
        },
        data() {
            return {
                editMode:"Brand",
                selectedCategory:null,
                selectedMiddle:null,

                //initialCategoryId:null,
                //initialMiddleId:null,

                detailEditObj:{
                    name:"",
                    name_eng:"",
                    strength:null,
                    description:"",
                    youtube:"",
                    youtube_time_hour:null,
                    youtube_time_minute:null,
                    youtube_time_second:null,
                    link_txt:"",
                    link_url:"",
                    is_major:false,
                    is_like:false,
                    input_image:null,
                    uploadImageUrl:null,
                },

            }
        },
        async created(){
            if(!this.brand_id){return}
            //IDがくっついているのでデータ取得
            try{
                var {data:{result:{brand:brand}}} = await axios.post(process.env.MIX_SENTRY_DSN_PUBLIC+'/Cocktail/admin/get/brand',{
                    id:this.brand_id
                })
            }catch(e){
                console.log(e)
            }

            console.log(brand)

            this.detailEditObj.name=brand.name
            this.detailEditObj.name_eng=brand.name_eng
            this.detailEditObj.strength=brand.strength
            this.detailEditObj.description=brand.description
            this.detailEditObj.youtube=brand.youtube
            this.detailEditObj.youtube_time_hour=brand.y_hour
            this.detailEditObj.youtube_time_minute=brand.y_minute
            this.detailEditObj.youtube_time_second=brand.y_second
            this.detailEditObj.link_txt=brand.image_txt
            this.detailEditObj.link_url=brand.image_url
            this.detailEditObj.is_major=brand.is_major
            this.detailEditObj.is_like=brand.is_like
            this.detailEditObj.uploadImageUrl=brand.image

            this.selectedCategory={value:brand.category,label:""}
            this.selectedMiddle={value:brand.middle_category,label:""}

        },
        computed:{
            sendObj:function(){
                //PHP側に渡すオブジェクトを整形する
                var data={
                    id:(this.brand_id)?this.brand_id:null,
                    category:this.selectedCategory.value,
                    middle:(this.selectedMiddle)?this.selectedMiddle.value:null,
                    ...this.detailEditObj
                }
                if(data.uploadImageUrl) {
                    delete data.uploadImageUrl;//特に必要のないデータ
                }
                return data
            },

            formdata:function(){
                //sendObjをFormData型に変換する
                var bodyFormData = new FormData();
                Object.keys(this.sendObj).forEach( key=> {
                    bodyFormData.append(key, this.sendObj[key])
                })
                return bodyFormData
            }
        },
        methods:{
            async send(){
                //データを送信する
                //データのバリデーション
               if(!this.is_validation([
                   this.$refs.form.validateObj,
                   this.$refs.categorySelect.validateObj
               ])){
                   return
               }

                //とりあえずデータは埋まっている
                try{
                    //console.log(...this.formdata.entries())
                    var result = await axios.post(process.env.MIX_SENTRY_DSN_PUBLIC+'/admin/submit/brand',this.formdata, {headers: {'Content-Type': 'multipart/form-data'} })
                }catch(error){
                    alert(error.response.data.message);
                    return;
                }

                //特に更新終了を待つ必要はないので、さっさとトップ画面に戻ってしまう
                this.$router.push({name: 'AdminHome'});//結果表示画面に飛ばす
            }
        }
    }
</script>

<style scoped lang="scss">
    div#container{
        max-width:800px;
        margin:auto;
    }
</style>
