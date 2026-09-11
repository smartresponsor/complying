api-hmac sketch
- подписываем все /compliance/*: X-SR-Signature, X-SR-Timestamp
- формула: hmac_sha256(ts:body, COMPLIANCE_HMAC_KEY)
- толеранс: 120 сек
- при fail → 403 и audit в base слое (настроить позже)
