# -*- mode: ruby -*-
# vi: set ft=ruby :

# Vagrantfile API/syntax version. Don't touch unless you know what you're doing!
VAGRANTFILE_API_VERSION = "2"

Vagrant.configure(VAGRANTFILE_API_VERSION) do |config|

  config.vm.box = "ubuntu/trusty64"
  config.vm.provision :shell, path: "vagrant/provision.sh"
  config.vm.hostname = "ownsocial"
  config.vm.network "private_network", ip: "192.168.33.20"
  config.hostsupdater.aliases = ["ownsocial.local"]
  config.vm.synced_folder ".", "/vagrant", {:owner => "www-data", :group => "www-data"}

end
