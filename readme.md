# Wittr PHP API

## What is it?

A simple API used to power the Wittr App.

## Requirements

You need to have a web server running:
 - Webserver
 - MySQL
 - PHP

### If using Nginx/Lighttpd/IIS

 The project is ready for use with Apache via the routing rules in `.htaccess`, if you are using, Nginx, Lighttpd or IIS, please see the server config details of the following Fat Free Framework document : http://fatfreeframework.com/routing-engine#DynamicWebSites

## Installation

1. Create a new MySQL database and use the provided `wittr.sql` file to populate it.
2. Create a user with SELECT/INSERT/UPDATE/DELETE credentials
3. Copy `htdocs/settings.example.php` to `htdocs/settings.php` and populate with the required details
4. Configure your web server to point to `htdocs/` as the document root of the project.

## With thanks to

 - Fat Free Framework - http://fatfreeframework.com/
 - Twitter Bootstrap 3 - http://getbootstrap.com/
 - Google Web Fonts - https://www.google.com/fonts/
 - JQuery - http://jquery.com/

## Hello to

- Jason Isaacs

## Please note


```
 _    _  _  _    _           _                      _    _      _
| |  | |(_)| |  | |         (_)                    | |  | |    (_)
| |  | | _ | |_ | |_  _ __   _  ___   _ __    ___  | |_ | |__   _  _ __    __ _
| |/\| || || __|| __|| '__| | |/ __| | '_ \  / _ \ | __|| '_ \ | || '_ \  / _` |
\  /\  /| || |_ | |_ | |    | |\__ \ | | | || (_) || |_ | | | || || | | || (_| |
 \/  \/ |_| \__| \__||_|    |_||___/ |_| |_| \___/  \__||_| |_||_||_| |_| \__, |
 _                _                    _  _    _       _    _              __/ |
| |              | |                  (_)| |  | |     | |  | |            |___/
| |_   ___     __| |  ___   __      __ _ | |_ | |__   | |_ | |__    ___
| __| / _ \   / _` | / _ \  \ \ /\ / /| || __|| '_ \  | __|| '_ \  / _ \
| |_ | (_) | | (_| || (_) |  \ V  V / | || |_ | | | | | |_ | | | ||  __/
 \__| \___/   \__,_| \___/    \_/\_/  |_| \__||_| |_|  \__||_| |_| \___|
______ ______  _____  _
| ___ \| ___ \/  __ \| |
| |_/ /| |_/ /| /  \/| |
| ___ \| ___ \| |    | |
| |_/ /| |_/ /| \__/\|_|
\____/ \____/  \____/(_)
```
