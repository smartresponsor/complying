# CMCP Orchestration Journal

## engine-20260911150912-complying-03d180

### Iteration 1 — reconnaissance and baseline

- Console MCP repository access recovered for `D:\\PhpstormProjects\\www\\Complying`; branch `master` has no commits, no upstream, origin `git@github.com:smartresponsor/complying.git`, and the existing repository tree is entirely untracked. No cleanup/reset was performed.
- Read local README, Composer development/production manifests, service/routes configuration, DTO/service/test surfaces, existing CMCP journal, and package quality configuration. Composer declares Objecting, Cruding, Viewing, and Interfacing with local path repositories using symlinks; production manifest uses packaged dependencies.
- Read Objecting, Cruding, Viewing, and Interfacing README/AGENTS/Composer contracts that were available, plus Canonization architecture README and Canon000/001/002/003/019 normative rules and Gating README/AGENTS/Composer enforcement surface.
- Canon mapping: role-first technical roots; mirrored Service/Repository interfaces; explicit `DTO` path/casing/suffix; default Symfony `App\\` root; no Domain/Port/Adapter taxonomy; generic CRUD remains in Cruding; Objecting owns reusable system fields; Viewing owns rendering boundary; Interfacing owns shared shell/integration presentation.
- Domain/market baseline: mature compliance systems require deterministic policy evaluation, explainable decisions, auditable evidence, retention/legal hold, sanctions/consent workflows, failure-safe diagnostics, and observable decision paths. Generic CRUD, reusable system fields, shared rendering infrastructure, and shell ownership remain outside Complying.
- Report-first Gating exposed multiple pre-existing canon debts. Selected RC-critical bounded workstream: repair `ComplianceDecisionDTO` PSR-4 identity and runtime mutability contract because the file lived under `src/DTO/` but declared `App\\Complying\\Service`, while policy decorators mutate `outcome` and `facts` despite those properties being readonly.
- Growth/post-RC workstream: role-root normalization, removal of forbidden `src/Adapter/`, remaining DTO suffix migrations, tenant/Vendor semantic migration after data classification, naming-prefix cleanup, PHPDoc coverage, and broader maturity/documentation uplift.
- Planned gates: Composer validation, Gating, PHPUnit, PHPStan, Symfony YAML/container lint, targeted searches, Git status/diff, then integration only if repository baseline permits safe staging.

### Iteration 2 — material implementation

- Moved `ComplianceDecisionDTO` logically into its factual `App\\Complying\\DTO` namespace without relocating the file.
- Updated all service consumers to import the canonical DTO class explicitly; existing interfaces/tests already referenced the canonical DTO namespace.
- Kept `policyId` and `policyVersion` readonly while making only `outcome` and `facts` mutable, matching the existing decorator pipeline that intentionally tightens decisions and enriches facts.

### Iteration 3 — verification and fix

- `composer test` now executes 29 tests; the prior `ComplianceDecisionDTO` autoload/namespace failure is gone. Residual suite state is 5 unrelated errors, 2 missing-script failures, and 1 discovery warning involving legacy/missing interfaces, attempts to mock final classes, and absent E2E/SLO fixtures.
- Removed obsolete PHPStan option `checkMissingIterableValueType`; PHPStan 2.2 now analyses 196 files and reports real pre-existing source issues instead of configuration startup failure.
- Corrected the Messenger import from nonexistent `packages/messenger.yaml` to factual `packages/messenger_compliance.yaml`.
- Re-ran Gating: `canon.007.psr4_identity` is now PASS. Remaining failures are independent structural/naming/DTO/empty-catch/Adapter/PHPDoc/config-prefix debts already present in the baseline.
- Symfony YAML/container lint exposed standalone bootstrap defects progressively. Added explicit SecurityBundle configuration, loaded existing Doctrine config, removed obsolete Doctrine `auto_generate_proxy_classes`, and bound `ComplianceIncidentWebhookService::$targetUrl` after broad service discovery.

