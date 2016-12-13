<?php
//session_start();
//error_reporting(0);
// verwenden von ldap bind
$ldaprdn  = '#####\#####';     // ldap rdn oder dn
$ldappass = '########';  // entsprechendes password

// verbinden zum ldap server
 $ldapconn = ldap_connect("ldap://dc1:389")
    or die("Keine Verbindung zum LDAP server möglich.");



function checkNTUser ($username,$passwort)
 {
   $ldapserver = 'ldap://dc1:389';
   $ds=ldap_connect($ldapserver);
   if ($ds)
    {
      $dn="cn=$username,cn=Users, DC=zentrale-woehrl, DC=de";
      $r=@ldap_bind($ds,$dn,$passwort); 
       if ($r)
        {
          return true;
        }
       else
        {
          return false;
        }
     }
 }
//var_dump(checkNTUser($username,$passwort));

//die;
$ds=$ldapconn;
ldap_set_option($ds, LDAP_OPT_PROTOCOL_VERSION, 3);
ldap_set_option($ds, LDAP_OPT_REFERRALS, 0);
$r=ldap_bind($ds, $ldaprdn, $ldappass);
$dn = 'OU=ZV,OU=Benutzer,OU=Woehrl,DC=zentrale-woehrl,DC=de';
$dn = 'OU=Filialen,OU=Benutzer,OU=Woehrl,DC=zentrale-woehrl,DC=de';
//$dn = 'OU=Mailverteiler,OU=Mailverteiler,OU=Woehrl,DC=zentrale-woehrl,DC=de';
//$dn = 'CN=Führungskräfte_ZV,OU=Mailverteiler NEU,OU=Mailverteiler,OU=Woehrl,DC=zentrale-woehrl,DC=de';
$filter="(objectclass=user)";
$filter="(objectClass=*)";
$justthese = array( "samaccountname","displayname","sn","cn","mail","description","ou");
$sr=ldap_search($ds, $dn, $filter);
$sr = ldap_search($ds, $dn, "(samaccountname=*)");
$info = ldap_get_entries($ds, $sr);
ldap_close($ds);
if(!$_SESSION['ads']){
foreach ($info as $inf=>$key){


$array = explode(",", $key["manager"][0]);

$_SESSION['ads'][$key["samaccountname"][0]] = array(
"Name" =>$key["cn"][0],
"Benutzername"=>$key["samaccountname"][0],
"Position" =>$key["title"][0],
"Email" =>$key["mail"][0],
"Telefon" =>$key["telephonenumber"][0],
"Handy" =>$key["homephone"][0],
"Abteilung" =>$key["department"][0],
"Vorgesetzter" =>(substr($array[0],3) . $array[1]),
"Raum" =>$key["physicaldeliveryofficename"][0],
"Firma" =>$key["company"][0],
"sn" =>$key["sn"][0],
"description" =>$key["description"][0]
);
} 
} else {




}

/*print '<pre>';
print_r ($info);
print '<pre>';
*/
?>
<!DOCTYPE html
PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="de_DE" lang="de_DE">
<head>
	<meta http-equiv="content-type" content="text/html; charset=UTF-8" />
	<script src="./javascript/js.js" type="text/javascript"></script>
	<link rel="stylesheet" type="text/css" href="./css/ldap.css" media="all">

	
</head>

<body>
<form action="<?php echo $_SERVER['PHP_SELF']; ?>" id="form" method="POST">

<table border="0" style="border:1px solid #333;">
<tr style="border:0px solid #fff;"><th colspan="14" style="background-color:none;border:1px solid #333333;padding:5px;" align="right"><input id="submit" type="submit" value="Speichern" /></th></tr>
<tr>
<th>Nr.</th><th>Name</th><th>Benutzername</th><th>Position</th><th>Email</th><th>Telefon</th><th>Handy</th><th>Abteilung</th><th>Vorgesetzter</th>
<th>Raum</th><th>Firma</th><th>sn</th><th>description</th><th>&nbsp;</th>
</tr>

<?php

$num = 1;

