<?php
declare(strict_types=1);

namespace App\Exception;

use LogicException;

class TryInvestToExpiredLoanException extends LogicException
{
    public function __construct()
    {
        parent::__construct('Try invest to expired loan', 500);
    }
}