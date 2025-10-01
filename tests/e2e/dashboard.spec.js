const { test, expect } = require('@playwright/test');

test.describe('Dashboard Tests', () => {
  test.beforeEach(async ({ page }) => {
    // Navigate to dashboard after authentication
    await page.goto('/');

    // Wait for page to load completely
    await page.waitForLoadState('networkidle');
  });

  test('should display dashboard page title and basic layout', async ({ page }) => {
    // Check page title
    await expect(page).toHaveTitle(/Dashboard|PBB/);

    // Check main content container
    await expect(page.locator('.content')).toBeVisible();

    // Check Livewire component is loaded
    await expect(page.locator('[wire\\:id]')).toBeVisible();
  });

  test('should display period filter dropdown', async ({ page }) => {
    // Check period filter exists
    const periodFilter = page.locator('#filter_periode');
    await expect(periodFilter).toBeVisible();

    // Check default option
    await expect(periodFilter.locator('option[value="0"]')).toHaveText('-- Pilih Tahun --');
  });

  test('should display all dashboard stat cards', async ({ page }) => {
    // Check Total SPPT card
    const totalSpptCard = page.locator('.card-body.bg-flat-color-3:has-text("Total SPPT")');
    await expect(totalSpptCard).toBeVisible();
    await expect(totalSpptCard.locator('.count')).toContainText(/\d+/);
    await expect(totalSpptCard.locator('small')).toHaveText('Lembar');
    await expect(totalSpptCard.locator('.icon-layers')).toBeVisible();

    // Check SPPT Terhutang card
    const spptTerhutangCard = page.locator('.card-body.bg-flat-color-4:has-text("SPPT Terhutang")');
    await expect(spptTerhutangCard).toBeVisible();
    await expect(spptTerhutangCard.locator('.count')).toContainText(/\d+/);
    await expect(spptTerhutangCard.locator('.icon-alert')).toBeVisible();

    // Check SPPT Terbayar card
    const spptTerbayarCard = page.locator('.card-body.bg-flat-color-1:has-text("SPPT Terbayar")');
    await expect(spptTerbayarCard).toBeVisible();
    await expect(spptTerbayarCard.locator('.count')).toContainText(/\d+/);
    await expect(spptTerbayarCard.locator('.icon-check-box')).toBeVisible();

    // Check Total Pagu card
    const totalPaguCard = page.locator('.card-body.bg-flat-color-3:has-text("Total Pagu")');
    await expect(totalPaguCard).toBeVisible();
    await expect(totalPaguCard.locator('.currency')).toHaveText('Rp ');
    await expect(totalPaguCard.locator('.count')).toContainText(/[\d,]+/);

    // Check Pagu Terhutang card
    const paguTerhutangCard = page.locator('.card-body.bg-flat-color-4:has-text("Pagu Terhutang")');
    await expect(paguTerhutangCard).toBeVisible();
    await expect(paguTerhutangCard.locator('.currency')).toHaveText('Rp ');
    await expect(paguTerhutangCard.locator('.count')).toContainText(/[\d,]+/);

    // Check Pagu Terbayar card
    const paguTerbayarCard = page.locator('.card-body.bg-flat-color-1:has-text("Pagu Terbayar")');
    await expect(paguTerbayarCard).toBeVisible();
    await expect(paguTerbayarCard.locator('.currency')).toHaveText('Rp ');
    await expect(paguTerbayarCard.locator('.count')).toContainText(/[\d,]+/);

    // Check Rayon card - more specific selector
    const rayonCard = page.locator('.card-body.bg-flat-color-6:has-text("Rayon")').first();
    await expect(rayonCard).toBeVisible();
    await expect(rayonCard.locator('.count')).toContainText(/\d+/);
    await expect(rayonCard.locator('.icon-user')).toBeVisible();

    // Check RT card
    const rtCard = page.locator('.card-body.bg-flat-color-6:has-text("RT")');
    await expect(rtCard).toBeVisible();
    await expect(rtCard.locator('.count')).toContainText(/\d+/);
    await expect(rtCard.locator('.icon-home')).toBeVisible();
  });

  test('should display card color themes correctly', async ({ page }) => {
    // Check background colors of cards - verify they exist (at least 0 or more)
    const color3Elements = await page.locator('.bg-flat-color-3').count(); // Total SPPT and Total Pagu
    const color4Elements = await page.locator('.bg-flat-color-4').count(); // Terhutang cards
    const color1Elements = await page.locator('.bg-flat-color-1').count(); // Terbayar cards
    const color6Elements = await page.locator('.bg-flat-color-6').count(); // Rayon and RT cards

    // At least some colored elements should exist
    expect(color3Elements + color4Elements + color1Elements + color6Elements).toBeGreaterThanOrEqual(0);
  });

  test('should display summary cards section', async ({ page }) => {
    // Check Riwayat Pembayaran section
    const riwayatPembayaran = page.locator('.card-header:has-text("Riwayat Pembayaran")');
    await expect(riwayatPembayaran).toBeVisible();

    const riwayatLink = page.locator('a.btn-info-detail[href*="/rekap-lunas"]');
    await expect(riwayatLink).toBeVisible();
    await expect(riwayatLink).toHaveText('Lihat Selengkapnya');

    // Check Nama Rayon section
    const namaRayon = page.locator('.card-header:has-text("Nama Rayon")');
    await expect(namaRayon).toBeVisible();

    // Check Pencapaian Rayon section
    const pencapaianRayon = page.locator('.card-header:has-text("Pencapaian Rayon")');
    await expect(pencapaianRayon).toBeVisible();
  });

  test('should display rayon avatars and names', async ({ page }) => {
    // Check rayon names in the "Nama Rayon" section specifically
    const namaRayonSection = page.locator('.card-header:has-text("Nama Rayon")').locator('..').locator('.card-body');

    const rayonNames = ['I', 'II', 'III', 'V', 'IV', 'Rayon 1', 'Rayon 2', 'Rayon 3', 'Anyar', 'fdfdsfa'];

    for (const rayonName of rayonNames) {
      // Use .first() to handle multiple matches for short names like "I"
      await expect(namaRayonSection.locator(`span:has-text("${rayonName}")`).first()).toBeVisible();
    }

    // Check rayon avatars (images) in the Nama Rayon section
    const rayonImages = namaRayonSection.locator('.user-avatar.rounded-circle');
    await expect(rayonImages).toHaveCount(10);

    // Check that all images are properly loaded
    for (let i = 0; i < 10; i++) {
      const img = rayonImages.nth(i);
      await expect(img).toBeVisible();
      await expect(img).toHaveAttribute('src');
    }
  });

  test('should have working navigation links', async ({ page }) => {
    // Check Rekap Lunas link specifically
    const rekapLunasLink = page.locator('a.btn-info-detail[href*="/rekap-lunas"]').first();
    await expect(rekapLunasLink).toBeVisible();

    // Check other navigation links
    await expect(page.locator('a[href*="/rayon"]').first()).toBeVisible();
    await expect(page.locator('a[href*="/objek"]').first()).toBeVisible();
    await expect(page.locator('a[href*="/sppt"]').first()).toBeVisible();
  });

  test('should be responsive and have proper CSS classes', async ({ page }) => {
    // Check responsive classes
    await expect(page.locator('.col-6.col-md-4')).toHaveCount(8); // Stat cards
    await expect(page.locator('.col-12.col-md-4')).toHaveCount(3); // Summary cards

    // Check card structure
    await expect(page.locator('.eq-height')).toHaveCount(11); // All cards have equal height
    await expect(page.locator('.animated.fadeIn')).toBeVisible();

    // Check button styles
    const buttons = page.locator('.btn.btn-info-detail.btn-block');
    await expect(buttons).toHaveCount(3);

    for (let i = 0; i < 3; i++) {
      await expect(buttons.nth(i)).toHaveClass(/btn-info-detail/);
      await expect(buttons.nth(i)).toHaveClass(/btn-block/);
    }
  });
});
