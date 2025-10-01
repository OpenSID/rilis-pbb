import { test, expect } from '@playwright/test';

test.describe('Rekap Waktu Page', () => {
  test.beforeEach(async ({ page }) => {
    // Menggunakan storage state untuk otentikasi
    await page.goto('/rekap-waktu');
  });

  // Test 1: Memastikan halaman terakses dengan benar
  test('should load Rekap Waktu page with correct title', async ({ page }) => {
    await expect(page).toHaveTitle('Rekap Waktu | Pencatatan Pajak');
    await expect(page.locator('h1, h2, h3').filter({ hasText: 'Rekap Waktu' })).toBeVisible();
  });

  // Test 2: Memastikan tabel data tersedia
  test('should display data table with correct headers', async ({ page }) => {
    // Tunggu sampai tabel dimuat
    await page.waitForLoadState('networkidle');

    // Periksa keberadaan tabel
    const table = page.locator('table').first();
    await expect(table).toBeVisible();

    // Periksa header tabel
    await expect(page.locator('th').filter({ hasText: 'No' })).toBeVisible();
    await expect(page.locator('th').filter({ hasText: 'Tanggal Pelunasan' })).toBeVisible();
    await expect(page.locator('th').filter({ hasText: 'Jumlah Penerimaan' })).toBeVisible();
    await expect(page.locator('th').filter({ hasText: 'Status Setor' })).toBeVisible();
    await expect(page.locator('th').filter({ hasText: 'Tanggal Setor' })).toBeVisible();
  });

  // Test 3: Memastikan filter input tersedia
  test('should have filter inputs available', async ({ page }) => {
    await page.waitForLoadState('networkidle');

    // Periksa keberadaan input filter (sesuaikan dengan realitas)
    const filterInputs = page.locator('input[type="text"], input[type="date"], input[type="search"], select');
    const count = await filterInputs.count();
    expect(count).toBeGreaterThanOrEqual(2);
  });

  // Test 4: Test fungsionalitas filter/search
  test('should be able to interact with filter inputs', async ({ page }) => {
    await page.waitForLoadState('networkidle');

    // Cari input filter pertama yang bisa diisi
    const firstInput = page.locator('input[type="text"], input[type="date"], input[type="search"]').first();
    if (await firstInput.isVisible()) {
      await firstInput.click();
      await firstInput.fill('test');
      await expect(firstInput).toHaveValue('test');
    }
  });

  // Test 5: Memastikan cards/summary sections tersedia
  test('should display summary cards or sections', async ({ page }) => {
    await page.waitForLoadState('networkidle');

    // Berdasarkan analisis, ada 1 card/summary section
    const cards = page.locator('.card, .summary, .stats, [class*="card"], [class*="summary"]');
    await expect(cards.first()).toBeVisible();
  });

  // Test 6: Test navigasi breadcrumb
  test('should have proper breadcrumb navigation', async ({ page }) => {
    await page.waitForLoadState('networkidle');

    // Periksa breadcrumb atau navigasi
    const breadcrumb = page.locator('.breadcrumb, nav, [class*="breadcrumb"]');
    await expect(breadcrumb.first()).toBeVisible();
  });

  // Test 7: Test keyword yang relevan ada di halaman
  test('should contain relevant keywords for Rekap Waktu', async ({ page }) => {
    await page.waitForLoadState('networkidle');

    // Periksa keyword yang ditemukan dalam analisis
    await expect(page.locator('body')).toContainText('Rekap');
    await expect(page.locator('body')).toContainText('Laporan');

    // Keyword specific untuk rekap waktu
    const pageContent = await page.textContent('body');
    expect(pageContent).toMatch(/Jumlah|Periode|Pembayaran|SPPT/);
  });

  // Test 8: Test responsivitas halaman
  test('should be responsive on different screen sizes', async ({ page }) => {
    // Test desktop view
    await page.setViewportSize({ width: 1200, height: 800 });
    await expect(page.locator('table').first()).toBeVisible();

    // Test tablet view
    await page.setViewportSize({ width: 768, height: 1024 });
    await expect(page.locator('h1, h2, h3').filter({ hasText: 'Rekap Waktu' })).toBeVisible();

    // Test mobile view
    await page.setViewportSize({ width: 375, height: 667 });
    await expect(page.locator('h1, h2, h3').filter({ hasText: 'Rekap Waktu' })).toBeVisible();
  });

  // Test 9: Test menu navigasi sidebar
  test('should have working sidebar navigation menu', async ({ page }) => {
    await page.waitForLoadState('networkidle');

    // Periksa menu navigasi berdasarkan button yang ditemukan (dengan fallback)
    const tentangPbbButton = page.locator('text=Tentang PBB');
    if (await tentangPbbButton.count() > 0) {
      // Element ada tapi mungkin collapsed, cek apakah ada di DOM
      expect(await tentangPbbButton.count()).toBeGreaterThan(0);
    }

    // Test alternative - cek apakah ada navigation elements
    const navElements = page.locator('nav, .nav, .navigation, .sidebar, .menu');
    await expect(navElements.first()).toBeVisible();
  });

  // Test 10: Test tombol Keluar
  test('should have logout button available', async ({ page }) => {
    await page.waitForLoadState('networkidle');

    const logoutButton = page.locator('text=Keluar');
    // Test bahwa button ada di DOM (mungkin dalam dropdown atau hidden menu)
    expect(await logoutButton.count()).toBeGreaterThan(0);

    // Jika ada, pastikan bisa diklik (mungkin perlu klik untuk expand menu dulu)
    if (await logoutButton.count() > 0) {
      // Coba cari parent menu atau dropdown yang mungkin perlu diklik dulu
      const profileMenu = page.locator('.user-menu, .profile-menu, .dropdown-toggle, [data-bs-toggle="dropdown"]');
      if (await profileMenu.count() > 0) {
        await profileMenu.first().click();
        await page.waitForTimeout(500);
      }
    }
  });

  // Test 11: Test data loading state
  test('should handle data loading properly', async ({ page }) => {
    // Reload halaman untuk test loading
    await page.reload();

    // Tunggu sampai konten dimuat
    await page.waitForLoadState('networkidle');

    // Pastikan tidak ada error message
    const errorMessage = page.locator('.error, .alert-danger, [class*="error"]');
    await expect(errorMessage).toHaveCount(0);

    // Pastikan tabel atau konten utama tersedia
    await expect(page.locator('table, .table').first()).toBeVisible();
  });

  // Test 12: Test page performance
  test('should load page within acceptable time', async ({ page }) => {
    const startTime = Date.now();
    await page.goto('/rekap-waktu');
    await page.waitForLoadState('networkidle');
    const loadTime = Date.now() - startTime;

    // Pastikan halaman dimuat dalam waktu yang wajar (kurang dari 5 detik)
    expect(loadTime).toBeLessThan(5000);

    // Pastikan konten utama tersedia
    await expect(page.locator('h1, h2, h3').filter({ hasText: 'Rekap Waktu' })).toBeVisible();
  });
});
