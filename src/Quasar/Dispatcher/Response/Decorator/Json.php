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

use Quasar\Dispatcher\Response\Decorator\DecoratorAbstract;


/**
 * Response decorator for encoding parameters into json
 * 
 * @author     Joan-Alexander Grigorov http://bgscripts.com
 * @category   Quasar
 * @package    Quasar Dispatcher
 * @subpackage Response
 * @copyright  Copyright (c) 2012 Sasquatch
 */
class Json extends DecoratorAbstract
{

   /**@#+
    * Reserved response param names
    */
    const RESERVED_RESET_HEADERS = '_jsonResetHeaders';
    /**@#-*/
    
	/**
     * Decorate response
     *
     * @param $content string
     * @return string
     */
    public function decorate($content)
    {
        $parameters = $this->response->getParams();

        if ($this->getResponse()->hasDecorator('HttpHeaders')) {
            /* @var $headersDecorator \Quasar\Dispatcher\Response\Decorator\HttpHeaders */
            $headersDecorator = $this->response->getDecorator('HttpHeaders');
                    
            $headersDecorator->setHeader('Cache-Control: no-cache, must-revalidate')
                             ->setHeader('Expires: Mon, 26 Jul 1997 05:00:00 GMT')
                             ->setHeader('Content-type: application/json');
        }
        
        return json_encode($parameters);
    }
    
}