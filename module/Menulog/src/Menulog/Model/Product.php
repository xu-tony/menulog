<?php
/**
 * Created by IntelliJ IDEA.
 * User: tonyxu
 * Date: 31/07/2016
 * Time: 8:12 PM
 */

namespace Menulog\Model;


class Product
{

    /**
     * @var int $id
     */
    protected $id;

    /**
     * @var int $menuCardId
     */
    protected $menuCardId;

    /**
     * @var string $name
     */
    protected $name;

    /**
     * @var string $synonym
     */
    protected $synonym;

    /**
     * @var string $description
     */
    protected $description;

    /**
     * @var float $price
     */
    protected $price;

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
     * @return int
     */
    public function getMenuCardId()
    {
        return $this->menuCardId;
    }

    /**
     * @param int $menuCardId
     */
    public function setMenuCardId($menuCardId)
    {
        $this->menuCardId = $menuCardId;
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
    public function getSynonym()
    {
        return $this->synonym;
    }

    /**
     * @param string $synonym
     */
    public function setSynonym($synonym)
    {
        $this->synonym = $synonym;
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
     * @return float
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * @param float $price
     */
    public function setPrice($price)
    {
        $this->price = $price;
    }

    /**
     * @return array
     */
    public function toArray()
    {
        $result = array();
        $result['id'] = $this->getId();
        $result['name'] = $this->getName();
        $result['synonym'] = $this->getSynonym();
        $result['description'] = $this->getDescription();
        $result['price'] = $this->getPrice();

        return $result;
    }
}