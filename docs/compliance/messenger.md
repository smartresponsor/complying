messenger/deferred sketch
- use App\Complying\Service\ComplianceDeferredDecisionService->defer(...) when role is unreachable
- worker: symfony console messenger:consume compliance
- message handler writes decision and creates case on REVIEW
