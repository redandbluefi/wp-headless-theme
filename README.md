# Theme for headless WordPress by redandblue

This theme removes everything visible from the WordPress and sets up
some good practices and conventions for the REST API, and overall as well.

## Getting started

Add the following lines to your `composer.json`

Under 'repositories', add:

```json
{
  "type": "git",
  "url": "https://github.com/redandbluefi/wp-headless-theme.git"
}
```

Under 'require', add:

```json
  "redandbluefi/wp-headless-theme": "dev-master",
```

## Theme requirements

This theme requires the following plugins to work properly:

* Advanced Custom Fields pro
* ACF to REST API
* Polylang

Next, you'll also need to make some configurations on the WordPress admin.

* Setup Permalinks: Settings -> Permalinks -> select e.g. "Day and name"
* Settings -> General: Change 'Site Address' to your Frontend address
* Settings -> Reading: Your homepage displays -> A static page, and select a page

## Credits

Inspiration drawn from https://github.com/postlight/headless-wp-starter, big thanks 🙏
