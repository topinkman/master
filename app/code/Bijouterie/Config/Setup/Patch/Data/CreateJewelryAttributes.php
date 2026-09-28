<?php
namespace Bijouterie\Config\Setup\Patch\Data;

use Magento\Eav\Setup\EavSetup;
use Magento\Eav\Setup\EavSetupFactory;
use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Framework\Setup\Patch\DataPatchInterface;
use Magento\Catalog\Model\Product;

class CreateJewelryAttributes implements DataPatchInterface
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

        // material
        $eavSetup->addAttribute(Product::ENTITY, 'material', [
            'type' => 'text',
            'input' => 'multiselect',
            'label' => 'Material',
            'source' => \Magento\Eav\Model\Entity\Attribute\Source\Table::class,
            'option' => ['values' => ['Gold', 'Silver', 'Platinum', 'Stainless Steel', 'Titanium', 'Gold Plated']],
            'global' => \Magento\Eav\Model\Entity\Attribute\ScopedAttributeInterface::SCOPE_GLOBAL,
            'visible' => true,
            'required' => false,
            'user_defined' => true,
            'searchable' => true,
            'filterable' => true,
            'comparable' => true,
            'visible_on_front' => true,
            'used_in_product_listing' => true,
            'group' => 'Materials',
        ]);

        // gemstone
        $eavSetup->addAttribute(Product::ENTITY, 'gemstone', [
            'type' => 'text',
            'input' => 'multiselect',
            'label' => 'Gemstone',
            'source' => \Magento\Eav\Model\Entity\Attribute\Source\Table::class,
            'option' => ['values' => ['Diamond', 'Sapphire', 'Ruby', 'Emerald', 'Pearl', 'Cubic Zirconia', 'No Stone']],
            'global' => \Magento\Eav\Model\Entity\Attribute\ScopedAttributeInterface::SCOPE_GLOBAL,
            'visible' => true,
            'required' => false,
            'user_defined' => true,
            'searchable' => true,
            'filterable' => true,
            'comparable' => true,
            'visible_on_front' => true,
            'used_in_product_listing' => true,
            'group' => 'Materials',
        ]);

        // metal_color
        $eavSetup->addAttribute(Product::ENTITY, 'metal_color', [
            'type' => 'int',
            'input' => 'select',
            'label' => 'Metal Color',
            'source' => \Magento\Eav\Model\Entity\Attribute\Source\Table::class,
            'option' => ['values' => ['Yellow Gold', 'White Gold', 'Rose Gold', 'Silver', 'Black']],
            'global' => \Magento\Eav\Model\Entity\Attribute\ScopedAttributeInterface::SCOPE_GLOBAL,
            'visible' => true,
            'required' => false,
            'user_defined' => true,
            'searchable' => false,
            'filterable' => true,
            'comparable' => true,
            'visible_on_front' => true,
            'used_in_product_listing' => true,
            'apply_to' => 'simple,configurable',
            'group' => 'Materials',
        ]);

        $this->moduleDataSetup->getConnection()->endSetup();

        // assign to attribute set/group
        $eavSetup->addAttributeToGroup($entityTypeId, $attributeSetId, 'Materials', 'material', 10);
        $eavSetup->addAttributeToGroup($entityTypeId, $attributeSetId, 'Materials', 'gemstone', 20);
        $eavSetup->addAttributeToGroup($entityTypeId, $attributeSetId, 'Materials', 'metal_color', 30);
    }

    public static function getDependencies()
    {
        return [
            CreateJewelryAttributeSet::class,
        ];
    }

    public function getAliases()
    {
        return [];
    }
}