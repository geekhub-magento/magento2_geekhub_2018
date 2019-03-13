define([
    'jquery',
    'underscore',
    'uiComponent',
    'ko',
    'Magento_Checkout/js/model/step-navigator',
    'mage/translate'
], function (
    $,
    _,
    Component,
    ko,
    stepNavigator,
    $t
) {
    'use strict';

    return Component.extend({
        defaults: {},
        isVisible: ko.observable(false),

        /** @inheritdoc */
        initialize: function () {
            this._super();
            stepNavigator.registerStep(
                'success',
                null,
                $t('Success'),
                this.isVisible,
                _.bind(this.navigate, this),
                40
            );

            return this;
        },

        /**
         * Navigate method.
         */
        navigate: function (step) {
            var self = this;
            self.isVisible(true);
        }
    });
});
