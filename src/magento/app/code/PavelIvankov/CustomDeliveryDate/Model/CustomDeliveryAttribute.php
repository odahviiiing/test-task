<?php
declare(strict_types=1);

namespace PavelIvankov\CustomDeliveryDate\Model;

use Magento\Framework\Model\AbstractModel;
use PavelIvankov\CustomDeliveryDate\Api\Data\CustomDeliveryAttributeInterface;

class CustomDeliveryAttribute extends AbstractModel implements CustomDeliveryAttributeInterface
{
    /**
     * {@inheritdoc}
     */
    public function getValue()
    {
        return $this->getData(self::VALUE);
    }

    /**
     * {@inheritdoc}
     */
    public function setValue($value)
    {
        return $this->setData(self::VALUE, $value);
    }
}
