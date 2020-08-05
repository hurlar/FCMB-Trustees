<?php
if (session_id() == "") session_start(); // Initialize Session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg10.php" ?>
<?php include_once "ewmysql10.php" ?>
<?php include_once "phpfn10.php" ?>
<?php include_once "comprehensivewill_tbinfo.php" ?>
<?php include_once "adminusersinfo.php" ?>
<?php include_once "personal_infogridcls.php" ?>
<?php include_once "spouse_tbgridcls.php" ?>
<?php include_once "divorce_tbgridcls.php" ?>
<?php include_once "children_detailsgridcls.php" ?>
<?php include_once "beneficiary_dumpgridcls.php" ?>
<?php include_once "alt_beneficiarygridcls.php" ?>
<?php include_once "assets_tbgridcls.php" ?>
<?php include_once "overall_assetgridcls.php" ?>
<?php include_once "executor_tbgridcls.php" ?>
<?php include_once "trustee_tbgridcls.php" ?>
<?php include_once "witness_tbgridcls.php" ?>
<?php include_once "addinfo_tbgridcls.php" ?>
<?php include_once "userfn10.php" ?>
<?php

//
// Page class
//

$comprehensivewill_tb_add = NULL; // Initialize page object first

class ccomprehensivewill_tb_add extends ccomprehensivewill_tb {

	// Page ID
	var $PageID = 'add';

	// Project ID
	var $ProjectID = "{D9B361E7-B2C1-4293-B9B3-B581986A15CC}";

	// Table name
	var $TableName = 'comprehensivewill_tb';

	// Page object name
	var $PageObjName = 'comprehensivewill_tb_add';

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

