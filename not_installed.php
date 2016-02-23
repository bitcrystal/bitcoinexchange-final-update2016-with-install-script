<?php
//mysql settings
$database_host = 'localhost';         // the server the database is located
$database_username = 'bitcoinexchange';      // the username to access the database
$database_password = 'fickdiekackwurstfickenscheisse3';      // the password to access the database
$database_name = 'bitcoinexchange';  // the name of the database being used

//coins settings
$init_feebee_account=false; // init feebee account is not important for you at the momment later you get the details!
$used_coins=array(); // here set your trade coins
$used_coins[0]=array("Dogecoin","Bitcrystal","Litecoin");  // 	BITCRY/DOGE 	BITCRY/LTC
$used_coins[1]=array("BitQuark","Bitcrystal","Karmacoin"); // 	BTCRY/BTQ 	BTCRY/KARMA
$used_coins[2]=array("Bitcoin","Bitcrystal","Pandacoin");  // 	BITCRY/BTC 	BTCRY/PANDA
$used_coins_length=count($used_coins);

//install settings
$enable_install_script=true; // set this to false if you have the exchange successfully installed!
$install_coins_from_configs=true; // generate the needed coins templates in my_coins from your wallet configs!
$install_coins_database=true; // setup mysql and execute all needed querys for you!
$install_my_trade_coins=true; // install the coins the you have setted in coins settings
$show_debug_messages=true; // show all error and successfull messages
?>
