<?php
/**
 * Created by IntelliJ IDEA.
 * User: tonyxu
 * Date: 1/08/2016
 * Time: 7:50 PM
 */

namespace MenulogTest\Service;


use Menulog\Model\Menu;
use Menulog\Model\Product;
use Menulog\Model\ProductCategory;
use Menulog\Model\Restaurant;
use Menulog\Service\RestaurantsService;
use PHPUnit_Framework_TestCase;
use Mockery;

class RestaurantsServiceTest extends PHPUnit_Framework_TestCase
{
    protected $restaurantsMapper;
    protected $restaurantsService;

    public function setup()
    {
        $this->restaurantsMapper = Mockery::mock('Menulog\Mapper\RestaurantsMapperInterface');
        $this->restaurantsService = new RestaurantsService($this->restaurantsMapper);
    }

    /**
     * test get Restaurants
     */
    public function testGetRestaurants()
    {
        $restaurants = array();

        $restaurant2 = new Restaurant();
        $restaurant2->setId(2);
        $restaurant2->setIsOpenNowForDelivery(true);
        $restaurant2->setMenus(array());
        $restaurant2->setDescription('testDescription2');
        $restaurant2->setLogo(null);
        $restaurant2->setName('name2');
        $restaurant2->setRatingAverage(3.5);
        $restaurant2->setUniqueName('unique name2');

        $restaurant1 = new Restaurant();
        $restaurant1->setId(1);
        $restaurant1->setIsOpenNowForDelivery(true);
        $restaurant1->setMenus(array());
        $restaurant1->setDescription('testDescription1');
        $restaurant1->setLogo(null);
        $restaurant1->setName('name1');
        $restaurant1->setRatingAverage(4.5);
        $restaurant1->setUniqueName('unique name1');

        $restaurant3 = new Restaurant();
        $restaurant3->setId(3);
        $restaurant3->setIsOpenNowForDelivery(false);
        $restaurant3->setMenus(array());
        $restaurant3->setDescription('testDescription3');
        $restaurant3->setLogo(null);
        $restaurant3->setName('name3');
        $restaurant3->setRatingAverage(2.5);
        $restaurant3->setUniqueName('unique name3');

        $restaurants[] = $restaurant1;
        $restaurants[] = $restaurant2;
        $restaurants[] = $restaurant3;

        $postCode = 'testcode';
        $this->restaurantsMapper->shouldReceive('getRestaurants')
            ->once()
            ->andReturn($restaurants);

        $restaurantsResult = $this->restaurantsService->getRestaurants($postCode);

        $this->assertEquals(3, count($restaurantsResult));
        $this->assertContains($restaurant1, $restaurantsResult);
        $this->assertContains($restaurant2, $restaurantsResult);
        $this->assertContains($restaurant3, $restaurantsResult);

    }


