<?php

namespace jenjetsu\structure\tree;
require_once "Comparator.php";
require_once "TreeNode.php";
require_once "Tree.php";

class BinaryTree implements Tree{

    protected ?TreeNode $head;
    protected readonly ?Comparator $COMPARATOR;
    
    public function __construct(Comparator $comparator = null){
        $this->head = null;
        if (is_null($comparator)) {
            $this->COMPARATOR = new class implements Comparator{
                public function compare(mixed $a1, mixed $a2) : int {return $a1 - $a2;}
            };
        } else {
            $this->COMPARATOR = $comparator;
        }
    }

    function __destruct() {
        $this->clear();
    }

    function __clone() {
        $this->COMPARATOR = clone $this->COMPARATOR;
        $this->head = is_null($this->head) ? null : clone $this->head;
    }

    //=========================================================================
    // Add tree section
    //=========================================================================
    public function add($value) {
        $this->addValue($this->head, $value);
    }

    private function addValue(?TreeNode &$currentNode, $value) {
        if ($currentNode == null) {
            $currentNode = new TreeNode($value);
        }
        elseif($this->COMPARATOR->compare($value, $currentNode->data) > 0) {
            $this->addValue($currentNode->right, $value);
        } else {
            $this->addValue($currentNode->left, $value);
        }
    }

    //=========================================================================
    // Check contains tree section
    //=========================================================================
    public function contains($value) : bool {
        return $this->containsValue($this->head, $value);
    }

    private function containsValue(?TreeNode &$currentNode, $value) : bool {
        if ($currentNode == null) {
            return false;
        } elseif ($this->COMPARATOR->compare($currentNode->data, $value) == 0) {
            return true;
        } else {
            return ($this->COMPARATOR->compare($value, $currentNode->data) > 0)
                   ? $this->containsValue($currentNode->right, $value)
                   : $this->containsValue($currentNode->left, $value);
        }
    }

    //=========================================================================
    // Remove value tree section
    //=========================================================================
    public function remove($value) : bool {
        return $this->removeValue($this->head, $value);
    }

    private function removeValue(?TreeNode &$currentNode, $value) : bool {
        if ($currentNode == null) {
            return false;
        }
        $compareResult = $this->COMPARATOR->compare($value, $currentNode->data);
        if ($compareResult > 0) {
            return $this->removeValue($currentNode->right, $value);
        } elseif ($compareResult < 0) {
            return $this->removeValue($currentNode->left, $value);
        } else {
            $q = $currentNode;
            if ($q->right == null) {
                $currentNode = $q->left;
            } elseif ($q->left == null) {
                $currentNode = $q->right;
            } else {
                $currentNode->data = $this->removeNode($currentNode, $currentNode->right)->data;
            }
            unset($q);
            $q = null;
            return true;
        }
    }

    private function removeNode(TreeNode $parentNode, TreeNode $childNode) : TreeNode {
        if ($childNode->left != null) {
            return $this->removeNode($childNode, $childNode->left);
        } else {
            if ($parentNode->left === $childNode) {
                $parentNode->left = $childNode->right;
            } else {
                $parentNode->right = $childNode->right;
            }
            $childNode->right = null;
            return $childNode;
        }
    }

    //=========================================================================
    // Search min/max values section
    //=========================================================================
    public function minValue() : mixed {
        $currentNode = $this->head;
        while ($currentNode->left != null) {
            $currentNode = $currentNode->left;
        }
        return $currentNode->data;
    }

    public function maxValue() : mixed {
        $currentNode = $this->head;
        while ($currentNode->right != null) {
            $currentNode = $currentNode->right;
        }
        return $currentNode->data;
    }

    //=========================================================================
    // Pre/In/Post order tree traversal section
    //=========================================================================

    public function preOrder() : iterable {
        $array  = [];
        $callback = function(?TreeNode $currentNode, &$array) use (&$callback) {
            if ($currentNode == null) {
                return;
            }
            array_push($array, $currentNode->data);
            $callback($currentNode->left, $array);
            $callback($currentNode->right, $array);
        };
        $callback($this->head, $array);
        return $array;
    }

    public function postOrder(): iterable {
        $array  = [];
        $callback = function(?TreeNode $currentNode, &$array) use (&$callback) {
            if ($currentNode == null) {
                return;
            }
            $callback($currentNode->left, $array);
            $callback($currentNode->right, $array);
            array_push($array, $currentNode->data);
        };
        $callback($this->head, $array);
        return $array;
    }

    public function inOrder() : iterable {
        $array  = [];
        $callback = function(?TreeNode $currentNode, &$array) use (&$callback) {
            if ($currentNode == null) {
                return;
            }
            $callback($currentNode->left, $array);
            array_push($array, $currentNode->data);
            $callback($currentNode->right,$array);
        };
        $callback($this->head, $array);
        return $array;
    }

    //=========================================================================
    // Clear tree section
    //=========================================================================
    public function clear() {
        $nodeArray = [];
        $callback = function(?TreeNode $currentNode) use (&$nodeArray, &$callback) {
            if ($currentNode == null) {
                return;
            }
            $callback($currentNode->left);
            $callback($currentNode->right);
            array_push($nodeArray, $currentNode);
        };
        $callback($this->head);
        foreach($nodeArray as $remNode) {
            $remNode->__destruct();
        }
        unset($this->head);
    }
}