<?php
declare(strict_types=1);

namespace App\Entity;

use DateTime;

class Loan
{
    /**
     * @var float
     */
    protected $amount;

    /**
     * @var Tranche[]
     */
    protected $tranches;

    /**
     * @var DateTime
     */
    protected $dateStart;

    /**
     * @var DateTime
     */
    protected $dateEnd;

    /**
     * Loan constructor.
     * @param float $amount
     * @param DateTime $start
     * @param DateTime $end
     */
    public function __construct(float $amount, DateTime $start, DateTime $end)
    {
        $this->amount = $amount;
        $this->dateStart = $start;
        $this->dateEnd = $end;
    }

    /**
     * @return float
     */
    public function getAmount(): float
    {
        return $this->amount;
    }

    /**
     * @param Tranche $tranche
     */
    public function addTranche(Tranche $tranche): void
    {
        $this->tranches[] = $tranche;
    }

    /**
     * @return Tranche[]
     */
    public function getTranches(): array
    {
        return $this->tranches;
    }

    /**
     * @return DateTime
     */
    public function getDateStart(): DateTime
    {
        return $this->dateStart;
    }

    /**
     * @return DateTime
     */
    public function getDateEnd(): DateTime
    {
        return $this->dateEnd;
    }
}
