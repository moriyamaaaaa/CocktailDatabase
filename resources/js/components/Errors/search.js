export default {
    methods: {
        searchError: function(code=0) {
            //alert("エラーが発生しました。通信状況をお確かめの上もう一度試して下さい。(エラーコード:"+code+")")
            alert("エラーが発生しました。強制リロードします。もし引き続きエラーが出る場合、通信状況をお確かめ下さい。もし特定の手順、もしくはページを踏んでエラーが出る場合は管理者にご連絡下さい。")
            location.reload(true);
        }
    }
}
