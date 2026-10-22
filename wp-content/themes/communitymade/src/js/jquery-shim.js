/**
 * jQuery shim.
 *
 * WordPress already loads one jQuery for the whole page (see functions.php).
 * Bundling a second copy would give us two instances that do not share
 * plugins or event handlers — slick would register on one and our code would
 * call the other.
 *
 * vite.config.js aliases the `jquery` package to this file, so both our
 * `import $ from 'jquery'` and slick-carousel's internal `require('jquery')`
 * resolve to the single global instance.
 *
 * This replaces the old webpack `externals: { jquery: 'jQuery' }` config.
 */

const jQuery = window.jQuery;

if (!jQuery) {
  throw new Error(
    'jQuery was not found on window. The theme bundle expects WordPress to ' +
      'enqueue jQuery before it. Check the jquery dependency in ' +
      'theme_enqueue_assets() in functions.php.'
  );
}

export default jQuery;
export { jQuery };
