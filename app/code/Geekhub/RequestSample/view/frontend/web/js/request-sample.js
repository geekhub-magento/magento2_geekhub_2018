define([
    'jquery',
    'geekHub_validationAlert',
    'jquery/ui'
], function ($, validationAlert) {
    'use strict';

    $.widget('geekhub.requestSample', {
        options: {
            action: ''
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
        },

        validateForm: function () {
            return $(this.element).validation().valid();
        }
    });

    return $.geekhub.requestSample;
});
