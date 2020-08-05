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

$processflow_tb_view = NULL; // Initialize page object first

class cprocessflow_tb_view extends cprocessflow_tb {

	// Page ID
	var $PageID = 'view';

	// Project ID
	var $ProjectID = "{D9B361E7-B2C1-4293-B9B3-B581986A15CC}";

	// Table name
	var $TableName = 'processflow_tb';

	// Page object name
	var $PageObjName = 'processflow_tb_view';

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

		// Table object (processflow_tb)
		if (!isset($GLOBALS["processflow_tb"])) {
			$GLOBALS["processflow_tb"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["processflow_tb"];
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

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'view', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'processflow_tb', TRUE);

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
						$this->Page_Terminate("processflow_tblist.php"); // Return to list page
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
						$sReturnUrl = "processflow_tblist.php"; // No matching record, return to list
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
			$sReturnUrl = "processflow_tblist.php"; // Not page request, return to list
		}
		if ($sReturnUrl <> "")
			$this->Page_Terminate($sReturnUrl);

		// Render row
		$this->RowType = EW_ROWTYPE_VIEW;
		$this->ResetAttrs();
		$this->RenderRow();
	}

	// Set up other options
	function SetupOtherOptions() {
		global $Language, $Security;
		$options = &$this->OtherOptions;
		$option = &$options["action"];

		// Delete
		$item = &$option->Add("delete");
		$item->Body = "<a onclick=\"return ew_Confirm(ewLanguage.Phrase('DeleteConfirmMsg'));\" class=\"ewAction ewDelete\" href=\"" . ew_HtmlEncode($this->DeleteUrl) . "\">" . $Language->Phrase("ViewPageDeleteLink") . "</a>";
		$item->Visible = ($this->DeleteUrl <> "" && $Security->IsLoggedIn());

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

			// name
			$this->name->ViewValue = $this->name->CurrentValue;
			$this->name->ViewCustomAttributes = "";

			// email
			$this->_email->ViewValue = $this->_email->CurrentValue;
			$this->_email->ViewCustomAttributes = "";

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
					default:
						$this->progress->ViewValue = $this->progress->CurrentValue;
				}
			} else {
				$this->progress->ViewValue = NULL;
			}
			$this->progress->ViewCustomAttributes = "";

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
					default:
						$this->progress2->ViewValue = $this->progress2->CurrentValue;
				}
			} else {
				$this->progress2->ViewValue = NULL;
			}
			$this->progress2->ViewCustomAttributes = "";

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
					default:
						$this->progress3->ViewValue = $this->progress3->CurrentValue;
				}
			} else {
				$this->progress3->ViewValue = NULL;
			}
			$this->progress3->ViewCustomAttributes = "";

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
					default:
						$this->progress4->ViewValue = $this->progress4->CurrentValue;
				}
			} else {
				$this->progress4->ViewValue = NULL;
			}
			$this->progress4->ViewCustomAttributes = "";

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
					default:
						$this->progress5->ViewValue = $this->progress5->CurrentValue;
				}
			} else {
				$this->progress5->ViewValue = NULL;
			}
			$this->progress5->ViewCustomAttributes = "";

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
					default:
						$this->progress6->ViewValue = $this->progress6->CurrentValue;
				}
			} else {
				$this->progress6->ViewValue = NULL;
			}
			$this->progress6->ViewCustomAttributes = "";

			// id
			$this->id->LinkCustomAttributes = "";
			$this->id->HrefValue = "";
			$this->id->TooltipValue = "";

			// name
			$this->name->LinkCustomAttributes = "";
			$this->name->HrefValue = "";
			$this->name->TooltipValue = "";

			// email
			$this->_email->LinkCustomAttributes = "";
			$this->_email->HrefValue = "";
			$this->_email->TooltipValue = "";

			// progress
			$this->progress->LinkCustomAttributes = "";
			$this->progress->HrefValue = "";
			$this->progress->TooltipValue = "";

			// progress2
			$this->progress2->LinkCustomAttributes = "";
			$this->progress2->HrefValue = "";
			$this->progress2->TooltipValue = "";

			// progress3
			$this->progress3->LinkCustomAttributes = "";
			$this->progress3->HrefValue = "";
			$this->progress3->TooltipValue = "";

			// progress4
			$this->progress4->LinkCustomAttributes = "";
			$this->progress4->HrefValue = "";
			$this->progress4->TooltipValue = "";

			// progress5
			$this->progress5->LinkCustomAttributes = "";
			$this->progress5->HrefValue = "";
			$this->progress5->TooltipValue = "";

			// progress6
			$this->progress6->LinkCustomAttributes = "";
			$this->progress6->HrefValue = "";
			$this->progress6->TooltipValue = "";
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
		$item->Body = "<a id=\"emf_processflow_tb\" href=\"javascript:void(0);\" class=\"ewExportLink ewEmail\" data-caption=\"" . $Language->Phrase("ExportToEmailText") . "\" onclick=\"ew_EmailDialogShow({lnk:'emf_processflow_tb',hdr:ewLanguage.Phrase('ExportToEmail'),f:document.fprocessflow_tbview,key:" . ew_ArrayToJsonAttr($this->RecKey) . ",sel:false});\">" . $Language->Phrase("ExportToEmail") . "</a>";
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

	// Set up Breadcrumb
	function SetupBreadcrumb() {
		global $Breadcrumb, $Language;
		$Breadcrumb = new cBreadcrumb();
		$PageCaption = $this->TableCaption();
		$Breadcrumb->Add("list", "<span id=\"ewPageCaption\">" . $PageCaption . "</span>", "processflow_tblist.php", $this->TableVar);
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
if (!isset($processflow_tb_view)) $processflow_tb_view = new cprocessflow_tb_view();

// Page init
$processflow_tb_view->Page_Init();

// Page main
$processflow_tb_view->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$processflow_tb_view->Page_Render();
?>
<?php include_once "header.php" ?>
<?php if ($processflow_tb->Export == "") { ?>
<script type="text/javascript">

// Page object
var processflow_tb_view = new ew_Page("processflow_tb_view");
processflow_tb_view.PageID = "view"; // Page ID
var EW_PAGE_ID = processflow_tb_view.PageID; // For backward compatibility

// Form object
var fprocessflow_tbview = new ew_Form("fprocessflow_tbview");

// Form_CustomValidate event
fprocessflow_tbview.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
fprocessflow_tbview.ValidateRequired = true;
<?php } else { ?>
fprocessflow_tbview.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
// Form object for search

</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<?php } ?>
<?php if ($processflow_tb->Export == "") { ?>
<?php $Breadcrumb->Render(); ?>
<?php } ?>
<?php if ($processflow_tb->Export == "") { ?>
<div class="ewViewExportOptions">
<?php $processflow_tb_view->ExportOptions->Render("body") ?>
<?php if (!$processflow_tb_view->ExportOptions->UseDropDownButton) { ?>
</div>
<div class="ewViewOtherOptions">
<?php } ?>
<?php
	foreach ($processflow_tb_view->OtherOptions as &$option)
		$option->Render("body");
?>
</div>
<?php } ?>
<?php $processflow_tb_view->ShowPageHeader(); ?>
<?php
$processflow_tb_view->ShowMessage();
?>
<form name="fprocessflow_tbview" id="fprocessflow_tbview" class="ewForm form-horizontal" action="<?php echo ew_CurrentPage() ?>" method="post">
<input type="hidden" name="t" value="processflow_tb">
<table cellspacing="0" class="ewGrid"><tr><td>
<table id="tbl_processflow_tbview" class="table table-bordered table-striped">
<?php if ($processflow_tb->id->Visible) { // id ?>
	<tr id="r_id">
		<td><span id="elh_processflow_tb_id"><?php echo $processflow_tb->id->FldCaption() ?></span></td>
		<td<?php echo $processflow_tb->id->CellAttributes() ?>>
<span id="el_processflow_tb_id" class="control-group">
<span<?php echo $processflow_tb->id->ViewAttributes() ?>>
<?php echo $processflow_tb->id->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($processflow_tb->name->Visible) { // name ?>
	<tr id="r_name">
		<td><span id="elh_processflow_tb_name"><?php echo $processflow_tb->name->FldCaption() ?></span></td>
		<td<?php echo $processflow_tb->name->CellAttributes() ?>>
<span id="el_processflow_tb_name" class="control-group">
<span<?php echo $processflow_tb->name->ViewAttributes() ?>>
<?php echo $processflow_tb->name->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($processflow_tb->_email->Visible) { // email ?>
	<tr id="r__email">
		<td><span id="elh_processflow_tb__email"><?php echo $processflow_tb->_email->FldCaption() ?></span></td>
		<td<?php echo $processflow_tb->_email->CellAttributes() ?>>
<span id="el_processflow_tb__email" class="control-group">
<span<?php echo $processflow_tb->_email->ViewAttributes() ?>>
<?php echo $processflow_tb->_email->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($processflow_tb->progress->Visible) { // progress ?>
	<tr id="r_progress">
		<td><span id="elh_processflow_tb_progress"><?php echo $processflow_tb->progress->FldCaption() ?></span></td>
		<td<?php echo $processflow_tb->progress->CellAttributes() ?>>
<span id="el_processflow_tb_progress" class="control-group">
<span<?php echo $processflow_tb->progress->ViewAttributes() ?>>
<?php echo $processflow_tb->progress->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($processflow_tb->progress2->Visible) { // progress2 ?>
	<tr id="r_progress2">
		<td><span id="elh_processflow_tb_progress2"><?php echo $processflow_tb->progress2->FldCaption() ?></span></td>
		<td<?php echo $processflow_tb->progress2->CellAttributes() ?>>
<span id="el_processflow_tb_progress2" class="control-group">
<span<?php echo $processflow_tb->progress2->ViewAttributes() ?>>
<?php echo $processflow_tb->progress2->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($processflow_tb->progress3->Visible) { // progress3 ?>
	<tr id="r_progress3">
		<td><span id="elh_processflow_tb_progress3"><?php echo $processflow_tb->progress3->FldCaption() ?></span></td>
		<td<?php echo $processflow_tb->progress3->CellAttributes() ?>>
<span id="el_processflow_tb_progress3" class="control-group">
<span<?php echo $processflow_tb->progress3->ViewAttributes() ?>>
<?php echo $processflow_tb->progress3->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($processflow_tb->progress4->Visible) { // progress4 ?>
	<tr id="r_progress4">
		<td><span id="elh_processflow_tb_progress4"><?php echo $processflow_tb->progress4->FldCaption() ?></span></td>
		<td<?php echo $processflow_tb->progress4->CellAttributes() ?>>
<span id="el_processflow_tb_progress4" class="control-group">
<span<?php echo $processflow_tb->progress4->ViewAttributes() ?>>
<?php echo $processflow_tb->progress4->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($processflow_tb->progress5->Visible) { // progress5 ?>
	<tr id="r_progress5">
		<td><span id="elh_processflow_tb_progress5"><?php echo $processflow_tb->progress5->FldCaption() ?></span></td>
		<td<?php echo $processflow_tb->progress5->CellAttributes() ?>>
<span id="el_processflow_tb_progress5" class="control-group">
<span<?php echo $processflow_tb->progress5->ViewAttributes() ?>>
<?php echo $processflow_tb->progress5->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($processflow_tb->progress6->Visible) { // progress6 ?>
	<tr id="r_progress6">
		<td><span id="elh_processflow_tb_progress6"><?php echo $processflow_tb->progress6->FldCaption() ?></span></td>
		<td<?php echo $processflow_tb->progress6->CellAttributes() ?>>
<span id="el_processflow_tb_progress6" class="control-group">
<span<?php echo $processflow_tb->progress6->ViewAttributes() ?>>
<?php echo $processflow_tb->progress6->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
</table>
</td></tr></table>
<?php if ($processflow_tb->Export == "") { ?>
<table class="ewPager">
<tr><td>
<?php if (!isset($processflow_tb_view->Pager)) $processflow_tb_view->Pager = new cNumericPager($processflow_tb_view->StartRec, $processflow_tb_view->DisplayRecs, $processflow_tb_view->TotalRecs, $processflow_tb_view->RecRange) ?>
<?php if ($processflow_tb_view->Pager->RecordCount > 0) { ?>
<table cellspacing="0" class="ewStdTable"><tbody><tr><td>
<div class="pagination"><ul>
	<?php if ($processflow_tb_view->Pager->FirstButton->Enabled) { ?>
	<li><a href="<?php echo $processflow_tb_view->PageUrl() ?>start=<?php echo $processflow_tb_view->Pager->FirstButton->Start ?>"><?php echo $Language->Phrase("PagerFirst") ?></a></li>
	<?php } ?>
	<?php if ($processflow_tb_view->Pager->PrevButton->Enabled) { ?>
	<li><a href="<?php echo $processflow_tb_view->PageUrl() ?>start=<?php echo $processflow_tb_view->Pager->PrevButton->Start ?>"><?php echo $Language->Phrase("PagerPrevious") ?></a></li>
	<?php } ?>
	<?php foreach ($processflow_tb_view->Pager->Items as $PagerItem) { ?>
		<li<?php if (!$PagerItem->Enabled) { echo " class=\" active\""; } ?>><a href="<?php if ($PagerItem->Enabled) { echo $processflow_tb_view->PageUrl() . "start=" . $PagerItem->Start; } else { echo "#"; } ?>"><?php echo $PagerItem->Text ?></a></li>
	<?php } ?>
	<?php if ($processflow_tb_view->Pager->NextButton->Enabled) { ?>
	<li><a href="<?php echo $processflow_tb_view->PageUrl() ?>start=<?php echo $processflow_tb_view->Pager->NextButton->Start ?>"><?php echo $Language->Phrase("PagerNext") ?></a></li>
	<?php } ?>
	<?php if ($processflow_tb_view->Pager->LastButton->Enabled) { ?>
	<li><a href="<?php echo $processflow_tb_view->PageUrl() ?>start=<?php echo $processflow_tb_view->Pager->LastButton->Start ?>"><?php echo $Language->Phrase("PagerLast") ?></a></li>
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
</form>
<script type="text/javascript">
fprocessflow_tbview.Init();
</script>
<?php
$processflow_tb_view->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<?php if ($processflow_tb->Export == "") { ?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php } ?>
<?php include_once "footer.php" ?>
<?php
$processflow_tb_view->Page_Terminate();
?>
