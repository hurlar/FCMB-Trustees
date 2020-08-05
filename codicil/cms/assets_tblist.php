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

$assets_tb_list = NULL; // Initialize page object first

class cassets_tb_list extends cassets_tb {

	// Page ID
	var $PageID = 'list';

	// Project ID
	var $ProjectID = "{D9B361E7-B2C1-4293-B9B3-B581986A15CC}";

	// Table name
	var $TableName = 'assets_tb';

	// Page object name
	var $PageObjName = 'assets_tb_list';

	// Grid form hidden field names
	var $FormName = 'fassets_tblist';
	var $FormActionName = 'k_action';
	var $FormKeyName = 'k_key';
	var $FormOldKeyName = 'k_oldkey';
	var $FormBlankRowName = 'k_blankrow';
	var $FormKeyCountName = 'key_count';

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

		// Initialize URLs
		$this->ExportPrintUrl = $this->PageUrl() . "export=print";
		$this->ExportExcelUrl = $this->PageUrl() . "export=excel";
		$this->ExportWordUrl = $this->PageUrl() . "export=word";
		$this->ExportHtmlUrl = $this->PageUrl() . "export=html";
		$this->ExportXmlUrl = $this->PageUrl() . "export=xml";
		$this->ExportCsvUrl = $this->PageUrl() . "export=csv";
		$this->ExportPdfUrl = $this->PageUrl() . "export=pdf";
		$this->AddUrl = "assets_tbadd.php?" . EW_TABLE_SHOW_DETAIL . "=";
		$this->InlineAddUrl = $this->PageUrl() . "a=add";
		$this->GridAddUrl = $this->PageUrl() . "a=gridadd";
		$this->GridEditUrl = $this->PageUrl() . "a=gridedit";
		$this->MultiDeleteUrl = "assets_tbdelete.php";
		$this->MultiUpdateUrl = "assets_tbupdate.php";

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
			define("EW_PAGE_ID", 'list', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'assets_tb', TRUE);

		// Start timer
		if (!isset($GLOBALS["gTimer"])) $GLOBALS["gTimer"] = new cTimer();

		// Open connection
		if (!isset($conn)) $conn = ew_Connect();

		// List options
		$this->ListOptions = new cListOptions();
		$this->ListOptions->TableVar = $this->TableVar;

		// Export options
		$this->ExportOptions = new cListOptions();
		$this->ExportOptions->Tag = "span";
		$this->ExportOptions->TagClassName = "ewExportOption";

		// Other options
		$this->OtherOptions['addedit'] = new cListOptions();
		$this->OtherOptions['addedit']->Tag = "span";
		$this->OtherOptions['addedit']->TagClassName = "ewAddEditOption";
		$this->OtherOptions['detail'] = new cListOptions();
		$this->OtherOptions['detail']->Tag = "span";
		$this->OtherOptions['detail']->TagClassName = "ewDetailOption";
		$this->OtherOptions['action'] = new cListOptions();
		$this->OtherOptions['action']->Tag = "span";
		$this->OtherOptions['action']->TagClassName = "ewActionOption";
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
		$this->CurrentAction = (@$_GET["a"] <> "") ? $_GET["a"] : @$_POST["a_list"]; // Set up curent action

		// Get grid add count
		$gridaddcnt = @$_GET[EW_TABLE_GRID_ADD_ROW_COUNT];
		if (is_numeric($gridaddcnt) && $gridaddcnt > 0)
			$this->GridAddRowCount = $gridaddcnt;

		// Set up list options
		$this->SetupListOptions();

		// Setup export options
		$this->SetupExportOptions();
		$this->id->Visible = !$this->IsAdd() && !$this->IsCopy() && !$this->IsGridAdd();

		// Global Page Loading event (in userfn*.php)
		Page_Loading();

		// Page Load event
		$this->Page_Load();

		// Setup other options
		$this->SetupOtherOptions();

		// Set "checkbox" visible
		if (count($this->CustomActions) > 0)
			$this->ListOptions->Items["checkbox"]->Visible = TRUE;

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

	// Class variables
	var $ListOptions; // List options
	var $ExportOptions; // Export options
	var $OtherOptions = array(); // Other options
	var $DisplayRecs = 25;
	var $StartRec;
	var $StopRec;
	var $TotalRecs = 0;
	var $RecRange = 10;
	var $Pager;
	var $SearchWhere = ""; // Search WHERE clause
	var $RecCnt = 0; // Record count
	var $EditRowCnt;
	var $StartRowCnt = 1;
	var $RowCnt = 0;
	var $Attrs = array(); // Row attributes and cell attributes
	var $RowIndex = 0; // Row index
	var $KeyCount = 0; // Key count
	var $RowAction = ""; // Row action
	var $RowOldKey = ""; // Row old key (for copy)
	var $RecPerRow = 0;
	var $ColCnt = 0;
	var $DbMasterFilter = ""; // Master filter
	var $DbDetailFilter = ""; // Detail filter
	var $MasterRecordExists;	
	var $MultiSelectKey;
	var $Command;
	var $RestoreSearch = FALSE;
	var $Recordset;
	var $OldRecordset;

	//
	// Page main
	//
	function Page_Main() {
		global $objForm, $Language, $gsFormError, $gsSearchError, $Security;

		// Search filters
		$sSrchAdvanced = ""; // Advanced search filter
		$sSrchBasic = ""; // Basic search filter
		$sFilter = "";

		// Get command
		$this->Command = strtolower(@$_GET["cmd"]);
		if ($this->IsPageRequest()) { // Validate request

			// Process custom action first
			$this->ProcessCustomAction();

			// Set up records per page
			$this->SetUpDisplayRecs();

			// Handle reset command
			$this->ResetCmd();

			// Set up master detail parameters
			$this->SetUpMasterParms();

			// Set up Breadcrumb
			$this->SetupBreadcrumb();

			// Hide list options
			if ($this->Export <> "") {
				$this->ListOptions->HideAllOptions(array("sequence"));
				$this->ListOptions->UseDropDownButton = FALSE; // Disable drop down button
				$this->ListOptions->UseButtonGroup = FALSE; // Disable button group
			} elseif ($this->CurrentAction == "gridadd" || $this->CurrentAction == "gridedit") {
				$this->ListOptions->HideAllOptions();
				$this->ListOptions->UseDropDownButton = FALSE; // Disable drop down button
				$this->ListOptions->UseButtonGroup = FALSE; // Disable button group
			}

			// Hide export options
			if ($this->Export <> "" || $this->CurrentAction <> "")
				$this->ExportOptions->HideAllOptions();

			// Hide other options
			if ($this->Export <> "") {
				foreach ($this->OtherOptions as &$option)
					$option->HideAllOptions();
			}

			// Get basic search values
			$this->LoadBasicSearchValues();

			// Restore search parms from Session if not searching / reset
			if ($this->Command <> "search" && $this->Command <> "reset" && $this->Command <> "resetall" && $this->CheckSearchParms())
				$this->RestoreSearchParms();

			// Call Recordset SearchValidated event
			$this->Recordset_SearchValidated();

			// Set up sorting order
			$this->SetUpSortOrder();

			// Get basic search criteria
			if ($gsSearchError == "")
				$sSrchBasic = $this->BasicSearchWhere();
		}

		// Restore display records
		if ($this->getRecordsPerPage() <> "") {
			$this->DisplayRecs = $this->getRecordsPerPage(); // Restore from Session
		} else {
			$this->DisplayRecs = 25; // Load default
		}

		// Load Sorting Order
		$this->LoadSortOrder();

		// Load search default if no existing search criteria
		if (!$this->CheckSearchParms()) {

			// Load basic search from default
			$this->BasicSearch->LoadDefault();
			if ($this->BasicSearch->Keyword != "")
				$sSrchBasic = $this->BasicSearchWhere();
		}

		// Build search criteria
		ew_AddFilter($this->SearchWhere, $sSrchAdvanced);
		ew_AddFilter($this->SearchWhere, $sSrchBasic);

		// Call Recordset_Searching event
		$this->Recordset_Searching($this->SearchWhere);

		// Save search criteria
		if ($this->Command == "search" && !$this->RestoreSearch) {
			$this->setSearchWhere($this->SearchWhere); // Save to Session
			$this->StartRec = 1; // Reset start record counter
			$this->setStartRecordNumber($this->StartRec);
		} else {
			$this->SearchWhere = $this->getSearchWhere();
		}

		// Build filter
		$sFilter = "";

		// Restore master/detail filter
		$this->DbMasterFilter = $this->GetMasterFilter(); // Restore master filter
		$this->DbDetailFilter = $this->GetDetailFilter(); // Restore detail filter
		ew_AddFilter($sFilter, $this->DbDetailFilter);
		ew_AddFilter($sFilter, $this->SearchWhere);

		// Load master record
		if ($this->CurrentMode <> "add" && $this->GetMasterFilter() <> "" && $this->getCurrentMasterTable() == "beneficiary_dump") {
			global $beneficiary_dump;
			$rsmaster = $beneficiary_dump->LoadRs($this->DbMasterFilter);
			$this->MasterRecordExists = ($rsmaster && !$rsmaster->EOF);
			if (!$this->MasterRecordExists) {
				$this->setFailureMessage($Language->Phrase("NoRecord")); // Set no record found
				$this->Page_Terminate("beneficiary_dumplist.php"); // Return to master page
			} else {
				$beneficiary_dump->LoadListRowValues($rsmaster);
				$beneficiary_dump->RowType = EW_ROWTYPE_MASTER; // Master row
				$beneficiary_dump->RenderListRow();
				$rsmaster->Close();
			}
		}

		// Load master record
		if ($this->CurrentMode <> "add" && $this->GetMasterFilter() <> "" && $this->getCurrentMasterTable() == "comprehensivewill_tb") {
			global $comprehensivewill_tb;
			$rsmaster = $comprehensivewill_tb->LoadRs($this->DbMasterFilter);
			$this->MasterRecordExists = ($rsmaster && !$rsmaster->EOF);
			if (!$this->MasterRecordExists) {
				$this->setFailureMessage($Language->Phrase("NoRecord")); // Set no record found
				$this->Page_Terminate("comprehensivewill_tblist.php"); // Return to master page
			} else {
				$comprehensivewill_tb->LoadListRowValues($rsmaster);
				$comprehensivewill_tb->RowType = EW_ROWTYPE_MASTER; // Master row
				$comprehensivewill_tb->RenderListRow();
				$rsmaster->Close();
			}
		}

		// Load master record
		if ($this->CurrentMode <> "add" && $this->GetMasterFilter() <> "" && $this->getCurrentMasterTable() == "premiumwill_tb") {
			global $premiumwill_tb;
			$rsmaster = $premiumwill_tb->LoadRs($this->DbMasterFilter);
			$this->MasterRecordExists = ($rsmaster && !$rsmaster->EOF);
			if (!$this->MasterRecordExists) {
				$this->setFailureMessage($Language->Phrase("NoRecord")); // Set no record found
				$this->Page_Terminate("premiumwill_tblist.php"); // Return to master page
			} else {
				$premiumwill_tb->LoadListRowValues($rsmaster);
				$premiumwill_tb->RowType = EW_ROWTYPE_MASTER; // Master row
				$premiumwill_tb->RenderListRow();
				$rsmaster->Close();
			}
		}

		// Load master record
		if ($this->CurrentMode <> "add" && $this->GetMasterFilter() <> "" && $this->getCurrentMasterTable() == "personal_info") {
			global $personal_info;
			$rsmaster = $personal_info->LoadRs($this->DbMasterFilter);
			$this->MasterRecordExists = ($rsmaster && !$rsmaster->EOF);
			if (!$this->MasterRecordExists) {
				$this->setFailureMessage($Language->Phrase("NoRecord")); // Set no record found
				$this->Page_Terminate("personal_infolist.php"); // Return to master page
			} else {
				$personal_info->LoadListRowValues($rsmaster);
				$personal_info->RowType = EW_ROWTYPE_MASTER; // Master row
				$personal_info->RenderListRow();
				$rsmaster->Close();
			}
		}

		// Load master record
		if ($this->CurrentMode <> "add" && $this->GetMasterFilter() <> "" && $this->getCurrentMasterTable() == "privatetrust_tb") {
			global $privatetrust_tb;
			$rsmaster = $privatetrust_tb->LoadRs($this->DbMasterFilter);
			$this->MasterRecordExists = ($rsmaster && !$rsmaster->EOF);
			if (!$this->MasterRecordExists) {
				$this->setFailureMessage($Language->Phrase("NoRecord")); // Set no record found
				$this->Page_Terminate("privatetrust_tblist.php"); // Return to master page
			} else {
				$privatetrust_tb->LoadListRowValues($rsmaster);
				$privatetrust_tb->RowType = EW_ROWTYPE_MASTER; // Master row
				$privatetrust_tb->RenderListRow();
				$rsmaster->Close();
			}
		}

		// Set up filter in session
		$this->setSessionWhere($sFilter);
		$this->CurrentFilter = "";

		// Export data only
		if (in_array($this->Export, array("html","word","excel","xml","csv","email","pdf"))) {
			$this->ExportData();
			$this->Page_Terminate(); // Terminate response
			exit();
		}
	}

