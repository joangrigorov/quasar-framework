<?php
/**
 * Galanthus Framework © 2012
 * Copyright © 2012 Sasquatch <Joan-Alexander Grigorov>
 *                              http://bgscripts.com
 *
 * LICENSE
 *
 * This source file is subject to the GNU General Public License v3
 * that is bundled with this package in the file LICENSE.
 * It is also available through the world-wide-web at this URL:
 * http://www.gnu.org/copyleft/gpl.html
 *
 * @category   Galanthus
 * @package    Galanthus Dispatcher
 * @subpackage Response
 * @copyright  Copyright (c) 2012 Sasquatch, Elegance Team
 */

namespace galanthus\dispatcher\response;

use galanthus\dispatcher\ResponseInterface,
    galanthus\dispatcher\response\DecoratorInterface;

/**
 * @author     Joan-Alexander Grigorov http://bgscripts.com
 * @category   Galanthus
 * @package    Galanthus Dispatcher
 * @subpackage Response
 * @copyright  Copyright (c) 2012 Sasquatch, Elegance Team
 */
abstract class DecoratorAbstract implements DecoratorInterface
{
    
    /**
     * The response object
     *
     * @var ResponseInterface
     */
    protected $response;
    
    /**
     * New content placement
     *
     * @var string
     */
    protected $placement;
    
    /**
     * Get the response object
     *
     * @return ResponseInterface
     */
    public function getResponse()
    {
        return $this->_response;
    }
    
    /**
     * Set the response object
     *
     * @param $response ResponseInterface
     * @return DecoratorAbstract
     */
    public function setResponse(ResponseInterface $response)
    {
        $this->response = $response;
        return $this;
    }
    
    /**
     * Sets content placement
     *
     * @param string $placement
     * @return DecoratorAbstract
     */
    public function setPlacement($placement)
    {
        $placement = strtoupper($placement);
    
        switch ($placement) {
            case self::PREPEND:
                $this->placement = self::PREPEND;
                break;
            default:
                $this->placement = self::APPEND;
                break;
        }
    
        return $this;
    }
    
    /**
     * Get content placement
     *
     * @return string
     */
    public function getPlacement()
    {
        return $this->_placement;
    }
    
    /**
     * Set decorator options
     * 
     * @param array $options
     * @return Renderer
     */
    public function setOptions(array $options)
    {
        foreach ($options as $name => $value) {
            $setter = 'set' . ucfirst($name);
            if (method_exists($this, $setter)) {
                $this->$setter($value);
            }
        }
    }
    
}