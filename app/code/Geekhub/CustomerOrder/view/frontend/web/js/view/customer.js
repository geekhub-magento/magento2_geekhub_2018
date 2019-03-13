define([
    'jquery',
    'underscore',
    'uiComponent',
    'ko',
    'Magento_Checkout/js/model/step-navigator',
    'mage/translate',
    'mageUtils',
    'Geekhub_CustomerOrder/js/model/customer-service'
], function (
    $,
    _,
    Component,
    ko,
    stepNavigator,
    $t,
    utils,
    customerService
) {
    'use strict';

    return Component.extend({
        defaults: {
            customers: [],
            listens: {
                responseData: 'updateCustomersList',
                request: 'searchRequest'
            }
        },
        isVisible: ko.observable(false),

        /** @inheritdoc */
        initialize: function () {
            this._super();
            stepNavigator.registerStep(
                'customer',
                null,
                $t('Customer'),
                this.isVisible,
                _.bind(this.navigate, this),
                10
            );

            var self = this;
            this.initCustomerList();
            // this.responseData.subscribe(function(data){
            //     self.customers(data.customers);
            // });

            return this;
        },

        initObservable: function () {
            return this._super()
                .observe([
                    'responseData',
                    'responseStatus',
                    'customers',
                    'request'
                ]);
        },

        initCustomerList: function (params) {
            customerService.getCustomerList(
                params,
                {
                    url: this.customersListUrl
                },
                {
                    data: this.responseData,
                    status: this.responseStatus
                }
            );
        },

        updateCustomersList: function (data) {
            this.customers(data.customers);
        },


        chooseCustomer: function (customer) {
            alert(customer.id);
        },

        searchRequest: function (request) {
            this.initCustomerList({q:request});
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
        }
    });
});
