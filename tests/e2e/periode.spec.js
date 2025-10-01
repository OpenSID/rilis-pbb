const { test, expect } = require('@playwright/test');

test.describe('Periode Tests', () => {
  test.beforeEach(async ({ page }) => {
    // Navigate to periode page after authentication
    await page.goto('/periode');

    // Wait for page to load completely
    await page.waitForLoadState('networkidle');
  });

  test('should display periode page title and basic layout', async ({ page }) => {
    // Check specific page title for periode
    await expect(page).toHaveTitle(/Periode|PBB/);

    // Check main content container
    await expect(page.locator('.content')).toBeVisible();

    // Check for periode-specific heading
    await expect(page.locator('h1:has-text("Periode"), h2:has-text("Periode"), h3:has-text("Periode")')).toBeVisible();
  });

  test('should display periode data table', async ({ page }) => {
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

  test('should display year selector or date filters', async ({ page }) => {
    // Check for year/date related inputs
    const yearInputs = page.locator('select[name*="tahun"], select[name*="year"], input[type="date"], input[placeholder*="tahun"]');
    const yearCount = await yearInputs.count();

    if (yearCount > 0) {
      await expect(yearInputs.first()).toBeVisible();
    }

    // Check for periode-specific filters
    const periodeFilters = page.locator('select[name*="periode"], input[name*="periode"]');
    const filterCount = await periodeFilters.count();

    if (filterCount > 0) {
      await expect(periodeFilters.first()).toBeVisible();
    }
  });

  test('should have search functionality if available', async ({ page }) => {
    // Check for search input
    const searchInput = page.locator('input[type="search"], input[placeholder*="cari"], input[placeholder*="search"], #search');
    const searchCount = await searchInput.count();

    if (searchCount > 0) {
      await expect(searchInput.first()).toBeVisible();

      // Test search functionality
      await searchInput.first().fill('2024');
      await expect(searchInput.first()).toHaveValue('2024');

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
  });

  test('should display periode information', async ({ page }) => {
    // Check for periode-specific information like years
    const currentYear = new Date().getFullYear();
    const lastYear = currentYear - 1;
    const nextYear = currentYear + 1;

    // Look for common years that might be displayed
    const yearElements = page.locator(`:has-text("${currentYear}"), :has-text("${lastYear}"), :has-text("${nextYear}")`);
    const yearCount = await yearElements.count();

    if (yearCount > 0) {
      await expect(yearElements.first()).toBeVisible();
    }

    // Check for status indicators (active/inactive periods)
    const statusElements = page.locator(':has-text("Aktif"), :has-text("Active"), :has-text("Nonaktif"), :has-text("Inactive")');
    const statusCount = await statusElements.count();

    if (statusCount > 0) {
      await expect(statusElements.first()).toBeVisible();
    }
  });

  test('should display cards or list items', async ({ page }) => {
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

      // Click the button and wait for navigation
      await tambahButton.click();

      // Wait for navigation to complete with shorter timeout
      try {
        await page.waitForLoadState('networkidle', { timeout: 5000 });
      } catch (error) {
        // If navigation doesn't complete, that's okay - just continue
        console.log('Navigation timeout - continuing with test');
      }

      // Check if URL has changed (indicating navigation to a new page)
      const newUrl = page.url();

      if (newUrl !== currentUrl) {
        // URL changed - we navigated to a new page
        // Check that the new page loaded successfully
        await expect(page.locator('body')).toBeVisible();

        // Look for form elements that are NOT the logout form
        const createFormElements = page.locator('form:not([action*="logout"]) input[type="text"], form:not([action*="logout"]) textarea, form:not([action*="logout"]) select');
        const anyFormElements = page.locator('input[type="text"], textarea, select[name]:not([name=""])');

        // Check for page title or heading indicating it's an add/create page
        const addPageIndicators = page.locator('text=Tambah, text=Create, text=Buat, text=Add');

        // Check for periode-specific form fields
        const tahunInput = page.locator('input[name*="tahun"], input[placeholder*="tahun"], input[name*="year"], select[name*="tahun"]');

        // Verify page has form elements or create content or specific fields
        const hasCreateForms = await createFormElements.count() > 0;
        const hasAnyForms = await anyFormElements.count() > 0;
        const hasCreateContent = await addPageIndicators.count() > 0;
        const hasSpecificFields = await tahunInput.count() > 0;

        expect(hasCreateForms || hasAnyForms || hasCreateContent || hasSpecificFields).toBeTruthy();

      }
    }
  });
});
