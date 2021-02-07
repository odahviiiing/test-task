<?php
declare(strict_types=1);

namespace PavelIvankov\CustomDeliveryDate\Plugin;

use Magento\Sales\Api\Data\OrderExtensionFactory;
use Magento\Framework\Exception\CouldNotSaveException;
use PavelIvankov\CustomDeliveryDate\Helper\Config as HelperConfig;
use PavelIvankov\CustomDeliveryDate\Model\CustomDeliveryAttributeFactory;
use PavelIvankov\CustomDeliveryDate\Api\CustomDeliveryAttributeRepositoryInterface;

class OrderSave
{
    /**
     * @var HelperConfig
     */
    protected $helperConfig;

    /**
     * @var CustomDeliveryAttributeRepositoryInterface
     */
    protected $customDeliveryAttributeRepository;

    public function __construct(
        HelperConfig $helperConfig,
        CustomDeliveryAttributeRepositoryInterface $customDeliveryAttributeRepository
    ) {
        $this->helperConfig = $helperConfig;
        $this->customDeliveryAttributeRepository = $customDeliveryAttributeRepository;
    }

    public function afterSave(
        \Magento\Sales\Api\OrderRepositoryInterface $subject,
        \Magento\Sales\Api\Data\OrderInterface $resultOrder
    ) {
        $resultOrder = $this->saveCustomDeliveryAttribute($resultOrder);

        return $resultOrder;
    }

    private function saveCustomDeliveryAttribute(\Magento\Sales\Api\Data\OrderInterface $order)
    {
        $createdAt = $order->getCreatedAt();
        $daysOffset = $this->helperConfig->getDaysOffset($order->getStoreId());
        $customDeliveryValue = $this->helperConfig->addDaysOffset($createdAt, $daysOffset);
        try {
            $this->customDeliveryAttributeRepository->saveValue($customDeliveryValue, $order->getEntityId());
        } catch (\Exception $e) {
            throw new CouldNotSaveException(
                __('Could not add attribute to order: "%1"', $e->getMessage()),
                $e
            );
        }

        return $order;
    }
}