    /**
     * test get restaurant all products
     */
    public function testGetRestaurantProducts()
    {
        $restaurantId = 1;

        $menuId1 = 1;

        $menuId1CategoryId1 = 11;
        $menuId1CategoryId1Product1 = 111;
        $menuId1CategoryId1Product2 = 112;
        $menuId1CategoryId1Product3 = 113;

        $menuId1CategoryId2 = 12;
        $menuId1CategoryId2Product1 = 121;
        $menuId1CategoryId2Product2 = 122;
        $menuId1CategoryId2Product3 = 123;

        $menuId2 = 2;

        $menuId2CategoryId1 = 21;
        $menuId2CategoryId1Product1 = 211;
        $menuId2CategoryId1Product2 = 212;
        $menuId2CategoryId1Product3 = 213;

        $menuId2CategoryId2 = 22;
        $menuId2CategoryId2Product1 = 221;
        $menuId2CategoryId2Product2 = 222;
        $menuId2CategoryId2Product3 = 223;

        $menus = array();
        $menu1 = new Menu();
        $menu1->setId($menuId1);
        $menu2 = new Menu();
        $menu2->setId($menuId2);

        $productCategory11 = new ProductCategory();
        $productCategory11->setId($menuId1CategoryId1);
        $productCategory12 = new ProductCategory();
        $productCategory12->setId($menuId1CategoryId2);
        $productCategories1 = array($productCategory11, $productCategory12);

        $productCategory21 = new ProductCategory();
        $productCategory21->setId($menuId2CategoryId1);
        $productCategory22 = new ProductCategory();
        $productCategory22->setId($menuId2CategoryId2);
        $productCategories2 = array($productCategory21, $productCategory22);


        $product111 = new Product();
        $product111->setId($menuId1CategoryId1Product1);
        $product112 = new Product();
        $product112->setId($menuId1CategoryId1Product2);
        $product113 = new Product();
        $product113->setId($menuId1CategoryId1Product3);
        $products11 = array($product111, $product112, $product113);

        $product121 = new Product();
        $product121->setId($menuId1CategoryId2Product1);
        $product122 = new Product();
        $product122->setId($menuId1CategoryId2Product2);
        $product123 = new Product();
        $product123->setId($menuId1CategoryId2Product3);
        $products12 = array($product121, $product122, $product123);

        $product211 = new Product();
        $product211->setId($menuId2CategoryId1Product1);
        $product212 = new Product();
        $product212->setId($menuId2CategoryId1Product2);
        $product213 = new Product();
        $product213->setId($menuId2CategoryId1Product3);
        $products21 = array($product211, $product212, $product213);

        $product221 = new Product();
        $product221->setId($menuId2CategoryId2Product1);
        $product222 = new Product();
        $product222->setId($menuId2CategoryId2Product2);
        $product223 = new Product();
        $product223->setId($menuId2CategoryId2Product3);
        $products22 = array($product221, $product222, $product223);

        $productCategory11->setProducts(array($products11));
        $productCategory12->setProducts(array($products12));
        $productCategory21->setProducts(array($products21));
        $productCategory22->setProducts(array($products22));

        $menu1->setProductCategories($productCategories1);

        $menu2->setProductCategories($productCategories2);


        $restaurantDetails = new Restaurant();
        $restaurantDetails->setId(1);
        $restaurantDetails->setDescription('test description');

        $this->restaurantsMapper->shouldReceive('getRestaurantDetails')
            ->withArgs(array($restaurantId))
            ->once()
            ->andReturn($restaurantDetails);

        $this->restaurantsMapper->shouldReceive('getRestaurantMenus')
            ->withArgs(array($restaurantId))
            ->once()
            ->andReturn($menus);

        $this->restaurantsMapper->shouldReceive('getRestaurantMenuCategories')
            ->withArgs(array($menuId1))
            ->once()
            ->andReturn($menu1);

        $this->restaurantsMapper->shouldReceive('getRestaurantMenuCategories')
            ->withArgs(array($menuId2))
            ->once()
            ->andReturn($menu2);



        $this->restaurantsMapper->shouldReceive('getRestaurantMenuProductCategoryProducts')
            ->withArgs(array($menuId1, $menuId1CategoryId1))
            ->once()
            ->andReturn($products11);

        $this->restaurantsMapper->shouldReceive('getRestaurantMenuProductCategoryProducts')
            ->withArgs(array($menuId1, $menuId1CategoryId2))
            ->once()
            ->andReturn($products12);
        $this->restaurantsMapper->shouldReceive('getRestaurantMenuProductCategoryProducts')
            ->withArgs(array($menuId2, $menuId2CategoryId1))
            ->once()
            ->andReturn($products21);
        $this->restaurantsMapper->shouldReceive('getRestaurantMenuProductCategoryProducts')
            ->withArgs(array($menuId2, $menuId2CategoryId2))
            ->once()
            ->andReturn($products22);


        $restaurantResult = $this->restaurantsService->getRestaurantProducts($restaurantId);

        $this->assertEquals($restaurantDetails, $restaurantResult);
    }
}