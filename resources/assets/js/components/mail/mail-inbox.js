module.exports = {
    //props: ['url'],

    template: require("./mail-inbox.html"),

    data: function () {
        return {
            data: {
                query: '',
                page: 1,
            },
            mails: [],
            email_count: 0,
            url: null,
            selectedAll: false,
        }
    },

    computed: {
        selectedMails: function () {
            return this.mails.filter(function (item) {
                return item.selected;
            });
        },
    },

    methods: {
        init: function (response) {
            this.$set('mails', _.map(response.data.received, function (item) {
                item.selected = false;
                return item;
            }));
            this.$set('email_count',response.data.received_count);

            //Look for select all checkbox
            this.$watch('selectedAll', function (selected) {
                this.updateRowsSelection(selected);
            });

            this.$set('loaded', true);
            this.selectedAll = false;
        },

        loadMails: function () {
            this.$http.get(this.url + '/received', this.data).then(function (response) {
                this.init(response);
            }, function (error) {

            });
        },

        deleteSelected: function () {
            var ids = _.map(this.selectedMails, function (item) {
                return item.id;
            });

            this.$http.post(this.url + '/delete', {ids: ids}).then(function () {
                this.loadMails();
            }.bind(this));
        },

        markAsRead: function () {
            var ids = _.map(this.selectedMails, function (item) {
                return item.id;
            });

            this.$http.post(this.url + '/mark-as-read', {ids: ids}).then(function () {
                this.loadMails();
            }.bind(this));

        },
        updateRowsSelection: function (status) {
            _.each(this.mails, function (item) {
                item.selected = status;
            });
        },

        selectAllRead: function () {
            this.updateRowsSelection(false);
            _.each(this.mails, function (item) {
                if (item.read) {
                    item.selected = true;
                }
            });
        },

        selectAllUnRead: function () {
            this.updateRowsSelection(false);
            _.each(this.mails, function (item) {
                if (!item.read) {
                    item.selected = true;
                }
            });
        },

        search: function () {
            this.loadMails();
        }
    },

    ready: function () {
        this.url = this.$parent.url;
        this.loadMails();
    },

    filters: {
        date: function (val) {
            return moment(val).fromNow();
        }
    }
}