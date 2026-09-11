tenant-guard sketch
- /compliance/* → TenantRequestSubscriber кладет tenant в request attr (X-Tenant-ID)
- decorator TenantAwareCompliancePolicyService добавляет tenant_id в payload/facts
- repo trait TenantFilterTrait для дальнейших репо (decision_log, case_queue)
- config: config/packages/compliance_tenant.yaml
