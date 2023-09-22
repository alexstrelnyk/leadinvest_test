<?php
declare(strict_types=1);

namespace App\Factory;

use App\Entity\Donation;
use App\Entity\Investor;
use App\Entity\Tranche;
use App\Exception\TryInvestToExpiredLoanException;
use DateTime;

class DonationFactory
{
    /**
     * @param Tranche $tranche
     * @param Investor $investor
     * @param float $amount
     * @param DateTime|null $date
     * @return Donation
     * @throws
     */
    public function create(Tranche $tranche, Investor $investor, float $amount, DateTime $date = null): Donation
    {
        $date = $date ?? new DateTime();

        if ($date > $tranche->getLoan()->getDateEnd() || $date < $tranche->getLoan()->getDateStart()) {
            throw new TryInvestToExpiredLoanException();
        }

        $donation = new Donation($tranche, $investor, $amount, $date);
        $tranche->addDonation($donation);
        return $donation;
    }
}