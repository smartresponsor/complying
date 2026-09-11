<?php

declare(strict_types=1);

namespace App\Complying\Entity;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table(name: 'limit_policy')]
class ComplianceLimitPolicy
{
    #[ORM\Id, ORM\GeneratedValue, ORM\Column(type: 'integer')]
    private int $id;

    #[ORM\Column(type: 'integer')]
    private int $vendorId;

    #[ORM\Column(type: 'bigint')]
    private int $dailyLimitMinor = 0;

    #[ORM\Column(type: 'bigint')]
    private int $monthlyLimitMinor = 0;

    public function __construct(int $vendorId, int $dailyLimitMinor, int $monthlyLimitMinor)
    {
        $this->vendorId = $vendorId;
        $this->dailyLimitMinor = $dailyLimitMinor;
        $this->monthlyLimitMinor = $monthlyLimitMinor;
    }

    public function getVendorId(): int
    {
        return $this->vendorId;
    }

    public function getDailyLimitMinor(): int
    {
        return $this->dailyLimitMinor;
    }

    public function getMonthlyLimitMinor(): int
    {
        return $this->monthlyLimitMinor;
    }
}
