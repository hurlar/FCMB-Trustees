<?php
if (session_id() == "") session_start(); // Initialize Session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg10.php" ?>
<?php include_once "ewmysql10.php" ?>
<?php include_once "phpfn10.php" ?>
<?php include_once "personal_infoinfo.php" ?>
<?php include_once "adminusersinfo.php" ?>
<?php include_once "comprehensivewill_tbinfo.php" ?>
<?php include_once "premiumwill_tbinfo.php" ?>
<?php include_once "privatetrust_tbinfo.php" ?>
<?php include_once "spouse_tbgridcls.php" ?>
<?php include_once "divorce_tbgridcls.php" ?>
<?php include_once "children_detailsgridcls.php" ?>
<?php include_once "beneficiary_dumpgridcls.php" ?>
<?php include_once "alt_beneficiarygridcls.php" ?>
<?php include_once "assets_tbgridcls.php" ?>
<?php include_once "overall_assetgridcls.php" ?>
<?php include_once "executor_tbgridcls.php" ?>
<?php include_once "trustee_tbgridcls.php" ?>
<?php include_once "witness_tbgridcls.php" ?>
<?php include_once "addinfo_tbgridcls.php" ?>
<?php include_once "userfn10.php" ?>
<?php

//
// Page class
//

$personal_info_view = NULL; // Initialize page object first

class cpersonal_info_view extends cpersonal_info {

	// Page ID
	var $PageID = 'view';

	// Project ID
	var $ProjectID = "{D9B361E7-B2C1-4293-B9B3-B581986A15CC}";

	// Table name
	var $TableName = 'personal_info';

	// Page object name
	var $PageObjName = 'personal_info_view';

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

