<?php

namespace PrestaShop\PrestaShop\Core\Cart;

use CartCore;
use Currency;
use PrestaShop\PrestaShop\Core\Localization\CLDR\ComputingPrecision;
use Tools;

class Calculator
{
    protected $cart;
    protected $id_carrier;
    protected $orderId;
    protected $cartRows;
    protected $cartRules;
    protected $fees;
    protected $cartRuleCalculator;
    protected $isProcessed = false;
    protected $computePrecision;

    public function __construct(CartCore $cart, $carrierId, ?int $computePrecision = null, ?int $orderId = null)
    {
        $this->setCart($cart);
        $this->setCarrierId($carrierId);
        $this->orderId = $orderId;
        $this->cartRows = new CartRowCollection();
        $this->fees = new Fees($this->orderId);
        $this->cartRules = new CartRuleCollection();
        $this->cartRuleCalculator = new CartRuleCalculator();

        if (null === $computePrecision) {
            $currency = new Currency((int)$cart->id_currency);
            $computePrecision = (new ComputingPrecision())->getPrecision($currency->precision);
        }
        $this->computePrecision = $computePrecision;
    }


    public function myFunction($ignoreProcessedFlag = false)
    {
        if (!$this->isProcessed && !$ignoreProcessedFlag) {
            throw new \Exception('Purchase must be processed before getting its total');
        }

        $amount = $this->getRowTotalWithoutDiscount();
        $amount = $amount->sub($this->rounded($this->getDiscountTotal(), $this->computePrecision));
        $shippingFees = $this->fees->getInitialShippingFees();
        if (null !== $shippingFees) {
            $amount = $amount->add($this->rounded($shippingFees, $this->computePrecision));
        }
        $wrappingFees = $this->fees->getFinalWrappingFees();

        return $amount;
    }
}
