<?php
declare(strict_types=1);

namespace App\Tests;

use App\Entity\Donation;
use App\Exception\ContributionLimitExceededException;
use App\Factory\DonationFactory;
use App\Factory\InvestorFactory;
use App\Factory\LoanFactory;
use App\Factory\TrancheFactory;
use App\Manager\InvestManager;
use App\Manager\RefundManager;
use App\Service\CalculationService;
use DateTime;
use PHPUnit\Framework\TestCase;

class GeneralTest extends TestCase
{
    public function testFirstInvestToTrancheA(): void
    {
        $trancheFactory = new TrancheFactory();
        $investorFactory = new InvestorFactory();
        $donationFactory = new DonationFactory();
        $loanFactory = new LoanFactory();
        $investManager = new InvestManager($donationFactory);

        $loan = $loanFactory->create(3000, new DateTime('1/10/2015'), new DateTime('15-11-2015'));
        $trancheA = $trancheFactory->create($loan, 3, 1000, 'A');
        $investor1 = $investorFactory->create('Investor 1');
        $donation = $investManager->investToTranche($trancheA, $investor1, 1000, new DateTime('03-10-2015'));

        $this->assertInstanceOf(Donation::class, $donation);
    }

    public function testSecondInvestToTrancheA(): void
    {
        $trancheFactory = new TrancheFactory();
        $investorFactory = new InvestorFactory();
        $donationFactory = new DonationFactory();
        $loanFactory = new LoanFactory();
        $investManager = new InvestManager($donationFactory);

        $loan = $loanFactory->create(3000, new DateTime('1/10/2015'), new DateTime('15-11-2015'));
        $trancheA = $trancheFactory->create($loan, 3, 1000, 'A');
        $investor1 = $investorFactory->create('Investor 1');
        $investor2 = $investorFactory->create('Investor 2');

        $investManager->investToTranche($trancheA, $investor1, 1000, new DateTime('03-10-2015'));

        $this->expectException(ContributionLimitExceededException::class);
        $investManager->investToTranche($trancheA, $investor2, 1, new DateTime('04-10-2015'));
    }

    public function testFirstInvestToTrancheB(): void
    {
        $trancheFactory = new TrancheFactory();
        $investorFactory = new InvestorFactory();
        $donationFactory = new DonationFactory();
        $loanFactory = new LoanFactory();
        $investManager = new InvestManager($donationFactory);

        $loan = $loanFactory->create(3000, new DateTime('1/10/2015'), new DateTime('15-11-2015'));
        $trancheB = $trancheFactory->create($loan, 6, 1000, 'B');
        $investor3 = $investorFactory->create('Investor 3');

        $donation = $investManager->investToTranche($trancheB, $investor3, 500, new DateTime('10-10-2015'));
        $this->assertInstanceOf(Donation::class, $donation);
    }

    public function testSecondInvestToTrancheB(): void
    {
        $trancheFactory = new TrancheFactory();
        $investorFactory = new InvestorFactory();
        $donationFactory = new DonationFactory();
        $loanFactory = new LoanFactory();
        $investManager = new InvestManager($donationFactory);

        $loan = $loanFactory->create(3000, new DateTime('1/10/2015'), new DateTime('15-11-2015'));
        $trancheB = $trancheFactory->create($loan, 6, 1000, 'B');
        $investor3 = $investorFactory->create('Investor 3');
        $investor4 = $investorFactory->create('Investor 4');

        $investManager->investToTranche($trancheB, $investor3, 500, new DateTime('10-10-2015'));
        $this->expectException(ContributionLimitExceededException::class);
        $investManager->investToTranche($trancheB, $investor4, 1100, new DateTime('25-10-2015'));

    }

    public function testInterests(): void
    {
        $trancheFactory = new TrancheFactory();
        $investorFactory = new InvestorFactory();
        $donationFactory = new DonationFactory();
        $loanFactory = new LoanFactory();
        $investManager = new InvestManager($donationFactory);
        $calculationService = new CalculationService(new RefundManager());

        $loan = $loanFactory->create(3000, new DateTime('1/10/2015'), new DateTime('15-11-2015'));
        $trancheA = $trancheFactory->create($loan, 3, 1000, 'A');
        $trancheB = $trancheFactory->create($loan, 6, 1000, 'B');
        $investor1 = $investorFactory->create('Investor 1');
        $investor3 = $investorFactory->create('Investor 3');

        $investManager->investToTranche($trancheA, $investor1, 1000, new DateTime('03-10-2015'));
        $investManager->investToTranche($trancheB, $investor3, 500, new DateTime('10-10-2015'));

        $calculationService->setLoan($loan);
        $calculationService->calculate(new DateTime('01-10-2015'), new DateTime('31-10-2015'));

        $this->assertEqualsWithDelta(28.06, $calculationService->getInterestForInvestor($investor1), 0.01);
        $this->assertEqualsWithDelta(21.29, $calculationService->getInterestForInvestor($investor3), 0.01);

    }
}

