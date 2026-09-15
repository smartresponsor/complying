tenant-guard sketch
- /compliance/* → ComplianceTenantRequestSubscriber кладет tenant в request attr (X-Tenant-ID)
- decorator ComplianceTenantAwarePolicyEvaluationService добавляет tenant_id в payload/facts
- repo trait ComplianceTenantFilterTrait для дальнейших репо (decision_log, case_queue)
- config: config/packages/compliance_tenant.yaml