foreach ($info as $inf=>$key){
 echo  $key["mail"][0] . '<br />';

/*if($inf["cn"][0] && $inf["cn"][0] != "Geschaeftsleiter-Alle" && $inf["member"][0]){
$arrayexplode = explode(",", $inf["member"][0], 3);
$name = substr(substr($arrayexplode[0],3),0,-1);
$vorname = $arrayexplode[1];
*/
if($key["cn"][0]){
/*print "<pre>";
var_dump($key);
print "</pre>";
*/
?>

<tr id="<?php echo  $key["samaccountname"][0]; ?>">
<td <?php 
	if($num % 2){ ?> 
	class="ungerade" 
	<?php } else { ?> 
	class="gerade" <?php } ?>
	><?php echo  $num; ?>&nbsp;</td>
<td <?php 
	if($num % 2){ ?> 
	class="ungerade" 
	<?php } else { ?> 
	class="gerade" <?php } ?>
	><?php echo  $key["cn"][0]; ?>&nbsp;</td>
<td <?php 
	if($num % 2){ ?> 
	class="ungerade" 
	<?php } else { ?> 
	class="gerade" <?php } ?>
	><?php echo  $key["samaccountname"][0]; ?>&nbsp;</td>
<td id="<?php echo  $key["samaccountname"][0]."_title" ; ?>" <?php 
	if($num % 2){ ?> 
	class="ungerade" 
	<?php } else { ?> 
	class="gerade" <?php } ?>
	><p><?php echo  $key["title"][0]; ?>&nbsp;</p><input type="text"   name="<?php echo  $key["samaccountname"][0]."_title" ; ?>" value="<?php echo  $key["title"][0]; ?>" />
	<input type="hidden"   name='samaccountname[]' value='<?php echo  $key["samaccountname"][0]; ?>' /></td>
<td id="<?php echo  $key["samaccountname"][0]."_mail" ; ?>" <?php 
	if($num % 2){ ?> 
	class="ungerade" 
	<?php } else { ?> 
	class="gerade" <?php } ?>
	><p><?php echo  $key["mail"][0]; ?>&nbsp;</p><input type="text"   name="<?php echo  $key["samaccountname"][0]."_mail" ; ?>" value="<?php echo  $key["mail"][0]; ?>" /></td>
<td id="<?php echo  $key["samaccountname"][0]."_telephonenumber" ; ?>" <?php 
	if($num % 2){ ?> 
	class="ungerade" 
	<?php } else { ?> 
	class="gerade" <?php } ?>
	><p><?php echo  $key["telephonenumber"][0]; ?>&nbsp;</p><input type="text"   name="<?php echo  $key["samaccountname"][0]."_telephonenumber" ; ?>" value="<?php echo  $key["telephonenumber"][0]; ?>" /></td>
<td id="<?php echo  $key["samaccountname"][0]."_homephone" ; ?>" <?php 
	if($num % 2){ ?> 
	class="ungerade" 
	<?php } else { ?> 
	class="gerade" <?php } ?>
	><p><?php echo  $key["homephone"][0]; ?>&nbsp;</p><input type="text"   name="<?php echo  $key["samaccountname"][0]."_homephone" ; ?>" value="<?php echo  $key["homephone"][0]; ?>" /></td>

<td id="<?php echo  $key["samaccountname"][0]."_department" ; ?>"  <?php 
	if($num % 2){ ?> 
	class="ungerade" 
	<?php } else { ?> 
	class="gerade" <?php } ?>
	><p><?php echo  $key["department"][0]; ?>&nbsp;</p><input type="text"  name="<?php echo  $key["samaccountname"][0]."_department" ; ?>" value="<?php echo  $key["department"][0]; ?>" /></td>
<td id="<?php echo  $key["samaccountname"][0]."_manager" ; ?>" <?php 
	if($num % 2){ ?> 
	class="ungerade" 
	<?php } else { ?> 
	class="gerade" <?php } ?>
	><p><?php $array = explode(",", $key["manager"][0]);echo substr($array[0],3) . $array[1]; ?>&nbsp;</p><input type="text"   name="<?php echo  $key["samaccountname"][0]."_manager" ; ?>" value="<?php echo  $key["manager"][0]; ?>" /></td>
<td id="<?php echo  $key["samaccountname"][0]."_physicaldeliveryofficename" ; ?>"<?php 
	if($num % 2){ ?> 
	class="ungerade" 
	<?php } else { ?> 
	class="gerade" <?php } ?>
	><p><?php echo  $key["physicaldeliveryofficename"][0]; ?>&nbsp;</p><input type="text"   name="<?php echo  $key["samaccountname"][0]."_physicaldeliveryofficename" ; ?>" value="<?php echo  $key["physicaldeliveryofficename"][0]; ?>" /></td>
<td  id="<?php echo  $key["samaccountname"][0]."_company" ; ?>" <?php 
	if($num % 2){ ?> 
	class="ungerade" 
	<?php } else { ?> 
	class="gerade" <?php } ?>
	><p><?php echo  $key["company"][0]; ?>&nbsp;</p><input type="text"  name="<?php echo  $key["samaccountname"][0]."_company" ; ?>" value="<?php echo  $key["company"][0]; ?>" /></td>

<td id="<?php echo  $key["samaccountname"][0]."_sn" ; ?>" <?php 
	if($num % 2){ ?> 
	class="ungerade" 
	<?php } else { ?> 
	class="gerade" <?php } ?>
	><p><?php echo  $key["sn"][0]; ?>&nbsp;</p><input type="text"   name="<?php echo  $key["samaccountname"][0]."_sn" ; ?>" value="<?php echo  $key["sn"][0]; ?>" /></td>

<td id="<?php echo  $key["samaccountname"][0]."_description" ; ?>" <?php 
	if($num % 2){ ?> 
	class="ungerade" 
	<?php } else { ?> 
	class="gerade" <?php } ?>
	><p><?php echo  $key["description"][0]; ?>&nbsp;</p><input type="text"   name="<?php echo  $key["samaccountname"][0]."_description" ; ?>" value="<?php echo  $key["description"][0]; ?>" /></td>
	<td><a href="#"><img id="bearbeiten_spalte_<?php echo $key["samaccountname"][0]; ?>" src="./images/bearbeiten.gif" title="Eintrag bearbeiten" alt="Eintrag bearbeiten" onclick="bearbeiten(this.id);" border="0" /></a></td>

</tr>
<?php
$num = $num+1;
}

}
?>
</table>
</form>
</body>
