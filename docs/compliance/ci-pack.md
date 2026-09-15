ci-pack sketch
- .github/workflows/compliance-ci.yml
- PHP 8.4 (repository baseline; keep this aligned with `composer.json` and Canon026)
- гоняет phpunit, slo (лайтовый), выгружает артефакт
- требует, чтобы tools/slo и tools/e2e уже были в репозитории
