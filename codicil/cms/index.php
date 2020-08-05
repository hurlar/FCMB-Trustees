<?php
if (session_id() == "") session_start(); // Initialize Session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg10.php" ?>
<?php include_once "ewmysql10.php" ?>
<?php include_once "phpfn10.php" ?>
<?php include_once "adminusersinfo.php" ?>
<?php include_once "userfn10.php" ?>
<?php

//
// Page class
//

$default = NULL; // Initialize page object first

class cdefault {

	// Page ID
	var $PageID = 'default';

	// Project ID
	var $ProjectID = "{D9B361E7-B2C1-4293-B9B3-B581986A15CC}";

	// Page object name
	var $PageObjName = 'default';

	// Page name
	function PageName() {
		return ew_CurrentPage();
	}

	// Page URL
	function PageUrl() {
		$PageUrl = ew_CurrentPage() . "?";
		return $PageUrl;
	}

	// Message
	function getMessage() {
		return @$_SESSION[EW_SESSION_MESSAGE];
	}

	function setMessage($v) {
		ew_AddMessage($_SESSION[EW_SESSION_MESSAGE], $v);
	}

	function getFailureMessage() {
		return @$_SESSION[EW_SESSION_FAILURE_MESSAGE];
	}

	function setFailureMessage($v) {
		ew_AddMessage($_SESSION[EW_SESSION_FAILURE_MESSAGE], $v);
	}

	function getSuccessMessage() {
		return @$_SESSION[EW_SESSION_SUCCESS_MESSAGE];
	}

	function setSuccessMessage($v) {
		ew_AddMessage($_SESSION[EW_SESSION_SUCCESS_MESSAGE], $v);
	}

	function getWarningMessage() {
		return @$_SESSION[EW_SESSION_WARNING_MESSAGE];
	}

	function setWarningMessage($v) {
		ew_AddMessage($_SESSION[EW_SESSION_WARNING_MESSAGE], $v);
	}

	// Show message
	function ShowMessage() {
		$hidden = FALSE;
		$html = "";

		// Message
		$sMessage = $this->getMessage();
		$this->Message_Showing($sMessage, "");
		if ($sMessage <> "") { // Message in Session, display
			if (!$hidden)
				$sMessage = "<button type=\"button\" class=\"close\" data-dismiss=\"alert\">&times;</button>" . $sMessage;
			$html .= "<div class=\"alert alert-success ewSuccess\">" . $sMessage . "</div>";
			$_SESSION[EW_SESSION_MESSAGE] = ""; // Clear message in Session
		}

		// Warning message
		$sWarningMessage = $this->getWarningMessage();
		$this->Message_Showing($sWarningMessage, "warning");
		if ($sWarningMessage <> "") { // Message in Session, display
			if (!$hidden)
				$sWarningMessage = "<button type=\"button\" class=\"close\" data-dismiss=\"alert\">&times;</button>" . $sWarningMessage;
			$html .= "<div class=\"alert alert-warning ewWarning\">" . $sWarningMessage . "</div>";
			$_SESSION[EW_SESSION_WARNING_MESSAGE] = ""; // Clear message in Session
		}

		// Success message
		$sSuccessMessage = $this->getSuccessMessage();
		$this->Message_Showing($sSuccessMessage, "success");
		if ($sSuccessMessage <> "") { // Message in Session, display
			if (!$hidden)
				$sSuccessMessage = "<button type=\"button\" class=\"close\" data-dismiss=\"alert\">&times;</button>" . $sSuccessMessage;
			$html .= "<div class=\"alert alert-success ewSuccess\">" . $sSuccessMessage . "</div>";
			$_SESSION[EW_SESSION_SUCCESS_MESSAGE] = ""; // Clear message in Session
		}

		// Failure message
		$sErrorMessage = $this->getFailureMessage();
		$this->Message_Showing($sErrorMessage, "failure");
		if ($sErrorMessage <> "") { // Message in Session, display
			if (!$hidden)
				$sErrorMessage = "<button type=\"button\" class=\"close\" data-dismiss=\"alert\">&times;</button>" . $sErrorMessage;
			$html .= "<div class=\"alert alert-error ewError\">" . $sErrorMessage . "</div>";
			$_SESSION[EW_SESSION_FAILURE_MESSAGE] = ""; // Clear message in Session
		}
		echo "<table class=\"ewStdTable\"><tr><td><div class=\"ewMessageDialog\"" . (($hidden) ? " style=\"display: none;\"" : "") . ">" . $html . "</div></td></tr></table>";
	}

	//
	// Page class constructor
	//
	function __construct() {
		global $conn, $Language, $UserAgent;

		// User agent
		$UserAgent = ew_UserAgent();
		$GLOBALS["Page"] = &$this;

		// Language object
		if (!isset($Language)) $Language = new cLanguage();

		// User table object (adminusers)
		if (!isset($GLOBALS["adminusers"])) $GLOBALS["adminusers"] = new cadminusers;

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'default', TRUE);

		// Start timer
		if (!isset($GLOBALS["gTimer"])) $GLOBALS["gTimer"] = new cTimer();