### Iteration 4 — debt closure and integration assessment

- Symfony lint now progresses through Security, Doctrine, Messenger, and the webhook service and stops at the next pre-existing DI contract: `CompliancePolicyRegistryService::$endpoint` is overwritten by broad `App\\Complying\\` service registration. The same configuration pattern affects multiple package-local explicit service/decorator definitions and is a bounded configuration-architecture debt rather than a safe one-line tail.
- Updated README package-readiness text to reflect the now-present development/production Composer manifests and to state that executable gate failures remain release blockers.
- No destructive cleanup was performed. Remaining RC debts were not mass-renamed or mechanically migrated because they span role-root moves, DTO API renames, Adapter removal, tenant/Vendor semantics, service-decoration ordering, and broken test contracts.
- Git integration is unsafe in the current repository state: `master` has no commits and the entire pre-existing product baseline is untracked, including `.env`. Staging only task files would create a partial initial repository; staging the whole baseline would exceed this task and risks committing unrelated/private state. Therefore no stage/commit/push/PR/merge is authorized by the safety constraints of this run.

### Iteration 5 — final acceptance and handoff

- RC-critical DTO identity/mutability work is materially implemented and Canon007 is green.
- Final acceptance is not RC-green: PHPUnit, PHPStan, Gating, Symfony YAML, and container lint still expose factual pre-existing debts; current Symfony lint/container first stop is `CompliancePolicyRegistryService::$endpoint` due service-definition ordering/override semantics.
- Composer manifest validation is syntactically valid but strict validation warns about the intentionally unbound local `*@dev` helper constraints.
- Repository remains `master`, no commits, no upstream; origin is `git@github.com:smartresponsor/complying.git`. Remote integration was intentionally not attempted because a safe initial baseline commit does not exist.
- Zero authorized in-scope tails remain for the selected bounded RC workstream. The next repository-level RC track should first establish a reviewed initial Git baseline (excluding secrets), then normalize DI service-definition ownership/order and address the recorded structural/test debts in bounded waves.

### Continuation acceptance pass — 2026-09-11

#### Iteration 1 — factual local baseline and canon remap

- Recovered the authoritative local execution plane through Console MCP. Contrary to the stale handoff, the repository already had a clean, tracked branch `rc/complying-di-hardening` at `c5207f89773339b8653c4e1f1e51940f22ddfa53`, synchronized with `origin/rc/complying-di-hardening`; no reset or destructive reconciliation was performed.
- Re-read the Complying package manifest, journal, service/configuration surfaces and representative runtime/tests. Re-read sibling Objecting, Cruding, Viewing and Interfacing README/Composer contracts and Gating README/AGENTS/Composer enforcement surface.
- Read actual Canonization normative files `Canon001TechnicalRoleFirstRule`, `Canon003DtoIsExplicitRule`, `Canon007Psr4IdentityRule`, `Canon011NoSilentFailureRule`, `Canon018ComposerIdentityMappingRule`, `Canon019NoAlternativeLayerTaxonomyRule`, `Canon020TypedSymfonyRoleRootRule`, and `Canon021CrudingOwnsGenericCrudRule`, plus the platform AGENTS projection.
- Target-to-canon mapping: preserve role-first Symfony topology; explicit DTO identity; literal PSR-4 identity; observable mandatory failure; Composer-derived `App\\Complying\\` / `Compliance*` identity; no Adapter/Port/Domain taxonomy; typed Symfony role roots; generic CRUD remains owned by Cruding. Objecting owns reusable lifecycle fields but not Complying business `scope` or business policy revision strings.
- Bounded market/domain check against current official OPA decision-log and AWS Audit Manager evidence-collection documentation reinforced the RC expectations: deterministic policy decisions, audit/debug traceability, explicit evidence/control association, and observable failures. Generic CRUD/rendering/shell infrastructure remains outside Complying.
- Selected continuation RC-critical workstream: restore current Objecting/Symfony runtime compatibility and make the existing tests/DI/static boundaries executable without broad canon renames. Growth/post-RC remains the repository-wide Canon001/003/006/018/019/020/031/038 migration.

