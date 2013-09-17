## Prerequisites

* [Virtualbox](https://www.virtualbox.org/wiki/Downloads)
* [Vagrant](http://downloads.vagrantup.com/)
* [Composer](http://getcomposer.org/download/)
* git
* [puppet](http://docs.puppetlabs.com/guides/installation.html#install-puppet-1)
* [librarian-puppet](http://librarian-puppet.com/)

## Getting started

1. Run `git clone`
2. Run `composer install`
3. Add `192.168.33.10 your.domain.dev` to `/etc/hosts`
4. Run `cd puppet && librarian-puppet install`
5. Run `vagrant up`
6. Browse to http://your.domain.dev/app_dev.php/
7. Or `vagrant ssh` and `cd /vagrant`, then type `php app/console`

## What's next?

### Change the domain name

* In `puppet/manifests/site.pp`: change the line with `apache::vhost { 'your.domain.com':`
* Update your hosts file (`/etc/hosts`) with the new domain

### Setup database

A database is created and configured. To get started:

* Create an entity: `php app/console doctrine:generate:entity`
* Update the schema's: `doctrine:schema:update --force`
