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
                'product',
                null,
                $t('Product'),
                this.isVisible,
                _.bind(this.navigate, this),
                20
            );

            return this;
        },

        /**
         * Navigate method.
         */
        navigate: function () {
            var self = this;
            self.isVisible(true);
        },

        nextAction: function () {
            stepNavigator.next();
        }
    });
});