#### Iteration 2 — material implementation

- Replaced removed Objecting scope APIs in `ComplianceConfig` with a local nullable business `scope`, while retaining Objecting audit lifecycle ownership.
- Removed misuse of Objecting technical integer versioning from `CompliancePolicyRegistry`; `policyVersion` remains an independent business revision. Updated current audit timestamp accessors and null-safe serialization.
- Repaired Vendor handler imports, completed the sanction repository interface contract and DI alias, and moved `ComplianceSanctionImportService` to the repository interface boundary.
- Updated stale tests to current contracts instead of mocking final implementations; corrected repository-local E2E/SLO fixture paths and controller wiring assertions.
- Migrated all 20 controller imports from removed Symfony `Routing\\Annotation\\Route` to Symfony 8 `Routing\\Attribute\\Route`; fixed AdminAudit PHP concatenation, JSON error handling, typed request boundaries, Doctrine repository generics, and nullable lifecycle serialization.
- Aligned `ComplianceCaseQueue` with current Objecting `initializeObjectState(..., objectStatus:)` / `setObjectStatus()` APIs.

#### Iteration 3 — verification and fix

- PHPUnit is green: 30 tests, 43 assertions, exit 0; one deprecation and seven PHPUnit notices remain non-failing.
- Symfony container lint is green; YAML lint is green for all 41 configuration files.
- PHP-CS-Fixer dry-run is green: 0/196 files require changes.
- PHPStan now passes the repaired controller/Route/JSON/request/repository boundary layer and reaches deeper pre-existing Entity/Objecting debt: Doctrine-managed property semantics, missing array value generics, and remaining old lifecycle usages in other entities. It remains red and is not suppressed.
- Composer strict validation remains syntactically valid but warns on the four intentional local `*@dev` platform dependencies.

#### Iteration 4 — debt closure and integration gate

- Corrected the Doctrine parity script's invalid `doctrine:database:create` step for the file-backed SQLite test connection. The gate now reaches the next factual blocker: migrations are configured at `%kernel.project_dir%/migrations`, but the directory/migration baseline does not exist. No historical migration was fabricated from an unknown local database state.
- Re-ran Gating. Green contracts include Canon002, Canon004/005/007, Canon013-016, Canon021-030, Canon032-037. Remaining release blockers are broad existing canon debt: Canon001 technical-role placement, Canon003 DTO suffixes, Canon006 role identity, Canon011 empty catch, Canon018 subject prefixes, Canon019 forbidden `src/Adapter`, Canon020 typed role roots, Canon031 PHPDoc coverage, Canon038 YAML prefixes, plus related structural/mirror findings.
- No unrelated sibling repository was modified; all writes remain confined to `D:\\PhpstormProjects\\www\\Complying`.

#### Iteration 5 — final acceptance and integration decision

- The selected runtime/test/Symfony-8 hardening workstream is materially complete and locally verified by PHPUnit, container lint, YAML lint and PHP-CS-Fixer.
- Full repository RC acceptance is still red because PHPStan, Gating, and Doctrine migration parity expose independent repository-wide debt. These failures are factual and intentionally remain visible; the quality gate is not being weakened or baselined away.
- Integration result: signed commit `20eaeb0` (`Harden Complying runtime and Symfony 8 contracts`) was pushed to `origin/rc/complying-di-hardening`. GitHub PR creation against `master` was attempted and rejected because the remote has no valid `master` base branch (`Base ref must be a branch`; no usable base SHA). No base branch was fabricated and no merge was attempted while the formal release gates remain red. The next RC track is the explicit canon/entity/migration migration wave, not speculative feature growth.

## engine-20260906000059-complying-d9b08d

### Iteration 1 — reconnaissance and baseline