	// Set up number of records displayed per page
	function SetUpDisplayRecs() {
		$sWrk = @$_GET[EW_TABLE_REC_PER_PAGE];
		if ($sWrk <> "") {
			if (is_numeric($sWrk)) {
				$this->DisplayRecs = intval($sWrk);
			} else {
				if (strtolower($sWrk) == "all") { // Display all records
					$this->DisplayRecs = -1;
				} else {
					$this->DisplayRecs = 25; // Non-numeric, load default
				}
			}
			$this->setRecordsPerPage($this->DisplayRecs); // Save to Session

			// Reset start position
			$this->StartRec = 1;
			$this->setStartRecordNumber($this->StartRec);
		}
	}

	// Build filter for all keys
	function BuildKeyFilter() {
		global $objForm;
		$sWrkFilter = "";

		// Update row index and get row key
		$rowindex = 1;
		$objForm->Index = $rowindex;
		$sThisKey = strval($objForm->GetValue("k_key"));
		while ($sThisKey <> "") {
			if ($this->SetupKeyValues($sThisKey)) {
				$sFilter = $this->KeyFilter();
				if ($sWrkFilter <> "") $sWrkFilter .= " OR ";
				$sWrkFilter .= $sFilter;
			} else {
				$sWrkFilter = "0=1";
				break;
			}

			// Update row index and get row key
			$rowindex++; // Next row
			$objForm->Index = $rowindex;
			$sThisKey = strval($objForm->GetValue("k_key"));
		}
		return $sWrkFilter;
	}

	// Set up key values
	function SetupKeyValues($key) {
		$arrKeyFlds = explode($GLOBALS["EW_COMPOSITE_KEY_SEPARATOR"], $key);
		if (count($arrKeyFlds) >= 1) {
			$this->id->setFormValue($arrKeyFlds[0]);
			if (!is_numeric($this->id->FormValue))
				return FALSE;
		}
		return TRUE;
	}

	// Return basic search SQL
	function BasicSearchSQL($Keyword) {
		$sKeyword = ew_AdjustSql($Keyword);
		$sWhere = "";
		$this->BuildBasicSearchSQL($sWhere, $this->asset_type, $Keyword);
		$this->BuildBasicSearchSQL($sWhere, $this->property_location, $Keyword);
		$this->BuildBasicSearchSQL($sWhere, $this->property_type, $Keyword);
		$this->BuildBasicSearchSQL($sWhere, $this->property_registered, $Keyword);
		$this->BuildBasicSearchSQL($sWhere, $this->shares_company, $Keyword);
		$this->BuildBasicSearchSQL($sWhere, $this->shares_volume, $Keyword);
		$this->BuildBasicSearchSQL($sWhere, $this->shares_percent, $Keyword);
		$this->BuildBasicSearchSQL($sWhere, $this->shares_cscs, $Keyword);
		$this->BuildBasicSearchSQL($sWhere, $this->shares_chn, $Keyword);
		$this->BuildBasicSearchSQL($sWhere, $this->insurance_company, $Keyword);
		$this->BuildBasicSearchSQL($sWhere, $this->insurance_type, $Keyword);
		$this->BuildBasicSearchSQL($sWhere, $this->insurance_owner, $Keyword);
		$this->BuildBasicSearchSQL($sWhere, $this->insurance_facevalue, $Keyword);
		$this->BuildBasicSearchSQL($sWhere, $this->bvn, $Keyword);
		$this->BuildBasicSearchSQL($sWhere, $this->account_name, $Keyword);
		$this->BuildBasicSearchSQL($sWhere, $this->account_no, $Keyword);
		$this->BuildBasicSearchSQL($sWhere, $this->bankname, $Keyword);
		$this->BuildBasicSearchSQL($sWhere, $this->accounttype, $Keyword);
		$this->BuildBasicSearchSQL($sWhere, $this->pension_name, $Keyword);
		$this->BuildBasicSearchSQL($sWhere, $this->pension_owner, $Keyword);
		$this->BuildBasicSearchSQL($sWhere, $this->pension_plan, $Keyword);
		$this->BuildBasicSearchSQL($sWhere, $this->rsano, $Keyword);
		$this->BuildBasicSearchSQL($sWhere, $this->pension_admin, $Keyword);
		return $sWhere;
	}

	// Build basic search SQL
	function BuildBasicSearchSql(&$Where, &$Fld, $Keyword) {
		if ($Keyword == EW_NULL_VALUE) {
			$sWrk = $Fld->FldExpression . " IS NULL";
		} elseif ($Keyword == EW_NOT_NULL_VALUE) {
			$sWrk = $Fld->FldExpression . " IS NOT NULL";
		} else {
			$sFldExpression = ($Fld->FldVirtualExpression <> $Fld->FldExpression) ? $Fld->FldVirtualExpression : $Fld->FldBasicSearchExpression;
			$sWrk = $sFldExpression . ew_Like(ew_QuotedValue("%" . $Keyword . "%", EW_DATATYPE_STRING));
		}
		if ($Where <> "") $Where .= " OR ";
		$Where .= $sWrk;
	}

	// Return basic search WHERE clause based on search keyword and type
	function BasicSearchWhere() {
		global $Security;
		$sSearchStr = "";
		$sSearchKeyword = $this->BasicSearch->Keyword;
		$sSearchType = $this->BasicSearch->Type;
		if ($sSearchKeyword <> "") {
			$sSearch = trim($sSearchKeyword);
			if ($sSearchType <> "=") {
				while (strpos($sSearch, "  ") !== FALSE)
					$sSearch = str_replace("  ", " ", $sSearch);
				$arKeyword = explode(" ", trim($sSearch));
				foreach ($arKeyword as $sKeyword) {
					if ($sSearchStr <> "") $sSearchStr .= " " . $sSearchType . " ";
					$sSearchStr .= "(" . $this->BasicSearchSQL($sKeyword) . ")";
				}
			} else {
				$sSearchStr = $this->BasicSearchSQL($sSearch);
			}
			$this->Command = "search";
		}
		if ($this->Command == "search") {
			$this->BasicSearch->setKeyword($sSearchKeyword);
			$this->BasicSearch->setType($sSearchType);
		}
		return $sSearchStr;
	}

	// Check if search parm exists
	function CheckSearchParms() {

		// Check basic search
		if ($this->BasicSearch->IssetSession())
			return TRUE;
		return FALSE;
	}

	// Clear all search parameters
	function ResetSearchParms() {

		// Clear search WHERE clause
		$this->SearchWhere = "";
		$this->setSearchWhere($this->SearchWhere);

		// Clear basic search parameters
		$this->ResetBasicSearchParms();
	}

	// Load advanced search default values
	function LoadAdvancedSearchDefault() {
		return FALSE;
	}

	// Clear all basic search parameters
	function ResetBasicSearchParms() {
		$this->BasicSearch->UnsetSession();
	}

	// Restore all search parameters
	function RestoreSearchParms() {
		$this->RestoreSearch = TRUE;

		// Restore basic search values
		$this->BasicSearch->Load();
	}

	// Set up sort parameters
	function SetUpSortOrder() {

		// Check for Ctrl pressed
		$bCtrl = (@$_GET["ctrl"] <> "");

		// Check for "order" parameter
		if (@$_GET["order"] <> "") {
			$this->CurrentOrder = ew_StripSlashes(@$_GET["order"]);
			$this->CurrentOrderType = @$_GET["ordertype"];
			$this->UpdateSort($this->id, $bCtrl); // id
			$this->UpdateSort($this->asset_type, $bCtrl); // asset_type
			$this->UpdateSort($this->property_location, $bCtrl); // property_location
			$this->UpdateSort($this->property_type, $bCtrl); // property_type
			$this->UpdateSort($this->shares_company, $bCtrl); // shares_company
			$this->UpdateSort($this->insurance_company, $bCtrl); // insurance_company
			$this->UpdateSort($this->insurance_type, $bCtrl); // insurance_type
			$this->UpdateSort($this->account_name, $bCtrl); // account_name
			$this->UpdateSort($this->bankname, $bCtrl); // bankname
			$this->UpdateSort($this->pension_name, $bCtrl); // pension_name
			$this->UpdateSort($this->pension_owner, $bCtrl); // pension_owner
			$this->UpdateSort($this->datecreated, $bCtrl); // datecreated
			$this->setStartRecordNumber(1); // Reset start position
		}
	}

	// Load sort order parameters
	function LoadSortOrder() {
		$sOrderBy = $this->getSessionOrderBy(); // Get ORDER BY from Session
		if ($sOrderBy == "") {
			if ($this->SqlOrderBy() <> "") {
				$sOrderBy = $this->SqlOrderBy();
				$this->setSessionOrderBy($sOrderBy);
			}
		}
	}

	// Reset command
	// - cmd=reset (Reset search parameters)
	// - cmd=resetall (Reset search and master/detail parameters)
	// - cmd=resetsort (Reset sort parameters)
	function ResetCmd() {

		// Check if reset command
		if (substr($this->Command,0,5) == "reset") {

			// Reset search criteria
			if ($this->Command == "reset" || $this->Command == "resetall")
				$this->ResetSearchParms();

			// Reset master/detail keys
			if ($this->Command == "resetall") {
				$this->setCurrentMasterTable(""); // Clear master table
				$this->DbMasterFilter = "";
				$this->DbDetailFilter = "";
				$this->uid->setSessionValue("");
				$this->uid->setSessionValue("");
				$this->uid->setSessionValue("");
				$this->uid->setSessionValue("");
				$this->uid->setSessionValue("");
			}

			// Reset sorting order
			if ($this->Command == "resetsort") {
				$sOrderBy = "";
				$this->setSessionOrderBy($sOrderBy);
				$this->id->setSort("");
				$this->asset_type->setSort("");
				$this->property_location->setSort("");
				$this->property_type->setSort("");
				$this->shares_company->setSort("");
				$this->insurance_company->setSort("");
				$this->insurance_type->setSort("");
				$this->account_name->setSort("");
				$this->bankname->setSort("");
				$this->pension_name->setSort("");
				$this->pension_owner->setSort("");
				$this->datecreated->setSort("");
			}

			// Reset start position
			$this->StartRec = 1;
			$this->setStartRecordNumber($this->StartRec);
		}
	}

