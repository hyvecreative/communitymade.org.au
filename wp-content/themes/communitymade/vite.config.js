import { defineConfig } from 'vite';
import { resolve } from 'node:path';
import { writeFileSync, rmSync } from 'node:fs';
import fullReload from 'vite-plugin-full-reload';

/**
 * Vite config for the Community Made WordPress theme.
 *
 * Replaces the previous webpack 2 / node-sass / BrowserSync setup.
 *
 *   npm run dev    → dev server on :5173 with HMR. Writes dist/hot so
 *                    functions.php knows to load assets from Vite.
 *   npm run build  → hashed production build in dist/ + dist/.vite/manifest.json
 *
 * The theme is served by WordPress (Local/Nginx/PHP), NOT by Vite. Vite only
 * serves the JS/CSS during development; WordPress renders every page.
 */

const THEME_DIR = import.meta.dirname;
const OUT_DIR = 'dist';
const HOT_FILE = resolve(THEME_DIR, OUT_DIR, 'hot');

const DEV_HOST = 'localhost';
const DEV_PORT = 5173;
const DEV_ORIGIN = `http://${DEV_HOST}:${DEV_PORT}`;

/**
 * Writes dist/hot while the dev server is running and removes it on exit.
 * functions.php checks for this file to decide dev vs production asset loading.
 */
function wordpressHotFile() {
  return {
    name: 'wordpress-hot-file',
    apply: 'serve',
    configureServer(server) {
      const clean = () => {
        try {
          rmSync(HOT_FILE, { force: true });
        } catch {
          /* already gone */
        }
      };

      server.httpServer?.once('listening', () => {
        writeFileSync(HOT_FILE, DEV_ORIGIN);
        server.config.logger.info(
          `\n  WordPress is loading assets from ${DEV_ORIGIN}\n` +
            `  Stop this server (or delete dist/hot) to fall back to the built files.\n`
        );
      });

      // Remove the marker however the process ends, so a stale dist/hot
      // never leaves the site pointing at a dead dev server.
      process.on('exit', clean);
      process.on('SIGINT', () => {
        clean();
        process.exit();
      });
      process.on('SIGTERM', () => {
        clean();
        process.exit();
      });
      server.httpServer?.once('close', clean);
    },
  };
}

export default defineConfig(({ command }) => ({
  // Dev is served from the Vite origin; the production build uses relative
  // URLs so hashed fonts/images referenced from CSS resolve correctly
  // under /wp-content/themes/communitymade/dist/.
  base: command === 'serve' ? '/' : './',

  root: THEME_DIR,

  plugins: [
    wordpressHotFile(),
    // Reload the browser when a template changes. SCSS and JS use HMR
    // and do not need this.
    fullReload(
      [
        '*.php',
        'template-parts/**/*.php',
        'partials/**/*.php',
        'includes/**/*.php',
      ],
      { root: THEME_DIR, delay: 100 }
    ),
  ],

  resolve: {
    alias: {
      // WordPress loads a single jQuery for the whole page. Rather than
      // bundling a second copy, point every `import $ from 'jquery'`
      // (ours and slick-carousel's) at the global instance.
      jquery: resolve(THEME_DIR, 'src/js/jquery-shim.js'),
    },
  },

  css: {
    preprocessorOptions: {
      scss: {
        // Vendor SCSS (slick, include-media) still uses legacy @import,
        // slash division and the old if() form. Silence those so real
        // warnings stay visible. See MIGRATION.md for the cleanup owed here.
        quietDeps: true,
        silenceDeprecations: [
          'import',
          'slash-div',
          'global-builtin',
          'if-function',
        ],
      },
    },
  },

  server: {
    host: DEV_HOST,
    port: DEV_PORT,
    strictPort: true,
    // WordPress runs on a different origin (e.g. https://communitymade.local),
    // so the dev server must allow cross-origin asset requests from it.
    cors: true,
    origin: DEV_ORIGIN,
  },

  build: {
    outDir: OUT_DIR,
    emptyOutDir: true,
    manifest: true,
    // Modern browsers only. The old Babel config targeted IE9, which cost
    // bundle size and transpilation for a browser dead since 2016.
    target: 'es2020',
    sourcemap: true,
    rollupOptions: {
      input: resolve(THEME_DIR, 'src/index.js'),
    },
  },
}));
