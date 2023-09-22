<?php
declare(strict_types=1);

namespace App\Factory;

use App\Entity\Loan;
use DateTime;

class LoanFactory
{
    /**
     * @param float $amount
     * @param DateTime $start
     * @param DateTime $end
     * @return Loan
     */
    public function create(float $amount, DateTime $start, DateTime $end): Loan
    {
        return new Loan($amount, $start, $end);
    }
}
