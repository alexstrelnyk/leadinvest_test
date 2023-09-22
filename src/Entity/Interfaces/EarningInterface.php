<?php
declare(strict_types=1);

namespace App\Entity\Interfaces;

interface EarningInterface
{
    /**
     * @param float $amount
     * @return mixed
     */
    public function earning(float $amount);
}