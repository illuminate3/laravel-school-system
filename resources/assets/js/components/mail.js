module.exports = {
    props: ['url'],

    template: require("./mail.html"),

    data: function () {
        return {
            email_count: 0,
            sent_email_count: 0,
            users: [],
            users_list: [],
            online: false,
        }
    },

    methods: {
        loadData: function () {
            this.$http.get(this.url + '/data', this.query).then(function (response) {
                this.$set('email_count', response.data.email_count);
                this.$set('sent_email_count', response.data.sent_email_count);
                this.$set('users', response.data.users);
                this.$set('users_list', response.data.users_list);
                //this.$set('online', this.onlineUsers.length > 0 ? true : false);
            }, function (error) {

            });
        }
    },

    computed: {
        onlineUsers: function () {
            return this.users_list.filter(function (item) {
                if(parseInt(item.active)) {
                    return item;
                }
            });
        }
    },

    filters: {
        online: function (items) {
            return items.filter(function (item) {
                return item.active;
            });
        }
    },

    ready: function () {
        this.loadData();
    },

    events: {
        mailStatusUpdated: function () {
            this.loadData();
        },

        readMail: function (id) {
            alert('Reading message...');
        }
    }

};
