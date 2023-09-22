<?php
declare(strict_types=1);

namespace App\Manager\Interfaces;

use App\Entity\Interfaces\EarningInterface;

interface RefundManagerInterface
{
    /**
     * @param EarningInterface $earningElement
     * @param float $amount
     * @return mixed
     */
    public function refund(EarningInterface $earningElement, float $amount);
}