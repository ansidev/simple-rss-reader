# Simple RSS Reader

## Manual

- App was built on top of Laravel framework.
- First, run `composer install` and `yarn install` to install dependencies.
- Setup database: `php artisan migrate --seed`.
- Grab the feed: `php artisan feed {urls}`.
- Log file for feed job was located at: `./storage/feeds/logs/feed.log`.
- You need to run `yarn dev` or `yarn watch` for compiling css and js (for development) or `yarn prod` (for production).
- Default login account:

    - Username: johndoe@example.com
    - Password: secret

- Run `php artisan serve` to start server at `http://localhost:8000/`.
