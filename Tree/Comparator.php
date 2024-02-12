<?php

namespace jenjetsu\structure\tree;

interface Comparator {
    public function compare($a1, $a2) : int;
}