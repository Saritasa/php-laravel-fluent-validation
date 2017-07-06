<?php

namespace Saritasa\Laravel\Validation;

class StringRuleSet extends RuleSet
{
    const EXPOSED_RULES = ['email', 'regex'];

    public function __construct(array $rules = [])
    {
        parent::__construct(self::mergeIfNotExists('string', $rules));
    }

    public function email(): StringRuleSet
    {
        return $this->appendIfNotExists('email');
    }

    public function regex(string $pattern, bool $ignoreCase = false): StringRuleSet
    {
        if (!starts_with($pattern, '/')) {
            $pattern = "/$pattern/";
        }
        if ($ignoreCase && !ends_with('i', $pattern)) {
            $pattern .= 'i';
        }
        return $this->appendIfNotExists("regex:$pattern");
    }
}
