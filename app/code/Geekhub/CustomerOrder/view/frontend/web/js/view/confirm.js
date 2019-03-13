define([
    'jquery',
    'underscore',
    'Magento_Ui/js/form/form',
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
                'confirm',
                null,
                $t('Confirm'),
                this.isVisible,
                _.bind(this.navigate, this),
                30
            );

            return this;
        },

        /**
         * Navigate method.
         */
        navigate: function (step) {
            var self = this;
            self.isVisible(true);
        },

        nextAction: function () {
            stepNavigator.next();
        },

        submitAction: function () {
            var formData = this.source.data;
            if (formData.test_input) {
                this.nextAction();
            } else {
                alert('Please set input data!');
            }
        }
    });
});
