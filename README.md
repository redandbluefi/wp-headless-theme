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

# Features / TODOs

* [x] Local / Synchronized JSON for ACF
* [x] CORS headers
* [x] Draft preview
* [x] Permalinks
* [x] Endpoints for main WP features (language-specific)
* [ ] ACF codifier
* [ ] Extendable (e.g. Generic endpoints vs Customer-specific endpoints)
* [ ] Initial data & configuration (e.g. for polylang, generic WP settings, etc.)

# Theme requirements

This theme requires the following plugins to work properly:

* Advanced Custom Fields pro
* ACF to REST API
* Polylang

## Next, you'll also need to make some configurations on the WordPress admin

> TODO We should add a script or code that would do these configurations automatically
> NOTE Some of these also depend on the project's setup

* Setup Permalinks: Settings -> Permalinks -> select custom and use "`/post/%postname%/`"
* Enable all required plugins
* Go to Polylang settings and add languages (fi, en_GB)
* in Polylang settings, go to URL modification and set
  * Uncheck "Hide URL language information..."
  * Select "Remove /language/ in pretty permalinks"
  * Check "The frontpage url contains..."
* Settings -> General: Change 'Site Address' to your Frontend address
* Settings -> Reading: Your homepage displays -> A static page, and select a page

## Create some content

* Add footer content on `Sivuston asetukset` section on admin
* Create navigation structure under `Appearance -> Customize -> Menus`
  * Name the menus `menu` for Finnish, `menu_en` for English
* Create new page for English and Finnish with some content

Finally, see it working:

* http://{your_local_domain}:{local_port}/wp-json/acf/v3/pages
* http://{your_local_domain}:{local_port}/wp-json/bodybuilder/v1/site

## Credits

Inspiration drawn from https://github.com/postlight/headless-wp-starter, big thanks 🙏
