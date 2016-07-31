<?php
/**
 * Created by IntelliJ IDEA.
 * User: tonyxu
 * Date: 31/07/2016
 * Time: 10:04 PM
 */

namespace Menulog\Factory;


use Menulog\Mapper\JeApi;
use Zend\Http\Client;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class RestaurantsMapperFactory implements FactoryInterface
{

    /**
     * Create service
     *
     * @param ServiceLocatorInterface $serviceLocator
     * @return mixed
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        return new JeApi(
            new Client()
        );
    }
}