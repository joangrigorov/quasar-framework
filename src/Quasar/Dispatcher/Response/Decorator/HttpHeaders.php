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
 * @package    Quasar Dispatcher
 * @subpackage Response
 * @copyright  Copyright (c) 2012 Sasquatch
 */

namespace Quasar\Dispatcher\Response\Decorator;

use Quasar\Dispatcher\Response\DecoratorAbstract;


/**
 * Response decorator for http headers
 * 
 * @author     Joan-Alexander Grigorov http://bgscripts.com
 * @category   Quasar
 * @package    Quasar Dispatcher
 * @subpackage Response
 * @copyright  Copyright (c) 2012 Sasquatch
 */
class HttpHeaders extends DecoratorAbstract
{
    
    /**
     * @var array
     */
    protected $headers = array();
    
    /**
     * Set new header
     * 
     * @param string|array $content
     * @return HttpHeaders
     */
    public function setHeader($header)
    {
        
        if (is_array($header)) {
            
            if (2 === count($header)) {
                $this->headers[$header[0]] = $header[1];
                return $this;
            } else if (1 === count($header)) {
                foreach($header as $key => $content) {
                    $this->headers[$key] = $content;
                    return $this;
                } 
            }
            
            if (isset($header['key']) && isset($header['content'])) {
                $this->headers[$header['key']] = $header['content'];
                return $this;
            }
            
        }
        
        $this->headers[] = $header;
        return $this;
    }
    
    /**
     * Set headers
     * 
     * @param array $headers
     * @return \Quasar\Dispatcher\Response\Decorator\HttpHeaders
     */
    public function setHeaders(array $headers)
    {
        foreach ($headers as $header) {
            $this->setHeader($header);
        }
        return $this;
    }
    
    /**
     * Remove a specified header by key or content
     * 
     * @param string $content
     * @return HttpHeaders
     */
    public function removeHeader($content)
    {
        if (array_key_exists($content, $this->headers)) {
            unset($this->headers[$content]);
            return $this;
        }
        
        $header = array_search($content, $this->headers);
        if ($header) {
            unset($this->headers[$header]);
        }
        return $this;
    }
    
    /**
     * Get registered headers
     * 
     * @return array
     */
    public function getHeaders()
    {
        return $this->headers;
    }
    
    /**
     * Remove all headers
     * 
     * @return HttpHeaders
     */
    public function clearHeaders()
    {
        $this->headers = array();
        return $this;
    }
    
	/**
     * Decorate response
     *
     * @param $content string
     * @return string
     */
    public function decorate($content)
    {
        foreach ($this->headers as $header) {
            header($header);
        }
        
        return $content;
    }
    
}