		// Open connection
		if (!isset($conn)) $conn = ew_Connect();
	}

	// 
	//  Page_Init
	//
	function Page_Init() {
		global $gsExport, $gsExportFile, $UserProfile, $Language, $Security, $objForm;

		// Security
		$Security = new cAdvancedSecurity();
		$this->CurrentAction = (@$_GET["a"] <> "") ? $_GET["a"] : @$_POST["a_list"]; // Set up curent action

		// Global Page Loading event (in userfn*.php)
		Page_Loading();

		// Page Load event
		$this->Page_Load();
	}

	//
	// Page_Terminate
	//
	function Page_Terminate($url = "") {
		global $conn;

		// Page Unload event
		$this->Page_Unload();

		// Global Page Unloaded event (in userfn*.php)
		Page_Unloaded();
		$this->Page_Redirecting($url);

		 // Close connection
		$conn->Close();

		// Go to URL if specified
		if ($url <> "") {
			if (!EW_DEBUG_ENABLED && ob_get_length())
				ob_end_clean();
			header("Location: " . $url);
		}
		exit();
	}

	//
	// Page main
	//
	function Page_Main() {
		global $Security, $Language;
		if (!$Security->IsLoggedIn()) $Security->AutoLogin();
		if ($Security->IsLoggedIn())
		$this->Page_Terminate("contentlist.php"); // Exit and go to default page
		if ($Security->IsLoggedIn())
			$this->Page_Terminate("adminuserslist.php");
		if ($Security->IsLoggedIn())
			$this->Page_Terminate("fileuploadslist.php");
		if ($Security->IsLoggedIn())
			$this->Page_Terminate("layoutlist.php");
		if ($Security->IsLoggedIn())
			$this->Page_Terminate("page_catlist.php");
		if ($Security->IsLoggedIn())
			$this->Page_Terminate("page_templatelist.php");
		if ($Security->IsLoggedIn())
			$this->Page_Terminate("userslist.php");
		if ($Security->IsLoggedIn())
			$this->Page_Terminate("faqlist.php");
		if ($Security->IsLoggedIn())
			$this->Page_Terminate("directorslist.php");
		if ($Security->IsLoggedIn())
			$this->Page_Terminate("managementlist.php");
		if ($Security->IsLoggedIn())
			$this->Page_Terminate("mgt_catlist.php");
		if ($Security->IsLoggedIn())
			$this->Page_Terminate("faq_catlist.php");
		if ($Security->IsLoggedIn())
			$this->Page_Terminate("addinfo_tblist.php");
		if ($Security->IsLoggedIn())
			$this->Page_Terminate("alt_beneficiarylist.php");
		if ($Security->IsLoggedIn())
			$this->Page_Terminate("assets_tblist.php");
		if ($Security->IsLoggedIn())
			$this->Page_Terminate("beneficiary_dumplist.php");
		if ($Security->IsLoggedIn())
			$this->Page_Terminate("children_detailslist.php");
		if ($Security->IsLoggedIn())
			$this->Page_Terminate("divorce_tblist.php");
		if ($Security->IsLoggedIn())
			$this->Page_Terminate("executor_tblist.php");
		if ($Security->IsLoggedIn())
			$this->Page_Terminate("overall_assetlist.php");
		if ($Security->IsLoggedIn())
			$this->Page_Terminate("payment_tblist.php");
		if ($Security->IsLoggedIn())
			$this->Page_Terminate("personal_infolist.php");
		if ($Security->IsLoggedIn())
			$this->Page_Terminate("processflow_tblist.php");
		if ($Security->IsLoggedIn())
			$this->Page_Terminate("spouse_tblist.php");
		if ($Security->IsLoggedIn())
			$this->Page_Terminate("trustee_tblist.php");
		if ($Security->IsLoggedIn())
			$this->Page_Terminate("will_tblist.php");
		if ($Security->IsLoggedIn())
			$this->Page_Terminate("witness_tblist.php");
		if ($Security->IsLoggedIn())
			$this->Page_Terminate("comprehensivewill_tblist.php");
		if ($Security->IsLoggedIn())
			$this->Page_Terminate("education_tblist.php");
		if ($Security->IsLoggedIn())
			$this->Page_Terminate("nextofkinlist.php");
		if ($Security->IsLoggedIn())
			$this->Page_Terminate("premiumwill_tblist.php");
		if ($Security->IsLoggedIn())
			$this->Page_Terminate("privatetrust_tblist.php");
		if ($Security->IsLoggedIn())
			$this->Page_Terminate("simplewill_tblist.php");
		if ($Security->IsLoggedIn())
			$this->Page_Terminate("investmenttrust_tblist.php");
		if ($Security->IsLoggedIn())
			$this->Page_Terminate("reservetrust_tblist.php");
		if ($Security->IsLoggedIn())
			$this->Page_Terminate("simplewill_assets_tblist.php");
		if ($Security->IsLoggedIn())
			$this->Page_Terminate("simplewill_overall_assetlist.php");
		if ($Security->IsLoggedIn()) {
			$this->setFailureMessage($Language->Phrase("NoPermission") . "<br><br><a href=\"logout.php\">" . $Language->Phrase("BackToLogin") . "</a>");
		} else {
			$this->Page_Terminate("login.php"); // Exit and go to login page
		}
	}

	// Page Load event
	function Page_Load() {

		//echo "Page Load";
	}

	// Page Unload event
	function Page_Unload() {

		//echo "Page Unload";
	}

	// Page Redirecting event
	function Page_Redirecting(&$url) {

		// Example:
		//$url = "your URL";

	}

	// Message Showing event
	// $type = ''|'success'|'failure'
	function Message_Showing(&$msg, $type) {

		// Example:
		//if ($type == 'success') $msg = "your success message";

	}
}
?>
<?php ew_Header(FALSE) ?>
<?php

// Create page object
if (!isset($default)) $default = new cdefault();

// Page init
$default->Page_Init();

// Page main
$default->Page_Main();
?>
<?php include_once "header.php" ?>
<?php
$default->ShowMessage();
?>
<?php include_once "footer.php" ?>
<?php
$default->Page_Terminate();
?>
