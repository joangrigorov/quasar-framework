<?php
/**
 * Quasar Framework © 2012
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
 * @category   Quasar
 * @package    Quasar Controller
 * @subpackage Helpers
 * @copyright  Copyright (c) 2012 Sasquatch
 */

namespace Quasar\Controller\Helper;

use Quasar\Dispatcher\Response\Decorator\HttpHeaders,
    Quasar\Controller\HelperAbstract;

/**
 * Helper for quick http headers manipulation
 *
 * @author     Joan-Alexander Grigorov http://bgscripts.com
 * @category   Quasar
 * @package    Quasar Controller
 * @subpackage Helpers
 * @copyright  Copyright (c) 2012 Sasquatch
 */
class Header extends HelperAbstract
{
    
    /**
     * Set HTTP header
     * 
     * @param string}array $header
     * @return Header
     */
    public function direct($header = null)
    {        
        if (null !== $header) {
            return $this->set($header);
        }
        
        return $this;
    }

    /**
     * Set HTTP header
     *
     * @param string}array $header
     * @return Header
     */
    public function set($header)
    {
        if (!$this->response->hasDecorator('HttpHeaders')) {
            $this->response->addDecorator('HttpHeaders');
        }
        
        /* @var $headersDecorator HttpHeaders */
        $headersDecorator = $this->response->getDecorator('HttpHeaders');
        $headersDecorator->setHeader($header);
        
        return $this;
    }
    
    /**
     * Remove http header
     * 
     * @param string $header
     * @return Header
     */
    public function remove($header)
    {
        if (!$this->response->hasDecorator('HttpHeaders')) {
            $this->response->addDecorator('HttpHeaders');
        }
        
        /* @var $headersDecorator HttpHeaders */
        $headersDecorator = $this->response->getDecorator('HttpHeaders');
        $headersDecorator->removeHeader($header);
        
        return $this;
    }
    
}