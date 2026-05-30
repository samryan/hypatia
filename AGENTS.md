# AGENTS.md

## Cursor Cloud specific instructions

### What this repo is

**Hypatia** is a WordPress theme (PHP + SCSS + vanilla JS), not a standalone app. There is no `package.json`, Composer manifest, lint config, or automated test suite in the repo. Production deploy compiles CSS with Sass and SFTPs the theme to NearlyFreeSpeech (see `.github/workflows/deploy.yml` and `README.md`).

### System dependencies (one-time on a fresh VM)

Local WordPress development requires packages that are **not** installed by the VM update script:

- `php-cli`, `php-mysql`, `php-mbstring`, `php-xml`, `php-curl` (mbstring is required — `hypatia_rating_to_stars()` uses `mb_strpos`)
- `mariadb-server` (start with `sudo service mariadb start`)
- [WP-CLI](https://wp-cli.org/) (`wp` on `PATH`)

Node.js is already available via nvm on Cloud VMs; Sass is invoked ephemerally with `npx` (same as CI).

### Local WordPress instance

A working dev stack lives at **`.dev-wp/`** (git-ignored by convention; do not commit). It is created once per VM:

1. Create DB/user, download core, symlink theme:
   - Theme path: `.dev-wp/wp-content/themes/hypatia` → repo root (`/workspace`)
2. `wp core install` with URL `http://127.0.0.1:8080`
3. `wp theme activate hypatia`
4. `wp rewrite structure '/%postname%/' --hard` then `wp rewrite flush`
5. Use `.dev-wp/wp-content/mu-plugins/hypatia-dev-fixtures.php` for local-only fixtures: registers the `books` post type (production uses ACF/plugin), stubs minimal ACF helpers, seeds sample book + `/books/` page with `books-main.php` template. CPT rewrite slug is `book` (singular) so the **Reading** page can own `/books/`.

### Running services

| Service | Command | Notes |
|--------|---------|--------|
| WordPress | `cd .dev-wp && wp server --host=127.0.0.1 --port=8080` | Use a tmux session for long-running dev server |
| MariaDB | `sudo service mariadb start` | Required before `wp` DB commands |

Admin (local only): user `admin` / password `admin` at `http://127.0.0.1:8080/wp-admin/`

### Build / lint / test

| Task | Command |
|------|---------|
| **Build CSS** (matches CI) | `npx --yes sass style.scss:style.css --style=compressed --no-source-map` |
| **Watch CSS** (optional) | `npx --yes sass --watch style.scss:style.css` |
| **Lint** | Not configured in repo |
| **Tests** | Not configured in repo |

### Useful smoke checks

```bash
curl -sI http://127.0.0.1:8080/ | head -1          # expect HTTP/1.1 200
curl -s http://127.0.0.1:8080/books/ | grep -q 'books-menu'
curl -s 'http://127.0.0.1:8080/wp-json/hypatia/v1/search?q=pragmatic'
```

### Gotchas

- Rebuilding CSS does not require restarting `wp server`; PHP templates pick up changes immediately.
- Full books UX on production depends on **ACF** and real content; the mu-plugin only approximates that locally.
- `page-home.php` expects upload images under `wp-content/uploads/` for project photos; missing files show broken images but do not fatal.
- Production deploy secrets: `NFSN_USER`, `NFSN_PASSWORD` (GitHub Actions only).
