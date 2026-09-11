audit-log-enricher sketch
- entity: compliance_audit_log (action, actor, ip, payload, createdAt)
- service: ComplianceAuditTrailService->add(action, payload)
- example endpoint: POST /admin/compliance/cases/{id}/close-audited
- to integrate: call ->add(...) from import, ui, webhook config changes
