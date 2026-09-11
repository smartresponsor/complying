hardening sketch
- adds App\Complying\Service\ComplianceGuard
- DENY -> exception
- unreachability -> defer to messenger (if enabled) or throw ComplianceUnavailableException
- controlled by parameter: compliance.fallback_to_deferred
