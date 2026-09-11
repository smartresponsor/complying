policy-expression sketch
- expression engine: Symfony ExpressionLanguage
- provider: читаем из compliance_policy_registry где source='expression'
- decorator: ExpressionAwareCompliancePolicyService → если expr=true, ужесточаем (PERMIT→REVIEW)
- cli: bin/console compliance:policy:import-expr fixtures/compliance/policy-expressions.yaml
- пример выражений:
  - "is_sanctioned == true"
  - "amount > 15000 and country in ['RU','BY']"
  - "facts['risk']['score'] >= 80"
