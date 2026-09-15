<?php

/**
 * Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp.
 */

declare(strict_types=1);

namespace App\Complying\Service;

use App\Complying\Entity\ComplianceDecisionLog;
use Doctrine\ORM\EntityManagerInterface;

/**
 * Coordinates the compliance export service responsibility within the Complying component and its explicit boundaries.
 */
final class ComplianceExportService
{
    /**
     * Initializes the collaborators and state required by this compliance responsibility.
     */
    public function __construct(private readonly EntityManagerInterface $em)
    {
    }

    /**
     * Performs the fetch decisions behavior as part of the owning compliance responsibility.
     *
     * @return array<int, array<string, mixed>>
     */
    public function fetchDecisions(?\DateTimeImmutable $from = null, ?\DateTimeImmutable $to = null, ?string $outcome = null, ?string $event = null): array
    {
        $qb = $this->em->getRepository(ComplianceDecisionLog::class)->createQueryBuilder('d');

        if ($from) {
            $qb->andWhere('d.decidedAt >= :from')->setParameter('from', $from);
        }
        if ($to) {
            $qb->andWhere('d.decidedAt <= :to')->setParameter('to', $to);
        }
        if ($outcome) {
            $qb->andWhere('d.outcome = :outcome')->setParameter('outcome', $outcome);
        }
        if ($event) {
            $qb->andWhere('d.targetId = :event')->setParameter('event', $event);
        }

        $items = $qb->orderBy('d.id', 'DESC')->setMaxResults(1000)->getQuery()->getResult();

        $result = [];
        foreach ($items as $item) {
            /** @var ComplianceDecisionLog $item */
            $result[] = [
                'id' => $item->getId(),
                'outcome' => $item->getOutcome(),
                'policy_id' => $item->getPolicyId(),
                'policy_version' => $item->getPolicyVersion(),
                'object_id' => $item->getTargetId(),
                'facts' => $item->getFacts(),
                'decided_at' => $item->getDecidedAt()->format(\DATE_ATOM),
            ];
        }

        return $result;
    }

    /**
     * Performs the to csv behavior as part of the owning compliance responsibility.
     *
     * @param array<int, array<string, mixed>> $rows
     */
    public function toCsv(array $rows): string
    {
        $f = fopen('php://temp', 'r+');
        if (false === $f) {
            throw new \RuntimeException('Unable to open temporary compliance export stream.');
        }

        fputcsv($f, ['id', 'outcome', 'policy_id', 'policy_version', 'object_id', 'decided_at', 'facts_json']);

        foreach ($rows as $row) {
            fputcsv($f, [
                $row['id'],
                $row['outcome'],
                $row['policy_id'],
                $row['policy_version'],
                $row['object_id'],
                $row['decided_at'],
                json_encode($row['facts'], \JSON_UNESCAPED_UNICODE | \JSON_THROW_ON_ERROR),
            ]);
        }

        rewind($f);
        $csv = stream_get_contents($f);
        fclose($f);

        return false === $csv ? '' : $csv;
    }

    /**
     * Performs the to ndjson behavior as part of the owning compliance responsibility.
     *
     * @param array<int, array<string, mixed>> $rows
     */
    public function toNdjson(array $rows): string
    {
        $lines = [];
        foreach ($rows as $row) {
            $lines[] = json_encode($row, \JSON_UNESCAPED_UNICODE | \JSON_THROW_ON_ERROR);
        }

        return implode("\n", $lines)."\n";
    }
}
