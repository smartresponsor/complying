retention/archiver sketch
- entity: ComplianceDecisionLogArchive
- service: ComplianceRetentionService->archiveOlderThan(days)
- cli: bin/console compliance:retention:run 30
- batch 1000 rows per run, older than N days