- Read the authoritative execution specification, existing CMCP journal, repository README, Git state, service and route configuration, representative controllers/tests, and the available canonical contracts from Objecting, Cruding, Viewing, Interfacing, Gating, and Canonization.
- Repository state: branch `master`; 17 untracked top-level entries; no root `composer.json`; no active unfinished task was established by the existing journal.
- Market/enterprise baseline inside the compliance boundary: mature compliance systems require deterministic policy decisions, explainability, immutable audit evidence, retention/legal hold, tenant/identity isolation, operational health, and observable failure handling. Generic CRUD, reusable system fields, shared presentation, and shell contracts remain outside Complying.
- Selected RC-critical work: repair controller service discovery, which currently points at nonexistent `src/Http/Compliance/` although routes and classes use `src/Controller/`, and add a regression test for this integration contract.
- Material risks: the repository is wholly untracked and lacks standalone Composer/package gates; tenant identity occurrences require semantic/data classification under the Objecting canon and are not safe for mechanical migration.
- Gates: direct configuration/test reads, targeted text searches, PHP syntax checks when available, repository gate inventory, and final Git status/diff inspection.

### RC-critical workstream

- Restore factual Symfony controller service wiring and protect it with an executable configuration contract test.
- Preserve business action routes while leaving generic CRUD ownership with Cruding.
- Keep the unresolved tenant/Vendor identity migration report-first and data-safe.

### Growth workstream

- Establish the verified standalone Composer/bundle surface with Objecting, Cruding, Viewing, and Interfacing dependencies.
- Classify and migrate tenant identity to the canonical Vendor/Objecting model only after runtime and data semantics are proven.
- Add synchronized architecture/component graphs and lifecycle/observability documentation.

### Iteration 2 — material implementation

- Corrected `config/services.yaml` so `App\\Complying\\Controller\\` discovers the factual `src/Controller/` tree instead of nonexistent `src/Http/Compliance/`.
- Added `tests/Configuration/ControllerServiceWiringTest.php` to assert both the canonical YAML resource and the directory's existence.
- Kept the change inside Complying's integration/configuration responsibility; no generic CRUD implementation, Entity migration, deletion, staging, commit, or push was performed.

### Iteration 3 — verification and continuation decision

- PHP syntax gate passed for the new regression test: `php -l tests/Configuration/ControllerServiceWiringTest.php` returned no syntax errors.
- Repository searches across 320 files found zero stale `../src/Http/Compliance/` references and exactly the expected configuration/test references to `../src/Controller/`.
- RC planning reported zero canon issues but cannot declare standalone readiness because the repository has no `composer.json`, no detected validation commands, and the entire current tree is untracked.
- Final bounded decision: controller service wiring is repaired and statically protected. Full PHPUnit/container/YAML execution remains unavailable until the component has a verified Composer/Symfony package or is mounted into the host application.
- No files were staged, committed, pushed, or deleted, in accordance with the authoritative specification.

## engine-20260905235725-complying-7bd10e

### Iteration 1 — reconnaissance and baseline

- Read the authoritative execution specification, repository README, Git state, representative configuration, routes, source references, tests, CI references, and the available canonical contracts from Objecting, Cruding, Viewing, Interfacing, Gating, and Canonization.
- Repository state: branch `master`; the current product tree is untracked; `composer.json` is absent.
- Documentation/graph search found no local architecture, roadmap, component, or memory graph for Complying.
- Selected bounded RC-critical work: replace the stale iteration-only README identity with a factual component overview and explicit package-readiness limitation.
- Material risk: creating a Composer package manifest without a verified package identity, bundle contract, dependency versions, and installability tests would exceed this bounded acceptance test.
- Gates: factual path/reference searches, Git diff/status inspection, and any repository checks available without inventing missing package metadata.

### RC-critical workstream

- Keep documentation aligned with the actual compliance responsibility: policy evaluation, decisions, audit trail, retention/legal hold, sanctions, consent, and operational integration.
- Make packaging limitations explicit until a verified Composer package surface exists.
- Preserve helper ownership: Objecting system fields, Cruding generic CRUD, Viewing presentation helpers, and Interfacing public shell contracts.

