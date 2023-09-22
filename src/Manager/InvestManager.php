<?php
declare(strict_types=1);

namespace App\Manager;

use App\Entity\Donation;
use App\Entity\Investor;
use App\Entity\Tranche;
use App\Exception\ContributionLimitExceededException;
use App\Factory\DonationFactory;
use DateTime;

class InvestManager
{
    /**
     * @var DonationFactory
     */
    private $donationFactory;

    /**
     * InvestManager constructor.
     * @param DonationFactory $donationFactory
     */
    public function __construct(DonationFactory $donationFactory)
    {
        $this->donationFactory = $donationFactory;
    }

    /**
     * @param Tranche $tranche
     * @param Investor $investor
     * @param float $amount
     * @param DateTime|null $date
     * @return Donation
     */
    public function investToTranche(Tranche $tranche, Investor $investor, float $amount, DateTime $date = null): Donation
    {
        if ($tranche->getMaxAmount() < $amount + $tranche->getDonated()) {
            throw new ContributionLimitExceededException();
        }

        $amount = $investor->take($amount);

        return $this->donationFactory->create($tranche, $investor, $amount, $date);
    }
}
