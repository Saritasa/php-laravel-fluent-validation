<?php

namespace Saritasa\Laravel\Validation;

use Illuminate\Support\Str;

/**
 * Rules, that are reasonable for strings only
 *
 * @method StringRuleSet activeUrl() The field under validation must have a valid A or AAAA record according to the dns_get_record PHP function.
 * @method StringRuleSet email() The field under validation must be formatted as an e-mail address.
 * @method StringRuleSet ip() The field under validation must be an IP address.
 * @method StringRuleSet ipv4() The field under validation must be an IPv4 address.
 * @method StringRuleSet ipv6() The field under validation must be an IPv6 address.
 * @method StringRuleSet json() The field under validation must be a valid JSON string.
 * @method StringRuleSet timezone() The field under validation must be a valid timezone identifier according to the timezone_identifiers_list PHP function
 * @method StringRuleSet url() The field under validation must be a valid URL.
 */
class StringRuleSet extends RuleSet
{
    const EXPOSED_RULES = ['email', 'regex', 'timezone'];

    const TRIVIAL_STRING_RULES = [
        'activeUrl',
        'email',
        'ip',
        'ipv4',
        'ipv6',
        'json',
        'timezone',
        'url'
    ];

    public function __construct(array $rules = [])
    {
        parent::__construct(self::mergeIfNotExists('string', $rules));
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

    function __call($name, $arguments)
    {
        if (in_array($name, static::TRIVIAL_STRING_RULES)) {
            return $this->appendIfNotExists(Str::snake($name));
        }
        return parent::__call($name, $arguments);
    }
}
