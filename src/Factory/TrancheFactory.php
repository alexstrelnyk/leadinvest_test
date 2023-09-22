<?php
declare(strict_types=1);

namespace App\Factory;

use App\Entity\Loan;
use App\Entity\Tranche;

class TrancheFactory
{
    /**
     * @param Loan $loan
     * @param float $monthlyInterestRate
     * @param float $maxAmount
     * @return Tranche
     */
    public function create(Loan $loan, float $monthlyInterestRate, float $maxAmount, string $name): Tranche
    {
        $tranche = new Tranche($loan, $monthlyInterestRate, $maxAmount, $name);
        $loan->addTranche($tranche);
        return $tranche;
    }
}
