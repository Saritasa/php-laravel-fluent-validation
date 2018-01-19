<?php

namespace Saritasa\Laravel\Validation;

use Illuminate\Validation\Rules\Dimensions;
use Saritasa\Exceptions\NotImplementedException;

/**
 * Image validation rules. In addition to file validation has image dimensions rules
 * (width, height, ratio of width and height).
 *
 * @see https://laravel.com/docs/5.5/validation#rule-dimensions
 *
 * @method ImageRuleSet width(int $width)
 * @method ImageRuleSet height(int $height)
 * @method ImageRuleSet minWidth(int $width)
 * @method ImageRuleSet minHeight(int $height)
 * @method ImageRuleSet maxWidth(int $width)
 * @method ImageRuleSet maxHeight(int $height)
 */
class ImageRuleSet extends FileRuleSet
{
    /**
     * Expected image dimensions
     *
     * @var Dimensions
     */
    protected $dimensions;

    /**
     * Image validation rules. In addition to file validation has image dimensions rules
     * (width, height, ratio of width and height).
     *
     * @see https://laravel.com/docs/5.5/validation#rule-dimensions
     *
     * @param array $rules Additional validation rules
     * @param mixed|array|\Closure|Dimensions $constraints Image dimension constraints
     */
    public function __construct(array $rules = [], $constraints = [])
    {
        $this->dimensions($constraints);
        parent::__construct(self::mergeIfNotExists('image', $rules));
    }

    /**
     * The field under validation must be a successfully uploaded file.
     *
     * @return $this|static
     */
    public function file()
    {
        return $this->appendIfNotExists('file');
    }

    public function __call(string $name, array $arguments)
    {
        if (in_array($name, ['width', 'height', 'minWidth', 'minHeight', 'maxWidth', 'maxHeight', 'ratio'])) {
            if ($this->dimensions == null) {
                $this->dimensions = new Dimensions();
            }
            call_user_func_array([$this->dimensions, $name], $arguments);
            return $this;
        }
        throw new NotImplementedException("Unknown Image Rule $name");
    }

    /**
     * Image dimension constraints
     *
     * @param array|\Closure|Dimensions $constraints Image dimensions constraints
     * @return $this
     * @see \Illuminate\Validation\Rules\Dimensions
     */
    public function dimensions($constraints)
    {
        if ($constraints instanceof Dimensions) {
            $this->dimensions = $constraints;
        } elseif (is_array($constraints) && !empty($constraints)) {
            $this->dimensions = new Dimensions($constraints);
        } elseif (is_callable($constraints)) {
            $this->dimensions = new Dimensions();
            $constraints($this->dimensions);
        }
        return $this;
    }

    public function toArray(): array
    {
        if (!$this->dimensions) {
            return parent::toArray();
        }
        return self::mergeIfNotExists($this->dimensions, parent::toArray());
    }
}
