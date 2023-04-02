export default {
    methods: {
        sortedClass: function(key) {
            return this.sort.key === key ? `sorted ${this.sort.isAsc ? 'asc' : 'desc' }` : '';
        }
    }
}
