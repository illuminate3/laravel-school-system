module.exports = {
    props: [],

    template: require("./mail-read.html"),

    data: function () {
        return {
            email: null,
        }
    },

    methods: {
        getMail: function () {
            this.$http.get(this.url +  '/' + this.$route.params.id + '/get').then(function (response) {
                this.$set('email', response.data.email);
            }, function (error) {

            });
        },
    },

    ready: function () {
        this.url = this.$parent.url;
        this.getMail();

        this.$watch(this.$route.params.id, function (val) {
            alert('test');
        })
    },

    route: {
        activate: function (transition) {
            transition.next();
            //alert('test');
        },
    },

    events: {
        readMail: function (id) {
            alert(id);
        }
    },

    filters: {
        dateFull: function (val) {
            return moment(val).format('MMM Do YYYY, h:mm:ss a');
        }
    }

}