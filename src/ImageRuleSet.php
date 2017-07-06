<?php

namespace Saritasa\Laravel\Validation;

use Illuminate\Validation\Rules\Dimensions;
use Saritasa\Exceptions\NotImplementedException;

class ImageRuleSet extends FileRuleSet
{
    /** @var  Dimensions */
    protected $dimensions;

    public function __construct(array $constraints = [], array $rules = [])
    {
        $this->dimensions = new Dimensions($constraints);
        parent::__construct(array_merge($rules, [$this->dimensions]));
    }

    function __call($name, $arguments)
    {
        if (in_array($name, ['width', 'height', 'minWidth', 'minHeight', 'maxWidth', 'maxHeight', 'ratio'])) {
            $this->dimensions->$name($arguments);
            return $this;
        }
        throw new NotImplementedException("Unknown Image Rule $name");
    }
}
