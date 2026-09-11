# Complying entity-first migration retirement

## Scope

This patch converts the Complying component away from schema-first migration ownership. Runtime schema must be derived from Doctrine entities.

## Retired schema-first sources

- `Complying/migrations/**`

## Entity-first reconciliation

- `ComplianceDecisionLog` now restores the migration-only `event_name` concept as `eventName`.
- `ComplianceCaseQueue` restores the missing `decision_id` relationship to `ComplianceDecisionLog` and keeps `processedAt` as queue lifecycle state.
- Migration-defined indexes/unique constraints were moved into Doctrine attributes where they belong.
- Repository interfaces were added for compliance entities so services can bind to contracts instead of concrete repositories.

## Objecting alignment

System timestamps, state, version, and scope are moved toward Objecting embeddable traits where the fields are generic infrastructure rather than compliance business data.

Business fields remain local to Complying when they carry compliance meaning, for example:

- `decidedAt` on `ComplianceDecisionLog`
- `processedAt` on `ComplianceCaseQueue`
- `policyId` / `policyVersion`
- `outcome` / `facts`

## Old monolith reconciliation

No dedicated `Compliance` monolith entities were present in `Entity-src(6).zip`. This pass therefore reconciles Complying from its current entities and retired SQL migrations only.
