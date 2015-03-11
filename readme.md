# [Wiki](https://github.com/Stolz/Wiki)

A simple PHP wiki engine.

## Features

- Backend based on [Laravel 5](http://laravel.com) PHP framework. The code has a minimal footprint which makes the application very easy to customize to your needs.
- Frontend based on [Zurb Foundation](http://foundation.zurb.com) CSS framework which gives a clean responsive layout and a mobile-friendly user experience.
- Pages are written in [Markdown](http://en.wikipedia.org/wiki/Markdown) with live preview of the final markup.
- User authentication/registration with one click via Oauth providers (Facebook, GitHub, Google and Twitter).
- Multilanguage support via Gettext.
- Included boilerplate to implement your own custom permissions system based on user roles.

## Caveats

This project is not intended to be a mass distributed real world application but rather to server as a proof-of-concept and showcase of different technologies and concepts I enjoy using ([RESTful architecture](http://en.wikipedia.org/wiki/Representational_state_transfer), [Dependency Injection](http://en.wikipedia.org/wiki/Dependency_injection), [Responsive design](http://en.wikipedia.org/wiki/Responsive_web_design), [SOLID principles](http://en.wikipedia.org/wiki/SOLID_%28object-oriented_design%29), ...). Nevertheless it's being implemented to be 100% usable in real scenarios.

## Install

Via composer

	composer create-project stolz/wiki --prefer-dist --stability=dev

Via git

	git clone https://github.com/Stolz/Wiki.git --depth 1 && cd Wiki && composer install

## License

MIT license. Check the included [LICENSE.txt](https://github.com/Stolz/Wiki/blob/master/LICENSE.txt) file for details.

(c) [Stolz](https://github.com/Stolz).
