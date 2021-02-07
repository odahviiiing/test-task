<?php
declare(strict_types=1);

namespace PavelIvankov\CustomDeliveryDate\Api;

interface CustomDeliveryAttributeRepositoryInterface
{
    /**
     * @param int $orderId
     * @return string
     */
    public function getValue($orderId);

    /**
     * @param string $value
     * @param int $orderId
     * @return void
     */
    public function saveValue($value, $orderId);
}
