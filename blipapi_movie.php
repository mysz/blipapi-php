<?php

/**
 * Blip! (http://blip.pl) communication library.
 *
 * @author Marcin Sztolcman <marcin /at/ urzenia /dot/ net>
 * @version 0.02.10
 * @version $Id$
 * @copyright Copyright (c) 2007, Marcin Sztolcman
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License v.2
 * @package blipapi
 */

/**
 * Blip! (http://blip.pl) communication library.
 *
 * @author Marcin Sztolcman <marcin /at/ urzenia /dot/ net>
 * @version 0.02.10
 * @version $Id$
 * @copyright Copyright (c) 2007, Marcin Sztolcman
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License v.2
 * @package blipapi
 */

if (!class_exists ('BlipApi_Movie')) {
    class BlipApi_Movie implements IBlipApi_Command {
        /**
        * Read movie attached to status/message/update
        *
        * Throws UnexpectedValueException when status ID is missing
        *
        * @param int $id status ID
        * @access public
        * @return array parameters for BlipApi::__query
        */
        public static function read ($id) {
            if (!$id) {
                throw new UnexpectedValueException ('Update ID is missing.', -1);
            }
            return array ("/updates/$id/movie", 'get');
        }
    }
}

