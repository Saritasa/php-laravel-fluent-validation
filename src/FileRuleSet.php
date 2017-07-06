<?php

namespace Saritasa\Laravel\Validation;

class FileRuleSet extends RuleSet
{
    const EXPOSED_RULES = ['min', 'max'];

    public function __construct(array $rules = [])
    {
        if ($rules) {
            if (!in_array('image', $rules)) {
                $rules = self::mergeIfNotExists('file', $rules);
            }
        } else {
            $rules = ['file'];
        }

        parent::__construct($rules);
    }

    /**
     * @param array|\Closure $constraints
     * @return ImageRuleSet
     */
    public function image($constraints = []): ImageRuleSet
    {
        return new ImageRuleSet($this->rules, $constraints);
    }
}