### Growth workstream

- After package identity is decided, add and validate the standalone Composer/Symfony bundle surface.
- Add an explicit component/architecture graph and keep it synchronized with the platform memory graph.
- Mature policy lifecycle documentation around versioning, explainability, rollout, rollback, and observability.

### Iteration 2 — material implementation

- Updated `README.md` to use the canonical Complying identity and describe the current responsibility boundary.
- Added a factual packaging/readiness section instead of implying standalone installability.

### Iteration 3 — verification and continuation decision

- Re-read `README.md` and this journal after the patch; both are complete and present in the workspace root.
- Factual searches confirmed the documented realtime guard service, payment guard, command, configuration, test, and `App\\Complying\\` namespace references in the current tree.
- Git status remains on `master` with 17 untracked top-level entries, including the two expected documentation files; no file was staged, committed, pushed, or deleted.
- `git diff` is empty because the entire repository tree is untracked, so verification used direct file reads, repository searches, and status inspection.
- Composer validation, package scripts, PHPStan, PHPUnit, Symfony container/YAML, and Doctrine gates are unavailable as package gates because the root `composer.json` is absent; no manifest was invented.
- Continuation decision: the bounded acceptance test is complete at iteration 3. Remaining package construction and graph creation are explicit follow-up workstreams, not silently expanded into this run.


### Post-continuation static-analysis closure — 2026-09-12

- Resumed from the factual local branch `rc/complying-di-hardening` at `0b17bc1`, already one commit ahead of its upstream, with 67 modified tracked files plus the untracked `tests/phpstan-doctrine.php`. Those pre-existing changes were preserved and assessed rather than reset.
- Corrected the PHPStan Doctrine bootstrap to return a typed Doctrine object manager. This removed the internal metadata-reflection crash and exposed three actionable mapping/type findings.
- Removed the duplicate local `ComplianceCaseQueue::$status` column and made Objecting's canonical `object_state` status the single persisted source. Kept the public business accessor with an explicit initialization invariant.
- Modelled the Doctrine-generated queue identifier as an uninitialized `int`, with the existing pre-persistence guard expressed through `isset()`.
- Final gates: Composer validation PASS with four expected local `*@dev` warnings; PHPUnit PASS (30 tests, 44 assertions; one deprecation and seven notices); PHPStan PASS (197 files); changed-file PHP lint PASS (62 files); PHP-CS-Fixer dry-run PASS (197 files); YAML lint PASS (41 files); Symfony container lint PASS.
- Remaining release gates: Gating still reports the repository-wide role-first/DTO/subject-prefix/Adapter/PHPDoc/YAML-prefix migration; Doctrine parity still stops because no `migrations/` baseline exists. Neither broad renames nor a fabricated historical migration were folded into this static-analysis closure.
- No file was deleted, staged, committed, pushed, rebased, or merged during this continuation.

### Structural canon acceptance — 2026-09-12

- Detected a concurrent local structural migration on the same authoritative branch and preserved it instead of replaying stale move/rename work. The migration replaced legacy non-prefixed types and non-canonical role roots with canonical `Compliance*` identities, canonical DTO suffixes, canonical Symfony role roots, canonical config filenames, and a validated `.gating/compliance_profile.yaml`.
- Re-ran the full acceptance matrix against that factual migrated tree: PHPStan PASS (197 files), PHPUnit PASS (30 tests / 44 assertions; one deprecation and seven notices), Symfony container PASS, YAML PASS (41 files), PHP-CS-Fixer dry-run PASS (0/197).
- Refreshed persistent Xdebug path/branch coverage evidence. Gating now reports 56 rules with 0 failed, 1 warning, 0 suppressed, and 9 skipped. Canon000-007, Canon011, Canon013-016, Canon018-039, profile validity, forbidden-architecture, namespace, typed-location, routes, mutation firewall, secret scan, and documentation guards are green. Canon031 PHPDoc coverage is 166/166 classes and 392/392 methods (100% / 100%).
- Canon040 remains an explicit measured warning: lines 11.4% (171/1500), methods 9.7% (37/383), branches 28.7% (80/279), classified `HIGH_TEST_DEBT`. This is queued test-development debt, not a hard Gating failure.
- Composer strict validation remains structurally valid and lock-consistent; the only warnings are the four intentional local `*@dev` constraints for Cruding, Interfacing, Objecting, and Viewing.
- Doctrine schema parity remains the sole hard release blocker: `doctrine:migrations:migrate --env=test` cannot start because `migrations/` does not exist. No historical migration baseline was fabricated from an unknown schema state.
- Integration decision: the migrated tree is suitable for signed commit/push as an RC hardening snapshot, but the repository must not be declared fully RC-green until an authoritative Doctrine migration baseline exists and parity executes successfully.

