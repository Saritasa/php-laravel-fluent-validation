<?php

namespace Saritasa\Laravel\Validation;

/**
 * Each rule or rule set in this package inherits this interface,
 * so we can distinguish them from other classes
 */
interface IRule
{
    /** Magic method, called on explicit or implicit casting to string */
    public function __toString(): string;
}
