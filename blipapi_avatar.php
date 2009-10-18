<?php

/**
 * Blip! (http://blip.pl) communication library.
 *
 * @author Marcin Sztolcman <marcin /at/ urzenia /dot/ net>
 * @version 0.02.20
 * @version $Id$
 * @copyright Copyright (c) 2007, Marcin Sztolcman
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License v.2
 * @package blipapi
 */

/**
 * Blip! (http://blip.pl) communication library.
 *
 * @author Marcin Sztolcman <marcin /at/ urzenia /dot/ net>
 * @version 0.02.20
 * @version $Id$
 * @copyright Copyright (c) 2007, Marcin Sztolcman
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License v.2
 * @package blipapi
 */

if (!class_exists ('BlipApi_Avatar')) {
    class BlipApi_Avatar extends BlipApi_Abstract implements IBlipApi_Command {
        protected $_user    = '';
        protected $_image   = '';

        protected function __set_user ($value) {
            $this->_user = $value;
        }

        protected function __set_image ($value) {
            $this->_image = $this->__validate_file ($value);
        }

        /**
        * Get info about users avatar
        *
        * @access public
        * @return array parameters for BlipApi::__query
        */
        public function read () {
            if (!$this->_user) {
                return array ('/avatar', 'get');
            }
            return array ("/users/$this->_user/avatar", 'get');
        }

        /**
        * Upload new avatar
        *
        * Throws InvalidArgumentException if avatar path is missing or file not found
        *
        * @access public
        * @return array parameters for BlipApi::__query
        */
        public function update () {
            if (!$this->_image) {
                throw new InvalidArgumentException ('Avatar path missing or file not found.', -1);
            }
            return array ('/avatar', 'post', array ( 'avatar[file]' => '@'.$this->_image ), array ('multipart' => 1));
        }

        /**
        * Delete avatar
        *
        * @access public
        * @return array parameters for BlipApi::__query
        */
        public function delete () {
            return array ('/avatar', 'delete');
        }
    }
}
