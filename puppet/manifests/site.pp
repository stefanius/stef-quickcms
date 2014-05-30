
exec { '/usr/bin/apt-get update':
}

package {['git', 'acl', 'curl', 'wget', 'htop']:
  ensure => 'present',
}

package {['consolekit', 'landscape-client', 'landscape-common']:
  ensure => 'absent',
}

class { 'mysql': }
class { 'mysql::server': }
class { 'mysql::php': }

mysql::db { 'symfony':
  user     => 'symfony',
  password => '',
  host     => 'localhost',
  grant    => ['all'],
}

class { 'apache': }

apache::vhost { 'quickcms.dev':
  docroot  => '/vagrant/web',
  serveraliases => ["quickcms.dev"],
  directory_allow_override => 'All',
  template => 'symfony-bootstrap/vhost.conf.erb',
}

apache::module { 'php5': }
apache::module { 'rewrite': }

class { 'php': }

php::module {'gd':
  require => Exec['/usr/bin/apt-get update'],
}
php::module {'json': }

class { 'composer':
  command_name => 'composer',
  target_dir   => '/usr/local/bin',
  require      => Class['php'],
}

exec {'/bin/sed -i \'s/^;date.timezone =$/date.timezone = "UTC"/g\' /etc/php5/apache2/php.ini':
  require => [Package['php5'], Package['apache2']],
  notify => Service['apache2'],
}
