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
 * @copyright  Copyright (c) 2012 Sasquatch, Elegance Team
 */

namespace galanthus\dispatcher;

use galanthus\dispatcher\request\Query;

/**
 * The standard request object
 * 
 * Resolves the requested URI
 * 
 * @todo Customizing route
 * 
 * @author     Joan-Alexander Grigorov http://bgscripts.com
 * @category   Galanthus
 * @package    Galanthus Dispatcher
 * @copyright  Copyright (c) 2012 Sasquatch, Elegance Team
 */
class Request implements RequestInterface
{
    
    /**
     * Query stack
     * 
     * @var Query
     */
    protected $query;
    
    protected function resolveUri()
    {

        if (dirname($_SERVER['SCRIPT_NAME']) != DS) {
            $requestQuery = parse_url(
                str_replace(dirname($_SERVER['SCRIPT_NAME']), '', 
                        str_replace($_SERVER['SCRIPT_NAME'], '', $_SERVER['REQUEST_URI'])
                )
            );
        } else {
            $requestQuery = parse_url(
                str_replace($_SERVER['SCRIPT_NAME'], '', $_SERVER['REQUEST_URI'])
            );
        }
        
        $path = explode('/', $requestQuery['path']);
        
        if (!empty($path)) {
            foreach ($path as $entity) {
                if (empty($entity)) {
                    continue;
                }
                $this->query->push($entity);
            }
        }        
    }
    
    /**
     * Sets the request query stack object
     * 
     * @param Query $query
     */
    public function __construct(Query $query)
    {
        $this->query = $query;
        $this->resolveUri();
    }
    
    /**
     * Get the query stack
     * 
     * @return Query
     */
    public function getQuery()
    {
        return $this->query;
    }
    
}