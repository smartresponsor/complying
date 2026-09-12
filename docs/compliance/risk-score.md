risk-score sketch
- dto: App\Complying\DTO\ComplianceRiskScoreDTO {score, reasons[]}
- service: App\Complying\Service\ComplianceRiskScoreService->calculate(facts)
- decorator: App\Complying\Service\ComplianceRiskAwarePolicyEvaluationService
  - if score>=90 -> outcome=DENY
  - else if score>=60 and outcome=PERMIT -> outcome=REVIEW
  - injects facts.risk={score,reasons}
- export в /compliance/export уже увидит risk внутри facts