	// Set up list options
	function SetupListOptions() {
		global $Security, $Language;

		// Add group option item
		$item = &$this->ListOptions->Add($this->ListOptions->GroupOptionName);
		$item->Body = "";
		$item->OnLeft = FALSE;
		$item->Visible = FALSE;

		// "view"
		$item = &$this->ListOptions->Add("view");
		$item->CssStyle = "white-space: nowrap;";
		$item->Visible = $Security->IsLoggedIn();
		$item->OnLeft = FALSE;

		// "edit"
		$item = &$this->ListOptions->Add("edit");
		$item->CssStyle = "white-space: nowrap;";
		$item->Visible = $Security->IsLoggedIn();
		$item->OnLeft = FALSE;

		// "copy"
		$item = &$this->ListOptions->Add("copy");
		$item->CssStyle = "white-space: nowrap;";
		$item->Visible = $Security->IsLoggedIn();
		$item->OnLeft = FALSE;

		// "detail_overall_asset"
		$item = &$this->ListOptions->Add("detail_overall_asset");
		$item->CssStyle = "white-space: nowrap;";
		$item->Visible = $Security->IsLoggedIn() && !$this->ShowMultipleDetails;
		$item->OnLeft = FALSE;
		$item->ShowInButtonGroup = FALSE;
		if (!isset($GLOBALS["overall_asset_grid"])) $GLOBALS["overall_asset_grid"] = new coverall_asset_grid;

		// Multiple details
		if ($this->ShowMultipleDetails) {
			$item = &$this->ListOptions->Add("details");
			$item->CssStyle = "white-space: nowrap;";
			$item->Visible = $this->ShowMultipleDetails;
			$item->OnLeft = FALSE;
			$item->ShowInButtonGroup = FALSE;
		}

		// "checkbox"
		$item = &$this->ListOptions->Add("checkbox");
		$item->Visible = $Security->IsLoggedIn();
		$item->OnLeft = FALSE;
		$item->Header = "<label class=\"checkbox\"><input type=\"checkbox\" name=\"key\" id=\"key\" onclick=\"ew_SelectAllKey(this);\"></label>";
		$item->ShowInDropDown = FALSE;
		$item->ShowInButtonGroup = FALSE;

		// "sequence"
		$item = &$this->ListOptions->Add("sequence");
		$item->CssStyle = "white-space: nowrap;";
		$item->Visible = TRUE;
		$item->OnLeft = TRUE; // Always on left
		$item->ShowInDropDown = FALSE;
		$item->ShowInButtonGroup = FALSE;

		// Drop down button for ListOptions
		$this->ListOptions->UseDropDownButton = TRUE;
		$this->ListOptions->DropDownButtonPhrase = $Language->Phrase("ButtonListOptions");
		$this->ListOptions->UseButtonGroup = TRUE;
		$this->ListOptions->ButtonClass = "btn-small"; // Class for button group

		// Call ListOptions_Load event
		$this->ListOptions_Load();
		$item = &$this->ListOptions->GetItem($this->ListOptions->GroupOptionName);
		$item->Visible = $this->ListOptions->GroupOptionVisible();
	}

	// Render list options
	function RenderListOptions() {
		global $Security, $Language, $objForm;
		$this->ListOptions->LoadDefault();

		// "sequence"
		$oListOpt = &$this->ListOptions->Items["sequence"];
		$oListOpt->Body = ew_FormatSeqNo($this->RecCnt);

		// "view"
		$oListOpt = &$this->ListOptions->Items["view"];
		if ($Security->IsLoggedIn())
			$oListOpt->Body = "<a class=\"ewRowLink ewView\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("ViewLink")) . "\" href=\"" . ew_HtmlEncode($this->ViewUrl) . "\">" . $Language->Phrase("ViewLink") . "</a>";
		else
			$oListOpt->Body = "";

		// "edit"
		$oListOpt = &$this->ListOptions->Items["edit"];
		if ($Security->IsLoggedIn()) {
			$oListOpt->Body = "<a class=\"ewRowLink ewEdit\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("EditLink")) . "\" href=\"" . ew_HtmlEncode($this->EditUrl) . "\">" . $Language->Phrase("EditLink") . "</a>";
		} else {
			$oListOpt->Body = "";
		}

		// "copy"
		$oListOpt = &$this->ListOptions->Items["copy"];
		if ($Security->IsLoggedIn()) {
			$oListOpt->Body = "<a class=\"ewRowLink ewCopy\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("CopyLink")) . "\" href=\"" . ew_HtmlEncode($this->CopyUrl) . "\">" . $Language->Phrase("CopyLink") . "</a>";
		} else {
			$oListOpt->Body = "";
		}
		$DetailViewTblVar = "";
		$DetailCopyTblVar = "";
		$DetailEditTblVar = "";

		// "detail_overall_asset"
		$oListOpt = &$this->ListOptions->Items["detail_overall_asset"];
		if ($Security->IsLoggedIn()) {
			$body = $Language->Phrase("DetailLink") . $Language->TablePhrase("overall_asset", "TblCaption");
			$body = "<a class=\"btn btn-small ewRowLink ewDetailList\" data-action=\"list\" href=\"" . ew_HtmlEncode("overall_assetlist.php?" . EW_TABLE_SHOW_MASTER . "=assets_tb&uid=" . strval($this->uid->CurrentValue) . "") . "\">" . $body . "</a>";
			$links = "";
			if ($GLOBALS["overall_asset_grid"]->DetailView && $Security->IsLoggedIn() && $Security->IsLoggedIn()) {
				$links .= "<li><a class=\"ewRowLink ewDetailView\" data-action=\"view\" href=\"" . ew_HtmlEncode($this->GetViewUrl(EW_TABLE_SHOW_DETAIL . "=overall_asset")) . "\">" . $Language->Phrase("MasterDetailViewLink") . "</a></li>";
				if ($DetailViewTblVar <> "") $DetailViewTblVar .= ",";
				$DetailViewTblVar .= "overall_asset";
			}
			if ($GLOBALS["overall_asset_grid"]->DetailEdit && $Security->IsLoggedIn() && $Security->IsLoggedIn()) {
				$links .= "<li><a class=\"ewRowLink ewDetailEdit\" data-action=\"edit\" href=\"" . ew_HtmlEncode($this->GetEditUrl(EW_TABLE_SHOW_DETAIL . "=overall_asset")) . "\">" . $Language->Phrase("MasterDetailEditLink") . "</a></li>";
				if ($DetailEditTblVar <> "") $DetailEditTblVar .= ",";
				$DetailEditTblVar .= "overall_asset";
			}
			if ($GLOBALS["overall_asset_grid"]->DetailAdd && $Security->IsLoggedIn() && $Security->IsLoggedIn()) {
				$links .= "<li><a class=\"ewRowLink ewDetailCopy\" data-action=\"add\" href=\"" . ew_HtmlEncode($this->GetCopyUrl(EW_TABLE_SHOW_DETAIL . "=overall_asset")) . "\">" . $Language->Phrase("MasterDetailCopyLink") . "</a></li>";
				if ($DetailCopyTblVar <> "") $DetailCopyTblVar .= ",";
				$DetailCopyTblVar .= "overall_asset";
			}
			if ($links <> "") {
				$body .= "<button class=\"btn btn-small dropdown-toggle\" data-toggle=\"dropdown\"><b class=\"caret\"></b></button>";
				$body .= "<ul class=\"dropdown-menu\">". $links . "</ul>";
			}
			$body = "<div class=\"btn-group\">" . $body . "</div>";
			$oListOpt->Body = $body;
			if ($this->ShowMultipleDetails) $oListOpt->Visible = FALSE;
		}
		if ($this->ShowMultipleDetails) {
			$body = $Language->Phrase("MultipleMasterDetails");
			$body = "<div class=\"btn-group\">" .
				"<a class=\"btn btn-small ewRowLink ewDetailView\" data-action=\"list\" href=\"" . ew_HtmlEncode($this->GetViewUrl(EW_TABLE_SHOW_DETAIL . "=" . $DetailViewTblVar)) . "\">" . $body . "</a>";
			$links = "";
			if ($DetailViewTblVar <> "") {
				$links .= "<li><a class=\"ewRowLink ewDetailView\" data-action=\"view\" href=\"" . ew_HtmlEncode($this->GetViewUrl(EW_TABLE_SHOW_DETAIL . "=" . $DetailViewTblVar)) . "\">" . $Language->Phrase("MasterDetailViewLink") . "</a></li>";
			}
			if ($DetailEditTblVar <> "") {
				$links .= "<li><a class=\"ewRowLink ewDetailEdit\" data-action=\"edit\" href=\"" . ew_HtmlEncode($this->GetEditUrl(EW_TABLE_SHOW_DETAIL . "=" . $DetailEditTblVar)) . "\">" . $Language->Phrase("MasterDetailEditLink") . "</a></li>";
			}
			if ($DetailCopyTblVar <> "") {
				$links .= "<li><a class=\"ewRowLink ewDetailCopy\" data-action=\"add\" href=\"" . ew_HtmlEncode($this->GetCopyUrl(EW_TABLE_SHOW_DETAIL . "=" . $DetailCopyTblVar)) . "\">" . $Language->Phrase("MasterDetailCopyLink") . "</a></li>";
			}
			if ($links <> "") {
				$body .= "<button class=\"btn btn-small dropdown-toggle\" data-toggle=\"dropdown\">&nbsp;<b class=\"caret\"></b></button>";
				$body .= "<ul class=\"dropdown-menu\">". $links . "</ul>";
			}
			$body .= "</div>";

			// Multiple details
			$oListOpt = &$this->ListOptions->Items["details"];
			$oListOpt->Body = $body;
		}

		// "checkbox"
		$oListOpt = &$this->ListOptions->Items["checkbox"];
		$oListOpt->Body = "<label class=\"checkbox\"><input type=\"checkbox\" name=\"key_m[]\" value=\"" . ew_HtmlEncode($this->id->CurrentValue) . "\" onclick='ew_ClickMultiCheckbox(event, this);'></label>";
		$this->RenderListOptionsExt();

		// Call ListOptions_Rendered event
		$this->ListOptions_Rendered();
	}

