<?php
namespace Yireo\ExampleAddressFieldComment\Block\Address\Edit\Field;

use Magento\Framework\View\Element\Template;

/**
 * Class Comment
 *
 * @package Yireo\ExampleAddressFieldComment\Block\Address\Edit\Field
 */
class Comment extends Template
{
    /**
     * @var string
     */
    protected $_template = 'address/edit/field/comment.phtml';

    /**
     * @var \Magento\Customer\Api\Data\AddressInterface
     */
    protected $_address;

    /**
     * @return string
     */
    public function getCommentValue()
    {
        /** @var \Magento\Customer\Model\Data\Address $address */
        $address = $this->getAddress();
        $commentValue = $address->getCustomAttribute('comment');

        if (!$commentValue instanceof \Magento\Framework\Api\AttributeInterface) {
            return '';
        }

        return $commentValue->getValue();
    }

    /**
     * Return the associated address.
     *
     * @return \Magento\Customer\Api\Data\AddressInterface
     */
    public function getAddress()
    {
        return $this->_address;
    }

    /**
     * Set the associated address.
     *
     * @param \Magento\Customer\Api\Data\AddressInterface $address
     */
    public function setAddress($address)
    {
        $this->_address = $address;
    }
}