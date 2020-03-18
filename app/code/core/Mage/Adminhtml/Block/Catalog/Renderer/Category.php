<?php
class Mage_Adminhtml_Block_Catalog_Renderer_Category extends Mage_Adminhtml_Block_Widget_Grid_Column_Renderer_Abstract
{
    public function render(Varien_Object $row)
    {
        $html = '';

        $product = Mage::getModel('catalog/product')->load($row->getId());
        $categoryIds = $product->getCategoryIds();

        foreach($categoryIds as $categoryId) {
            $category = Mage::getModel('catalog/category')->load($categoryId);

            $html .= $category->getName() . '<br>';
        }

        return $html;
    }
}
?>