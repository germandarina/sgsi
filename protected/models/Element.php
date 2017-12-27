<?php
class Element {
    public $_data = array();
    public function __construct( $_data = array() ) {
        $this->_data = $_data;
    }
    public function __get($name) {
        return $this->_data[$name];
    }

    public function __toString() {
        return $this->_data["name"];
    }
}