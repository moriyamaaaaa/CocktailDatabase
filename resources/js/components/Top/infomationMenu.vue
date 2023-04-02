<template>
    <v-layout wrap class="menu">
        <v-flex sm12 lg6>
            <div class="menu_child">
                <div class="title">Menu</div>
                <div class="text">
                    <div class="menu_block">
                        <div class="link_block">・<a href="#cocktailform_anchor">カクテル検索</a></div>
                        <div>具体的な条件を指定してカクテルが検索できます。<br>
                            名前から検索する時は上部のフォームよりどうぞ。<br>
                        </div>
                    </div>
                    <div class="menu_block">
                        <div class="link_block">・<a href="https://www.youtube.com/channel/UCJBSxULGc7KiQfjo85qoG7g" target="_blank">カクテル動画リスト</a></div>
                        <div>カクテルのメイキング＆感想動画のリスト(youtubeに飛びます)</div>
                    </div>
                    <div class="menu_block">
                        <div class="link_block">・<router-link :to="{ name: 'DictionaryIndex'}">用語辞典</router-link></div>
                        <div>素人解説の辞典です。分からない単語があれば。</div>
                    </div>
                </div>
            </div>
        </v-flex>
        <v-flex sm12 lg6>
            <div class="menu_child">
                <div class="title">What is this!?</div>
                <div class="text heightScroll">
                    <a href="http://trc-vlackhistory.net" target="_blank">私(ろんぐ)</a>が、個人的に作ったカクテルのデータベースです。<br>
                    <b>「今手元にあるお酒で何が作れるか」</b><b>「聞いたことのないカクテルとの出会い」</b>に重点を置いています。<br>
                    <br>
                    私自身が作って飲んだカクテルに関しては、<s>私が忘れるので</s>評価とコメントを残しています。<br>
                    <br>
                    私がおすすめするカクテルを試してみるも良し！地雷臭のするカクテルに挑戦しても良し！<br>
                    宅飲みの際の話題のネタにも。カクテルは意外と簡単に作れるものです！ビールだけじゃ勿体無い！<br>
                    <br>
                    さあ、あなたも是非おうちでカクテル、作りませんか！？<br>
                    まずは下のフォーム、もしくは上の検索ボタンから、知ってるカクテルでも探してみましょう！
                </div>
            </div>
        </v-flex>
    </v-layout>
</template>

<script>

</script>

<style scoped lang="scss">
    @import "../mq.scss";

    div.menu_child{
        margin-left:10px;

        div.title{
            font-size:150%;
            border-left:5px solid #4499FF;
            border-bottom: 2px solid #4499FF;
            padding-left: 5px;
            margin-bottom:3px;

        }
        div.menu_block{
            margin-top:7px;
            margin-bottom: 15px;

            div.link_block{
                font-size:130%;
            }
        }
        @include mq(sm) {
            div.text.heightScroll{
                max-height:250px;
                overflow-y: scroll;

                -ms-overflow-style: none;    /* IE, Edge 対応 */
                scrollbar-width: none;       /* Firefox 対応 */

                &::-webkit-scrollbar {  /* Chrome, Safari 対応 */
                    display:none;
                }
            }
        }

    }
</style>
