module.exports = {
    props: ['url'],

    template: require("./notifications.html"),

    data: function () {
        return {
            total: null,
            notifications: []
        }
    },

    methods: {
        loadNotifications: function () {
            /*this.$http.get(this.url + '/notification/all')
                .success(function (response) {
                    this.total = response.total;
                    this.notifications = response.notifications;
                })
                .error(function (error) {

                });*/
        },

        readNotification: function (item) {
            this.$http.post(this.url + '/notification/read', {id: item.id})
                .then(function (response) {
                    window.location = this.getUrl(item);
                }, function (error) {
                    console.log('error in reading the notification...');
                });
        },

        getUrl: function (item) {
            return this.url + '/' + item.type + '/' + item.type_id + '/edit';
        }
    },

    filters: {
        date: function (val) {
            return moment(val).fromNow();
        }
    },

    ready: function () {
        this.loadNotifications();
    },

    events: {
        newNotification: function (item) {
            this.loadNotifications();
        }
    }

}