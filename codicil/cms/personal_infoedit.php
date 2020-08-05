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

$personal_info_edit = NULL; // Initialize page object first

class cpersonal_info_edit extends cpersonal_info {

	// Page ID
	var $PageID = 'edit';

	// Project ID
	var $ProjectID = "{D9B361E7-B2C1-4293-B9B3-B581986A15CC}";

	// Table name
	var $TableName = 'personal_info';

	// Page object name
	var $PageObjName = 'personal_info_edit';

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
			define("EW_PAGE_ID", 'edit', TRUE);

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
			$this->Page_Terminate("personal_infolist.php"); // Return to list page
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
					$this->Page_Terminate("personal_infolist.php"); // Return to list page
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
					if (ew_GetPageName($sReturnUrl) == "personal_infoview.php")
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
		if (!$this->salutation->FldIsDetailKey) {
			$this->salutation->setFormValue($objForm->GetValue("x_salutation"));
		}
		if (!$this->fname->FldIsDetailKey) {
			$this->fname->setFormValue($objForm->GetValue("x_fname"));
		}
		if (!$this->mname->FldIsDetailKey) {
			$this->mname->setFormValue($objForm->GetValue("x_mname"));
		}
		if (!$this->lname->FldIsDetailKey) {
			$this->lname->setFormValue($objForm->GetValue("x_lname"));
		}
		if (!$this->dob->FldIsDetailKey) {
			$this->dob->setFormValue($objForm->GetValue("x_dob"));
		}
		if (!$this->gender->FldIsDetailKey) {
			$this->gender->setFormValue($objForm->GetValue("x_gender"));
		}
		if (!$this->nationality->FldIsDetailKey) {
			$this->nationality->setFormValue($objForm->GetValue("x_nationality"));
		}
		if (!$this->state->FldIsDetailKey) {
			$this->state->setFormValue($objForm->GetValue("x_state"));
		}
		if (!$this->lga->FldIsDetailKey) {
			$this->lga->setFormValue($objForm->GetValue("x_lga"));
		}
		if (!$this->phone->FldIsDetailKey) {
			$this->phone->setFormValue($objForm->GetValue("x_phone"));
		}
		if (!$this->aphone->FldIsDetailKey) {
			$this->aphone->setFormValue($objForm->GetValue("x_aphone"));
		}
		if (!$this->msg->FldIsDetailKey) {
			$this->msg->setFormValue($objForm->GetValue("x_msg"));
		}
		if (!$this->city->FldIsDetailKey) {
			$this->city->setFormValue($objForm->GetValue("x_city"));
		}
		if (!$this->rstate->FldIsDetailKey) {
			$this->rstate->setFormValue($objForm->GetValue("x_rstate"));
		}
		if (!$this->reg_status->FldIsDetailKey) {
			$this->reg_status->setFormValue($objForm->GetValue("x_reg_status"));
		}
		if (!$this->employment_status->FldIsDetailKey) {
			$this->employment_status->setFormValue($objForm->GetValue("x_employment_status"));
		}
		if (!$this->datecreated->FldIsDetailKey) {
			$this->datecreated->setFormValue($objForm->GetValue("x_datecreated"));
			$this->datecreated->CurrentValue = ew_UnFormatDateTime($this->datecreated->CurrentValue, 0);
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
	}

