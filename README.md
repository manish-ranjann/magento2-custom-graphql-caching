## Graphql Caching In Magento 2

Caching improves response time and also reduces the load on the server. but without caching, each page might need to 
run blocks of code and retrieve large amounts of information from the database. basically queries submit with an 
HTTP GET operation can be cache. POST queries cannot be cache.


```graphql-query
{
    categoryProductlist(categoryId: 2, pageSize: 20, currentPage: 1) {
        totalCount
        category_product_list {
            entity_id
            type_id
            sku
            name
            image
            status
            visibility
            price
        }
    }
}
```

### Resolver
A resolver performs GraphQL request processing. resolver construct a query, fetching data and performing any calculations.

Resolver transforms the fetched and calculated data into a GraphQL array format and returns the results wrapped by a callable function

In headers X-Magento-Cache-Debug : MISS that means query is not cache.
We can achieve this by creating a GET request and use graphql query in it like below because POST requests cannot be cache.

Request Type =>GET

{{base_url}}/graphql?query={categoryProductlist(categoryId: 2, pageSize: 20, currentPage: 1) {totalCount category_product_list {entity_id type_id sku name image status visibility price } } }


### @cache Directive
The @cache directive defines whether the results of certain queries can be cached.

The cacheIdentity value points to the class responsible for retrieving cache tags.

Additionally query without a cacheIdentity will not be cached.

To disable caching for queries declared in another module with a cacheIdentity class, 
the @cache(cacheable: false) directive can be used. This cacheable argument is intended to disable caching for queries that are defined in another module.

Specifying @cache(cacheable: false) or @cache(cacheable: true) on a query without a cacheIdentity class has no effect. 
The query will not be cache. If a query should not be cached, do not specify the @cache directive.
