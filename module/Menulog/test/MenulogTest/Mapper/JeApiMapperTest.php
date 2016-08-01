<?php
/**
 * Created by IntelliJ IDEA.
 * User: tonyxu
 * Date: 1/08/2016
 * Time: 9:29 PM
 */

namespace MenulogTest\Mapper;


use Menulog\Mapper\JeApi;
use Menulog\Model\Image;
use Menulog\Model\Restaurant;
use Mockery;
use PHPUnit_Framework_TestCase;
use Zend\Di\ServiceLocator;
use Zend\Http\Response;
use Zend\ServiceManager\ServiceManager;

class JeApiMapperTest extends PHPUnit_Framework_TestCase
{

    protected $httpClient;
    protected $cache;
    protected $serviceManager;
    protected $adapterOptions;
    /**
     * @var JeApi $JeApi
     */
    protected $JeApi;

    public function setup()
    {
        $this->httpClient = Mockery::mock('Zend\Http\client');
        $this->httpClient->shouldReceive('setUri');
        $this->httpClient->shouldReceive('setMethod');
        $this->httpClient->shouldReceive('setParameterGet');
        $this->httpClient->shouldReceive('setHeaders');
        $this->httpClient->shouldReceive('setOptions');
        $this->httpClient->shouldReceive('reset');

        $this->serviceManager = new ServiceManager();
        $this->cache = Mockery::mock('Zend\Cache\Storage\Adapter\AbstractAdapter');

        $this->adapterOptions = Mockery::mock('Zend\Cache\Storage\Adapter\AdapterOptions');

        $this->JeApi = new JeApi($this->httpClient, $this->cache);
    }

    /**
     * test api call for GetRestaurants
     */
    public function testGetRestaurantsApi()
    {
        $postcode = 'se19';
        $this->cache->shouldReceive('hasItem')
            ->once()
            ->andReturn(false);
        $this->cache->shouldReceive('getItem')
            ->once()
            ->andReturn(null);
        $this->cache->shouldReceive('getOptions')
            ->once()
            ->andReturn($this->adapterOptions);

        $this->adapterOptions->shouldReceive('setTtl')
            ->once()
            ->andReturn();


        $this->cache->shouldReceive('setItem')
            ->once()
            ->andReturn(null);

        $jsonRestaurant = '{"Restaurants":[{"IsOpenNowForDelivery":true,"Id":1,"Name":"name1","UniqueName":"uniquename1","RatingAverage":3.5,"Logo":[{"StandardResolutionURL":"urlhere1"}]},
        {"IsOpenNowForDelivery":true,"Id":2,"Name":"name2","UniqueName":"uniquename2","RatingAverage":4.5,"Logo":[{"StandardResolutionURL":"urlhere2"}]} ]}';

        $response = new Response();
        $response->setContent($jsonRestaurant);
        $this->httpClient->shouldReceive('send')
            ->once()
            ->andReturn($response);

        $restaurant1 = new Restaurant();
        $restaurant1->setId(1);
        $restaurant1->setName("name1");
        $restaurant1->setUniqueName("uniquename1");
        $restaurant1->setRatingAverage(3.5);
        $restaurant1->setIsOpenNowForDelivery(true);
        $logo1 = new Image();
        $logo1->setStandardResolutionURL("urlhere1");
        $restaurant1->setLogo($logo1);

        $restaurant2 = new Restaurant();
        $restaurant2->setId(2);
        $restaurant2->setName("name2");
        $restaurant2->setUniqueName("uniquename2");
        $restaurant2->setRatingAverage(4.5);
        $restaurant2->setIsOpenNowForDelivery(true);
        $logo2 = new Image();
        $logo2->setStandardResolutionURL("urlhere2");
        $restaurant2->setLogo($logo2);

        $restaurantsResult = $this->JeApi->getRestaurants($postcode);

        $this->assertEquals(array($restaurant1, $restaurant2),$restaurantsResult);

    }

    /**
     * test api call for GetRestaurants
     */
    public function testGetRestaurantsRedisCache()
    {
        $jsonRestaurant = '{"Restaurants":[{"IsOpenNowForDelivery":true,"Id":1,"Name":"name1","UniqueName":"uniquename1","RatingAverage":3.5,"Logo":[{"StandardResolutionURL":"urlhere1"}]},
        {"IsOpenNowForDelivery":true,"Id":2,"Name":"name2","UniqueName":"uniquename2","RatingAverage":4.5,"Logo":[{"StandardResolutionURL":"urlhere2"}]} ]}';


        $this->cache->shouldReceive('hasItem')
            ->once()
            ->andReturn(true);
        $this->cache->shouldReceive('getItem')
            ->once()
            ->andReturn($jsonRestaurant);
        $this->cache->shouldReceive('getOptions')
            ->once()
            ->andReturn($this->adapterOptions);

        $restaurant1 = new Restaurant();
        $restaurant1->setId(1);
        $restaurant1->setName("name1");
        $restaurant1->setUniqueName("uniquename1");
        $restaurant1->setRatingAverage(3.5);
        $restaurant1->setIsOpenNowForDelivery(true);
        $logo1 = new Image();
        $logo1->setStandardResolutionURL("urlhere1");
        $restaurant1->setLogo($logo1);

        $restaurant2 = new Restaurant();
        $restaurant2->setId(2);
        $restaurant2->setName("name2");
        $restaurant2->setUniqueName("uniquename2");
        $restaurant2->setRatingAverage(4.5);
        $restaurant2->setIsOpenNowForDelivery(true);
        $logo2 = new Image();
        $logo2->setStandardResolutionURL("urlhere2");
        $restaurant2->setLogo($logo2);

        $postcode = "se19";

        $restaurantsResult = $this->JeApi->getRestaurants($postcode);

        $this->assertEquals(array($restaurant1, $restaurant2),$restaurantsResult);
    }


}