observability-otel sketch
- service: ComplianceOtelTracer (wraps OTEL tracer)
- decorator: ComplianceTracingPolicyEvaluationService
  - span name: compliance.decide
  - attrs: outcome, tenant_id, policy_id, event
- subscriber: ComplianceOtelHttpSubscriber for /compliance/*
- config: config/packages/compliance_otel.yaml (decorates policy service)
note:
  - рассчитано, что в проекте уже есть OTEL bundle, тут только обвязка
