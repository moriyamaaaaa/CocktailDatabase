<template>
    <div id="container">
        <category-secelt v-bind:edit-mode="editMode"
                         v-bind:selected-category.sync="selectedCategory"

                         ref="categorySelect"
        ></category-secelt>
        <br>
        <NameAndDrescription
            v-bind:edit-mode="editMode"
            v-bind.sync="detailEditObj"
            v-bind:parent_id="(selectedCategory)?selectedCategory.value:null"

            ref="middleForm"

        ></NameAndDrescription>
        <br>
        <famous-brand
            v-if="selectedCategory"
            v-bind:edit-mode="editMode"
            v-bind:category_id="selectedCategory.value"
            v-bind:middle_id="middle_id"
            v-bind:selected-brand.sync="selectedBrand"

            v-bind.sync="newBrandObj"

            ref="famousBrand"
        />
        <v-alert
            v-else
            dense
            outlined
            type="error"
        >
            先にメインカテゴリを選択して下さい
        </v-alert>
        <br>
        <v-btn large  color="blue darken-3" dark @click="send">送信</v-btn>
        <br>
        <hr>
        <div>登録されている銘柄の一覧</div>
        <brand-list
            v-if="middle_id"
        v-bind:middle_id="middle_id"/>
    </div>
</template>

<script>
    import CategorySecelt from "./component/CategorySelect"
    import NameAndDrescription from "./component/NamesAndDescription"
    import FamousBrand from "./component/FamousBrandSelect"
    import validationComponent from "./component/validationComponent"
    import newBrandObj from "./component/newBrandObjDatat"
    import BrandList from "./../BrandList"

    export default {
        mixins:[validationComponent,newBrandObj],
        components: {
            CategorySecelt,NameAndDrescription,FamousBrand,BrandList
        },
        props:{
            middle_id:Number
        },
        data() {
            return {
                editMode:"Middle",
                selectedCategory:null,
                selectedBrand:null,

                //initialCategoryId:null,
                //initialMiddleId:null,

                detailEditObj:{
                    name:"",
                    name_eng:"",
                    description:"",
                    youtube:"",
                    youtube_time_hour:null,
                    youtube_time_minute:null,
                    youtube_time_second:null,
                    link_txt:"",
                    link_url:"",
                    is_major:false,
                    is_like:false,
                    is_powder:false,
                    input_image:null,
                    uploadImageUrl:null,
                },

            }
        },
        async created(){
            if(!this.middle_id){return}
            //IDがくっついているのでデータ取得
            try{
                var {data:{result:{middle:middle}}} = await axios.post(process.env.MIX_SENTRY_DSN_PUBLIC+'/Cocktail/admin/get/middle',{
                    id:this.middle_id
                })
            }catch(e){
                console.log(e)
            }

            this.detailEditObj.name=middle.name
            this.detailEditObj.name_eng=middle.name_eng
            this.detailEditObj.description=middle.description
            this.detailEditObj.youtube=middle.youtube
            this.detailEditObj.youtube_time_hour=middle.y_hour
            this.detailEditObj.youtube_time_minute=middle.y_minute
            this.detailEditObj.youtube_time_second=middle.y_second
            this.detailEditObj.link_txt=middle.image_txt
            this.detailEditObj.link_url=middle.image_url
            this.detailEditObj.is_major=middle.is_major
            this.detailEditObj.is_like=middle.is_like
            this.detailEditObj.is_powder=middle.is_powder
            this.detailEditObj.uploadImageUrl=middle.image

            this.selectedCategory={value:middle.category||null,label:""}
            this.selectedBrand={value:middle.famous_brand_id||null,label:""}

        },
        computed:{
            sendObj:function(){
                var data={
                    id:(this.middle_id)?this.middle_id:null,
                    category:this.selectedCategory.value,
                    ...this.detailEditObj
                }

                //銘柄データを付与する
                if(this.selectedBrand && this.selectedBrand.value!=null){
                    //銘柄が選択されている
                    data.brand_id=this.selectedBrand.value
                }else{
                    //銘柄も同時に新規作成している
                    Object.keys(this.newBrandObj).forEach(
                        key =>{
                            data[key]=this.newBrandObj[key]}
                    )
                }

                if(data.uploadImageUrl) {
                    delete data.uploadImageUrl;//特に必要のないデータ
                }
                if(data.brand && data.brand.brand_uploadImageUrl) {
                    delete data.brand.brand_uploadImageUrl;//特に必要のないデータ
                }
                return data
            },

            //mixinに退避したらなんかおかしくなったから仕方なく。たぶん引数でsendObjを渡さないといけないんじゃないかな。
            formdata:function(){
                var bodyFormData = new FormData();
                Object.keys(this.sendObj).forEach( key=> {
                    bodyFormData.append(key, this.sendObj[key])
                })
                return bodyFormData
            },
        },
        methods:{
            async send(){
                //データを送信する
                //データのバリデーション
                var array=[
                    this.$refs.categorySelect.validateObj,
                    this.$refs.middleForm.validateObj,
                ]
                //もし「親カテゴリ」がその他だった場合は、この部分のバリデーションが不要になる
                var {data:{result:{is_kind5:is_kind5}}} = await axios.post(process.env.MIX_SENTRY_DSN_PUBLIC+'/Cocktail/iskind5/check',{id:this.selectedCategory.value})
                if(!is_kind5 && this.$refs.famousBrand){
                    array.push(this.$refs.famousBrand.validateObjAccess)
                }
                //「その他」カテゴリの場合でも、何かしら記入されてたらバリデーションを行う
                if(is_kind5 &&(
                    this.newBrandObj.brand_name
                    || this.newBrandObj.brand_name_eng
                    || this.newBrandObj.brand_description
                    || this.newBrandObj.brand_strength
                )){
                    array.push(this.$refs.famousBrand.validateObjAccess)
                }
                if(!this.is_validation(array)){
                    return
                }

                //とりあえずデータは埋まっている
                try{
                    var result = await axios.post(process.env.MIX_SENTRY_DSN_PUBLIC+'/admin/submit/middle',this.formdata, {headers: {'Content-Type': 'multipart/form-data'} })
                }catch(error){
                    console.log(error);
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
