<?php

namespace Saritasa\Laravel\Validation;

use Illuminate\Validation\Rules\Dimensions;
use Saritasa\Exceptions\NotImplementedException;

class ImageRuleSet extends FileRuleSet
{
    /** @var  Dimensions */
    protected $dimensions;

    /**
     * ImageRuleSet constructor.
     * @param array|\Closure|Dimensions $constraints
     * @param array $rules
     */
    public function __construct(array $rules = [], $constraints = [])
    {
        $this->dimensions($constraints);
        parent::__construct(self::mergeIfNotExists('image', $rules));
    }

    /**
     * The field under validation must be a successfully uploaded file.
     * @return $this|static
     */
    public function file()
    {
        return $this->appendIfNotExists('file');
    }

    function __call($name, $arguments)
    {
        if (in_array($name, ['width', 'height', 'minWidth', 'minHeight', 'maxWidth', 'maxHeight', 'ratio'])) {
            if ($this->dimensions == null) {
                $this->dimensions = new Dimensions();
            }
            $this->dimensions->$name($arguments);
            return $this;
        }
        throw new NotImplementedException("Unknown Image Rule $name");
    }

    /**
     * @param array|\Closure|Dimensions $constraints
     */
    public function dimensions($constraints) {
        if ($constraints instanceof Dimensions) {
            $this->dimensions = $constraints;
        } elseif (is_array($constraints) && !empty($constraints)) {
            $this->dimensions = new Dimensions($constraints);
        } elseif (is_callable($constraints)) {
            $this->dimensions = new Dimensions();
            $constraints($this->dimensions);
        }
    }

    public function toArray(): array
    {
        if (!$this->dimensions) {
            return parent::toArray();
        }
        return self::mergeIfNotExists($this->dimensions, parent::toArray());
    }
}
