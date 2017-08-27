<?php

namespace Yireo\ExampleAddressFieldComment\Setup;

use Magento\Framework\Exception\AlreadyExistsException;
use Magento\Framework\Setup\InstallDataInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Customer\Setup\CustomerSetupFactory;
use Magento\Eav\Api\AttributeRepositoryInterface;

/**
 * Class InstallData
 *
 * @package Yireo\ExampleAddressFieldComment\Setup
 */
class InstallData implements InstallDataInterface
{
    /**
     * @var CustomerSetupFactory
     */
    private $customerSetupFactory;

    /**
     * @var AttributeRepositoryInterface
     */
    private $attributeRepository;

    /**
     * Constructor
     *
     * @param CustomerSetupFactory $customerSetupFactory
     * @param AttributeRepositoryInterface $attributeRepository
     */
    public function __construct(
        CustomerSetupFactory $customerSetupFactory,
        AttributeRepositoryInterface $attributeRepository
    )
    {
        $this->customerSetupFactory = $customerSetupFactory;
        $this->attributeRepository = $attributeRepository;
    }

    /**
     * @param ModuleDataSetupInterface $setup
     * @param ModuleContextInterface $context
     */
    public function install(ModuleDataSetupInterface $setup, ModuleContextInterface $context)
    {
        $setup->startSetup();
        $this->addCommentAttribute($setup);
        $setup->endSetup();
    }

    /**
     * @param $setup
     *
     * @return bool
     */
    private function addCommentAttribute($setup)
    {
        if ($this->checkIfAttributeExists('comment')) {
            return false;
        }

        $customerSetup = $this->customerSetupFactory->create(['setup' => $setup]);
        $customerSetup->addAttribute('customer_address', 'comment',  [
            'label' => 'Example Comment',
            'type' => 'varchar',
            'input' => 'textarea',
            'position' => 98,
            'visible' => true,
            'required' => false,
            'system' => 0
        ]);

        $commentAttribute = $customerSetup->getEavConfig()->getAttribute('customer_address', 'comment');
        $commentAttribute->setData(
            'used_in_forms',
            ['adminhtml_customer_address', 'customer_address_edit', 'customer_register_address']
        );

        try {
            $commentAttribute->save();
        } catch(AlreadyExistsException $exception) {
            return true;
        }

        return true;
    }

    /**
     * @param $attributeCode
     *
     * @return bool
     */
    private function checkIfAttributeExists($attributeCode)
    {
        try {
            return (bool) $this->attributeRepository->get('customer_address', $attributeCode);
        } catch (\Magento\Framework\Exception\NoSuchEntityException $e) {
            return false;
        }
    }
}