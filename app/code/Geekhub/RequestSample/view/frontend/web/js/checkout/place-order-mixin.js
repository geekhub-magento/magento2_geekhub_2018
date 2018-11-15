define([
    'jquery',
    'mage/utils/wrapper'
], function ($, wrapper) {
    'use strict';

    return function (placeOrderAction) {

        /** Override default place order action and add clear cookie */
        return wrapper.wrap(placeOrderAction, function (originalAction, paymentData, messageContainer) {
            $('body').trigger('geekhub_request_sample_clear_cookie');

            return originalAction(paymentData, messageContainer);
        });
    };
});
