<?php
if (session_id() == "") session_start(); // Initialize Session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg10.php" ?>
<?php include_once "ewmysql10.php" ?>
<?php include_once "phpfn10.php" ?>
<?php include_once "children_detailsinfo.php" ?>
<?php include_once "adminusersinfo.php" ?>
<?php include_once "personal_infoinfo.php" ?>
<?php include_once "spouse_tbinfo.php" ?>
<?php include_once "beneficiary_dumpgridcls.php" ?>
<?php include_once "userfn10.php" ?>
<?php

//
// Page class
//

$children_details_edit = NULL; // Initialize page object first

class cchildren_details_edit extends cchildren_details {

	// Page ID
	var $PageID = 'edit';

	// Project ID
	var $ProjectID = "{D9B361E7-B2C1-4293-B9B3-B581986A15CC}";

	// Table name
	var $TableName = 'children_details';

	// Page object name
	var $PageObjName = 'children_details_edit';

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

		// Table object (children_details)
		if (!isset($GLOBALS["children_details"])) {
			$GLOBALS["children_details"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["children_details"];
		}

		// Table object (adminusers)
		if (!isset($GLOBALS['adminusers'])) $GLOBALS['adminusers'] = new cadminusers();

		// Table object (personal_info)
		if (!isset($GLOBALS['personal_info'])) $GLOBALS['personal_info'] = new cpersonal_info();

		// Table object (spouse_tb)
		if (!isset($GLOBALS['spouse_tb'])) $GLOBALS['spouse_tb'] = new cspouse_tb();

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'edit', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'children_details', TRUE);

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

		// Set up master detail parameters
		$this->SetUpMasterParms();

		// Set up Breadcrumb
		$this->SetupBreadcrumb();

		// Load recordset
		$this->StartRec = 1; // Initialize start position
		if ($this->Recordset = $this->LoadRecordset()) // Load records
			$this->TotalRecs = $this->Recordset->RecordCount(); // Get record count
		if ($this->TotalRecs <= 0) { // No record found
			if ($this->getSuccessMessage() == "" && $this->getFailureMessage() == "")
				$this->setFailureMessage($Language->Phrase("NoRecord")); // Set no record message
			$this->Page_Terminate("children_detailslist.php"); // Return to list page
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

			// Set up detail parameters
			$this->SetUpDetailParms();
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
					$this->Page_Terminate("children_detailslist.php"); // Return to list page
				} else {
					$this->LoadRowValues($this->Recordset); // Load row values
				}

