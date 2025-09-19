<?php

namespace Netzkollektiv\EasyCreditOverwriteAddress\Plugin;

use Netzkollektiv\EasyCredit\BackendApi\QuoteBuilder;
use Teambank\EasyCreditApiV3\Model\Transaction;

class QuoteBuilderPlugin
{
    /**
     * After plugin for QuoteBuilder::build()
     *
     * @param QuoteBuilder $subject
     * @param Transaction $result
     * @return Transaction
     */
    public function afterBuild(QuoteBuilder $subject, Transaction $result): Transaction
    {
        $orderDetails = $result->getOrderDetails();
        $customerRelationship = $result->getCustomerRelationship();

        if ($orderDetails && $orderDetails->getInvoiceAddress() && $customerRelationship) {
            $shippingMethod = $customerRelationship->getLogisticsServiceProvider() ?: '';

            // Replace shipping address with billing address only if Click & Collect
            if (stripos($shippingMethod, '[Selbstabholung]') !== false) {
                $orderDetails->setShippingAddress($orderDetails->getInvoiceAddress());
                $result->setOrderDetails($orderDetails);
            }
        }

        return $result;
    }
}
