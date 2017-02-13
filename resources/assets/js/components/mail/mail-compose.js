module.exports = {
    props: [],

    template: require("./mail-compose.html"),

    data: function () {
        return {
            users: null,
            data: {
                recipients: null
            }
        }
    },

    methods: {
        sendMail: function () {
            var data = this.data;
            if (data.recipients != null && data.subject != null && data.message != null) {
                this.$http.post(this.url + '/send', data).then(function (response) {
                    this.data = {}
                    toastr["success"]("Email sent successfully");
                }.bind(this));
            } else {
                //alert('Please fill all the required fields.');
                toastr["error"]("Please fill the required fields");
            }
        },

        loadData: function () {
            var self = this;
            this.$http.get(this.url + '/data', this.query).then(function (response) {
                this.$set('users', response.data.users);
                this.$set('loaded', true);
            }, function (error) {

            });
        }
    },

    ready: function () {
        this.url = this.$parent.url;
        this.loadData();
    },

    events: {},

    route: {
        activate: function () {
            
        }
    }
}