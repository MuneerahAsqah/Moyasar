<?php

namespace Moyasar\STCpay\Controller\STCpay;

use Magento\Checkout\Model\Session;
use Magento\Framework\App\Action\Context;
use Magento\Framework\Controller\ResultFactory;
use Magento\Sales\Model\Order;
use Magento\Framework\App\ResponseInterface;
use \Magento\Framework\App\Action\Action;
use \Moyasar\STCpay\Helper\Data;


class PostData extends Action
{

  public function __construct(
    Context $context,
    Data $dataHelper, //to get the system.xml configuration data
    Session $checkoutSession,
    \Magento\Framework\UrlInterface $urlBuilder,
    \Magento\Framework\Controller\Result\JsonFactory $resultJsonFactory,
    \Magento\Directory\Model\CountryFactory $countryFactory,
    \Magento\Sales\Api\OrderRepositoryInterface $orderRepository,
    \Magento\Framework\HTTP\ClientInterface $client
    ) {
      parent::__construct($context);
      $this->dataHelper = $dataHelper;
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

    $amount = $qouteData->getGrandTotal();
    //$email = $order->getCustomerEmail();
    //$mobile = $this->getRequest()->getPost('mobile');

    $form_action_url = "https://api.moyasar.com/v1/payments";
    $publishable_api_key = $this->dataHelper->getConfig("payment/stcpay/publishable_api_key"); //system.xml (section_id/group_id/field_id)


      $post_data = array(
          'action' => $form_action_url,
          'fields' => array (
            'publishable_api_key' => $publishable_api_key,
            'amount' => $amount * 100,
            'currency' => 'SAR',
            //'description' => $email,
            'source' => array(
              'type' => 'stcpay',
              'mobile' => $mobile)
          )
      );

      $result = $this->resultJsonFactory->create();
      return $result->setData($post_data);

  }
}


 ?>
