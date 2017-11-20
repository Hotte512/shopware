<?php

namespace Shopware\CartBridge\Order;

use Shopware\Cart\Cart\CartProcessorInterface;
use Shopware\Cart\Cart\Struct\CalculatedCart;
use Shopware\Cart\Cart\Struct\CartContainer;
use Shopware\Cart\LineItem\CalculatedLineItem;
use Shopware\Cart\Price\AbsolutePriceCalculator;
use Shopware\Context\Struct\ShopContext;
use Shopware\Framework\Struct\StructCollection;

class MinimumOrderAmountProcessor implements CartProcessorInterface
{
    /**
     * @var AbsolutePriceCalculator
     */
    private $calculator;

    public function __construct(AbsolutePriceCalculator $calculator)
    {
        $this->calculator = $calculator;
    }

    public function process(
        CartContainer $cartContainer,
        CalculatedCart $calculatedCart,
        StructCollection $dataCollection,
        ShopContext $context
    ): void
    {
        if (!$context->getCustomer()) {
            return;
        }

        $customerGroup = $context->getCurrentCustomerGroup();
        if (!$customerGroup->getMinimumOrderAmount()) {
            return;
        }

        $goods = $calculatedCart->getCalculatedLineItems()->filterGoods();
        if ($goods->count() === 0) {
            return;
        }

        $prices = $goods->getPrices();

        if ($customerGroup->getMinimumOrderAmount() <= $prices->sum()->getTotalPrice()) {
            return;
        }

        $surcharge = $this->calculator->calculate(
            $customerGroup->getMinimumOrderAmountSurcharge(),
            $prices,
            $context
        );

        $calculatedCart->getCalculatedLineItems()->add(
            new CalculatedLineItem('minimum-order-value', $surcharge, 1, 'minimum-order-value')
        );
    }
}