		// Table object (comprehensivewill_tb)
		if (!isset($GLOBALS["comprehensivewill_tb"])) {
			$GLOBALS["comprehensivewill_tb"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["comprehensivewill_tb"];
		}

		// Table object (adminusers)
		if (!isset($GLOBALS['adminusers'])) $GLOBALS['adminusers'] = new cadminusers();

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'add', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'comprehensivewill_tb', TRUE);

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
					$this->Page_Terminate("comprehensivewill_tblist.php"); // No matching record, return to list
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
					if (ew_GetPageName($sReturnUrl) == "comprehensivewill_tbview.php")
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
		$this->willtype->CurrentValue = NULL;
		$this->willtype->OldValue = $this->willtype->CurrentValue;
		$this->fullname->CurrentValue = NULL;
		$this->fullname->OldValue = $this->fullname->CurrentValue;
		$this->address->CurrentValue = NULL;
		$this->address->OldValue = $this->address->CurrentValue;
		$this->_email->CurrentValue = NULL;
		$this->_email->OldValue = $this->_email->CurrentValue;
		$this->phoneno->CurrentValue = NULL;
		$this->phoneno->OldValue = $this->phoneno->CurrentValue;
		$this->aphoneno->CurrentValue = NULL;
		$this->aphoneno->OldValue = $this->aphoneno->CurrentValue;
		$this->gender->CurrentValue = NULL;
		$this->gender->OldValue = $this->gender->CurrentValue;
		$this->dob->CurrentValue = NULL;
		$this->dob->OldValue = $this->dob->CurrentValue;
		$this->state->CurrentValue = NULL;
		$this->state->OldValue = $this->state->CurrentValue;
		$this->nationality->CurrentValue = NULL;
		$this->nationality->OldValue = $this->nationality->CurrentValue;
		$this->lga->CurrentValue = NULL;
		$this->lga->OldValue = $this->lga->CurrentValue;
		$this->employmentstatus->CurrentValue = NULL;
		$this->employmentstatus->OldValue = $this->employmentstatus->CurrentValue;
		$this->employer->CurrentValue = NULL;
		$this->employer->OldValue = $this->employer->CurrentValue;
		$this->employerphone->CurrentValue = NULL;
		$this->employerphone->OldValue = $this->employerphone->CurrentValue;
		$this->employeraddr->CurrentValue = NULL;
		$this->employeraddr->OldValue = $this->employeraddr->CurrentValue;
		$this->maritalstatus->CurrentValue = NULL;
		$this->maritalstatus->OldValue = $this->maritalstatus->CurrentValue;
		$this->spname->CurrentValue = NULL;
		$this->spname->OldValue = $this->spname->CurrentValue;
		$this->spemail->CurrentValue = NULL;
		$this->spemail->OldValue = $this->spemail->CurrentValue;
		$this->spphone->CurrentValue = NULL;
		$this->spphone->OldValue = $this->spphone->CurrentValue;
		$this->sdob->CurrentValue = NULL;
		$this->sdob->OldValue = $this->sdob->CurrentValue;
		$this->spaddr->CurrentValue = NULL;
		$this->spaddr->OldValue = $this->spaddr->CurrentValue;
		$this->spcity->CurrentValue = NULL;
		$this->spcity->OldValue = $this->spcity->CurrentValue;
		$this->spstate->CurrentValue = NULL;
		$this->spstate->OldValue = $this->spstate->CurrentValue;
		$this->marriagetype->CurrentValue = NULL;
		$this->marriagetype->OldValue = $this->marriagetype->CurrentValue;
		$this->marriageyear->CurrentValue = NULL;
		$this->marriageyear->OldValue = $this->marriageyear->CurrentValue;
		$this->marriagecert->CurrentValue = NULL;
		$this->marriagecert->OldValue = $this->marriagecert->CurrentValue;
		$this->marriagecity->CurrentValue = NULL;
		$this->marriagecity->OldValue = $this->marriagecity->CurrentValue;
		$this->marriagecountry->CurrentValue = NULL;
		$this->marriagecountry->OldValue = $this->marriagecountry->CurrentValue;
		$this->divorce->CurrentValue = NULL;
		$this->divorce->OldValue = $this->divorce->CurrentValue;
		$this->divorceyear->CurrentValue = NULL;
		$this->divorceyear->OldValue = $this->divorceyear->CurrentValue;
		$this->addinfo->CurrentValue = NULL;
		$this->addinfo->OldValue = $this->addinfo->CurrentValue;
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
		if (!$this->willtype->FldIsDetailKey) {
			$this->willtype->setFormValue($objForm->GetValue("x_willtype"));
		}
		if (!$this->fullname->FldIsDetailKey) {
			$this->fullname->setFormValue($objForm->GetValue("x_fullname"));
		}
		if (!$this->address->FldIsDetailKey) {
			$this->address->setFormValue($objForm->GetValue("x_address"));
		}
		if (!$this->_email->FldIsDetailKey) {
			$this->_email->setFormValue($objForm->GetValue("x__email"));
		}
		if (!$this->phoneno->FldIsDetailKey) {
			$this->phoneno->setFormValue($objForm->GetValue("x_phoneno"));
		}
		if (!$this->aphoneno->FldIsDetailKey) {
			$this->aphoneno->setFormValue($objForm->GetValue("x_aphoneno"));
		}
		if (!$this->gender->FldIsDetailKey) {
			$this->gender->setFormValue($objForm->GetValue("x_gender"));
		}
		if (!$this->dob->FldIsDetailKey) {
			$this->dob->setFormValue($objForm->GetValue("x_dob"));
		}
		if (!$this->state->FldIsDetailKey) {
			$this->state->setFormValue($objForm->GetValue("x_state"));
		}
		if (!$this->nationality->FldIsDetailKey) {
			$this->nationality->setFormValue($objForm->GetValue("x_nationality"));
		}
		if (!$this->lga->FldIsDetailKey) {
			$this->lga->setFormValue($objForm->GetValue("x_lga"));
		}
		if (!$this->employmentstatus->FldIsDetailKey) {
			$this->employmentstatus->setFormValue($objForm->GetValue("x_employmentstatus"));
		}
		if (!$this->employer->FldIsDetailKey) {
			$this->employer->setFormValue($objForm->GetValue("x_employer"));
		}
		if (!$this->employerphone->FldIsDetailKey) {
			$this->employerphone->setFormValue($objForm->GetValue("x_employerphone"));
		}
		if (!$this->employeraddr->FldIsDetailKey) {
			$this->employeraddr->setFormValue($objForm->GetValue("x_employeraddr"));
		}
		if (!$this->maritalstatus->FldIsDetailKey) {
			$this->maritalstatus->setFormValue($objForm->GetValue("x_maritalstatus"));
		}
		if (!$this->spname->FldIsDetailKey) {
			$this->spname->setFormValue($objForm->GetValue("x_spname"));
		}
		if (!$this->spemail->FldIsDetailKey) {
			$this->spemail->setFormValue($objForm->GetValue("x_spemail"));
		}
		if (!$this->spphone->FldIsDetailKey) {
			$this->spphone->setFormValue($objForm->GetValue("x_spphone"));
		}
		if (!$this->sdob->FldIsDetailKey) {
			$this->sdob->setFormValue($objForm->GetValue("x_sdob"));
		}
		if (!$this->spaddr->FldIsDetailKey) {
			$this->spaddr->setFormValue($objForm->GetValue("x_spaddr"));
		}
		if (!$this->spcity->FldIsDetailKey) {
			$this->spcity->setFormValue($objForm->GetValue("x_spcity"));
		}
		if (!$this->spstate->FldIsDetailKey) {
			$this->spstate->setFormValue($objForm->GetValue("x_spstate"));
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
		if (!$this->marriagecity->FldIsDetailKey) {
			$this->marriagecity->setFormValue($objForm->GetValue("x_marriagecity"));
		}
		if (!$this->marriagecountry->FldIsDetailKey) {
			$this->marriagecountry->setFormValue($objForm->GetValue("x_marriagecountry"));
		}
		if (!$this->divorce->FldIsDetailKey) {
			$this->divorce->setFormValue($objForm->GetValue("x_divorce"));
		}
		if (!$this->divorceyear->FldIsDetailKey) {
			$this->divorceyear->setFormValue($objForm->GetValue("x_divorceyear"));
		}
		if (!$this->addinfo->FldIsDetailKey) {
			$this->addinfo->setFormValue($objForm->GetValue("x_addinfo"));
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
		$this->willtype->CurrentValue = $this->willtype->FormValue;
		$this->fullname->CurrentValue = $this->fullname->FormValue;
		$this->address->CurrentValue = $this->address->FormValue;
		$this->_email->CurrentValue = $this->_email->FormValue;
		$this->phoneno->CurrentValue = $this->phoneno->FormValue;
		$this->aphoneno->CurrentValue = $this->aphoneno->FormValue;
		$this->gender->CurrentValue = $this->gender->FormValue;
		$this->dob->CurrentValue = $this->dob->FormValue;
		$this->state->CurrentValue = $this->state->FormValue;
		$this->nationality->CurrentValue = $this->nationality->FormValue;
		$this->lga->CurrentValue = $this->lga->FormValue;
		$this->employmentstatus->CurrentValue = $this->employmentstatus->FormValue;
		$this->employer->CurrentValue = $this->employer->FormValue;
		$this->employerphone->CurrentValue = $this->employerphone->FormValue;
		$this->employeraddr->CurrentValue = $this->employeraddr->FormValue;
		$this->maritalstatus->CurrentValue = $this->maritalstatus->FormValue;
		$this->spname->CurrentValue = $this->spname->FormValue;
		$this->spemail->CurrentValue = $this->spemail->FormValue;
		$this->spphone->CurrentValue = $this->spphone->FormValue;
		$this->sdob->CurrentValue = $this->sdob->FormValue;
		$this->spaddr->CurrentValue = $this->spaddr->FormValue;
		$this->spcity->CurrentValue = $this->spcity->FormValue;
		$this->spstate->CurrentValue = $this->spstate->FormValue;
		$this->marriagetype->CurrentValue = $this->marriagetype->FormValue;
		$this->marriageyear->CurrentValue = $this->marriageyear->FormValue;
		$this->marriagecert->CurrentValue = $this->marriagecert->FormValue;
		$this->marriagecity->CurrentValue = $this->marriagecity->FormValue;
		$this->marriagecountry->CurrentValue = $this->marriagecountry->FormValue;
		$this->divorce->CurrentValue = $this->divorce->FormValue;
		$this->divorceyear->CurrentValue = $this->divorceyear->FormValue;
		$this->addinfo->CurrentValue = $this->addinfo->FormValue;
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
		$this->willtype->setDbValue($rs->fields('willtype'));
		$this->fullname->setDbValue($rs->fields('fullname'));
		$this->address->setDbValue($rs->fields('address'));
		$this->_email->setDbValue($rs->fields('email'));
		$this->phoneno->setDbValue($rs->fields('phoneno'));
		$this->aphoneno->setDbValue($rs->fields('aphoneno'));
		$this->gender->setDbValue($rs->fields('gender'));
		$this->dob->setDbValue($rs->fields('dob'));
		$this->state->setDbValue($rs->fields('state'));
		$this->nationality->setDbValue($rs->fields('nationality'));
		$this->lga->setDbValue($rs->fields('lga'));
		$this->employmentstatus->setDbValue($rs->fields('employmentstatus'));
		$this->employer->setDbValue($rs->fields('employer'));
		$this->employerphone->setDbValue($rs->fields('employerphone'));
		$this->employeraddr->setDbValue($rs->fields('employeraddr'));
		$this->maritalstatus->setDbValue($rs->fields('maritalstatus'));
		$this->spname->setDbValue($rs->fields('spname'));
		$this->spemail->setDbValue($rs->fields('spemail'));
		$this->spphone->setDbValue($rs->fields('spphone'));
		$this->sdob->setDbValue($rs->fields('sdob'));
		$this->spaddr->setDbValue($rs->fields('spaddr'));
		$this->spcity->setDbValue($rs->fields('spcity'));
		$this->spstate->setDbValue($rs->fields('spstate'));
		$this->marriagetype->setDbValue($rs->fields('marriagetype'));
		$this->marriageyear->setDbValue($rs->fields('marriageyear'));
		$this->marriagecert->setDbValue($rs->fields('marriagecert'));
		$this->marriagecity->setDbValue($rs->fields('marriagecity'));
		$this->marriagecountry->setDbValue($rs->fields('marriagecountry'));
		$this->divorce->setDbValue($rs->fields('divorce'));
		$this->divorceyear->setDbValue($rs->fields('divorceyear'));
		$this->addinfo->setDbValue($rs->fields('addinfo'));
		$this->datecreated->setDbValue($rs->fields('datecreated'));
	}

	// Load DbValue from recordset
	function LoadDbValues(&$rs) {
		if (!$rs || !is_array($rs) && $rs->EOF) return;
		$row = is_array($rs) ? $rs : $rs->fields;
		$this->id->DbValue = $row['id'];
		$this->uid->DbValue = $row['uid'];
		$this->willtype->DbValue = $row['willtype'];
		$this->fullname->DbValue = $row['fullname'];
		$this->address->DbValue = $row['address'];
		$this->_email->DbValue = $row['email'];
		$this->phoneno->DbValue = $row['phoneno'];
		$this->aphoneno->DbValue = $row['aphoneno'];
		$this->gender->DbValue = $row['gender'];
		$this->dob->DbValue = $row['dob'];
		$this->state->DbValue = $row['state'];
		$this->nationality->DbValue = $row['nationality'];
		$this->lga->DbValue = $row['lga'];
		$this->employmentstatus->DbValue = $row['employmentstatus'];
		$this->employer->DbValue = $row['employer'];
		$this->employerphone->DbValue = $row['employerphone'];
		$this->employeraddr->DbValue = $row['employeraddr'];
		$this->maritalstatus->DbValue = $row['maritalstatus'];
		$this->spname->DbValue = $row['spname'];
		$this->spemail->DbValue = $row['spemail'];
		$this->spphone->DbValue = $row['spphone'];
		$this->sdob->DbValue = $row['sdob'];
		$this->spaddr->DbValue = $row['spaddr'];
		$this->spcity->DbValue = $row['spcity'];
		$this->spstate->DbValue = $row['spstate'];
		$this->marriagetype->DbValue = $row['marriagetype'];
		$this->marriageyear->DbValue = $row['marriageyear'];
		$this->marriagecert->DbValue = $row['marriagecert'];
		$this->marriagecity->DbValue = $row['marriagecity'];
		$this->marriagecountry->DbValue = $row['marriagecountry'];
		$this->divorce->DbValue = $row['divorce'];
		$this->divorceyear->DbValue = $row['divorceyear'];
		$this->addinfo->DbValue = $row['addinfo'];
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
		// willtype
		// fullname
		// address
		// email
		// phoneno
		// aphoneno
		// gender
		// dob
		// state
		// nationality
		// lga
		// employmentstatus
		// employer
		// employerphone
		// employeraddr
		// maritalstatus
		// spname
		// spemail
		// spphone
		// sdob
		// spaddr
		// spcity
		// spstate
		// marriagetype
		// marriageyear
		// marriagecert
		// marriagecity
		// marriagecountry
		// divorce
		// divorceyear
		// addinfo
		// datecreated

		if ($this->RowType == EW_ROWTYPE_VIEW) { // View row

			// id
			$this->id->ViewValue = $this->id->CurrentValue;
			$this->id->ViewCustomAttributes = "";

			// uid
			$this->uid->ViewValue = $this->uid->CurrentValue;
			$this->uid->ViewCustomAttributes = "";

			// willtype
			$this->willtype->ViewValue = $this->willtype->CurrentValue;
			$this->willtype->ViewCustomAttributes = "";

			// fullname
			$this->fullname->ViewValue = $this->fullname->CurrentValue;
			$this->fullname->ViewCustomAttributes = "";

			// address
			$this->address->ViewValue = $this->address->CurrentValue;
			$this->address->ViewCustomAttributes = "";

			// email
			$this->_email->ViewValue = $this->_email->CurrentValue;
			$this->_email->ViewCustomAttributes = "";

			// phoneno
			$this->phoneno->ViewValue = $this->phoneno->CurrentValue;
			$this->phoneno->ViewCustomAttributes = "";

			// aphoneno
			$this->aphoneno->ViewValue = $this->aphoneno->CurrentValue;
			$this->aphoneno->ViewCustomAttributes = "";

			// gender
			$this->gender->ViewValue = $this->gender->CurrentValue;
			$this->gender->ViewCustomAttributes = "";

			// dob
			$this->dob->ViewValue = $this->dob->CurrentValue;
			$this->dob->ViewCustomAttributes = "";

			// state
			$this->state->ViewValue = $this->state->CurrentValue;
			$this->state->ViewCustomAttributes = "";

			// nationality
			$this->nationality->ViewValue = $this->nationality->CurrentValue;
			$this->nationality->ViewCustomAttributes = "";

			// lga
			$this->lga->ViewValue = $this->lga->CurrentValue;
			$this->lga->ViewCustomAttributes = "";

			// employmentstatus
			$this->employmentstatus->ViewValue = $this->employmentstatus->CurrentValue;
			$this->employmentstatus->ViewCustomAttributes = "";

			// employer
			$this->employer->ViewValue = $this->employer->CurrentValue;
			$this->employer->ViewCustomAttributes = "";

			// employerphone
			$this->employerphone->ViewValue = $this->employerphone->CurrentValue;
			$this->employerphone->ViewCustomAttributes = "";

			// employeraddr
			$this->employeraddr->ViewValue = $this->employeraddr->CurrentValue;
			$this->employeraddr->ViewCustomAttributes = "";

			// maritalstatus
			$this->maritalstatus->ViewValue = $this->maritalstatus->CurrentValue;
			$this->maritalstatus->ViewCustomAttributes = "";

			// spname
			$this->spname->ViewValue = $this->spname->CurrentValue;
			$this->spname->ViewCustomAttributes = "";

			// spemail
			$this->spemail->ViewValue = $this->spemail->CurrentValue;
			$this->spemail->ViewCustomAttributes = "";

			// spphone
			$this->spphone->ViewValue = $this->spphone->CurrentValue;
			$this->spphone->ViewCustomAttributes = "";

			// sdob
			$this->sdob->ViewValue = $this->sdob->CurrentValue;
			$this->sdob->ViewCustomAttributes = "";

			// spaddr
			$this->spaddr->ViewValue = $this->spaddr->CurrentValue;
			$this->spaddr->ViewCustomAttributes = "";

			// spcity
			$this->spcity->ViewValue = $this->spcity->CurrentValue;
			$this->spcity->ViewCustomAttributes = "";

			// spstate
			$this->spstate->ViewValue = $this->spstate->CurrentValue;
			$this->spstate->ViewCustomAttributes = "";

			// marriagetype
			$this->marriagetype->ViewValue = $this->marriagetype->CurrentValue;
			$this->marriagetype->ViewCustomAttributes = "";

			// marriageyear
			$this->marriageyear->ViewValue = $this->marriageyear->CurrentValue;
			$this->marriageyear->ViewCustomAttributes = "";

			// marriagecert
			$this->marriagecert->ViewValue = $this->marriagecert->CurrentValue;
			$this->marriagecert->ViewCustomAttributes = "";

			// marriagecity
			$this->marriagecity->ViewValue = $this->marriagecity->CurrentValue;
			$this->marriagecity->ViewCustomAttributes = "";

			// marriagecountry
			$this->marriagecountry->ViewValue = $this->marriagecountry->CurrentValue;
			$this->marriagecountry->ViewCustomAttributes = "";

			// divorce
			$this->divorce->ViewValue = $this->divorce->CurrentValue;
			$this->divorce->ViewCustomAttributes = "";

			// divorceyear
			$this->divorceyear->ViewValue = $this->divorceyear->CurrentValue;
			$this->divorceyear->ViewCustomAttributes = "";

			// addinfo
			$this->addinfo->ViewValue = $this->addinfo->CurrentValue;
			$this->addinfo->ViewCustomAttributes = "";

			// datecreated
			$this->datecreated->ViewValue = $this->datecreated->CurrentValue;
			$this->datecreated->ViewCustomAttributes = "";

			// uid
			$this->uid->LinkCustomAttributes = "";
			$this->uid->HrefValue = "";
			$this->uid->TooltipValue = "";

			// willtype
			$this->willtype->LinkCustomAttributes = "";
			$this->willtype->HrefValue = "";
			$this->willtype->TooltipValue = "";

			// fullname
			$this->fullname->LinkCustomAttributes = "";
			if (!ew_Empty($this->uid->CurrentValue)) {
				$this->fullname->HrefValue = "http://tisvdigital.com/trustees/portal/admincomprehensivewill-preview.php?a=" . ((!empty($this->uid->ViewValue)) ? $this->uid->ViewValue : $this->uid->CurrentValue); // Add prefix/suffix
				$this->fullname->LinkAttrs["target"] = "_blank"; // Add target
				if ($this->Export <> "") $this->fullname->HrefValue = ew_ConvertFullUrl($this->fullname->HrefValue);
			} else {
				$this->fullname->HrefValue = "";
			}
			$this->fullname->TooltipValue = "";

			// address
			$this->address->LinkCustomAttributes = "";
			$this->address->HrefValue = "";
			$this->address->TooltipValue = "";

			// email
			$this->_email->LinkCustomAttributes = "";
			$this->_email->HrefValue = "";
			$this->_email->TooltipValue = "";

			// phoneno
			$this->phoneno->LinkCustomAttributes = "";
			$this->phoneno->HrefValue = "";
			$this->phoneno->TooltipValue = "";

			// aphoneno
			$this->aphoneno->LinkCustomAttributes = "";
			$this->aphoneno->HrefValue = "";
			$this->aphoneno->TooltipValue = "";

			// gender
			$this->gender->LinkCustomAttributes = "";
			$this->gender->HrefValue = "";
			$this->gender->TooltipValue = "";

			// dob
			$this->dob->LinkCustomAttributes = "";
			$this->dob->HrefValue = "";
			$this->dob->TooltipValue = "";

			// state
			$this->state->LinkCustomAttributes = "";
			$this->state->HrefValue = "";
			$this->state->TooltipValue = "";

			// nationality
			$this->nationality->LinkCustomAttributes = "";
			$this->nationality->HrefValue = "";
			$this->nationality->TooltipValue = "";

			// lga
			$this->lga->LinkCustomAttributes = "";
			$this->lga->HrefValue = "";
			$this->lga->TooltipValue = "";

			// employmentstatus
			$this->employmentstatus->LinkCustomAttributes = "";
			$this->employmentstatus->HrefValue = "";
			$this->employmentstatus->TooltipValue = "";

			// employer
			$this->employer->LinkCustomAttributes = "";
			$this->employer->HrefValue = "";
			$this->employer->TooltipValue = "";

			// employerphone
			$this->employerphone->LinkCustomAttributes = "";
			$this->employerphone->HrefValue = "";
			$this->employerphone->TooltipValue = "";

			// employeraddr
			$this->employeraddr->LinkCustomAttributes = "";
			$this->employeraddr->HrefValue = "";
			$this->employeraddr->TooltipValue = "";

			// maritalstatus
			$this->maritalstatus->LinkCustomAttributes = "";
			$this->maritalstatus->HrefValue = "";
			$this->maritalstatus->TooltipValue = "";

			// spname
			$this->spname->LinkCustomAttributes = "";
			$this->spname->HrefValue = "";
			$this->spname->TooltipValue = "";

			// spemail
			$this->spemail->LinkCustomAttributes = "";
			$this->spemail->HrefValue = "";
			$this->spemail->TooltipValue = "";

			// spphone
			$this->spphone->LinkCustomAttributes = "";
			$this->spphone->HrefValue = "";
			$this->spphone->TooltipValue = "";

			// sdob
			$this->sdob->LinkCustomAttributes = "";
			$this->sdob->HrefValue = "";
			$this->sdob->TooltipValue = "";

			// spaddr
			$this->spaddr->LinkCustomAttributes = "";
			$this->spaddr->HrefValue = "";
			$this->spaddr->TooltipValue = "";

			// spcity
			$this->spcity->LinkCustomAttributes = "";
			$this->spcity->HrefValue = "";
			$this->spcity->TooltipValue = "";

			// spstate
			$this->spstate->LinkCustomAttributes = "";
			$this->spstate->HrefValue = "";
			$this->spstate->TooltipValue = "";

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

			// marriagecity
			$this->marriagecity->LinkCustomAttributes = "";
			$this->marriagecity->HrefValue = "";
			$this->marriagecity->TooltipValue = "";

			// marriagecountry
			$this->marriagecountry->LinkCustomAttributes = "";
			$this->marriagecountry->HrefValue = "";
			$this->marriagecountry->TooltipValue = "";

			// divorce
			$this->divorce->LinkCustomAttributes = "";
			$this->divorce->HrefValue = "";
			$this->divorce->TooltipValue = "";

			// divorceyear
			$this->divorceyear->LinkCustomAttributes = "";
			$this->divorceyear->HrefValue = "";
			$this->divorceyear->TooltipValue = "";

			// addinfo
			$this->addinfo->LinkCustomAttributes = "";
			$this->addinfo->HrefValue = "";
			$this->addinfo->TooltipValue = "";

			// datecreated
			$this->datecreated->LinkCustomAttributes = "";
			$this->datecreated->HrefValue = "";
			$this->datecreated->TooltipValue = "";
		} elseif ($this->RowType == EW_ROWTYPE_ADD) { // Add row

			// uid
			$this->uid->EditCustomAttributes = "";
			$this->uid->EditValue = ew_HtmlEncode($this->uid->CurrentValue);
			$this->uid->PlaceHolder = ew_HtmlEncode(ew_RemoveHtml($this->uid->FldCaption()));

			// willtype
			$this->willtype->EditCustomAttributes = "style='width:97%' ";
			$this->willtype->EditValue = ew_HtmlEncode($this->willtype->CurrentValue);
			$this->willtype->PlaceHolder = ew_HtmlEncode(ew_RemoveHtml($this->willtype->FldCaption()));

			// fullname
			$this->fullname->EditCustomAttributes = "style='width:97%' ";
			$this->fullname->EditValue = ew_HtmlEncode($this->fullname->CurrentValue);
			$this->fullname->PlaceHolder = ew_HtmlEncode(ew_RemoveHtml($this->fullname->FldCaption()));

			// address
			$this->address->EditCustomAttributes = "style='width:97%' ";
			$this->address->EditValue = $this->address->CurrentValue;
			$this->address->PlaceHolder = ew_HtmlEncode(ew_RemoveHtml($this->address->FldCaption()));

			// email
			$this->_email->EditCustomAttributes = "style='width:97%' ";
			$this->_email->EditValue = ew_HtmlEncode($this->_email->CurrentValue);
			$this->_email->PlaceHolder = ew_HtmlEncode(ew_RemoveHtml($this->_email->FldCaption()));

			// phoneno
			$this->phoneno->EditCustomAttributes = "style='width:97%' ";
			$this->phoneno->EditValue = ew_HtmlEncode($this->phoneno->CurrentValue);
			$this->phoneno->PlaceHolder = ew_HtmlEncode(ew_RemoveHtml($this->phoneno->FldCaption()));

			// aphoneno
			$this->aphoneno->EditCustomAttributes = "style='width:97%' ";
			$this->aphoneno->EditValue = ew_HtmlEncode($this->aphoneno->CurrentValue);
			$this->aphoneno->PlaceHolder = ew_HtmlEncode(ew_RemoveHtml($this->aphoneno->FldCaption()));

			// gender
			$this->gender->EditCustomAttributes = "style='width:97%' ";
			$this->gender->EditValue = ew_HtmlEncode($this->gender->CurrentValue);
			$this->gender->PlaceHolder = ew_HtmlEncode(ew_RemoveHtml($this->gender->FldCaption()));

			// dob
			$this->dob->EditCustomAttributes = "style='width:97%' ";
			$this->dob->EditValue = ew_HtmlEncode($this->dob->CurrentValue);
			$this->dob->PlaceHolder = ew_HtmlEncode(ew_RemoveHtml($this->dob->FldCaption()));

			// state
			$this->state->EditCustomAttributes = "style='width:97%' ";
			$this->state->EditValue = ew_HtmlEncode($this->state->CurrentValue);
			$this->state->PlaceHolder = ew_HtmlEncode(ew_RemoveHtml($this->state->FldCaption()));

			// nationality
			$this->nationality->EditCustomAttributes = "style='width:97%' ";
			$this->nationality->EditValue = ew_HtmlEncode($this->nationality->CurrentValue);
			$this->nationality->PlaceHolder = ew_HtmlEncode(ew_RemoveHtml($this->nationality->FldCaption()));

			// lga
			$this->lga->EditCustomAttributes = "style='width:97%' ";
			$this->lga->EditValue = ew_HtmlEncode($this->lga->CurrentValue);
			$this->lga->PlaceHolder = ew_HtmlEncode(ew_RemoveHtml($this->lga->FldCaption()));

			// employmentstatus
			$this->employmentstatus->EditCustomAttributes = "style='width:97%' ";
			$this->employmentstatus->EditValue = ew_HtmlEncode($this->employmentstatus->CurrentValue);
			$this->employmentstatus->PlaceHolder = ew_HtmlEncode(ew_RemoveHtml($this->employmentstatus->FldCaption()));

			// employer
			$this->employer->EditCustomAttributes = "style='width:97%' ";
			$this->employer->EditValue = $this->employer->CurrentValue;
			$this->employer->PlaceHolder = ew_HtmlEncode(ew_RemoveHtml($this->employer->FldCaption()));

			// employerphone
			$this->employerphone->EditCustomAttributes = "style='width:97%' ";
			$this->employerphone->EditValue = ew_HtmlEncode($this->employerphone->CurrentValue);
			$this->employerphone->PlaceHolder = ew_HtmlEncode(ew_RemoveHtml($this->employerphone->FldCaption()));

			// employeraddr
			$this->employeraddr->EditCustomAttributes = "style='width:97%' ";
			$this->employeraddr->EditValue = $this->employeraddr->CurrentValue;
			$this->employeraddr->PlaceHolder = ew_HtmlEncode(ew_RemoveHtml($this->employeraddr->FldCaption()));

			// maritalstatus
			$this->maritalstatus->EditCustomAttributes = "style='width:97%' ";
			$this->maritalstatus->EditValue = ew_HtmlEncode($this->maritalstatus->CurrentValue);
			$this->maritalstatus->PlaceHolder = ew_HtmlEncode(ew_RemoveHtml($this->maritalstatus->FldCaption()));

			// spname
			$this->spname->EditCustomAttributes = "style='width:97%' ";
			$this->spname->EditValue = ew_HtmlEncode($this->spname->CurrentValue);
			$this->spname->PlaceHolder = ew_HtmlEncode(ew_RemoveHtml($this->spname->FldCaption()));

			// spemail
			$this->spemail->EditCustomAttributes = "style='width:97%' ";
			$this->spemail->EditValue = ew_HtmlEncode($this->spemail->CurrentValue);
			$this->spemail->PlaceHolder = ew_HtmlEncode(ew_RemoveHtml($this->spemail->FldCaption()));

			// spphone
			$this->spphone->EditCustomAttributes = "style='width:97%' ";
			$this->spphone->EditValue = ew_HtmlEncode($this->spphone->CurrentValue);
			$this->spphone->PlaceHolder = ew_HtmlEncode(ew_RemoveHtml($this->spphone->FldCaption()));

			// sdob
			$this->sdob->EditCustomAttributes = "style='width:97%' ";
			$this->sdob->EditValue = ew_HtmlEncode($this->sdob->CurrentValue);
			$this->sdob->PlaceHolder = ew_HtmlEncode(ew_RemoveHtml($this->sdob->FldCaption()));

			// spaddr
			$this->spaddr->EditCustomAttributes = "style='width:97%' ";
			$this->spaddr->EditValue = $this->spaddr->CurrentValue;
			$this->spaddr->PlaceHolder = ew_HtmlEncode(ew_RemoveHtml($this->spaddr->FldCaption()));

			// spcity
			$this->spcity->EditCustomAttributes = "style='width:97%' ";
			$this->spcity->EditValue = ew_HtmlEncode($this->spcity->CurrentValue);
			$this->spcity->PlaceHolder = ew_HtmlEncode(ew_RemoveHtml($this->spcity->FldCaption()));

			// spstate
			$this->spstate->EditCustomAttributes = "style='width:97%' ";
			$this->spstate->EditValue = ew_HtmlEncode($this->spstate->CurrentValue);
			$this->spstate->PlaceHolder = ew_HtmlEncode(ew_RemoveHtml($this->spstate->FldCaption()));

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

			// marriagecity
			$this->marriagecity->EditCustomAttributes = "style='width:97%' ";
			$this->marriagecity->EditValue = ew_HtmlEncode($this->marriagecity->CurrentValue);
			$this->marriagecity->PlaceHolder = ew_HtmlEncode(ew_RemoveHtml($this->marriagecity->FldCaption()));

			// marriagecountry
			$this->marriagecountry->EditCustomAttributes = "style='width:97%' ";
			$this->marriagecountry->EditValue = ew_HtmlEncode($this->marriagecountry->CurrentValue);
			$this->marriagecountry->PlaceHolder = ew_HtmlEncode(ew_RemoveHtml($this->marriagecountry->FldCaption()));

			// divorce
			$this->divorce->EditCustomAttributes = "style='width:97%' ";
			$this->divorce->EditValue = ew_HtmlEncode($this->divorce->CurrentValue);
			$this->divorce->PlaceHolder = ew_HtmlEncode(ew_RemoveHtml($this->divorce->FldCaption()));

			// divorceyear
			$this->divorceyear->EditCustomAttributes = "style='width:97%' ";
			$this->divorceyear->EditValue = ew_HtmlEncode($this->divorceyear->CurrentValue);
			$this->divorceyear->PlaceHolder = ew_HtmlEncode(ew_RemoveHtml($this->divorceyear->FldCaption()));

			// addinfo
			$this->addinfo->EditCustomAttributes = "style='width:97%' ";
			$this->addinfo->EditValue = $this->addinfo->CurrentValue;
			$this->addinfo->PlaceHolder = ew_HtmlEncode(ew_RemoveHtml($this->addinfo->FldCaption()));

			// datecreated
			$this->datecreated->EditCustomAttributes = "";
			$this->datecreated->EditValue = ew_HtmlEncode($this->datecreated->CurrentValue);
			$this->datecreated->PlaceHolder = ew_HtmlEncode(ew_RemoveHtml($this->datecreated->FldCaption()));

			// Edit refer script
			// uid

			$this->uid->HrefValue = "";

			// willtype
			$this->willtype->HrefValue = "";

			// fullname
			if (!ew_Empty($this->uid->CurrentValue)) {
				$this->fullname->HrefValue = "http://tisvdigital.com/trustees/portal/admincomprehensivewill-preview.php?a=" . ((!empty($this->uid->EditValue)) ? $this->uid->EditValue : $this->uid->CurrentValue); // Add prefix/suffix
				$this->fullname->LinkAttrs["target"] = "_blank"; // Add target
				if ($this->Export <> "") $this->fullname->HrefValue = ew_ConvertFullUrl($this->fullname->HrefValue);
			} else {
				$this->fullname->HrefValue = "";
			}

			// address
			$this->address->HrefValue = "";

			// email
			$this->_email->HrefValue = "";

			// phoneno
			$this->phoneno->HrefValue = "";

			// aphoneno
			$this->aphoneno->HrefValue = "";

			// gender
			$this->gender->HrefValue = "";

			// dob
			$this->dob->HrefValue = "";

			// state
			$this->state->HrefValue = "";

			// nationality
			$this->nationality->HrefValue = "";

			// lga
			$this->lga->HrefValue = "";

			// employmentstatus
			$this->employmentstatus->HrefValue = "";

			// employer
			$this->employer->HrefValue = "";

			// employerphone
			$this->employerphone->HrefValue = "";

			// employeraddr
			$this->employeraddr->HrefValue = "";

			// maritalstatus
			$this->maritalstatus->HrefValue = "";

			// spname
			$this->spname->HrefValue = "";

			// spemail
			$this->spemail->HrefValue = "";

			// spphone
			$this->spphone->HrefValue = "";

			// sdob
			$this->sdob->HrefValue = "";

			// spaddr
			$this->spaddr->HrefValue = "";

			// spcity
			$this->spcity->HrefValue = "";

			// spstate
			$this->spstate->HrefValue = "";

			// marriagetype
			$this->marriagetype->HrefValue = "";

			// marriageyear
			$this->marriageyear->HrefValue = "";

			// marriagecert
			$this->marriagecert->HrefValue = "";

			// marriagecity
			$this->marriagecity->HrefValue = "";

			// marriagecountry
			$this->marriagecountry->HrefValue = "";

			// divorce
			$this->divorce->HrefValue = "";

			// divorceyear
			$this->divorceyear->HrefValue = "";

			// addinfo
			$this->addinfo->HrefValue = "";

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
		if (!ew_CheckInteger($this->uid->FormValue)) {
			ew_AddMessage($gsFormError, $this->uid->FldErrMsg());
		}

		// Validate detail grid
		$DetailTblVar = explode(",", $this->getCurrentDetailTable());
		if (in_array("personal_info", $DetailTblVar) && $GLOBALS["personal_info"]->DetailAdd) {
			if (!isset($GLOBALS["personal_info_grid"])) $GLOBALS["personal_info_grid"] = new cpersonal_info_grid(); // get detail page object
			$GLOBALS["personal_info_grid"]->ValidateGridForm();
		}
		if (in_array("spouse_tb", $DetailTblVar) && $GLOBALS["spouse_tb"]->DetailAdd) {
			if (!isset($GLOBALS["spouse_tb_grid"])) $GLOBALS["spouse_tb_grid"] = new cspouse_tb_grid(); // get detail page object
			$GLOBALS["spouse_tb_grid"]->ValidateGridForm();
		}
		if (in_array("divorce_tb", $DetailTblVar) && $GLOBALS["divorce_tb"]->DetailAdd) {
			if (!isset($GLOBALS["divorce_tb_grid"])) $GLOBALS["divorce_tb_grid"] = new cdivorce_tb_grid(); // get detail page object
			$GLOBALS["divorce_tb_grid"]->ValidateGridForm();
		}
		if (in_array("children_details", $DetailTblVar) && $GLOBALS["children_details"]->DetailAdd) {
			if (!isset($GLOBALS["children_details_grid"])) $GLOBALS["children_details_grid"] = new cchildren_details_grid(); // get detail page object
			$GLOBALS["children_details_grid"]->ValidateGridForm();
		}
		if (in_array("beneficiary_dump", $DetailTblVar) && $GLOBALS["beneficiary_dump"]->DetailAdd) {
			if (!isset($GLOBALS["beneficiary_dump_grid"])) $GLOBALS["beneficiary_dump_grid"] = new cbeneficiary_dump_grid(); // get detail page object
			$GLOBALS["beneficiary_dump_grid"]->ValidateGridForm();
		}
		if (in_array("alt_beneficiary", $DetailTblVar) && $GLOBALS["alt_beneficiary"]->DetailAdd) {
			if (!isset($GLOBALS["alt_beneficiary_grid"])) $GLOBALS["alt_beneficiary_grid"] = new calt_beneficiary_grid(); // get detail page object
			$GLOBALS["alt_beneficiary_grid"]->ValidateGridForm();
		}
		if (in_array("assets_tb", $DetailTblVar) && $GLOBALS["assets_tb"]->DetailAdd) {
			if (!isset($GLOBALS["assets_tb_grid"])) $GLOBALS["assets_tb_grid"] = new cassets_tb_grid(); // get detail page object
			$GLOBALS["assets_tb_grid"]->ValidateGridForm();
		}
		if (in_array("overall_asset", $DetailTblVar) && $GLOBALS["overall_asset"]->DetailAdd) {
			if (!isset($GLOBALS["overall_asset_grid"])) $GLOBALS["overall_asset_grid"] = new coverall_asset_grid(); // get detail page object
			$GLOBALS["overall_asset_grid"]->ValidateGridForm();
		}
		if (in_array("executor_tb", $DetailTblVar) && $GLOBALS["executor_tb"]->DetailAdd) {
			if (!isset($GLOBALS["executor_tb_grid"])) $GLOBALS["executor_tb_grid"] = new cexecutor_tb_grid(); // get detail page object
			$GLOBALS["executor_tb_grid"]->ValidateGridForm();
		}
		if (in_array("trustee_tb", $DetailTblVar) && $GLOBALS["trustee_tb"]->DetailAdd) {
			if (!isset($GLOBALS["trustee_tb_grid"])) $GLOBALS["trustee_tb_grid"] = new ctrustee_tb_grid(); // get detail page object
			$GLOBALS["trustee_tb_grid"]->ValidateGridForm();
		}
		if (in_array("witness_tb", $DetailTblVar) && $GLOBALS["witness_tb"]->DetailAdd) {
			if (!isset($GLOBALS["witness_tb_grid"])) $GLOBALS["witness_tb_grid"] = new cwitness_tb_grid(); // get detail page object
			$GLOBALS["witness_tb_grid"]->ValidateGridForm();
		}
		if (in_array("addinfo_tb", $DetailTblVar) && $GLOBALS["addinfo_tb"]->DetailAdd) {
			if (!isset($GLOBALS["addinfo_tb_grid"])) $GLOBALS["addinfo_tb_grid"] = new caddinfo_tb_grid(); // get detail page object
			$GLOBALS["addinfo_tb_grid"]->ValidateGridForm();
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

		// Begin transaction
		if ($this->getCurrentDetailTable() <> "")
			$conn->BeginTrans();

		// Load db values from rsold
		if ($rsold) {
			$this->LoadDbValues($rsold);
		}
		$rsnew = array();

		// uid
		$this->uid->SetDbValueDef($rsnew, $this->uid->CurrentValue, NULL, FALSE);

		// willtype
		$this->willtype->SetDbValueDef($rsnew, $this->willtype->CurrentValue, NULL, FALSE);

		// fullname
		$this->fullname->SetDbValueDef($rsnew, $this->fullname->CurrentValue, NULL, FALSE);

		// address
		$this->address->SetDbValueDef($rsnew, $this->address->CurrentValue, NULL, FALSE);

		// email
		$this->_email->SetDbValueDef($rsnew, $this->_email->CurrentValue, NULL, FALSE);

		// phoneno
		$this->phoneno->SetDbValueDef($rsnew, $this->phoneno->CurrentValue, NULL, FALSE);

		// aphoneno
		$this->aphoneno->SetDbValueDef($rsnew, $this->aphoneno->CurrentValue, NULL, FALSE);

		// gender
		$this->gender->SetDbValueDef($rsnew, $this->gender->CurrentValue, NULL, FALSE);

		// dob
		$this->dob->SetDbValueDef($rsnew, $this->dob->CurrentValue, NULL, FALSE);

		// state
		$this->state->SetDbValueDef($rsnew, $this->state->CurrentValue, NULL, FALSE);

		// nationality
		$this->nationality->SetDbValueDef($rsnew, $this->nationality->CurrentValue, NULL, FALSE);

		// lga
		$this->lga->SetDbValueDef($rsnew, $this->lga->CurrentValue, NULL, FALSE);

		// employmentstatus
		$this->employmentstatus->SetDbValueDef($rsnew, $this->employmentstatus->CurrentValue, NULL, FALSE);

		// employer
		$this->employer->SetDbValueDef($rsnew, $this->employer->CurrentValue, NULL, FALSE);

		// employerphone
		$this->employerphone->SetDbValueDef($rsnew, $this->employerphone->CurrentValue, NULL, FALSE);

		// employeraddr
		$this->employeraddr->SetDbValueDef($rsnew, $this->employeraddr->CurrentValue, NULL, FALSE);

		// maritalstatus
		$this->maritalstatus->SetDbValueDef($rsnew, $this->maritalstatus->CurrentValue, NULL, FALSE);

		// spname
		$this->spname->SetDbValueDef($rsnew, $this->spname->CurrentValue, NULL, FALSE);

		// spemail
		$this->spemail->SetDbValueDef($rsnew, $this->spemail->CurrentValue, NULL, FALSE);

		// spphone
		$this->spphone->SetDbValueDef($rsnew, $this->spphone->CurrentValue, NULL, FALSE);

		// sdob
		$this->sdob->SetDbValueDef($rsnew, $this->sdob->CurrentValue, NULL, FALSE);

		// spaddr
		$this->spaddr->SetDbValueDef($rsnew, $this->spaddr->CurrentValue, NULL, FALSE);

		// spcity
		$this->spcity->SetDbValueDef($rsnew, $this->spcity->CurrentValue, NULL, FALSE);

		// spstate
		$this->spstate->SetDbValueDef($rsnew, $this->spstate->CurrentValue, NULL, FALSE);

		// marriagetype
		$this->marriagetype->SetDbValueDef($rsnew, $this->marriagetype->CurrentValue, NULL, FALSE);

		// marriageyear
		$this->marriageyear->SetDbValueDef($rsnew, $this->marriageyear->CurrentValue, NULL, FALSE);

		// marriagecert
		$this->marriagecert->SetDbValueDef($rsnew, $this->marriagecert->CurrentValue, NULL, FALSE);

		// marriagecity
		$this->marriagecity->SetDbValueDef($rsnew, $this->marriagecity->CurrentValue, NULL, FALSE);

		// marriagecountry
		$this->marriagecountry->SetDbValueDef($rsnew, $this->marriagecountry->CurrentValue, NULL, FALSE);

		// divorce
		$this->divorce->SetDbValueDef($rsnew, $this->divorce->CurrentValue, NULL, FALSE);

		// divorceyear
		$this->divorceyear->SetDbValueDef($rsnew, $this->divorceyear->CurrentValue, NULL, FALSE);

		// addinfo
		$this->addinfo->SetDbValueDef($rsnew, $this->addinfo->CurrentValue, NULL, FALSE);

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
			if (in_array("personal_info", $DetailTblVar) && $GLOBALS["personal_info"]->DetailAdd) {
				$GLOBALS["personal_info"]->uid->setSessionValue($this->uid->CurrentValue); // Set master key
				if (!isset($GLOBALS["personal_info_grid"])) $GLOBALS["personal_info_grid"] = new cpersonal_info_grid(); // Get detail page object
				$AddRow = $GLOBALS["personal_info_grid"]->GridInsert();
				if (!$AddRow)
					$GLOBALS["personal_info"]->uid->setSessionValue(""); // Clear master key if insert failed
			}
			if (in_array("spouse_tb", $DetailTblVar) && $GLOBALS["spouse_tb"]->DetailAdd) {
				$GLOBALS["spouse_tb"]->uid->setSessionValue($this->uid->CurrentValue); // Set master key
				if (!isset($GLOBALS["spouse_tb_grid"])) $GLOBALS["spouse_tb_grid"] = new cspouse_tb_grid(); // Get detail page object
				$AddRow = $GLOBALS["spouse_tb_grid"]->GridInsert();
				if (!$AddRow)
					$GLOBALS["spouse_tb"]->uid->setSessionValue(""); // Clear master key if insert failed
			}
			if (in_array("divorce_tb", $DetailTblVar) && $GLOBALS["divorce_tb"]->DetailAdd) {
				$GLOBALS["divorce_tb"]->uid->setSessionValue($this->uid->CurrentValue); // Set master key
				if (!isset($GLOBALS["divorce_tb_grid"])) $GLOBALS["divorce_tb_grid"] = new cdivorce_tb_grid(); // Get detail page object
				$AddRow = $GLOBALS["divorce_tb_grid"]->GridInsert();
				if (!$AddRow)
					$GLOBALS["divorce_tb"]->uid->setSessionValue(""); // Clear master key if insert failed
			}
			if (in_array("children_details", $DetailTblVar) && $GLOBALS["children_details"]->DetailAdd) {
				$GLOBALS["children_details"]->uid->setSessionValue($this->uid->CurrentValue); // Set master key
				if (!isset($GLOBALS["children_details_grid"])) $GLOBALS["children_details_grid"] = new cchildren_details_grid(); // Get detail page object
				$AddRow = $GLOBALS["children_details_grid"]->GridInsert();
				if (!$AddRow)
					$GLOBALS["children_details"]->uid->setSessionValue(""); // Clear master key if insert failed
			}
			if (in_array("beneficiary_dump", $DetailTblVar) && $GLOBALS["beneficiary_dump"]->DetailAdd) {
				$GLOBALS["beneficiary_dump"]->uid->setSessionValue($this->uid->CurrentValue); // Set master key
				if (!isset($GLOBALS["beneficiary_dump_grid"])) $GLOBALS["beneficiary_dump_grid"] = new cbeneficiary_dump_grid(); // Get detail page object
				$AddRow = $GLOBALS["beneficiary_dump_grid"]->GridInsert();
				if (!$AddRow)
					$GLOBALS["beneficiary_dump"]->uid->setSessionValue(""); // Clear master key if insert failed
			}
			if (in_array("alt_beneficiary", $DetailTblVar) && $GLOBALS["alt_beneficiary"]->DetailAdd) {
				$GLOBALS["alt_beneficiary"]->uid->setSessionValue($this->uid->CurrentValue); // Set master key
				if (!isset($GLOBALS["alt_beneficiary_grid"])) $GLOBALS["alt_beneficiary_grid"] = new calt_beneficiary_grid(); // Get detail page object
				$AddRow = $GLOBALS["alt_beneficiary_grid"]->GridInsert();
				if (!$AddRow)
					$GLOBALS["alt_beneficiary"]->uid->setSessionValue(""); // Clear master key if insert failed
			}
			if (in_array("assets_tb", $DetailTblVar) && $GLOBALS["assets_tb"]->DetailAdd) {
				$GLOBALS["assets_tb"]->uid->setSessionValue($this->uid->CurrentValue); // Set master key
				if (!isset($GLOBALS["assets_tb_grid"])) $GLOBALS["assets_tb_grid"] = new cassets_tb_grid(); // Get detail page object
				$AddRow = $GLOBALS["assets_tb_grid"]->GridInsert();
				if (!$AddRow)
					$GLOBALS["assets_tb"]->uid->setSessionValue(""); // Clear master key if insert failed
			}
			if (in_array("overall_asset", $DetailTblVar) && $GLOBALS["overall_asset"]->DetailAdd) {
				$GLOBALS["overall_asset"]->uid->setSessionValue($this->uid->CurrentValue); // Set master key
				if (!isset($GLOBALS["overall_asset_grid"])) $GLOBALS["overall_asset_grid"] = new coverall_asset_grid(); // Get detail page object
				$AddRow = $GLOBALS["overall_asset_grid"]->GridInsert();
				if (!$AddRow)
					$GLOBALS["overall_asset"]->uid->setSessionValue(""); // Clear master key if insert failed
			}
			if (in_array("executor_tb", $DetailTblVar) && $GLOBALS["executor_tb"]->DetailAdd) {
				$GLOBALS["executor_tb"]->uid->setSessionValue($this->uid->CurrentValue); // Set master key
				if (!isset($GLOBALS["executor_tb_grid"])) $GLOBALS["executor_tb_grid"] = new cexecutor_tb_grid(); // Get detail page object
				$AddRow = $GLOBALS["executor_tb_grid"]->GridInsert();
				if (!$AddRow)
					$GLOBALS["executor_tb"]->uid->setSessionValue(""); // Clear master key if insert failed
			}
			if (in_array("trustee_tb", $DetailTblVar) && $GLOBALS["trustee_tb"]->DetailAdd) {
				$GLOBALS["trustee_tb"]->uid->setSessionValue($this->uid->CurrentValue); // Set master key
				if (!isset($GLOBALS["trustee_tb_grid"])) $GLOBALS["trustee_tb_grid"] = new ctrustee_tb_grid(); // Get detail page object
				$AddRow = $GLOBALS["trustee_tb_grid"]->GridInsert();
				if (!$AddRow)
					$GLOBALS["trustee_tb"]->uid->setSessionValue(""); // Clear master key if insert failed
			}
			if (in_array("witness_tb", $DetailTblVar) && $GLOBALS["witness_tb"]->DetailAdd) {
				$GLOBALS["witness_tb"]->uid->setSessionValue($this->uid->CurrentValue); // Set master key
				if (!isset($GLOBALS["witness_tb_grid"])) $GLOBALS["witness_tb_grid"] = new cwitness_tb_grid(); // Get detail page object
				$AddRow = $GLOBALS["witness_tb_grid"]->GridInsert();
				if (!$AddRow)
					$GLOBALS["witness_tb"]->uid->setSessionValue(""); // Clear master key if insert failed
			}
			if (in_array("addinfo_tb", $DetailTblVar) && $GLOBALS["addinfo_tb"]->DetailAdd) {
				$GLOBALS["addinfo_tb"]->uid->setSessionValue($this->uid->CurrentValue); // Set master key
				if (!isset($GLOBALS["addinfo_tb_grid"])) $GLOBALS["addinfo_tb_grid"] = new caddinfo_tb_grid(); // Get detail page object
				$AddRow = $GLOBALS["addinfo_tb_grid"]->GridInsert();
				if (!$AddRow)
					$GLOBALS["addinfo_tb"]->uid->setSessionValue(""); // Clear master key if insert failed
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
			if (in_array("personal_info", $DetailTblVar)) {
				if (!isset($GLOBALS["personal_info_grid"]))
					$GLOBALS["personal_info_grid"] = new cpersonal_info_grid;
				if ($GLOBALS["personal_info_grid"]->DetailAdd) {
					if ($this->CopyRecord)
						$GLOBALS["personal_info_grid"]->CurrentMode = "copy";
					else
						$GLOBALS["personal_info_grid"]->CurrentMode = "add";
					$GLOBALS["personal_info_grid"]->CurrentAction = "gridadd";

					// Save current master table to detail table
					$GLOBALS["personal_info_grid"]->setCurrentMasterTable($this->TableVar);
					$GLOBALS["personal_info_grid"]->setStartRecordNumber(1);
					$GLOBALS["personal_info_grid"]->uid->FldIsDetailKey = TRUE;
					$GLOBALS["personal_info_grid"]->uid->CurrentValue = $this->uid->CurrentValue;
					$GLOBALS["personal_info_grid"]->uid->setSessionValue($GLOBALS["personal_info_grid"]->uid->CurrentValue);
				}
			}
			if (in_array("spouse_tb", $DetailTblVar)) {
				if (!isset($GLOBALS["spouse_tb_grid"]))
					$GLOBALS["spouse_tb_grid"] = new cspouse_tb_grid;
				if ($GLOBALS["spouse_tb_grid"]->DetailAdd) {
					if ($this->CopyRecord)
						$GLOBALS["spouse_tb_grid"]->CurrentMode = "copy";
					else
						$GLOBALS["spouse_tb_grid"]->CurrentMode = "add";
					$GLOBALS["spouse_tb_grid"]->CurrentAction = "gridadd";

					// Save current master table to detail table
					$GLOBALS["spouse_tb_grid"]->setCurrentMasterTable($this->TableVar);
					$GLOBALS["spouse_tb_grid"]->setStartRecordNumber(1);
					$GLOBALS["spouse_tb_grid"]->uid->FldIsDetailKey = TRUE;
					$GLOBALS["spouse_tb_grid"]->uid->CurrentValue = $this->uid->CurrentValue;
					$GLOBALS["spouse_tb_grid"]->uid->setSessionValue($GLOBALS["spouse_tb_grid"]->uid->CurrentValue);
				}
			}
			if (in_array("divorce_tb", $DetailTblVar)) {
				if (!isset($GLOBALS["divorce_tb_grid"]))
					$GLOBALS["divorce_tb_grid"] = new cdivorce_tb_grid;
				if ($GLOBALS["divorce_tb_grid"]->DetailAdd) {
					if ($this->CopyRecord)
						$GLOBALS["divorce_tb_grid"]->CurrentMode = "copy";
					else
						$GLOBALS["divorce_tb_grid"]->CurrentMode = "add";
					$GLOBALS["divorce_tb_grid"]->CurrentAction = "gridadd";

					// Save current master table to detail table
					$GLOBALS["divorce_tb_grid"]->setCurrentMasterTable($this->TableVar);
					$GLOBALS["divorce_tb_grid"]->setStartRecordNumber(1);
					$GLOBALS["divorce_tb_grid"]->uid->FldIsDetailKey = TRUE;
					$GLOBALS["divorce_tb_grid"]->uid->CurrentValue = $this->uid->CurrentValue;
					$GLOBALS["divorce_tb_grid"]->uid->setSessionValue($GLOBALS["divorce_tb_grid"]->uid->CurrentValue);
				}
			}
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
			if (in_array("beneficiary_dump", $DetailTblVar)) {
				if (!isset($GLOBALS["beneficiary_dump_grid"]))
					$GLOBALS["beneficiary_dump_grid"] = new cbeneficiary_dump_grid;
				if ($GLOBALS["beneficiary_dump_grid"]->DetailAdd) {
					if ($this->CopyRecord)
						$GLOBALS["beneficiary_dump_grid"]->CurrentMode = "copy";
					else
						$GLOBALS["beneficiary_dump_grid"]->CurrentMode = "add";
					$GLOBALS["beneficiary_dump_grid"]->CurrentAction = "gridadd";

					// Save current master table to detail table
					$GLOBALS["beneficiary_dump_grid"]->setCurrentMasterTable($this->TableVar);
					$GLOBALS["beneficiary_dump_grid"]->setStartRecordNumber(1);
					$GLOBALS["beneficiary_dump_grid"]->uid->FldIsDetailKey = TRUE;
					$GLOBALS["beneficiary_dump_grid"]->uid->CurrentValue = $this->uid->CurrentValue;
					$GLOBALS["beneficiary_dump_grid"]->uid->setSessionValue($GLOBALS["beneficiary_dump_grid"]->uid->CurrentValue);
				}
			}
			if (in_array("alt_beneficiary", $DetailTblVar)) {
				if (!isset($GLOBALS["alt_beneficiary_grid"]))
					$GLOBALS["alt_beneficiary_grid"] = new calt_beneficiary_grid;
				if ($GLOBALS["alt_beneficiary_grid"]->DetailAdd) {
					if ($this->CopyRecord)
						$GLOBALS["alt_beneficiary_grid"]->CurrentMode = "copy";
					else
						$GLOBALS["alt_beneficiary_grid"]->CurrentMode = "add";
					$GLOBALS["alt_beneficiary_grid"]->CurrentAction = "gridadd";

					// Save current master table to detail table
					$GLOBALS["alt_beneficiary_grid"]->setCurrentMasterTable($this->TableVar);
					$GLOBALS["alt_beneficiary_grid"]->setStartRecordNumber(1);
					$GLOBALS["alt_beneficiary_grid"]->uid->FldIsDetailKey = TRUE;
					$GLOBALS["alt_beneficiary_grid"]->uid->CurrentValue = $this->uid->CurrentValue;
					$GLOBALS["alt_beneficiary_grid"]->uid->setSessionValue($GLOBALS["alt_beneficiary_grid"]->uid->CurrentValue);
				}
			}
			if (in_array("assets_tb", $DetailTblVar)) {
				if (!isset($GLOBALS["assets_tb_grid"]))
					$GLOBALS["assets_tb_grid"] = new cassets_tb_grid;
				if ($GLOBALS["assets_tb_grid"]->DetailAdd) {
					if ($this->CopyRecord)
						$GLOBALS["assets_tb_grid"]->CurrentMode = "copy";
					else
						$GLOBALS["assets_tb_grid"]->CurrentMode = "add";
					$GLOBALS["assets_tb_grid"]->CurrentAction = "gridadd";

					// Save current master table to detail table
					$GLOBALS["assets_tb_grid"]->setCurrentMasterTable($this->TableVar);
					$GLOBALS["assets_tb_grid"]->setStartRecordNumber(1);
					$GLOBALS["assets_tb_grid"]->uid->FldIsDetailKey = TRUE;
					$GLOBALS["assets_tb_grid"]->uid->CurrentValue = $this->uid->CurrentValue;
					$GLOBALS["assets_tb_grid"]->uid->setSessionValue($GLOBALS["assets_tb_grid"]->uid->CurrentValue);
				}
			}
			if (in_array("overall_asset", $DetailTblVar)) {
				if (!isset($GLOBALS["overall_asset_grid"]))
					$GLOBALS["overall_asset_grid"] = new coverall_asset_grid;
				if ($GLOBALS["overall_asset_grid"]->DetailAdd) {
					if ($this->CopyRecord)
						$GLOBALS["overall_asset_grid"]->CurrentMode = "copy";
					else
						$GLOBALS["overall_asset_grid"]->CurrentMode = "add";
					$GLOBALS["overall_asset_grid"]->CurrentAction = "gridadd";

					// Save current master table to detail table
					$GLOBALS["overall_asset_grid"]->setCurrentMasterTable($this->TableVar);
					$GLOBALS["overall_asset_grid"]->setStartRecordNumber(1);
					$GLOBALS["overall_asset_grid"]->uid->FldIsDetailKey = TRUE;
					$GLOBALS["overall_asset_grid"]->uid->CurrentValue = $this->uid->CurrentValue;
					$GLOBALS["overall_asset_grid"]->uid->setSessionValue($GLOBALS["overall_asset_grid"]->uid->CurrentValue);
				}
			}
			if (in_array("executor_tb", $DetailTblVar)) {
				if (!isset($GLOBALS["executor_tb_grid"]))
					$GLOBALS["executor_tb_grid"] = new cexecutor_tb_grid;
				if ($GLOBALS["executor_tb_grid"]->DetailAdd) {
					if ($this->CopyRecord)
						$GLOBALS["executor_tb_grid"]->CurrentMode = "copy";
					else
						$GLOBALS["executor_tb_grid"]->CurrentMode = "add";
					$GLOBALS["executor_tb_grid"]->CurrentAction = "gridadd";

					// Save current master table to detail table
					$GLOBALS["executor_tb_grid"]->setCurrentMasterTable($this->TableVar);
					$GLOBALS["executor_tb_grid"]->setStartRecordNumber(1);
					$GLOBALS["executor_tb_grid"]->uid->FldIsDetailKey = TRUE;
					$GLOBALS["executor_tb_grid"]->uid->CurrentValue = $this->uid->CurrentValue;
					$GLOBALS["executor_tb_grid"]->uid->setSessionValue($GLOBALS["executor_tb_grid"]->uid->CurrentValue);
				}
			}
			if (in_array("trustee_tb", $DetailTblVar)) {
				if (!isset($GLOBALS["trustee_tb_grid"]))
					$GLOBALS["trustee_tb_grid"] = new ctrustee_tb_grid;
				if ($GLOBALS["trustee_tb_grid"]->DetailAdd) {
					if ($this->CopyRecord)
						$GLOBALS["trustee_tb_grid"]->CurrentMode = "copy";
					else
						$GLOBALS["trustee_tb_grid"]->CurrentMode = "add";
					$GLOBALS["trustee_tb_grid"]->CurrentAction = "gridadd";

					// Save current master table to detail table
					$GLOBALS["trustee_tb_grid"]->setCurrentMasterTable($this->TableVar);
					$GLOBALS["trustee_tb_grid"]->setStartRecordNumber(1);
					$GLOBALS["trustee_tb_grid"]->uid->FldIsDetailKey = TRUE;
					$GLOBALS["trustee_tb_grid"]->uid->CurrentValue = $this->uid->CurrentValue;
					$GLOBALS["trustee_tb_grid"]->uid->setSessionValue($GLOBALS["trustee_tb_grid"]->uid->CurrentValue);
				}
			}
			if (in_array("witness_tb", $DetailTblVar)) {
				if (!isset($GLOBALS["witness_tb_grid"]))
					$GLOBALS["witness_tb_grid"] = new cwitness_tb_grid;
				if ($GLOBALS["witness_tb_grid"]->DetailAdd) {
					if ($this->CopyRecord)
						$GLOBALS["witness_tb_grid"]->CurrentMode = "copy";
					else
						$GLOBALS["witness_tb_grid"]->CurrentMode = "add";
					$GLOBALS["witness_tb_grid"]->CurrentAction = "gridadd";

					// Save current master table to detail table
					$GLOBALS["witness_tb_grid"]->setCurrentMasterTable($this->TableVar);
					$GLOBALS["witness_tb_grid"]->setStartRecordNumber(1);
					$GLOBALS["witness_tb_grid"]->uid->FldIsDetailKey = TRUE;
					$GLOBALS["witness_tb_grid"]->uid->CurrentValue = $this->uid->CurrentValue;
					$GLOBALS["witness_tb_grid"]->uid->setSessionValue($GLOBALS["witness_tb_grid"]->uid->CurrentValue);
				}
			}
			if (in_array("addinfo_tb", $DetailTblVar)) {
				if (!isset($GLOBALS["addinfo_tb_grid"]))
					$GLOBALS["addinfo_tb_grid"] = new caddinfo_tb_grid;
				if ($GLOBALS["addinfo_tb_grid"]->DetailAdd) {
					if ($this->CopyRecord)
						$GLOBALS["addinfo_tb_grid"]->CurrentMode = "copy";
					else
						$GLOBALS["addinfo_tb_grid"]->CurrentMode = "add";
					$GLOBALS["addinfo_tb_grid"]->CurrentAction = "gridadd";

					// Save current master table to detail table
					$GLOBALS["addinfo_tb_grid"]->setCurrentMasterTable($this->TableVar);
					$GLOBALS["addinfo_tb_grid"]->setStartRecordNumber(1);
					$GLOBALS["addinfo_tb_grid"]->uid->FldIsDetailKey = TRUE;
					$GLOBALS["addinfo_tb_grid"]->uid->CurrentValue = $this->uid->CurrentValue;
					$GLOBALS["addinfo_tb_grid"]->uid->setSessionValue($GLOBALS["addinfo_tb_grid"]->uid->CurrentValue);
				}
			}
		}
	}

	// Set up Breadcrumb
	function SetupBreadcrumb() {
		global $Breadcrumb, $Language;
		$Breadcrumb = new cBreadcrumb();
		$PageCaption = $this->TableCaption();
		$Breadcrumb->Add("list", "<span id=\"ewPageCaption\">" . $PageCaption . "</span>", "comprehensivewill_tblist.php", $this->TableVar);
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
if (!isset($comprehensivewill_tb_add)) $comprehensivewill_tb_add = new ccomprehensivewill_tb_add();

// Page init
$comprehensivewill_tb_add->Page_Init();

// Page main
$comprehensivewill_tb_add->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$comprehensivewill_tb_add->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Page object
var comprehensivewill_tb_add = new ew_Page("comprehensivewill_tb_add");
comprehensivewill_tb_add.PageID = "add"; // Page ID
var EW_PAGE_ID = comprehensivewill_tb_add.PageID; // For backward compatibility

// Form object
var fcomprehensivewill_tbadd = new ew_Form("fcomprehensivewill_tbadd");

// Validate form
fcomprehensivewill_tbadd.Validate = function() {
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
			if (elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($comprehensivewill_tb->uid->FldErrMsg()) ?>");

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
fcomprehensivewill_tbadd.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
fcomprehensivewill_tbadd.ValidateRequired = true;
<?php } else { ?>
fcomprehensivewill_tbadd.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
// Form object for search

</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<?php $Breadcrumb->Render(); ?>
<?php $comprehensivewill_tb_add->ShowPageHeader(); ?>
<?php
$comprehensivewill_tb_add->ShowMessage();
?>
<form name="fcomprehensivewill_tbadd" id="fcomprehensivewill_tbadd" class="ewForm form-horizontal" action="<?php echo ew_CurrentPage() ?>" method="post">
<input type="hidden" name="t" value="comprehensivewill_tb">
<input type="hidden" name="a_add" id="a_add" value="A">
<table cellspacing="0" class="ewGrid"><tr><td>
<table id="tbl_comprehensivewill_tbadd" class="table table-bordered table-striped">
<?php if ($comprehensivewill_tb->uid->Visible) { // uid ?>
	<tr id="r_uid">
		<td><span id="elh_comprehensivewill_tb_uid"><?php echo $comprehensivewill_tb->uid->FldCaption() ?></span></td>
		<td<?php echo $comprehensivewill_tb->uid->CellAttributes() ?>>
<span id="el_comprehensivewill_tb_uid" class="control-group">
<input type="text" data-field="x_uid" name="x_uid" id="x_uid" size="30" placeholder="<?php echo $comprehensivewill_tb->uid->PlaceHolder ?>" value="<?php echo $comprehensivewill_tb->uid->EditValue ?>"<?php echo $comprehensivewill_tb->uid->EditAttributes() ?>>
</span>
<?php echo $comprehensivewill_tb->uid->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($comprehensivewill_tb->willtype->Visible) { // willtype ?>
	<tr id="r_willtype">
		<td><span id="elh_comprehensivewill_tb_willtype"><?php echo $comprehensivewill_tb->willtype->FldCaption() ?></span></td>
		<td<?php echo $comprehensivewill_tb->willtype->CellAttributes() ?>>
<span id="el_comprehensivewill_tb_willtype" class="control-group">
<input type="text" data-field="x_willtype" name="x_willtype" id="x_willtype" size="30" maxlength="100" placeholder="<?php echo $comprehensivewill_tb->willtype->PlaceHolder ?>" value="<?php echo $comprehensivewill_tb->willtype->EditValue ?>"<?php echo $comprehensivewill_tb->willtype->EditAttributes() ?>>
</span>
<?php echo $comprehensivewill_tb->willtype->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($comprehensivewill_tb->fullname->Visible) { // fullname ?>
	<tr id="r_fullname">
		<td><span id="elh_comprehensivewill_tb_fullname"><?php echo $comprehensivewill_tb->fullname->FldCaption() ?></span></td>
		<td<?php echo $comprehensivewill_tb->fullname->CellAttributes() ?>>
<span id="el_comprehensivewill_tb_fullname" class="control-group">
<input type="text" data-field="x_fullname" name="x_fullname" id="x_fullname" size="30" maxlength="100" placeholder="<?php echo $comprehensivewill_tb->fullname->PlaceHolder ?>" value="<?php echo $comprehensivewill_tb->fullname->EditValue ?>"<?php echo $comprehensivewill_tb->fullname->EditAttributes() ?>>
</span>
<?php echo $comprehensivewill_tb->fullname->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($comprehensivewill_tb->address->Visible) { // address ?>
	<tr id="r_address">
		<td><span id="elh_comprehensivewill_tb_address"><?php echo $comprehensivewill_tb->address->FldCaption() ?></span></td>
		<td<?php echo $comprehensivewill_tb->address->CellAttributes() ?>>
<span id="el_comprehensivewill_tb_address" class="control-group">
<textarea data-field="x_address" name="x_address" id="x_address" cols="35" rows="4" placeholder="<?php echo $comprehensivewill_tb->address->PlaceHolder ?>"<?php echo $comprehensivewill_tb->address->EditAttributes() ?>><?php echo $comprehensivewill_tb->address->EditValue ?></textarea>
</span>
<?php echo $comprehensivewill_tb->address->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($comprehensivewill_tb->_email->Visible) { // email ?>
	<tr id="r__email">
		<td><span id="elh_comprehensivewill_tb__email"><?php echo $comprehensivewill_tb->_email->FldCaption() ?></span></td>
		<td<?php echo $comprehensivewill_tb->_email->CellAttributes() ?>>
<span id="el_comprehensivewill_tb__email" class="control-group">
<input type="text" data-field="x__email" name="x__email" id="x__email" size="30" maxlength="50" placeholder="<?php echo $comprehensivewill_tb->_email->PlaceHolder ?>" value="<?php echo $comprehensivewill_tb->_email->EditValue ?>"<?php echo $comprehensivewill_tb->_email->EditAttributes() ?>>
</span>
<?php echo $comprehensivewill_tb->_email->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($comprehensivewill_tb->phoneno->Visible) { // phoneno ?>
	<tr id="r_phoneno">
		<td><span id="elh_comprehensivewill_tb_phoneno"><?php echo $comprehensivewill_tb->phoneno->FldCaption() ?></span></td>
		<td<?php echo $comprehensivewill_tb->phoneno->CellAttributes() ?>>
<span id="el_comprehensivewill_tb_phoneno" class="control-group">
<input type="text" data-field="x_phoneno" name="x_phoneno" id="x_phoneno" size="30" maxlength="20" placeholder="<?php echo $comprehensivewill_tb->phoneno->PlaceHolder ?>" value="<?php echo $comprehensivewill_tb->phoneno->EditValue ?>"<?php echo $comprehensivewill_tb->phoneno->EditAttributes() ?>>
</span>
<?php echo $comprehensivewill_tb->phoneno->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($comprehensivewill_tb->aphoneno->Visible) { // aphoneno ?>
	<tr id="r_aphoneno">
		<td><span id="elh_comprehensivewill_tb_aphoneno"><?php echo $comprehensivewill_tb->aphoneno->FldCaption() ?></span></td>
		<td<?php echo $comprehensivewill_tb->aphoneno->CellAttributes() ?>>
<span id="el_comprehensivewill_tb_aphoneno" class="control-group">
<input type="text" data-field="x_aphoneno" name="x_aphoneno" id="x_aphoneno" size="30" maxlength="20" placeholder="<?php echo $comprehensivewill_tb->aphoneno->PlaceHolder ?>" value="<?php echo $comprehensivewill_tb->aphoneno->EditValue ?>"<?php echo $comprehensivewill_tb->aphoneno->EditAttributes() ?>>
</span>
<?php echo $comprehensivewill_tb->aphoneno->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($comprehensivewill_tb->gender->Visible) { // gender ?>
	<tr id="r_gender">
		<td><span id="elh_comprehensivewill_tb_gender"><?php echo $comprehensivewill_tb->gender->FldCaption() ?></span></td>
		<td<?php echo $comprehensivewill_tb->gender->CellAttributes() ?>>
<span id="el_comprehensivewill_tb_gender" class="control-group">
<input type="text" data-field="x_gender" name="x_gender" id="x_gender" size="30" maxlength="10" placeholder="<?php echo $comprehensivewill_tb->gender->PlaceHolder ?>" value="<?php echo $comprehensivewill_tb->gender->EditValue ?>"<?php echo $comprehensivewill_tb->gender->EditAttributes() ?>>
</span>
<?php echo $comprehensivewill_tb->gender->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($comprehensivewill_tb->dob->Visible) { // dob ?>
	<tr id="r_dob">
		<td><span id="elh_comprehensivewill_tb_dob"><?php echo $comprehensivewill_tb->dob->FldCaption() ?></span></td>
		<td<?php echo $comprehensivewill_tb->dob->CellAttributes() ?>>
<span id="el_comprehensivewill_tb_dob" class="control-group">
<input type="text" data-field="x_dob" name="x_dob" id="x_dob" size="30" maxlength="20" placeholder="<?php echo $comprehensivewill_tb->dob->PlaceHolder ?>" value="<?php echo $comprehensivewill_tb->dob->EditValue ?>"<?php echo $comprehensivewill_tb->dob->EditAttributes() ?>>
</span>
<?php echo $comprehensivewill_tb->dob->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($comprehensivewill_tb->state->Visible) { // state ?>
	<tr id="r_state">
		<td><span id="elh_comprehensivewill_tb_state"><?php echo $comprehensivewill_tb->state->FldCaption() ?></span></td>
		<td<?php echo $comprehensivewill_tb->state->CellAttributes() ?>>
<span id="el_comprehensivewill_tb_state" class="control-group">
<input type="text" data-field="x_state" name="x_state" id="x_state" size="30" maxlength="20" placeholder="<?php echo $comprehensivewill_tb->state->PlaceHolder ?>" value="<?php echo $comprehensivewill_tb->state->EditValue ?>"<?php echo $comprehensivewill_tb->state->EditAttributes() ?>>
</span>
<?php echo $comprehensivewill_tb->state->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($comprehensivewill_tb->nationality->Visible) { // nationality ?>
	<tr id="r_nationality">
		<td><span id="elh_comprehensivewill_tb_nationality"><?php echo $comprehensivewill_tb->nationality->FldCaption() ?></span></td>
		<td<?php echo $comprehensivewill_tb->nationality->CellAttributes() ?>>
<span id="el_comprehensivewill_tb_nationality" class="control-group">
<input type="text" data-field="x_nationality" name="x_nationality" id="x_nationality" size="30" maxlength="20" placeholder="<?php echo $comprehensivewill_tb->nationality->PlaceHolder ?>" value="<?php echo $comprehensivewill_tb->nationality->EditValue ?>"<?php echo $comprehensivewill_tb->nationality->EditAttributes() ?>>
</span>
<?php echo $comprehensivewill_tb->nationality->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($comprehensivewill_tb->lga->Visible) { // lga ?>
	<tr id="r_lga">
		<td><span id="elh_comprehensivewill_tb_lga"><?php echo $comprehensivewill_tb->lga->FldCaption() ?></span></td>
		<td<?php echo $comprehensivewill_tb->lga->CellAttributes() ?>>
<span id="el_comprehensivewill_tb_lga" class="control-group">
<input type="text" data-field="x_lga" name="x_lga" id="x_lga" size="30" maxlength="50" placeholder="<?php echo $comprehensivewill_tb->lga->PlaceHolder ?>" value="<?php echo $comprehensivewill_tb->lga->EditValue ?>"<?php echo $comprehensivewill_tb->lga->EditAttributes() ?>>
</span>
<?php echo $comprehensivewill_tb->lga->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($comprehensivewill_tb->employmentstatus->Visible) { // employmentstatus ?>
	<tr id="r_employmentstatus">
		<td><span id="elh_comprehensivewill_tb_employmentstatus"><?php echo $comprehensivewill_tb->employmentstatus->FldCaption() ?></span></td>
		<td<?php echo $comprehensivewill_tb->employmentstatus->CellAttributes() ?>>
<span id="el_comprehensivewill_tb_employmentstatus" class="control-group">
<input type="text" data-field="x_employmentstatus" name="x_employmentstatus" id="x_employmentstatus" size="30" maxlength="50" placeholder="<?php echo $comprehensivewill_tb->employmentstatus->PlaceHolder ?>" value="<?php echo $comprehensivewill_tb->employmentstatus->EditValue ?>"<?php echo $comprehensivewill_tb->employmentstatus->EditAttributes() ?>>
</span>
<?php echo $comprehensivewill_tb->employmentstatus->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($comprehensivewill_tb->employer->Visible) { // employer ?>
	<tr id="r_employer">
		<td><span id="elh_comprehensivewill_tb_employer"><?php echo $comprehensivewill_tb->employer->FldCaption() ?></span></td>
		<td<?php echo $comprehensivewill_tb->employer->CellAttributes() ?>>
<span id="el_comprehensivewill_tb_employer" class="control-group">
<textarea data-field="x_employer" name="x_employer" id="x_employer" cols="35" rows="4" placeholder="<?php echo $comprehensivewill_tb->employer->PlaceHolder ?>"<?php echo $comprehensivewill_tb->employer->EditAttributes() ?>><?php echo $comprehensivewill_tb->employer->EditValue ?></textarea>
</span>
<?php echo $comprehensivewill_tb->employer->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($comprehensivewill_tb->employerphone->Visible) { // employerphone ?>
	<tr id="r_employerphone">
		<td><span id="elh_comprehensivewill_tb_employerphone"><?php echo $comprehensivewill_tb->employerphone->FldCaption() ?></span></td>
		<td<?php echo $comprehensivewill_tb->employerphone->CellAttributes() ?>>
<span id="el_comprehensivewill_tb_employerphone" class="control-group">
<input type="text" data-field="x_employerphone" name="x_employerphone" id="x_employerphone" size="30" maxlength="50" placeholder="<?php echo $comprehensivewill_tb->employerphone->PlaceHolder ?>" value="<?php echo $comprehensivewill_tb->employerphone->EditValue ?>"<?php echo $comprehensivewill_tb->employerphone->EditAttributes() ?>>
</span>
<?php echo $comprehensivewill_tb->employerphone->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($comprehensivewill_tb->employeraddr->Visible) { // employeraddr ?>
	<tr id="r_employeraddr">
		<td><span id="elh_comprehensivewill_tb_employeraddr"><?php echo $comprehensivewill_tb->employeraddr->FldCaption() ?></span></td>
		<td<?php echo $comprehensivewill_tb->employeraddr->CellAttributes() ?>>
<span id="el_comprehensivewill_tb_employeraddr" class="control-group">
<textarea data-field="x_employeraddr" name="x_employeraddr" id="x_employeraddr" cols="35" rows="4" placeholder="<?php echo $comprehensivewill_tb->employeraddr->PlaceHolder ?>"<?php echo $comprehensivewill_tb->employeraddr->EditAttributes() ?>><?php echo $comprehensivewill_tb->employeraddr->EditValue ?></textarea>
</span>
<?php echo $comprehensivewill_tb->employeraddr->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($comprehensivewill_tb->maritalstatus->Visible) { // maritalstatus ?>
	<tr id="r_maritalstatus">
		<td><span id="elh_comprehensivewill_tb_maritalstatus"><?php echo $comprehensivewill_tb->maritalstatus->FldCaption() ?></span></td>
		<td<?php echo $comprehensivewill_tb->maritalstatus->CellAttributes() ?>>
<span id="el_comprehensivewill_tb_maritalstatus" class="control-group">
<input type="text" data-field="x_maritalstatus" name="x_maritalstatus" id="x_maritalstatus" size="30" maxlength="50" placeholder="<?php echo $comprehensivewill_tb->maritalstatus->PlaceHolder ?>" value="<?php echo $comprehensivewill_tb->maritalstatus->EditValue ?>"<?php echo $comprehensivewill_tb->maritalstatus->EditAttributes() ?>>
</span>
<?php echo $comprehensivewill_tb->maritalstatus->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($comprehensivewill_tb->spname->Visible) { // spname ?>
	<tr id="r_spname">
		<td><span id="elh_comprehensivewill_tb_spname"><?php echo $comprehensivewill_tb->spname->FldCaption() ?></span></td>
		<td<?php echo $comprehensivewill_tb->spname->CellAttributes() ?>>
<span id="el_comprehensivewill_tb_spname" class="control-group">
<input type="text" data-field="x_spname" name="x_spname" id="x_spname" size="30" maxlength="50" placeholder="<?php echo $comprehensivewill_tb->spname->PlaceHolder ?>" value="<?php echo $comprehensivewill_tb->spname->EditValue ?>"<?php echo $comprehensivewill_tb->spname->EditAttributes() ?>>
</span>
<?php echo $comprehensivewill_tb->spname->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($comprehensivewill_tb->spemail->Visible) { // spemail ?>
	<tr id="r_spemail">
		<td><span id="elh_comprehensivewill_tb_spemail"><?php echo $comprehensivewill_tb->spemail->FldCaption() ?></span></td>
		<td<?php echo $comprehensivewill_tb->spemail->CellAttributes() ?>>
<span id="el_comprehensivewill_tb_spemail" class="control-group">
<input type="text" data-field="x_spemail" name="x_spemail" id="x_spemail" size="30" maxlength="50" placeholder="<?php echo $comprehensivewill_tb->spemail->PlaceHolder ?>" value="<?php echo $comprehensivewill_tb->spemail->EditValue ?>"<?php echo $comprehensivewill_tb->spemail->EditAttributes() ?>>
</span>
<?php echo $comprehensivewill_tb->spemail->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($comprehensivewill_tb->spphone->Visible) { // spphone ?>
	<tr id="r_spphone">
		<td><span id="elh_comprehensivewill_tb_spphone"><?php echo $comprehensivewill_tb->spphone->FldCaption() ?></span></td>
		<td<?php echo $comprehensivewill_tb->spphone->CellAttributes() ?>>
<span id="el_comprehensivewill_tb_spphone" class="control-group">
<input type="text" data-field="x_spphone" name="x_spphone" id="x_spphone" size="30" maxlength="20" placeholder="<?php echo $comprehensivewill_tb->spphone->PlaceHolder ?>" value="<?php echo $comprehensivewill_tb->spphone->EditValue ?>"<?php echo $comprehensivewill_tb->spphone->EditAttributes() ?>>
</span>
<?php echo $comprehensivewill_tb->spphone->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($comprehensivewill_tb->sdob->Visible) { // sdob ?>
	<tr id="r_sdob">
		<td><span id="elh_comprehensivewill_tb_sdob"><?php echo $comprehensivewill_tb->sdob->FldCaption() ?></span></td>
		<td<?php echo $comprehensivewill_tb->sdob->CellAttributes() ?>>
<span id="el_comprehensivewill_tb_sdob" class="control-group">
<input type="text" data-field="x_sdob" name="x_sdob" id="x_sdob" size="30" maxlength="10" placeholder="<?php echo $comprehensivewill_tb->sdob->PlaceHolder ?>" value="<?php echo $comprehensivewill_tb->sdob->EditValue ?>"<?php echo $comprehensivewill_tb->sdob->EditAttributes() ?>>
</span>
<?php echo $comprehensivewill_tb->sdob->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($comprehensivewill_tb->spaddr->Visible) { // spaddr ?>
	<tr id="r_spaddr">
		<td><span id="elh_comprehensivewill_tb_spaddr"><?php echo $comprehensivewill_tb->spaddr->FldCaption() ?></span></td>
		<td<?php echo $comprehensivewill_tb->spaddr->CellAttributes() ?>>
<span id="el_comprehensivewill_tb_spaddr" class="control-group">
<textarea data-field="x_spaddr" name="x_spaddr" id="x_spaddr" cols="35" rows="4" placeholder="<?php echo $comprehensivewill_tb->spaddr->PlaceHolder ?>"<?php echo $comprehensivewill_tb->spaddr->EditAttributes() ?>><?php echo $comprehensivewill_tb->spaddr->EditValue ?></textarea>
</span>
<?php echo $comprehensivewill_tb->spaddr->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($comprehensivewill_tb->spcity->Visible) { // spcity ?>
	<tr id="r_spcity">
		<td><span id="elh_comprehensivewill_tb_spcity"><?php echo $comprehensivewill_tb->spcity->FldCaption() ?></span></td>
		<td<?php echo $comprehensivewill_tb->spcity->CellAttributes() ?>>
<span id="el_comprehensivewill_tb_spcity" class="control-group">
<input type="text" data-field="x_spcity" name="x_spcity" id="x_spcity" size="30" maxlength="50" placeholder="<?php echo $comprehensivewill_tb->spcity->PlaceHolder ?>" value="<?php echo $comprehensivewill_tb->spcity->EditValue ?>"<?php echo $comprehensivewill_tb->spcity->EditAttributes() ?>>
</span>
<?php echo $comprehensivewill_tb->spcity->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($comprehensivewill_tb->spstate->Visible) { // spstate ?>
	<tr id="r_spstate">
		<td><span id="elh_comprehensivewill_tb_spstate"><?php echo $comprehensivewill_tb->spstate->FldCaption() ?></span></td>
		<td<?php echo $comprehensivewill_tb->spstate->CellAttributes() ?>>
<span id="el_comprehensivewill_tb_spstate" class="control-group">
<input type="text" data-field="x_spstate" name="x_spstate" id="x_spstate" size="30" maxlength="50" placeholder="<?php echo $comprehensivewill_tb->spstate->PlaceHolder ?>" value="<?php echo $comprehensivewill_tb->spstate->EditValue ?>"<?php echo $comprehensivewill_tb->spstate->EditAttributes() ?>>
</span>
<?php echo $comprehensivewill_tb->spstate->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($comprehensivewill_tb->marriagetype->Visible) { // marriagetype ?>
	<tr id="r_marriagetype">
		<td><span id="elh_comprehensivewill_tb_marriagetype"><?php echo $comprehensivewill_tb->marriagetype->FldCaption() ?></span></td>
		<td<?php echo $comprehensivewill_tb->marriagetype->CellAttributes() ?>>
<span id="el_comprehensivewill_tb_marriagetype" class="control-group">
<input type="text" data-field="x_marriagetype" name="x_marriagetype" id="x_marriagetype" size="30" maxlength="20" placeholder="<?php echo $comprehensivewill_tb->marriagetype->PlaceHolder ?>" value="<?php echo $comprehensivewill_tb->marriagetype->EditValue ?>"<?php echo $comprehensivewill_tb->marriagetype->EditAttributes() ?>>
</span>
<?php echo $comprehensivewill_tb->marriagetype->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($comprehensivewill_tb->marriageyear->Visible) { // marriageyear ?>
	<tr id="r_marriageyear">
		<td><span id="elh_comprehensivewill_tb_marriageyear"><?php echo $comprehensivewill_tb->marriageyear->FldCaption() ?></span></td>
		<td<?php echo $comprehensivewill_tb->marriageyear->CellAttributes() ?>>
<span id="el_comprehensivewill_tb_marriageyear" class="control-group">
<input type="text" data-field="x_marriageyear" name="x_marriageyear" id="x_marriageyear" size="30" maxlength="10" placeholder="<?php echo $comprehensivewill_tb->marriageyear->PlaceHolder ?>" value="<?php echo $comprehensivewill_tb->marriageyear->EditValue ?>"<?php echo $comprehensivewill_tb->marriageyear->EditAttributes() ?>>
</span>
<?php echo $comprehensivewill_tb->marriageyear->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($comprehensivewill_tb->marriagecert->Visible) { // marriagecert ?>
	<tr id="r_marriagecert">
		<td><span id="elh_comprehensivewill_tb_marriagecert"><?php echo $comprehensivewill_tb->marriagecert->FldCaption() ?></span></td>
		<td<?php echo $comprehensivewill_tb->marriagecert->CellAttributes() ?>>
<span id="el_comprehensivewill_tb_marriagecert" class="control-group">
<input type="text" data-field="x_marriagecert" name="x_marriagecert" id="x_marriagecert" size="30" maxlength="50" placeholder="<?php echo $comprehensivewill_tb->marriagecert->PlaceHolder ?>" value="<?php echo $comprehensivewill_tb->marriagecert->EditValue ?>"<?php echo $comprehensivewill_tb->marriagecert->EditAttributes() ?>>
</span>
<?php echo $comprehensivewill_tb->marriagecert->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($comprehensivewill_tb->marriagecity->Visible) { // marriagecity ?>
	<tr id="r_marriagecity">
		<td><span id="elh_comprehensivewill_tb_marriagecity"><?php echo $comprehensivewill_tb->marriagecity->FldCaption() ?></span></td>
		<td<?php echo $comprehensivewill_tb->marriagecity->CellAttributes() ?>>
<span id="el_comprehensivewill_tb_marriagecity" class="control-group">
<input type="text" data-field="x_marriagecity" name="x_marriagecity" id="x_marriagecity" size="30" maxlength="50" placeholder="<?php echo $comprehensivewill_tb->marriagecity->PlaceHolder ?>" value="<?php echo $comprehensivewill_tb->marriagecity->EditValue ?>"<?php echo $comprehensivewill_tb->marriagecity->EditAttributes() ?>>
</span>
<?php echo $comprehensivewill_tb->marriagecity->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($comprehensivewill_tb->marriagecountry->Visible) { // marriagecountry ?>
	<tr id="r_marriagecountry">
		<td><span id="elh_comprehensivewill_tb_marriagecountry"><?php echo $comprehensivewill_tb->marriagecountry->FldCaption() ?></span></td>
		<td<?php echo $comprehensivewill_tb->marriagecountry->CellAttributes() ?>>
<span id="el_comprehensivewill_tb_marriagecountry" class="control-group">
<input type="text" data-field="x_marriagecountry" name="x_marriagecountry" id="x_marriagecountry" size="30" maxlength="50" placeholder="<?php echo $comprehensivewill_tb->marriagecountry->PlaceHolder ?>" value="<?php echo $comprehensivewill_tb->marriagecountry->EditValue ?>"<?php echo $comprehensivewill_tb->marriagecountry->EditAttributes() ?>>
</span>
<?php echo $comprehensivewill_tb->marriagecountry->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($comprehensivewill_tb->divorce->Visible) { // divorce ?>
	<tr id="r_divorce">
		<td><span id="elh_comprehensivewill_tb_divorce"><?php echo $comprehensivewill_tb->divorce->FldCaption() ?></span></td>
		<td<?php echo $comprehensivewill_tb->divorce->CellAttributes() ?>>
<span id="el_comprehensivewill_tb_divorce" class="control-group">
<input type="text" data-field="x_divorce" name="x_divorce" id="x_divorce" size="30" maxlength="10" placeholder="<?php echo $comprehensivewill_tb->divorce->PlaceHolder ?>" value="<?php echo $comprehensivewill_tb->divorce->EditValue ?>"<?php echo $comprehensivewill_tb->divorce->EditAttributes() ?>>
</span>
<?php echo $comprehensivewill_tb->divorce->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($comprehensivewill_tb->divorceyear->Visible) { // divorceyear ?>
	<tr id="r_divorceyear">
		<td><span id="elh_comprehensivewill_tb_divorceyear"><?php echo $comprehensivewill_tb->divorceyear->FldCaption() ?></span></td>
		<td<?php echo $comprehensivewill_tb->divorceyear->CellAttributes() ?>>
<span id="el_comprehensivewill_tb_divorceyear" class="control-group">
<input type="text" data-field="x_divorceyear" name="x_divorceyear" id="x_divorceyear" size="30" maxlength="10" placeholder="<?php echo $comprehensivewill_tb->divorceyear->PlaceHolder ?>" value="<?php echo $comprehensivewill_tb->divorceyear->EditValue ?>"<?php echo $comprehensivewill_tb->divorceyear->EditAttributes() ?>>
</span>
<?php echo $comprehensivewill_tb->divorceyear->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($comprehensivewill_tb->addinfo->Visible) { // addinfo ?>
	<tr id="r_addinfo">
		<td><span id="elh_comprehensivewill_tb_addinfo"><?php echo $comprehensivewill_tb->addinfo->FldCaption() ?></span></td>
		<td<?php echo $comprehensivewill_tb->addinfo->CellAttributes() ?>>
<span id="el_comprehensivewill_tb_addinfo" class="control-group">
<textarea data-field="x_addinfo" name="x_addinfo" id="x_addinfo" cols="35" rows="4" placeholder="<?php echo $comprehensivewill_tb->addinfo->PlaceHolder ?>"<?php echo $comprehensivewill_tb->addinfo->EditAttributes() ?>><?php echo $comprehensivewill_tb->addinfo->EditValue ?></textarea>
</span>
<?php echo $comprehensivewill_tb->addinfo->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($comprehensivewill_tb->datecreated->Visible) { // datecreated ?>
	<tr id="r_datecreated">
		<td><span id="elh_comprehensivewill_tb_datecreated"><?php echo $comprehensivewill_tb->datecreated->FldCaption() ?></span></td>
		<td<?php echo $comprehensivewill_tb->datecreated->CellAttributes() ?>>
<span id="el_comprehensivewill_tb_datecreated" class="control-group">
<input type="text" data-field="x_datecreated" name="x_datecreated" id="x_datecreated" placeholder="<?php echo $comprehensivewill_tb->datecreated->PlaceHolder ?>" value="<?php echo $comprehensivewill_tb->datecreated->EditValue ?>"<?php echo $comprehensivewill_tb->datecreated->EditAttributes() ?>>
</span>
<?php echo $comprehensivewill_tb->datecreated->CustomMsg ?></td>
	</tr>
<?php } ?>
</table>
</td></tr></table>
<?php
	if (in_array("personal_info", explode(",", $comprehensivewill_tb->getCurrentDetailTable())) && $personal_info->DetailAdd) {
?>
<?php include_once "personal_infogrid.php" ?>
<?php } ?>
<?php
	if (in_array("spouse_tb", explode(",", $comprehensivewill_tb->getCurrentDetailTable())) && $spouse_tb->DetailAdd) {
?>
<?php include_once "spouse_tbgrid.php" ?>
<?php } ?>
<?php
	if (in_array("divorce_tb", explode(",", $comprehensivewill_tb->getCurrentDetailTable())) && $divorce_tb->DetailAdd) {
?>
<?php include_once "divorce_tbgrid.php" ?>
<?php } ?>
<?php
	if (in_array("children_details", explode(",", $comprehensivewill_tb->getCurrentDetailTable())) && $children_details->DetailAdd) {
?>
<?php include_once "children_detailsgrid.php" ?>
<?php } ?>
<?php
	if (in_array("beneficiary_dump", explode(",", $comprehensivewill_tb->getCurrentDetailTable())) && $beneficiary_dump->DetailAdd) {
?>
<?php include_once "beneficiary_dumpgrid.php" ?>
<?php } ?>
<?php
	if (in_array("alt_beneficiary", explode(",", $comprehensivewill_tb->getCurrentDetailTable())) && $alt_beneficiary->DetailAdd) {
?>
<?php include_once "alt_beneficiarygrid.php" ?>
<?php } ?>
<?php
	if (in_array("assets_tb", explode(",", $comprehensivewill_tb->getCurrentDetailTable())) && $assets_tb->DetailAdd) {
?>
<?php include_once "assets_tbgrid.php" ?>
<?php } ?>
<?php
	if (in_array("overall_asset", explode(",", $comprehensivewill_tb->getCurrentDetailTable())) && $overall_asset->DetailAdd) {
?>
<?php include_once "overall_assetgrid.php" ?>
<?php } ?>
<?php
	if (in_array("executor_tb", explode(",", $comprehensivewill_tb->getCurrentDetailTable())) && $executor_tb->DetailAdd) {
?>
<?php include_once "executor_tbgrid.php" ?>
<?php } ?>
<?php
	if (in_array("trustee_tb", explode(",", $comprehensivewill_tb->getCurrentDetailTable())) && $trustee_tb->DetailAdd) {
?>
<?php include_once "trustee_tbgrid.php" ?>
<?php } ?>
<?php
	if (in_array("witness_tb", explode(",", $comprehensivewill_tb->getCurrentDetailTable())) && $witness_tb->DetailAdd) {
?>
<?php include_once "witness_tbgrid.php" ?>
<?php } ?>
<?php
	if (in_array("addinfo_tb", explode(",", $comprehensivewill_tb->getCurrentDetailTable())) && $addinfo_tb->DetailAdd) {
?>
<?php include_once "addinfo_tbgrid.php" ?>
<?php } ?>
<button class="btn btn-primary ewButton" name="btnAction" id="btnAction" type="submit"><?php echo $Language->Phrase("AddBtn") ?></button>
</form>
<script type="text/javascript">
fcomprehensivewill_tbadd.Init();
<?php if (EW_MOBILE_REFLOW && ew_IsMobile()) { ?>
ew_Reflow();
<?php } ?>
</script>
<?php
$comprehensivewill_tb_add->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$comprehensivewill_tb_add->Page_Terminate();
?>
