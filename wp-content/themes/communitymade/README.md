# Community Made theme

WordPress theme for communitymade.org.au. Successor to the `commmade` theme,
which stays in place untouched as a rollback.

**Stack:** [Local](https://localwp.com) runs WordPress (PHP, MySQL, Nginx).
[Vite](https://vite.dev) builds the JS and SCSS. No Docker, no webpack, no
BrowserSync.

## Requirements

- **Node 22** — `nvm use` picks it up from `.nvmrc`
- **Local** — runs the WordPress side

## First-time setup

```bash
cd wp-content/themes/communitymade
nvm use          # or: nvm install 22
npm install
npm run build    # produces dist/ so the site renders before you start dev
```

Then add this to the site's `wp-config.php`, above the
`/* That's all, stop editing! */` line:

```php
define( 'WP_ENVIRONMENT_TYPE', 'local' );
```

This is what tells the theme it may talk to the Vite dev server. Without it,
the site always uses the built files in `dist/` — correct for production, but
you'd get no hot reloading.

## Daily workflow

Start the site in Local, then:

```bash
npm run dev
```

Open the site at its Local URL (e.g. `https://communitymade.local`) — **not**
at `localhost:5173`. Vite only serves the assets; WordPress still renders every
page.

| Edit | What happens |
| --- | --- |
| `src/scss/**` | Styles swap in place. No reload, scroll position kept. |
| `src/js/**` | Module reloads. |
| `*.php`, `template-parts/**`, `partials/**` | Full page reload. |

Ctrl-C to stop. The site falls straight back to the last `npm run build` output.

## Building for production

```bash
npm run build
```

Writes hashed files to `dist/` plus `dist/.vite/manifest.json`.

**Cachebusting is automatic.** The hash comes from the file contents, so the
URL changes whenever the file does and never otherwise. `functions.php` reads
the manifest and enqueues with `null` as the version — no `?ver=` strings to
bump, and assets can be served with long cache headers.

`dist/` is generated and git-ignored. Never edit it, never commit it.

## How assets get onto the page

`includes/vite.php` picks one of two modes per request:

- **`dist/hot` exists and the dev server responds** → load from Vite, with HMR
- **otherwise** → read `dist/.vite/manifest.json`, enqueue the hashed files

The dev branch only runs when `WP_ENVIRONMENT_TYPE` is `local` (or `WP_DEBUG`
is on), so a `dist/hot` accidentally deployed to production cannot take the
live site down.

## Source layout

```
src/
  index.js              entry point — imports the SCSS and boots components
  style.scss            SCSS manifest, imports everything below
  js/
    jquery-shim.js      maps the `jquery` package to WordPress's global jQuery
    components/         one file per behaviour
  scss/
    _base.scss
    variables/          colors, fonts, site specs
    mixins/
    components/
    vendor/
```

Anything not reachable from `src/style.scss` or `src/index.js` is never
compiled.

### jQuery

WordPress loads one jQuery for the whole page (from a CDN, see
`functions.php`). `src/js/jquery-shim.js` points the `jquery` package at that
global instance, so we never ship a second copy — and so slick-carousel
registers on the same jQuery our code calls.

Import it normally; the alias in `vite.config.js` handles the rest:

```js
import $ from 'jquery';
```

## Troubleshooting

**Site loads unstyled.** No build exists yet. Run `npm run build`.

**Site still points at a dead dev server.** Delete `dist/hot`. Shouldn't
happen — the dev server removes it on exit and `includes/vite.php` verifies
the server is reachable — but a hard crash can leave it behind.

**`Error: jQuery was not found on window`.** The bundle loaded before jQuery.
Check the `jquery` dependency is still present in `theme_enqueue_assets()`.

**`Port 5173 is already in use`.** Another Vite server is running —
`lsof -i :5173`.

**Icons or slick fonts 404.** Some SCSS uses absolute paths containing the
theme folder name. If the folder is ever renamed, update
`src/scss/components/_header-search.scss` and
`src/scss/vendor/slick1.8/slick/slick-theme.scss`.
