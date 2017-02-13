module.exports = {
    props: ['sms_driver', 'options'],

    data: function () {
        return {
            loaded: false
        }
    },

    read: function () {
        this.loaded = true;
    }


};