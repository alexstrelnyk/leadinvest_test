<?php
declare(strict_types=1);

namespace App\Factory;

use App\Entity\Investor;

class InvestorFactory
{
    /**
     * @param string $name
     * @return Investor
     */
    public function create(string $name): Investor
    {
        return new Investor($name);
    }
}
