import { defineConfig } from '@playwright/test';

export default defineConfig({
  testDir: './tests/Browser',
  fullyParallel: false,
  forbidOnly: true,
  retries: 0,
  reporter: 'list',
  use: {
    baseURL: process.env.PLAYWRIGHT_BASE_URL ?? 'http://127.0.0.1:8000',
    trace: 'retain-on-failure',
  },
});
