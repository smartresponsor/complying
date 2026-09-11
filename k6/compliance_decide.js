import http from 'k6/http';

// This k6 probe targets real routes present in this component.
// Override base URL with: COMPLIANCE_BASE_URL=http://localhost:8080

const BASE_URL = __ENV.COMPLIANCE_BASE_URL || 'http://localhost:8080';

export default function () {
  http.get(`${BASE_URL}/compliance/status`);
}
