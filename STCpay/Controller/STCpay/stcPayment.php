<?php

namespace Moyasar\STCpay\Controller\STCpay;

use Magento\Checkout\Model\Session;
use Magento\Framework\App\Action\Context;
use Magento\Framework\Controller\ResultFactory;
use Magento\Sales\Model\Order;
use Magento\Framework\App\ResponseInterface;


class stcPayment extends use Magento\Framework\App\ActionInterface
{
  function __construct(
    Context $context,
    \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig,
    Session $checkoutSession,
    \Magento\Framework\UrlInterface $urlBuilder,
    \Magento\Framework\Controller\Result\JsonFactory $resultJsonFactory,
    \Magento\Directory\Model\CountryFactory $countryFactory,
    \Magento\Sales\Api\OrderRepositoryInterface $orderRepository,
    \Magento\Framework\HTTP\ClientInterface $client
    ) {
      parent::__consrtuct($context);
      $this->scopeConfig = $scopeConfig;
      $this->checkoutSession = $checkoutSession;
      $this->urlBuilder = $urlBuilder;
      $this->resultJsonFactory = $resultJsonFactory;
      $this->orderRepository = $orderRepository;
      $this->client = $client;
  }

  public function execute(){

    //getting the parameters
    $qoute = $this->checkoutSession->getQoute();
    $qouteData = $qoute->getData();

    $amount = $qoute->getGrandTotal();
    //$email = $order->getCustomerEmail();
    $mobile = $this->getRequest()->getPost('mobile');

    $post_data = array(
      'publishable_api_key' => $this->scopeConfig->get('publishable_api_key'),
      'amount' => $amount * 100,
      'currency' => 'SAR',
      'description' => $email,
      'source' => array(
        'type' => 'stcpay',
        'mobile' => $mobile)
      );


      $params = json_encode($post_data);

      $url = "https://api.moyasar.com/v1/payments";

      //$result = $this->resultJsonFactory->create();

    try {

      $this->client->setHeaders(['Content-Type' => 'application/json']);
      $this->client->post($url,$params);

    } catch(\Exception $e) {
      throw new \Magento\Framework\Validator\Exception(__('Payment error.'));
    }
    //To return the data ..
    //return $result->setData();

  }
}


 ?>
