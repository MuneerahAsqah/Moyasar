<?php

namespace Moyasar\STCpay\Observer;
use Magento\Framework\Event\ObserverInterface;
use Psr\Log\LoggerInterface;

class OrdedataObserver implements ObserverInterface {
  protected $logger;

  public function __construct(LoggerInterface $logger) {
    $this->logger = $logger;
  }

  public function execute(\Magento\Framework\Event\Observer $observer) {
    try {
      $order = $observer->getEvent()->getOrder();
    } catch (\Exception $e) {
      $this->logger->info($e->getMessage());
    }
  }
}

 ?>
