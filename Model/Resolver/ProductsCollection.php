<?php

declare(strict_types=1);

namespace Dev\CustomGraphQl\Model\Resolver;

use Magento\Catalog\Model\CategoryFactory;
use Magento\Framework\GraphQl\Config\Element\Field;
use Magento\Framework\GraphQl\Exception\GraphQlNoSuchEntityException;
use Magento\Framework\GraphQl\Schema\Type\ResolveInfo;
use Magento\Framework\GraphQl\Query\ResolverInterface;

class ProductsCollection implements ResolverInterface
{
    /**
     * @var CategoryFactory
     */
    private CategoryFactory $categoryFactory;

    /**
     * @inheritdoc
     */
    public function __construct(
        CategoryFactory $categoryFactory,
    ) {
        $this->categoryFactory = $categoryFactory;
    }

    /**
     * @return array
     * @throws GraphQlNoSuchEntityException
     */
    public function resolve(Field $field, $context, ResolveInfo $info, array $value = null, array $args = null)
    {
        try {
            $category = $this->categoryFactory->create();
            $category->load($args['categoryId']);
            $products = $category->getProductCollection()->distinct(true);
            $products->addAttributeToSelect('*');
            $productCount = count($products);
            $products->setPageSize($args['pageSize'] ?? 10);
            $products->setCurPage($args['currentPage'] ?? 1);
            $productList = [];
            foreach ($products as $product) {
                $eachProduct = [];
                $eachProduct = $product->toArray();
                $productList[] = $eachProduct;
            }

            $productRecord['totalCount'] = $productCount;
            $productRecord['category_product_list'] = $productList;

        } catch (NoSuchEntityException $e) {
            throw new GraphQlNoSuchEntityException(__($e->getMessage()), $e);
        }
        return $productRecord;
    }


}
