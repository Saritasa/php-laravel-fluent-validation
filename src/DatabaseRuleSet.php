<?php

namespace Saritasa\Laravel\Validation;

use Illuminate\Support\Facades\Config;
use Saritasa\Exceptions\ConfigurationException;

/**
 * Validate values against database (performs queries directly to DB, using Eloquent)
 */
class DatabaseRuleSet extends GenericRuleSet
{
    public function __construct(array $rules = [])
    {
        if (!Config::get('validation.allow_db', false)) {
            throw new ConfigurationException("Validation against database is disabled. "
                ."To to use validation rules, like 'exists', 'unique', etc. set configuration parameter "
                ."'validation.allow_db' = true");
        }

        $this->rules = $rules;
    }

    /**
     * Get a exists constraint builder instance.
     *
     * @param  string  $table
     * @param  string  $column
     * @return GenericRuleSet
     */
    public function exists($table, $column = 'NULL'): GenericRuleSet
    {
        return $this->appendIfNotExists(\Illuminate\Validation\Rule::exists($table, $column));
    }

    /**
     * Get a unique constraint builder instance.
     *
     * @param  string  $table
     * @param  string  $column
     * @return GenericRuleSet
     */
    public function unique($table, $column = 'NULL'): GenericRuleSet
    {
        return $this->appendIfNotExists(\Illuminate\Validation\Rule::unique($table, $column));
    }
}
