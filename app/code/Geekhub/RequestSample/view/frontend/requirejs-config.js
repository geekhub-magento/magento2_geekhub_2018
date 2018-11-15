var config = {
    map: {
        '*': {
            geekHubRequestSample: 'Geekhub_RequestSample/js/request-sample',
            geekHubValidationAlert: 'Geekhub_RequestSample/js/validation-alert',
            // overriding default cookie component
            'jquery/jquery.cookie': 'Geekhub_RequestSample/js/jquery/jquery.cookie'
        }
    },
    config: {
        mixins: {
            'Magento_Catalog/js/catalog-add-to-cart': {
                'Geekhub_RequestSample/js/product/catalog-add-to-cart-mixin': true
            },
            'Magento_Checkout/js/action/place-order': {
                'Geekhub_RequestSample/js/checkout/place-order-mixin': true
            }
        }
    }
};
