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
        $postCode = 'se19';
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
    public function detailsAction()
    {
        $restaurantId = 61642;
        $restaurant = $this->restaurantsService->getRestaurantProducts($restaurantId);
        return new JsonModel($restaurant->toArray());
    }


}