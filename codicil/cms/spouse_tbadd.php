<?php
if (session_id() == "") session_start(); // Initialize Session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg10.php" ?>
<?php include_once "ewmysql10.php" ?>
<?php include_once "phpfn10.php" ?>
<?php include_once "spouse_tbinfo.php" ?>
<?php include_once "adminusersinfo.php" ?>
<?php include_once "personal_infoinfo.php" ?>
<?php include_once "comprehensivewill_tbinfo.php" ?>
<?php include_once "premiumwill_tbinfo.php" ?>
<?php include_once "privatetrust_tbinfo.php" ?>
<?php include_once "children_detailsgridcls.php" ?>
<?php include_once "userfn10.php" ?>
<?php

//
// Page class
//

$spouse_tb_add = NULL; // Initialize page object first

class cspouse_tb_add extends cspouse_tb {

	// Page ID
	var $PageID = 'add';

	// Project ID
	var $ProjectID = "{D9B361E7-B2C1-4293-B9B3-B581986A15CC}";

	// Table name
	var $TableName = 'spouse_tb';

	// Page object name
	var $PageObjName = 'spouse_tb_add';

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

		// Table object (spouse_tb)
		if (!isset($GLOBALS["spouse_tb"])) {
			$GLOBALS["spouse_tb"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["spouse_tb"];
		}

		// Table object (adminusers)
		if (!isset($GLOBALS['adminusers'])) $GLOBALS['adminusers'] = new cadminusers();

		// Table object (personal_info)
		if (!isset($GLOBALS['personal_info'])) $GLOBALS['personal_info'] = new cpersonal_info();

		// Table object (comprehensivewill_tb)
		if (!isset($GLOBALS['comprehensivewill_tb'])) $GLOBALS['comprehensivewill_tb'] = new ccomprehensivewill_tb();

		// Table object (premiumwill_tb)
		if (!isset($GLOBALS['premiumwill_tb'])) $GLOBALS['premiumwill_tb'] = new cpremiumwill_tb();

		// Table object (privatetrust_tb)
		if (!isset($GLOBALS['privatetrust_tb'])) $GLOBALS['privatetrust_tb'] = new cprivatetrust_tb();

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'add', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'spouse_tb', TRUE);

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

		// Set up master/detail parameters
		$this->SetUpMasterParms();

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

