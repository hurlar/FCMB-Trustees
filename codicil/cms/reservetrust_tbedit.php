<?php
if (session_id() == "") session_start(); // Initialize Session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg10.php" ?>
<?php include_once "ewmysql10.php" ?>
<?php include_once "phpfn10.php" ?>
<?php include_once "reservetrust_tbinfo.php" ?>
<?php include_once "adminusersinfo.php" ?>
<?php include_once "userfn10.php" ?>
<?php

//
// Page class
//

$reservetrust_tb_edit = NULL; // Initialize page object first

class creservetrust_tb_edit extends creservetrust_tb {

	// Page ID
	var $PageID = 'edit';

	// Project ID
	var $ProjectID = "{D9B361E7-B2C1-4293-B9B3-B581986A15CC}";

	// Table name
	var $TableName = 'reservetrust_tb';

	// Page object name
	var $PageObjName = 'reservetrust_tb_edit';

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

		// Table object (reservetrust_tb)
		if (!isset($GLOBALS["reservetrust_tb"])) {
			$GLOBALS["reservetrust_tb"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["reservetrust_tb"];
		}

		// Table object (adminusers)
		if (!isset($GLOBALS['adminusers'])) $GLOBALS['adminusers'] = new cadminusers();

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'edit', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'reservetrust_tb', TRUE);

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
	var $DbMasterFilter;
	var $DbDetailFilter;
	var $DisplayRecs = 1;
	var $StartRec;
	var $StopRec;
	var $TotalRecs = 0;
	var $RecRange = 10;
	var $Pager;
	var $RecCnt;
	var $RecKey = array();
	var $Recordset;

	// 
	// Page main
	//
	function Page_Main() {
		global $objForm, $Language, $gsFormError;

		// Load current record
		$bLoadCurrentRecord = FALSE;
		$sReturnUrl = "";
		$bMatchRecord = FALSE;

		// Load key from QueryString
		if (@$_GET["id"] <> "") {
			$this->id->setQueryStringValue($_GET["id"]);
			$this->RecKey["id"] = $this->id->QueryStringValue;
		} else {
			$bLoadCurrentRecord = TRUE;
		}

		// Set up Breadcrumb
		$this->SetupBreadcrumb();

		// Load recordset
		$this->StartRec = 1; // Initialize start position
		if ($this->Recordset = $this->LoadRecordset()) // Load records
			$this->TotalRecs = $this->Recordset->RecordCount(); // Get record count
		if ($this->TotalRecs <= 0) { // No record found
			if ($this->getSuccessMessage() == "" && $this->getFailureMessage() == "")
				$this->setFailureMessage($Language->Phrase("NoRecord")); // Set no record message
			$this->Page_Terminate("reservetrust_tblist.php"); // Return to list page
		} elseif ($bLoadCurrentRecord) { // Load current record position
			$this->SetUpStartRec(); // Set up start record position

			// Point to current record
			if (intval($this->StartRec) <= intval($this->TotalRecs)) {
				$bMatchRecord = TRUE;
				$this->Recordset->Move($this->StartRec-1);
			}
		} else { // Match key values
			while (!$this->Recordset->EOF) {
				if (strval($this->id->CurrentValue) == strval($this->Recordset->fields('id'))) {
					$this->setStartRecordNumber($this->StartRec); // Save record position
					$bMatchRecord = TRUE;
					break;
				} else {
					$this->StartRec++;
					$this->Recordset->MoveNext();
				}
			}
		}

		// Process form if post back
		if (@$_POST["a_edit"] <> "") {
			$this->CurrentAction = $_POST["a_edit"]; // Get action code
			$this->LoadFormValues(); // Get form values
		} else {
			$this->CurrentAction = "I"; // Default action is display
		}

		// Validate form if post back
		if (@$_POST["a_edit"] <> "") {
			if (!$this->ValidateForm()) {
				$this->CurrentAction = ""; // Form error, reset action
				$this->setFailureMessage($gsFormError);
				$this->EventCancelled = TRUE; // Event cancelled
				$this->RestoreFormValues();
			}
		}
		switch ($this->CurrentAction) {
			case "I": // Get a record to display
				if (!$bMatchRecord) {
					if ($this->getSuccessMessage() == "" && $this->getFailureMessage() == "")
						$this->setFailureMessage($Language->Phrase("NoRecord")); // Set no record message
					$this->Page_Terminate("reservetrust_tblist.php"); // Return to list page
				} else {
					$this->LoadRowValues($this->Recordset); // Load row values
				}
				break;
			Case "U": // Update
				$this->SendEmail = TRUE; // Send email on update success
				if ($this->EditRow()) { // Update record based on key
					if ($this->getSuccessMessage() == "")
						$this->setSuccessMessage($Language->Phrase("UpdateSuccess")); // Update success
					$sReturnUrl = $this->getReturnUrl();
					if (ew_GetPageName($sReturnUrl) == "reservetrust_tbview.php")
						$sReturnUrl = $this->GetViewUrl(); // View paging, return to View page directly
					$this->Page_Terminate($sReturnUrl); // Return to caller
				} else {
					$this->EventCancelled = TRUE; // Event cancelled
					$this->RestoreFormValues(); // Restore form values if update failed
				}
		}

		// Render the record
		$this->RowType = EW_ROWTYPE_EDIT; // Render as Edit
		$this->ResetAttrs();
		$this->RenderRow();
	}

	// Set up starting record parameters
	function SetUpStartRec() {
		if ($this->DisplayRecs == 0)
			return;
		if ($this->IsPageRequest()) { // Validate request
			if (@$_GET[EW_TABLE_START_REC] <> "") { // Check for "start" parameter
				$this->StartRec = $_GET[EW_TABLE_START_REC];
				$this->setStartRecordNumber($this->StartRec);
			} elseif (@$_GET[EW_TABLE_PAGE_NO] <> "") {
				$PageNo = $_GET[EW_TABLE_PAGE_NO];
				if (is_numeric($PageNo)) {
					$this->StartRec = ($PageNo-1)*$this->DisplayRecs+1;
					if ($this->StartRec <= 0) {
						$this->StartRec = 1;
					} elseif ($this->StartRec >= intval(($this->TotalRecs-1)/$this->DisplayRecs)*$this->DisplayRecs+1) {
						$this->StartRec = intval(($this->TotalRecs-1)/$this->DisplayRecs)*$this->DisplayRecs+1;
					}
					$this->setStartRecordNumber($this->StartRec);
				}
			}
		}
		$this->StartRec = $this->getStartRecordNumber();

		// Check if correct start record counter
		if (!is_numeric($this->StartRec) || $this->StartRec == "") { // Avoid invalid start record counter
			$this->StartRec = 1; // Reset start record counter
			$this->setStartRecordNumber($this->StartRec);
		} elseif (intval($this->StartRec) > intval($this->TotalRecs)) { // Avoid starting record > total records
			$this->StartRec = intval(($this->TotalRecs-1)/$this->DisplayRecs)*$this->DisplayRecs+1; // Point to last page first record
			$this->setStartRecordNumber($this->StartRec);
		} elseif (($this->StartRec-1) % $this->DisplayRecs <> 0) {
			$this->StartRec = intval(($this->StartRec-1)/$this->DisplayRecs)*$this->DisplayRecs+1; // Point to page boundary
			$this->setStartRecordNumber($this->StartRec);
		}
	}

	// Get upload files
	function GetUploadFiles() {
		global $objForm;

		// Get upload data
	}

