policy-registry sketch
- entity: compliance_policy_registry (policy_id, policy_version, description, source, updated_at)
- service: PolicyRegistryService (refresh + list)
- http:
  - GET /compliance/policies
  - POST /compliance/policies/refresh
- config: compliance.role.policies_endpoint
