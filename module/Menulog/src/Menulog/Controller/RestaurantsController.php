<?php
/**
 * Created by IntelliJ IDEA.
 * User: tonyxu
 * Date: 31/07/2016
 * Time: 9:52 PM
 */

namespace Menulog\Controller;


use Menulog\Service\RestaurantsServiceInterface;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\JsonModel;
use Zend\View\Model\ViewModel;

class RestaurantsController extends AbstractActionController
{

    /**
     * @var RestaurantsServiceInterface $restaurantsService
     */
    protected $restaurantsService;


    public function __construct(RestaurantsServiceInterface $restaurantsService)
    {
        $this->restaurantsService = $restaurantsService;
    }

    /**
     * @return JsonModel
     */
    public function restaurantsAction()
    {
        $postCode = $this->getRequest()->getQuery('q');
        $postCode = strip_tags($postCode);
        $restaurants = $this->restaurantsService->getRestaurants($postCode);
        $result = array();
        if ($restaurants) {
            foreach($restaurants as $restaurant) {
                $result[] = $restaurant->toArray();
            }
        }
        return new JsonModel($result);
    }

    /**
     * @return JsonModel
     */
    public function restaurantGetAction()
    {
        //$restaurantId = 61642;
        $restaurantId = $this->params()->fromRoute('id');
        $restaurant = $this->restaurantsService->getRestaurantProducts($restaurantId);
        return new JsonModel($restaurant->toArray());
    }

    public function restaurantAction()
    {
        $restaurantId = $this->params()->fromRoute('id');
        return new ViewModel(array('id'=>$restaurantId));
    }
}