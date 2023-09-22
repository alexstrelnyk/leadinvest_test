<?php
declare(strict_types=1);

namespace App\Service;

use App\Entity\Donation;
use App\Entity\Investor;
use App\Entity\Loan;
use App\Manager\Interfaces\RefundManagerInterface;
use DateTime;

class CalculationService
{
    /**
     * @var RefundManagerInterface
     */
    private $refundManager;

    /**
     * @var Loan
     */
    protected $loan;

    /**
     * @var float[]
     */
    private $results;

    /**
     * CalculationService constructor.
     * @param RefundManagerInterface $refundManager
     */
    public function __construct(RefundManagerInterface $refundManager)
    {
        $this->refundManager = $refundManager;
    }

    /**
     * @param Loan $loan
     */
    public function setLoan(Loan $loan): void
    {
        $this->loan = $loan;
    }

    /**
     * @param Donation $donation
     * @return float
     */
    public function calculateInterest(Donation $donation): float
    {
        $daysInMonth = (int) $donation->getDate()->format('t');
        $profitableDays = (int) $daysInMonth - $donation->getDate()->format('j') + 1; // (+ 1) Include today

        return $donation->getAmount() / $daysInMonth *
            $donation->getTranche()->getMonthlyInterestRate() / 100 * $profitableDays;
    }

    /**
     * @param Donation $donation
     */
    public function calculateAndRefund(Donation $donation): void
    {
        $earnings = $this->calculateInterest($donation);
        $this->results[$donation->getInvestor()->getIdentifier()]
            = $this->results[$donation->getInvestor()->getIdentifier()] ?? 0 + $earnings;
        $this->refundManager->refund($donation->getInvestor(), $earnings);
    }

    /**
     * @param DateTime $dateFrom
     * @param DateTime $dateTo
     */
    public function calculate(DateTime $dateFrom, DateTime $dateTo): void
    {
        foreach ($this->loan->getTranches() as $tranche) {
            foreach ($tranche->getDonations() as $donation) {
                $donationDate = $donation->getDate();
                if ($donationDate >= $dateFrom && $donationDate <= $dateTo) {
                    $this->calculateAndRefund($donation);
                }
            }
        }
    }

    /**
     * @param Investor $investor
     * @return float
     */
    public function getInterestForInvestor(Investor $investor): float
    {
        return $this->results[$investor->getIdentifier()];
    }
}