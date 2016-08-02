<?php
/**
 * Created by IntelliJ IDEA.
 * User: tonyxu
 * Date: 31/07/2016
 * Time: 7:33 PM
 */

namespace Menulog\Mapper;


use Menulog\Model\Menu;
use Menulog\Model\Product;
use Menulog\Model\ProductCategory;
use Menulog\Model\Restaurant;
use Menulog\Model\Image;
use Zend\Cache\Storage\Adapter\AbstractAdapter as AbstractCacheAdapter;
use Zend\Http\Client;
use Zend\Http\Request;

class JeApi implements RestaurantsMapperInterface
{

    /**
     * @var string $baseUri
     */
    protected $baseUri;

    /**
     * @var Client $httpClient
     */
    protected $httpClient;

    /**
     * @var array $httpHeaders
     */
    protected $httpHeaders;

    /**
     * @var array $httpOptions
     */
    protected $httpOptions;

    /**
     * @var $cache
     */
    protected $cache;


    /**
     * @param Client $httpClient
     * @param AbstractCacheAdapter $cache
     */
    public function __construct(Client $httpClient, AbstractCacheAdapter $cache)
    {
        $this->baseUri = "https://public.je-apis.com";

        $this->httpHeaders = array(
            'Accept-Tenant' => 'uk',
            'Accept-Language' => 'en-GB',
            'Accept-Charset' => 'utf-8',
            'Authorization' => 'Basic VGVjaFRlc3RBUEk6dXNlcjI=',
            'Host' => 'public.je-apis.com',
        );
        $this->httpOptions = array(
            'maxredirects' => 0,
            'timeout'      => 5
        );

        $this->httpClient = $httpClient;
        $this->cache = $cache;
    }

    /**
     * @param $postcode
     * @return mixed
     */
    public function getRestaurants($postcode)
    {
        $redisKey = 'restaurants_postcode_'.$postcode;

        if ($this->cache->hasItem($redisKey) && $this->cache->getItem($redisKey)) {

            $result = $this->cache->getItem($redisKey);

        } else {
            $uri = $this->baseUri.'/restaurants';
            $requestParams = array(
                'q' => urlencode($postcode)
            );
            $httpMethod = Request::METHOD_GET;
            $result = $this->sendHttpRequest($uri, $httpMethod, $requestParams);
            // if response has content, we save to redis for 1 hour
            if ($result) {
                $this->cache->getOptions()->setTtl(60*60); // save for 1 hour
                $this->cache->setItem($redisKey, $result);
            }
        }

        $restaurants = array();
        if ($result) {
            // parse the json
            $resultDecode = json_decode($result, true);
            if ($resultDecode && array_key_exists('Restaurants', $resultDecode)) {
                foreach($resultDecode['Restaurants'] as $restaurantArr){
                    if ($restaurantArr['IsOpenNowForDelivery'] == true){
                        $restaurant = new Restaurant();
                        $restaurant->setId($restaurantArr['Id']);
                        $restaurant->setName($restaurantArr['Name']);
                        $restaurant->setUniqueName($restaurantArr['UniqueName']);
                        $logo = new Image();
                        $logo->setStandardResolutionURL($restaurantArr['Logo'][0]['StandardResolutionURL']);
                        $restaurant->setLogo($logo);
                        $restaurant->setRatingAverage($restaurantArr['RatingAverage']);
                        $restaurant->setIsOpenNowForDelivery($restaurantArr['IsOpenNowForDelivery']);
                        $restaurants[] = $restaurant;
                    }
                }
            }
        }
        return $restaurants;
    }

    /**
     * @param $restaurantId
     * @return mixed
     */
    public function getRestaurantMenus($restaurantId)
    {
        $redisKey = 'restaurant_menus_'.$restaurantId;

        if ($this->cache->hasItem($redisKey) && $this->cache->getItem($redisKey)) {

            $result = $this->cache->getItem($redisKey);
        } else {
            $uri = $this->baseUri.'/restaurants/'.$restaurantId.'/menus';
            $requestParams = array();
            $httpMethod = Request::METHOD_GET;
            $result = $this->sendHttpRequest($uri, $httpMethod, $requestParams);
            if ($result) {
                $this->cache->getOptions()->setTtl(60*60); // save for 1 hour
                $this->cache->setItem($redisKey, $result);
            }
        }

        $menus = array();
        if ($result) {
            $resultDecode = json_decode($result, true);
            if ($resultDecode && array_key_exists('Menus', $resultDecode)) {
                foreach($resultDecode['Menus'] as $menuArr){
                    $menu = new Menu();
                    $menu->setId($menuArr['Id']);
                    $menu->setTitle($menuArr['Title']);
                    $menu->setDescription($menuArr['Description']);
                    $menus[] = $menu;
                }
            }
        }

        return $menus;
    }

