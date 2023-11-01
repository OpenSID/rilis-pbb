<?php

namespace App\FilterClass;

class MatchKeyword
{
    private $column;

    public function __construct($name)
    {
        $this->column = $name;
    }

    public function __invoke($builder, $keyword)
    {
        $builder->where($this->column, $keyword);
    }
}
