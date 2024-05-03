<?php
declare(strict_types=1);

namespace Dev\CustomGraphQl\Model\Resolver\Block;

use Magento\Framework\GraphQl\Query\Resolver\IdentityInterface;

/**
 * Get identities from resolved data
 */
class CustomCategoryIdentity implements IdentityInterface
{
    private $cacheTag = 'custom_category_products';

    /**
     * Get identity tags from resolved data
     *
     * @param array $resolvedData
     * @return string[]
     */
    public function getIdentities(array $resolvedData): array
    {
        $ids = [];
        $items = $resolvedData['category_product_list'] ?? [];
        foreach ($items as $item) {
            $ids[] = sprintf('%s_%s', $this->cacheTag, $item['entity_id']);
        }
        if (!empty($ids)) {
            $ids[] = $this->cacheTag;
        }
        return $ids;
    }
}
