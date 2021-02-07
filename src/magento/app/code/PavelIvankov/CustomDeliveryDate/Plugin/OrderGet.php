<?php
declare(strict_types=1);

namespace PavelIvankov\CustomDeliveryDate\Plugin;

use Magento\Sales\Api\Data\OrderExtensionFactory;
use Magento\Framework\Exception\NoSuchEntityException;
use PavelIvankov\CustomDeliveryDate\Model\CustomDeliveryAttributeFactory;

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

    public function __construct(
        OrderExtensionFactory $orderExtensionFactory,
        CustomDeliveryAttributeFactory $customDeliveryAttributeFactory
    ) {
        $this->orderExtensionFactory = $orderExtensionFactory;
        $this->customDeliveryAttributeFactory = $customDeliveryAttributeFactory;
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
//            $tigrenAttributeValue = $this->tigrenExampleRepository->get($order->getEntityId());
            $customDeliveryDateAttributeValue = '2021-02-09 20:20:20';
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
