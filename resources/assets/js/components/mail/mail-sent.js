module.exports = {
    props: [],

    template: require("./mail-sent.html"),

    data: function () {
        return {
            mails: []
        }
    },

    methods: {
        loadSentMails: function () {
            this.$http.get(this.url + '/sent').then(function (response) {
                this.$set('mails', response.data.sent);
            }, function (error) {

            });
        }
    },

    ready: function () {
        this.url = this.$parent.url;
        this.loadSentMails();
    },

    events: {},

    filters: {
        date: function (val) {
            return moment(val).fromNow();
        }
    }

}