<?php
declare(strict_types=1);

namespace PavelIvankov\CustomDeliveryDate\Helper;

use Magento\Framework\App\Helper\AbstractHelper;
use Magento\Store\Model\ScopeInterface;

class Config extends AbstractHelper
{
    const DAYS_OFFSET_XML_PATH = 'custom_delivery_date/general/days_offset';

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
        return $this->scopeConfig->getValue(
            self::DAYS_OFFSET_XML_PATH, ScopeInterface::SCOPE_STORE, $storeId
        );
    }
}
