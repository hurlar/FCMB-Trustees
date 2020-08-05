<?php
if (session_id() == "") session_start(); // Initialize Session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg10.php" ?>
<?php include_once "ewmysql10.php" ?>
<?php include_once "phpfn10.php" ?>
<?php include_once "contentinfo.php" ?>
<?php include_once "adminusersinfo.php" ?>
<?php include_once "userfn10.php" ?>
<?php

//
// Page class
//

$content_edit = NULL; // Initialize page object first

class ccontent_edit extends ccontent {

	// Page ID
	var $PageID = 'edit';

	// Project ID
	var $ProjectID = "{D9B361E7-B2C1-4293-B9B3-B581986A15CC}";

	// Table name
	var $TableName = 'content';

	// Page object name
	var $PageObjName = 'content_edit';

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

		// Table object (content)
		if (!isset($GLOBALS["content"])) {
			$GLOBALS["content"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["content"];
		}

		// Table object (adminusers)
		if (!isset($GLOBALS['adminusers'])) $GLOBALS['adminusers'] = new cadminusers();

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'edit', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'content', TRUE);

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
			$this->Page_Terminate("contentlist.php"); // Return to list page
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
					$this->Page_Terminate("contentlist.php"); // Return to list page
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
					if (ew_GetPageName($sReturnUrl) == "contentview.php")
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
		$this->uploads->Upload->Index = $objForm->Index;
		if ($this->uploads->Upload->UploadFile()) {

			// No action required
		} else {
			echo $this->uploads->Upload->Message;
			$this->Page_Terminate();
			exit();
		}
		$this->uploads->CurrentValue = $this->uploads->Upload->FileName;
	}

	// Load form values
	function LoadFormValues() {

		// Load from form
		global $objForm;
		$this->GetUploadFiles(); // Get upload files
		if (!$this->id->FldIsDetailKey)
			$this->id->setFormValue($objForm->GetValue("x_id"));
		if (!$this->pg_name->FldIsDetailKey) {
			$this->pg_name->setFormValue($objForm->GetValue("x_pg_name"));
		}
		if (!$this->pg_cat->FldIsDetailKey) {
			$this->pg_cat->setFormValue($objForm->GetValue("x_pg_cat"));
		}
		if (!$this->content->FldIsDetailKey) {
			$this->content->setFormValue($objForm->GetValue("x_content"));
		}
		if (!$this->pg_alias->FldIsDetailKey) {
			$this->pg_alias->setFormValue($objForm->GetValue("x_pg_alias"));
		}
		if (!$this->pg_type->FldIsDetailKey) {
			$this->pg_type->setFormValue($objForm->GetValue("x_pg_type"));
		}
		if (!$this->pg_title->FldIsDetailKey) {
			$this->pg_title->setFormValue($objForm->GetValue("x_pg_title"));
		}
		if (!$this->keywords->FldIsDetailKey) {
			$this->keywords->setFormValue($objForm->GetValue("x_keywords"));
		}
		if (!$this->pr_status->FldIsDetailKey) {
			$this->pr_status->setFormValue($objForm->GetValue("x_pr_status"));
		}
		if (!$this->rate_ord->FldIsDetailKey) {
			$this->rate_ord->setFormValue($objForm->GetValue("x_rate_ord"));
		}
	}

	// Restore form values
	function RestoreFormValues() {
		global $objForm;
		$this->LoadRow();
		$this->id->CurrentValue = $this->id->FormValue;
		$this->pg_name->CurrentValue = $this->pg_name->FormValue;
		$this->pg_cat->CurrentValue = $this->pg_cat->FormValue;
		$this->content->CurrentValue = $this->content->FormValue;
		$this->pg_alias->CurrentValue = $this->pg_alias->FormValue;
		$this->pg_type->CurrentValue = $this->pg_type->FormValue;
		$this->pg_title->CurrentValue = $this->pg_title->FormValue;
		$this->keywords->CurrentValue = $this->keywords->FormValue;
		$this->pr_status->CurrentValue = $this->pr_status->FormValue;
		$this->rate_ord->CurrentValue = $this->rate_ord->FormValue;
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
		$this->pg_name->setDbValue($rs->fields('pg_name'));
		$this->pg_cat->setDbValue($rs->fields('pg_cat'));
		$this->content->setDbValue($rs->fields('content'));
		$this->pg_alias->setDbValue($rs->fields('pg_alias'));
		$this->pg_type->setDbValue($rs->fields('pg_type'));
		$this->pg_menu->setDbValue($rs->fields('pg_menu'));
		$this->pg_title->setDbValue($rs->fields('pg_title'));
		$this->keywords->setDbValue($rs->fields('keywords'));
		$this->pr_status->setDbValue($rs->fields('pr_status'));
		$this->pg_url->setDbValue($rs->fields('pg_url'));
		$this->secured_st->setDbValue($rs->fields('secured_st'));
		$this->rate_ord->setDbValue($rs->fields('rate_ord'));
		$this->uploads->Upload->DbValue = $rs->fields('uploads');
		$this->intro->setDbValue($rs->fields('intro'));
		$this->sidebar->setDbValue($rs->fields('sidebar'));
		$this->postdate->setDbValue($rs->fields('postdate'));
		$this->img1->setDbValue($rs->fields('img1'));
		$this->img2->setDbValue($rs->fields('img2'));
		$this->creator->setDbValue($rs->fields('creator'));
		$this->datep->setDbValue($rs->fields('datep'));
	}

	// Load DbValue from recordset
	function LoadDbValues(&$rs) {
		if (!$rs || !is_array($rs) && $rs->EOF) return;
		$row = is_array($rs) ? $rs : $rs->fields;
		$this->id->DbValue = $row['id'];
		$this->pg_name->DbValue = $row['pg_name'];
		$this->pg_cat->DbValue = $row['pg_cat'];
		$this->content->DbValue = $row['content'];
		$this->pg_alias->DbValue = $row['pg_alias'];
		$this->pg_type->DbValue = $row['pg_type'];
		$this->pg_menu->DbValue = $row['pg_menu'];
		$this->pg_title->DbValue = $row['pg_title'];
		$this->keywords->DbValue = $row['keywords'];
		$this->pr_status->DbValue = $row['pr_status'];
		$this->pg_url->DbValue = $row['pg_url'];
		$this->secured_st->DbValue = $row['secured_st'];
		$this->rate_ord->DbValue = $row['rate_ord'];
		$this->uploads->Upload->DbValue = $row['uploads'];
		$this->intro->DbValue = $row['intro'];
		$this->sidebar->DbValue = $row['sidebar'];
		$this->postdate->DbValue = $row['postdate'];
		$this->img1->DbValue = $row['img1'];
		$this->img2->DbValue = $row['img2'];
		$this->creator->DbValue = $row['creator'];
		$this->datep->DbValue = $row['datep'];
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
		// pg_name
		// pg_cat
		// content
		// pg_alias
		// pg_type
		// pg_menu
		// pg_title
		// keywords
		// pr_status
		// pg_url
		// secured_st
		// rate_ord
		// uploads
		// intro
		// sidebar
		// postdate
		// img1
		// img2
		// creator
		// datep

		if ($this->RowType == EW_ROWTYPE_VIEW) { // View row

			// id
			$this->id->ViewValue = $this->id->CurrentValue;
			$this->id->ViewCustomAttributes = "";

			// pg_name
			$this->pg_name->ViewValue = $this->pg_name->CurrentValue;
			$this->pg_name->ViewCustomAttributes = "";

			// pg_cat
			if (strval($this->pg_cat->CurrentValue) <> "") {
				$sFilterWrk = "`pg_cat`" . ew_SearchString("=", $this->pg_cat->CurrentValue, EW_DATATYPE_STRING);
			$sSqlWrk = "SELECT `pg_cat`, `pg_cat` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `page_cat`";
			$sWhereWrk = "";
			if ($sFilterWrk <> "") {
				ew_AddFilter($sWhereWrk, $sFilterWrk);
			}

			// Call Lookup selecting
			$this->Lookup_Selecting($this->pg_cat, $sWhereWrk);
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
				$rswrk = $conn->Execute($sSqlWrk);
				if ($rswrk && !$rswrk->EOF) { // Lookup values found
					$this->pg_cat->ViewValue = $rswrk->fields('DispFld');
					$rswrk->Close();
				} else {
					$this->pg_cat->ViewValue = $this->pg_cat->CurrentValue;
				}
			} else {
				$this->pg_cat->ViewValue = NULL;
			}
			$this->pg_cat->ViewCustomAttributes = "";

			// content
			$this->content->ViewValue = $this->content->CurrentValue;
			$this->content->ViewCustomAttributes = "";

			// pg_alias
			$this->pg_alias->ViewValue = $this->pg_alias->CurrentValue;
			$this->pg_alias->ViewCustomAttributes = "";

			// pg_type
			$this->pg_type->ViewValue = $this->pg_type->CurrentValue;
			if (strval($this->pg_type->CurrentValue) <> "") {
				$sFilterWrk = "`name`" . ew_SearchString("=", $this->pg_type->CurrentValue, EW_DATATYPE_STRING);
			$sSqlWrk = "SELECT `name`, `name` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `page_template`";
			$sWhereWrk = "";
			if ($sFilterWrk <> "") {
				ew_AddFilter($sWhereWrk, $sFilterWrk);
			}

			// Call Lookup selecting
			$this->Lookup_Selecting($this->pg_type, $sWhereWrk);
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
				$rswrk = $conn->Execute($sSqlWrk);
				if ($rswrk && !$rswrk->EOF) { // Lookup values found
					$this->pg_type->ViewValue = $rswrk->fields('DispFld');
					$rswrk->Close();
				} else {
					$this->pg_type->ViewValue = $this->pg_type->CurrentValue;
				}
			} else {
				$this->pg_type->ViewValue = NULL;
			}
			$this->pg_type->ViewCustomAttributes = "";

			// pg_menu
			$this->pg_menu->ViewValue = $this->pg_menu->CurrentValue;
			$this->pg_menu->ViewCustomAttributes = "";

			// pg_title
			$this->pg_title->ViewValue = $this->pg_title->CurrentValue;
			$this->pg_title->ViewCustomAttributes = "";

			// keywords
			$this->keywords->ViewValue = $this->keywords->CurrentValue;
			$this->keywords->ViewCustomAttributes = "";

			// pr_status
			if (strval($this->pr_status->CurrentValue) <> "") {
				switch ($this->pr_status->CurrentValue) {
					case $this->pr_status->FldTagValue(1):
						$this->pr_status->ViewValue = $this->pr_status->FldTagCaption(1) <> "" ? $this->pr_status->FldTagCaption(1) : $this->pr_status->CurrentValue;
						break;
					case $this->pr_status->FldTagValue(2):
						$this->pr_status->ViewValue = $this->pr_status->FldTagCaption(2) <> "" ? $this->pr_status->FldTagCaption(2) : $this->pr_status->CurrentValue;
						break;
					default:
						$this->pr_status->ViewValue = $this->pr_status->CurrentValue;
				}
			} else {
				$this->pr_status->ViewValue = NULL;
			}
			$this->pr_status->ViewCustomAttributes = "";

			// pg_url
			$this->pg_url->ViewValue = $this->pg_url->CurrentValue;
			$this->pg_url->ViewCustomAttributes = "";

			// secured_st
			if (ew_ConvertToBool($this->secured_st->CurrentValue)) {
				$this->secured_st->ViewValue = $this->secured_st->FldTagCaption(2) <> "" ? $this->secured_st->FldTagCaption(2) : "Secured";
			} else {
				$this->secured_st->ViewValue = $this->secured_st->FldTagCaption(1) <> "" ? $this->secured_st->FldTagCaption(1) : "Public";
			}
			$this->secured_st->ViewCustomAttributes = "";

			// rate_ord
			if (strval($this->rate_ord->CurrentValue) <> "") {
				switch ($this->rate_ord->CurrentValue) {
					case $this->rate_ord->FldTagValue(1):
						$this->rate_ord->ViewValue = $this->rate_ord->FldTagCaption(1) <> "" ? $this->rate_ord->FldTagCaption(1) : $this->rate_ord->CurrentValue;
						break;
					case $this->rate_ord->FldTagValue(2):
						$this->rate_ord->ViewValue = $this->rate_ord->FldTagCaption(2) <> "" ? $this->rate_ord->FldTagCaption(2) : $this->rate_ord->CurrentValue;
						break;
					case $this->rate_ord->FldTagValue(3):
						$this->rate_ord->ViewValue = $this->rate_ord->FldTagCaption(3) <> "" ? $this->rate_ord->FldTagCaption(3) : $this->rate_ord->CurrentValue;
						break;
					case $this->rate_ord->FldTagValue(4):
						$this->rate_ord->ViewValue = $this->rate_ord->FldTagCaption(4) <> "" ? $this->rate_ord->FldTagCaption(4) : $this->rate_ord->CurrentValue;
						break;
					case $this->rate_ord->FldTagValue(5):
						$this->rate_ord->ViewValue = $this->rate_ord->FldTagCaption(5) <> "" ? $this->rate_ord->FldTagCaption(5) : $this->rate_ord->CurrentValue;
						break;
					case $this->rate_ord->FldTagValue(6):
						$this->rate_ord->ViewValue = $this->rate_ord->FldTagCaption(6) <> "" ? $this->rate_ord->FldTagCaption(6) : $this->rate_ord->CurrentValue;
						break;
					case $this->rate_ord->FldTagValue(7):
						$this->rate_ord->ViewValue = $this->rate_ord->FldTagCaption(7) <> "" ? $this->rate_ord->FldTagCaption(7) : $this->rate_ord->CurrentValue;
						break;
					case $this->rate_ord->FldTagValue(8):
						$this->rate_ord->ViewValue = $this->rate_ord->FldTagCaption(8) <> "" ? $this->rate_ord->FldTagCaption(8) : $this->rate_ord->CurrentValue;
						break;
					case $this->rate_ord->FldTagValue(9):
						$this->rate_ord->ViewValue = $this->rate_ord->FldTagCaption(9) <> "" ? $this->rate_ord->FldTagCaption(9) : $this->rate_ord->CurrentValue;
						break;
					case $this->rate_ord->FldTagValue(10):
						$this->rate_ord->ViewValue = $this->rate_ord->FldTagCaption(10) <> "" ? $this->rate_ord->FldTagCaption(10) : $this->rate_ord->CurrentValue;
						break;
					case $this->rate_ord->FldTagValue(11):
						$this->rate_ord->ViewValue = $this->rate_ord->FldTagCaption(11) <> "" ? $this->rate_ord->FldTagCaption(11) : $this->rate_ord->CurrentValue;
						break;
					default:
						$this->rate_ord->ViewValue = $this->rate_ord->CurrentValue;
				}
			} else {
				$this->rate_ord->ViewValue = NULL;
			}
			$this->rate_ord->ViewCustomAttributes = "";

			// uploads
			$this->uploads->UploadPath = "../uploads/";
			if (!ew_Empty($this->uploads->Upload->DbValue)) {
				$this->uploads->ViewValue = $this->uploads->Upload->DbValue;
			} else {
				$this->uploads->ViewValue = "";
			}
			$this->uploads->ViewCustomAttributes = "";

			// intro
			$this->intro->ViewValue = $this->intro->CurrentValue;
			$this->intro->ViewCustomAttributes = "";

			// sidebar
			$this->sidebar->ViewValue = $this->sidebar->CurrentValue;
			$this->sidebar->ViewCustomAttributes = "";

			// postdate
			$this->postdate->ViewValue = $this->postdate->CurrentValue;
			$this->postdate->ViewCustomAttributes = "";

			// img1
			$this->img1->ViewValue = $this->img1->CurrentValue;
			$this->img1->ViewCustomAttributes = "";

			// img2
			$this->img2->ViewValue = $this->img2->CurrentValue;
			$this->img2->ViewCustomAttributes = "";

			// creator
			$this->creator->ViewValue = $this->creator->CurrentValue;
			$this->creator->ViewCustomAttributes = "";

			// datep
			$this->datep->ViewValue = $this->datep->CurrentValue;
			$this->datep->ViewCustomAttributes = "";

			// id
			$this->id->LinkCustomAttributes = "";
			$this->id->HrefValue = "";
			$this->id->TooltipValue = "";

			// pg_name
			$this->pg_name->LinkCustomAttributes = "";
			$this->pg_name->HrefValue = "";
			$this->pg_name->TooltipValue = "";

			// pg_cat
			$this->pg_cat->LinkCustomAttributes = "";
			$this->pg_cat->HrefValue = "";
			$this->pg_cat->TooltipValue = "";

			// content
			$this->content->LinkCustomAttributes = "";
			$this->content->HrefValue = "";
			$this->content->TooltipValue = "";

			// pg_alias
			$this->pg_alias->LinkCustomAttributes = "";
			$this->pg_alias->HrefValue = "";
			$this->pg_alias->TooltipValue = "";

			// pg_type
			$this->pg_type->LinkCustomAttributes = "";
			$this->pg_type->HrefValue = "";
			$this->pg_type->TooltipValue = "";

			// pg_title
			$this->pg_title->LinkCustomAttributes = "";
			$this->pg_title->HrefValue = "";
			$this->pg_title->TooltipValue = "";

			// keywords
			$this->keywords->LinkCustomAttributes = "";
			$this->keywords->HrefValue = "";
			$this->keywords->TooltipValue = "";

			// pr_status
			$this->pr_status->LinkCustomAttributes = "";
			$this->pr_status->HrefValue = "";
			$this->pr_status->TooltipValue = "";

			// rate_ord
			$this->rate_ord->LinkCustomAttributes = "";
			$this->rate_ord->HrefValue = "";
			$this->rate_ord->TooltipValue = "";

			// uploads
			$this->uploads->LinkCustomAttributes = "";
			$this->uploads->HrefValue = "";
			$this->uploads->HrefValue2 = $this->uploads->UploadPath . $this->uploads->Upload->DbValue;
			$this->uploads->TooltipValue = "";
		} elseif ($this->RowType == EW_ROWTYPE_EDIT) { // Edit row

			// id
			$this->id->EditCustomAttributes = "";
			$this->id->EditValue = $this->id->CurrentValue;
			$this->id->ViewCustomAttributes = "";

			// pg_name
			$this->pg_name->EditCustomAttributes = "style='width:97%' ";
			$this->pg_name->EditValue = ew_HtmlEncode($this->pg_name->CurrentValue);
			$this->pg_name->PlaceHolder = ew_HtmlEncode(ew_RemoveHtml($this->pg_name->FldCaption()));

			// pg_cat
			$this->pg_cat->EditCustomAttributes = "style='width:97%' ";
			if (trim(strval($this->pg_cat->CurrentValue)) == "") {
				$sFilterWrk = "0=1";
			} else {
				$sFilterWrk = "`pg_cat`" . ew_SearchString("=", $this->pg_cat->CurrentValue, EW_DATATYPE_STRING);
			}
			$sSqlWrk = "SELECT `pg_cat`, `pg_cat` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld`, '' AS `SelectFilterFld`, '' AS `SelectFilterFld2`, '' AS `SelectFilterFld3`, '' AS `SelectFilterFld4` FROM `page_cat`";
			$sWhereWrk = "";
			if ($sFilterWrk <> "") {
				ew_AddFilter($sWhereWrk, $sFilterWrk);
			}

			// Call Lookup selecting
			$this->Lookup_Selecting($this->pg_cat, $sWhereWrk);
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = $conn->Execute($sSqlWrk);
			$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
			if ($rswrk) $rswrk->Close();
			array_unshift($arwrk, array("", $Language->Phrase("PleaseSelect"), "", "", "", "", "", "", ""));
			$this->pg_cat->EditValue = $arwrk;

			// content
			$this->content->EditCustomAttributes = "style='width:97%' ";
			$this->content->EditValue = $this->content->CurrentValue;
			$this->content->PlaceHolder = ew_HtmlEncode(ew_RemoveHtml($this->content->FldCaption()));

			// pg_alias
			$this->pg_alias->EditCustomAttributes = "style='width:97%' ";
			$this->pg_alias->EditValue = ew_HtmlEncode($this->pg_alias->CurrentValue);
			$this->pg_alias->PlaceHolder = ew_HtmlEncode(ew_RemoveHtml($this->pg_alias->FldCaption()));

			// pg_type
			$this->pg_type->EditCustomAttributes = "style='width:97%' ";
			$this->pg_type->EditValue = ew_HtmlEncode($this->pg_type->CurrentValue);
			if (strval($this->pg_type->CurrentValue) <> "") {
				$sFilterWrk = "`name`" . ew_SearchString("=", $this->pg_type->CurrentValue, EW_DATATYPE_STRING);
			$sSqlWrk = "SELECT `name`, `name` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `page_template`";
			$sWhereWrk = "";
			if ($sFilterWrk <> "") {
				ew_AddFilter($sWhereWrk, $sFilterWrk);
			}

			// Call Lookup selecting
			$this->Lookup_Selecting($this->pg_type, $sWhereWrk);
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
				$rswrk = $conn->Execute($sSqlWrk);
				if ($rswrk && !$rswrk->EOF) { // Lookup values found
					$this->pg_type->EditValue = $rswrk->fields('DispFld');
					$rswrk->Close();
				} else {
					$this->pg_type->EditValue = $this->pg_type->CurrentValue;
				}
			} else {
				$this->pg_type->EditValue = NULL;
			}
			$this->pg_type->PlaceHolder = ew_HtmlEncode(ew_RemoveHtml($this->pg_type->FldCaption()));

			// pg_title
			$this->pg_title->EditCustomAttributes = "style='width:97%' ";
			$this->pg_title->EditValue = ew_HtmlEncode($this->pg_title->CurrentValue);
			$this->pg_title->PlaceHolder = ew_HtmlEncode(ew_RemoveHtml($this->pg_title->FldCaption()));

			// keywords
			$this->keywords->EditCustomAttributes = "style='width:600px;height:100px' ";
			$this->keywords->EditValue = $this->keywords->CurrentValue;
			$this->keywords->PlaceHolder = ew_HtmlEncode(ew_RemoveHtml($this->keywords->FldCaption()));

			// pr_status
			$this->pr_status->EditCustomAttributes = "";
			$arwrk = array();
			$arwrk[] = array($this->pr_status->FldTagValue(1), $this->pr_status->FldTagCaption(1) <> "" ? $this->pr_status->FldTagCaption(1) : $this->pr_status->FldTagValue(1));
			$arwrk[] = array($this->pr_status->FldTagValue(2), $this->pr_status->FldTagCaption(2) <> "" ? $this->pr_status->FldTagCaption(2) : $this->pr_status->FldTagValue(2));
			$this->pr_status->EditValue = $arwrk;

			// rate_ord
			$this->rate_ord->EditCustomAttributes = "style='width:97%' ";
			$arwrk = array();
			$arwrk[] = array($this->rate_ord->FldTagValue(1), $this->rate_ord->FldTagCaption(1) <> "" ? $this->rate_ord->FldTagCaption(1) : $this->rate_ord->FldTagValue(1));
			$arwrk[] = array($this->rate_ord->FldTagValue(2), $this->rate_ord->FldTagCaption(2) <> "" ? $this->rate_ord->FldTagCaption(2) : $this->rate_ord->FldTagValue(2));
			$arwrk[] = array($this->rate_ord->FldTagValue(3), $this->rate_ord->FldTagCaption(3) <> "" ? $this->rate_ord->FldTagCaption(3) : $this->rate_ord->FldTagValue(3));
			$arwrk[] = array($this->rate_ord->FldTagValue(4), $this->rate_ord->FldTagCaption(4) <> "" ? $this->rate_ord->FldTagCaption(4) : $this->rate_ord->FldTagValue(4));
			$arwrk[] = array($this->rate_ord->FldTagValue(5), $this->rate_ord->FldTagCaption(5) <> "" ? $this->rate_ord->FldTagCaption(5) : $this->rate_ord->FldTagValue(5));
			$arwrk[] = array($this->rate_ord->FldTagValue(6), $this->rate_ord->FldTagCaption(6) <> "" ? $this->rate_ord->FldTagCaption(6) : $this->rate_ord->FldTagValue(6));
			$arwrk[] = array($this->rate_ord->FldTagValue(7), $this->rate_ord->FldTagCaption(7) <> "" ? $this->rate_ord->FldTagCaption(7) : $this->rate_ord->FldTagValue(7));
			$arwrk[] = array($this->rate_ord->FldTagValue(8), $this->rate_ord->FldTagCaption(8) <> "" ? $this->rate_ord->FldTagCaption(8) : $this->rate_ord->FldTagValue(8));
			$arwrk[] = array($this->rate_ord->FldTagValue(9), $this->rate_ord->FldTagCaption(9) <> "" ? $this->rate_ord->FldTagCaption(9) : $this->rate_ord->FldTagValue(9));
			$arwrk[] = array($this->rate_ord->FldTagValue(10), $this->rate_ord->FldTagCaption(10) <> "" ? $this->rate_ord->FldTagCaption(10) : $this->rate_ord->FldTagValue(10));
			$arwrk[] = array($this->rate_ord->FldTagValue(11), $this->rate_ord->FldTagCaption(11) <> "" ? $this->rate_ord->FldTagCaption(11) : $this->rate_ord->FldTagValue(11));
			array_unshift($arwrk, array("", $Language->Phrase("PleaseSelect")));
			$this->rate_ord->EditValue = $arwrk;

			// uploads
			$this->uploads->EditCustomAttributes = "";
			$this->uploads->UploadPath = "../uploads/";
			if (!ew_Empty($this->uploads->Upload->DbValue)) {
				$this->uploads->EditValue = $this->uploads->Upload->DbValue;
			} else {
				$this->uploads->EditValue = "";
			}
			if ($this->CurrentAction == "I" && !$this->EventCancelled) ew_RenderUploadField($this->uploads);

			// Edit refer script
			// id

			$this->id->HrefValue = "";

			// pg_name
			$this->pg_name->HrefValue = "";

			// pg_cat
			$this->pg_cat->HrefValue = "";

			// content
			$this->content->HrefValue = "";

			// pg_alias
			$this->pg_alias->HrefValue = "";

			// pg_type
			$this->pg_type->HrefValue = "";

			// pg_title
			$this->pg_title->HrefValue = "";

			// keywords
			$this->keywords->HrefValue = "";

			// pr_status
			$this->pr_status->HrefValue = "";

			// rate_ord
			$this->rate_ord->HrefValue = "";

			// uploads
			$this->uploads->HrefValue = "";
			$this->uploads->HrefValue2 = $this->uploads->UploadPath . $this->uploads->Upload->DbValue;
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
		if (!$this->pg_name->FldIsDetailKey && !is_null($this->pg_name->FormValue) && $this->pg_name->FormValue == "") {
			ew_AddMessage($gsFormError, $Language->Phrase("EnterRequiredField") . " - " . $this->pg_name->FldCaption());
		}
		if (!$this->pg_alias->FldIsDetailKey && !is_null($this->pg_alias->FormValue) && $this->pg_alias->FormValue == "") {
			ew_AddMessage($gsFormError, $Language->Phrase("EnterRequiredField") . " - " . $this->pg_alias->FldCaption());
		}
		if ($this->pr_status->FormValue == "") {
			ew_AddMessage($gsFormError, $Language->Phrase("EnterRequiredField") . " - " . $this->pr_status->FldCaption());
		}
		if (!$this->rate_ord->FldIsDetailKey && !is_null($this->rate_ord->FormValue) && $this->rate_ord->FormValue == "") {
			ew_AddMessage($gsFormError, $Language->Phrase("EnterRequiredField") . " - " . $this->rate_ord->FldCaption());
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
			$this->uploads->OldUploadPath = "../uploads/";
			$this->uploads->UploadPath = $this->uploads->OldUploadPath;
			$rsnew = array();

			// pg_name
			$this->pg_name->SetDbValueDef($rsnew, $this->pg_name->CurrentValue, "", $this->pg_name->ReadOnly);

			// pg_cat
			$this->pg_cat->SetDbValueDef($rsnew, $this->pg_cat->CurrentValue, NULL, $this->pg_cat->ReadOnly);

			// content
			$this->content->SetDbValueDef($rsnew, $this->content->CurrentValue, NULL, $this->content->ReadOnly);

			// pg_alias
			$this->pg_alias->SetDbValueDef($rsnew, $this->pg_alias->CurrentValue, "", $this->pg_alias->ReadOnly);

			// pg_type
			$this->pg_type->SetDbValueDef($rsnew, $this->pg_type->CurrentValue, NULL, $this->pg_type->ReadOnly);

			// pg_title
			$this->pg_title->SetDbValueDef($rsnew, $this->pg_title->CurrentValue, NULL, $this->pg_title->ReadOnly);

			// keywords
			$this->keywords->SetDbValueDef($rsnew, $this->keywords->CurrentValue, NULL, $this->keywords->ReadOnly);

			// pr_status
			$this->pr_status->SetDbValueDef($rsnew, $this->pr_status->CurrentValue, "", $this->pr_status->ReadOnly);

			// rate_ord
			$this->rate_ord->SetDbValueDef($rsnew, $this->rate_ord->CurrentValue, "", $this->rate_ord->ReadOnly);

			// uploads
			if (!($this->uploads->ReadOnly) && !$this->uploads->Upload->KeepFile) {
				$this->uploads->Upload->DbValue = $rs->fields('uploads'); // Get original value
				if ($this->uploads->Upload->FileName == "") {
					$rsnew['uploads'] = NULL;
				} else {
					$rsnew['uploads'] = $this->uploads->Upload->FileName;
				}
			}
			if (!$this->uploads->Upload->KeepFile) {
				$this->uploads->UploadPath = "../uploads/";
				if (!ew_Empty($this->uploads->Upload->Value)) {
					if ($this->uploads->Upload->FileName == $this->uploads->Upload->DbValue) { // Overwrite if same file name
						$this->uploads->Upload->DbValue = ""; // No need to delete any more
					} else {
						$rsnew['uploads'] = ew_UploadFileNameEx(ew_UploadPathEx(TRUE, $this->uploads->UploadPath), $rsnew['uploads']); // Get new file name
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
					if (!$this->uploads->Upload->KeepFile) {
						if (!ew_Empty($this->uploads->Upload->Value)) {
							$this->uploads->Upload->SaveToFile($this->uploads->UploadPath, $rsnew['uploads'], TRUE);
						}
						if ($this->uploads->Upload->DbValue <> "")
							@unlink(ew_UploadPathEx(TRUE, $this->uploads->OldUploadPath) . $this->uploads->Upload->DbValue);
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

		// uploads
		ew_CleanUploadTempPath($this->uploads, $this->uploads->Upload->Index);
		return $EditRow;
	}

	// Set up Breadcrumb
	function SetupBreadcrumb() {
		global $Breadcrumb, $Language;
		$Breadcrumb = new cBreadcrumb();
		$PageCaption = $this->TableCaption();
		$Breadcrumb->Add("list", "<span id=\"ewPageCaption\">" . $PageCaption . "</span>", "contentlist.php", $this->TableVar);
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
if (!isset($content_edit)) $content_edit = new ccontent_edit();

// Page init
$content_edit->Page_Init();

// Page main
$content_edit->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$content_edit->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Page object
var content_edit = new ew_Page("content_edit");
content_edit.PageID = "edit"; // Page ID
var EW_PAGE_ID = content_edit.PageID; // For backward compatibility

// Form object
var fcontentedit = new ew_Form("fcontentedit");

// Validate form
fcontentedit.Validate = function() {
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
			elm = this.GetElements("x" + infix + "_pg_name");
			if (elm && !ew_HasValue(elm))
				return this.OnError(elm, ewLanguage.Phrase("EnterRequiredField") + " - <?php echo ew_JsEncode2($content->pg_name->FldCaption()) ?>");
			elm = this.GetElements("x" + infix + "_pg_alias");
			if (elm && !ew_HasValue(elm))
				return this.OnError(elm, ewLanguage.Phrase("EnterRequiredField") + " - <?php echo ew_JsEncode2($content->pg_alias->FldCaption()) ?>");
			elm = this.GetElements("x" + infix + "_pr_status");
			if (elm && !ew_HasValue(elm))
				return this.OnError(elm, ewLanguage.Phrase("EnterRequiredField") + " - <?php echo ew_JsEncode2($content->pr_status->FldCaption()) ?>");
			elm = this.GetElements("x" + infix + "_rate_ord");
			if (elm && !ew_HasValue(elm))
				return this.OnError(elm, ewLanguage.Phrase("EnterRequiredField") + " - <?php echo ew_JsEncode2($content->rate_ord->FldCaption()) ?>");

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
fcontentedit.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
fcontentedit.ValidateRequired = true;
<?php } else { ?>
fcontentedit.ValidateRequired = false; 
<?php } ?>

// Multi-Page properties
fcontentedit.MultiPage = new ew_MultiPage("fcontentedit",
	[["x_id",1],["x_pg_name",1],["x_pg_cat",1],["x_content",1],["x_pg_alias",1],["x_pg_type",1],["x_pg_title",2],["x_keywords",2],["x_pr_status",2],["x_rate_ord",2],["x_uploads",3]]
);

// Dynamic selection lists
fcontentedit.Lists["x_pg_cat"] = {"LinkField":"x_pg_cat","Ajax":true,"AutoFill":false,"DisplayFields":["x_pg_cat","","",""],"ParentFields":[],"FilterFields":[],"Options":[]};
fcontentedit.Lists["x_pg_type"] = {"LinkField":"x_name","Ajax":true,"AutoFill":false,"DisplayFields":["x_name","","",""],"ParentFields":[],"FilterFields":[],"Options":[]};

// Form object for search
</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<?php $Breadcrumb->Render(); ?>
<?php $content_edit->ShowPageHeader(); ?>
<?php
$content_edit->ShowMessage();
?>
<form name="fcontentedit" id="fcontentedit" class="ewForm form-horizontal" action="<?php echo ew_CurrentPage() ?>" method="post">
<input type="hidden" name="t" value="content">
<input type="hidden" name="a_edit" id="a_edit" value="U">
<table class="ewStdTable"><tbody><tr><td>
<div class="tabbable" id="content_edit">
	<ul class="nav nav-tabs">
		<li class="active"><a href="#tab_content1" data-toggle="tab"><?php echo $content->PageCaption(1) ?></a></li>
		<li><a href="#tab_content2" data-toggle="tab"><?php echo $content->PageCaption(2) ?></a></li>
		<li><a href="#tab_content3" data-toggle="tab"><?php echo $content->PageCaption(3) ?></a></li>
	</ul>
	<div class="tab-content">
		<div class="tab-pane active" id="tab_content1">
<table cellspacing="0" class="ewGrid" style="width: 100%"><tr><td>
<table id="tbl_contentedit1" class="table table-bordered table-striped">
<?php if ($content->id->Visible) { // id ?>
	<tr id="r_id">
		<td><span id="elh_content_id"><?php echo $content->id->FldCaption() ?></span></td>
		<td<?php echo $content->id->CellAttributes() ?>>
<span id="el_content_id" class="control-group">
<span<?php echo $content->id->ViewAttributes() ?>>
<?php echo $content->id->EditValue ?></span>
</span>
<input type="hidden" data-field="x_id" name="x_id" id="x_id" value="<?php echo ew_HtmlEncode($content->id->CurrentValue) ?>">
<?php echo $content->id->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($content->pg_name->Visible) { // pg_name ?>
	<tr id="r_pg_name">
		<td><span id="elh_content_pg_name"><?php echo $content->pg_name->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></span></td>
		<td<?php echo $content->pg_name->CellAttributes() ?>>
<span id="el_content_pg_name" class="control-group">
<input type="text" data-field="x_pg_name" name="x_pg_name" id="x_pg_name" size="30" maxlength="200" placeholder="<?php echo $content->pg_name->PlaceHolder ?>" value="<?php echo $content->pg_name->EditValue ?>"<?php echo $content->pg_name->EditAttributes() ?>>
</span>
<?php echo $content->pg_name->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($content->pg_cat->Visible) { // pg_cat ?>
	<tr id="r_pg_cat">
		<td><span id="elh_content_pg_cat"><?php echo $content->pg_cat->FldCaption() ?></span></td>
		<td<?php echo $content->pg_cat->CellAttributes() ?>>
<span id="el_content_pg_cat" class="control-group">
<select data-field="x_pg_cat" id="x_pg_cat" name="x_pg_cat"<?php echo $content->pg_cat->EditAttributes() ?>>
<?php
if (is_array($content->pg_cat->EditValue)) {
	$arwrk = $content->pg_cat->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($content->pg_cat->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " selected=\"selected\"" : "";
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
&nbsp;<a id="aol_x_pg_cat" class="ewAddOptLink" href="javascript:void(0);" onclick="ew_AddOptDialogShow({lnk:this,el:'x_pg_cat',url:'page_cataddopt.php'});"><?php echo $Language->Phrase("AddLink") ?>&nbsp;<?php echo $content->pg_cat->FldCaption() ?></a>
<?php
$sSqlWrk = "SELECT `pg_cat`, `pg_cat` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `page_cat`";
$sWhereWrk = "";

// Call Lookup selecting
$content->Lookup_Selecting($content->pg_cat, $sWhereWrk);
if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
?>
<input type="hidden" name="s_x_pg_cat" id="s_x_pg_cat" value="s=<?php echo ew_Encrypt($sSqlWrk) ?>&f0=<?php echo ew_Encrypt("`pg_cat` = {filter_value}"); ?>&t0=200">
</span>
<?php echo $content->pg_cat->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($content->content->Visible) { // content ?>
	<tr id="r_content">
		<td><span id="elh_content_content"><?php echo $content->content->FldCaption() ?></span></td>
		<td<?php echo $content->content->CellAttributes() ?>>
<span id="el_content_content" class="control-group">
<textarea data-field="x_content" class="editor" name="x_content" id="x_content" cols="35" rows="8" placeholder="<?php echo $content->content->PlaceHolder ?>"<?php echo $content->content->EditAttributes() ?>><?php echo $content->content->EditValue ?></textarea>
<script type="text/javascript">
ew_CreateEditor("fcontentedit", "x_content", 35, 8, <?php echo ($content->content->ReadOnly || FALSE) ? "true" : "false" ?>);
</script>
</span>
<?php echo $content->content->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($content->pg_alias->Visible) { // pg_alias ?>
	<tr id="r_pg_alias">
		<td><span id="elh_content_pg_alias"><?php echo $content->pg_alias->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></span></td>
		<td<?php echo $content->pg_alias->CellAttributes() ?>>
<span id="el_content_pg_alias" class="control-group">
<input type="text" data-field="x_pg_alias" name="x_pg_alias" id="x_pg_alias" size="30" maxlength="100" placeholder="<?php echo $content->pg_alias->PlaceHolder ?>" value="<?php echo $content->pg_alias->EditValue ?>"<?php echo $content->pg_alias->EditAttributes() ?>>
</span>
<?php echo $content->pg_alias->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($content->pg_type->Visible) { // pg_type ?>
	<tr id="r_pg_type">
		<td><span id="elh_content_pg_type"><?php echo $content->pg_type->FldCaption() ?></span></td>
		<td<?php echo $content->pg_type->CellAttributes() ?>>
<span id="el_content_pg_type" class="control-group">
<?php
	$wrkonchange = trim(" " . @$content->pg_type->EditAttrs["onchange"]);
	if ($wrkonchange <> "") $wrkonchange = " onchange=\"" . ew_JsEncode2($wrkonchange) . "\"";
	$content->pg_type->EditAttrs["onchange"] = "";
?>
<span id="as_x_pg_type" style="white-space: nowrap; z-index: 8940">
	<input type="text" name="sv_x_pg_type" id="sv_x_pg_type" value="<?php echo $content->pg_type->EditValue ?>" size="30" maxlength="100" placeholder="<?php echo $content->pg_type->PlaceHolder ?>"<?php echo $content->pg_type->EditAttributes() ?>>&nbsp;<span id="em_x_pg_type" class="ewMessage" style="display: none"><?php echo str_replace("%f", "phpimages/", $Language->Phrase("UnmatchedValue")) ?></span>
	<div id="sc_x_pg_type" style="display: inline; z-index: 8940"></div>
</span>
<input type="hidden" data-field="x_pg_type" name="x_pg_type" id="x_pg_type" value="<?php echo $content->pg_type->CurrentValue ?>"<?php echo $wrkonchange ?>>
<?php
$sSqlWrk = "SELECT `name`, `name` AS `DispFld` FROM `page_template`";
$sWhereWrk = "`name` LIKE '{query_value}%'";

// Call Lookup selecting
$content->Lookup_Selecting($content->pg_type, $sWhereWrk);
if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
$sSqlWrk .= " LIMIT " . EW_AUTO_SUGGEST_MAX_ENTRIES;
?>
<input type="hidden" name="q_x_pg_type" id="q_x_pg_type" value="s=<?php echo ew_Encrypt($sSqlWrk) ?>">
<script type="text/javascript">
var oas = new ew_AutoSuggest("x_pg_type", fcontentedit, true, EW_AUTO_SUGGEST_MAX_ENTRIES);
fcontentedit.AutoSuggests["x_pg_type"] = oas;
</script>
&nbsp;<a id="aol_x_pg_type" class="ewAddOptLink" href="javascript:void(0);" onclick="ew_AddOptDialogShow({lnk:this,el:'x_pg_type',url:'page_templateaddopt.php'});"><?php echo $Language->Phrase("AddLink") ?>&nbsp;<?php echo $content->pg_type->FldCaption() ?></a>
<?php
$sSqlWrk = "SELECT `name`, `name` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `page_template`";
$sWhereWrk = "{filter}";

// Call Lookup selecting
$content->Lookup_Selecting($content->pg_type, $sWhereWrk);
if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
?>
<input type="hidden" name="s_x_pg_type" id="s_x_pg_type" value="s=<?php echo ew_Encrypt($sSqlWrk) ?>&f0=<?php echo ew_Encrypt("`name` = {filter_value}"); ?>&t0=200">
</span>
<?php echo $content->pg_type->CustomMsg ?></td>
	</tr>
<?php } ?>
</table>
</td></tr></table>
		</div>
		<div class="tab-pane" id="tab_content2">
<table cellspacing="0" class="ewGrid" style="width: 100%"><tr><td>
<table id="tbl_contentedit2" class="table table-bordered table-striped">
<?php if ($content->pg_title->Visible) { // pg_title ?>
	<tr id="r_pg_title">
		<td><span id="elh_content_pg_title"><?php echo $content->pg_title->FldCaption() ?></span></td>
		<td<?php echo $content->pg_title->CellAttributes() ?>>
<span id="el_content_pg_title" class="control-group">
<input type="text" data-field="x_pg_title" name="x_pg_title" id="x_pg_title" size="30" maxlength="200" placeholder="<?php echo $content->pg_title->PlaceHolder ?>" value="<?php echo $content->pg_title->EditValue ?>"<?php echo $content->pg_title->EditAttributes() ?>>
</span>
<?php echo $content->pg_title->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($content->keywords->Visible) { // keywords ?>
	<tr id="r_keywords">
		<td><span id="elh_content_keywords"><?php echo $content->keywords->FldCaption() ?></span></td>
		<td<?php echo $content->keywords->CellAttributes() ?>>
<span id="el_content_keywords" class="control-group">
<textarea data-field="x_keywords" name="x_keywords" id="x_keywords" cols="35" rows="4" placeholder="<?php echo $content->keywords->PlaceHolder ?>"<?php echo $content->keywords->EditAttributes() ?>><?php echo $content->keywords->EditValue ?></textarea>
</span>
<?php echo $content->keywords->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($content->pr_status->Visible) { // pr_status ?>
	<tr id="r_pr_status">
		<td><span id="elh_content_pr_status"><?php echo $content->pr_status->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></span></td>
		<td<?php echo $content->pr_status->CellAttributes() ?>>
<span id="el_content_pr_status" class="control-group">
<div id="tp_x_pr_status" class="<?php echo EW_ITEM_TEMPLATE_CLASSNAME ?>"><input type="radio" name="x_pr_status" id="x_pr_status" value="{value}"<?php echo $content->pr_status->EditAttributes() ?>></div>
<div id="dsl_x_pr_status" data-repeatcolumn="5" class="ewItemList">
<?php
$arwrk = $content->pr_status->EditValue;
if (is_array($arwrk)) {
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($content->pr_status->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " checked=\"checked\"" : "";
		if ($selwrk <> "") $emptywrk = FALSE;

		// Note: No spacing within the LABEL tag
?>
<?php echo ew_RepeatColumnTable($rowswrk, $rowcntwrk, 5, 1) ?>
<label class="radio"><input type="radio" data-field="x_pr_status" name="x_pr_status" id="x_pr_status_<?php echo $rowcntwrk ?>" value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?><?php echo $content->pr_status->EditAttributes() ?>><?php echo $arwrk[$rowcntwrk][1] ?></label>
<?php echo ew_RepeatColumnTable($rowswrk, $rowcntwrk, 5, 2) ?>
<?php
	}
}
?>
</div>
</span>
<?php echo $content->pr_status->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($content->rate_ord->Visible) { // rate_ord ?>
	<tr id="r_rate_ord">
		<td><span id="elh_content_rate_ord"><?php echo $content->rate_ord->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></span></td>
		<td<?php echo $content->rate_ord->CellAttributes() ?>>
<span id="el_content_rate_ord" class="control-group">
<select data-field="x_rate_ord" id="x_rate_ord" name="x_rate_ord"<?php echo $content->rate_ord->EditAttributes() ?>>
<?php
if (is_array($content->rate_ord->EditValue)) {
	$arwrk = $content->rate_ord->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($content->rate_ord->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " selected=\"selected\"" : "";
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
<?php echo $content->rate_ord->CustomMsg ?></td>
	</tr>
<?php } ?>
</table>
</td></tr></table>
		</div>
		<div class="tab-pane" id="tab_content3">
<table cellspacing="0" class="ewGrid" style="width: 100%"><tr><td>
<table id="tbl_contentedit3" class="table table-bordered table-striped">
<?php if ($content->uploads->Visible) { // uploads ?>
	<tr id="r_uploads">
		<td><span id="elh_content_uploads"><?php echo $content->uploads->FldCaption() ?></span></td>
		<td<?php echo $content->uploads->CellAttributes() ?>>
<span id="el_content_uploads" class="control-group">
<span id="fd_x_uploads">
<span class="btn btn-small fileinput-button">
	<span><?php echo $Language->Phrase("ChooseFile") ?></span>
	<input type="file" data-field="x_uploads" name="x_uploads" id="x_uploads">
</span>
<input type="hidden" name="fn_x_uploads" id= "fn_x_uploads" value="<?php echo $content->uploads->Upload->FileName ?>">
<?php if (@$_POST["fa_x_uploads"] == "0") { ?>
<input type="hidden" name="fa_x_uploads" id= "fa_x_uploads" value="0">
<?php } else { ?>
<input type="hidden" name="fa_x_uploads" id= "fa_x_uploads" value="1">
<?php } ?>
<input type="hidden" name="fs_x_uploads" id= "fs_x_uploads" value="250">
</span>
<table id="ft_x_uploads" class="table table-condensed pull-left ewUploadTable"><tbody class="files"></tbody></table>
</span>
<?php echo $content->uploads->CustomMsg ?></td>
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
<?php if (!isset($content_edit->Pager)) $content_edit->Pager = new cNumericPager($content_edit->StartRec, $content_edit->DisplayRecs, $content_edit->TotalRecs, $content_edit->RecRange) ?>
<?php if ($content_edit->Pager->RecordCount > 0) { ?>
<table cellspacing="0" class="ewStdTable"><tbody><tr><td>
<div class="pagination"><ul>
	<?php if ($content_edit->Pager->FirstButton->Enabled) { ?>
	<li><a href="<?php echo $content_edit->PageUrl() ?>start=<?php echo $content_edit->Pager->FirstButton->Start ?>"><?php echo $Language->Phrase("PagerFirst") ?></a></li>
	<?php } ?>
	<?php if ($content_edit->Pager->PrevButton->Enabled) { ?>
	<li><a href="<?php echo $content_edit->PageUrl() ?>start=<?php echo $content_edit->Pager->PrevButton->Start ?>"><?php echo $Language->Phrase("PagerPrevious") ?></a></li>
	<?php } ?>
	<?php foreach ($content_edit->Pager->Items as $PagerItem) { ?>
		<li<?php if (!$PagerItem->Enabled) { echo " class=\" active\""; } ?>><a href="<?php if ($PagerItem->Enabled) { echo $content_edit->PageUrl() . "start=" . $PagerItem->Start; } else { echo "#"; } ?>"><?php echo $PagerItem->Text ?></a></li>
	<?php } ?>
	<?php if ($content_edit->Pager->NextButton->Enabled) { ?>
	<li><a href="<?php echo $content_edit->PageUrl() ?>start=<?php echo $content_edit->Pager->NextButton->Start ?>"><?php echo $Language->Phrase("PagerNext") ?></a></li>
	<?php } ?>
	<?php if ($content_edit->Pager->LastButton->Enabled) { ?>
	<li><a href="<?php echo $content_edit->PageUrl() ?>start=<?php echo $content_edit->Pager->LastButton->Start ?>"><?php echo $Language->Phrase("PagerLast") ?></a></li>
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
fcontentedit.Init();
<?php if (EW_MOBILE_REFLOW && ew_IsMobile()) { ?>
ew_Reflow();
<?php } ?>
</script>
<?php
$content_edit->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$content_edit->Page_Terminate();
?>
