pantheon-backup
===============

A set of utility classes to automate interacting with pantheon.

Examples
===============

examples/create_backups.php
An example program that demonstrates how to use this library by loading a config
file and creating a new code, files, and database backup for each environment (dev, live)
from all of the sites in the linked Pantheon account.

examples/get_backups.php
An example program that demonstrates how to use this library by loading a config
file and downloading the most recent code, files, and database backups
from each environment (dev, live) from all of the sites in the linked
Pantheon account.

1. Copy default.config.yml to config.yml and change the default values to
match your Pantheon subscription.

2. To create the backups that will later be retrieved execute the create
backups script.
  php examples/create_backups.php

3. To download the backups created with the create backups script call the
get backups script.
  php examples/get_backups.php
