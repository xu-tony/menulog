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
     * @param Client $httpClient
     */
    public function __construct(Client $httpClient)
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
            'timeout'      => 30
        );

        $this->httpClient = $httpClient;

    }

    /**
     * @param $postcode
     * @return mixed
     */
    public function getRestaurants($postcode)
    {
        $uri = $this->baseUri.'/restaurants';
        $requestParams = array(
            'q' => urlencode($postcode)
        );
        $httpMethod = Request::METHOD_GET;
        $result = $this->sendHttpRequest($uri, $httpMethod, $requestParams);
        $restaurants = array();
        if ($result && array_key_exists('Restaurants', $result)) {

            foreach($result['Restaurants'] as $restaurantArr){
                if ($restaurantArr['IsOpenNowForDelivery'] == true){
                    $restaurant = new Restaurant();
                    $restaurant->setId($restaurantArr['Id']);
                    $restaurant->setName($restaurantArr['Name']);
                    $restaurant->setUniqueName($restaurantArr['UniqueName']);
                    $logo = new Image();
                    $logo->setStandardResolutionURL($restaurantArr['Logo'][0]['StandardResolutionURL']);
                    $restaurant->setLogo($logo);
                    $restaurant->setRatingAverage($restaurantArr['RatingAverage']);
                    $restaurants[] = $restaurant;
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
        $uri = $this->baseUri.'/restaurants/'.$restaurantId.'/menus';
        $requestParams = array();
        $httpMethod = Request::METHOD_GET;
        $result = $this->sendHttpRequest($uri, $httpMethod, $requestParams);
        $menus = array();
        if ($result && array_key_exists('Menus', $result)) {
            foreach($result['Menus'] as $menuArr){
                $menu = new Menu();
                $menu->setId($menuArr['Id']);
                $menu->setTitle($menuArr['Title']);
                $menu->setDescription($menuArr['Description']);
                $menus[] = $menu;
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
        $uri = $this->baseUri.'/menus/'.$menuId.'/productcategories';
        $requestParams = array();
        $httpMethod = Request::METHOD_GET;
        $result = $this->sendHttpRequest($uri, $httpMethod, $requestParams);

        $productCategories = array();
        if ($result && array_key_exists('Categories', $result)) {
            foreach($result['Categories'] as $category){
                $productCategory = new ProductCategory();
                $productCategory->setId($category['Id']);
                $productCategory->setName($category['Name']);
                $productCategories[] = $productCategory;
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
        $uri = $this->baseUri.'/menus/'.$menuId.'/productcategories/'.$productCategoryId.'/products';
        $requestParams = array();
        $httpMethod = Request::METHOD_GET;
        $result = $this->sendHttpRequest($uri, $httpMethod, $requestParams);

        $products = array();
        if ($result && array_key_exists('Products', $result)) {
            foreach($result['Products'] as $productArr){
                $product = new Product();
                $product->setId($productArr['Id']);
                $product->setName($productArr['Name']);
                $product->setDescription($productArr['Description']);
                $product->setPrice($productArr['Price']);
                $product->setSynonym($productArr['Synonym']);
                $products[] = $product;
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
        $uri = $this->baseUri.'/restaurants/'.$restaurantId.'/details';
        $requestParams = array();
        $httpMethod = Request::METHOD_GET;
        $result = $this->sendHttpRequest($uri, $httpMethod, $requestParams);
        $restaurant = new Restaurant();
        if ($result && array_key_exists('Id', $result)) {
            $restaurant->setId($restaurantId);
            $restaurant->setDescription($result['Description']);
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
        $json = $response->getBody();
        $result = json_decode($json, true);
        // need to reset httpclient after each request
        $this->httpClient->reset();
        return $result;
    }
}