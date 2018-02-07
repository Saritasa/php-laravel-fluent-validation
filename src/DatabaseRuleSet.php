<?php

namespace Saritasa\Laravel\Validation;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Config;
use Saritasa\Exceptions\ConfigurationException;

/**
 * Validate values against database (performs queries directly to DB, using Eloquent)
 */
class DatabaseRuleSet extends GenericRuleSet
{
    const EXPOSED_RULES = ['exists', 'modelExists', 'unique'];

    public function __construct(array $rules = [])
    {
        if (!Config::get('validation.allow_db', false)) {
            throw new ConfigurationException("Validation against database is disabled. "
                ."To use validation rules, like 'exists', 'unique', etc. set configuration parameter "
                ."'validation.allow_db' = true");
        }

        parent::__construct($rules);
    }

    /**
     * Get a exists constraint builder instance.
     *
     * @param  string $table Table in database, in which lookup should be performed
     * @param  string $column Column in table, in which lookup should be performed
     * @param \Closure|null $callback callback, that will receive \Illuminate\Validation\Rules\Exists $rule
     * @return GenericRuleSet
     * @see \Illuminate\Validation\Rules\Exists
     */
    public function exists(string $table, string $column = 'NULL', \Closure $callback = null): GenericRuleSet
    {
        $rule = \Illuminate\Validation\Rule::exists($table, $column);
        if ($callback !== null) {
            $callback($rule);
        }
        return $this->appendIfNotExists((string)$rule);
    }

    /**
     * Get a exists constraint builder instance by model class.
     *
     * @param string $modelClass Enumeration to validate against
     * @param \Closure|null $callback callback, that will receive \Illuminate\Validation\Rules\Exists $rule
     * @return GenericRuleSet
     * @see \Illuminate\Validation\Rules\Exists
     * @see DatabaseRuleSet::exists
     */
    public function modelExists(string $modelClass, \Closure $callback = null): GenericRuleSet
    {
        if (!is_a($modelClass, Model::class, true)) {
            throw new \UnexpectedValueException('Class is not a Model subclass');
        }
        /**
         * Model instance to retrieve rule details.
         *
         * @var Model $model
         */
        $model = new $modelClass();

        return $this->appendIfNotExists(Rule::exists($model->getTable(), $model->getKeyName(), $callback));
    }

    /**
     * Get a unique constraint builder instance.
     *
     * @param  string $table Table in database, in which lookup should be performed
     * @param  string $column Column in table, in which lookup should be performed
     * @param \Closure|null $callback callback, that will receive \Illuminate\Validation\Rules\Unique $rule
     * @return GenericRuleSet
     */
    public function unique(string $table, string $column = 'NULL', \Closure $callback = null): GenericRuleSet
    {
        if ($callback !== null) {
            $rule = \Illuminate\Validation\Rule::unique($table, $column);
            $callback($rule);
        } else {
            $rule = "unique:$table,$column";
        }
        return $this->appendIfNotExists((string)$rule);
    }
}
