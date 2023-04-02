/*ユーザー定義ヘルパ関数群*/


export default {
    props:{
        searchMethod : "or",
        methods : [],
        categories : [],
        middles : [],
        is_easily : false
    },

    generateObj:function (searchMethod, methods,categories, middles, is_easily){
        this.props.searchMethod=searchMethod;
        this.props.methods=methods;
        this.props.categories=categories;
        this.props.middles=middles;
        this.props.is_easily=is_easily;
    },
    saveInstant:function(){
        //自動で保存されるもの
        localStorage.setItem("searchInstant", JSON.stringify( this.props ));//JSONを生成する
    },
    saveUser:function(){
        //ユーザー自身が保存するもの
        console.log(this.props)
        console.log(JSON.stringify( this.props ))
        localStorage.setItem("searchUser", JSON.stringify( this.props ));//JSONを生成する
    },
    loadInstant:function(){
        //「前回の検索結果の読み込み」
        return JSON.parse(localStorage.getItem("searchInstant"));
    },
    loadUser:function(){
        //「保存したデータ」の読み込み
        return JSON.parse(localStorage.getItem("searchUser"));
    }
}
