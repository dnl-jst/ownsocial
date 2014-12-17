# ownsocial

## Currently developed on:

	* nginx 1.4.6
	* PHP 5.5.9 (FastCGI)
	* MySQL 5.5.40

## Prequisites

	* Vagrant (https://www.vagrantup.com)
	* VirtualBox (https://www.virtualbox.org)

## Minimum requirements

	* PHP 5.3.7 (PHP 5.5 recommended)
	* MySQL 5.1

## Installation:

Download latest version:

	as .zip: https://github.com/dnl-jst/ownsocial/archive/0.1.6.zip
	as .tar.gz: https://github.com/dnl-jst/ownsocial/archive/0.1.6.tar.gz

Extract the file and upload the contents to your webspace.

You need to set the root-folder of your webspace to the public-subfolder.

Open the site and you will be guided through the installation process.

## Development:

Clone from git:

	git clone https://github.com/dnl-jst/ownsocial.git

Go to project folder:

	cd ownsocial/

If not installed, install vagrant-hostsupdater plugin:

	vagrant plugin install vagrant-hostsupdater

Fire up vagrant VM:

	vagrant up

Point your browser to:

	http://ownsocial.local/

and you will be redirected to the installer.

Credentials for the local database server are:

	Hostname: localhost
	Username: root
	Password: rootpass
	Database: (choose one, for example "ownsocial")

Chosen database is created automatically if it doesn't exist.

## Contribution

Feel free to contribute to this project. We are at an very early
stage of development but want to get this project to the world
and see it being used and enhanced. Write an issue with an idea
or improvement or send a pull request if you are familiar with
development.