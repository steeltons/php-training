<?php
namespace jenjetsu\structure\tree;

class TreeNode {

    function __construct(public $data = null, 
                         public $left = null, 
                         public $right = null) {
        $this->data = $data;
        $this->left = $left;
        $this->right = $right;
    }

    function __destruct() {
        $this->data = null;
        $this->left = null;
        $this->right = null;
    }

    function __clone(){
        $this->data = is_object($this->data) ? clone $this->data : $this->data;
        $this->left = is_null($this->left) ? null : clone $this->left;
        $this->right = is_null($this->right) ? null : clone $this->right;
    }
}