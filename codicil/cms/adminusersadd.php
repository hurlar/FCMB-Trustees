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

$adminusers_add = NULL; // Initialize page object first

class cadminusers_add extends cadminusers {

	// Page ID
	var $PageID = 'add';

	// Project ID
	var $ProjectID = "{D9B361E7-B2C1-4293-B9B3-B581986A15CC}";

	// Table name
	var $TableName = 'adminusers';

	// Page object name
	var $PageObjName = 'adminusers_add';

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

		// Table object (adminusers)
		if (!isset($GLOBALS["adminusers"])) {
			$GLOBALS["adminusers"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["adminusers"];
		}

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'add', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'adminusers', TRUE);

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

		// Create form object
		$objForm = new cFormObj();
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
	var $DbMasterFilter = "";
	var $DbDetailFilter = "";
	var $Priv = 0;
	var $OldRecordset;
	var $CopyRecord;

	// 
	// Page main
	//
	function Page_Main() {
		global $objForm, $Language, $gsFormError;

		// Process form if post back
		if (@$_POST["a_add"] <> "") {
			$this->CurrentAction = $_POST["a_add"]; // Get form action
			$this->CopyRecord = $this->LoadOldRecord(); // Load old recordset
			$this->LoadFormValues(); // Load form values
		} else { // Not post back

			// Load key values from QueryString
			$this->CopyRecord = TRUE;
			if (@$_GET["id"] != "") {
				$this->id->setQueryStringValue($_GET["id"]);
				$this->setKey("id", $this->id->CurrentValue); // Set up key
			} else {
				$this->setKey("id", ""); // Clear key
				$this->CopyRecord = FALSE;
			}
			if ($this->CopyRecord) {
				$this->CurrentAction = "C"; // Copy record
			} else {
				$this->CurrentAction = "I"; // Display blank record
				$this->LoadDefaultValues(); // Load default values
			}
		}

		// Set up Breadcrumb
		$this->SetupBreadcrumb();

		// Validate form if post back
		if (@$_POST["a_add"] <> "") {
			if (!$this->ValidateForm()) {
				$this->CurrentAction = "I"; // Form error, reset action
				$this->EventCancelled = TRUE; // Event cancelled
				$this->RestoreFormValues(); // Restore form values
				$this->setFailureMessage($gsFormError);
			}
		}

		// Perform action based on action code
		switch ($this->CurrentAction) {
			case "I": // Blank record, no action required
				break;
			case "C": // Copy an existing record
				if (!$this->LoadRow()) { // Load record based on key
					if ($this->getFailureMessage() == "") $this->setFailureMessage($Language->Phrase("NoRecord")); // No record found
					$this->Page_Terminate("adminuserslist.php"); // No matching record, return to list
				}
				break;
			case "A": // Add new record
				$this->SendEmail = TRUE; // Send email on add success
				if ($this->AddRow($this->OldRecordset)) { // Add successful
					if ($this->getSuccessMessage() == "")
						$this->setSuccessMessage($Language->Phrase("AddSuccess")); // Set up success message
					$sReturnUrl = $this->getReturnUrl();
					if (ew_GetPageName($sReturnUrl) == "adminusersview.php")
						$sReturnUrl = $this->GetViewUrl(); // View paging, return to view page with keyurl directly
					$this->Page_Terminate($sReturnUrl); // Clean up and return
				} else {
					$this->EventCancelled = TRUE; // Event cancelled
					$this->RestoreFormValues(); // Add failed, restore form values
				}
		}

		// Render row based on row type
		$this->RowType = EW_ROWTYPE_ADD;  // Render add type

		// Render row
		$this->ResetAttrs();
		$this->RenderRow();
	}

	// Get upload files
	function GetUploadFiles() {
		global $objForm;

		// Get upload data
	}

	// Load default values
	function LoadDefaultValues() {
		$this->fullname->CurrentValue = NULL;
		$this->fullname->OldValue = $this->fullname->CurrentValue;
		$this->_email->CurrentValue = NULL;
		$this->_email->OldValue = $this->_email->CurrentValue;
		$this->username->CurrentValue = NULL;
		$this->username->OldValue = $this->username->CurrentValue;
		$this->password->CurrentValue = NULL;
		$this->password->OldValue = $this->password->CurrentValue;
		$this->datecr->CurrentValue = NULL;
		$this->datecr->OldValue = $this->datecr->CurrentValue;
		$this->activated->CurrentValue = "N";
	}

