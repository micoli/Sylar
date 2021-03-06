# -*- mode: ruby -*-
# vi: set ft=ruby :
#@ansible_home = "/home/vagrant/.ansible"

Vagrant.configure("2") do |config|
    config.vm.define "master" do |subconfig|
        subconfig.vm.box = "bento/ubuntu-18.04"
        #subconfig.vm.box = "aalmenar/debian-10"

        subconfig.vm.network "private_network", ip: "192.168.99.20"
        subconfig.vm.network "forwarded_port", guest: 8080, host: 8081
        subconfig.vm.network "forwarded_port", guest: 3306, host: 20306

        authorized_keys = `cat ~/.ssh/id_rsa.pub`
        subconfig.vm.provision :shell, :inline => "echo '#{authorized_keys}' >> /home/vagrant/.ssh/authorized_keys"
#
# #         subconfig.vm.provision 'install ansible', type: :shell, inline: <<~'EOM'
# #             sudo  echo "deb http://ppa.launchpad.net/ansible/ansible/ubuntu trusty main" > /etc/apt/sources.list.d/ansible.list
# #             sudo apt-key adv --keyserver keyserver.ubuntu.com --recv-keys 93C4A3FD7BB9C367
# #             sudo apt-get update
# #             sudo apt-get install -y ansible
# #             mkdir /etc/ansible/roles -p
# #             chmod o+w /etc/ansible/roles
# #         EOM
# #
        subconfig.vm.provision "ansible_local" do |ansible|
            ansible.raw_arguments = Shellwords.shellsplit(ENV["ANSIBLE_ARGS"]) if ENV["ANSIBLE_ARGS"]
            ansible.galaxy_role_file = 'provisioning/requirements.yml'
            ansible.playbook = "provisioning/vagrant-master.yml"
        end
    end

    config.vm.define "slave" do |subconfig|
        subconfig.vm.box = "bento/ubuntu-18.04"

        subconfig.vm.synced_folder "./", "/app"

        subconfig.vm.network "private_network", ip: "192.168.99.21"
        subconfig.vm.network "forwarded_port", guest: 8080, host: 8082
        subconfig.vm.network "forwarded_port", guest: 3306, host: 21306

#         authorized_keys = `cat ~/.ssh/id_rsa.pub`
#         subconfig.vm.provision :shell, :inline => "echo '#{authorized_keys}' >> /home/vagrant/.ssh/authorized_keys"
#
#         subconfig.vm.provision 'install ansible', type: :shell, inline: <<~'EOM'
#             sudo  echo "deb http://ppa.launchpad.net/ansible/ansible/ubuntu trusty main" > /etc/apt/sources.list.d/ansible.list
#             sudo apt-key adv --keyserver keyserver.ubuntu.com --recv-keys 93C4A3FD7BB9C367
#             sudo apt-get update
#             sudo apt-get install -y ansible
#             mkdir /etc/ansible/roles -p
#             chmod o+w /etc/ansible/roles
#         EOM
#
        subconfig.vm.provision "ansible_local" do |ansible|
            ansible.raw_arguments = Shellwords.shellsplit(ENV["ANSIBLE_ARGS"]) if ENV["ANSIBLE_ARGS"]
            ansible.galaxy_role_file = 'provisioning/requirements.yml'
            ansible.playbook = "provisioning/vagrant-slave.yml"
#             ansible.verbose = 'vvvv'
        end

        subconfig.vm.provider :virtualbox do |vb|
            vb.memory = 2048

            for vol in ['1', '2'] do
                diskFilename = File.absolute_path("./.vboxhdd/slave-disk#{vol}.vdi")
                unless File.exist?(diskFilename)
                    vb.customize [
                        'createhd',
                        '--filename', diskFilename,
                        '--size', 50 * 1024
                    ]
                end
                vb.customize [
                    'storageattach', :id,
                    '--storagectl', 'SATA Controller',
                    '--port', vol,
                    '--device', 0,
                    '--type', 'hdd',
                    '--medium', diskFilename
                ]
            end
        end
    end
end
