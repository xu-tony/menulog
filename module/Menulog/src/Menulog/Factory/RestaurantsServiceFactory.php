<?php
/**
 * Created by IntelliJ IDEA.
 * User: tonyxu
 * Date: 31/07/2016
 * Time: 9:59 PM
 */

namespace Menulog\Factory;


use Menulog\Service\RestaurantsService;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class RestaurantsServiceFactory implements FactoryInterface
{

    /**
     * Create service
     *
     * @param ServiceLocatorInterface $serviceLocator
     * @return mixed
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        return new RestaurantsService(
            $serviceLocator->get('Menulog\Mapper\RestaurantsMapperInterface')
        );
    }

}