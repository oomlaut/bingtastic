# It's Bingtastic!

Automation of daily searches to earn the maximum Bing Rewards points, integrated as an optional Facebook app.

[![endorse](https://api.coderwall.com/oomlaut/endorsecount.png)](https://coderwall.com/oomlaut)

## Web Properties

* [Heroku](http://bingtastic.herokuapp.com)
* [Facebook](https://apps.facebook.com/1404888123068033/)

## API

[Documentation provided on Apiary](http://docs.bingtastic.apiary.io/)

### Colophon

* [php](http://php.net)
* [Heroku](http://heroku.com)
* [Mustache](http://mustache.github.io/)
* [Bower](https://github.com/bower/bower)
* [jQuery](http://jquery.com/)
* [jQuery UI](http://jqueryui.com/)
* [LESS](http://lesscss.org/)
* [Twitter Bootstrap](http://getbootstrap.com/)
* [Font Awesome](http://fortawesome.github.io/Font-Awesome/)
* [WeblySleek](http://www.dafont.com/weblysleek-ui.font)
* [Google Fonts](https://www.google.com/fonts)
* [Grunt](http://gruntjs.com/)

# php-getting-started

A barebones PHP app that makes use of the [Silex](http://silex.sensiolabs.org/) web framework, which can easily be deployed to Heroku.

This application support the [Getting Started with PHP on Heroku](https://devcenter.heroku.com/articles/getting-started-with-php) article - check it out.

## Running Locally

Make sure you have PHP, Apache and Composer installed.  Also, install the [Heroku Toolbelt](https://toolbelt.heroku.com/).

```sh
$ git clone git@github.com:heroku/php-getting-started.git # or clone your own fork
$ cd php-getting-started
$ composer update
$ foreman start web
```

Your app should now be running on [localhost:5000](http://localhost:5000/).

## Deploying to Heroku

```
$ heroku create
$ git push heroku master
$ heroku open
```

## Documentation

For more information about using PHP on Heroku, see these Dev Center articles:

- [PHP on Heroku](https://devcenter.heroku.com/categories/php)
