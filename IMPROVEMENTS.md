# Hypatia Theme - Improvement Opportunities

Audit conducted: 2026-02-07

## Status Legend
- 🔴 Not started
- 🟡 In progress
- 🟢 Complete
- ⚪ Won't fix

---

## 1. Book Cover Image Alt Text ⚪
**Files:** `template-parts/content-books.php`, `functions.php:400`, `books-YYYY.php` files

Empty alt tags are intentional - book covers are decorative since title/author text is adjacent.

---

## 2. Book Year Template Duplication 🟢
**Files:** `books-2009.php` through `books-2026.php` (17 files) → consolidated to `books-year.php`

~1,020 lines of duplicate code reduced to ~60 lines. Single template extracts year from page slug (`list-YYYY` → `YYYY`).

**Completed:** 2026-02-07

---

## 3. Responsive Images ⚪
**Files:** Book templates using `the_post_thumbnail_url('full')`

Won't fix - images are already manually optimized (max 600px, <200kb). WordPress thumbnail sizes not configured consistently, and older books are missing intermediate sizes. Potential savings minimal.

---

## 4. Render-Blocking Google Fonts 🟢
**File:** `style.scss:57` → `header.php`

Moved Google Fonts from CSS `@import` to `<link>` tags with `preconnect` hints in header.php.

**Completed:** 2026-02-07

---

## 5. Focus Indicators ⚪
**File:** `style.scss`

Won't fix - manual testing confirms focus outlines are visible on all interactive elements in both light and dark mode. The `outline: 0` on `:active` only affects momentary click state, not keyboard focus.

---

## 6. Link Hover Contrast ⚪
**File:** `style.scss:100-108`

Won't fix - WCAG contrast requirements apply to default states, not transient hover states. Default link color (#3e3c2f on #f4f4f0) has excellent contrast (~9:1).

---

## 7. CSS Size / Dark Mode Optimization 🟢
**File:** `style.scss`

Refactored to use CSS custom properties throughout. Base styles now use `var(--color-*)` instead of SCSS variables, eliminating redundant dark mode overrides.

- Before: 53KB, 2,611 lines
- After: 49KB, 2,455 lines (-8% file size, -156 lines)
- Dark mode block reduced from ~300 lines to ~100 lines

**Completed:** 2026-02-07

---

## 8. Grade.js Performance 🟢
**File:** `footer.php`, `grade.min.js`

Removed entirely - the `.gradient-wrap` class wasn't being used anywhere in the templates.

**Completed:** 2026-02-07

---

## 9. Inline JavaScript ⚪
**File:** `footer.php`

Won't fix - keeping inline avoids an extra HTTP request. Footer.php is already included on every page, so the JS is effectively "cached" in the template.

---

## 10. Hardcoded Post IDs ⚪
**File:** `functions.php:203-206`

Won't fix - low-risk admin-only code, pages are unlikely to be recreated.

---

## 11. Schema.org Markup 🟢
**File:** `template-parts/content-books.php`

Added `itemprop="image"` to book cover. ISBN and datePublished skipped - data not available.

**Completed:** 2026-02-07

---

## 12. CSS Magic Numbers ⚪
**File:** `style.scss` (various)

Won't fix - values are contextual and self-explanatory in their usage.

---

## 13. Extract() Usage 🟢
**File:** `books-main.php:133`

Removed `extract($stats)` and replaced all variable references with explicit array access (`$stats['total_books']`, etc.).

**Completed:** 2026-02-07

---

## Notes

_Add discussion notes here as issues are reviewed._
