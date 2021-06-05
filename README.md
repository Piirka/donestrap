# DoneStrap WordPress Bootstrap 5 Theme Framework with multilevel dropdown support based on Understrap

## What's new

- Bootstrap 5
- Multilevel dropdown menu (Megamenu example under development)
- Colors which are defined in SCSS are available also in Guternberg as text and background color
- Idea behing Gutenberg. 1. Design a block in Guternberg using Bootstrap classes 2. Copy editor code and save it as block pattern for content creators. Example `inc/block-patterns.php`
- Webpack for compiling: Removes also unnecessary css
- Bootstrap 5 JS and SCSS are loaded module by modyle so you can uncomment modules what you don´t need to make compiled CSS smaller. See SCSS: `scss/theme.scss` JS: `webpack.mix.js`

## Developing Webpack

### Installing Dependencies
- Make sure you have installed Node.js and Browser-Sync (optional) on your computer globally
- Then open your terminal and browse to the location of your UnderStrap copy
- Run: `$ npm install`
- Run Webpack: `$ npm run prod`

## Page Templates
UnderStrap includes several different page template files: (1) blank template, (2) empty template, and (3) full width template.

### Blank Template

The `blank.php` template is useful when working with various page builders and can be used as a starting blank canvas.

### Empty Template

The `empty.php` template displays a header and a footer only. A good starting point for landing pages.

### Full Width Template

The `fullwidthpage.php` template has full width layout without a sidebar.

## Footnotes

Licenses & Credits
=
- Understrap: https://understrap.com/ | https://github.com/understrap/understrap/blob/master/LICENSE.md (MIT)
- SmartMenus: https://www.smartmenus.org/ | https://github.com/vadikom/smartmenus/blob/master/LICENSE-MIT (MIT)
- Bootstrap: http://getbootstrap.com | https://github.com/twbs/bootstrap/blob/master/LICENSE (MIT)
- WP Bootstrap Navwalker by Edward McIntyre & William Patton: https://github.com/wp-bootstrap/wp-bootstrap-navwalker (GNU GPLv3)
