<?php
declare(strict_types=1);

namespace PavelIvankov\CustomDeliveryDate\Api\Data;

interface CustomDeliveryAttributeInterface
{
    const VALUE = 'value';

    /**
     * Return value.
     *
     * @return string|null
     */
    public function getValue();

    /**
     * Set value.
     *
     * @param string|null $value
     * @return $this
     */
    public function setValue($value);
}
