# AMSRO theme

## Features
- Webpack
- Live reload via BrowserSync
- SCSS support

## Getting started
To install theme dependancies
```
npm install
```

## Developing Locally
To work on the theme locally, open another window/tab in terminal and run:

```
npm start
```

This will open a browser, watch all files (php, scss, js, etc) and reload the 
browser when you press save. 

## Building for Production
To create an optimized production build, run:

```
npm run build
```

This will minify assets, bundle and uglify javascript, and compile scss to css.
It will also add cachebusting names to then ends of the compiled files, so you
do not need to bump any enqueued asset versions in `functions.php`.

