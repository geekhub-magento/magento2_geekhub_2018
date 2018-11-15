var config = {
    map: {
        '*': {
            geekHub_requestSample: 'Geekhub_RequestSample/js/request-sample',
            geekHub_validationAlert: 'Geekhub_RequestSample/js/validation-alert',
            // overriding default cookie component
            'jquery/jquery.cookie': 'Geekhub_RequestSample/js/jquery/jquery.cookie'
        }
    },
    config: {
        mixins: {
            'Magento_Catalog/js/catalog-add-to-cart': {
                'Geekhub_RequestSample/js/product/catalog-add-to-cart-mixin': true
            }
        }
    }
};