<?php
/**
 * Created by IntelliJ IDEA.
 * User: tonyxu
 * Date: 31/07/2016
 * Time: 5:40 PM
 */

namespace Menulog\Service;


use Menulog\Mapper\RestaurantsMapperInterface;
use Menulog\Model\Restaurant;

class RestaurantsService implements RestaurantsServiceInterface
{
    /**
     * @var RestaurantsMapperInterface $restaurantsMapper
     */
    protected $restaurantsMapper;

    public function __construct(RestaurantsMapperInterface $restaurantsMapperInterface)
    {
        $this->restaurantsMapper = $restaurantsMapperInterface;
    }

    /**
     * @param $postcode
     * @return mixed
     */
    public function getRestaurants($postcode)
    {
        $restaurants = $this->restaurantsMapper->getRestaurants($postcode);
        // sort restaurant by average rating desc
        $restaurants = $this->restaurantsSortByAvgRatingDesc($restaurants);

        return $restaurants;
    }

    /**
     * @param Restaurant[] $restaurants
     * @return Restaurant[] $restaurants
     */
    private function restaurantsSortByAvgRatingDesc($restaurants)
    {
        if (count($restaurants) > 0){
            usort($restaurants,  array($this,'averageRatingSortDesc'));
        }
        return $restaurants;
    }

    /**
     * @param Restaurant $a
     * @param Restaurant $b
     * @return int
     */
    private function averageRatingSortDesc($a, $b)
    {
        if ($a->getRatingAverage() == $b->getRatingAverage())
        {
            return 0;
        }
        return ($a->getRatingAverage() > $b->getRatingAverage())? -1 : 1; // desc
    }

    /**
     * @param $restaurantId
     * @return Restaurant
     */
    public function getRestaurantDetails($restaurantId)
    {
        // get details
        $restaurant = $this->restaurantsMapper->getRestaurantDetails($restaurantId);
        // get all menus
        $menus = $this->restaurantsMapper->getRestaurantMenus($restaurantId);
        if ($menus) {
            foreach($menus as &$menu) {
                $productCategories = $this->restaurantsMapper->getRestaurantMenuCategories($menu->getId());
                if ($productCategories) {
                    foreach ($productCategories as &$productCategory) {
                        $products = $this->restaurantsMapper->getRestaurantMenuProductCategoryProducts($menu->getId(), $productCategory->getId());
                        $productCategory->setProducts($products);
                    }
                    $menu->setProductCategories($productCategories);
                }
            }
        }
        $restaurant->setMenus($menus);
        return $restaurant;
    }
}