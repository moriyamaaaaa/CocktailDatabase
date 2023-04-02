<template>
    <div class="result brand_result">
        <table>
            <thead>
            <tr>
                <th class="name sortable" :class="sortedClass('name')" @click="sortBy('name')">名前</th>
                <th class="name_eng sortable" :class="sortedClass('name_eng')" @click="sortBy('name_eng')">Name</th>
                <th class="category sortable" :class="sortedClass('category')" @click="sortBy('category')">親カテゴリ</th>
                <th class="middle sortable" :class="sortedClass('middle')" @click="sortBy('middle')">ミドルカテゴリ</th>
                <th class="strength sortable" :class="sortedClass('volume')" @click="sortBy('volume')">度数</th>
                <th class="youtube sortable" :class="sortedClass('youtube')" @click="sortBy('middle')">動画</th>
            </tr>
            </thead>
            <tbody class="list">
            <tr :class="{hasMovie:!!b.youtube}" v-for="b in sortedList">
                <td class="name">
                    <router-link :to="{ name: 'BrandDetail', params: { id: b.id }}">
                        {{b.name}}
                    </router-link>
                </td>
                <td class="name_eng">
                    <router-link :to="{ name: 'BrandDetail', params: { id: b.id }}">
                        {{b.name_eng}}
                    </router-link></td>
                <template v-if="b.category">
                        <td class="category">
                            <router-link :to="{name:'CategoryDetail', params: { id: b.category.base_id }}">{{b.category.base_name}}({{b.category.base_eng}})</router-link>
                        </td>
                </template>
                <template>
                    <td class="middle" v-if="b.middle">
                        <router-link :to="{name:'MiddleDetail', params: { id: b.middle.id }}">{{b.middle.name}}<span class="middle_eng link">({{b.middle.name_eng}})</span></router-link>
                    </td>
                    <td class="middle" v-else></td>
                </template>
                <template>
                    <td class="strength">{{b.volume||""}}</td>
                </template>
                <template>
                    <td class="youtube">
                        <a v-if="b.youtube" :href="youtubeURLnewPage(b.youtube)" target="_blank"><font-awesome-icon v-if="b.youtube" :icon="['fab', 'youtube']" /></a><span v-else>-</span></td>
                </template>
            </tr>
            </tbody>
        </table>
    </div>
</template>


<script>
    import Helper from "../../../Modules/helper"
    import sortedClass from "../Mixins/SortedClass"
    import common from "../../CommonMixins/Common"
    import "./table.scss"

    export default {
        props:["brands"],
        mixins: [sortedClass,common],
        data:function(){
            return {
                sort: {
                    key: "",
                    isAsc: true
                }
            }
        },
        mounted:function(){
            console.log(this.brands)
        },
        computed: {
            //ソート関数
            sortedList: function() {
                let list = this.brands.slice();
                if(this.sort.key) {
                    list.sort((a, b) => {
                        var a_=a[this.sort.key]
                        var b_=b[this.sort.key]
                        switch (this.sort.key) {
                            case "middle":
                                //親カテゴリなしは無条件に下へ
                                if(!a_ && !b_){return 0}
                                if(!a_){return 1}
                                if(!b_){return -1}
                            //キーの名前が違っているので入れ直し
                            case "category":
                                if(this.sort.key==="category"){
                                    a_=a_.base_name;
                                    b_=b_.base_name;
                                }else{
                                    a_=a_.name;
                                    b_=b_.name;
                                }
                            case "name":
                                //↓このまま文字列比較へ続く
                                //「ベース」と「名前」はひらがなとカタカナを統一する(これもバグるため)
                                a_ = Helper.katakanaToHiragana(a_.toString());
                                b_ = Helper.katakanaToHiragana(b_.toString());
                                break;
                            case "youtube":
                                //動画の場合、「更新日時」で比較する
                                a_=a.youtube;
                                b_=b.youtube;
                                if(a_===null && b_===null){return 0}
                                if(a_===null){return 1}
                                if(b_===null){return -1}
                                //youtube動画が存在する場合、更新日時で比較する
                                a_=new Date(a.b_updated_at.date)
                                b_=new Date(b.b_updated_at.date)
                                break;
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

<style lang="scss" scoped>
    @import "../../mq.scss";
    @import "./table.scss";

    span.middle_eng {
        @include mqm(xs) {
            display:none;
        }
    }
</style>
