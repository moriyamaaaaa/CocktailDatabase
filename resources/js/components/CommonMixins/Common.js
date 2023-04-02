export default {
    methods: {
        youtubeURL: function(str) {
            //embed専用･･････メソッド名みすった･･････
            return "https://www.youtube.com/embed/"+str;
        },
        youtubeURLnewPage: function(str) {
            return "https://www.youtube.com/watch?v="+str;
        },

        imageURL:function(str){
            return process.env.MIX_IMAGE_CONTAINER_URL+str
        }
    }
}
