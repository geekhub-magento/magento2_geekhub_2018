define([
    'underscore',
    'Magento_Ui/js/grid/columns/select'
], function (_, Select) {
    'use strict';

    return Select.extend({
        defaults: {
            additionalCustomClass: '',
            customClasses: {
                pending: 'blue',
                running: 'yellow',
                success: 'green',
                missed: 'grey',
                error: 'red'
            },
            bodyTmpl: 'Geekhub_Lesson9/grid/cells/text'
        },

        getCustomClass: function (row) {
            var customClass = this.customClasses[row.status] || '';
            return customClass + ' ' + this.additionalCustomClass;
        }
    });
});