    /**
     * @param $menuId
     * @return mixed
     */
    public function getRestaurantMenuCategories($menuId)
    {
        $redisKey = 'menu_'.$menuId.'_categories';

        if ($this->cache->hasItem($redisKey) && $this->cache->getItem($redisKey)) {

            $result = $this->cache->getItem($redisKey);
        } else {

            $uri = $this->baseUri.'/menus/'.$menuId.'/productcategories';
            $requestParams = array();
            $httpMethod = Request::METHOD_GET;
            $result = $this->sendHttpRequest($uri, $httpMethod, $requestParams);
            if ($result) {
                $this->cache->getOptions()->setTtl(60*60); // save for 1 hour
                $this->cache->setItem($redisKey, $result);
            }
        }

        $productCategories = array();
        if ($result) {
            $resultDecode = json_decode($result, true);
            if ($resultDecode && array_key_exists('Categories', $resultDecode)) {
                foreach($resultDecode['Categories'] as $category){
                    $productCategory = new ProductCategory();
                    $productCategory->setId($category['Id']);
                    $productCategory->setName($category['Name']);
                    $productCategories[] = $productCategory;
                }
            }
        }

        return $productCategories;
    }

    /**
     * @param $menuId
     * @param $productCategoryId
     * @return mixed
     */
    public function getRestaurantMenuProductCategoryProducts($menuId, $productCategoryId)
    {
        $redisKey = 'menu_'.$menuId.'_category_'.$productCategoryId.'_products';

        if ($this->cache->hasItem($redisKey) && $this->cache->getItem($redisKey)) {

            $result = $this->cache->getItem($redisKey);
        } else {
            $uri = $this->baseUri.'/menus/'.$menuId.'/productcategories/'.$productCategoryId.'/products';
            $requestParams = array();
            $httpMethod = Request::METHOD_GET;
            $result = $this->sendHttpRequest($uri, $httpMethod, $requestParams);
            if ($result) {
                $this->cache->getOptions()->setTtl(60*60); // save for 1 hour
                $this->cache->setItem($redisKey, $result);
            }
        }

        $products = array();
        if ($result) {
            $resultDecode = json_decode($result, true);
            if ($resultDecode && array_key_exists('Products', $resultDecode)) {
                foreach($resultDecode['Products'] as $productArr){
                    $product = new Product();
                    $product->setId($productArr['Id']);
                    $product->setName($productArr['Name']);
                    $product->setDescription($productArr['Description']);
                    $product->setPrice($productArr['Price']);
                    $product->setSynonym($productArr['Synonym']);
                    $products[] = $product;
                }
            }
        }


        return $products;
    }

    /**
     * @param int $restaurantId
     * @return mixed
     */
    public function getRestaurantDetails($restaurantId)
    {
        $redisKey = 'restaurant_details_'.$restaurantId;

        if ($this->cache->hasItem($redisKey) && $this->cache->getItem($redisKey)) {

            $result = $this->cache->getItem($redisKey);

        } else {
            $uri = $this->baseUri.'/restaurants/'.$restaurantId.'/details';
            $requestParams = array();
            $httpMethod = Request::METHOD_GET;
            $result = $this->sendHttpRequest($uri, $httpMethod, $requestParams);

            if ($result) {
                $this->cache->getOptions()->setTtl(60*60); // save for 1 hour
                $this->cache->setItem($redisKey, $result);
            }
        }

        $restaurant = new Restaurant();
        if ($result) {
            $resultDecode = json_decode($result, true);
            if ($resultDecode && array_key_exists('Id', $resultDecode)) {
                $restaurant->setId($restaurantId);
                $restaurant->setDescription($resultDecode['Description']);
            }
        }

        return $restaurant;
    }


    /**
     * @param $uri
     * @param $httpMethod
     * @param $requestParams
     * @return mixed
     */
    private function sendHttpRequest($uri, $httpMethod, $requestParams){
        $this->httpClient->setUri($uri);
        $this->httpClient->setMethod($httpMethod);
        if ($httpMethod == Request::METHOD_GET){
            $this->httpClient->setParameterGet($requestParams);
        }
        $this->httpClient->setHeaders($this->httpHeaders);
        $this->httpClient->setOptions($this->httpOptions);
        $response = $this->httpClient->send();
        $jsonBody = $response->getBody();
        // need to reset httpclient after each request
        $this->httpClient->reset();
        return $jsonBody;
    }
}