		// Set up detail parameters
		$this->SetUpDetailParms();

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
					$this->Page_Terminate("spouse_tblist.php"); // No matching record, return to list
				}

				// Set up detail parameters
				$this->SetUpDetailParms();
				break;
			case "A": // Add new record
				$this->SendEmail = TRUE; // Send email on add success
				if ($this->AddRow($this->OldRecordset)) { // Add successful
					if ($this->getSuccessMessage() == "")
						$this->setSuccessMessage($Language->Phrase("AddSuccess")); // Set up success message
					if ($this->getCurrentDetailTable() <> "") // Master/detail add
						$sReturnUrl = $this->GetDetailUrl();
					else
						$sReturnUrl = $this->getReturnUrl();
					if (ew_GetPageName($sReturnUrl) == "spouse_tbview.php")
						$sReturnUrl = $this->GetViewUrl(); // View paging, return to view page with keyurl directly
					$this->Page_Terminate($sReturnUrl); // Clean up and return
				} else {
					$this->EventCancelled = TRUE; // Event cancelled
					$this->RestoreFormValues(); // Add failed, restore form values

					// Set up detail parameters
					$this->SetUpDetailParms();
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
		$this->uid->CurrentValue = NULL;
		$this->uid->OldValue = $this->uid->CurrentValue;
		$this->title->CurrentValue = NULL;
		$this->title->OldValue = $this->title->CurrentValue;
		$this->fullname->CurrentValue = NULL;
		$this->fullname->OldValue = $this->fullname->CurrentValue;
		$this->_email->CurrentValue = NULL;
		$this->_email->OldValue = $this->_email->CurrentValue;
		$this->dob->CurrentValue = NULL;
		$this->dob->OldValue = $this->dob->CurrentValue;
		$this->phoneno->CurrentValue = NULL;
		$this->phoneno->OldValue = $this->phoneno->CurrentValue;
		$this->altphoneno->CurrentValue = NULL;
		$this->altphoneno->OldValue = $this->altphoneno->CurrentValue;
		$this->addr->CurrentValue = NULL;
		$this->addr->OldValue = $this->addr->CurrentValue;
		$this->city->CurrentValue = NULL;
		$this->city->OldValue = $this->city->CurrentValue;
		$this->state->CurrentValue = NULL;
		$this->state->OldValue = $this->state->CurrentValue;
		$this->marriagetype->CurrentValue = NULL;
		$this->marriagetype->OldValue = $this->marriagetype->CurrentValue;
		$this->marriageyear->CurrentValue = NULL;
		$this->marriageyear->OldValue = $this->marriageyear->CurrentValue;
		$this->marriagecert->CurrentValue = NULL;
		$this->marriagecert->OldValue = $this->marriagecert->CurrentValue;
		$this->citym->CurrentValue = NULL;
		$this->citym->OldValue = $this->citym->CurrentValue;
		$this->countrym->CurrentValue = NULL;
		$this->countrym->OldValue = $this->countrym->CurrentValue;
		$this->datecreated->CurrentValue = NULL;
		$this->datecreated->OldValue = $this->datecreated->CurrentValue;
	}

	// Load form values
	function LoadFormValues() {

		// Load from form
		global $objForm;
		if (!$this->uid->FldIsDetailKey) {
			$this->uid->setFormValue($objForm->GetValue("x_uid"));
		}
		if (!$this->title->FldIsDetailKey) {
			$this->title->setFormValue($objForm->GetValue("x_title"));
		}
		if (!$this->fullname->FldIsDetailKey) {
			$this->fullname->setFormValue($objForm->GetValue("x_fullname"));
		}
		if (!$this->_email->FldIsDetailKey) {
			$this->_email->setFormValue($objForm->GetValue("x__email"));
		}
		if (!$this->dob->FldIsDetailKey) {
			$this->dob->setFormValue($objForm->GetValue("x_dob"));
		}
		if (!$this->phoneno->FldIsDetailKey) {
			$this->phoneno->setFormValue($objForm->GetValue("x_phoneno"));
		}
		if (!$this->altphoneno->FldIsDetailKey) {
			$this->altphoneno->setFormValue($objForm->GetValue("x_altphoneno"));
		}
		if (!$this->addr->FldIsDetailKey) {
			$this->addr->setFormValue($objForm->GetValue("x_addr"));
		}
		if (!$this->city->FldIsDetailKey) {
			$this->city->setFormValue($objForm->GetValue("x_city"));
		}
		if (!$this->state->FldIsDetailKey) {
			$this->state->setFormValue($objForm->GetValue("x_state"));
		}
		if (!$this->marriagetype->FldIsDetailKey) {
			$this->marriagetype->setFormValue($objForm->GetValue("x_marriagetype"));
		}
		if (!$this->marriageyear->FldIsDetailKey) {
			$this->marriageyear->setFormValue($objForm->GetValue("x_marriageyear"));
		}
		if (!$this->marriagecert->FldIsDetailKey) {
			$this->marriagecert->setFormValue($objForm->GetValue("x_marriagecert"));
		}
		if (!$this->citym->FldIsDetailKey) {
			$this->citym->setFormValue($objForm->GetValue("x_citym"));
		}
		if (!$this->countrym->FldIsDetailKey) {
			$this->countrym->setFormValue($objForm->GetValue("x_countrym"));
		}
		if (!$this->datecreated->FldIsDetailKey) {
			$this->datecreated->setFormValue($objForm->GetValue("x_datecreated"));
			$this->datecreated->CurrentValue = ew_UnFormatDateTime($this->datecreated->CurrentValue, 0);
		}
	}

	// Restore form values
	function RestoreFormValues() {
		global $objForm;
		$this->LoadOldRecord();
		$this->uid->CurrentValue = $this->uid->FormValue;
		$this->title->CurrentValue = $this->title->FormValue;
		$this->fullname->CurrentValue = $this->fullname->FormValue;
		$this->_email->CurrentValue = $this->_email->FormValue;
		$this->dob->CurrentValue = $this->dob->FormValue;
		$this->phoneno->CurrentValue = $this->phoneno->FormValue;
		$this->altphoneno->CurrentValue = $this->altphoneno->FormValue;
		$this->addr->CurrentValue = $this->addr->FormValue;
		$this->city->CurrentValue = $this->city->FormValue;
		$this->state->CurrentValue = $this->state->FormValue;
		$this->marriagetype->CurrentValue = $this->marriagetype->FormValue;
		$this->marriageyear->CurrentValue = $this->marriageyear->FormValue;
		$this->marriagecert->CurrentValue = $this->marriagecert->FormValue;
		$this->citym->CurrentValue = $this->citym->FormValue;
		$this->countrym->CurrentValue = $this->countrym->FormValue;
		$this->datecreated->CurrentValue = $this->datecreated->FormValue;
		$this->datecreated->CurrentValue = ew_UnFormatDateTime($this->datecreated->CurrentValue, 0);
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
		$this->title->setDbValue($rs->fields('title'));
		$this->fullname->setDbValue($rs->fields('fullname'));
		$this->_email->setDbValue($rs->fields('email'));
		$this->dob->setDbValue($rs->fields('dob'));
		$this->phoneno->setDbValue($rs->fields('phoneno'));
		$this->altphoneno->setDbValue($rs->fields('altphoneno'));
		$this->addr->setDbValue($rs->fields('addr'));
		$this->city->setDbValue($rs->fields('city'));
		$this->state->setDbValue($rs->fields('state'));
		$this->marriagetype->setDbValue($rs->fields('marriagetype'));
		$this->marriageyear->setDbValue($rs->fields('marriageyear'));
		$this->marriagecert->setDbValue($rs->fields('marriagecert'));
		$this->citym->setDbValue($rs->fields('citym'));
		$this->countrym->setDbValue($rs->fields('countrym'));
		$this->datecreated->setDbValue($rs->fields('datecreated'));
	}

	// Load DbValue from recordset
	function LoadDbValues(&$rs) {
		if (!$rs || !is_array($rs) && $rs->EOF) return;
		$row = is_array($rs) ? $rs : $rs->fields;
		$this->id->DbValue = $row['id'];
		$this->uid->DbValue = $row['uid'];
		$this->title->DbValue = $row['title'];
		$this->fullname->DbValue = $row['fullname'];
		$this->_email->DbValue = $row['email'];
		$this->dob->DbValue = $row['dob'];
		$this->phoneno->DbValue = $row['phoneno'];
		$this->altphoneno->DbValue = $row['altphoneno'];
		$this->addr->DbValue = $row['addr'];
		$this->city->DbValue = $row['city'];
		$this->state->DbValue = $row['state'];
		$this->marriagetype->DbValue = $row['marriagetype'];
		$this->marriageyear->DbValue = $row['marriageyear'];
		$this->marriagecert->DbValue = $row['marriagecert'];
		$this->citym->DbValue = $row['citym'];
		$this->countrym->DbValue = $row['countrym'];
		$this->datecreated->DbValue = $row['datecreated'];
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
		// uid
		// title
		// fullname
		// email
		// dob
		// phoneno
		// altphoneno
		// addr
		// city
		// state
		// marriagetype
		// marriageyear
		// marriagecert
		// citym
		// countrym
		// datecreated

		if ($this->RowType == EW_ROWTYPE_VIEW) { // View row

			// id
			$this->id->ViewValue = $this->id->CurrentValue;
			$this->id->ViewCustomAttributes = "";

			// uid
			$this->uid->ViewValue = $this->uid->CurrentValue;
			$this->uid->ViewCustomAttributes = "";

			// title
			$this->title->ViewValue = $this->title->CurrentValue;
			$this->title->ViewCustomAttributes = "";

			// fullname
			$this->fullname->ViewValue = $this->fullname->CurrentValue;
			$this->fullname->ViewCustomAttributes = "";

			// email
			$this->_email->ViewValue = $this->_email->CurrentValue;
			$this->_email->ViewCustomAttributes = "";

			// dob
			$this->dob->ViewValue = $this->dob->CurrentValue;
			$this->dob->ViewCustomAttributes = "";

			// phoneno
			$this->phoneno->ViewValue = $this->phoneno->CurrentValue;
			$this->phoneno->ViewCustomAttributes = "";

			// altphoneno
			$this->altphoneno->ViewValue = $this->altphoneno->CurrentValue;
			$this->altphoneno->ViewCustomAttributes = "";

			// addr
			$this->addr->ViewValue = $this->addr->CurrentValue;
			$this->addr->ViewCustomAttributes = "";

			// city
			$this->city->ViewValue = $this->city->CurrentValue;
			$this->city->ViewCustomAttributes = "";

			// state
			$this->state->ViewValue = $this->state->CurrentValue;
			$this->state->ViewCustomAttributes = "";

			// marriagetype
			$this->marriagetype->ViewValue = $this->marriagetype->CurrentValue;
			$this->marriagetype->ViewCustomAttributes = "";

			// marriageyear
			$this->marriageyear->ViewValue = $this->marriageyear->CurrentValue;
			$this->marriageyear->ViewCustomAttributes = "";

			// marriagecert
			$this->marriagecert->ViewValue = $this->marriagecert->CurrentValue;
			$this->marriagecert->ViewCustomAttributes = "";

			// citym
			$this->citym->ViewValue = $this->citym->CurrentValue;
			$this->citym->ViewCustomAttributes = "";

			// countrym
			$this->countrym->ViewValue = $this->countrym->CurrentValue;
			$this->countrym->ViewCustomAttributes = "";

			// datecreated
			$this->datecreated->ViewValue = $this->datecreated->CurrentValue;
			$this->datecreated->ViewCustomAttributes = "";

			// uid
			$this->uid->LinkCustomAttributes = "";
			$this->uid->HrefValue = "";
			$this->uid->TooltipValue = "";

			// title
			$this->title->LinkCustomAttributes = "";
			$this->title->HrefValue = "";
			$this->title->TooltipValue = "";

			// fullname
			$this->fullname->LinkCustomAttributes = "";
			$this->fullname->HrefValue = "";
			$this->fullname->TooltipValue = "";

			// email
			$this->_email->LinkCustomAttributes = "";
			$this->_email->HrefValue = "";
			$this->_email->TooltipValue = "";

			// dob
			$this->dob->LinkCustomAttributes = "";
			$this->dob->HrefValue = "";
			$this->dob->TooltipValue = "";

			// phoneno
			$this->phoneno->LinkCustomAttributes = "";
			$this->phoneno->HrefValue = "";
			$this->phoneno->TooltipValue = "";

			// altphoneno
			$this->altphoneno->LinkCustomAttributes = "";
			$this->altphoneno->HrefValue = "";
			$this->altphoneno->TooltipValue = "";

			// addr
			$this->addr->LinkCustomAttributes = "";
			$this->addr->HrefValue = "";
			$this->addr->TooltipValue = "";

			// city
			$this->city->LinkCustomAttributes = "";
			$this->city->HrefValue = "";
			$this->city->TooltipValue = "";

			// state
			$this->state->LinkCustomAttributes = "";
			$this->state->HrefValue = "";
			$this->state->TooltipValue = "";

			// marriagetype
			$this->marriagetype->LinkCustomAttributes = "";
			$this->marriagetype->HrefValue = "";
			$this->marriagetype->TooltipValue = "";

			// marriageyear
			$this->marriageyear->LinkCustomAttributes = "";
			$this->marriageyear->HrefValue = "";
			$this->marriageyear->TooltipValue = "";

			// marriagecert
			$this->marriagecert->LinkCustomAttributes = "";
			$this->marriagecert->HrefValue = "";
			$this->marriagecert->TooltipValue = "";

			// citym
			$this->citym->LinkCustomAttributes = "";
			$this->citym->HrefValue = "";
			$this->citym->TooltipValue = "";

			// countrym
			$this->countrym->LinkCustomAttributes = "";
			$this->countrym->HrefValue = "";
			$this->countrym->TooltipValue = "";

			// datecreated
			$this->datecreated->LinkCustomAttributes = "";
			$this->datecreated->HrefValue = "";
			$this->datecreated->TooltipValue = "";
		} elseif ($this->RowType == EW_ROWTYPE_ADD) { // Add row

			// uid
			$this->uid->EditCustomAttributes = "";
			if ($this->uid->getSessionValue() <> "") {
				$this->uid->CurrentValue = $this->uid->getSessionValue();
			$this->uid->ViewValue = $this->uid->CurrentValue;
			$this->uid->ViewCustomAttributes = "";
			} else {
			$this->uid->EditValue = ew_HtmlEncode($this->uid->CurrentValue);
			$this->uid->PlaceHolder = ew_HtmlEncode(ew_RemoveHtml($this->uid->FldCaption()));
			}

			// title
			$this->title->EditCustomAttributes = "style='width:97%' ";
			$this->title->EditValue = ew_HtmlEncode($this->title->CurrentValue);
			$this->title->PlaceHolder = ew_HtmlEncode(ew_RemoveHtml($this->title->FldCaption()));

			// fullname
			$this->fullname->EditCustomAttributes = "style='width:97%' ";
			$this->fullname->EditValue = ew_HtmlEncode($this->fullname->CurrentValue);
			$this->fullname->PlaceHolder = ew_HtmlEncode(ew_RemoveHtml($this->fullname->FldCaption()));

			// email
			$this->_email->EditCustomAttributes = "style='width:97%' ";
			$this->_email->EditValue = ew_HtmlEncode($this->_email->CurrentValue);
			$this->_email->PlaceHolder = ew_HtmlEncode(ew_RemoveHtml($this->_email->FldCaption()));

			// dob
			$this->dob->EditCustomAttributes = "style='width:97%' ";
			$this->dob->EditValue = ew_HtmlEncode($this->dob->CurrentValue);
			$this->dob->PlaceHolder = ew_HtmlEncode(ew_RemoveHtml($this->dob->FldCaption()));

			// phoneno
			$this->phoneno->EditCustomAttributes = "";
			$this->phoneno->EditValue = ew_HtmlEncode($this->phoneno->CurrentValue);
			$this->phoneno->PlaceHolder = ew_HtmlEncode(ew_RemoveHtml($this->phoneno->FldCaption()));

			// altphoneno
			$this->altphoneno->EditCustomAttributes = "style='width:97%' ";
			$this->altphoneno->EditValue = ew_HtmlEncode($this->altphoneno->CurrentValue);
			$this->altphoneno->PlaceHolder = ew_HtmlEncode(ew_RemoveHtml($this->altphoneno->FldCaption()));

			// addr
			$this->addr->EditCustomAttributes = "style='width:97%' ";
			$this->addr->EditValue = $this->addr->CurrentValue;
			$this->addr->PlaceHolder = ew_HtmlEncode(ew_RemoveHtml($this->addr->FldCaption()));

			// city
			$this->city->EditCustomAttributes = "style='width:97%' ";
			$this->city->EditValue = ew_HtmlEncode($this->city->CurrentValue);
			$this->city->PlaceHolder = ew_HtmlEncode(ew_RemoveHtml($this->city->FldCaption()));

			// state
			$this->state->EditCustomAttributes = "style='width:97%' ";
			$this->state->EditValue = ew_HtmlEncode($this->state->CurrentValue);
			$this->state->PlaceHolder = ew_HtmlEncode(ew_RemoveHtml($this->state->FldCaption()));

			// marriagetype
			$this->marriagetype->EditCustomAttributes = "style='width:97%' ";
			$this->marriagetype->EditValue = ew_HtmlEncode($this->marriagetype->CurrentValue);
			$this->marriagetype->PlaceHolder = ew_HtmlEncode(ew_RemoveHtml($this->marriagetype->FldCaption()));

			// marriageyear
			$this->marriageyear->EditCustomAttributes = "style='width:97%' ";
			$this->marriageyear->EditValue = ew_HtmlEncode($this->marriageyear->CurrentValue);
			$this->marriageyear->PlaceHolder = ew_HtmlEncode(ew_RemoveHtml($this->marriageyear->FldCaption()));

			// marriagecert
			$this->marriagecert->EditCustomAttributes = "style='width:97%' ";
			$this->marriagecert->EditValue = ew_HtmlEncode($this->marriagecert->CurrentValue);
			$this->marriagecert->PlaceHolder = ew_HtmlEncode(ew_RemoveHtml($this->marriagecert->FldCaption()));

			// citym
			$this->citym->EditCustomAttributes = "style='width:97%' ";
			$this->citym->EditValue = ew_HtmlEncode($this->citym->CurrentValue);
			$this->citym->PlaceHolder = ew_HtmlEncode(ew_RemoveHtml($this->citym->FldCaption()));

			// countrym
			$this->countrym->EditCustomAttributes = "style='width:97%' ";
			$this->countrym->EditValue = ew_HtmlEncode($this->countrym->CurrentValue);
			$this->countrym->PlaceHolder = ew_HtmlEncode(ew_RemoveHtml($this->countrym->FldCaption()));

			// datecreated
			$this->datecreated->EditCustomAttributes = "";
			$this->datecreated->EditValue = ew_HtmlEncode($this->datecreated->CurrentValue);
			$this->datecreated->PlaceHolder = ew_HtmlEncode(ew_RemoveHtml($this->datecreated->FldCaption()));

			// Edit refer script
			// uid

			$this->uid->HrefValue = "";

			// title
			$this->title->HrefValue = "";

			// fullname
			$this->fullname->HrefValue = "";

			// email
			$this->_email->HrefValue = "";

			// dob
			$this->dob->HrefValue = "";

			// phoneno
			$this->phoneno->HrefValue = "";

			// altphoneno
			$this->altphoneno->HrefValue = "";

			// addr
			$this->addr->HrefValue = "";

			// city
			$this->city->HrefValue = "";

			// state
			$this->state->HrefValue = "";

			// marriagetype
			$this->marriagetype->HrefValue = "";

			// marriageyear
			$this->marriageyear->HrefValue = "";

			// marriagecert
			$this->marriagecert->HrefValue = "";

			// citym
			$this->citym->HrefValue = "";

			// countrym
			$this->countrym->HrefValue = "";

			// datecreated
			$this->datecreated->HrefValue = "";
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
		if (!$this->uid->FldIsDetailKey && !is_null($this->uid->FormValue) && $this->uid->FormValue == "") {
			ew_AddMessage($gsFormError, $Language->Phrase("EnterRequiredField") . " - " . $this->uid->FldCaption());
		}
		if (!ew_CheckInteger($this->uid->FormValue)) {
			ew_AddMessage($gsFormError, $this->uid->FldErrMsg());
		}
		if (!$this->marriagetype->FldIsDetailKey && !is_null($this->marriagetype->FormValue) && $this->marriagetype->FormValue == "") {
			ew_AddMessage($gsFormError, $Language->Phrase("EnterRequiredField") . " - " . $this->marriagetype->FldCaption());
		}
		if (!$this->marriageyear->FldIsDetailKey && !is_null($this->marriageyear->FormValue) && $this->marriageyear->FormValue == "") {
			ew_AddMessage($gsFormError, $Language->Phrase("EnterRequiredField") . " - " . $this->marriageyear->FldCaption());
		}
		if (!$this->marriagecert->FldIsDetailKey && !is_null($this->marriagecert->FormValue) && $this->marriagecert->FormValue == "") {
			ew_AddMessage($gsFormError, $Language->Phrase("EnterRequiredField") . " - " . $this->marriagecert->FldCaption());
		}

		// Validate detail grid
		$DetailTblVar = explode(",", $this->getCurrentDetailTable());
		if (in_array("children_details", $DetailTblVar) && $GLOBALS["children_details"]->DetailAdd) {
			if (!isset($GLOBALS["children_details_grid"])) $GLOBALS["children_details_grid"] = new cchildren_details_grid(); // get detail page object
			$GLOBALS["children_details_grid"]->ValidateGridForm();
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

		// Check referential integrity for master table 'comprehensivewill_tb'
		$bValidMasterRecord = TRUE;
		$sMasterFilter = $this->SqlMasterFilter_comprehensivewill_tb();
		if (strval($this->uid->CurrentValue) <> "") {
			$sMasterFilter = str_replace("@uid@", ew_AdjustSql($this->uid->CurrentValue), $sMasterFilter);
		} else {
			$bValidMasterRecord = FALSE;
		}
		if ($bValidMasterRecord) {
			$rsmaster = $GLOBALS["comprehensivewill_tb"]->LoadRs($sMasterFilter);
			$bValidMasterRecord = ($rsmaster && !$rsmaster->EOF);
			$rsmaster->Close();
		}
		if (!$bValidMasterRecord) {
			$sRelatedRecordMsg = str_replace("%t", "comprehensivewill_tb", $Language->Phrase("RelatedRecordRequired"));
			$this->setFailureMessage($sRelatedRecordMsg);
			return FALSE;
		}

		// Begin transaction
		if ($this->getCurrentDetailTable() <> "")
			$conn->BeginTrans();

		// Load db values from rsold
		if ($rsold) {
			$this->LoadDbValues($rsold);
		}
		$rsnew = array();

		// uid
		$this->uid->SetDbValueDef($rsnew, $this->uid->CurrentValue, 0, FALSE);

		// title
		$this->title->SetDbValueDef($rsnew, $this->title->CurrentValue, NULL, FALSE);

		// fullname
		$this->fullname->SetDbValueDef($rsnew, $this->fullname->CurrentValue, NULL, FALSE);

		// email
		$this->_email->SetDbValueDef($rsnew, $this->_email->CurrentValue, NULL, FALSE);

		// dob
		$this->dob->SetDbValueDef($rsnew, $this->dob->CurrentValue, NULL, FALSE);

		// phoneno
		$this->phoneno->SetDbValueDef($rsnew, $this->phoneno->CurrentValue, NULL, FALSE);

		// altphoneno
		$this->altphoneno->SetDbValueDef($rsnew, $this->altphoneno->CurrentValue, NULL, FALSE);

		// addr
		$this->addr->SetDbValueDef($rsnew, $this->addr->CurrentValue, NULL, FALSE);

		// city
		$this->city->SetDbValueDef($rsnew, $this->city->CurrentValue, NULL, FALSE);

		// state
		$this->state->SetDbValueDef($rsnew, $this->state->CurrentValue, NULL, FALSE);

		// marriagetype
		$this->marriagetype->SetDbValueDef($rsnew, $this->marriagetype->CurrentValue, "", FALSE);

		// marriageyear
		$this->marriageyear->SetDbValueDef($rsnew, $this->marriageyear->CurrentValue, "", FALSE);

		// marriagecert
		$this->marriagecert->SetDbValueDef($rsnew, $this->marriagecert->CurrentValue, "", FALSE);

		// citym
		$this->citym->SetDbValueDef($rsnew, $this->citym->CurrentValue, NULL, FALSE);

		// countrym
		$this->countrym->SetDbValueDef($rsnew, $this->countrym->CurrentValue, NULL, FALSE);

		// datecreated
		$this->datecreated->SetDbValueDef($rsnew, $this->datecreated->CurrentValue, NULL, FALSE);

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

		// Add detail records
		if ($AddRow) {
			$DetailTblVar = explode(",", $this->getCurrentDetailTable());
			if (in_array("children_details", $DetailTblVar) && $GLOBALS["children_details"]->DetailAdd) {
				$GLOBALS["children_details"]->uid->setSessionValue($this->uid->CurrentValue); // Set master key
				if (!isset($GLOBALS["children_details_grid"])) $GLOBALS["children_details_grid"] = new cchildren_details_grid(); // Get detail page object
				$AddRow = $GLOBALS["children_details_grid"]->GridInsert();
				if (!$AddRow)
					$GLOBALS["children_details"]->uid->setSessionValue(""); // Clear master key if insert failed
			}
		}

		// Commit/Rollback transaction
		if ($this->getCurrentDetailTable() <> "") {
			if ($AddRow) {
				$conn->CommitTrans(); // Commit transaction
			} else {
				$conn->RollbackTrans(); // Rollback transaction
			}
		}
		if ($AddRow) {

			// Call Row Inserted event
			$rs = ($rsold == NULL) ? NULL : $rsold->fields;
			$this->Row_Inserted($rs, $rsnew);
		}
		return $AddRow;
	}

	// Set up master/detail based on QueryString
	function SetUpMasterParms() {
		$bValidMaster = FALSE;

		// Get the keys for master table
		if (isset($_GET[EW_TABLE_SHOW_MASTER])) {
			$sMasterTblVar = $_GET[EW_TABLE_SHOW_MASTER];
			if ($sMasterTblVar == "") {
				$bValidMaster = TRUE;
				$this->DbMasterFilter = "";
				$this->DbDetailFilter = "";
			}
			if ($sMasterTblVar == "comprehensivewill_tb") {
				$bValidMaster = TRUE;
				if (@$_GET["uid"] <> "") {
					$GLOBALS["comprehensivewill_tb"]->uid->setQueryStringValue($_GET["uid"]);
					$this->uid->setQueryStringValue($GLOBALS["comprehensivewill_tb"]->uid->QueryStringValue);
					$this->uid->setSessionValue($this->uid->QueryStringValue);
					if (!is_numeric($GLOBALS["comprehensivewill_tb"]->uid->QueryStringValue)) $bValidMaster = FALSE;
				} else {
					$bValidMaster = FALSE;
				}
			}
			if ($sMasterTblVar == "personal_info") {
				$bValidMaster = TRUE;
				if (@$_GET["uid"] <> "") {
					$GLOBALS["personal_info"]->uid->setQueryStringValue($_GET["uid"]);
					$this->uid->setQueryStringValue($GLOBALS["personal_info"]->uid->QueryStringValue);
					$this->uid->setSessionValue($this->uid->QueryStringValue);
					if (!is_numeric($GLOBALS["personal_info"]->uid->QueryStringValue)) $bValidMaster = FALSE;
				} else {
					$bValidMaster = FALSE;
				}
			}
			if ($sMasterTblVar == "premiumwill_tb") {
				$bValidMaster = TRUE;
				if (@$_GET["uid"] <> "") {
					$GLOBALS["premiumwill_tb"]->uid->setQueryStringValue($_GET["uid"]);
					$this->uid->setQueryStringValue($GLOBALS["premiumwill_tb"]->uid->QueryStringValue);
					$this->uid->setSessionValue($this->uid->QueryStringValue);
					if (!is_numeric($GLOBALS["premiumwill_tb"]->uid->QueryStringValue)) $bValidMaster = FALSE;
				} else {
					$bValidMaster = FALSE;
				}
			}
			if ($sMasterTblVar == "privatetrust_tb") {
				$bValidMaster = TRUE;
				if (@$_GET["uid"] <> "") {
					$GLOBALS["privatetrust_tb"]->uid->setQueryStringValue($_GET["uid"]);
					$this->uid->setQueryStringValue($GLOBALS["privatetrust_tb"]->uid->QueryStringValue);
					$this->uid->setSessionValue($this->uid->QueryStringValue);
					if (!is_numeric($GLOBALS["privatetrust_tb"]->uid->QueryStringValue)) $bValidMaster = FALSE;
				} else {
					$bValidMaster = FALSE;
				}
			}
		}
		if ($bValidMaster) {

			// Save current master table
			$this->setCurrentMasterTable($sMasterTblVar);

			// Reset start record counter (new master key)
			$this->StartRec = 1;
			$this->setStartRecordNumber($this->StartRec);

			// Clear previous master key from Session
			if ($sMasterTblVar <> "comprehensivewill_tb") {
				if ($this->uid->QueryStringValue == "") $this->uid->setSessionValue("");
			}
			if ($sMasterTblVar <> "personal_info") {
				if ($this->uid->QueryStringValue == "") $this->uid->setSessionValue("");
			}
			if ($sMasterTblVar <> "premiumwill_tb") {
				if ($this->uid->QueryStringValue == "") $this->uid->setSessionValue("");
			}
			if ($sMasterTblVar <> "privatetrust_tb") {
				if ($this->uid->QueryStringValue == "") $this->uid->setSessionValue("");
			}
		}
		$this->DbMasterFilter = $this->GetMasterFilter(); //  Get master filter
		$this->DbDetailFilter = $this->GetDetailFilter(); // Get detail filter
	}

	// Set up detail parms based on QueryString
	function SetUpDetailParms() {

		// Get the keys for master table
		if (isset($_GET[EW_TABLE_SHOW_DETAIL])) {
			$sDetailTblVar = $_GET[EW_TABLE_SHOW_DETAIL];
			$this->setCurrentDetailTable($sDetailTblVar);
		} else {
			$sDetailTblVar = $this->getCurrentDetailTable();
		}
		if ($sDetailTblVar <> "") {
			$DetailTblVar = explode(",", $sDetailTblVar);
			if (in_array("children_details", $DetailTblVar)) {
				if (!isset($GLOBALS["children_details_grid"]))
					$GLOBALS["children_details_grid"] = new cchildren_details_grid;
				if ($GLOBALS["children_details_grid"]->DetailAdd) {
					if ($this->CopyRecord)
						$GLOBALS["children_details_grid"]->CurrentMode = "copy";
					else
						$GLOBALS["children_details_grid"]->CurrentMode = "add";
					$GLOBALS["children_details_grid"]->CurrentAction = "gridadd";

					// Save current master table to detail table
					$GLOBALS["children_details_grid"]->setCurrentMasterTable($this->TableVar);
					$GLOBALS["children_details_grid"]->setStartRecordNumber(1);
					$GLOBALS["children_details_grid"]->uid->FldIsDetailKey = TRUE;
					$GLOBALS["children_details_grid"]->uid->CurrentValue = $this->uid->CurrentValue;
					$GLOBALS["children_details_grid"]->uid->setSessionValue($GLOBALS["children_details_grid"]->uid->CurrentValue);
				}
			}
		}
	}

	// Set up Breadcrumb
	function SetupBreadcrumb() {
		global $Breadcrumb, $Language;
		$Breadcrumb = new cBreadcrumb();
		$PageCaption = $this->TableCaption();
		$Breadcrumb->Add("list", "<span id=\"ewPageCaption\">" . $PageCaption . "</span>", "spouse_tblist.php", $this->TableVar);
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
if (!isset($spouse_tb_add)) $spouse_tb_add = new cspouse_tb_add();

// Page init
$spouse_tb_add->Page_Init();

// Page main
$spouse_tb_add->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$spouse_tb_add->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Page object
var spouse_tb_add = new ew_Page("spouse_tb_add");
spouse_tb_add.PageID = "add"; // Page ID
var EW_PAGE_ID = spouse_tb_add.PageID; // For backward compatibility

// Form object
var fspouse_tbadd = new ew_Form("fspouse_tbadd");

// Validate form
fspouse_tbadd.Validate = function() {
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
			elm = this.GetElements("x" + infix + "_uid");
			if (elm && !ew_HasValue(elm))
				return this.OnError(elm, ewLanguage.Phrase("EnterRequiredField") + " - <?php echo ew_JsEncode2($spouse_tb->uid->FldCaption()) ?>");
			elm = this.GetElements("x" + infix + "_uid");
			if (elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($spouse_tb->uid->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_marriagetype");
			if (elm && !ew_HasValue(elm))
				return this.OnError(elm, ewLanguage.Phrase("EnterRequiredField") + " - <?php echo ew_JsEncode2($spouse_tb->marriagetype->FldCaption()) ?>");
			elm = this.GetElements("x" + infix + "_marriageyear");
			if (elm && !ew_HasValue(elm))
				return this.OnError(elm, ewLanguage.Phrase("EnterRequiredField") + " - <?php echo ew_JsEncode2($spouse_tb->marriageyear->FldCaption()) ?>");
			elm = this.GetElements("x" + infix + "_marriagecert");
			if (elm && !ew_HasValue(elm))
				return this.OnError(elm, ewLanguage.Phrase("EnterRequiredField") + " - <?php echo ew_JsEncode2($spouse_tb->marriagecert->FldCaption()) ?>");

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
fspouse_tbadd.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
fspouse_tbadd.ValidateRequired = true;
<?php } else { ?>
fspouse_tbadd.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
// Form object for search

</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<?php $Breadcrumb->Render(); ?>
<?php $spouse_tb_add->ShowPageHeader(); ?>
<?php
$spouse_tb_add->ShowMessage();
?>
<form name="fspouse_tbadd" id="fspouse_tbadd" class="ewForm form-horizontal" action="<?php echo ew_CurrentPage() ?>" method="post">
<input type="hidden" name="t" value="spouse_tb">
<input type="hidden" name="a_add" id="a_add" value="A">
<table cellspacing="0" class="ewGrid"><tr><td>
<table id="tbl_spouse_tbadd" class="table table-bordered table-striped">
<?php if ($spouse_tb->uid->Visible) { // uid ?>
	<tr id="r_uid">
		<td><span id="elh_spouse_tb_uid"><?php echo $spouse_tb->uid->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></span></td>
		<td<?php echo $spouse_tb->uid->CellAttributes() ?>>
<?php if ($spouse_tb->uid->getSessionValue() <> "") { ?>
<span<?php echo $spouse_tb->uid->ViewAttributes() ?>>
<?php echo $spouse_tb->uid->ViewValue ?></span>
<input type="hidden" id="x_uid" name="x_uid" value="<?php echo ew_HtmlEncode($spouse_tb->uid->CurrentValue) ?>">
<?php } else { ?>
<input type="text" data-field="x_uid" name="x_uid" id="x_uid" size="30" placeholder="<?php echo $spouse_tb->uid->PlaceHolder ?>" value="<?php echo $spouse_tb->uid->EditValue ?>"<?php echo $spouse_tb->uid->EditAttributes() ?>>
<?php } ?>
<?php echo $spouse_tb->uid->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($spouse_tb->title->Visible) { // title ?>
	<tr id="r_title">
		<td><span id="elh_spouse_tb_title"><?php echo $spouse_tb->title->FldCaption() ?></span></td>
		<td<?php echo $spouse_tb->title->CellAttributes() ?>>
<span id="el_spouse_tb_title" class="control-group">
<input type="text" data-field="x_title" name="x_title" id="x_title" size="30" maxlength="10" placeholder="<?php echo $spouse_tb->title->PlaceHolder ?>" value="<?php echo $spouse_tb->title->EditValue ?>"<?php echo $spouse_tb->title->EditAttributes() ?>>
</span>
<?php echo $spouse_tb->title->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($spouse_tb->fullname->Visible) { // fullname ?>
	<tr id="r_fullname">
		<td><span id="elh_spouse_tb_fullname"><?php echo $spouse_tb->fullname->FldCaption() ?></span></td>
		<td<?php echo $spouse_tb->fullname->CellAttributes() ?>>
<span id="el_spouse_tb_fullname" class="control-group">
<input type="text" data-field="x_fullname" name="x_fullname" id="x_fullname" size="30" maxlength="70" placeholder="<?php echo $spouse_tb->fullname->PlaceHolder ?>" value="<?php echo $spouse_tb->fullname->EditValue ?>"<?php echo $spouse_tb->fullname->EditAttributes() ?>>
</span>
<?php echo $spouse_tb->fullname->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($spouse_tb->_email->Visible) { // email ?>
	<tr id="r__email">
		<td><span id="elh_spouse_tb__email"><?php echo $spouse_tb->_email->FldCaption() ?></span></td>
		<td<?php echo $spouse_tb->_email->CellAttributes() ?>>
<span id="el_spouse_tb__email" class="control-group">
<input type="text" data-field="x__email" name="x__email" id="x__email" size="30" maxlength="50" placeholder="<?php echo $spouse_tb->_email->PlaceHolder ?>" value="<?php echo $spouse_tb->_email->EditValue ?>"<?php echo $spouse_tb->_email->EditAttributes() ?>>
</span>
<?php echo $spouse_tb->_email->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($spouse_tb->dob->Visible) { // dob ?>
	<tr id="r_dob">
		<td><span id="elh_spouse_tb_dob"><?php echo $spouse_tb->dob->FldCaption() ?></span></td>
		<td<?php echo $spouse_tb->dob->CellAttributes() ?>>
<span id="el_spouse_tb_dob" class="control-group">
<input type="text" data-field="x_dob" name="x_dob" id="x_dob" size="30" maxlength="50" placeholder="<?php echo $spouse_tb->dob->PlaceHolder ?>" value="<?php echo $spouse_tb->dob->EditValue ?>"<?php echo $spouse_tb->dob->EditAttributes() ?>>
</span>
<?php echo $spouse_tb->dob->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($spouse_tb->phoneno->Visible) { // phoneno ?>
	<tr id="r_phoneno">
		<td><span id="elh_spouse_tb_phoneno"><?php echo $spouse_tb->phoneno->FldCaption() ?></span></td>
		<td<?php echo $spouse_tb->phoneno->CellAttributes() ?>>
<span id="el_spouse_tb_phoneno" class="control-group">
<input type="text" data-field="x_phoneno" name="x_phoneno" id="x_phoneno" size="30" maxlength="20" placeholder="<?php echo $spouse_tb->phoneno->PlaceHolder ?>" value="<?php echo $spouse_tb->phoneno->EditValue ?>"<?php echo $spouse_tb->phoneno->EditAttributes() ?>>
</span>
<?php echo $spouse_tb->phoneno->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($spouse_tb->altphoneno->Visible) { // altphoneno ?>
	<tr id="r_altphoneno">
		<td><span id="elh_spouse_tb_altphoneno"><?php echo $spouse_tb->altphoneno->FldCaption() ?></span></td>
		<td<?php echo $spouse_tb->altphoneno->CellAttributes() ?>>
<span id="el_spouse_tb_altphoneno" class="control-group">
<input type="text" data-field="x_altphoneno" name="x_altphoneno" id="x_altphoneno" size="30" maxlength="20" placeholder="<?php echo $spouse_tb->altphoneno->PlaceHolder ?>" value="<?php echo $spouse_tb->altphoneno->EditValue ?>"<?php echo $spouse_tb->altphoneno->EditAttributes() ?>>
</span>
<?php echo $spouse_tb->altphoneno->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($spouse_tb->addr->Visible) { // addr ?>
	<tr id="r_addr">
		<td><span id="elh_spouse_tb_addr"><?php echo $spouse_tb->addr->FldCaption() ?></span></td>
		<td<?php echo $spouse_tb->addr->CellAttributes() ?>>
<span id="el_spouse_tb_addr" class="control-group">
<textarea data-field="x_addr" name="x_addr" id="x_addr" cols="35" rows="4" placeholder="<?php echo $spouse_tb->addr->PlaceHolder ?>"<?php echo $spouse_tb->addr->EditAttributes() ?>><?php echo $spouse_tb->addr->EditValue ?></textarea>
</span>
<?php echo $spouse_tb->addr->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($spouse_tb->city->Visible) { // city ?>
	<tr id="r_city">
		<td><span id="elh_spouse_tb_city"><?php echo $spouse_tb->city->FldCaption() ?></span></td>
		<td<?php echo $spouse_tb->city->CellAttributes() ?>>
<span id="el_spouse_tb_city" class="control-group">
<input type="text" data-field="x_city" name="x_city" id="x_city" size="30" maxlength="50" placeholder="<?php echo $spouse_tb->city->PlaceHolder ?>" value="<?php echo $spouse_tb->city->EditValue ?>"<?php echo $spouse_tb->city->EditAttributes() ?>>
</span>
<?php echo $spouse_tb->city->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($spouse_tb->state->Visible) { // state ?>
	<tr id="r_state">
		<td><span id="elh_spouse_tb_state"><?php echo $spouse_tb->state->FldCaption() ?></span></td>
		<td<?php echo $spouse_tb->state->CellAttributes() ?>>
<span id="el_spouse_tb_state" class="control-group">
<input type="text" data-field="x_state" name="x_state" id="x_state" size="30" maxlength="50" placeholder="<?php echo $spouse_tb->state->PlaceHolder ?>" value="<?php echo $spouse_tb->state->EditValue ?>"<?php echo $spouse_tb->state->EditAttributes() ?>>
</span>
<?php echo $spouse_tb->state->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($spouse_tb->marriagetype->Visible) { // marriagetype ?>
	<tr id="r_marriagetype">
		<td><span id="elh_spouse_tb_marriagetype"><?php echo $spouse_tb->marriagetype->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></span></td>
		<td<?php echo $spouse_tb->marriagetype->CellAttributes() ?>>
<span id="el_spouse_tb_marriagetype" class="control-group">
<input type="text" data-field="x_marriagetype" name="x_marriagetype" id="x_marriagetype" size="30" maxlength="20" placeholder="<?php echo $spouse_tb->marriagetype->PlaceHolder ?>" value="<?php echo $spouse_tb->marriagetype->EditValue ?>"<?php echo $spouse_tb->marriagetype->EditAttributes() ?>>
</span>
<?php echo $spouse_tb->marriagetype->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($spouse_tb->marriageyear->Visible) { // marriageyear ?>
	<tr id="r_marriageyear">
		<td><span id="elh_spouse_tb_marriageyear"><?php echo $spouse_tb->marriageyear->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></span></td>
		<td<?php echo $spouse_tb->marriageyear->CellAttributes() ?>>
<span id="el_spouse_tb_marriageyear" class="control-group">
<input type="text" data-field="x_marriageyear" name="x_marriageyear" id="x_marriageyear" size="30" maxlength="10" placeholder="<?php echo $spouse_tb->marriageyear->PlaceHolder ?>" value="<?php echo $spouse_tb->marriageyear->EditValue ?>"<?php echo $spouse_tb->marriageyear->EditAttributes() ?>>
</span>
<?php echo $spouse_tb->marriageyear->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($spouse_tb->marriagecert->Visible) { // marriagecert ?>
	<tr id="r_marriagecert">
		<td><span id="elh_spouse_tb_marriagecert"><?php echo $spouse_tb->marriagecert->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></span></td>
		<td<?php echo $spouse_tb->marriagecert->CellAttributes() ?>>
<span id="el_spouse_tb_marriagecert" class="control-group">
<input type="text" data-field="x_marriagecert" name="x_marriagecert" id="x_marriagecert" size="30" maxlength="50" placeholder="<?php echo $spouse_tb->marriagecert->PlaceHolder ?>" value="<?php echo $spouse_tb->marriagecert->EditValue ?>"<?php echo $spouse_tb->marriagecert->EditAttributes() ?>>
</span>
<?php echo $spouse_tb->marriagecert->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($spouse_tb->citym->Visible) { // citym ?>
	<tr id="r_citym">
		<td><span id="elh_spouse_tb_citym"><?php echo $spouse_tb->citym->FldCaption() ?></span></td>
		<td<?php echo $spouse_tb->citym->CellAttributes() ?>>
<span id="el_spouse_tb_citym" class="control-group">
<input type="text" data-field="x_citym" name="x_citym" id="x_citym" size="30" maxlength="100" placeholder="<?php echo $spouse_tb->citym->PlaceHolder ?>" value="<?php echo $spouse_tb->citym->EditValue ?>"<?php echo $spouse_tb->citym->EditAttributes() ?>>
</span>
<?php echo $spouse_tb->citym->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($spouse_tb->countrym->Visible) { // countrym ?>
	<tr id="r_countrym">
		<td><span id="elh_spouse_tb_countrym"><?php echo $spouse_tb->countrym->FldCaption() ?></span></td>
		<td<?php echo $spouse_tb->countrym->CellAttributes() ?>>
<span id="el_spouse_tb_countrym" class="control-group">
<input type="text" data-field="x_countrym" name="x_countrym" id="x_countrym" size="30" maxlength="100" placeholder="<?php echo $spouse_tb->countrym->PlaceHolder ?>" value="<?php echo $spouse_tb->countrym->EditValue ?>"<?php echo $spouse_tb->countrym->EditAttributes() ?>>
</span>
<?php echo $spouse_tb->countrym->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($spouse_tb->datecreated->Visible) { // datecreated ?>
	<tr id="r_datecreated">
		<td><span id="elh_spouse_tb_datecreated"><?php echo $spouse_tb->datecreated->FldCaption() ?></span></td>
		<td<?php echo $spouse_tb->datecreated->CellAttributes() ?>>
<span id="el_spouse_tb_datecreated" class="control-group">
<input type="text" data-field="x_datecreated" name="x_datecreated" id="x_datecreated" placeholder="<?php echo $spouse_tb->datecreated->PlaceHolder ?>" value="<?php echo $spouse_tb->datecreated->EditValue ?>"<?php echo $spouse_tb->datecreated->EditAttributes() ?>>
</span>
<?php echo $spouse_tb->datecreated->CustomMsg ?></td>
	</tr>
<?php } ?>
</table>
</td></tr></table>
<?php
	if (in_array("children_details", explode(",", $spouse_tb->getCurrentDetailTable())) && $children_details->DetailAdd) {
?>
<?php include_once "children_detailsgrid.php" ?>
<?php } ?>
<button class="btn btn-primary ewButton" name="btnAction" id="btnAction" type="submit"><?php echo $Language->Phrase("AddBtn") ?></button>
</form>
<script type="text/javascript">
fspouse_tbadd.Init();
<?php if (EW_MOBILE_REFLOW && ew_IsMobile()) { ?>
ew_Reflow();
<?php } ?>
</script>
<?php
$spouse_tb_add->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$spouse_tb_add->Page_Terminate();
?>
