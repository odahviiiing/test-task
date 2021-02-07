<?php
declare(strict_types=1);

namespace PavelIvankov\CustomDeliveryDate\Model;

use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\NoSuchEntityException;
use PavelIvankov\CustomDeliveryDate\Api\CustomDeliveryAttributeRepositoryInterface;
use Magento\Sales\Model\ResourceModel\Order as OrderResource;
use PavelIvankov\CustomDeliveryDate\Helper\Config as HelperConfig;
use Psr\Log\LoggerInterface;

class CustomDeliveryAttributeRepository implements CustomDeliveryAttributeRepositoryInterface
{
    /**
     * @var OrderResource
     */
    protected $orderResource;

    /**
     * @var HelperConfig
     */
    protected $helperConfig;

    /**
     * @var LoggerInterface
     */
    protected $logger;

    public function __construct(
        OrderResource $orderResource,
        HelperConfig $helperConfig,
        LoggerInterface $logger
    ) {
        $this->orderResource = $orderResource;
        $this->helperConfig = $helperConfig;
        $this->logger = $logger;
    }

    public function getValue($orderId)
    {
        try {
            $connection = $this->orderResource->getConnection();
            $select = $connection->select()
                ->from($this->orderResource->getMainTable(), $this->helperConfig->getCustomDeliveryFieldName())
                ->where($this->orderResource->getIdFieldName() . ' = ?', $orderId)
            ;
            $customDeliveryDate = $connection->fetchOne($select);

            return $customDeliveryDate;
        } catch (\Exception $e) {
            $this->logger->error('PavelIvankov_CustomDeliveryDat: get custom delivery date error: ' . $e->getMessage());
            throw new NoSuchEntityException();
        }
    }

    public function saveValue($value, $orderId)
    {
        try {
            $connection = $this->orderResource->getConnection();
            $connection->update(
                $this->orderResource->getMainTable(),
                [$this->helperConfig->getCustomDeliveryFieldName() => $value],
                [$this->orderResource->getIdFieldName() . ' = ?' => $orderId]
            );
        } catch (\Exception $e) {
            $this->logger->error('PavelIvankov_CustomDeliveryDat: save custom delivery date error: ' . $e->getMessage());
            throw new CouldNotSaveException(__($e->getMessage()));
        }
    }
}
