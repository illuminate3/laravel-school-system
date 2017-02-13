module.exports = {
    twoWay: true,
    priority: 1000,

    params: ['options'],

    bind: function () {
        var self = this;

        $(this.el)
            .select2({
                data: this.params.options
            })
            .on('change', function () {
                var val = $(this.el).val();
                self.set(val)
            }.bind(this));
    },

    update: function (value) {
        $(this.el).val(value).trigger('change')
    },

    unbind: function () {
        $(this.el).off().select2('destroy')
    }

}