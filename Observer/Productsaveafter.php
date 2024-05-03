<?php

namespace Dev\CustomGraphQl\Observer;

use Magento\Framework\Event\ObserverInterface;
use Zend_Cache;
use Magento\PageCache\Model\Cache\Type;

class Productsaveafter implements ObserverInterface
{
    /**
     * @var Type
     */
    private Type $fullPageCache;

    /**
     * @param Type $fullPageCache
     */
    public function __construct(
        Type $fullPageCache
    ) {
        $this->fullPageCache = $fullPageCache;
    }

    public function execute(\Magento\Framework\Event\Observer $observer)
    {
        $_product = $observer->getProduct();
        $productId = $_product->getId();
        $tags = ['custom_category_products_'.$productId];
        if (!empty($tags)) {
            $this->fullPageCache->clean(Zend_Cache::CLEANING_MODE_MATCHING_ANY_TAG, array_unique($tags));
        }
    }
}
