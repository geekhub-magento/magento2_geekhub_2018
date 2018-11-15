define([
    'jquery',
    'jquery/ui',
    'Magento_Ui/js/modal/alert',
    'mage/translate'
], function ($) {
    'use strict';

    $.widget('geekhub.validationAlert', $.mage.alert, {
        options: {
            modalClass: 'error',
            title: $.mage.__('Request can not be sent'),
            content: $.mage.__('Please, check the form data. Some fields are not filled in correctly.')
        },

        /**
         * Override the openModal method to be able to have the default content and do not pass it every time
         */
        openModal: function () {
            var element = this._super();

            $('<div></div>').html(this.options.content).appendTo(element);
        }
    });

    return $.geekhub.validationAlert;
});
