sync-with-role sketch
- интерфейс: App\Complying\ServiceInterface\RoleActorResolverInterface
- реализация: SecurityRoleActorResolver (берем из Symfony Security токена)
- decorator decide: RoleAwareCompliancePolicyService
  - обогащает payload/facts: actor, actor_roles[]
- decorator audit: RoleAwareComplianceAuditTrailService
  - добавляет actor в audit-лог
- config: config/packages/compliance_role_sync.yaml
