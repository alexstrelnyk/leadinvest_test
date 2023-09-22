<?php
declare(strict_types=1);

namespace App\Manager;

use App\Entity\Interfaces\EarningInterface;
use App\Manager\Interfaces\RefundManagerInterface;

class RefundManager implements RefundManagerInterface
{
    /**
     * @param EarningInterface $earningElement
     * @param float $amount
     */
    public function refund(EarningInterface $earningElement, float $amount): void
    {
        $earningElement->earning($amount);
    }
}