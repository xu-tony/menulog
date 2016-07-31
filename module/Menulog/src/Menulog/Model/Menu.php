<?php
/**
 * Created by IntelliJ IDEA.
 * User: tonyxu
 * Date: 31/07/2016
 * Time: 9:07 PM
 */

namespace Menulog\Model;


class Menu
{

    /**
     * @var int $id
     */
    protected $id;

    /**
     * @var string $title
     */
    protected $title;

    /**
     * @var string $description
     */
    protected $description;

    /**
     * @var ProductCategory[] $productCategories
     */
    protected $productCategories;

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
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param string $title
     */
    public function setTitle($title)
    {
        $this->title = $title;
    }

    /**
     * @return ProductCategory[]
     */
    public function getProductCategories()
    {
        return $this->productCategories;
    }

    /**
     * @param ProductCategory[] $productCategories
     */
    public function setProductCategories($productCategories)
    {
        $this->productCategories = $productCategories;
    }

    /**
     * @return array
     */
    public function toArray()
    {
        $result = array();
        $result['id'] = $this->getId();
        $result['description'] = $this->getDescription();
        $result['title'] = $this->getTitle();

        $result['productCategories'] = array();
        if ($this->getProductCategories()) {
            foreach($this->getProductCategories() as $productCategory){
                $result['productCategories'][] = $productCategory->toArray();
            }
        }
        return $result;
    }
}