@echo off
set WWW_DIR=C:\xampp\htdocs\bitcoinexchange-final
cd %WWW_DIR%
mkdir config_coins_files
copy /b %appdata%\BitCrystal_V20\bitcrystal.conf config_coins_files/bitcrystal.conf
copy /b %appdata%\BitCrystalRare\bitcrystalrare.conf config_coins_files/bitcrystalrare.conf
copy /b %appdata%\BitCrystalX_V20\bitcrystalx.conf config_coins_files/bitcrystalx.conf
copy /b %appdata%\Bitcoin\bitcoin.conf config_coins_files/bitcoin.conf
copy /b %appdata%\Litecoin\litecoin.conf config_coins_files/litecoin.conf
copy /b %appdata%\Dogecoin\dogecoin.conf config_coins_files/dogecoin.conf
copy /b %appdata%\Pandacoin\pandacoin.conf config_coins_files/pandacoin.conf
copy /b %appdata%\Karma\karma.conf config_coins_files/karma.conf
copy /b %appdata%\Bitquark\bitquark.conf config_coins_files/bitquark.conf
