module.exports = {
    props: [],

    template: require("./mail-read-sent.html"),

    data: function () {
        return {
            email: null,
        }
    },

    methods: {
        getMail: function () {
            this.$http.get(this.url + '/' + this.$route.params.id + '/get').then(function (response) {
                this.$set('email', response.data.email);
            }, function (error) {

            });
        },
    },

    ready: function () {
        this.url = this.$parent.url;
        this.getMail();
    },

}