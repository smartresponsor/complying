case-worker-cli sketch
- service: App\Complying\Service\ComplianceCaseWorkerService->process(limit=50)
- cli: bin/console compliance:case:process 100
- use in cron: */5 * * * * php bin/console compliance:case:process 100
