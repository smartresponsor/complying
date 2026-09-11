config-endpoints sketch
- entity: compliance_config (key, value, scope, updated_at)
- service: ComplianceConfigService (get/set/list) with audit hook
- http:
  - GET /compliance/config
  - GET /compliance/config/{key}
  - PUT/POST /compliance/config/{key} {value, scope}
usage:
  curl -X POST http://.../compliance/config/compliance.webhook.endpoint -d '{"value":"https://ops/..."}'