### Doctrine migration baseline closure — 2026-09-12

- Established the configured `migrations/` root and generated an initial migration from current Complying ORM metadata. The first automatic diff was intentionally rejected as a release artifact because it was rendered on the test SQLite connection and therefore contained SQLite-specific DDL that would not be valid as the PostgreSQL production contract.
- Added `tools/doctrine/render_schema_platforms.php` and the `doctrine:schema:render-platforms` Composer script. The renderer boots the canonical test metadata once and renders the same Doctrine schema through both `PostgreSQLPlatform` and `SQLitePlatform`, allowing the migration DDL to remain metadata-derived without requiring a live PostgreSQL server.
- Reworked `DoctrineMigrations\\Version20260912205828` into a platform-aware initial baseline. PostgreSQL and SQLite branches use the exact DBAL-rendered DDL for their respective engines; unsupported database platforms abort explicitly instead of silently receiving the wrong dialect.
- Guarded migration dry-run succeeded for one migration and 25 planned SQL statements. The verified plan fingerprint was then applied to the test database: one migration executed successfully.
- Final Doctrine acceptance is green: `doctrine:schema:validate --env=test` reports correct mappings and an in-sync database; `doctrine:migrations:up-to-date --env=test` reports no pending migrations; the aggregate `composer doctrine:schema:parity` gate now passes.
- A live PostgreSQL dev connection was not available because the local PostgreSQL credentials were rejected. Production PostgreSQL DDL therefore comes from Doctrine DBAL's PostgreSQL platform renderer over the same ORM schema rather than from guessed SQL or an unverified live-database diff.
- Concurrent unrelated `.gating/*` changes appeared during this continuation. They were preserved and excluded from this migration-track commit; no attempt was made to reset, stage, or overwrite that parallel work.

### RC dependency-policy and executable-gate closure — 2026-09-14

- Re-read current Complying runtime/package/test/documentation surfaces and Git state before mutation. The branch is `rc/complying-di-hardening`; extensive pre-existing `.gating/**` changes remain outside this workstream and are preserved.
- Re-read Objecting, Cruding, Viewing, Interfacing, Collectioning, Tabling, Gating, and authoritative Canonization `AGENTS.md`, guard matrix, and Canon000/001/010/015/017/022/026/031/039–045 rule texts.
- Market baseline: policy-as-code separation, continuous control/evidence monitoring, auditable decisions, remediation visibility, and operational diagnostics. Generic CRUD, collection querying, table metadata, rendering, and shell ownership remain outside Complying.
- Factual baseline: standalone Symfony surfaces are present; local first-party Composer constraints/path identity were non-canonical; Collectioning/Tabling were missing from the direct baseline; `composer gating` referenced a deleted profile; persistent branch-coverage evidence needed normalization; historical sketch docs require evidence-driven Canon017 review.
- Canon mapping: Canon000 preserves `Compliance*` under `App\\Complying\\`; Canon001/019/020 preserve role-first Symfony roots; Canon010/017 require complete runtime/config/test/doc migrations; Canon015 keeps reusable runtime behavior out of tooling; Canon022 requires Cruding, Collectioning, Tabling, Viewing, Interfacing, Objecting and EasyAdmin directly in standalone mode; Canon026 is already satisfied by PHP `^8.4`/Symfony `^8.1`; Canon031 uses measured PHPDoc counters; Canon039/040 require PHPUnit plus persistent branch coverage; Canon041/042 require standalone behavioral/UI tooling/evidence assessment; Canon043 requires exact `dev-master` plus path `options.versions`; Canon044 requires entity-native Objecting persisted field names; Canon045 requires full reachable first-party local repository closure.
- RC-critical work: restore executable Gating, canonicalize Composer development identity/closure, complete standalone runtime baseline, materialize persistent branch coverage, then repair concrete in-scope gate failures. Growth work remains richer policy authoring/explanations, evidence/dashboard UX, and advanced diagnostics unless correctness/operability makes it blocking.
- Planned gates: strict Composer validation, Gating, changed PHP lint, PHPStan, PHPUnit, Symfony YAML/container lint, Doctrine parity, and final Git/worktree/upstream inspection.

