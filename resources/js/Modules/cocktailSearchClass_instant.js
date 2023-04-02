export default {
    props:{
        Category : [],
        Middle : [],
        Method : [],
        searchMethod : "or",
        isEasily : false
    },

    setCategories:function(categories){
        this.props.Category=categories;
        return this
    },

    setMiddles:function(middles){
        this.props.Middle=middles;
        return this
    },

    setMethods:function(methods){
        this.props.Method=methods;
        return this
    },

    setSearchMethod:function(method){
        this.props.searchMethod=method;
        return this
    },

    setEasily:function(is_easily){
        this.props.isEasily=is_easily;
        return this
    },

    getJSON:function(){
        return JSON.stringify(this.props)
    },
    getObj:function(){
        return this.props
    }

}
