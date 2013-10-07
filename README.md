Symfony-boostrap is a bootstrap repository to quickly start with a clean symfony-standard 
checkout (without the demo stuff) and running on vagrant/puppet setup.

## Prerequisites

* [Virtualbox](https://www.virtualbox.org/wiki/Downloads)
* [Vagrant](http://downloads.vagrantup.com/)
* [Composer](http://getcomposer.org/download/)
* git
* [puppet](http://docs.puppetlabs.com/guides/installation.html#install-puppet-1)
* [librarian-puppet](http://librarian-puppet.com/)

## Getting started

1. Run `git clone git@github.com:fieg/symfony-bootstrap.git <your-project-dirname>`
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

### Create your first bundle

* Run `php app/console generate:bundle`

### Setup the database

A database is created and configured. To get started:

* Create an entity: `php app/console doctrine:generate:entity`
* Update the schema: `doctrine:schema:update --force`

### Change git remote

To start committing your changes to your own repository:

* Create a new repository
* Run `git remote set-url origin git://new.url.here`
