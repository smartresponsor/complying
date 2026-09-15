sync-with-role sketch
- интерфейс: App\Complying\ServiceInterface\ComplianceRoleActorResolverInterface
- реализация: ComplianceSecurityRoleActorResolver (берем из Symfony Security токена)
- decorator decide: ComplianceRoleAwarePolicyEvaluationService
  - обогащает payload/facts: actor, actor_roles[]
- decorator audit: ComplianceRoleAwareAuditTrailService
  - добавляет actor в audit-лог
- config: config/packages/compliance_role_sync.yaml
