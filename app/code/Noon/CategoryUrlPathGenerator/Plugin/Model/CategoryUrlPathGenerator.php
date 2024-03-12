<?php

namespace Noon\CategoryUrlPathGenerator\Plugin\Model;

use Magento\CatalogUrlRewrite\Model\CategoryUrlRewriteGenerator;
use Magento\Catalog\Api\CategoryRepositoryInterface;
use Magento\Catalog\Model\Category;

class CategoryUrlPathGenerator
{
    protected $helper;

    public function __construct(
        \Noon\CategoryUrlPathGenerator\Helper\Data $helper
    ){
        $this->helper = $helper;
    }

    /**
    *
    * @param \Magento\CatalogUrlRewrite\Model\CategoryUrlPathGenerator $subject
    * @param $path
    * @return string
    */
    public function aroundGetUrlPath(\Magento\CatalogUrlRewrite\Model\CategoryUrlPathGenerator $subject, $proceed, $category)
    {

        if (in_array($category->getParentId(), [Category::ROOT_CATEGORY_ID, Category::TREE_ROOT_ID])) {
            return '';
        }
        $path = $category->getUrlPath();
        if ($path !== null && !$category->dataHasChangedFor('url_key') && !$category->dataHasChangedFor('parent_id')) {
            return $path;
        }
        $path = $category->getUrlKey();
        if ($path === false) {
            return $category->getUrlPath();
        }
        if ($this->helper->useParentCategoties() && $this->isNeedToGenerateUrlPathForParent($category)) {
            $parentPath = $this->getUrlPath(
                $this->categoryRepository->get($category->getParentId(), $category->getStoreId())
            );
            $path = $parentPath === '' ? $path : $parentPath . '/' . $path;
        }
        return $path;

    }

}