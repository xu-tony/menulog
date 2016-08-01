<?php
/**
 * Created by IntelliJ IDEA.
 * User: tonyxu
 * Date: 31/07/2016
 * Time: 5:39 PM
 */

namespace Menulog\Service;


use Menulog\Model\Menu;
use Menulog\Model\Restaurant;

interface RestaurantsServiceInterface
{

    /**
     * @param $postcode
     * @return Restaurant[]
     */
    public function getRestaurants($postcode);

    /**
     * @param $restaurantId
     * @return Restaurant
     */
    public function getRestaurantProducts($restaurantId);


}