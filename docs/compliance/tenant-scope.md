tenant-scope sketch
- adds tenant_id to ComplianceDecisionLog and CaseQueue
- tenant is taken from X-Tenant header or ?tenant_id=
- writer stores tenant_id automatically
