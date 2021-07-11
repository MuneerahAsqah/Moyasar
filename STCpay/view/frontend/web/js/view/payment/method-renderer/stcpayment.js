define(
    [
        'Magento_Checkout/js/view/payment/default'
    ],
    function (Component) {
        'use strict';
 
        return Component.extend({
            defaults: {
                template: 'Moyasar_STCpay/payment/stcpay_template'
            }
        });
    }
);
