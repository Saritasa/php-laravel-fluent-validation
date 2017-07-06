<?php

namespace Saritasa\Laravel\Validation;

/**
 * Rules, that are reasonable for strings only
 */
class StringRuleSet extends RuleSet
{
    const EXPOSED_RULES = ['email', 'regex', 'timezone'];

    public function __construct(array $rules = [])
    {
        parent::__construct(self::mergeIfNotExists('string', $rules));
    }

    /**
     * The field under validation must be formatted as an e-mail address.
     * @return StringRuleSet
     */
    public function email(): StringRuleSet
    {
        return $this->appendIfNotExists('email');
    }

    /**
     * The field under validation must match the given regular expression.
     * @param string $pattern
     * @param bool $ignoreCase
     * @return StringRuleSet
     */
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

    /**
     * The field under validation must be a valid timezone identifier according to the  timezone_identifiers_list PHP function.
     * @return StringRuleSet
     */
    public function timezone(): StringRuleSet
    {
        return $this->appendIfNotExists('timezone');
    }
}
