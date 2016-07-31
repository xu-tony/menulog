<?php
/**
 * Created by IntelliJ IDEA.
 * User: tonyxu
 * Date: 31/07/2016
 * Time: 7:28 PM
 */

namespace Menulog\Model;



class Restaurant
{

    /**
     * @var int $id
     */
    protected $id;

    /**
     * @var Menu[] $menus
     */
    protected $menus;

    /**
     * @var string $name
     */
    protected $name;

    /**
     * @var string $description
     */
    protected $description;

    /**
     * url in JE is https://www.just-eat.co.uk/restaurants-{$uniqueName}/menu
     * @var string $uniqueName
     */
    protected $uniqueName;

    /**
     * @var float $ratingAverage
     */
    protected $ratingAverage;

    /**
     * @var Image $logo;
     */
    protected $logo;

    /**
     * @var boolean $isOpenNowForDelivery
     */
    protected $isOpenNowForDelivery;

    /**
     * @return Menu[]
     */
    public function getMenus()
    {
        return $this->menus;
    }

    /**
     * @param Menu[] $menus
     */
    public function setMenus($menus)
    {
        $this->menus = $menus;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getUniqueName()
    {
        return $this->uniqueName;
    }

    /**
     * @param string $uniqueName
     */
    public function setUniqueName($uniqueName)
    {
        $this->uniqueName = $uniqueName;
    }

    /**
     * @return float
     */
    public function getRatingAverage()
    {
        return $this->ratingAverage;
    }

    /**
     * @param float $ratingAverage
     */
    public function setRatingAverage($ratingAverage)
    {
        $this->ratingAverage = $ratingAverage;
    }

    /**
     * @return Image
     */
    public function getLogo()
    {
        return $this->logo;
    }

    /**
     * @param Image $logo
     */
    public function setLogo($logo)
    {
        $this->logo = $logo;
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param string $description
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }

    /**
     * @return boolean
     */
    public function isOpenNowForDelivery()
    {
        return $this->isOpenNowForDelivery;
    }

    /**
     * @param boolean $isOpenNowForDelivery
     */
    public function setIsOpenNowForDelivery($isOpenNowForDelivery)
    {
        $this->isOpenNowForDelivery = $isOpenNowForDelivery;
    }

    /**
     * @return array
     */
    public function toArray()
    {
        $result = array();
        $result['id'] = $this->getId();
        $result['logo'] = $this->getLogo() ? $this->getLogo()->toArray() : '';
        $result['name'] = $this->getName();
        $result['unique_name'] = $this->getUniqueName();
        $result['rating_average'] = $this->getRatingAverage();
        $result['description'] = $this->getDescription();
        $result['menus'] = array();
        if ($this->getMenus()) {
            foreach($this->getMenus() as $menu){
                $result['menus'][] = $menu->toArray();
            }
        }
        return $result;
    }

}