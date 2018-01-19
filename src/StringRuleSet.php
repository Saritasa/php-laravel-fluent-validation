<?php

namespace Saritasa\Laravel\Validation;

use Illuminate\Support\Str;
use Saritasa\Enum;

/**
 * Rules, that are reasonable for strings only
 *
 * @method StringRuleSet activeUrl() The field under validation must have a valid A or AAAA record according to the dns_get_record PHP function.
 * @method StringRuleSet alpha() The field under validation must be entirely alphabetic characters.
 * @method StringRuleSet alphaDash() The field under validation may have alpha-numeric characters, as well as dashes and underscores.
 * @method StringRuleSet alphaNum() The field under validation must be entirely alpha-numeric characters.
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
    const EXPOSED_RULES = ['email', 'regex', 'timezone', 'phoneRegex', 'enum'];

    const TRIVIAL_STRING_RULES = [
        'activeUrl',
        'alpha',
        'alphaDash',
        'alphaNum',
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
     *
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
     * Field under validation must match one of values of specified Enum
     *
     * @see https://github.com/Saritasa/php-common#enum
     *
     * @param string $enumClass Enumeration to validate against
     * @return StringRuleSet
     */
    public function enum(string $enumClass): StringRuleSet
    {
        if (!is_a($enumClass, Enum::class, true)) {
            throw new \UnexpectedValueException('Class is not enum');
        }
        return $this->appendIfNotExists(Rule::in($enumClass::getConstants()));
    }

    /**
     * Shortcut method for validating phone with use regex.
     * The method uses E.164 format for validation. (ex: +12345678901)
     *
     * For more difficult validation needs use \Saritasa\Laravel\Validation\Rule::phone()
     *
     * @see \Saritasa\Laravel\Validation\Rule::phone()
     *
     * @return StringRuleSet
     */
    public function phoneRegex()
    {
        return $this->regex('/^\+(?:[0-9]?){6,14}[0-9]$/');
    }

    public function __call($name, $arguments)
    {
        if (in_array($name, static::TRIVIAL_STRING_RULES)) {
            return $this->appendIfNotExists(Str::snake($name));
        }
        return parent::__call($name, $arguments);
    }
}
