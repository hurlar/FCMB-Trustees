<!-- Begin Main Menu -->
<div class="ewMenu">
<?php $RootMenu = new cMenu(EW_MENUBAR_ID) ?>
<?php

// Generate all menu items
$RootMenu->IsRoot = TRUE;
$RootMenu->AddMenuItem(14, $Language->MenuPhrase("14", "MenuText"), "#", -1, "", IsLoggedIn(), FALSE, TRUE);
$RootMenu->AddMenuItem(20, $Language->MenuPhrase("20", "MenuText"), "layoutedit.php", 14, "", IsLoggedIn(), FALSE, TRUE);
$RootMenu->AddMenuItem(35, $Language->MenuPhrase("35", "MenuText"), "contentlist.php", 14, "", IsLoggedIn(), FALSE, TRUE);
$RootMenu->AddMenuItem(21, $Language->MenuPhrase("21", "MenuText"), "page_catlist.php", 14, "", IsLoggedIn(), FALSE, TRUE);
$RootMenu->AddMenuItem(11, $Language->MenuPhrase("11", "MenuText"), "page_templatelist.php", 14, "", IsLoggedIn(), FALSE);
$RootMenu->AddMenuItem(86, $Language->MenuPhrase("86", "MenuText"), "#", -1, "", IsLoggedIn(), FALSE, TRUE);
$RootMenu->AddMenuItem(64, $Language->MenuPhrase("64", "MenuText"), "mgt_catlist.php", 86, "", IsLoggedIn(), FALSE);
$RootMenu->AddMenuItem(62, $Language->MenuPhrase("62", "MenuText"), "directorslist.php", 86, "", IsLoggedIn(), FALSE);
$RootMenu->AddMenuItem(63, $Language->MenuPhrase("63", "MenuText"), "managementlist.php", 86, "", IsLoggedIn(), FALSE);
$RootMenu->AddMenuItem(89, $Language->MenuPhrase("89", "MenuText"), "", -1, "", IsLoggedIn(), FALSE, TRUE);
$RootMenu->AddMenuItem(88, $Language->MenuPhrase("88", "MenuText"), "faq_catlist.php", 89, "", IsLoggedIn(), FALSE);
$RootMenu->AddMenuItem(87, $Language->MenuPhrase("87", "MenuText"), "faqlist.php", 89, "", IsLoggedIn(), FALSE);
$RootMenu->AddMenuItem(15, $Language->MenuPhrase("15", "MenuText"), "#", -1, "", IsLoggedIn(), FALSE, TRUE);
$RootMenu->AddMenuItem(28, $Language->MenuPhrase("28", "MenuText"), "fileuploadslist.php", 15, "", IsLoggedIn(), FALSE, TRUE);
$RootMenu->AddMenuItem(118, $Language->MenuPhrase("118", "MenuText"), "#", -1, "", IsLoggedIn(), FALSE, TRUE);
$RootMenu->AddMenuItem(225, $Language->MenuPhrase("225", "MenuText"), "userslist.php", 118, "", IsLoggedIn(), FALSE, TRUE);
$RootMenu->AddMenuItem(138, $Language->MenuPhrase("138", "MenuText"), "personal_infolist.php?cmd=resetall", 118, "", IsLoggedIn(), FALSE);
$RootMenu->AddMenuItem(119, $Language->MenuPhrase("119", "MenuText"), "processflow_tblist.php", 118, "", IsLoggedIn(), FALSE);
$RootMenu->AddMenuItem(137, $Language->MenuPhrase("137", "MenuText"), "#", -1, "", IsLoggedIn(), FALSE, TRUE);
$RootMenu->AddMenuItem(149, $Language->MenuPhrase("149", "MenuText"), "simplewill_tblist.php", 137, "", IsLoggedIn(), FALSE);
$RootMenu->AddMenuItem(146, $Language->MenuPhrase("146", "MenuText"), "premiumwill_tblist.php", 137, "", IsLoggedIn(), FALSE);
$RootMenu->AddMenuItem(143, $Language->MenuPhrase("143", "MenuText"), "comprehensivewill_tblist.php", 137, "", IsLoggedIn(), FALSE);
$RootMenu->AddMenuItem(147, $Language->MenuPhrase("147", "MenuText"), "privatetrust_tblist.php", 137, "", IsLoggedIn(), FALSE);
$RootMenu->AddMenuItem(140, $Language->MenuPhrase("140", "MenuText"), "education_tblist.php", 137, "", IsLoggedIn(), FALSE);
$RootMenu->AddMenuItem(150, $Language->MenuPhrase("150", "MenuText"), "investmenttrust_tblist.php", 137, "", IsLoggedIn(), FALSE);
$RootMenu->AddMenuItem(151, $Language->MenuPhrase("151", "MenuText"), "reservetrust_tblist.php", 137, "", IsLoggedIn(), FALSE);
$RootMenu->AddMenuItem(141, $Language->MenuPhrase("141", "MenuText"), "payment_tblist.php", -1, "", IsLoggedIn(), FALSE);
$RootMenu->AddMenuItem(17, $Language->MenuPhrase("17", "MenuText"), "adminuserslist.php", -1, "", IsLoggedIn(), FALSE, TRUE);
$RootMenu->AddMenuItem(-2, $Language->Phrase("ChangePwd"), "changepwd.php", -1, "", IsLoggedIn() && !IsSysAdmin());
$RootMenu->AddMenuItem(-1, $Language->Phrase("Logout"), "logout.php", -1, "", IsLoggedIn());
$RootMenu->AddMenuItem(-1, $Language->Phrase("Login"), "login.php", -1, "", !IsLoggedIn() && substr(@$_SERVER["URL"], -1 * strlen("login.php")) <> "login.php");
$RootMenu->Render();
?>
</div>
<!-- End Main Menu -->
