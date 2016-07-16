<?php

namespace Drupal\commerce_invoice\Entity;

use Drupal\commerce_invoice\InvoiceNumber\InvoiceNumber;
use Drupal\commerce_invoice\InvoiceNumber\Strategy\StrategyInterface;

class Invoice extends \Entity {

  public $invoice_id;
  public $revision_id;
  public $type = 'commerce_invoice';
  public $order_id;
  public $order_revision_id;
  public $number_strategy;
  public $number_sequence;
  public $number_key;
  public $uid;
  public $invoice_date;
  public $invoice_status;
  public $quantity;
  public $created;
  public $changed;
  public $revision_created;
  public $revision_uid;
  public $log;

  /**
   * @todo bundle settings logic
   *
   * @return StrategyInterface
   */
  public function getNumberStrategy() {
    $strategyName = $this->number_strategy ?: 'monthly';
    foreach (commerce_invoice_number_strategies() as $strategy) {
      if ($strategy->getName() === $strategyName) {
        return $strategy;
      }
    }

    throw new \RuntimeException('Invoice number strategy not found: ' . $strategyName);
  }

  /**
   * @param InvoiceNumber $number
   */
  public function setInvoiceNumber(InvoiceNumber $number) {
    $this->number_key = $number->getKey();
    $this->number_sequence = $number->getSequence();
    $this->number_strategy = $number->getStrategyName();
  }

  /**
   * @return bool
   */
  public function hasInvoiceNumber() {
    return isset($this->number_sequence);
  }

}