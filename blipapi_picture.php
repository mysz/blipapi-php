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

if (!class_exists ('BlipApi_Picture')) {
    class BlipApi_Picture implements IBlipApi_Command {
        /**
        * Read picture attached to status/message/update
        *
        * Throws UnexpectedValueException when update ID is missing
        *
        * @param int $id picture ID
        * @access public
        * @return array parameters for BlipApi::__query
        */
        public static function read ($id) {
            if (!$id) {
                throw new UnexpectedValueException ('Update ID is missing.', -1);
            }
            return array (sprintf ('/updates/%s/pictures', $id), 'get');
        }
    }
}
