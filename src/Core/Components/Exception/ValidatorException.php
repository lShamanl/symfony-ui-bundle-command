<?php

declare(strict_types=1);

namespace SymfonyBundle\UIBundle\Command\Core\Components\Exception;

use SymfonyBundle\UIBundle\Foundation\Core\Components\Exception\DomainException;
use Throwable;

class ValidatorException extends DomainException
{
    public function __construct(
        string $message = "",
        ?int $code = 400,
        ?Throwable $previous = null
    ) {
        parent::__construct($message, (int) $code, $previous);
    }
}
