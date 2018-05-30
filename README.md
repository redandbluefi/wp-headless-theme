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

Also, make sure on admin you've configured your Permalinks properly, so the
REST API is functional. Check: > Permalinks > select e.g. "Day and name"

## Credits

Based on https://github.com/postlight/headless-wp-starter, big thanks 🙏
