<?php

namespace jenjetsu\structure\tree;

require_once "TreeNode.php";

interface Tree {
    public function add($value);
    public function contains($value) : bool;
    public function remove($value) : bool;
    public function preOrder() : iterable;
    public function postOrder() : iterable;
    public function inOrder() : iterable;
    public function minValue() : mixed;
    public function maxValue() : mixed;
    public function clear();
}