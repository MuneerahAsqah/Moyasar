define(
    [
        'Magento_Checkout/js/view/payment/default',
        'jquery',
        'mage/url',
        'Magento_Custome/js/customer-data',
        'Magento_Checkout/js/model/error-processor',
        'Magento_Checkout/js/model/full-screen-loader',
        'Moyasar_STCpay/js/stcpay/form-builder'
    ],
    function (Component, $, url, customerData, errorProcessor, fullScreenLoader, formBuilder) {
        'use strict';

        return Component.extend({
            redirectAfterPlaceOrder: false,
            defaults: {
                template: 'Moyasar_STCpay/payment/stcpay_template'
            },
            getMailingAddress: function() {
              return window.checkoutConfig.payment.checkmo.mailingAddress;
            },

            afterPlaceOrder: function() {
              var custom_controller_url = url.build('stcpayment/STCpay/PostData');
              $.post(custom_controller_url, 'json')
              .done(function(response) {
                customerData.invalidate(['cart']);
                formBuilder(response).submit();
              })
              .fail(function(response) {
                errorProcessor.process(response, this.messageContainer);
              })
              .always(function() {
                fullScreenLoader.stopLoader();
              })
            }
        });
    }
);
