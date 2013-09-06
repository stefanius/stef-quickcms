## Prerequisites

* [Virtualbox](https://www.virtualbox.org/wiki/Downloads)
* [Vagrant](http://downloads.vagrantup.com/)
* [Composer](http://getcomposer.org/download/)
* git
* [puppet](http://docs.puppetlabs.com/guides/installation.html#install-puppet-1)
* [librarian-puppet](http://librarian-puppet.com/)

## Getting started

1. git clone
2. composer install
3. add '192.168.33.10 your.domain.dev' to /etc/hosts
4. cd puppet && librarian-puppet install
5. vagrant up
6. Browse to http://your.domain.dev/app_dev.php/

## What's next?

### Change the domain name

* In `puppet/manifests/site.pp` -> change the line with 'apache::vhost { 'your.domain.com':'
* Update your hosts file (`/etc/hosts`) with the new domain

### Setup database

* doctrine:database:create
* doctrine:schema:update --force
