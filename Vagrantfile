# -*- mode: ruby -*-
# vi: set ft=ruby :

# Vagrantfile API/syntax version. Don't touch unless you know what you're doing!
VAGRANTFILE_API_VERSION = "2"

Vagrant.configure(VAGRANTFILE_API_VERSION) do |config|

  config.vm.define "debian", autostart: false do |debian|
	  debian.vm.box = "chef/debian-7.4"
	  debian.vm.provision :shell, path: "vagrant/provision.sh"
	  debian.vm.hostname = "ownsocial-debian"
	  debian.vm.network "private_network", ip: "192.168.35.10"
	  debian.hostsupdater.aliases = ["debian.ownsocial.local"]
	  debian.vm.synced_folder ".", "/vagrant", {:owner => "www-data", :group => "www-data"}
  end

  config.vm.define "ubuntu", primary: true do |ubuntu|
  	  ubuntu.vm.box = "ubuntu/trusty64"
  	  ubuntu.vm.provision :shell, path: "vagrant/provision.sh"
  	  ubuntu.vm.hostname = "ownsocial-ubuntu"
  	  ubuntu.vm.network "private_network", ip: "192.168.35.20"
  	  ubuntu.hostsupdater.aliases = ["ownsocial.local", "ubuntu.ownsocial.local"]
  	  ubuntu.vm.synced_folder ".", "/vagrant", {:owner => "www-data", :group => "www-data"}
    end

end
