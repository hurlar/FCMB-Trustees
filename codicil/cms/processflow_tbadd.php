<?php
if (session_id() == "") session_start(); // Initialize Session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg10.php" ?>
<?php include_once "ewmysql10.php" ?>
<?php include_once "phpfn10.php" ?>
<?php include_once "processflow_tbinfo.php" ?>
<?php include_once "adminusersinfo.php" ?>
<?php include_once "userfn10.php" ?>
<?php

//
// Page class
//

$processflow_tb_add = NULL; // Initialize page object first

class cprocessflow_tb_add extends cprocessflow_tb {

	// Page ID
	var $PageID = 'add';

	// Project ID
	var $ProjectID = "{D9B361E7-B2C1-4293-B9B3-B581986A15CC}";

	// Table name
	var $TableName = 'processflow_tb';

	// Page object name
	var $PageObjName = 'processflow_tb_add';

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

		// Table object (processflow_tb)
		if (!isset($GLOBALS["processflow_tb"])) {
			$GLOBALS["processflow_tb"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["processflow_tb"];
		}

		// Table object (adminusers)
		if (!isset($GLOBALS['adminusers'])) $GLOBALS['adminusers'] = new cadminusers();

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'add', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'processflow_tb', TRUE);

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
					$this->Page_Terminate("processflow_tblist.php"); // No matching record, return to list
				}
				break;
			case "A": // Add new record
				$this->SendEmail = TRUE; // Send email on add success
				if ($this->AddRow($this->OldRecordset)) { // Add successful
					if ($this->getSuccessMessage() == "")
						$this->setSuccessMessage($Language->Phrase("AddSuccess")); // Set up success message
					$sReturnUrl = $this->getReturnUrl();
					if (ew_GetPageName($sReturnUrl) == "processflow_tbview.php")
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
		$this->uid->CurrentValue = NULL;
		$this->uid->OldValue = $this->uid->CurrentValue;
		$this->name->CurrentValue = NULL;
		$this->name->OldValue = $this->name->CurrentValue;
		$this->_email->CurrentValue = NULL;
		$this->_email->OldValue = $this->_email->CurrentValue;
		$this->stage->CurrentValue = "Registration";
		$this->progress->CurrentValue = "No";
		$this->stage2->CurrentValue = "Completion and Submission";
		$this->progress2->CurrentValue = "No";
		$this->stage3->CurrentValue = "Receipt and drafting";
		$this->progress3->CurrentValue = "No";
		$this->stage4->CurrentValue = "Review";
		$this->progress4->CurrentValue = "No";
		$this->stage5->CurrentValue = "Execution";
		$this->progress5->CurrentValue = "No";
		$this->stage6->CurrentValue = "Registry and Lodgment";
		$this->progress6->CurrentValue = "No";
	}

	// Load form values
	function LoadFormValues() {

		// Load from form
		global $objForm;
		if (!$this->uid->FldIsDetailKey) {
			$this->uid->setFormValue($objForm->GetValue("x_uid"));
		}
		if (!$this->name->FldIsDetailKey) {
			$this->name->setFormValue($objForm->GetValue("x_name"));
		}
		if (!$this->_email->FldIsDetailKey) {
			$this->_email->setFormValue($objForm->GetValue("x__email"));
		}
		if (!$this->stage->FldIsDetailKey) {
			$this->stage->setFormValue($objForm->GetValue("x_stage"));
		}
		if (!$this->progress->FldIsDetailKey) {
			$this->progress->setFormValue($objForm->GetValue("x_progress"));
		}
		if (!$this->stage2->FldIsDetailKey) {
			$this->stage2->setFormValue($objForm->GetValue("x_stage2"));
		}
		if (!$this->progress2->FldIsDetailKey) {
			$this->progress2->setFormValue($objForm->GetValue("x_progress2"));
		}
		if (!$this->stage3->FldIsDetailKey) {
			$this->stage3->setFormValue($objForm->GetValue("x_stage3"));
		}
		if (!$this->progress3->FldIsDetailKey) {
			$this->progress3->setFormValue($objForm->GetValue("x_progress3"));
		}
		if (!$this->stage4->FldIsDetailKey) {
			$this->stage4->setFormValue($objForm->GetValue("x_stage4"));
		}
		if (!$this->progress4->FldIsDetailKey) {
			$this->progress4->setFormValue($objForm->GetValue("x_progress4"));
		}
		if (!$this->stage5->FldIsDetailKey) {
			$this->stage5->setFormValue($objForm->GetValue("x_stage5"));
		}
		if (!$this->progress5->FldIsDetailKey) {
			$this->progress5->setFormValue($objForm->GetValue("x_progress5"));
		}
		if (!$this->stage6->FldIsDetailKey) {
			$this->stage6->setFormValue($objForm->GetValue("x_stage6"));
		}
		if (!$this->progress6->FldIsDetailKey) {
			$this->progress6->setFormValue($objForm->GetValue("x_progress6"));
		}
	}

	// Restore form values
	function RestoreFormValues() {
		global $objForm;
		$this->LoadOldRecord();
		$this->uid->CurrentValue = $this->uid->FormValue;
		$this->name->CurrentValue = $this->name->FormValue;
		$this->_email->CurrentValue = $this->_email->FormValue;
		$this->stage->CurrentValue = $this->stage->FormValue;
		$this->progress->CurrentValue = $this->progress->FormValue;
		$this->stage2->CurrentValue = $this->stage2->FormValue;
		$this->progress2->CurrentValue = $this->progress2->FormValue;
		$this->stage3->CurrentValue = $this->stage3->FormValue;
		$this->progress3->CurrentValue = $this->progress3->FormValue;
		$this->stage4->CurrentValue = $this->stage4->FormValue;
		$this->progress4->CurrentValue = $this->progress4->FormValue;
		$this->stage5->CurrentValue = $this->stage5->FormValue;
		$this->progress5->CurrentValue = $this->progress5->FormValue;
		$this->stage6->CurrentValue = $this->stage6->FormValue;
		$this->progress6->CurrentValue = $this->progress6->FormValue;
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
		$this->_email->setDbValue($rs->fields('email'));
		$this->stage->setDbValue($rs->fields('stage'));
		$this->progress->setDbValue($rs->fields('progress'));
		$this->stage2->setDbValue($rs->fields('stage2'));
		$this->progress2->setDbValue($rs->fields('progress2'));
		$this->stage3->setDbValue($rs->fields('stage3'));
		$this->progress3->setDbValue($rs->fields('progress3'));
		$this->stage4->setDbValue($rs->fields('stage4'));
		$this->progress4->setDbValue($rs->fields('progress4'));
		$this->stage5->setDbValue($rs->fields('stage5'));
		$this->progress5->setDbValue($rs->fields('progress5'));
		$this->stage6->setDbValue($rs->fields('stage6'));
		$this->progress6->setDbValue($rs->fields('progress6'));
	}

	// Load DbValue from recordset
	function LoadDbValues(&$rs) {
		if (!$rs || !is_array($rs) && $rs->EOF) return;
		$row = is_array($rs) ? $rs : $rs->fields;
		$this->id->DbValue = $row['id'];
		$this->uid->DbValue = $row['uid'];
		$this->name->DbValue = $row['name'];
		$this->_email->DbValue = $row['email'];
		$this->stage->DbValue = $row['stage'];
		$this->progress->DbValue = $row['progress'];
		$this->stage2->DbValue = $row['stage2'];
		$this->progress2->DbValue = $row['progress2'];
		$this->stage3->DbValue = $row['stage3'];
		$this->progress3->DbValue = $row['progress3'];
		$this->stage4->DbValue = $row['stage4'];
		$this->progress4->DbValue = $row['progress4'];
		$this->stage5->DbValue = $row['stage5'];
		$this->progress5->DbValue = $row['progress5'];
		$this->stage6->DbValue = $row['stage6'];
		$this->progress6->DbValue = $row['progress6'];
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
		// name
		// email
		// stage
		// progress
		// stage2
		// progress2
		// stage3
		// progress3
		// stage4
		// progress4
		// stage5
		// progress5
		// stage6
		// progress6

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

			// email
			$this->_email->ViewValue = $this->_email->CurrentValue;
			$this->_email->ViewCustomAttributes = "";

			// stage
			$this->stage->ViewValue = $this->stage->CurrentValue;
			$this->stage->ViewCustomAttributes = "";

			// progress
			if (strval($this->progress->CurrentValue) <> "") {
				switch ($this->progress->CurrentValue) {
					case $this->progress->FldTagValue(1):
						$this->progress->ViewValue = $this->progress->FldTagCaption(1) <> "" ? $this->progress->FldTagCaption(1) : $this->progress->CurrentValue;
						break;
					case $this->progress->FldTagValue(2):
						$this->progress->ViewValue = $this->progress->FldTagCaption(2) <> "" ? $this->progress->FldTagCaption(2) : $this->progress->CurrentValue;
						break;
					case $this->progress->FldTagValue(3):
						$this->progress->ViewValue = $this->progress->FldTagCaption(3) <> "" ? $this->progress->FldTagCaption(3) : $this->progress->CurrentValue;
						break;
					case $this->progress->FldTagValue(4):
						$this->progress->ViewValue = $this->progress->FldTagCaption(4) <> "" ? $this->progress->FldTagCaption(4) : $this->progress->CurrentValue;
						break;
					default:
						$this->progress->ViewValue = $this->progress->CurrentValue;
				}
			} else {
				$this->progress->ViewValue = NULL;
			}
			$this->progress->ViewCustomAttributes = "";

			// stage2
			$this->stage2->ViewValue = $this->stage2->CurrentValue;
			$this->stage2->ViewCustomAttributes = "";

			// progress2
			if (strval($this->progress2->CurrentValue) <> "") {
				switch ($this->progress2->CurrentValue) {
					case $this->progress2->FldTagValue(1):
						$this->progress2->ViewValue = $this->progress2->FldTagCaption(1) <> "" ? $this->progress2->FldTagCaption(1) : $this->progress2->CurrentValue;
						break;
					case $this->progress2->FldTagValue(2):
						$this->progress2->ViewValue = $this->progress2->FldTagCaption(2) <> "" ? $this->progress2->FldTagCaption(2) : $this->progress2->CurrentValue;
						break;
					case $this->progress2->FldTagValue(3):
						$this->progress2->ViewValue = $this->progress2->FldTagCaption(3) <> "" ? $this->progress2->FldTagCaption(3) : $this->progress2->CurrentValue;
						break;
					case $this->progress2->FldTagValue(4):
						$this->progress2->ViewValue = $this->progress2->FldTagCaption(4) <> "" ? $this->progress2->FldTagCaption(4) : $this->progress2->CurrentValue;
						break;
					default:
						$this->progress2->ViewValue = $this->progress2->CurrentValue;
				}
			} else {
				$this->progress2->ViewValue = NULL;
			}
			$this->progress2->ViewCustomAttributes = "";

			// stage3
			$this->stage3->ViewValue = $this->stage3->CurrentValue;
			$this->stage3->ViewCustomAttributes = "";

			// progress3
			if (strval($this->progress3->CurrentValue) <> "") {
				switch ($this->progress3->CurrentValue) {
					case $this->progress3->FldTagValue(1):
						$this->progress3->ViewValue = $this->progress3->FldTagCaption(1) <> "" ? $this->progress3->FldTagCaption(1) : $this->progress3->CurrentValue;
						break;
					case $this->progress3->FldTagValue(2):
						$this->progress3->ViewValue = $this->progress3->FldTagCaption(2) <> "" ? $this->progress3->FldTagCaption(2) : $this->progress3->CurrentValue;
						break;
					case $this->progress3->FldTagValue(3):
						$this->progress3->ViewValue = $this->progress3->FldTagCaption(3) <> "" ? $this->progress3->FldTagCaption(3) : $this->progress3->CurrentValue;
						break;
					case $this->progress3->FldTagValue(4):
						$this->progress3->ViewValue = $this->progress3->FldTagCaption(4) <> "" ? $this->progress3->FldTagCaption(4) : $this->progress3->CurrentValue;
						break;
					default:
						$this->progress3->ViewValue = $this->progress3->CurrentValue;
				}
			} else {
				$this->progress3->ViewValue = NULL;
			}
			$this->progress3->ViewCustomAttributes = "";

			// stage4
			$this->stage4->ViewValue = $this->stage4->CurrentValue;
			$this->stage4->ViewCustomAttributes = "";

			// progress4
			if (strval($this->progress4->CurrentValue) <> "") {
				switch ($this->progress4->CurrentValue) {
					case $this->progress4->FldTagValue(1):
						$this->progress4->ViewValue = $this->progress4->FldTagCaption(1) <> "" ? $this->progress4->FldTagCaption(1) : $this->progress4->CurrentValue;
						break;
					case $this->progress4->FldTagValue(2):
						$this->progress4->ViewValue = $this->progress4->FldTagCaption(2) <> "" ? $this->progress4->FldTagCaption(2) : $this->progress4->CurrentValue;
						break;
					case $this->progress4->FldTagValue(3):
						$this->progress4->ViewValue = $this->progress4->FldTagCaption(3) <> "" ? $this->progress4->FldTagCaption(3) : $this->progress4->CurrentValue;
						break;
					case $this->progress4->FldTagValue(4):
						$this->progress4->ViewValue = $this->progress4->FldTagCaption(4) <> "" ? $this->progress4->FldTagCaption(4) : $this->progress4->CurrentValue;
						break;
					default:
						$this->progress4->ViewValue = $this->progress4->CurrentValue;
				}
			} else {
				$this->progress4->ViewValue = NULL;
			}
			$this->progress4->ViewCustomAttributes = "";

			// stage5
			$this->stage5->ViewValue = $this->stage5->CurrentValue;
			$this->stage5->ViewCustomAttributes = "";

			// progress5
			if (strval($this->progress5->CurrentValue) <> "") {
				switch ($this->progress5->CurrentValue) {
					case $this->progress5->FldTagValue(1):
						$this->progress5->ViewValue = $this->progress5->FldTagCaption(1) <> "" ? $this->progress5->FldTagCaption(1) : $this->progress5->CurrentValue;
						break;
					case $this->progress5->FldTagValue(2):
						$this->progress5->ViewValue = $this->progress5->FldTagCaption(2) <> "" ? $this->progress5->FldTagCaption(2) : $this->progress5->CurrentValue;
						break;
					case $this->progress5->FldTagValue(3):
						$this->progress5->ViewValue = $this->progress5->FldTagCaption(3) <> "" ? $this->progress5->FldTagCaption(3) : $this->progress5->CurrentValue;
						break;
					case $this->progress5->FldTagValue(4):
						$this->progress5->ViewValue = $this->progress5->FldTagCaption(4) <> "" ? $this->progress5->FldTagCaption(4) : $this->progress5->CurrentValue;
						break;
					default:
						$this->progress5->ViewValue = $this->progress5->CurrentValue;
				}
			} else {
				$this->progress5->ViewValue = NULL;
			}
			$this->progress5->ViewCustomAttributes = "";

			// stage6
			$this->stage6->ViewValue = $this->stage6->CurrentValue;
			$this->stage6->ViewCustomAttributes = "";

			// progress6
			if (strval($this->progress6->CurrentValue) <> "") {
				switch ($this->progress6->CurrentValue) {
					case $this->progress6->FldTagValue(1):
						$this->progress6->ViewValue = $this->progress6->FldTagCaption(1) <> "" ? $this->progress6->FldTagCaption(1) : $this->progress6->CurrentValue;
						break;
					case $this->progress6->FldTagValue(2):
						$this->progress6->ViewValue = $this->progress6->FldTagCaption(2) <> "" ? $this->progress6->FldTagCaption(2) : $this->progress6->CurrentValue;
						break;
					case $this->progress6->FldTagValue(3):
						$this->progress6->ViewValue = $this->progress6->FldTagCaption(3) <> "" ? $this->progress6->FldTagCaption(3) : $this->progress6->CurrentValue;
						break;
					case $this->progress6->FldTagValue(4):
						$this->progress6->ViewValue = $this->progress6->FldTagCaption(4) <> "" ? $this->progress6->FldTagCaption(4) : $this->progress6->CurrentValue;
						break;
					default:
						$this->progress6->ViewValue = $this->progress6->CurrentValue;
				}
			} else {
				$this->progress6->ViewValue = NULL;
			}
			$this->progress6->ViewCustomAttributes = "";

			// uid
			$this->uid->LinkCustomAttributes = "";
			$this->uid->HrefValue = "";
			$this->uid->TooltipValue = "";

			// name
			$this->name->LinkCustomAttributes = "";
			$this->name->HrefValue = "";
			$this->name->TooltipValue = "";

			// email
			$this->_email->LinkCustomAttributes = "";
			$this->_email->HrefValue = "";
			$this->_email->TooltipValue = "";

			// stage
			$this->stage->LinkCustomAttributes = "";
			$this->stage->HrefValue = "";
			$this->stage->TooltipValue = "";

			// progress
			$this->progress->LinkCustomAttributes = "";
			$this->progress->HrefValue = "";
			$this->progress->TooltipValue = "";

			// stage2
			$this->stage2->LinkCustomAttributes = "";
			$this->stage2->HrefValue = "";
			$this->stage2->TooltipValue = "";

			// progress2
			$this->progress2->LinkCustomAttributes = "";
			$this->progress2->HrefValue = "";
			$this->progress2->TooltipValue = "";

			// stage3
			$this->stage3->LinkCustomAttributes = "";
			$this->stage3->HrefValue = "";
			$this->stage3->TooltipValue = "";

			// progress3
			$this->progress3->LinkCustomAttributes = "";
			$this->progress3->HrefValue = "";
			$this->progress3->TooltipValue = "";

			// stage4
			$this->stage4->LinkCustomAttributes = "";
			$this->stage4->HrefValue = "";
			$this->stage4->TooltipValue = "";

			// progress4
			$this->progress4->LinkCustomAttributes = "";
			$this->progress4->HrefValue = "";
			$this->progress4->TooltipValue = "";

			// stage5
			$this->stage5->LinkCustomAttributes = "";
			$this->stage5->HrefValue = "";
			$this->stage5->TooltipValue = "";

			// progress5
			$this->progress5->LinkCustomAttributes = "";
			$this->progress5->HrefValue = "";
			$this->progress5->TooltipValue = "";

			// stage6
			$this->stage6->LinkCustomAttributes = "";
			$this->stage6->HrefValue = "";
			$this->stage6->TooltipValue = "";

			// progress6
			$this->progress6->LinkCustomAttributes = "";
			$this->progress6->HrefValue = "";
			$this->progress6->TooltipValue = "";
		} elseif ($this->RowType == EW_ROWTYPE_ADD) { // Add row

			// uid
			$this->uid->EditCustomAttributes = "";
			$this->uid->EditValue = ew_HtmlEncode($this->uid->CurrentValue);
			$this->uid->PlaceHolder = ew_HtmlEncode(ew_RemoveHtml($this->uid->FldCaption()));

			// name
			$this->name->EditCustomAttributes = "style='width:97%' ";
			$this->name->EditValue = ew_HtmlEncode($this->name->CurrentValue);
			$this->name->PlaceHolder = ew_HtmlEncode(ew_RemoveHtml($this->name->FldCaption()));

			// email
			$this->_email->EditCustomAttributes = "style='width:97%' ";
			$this->_email->EditValue = ew_HtmlEncode($this->_email->CurrentValue);
			$this->_email->PlaceHolder = ew_HtmlEncode(ew_RemoveHtml($this->_email->FldCaption()));

			// stage
			$this->stage->EditCustomAttributes = "";
			$this->stage->EditValue = ew_HtmlEncode($this->stage->CurrentValue);
			$this->stage->PlaceHolder = ew_HtmlEncode(ew_RemoveHtml($this->stage->FldCaption()));

			// progress
			$this->progress->EditCustomAttributes = "style='width:97%' ";
			$arwrk = array();
			$arwrk[] = array($this->progress->FldTagValue(1), $this->progress->FldTagCaption(1) <> "" ? $this->progress->FldTagCaption(1) : $this->progress->FldTagValue(1));
			$arwrk[] = array($this->progress->FldTagValue(2), $this->progress->FldTagCaption(2) <> "" ? $this->progress->FldTagCaption(2) : $this->progress->FldTagValue(2));
			$arwrk[] = array($this->progress->FldTagValue(3), $this->progress->FldTagCaption(3) <> "" ? $this->progress->FldTagCaption(3) : $this->progress->FldTagValue(3));
			$arwrk[] = array($this->progress->FldTagValue(4), $this->progress->FldTagCaption(4) <> "" ? $this->progress->FldTagCaption(4) : $this->progress->FldTagValue(4));
			array_unshift($arwrk, array("", $Language->Phrase("PleaseSelect")));
			$this->progress->EditValue = $arwrk;

			// stage2
			$this->stage2->EditCustomAttributes = "";
			$this->stage2->EditValue = ew_HtmlEncode($this->stage2->CurrentValue);
			$this->stage2->PlaceHolder = ew_HtmlEncode(ew_RemoveHtml($this->stage2->FldCaption()));

			// progress2
			$this->progress2->EditCustomAttributes = "style='width:97%' ";
			$arwrk = array();
			$arwrk[] = array($this->progress2->FldTagValue(1), $this->progress2->FldTagCaption(1) <> "" ? $this->progress2->FldTagCaption(1) : $this->progress2->FldTagValue(1));
			$arwrk[] = array($this->progress2->FldTagValue(2), $this->progress2->FldTagCaption(2) <> "" ? $this->progress2->FldTagCaption(2) : $this->progress2->FldTagValue(2));
			$arwrk[] = array($this->progress2->FldTagValue(3), $this->progress2->FldTagCaption(3) <> "" ? $this->progress2->FldTagCaption(3) : $this->progress2->FldTagValue(3));
			$arwrk[] = array($this->progress2->FldTagValue(4), $this->progress2->FldTagCaption(4) <> "" ? $this->progress2->FldTagCaption(4) : $this->progress2->FldTagValue(4));
			array_unshift($arwrk, array("", $Language->Phrase("PleaseSelect")));
			$this->progress2->EditValue = $arwrk;

			// stage3
			$this->stage3->EditCustomAttributes = "";
			$this->stage3->EditValue = ew_HtmlEncode($this->stage3->CurrentValue);
			$this->stage3->PlaceHolder = ew_HtmlEncode(ew_RemoveHtml($this->stage3->FldCaption()));

			// progress3
			$this->progress3->EditCustomAttributes = "style='width:97%' ";
			$arwrk = array();
			$arwrk[] = array($this->progress3->FldTagValue(1), $this->progress3->FldTagCaption(1) <> "" ? $this->progress3->FldTagCaption(1) : $this->progress3->FldTagValue(1));
			$arwrk[] = array($this->progress3->FldTagValue(2), $this->progress3->FldTagCaption(2) <> "" ? $this->progress3->FldTagCaption(2) : $this->progress3->FldTagValue(2));
			$arwrk[] = array($this->progress3->FldTagValue(3), $this->progress3->FldTagCaption(3) <> "" ? $this->progress3->FldTagCaption(3) : $this->progress3->FldTagValue(3));
			$arwrk[] = array($this->progress3->FldTagValue(4), $this->progress3->FldTagCaption(4) <> "" ? $this->progress3->FldTagCaption(4) : $this->progress3->FldTagValue(4));
			array_unshift($arwrk, array("", $Language->Phrase("PleaseSelect")));
			$this->progress3->EditValue = $arwrk;

			// stage4
			$this->stage4->EditCustomAttributes = "";
			$this->stage4->EditValue = ew_HtmlEncode($this->stage4->CurrentValue);
			$this->stage4->PlaceHolder = ew_HtmlEncode(ew_RemoveHtml($this->stage4->FldCaption()));

			// progress4
			$this->progress4->EditCustomAttributes = "style='width:97%' ";
			$arwrk = array();
			$arwrk[] = array($this->progress4->FldTagValue(1), $this->progress4->FldTagCaption(1) <> "" ? $this->progress4->FldTagCaption(1) : $this->progress4->FldTagValue(1));
			$arwrk[] = array($this->progress4->FldTagValue(2), $this->progress4->FldTagCaption(2) <> "" ? $this->progress4->FldTagCaption(2) : $this->progress4->FldTagValue(2));
			$arwrk[] = array($this->progress4->FldTagValue(3), $this->progress4->FldTagCaption(3) <> "" ? $this->progress4->FldTagCaption(3) : $this->progress4->FldTagValue(3));
			$arwrk[] = array($this->progress4->FldTagValue(4), $this->progress4->FldTagCaption(4) <> "" ? $this->progress4->FldTagCaption(4) : $this->progress4->FldTagValue(4));
			array_unshift($arwrk, array("", $Language->Phrase("PleaseSelect")));
			$this->progress4->EditValue = $arwrk;

			// stage5
			$this->stage5->EditCustomAttributes = "";
			$this->stage5->EditValue = ew_HtmlEncode($this->stage5->CurrentValue);
			$this->stage5->PlaceHolder = ew_HtmlEncode(ew_RemoveHtml($this->stage5->FldCaption()));

			// progress5
			$this->progress5->EditCustomAttributes = "style='width:97%' ";
			$arwrk = array();
			$arwrk[] = array($this->progress5->FldTagValue(1), $this->progress5->FldTagCaption(1) <> "" ? $this->progress5->FldTagCaption(1) : $this->progress5->FldTagValue(1));
			$arwrk[] = array($this->progress5->FldTagValue(2), $this->progress5->FldTagCaption(2) <> "" ? $this->progress5->FldTagCaption(2) : $this->progress5->FldTagValue(2));
			$arwrk[] = array($this->progress5->FldTagValue(3), $this->progress5->FldTagCaption(3) <> "" ? $this->progress5->FldTagCaption(3) : $this->progress5->FldTagValue(3));
			$arwrk[] = array($this->progress5->FldTagValue(4), $this->progress5->FldTagCaption(4) <> "" ? $this->progress5->FldTagCaption(4) : $this->progress5->FldTagValue(4));
			array_unshift($arwrk, array("", $Language->Phrase("PleaseSelect")));
			$this->progress5->EditValue = $arwrk;

			// stage6
			$this->stage6->EditCustomAttributes = "";
			$this->stage6->EditValue = ew_HtmlEncode($this->stage6->CurrentValue);
			$this->stage6->PlaceHolder = ew_HtmlEncode(ew_RemoveHtml($this->stage6->FldCaption()));

			// progress6
			$this->progress6->EditCustomAttributes = "style='width:97%' ";
			$arwrk = array();
			$arwrk[] = array($this->progress6->FldTagValue(1), $this->progress6->FldTagCaption(1) <> "" ? $this->progress6->FldTagCaption(1) : $this->progress6->FldTagValue(1));
			$arwrk[] = array($this->progress6->FldTagValue(2), $this->progress6->FldTagCaption(2) <> "" ? $this->progress6->FldTagCaption(2) : $this->progress6->FldTagValue(2));
			$arwrk[] = array($this->progress6->FldTagValue(3), $this->progress6->FldTagCaption(3) <> "" ? $this->progress6->FldTagCaption(3) : $this->progress6->FldTagValue(3));
			$arwrk[] = array($this->progress6->FldTagValue(4), $this->progress6->FldTagCaption(4) <> "" ? $this->progress6->FldTagCaption(4) : $this->progress6->FldTagValue(4));
			array_unshift($arwrk, array("", $Language->Phrase("PleaseSelect")));
			$this->progress6->EditValue = $arwrk;

			// Edit refer script
			// uid

			$this->uid->HrefValue = "";

			// name
			$this->name->HrefValue = "";

			// email
			$this->_email->HrefValue = "";

			// stage
			$this->stage->HrefValue = "";

			// progress
			$this->progress->HrefValue = "";

			// stage2
			$this->stage2->HrefValue = "";

			// progress2
			$this->progress2->HrefValue = "";

			// stage3
			$this->stage3->HrefValue = "";

			// progress3
			$this->progress3->HrefValue = "";

			// stage4
			$this->stage4->HrefValue = "";

			// progress4
			$this->progress4->HrefValue = "";

			// stage5
			$this->stage5->HrefValue = "";

			// progress5
			$this->progress5->HrefValue = "";

			// stage6
			$this->stage6->HrefValue = "";

			// progress6
			$this->progress6->HrefValue = "";
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

	// Add record
	function AddRow($rsold = NULL) {
		global $conn, $Language, $Security;

		// Load db values from rsold
		if ($rsold) {
			$this->LoadDbValues($rsold);
		}
		$rsnew = array();

		// uid
		$this->uid->SetDbValueDef($rsnew, $this->uid->CurrentValue, NULL, FALSE);

		// name
		$this->name->SetDbValueDef($rsnew, $this->name->CurrentValue, NULL, FALSE);

		// email
		$this->_email->SetDbValueDef($rsnew, $this->_email->CurrentValue, NULL, FALSE);

		// stage
		$this->stage->SetDbValueDef($rsnew, $this->stage->CurrentValue, NULL, strval($this->stage->CurrentValue) == "");

		// progress
		$this->progress->SetDbValueDef($rsnew, $this->progress->CurrentValue, NULL, strval($this->progress->CurrentValue) == "");

		// stage2
		$this->stage2->SetDbValueDef($rsnew, $this->stage2->CurrentValue, NULL, strval($this->stage2->CurrentValue) == "");

		// progress2
		$this->progress2->SetDbValueDef($rsnew, $this->progress2->CurrentValue, NULL, strval($this->progress2->CurrentValue) == "");

		// stage3
		$this->stage3->SetDbValueDef($rsnew, $this->stage3->CurrentValue, NULL, strval($this->stage3->CurrentValue) == "");

		// progress3
		$this->progress3->SetDbValueDef($rsnew, $this->progress3->CurrentValue, NULL, strval($this->progress3->CurrentValue) == "");

		// stage4
		$this->stage4->SetDbValueDef($rsnew, $this->stage4->CurrentValue, NULL, strval($this->stage4->CurrentValue) == "");

		// progress4
		$this->progress4->SetDbValueDef($rsnew, $this->progress4->CurrentValue, NULL, strval($this->progress4->CurrentValue) == "");

		// stage5
		$this->stage5->SetDbValueDef($rsnew, $this->stage5->CurrentValue, NULL, strval($this->stage5->CurrentValue) == "");

		// progress5
		$this->progress5->SetDbValueDef($rsnew, $this->progress5->CurrentValue, NULL, strval($this->progress5->CurrentValue) == "");

		// stage6
		$this->stage6->SetDbValueDef($rsnew, $this->stage6->CurrentValue, NULL, strval($this->stage6->CurrentValue) == "");

		// progress6
		$this->progress6->SetDbValueDef($rsnew, $this->progress6->CurrentValue, NULL, strval($this->progress6->CurrentValue) == "");

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
		$Breadcrumb->Add("list", "<span id=\"ewPageCaption\">" . $PageCaption . "</span>", "processflow_tblist.php", $this->TableVar);
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
if (!isset($processflow_tb_add)) $processflow_tb_add = new cprocessflow_tb_add();

// Page init
$processflow_tb_add->Page_Init();

// Page main
$processflow_tb_add->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$processflow_tb_add->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Page object
var processflow_tb_add = new ew_Page("processflow_tb_add");
processflow_tb_add.PageID = "add"; // Page ID
var EW_PAGE_ID = processflow_tb_add.PageID; // For backward compatibility

// Form object
var fprocessflow_tbadd = new ew_Form("fprocessflow_tbadd");

// Validate form
fprocessflow_tbadd.Validate = function() {
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
				return this.OnError(elm, "<?php echo ew_JsEncode2($processflow_tb->uid->FldErrMsg()) ?>");

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
fprocessflow_tbadd.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
fprocessflow_tbadd.ValidateRequired = true;
<?php } else { ?>
fprocessflow_tbadd.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
// Form object for search

</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<?php $Breadcrumb->Render(); ?>
<?php $processflow_tb_add->ShowPageHeader(); ?>
<?php
$processflow_tb_add->ShowMessage();
?>
<form name="fprocessflow_tbadd" id="fprocessflow_tbadd" class="ewForm form-horizontal" action="<?php echo ew_CurrentPage() ?>" method="post">
<input type="hidden" name="t" value="processflow_tb">
<input type="hidden" name="a_add" id="a_add" value="A">
<table cellspacing="0" class="ewGrid"><tr><td>
<table id="tbl_processflow_tbadd" class="table table-bordered table-striped">
<?php if ($processflow_tb->uid->Visible) { // uid ?>
	<tr id="r_uid">
		<td><span id="elh_processflow_tb_uid"><?php echo $processflow_tb->uid->FldCaption() ?></span></td>
		<td<?php echo $processflow_tb->uid->CellAttributes() ?>>
<span id="el_processflow_tb_uid" class="control-group">
<input type="text" data-field="x_uid" name="x_uid" id="x_uid" size="30" placeholder="<?php echo $processflow_tb->uid->PlaceHolder ?>" value="<?php echo $processflow_tb->uid->EditValue ?>"<?php echo $processflow_tb->uid->EditAttributes() ?>>
</span>
<?php echo $processflow_tb->uid->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($processflow_tb->name->Visible) { // name ?>
	<tr id="r_name">
		<td><span id="elh_processflow_tb_name"><?php echo $processflow_tb->name->FldCaption() ?></span></td>
		<td<?php echo $processflow_tb->name->CellAttributes() ?>>
<span id="el_processflow_tb_name" class="control-group">
<input type="text" data-field="x_name" name="x_name" id="x_name" size="30" maxlength="100" placeholder="<?php echo $processflow_tb->name->PlaceHolder ?>" value="<?php echo $processflow_tb->name->EditValue ?>"<?php echo $processflow_tb->name->EditAttributes() ?>>
</span>
<?php echo $processflow_tb->name->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($processflow_tb->_email->Visible) { // email ?>
	<tr id="r__email">
		<td><span id="elh_processflow_tb__email"><?php echo $processflow_tb->_email->FldCaption() ?></span></td>
		<td<?php echo $processflow_tb->_email->CellAttributes() ?>>
<span id="el_processflow_tb__email" class="control-group">
<input type="text" data-field="x__email" name="x__email" id="x__email" size="30" maxlength="50" placeholder="<?php echo $processflow_tb->_email->PlaceHolder ?>" value="<?php echo $processflow_tb->_email->EditValue ?>"<?php echo $processflow_tb->_email->EditAttributes() ?>>
</span>
<?php echo $processflow_tb->_email->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($processflow_tb->stage->Visible) { // stage ?>
	<tr id="r_stage">
		<td><span id="elh_processflow_tb_stage"><?php echo $processflow_tb->stage->FldCaption() ?></span></td>
		<td<?php echo $processflow_tb->stage->CellAttributes() ?>>
<span id="el_processflow_tb_stage" class="control-group">
<input type="text" data-field="x_stage" name="x_stage" id="x_stage" size="30" maxlength="100" placeholder="<?php echo $processflow_tb->stage->PlaceHolder ?>" value="<?php echo $processflow_tb->stage->EditValue ?>"<?php echo $processflow_tb->stage->EditAttributes() ?>>
</span>
<?php echo $processflow_tb->stage->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($processflow_tb->progress->Visible) { // progress ?>
	<tr id="r_progress">
		<td><span id="elh_processflow_tb_progress"><?php echo $processflow_tb->progress->FldCaption() ?></span></td>
		<td<?php echo $processflow_tb->progress->CellAttributes() ?>>
<span id="el_processflow_tb_progress" class="control-group">
<select data-field="x_progress" id="x_progress" name="x_progress"<?php echo $processflow_tb->progress->EditAttributes() ?>>
<?php
if (is_array($processflow_tb->progress->EditValue)) {
	$arwrk = $processflow_tb->progress->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($processflow_tb->progress->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " selected=\"selected\"" : "";
		if ($selwrk <> "") $emptywrk = FALSE;
?>
<option value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?>>
<?php echo $arwrk[$rowcntwrk][1] ?>
</option>
<?php
	}
}
?>
</select>
</span>
<?php echo $processflow_tb->progress->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($processflow_tb->stage2->Visible) { // stage2 ?>
	<tr id="r_stage2">
		<td><span id="elh_processflow_tb_stage2"><?php echo $processflow_tb->stage2->FldCaption() ?></span></td>
		<td<?php echo $processflow_tb->stage2->CellAttributes() ?>>
<span id="el_processflow_tb_stage2" class="control-group">
<input type="text" data-field="x_stage2" name="x_stage2" id="x_stage2" size="30" maxlength="100" placeholder="<?php echo $processflow_tb->stage2->PlaceHolder ?>" value="<?php echo $processflow_tb->stage2->EditValue ?>"<?php echo $processflow_tb->stage2->EditAttributes() ?>>
</span>
<?php echo $processflow_tb->stage2->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($processflow_tb->progress2->Visible) { // progress2 ?>
	<tr id="r_progress2">
		<td><span id="elh_processflow_tb_progress2"><?php echo $processflow_tb->progress2->FldCaption() ?></span></td>
		<td<?php echo $processflow_tb->progress2->CellAttributes() ?>>
<span id="el_processflow_tb_progress2" class="control-group">
<select data-field="x_progress2" id="x_progress2" name="x_progress2"<?php echo $processflow_tb->progress2->EditAttributes() ?>>
<?php
if (is_array($processflow_tb->progress2->EditValue)) {
	$arwrk = $processflow_tb->progress2->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($processflow_tb->progress2->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " selected=\"selected\"" : "";
		if ($selwrk <> "") $emptywrk = FALSE;
?>
<option value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?>>
<?php echo $arwrk[$rowcntwrk][1] ?>
</option>
<?php
	}
}
?>
</select>
</span>
<?php echo $processflow_tb->progress2->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($processflow_tb->stage3->Visible) { // stage3 ?>
	<tr id="r_stage3">
		<td><span id="elh_processflow_tb_stage3"><?php echo $processflow_tb->stage3->FldCaption() ?></span></td>
		<td<?php echo $processflow_tb->stage3->CellAttributes() ?>>
<span id="el_processflow_tb_stage3" class="control-group">
<input type="text" data-field="x_stage3" name="x_stage3" id="x_stage3" size="30" maxlength="100" placeholder="<?php echo $processflow_tb->stage3->PlaceHolder ?>" value="<?php echo $processflow_tb->stage3->EditValue ?>"<?php echo $processflow_tb->stage3->EditAttributes() ?>>
</span>
<?php echo $processflow_tb->stage3->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($processflow_tb->progress3->Visible) { // progress3 ?>
	<tr id="r_progress3">
		<td><span id="elh_processflow_tb_progress3"><?php echo $processflow_tb->progress3->FldCaption() ?></span></td>
		<td<?php echo $processflow_tb->progress3->CellAttributes() ?>>
<span id="el_processflow_tb_progress3" class="control-group">
<select data-field="x_progress3" id="x_progress3" name="x_progress3"<?php echo $processflow_tb->progress3->EditAttributes() ?>>
<?php
if (is_array($processflow_tb->progress3->EditValue)) {
	$arwrk = $processflow_tb->progress3->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($processflow_tb->progress3->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " selected=\"selected\"" : "";
		if ($selwrk <> "") $emptywrk = FALSE;
?>
<option value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?>>
<?php echo $arwrk[$rowcntwrk][1] ?>
</option>
<?php
	}
}
?>
</select>
</span>
<?php echo $processflow_tb->progress3->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($processflow_tb->stage4->Visible) { // stage4 ?>
	<tr id="r_stage4">
		<td><span id="elh_processflow_tb_stage4"><?php echo $processflow_tb->stage4->FldCaption() ?></span></td>
		<td<?php echo $processflow_tb->stage4->CellAttributes() ?>>
<span id="el_processflow_tb_stage4" class="control-group">
<input type="text" data-field="x_stage4" name="x_stage4" id="x_stage4" size="30" maxlength="100" placeholder="<?php echo $processflow_tb->stage4->PlaceHolder ?>" value="<?php echo $processflow_tb->stage4->EditValue ?>"<?php echo $processflow_tb->stage4->EditAttributes() ?>>
</span>
<?php echo $processflow_tb->stage4->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($processflow_tb->progress4->Visible) { // progress4 ?>
	<tr id="r_progress4">
		<td><span id="elh_processflow_tb_progress4"><?php echo $processflow_tb->progress4->FldCaption() ?></span></td>
		<td<?php echo $processflow_tb->progress4->CellAttributes() ?>>
<span id="el_processflow_tb_progress4" class="control-group">
<select data-field="x_progress4" id="x_progress4" name="x_progress4"<?php echo $processflow_tb->progress4->EditAttributes() ?>>
<?php
if (is_array($processflow_tb->progress4->EditValue)) {
	$arwrk = $processflow_tb->progress4->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($processflow_tb->progress4->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " selected=\"selected\"" : "";
		if ($selwrk <> "") $emptywrk = FALSE;
?>
<option value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?>>
<?php echo $arwrk[$rowcntwrk][1] ?>
</option>
<?php
	}
}
?>
</select>
</span>
<?php echo $processflow_tb->progress4->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($processflow_tb->stage5->Visible) { // stage5 ?>
	<tr id="r_stage5">
		<td><span id="elh_processflow_tb_stage5"><?php echo $processflow_tb->stage5->FldCaption() ?></span></td>
		<td<?php echo $processflow_tb->stage5->CellAttributes() ?>>
<span id="el_processflow_tb_stage5" class="control-group">
<input type="text" data-field="x_stage5" name="x_stage5" id="x_stage5" size="30" maxlength="100" placeholder="<?php echo $processflow_tb->stage5->PlaceHolder ?>" value="<?php echo $processflow_tb->stage5->EditValue ?>"<?php echo $processflow_tb->stage5->EditAttributes() ?>>
</span>
<?php echo $processflow_tb->stage5->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($processflow_tb->progress5->Visible) { // progress5 ?>
	<tr id="r_progress5">
		<td><span id="elh_processflow_tb_progress5"><?php echo $processflow_tb->progress5->FldCaption() ?></span></td>
		<td<?php echo $processflow_tb->progress5->CellAttributes() ?>>
<span id="el_processflow_tb_progress5" class="control-group">
<select data-field="x_progress5" id="x_progress5" name="x_progress5"<?php echo $processflow_tb->progress5->EditAttributes() ?>>
<?php
if (is_array($processflow_tb->progress5->EditValue)) {
	$arwrk = $processflow_tb->progress5->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($processflow_tb->progress5->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " selected=\"selected\"" : "";
		if ($selwrk <> "") $emptywrk = FALSE;
?>
<option value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?>>
<?php echo $arwrk[$rowcntwrk][1] ?>
</option>
<?php
	}
}
?>
</select>
</span>
<?php echo $processflow_tb->progress5->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($processflow_tb->stage6->Visible) { // stage6 ?>
	<tr id="r_stage6">
		<td><span id="elh_processflow_tb_stage6"><?php echo $processflow_tb->stage6->FldCaption() ?></span></td>
		<td<?php echo $processflow_tb->stage6->CellAttributes() ?>>
<span id="el_processflow_tb_stage6" class="control-group">
<input type="text" data-field="x_stage6" name="x_stage6" id="x_stage6" size="30" maxlength="100" placeholder="<?php echo $processflow_tb->stage6->PlaceHolder ?>" value="<?php echo $processflow_tb->stage6->EditValue ?>"<?php echo $processflow_tb->stage6->EditAttributes() ?>>
</span>
<?php echo $processflow_tb->stage6->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($processflow_tb->progress6->Visible) { // progress6 ?>
	<tr id="r_progress6">
		<td><span id="elh_processflow_tb_progress6"><?php echo $processflow_tb->progress6->FldCaption() ?></span></td>
		<td<?php echo $processflow_tb->progress6->CellAttributes() ?>>
<span id="el_processflow_tb_progress6" class="control-group">
<select data-field="x_progress6" id="x_progress6" name="x_progress6"<?php echo $processflow_tb->progress6->EditAttributes() ?>>
<?php
if (is_array($processflow_tb->progress6->EditValue)) {
	$arwrk = $processflow_tb->progress6->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($processflow_tb->progress6->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " selected=\"selected\"" : "";
		if ($selwrk <> "") $emptywrk = FALSE;
?>
<option value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?>>
<?php echo $arwrk[$rowcntwrk][1] ?>
</option>
<?php
	}
}
?>
</select>
</span>
<?php echo $processflow_tb->progress6->CustomMsg ?></td>
	</tr>
<?php } ?>
</table>
</td></tr></table>
<button class="btn btn-primary ewButton" name="btnAction" id="btnAction" type="submit"><?php echo $Language->Phrase("AddBtn") ?></button>
</form>
<script type="text/javascript">
fprocessflow_tbadd.Init();
<?php if (EW_MOBILE_REFLOW && ew_IsMobile()) { ?>
ew_Reflow();
<?php } ?>
</script>
<?php
$processflow_tb_add->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$processflow_tb_add->Page_Terminate();
?>
