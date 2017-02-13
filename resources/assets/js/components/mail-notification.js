module.exports = {
    props: ['url'],

    template: require("./mail-notification.html"),

    data: function () {
        return {
            total: null,
            notifications: []
        }
    },

    methods: {
        loadNotifications: function () {
            this.$http.get(this.url + '/mailbox/all')
                .then(function (response) {
                    this.total = response.total;
                    this.notifications = response.emails;
                })
                .catch(function (error) {

                });
        },

        readNotification: function (item) {
            window.location = this.getUrl(item);
            this.$dispatch('readMail', item.id);
            //router.go({ name: 'inbox', params: { id: item.id }});
            //this.$http.post(this.url + '/mailbox/read', {id: item.id})
            //    .then(function (response) {
            //        this.loadNotifications();
            //        window.location = this.getUrl(item);
            //        router.go({ name: 'inbox', params: { id: item.id }});
            //    }, function (error) {
            //        console.log('error in reading the notification...');
            //    });
        },

        getUrl: function (item) {
            return this.url + '/mailbox#/m/inbox/' + item.id;
        }
    },

    ready: function () {
        this.loadNotifications();
    },

    events: {
        newMailNotification: function (email) {
            this.loadNotifications();
        },
    },

    filters: {
        date: function (val) {
            return moment(val).fromNow();
        }
    },

}