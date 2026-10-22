# Migration notes

Working notes for moving off Docker + webpack 2 and onto Local + Vite. This
theme (`communitymade`) is a clean copy of `commmade`, which is untouched and
still the active theme. Delete this file once the new theme is live and settled.

---

## Why

The old build could not be installed on a current machine. `node-sass@4.14`
ships prebuilt binaries only up to Node 14 and fails to compile from source on
anything newer, so `npm install` was already a dead end. `babel-core@6`,
`extract-text-webpack-plugin@2`, `clean-webpack-plugin@0.1` and
`css-loader@0.28` are all abandoned.

## What changed

| | `commmade` | `communitymade` |
| --- | --- | --- |
| WordPress runtime | Docker | Local |
| Bundler | webpack 2.4 (2017) | Vite 8 |
| Sass | node-sass 4 (dead) | sass-embedded (Dart Sass) |
| Transpiler | Babel 6, targeting IE9 | none needed, `es2020` |
| Reload | BrowserSync proxy on :4000 | Vite HMR |
| Build entry | `scripts/start.js`, `scripts/build.js` | `vite` / `vite build` |
| Manifest | `dist/assets.json` | `dist/.vite/manifest.json` |
| devDependencies | 15 | 3 |
| Build time | seconds | ~200ms |
| Output | 131 KB CSS / 47 KB JS | 118 KB CSS / 45.7 KB JS |

The CSS and JS got smaller purely from dropping the IE9 target.

### Not carried over from `commmade`

Unreferenced backups and build leftovers: `scripts/`, `.babelrc`, `dev/`,
`partials/original/`, `partials/dev/`, `functions orig/`,
`functions 220726.php`, `headerbackup.php`, `footer with socials.php`,
`src/index_orig.js`, `src/index-orig.js`,
`src/scss/components/_header-search-old.scss`, `package-lock.json`,
`node_modules/`, `dist/`, `.DS_Store`.

All `front-page-*.php` files **were** kept — each declares a `Template Name`
and may be assigned to a live page.

Dropped npm packages, none of them imported anywhere in `src/`: `animate.css`,
`imagesloaded`, `jquery-match-height`, `masonry-layout`, `simple-parallax-js`.
`animate.css` is referenced in `holding.php`, so check that template if you
use it.

### Source changes required by strict ESM

Vite uses real ES modules, which are stricter than webpack's loader:

1. **`src/js/jquery-shim.js` (new).** Replaces webpack's
   `externals: { jquery: 'jQuery' }`. `vite.config.js` aliases the `jquery`
   package to it, so our imports and slick-carousel's internal
   `require('jquery')` both resolve to WordPress's single global jQuery.
   Without this we would ship a second jQuery and slick would attach to the
   wrong one.
2. **`src/index.js`** imported `dropdown` and `menu-toggle` as default exports.
   Neither has a default export — webpack silently gave `undefined`, Rollup
   does not. They are now side-effect imports.
3. **`dropdown.js`, `menu-toggle.js`, `header-search.js`** relied on a global
   `$` and bound handlers at module scope. They now import `$` and wait for
   ready.

### Renamed paths

Six hardcoded `/wp-content/themes/commmade/` URLs in the SCSS were updated to
`/wp-content/themes/communitymade/` — four icon paths in
`_header-search.scss`, two slick font/loader paths in `slick-theme.scss`.
If the folder is ever renamed again, these need updating or the assets 404.

---

## Remaining steps

### 1. Version control

Not initialised — run it yourself so nothing is committed under the wrong
identity:

```bash
cd wp-content/themes/communitymade
git init
git add -A
git commit -m "Community Made theme: clean copy of commmade on a Vite toolchain"
```

`.gitignore` is already in place and excludes `node_modules/`, `dist/` and
`.DS_Store`.

### 2. Set up Local and import the live site

The site is not on WP Engine, so Local can't pull it directly. Use **WP Migrate
Lite** (free) — Local imports the zip it produces.

1. Install Local, create a site (`communitymade`, PHP 8.2+, MySQL 8).
2. On the **live** site, install WP Migrate Lite.
3. Create a **Full Site Export** — it bundles `wp-content` plus a database dump
   into one zip.
4. Drag that zip onto Local's *Import Site* screen. Local handles the URL
   find-and-replace.
5. Copy this theme folder into the new site's `wp-content/themes/`.
6. `npm install && npm run build`, activate the theme, confirm it renders.
7. Add `define( 'WP_ENVIRONMENT_TYPE', 'local' );` to `wp-config.php`.

