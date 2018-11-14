define([
    'jquery',
    'jquery/ui'
], function ($) {
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
                return;
            }

            alert('Form was submitted');
        },

        validateForm: function () {
            return true;
        }
    });

    return $.geekhub.requestSample;
});
