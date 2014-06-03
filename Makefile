createuser:
	php app/console fos:user:create testuser testuser@stefanius.nl 1234

createadminuser:
	php app/console fos:user:create admin admin@stefanius.nl 1234

install:
    php app/console assetic:dump
    php app/console braincrafted:bootstrap:install
    make createuser
    make createadminuser