	// Restore form values
	function RestoreFormValues() {
		global $objForm;
		$this->LoadRow();
		$this->id->CurrentValue = $this->id->FormValue;
		$this->uid->CurrentValue = $this->uid->FormValue;
		$this->salutation->CurrentValue = $this->salutation->FormValue;
		$this->fname->CurrentValue = $this->fname->FormValue;
		$this->mname->CurrentValue = $this->mname->FormValue;
		$this->lname->CurrentValue = $this->lname->FormValue;
		$this->dob->CurrentValue = $this->dob->FormValue;
		$this->gender->CurrentValue = $this->gender->FormValue;
		$this->nationality->CurrentValue = $this->nationality->FormValue;
		$this->state->CurrentValue = $this->state->FormValue;
		$this->lga->CurrentValue = $this->lga->FormValue;
		$this->phone->CurrentValue = $this->phone->FormValue;
		$this->aphone->CurrentValue = $this->aphone->FormValue;
		$this->msg->CurrentValue = $this->msg->FormValue;
		$this->city->CurrentValue = $this->city->FormValue;
		$this->rstate->CurrentValue = $this->rstate->FormValue;
		$this->reg_status->CurrentValue = $this->reg_status->FormValue;
		$this->employment_status->CurrentValue = $this->employment_status->FormValue;
		$this->datecreated->CurrentValue = $this->datecreated->FormValue;
		$this->datecreated->CurrentValue = ew_UnFormatDateTime($this->datecreated->CurrentValue, 0);
		$this->employer->CurrentValue = $this->employer->FormValue;
		$this->employerphone->CurrentValue = $this->employerphone->FormValue;
		$this->employeraddr->CurrentValue = $this->employeraddr->FormValue;
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

			// msg
			$this->msg->ViewValue = $this->msg->CurrentValue;
			$this->msg->ViewCustomAttributes = "";

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

			// employer
			$this->employer->ViewValue = $this->employer->CurrentValue;
			$this->employer->ViewCustomAttributes = "";

			// employerphone
			$this->employerphone->ViewValue = $this->employerphone->CurrentValue;
			$this->employerphone->ViewCustomAttributes = "";

			// employeraddr
			$this->employeraddr->ViewValue = $this->employeraddr->CurrentValue;
			$this->employeraddr->ViewCustomAttributes = "";

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

			// msg
			$this->msg->LinkCustomAttributes = "";
			$this->msg->HrefValue = "";
			$this->msg->TooltipValue = "";

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

			// salutation
			$this->salutation->EditCustomAttributes = "";
			$this->salutation->EditValue = ew_HtmlEncode($this->salutation->CurrentValue);
			$this->salutation->PlaceHolder = ew_HtmlEncode(ew_RemoveHtml($this->salutation->FldCaption()));

			// fname
			$this->fname->EditCustomAttributes = "";
			$this->fname->EditValue = ew_HtmlEncode($this->fname->CurrentValue);
			$this->fname->PlaceHolder = ew_HtmlEncode(ew_RemoveHtml($this->fname->FldCaption()));

			// mname
			$this->mname->EditCustomAttributes = "";
			$this->mname->EditValue = ew_HtmlEncode($this->mname->CurrentValue);
			$this->mname->PlaceHolder = ew_HtmlEncode(ew_RemoveHtml($this->mname->FldCaption()));

			// lname
			$this->lname->EditCustomAttributes = "";
			$this->lname->EditValue = ew_HtmlEncode($this->lname->CurrentValue);
			$this->lname->PlaceHolder = ew_HtmlEncode(ew_RemoveHtml($this->lname->FldCaption()));

			// dob
			$this->dob->EditCustomAttributes = "";
			$this->dob->EditValue = ew_HtmlEncode($this->dob->CurrentValue);
			$this->dob->PlaceHolder = ew_HtmlEncode(ew_RemoveHtml($this->dob->FldCaption()));

			// gender
			$this->gender->EditCustomAttributes = "";
			$this->gender->EditValue = ew_HtmlEncode($this->gender->CurrentValue);
			$this->gender->PlaceHolder = ew_HtmlEncode(ew_RemoveHtml($this->gender->FldCaption()));

			// nationality
			$this->nationality->EditCustomAttributes = "";
			$this->nationality->EditValue = ew_HtmlEncode($this->nationality->CurrentValue);
			$this->nationality->PlaceHolder = ew_HtmlEncode(ew_RemoveHtml($this->nationality->FldCaption()));

			// state
			$this->state->EditCustomAttributes = "";
			$this->state->EditValue = ew_HtmlEncode($this->state->CurrentValue);
			$this->state->PlaceHolder = ew_HtmlEncode(ew_RemoveHtml($this->state->FldCaption()));

			// lga
			$this->lga->EditCustomAttributes = "";
			$this->lga->EditValue = ew_HtmlEncode($this->lga->CurrentValue);
			$this->lga->PlaceHolder = ew_HtmlEncode(ew_RemoveHtml($this->lga->FldCaption()));

			// phone
			$this->phone->EditCustomAttributes = "";
			$this->phone->EditValue = ew_HtmlEncode($this->phone->CurrentValue);
			$this->phone->PlaceHolder = ew_HtmlEncode(ew_RemoveHtml($this->phone->FldCaption()));

			// aphone
			$this->aphone->EditCustomAttributes = "";
			$this->aphone->EditValue = ew_HtmlEncode($this->aphone->CurrentValue);
			$this->aphone->PlaceHolder = ew_HtmlEncode(ew_RemoveHtml($this->aphone->FldCaption()));

			// msg
			$this->msg->EditCustomAttributes = "";
			$this->msg->EditValue = $this->msg->CurrentValue;
			$this->msg->PlaceHolder = ew_HtmlEncode(ew_RemoveHtml($this->msg->FldCaption()));

			// city
			$this->city->EditCustomAttributes = "";
			$this->city->EditValue = ew_HtmlEncode($this->city->CurrentValue);
			$this->city->PlaceHolder = ew_HtmlEncode(ew_RemoveHtml($this->city->FldCaption()));

			// rstate
			$this->rstate->EditCustomAttributes = "";
			$this->rstate->EditValue = ew_HtmlEncode($this->rstate->CurrentValue);
			$this->rstate->PlaceHolder = ew_HtmlEncode(ew_RemoveHtml($this->rstate->FldCaption()));

			// reg_status
			$this->reg_status->EditCustomAttributes = "";
			$this->reg_status->EditValue = ew_HtmlEncode($this->reg_status->CurrentValue);
			$this->reg_status->PlaceHolder = ew_HtmlEncode(ew_RemoveHtml($this->reg_status->FldCaption()));

			// employment_status
			$this->employment_status->EditCustomAttributes = "";
			$this->employment_status->EditValue = ew_HtmlEncode($this->employment_status->CurrentValue);
			$this->employment_status->PlaceHolder = ew_HtmlEncode(ew_RemoveHtml($this->employment_status->FldCaption()));

			// datecreated
			$this->datecreated->EditCustomAttributes = "";
			$this->datecreated->EditValue = ew_HtmlEncode($this->datecreated->CurrentValue);
			$this->datecreated->PlaceHolder = ew_HtmlEncode(ew_RemoveHtml($this->datecreated->FldCaption()));

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

			// Edit refer script
			// id

			$this->id->HrefValue = "";

			// uid
			$this->uid->HrefValue = "";

			// salutation
			$this->salutation->HrefValue = "";

			// fname
			$this->fname->HrefValue = "";

			// mname
			$this->mname->HrefValue = "";

			// lname
			$this->lname->HrefValue = "";

			// dob
			$this->dob->HrefValue = "";

			// gender
			$this->gender->HrefValue = "";

			// nationality
			$this->nationality->HrefValue = "";

			// state
			$this->state->HrefValue = "";

			// lga
			$this->lga->HrefValue = "";

			// phone
			$this->phone->HrefValue = "";

			// aphone
			$this->aphone->HrefValue = "";

			// msg
			$this->msg->HrefValue = "";

			// city
			$this->city->HrefValue = "";

			// rstate
			$this->rstate->HrefValue = "";

			// reg_status
			$this->reg_status->HrefValue = "";

			// employment_status
			$this->employment_status->HrefValue = "";

			// datecreated
			$this->datecreated->HrefValue = "";

			// employer
			$this->employer->HrefValue = "";

			// employerphone
			$this->employerphone->HrefValue = "";

			// employeraddr
			$this->employeraddr->HrefValue = "";
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
		if (!$this->salutation->FldIsDetailKey && !is_null($this->salutation->FormValue) && $this->salutation->FormValue == "") {
			ew_AddMessage($gsFormError, $Language->Phrase("EnterRequiredField") . " - " . $this->salutation->FldCaption());
		}
		if (!$this->reg_status->FldIsDetailKey && !is_null($this->reg_status->FormValue) && $this->reg_status->FormValue == "") {
			ew_AddMessage($gsFormError, $Language->Phrase("EnterRequiredField") . " - " . $this->reg_status->FldCaption());
		}
		if (!$this->datecreated->FldIsDetailKey && !is_null($this->datecreated->FormValue) && $this->datecreated->FormValue == "") {
			ew_AddMessage($gsFormError, $Language->Phrase("EnterRequiredField") . " - " . $this->datecreated->FldCaption());
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
			$this->uid->SetDbValueDef($rsnew, $this->uid->CurrentValue, 0, $this->uid->ReadOnly);

			// salutation
			$this->salutation->SetDbValueDef($rsnew, $this->salutation->CurrentValue, "", $this->salutation->ReadOnly);

			// fname
			$this->fname->SetDbValueDef($rsnew, $this->fname->CurrentValue, NULL, $this->fname->ReadOnly);

			// mname
			$this->mname->SetDbValueDef($rsnew, $this->mname->CurrentValue, NULL, $this->mname->ReadOnly);

			// lname
			$this->lname->SetDbValueDef($rsnew, $this->lname->CurrentValue, NULL, $this->lname->ReadOnly);

			// dob
			$this->dob->SetDbValueDef($rsnew, $this->dob->CurrentValue, NULL, $this->dob->ReadOnly);

			// gender
			$this->gender->SetDbValueDef($rsnew, $this->gender->CurrentValue, NULL, $this->gender->ReadOnly);

			// nationality
			$this->nationality->SetDbValueDef($rsnew, $this->nationality->CurrentValue, NULL, $this->nationality->ReadOnly);

			// state
			$this->state->SetDbValueDef($rsnew, $this->state->CurrentValue, NULL, $this->state->ReadOnly);

			// lga
			$this->lga->SetDbValueDef($rsnew, $this->lga->CurrentValue, NULL, $this->lga->ReadOnly);

			// phone
			$this->phone->SetDbValueDef($rsnew, $this->phone->CurrentValue, NULL, $this->phone->ReadOnly);

			// aphone
			$this->aphone->SetDbValueDef($rsnew, $this->aphone->CurrentValue, NULL, $this->aphone->ReadOnly);

			// msg
			$this->msg->SetDbValueDef($rsnew, $this->msg->CurrentValue, NULL, $this->msg->ReadOnly);

			// city
			$this->city->SetDbValueDef($rsnew, $this->city->CurrentValue, NULL, $this->city->ReadOnly);

			// rstate
			$this->rstate->SetDbValueDef($rsnew, $this->rstate->CurrentValue, NULL, $this->rstate->ReadOnly);

			// reg_status
			$this->reg_status->SetDbValueDef($rsnew, $this->reg_status->CurrentValue, "", $this->reg_status->ReadOnly);

			// employment_status
			$this->employment_status->SetDbValueDef($rsnew, $this->employment_status->CurrentValue, NULL, $this->employment_status->ReadOnly);

			// datecreated
			$this->datecreated->SetDbValueDef($rsnew, $this->datecreated->CurrentValue, ew_CurrentDate(), $this->datecreated->ReadOnly);

			// employer
			$this->employer->SetDbValueDef($rsnew, $this->employer->CurrentValue, NULL, $this->employer->ReadOnly);

			// employerphone
			$this->employerphone->SetDbValueDef($rsnew, $this->employerphone->CurrentValue, NULL, $this->employerphone->ReadOnly);

			// employeraddr
			$this->employeraddr->SetDbValueDef($rsnew, $this->employeraddr->CurrentValue, NULL, $this->employeraddr->ReadOnly);

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
			if ($sMasterTblVar == "preview_will") {
				$bValidMaster = TRUE;
				if (@$_GET["uid"] <> "") {
					$GLOBALS["preview_will"]->uid->setQueryStringValue($_GET["uid"]);
					$this->uid->setQueryStringValue($GLOBALS["preview_will"]->uid->QueryStringValue);
					$this->uid->setSessionValue($this->uid->QueryStringValue);
					if (!is_numeric($GLOBALS["preview_will"]->uid->QueryStringValue)) $bValidMaster = FALSE;
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
			if ($sMasterTblVar <> "preview_will") {
				if ($this->uid->QueryStringValue == "") $this->uid->setSessionValue("");
			}
		}
		$this->DbMasterFilter = $this->GetMasterFilter(); //  Get master filter
		$this->DbDetailFilter = $this->GetDetailFilter(); // Get detail filter
	}

	// Set up Breadcrumb
	function SetupBreadcrumb() {
		global $Breadcrumb, $Language;
		$Breadcrumb = new cBreadcrumb();
		$PageCaption = $this->TableCaption();
		$Breadcrumb->Add("list", "<span id=\"ewPageCaption\">" . $PageCaption . "</span>", "personal_infolist.php", $this->TableVar);
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
if (!isset($personal_info_edit)) $personal_info_edit = new cpersonal_info_edit();

// Page init
$personal_info_edit->Page_Init();

// Page main
$personal_info_edit->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$personal_info_edit->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Page object
var personal_info_edit = new ew_Page("personal_info_edit");
personal_info_edit.PageID = "edit"; // Page ID
var EW_PAGE_ID = personal_info_edit.PageID; // For backward compatibility

// Form object
var fpersonal_infoedit = new ew_Form("fpersonal_infoedit");

// Validate form
fpersonal_infoedit.Validate = function() {
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
				return this.OnError(elm, ewLanguage.Phrase("EnterRequiredField") + " - <?php echo ew_JsEncode2($personal_info->uid->FldCaption()) ?>");
			elm = this.GetElements("x" + infix + "_uid");
			if (elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($personal_info->uid->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_salutation");
			if (elm && !ew_HasValue(elm))
				return this.OnError(elm, ewLanguage.Phrase("EnterRequiredField") + " - <?php echo ew_JsEncode2($personal_info->salutation->FldCaption()) ?>");
			elm = this.GetElements("x" + infix + "_reg_status");
			if (elm && !ew_HasValue(elm))
				return this.OnError(elm, ewLanguage.Phrase("EnterRequiredField") + " - <?php echo ew_JsEncode2($personal_info->reg_status->FldCaption()) ?>");
			elm = this.GetElements("x" + infix + "_datecreated");
			if (elm && !ew_HasValue(elm))
				return this.OnError(elm, ewLanguage.Phrase("EnterRequiredField") + " - <?php echo ew_JsEncode2($personal_info->datecreated->FldCaption()) ?>");

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
fpersonal_infoedit.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
fpersonal_infoedit.ValidateRequired = true;
<?php } else { ?>
fpersonal_infoedit.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
// Form object for search

</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<?php $Breadcrumb->Render(); ?>
<?php $personal_info_edit->ShowPageHeader(); ?>
<?php
$personal_info_edit->ShowMessage();
?>
<form name="fpersonal_infoedit" id="fpersonal_infoedit" class="ewForm form-horizontal" action="<?php echo ew_CurrentPage() ?>" method="post">
<input type="hidden" name="t" value="personal_info">
<input type="hidden" name="a_edit" id="a_edit" value="U">
<table cellspacing="0" class="ewGrid"><tr><td>
<table id="tbl_personal_infoedit" class="table table-bordered table-striped">
<?php if ($personal_info->id->Visible) { // id ?>
	<tr id="r_id">
		<td><span id="elh_personal_info_id"><?php echo $personal_info->id->FldCaption() ?></span></td>
		<td<?php echo $personal_info->id->CellAttributes() ?>>
<span id="el_personal_info_id" class="control-group">
<span<?php echo $personal_info->id->ViewAttributes() ?>>
<?php echo $personal_info->id->EditValue ?></span>
</span>
<input type="hidden" data-field="x_id" name="x_id" id="x_id" value="<?php echo ew_HtmlEncode($personal_info->id->CurrentValue) ?>">
<?php echo $personal_info->id->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($personal_info->uid->Visible) { // uid ?>
	<tr id="r_uid">
		<td><span id="elh_personal_info_uid"><?php echo $personal_info->uid->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></span></td>
		<td<?php echo $personal_info->uid->CellAttributes() ?>>
<?php if ($personal_info->uid->getSessionValue() <> "") { ?>
<span<?php echo $personal_info->uid->ViewAttributes() ?>>
<?php echo $personal_info->uid->ViewValue ?></span>
<input type="hidden" id="x_uid" name="x_uid" value="<?php echo ew_HtmlEncode($personal_info->uid->CurrentValue) ?>">
<?php } else { ?>
<input type="text" data-field="x_uid" name="x_uid" id="x_uid" size="30" placeholder="<?php echo $personal_info->uid->PlaceHolder ?>" value="<?php echo $personal_info->uid->EditValue ?>"<?php echo $personal_info->uid->EditAttributes() ?>>
<?php } ?>
<?php echo $personal_info->uid->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($personal_info->salutation->Visible) { // salutation ?>
	<tr id="r_salutation">
		<td><span id="elh_personal_info_salutation"><?php echo $personal_info->salutation->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></span></td>
		<td<?php echo $personal_info->salutation->CellAttributes() ?>>
<span id="el_personal_info_salutation" class="control-group">
<input type="text" data-field="x_salutation" name="x_salutation" id="x_salutation" size="30" maxlength="20" placeholder="<?php echo $personal_info->salutation->PlaceHolder ?>" value="<?php echo $personal_info->salutation->EditValue ?>"<?php echo $personal_info->salutation->EditAttributes() ?>>
</span>
<?php echo $personal_info->salutation->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($personal_info->fname->Visible) { // fname ?>
	<tr id="r_fname">
		<td><span id="elh_personal_info_fname"><?php echo $personal_info->fname->FldCaption() ?></span></td>
		<td<?php echo $personal_info->fname->CellAttributes() ?>>
<span id="el_personal_info_fname" class="control-group">
<input type="text" data-field="x_fname" name="x_fname" id="x_fname" size="30" maxlength="50" placeholder="<?php echo $personal_info->fname->PlaceHolder ?>" value="<?php echo $personal_info->fname->EditValue ?>"<?php echo $personal_info->fname->EditAttributes() ?>>
</span>
<?php echo $personal_info->fname->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($personal_info->mname->Visible) { // mname ?>
	<tr id="r_mname">
		<td><span id="elh_personal_info_mname"><?php echo $personal_info->mname->FldCaption() ?></span></td>
		<td<?php echo $personal_info->mname->CellAttributes() ?>>
<span id="el_personal_info_mname" class="control-group">
<input type="text" data-field="x_mname" name="x_mname" id="x_mname" size="30" maxlength="50" placeholder="<?php echo $personal_info->mname->PlaceHolder ?>" value="<?php echo $personal_info->mname->EditValue ?>"<?php echo $personal_info->mname->EditAttributes() ?>>
</span>
<?php echo $personal_info->mname->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($personal_info->lname->Visible) { // lname ?>
	<tr id="r_lname">
		<td><span id="elh_personal_info_lname"><?php echo $personal_info->lname->FldCaption() ?></span></td>
		<td<?php echo $personal_info->lname->CellAttributes() ?>>
<span id="el_personal_info_lname" class="control-group">
<input type="text" data-field="x_lname" name="x_lname" id="x_lname" size="30" maxlength="50" placeholder="<?php echo $personal_info->lname->PlaceHolder ?>" value="<?php echo $personal_info->lname->EditValue ?>"<?php echo $personal_info->lname->EditAttributes() ?>>
</span>
<?php echo $personal_info->lname->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($personal_info->dob->Visible) { // dob ?>
	<tr id="r_dob">
		<td><span id="elh_personal_info_dob"><?php echo $personal_info->dob->FldCaption() ?></span></td>
		<td<?php echo $personal_info->dob->CellAttributes() ?>>
<span id="el_personal_info_dob" class="control-group">
<input type="text" data-field="x_dob" name="x_dob" id="x_dob" size="30" maxlength="15" placeholder="<?php echo $personal_info->dob->PlaceHolder ?>" value="<?php echo $personal_info->dob->EditValue ?>"<?php echo $personal_info->dob->EditAttributes() ?>>
</span>
<?php echo $personal_info->dob->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($personal_info->gender->Visible) { // gender ?>
	<tr id="r_gender">
		<td><span id="elh_personal_info_gender"><?php echo $personal_info->gender->FldCaption() ?></span></td>
		<td<?php echo $personal_info->gender->CellAttributes() ?>>
<span id="el_personal_info_gender" class="control-group">
<input type="text" data-field="x_gender" name="x_gender" id="x_gender" size="30" maxlength="10" placeholder="<?php echo $personal_info->gender->PlaceHolder ?>" value="<?php echo $personal_info->gender->EditValue ?>"<?php echo $personal_info->gender->EditAttributes() ?>>
</span>
<?php echo $personal_info->gender->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($personal_info->nationality->Visible) { // nationality ?>
	<tr id="r_nationality">
		<td><span id="elh_personal_info_nationality"><?php echo $personal_info->nationality->FldCaption() ?></span></td>
		<td<?php echo $personal_info->nationality->CellAttributes() ?>>
<span id="el_personal_info_nationality" class="control-group">
<input type="text" data-field="x_nationality" name="x_nationality" id="x_nationality" size="30" maxlength="20" placeholder="<?php echo $personal_info->nationality->PlaceHolder ?>" value="<?php echo $personal_info->nationality->EditValue ?>"<?php echo $personal_info->nationality->EditAttributes() ?>>
</span>
<?php echo $personal_info->nationality->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($personal_info->state->Visible) { // state ?>
	<tr id="r_state">
		<td><span id="elh_personal_info_state"><?php echo $personal_info->state->FldCaption() ?></span></td>
		<td<?php echo $personal_info->state->CellAttributes() ?>>
<span id="el_personal_info_state" class="control-group">
<input type="text" data-field="x_state" name="x_state" id="x_state" size="30" maxlength="20" placeholder="<?php echo $personal_info->state->PlaceHolder ?>" value="<?php echo $personal_info->state->EditValue ?>"<?php echo $personal_info->state->EditAttributes() ?>>
</span>
<?php echo $personal_info->state->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($personal_info->lga->Visible) { // lga ?>
	<tr id="r_lga">
		<td><span id="elh_personal_info_lga"><?php echo $personal_info->lga->FldCaption() ?></span></td>
		<td<?php echo $personal_info->lga->CellAttributes() ?>>
<span id="el_personal_info_lga" class="control-group">
<input type="text" data-field="x_lga" name="x_lga" id="x_lga" size="30" maxlength="100" placeholder="<?php echo $personal_info->lga->PlaceHolder ?>" value="<?php echo $personal_info->lga->EditValue ?>"<?php echo $personal_info->lga->EditAttributes() ?>>
</span>
<?php echo $personal_info->lga->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($personal_info->phone->Visible) { // phone ?>
	<tr id="r_phone">
		<td><span id="elh_personal_info_phone"><?php echo $personal_info->phone->FldCaption() ?></span></td>
		<td<?php echo $personal_info->phone->CellAttributes() ?>>
<span id="el_personal_info_phone" class="control-group">
<input type="text" data-field="x_phone" name="x_phone" id="x_phone" size="30" maxlength="15" placeholder="<?php echo $personal_info->phone->PlaceHolder ?>" value="<?php echo $personal_info->phone->EditValue ?>"<?php echo $personal_info->phone->EditAttributes() ?>>
</span>
<?php echo $personal_info->phone->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($personal_info->aphone->Visible) { // aphone ?>
	<tr id="r_aphone">
		<td><span id="elh_personal_info_aphone"><?php echo $personal_info->aphone->FldCaption() ?></span></td>
		<td<?php echo $personal_info->aphone->CellAttributes() ?>>
<span id="el_personal_info_aphone" class="control-group">
<input type="text" data-field="x_aphone" name="x_aphone" id="x_aphone" size="30" maxlength="15" placeholder="<?php echo $personal_info->aphone->PlaceHolder ?>" value="<?php echo $personal_info->aphone->EditValue ?>"<?php echo $personal_info->aphone->EditAttributes() ?>>
</span>
<?php echo $personal_info->aphone->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($personal_info->msg->Visible) { // msg ?>
	<tr id="r_msg">
		<td><span id="elh_personal_info_msg"><?php echo $personal_info->msg->FldCaption() ?></span></td>
		<td<?php echo $personal_info->msg->CellAttributes() ?>>
<span id="el_personal_info_msg" class="control-group">
<textarea data-field="x_msg" name="x_msg" id="x_msg" cols="35" rows="4" placeholder="<?php echo $personal_info->msg->PlaceHolder ?>"<?php echo $personal_info->msg->EditAttributes() ?>><?php echo $personal_info->msg->EditValue ?></textarea>
</span>
<?php echo $personal_info->msg->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($personal_info->city->Visible) { // city ?>
	<tr id="r_city">
		<td><span id="elh_personal_info_city"><?php echo $personal_info->city->FldCaption() ?></span></td>
		<td<?php echo $personal_info->city->CellAttributes() ?>>
<span id="el_personal_info_city" class="control-group">
<input type="text" data-field="x_city" name="x_city" id="x_city" size="30" maxlength="10" placeholder="<?php echo $personal_info->city->PlaceHolder ?>" value="<?php echo $personal_info->city->EditValue ?>"<?php echo $personal_info->city->EditAttributes() ?>>
</span>
<?php echo $personal_info->city->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($personal_info->rstate->Visible) { // rstate ?>
	<tr id="r_rstate">
		<td><span id="elh_personal_info_rstate"><?php echo $personal_info->rstate->FldCaption() ?></span></td>
		<td<?php echo $personal_info->rstate->CellAttributes() ?>>
<span id="el_personal_info_rstate" class="control-group">
<input type="text" data-field="x_rstate" name="x_rstate" id="x_rstate" size="30" maxlength="20" placeholder="<?php echo $personal_info->rstate->PlaceHolder ?>" value="<?php echo $personal_info->rstate->EditValue ?>"<?php echo $personal_info->rstate->EditAttributes() ?>>
</span>
<?php echo $personal_info->rstate->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($personal_info->reg_status->Visible) { // reg_status ?>
	<tr id="r_reg_status">
		<td><span id="elh_personal_info_reg_status"><?php echo $personal_info->reg_status->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></span></td>
		<td<?php echo $personal_info->reg_status->CellAttributes() ?>>
<span id="el_personal_info_reg_status" class="control-group">
<input type="text" data-field="x_reg_status" name="x_reg_status" id="x_reg_status" size="30" maxlength="255" placeholder="<?php echo $personal_info->reg_status->PlaceHolder ?>" value="<?php echo $personal_info->reg_status->EditValue ?>"<?php echo $personal_info->reg_status->EditAttributes() ?>>
</span>
<?php echo $personal_info->reg_status->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($personal_info->employment_status->Visible) { // employment_status ?>
	<tr id="r_employment_status">
		<td><span id="elh_personal_info_employment_status"><?php echo $personal_info->employment_status->FldCaption() ?></span></td>
		<td<?php echo $personal_info->employment_status->CellAttributes() ?>>
<span id="el_personal_info_employment_status" class="control-group">
<input type="text" data-field="x_employment_status" name="x_employment_status" id="x_employment_status" size="30" maxlength="50" placeholder="<?php echo $personal_info->employment_status->PlaceHolder ?>" value="<?php echo $personal_info->employment_status->EditValue ?>"<?php echo $personal_info->employment_status->EditAttributes() ?>>
</span>
<?php echo $personal_info->employment_status->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($personal_info->datecreated->Visible) { // datecreated ?>
	<tr id="r_datecreated">
		<td><span id="elh_personal_info_datecreated"><?php echo $personal_info->datecreated->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></span></td>
		<td<?php echo $personal_info->datecreated->CellAttributes() ?>>
<span id="el_personal_info_datecreated" class="control-group">
<input type="text" data-field="x_datecreated" name="x_datecreated" id="x_datecreated" placeholder="<?php echo $personal_info->datecreated->PlaceHolder ?>" value="<?php echo $personal_info->datecreated->EditValue ?>"<?php echo $personal_info->datecreated->EditAttributes() ?>>
</span>
<?php echo $personal_info->datecreated->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($personal_info->employer->Visible) { // employer ?>
	<tr id="r_employer">
		<td><span id="elh_personal_info_employer"><?php echo $personal_info->employer->FldCaption() ?></span></td>
		<td<?php echo $personal_info->employer->CellAttributes() ?>>
<span id="el_personal_info_employer" class="control-group">
<textarea data-field="x_employer" name="x_employer" id="x_employer" cols="35" rows="4" placeholder="<?php echo $personal_info->employer->PlaceHolder ?>"<?php echo $personal_info->employer->EditAttributes() ?>><?php echo $personal_info->employer->EditValue ?></textarea>
</span>
<?php echo $personal_info->employer->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($personal_info->employerphone->Visible) { // employerphone ?>
	<tr id="r_employerphone">
		<td><span id="elh_personal_info_employerphone"><?php echo $personal_info->employerphone->FldCaption() ?></span></td>
		<td<?php echo $personal_info->employerphone->CellAttributes() ?>>
<span id="el_personal_info_employerphone" class="control-group">
<input type="text" data-field="x_employerphone" name="x_employerphone" id="x_employerphone" size="30" maxlength="50" placeholder="<?php echo $personal_info->employerphone->PlaceHolder ?>" value="<?php echo $personal_info->employerphone->EditValue ?>"<?php echo $personal_info->employerphone->EditAttributes() ?>>
</span>
<?php echo $personal_info->employerphone->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($personal_info->employeraddr->Visible) { // employeraddr ?>
	<tr id="r_employeraddr">
		<td><span id="elh_personal_info_employeraddr"><?php echo $personal_info->employeraddr->FldCaption() ?></span></td>
		<td<?php echo $personal_info->employeraddr->CellAttributes() ?>>
<span id="el_personal_info_employeraddr" class="control-group">
<textarea data-field="x_employeraddr" name="x_employeraddr" id="x_employeraddr" cols="35" rows="4" placeholder="<?php echo $personal_info->employeraddr->PlaceHolder ?>"<?php echo $personal_info->employeraddr->EditAttributes() ?>><?php echo $personal_info->employeraddr->EditValue ?></textarea>
</span>
<?php echo $personal_info->employeraddr->CustomMsg ?></td>
	</tr>
<?php } ?>
</table>
</td></tr></table>
<table class="ewPager">
<tr><td>
<?php if (!isset($personal_info_edit->Pager)) $personal_info_edit->Pager = new cNumericPager($personal_info_edit->StartRec, $personal_info_edit->DisplayRecs, $personal_info_edit->TotalRecs, $personal_info_edit->RecRange) ?>
<?php if ($personal_info_edit->Pager->RecordCount > 0) { ?>
<table cellspacing="0" class="ewStdTable"><tbody><tr><td>
<div class="pagination"><ul>
	<?php if ($personal_info_edit->Pager->FirstButton->Enabled) { ?>
	<li><a href="<?php echo $personal_info_edit->PageUrl() ?>start=<?php echo $personal_info_edit->Pager->FirstButton->Start ?>"><?php echo $Language->Phrase("PagerFirst") ?></a></li>
	<?php } ?>
	<?php if ($personal_info_edit->Pager->PrevButton->Enabled) { ?>
	<li><a href="<?php echo $personal_info_edit->PageUrl() ?>start=<?php echo $personal_info_edit->Pager->PrevButton->Start ?>"><?php echo $Language->Phrase("PagerPrevious") ?></a></li>
	<?php } ?>
	<?php foreach ($personal_info_edit->Pager->Items as $PagerItem) { ?>
		<li<?php if (!$PagerItem->Enabled) { echo " class=\" active\""; } ?>><a href="<?php if ($PagerItem->Enabled) { echo $personal_info_edit->PageUrl() . "start=" . $PagerItem->Start; } else { echo "#"; } ?>"><?php echo $PagerItem->Text ?></a></li>
	<?php } ?>
	<?php if ($personal_info_edit->Pager->NextButton->Enabled) { ?>
	<li><a href="<?php echo $personal_info_edit->PageUrl() ?>start=<?php echo $personal_info_edit->Pager->NextButton->Start ?>"><?php echo $Language->Phrase("PagerNext") ?></a></li>
	<?php } ?>
	<?php if ($personal_info_edit->Pager->LastButton->Enabled) { ?>
	<li><a href="<?php echo $personal_info_edit->PageUrl() ?>start=<?php echo $personal_info_edit->Pager->LastButton->Start ?>"><?php echo $Language->Phrase("PagerLast") ?></a></li>
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
fpersonal_infoedit.Init();
<?php if (EW_MOBILE_REFLOW && ew_IsMobile()) { ?>
ew_Reflow();
<?php } ?>
</script>
<?php
$personal_info_edit->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$personal_info_edit->Page_Terminate();
?>
