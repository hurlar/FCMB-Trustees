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
<?php include_once "comprehensivewill_tbinfo.php" ?>
<?php include_once "premiumwill_tbinfo.php" ?>
<?php include_once "privatetrust_tbinfo.php" ?>
<?php include_once "assets_tbgridcls.php" ?>
<?php include_once "alt_beneficiarygridcls.php" ?>
<?php include_once "userfn10.php" ?>
<?php

//
// Page class
//

$beneficiary_dump_view = NULL; // Initialize page object first

class cbeneficiary_dump_view extends cbeneficiary_dump {

	// Page ID
	var $PageID = 'view';

	// Project ID
	var $ProjectID = "{D9B361E7-B2C1-4293-B9B3-B581986A15CC}";

	// Table name
	var $TableName = 'beneficiary_dump';

	// Page object name
	var $PageObjName = 'beneficiary_dump_view';

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

	// Page URLs
	var $AddUrl;
	var $EditUrl;
	var $CopyUrl;
	var $DeleteUrl;
	var $ViewUrl;
	var $ListUrl;

	// Export URLs
	var $ExportPrintUrl;
	var $ExportHtmlUrl;
	var $ExportExcelUrl;
	var $ExportWordUrl;
	var $ExportXmlUrl;
	var $ExportCsvUrl;
	var $ExportPdfUrl;

	// Update URLs
	var $InlineAddUrl;
	var $InlineCopyUrl;
	var $InlineEditUrl;
	var $GridAddUrl;
	var $GridEditUrl;
	var $MultiDeleteUrl;
	var $MultiUpdateUrl;

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
		$KeyUrl = "";
		if (@$_GET["id"] <> "") {
			$this->RecKey["id"] = $_GET["id"];
			$KeyUrl .= "&id=" . urlencode($this->RecKey["id"]);
		}
		$this->ExportPrintUrl = $this->PageUrl() . "export=print" . $KeyUrl;
		$this->ExportHtmlUrl = $this->PageUrl() . "export=html" . $KeyUrl;
		$this->ExportExcelUrl = $this->PageUrl() . "export=excel" . $KeyUrl;
		$this->ExportWordUrl = $this->PageUrl() . "export=word" . $KeyUrl;
		$this->ExportXmlUrl = $this->PageUrl() . "export=xml" . $KeyUrl;
		$this->ExportCsvUrl = $this->PageUrl() . "export=csv" . $KeyUrl;
		$this->ExportPdfUrl = $this->PageUrl() . "export=pdf" . $KeyUrl;

		// Table object (adminusers)
		if (!isset($GLOBALS['adminusers'])) $GLOBALS['adminusers'] = new cadminusers();

		// Table object (children_details)
		if (!isset($GLOBALS['children_details'])) $GLOBALS['children_details'] = new cchildren_details();

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
			define("EW_PAGE_ID", 'view', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'beneficiary_dump', TRUE);

		// Start timer
		if (!isset($GLOBALS["gTimer"])) $GLOBALS["gTimer"] = new cTimer();

		// Open connection
		if (!isset($conn)) $conn = ew_Connect();

		// Export options
		$this->ExportOptions = new cListOptions();
		$this->ExportOptions->Tag = "span";
		$this->ExportOptions->TagClassName = "ewExportOption";

		// Other options
		$this->OtherOptions['action'] = new cListOptions();
		$this->OtherOptions['action']->Tag = "span";
		$this->OtherOptions['action']->TagClassName = "ewActionOption";
		$this->OtherOptions['detail'] = new cListOptions();
		$this->OtherOptions['detail']->Tag = "span";
		$this->OtherOptions['detail']->TagClassName = "ewDetailOption";
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

		// Get export parameters
		if (@$_GET["export"] <> "") {
			$this->Export = $_GET["export"];
		} elseif (ew_IsHttpPost()) {
			if (@$_POST["exporttype"] <> "")
				$this->Export = $_POST["exporttype"];
		} else {
			$this->setExportReturnUrl(ew_CurrentUrl());
		}
		$gsExport = $this->Export; // Get export parameter, used in header
		$gsExportFile = $this->TableVar; // Get export file, used in header
		if (@$_GET["id"] <> "") {
			if ($gsExportFile <> "") $gsExportFile .= "_";
			$gsExportFile .= ew_StripSlashes($_GET["id"]);
		}
		$this->CurrentAction = (@$_GET["a"] <> "") ? $_GET["a"] : @$_POST["a_list"]; // Set up curent action

		// Setup export options
		$this->SetupExportOptions();
		$this->id->Visible = !$this->IsAdd() && !$this->IsCopy() && !$this->IsGridAdd();

		// Global Page Loading event (in userfn*.php)
		Page_Loading();

		// Page Load event
		$this->Page_Load();

