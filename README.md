## Prerequisites

* [Virtualbox](https://www.virtualbox.org/wiki/Downloads)
* [Vagrant](http://downloads.vagrantup.com/)
* [Composer](http://getcomposer.org/download/)
* git
* [librarian-puppet](http://librarian-puppet.com/)

## Getting started

1. git clone
2. composer install
3. add '192.168.33.10 your.domain.dev' to /etc/hosts
4. cd puppet && librarian-puppet install
5. vagrant up
6. Browse to http://your.domain.dev/app_dev.php/
