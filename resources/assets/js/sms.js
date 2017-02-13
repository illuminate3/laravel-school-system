var Vue = require('vue');
var VueRouter = require('vue-router');
var VueValidator = require('vue-validator');

Vue.use(require('vue-resource'));
Vue.use(VueRouter);
Vue.use(VueValidator);

Vue.http.headers.common['X-CSRF-TOKEN'] = document.querySelector('#token').getAttribute('value');

Vue.directive('image-preview', require('./directives/image-upload-preview'));
Vue.directive('select', require('./directives/select2'));

var App = Vue.extend({
    components: {
        'backup-settings': require('./components/backup-settings'),
        'sms-settings': require('./components/sms-settings'),
        'notifications': require('./components/notifications'),
        'mail-notifications': require('./components/mail-notification'),
        'mail': require('./components/mail'),
        'teacher-import': require('./components/teacher-import'),
        'student-import': require('./components/student-import'),
        'subject-import': require('./components/subject-import')
    },
    methods: {
        initToastr: function () {
            toastr.options = {
                "closeButton": true,
                "debug": false,
                "positionClass": "toast-top-right",
                "onclick": null,
                "showDuration": "1000",
                "hideDuration": "1000",
                "timeOut": "5000",
                "extendedTimeOut": "1000",
                "showEasing": "swing",
                "hideEasing": "linear",
                "showMethod": "fadeIn",
                "hideMethod": "fadeOut"
            }
        }
    },
    events: {
        readMail: function (id) {
            this.$broadcast('readMail', id);
        }
    },
    ready: function () {
        this.initToastr();
    }
});

var router = new VueRouter({
    hashbang: false,
    linkActiveClass: 'active'
});

router.map({
    '/m': {
        component: require('./components/mail'),

        subRoutes: {
            '/inbox': {
                component: require('./components/mail/mail-inbox')
            },

            '/inbox/:id': {
                name: 'inbox',
                component: require('./components/mail/mail-read'),

                subRoutes: {
                    '/reply': {
                        name: 'reply',
                        component: require('./components/mail/mail-reply')
                    }
                }
            },


            '/compose': {
                component: require('./components/mail/mail-compose')
            },

            '/sent': {
                component: require('./components/mail/mail-sent')
            },

            '/sent/:id': {
                name: 'sent',
                component: require('./components/mail/mail-read-sent')
            }

        }
    }
});

router.redirect({
    // redirect can contain dynamic segments
    // the dynamic segment names must match
    '/m/inboxr/:id': '/m/inbox/:id'
});

router.start(App, 'body');

$(document).ready(function () {
    $('textarea').not(".no_wysiwyg").summernote({height: 200});
    $('.select2').select2({
        width: '100%',
        theme: 'bootstrap'
    });
    $('#to_email_id').select2({
        width: '100%',
        theme: 'bootstrap',
        placeholder: 'Select'
    });

    $('.tokenfield').tokenfield();

    if ($('#type').val() == 'select' || $('#type').val() == 'radio' || $('#type').val() == 'checkbox'){
        $('.custom-field-option').show();
    }
    else{
        $('.custom-field-option').hide();
        $('#options').val();
    }

    $( "#custom-field-form #type" ).on('change', function() {
        var field = $(this).val();
        if(field == 'select' || field == 'radio' || field == 'checkbox'){
            $('.custom-field-option').show();
        }else {
            $('.custom-field-option').hide();
            $('#options').val();
        }
    });

    $('#phone, #mobile').intlTelInput({nationalMode: false});
});