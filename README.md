# Composer for DirectAdmin
Your service provider may not grant SSH access for you because of security reasons. You cannot install Composer by yourself or even running shell command. With Composer for DirectAdmin, you can use Composer in an easy and safe way without CLI.

## Getting started
### Install via Command Line
```sh
cd /usr/local/directadmin/plugins
wget https://github.com/Marco129/DirectAdmin-Composer/archive/master.zip
unzip master.zip
mv DirectAdmin-Composer-master directadmin-composer
rm -f master.zip
sh directadmin-composer/scripts/install.sh
```

## Contributing
If you'd like to contribute, feel free to submit a pull request!

## License
Composer for DirectAdmin is released under the MIT License.
