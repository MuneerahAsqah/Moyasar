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
                type: 'Extension',
                component: 'Moyasar_STCpay/js/view/payment/method-renderer/stcpay'
            }
        );
        /** Add view logic here if needed */
        return Component.extend({});
    }
);