	// Load form values
	function LoadFormValues() {

		// Load from form
		global $objForm;
		if (!$this->fullname->FldIsDetailKey) {
			$this->fullname->setFormValue($objForm->GetValue("x_fullname"));
		}
		if (!$this->_email->FldIsDetailKey) {
			$this->_email->setFormValue($objForm->GetValue("x__email"));
		}
		if (!$this->username->FldIsDetailKey) {
			$this->username->setFormValue($objForm->GetValue("x_username"));
		}
		if (!$this->password->FldIsDetailKey) {
			$this->password->setFormValue($objForm->GetValue("x_password"));
		}
		if (!$this->datecr->FldIsDetailKey) {
			$this->datecr->setFormValue($objForm->GetValue("x_datecr"));
			$this->datecr->CurrentValue = ew_UnFormatDateTime($this->datecr->CurrentValue, 0);
		}
		if (!$this->activated->FldIsDetailKey) {
			$this->activated->setFormValue($objForm->GetValue("x_activated"));
		}
	}

	// Restore form values
	function RestoreFormValues() {
		global $objForm;
		$this->LoadOldRecord();
		$this->fullname->CurrentValue = $this->fullname->FormValue;
		$this->_email->CurrentValue = $this->_email->FormValue;
		$this->username->CurrentValue = $this->username->FormValue;
		$this->password->CurrentValue = $this->password->FormValue;
		$this->datecr->CurrentValue = $this->datecr->FormValue;
		$this->datecr->CurrentValue = ew_UnFormatDateTime($this->datecr->CurrentValue, 0);
		$this->activated->CurrentValue = $this->activated->FormValue;
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
		$this->fullname->setDbValue($rs->fields('fullname'));
		$this->_email->setDbValue($rs->fields('email'));
		$this->username->setDbValue($rs->fields('username'));
		$this->password->setDbValue($rs->fields('password'));
		$this->lastlogin->setDbValue($rs->fields('lastlogin'));
		$this->logincount->setDbValue($rs->fields('logincount'));
		$this->datecr->setDbValue($rs->fields('datecr'));
		$this->userlevel->setDbValue($rs->fields('userlevel'));
		$this->activated->setDbValue($rs->fields('activated'));
	}

	// Load DbValue from recordset
	function LoadDbValues(&$rs) {
		if (!$rs || !is_array($rs) && $rs->EOF) return;
		$row = is_array($rs) ? $rs : $rs->fields;
		$this->id->DbValue = $row['id'];
		$this->fullname->DbValue = $row['fullname'];
		$this->_email->DbValue = $row['email'];
		$this->username->DbValue = $row['username'];
		$this->password->DbValue = $row['password'];
		$this->lastlogin->DbValue = $row['lastlogin'];
		$this->logincount->DbValue = $row['logincount'];
		$this->datecr->DbValue = $row['datecr'];
		$this->userlevel->DbValue = $row['userlevel'];
		$this->activated->DbValue = $row['activated'];
	}

