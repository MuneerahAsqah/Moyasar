<?php

namespace Moyasar\STCpay\Model;


class STCpay extends \Magento\Payment\Model\Method\AbstractMethod
{
  const METHOD_CODE = 'STCpay';
  protected $_code = self::METHOD_CODE;

  protected $_isGateway = true;
  protected $_canAuthorize = true;
  protected $_canCapture = true;
  protected $_canUseCheckout = true;

  public function __consrtuct(
    \Magento\Framework\Model\Context $context,
    \Magento\Framework\Registry $registry,
    \Magento\Framework\Api\ExtensionAttributesFactory $extensionFactory,
    \Magento\Framework\Api\AttributeValueFactory $customAttributeFactory,
    \Magento\Payment\Helper\Data $paymentData,
    \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig,
    \Magento\Payment\Model\Method\Logger $logger,
    \Magento\Framework\Module\ModuleListInterface $moduleList,
    \Magento\Framework\Stdlib\DateTime\TimezoneInterface $localeDate,
    \Extension\Extension $Extension,
    array $data = array()
  ) {
    parent::__construct(
      $context,
      $registry,
      $extensionFactory,
      $customAttributeFactory,
      $paymentData,
      $scopeConfig,
      $logger,
      $moduleList,
      $localeDate,
      null,
      null,
      $data
    );

    $this->_code = 'Extension';
    $this->_Extension = $Extension;
    $this->_Extension->setApiKey($this->getConfigData('api_key'));
  }

  public function capture(\Magento\Payment\Model\InfoInterface $payment, $amount){
    $order = $payment->getOrder();
    $billing = $order->getBillingAddress();
    $mobile = $this->getRequest()->getPost('mobile');

    try {
      $requestData = [
        //the amount in samllest currency unit
        'publishable_api_key' => $this->getConfigData('publishable_api_key'),
        'amount' => $amount * 100,
        'description' => sprintf('#%s, %s', $order->getIncrementId(), $order->getCustomerEmail()),
        'currency' => 'SAR',
        'source' => array(
          'type'=> 'stcpay',
          'mobile'=> $mobile
        )
      ];

      $payment ->setTransactionId($charge->id) ->setIsTransactionClosed(0);

    } catch (\Exception $e) {
      $this->debugData(['request' => $requestData, 'exception' => $e->getMessage()]); $this->_logger->error(__('Payment capturing error.'));
      throw new \Magento\Framework\Validator\Exception(__('Payment capturing error.'));
                }

    return $this;

  }


}

 ?>
