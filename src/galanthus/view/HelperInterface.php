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
 * @package    Galanthus View
 * @copyright  Copyright (c) 2012 Sasquatch, Elegance Team
 */

namespace galanthus\view;

use galanthus\broker\HelperInterface as GlobalHelperInterface;

/**
 * Helpers interface
 *
 * @author     Joan-Alexander Grigorov http://bgscripts.com
 * @category   Galanthus
 * @package    Galanthus View
 * @copyright  Copyright (c) 2012 Sasquatch, Elegance Team
 */
interface HelperInterface extends GlobalHelperInterface
{
    
    /**
     * Set view renderer instance
     * 
     * @param RendererInterface $renderer
     * @return HelperInterface
     */
    public function setRenderer(RendererInterface $renderer);
    
    /**
     * Get view renderer instance
     * 
     * @return RendererInterface
     */
    public function getRenderer();
    
}