	// Load old record
	function LoadOldRecord() {

		// Load key values from Session
		$bValidKey = TRUE;
		if (strval($this->getKey("id")) <> "")
			$this->id->CurrentValue = $this->getKey("id"); // id
		else
			$bValidKey = FALSE;

		// Load old recordset
		if ($bValidKey) {
			$this->CurrentFilter = $this->KeyFilter();
			$sSql = $this->SQL();
			$this->OldRecordset = ew_LoadRecordset($sSql);
			$this->LoadRowValues($this->OldRecordset); // Load row values
		} else {
			$this->OldRecordset = NULL;
		}
		return $bValidKey;
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
		// fullname
		// email
		// username
		// password
		// lastlogin
		// logincount
		// datecr
		// userlevel
		// activated

		if ($this->RowType == EW_ROWTYPE_VIEW) { // View row

			// id
			$this->id->ViewValue = $this->id->CurrentValue;
			$this->id->ViewCustomAttributes = "";

			// fullname
			$this->fullname->ViewValue = $this->fullname->CurrentValue;
			$this->fullname->ViewCustomAttributes = "";

			// email
			$this->_email->ViewValue = $this->_email->CurrentValue;
			$this->_email->ViewCustomAttributes = "";

			// username
			$this->username->ViewValue = $this->username->CurrentValue;
			$this->username->ViewCustomAttributes = "";

			// password
			$this->password->ViewValue = "********";
			$this->password->ViewCustomAttributes = "";

			// lastlogin
			$this->lastlogin->ViewValue = $this->lastlogin->CurrentValue;
			$this->lastlogin->ViewCustomAttributes = "";

			// logincount
			$this->logincount->ViewValue = $this->logincount->CurrentValue;
			$this->logincount->ViewCustomAttributes = "";

			// datecr
			$this->datecr->ViewValue = $this->datecr->CurrentValue;
			$this->datecr->ViewCustomAttributes = "";

			// userlevel
			$this->userlevel->ViewValue = $this->userlevel->CurrentValue;
			$this->userlevel->ViewCustomAttributes = "";

			// activated
			if (ew_ConvertToBool($this->activated->CurrentValue)) {
				$this->activated->ViewValue = $this->activated->FldTagCaption(1) <> "" ? $this->activated->FldTagCaption(1) : "Y";
			} else {
				$this->activated->ViewValue = $this->activated->FldTagCaption(2) <> "" ? $this->activated->FldTagCaption(2) : "N";
			}
			$this->activated->ViewCustomAttributes = "";

			// fullname
			$this->fullname->LinkCustomAttributes = "";
			$this->fullname->HrefValue = "";
			$this->fullname->TooltipValue = "";

			// email
			$this->_email->LinkCustomAttributes = "";
			$this->_email->HrefValue = "";
			$this->_email->TooltipValue = "";

			// username
			$this->username->LinkCustomAttributes = "";
			$this->username->HrefValue = "";
			$this->username->TooltipValue = "";

			// password
			$this->password->LinkCustomAttributes = "";
			$this->password->HrefValue = "";
			$this->password->TooltipValue = "";

			// datecr
			$this->datecr->LinkCustomAttributes = "";
			$this->datecr->HrefValue = "";
			$this->datecr->TooltipValue = "";

			// activated
			$this->activated->LinkCustomAttributes = "";
			$this->activated->HrefValue = "";
			$this->activated->TooltipValue = "";
		} elseif ($this->RowType == EW_ROWTYPE_ADD) { // Add row

			// fullname
			$this->fullname->EditCustomAttributes = "";
			$this->fullname->EditValue = ew_HtmlEncode($this->fullname->CurrentValue);
			$this->fullname->PlaceHolder = ew_HtmlEncode(ew_RemoveHtml($this->fullname->FldCaption()));

			// email
			$this->_email->EditCustomAttributes = "";
			$this->_email->EditValue = ew_HtmlEncode($this->_email->CurrentValue);
			$this->_email->PlaceHolder = ew_HtmlEncode(ew_RemoveHtml($this->_email->FldCaption()));

			// username
			$this->username->EditCustomAttributes = "";
			$this->username->EditValue = ew_HtmlEncode($this->username->CurrentValue);
			$this->username->PlaceHolder = ew_HtmlEncode(ew_RemoveHtml($this->username->FldCaption()));

			// password
			$this->password->EditCustomAttributes = "";
			$this->password->EditValue = ew_HtmlEncode($this->password->CurrentValue);

			// datecr
			$this->datecr->EditCustomAttributes = "";
			$this->datecr->EditValue = ew_HtmlEncode($this->datecr->CurrentValue);
			$this->datecr->PlaceHolder = ew_HtmlEncode(ew_RemoveHtml($this->datecr->FldCaption()));

			// activated
			$this->activated->EditCustomAttributes = "";
			$arwrk = array();
			$arwrk[] = array($this->activated->FldTagValue(1), $this->activated->FldTagCaption(1) <> "" ? $this->activated->FldTagCaption(1) : $this->activated->FldTagValue(1));
			$arwrk[] = array($this->activated->FldTagValue(2), $this->activated->FldTagCaption(2) <> "" ? $this->activated->FldTagCaption(2) : $this->activated->FldTagValue(2));
			$this->activated->EditValue = $arwrk;

			// Edit refer script
			// fullname

			$this->fullname->HrefValue = "";

			// email
			$this->_email->HrefValue = "";

			// username
			$this->username->HrefValue = "";

			// password
			$this->password->HrefValue = "";

			// datecr
			$this->datecr->HrefValue = "";

			// activated
			$this->activated->HrefValue = "";
		}
		if ($this->RowType == EW_ROWTYPE_ADD ||
			$this->RowType == EW_ROWTYPE_EDIT ||
			$this->RowType == EW_ROWTYPE_SEARCH) { // Add / Edit / Search row
			$this->SetupFieldTitles();
		}

		// Call Row Rendered event
		if ($this->RowType <> EW_ROWTYPE_AGGREGATEINIT)
			$this->Row_Rendered();
	}

