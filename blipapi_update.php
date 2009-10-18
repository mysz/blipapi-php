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

if (!class_exists ('BlipApi_Update')) {
    class BlipApi_Update extends BlipApi_Abstract implements IBlipApi_Command {
        protected $_body;
        protected $_id;
        protected $_include;
        protected $_limit   = 10;
        protected $_offset  = 0;
        protected $_image;
        protected $_private;
        protected $_since_id;
        protected $_user;

        protected function __set_body ($value) {
            $this->_body = $value;
        }
        protected function __set_id ($value) {
            $this->_id = $this->__validate_offset ($value);
        }
        protected function __set_include ($value) {
            $this->_include = $this->__validate_include ($value);
        }
        protected function __set_limit ($value) {
            $this->_limit = $this->__validate_limit ($value);
        }
        protected function __set_offset ($value) {
            $this->_offset = $this->__validate_offset ($value);
        }
        protected function __set_image ($value) {
            $this->_image = $this->__validate_file ($value);
        }
        protected function __set_private ($value) {
            $this->_private = $value;
        }
        protected function __set_since_id ($value) {
            $this->_since_id = $this->__validate_offset ($value);
        }
        protected function __set_user ($value) {
            $this->_user = $value;
        }


        /**
        * Creating update
        *
        * @static
        * @access public
        * @return array parameters for BlipApi::__query
        */
        public function create () {
            if (!$this->_body) {
                throw new InvalidArgumentException ('Update body is missing.', -1);
            }

            if ($this->_user) {
                $this->_body = ($this->_private ? '>' : '') . ">$this->_user $this->_body";
            }

            $opts = array();
            $data = array('update[body]' => $this->_body);
            if ($this->_image) {
                $data['update[picture]'] = '@'.$this->_image;
                $opts['multipart'] = true;
            }

            return array ('/updates', 'post', $data, $opts);
        }

        /**
        * Reading update
        *
        * It's hard to explain what are doing specified parameters. Please consult with offcial API
        * documentation: {@link http://www.blip.pl/api-0.02.html}.
        *
        * Differences with official API: if you want messages from all users, specify $user == __ALL__.
        *
        * @static
        * @access public
        * @return array parameters for BlipApi::__query
        */
        public function read () {
            if ($this->_user) {
                if ($this->_user == '__ALL__') {
                    if ($this->_since_id) {
                        $url = "/updates/$this->_since_id/all_since";
                    }
                    else {
                        $url = "/updates/all";
                    }
                }
                else {
                    if ($this->_since_id) {
                        $url = "/users/$this->_user/updates/$this->_since_id/since";
                    }
                    else {
                        $url = "/users/$this->_user/updates";
                    }
                }
            }
            else if ($this->_id) {
                $url = "/updates/$this->_id";
            }

            else {
                $url = '/updates';
                if ($this->_since_id) {
                    $url .= "/$this->_since_id/since";
                }
            }

            $params = array ();
            if ($this->_limit) {
                $params['limit'] = $this->_limit;
            }
            if ($this->_offset) {
                $params['offset'] = $this->_offset;
            }
            if ($this->_include) {
                $params['include'] = implode (',', $this->_include);
            }

            if (count ($params)) {
                $url .= '?' . BlipApi__arr2qstr ($params);
            }

            return array ($url, 'get');
        }

        /**
        * Deleting update
        *
        * Throws InvalidArgumentException when update ID is missing.
        *
        * @param int $id update ID
        * @static
        * @access public
        * @return array parameters for BlipApi::__query
        */
        public function delete () {
            if (!$this->_id) {
                throw new InvalidArgumentException ('Update ID is missing.', -1);
            }
            return array ("/updates/$this->_id", 'delete');
        }
    }
}

