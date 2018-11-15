define([
    'jquery',
    'mage/cookies'
], function ($) {
    'use strict';

    // see jQuery.mage.catalogAddToCart.prototype in your browser to get more information of how extending via mixins work
    return function (widget) {
        $.widget('mage.catalogAddToCart', widget, {
            /**
             * @param {String} form
             */
            submitForm: function (form) {
                $('body').trigger('geekhub_request_sample_clear_cookie');
                this._super(form);
            }
        });

        return $.mage.catalogAddToCart;
    };
});