		// Table object (personal_info)
		if (!isset($GLOBALS["personal_info"])) {
			$GLOBALS["personal_info"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["personal_info"];
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
			define("EW_TABLE_NAME", 'personal_info', TRUE);

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
					if (!$bMatchRecord) {
						if ($this->getSuccessMessage() == "" && $this->getFailureMessage() == "")
							$this->setFailureMessage($Language->Phrase("NoRecord")); // Set no record message
						$sReturnUrl = "personal_infolist.php"; // No matching record, return to list
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
			$sReturnUrl = "personal_infolist.php"; // Not page request, return to list
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
		$DetailTableLink = "";
		$option = &$options["detail"];

		// Detail table 'spouse_tb'
		$body = $Language->TablePhrase("spouse_tb", "TblCaption");
		$body = "<a class=\"ewAction ewDetailList\" href=\"" . ew_HtmlEncode("spouse_tblist.php?" . EW_TABLE_SHOW_MASTER . "=personal_info&uid=" . strval($this->uid->CurrentValue) . "") . "\">" . $body . "</a>";
		$item = &$option->Add("detail_spouse_tb");
		$item->Body = $body;
		$item->Visible = $Security->IsLoggedIn();
		if ($item->Visible) {
			if ($DetailTableLink <> "") $DetailTableLink .= ",";
			$DetailTableLink .= "spouse_tb";
		}

		// Detail table 'divorce_tb'
		$body = $Language->TablePhrase("divorce_tb", "TblCaption");
		$body = "<a class=\"ewAction ewDetailList\" href=\"" . ew_HtmlEncode("divorce_tblist.php?" . EW_TABLE_SHOW_MASTER . "=personal_info&uid=" . strval($this->uid->CurrentValue) . "") . "\">" . $body . "</a>";
		$item = &$option->Add("detail_divorce_tb");
		$item->Body = $body;
		$item->Visible = $Security->IsLoggedIn();
		if ($item->Visible) {
			if ($DetailTableLink <> "") $DetailTableLink .= ",";
			$DetailTableLink .= "divorce_tb";
		}

		// Detail table 'children_details'
		$body = $Language->TablePhrase("children_details", "TblCaption");
		$body = "<a class=\"ewAction ewDetailList\" href=\"" . ew_HtmlEncode("children_detailslist.php?" . EW_TABLE_SHOW_MASTER . "=personal_info&uid=" . strval($this->uid->CurrentValue) . "") . "\">" . $body . "</a>";
		$item = &$option->Add("detail_children_details");
		$item->Body = $body;
		$item->Visible = $Security->IsLoggedIn();
		if ($item->Visible) {
			if ($DetailTableLink <> "") $DetailTableLink .= ",";
			$DetailTableLink .= "children_details";
		}

		// Detail table 'beneficiary_dump'
		$body = $Language->TablePhrase("beneficiary_dump", "TblCaption");
		$body = "<a class=\"ewAction ewDetailList\" href=\"" . ew_HtmlEncode("beneficiary_dumplist.php?" . EW_TABLE_SHOW_MASTER . "=personal_info&uid=" . strval($this->uid->CurrentValue) . "") . "\">" . $body . "</a>";
		$item = &$option->Add("detail_beneficiary_dump");
		$item->Body = $body;
		$item->Visible = $Security->IsLoggedIn();
		if ($item->Visible) {
			if ($DetailTableLink <> "") $DetailTableLink .= ",";
			$DetailTableLink .= "beneficiary_dump";
		}

		// Detail table 'alt_beneficiary'
		$body = $Language->TablePhrase("alt_beneficiary", "TblCaption");
		$body = "<a class=\"ewAction ewDetailList\" href=\"" . ew_HtmlEncode("alt_beneficiarylist.php?" . EW_TABLE_SHOW_MASTER . "=personal_info&uid=" . strval($this->uid->CurrentValue) . "") . "\">" . $body . "</a>";
		$item = &$option->Add("detail_alt_beneficiary");
		$item->Body = $body;
		$item->Visible = $Security->IsLoggedIn();
		if ($item->Visible) {
			if ($DetailTableLink <> "") $DetailTableLink .= ",";
			$DetailTableLink .= "alt_beneficiary";
		}

		// Detail table 'assets_tb'
		$body = $Language->TablePhrase("assets_tb", "TblCaption");
		$body = "<a class=\"ewAction ewDetailList\" href=\"" . ew_HtmlEncode("assets_tblist.php?" . EW_TABLE_SHOW_MASTER . "=personal_info&uid=" . strval($this->uid->CurrentValue) . "") . "\">" . $body . "</a>";
		$item = &$option->Add("detail_assets_tb");
		$item->Body = $body;
		$item->Visible = $Security->IsLoggedIn();
		if ($item->Visible) {
			if ($DetailTableLink <> "") $DetailTableLink .= ",";
			$DetailTableLink .= "assets_tb";
		}

		// Detail table 'overall_asset'
		$body = $Language->TablePhrase("overall_asset", "TblCaption");
		$body = "<a class=\"ewAction ewDetailList\" href=\"" . ew_HtmlEncode("overall_assetlist.php?" . EW_TABLE_SHOW_MASTER . "=personal_info&uid=" . strval($this->uid->CurrentValue) . "") . "\">" . $body . "</a>";
		$item = &$option->Add("detail_overall_asset");
		$item->Body = $body;
		$item->Visible = $Security->IsLoggedIn();
		if ($item->Visible) {
			if ($DetailTableLink <> "") $DetailTableLink .= ",";
			$DetailTableLink .= "overall_asset";
		}

		// Detail table 'executor_tb'
		$body = $Language->TablePhrase("executor_tb", "TblCaption");
		$body = "<a class=\"ewAction ewDetailList\" href=\"" . ew_HtmlEncode("executor_tblist.php?" . EW_TABLE_SHOW_MASTER . "=personal_info&uid=" . strval($this->uid->CurrentValue) . "") . "\">" . $body . "</a>";
		$item = &$option->Add("detail_executor_tb");
		$item->Body = $body;
		$item->Visible = $Security->IsLoggedIn();
		if ($item->Visible) {
			if ($DetailTableLink <> "") $DetailTableLink .= ",";
			$DetailTableLink .= "executor_tb";
		}

		// Detail table 'trustee_tb'
		$body = $Language->TablePhrase("trustee_tb", "TblCaption");
		$body = "<a class=\"ewAction ewDetailList\" href=\"" . ew_HtmlEncode("trustee_tblist.php?" . EW_TABLE_SHOW_MASTER . "=personal_info&uid=" . strval($this->uid->CurrentValue) . "") . "\">" . $body . "</a>";
		$item = &$option->Add("detail_trustee_tb");
		$item->Body = $body;
		$item->Visible = $Security->IsLoggedIn();
		if ($item->Visible) {
			if ($DetailTableLink <> "") $DetailTableLink .= ",";
			$DetailTableLink .= "trustee_tb";
		}

		// Detail table 'witness_tb'
		$body = $Language->TablePhrase("witness_tb", "TblCaption");
		$body = "<a class=\"ewAction ewDetailList\" href=\"" . ew_HtmlEncode("witness_tblist.php?" . EW_TABLE_SHOW_MASTER . "=personal_info&uid=" . strval($this->uid->CurrentValue) . "") . "\">" . $body . "</a>";
		$item = &$option->Add("detail_witness_tb");
		$item->Body = $body;
		$item->Visible = $Security->IsLoggedIn();
		if ($item->Visible) {
			if ($DetailTableLink <> "") $DetailTableLink .= ",";
			$DetailTableLink .= "witness_tb";
		}

		// Detail table 'addinfo_tb'
		$body = $Language->TablePhrase("addinfo_tb", "TblCaption");
		$body = "<a class=\"ewAction ewDetailList\" href=\"" . ew_HtmlEncode("addinfo_tblist.php?" . EW_TABLE_SHOW_MASTER . "=personal_info&uid=" . strval($this->uid->CurrentValue) . "") . "\">" . $body . "</a>";
		$item = &$option->Add("detail_addinfo_tb");
		$item->Body = $body;
		$item->Visible = $Security->IsLoggedIn();
		if ($item->Visible) {
			if ($DetailTableLink <> "") $DetailTableLink .= ",";
			$DetailTableLink .= "addinfo_tb";
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
		$this->salutation->setDbValue($rs->fields('salutation'));
		$this->fname->setDbValue($rs->fields('fname'));
		$this->mname->setDbValue($rs->fields('mname'));
		$this->lname->setDbValue($rs->fields('lname'));
		$this->phone->setDbValue($rs->fields('phone'));
		$this->aphone->setDbValue($rs->fields('aphone'));
		$this->msg->setDbValue($rs->fields('msg'));
		$this->city->setDbValue($rs->fields('city'));
		$this->rstate->setDbValue($rs->fields('rstate'));
		$this->dob->setDbValue($rs->fields('dob'));
		$this->gender->setDbValue($rs->fields('gender'));
		$this->lga->setDbValue($rs->fields('lga'));
		$this->nationality->setDbValue($rs->fields('nationality'));
		$this->state->setDbValue($rs->fields('state'));
		$this->employment_status->setDbValue($rs->fields('employment_status'));
		$this->employer->setDbValue($rs->fields('employer'));
		$this->employerphone->setDbValue($rs->fields('employerphone'));
		$this->employeraddr->setDbValue($rs->fields('employeraddr'));
		$this->datecreated->setDbValue($rs->fields('datecreated'));
		$this->maidenname->setDbValue($rs->fields('maidenname'));
		$this->passport->setDbValue($rs->fields('passport'));
		$this->identification_type->setDbValue($rs->fields('identification_type'));
		$this->identification_number->setDbValue($rs->fields('identification_number'));
		$this->issuedate->setDbValue($rs->fields('issuedate'));
		$this->expirydate->setDbValue($rs->fields('expirydate'));
		$this->issuedplace->setDbValue($rs->fields('issuedplace'));
		$this->earning_type->setDbValue($rs->fields('earning_type'));
		$this->earning_note->setDbValue($rs->fields('earning_note'));
		$this->annual_income->setDbValue($rs->fields('annual_income'));
		$this->nameofcompany->setDbValue($rs->fields('nameofcompany'));
		$this->company_telephone->setDbValue($rs->fields('company_telephone'));
		$this->company_email->setDbValue($rs->fields('company_email'));
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
		$this->phone->DbValue = $row['phone'];
		$this->aphone->DbValue = $row['aphone'];
		$this->msg->DbValue = $row['msg'];
		$this->city->DbValue = $row['city'];
		$this->rstate->DbValue = $row['rstate'];
		$this->dob->DbValue = $row['dob'];
		$this->gender->DbValue = $row['gender'];
		$this->lga->DbValue = $row['lga'];
		$this->nationality->DbValue = $row['nationality'];
		$this->state->DbValue = $row['state'];
		$this->employment_status->DbValue = $row['employment_status'];
		$this->employer->DbValue = $row['employer'];
		$this->employerphone->DbValue = $row['employerphone'];
		$this->employeraddr->DbValue = $row['employeraddr'];
		$this->datecreated->DbValue = $row['datecreated'];
		$this->maidenname->DbValue = $row['maidenname'];
		$this->passport->DbValue = $row['passport'];
		$this->identification_type->DbValue = $row['identification_type'];
		$this->identification_number->DbValue = $row['identification_number'];
		$this->issuedate->DbValue = $row['issuedate'];
		$this->expirydate->DbValue = $row['expirydate'];
		$this->issuedplace->DbValue = $row['issuedplace'];
		$this->earning_type->DbValue = $row['earning_type'];
		$this->earning_note->DbValue = $row['earning_note'];
		$this->annual_income->DbValue = $row['annual_income'];
		$this->nameofcompany->DbValue = $row['nameofcompany'];
		$this->company_telephone->DbValue = $row['company_telephone'];
		$this->company_email->DbValue = $row['company_email'];
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
		// salutation
		// fname
		// mname
		// lname
		// phone
		// aphone
		// msg
		// city
		// rstate
		// dob
		// gender
		// lga
		// nationality
		// state
		// employment_status
		// employer
		// employerphone
		// employeraddr
		// datecreated
		// maidenname
		// passport
		// identification_type
		// identification_number
		// issuedate
		// expirydate
		// issuedplace
		// earning_type
		// earning_note
		// annual_income
		// nameofcompany
		// company_telephone
		// company_email

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

			// dob
			$this->dob->ViewValue = $this->dob->CurrentValue;
			$this->dob->ViewCustomAttributes = "";

			// gender
			$this->gender->ViewValue = $this->gender->CurrentValue;
			$this->gender->ViewCustomAttributes = "";

			// lga
			$this->lga->ViewValue = $this->lga->CurrentValue;
			$this->lga->ViewCustomAttributes = "";

			// nationality
			$this->nationality->ViewValue = $this->nationality->CurrentValue;
			$this->nationality->ViewCustomAttributes = "";

			// state
			$this->state->ViewValue = $this->state->CurrentValue;
			$this->state->ViewCustomAttributes = "";

			// employment_status
			$this->employment_status->ViewValue = $this->employment_status->CurrentValue;
			$this->employment_status->ViewCustomAttributes = "";

			// employer
			$this->employer->ViewValue = $this->employer->CurrentValue;
			$this->employer->ViewCustomAttributes = "";

			// employerphone
			$this->employerphone->ViewValue = $this->employerphone->CurrentValue;
			$this->employerphone->ViewCustomAttributes = "";

			// employeraddr
			$this->employeraddr->ViewValue = $this->employeraddr->CurrentValue;
			$this->employeraddr->ViewCustomAttributes = "";

			// datecreated
			$this->datecreated->ViewValue = $this->datecreated->CurrentValue;
			$this->datecreated->ViewCustomAttributes = "";

			// maidenname
			$this->maidenname->ViewValue = $this->maidenname->CurrentValue;
			$this->maidenname->ViewCustomAttributes = "";

			// passport
			$this->passport->ViewValue = $this->passport->CurrentValue;
			$this->passport->ViewCustomAttributes = "";

			// identification_type
			$this->identification_type->ViewValue = $this->identification_type->CurrentValue;
			$this->identification_type->ViewCustomAttributes = "";

			// identification_number
			$this->identification_number->ViewValue = $this->identification_number->CurrentValue;
			$this->identification_number->ViewCustomAttributes = "";

			// issuedate
			$this->issuedate->ViewValue = $this->issuedate->CurrentValue;
			$this->issuedate->ViewCustomAttributes = "";

			// expirydate
			$this->expirydate->ViewValue = $this->expirydate->CurrentValue;
			$this->expirydate->ViewCustomAttributes = "";

			// issuedplace
			$this->issuedplace->ViewValue = $this->issuedplace->CurrentValue;
			$this->issuedplace->ViewCustomAttributes = "";

			// earning_type
			$this->earning_type->ViewValue = $this->earning_type->CurrentValue;
			$this->earning_type->ViewCustomAttributes = "";

			// earning_note
			$this->earning_note->ViewValue = $this->earning_note->CurrentValue;
			$this->earning_note->ViewCustomAttributes = "";

			// annual_income
			$this->annual_income->ViewValue = $this->annual_income->CurrentValue;
			$this->annual_income->ViewCustomAttributes = "";

			// nameofcompany
			$this->nameofcompany->ViewValue = $this->nameofcompany->CurrentValue;
			$this->nameofcompany->ViewCustomAttributes = "";

			// company_telephone
			$this->company_telephone->ViewValue = $this->company_telephone->CurrentValue;
			$this->company_telephone->ViewCustomAttributes = "";

			// company_email
			$this->company_email->ViewValue = $this->company_email->CurrentValue;
			$this->company_email->ViewCustomAttributes = "";

			// id
			$this->id->LinkCustomAttributes = "";
			$this->id->HrefValue = "";
			$this->id->TooltipValue = "";

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

			// dob
			$this->dob->LinkCustomAttributes = "";
			$this->dob->HrefValue = "";
			$this->dob->TooltipValue = "";

			// gender
			$this->gender->LinkCustomAttributes = "";
			$this->gender->HrefValue = "";
			$this->gender->TooltipValue = "";

			// lga
			$this->lga->LinkCustomAttributes = "";
			$this->lga->HrefValue = "";
			$this->lga->TooltipValue = "";

			// nationality
			$this->nationality->LinkCustomAttributes = "";
			$this->nationality->HrefValue = "";
			$this->nationality->TooltipValue = "";

			// state
			$this->state->LinkCustomAttributes = "";
			$this->state->HrefValue = "";
			$this->state->TooltipValue = "";

			// employment_status
			$this->employment_status->LinkCustomAttributes = "";
			$this->employment_status->HrefValue = "";
			$this->employment_status->TooltipValue = "";

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

			// datecreated
			$this->datecreated->LinkCustomAttributes = "";
			$this->datecreated->HrefValue = "";
			$this->datecreated->TooltipValue = "";

			// maidenname
			$this->maidenname->LinkCustomAttributes = "";
			$this->maidenname->HrefValue = "";
			$this->maidenname->TooltipValue = "";

			// passport
			$this->passport->LinkCustomAttributes = "";
			$this->passport->HrefValue = "";
			$this->passport->TooltipValue = "";

			// identification_type
			$this->identification_type->LinkCustomAttributes = "";
			$this->identification_type->HrefValue = "";
			$this->identification_type->TooltipValue = "";

			// identification_number
			$this->identification_number->LinkCustomAttributes = "";
			$this->identification_number->HrefValue = "";
			$this->identification_number->TooltipValue = "";

			// issuedate
			$this->issuedate->LinkCustomAttributes = "";
			$this->issuedate->HrefValue = "";
			$this->issuedate->TooltipValue = "";

			// expirydate
			$this->expirydate->LinkCustomAttributes = "";
			$this->expirydate->HrefValue = "";
			$this->expirydate->TooltipValue = "";

			// issuedplace
			$this->issuedplace->LinkCustomAttributes = "";
			$this->issuedplace->HrefValue = "";
			$this->issuedplace->TooltipValue = "";

			// earning_type
			$this->earning_type->LinkCustomAttributes = "";
			$this->earning_type->HrefValue = "";
			$this->earning_type->TooltipValue = "";

			// earning_note
			$this->earning_note->LinkCustomAttributes = "";
			$this->earning_note->HrefValue = "";
			$this->earning_note->TooltipValue = "";

			// annual_income
			$this->annual_income->LinkCustomAttributes = "";
			$this->annual_income->HrefValue = "";
			$this->annual_income->TooltipValue = "";

			// nameofcompany
			$this->nameofcompany->LinkCustomAttributes = "";
			$this->nameofcompany->HrefValue = "";
			$this->nameofcompany->TooltipValue = "";

			// company_telephone
			$this->company_telephone->LinkCustomAttributes = "";
			$this->company_telephone->HrefValue = "";
			$this->company_telephone->TooltipValue = "";

			// company_email
			$this->company_email->LinkCustomAttributes = "";
			$this->company_email->HrefValue = "";
			$this->company_email->TooltipValue = "";
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
		$item->Body = "<a id=\"emf_personal_info\" href=\"javascript:void(0);\" class=\"ewExportLink ewEmail\" data-caption=\"" . $Language->Phrase("ExportToEmailText") . "\" onclick=\"ew_EmailDialogShow({lnk:'emf_personal_info',hdr:ewLanguage.Phrase('ExportToEmail'),f:document.fpersonal_infoview,key:" . ew_ArrayToJsonAttr($this->RecKey) . ",sel:false});\">" . $Language->Phrase("ExportToEmail") . "</a>";
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
			if (in_array("spouse_tb", $DetailTblVar)) {
				if (!isset($GLOBALS["spouse_tb_grid"]))
					$GLOBALS["spouse_tb_grid"] = new cspouse_tb_grid;
				if ($GLOBALS["spouse_tb_grid"]->DetailView) {
					$GLOBALS["spouse_tb_grid"]->CurrentMode = "view";

					// Save current master table to detail table
					$GLOBALS["spouse_tb_grid"]->setCurrentMasterTable($this->TableVar);
					$GLOBALS["spouse_tb_grid"]->setStartRecordNumber(1);
					$GLOBALS["spouse_tb_grid"]->uid->FldIsDetailKey = TRUE;
					$GLOBALS["spouse_tb_grid"]->uid->CurrentValue = $this->uid->CurrentValue;
					$GLOBALS["spouse_tb_grid"]->uid->setSessionValue($GLOBALS["spouse_tb_grid"]->uid->CurrentValue);
				}
			}
			if (in_array("divorce_tb", $DetailTblVar)) {
				if (!isset($GLOBALS["divorce_tb_grid"]))
					$GLOBALS["divorce_tb_grid"] = new cdivorce_tb_grid;
				if ($GLOBALS["divorce_tb_grid"]->DetailView) {
					$GLOBALS["divorce_tb_grid"]->CurrentMode = "view";

					// Save current master table to detail table
					$GLOBALS["divorce_tb_grid"]->setCurrentMasterTable($this->TableVar);
					$GLOBALS["divorce_tb_grid"]->setStartRecordNumber(1);
					$GLOBALS["divorce_tb_grid"]->uid->FldIsDetailKey = TRUE;
					$GLOBALS["divorce_tb_grid"]->uid->CurrentValue = $this->uid->CurrentValue;
					$GLOBALS["divorce_tb_grid"]->uid->setSessionValue($GLOBALS["divorce_tb_grid"]->uid->CurrentValue);
				}
			}
			if (in_array("children_details", $DetailTblVar)) {
				if (!isset($GLOBALS["children_details_grid"]))
					$GLOBALS["children_details_grid"] = new cchildren_details_grid;
				if ($GLOBALS["children_details_grid"]->DetailView) {
					$GLOBALS["children_details_grid"]->CurrentMode = "view";

					// Save current master table to detail table
					$GLOBALS["children_details_grid"]->setCurrentMasterTable($this->TableVar);
					$GLOBALS["children_details_grid"]->setStartRecordNumber(1);
					$GLOBALS["children_details_grid"]->uid->FldIsDetailKey = TRUE;
					$GLOBALS["children_details_grid"]->uid->CurrentValue = $this->uid->CurrentValue;
					$GLOBALS["children_details_grid"]->uid->setSessionValue($GLOBALS["children_details_grid"]->uid->CurrentValue);
				}
			}
			if (in_array("beneficiary_dump", $DetailTblVar)) {
				if (!isset($GLOBALS["beneficiary_dump_grid"]))
					$GLOBALS["beneficiary_dump_grid"] = new cbeneficiary_dump_grid;
				if ($GLOBALS["beneficiary_dump_grid"]->DetailView) {
					$GLOBALS["beneficiary_dump_grid"]->CurrentMode = "view";

					// Save current master table to detail table
					$GLOBALS["beneficiary_dump_grid"]->setCurrentMasterTable($this->TableVar);
					$GLOBALS["beneficiary_dump_grid"]->setStartRecordNumber(1);
					$GLOBALS["beneficiary_dump_grid"]->uid->FldIsDetailKey = TRUE;
					$GLOBALS["beneficiary_dump_grid"]->uid->CurrentValue = $this->uid->CurrentValue;
					$GLOBALS["beneficiary_dump_grid"]->uid->setSessionValue($GLOBALS["beneficiary_dump_grid"]->uid->CurrentValue);
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
					$GLOBALS["alt_beneficiary_grid"]->uid->FldIsDetailKey = TRUE;
					$GLOBALS["alt_beneficiary_grid"]->uid->CurrentValue = $this->uid->CurrentValue;
					$GLOBALS["alt_beneficiary_grid"]->uid->setSessionValue($GLOBALS["alt_beneficiary_grid"]->uid->CurrentValue);
				}
			}
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
			if (in_array("overall_asset", $DetailTblVar)) {
				if (!isset($GLOBALS["overall_asset_grid"]))
					$GLOBALS["overall_asset_grid"] = new coverall_asset_grid;
				if ($GLOBALS["overall_asset_grid"]->DetailView) {
					$GLOBALS["overall_asset_grid"]->CurrentMode = "view";

					// Save current master table to detail table
					$GLOBALS["overall_asset_grid"]->setCurrentMasterTable($this->TableVar);
					$GLOBALS["overall_asset_grid"]->setStartRecordNumber(1);
					$GLOBALS["overall_asset_grid"]->uid->FldIsDetailKey = TRUE;
					$GLOBALS["overall_asset_grid"]->uid->CurrentValue = $this->uid->CurrentValue;
					$GLOBALS["overall_asset_grid"]->uid->setSessionValue($GLOBALS["overall_asset_grid"]->uid->CurrentValue);
				}
			}
			if (in_array("executor_tb", $DetailTblVar)) {
				if (!isset($GLOBALS["executor_tb_grid"]))
					$GLOBALS["executor_tb_grid"] = new cexecutor_tb_grid;
				if ($GLOBALS["executor_tb_grid"]->DetailView) {
					$GLOBALS["executor_tb_grid"]->CurrentMode = "view";

					// Save current master table to detail table
					$GLOBALS["executor_tb_grid"]->setCurrentMasterTable($this->TableVar);
					$GLOBALS["executor_tb_grid"]->setStartRecordNumber(1);
					$GLOBALS["executor_tb_grid"]->uid->FldIsDetailKey = TRUE;
					$GLOBALS["executor_tb_grid"]->uid->CurrentValue = $this->uid->CurrentValue;
					$GLOBALS["executor_tb_grid"]->uid->setSessionValue($GLOBALS["executor_tb_grid"]->uid->CurrentValue);
				}
			}
			if (in_array("trustee_tb", $DetailTblVar)) {
				if (!isset($GLOBALS["trustee_tb_grid"]))
					$GLOBALS["trustee_tb_grid"] = new ctrustee_tb_grid;
				if ($GLOBALS["trustee_tb_grid"]->DetailView) {
					$GLOBALS["trustee_tb_grid"]->CurrentMode = "view";

					// Save current master table to detail table
					$GLOBALS["trustee_tb_grid"]->setCurrentMasterTable($this->TableVar);
					$GLOBALS["trustee_tb_grid"]->setStartRecordNumber(1);
					$GLOBALS["trustee_tb_grid"]->uid->FldIsDetailKey = TRUE;
					$GLOBALS["trustee_tb_grid"]->uid->CurrentValue = $this->uid->CurrentValue;
					$GLOBALS["trustee_tb_grid"]->uid->setSessionValue($GLOBALS["trustee_tb_grid"]->uid->CurrentValue);
				}
			}
			if (in_array("witness_tb", $DetailTblVar)) {
				if (!isset($GLOBALS["witness_tb_grid"]))
					$GLOBALS["witness_tb_grid"] = new cwitness_tb_grid;
				if ($GLOBALS["witness_tb_grid"]->DetailView) {
					$GLOBALS["witness_tb_grid"]->CurrentMode = "view";

					// Save current master table to detail table
					$GLOBALS["witness_tb_grid"]->setCurrentMasterTable($this->TableVar);
					$GLOBALS["witness_tb_grid"]->setStartRecordNumber(1);
					$GLOBALS["witness_tb_grid"]->uid->FldIsDetailKey = TRUE;
					$GLOBALS["witness_tb_grid"]->uid->CurrentValue = $this->uid->CurrentValue;
					$GLOBALS["witness_tb_grid"]->uid->setSessionValue($GLOBALS["witness_tb_grid"]->uid->CurrentValue);
				}
			}
			if (in_array("addinfo_tb", $DetailTblVar)) {
				if (!isset($GLOBALS["addinfo_tb_grid"]))
					$GLOBALS["addinfo_tb_grid"] = new caddinfo_tb_grid;
				if ($GLOBALS["addinfo_tb_grid"]->DetailView) {
					$GLOBALS["addinfo_tb_grid"]->CurrentMode = "view";

					// Save current master table to detail table
					$GLOBALS["addinfo_tb_grid"]->setCurrentMasterTable($this->TableVar);
					$GLOBALS["addinfo_tb_grid"]->setStartRecordNumber(1);
					$GLOBALS["addinfo_tb_grid"]->uid->FldIsDetailKey = TRUE;
					$GLOBALS["addinfo_tb_grid"]->uid->CurrentValue = $this->uid->CurrentValue;
					$GLOBALS["addinfo_tb_grid"]->uid->setSessionValue($GLOBALS["addinfo_tb_grid"]->uid->CurrentValue);
				}
			}
		}
	}

	// Set up Breadcrumb
	function SetupBreadcrumb() {
		global $Breadcrumb, $Language;
		$Breadcrumb = new cBreadcrumb();
		$PageCaption = $this->TableCaption();
		$Breadcrumb->Add("list", "<span id=\"ewPageCaption\">" . $PageCaption . "</span>", "personal_infolist.php", $this->TableVar);
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
if (!isset($personal_info_view)) $personal_info_view = new cpersonal_info_view();

// Page init
$personal_info_view->Page_Init();

// Page main
$personal_info_view->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$personal_info_view->Page_Render();
?>
<?php include_once "header.php" ?>
<?php if ($personal_info->Export == "") { ?>
<script type="text/javascript">

// Page object
var personal_info_view = new ew_Page("personal_info_view");
personal_info_view.PageID = "view"; // Page ID
var EW_PAGE_ID = personal_info_view.PageID; // For backward compatibility

// Form object
var fpersonal_infoview = new ew_Form("fpersonal_infoview");

// Form_CustomValidate event
fpersonal_infoview.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
fpersonal_infoview.ValidateRequired = true;
<?php } else { ?>
fpersonal_infoview.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
// Form object for search

</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<?php } ?>
<?php if ($personal_info->Export == "") { ?>
<?php $Breadcrumb->Render(); ?>
<?php } ?>
<?php if ($personal_info->Export == "") { ?>
<div class="ewViewExportOptions">
<?php $personal_info_view->ExportOptions->Render("body") ?>
<?php if (!$personal_info_view->ExportOptions->UseDropDownButton) { ?>
</div>
<div class="ewViewOtherOptions">
<?php } ?>
<?php
	foreach ($personal_info_view->OtherOptions as &$option)
		$option->Render("body");
?>
</div>
<?php } ?>
<?php $personal_info_view->ShowPageHeader(); ?>
<?php
$personal_info_view->ShowMessage();
?>
<form name="fpersonal_infoview" id="fpersonal_infoview" class="ewForm form-horizontal" action="<?php echo ew_CurrentPage() ?>" method="post">
<input type="hidden" name="t" value="personal_info">
<table cellspacing="0" class="ewGrid"><tr><td>
<table id="tbl_personal_infoview" class="table table-bordered table-striped">
<?php if ($personal_info->id->Visible) { // id ?>
	<tr id="r_id">
		<td><span id="elh_personal_info_id"><?php echo $personal_info->id->FldCaption() ?></span></td>
		<td<?php echo $personal_info->id->CellAttributes() ?>>
<span id="el_personal_info_id" class="control-group">
<span<?php echo $personal_info->id->ViewAttributes() ?>>
<?php echo $personal_info->id->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($personal_info->salutation->Visible) { // salutation ?>
	<tr id="r_salutation">
		<td><span id="elh_personal_info_salutation"><?php echo $personal_info->salutation->FldCaption() ?></span></td>
		<td<?php echo $personal_info->salutation->CellAttributes() ?>>
<span id="el_personal_info_salutation" class="control-group">
<span<?php echo $personal_info->salutation->ViewAttributes() ?>>
<?php echo $personal_info->salutation->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($personal_info->fname->Visible) { // fname ?>
	<tr id="r_fname">
		<td><span id="elh_personal_info_fname"><?php echo $personal_info->fname->FldCaption() ?></span></td>
		<td<?php echo $personal_info->fname->CellAttributes() ?>>
<span id="el_personal_info_fname" class="control-group">
<span<?php echo $personal_info->fname->ViewAttributes() ?>>
<?php echo $personal_info->fname->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($personal_info->mname->Visible) { // mname ?>
	<tr id="r_mname">
		<td><span id="elh_personal_info_mname"><?php echo $personal_info->mname->FldCaption() ?></span></td>
		<td<?php echo $personal_info->mname->CellAttributes() ?>>
<span id="el_personal_info_mname" class="control-group">
<span<?php echo $personal_info->mname->ViewAttributes() ?>>
<?php echo $personal_info->mname->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($personal_info->lname->Visible) { // lname ?>
	<tr id="r_lname">
		<td><span id="elh_personal_info_lname"><?php echo $personal_info->lname->FldCaption() ?></span></td>
		<td<?php echo $personal_info->lname->CellAttributes() ?>>
<span id="el_personal_info_lname" class="control-group">
<span<?php echo $personal_info->lname->ViewAttributes() ?>>
<?php echo $personal_info->lname->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($personal_info->phone->Visible) { // phone ?>
	<tr id="r_phone">
		<td><span id="elh_personal_info_phone"><?php echo $personal_info->phone->FldCaption() ?></span></td>
		<td<?php echo $personal_info->phone->CellAttributes() ?>>
<span id="el_personal_info_phone" class="control-group">
<span<?php echo $personal_info->phone->ViewAttributes() ?>>
<?php echo $personal_info->phone->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($personal_info->aphone->Visible) { // aphone ?>
	<tr id="r_aphone">
		<td><span id="elh_personal_info_aphone"><?php echo $personal_info->aphone->FldCaption() ?></span></td>
		<td<?php echo $personal_info->aphone->CellAttributes() ?>>
<span id="el_personal_info_aphone" class="control-group">
<span<?php echo $personal_info->aphone->ViewAttributes() ?>>
<?php echo $personal_info->aphone->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($personal_info->msg->Visible) { // msg ?>
	<tr id="r_msg">
		<td><span id="elh_personal_info_msg"><?php echo $personal_info->msg->FldCaption() ?></span></td>
		<td<?php echo $personal_info->msg->CellAttributes() ?>>
<span id="el_personal_info_msg" class="control-group">
<span<?php echo $personal_info->msg->ViewAttributes() ?>>
<?php echo $personal_info->msg->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($personal_info->city->Visible) { // city ?>
	<tr id="r_city">
		<td><span id="elh_personal_info_city"><?php echo $personal_info->city->FldCaption() ?></span></td>
		<td<?php echo $personal_info->city->CellAttributes() ?>>
<span id="el_personal_info_city" class="control-group">
<span<?php echo $personal_info->city->ViewAttributes() ?>>
<?php echo $personal_info->city->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($personal_info->rstate->Visible) { // rstate ?>
	<tr id="r_rstate">
		<td><span id="elh_personal_info_rstate"><?php echo $personal_info->rstate->FldCaption() ?></span></td>
		<td<?php echo $personal_info->rstate->CellAttributes() ?>>
<span id="el_personal_info_rstate" class="control-group">
<span<?php echo $personal_info->rstate->ViewAttributes() ?>>
<?php echo $personal_info->rstate->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($personal_info->dob->Visible) { // dob ?>
	<tr id="r_dob">
		<td><span id="elh_personal_info_dob"><?php echo $personal_info->dob->FldCaption() ?></span></td>
		<td<?php echo $personal_info->dob->CellAttributes() ?>>
<span id="el_personal_info_dob" class="control-group">
<span<?php echo $personal_info->dob->ViewAttributes() ?>>
<?php echo $personal_info->dob->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($personal_info->gender->Visible) { // gender ?>
	<tr id="r_gender">
		<td><span id="elh_personal_info_gender"><?php echo $personal_info->gender->FldCaption() ?></span></td>
		<td<?php echo $personal_info->gender->CellAttributes() ?>>
<span id="el_personal_info_gender" class="control-group">
<span<?php echo $personal_info->gender->ViewAttributes() ?>>
<?php echo $personal_info->gender->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($personal_info->lga->Visible) { // lga ?>
	<tr id="r_lga">
		<td><span id="elh_personal_info_lga"><?php echo $personal_info->lga->FldCaption() ?></span></td>
		<td<?php echo $personal_info->lga->CellAttributes() ?>>
<span id="el_personal_info_lga" class="control-group">
<span<?php echo $personal_info->lga->ViewAttributes() ?>>
<?php echo $personal_info->lga->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($personal_info->nationality->Visible) { // nationality ?>
	<tr id="r_nationality">
		<td><span id="elh_personal_info_nationality"><?php echo $personal_info->nationality->FldCaption() ?></span></td>
		<td<?php echo $personal_info->nationality->CellAttributes() ?>>
<span id="el_personal_info_nationality" class="control-group">
<span<?php echo $personal_info->nationality->ViewAttributes() ?>>
<?php echo $personal_info->nationality->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($personal_info->state->Visible) { // state ?>
	<tr id="r_state">
		<td><span id="elh_personal_info_state"><?php echo $personal_info->state->FldCaption() ?></span></td>
		<td<?php echo $personal_info->state->CellAttributes() ?>>
<span id="el_personal_info_state" class="control-group">
<span<?php echo $personal_info->state->ViewAttributes() ?>>
<?php echo $personal_info->state->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($personal_info->employment_status->Visible) { // employment_status ?>
	<tr id="r_employment_status">
		<td><span id="elh_personal_info_employment_status"><?php echo $personal_info->employment_status->FldCaption() ?></span></td>
		<td<?php echo $personal_info->employment_status->CellAttributes() ?>>
<span id="el_personal_info_employment_status" class="control-group">
<span<?php echo $personal_info->employment_status->ViewAttributes() ?>>
<?php echo $personal_info->employment_status->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($personal_info->employer->Visible) { // employer ?>
	<tr id="r_employer">
		<td><span id="elh_personal_info_employer"><?php echo $personal_info->employer->FldCaption() ?></span></td>
		<td<?php echo $personal_info->employer->CellAttributes() ?>>
<span id="el_personal_info_employer" class="control-group">
<span<?php echo $personal_info->employer->ViewAttributes() ?>>
<?php echo $personal_info->employer->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($personal_info->employerphone->Visible) { // employerphone ?>
	<tr id="r_employerphone">
		<td><span id="elh_personal_info_employerphone"><?php echo $personal_info->employerphone->FldCaption() ?></span></td>
		<td<?php echo $personal_info->employerphone->CellAttributes() ?>>
<span id="el_personal_info_employerphone" class="control-group">
<span<?php echo $personal_info->employerphone->ViewAttributes() ?>>
<?php echo $personal_info->employerphone->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($personal_info->employeraddr->Visible) { // employeraddr ?>
	<tr id="r_employeraddr">
		<td><span id="elh_personal_info_employeraddr"><?php echo $personal_info->employeraddr->FldCaption() ?></span></td>
		<td<?php echo $personal_info->employeraddr->CellAttributes() ?>>
<span id="el_personal_info_employeraddr" class="control-group">
<span<?php echo $personal_info->employeraddr->ViewAttributes() ?>>
<?php echo $personal_info->employeraddr->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($personal_info->datecreated->Visible) { // datecreated ?>
	<tr id="r_datecreated">
		<td><span id="elh_personal_info_datecreated"><?php echo $personal_info->datecreated->FldCaption() ?></span></td>
		<td<?php echo $personal_info->datecreated->CellAttributes() ?>>
<span id="el_personal_info_datecreated" class="control-group">
<span<?php echo $personal_info->datecreated->ViewAttributes() ?>>
<?php echo $personal_info->datecreated->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($personal_info->maidenname->Visible) { // maidenname ?>
	<tr id="r_maidenname">
		<td><span id="elh_personal_info_maidenname"><?php echo $personal_info->maidenname->FldCaption() ?></span></td>
		<td<?php echo $personal_info->maidenname->CellAttributes() ?>>
<span id="el_personal_info_maidenname" class="control-group">
<span<?php echo $personal_info->maidenname->ViewAttributes() ?>>
<?php echo $personal_info->maidenname->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($personal_info->passport->Visible) { // passport ?>
	<tr id="r_passport">
		<td><span id="elh_personal_info_passport"><?php echo $personal_info->passport->FldCaption() ?></span></td>
		<td<?php echo $personal_info->passport->CellAttributes() ?>>
<span id="el_personal_info_passport" class="control-group">
<span<?php echo $personal_info->passport->ViewAttributes() ?>>
<?php echo $personal_info->passport->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($personal_info->identification_type->Visible) { // identification_type ?>
	<tr id="r_identification_type">
		<td><span id="elh_personal_info_identification_type"><?php echo $personal_info->identification_type->FldCaption() ?></span></td>
		<td<?php echo $personal_info->identification_type->CellAttributes() ?>>
<span id="el_personal_info_identification_type" class="control-group">
<span<?php echo $personal_info->identification_type->ViewAttributes() ?>>
<?php echo $personal_info->identification_type->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($personal_info->identification_number->Visible) { // identification_number ?>
	<tr id="r_identification_number">
		<td><span id="elh_personal_info_identification_number"><?php echo $personal_info->identification_number->FldCaption() ?></span></td>
		<td<?php echo $personal_info->identification_number->CellAttributes() ?>>
<span id="el_personal_info_identification_number" class="control-group">
<span<?php echo $personal_info->identification_number->ViewAttributes() ?>>
<?php echo $personal_info->identification_number->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($personal_info->issuedate->Visible) { // issuedate ?>
	<tr id="r_issuedate">
		<td><span id="elh_personal_info_issuedate"><?php echo $personal_info->issuedate->FldCaption() ?></span></td>
		<td<?php echo $personal_info->issuedate->CellAttributes() ?>>
<span id="el_personal_info_issuedate" class="control-group">
<span<?php echo $personal_info->issuedate->ViewAttributes() ?>>
<?php echo $personal_info->issuedate->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($personal_info->expirydate->Visible) { // expirydate ?>
	<tr id="r_expirydate">
		<td><span id="elh_personal_info_expirydate"><?php echo $personal_info->expirydate->FldCaption() ?></span></td>
		<td<?php echo $personal_info->expirydate->CellAttributes() ?>>
<span id="el_personal_info_expirydate" class="control-group">
<span<?php echo $personal_info->expirydate->ViewAttributes() ?>>
<?php echo $personal_info->expirydate->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($personal_info->issuedplace->Visible) { // issuedplace ?>
	<tr id="r_issuedplace">
		<td><span id="elh_personal_info_issuedplace"><?php echo $personal_info->issuedplace->FldCaption() ?></span></td>
		<td<?php echo $personal_info->issuedplace->CellAttributes() ?>>
<span id="el_personal_info_issuedplace" class="control-group">
<span<?php echo $personal_info->issuedplace->ViewAttributes() ?>>
<?php echo $personal_info->issuedplace->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($personal_info->earning_type->Visible) { // earning_type ?>
	<tr id="r_earning_type">
		<td><span id="elh_personal_info_earning_type"><?php echo $personal_info->earning_type->FldCaption() ?></span></td>
		<td<?php echo $personal_info->earning_type->CellAttributes() ?>>
<span id="el_personal_info_earning_type" class="control-group">
<span<?php echo $personal_info->earning_type->ViewAttributes() ?>>
<?php echo $personal_info->earning_type->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($personal_info->earning_note->Visible) { // earning_note ?>
	<tr id="r_earning_note">
		<td><span id="elh_personal_info_earning_note"><?php echo $personal_info->earning_note->FldCaption() ?></span></td>
		<td<?php echo $personal_info->earning_note->CellAttributes() ?>>
<span id="el_personal_info_earning_note" class="control-group">
<span<?php echo $personal_info->earning_note->ViewAttributes() ?>>
<?php echo $personal_info->earning_note->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($personal_info->annual_income->Visible) { // annual_income ?>
	<tr id="r_annual_income">
		<td><span id="elh_personal_info_annual_income"><?php echo $personal_info->annual_income->FldCaption() ?></span></td>
		<td<?php echo $personal_info->annual_income->CellAttributes() ?>>
<span id="el_personal_info_annual_income" class="control-group">
<span<?php echo $personal_info->annual_income->ViewAttributes() ?>>
<?php echo $personal_info->annual_income->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($personal_info->nameofcompany->Visible) { // nameofcompany ?>
	<tr id="r_nameofcompany">
		<td><span id="elh_personal_info_nameofcompany"><?php echo $personal_info->nameofcompany->FldCaption() ?></span></td>
		<td<?php echo $personal_info->nameofcompany->CellAttributes() ?>>
<span id="el_personal_info_nameofcompany" class="control-group">
<span<?php echo $personal_info->nameofcompany->ViewAttributes() ?>>
<?php echo $personal_info->nameofcompany->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($personal_info->company_telephone->Visible) { // company_telephone ?>
	<tr id="r_company_telephone">
		<td><span id="elh_personal_info_company_telephone"><?php echo $personal_info->company_telephone->FldCaption() ?></span></td>
		<td<?php echo $personal_info->company_telephone->CellAttributes() ?>>
<span id="el_personal_info_company_telephone" class="control-group">
<span<?php echo $personal_info->company_telephone->ViewAttributes() ?>>
<?php echo $personal_info->company_telephone->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($personal_info->company_email->Visible) { // company_email ?>
	<tr id="r_company_email">
		<td><span id="elh_personal_info_company_email"><?php echo $personal_info->company_email->FldCaption() ?></span></td>
		<td<?php echo $personal_info->company_email->CellAttributes() ?>>
<span id="el_personal_info_company_email" class="control-group">
<span<?php echo $personal_info->company_email->ViewAttributes() ?>>
<?php echo $personal_info->company_email->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
</table>
</td></tr></table>
<?php if ($personal_info->Export == "") { ?>
<table class="ewPager">
<tr><td>
<?php if (!isset($personal_info_view->Pager)) $personal_info_view->Pager = new cNumericPager($personal_info_view->StartRec, $personal_info_view->DisplayRecs, $personal_info_view->TotalRecs, $personal_info_view->RecRange) ?>
<?php if ($personal_info_view->Pager->RecordCount > 0) { ?>
<table cellspacing="0" class="ewStdTable"><tbody><tr><td>
<div class="pagination"><ul>
	<?php if ($personal_info_view->Pager->FirstButton->Enabled) { ?>
	<li><a href="<?php echo $personal_info_view->PageUrl() ?>start=<?php echo $personal_info_view->Pager->FirstButton->Start ?>"><?php echo $Language->Phrase("PagerFirst") ?></a></li>
	<?php } ?>
	<?php if ($personal_info_view->Pager->PrevButton->Enabled) { ?>
	<li><a href="<?php echo $personal_info_view->PageUrl() ?>start=<?php echo $personal_info_view->Pager->PrevButton->Start ?>"><?php echo $Language->Phrase("PagerPrevious") ?></a></li>
	<?php } ?>
	<?php foreach ($personal_info_view->Pager->Items as $PagerItem) { ?>
		<li<?php if (!$PagerItem->Enabled) { echo " class=\" active\""; } ?>><a href="<?php if ($PagerItem->Enabled) { echo $personal_info_view->PageUrl() . "start=" . $PagerItem->Start; } else { echo "#"; } ?>"><?php echo $PagerItem->Text ?></a></li>
	<?php } ?>
	<?php if ($personal_info_view->Pager->NextButton->Enabled) { ?>
	<li><a href="<?php echo $personal_info_view->PageUrl() ?>start=<?php echo $personal_info_view->Pager->NextButton->Start ?>"><?php echo $Language->Phrase("PagerNext") ?></a></li>
	<?php } ?>
	<?php if ($personal_info_view->Pager->LastButton->Enabled) { ?>
	<li><a href="<?php echo $personal_info_view->PageUrl() ?>start=<?php echo $personal_info_view->Pager->LastButton->Start ?>"><?php echo $Language->Phrase("PagerLast") ?></a></li>
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
<?php if ($personal_info->getCurrentDetailTable() <> "") { ?>
<?php
	$FirstActiveDetailTable = "";
	$ActiveTableItemClass = "";
	$ActiveTableDivClass = "";
?>
<table class="ewStdTable"><tr><td>
<div class="tabbable" id="personal_info_view_details">
	<ul class="nav nav-tabs">
<?php
	if (in_array("spouse_tb", explode(",", $personal_info->getCurrentDetailTable())) && $spouse_tb->DetailView) {
		if ($FirstActiveDetailTable == "" || $FirstActiveDetailTable == "spouse_tb") {
			$FirstActiveDetailTable = "spouse_tb";
			$ActiveTableItemClass = " class=\"active\"";
		} else {
			$ActiveTableItemClass = "";
		}
?>
		<li<?php echo $ActiveTableItemClass ?>><a href="#tab_spouse_tb" data-toggle="tab"><?php echo $Language->TablePhrase("spouse_tb", "TblCaption") ?></a></li>
<?php
	}
?>
<?php
	if (in_array("divorce_tb", explode(",", $personal_info->getCurrentDetailTable())) && $divorce_tb->DetailView) {
		if ($FirstActiveDetailTable == "" || $FirstActiveDetailTable == "divorce_tb") {
			$FirstActiveDetailTable = "divorce_tb";
			$ActiveTableItemClass = " class=\"active\"";
		} else {
			$ActiveTableItemClass = "";
		}
?>
		<li<?php echo $ActiveTableItemClass ?>><a href="#tab_divorce_tb" data-toggle="tab"><?php echo $Language->TablePhrase("divorce_tb", "TblCaption") ?></a></li>
<?php
	}
?>
<?php
	if (in_array("children_details", explode(",", $personal_info->getCurrentDetailTable())) && $children_details->DetailView) {
		if ($FirstActiveDetailTable == "" || $FirstActiveDetailTable == "children_details") {
			$FirstActiveDetailTable = "children_details";
			$ActiveTableItemClass = " class=\"active\"";
		} else {
			$ActiveTableItemClass = "";
		}
?>
		<li<?php echo $ActiveTableItemClass ?>><a href="#tab_children_details" data-toggle="tab"><?php echo $Language->TablePhrase("children_details", "TblCaption") ?></a></li>
<?php
	}
?>
<?php
	if (in_array("beneficiary_dump", explode(",", $personal_info->getCurrentDetailTable())) && $beneficiary_dump->DetailView) {
		if ($FirstActiveDetailTable == "" || $FirstActiveDetailTable == "beneficiary_dump") {
			$FirstActiveDetailTable = "beneficiary_dump";
			$ActiveTableItemClass = " class=\"active\"";
		} else {
			$ActiveTableItemClass = "";
		}
?>
		<li<?php echo $ActiveTableItemClass ?>><a href="#tab_beneficiary_dump" data-toggle="tab"><?php echo $Language->TablePhrase("beneficiary_dump", "TblCaption") ?></a></li>
<?php
	}
?>
<?php
	if (in_array("alt_beneficiary", explode(",", $personal_info->getCurrentDetailTable())) && $alt_beneficiary->DetailView) {
		if ($FirstActiveDetailTable == "" || $FirstActiveDetailTable == "alt_beneficiary") {
			$FirstActiveDetailTable = "alt_beneficiary";
			$ActiveTableItemClass = " class=\"active\"";
		} else {
			$ActiveTableItemClass = "";
		}
?>
		<li<?php echo $ActiveTableItemClass ?>><a href="#tab_alt_beneficiary" data-toggle="tab"><?php echo $Language->TablePhrase("alt_beneficiary", "TblCaption") ?></a></li>
<?php
	}
?>
<?php
	if (in_array("assets_tb", explode(",", $personal_info->getCurrentDetailTable())) && $assets_tb->DetailView) {
		if ($FirstActiveDetailTable == "" || $FirstActiveDetailTable == "assets_tb") {
			$FirstActiveDetailTable = "assets_tb";
			$ActiveTableItemClass = " class=\"active\"";
		} else {
			$ActiveTableItemClass = "";
		}
?>
		<li<?php echo $ActiveTableItemClass ?>><a href="#tab_assets_tb" data-toggle="tab"><?php echo $Language->TablePhrase("assets_tb", "TblCaption") ?></a></li>
<?php
	}
?>
<?php
	if (in_array("overall_asset", explode(",", $personal_info->getCurrentDetailTable())) && $overall_asset->DetailView) {
		if ($FirstActiveDetailTable == "" || $FirstActiveDetailTable == "overall_asset") {
			$FirstActiveDetailTable = "overall_asset";
			$ActiveTableItemClass = " class=\"active\"";
		} else {
			$ActiveTableItemClass = "";
		}
?>
		<li<?php echo $ActiveTableItemClass ?>><a href="#tab_overall_asset" data-toggle="tab"><?php echo $Language->TablePhrase("overall_asset", "TblCaption") ?></a></li>
<?php
	}
?>
<?php
	if (in_array("executor_tb", explode(",", $personal_info->getCurrentDetailTable())) && $executor_tb->DetailView) {
		if ($FirstActiveDetailTable == "" || $FirstActiveDetailTable == "executor_tb") {
			$FirstActiveDetailTable = "executor_tb";
			$ActiveTableItemClass = " class=\"active\"";
		} else {
			$ActiveTableItemClass = "";
		}
?>
		<li<?php echo $ActiveTableItemClass ?>><a href="#tab_executor_tb" data-toggle="tab"><?php echo $Language->TablePhrase("executor_tb", "TblCaption") ?></a></li>
<?php
	}
?>
<?php
	if (in_array("trustee_tb", explode(",", $personal_info->getCurrentDetailTable())) && $trustee_tb->DetailView) {
		if ($FirstActiveDetailTable == "" || $FirstActiveDetailTable == "trustee_tb") {
			$FirstActiveDetailTable = "trustee_tb";
			$ActiveTableItemClass = " class=\"active\"";
		} else {
			$ActiveTableItemClass = "";
		}
?>
		<li<?php echo $ActiveTableItemClass ?>><a href="#tab_trustee_tb" data-toggle="tab"><?php echo $Language->TablePhrase("trustee_tb", "TblCaption") ?></a></li>
<?php
	}
?>
<?php
	if (in_array("witness_tb", explode(",", $personal_info->getCurrentDetailTable())) && $witness_tb->DetailView) {
		if ($FirstActiveDetailTable == "" || $FirstActiveDetailTable == "witness_tb") {
			$FirstActiveDetailTable = "witness_tb";
			$ActiveTableItemClass = " class=\"active\"";
		} else {
			$ActiveTableItemClass = "";
		}
?>
		<li<?php echo $ActiveTableItemClass ?>><a href="#tab_witness_tb" data-toggle="tab"><?php echo $Language->TablePhrase("witness_tb", "TblCaption") ?></a></li>
<?php
	}
?>
<?php
	if (in_array("addinfo_tb", explode(",", $personal_info->getCurrentDetailTable())) && $addinfo_tb->DetailView) {
		if ($FirstActiveDetailTable == "" || $FirstActiveDetailTable == "addinfo_tb") {
			$FirstActiveDetailTable = "addinfo_tb";
			$ActiveTableItemClass = " class=\"active\"";
		} else {
			$ActiveTableItemClass = "";
		}
?>
		<li<?php echo $ActiveTableItemClass ?>><a href="#tab_addinfo_tb" data-toggle="tab"><?php echo $Language->TablePhrase("addinfo_tb", "TblCaption") ?></a></li>
<?php
	}
?>
	</ul>
	<div class="tab-content">
<?php
	if (in_array("spouse_tb", explode(",", $personal_info->getCurrentDetailTable())) && $spouse_tb->DetailView) {
		if ($FirstActiveDetailTable == "" || $FirstActiveDetailTable == "spouse_tb") {
			$FirstActiveDetailTable = "spouse_tb";
			$ActiveTableDivClass = " active";
		} else {
			$ActiveTableDivClass = "";
		}
?>
		<div class="tab-pane<?php echo $ActiveTableDivClass ?>" id="tab_spouse_tb">
<?php include_once "spouse_tbgrid.php" ?>
		</div>
<?php } ?>
<?php
	if (in_array("divorce_tb", explode(",", $personal_info->getCurrentDetailTable())) && $divorce_tb->DetailView) {
		if ($FirstActiveDetailTable == "" || $FirstActiveDetailTable == "divorce_tb") {
			$FirstActiveDetailTable = "divorce_tb";
			$ActiveTableDivClass = " active";
		} else {
			$ActiveTableDivClass = "";
		}
?>
		<div class="tab-pane<?php echo $ActiveTableDivClass ?>" id="tab_divorce_tb">
<?php include_once "divorce_tbgrid.php" ?>
		</div>
<?php } ?>
<?php
	if (in_array("children_details", explode(",", $personal_info->getCurrentDetailTable())) && $children_details->DetailView) {
		if ($FirstActiveDetailTable == "" || $FirstActiveDetailTable == "children_details") {
			$FirstActiveDetailTable = "children_details";
			$ActiveTableDivClass = " active";
		} else {
			$ActiveTableDivClass = "";
		}
?>
		<div class="tab-pane<?php echo $ActiveTableDivClass ?>" id="tab_children_details">
<?php include_once "children_detailsgrid.php" ?>
		</div>
<?php } ?>
<?php
	if (in_array("beneficiary_dump", explode(",", $personal_info->getCurrentDetailTable())) && $beneficiary_dump->DetailView) {
		if ($FirstActiveDetailTable == "" || $FirstActiveDetailTable == "beneficiary_dump") {
			$FirstActiveDetailTable = "beneficiary_dump";
			$ActiveTableDivClass = " active";
		} else {
			$ActiveTableDivClass = "";
		}
?>
		<div class="tab-pane<?php echo $ActiveTableDivClass ?>" id="tab_beneficiary_dump">
<?php include_once "beneficiary_dumpgrid.php" ?>
		</div>
<?php } ?>
<?php
	if (in_array("alt_beneficiary", explode(",", $personal_info->getCurrentDetailTable())) && $alt_beneficiary->DetailView) {
		if ($FirstActiveDetailTable == "" || $FirstActiveDetailTable == "alt_beneficiary") {
			$FirstActiveDetailTable = "alt_beneficiary";
			$ActiveTableDivClass = " active";
		} else {
			$ActiveTableDivClass = "";
		}
?>
		<div class="tab-pane<?php echo $ActiveTableDivClass ?>" id="tab_alt_beneficiary">
<?php include_once "alt_beneficiarygrid.php" ?>
		</div>
<?php } ?>
<?php
	if (in_array("assets_tb", explode(",", $personal_info->getCurrentDetailTable())) && $assets_tb->DetailView) {
		if ($FirstActiveDetailTable == "" || $FirstActiveDetailTable == "assets_tb") {
			$FirstActiveDetailTable = "assets_tb";
			$ActiveTableDivClass = " active";
		} else {
			$ActiveTableDivClass = "";
		}
?>
		<div class="tab-pane<?php echo $ActiveTableDivClass ?>" id="tab_assets_tb">
<?php include_once "assets_tbgrid.php" ?>
		</div>
<?php } ?>
<?php
	if (in_array("overall_asset", explode(",", $personal_info->getCurrentDetailTable())) && $overall_asset->DetailView) {
		if ($FirstActiveDetailTable == "" || $FirstActiveDetailTable == "overall_asset") {
			$FirstActiveDetailTable = "overall_asset";
			$ActiveTableDivClass = " active";
		} else {
			$ActiveTableDivClass = "";
		}
?>
		<div class="tab-pane<?php echo $ActiveTableDivClass ?>" id="tab_overall_asset">
<?php include_once "overall_assetgrid.php" ?>
		</div>
<?php } ?>
<?php
	if (in_array("executor_tb", explode(",", $personal_info->getCurrentDetailTable())) && $executor_tb->DetailView) {
		if ($FirstActiveDetailTable == "" || $FirstActiveDetailTable == "executor_tb") {
			$FirstActiveDetailTable = "executor_tb";
			$ActiveTableDivClass = " active";
		} else {
			$ActiveTableDivClass = "";
		}
?>
		<div class="tab-pane<?php echo $ActiveTableDivClass ?>" id="tab_executor_tb">
<?php include_once "executor_tbgrid.php" ?>
		</div>
<?php } ?>
<?php
	if (in_array("trustee_tb", explode(",", $personal_info->getCurrentDetailTable())) && $trustee_tb->DetailView) {
		if ($FirstActiveDetailTable == "" || $FirstActiveDetailTable == "trustee_tb") {
			$FirstActiveDetailTable = "trustee_tb";
			$ActiveTableDivClass = " active";
		} else {
			$ActiveTableDivClass = "";
		}
?>
		<div class="tab-pane<?php echo $ActiveTableDivClass ?>" id="tab_trustee_tb">
<?php include_once "trustee_tbgrid.php" ?>
		</div>
<?php } ?>
<?php
	if (in_array("witness_tb", explode(",", $personal_info->getCurrentDetailTable())) && $witness_tb->DetailView) {
		if ($FirstActiveDetailTable == "" || $FirstActiveDetailTable == "witness_tb") {
			$FirstActiveDetailTable = "witness_tb";
			$ActiveTableDivClass = " active";
		} else {
			$ActiveTableDivClass = "";
		}
?>
		<div class="tab-pane<?php echo $ActiveTableDivClass ?>" id="tab_witness_tb">
<?php include_once "witness_tbgrid.php" ?>
		</div>
<?php } ?>
<?php
	if (in_array("addinfo_tb", explode(",", $personal_info->getCurrentDetailTable())) && $addinfo_tb->DetailView) {
		if ($FirstActiveDetailTable == "" || $FirstActiveDetailTable == "addinfo_tb") {
			$FirstActiveDetailTable = "addinfo_tb";
			$ActiveTableDivClass = " active";
		} else {
			$ActiveTableDivClass = "";
		}
?>
		<div class="tab-pane<?php echo $ActiveTableDivClass ?>" id="tab_addinfo_tb">
<?php include_once "addinfo_tbgrid.php" ?>
		</div>
<?php } ?>
	</div>
</div>
</td></tr></table>
<?php } ?>
</form>
<script type="text/javascript">
fpersonal_infoview.Init();
</script>
<?php
$personal_info_view->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<?php if ($personal_info->Export == "") { ?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php } ?>
<?php include_once "footer.php" ?>
<?php
$personal_info_view->Page_Terminate();
?>
