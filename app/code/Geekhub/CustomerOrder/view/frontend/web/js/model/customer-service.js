define([
    'underscore',
    'mageUtils'
], function (_, utils) {
    'use strict';

    return {
        getCustomerList: function (params, options, response) {
            params = params || {};
            utils.ajaxSubmit({
                url: options.url,
                data: params
            }, {
                ajaxSaveType: 'default',
                response: response
            });
        }
    }
});