	// Set up other options
	function SetupOtherOptions() {
		global $Language, $Security;
		$options = &$this->OtherOptions;
		$option = $options["addedit"];

		// Add
		$item = &$option->Add("add");
		$item->Body = "<a class=\"ewAddEdit ewAdd\" href=\"" . ew_HtmlEncode($this->AddUrl) . "\">" . $Language->Phrase("AddLink") . "</a>";
		$item->Visible = ($this->AddUrl <> "" && $Security->IsLoggedIn());
		$option = $options["detail"];
		$DetailTableLink = "";
		$item = &$option->Add("detailadd_overall_asset");
		$item->Body = "<a class=\"ewDetailAddGroup ewDetailAdd\" href=\"" . ew_HtmlEncode($this->GetAddUrl() . "?" . EW_TABLE_SHOW_DETAIL . "=overall_asset") . "\">" . $Language->Phrase("AddLink") . "&nbsp;" . $this->TableCaption() . "/" . $GLOBALS["overall_asset"]->TableCaption() . "</a>";
		$item->Visible = ($GLOBALS["overall_asset"]->DetailAdd && $Security->IsLoggedIn() && $Security->IsLoggedIn());
		if ($item->Visible) {
			if ($DetailTableLink <> "") $DetailTableLink .= ",";
			$DetailTableLink .= "overall_asset";
		}

		// Add multiple details
		if ($this->ShowMultipleDetails) {
			$item = &$option->Add("detailsadd");
			$item->Body = "<a class=\"ewDetailAddGroup ewDetailAdd\" href=\"" . ew_HtmlEncode($this->GetAddUrl() . "?" . EW_TABLE_SHOW_DETAIL . "=" . $DetailTableLink) . "\">" . $Language->Phrase("AddMasterDetailLink") . "</a>";
			$item->Visible = ($DetailTableLink <> "" && $Security->IsLoggedIn());

			// Hide single master/detail items
			$ar = explode(",", $DetailTableLink);
			$cnt = count($ar);
			for ($i = 0; $i < $cnt; $i++) {
				if ($item = &$option->GetItem("detailadd_" . $ar[$i]))
					$item->Visible = FALSE;
			}
		}
		$option = $options["action"];

		// Add multi delete
		$item = &$option->Add("multidelete");
		$item->Body = "<a class=\"ewAction ewMultiDelete\" href=\"\" onclick=\"ew_SubmitSelected(document.fassets_tblist, '" . $this->MultiDeleteUrl . "', ewLanguage.Phrase('DeleteMultiConfirmMsg'));return false;\">" . $Language->Phrase("DeleteSelectedLink") . "</a>";
		$item->Visible = ($Security->IsLoggedIn());

		// Set up options default
		foreach ($options as &$option) {
			$option->UseDropDownButton = TRUE;
			$option->UseButtonGroup = TRUE;
			$option->ButtonClass = "btn-small"; // Class for button group
			$item = &$option->Add($option->GroupOptionName);
			$item->Body = "";
			$item->Visible = FALSE;
		}
		$options["addedit"]->DropDownButtonPhrase = $Language->Phrase("ButtonAddEdit");
		$options["detail"]->DropDownButtonPhrase = $Language->Phrase("ButtonDetails");
		$options["action"]->DropDownButtonPhrase = $Language->Phrase("ButtonActions");
	}

	// Render other options
	function RenderOtherOptions() {
		global $Language, $Security;
		$options = &$this->OtherOptions;
			$option = &$options["action"];
			foreach ($this->CustomActions as $action => $name) {

				// Add custom action
				$item = &$option->Add("custom_" . $action);
				$item->Body = "<a class=\"ewAction ewCustomAction\" href=\"\" onclick=\"ew_SubmitSelected(document.fassets_tblist, '" . ew_CurrentUrl() . "', null, '" . $action . "');return false;\">" . $name . "</a>";
			}

			// Hide grid edit, multi-delete and multi-update
			if ($this->TotalRecs <= 0) {
				$option = &$options["addedit"];
				$item = &$option->GetItem("gridedit");
				if ($item) $item->Visible = FALSE;
				$option = &$options["action"];
				$item = &$option->GetItem("multidelete");
				if ($item) $item->Visible = FALSE;
				$item = &$option->GetItem("multiupdate");
				if ($item) $item->Visible = FALSE;
			}
	}

	// Process custom action
	function ProcessCustomAction() {
		global $conn, $Language, $Security;
		$sFilter = $this->GetKeyFilter();
		$UserAction = @$_POST["useraction"];
		if ($sFilter <> "" && $UserAction <> "") {
			$this->CurrentFilter = $sFilter;
			$sSql = $this->SQL();
			$conn->raiseErrorFn = 'ew_ErrorFn';
			$rs = $conn->Execute($sSql);
			$conn->raiseErrorFn = '';
			$rsuser = ($rs) ? $rs->GetRows() : array();
			if ($rs)
				$rs->Close();

			// Call row custom action event
			if (count($rsuser) > 0) {
				$conn->BeginTrans();
				foreach ($rsuser as $row) {
					$Processed = $this->Row_CustomAction($UserAction, $row);
					if (!$Processed) break;
				}
				if ($Processed) {
					$conn->CommitTrans(); // Commit the changes
					if ($this->getSuccessMessage() == "")
						$this->setSuccessMessage(str_replace('%s', $UserAction, $Language->Phrase("CustomActionCompleted"))); // Set up success message
				} else {
					$conn->RollbackTrans(); // Rollback changes

					// Set up error message
					if ($this->getSuccessMessage() <> "" || $this->getFailureMessage() <> "") {

						// Use the message, do nothing
					} elseif ($this->CancelMessage <> "") {
						$this->setFailureMessage($this->CancelMessage);
						$this->CancelMessage = "";
					} else {
						$this->setFailureMessage(str_replace('%s', $UserAction, $Language->Phrase("CustomActionCancelled")));
					}
				}
			}
		}
	}

