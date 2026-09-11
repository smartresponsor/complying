<?php

declare(strict_types=1);

namespace App\Complying\Service;

use Doctrine\DBAL\Connection;

final class LimitEvaluator
{
    public function __construct(private readonly Connection $db)
    {
    }

    public function evaluate(int $vendorId, int $dailyLimitMinor, int $monthlyLimitMinor): array
    {
        try {
            $daily = (int) $this->db->fetchOne('SELECT COALESCE(SUM(amount_minor),0) FROM ledger_entry WHERE reference_id = :v AND created_at >= CURRENT_DATE()', ['v' => $vendorId]);
            $monthly = (int) $this->db->fetchOne('SELECT COALESCE(SUM(amount_minor),0) FROM ledger_entry WHERE reference_id = :v AND created_at >= DATE_SUB(CURRENT_DATE(), INTERVAL 30 DAY)', ['v' => $vendorId]);
        } catch (\Throwable $e) {
            $daily = 0;
            $monthly = 0;
        }
        $ok = $daily <= $dailyLimitMinor && $monthly <= $monthlyLimitMinor;

        return ['ok' => $ok, 'daily' => $daily, 'monthly' => $monthly];
    }
}
