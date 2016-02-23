<?php
require_once('functions_main.php');
function mytrim($string)
{
	return str_replace("\n","",str_replace("\r","",$string));
} 

function chrtoupper($chr)
{
	$c = ord($chr);
	if($c>=97&&$c<=122)
	{
		$c = $c - 32;
	}
	return chr($c); 
}

function chrtolower($chr)
{
	$c = ord($chr);
	if($c>=65&&$c<=90)
	{
		$c = $c + 32;
	}
}

function mytoupper($string)
{
	$len = strlen($string);
	for($i = 0; $i < $len; $i++)
	{
		$c = ord($string[$i]);
		if($c>=97&&$c<=122)
		{
			$c = $c - 32;
		}
		$string[$i] = chr($c);
	}
}

function mytolower($string)
{
	$len = strlen($string);
	for($i = 0; $i < $len; $i++)
	{
		$c = ord($string[$i]);
		if($c>=65&&$c<=90)
		{
			$c = $c + 32;
		}
		$string[$i] = chr($c);
	}
}

function install()
{
	$files = myscandir('.');
	$files_length = count($files);
	if($files_length<=0)
	{
		return false;
	}
	for($i = 0; $i < $files_length; $i++)
	{
		if($files[$i]=="not_installed.php")
		{
			include('not_installed.php');
			if($enable_install_script==false)
			{
				return false;
			}
			if($install_coins_from_configs==true)
			{
				$configs_coins_files = myscandir('./configs_coins_files/.');
				$configs_coins_files_length = count($configs_coins_files);
				if($configs_coins_files_length == 0)
				{
					if($show_debug_messages==true)
					{
						echo "<br>execute the install.bat(Windows) or install.sh first and then examine that the paths in the shell files are correct with your coins!<br/>";
						echo "<br>For example if your coin is the Canabiscoin then check either the path is available in the install.bat(Windows) or install.sh(Linux) file and otherwise put the correct path for example:!<br/>";
						echo "<br>$CURRENT_DIR=home directory in linux for example /home/john<br/>";
						echo "<br>$CURRENT_DIR/.cannabiscoin/cannabiscoin.conf<br/>";
						echo "<br>/home/.cannabiscoin/cannabiscoin.conf<br/>";
						echo "<br>or in Windows<br/>";
						echo "<br>%appdata%\Cannabiscoin\cannabiscoin.conf</br>";
						echo "<br>If you have setted the paths correctly then please execute the install.bat(Windows) or install.sh(Linux) again";
						echo "<br>And you must execute all you wallets that you want to use otherwise the exchange will not worked!<br/>";
					}
					return false;
				}
				$coin_confi=array();
				for($j = 0; $j < $configs_coins_files_length; $j++)
				{
					$coin_confi[$j]=array();
					$coin_confi[$j]["name"]='doofcoin';
					$coin_confi[$j]["rpcuser"]='myrpcuser';
					$coin_confi[$j]["rpcpassword"]='myrpcpassword';
					$coin_confi[$j]["rpcallowip"]='127.0.0.1';
					$coin_confi[$j]["walletpassphrase"]='';
					$coin_confi[$j]["walletpassphrase_timeout"]='99999999';
					$coin_confi[$j]["rpcport"]='1234';
					$coin_confi[$j]["port"]='1235';
					$coin_confi[$j]["maxconnections"]='80';
					$coin_confi[$j]["gen"]='0';
					$coin_confi[$j]["genproclimit"]='-1';
					$coin_confi[$j]["server"]='1';
					$coin_confi[$j]["daemon"]='1';
					$coin_confi[$j]["listen"]='1';
					$xyz=$configs_coins_files[$j];
					$xyz=str_replace(".conf","",$xyz);
					$coin_confi[$j]["name"]=$xyz;
					$contents = file_get_contents('./configs_coins_files/'.$configs_coins_files[$j]);
					$arr = explode("\n",$contents);
					$arr_length = count($arr);
					for($k = 0; $k < $arr_length; $k++)
					{
						$xyz=explode("=", $arr[$k]);
						if(count($xyz)!=2)
						{
							continue;
						}
						$coin_confi[$j][$xyz[0]]=$xyz[1];
					}
				}

				for($j = 0; $j < $configs_coins_files_length; $j++)
				{
					$temp = $coin_confi[$j]["name"];
					$temp2 = $temp;
					$temp2[0]=chrtoupper($temp2[0]);
					if($temp2=="Karma")
					{
						$temp2="Karmacoin";
					} else if($temp2=="Bitquark") {
						$temp2="BitQuark";
					}
					$prefix=$temp2;
					if($temp2=="Bitcoin")
					{
						$prefix="BTC";
					} else if ($temp2=="Litecoin") {
						$prefix="LTC";
					} else if ($temp2=="Bitcrystal") {
						$prefix = "BTCRY";
					} else if ($temp2=="Bitcrystalx") {
						$prefix = "BTCRYX";
					} else if($temp2=="Dogecoin") {
						$prefix = "DOGE";
					} else if($temp2=="Pandacoin") {
						$prefix = "PANDA";
					} else if($temp2=="Karmacoin") {
						$prefix = "KARMA";
					} else if($temp2=="BitQuark") {
						$prefix = "BTQ";
					} else if($temp2=="Bitcrystalrare") {
						$prefix = "BITCRYR";
					} else {
						$ex = mytoupper($temp2);
						$ex=explode("COIN",$ex);
						if(is_array($ex)&&count($ex)==2)
						{
							$prefix = $ex[0];
						}
					}

					$fl=array();
					$fl[0]="require_once('my_coin.php');";
					$fl[1]="\$coin=new my_coin();";
					$fl[2]=mytrim('$coin->set_name("'.$temp2.'");');
					$fl[3]=mytrim('$coin->set_prefix("'.$prefix.'");');
					$fl[4]='$coin->set_fee(0.0000002);';
					$fl[5]='$coin->set_feebee($coin->getName());';
					$fl[6]='$coin->set_buy_fee(false);';
					$fl[7]='$coin->set_sell_fee(false);';
					$fl[8]=mytrim('$coin->set_use_multisignature_support(true);');
					$fl[9]=mytrim('$coin->set_count_of_used_addresses_for_multisignature_support(3);');
					$rpcuser=$coin_confi[$j]["rpcuser"];
					$rpcpassword=$coin_confi[$j]["rpcpassword"];
					$rpcallowip=$coin_confi[$j]["rpcallowip"];
					$rpcport=$coin_confi[$j]["rpcport"];
					$walletpassphrase=$coin_confi[$j]["walletpassphrase"];
					$walletpassphrase_timeout=$coin_confi[$j]["walletpassphrase_timeout"];
					$fl[10]=mytrim('$coin->set_rpc_settings_coin("'.$rpcuser.'", "'.$rpcpassword.'", "'.$rpcallowip.'", "'.$rpcport.'", "'.$walletpassphrase.'", '.$walletpassphrase_timeout.');');
					$fls="<?php\n".$fl[0]."\n".$fl[1]."\n".$fl[2]."\n".$fl[3]."\n".$fl[4]."\n".$fl[5]."\n".$fl[6]."\n".$fl[7]."\n".$fl[8]."\n".$fl[9]."\n".$fl[10]."\n?>";
					$template = './my_coins/'.$temp2.'.php';
					$fp = fopen($template,'w');
					fwrite($fp,$fls);
					fclose($fp);
					if($show_debug_messages==true)
					{
						echo '<br>' . $template . ' erstellt!<br/>';
					}
				}
				if($show_debug_messages==true)
				{
					echo "<br>coins from configs installed!</br>";
				}
			}
			if($install_my_trade_coins==true)
			{
				//Dogecoin,Bitcrystal,Litecoin,BitQuark,Bitcrystal,Karmacoin,Bitcoin,Bitcrystal,Pandacoin
				$my_coins_xx=myscandir('./my_coins/.');
				$my_coins_xx_length=count($my_coins_xx);
				$my_trade_coins_xx='';
				if($my_coins_xx_length<=0)
				{
					return false;
				}
				for($k = 0; $k < $used_coins_length; $k++)
				{
					if(!is_array($used_coins[$k])||count($used_coins[$k])!=3)
					{
						continue;
					}
					$have_coins_count=0;
					for($j = 0; $j < $my_coins_xx_length;$j++)
					{
						$th=str_replace(".php","",$my_coins_xx[$j]);
						$tj=$used_coins[$k];
						if($th==$tj[0]||$th==$tj[1]||$th==$tj[2])
						{
							$have_coins_count = $have_coins_count + 1;
						}
						if($have_coins_count==3)
						{
							break;
						}
					}
					if($have_coins_count!=3)
					{
						continue;
					}
					if($my_trade_coins_xx!='')
					{
						$my_trade_coins_xx = $my_trade_coins_xx .','.$tj[0].','.$tj[1].','.$tj[2];
					} else {
						$my_trade_coins_xx = $tj[0].','.$tj[1].','.$tj[2];
					}
				}
				if($my_trade_coins_xx=='')
				{
					if($show_debug_messages==true)
					{
						echo "<br>no coins found!</br>";
						echo "<br>check coin settings!</br>";
					}
					return false;
				}
				$fl="<?php\nrequire_once('coins_class.php');\n\$my_coins_names=\"\";\n\$init_feebee_account=\"\";\n\n//Only needed if you want add your own coins\n//The array must dividable through 3 otherwise you get a error\n\$my_coins_names=\"".$my_trade_coins_xx."\";\n\$my_coins_names=explode(\",\",\$my_coins_names);\n\$init_feebee_account=false;\n\$my_coins = w_coins::get(\$my_coins_names,\$init_feebee_account);\n?>\n";
				$fp=fopen('my_coins_template.php','w');
				fwrite($fp,$fl);
				fclose($fp);
				if($show_debug_messages==true)
				{
					echo "<br>coins installed!</br>";
				}
			}
			if($install_coins_database==true)
			{
				$fp = fopen('database.php', 'w');
				fwrite($fp,"<?php\n\$dbdb_host = '".$database_host."';         // the server the database is located\n\$dbdb_user = '".$database_username."';      // the username to access the database\n\$dbdb_pass = '".$database_password."';      // the password to access the database\n\$dbdb_database = '".$database_name."';  // the name of the database being used\n?>");
				fclose($fp);
				include('database.php');
				$link = mysql_connect($dbdb_host,$dbdb_user,$dbdb_pass);
				$allok1 = false;
				$allok2 = false;
				$allok3 = false;
				if($link)
				{
					$allok1=true;
					echo "<br>mysql connection ok!<br/>";
					$charset = mysql_set_charset('utf8');
					if($charset)
					{
						if($show_debug_nessages==true)
						{
							echo "<br>mysql charset successfully setted!</br>";
						}
						$allok2 = true;
					} else {
						if($show_debug_messages==true)
						{
							echo "<br>mysql charset can not setted!</br>";
							echo "<br>mysql error number: " . mysql_errno($link) . ", mysql error: " . mysql_error($link). "</br>";				
						}
						return false;
					}
					$select_db = mysql_select_db($dbdb_database,$link);
					if($select_db)
					{
						$allok3=true;
						if($show_debug_messages==true)
						{
							echo "<br>mysql database successfully selected!</br>";
						}
					} else {
						if($show_debug_messages==true)
						{
							echo "<br>mysql database can not selected!</br>";
							echo "<br>mysql error number: " . mysql_errno($link) . ", mysql error: " . mysql_error($link). "</br>";
						}
						return false;
					}
					if($allok1==true&&$allok2==true&&$allok3==true)
					{
						include('db_sql.php');
						for($k=0; $k < $mysql_querys_length; $k++)
						{
							if(mysql_query($mysql_querys[$k],$link))
							{
								if($show_debug_messages==true)
								{
									echo '<br>mysql query: "'.$mysql_querys[$k].'" ok!</br>';
								}
							} else {
								if($show_debug_messages==true)
								{
									echo '<br>mysql query: "'.$mysql_querys[$k].'" failed!</br>';
									echo "<br>mysql error number: " . mysql_errno($link) . ", mysql error: " . mysql_error($link). "</br>";
								}
							}
						}
					}
				} else {
					if($show_debug_messages==true)
					{
						echo "<br>mysql connection  not ok!<br/>";
						echo "<br>mysql error number: " . mysql_errno($link) . ", mysql error: " . mysql_error($link). "</br>";
					}
					return false;
				}
			}
			return true;
		}
	}
	return false;
}

if(install())
{
	echo "<br>Zelles/Werris(bitcrystal) Exchange installed!</br>";
} else {
	echo "<br>Error 404 not found!<br/>";
}
?>