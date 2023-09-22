<?php
declare(strict_types=1);

namespace App\Entity;

use App\Entity\Interfaces\EarningInterface;
use App\Entity\Interfaces\IdentifierInterface;
use App\Exception\InsufficientFundsException;

class Investor implements EarningInterface, IdentifierInterface
{
    /**
     * @var string
     */
    protected $name;

    /**
     * @var float
     */
    protected $balance = 1000;

    /**
     * Investor constructor.
     * @param string $name
     */
    public function __construct(string $name)
    {
        $this->name = $name;
    }

    /**
     * @param float $amount
     * @return float
     */
    public function take(float $amount): float
    {
        if ($this->balance < $amount) {
            throw new InsufficientFundsException();
        }

        $this->balance -= $amount;

        return $amount;
    }

    /**
     * @param float $amount
     */
    public function earning(float $amount): void
    {
        $this->balance += $amount;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return mixed|string
     */
    public function getIdentifier()
    {
        return $this->getName();
    }
}
