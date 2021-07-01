define(
    [
        'jquery',
        'Magento_Checkout/js/view/payment/default',
        'mage/url',
        'Magento_Customer/js/customer-data',
        'Magento_Checkout/js/model/error-processor',
        'Magento_Checkout/js/model/full-screen-loader',
        //'Moyasar_STCpay/js/STCpay/form-builder'
    ],

    function (Component, $) {
        'use strict';

        return Component.extend({
            defaults: {
                template: 'Moyasar_STCpay/payment/stcpay'
            },

            getCode: function() {
                return 'STCpay';
            },

            isActive: function() {
                return true;
            },

            validate: function() {
                var $form = $('#' + this.getCode() + '-form');
                return $form.validation() && $form.validation('isValid');
            }
        });
    }
);
