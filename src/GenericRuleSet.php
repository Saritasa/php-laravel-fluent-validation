<?php

namespace Saritasa\Laravel\Validation;

use Carbon\Carbon;
use Illuminate\Support\Str;

/**
 * @method ImageRuleSet dimensions(array $constraints) Get a dimensions constraint builder instance.
 * @method GenericRuleSet exists(string $table, string $column, \Closure $closure = null) Get a exists constraint builder instance.
 * @method GenericRuleSet unique(string $table, string $column, \Closure $closure = null) Get a unique constraint builder instance.
 *
 * @method StringRuleSet activeUrl() The field under validation must have a valid A or AAAA record according to the dns_get_record PHP function.
 * @method StringRuleSet email() The field under validation must be formatted as an e-mail address.
 * @method StringRuleSet ip() The field under validation must be an IP address.
 * @method StringRuleSet ipv4() The field under validation must be an IPv4 address.
 * @method StringRuleSet ipv6() The field under validation must be an IPv6 address.
 * @method StringRuleSet json() The field under validation must be a valid JSON string.
 * @method StringRuleSet timezone() The field under validation must be a valid timezone identifier according to the timezone_identifiers_list PHP function
 * @method StringRuleSet url() The field under validation must be a valid URL.
 * @method FileRuleSet mimetypes(string ...$types) The file under validation must match one of the given MIME types. To determine the MIME type of the uploaded file, the file's contents will be read and the framework will attempt to guess the MIME type, which may be different from the client provided MIME type.
 * @method FileRuleSet mimes(string ...$extensions) The file under validation must have a MIME type corresponding to one of the listed extensions.
 *
 * @method DateRuleSet date() The field under validation must be a valid date according to the strtotime PHP function.
 * @method DateRuleSet after(Carbon|string $date) The field under validation must be a value after a given date. The dates will be passed into the  strtotime PHP function
 * @method DateRuleSet afterOrEqual(Carbon|string $date) The field under validation must be a value after or equal to the given date. For more information, see the after rule.
 * @method DateRuleSet before(Carbon|string $date) The field under validation must be a value preceding the given date. The dates will be passed into the PHP strtotime function.
 * @method DateRuleSet beforeOrEqual(Carbon|string $date) The field under validation must be a value preceding or equal to the given date. The dates will be passed into the PHP strtotime function.

 * @method NumericRuleSet digits($length) The field under validation must be numeric and must have an exact length of value.
 * @method NumericRuleSet digitsBetween($minLength, $maxLength) The field under validation must have a length between the given min and max.
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
     * The field under validation must be able to be cast as a boolean. Accepted input are true,  false, 1, 0, "1", and "0".
     * @return GenericRuleSet
     */
    function boolean(): GenericRuleSet
    {
        return $this->appendIfNotExists('boolean');
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
        } elseif (in_array($name, DateRuleSet::EXPOSED_RULES)) {
            $ruleSet = new DateRuleSet($this->rules);
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
