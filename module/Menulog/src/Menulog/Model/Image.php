<?php
/**
 * Created by IntelliJ IDEA.
 * User: tonyxu
 * Date: 31/07/2016
 * Time: 7:45 PM
 */

namespace Menulog\Model;


class Image
{
    /**
     * @var string $standardResolutionURL
     */
    protected $standardResolutionURL;

    /**
     * @return string
     */
    public function getStandardResolutionURL()
    {
        return $this->standardResolutionURL;
    }

    /**
     * @param string $standardResolutionURL
     */
    public function setStandardResolutionURL($standardResolutionURL)
    {
        $this->standardResolutionURL = $standardResolutionURL;
    }

    public function toArray()
    {
        return array('standardResolutionURL' => $this->getStandardResolutionURL());
    }
}