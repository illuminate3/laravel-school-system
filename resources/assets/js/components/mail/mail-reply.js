module.exports = {
    props: ['email'],

    template: require("./mail-reply.html"),

    data: function () {
        return {
            data: {}
        }
    },

    methods: {
        submitReply: function () {
            if (this.data.message != null) {
                this.$http.post(this.url +'/'+ this.$route.params.id + '/reply', this.data).then(function () {
                    this.$route.router.go({
                        name: 'inbox',
                        params: {
                            id: this.$route.params.id
                        }
                    })
                }.bind(this));
            } else {
                toastr["error"]("Please fill all the required fields");
            }
        }
    },

    ready: function () {
        this.url = this.$parent.$parent.url;
    },

    events: {}

}