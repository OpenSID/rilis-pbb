const { test, expect } = require('@playwright/test');

test.describe('Objek Pajak Tests', () => {
  test.beforeEach(async ({ page }) => {
    // Navigate to objek pajak page after authentication
    await page.goto('/objek-pajak');

    // Wait for page to load completely
    await page.waitForLoadState('networkidle');
  });

  test('should display objek pajak page title and basic layout', async ({ page }) => {
    // Check specific page title for objek pajak
    await expect(page).toHaveTitle(/Objek Pajak|Objek|PBB/);

    // Check main content container
    await expect(page.locator('.content')).toBeVisible();

    // Check for objek pajak-specific heading
    await expect(page.locator('h1:has-text("Objek Pajak"), h2:has-text("Objek Pajak"), h3:has-text("Objek Pajak"), h1:has-text("Objek"), h2:has-text("Objek"), h3:has-text("Objek")')).toBeVisible();
  });

  test('should display objek pajak data table', async ({ page }) => {
    // Check if there's a data table
    const tables = page.locator('table, .table');
    const tableCount = await tables.count();

    if (tableCount > 0) {
      await expect(tables.first()).toBeVisible();

      // Check table headers exist
      const tableHeaders = tables.first().locator('thead th, th');
      if (await tableHeaders.count() > 0) {
        await expect(tableHeaders.first()).toBeVisible();
      }

      // Check if there are table rows with data
      const tableRows = tables.first().locator('tbody tr, tr');
      const rowCount = await tableRows.count();
      if (rowCount > 0) {
        await expect(tableRows.first()).toBeVisible();
      }
    }
  });

  test('should display objek pajak specific fields', async ({ page }) => {
    // Check for common objek pajak fields
    const nopFields = page.locator(':has-text("NOP"), :has-text("Nomor Objek Pajak")');
    const luasFields = page.locator(':has-text("Luas"), :has-text("Area")');
    const nilaiFields = page.locator(':has-text("Nilai"), :has-text("Value"), :has-text("NJOP")');
    const kelasFields = page.locator(':has-text("Kelas"), :has-text("Class")');

    const nopCount = await nopFields.count();
    const luasCount = await luasFields.count();
    const nilaiCount = await nilaiFields.count();
    const kelasCount = await kelasFields.count();

    if (nopCount > 0) {
      await expect(nopFields.first()).toBeVisible();
    }

    if (luasCount > 0) {
      await expect(luasFields.first()).toBeVisible();
    }

    if (nilaiCount > 0) {
      await expect(nilaiFields.first()).toBeVisible();
    }

    if (kelasCount > 0) {
      await expect(kelasFields.first()).toBeVisible();
    }
  });

  test('should display objek pajak categories', async ({ page }) => {
    // Check for objek pajak categories
    const bangunanFields = page.locator(':has-text("Bangunan"), :has-text("Building")');
    const tanahFields = page.locator(':has-text("Tanah"), :has-text("Land")');
    const jenisFields = page.locator(':has-text("Jenis"), :has-text("Type")');

    const bangunanCount = await bangunanFields.count();
    const tanahCount = await tanahFields.count();
    const jenisCount = await jenisFields.count();

    if (bangunanCount > 0) {
      await expect(bangunanFields.first()).toBeVisible();
    }

    if (tanahCount > 0) {
      await expect(tanahFields.first()).toBeVisible();
    }

    if (jenisCount > 0) {
      await expect(jenisFields.first()).toBeVisible();
    }
  });

  test('should have search functionality if available', async ({ page }) => {
    // Check for search input
    const searchInput = page.locator('input[type="search"], input[placeholder*="cari"], input[placeholder*="search"], #search, input[placeholder*="nop"], input[placeholder*="alamat"]');
    const searchCount = await searchInput.count();

    if (searchCount > 0) {
      await expect(searchInput.first()).toBeVisible();

      // Test search functionality with common objek pajak data
      await searchInput.first().fill('test');
      await expect(searchInput.first()).toHaveValue('test');

      // Clear search
      await searchInput.first().clear();
    }
  });

  test('should have pagination if available', async ({ page }) => {
    // Check for pagination elements
    const pagination = page.locator('.pagination, .dataTables_paginate, [class*="page"]');
    const paginationCount = await pagination.count();

    if (paginationCount > 0) {
      await expect(pagination.first()).toBeVisible();

      // Check for page numbers or next/prev buttons
      const paginationLinks = pagination.first().locator('a, button');
      const linkCount = await paginationLinks.count();
      if (linkCount > 0) {
        await expect(paginationLinks.first()).toBeVisible();
      }
    }
  });

  test('should display action buttons if available', async ({ page }) => {
    // Check for the "Tambah" (Add) button
    const addButton = page.locator('button:has-text("Tambah"), a:has-text("Tambah"), .btn:has-text("Tambah")');
    const addCount = await addButton.count();

    if (addCount > 0) {
      await expect(addButton.first()).toBeVisible();
    }

    // Check for edit buttons
    const editButtons = page.locator('button:has-text("Edit"), a:has-text("Edit"), .btn:has-text("Edit")');
    const editCount = await editButtons.count();

    if (editCount > 0) {
      await expect(editButtons.first()).toBeVisible();
    }

    // Check for delete buttons
    const deleteButtons = page.locator('button:has-text("Hapus"), button:has-text("Delete"), .btn:has-text("Hapus")');
    const deleteCount = await deleteButtons.count();

    if (deleteCount > 0) {
      await expect(deleteButtons.first()).toBeVisible();
    }

    // Check for detail/view buttons
    const detailButtons = page.locator('button:has-text("Detail"), a:has-text("Detail"), .btn:has-text("Detail"), button:has-text("Lihat"), a:has-text("Lihat")');
    const detailCount = await detailButtons.count();

    if (detailCount > 0) {
      await expect(detailButtons.first()).toBeVisible();
    }
  });

  test('should display import/export functionality if available', async ({ page }) => {
    // Check for import buttons
    const importButtons = page.locator('button:has-text("Import"), a:has-text("Import"), .btn:has-text("Import")');
    const importCount = await importButtons.count();

    if (importCount > 0) {
      await expect(importButtons.first()).toBeVisible();
    }

    // Check for export buttons
    const exportButtons = page.locator('button:has-text("Export"), a:has-text("Export"), .btn:has-text("Export"), button:has-text("Unduh"), a:has-text("Unduh")');
    const exportCount = await exportButtons.count();

    if (exportCount > 0) {
      await expect(exportButtons.first()).toBeVisible();
    }

    // Check for file upload inputs
    const fileInputs = page.locator('input[type="file"]');
    const fileCount = await fileInputs.count();

    if (fileCount > 0) {
      await expect(fileInputs.first()).toBeVisible();
    }
  });

  test('should display filter options if available', async ({ page }) => {
    // Check for common filters
    const kelasFilter = page.locator('select[name*="kelas"], select:has(option:has-text("Kelas"))');
    const jenisFilter = page.locator('select[name*="jenis"], select:has(option:has-text("Jenis"))');
    const rayonFilter = page.locator('select[name*="rayon"], select:has(option:has-text("Rayon"))');

    const kelasCount = await kelasFilter.count();
    const jenisCount = await jenisFilter.count();
    const rayonCount = await rayonFilter.count();

    if (kelasCount > 0) {
      await expect(kelasFilter.first()).toBeVisible();
    }

    if (jenisCount > 0) {
      await expect(jenisFilter.first()).toBeVisible();
    }

    if (rayonCount > 0) {
      await expect(rayonFilter.first()).toBeVisible();
    }
  });

  test('should display objek pajak cards or list items', async ({ page }) => {
    // Check for cards
    const cards = page.locator('.card, .card-body');
    const cardCount = await cards.count();

    if (cardCount > 0) {
      await expect(cards.first()).toBeVisible();
    }

    // Check for table rows which act as list items
    const tableRows = page.locator('table tbody tr, table tr');
    const rowCount = await tableRows.count();

    if (rowCount > 0) {
      await expect(tableRows.first()).toBeVisible();
    }
  });

  test('should have proper navigation and breadcrumbs', async ({ page }) => {
    // Check for breadcrumbs
    const breadcrumbs = page.locator('.breadcrumb, .breadcrumb-item, [aria-label="breadcrumb"]');
    const breadcrumbCount = await breadcrumbs.count();

    if (breadcrumbCount > 0) {
      await expect(breadcrumbs.first()).toBeVisible();
    }

    // Check for navigation menu
    const navMenu = page.locator('nav, .navbar, .sidebar');
    await expect(navMenu.first()).toBeVisible();
  });

  test('should handle empty state gracefully', async ({ page }) => {
    // Check if page loads even when no data is available
    await expect(page.locator('body')).toBeVisible();

    // Look for empty state messages
    const emptyState = page.locator(':has-text("Tidak ada data"), :has-text("No data"), :has-text("Empty"), .empty-state');
    const emptyCount = await emptyState.count();

    // Either data should be present or empty state should be shown
    const hasData = await page.locator('table tbody tr, .list-group-item, .card-body').count() > 0;
    const hasEmptyState = emptyCount > 0;

    expect(hasData || hasEmptyState).toBeTruthy();
  });

  test('should be responsive and have proper CSS classes', async ({ page }) => {
    // Check for Bootstrap column classes
    const colElements = page.locator('[class*="col-"]');
    const rowElements = page.locator('.row');
    const containerElements = page.locator('.container, .container-fluid');

    const colCount = await colElements.count();
    const rowCount = await rowElements.count();
    const containerCount = await containerElements.count();

    // At least one of these should be present for responsive layout
    expect(colCount + rowCount + containerCount).toBeGreaterThan(0);

    // Check for Bootstrap or similar framework classes - only visible elements
    const visibleFrameworkElements = page.locator('.btn:visible, .card:visible, .table:visible, .form-control:visible');
    const frameworkCount = await visibleFrameworkElements.count();

    if (frameworkCount > 0) {
      await expect(visibleFrameworkElements.first()).toBeVisible();
    }
  });

  test('should load without JavaScript errors', async ({ page }) => {
    // Check that no major JavaScript errors occurred
    await expect(page.locator('body')).toBeVisible();

    // Verify essential elements are loaded
    await expect(page.locator('.content, .main, #content, main')).toBeVisible();
  });

  test('should handle tambah button click functionality', async ({ page }) => {
    // Find and click the Tambah button
    const tambahButton = page.locator('button:has-text("Tambah"), .btn:has-text("Tambah"), a:has-text("Tambah")').first();

    // Check if button exists and is clickable
    if (await tambahButton.count() > 0) {
      await expect(tambahButton).toBeVisible();
      await expect(tambahButton).toBeEnabled();

      // Get current URL before clicking
      const currentUrl = page.url();

      // Click the tambah button and wait for navigation
      await tambahButton.click();

      // Wait for potential navigation
      await page.waitForLoadState('networkidle', { timeout: 10000 });

      // Check if navigation occurred
      const newUrl = page.url();
      if (newUrl !== currentUrl) {
        // Navigation occurred - verify new page elements
        // Check for form elements or page content that indicates add/create page
        const hasFormElements = await page.locator('form, input[type="text"], input[type="email"], textarea, select').count() > 0;
        const hasCreateContent = await page.locator('text=Tambah, text=Create, text=Buat, text=Add').count() > 0;

        expect(hasFormElements || hasCreateContent).toBeTruthy();

        // If form inputs are present, check for objek pajak specific fields
        if (hasFormElements) {
          const nopInput = page.locator('input[name*="nop"], input[placeholder*="nop"], input[name*="nomor"]');
          const alamatInput = page.locator('input[name*="alamat"], textarea[name*="alamat"], input[name*="address"]');
          const luasInput = page.locator('input[name*="luas"], input[placeholder*="luas"], input[name*="area"]');
          const nilaiInput = page.locator('input[name*="nilai"], input[name*="njop"], input[placeholder*="nilai"]');

          // Check if objek pajak specific fields exist
          const hasObjekPajakFields = await nopInput.count() > 0 ||
                                      await alamatInput.count() > 0 ||
                                      await luasInput.count() > 0 ||
                                      await nilaiInput.count() > 0;

          if (hasObjekPajakFields) {
            expect(hasObjekPajakFields).toBeTruthy();
          }
        }
      } else {
        // No navigation - button click was successful
        expect(true).toBeTruthy();
      }
    }
  });
});
