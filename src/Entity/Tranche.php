<?php

declare(strict_types=1);

namespace App\Entity;

use App\Exception\ContributionLimitExceededException;

class Tranche
{
    /**
     * @var Loan
     */
    protected $loan;

    /**
     * @var float
     */
    protected $monthlyInterestRate;

    /**
     * @var float
     */
    protected $maxAmount;

    /**
     * @var Donation[]
     */
    protected $donations = [];

    /**
     * @var float
     */
    private $donated = 0;

    /**
     * @var string
     */
    private $name;

    /**
     * Tranche constructor.
     * @param Loan $loan
     * @param float $monthlyInterestRate
     * @param float $maxAmount
     * @param string $name
     */
    public function __construct(Loan $loan, float $monthlyInterestRate, float $maxAmount, string $name)
    {
        $this->loan = $loan;
        $this->monthlyInterestRate = $monthlyInterestRate;
        $this->maxAmount = $maxAmount;
        $this->name = $name;
    }

    /**
     * @return Loan
     */
    public function getLoan(): Loan
    {
        return $this->loan;
    }

    /**
     * @return float
     */
    public function getMonthlyInterestRate(): float
    {
        return $this->monthlyInterestRate;
    }

    /**
     * @return float
     */
    public function getMaxAmount(): float
    {
        return $this->maxAmount;
    }

    /**
     * @param Donation $donation
     */
    public function addDonation(Donation $donation): void
    {
        if ($this->maxAmount < $this->donated + $donation->getAmount() ) {
            throw new ContributionLimitExceededException();
        }

        $this->donations[] = $donation;
        $this->donated += $donation->getAmount();
    }

    /**
     * @return float
     */
    public function getDonated(): float
    {
        return $this->donated;
    }

    /**
     * @return Donation[]
     */
    public function getDonations(): array
    {
        return $this->donations;
    }
}
