<?php
if (session_id() == "") session_start(); // Initialize Session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg10.php" ?>
<?php include_once "ewmysql10.php" ?>
<?php include_once "phpfn10.php" ?>
<?php include_once "assets_tbinfo.php" ?>
<?php include_once "adminusersinfo.php" ?>
<?php include_once "beneficiary_dumpinfo.php" ?>
<?php include_once "personal_infoinfo.php" ?>
<?php include_once "comprehensivewill_tbinfo.php" ?>
<?php include_once "premiumwill_tbinfo.php" ?>
<?php include_once "privatetrust_tbinfo.php" ?>
<?php include_once "overall_assetgridcls.php" ?>
<?php include_once "userfn10.php" ?>
<?php

//
// Page class
//

$assets_tb_view = NULL; // Initialize page object first

class cassets_tb_view extends cassets_tb {

	// Page ID
	var $PageID = 'view';

	// Project ID
	var $ProjectID = "{D9B361E7-B2C1-4293-B9B3-B581986A15CC}";

	// Table name
	var $TableName = 'assets_tb';

	// Page object name
	var $PageObjName = 'assets_tb_view';

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

		// Table object (assets_tb)
		if (!isset($GLOBALS["assets_tb"])) {
			$GLOBALS["assets_tb"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["assets_tb"];
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

		// Table object (beneficiary_dump)
		if (!isset($GLOBALS['beneficiary_dump'])) $GLOBALS['beneficiary_dump'] = new cbeneficiary_dump();

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
			define("EW_TABLE_NAME", 'assets_tb', TRUE);

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
						$this->Page_Terminate("assets_tblist.php"); // Return to list page
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
						$sReturnUrl = "assets_tblist.php"; // No matching record, return to list
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
			$sReturnUrl = "assets_tblist.php"; // Not page request, return to list
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

		// Detail table 'overall_asset'
		$body = $Language->TablePhrase("overall_asset", "TblCaption");
		$body = "<a class=\"ewAction ewDetailList\" href=\"" . ew_HtmlEncode("overall_assetlist.php?" . EW_TABLE_SHOW_MASTER . "=assets_tb&uid=" . strval($this->uid->CurrentValue) . "") . "\">" . $body . "</a>";
		$item = &$option->Add("detail_overall_asset");
		$item->Body = $body;
		$item->Visible = $Security->IsLoggedIn();
		if ($item->Visible) {
			if ($DetailTableLink <> "") $DetailTableLink .= ",";
			$DetailTableLink .= "overall_asset";
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
		$this->asset_type->setDbValue($rs->fields('asset_type'));
		$this->property_location->setDbValue($rs->fields('property_location'));
		$this->property_type->setDbValue($rs->fields('property_type'));
		$this->property_registered->setDbValue($rs->fields('property_registered'));
		$this->shares_company->setDbValue($rs->fields('shares_company'));
		$this->shares_volume->setDbValue($rs->fields('shares_volume'));
		$this->shares_percent->setDbValue($rs->fields('shares_percent'));
		$this->shares_cscs->setDbValue($rs->fields('shares_cscs'));
		$this->shares_chn->setDbValue($rs->fields('shares_chn'));
		$this->insurance_company->setDbValue($rs->fields('insurance_company'));
		$this->insurance_type->setDbValue($rs->fields('insurance_type'));
		$this->insurance_owner->setDbValue($rs->fields('insurance_owner'));
		$this->insurance_facevalue->setDbValue($rs->fields('insurance_facevalue'));
		$this->bvn->setDbValue($rs->fields('bvn'));
		$this->account_name->setDbValue($rs->fields('account_name'));
		$this->account_no->setDbValue($rs->fields('account_no'));
		$this->bankname->setDbValue($rs->fields('bankname'));
		$this->accounttype->setDbValue($rs->fields('accounttype'));
		$this->pension_name->setDbValue($rs->fields('pension_name'));
		$this->pension_owner->setDbValue($rs->fields('pension_owner'));
		$this->pension_plan->setDbValue($rs->fields('pension_plan'));
		$this->rsano->setDbValue($rs->fields('rsano'));
		$this->pension_admin->setDbValue($rs->fields('pension_admin'));
		$this->datecreated->setDbValue($rs->fields('datecreated'));
	}

	// Load DbValue from recordset
	function LoadDbValues(&$rs) {
		if (!$rs || !is_array($rs) && $rs->EOF) return;
		$row = is_array($rs) ? $rs : $rs->fields;
		$this->id->DbValue = $row['id'];
		$this->uid->DbValue = $row['uid'];
		$this->asset_type->DbValue = $row['asset_type'];
		$this->property_location->DbValue = $row['property_location'];
		$this->property_type->DbValue = $row['property_type'];
		$this->property_registered->DbValue = $row['property_registered'];
		$this->shares_company->DbValue = $row['shares_company'];
		$this->shares_volume->DbValue = $row['shares_volume'];
		$this->shares_percent->DbValue = $row['shares_percent'];
		$this->shares_cscs->DbValue = $row['shares_cscs'];
		$this->shares_chn->DbValue = $row['shares_chn'];
		$this->insurance_company->DbValue = $row['insurance_company'];
		$this->insurance_type->DbValue = $row['insurance_type'];
		$this->insurance_owner->DbValue = $row['insurance_owner'];
		$this->insurance_facevalue->DbValue = $row['insurance_facevalue'];
		$this->bvn->DbValue = $row['bvn'];
		$this->account_name->DbValue = $row['account_name'];
		$this->account_no->DbValue = $row['account_no'];
		$this->bankname->DbValue = $row['bankname'];
		$this->accounttype->DbValue = $row['accounttype'];
		$this->pension_name->DbValue = $row['pension_name'];
		$this->pension_owner->DbValue = $row['pension_owner'];
		$this->pension_plan->DbValue = $row['pension_plan'];
		$this->rsano->DbValue = $row['rsano'];
		$this->pension_admin->DbValue = $row['pension_admin'];
		$this->datecreated->DbValue = $row['datecreated'];
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
		// asset_type
		// property_location
		// property_type
		// property_registered
		// shares_company
		// shares_volume
		// shares_percent
		// shares_cscs
		// shares_chn
		// insurance_company
		// insurance_type
		// insurance_owner
		// insurance_facevalue
		// bvn
		// account_name
		// account_no
		// bankname
		// accounttype
		// pension_name
		// pension_owner
		// pension_plan
		// rsano
		// pension_admin
		// datecreated

		if ($this->RowType == EW_ROWTYPE_VIEW) { // View row

			// id
			$this->id->ViewValue = $this->id->CurrentValue;
			$this->id->ViewCustomAttributes = "";

			// uid
			$this->uid->ViewValue = $this->uid->CurrentValue;
			$this->uid->ViewCustomAttributes = "";

			// asset_type
			$this->asset_type->ViewValue = $this->asset_type->CurrentValue;
			$this->asset_type->ViewCustomAttributes = "";

			// property_location
			$this->property_location->ViewValue = $this->property_location->CurrentValue;
			$this->property_location->ViewCustomAttributes = "";

			// property_type
			$this->property_type->ViewValue = $this->property_type->CurrentValue;
			$this->property_type->ViewCustomAttributes = "";

			// property_registered
			$this->property_registered->ViewValue = $this->property_registered->CurrentValue;
			$this->property_registered->ViewCustomAttributes = "";

			// shares_company
			$this->shares_company->ViewValue = $this->shares_company->CurrentValue;
			$this->shares_company->ViewCustomAttributes = "";

			// shares_volume
			$this->shares_volume->ViewValue = $this->shares_volume->CurrentValue;
			$this->shares_volume->ViewCustomAttributes = "";

			// shares_percent
			$this->shares_percent->ViewValue = $this->shares_percent->CurrentValue;
			$this->shares_percent->ViewCustomAttributes = "";

			// shares_cscs
			$this->shares_cscs->ViewValue = $this->shares_cscs->CurrentValue;
			$this->shares_cscs->ViewCustomAttributes = "";

			// shares_chn
			$this->shares_chn->ViewValue = $this->shares_chn->CurrentValue;
			$this->shares_chn->ViewCustomAttributes = "";

			// insurance_company
			$this->insurance_company->ViewValue = $this->insurance_company->CurrentValue;
			$this->insurance_company->ViewCustomAttributes = "";

			// insurance_type
			$this->insurance_type->ViewValue = $this->insurance_type->CurrentValue;
			$this->insurance_type->ViewCustomAttributes = "";

			// insurance_owner
			$this->insurance_owner->ViewValue = $this->insurance_owner->CurrentValue;
			$this->insurance_owner->ViewCustomAttributes = "";

			// insurance_facevalue
			$this->insurance_facevalue->ViewValue = $this->insurance_facevalue->CurrentValue;
			$this->insurance_facevalue->ViewCustomAttributes = "";

			// bvn
			$this->bvn->ViewValue = $this->bvn->CurrentValue;
			$this->bvn->ViewCustomAttributes = "";

			// account_name
			$this->account_name->ViewValue = $this->account_name->CurrentValue;
			$this->account_name->ViewCustomAttributes = "";

			// account_no
			$this->account_no->ViewValue = $this->account_no->CurrentValue;
			$this->account_no->ViewCustomAttributes = "";

			// bankname
			$this->bankname->ViewValue = $this->bankname->CurrentValue;
			$this->bankname->ViewCustomAttributes = "";

			// accounttype
			$this->accounttype->ViewValue = $this->accounttype->CurrentValue;
			$this->accounttype->ViewCustomAttributes = "";

			// pension_name
			$this->pension_name->ViewValue = $this->pension_name->CurrentValue;
			$this->pension_name->ViewCustomAttributes = "";

			// pension_owner
			$this->pension_owner->ViewValue = $this->pension_owner->CurrentValue;
			$this->pension_owner->ViewCustomAttributes = "";

			// pension_plan
			$this->pension_plan->ViewValue = $this->pension_plan->CurrentValue;
			$this->pension_plan->ViewCustomAttributes = "";

			// rsano
			$this->rsano->ViewValue = $this->rsano->CurrentValue;
			$this->rsano->ViewCustomAttributes = "";

			// pension_admin
			$this->pension_admin->ViewValue = $this->pension_admin->CurrentValue;
			$this->pension_admin->ViewCustomAttributes = "";

			// datecreated
			$this->datecreated->ViewValue = $this->datecreated->CurrentValue;
			$this->datecreated->ViewCustomAttributes = "";

			// id
			$this->id->LinkCustomAttributes = "";
			$this->id->HrefValue = "";
			$this->id->TooltipValue = "";

			// uid
			$this->uid->LinkCustomAttributes = "";
			$this->uid->HrefValue = "";
			$this->uid->TooltipValue = "";

			// asset_type
			$this->asset_type->LinkCustomAttributes = "";
			$this->asset_type->HrefValue = "";
			$this->asset_type->TooltipValue = "";

			// property_location
			$this->property_location->LinkCustomAttributes = "";
			$this->property_location->HrefValue = "";
			$this->property_location->TooltipValue = "";

			// property_type
			$this->property_type->LinkCustomAttributes = "";
			$this->property_type->HrefValue = "";
			$this->property_type->TooltipValue = "";

			// property_registered
			$this->property_registered->LinkCustomAttributes = "";
			$this->property_registered->HrefValue = "";
			$this->property_registered->TooltipValue = "";

			// shares_company
			$this->shares_company->LinkCustomAttributes = "";
			$this->shares_company->HrefValue = "";
			$this->shares_company->TooltipValue = "";

			// shares_volume
			$this->shares_volume->LinkCustomAttributes = "";
			$this->shares_volume->HrefValue = "";
			$this->shares_volume->TooltipValue = "";

			// shares_percent
			$this->shares_percent->LinkCustomAttributes = "";
			$this->shares_percent->HrefValue = "";
			$this->shares_percent->TooltipValue = "";

			// shares_cscs
			$this->shares_cscs->LinkCustomAttributes = "";
			$this->shares_cscs->HrefValue = "";
			$this->shares_cscs->TooltipValue = "";

			// shares_chn
			$this->shares_chn->LinkCustomAttributes = "";
			$this->shares_chn->HrefValue = "";
			$this->shares_chn->TooltipValue = "";

			// insurance_company
			$this->insurance_company->LinkCustomAttributes = "";
			$this->insurance_company->HrefValue = "";
			$this->insurance_company->TooltipValue = "";

			// insurance_type
			$this->insurance_type->LinkCustomAttributes = "";
			$this->insurance_type->HrefValue = "";
			$this->insurance_type->TooltipValue = "";

			// insurance_owner
			$this->insurance_owner->LinkCustomAttributes = "";
			$this->insurance_owner->HrefValue = "";
			$this->insurance_owner->TooltipValue = "";

			// insurance_facevalue
			$this->insurance_facevalue->LinkCustomAttributes = "";
			$this->insurance_facevalue->HrefValue = "";
			$this->insurance_facevalue->TooltipValue = "";

			// bvn
			$this->bvn->LinkCustomAttributes = "";
			$this->bvn->HrefValue = "";
			$this->bvn->TooltipValue = "";

			// account_name
			$this->account_name->LinkCustomAttributes = "";
			$this->account_name->HrefValue = "";
			$this->account_name->TooltipValue = "";

			// account_no
			$this->account_no->LinkCustomAttributes = "";
			$this->account_no->HrefValue = "";
			$this->account_no->TooltipValue = "";

			// bankname
			$this->bankname->LinkCustomAttributes = "";
			$this->bankname->HrefValue = "";
			$this->bankname->TooltipValue = "";

			// accounttype
			$this->accounttype->LinkCustomAttributes = "";
			$this->accounttype->HrefValue = "";
			$this->accounttype->TooltipValue = "";

			// pension_name
			$this->pension_name->LinkCustomAttributes = "";
			$this->pension_name->HrefValue = "";
			$this->pension_name->TooltipValue = "";

			// pension_owner
			$this->pension_owner->LinkCustomAttributes = "";
			$this->pension_owner->HrefValue = "";
			$this->pension_owner->TooltipValue = "";

			// pension_plan
			$this->pension_plan->LinkCustomAttributes = "";
			$this->pension_plan->HrefValue = "";
			$this->pension_plan->TooltipValue = "";

			// rsano
			$this->rsano->LinkCustomAttributes = "";
			$this->rsano->HrefValue = "";
			$this->rsano->TooltipValue = "";

			// pension_admin
			$this->pension_admin->LinkCustomAttributes = "";
			$this->pension_admin->HrefValue = "";
			$this->pension_admin->TooltipValue = "";

			// datecreated
			$this->datecreated->LinkCustomAttributes = "";
			$this->datecreated->HrefValue = "";
			$this->datecreated->TooltipValue = "";
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
		$item->Body = "<a id=\"emf_assets_tb\" href=\"javascript:void(0);\" class=\"ewExportLink ewEmail\" data-caption=\"" . $Language->Phrase("ExportToEmailText") . "\" onclick=\"ew_EmailDialogShow({lnk:'emf_assets_tb',hdr:ewLanguage.Phrase('ExportToEmail'),f:document.fassets_tbview,key:" . ew_ArrayToJsonAttr($this->RecKey) . ",sel:false});\">" . $Language->Phrase("ExportToEmail") . "</a>";
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
		}
	}

	// Set up Breadcrumb
	function SetupBreadcrumb() {
		global $Breadcrumb, $Language;
		$Breadcrumb = new cBreadcrumb();
		$PageCaption = $this->TableCaption();
		$Breadcrumb->Add("list", "<span id=\"ewPageCaption\">" . $PageCaption . "</span>", "assets_tblist.php", $this->TableVar);
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
if (!isset($assets_tb_view)) $assets_tb_view = new cassets_tb_view();

// Page init
$assets_tb_view->Page_Init();

// Page main
$assets_tb_view->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$assets_tb_view->Page_Render();
?>
<?php include_once "header.php" ?>
<?php if ($assets_tb->Export == "") { ?>
<script type="text/javascript">

// Page object
var assets_tb_view = new ew_Page("assets_tb_view");
assets_tb_view.PageID = "view"; // Page ID
var EW_PAGE_ID = assets_tb_view.PageID; // For backward compatibility

// Form object
var fassets_tbview = new ew_Form("fassets_tbview");

// Form_CustomValidate event
fassets_tbview.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
fassets_tbview.ValidateRequired = true;
<?php } else { ?>
fassets_tbview.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
// Form object for search

</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<?php } ?>
<?php if ($assets_tb->Export == "") { ?>
<?php $Breadcrumb->Render(); ?>
<?php } ?>
<?php if ($assets_tb->Export == "") { ?>
<div class="ewViewExportOptions">
<?php $assets_tb_view->ExportOptions->Render("body") ?>
<?php if (!$assets_tb_view->ExportOptions->UseDropDownButton) { ?>
</div>
<div class="ewViewOtherOptions">
<?php } ?>
<?php
	foreach ($assets_tb_view->OtherOptions as &$option)
		$option->Render("body");
?>
</div>
<?php } ?>
<?php $assets_tb_view->ShowPageHeader(); ?>
<?php
$assets_tb_view->ShowMessage();
?>
<form name="fassets_tbview" id="fassets_tbview" class="ewForm form-horizontal" action="<?php echo ew_CurrentPage() ?>" method="post">
<input type="hidden" name="t" value="assets_tb">
<table cellspacing="0" class="ewGrid"><tr><td>
<table id="tbl_assets_tbview" class="table table-bordered table-striped">
<?php if ($assets_tb->id->Visible) { // id ?>
	<tr id="r_id">
		<td><span id="elh_assets_tb_id"><?php echo $assets_tb->id->FldCaption() ?></span></td>
		<td<?php echo $assets_tb->id->CellAttributes() ?>>
<span id="el_assets_tb_id" class="control-group">
<span<?php echo $assets_tb->id->ViewAttributes() ?>>
<?php echo $assets_tb->id->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($assets_tb->uid->Visible) { // uid ?>
	<tr id="r_uid">
		<td><span id="elh_assets_tb_uid"><?php echo $assets_tb->uid->FldCaption() ?></span></td>
		<td<?php echo $assets_tb->uid->CellAttributes() ?>>
<span id="el_assets_tb_uid" class="control-group">
<span<?php echo $assets_tb->uid->ViewAttributes() ?>>
<?php echo $assets_tb->uid->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($assets_tb->asset_type->Visible) { // asset_type ?>
	<tr id="r_asset_type">
		<td><span id="elh_assets_tb_asset_type"><?php echo $assets_tb->asset_type->FldCaption() ?></span></td>
		<td<?php echo $assets_tb->asset_type->CellAttributes() ?>>
<span id="el_assets_tb_asset_type" class="control-group">
<span<?php echo $assets_tb->asset_type->ViewAttributes() ?>>
<?php echo $assets_tb->asset_type->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($assets_tb->property_location->Visible) { // property_location ?>
	<tr id="r_property_location">
		<td><span id="elh_assets_tb_property_location"><?php echo $assets_tb->property_location->FldCaption() ?></span></td>
		<td<?php echo $assets_tb->property_location->CellAttributes() ?>>
<span id="el_assets_tb_property_location" class="control-group">
<span<?php echo $assets_tb->property_location->ViewAttributes() ?>>
<?php echo $assets_tb->property_location->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($assets_tb->property_type->Visible) { // property_type ?>
	<tr id="r_property_type">
		<td><span id="elh_assets_tb_property_type"><?php echo $assets_tb->property_type->FldCaption() ?></span></td>
		<td<?php echo $assets_tb->property_type->CellAttributes() ?>>
<span id="el_assets_tb_property_type" class="control-group">
<span<?php echo $assets_tb->property_type->ViewAttributes() ?>>
<?php echo $assets_tb->property_type->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($assets_tb->property_registered->Visible) { // property_registered ?>
	<tr id="r_property_registered">
		<td><span id="elh_assets_tb_property_registered"><?php echo $assets_tb->property_registered->FldCaption() ?></span></td>
		<td<?php echo $assets_tb->property_registered->CellAttributes() ?>>
<span id="el_assets_tb_property_registered" class="control-group">
<span<?php echo $assets_tb->property_registered->ViewAttributes() ?>>
<?php echo $assets_tb->property_registered->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($assets_tb->shares_company->Visible) { // shares_company ?>
	<tr id="r_shares_company">
		<td><span id="elh_assets_tb_shares_company"><?php echo $assets_tb->shares_company->FldCaption() ?></span></td>
		<td<?php echo $assets_tb->shares_company->CellAttributes() ?>>
<span id="el_assets_tb_shares_company" class="control-group">
<span<?php echo $assets_tb->shares_company->ViewAttributes() ?>>
<?php echo $assets_tb->shares_company->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($assets_tb->shares_volume->Visible) { // shares_volume ?>
	<tr id="r_shares_volume">
		<td><span id="elh_assets_tb_shares_volume"><?php echo $assets_tb->shares_volume->FldCaption() ?></span></td>
		<td<?php echo $assets_tb->shares_volume->CellAttributes() ?>>
<span id="el_assets_tb_shares_volume" class="control-group">
<span<?php echo $assets_tb->shares_volume->ViewAttributes() ?>>
<?php echo $assets_tb->shares_volume->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($assets_tb->shares_percent->Visible) { // shares_percent ?>
	<tr id="r_shares_percent">
		<td><span id="elh_assets_tb_shares_percent"><?php echo $assets_tb->shares_percent->FldCaption() ?></span></td>
		<td<?php echo $assets_tb->shares_percent->CellAttributes() ?>>
<span id="el_assets_tb_shares_percent" class="control-group">
<span<?php echo $assets_tb->shares_percent->ViewAttributes() ?>>
<?php echo $assets_tb->shares_percent->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($assets_tb->shares_cscs->Visible) { // shares_cscs ?>
	<tr id="r_shares_cscs">
		<td><span id="elh_assets_tb_shares_cscs"><?php echo $assets_tb->shares_cscs->FldCaption() ?></span></td>
		<td<?php echo $assets_tb->shares_cscs->CellAttributes() ?>>
<span id="el_assets_tb_shares_cscs" class="control-group">
<span<?php echo $assets_tb->shares_cscs->ViewAttributes() ?>>
<?php echo $assets_tb->shares_cscs->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($assets_tb->shares_chn->Visible) { // shares_chn ?>
	<tr id="r_shares_chn">
		<td><span id="elh_assets_tb_shares_chn"><?php echo $assets_tb->shares_chn->FldCaption() ?></span></td>
		<td<?php echo $assets_tb->shares_chn->CellAttributes() ?>>
<span id="el_assets_tb_shares_chn" class="control-group">
<span<?php echo $assets_tb->shares_chn->ViewAttributes() ?>>
<?php echo $assets_tb->shares_chn->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($assets_tb->insurance_company->Visible) { // insurance_company ?>
	<tr id="r_insurance_company">
		<td><span id="elh_assets_tb_insurance_company"><?php echo $assets_tb->insurance_company->FldCaption() ?></span></td>
		<td<?php echo $assets_tb->insurance_company->CellAttributes() ?>>
<span id="el_assets_tb_insurance_company" class="control-group">
<span<?php echo $assets_tb->insurance_company->ViewAttributes() ?>>
<?php echo $assets_tb->insurance_company->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($assets_tb->insurance_type->Visible) { // insurance_type ?>
	<tr id="r_insurance_type">
		<td><span id="elh_assets_tb_insurance_type"><?php echo $assets_tb->insurance_type->FldCaption() ?></span></td>
		<td<?php echo $assets_tb->insurance_type->CellAttributes() ?>>
<span id="el_assets_tb_insurance_type" class="control-group">
<span<?php echo $assets_tb->insurance_type->ViewAttributes() ?>>
<?php echo $assets_tb->insurance_type->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($assets_tb->insurance_owner->Visible) { // insurance_owner ?>
	<tr id="r_insurance_owner">
		<td><span id="elh_assets_tb_insurance_owner"><?php echo $assets_tb->insurance_owner->FldCaption() ?></span></td>
		<td<?php echo $assets_tb->insurance_owner->CellAttributes() ?>>
<span id="el_assets_tb_insurance_owner" class="control-group">
<span<?php echo $assets_tb->insurance_owner->ViewAttributes() ?>>
<?php echo $assets_tb->insurance_owner->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($assets_tb->insurance_facevalue->Visible) { // insurance_facevalue ?>
	<tr id="r_insurance_facevalue">
		<td><span id="elh_assets_tb_insurance_facevalue"><?php echo $assets_tb->insurance_facevalue->FldCaption() ?></span></td>
		<td<?php echo $assets_tb->insurance_facevalue->CellAttributes() ?>>
<span id="el_assets_tb_insurance_facevalue" class="control-group">
<span<?php echo $assets_tb->insurance_facevalue->ViewAttributes() ?>>
<?php echo $assets_tb->insurance_facevalue->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($assets_tb->bvn->Visible) { // bvn ?>
	<tr id="r_bvn">
		<td><span id="elh_assets_tb_bvn"><?php echo $assets_tb->bvn->FldCaption() ?></span></td>
		<td<?php echo $assets_tb->bvn->CellAttributes() ?>>
<span id="el_assets_tb_bvn" class="control-group">
<span<?php echo $assets_tb->bvn->ViewAttributes() ?>>
<?php echo $assets_tb->bvn->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($assets_tb->account_name->Visible) { // account_name ?>
	<tr id="r_account_name">
		<td><span id="elh_assets_tb_account_name"><?php echo $assets_tb->account_name->FldCaption() ?></span></td>
		<td<?php echo $assets_tb->account_name->CellAttributes() ?>>
<span id="el_assets_tb_account_name" class="control-group">
<span<?php echo $assets_tb->account_name->ViewAttributes() ?>>
<?php echo $assets_tb->account_name->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($assets_tb->account_no->Visible) { // account_no ?>
	<tr id="r_account_no">
		<td><span id="elh_assets_tb_account_no"><?php echo $assets_tb->account_no->FldCaption() ?></span></td>
		<td<?php echo $assets_tb->account_no->CellAttributes() ?>>
<span id="el_assets_tb_account_no" class="control-group">
<span<?php echo $assets_tb->account_no->ViewAttributes() ?>>
<?php echo $assets_tb->account_no->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($assets_tb->bankname->Visible) { // bankname ?>
	<tr id="r_bankname">
		<td><span id="elh_assets_tb_bankname"><?php echo $assets_tb->bankname->FldCaption() ?></span></td>
		<td<?php echo $assets_tb->bankname->CellAttributes() ?>>
<span id="el_assets_tb_bankname" class="control-group">
<span<?php echo $assets_tb->bankname->ViewAttributes() ?>>
<?php echo $assets_tb->bankname->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($assets_tb->accounttype->Visible) { // accounttype ?>
	<tr id="r_accounttype">
		<td><span id="elh_assets_tb_accounttype"><?php echo $assets_tb->accounttype->FldCaption() ?></span></td>
		<td<?php echo $assets_tb->accounttype->CellAttributes() ?>>
<span id="el_assets_tb_accounttype" class="control-group">
<span<?php echo $assets_tb->accounttype->ViewAttributes() ?>>
<?php echo $assets_tb->accounttype->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($assets_tb->pension_name->Visible) { // pension_name ?>
	<tr id="r_pension_name">
		<td><span id="elh_assets_tb_pension_name"><?php echo $assets_tb->pension_name->FldCaption() ?></span></td>
		<td<?php echo $assets_tb->pension_name->CellAttributes() ?>>
<span id="el_assets_tb_pension_name" class="control-group">
<span<?php echo $assets_tb->pension_name->ViewAttributes() ?>>
<?php echo $assets_tb->pension_name->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($assets_tb->pension_owner->Visible) { // pension_owner ?>
	<tr id="r_pension_owner">
		<td><span id="elh_assets_tb_pension_owner"><?php echo $assets_tb->pension_owner->FldCaption() ?></span></td>
		<td<?php echo $assets_tb->pension_owner->CellAttributes() ?>>
<span id="el_assets_tb_pension_owner" class="control-group">
<span<?php echo $assets_tb->pension_owner->ViewAttributes() ?>>
<?php echo $assets_tb->pension_owner->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($assets_tb->pension_plan->Visible) { // pension_plan ?>
	<tr id="r_pension_plan">
		<td><span id="elh_assets_tb_pension_plan"><?php echo $assets_tb->pension_plan->FldCaption() ?></span></td>
		<td<?php echo $assets_tb->pension_plan->CellAttributes() ?>>
<span id="el_assets_tb_pension_plan" class="control-group">
<span<?php echo $assets_tb->pension_plan->ViewAttributes() ?>>
<?php echo $assets_tb->pension_plan->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($assets_tb->rsano->Visible) { // rsano ?>
	<tr id="r_rsano">
		<td><span id="elh_assets_tb_rsano"><?php echo $assets_tb->rsano->FldCaption() ?></span></td>
		<td<?php echo $assets_tb->rsano->CellAttributes() ?>>
<span id="el_assets_tb_rsano" class="control-group">
<span<?php echo $assets_tb->rsano->ViewAttributes() ?>>
<?php echo $assets_tb->rsano->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($assets_tb->pension_admin->Visible) { // pension_admin ?>
	<tr id="r_pension_admin">
		<td><span id="elh_assets_tb_pension_admin"><?php echo $assets_tb->pension_admin->FldCaption() ?></span></td>
		<td<?php echo $assets_tb->pension_admin->CellAttributes() ?>>
<span id="el_assets_tb_pension_admin" class="control-group">
<span<?php echo $assets_tb->pension_admin->ViewAttributes() ?>>
<?php echo $assets_tb->pension_admin->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($assets_tb->datecreated->Visible) { // datecreated ?>
	<tr id="r_datecreated">
		<td><span id="elh_assets_tb_datecreated"><?php echo $assets_tb->datecreated->FldCaption() ?></span></td>
		<td<?php echo $assets_tb->datecreated->CellAttributes() ?>>
<span id="el_assets_tb_datecreated" class="control-group">
<span<?php echo $assets_tb->datecreated->ViewAttributes() ?>>
<?php echo $assets_tb->datecreated->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
</table>
</td></tr></table>
<?php if ($assets_tb->Export == "") { ?>
<table class="ewPager">
<tr><td>
<?php if (!isset($assets_tb_view->Pager)) $assets_tb_view->Pager = new cNumericPager($assets_tb_view->StartRec, $assets_tb_view->DisplayRecs, $assets_tb_view->TotalRecs, $assets_tb_view->RecRange) ?>
<?php if ($assets_tb_view->Pager->RecordCount > 0) { ?>
<table cellspacing="0" class="ewStdTable"><tbody><tr><td>
<div class="pagination"><ul>
	<?php if ($assets_tb_view->Pager->FirstButton->Enabled) { ?>
	<li><a href="<?php echo $assets_tb_view->PageUrl() ?>start=<?php echo $assets_tb_view->Pager->FirstButton->Start ?>"><?php echo $Language->Phrase("PagerFirst") ?></a></li>
	<?php } ?>
	<?php if ($assets_tb_view->Pager->PrevButton->Enabled) { ?>
	<li><a href="<?php echo $assets_tb_view->PageUrl() ?>start=<?php echo $assets_tb_view->Pager->PrevButton->Start ?>"><?php echo $Language->Phrase("PagerPrevious") ?></a></li>
	<?php } ?>
	<?php foreach ($assets_tb_view->Pager->Items as $PagerItem) { ?>
		<li<?php if (!$PagerItem->Enabled) { echo " class=\" active\""; } ?>><a href="<?php if ($PagerItem->Enabled) { echo $assets_tb_view->PageUrl() . "start=" . $PagerItem->Start; } else { echo "#"; } ?>"><?php echo $PagerItem->Text ?></a></li>
	<?php } ?>
	<?php if ($assets_tb_view->Pager->NextButton->Enabled) { ?>
	<li><a href="<?php echo $assets_tb_view->PageUrl() ?>start=<?php echo $assets_tb_view->Pager->NextButton->Start ?>"><?php echo $Language->Phrase("PagerNext") ?></a></li>
	<?php } ?>
	<?php if ($assets_tb_view->Pager->LastButton->Enabled) { ?>
	<li><a href="<?php echo $assets_tb_view->PageUrl() ?>start=<?php echo $assets_tb_view->Pager->LastButton->Start ?>"><?php echo $Language->Phrase("PagerLast") ?></a></li>
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
	if (in_array("overall_asset", explode(",", $assets_tb->getCurrentDetailTable())) && $overall_asset->DetailView) {
?>
<?php include_once "overall_assetgrid.php" ?>
<?php } ?>
</form>
<script type="text/javascript">
fassets_tbview.Init();
</script>
<?php
$assets_tb_view->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<?php if ($assets_tb->Export == "") { ?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php } ?>
<?php include_once "footer.php" ?>
<?php
$assets_tb_view->Page_Terminate();
?>
