<?php
/**
 * Created by IntelliJ IDEA.
 * User: tonyxu
 * Date: 31/07/2016
 * Time: 5:42 PM
 */

namespace Menulog\Mapper;


use Menulog\Model\Menu;
use Menulog\Model\Product;
use Menulog\Model\ProductCategory;
use Menulog\Model\Restaurant;

interface RestaurantsMapperInterface
{
    /**
     * @param $postcode
     * @return Restaurant[]
     */
    public function getRestaurants($postcode);

    /**
     * @param $restaurantId
     * @return Menu[]
     */
    public function getRestaurantMenus($restaurantId);

    /**
     * @param $restaurantId
     * @return Restaurant
     */
    public function getRestaurantDetails($restaurantId);

    /**
     * @param $menuId
     * @return ProductCategory[]
     */
    public function getRestaurantMenuCategories($menuId);

    /**
     * @param $menuId
     * @param $productCategoryId
     * @return Product[]
     */
    public function getRestaurantMenuProductCategoryProducts($menuId, $productCategoryId);
}