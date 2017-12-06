<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace Magento\GraphQl\Model;

use Magento\Authorization\Model\UserContextInterface;
use Magento\Framework\Api\AttributeValueFactory;
use Magento\Framework\Api\ExtensionAttributesFactory;

class Context extends \Magento\Framework\Model\AbstractExtensibleModel implements ContextInterface
{
    /**#@+
     * Constants defined for type of context
     */
    const CUSTOMER_TYPE_ID   = 'customer_type';
    const CUSTOMER_ID = 'customer_id';
    /**#@-*/

    /**
     * @var UserContextInterface
     */
    private $userContext;

    /**
     * @param \Magento\Framework\Model\Context $context
     * @param \Magento\Framework\Registry $registry
     * @param ExtensionAttributesFactory $extensionFactory
     * @param AttributeValueFactory $customAttributeFactory
     * @param UserContextInterface|null $userContext
     * @param array $data
     */
    public function __construct(
        \Magento\Framework\Model\Context $context,
        \Magento\Framework\Registry $registry,
        ExtensionAttributesFactory $extensionFactory,
        AttributeValueFactory $customAttributeFactory,
        UserContextInterface $userContext,
        array $data = []
    ) {
        parent::__construct(
            $context,
            $registry,
            $extensionFactory,
            $customAttributeFactory
        );
        if (isset($data['id'])) {
            $this->setId($data['id']);
        }
        if (isset($data['type'])) {
            $this->setId($data['type']);
        }
        $this->userContext = $userContext;
    }

    /**
     * {@inheritdoc}
     *
     * @return \Magento\GraphQl\Model\ContextInterfaceExtensionInterface||null
     */
    public function getExtensionAttributes()
    {
        return $this->_getExtensionAttributes();
    }

    /**
     * {@inheritdoc}
     *
     * @param \Magento\GraphQl\Model\ContextInterfaceExtensionInterface $extensionAttributes
     * @return $this
     */
    public function setExtensionAttributes(\Magento\GraphQl\Model\ContextInterfaceExtensionInterface $extensionAttributes)
    {
        return $this->_setExtensionAttributes($extensionAttributes);
    }

    /**
     * @inheritDoc
     */
    public function getCustomerId()
    {
        if (!$this->getData(self::CUSTOMER_ID)) {
            $this->setCustomerId((int) $this->userContext->getUserId());
        }
        return (int) $this->getData(self::CUSTOMER_ID);
    }

    /**
     * @inheritDoc
     */
    public function setCustomerId(int $customerId)
    {
        return $this->setData(self::CUSTOMER_ID, $customerId);
    }

    /**
     * @inheritDoc
     */
    public function getCustomerType()
    {
        if (!$this->getData(self::CUSTOMER_TYPE_ID)) {
            $this->setCustomerType($this->userContext->getUserType());
        }
        return (int) $this->getData(self::CUSTOMER_TYPE_ID);
    }

    /**
     * @inheritDoc
     */
    public function setCustomerType(int $typeId)
    {
        return $this->setData(self::CUSTOMER_ID, $typeId);
    }
}
