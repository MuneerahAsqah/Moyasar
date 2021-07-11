define(
    [
        'uiComponent',
        'Magento_Checkout/js/model/payment/renderer-list'
    ],
    function (
        Component,
        rendererList
    ) {
        'use strict';
        rendererList.push(
            {
                type: 'stcpayment',
                component: 'Moyasar_STCpay/js/view/payment/method-renderer/stcpayment'
            }
        );
        return Component.extend({});
    }
);
