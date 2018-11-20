define(
    [
        'jquery',
        'ko',
        'uiComponent',
    ],
    function ($, ko, component) {
        "use strict";

        return component.extend({
            firstName: ko.observable('John'),
            lastName: ko.observable('Doe'),
            initialize: function() {
                this._super();
                this.fullName = ko.pureComputed(function () {
                    return this.firstName() + ' ' + this.lastName();
                }, this);
            },
            defaults: {
                template: 'Geekhub_Lesson7/grid'
            }
        });
    }
);
