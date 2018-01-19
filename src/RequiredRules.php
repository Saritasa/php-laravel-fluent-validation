<?php

namespace Saritasa\Laravel\Validation;

/**
 * Variations of Required rules
 */
trait RequiredRules
{
    /**
    The field under validation must be present in the input data and not empty. A field is considered "empty" if one of the following conditions are true:

    The value is null.
    The value is an empty string.
    The value is an empty array or empty Countable object.
    The value is an uploaded file with no path.

     * @return static
     */
    public function required()
    {
        return $this->appendIfNotExists('required');
    }

    /**
     * The field under validation must be present and not empty only if any of the other specified fields are present.
     *
     * @param \string[] $otherFields Field is required, if any of these fields present
     * @return static
     */
    public function requiredWith(string ...$otherFields)
    {
        return $this->appendIfNotExists("required_with:".implode(',', $otherFields));
    }

    /**
     * The field under validation must be present and not empty only if all of the other specified fields are present.
     *
     * @param \string[] ...$otherFields Field is required, if all of these fields present
     * @return static
     */
    public function requiredWithAll(string ...$otherFields)
    {
        return $this->appendIfNotExists("required_with_all:".implode(',', $otherFields));
    }

    /**
     * The field under validation must be present and not empty only when any of the other specified fields are not present.
     *
     * @param \string[] ...$otherFields Field is required, if any of these fields is absent
     * @return static
     */
    public function requiredWithout(string ...$otherFields)
    {
        return $this->appendIfNotExists("required_without:".implode(',', $otherFields));
    }

    /**
     * The field under validation must be present and not empty only when all of the other specified fields are not present.
     *
     * @param \string[] ...$otherFields Field is required, if all of these fields absent
     * @return static
     */
    public function requiredWithoutAll(string ...$otherFields)
    {
        return $this->appendIfNotExists("required_without_all:".implode(',', $otherFields));
    }

    /**
     * The field under validation must be present and not empty if the anotherField field is equal to any value.
     *
     * @param string $anotherField Field name to compare with
     * @param mixed $value Value of another field to compare with
     * @return static
     */
    public function requiredIf(string $anotherField, $value)
    {
        return $this->appendIfNotExists("required_if:$anotherField,$value");
    }

    /**
     * The field under validation must be present and not empty unless the anotherField field is equal to any value.
     *
     * @param string $anotherField Field to compare with
     * @param mixed $value Value of another field to compare with
     * @return static
     */
    public function requiredUnless(string $anotherField, $value)
    {
        return $this->appendIfNotExists("required_unless:$anotherField,$value");
    }
}
