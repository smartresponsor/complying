# Complying relationship/lifecycle hardening wave 2

Status: applied as a conservative hardening pass.

## Scope

- Adds `ComplianceCaseLifecyclePolicy`.
- Keeps lifecycle validation string-based to avoid schema drift.
- Does not touch `*EnGb*` / translation normalization.
- Does not touch Attachment/Attaching mechanics.

## Lifecycle decision

Compliance case/decision lifecycle. Policy version/outcome/facts remain compliance evidence fields.

## Transition map

- `queued` -> `reviewing`, `decided`, `discarded`
- `reviewing` -> `queued`, `decided`, `escalated`, `discarded`
- `escalated` -> `reviewing`, `decided`, `discarded`
- `decided` -> `processed`
- `processed` -> `terminal`
- `discarded` -> `terminal`
