define([
    'jquery',
    'geekHub_validationAlert',
    'Magento_Ui/js/modal/alert',
    'mage/cookies',
    'mage/translate',
    'jquery/ui'
], function ($, validationAlert, alert) {
    'use strict';

    $.widget('geekhub.requestSample', {
        options: {
            cookieName: 'geekhub_sample_was_requested'
        },

        /** @inheritdoc */
        _create: function () {
            $(this.element).submit(this.submitForm.bind(this));
        },

        submitForm: function () {
            if (!this.validateForm()) {
                validationAlert();
                return;
            }

            console.log('Form was submitted');

            var formData = new FormData($(this.element).get(0));
            formData.append('form_key', $.mage.cookies.get('form_key'));

            $.ajax({
                url: $(this.element).attr('action'),
                data: formData,
                processData: false,
                contentType: false,
                type: 'post',
                dataType: 'json',
                context: this,

                beforeSend: function () {
                    $('body').trigger('processStart');
                },

                success: function (response) {
                    $('body').trigger('processStop');
                    alert({
                        title: $.mage.__(response.status),
                        content: $.mage.__(response.message)
                    });

                    if (response.status === 'Success') {
                        // can use this cookie to prevent from sending requests too often
                        $.mage.cookies.set(this.options.cookieName, true);
                    }
                },

                error: function (error) {
                    console.log(JSON.stringify(error));
                    $('body').trigger('processStop');
                    alert({
                        title: $.mage.__('Error'),
                        content: $.mage.__('Your request can not be submitted right now. Please, contact us directly via email or phone to get your Sample.')
                    });
                }
            })
        },

        validateForm: function () {
            return $(this.element).validation().valid();
        }
    });

    return $.geekhub.requestSample;
});
