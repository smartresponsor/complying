# Complying

Complying is the Symfony-oriented compliance component of the SmartResponsor
platform. It owns compliance policy evaluation, explainable decisions, audit
records, retention and legal-hold operations, consent and sanction workflows,
and the operational integration points required by those responsibilities.

## Responsibility boundary

`App\\Complying\\` owns compliance-specific entities, repositories, services,
commands, messages, controllers, configuration, templates, and tests. Generic
CRUD mechanics belong to Cruding; reusable system fields belong to Objecting;
shared presentation helpers belong to Viewing; and public shell/integration
contracts belong to Interfacing.

## Current capabilities

- JSON policy-as-code under `policies/`
- realtime `ALLOW`, `REVIEW`, and `DENY` decisions
- compliance decision logging and audit trails
- retention, legal-hold, consent, sanction, and case workflows
- Messenger, webhook, HMAC, OpenTelemetry, export, and operational endpoints
- CLI policy linting and guard evaluation

The iteration 3.3 realtime guard remains available through:

- `config/packages/compliance_kernel_iter_3_3.yaml`
- `App\\Complying\\Service\\PolicyRepository`
- `App\\Complying\\Service\\RealtimeGuard`
- `App\\Complying\\Service\\Payment\\PaymentGuard`
- `tests/RealtimeGuardSmokeTest.php`

## Example

```bash
php bin/console app:policy:lint
php bin/console app:guard:evaluate 501 7500000 '{"country":"US"}'
```

## Package readiness

This repository now includes development and production Composer manifests for
the standalone Symfony/bundle surface. RC readiness still depends on the local
quality gates documented in `composer.json`; unresolved Gating, PHPUnit, PHPStan,
Symfony configuration, or Doctrine failures must be treated as release blockers
rather than hidden by package metadata.
