# ownsocial

## Currently developed on:

	* nginx 1.4.6
	* PHP 5.5.9 (FastCGI)
	* MySQL 5.5.40

## Installation:

Clone from git:
	git clone https://github.com/dnl-jst/ownsocial.git

Go to project folder:
	cd ownsocial/

Get composer dependencies:
	composer install

Get bower dependencies:
	bower install

If not installed, install vagrant-hostsupdater plugin:
	vagrant plugin install vagrant-hostsupdater

Fire up vagrant VM:
	vagrant up

Point your browser to:
	http://ownsocial.local/

and you will be redirected to the installer.

Credentials for the local database server are:
	Username: root
	Password: rootpass

Chosen database is created automatically if it doesn't exist.

## Contribution

Feel free to contribute to this project. We are at an very early
stage of development but want to get this project to the world
and see it being used and enhanced. Write an issue with an idea
or improvement or send a pull request if you are familiar with
development.