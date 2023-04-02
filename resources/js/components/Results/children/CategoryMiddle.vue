<template>
    <div>
        <div class="result_text result_cocktail">
            <span id="txt_result">カテゴリー検索結果</span> {{this.categoryMiddles.length}}件ヒットしました。<span v-if="!!this.categoryMiddles.searched_word">(検索語句：<b>{{this.categoryMiddles.searched_word}}</b>)</span>
        </div>
        <div class="result" id="cocktail_result">
            <table class="cocktail_table">
                <thead>
                <tr>
                    <th class="column_name sortable" :class="sortedClass('name')" @click="sortBy('name')">名前</th><th class="column_name_eng sortable" :class="sortedClass('name_eng')" @click="sortBy('name_eng')">Name</th>
                    <th class="column_parent sortable" :class="sortedClass('parent')" @click="sortBy('parent')">親カテゴリ</th>
                </tr>
                </thead>
                <tbody class="list">
                <tr class="" v-for="c in sortedList">
                    <td class="column_name">
                        <router-link v-if="c.category" :to="{ name: 'MiddleDetail', params: { id: parseInt(c.id) }}">{{c.name}}</router-link>
                        <router-link v-else :to="{ name: 'CategoryDetail', params: { id: parseInt(c.id) }}">{{c.name}}</router-link>
                    </td>
                    <td class="column_name_eng">
                        <router-link v-if="c.category" :to="{ name: 'MiddleDetail', params: { id: parseInt(c.id) }}">{{c.name_eng}}</router-link>
                        <router-link v-else :to="{ name: 'CategoryDetail', params: { id: parseInt(c.id) }}">{{c.name_eng}}</router-link>
                    </td>
                    <template v-if="c.category">
                        <td class="column_parent"><router-link :to="{ name: 'CategoryDetail', params: { id: parseInt(c.category.base_id) }}">{{c.category.base_name}}({{c.category.base_eng}})</router-link></td>
                    </template>
                </tr>
                </tbody>
            </table>
        </div>
    </div>
</template>


<script>
    import Helper from "../../../Modules/helper"
    import sortedClass from "../Mixins/SortedClass"

    export default {
        props:["categoryMiddles"],
        mixins: [sortedClass],
        data:function(){
            return {
                //cocktails:null,
                sort: {
                    key: "id",//デフォルトの順番を定義。親カテゴリのID順という意味。
                    isAsc: true
                }
            }
        },
        mounted:function(){
            //デフォルトソート(親カテゴリ順)
            //console.log(this,categoryMiddles)
        },
        computed: {
            //ソート関数
            sortedList: function() {
                let list = this.categoryMiddles.slice();
                if(this.sort.key) {
                    list.sort((a, b) => {
                        var a_=a[this.sort.key]
                        var b_=b[this.sort.key]
                        switch (this.sort.key) {
                            case "parent":
                                console.log("parent")
                                //親カテゴリなしは無条件に下へ
                                if(!a.category && !b.category){return 0}
                                if(!a.category){return 1}
                                if(!b.category){return -1}
                                a_=a.category.base_name;
                                b_=b.category.base_name;
                            case "name":
                                //「ベース」と「名前」はひらがなとカタカナを統一する(これもバグるため)
                                a_ = Helper.katakanaToHiragana(a_.toString());
                                b_ = Helper.katakanaToHiragana(b_.toString());
                                break;
                            case "id":
                                if(a.category){a_=a.category.base_id}//サブカテゴリの場合はその親のIDを取得する
                                if(b.category){b_=b.category.base_id}
                                break;
                                /*
                            case "youtube":
                                //動画の場合、「更新日時」で比較する
                                a_=a.youtube;
                                b_=b.youtube;
                                if(a_===null && b_===null){return 0}
                                if(a_===null){return 1}
                                if(b_===null){return -1}
                                //youtube動画が存在する場合、更新日時で比較する
                                a_=new Date(a.updated_at.date)
                                b_=new Date(b.updated_at.date)
                                break;
                                */
                            default:
                                //それ以外(通常)　英文字は大文字小文字が混在してるとバグるので調整
                                a_ = (a_)?a_.toLowerCase():a_;//nullだとtoLowerCaseが呼び出せないので
                                b_ = (b_)?b_.toLowerCase():b_;
                        }
                        return (a_ === b_ ? 0 : a_ > b_ ? 1 : -1) * (this.sort.isAsc ? 1 : -1);
                    });
                }
                return list;
            }
        },
        methods:{
            sortBy (key) {
                this.sort.isAsc = (this.sort.key === key) ? !this.sort.isAsc : true;//デフォルトが昇順
                /*switch (key) {
                    case "youtube":
                        if(this.sort.key !== key) {
                            this.sort.isAsc = !this.sort.isAsc;//デフォルトが降順の方が良さそうなやつは反転させる
                        }
                }*/
                this.sort.key = key;
            }
        }
    }
</script>
