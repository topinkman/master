<?php
namespace Bijouterie\Config\Setup\Patch\Data;

use Magento\Eav\Setup\EavSetup;
use Magento\Eav\Setup\EavSetupFactory;
use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Framework\Setup\Patch\DataPatchInterface;
use Magento\Catalog\Model\Product;

class CreateJewelryAttributesPartTwo implements DataPatchInterface
{
    private $moduleDataSetup;
    private $eavSetupFactory;

    public function __construct(
        ModuleDataSetupInterface $moduleDataSetup,
        EavSetupFactory $eavSetupFactory
    ) {
        $this->moduleDataSetup = $moduleDataSetup;
        $this->eavSetupFactory = $eavSetupFactory;
    }

    public function apply()
    {
        $this->moduleDataSetup->getConnection()->startSetup();

        /** @var EavSetup $eavSetup */
        $eavSetup = $this->eavSetupFactory->create(['setup' => $this->moduleDataSetup]);

        $entityTypeId = $eavSetup->getEntityTypeId(Product::ENTITY);
        $attributeSetId = $eavSetup->getAttributeSetId($entityTypeId, 'Jewelry');

        // karat
        $eavSetup->addAttribute(Product::ENTITY, 'karat', [
            'type' => 'int',
            'input' => 'select',
            'label' => 'Karat',
            'source' => \Magento\Eav\Model\Entity\Attribute\Source\Table::class,
            'option' => ['values' => ['585 (14K)', '750 (18K)', '925 (Sterling Silver)']],
            'global' => \Magento\Eav\Model\Entity\Attribute\ScopedAttributeInterface::SCOPE_GLOBAL,
            'visible' => true,
            'required' => false,
            'user_defined' => true,
            'searchable' => false,
            'filterable' => true,
            'comparable' => true,
            'visible_on_front' => true,
            'used_in_product_listing' => true,
            'group' => 'Materials',
        ]);

        // weight
        $eavSetup->addAttribute(Product::ENTITY, 'jewelry_weight', [
            'type' => 'decimal',
            'input' => 'text',
            'label' => 'Weight (g)',
            'global' => \Magento\Eav\Model\Entity\Attribute\ScopedAttributeInterface::SCOPE_GLOBAL,
            'visible' => true,
            'required' => false,
            'user_defined' => true,
            'searchable' => false,
            'filterable' => false,
            'comparable' => false,
            'visible_on_front' => true,
            'used_in_product_listing' => false,
            'group' => 'Materials',
        ]);

        // size
        $eavSetup->addAttribute(Product::ENTITY, 'size', [
            'type' => 'text',
            'input' => 'select',
            'label' => 'Size',
            'source' => \Magento\Eav\Model\Entity\Attribute\Source\Table::class,
            'option' => ['values' => ['50', '52', '54', '56', '58', '60', '62', '40cm', '45cm', '50cm', '60cm']],
            'global' => \Magento\Eav\Model\Entity\Attribute\ScopedAttributeInterface::SCOPE_GLOBAL,
            'visible' => true,
            'required' => false,
            'user_defined' => true,
            'searchable' => false,
            'filterable' => true,
            'comparable' => false,
            'visible_on_front' => true,
            'used_in_product_listing' => true,
            'apply_to' => 'simple,configurable',
            'group' => 'Size & Variants',
        ]);

        // gender
        $eavSetup->addAttribute(Product::ENTITY, 'gender', [
            'type' => 'int',
            'input' => 'select',
            'label' => 'Gender',
            'source' => \Magento\Eav\Model\Entity\Attribute\Source\Table::class,
            'option' => ['values' => ['Women', 'Men', 'Unisex', 'Kids']],
            'global' => \Magento\Eav\Model\Entity\Attribute\ScopedAttributeInterface::SCOPE_GLOBAL,
            'visible' => true,
            'required' => false,
            'user_defined' => true,
            'searchable' => false,
            'filterable' => true,
            'comparable' => true,
            'visible_on_front' => true,
            'used_in_product_listing' => true,
            'group' => 'Product Details',
        ]);

        $this->moduleDataSetup->getConnection()->endSetup();

        $eavSetup->addAttributeToGroup($entityTypeId, $attributeSetId, 'Materials', 'karat', 40);
        $eavSetup->addAttributeToGroup($entityTypeId, $attributeSetId, 'Materials', 'jewelry_weight', 50);
        $eavSetup->addAttributeToGroup($entityTypeId, $attributeSetId, 'Size & Variants', 'size', 10);
        $eavSetup->addAttributeToGroup($entityTypeId, $attributeSetId, 'General', 'gender', 10);
    }

    public static function getDependencies()
    {
        return [
            CreateJewelryAttributes::class,
        ];
    }

    public function getAliases()
    {
        return [];
    }
}