	// Validate form
	function ValidateForm() {
		global $Language, $gsFormError;

		// Initialize form error message
		$gsFormError = "";

		// Check if validation required
		if (!EW_SERVER_VALIDATE)
			return ($gsFormError == "");
		if (!$this->username->FldIsDetailKey && !is_null($this->username->FormValue) && $this->username->FormValue == "") {
			ew_AddMessage($gsFormError, $Language->Phrase("EnterRequiredField") . " - " . $this->username->FldCaption());
		}

		// Return validate result
		$ValidateForm = ($gsFormError == "");

		// Call Form_CustomValidate event
		$sFormCustomError = "";
		$ValidateForm = $ValidateForm && $this->Form_CustomValidate($sFormCustomError);
		if ($sFormCustomError <> "") {
			ew_AddMessage($gsFormError, $sFormCustomError);
		}
		return $ValidateForm;
	}

	// Add record
	function AddRow($rsold = NULL) {
		global $conn, $Language, $Security;

		// Load db values from rsold
		if ($rsold) {
			$this->LoadDbValues($rsold);
		}
		$rsnew = array();

		// fullname
		$this->fullname->SetDbValueDef($rsnew, $this->fullname->CurrentValue, NULL, FALSE);

		// email
		$this->_email->SetDbValueDef($rsnew, $this->_email->CurrentValue, NULL, FALSE);

		// username
		$this->username->SetDbValueDef($rsnew, $this->username->CurrentValue, NULL, FALSE);

		// password
		$this->password->SetDbValueDef($rsnew, $this->password->CurrentValue, NULL, FALSE);

		// datecr
		$this->datecr->SetDbValueDef($rsnew, $this->datecr->CurrentValue, NULL, FALSE);

		// activated
		$tmpBool = $this->activated->CurrentValue;
		if ($tmpBool <> "Y" && $tmpBool <> "N")
			$tmpBool = (!empty($tmpBool)) ? "Y" : "N";
		$this->activated->SetDbValueDef($rsnew, $tmpBool, NULL, strval($this->activated->CurrentValue) == "");

		// Call Row Inserting event
		$rs = ($rsold == NULL) ? NULL : $rsold->fields;
		$bInsertRow = $this->Row_Inserting($rs, $rsnew);
		if ($bInsertRow) {
			$conn->raiseErrorFn = 'ew_ErrorFn';
			$AddRow = $this->Insert($rsnew);
			$conn->raiseErrorFn = '';
			if ($AddRow) {
			}
		} else {
			if ($this->getSuccessMessage() <> "" || $this->getFailureMessage() <> "") {

				// Use the message, do nothing
			} elseif ($this->CancelMessage <> "") {
				$this->setFailureMessage($this->CancelMessage);
				$this->CancelMessage = "";
			} else {
				$this->setFailureMessage($Language->Phrase("InsertCancelled"));
			}
			$AddRow = FALSE;
		}

		// Get insert id if necessary
		if ($AddRow) {
			$this->id->setDbValue($conn->Insert_ID());
			$rsnew['id'] = $this->id->DbValue;
		}
		if ($AddRow) {

			// Call Row Inserted event
			$rs = ($rsold == NULL) ? NULL : $rsold->fields;
			$this->Row_Inserted($rs, $rsnew);
		}
		return $AddRow;
	}