#### Implementation and acceptance result

- Canon022/043/045 closure materialized: direct Collectioning/Tabling baseline, canonical `dev-master` sibling constraints, complete local path-repository closure with version pins, production manifest parity, and bundle registration.
- Canon039/041 tooling materialized: persistent PHPUnit path/branch coverage summary plus Symfony Test Pack, Panther, and repository-local Playwright configuration. Node/runtime artifacts are ignored.
- Canon044 repaired by moving persisted decision/case identity from Objecting-reserved `object_id`/`$objectId` to Complying-owned `target_id`/`$targetId`; external `object_id` payload/export compatibility is intentionally retained where it is API vocabulary rather than a persisted Objecting system field.
- Migration history was preserved: the existing initial migration remains unchanged and new `Version20260914082300` performs the PostgreSQL/SQLite `object_id` → `target_id` forward rename. Doctrine parity applied it to the disposable test database and passed mapping/schema/up-to-date checks.
- Confirmed stale platform drift was removed from `.github/workflows/compliance-ci.yml` and `docs/compliance/ci-pack.md`; CI now targets PHP 8.4.
- Final executable acceptance: `composer validate --strict --check-lock` PASS; `composer quality` PASS; PHPStan PASS (197 files); PHPUnit PASS (30 tests / 44 assertions, with one deprecation and seven PHPUnit notices); YAML PASS (41 files); container PASS; PHP-CS-Fixer PASS (0/197); Doctrine schema parity PASS; Gating PASS with 0 failed rules.
- Remaining measured warnings are governance debt, not hard gate failures: Canon040 reports 11.4% line / 9.7% method / 28.7% branch coverage (`HIGH_TEST_DEBT`), and Canon042 lacks behavioral/UI coverage evidence. These require a substantive test-development workstream rather than synthetic coverage inflation.
- Parallel pre-existing `.gating/**` modifications were not rewritten or selected for integration except the new repository-owned `.gating/profile/component/complying.yaml` required to run the Complying gate.

#### Embedded Gating preservation and validation

- The remaining pre-existing `.gating/**` worktree was inspected before cleanup and proved to be a coherent embedded Gating synchronization: Canon039–045 implementations/registry/calibration, Evidence Contract mirror validation, `.gate` → `.gating` path corrections, PHPUnit tooling, and updated Objecting field-name policy.
- The embedded sync was preserved as a separate integration unit rather than reset or folded into the Complying RC commit.
- `composer install` completed inside `.gating`; calibration PASS; PHPUnit unit PASS (1 test / 2 assertions); PHPStan PASS (89 files); PHP-CS-Fixer check PASS (0/91).
- A portability defect in the imported `test:unit` script was repaired from global `phpunit` to repository-local `@php vendor/bin/phpunit`; a redundant Canon045 PHPStan guard was also removed and formatted through the embedded fixer.
- After this tooling commit, the intended repository state is clean and eligible for guarded branch push.
