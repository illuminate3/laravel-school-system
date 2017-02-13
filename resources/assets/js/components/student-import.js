module.exports = {
    props: ['url'],

    data: function () {
        return {
            data: null,
            students: null,
            sections: null,
            selectedAll: false
        }
    },

    template: require("./student-import.html"),


    filters: {
        success: function (items) {
            return items.filter(function (item) {
                return item.created;
            });
        },

        rejected: function (items) {
            return items.filter(function (item) {
                return item.errors
            });
        }
    },

    computed: {
        actuallyUseableSectionList: function () {
            return this.sections.map(function(section) {
                var code = Object.keys(section)[0];
                return {
                    code: code,
                    name: section[code]
                }
            })
        },
        completed: function () {
            return (this.data !== null) ?
                this.data.filter(function (item) {
                    return item.created;
                }):null;
        },

        remaining: function () {
            return (this.data !== null) ?
                this.data.filter(function (item) {
                    return !item.created;
                }): 0;
        },

        total: function () {
            return (this.data !== null) ? this.data.length : 0;
        },

        selected: function () {
            return (this.data !== null) ?
                this.data.filter(function (item) {
                    return item.selected;
                }) :
                0;
        }
    },

    methods: {
        init: function (res) {
            //Excel ROWS
            this.$set('data', _.map(res.students, function (item) {
                item.created = false;
                item.errors = false;
                item.selected = false;
                return item;
            }));

            //county data to be used
            this.$set('sections', res.sections);

            //Look for select all checkbox
            this.$watch('selectedAll', function (selected) {
                this.updateRowsSelection(selected);
            });

            this.selectedAll = false;
        },

        updateRowsSelection: function (status) {
            _.each(this.data, function (item) {
                item.selected = status;
            });
        },

        uploadFile: function () {

            var formData = new FormData();
            formData.append('file', this.$els.fileinput.files[0]);

            this.$http.post(this.url + 'import', formData)
                .success(function (res) {
                    this.init(res);
                }.bind(this)).error(function (err) {

            })
        },

        createRecord: function (item) {
            if (!item.created) {
                var vm = this;
                this.$http.post(this.url + 'ajax-store', item)
                    .success(function (response) {
                        item.created = true;
                        item.selected = false;
                        item.errors = null;
                    })
                    .error(function (error) {
                        console.log(error);
                        item.errors = error;
                    });
            }
        },

        createAll: function () {
            this.selected.forEach(function (item) {
                this.createRecord(item);
            }.bind(this));
        }
    }
}
