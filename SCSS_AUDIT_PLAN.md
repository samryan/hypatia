# SCSS Audit & Improvement Plan

## Current State Analysis

- **File size**: 1,542 lines in single `style.scss`
- **Deep nesting**: ~333 lines with 4+ levels of nesting
- **!important usage**: 9 instances
- **ID selectors**: `#toggle-theme`, `#toggle-menu` (acceptable for unique elements)
- **Variables**: Well-organized at top (colors, fonts, breakpoints)
- **Imports**: normalize, a11y partials already exist

## Phase 1: Safe Cleanup (No Visual Changes)

### 1.1 Install Stylelint
```bash
npm install -D stylelint stylelint-config-standard-scss
```

Create `stylelint.config.mjs`:
```js
export default {
  extends: ["stylelint-config-standard-scss"],
  rules: {
    "selector-id-pattern": null, // Allow IDs for now
    "scss/at-rule-no-unknown": true,
    "max-nesting-depth": [4, { ignore: ["blockless-at-rules", "pseudo-classes"] }]
  }
};
```

### 1.2 Review & Document !important Usage
Current locations to audit:
- Nav link colors (likely specificity wars)
- Logo colors
Review if these can be resolved with better selector specificity.

### 1.3 Reduce Nesting Depth
Target areas with deepest nesting:
- Book card components
- Dark mode overrides
- Navigation styles

**Safe refactor pattern:**
```scss
// Before (4+ levels deep)
nav {
  ul {
    li {
      a {
        &:hover { ... }
      }
    }
  }
}

// After (flatter)
nav ul { ... }
nav li { ... }
nav a { ... }
nav a:hover { ... }
```

## Phase 2: Organization (No Visual Changes)

### 2.1 Extract Variables to Partial
Create `_variables.scss` with:
- Colors
- Typography
- Breakpoints
- Spacing scale (new)

### 2.2 Add Spacing Scale Variables
```scss
$space-xs: 0.25rem;
$space-sm: 0.5rem;
$space-md: 1rem;
$space-lg: 2rem;
$space-xl: 5rem;
```

### 2.3 Logical Section Ordering
Recommended order (already partially followed):
1. Variables & imports
2. Base/reset styles
3. Typography
4. Layout (containers, grid)
5. Navigation
6. Components (buttons, forms, cards)
7. Page-specific styles
8. Dark mode overrides
9. Utilities

## Phase 3: Optional File Splitting

If desired, split into 7-1 pattern:
```
scss/
├── abstracts/
│   ├── _variables.scss
│   └── _mixins.scss
├── base/
│   ├── _reset.scss
│   └── _typography.scss
├── components/
│   ├── _buttons.scss
│   ├── _book-cards.scss
│   └── _navigation.scss
├── layout/
│   ├── _header.scss
│   ├── _footer.scss
│   └── _container.scss
├── pages/
│   ├── _home.scss
│   ├── _books.scss
│   └── _projects.scss
├── themes/
│   └── _dark.scss
└── style.scss (imports only)
```

**Note**: This is optional and adds complexity. Single-file works fine for this project size.

## Implementation Approach

### Safety Measures
1. **Visual regression testing**: Take screenshots before/after each change
2. **Git commits**: Small, atomic commits for each refactor
3. **No selector changes**: Keep all class/ID names identical
4. **Compile & compare**: Diff compiled CSS to ensure output matches

### Recommended Order
1. Run Stylelint, review warnings
2. Fix obvious issues (empty rules, duplicate properties)
3. Flatten deepest nesting (one section at a time)
4. Extract variables partial
5. Add section comment headers where missing
6. Review !important usage last (highest risk)

## Quick Wins (15 min)

- [ ] Add missing section comments for clarity
- [ ] Remove any commented-out code
- [ ] Consolidate duplicate media queries where adjacent
- [ ] Alphabetize properties within rules (optional, tooling can do this)

## Metrics to Track

Before/after comparison:
- Total lines
- Nesting depth (max and average)
- !important count
- Compiled CSS size
- Stylelint warning count

---

## Audit Results (Completed)

**Date**: January 2026

### Issues Found & Fixed
- ✅ **12 zero-unit issues** (`0px` → `0`) - Fixed
- ✅ **10 redundant shorthand values** - Fixed

### Issues Reviewed & Left As-Is
- **9 !important usages** - All legitimate (nav color overrides, dark mode)
- **34 variable naming** - Uses `__` convention consistently, no need to change
- **3 nesting depth violations** - Minor, logical nesting for nav/book cards
- **125 whitespace issues** - Cosmetic, low priority
- **18 global function names** - `lighten()` works fine, no need for modern syntax

### Overall Assessment
The SCSS is in good shape. Main areas for future improvement:
1. Could extract variables to `_variables.scss` partial
2. Could add more section comments for clarity
3. File splitting is optional - 1500 lines is manageable
