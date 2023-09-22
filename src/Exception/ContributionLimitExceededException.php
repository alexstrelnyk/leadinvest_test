<?php
declare(strict_types=1);

namespace App\Exception;

use LogicException;

class ContributionLimitExceededException extends LogicException
{
    /**
     * ContributionLimitExceededException constructor.
     * @param string $message
     */
    public function __construct($message = 'Contribution Limit Exceeded')
    {
        parent::__construct($message, 500);
    }
}