	// Load form values
	function LoadFormValues() {

		// Load from form
		global $objForm;
		if (!$this->id->FldIsDetailKey)
			$this->id->setFormValue($objForm->GetValue("x_id"));
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
		if (!$this->marriagetype->FldIsDetailKey) {
			$this->marriagetype->setFormValue($objForm->GetValue("x_marriagetype"));
		}
		if (!$this->marriageyear->FldIsDetailKey) {
			$this->marriageyear->setFormValue($objForm->GetValue("x_marriageyear"));
		}
		if (!$this->marriagecert->FldIsDetailKey) {
			$this->marriagecert->setFormValue($objForm->GetValue("x_marriagecert"));
		}
		if (!$this->divorce->FldIsDetailKey) {
			$this->divorce->setFormValue($objForm->GetValue("x_divorce"));
		}
		if (!$this->divorceyear->FldIsDetailKey) {
			$this->divorceyear->setFormValue($objForm->GetValue("x_divorceyear"));
		}
		if (!$this->datecreated->FldIsDetailKey) {
			$this->datecreated->setFormValue($objForm->GetValue("x_datecreated"));
			$this->datecreated->CurrentValue = ew_UnFormatDateTime($this->datecreated->CurrentValue, 0);
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
		if (!$this->cityofmarriage->FldIsDetailKey) {
			$this->cityofmarriage->setFormValue($objForm->GetValue("x_cityofmarriage"));
		}
		if (!$this->countryofmarriage->FldIsDetailKey) {
			$this->countryofmarriage->setFormValue($objForm->GetValue("x_countryofmarriage"));
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
	}

	// Restore form values
	function RestoreFormValues() {
		global $objForm;
		$this->LoadRow();
		$this->id->CurrentValue = $this->id->FormValue;
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
		$this->marriagetype->CurrentValue = $this->marriagetype->FormValue;
		$this->marriageyear->CurrentValue = $this->marriageyear->FormValue;
		$this->marriagecert->CurrentValue = $this->marriagecert->FormValue;
		$this->divorce->CurrentValue = $this->divorce->FormValue;
		$this->divorceyear->CurrentValue = $this->divorceyear->FormValue;
		$this->datecreated->CurrentValue = $this->datecreated->FormValue;
		$this->datecreated->CurrentValue = ew_UnFormatDateTime($this->datecreated->CurrentValue, 0);
		$this->maidenname->CurrentValue = $this->maidenname->FormValue;
		$this->identificationtype->CurrentValue = $this->identificationtype->FormValue;
		$this->idnumber->CurrentValue = $this->idnumber->FormValue;
		$this->issuedate->CurrentValue = $this->issuedate->FormValue;
		$this->expirydate->CurrentValue = $this->expirydate->FormValue;
		$this->issueplace->CurrentValue = $this->issueplace->FormValue;
		$this->spousename->CurrentValue = $this->spousename->FormValue;
		$this->spouseemail->CurrentValue = $this->spouseemail->FormValue;
		$this->spousephone->CurrentValue = $this->spousephone->FormValue;
		$this->spousedob->CurrentValue = $this->spousedob->FormValue;
		$this->spouseaddr->CurrentValue = $this->spouseaddr->FormValue;
		$this->spousecity->CurrentValue = $this->spousecity->FormValue;
		$this->spousestate->CurrentValue = $this->spousestate->FormValue;
		$this->cityofmarriage->CurrentValue = $this->cityofmarriage->FormValue;
		$this->countryofmarriage->CurrentValue = $this->countryofmarriage->FormValue;
		$this->nextofkinfullname->CurrentValue = $this->nextofkinfullname->FormValue;
		$this->nextofkintelephone->CurrentValue = $this->nextofkintelephone->FormValue;
		$this->nextofkinemail->CurrentValue = $this->nextofkinemail->FormValue;
		$this->nextofkinaddress->CurrentValue = $this->nextofkinaddress->FormValue;
		$this->nameofcompany->CurrentValue = $this->nameofcompany->FormValue;
		$this->humanresourcescontacttelephone->CurrentValue = $this->humanresourcescontacttelephone->FormValue;
		$this->humanresourcescontactemailaddress->CurrentValue = $this->humanresourcescontactemailaddress->FormValue;
	}

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
		$this->marriagetype->setDbValue($rs->fields('marriagetype'));
		$this->marriageyear->setDbValue($rs->fields('marriageyear'));
		$this->marriagecert->setDbValue($rs->fields('marriagecert'));
		$this->divorce->setDbValue($rs->fields('divorce'));
		$this->divorceyear->setDbValue($rs->fields('divorceyear'));
		$this->datecreated->setDbValue($rs->fields('datecreated'));
		$this->maidenname->setDbValue($rs->fields('maidenname'));
		$this->identificationtype->setDbValue($rs->fields('identificationtype'));
		$this->idnumber->setDbValue($rs->fields('idnumber'));
		$this->issuedate->setDbValue($rs->fields('issuedate'));
		$this->expirydate->setDbValue($rs->fields('expirydate'));
		$this->issueplace->setDbValue($rs->fields('issueplace'));
		$this->spousename->setDbValue($rs->fields('spousename'));
		$this->spouseemail->setDbValue($rs->fields('spouseemail'));
		$this->spousephone->setDbValue($rs->fields('spousephone'));
		$this->spousedob->setDbValue($rs->fields('spousedob'));
		$this->spouseaddr->setDbValue($rs->fields('spouseaddr'));
		$this->spousecity->setDbValue($rs->fields('spousecity'));
		$this->spousestate->setDbValue($rs->fields('spousestate'));
		$this->cityofmarriage->setDbValue($rs->fields('cityofmarriage'));
		$this->countryofmarriage->setDbValue($rs->fields('countryofmarriage'));
		$this->nextofkinfullname->setDbValue($rs->fields('nextofkinfullname'));
		$this->nextofkintelephone->setDbValue($rs->fields('nextofkintelephone'));
		$this->nextofkinemail->setDbValue($rs->fields('nextofkinemail'));
		$this->nextofkinaddress->setDbValue($rs->fields('nextofkinaddress'));
		$this->nameofcompany->setDbValue($rs->fields('nameofcompany'));
		$this->humanresourcescontacttelephone->setDbValue($rs->fields('humanresourcescontacttelephone'));
		$this->humanresourcescontactemailaddress->setDbValue($rs->fields('humanresourcescontactemailaddress'));
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
		$this->marriagetype->DbValue = $row['marriagetype'];
		$this->marriageyear->DbValue = $row['marriageyear'];
		$this->marriagecert->DbValue = $row['marriagecert'];
		$this->divorce->DbValue = $row['divorce'];
		$this->divorceyear->DbValue = $row['divorceyear'];
		$this->datecreated->DbValue = $row['datecreated'];
		$this->maidenname->DbValue = $row['maidenname'];
		$this->identificationtype->DbValue = $row['identificationtype'];
		$this->idnumber->DbValue = $row['idnumber'];
		$this->issuedate->DbValue = $row['issuedate'];
		$this->expirydate->DbValue = $row['expirydate'];
		$this->issueplace->DbValue = $row['issueplace'];
		$this->spousename->DbValue = $row['spousename'];
		$this->spouseemail->DbValue = $row['spouseemail'];
		$this->spousephone->DbValue = $row['spousephone'];
		$this->spousedob->DbValue = $row['spousedob'];
		$this->spouseaddr->DbValue = $row['spouseaddr'];
		$this->spousecity->DbValue = $row['spousecity'];
		$this->spousestate->DbValue = $row['spousestate'];
		$this->cityofmarriage->DbValue = $row['cityofmarriage'];
		$this->countryofmarriage->DbValue = $row['countryofmarriage'];
		$this->nextofkinfullname->DbValue = $row['nextofkinfullname'];
		$this->nextofkintelephone->DbValue = $row['nextofkintelephone'];
		$this->nextofkinemail->DbValue = $row['nextofkinemail'];
		$this->nextofkinaddress->DbValue = $row['nextofkinaddress'];
		$this->nameofcompany->DbValue = $row['nameofcompany'];
		$this->humanresourcescontacttelephone->DbValue = $row['humanresourcescontacttelephone'];
		$this->humanresourcescontactemailaddress->DbValue = $row['humanresourcescontactemailaddress'];
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
		// marriagetype
		// marriageyear
		// marriagecert
		// divorce
		// divorceyear
		// datecreated
		// maidenname
		// identificationtype
		// idnumber
		// issuedate
		// expirydate
		// issueplace
		// spousename
		// spouseemail
		// spousephone
		// spousedob
		// spouseaddr
		// spousecity
		// spousestate
		// cityofmarriage
		// countryofmarriage
		// nextofkinfullname
		// nextofkintelephone
		// nextofkinemail
		// nextofkinaddress
		// nameofcompany
		// humanresourcescontacttelephone
		// humanresourcescontactemailaddress

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

			// marriagetype
			$this->marriagetype->ViewValue = $this->marriagetype->CurrentValue;
			$this->marriagetype->ViewCustomAttributes = "";

			// marriageyear
			$this->marriageyear->ViewValue = $this->marriageyear->CurrentValue;
			$this->marriageyear->ViewCustomAttributes = "";

			// marriagecert
			$this->marriagecert->ViewValue = $this->marriagecert->CurrentValue;
			$this->marriagecert->ViewCustomAttributes = "";

			// divorce
			$this->divorce->ViewValue = $this->divorce->CurrentValue;
			$this->divorce->ViewCustomAttributes = "";

			// divorceyear
			$this->divorceyear->ViewValue = $this->divorceyear->CurrentValue;
			$this->divorceyear->ViewCustomAttributes = "";

			// datecreated
			$this->datecreated->ViewValue = $this->datecreated->CurrentValue;
			$this->datecreated->ViewCustomAttributes = "";

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

			// cityofmarriage
			$this->cityofmarriage->ViewValue = $this->cityofmarriage->CurrentValue;
			$this->cityofmarriage->ViewCustomAttributes = "";

			// countryofmarriage
			$this->countryofmarriage->ViewValue = $this->countryofmarriage->CurrentValue;
			$this->countryofmarriage->ViewCustomAttributes = "";

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

			// id
			$this->id->LinkCustomAttributes = "";
			$this->id->HrefValue = "";
			$this->id->TooltipValue = "";

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
			$this->fullname->HrefValue = "";
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

			// divorce
			$this->divorce->LinkCustomAttributes = "";
			$this->divorce->HrefValue = "";
			$this->divorce->TooltipValue = "";

			// divorceyear
			$this->divorceyear->LinkCustomAttributes = "";
			$this->divorceyear->HrefValue = "";
			$this->divorceyear->TooltipValue = "";

			// datecreated
			$this->datecreated->LinkCustomAttributes = "";
			$this->datecreated->HrefValue = "";
			$this->datecreated->TooltipValue = "";

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

			// cityofmarriage
			$this->cityofmarriage->LinkCustomAttributes = "";
			$this->cityofmarriage->HrefValue = "";
			$this->cityofmarriage->TooltipValue = "";

			// countryofmarriage
			$this->countryofmarriage->LinkCustomAttributes = "";
			$this->countryofmarriage->HrefValue = "";
			$this->countryofmarriage->TooltipValue = "";

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
		} elseif ($this->RowType == EW_ROWTYPE_EDIT) { // Edit row

			// id
			$this->id->EditCustomAttributes = "";
			$this->id->EditValue = $this->id->CurrentValue;
			$this->id->ViewCustomAttributes = "";

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

			// divorce
			$this->divorce->EditCustomAttributes = "";
			$this->divorce->EditValue = ew_HtmlEncode($this->divorce->CurrentValue);
			$this->divorce->PlaceHolder = ew_HtmlEncode(ew_RemoveHtml($this->divorce->FldCaption()));

			// divorceyear
			$this->divorceyear->EditCustomAttributes = "";
			$this->divorceyear->EditValue = ew_HtmlEncode($this->divorceyear->CurrentValue);
			$this->divorceyear->PlaceHolder = ew_HtmlEncode(ew_RemoveHtml($this->divorceyear->FldCaption()));

			// datecreated
			$this->datecreated->EditCustomAttributes = "";
			$this->datecreated->EditValue = ew_HtmlEncode($this->datecreated->CurrentValue);
			$this->datecreated->PlaceHolder = ew_HtmlEncode(ew_RemoveHtml($this->datecreated->FldCaption()));

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

			// cityofmarriage
			$this->cityofmarriage->EditCustomAttributes = "";
			$this->cityofmarriage->EditValue = ew_HtmlEncode($this->cityofmarriage->CurrentValue);
			$this->cityofmarriage->PlaceHolder = ew_HtmlEncode(ew_RemoveHtml($this->cityofmarriage->FldCaption()));

			// countryofmarriage
			$this->countryofmarriage->EditCustomAttributes = "";
			$this->countryofmarriage->EditValue = ew_HtmlEncode($this->countryofmarriage->CurrentValue);
			$this->countryofmarriage->PlaceHolder = ew_HtmlEncode(ew_RemoveHtml($this->countryofmarriage->FldCaption()));

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

			// Edit refer script
			// id

			$this->id->HrefValue = "";

			// uid
			$this->uid->HrefValue = "";

			// willtype
			$this->willtype->HrefValue = "";

			// fullname
			$this->fullname->HrefValue = "";

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

			// marriagetype
			$this->marriagetype->HrefValue = "";

			// marriageyear
			$this->marriageyear->HrefValue = "";

			// marriagecert
			$this->marriagecert->HrefValue = "";

			// divorce
			$this->divorce->HrefValue = "";

			// divorceyear
			$this->divorceyear->HrefValue = "";

			// datecreated
			$this->datecreated->HrefValue = "";

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

			// cityofmarriage
			$this->cityofmarriage->HrefValue = "";

			// countryofmarriage
			$this->countryofmarriage->HrefValue = "";

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

	// Update record based on key values
	function EditRow() {
		global $conn, $Security, $Language;
		$sFilter = $this->KeyFilter();
		$this->CurrentFilter = $sFilter;
		$sSql = $this->SQL();
		$conn->raiseErrorFn = 'ew_ErrorFn';
		$rs = $conn->Execute($sSql);
		$conn->raiseErrorFn = '';
		if ($rs === FALSE)
			return FALSE;
		if ($rs->EOF) {
			$EditRow = FALSE; // Update Failed
		} else {

			// Save old values
			$rsold = &$rs->fields;
			$this->LoadDbValues($rsold);
			$rsnew = array();

			// uid
			$this->uid->SetDbValueDef($rsnew, $this->uid->CurrentValue, NULL, $this->uid->ReadOnly);

			// willtype
			$this->willtype->SetDbValueDef($rsnew, $this->willtype->CurrentValue, NULL, $this->willtype->ReadOnly);

			// fullname
			$this->fullname->SetDbValueDef($rsnew, $this->fullname->CurrentValue, NULL, $this->fullname->ReadOnly);

			// address
			$this->address->SetDbValueDef($rsnew, $this->address->CurrentValue, NULL, $this->address->ReadOnly);

			// email
			$this->_email->SetDbValueDef($rsnew, $this->_email->CurrentValue, NULL, $this->_email->ReadOnly);

			// phoneno
			$this->phoneno->SetDbValueDef($rsnew, $this->phoneno->CurrentValue, NULL, $this->phoneno->ReadOnly);

			// aphoneno
			$this->aphoneno->SetDbValueDef($rsnew, $this->aphoneno->CurrentValue, NULL, $this->aphoneno->ReadOnly);

			// gender
			$this->gender->SetDbValueDef($rsnew, $this->gender->CurrentValue, NULL, $this->gender->ReadOnly);

			// dob
			$this->dob->SetDbValueDef($rsnew, $this->dob->CurrentValue, NULL, $this->dob->ReadOnly);

			// state
			$this->state->SetDbValueDef($rsnew, $this->state->CurrentValue, NULL, $this->state->ReadOnly);

			// nationality
			$this->nationality->SetDbValueDef($rsnew, $this->nationality->CurrentValue, NULL, $this->nationality->ReadOnly);

			// lga
			$this->lga->SetDbValueDef($rsnew, $this->lga->CurrentValue, NULL, $this->lga->ReadOnly);

			// employmentstatus
			$this->employmentstatus->SetDbValueDef($rsnew, $this->employmentstatus->CurrentValue, NULL, $this->employmentstatus->ReadOnly);

			// employer
			$this->employer->SetDbValueDef($rsnew, $this->employer->CurrentValue, NULL, $this->employer->ReadOnly);

			// employerphone
			$this->employerphone->SetDbValueDef($rsnew, $this->employerphone->CurrentValue, NULL, $this->employerphone->ReadOnly);

			// employeraddr
			$this->employeraddr->SetDbValueDef($rsnew, $this->employeraddr->CurrentValue, NULL, $this->employeraddr->ReadOnly);

			// maritalstatus
			$this->maritalstatus->SetDbValueDef($rsnew, $this->maritalstatus->CurrentValue, NULL, $this->maritalstatus->ReadOnly);

			// marriagetype
			$this->marriagetype->SetDbValueDef($rsnew, $this->marriagetype->CurrentValue, NULL, $this->marriagetype->ReadOnly);

			// marriageyear
			$this->marriageyear->SetDbValueDef($rsnew, $this->marriageyear->CurrentValue, NULL, $this->marriageyear->ReadOnly);

			// marriagecert
			$this->marriagecert->SetDbValueDef($rsnew, $this->marriagecert->CurrentValue, NULL, $this->marriagecert->ReadOnly);

			// divorce
			$this->divorce->SetDbValueDef($rsnew, $this->divorce->CurrentValue, NULL, $this->divorce->ReadOnly);

			// divorceyear
			$this->divorceyear->SetDbValueDef($rsnew, $this->divorceyear->CurrentValue, NULL, $this->divorceyear->ReadOnly);

			// datecreated
			$this->datecreated->SetDbValueDef($rsnew, $this->datecreated->CurrentValue, NULL, $this->datecreated->ReadOnly);

			// maidenname
			$this->maidenname->SetDbValueDef($rsnew, $this->maidenname->CurrentValue, NULL, $this->maidenname->ReadOnly);

			// identificationtype
			$this->identificationtype->SetDbValueDef($rsnew, $this->identificationtype->CurrentValue, NULL, $this->identificationtype->ReadOnly);

			// idnumber
			$this->idnumber->SetDbValueDef($rsnew, $this->idnumber->CurrentValue, NULL, $this->idnumber->ReadOnly);

			// issuedate
			$this->issuedate->SetDbValueDef($rsnew, $this->issuedate->CurrentValue, NULL, $this->issuedate->ReadOnly);

			// expirydate
			$this->expirydate->SetDbValueDef($rsnew, $this->expirydate->CurrentValue, NULL, $this->expirydate->ReadOnly);

			// issueplace
			$this->issueplace->SetDbValueDef($rsnew, $this->issueplace->CurrentValue, NULL, $this->issueplace->ReadOnly);

			// spousename
			$this->spousename->SetDbValueDef($rsnew, $this->spousename->CurrentValue, NULL, $this->spousename->ReadOnly);

			// spouseemail
			$this->spouseemail->SetDbValueDef($rsnew, $this->spouseemail->CurrentValue, NULL, $this->spouseemail->ReadOnly);

			// spousephone
			$this->spousephone->SetDbValueDef($rsnew, $this->spousephone->CurrentValue, NULL, $this->spousephone->ReadOnly);

			// spousedob
			$this->spousedob->SetDbValueDef($rsnew, $this->spousedob->CurrentValue, NULL, $this->spousedob->ReadOnly);

			// spouseaddr
			$this->spouseaddr->SetDbValueDef($rsnew, $this->spouseaddr->CurrentValue, NULL, $this->spouseaddr->ReadOnly);

			// spousecity
			$this->spousecity->SetDbValueDef($rsnew, $this->spousecity->CurrentValue, NULL, $this->spousecity->ReadOnly);

			// spousestate
			$this->spousestate->SetDbValueDef($rsnew, $this->spousestate->CurrentValue, NULL, $this->spousestate->ReadOnly);

			// cityofmarriage
			$this->cityofmarriage->SetDbValueDef($rsnew, $this->cityofmarriage->CurrentValue, NULL, $this->cityofmarriage->ReadOnly);

			// countryofmarriage
			$this->countryofmarriage->SetDbValueDef($rsnew, $this->countryofmarriage->CurrentValue, NULL, $this->countryofmarriage->ReadOnly);

			// nextofkinfullname
			$this->nextofkinfullname->SetDbValueDef($rsnew, $this->nextofkinfullname->CurrentValue, NULL, $this->nextofkinfullname->ReadOnly);

			// nextofkintelephone
			$this->nextofkintelephone->SetDbValueDef($rsnew, $this->nextofkintelephone->CurrentValue, NULL, $this->nextofkintelephone->ReadOnly);

			// nextofkinemail
			$this->nextofkinemail->SetDbValueDef($rsnew, $this->nextofkinemail->CurrentValue, NULL, $this->nextofkinemail->ReadOnly);

			// nextofkinaddress
			$this->nextofkinaddress->SetDbValueDef($rsnew, $this->nextofkinaddress->CurrentValue, NULL, $this->nextofkinaddress->ReadOnly);

			// nameofcompany
			$this->nameofcompany->SetDbValueDef($rsnew, $this->nameofcompany->CurrentValue, NULL, $this->nameofcompany->ReadOnly);

			// humanresourcescontacttelephone
			$this->humanresourcescontacttelephone->SetDbValueDef($rsnew, $this->humanresourcescontacttelephone->CurrentValue, NULL, $this->humanresourcescontacttelephone->ReadOnly);

			// humanresourcescontactemailaddress
			$this->humanresourcescontactemailaddress->SetDbValueDef($rsnew, $this->humanresourcescontactemailaddress->CurrentValue, NULL, $this->humanresourcescontactemailaddress->ReadOnly);

			// Call Row Updating event
			$bUpdateRow = $this->Row_Updating($rsold, $rsnew);
			if ($bUpdateRow) {
				$conn->raiseErrorFn = 'ew_ErrorFn';
				if (count($rsnew) > 0)
					$EditRow = $this->Update($rsnew, "", $rsold);
				else
					$EditRow = TRUE; // No field to update
				$conn->raiseErrorFn = '';
				if ($EditRow) {
				}
			} else {
				if ($this->getSuccessMessage() <> "" || $this->getFailureMessage() <> "") {

					// Use the message, do nothing
				} elseif ($this->CancelMessage <> "") {
					$this->setFailureMessage($this->CancelMessage);
					$this->CancelMessage = "";
				} else {
					$this->setFailureMessage($Language->Phrase("UpdateCancelled"));
				}
				$EditRow = FALSE;
			}
		}

		// Call Row_Updated event
		if ($EditRow)
			$this->Row_Updated($rsold, $rsnew);
		$rs->Close();
		return $EditRow;
	}

	// Set up Breadcrumb
	function SetupBreadcrumb() {
		global $Breadcrumb, $Language;
		$Breadcrumb = new cBreadcrumb();
		$PageCaption = $this->TableCaption();
		$Breadcrumb->Add("list", "<span id=\"ewPageCaption\">" . $PageCaption . "</span>", "reservetrust_tblist.php", $this->TableVar);
		$PageCaption = $Language->Phrase("edit");
		$Breadcrumb->Add("edit", "<span id=\"ewPageCaption\">" . $PageCaption . "</span>", ew_CurrentUrl(), $this->TableVar);
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
if (!isset($reservetrust_tb_edit)) $reservetrust_tb_edit = new creservetrust_tb_edit();

// Page init
$reservetrust_tb_edit->Page_Init();

// Page main
$reservetrust_tb_edit->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$reservetrust_tb_edit->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Page object
var reservetrust_tb_edit = new ew_Page("reservetrust_tb_edit");
reservetrust_tb_edit.PageID = "edit"; // Page ID
var EW_PAGE_ID = reservetrust_tb_edit.PageID; // For backward compatibility

// Form object
var freservetrust_tbedit = new ew_Form("freservetrust_tbedit");

// Validate form
freservetrust_tbedit.Validate = function() {
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
				return this.OnError(elm, "<?php echo ew_JsEncode2($reservetrust_tb->uid->FldErrMsg()) ?>");

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
freservetrust_tbedit.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
freservetrust_tbedit.ValidateRequired = true;
<?php } else { ?>
freservetrust_tbedit.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
// Form object for search

</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<?php $Breadcrumb->Render(); ?>
<?php $reservetrust_tb_edit->ShowPageHeader(); ?>
<?php
$reservetrust_tb_edit->ShowMessage();
?>
<form name="freservetrust_tbedit" id="freservetrust_tbedit" class="ewForm form-horizontal" action="<?php echo ew_CurrentPage() ?>" method="post">
<input type="hidden" name="t" value="reservetrust_tb">
<input type="hidden" name="a_edit" id="a_edit" value="U">
<table cellspacing="0" class="ewGrid"><tr><td>
<table id="tbl_reservetrust_tbedit" class="table table-bordered table-striped">
<?php if ($reservetrust_tb->id->Visible) { // id ?>
	<tr id="r_id">
		<td><span id="elh_reservetrust_tb_id"><?php echo $reservetrust_tb->id->FldCaption() ?></span></td>
		<td<?php echo $reservetrust_tb->id->CellAttributes() ?>>
<span id="el_reservetrust_tb_id" class="control-group">
<span<?php echo $reservetrust_tb->id->ViewAttributes() ?>>
<?php echo $reservetrust_tb->id->EditValue ?></span>
</span>
<input type="hidden" data-field="x_id" name="x_id" id="x_id" value="<?php echo ew_HtmlEncode($reservetrust_tb->id->CurrentValue) ?>">
<?php echo $reservetrust_tb->id->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($reservetrust_tb->uid->Visible) { // uid ?>
	<tr id="r_uid">
		<td><span id="elh_reservetrust_tb_uid"><?php echo $reservetrust_tb->uid->FldCaption() ?></span></td>
		<td<?php echo $reservetrust_tb->uid->CellAttributes() ?>>
<span id="el_reservetrust_tb_uid" class="control-group">
<input type="text" data-field="x_uid" name="x_uid" id="x_uid" size="30" placeholder="<?php echo $reservetrust_tb->uid->PlaceHolder ?>" value="<?php echo $reservetrust_tb->uid->EditValue ?>"<?php echo $reservetrust_tb->uid->EditAttributes() ?>>
</span>
<?php echo $reservetrust_tb->uid->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($reservetrust_tb->willtype->Visible) { // willtype ?>
	<tr id="r_willtype">
		<td><span id="elh_reservetrust_tb_willtype"><?php echo $reservetrust_tb->willtype->FldCaption() ?></span></td>
		<td<?php echo $reservetrust_tb->willtype->CellAttributes() ?>>
<span id="el_reservetrust_tb_willtype" class="control-group">
<input type="text" data-field="x_willtype" name="x_willtype" id="x_willtype" size="30" maxlength="100" placeholder="<?php echo $reservetrust_tb->willtype->PlaceHolder ?>" value="<?php echo $reservetrust_tb->willtype->EditValue ?>"<?php echo $reservetrust_tb->willtype->EditAttributes() ?>>
</span>
<?php echo $reservetrust_tb->willtype->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($reservetrust_tb->fullname->Visible) { // fullname ?>
	<tr id="r_fullname">
		<td><span id="elh_reservetrust_tb_fullname"><?php echo $reservetrust_tb->fullname->FldCaption() ?></span></td>
		<td<?php echo $reservetrust_tb->fullname->CellAttributes() ?>>
<span id="el_reservetrust_tb_fullname" class="control-group">
<input type="text" data-field="x_fullname" name="x_fullname" id="x_fullname" size="30" maxlength="100" placeholder="<?php echo $reservetrust_tb->fullname->PlaceHolder ?>" value="<?php echo $reservetrust_tb->fullname->EditValue ?>"<?php echo $reservetrust_tb->fullname->EditAttributes() ?>>
</span>
<?php echo $reservetrust_tb->fullname->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($reservetrust_tb->address->Visible) { // address ?>
	<tr id="r_address">
		<td><span id="elh_reservetrust_tb_address"><?php echo $reservetrust_tb->address->FldCaption() ?></span></td>
		<td<?php echo $reservetrust_tb->address->CellAttributes() ?>>
<span id="el_reservetrust_tb_address" class="control-group">
<textarea data-field="x_address" name="x_address" id="x_address" cols="35" rows="4" placeholder="<?php echo $reservetrust_tb->address->PlaceHolder ?>"<?php echo $reservetrust_tb->address->EditAttributes() ?>><?php echo $reservetrust_tb->address->EditValue ?></textarea>
</span>
<?php echo $reservetrust_tb->address->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($reservetrust_tb->_email->Visible) { // email ?>
	<tr id="r__email">
		<td><span id="elh_reservetrust_tb__email"><?php echo $reservetrust_tb->_email->FldCaption() ?></span></td>
		<td<?php echo $reservetrust_tb->_email->CellAttributes() ?>>
<span id="el_reservetrust_tb__email" class="control-group">
<input type="text" data-field="x__email" name="x__email" id="x__email" size="30" maxlength="50" placeholder="<?php echo $reservetrust_tb->_email->PlaceHolder ?>" value="<?php echo $reservetrust_tb->_email->EditValue ?>"<?php echo $reservetrust_tb->_email->EditAttributes() ?>>
</span>
<?php echo $reservetrust_tb->_email->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($reservetrust_tb->phoneno->Visible) { // phoneno ?>
	<tr id="r_phoneno">
		<td><span id="elh_reservetrust_tb_phoneno"><?php echo $reservetrust_tb->phoneno->FldCaption() ?></span></td>
		<td<?php echo $reservetrust_tb->phoneno->CellAttributes() ?>>
<span id="el_reservetrust_tb_phoneno" class="control-group">
<input type="text" data-field="x_phoneno" name="x_phoneno" id="x_phoneno" size="30" maxlength="20" placeholder="<?php echo $reservetrust_tb->phoneno->PlaceHolder ?>" value="<?php echo $reservetrust_tb->phoneno->EditValue ?>"<?php echo $reservetrust_tb->phoneno->EditAttributes() ?>>
</span>
<?php echo $reservetrust_tb->phoneno->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($reservetrust_tb->aphoneno->Visible) { // aphoneno ?>
	<tr id="r_aphoneno">
		<td><span id="elh_reservetrust_tb_aphoneno"><?php echo $reservetrust_tb->aphoneno->FldCaption() ?></span></td>
		<td<?php echo $reservetrust_tb->aphoneno->CellAttributes() ?>>
<span id="el_reservetrust_tb_aphoneno" class="control-group">
<input type="text" data-field="x_aphoneno" name="x_aphoneno" id="x_aphoneno" size="30" maxlength="20" placeholder="<?php echo $reservetrust_tb->aphoneno->PlaceHolder ?>" value="<?php echo $reservetrust_tb->aphoneno->EditValue ?>"<?php echo $reservetrust_tb->aphoneno->EditAttributes() ?>>
</span>
<?php echo $reservetrust_tb->aphoneno->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($reservetrust_tb->gender->Visible) { // gender ?>
	<tr id="r_gender">
		<td><span id="elh_reservetrust_tb_gender"><?php echo $reservetrust_tb->gender->FldCaption() ?></span></td>
		<td<?php echo $reservetrust_tb->gender->CellAttributes() ?>>
<span id="el_reservetrust_tb_gender" class="control-group">
<input type="text" data-field="x_gender" name="x_gender" id="x_gender" size="30" maxlength="10" placeholder="<?php echo $reservetrust_tb->gender->PlaceHolder ?>" value="<?php echo $reservetrust_tb->gender->EditValue ?>"<?php echo $reservetrust_tb->gender->EditAttributes() ?>>
</span>
<?php echo $reservetrust_tb->gender->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($reservetrust_tb->dob->Visible) { // dob ?>
	<tr id="r_dob">
		<td><span id="elh_reservetrust_tb_dob"><?php echo $reservetrust_tb->dob->FldCaption() ?></span></td>
		<td<?php echo $reservetrust_tb->dob->CellAttributes() ?>>
<span id="el_reservetrust_tb_dob" class="control-group">
<input type="text" data-field="x_dob" name="x_dob" id="x_dob" size="30" maxlength="20" placeholder="<?php echo $reservetrust_tb->dob->PlaceHolder ?>" value="<?php echo $reservetrust_tb->dob->EditValue ?>"<?php echo $reservetrust_tb->dob->EditAttributes() ?>>
</span>
<?php echo $reservetrust_tb->dob->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($reservetrust_tb->state->Visible) { // state ?>
	<tr id="r_state">
		<td><span id="elh_reservetrust_tb_state"><?php echo $reservetrust_tb->state->FldCaption() ?></span></td>
		<td<?php echo $reservetrust_tb->state->CellAttributes() ?>>
<span id="el_reservetrust_tb_state" class="control-group">
<input type="text" data-field="x_state" name="x_state" id="x_state" size="30" maxlength="20" placeholder="<?php echo $reservetrust_tb->state->PlaceHolder ?>" value="<?php echo $reservetrust_tb->state->EditValue ?>"<?php echo $reservetrust_tb->state->EditAttributes() ?>>
</span>
<?php echo $reservetrust_tb->state->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($reservetrust_tb->nationality->Visible) { // nationality ?>
	<tr id="r_nationality">
		<td><span id="elh_reservetrust_tb_nationality"><?php echo $reservetrust_tb->nationality->FldCaption() ?></span></td>
		<td<?php echo $reservetrust_tb->nationality->CellAttributes() ?>>
<span id="el_reservetrust_tb_nationality" class="control-group">
<input type="text" data-field="x_nationality" name="x_nationality" id="x_nationality" size="30" maxlength="20" placeholder="<?php echo $reservetrust_tb->nationality->PlaceHolder ?>" value="<?php echo $reservetrust_tb->nationality->EditValue ?>"<?php echo $reservetrust_tb->nationality->EditAttributes() ?>>
</span>
<?php echo $reservetrust_tb->nationality->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($reservetrust_tb->lga->Visible) { // lga ?>
	<tr id="r_lga">
		<td><span id="elh_reservetrust_tb_lga"><?php echo $reservetrust_tb->lga->FldCaption() ?></span></td>
		<td<?php echo $reservetrust_tb->lga->CellAttributes() ?>>
<span id="el_reservetrust_tb_lga" class="control-group">
<input type="text" data-field="x_lga" name="x_lga" id="x_lga" size="30" maxlength="50" placeholder="<?php echo $reservetrust_tb->lga->PlaceHolder ?>" value="<?php echo $reservetrust_tb->lga->EditValue ?>"<?php echo $reservetrust_tb->lga->EditAttributes() ?>>
</span>
<?php echo $reservetrust_tb->lga->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($reservetrust_tb->employmentstatus->Visible) { // employmentstatus ?>
	<tr id="r_employmentstatus">
		<td><span id="elh_reservetrust_tb_employmentstatus"><?php echo $reservetrust_tb->employmentstatus->FldCaption() ?></span></td>
		<td<?php echo $reservetrust_tb->employmentstatus->CellAttributes() ?>>
<span id="el_reservetrust_tb_employmentstatus" class="control-group">
<input type="text" data-field="x_employmentstatus" name="x_employmentstatus" id="x_employmentstatus" size="30" maxlength="50" placeholder="<?php echo $reservetrust_tb->employmentstatus->PlaceHolder ?>" value="<?php echo $reservetrust_tb->employmentstatus->EditValue ?>"<?php echo $reservetrust_tb->employmentstatus->EditAttributes() ?>>
</span>
<?php echo $reservetrust_tb->employmentstatus->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($reservetrust_tb->employer->Visible) { // employer ?>
	<tr id="r_employer">
		<td><span id="elh_reservetrust_tb_employer"><?php echo $reservetrust_tb->employer->FldCaption() ?></span></td>
		<td<?php echo $reservetrust_tb->employer->CellAttributes() ?>>
<span id="el_reservetrust_tb_employer" class="control-group">
<textarea data-field="x_employer" name="x_employer" id="x_employer" cols="35" rows="4" placeholder="<?php echo $reservetrust_tb->employer->PlaceHolder ?>"<?php echo $reservetrust_tb->employer->EditAttributes() ?>><?php echo $reservetrust_tb->employer->EditValue ?></textarea>
</span>
<?php echo $reservetrust_tb->employer->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($reservetrust_tb->employerphone->Visible) { // employerphone ?>
	<tr id="r_employerphone">
		<td><span id="elh_reservetrust_tb_employerphone"><?php echo $reservetrust_tb->employerphone->FldCaption() ?></span></td>
		<td<?php echo $reservetrust_tb->employerphone->CellAttributes() ?>>
<span id="el_reservetrust_tb_employerphone" class="control-group">
<input type="text" data-field="x_employerphone" name="x_employerphone" id="x_employerphone" size="30" maxlength="50" placeholder="<?php echo $reservetrust_tb->employerphone->PlaceHolder ?>" value="<?php echo $reservetrust_tb->employerphone->EditValue ?>"<?php echo $reservetrust_tb->employerphone->EditAttributes() ?>>
</span>
<?php echo $reservetrust_tb->employerphone->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($reservetrust_tb->employeraddr->Visible) { // employeraddr ?>
	<tr id="r_employeraddr">
		<td><span id="elh_reservetrust_tb_employeraddr"><?php echo $reservetrust_tb->employeraddr->FldCaption() ?></span></td>
		<td<?php echo $reservetrust_tb->employeraddr->CellAttributes() ?>>
<span id="el_reservetrust_tb_employeraddr" class="control-group">
<textarea data-field="x_employeraddr" name="x_employeraddr" id="x_employeraddr" cols="35" rows="4" placeholder="<?php echo $reservetrust_tb->employeraddr->PlaceHolder ?>"<?php echo $reservetrust_tb->employeraddr->EditAttributes() ?>><?php echo $reservetrust_tb->employeraddr->EditValue ?></textarea>
</span>
<?php echo $reservetrust_tb->employeraddr->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($reservetrust_tb->maritalstatus->Visible) { // maritalstatus ?>
	<tr id="r_maritalstatus">
		<td><span id="elh_reservetrust_tb_maritalstatus"><?php echo $reservetrust_tb->maritalstatus->FldCaption() ?></span></td>
		<td<?php echo $reservetrust_tb->maritalstatus->CellAttributes() ?>>
<span id="el_reservetrust_tb_maritalstatus" class="control-group">
<input type="text" data-field="x_maritalstatus" name="x_maritalstatus" id="x_maritalstatus" size="30" maxlength="50" placeholder="<?php echo $reservetrust_tb->maritalstatus->PlaceHolder ?>" value="<?php echo $reservetrust_tb->maritalstatus->EditValue ?>"<?php echo $reservetrust_tb->maritalstatus->EditAttributes() ?>>
</span>
<?php echo $reservetrust_tb->maritalstatus->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($reservetrust_tb->marriagetype->Visible) { // marriagetype ?>
	<tr id="r_marriagetype">
		<td><span id="elh_reservetrust_tb_marriagetype"><?php echo $reservetrust_tb->marriagetype->FldCaption() ?></span></td>
		<td<?php echo $reservetrust_tb->marriagetype->CellAttributes() ?>>
<span id="el_reservetrust_tb_marriagetype" class="control-group">
<input type="text" data-field="x_marriagetype" name="x_marriagetype" id="x_marriagetype" size="30" maxlength="20" placeholder="<?php echo $reservetrust_tb->marriagetype->PlaceHolder ?>" value="<?php echo $reservetrust_tb->marriagetype->EditValue ?>"<?php echo $reservetrust_tb->marriagetype->EditAttributes() ?>>
</span>
<?php echo $reservetrust_tb->marriagetype->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($reservetrust_tb->marriageyear->Visible) { // marriageyear ?>
	<tr id="r_marriageyear">
		<td><span id="elh_reservetrust_tb_marriageyear"><?php echo $reservetrust_tb->marriageyear->FldCaption() ?></span></td>
		<td<?php echo $reservetrust_tb->marriageyear->CellAttributes() ?>>
<span id="el_reservetrust_tb_marriageyear" class="control-group">
<input type="text" data-field="x_marriageyear" name="x_marriageyear" id="x_marriageyear" size="30" maxlength="10" placeholder="<?php echo $reservetrust_tb->marriageyear->PlaceHolder ?>" value="<?php echo $reservetrust_tb->marriageyear->EditValue ?>"<?php echo $reservetrust_tb->marriageyear->EditAttributes() ?>>
</span>
<?php echo $reservetrust_tb->marriageyear->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($reservetrust_tb->marriagecert->Visible) { // marriagecert ?>
	<tr id="r_marriagecert">
		<td><span id="elh_reservetrust_tb_marriagecert"><?php echo $reservetrust_tb->marriagecert->FldCaption() ?></span></td>
		<td<?php echo $reservetrust_tb->marriagecert->CellAttributes() ?>>
<span id="el_reservetrust_tb_marriagecert" class="control-group">
<input type="text" data-field="x_marriagecert" name="x_marriagecert" id="x_marriagecert" size="30" maxlength="50" placeholder="<?php echo $reservetrust_tb->marriagecert->PlaceHolder ?>" value="<?php echo $reservetrust_tb->marriagecert->EditValue ?>"<?php echo $reservetrust_tb->marriagecert->EditAttributes() ?>>
</span>
<?php echo $reservetrust_tb->marriagecert->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($reservetrust_tb->divorce->Visible) { // divorce ?>
	<tr id="r_divorce">
		<td><span id="elh_reservetrust_tb_divorce"><?php echo $reservetrust_tb->divorce->FldCaption() ?></span></td>
		<td<?php echo $reservetrust_tb->divorce->CellAttributes() ?>>
<span id="el_reservetrust_tb_divorce" class="control-group">
<input type="text" data-field="x_divorce" name="x_divorce" id="x_divorce" size="30" maxlength="10" placeholder="<?php echo $reservetrust_tb->divorce->PlaceHolder ?>" value="<?php echo $reservetrust_tb->divorce->EditValue ?>"<?php echo $reservetrust_tb->divorce->EditAttributes() ?>>
</span>
<?php echo $reservetrust_tb->divorce->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($reservetrust_tb->divorceyear->Visible) { // divorceyear ?>
	<tr id="r_divorceyear">
		<td><span id="elh_reservetrust_tb_divorceyear"><?php echo $reservetrust_tb->divorceyear->FldCaption() ?></span></td>
		<td<?php echo $reservetrust_tb->divorceyear->CellAttributes() ?>>
<span id="el_reservetrust_tb_divorceyear" class="control-group">
<input type="text" data-field="x_divorceyear" name="x_divorceyear" id="x_divorceyear" size="30" maxlength="10" placeholder="<?php echo $reservetrust_tb->divorceyear->PlaceHolder ?>" value="<?php echo $reservetrust_tb->divorceyear->EditValue ?>"<?php echo $reservetrust_tb->divorceyear->EditAttributes() ?>>
</span>
<?php echo $reservetrust_tb->divorceyear->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($reservetrust_tb->datecreated->Visible) { // datecreated ?>
	<tr id="r_datecreated">
		<td><span id="elh_reservetrust_tb_datecreated"><?php echo $reservetrust_tb->datecreated->FldCaption() ?></span></td>
		<td<?php echo $reservetrust_tb->datecreated->CellAttributes() ?>>
<span id="el_reservetrust_tb_datecreated" class="control-group">
<input type="text" data-field="x_datecreated" name="x_datecreated" id="x_datecreated" placeholder="<?php echo $reservetrust_tb->datecreated->PlaceHolder ?>" value="<?php echo $reservetrust_tb->datecreated->EditValue ?>"<?php echo $reservetrust_tb->datecreated->EditAttributes() ?>>
</span>
<?php echo $reservetrust_tb->datecreated->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($reservetrust_tb->maidenname->Visible) { // maidenname ?>
	<tr id="r_maidenname">
		<td><span id="elh_reservetrust_tb_maidenname"><?php echo $reservetrust_tb->maidenname->FldCaption() ?></span></td>
		<td<?php echo $reservetrust_tb->maidenname->CellAttributes() ?>>
<span id="el_reservetrust_tb_maidenname" class="control-group">
<input type="text" data-field="x_maidenname" name="x_maidenname" id="x_maidenname" size="30" maxlength="50" placeholder="<?php echo $reservetrust_tb->maidenname->PlaceHolder ?>" value="<?php echo $reservetrust_tb->maidenname->EditValue ?>"<?php echo $reservetrust_tb->maidenname->EditAttributes() ?>>
</span>
<?php echo $reservetrust_tb->maidenname->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($reservetrust_tb->identificationtype->Visible) { // identificationtype ?>
	<tr id="r_identificationtype">
		<td><span id="elh_reservetrust_tb_identificationtype"><?php echo $reservetrust_tb->identificationtype->FldCaption() ?></span></td>
		<td<?php echo $reservetrust_tb->identificationtype->CellAttributes() ?>>
<span id="el_reservetrust_tb_identificationtype" class="control-group">
<input type="text" data-field="x_identificationtype" name="x_identificationtype" id="x_identificationtype" size="30" maxlength="50" placeholder="<?php echo $reservetrust_tb->identificationtype->PlaceHolder ?>" value="<?php echo $reservetrust_tb->identificationtype->EditValue ?>"<?php echo $reservetrust_tb->identificationtype->EditAttributes() ?>>
</span>
<?php echo $reservetrust_tb->identificationtype->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($reservetrust_tb->idnumber->Visible) { // idnumber ?>
	<tr id="r_idnumber">
		<td><span id="elh_reservetrust_tb_idnumber"><?php echo $reservetrust_tb->idnumber->FldCaption() ?></span></td>
		<td<?php echo $reservetrust_tb->idnumber->CellAttributes() ?>>
<span id="el_reservetrust_tb_idnumber" class="control-group">
<input type="text" data-field="x_idnumber" name="x_idnumber" id="x_idnumber" size="30" maxlength="50" placeholder="<?php echo $reservetrust_tb->idnumber->PlaceHolder ?>" value="<?php echo $reservetrust_tb->idnumber->EditValue ?>"<?php echo $reservetrust_tb->idnumber->EditAttributes() ?>>
</span>
<?php echo $reservetrust_tb->idnumber->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($reservetrust_tb->issuedate->Visible) { // issuedate ?>
	<tr id="r_issuedate">
		<td><span id="elh_reservetrust_tb_issuedate"><?php echo $reservetrust_tb->issuedate->FldCaption() ?></span></td>
		<td<?php echo $reservetrust_tb->issuedate->CellAttributes() ?>>
<span id="el_reservetrust_tb_issuedate" class="control-group">
<input type="text" data-field="x_issuedate" name="x_issuedate" id="x_issuedate" size="30" maxlength="50" placeholder="<?php echo $reservetrust_tb->issuedate->PlaceHolder ?>" value="<?php echo $reservetrust_tb->issuedate->EditValue ?>"<?php echo $reservetrust_tb->issuedate->EditAttributes() ?>>
</span>
<?php echo $reservetrust_tb->issuedate->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($reservetrust_tb->expirydate->Visible) { // expirydate ?>
	<tr id="r_expirydate">
		<td><span id="elh_reservetrust_tb_expirydate"><?php echo $reservetrust_tb->expirydate->FldCaption() ?></span></td>
		<td<?php echo $reservetrust_tb->expirydate->CellAttributes() ?>>
<span id="el_reservetrust_tb_expirydate" class="control-group">
<input type="text" data-field="x_expirydate" name="x_expirydate" id="x_expirydate" size="30" maxlength="50" placeholder="<?php echo $reservetrust_tb->expirydate->PlaceHolder ?>" value="<?php echo $reservetrust_tb->expirydate->EditValue ?>"<?php echo $reservetrust_tb->expirydate->EditAttributes() ?>>
</span>
<?php echo $reservetrust_tb->expirydate->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($reservetrust_tb->issueplace->Visible) { // issueplace ?>
	<tr id="r_issueplace">
		<td><span id="elh_reservetrust_tb_issueplace"><?php echo $reservetrust_tb->issueplace->FldCaption() ?></span></td>
		<td<?php echo $reservetrust_tb->issueplace->CellAttributes() ?>>
<span id="el_reservetrust_tb_issueplace" class="control-group">
<input type="text" data-field="x_issueplace" name="x_issueplace" id="x_issueplace" size="30" maxlength="50" placeholder="<?php echo $reservetrust_tb->issueplace->PlaceHolder ?>" value="<?php echo $reservetrust_tb->issueplace->EditValue ?>"<?php echo $reservetrust_tb->issueplace->EditAttributes() ?>>
</span>
<?php echo $reservetrust_tb->issueplace->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($reservetrust_tb->spousename->Visible) { // spousename ?>
	<tr id="r_spousename">
		<td><span id="elh_reservetrust_tb_spousename"><?php echo $reservetrust_tb->spousename->FldCaption() ?></span></td>
		<td<?php echo $reservetrust_tb->spousename->CellAttributes() ?>>
<span id="el_reservetrust_tb_spousename" class="control-group">
<input type="text" data-field="x_spousename" name="x_spousename" id="x_spousename" size="30" maxlength="50" placeholder="<?php echo $reservetrust_tb->spousename->PlaceHolder ?>" value="<?php echo $reservetrust_tb->spousename->EditValue ?>"<?php echo $reservetrust_tb->spousename->EditAttributes() ?>>
</span>
<?php echo $reservetrust_tb->spousename->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($reservetrust_tb->spouseemail->Visible) { // spouseemail ?>
	<tr id="r_spouseemail">
		<td><span id="elh_reservetrust_tb_spouseemail"><?php echo $reservetrust_tb->spouseemail->FldCaption() ?></span></td>
		<td<?php echo $reservetrust_tb->spouseemail->CellAttributes() ?>>
<span id="el_reservetrust_tb_spouseemail" class="control-group">
<input type="text" data-field="x_spouseemail" name="x_spouseemail" id="x_spouseemail" size="30" maxlength="50" placeholder="<?php echo $reservetrust_tb->spouseemail->PlaceHolder ?>" value="<?php echo $reservetrust_tb->spouseemail->EditValue ?>"<?php echo $reservetrust_tb->spouseemail->EditAttributes() ?>>
</span>
<?php echo $reservetrust_tb->spouseemail->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($reservetrust_tb->spousephone->Visible) { // spousephone ?>
	<tr id="r_spousephone">
		<td><span id="elh_reservetrust_tb_spousephone"><?php echo $reservetrust_tb->spousephone->FldCaption() ?></span></td>
		<td<?php echo $reservetrust_tb->spousephone->CellAttributes() ?>>
<span id="el_reservetrust_tb_spousephone" class="control-group">
<input type="text" data-field="x_spousephone" name="x_spousephone" id="x_spousephone" size="30" maxlength="20" placeholder="<?php echo $reservetrust_tb->spousephone->PlaceHolder ?>" value="<?php echo $reservetrust_tb->spousephone->EditValue ?>"<?php echo $reservetrust_tb->spousephone->EditAttributes() ?>>
</span>
<?php echo $reservetrust_tb->spousephone->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($reservetrust_tb->spousedob->Visible) { // spousedob ?>
	<tr id="r_spousedob">
		<td><span id="elh_reservetrust_tb_spousedob"><?php echo $reservetrust_tb->spousedob->FldCaption() ?></span></td>
		<td<?php echo $reservetrust_tb->spousedob->CellAttributes() ?>>
<span id="el_reservetrust_tb_spousedob" class="control-group">
<input type="text" data-field="x_spousedob" name="x_spousedob" id="x_spousedob" size="30" maxlength="10" placeholder="<?php echo $reservetrust_tb->spousedob->PlaceHolder ?>" value="<?php echo $reservetrust_tb->spousedob->EditValue ?>"<?php echo $reservetrust_tb->spousedob->EditAttributes() ?>>
</span>
<?php echo $reservetrust_tb->spousedob->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($reservetrust_tb->spouseaddr->Visible) { // spouseaddr ?>
	<tr id="r_spouseaddr">
		<td><span id="elh_reservetrust_tb_spouseaddr"><?php echo $reservetrust_tb->spouseaddr->FldCaption() ?></span></td>
		<td<?php echo $reservetrust_tb->spouseaddr->CellAttributes() ?>>
<span id="el_reservetrust_tb_spouseaddr" class="control-group">
<textarea data-field="x_spouseaddr" name="x_spouseaddr" id="x_spouseaddr" cols="35" rows="4" placeholder="<?php echo $reservetrust_tb->spouseaddr->PlaceHolder ?>"<?php echo $reservetrust_tb->spouseaddr->EditAttributes() ?>><?php echo $reservetrust_tb->spouseaddr->EditValue ?></textarea>
</span>
<?php echo $reservetrust_tb->spouseaddr->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($reservetrust_tb->spousecity->Visible) { // spousecity ?>
	<tr id="r_spousecity">
		<td><span id="elh_reservetrust_tb_spousecity"><?php echo $reservetrust_tb->spousecity->FldCaption() ?></span></td>
		<td<?php echo $reservetrust_tb->spousecity->CellAttributes() ?>>
<span id="el_reservetrust_tb_spousecity" class="control-group">
<input type="text" data-field="x_spousecity" name="x_spousecity" id="x_spousecity" size="30" maxlength="50" placeholder="<?php echo $reservetrust_tb->spousecity->PlaceHolder ?>" value="<?php echo $reservetrust_tb->spousecity->EditValue ?>"<?php echo $reservetrust_tb->spousecity->EditAttributes() ?>>
</span>
<?php echo $reservetrust_tb->spousecity->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($reservetrust_tb->spousestate->Visible) { // spousestate ?>
	<tr id="r_spousestate">
		<td><span id="elh_reservetrust_tb_spousestate"><?php echo $reservetrust_tb->spousestate->FldCaption() ?></span></td>
		<td<?php echo $reservetrust_tb->spousestate->CellAttributes() ?>>
<span id="el_reservetrust_tb_spousestate" class="control-group">
<input type="text" data-field="x_spousestate" name="x_spousestate" id="x_spousestate" size="30" maxlength="50" placeholder="<?php echo $reservetrust_tb->spousestate->PlaceHolder ?>" value="<?php echo $reservetrust_tb->spousestate->EditValue ?>"<?php echo $reservetrust_tb->spousestate->EditAttributes() ?>>
</span>
<?php echo $reservetrust_tb->spousestate->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($reservetrust_tb->cityofmarriage->Visible) { // cityofmarriage ?>
	<tr id="r_cityofmarriage">
		<td><span id="elh_reservetrust_tb_cityofmarriage"><?php echo $reservetrust_tb->cityofmarriage->FldCaption() ?></span></td>
		<td<?php echo $reservetrust_tb->cityofmarriage->CellAttributes() ?>>
<span id="el_reservetrust_tb_cityofmarriage" class="control-group">
<input type="text" data-field="x_cityofmarriage" name="x_cityofmarriage" id="x_cityofmarriage" size="30" maxlength="50" placeholder="<?php echo $reservetrust_tb->cityofmarriage->PlaceHolder ?>" value="<?php echo $reservetrust_tb->cityofmarriage->EditValue ?>"<?php echo $reservetrust_tb->cityofmarriage->EditAttributes() ?>>
</span>
<?php echo $reservetrust_tb->cityofmarriage->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($reservetrust_tb->countryofmarriage->Visible) { // countryofmarriage ?>
	<tr id="r_countryofmarriage">
		<td><span id="elh_reservetrust_tb_countryofmarriage"><?php echo $reservetrust_tb->countryofmarriage->FldCaption() ?></span></td>
		<td<?php echo $reservetrust_tb->countryofmarriage->CellAttributes() ?>>
<span id="el_reservetrust_tb_countryofmarriage" class="control-group">
<input type="text" data-field="x_countryofmarriage" name="x_countryofmarriage" id="x_countryofmarriage" size="30" maxlength="50" placeholder="<?php echo $reservetrust_tb->countryofmarriage->PlaceHolder ?>" value="<?php echo $reservetrust_tb->countryofmarriage->EditValue ?>"<?php echo $reservetrust_tb->countryofmarriage->EditAttributes() ?>>
</span>
<?php echo $reservetrust_tb->countryofmarriage->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($reservetrust_tb->nextofkinfullname->Visible) { // nextofkinfullname ?>
	<tr id="r_nextofkinfullname">
		<td><span id="elh_reservetrust_tb_nextofkinfullname"><?php echo $reservetrust_tb->nextofkinfullname->FldCaption() ?></span></td>
		<td<?php echo $reservetrust_tb->nextofkinfullname->CellAttributes() ?>>
<span id="el_reservetrust_tb_nextofkinfullname" class="control-group">
<input type="text" data-field="x_nextofkinfullname" name="x_nextofkinfullname" id="x_nextofkinfullname" size="30" maxlength="100" placeholder="<?php echo $reservetrust_tb->nextofkinfullname->PlaceHolder ?>" value="<?php echo $reservetrust_tb->nextofkinfullname->EditValue ?>"<?php echo $reservetrust_tb->nextofkinfullname->EditAttributes() ?>>
</span>
<?php echo $reservetrust_tb->nextofkinfullname->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($reservetrust_tb->nextofkintelephone->Visible) { // nextofkintelephone ?>
	<tr id="r_nextofkintelephone">
		<td><span id="elh_reservetrust_tb_nextofkintelephone"><?php echo $reservetrust_tb->nextofkintelephone->FldCaption() ?></span></td>
		<td<?php echo $reservetrust_tb->nextofkintelephone->CellAttributes() ?>>
<span id="el_reservetrust_tb_nextofkintelephone" class="control-group">
<input type="text" data-field="x_nextofkintelephone" name="x_nextofkintelephone" id="x_nextofkintelephone" size="30" maxlength="20" placeholder="<?php echo $reservetrust_tb->nextofkintelephone->PlaceHolder ?>" value="<?php echo $reservetrust_tb->nextofkintelephone->EditValue ?>"<?php echo $reservetrust_tb->nextofkintelephone->EditAttributes() ?>>
</span>
<?php echo $reservetrust_tb->nextofkintelephone->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($reservetrust_tb->nextofkinemail->Visible) { // nextofkinemail ?>
	<tr id="r_nextofkinemail">
		<td><span id="elh_reservetrust_tb_nextofkinemail"><?php echo $reservetrust_tb->nextofkinemail->FldCaption() ?></span></td>
		<td<?php echo $reservetrust_tb->nextofkinemail->CellAttributes() ?>>
<span id="el_reservetrust_tb_nextofkinemail" class="control-group">
<input type="text" data-field="x_nextofkinemail" name="x_nextofkinemail" id="x_nextofkinemail" size="30" maxlength="50" placeholder="<?php echo $reservetrust_tb->nextofkinemail->PlaceHolder ?>" value="<?php echo $reservetrust_tb->nextofkinemail->EditValue ?>"<?php echo $reservetrust_tb->nextofkinemail->EditAttributes() ?>>
</span>
<?php echo $reservetrust_tb->nextofkinemail->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($reservetrust_tb->nextofkinaddress->Visible) { // nextofkinaddress ?>
	<tr id="r_nextofkinaddress">
		<td><span id="elh_reservetrust_tb_nextofkinaddress"><?php echo $reservetrust_tb->nextofkinaddress->FldCaption() ?></span></td>
		<td<?php echo $reservetrust_tb->nextofkinaddress->CellAttributes() ?>>
<span id="el_reservetrust_tb_nextofkinaddress" class="control-group">
<textarea data-field="x_nextofkinaddress" name="x_nextofkinaddress" id="x_nextofkinaddress" cols="35" rows="4" placeholder="<?php echo $reservetrust_tb->nextofkinaddress->PlaceHolder ?>"<?php echo $reservetrust_tb->nextofkinaddress->EditAttributes() ?>><?php echo $reservetrust_tb->nextofkinaddress->EditValue ?></textarea>
</span>
<?php echo $reservetrust_tb->nextofkinaddress->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($reservetrust_tb->nameofcompany->Visible) { // nameofcompany ?>
	<tr id="r_nameofcompany">
		<td><span id="elh_reservetrust_tb_nameofcompany"><?php echo $reservetrust_tb->nameofcompany->FldCaption() ?></span></td>
		<td<?php echo $reservetrust_tb->nameofcompany->CellAttributes() ?>>
<span id="el_reservetrust_tb_nameofcompany" class="control-group">
<input type="text" data-field="x_nameofcompany" name="x_nameofcompany" id="x_nameofcompany" size="30" maxlength="100" placeholder="<?php echo $reservetrust_tb->nameofcompany->PlaceHolder ?>" value="<?php echo $reservetrust_tb->nameofcompany->EditValue ?>"<?php echo $reservetrust_tb->nameofcompany->EditAttributes() ?>>
</span>
<?php echo $reservetrust_tb->nameofcompany->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($reservetrust_tb->humanresourcescontacttelephone->Visible) { // humanresourcescontacttelephone ?>
	<tr id="r_humanresourcescontacttelephone">
		<td><span id="elh_reservetrust_tb_humanresourcescontacttelephone"><?php echo $reservetrust_tb->humanresourcescontacttelephone->FldCaption() ?></span></td>
		<td<?php echo $reservetrust_tb->humanresourcescontacttelephone->CellAttributes() ?>>
<span id="el_reservetrust_tb_humanresourcescontacttelephone" class="control-group">
<input type="text" data-field="x_humanresourcescontacttelephone" name="x_humanresourcescontacttelephone" id="x_humanresourcescontacttelephone" size="30" maxlength="20" placeholder="<?php echo $reservetrust_tb->humanresourcescontacttelephone->PlaceHolder ?>" value="<?php echo $reservetrust_tb->humanresourcescontacttelephone->EditValue ?>"<?php echo $reservetrust_tb->humanresourcescontacttelephone->EditAttributes() ?>>
</span>
<?php echo $reservetrust_tb->humanresourcescontacttelephone->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($reservetrust_tb->humanresourcescontactemailaddress->Visible) { // humanresourcescontactemailaddress ?>
	<tr id="r_humanresourcescontactemailaddress">
		<td><span id="elh_reservetrust_tb_humanresourcescontactemailaddress"><?php echo $reservetrust_tb->humanresourcescontactemailaddress->FldCaption() ?></span></td>
		<td<?php echo $reservetrust_tb->humanresourcescontactemailaddress->CellAttributes() ?>>
<span id="el_reservetrust_tb_humanresourcescontactemailaddress" class="control-group">
<input type="text" data-field="x_humanresourcescontactemailaddress" name="x_humanresourcescontactemailaddress" id="x_humanresourcescontactemailaddress" size="30" maxlength="50" placeholder="<?php echo $reservetrust_tb->humanresourcescontactemailaddress->PlaceHolder ?>" value="<?php echo $reservetrust_tb->humanresourcescontactemailaddress->EditValue ?>"<?php echo $reservetrust_tb->humanresourcescontactemailaddress->EditAttributes() ?>>
</span>
<?php echo $reservetrust_tb->humanresourcescontactemailaddress->CustomMsg ?></td>
	</tr>
<?php } ?>
</table>
</td></tr></table>
<table class="ewPager">
<tr><td>
<?php if (!isset($reservetrust_tb_edit->Pager)) $reservetrust_tb_edit->Pager = new cNumericPager($reservetrust_tb_edit->StartRec, $reservetrust_tb_edit->DisplayRecs, $reservetrust_tb_edit->TotalRecs, $reservetrust_tb_edit->RecRange) ?>
<?php if ($reservetrust_tb_edit->Pager->RecordCount > 0) { ?>
<table cellspacing="0" class="ewStdTable"><tbody><tr><td>
<div class="pagination"><ul>
	<?php if ($reservetrust_tb_edit->Pager->FirstButton->Enabled) { ?>
	<li><a href="<?php echo $reservetrust_tb_edit->PageUrl() ?>start=<?php echo $reservetrust_tb_edit->Pager->FirstButton->Start ?>"><?php echo $Language->Phrase("PagerFirst") ?></a></li>
	<?php } ?>
	<?php if ($reservetrust_tb_edit->Pager->PrevButton->Enabled) { ?>
	<li><a href="<?php echo $reservetrust_tb_edit->PageUrl() ?>start=<?php echo $reservetrust_tb_edit->Pager->PrevButton->Start ?>"><?php echo $Language->Phrase("PagerPrevious") ?></a></li>
	<?php } ?>
	<?php foreach ($reservetrust_tb_edit->Pager->Items as $PagerItem) { ?>
		<li<?php if (!$PagerItem->Enabled) { echo " class=\" active\""; } ?>><a href="<?php if ($PagerItem->Enabled) { echo $reservetrust_tb_edit->PageUrl() . "start=" . $PagerItem->Start; } else { echo "#"; } ?>"><?php echo $PagerItem->Text ?></a></li>
	<?php } ?>
	<?php if ($reservetrust_tb_edit->Pager->NextButton->Enabled) { ?>
	<li><a href="<?php echo $reservetrust_tb_edit->PageUrl() ?>start=<?php echo $reservetrust_tb_edit->Pager->NextButton->Start ?>"><?php echo $Language->Phrase("PagerNext") ?></a></li>
	<?php } ?>
	<?php if ($reservetrust_tb_edit->Pager->LastButton->Enabled) { ?>
	<li><a href="<?php echo $reservetrust_tb_edit->PageUrl() ?>start=<?php echo $reservetrust_tb_edit->Pager->LastButton->Start ?>"><?php echo $Language->Phrase("PagerLast") ?></a></li>
	<?php } ?>
</ul></div>
</td>
</tr></tbody></table>
<?php } else { ?>
	<p><?php echo $Language->Phrase("NoRecord") ?></p>
<?php } ?>
</td>
</tr></table>
<button class="btn btn-primary ewButton" name="btnAction" id="btnAction" type="submit"><?php echo $Language->Phrase("EditBtn") ?></button>
</form>
<script type="text/javascript">
freservetrust_tbedit.Init();
<?php if (EW_MOBILE_REFLOW && ew_IsMobile()) { ?>
ew_Reflow();
<?php } ?>
</script>
<?php
$reservetrust_tb_edit->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$reservetrust_tb_edit->Page_Terminate();
?>
