<?php
namespace Bijouterie\Config\Setup\Patch\Data;

use Magento\Eav\Setup\EavSetup;
use Magento\Eav\Setup\EavSetupFactory;
use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Framework\Setup\Patch\DataPatchInterface;
use Magento\Catalog\Model\Product;

class CreateJewelryAttributesPartThree implements DataPatchInterface
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

        // jewelry_type
        $eavSetup->addAttribute(Product::ENTITY, 'jewelry_type', [
            'type' => 'int',
            'input' => 'select',
            'label' => 'Jewelry Type',
            'source' => \Magento\Eav\Model\Entity\Attribute\Source\Table::class,
            'option' => ['values' => ['Ring', 'Necklace', 'Bracelet', 'Earring', 'Pendant', 'Watch']],
            'global' => \Magento\Eav\Model\Entity\Attribute\ScopedAttributeInterface::SCOPE_GLOBAL,
            'visible' => true,
            'required' => false,
            'user_defined' => true,
            'searchable' => true,
            'filterable' => true,
            'comparable' => true,
            'visible_on_front' => true,
            'used_in_product_listing' => true,
            'group' => 'General',
        ]);

        // collection
        $eavSetup->addAttribute(Product::ENTITY, 'jewelry_collection', [
            'type' => 'varchar',
            'input' => 'text',
            'label' => 'Collection',
            'global' => \Magento\Eav\Model\Entity\Attribute\ScopedAttributeInterface::SCOPE_GLOBAL,
            'visible' => true,
            'required' => false,
            'user_defined' => true,
            'searchable' => true,
            'filterable' => false,
            'comparable' => false,
            'visible_on_front' => true,
            'used_in_product_listing' => true,
            'group' => 'General',
        ]);

        // occasion
        $eavSetup->addAttribute(Product::ENTITY, 'occasion', [
            'type' => 'text',
            'input' => 'multiselect',
            'label' => 'Occasion',
            'source' => \Magento\Eav\Model\Entity\Attribute\Source\Table::class,
            'option' => ['values' => ['Wedding', 'Birthday', 'Everyday', 'Anniversary']],
            'global' => \Magento\Eav\Model\Entity\Attribute\ScopedAttributeInterface::SCOPE_GLOBAL,
            'visible' => true,
            'required' => false,
            'user_defined' => true,
            'searchable' => true,
            'filterable' => true,
            'comparable' => false,
            'visible_on_front' => true,
            'used_in_product_listing' => false,
            'group' => 'General',
        ]);

        // is_engravable
        $eavSetup->addAttribute(Product::ENTITY, 'is_engravable', [
            'type' => 'int',
            'input' => 'boolean',
            'label' => 'Engravable',
            'source' => \Magento\Eav\Model\Entity\Attribute\Source\Boolean::class,
            'global' => \Magento\Eav\Model\Entity\Attribute\ScopedAttributeInterface::SCOPE_GLOBAL,
            'visible' => true,
            'required' => false,
            'user_defined' => true,
            'searchable' => false,
            'filterable' => true,
            'comparable' => false,
            'visible_on_front' => true,
            'used_in_product_listing' => false,
            'default' => '0',
            'group' => 'Additional',
        ]);

        // clasp_type
        $eavSetup->addAttribute(Product::ENTITY, 'clasp_type', [
            'type' => 'int',
            'input' => 'select',
            'label' => 'Clasp Type',
            'source' => \Magento\Eav\Model\Entity\Attribute\Source\Table::class,
            'option' => ['values' => ['Lobster Clasp', 'Spring Ring', 'Magnetic Clasp']],
            'global' => \Magento\Eav\Model\Entity\Attribute\ScopedAttributeInterface::SCOPE_GLOBAL,
            'visible' => true,
            'required' => false,
            'user_defined' => true,
            'searchable' => false,
            'filterable' => true,
            'comparable' => false,
            'visible_on_front' => true,
            'used_in_product_listing' => false,
            'group' => 'Size & Variants',
        ]);

        // earring_type
        $eavSetup->addAttribute(Product::ENTITY, 'earring_type', [
            'type' => 'int',
            'input' => 'select',
            'label' => 'Earring Type',
            'source' => \Magento\Eav\Model\Entity\Attribute\Source\Table::class,
            'option' => ['values' => ['Stud', 'Hoop', 'Drop', 'Clip-On']],
            'global' => \Magento\Eav\Model\Entity\Attribute\ScopedAttributeInterface::SCOPE_GLOBAL,
            'visible' => true,
            'required' => false,
            'user_defined' => true,
            'searchable' => false,
            'filterable' => true,
            'comparable' => false,
            'visible_on_front' => true,
            'used_in_product_listing' => false,
            'group' => 'Size & Variants',
        ]);

        $this->moduleDataSetup->getConnection()->endSetup();

        $eavSetup->addAttributeToGroup($entityTypeId, $attributeSetId, 'General', 'jewelry_type', 20);
        $eavSetup->addAttributeToGroup($entityTypeId, $attributeSetId, 'General', 'jewelry_collection', 30);
        $eavSetup->addAttributeToGroup($entityTypeId, $attributeSetId, 'General', 'occasion', 40);
        $eavSetup->addAttributeToGroup($entityTypeId, $attributeSetId, 'Additional', 'is_engravable', 10);
        $eavSetup->addAttributeToGroup($entityTypeId, $attributeSetId, 'Size & Variants', 'clasp_type', 20);
        $eavSetup->addAttributeToGroup($entityTypeId, $attributeSetId, 'Size & Variants', 'earring_type', 30);
    }

    public static function getDependencies()
    {
        return [
            CreateJewelryAttributesPartTwo::class,
        ];
    }

    public function getAliases()
    {
        return [];
    }
}