	// Set up Breadcrumb
	function SetupBreadcrumb() {
		global $Breadcrumb, $Language;
		$Breadcrumb = new cBreadcrumb();
		$PageCaption = $this->TableCaption();
		$Breadcrumb->Add("list", "<span id=\"ewPageCaption\">" . $PageCaption . "</span>", "adminuserslist.php", $this->TableVar);
		$PageCaption = ($this->CurrentAction == "C") ? $Language->Phrase("Copy") : $Language->Phrase("Add");
		$Breadcrumb->Add("add", "<span id=\"ewPageCaption\">" . $PageCaption . "</span>", ew_CurrentUrl(), $this->TableVar);
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

	// Form Custom Validate event
	function Form_CustomValidate(&$CustomError) {

		// Return error message in CustomError
		return TRUE;
	}
}
?>
<?php ew_Header(FALSE) ?>
<?php

// Create page object
if (!isset($adminusers_add)) $adminusers_add = new cadminusers_add();

// Page init
$adminusers_add->Page_Init();

// Page main
$adminusers_add->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$adminusers_add->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Page object
var adminusers_add = new ew_Page("adminusers_add");
adminusers_add.PageID = "add"; // Page ID
var EW_PAGE_ID = adminusers_add.PageID; // For backward compatibility

// Form object
var fadminusersadd = new ew_Form("fadminusersadd");

// Validate form
fadminusersadd.Validate = function() {
	if (!this.ValidateRequired)
		return true; // Ignore validation
	var $ = jQuery, fobj = this.GetForm(), $fobj = $(fobj);
	this.PostAutoSuggest();
	if ($fobj.find("#a_confirm").val() == "F")
		return true;
	var elm, felm, uelm, addcnt = 0;
	var $k = $fobj.find("#" + this.FormKeyCountName); // Get key_count
	var rowcnt = ($k[0]) ? parseInt($k.val(), 10) : 1;
	var startcnt = (rowcnt == 0) ? 0 : 1; // Check rowcnt == 0 => Inline-Add
	var gridinsert = $fobj.find("#a_list").val() == "gridinsert";
	for (var i = startcnt; i <= rowcnt; i++) {
		var infix = ($k[0]) ? String(i) : "";
		$fobj.data("rowindex", infix);
			elm = this.GetElements("x" + infix + "_username");
			if (elm && !ew_HasValue(elm))
				return this.OnError(elm, ewLanguage.Phrase("EnterRequiredField") + " - <?php echo ew_JsEncode2($adminusers->username->FldCaption()) ?>");
			elm = this.GetElements("x" + infix + "_activated[]");
			if (elm && !ew_HasValue(elm))
				return this.OnError(elm, ewLanguage.Phrase("EnterRequiredField") + " - <?php echo ew_JsEncode2($adminusers->activated->FldCaption()) ?>");

			// Set up row object
			ew_ElementsToRow(fobj);

			// Fire Form_CustomValidate event
			if (!this.Form_CustomValidate(fobj))
				return false;
	}

	// Process detail forms
	var dfs = $fobj.find("input[name='detailpage']").get();
	for (var i = 0; i < dfs.length; i++) {
		var df = dfs[i], val = df.value;
		if (val && ewForms[val])
			if (!ewForms[val].Validate())
				return false;
	}
	return true;
}

// Form_CustomValidate event
fadminusersadd.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
fadminusersadd.ValidateRequired = true;
<?php } else { ?>
fadminusersadd.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
// Form object for search

</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<?php $Breadcrumb->Render(); ?>
<?php $adminusers_add->ShowPageHeader(); ?>
<?php
$adminusers_add->ShowMessage();
?>
<form name="fadminusersadd" id="fadminusersadd" class="ewForm form-horizontal" action="<?php echo ew_CurrentPage() ?>" method="post">
<input type="hidden" name="t" value="adminusers">
<input type="hidden" name="a_add" id="a_add" value="A">
<table cellspacing="0" class="ewGrid"><tr><td>
<table id="tbl_adminusersadd" class="table table-bordered table-striped">
<?php if ($adminusers->fullname->Visible) { // fullname ?>
	<tr id="r_fullname">
		<td><span id="elh_adminusers_fullname"><?php echo $adminusers->fullname->FldCaption() ?></span></td>
		<td<?php echo $adminusers->fullname->CellAttributes() ?>>
<span id="el_adminusers_fullname" class="control-group">
<input type="text" data-field="x_fullname" name="x_fullname" id="x_fullname" size="30" maxlength="50" placeholder="<?php echo $adminusers->fullname->PlaceHolder ?>" value="<?php echo $adminusers->fullname->EditValue ?>"<?php echo $adminusers->fullname->EditAttributes() ?>>
</span>
<?php echo $adminusers->fullname->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($adminusers->_email->Visible) { // email ?>
	<tr id="r__email">
		<td><span id="elh_adminusers__email"><?php echo $adminusers->_email->FldCaption() ?></span></td>
		<td<?php echo $adminusers->_email->CellAttributes() ?>>
<span id="el_adminusers__email" class="control-group">
<input type="text" data-field="x__email" name="x__email" id="x__email" size="30" maxlength="50" placeholder="<?php echo $adminusers->_email->PlaceHolder ?>" value="<?php echo $adminusers->_email->EditValue ?>"<?php echo $adminusers->_email->EditAttributes() ?>>
</span>
<?php echo $adminusers->_email->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($adminusers->username->Visible) { // username ?>
	<tr id="r_username">
		<td><span id="elh_adminusers_username"><?php echo $adminusers->username->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></span></td>
		<td<?php echo $adminusers->username->CellAttributes() ?>>
<span id="el_adminusers_username" class="control-group">
<input type="text" data-field="x_username" name="x_username" id="x_username" size="30" maxlength="50" placeholder="<?php echo $adminusers->username->PlaceHolder ?>" value="<?php echo $adminusers->username->EditValue ?>"<?php echo $adminusers->username->EditAttributes() ?>>
</span>
<?php echo $adminusers->username->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($adminusers->password->Visible) { // password ?>
	<tr id="r_password">
		<td><span id="elh_adminusers_password"><?php echo $adminusers->password->FldCaption() ?></span></td>
		<td<?php echo $adminusers->password->CellAttributes() ?>>
<span id="el_adminusers_password" class="control-group">
<input type="password" data-field="x_password" name="x_password" id="x_password" size="30" maxlength="50"<?php echo $adminusers->password->EditAttributes() ?>>
</span>
<?php echo $adminusers->password->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($adminusers->datecr->Visible) { // datecr ?>
	<tr id="r_datecr">
		<td><span id="elh_adminusers_datecr"><?php echo $adminusers->datecr->FldCaption() ?></span></td>
		<td<?php echo $adminusers->datecr->CellAttributes() ?>>
<span id="el_adminusers_datecr" class="control-group">
<input type="text" data-field="x_datecr" name="x_datecr" id="x_datecr" placeholder="<?php echo $adminusers->datecr->PlaceHolder ?>" value="<?php echo $adminusers->datecr->EditValue ?>"<?php echo $adminusers->datecr->EditAttributes() ?>>
</span>
<?php echo $adminusers->datecr->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($adminusers->activated->Visible) { // activated ?>
	<tr id="r_activated">
		<td><span id="elh_adminusers_activated"><?php echo $adminusers->activated->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></span></td>
		<td<?php echo $adminusers->activated->CellAttributes() ?>>
<span id="el_adminusers_activated" class="control-group">
<?php
$selwrk = (ew_ConvertToBool($adminusers->activated->CurrentValue)) ? " checked=\"checked\"" : "";
?>
<label class="checkbox"><input type="checkbox" data-field="x_activated" name="x_activated[]" id="x_activated[]" value="1"<?php echo $selwrk ?><?php echo $adminusers->activated->EditAttributes() ?>></label>
</span>
<?php echo $adminusers->activated->CustomMsg ?></td>
	</tr>
<?php } ?>
</table>
</td></tr></table>
<button class="btn btn-primary ewButton" name="btnAction" id="btnAction" type="submit"><?php echo $Language->Phrase("AddBtn") ?></button>
</form>
<script type="text/javascript">
fadminusersadd.Init();
<?php if (EW_MOBILE_REFLOW && ew_IsMobile()) { ?>
ew_Reflow();
<?php } ?>
</script>
<?php
$adminusers_add->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$adminusers_add->Page_Terminate();
?>