	function RenderListOptionsExt() {
		global $Security, $Language;
		$links = "";
		$btngrps = "";
		$sSqlWrk = "`uid`=" . ew_AdjustSql($this->uid->CurrentValue) . "";

		// Column "detail_overall_asset"
		$link = "";
		$option = &$this->ListOptions->Items["detail_overall_asset"];
		$url = "overall_assetpreview.php?f=" . ew_Encrypt($sSqlWrk);
		$btngrp = "<div data-table=\"overall_asset\" data-url=\"" . $url . "\" class=\"btn-group\">";
		if ($Security->IsLoggedIn()) {			
			$label = $Language->TablePhrase("overall_asset", "TblCaption");
			$link = "<li><a href=\"#\" data-toggle=\"tab\" data-table=\"overall_asset\" data-url=\"" . $url . "\">" . $label . "</a></li>";			
			$links .= $link;
			$detaillnk = ew_JsEncode3("overall_assetlist.php?" . EW_TABLE_SHOW_MASTER . "=assets_tb&uid=" . urlencode(strval($this->uid->CurrentValue)) . "");
			$btngrp .= "<button type=\"button\" class=\"btn btn-small\" onclick=\"window.location='" . $detaillnk . "'\">" . $Language->TablePhrase("overall_asset", "TblCaption") . "</button>";
		}
		if ($GLOBALS["overall_asset_grid"]->DetailView && $Security->IsLoggedIn() && $Security->IsLoggedIn())
			$btngrp .= "<button type=\"button\" class=\"btn btn-small\" onclick=\"window.location='" . $this->GetViewUrl(EW_TABLE_SHOW_DETAIL . "=overall_asset") . "'\">" . $Language->Phrase("MasterDetailViewLink") . "</button>";
		if ($GLOBALS["overall_asset_grid"]->DetailEdit && $Security->IsLoggedIn() && $Security->IsLoggedIn())
			$btngrp .= "<button type=\"button\" class=\"btn btn-small\" onclick=\"window.location='" . $this->GetEditUrl(EW_TABLE_SHOW_DETAIL . "=overall_asset") . "'\">" . $Language->Phrase("MasterDetailEditLink") . "</button>";
		if ($GLOBALS["overall_asset_grid"]->DetailAdd && $Security->IsLoggedIn() && $Security->IsLoggedIn())
			$btngrp .= "<button type=\"button\" class=\"btn btn-small\" onclick=\"window.location='" . $this->GetCopyUrl(EW_TABLE_SHOW_DETAIL . "=overall_asset") . "'\">" . $Language->Phrase("MasterDetailCopyLink") . "</button>";
		$btngrp .= "</div>";
		if ($link <> "") {
			$btngrps .= $btngrp;
			$option->Body .= "<div class=\"hide ewPreview\">" . $link . $btngrp . "</div>";
		}

		// Hide detail items if necessary
		$showdtl = FALSE;
		foreach ($this->ListOptions->Items as $item) {
			if ($item->Name <> $this->ListOptions->GroupOptionName && $item->Visible && $item->ShowInDropDown && substr($item->Name,0,7) <> "detail_") {
				$showdtl = TRUE;
				break;
			}
		}
		if (!$showdtl) {
			foreach ($this->ListOptions->Items as $item) {
				if (substr($item->Name,0,7) == "detail_") {
					$item->Visible = FALSE;
				}
			}
		}

		// Column "preview"
		$option = &$this->ListOptions->GetItem("preview");
		if (!$option) { // Add preview column
			$option = &$this->ListOptions->Add("preview");
			$option->OnLeft = FALSE;
			if ($option->OnLeft) {
				$option->MoveTo($this->ListOptions->ItemPos("checkbox") + 1);
			} else {
				$option->MoveTo($this->ListOptions->ItemPos("checkbox"));
			}
			$option->Visible = !($this->Export <> "" || $this->CurrentAction == "gridadd" || $this->CurrentAction == "gridedit");
			$option->ShowInDropDown = FALSE;
			$option->ShowInButtonGroup = FALSE;
		}
		if ($option) {
			$option->Body = "<img class=\"ewPreviewRowImage\" src=\"phpimages/expand.gif\" alt=\"\" style=\"width: 9px; height: 9px; border: 0;\">";
			$option->Body .= "<div class=\"hide ewPreview\">" . $links . $btngrps . "</div>";
			if ($option->Visible) $option->Visible = $link <> "";
		}

		// Column "details" (Multiple details)
		$option = &$this->ListOptions->GetItem("details");
		if ($option) {
			$option->Body .= "<div class=\"hide ewPreview\">" . $links . $btngrps . "</div>";
			if ($option->Visible) $option->Visible = $links <> "";
		}
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

	// Load basic search values
	function LoadBasicSearchValues() {
		$this->BasicSearch->Keyword = @$_GET[EW_TABLE_BASIC_SEARCH];
		if ($this->BasicSearch->Keyword <> "") $this->Command = "search";
		$this->BasicSearch->Type = @$_GET[EW_TABLE_BASIC_SEARCH_TYPE];
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
		$this->ViewUrl = $this->GetViewUrl();
		$this->EditUrl = $this->GetEditUrl();
		$this->InlineEditUrl = $this->GetInlineEditUrl();
		$this->CopyUrl = $this->GetCopyUrl();
		$this->InlineCopyUrl = $this->GetInlineCopyUrl();
		$this->DeleteUrl = $this->GetDeleteUrl();

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

			// shares_company
			$this->shares_company->LinkCustomAttributes = "";
			$this->shares_company->HrefValue = "";
			$this->shares_company->TooltipValue = "";

			// insurance_company
			$this->insurance_company->LinkCustomAttributes = "";
			$this->insurance_company->HrefValue = "";
			$this->insurance_company->TooltipValue = "";

			// insurance_type
			$this->insurance_type->LinkCustomAttributes = "";
			$this->insurance_type->HrefValue = "";
			$this->insurance_type->TooltipValue = "";

			// account_name
			$this->account_name->LinkCustomAttributes = "";
			$this->account_name->HrefValue = "";
			$this->account_name->TooltipValue = "";

			// bankname
			$this->bankname->LinkCustomAttributes = "";
			$this->bankname->HrefValue = "";
			$this->bankname->TooltipValue = "";

			// pension_name
			$this->pension_name->LinkCustomAttributes = "";
			$this->pension_name->HrefValue = "";
			$this->pension_name->TooltipValue = "";

			// pension_owner
			$this->pension_owner->LinkCustomAttributes = "";
			$this->pension_owner->HrefValue = "";
			$this->pension_owner->TooltipValue = "";

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
		$item->Body = "<a id=\"emf_assets_tb\" href=\"javascript:void(0);\" class=\"ewExportLink ewEmail\" data-caption=\"" . $Language->Phrase("ExportToEmailText") . "\" onclick=\"ew_EmailDialogShow({lnk:'emf_assets_tb',hdr:ewLanguage.Phrase('ExportToEmail'),f:document.fassets_tblist,sel:false});\">" . $Language->Phrase("ExportToEmail") . "</a>";
		$item->Visible = TRUE;

		// Drop down button for export
		$this->ExportOptions->UseDropDownButton = TRUE;
		$this->ExportOptions->DropDownButtonPhrase = $Language->Phrase("ButtonExport");

		// Add group option item
		$item = &$this->ExportOptions->Add($this->ExportOptions->GroupOptionName);
		$item->Body = "";
		$item->Visible = FALSE;
	}

	// Export data in HTML/CSV/Word/Excel/XML/Email/PDF format
	function ExportData() {
		$utf8 = (strtolower(EW_CHARSET) == "utf-8");
		$bSelectLimit = EW_SELECT_LIMIT;

		// Load recordset
		if ($bSelectLimit) {
			$this->TotalRecs = $this->SelectRecordCount();
		} else {
			if ($rs = $this->LoadRecordset())
				$this->TotalRecs = $rs->RecordCount();
		}
		$this->StartRec = 1;

		// Export all
		if ($this->ExportAll) {
			set_time_limit(EW_EXPORT_ALL_TIME_LIMIT);
			$this->DisplayRecs = $this->TotalRecs;
			$this->StopRec = $this->TotalRecs;
		} else { // Export one page only
			$this->SetUpStartRec(); // Set up start record position

			// Set the last record to display
			if ($this->DisplayRecs <= 0) {
				$this->StopRec = $this->TotalRecs;
			} else {
				$this->StopRec = $this->StartRec + $this->DisplayRecs - 1;
			}
		}
		if ($bSelectLimit)
			$rs = $this->LoadRecordset($this->StartRec-1, $this->DisplayRecs <= 0 ? $this->TotalRecs : $this->DisplayRecs);
		if (!$rs) {
			header("Content-Type:"); // Remove header
			header("Content-Disposition:");
			$this->ShowMessage();
			return;
		}
		$ExportDoc = ew_ExportDocument($this, "h");
		$ParentTable = "";

		// Export master record
		if (EW_EXPORT_MASTER_RECORD && $this->GetMasterFilter() <> "" && $this->getCurrentMasterTable() == "beneficiary_dump") {
			global $beneficiary_dump;
			$rsmaster = $beneficiary_dump->LoadRs($this->DbMasterFilter); // Load master record
			if ($rsmaster && !$rsmaster->EOF) {
				$ExportStyle = $ExportDoc->Style;
				$ExportDoc->SetStyle("v"); // Change to vertical
				if ($this->Export <> "csv" || EW_EXPORT_MASTER_RECORD_FOR_CSV) {
					$beneficiary_dump->ExportDocument($ExportDoc, $rsmaster, 1, 1);
					$ExportDoc->ExportEmptyRow();
				}
				$ExportDoc->SetStyle($ExportStyle); // Restore
				$rsmaster->Close();
			}
		}

		// Export master record
		if (EW_EXPORT_MASTER_RECORD && $this->GetMasterFilter() <> "" && $this->getCurrentMasterTable() == "comprehensivewill_tb") {
			global $comprehensivewill_tb;
			$rsmaster = $comprehensivewill_tb->LoadRs($this->DbMasterFilter); // Load master record
			if ($rsmaster && !$rsmaster->EOF) {
				$ExportStyle = $ExportDoc->Style;
				$ExportDoc->SetStyle("v"); // Change to vertical
				if ($this->Export <> "csv" || EW_EXPORT_MASTER_RECORD_FOR_CSV) {
					$comprehensivewill_tb->ExportDocument($ExportDoc, $rsmaster, 1, 1);
					$ExportDoc->ExportEmptyRow();
				}
				$ExportDoc->SetStyle($ExportStyle); // Restore
				$rsmaster->Close();
			}
		}

		// Export master record
		if (EW_EXPORT_MASTER_RECORD && $this->GetMasterFilter() <> "" && $this->getCurrentMasterTable() == "premiumwill_tb") {
			global $premiumwill_tb;
			$rsmaster = $premiumwill_tb->LoadRs($this->DbMasterFilter); // Load master record
			if ($rsmaster && !$rsmaster->EOF) {
				$ExportStyle = $ExportDoc->Style;
				$ExportDoc->SetStyle("v"); // Change to vertical
				if ($this->Export <> "csv" || EW_EXPORT_MASTER_RECORD_FOR_CSV) {
					$premiumwill_tb->ExportDocument($ExportDoc, $rsmaster, 1, 1);
					$ExportDoc->ExportEmptyRow();
				}
				$ExportDoc->SetStyle($ExportStyle); // Restore
				$rsmaster->Close();
			}
		}

		// Export master record
		if (EW_EXPORT_MASTER_RECORD && $this->GetMasterFilter() <> "" && $this->getCurrentMasterTable() == "personal_info") {
			global $personal_info;
			$rsmaster = $personal_info->LoadRs($this->DbMasterFilter); // Load master record
			if ($rsmaster && !$rsmaster->EOF) {
				$ExportStyle = $ExportDoc->Style;
				$ExportDoc->SetStyle("v"); // Change to vertical
				if ($this->Export <> "csv" || EW_EXPORT_MASTER_RECORD_FOR_CSV) {
					$personal_info->ExportDocument($ExportDoc, $rsmaster, 1, 1);
					$ExportDoc->ExportEmptyRow();
				}
				$ExportDoc->SetStyle($ExportStyle); // Restore
				$rsmaster->Close();
			}
		}

		// Export master record
		if (EW_EXPORT_MASTER_RECORD && $this->GetMasterFilter() <> "" && $this->getCurrentMasterTable() == "privatetrust_tb") {
			global $privatetrust_tb;
			$rsmaster = $privatetrust_tb->LoadRs($this->DbMasterFilter); // Load master record
			if ($rsmaster && !$rsmaster->EOF) {
				$ExportStyle = $ExportDoc->Style;
				$ExportDoc->SetStyle("v"); // Change to vertical
				if ($this->Export <> "csv" || EW_EXPORT_MASTER_RECORD_FOR_CSV) {
					$privatetrust_tb->ExportDocument($ExportDoc, $rsmaster, 1, 1);
					$ExportDoc->ExportEmptyRow();
				}
				$ExportDoc->SetStyle($ExportStyle); // Restore
				$rsmaster->Close();
			}
		}
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
		$this->ExportDocument($ExportDoc, $rs, $StartRec, $StopRec, "");
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

		// Build QueryString for search
		if ($this->BasicSearch->getKeyword() <> "") {
			$sQry .= "&" . EW_TABLE_BASIC_SEARCH . "=" . urlencode($this->BasicSearch->getKeyword()) . "&" . EW_TABLE_BASIC_SEARCH_TYPE . "=" . urlencode($this->BasicSearch->getType());
		}

		// Build QueryString for pager
		$sQry .= "&" . EW_TABLE_REC_PER_PAGE . "=" . urlencode($this->getRecordsPerPage()) . "&" . EW_TABLE_START_REC . "=" . urlencode($this->getStartRecordNumber());
		return $sQry;
	}

	// Add search QueryString
	function AddSearchQueryString(&$Qry, &$Fld) {
		$FldSearchValue = $Fld->AdvancedSearch->getValue("x");
		$FldParm = substr($Fld->FldVar,2);
		if (strval($FldSearchValue) <> "") {
			$Qry .= "&x_" . $FldParm . "=" . urlencode($FldSearchValue) .
				"&z_" . $FldParm . "=" . urlencode($Fld->AdvancedSearch->getValue("z"));
		}
		$FldSearchValue2 = $Fld->AdvancedSearch->getValue("y");
		if (strval($FldSearchValue2) <> "") {
			$Qry .= "&v_" . $FldParm . "=" . urlencode($Fld->AdvancedSearch->getValue("v")) .
				"&y_" . $FldParm . "=" . urlencode($FldSearchValue2) .
				"&w_" . $FldParm . "=" . urlencode($Fld->AdvancedSearch->getValue("w"));
		}
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
			if ($sMasterTblVar == "beneficiary_dump") {
				$bValidMaster = TRUE;
				if (@$_GET["uid"] <> "") {
					$GLOBALS["beneficiary_dump"]->uid->setQueryStringValue($_GET["uid"]);
					$this->uid->setQueryStringValue($GLOBALS["beneficiary_dump"]->uid->QueryStringValue);
					$this->uid->setSessionValue($this->uid->QueryStringValue);
					if (!is_numeric($GLOBALS["beneficiary_dump"]->uid->QueryStringValue)) $bValidMaster = FALSE;
				} else {
					$bValidMaster = FALSE;
				}
			}
			if ($sMasterTblVar == "comprehensivewill_tb") {
				$bValidMaster = TRUE;
				if (@$_GET["uid"] <> "") {
					$GLOBALS["comprehensivewill_tb"]->uid->setQueryStringValue($_GET["uid"]);
					$this->uid->setQueryStringValue($GLOBALS["comprehensivewill_tb"]->uid->QueryStringValue);
					$this->uid->setSessionValue($this->uid->QueryStringValue);
					if (!is_numeric($GLOBALS["comprehensivewill_tb"]->uid->QueryStringValue)) $bValidMaster = FALSE;
				} else {
					$bValidMaster = FALSE;
				}
			}
			if ($sMasterTblVar == "premiumwill_tb") {
				$bValidMaster = TRUE;
				if (@$_GET["uid"] <> "") {
					$GLOBALS["premiumwill_tb"]->uid->setQueryStringValue($_GET["uid"]);
					$this->uid->setQueryStringValue($GLOBALS["premiumwill_tb"]->uid->QueryStringValue);
					$this->uid->setSessionValue($this->uid->QueryStringValue);
					if (!is_numeric($GLOBALS["premiumwill_tb"]->uid->QueryStringValue)) $bValidMaster = FALSE;
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
			if ($sMasterTblVar == "privatetrust_tb") {
				$bValidMaster = TRUE;
				if (@$_GET["uid"] <> "") {
					$GLOBALS["privatetrust_tb"]->uid->setQueryStringValue($_GET["uid"]);
					$this->uid->setQueryStringValue($GLOBALS["privatetrust_tb"]->uid->QueryStringValue);
					$this->uid->setSessionValue($this->uid->QueryStringValue);
					if (!is_numeric($GLOBALS["privatetrust_tb"]->uid->QueryStringValue)) $bValidMaster = FALSE;
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
			if ($sMasterTblVar <> "beneficiary_dump") {
				if ($this->uid->QueryStringValue == "") $this->uid->setSessionValue("");
			}
			if ($sMasterTblVar <> "comprehensivewill_tb") {
				if ($this->uid->QueryStringValue == "") $this->uid->setSessionValue("");
			}
			if ($sMasterTblVar <> "premiumwill_tb") {
				if ($this->uid->QueryStringValue == "") $this->uid->setSessionValue("");
			}
			if ($sMasterTblVar <> "personal_info") {
				if ($this->uid->QueryStringValue == "") $this->uid->setSessionValue("");
			}
			if ($sMasterTblVar <> "privatetrust_tb") {
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
		$url = ew_CurrentUrl();
		$url = preg_replace('/\?cmd=reset(all){0,1}$/i', '', $url); // Remove cmd=reset / cmd=resetall
		$Breadcrumb->Add("list", "<span id=\"ewPageCaption\">" . $PageCaption . "</span>", $url, $this->TableVar);
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

	// ListOptions Load event
	function ListOptions_Load() {

		// Example:
		//$opt = &$this->ListOptions->Add("new");
		//$opt->Header = "xxx";
		//$opt->OnLeft = TRUE; // Link on left
		//$opt->MoveTo(0); // Move to first column

	}

	// ListOptions Rendered event
	function ListOptions_Rendered() {

		// Example: 
		//$this->ListOptions->Items["new"]->Body = "xxx";

	}

	// Row Custom Action event
	function Row_CustomAction($action, $row) {

		// Return FALSE to abort
		return TRUE;
	}
}
?>
<?php ew_Header(FALSE) ?>
<?php

// Create page object
if (!isset($assets_tb_list)) $assets_tb_list = new cassets_tb_list();

// Page init
$assets_tb_list->Page_Init();

// Page main
$assets_tb_list->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$assets_tb_list->Page_Render();
?>
<?php include_once "header.php" ?>
<?php if ($assets_tb->Export == "") { ?>
<script type="text/javascript">

// Page object
var assets_tb_list = new ew_Page("assets_tb_list");
assets_tb_list.PageID = "list"; // Page ID
var EW_PAGE_ID = assets_tb_list.PageID; // For backward compatibility

// Form object
var fassets_tblist = new ew_Form("fassets_tblist");
fassets_tblist.FormKeyCountName = '<?php echo $assets_tb_list->FormKeyCountName ?>';

// Form_CustomValidate event
fassets_tblist.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
fassets_tblist.ValidateRequired = true;
<?php } else { ?>
fassets_tblist.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
// Form object for search

var fassets_tblistsrch = new ew_Form("fassets_tblistsrch");
</script>
<style type="text/css">

/* main table preview row color */
.ewTablePreviewRow {
	background-color: #FFFFFF; /* preview row color */
}
.ewPreviewRowImage {
    min-width: 9px; /* for Chrome */
}
</style>
<div id="ewPreview" class="hide"><ul class="nav nav-tabs"></ul><div class="tab-content"><div class="tab-pane fade"></div></div></div>
<script type="text/javascript" src="phpjs/ewpreview.min.js"></script>
<script type="text/javascript">
var EW_PREVIEW_PLACEMENT = "left";
var EW_PREVIEW_SINGLE_ROW = false;
var EW_PREVIEW_OVERLAY = false;
</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<?php } ?>
<?php if ($assets_tb->Export == "") { ?>
<?php $Breadcrumb->Render(); ?>
<?php } ?>
<?php if ($assets_tb->getCurrentMasterTable() == "" && $assets_tb_list->ExportOptions->Visible()) { ?>
<div class="ewListExportOptions"><?php $assets_tb_list->ExportOptions->Render("body") ?></div>
<?php } ?>
<?php if (($assets_tb->Export == "") || (EW_EXPORT_MASTER_RECORD && $assets_tb->Export == "print")) { ?>
<?php
$gsMasterReturnUrl = "beneficiary_dumplist.php";
if ($assets_tb_list->DbMasterFilter <> "" && $assets_tb->getCurrentMasterTable() == "beneficiary_dump") {
	if ($assets_tb_list->MasterRecordExists) {
		if ($assets_tb->getCurrentMasterTable() == $assets_tb->TableVar) $gsMasterReturnUrl .= "?" . EW_TABLE_SHOW_MASTER . "=";
?>
<?php if ($assets_tb_list->ExportOptions->Visible()) { ?>
<div class="ewListExportOptions"><?php $assets_tb_list->ExportOptions->Render("body") ?></div>
<?php } ?>
<?php include_once "beneficiary_dumpmaster.php" ?>
<?php
	}
}
?>
<?php
$gsMasterReturnUrl = "comprehensivewill_tblist.php";
if ($assets_tb_list->DbMasterFilter <> "" && $assets_tb->getCurrentMasterTable() == "comprehensivewill_tb") {
	if ($assets_tb_list->MasterRecordExists) {
		if ($assets_tb->getCurrentMasterTable() == $assets_tb->TableVar) $gsMasterReturnUrl .= "?" . EW_TABLE_SHOW_MASTER . "=";
?>
<?php if ($assets_tb_list->ExportOptions->Visible()) { ?>
<div class="ewListExportOptions"><?php $assets_tb_list->ExportOptions->Render("body") ?></div>
<?php } ?>
<?php include_once "comprehensivewill_tbmaster.php" ?>
<?php
	}
}
?>
<?php
$gsMasterReturnUrl = "premiumwill_tblist.php";
if ($assets_tb_list->DbMasterFilter <> "" && $assets_tb->getCurrentMasterTable() == "premiumwill_tb") {
	if ($assets_tb_list->MasterRecordExists) {
		if ($assets_tb->getCurrentMasterTable() == $assets_tb->TableVar) $gsMasterReturnUrl .= "?" . EW_TABLE_SHOW_MASTER . "=";
?>
<?php if ($assets_tb_list->ExportOptions->Visible()) { ?>
<div class="ewListExportOptions"><?php $assets_tb_list->ExportOptions->Render("body") ?></div>
<?php } ?>
<?php include_once "premiumwill_tbmaster.php" ?>
<?php
	}
}
?>
<?php
$gsMasterReturnUrl = "personal_infolist.php";
if ($assets_tb_list->DbMasterFilter <> "" && $assets_tb->getCurrentMasterTable() == "personal_info") {
	if ($assets_tb_list->MasterRecordExists) {
		if ($assets_tb->getCurrentMasterTable() == $assets_tb->TableVar) $gsMasterReturnUrl .= "?" . EW_TABLE_SHOW_MASTER . "=";
?>
<?php if ($assets_tb_list->ExportOptions->Visible()) { ?>
<div class="ewListExportOptions"><?php $assets_tb_list->ExportOptions->Render("body") ?></div>
<?php } ?>
<?php include_once "personal_infomaster.php" ?>
<?php
	}
}
?>
<?php
$gsMasterReturnUrl = "privatetrust_tblist.php";
if ($assets_tb_list->DbMasterFilter <> "" && $assets_tb->getCurrentMasterTable() == "privatetrust_tb") {
	if ($assets_tb_list->MasterRecordExists) {
		if ($assets_tb->getCurrentMasterTable() == $assets_tb->TableVar) $gsMasterReturnUrl .= "?" . EW_TABLE_SHOW_MASTER . "=";
?>
<?php if ($assets_tb_list->ExportOptions->Visible()) { ?>
<div class="ewListExportOptions"><?php $assets_tb_list->ExportOptions->Render("body") ?></div>
<?php } ?>
<?php include_once "privatetrust_tbmaster.php" ?>
<?php
	}
}
?>
<?php } ?>
<?php
	$bSelectLimit = EW_SELECT_LIMIT;
	if ($bSelectLimit) {
		$assets_tb_list->TotalRecs = $assets_tb->SelectRecordCount();
	} else {
		if ($assets_tb_list->Recordset = $assets_tb_list->LoadRecordset())
			$assets_tb_list->TotalRecs = $assets_tb_list->Recordset->RecordCount();
	}
	$assets_tb_list->StartRec = 1;
	if ($assets_tb_list->DisplayRecs <= 0 || ($assets_tb->Export <> "" && $assets_tb->ExportAll)) // Display all records
		$assets_tb_list->DisplayRecs = $assets_tb_list->TotalRecs;
	if (!($assets_tb->Export <> "" && $assets_tb->ExportAll))
		$assets_tb_list->SetUpStartRec(); // Set up start record position
	if ($bSelectLimit)
		$assets_tb_list->Recordset = $assets_tb_list->LoadRecordset($assets_tb_list->StartRec-1, $assets_tb_list->DisplayRecs);
$assets_tb_list->RenderOtherOptions();
?>
<?php if ($Security->IsLoggedIn()) { ?>
<?php if ($assets_tb->Export == "" && $assets_tb->CurrentAction == "") { ?>
<form name="fassets_tblistsrch" id="fassets_tblistsrch" class="ewForm form-inline" action="<?php echo ew_CurrentPage() ?>">
<table class="ewSearchTable"><tr><td>
<div class="accordion" id="fassets_tblistsrch_SearchGroup">
	<div class="accordion-group">
		<div class="accordion-heading">
<a class="accordion-toggle" data-toggle="collapse" data-parent="#fassets_tblistsrch_SearchGroup" href="#fassets_tblistsrch_SearchBody"><?php echo $Language->Phrase("Search") ?></a>
		</div>
		<div id="fassets_tblistsrch_SearchBody" class="accordion-body collapse in">
			<div class="accordion-inner">
<div id="fassets_tblistsrch_SearchPanel">
<input type="hidden" name="cmd" value="search">
<input type="hidden" name="t" value="assets_tb">
<div class="ewBasicSearch">
<div id="xsr_1" class="ewRow">
	<div class="btn-group ewButtonGroup">
	<div class="input-append">
	<input type="text" name="<?php echo EW_TABLE_BASIC_SEARCH ?>" id="<?php echo EW_TABLE_BASIC_SEARCH ?>" class="input-large" value="<?php echo ew_HtmlEncode($assets_tb_list->BasicSearch->getKeyword()) ?>" placeholder="<?php echo $Language->Phrase("Search") ?>">
	<button class="btn btn-primary ewButton" name="btnsubmit" id="btnsubmit" type="submit"><?php echo $Language->Phrase("QuickSearchBtn") ?></button>
	</div>
	</div>
	<div class="btn-group ewButtonGroup">
	<a class="btn ewShowAll" href="<?php echo $assets_tb_list->PageUrl() ?>cmd=reset"><?php echo $Language->Phrase("ShowAll") ?></a>
</div>
<div id="xsr_2" class="ewRow">
	<label class="inline radio ewRadio" style="white-space: nowrap;"><input type="radio" name="<?php echo EW_TABLE_BASIC_SEARCH_TYPE ?>" value="="<?php if ($assets_tb_list->BasicSearch->getType() == "=") { ?> checked="checked"<?php } ?>><?php echo $Language->Phrase("ExactPhrase") ?></label>
	<label class="inline radio ewRadio" style="white-space: nowrap;"><input type="radio" name="<?php echo EW_TABLE_BASIC_SEARCH_TYPE ?>" value="AND"<?php if ($assets_tb_list->BasicSearch->getType() == "AND") { ?> checked="checked"<?php } ?>><?php echo $Language->Phrase("AllWord") ?></label>
	<label class="inline radio ewRadio" style="white-space: nowrap;"><input type="radio" name="<?php echo EW_TABLE_BASIC_SEARCH_TYPE ?>" value="OR"<?php if ($assets_tb_list->BasicSearch->getType() == "OR") { ?> checked="checked"<?php } ?>><?php echo $Language->Phrase("AnyWord") ?></label>
</div>
</div>
</div>
			</div>
		</div>
	</div>
</div>
</td></tr></table>
</form>
<?php } ?>
<?php } ?>
<?php $assets_tb_list->ShowPageHeader(); ?>
<?php
$assets_tb_list->ShowMessage();
?>
<table cellspacing="0" class="ewGrid"><tr><td class="ewGridContent">
<form name="fassets_tblist" id="fassets_tblist" class="ewForm form-horizontal" action="<?php echo ew_CurrentPage() ?>" method="post">
<input type="hidden" name="t" value="assets_tb">
<div id="gmp_assets_tb" class="ewGridMiddlePanel">
<?php if ($assets_tb_list->TotalRecs > 0) { ?>
<table id="tbl_assets_tblist" class="ewTable ewTableSeparate">
<?php echo $assets_tb->TableCustomInnerHtml ?>
<thead><!-- Table header -->
	<tr class="ewTableHeader">
<?php

// Render list options
$assets_tb_list->RenderListOptions();

// Render list options (header, left)
$assets_tb_list->ListOptions->Render("header", "left");
?>
<?php if ($assets_tb->id->Visible) { // id ?>
	<?php if ($assets_tb->SortUrl($assets_tb->id) == "") { ?>
		<td><div id="elh_assets_tb_id" class="assets_tb_id"><div class="ewTableHeaderCaption"><?php echo $assets_tb->id->FldCaption() ?></div></div></td>
	<?php } else { ?>
		<td><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $assets_tb->SortUrl($assets_tb->id) ?>',2);"><div id="elh_assets_tb_id" class="assets_tb_id">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $assets_tb->id->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($assets_tb->id->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($assets_tb->id->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></td>
	<?php } ?>
<?php } ?>		
<?php if ($assets_tb->asset_type->Visible) { // asset_type ?>
	<?php if ($assets_tb->SortUrl($assets_tb->asset_type) == "") { ?>
		<td><div id="elh_assets_tb_asset_type" class="assets_tb_asset_type"><div class="ewTableHeaderCaption"><?php echo $assets_tb->asset_type->FldCaption() ?></div></div></td>
	<?php } else { ?>
		<td><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $assets_tb->SortUrl($assets_tb->asset_type) ?>',2);"><div id="elh_assets_tb_asset_type" class="assets_tb_asset_type">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $assets_tb->asset_type->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($assets_tb->asset_type->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($assets_tb->asset_type->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></td>
	<?php } ?>
<?php } ?>		
<?php if ($assets_tb->property_location->Visible) { // property_location ?>
	<?php if ($assets_tb->SortUrl($assets_tb->property_location) == "") { ?>
		<td><div id="elh_assets_tb_property_location" class="assets_tb_property_location"><div class="ewTableHeaderCaption"><?php echo $assets_tb->property_location->FldCaption() ?></div></div></td>
	<?php } else { ?>
		<td><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $assets_tb->SortUrl($assets_tb->property_location) ?>',2);"><div id="elh_assets_tb_property_location" class="assets_tb_property_location">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $assets_tb->property_location->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($assets_tb->property_location->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($assets_tb->property_location->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></td>
	<?php } ?>
<?php } ?>		
<?php if ($assets_tb->property_type->Visible) { // property_type ?>
	<?php if ($assets_tb->SortUrl($assets_tb->property_type) == "") { ?>
		<td><div id="elh_assets_tb_property_type" class="assets_tb_property_type"><div class="ewTableHeaderCaption"><?php echo $assets_tb->property_type->FldCaption() ?></div></div></td>
	<?php } else { ?>
		<td><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $assets_tb->SortUrl($assets_tb->property_type) ?>',2);"><div id="elh_assets_tb_property_type" class="assets_tb_property_type">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $assets_tb->property_type->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($assets_tb->property_type->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($assets_tb->property_type->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></td>
	<?php } ?>
<?php } ?>		
<?php if ($assets_tb->shares_company->Visible) { // shares_company ?>
	<?php if ($assets_tb->SortUrl($assets_tb->shares_company) == "") { ?>
		<td><div id="elh_assets_tb_shares_company" class="assets_tb_shares_company"><div class="ewTableHeaderCaption"><?php echo $assets_tb->shares_company->FldCaption() ?></div></div></td>
	<?php } else { ?>
		<td><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $assets_tb->SortUrl($assets_tb->shares_company) ?>',2);"><div id="elh_assets_tb_shares_company" class="assets_tb_shares_company">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $assets_tb->shares_company->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($assets_tb->shares_company->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($assets_tb->shares_company->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></td>
	<?php } ?>
<?php } ?>		
<?php if ($assets_tb->insurance_company->Visible) { // insurance_company ?>
	<?php if ($assets_tb->SortUrl($assets_tb->insurance_company) == "") { ?>
		<td><div id="elh_assets_tb_insurance_company" class="assets_tb_insurance_company"><div class="ewTableHeaderCaption"><?php echo $assets_tb->insurance_company->FldCaption() ?></div></div></td>
	<?php } else { ?>
		<td><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $assets_tb->SortUrl($assets_tb->insurance_company) ?>',2);"><div id="elh_assets_tb_insurance_company" class="assets_tb_insurance_company">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $assets_tb->insurance_company->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($assets_tb->insurance_company->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($assets_tb->insurance_company->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></td>
	<?php } ?>
<?php } ?>		
<?php if ($assets_tb->insurance_type->Visible) { // insurance_type ?>
	<?php if ($assets_tb->SortUrl($assets_tb->insurance_type) == "") { ?>
		<td><div id="elh_assets_tb_insurance_type" class="assets_tb_insurance_type"><div class="ewTableHeaderCaption"><?php echo $assets_tb->insurance_type->FldCaption() ?></div></div></td>
	<?php } else { ?>
		<td><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $assets_tb->SortUrl($assets_tb->insurance_type) ?>',2);"><div id="elh_assets_tb_insurance_type" class="assets_tb_insurance_type">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $assets_tb->insurance_type->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($assets_tb->insurance_type->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($assets_tb->insurance_type->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></td>
	<?php } ?>
<?php } ?>		
<?php if ($assets_tb->account_name->Visible) { // account_name ?>
	<?php if ($assets_tb->SortUrl($assets_tb->account_name) == "") { ?>
		<td><div id="elh_assets_tb_account_name" class="assets_tb_account_name"><div class="ewTableHeaderCaption"><?php echo $assets_tb->account_name->FldCaption() ?></div></div></td>
	<?php } else { ?>
		<td><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $assets_tb->SortUrl($assets_tb->account_name) ?>',2);"><div id="elh_assets_tb_account_name" class="assets_tb_account_name">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $assets_tb->account_name->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($assets_tb->account_name->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($assets_tb->account_name->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></td>
	<?php } ?>
<?php } ?>		
<?php if ($assets_tb->bankname->Visible) { // bankname ?>
	<?php if ($assets_tb->SortUrl($assets_tb->bankname) == "") { ?>
		<td><div id="elh_assets_tb_bankname" class="assets_tb_bankname"><div class="ewTableHeaderCaption"><?php echo $assets_tb->bankname->FldCaption() ?></div></div></td>
	<?php } else { ?>
		<td><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $assets_tb->SortUrl($assets_tb->bankname) ?>',2);"><div id="elh_assets_tb_bankname" class="assets_tb_bankname">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $assets_tb->bankname->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($assets_tb->bankname->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($assets_tb->bankname->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></td>
	<?php } ?>
<?php } ?>		
<?php if ($assets_tb->pension_name->Visible) { // pension_name ?>
	<?php if ($assets_tb->SortUrl($assets_tb->pension_name) == "") { ?>
		<td><div id="elh_assets_tb_pension_name" class="assets_tb_pension_name"><div class="ewTableHeaderCaption"><?php echo $assets_tb->pension_name->FldCaption() ?></div></div></td>
	<?php } else { ?>
		<td><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $assets_tb->SortUrl($assets_tb->pension_name) ?>',2);"><div id="elh_assets_tb_pension_name" class="assets_tb_pension_name">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $assets_tb->pension_name->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($assets_tb->pension_name->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($assets_tb->pension_name->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></td>
	<?php } ?>
<?php } ?>		
<?php if ($assets_tb->pension_owner->Visible) { // pension_owner ?>
	<?php if ($assets_tb->SortUrl($assets_tb->pension_owner) == "") { ?>
		<td><div id="elh_assets_tb_pension_owner" class="assets_tb_pension_owner"><div class="ewTableHeaderCaption"><?php echo $assets_tb->pension_owner->FldCaption() ?></div></div></td>
	<?php } else { ?>
		<td><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $assets_tb->SortUrl($assets_tb->pension_owner) ?>',2);"><div id="elh_assets_tb_pension_owner" class="assets_tb_pension_owner">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $assets_tb->pension_owner->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($assets_tb->pension_owner->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($assets_tb->pension_owner->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></td>
	<?php } ?>
<?php } ?>		
<?php if ($assets_tb->datecreated->Visible) { // datecreated ?>
	<?php if ($assets_tb->SortUrl($assets_tb->datecreated) == "") { ?>
		<td><div id="elh_assets_tb_datecreated" class="assets_tb_datecreated"><div class="ewTableHeaderCaption"><?php echo $assets_tb->datecreated->FldCaption() ?></div></div></td>
	<?php } else { ?>
		<td><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $assets_tb->SortUrl($assets_tb->datecreated) ?>',2);"><div id="elh_assets_tb_datecreated" class="assets_tb_datecreated">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $assets_tb->datecreated->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($assets_tb->datecreated->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($assets_tb->datecreated->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></td>
	<?php } ?>
<?php } ?>		
<?php

// Render list options (header, right)
$assets_tb_list->ListOptions->Render("header", "right");
?>
	</tr>
</thead>
<tbody>
<?php
if ($assets_tb->ExportAll && $assets_tb->Export <> "") {
	$assets_tb_list->StopRec = $assets_tb_list->TotalRecs;
} else {

	// Set the last record to display
	if ($assets_tb_list->TotalRecs > $assets_tb_list->StartRec + $assets_tb_list->DisplayRecs - 1)
		$assets_tb_list->StopRec = $assets_tb_list->StartRec + $assets_tb_list->DisplayRecs - 1;
	else
		$assets_tb_list->StopRec = $assets_tb_list->TotalRecs;
}
$assets_tb_list->RecCnt = $assets_tb_list->StartRec - 1;
if ($assets_tb_list->Recordset && !$assets_tb_list->Recordset->EOF) {
	$assets_tb_list->Recordset->MoveFirst();
	if (!$bSelectLimit && $assets_tb_list->StartRec > 1)
		$assets_tb_list->Recordset->Move($assets_tb_list->StartRec - 1);
} elseif (!$assets_tb->AllowAddDeleteRow && $assets_tb_list->StopRec == 0) {
	$assets_tb_list->StopRec = $assets_tb->GridAddRowCount;
}

// Initialize aggregate
$assets_tb->RowType = EW_ROWTYPE_AGGREGATEINIT;
$assets_tb->ResetAttrs();
$assets_tb_list->RenderRow();
while ($assets_tb_list->RecCnt < $assets_tb_list->StopRec) {
	$assets_tb_list->RecCnt++;
	if (intval($assets_tb_list->RecCnt) >= intval($assets_tb_list->StartRec)) {
		$assets_tb_list->RowCnt++;

		// Set up key count
		$assets_tb_list->KeyCount = $assets_tb_list->RowIndex;

		// Init row class and style
		$assets_tb->ResetAttrs();
		$assets_tb->CssClass = "";
		if ($assets_tb->CurrentAction == "gridadd") {
		} else {
			$assets_tb_list->LoadRowValues($assets_tb_list->Recordset); // Load row values
		}
		$assets_tb->RowType = EW_ROWTYPE_VIEW; // Render view

		// Set up row id / data-rowindex
		$assets_tb->RowAttrs = array_merge($assets_tb->RowAttrs, array('data-rowindex'=>$assets_tb_list->RowCnt, 'id'=>'r' . $assets_tb_list->RowCnt . '_assets_tb', 'data-rowtype'=>$assets_tb->RowType));

		// Render row
		$assets_tb_list->RenderRow();

		// Render list options
		$assets_tb_list->RenderListOptions();
?>
	<tr<?php echo $assets_tb->RowAttributes() ?>>
<?php

// Render list options (body, left)
$assets_tb_list->ListOptions->Render("body", "left", $assets_tb_list->RowCnt);
?>
	<?php if ($assets_tb->id->Visible) { // id ?>
		<td<?php echo $assets_tb->id->CellAttributes() ?>>
<span<?php echo $assets_tb->id->ViewAttributes() ?>>
<?php echo $assets_tb->id->ListViewValue() ?></span>
<a id="<?php echo $assets_tb_list->PageObjName . "_row_" . $assets_tb_list->RowCnt ?>"></a></td>
	<?php } ?>
	<?php if ($assets_tb->asset_type->Visible) { // asset_type ?>
		<td<?php echo $assets_tb->asset_type->CellAttributes() ?>>
<span<?php echo $assets_tb->asset_type->ViewAttributes() ?>>
<?php echo $assets_tb->asset_type->ListViewValue() ?></span>
<a id="<?php echo $assets_tb_list->PageObjName . "_row_" . $assets_tb_list->RowCnt ?>"></a></td>
	<?php } ?>
	<?php if ($assets_tb->property_location->Visible) { // property_location ?>
		<td<?php echo $assets_tb->property_location->CellAttributes() ?>>
<span<?php echo $assets_tb->property_location->ViewAttributes() ?>>
<?php echo $assets_tb->property_location->ListViewValue() ?></span>
<a id="<?php echo $assets_tb_list->PageObjName . "_row_" . $assets_tb_list->RowCnt ?>"></a></td>
	<?php } ?>
	<?php if ($assets_tb->property_type->Visible) { // property_type ?>
		<td<?php echo $assets_tb->property_type->CellAttributes() ?>>
<span<?php echo $assets_tb->property_type->ViewAttributes() ?>>
<?php echo $assets_tb->property_type->ListViewValue() ?></span>
<a id="<?php echo $assets_tb_list->PageObjName . "_row_" . $assets_tb_list->RowCnt ?>"></a></td>
	<?php } ?>
	<?php if ($assets_tb->shares_company->Visible) { // shares_company ?>
		<td<?php echo $assets_tb->shares_company->CellAttributes() ?>>
<span<?php echo $assets_tb->shares_company->ViewAttributes() ?>>
<?php echo $assets_tb->shares_company->ListViewValue() ?></span>
<a id="<?php echo $assets_tb_list->PageObjName . "_row_" . $assets_tb_list->RowCnt ?>"></a></td>
	<?php } ?>
	<?php if ($assets_tb->insurance_company->Visible) { // insurance_company ?>
		<td<?php echo $assets_tb->insurance_company->CellAttributes() ?>>
<span<?php echo $assets_tb->insurance_company->ViewAttributes() ?>>
<?php echo $assets_tb->insurance_company->ListViewValue() ?></span>
<a id="<?php echo $assets_tb_list->PageObjName . "_row_" . $assets_tb_list->RowCnt ?>"></a></td>
	<?php } ?>
	<?php if ($assets_tb->insurance_type->Visible) { // insurance_type ?>
		<td<?php echo $assets_tb->insurance_type->CellAttributes() ?>>
<span<?php echo $assets_tb->insurance_type->ViewAttributes() ?>>
<?php echo $assets_tb->insurance_type->ListViewValue() ?></span>
<a id="<?php echo $assets_tb_list->PageObjName . "_row_" . $assets_tb_list->RowCnt ?>"></a></td>
	<?php } ?>
	<?php if ($assets_tb->account_name->Visible) { // account_name ?>
		<td<?php echo $assets_tb->account_name->CellAttributes() ?>>
<span<?php echo $assets_tb->account_name->ViewAttributes() ?>>
<?php echo $assets_tb->account_name->ListViewValue() ?></span>
<a id="<?php echo $assets_tb_list->PageObjName . "_row_" . $assets_tb_list->RowCnt ?>"></a></td>
	<?php } ?>
	<?php if ($assets_tb->bankname->Visible) { // bankname ?>
		<td<?php echo $assets_tb->bankname->CellAttributes() ?>>
<span<?php echo $assets_tb->bankname->ViewAttributes() ?>>
<?php echo $assets_tb->bankname->ListViewValue() ?></span>
<a id="<?php echo $assets_tb_list->PageObjName . "_row_" . $assets_tb_list->RowCnt ?>"></a></td>
	<?php } ?>
	<?php if ($assets_tb->pension_name->Visible) { // pension_name ?>
		<td<?php echo $assets_tb->pension_name->CellAttributes() ?>>
<span<?php echo $assets_tb->pension_name->ViewAttributes() ?>>
<?php echo $assets_tb->pension_name->ListViewValue() ?></span>
<a id="<?php echo $assets_tb_list->PageObjName . "_row_" . $assets_tb_list->RowCnt ?>"></a></td>
	<?php } ?>
	<?php if ($assets_tb->pension_owner->Visible) { // pension_owner ?>
		<td<?php echo $assets_tb->pension_owner->CellAttributes() ?>>
<span<?php echo $assets_tb->pension_owner->ViewAttributes() ?>>
<?php echo $assets_tb->pension_owner->ListViewValue() ?></span>
<a id="<?php echo $assets_tb_list->PageObjName . "_row_" . $assets_tb_list->RowCnt ?>"></a></td>
	<?php } ?>
	<?php if ($assets_tb->datecreated->Visible) { // datecreated ?>
		<td<?php echo $assets_tb->datecreated->CellAttributes() ?>>
<span<?php echo $assets_tb->datecreated->ViewAttributes() ?>>
<?php echo $assets_tb->datecreated->ListViewValue() ?></span>
<a id="<?php echo $assets_tb_list->PageObjName . "_row_" . $assets_tb_list->RowCnt ?>"></a></td>
	<?php } ?>
<?php

// Render list options (body, right)
$assets_tb_list->ListOptions->Render("body", "right", $assets_tb_list->RowCnt);
?>
	</tr>
<?php
	}
	if ($assets_tb->CurrentAction <> "gridadd")
		$assets_tb_list->Recordset->MoveNext();
}
?>
</tbody>
</table>
<?php } ?>
<?php if ($assets_tb->CurrentAction == "") { ?>
<input type="hidden" name="a_list" id="a_list" value="">
<?php } ?>
</div>
</form>
<?php

// Close recordset
if ($assets_tb_list->Recordset)
	$assets_tb_list->Recordset->Close();
?>
<?php if ($assets_tb->Export == "") { ?>
<div class="ewGridLowerPanel">
<?php if ($assets_tb->CurrentAction <> "gridadd" && $assets_tb->CurrentAction <> "gridedit") { ?>
<form name="ewPagerForm" class="ewForm form-horizontal" action="<?php echo ew_CurrentPage() ?>">
<table class="ewPager">
<tr><td>
<?php if (!isset($assets_tb_list->Pager)) $assets_tb_list->Pager = new cNumericPager($assets_tb_list->StartRec, $assets_tb_list->DisplayRecs, $assets_tb_list->TotalRecs, $assets_tb_list->RecRange) ?>
<?php if ($assets_tb_list->Pager->RecordCount > 0) { ?>
<table cellspacing="0" class="ewStdTable"><tbody><tr><td>
<div class="pagination"><ul>
	<?php if ($assets_tb_list->Pager->FirstButton->Enabled) { ?>
	<li><a href="<?php echo $assets_tb_list->PageUrl() ?>start=<?php echo $assets_tb_list->Pager->FirstButton->Start ?>"><?php echo $Language->Phrase("PagerFirst") ?></a></li>
	<?php } ?>
	<?php if ($assets_tb_list->Pager->PrevButton->Enabled) { ?>
	<li><a href="<?php echo $assets_tb_list->PageUrl() ?>start=<?php echo $assets_tb_list->Pager->PrevButton->Start ?>"><?php echo $Language->Phrase("PagerPrevious") ?></a></li>
	<?php } ?>
	<?php foreach ($assets_tb_list->Pager->Items as $PagerItem) { ?>
		<li<?php if (!$PagerItem->Enabled) { echo " class=\" active\""; } ?>><a href="<?php if ($PagerItem->Enabled) { echo $assets_tb_list->PageUrl() . "start=" . $PagerItem->Start; } else { echo "#"; } ?>"><?php echo $PagerItem->Text ?></a></li>
	<?php } ?>
	<?php if ($assets_tb_list->Pager->NextButton->Enabled) { ?>
	<li><a href="<?php echo $assets_tb_list->PageUrl() ?>start=<?php echo $assets_tb_list->Pager->NextButton->Start ?>"><?php echo $Language->Phrase("PagerNext") ?></a></li>
	<?php } ?>
	<?php if ($assets_tb_list->Pager->LastButton->Enabled) { ?>
	<li><a href="<?php echo $assets_tb_list->PageUrl() ?>start=<?php echo $assets_tb_list->Pager->LastButton->Start ?>"><?php echo $Language->Phrase("PagerLast") ?></a></li>
	<?php } ?>
</ul></div>
</td>
<td>
	<?php if ($assets_tb_list->Pager->ButtonCount > 0) { ?>&nbsp;&nbsp;&nbsp;&nbsp;<?php } ?>
	<?php echo $Language->Phrase("Record") ?>&nbsp;<?php echo $assets_tb_list->Pager->FromIndex ?>&nbsp;<?php echo $Language->Phrase("To") ?>&nbsp;<?php echo $assets_tb_list->Pager->ToIndex ?>&nbsp;<?php echo $Language->Phrase("Of") ?>&nbsp;<?php echo $assets_tb_list->Pager->RecordCount ?>
</td>
</tr></tbody></table>
<?php } else { ?>
	<?php if ($assets_tb_list->SearchWhere == "0=101") { ?>
	<p><?php echo $Language->Phrase("EnterSearchCriteria") ?></p>
	<?php } else { ?>
	<p><?php echo $Language->Phrase("NoRecord") ?></p>
	<?php } ?>
<?php } ?>
</td>
<?php if ($assets_tb_list->TotalRecs > 0) { ?>
<td>
	&nbsp;&nbsp;&nbsp;&nbsp;
<input type="hidden" name="t" value="assets_tb">
<select name="<?php echo EW_TABLE_REC_PER_PAGE ?>" class="input-small" onchange="this.form.submit();">
<option value="25"<?php if ($assets_tb_list->DisplayRecs == 25) { ?> selected="selected"<?php } ?>>25</option>
<option value="50"<?php if ($assets_tb_list->DisplayRecs == 50) { ?> selected="selected"<?php } ?>>50</option>
<option value="100"<?php if ($assets_tb_list->DisplayRecs == 100) { ?> selected="selected"<?php } ?>>100</option>
<option value="200"<?php if ($assets_tb_list->DisplayRecs == 200) { ?> selected="selected"<?php } ?>>200</option>
<option value="500"<?php if ($assets_tb_list->DisplayRecs == 500) { ?> selected="selected"<?php } ?>>500</option>
<option value="ALL"<?php if ($assets_tb->getRecordsPerPage() == -1) { ?> selected="selected"<?php } ?>><?php echo $Language->Phrase("AllRecords") ?></option>
</select>
</td>
<?php } ?>
</tr></table>
</form>
<?php } ?>
<div class="ewListOtherOptions">
<?php
	foreach ($assets_tb_list->OtherOptions as &$option)
		$option->Render("body", "bottom");
?>
</div>
</div>
<?php } ?>
</td></tr></table>
<?php if ($assets_tb->Export == "") { ?>
<script type="text/javascript">
fassets_tblistsrch.Init();
fassets_tblist.Init();
<?php if (EW_MOBILE_REFLOW && ew_IsMobile()) { ?>
ew_Reflow();
<?php } ?>
</script>
<?php } ?>
<?php
$assets_tb_list->ShowPageFooter();
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
$assets_tb_list->Page_Terminate();
?>
