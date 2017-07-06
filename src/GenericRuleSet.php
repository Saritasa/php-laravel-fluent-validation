<?php

namespace Saritasa\Laravel\Validation;

use Illuminate\Support\Str;

/**
 * @method FileRuleSet dimensions(array $constraints) Get a dimensions constraint builder instance.
 * @method GenericRuleSet exists(string $table, string $column, \Closure $closure = null) Get a exists constraint builder instance.
 * @method GenericRuleSet unique(string $table, string $column, \Closure $closure = null) Get a unique constraint builder instance.
 *
 * @method StringRuleSet activeUrl() The field under validation must have a valid A or AAAA record according to the dns_get_record PHP function.
 * @method StringRuleSet email() The field under validation must be formatted as an e-mail address.
 * @method static StringRuleSet ip() The field under validation must be an IP address.
 * @method static StringRuleSet ipv4() The field under validation must be an IPv4 address.
 * @method static StringRuleSet ipv6() The field under validation must be an IPv6 address.
 * @method static StringRuleSet json() The field under validation must be a valid JSON string.
 * @method static StringRuleSet timezone() The field under validation must be a valid timezone identifier according to the timezone_identifiers_list PHP function
 * @method static StringRuleSet url() The field under validation must be a valid URL.

 * @method static FileRuleSet mimetypes(string ...$types) The file under validation must match one of the given MIME types. To determine the MIME type of the uploaded file, the file's contents will be read and the framework will attempt to guess the MIME type, which may be different from the client provided MIME type.
 * @method static FileRuleSet mimes(string ...$extensions) The file under validation must have a MIME type corresponding to one of the listed extensions.
 */
class GenericRuleSet extends RuleSet
{
    const EXPOSED_RULES = ['int', 'numeric', 'string'];

    /**
     * The field under validation must be an integer.
     * @return IntRuleSet
     */
    function int(): IntRuleSet
    {
        return new IntRuleSet($this->rules);
    }

    /**
     * The field under validation must be numeric.
     * @return NumericRuleSet
     */
    function numeric(): NumericRuleSet
    {
        return new NumericRuleSet($this->rules);
    }

    /**
     * The field under validation must be a string. If you would like to allow the field to also be null, you should assign the nullable rule to the field.
     * @return StringRuleSet
     */
    function string(): StringRuleSet
    {
        return new StringRuleSet($this->rules);
    }

    /**
     * The field under validation must be a successfully uploaded file.
     * @return FileRuleSet
     */
    function file(): FileRuleSet
    {
        return new FileRuleSet($this->rules);
    }

    function __call($name, $arguments)
    {
        $ruleSet = null;
        if (in_array($name, StringRuleSet::EXPOSED_RULES)) {
            $ruleSet = new StringRuleSet($this->rules);
        } elseif (in_array($name, IntRuleSet::EXPOSED_RULES)) {
            $ruleSet = new IntRuleSet($this->rules);
        } elseif (in_array($name, DatabaseRuleSet::EXPOSED_RULES)) {
            $ruleSet = new DatabaseRuleSet($this->rules);
        } elseif (in_array($name, static::TRIVIAL_RULES)) {
            return $this->appendIfNotExists(Str::snake($name));
        } elseif (in_array($name, FileRuleSet::EXPOSED_RULES)) {
            $ruleSet = new FileRuleSet($this->rules);
        } else {
            return parent::__call($name, $arguments);
        }
        return call_user_func_array([$ruleSet, $name], $arguments);
    }
}
