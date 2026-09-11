export-ndjson sketch
- service: App\Complying\Service\DecisionExportService->exportDecisions(fromId, fromDate)
- endpoint: GET /compliance/export/decisions.ndjson?from_id=100&from_date=2025-11-01
- format: NDJSON (1 decision per line)
- use: curl -o decisions.ndjson http://.../compliance/export/decisions.ndjson
