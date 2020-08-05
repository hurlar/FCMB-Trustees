<?php
if (session_id() == "") session_start(); // Initialize Session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg10.php" ?>
<?php include_once "ewmysql10.php" ?>
<?php include_once "phpfn10.php" ?>
<?php include_once "personal_infoinfo.php" ?>
<?php include_once "adminusersinfo.php" ?>
<?php include_once "preview_willinfo.php" ?>
<?php include_once "userfn10.php" ?>
<?php

//
// Page class
//

$personal_info_delete = NULL; // Initialize page object first

class cpersonal_info_delete extends cpersonal_info {

	// Page ID
	var $PageID = 'delete';

	// Project ID
	var $ProjectID = "{D9B361E7-B2C1-4293-B9B3-B581986A15CC}";

	// Table name
	var $TableName = 'personal_info';

	// Page object name
	var $PageObjName = 'personal_info_delete';

	// Page name
	function PageName() {
		return ew_CurrentPage();
	}

	// Page URL
	function PageUrl() {
		$PageUrl = ew_CurrentPage() . "?";
		if ($this->UseTokenInUrl) $PageUrl .= "t=" . $this->TableVar . "&"; // Add page token
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
	var $PageHeader;
	var $PageFooter;

	// Show Page Header
	function ShowPageHeader() {
		$sHeader = $this->PageHeader;
		$this->Page_DataRendering($sHeader);
		if ($sHeader <> "") { // Header exists, display
			echo "<p>" . $sHeader . "</p>";
		}
	}

	// Show Page Footer
	function ShowPageFooter() {
		$sFooter = $this->PageFooter;
		$this->Page_DataRendered($sFooter);
		if ($sFooter <> "") { // Footer exists, display
			echo "<p>" . $sFooter . "</p>";
		}
	}

	// Validate page request
	function IsPageRequest() {
		global $objForm;
		if ($this->UseTokenInUrl) {
			if ($objForm)
				return ($this->TableVar == $objForm->GetValue("t"));
			if (@$_GET["t"] <> "")
				return ($this->TableVar == $_GET["t"]);
		} else {
			return TRUE;
		}
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

		// Parent constuctor
		parent::__construct();

		// Table object (personal_info)
		if (!isset($GLOBALS["personal_info"])) {
			$GLOBALS["personal_info"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["personal_info"];
		}

		// Table object (adminusers)
		if (!isset($GLOBALS['adminusers'])) $GLOBALS['adminusers'] = new cadminusers();

		// Table object (preview_will)
		if (!isset($GLOBALS['preview_will'])) $GLOBALS['preview_will'] = new cpreview_will();

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'delete', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'personal_info', TRUE);

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
		if (!$Security->IsLoggedIn()) $Security->AutoLogin();
		if (!$Security->IsLoggedIn()) {
			$Security->SaveLastUrl();
			$this->Page_Terminate("login.php");
		}
		$this->CurrentAction = (@$_GET["a"] <> "") ? $_GET["a"] : @$_POST["a_list"]; // Set up curent action
		$this->id->Visible = !$this->IsAdd() && !$this->IsCopy() && !$this->IsGridAdd();

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
	var $TotalRecs = 0;
	var $RecCnt;
	var $RecKeys = array();
	var $Recordset;
	var $StartRowCnt = 1;
	var $RowCnt = 0;

	//
	// Page main
	//
	function Page_Main() {
		global $Language;

		// Set up Breadcrumb
		$this->SetupBreadcrumb();

		// Load key parameters
		$this->RecKeys = $this->GetRecordKeys(); // Load record keys
		$sFilter = $this->GetKeyFilter();
		if ($sFilter == "")
			$this->Page_Terminate("personal_infolist.php"); // Prevent SQL injection, return to list

		// Set up filter (SQL WHHERE clause) and get return SQL
		// SQL constructor in personal_info class, personal_infoinfo.php

		$this->CurrentFilter = $sFilter;

		// Get action
		if (@$_POST["a_delete"] <> "") {
			$this->CurrentAction = $_POST["a_delete"];
		} else {
			$this->CurrentAction = "D"; // Delete record directly
		}
		switch ($this->CurrentAction) {
			case "D": // Delete
				$this->SendEmail = TRUE; // Send email on delete success
				if ($this->DeleteRows()) { // Delete rows
					if ($this->getSuccessMessage() == "")
						$this->setSuccessMessage($Language->Phrase("DeleteSuccess")); // Set up success message
					$this->Page_Terminate($this->getReturnUrl()); // Return to caller
				}
		}
	}

// No functions
	// Load recordset
	function LoadRecordset($offset = -1, $rowcnt = -1) {
		global $conn;

		// Call Recordset Selecting event
		$this->Recordset_Selecting($this->CurrentFilter);

		// Load List page SQL
		$sSql = $this->SelectSQL();
		if ($offset > -1 && $rowcnt > -1)
			$sSql .= " LIMIT $rowcnt OFFSET $offset";

		// Load recordset
		$rs = ew_LoadRecordset($sSql);

		// Call Recordset Selected event
		$this->Recordset_Selected($rs);
		return $rs;
	}

	// Load row based on key values
	function LoadRow() {
		global $conn, $Security, $Language;
		$sFilter = $this->KeyFilter();

		// Call Row Selecting event
		$this->Row_Selecting($sFilter);

		// Load SQL based on filter
		$this->CurrentFilter = $sFilter;
		$sSql = $this->SQL();
		$res = FALSE;
		$rs = ew_LoadRecordset($sSql);
		if ($rs && !$rs->EOF) {
			$res = TRUE;
			$this->LoadRowValues($rs); // Load row values
			$rs->Close();
		}
		return $res;
	}

	// Load row values from recordset
	function LoadRowValues(&$rs) {
		global $conn;
		if (!$rs || $rs->EOF) return;

		// Call Row Selected event
		$row = &$rs->fields;
		$this->Row_Selected($row);
		$this->id->setDbValue($rs->fields('id'));
		$this->uid->setDbValue($rs->fields('uid'));
		$this->salutation->setDbValue($rs->fields('salutation'));
		$this->fname->setDbValue($rs->fields('fname'));
		$this->mname->setDbValue($rs->fields('mname'));
		$this->lname->setDbValue($rs->fields('lname'));
		$this->dob->setDbValue($rs->fields('dob'));
		$this->gender->setDbValue($rs->fields('gender'));
		$this->nationality->setDbValue($rs->fields('nationality'));
		$this->state->setDbValue($rs->fields('state'));
		$this->lga->setDbValue($rs->fields('lga'));
		$this->phone->setDbValue($rs->fields('phone'));
		$this->aphone->setDbValue($rs->fields('aphone'));
		$this->msg->setDbValue($rs->fields('msg'));
		$this->city->setDbValue($rs->fields('city'));
		$this->rstate->setDbValue($rs->fields('rstate'));
		$this->reg_status->setDbValue($rs->fields('reg_status'));
		$this->employment_status->setDbValue($rs->fields('employment_status'));
		$this->datecreated->setDbValue($rs->fields('datecreated'));
		$this->employer->setDbValue($rs->fields('employer'));
		$this->employerphone->setDbValue($rs->fields('employerphone'));
		$this->employeraddr->setDbValue($rs->fields('employeraddr'));
	}

	// Load DbValue from recordset
	function LoadDbValues(&$rs) {
		if (!$rs || !is_array($rs) && $rs->EOF) return;
		$row = is_array($rs) ? $rs : $rs->fields;
		$this->id->DbValue = $row['id'];
		$this->uid->DbValue = $row['uid'];
		$this->salutation->DbValue = $row['salutation'];
		$this->fname->DbValue = $row['fname'];
		$this->mname->DbValue = $row['mname'];
		$this->lname->DbValue = $row['lname'];
		$this->dob->DbValue = $row['dob'];
		$this->gender->DbValue = $row['gender'];
		$this->nationality->DbValue = $row['nationality'];
		$this->state->DbValue = $row['state'];
		$this->lga->DbValue = $row['lga'];
		$this->phone->DbValue = $row['phone'];
		$this->aphone->DbValue = $row['aphone'];
		$this->msg->DbValue = $row['msg'];
		$this->city->DbValue = $row['city'];
		$this->rstate->DbValue = $row['rstate'];
		$this->reg_status->DbValue = $row['reg_status'];
		$this->employment_status->DbValue = $row['employment_status'];
		$this->datecreated->DbValue = $row['datecreated'];
		$this->employer->DbValue = $row['employer'];
		$this->employerphone->DbValue = $row['employerphone'];
		$this->employeraddr->DbValue = $row['employeraddr'];
	}

	// Render row values based on field settings
	function RenderRow() {
		global $conn, $Security, $Language;
		global $gsLanguage;

		// Initialize URLs
		// Call Row_Rendering event

		$this->Row_Rendering();

		// Common render codes for all row types
		// id
		// uid
		// salutation
		// fname
		// mname
		// lname
		// dob
		// gender
		// nationality
		// state
		// lga
		// phone
		// aphone
		// msg
		// city
		// rstate
		// reg_status
		// employment_status
		// datecreated
		// employer
		// employerphone
		// employeraddr

		if ($this->RowType == EW_ROWTYPE_VIEW) { // View row

			// id
			$this->id->ViewValue = $this->id->CurrentValue;
			$this->id->ViewCustomAttributes = "";

			// uid
			$this->uid->ViewValue = $this->uid->CurrentValue;
			$this->uid->ViewCustomAttributes = "";

			// salutation
			$this->salutation->ViewValue = $this->salutation->CurrentValue;
			$this->salutation->ViewCustomAttributes = "";

			// fname
			$this->fname->ViewValue = $this->fname->CurrentValue;
			$this->fname->ViewCustomAttributes = "";

			// mname
			$this->mname->ViewValue = $this->mname->CurrentValue;
			$this->mname->ViewCustomAttributes = "";

			// lname
			$this->lname->ViewValue = $this->lname->CurrentValue;
			$this->lname->ViewCustomAttributes = "";

			// dob
			$this->dob->ViewValue = $this->dob->CurrentValue;
			$this->dob->ViewCustomAttributes = "";

			// gender
			$this->gender->ViewValue = $this->gender->CurrentValue;
			$this->gender->ViewCustomAttributes = "";

			// nationality
			$this->nationality->ViewValue = $this->nationality->CurrentValue;
			$this->nationality->ViewCustomAttributes = "";

			// state
			$this->state->ViewValue = $this->state->CurrentValue;
			$this->state->ViewCustomAttributes = "";

			// lga
			$this->lga->ViewValue = $this->lga->CurrentValue;
			$this->lga->ViewCustomAttributes = "";

			// phone
			$this->phone->ViewValue = $this->phone->CurrentValue;
			$this->phone->ViewCustomAttributes = "";

			// aphone
			$this->aphone->ViewValue = $this->aphone->CurrentValue;
			$this->aphone->ViewCustomAttributes = "";

			// city
			$this->city->ViewValue = $this->city->CurrentValue;
			$this->city->ViewCustomAttributes = "";

			// rstate
			$this->rstate->ViewValue = $this->rstate->CurrentValue;
			$this->rstate->ViewCustomAttributes = "";

			// reg_status
			$this->reg_status->ViewValue = $this->reg_status->CurrentValue;
			$this->reg_status->ViewCustomAttributes = "";

			// employment_status
			$this->employment_status->ViewValue = $this->employment_status->CurrentValue;
			$this->employment_status->ViewCustomAttributes = "";

			// datecreated
			$this->datecreated->ViewValue = $this->datecreated->CurrentValue;
			$this->datecreated->ViewCustomAttributes = "";

			// employerphone
			$this->employerphone->ViewValue = $this->employerphone->CurrentValue;
			$this->employerphone->ViewCustomAttributes = "";

			// id
			$this->id->LinkCustomAttributes = "";
			$this->id->HrefValue = "";
			$this->id->TooltipValue = "";

			// uid
			$this->uid->LinkCustomAttributes = "";
			$this->uid->HrefValue = "";
			$this->uid->TooltipValue = "";

			// salutation
			$this->salutation->LinkCustomAttributes = "";
			$this->salutation->HrefValue = "";
			$this->salutation->TooltipValue = "";

			// fname
			$this->fname->LinkCustomAttributes = "";
			$this->fname->HrefValue = "";
			$this->fname->TooltipValue = "";

			// mname
			$this->mname->LinkCustomAttributes = "";
			$this->mname->HrefValue = "";
			$this->mname->TooltipValue = "";

			// lname
			$this->lname->LinkCustomAttributes = "";
			$this->lname->HrefValue = "";
			$this->lname->TooltipValue = "";

			// dob
			$this->dob->LinkCustomAttributes = "";
			$this->dob->HrefValue = "";
			$this->dob->TooltipValue = "";

			// gender
			$this->gender->LinkCustomAttributes = "";
			$this->gender->HrefValue = "";
			$this->gender->TooltipValue = "";

			// nationality
			$this->nationality->LinkCustomAttributes = "";
			$this->nationality->HrefValue = "";
			$this->nationality->TooltipValue = "";

			// state
			$this->state->LinkCustomAttributes = "";
			$this->state->HrefValue = "";
			$this->state->TooltipValue = "";

			// lga
			$this->lga->LinkCustomAttributes = "";
			$this->lga->HrefValue = "";
			$this->lga->TooltipValue = "";

			// phone
			$this->phone->LinkCustomAttributes = "";
			$this->phone->HrefValue = "";
			$this->phone->TooltipValue = "";

			// aphone
			$this->aphone->LinkCustomAttributes = "";
			$this->aphone->HrefValue = "";
			$this->aphone->TooltipValue = "";

			// city
			$this->city->LinkCustomAttributes = "";
			$this->city->HrefValue = "";
			$this->city->TooltipValue = "";

			// rstate
			$this->rstate->LinkCustomAttributes = "";
			$this->rstate->HrefValue = "";
			$this->rstate->TooltipValue = "";

			// reg_status
			$this->reg_status->LinkCustomAttributes = "";
			$this->reg_status->HrefValue = "";
			$this->reg_status->TooltipValue = "";

			// employment_status
			$this->employment_status->LinkCustomAttributes = "";
			$this->employment_status->HrefValue = "";
			$this->employment_status->TooltipValue = "";

			// datecreated
			$this->datecreated->LinkCustomAttributes = "";
			$this->datecreated->HrefValue = "";
			$this->datecreated->TooltipValue = "";

			// employerphone
			$this->employerphone->LinkCustomAttributes = "";
			$this->employerphone->HrefValue = "";
			$this->employerphone->TooltipValue = "";
		}

		// Call Row Rendered event
		if ($this->RowType <> EW_ROWTYPE_AGGREGATEINIT)
			$this->Row_Rendered();
	}

	//
	// Delete records based on current filter
	//
	function DeleteRows() {
		global $conn, $Language, $Security;
		$DeleteRows = TRUE;
		$sSql = $this->SQL();
		$conn->raiseErrorFn = 'ew_ErrorFn';
		$rs = $conn->Execute($sSql);
		$conn->raiseErrorFn = '';
		if ($rs === FALSE) {
			return FALSE;
		} elseif ($rs->EOF) {
			$this->setFailureMessage($Language->Phrase("NoRecord")); // No record found
			$rs->Close();
			return FALSE;

		//} else {
		//	$this->LoadRowValues($rs); // Load row values

		}
		$conn->BeginTrans();

		// Clone old rows
		$rsold = ($rs) ? $rs->GetRows() : array();
		if ($rs)
			$rs->Close();

		// Call row deleting event
		if ($DeleteRows) {
			foreach ($rsold as $row) {
				$DeleteRows = $this->Row_Deleting($row);
				if (!$DeleteRows) break;
			}
		}
		if ($DeleteRows) {
			$sKey = "";
			foreach ($rsold as $row) {
				$sThisKey = "";
				if ($sThisKey <> "") $sThisKey .= $GLOBALS["EW_COMPOSITE_KEY_SEPARATOR"];
				$sThisKey .= $row['id'];
				$this->LoadDbValues($row);
				$conn->raiseErrorFn = 'ew_ErrorFn';
				$DeleteRows = $this->Delete($row); // Delete
				$conn->raiseErrorFn = '';
				if ($DeleteRows === FALSE)
					break;
				if ($sKey <> "") $sKey .= ", ";
				$sKey .= $sThisKey;
			}
		} else {

			// Set up error message
			if ($this->getSuccessMessage() <> "" || $this->getFailureMessage() <> "") {

				// Use the message, do nothing
			} elseif ($this->CancelMessage <> "") {
				$this->setFailureMessage($this->CancelMessage);
				$this->CancelMessage = "";
			} else {
				$this->setFailureMessage($Language->Phrase("DeleteCancelled"));
			}
		}
		if ($DeleteRows) {
			$conn->CommitTrans(); // Commit the changes
		} else {
			$conn->RollbackTrans(); // Rollback changes
		}

		// Call Row Deleted event
		if ($DeleteRows) {
			foreach ($rsold as $row) {
				$this->Row_Deleted($row);
			}
		}
		return $DeleteRows;
	}

	// Set up Breadcrumb
	function SetupBreadcrumb() {
		global $Breadcrumb, $Language;
		$Breadcrumb = new cBreadcrumb();
		$PageCaption = $this->TableCaption();
		$Breadcrumb->Add("list", "<span id=\"ewPageCaption\">" . $PageCaption . "</span>", "personal_infolist.php", $this->TableVar);
		$PageCaption = $Language->Phrase("delete");
		$Breadcrumb->Add("delete", "<span id=\"ewPageCaption\">" . $PageCaption . "</span>", ew_CurrentUrl(), $this->TableVar);
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
	// $type = ''|'success'|'failure'|'warning'
	function Message_Showing(&$msg, $type) {
		if ($type == 'success') {

			//$msg = "your success message";
		} elseif ($type == 'failure') {

			//$msg = "your failure message";
		} elseif ($type == 'warning') {

			//$msg = "your warning message";
		} else {

			//$msg = "your message";
		}
	}

	// Page Render event
	function Page_Render() {

		//echo "Page Render";
	}

	// Page Data Rendering event
	function Page_DataRendering(&$header) {

		// Example:
		//$header = "your header";

	}

	// Page Data Rendered event
	function Page_DataRendered(&$footer) {

		// Example:
		//$footer = "your footer";

	}
}
?>
<?php ew_Header(FALSE) ?>
<?php

// Create page object
if (!isset($personal_info_delete)) $personal_info_delete = new cpersonal_info_delete();

// Page init
$personal_info_delete->Page_Init();

// Page main
$personal_info_delete->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$personal_info_delete->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Page object
var personal_info_delete = new ew_Page("personal_info_delete");
personal_info_delete.PageID = "delete"; // Page ID
var EW_PAGE_ID = personal_info_delete.PageID; // For backward compatibility

// Form object
var fpersonal_infodelete = new ew_Form("fpersonal_infodelete");

// Form_CustomValidate event
fpersonal_infodelete.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
fpersonal_infodelete.ValidateRequired = true;
<?php } else { ?>
fpersonal_infodelete.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
// Form object for search

</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<?php

// Load records for display
if ($personal_info_delete->Recordset = $personal_info_delete->LoadRecordset())
	$personal_info_deleteTotalRecs = $personal_info_delete->Recordset->RecordCount(); // Get record count
if ($personal_info_deleteTotalRecs <= 0) { // No record found, exit
	if ($personal_info_delete->Recordset)
		$personal_info_delete->Recordset->Close();
	$personal_info_delete->Page_Terminate("personal_infolist.php"); // Return to list
}
?>
<?php $Breadcrumb->Render(); ?>
<?php $personal_info_delete->ShowPageHeader(); ?>
<?php
$personal_info_delete->ShowMessage();
?>
<form name="fpersonal_infodelete" id="fpersonal_infodelete" class="ewForm form-horizontal" action="<?php echo ew_CurrentPage() ?>" method="post">
<input type="hidden" name="t" value="personal_info">
<input type="hidden" name="a_delete" id="a_delete" value="D">
<?php foreach ($personal_info_delete->RecKeys as $key) { ?>
<?php $keyvalue = is_array($key) ? implode($EW_COMPOSITE_KEY_SEPARATOR, $key) : $key; ?>
<input type="hidden" name="key_m[]" value="<?php echo ew_HtmlEncode($keyvalue) ?>">
<?php } ?>
<table cellspacing="0" class="ewGrid"><tr><td class="ewGridContent">
<div class="ewGridMiddlePanel">
<table id="tbl_personal_infodelete" class="ewTable ewTableSeparate">
<?php echo $personal_info->TableCustomInnerHtml ?>
	<thead>
	<tr class="ewTableHeader">
<?php if ($personal_info->id->Visible) { // id ?>
		<td><span id="elh_personal_info_id" class="personal_info_id"><?php echo $personal_info->id->FldCaption() ?></span></td>
<?php } ?>
<?php if ($personal_info->uid->Visible) { // uid ?>
		<td><span id="elh_personal_info_uid" class="personal_info_uid"><?php echo $personal_info->uid->FldCaption() ?></span></td>
<?php } ?>
<?php if ($personal_info->salutation->Visible) { // salutation ?>
		<td><span id="elh_personal_info_salutation" class="personal_info_salutation"><?php echo $personal_info->salutation->FldCaption() ?></span></td>
<?php } ?>
<?php if ($personal_info->fname->Visible) { // fname ?>
		<td><span id="elh_personal_info_fname" class="personal_info_fname"><?php echo $personal_info->fname->FldCaption() ?></span></td>
<?php } ?>
<?php if ($personal_info->mname->Visible) { // mname ?>
		<td><span id="elh_personal_info_mname" class="personal_info_mname"><?php echo $personal_info->mname->FldCaption() ?></span></td>
<?php } ?>
<?php if ($personal_info->lname->Visible) { // lname ?>
		<td><span id="elh_personal_info_lname" class="personal_info_lname"><?php echo $personal_info->lname->FldCaption() ?></span></td>
<?php } ?>
<?php if ($personal_info->dob->Visible) { // dob ?>
		<td><span id="elh_personal_info_dob" class="personal_info_dob"><?php echo $personal_info->dob->FldCaption() ?></span></td>
<?php } ?>
<?php if ($personal_info->gender->Visible) { // gender ?>
		<td><span id="elh_personal_info_gender" class="personal_info_gender"><?php echo $personal_info->gender->FldCaption() ?></span></td>
<?php } ?>
<?php if ($personal_info->nationality->Visible) { // nationality ?>
		<td><span id="elh_personal_info_nationality" class="personal_info_nationality"><?php echo $personal_info->nationality->FldCaption() ?></span></td>
<?php } ?>
<?php if ($personal_info->state->Visible) { // state ?>
		<td><span id="elh_personal_info_state" class="personal_info_state"><?php echo $personal_info->state->FldCaption() ?></span></td>
<?php } ?>
<?php if ($personal_info->lga->Visible) { // lga ?>
		<td><span id="elh_personal_info_lga" class="personal_info_lga"><?php echo $personal_info->lga->FldCaption() ?></span></td>
<?php } ?>
<?php if ($personal_info->phone->Visible) { // phone ?>
		<td><span id="elh_personal_info_phone" class="personal_info_phone"><?php echo $personal_info->phone->FldCaption() ?></span></td>
<?php } ?>
<?php if ($personal_info->aphone->Visible) { // aphone ?>
		<td><span id="elh_personal_info_aphone" class="personal_info_aphone"><?php echo $personal_info->aphone->FldCaption() ?></span></td>
<?php } ?>
<?php if ($personal_info->city->Visible) { // city ?>
		<td><span id="elh_personal_info_city" class="personal_info_city"><?php echo $personal_info->city->FldCaption() ?></span></td>
<?php } ?>
<?php if ($personal_info->rstate->Visible) { // rstate ?>
		<td><span id="elh_personal_info_rstate" class="personal_info_rstate"><?php echo $personal_info->rstate->FldCaption() ?></span></td>
<?php } ?>
<?php if ($personal_info->reg_status->Visible) { // reg_status ?>
		<td><span id="elh_personal_info_reg_status" class="personal_info_reg_status"><?php echo $personal_info->reg_status->FldCaption() ?></span></td>
<?php } ?>
<?php if ($personal_info->employment_status->Visible) { // employment_status ?>
		<td><span id="elh_personal_info_employment_status" class="personal_info_employment_status"><?php echo $personal_info->employment_status->FldCaption() ?></span></td>
<?php } ?>
<?php if ($personal_info->datecreated->Visible) { // datecreated ?>
		<td><span id="elh_personal_info_datecreated" class="personal_info_datecreated"><?php echo $personal_info->datecreated->FldCaption() ?></span></td>
<?php } ?>
<?php if ($personal_info->employerphone->Visible) { // employerphone ?>
		<td><span id="elh_personal_info_employerphone" class="personal_info_employerphone"><?php echo $personal_info->employerphone->FldCaption() ?></span></td>
<?php } ?>
	</tr>
	</thead>
	<tbody>
<?php
$personal_info_delete->RecCnt = 0;
$i = 0;
while (!$personal_info_delete->Recordset->EOF) {
	$personal_info_delete->RecCnt++;
	$personal_info_delete->RowCnt++;

	// Set row properties
	$personal_info->ResetAttrs();
	$personal_info->RowType = EW_ROWTYPE_VIEW; // View

	// Get the field contents
	$personal_info_delete->LoadRowValues($personal_info_delete->Recordset);

	// Render row
	$personal_info_delete->RenderRow();
?>
	<tr<?php echo $personal_info->RowAttributes() ?>>
<?php if ($personal_info->id->Visible) { // id ?>
		<td<?php echo $personal_info->id->CellAttributes() ?>>
<span id="el<?php echo $personal_info_delete->RowCnt ?>_personal_info_id" class="control-group personal_info_id">
<span<?php echo $personal_info->id->ViewAttributes() ?>>
<?php echo $personal_info->id->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($personal_info->uid->Visible) { // uid ?>
		<td<?php echo $personal_info->uid->CellAttributes() ?>>
<span id="el<?php echo $personal_info_delete->RowCnt ?>_personal_info_uid" class="control-group personal_info_uid">
<span<?php echo $personal_info->uid->ViewAttributes() ?>>
<?php echo $personal_info->uid->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($personal_info->salutation->Visible) { // salutation ?>
		<td<?php echo $personal_info->salutation->CellAttributes() ?>>
<span id="el<?php echo $personal_info_delete->RowCnt ?>_personal_info_salutation" class="control-group personal_info_salutation">
<span<?php echo $personal_info->salutation->ViewAttributes() ?>>
<?php echo $personal_info->salutation->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($personal_info->fname->Visible) { // fname ?>
		<td<?php echo $personal_info->fname->CellAttributes() ?>>
<span id="el<?php echo $personal_info_delete->RowCnt ?>_personal_info_fname" class="control-group personal_info_fname">
<span<?php echo $personal_info->fname->ViewAttributes() ?>>
<?php echo $personal_info->fname->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($personal_info->mname->Visible) { // mname ?>
		<td<?php echo $personal_info->mname->CellAttributes() ?>>
<span id="el<?php echo $personal_info_delete->RowCnt ?>_personal_info_mname" class="control-group personal_info_mname">
<span<?php echo $personal_info->mname->ViewAttributes() ?>>
<?php echo $personal_info->mname->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($personal_info->lname->Visible) { // lname ?>
		<td<?php echo $personal_info->lname->CellAttributes() ?>>
<span id="el<?php echo $personal_info_delete->RowCnt ?>_personal_info_lname" class="control-group personal_info_lname">
<span<?php echo $personal_info->lname->ViewAttributes() ?>>
<?php echo $personal_info->lname->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($personal_info->dob->Visible) { // dob ?>
		<td<?php echo $personal_info->dob->CellAttributes() ?>>
<span id="el<?php echo $personal_info_delete->RowCnt ?>_personal_info_dob" class="control-group personal_info_dob">
<span<?php echo $personal_info->dob->ViewAttributes() ?>>
<?php echo $personal_info->dob->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($personal_info->gender->Visible) { // gender ?>
		<td<?php echo $personal_info->gender->CellAttributes() ?>>
<span id="el<?php echo $personal_info_delete->RowCnt ?>_personal_info_gender" class="control-group personal_info_gender">
<span<?php echo $personal_info->gender->ViewAttributes() ?>>
<?php echo $personal_info->gender->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($personal_info->nationality->Visible) { // nationality ?>
		<td<?php echo $personal_info->nationality->CellAttributes() ?>>
<span id="el<?php echo $personal_info_delete->RowCnt ?>_personal_info_nationality" class="control-group personal_info_nationality">
<span<?php echo $personal_info->nationality->ViewAttributes() ?>>
<?php echo $personal_info->nationality->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($personal_info->state->Visible) { // state ?>
		<td<?php echo $personal_info->state->CellAttributes() ?>>
<span id="el<?php echo $personal_info_delete->RowCnt ?>_personal_info_state" class="control-group personal_info_state">
<span<?php echo $personal_info->state->ViewAttributes() ?>>
<?php echo $personal_info->state->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($personal_info->lga->Visible) { // lga ?>
		<td<?php echo $personal_info->lga->CellAttributes() ?>>
<span id="el<?php echo $personal_info_delete->RowCnt ?>_personal_info_lga" class="control-group personal_info_lga">
<span<?php echo $personal_info->lga->ViewAttributes() ?>>
<?php echo $personal_info->lga->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($personal_info->phone->Visible) { // phone ?>
		<td<?php echo $personal_info->phone->CellAttributes() ?>>
<span id="el<?php echo $personal_info_delete->RowCnt ?>_personal_info_phone" class="control-group personal_info_phone">
<span<?php echo $personal_info->phone->ViewAttributes() ?>>
<?php echo $personal_info->phone->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($personal_info->aphone->Visible) { // aphone ?>
		<td<?php echo $personal_info->aphone->CellAttributes() ?>>
<span id="el<?php echo $personal_info_delete->RowCnt ?>_personal_info_aphone" class="control-group personal_info_aphone">
<span<?php echo $personal_info->aphone->ViewAttributes() ?>>
<?php echo $personal_info->aphone->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($personal_info->city->Visible) { // city ?>
		<td<?php echo $personal_info->city->CellAttributes() ?>>
<span id="el<?php echo $personal_info_delete->RowCnt ?>_personal_info_city" class="control-group personal_info_city">
<span<?php echo $personal_info->city->ViewAttributes() ?>>
<?php echo $personal_info->city->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($personal_info->rstate->Visible) { // rstate ?>
		<td<?php echo $personal_info->rstate->CellAttributes() ?>>
<span id="el<?php echo $personal_info_delete->RowCnt ?>_personal_info_rstate" class="control-group personal_info_rstate">
<span<?php echo $personal_info->rstate->ViewAttributes() ?>>
<?php echo $personal_info->rstate->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($personal_info->reg_status->Visible) { // reg_status ?>
		<td<?php echo $personal_info->reg_status->CellAttributes() ?>>
<span id="el<?php echo $personal_info_delete->RowCnt ?>_personal_info_reg_status" class="control-group personal_info_reg_status">
<span<?php echo $personal_info->reg_status->ViewAttributes() ?>>
<?php echo $personal_info->reg_status->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($personal_info->employment_status->Visible) { // employment_status ?>
		<td<?php echo $personal_info->employment_status->CellAttributes() ?>>
<span id="el<?php echo $personal_info_delete->RowCnt ?>_personal_info_employment_status" class="control-group personal_info_employment_status">
<span<?php echo $personal_info->employment_status->ViewAttributes() ?>>
<?php echo $personal_info->employment_status->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($personal_info->datecreated->Visible) { // datecreated ?>
		<td<?php echo $personal_info->datecreated->CellAttributes() ?>>
<span id="el<?php echo $personal_info_delete->RowCnt ?>_personal_info_datecreated" class="control-group personal_info_datecreated">
<span<?php echo $personal_info->datecreated->ViewAttributes() ?>>
<?php echo $personal_info->datecreated->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($personal_info->employerphone->Visible) { // employerphone ?>
		<td<?php echo $personal_info->employerphone->CellAttributes() ?>>
<span id="el<?php echo $personal_info_delete->RowCnt ?>_personal_info_employerphone" class="control-group personal_info_employerphone">
<span<?php echo $personal_info->employerphone->ViewAttributes() ?>>
<?php echo $personal_info->employerphone->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
	</tr>
<?php
	$personal_info_delete->Recordset->MoveNext();
}
$personal_info_delete->Recordset->Close();
?>
</tbody>
</table>
</div>
</td></tr></table>
<div class="btn-group ewButtonGroup">
<button class="btn btn-primary ewButton" name="btnAction" id="btnAction" type="submit"><?php echo $Language->Phrase("DeleteBtn") ?></button>
</div>
</form>
<script type="text/javascript">
fpersonal_infodelete.Init();
</script>
<?php
$personal_info_delete->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$personal_info_delete->Page_Terminate();
?>
