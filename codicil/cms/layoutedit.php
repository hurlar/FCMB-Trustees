<?php
if (session_id() == "") session_start(); // Initialize Session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg10.php" ?>
<?php include_once "ewmysql10.php" ?>
<?php include_once "phpfn10.php" ?>
<?php include_once "layoutinfo.php" ?>
<?php include_once "adminusersinfo.php" ?>
<?php include_once "userfn10.php" ?>
<?php

//
// Page class
//

$layout_edit = NULL; // Initialize page object first

class clayout_edit extends clayout {

	// Page ID
	var $PageID = 'edit';

	// Project ID
	var $ProjectID = "{D9B361E7-B2C1-4293-B9B3-B581986A15CC}";

	// Table name
	var $TableName = 'layout';

	// Page object name
	var $PageObjName = 'layout_edit';

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

		// Table object (layout)
		if (!isset($GLOBALS["layout"])) {
			$GLOBALS["layout"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["layout"];
		}

		// Table object (adminusers)
		if (!isset($GLOBALS['adminusers'])) $GLOBALS['adminusers'] = new cadminusers();

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'edit', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'layout', TRUE);

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
			$this->Page_Terminate("layoutlist.php"); // Return to list page
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
					$this->Page_Terminate("layoutlist.php"); // Return to list page
				} else {
					$this->LoadRowValues($this->Recordset); // Load row values
				}
				break;
			Case "U": // Update
				$this->SendEmail = TRUE; // Send email on update success
				if ($this->EditRow()) { // Update record based on key
					if ($this->getSuccessMessage() == "")
						$this->setSuccessMessage($Language->Phrase("UpdateSuccess")); // Update success
					$sReturnUrl = $this->GetViewUrl();
					if (ew_GetPageName($sReturnUrl) == "layoutview.php")
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
		$this->slide1->Upload->Index = $objForm->Index;
		if ($this->slide1->Upload->UploadFile()) {

			// No action required
		} else {
			echo $this->slide1->Upload->Message;
			$this->Page_Terminate();
			exit();
		}
		$this->slide1->CurrentValue = $this->slide1->Upload->FileName;
		$this->slide2->Upload->Index = $objForm->Index;
		if ($this->slide2->Upload->UploadFile()) {

			// No action required
		} else {
			echo $this->slide2->Upload->Message;
			$this->Page_Terminate();
			exit();
		}
		$this->slide2->CurrentValue = $this->slide2->Upload->FileName;
		$this->slide3->Upload->Index = $objForm->Index;
		if ($this->slide3->Upload->UploadFile()) {

			// No action required
		} else {
			echo $this->slide3->Upload->Message;
			$this->Page_Terminate();
			exit();
		}
		$this->slide3->CurrentValue = $this->slide3->Upload->FileName;
		$this->slide4->Upload->Index = $objForm->Index;
		if ($this->slide4->Upload->UploadFile()) {

			// No action required
		} else {
			echo $this->slide4->Upload->Message;
			$this->Page_Terminate();
			exit();
		}
		$this->slide4->CurrentValue = $this->slide4->Upload->FileName;
		$this->slide5->Upload->Index = $objForm->Index;
		if ($this->slide5->Upload->UploadFile()) {

			// No action required
		} else {
			echo $this->slide5->Upload->Message;
			$this->Page_Terminate();
			exit();
		}
		$this->slide5->CurrentValue = $this->slide5->Upload->FileName;
		$this->slide6->Upload->Index = $objForm->Index;
		if ($this->slide6->Upload->UploadFile()) {

			// No action required
		} else {
			echo $this->slide6->Upload->Message;
			$this->Page_Terminate();
			exit();
		}
		$this->slide6->CurrentValue = $this->slide6->Upload->FileName;
	}

	// Load form values
	function LoadFormValues() {

		// Load from form
		global $objForm;
		$this->GetUploadFiles(); // Get upload files
		if (!$this->id->FldIsDetailKey)
			$this->id->setFormValue($objForm->GetValue("x_id"));
		if (!$this->top2Dl->FldIsDetailKey) {
			$this->top2Dl->setFormValue($objForm->GetValue("x_top2Dl"));
		}
		if (!$this->top2Dr->FldIsDetailKey) {
			$this->top2Dr->setFormValue($objForm->GetValue("x_top2Dr"));
		}
		if (!$this->head2Dl->FldIsDetailKey) {
			$this->head2Dl->setFormValue($objForm->GetValue("x_head2Dl"));
		}
		if (!$this->head2Dr->FldIsDetailKey) {
			$this->head2Dr->setFormValue($objForm->GetValue("x_head2Dr"));
		}
		if (!$this->home2Dcaption1->FldIsDetailKey) {
			$this->home2Dcaption1->setFormValue($objForm->GetValue("x_home2Dcaption1"));
		}
		if (!$this->home2Dtext1->FldIsDetailKey) {
			$this->home2Dtext1->setFormValue($objForm->GetValue("x_home2Dtext1"));
		}
		if (!$this->home2Dcaption2->FldIsDetailKey) {
			$this->home2Dcaption2->setFormValue($objForm->GetValue("x_home2Dcaption2"));
		}
		if (!$this->home2Dtext2->FldIsDetailKey) {
			$this->home2Dtext2->setFormValue($objForm->GetValue("x_home2Dtext2"));
		}
		if (!$this->home2Dcaption3->FldIsDetailKey) {
			$this->home2Dcaption3->setFormValue($objForm->GetValue("x_home2Dcaption3"));
		}
		if (!$this->home2Dtext3->FldIsDetailKey) {
			$this->home2Dtext3->setFormValue($objForm->GetValue("x_home2Dtext3"));
		}
		if (!$this->home2Dcaption4->FldIsDetailKey) {
			$this->home2Dcaption4->setFormValue($objForm->GetValue("x_home2Dcaption4"));
		}
		if (!$this->home2Dtext4->FldIsDetailKey) {
			$this->home2Dtext4->setFormValue($objForm->GetValue("x_home2Dtext4"));
		}
		if (!$this->home2Dcaption5->FldIsDetailKey) {
			$this->home2Dcaption5->setFormValue($objForm->GetValue("x_home2Dcaption5"));
		}
		if (!$this->home2Dtext5->FldIsDetailKey) {
			$this->home2Dtext5->setFormValue($objForm->GetValue("x_home2Dtext5"));
		}
		if (!$this->home2Dcaption6->FldIsDetailKey) {
			$this->home2Dcaption6->setFormValue($objForm->GetValue("x_home2Dcaption6"));
		}
		if (!$this->home2Dtext6->FldIsDetailKey) {
			$this->home2Dtext6->setFormValue($objForm->GetValue("x_home2Dtext6"));
		}
		if (!$this->footer2D1->FldIsDetailKey) {
			$this->footer2D1->setFormValue($objForm->GetValue("x_footer2D1"));
		}
		if (!$this->footer2D2->FldIsDetailKey) {
			$this->footer2D2->setFormValue($objForm->GetValue("x_footer2D2"));
		}
		if (!$this->footer2D3->FldIsDetailKey) {
			$this->footer2D3->setFormValue($objForm->GetValue("x_footer2D3"));
		}
		if (!$this->footer2D4->FldIsDetailKey) {
			$this->footer2D4->setFormValue($objForm->GetValue("x_footer2D4"));
		}
		if (!$this->contact2Demail->FldIsDetailKey) {
			$this->contact2Demail->setFormValue($objForm->GetValue("x_contact2Demail"));
		}
		if (!$this->contact2Dtext1->FldIsDetailKey) {
			$this->contact2Dtext1->setFormValue($objForm->GetValue("x_contact2Dtext1"));
		}
		if (!$this->contact2Dtext2->FldIsDetailKey) {
			$this->contact2Dtext2->setFormValue($objForm->GetValue("x_contact2Dtext2"));
		}
		if (!$this->contact2Dtext3->FldIsDetailKey) {
			$this->contact2Dtext3->setFormValue($objForm->GetValue("x_contact2Dtext3"));
		}
		if (!$this->contact2Dtext4->FldIsDetailKey) {
			$this->contact2Dtext4->setFormValue($objForm->GetValue("x_contact2Dtext4"));
		}
	}

	// Restore form values
	function RestoreFormValues() {
		global $objForm;
		$this->LoadRow();
		$this->id->CurrentValue = $this->id->FormValue;
		$this->top2Dl->CurrentValue = $this->top2Dl->FormValue;
		$this->top2Dr->CurrentValue = $this->top2Dr->FormValue;
		$this->head2Dl->CurrentValue = $this->head2Dl->FormValue;
		$this->head2Dr->CurrentValue = $this->head2Dr->FormValue;
		$this->home2Dcaption1->CurrentValue = $this->home2Dcaption1->FormValue;
		$this->home2Dtext1->CurrentValue = $this->home2Dtext1->FormValue;
		$this->home2Dcaption2->CurrentValue = $this->home2Dcaption2->FormValue;
		$this->home2Dtext2->CurrentValue = $this->home2Dtext2->FormValue;
		$this->home2Dcaption3->CurrentValue = $this->home2Dcaption3->FormValue;
		$this->home2Dtext3->CurrentValue = $this->home2Dtext3->FormValue;
		$this->home2Dcaption4->CurrentValue = $this->home2Dcaption4->FormValue;
		$this->home2Dtext4->CurrentValue = $this->home2Dtext4->FormValue;
		$this->home2Dcaption5->CurrentValue = $this->home2Dcaption5->FormValue;
		$this->home2Dtext5->CurrentValue = $this->home2Dtext5->FormValue;
		$this->home2Dcaption6->CurrentValue = $this->home2Dcaption6->FormValue;
		$this->home2Dtext6->CurrentValue = $this->home2Dtext6->FormValue;
		$this->footer2D1->CurrentValue = $this->footer2D1->FormValue;
		$this->footer2D2->CurrentValue = $this->footer2D2->FormValue;
		$this->footer2D3->CurrentValue = $this->footer2D3->FormValue;
		$this->footer2D4->CurrentValue = $this->footer2D4->FormValue;
		$this->contact2Demail->CurrentValue = $this->contact2Demail->FormValue;
		$this->contact2Dtext1->CurrentValue = $this->contact2Dtext1->FormValue;
		$this->contact2Dtext2->CurrentValue = $this->contact2Dtext2->FormValue;
		$this->contact2Dtext3->CurrentValue = $this->contact2Dtext3->FormValue;
		$this->contact2Dtext4->CurrentValue = $this->contact2Dtext4->FormValue;
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
		$this->logo->setDbValue($rs->fields('logo'));
		$this->url->setDbValue($rs->fields('url'));
		$this->meta2Dtitle->setDbValue($rs->fields('meta-title'));
		$this->meta2Dkeywords->setDbValue($rs->fields('meta-keywords'));
		$this->meta2Ddescp->setDbValue($rs->fields('meta-descp'));
		$this->top2Dl->setDbValue($rs->fields('top-l'));
		$this->top2Dr->setDbValue($rs->fields('top-r'));
		$this->head2Dl->setDbValue($rs->fields('head-l'));
		$this->head2Dr->setDbValue($rs->fields('head-r'));
		$this->slide1->Upload->DbValue = $rs->fields('slide1');
		$this->slide2->Upload->DbValue = $rs->fields('slide2');
		$this->slide3->Upload->DbValue = $rs->fields('slide3');
		$this->slide4->Upload->DbValue = $rs->fields('slide4');
		$this->slide5->Upload->DbValue = $rs->fields('slide5');
		$this->slide6->Upload->DbValue = $rs->fields('slide6');
		$this->nav2Dtext->setDbValue($rs->fields('nav-text'));
		$this->slide2Dbox->setDbValue($rs->fields('slide-box'));
		$this->custom2Dcss->setDbValue($rs->fields('custom-css'));
		$this->home2Dcaption1->setDbValue($rs->fields('home-caption1'));
		$this->home2Dtext1->setDbValue($rs->fields('home-text1'));
		$this->home2Dcaption2->setDbValue($rs->fields('home-caption2'));
		$this->home2Dtext2->setDbValue($rs->fields('home-text2'));
		$this->home2Dcaption3->setDbValue($rs->fields('home-caption3'));
		$this->home2Dtext3->setDbValue($rs->fields('home-text3'));
		$this->home2Dcaption4->setDbValue($rs->fields('home-caption4'));
		$this->home2Dtext4->setDbValue($rs->fields('home-text4'));
		$this->home2Dcaption5->setDbValue($rs->fields('home-caption5'));
		$this->home2Dtext5->setDbValue($rs->fields('home-text5'));
		$this->home2Dcaption6->setDbValue($rs->fields('home-caption6'));
		$this->home2Dtext6->setDbValue($rs->fields('home-text6'));
		$this->footer2D1->setDbValue($rs->fields('footer-1'));
		$this->footer2D2->setDbValue($rs->fields('footer-2'));
		$this->footer2D3->setDbValue($rs->fields('footer-3'));
		$this->footer2D4->setDbValue($rs->fields('footer-4'));
		$this->base2Dl->setDbValue($rs->fields('base-l'));
		$this->base2Dr->setDbValue($rs->fields('base-r'));
		$this->contact2Demail->setDbValue($rs->fields('contact-email'));
		$this->contact2Dtext1->setDbValue($rs->fields('contact-text1'));
		$this->contact2Dtext2->setDbValue($rs->fields('contact-text2'));
		$this->contact2Dtext3->setDbValue($rs->fields('contact-text3'));
		$this->contact2Dtext4->setDbValue($rs->fields('contact-text4'));
		$this->google2Dmap->setDbValue($rs->fields('google-map'));
		$this->fb2Dlikebox->setDbValue($rs->fields('fb-likebox'));
	}

	// Load DbValue from recordset
	function LoadDbValues(&$rs) {
		if (!$rs || !is_array($rs) && $rs->EOF) return;
		$row = is_array($rs) ? $rs : $rs->fields;
		$this->id->DbValue = $row['id'];
		$this->logo->DbValue = $row['logo'];
		$this->url->DbValue = $row['url'];
		$this->meta2Dtitle->DbValue = $row['meta-title'];
		$this->meta2Dkeywords->DbValue = $row['meta-keywords'];
		$this->meta2Ddescp->DbValue = $row['meta-descp'];
		$this->top2Dl->DbValue = $row['top-l'];
		$this->top2Dr->DbValue = $row['top-r'];
		$this->head2Dl->DbValue = $row['head-l'];
		$this->head2Dr->DbValue = $row['head-r'];
		$this->slide1->Upload->DbValue = $row['slide1'];
		$this->slide2->Upload->DbValue = $row['slide2'];
		$this->slide3->Upload->DbValue = $row['slide3'];
		$this->slide4->Upload->DbValue = $row['slide4'];
		$this->slide5->Upload->DbValue = $row['slide5'];
		$this->slide6->Upload->DbValue = $row['slide6'];
		$this->nav2Dtext->DbValue = $row['nav-text'];
		$this->slide2Dbox->DbValue = $row['slide-box'];
		$this->custom2Dcss->DbValue = $row['custom-css'];
		$this->home2Dcaption1->DbValue = $row['home-caption1'];
		$this->home2Dtext1->DbValue = $row['home-text1'];
		$this->home2Dcaption2->DbValue = $row['home-caption2'];
		$this->home2Dtext2->DbValue = $row['home-text2'];
		$this->home2Dcaption3->DbValue = $row['home-caption3'];
		$this->home2Dtext3->DbValue = $row['home-text3'];
		$this->home2Dcaption4->DbValue = $row['home-caption4'];
		$this->home2Dtext4->DbValue = $row['home-text4'];
		$this->home2Dcaption5->DbValue = $row['home-caption5'];
		$this->home2Dtext5->DbValue = $row['home-text5'];
		$this->home2Dcaption6->DbValue = $row['home-caption6'];
		$this->home2Dtext6->DbValue = $row['home-text6'];
		$this->footer2D1->DbValue = $row['footer-1'];
		$this->footer2D2->DbValue = $row['footer-2'];
		$this->footer2D3->DbValue = $row['footer-3'];
		$this->footer2D4->DbValue = $row['footer-4'];
		$this->base2Dl->DbValue = $row['base-l'];
		$this->base2Dr->DbValue = $row['base-r'];
		$this->contact2Demail->DbValue = $row['contact-email'];
		$this->contact2Dtext1->DbValue = $row['contact-text1'];
		$this->contact2Dtext2->DbValue = $row['contact-text2'];
		$this->contact2Dtext3->DbValue = $row['contact-text3'];
		$this->contact2Dtext4->DbValue = $row['contact-text4'];
		$this->google2Dmap->DbValue = $row['google-map'];
		$this->fb2Dlikebox->DbValue = $row['fb-likebox'];
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
		// logo
		// url
		// meta-title
		// meta-keywords
		// meta-descp
		// top-l
		// top-r
		// head-l
		// head-r
		// slide1
		// slide2
		// slide3
		// slide4
		// slide5
		// slide6
		// nav-text
		// slide-box
		// custom-css
		// home-caption1
		// home-text1
		// home-caption2
		// home-text2
		// home-caption3
		// home-text3
		// home-caption4
		// home-text4
		// home-caption5
		// home-text5
		// home-caption6
		// home-text6
		// footer-1
		// footer-2
		// footer-3
		// footer-4
		// base-l
		// base-r
		// contact-email
		// contact-text1
		// contact-text2
		// contact-text3
		// contact-text4
		// google-map
		// fb-likebox

		if ($this->RowType == EW_ROWTYPE_VIEW) { // View row

			// id
			$this->id->ViewValue = $this->id->CurrentValue;
			$this->id->ViewCustomAttributes = "";

			// logo
			$this->logo->ViewValue = $this->logo->CurrentValue;
			$this->logo->ViewCustomAttributes = "";

			// url
			$this->url->ViewValue = $this->url->CurrentValue;
			$this->url->ViewCustomAttributes = "";

			// meta-title
			$this->meta2Dtitle->ViewValue = $this->meta2Dtitle->CurrentValue;
			$this->meta2Dtitle->ViewCustomAttributes = "";

			// meta-keywords
			$this->meta2Dkeywords->ViewValue = $this->meta2Dkeywords->CurrentValue;
			$this->meta2Dkeywords->ViewCustomAttributes = "";

			// meta-descp
			$this->meta2Ddescp->ViewValue = $this->meta2Ddescp->CurrentValue;
			$this->meta2Ddescp->ViewCustomAttributes = "";

			// top-l
			$this->top2Dl->ViewValue = $this->top2Dl->CurrentValue;
			$this->top2Dl->ViewCustomAttributes = "";

			// top-r
			$this->top2Dr->ViewValue = $this->top2Dr->CurrentValue;
			$this->top2Dr->ViewCustomAttributes = "";

			// head-l
			$this->head2Dl->ViewValue = $this->head2Dl->CurrentValue;
			$this->head2Dl->ViewCustomAttributes = "";

			// head-r
			$this->head2Dr->ViewValue = $this->head2Dr->CurrentValue;
			$this->head2Dr->ViewCustomAttributes = "";

			// slide1
			$this->slide1->UploadPath = "../images/slides/";
			if (!ew_Empty($this->slide1->Upload->DbValue)) {
				$this->slide1->ViewValue = $this->slide1->Upload->DbValue;
			} else {
				$this->slide1->ViewValue = "";
			}
			$this->slide1->ViewCustomAttributes = "";

			// slide2
			$this->slide2->UploadPath = "../images/slides/";
			if (!ew_Empty($this->slide2->Upload->DbValue)) {
				$this->slide2->ViewValue = $this->slide2->Upload->DbValue;
			} else {
				$this->slide2->ViewValue = "";
			}
			$this->slide2->ViewCustomAttributes = "";

			// slide3
			$this->slide3->UploadPath = "../images/slides/";
			if (!ew_Empty($this->slide3->Upload->DbValue)) {
				$this->slide3->ViewValue = $this->slide3->Upload->DbValue;
			} else {
				$this->slide3->ViewValue = "";
			}
			$this->slide3->ViewCustomAttributes = "";

			// slide4
			$this->slide4->UploadPath = "../images/slides/";
			if (!ew_Empty($this->slide4->Upload->DbValue)) {
				$this->slide4->ViewValue = $this->slide4->Upload->DbValue;
			} else {
				$this->slide4->ViewValue = "";
			}
			$this->slide4->ViewCustomAttributes = "";

			// slide5
			$this->slide5->UploadPath = "../images/slides/";
			if (!ew_Empty($this->slide5->Upload->DbValue)) {
				$this->slide5->ViewValue = $this->slide5->Upload->DbValue;
			} else {
				$this->slide5->ViewValue = "";
			}
			$this->slide5->ViewCustomAttributes = "";

			// slide6
			$this->slide6->UploadPath = "../images/slides/";
			if (!ew_Empty($this->slide6->Upload->DbValue)) {
				$this->slide6->ViewValue = $this->slide6->Upload->DbValue;
			} else {
				$this->slide6->ViewValue = "";
			}
			$this->slide6->ViewCustomAttributes = "";

			// nav-text
			$this->nav2Dtext->ViewValue = $this->nav2Dtext->CurrentValue;
			$this->nav2Dtext->ViewCustomAttributes = "";

			// slide-box
			$this->slide2Dbox->ViewValue = $this->slide2Dbox->CurrentValue;
			$this->slide2Dbox->ViewCustomAttributes = "";

			// custom-css
			$this->custom2Dcss->ViewValue = $this->custom2Dcss->CurrentValue;
			$this->custom2Dcss->ViewCustomAttributes = "";

			// home-caption1
			$this->home2Dcaption1->ViewValue = $this->home2Dcaption1->CurrentValue;
			$this->home2Dcaption1->ViewCustomAttributes = "";

			// home-text1
			$this->home2Dtext1->ViewValue = $this->home2Dtext1->CurrentValue;
			$this->home2Dtext1->ViewCustomAttributes = "";

			// home-caption2
			$this->home2Dcaption2->ViewValue = $this->home2Dcaption2->CurrentValue;
			$this->home2Dcaption2->ViewCustomAttributes = "";

			// home-text2
			$this->home2Dtext2->ViewValue = $this->home2Dtext2->CurrentValue;
			$this->home2Dtext2->ViewCustomAttributes = "";

			// home-caption3
			$this->home2Dcaption3->ViewValue = $this->home2Dcaption3->CurrentValue;
			$this->home2Dcaption3->ViewCustomAttributes = "";

			// home-text3
			$this->home2Dtext3->ViewValue = $this->home2Dtext3->CurrentValue;
			$this->home2Dtext3->ViewCustomAttributes = "";

			// home-caption4
			$this->home2Dcaption4->ViewValue = $this->home2Dcaption4->CurrentValue;
			$this->home2Dcaption4->ViewCustomAttributes = "";

			// home-text4
			$this->home2Dtext4->ViewValue = $this->home2Dtext4->CurrentValue;
			$this->home2Dtext4->ViewCustomAttributes = "";

			// home-caption5
			$this->home2Dcaption5->ViewValue = $this->home2Dcaption5->CurrentValue;
			$this->home2Dcaption5->ViewCustomAttributes = "";

			// home-text5
			$this->home2Dtext5->ViewValue = $this->home2Dtext5->CurrentValue;
			$this->home2Dtext5->ViewCustomAttributes = "";

			// home-caption6
			$this->home2Dcaption6->ViewValue = $this->home2Dcaption6->CurrentValue;
			$this->home2Dcaption6->ViewCustomAttributes = "";

			// home-text6
			$this->home2Dtext6->ViewValue = $this->home2Dtext6->CurrentValue;
			$this->home2Dtext6->ViewCustomAttributes = "";

			// footer-1
			$this->footer2D1->ViewValue = $this->footer2D1->CurrentValue;
			$this->footer2D1->ViewCustomAttributes = "";

			// footer-2
			$this->footer2D2->ViewValue = $this->footer2D2->CurrentValue;
			$this->footer2D2->ViewCustomAttributes = "";

			// footer-3
			$this->footer2D3->ViewValue = $this->footer2D3->CurrentValue;
			$this->footer2D3->ViewCustomAttributes = "";

			// footer-4
			$this->footer2D4->ViewValue = $this->footer2D4->CurrentValue;
			$this->footer2D4->ViewCustomAttributes = "";

			// base-l
			$this->base2Dl->ViewValue = $this->base2Dl->CurrentValue;
			$this->base2Dl->ViewCustomAttributes = "";

			// base-r
			$this->base2Dr->ViewValue = $this->base2Dr->CurrentValue;
			$this->base2Dr->ViewCustomAttributes = "";

			// contact-email
			$this->contact2Demail->ViewValue = $this->contact2Demail->CurrentValue;
			$this->contact2Demail->ViewCustomAttributes = "";

			// contact-text1
			$this->contact2Dtext1->ViewValue = $this->contact2Dtext1->CurrentValue;
			$this->contact2Dtext1->ViewCustomAttributes = "";

			// contact-text2
			$this->contact2Dtext2->ViewValue = $this->contact2Dtext2->CurrentValue;
			$this->contact2Dtext2->ViewCustomAttributes = "";

			// contact-text3
			$this->contact2Dtext3->ViewValue = $this->contact2Dtext3->CurrentValue;
			$this->contact2Dtext3->ViewCustomAttributes = "";

			// contact-text4
			$this->contact2Dtext4->ViewValue = $this->contact2Dtext4->CurrentValue;
			$this->contact2Dtext4->ViewCustomAttributes = "";

			// google-map
			$this->google2Dmap->ViewValue = $this->google2Dmap->CurrentValue;
			$this->google2Dmap->ViewCustomAttributes = "";

			// fb-likebox
			$this->fb2Dlikebox->ViewValue = $this->fb2Dlikebox->CurrentValue;
			$this->fb2Dlikebox->ViewCustomAttributes = "";

			// id
			$this->id->LinkCustomAttributes = "";
			$this->id->HrefValue = "";
			$this->id->TooltipValue = "";

			// top-l
			$this->top2Dl->LinkCustomAttributes = "";
			$this->top2Dl->HrefValue = "";
			$this->top2Dl->TooltipValue = "";

			// top-r
			$this->top2Dr->LinkCustomAttributes = "";
			$this->top2Dr->HrefValue = "";
			$this->top2Dr->TooltipValue = "";

			// head-l
			$this->head2Dl->LinkCustomAttributes = "";
			$this->head2Dl->HrefValue = "";
			$this->head2Dl->TooltipValue = "";

			// head-r
			$this->head2Dr->LinkCustomAttributes = "";
			$this->head2Dr->HrefValue = "";
			$this->head2Dr->TooltipValue = "";

			// slide1
			$this->slide1->LinkCustomAttributes = "";
			$this->slide1->UploadPath = "../images/slides/";
			if (!ew_Empty($this->slide1->Upload->DbValue)) {
				$this->slide1->HrefValue = ew_UploadPathEx(FALSE, $this->slide1->UploadPath) . $this->slide1->Upload->DbValue; // Add prefix/suffix
				$this->slide1->LinkAttrs["target"] = "_blank"; // Add target
				if ($this->Export <> "") $this->slide1->HrefValue = ew_ConvertFullUrl($this->slide1->HrefValue);
			} else {
				$this->slide1->HrefValue = "";
			}
			$this->slide1->HrefValue2 = $this->slide1->UploadPath . $this->slide1->Upload->DbValue;
			$this->slide1->TooltipValue = "";

			// slide2
			$this->slide2->LinkCustomAttributes = "";
			$this->slide2->UploadPath = "../images/slides/";
			if (!ew_Empty($this->slide2->Upload->DbValue)) {
				$this->slide2->HrefValue = ew_UploadPathEx(FALSE, $this->slide2->UploadPath) . $this->slide2->Upload->DbValue; // Add prefix/suffix
				$this->slide2->LinkAttrs["target"] = "_blank"; // Add target
				if ($this->Export <> "") $this->slide2->HrefValue = ew_ConvertFullUrl($this->slide2->HrefValue);
			} else {
				$this->slide2->HrefValue = "";
			}
			$this->slide2->HrefValue2 = $this->slide2->UploadPath . $this->slide2->Upload->DbValue;
			$this->slide2->TooltipValue = "";

			// slide3
			$this->slide3->LinkCustomAttributes = "";
			$this->slide3->UploadPath = "../images/slides/";
			if (!ew_Empty($this->slide3->Upload->DbValue)) {
				$this->slide3->HrefValue = ew_UploadPathEx(FALSE, $this->slide3->UploadPath) . $this->slide3->Upload->DbValue; // Add prefix/suffix
				$this->slide3->LinkAttrs["target"] = "_blank"; // Add target
				if ($this->Export <> "") $this->slide3->HrefValue = ew_ConvertFullUrl($this->slide3->HrefValue);
			} else {
				$this->slide3->HrefValue = "";
			}
			$this->slide3->HrefValue2 = $this->slide3->UploadPath . $this->slide3->Upload->DbValue;
			$this->slide3->TooltipValue = "";

			// slide4
			$this->slide4->LinkCustomAttributes = "";
			$this->slide4->UploadPath = "../images/slides/";
			if (!ew_Empty($this->slide4->Upload->DbValue)) {
				$this->slide4->HrefValue = ew_UploadPathEx(FALSE, $this->slide4->UploadPath) . $this->slide4->Upload->DbValue; // Add prefix/suffix
				$this->slide4->LinkAttrs["target"] = "_blank"; // Add target
				if ($this->Export <> "") $this->slide4->HrefValue = ew_ConvertFullUrl($this->slide4->HrefValue);
			} else {
				$this->slide4->HrefValue = "";
			}
			$this->slide4->HrefValue2 = $this->slide4->UploadPath . $this->slide4->Upload->DbValue;
			$this->slide4->TooltipValue = "";

			// slide5
			$this->slide5->LinkCustomAttributes = "";
			$this->slide5->UploadPath = "../images/slides/";
			if (!ew_Empty($this->slide5->Upload->DbValue)) {
				$this->slide5->HrefValue = ew_UploadPathEx(FALSE, $this->slide5->UploadPath) . $this->slide5->Upload->DbValue; // Add prefix/suffix
				$this->slide5->LinkAttrs["target"] = "_blank"; // Add target
				if ($this->Export <> "") $this->slide5->HrefValue = ew_ConvertFullUrl($this->slide5->HrefValue);
			} else {
				$this->slide5->HrefValue = "";
			}
			$this->slide5->HrefValue2 = $this->slide5->UploadPath . $this->slide5->Upload->DbValue;
			$this->slide5->TooltipValue = "";

			// slide6
			$this->slide6->LinkCustomAttributes = "";
			$this->slide6->UploadPath = "../images/slides/";
			if (!ew_Empty($this->slide6->Upload->DbValue)) {
				$this->slide6->HrefValue = ew_UploadPathEx(FALSE, $this->slide6->UploadPath) . $this->slide6->Upload->DbValue; // Add prefix/suffix
				$this->slide6->LinkAttrs["target"] = "_blank"; // Add target
				if ($this->Export <> "") $this->slide6->HrefValue = ew_ConvertFullUrl($this->slide6->HrefValue);
			} else {
				$this->slide6->HrefValue = "";
			}
			$this->slide6->HrefValue2 = $this->slide6->UploadPath . $this->slide6->Upload->DbValue;
			$this->slide6->TooltipValue = "";

			// home-caption1
			$this->home2Dcaption1->LinkCustomAttributes = "";
			$this->home2Dcaption1->HrefValue = "";
			$this->home2Dcaption1->TooltipValue = "";

			// home-text1
			$this->home2Dtext1->LinkCustomAttributes = "";
			$this->home2Dtext1->HrefValue = "";
			$this->home2Dtext1->TooltipValue = "";

			// home-caption2
			$this->home2Dcaption2->LinkCustomAttributes = "";
			$this->home2Dcaption2->HrefValue = "";
			$this->home2Dcaption2->TooltipValue = "";

			// home-text2
			$this->home2Dtext2->LinkCustomAttributes = "";
			$this->home2Dtext2->HrefValue = "";
			$this->home2Dtext2->TooltipValue = "";

			// home-caption3
			$this->home2Dcaption3->LinkCustomAttributes = "";
			$this->home2Dcaption3->HrefValue = "";
			$this->home2Dcaption3->TooltipValue = "";

			// home-text3
			$this->home2Dtext3->LinkCustomAttributes = "";
			$this->home2Dtext3->HrefValue = "";
			$this->home2Dtext3->TooltipValue = "";

			// home-caption4
			$this->home2Dcaption4->LinkCustomAttributes = "";
			$this->home2Dcaption4->HrefValue = "";
			$this->home2Dcaption4->TooltipValue = "";

			// home-text4
			$this->home2Dtext4->LinkCustomAttributes = "";
			$this->home2Dtext4->HrefValue = "";
			$this->home2Dtext4->TooltipValue = "";

			// home-caption5
			$this->home2Dcaption5->LinkCustomAttributes = "";
			$this->home2Dcaption5->HrefValue = "";
			$this->home2Dcaption5->TooltipValue = "";

			// home-text5
			$this->home2Dtext5->LinkCustomAttributes = "";
			$this->home2Dtext5->HrefValue = "";
			$this->home2Dtext5->TooltipValue = "";

			// home-caption6
			$this->home2Dcaption6->LinkCustomAttributes = "";
			$this->home2Dcaption6->HrefValue = "";
			$this->home2Dcaption6->TooltipValue = "";

			// home-text6
			$this->home2Dtext6->LinkCustomAttributes = "";
			$this->home2Dtext6->HrefValue = "";
			$this->home2Dtext6->TooltipValue = "";

			// footer-1
			$this->footer2D1->LinkCustomAttributes = "";
			$this->footer2D1->HrefValue = "";
			$this->footer2D1->TooltipValue = "";

			// footer-2
			$this->footer2D2->LinkCustomAttributes = "";
			$this->footer2D2->HrefValue = "";
			$this->footer2D2->TooltipValue = "";

			// footer-3
			$this->footer2D3->LinkCustomAttributes = "";
			$this->footer2D3->HrefValue = "";
			$this->footer2D3->TooltipValue = "";

			// footer-4
			$this->footer2D4->LinkCustomAttributes = "";
			$this->footer2D4->HrefValue = "";
			$this->footer2D4->TooltipValue = "";

			// contact-email
			$this->contact2Demail->LinkCustomAttributes = "";
			$this->contact2Demail->HrefValue = "";
			$this->contact2Demail->TooltipValue = "";

			// contact-text1
			$this->contact2Dtext1->LinkCustomAttributes = "";
			$this->contact2Dtext1->HrefValue = "";
			$this->contact2Dtext1->TooltipValue = "";

			// contact-text2
			$this->contact2Dtext2->LinkCustomAttributes = "";
			$this->contact2Dtext2->HrefValue = "";
			$this->contact2Dtext2->TooltipValue = "";

			// contact-text3
			$this->contact2Dtext3->LinkCustomAttributes = "";
			$this->contact2Dtext3->HrefValue = "";
			$this->contact2Dtext3->TooltipValue = "";

			// contact-text4
			$this->contact2Dtext4->LinkCustomAttributes = "";
			$this->contact2Dtext4->HrefValue = "";
			$this->contact2Dtext4->TooltipValue = "";
		} elseif ($this->RowType == EW_ROWTYPE_EDIT) { // Edit row

			// id
			$this->id->EditCustomAttributes = "";
			$this->id->EditValue = $this->id->CurrentValue;
			$this->id->ViewCustomAttributes = "";

			// top-l
			$this->top2Dl->EditCustomAttributes = "style='width:97%' ";
			$this->top2Dl->EditValue = $this->top2Dl->CurrentValue;
			$this->top2Dl->PlaceHolder = ew_HtmlEncode(ew_RemoveHtml($this->top2Dl->FldCaption()));

			// top-r
			$this->top2Dr->EditCustomAttributes = "style='width:97%' ";
			$this->top2Dr->EditValue = $this->top2Dr->CurrentValue;
			$this->top2Dr->PlaceHolder = ew_HtmlEncode(ew_RemoveHtml($this->top2Dr->FldCaption()));

			// head-l
			$this->head2Dl->EditCustomAttributes = "style='width:97%' ";
			$this->head2Dl->EditValue = $this->head2Dl->CurrentValue;
			$this->head2Dl->PlaceHolder = ew_HtmlEncode(ew_RemoveHtml($this->head2Dl->FldCaption()));

			// head-r
			$this->head2Dr->EditCustomAttributes = "style='width:97%' ";
			$this->head2Dr->EditValue = $this->head2Dr->CurrentValue;
			$this->head2Dr->PlaceHolder = ew_HtmlEncode(ew_RemoveHtml($this->head2Dr->FldCaption()));

			// slide1
			$this->slide1->EditCustomAttributes = "";
			$this->slide1->UploadPath = "../images/slides/";
			if (!ew_Empty($this->slide1->Upload->DbValue)) {
				$this->slide1->EditValue = $this->slide1->Upload->DbValue;
			} else {
				$this->slide1->EditValue = "";
			}
			if ($this->CurrentAction == "I" && !$this->EventCancelled) ew_RenderUploadField($this->slide1);

			// slide2
			$this->slide2->EditCustomAttributes = "";
			$this->slide2->UploadPath = "../images/slides/";
			if (!ew_Empty($this->slide2->Upload->DbValue)) {
				$this->slide2->EditValue = $this->slide2->Upload->DbValue;
			} else {
				$this->slide2->EditValue = "";
			}
			if ($this->CurrentAction == "I" && !$this->EventCancelled) ew_RenderUploadField($this->slide2);

			// slide3
			$this->slide3->EditCustomAttributes = "";
			$this->slide3->UploadPath = "../images/slides/";
			if (!ew_Empty($this->slide3->Upload->DbValue)) {
				$this->slide3->EditValue = $this->slide3->Upload->DbValue;
			} else {
				$this->slide3->EditValue = "";
			}
			if ($this->CurrentAction == "I" && !$this->EventCancelled) ew_RenderUploadField($this->slide3);

			// slide4
			$this->slide4->EditCustomAttributes = "";
			$this->slide4->UploadPath = "../images/slides/";
			if (!ew_Empty($this->slide4->Upload->DbValue)) {
				$this->slide4->EditValue = $this->slide4->Upload->DbValue;
			} else {
				$this->slide4->EditValue = "";
			}
			if ($this->CurrentAction == "I" && !$this->EventCancelled) ew_RenderUploadField($this->slide4);

			// slide5
			$this->slide5->EditCustomAttributes = "";
			$this->slide5->UploadPath = "../images/slides/";
			if (!ew_Empty($this->slide5->Upload->DbValue)) {
				$this->slide5->EditValue = $this->slide5->Upload->DbValue;
			} else {
				$this->slide5->EditValue = "";
			}
			if ($this->CurrentAction == "I" && !$this->EventCancelled) ew_RenderUploadField($this->slide5);

			// slide6
			$this->slide6->EditCustomAttributes = "";
			$this->slide6->UploadPath = "../images/slides/";
			if (!ew_Empty($this->slide6->Upload->DbValue)) {
				$this->slide6->EditValue = $this->slide6->Upload->DbValue;
			} else {
				$this->slide6->EditValue = "";
			}
			if ($this->CurrentAction == "I" && !$this->EventCancelled) ew_RenderUploadField($this->slide6);

			// home-caption1
			$this->home2Dcaption1->EditCustomAttributes = "style='width:97%' ";
			$this->home2Dcaption1->EditValue = ew_HtmlEncode($this->home2Dcaption1->CurrentValue);
			$this->home2Dcaption1->PlaceHolder = ew_HtmlEncode(ew_RemoveHtml($this->home2Dcaption1->FldCaption()));

			// home-text1
			$this->home2Dtext1->EditCustomAttributes = "style='width:97%' ";
			$this->home2Dtext1->EditValue = $this->home2Dtext1->CurrentValue;
			$this->home2Dtext1->PlaceHolder = ew_HtmlEncode(ew_RemoveHtml($this->home2Dtext1->FldCaption()));

			// home-caption2
			$this->home2Dcaption2->EditCustomAttributes = "style='width:97%' ";
			$this->home2Dcaption2->EditValue = ew_HtmlEncode($this->home2Dcaption2->CurrentValue);
			$this->home2Dcaption2->PlaceHolder = ew_HtmlEncode(ew_RemoveHtml($this->home2Dcaption2->FldCaption()));

			// home-text2
			$this->home2Dtext2->EditCustomAttributes = "style='width:97%' ";
			$this->home2Dtext2->EditValue = $this->home2Dtext2->CurrentValue;
			$this->home2Dtext2->PlaceHolder = ew_HtmlEncode(ew_RemoveHtml($this->home2Dtext2->FldCaption()));

			// home-caption3
			$this->home2Dcaption3->EditCustomAttributes = "style='width:97%' ";
			$this->home2Dcaption3->EditValue = ew_HtmlEncode($this->home2Dcaption3->CurrentValue);
			$this->home2Dcaption3->PlaceHolder = ew_HtmlEncode(ew_RemoveHtml($this->home2Dcaption3->FldCaption()));

			// home-text3
			$this->home2Dtext3->EditCustomAttributes = "style='width:97%' ";
			$this->home2Dtext3->EditValue = $this->home2Dtext3->CurrentValue;
			$this->home2Dtext3->PlaceHolder = ew_HtmlEncode(ew_RemoveHtml($this->home2Dtext3->FldCaption()));

			// home-caption4
			$this->home2Dcaption4->EditCustomAttributes = "style='width:97%' ";
			$this->home2Dcaption4->EditValue = $this->home2Dcaption4->CurrentValue;
			$this->home2Dcaption4->PlaceHolder = ew_HtmlEncode(ew_RemoveHtml($this->home2Dcaption4->FldCaption()));

			// home-text4
			$this->home2Dtext4->EditCustomAttributes = "style='width:97%' ";
			$this->home2Dtext4->EditValue = $this->home2Dtext4->CurrentValue;
			$this->home2Dtext4->PlaceHolder = ew_HtmlEncode(ew_RemoveHtml($this->home2Dtext4->FldCaption()));

			// home-caption5
			$this->home2Dcaption5->EditCustomAttributes = "style='width:97%' ";
			$this->home2Dcaption5->EditValue = ew_HtmlEncode($this->home2Dcaption5->CurrentValue);
			$this->home2Dcaption5->PlaceHolder = ew_HtmlEncode(ew_RemoveHtml($this->home2Dcaption5->FldCaption()));

			// home-text5
			$this->home2Dtext5->EditCustomAttributes = "style='width:97%' ";
			$this->home2Dtext5->EditValue = $this->home2Dtext5->CurrentValue;
			$this->home2Dtext5->PlaceHolder = ew_HtmlEncode(ew_RemoveHtml($this->home2Dtext5->FldCaption()));

			// home-caption6
			$this->home2Dcaption6->EditCustomAttributes = "style='width:97%' ";
			$this->home2Dcaption6->EditValue = ew_HtmlEncode($this->home2Dcaption6->CurrentValue);
			$this->home2Dcaption6->PlaceHolder = ew_HtmlEncode(ew_RemoveHtml($this->home2Dcaption6->FldCaption()));

			// home-text6
			$this->home2Dtext6->EditCustomAttributes = "style='width:97%' ";
			$this->home2Dtext6->EditValue = $this->home2Dtext6->CurrentValue;
			$this->home2Dtext6->PlaceHolder = ew_HtmlEncode(ew_RemoveHtml($this->home2Dtext6->FldCaption()));

			// footer-1
			$this->footer2D1->EditCustomAttributes = "style='width:97%' ";
			$this->footer2D1->EditValue = $this->footer2D1->CurrentValue;
			$this->footer2D1->PlaceHolder = ew_HtmlEncode(ew_RemoveHtml($this->footer2D1->FldCaption()));

			// footer-2
			$this->footer2D2->EditCustomAttributes = "style='width:97%' ";
			$this->footer2D2->EditValue = $this->footer2D2->CurrentValue;
			$this->footer2D2->PlaceHolder = ew_HtmlEncode(ew_RemoveHtml($this->footer2D2->FldCaption()));

			// footer-3
			$this->footer2D3->EditCustomAttributes = "style='width:97%' ";
			$this->footer2D3->EditValue = $this->footer2D3->CurrentValue;
			$this->footer2D3->PlaceHolder = ew_HtmlEncode(ew_RemoveHtml($this->footer2D3->FldCaption()));

			// footer-4
			$this->footer2D4->EditCustomAttributes = "style='width:97%' ";
			$this->footer2D4->EditValue = $this->footer2D4->CurrentValue;
			$this->footer2D4->PlaceHolder = ew_HtmlEncode(ew_RemoveHtml($this->footer2D4->FldCaption()));

			// contact-email
			$this->contact2Demail->EditCustomAttributes = "style='width:97%' ";
			$this->contact2Demail->EditValue = ew_HtmlEncode($this->contact2Demail->CurrentValue);
			$this->contact2Demail->PlaceHolder = ew_HtmlEncode(ew_RemoveHtml($this->contact2Demail->FldCaption()));

			// contact-text1
			$this->contact2Dtext1->EditCustomAttributes = "style='width:97%' ";
			$this->contact2Dtext1->EditValue = $this->contact2Dtext1->CurrentValue;
			$this->contact2Dtext1->PlaceHolder = ew_HtmlEncode(ew_RemoveHtml($this->contact2Dtext1->FldCaption()));

			// contact-text2
			$this->contact2Dtext2->EditCustomAttributes = "style='width:97%' ";
			$this->contact2Dtext2->EditValue = $this->contact2Dtext2->CurrentValue;
			$this->contact2Dtext2->PlaceHolder = ew_HtmlEncode(ew_RemoveHtml($this->contact2Dtext2->FldCaption()));

			// contact-text3
			$this->contact2Dtext3->EditCustomAttributes = "style='width:97%' ";
			$this->contact2Dtext3->EditValue = $this->contact2Dtext3->CurrentValue;
			$this->contact2Dtext3->PlaceHolder = ew_HtmlEncode(ew_RemoveHtml($this->contact2Dtext3->FldCaption()));

			// contact-text4
			$this->contact2Dtext4->EditCustomAttributes = "style='width:97%' ";
			$this->contact2Dtext4->EditValue = $this->contact2Dtext4->CurrentValue;
			$this->contact2Dtext4->PlaceHolder = ew_HtmlEncode(ew_RemoveHtml($this->contact2Dtext4->FldCaption()));

			// Edit refer script
			// id

			$this->id->HrefValue = "";

			// top-l
			$this->top2Dl->HrefValue = "";

			// top-r
			$this->top2Dr->HrefValue = "";

			// head-l
			$this->head2Dl->HrefValue = "";

			// head-r
			$this->head2Dr->HrefValue = "";

			// slide1
			$this->slide1->UploadPath = "../images/slides/";
			if (!ew_Empty($this->slide1->Upload->DbValue)) {
				$this->slide1->HrefValue = ew_UploadPathEx(FALSE, $this->slide1->UploadPath) . $this->slide1->Upload->DbValue; // Add prefix/suffix
				$this->slide1->LinkAttrs["target"] = "_blank"; // Add target
				if ($this->Export <> "") $this->slide1->HrefValue = ew_ConvertFullUrl($this->slide1->HrefValue);
			} else {
				$this->slide1->HrefValue = "";
			}
			$this->slide1->HrefValue2 = $this->slide1->UploadPath . $this->slide1->Upload->DbValue;

			// slide2
			$this->slide2->UploadPath = "../images/slides/";
			if (!ew_Empty($this->slide2->Upload->DbValue)) {
				$this->slide2->HrefValue = ew_UploadPathEx(FALSE, $this->slide2->UploadPath) . $this->slide2->Upload->DbValue; // Add prefix/suffix
				$this->slide2->LinkAttrs["target"] = "_blank"; // Add target
				if ($this->Export <> "") $this->slide2->HrefValue = ew_ConvertFullUrl($this->slide2->HrefValue);
			} else {
				$this->slide2->HrefValue = "";
			}
			$this->slide2->HrefValue2 = $this->slide2->UploadPath . $this->slide2->Upload->DbValue;

			// slide3
			$this->slide3->UploadPath = "../images/slides/";
			if (!ew_Empty($this->slide3->Upload->DbValue)) {
				$this->slide3->HrefValue = ew_UploadPathEx(FALSE, $this->slide3->UploadPath) . $this->slide3->Upload->DbValue; // Add prefix/suffix
				$this->slide3->LinkAttrs["target"] = "_blank"; // Add target
				if ($this->Export <> "") $this->slide3->HrefValue = ew_ConvertFullUrl($this->slide3->HrefValue);
			} else {
				$this->slide3->HrefValue = "";
			}
			$this->slide3->HrefValue2 = $this->slide3->UploadPath . $this->slide3->Upload->DbValue;

			// slide4
			$this->slide4->UploadPath = "../images/slides/";
			if (!ew_Empty($this->slide4->Upload->DbValue)) {
				$this->slide4->HrefValue = ew_UploadPathEx(FALSE, $this->slide4->UploadPath) . $this->slide4->Upload->DbValue; // Add prefix/suffix
				$this->slide4->LinkAttrs["target"] = "_blank"; // Add target
				if ($this->Export <> "") $this->slide4->HrefValue = ew_ConvertFullUrl($this->slide4->HrefValue);
			} else {
				$this->slide4->HrefValue = "";
			}
			$this->slide4->HrefValue2 = $this->slide4->UploadPath . $this->slide4->Upload->DbValue;

			// slide5
			$this->slide5->UploadPath = "../images/slides/";
			if (!ew_Empty($this->slide5->Upload->DbValue)) {
				$this->slide5->HrefValue = ew_UploadPathEx(FALSE, $this->slide5->UploadPath) . $this->slide5->Upload->DbValue; // Add prefix/suffix
				$this->slide5->LinkAttrs["target"] = "_blank"; // Add target
				if ($this->Export <> "") $this->slide5->HrefValue = ew_ConvertFullUrl($this->slide5->HrefValue);
			} else {
				$this->slide5->HrefValue = "";
			}
			$this->slide5->HrefValue2 = $this->slide5->UploadPath . $this->slide5->Upload->DbValue;

			// slide6
			$this->slide6->UploadPath = "../images/slides/";
			if (!ew_Empty($this->slide6->Upload->DbValue)) {
				$this->slide6->HrefValue = ew_UploadPathEx(FALSE, $this->slide6->UploadPath) . $this->slide6->Upload->DbValue; // Add prefix/suffix
				$this->slide6->LinkAttrs["target"] = "_blank"; // Add target
				if ($this->Export <> "") $this->slide6->HrefValue = ew_ConvertFullUrl($this->slide6->HrefValue);
			} else {
				$this->slide6->HrefValue = "";
			}
			$this->slide6->HrefValue2 = $this->slide6->UploadPath . $this->slide6->Upload->DbValue;

			// home-caption1
			$this->home2Dcaption1->HrefValue = "";

			// home-text1
			$this->home2Dtext1->HrefValue = "";

			// home-caption2
			$this->home2Dcaption2->HrefValue = "";

			// home-text2
			$this->home2Dtext2->HrefValue = "";

			// home-caption3
			$this->home2Dcaption3->HrefValue = "";

			// home-text3
			$this->home2Dtext3->HrefValue = "";

			// home-caption4
			$this->home2Dcaption4->HrefValue = "";

			// home-text4
			$this->home2Dtext4->HrefValue = "";

			// home-caption5
			$this->home2Dcaption5->HrefValue = "";

			// home-text5
			$this->home2Dtext5->HrefValue = "";

			// home-caption6
			$this->home2Dcaption6->HrefValue = "";

			// home-text6
			$this->home2Dtext6->HrefValue = "";

			// footer-1
			$this->footer2D1->HrefValue = "";

			// footer-2
			$this->footer2D2->HrefValue = "";

			// footer-3
			$this->footer2D3->HrefValue = "";

			// footer-4
			$this->footer2D4->HrefValue = "";

			// contact-email
			$this->contact2Demail->HrefValue = "";

			// contact-text1
			$this->contact2Dtext1->HrefValue = "";

			// contact-text2
			$this->contact2Dtext2->HrefValue = "";

			// contact-text3
			$this->contact2Dtext3->HrefValue = "";

			// contact-text4
			$this->contact2Dtext4->HrefValue = "";
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
			$this->slide1->OldUploadPath = "../images/slides/";
			$this->slide1->UploadPath = $this->slide1->OldUploadPath;
			$this->slide2->OldUploadPath = "../images/slides/";
			$this->slide2->UploadPath = $this->slide2->OldUploadPath;
			$this->slide3->OldUploadPath = "../images/slides/";
			$this->slide3->UploadPath = $this->slide3->OldUploadPath;
			$this->slide4->OldUploadPath = "../images/slides/";
			$this->slide4->UploadPath = $this->slide4->OldUploadPath;
			$this->slide5->OldUploadPath = "../images/slides/";
			$this->slide5->UploadPath = $this->slide5->OldUploadPath;
			$this->slide6->OldUploadPath = "../images/slides/";
			$this->slide6->UploadPath = $this->slide6->OldUploadPath;
			$rsnew = array();

			// top-l
			$this->top2Dl->SetDbValueDef($rsnew, $this->top2Dl->CurrentValue, NULL, $this->top2Dl->ReadOnly);

			// top-r
			$this->top2Dr->SetDbValueDef($rsnew, $this->top2Dr->CurrentValue, NULL, $this->top2Dr->ReadOnly);

			// head-l
			$this->head2Dl->SetDbValueDef($rsnew, $this->head2Dl->CurrentValue, NULL, $this->head2Dl->ReadOnly);

			// head-r
			$this->head2Dr->SetDbValueDef($rsnew, $this->head2Dr->CurrentValue, NULL, $this->head2Dr->ReadOnly);

			// slide1
			if (!($this->slide1->ReadOnly) && !$this->slide1->Upload->KeepFile) {
				$this->slide1->Upload->DbValue = $rs->fields('slide1'); // Get original value
				if ($this->slide1->Upload->FileName == "") {
					$rsnew['slide1'] = NULL;
				} else {
					$rsnew['slide1'] = $this->slide1->Upload->FileName;
				}
			}

			// slide2
			if (!($this->slide2->ReadOnly) && !$this->slide2->Upload->KeepFile) {
				$this->slide2->Upload->DbValue = $rs->fields('slide2'); // Get original value
				if ($this->slide2->Upload->FileName == "") {
					$rsnew['slide2'] = NULL;
				} else {
					$rsnew['slide2'] = $this->slide2->Upload->FileName;
				}
			}

			// slide3
			if (!($this->slide3->ReadOnly) && !$this->slide3->Upload->KeepFile) {
				$this->slide3->Upload->DbValue = $rs->fields('slide3'); // Get original value
				if ($this->slide3->Upload->FileName == "") {
					$rsnew['slide3'] = NULL;
				} else {
					$rsnew['slide3'] = $this->slide3->Upload->FileName;
				}
			}

			// slide4
			if (!($this->slide4->ReadOnly) && !$this->slide4->Upload->KeepFile) {
				$this->slide4->Upload->DbValue = $rs->fields('slide4'); // Get original value
				if ($this->slide4->Upload->FileName == "") {
					$rsnew['slide4'] = NULL;
				} else {
					$rsnew['slide4'] = $this->slide4->Upload->FileName;
				}
			}

			// slide5
			if (!($this->slide5->ReadOnly) && !$this->slide5->Upload->KeepFile) {
				$this->slide5->Upload->DbValue = $rs->fields('slide5'); // Get original value
				if ($this->slide5->Upload->FileName == "") {
					$rsnew['slide5'] = NULL;
				} else {
					$rsnew['slide5'] = $this->slide5->Upload->FileName;
				}
			}

			// slide6
			if (!($this->slide6->ReadOnly) && !$this->slide6->Upload->KeepFile) {
				$this->slide6->Upload->DbValue = $rs->fields('slide6'); // Get original value
				if ($this->slide6->Upload->FileName == "") {
					$rsnew['slide6'] = NULL;
				} else {
					$rsnew['slide6'] = $this->slide6->Upload->FileName;
				}
			}

			// home-caption1
			$this->home2Dcaption1->SetDbValueDef($rsnew, $this->home2Dcaption1->CurrentValue, NULL, $this->home2Dcaption1->ReadOnly);

			// home-text1
			$this->home2Dtext1->SetDbValueDef($rsnew, $this->home2Dtext1->CurrentValue, NULL, $this->home2Dtext1->ReadOnly);

			// home-caption2
			$this->home2Dcaption2->SetDbValueDef($rsnew, $this->home2Dcaption2->CurrentValue, NULL, $this->home2Dcaption2->ReadOnly);

			// home-text2
			$this->home2Dtext2->SetDbValueDef($rsnew, $this->home2Dtext2->CurrentValue, NULL, $this->home2Dtext2->ReadOnly);

			// home-caption3
			$this->home2Dcaption3->SetDbValueDef($rsnew, $this->home2Dcaption3->CurrentValue, NULL, $this->home2Dcaption3->ReadOnly);

			// home-text3
			$this->home2Dtext3->SetDbValueDef($rsnew, $this->home2Dtext3->CurrentValue, NULL, $this->home2Dtext3->ReadOnly);

			// home-caption4
			$this->home2Dcaption4->SetDbValueDef($rsnew, $this->home2Dcaption4->CurrentValue, NULL, $this->home2Dcaption4->ReadOnly);

			// home-text4
			$this->home2Dtext4->SetDbValueDef($rsnew, $this->home2Dtext4->CurrentValue, NULL, $this->home2Dtext4->ReadOnly);

			// home-caption5
			$this->home2Dcaption5->SetDbValueDef($rsnew, $this->home2Dcaption5->CurrentValue, NULL, $this->home2Dcaption5->ReadOnly);

			// home-text5
			$this->home2Dtext5->SetDbValueDef($rsnew, $this->home2Dtext5->CurrentValue, NULL, $this->home2Dtext5->ReadOnly);

			// home-caption6
			$this->home2Dcaption6->SetDbValueDef($rsnew, $this->home2Dcaption6->CurrentValue, NULL, $this->home2Dcaption6->ReadOnly);

			// home-text6
			$this->home2Dtext6->SetDbValueDef($rsnew, $this->home2Dtext6->CurrentValue, NULL, $this->home2Dtext6->ReadOnly);

			// footer-1
			$this->footer2D1->SetDbValueDef($rsnew, $this->footer2D1->CurrentValue, NULL, $this->footer2D1->ReadOnly);

			// footer-2
			$this->footer2D2->SetDbValueDef($rsnew, $this->footer2D2->CurrentValue, NULL, $this->footer2D2->ReadOnly);

			// footer-3
			$this->footer2D3->SetDbValueDef($rsnew, $this->footer2D3->CurrentValue, NULL, $this->footer2D3->ReadOnly);

			// footer-4
			$this->footer2D4->SetDbValueDef($rsnew, $this->footer2D4->CurrentValue, NULL, $this->footer2D4->ReadOnly);

			// contact-email
			$this->contact2Demail->SetDbValueDef($rsnew, $this->contact2Demail->CurrentValue, NULL, $this->contact2Demail->ReadOnly);

			// contact-text1
			$this->contact2Dtext1->SetDbValueDef($rsnew, $this->contact2Dtext1->CurrentValue, NULL, $this->contact2Dtext1->ReadOnly);

			// contact-text2
			$this->contact2Dtext2->SetDbValueDef($rsnew, $this->contact2Dtext2->CurrentValue, NULL, $this->contact2Dtext2->ReadOnly);

			// contact-text3
			$this->contact2Dtext3->SetDbValueDef($rsnew, $this->contact2Dtext3->CurrentValue, NULL, $this->contact2Dtext3->ReadOnly);

			// contact-text4
			$this->contact2Dtext4->SetDbValueDef($rsnew, $this->contact2Dtext4->CurrentValue, NULL, $this->contact2Dtext4->ReadOnly);
			if (!$this->slide1->Upload->KeepFile) {
				$this->slide1->UploadPath = "../images/slides/";
				if (!ew_Empty($this->slide1->Upload->Value)) {
					if ($this->slide1->Upload->FileName == $this->slide1->Upload->DbValue) { // Overwrite if same file name
						$this->slide1->Upload->DbValue = ""; // No need to delete any more
					} else {
						$rsnew['slide1'] = ew_UploadFileNameEx(ew_UploadPathEx(TRUE, $this->slide1->UploadPath), $rsnew['slide1']); // Get new file name
					}
				}
			}
			if (!$this->slide2->Upload->KeepFile) {
				$this->slide2->UploadPath = "../images/slides/";
				if (!ew_Empty($this->slide2->Upload->Value)) {
					if ($this->slide2->Upload->FileName == $this->slide2->Upload->DbValue) { // Overwrite if same file name
						$this->slide2->Upload->DbValue = ""; // No need to delete any more
					} else {
						$rsnew['slide2'] = ew_UploadFileNameEx(ew_UploadPathEx(TRUE, $this->slide2->UploadPath), $rsnew['slide2']); // Get new file name
					}
				}
			}
			if (!$this->slide3->Upload->KeepFile) {
				$this->slide3->UploadPath = "../images/slides/";
				if (!ew_Empty($this->slide3->Upload->Value)) {
					if ($this->slide3->Upload->FileName == $this->slide3->Upload->DbValue) { // Overwrite if same file name
						$this->slide3->Upload->DbValue = ""; // No need to delete any more
					} else {
						$rsnew['slide3'] = ew_UploadFileNameEx(ew_UploadPathEx(TRUE, $this->slide3->UploadPath), $rsnew['slide3']); // Get new file name
					}
				}
			}
			if (!$this->slide4->Upload->KeepFile) {
				$this->slide4->UploadPath = "../images/slides/";
				if (!ew_Empty($this->slide4->Upload->Value)) {
					if ($this->slide4->Upload->FileName == $this->slide4->Upload->DbValue) { // Overwrite if same file name
						$this->slide4->Upload->DbValue = ""; // No need to delete any more
					} else {
						$rsnew['slide4'] = ew_UploadFileNameEx(ew_UploadPathEx(TRUE, $this->slide4->UploadPath), $rsnew['slide4']); // Get new file name
					}
				}
			}
			if (!$this->slide5->Upload->KeepFile) {
				$this->slide5->UploadPath = "../images/slides/";
				if (!ew_Empty($this->slide5->Upload->Value)) {
					if ($this->slide5->Upload->FileName == $this->slide5->Upload->DbValue) { // Overwrite if same file name
						$this->slide5->Upload->DbValue = ""; // No need to delete any more
					} else {
						$rsnew['slide5'] = ew_UploadFileNameEx(ew_UploadPathEx(TRUE, $this->slide5->UploadPath), $rsnew['slide5']); // Get new file name
					}
				}
			}
			if (!$this->slide6->Upload->KeepFile) {
				$this->slide6->UploadPath = "../images/slides/";
				if (!ew_Empty($this->slide6->Upload->Value)) {
					if ($this->slide6->Upload->FileName == $this->slide6->Upload->DbValue) { // Overwrite if same file name
						$this->slide6->Upload->DbValue = ""; // No need to delete any more
					} else {
						$rsnew['slide6'] = ew_UploadFileNameEx(ew_UploadPathEx(TRUE, $this->slide6->UploadPath), $rsnew['slide6']); // Get new file name
					}
				}
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
					if (!$this->slide1->Upload->KeepFile) {
						if (!ew_Empty($this->slide1->Upload->Value)) {
							$this->slide1->Upload->SaveToFile($this->slide1->UploadPath, $rsnew['slide1'], TRUE);
						}
						if ($this->slide1->Upload->DbValue <> "")
							@unlink(ew_UploadPathEx(TRUE, $this->slide1->OldUploadPath) . $this->slide1->Upload->DbValue);
					}
					if (!$this->slide2->Upload->KeepFile) {
						if (!ew_Empty($this->slide2->Upload->Value)) {
							$this->slide2->Upload->SaveToFile($this->slide2->UploadPath, $rsnew['slide2'], TRUE);
						}
						if ($this->slide2->Upload->DbValue <> "")
							@unlink(ew_UploadPathEx(TRUE, $this->slide2->OldUploadPath) . $this->slide2->Upload->DbValue);
					}
					if (!$this->slide3->Upload->KeepFile) {
						if (!ew_Empty($this->slide3->Upload->Value)) {
							$this->slide3->Upload->SaveToFile($this->slide3->UploadPath, $rsnew['slide3'], TRUE);
						}
						if ($this->slide3->Upload->DbValue <> "")
							@unlink(ew_UploadPathEx(TRUE, $this->slide3->OldUploadPath) . $this->slide3->Upload->DbValue);
					}
					if (!$this->slide4->Upload->KeepFile) {
						if (!ew_Empty($this->slide4->Upload->Value)) {
							$this->slide4->Upload->SaveToFile($this->slide4->UploadPath, $rsnew['slide4'], TRUE);
						}
						if ($this->slide4->Upload->DbValue <> "")
							@unlink(ew_UploadPathEx(TRUE, $this->slide4->OldUploadPath) . $this->slide4->Upload->DbValue);
					}
					if (!$this->slide5->Upload->KeepFile) {
						if (!ew_Empty($this->slide5->Upload->Value)) {
							$this->slide5->Upload->SaveToFile($this->slide5->UploadPath, $rsnew['slide5'], TRUE);
						}
						if ($this->slide5->Upload->DbValue <> "")
							@unlink(ew_UploadPathEx(TRUE, $this->slide5->OldUploadPath) . $this->slide5->Upload->DbValue);
					}
					if (!$this->slide6->Upload->KeepFile) {
						if (!ew_Empty($this->slide6->Upload->Value)) {
							$this->slide6->Upload->SaveToFile($this->slide6->UploadPath, $rsnew['slide6'], TRUE);
						}
						if ($this->slide6->Upload->DbValue <> "")
							@unlink(ew_UploadPathEx(TRUE, $this->slide6->OldUploadPath) . $this->slide6->Upload->DbValue);
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

		// slide1
		ew_CleanUploadTempPath($this->slide1, $this->slide1->Upload->Index);

		// slide2
		ew_CleanUploadTempPath($this->slide2, $this->slide2->Upload->Index);

		// slide3
		ew_CleanUploadTempPath($this->slide3, $this->slide3->Upload->Index);

		// slide4
		ew_CleanUploadTempPath($this->slide4, $this->slide4->Upload->Index);

		// slide5
		ew_CleanUploadTempPath($this->slide5, $this->slide5->Upload->Index);

		// slide6
		ew_CleanUploadTempPath($this->slide6, $this->slide6->Upload->Index);
		return $EditRow;
	}

	// Set up Breadcrumb
	function SetupBreadcrumb() {
		global $Breadcrumb, $Language;
		$Breadcrumb = new cBreadcrumb();
		$PageCaption = $this->TableCaption();
		$Breadcrumb->Add("list", "<span id=\"ewPageCaption\">" . $PageCaption . "</span>", "layoutlist.php", $this->TableVar);
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
if (!isset($layout_edit)) $layout_edit = new clayout_edit();

// Page init
$layout_edit->Page_Init();

// Page main
$layout_edit->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$layout_edit->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Page object
var layout_edit = new ew_Page("layout_edit");
layout_edit.PageID = "edit"; // Page ID
var EW_PAGE_ID = layout_edit.PageID; // For backward compatibility

// Form object
var flayoutedit = new ew_Form("flayoutedit");

// Validate form
flayoutedit.Validate = function() {
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
flayoutedit.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
flayoutedit.ValidateRequired = true;
<?php } else { ?>
flayoutedit.ValidateRequired = false; 
<?php } ?>

// Multi-Page properties
flayoutedit.MultiPage = new ew_MultiPage("flayoutedit",
	[["x_id",1],["x_top2Dl",1],["x_top2Dr",1],["x_head2Dl",1],["x_head2Dr",1],["x_slide1",1],["x_slide2",1],["x_slide3",1],["x_slide4",1],["x_slide5",1],["x_slide6",1],["x_home2Dcaption1",3],["x_home2Dtext1",3],["x_home2Dcaption2",3],["x_home2Dtext2",3],["x_home2Dcaption3",3],["x_home2Dtext3",3],["x_home2Dcaption4",3],["x_home2Dtext4",3],["x_home2Dcaption5",3],["x_home2Dtext5",3],["x_home2Dcaption6",3],["x_home2Dtext6",3],["x_footer2D1",4],["x_footer2D2",4],["x_footer2D3",4],["x_footer2D4",4],["x_contact2Demail",5],["x_contact2Dtext1",5],["x_contact2Dtext2",5],["x_contact2Dtext3",5],["x_contact2Dtext4",5]]
);

// Dynamic selection lists
// Form object for search

</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<?php $Breadcrumb->Render(); ?>
<?php $layout_edit->ShowPageHeader(); ?>
<?php
$layout_edit->ShowMessage();
?>
<form name="flayoutedit" id="flayoutedit" class="ewForm form-horizontal" action="<?php echo ew_CurrentPage() ?>" method="post">
<input type="hidden" name="t" value="layout">
<input type="hidden" name="a_edit" id="a_edit" value="U">
<table class="ewStdTable"><tbody><tr><td>
<div class="tabbable" id="layout_edit">
	<ul class="nav nav-tabs">
		<li class="active"><a href="#tab_layout1" data-toggle="tab"><?php echo $layout->PageCaption(1) ?></a></li>
		<li style="display: none"><a href="#tab_layout2" data-toggle="tab"></a></li>
		<li><a href="#tab_layout3" data-toggle="tab"><?php echo $layout->PageCaption(3) ?></a></li>
		<li><a href="#tab_layout4" data-toggle="tab"><?php echo $layout->PageCaption(4) ?></a></li>
		<li><a href="#tab_layout5" data-toggle="tab"><?php echo $layout->PageCaption(5) ?></a></li>
	</ul>
	<div class="tab-content">
		<div class="tab-pane active" id="tab_layout1">
<table cellspacing="0" class="ewGrid" style="width: 100%"><tr><td>
<table id="tbl_layoutedit1" class="table table-bordered table-striped">
<?php if ($layout->id->Visible) { // id ?>
	<tr id="r_id">
		<td><span id="elh_layout_id"><?php echo $layout->id->FldCaption() ?></span></td>
		<td<?php echo $layout->id->CellAttributes() ?>>
<span id="el_layout_id" class="control-group">
<span>
<?php if (!ew_EmptyStr($layout->id->EditValue)) { ?><img src="<?php echo $layout->id->EditValue ?>" alt="" style="border: 0;"<?php echo $layout->id->ViewAttributes() ?>><?php } ?></span>
</span>
<input type="hidden" data-field="x_id" name="x_id" id="x_id" value="<?php echo ew_HtmlEncode($layout->id->CurrentValue) ?>">
<?php echo $layout->id->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($layout->top2Dl->Visible) { // top-l ?>
	<tr id="r_top2Dl">
		<td><span id="elh_layout_top2Dl"><?php echo $layout->top2Dl->FldCaption() ?></span></td>
		<td<?php echo $layout->top2Dl->CellAttributes() ?>>
<span id="el_layout_top2Dl" class="control-group">
<textarea data-field="x_top2Dl" name="x_top2Dl" id="x_top2Dl" cols="35" rows="4" placeholder="<?php echo $layout->top2Dl->PlaceHolder ?>"<?php echo $layout->top2Dl->EditAttributes() ?>><?php echo $layout->top2Dl->EditValue ?></textarea>
</span>
<?php echo $layout->top2Dl->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($layout->top2Dr->Visible) { // top-r ?>
	<tr id="r_top2Dr">
		<td><span id="elh_layout_top2Dr"><?php echo $layout->top2Dr->FldCaption() ?></span></td>
		<td<?php echo $layout->top2Dr->CellAttributes() ?>>
<span id="el_layout_top2Dr" class="control-group">
<textarea data-field="x_top2Dr" name="x_top2Dr" id="x_top2Dr" cols="35" rows="4" placeholder="<?php echo $layout->top2Dr->PlaceHolder ?>"<?php echo $layout->top2Dr->EditAttributes() ?>><?php echo $layout->top2Dr->EditValue ?></textarea>
</span>
<?php echo $layout->top2Dr->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($layout->head2Dl->Visible) { // head-l ?>
	<tr id="r_head2Dl">
		<td><span id="elh_layout_head2Dl"><?php echo $layout->head2Dl->FldCaption() ?></span></td>
		<td<?php echo $layout->head2Dl->CellAttributes() ?>>
<span id="el_layout_head2Dl" class="control-group">
<textarea data-field="x_head2Dl" name="x_head2Dl" id="x_head2Dl" cols="35" rows="4" placeholder="<?php echo $layout->head2Dl->PlaceHolder ?>"<?php echo $layout->head2Dl->EditAttributes() ?>><?php echo $layout->head2Dl->EditValue ?></textarea>
</span>
<?php echo $layout->head2Dl->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($layout->head2Dr->Visible) { // head-r ?>
	<tr id="r_head2Dr">
		<td><span id="elh_layout_head2Dr"><?php echo $layout->head2Dr->FldCaption() ?></span></td>
		<td<?php echo $layout->head2Dr->CellAttributes() ?>>
<span id="el_layout_head2Dr" class="control-group">
<textarea data-field="x_head2Dr" name="x_head2Dr" id="x_head2Dr" cols="35" rows="4" placeholder="<?php echo $layout->head2Dr->PlaceHolder ?>"<?php echo $layout->head2Dr->EditAttributes() ?>><?php echo $layout->head2Dr->EditValue ?></textarea>
</span>
<?php echo $layout->head2Dr->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($layout->slide1->Visible) { // slide1 ?>
	<tr id="r_slide1">
		<td><span id="elh_layout_slide1"><?php echo $layout->slide1->FldCaption() ?></span></td>
		<td<?php echo $layout->slide1->CellAttributes() ?>>
<span id="el_layout_slide1" class="control-group">
<span id="fd_x_slide1">
<span class="btn btn-small fileinput-button">
	<span><?php echo $Language->Phrase("ChooseFile") ?></span>
	<input type="file" data-field="x_slide1" name="x_slide1" id="x_slide1">
</span>
<input type="hidden" name="fn_x_slide1" id= "fn_x_slide1" value="<?php echo $layout->slide1->Upload->FileName ?>">
<?php if (@$_POST["fa_x_slide1"] == "0") { ?>
<input type="hidden" name="fa_x_slide1" id= "fa_x_slide1" value="0">
<?php } else { ?>
<input type="hidden" name="fa_x_slide1" id= "fa_x_slide1" value="1">
<?php } ?>
<input type="hidden" name="fs_x_slide1" id= "fs_x_slide1" value="200">
</span>
<table id="ft_x_slide1" class="table table-condensed pull-left ewUploadTable"><tbody class="files"></tbody></table>
</span>
<?php echo $layout->slide1->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($layout->slide2->Visible) { // slide2 ?>
	<tr id="r_slide2">
		<td><span id="elh_layout_slide2"><?php echo $layout->slide2->FldCaption() ?></span></td>
		<td<?php echo $layout->slide2->CellAttributes() ?>>
<span id="el_layout_slide2" class="control-group">
<span id="fd_x_slide2">
<span class="btn btn-small fileinput-button">
	<span><?php echo $Language->Phrase("ChooseFile") ?></span>
	<input type="file" data-field="x_slide2" name="x_slide2" id="x_slide2">
</span>
<input type="hidden" name="fn_x_slide2" id= "fn_x_slide2" value="<?php echo $layout->slide2->Upload->FileName ?>">
<?php if (@$_POST["fa_x_slide2"] == "0") { ?>
<input type="hidden" name="fa_x_slide2" id= "fa_x_slide2" value="0">
<?php } else { ?>
<input type="hidden" name="fa_x_slide2" id= "fa_x_slide2" value="1">
<?php } ?>
<input type="hidden" name="fs_x_slide2" id= "fs_x_slide2" value="200">
</span>
<table id="ft_x_slide2" class="table table-condensed pull-left ewUploadTable"><tbody class="files"></tbody></table>
</span>
<?php echo $layout->slide2->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($layout->slide3->Visible) { // slide3 ?>
	<tr id="r_slide3">
		<td><span id="elh_layout_slide3"><?php echo $layout->slide3->FldCaption() ?></span></td>
		<td<?php echo $layout->slide3->CellAttributes() ?>>
<span id="el_layout_slide3" class="control-group">
<span id="fd_x_slide3">
<span class="btn btn-small fileinput-button">
	<span><?php echo $Language->Phrase("ChooseFile") ?></span>
	<input type="file" data-field="x_slide3" name="x_slide3" id="x_slide3">
</span>
<input type="hidden" name="fn_x_slide3" id= "fn_x_slide3" value="<?php echo $layout->slide3->Upload->FileName ?>">
<?php if (@$_POST["fa_x_slide3"] == "0") { ?>
<input type="hidden" name="fa_x_slide3" id= "fa_x_slide3" value="0">
<?php } else { ?>
<input type="hidden" name="fa_x_slide3" id= "fa_x_slide3" value="1">
<?php } ?>
<input type="hidden" name="fs_x_slide3" id= "fs_x_slide3" value="200">
</span>
<table id="ft_x_slide3" class="table table-condensed pull-left ewUploadTable"><tbody class="files"></tbody></table>
</span>
<?php echo $layout->slide3->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($layout->slide4->Visible) { // slide4 ?>
	<tr id="r_slide4">
		<td><span id="elh_layout_slide4"><?php echo $layout->slide4->FldCaption() ?></span></td>
		<td<?php echo $layout->slide4->CellAttributes() ?>>
<span id="el_layout_slide4" class="control-group">
<span id="fd_x_slide4">
<span class="btn btn-small fileinput-button">
	<span><?php echo $Language->Phrase("ChooseFile") ?></span>
	<input type="file" data-field="x_slide4" name="x_slide4" id="x_slide4">
</span>
<input type="hidden" name="fn_x_slide4" id= "fn_x_slide4" value="<?php echo $layout->slide4->Upload->FileName ?>">
<?php if (@$_POST["fa_x_slide4"] == "0") { ?>
<input type="hidden" name="fa_x_slide4" id= "fa_x_slide4" value="0">
<?php } else { ?>
<input type="hidden" name="fa_x_slide4" id= "fa_x_slide4" value="1">
<?php } ?>
<input type="hidden" name="fs_x_slide4" id= "fs_x_slide4" value="200">
</span>
<table id="ft_x_slide4" class="table table-condensed pull-left ewUploadTable"><tbody class="files"></tbody></table>
</span>
<?php echo $layout->slide4->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($layout->slide5->Visible) { // slide5 ?>
	<tr id="r_slide5">
		<td><span id="elh_layout_slide5"><?php echo $layout->slide5->FldCaption() ?></span></td>
		<td<?php echo $layout->slide5->CellAttributes() ?>>
<span id="el_layout_slide5" class="control-group">
<span id="fd_x_slide5">
<span class="btn btn-small fileinput-button">
	<span><?php echo $Language->Phrase("ChooseFile") ?></span>
	<input type="file" data-field="x_slide5" name="x_slide5" id="x_slide5">
</span>
<input type="hidden" name="fn_x_slide5" id= "fn_x_slide5" value="<?php echo $layout->slide5->Upload->FileName ?>">
<?php if (@$_POST["fa_x_slide5"] == "0") { ?>
<input type="hidden" name="fa_x_slide5" id= "fa_x_slide5" value="0">
<?php } else { ?>
<input type="hidden" name="fa_x_slide5" id= "fa_x_slide5" value="1">
<?php } ?>
<input type="hidden" name="fs_x_slide5" id= "fs_x_slide5" value="200">
</span>
<table id="ft_x_slide5" class="table table-condensed pull-left ewUploadTable"><tbody class="files"></tbody></table>
</span>
<?php echo $layout->slide5->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($layout->slide6->Visible) { // slide6 ?>
	<tr id="r_slide6">
		<td><span id="elh_layout_slide6"><?php echo $layout->slide6->FldCaption() ?></span></td>
		<td<?php echo $layout->slide6->CellAttributes() ?>>
<span id="el_layout_slide6" class="control-group">
<span id="fd_x_slide6">
<span class="btn btn-small fileinput-button">
	<span><?php echo $Language->Phrase("ChooseFile") ?></span>
	<input type="file" data-field="x_slide6" name="x_slide6" id="x_slide6">
</span>
<input type="hidden" name="fn_x_slide6" id= "fn_x_slide6" value="<?php echo $layout->slide6->Upload->FileName ?>">
<?php if (@$_POST["fa_x_slide6"] == "0") { ?>
<input type="hidden" name="fa_x_slide6" id= "fa_x_slide6" value="0">
<?php } else { ?>
<input type="hidden" name="fa_x_slide6" id= "fa_x_slide6" value="1">
<?php } ?>
<input type="hidden" name="fs_x_slide6" id= "fs_x_slide6" value="200">
</span>
<table id="ft_x_slide6" class="table table-condensed pull-left ewUploadTable"><tbody class="files"></tbody></table>
</span>
<?php echo $layout->slide6->CustomMsg ?></td>
	</tr>
<?php } ?>
</table>
</td></tr></table>
		</div>
		<div class="tab-pane" id="tab_layout2">
		</div>
		<div class="tab-pane" id="tab_layout3">
<table cellspacing="0" class="ewGrid" style="width: 100%"><tr><td>
<table id="tbl_layoutedit3" class="table table-bordered table-striped">
<?php if ($layout->home2Dcaption1->Visible) { // home-caption1 ?>
	<tr id="r_home2Dcaption1">
		<td><span id="elh_layout_home2Dcaption1"><?php echo $layout->home2Dcaption1->FldCaption() ?></span></td>
		<td<?php echo $layout->home2Dcaption1->CellAttributes() ?>>
<span id="el_layout_home2Dcaption1" class="control-group">
<input type="text" data-field="x_home2Dcaption1" name="x_home2Dcaption1" id="x_home2Dcaption1" size="30" maxlength="250" placeholder="<?php echo $layout->home2Dcaption1->PlaceHolder ?>" value="<?php echo $layout->home2Dcaption1->EditValue ?>"<?php echo $layout->home2Dcaption1->EditAttributes() ?>>
</span>
<?php echo $layout->home2Dcaption1->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($layout->home2Dtext1->Visible) { // home-text1 ?>
	<tr id="r_home2Dtext1">
		<td><span id="elh_layout_home2Dtext1"><?php echo $layout->home2Dtext1->FldCaption() ?></span></td>
		<td<?php echo $layout->home2Dtext1->CellAttributes() ?>>
<span id="el_layout_home2Dtext1" class="control-group">
<textarea data-field="x_home2Dtext1" class="editor" name="x_home2Dtext1" id="x_home2Dtext1" cols="35" rows="4" placeholder="<?php echo $layout->home2Dtext1->PlaceHolder ?>"<?php echo $layout->home2Dtext1->EditAttributes() ?>><?php echo $layout->home2Dtext1->EditValue ?></textarea>
<script type="text/javascript">
ew_CreateEditor("flayoutedit", "x_home2Dtext1", 35, 4, <?php echo ($layout->home2Dtext1->ReadOnly || FALSE) ? "true" : "false" ?>);
</script>
</span>
<?php echo $layout->home2Dtext1->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($layout->home2Dcaption2->Visible) { // home-caption2 ?>
	<tr id="r_home2Dcaption2">
		<td><span id="elh_layout_home2Dcaption2"><?php echo $layout->home2Dcaption2->FldCaption() ?></span></td>
		<td<?php echo $layout->home2Dcaption2->CellAttributes() ?>>
<span id="el_layout_home2Dcaption2" class="control-group">
<input type="text" data-field="x_home2Dcaption2" name="x_home2Dcaption2" id="x_home2Dcaption2" size="30" maxlength="100" placeholder="<?php echo $layout->home2Dcaption2->PlaceHolder ?>" value="<?php echo $layout->home2Dcaption2->EditValue ?>"<?php echo $layout->home2Dcaption2->EditAttributes() ?>>
</span>
<?php echo $layout->home2Dcaption2->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($layout->home2Dtext2->Visible) { // home-text2 ?>
	<tr id="r_home2Dtext2">
		<td><span id="elh_layout_home2Dtext2"><?php echo $layout->home2Dtext2->FldCaption() ?></span></td>
		<td<?php echo $layout->home2Dtext2->CellAttributes() ?>>
<span id="el_layout_home2Dtext2" class="control-group">
<textarea data-field="x_home2Dtext2" class="editor" name="x_home2Dtext2" id="x_home2Dtext2" cols="35" rows="4" placeholder="<?php echo $layout->home2Dtext2->PlaceHolder ?>"<?php echo $layout->home2Dtext2->EditAttributes() ?>><?php echo $layout->home2Dtext2->EditValue ?></textarea>
<script type="text/javascript">
ew_CreateEditor("flayoutedit", "x_home2Dtext2", 35, 4, <?php echo ($layout->home2Dtext2->ReadOnly || FALSE) ? "true" : "false" ?>);
</script>
</span>
<?php echo $layout->home2Dtext2->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($layout->home2Dcaption3->Visible) { // home-caption3 ?>
	<tr id="r_home2Dcaption3">
		<td><span id="elh_layout_home2Dcaption3"><?php echo $layout->home2Dcaption3->FldCaption() ?></span></td>
		<td<?php echo $layout->home2Dcaption3->CellAttributes() ?>>
<span id="el_layout_home2Dcaption3" class="control-group">
<input type="text" data-field="x_home2Dcaption3" name="x_home2Dcaption3" id="x_home2Dcaption3" size="30" maxlength="200" placeholder="<?php echo $layout->home2Dcaption3->PlaceHolder ?>" value="<?php echo $layout->home2Dcaption3->EditValue ?>"<?php echo $layout->home2Dcaption3->EditAttributes() ?>>
</span>
<?php echo $layout->home2Dcaption3->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($layout->home2Dtext3->Visible) { // home-text3 ?>
	<tr id="r_home2Dtext3">
		<td><span id="elh_layout_home2Dtext3"><?php echo $layout->home2Dtext3->FldCaption() ?></span></td>
		<td<?php echo $layout->home2Dtext3->CellAttributes() ?>>
<span id="el_layout_home2Dtext3" class="control-group">
<textarea data-field="x_home2Dtext3" class="editor" name="x_home2Dtext3" id="x_home2Dtext3" cols="35" rows="4" placeholder="<?php echo $layout->home2Dtext3->PlaceHolder ?>"<?php echo $layout->home2Dtext3->EditAttributes() ?>><?php echo $layout->home2Dtext3->EditValue ?></textarea>
<script type="text/javascript">
ew_CreateEditor("flayoutedit", "x_home2Dtext3", 35, 4, <?php echo ($layout->home2Dtext3->ReadOnly || FALSE) ? "true" : "false" ?>);
</script>
</span>
<?php echo $layout->home2Dtext3->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($layout->home2Dcaption4->Visible) { // home-caption4 ?>
	<tr id="r_home2Dcaption4">
		<td><span id="elh_layout_home2Dcaption4"><?php echo $layout->home2Dcaption4->FldCaption() ?></span></td>
		<td<?php echo $layout->home2Dcaption4->CellAttributes() ?>>
<span id="el_layout_home2Dcaption4" class="control-group">
<textarea data-field="x_home2Dcaption4" name="x_home2Dcaption4" id="x_home2Dcaption4" cols="35" rows="4" placeholder="<?php echo $layout->home2Dcaption4->PlaceHolder ?>"<?php echo $layout->home2Dcaption4->EditAttributes() ?>><?php echo $layout->home2Dcaption4->EditValue ?></textarea>
</span>
<?php echo $layout->home2Dcaption4->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($layout->home2Dtext4->Visible) { // home-text4 ?>
	<tr id="r_home2Dtext4">
		<td><span id="elh_layout_home2Dtext4"><?php echo $layout->home2Dtext4->FldCaption() ?></span></td>
		<td<?php echo $layout->home2Dtext4->CellAttributes() ?>>
<span id="el_layout_home2Dtext4" class="control-group">
<textarea data-field="x_home2Dtext4" class="editor" name="x_home2Dtext4" id="x_home2Dtext4" cols="35" rows="4" placeholder="<?php echo $layout->home2Dtext4->PlaceHolder ?>"<?php echo $layout->home2Dtext4->EditAttributes() ?>><?php echo $layout->home2Dtext4->EditValue ?></textarea>
<script type="text/javascript">
ew_CreateEditor("flayoutedit", "x_home2Dtext4", 35, 4, <?php echo ($layout->home2Dtext4->ReadOnly || FALSE) ? "true" : "false" ?>);
</script>
</span>
<?php echo $layout->home2Dtext4->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($layout->home2Dcaption5->Visible) { // home-caption5 ?>
	<tr id="r_home2Dcaption5">
		<td><span id="elh_layout_home2Dcaption5"><?php echo $layout->home2Dcaption5->FldCaption() ?></span></td>
		<td<?php echo $layout->home2Dcaption5->CellAttributes() ?>>
<span id="el_layout_home2Dcaption5" class="control-group">
<input type="text" data-field="x_home2Dcaption5" name="x_home2Dcaption5" id="x_home2Dcaption5" size="30" maxlength="200" placeholder="<?php echo $layout->home2Dcaption5->PlaceHolder ?>" value="<?php echo $layout->home2Dcaption5->EditValue ?>"<?php echo $layout->home2Dcaption5->EditAttributes() ?>>
</span>
<?php echo $layout->home2Dcaption5->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($layout->home2Dtext5->Visible) { // home-text5 ?>
	<tr id="r_home2Dtext5">
		<td><span id="elh_layout_home2Dtext5"><?php echo $layout->home2Dtext5->FldCaption() ?></span></td>
		<td<?php echo $layout->home2Dtext5->CellAttributes() ?>>
<span id="el_layout_home2Dtext5" class="control-group">
<textarea data-field="x_home2Dtext5" class="editor" name="x_home2Dtext5" id="x_home2Dtext5" cols="35" rows="4" placeholder="<?php echo $layout->home2Dtext5->PlaceHolder ?>"<?php echo $layout->home2Dtext5->EditAttributes() ?>><?php echo $layout->home2Dtext5->EditValue ?></textarea>
<script type="text/javascript">
ew_CreateEditor("flayoutedit", "x_home2Dtext5", 35, 4, <?php echo ($layout->home2Dtext5->ReadOnly || FALSE) ? "true" : "false" ?>);
</script>
</span>
<?php echo $layout->home2Dtext5->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($layout->home2Dcaption6->Visible) { // home-caption6 ?>
	<tr id="r_home2Dcaption6">
		<td><span id="elh_layout_home2Dcaption6"><?php echo $layout->home2Dcaption6->FldCaption() ?></span></td>
		<td<?php echo $layout->home2Dcaption6->CellAttributes() ?>>
<span id="el_layout_home2Dcaption6" class="control-group">
<input type="text" data-field="x_home2Dcaption6" name="x_home2Dcaption6" id="x_home2Dcaption6" size="30" maxlength="200" placeholder="<?php echo $layout->home2Dcaption6->PlaceHolder ?>" value="<?php echo $layout->home2Dcaption6->EditValue ?>"<?php echo $layout->home2Dcaption6->EditAttributes() ?>>
</span>
<?php echo $layout->home2Dcaption6->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($layout->home2Dtext6->Visible) { // home-text6 ?>
	<tr id="r_home2Dtext6">
		<td><span id="elh_layout_home2Dtext6"><?php echo $layout->home2Dtext6->FldCaption() ?></span></td>
		<td<?php echo $layout->home2Dtext6->CellAttributes() ?>>
<span id="el_layout_home2Dtext6" class="control-group">
<textarea data-field="x_home2Dtext6" class="editor" name="x_home2Dtext6" id="x_home2Dtext6" cols="35" rows="4" placeholder="<?php echo $layout->home2Dtext6->PlaceHolder ?>"<?php echo $layout->home2Dtext6->EditAttributes() ?>><?php echo $layout->home2Dtext6->EditValue ?></textarea>
<script type="text/javascript">
ew_CreateEditor("flayoutedit", "x_home2Dtext6", 35, 4, <?php echo ($layout->home2Dtext6->ReadOnly || FALSE) ? "true" : "false" ?>);
</script>
</span>
<?php echo $layout->home2Dtext6->CustomMsg ?></td>
	</tr>
<?php } ?>
</table>
</td></tr></table>
		</div>
		<div class="tab-pane" id="tab_layout4">
<table cellspacing="0" class="ewGrid" style="width: 100%"><tr><td>
<table id="tbl_layoutedit4" class="table table-bordered table-striped">
<?php if ($layout->footer2D1->Visible) { // footer-1 ?>
	<tr id="r_footer2D1">
		<td><span id="elh_layout_footer2D1"><?php echo $layout->footer2D1->FldCaption() ?></span></td>
		<td<?php echo $layout->footer2D1->CellAttributes() ?>>
<span id="el_layout_footer2D1" class="control-group">
<textarea data-field="x_footer2D1" name="x_footer2D1" id="x_footer2D1" cols="35" rows="4" placeholder="<?php echo $layout->footer2D1->PlaceHolder ?>"<?php echo $layout->footer2D1->EditAttributes() ?>><?php echo $layout->footer2D1->EditValue ?></textarea>
</span>
<?php echo $layout->footer2D1->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($layout->footer2D2->Visible) { // footer-2 ?>
	<tr id="r_footer2D2">
		<td><span id="elh_layout_footer2D2"><?php echo $layout->footer2D2->FldCaption() ?></span></td>
		<td<?php echo $layout->footer2D2->CellAttributes() ?>>
<span id="el_layout_footer2D2" class="control-group">
<textarea data-field="x_footer2D2" name="x_footer2D2" id="x_footer2D2" cols="35" rows="4" placeholder="<?php echo $layout->footer2D2->PlaceHolder ?>"<?php echo $layout->footer2D2->EditAttributes() ?>><?php echo $layout->footer2D2->EditValue ?></textarea>
</span>
<?php echo $layout->footer2D2->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($layout->footer2D3->Visible) { // footer-3 ?>
	<tr id="r_footer2D3">
		<td><span id="elh_layout_footer2D3"><?php echo $layout->footer2D3->FldCaption() ?></span></td>
		<td<?php echo $layout->footer2D3->CellAttributes() ?>>
<span id="el_layout_footer2D3" class="control-group">
<textarea data-field="x_footer2D3" name="x_footer2D3" id="x_footer2D3" cols="35" rows="4" placeholder="<?php echo $layout->footer2D3->PlaceHolder ?>"<?php echo $layout->footer2D3->EditAttributes() ?>><?php echo $layout->footer2D3->EditValue ?></textarea>
</span>
<?php echo $layout->footer2D3->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($layout->footer2D4->Visible) { // footer-4 ?>
	<tr id="r_footer2D4">
		<td><span id="elh_layout_footer2D4"><?php echo $layout->footer2D4->FldCaption() ?></span></td>
		<td<?php echo $layout->footer2D4->CellAttributes() ?>>
<span id="el_layout_footer2D4" class="control-group">
<textarea data-field="x_footer2D4" name="x_footer2D4" id="x_footer2D4" cols="35" rows="4" placeholder="<?php echo $layout->footer2D4->PlaceHolder ?>"<?php echo $layout->footer2D4->EditAttributes() ?>><?php echo $layout->footer2D4->EditValue ?></textarea>
</span>
<?php echo $layout->footer2D4->CustomMsg ?></td>
	</tr>
<?php } ?>
</table>
</td></tr></table>
		</div>
		<div class="tab-pane" id="tab_layout5">
<table cellspacing="0" class="ewGrid" style="width: 100%"><tr><td>
<table id="tbl_layoutedit5" class="table table-bordered table-striped">
<?php if ($layout->contact2Demail->Visible) { // contact-email ?>
	<tr id="r_contact2Demail">
		<td><span id="elh_layout_contact2Demail"><?php echo $layout->contact2Demail->FldCaption() ?></span></td>
		<td<?php echo $layout->contact2Demail->CellAttributes() ?>>
<span id="el_layout_contact2Demail" class="control-group">
<input type="text" data-field="x_contact2Demail" name="x_contact2Demail" id="x_contact2Demail" size="30" maxlength="100" placeholder="<?php echo $layout->contact2Demail->PlaceHolder ?>" value="<?php echo $layout->contact2Demail->EditValue ?>"<?php echo $layout->contact2Demail->EditAttributes() ?>>
</span>
<?php echo $layout->contact2Demail->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($layout->contact2Dtext1->Visible) { // contact-text1 ?>
	<tr id="r_contact2Dtext1">
		<td><span id="elh_layout_contact2Dtext1"><?php echo $layout->contact2Dtext1->FldCaption() ?></span></td>
		<td<?php echo $layout->contact2Dtext1->CellAttributes() ?>>
<span id="el_layout_contact2Dtext1" class="control-group">
<textarea data-field="x_contact2Dtext1" name="x_contact2Dtext1" id="x_contact2Dtext1" cols="35" rows="4" placeholder="<?php echo $layout->contact2Dtext1->PlaceHolder ?>"<?php echo $layout->contact2Dtext1->EditAttributes() ?>><?php echo $layout->contact2Dtext1->EditValue ?></textarea>
</span>
<?php echo $layout->contact2Dtext1->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($layout->contact2Dtext2->Visible) { // contact-text2 ?>
	<tr id="r_contact2Dtext2">
		<td><span id="elh_layout_contact2Dtext2"><?php echo $layout->contact2Dtext2->FldCaption() ?></span></td>
		<td<?php echo $layout->contact2Dtext2->CellAttributes() ?>>
<span id="el_layout_contact2Dtext2" class="control-group">
<textarea data-field="x_contact2Dtext2" name="x_contact2Dtext2" id="x_contact2Dtext2" cols="35" rows="4" placeholder="<?php echo $layout->contact2Dtext2->PlaceHolder ?>"<?php echo $layout->contact2Dtext2->EditAttributes() ?>><?php echo $layout->contact2Dtext2->EditValue ?></textarea>
</span>
<?php echo $layout->contact2Dtext2->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($layout->contact2Dtext3->Visible) { // contact-text3 ?>
	<tr id="r_contact2Dtext3">
		<td><span id="elh_layout_contact2Dtext3"><?php echo $layout->contact2Dtext3->FldCaption() ?></span></td>
		<td<?php echo $layout->contact2Dtext3->CellAttributes() ?>>
<span id="el_layout_contact2Dtext3" class="control-group">
<textarea data-field="x_contact2Dtext3" name="x_contact2Dtext3" id="x_contact2Dtext3" cols="35" rows="4" placeholder="<?php echo $layout->contact2Dtext3->PlaceHolder ?>"<?php echo $layout->contact2Dtext3->EditAttributes() ?>><?php echo $layout->contact2Dtext3->EditValue ?></textarea>
</span>
<?php echo $layout->contact2Dtext3->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($layout->contact2Dtext4->Visible) { // contact-text4 ?>
	<tr id="r_contact2Dtext4">
		<td><span id="elh_layout_contact2Dtext4"><?php echo $layout->contact2Dtext4->FldCaption() ?></span></td>
		<td<?php echo $layout->contact2Dtext4->CellAttributes() ?>>
<span id="el_layout_contact2Dtext4" class="control-group">
<textarea data-field="x_contact2Dtext4" name="x_contact2Dtext4" id="x_contact2Dtext4" cols="35" rows="4" placeholder="<?php echo $layout->contact2Dtext4->PlaceHolder ?>"<?php echo $layout->contact2Dtext4->EditAttributes() ?>><?php echo $layout->contact2Dtext4->EditValue ?></textarea>
</span>
<?php echo $layout->contact2Dtext4->CustomMsg ?></td>
	</tr>
<?php } ?>
</table>
</td></tr></table>
		</div>
	</div>
</div>
</td></tr></tbody></table>
<table class="ewPager">
<tr><td>
<?php if (!isset($layout_edit->Pager)) $layout_edit->Pager = new cNumericPager($layout_edit->StartRec, $layout_edit->DisplayRecs, $layout_edit->TotalRecs, $layout_edit->RecRange) ?>
<?php if ($layout_edit->Pager->RecordCount > 0) { ?>
<table cellspacing="0" class="ewStdTable"><tbody><tr><td>
<div class="pagination"><ul>
	<?php if ($layout_edit->Pager->FirstButton->Enabled) { ?>
	<li><a href="<?php echo $layout_edit->PageUrl() ?>start=<?php echo $layout_edit->Pager->FirstButton->Start ?>"><?php echo $Language->Phrase("PagerFirst") ?></a></li>
	<?php } ?>
	<?php if ($layout_edit->Pager->PrevButton->Enabled) { ?>
	<li><a href="<?php echo $layout_edit->PageUrl() ?>start=<?php echo $layout_edit->Pager->PrevButton->Start ?>"><?php echo $Language->Phrase("PagerPrevious") ?></a></li>
	<?php } ?>
	<?php foreach ($layout_edit->Pager->Items as $PagerItem) { ?>
		<li<?php if (!$PagerItem->Enabled) { echo " class=\" active\""; } ?>><a href="<?php if ($PagerItem->Enabled) { echo $layout_edit->PageUrl() . "start=" . $PagerItem->Start; } else { echo "#"; } ?>"><?php echo $PagerItem->Text ?></a></li>
	<?php } ?>
	<?php if ($layout_edit->Pager->NextButton->Enabled) { ?>
	<li><a href="<?php echo $layout_edit->PageUrl() ?>start=<?php echo $layout_edit->Pager->NextButton->Start ?>"><?php echo $Language->Phrase("PagerNext") ?></a></li>
	<?php } ?>
	<?php if ($layout_edit->Pager->LastButton->Enabled) { ?>
	<li><a href="<?php echo $layout_edit->PageUrl() ?>start=<?php echo $layout_edit->Pager->LastButton->Start ?>"><?php echo $Language->Phrase("PagerLast") ?></a></li>
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
flayoutedit.Init();
<?php if (EW_MOBILE_REFLOW && ew_IsMobile()) { ?>
ew_Reflow();
<?php } ?>
</script>
<?php
$layout_edit->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$layout_edit->Page_Terminate();
?>
