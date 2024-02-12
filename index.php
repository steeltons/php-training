<?php

require 'Tree/BinaryTree.php';
use jenjetsu\structure\tree\BinaryTree;

$tree = new BinaryTree();
$tree->add(10);
$tree->add(8);
$tree->add(12);
$tree->add(6);
$tree->add(9);
$tree->add(11);
$tree->add(14);
$tree->add(4);
$tree->add(7);
$tree->add(13);
$clone = clone $tree;
$clone->remove(10);
echo '======================ORIGINAL TREE===========================';
print_r($tree->postOrder());
echo '======================CLONE TREE===========================';
print_r($clone->postOrder());

