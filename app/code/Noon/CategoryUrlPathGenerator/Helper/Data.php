<?php
namespace Noon\CategoryUrlPathGenerator\Helper;

class Data extends \Magento\Framework\App\Helper\AbstractHelper
{
    const XML_PATH_CATEGORY_USE_PARENT_CATEGORIES = 'catalog/seo/category_use_parent_categories';

    /**
     *
     * @var \Magento\Framework\App\Config\ScopeConfigInterface
     */
    protected $scopeConfig;

    /**
     *
     * @param \Magento\Framework\App\Helper\Context $context
     * @param \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig
     */
    public function __construct(
        \Magento\Framework\App\Helper\Context $context,
        \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig
    ) {
        parent::__construct($context);
        $this->scopeConfig = $scopeConfig;
    }

    /**
     *
     * @return boolean
     */
    public function useParentCategoties()
    {
        if ($this->scopeConfig->getValue(self::XML_PATH_CATEGORY_USE_PARENT_CATEGORIES, \Magento\Store\Model\ScopeInterface::SCOPE_STORE)) {
            return true;
        }
        return false;
    }
}

