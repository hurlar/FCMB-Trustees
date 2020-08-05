<?php
if (session_id() == "") session_start(); // Initialize Session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg10.php" ?>
<?php include_once "ewmysql10.php" ?>
<?php include_once "phpfn10.php" ?>
<?php include_once "simplewill_tbinfo.php" ?>
<?php include_once "adminusersinfo.php" ?>
<?php include_once "simplewill_assets_tbgridcls.php" ?>
<?php include_once "simplewill_overall_assetgridcls.php" ?>
<?php include_once "userfn10.php" ?>
<?php

//
// Page class
//

$simplewill_tb_add = NULL; // Initialize page object first

class csimplewill_tb_add extends csimplewill_tb {

	// Page ID
	var $PageID = 'add';

	// Project ID
	var $ProjectID = "{D9B361E7-B2C1-4293-B9B3-B581986A15CC}";

	// Table name
	var $TableName = 'simplewill_tb';

	// Page object name
	var $PageObjName = 'simplewill_tb_add';

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

		// Table object (simplewill_tb)
		if (!isset($GLOBALS["simplewill_tb"])) {
			$GLOBALS["simplewill_tb"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["simplewill_tb"];
		}

		// Table object (adminusers)
		if (!isset($GLOBALS['adminusers'])) $GLOBALS['adminusers'] = new cadminusers();

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'add', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'simplewill_tb', TRUE);

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
					$this->Page_Terminate("simplewill_tblist.php"); // No matching record, return to list
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
					if (ew_GetPageName($sReturnUrl) == "simplewill_tbview.php")
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
		$this->maidenname->CurrentValue = NULL;
		$this->maidenname->OldValue = $this->maidenname->CurrentValue;
		$this->identificationtype->CurrentValue = NULL;
		$this->identificationtype->OldValue = $this->identificationtype->CurrentValue;
		$this->idnumber->CurrentValue = NULL;
		$this->idnumber->OldValue = $this->idnumber->CurrentValue;
		$this->issuedate->CurrentValue = NULL;
		$this->issuedate->OldValue = $this->issuedate->CurrentValue;
		$this->expirydate->CurrentValue = NULL;
		$this->expirydate->OldValue = $this->expirydate->CurrentValue;
		$this->issueplace->CurrentValue = NULL;
		$this->issueplace->OldValue = $this->issueplace->CurrentValue;
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
		$this->spousename->CurrentValue = NULL;
		$this->spousename->OldValue = $this->spousename->CurrentValue;
		$this->spouseemail->CurrentValue = NULL;
		$this->spouseemail->OldValue = $this->spouseemail->CurrentValue;
		$this->spousephone->CurrentValue = NULL;
		$this->spousephone->OldValue = $this->spousephone->CurrentValue;
		$this->spousedob->CurrentValue = NULL;
		$this->spousedob->OldValue = $this->spousedob->CurrentValue;
		$this->spouseaddr->CurrentValue = NULL;
		$this->spouseaddr->OldValue = $this->spouseaddr->CurrentValue;
		$this->spousecity->CurrentValue = NULL;
		$this->spousecity->OldValue = $this->spousecity->CurrentValue;
		$this->spousestate->CurrentValue = NULL;
		$this->spousestate->OldValue = $this->spousestate->CurrentValue;
		$this->marriagetype->CurrentValue = NULL;
		$this->marriagetype->OldValue = $this->marriagetype->CurrentValue;
		$this->marriageyear->CurrentValue = NULL;
		$this->marriageyear->OldValue = $this->marriageyear->CurrentValue;
		$this->marriagecert->CurrentValue = NULL;
		$this->marriagecert->OldValue = $this->marriagecert->CurrentValue;
		$this->cityofmarriage->CurrentValue = NULL;
		$this->cityofmarriage->OldValue = $this->cityofmarriage->CurrentValue;
		$this->countryofmarriage->CurrentValue = NULL;
		$this->countryofmarriage->OldValue = $this->countryofmarriage->CurrentValue;
		$this->divorce->CurrentValue = NULL;
		$this->divorce->OldValue = $this->divorce->CurrentValue;
		$this->divorceyear->CurrentValue = NULL;
		$this->divorceyear->OldValue = $this->divorceyear->CurrentValue;
		$this->nextofkinfullname->CurrentValue = NULL;
		$this->nextofkinfullname->OldValue = $this->nextofkinfullname->CurrentValue;
		$this->nextofkintelephone->CurrentValue = NULL;
		$this->nextofkintelephone->OldValue = $this->nextofkintelephone->CurrentValue;
		$this->nextofkinemail->CurrentValue = NULL;
		$this->nextofkinemail->OldValue = $this->nextofkinemail->CurrentValue;
		$this->nextofkinaddress->CurrentValue = NULL;
		$this->nextofkinaddress->OldValue = $this->nextofkinaddress->CurrentValue;
		$this->nameofcompany->CurrentValue = NULL;
		$this->nameofcompany->OldValue = $this->nameofcompany->CurrentValue;
		$this->humanresourcescontacttelephone->CurrentValue = NULL;
		$this->humanresourcescontacttelephone->OldValue = $this->humanresourcescontacttelephone->CurrentValue;
		$this->humanresourcescontactemailaddress->CurrentValue = NULL;
		$this->humanresourcescontactemailaddress->OldValue = $this->humanresourcescontactemailaddress->CurrentValue;
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
		if (!$this->maidenname->FldIsDetailKey) {
			$this->maidenname->setFormValue($objForm->GetValue("x_maidenname"));
		}
		if (!$this->identificationtype->FldIsDetailKey) {
			$this->identificationtype->setFormValue($objForm->GetValue("x_identificationtype"));
		}
		if (!$this->idnumber->FldIsDetailKey) {
			$this->idnumber->setFormValue($objForm->GetValue("x_idnumber"));
		}
		if (!$this->issuedate->FldIsDetailKey) {
			$this->issuedate->setFormValue($objForm->GetValue("x_issuedate"));
		}
		if (!$this->expirydate->FldIsDetailKey) {
			$this->expirydate->setFormValue($objForm->GetValue("x_expirydate"));
		}
		if (!$this->issueplace->FldIsDetailKey) {
			$this->issueplace->setFormValue($objForm->GetValue("x_issueplace"));
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
		if (!$this->spousename->FldIsDetailKey) {
			$this->spousename->setFormValue($objForm->GetValue("x_spousename"));
		}
		if (!$this->spouseemail->FldIsDetailKey) {
			$this->spouseemail->setFormValue($objForm->GetValue("x_spouseemail"));
		}
		if (!$this->spousephone->FldIsDetailKey) {
			$this->spousephone->setFormValue($objForm->GetValue("x_spousephone"));
		}
		if (!$this->spousedob->FldIsDetailKey) {
			$this->spousedob->setFormValue($objForm->GetValue("x_spousedob"));
		}
		if (!$this->spouseaddr->FldIsDetailKey) {
			$this->spouseaddr->setFormValue($objForm->GetValue("x_spouseaddr"));
		}
		if (!$this->spousecity->FldIsDetailKey) {
			$this->spousecity->setFormValue($objForm->GetValue("x_spousecity"));
		}
		if (!$this->spousestate->FldIsDetailKey) {
			$this->spousestate->setFormValue($objForm->GetValue("x_spousestate"));
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
		if (!$this->cityofmarriage->FldIsDetailKey) {
			$this->cityofmarriage->setFormValue($objForm->GetValue("x_cityofmarriage"));
		}
		if (!$this->countryofmarriage->FldIsDetailKey) {
			$this->countryofmarriage->setFormValue($objForm->GetValue("x_countryofmarriage"));
		}
		if (!$this->divorce->FldIsDetailKey) {
			$this->divorce->setFormValue($objForm->GetValue("x_divorce"));
		}
		if (!$this->divorceyear->FldIsDetailKey) {
			$this->divorceyear->setFormValue($objForm->GetValue("x_divorceyear"));
		}
		if (!$this->nextofkinfullname->FldIsDetailKey) {
			$this->nextofkinfullname->setFormValue($objForm->GetValue("x_nextofkinfullname"));
		}
		if (!$this->nextofkintelephone->FldIsDetailKey) {
			$this->nextofkintelephone->setFormValue($objForm->GetValue("x_nextofkintelephone"));
		}
		if (!$this->nextofkinemail->FldIsDetailKey) {
			$this->nextofkinemail->setFormValue($objForm->GetValue("x_nextofkinemail"));
		}
		if (!$this->nextofkinaddress->FldIsDetailKey) {
			$this->nextofkinaddress->setFormValue($objForm->GetValue("x_nextofkinaddress"));
		}
		if (!$this->nameofcompany->FldIsDetailKey) {
			$this->nameofcompany->setFormValue($objForm->GetValue("x_nameofcompany"));
		}
		if (!$this->humanresourcescontacttelephone->FldIsDetailKey) {
			$this->humanresourcescontacttelephone->setFormValue($objForm->GetValue("x_humanresourcescontacttelephone"));
		}
		if (!$this->humanresourcescontactemailaddress->FldIsDetailKey) {
			$this->humanresourcescontactemailaddress->setFormValue($objForm->GetValue("x_humanresourcescontactemailaddress"));
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
		$this->maidenname->CurrentValue = $this->maidenname->FormValue;
		$this->identificationtype->CurrentValue = $this->identificationtype->FormValue;
		$this->idnumber->CurrentValue = $this->idnumber->FormValue;
		$this->issuedate->CurrentValue = $this->issuedate->FormValue;
		$this->expirydate->CurrentValue = $this->expirydate->FormValue;
		$this->issueplace->CurrentValue = $this->issueplace->FormValue;
		$this->employmentstatus->CurrentValue = $this->employmentstatus->FormValue;
		$this->employer->CurrentValue = $this->employer->FormValue;
		$this->employerphone->CurrentValue = $this->employerphone->FormValue;
		$this->employeraddr->CurrentValue = $this->employeraddr->FormValue;
		$this->maritalstatus->CurrentValue = $this->maritalstatus->FormValue;
		$this->spousename->CurrentValue = $this->spousename->FormValue;
		$this->spouseemail->CurrentValue = $this->spouseemail->FormValue;
		$this->spousephone->CurrentValue = $this->spousephone->FormValue;
		$this->spousedob->CurrentValue = $this->spousedob->FormValue;
		$this->spouseaddr->CurrentValue = $this->spouseaddr->FormValue;
		$this->spousecity->CurrentValue = $this->spousecity->FormValue;
		$this->spousestate->CurrentValue = $this->spousestate->FormValue;
		$this->marriagetype->CurrentValue = $this->marriagetype->FormValue;
		$this->marriageyear->CurrentValue = $this->marriageyear->FormValue;
		$this->marriagecert->CurrentValue = $this->marriagecert->FormValue;
		$this->cityofmarriage->CurrentValue = $this->cityofmarriage->FormValue;
		$this->countryofmarriage->CurrentValue = $this->countryofmarriage->FormValue;
		$this->divorce->CurrentValue = $this->divorce->FormValue;
		$this->divorceyear->CurrentValue = $this->divorceyear->FormValue;
		$this->nextofkinfullname->CurrentValue = $this->nextofkinfullname->FormValue;
		$this->nextofkintelephone->CurrentValue = $this->nextofkintelephone->FormValue;
		$this->nextofkinemail->CurrentValue = $this->nextofkinemail->FormValue;
		$this->nextofkinaddress->CurrentValue = $this->nextofkinaddress->FormValue;
		$this->nameofcompany->CurrentValue = $this->nameofcompany->FormValue;
		$this->humanresourcescontacttelephone->CurrentValue = $this->humanresourcescontacttelephone->FormValue;
		$this->humanresourcescontactemailaddress->CurrentValue = $this->humanresourcescontactemailaddress->FormValue;
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
		$this->maidenname->setDbValue($rs->fields('maidenname'));
		$this->identificationtype->setDbValue($rs->fields('identificationtype'));
		$this->idnumber->setDbValue($rs->fields('idnumber'));
		$this->issuedate->setDbValue($rs->fields('issuedate'));
		$this->expirydate->setDbValue($rs->fields('expirydate'));
		$this->issueplace->setDbValue($rs->fields('issueplace'));
		$this->employmentstatus->setDbValue($rs->fields('employmentstatus'));
		$this->employer->setDbValue($rs->fields('employer'));
		$this->employerphone->setDbValue($rs->fields('employerphone'));
		$this->employeraddr->setDbValue($rs->fields('employeraddr'));
		$this->maritalstatus->setDbValue($rs->fields('maritalstatus'));
		$this->spousename->setDbValue($rs->fields('spousename'));
		$this->spouseemail->setDbValue($rs->fields('spouseemail'));
		$this->spousephone->setDbValue($rs->fields('spousephone'));
		$this->spousedob->setDbValue($rs->fields('spousedob'));
		$this->spouseaddr->setDbValue($rs->fields('spouseaddr'));
		$this->spousecity->setDbValue($rs->fields('spousecity'));
		$this->spousestate->setDbValue($rs->fields('spousestate'));
		$this->marriagetype->setDbValue($rs->fields('marriagetype'));
		$this->marriageyear->setDbValue($rs->fields('marriageyear'));
		$this->marriagecert->setDbValue($rs->fields('marriagecert'));
		$this->cityofmarriage->setDbValue($rs->fields('cityofmarriage'));
		$this->countryofmarriage->setDbValue($rs->fields('countryofmarriage'));
		$this->divorce->setDbValue($rs->fields('divorce'));
		$this->divorceyear->setDbValue($rs->fields('divorceyear'));
		$this->nextofkinfullname->setDbValue($rs->fields('nextofkinfullname'));
		$this->nextofkintelephone->setDbValue($rs->fields('nextofkintelephone'));
		$this->nextofkinemail->setDbValue($rs->fields('nextofkinemail'));
		$this->nextofkinaddress->setDbValue($rs->fields('nextofkinaddress'));
		$this->nameofcompany->setDbValue($rs->fields('nameofcompany'));
		$this->humanresourcescontacttelephone->setDbValue($rs->fields('humanresourcescontacttelephone'));
		$this->humanresourcescontactemailaddress->setDbValue($rs->fields('humanresourcescontactemailaddress'));
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
		$this->maidenname->DbValue = $row['maidenname'];
		$this->identificationtype->DbValue = $row['identificationtype'];
		$this->idnumber->DbValue = $row['idnumber'];
		$this->issuedate->DbValue = $row['issuedate'];
		$this->expirydate->DbValue = $row['expirydate'];
		$this->issueplace->DbValue = $row['issueplace'];
		$this->employmentstatus->DbValue = $row['employmentstatus'];
		$this->employer->DbValue = $row['employer'];
		$this->employerphone->DbValue = $row['employerphone'];
		$this->employeraddr->DbValue = $row['employeraddr'];
		$this->maritalstatus->DbValue = $row['maritalstatus'];
		$this->spousename->DbValue = $row['spousename'];
		$this->spouseemail->DbValue = $row['spouseemail'];
		$this->spousephone->DbValue = $row['spousephone'];
		$this->spousedob->DbValue = $row['spousedob'];
		$this->spouseaddr->DbValue = $row['spouseaddr'];
		$this->spousecity->DbValue = $row['spousecity'];
		$this->spousestate->DbValue = $row['spousestate'];
		$this->marriagetype->DbValue = $row['marriagetype'];
		$this->marriageyear->DbValue = $row['marriageyear'];
		$this->marriagecert->DbValue = $row['marriagecert'];
		$this->cityofmarriage->DbValue = $row['cityofmarriage'];
		$this->countryofmarriage->DbValue = $row['countryofmarriage'];
		$this->divorce->DbValue = $row['divorce'];
		$this->divorceyear->DbValue = $row['divorceyear'];
		$this->nextofkinfullname->DbValue = $row['nextofkinfullname'];
		$this->nextofkintelephone->DbValue = $row['nextofkintelephone'];
		$this->nextofkinemail->DbValue = $row['nextofkinemail'];
		$this->nextofkinaddress->DbValue = $row['nextofkinaddress'];
		$this->nameofcompany->DbValue = $row['nameofcompany'];
		$this->humanresourcescontacttelephone->DbValue = $row['humanresourcescontacttelephone'];
		$this->humanresourcescontactemailaddress->DbValue = $row['humanresourcescontactemailaddress'];
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
		// maidenname
		// identificationtype
		// idnumber
		// issuedate
		// expirydate
		// issueplace
		// employmentstatus
		// employer
		// employerphone
		// employeraddr
		// maritalstatus
		// spousename
		// spouseemail
		// spousephone
		// spousedob
		// spouseaddr
		// spousecity
		// spousestate
		// marriagetype
		// marriageyear
		// marriagecert
		// cityofmarriage
		// countryofmarriage
		// divorce
		// divorceyear
		// nextofkinfullname
		// nextofkintelephone
		// nextofkinemail
		// nextofkinaddress
		// nameofcompany
		// humanresourcescontacttelephone
		// humanresourcescontactemailaddress
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

			// maidenname
			$this->maidenname->ViewValue = $this->maidenname->CurrentValue;
			$this->maidenname->ViewCustomAttributes = "";

			// identificationtype
			$this->identificationtype->ViewValue = $this->identificationtype->CurrentValue;
			$this->identificationtype->ViewCustomAttributes = "";

			// idnumber
			$this->idnumber->ViewValue = $this->idnumber->CurrentValue;
			$this->idnumber->ViewCustomAttributes = "";

			// issuedate
			$this->issuedate->ViewValue = $this->issuedate->CurrentValue;
			$this->issuedate->ViewCustomAttributes = "";

			// expirydate
			$this->expirydate->ViewValue = $this->expirydate->CurrentValue;
			$this->expirydate->ViewCustomAttributes = "";

			// issueplace
			$this->issueplace->ViewValue = $this->issueplace->CurrentValue;
			$this->issueplace->ViewCustomAttributes = "";

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

			// spousename
			$this->spousename->ViewValue = $this->spousename->CurrentValue;
			$this->spousename->ViewCustomAttributes = "";

			// spouseemail
			$this->spouseemail->ViewValue = $this->spouseemail->CurrentValue;
			$this->spouseemail->ViewCustomAttributes = "";

			// spousephone
			$this->spousephone->ViewValue = $this->spousephone->CurrentValue;
			$this->spousephone->ViewCustomAttributes = "";

			// spousedob
			$this->spousedob->ViewValue = $this->spousedob->CurrentValue;
			$this->spousedob->ViewCustomAttributes = "";

			// spouseaddr
			$this->spouseaddr->ViewValue = $this->spouseaddr->CurrentValue;
			$this->spouseaddr->ViewCustomAttributes = "";

			// spousecity
			$this->spousecity->ViewValue = $this->spousecity->CurrentValue;
			$this->spousecity->ViewCustomAttributes = "";

			// spousestate
			$this->spousestate->ViewValue = $this->spousestate->CurrentValue;
			$this->spousestate->ViewCustomAttributes = "";

			// marriagetype
			$this->marriagetype->ViewValue = $this->marriagetype->CurrentValue;
			$this->marriagetype->ViewCustomAttributes = "";

			// marriageyear
			$this->marriageyear->ViewValue = $this->marriageyear->CurrentValue;
			$this->marriageyear->ViewCustomAttributes = "";

			// marriagecert
			$this->marriagecert->ViewValue = $this->marriagecert->CurrentValue;
			$this->marriagecert->ViewCustomAttributes = "";

			// cityofmarriage
			$this->cityofmarriage->ViewValue = $this->cityofmarriage->CurrentValue;
			$this->cityofmarriage->ViewCustomAttributes = "";

			// countryofmarriage
			$this->countryofmarriage->ViewValue = $this->countryofmarriage->CurrentValue;
			$this->countryofmarriage->ViewCustomAttributes = "";

			// divorce
			$this->divorce->ViewValue = $this->divorce->CurrentValue;
			$this->divorce->ViewCustomAttributes = "";

			// divorceyear
			$this->divorceyear->ViewValue = $this->divorceyear->CurrentValue;
			$this->divorceyear->ViewCustomAttributes = "";

			// nextofkinfullname
			$this->nextofkinfullname->ViewValue = $this->nextofkinfullname->CurrentValue;
			$this->nextofkinfullname->ViewCustomAttributes = "";

			// nextofkintelephone
			$this->nextofkintelephone->ViewValue = $this->nextofkintelephone->CurrentValue;
			$this->nextofkintelephone->ViewCustomAttributes = "";

			// nextofkinemail
			$this->nextofkinemail->ViewValue = $this->nextofkinemail->CurrentValue;
			$this->nextofkinemail->ViewCustomAttributes = "";

			// nextofkinaddress
			$this->nextofkinaddress->ViewValue = $this->nextofkinaddress->CurrentValue;
			$this->nextofkinaddress->ViewCustomAttributes = "";

			// nameofcompany
			$this->nameofcompany->ViewValue = $this->nameofcompany->CurrentValue;
			$this->nameofcompany->ViewCustomAttributes = "";

			// humanresourcescontacttelephone
			$this->humanresourcescontacttelephone->ViewValue = $this->humanresourcescontacttelephone->CurrentValue;
			$this->humanresourcescontacttelephone->ViewCustomAttributes = "";

			// humanresourcescontactemailaddress
			$this->humanresourcescontactemailaddress->ViewValue = $this->humanresourcescontactemailaddress->CurrentValue;
			$this->humanresourcescontactemailaddress->ViewCustomAttributes = "";

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
				$this->fullname->HrefValue = "http://tisvdigital.com/trustees/portal/adminsimplewill-preview.php?a=" . ((!empty($this->uid->ViewValue)) ? $this->uid->ViewValue : $this->uid->CurrentValue); // Add prefix/suffix
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

			// maidenname
			$this->maidenname->LinkCustomAttributes = "";
			$this->maidenname->HrefValue = "";
			$this->maidenname->TooltipValue = "";

			// identificationtype
			$this->identificationtype->LinkCustomAttributes = "";
			$this->identificationtype->HrefValue = "";
			$this->identificationtype->TooltipValue = "";

			// idnumber
			$this->idnumber->LinkCustomAttributes = "";
			$this->idnumber->HrefValue = "";
			$this->idnumber->TooltipValue = "";

			// issuedate
			$this->issuedate->LinkCustomAttributes = "";
			$this->issuedate->HrefValue = "";
			$this->issuedate->TooltipValue = "";

			// expirydate
			$this->expirydate->LinkCustomAttributes = "";
			$this->expirydate->HrefValue = "";
			$this->expirydate->TooltipValue = "";

			// issueplace
			$this->issueplace->LinkCustomAttributes = "";
			$this->issueplace->HrefValue = "";
			$this->issueplace->TooltipValue = "";

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

			// spousename
			$this->spousename->LinkCustomAttributes = "";
			$this->spousename->HrefValue = "";
			$this->spousename->TooltipValue = "";

			// spouseemail
			$this->spouseemail->LinkCustomAttributes = "";
			$this->spouseemail->HrefValue = "";
			$this->spouseemail->TooltipValue = "";

			// spousephone
			$this->spousephone->LinkCustomAttributes = "";
			$this->spousephone->HrefValue = "";
			$this->spousephone->TooltipValue = "";

			// spousedob
			$this->spousedob->LinkCustomAttributes = "";
			$this->spousedob->HrefValue = "";
			$this->spousedob->TooltipValue = "";

			// spouseaddr
			$this->spouseaddr->LinkCustomAttributes = "";
			$this->spouseaddr->HrefValue = "";
			$this->spouseaddr->TooltipValue = "";

			// spousecity
			$this->spousecity->LinkCustomAttributes = "";
			$this->spousecity->HrefValue = "";
			$this->spousecity->TooltipValue = "";

			// spousestate
			$this->spousestate->LinkCustomAttributes = "";
			$this->spousestate->HrefValue = "";
			$this->spousestate->TooltipValue = "";

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

			// cityofmarriage
			$this->cityofmarriage->LinkCustomAttributes = "";
			$this->cityofmarriage->HrefValue = "";
			$this->cityofmarriage->TooltipValue = "";

			// countryofmarriage
			$this->countryofmarriage->LinkCustomAttributes = "";
			$this->countryofmarriage->HrefValue = "";
			$this->countryofmarriage->TooltipValue = "";

			// divorce
			$this->divorce->LinkCustomAttributes = "";
			$this->divorce->HrefValue = "";
			$this->divorce->TooltipValue = "";

			// divorceyear
			$this->divorceyear->LinkCustomAttributes = "";
			$this->divorceyear->HrefValue = "";
			$this->divorceyear->TooltipValue = "";

			// nextofkinfullname
			$this->nextofkinfullname->LinkCustomAttributes = "";
			$this->nextofkinfullname->HrefValue = "";
			$this->nextofkinfullname->TooltipValue = "";

			// nextofkintelephone
			$this->nextofkintelephone->LinkCustomAttributes = "";
			$this->nextofkintelephone->HrefValue = "";
			$this->nextofkintelephone->TooltipValue = "";

			// nextofkinemail
			$this->nextofkinemail->LinkCustomAttributes = "";
			$this->nextofkinemail->HrefValue = "";
			$this->nextofkinemail->TooltipValue = "";

			// nextofkinaddress
			$this->nextofkinaddress->LinkCustomAttributes = "";
			$this->nextofkinaddress->HrefValue = "";
			$this->nextofkinaddress->TooltipValue = "";

			// nameofcompany
			$this->nameofcompany->LinkCustomAttributes = "";
			$this->nameofcompany->HrefValue = "";
			$this->nameofcompany->TooltipValue = "";

			// humanresourcescontacttelephone
			$this->humanresourcescontacttelephone->LinkCustomAttributes = "";
			$this->humanresourcescontacttelephone->HrefValue = "";
			$this->humanresourcescontacttelephone->TooltipValue = "";

			// humanresourcescontactemailaddress
			$this->humanresourcescontactemailaddress->LinkCustomAttributes = "";
			$this->humanresourcescontactemailaddress->HrefValue = "";
			$this->humanresourcescontactemailaddress->TooltipValue = "";

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
			$this->willtype->EditCustomAttributes = "";
			$this->willtype->EditValue = ew_HtmlEncode($this->willtype->CurrentValue);
			$this->willtype->PlaceHolder = ew_HtmlEncode(ew_RemoveHtml($this->willtype->FldCaption()));

			// fullname
			$this->fullname->EditCustomAttributes = "";
			$this->fullname->EditValue = ew_HtmlEncode($this->fullname->CurrentValue);
			$this->fullname->PlaceHolder = ew_HtmlEncode(ew_RemoveHtml($this->fullname->FldCaption()));

			// address
			$this->address->EditCustomAttributes = "";
			$this->address->EditValue = $this->address->CurrentValue;
			$this->address->PlaceHolder = ew_HtmlEncode(ew_RemoveHtml($this->address->FldCaption()));

			// email
			$this->_email->EditCustomAttributes = "";
			$this->_email->EditValue = ew_HtmlEncode($this->_email->CurrentValue);
			$this->_email->PlaceHolder = ew_HtmlEncode(ew_RemoveHtml($this->_email->FldCaption()));

			// phoneno
			$this->phoneno->EditCustomAttributes = "";
			$this->phoneno->EditValue = ew_HtmlEncode($this->phoneno->CurrentValue);
			$this->phoneno->PlaceHolder = ew_HtmlEncode(ew_RemoveHtml($this->phoneno->FldCaption()));

			// aphoneno
			$this->aphoneno->EditCustomAttributes = "";
			$this->aphoneno->EditValue = ew_HtmlEncode($this->aphoneno->CurrentValue);
			$this->aphoneno->PlaceHolder = ew_HtmlEncode(ew_RemoveHtml($this->aphoneno->FldCaption()));

			// gender
			$this->gender->EditCustomAttributes = "";
			$this->gender->EditValue = ew_HtmlEncode($this->gender->CurrentValue);
			$this->gender->PlaceHolder = ew_HtmlEncode(ew_RemoveHtml($this->gender->FldCaption()));

			// dob
			$this->dob->EditCustomAttributes = "";
			$this->dob->EditValue = ew_HtmlEncode($this->dob->CurrentValue);
			$this->dob->PlaceHolder = ew_HtmlEncode(ew_RemoveHtml($this->dob->FldCaption()));

			// state
			$this->state->EditCustomAttributes = "";
			$this->state->EditValue = ew_HtmlEncode($this->state->CurrentValue);
			$this->state->PlaceHolder = ew_HtmlEncode(ew_RemoveHtml($this->state->FldCaption()));

			// nationality
			$this->nationality->EditCustomAttributes = "";
			$this->nationality->EditValue = ew_HtmlEncode($this->nationality->CurrentValue);
			$this->nationality->PlaceHolder = ew_HtmlEncode(ew_RemoveHtml($this->nationality->FldCaption()));

			// lga
			$this->lga->EditCustomAttributes = "";
			$this->lga->EditValue = ew_HtmlEncode($this->lga->CurrentValue);
			$this->lga->PlaceHolder = ew_HtmlEncode(ew_RemoveHtml($this->lga->FldCaption()));

			// maidenname
			$this->maidenname->EditCustomAttributes = "";
			$this->maidenname->EditValue = ew_HtmlEncode($this->maidenname->CurrentValue);
			$this->maidenname->PlaceHolder = ew_HtmlEncode(ew_RemoveHtml($this->maidenname->FldCaption()));

			// identificationtype
			$this->identificationtype->EditCustomAttributes = "";
			$this->identificationtype->EditValue = ew_HtmlEncode($this->identificationtype->CurrentValue);
			$this->identificationtype->PlaceHolder = ew_HtmlEncode(ew_RemoveHtml($this->identificationtype->FldCaption()));

			// idnumber
			$this->idnumber->EditCustomAttributes = "";
			$this->idnumber->EditValue = ew_HtmlEncode($this->idnumber->CurrentValue);
			$this->idnumber->PlaceHolder = ew_HtmlEncode(ew_RemoveHtml($this->idnumber->FldCaption()));

			// issuedate
			$this->issuedate->EditCustomAttributes = "";
			$this->issuedate->EditValue = ew_HtmlEncode($this->issuedate->CurrentValue);
			$this->issuedate->PlaceHolder = ew_HtmlEncode(ew_RemoveHtml($this->issuedate->FldCaption()));

			// expirydate
			$this->expirydate->EditCustomAttributes = "";
			$this->expirydate->EditValue = ew_HtmlEncode($this->expirydate->CurrentValue);
			$this->expirydate->PlaceHolder = ew_HtmlEncode(ew_RemoveHtml($this->expirydate->FldCaption()));

			// issueplace
			$this->issueplace->EditCustomAttributes = "";
			$this->issueplace->EditValue = ew_HtmlEncode($this->issueplace->CurrentValue);
			$this->issueplace->PlaceHolder = ew_HtmlEncode(ew_RemoveHtml($this->issueplace->FldCaption()));

			// employmentstatus
			$this->employmentstatus->EditCustomAttributes = "";
			$this->employmentstatus->EditValue = ew_HtmlEncode($this->employmentstatus->CurrentValue);
			$this->employmentstatus->PlaceHolder = ew_HtmlEncode(ew_RemoveHtml($this->employmentstatus->FldCaption()));

			// employer
			$this->employer->EditCustomAttributes = "";
			$this->employer->EditValue = $this->employer->CurrentValue;
			$this->employer->PlaceHolder = ew_HtmlEncode(ew_RemoveHtml($this->employer->FldCaption()));

			// employerphone
			$this->employerphone->EditCustomAttributes = "";
			$this->employerphone->EditValue = ew_HtmlEncode($this->employerphone->CurrentValue);
			$this->employerphone->PlaceHolder = ew_HtmlEncode(ew_RemoveHtml($this->employerphone->FldCaption()));

			// employeraddr
			$this->employeraddr->EditCustomAttributes = "";
			$this->employeraddr->EditValue = $this->employeraddr->CurrentValue;
			$this->employeraddr->PlaceHolder = ew_HtmlEncode(ew_RemoveHtml($this->employeraddr->FldCaption()));

			// maritalstatus
			$this->maritalstatus->EditCustomAttributes = "";
			$this->maritalstatus->EditValue = ew_HtmlEncode($this->maritalstatus->CurrentValue);
			$this->maritalstatus->PlaceHolder = ew_HtmlEncode(ew_RemoveHtml($this->maritalstatus->FldCaption()));

			// spousename
			$this->spousename->EditCustomAttributes = "";
			$this->spousename->EditValue = ew_HtmlEncode($this->spousename->CurrentValue);
			$this->spousename->PlaceHolder = ew_HtmlEncode(ew_RemoveHtml($this->spousename->FldCaption()));

			// spouseemail
			$this->spouseemail->EditCustomAttributes = "";
			$this->spouseemail->EditValue = ew_HtmlEncode($this->spouseemail->CurrentValue);
			$this->spouseemail->PlaceHolder = ew_HtmlEncode(ew_RemoveHtml($this->spouseemail->FldCaption()));

			// spousephone
			$this->spousephone->EditCustomAttributes = "";
			$this->spousephone->EditValue = ew_HtmlEncode($this->spousephone->CurrentValue);
			$this->spousephone->PlaceHolder = ew_HtmlEncode(ew_RemoveHtml($this->spousephone->FldCaption()));

			// spousedob
			$this->spousedob->EditCustomAttributes = "";
			$this->spousedob->EditValue = ew_HtmlEncode($this->spousedob->CurrentValue);
			$this->spousedob->PlaceHolder = ew_HtmlEncode(ew_RemoveHtml($this->spousedob->FldCaption()));

			// spouseaddr
			$this->spouseaddr->EditCustomAttributes = "";
			$this->spouseaddr->EditValue = $this->spouseaddr->CurrentValue;
			$this->spouseaddr->PlaceHolder = ew_HtmlEncode(ew_RemoveHtml($this->spouseaddr->FldCaption()));

			// spousecity
			$this->spousecity->EditCustomAttributes = "";
			$this->spousecity->EditValue = ew_HtmlEncode($this->spousecity->CurrentValue);
			$this->spousecity->PlaceHolder = ew_HtmlEncode(ew_RemoveHtml($this->spousecity->FldCaption()));

			// spousestate
			$this->spousestate->EditCustomAttributes = "";
			$this->spousestate->EditValue = ew_HtmlEncode($this->spousestate->CurrentValue);
			$this->spousestate->PlaceHolder = ew_HtmlEncode(ew_RemoveHtml($this->spousestate->FldCaption()));

			// marriagetype
			$this->marriagetype->EditCustomAttributes = "";
			$this->marriagetype->EditValue = ew_HtmlEncode($this->marriagetype->CurrentValue);
			$this->marriagetype->PlaceHolder = ew_HtmlEncode(ew_RemoveHtml($this->marriagetype->FldCaption()));

			// marriageyear
			$this->marriageyear->EditCustomAttributes = "";
			$this->marriageyear->EditValue = ew_HtmlEncode($this->marriageyear->CurrentValue);
			$this->marriageyear->PlaceHolder = ew_HtmlEncode(ew_RemoveHtml($this->marriageyear->FldCaption()));

			// marriagecert
			$this->marriagecert->EditCustomAttributes = "";
			$this->marriagecert->EditValue = ew_HtmlEncode($this->marriagecert->CurrentValue);
			$this->marriagecert->PlaceHolder = ew_HtmlEncode(ew_RemoveHtml($this->marriagecert->FldCaption()));

			// cityofmarriage
			$this->cityofmarriage->EditCustomAttributes = "";
			$this->cityofmarriage->EditValue = ew_HtmlEncode($this->cityofmarriage->CurrentValue);
			$this->cityofmarriage->PlaceHolder = ew_HtmlEncode(ew_RemoveHtml($this->cityofmarriage->FldCaption()));

			// countryofmarriage
			$this->countryofmarriage->EditCustomAttributes = "";
			$this->countryofmarriage->EditValue = ew_HtmlEncode($this->countryofmarriage->CurrentValue);
			$this->countryofmarriage->PlaceHolder = ew_HtmlEncode(ew_RemoveHtml($this->countryofmarriage->FldCaption()));

			// divorce
			$this->divorce->EditCustomAttributes = "";
			$this->divorce->EditValue = ew_HtmlEncode($this->divorce->CurrentValue);
			$this->divorce->PlaceHolder = ew_HtmlEncode(ew_RemoveHtml($this->divorce->FldCaption()));

			// divorceyear
			$this->divorceyear->EditCustomAttributes = "";
			$this->divorceyear->EditValue = ew_HtmlEncode($this->divorceyear->CurrentValue);
			$this->divorceyear->PlaceHolder = ew_HtmlEncode(ew_RemoveHtml($this->divorceyear->FldCaption()));

			// nextofkinfullname
			$this->nextofkinfullname->EditCustomAttributes = "";
			$this->nextofkinfullname->EditValue = ew_HtmlEncode($this->nextofkinfullname->CurrentValue);
			$this->nextofkinfullname->PlaceHolder = ew_HtmlEncode(ew_RemoveHtml($this->nextofkinfullname->FldCaption()));

			// nextofkintelephone
			$this->nextofkintelephone->EditCustomAttributes = "";
			$this->nextofkintelephone->EditValue = ew_HtmlEncode($this->nextofkintelephone->CurrentValue);
			$this->nextofkintelephone->PlaceHolder = ew_HtmlEncode(ew_RemoveHtml($this->nextofkintelephone->FldCaption()));

			// nextofkinemail
			$this->nextofkinemail->EditCustomAttributes = "";
			$this->nextofkinemail->EditValue = ew_HtmlEncode($this->nextofkinemail->CurrentValue);
			$this->nextofkinemail->PlaceHolder = ew_HtmlEncode(ew_RemoveHtml($this->nextofkinemail->FldCaption()));

			// nextofkinaddress
			$this->nextofkinaddress->EditCustomAttributes = "";
			$this->nextofkinaddress->EditValue = $this->nextofkinaddress->CurrentValue;
			$this->nextofkinaddress->PlaceHolder = ew_HtmlEncode(ew_RemoveHtml($this->nextofkinaddress->FldCaption()));

			// nameofcompany
			$this->nameofcompany->EditCustomAttributes = "";
			$this->nameofcompany->EditValue = ew_HtmlEncode($this->nameofcompany->CurrentValue);
			$this->nameofcompany->PlaceHolder = ew_HtmlEncode(ew_RemoveHtml($this->nameofcompany->FldCaption()));

			// humanresourcescontacttelephone
			$this->humanresourcescontacttelephone->EditCustomAttributes = "";
			$this->humanresourcescontacttelephone->EditValue = ew_HtmlEncode($this->humanresourcescontacttelephone->CurrentValue);
			$this->humanresourcescontacttelephone->PlaceHolder = ew_HtmlEncode(ew_RemoveHtml($this->humanresourcescontacttelephone->FldCaption()));

			// humanresourcescontactemailaddress
			$this->humanresourcescontactemailaddress->EditCustomAttributes = "";
			$this->humanresourcescontactemailaddress->EditValue = ew_HtmlEncode($this->humanresourcescontactemailaddress->CurrentValue);
			$this->humanresourcescontactemailaddress->PlaceHolder = ew_HtmlEncode(ew_RemoveHtml($this->humanresourcescontactemailaddress->FldCaption()));

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
				$this->fullname->HrefValue = "http://tisvdigital.com/trustees/portal/adminsimplewill-preview.php?a=" . ((!empty($this->uid->EditValue)) ? $this->uid->EditValue : $this->uid->CurrentValue); // Add prefix/suffix
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

			// maidenname
			$this->maidenname->HrefValue = "";

			// identificationtype
			$this->identificationtype->HrefValue = "";

			// idnumber
			$this->idnumber->HrefValue = "";

			// issuedate
			$this->issuedate->HrefValue = "";

			// expirydate
			$this->expirydate->HrefValue = "";

			// issueplace
			$this->issueplace->HrefValue = "";

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

			// spousename
			$this->spousename->HrefValue = "";

			// spouseemail
			$this->spouseemail->HrefValue = "";

			// spousephone
			$this->spousephone->HrefValue = "";

			// spousedob
			$this->spousedob->HrefValue = "";

			// spouseaddr
			$this->spouseaddr->HrefValue = "";

			// spousecity
			$this->spousecity->HrefValue = "";

			// spousestate
			$this->spousestate->HrefValue = "";

			// marriagetype
			$this->marriagetype->HrefValue = "";

			// marriageyear
			$this->marriageyear->HrefValue = "";

			// marriagecert
			$this->marriagecert->HrefValue = "";

			// cityofmarriage
			$this->cityofmarriage->HrefValue = "";

			// countryofmarriage
			$this->countryofmarriage->HrefValue = "";

			// divorce
			$this->divorce->HrefValue = "";

			// divorceyear
			$this->divorceyear->HrefValue = "";

			// nextofkinfullname
			$this->nextofkinfullname->HrefValue = "";

			// nextofkintelephone
			$this->nextofkintelephone->HrefValue = "";

			// nextofkinemail
			$this->nextofkinemail->HrefValue = "";

			// nextofkinaddress
			$this->nextofkinaddress->HrefValue = "";

			// nameofcompany
			$this->nameofcompany->HrefValue = "";

			// humanresourcescontacttelephone
			$this->humanresourcescontacttelephone->HrefValue = "";

			// humanresourcescontactemailaddress
			$this->humanresourcescontactemailaddress->HrefValue = "";

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
		if (in_array("simplewill_assets_tb", $DetailTblVar) && $GLOBALS["simplewill_assets_tb"]->DetailAdd) {
			if (!isset($GLOBALS["simplewill_assets_tb_grid"])) $GLOBALS["simplewill_assets_tb_grid"] = new csimplewill_assets_tb_grid(); // get detail page object
			$GLOBALS["simplewill_assets_tb_grid"]->ValidateGridForm();
		}
		if (in_array("simplewill_overall_asset", $DetailTblVar) && $GLOBALS["simplewill_overall_asset"]->DetailAdd) {
			if (!isset($GLOBALS["simplewill_overall_asset_grid"])) $GLOBALS["simplewill_overall_asset_grid"] = new csimplewill_overall_asset_grid(); // get detail page object
			$GLOBALS["simplewill_overall_asset_grid"]->ValidateGridForm();
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

		// maidenname
		$this->maidenname->SetDbValueDef($rsnew, $this->maidenname->CurrentValue, NULL, FALSE);

		// identificationtype
		$this->identificationtype->SetDbValueDef($rsnew, $this->identificationtype->CurrentValue, NULL, FALSE);

		// idnumber
		$this->idnumber->SetDbValueDef($rsnew, $this->idnumber->CurrentValue, NULL, FALSE);

		// issuedate
		$this->issuedate->SetDbValueDef($rsnew, $this->issuedate->CurrentValue, NULL, FALSE);

		// expirydate
		$this->expirydate->SetDbValueDef($rsnew, $this->expirydate->CurrentValue, NULL, FALSE);

		// issueplace
		$this->issueplace->SetDbValueDef($rsnew, $this->issueplace->CurrentValue, NULL, FALSE);

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

		// spousename
		$this->spousename->SetDbValueDef($rsnew, $this->spousename->CurrentValue, NULL, FALSE);

		// spouseemail
		$this->spouseemail->SetDbValueDef($rsnew, $this->spouseemail->CurrentValue, NULL, FALSE);

		// spousephone
		$this->spousephone->SetDbValueDef($rsnew, $this->spousephone->CurrentValue, NULL, FALSE);

		// spousedob
		$this->spousedob->SetDbValueDef($rsnew, $this->spousedob->CurrentValue, NULL, FALSE);

		// spouseaddr
		$this->spouseaddr->SetDbValueDef($rsnew, $this->spouseaddr->CurrentValue, NULL, FALSE);

		// spousecity
		$this->spousecity->SetDbValueDef($rsnew, $this->spousecity->CurrentValue, NULL, FALSE);

		// spousestate
		$this->spousestate->SetDbValueDef($rsnew, $this->spousestate->CurrentValue, NULL, FALSE);

		// marriagetype
		$this->marriagetype->SetDbValueDef($rsnew, $this->marriagetype->CurrentValue, NULL, FALSE);

		// marriageyear
		$this->marriageyear->SetDbValueDef($rsnew, $this->marriageyear->CurrentValue, NULL, FALSE);

		// marriagecert
		$this->marriagecert->SetDbValueDef($rsnew, $this->marriagecert->CurrentValue, NULL, FALSE);

		// cityofmarriage
		$this->cityofmarriage->SetDbValueDef($rsnew, $this->cityofmarriage->CurrentValue, NULL, FALSE);

		// countryofmarriage
		$this->countryofmarriage->SetDbValueDef($rsnew, $this->countryofmarriage->CurrentValue, NULL, FALSE);

		// divorce
		$this->divorce->SetDbValueDef($rsnew, $this->divorce->CurrentValue, NULL, FALSE);

		// divorceyear
		$this->divorceyear->SetDbValueDef($rsnew, $this->divorceyear->CurrentValue, NULL, FALSE);

		// nextofkinfullname
		$this->nextofkinfullname->SetDbValueDef($rsnew, $this->nextofkinfullname->CurrentValue, NULL, FALSE);

		// nextofkintelephone
		$this->nextofkintelephone->SetDbValueDef($rsnew, $this->nextofkintelephone->CurrentValue, NULL, FALSE);

		// nextofkinemail
		$this->nextofkinemail->SetDbValueDef($rsnew, $this->nextofkinemail->CurrentValue, NULL, FALSE);

		// nextofkinaddress
		$this->nextofkinaddress->SetDbValueDef($rsnew, $this->nextofkinaddress->CurrentValue, NULL, FALSE);

		// nameofcompany
		$this->nameofcompany->SetDbValueDef($rsnew, $this->nameofcompany->CurrentValue, NULL, FALSE);

		// humanresourcescontacttelephone
		$this->humanresourcescontacttelephone->SetDbValueDef($rsnew, $this->humanresourcescontacttelephone->CurrentValue, NULL, FALSE);

		// humanresourcescontactemailaddress
		$this->humanresourcescontactemailaddress->SetDbValueDef($rsnew, $this->humanresourcescontactemailaddress->CurrentValue, NULL, FALSE);

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
			if (in_array("simplewill_assets_tb", $DetailTblVar) && $GLOBALS["simplewill_assets_tb"]->DetailAdd) {
				$GLOBALS["simplewill_assets_tb"]->uid->setSessionValue($this->uid->CurrentValue); // Set master key
				if (!isset($GLOBALS["simplewill_assets_tb_grid"])) $GLOBALS["simplewill_assets_tb_grid"] = new csimplewill_assets_tb_grid(); // Get detail page object
				$AddRow = $GLOBALS["simplewill_assets_tb_grid"]->GridInsert();
				if (!$AddRow)
					$GLOBALS["simplewill_assets_tb"]->uid->setSessionValue(""); // Clear master key if insert failed
			}
			if (in_array("simplewill_overall_asset", $DetailTblVar) && $GLOBALS["simplewill_overall_asset"]->DetailAdd) {
				$GLOBALS["simplewill_overall_asset"]->uid->setSessionValue($this->uid->CurrentValue); // Set master key
				if (!isset($GLOBALS["simplewill_overall_asset_grid"])) $GLOBALS["simplewill_overall_asset_grid"] = new csimplewill_overall_asset_grid(); // Get detail page object
				$AddRow = $GLOBALS["simplewill_overall_asset_grid"]->GridInsert();
				if (!$AddRow)
					$GLOBALS["simplewill_overall_asset"]->uid->setSessionValue(""); // Clear master key if insert failed
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
			if (in_array("simplewill_assets_tb", $DetailTblVar)) {
				if (!isset($GLOBALS["simplewill_assets_tb_grid"]))
					$GLOBALS["simplewill_assets_tb_grid"] = new csimplewill_assets_tb_grid;
				if ($GLOBALS["simplewill_assets_tb_grid"]->DetailAdd) {
					if ($this->CopyRecord)
						$GLOBALS["simplewill_assets_tb_grid"]->CurrentMode = "copy";
					else
						$GLOBALS["simplewill_assets_tb_grid"]->CurrentMode = "add";
					$GLOBALS["simplewill_assets_tb_grid"]->CurrentAction = "gridadd";

					// Save current master table to detail table
					$GLOBALS["simplewill_assets_tb_grid"]->setCurrentMasterTable($this->TableVar);
					$GLOBALS["simplewill_assets_tb_grid"]->setStartRecordNumber(1);
					$GLOBALS["simplewill_assets_tb_grid"]->uid->FldIsDetailKey = TRUE;
					$GLOBALS["simplewill_assets_tb_grid"]->uid->CurrentValue = $this->uid->CurrentValue;
					$GLOBALS["simplewill_assets_tb_grid"]->uid->setSessionValue($GLOBALS["simplewill_assets_tb_grid"]->uid->CurrentValue);
				}
			}
			if (in_array("simplewill_overall_asset", $DetailTblVar)) {
				if (!isset($GLOBALS["simplewill_overall_asset_grid"]))
					$GLOBALS["simplewill_overall_asset_grid"] = new csimplewill_overall_asset_grid;
				if ($GLOBALS["simplewill_overall_asset_grid"]->DetailAdd) {
					if ($this->CopyRecord)
						$GLOBALS["simplewill_overall_asset_grid"]->CurrentMode = "copy";
					else
						$GLOBALS["simplewill_overall_asset_grid"]->CurrentMode = "add";
					$GLOBALS["simplewill_overall_asset_grid"]->CurrentAction = "gridadd";

					// Save current master table to detail table
					$GLOBALS["simplewill_overall_asset_grid"]->setCurrentMasterTable($this->TableVar);
					$GLOBALS["simplewill_overall_asset_grid"]->setStartRecordNumber(1);
					$GLOBALS["simplewill_overall_asset_grid"]->uid->FldIsDetailKey = TRUE;
					$GLOBALS["simplewill_overall_asset_grid"]->uid->CurrentValue = $this->uid->CurrentValue;
					$GLOBALS["simplewill_overall_asset_grid"]->uid->setSessionValue($GLOBALS["simplewill_overall_asset_grid"]->uid->CurrentValue);
				}
			}
		}
	}

	// Set up Breadcrumb
	function SetupBreadcrumb() {
		global $Breadcrumb, $Language;
		$Breadcrumb = new cBreadcrumb();
		$PageCaption = $this->TableCaption();
		$Breadcrumb->Add("list", "<span id=\"ewPageCaption\">" . $PageCaption . "</span>", "simplewill_tblist.php", $this->TableVar);
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
if (!isset($simplewill_tb_add)) $simplewill_tb_add = new csimplewill_tb_add();

// Page init
$simplewill_tb_add->Page_Init();

// Page main
$simplewill_tb_add->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$simplewill_tb_add->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Page object
var simplewill_tb_add = new ew_Page("simplewill_tb_add");
simplewill_tb_add.PageID = "add"; // Page ID
var EW_PAGE_ID = simplewill_tb_add.PageID; // For backward compatibility

// Form object
var fsimplewill_tbadd = new ew_Form("fsimplewill_tbadd");

// Validate form
fsimplewill_tbadd.Validate = function() {
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
				return this.OnError(elm, "<?php echo ew_JsEncode2($simplewill_tb->uid->FldErrMsg()) ?>");

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
fsimplewill_tbadd.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
fsimplewill_tbadd.ValidateRequired = true;
<?php } else { ?>
fsimplewill_tbadd.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
// Form object for search

</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<?php $Breadcrumb->Render(); ?>
<?php $simplewill_tb_add->ShowPageHeader(); ?>
<?php
$simplewill_tb_add->ShowMessage();
?>
<form name="fsimplewill_tbadd" id="fsimplewill_tbadd" class="ewForm form-horizontal" action="<?php echo ew_CurrentPage() ?>" method="post">
<input type="hidden" name="t" value="simplewill_tb">
<input type="hidden" name="a_add" id="a_add" value="A">
<table cellspacing="0" class="ewGrid"><tr><td>
<table id="tbl_simplewill_tbadd" class="table table-bordered table-striped">
<?php if ($simplewill_tb->uid->Visible) { // uid ?>
	<tr id="r_uid">
		<td><span id="elh_simplewill_tb_uid"><?php echo $simplewill_tb->uid->FldCaption() ?></span></td>
		<td<?php echo $simplewill_tb->uid->CellAttributes() ?>>
<span id="el_simplewill_tb_uid" class="control-group">
<input type="text" data-field="x_uid" name="x_uid" id="x_uid" size="30" placeholder="<?php echo $simplewill_tb->uid->PlaceHolder ?>" value="<?php echo $simplewill_tb->uid->EditValue ?>"<?php echo $simplewill_tb->uid->EditAttributes() ?>>
</span>
<?php echo $simplewill_tb->uid->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($simplewill_tb->willtype->Visible) { // willtype ?>
	<tr id="r_willtype">
		<td><span id="elh_simplewill_tb_willtype"><?php echo $simplewill_tb->willtype->FldCaption() ?></span></td>
		<td<?php echo $simplewill_tb->willtype->CellAttributes() ?>>
<span id="el_simplewill_tb_willtype" class="control-group">
<input type="text" data-field="x_willtype" name="x_willtype" id="x_willtype" size="30" maxlength="100" placeholder="<?php echo $simplewill_tb->willtype->PlaceHolder ?>" value="<?php echo $simplewill_tb->willtype->EditValue ?>"<?php echo $simplewill_tb->willtype->EditAttributes() ?>>
</span>
<?php echo $simplewill_tb->willtype->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($simplewill_tb->fullname->Visible) { // fullname ?>
	<tr id="r_fullname">
		<td><span id="elh_simplewill_tb_fullname"><?php echo $simplewill_tb->fullname->FldCaption() ?></span></td>
		<td<?php echo $simplewill_tb->fullname->CellAttributes() ?>>
<span id="el_simplewill_tb_fullname" class="control-group">
<input type="text" data-field="x_fullname" name="x_fullname" id="x_fullname" size="30" maxlength="100" placeholder="<?php echo $simplewill_tb->fullname->PlaceHolder ?>" value="<?php echo $simplewill_tb->fullname->EditValue ?>"<?php echo $simplewill_tb->fullname->EditAttributes() ?>>
</span>
<?php echo $simplewill_tb->fullname->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($simplewill_tb->address->Visible) { // address ?>
	<tr id="r_address">
		<td><span id="elh_simplewill_tb_address"><?php echo $simplewill_tb->address->FldCaption() ?></span></td>
		<td<?php echo $simplewill_tb->address->CellAttributes() ?>>
<span id="el_simplewill_tb_address" class="control-group">
<textarea data-field="x_address" name="x_address" id="x_address" cols="35" rows="4" placeholder="<?php echo $simplewill_tb->address->PlaceHolder ?>"<?php echo $simplewill_tb->address->EditAttributes() ?>><?php echo $simplewill_tb->address->EditValue ?></textarea>
</span>
<?php echo $simplewill_tb->address->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($simplewill_tb->_email->Visible) { // email ?>
	<tr id="r__email">
		<td><span id="elh_simplewill_tb__email"><?php echo $simplewill_tb->_email->FldCaption() ?></span></td>
		<td<?php echo $simplewill_tb->_email->CellAttributes() ?>>
<span id="el_simplewill_tb__email" class="control-group">
<input type="text" data-field="x__email" name="x__email" id="x__email" size="30" maxlength="50" placeholder="<?php echo $simplewill_tb->_email->PlaceHolder ?>" value="<?php echo $simplewill_tb->_email->EditValue ?>"<?php echo $simplewill_tb->_email->EditAttributes() ?>>
</span>
<?php echo $simplewill_tb->_email->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($simplewill_tb->phoneno->Visible) { // phoneno ?>
	<tr id="r_phoneno">
		<td><span id="elh_simplewill_tb_phoneno"><?php echo $simplewill_tb->phoneno->FldCaption() ?></span></td>
		<td<?php echo $simplewill_tb->phoneno->CellAttributes() ?>>
<span id="el_simplewill_tb_phoneno" class="control-group">
<input type="text" data-field="x_phoneno" name="x_phoneno" id="x_phoneno" size="30" maxlength="20" placeholder="<?php echo $simplewill_tb->phoneno->PlaceHolder ?>" value="<?php echo $simplewill_tb->phoneno->EditValue ?>"<?php echo $simplewill_tb->phoneno->EditAttributes() ?>>
</span>
<?php echo $simplewill_tb->phoneno->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($simplewill_tb->aphoneno->Visible) { // aphoneno ?>
	<tr id="r_aphoneno">
		<td><span id="elh_simplewill_tb_aphoneno"><?php echo $simplewill_tb->aphoneno->FldCaption() ?></span></td>
		<td<?php echo $simplewill_tb->aphoneno->CellAttributes() ?>>
<span id="el_simplewill_tb_aphoneno" class="control-group">
<input type="text" data-field="x_aphoneno" name="x_aphoneno" id="x_aphoneno" size="30" maxlength="20" placeholder="<?php echo $simplewill_tb->aphoneno->PlaceHolder ?>" value="<?php echo $simplewill_tb->aphoneno->EditValue ?>"<?php echo $simplewill_tb->aphoneno->EditAttributes() ?>>
</span>
<?php echo $simplewill_tb->aphoneno->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($simplewill_tb->gender->Visible) { // gender ?>
	<tr id="r_gender">
		<td><span id="elh_simplewill_tb_gender"><?php echo $simplewill_tb->gender->FldCaption() ?></span></td>
		<td<?php echo $simplewill_tb->gender->CellAttributes() ?>>
<span id="el_simplewill_tb_gender" class="control-group">
<input type="text" data-field="x_gender" name="x_gender" id="x_gender" size="30" maxlength="10" placeholder="<?php echo $simplewill_tb->gender->PlaceHolder ?>" value="<?php echo $simplewill_tb->gender->EditValue ?>"<?php echo $simplewill_tb->gender->EditAttributes() ?>>
</span>
<?php echo $simplewill_tb->gender->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($simplewill_tb->dob->Visible) { // dob ?>
	<tr id="r_dob">
		<td><span id="elh_simplewill_tb_dob"><?php echo $simplewill_tb->dob->FldCaption() ?></span></td>
		<td<?php echo $simplewill_tb->dob->CellAttributes() ?>>
<span id="el_simplewill_tb_dob" class="control-group">
<input type="text" data-field="x_dob" name="x_dob" id="x_dob" size="30" maxlength="20" placeholder="<?php echo $simplewill_tb->dob->PlaceHolder ?>" value="<?php echo $simplewill_tb->dob->EditValue ?>"<?php echo $simplewill_tb->dob->EditAttributes() ?>>
</span>
<?php echo $simplewill_tb->dob->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($simplewill_tb->state->Visible) { // state ?>
	<tr id="r_state">
		<td><span id="elh_simplewill_tb_state"><?php echo $simplewill_tb->state->FldCaption() ?></span></td>
		<td<?php echo $simplewill_tb->state->CellAttributes() ?>>
<span id="el_simplewill_tb_state" class="control-group">
<input type="text" data-field="x_state" name="x_state" id="x_state" size="30" maxlength="20" placeholder="<?php echo $simplewill_tb->state->PlaceHolder ?>" value="<?php echo $simplewill_tb->state->EditValue ?>"<?php echo $simplewill_tb->state->EditAttributes() ?>>
</span>
<?php echo $simplewill_tb->state->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($simplewill_tb->nationality->Visible) { // nationality ?>
	<tr id="r_nationality">
		<td><span id="elh_simplewill_tb_nationality"><?php echo $simplewill_tb->nationality->FldCaption() ?></span></td>
		<td<?php echo $simplewill_tb->nationality->CellAttributes() ?>>
<span id="el_simplewill_tb_nationality" class="control-group">
<input type="text" data-field="x_nationality" name="x_nationality" id="x_nationality" size="30" maxlength="20" placeholder="<?php echo $simplewill_tb->nationality->PlaceHolder ?>" value="<?php echo $simplewill_tb->nationality->EditValue ?>"<?php echo $simplewill_tb->nationality->EditAttributes() ?>>
</span>
<?php echo $simplewill_tb->nationality->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($simplewill_tb->lga->Visible) { // lga ?>
	<tr id="r_lga">
		<td><span id="elh_simplewill_tb_lga"><?php echo $simplewill_tb->lga->FldCaption() ?></span></td>
		<td<?php echo $simplewill_tb->lga->CellAttributes() ?>>
<span id="el_simplewill_tb_lga" class="control-group">
<input type="text" data-field="x_lga" name="x_lga" id="x_lga" size="30" maxlength="50" placeholder="<?php echo $simplewill_tb->lga->PlaceHolder ?>" value="<?php echo $simplewill_tb->lga->EditValue ?>"<?php echo $simplewill_tb->lga->EditAttributes() ?>>
</span>
<?php echo $simplewill_tb->lga->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($simplewill_tb->maidenname->Visible) { // maidenname ?>
	<tr id="r_maidenname">
		<td><span id="elh_simplewill_tb_maidenname"><?php echo $simplewill_tb->maidenname->FldCaption() ?></span></td>
		<td<?php echo $simplewill_tb->maidenname->CellAttributes() ?>>
<span id="el_simplewill_tb_maidenname" class="control-group">
<input type="text" data-field="x_maidenname" name="x_maidenname" id="x_maidenname" size="30" maxlength="50" placeholder="<?php echo $simplewill_tb->maidenname->PlaceHolder ?>" value="<?php echo $simplewill_tb->maidenname->EditValue ?>"<?php echo $simplewill_tb->maidenname->EditAttributes() ?>>
</span>
<?php echo $simplewill_tb->maidenname->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($simplewill_tb->identificationtype->Visible) { // identificationtype ?>
	<tr id="r_identificationtype">
		<td><span id="elh_simplewill_tb_identificationtype"><?php echo $simplewill_tb->identificationtype->FldCaption() ?></span></td>
		<td<?php echo $simplewill_tb->identificationtype->CellAttributes() ?>>
<span id="el_simplewill_tb_identificationtype" class="control-group">
<input type="text" data-field="x_identificationtype" name="x_identificationtype" id="x_identificationtype" size="30" maxlength="50" placeholder="<?php echo $simplewill_tb->identificationtype->PlaceHolder ?>" value="<?php echo $simplewill_tb->identificationtype->EditValue ?>"<?php echo $simplewill_tb->identificationtype->EditAttributes() ?>>
</span>
<?php echo $simplewill_tb->identificationtype->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($simplewill_tb->idnumber->Visible) { // idnumber ?>
	<tr id="r_idnumber">
		<td><span id="elh_simplewill_tb_idnumber"><?php echo $simplewill_tb->idnumber->FldCaption() ?></span></td>
		<td<?php echo $simplewill_tb->idnumber->CellAttributes() ?>>
<span id="el_simplewill_tb_idnumber" class="control-group">
<input type="text" data-field="x_idnumber" name="x_idnumber" id="x_idnumber" size="30" maxlength="50" placeholder="<?php echo $simplewill_tb->idnumber->PlaceHolder ?>" value="<?php echo $simplewill_tb->idnumber->EditValue ?>"<?php echo $simplewill_tb->idnumber->EditAttributes() ?>>
</span>
<?php echo $simplewill_tb->idnumber->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($simplewill_tb->issuedate->Visible) { // issuedate ?>
	<tr id="r_issuedate">
		<td><span id="elh_simplewill_tb_issuedate"><?php echo $simplewill_tb->issuedate->FldCaption() ?></span></td>
		<td<?php echo $simplewill_tb->issuedate->CellAttributes() ?>>
<span id="el_simplewill_tb_issuedate" class="control-group">
<input type="text" data-field="x_issuedate" name="x_issuedate" id="x_issuedate" size="30" maxlength="50" placeholder="<?php echo $simplewill_tb->issuedate->PlaceHolder ?>" value="<?php echo $simplewill_tb->issuedate->EditValue ?>"<?php echo $simplewill_tb->issuedate->EditAttributes() ?>>
</span>
<?php echo $simplewill_tb->issuedate->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($simplewill_tb->expirydate->Visible) { // expirydate ?>
	<tr id="r_expirydate">
		<td><span id="elh_simplewill_tb_expirydate"><?php echo $simplewill_tb->expirydate->FldCaption() ?></span></td>
		<td<?php echo $simplewill_tb->expirydate->CellAttributes() ?>>
<span id="el_simplewill_tb_expirydate" class="control-group">
<input type="text" data-field="x_expirydate" name="x_expirydate" id="x_expirydate" size="30" maxlength="50" placeholder="<?php echo $simplewill_tb->expirydate->PlaceHolder ?>" value="<?php echo $simplewill_tb->expirydate->EditValue ?>"<?php echo $simplewill_tb->expirydate->EditAttributes() ?>>
</span>
<?php echo $simplewill_tb->expirydate->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($simplewill_tb->issueplace->Visible) { // issueplace ?>
	<tr id="r_issueplace">
		<td><span id="elh_simplewill_tb_issueplace"><?php echo $simplewill_tb->issueplace->FldCaption() ?></span></td>
		<td<?php echo $simplewill_tb->issueplace->CellAttributes() ?>>
<span id="el_simplewill_tb_issueplace" class="control-group">
<input type="text" data-field="x_issueplace" name="x_issueplace" id="x_issueplace" size="30" maxlength="50" placeholder="<?php echo $simplewill_tb->issueplace->PlaceHolder ?>" value="<?php echo $simplewill_tb->issueplace->EditValue ?>"<?php echo $simplewill_tb->issueplace->EditAttributes() ?>>
</span>
<?php echo $simplewill_tb->issueplace->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($simplewill_tb->employmentstatus->Visible) { // employmentstatus ?>
	<tr id="r_employmentstatus">
		<td><span id="elh_simplewill_tb_employmentstatus"><?php echo $simplewill_tb->employmentstatus->FldCaption() ?></span></td>
		<td<?php echo $simplewill_tb->employmentstatus->CellAttributes() ?>>
<span id="el_simplewill_tb_employmentstatus" class="control-group">
<input type="text" data-field="x_employmentstatus" name="x_employmentstatus" id="x_employmentstatus" size="30" maxlength="50" placeholder="<?php echo $simplewill_tb->employmentstatus->PlaceHolder ?>" value="<?php echo $simplewill_tb->employmentstatus->EditValue ?>"<?php echo $simplewill_tb->employmentstatus->EditAttributes() ?>>
</span>
<?php echo $simplewill_tb->employmentstatus->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($simplewill_tb->employer->Visible) { // employer ?>
	<tr id="r_employer">
		<td><span id="elh_simplewill_tb_employer"><?php echo $simplewill_tb->employer->FldCaption() ?></span></td>
		<td<?php echo $simplewill_tb->employer->CellAttributes() ?>>
<span id="el_simplewill_tb_employer" class="control-group">
<textarea data-field="x_employer" name="x_employer" id="x_employer" cols="35" rows="4" placeholder="<?php echo $simplewill_tb->employer->PlaceHolder ?>"<?php echo $simplewill_tb->employer->EditAttributes() ?>><?php echo $simplewill_tb->employer->EditValue ?></textarea>
</span>
<?php echo $simplewill_tb->employer->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($simplewill_tb->employerphone->Visible) { // employerphone ?>
	<tr id="r_employerphone">
		<td><span id="elh_simplewill_tb_employerphone"><?php echo $simplewill_tb->employerphone->FldCaption() ?></span></td>
		<td<?php echo $simplewill_tb->employerphone->CellAttributes() ?>>
<span id="el_simplewill_tb_employerphone" class="control-group">
<input type="text" data-field="x_employerphone" name="x_employerphone" id="x_employerphone" size="30" maxlength="50" placeholder="<?php echo $simplewill_tb->employerphone->PlaceHolder ?>" value="<?php echo $simplewill_tb->employerphone->EditValue ?>"<?php echo $simplewill_tb->employerphone->EditAttributes() ?>>
</span>
<?php echo $simplewill_tb->employerphone->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($simplewill_tb->employeraddr->Visible) { // employeraddr ?>
	<tr id="r_employeraddr">
		<td><span id="elh_simplewill_tb_employeraddr"><?php echo $simplewill_tb->employeraddr->FldCaption() ?></span></td>
		<td<?php echo $simplewill_tb->employeraddr->CellAttributes() ?>>
<span id="el_simplewill_tb_employeraddr" class="control-group">
<textarea data-field="x_employeraddr" name="x_employeraddr" id="x_employeraddr" cols="35" rows="4" placeholder="<?php echo $simplewill_tb->employeraddr->PlaceHolder ?>"<?php echo $simplewill_tb->employeraddr->EditAttributes() ?>><?php echo $simplewill_tb->employeraddr->EditValue ?></textarea>
</span>
<?php echo $simplewill_tb->employeraddr->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($simplewill_tb->maritalstatus->Visible) { // maritalstatus ?>
	<tr id="r_maritalstatus">
		<td><span id="elh_simplewill_tb_maritalstatus"><?php echo $simplewill_tb->maritalstatus->FldCaption() ?></span></td>
		<td<?php echo $simplewill_tb->maritalstatus->CellAttributes() ?>>
<span id="el_simplewill_tb_maritalstatus" class="control-group">
<input type="text" data-field="x_maritalstatus" name="x_maritalstatus" id="x_maritalstatus" size="30" maxlength="50" placeholder="<?php echo $simplewill_tb->maritalstatus->PlaceHolder ?>" value="<?php echo $simplewill_tb->maritalstatus->EditValue ?>"<?php echo $simplewill_tb->maritalstatus->EditAttributes() ?>>
</span>
<?php echo $simplewill_tb->maritalstatus->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($simplewill_tb->spousename->Visible) { // spousename ?>
	<tr id="r_spousename">
		<td><span id="elh_simplewill_tb_spousename"><?php echo $simplewill_tb->spousename->FldCaption() ?></span></td>
		<td<?php echo $simplewill_tb->spousename->CellAttributes() ?>>
<span id="el_simplewill_tb_spousename" class="control-group">
<input type="text" data-field="x_spousename" name="x_spousename" id="x_spousename" size="30" maxlength="50" placeholder="<?php echo $simplewill_tb->spousename->PlaceHolder ?>" value="<?php echo $simplewill_tb->spousename->EditValue ?>"<?php echo $simplewill_tb->spousename->EditAttributes() ?>>
</span>
<?php echo $simplewill_tb->spousename->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($simplewill_tb->spouseemail->Visible) { // spouseemail ?>
	<tr id="r_spouseemail">
		<td><span id="elh_simplewill_tb_spouseemail"><?php echo $simplewill_tb->spouseemail->FldCaption() ?></span></td>
		<td<?php echo $simplewill_tb->spouseemail->CellAttributes() ?>>
<span id="el_simplewill_tb_spouseemail" class="control-group">
<input type="text" data-field="x_spouseemail" name="x_spouseemail" id="x_spouseemail" size="30" maxlength="50" placeholder="<?php echo $simplewill_tb->spouseemail->PlaceHolder ?>" value="<?php echo $simplewill_tb->spouseemail->EditValue ?>"<?php echo $simplewill_tb->spouseemail->EditAttributes() ?>>
</span>
<?php echo $simplewill_tb->spouseemail->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($simplewill_tb->spousephone->Visible) { // spousephone ?>
	<tr id="r_spousephone">
		<td><span id="elh_simplewill_tb_spousephone"><?php echo $simplewill_tb->spousephone->FldCaption() ?></span></td>
		<td<?php echo $simplewill_tb->spousephone->CellAttributes() ?>>
<span id="el_simplewill_tb_spousephone" class="control-group">
<input type="text" data-field="x_spousephone" name="x_spousephone" id="x_spousephone" size="30" maxlength="20" placeholder="<?php echo $simplewill_tb->spousephone->PlaceHolder ?>" value="<?php echo $simplewill_tb->spousephone->EditValue ?>"<?php echo $simplewill_tb->spousephone->EditAttributes() ?>>
</span>
<?php echo $simplewill_tb->spousephone->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($simplewill_tb->spousedob->Visible) { // spousedob ?>
	<tr id="r_spousedob">
		<td><span id="elh_simplewill_tb_spousedob"><?php echo $simplewill_tb->spousedob->FldCaption() ?></span></td>
		<td<?php echo $simplewill_tb->spousedob->CellAttributes() ?>>
<span id="el_simplewill_tb_spousedob" class="control-group">
<input type="text" data-field="x_spousedob" name="x_spousedob" id="x_spousedob" size="30" maxlength="10" placeholder="<?php echo $simplewill_tb->spousedob->PlaceHolder ?>" value="<?php echo $simplewill_tb->spousedob->EditValue ?>"<?php echo $simplewill_tb->spousedob->EditAttributes() ?>>
</span>
<?php echo $simplewill_tb->spousedob->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($simplewill_tb->spouseaddr->Visible) { // spouseaddr ?>
	<tr id="r_spouseaddr">
		<td><span id="elh_simplewill_tb_spouseaddr"><?php echo $simplewill_tb->spouseaddr->FldCaption() ?></span></td>
		<td<?php echo $simplewill_tb->spouseaddr->CellAttributes() ?>>
<span id="el_simplewill_tb_spouseaddr" class="control-group">
<textarea data-field="x_spouseaddr" name="x_spouseaddr" id="x_spouseaddr" cols="35" rows="4" placeholder="<?php echo $simplewill_tb->spouseaddr->PlaceHolder ?>"<?php echo $simplewill_tb->spouseaddr->EditAttributes() ?>><?php echo $simplewill_tb->spouseaddr->EditValue ?></textarea>
</span>
<?php echo $simplewill_tb->spouseaddr->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($simplewill_tb->spousecity->Visible) { // spousecity ?>
	<tr id="r_spousecity">
		<td><span id="elh_simplewill_tb_spousecity"><?php echo $simplewill_tb->spousecity->FldCaption() ?></span></td>
		<td<?php echo $simplewill_tb->spousecity->CellAttributes() ?>>
<span id="el_simplewill_tb_spousecity" class="control-group">
<input type="text" data-field="x_spousecity" name="x_spousecity" id="x_spousecity" size="30" maxlength="50" placeholder="<?php echo $simplewill_tb->spousecity->PlaceHolder ?>" value="<?php echo $simplewill_tb->spousecity->EditValue ?>"<?php echo $simplewill_tb->spousecity->EditAttributes() ?>>
</span>
<?php echo $simplewill_tb->spousecity->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($simplewill_tb->spousestate->Visible) { // spousestate ?>
	<tr id="r_spousestate">
		<td><span id="elh_simplewill_tb_spousestate"><?php echo $simplewill_tb->spousestate->FldCaption() ?></span></td>
		<td<?php echo $simplewill_tb->spousestate->CellAttributes() ?>>
<span id="el_simplewill_tb_spousestate" class="control-group">
<input type="text" data-field="x_spousestate" name="x_spousestate" id="x_spousestate" size="30" maxlength="50" placeholder="<?php echo $simplewill_tb->spousestate->PlaceHolder ?>" value="<?php echo $simplewill_tb->spousestate->EditValue ?>"<?php echo $simplewill_tb->spousestate->EditAttributes() ?>>
</span>
<?php echo $simplewill_tb->spousestate->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($simplewill_tb->marriagetype->Visible) { // marriagetype ?>
	<tr id="r_marriagetype">
		<td><span id="elh_simplewill_tb_marriagetype"><?php echo $simplewill_tb->marriagetype->FldCaption() ?></span></td>
		<td<?php echo $simplewill_tb->marriagetype->CellAttributes() ?>>
<span id="el_simplewill_tb_marriagetype" class="control-group">
<input type="text" data-field="x_marriagetype" name="x_marriagetype" id="x_marriagetype" size="30" maxlength="20" placeholder="<?php echo $simplewill_tb->marriagetype->PlaceHolder ?>" value="<?php echo $simplewill_tb->marriagetype->EditValue ?>"<?php echo $simplewill_tb->marriagetype->EditAttributes() ?>>
</span>
<?php echo $simplewill_tb->marriagetype->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($simplewill_tb->marriageyear->Visible) { // marriageyear ?>
	<tr id="r_marriageyear">
		<td><span id="elh_simplewill_tb_marriageyear"><?php echo $simplewill_tb->marriageyear->FldCaption() ?></span></td>
		<td<?php echo $simplewill_tb->marriageyear->CellAttributes() ?>>
<span id="el_simplewill_tb_marriageyear" class="control-group">
<input type="text" data-field="x_marriageyear" name="x_marriageyear" id="x_marriageyear" size="30" maxlength="10" placeholder="<?php echo $simplewill_tb->marriageyear->PlaceHolder ?>" value="<?php echo $simplewill_tb->marriageyear->EditValue ?>"<?php echo $simplewill_tb->marriageyear->EditAttributes() ?>>
</span>
<?php echo $simplewill_tb->marriageyear->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($simplewill_tb->marriagecert->Visible) { // marriagecert ?>
	<tr id="r_marriagecert">
		<td><span id="elh_simplewill_tb_marriagecert"><?php echo $simplewill_tb->marriagecert->FldCaption() ?></span></td>
		<td<?php echo $simplewill_tb->marriagecert->CellAttributes() ?>>
<span id="el_simplewill_tb_marriagecert" class="control-group">
<input type="text" data-field="x_marriagecert" name="x_marriagecert" id="x_marriagecert" size="30" maxlength="50" placeholder="<?php echo $simplewill_tb->marriagecert->PlaceHolder ?>" value="<?php echo $simplewill_tb->marriagecert->EditValue ?>"<?php echo $simplewill_tb->marriagecert->EditAttributes() ?>>
</span>
<?php echo $simplewill_tb->marriagecert->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($simplewill_tb->cityofmarriage->Visible) { // cityofmarriage ?>
	<tr id="r_cityofmarriage">
		<td><span id="elh_simplewill_tb_cityofmarriage"><?php echo $simplewill_tb->cityofmarriage->FldCaption() ?></span></td>
		<td<?php echo $simplewill_tb->cityofmarriage->CellAttributes() ?>>
<span id="el_simplewill_tb_cityofmarriage" class="control-group">
<input type="text" data-field="x_cityofmarriage" name="x_cityofmarriage" id="x_cityofmarriage" size="30" maxlength="50" placeholder="<?php echo $simplewill_tb->cityofmarriage->PlaceHolder ?>" value="<?php echo $simplewill_tb->cityofmarriage->EditValue ?>"<?php echo $simplewill_tb->cityofmarriage->EditAttributes() ?>>
</span>
<?php echo $simplewill_tb->cityofmarriage->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($simplewill_tb->countryofmarriage->Visible) { // countryofmarriage ?>
	<tr id="r_countryofmarriage">
		<td><span id="elh_simplewill_tb_countryofmarriage"><?php echo $simplewill_tb->countryofmarriage->FldCaption() ?></span></td>
		<td<?php echo $simplewill_tb->countryofmarriage->CellAttributes() ?>>
<span id="el_simplewill_tb_countryofmarriage" class="control-group">
<input type="text" data-field="x_countryofmarriage" name="x_countryofmarriage" id="x_countryofmarriage" size="30" maxlength="50" placeholder="<?php echo $simplewill_tb->countryofmarriage->PlaceHolder ?>" value="<?php echo $simplewill_tb->countryofmarriage->EditValue ?>"<?php echo $simplewill_tb->countryofmarriage->EditAttributes() ?>>
</span>
<?php echo $simplewill_tb->countryofmarriage->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($simplewill_tb->divorce->Visible) { // divorce ?>
	<tr id="r_divorce">
		<td><span id="elh_simplewill_tb_divorce"><?php echo $simplewill_tb->divorce->FldCaption() ?></span></td>
		<td<?php echo $simplewill_tb->divorce->CellAttributes() ?>>
<span id="el_simplewill_tb_divorce" class="control-group">
<input type="text" data-field="x_divorce" name="x_divorce" id="x_divorce" size="30" maxlength="10" placeholder="<?php echo $simplewill_tb->divorce->PlaceHolder ?>" value="<?php echo $simplewill_tb->divorce->EditValue ?>"<?php echo $simplewill_tb->divorce->EditAttributes() ?>>
</span>
<?php echo $simplewill_tb->divorce->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($simplewill_tb->divorceyear->Visible) { // divorceyear ?>
	<tr id="r_divorceyear">
		<td><span id="elh_simplewill_tb_divorceyear"><?php echo $simplewill_tb->divorceyear->FldCaption() ?></span></td>
		<td<?php echo $simplewill_tb->divorceyear->CellAttributes() ?>>
<span id="el_simplewill_tb_divorceyear" class="control-group">
<input type="text" data-field="x_divorceyear" name="x_divorceyear" id="x_divorceyear" size="30" maxlength="10" placeholder="<?php echo $simplewill_tb->divorceyear->PlaceHolder ?>" value="<?php echo $simplewill_tb->divorceyear->EditValue ?>"<?php echo $simplewill_tb->divorceyear->EditAttributes() ?>>
</span>
<?php echo $simplewill_tb->divorceyear->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($simplewill_tb->nextofkinfullname->Visible) { // nextofkinfullname ?>
	<tr id="r_nextofkinfullname">
		<td><span id="elh_simplewill_tb_nextofkinfullname"><?php echo $simplewill_tb->nextofkinfullname->FldCaption() ?></span></td>
		<td<?php echo $simplewill_tb->nextofkinfullname->CellAttributes() ?>>
<span id="el_simplewill_tb_nextofkinfullname" class="control-group">
<input type="text" data-field="x_nextofkinfullname" name="x_nextofkinfullname" id="x_nextofkinfullname" size="30" maxlength="100" placeholder="<?php echo $simplewill_tb->nextofkinfullname->PlaceHolder ?>" value="<?php echo $simplewill_tb->nextofkinfullname->EditValue ?>"<?php echo $simplewill_tb->nextofkinfullname->EditAttributes() ?>>
</span>
<?php echo $simplewill_tb->nextofkinfullname->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($simplewill_tb->nextofkintelephone->Visible) { // nextofkintelephone ?>
	<tr id="r_nextofkintelephone">
		<td><span id="elh_simplewill_tb_nextofkintelephone"><?php echo $simplewill_tb->nextofkintelephone->FldCaption() ?></span></td>
		<td<?php echo $simplewill_tb->nextofkintelephone->CellAttributes() ?>>
<span id="el_simplewill_tb_nextofkintelephone" class="control-group">
<input type="text" data-field="x_nextofkintelephone" name="x_nextofkintelephone" id="x_nextofkintelephone" size="30" maxlength="20" placeholder="<?php echo $simplewill_tb->nextofkintelephone->PlaceHolder ?>" value="<?php echo $simplewill_tb->nextofkintelephone->EditValue ?>"<?php echo $simplewill_tb->nextofkintelephone->EditAttributes() ?>>
</span>
<?php echo $simplewill_tb->nextofkintelephone->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($simplewill_tb->nextofkinemail->Visible) { // nextofkinemail ?>
	<tr id="r_nextofkinemail">
		<td><span id="elh_simplewill_tb_nextofkinemail"><?php echo $simplewill_tb->nextofkinemail->FldCaption() ?></span></td>
		<td<?php echo $simplewill_tb->nextofkinemail->CellAttributes() ?>>
<span id="el_simplewill_tb_nextofkinemail" class="control-group">
<input type="text" data-field="x_nextofkinemail" name="x_nextofkinemail" id="x_nextofkinemail" size="30" maxlength="50" placeholder="<?php echo $simplewill_tb->nextofkinemail->PlaceHolder ?>" value="<?php echo $simplewill_tb->nextofkinemail->EditValue ?>"<?php echo $simplewill_tb->nextofkinemail->EditAttributes() ?>>
</span>
<?php echo $simplewill_tb->nextofkinemail->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($simplewill_tb->nextofkinaddress->Visible) { // nextofkinaddress ?>
	<tr id="r_nextofkinaddress">
		<td><span id="elh_simplewill_tb_nextofkinaddress"><?php echo $simplewill_tb->nextofkinaddress->FldCaption() ?></span></td>
		<td<?php echo $simplewill_tb->nextofkinaddress->CellAttributes() ?>>
<span id="el_simplewill_tb_nextofkinaddress" class="control-group">
<textarea data-field="x_nextofkinaddress" name="x_nextofkinaddress" id="x_nextofkinaddress" cols="35" rows="4" placeholder="<?php echo $simplewill_tb->nextofkinaddress->PlaceHolder ?>"<?php echo $simplewill_tb->nextofkinaddress->EditAttributes() ?>><?php echo $simplewill_tb->nextofkinaddress->EditValue ?></textarea>
</span>
<?php echo $simplewill_tb->nextofkinaddress->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($simplewill_tb->nameofcompany->Visible) { // nameofcompany ?>
	<tr id="r_nameofcompany">
		<td><span id="elh_simplewill_tb_nameofcompany"><?php echo $simplewill_tb->nameofcompany->FldCaption() ?></span></td>
		<td<?php echo $simplewill_tb->nameofcompany->CellAttributes() ?>>
<span id="el_simplewill_tb_nameofcompany" class="control-group">
<input type="text" data-field="x_nameofcompany" name="x_nameofcompany" id="x_nameofcompany" size="30" maxlength="100" placeholder="<?php echo $simplewill_tb->nameofcompany->PlaceHolder ?>" value="<?php echo $simplewill_tb->nameofcompany->EditValue ?>"<?php echo $simplewill_tb->nameofcompany->EditAttributes() ?>>
</span>
<?php echo $simplewill_tb->nameofcompany->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($simplewill_tb->humanresourcescontacttelephone->Visible) { // humanresourcescontacttelephone ?>
	<tr id="r_humanresourcescontacttelephone">
		<td><span id="elh_simplewill_tb_humanresourcescontacttelephone"><?php echo $simplewill_tb->humanresourcescontacttelephone->FldCaption() ?></span></td>
		<td<?php echo $simplewill_tb->humanresourcescontacttelephone->CellAttributes() ?>>
<span id="el_simplewill_tb_humanresourcescontacttelephone" class="control-group">
<input type="text" data-field="x_humanresourcescontacttelephone" name="x_humanresourcescontacttelephone" id="x_humanresourcescontacttelephone" size="30" maxlength="20" placeholder="<?php echo $simplewill_tb->humanresourcescontacttelephone->PlaceHolder ?>" value="<?php echo $simplewill_tb->humanresourcescontacttelephone->EditValue ?>"<?php echo $simplewill_tb->humanresourcescontacttelephone->EditAttributes() ?>>
</span>
<?php echo $simplewill_tb->humanresourcescontacttelephone->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($simplewill_tb->humanresourcescontactemailaddress->Visible) { // humanresourcescontactemailaddress ?>
	<tr id="r_humanresourcescontactemailaddress">
		<td><span id="elh_simplewill_tb_humanresourcescontactemailaddress"><?php echo $simplewill_tb->humanresourcescontactemailaddress->FldCaption() ?></span></td>
		<td<?php echo $simplewill_tb->humanresourcescontactemailaddress->CellAttributes() ?>>
<span id="el_simplewill_tb_humanresourcescontactemailaddress" class="control-group">
<input type="text" data-field="x_humanresourcescontactemailaddress" name="x_humanresourcescontactemailaddress" id="x_humanresourcescontactemailaddress" size="30" maxlength="50" placeholder="<?php echo $simplewill_tb->humanresourcescontactemailaddress->PlaceHolder ?>" value="<?php echo $simplewill_tb->humanresourcescontactemailaddress->EditValue ?>"<?php echo $simplewill_tb->humanresourcescontactemailaddress->EditAttributes() ?>>
</span>
<?php echo $simplewill_tb->humanresourcescontactemailaddress->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($simplewill_tb->datecreated->Visible) { // datecreated ?>
	<tr id="r_datecreated">
		<td><span id="elh_simplewill_tb_datecreated"><?php echo $simplewill_tb->datecreated->FldCaption() ?></span></td>
		<td<?php echo $simplewill_tb->datecreated->CellAttributes() ?>>
<span id="el_simplewill_tb_datecreated" class="control-group">
<input type="text" data-field="x_datecreated" name="x_datecreated" id="x_datecreated" placeholder="<?php echo $simplewill_tb->datecreated->PlaceHolder ?>" value="<?php echo $simplewill_tb->datecreated->EditValue ?>"<?php echo $simplewill_tb->datecreated->EditAttributes() ?>>
</span>
<?php echo $simplewill_tb->datecreated->CustomMsg ?></td>
	</tr>
<?php } ?>
</table>
</td></tr></table>
<?php
	if (in_array("simplewill_assets_tb", explode(",", $simplewill_tb->getCurrentDetailTable())) && $simplewill_assets_tb->DetailAdd) {
?>
<?php include_once "simplewill_assets_tbgrid.php" ?>
<?php } ?>
<?php
	if (in_array("simplewill_overall_asset", explode(",", $simplewill_tb->getCurrentDetailTable())) && $simplewill_overall_asset->DetailAdd) {
?>
<?php include_once "simplewill_overall_assetgrid.php" ?>
<?php } ?>
<button class="btn btn-primary ewButton" name="btnAction" id="btnAction" type="submit"><?php echo $Language->Phrase("AddBtn") ?></button>
</form>
<script type="text/javascript">
fsimplewill_tbadd.Init();
<?php if (EW_MOBILE_REFLOW && ew_IsMobile()) { ?>
ew_Reflow();
<?php } ?>
</script>
<?php
$simplewill_tb_add->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$simplewill_tb_add->Page_Terminate();
?>
