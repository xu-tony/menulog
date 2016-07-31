<?php
/**
 * Created by IntelliJ IDEA.
 * User: tonyxu
 * Date: 31/07/2016
 * Time: 9:54 PM
 */

namespace Menulog\Factory;


use Menulog\Controller\RestaurantsController;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class RestaurantsControllerFactory implements FactoryInterface
{

    public function createService(ServiceLocatorInterface $serviceLocator) {
        $realServiceLocator = $serviceLocator->getServiceLocator();
        $restaurantsService = $realServiceLocator->get('Menulog\Service\RestaurantsServiceInterface');
        return new RestaurantsController($restaurantsService);
    }
}