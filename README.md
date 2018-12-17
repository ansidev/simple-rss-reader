# PHP Developer assignment

## Task

Your task is to create a PHP application that is a feeds reader. The app can read feed from multiple feeds and store them to database. Sample feeds http://www.feedforall.com/sample-feeds.htm.

## Requirements
- The application must be developed by using a php framework and follow coding standard of that framework.
- As a developer, I want to run a command which help me to setup database easily with one run.
- As a developer, I want to run a command which accepts the feed urls (separated by comma) as argument to grab items from given urls. Duplicate items are accepted.
- As a developer, I want to see output of the command not only in shell but also in pre-defined log file. The log file should be defined as a parameter of the application.
- As a user, I want to see the list of items which were grabbed by running the command line. I also should see the pagination if there are more than one page. The page size is up to you.
- As a user, I want to filter items by category name on list of items.
- As a user, I want to create new item manually
- As a user, I want to update/delete an item

## How to do
1. Fork this repository
2. Start coding
3. Use gitflow to manage branches on your repository
4. Open a pull request to this repository after done

## Output

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