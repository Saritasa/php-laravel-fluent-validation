<?php

namespace Saritasa\Laravel\Validation;

use Carbon\Carbon;

/**
 * Validation rules, sensible only for dates
 */
class DateRuleSet extends RuleSet
{
    public function __construct(array $rules = [])
    {
        parent::__construct(static::mergeIfNotExists('date', $rules));
    }

    const EXPOSED_RULES = [
        'after',
        'afterOrEqual',
        'before',
        'beforeOrEqual',
        'dateFormat'
    ];


    /**
     * The field under validation must be a value after a given date.
     * The dates will be passed into the  strtotime PHP function.
     *
     * Ex. 'start_date' => 'required|date|after:tomorrow'
     *
     * Instead of passing a date string to be evaluated by strtotime,
     * you may specify another field to compare against the date
     *
     * 'finish_date' => 'required|date|after:start_date'
     *
     * @param Carbon|string $date Value must be after this date
     * @return $this|static
     */
    public function after($date)
    {
        return $this->appendIfNotExists("after:$date");
    }

    /**
     * The field under validation must be a value after or equal to the given date.
     * For more information, see the after rule.
     *
     * @see after
     * @param Carbon|string $date Value must be after or equal this date
     * @return $this|static
     */
    public function afterOrEqual($date)
    {
        return $this->appendIfNotExists("after_or_equal:$date");
    }

    /**
     * The field under validation must be a value preceding the given date.
     * The dates will be passed into the PHP strtotime function.
     *
     * @param Carbon|string $date Value must be preceding this date
     * @return $this|static
     */
    public function before($date)
    {
        return $this->appendIfNotExists("before:$date");
    }

    /**
     * The field under validation must be a value preceding or equal to the given date.
     * The dates will be passed into the PHP strtotime function.
     *
     * @param Carbon|string $date Value must be before or equal this date
     * @return $this|static
     */
    public function beforeOrEqual($date)
    {
        return $this->appendIfNotExists("before_or_equal:$date");
    }
}