A large media library makes for a large zip. If it's unmanageable, exclude
uploads from the export and let images 404 locally.

### 3. Deploy

Ships alongside the existing theme, so the old one stays a one-click rollback.

1. `npm run build`
2. Upload the theme folder to `wp-content/themes/communitymade` on the live
   server.
3. **Upload `dist/` too.** It's git-ignored, so a git-based deploy won't
   include it — either upload it separately or build on the server.
4. Activate via Appearance → Themes. Menus and widgets are per-theme in
   WordPress and will need reassigning.
5. If anything is wrong, reactivate `commmade`.

**What must ship:** everything except `node_modules/`. `dist/` is required.
`src/` is *currently* still required — see the first tech debt item.

**Deployment method is still undecided.** Roughly in order of effort: SFTP
upload; rsync over SSH; a git-based deploy with a build step. Worth settling
before the first deploy.

---

## Tech debt

Not blocking. Roughly in priority order.

**`src/` has to ship to production.**
`src/scss/vendor/slick1.8/slick/slick-theme.scss` hardcodes absolute font paths:

```scss
$slick-font-path: "/wp-content/themes/communitymade/src/scss/vendor/slick1.8/slick/fonts/";
```

So the source tree must be deployed for slick's arrow font to resolve. Making
these relative would let Vite hash and bundle the fonts, and `src/` could stop
shipping. Low risk — the carousel runs with `arrows: false`.

**Assets referenced from other sites.** The SCSS pulls images from four
unrelated themes:

- `super.essentialmedia.com.au/.../superconsumers/images/quote-blue.svg` (and `quote-rt-blue.svg`)
- `coalimpactsindex.com.au/.../coaltracker/images/icon-email.svg`
- `/wp-content/themes/superback/images/breakout-corner.png` — a local path to a
  theme that isn't installed, so it 404s
- `/wp-content/themes/lifestart/images/iconSearch-pur.svg` (and `-alt-1`)

The cross-domain ones are third-party requests on every page load; the local
ones are broken. Both hurt Lighthouse.

**Bootstrap loaded three ways.** CDN `bootstrap.bundle.min.js` 4.6 in
`functions.php`; `bootstrap-grid.css` and `bootstrap-reboot.css` imported into
the SCSS bundle; and an unused local copy in `_bootstrap/`. Pick one.

**Sass deprecations.** `vite.config.js` silences `import`, `slash-div`,
`global-builtin` and `if-function`. Dart Sass 2.0 removes `@import` outright,
so `src/style.scss` will need converting to `@use`/`@forward`. Mostly
mechanical.

**Legacy `css/` and `js/` folders.** 30+ loose scripts including three
different jQuery versions (1.3.2, 1.9.1, plus migrate) and a `css/` folder with
`ie8.css` and `normalize.css`. Only `jquery.scrollTo.js` and `scroll.js` are
enqueued. The rest is dead weight in the deploy — worth auditing before the
theme ships.

---

## Lighthouse backlog

To tackle once the site renders correctly in Local. Ordered by expected impact.

**1. Render-blocking third-party JS.** `functions.php` loads five external
scripts — Font Awesome kit, jQuery (Google), Popper (cdnjs), Bootstrap
(jsDelivr), AOS (jsDelivr) — from four different origins. Each costs a DNS
lookup, TCP connection and TLS handshake before a byte arrives. Self-hosting
them through the Vite bundle collapses that to zero extra connections and lets
them be hashed and cached. Likely the single biggest win.

**2. Font Awesome kit script.** The kit loader injects CSS at runtime, which
blocks render and causes icon reflow. If only a handful of icons are used,
inlining them as SVG removes the dependency entirely.

**3. Unused CSS.** 118 KB ships on every page, including the full Bootstrap
grid and reboot, all of slick, and AOS. Bootstrap grid alone is a large share.

**4. Images.** `images/` holds 60+ files. Check for oversized dimensions,
missing `width`/`height` (causes layout shift), and no WebP/AVIF. Vite can
process images referenced from SCSS once the absolute paths above go relative.

**5. `screenshot.png` is 601 KB.** Not served to visitors, but it bloats every
deploy.

**6. Fonts.** `webfonts/` — check for `font-display: swap` and preload the one
or two faces used above the fold.

**7. jQuery itself.** The three components mostly toggle classes and call
`slideDown`. Dropping jQuery is realistic but would also mean replacing
slick-carousel and Bootstrap's JS. A separate project, not part of this
migration.
