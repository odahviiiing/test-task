<?php
declare(strict_types=1);

namespace PavelIvankov\CustomDeliveryDate\Helper;

use Magento\Framework\App\Helper\AbstractHelper;
use Magento\Store\Model\ScopeInterface;

class Config extends AbstractHelper
{
    const DAYS_OFFSET_XML_PATH = 'custom_delivery_date/general/days_offset';
    const CUSTOM_DELIVERY_FIELD_NAME = 'custom_delivery_date';

    /**
     * @param \Magento\Framework\App\Helper\Context $context
     */
    public function __construct(
        \Magento\Framework\App\Helper\Context $context
    ) {
        parent::__construct($context);
    }

    public function getDaysOffset($storeId = null)
    {
        return (int)$this->scopeConfig->getValue(
            self::DAYS_OFFSET_XML_PATH, ScopeInterface::SCOPE_STORE, $storeId
        );
    }

    public function getCustomDeliveryFieldName()
    {
        return self::CUSTOM_DELIVERY_FIELD_NAME;
    }

    public function addDaysOffset($createdAt, $daysOffset)
    {
        $dateTime = new \DateTime($createdAt);
        $daysInterval = new \DateInterval('P' . $daysOffset . 'D');
        return $dateTime->add($daysInterval)->format('Y-m-d H:i:s');
    }
}
