risk-score sketch
- dto: App\Complying\DTO\RiskScoreDTO {score, reasons[]}
- service: App\Complying\Service\RiskScoreService->calculate(facts)
- decorator: App\Complying\Service\RiskAwareCompliancePolicyService
  - if score>=90 -> outcome=DENY
  - else if score>=60 and outcome=PERMIT -> outcome=REVIEW
  - injects facts.risk={score,reasons}
- export в /compliance/export уже увидит risk внутри facts
