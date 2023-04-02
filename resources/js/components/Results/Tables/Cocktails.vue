<template>
    <div class="result" id="cocktail_result">
        <!--通常版-->
        <table class="cocktail_table" v-if="!is_sm">
            <thead>
            <tr>
                <th class="method sortable" :class="sortedClass('method')" @click="sortBy('method')">製法</th>
                <th class="name sortable" :class="sortedClass('name')" @click="sortBy('name')">名前</th>
                <th class="name_eng sortable" :class="sortedClass('name_eng')" @click="sortBy('name_eng')">Name</th>
                <th class="category sortable" :class="sortedClass('base')" @click="sortBy('base')">ベース</th>
                <th class="recipe_count sortable" :class="sortedClass('recipe_count')" @click="sortBy('recipe_count')">必須</th>
                <th class="sweet sortable" :class="sortedClass('sweet_degree')" @click="sortBy('sweet_degree')">甘さ</th>
                <th class="rate sortable" :class="sortedClass('rate')" @click="sortBy('rate')">評価</th>
                <th class="strength sortable" :class="sortedClass('strength')" @click="sortBy('strength')">度数</th>
                <th class="youtube sortable" :class="sortedClass('youtube')" @click="sortBy('youtube')">動画</th>
            </tr>
            </thead>
            <tbody class="list" v-if="sortedList">
            <tr :class="{hasMovie:!!c.youtube}" v-for="c in sortedList">
                <td class="method">
                        <font-awesome-icon v-if="c.method.method_id==1" :icon="['fas', 'slash']" />
                        <font-awesome-icon v-else-if="c.method.method_id==2" :icon="['fas', 'fill-drip']" />
                        <font-awesome-icon v-else-if="c.method.method_id==3" :icon="['fas', 'glass-martini-alt']" />
                        <font-awesome-icon v-else-if="c.method.method_id==4" :icon="['fas', 'blender']" />
                        <font-awesome-icon v-else-if="c.method.method_id==5" :icon="['fas', 'glass-whiskey']" />
                        <font-awesome-icon v-else-if="c.method.method_id==6" :icon="['fas', 'mug-hot']" />
                </td><td class="name"><router-link :to="{ name: 'CocktailDetail', params: { id: c.id }}">{{c.name}}</router-link></td>
                <td class="name_eng"><router-link :to="{ name: 'CocktailDetail', params: { id: c.id }}">{{c.name_eng}}</router-link></td>
                <td class="category"><router-link :to="{ name: 'CategoryDetail', params: { id: c.base.base_id }}">{{c.base.base_name}}<span class="category_eng link">({{c.base.base_eng}})</span></router-link></td>
                <td class="recipe_count">{{c.recipe_count}}</td>
                <td class="sweet">{{sweet_degree_str(c.sweet_degree)}}</td>
                <td class="rate" :class="{is_rateFilled : !!c.rate}">{{"★".repeat(c.rate)||"-"}}</td>
                <td class="strength">{{demimalPoint(c.strength,1)}}</td>
                <td class="youtube">
                    <a v-if="c.youtube" :href="youtubeURLnewPage(c.youtube)" target="_blank"><font-awesome-icon v-if="c.youtube" :icon="['fab', 'youtube']" /></a><span v-else>-</span></td>
            </tr>
            </tbody>
        </table>


        <!--スマホ版-->
        <div class="cocktail_table" id="xsTable" v-else>
            <div>
                <div class="name sortable" :class="sortedClass('name')" @click="sortBy('name')" style="font-weight: bold;">名前</div>
            </div>
            <div class="xsTableDatasDiv">
                <div class="method sortable" :class="sortedClass('method')" @click="sortBy('method')" style="font-weight: bold;">製法</div>
                <div class="recipe_count sortable" :class="sortedClass('recipe_count')" @click="sortBy('recipe_count')" style="font-weight: bold;">必須</div>
                <div class="sweet sortable" :class="sortedClass('sweet_degree')" @click="sortBy('sweet_degree')" style="font-weight: bold;">甘さ</div>
                <div class="rate sortable" :class="sortedClass('rate')" @click="sortBy('rate')" style="font-weight: bold;">評価</div>
                <div class="strength sortable" :class="sortedClass('strength')" @click="sortBy('strength')" style="font-weight: bold;">度数</div>
                <div class="youtube sortable" :class="sortedClass('youtube')" @click="sortBy('youtube')" style="font-weight: bold;">動画</div>
            </div>
            <div v-for="c in sortedList" class="partDiv">
                <div :class="{hasMovie:!!c.youtube}">
                    <router-link :to="{ name: 'CocktailDetail', params: { id: c.id }}">{{c.name}}</router-link>
                </div>
                <div :class="{hasMovie:!!c.youtube}" class="xsTableDatasDiv">
                    <div class="method">
                        <font-awesome-icon v-if="c.method.method_id==1" :icon="['fas', 'slash']" />
                        <font-awesome-icon v-else-if="c.method.method_id==2" :icon="['fas', 'fill-drip']" />
                        <font-awesome-icon v-else-if="c.method.method_id==3" :icon="['fas', 'glass-martini-alt']" />
                        <font-awesome-icon v-else-if="c.method.method_id==4" :icon="['fas', 'blender']" />
                        <font-awesome-icon v-else-if="c.method.method_id==5" :icon="['fas', 'glass-whiskey']" />
                        <font-awesome-icon v-else-if="c.method.method_id==6" :icon="['fas', 'mug-hot']" />
                    </div>
                    <div class="recipe_count">{{c.recipe_count}}</div>
                    <div class="sweet">{{sweet_degree_str(c.sweet_degree)}}</div>
                    <div class="rate" :class="{is_rateFilled : !!c.rate}">{{"★".repeat(c.rate)||"-"}}</div>
                    <div class="strength">{{demimalPoint(c.strength,1)}}</div>
                    <div class="youtube">
                        <a v-if="c.youtube" :href="youtubeURLnewPage(c.youtube)" target="_blank"><font-awesome-icon v-if="c.youtube" :icon="['fab', 'youtube']" /></a><span v-else>-</span></div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import Helper from "../../../Modules/helper"
    import sortedClass from "../Mixins/SortedClass"
    import common from "../../CommonMixins/Common"
    import "./table.scss"

    export default {
        props:["cocktails"],
        mixins: [sortedClass,common],
        data:function(){
            return {
                //cocktails:null,
                width: window.innerWidth,
                sort: {
                    key: null,
                    isAsc: false
                }
            }
        },
        mounted:function(){
            //console.log(this.cocktails)
        },
        computed: {
            //ソート関数
            sortedList: function() {
                let list = this.cocktails.slice();
                if(this.sort.key) {
                    list.sort((a, b) => {
                        var a_=a[this.sort.key]
                        var b_=b[this.sort.key]
                        switch (this.sort.key) {
                            case "method":
                                console.log(a_);
                                a_=a_.method_id;
                                b_=b_.method_id;
                                break;
                            case "sweet_degree":
                            case "rate":
                                //甘さ、評価の場合、undefinedは常に-99扱い
                                if(a_===null && b_===null){return 0}
                                if(a_===null){return 1}
                                if(b_===null){return -1}
                            case "strength":
                            case "recipe_count":
                                break;//「甘さ」と「度数」は数値比較なのでここで終了
                            case "base":
                                a_ = a_.base_name;
                                b_ = b_.base_name;
                            case "name":
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
                                a_=new Date(a.updated_at.date)
                                b_=new Date(b.updated_at.date)
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
            },
            is_sm:function () {
                return this.width < 600;
            },
            display_width:function(){
                return this.width
            }
        },
        methods:{
            sortBy (key) {
                this.sort.isAsc = (this.sort.key === key) ? !this.sort.isAsc : true;//デフォルトが昇順
                switch (key) {
                    case "strength":
                    case "sweet_degree":
                    case "youtube":
                    case "rate":
                        if(this.sort.key !== key) {
                            this.sort.isAsc = !this.sort.isAsc;//デフォルトが降順の方が良さそうなやつは反転させる
                        }
                }
                this.sort.key = key;
            },
            demimalPoint(number,dem){
                return Helper.fixDecimalPoint(number,1)
            },

            sweet_degree_str(sweet_degree){
                return Helper.sweet_degree_str(sweet_degree);
            },
        }
    }
</script>

<style scoped lang="scss">
    div#xsTable{
        div.xsTableDatasDiv{
            display: flex;
        }

        div.partDiv{
            padding:5px;
        }

        div.method{
            width:2em;
        }


        div.rate{
            width:100px;
        }

        div.recipe_count,
        div.sweet,
        div.strength,
        div.youtube{
            width:5em;
        }

        div.youtube{
            text-align:center;
        }

        div.method,
        div.rate,
        div.recipe_count,
        div.sweet,
        div.strength,
        div.youtube{
            flex:1;
        }
    }
</style>
