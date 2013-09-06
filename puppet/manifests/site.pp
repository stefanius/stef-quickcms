
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

apache::vhost { 'your.domain.com':
  docroot  => '/vagrant/web',
  serveraliases => ["your.domain.dev"],
}

apache::module { 'php5': }
apache::module { 'rewrite': }

class { 'php': }

php::module {'gd':
  require => Exec['/usr/bin/apt-get update'],
}

class { 'composer':
  command_name => 'composer',
  target_dir   => '/usr/local/bin',
  require      => Class['php'],
}
