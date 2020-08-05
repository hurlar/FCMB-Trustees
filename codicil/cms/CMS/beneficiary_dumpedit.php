<?php
if (session_id() == "") session_start(); // Initialize Session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg10.php" ?>
<?php include_once "ewmysql10.php" ?>
<?php include_once "phpfn10.php" ?>
<?php include_once "beneficiary_dumpinfo.php" ?>
<?php include_once "adminusersinfo.php" ?>
<?php include_once "children_detailsinfo.php" ?>
<?php include_once "personal_infoinfo.php" ?>
<?php include_once "assets_tbgridcls.php" ?>
<?php include_once "userfn10.php" ?>
<?php

//
// Page class
//

$beneficiary_dump_edit = NULL; // Initialize page object first

class cbeneficiary_dump_edit extends cbeneficiary_dump {

	// Page ID
	var $PageID = 'edit';

	// Project ID
	var $ProjectID = "{D9B361E7-B2C1-4293-B9B3-B581986A15CC}";

	// Table name
	var $TableName = 'beneficiary_dump';

	// Page object name
	var $PageObjName = 'beneficiary_dump_edit';

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

		// Table object (beneficiary_dump)
		if (!isset($GLOBALS["beneficiary_dump"])) {
			$GLOBALS["beneficiary_dump"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["beneficiary_dump"];
		}

		// Table object (adminusers)
		if (!isset($GLOBALS['adminusers'])) $GLOBALS['adminusers'] = new cadminusers();

		// Table object (children_details)
		if (!isset($GLOBALS['children_details'])) $GLOBALS['children_details'] = new cchildren_details();

		// Table object (personal_info)
		if (!isset($GLOBALS['personal_info'])) $GLOBALS['personal_info'] = new cpersonal_info();

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'edit', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'beneficiary_dump', TRUE);

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
			$this->Page_Terminate("beneficiary_dumplist.php"); // Return to list page
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
					$this->Page_Terminate("beneficiary_dumplist.php"); // Return to list page
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
					if (ew_GetPageName($sReturnUrl) == "beneficiary_dumpview.php")
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
		if (!$this->childid->FldIsDetailKey) {
			$this->childid->setFormValue($objForm->GetValue("x_childid"));
		}
		if (!$this->title->FldIsDetailKey) {
			$this->title->setFormValue($objForm->GetValue("x_title"));
		}
		if (!$this->fullname->FldIsDetailKey) {
			$this->fullname->setFormValue($objForm->GetValue("x_fullname"));
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
		if (!$this->percentage->FldIsDetailKey) {
			$this->percentage->setFormValue($objForm->GetValue("x_percentage"));
		}
		if (!$this->percentage1->FldIsDetailKey) {
			$this->percentage1->setFormValue($objForm->GetValue("x_percentage1"));
		}
		if (!$this->percentage2->FldIsDetailKey) {
			$this->percentage2->setFormValue($objForm->GetValue("x_percentage2"));
		}
		if (!$this->percentage3->FldIsDetailKey) {
			$this->percentage3->setFormValue($objForm->GetValue("x_percentage3"));
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
		$this->childid->CurrentValue = $this->childid->FormValue;
		$this->title->CurrentValue = $this->title->FormValue;
		$this->fullname->CurrentValue = $this->fullname->FormValue;
		$this->rtionship->CurrentValue = $this->rtionship->FormValue;
		$this->_email->CurrentValue = $this->_email->FormValue;
		$this->phone->CurrentValue = $this->phone->FormValue;
		$this->addr->CurrentValue = $this->addr->FormValue;
		$this->city->CurrentValue = $this->city->FormValue;
		$this->state->CurrentValue = $this->state->FormValue;
		$this->percentage->CurrentValue = $this->percentage->FormValue;
		$this->percentage1->CurrentValue = $this->percentage1->FormValue;
		$this->percentage2->CurrentValue = $this->percentage2->FormValue;
		$this->percentage3->CurrentValue = $this->percentage3->FormValue;
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
		$this->childid->setDbValue($rs->fields('childid'));
		$this->title->setDbValue($rs->fields('title'));
		$this->fullname->setDbValue($rs->fields('fullname'));
		$this->rtionship->setDbValue($rs->fields('rtionship'));
		$this->_email->setDbValue($rs->fields('email'));
		$this->phone->setDbValue($rs->fields('phone'));
		$this->addr->setDbValue($rs->fields('addr'));
		$this->city->setDbValue($rs->fields('city'));
		$this->state->setDbValue($rs->fields('state'));
		$this->percentage->setDbValue($rs->fields('percentage'));
		$this->percentage1->setDbValue($rs->fields('percentage1'));
		$this->percentage2->setDbValue($rs->fields('percentage2'));
		$this->percentage3->setDbValue($rs->fields('percentage3'));
		$this->datecreated->setDbValue($rs->fields('datecreated'));
		$this->passport->setDbValue($rs->fields('passport'));
	}

	// Load DbValue from recordset
	function LoadDbValues(&$rs) {
		if (!$rs || !is_array($rs) && $rs->EOF) return;
		$row = is_array($rs) ? $rs : $rs->fields;
		$this->id->DbValue = $row['id'];
		$this->uid->DbValue = $row['uid'];
		$this->childid->DbValue = $row['childid'];
		$this->title->DbValue = $row['title'];
		$this->fullname->DbValue = $row['fullname'];
		$this->rtionship->DbValue = $row['rtionship'];
		$this->_email->DbValue = $row['email'];
		$this->phone->DbValue = $row['phone'];
		$this->addr->DbValue = $row['addr'];
		$this->city->DbValue = $row['city'];
		$this->state->DbValue = $row['state'];
		$this->percentage->DbValue = $row['percentage'];
		$this->percentage1->DbValue = $row['percentage1'];
		$this->percentage2->DbValue = $row['percentage2'];
		$this->percentage3->DbValue = $row['percentage3'];
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
		// childid
		// title
		// fullname
		// rtionship
		// email
		// phone
		// addr
		// city
		// state
		// percentage
		// percentage1
		// percentage2
		// percentage3
		// datecreated
		// passport

		if ($this->RowType == EW_ROWTYPE_VIEW) { // View row

			// id
			$this->id->ViewValue = $this->id->CurrentValue;
			$this->id->ViewCustomAttributes = "";

			// uid
			$this->uid->ViewValue = $this->uid->CurrentValue;
			$this->uid->ViewCustomAttributes = "";

			// childid
			$this->childid->ViewValue = $this->childid->CurrentValue;
			$this->childid->ViewCustomAttributes = "";

			// title
			$this->title->ViewValue = $this->title->CurrentValue;
			$this->title->ViewCustomAttributes = "";

			// fullname
			$this->fullname->ViewValue = $this->fullname->CurrentValue;
			$this->fullname->ViewCustomAttributes = "";

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

			// percentage
			$this->percentage->ViewValue = $this->percentage->CurrentValue;
			$this->percentage->ViewCustomAttributes = "";

			// percentage1
			$this->percentage1->ViewValue = $this->percentage1->CurrentValue;
			$this->percentage1->ViewCustomAttributes = "";

			// percentage2
			$this->percentage2->ViewValue = $this->percentage2->CurrentValue;
			$this->percentage2->ViewCustomAttributes = "";

			// percentage3
			$this->percentage3->ViewValue = $this->percentage3->CurrentValue;
			$this->percentage3->ViewCustomAttributes = "";

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

			// childid
			$this->childid->LinkCustomAttributes = "";
			$this->childid->HrefValue = "";
			$this->childid->TooltipValue = "";

			// title
			$this->title->LinkCustomAttributes = "";
			$this->title->HrefValue = "";
			$this->title->TooltipValue = "";

			// fullname
			$this->fullname->LinkCustomAttributes = "";
			$this->fullname->HrefValue = "";
			$this->fullname->TooltipValue = "";

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

			// percentage
			$this->percentage->LinkCustomAttributes = "";
			$this->percentage->HrefValue = "";
			$this->percentage->TooltipValue = "";

			// percentage1
			$this->percentage1->LinkCustomAttributes = "";
			$this->percentage1->HrefValue = "";
			$this->percentage1->TooltipValue = "";

			// percentage2
			$this->percentage2->LinkCustomAttributes = "";
			$this->percentage2->HrefValue = "";
			$this->percentage2->TooltipValue = "";

			// percentage3
			$this->percentage3->LinkCustomAttributes = "";
			$this->percentage3->HrefValue = "";
			$this->percentage3->TooltipValue = "";

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

			// childid
			$this->childid->EditCustomAttributes = "";
			$this->childid->EditValue = ew_HtmlEncode($this->childid->CurrentValue);
			$this->childid->PlaceHolder = ew_HtmlEncode(ew_RemoveHtml($this->childid->FldCaption()));

			// title
			$this->title->EditCustomAttributes = "";
			$this->title->EditValue = ew_HtmlEncode($this->title->CurrentValue);
			$this->title->PlaceHolder = ew_HtmlEncode(ew_RemoveHtml($this->title->FldCaption()));

			// fullname
			$this->fullname->EditCustomAttributes = "";
			$this->fullname->EditValue = ew_HtmlEncode($this->fullname->CurrentValue);
			$this->fullname->PlaceHolder = ew_HtmlEncode(ew_RemoveHtml($this->fullname->FldCaption()));

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

			// percentage
			$this->percentage->EditCustomAttributes = "";
			$this->percentage->EditValue = ew_HtmlEncode($this->percentage->CurrentValue);
			$this->percentage->PlaceHolder = ew_HtmlEncode(ew_RemoveHtml($this->percentage->FldCaption()));

			// percentage1
			$this->percentage1->EditCustomAttributes = "";
			$this->percentage1->EditValue = ew_HtmlEncode($this->percentage1->CurrentValue);
			$this->percentage1->PlaceHolder = ew_HtmlEncode(ew_RemoveHtml($this->percentage1->FldCaption()));

			// percentage2
			$this->percentage2->EditCustomAttributes = "";
			$this->percentage2->EditValue = ew_HtmlEncode($this->percentage2->CurrentValue);
			$this->percentage2->PlaceHolder = ew_HtmlEncode(ew_RemoveHtml($this->percentage2->FldCaption()));

			// percentage3
			$this->percentage3->EditCustomAttributes = "";
			$this->percentage3->EditValue = ew_HtmlEncode($this->percentage3->CurrentValue);
			$this->percentage3->PlaceHolder = ew_HtmlEncode(ew_RemoveHtml($this->percentage3->FldCaption()));

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

			// childid
			$this->childid->HrefValue = "";

			// title
			$this->title->HrefValue = "";

			// fullname
			$this->fullname->HrefValue = "";

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

			// percentage
			$this->percentage->HrefValue = "";

			// percentage1
			$this->percentage1->HrefValue = "";

			// percentage2
			$this->percentage2->HrefValue = "";

			// percentage3
			$this->percentage3->HrefValue = "";

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
		if (in_array("assets_tb", $DetailTblVar) && $GLOBALS["assets_tb"]->DetailEdit) {
			if (!isset($GLOBALS["assets_tb_grid"])) $GLOBALS["assets_tb_grid"] = new cassets_tb_grid(); // get detail page object
			$GLOBALS["assets_tb_grid"]->ValidateGridForm();
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

			// childid
			$this->childid->SetDbValueDef($rsnew, $this->childid->CurrentValue, NULL, $this->childid->ReadOnly);

			// title
			$this->title->SetDbValueDef($rsnew, $this->title->CurrentValue, NULL, $this->title->ReadOnly);

			// fullname
			$this->fullname->SetDbValueDef($rsnew, $this->fullname->CurrentValue, NULL, $this->fullname->ReadOnly);

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

			// percentage
			$this->percentage->SetDbValueDef($rsnew, $this->percentage->CurrentValue, NULL, $this->percentage->ReadOnly);

			// percentage1
			$this->percentage1->SetDbValueDef($rsnew, $this->percentage1->CurrentValue, NULL, $this->percentage1->ReadOnly);

			// percentage2
			$this->percentage2->SetDbValueDef($rsnew, $this->percentage2->CurrentValue, NULL, $this->percentage2->ReadOnly);

			// percentage3
			$this->percentage3->SetDbValueDef($rsnew, $this->percentage3->CurrentValue, NULL, $this->percentage3->ReadOnly);

			// datecreated
			$this->datecreated->SetDbValueDef($rsnew, $this->datecreated->CurrentValue, NULL, $this->datecreated->ReadOnly);

			// passport
			$this->passport->SetDbValueDef($rsnew, $this->passport->CurrentValue, NULL, $this->passport->ReadOnly);

			// Check referential integrity for master table 'children_details'
			$bValidMasterRecord = TRUE;
			$sMasterFilter = $this->SqlMasterFilter_children_details();
			$KeyValue = isset($rsnew['uid']) ? $rsnew['uid'] : $rsold['uid'];
			if (strval($KeyValue) <> "") {
				$sMasterFilter = str_replace("@uid@", ew_AdjustSql($KeyValue), $sMasterFilter);
			} else {
				$bValidMasterRecord = FALSE;
			}
			if ($bValidMasterRecord) {
				$rsmaster = $GLOBALS["children_details"]->LoadRs($sMasterFilter);
				$bValidMasterRecord = ($rsmaster && !$rsmaster->EOF);
				$rsmaster->Close();
			}
			if (!$bValidMasterRecord) {
				$sRelatedRecordMsg = str_replace("%t", "children_details", $Language->Phrase("RelatedRecordRequired"));
				$this->setFailureMessage($sRelatedRecordMsg);
				$rs->Close();
				return FALSE;
			}

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
					if (in_array("assets_tb", $DetailTblVar) && $GLOBALS["assets_tb"]->DetailEdit) {
						if (!isset($GLOBALS["assets_tb_grid"])) $GLOBALS["assets_tb_grid"] = new cassets_tb_grid(); // Get detail page object
						$EditRow = $GLOBALS["assets_tb_grid"]->GridUpdate();
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
			if ($sMasterTblVar == "children_details") {
				$bValidMaster = TRUE;
				if (@$_GET["uid"] <> "") {
					$GLOBALS["children_details"]->uid->setQueryStringValue($_GET["uid"]);
					$this->uid->setQueryStringValue($GLOBALS["children_details"]->uid->QueryStringValue);
					$this->uid->setSessionValue($this->uid->QueryStringValue);
					if (!is_numeric($GLOBALS["children_details"]->uid->QueryStringValue)) $bValidMaster = FALSE;
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
		}
		if ($bValidMaster) {

			// Save current master table
			$this->setCurrentMasterTable($sMasterTblVar);

			// Reset start record counter (new master key)
			$this->StartRec = 1;
			$this->setStartRecordNumber($this->StartRec);

			// Clear previous master key from Session
			if ($sMasterTblVar <> "children_details") {
				if ($this->uid->QueryStringValue == "") $this->uid->setSessionValue("");
			}
			if ($sMasterTblVar <> "personal_info") {
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
			if (in_array("assets_tb", $DetailTblVar)) {
				if (!isset($GLOBALS["assets_tb_grid"]))
					$GLOBALS["assets_tb_grid"] = new cassets_tb_grid;
				if ($GLOBALS["assets_tb_grid"]->DetailEdit) {
					$GLOBALS["assets_tb_grid"]->CurrentMode = "edit";
					$GLOBALS["assets_tb_grid"]->CurrentAction = "gridedit";

					// Save current master table to detail table
					$GLOBALS["assets_tb_grid"]->setCurrentMasterTable($this->TableVar);
					$GLOBALS["assets_tb_grid"]->setStartRecordNumber(1);
					$GLOBALS["assets_tb_grid"]->uid->FldIsDetailKey = TRUE;
					$GLOBALS["assets_tb_grid"]->uid->CurrentValue = $this->uid->CurrentValue;
					$GLOBALS["assets_tb_grid"]->uid->setSessionValue($GLOBALS["assets_tb_grid"]->uid->CurrentValue);
				}
			}
		}
	}

	// Set up Breadcrumb
	function SetupBreadcrumb() {
		global $Breadcrumb, $Language;
		$Breadcrumb = new cBreadcrumb();
		$PageCaption = $this->TableCaption();
		$Breadcrumb->Add("list", "<span id=\"ewPageCaption\">" . $PageCaption . "</span>", "beneficiary_dumplist.php", $this->TableVar);
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
if (!isset($beneficiary_dump_edit)) $beneficiary_dump_edit = new cbeneficiary_dump_edit();

// Page init
$beneficiary_dump_edit->Page_Init();

// Page main
$beneficiary_dump_edit->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$beneficiary_dump_edit->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Page object
var beneficiary_dump_edit = new ew_Page("beneficiary_dump_edit");
beneficiary_dump_edit.PageID = "edit"; // Page ID
var EW_PAGE_ID = beneficiary_dump_edit.PageID; // For backward compatibility

// Form object
var fbeneficiary_dumpedit = new ew_Form("fbeneficiary_dumpedit");

// Validate form
fbeneficiary_dumpedit.Validate = function() {
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
				return this.OnError(elm, "<?php echo ew_JsEncode2($beneficiary_dump->uid->FldErrMsg()) ?>");

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
fbeneficiary_dumpedit.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
fbeneficiary_dumpedit.ValidateRequired = true;
<?php } else { ?>
fbeneficiary_dumpedit.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
// Form object for search

</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<?php $Breadcrumb->Render(); ?>
<?php $beneficiary_dump_edit->ShowPageHeader(); ?>
<?php
$beneficiary_dump_edit->ShowMessage();
?>
<form name="fbeneficiary_dumpedit" id="fbeneficiary_dumpedit" class="ewForm form-horizontal" action="<?php echo ew_CurrentPage() ?>" method="post">
<input type="hidden" name="t" value="beneficiary_dump">
<input type="hidden" name="a_edit" id="a_edit" value="U">
<table cellspacing="0" class="ewGrid"><tr><td>
<table id="tbl_beneficiary_dumpedit" class="table table-bordered table-striped">
<?php if ($beneficiary_dump->id->Visible) { // id ?>
	<tr id="r_id">
		<td><span id="elh_beneficiary_dump_id"><?php echo $beneficiary_dump->id->FldCaption() ?></span></td>
		<td<?php echo $beneficiary_dump->id->CellAttributes() ?>>
<span id="el_beneficiary_dump_id" class="control-group">
<span<?php echo $beneficiary_dump->id->ViewAttributes() ?>>
<?php echo $beneficiary_dump->id->EditValue ?></span>
</span>
<input type="hidden" data-field="x_id" name="x_id" id="x_id" value="<?php echo ew_HtmlEncode($beneficiary_dump->id->CurrentValue) ?>">
<?php echo $beneficiary_dump->id->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($beneficiary_dump->uid->Visible) { // uid ?>
	<tr id="r_uid">
		<td><span id="elh_beneficiary_dump_uid"><?php echo $beneficiary_dump->uid->FldCaption() ?></span></td>
		<td<?php echo $beneficiary_dump->uid->CellAttributes() ?>>
<?php if ($beneficiary_dump->uid->getSessionValue() <> "") { ?>
<span<?php echo $beneficiary_dump->uid->ViewAttributes() ?>>
<?php echo $beneficiary_dump->uid->ViewValue ?></span>
<input type="hidden" id="x_uid" name="x_uid" value="<?php echo ew_HtmlEncode($beneficiary_dump->uid->CurrentValue) ?>">
<?php } else { ?>
<input type="text" data-field="x_uid" name="x_uid" id="x_uid" size="30" placeholder="<?php echo $beneficiary_dump->uid->PlaceHolder ?>" value="<?php echo $beneficiary_dump->uid->EditValue ?>"<?php echo $beneficiary_dump->uid->EditAttributes() ?>>
<?php } ?>
<?php echo $beneficiary_dump->uid->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($beneficiary_dump->childid->Visible) { // childid ?>
	<tr id="r_childid">
		<td><span id="elh_beneficiary_dump_childid"><?php echo $beneficiary_dump->childid->FldCaption() ?></span></td>
		<td<?php echo $beneficiary_dump->childid->CellAttributes() ?>>
<span id="el_beneficiary_dump_childid" class="control-group">
<input type="text" data-field="x_childid" name="x_childid" id="x_childid" size="30" maxlength="10" placeholder="<?php echo $beneficiary_dump->childid->PlaceHolder ?>" value="<?php echo $beneficiary_dump->childid->EditValue ?>"<?php echo $beneficiary_dump->childid->EditAttributes() ?>>
</span>
<?php echo $beneficiary_dump->childid->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($beneficiary_dump->title->Visible) { // title ?>
	<tr id="r_title">
		<td><span id="elh_beneficiary_dump_title"><?php echo $beneficiary_dump->title->FldCaption() ?></span></td>
		<td<?php echo $beneficiary_dump->title->CellAttributes() ?>>
<span id="el_beneficiary_dump_title" class="control-group">
<input type="text" data-field="x_title" name="x_title" id="x_title" size="30" maxlength="20" placeholder="<?php echo $beneficiary_dump->title->PlaceHolder ?>" value="<?php echo $beneficiary_dump->title->EditValue ?>"<?php echo $beneficiary_dump->title->EditAttributes() ?>>
</span>
<?php echo $beneficiary_dump->title->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($beneficiary_dump->fullname->Visible) { // fullname ?>
	<tr id="r_fullname">
		<td><span id="elh_beneficiary_dump_fullname"><?php echo $beneficiary_dump->fullname->FldCaption() ?></span></td>
		<td<?php echo $beneficiary_dump->fullname->CellAttributes() ?>>
<span id="el_beneficiary_dump_fullname" class="control-group">
<input type="text" data-field="x_fullname" name="x_fullname" id="x_fullname" size="30" maxlength="50" placeholder="<?php echo $beneficiary_dump->fullname->PlaceHolder ?>" value="<?php echo $beneficiary_dump->fullname->EditValue ?>"<?php echo $beneficiary_dump->fullname->EditAttributes() ?>>
</span>
<?php echo $beneficiary_dump->fullname->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($beneficiary_dump->rtionship->Visible) { // rtionship ?>
	<tr id="r_rtionship">
		<td><span id="elh_beneficiary_dump_rtionship"><?php echo $beneficiary_dump->rtionship->FldCaption() ?></span></td>
		<td<?php echo $beneficiary_dump->rtionship->CellAttributes() ?>>
<span id="el_beneficiary_dump_rtionship" class="control-group">
<input type="text" data-field="x_rtionship" name="x_rtionship" id="x_rtionship" size="30" maxlength="20" placeholder="<?php echo $beneficiary_dump->rtionship->PlaceHolder ?>" value="<?php echo $beneficiary_dump->rtionship->EditValue ?>"<?php echo $beneficiary_dump->rtionship->EditAttributes() ?>>
</span>
<?php echo $beneficiary_dump->rtionship->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($beneficiary_dump->_email->Visible) { // email ?>
	<tr id="r__email">
		<td><span id="elh_beneficiary_dump__email"><?php echo $beneficiary_dump->_email->FldCaption() ?></span></td>
		<td<?php echo $beneficiary_dump->_email->CellAttributes() ?>>
<span id="el_beneficiary_dump__email" class="control-group">
<input type="text" data-field="x__email" name="x__email" id="x__email" size="30" maxlength="50" placeholder="<?php echo $beneficiary_dump->_email->PlaceHolder ?>" value="<?php echo $beneficiary_dump->_email->EditValue ?>"<?php echo $beneficiary_dump->_email->EditAttributes() ?>>
</span>
<?php echo $beneficiary_dump->_email->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($beneficiary_dump->phone->Visible) { // phone ?>
	<tr id="r_phone">
		<td><span id="elh_beneficiary_dump_phone"><?php echo $beneficiary_dump->phone->FldCaption() ?></span></td>
		<td<?php echo $beneficiary_dump->phone->CellAttributes() ?>>
<span id="el_beneficiary_dump_phone" class="control-group">
<input type="text" data-field="x_phone" name="x_phone" id="x_phone" size="30" maxlength="20" placeholder="<?php echo $beneficiary_dump->phone->PlaceHolder ?>" value="<?php echo $beneficiary_dump->phone->EditValue ?>"<?php echo $beneficiary_dump->phone->EditAttributes() ?>>
</span>
<?php echo $beneficiary_dump->phone->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($beneficiary_dump->addr->Visible) { // addr ?>
	<tr id="r_addr">
		<td><span id="elh_beneficiary_dump_addr"><?php echo $beneficiary_dump->addr->FldCaption() ?></span></td>
		<td<?php echo $beneficiary_dump->addr->CellAttributes() ?>>
<span id="el_beneficiary_dump_addr" class="control-group">
<textarea data-field="x_addr" name="x_addr" id="x_addr" cols="35" rows="4" placeholder="<?php echo $beneficiary_dump->addr->PlaceHolder ?>"<?php echo $beneficiary_dump->addr->EditAttributes() ?>><?php echo $beneficiary_dump->addr->EditValue ?></textarea>
</span>
<?php echo $beneficiary_dump->addr->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($beneficiary_dump->city->Visible) { // city ?>
	<tr id="r_city">
		<td><span id="elh_beneficiary_dump_city"><?php echo $beneficiary_dump->city->FldCaption() ?></span></td>
		<td<?php echo $beneficiary_dump->city->CellAttributes() ?>>
<span id="el_beneficiary_dump_city" class="control-group">
<input type="text" data-field="x_city" name="x_city" id="x_city" size="30" maxlength="20" placeholder="<?php echo $beneficiary_dump->city->PlaceHolder ?>" value="<?php echo $beneficiary_dump->city->EditValue ?>"<?php echo $beneficiary_dump->city->EditAttributes() ?>>
</span>
<?php echo $beneficiary_dump->city->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($beneficiary_dump->state->Visible) { // state ?>
	<tr id="r_state">
		<td><span id="elh_beneficiary_dump_state"><?php echo $beneficiary_dump->state->FldCaption() ?></span></td>
		<td<?php echo $beneficiary_dump->state->CellAttributes() ?>>
<span id="el_beneficiary_dump_state" class="control-group">
<input type="text" data-field="x_state" name="x_state" id="x_state" size="30" maxlength="20" placeholder="<?php echo $beneficiary_dump->state->PlaceHolder ?>" value="<?php echo $beneficiary_dump->state->EditValue ?>"<?php echo $beneficiary_dump->state->EditAttributes() ?>>
</span>
<?php echo $beneficiary_dump->state->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($beneficiary_dump->percentage->Visible) { // percentage ?>
	<tr id="r_percentage">
		<td><span id="elh_beneficiary_dump_percentage"><?php echo $beneficiary_dump->percentage->FldCaption() ?></span></td>
		<td<?php echo $beneficiary_dump->percentage->CellAttributes() ?>>
<span id="el_beneficiary_dump_percentage" class="control-group">
<input type="text" data-field="x_percentage" name="x_percentage" id="x_percentage" size="30" maxlength="10" placeholder="<?php echo $beneficiary_dump->percentage->PlaceHolder ?>" value="<?php echo $beneficiary_dump->percentage->EditValue ?>"<?php echo $beneficiary_dump->percentage->EditAttributes() ?>>
</span>
<?php echo $beneficiary_dump->percentage->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($beneficiary_dump->percentage1->Visible) { // percentage1 ?>
	<tr id="r_percentage1">
		<td><span id="elh_beneficiary_dump_percentage1"><?php echo $beneficiary_dump->percentage1->FldCaption() ?></span></td>
		<td<?php echo $beneficiary_dump->percentage1->CellAttributes() ?>>
<span id="el_beneficiary_dump_percentage1" class="control-group">
<input type="text" data-field="x_percentage1" name="x_percentage1" id="x_percentage1" size="30" maxlength="10" placeholder="<?php echo $beneficiary_dump->percentage1->PlaceHolder ?>" value="<?php echo $beneficiary_dump->percentage1->EditValue ?>"<?php echo $beneficiary_dump->percentage1->EditAttributes() ?>>
</span>
<?php echo $beneficiary_dump->percentage1->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($beneficiary_dump->percentage2->Visible) { // percentage2 ?>
	<tr id="r_percentage2">
		<td><span id="elh_beneficiary_dump_percentage2"><?php echo $beneficiary_dump->percentage2->FldCaption() ?></span></td>
		<td<?php echo $beneficiary_dump->percentage2->CellAttributes() ?>>
<span id="el_beneficiary_dump_percentage2" class="control-group">
<input type="text" data-field="x_percentage2" name="x_percentage2" id="x_percentage2" size="30" maxlength="10" placeholder="<?php echo $beneficiary_dump->percentage2->PlaceHolder ?>" value="<?php echo $beneficiary_dump->percentage2->EditValue ?>"<?php echo $beneficiary_dump->percentage2->EditAttributes() ?>>
</span>
<?php echo $beneficiary_dump->percentage2->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($beneficiary_dump->percentage3->Visible) { // percentage3 ?>
	<tr id="r_percentage3">
		<td><span id="elh_beneficiary_dump_percentage3"><?php echo $beneficiary_dump->percentage3->FldCaption() ?></span></td>
		<td<?php echo $beneficiary_dump->percentage3->CellAttributes() ?>>
<span id="el_beneficiary_dump_percentage3" class="control-group">
<input type="text" data-field="x_percentage3" name="x_percentage3" id="x_percentage3" size="30" maxlength="10" placeholder="<?php echo $beneficiary_dump->percentage3->PlaceHolder ?>" value="<?php echo $beneficiary_dump->percentage3->EditValue ?>"<?php echo $beneficiary_dump->percentage3->EditAttributes() ?>>
</span>
<?php echo $beneficiary_dump->percentage3->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($beneficiary_dump->datecreated->Visible) { // datecreated ?>
	<tr id="r_datecreated">
		<td><span id="elh_beneficiary_dump_datecreated"><?php echo $beneficiary_dump->datecreated->FldCaption() ?></span></td>
		<td<?php echo $beneficiary_dump->datecreated->CellAttributes() ?>>
<span id="el_beneficiary_dump_datecreated" class="control-group">
<input type="text" data-field="x_datecreated" name="x_datecreated" id="x_datecreated" placeholder="<?php echo $beneficiary_dump->datecreated->PlaceHolder ?>" value="<?php echo $beneficiary_dump->datecreated->EditValue ?>"<?php echo $beneficiary_dump->datecreated->EditAttributes() ?>>
</span>
<?php echo $beneficiary_dump->datecreated->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($beneficiary_dump->passport->Visible) { // passport ?>
	<tr id="r_passport">
		<td><span id="elh_beneficiary_dump_passport"><?php echo $beneficiary_dump->passport->FldCaption() ?></span></td>
		<td<?php echo $beneficiary_dump->passport->CellAttributes() ?>>
<span id="el_beneficiary_dump_passport" class="control-group">
<input type="text" data-field="x_passport" name="x_passport" id="x_passport" size="30" maxlength="200" placeholder="<?php echo $beneficiary_dump->passport->PlaceHolder ?>" value="<?php echo $beneficiary_dump->passport->EditValue ?>"<?php echo $beneficiary_dump->passport->EditAttributes() ?>>
</span>
<?php echo $beneficiary_dump->passport->CustomMsg ?></td>
	</tr>
<?php } ?>
</table>
</td></tr></table>
<table class="ewPager">
<tr><td>
<?php if (!isset($beneficiary_dump_edit->Pager)) $beneficiary_dump_edit->Pager = new cNumericPager($beneficiary_dump_edit->StartRec, $beneficiary_dump_edit->DisplayRecs, $beneficiary_dump_edit->TotalRecs, $beneficiary_dump_edit->RecRange) ?>
<?php if ($beneficiary_dump_edit->Pager->RecordCount > 0) { ?>
<table cellspacing="0" class="ewStdTable"><tbody><tr><td>
<div class="pagination"><ul>
	<?php if ($beneficiary_dump_edit->Pager->FirstButton->Enabled) { ?>
	<li><a href="<?php echo $beneficiary_dump_edit->PageUrl() ?>start=<?php echo $beneficiary_dump_edit->Pager->FirstButton->Start ?>"><?php echo $Language->Phrase("PagerFirst") ?></a></li>
	<?php } ?>
	<?php if ($beneficiary_dump_edit->Pager->PrevButton->Enabled) { ?>
	<li><a href="<?php echo $beneficiary_dump_edit->PageUrl() ?>start=<?php echo $beneficiary_dump_edit->Pager->PrevButton->Start ?>"><?php echo $Language->Phrase("PagerPrevious") ?></a></li>
	<?php } ?>
	<?php foreach ($beneficiary_dump_edit->Pager->Items as $PagerItem) { ?>
		<li<?php if (!$PagerItem->Enabled) { echo " class=\" active\""; } ?>><a href="<?php if ($PagerItem->Enabled) { echo $beneficiary_dump_edit->PageUrl() . "start=" . $PagerItem->Start; } else { echo "#"; } ?>"><?php echo $PagerItem->Text ?></a></li>
	<?php } ?>
	<?php if ($beneficiary_dump_edit->Pager->NextButton->Enabled) { ?>
	<li><a href="<?php echo $beneficiary_dump_edit->PageUrl() ?>start=<?php echo $beneficiary_dump_edit->Pager->NextButton->Start ?>"><?php echo $Language->Phrase("PagerNext") ?></a></li>
	<?php } ?>
	<?php if ($beneficiary_dump_edit->Pager->LastButton->Enabled) { ?>
	<li><a href="<?php echo $beneficiary_dump_edit->PageUrl() ?>start=<?php echo $beneficiary_dump_edit->Pager->LastButton->Start ?>"><?php echo $Language->Phrase("PagerLast") ?></a></li>
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
	if (in_array("assets_tb", explode(",", $beneficiary_dump->getCurrentDetailTable())) && $assets_tb->DetailEdit) {
?>
<?php include_once "assets_tbgrid.php" ?>
<?php } ?>
<button class="btn btn-primary ewButton" name="btnAction" id="btnAction" type="submit"><?php echo $Language->Phrase("EditBtn") ?></button>
</form>
<script type="text/javascript">
fbeneficiary_dumpedit.Init();
<?php if (EW_MOBILE_REFLOW && ew_IsMobile()) { ?>
ew_Reflow();
<?php } ?>
</script>
<?php
$beneficiary_dump_edit->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$beneficiary_dump_edit->Page_Terminate();
?>
