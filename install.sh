#!/bin/bash
WWW_USER="www-data"
WWW_DIR="/var/www/bitcoinexchange-final"
UID_CURRENT_USER=$(id -u)
CURRENT_USER=$USER
CURRENT_DIR=$HOME
mkdir configs_coins_files
cp $CURRENT_DIR/.karma/karma.conf configs_coins_files
cp $CURRENT_DIR/.bitcoin/bitcoin.conf configs_coins_files
cp $CURRENT_DIR/.dogecoin/dogecoin.conf configs_coins_files
cp $CURRENT_DIR/.litecoin/litecoin.conf configs_coins_files
cp $CURRENT_DIR/.bitcrystal_v20/bitcrystal.conf configs_coins_files
cp $CURRENT_DIR/.pandacoin/pandacoin.conf configs_coins_files
cp $CURRENT_DIR/.bitcrystalx/bitcrystalx.conf configs_coins_files
cp $CURRENT_DIR/.bitcrystalrare/bitcrystalrare.conf configs_coins_files
chown $WWW_USER:$WWW_USER $WWW_DIR/configs_coins_files -R
chmod 755 $WWW_DIR/configs_coins_files -R
