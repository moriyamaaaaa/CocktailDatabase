<template>
    <div id="container">
        <kind-select v-bind:edit-mode="editMode"
                         v-bind:selected-kind.sync="selectedKind"

                         ref="categoryKind"
        />
        <br>
        <NameAndDrescription
            v-bind:edit-mode="editMode"
            v-bind.sync="detailEditObj"

            ref="categoryForm"

        ></NameAndDrescription>

        <br>
        <v-btn large  color="blue darken-3" dark @click="send">送信</v-btn>

    </div>
</template>

<script>
    import KindSelect from "./component/KindSelect"
    import NameAndDrescription from "./component/NamesAndDescription"
    import FamousBrand from "./component/FamousBrandSelect"
    import validationComponent from "./component/validationComponent"
    import newBrandObj from "./component/newBrandObjDatat"
    import BrandList from "./../BrandList"
    import MiddleList from "./../MiddleList"

    export default {
        mixins:[validationComponent,newBrandObj],
        components: {
            KindSelect,NameAndDrescription,FamousBrand,BrandList,MiddleList
        },
        props:{
            category_id:Number
        },
        data() {
            return {
                editMode:"Dictionary",
                selectedKind:null,
                selectedBrand:null,

                detailEditObj:{
                    name:"",
                    name_eng:"",
                    //kind:"",
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
            if(!this.category_id){return}
            //IDがくっついているのでデータ取得
            try{
                var {data:{result:{category:category}}} = await axios.post(process.env.MIX_SENTRY_DSN_PUBLIC+'/Cocktail/admin/get/category',{
                    id:this.category_id
                })
            }catch(e){
                console.log(e)
            }

            this.detailEditObj.name=category.name
            this.detailEditObj.name_eng=category.name_eng
            this.detailEditObj.description=category.description
            this.detailEditObj.youtube=category.youtube
            this.detailEditObj.youtube_time_hour=category.y_hour
            this.detailEditObj.youtube_time_minute=category.y_minute
            this.detailEditObj.youtube_time_second=category.y_second
            this.detailEditObj.link_txt=category.image_txt
            this.detailEditObj.link_url=category.image_url
            this.detailEditObj.is_major=category.is_major
            this.detailEditObj.is_like=category.is_like
            this.detailEditObj.is_powder=category.is_powder
            this.detailEditObj.uploadImageUrl=category.image

            this.selectedBrand={value:category.famous_brand_id||null,label:""}
            this.selectedKind={value:category.kind||null,label:""}
        },
        computed:{
            sendObj:function(){
                var data={
                    id:(this.category_id)?this.category_id:null,
                    kind:(this.selectedKind)?this.selectedKind.value:null,
                    ...this.detailEditObj
                }

                //銘柄データを付与する
                if(this.category_id && this.selectedBrand && this.selectedBrand.value!=null){
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
        methods: {
            async send() {
                //データを送信する
                //データのバリデーション
                var array = [
                    this.$refs.categoryForm.validateObj,
                    this.$refs.categoryKind.validateObj,
                ]
                //もし「親カテゴリ」がその他だった場合は、この部分のバリデーションが不要になる
                try {
                    var {data: {result: {is_kind5: is_kind5}}} = await axios.post(process.env.MIX_SENTRY_DSN_PUBLIC + '/Cocktail/iskind5/kind/check', {id: this.selectedKind.value})
                } catch (e){
                    //大カテゴリのバリデーション自体に関しては、this.$refs.categoryKind.validateObjに丸投げするので処理を継続してもよい
                    is_kind5=false;
                }　
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
                    var result = await axios.post(process.env.MIX_SENTRY_DSN_PUBLIC+'/admin/submit/dictionary',this.formdata, {headers: {'Content-Type': 'multipart/form-data'} })
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
