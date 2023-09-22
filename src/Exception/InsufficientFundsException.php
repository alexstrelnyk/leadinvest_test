<?php
declare(strict_types=1);

namespace App\Exception;

use LogicException;

class InsufficientFundsException extends LogicException
{
    /**
     * InsufficientFundsException constructor.
     * @param string $message
     */
    public function __construct(string $message = 'Insufficient funds')
    {
        parent::__construct($message, 500);
    }
}
