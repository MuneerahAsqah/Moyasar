define(
    [
        'uiComponent',
        'Magento_Checkout/js/model/payment/renderer-list'
    ],
    function (Component,
              rendererList) {
        'use strict';
        rendererList.push(
            {
                type: 'stcpay',
                component: 'Moyasar_STCpay/js/view/payment/method-renderer/stcpay-method'
            }
        );
        return Component.extend({});
    }
);