				// Set up detail parameters
				$this->SetUpDetailParms();
				break;
			Case "U": // Update
				$this->SendEmail = TRUE; // Send email on update success
				if ($this->EditRow()) { // Update record based on key
					if ($this->getSuccessMessage() == "")
						$this->setSuccessMessage($Language->Phrase("UpdateSuccess")); // Update success
					if ($this->getCurrentDetailTable() <> "") // Master/detail edit
						$sReturnUrl = $this->GetDetailUrl();
					else
						$sReturnUrl = $this->getReturnUrl();
					if (ew_GetPageName($sReturnUrl) == "children_detailsview.php")
						$sReturnUrl = $this->GetViewUrl(); // View paging, return to View page directly
					$this->Page_Terminate($sReturnUrl); // Return to caller
				} else {
					$this->EventCancelled = TRUE; // Event cancelled
					$this->RestoreFormValues(); // Restore form values if update failed

					// Set up detail parameters
					$this->SetUpDetailParms();
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
		if (!$this->name->FldIsDetailKey) {
			$this->name->setFormValue($objForm->GetValue("x_name"));
		}
		if (!$this->gender->FldIsDetailKey) {
			$this->gender->setFormValue($objForm->GetValue("x_gender"));
		}
		if (!$this->dob->FldIsDetailKey) {
			$this->dob->setFormValue($objForm->GetValue("x_dob"));
		}
		if (!$this->age->FldIsDetailKey) {
			$this->age->setFormValue($objForm->GetValue("x_age"));
		}
		if (!$this->title->FldIsDetailKey) {
			$this->title->setFormValue($objForm->GetValue("x_title"));
		}
		if (!$this->guardianname->FldIsDetailKey) {
			$this->guardianname->setFormValue($objForm->GetValue("x_guardianname"));
		}
		if (!$this->rtionship->FldIsDetailKey) {
			$this->rtionship->setFormValue($objForm->GetValue("x_rtionship"));
		}
		if (!$this->_email->FldIsDetailKey) {
			$this->_email->setFormValue($objForm->GetValue("x__email"));
		}
		if (!$this->phone->FldIsDetailKey) {
			$this->phone->setFormValue($objForm->GetValue("x_phone"));
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
		if (!$this->stipend->FldIsDetailKey) {
			$this->stipend->setFormValue($objForm->GetValue("x_stipend"));
		}
		if (!$this->alt_beneficiary->FldIsDetailKey) {
			$this->alt_beneficiary->setFormValue($objForm->GetValue("x_alt_beneficiary"));
		}
		if (!$this->datecreated->FldIsDetailKey) {
			$this->datecreated->setFormValue($objForm->GetValue("x_datecreated"));
			$this->datecreated->CurrentValue = ew_UnFormatDateTime($this->datecreated->CurrentValue, 0);
		}
		if (!$this->passport->FldIsDetailKey) {
			$this->passport->setFormValue($objForm->GetValue("x_passport"));
		}
	}

	// Restore form values
	function RestoreFormValues() {
		global $objForm;
		$this->LoadRow();
		$this->id->CurrentValue = $this->id->FormValue;
		$this->uid->CurrentValue = $this->uid->FormValue;
		$this->name->CurrentValue = $this->name->FormValue;
		$this->gender->CurrentValue = $this->gender->FormValue;
		$this->dob->CurrentValue = $this->dob->FormValue;
		$this->age->CurrentValue = $this->age->FormValue;
		$this->title->CurrentValue = $this->title->FormValue;
		$this->guardianname->CurrentValue = $this->guardianname->FormValue;
		$this->rtionship->CurrentValue = $this->rtionship->FormValue;
		$this->_email->CurrentValue = $this->_email->FormValue;
		$this->phone->CurrentValue = $this->phone->FormValue;
		$this->addr->CurrentValue = $this->addr->FormValue;
		$this->city->CurrentValue = $this->city->FormValue;
		$this->state->CurrentValue = $this->state->FormValue;
		$this->stipend->CurrentValue = $this->stipend->FormValue;
		$this->alt_beneficiary->CurrentValue = $this->alt_beneficiary->FormValue;
		$this->datecreated->CurrentValue = $this->datecreated->FormValue;
		$this->datecreated->CurrentValue = ew_UnFormatDateTime($this->datecreated->CurrentValue, 0);
		$this->passport->CurrentValue = $this->passport->FormValue;
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
		$this->name->setDbValue($rs->fields('name'));
		$this->gender->setDbValue($rs->fields('gender'));
		$this->dob->setDbValue($rs->fields('dob'));
		$this->age->setDbValue($rs->fields('age'));
		$this->title->setDbValue($rs->fields('title'));
		$this->guardianname->setDbValue($rs->fields('guardianname'));
		$this->rtionship->setDbValue($rs->fields('rtionship'));
		$this->_email->setDbValue($rs->fields('email'));
		$this->phone->setDbValue($rs->fields('phone'));
		$this->addr->setDbValue($rs->fields('addr'));
		$this->city->setDbValue($rs->fields('city'));
		$this->state->setDbValue($rs->fields('state'));
		$this->stipend->setDbValue($rs->fields('stipend'));
		$this->alt_beneficiary->setDbValue($rs->fields('alt_beneficiary'));
		$this->datecreated->setDbValue($rs->fields('datecreated'));
		$this->passport->setDbValue($rs->fields('passport'));
	}

	// Load DbValue from recordset
	function LoadDbValues(&$rs) {
		if (!$rs || !is_array($rs) && $rs->EOF) return;
		$row = is_array($rs) ? $rs : $rs->fields;
		$this->id->DbValue = $row['id'];
		$this->uid->DbValue = $row['uid'];
		$this->name->DbValue = $row['name'];
		$this->gender->DbValue = $row['gender'];
		$this->dob->DbValue = $row['dob'];
		$this->age->DbValue = $row['age'];
		$this->title->DbValue = $row['title'];
		$this->guardianname->DbValue = $row['guardianname'];
		$this->rtionship->DbValue = $row['rtionship'];
		$this->_email->DbValue = $row['email'];
		$this->phone->DbValue = $row['phone'];
		$this->addr->DbValue = $row['addr'];
		$this->city->DbValue = $row['city'];
		$this->state->DbValue = $row['state'];
		$this->stipend->DbValue = $row['stipend'];
		$this->alt_beneficiary->DbValue = $row['alt_beneficiary'];
		$this->datecreated->DbValue = $row['datecreated'];
		$this->passport->DbValue = $row['passport'];
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
		// name
		// gender
		// dob
		// age
		// title
		// guardianname
		// rtionship
		// email
		// phone
		// addr
		// city
		// state
		// stipend
		// alt_beneficiary
		// datecreated
		// passport

		if ($this->RowType == EW_ROWTYPE_VIEW) { // View row

			// id
			$this->id->ViewValue = $this->id->CurrentValue;
			$this->id->ViewCustomAttributes = "";

			// uid
			$this->uid->ViewValue = $this->uid->CurrentValue;
			$this->uid->ViewCustomAttributes = "";

			// name
			$this->name->ViewValue = $this->name->CurrentValue;
			$this->name->ViewCustomAttributes = "";

			// gender
			$this->gender->ViewValue = $this->gender->CurrentValue;
			$this->gender->ViewCustomAttributes = "";

			// dob
			$this->dob->ViewValue = $this->dob->CurrentValue;
			$this->dob->ViewCustomAttributes = "";

			// age
			$this->age->ViewValue = $this->age->CurrentValue;
			$this->age->ViewCustomAttributes = "";

			// title
			$this->title->ViewValue = $this->title->CurrentValue;
			$this->title->ViewCustomAttributes = "";

			// guardianname
			$this->guardianname->ViewValue = $this->guardianname->CurrentValue;
			$this->guardianname->ViewCustomAttributes = "";

			// rtionship
			$this->rtionship->ViewValue = $this->rtionship->CurrentValue;
			$this->rtionship->ViewCustomAttributes = "";

			// email
			$this->_email->ViewValue = $this->_email->CurrentValue;
			$this->_email->ViewCustomAttributes = "";

			// phone
			$this->phone->ViewValue = $this->phone->CurrentValue;
			$this->phone->ViewCustomAttributes = "";

			// addr
			$this->addr->ViewValue = $this->addr->CurrentValue;
			$this->addr->ViewCustomAttributes = "";

			// city
			$this->city->ViewValue = $this->city->CurrentValue;
			$this->city->ViewCustomAttributes = "";

			// state
			$this->state->ViewValue = $this->state->CurrentValue;
			$this->state->ViewCustomAttributes = "";

			// stipend
			$this->stipend->ViewValue = $this->stipend->CurrentValue;
			$this->stipend->ViewCustomAttributes = "";

			// alt_beneficiary
			$this->alt_beneficiary->ViewValue = $this->alt_beneficiary->CurrentValue;
			$this->alt_beneficiary->ViewCustomAttributes = "";

			// datecreated
			$this->datecreated->ViewValue = $this->datecreated->CurrentValue;
			$this->datecreated->ViewCustomAttributes = "";

			// passport
			$this->passport->ViewValue = $this->passport->CurrentValue;
			$this->passport->ViewCustomAttributes = "";

			// id
			$this->id->LinkCustomAttributes = "";
			$this->id->HrefValue = "";
			$this->id->TooltipValue = "";

			// uid
			$this->uid->LinkCustomAttributes = "";
			$this->uid->HrefValue = "";
			$this->uid->TooltipValue = "";

			// name
			$this->name->LinkCustomAttributes = "";
			$this->name->HrefValue = "";
			$this->name->TooltipValue = "";

			// gender
			$this->gender->LinkCustomAttributes = "";
			$this->gender->HrefValue = "";
			$this->gender->TooltipValue = "";

			// dob
			$this->dob->LinkCustomAttributes = "";
			$this->dob->HrefValue = "";
			$this->dob->TooltipValue = "";

			// age
			$this->age->LinkCustomAttributes = "";
			$this->age->HrefValue = "";
			$this->age->TooltipValue = "";

			// title
			$this->title->LinkCustomAttributes = "";
			$this->title->HrefValue = "";
			$this->title->TooltipValue = "";

			// guardianname
			$this->guardianname->LinkCustomAttributes = "";
			$this->guardianname->HrefValue = "";
			$this->guardianname->TooltipValue = "";

			// rtionship
			$this->rtionship->LinkCustomAttributes = "";
			$this->rtionship->HrefValue = "";
			$this->rtionship->TooltipValue = "";

			// email
			$this->_email->LinkCustomAttributes = "";
			$this->_email->HrefValue = "";
			$this->_email->TooltipValue = "";

			// phone
			$this->phone->LinkCustomAttributes = "";
			$this->phone->HrefValue = "";
			$this->phone->TooltipValue = "";

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

			// stipend
			$this->stipend->LinkCustomAttributes = "";
			$this->stipend->HrefValue = "";
			$this->stipend->TooltipValue = "";

			// alt_beneficiary
			$this->alt_beneficiary->LinkCustomAttributes = "";
			$this->alt_beneficiary->HrefValue = "";
			$this->alt_beneficiary->TooltipValue = "";

			// datecreated
			$this->datecreated->LinkCustomAttributes = "";
			$this->datecreated->HrefValue = "";
			$this->datecreated->TooltipValue = "";

			// passport
			$this->passport->LinkCustomAttributes = "";
			$this->passport->HrefValue = "";
			$this->passport->TooltipValue = "";
		} elseif ($this->RowType == EW_ROWTYPE_EDIT) { // Edit row

			// id
			$this->id->EditCustomAttributes = "";
			$this->id->EditValue = $this->id->CurrentValue;
			$this->id->ViewCustomAttributes = "";

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

			// name
			$this->name->EditCustomAttributes = "";
			$this->name->EditValue = ew_HtmlEncode($this->name->CurrentValue);
			$this->name->PlaceHolder = ew_HtmlEncode(ew_RemoveHtml($this->name->FldCaption()));

			// gender
			$this->gender->EditCustomAttributes = "";
			$this->gender->EditValue = ew_HtmlEncode($this->gender->CurrentValue);
			$this->gender->PlaceHolder = ew_HtmlEncode(ew_RemoveHtml($this->gender->FldCaption()));

			// dob
			$this->dob->EditCustomAttributes = "";
			$this->dob->EditValue = ew_HtmlEncode($this->dob->CurrentValue);
			$this->dob->PlaceHolder = ew_HtmlEncode(ew_RemoveHtml($this->dob->FldCaption()));

			// age
			$this->age->EditCustomAttributes = "";
			$this->age->EditValue = ew_HtmlEncode($this->age->CurrentValue);
			$this->age->PlaceHolder = ew_HtmlEncode(ew_RemoveHtml($this->age->FldCaption()));

			// title
			$this->title->EditCustomAttributes = "";
			$this->title->EditValue = ew_HtmlEncode($this->title->CurrentValue);
			$this->title->PlaceHolder = ew_HtmlEncode(ew_RemoveHtml($this->title->FldCaption()));

			// guardianname
			$this->guardianname->EditCustomAttributes = "";
			$this->guardianname->EditValue = ew_HtmlEncode($this->guardianname->CurrentValue);
			$this->guardianname->PlaceHolder = ew_HtmlEncode(ew_RemoveHtml($this->guardianname->FldCaption()));

			// rtionship
			$this->rtionship->EditCustomAttributes = "";
			$this->rtionship->EditValue = ew_HtmlEncode($this->rtionship->CurrentValue);
			$this->rtionship->PlaceHolder = ew_HtmlEncode(ew_RemoveHtml($this->rtionship->FldCaption()));

			// email
			$this->_email->EditCustomAttributes = "";
			$this->_email->EditValue = ew_HtmlEncode($this->_email->CurrentValue);
			$this->_email->PlaceHolder = ew_HtmlEncode(ew_RemoveHtml($this->_email->FldCaption()));

			// phone
			$this->phone->EditCustomAttributes = "";
			$this->phone->EditValue = ew_HtmlEncode($this->phone->CurrentValue);
			$this->phone->PlaceHolder = ew_HtmlEncode(ew_RemoveHtml($this->phone->FldCaption()));

			// addr
			$this->addr->EditCustomAttributes = "";
			$this->addr->EditValue = $this->addr->CurrentValue;
			$this->addr->PlaceHolder = ew_HtmlEncode(ew_RemoveHtml($this->addr->FldCaption()));

			// city
			$this->city->EditCustomAttributes = "";
			$this->city->EditValue = ew_HtmlEncode($this->city->CurrentValue);
			$this->city->PlaceHolder = ew_HtmlEncode(ew_RemoveHtml($this->city->FldCaption()));

			// state
			$this->state->EditCustomAttributes = "";
			$this->state->EditValue = ew_HtmlEncode($this->state->CurrentValue);
			$this->state->PlaceHolder = ew_HtmlEncode(ew_RemoveHtml($this->state->FldCaption()));

			// stipend
			$this->stipend->EditCustomAttributes = "";
			$this->stipend->EditValue = $this->stipend->CurrentValue;
			$this->stipend->PlaceHolder = ew_HtmlEncode(ew_RemoveHtml($this->stipend->FldCaption()));

			// alt_beneficiary
			$this->alt_beneficiary->EditCustomAttributes = "";
			$this->alt_beneficiary->EditValue = ew_HtmlEncode($this->alt_beneficiary->CurrentValue);
			$this->alt_beneficiary->PlaceHolder = ew_HtmlEncode(ew_RemoveHtml($this->alt_beneficiary->FldCaption()));

			// datecreated
			$this->datecreated->EditCustomAttributes = "";
			$this->datecreated->EditValue = ew_HtmlEncode($this->datecreated->CurrentValue);
			$this->datecreated->PlaceHolder = ew_HtmlEncode(ew_RemoveHtml($this->datecreated->FldCaption()));

			// passport
			$this->passport->EditCustomAttributes = "";
			$this->passport->EditValue = ew_HtmlEncode($this->passport->CurrentValue);
			$this->passport->PlaceHolder = ew_HtmlEncode(ew_RemoveHtml($this->passport->FldCaption()));

			// Edit refer script
			// id

			$this->id->HrefValue = "";

			// uid
			$this->uid->HrefValue = "";

			// name
			$this->name->HrefValue = "";

			// gender
			$this->gender->HrefValue = "";

			// dob
			$this->dob->HrefValue = "";

			// age
			$this->age->HrefValue = "";

			// title
			$this->title->HrefValue = "";

			// guardianname
			$this->guardianname->HrefValue = "";

			// rtionship
			$this->rtionship->HrefValue = "";

			// email
			$this->_email->HrefValue = "";

			// phone
			$this->phone->HrefValue = "";

			// addr
			$this->addr->HrefValue = "";

			// city
			$this->city->HrefValue = "";

			// state
			$this->state->HrefValue = "";

			// stipend
			$this->stipend->HrefValue = "";

			// alt_beneficiary
			$this->alt_beneficiary->HrefValue = "";

			// datecreated
			$this->datecreated->HrefValue = "";

			// passport
			$this->passport->HrefValue = "";
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
		if (in_array("beneficiary_dump", $DetailTblVar) && $GLOBALS["beneficiary_dump"]->DetailEdit) {
			if (!isset($GLOBALS["beneficiary_dump_grid"])) $GLOBALS["beneficiary_dump_grid"] = new cbeneficiary_dump_grid(); // get detail page object
			$GLOBALS["beneficiary_dump_grid"]->ValidateGridForm();
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

			// Begin transaction
			if ($this->getCurrentDetailTable() <> "")
				$conn->BeginTrans();

			// Save old values
			$rsold = &$rs->fields;
			$this->LoadDbValues($rsold);
			$rsnew = array();

			// uid
			$this->uid->SetDbValueDef($rsnew, $this->uid->CurrentValue, NULL, $this->uid->ReadOnly);

			// name
			$this->name->SetDbValueDef($rsnew, $this->name->CurrentValue, NULL, $this->name->ReadOnly);

			// gender
			$this->gender->SetDbValueDef($rsnew, $this->gender->CurrentValue, NULL, $this->gender->ReadOnly);

			// dob
			$this->dob->SetDbValueDef($rsnew, $this->dob->CurrentValue, NULL, $this->dob->ReadOnly);

			// age
			$this->age->SetDbValueDef($rsnew, $this->age->CurrentValue, NULL, $this->age->ReadOnly);

			// title
			$this->title->SetDbValueDef($rsnew, $this->title->CurrentValue, NULL, $this->title->ReadOnly);

			// guardianname
			$this->guardianname->SetDbValueDef($rsnew, $this->guardianname->CurrentValue, NULL, $this->guardianname->ReadOnly);

			// rtionship
			$this->rtionship->SetDbValueDef($rsnew, $this->rtionship->CurrentValue, NULL, $this->rtionship->ReadOnly);

			// email
			$this->_email->SetDbValueDef($rsnew, $this->_email->CurrentValue, NULL, $this->_email->ReadOnly);

			// phone
			$this->phone->SetDbValueDef($rsnew, $this->phone->CurrentValue, NULL, $this->phone->ReadOnly);

			// addr
			$this->addr->SetDbValueDef($rsnew, $this->addr->CurrentValue, NULL, $this->addr->ReadOnly);

			// city
			$this->city->SetDbValueDef($rsnew, $this->city->CurrentValue, NULL, $this->city->ReadOnly);

			// state
			$this->state->SetDbValueDef($rsnew, $this->state->CurrentValue, NULL, $this->state->ReadOnly);

			// stipend
			$this->stipend->SetDbValueDef($rsnew, $this->stipend->CurrentValue, NULL, $this->stipend->ReadOnly);

			// alt_beneficiary
			$this->alt_beneficiary->SetDbValueDef($rsnew, $this->alt_beneficiary->CurrentValue, NULL, $this->alt_beneficiary->ReadOnly);

			// datecreated
			$this->datecreated->SetDbValueDef($rsnew, $this->datecreated->CurrentValue, NULL, $this->datecreated->ReadOnly);

			// passport
			$this->passport->SetDbValueDef($rsnew, $this->passport->CurrentValue, NULL, $this->passport->ReadOnly);

			// Check referential integrity for master table 'personal_info'
			$bValidMasterRecord = TRUE;
			$sMasterFilter = $this->SqlMasterFilter_personal_info();
			$KeyValue = isset($rsnew['uid']) ? $rsnew['uid'] : $rsold['uid'];
			if (strval($KeyValue) <> "") {
				$sMasterFilter = str_replace("@uid@", ew_AdjustSql($KeyValue), $sMasterFilter);
			} else {
				$bValidMasterRecord = FALSE;
			}
			if ($bValidMasterRecord) {
				$rsmaster = $GLOBALS["personal_info"]->LoadRs($sMasterFilter);
				$bValidMasterRecord = ($rsmaster && !$rsmaster->EOF);
				$rsmaster->Close();
			}
			if (!$bValidMasterRecord) {
				$sRelatedRecordMsg = str_replace("%t", "personal_info", $Language->Phrase("RelatedRecordRequired"));
				$this->setFailureMessage($sRelatedRecordMsg);
				$rs->Close();
				return FALSE;
			}

			// Check referential integrity for master table 'spouse_tb'
			$bValidMasterRecord = TRUE;
			$sMasterFilter = $this->SqlMasterFilter_spouse_tb();
			$KeyValue = isset($rsnew['uid']) ? $rsnew['uid'] : $rsold['uid'];
			if (strval($KeyValue) <> "") {
				$sMasterFilter = str_replace("@uid@", ew_AdjustSql($KeyValue), $sMasterFilter);
			} else {
				$bValidMasterRecord = FALSE;
			}
			if ($bValidMasterRecord) {
				$rsmaster = $GLOBALS["spouse_tb"]->LoadRs($sMasterFilter);
				$bValidMasterRecord = ($rsmaster && !$rsmaster->EOF);
				$rsmaster->Close();
			}
			if (!$bValidMasterRecord) {
				$sRelatedRecordMsg = str_replace("%t", "spouse_tb", $Language->Phrase("RelatedRecordRequired"));
				$this->setFailureMessage($sRelatedRecordMsg);
				$rs->Close();
				return FALSE;
			}

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

				// Update detail records
				if ($EditRow) {
					$DetailTblVar = explode(",", $this->getCurrentDetailTable());
					if (in_array("beneficiary_dump", $DetailTblVar) && $GLOBALS["beneficiary_dump"]->DetailEdit) {
						if (!isset($GLOBALS["beneficiary_dump_grid"])) $GLOBALS["beneficiary_dump_grid"] = new cbeneficiary_dump_grid(); // Get detail page object
						$EditRow = $GLOBALS["beneficiary_dump_grid"]->GridUpdate();
					}
				}

				// Commit/Rollback transaction
				if ($this->getCurrentDetailTable() <> "") {
					if ($EditRow) {
						$conn->CommitTrans(); // Commit transaction
					} else {
						$conn->RollbackTrans(); // Rollback transaction
					}
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
			if ($sMasterTblVar == "spouse_tb") {
				$bValidMaster = TRUE;
				if (@$_GET["uid"] <> "") {
					$GLOBALS["spouse_tb"]->uid->setQueryStringValue($_GET["uid"]);
					$this->uid->setQueryStringValue($GLOBALS["spouse_tb"]->uid->QueryStringValue);
					$this->uid->setSessionValue($this->uid->QueryStringValue);
					if (!is_numeric($GLOBALS["spouse_tb"]->uid->QueryStringValue)) $bValidMaster = FALSE;
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
			if ($sMasterTblVar <> "personal_info") {
				if ($this->uid->QueryStringValue == "") $this->uid->setSessionValue("");
			}
			if ($sMasterTblVar <> "spouse_tb") {
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
			if (in_array("beneficiary_dump", $DetailTblVar)) {
				if (!isset($GLOBALS["beneficiary_dump_grid"]))
					$GLOBALS["beneficiary_dump_grid"] = new cbeneficiary_dump_grid;
				if ($GLOBALS["beneficiary_dump_grid"]->DetailEdit) {
					$GLOBALS["beneficiary_dump_grid"]->CurrentMode = "edit";
					$GLOBALS["beneficiary_dump_grid"]->CurrentAction = "gridedit";

					// Save current master table to detail table
					$GLOBALS["beneficiary_dump_grid"]->setCurrentMasterTable($this->TableVar);
					$GLOBALS["beneficiary_dump_grid"]->setStartRecordNumber(1);
					$GLOBALS["beneficiary_dump_grid"]->uid->FldIsDetailKey = TRUE;
					$GLOBALS["beneficiary_dump_grid"]->uid->CurrentValue = $this->uid->CurrentValue;
					$GLOBALS["beneficiary_dump_grid"]->uid->setSessionValue($GLOBALS["beneficiary_dump_grid"]->uid->CurrentValue);
				}
			}
		}
	}

	// Set up Breadcrumb
	function SetupBreadcrumb() {
		global $Breadcrumb, $Language;
		$Breadcrumb = new cBreadcrumb();
		$PageCaption = $this->TableCaption();
		$Breadcrumb->Add("list", "<span id=\"ewPageCaption\">" . $PageCaption . "</span>", "children_detailslist.php", $this->TableVar);
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
if (!isset($children_details_edit)) $children_details_edit = new cchildren_details_edit();

// Page init
$children_details_edit->Page_Init();

// Page main
$children_details_edit->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$children_details_edit->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Page object
var children_details_edit = new ew_Page("children_details_edit");
children_details_edit.PageID = "edit"; // Page ID
var EW_PAGE_ID = children_details_edit.PageID; // For backward compatibility

// Form object
var fchildren_detailsedit = new ew_Form("fchildren_detailsedit");

// Validate form
fchildren_detailsedit.Validate = function() {
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
				return this.OnError(elm, "<?php echo ew_JsEncode2($children_details->uid->FldErrMsg()) ?>");

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
fchildren_detailsedit.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
fchildren_detailsedit.ValidateRequired = true;
<?php } else { ?>
fchildren_detailsedit.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
// Form object for search

</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<?php $Breadcrumb->Render(); ?>
<?php $children_details_edit->ShowPageHeader(); ?>
<?php
$children_details_edit->ShowMessage();
?>
<form name="fchildren_detailsedit" id="fchildren_detailsedit" class="ewForm form-horizontal" action="<?php echo ew_CurrentPage() ?>" method="post">
<input type="hidden" name="t" value="children_details">
<input type="hidden" name="a_edit" id="a_edit" value="U">
<table cellspacing="0" class="ewGrid"><tr><td>
<table id="tbl_children_detailsedit" class="table table-bordered table-striped">
<?php if ($children_details->id->Visible) { // id ?>
	<tr id="r_id">
		<td><span id="elh_children_details_id"><?php echo $children_details->id->FldCaption() ?></span></td>
		<td<?php echo $children_details->id->CellAttributes() ?>>
<span id="el_children_details_id" class="control-group">
<span<?php echo $children_details->id->ViewAttributes() ?>>
<?php echo $children_details->id->EditValue ?></span>
</span>
<input type="hidden" data-field="x_id" name="x_id" id="x_id" value="<?php echo ew_HtmlEncode($children_details->id->CurrentValue) ?>">
<?php echo $children_details->id->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($children_details->uid->Visible) { // uid ?>
	<tr id="r_uid">
		<td><span id="elh_children_details_uid"><?php echo $children_details->uid->FldCaption() ?></span></td>
		<td<?php echo $children_details->uid->CellAttributes() ?>>
<?php if ($children_details->uid->getSessionValue() <> "") { ?>
<span<?php echo $children_details->uid->ViewAttributes() ?>>
<?php echo $children_details->uid->ViewValue ?></span>
<input type="hidden" id="x_uid" name="x_uid" value="<?php echo ew_HtmlEncode($children_details->uid->CurrentValue) ?>">
<?php } else { ?>
<input type="text" data-field="x_uid" name="x_uid" id="x_uid" size="30" placeholder="<?php echo $children_details->uid->PlaceHolder ?>" value="<?php echo $children_details->uid->EditValue ?>"<?php echo $children_details->uid->EditAttributes() ?>>
<?php } ?>
<?php echo $children_details->uid->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($children_details->name->Visible) { // name ?>
	<tr id="r_name">
		<td><span id="elh_children_details_name"><?php echo $children_details->name->FldCaption() ?></span></td>
		<td<?php echo $children_details->name->CellAttributes() ?>>
<span id="el_children_details_name" class="control-group">
<input type="text" data-field="x_name" name="x_name" id="x_name" size="30" maxlength="100" placeholder="<?php echo $children_details->name->PlaceHolder ?>" value="<?php echo $children_details->name->EditValue ?>"<?php echo $children_details->name->EditAttributes() ?>>
</span>
<?php echo $children_details->name->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($children_details->gender->Visible) { // gender ?>
	<tr id="r_gender">
		<td><span id="elh_children_details_gender"><?php echo $children_details->gender->FldCaption() ?></span></td>
		<td<?php echo $children_details->gender->CellAttributes() ?>>
<span id="el_children_details_gender" class="control-group">
<input type="text" data-field="x_gender" name="x_gender" id="x_gender" size="30" maxlength="10" placeholder="<?php echo $children_details->gender->PlaceHolder ?>" value="<?php echo $children_details->gender->EditValue ?>"<?php echo $children_details->gender->EditAttributes() ?>>
</span>
<?php echo $children_details->gender->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($children_details->dob->Visible) { // dob ?>
	<tr id="r_dob">
		<td><span id="elh_children_details_dob"><?php echo $children_details->dob->FldCaption() ?></span></td>
		<td<?php echo $children_details->dob->CellAttributes() ?>>
<span id="el_children_details_dob" class="control-group">
<input type="text" data-field="x_dob" name="x_dob" id="x_dob" size="30" maxlength="20" placeholder="<?php echo $children_details->dob->PlaceHolder ?>" value="<?php echo $children_details->dob->EditValue ?>"<?php echo $children_details->dob->EditAttributes() ?>>
</span>
<?php echo $children_details->dob->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($children_details->age->Visible) { // age ?>
	<tr id="r_age">
		<td><span id="elh_children_details_age"><?php echo $children_details->age->FldCaption() ?></span></td>
		<td<?php echo $children_details->age->CellAttributes() ?>>
<span id="el_children_details_age" class="control-group">
<input type="text" data-field="x_age" name="x_age" id="x_age" size="30" maxlength="5" placeholder="<?php echo $children_details->age->PlaceHolder ?>" value="<?php echo $children_details->age->EditValue ?>"<?php echo $children_details->age->EditAttributes() ?>>
</span>
<?php echo $children_details->age->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($children_details->title->Visible) { // title ?>
	<tr id="r_title">
		<td><span id="elh_children_details_title"><?php echo $children_details->title->FldCaption() ?></span></td>
		<td<?php echo $children_details->title->CellAttributes() ?>>
<span id="el_children_details_title" class="control-group">
<input type="text" data-field="x_title" name="x_title" id="x_title" size="30" maxlength="10" placeholder="<?php echo $children_details->title->PlaceHolder ?>" value="<?php echo $children_details->title->EditValue ?>"<?php echo $children_details->title->EditAttributes() ?>>
</span>
<?php echo $children_details->title->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($children_details->guardianname->Visible) { // guardianname ?>
	<tr id="r_guardianname">
		<td><span id="elh_children_details_guardianname"><?php echo $children_details->guardianname->FldCaption() ?></span></td>
		<td<?php echo $children_details->guardianname->CellAttributes() ?>>
<span id="el_children_details_guardianname" class="control-group">
<input type="text" data-field="x_guardianname" name="x_guardianname" id="x_guardianname" size="30" maxlength="50" placeholder="<?php echo $children_details->guardianname->PlaceHolder ?>" value="<?php echo $children_details->guardianname->EditValue ?>"<?php echo $children_details->guardianname->EditAttributes() ?>>
</span>
<?php echo $children_details->guardianname->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($children_details->rtionship->Visible) { // rtionship ?>
	<tr id="r_rtionship">
		<td><span id="elh_children_details_rtionship"><?php echo $children_details->rtionship->FldCaption() ?></span></td>
		<td<?php echo $children_details->rtionship->CellAttributes() ?>>
<span id="el_children_details_rtionship" class="control-group">
<input type="text" data-field="x_rtionship" name="x_rtionship" id="x_rtionship" size="30" maxlength="20" placeholder="<?php echo $children_details->rtionship->PlaceHolder ?>" value="<?php echo $children_details->rtionship->EditValue ?>"<?php echo $children_details->rtionship->EditAttributes() ?>>
</span>
<?php echo $children_details->rtionship->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($children_details->_email->Visible) { // email ?>
	<tr id="r__email">
		<td><span id="elh_children_details__email"><?php echo $children_details->_email->FldCaption() ?></span></td>
		<td<?php echo $children_details->_email->CellAttributes() ?>>
<span id="el_children_details__email" class="control-group">
<input type="text" data-field="x__email" name="x__email" id="x__email" size="30" maxlength="50" placeholder="<?php echo $children_details->_email->PlaceHolder ?>" value="<?php echo $children_details->_email->EditValue ?>"<?php echo $children_details->_email->EditAttributes() ?>>
</span>
<?php echo $children_details->_email->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($children_details->phone->Visible) { // phone ?>
	<tr id="r_phone">
		<td><span id="elh_children_details_phone"><?php echo $children_details->phone->FldCaption() ?></span></td>
		<td<?php echo $children_details->phone->CellAttributes() ?>>
<span id="el_children_details_phone" class="control-group">
<input type="text" data-field="x_phone" name="x_phone" id="x_phone" size="30" maxlength="20" placeholder="<?php echo $children_details->phone->PlaceHolder ?>" value="<?php echo $children_details->phone->EditValue ?>"<?php echo $children_details->phone->EditAttributes() ?>>
</span>
<?php echo $children_details->phone->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($children_details->addr->Visible) { // addr ?>
	<tr id="r_addr">
		<td><span id="elh_children_details_addr"><?php echo $children_details->addr->FldCaption() ?></span></td>
		<td<?php echo $children_details->addr->CellAttributes() ?>>
<span id="el_children_details_addr" class="control-group">
<textarea data-field="x_addr" name="x_addr" id="x_addr" cols="35" rows="4" placeholder="<?php echo $children_details->addr->PlaceHolder ?>"<?php echo $children_details->addr->EditAttributes() ?>><?php echo $children_details->addr->EditValue ?></textarea>
</span>
<?php echo $children_details->addr->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($children_details->city->Visible) { // city ?>
	<tr id="r_city">
		<td><span id="elh_children_details_city"><?php echo $children_details->city->FldCaption() ?></span></td>
		<td<?php echo $children_details->city->CellAttributes() ?>>
<span id="el_children_details_city" class="control-group">
<input type="text" data-field="x_city" name="x_city" id="x_city" size="30" maxlength="50" placeholder="<?php echo $children_details->city->PlaceHolder ?>" value="<?php echo $children_details->city->EditValue ?>"<?php echo $children_details->city->EditAttributes() ?>>
</span>
<?php echo $children_details->city->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($children_details->state->Visible) { // state ?>
	<tr id="r_state">
		<td><span id="elh_children_details_state"><?php echo $children_details->state->FldCaption() ?></span></td>
		<td<?php echo $children_details->state->CellAttributes() ?>>
<span id="el_children_details_state" class="control-group">
<input type="text" data-field="x_state" name="x_state" id="x_state" size="30" maxlength="50" placeholder="<?php echo $children_details->state->PlaceHolder ?>" value="<?php echo $children_details->state->EditValue ?>"<?php echo $children_details->state->EditAttributes() ?>>
</span>
<?php echo $children_details->state->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($children_details->stipend->Visible) { // stipend ?>
	<tr id="r_stipend">
		<td><span id="elh_children_details_stipend"><?php echo $children_details->stipend->FldCaption() ?></span></td>
		<td<?php echo $children_details->stipend->CellAttributes() ?>>
<span id="el_children_details_stipend" class="control-group">
<textarea data-field="x_stipend" name="x_stipend" id="x_stipend" cols="35" rows="4" placeholder="<?php echo $children_details->stipend->PlaceHolder ?>"<?php echo $children_details->stipend->EditAttributes() ?>><?php echo $children_details->stipend->EditValue ?></textarea>
</span>
<?php echo $children_details->stipend->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($children_details->alt_beneficiary->Visible) { // alt_beneficiary ?>
	<tr id="r_alt_beneficiary">
		<td><span id="elh_children_details_alt_beneficiary"><?php echo $children_details->alt_beneficiary->FldCaption() ?></span></td>
		<td<?php echo $children_details->alt_beneficiary->CellAttributes() ?>>
<span id="el_children_details_alt_beneficiary" class="control-group">
<input type="text" data-field="x_alt_beneficiary" name="x_alt_beneficiary" id="x_alt_beneficiary" size="30" maxlength="5" placeholder="<?php echo $children_details->alt_beneficiary->PlaceHolder ?>" value="<?php echo $children_details->alt_beneficiary->EditValue ?>"<?php echo $children_details->alt_beneficiary->EditAttributes() ?>>
</span>
<?php echo $children_details->alt_beneficiary->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($children_details->datecreated->Visible) { // datecreated ?>
	<tr id="r_datecreated">
		<td><span id="elh_children_details_datecreated"><?php echo $children_details->datecreated->FldCaption() ?></span></td>
		<td<?php echo $children_details->datecreated->CellAttributes() ?>>
<span id="el_children_details_datecreated" class="control-group">
<input type="text" data-field="x_datecreated" name="x_datecreated" id="x_datecreated" placeholder="<?php echo $children_details->datecreated->PlaceHolder ?>" value="<?php echo $children_details->datecreated->EditValue ?>"<?php echo $children_details->datecreated->EditAttributes() ?>>
</span>
<?php echo $children_details->datecreated->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($children_details->passport->Visible) { // passport ?>
	<tr id="r_passport">
		<td><span id="elh_children_details_passport"><?php echo $children_details->passport->FldCaption() ?></span></td>
		<td<?php echo $children_details->passport->CellAttributes() ?>>
<span id="el_children_details_passport" class="control-group">
<input type="text" data-field="x_passport" name="x_passport" id="x_passport" size="30" maxlength="200" placeholder="<?php echo $children_details->passport->PlaceHolder ?>" value="<?php echo $children_details->passport->EditValue ?>"<?php echo $children_details->passport->EditAttributes() ?>>
</span>
<?php echo $children_details->passport->CustomMsg ?></td>
	</tr>
<?php } ?>
</table>
</td></tr></table>
<table class="ewPager">
<tr><td>
<?php if (!isset($children_details_edit->Pager)) $children_details_edit->Pager = new cNumericPager($children_details_edit->StartRec, $children_details_edit->DisplayRecs, $children_details_edit->TotalRecs, $children_details_edit->RecRange) ?>
<?php if ($children_details_edit->Pager->RecordCount > 0) { ?>
<table cellspacing="0" class="ewStdTable"><tbody><tr><td>
<div class="pagination"><ul>
	<?php if ($children_details_edit->Pager->FirstButton->Enabled) { ?>
	<li><a href="<?php echo $children_details_edit->PageUrl() ?>start=<?php echo $children_details_edit->Pager->FirstButton->Start ?>"><?php echo $Language->Phrase("PagerFirst") ?></a></li>
	<?php } ?>
	<?php if ($children_details_edit->Pager->PrevButton->Enabled) { ?>
	<li><a href="<?php echo $children_details_edit->PageUrl() ?>start=<?php echo $children_details_edit->Pager->PrevButton->Start ?>"><?php echo $Language->Phrase("PagerPrevious") ?></a></li>
	<?php } ?>
	<?php foreach ($children_details_edit->Pager->Items as $PagerItem) { ?>
		<li<?php if (!$PagerItem->Enabled) { echo " class=\" active\""; } ?>><a href="<?php if ($PagerItem->Enabled) { echo $children_details_edit->PageUrl() . "start=" . $PagerItem->Start; } else { echo "#"; } ?>"><?php echo $PagerItem->Text ?></a></li>
	<?php } ?>
	<?php if ($children_details_edit->Pager->NextButton->Enabled) { ?>
	<li><a href="<?php echo $children_details_edit->PageUrl() ?>start=<?php echo $children_details_edit->Pager->NextButton->Start ?>"><?php echo $Language->Phrase("PagerNext") ?></a></li>
	<?php } ?>
	<?php if ($children_details_edit->Pager->LastButton->Enabled) { ?>
	<li><a href="<?php echo $children_details_edit->PageUrl() ?>start=<?php echo $children_details_edit->Pager->LastButton->Start ?>"><?php echo $Language->Phrase("PagerLast") ?></a></li>
	<?php } ?>
</ul></div>
</td>
</tr></tbody></table>
<?php } else { ?>
	<p><?php echo $Language->Phrase("NoRecord") ?></p>
<?php } ?>
</td>
</tr></table>
<?php
	if (in_array("beneficiary_dump", explode(",", $children_details->getCurrentDetailTable())) && $beneficiary_dump->DetailEdit) {
?>
<?php include_once "beneficiary_dumpgrid.php" ?>
<?php } ?>
<button class="btn btn-primary ewButton" name="btnAction" id="btnAction" type="submit"><?php echo $Language->Phrase("EditBtn") ?></button>
</form>
<script type="text/javascript">
fchildren_detailsedit.Init();
<?php if (EW_MOBILE_REFLOW && ew_IsMobile()) { ?>
ew_Reflow();
<?php } ?>
</script>
<?php
$children_details_edit->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$children_details_edit->Page_Terminate();
?>