		// Update url if printer friendly for Pdf
		if ($this->PrinterFriendlyForPdf)
			$this->ExportOptions->Items["pdf"]->Body = str_replace($this->ExportPdfUrl, $this->ExportPrintUrl . "&pdf=1", $this->ExportOptions->Items["pdf"]->Body);
	}

	//
	// Page_Terminate
	//
	function Page_Terminate($url = "") {
		global $conn;

		// Page Unload event
		$this->Page_Unload();
		if ($this->Export == "print" && @$_GET["pdf"] == "1") { // Printer friendly version and with pdf=1 in URL parameters
			$pdf = new cExportPdf($GLOBALS["Table"]);
			$pdf->Text = ob_get_contents(); // Set the content as the HTML of current page (printer friendly version)
			ob_end_clean();
			$pdf->Export();
		}

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
	var $ExportOptions; // Export options
	var $OtherOptions = array(); // Other options
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
		global $Language;

		// Load current record
		$bLoadCurrentRecord = FALSE;
		$sReturnUrl = "";
		$bMatchRecord = FALSE;

		// Set up Breadcrumb
		$this->SetupBreadcrumb();
		if ($this->IsPageRequest()) { // Validate request
			if (@$_GET["id"] <> "") {
				$this->id->setQueryStringValue($_GET["id"]);
				$this->RecKey["id"] = $this->id->QueryStringValue;
			} else {
				$bLoadCurrentRecord = TRUE;
			}

			// Get action
			$this->CurrentAction = "I"; // Display form
			switch ($this->CurrentAction) {
				case "I": // Get a record to display
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
					if (!$bMatchRecord) {
						if ($this->getSuccessMessage() == "" && $this->getFailureMessage() == "")
							$this->setFailureMessage($Language->Phrase("NoRecord")); // Set no record message
						$sReturnUrl = "beneficiary_dumplist.php"; // No matching record, return to list
					} else {
						$this->LoadRowValues($this->Recordset); // Load row values
					}
			}

			// Export data only
			if (in_array($this->Export, array("html","word","excel","xml","csv","email","pdf"))) {
				$this->ExportData();
				$this->Page_Terminate(); // Terminate response
				exit();
			}
		} else {
			$sReturnUrl = "beneficiary_dumplist.php"; // Not page request, return to list
		}
		if ($sReturnUrl <> "")
			$this->Page_Terminate($sReturnUrl);

		// Render row
		$this->RowType = EW_ROWTYPE_VIEW;
		$this->ResetAttrs();
		$this->RenderRow();

		// Set up detail parameters
		$this->SetUpDetailParms();
	}

	// Set up other options
	function SetupOtherOptions() {
		global $Language, $Security;
		$options = &$this->OtherOptions;
		$option = &$options["action"];

		// Add
		$item = &$option->Add("add");
		$item->Body = "<a class=\"ewAction ewAdd\" href=\"" . ew_HtmlEncode($this->AddUrl) . "\">" . $Language->Phrase("ViewPageAddLink") . "</a>";
		$item->Visible = ($this->AddUrl <> "" && $Security->IsLoggedIn());

		// Edit
		$item = &$option->Add("edit");
		$item->Body = "<a class=\"ewAction ewEdit\" href=\"" . ew_HtmlEncode($this->EditUrl) . "\">" . $Language->Phrase("ViewPageEditLink") . "</a>";
		$item->Visible = ($this->EditUrl <> "" && $Security->IsLoggedIn());

		// Copy
		$item = &$option->Add("copy");
		$item->Body = "<a class=\"ewAction ewCopy\" href=\"" . ew_HtmlEncode($this->CopyUrl) . "\">" . $Language->Phrase("ViewPageCopyLink") . "</a>";
		$item->Visible = ($this->CopyUrl <> "" && $Security->IsLoggedIn());

		// Delete
		$item = &$option->Add("delete");
		$item->Body = "<a onclick=\"return ew_Confirm(ewLanguage.Phrase('DeleteConfirmMsg'));\" class=\"ewAction ewDelete\" href=\"" . ew_HtmlEncode($this->DeleteUrl) . "\">" . $Language->Phrase("ViewPageDeleteLink") . "</a>";
		$item->Visible = ($this->DeleteUrl <> "" && $Security->IsLoggedIn());
		$DetailTableLink = "";
		$option = &$options["detail"];

		// Detail table 'assets_tb'
		$body = $Language->TablePhrase("assets_tb", "TblCaption");
		$body = "<a class=\"ewAction ewDetailList\" href=\"" . ew_HtmlEncode("assets_tblist.php?" . EW_TABLE_SHOW_MASTER . "=beneficiary_dump&uid=" . strval($this->uid->CurrentValue) . "") . "\">" . $body . "</a>";
		$item = &$option->Add("detail_assets_tb");
		$item->Body = $body;
		$item->Visible = $Security->IsLoggedIn();
		if ($item->Visible) {
			if ($DetailTableLink <> "") $DetailTableLink .= ",";
			$DetailTableLink .= "assets_tb";
		}

		// Detail table 'alt_beneficiary'
		$body = $Language->TablePhrase("alt_beneficiary", "TblCaption");
		$body = "<a class=\"ewAction ewDetailList\" href=\"" . ew_HtmlEncode("alt_beneficiarylist.php?" . EW_TABLE_SHOW_MASTER . "=beneficiary_dump&childid=" . strval($this->childid->CurrentValue) . "") . "\">" . $body . "</a>";
		$item = &$option->Add("detail_alt_beneficiary");
		$item->Body = $body;
		$item->Visible = $Security->IsLoggedIn();
		if ($item->Visible) {
			if ($DetailTableLink <> "") $DetailTableLink .= ",";
			$DetailTableLink .= "alt_beneficiary";
		}

		// Multiple details
		if ($this->ShowMultipleDetails) {
			$body = $Language->Phrase("MultipleMasterDetails");
			$body = "<a class=\"ewAction ewDetailView\" data-action=\"view\" href=\"" . ew_HtmlEncode($this->GetViewUrl(EW_TABLE_SHOW_DETAIL . "=" . $DetailTableLink)) . "\">" . $body . "</a>";
			$item = &$option->Add("details");
			$item->Body = $body;
			$item->Visible = ($DetailTableLink <> "");

			// Hide single master/detail items
			$ar = explode(",", $DetailTableLink);
			$cnt = count($ar);
			for ($i = 0; $i < $cnt; $i++) {
				if ($item = &$option->GetItem("detail_" . $ar[$i]))
					$item->Visible = FALSE;
			}
		}

		// Set up options default
		foreach ($options as &$option) {
			$option->UseDropDownButton = TRUE;
			$option->UseButtonGroup = TRUE;
			$item = &$option->Add($option->GroupOptionName);
			$item->Body = "";
			$item->Visible = FALSE;
		}
		$options["detail"]->DropDownButtonPhrase = $Language->Phrase("ButtonDetails");
		$options["action"]->DropDownButtonPhrase = $Language->Phrase("ButtonActions");
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
		$this->AddUrl = $this->GetAddUrl();
		$this->EditUrl = $this->GetEditUrl();
		$this->CopyUrl = $this->GetCopyUrl();
		$this->DeleteUrl = $this->GetDeleteUrl();
		$this->ListUrl = $this->GetListUrl();
		$this->SetupOtherOptions();

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
		}

		// Call Row Rendered event
		if ($this->RowType <> EW_ROWTYPE_AGGREGATEINIT)
			$this->Row_Rendered();
	}

	// Set up export options
	function SetupExportOptions() {
		global $Language;

		// Printer friendly
		$item = &$this->ExportOptions->Add("print");
		$item->Body = "<a href=\"" . $this->ExportPrintUrl . "\" class=\"ewExportLink ewPrint\" data-caption=\"" . ew_HtmlEncode($Language->Phrase("PrinterFriendlyText")) . "\">" . $Language->Phrase("PrinterFriendly") . "</a>";
		$item->Visible = TRUE;

		// Export to Excel
		$item = &$this->ExportOptions->Add("excel");
		$item->Body = "<a href=\"" . $this->ExportExcelUrl . "\" class=\"ewExportLink ewExcel\" data-caption=\"" . ew_HtmlEncode($Language->Phrase("ExportToExcelText")) . "\">" . $Language->Phrase("ExportToExcel") . "</a>";
		$item->Visible = TRUE;

		// Export to Word
		$item = &$this->ExportOptions->Add("word");
		$item->Body = "<a href=\"" . $this->ExportWordUrl . "\" class=\"ewExportLink ewWord\" data-caption=\"" . ew_HtmlEncode($Language->Phrase("ExportToWordText")) . "\">" . $Language->Phrase("ExportToWord") . "</a>";
		$item->Visible = TRUE;

		// Export to Html
		$item = &$this->ExportOptions->Add("html");
		$item->Body = "<a href=\"" . $this->ExportHtmlUrl . "\" class=\"ewExportLink ewHtml\" data-caption=\"" . ew_HtmlEncode($Language->Phrase("ExportToHtmlText")) . "\">" . $Language->Phrase("ExportToHtml") . "</a>";
		$item->Visible = TRUE;

		// Export to Xml
		$item = &$this->ExportOptions->Add("xml");
		$item->Body = "<a href=\"" . $this->ExportXmlUrl . "\" class=\"ewExportLink ewXml\" data-caption=\"" . ew_HtmlEncode($Language->Phrase("ExportToXmlText")) . "\">" . $Language->Phrase("ExportToXml") . "</a>";
		$item->Visible = FALSE;

		// Export to Csv
		$item = &$this->ExportOptions->Add("csv");
		$item->Body = "<a href=\"" . $this->ExportCsvUrl . "\" class=\"ewExportLink ewCsv\" data-caption=\"" . ew_HtmlEncode($Language->Phrase("ExportToCsvText")) . "\">" . $Language->Phrase("ExportToCsv") . "</a>";
		$item->Visible = FALSE;

		// Export to Pdf
		$item = &$this->ExportOptions->Add("pdf");
		$item->Body = "<a href=\"" . $this->ExportPdfUrl . "\" class=\"ewExportLink ewPdf\" data-caption=\"" . ew_HtmlEncode($Language->Phrase("ExportToPDFText")) . "\">" . $Language->Phrase("ExportToPDF") . "</a>";
		$item->Visible = TRUE;

		// Export to Email
		$item = &$this->ExportOptions->Add("email");
		$item->Body = "<a id=\"emf_beneficiary_dump\" href=\"javascript:void(0);\" class=\"ewExportLink ewEmail\" data-caption=\"" . $Language->Phrase("ExportToEmailText") . "\" onclick=\"ew_EmailDialogShow({lnk:'emf_beneficiary_dump',hdr:ewLanguage.Phrase('ExportToEmail'),f:document.fbeneficiary_dumpview,key:" . ew_ArrayToJsonAttr($this->RecKey) . ",sel:false});\">" . $Language->Phrase("ExportToEmail") . "</a>";
		$item->Visible = TRUE;

		// Drop down button for export
		$this->ExportOptions->UseDropDownButton = TRUE;
		$this->ExportOptions->DropDownButtonPhrase = $Language->Phrase("ButtonExport");

		// Add group option item
		$item = &$this->ExportOptions->Add($this->ExportOptions->GroupOptionName);
		$item->Body = "";
		$item->Visible = FALSE;

		// Hide options for export
		if ($this->Export <> "")
			$this->ExportOptions->HideAllOptions();
	}

	// Export data in HTML/CSV/Word/Excel/XML/Email/PDF format
	function ExportData() {
		$utf8 = (strtolower(EW_CHARSET) == "utf-8");
		$bSelectLimit = FALSE;

		// Load recordset
		if ($bSelectLimit) {
			$this->TotalRecs = $this->SelectRecordCount();
		} else {
			if ($rs = $this->LoadRecordset())
				$this->TotalRecs = $rs->RecordCount();
		}
		$this->StartRec = 1;
		$this->SetUpStartRec(); // Set up start record position

		// Set the last record to display
		if ($this->DisplayRecs <= 0) {
			$this->StopRec = $this->TotalRecs;
		} else {
			$this->StopRec = $this->StartRec + $this->DisplayRecs - 1;
		}
		if (!$rs) {
			header("Content-Type:"); // Remove header
			header("Content-Disposition:");
			$this->ShowMessage();
			return;
		}
		$ExportDoc = ew_ExportDocument($this, "v");
		$ParentTable = "";
		if ($bSelectLimit) {
			$StartRec = 1;
			$StopRec = $this->DisplayRecs <= 0 ? $this->TotalRecs : $this->DisplayRecs;
		} else {
			$StartRec = $this->StartRec;
			$StopRec = $this->StopRec;
		}
		$sHeader = $this->PageHeader;
		$this->Page_DataRendering($sHeader);
		$ExportDoc->Text .= $sHeader;
		$this->ExportDocument($ExportDoc, $rs, $StartRec, $StopRec, "view");
		$sFooter = $this->PageFooter;
		$this->Page_DataRendered($sFooter);
		$ExportDoc->Text .= $sFooter;

		// Close recordset
		$rs->Close();

		// Export header and footer
		$ExportDoc->ExportHeaderAndFooter();

		// Clean output buffer
		if (!EW_DEBUG_ENABLED && ob_get_length())
			ob_end_clean();

		// Write debug message if enabled
		if (EW_DEBUG_ENABLED)
			echo ew_DebugMsg();

		// Output data
		if ($this->Export == "email") {
			echo $this->ExportEmail($ExportDoc->Text);
		} else {
			$ExportDoc->Export();
		}
	}

	// Export email
	function ExportEmail($EmailContent) {
		global $gTmpImages, $Language;
		$sSender = @$_GET["sender"];
		$sRecipient = @$_GET["recipient"];
		$sCc = @$_GET["cc"];
		$sBcc = @$_GET["bcc"];
		$sContentType = @$_GET["contenttype"];

		// Subject
		$sSubject = ew_StripSlashes(@$_GET["subject"]);
		$sEmailSubject = $sSubject;

		// Message
		$sContent = ew_StripSlashes(@$_GET["message"]);
		$sEmailMessage = $sContent;

		// Check sender
		if ($sSender == "") {
			return "<p class=\"text-error\">" . $Language->Phrase("EnterSenderEmail") . "</p>";
		}
		if (!ew_CheckEmail($sSender)) {
			return "<p class=\"text-error\">" . $Language->Phrase("EnterProperSenderEmail") . "</p>";
		}

		// Check recipient
		if (!ew_CheckEmailList($sRecipient, EW_MAX_EMAIL_RECIPIENT)) {
			return "<p class=\"text-error\">" . $Language->Phrase("EnterProperRecipientEmail") . "</p>";
		}

		// Check cc
		if (!ew_CheckEmailList($sCc, EW_MAX_EMAIL_RECIPIENT)) {
			return "<p class=\"text-error\">" . $Language->Phrase("EnterProperCcEmail") . "</p>";
		}

		// Check bcc
		if (!ew_CheckEmailList($sBcc, EW_MAX_EMAIL_RECIPIENT)) {
			return "<p class=\"text-error\">" . $Language->Phrase("EnterProperBccEmail") . "</p>";
		}

		// Check email sent count
		if (!isset($_SESSION[EW_EXPORT_EMAIL_COUNTER]))
			$_SESSION[EW_EXPORT_EMAIL_COUNTER] = 0;
		if (intval($_SESSION[EW_EXPORT_EMAIL_COUNTER]) > EW_MAX_EMAIL_SENT_COUNT) {
			return "<p class=\"text-error\">" . $Language->Phrase("ExceedMaxEmailExport") . "</p>";
		}

		// Send email
		$Email = new cEmail();
		$Email->Sender = $sSender; // Sender
		$Email->Recipient = $sRecipient; // Recipient
		$Email->Cc = $sCc; // Cc
		$Email->Bcc = $sBcc; // Bcc
		$Email->Subject = $sEmailSubject; // Subject
		$Email->Format = ($sContentType == "url") ? "text" : "html";
		$Email->Charset = EW_EMAIL_CHARSET;
		if ($sEmailMessage <> "") {
			$sEmailMessage = ew_RemoveXSS($sEmailMessage);
			$sEmailMessage .= ($sContentType == "url") ? "\r\n\r\n" : "<br><br>";
		}
		if ($sContentType == "url") {
			$sUrl = ew_ConvertFullUrl(ew_CurrentPage() . "?" . $this->ExportQueryString());
			$sEmailMessage .= $sUrl; // Send URL only
		} else {
			foreach ($gTmpImages as $tmpimage)
				$Email->AddEmbeddedImage($tmpimage);
			$sEmailMessage .= $EmailContent; // Send HTML
		}
		$Email->Content = $sEmailMessage; // Content
		$EventArgs = array();
		$bEmailSent = FALSE;
		if ($this->Email_Sending($Email, $EventArgs))
			$bEmailSent = $Email->Send();

		// Check email sent status
		if ($bEmailSent) {

			// Update email sent count
			$_SESSION[EW_EXPORT_EMAIL_COUNTER]++;

			// Sent email success
			return "<p class=\"text-success\">" . $Language->Phrase("SendEmailSuccess") . "</p>"; // Set up success message
		} else {

			// Sent email failure
			return "<p class=\"text-error\">" . $Email->SendErrDescription . "</p>";
		}
	}

	// Export QueryString
	function ExportQueryString() {

		// Initialize
		$sQry = "export=html";

		// Add record key QueryString
		$sQry .= "&" . substr($this->KeyUrl("", ""), 1);
		return $sQry;
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
				if ($GLOBALS["assets_tb_grid"]->DetailView) {
					$GLOBALS["assets_tb_grid"]->CurrentMode = "view";

					// Save current master table to detail table
					$GLOBALS["assets_tb_grid"]->setCurrentMasterTable($this->TableVar);
					$GLOBALS["assets_tb_grid"]->setStartRecordNumber(1);
					$GLOBALS["assets_tb_grid"]->uid->FldIsDetailKey = TRUE;
					$GLOBALS["assets_tb_grid"]->uid->CurrentValue = $this->uid->CurrentValue;
					$GLOBALS["assets_tb_grid"]->uid->setSessionValue($GLOBALS["assets_tb_grid"]->uid->CurrentValue);
				}
			}
			if (in_array("alt_beneficiary", $DetailTblVar)) {
				if (!isset($GLOBALS["alt_beneficiary_grid"]))
					$GLOBALS["alt_beneficiary_grid"] = new calt_beneficiary_grid;
				if ($GLOBALS["alt_beneficiary_grid"]->DetailView) {
					$GLOBALS["alt_beneficiary_grid"]->CurrentMode = "view";

					// Save current master table to detail table
					$GLOBALS["alt_beneficiary_grid"]->setCurrentMasterTable($this->TableVar);
					$GLOBALS["alt_beneficiary_grid"]->setStartRecordNumber(1);
					$GLOBALS["alt_beneficiary_grid"]->childid->FldIsDetailKey = TRUE;
					$GLOBALS["alt_beneficiary_grid"]->childid->CurrentValue = $this->childid->CurrentValue;
					$GLOBALS["alt_beneficiary_grid"]->childid->setSessionValue($GLOBALS["alt_beneficiary_grid"]->childid->CurrentValue);
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
		$PageCaption = $Language->Phrase("view");
		$Breadcrumb->Add("view", "<span id=\"ewPageCaption\">" . $PageCaption . "</span>", ew_CurrentUrl(), $this->TableVar);
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
}
?>
<?php ew_Header(FALSE) ?>
<?php

// Create page object
if (!isset($beneficiary_dump_view)) $beneficiary_dump_view = new cbeneficiary_dump_view();

// Page init
$beneficiary_dump_view->Page_Init();

// Page main
$beneficiary_dump_view->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$beneficiary_dump_view->Page_Render();
?>
<?php include_once "header.php" ?>
<?php if ($beneficiary_dump->Export == "") { ?>
<script type="text/javascript">

// Page object
var beneficiary_dump_view = new ew_Page("beneficiary_dump_view");
beneficiary_dump_view.PageID = "view"; // Page ID
var EW_PAGE_ID = beneficiary_dump_view.PageID; // For backward compatibility

// Form object
var fbeneficiary_dumpview = new ew_Form("fbeneficiary_dumpview");

// Form_CustomValidate event
fbeneficiary_dumpview.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
fbeneficiary_dumpview.ValidateRequired = true;
<?php } else { ?>
fbeneficiary_dumpview.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
// Form object for search

</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<?php } ?>
<?php if ($beneficiary_dump->Export == "") { ?>
<?php $Breadcrumb->Render(); ?>
<?php } ?>
<?php if ($beneficiary_dump->Export == "") { ?>
<div class="ewViewExportOptions">
<?php $beneficiary_dump_view->ExportOptions->Render("body") ?>
<?php if (!$beneficiary_dump_view->ExportOptions->UseDropDownButton) { ?>
</div>
<div class="ewViewOtherOptions">
<?php } ?>
<?php
	foreach ($beneficiary_dump_view->OtherOptions as &$option)
		$option->Render("body");
?>
</div>
<?php } ?>
<?php $beneficiary_dump_view->ShowPageHeader(); ?>
<?php
$beneficiary_dump_view->ShowMessage();
?>
<form name="fbeneficiary_dumpview" id="fbeneficiary_dumpview" class="ewForm form-horizontal" action="<?php echo ew_CurrentPage() ?>" method="post">
<input type="hidden" name="t" value="beneficiary_dump">
<table cellspacing="0" class="ewGrid"><tr><td>
<table id="tbl_beneficiary_dumpview" class="table table-bordered table-striped">
<?php if ($beneficiary_dump->id->Visible) { // id ?>
	<tr id="r_id">
		<td><span id="elh_beneficiary_dump_id"><?php echo $beneficiary_dump->id->FldCaption() ?></span></td>
		<td<?php echo $beneficiary_dump->id->CellAttributes() ?>>
<span id="el_beneficiary_dump_id" class="control-group">
<span<?php echo $beneficiary_dump->id->ViewAttributes() ?>>
<?php echo $beneficiary_dump->id->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($beneficiary_dump->uid->Visible) { // uid ?>
	<tr id="r_uid">
		<td><span id="elh_beneficiary_dump_uid"><?php echo $beneficiary_dump->uid->FldCaption() ?></span></td>
		<td<?php echo $beneficiary_dump->uid->CellAttributes() ?>>
<span id="el_beneficiary_dump_uid" class="control-group">
<span<?php echo $beneficiary_dump->uid->ViewAttributes() ?>>
<?php echo $beneficiary_dump->uid->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($beneficiary_dump->childid->Visible) { // childid ?>
	<tr id="r_childid">
		<td><span id="elh_beneficiary_dump_childid"><?php echo $beneficiary_dump->childid->FldCaption() ?></span></td>
		<td<?php echo $beneficiary_dump->childid->CellAttributes() ?>>
<span id="el_beneficiary_dump_childid" class="control-group">
<span<?php echo $beneficiary_dump->childid->ViewAttributes() ?>>
<?php echo $beneficiary_dump->childid->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($beneficiary_dump->title->Visible) { // title ?>
	<tr id="r_title">
		<td><span id="elh_beneficiary_dump_title"><?php echo $beneficiary_dump->title->FldCaption() ?></span></td>
		<td<?php echo $beneficiary_dump->title->CellAttributes() ?>>
<span id="el_beneficiary_dump_title" class="control-group">
<span<?php echo $beneficiary_dump->title->ViewAttributes() ?>>
<?php echo $beneficiary_dump->title->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($beneficiary_dump->fullname->Visible) { // fullname ?>
	<tr id="r_fullname">
		<td><span id="elh_beneficiary_dump_fullname"><?php echo $beneficiary_dump->fullname->FldCaption() ?></span></td>
		<td<?php echo $beneficiary_dump->fullname->CellAttributes() ?>>
<span id="el_beneficiary_dump_fullname" class="control-group">
<span<?php echo $beneficiary_dump->fullname->ViewAttributes() ?>>
<?php echo $beneficiary_dump->fullname->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($beneficiary_dump->rtionship->Visible) { // rtionship ?>
	<tr id="r_rtionship">
		<td><span id="elh_beneficiary_dump_rtionship"><?php echo $beneficiary_dump->rtionship->FldCaption() ?></span></td>
		<td<?php echo $beneficiary_dump->rtionship->CellAttributes() ?>>
<span id="el_beneficiary_dump_rtionship" class="control-group">
<span<?php echo $beneficiary_dump->rtionship->ViewAttributes() ?>>
<?php echo $beneficiary_dump->rtionship->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($beneficiary_dump->_email->Visible) { // email ?>
	<tr id="r__email">
		<td><span id="elh_beneficiary_dump__email"><?php echo $beneficiary_dump->_email->FldCaption() ?></span></td>
		<td<?php echo $beneficiary_dump->_email->CellAttributes() ?>>
<span id="el_beneficiary_dump__email" class="control-group">
<span<?php echo $beneficiary_dump->_email->ViewAttributes() ?>>
<?php echo $beneficiary_dump->_email->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($beneficiary_dump->phone->Visible) { // phone ?>
	<tr id="r_phone">
		<td><span id="elh_beneficiary_dump_phone"><?php echo $beneficiary_dump->phone->FldCaption() ?></span></td>
		<td<?php echo $beneficiary_dump->phone->CellAttributes() ?>>
<span id="el_beneficiary_dump_phone" class="control-group">
<span<?php echo $beneficiary_dump->phone->ViewAttributes() ?>>
<?php echo $beneficiary_dump->phone->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($beneficiary_dump->addr->Visible) { // addr ?>
	<tr id="r_addr">
		<td><span id="elh_beneficiary_dump_addr"><?php echo $beneficiary_dump->addr->FldCaption() ?></span></td>
		<td<?php echo $beneficiary_dump->addr->CellAttributes() ?>>
<span id="el_beneficiary_dump_addr" class="control-group">
<span<?php echo $beneficiary_dump->addr->ViewAttributes() ?>>
<?php echo $beneficiary_dump->addr->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($beneficiary_dump->city->Visible) { // city ?>
	<tr id="r_city">
		<td><span id="elh_beneficiary_dump_city"><?php echo $beneficiary_dump->city->FldCaption() ?></span></td>
		<td<?php echo $beneficiary_dump->city->CellAttributes() ?>>
<span id="el_beneficiary_dump_city" class="control-group">
<span<?php echo $beneficiary_dump->city->ViewAttributes() ?>>
<?php echo $beneficiary_dump->city->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($beneficiary_dump->state->Visible) { // state ?>
	<tr id="r_state">
		<td><span id="elh_beneficiary_dump_state"><?php echo $beneficiary_dump->state->FldCaption() ?></span></td>
		<td<?php echo $beneficiary_dump->state->CellAttributes() ?>>
<span id="el_beneficiary_dump_state" class="control-group">
<span<?php echo $beneficiary_dump->state->ViewAttributes() ?>>
<?php echo $beneficiary_dump->state->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($beneficiary_dump->percentage->Visible) { // percentage ?>
	<tr id="r_percentage">
		<td><span id="elh_beneficiary_dump_percentage"><?php echo $beneficiary_dump->percentage->FldCaption() ?></span></td>
		<td<?php echo $beneficiary_dump->percentage->CellAttributes() ?>>
<span id="el_beneficiary_dump_percentage" class="control-group">
<span<?php echo $beneficiary_dump->percentage->ViewAttributes() ?>>
<?php echo $beneficiary_dump->percentage->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($beneficiary_dump->percentage1->Visible) { // percentage1 ?>
	<tr id="r_percentage1">
		<td><span id="elh_beneficiary_dump_percentage1"><?php echo $beneficiary_dump->percentage1->FldCaption() ?></span></td>
		<td<?php echo $beneficiary_dump->percentage1->CellAttributes() ?>>
<span id="el_beneficiary_dump_percentage1" class="control-group">
<span<?php echo $beneficiary_dump->percentage1->ViewAttributes() ?>>
<?php echo $beneficiary_dump->percentage1->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($beneficiary_dump->percentage2->Visible) { // percentage2 ?>
	<tr id="r_percentage2">
		<td><span id="elh_beneficiary_dump_percentage2"><?php echo $beneficiary_dump->percentage2->FldCaption() ?></span></td>
		<td<?php echo $beneficiary_dump->percentage2->CellAttributes() ?>>
<span id="el_beneficiary_dump_percentage2" class="control-group">
<span<?php echo $beneficiary_dump->percentage2->ViewAttributes() ?>>
<?php echo $beneficiary_dump->percentage2->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($beneficiary_dump->percentage3->Visible) { // percentage3 ?>
	<tr id="r_percentage3">
		<td><span id="elh_beneficiary_dump_percentage3"><?php echo $beneficiary_dump->percentage3->FldCaption() ?></span></td>
		<td<?php echo $beneficiary_dump->percentage3->CellAttributes() ?>>
<span id="el_beneficiary_dump_percentage3" class="control-group">
<span<?php echo $beneficiary_dump->percentage3->ViewAttributes() ?>>
<?php echo $beneficiary_dump->percentage3->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($beneficiary_dump->datecreated->Visible) { // datecreated ?>
	<tr id="r_datecreated">
		<td><span id="elh_beneficiary_dump_datecreated"><?php echo $beneficiary_dump->datecreated->FldCaption() ?></span></td>
		<td<?php echo $beneficiary_dump->datecreated->CellAttributes() ?>>
<span id="el_beneficiary_dump_datecreated" class="control-group">
<span<?php echo $beneficiary_dump->datecreated->ViewAttributes() ?>>
<?php echo $beneficiary_dump->datecreated->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($beneficiary_dump->passport->Visible) { // passport ?>
	<tr id="r_passport">
		<td><span id="elh_beneficiary_dump_passport"><?php echo $beneficiary_dump->passport->FldCaption() ?></span></td>
		<td<?php echo $beneficiary_dump->passport->CellAttributes() ?>>
<span id="el_beneficiary_dump_passport" class="control-group">
<span<?php echo $beneficiary_dump->passport->ViewAttributes() ?>>
<?php echo $beneficiary_dump->passport->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
</table>
</td></tr></table>
<?php if ($beneficiary_dump->Export == "") { ?>
<table class="ewPager">
<tr><td>
<?php if (!isset($beneficiary_dump_view->Pager)) $beneficiary_dump_view->Pager = new cNumericPager($beneficiary_dump_view->StartRec, $beneficiary_dump_view->DisplayRecs, $beneficiary_dump_view->TotalRecs, $beneficiary_dump_view->RecRange) ?>
<?php if ($beneficiary_dump_view->Pager->RecordCount > 0) { ?>
<table cellspacing="0" class="ewStdTable"><tbody><tr><td>
<div class="pagination"><ul>
	<?php if ($beneficiary_dump_view->Pager->FirstButton->Enabled) { ?>
	<li><a href="<?php echo $beneficiary_dump_view->PageUrl() ?>start=<?php echo $beneficiary_dump_view->Pager->FirstButton->Start ?>"><?php echo $Language->Phrase("PagerFirst") ?></a></li>
	<?php } ?>
	<?php if ($beneficiary_dump_view->Pager->PrevButton->Enabled) { ?>
	<li><a href="<?php echo $beneficiary_dump_view->PageUrl() ?>start=<?php echo $beneficiary_dump_view->Pager->PrevButton->Start ?>"><?php echo $Language->Phrase("PagerPrevious") ?></a></li>
	<?php } ?>
	<?php foreach ($beneficiary_dump_view->Pager->Items as $PagerItem) { ?>
		<li<?php if (!$PagerItem->Enabled) { echo " class=\" active\""; } ?>><a href="<?php if ($PagerItem->Enabled) { echo $beneficiary_dump_view->PageUrl() . "start=" . $PagerItem->Start; } else { echo "#"; } ?>"><?php echo $PagerItem->Text ?></a></li>
	<?php } ?>
	<?php if ($beneficiary_dump_view->Pager->NextButton->Enabled) { ?>
	<li><a href="<?php echo $beneficiary_dump_view->PageUrl() ?>start=<?php echo $beneficiary_dump_view->Pager->NextButton->Start ?>"><?php echo $Language->Phrase("PagerNext") ?></a></li>
	<?php } ?>
	<?php if ($beneficiary_dump_view->Pager->LastButton->Enabled) { ?>
	<li><a href="<?php echo $beneficiary_dump_view->PageUrl() ?>start=<?php echo $beneficiary_dump_view->Pager->LastButton->Start ?>"><?php echo $Language->Phrase("PagerLast") ?></a></li>
	<?php } ?>
</ul></div>
</td>
</tr></tbody></table>
<?php } else { ?>
	<p><?php echo $Language->Phrase("NoRecord") ?></p>
<?php } ?>
</td>
</tr></table>
<?php } ?>
<?php
	if (in_array("assets_tb", explode(",", $beneficiary_dump->getCurrentDetailTable())) && $assets_tb->DetailView) {
?>
<?php include_once "assets_tbgrid.php" ?>
<?php } ?>
<?php
	if (in_array("alt_beneficiary", explode(",", $beneficiary_dump->getCurrentDetailTable())) && $alt_beneficiary->DetailView) {
?>
<?php include_once "alt_beneficiarygrid.php" ?>
<?php } ?>
</form>
<script type="text/javascript">
fbeneficiary_dumpview.Init();
</script>
<?php
$beneficiary_dump_view->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<?php if ($beneficiary_dump->Export == "") { ?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php } ?>
<?php include_once "footer.php" ?>
<?php
$beneficiary_dump_view->Page_Terminate();
?>
