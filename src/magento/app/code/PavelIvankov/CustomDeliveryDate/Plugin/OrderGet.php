<?php
declare(strict_types=1);

namespace PavelIvankov\CustomDeliveryDate\Plugin;

use Magento\Sales\Api\Data\OrderExtensionFactory;
use Magento\Framework\Exception\NoSuchEntityException;
use PavelIvankov\CustomDeliveryDate\Model\CustomDeliveryAttributeFactory;
use PavelIvankov\CustomDeliveryDate\Api\CustomDeliveryAttributeRepositoryInterface;

class OrderGet
{
    /**
     * @var OrderExtensionFactory
     */
    protected $orderExtensionFactory;

    /**
     * @var CustomDeliveryAttributeFactory
     */
    protected $customDeliveryAttributeFactory;

    /**
     * @var CustomDeliveryAttributeRepositoryInterface
     */
    protected $customDeliveryAttributeRepository;

    public function __construct(
        OrderExtensionFactory $orderExtensionFactory,
        CustomDeliveryAttributeFactory $customDeliveryAttributeFactory,
        CustomDeliveryAttributeRepositoryInterface $customDeliveryAttributeRepository
    ) {
        $this->orderExtensionFactory = $orderExtensionFactory;
        $this->customDeliveryAttributeFactory = $customDeliveryAttributeFactory;
        $this->customDeliveryAttributeRepository = $customDeliveryAttributeRepository;
    }
    public function afterGet(
        \Magento\Sales\Api\OrderRepositoryInterface $subject,
        \Magento\Sales\Api\Data\OrderInterface $resultOrder
    ) {
        $resultOrder = $this->getCustomDeliveryAttribute($resultOrder);

        return $resultOrder;
    }

    private function getCustomDeliveryAttribute(\Magento\Sales\Api\Data\OrderInterface $order)
    {

        try {
            $customDeliveryDateAttributeValue = $this->customDeliveryAttributeRepository->getValue($order->getEntityId());
        } catch (NoSuchEntityException $e) {
            return $order;
        }

        $extensionAttributes = $order->getExtensionAttributes();
        $orderExtension = $extensionAttributes ? $extensionAttributes : $this->orderExtensionFactory->create();
        $deliveryAttribute = $this->customDeliveryAttributeFactory->create();
        $deliveryAttribute->setValue($customDeliveryDateAttributeValue);
        $orderExtension->setCustomDeliveryDate($deliveryAttribute);
        $order->setExtensionAttributes($orderExtension);

        return $order;
    }
}
