<?php
/**
 * Created by IntelliJ IDEA.
 * User: tonyxu
 * Date: 31/07/2016
 * Time: 9:09 PM
 */

namespace Menulog\Model;


class ProductCategory
{

    /**
     * @var int $id
     */
    protected $id;

    /**
     * @var string $name
     */
    protected $name;

    /**
     * @var Product[] $products
     */
    protected $products;

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
     * @return Product[]
     */
    public function getProducts()
    {
        return $this->products;
    }

    /**
     * @param Product[] $products
     */
    public function setProducts($products)
    {
        $this->products = $products;
    }

    public function toArray()
    {
        $result = array();
        $result['id'] = $this->getId();
        $result['name'] = $this->getName();

        $result['products'] = array();
        if ($this->getProducts()) {
            foreach($this->getProducts() as $product){
                $result['products'][] = $product->toArray();
            }
        }
        return $result;
    }

}