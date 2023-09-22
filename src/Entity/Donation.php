<?php
declare(strict_types=1);

namespace App\Entity;

use DateTime;

class Donation
{
    /**
     * @var Tranche
     */
    protected $tranche;

    /**
     * @var Investor
     */
    protected $investor;

    /**
     * @var float
     */
    protected $amount;

    /**
     * @var DateTime
     */
    protected $date;

    /**
     * Donation constructor.
     * @param Tranche $tranche
     * @param Investor $investor
     * @param float $amount
     * @param DateTime $date
     */
    public function __construct(Tranche $tranche, Investor $investor, float $amount, DateTime $date)
    {
        $this->tranche = $tranche;
        $this->investor = $investor;
        $this->amount = $amount;
        $this->date = $date;
    }

    /**
     * @return Tranche
     */
    public function getTranche(): Tranche
    {
        return $this->tranche;
    }

    /**
     * @return Investor
     */
    public function getInvestor(): Investor
    {
        return $this->investor;
    }

    /**
     * @return float
     */
    public function getAmount(): float
    {
        return $this->amount;
    }

    /**
     * @return DateTime
     */
    public function getDate(): DateTime
    {
        return $this->date;
    }
}
