<?php
if (session_id() == "") session_start(); // Initialize Session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg10.php" ?>
<?php include_once "ewmysql10.php" ?>
<?php include_once "phpfn10.php" ?>
<?php include_once "comprehensivewill_tbinfo.php" ?>
<?php include_once "adminusersinfo.php" ?>
<?php include_once "personal_infogridcls.php" ?>
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

$comprehensivewill_tb_list = NULL; // Initialize page object first

class ccomprehensivewill_tb_list extends ccomprehensivewill_tb {

	// Page ID
	var $PageID = 'list';

	// Project ID
	var $ProjectID = "{D9B361E7-B2C1-4293-B9B3-B581986A15CC}";

	// Table name
	var $TableName = 'comprehensivewill_tb';

	// Page object name
	var $PageObjName = 'comprehensivewill_tb_list';

	// Grid form hidden field names
	var $FormName = 'fcomprehensivewill_tblist';
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

		// Table object (comprehensivewill_tb)
		if (!isset($GLOBALS["comprehensivewill_tb"])) {
			$GLOBALS["comprehensivewill_tb"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["comprehensivewill_tb"];
		}

		// Initialize URLs
		$this->ExportPrintUrl = $this->PageUrl() . "export=print";
		$this->ExportExcelUrl = $this->PageUrl() . "export=excel";
		$this->ExportWordUrl = $this->PageUrl() . "export=word";
		$this->ExportHtmlUrl = $this->PageUrl() . "export=html";
		$this->ExportXmlUrl = $this->PageUrl() . "export=xml";
		$this->ExportCsvUrl = $this->PageUrl() . "export=csv";
		$this->ExportPdfUrl = $this->PageUrl() . "export=pdf";
		$this->AddUrl = "comprehensivewill_tbadd.php?" . EW_TABLE_SHOW_DETAIL . "=";
		$this->InlineAddUrl = $this->PageUrl() . "a=add";
		$this->GridAddUrl = $this->PageUrl() . "a=gridadd";
		$this->GridEditUrl = $this->PageUrl() . "a=gridedit";
		$this->MultiDeleteUrl = "comprehensivewill_tbdelete.php";
		$this->MultiUpdateUrl = "comprehensivewill_tbupdate.php";

		// Table object (adminusers)
		if (!isset($GLOBALS['adminusers'])) $GLOBALS['adminusers'] = new cadminusers();

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'list', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'comprehensivewill_tb', TRUE);

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
		ew_AddFilter($sFilter, $this->DbDetailFilter);
		ew_AddFilter($sFilter, $this->SearchWhere);

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
		$this->BuildBasicSearchSQL($sWhere, $this->willtype, $Keyword);
		$this->BuildBasicSearchSQL($sWhere, $this->fullname, $Keyword);
		$this->BuildBasicSearchSQL($sWhere, $this->address, $Keyword);
		$this->BuildBasicSearchSQL($sWhere, $this->_email, $Keyword);
		$this->BuildBasicSearchSQL($sWhere, $this->phoneno, $Keyword);
		$this->BuildBasicSearchSQL($sWhere, $this->aphoneno, $Keyword);
		$this->BuildBasicSearchSQL($sWhere, $this->gender, $Keyword);
		$this->BuildBasicSearchSQL($sWhere, $this->dob, $Keyword);
		$this->BuildBasicSearchSQL($sWhere, $this->state, $Keyword);
		$this->BuildBasicSearchSQL($sWhere, $this->nationality, $Keyword);
		$this->BuildBasicSearchSQL($sWhere, $this->lga, $Keyword);
		$this->BuildBasicSearchSQL($sWhere, $this->employmentstatus, $Keyword);
		$this->BuildBasicSearchSQL($sWhere, $this->employer, $Keyword);
		$this->BuildBasicSearchSQL($sWhere, $this->employerphone, $Keyword);
		$this->BuildBasicSearchSQL($sWhere, $this->employeraddr, $Keyword);
		$this->BuildBasicSearchSQL($sWhere, $this->maritalstatus, $Keyword);
		$this->BuildBasicSearchSQL($sWhere, $this->spname, $Keyword);
		$this->BuildBasicSearchSQL($sWhere, $this->spemail, $Keyword);
		$this->BuildBasicSearchSQL($sWhere, $this->spphone, $Keyword);
		$this->BuildBasicSearchSQL($sWhere, $this->sdob, $Keyword);
		$this->BuildBasicSearchSQL($sWhere, $this->spaddr, $Keyword);
		$this->BuildBasicSearchSQL($sWhere, $this->spcity, $Keyword);
		$this->BuildBasicSearchSQL($sWhere, $this->spstate, $Keyword);
		$this->BuildBasicSearchSQL($sWhere, $this->marriagetype, $Keyword);
		$this->BuildBasicSearchSQL($sWhere, $this->marriageyear, $Keyword);
		$this->BuildBasicSearchSQL($sWhere, $this->marriagecert, $Keyword);
		$this->BuildBasicSearchSQL($sWhere, $this->marriagecity, $Keyword);
		$this->BuildBasicSearchSQL($sWhere, $this->marriagecountry, $Keyword);
		$this->BuildBasicSearchSQL($sWhere, $this->divorce, $Keyword);
		$this->BuildBasicSearchSQL($sWhere, $this->divorceyear, $Keyword);
		$this->BuildBasicSearchSQL($sWhere, $this->addinfo, $Keyword);
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
			$this->UpdateSort($this->willtype, $bCtrl); // willtype
			$this->UpdateSort($this->fullname, $bCtrl); // fullname
			$this->UpdateSort($this->_email, $bCtrl); // email
			$this->UpdateSort($this->phoneno, $bCtrl); // phoneno
			$this->UpdateSort($this->aphoneno, $bCtrl); // aphoneno
			$this->UpdateSort($this->gender, $bCtrl); // gender
			$this->UpdateSort($this->dob, $bCtrl); // dob
			$this->UpdateSort($this->state, $bCtrl); // state
			$this->UpdateSort($this->nationality, $bCtrl); // nationality
			$this->UpdateSort($this->lga, $bCtrl); // lga
			$this->UpdateSort($this->employmentstatus, $bCtrl); // employmentstatus
			$this->UpdateSort($this->employerphone, $bCtrl); // employerphone
			$this->UpdateSort($this->maritalstatus, $bCtrl); // maritalstatus
			$this->UpdateSort($this->spname, $bCtrl); // spname
			$this->UpdateSort($this->spemail, $bCtrl); // spemail
			$this->UpdateSort($this->spphone, $bCtrl); // spphone
			$this->UpdateSort($this->sdob, $bCtrl); // sdob
			$this->UpdateSort($this->spcity, $bCtrl); // spcity
			$this->UpdateSort($this->spstate, $bCtrl); // spstate
			$this->UpdateSort($this->marriagetype, $bCtrl); // marriagetype
			$this->UpdateSort($this->marriageyear, $bCtrl); // marriageyear
			$this->UpdateSort($this->marriagecert, $bCtrl); // marriagecert
			$this->UpdateSort($this->marriagecity, $bCtrl); // marriagecity
			$this->UpdateSort($this->marriagecountry, $bCtrl); // marriagecountry
			$this->UpdateSort($this->divorce, $bCtrl); // divorce
			$this->UpdateSort($this->divorceyear, $bCtrl); // divorceyear
			$this->UpdateSort($this->addinfo, $bCtrl); // addinfo
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

			// Reset sorting order
			if ($this->Command == "resetsort") {
				$sOrderBy = "";
				$this->setSessionOrderBy($sOrderBy);
				$this->willtype->setSort("");
				$this->fullname->setSort("");
				$this->_email->setSort("");
				$this->phoneno->setSort("");
				$this->aphoneno->setSort("");
				$this->gender->setSort("");
				$this->dob->setSort("");
				$this->state->setSort("");
				$this->nationality->setSort("");
				$this->lga->setSort("");
				$this->employmentstatus->setSort("");
				$this->employerphone->setSort("");
				$this->maritalstatus->setSort("");
				$this->spname->setSort("");
				$this->spemail->setSort("");
				$this->spphone->setSort("");
				$this->sdob->setSort("");
				$this->spcity->setSort("");
				$this->spstate->setSort("");
				$this->marriagetype->setSort("");
				$this->marriageyear->setSort("");
				$this->marriagecert->setSort("");
				$this->marriagecity->setSort("");
				$this->marriagecountry->setSort("");
				$this->divorce->setSort("");
				$this->divorceyear->setSort("");
				$this->addinfo->setSort("");
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

		// "detail_personal_info"
		$item = &$this->ListOptions->Add("detail_personal_info");
		$item->CssStyle = "white-space: nowrap;";
		$item->Visible = $Security->IsLoggedIn() && !$this->ShowMultipleDetails;
		$item->OnLeft = FALSE;
		$item->ShowInButtonGroup = FALSE;
		if (!isset($GLOBALS["personal_info_grid"])) $GLOBALS["personal_info_grid"] = new cpersonal_info_grid;

		// "detail_spouse_tb"
		$item = &$this->ListOptions->Add("detail_spouse_tb");
		$item->CssStyle = "white-space: nowrap;";
		$item->Visible = $Security->IsLoggedIn() && !$this->ShowMultipleDetails;
		$item->OnLeft = FALSE;
		$item->ShowInButtonGroup = FALSE;
		if (!isset($GLOBALS["spouse_tb_grid"])) $GLOBALS["spouse_tb_grid"] = new cspouse_tb_grid;

		// "detail_divorce_tb"
		$item = &$this->ListOptions->Add("detail_divorce_tb");
		$item->CssStyle = "white-space: nowrap;";
		$item->Visible = $Security->IsLoggedIn() && !$this->ShowMultipleDetails;
		$item->OnLeft = FALSE;
		$item->ShowInButtonGroup = FALSE;
		if (!isset($GLOBALS["divorce_tb_grid"])) $GLOBALS["divorce_tb_grid"] = new cdivorce_tb_grid;

		// "detail_children_details"
		$item = &$this->ListOptions->Add("detail_children_details");
		$item->CssStyle = "white-space: nowrap;";
		$item->Visible = $Security->IsLoggedIn() && !$this->ShowMultipleDetails;
		$item->OnLeft = FALSE;
		$item->ShowInButtonGroup = FALSE;
		if (!isset($GLOBALS["children_details_grid"])) $GLOBALS["children_details_grid"] = new cchildren_details_grid;

		// "detail_beneficiary_dump"
		$item = &$this->ListOptions->Add("detail_beneficiary_dump");
		$item->CssStyle = "white-space: nowrap;";
		$item->Visible = $Security->IsLoggedIn() && !$this->ShowMultipleDetails;
		$item->OnLeft = FALSE;
		$item->ShowInButtonGroup = FALSE;
		if (!isset($GLOBALS["beneficiary_dump_grid"])) $GLOBALS["beneficiary_dump_grid"] = new cbeneficiary_dump_grid;

		// "detail_alt_beneficiary"
		$item = &$this->ListOptions->Add("detail_alt_beneficiary");
		$item->CssStyle = "white-space: nowrap;";
		$item->Visible = $Security->IsLoggedIn() && !$this->ShowMultipleDetails;
		$item->OnLeft = FALSE;
		$item->ShowInButtonGroup = FALSE;
		if (!isset($GLOBALS["alt_beneficiary_grid"])) $GLOBALS["alt_beneficiary_grid"] = new calt_beneficiary_grid;

		// "detail_assets_tb"
		$item = &$this->ListOptions->Add("detail_assets_tb");
		$item->CssStyle = "white-space: nowrap;";
		$item->Visible = $Security->IsLoggedIn() && !$this->ShowMultipleDetails;
		$item->OnLeft = FALSE;
		$item->ShowInButtonGroup = FALSE;
		if (!isset($GLOBALS["assets_tb_grid"])) $GLOBALS["assets_tb_grid"] = new cassets_tb_grid;

		// "detail_overall_asset"
		$item = &$this->ListOptions->Add("detail_overall_asset");
		$item->CssStyle = "white-space: nowrap;";
		$item->Visible = $Security->IsLoggedIn() && !$this->ShowMultipleDetails;
		$item->OnLeft = FALSE;
		$item->ShowInButtonGroup = FALSE;
		if (!isset($GLOBALS["overall_asset_grid"])) $GLOBALS["overall_asset_grid"] = new coverall_asset_grid;

		// "detail_executor_tb"
		$item = &$this->ListOptions->Add("detail_executor_tb");
		$item->CssStyle = "white-space: nowrap;";
		$item->Visible = $Security->IsLoggedIn() && !$this->ShowMultipleDetails;
		$item->OnLeft = FALSE;
		$item->ShowInButtonGroup = FALSE;
		if (!isset($GLOBALS["executor_tb_grid"])) $GLOBALS["executor_tb_grid"] = new cexecutor_tb_grid;

		// "detail_trustee_tb"
		$item = &$this->ListOptions->Add("detail_trustee_tb");
		$item->CssStyle = "white-space: nowrap;";
		$item->Visible = $Security->IsLoggedIn() && !$this->ShowMultipleDetails;
		$item->OnLeft = FALSE;
		$item->ShowInButtonGroup = FALSE;
		if (!isset($GLOBALS["trustee_tb_grid"])) $GLOBALS["trustee_tb_grid"] = new ctrustee_tb_grid;

		// "detail_witness_tb"
		$item = &$this->ListOptions->Add("detail_witness_tb");
		$item->CssStyle = "white-space: nowrap;";
		$item->Visible = $Security->IsLoggedIn() && !$this->ShowMultipleDetails;
		$item->OnLeft = FALSE;
		$item->ShowInButtonGroup = FALSE;
		if (!isset($GLOBALS["witness_tb_grid"])) $GLOBALS["witness_tb_grid"] = new cwitness_tb_grid;

		// "detail_addinfo_tb"
		$item = &$this->ListOptions->Add("detail_addinfo_tb");
		$item->CssStyle = "white-space: nowrap;";
		$item->Visible = $Security->IsLoggedIn() && !$this->ShowMultipleDetails;
		$item->OnLeft = FALSE;
		$item->ShowInButtonGroup = FALSE;
		if (!isset($GLOBALS["addinfo_tb_grid"])) $GLOBALS["addinfo_tb_grid"] = new caddinfo_tb_grid;

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

		// "detail_personal_info"
		$oListOpt = &$this->ListOptions->Items["detail_personal_info"];
		if ($Security->IsLoggedIn()) {
			$body = $Language->Phrase("DetailLink") . $Language->TablePhrase("personal_info", "TblCaption");
			$body = "<a class=\"btn btn-small ewRowLink ewDetailList\" data-action=\"list\" href=\"" . ew_HtmlEncode("personal_infolist.php?" . EW_TABLE_SHOW_MASTER . "=comprehensivewill_tb&uid=" . strval($this->uid->CurrentValue) . "") . "\">" . $body . "</a>";
			$links = "";
			if ($GLOBALS["personal_info_grid"]->DetailView && $Security->IsLoggedIn() && $Security->IsLoggedIn()) {
				$links .= "<li><a class=\"ewRowLink ewDetailView\" data-action=\"view\" href=\"" . ew_HtmlEncode($this->GetViewUrl(EW_TABLE_SHOW_DETAIL . "=personal_info")) . "\">" . $Language->Phrase("MasterDetailViewLink") . "</a></li>";
				if ($DetailViewTblVar <> "") $DetailViewTblVar .= ",";
				$DetailViewTblVar .= "personal_info";
			}
			if ($GLOBALS["personal_info_grid"]->DetailEdit && $Security->IsLoggedIn() && $Security->IsLoggedIn()) {
				$links .= "<li><a class=\"ewRowLink ewDetailEdit\" data-action=\"edit\" href=\"" . ew_HtmlEncode($this->GetEditUrl(EW_TABLE_SHOW_DETAIL . "=personal_info")) . "\">" . $Language->Phrase("MasterDetailEditLink") . "</a></li>";
				if ($DetailEditTblVar <> "") $DetailEditTblVar .= ",";
				$DetailEditTblVar .= "personal_info";
			}
			if ($GLOBALS["personal_info_grid"]->DetailAdd && $Security->IsLoggedIn() && $Security->IsLoggedIn()) {
				$links .= "<li><a class=\"ewRowLink ewDetailCopy\" data-action=\"add\" href=\"" . ew_HtmlEncode($this->GetCopyUrl(EW_TABLE_SHOW_DETAIL . "=personal_info")) . "\">" . $Language->Phrase("MasterDetailCopyLink") . "</a></li>";
				if ($DetailCopyTblVar <> "") $DetailCopyTblVar .= ",";
				$DetailCopyTblVar .= "personal_info";
			}
			if ($links <> "") {
				$body .= "<button class=\"btn btn-small dropdown-toggle\" data-toggle=\"dropdown\"><b class=\"caret\"></b></button>";
				$body .= "<ul class=\"dropdown-menu\">". $links . "</ul>";
			}
			$body = "<div class=\"btn-group\">" . $body . "</div>";
			$oListOpt->Body = $body;
			if ($this->ShowMultipleDetails) $oListOpt->Visible = FALSE;
		}

		// "detail_spouse_tb"
		$oListOpt = &$this->ListOptions->Items["detail_spouse_tb"];
		if ($Security->IsLoggedIn()) {
			$body = $Language->Phrase("DetailLink") . $Language->TablePhrase("spouse_tb", "TblCaption");
			$body = "<a class=\"btn btn-small ewRowLink ewDetailList\" data-action=\"list\" href=\"" . ew_HtmlEncode("spouse_tblist.php?" . EW_TABLE_SHOW_MASTER . "=comprehensivewill_tb&uid=" . strval($this->uid->CurrentValue) . "") . "\">" . $body . "</a>";
			$links = "";
			if ($GLOBALS["spouse_tb_grid"]->DetailView && $Security->IsLoggedIn() && $Security->IsLoggedIn()) {
				$links .= "<li><a class=\"ewRowLink ewDetailView\" data-action=\"view\" href=\"" . ew_HtmlEncode($this->GetViewUrl(EW_TABLE_SHOW_DETAIL . "=spouse_tb")) . "\">" . $Language->Phrase("MasterDetailViewLink") . "</a></li>";
				if ($DetailViewTblVar <> "") $DetailViewTblVar .= ",";
				$DetailViewTblVar .= "spouse_tb";
			}
			if ($GLOBALS["spouse_tb_grid"]->DetailEdit && $Security->IsLoggedIn() && $Security->IsLoggedIn()) {
				$links .= "<li><a class=\"ewRowLink ewDetailEdit\" data-action=\"edit\" href=\"" . ew_HtmlEncode($this->GetEditUrl(EW_TABLE_SHOW_DETAIL . "=spouse_tb")) . "\">" . $Language->Phrase("MasterDetailEditLink") . "</a></li>";
				if ($DetailEditTblVar <> "") $DetailEditTblVar .= ",";
				$DetailEditTblVar .= "spouse_tb";
			}
			if ($GLOBALS["spouse_tb_grid"]->DetailAdd && $Security->IsLoggedIn() && $Security->IsLoggedIn()) {
				$links .= "<li><a class=\"ewRowLink ewDetailCopy\" data-action=\"add\" href=\"" . ew_HtmlEncode($this->GetCopyUrl(EW_TABLE_SHOW_DETAIL . "=spouse_tb")) . "\">" . $Language->Phrase("MasterDetailCopyLink") . "</a></li>";
				if ($DetailCopyTblVar <> "") $DetailCopyTblVar .= ",";
				$DetailCopyTblVar .= "spouse_tb";
			}
			if ($links <> "") {
				$body .= "<button class=\"btn btn-small dropdown-toggle\" data-toggle=\"dropdown\"><b class=\"caret\"></b></button>";
				$body .= "<ul class=\"dropdown-menu\">". $links . "</ul>";
			}
			$body = "<div class=\"btn-group\">" . $body . "</div>";
			$oListOpt->Body = $body;
			if ($this->ShowMultipleDetails) $oListOpt->Visible = FALSE;
		}

		// "detail_divorce_tb"
		$oListOpt = &$this->ListOptions->Items["detail_divorce_tb"];
		if ($Security->IsLoggedIn()) {
			$body = $Language->Phrase("DetailLink") . $Language->TablePhrase("divorce_tb", "TblCaption");
			$body = "<a class=\"btn btn-small ewRowLink ewDetailList\" data-action=\"list\" href=\"" . ew_HtmlEncode("divorce_tblist.php?" . EW_TABLE_SHOW_MASTER . "=comprehensivewill_tb&uid=" . strval($this->uid->CurrentValue) . "") . "\">" . $body . "</a>";
			$links = "";
			if ($GLOBALS["divorce_tb_grid"]->DetailView && $Security->IsLoggedIn() && $Security->IsLoggedIn()) {
				$links .= "<li><a class=\"ewRowLink ewDetailView\" data-action=\"view\" href=\"" . ew_HtmlEncode($this->GetViewUrl(EW_TABLE_SHOW_DETAIL . "=divorce_tb")) . "\">" . $Language->Phrase("MasterDetailViewLink") . "</a></li>";
				if ($DetailViewTblVar <> "") $DetailViewTblVar .= ",";
				$DetailViewTblVar .= "divorce_tb";
			}
			if ($GLOBALS["divorce_tb_grid"]->DetailEdit && $Security->IsLoggedIn() && $Security->IsLoggedIn()) {
				$links .= "<li><a class=\"ewRowLink ewDetailEdit\" data-action=\"edit\" href=\"" . ew_HtmlEncode($this->GetEditUrl(EW_TABLE_SHOW_DETAIL . "=divorce_tb")) . "\">" . $Language->Phrase("MasterDetailEditLink") . "</a></li>";
				if ($DetailEditTblVar <> "") $DetailEditTblVar .= ",";
				$DetailEditTblVar .= "divorce_tb";
			}
			if ($GLOBALS["divorce_tb_grid"]->DetailAdd && $Security->IsLoggedIn() && $Security->IsLoggedIn()) {
				$links .= "<li><a class=\"ewRowLink ewDetailCopy\" data-action=\"add\" href=\"" . ew_HtmlEncode($this->GetCopyUrl(EW_TABLE_SHOW_DETAIL . "=divorce_tb")) . "\">" . $Language->Phrase("MasterDetailCopyLink") . "</a></li>";
				if ($DetailCopyTblVar <> "") $DetailCopyTblVar .= ",";
				$DetailCopyTblVar .= "divorce_tb";
			}
			if ($links <> "") {
				$body .= "<button class=\"btn btn-small dropdown-toggle\" data-toggle=\"dropdown\"><b class=\"caret\"></b></button>";
				$body .= "<ul class=\"dropdown-menu\">". $links . "</ul>";
			}
			$body = "<div class=\"btn-group\">" . $body . "</div>";
			$oListOpt->Body = $body;
			if ($this->ShowMultipleDetails) $oListOpt->Visible = FALSE;
		}

		// "detail_children_details"
		$oListOpt = &$this->ListOptions->Items["detail_children_details"];
		if ($Security->IsLoggedIn()) {
			$body = $Language->Phrase("DetailLink") . $Language->TablePhrase("children_details", "TblCaption");
			$body = "<a class=\"btn btn-small ewRowLink ewDetailList\" data-action=\"list\" href=\"" . ew_HtmlEncode("children_detailslist.php?" . EW_TABLE_SHOW_MASTER . "=comprehensivewill_tb&uid=" . strval($this->uid->CurrentValue) . "") . "\">" . $body . "</a>";
			$links = "";
			if ($GLOBALS["children_details_grid"]->DetailView && $Security->IsLoggedIn() && $Security->IsLoggedIn()) {
				$links .= "<li><a class=\"ewRowLink ewDetailView\" data-action=\"view\" href=\"" . ew_HtmlEncode($this->GetViewUrl(EW_TABLE_SHOW_DETAIL . "=children_details")) . "\">" . $Language->Phrase("MasterDetailViewLink") . "</a></li>";
				if ($DetailViewTblVar <> "") $DetailViewTblVar .= ",";
				$DetailViewTblVar .= "children_details";
			}
			if ($GLOBALS["children_details_grid"]->DetailEdit && $Security->IsLoggedIn() && $Security->IsLoggedIn()) {
				$links .= "<li><a class=\"ewRowLink ewDetailEdit\" data-action=\"edit\" href=\"" . ew_HtmlEncode($this->GetEditUrl(EW_TABLE_SHOW_DETAIL . "=children_details")) . "\">" . $Language->Phrase("MasterDetailEditLink") . "</a></li>";
				if ($DetailEditTblVar <> "") $DetailEditTblVar .= ",";
				$DetailEditTblVar .= "children_details";
			}
			if ($GLOBALS["children_details_grid"]->DetailAdd && $Security->IsLoggedIn() && $Security->IsLoggedIn()) {
				$links .= "<li><a class=\"ewRowLink ewDetailCopy\" data-action=\"add\" href=\"" . ew_HtmlEncode($this->GetCopyUrl(EW_TABLE_SHOW_DETAIL . "=children_details")) . "\">" . $Language->Phrase("MasterDetailCopyLink") . "</a></li>";
				if ($DetailCopyTblVar <> "") $DetailCopyTblVar .= ",";
				$DetailCopyTblVar .= "children_details";
			}
			if ($links <> "") {
				$body .= "<button class=\"btn btn-small dropdown-toggle\" data-toggle=\"dropdown\"><b class=\"caret\"></b></button>";
				$body .= "<ul class=\"dropdown-menu\">". $links . "</ul>";
			}
			$body = "<div class=\"btn-group\">" . $body . "</div>";
			$oListOpt->Body = $body;
			if ($this->ShowMultipleDetails) $oListOpt->Visible = FALSE;
		}

		// "detail_beneficiary_dump"
		$oListOpt = &$this->ListOptions->Items["detail_beneficiary_dump"];
		if ($Security->IsLoggedIn()) {
			$body = $Language->Phrase("DetailLink") . $Language->TablePhrase("beneficiary_dump", "TblCaption");
			$body = "<a class=\"btn btn-small ewRowLink ewDetailList\" data-action=\"list\" href=\"" . ew_HtmlEncode("beneficiary_dumplist.php?" . EW_TABLE_SHOW_MASTER . "=comprehensivewill_tb&uid=" . strval($this->uid->CurrentValue) . "") . "\">" . $body . "</a>";
			$links = "";
			if ($GLOBALS["beneficiary_dump_grid"]->DetailView && $Security->IsLoggedIn() && $Security->IsLoggedIn()) {
				$links .= "<li><a class=\"ewRowLink ewDetailView\" data-action=\"view\" href=\"" . ew_HtmlEncode($this->GetViewUrl(EW_TABLE_SHOW_DETAIL . "=beneficiary_dump")) . "\">" . $Language->Phrase("MasterDetailViewLink") . "</a></li>";
				if ($DetailViewTblVar <> "") $DetailViewTblVar .= ",";
				$DetailViewTblVar .= "beneficiary_dump";
			}
			if ($GLOBALS["beneficiary_dump_grid"]->DetailEdit && $Security->IsLoggedIn() && $Security->IsLoggedIn()) {
				$links .= "<li><a class=\"ewRowLink ewDetailEdit\" data-action=\"edit\" href=\"" . ew_HtmlEncode($this->GetEditUrl(EW_TABLE_SHOW_DETAIL . "=beneficiary_dump")) . "\">" . $Language->Phrase("MasterDetailEditLink") . "</a></li>";
				if ($DetailEditTblVar <> "") $DetailEditTblVar .= ",";
				$DetailEditTblVar .= "beneficiary_dump";
			}
			if ($GLOBALS["beneficiary_dump_grid"]->DetailAdd && $Security->IsLoggedIn() && $Security->IsLoggedIn()) {
				$links .= "<li><a class=\"ewRowLink ewDetailCopy\" data-action=\"add\" href=\"" . ew_HtmlEncode($this->GetCopyUrl(EW_TABLE_SHOW_DETAIL . "=beneficiary_dump")) . "\">" . $Language->Phrase("MasterDetailCopyLink") . "</a></li>";
				if ($DetailCopyTblVar <> "") $DetailCopyTblVar .= ",";
				$DetailCopyTblVar .= "beneficiary_dump";
			}
			if ($links <> "") {
				$body .= "<button class=\"btn btn-small dropdown-toggle\" data-toggle=\"dropdown\"><b class=\"caret\"></b></button>";
				$body .= "<ul class=\"dropdown-menu\">". $links . "</ul>";
			}
			$body = "<div class=\"btn-group\">" . $body . "</div>";
			$oListOpt->Body = $body;
			if ($this->ShowMultipleDetails) $oListOpt->Visible = FALSE;
		}

		// "detail_alt_beneficiary"
		$oListOpt = &$this->ListOptions->Items["detail_alt_beneficiary"];
		if ($Security->IsLoggedIn()) {
			$body = $Language->Phrase("DetailLink") . $Language->TablePhrase("alt_beneficiary", "TblCaption");
			$body = "<a class=\"btn btn-small ewRowLink ewDetailList\" data-action=\"list\" href=\"" . ew_HtmlEncode("alt_beneficiarylist.php?" . EW_TABLE_SHOW_MASTER . "=comprehensivewill_tb&uid=" . strval($this->uid->CurrentValue) . "") . "\">" . $body . "</a>";
			$links = "";
			if ($GLOBALS["alt_beneficiary_grid"]->DetailView && $Security->IsLoggedIn() && $Security->IsLoggedIn()) {
				$links .= "<li><a class=\"ewRowLink ewDetailView\" data-action=\"view\" href=\"" . ew_HtmlEncode($this->GetViewUrl(EW_TABLE_SHOW_DETAIL . "=alt_beneficiary")) . "\">" . $Language->Phrase("MasterDetailViewLink") . "</a></li>";
				if ($DetailViewTblVar <> "") $DetailViewTblVar .= ",";
				$DetailViewTblVar .= "alt_beneficiary";
			}
			if ($GLOBALS["alt_beneficiary_grid"]->DetailEdit && $Security->IsLoggedIn() && $Security->IsLoggedIn()) {
				$links .= "<li><a class=\"ewRowLink ewDetailEdit\" data-action=\"edit\" href=\"" . ew_HtmlEncode($this->GetEditUrl(EW_TABLE_SHOW_DETAIL . "=alt_beneficiary")) . "\">" . $Language->Phrase("MasterDetailEditLink") . "</a></li>";
				if ($DetailEditTblVar <> "") $DetailEditTblVar .= ",";
				$DetailEditTblVar .= "alt_beneficiary";
			}
			if ($GLOBALS["alt_beneficiary_grid"]->DetailAdd && $Security->IsLoggedIn() && $Security->IsLoggedIn()) {
				$links .= "<li><a class=\"ewRowLink ewDetailCopy\" data-action=\"add\" href=\"" . ew_HtmlEncode($this->GetCopyUrl(EW_TABLE_SHOW_DETAIL . "=alt_beneficiary")) . "\">" . $Language->Phrase("MasterDetailCopyLink") . "</a></li>";
				if ($DetailCopyTblVar <> "") $DetailCopyTblVar .= ",";
				$DetailCopyTblVar .= "alt_beneficiary";
			}
			if ($links <> "") {
				$body .= "<button class=\"btn btn-small dropdown-toggle\" data-toggle=\"dropdown\"><b class=\"caret\"></b></button>";
				$body .= "<ul class=\"dropdown-menu\">". $links . "</ul>";
			}
			$body = "<div class=\"btn-group\">" . $body . "</div>";
			$oListOpt->Body = $body;
			if ($this->ShowMultipleDetails) $oListOpt->Visible = FALSE;
		}

		// "detail_assets_tb"
		$oListOpt = &$this->ListOptions->Items["detail_assets_tb"];
		if ($Security->IsLoggedIn()) {
			$body = $Language->Phrase("DetailLink") . $Language->TablePhrase("assets_tb", "TblCaption");
			$body = "<a class=\"btn btn-small ewRowLink ewDetailList\" data-action=\"list\" href=\"" . ew_HtmlEncode("assets_tblist.php?" . EW_TABLE_SHOW_MASTER . "=comprehensivewill_tb&uid=" . strval($this->uid->CurrentValue) . "") . "\">" . $body . "</a>";
			$links = "";
			if ($GLOBALS["assets_tb_grid"]->DetailView && $Security->IsLoggedIn() && $Security->IsLoggedIn()) {
				$links .= "<li><a class=\"ewRowLink ewDetailView\" data-action=\"view\" href=\"" . ew_HtmlEncode($this->GetViewUrl(EW_TABLE_SHOW_DETAIL . "=assets_tb")) . "\">" . $Language->Phrase("MasterDetailViewLink") . "</a></li>";
				if ($DetailViewTblVar <> "") $DetailViewTblVar .= ",";
				$DetailViewTblVar .= "assets_tb";
			}
			if ($GLOBALS["assets_tb_grid"]->DetailEdit && $Security->IsLoggedIn() && $Security->IsLoggedIn()) {
				$links .= "<li><a class=\"ewRowLink ewDetailEdit\" data-action=\"edit\" href=\"" . ew_HtmlEncode($this->GetEditUrl(EW_TABLE_SHOW_DETAIL . "=assets_tb")) . "\">" . $Language->Phrase("MasterDetailEditLink") . "</a></li>";
				if ($DetailEditTblVar <> "") $DetailEditTblVar .= ",";
				$DetailEditTblVar .= "assets_tb";
			}
			if ($GLOBALS["assets_tb_grid"]->DetailAdd && $Security->IsLoggedIn() && $Security->IsLoggedIn()) {
				$links .= "<li><a class=\"ewRowLink ewDetailCopy\" data-action=\"add\" href=\"" . ew_HtmlEncode($this->GetCopyUrl(EW_TABLE_SHOW_DETAIL . "=assets_tb")) . "\">" . $Language->Phrase("MasterDetailCopyLink") . "</a></li>";
				if ($DetailCopyTblVar <> "") $DetailCopyTblVar .= ",";
				$DetailCopyTblVar .= "assets_tb";
			}
			if ($links <> "") {
				$body .= "<button class=\"btn btn-small dropdown-toggle\" data-toggle=\"dropdown\"><b class=\"caret\"></b></button>";
				$body .= "<ul class=\"dropdown-menu\">". $links . "</ul>";
			}
			$body = "<div class=\"btn-group\">" . $body . "</div>";
			$oListOpt->Body = $body;
			if ($this->ShowMultipleDetails) $oListOpt->Visible = FALSE;
		}

		// "detail_overall_asset"
		$oListOpt = &$this->ListOptions->Items["detail_overall_asset"];
		if ($Security->IsLoggedIn()) {
			$body = $Language->Phrase("DetailLink") . $Language->TablePhrase("overall_asset", "TblCaption");
			$body = "<a class=\"btn btn-small ewRowLink ewDetailList\" data-action=\"list\" href=\"" . ew_HtmlEncode("overall_assetlist.php?" . EW_TABLE_SHOW_MASTER . "=comprehensivewill_tb&uid=" . strval($this->uid->CurrentValue) . "") . "\">" . $body . "</a>";
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

		// "detail_executor_tb"
		$oListOpt = &$this->ListOptions->Items["detail_executor_tb"];
		if ($Security->IsLoggedIn()) {
			$body = $Language->Phrase("DetailLink") . $Language->TablePhrase("executor_tb", "TblCaption");
			$body = "<a class=\"btn btn-small ewRowLink ewDetailList\" data-action=\"list\" href=\"" . ew_HtmlEncode("executor_tblist.php?" . EW_TABLE_SHOW_MASTER . "=comprehensivewill_tb&uid=" . strval($this->uid->CurrentValue) . "") . "\">" . $body . "</a>";
			$links = "";
			if ($GLOBALS["executor_tb_grid"]->DetailView && $Security->IsLoggedIn() && $Security->IsLoggedIn()) {
				$links .= "<li><a class=\"ewRowLink ewDetailView\" data-action=\"view\" href=\"" . ew_HtmlEncode($this->GetViewUrl(EW_TABLE_SHOW_DETAIL . "=executor_tb")) . "\">" . $Language->Phrase("MasterDetailViewLink") . "</a></li>";
				if ($DetailViewTblVar <> "") $DetailViewTblVar .= ",";
				$DetailViewTblVar .= "executor_tb";
			}
			if ($GLOBALS["executor_tb_grid"]->DetailEdit && $Security->IsLoggedIn() && $Security->IsLoggedIn()) {
				$links .= "<li><a class=\"ewRowLink ewDetailEdit\" data-action=\"edit\" href=\"" . ew_HtmlEncode($this->GetEditUrl(EW_TABLE_SHOW_DETAIL . "=executor_tb")) . "\">" . $Language->Phrase("MasterDetailEditLink") . "</a></li>";
				if ($DetailEditTblVar <> "") $DetailEditTblVar .= ",";
				$DetailEditTblVar .= "executor_tb";
			}
			if ($GLOBALS["executor_tb_grid"]->DetailAdd && $Security->IsLoggedIn() && $Security->IsLoggedIn()) {
				$links .= "<li><a class=\"ewRowLink ewDetailCopy\" data-action=\"add\" href=\"" . ew_HtmlEncode($this->GetCopyUrl(EW_TABLE_SHOW_DETAIL . "=executor_tb")) . "\">" . $Language->Phrase("MasterDetailCopyLink") . "</a></li>";
				if ($DetailCopyTblVar <> "") $DetailCopyTblVar .= ",";
				$DetailCopyTblVar .= "executor_tb";
			}
			if ($links <> "") {
				$body .= "<button class=\"btn btn-small dropdown-toggle\" data-toggle=\"dropdown\"><b class=\"caret\"></b></button>";
				$body .= "<ul class=\"dropdown-menu\">". $links . "</ul>";
			}
			$body = "<div class=\"btn-group\">" . $body . "</div>";
			$oListOpt->Body = $body;
			if ($this->ShowMultipleDetails) $oListOpt->Visible = FALSE;
		}

		// "detail_trustee_tb"
		$oListOpt = &$this->ListOptions->Items["detail_trustee_tb"];
		if ($Security->IsLoggedIn()) {
			$body = $Language->Phrase("DetailLink") . $Language->TablePhrase("trustee_tb", "TblCaption");
			$body = "<a class=\"btn btn-small ewRowLink ewDetailList\" data-action=\"list\" href=\"" . ew_HtmlEncode("trustee_tblist.php?" . EW_TABLE_SHOW_MASTER . "=comprehensivewill_tb&uid=" . strval($this->uid->CurrentValue) . "") . "\">" . $body . "</a>";
			$links = "";
			if ($GLOBALS["trustee_tb_grid"]->DetailView && $Security->IsLoggedIn() && $Security->IsLoggedIn()) {
				$links .= "<li><a class=\"ewRowLink ewDetailView\" data-action=\"view\" href=\"" . ew_HtmlEncode($this->GetViewUrl(EW_TABLE_SHOW_DETAIL . "=trustee_tb")) . "\">" . $Language->Phrase("MasterDetailViewLink") . "</a></li>";
				if ($DetailViewTblVar <> "") $DetailViewTblVar .= ",";
				$DetailViewTblVar .= "trustee_tb";
			}
			if ($GLOBALS["trustee_tb_grid"]->DetailEdit && $Security->IsLoggedIn() && $Security->IsLoggedIn()) {
				$links .= "<li><a class=\"ewRowLink ewDetailEdit\" data-action=\"edit\" href=\"" . ew_HtmlEncode($this->GetEditUrl(EW_TABLE_SHOW_DETAIL . "=trustee_tb")) . "\">" . $Language->Phrase("MasterDetailEditLink") . "</a></li>";
				if ($DetailEditTblVar <> "") $DetailEditTblVar .= ",";
				$DetailEditTblVar .= "trustee_tb";
			}
			if ($GLOBALS["trustee_tb_grid"]->DetailAdd && $Security->IsLoggedIn() && $Security->IsLoggedIn()) {
				$links .= "<li><a class=\"ewRowLink ewDetailCopy\" data-action=\"add\" href=\"" . ew_HtmlEncode($this->GetCopyUrl(EW_TABLE_SHOW_DETAIL . "=trustee_tb")) . "\">" . $Language->Phrase("MasterDetailCopyLink") . "</a></li>";
				if ($DetailCopyTblVar <> "") $DetailCopyTblVar .= ",";
				$DetailCopyTblVar .= "trustee_tb";
			}
			if ($links <> "") {
				$body .= "<button class=\"btn btn-small dropdown-toggle\" data-toggle=\"dropdown\"><b class=\"caret\"></b></button>";
				$body .= "<ul class=\"dropdown-menu\">". $links . "</ul>";
			}
			$body = "<div class=\"btn-group\">" . $body . "</div>";
			$oListOpt->Body = $body;
			if ($this->ShowMultipleDetails) $oListOpt->Visible = FALSE;
		}

		// "detail_witness_tb"
		$oListOpt = &$this->ListOptions->Items["detail_witness_tb"];
		if ($Security->IsLoggedIn()) {
			$body = $Language->Phrase("DetailLink") . $Language->TablePhrase("witness_tb", "TblCaption");
			$body = "<a class=\"btn btn-small ewRowLink ewDetailList\" data-action=\"list\" href=\"" . ew_HtmlEncode("witness_tblist.php?" . EW_TABLE_SHOW_MASTER . "=comprehensivewill_tb&uid=" . strval($this->uid->CurrentValue) . "") . "\">" . $body . "</a>";
			$links = "";
			if ($GLOBALS["witness_tb_grid"]->DetailView && $Security->IsLoggedIn() && $Security->IsLoggedIn()) {
				$links .= "<li><a class=\"ewRowLink ewDetailView\" data-action=\"view\" href=\"" . ew_HtmlEncode($this->GetViewUrl(EW_TABLE_SHOW_DETAIL . "=witness_tb")) . "\">" . $Language->Phrase("MasterDetailViewLink") . "</a></li>";
				if ($DetailViewTblVar <> "") $DetailViewTblVar .= ",";
				$DetailViewTblVar .= "witness_tb";
			}
			if ($GLOBALS["witness_tb_grid"]->DetailEdit && $Security->IsLoggedIn() && $Security->IsLoggedIn()) {
				$links .= "<li><a class=\"ewRowLink ewDetailEdit\" data-action=\"edit\" href=\"" . ew_HtmlEncode($this->GetEditUrl(EW_TABLE_SHOW_DETAIL . "=witness_tb")) . "\">" . $Language->Phrase("MasterDetailEditLink") . "</a></li>";
				if ($DetailEditTblVar <> "") $DetailEditTblVar .= ",";
				$DetailEditTblVar .= "witness_tb";
			}
			if ($GLOBALS["witness_tb_grid"]->DetailAdd && $Security->IsLoggedIn() && $Security->IsLoggedIn()) {
				$links .= "<li><a class=\"ewRowLink ewDetailCopy\" data-action=\"add\" href=\"" . ew_HtmlEncode($this->GetCopyUrl(EW_TABLE_SHOW_DETAIL . "=witness_tb")) . "\">" . $Language->Phrase("MasterDetailCopyLink") . "</a></li>";
				if ($DetailCopyTblVar <> "") $DetailCopyTblVar .= ",";
				$DetailCopyTblVar .= "witness_tb";
			}
			if ($links <> "") {
				$body .= "<button class=\"btn btn-small dropdown-toggle\" data-toggle=\"dropdown\"><b class=\"caret\"></b></button>";
				$body .= "<ul class=\"dropdown-menu\">". $links . "</ul>";
			}
			$body = "<div class=\"btn-group\">" . $body . "</div>";
			$oListOpt->Body = $body;
			if ($this->ShowMultipleDetails) $oListOpt->Visible = FALSE;
		}

		// "detail_addinfo_tb"
		$oListOpt = &$this->ListOptions->Items["detail_addinfo_tb"];
		if ($Security->IsLoggedIn()) {
			$body = $Language->Phrase("DetailLink") . $Language->TablePhrase("addinfo_tb", "TblCaption");
			$body = "<a class=\"btn btn-small ewRowLink ewDetailList\" data-action=\"list\" href=\"" . ew_HtmlEncode("addinfo_tblist.php?" . EW_TABLE_SHOW_MASTER . "=comprehensivewill_tb&uid=" . strval($this->uid->CurrentValue) . "") . "\">" . $body . "</a>";
			$links = "";
			if ($GLOBALS["addinfo_tb_grid"]->DetailView && $Security->IsLoggedIn() && $Security->IsLoggedIn()) {
				$links .= "<li><a class=\"ewRowLink ewDetailView\" data-action=\"view\" href=\"" . ew_HtmlEncode($this->GetViewUrl(EW_TABLE_SHOW_DETAIL . "=addinfo_tb")) . "\">" . $Language->Phrase("MasterDetailViewLink") . "</a></li>";
				if ($DetailViewTblVar <> "") $DetailViewTblVar .= ",";
				$DetailViewTblVar .= "addinfo_tb";
			}
			if ($GLOBALS["addinfo_tb_grid"]->DetailEdit && $Security->IsLoggedIn() && $Security->IsLoggedIn()) {
				$links .= "<li><a class=\"ewRowLink ewDetailEdit\" data-action=\"edit\" href=\"" . ew_HtmlEncode($this->GetEditUrl(EW_TABLE_SHOW_DETAIL . "=addinfo_tb")) . "\">" . $Language->Phrase("MasterDetailEditLink") . "</a></li>";
				if ($DetailEditTblVar <> "") $DetailEditTblVar .= ",";
				$DetailEditTblVar .= "addinfo_tb";
			}
			if ($GLOBALS["addinfo_tb_grid"]->DetailAdd && $Security->IsLoggedIn() && $Security->IsLoggedIn()) {
				$links .= "<li><a class=\"ewRowLink ewDetailCopy\" data-action=\"add\" href=\"" . ew_HtmlEncode($this->GetCopyUrl(EW_TABLE_SHOW_DETAIL . "=addinfo_tb")) . "\">" . $Language->Phrase("MasterDetailCopyLink") . "</a></li>";
				if ($DetailCopyTblVar <> "") $DetailCopyTblVar .= ",";
				$DetailCopyTblVar .= "addinfo_tb";
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
		$item = &$option->Add("detailadd_personal_info");
		$item->Body = "<a class=\"ewDetailAddGroup ewDetailAdd\" href=\"" . ew_HtmlEncode($this->GetAddUrl() . "?" . EW_TABLE_SHOW_DETAIL . "=personal_info") . "\">" . $Language->Phrase("AddLink") . "&nbsp;" . $this->TableCaption() . "/" . $GLOBALS["personal_info"]->TableCaption() . "</a>";
		$item->Visible = ($GLOBALS["personal_info"]->DetailAdd && $Security->IsLoggedIn() && $Security->IsLoggedIn());
		if ($item->Visible) {
			if ($DetailTableLink <> "") $DetailTableLink .= ",";
			$DetailTableLink .= "personal_info";
		}
		$item = &$option->Add("detailadd_spouse_tb");
		$item->Body = "<a class=\"ewDetailAddGroup ewDetailAdd\" href=\"" . ew_HtmlEncode($this->GetAddUrl() . "?" . EW_TABLE_SHOW_DETAIL . "=spouse_tb") . "\">" . $Language->Phrase("AddLink") . "&nbsp;" . $this->TableCaption() . "/" . $GLOBALS["spouse_tb"]->TableCaption() . "</a>";
		$item->Visible = ($GLOBALS["spouse_tb"]->DetailAdd && $Security->IsLoggedIn() && $Security->IsLoggedIn());
		if ($item->Visible) {
			if ($DetailTableLink <> "") $DetailTableLink .= ",";
			$DetailTableLink .= "spouse_tb";
		}
		$item = &$option->Add("detailadd_divorce_tb");
		$item->Body = "<a class=\"ewDetailAddGroup ewDetailAdd\" href=\"" . ew_HtmlEncode($this->GetAddUrl() . "?" . EW_TABLE_SHOW_DETAIL . "=divorce_tb") . "\">" . $Language->Phrase("AddLink") . "&nbsp;" . $this->TableCaption() . "/" . $GLOBALS["divorce_tb"]->TableCaption() . "</a>";
		$item->Visible = ($GLOBALS["divorce_tb"]->DetailAdd && $Security->IsLoggedIn() && $Security->IsLoggedIn());
		if ($item->Visible) {
			if ($DetailTableLink <> "") $DetailTableLink .= ",";
			$DetailTableLink .= "divorce_tb";
		}
		$item = &$option->Add("detailadd_children_details");
		$item->Body = "<a class=\"ewDetailAddGroup ewDetailAdd\" href=\"" . ew_HtmlEncode($this->GetAddUrl() . "?" . EW_TABLE_SHOW_DETAIL . "=children_details") . "\">" . $Language->Phrase("AddLink") . "&nbsp;" . $this->TableCaption() . "/" . $GLOBALS["children_details"]->TableCaption() . "</a>";
		$item->Visible = ($GLOBALS["children_details"]->DetailAdd && $Security->IsLoggedIn() && $Security->IsLoggedIn());
		if ($item->Visible) {
			if ($DetailTableLink <> "") $DetailTableLink .= ",";
			$DetailTableLink .= "children_details";
		}
		$item = &$option->Add("detailadd_beneficiary_dump");
		$item->Body = "<a class=\"ewDetailAddGroup ewDetailAdd\" href=\"" . ew_HtmlEncode($this->GetAddUrl() . "?" . EW_TABLE_SHOW_DETAIL . "=beneficiary_dump") . "\">" . $Language->Phrase("AddLink") . "&nbsp;" . $this->TableCaption() . "/" . $GLOBALS["beneficiary_dump"]->TableCaption() . "</a>";
		$item->Visible = ($GLOBALS["beneficiary_dump"]->DetailAdd && $Security->IsLoggedIn() && $Security->IsLoggedIn());
		if ($item->Visible) {
			if ($DetailTableLink <> "") $DetailTableLink .= ",";
			$DetailTableLink .= "beneficiary_dump";
		}
		$item = &$option->Add("detailadd_alt_beneficiary");
		$item->Body = "<a class=\"ewDetailAddGroup ewDetailAdd\" href=\"" . ew_HtmlEncode($this->GetAddUrl() . "?" . EW_TABLE_SHOW_DETAIL . "=alt_beneficiary") . "\">" . $Language->Phrase("AddLink") . "&nbsp;" . $this->TableCaption() . "/" . $GLOBALS["alt_beneficiary"]->TableCaption() . "</a>";
		$item->Visible = ($GLOBALS["alt_beneficiary"]->DetailAdd && $Security->IsLoggedIn() && $Security->IsLoggedIn());
		if ($item->Visible) {
			if ($DetailTableLink <> "") $DetailTableLink .= ",";
			$DetailTableLink .= "alt_beneficiary";
		}
		$item = &$option->Add("detailadd_assets_tb");
		$item->Body = "<a class=\"ewDetailAddGroup ewDetailAdd\" href=\"" . ew_HtmlEncode($this->GetAddUrl() . "?" . EW_TABLE_SHOW_DETAIL . "=assets_tb") . "\">" . $Language->Phrase("AddLink") . "&nbsp;" . $this->TableCaption() . "/" . $GLOBALS["assets_tb"]->TableCaption() . "</a>";
		$item->Visible = ($GLOBALS["assets_tb"]->DetailAdd && $Security->IsLoggedIn() && $Security->IsLoggedIn());
		if ($item->Visible) {
			if ($DetailTableLink <> "") $DetailTableLink .= ",";
			$DetailTableLink .= "assets_tb";
		}
		$item = &$option->Add("detailadd_overall_asset");
		$item->Body = "<a class=\"ewDetailAddGroup ewDetailAdd\" href=\"" . ew_HtmlEncode($this->GetAddUrl() . "?" . EW_TABLE_SHOW_DETAIL . "=overall_asset") . "\">" . $Language->Phrase("AddLink") . "&nbsp;" . $this->TableCaption() . "/" . $GLOBALS["overall_asset"]->TableCaption() . "</a>";
		$item->Visible = ($GLOBALS["overall_asset"]->DetailAdd && $Security->IsLoggedIn() && $Security->IsLoggedIn());
		if ($item->Visible) {
			if ($DetailTableLink <> "") $DetailTableLink .= ",";
			$DetailTableLink .= "overall_asset";
		}
		$item = &$option->Add("detailadd_executor_tb");
		$item->Body = "<a class=\"ewDetailAddGroup ewDetailAdd\" href=\"" . ew_HtmlEncode($this->GetAddUrl() . "?" . EW_TABLE_SHOW_DETAIL . "=executor_tb") . "\">" . $Language->Phrase("AddLink") . "&nbsp;" . $this->TableCaption() . "/" . $GLOBALS["executor_tb"]->TableCaption() . "</a>";
		$item->Visible = ($GLOBALS["executor_tb"]->DetailAdd && $Security->IsLoggedIn() && $Security->IsLoggedIn());
		if ($item->Visible) {
			if ($DetailTableLink <> "") $DetailTableLink .= ",";
			$DetailTableLink .= "executor_tb";
		}
		$item = &$option->Add("detailadd_trustee_tb");
		$item->Body = "<a class=\"ewDetailAddGroup ewDetailAdd\" href=\"" . ew_HtmlEncode($this->GetAddUrl() . "?" . EW_TABLE_SHOW_DETAIL . "=trustee_tb") . "\">" . $Language->Phrase("AddLink") . "&nbsp;" . $this->TableCaption() . "/" . $GLOBALS["trustee_tb"]->TableCaption() . "</a>";
		$item->Visible = ($GLOBALS["trustee_tb"]->DetailAdd && $Security->IsLoggedIn() && $Security->IsLoggedIn());
		if ($item->Visible) {
			if ($DetailTableLink <> "") $DetailTableLink .= ",";
			$DetailTableLink .= "trustee_tb";
		}
		$item = &$option->Add("detailadd_witness_tb");
		$item->Body = "<a class=\"ewDetailAddGroup ewDetailAdd\" href=\"" . ew_HtmlEncode($this->GetAddUrl() . "?" . EW_TABLE_SHOW_DETAIL . "=witness_tb") . "\">" . $Language->Phrase("AddLink") . "&nbsp;" . $this->TableCaption() . "/" . $GLOBALS["witness_tb"]->TableCaption() . "</a>";
		$item->Visible = ($GLOBALS["witness_tb"]->DetailAdd && $Security->IsLoggedIn() && $Security->IsLoggedIn());
		if ($item->Visible) {
			if ($DetailTableLink <> "") $DetailTableLink .= ",";
			$DetailTableLink .= "witness_tb";
		}
		$item = &$option->Add("detailadd_addinfo_tb");
		$item->Body = "<a class=\"ewDetailAddGroup ewDetailAdd\" href=\"" . ew_HtmlEncode($this->GetAddUrl() . "?" . EW_TABLE_SHOW_DETAIL . "=addinfo_tb") . "\">" . $Language->Phrase("AddLink") . "&nbsp;" . $this->TableCaption() . "/" . $GLOBALS["addinfo_tb"]->TableCaption() . "</a>";
		$item->Visible = ($GLOBALS["addinfo_tb"]->DetailAdd && $Security->IsLoggedIn() && $Security->IsLoggedIn());
		if ($item->Visible) {
			if ($DetailTableLink <> "") $DetailTableLink .= ",";
			$DetailTableLink .= "addinfo_tb";
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
		$item->Body = "<a class=\"ewAction ewMultiDelete\" href=\"\" onclick=\"ew_SubmitSelected(document.fcomprehensivewill_tblist, '" . $this->MultiDeleteUrl . "', ewLanguage.Phrase('DeleteMultiConfirmMsg'));return false;\">" . $Language->Phrase("DeleteSelectedLink") . "</a>";
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
				$item->Body = "<a class=\"ewAction ewCustomAction\" href=\"\" onclick=\"ew_SubmitSelected(document.fcomprehensivewill_tblist, '" . ew_CurrentUrl() . "', null, '" . $action . "');return false;\">" . $name . "</a>";
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

		// Column "detail_personal_info"
		$link = "";
		$option = &$this->ListOptions->Items["detail_personal_info"];
		$url = "personal_infopreview.php?f=" . ew_Encrypt($sSqlWrk);
		$btngrp = "<div data-table=\"personal_info\" data-url=\"" . $url . "\" class=\"btn-group\">";
		if ($Security->IsLoggedIn()) {			
			$label = $Language->TablePhrase("personal_info", "TblCaption");
			$link = "<li><a href=\"#\" data-toggle=\"tab\" data-table=\"personal_info\" data-url=\"" . $url . "\">" . $label . "</a></li>";			
			$links .= $link;
			$detaillnk = ew_JsEncode3("personal_infolist.php?" . EW_TABLE_SHOW_MASTER . "=comprehensivewill_tb&uid=" . urlencode(strval($this->uid->CurrentValue)) . "");
			$btngrp .= "<button type=\"button\" class=\"btn btn-small\" onclick=\"window.location='" . $detaillnk . "'\">" . $Language->TablePhrase("personal_info", "TblCaption") . "</button>";
		}
		if ($GLOBALS["personal_info_grid"]->DetailView && $Security->IsLoggedIn() && $Security->IsLoggedIn())
			$btngrp .= "<button type=\"button\" class=\"btn btn-small\" onclick=\"window.location='" . $this->GetViewUrl(EW_TABLE_SHOW_DETAIL . "=personal_info") . "'\">" . $Language->Phrase("MasterDetailViewLink") . "</button>";
		if ($GLOBALS["personal_info_grid"]->DetailEdit && $Security->IsLoggedIn() && $Security->IsLoggedIn())
			$btngrp .= "<button type=\"button\" class=\"btn btn-small\" onclick=\"window.location='" . $this->GetEditUrl(EW_TABLE_SHOW_DETAIL . "=personal_info") . "'\">" . $Language->Phrase("MasterDetailEditLink") . "</button>";
		$btngrp .= "</div>";
		if ($link <> "") {
			$btngrps .= $btngrp;
			$option->Body .= "<div class=\"hide ewPreview\">" . $link . $btngrp . "</div>";
		}
		$sSqlWrk = "`uid`=" . ew_AdjustSql($this->uid->CurrentValue) . "";

		// Column "detail_spouse_tb"
		$link = "";
		$option = &$this->ListOptions->Items["detail_spouse_tb"];
		$url = "spouse_tbpreview.php?f=" . ew_Encrypt($sSqlWrk);
		$btngrp = "<div data-table=\"spouse_tb\" data-url=\"" . $url . "\" class=\"btn-group\">";
		if ($Security->IsLoggedIn()) {			
			$label = $Language->TablePhrase("spouse_tb", "TblCaption");
			$link = "<li><a href=\"#\" data-toggle=\"tab\" data-table=\"spouse_tb\" data-url=\"" . $url . "\">" . $label . "</a></li>";			
			$links .= $link;
			$detaillnk = ew_JsEncode3("spouse_tblist.php?" . EW_TABLE_SHOW_MASTER . "=comprehensivewill_tb&uid=" . urlencode(strval($this->uid->CurrentValue)) . "");
			$btngrp .= "<button type=\"button\" class=\"btn btn-small\" onclick=\"window.location='" . $detaillnk . "'\">" . $Language->TablePhrase("spouse_tb", "TblCaption") . "</button>";
		}
		if ($GLOBALS["spouse_tb_grid"]->DetailView && $Security->IsLoggedIn() && $Security->IsLoggedIn())
			$btngrp .= "<button type=\"button\" class=\"btn btn-small\" onclick=\"window.location='" . $this->GetViewUrl(EW_TABLE_SHOW_DETAIL . "=spouse_tb") . "'\">" . $Language->Phrase("MasterDetailViewLink") . "</button>";
		if ($GLOBALS["spouse_tb_grid"]->DetailEdit && $Security->IsLoggedIn() && $Security->IsLoggedIn())
			$btngrp .= "<button type=\"button\" class=\"btn btn-small\" onclick=\"window.location='" . $this->GetEditUrl(EW_TABLE_SHOW_DETAIL . "=spouse_tb") . "'\">" . $Language->Phrase("MasterDetailEditLink") . "</button>";
		if ($GLOBALS["spouse_tb_grid"]->DetailAdd && $Security->IsLoggedIn() && $Security->IsLoggedIn())
			$btngrp .= "<button type=\"button\" class=\"btn btn-small\" onclick=\"window.location='" . $this->GetCopyUrl(EW_TABLE_SHOW_DETAIL . "=spouse_tb") . "'\">" . $Language->Phrase("MasterDetailCopyLink") . "</button>";
		$btngrp .= "</div>";
		if ($link <> "") {
			$btngrps .= $btngrp;
			$option->Body .= "<div class=\"hide ewPreview\">" . $link . $btngrp . "</div>";
		}
		$sSqlWrk = "`uid`=" . ew_AdjustSql($this->uid->CurrentValue) . "";

		// Column "detail_divorce_tb"
		$link = "";
		$option = &$this->ListOptions->Items["detail_divorce_tb"];
		$url = "divorce_tbpreview.php?f=" . ew_Encrypt($sSqlWrk);
		$btngrp = "<div data-table=\"divorce_tb\" data-url=\"" . $url . "\" class=\"btn-group\">";
		if ($Security->IsLoggedIn()) {			
			$label = $Language->TablePhrase("divorce_tb", "TblCaption");
			$link = "<li><a href=\"#\" data-toggle=\"tab\" data-table=\"divorce_tb\" data-url=\"" . $url . "\">" . $label . "</a></li>";			
			$links .= $link;
			$detaillnk = ew_JsEncode3("divorce_tblist.php?" . EW_TABLE_SHOW_MASTER . "=comprehensivewill_tb&uid=" . urlencode(strval($this->uid->CurrentValue)) . "");
			$btngrp .= "<button type=\"button\" class=\"btn btn-small\" onclick=\"window.location='" . $detaillnk . "'\">" . $Language->TablePhrase("divorce_tb", "TblCaption") . "</button>";
		}
		if ($GLOBALS["divorce_tb_grid"]->DetailView && $Security->IsLoggedIn() && $Security->IsLoggedIn())
			$btngrp .= "<button type=\"button\" class=\"btn btn-small\" onclick=\"window.location='" . $this->GetViewUrl(EW_TABLE_SHOW_DETAIL . "=divorce_tb") . "'\">" . $Language->Phrase("MasterDetailViewLink") . "</button>";
		if ($GLOBALS["divorce_tb_grid"]->DetailEdit && $Security->IsLoggedIn() && $Security->IsLoggedIn())
			$btngrp .= "<button type=\"button\" class=\"btn btn-small\" onclick=\"window.location='" . $this->GetEditUrl(EW_TABLE_SHOW_DETAIL . "=divorce_tb") . "'\">" . $Language->Phrase("MasterDetailEditLink") . "</button>";
		if ($GLOBALS["divorce_tb_grid"]->DetailAdd && $Security->IsLoggedIn() && $Security->IsLoggedIn())
			$btngrp .= "<button type=\"button\" class=\"btn btn-small\" onclick=\"window.location='" . $this->GetCopyUrl(EW_TABLE_SHOW_DETAIL . "=divorce_tb") . "'\">" . $Language->Phrase("MasterDetailCopyLink") . "</button>";
		$btngrp .= "</div>";
		if ($link <> "") {
			$btngrps .= $btngrp;
			$option->Body .= "<div class=\"hide ewPreview\">" . $link . $btngrp . "</div>";
		}
		$sSqlWrk = "`uid`=" . ew_AdjustSql($this->uid->CurrentValue) . "";

		// Column "detail_children_details"
		$link = "";
		$option = &$this->ListOptions->Items["detail_children_details"];
		$url = "children_detailspreview.php?f=" . ew_Encrypt($sSqlWrk);
		$btngrp = "<div data-table=\"children_details\" data-url=\"" . $url . "\" class=\"btn-group\">";
		if ($Security->IsLoggedIn()) {			
			$label = $Language->TablePhrase("children_details", "TblCaption");
			$link = "<li><a href=\"#\" data-toggle=\"tab\" data-table=\"children_details\" data-url=\"" . $url . "\">" . $label . "</a></li>";			
			$links .= $link;
			$detaillnk = ew_JsEncode3("children_detailslist.php?" . EW_TABLE_SHOW_MASTER . "=comprehensivewill_tb&uid=" . urlencode(strval($this->uid->CurrentValue)) . "");
			$btngrp .= "<button type=\"button\" class=\"btn btn-small\" onclick=\"window.location='" . $detaillnk . "'\">" . $Language->TablePhrase("children_details", "TblCaption") . "</button>";
		}
		if ($GLOBALS["children_details_grid"]->DetailView && $Security->IsLoggedIn() && $Security->IsLoggedIn())
			$btngrp .= "<button type=\"button\" class=\"btn btn-small\" onclick=\"window.location='" . $this->GetViewUrl(EW_TABLE_SHOW_DETAIL . "=children_details") . "'\">" . $Language->Phrase("MasterDetailViewLink") . "</button>";
		if ($GLOBALS["children_details_grid"]->DetailEdit && $Security->IsLoggedIn() && $Security->IsLoggedIn())
			$btngrp .= "<button type=\"button\" class=\"btn btn-small\" onclick=\"window.location='" . $this->GetEditUrl(EW_TABLE_SHOW_DETAIL . "=children_details") . "'\">" . $Language->Phrase("MasterDetailEditLink") . "</button>";
		if ($GLOBALS["children_details_grid"]->DetailAdd && $Security->IsLoggedIn() && $Security->IsLoggedIn())
			$btngrp .= "<button type=\"button\" class=\"btn btn-small\" onclick=\"window.location='" . $this->GetCopyUrl(EW_TABLE_SHOW_DETAIL . "=children_details") . "'\">" . $Language->Phrase("MasterDetailCopyLink") . "</button>";
		$btngrp .= "</div>";
		if ($link <> "") {
			$btngrps .= $btngrp;
			$option->Body .= "<div class=\"hide ewPreview\">" . $link . $btngrp . "</div>";
		}
		$sSqlWrk = "`uid`=" . ew_AdjustSql($this->uid->CurrentValue) . "";

		// Column "detail_beneficiary_dump"
		$link = "";
		$option = &$this->ListOptions->Items["detail_beneficiary_dump"];
		$url = "beneficiary_dumppreview.php?f=" . ew_Encrypt($sSqlWrk);
		$btngrp = "<div data-table=\"beneficiary_dump\" data-url=\"" . $url . "\" class=\"btn-group\">";
		if ($Security->IsLoggedIn()) {			
			$label = $Language->TablePhrase("beneficiary_dump", "TblCaption");
			$link = "<li><a href=\"#\" data-toggle=\"tab\" data-table=\"beneficiary_dump\" data-url=\"" . $url . "\">" . $label . "</a></li>";			
			$links .= $link;
			$detaillnk = ew_JsEncode3("beneficiary_dumplist.php?" . EW_TABLE_SHOW_MASTER . "=comprehensivewill_tb&uid=" . urlencode(strval($this->uid->CurrentValue)) . "");
			$btngrp .= "<button type=\"button\" class=\"btn btn-small\" onclick=\"window.location='" . $detaillnk . "'\">" . $Language->TablePhrase("beneficiary_dump", "TblCaption") . "</button>";
		}
		if ($GLOBALS["beneficiary_dump_grid"]->DetailView && $Security->IsLoggedIn() && $Security->IsLoggedIn())
			$btngrp .= "<button type=\"button\" class=\"btn btn-small\" onclick=\"window.location='" . $this->GetViewUrl(EW_TABLE_SHOW_DETAIL . "=beneficiary_dump") . "'\">" . $Language->Phrase("MasterDetailViewLink") . "</button>";
		if ($GLOBALS["beneficiary_dump_grid"]->DetailEdit && $Security->IsLoggedIn() && $Security->IsLoggedIn())
			$btngrp .= "<button type=\"button\" class=\"btn btn-small\" onclick=\"window.location='" . $this->GetEditUrl(EW_TABLE_SHOW_DETAIL . "=beneficiary_dump") . "'\">" . $Language->Phrase("MasterDetailEditLink") . "</button>";
		if ($GLOBALS["beneficiary_dump_grid"]->DetailAdd && $Security->IsLoggedIn() && $Security->IsLoggedIn())
			$btngrp .= "<button type=\"button\" class=\"btn btn-small\" onclick=\"window.location='" . $this->GetCopyUrl(EW_TABLE_SHOW_DETAIL . "=beneficiary_dump") . "'\">" . $Language->Phrase("MasterDetailCopyLink") . "</button>";
		$btngrp .= "</div>";
		if ($link <> "") {
			$btngrps .= $btngrp;
			$option->Body .= "<div class=\"hide ewPreview\">" . $link . $btngrp . "</div>";
		}
		$sSqlWrk = "`uid`=" . ew_AdjustSql($this->uid->CurrentValue) . "";

		// Column "detail_alt_beneficiary"
		$link = "";
		$option = &$this->ListOptions->Items["detail_alt_beneficiary"];
		$url = "alt_beneficiarypreview.php?f=" . ew_Encrypt($sSqlWrk);
		$btngrp = "<div data-table=\"alt_beneficiary\" data-url=\"" . $url . "\" class=\"btn-group\">";
		if ($Security->IsLoggedIn()) {			
			$label = $Language->TablePhrase("alt_beneficiary", "TblCaption");
			$link = "<li><a href=\"#\" data-toggle=\"tab\" data-table=\"alt_beneficiary\" data-url=\"" . $url . "\">" . $label . "</a></li>";			
			$links .= $link;
			$detaillnk = ew_JsEncode3("alt_beneficiarylist.php?" . EW_TABLE_SHOW_MASTER . "=comprehensivewill_tb&uid=" . urlencode(strval($this->uid->CurrentValue)) . "");
			$btngrp .= "<button type=\"button\" class=\"btn btn-small\" onclick=\"window.location='" . $detaillnk . "'\">" . $Language->TablePhrase("alt_beneficiary", "TblCaption") . "</button>";
		}
		if ($GLOBALS["alt_beneficiary_grid"]->DetailView && $Security->IsLoggedIn() && $Security->IsLoggedIn())
			$btngrp .= "<button type=\"button\" class=\"btn btn-small\" onclick=\"window.location='" . $this->GetViewUrl(EW_TABLE_SHOW_DETAIL . "=alt_beneficiary") . "'\">" . $Language->Phrase("MasterDetailViewLink") . "</button>";
		if ($GLOBALS["alt_beneficiary_grid"]->DetailEdit && $Security->IsLoggedIn() && $Security->IsLoggedIn())
			$btngrp .= "<button type=\"button\" class=\"btn btn-small\" onclick=\"window.location='" . $this->GetEditUrl(EW_TABLE_SHOW_DETAIL . "=alt_beneficiary") . "'\">" . $Language->Phrase("MasterDetailEditLink") . "</button>";
		if ($GLOBALS["alt_beneficiary_grid"]->DetailAdd && $Security->IsLoggedIn() && $Security->IsLoggedIn())
			$btngrp .= "<button type=\"button\" class=\"btn btn-small\" onclick=\"window.location='" . $this->GetCopyUrl(EW_TABLE_SHOW_DETAIL . "=alt_beneficiary") . "'\">" . $Language->Phrase("MasterDetailCopyLink") . "</button>";
		$btngrp .= "</div>";
		if ($link <> "") {
			$btngrps .= $btngrp;
			$option->Body .= "<div class=\"hide ewPreview\">" . $link . $btngrp . "</div>";
		}
		$sSqlWrk = "`uid`=" . ew_AdjustSql($this->uid->CurrentValue) . "";

		// Column "detail_assets_tb"
		$link = "";
		$option = &$this->ListOptions->Items["detail_assets_tb"];
		$url = "assets_tbpreview.php?f=" . ew_Encrypt($sSqlWrk);
		$btngrp = "<div data-table=\"assets_tb\" data-url=\"" . $url . "\" class=\"btn-group\">";
		if ($Security->IsLoggedIn()) {			
			$label = $Language->TablePhrase("assets_tb", "TblCaption");
			$link = "<li><a href=\"#\" data-toggle=\"tab\" data-table=\"assets_tb\" data-url=\"" . $url . "\">" . $label . "</a></li>";			
			$links .= $link;
			$detaillnk = ew_JsEncode3("assets_tblist.php?" . EW_TABLE_SHOW_MASTER . "=comprehensivewill_tb&uid=" . urlencode(strval($this->uid->CurrentValue)) . "");
			$btngrp .= "<button type=\"button\" class=\"btn btn-small\" onclick=\"window.location='" . $detaillnk . "'\">" . $Language->TablePhrase("assets_tb", "TblCaption") . "</button>";
		}
		if ($GLOBALS["assets_tb_grid"]->DetailView && $Security->IsLoggedIn() && $Security->IsLoggedIn())
			$btngrp .= "<button type=\"button\" class=\"btn btn-small\" onclick=\"window.location='" . $this->GetViewUrl(EW_TABLE_SHOW_DETAIL . "=assets_tb") . "'\">" . $Language->Phrase("MasterDetailViewLink") . "</button>";
		if ($GLOBALS["assets_tb_grid"]->DetailEdit && $Security->IsLoggedIn() && $Security->IsLoggedIn())
			$btngrp .= "<button type=\"button\" class=\"btn btn-small\" onclick=\"window.location='" . $this->GetEditUrl(EW_TABLE_SHOW_DETAIL . "=assets_tb") . "'\">" . $Language->Phrase("MasterDetailEditLink") . "</button>";
		if ($GLOBALS["assets_tb_grid"]->DetailAdd && $Security->IsLoggedIn() && $Security->IsLoggedIn())
			$btngrp .= "<button type=\"button\" class=\"btn btn-small\" onclick=\"window.location='" . $this->GetCopyUrl(EW_TABLE_SHOW_DETAIL . "=assets_tb") . "'\">" . $Language->Phrase("MasterDetailCopyLink") . "</button>";
		$btngrp .= "</div>";
		if ($link <> "") {
			$btngrps .= $btngrp;
			$option->Body .= "<div class=\"hide ewPreview\">" . $link . $btngrp . "</div>";
		}
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
			$detaillnk = ew_JsEncode3("overall_assetlist.php?" . EW_TABLE_SHOW_MASTER . "=comprehensivewill_tb&uid=" . urlencode(strval($this->uid->CurrentValue)) . "");
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
		$sSqlWrk = "`uid`=" . ew_AdjustSql($this->uid->CurrentValue) . "";

		// Column "detail_executor_tb"
		$link = "";
		$option = &$this->ListOptions->Items["detail_executor_tb"];
		$url = "executor_tbpreview.php?f=" . ew_Encrypt($sSqlWrk);
		$btngrp = "<div data-table=\"executor_tb\" data-url=\"" . $url . "\" class=\"btn-group\">";
		if ($Security->IsLoggedIn()) {			
			$label = $Language->TablePhrase("executor_tb", "TblCaption");
			$link = "<li><a href=\"#\" data-toggle=\"tab\" data-table=\"executor_tb\" data-url=\"" . $url . "\">" . $label . "</a></li>";			
			$links .= $link;
			$detaillnk = ew_JsEncode3("executor_tblist.php?" . EW_TABLE_SHOW_MASTER . "=comprehensivewill_tb&uid=" . urlencode(strval($this->uid->CurrentValue)) . "");
			$btngrp .= "<button type=\"button\" class=\"btn btn-small\" onclick=\"window.location='" . $detaillnk . "'\">" . $Language->TablePhrase("executor_tb", "TblCaption") . "</button>";
		}
		if ($GLOBALS["executor_tb_grid"]->DetailView && $Security->IsLoggedIn() && $Security->IsLoggedIn())
			$btngrp .= "<button type=\"button\" class=\"btn btn-small\" onclick=\"window.location='" . $this->GetViewUrl(EW_TABLE_SHOW_DETAIL . "=executor_tb") . "'\">" . $Language->Phrase("MasterDetailViewLink") . "</button>";
		if ($GLOBALS["executor_tb_grid"]->DetailEdit && $Security->IsLoggedIn() && $Security->IsLoggedIn())
			$btngrp .= "<button type=\"button\" class=\"btn btn-small\" onclick=\"window.location='" . $this->GetEditUrl(EW_TABLE_SHOW_DETAIL . "=executor_tb") . "'\">" . $Language->Phrase("MasterDetailEditLink") . "</button>";
		if ($GLOBALS["executor_tb_grid"]->DetailAdd && $Security->IsLoggedIn() && $Security->IsLoggedIn())
			$btngrp .= "<button type=\"button\" class=\"btn btn-small\" onclick=\"window.location='" . $this->GetCopyUrl(EW_TABLE_SHOW_DETAIL . "=executor_tb") . "'\">" . $Language->Phrase("MasterDetailCopyLink") . "</button>";
		$btngrp .= "</div>";
		if ($link <> "") {
			$btngrps .= $btngrp;
			$option->Body .= "<div class=\"hide ewPreview\">" . $link . $btngrp . "</div>";
		}
		$sSqlWrk = "`uid`=" . ew_AdjustSql($this->uid->CurrentValue) . "";

		// Column "detail_trustee_tb"
		$link = "";
		$option = &$this->ListOptions->Items["detail_trustee_tb"];
		$url = "trustee_tbpreview.php?f=" . ew_Encrypt($sSqlWrk);
		$btngrp = "<div data-table=\"trustee_tb\" data-url=\"" . $url . "\" class=\"btn-group\">";
		if ($Security->IsLoggedIn()) {			
			$label = $Language->TablePhrase("trustee_tb", "TblCaption");
			$link = "<li><a href=\"#\" data-toggle=\"tab\" data-table=\"trustee_tb\" data-url=\"" . $url . "\">" . $label . "</a></li>";			
			$links .= $link;
			$detaillnk = ew_JsEncode3("trustee_tblist.php?" . EW_TABLE_SHOW_MASTER . "=comprehensivewill_tb&uid=" . urlencode(strval($this->uid->CurrentValue)) . "");
			$btngrp .= "<button type=\"button\" class=\"btn btn-small\" onclick=\"window.location='" . $detaillnk . "'\">" . $Language->TablePhrase("trustee_tb", "TblCaption") . "</button>";
		}
		if ($GLOBALS["trustee_tb_grid"]->DetailView && $Security->IsLoggedIn() && $Security->IsLoggedIn())
			$btngrp .= "<button type=\"button\" class=\"btn btn-small\" onclick=\"window.location='" . $this->GetViewUrl(EW_TABLE_SHOW_DETAIL . "=trustee_tb") . "'\">" . $Language->Phrase("MasterDetailViewLink") . "</button>";
		if ($GLOBALS["trustee_tb_grid"]->DetailEdit && $Security->IsLoggedIn() && $Security->IsLoggedIn())
			$btngrp .= "<button type=\"button\" class=\"btn btn-small\" onclick=\"window.location='" . $this->GetEditUrl(EW_TABLE_SHOW_DETAIL . "=trustee_tb") . "'\">" . $Language->Phrase("MasterDetailEditLink") . "</button>";
		if ($GLOBALS["trustee_tb_grid"]->DetailAdd && $Security->IsLoggedIn() && $Security->IsLoggedIn())
			$btngrp .= "<button type=\"button\" class=\"btn btn-small\" onclick=\"window.location='" . $this->GetCopyUrl(EW_TABLE_SHOW_DETAIL . "=trustee_tb") . "'\">" . $Language->Phrase("MasterDetailCopyLink") . "</button>";
		$btngrp .= "</div>";
		if ($link <> "") {
			$btngrps .= $btngrp;
			$option->Body .= "<div class=\"hide ewPreview\">" . $link . $btngrp . "</div>";
		}
		$sSqlWrk = "`uid`=" . ew_AdjustSql($this->uid->CurrentValue) . "";

		// Column "detail_witness_tb"
		$link = "";
		$option = &$this->ListOptions->Items["detail_witness_tb"];
		$url = "witness_tbpreview.php?f=" . ew_Encrypt($sSqlWrk);
		$btngrp = "<div data-table=\"witness_tb\" data-url=\"" . $url . "\" class=\"btn-group\">";
		if ($Security->IsLoggedIn()) {			
			$label = $Language->TablePhrase("witness_tb", "TblCaption");
			$link = "<li><a href=\"#\" data-toggle=\"tab\" data-table=\"witness_tb\" data-url=\"" . $url . "\">" . $label . "</a></li>";			
			$links .= $link;
			$detaillnk = ew_JsEncode3("witness_tblist.php?" . EW_TABLE_SHOW_MASTER . "=comprehensivewill_tb&uid=" . urlencode(strval($this->uid->CurrentValue)) . "");
			$btngrp .= "<button type=\"button\" class=\"btn btn-small\" onclick=\"window.location='" . $detaillnk . "'\">" . $Language->TablePhrase("witness_tb", "TblCaption") . "</button>";
		}
		if ($GLOBALS["witness_tb_grid"]->DetailView && $Security->IsLoggedIn() && $Security->IsLoggedIn())
			$btngrp .= "<button type=\"button\" class=\"btn btn-small\" onclick=\"window.location='" . $this->GetViewUrl(EW_TABLE_SHOW_DETAIL . "=witness_tb") . "'\">" . $Language->Phrase("MasterDetailViewLink") . "</button>";
		if ($GLOBALS["witness_tb_grid"]->DetailEdit && $Security->IsLoggedIn() && $Security->IsLoggedIn())
			$btngrp .= "<button type=\"button\" class=\"btn btn-small\" onclick=\"window.location='" . $this->GetEditUrl(EW_TABLE_SHOW_DETAIL . "=witness_tb") . "'\">" . $Language->Phrase("MasterDetailEditLink") . "</button>";
		if ($GLOBALS["witness_tb_grid"]->DetailAdd && $Security->IsLoggedIn() && $Security->IsLoggedIn())
			$btngrp .= "<button type=\"button\" class=\"btn btn-small\" onclick=\"window.location='" . $this->GetCopyUrl(EW_TABLE_SHOW_DETAIL . "=witness_tb") . "'\">" . $Language->Phrase("MasterDetailCopyLink") . "</button>";
		$btngrp .= "</div>";
		if ($link <> "") {
			$btngrps .= $btngrp;
			$option->Body .= "<div class=\"hide ewPreview\">" . $link . $btngrp . "</div>";
		}
		$sSqlWrk = "`uid`=" . ew_AdjustSql($this->uid->CurrentValue) . "";

		// Column "detail_addinfo_tb"
		$link = "";
		$option = &$this->ListOptions->Items["detail_addinfo_tb"];
		$url = "addinfo_tbpreview.php?f=" . ew_Encrypt($sSqlWrk);
		$btngrp = "<div data-table=\"addinfo_tb\" data-url=\"" . $url . "\" class=\"btn-group\">";
		if ($Security->IsLoggedIn()) {			
			$label = $Language->TablePhrase("addinfo_tb", "TblCaption");
			$link = "<li><a href=\"#\" data-toggle=\"tab\" data-table=\"addinfo_tb\" data-url=\"" . $url . "\">" . $label . "</a></li>";			
			$links .= $link;
			$detaillnk = ew_JsEncode3("addinfo_tblist.php?" . EW_TABLE_SHOW_MASTER . "=comprehensivewill_tb&uid=" . urlencode(strval($this->uid->CurrentValue)) . "");
			$btngrp .= "<button type=\"button\" class=\"btn btn-small\" onclick=\"window.location='" . $detaillnk . "'\">" . $Language->TablePhrase("addinfo_tb", "TblCaption") . "</button>";
		}
		if ($GLOBALS["addinfo_tb_grid"]->DetailView && $Security->IsLoggedIn() && $Security->IsLoggedIn())
			$btngrp .= "<button type=\"button\" class=\"btn btn-small\" onclick=\"window.location='" . $this->GetViewUrl(EW_TABLE_SHOW_DETAIL . "=addinfo_tb") . "'\">" . $Language->Phrase("MasterDetailViewLink") . "</button>";
		if ($GLOBALS["addinfo_tb_grid"]->DetailEdit && $Security->IsLoggedIn() && $Security->IsLoggedIn())
			$btngrp .= "<button type=\"button\" class=\"btn btn-small\" onclick=\"window.location='" . $this->GetEditUrl(EW_TABLE_SHOW_DETAIL . "=addinfo_tb") . "'\">" . $Language->Phrase("MasterDetailEditLink") . "</button>";
		if ($GLOBALS["addinfo_tb_grid"]->DetailAdd && $Security->IsLoggedIn() && $Security->IsLoggedIn())
			$btngrp .= "<button type=\"button\" class=\"btn btn-small\" onclick=\"window.location='" . $this->GetCopyUrl(EW_TABLE_SHOW_DETAIL . "=addinfo_tb") . "'\">" . $Language->Phrase("MasterDetailCopyLink") . "</button>";
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
		$this->willtype->setDbValue($rs->fields('willtype'));
		$this->fullname->setDbValue($rs->fields('fullname'));
		$this->address->setDbValue($rs->fields('address'));
		$this->_email->setDbValue($rs->fields('email'));
		$this->phoneno->setDbValue($rs->fields('phoneno'));
		$this->aphoneno->setDbValue($rs->fields('aphoneno'));
		$this->gender->setDbValue($rs->fields('gender'));
		$this->dob->setDbValue($rs->fields('dob'));
		$this->state->setDbValue($rs->fields('state'));
		$this->nationality->setDbValue($rs->fields('nationality'));
		$this->lga->setDbValue($rs->fields('lga'));
		$this->employmentstatus->setDbValue($rs->fields('employmentstatus'));
		$this->employer->setDbValue($rs->fields('employer'));
		$this->employerphone->setDbValue($rs->fields('employerphone'));
		$this->employeraddr->setDbValue($rs->fields('employeraddr'));
		$this->maritalstatus->setDbValue($rs->fields('maritalstatus'));
		$this->spname->setDbValue($rs->fields('spname'));
		$this->spemail->setDbValue($rs->fields('spemail'));
		$this->spphone->setDbValue($rs->fields('spphone'));
		$this->sdob->setDbValue($rs->fields('sdob'));
		$this->spaddr->setDbValue($rs->fields('spaddr'));
		$this->spcity->setDbValue($rs->fields('spcity'));
		$this->spstate->setDbValue($rs->fields('spstate'));
		$this->marriagetype->setDbValue($rs->fields('marriagetype'));
		$this->marriageyear->setDbValue($rs->fields('marriageyear'));
		$this->marriagecert->setDbValue($rs->fields('marriagecert'));
		$this->marriagecity->setDbValue($rs->fields('marriagecity'));
		$this->marriagecountry->setDbValue($rs->fields('marriagecountry'));
		$this->divorce->setDbValue($rs->fields('divorce'));
		$this->divorceyear->setDbValue($rs->fields('divorceyear'));
		$this->addinfo->setDbValue($rs->fields('addinfo'));
		$this->datecreated->setDbValue($rs->fields('datecreated'));
	}

	// Load DbValue from recordset
	function LoadDbValues(&$rs) {
		if (!$rs || !is_array($rs) && $rs->EOF) return;
		$row = is_array($rs) ? $rs : $rs->fields;
		$this->id->DbValue = $row['id'];
		$this->uid->DbValue = $row['uid'];
		$this->willtype->DbValue = $row['willtype'];
		$this->fullname->DbValue = $row['fullname'];
		$this->address->DbValue = $row['address'];
		$this->_email->DbValue = $row['email'];
		$this->phoneno->DbValue = $row['phoneno'];
		$this->aphoneno->DbValue = $row['aphoneno'];
		$this->gender->DbValue = $row['gender'];
		$this->dob->DbValue = $row['dob'];
		$this->state->DbValue = $row['state'];
		$this->nationality->DbValue = $row['nationality'];
		$this->lga->DbValue = $row['lga'];
		$this->employmentstatus->DbValue = $row['employmentstatus'];
		$this->employer->DbValue = $row['employer'];
		$this->employerphone->DbValue = $row['employerphone'];
		$this->employeraddr->DbValue = $row['employeraddr'];
		$this->maritalstatus->DbValue = $row['maritalstatus'];
		$this->spname->DbValue = $row['spname'];
		$this->spemail->DbValue = $row['spemail'];
		$this->spphone->DbValue = $row['spphone'];
		$this->sdob->DbValue = $row['sdob'];
		$this->spaddr->DbValue = $row['spaddr'];
		$this->spcity->DbValue = $row['spcity'];
		$this->spstate->DbValue = $row['spstate'];
		$this->marriagetype->DbValue = $row['marriagetype'];
		$this->marriageyear->DbValue = $row['marriageyear'];
		$this->marriagecert->DbValue = $row['marriagecert'];
		$this->marriagecity->DbValue = $row['marriagecity'];
		$this->marriagecountry->DbValue = $row['marriagecountry'];
		$this->divorce->DbValue = $row['divorce'];
		$this->divorceyear->DbValue = $row['divorceyear'];
		$this->addinfo->DbValue = $row['addinfo'];
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
		// willtype
		// fullname
		// address
		// email
		// phoneno
		// aphoneno
		// gender
		// dob
		// state
		// nationality
		// lga
		// employmentstatus
		// employer
		// employerphone
		// employeraddr
		// maritalstatus
		// spname
		// spemail
		// spphone
		// sdob
		// spaddr
		// spcity
		// spstate
		// marriagetype
		// marriageyear
		// marriagecert
		// marriagecity
		// marriagecountry
		// divorce
		// divorceyear
		// addinfo
		// datecreated

		if ($this->RowType == EW_ROWTYPE_VIEW) { // View row

			// id
			$this->id->ViewValue = $this->id->CurrentValue;
			$this->id->ViewCustomAttributes = "";

			// uid
			$this->uid->ViewValue = $this->uid->CurrentValue;
			$this->uid->ViewCustomAttributes = "";

			// willtype
			$this->willtype->ViewValue = $this->willtype->CurrentValue;
			$this->willtype->ViewCustomAttributes = "";

			// fullname
			$this->fullname->ViewValue = $this->fullname->CurrentValue;
			$this->fullname->ViewCustomAttributes = "";

			// address
			$this->address->ViewValue = $this->address->CurrentValue;
			$this->address->ViewCustomAttributes = "";

			// email
			$this->_email->ViewValue = $this->_email->CurrentValue;
			$this->_email->ViewCustomAttributes = "";

			// phoneno
			$this->phoneno->ViewValue = $this->phoneno->CurrentValue;
			$this->phoneno->ViewCustomAttributes = "";

			// aphoneno
			$this->aphoneno->ViewValue = $this->aphoneno->CurrentValue;
			$this->aphoneno->ViewCustomAttributes = "";

			// gender
			$this->gender->ViewValue = $this->gender->CurrentValue;
			$this->gender->ViewCustomAttributes = "";

			// dob
			$this->dob->ViewValue = $this->dob->CurrentValue;
			$this->dob->ViewCustomAttributes = "";

			// state
			$this->state->ViewValue = $this->state->CurrentValue;
			$this->state->ViewCustomAttributes = "";

			// nationality
			$this->nationality->ViewValue = $this->nationality->CurrentValue;
			$this->nationality->ViewCustomAttributes = "";

			// lga
			$this->lga->ViewValue = $this->lga->CurrentValue;
			$this->lga->ViewCustomAttributes = "";

			// employmentstatus
			$this->employmentstatus->ViewValue = $this->employmentstatus->CurrentValue;
			$this->employmentstatus->ViewCustomAttributes = "";

			// employer
			$this->employer->ViewValue = $this->employer->CurrentValue;
			$this->employer->ViewCustomAttributes = "";

			// employerphone
			$this->employerphone->ViewValue = $this->employerphone->CurrentValue;
			$this->employerphone->ViewCustomAttributes = "";

			// employeraddr
			$this->employeraddr->ViewValue = $this->employeraddr->CurrentValue;
			$this->employeraddr->ViewCustomAttributes = "";

			// maritalstatus
			$this->maritalstatus->ViewValue = $this->maritalstatus->CurrentValue;
			$this->maritalstatus->ViewCustomAttributes = "";

			// spname
			$this->spname->ViewValue = $this->spname->CurrentValue;
			$this->spname->ViewCustomAttributes = "";

			// spemail
			$this->spemail->ViewValue = $this->spemail->CurrentValue;
			$this->spemail->ViewCustomAttributes = "";

			// spphone
			$this->spphone->ViewValue = $this->spphone->CurrentValue;
			$this->spphone->ViewCustomAttributes = "";

			// sdob
			$this->sdob->ViewValue = $this->sdob->CurrentValue;
			$this->sdob->ViewCustomAttributes = "";

			// spaddr
			$this->spaddr->ViewValue = $this->spaddr->CurrentValue;
			$this->spaddr->ViewCustomAttributes = "";

			// spcity
			$this->spcity->ViewValue = $this->spcity->CurrentValue;
			$this->spcity->ViewCustomAttributes = "";

			// spstate
			$this->spstate->ViewValue = $this->spstate->CurrentValue;
			$this->spstate->ViewCustomAttributes = "";

			// marriagetype
			$this->marriagetype->ViewValue = $this->marriagetype->CurrentValue;
			$this->marriagetype->ViewCustomAttributes = "";

			// marriageyear
			$this->marriageyear->ViewValue = $this->marriageyear->CurrentValue;
			$this->marriageyear->ViewCustomAttributes = "";

			// marriagecert
			$this->marriagecert->ViewValue = $this->marriagecert->CurrentValue;
			$this->marriagecert->ViewCustomAttributes = "";

			// marriagecity
			$this->marriagecity->ViewValue = $this->marriagecity->CurrentValue;
			$this->marriagecity->ViewCustomAttributes = "";

			// marriagecountry
			$this->marriagecountry->ViewValue = $this->marriagecountry->CurrentValue;
			$this->marriagecountry->ViewCustomAttributes = "";

			// divorce
			$this->divorce->ViewValue = $this->divorce->CurrentValue;
			$this->divorce->ViewCustomAttributes = "";

			// divorceyear
			$this->divorceyear->ViewValue = $this->divorceyear->CurrentValue;
			$this->divorceyear->ViewCustomAttributes = "";

			// addinfo
			$this->addinfo->ViewValue = $this->addinfo->CurrentValue;
			$this->addinfo->ViewCustomAttributes = "";

			// datecreated
			$this->datecreated->ViewValue = $this->datecreated->CurrentValue;
			$this->datecreated->ViewCustomAttributes = "";

			// willtype
			$this->willtype->LinkCustomAttributes = "";
			$this->willtype->HrefValue = "";
			$this->willtype->TooltipValue = "";

			// fullname
			$this->fullname->LinkCustomAttributes = "";
			if (!ew_Empty($this->uid->CurrentValue)) {
				$this->fullname->HrefValue = "http://tisvdigital.com/trustees/portal/admincomprehensivewill-preview.php?a=" . ((!empty($this->uid->ViewValue)) ? $this->uid->ViewValue : $this->uid->CurrentValue); // Add prefix/suffix
				$this->fullname->LinkAttrs["target"] = "_blank"; // Add target
				if ($this->Export <> "") $this->fullname->HrefValue = ew_ConvertFullUrl($this->fullname->HrefValue);
			} else {
				$this->fullname->HrefValue = "";
			}
			$this->fullname->TooltipValue = "";

			// email
			$this->_email->LinkCustomAttributes = "";
			$this->_email->HrefValue = "";
			$this->_email->TooltipValue = "";

			// phoneno
			$this->phoneno->LinkCustomAttributes = "";
			$this->phoneno->HrefValue = "";
			$this->phoneno->TooltipValue = "";

			// aphoneno
			$this->aphoneno->LinkCustomAttributes = "";
			$this->aphoneno->HrefValue = "";
			$this->aphoneno->TooltipValue = "";

			// gender
			$this->gender->LinkCustomAttributes = "";
			$this->gender->HrefValue = "";
			$this->gender->TooltipValue = "";

			// dob
			$this->dob->LinkCustomAttributes = "";
			$this->dob->HrefValue = "";
			$this->dob->TooltipValue = "";

			// state
			$this->state->LinkCustomAttributes = "";
			$this->state->HrefValue = "";
			$this->state->TooltipValue = "";

			// nationality
			$this->nationality->LinkCustomAttributes = "";
			$this->nationality->HrefValue = "";
			$this->nationality->TooltipValue = "";

			// lga
			$this->lga->LinkCustomAttributes = "";
			$this->lga->HrefValue = "";
			$this->lga->TooltipValue = "";

			// employmentstatus
			$this->employmentstatus->LinkCustomAttributes = "";
			$this->employmentstatus->HrefValue = "";
			$this->employmentstatus->TooltipValue = "";

			// employerphone
			$this->employerphone->LinkCustomAttributes = "";
			$this->employerphone->HrefValue = "";
			$this->employerphone->TooltipValue = "";

			// maritalstatus
			$this->maritalstatus->LinkCustomAttributes = "";
			$this->maritalstatus->HrefValue = "";
			$this->maritalstatus->TooltipValue = "";

			// spname
			$this->spname->LinkCustomAttributes = "";
			$this->spname->HrefValue = "";
			$this->spname->TooltipValue = "";

			// spemail
			$this->spemail->LinkCustomAttributes = "";
			$this->spemail->HrefValue = "";
			$this->spemail->TooltipValue = "";

			// spphone
			$this->spphone->LinkCustomAttributes = "";
			$this->spphone->HrefValue = "";
			$this->spphone->TooltipValue = "";

			// sdob
			$this->sdob->LinkCustomAttributes = "";
			$this->sdob->HrefValue = "";
			$this->sdob->TooltipValue = "";

			// spcity
			$this->spcity->LinkCustomAttributes = "";
			$this->spcity->HrefValue = "";
			$this->spcity->TooltipValue = "";

			// spstate
			$this->spstate->LinkCustomAttributes = "";
			$this->spstate->HrefValue = "";
			$this->spstate->TooltipValue = "";

			// marriagetype
			$this->marriagetype->LinkCustomAttributes = "";
			$this->marriagetype->HrefValue = "";
			$this->marriagetype->TooltipValue = "";

			// marriageyear
			$this->marriageyear->LinkCustomAttributes = "";
			$this->marriageyear->HrefValue = "";
			$this->marriageyear->TooltipValue = "";

			// marriagecert
			$this->marriagecert->LinkCustomAttributes = "";
			$this->marriagecert->HrefValue = "";
			$this->marriagecert->TooltipValue = "";

			// marriagecity
			$this->marriagecity->LinkCustomAttributes = "";
			$this->marriagecity->HrefValue = "";
			$this->marriagecity->TooltipValue = "";

			// marriagecountry
			$this->marriagecountry->LinkCustomAttributes = "";
			$this->marriagecountry->HrefValue = "";
			$this->marriagecountry->TooltipValue = "";

			// divorce
			$this->divorce->LinkCustomAttributes = "";
			$this->divorce->HrefValue = "";
			$this->divorce->TooltipValue = "";

			// divorceyear
			$this->divorceyear->LinkCustomAttributes = "";
			$this->divorceyear->HrefValue = "";
			$this->divorceyear->TooltipValue = "";

			// addinfo
			$this->addinfo->LinkCustomAttributes = "";
			$this->addinfo->HrefValue = "";
			$this->addinfo->TooltipValue = "";

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
		$item->Body = "<a id=\"emf_comprehensivewill_tb\" href=\"javascript:void(0);\" class=\"ewExportLink ewEmail\" data-caption=\"" . $Language->Phrase("ExportToEmailText") . "\" onclick=\"ew_EmailDialogShow({lnk:'emf_comprehensivewill_tb',hdr:ewLanguage.Phrase('ExportToEmail'),f:document.fcomprehensivewill_tblist,sel:false});\">" . $Language->Phrase("ExportToEmail") . "</a>";
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
if (!isset($comprehensivewill_tb_list)) $comprehensivewill_tb_list = new ccomprehensivewill_tb_list();

// Page init
$comprehensivewill_tb_list->Page_Init();

// Page main
$comprehensivewill_tb_list->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$comprehensivewill_tb_list->Page_Render();
?>
<?php include_once "header.php" ?>
<?php if ($comprehensivewill_tb->Export == "") { ?>
<script type="text/javascript">

// Page object
var comprehensivewill_tb_list = new ew_Page("comprehensivewill_tb_list");
comprehensivewill_tb_list.PageID = "list"; // Page ID
var EW_PAGE_ID = comprehensivewill_tb_list.PageID; // For backward compatibility

// Form object
var fcomprehensivewill_tblist = new ew_Form("fcomprehensivewill_tblist");
fcomprehensivewill_tblist.FormKeyCountName = '<?php echo $comprehensivewill_tb_list->FormKeyCountName ?>';

// Form_CustomValidate event
fcomprehensivewill_tblist.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
fcomprehensivewill_tblist.ValidateRequired = true;
<?php } else { ?>
fcomprehensivewill_tblist.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
// Form object for search

var fcomprehensivewill_tblistsrch = new ew_Form("fcomprehensivewill_tblistsrch");
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
<?php if ($comprehensivewill_tb->Export == "") { ?>
<?php $Breadcrumb->Render(); ?>
<?php } ?>
<?php if ($comprehensivewill_tb_list->ExportOptions->Visible()) { ?>
<div class="ewListExportOptions"><?php $comprehensivewill_tb_list->ExportOptions->Render("body") ?></div>
<?php } ?>
<?php
	$bSelectLimit = EW_SELECT_LIMIT;
	if ($bSelectLimit) {
		$comprehensivewill_tb_list->TotalRecs = $comprehensivewill_tb->SelectRecordCount();
	} else {
		if ($comprehensivewill_tb_list->Recordset = $comprehensivewill_tb_list->LoadRecordset())
			$comprehensivewill_tb_list->TotalRecs = $comprehensivewill_tb_list->Recordset->RecordCount();
	}
	$comprehensivewill_tb_list->StartRec = 1;
	if ($comprehensivewill_tb_list->DisplayRecs <= 0 || ($comprehensivewill_tb->Export <> "" && $comprehensivewill_tb->ExportAll)) // Display all records
		$comprehensivewill_tb_list->DisplayRecs = $comprehensivewill_tb_list->TotalRecs;
	if (!($comprehensivewill_tb->Export <> "" && $comprehensivewill_tb->ExportAll))
		$comprehensivewill_tb_list->SetUpStartRec(); // Set up start record position
	if ($bSelectLimit)
		$comprehensivewill_tb_list->Recordset = $comprehensivewill_tb_list->LoadRecordset($comprehensivewill_tb_list->StartRec-1, $comprehensivewill_tb_list->DisplayRecs);
$comprehensivewill_tb_list->RenderOtherOptions();
?>
<?php if ($Security->IsLoggedIn()) { ?>
<?php if ($comprehensivewill_tb->Export == "" && $comprehensivewill_tb->CurrentAction == "") { ?>
<form name="fcomprehensivewill_tblistsrch" id="fcomprehensivewill_tblistsrch" class="ewForm form-inline" action="<?php echo ew_CurrentPage() ?>">
<table class="ewSearchTable"><tr><td>
<div class="accordion" id="fcomprehensivewill_tblistsrch_SearchGroup">
	<div class="accordion-group">
		<div class="accordion-heading">
<a class="accordion-toggle" data-toggle="collapse" data-parent="#fcomprehensivewill_tblistsrch_SearchGroup" href="#fcomprehensivewill_tblistsrch_SearchBody"><?php echo $Language->Phrase("Search") ?></a>
		</div>
		<div id="fcomprehensivewill_tblistsrch_SearchBody" class="accordion-body collapse in">
			<div class="accordion-inner">
<div id="fcomprehensivewill_tblistsrch_SearchPanel">
<input type="hidden" name="cmd" value="search">
<input type="hidden" name="t" value="comprehensivewill_tb">
<div class="ewBasicSearch">
<div id="xsr_1" class="ewRow">
	<div class="btn-group ewButtonGroup">
	<div class="input-append">
	<input type="text" name="<?php echo EW_TABLE_BASIC_SEARCH ?>" id="<?php echo EW_TABLE_BASIC_SEARCH ?>" class="input-large" value="<?php echo ew_HtmlEncode($comprehensivewill_tb_list->BasicSearch->getKeyword()) ?>" placeholder="<?php echo $Language->Phrase("Search") ?>">
	<button class="btn btn-primary ewButton" name="btnsubmit" id="btnsubmit" type="submit"><?php echo $Language->Phrase("QuickSearchBtn") ?></button>
	</div>
	</div>
	<div class="btn-group ewButtonGroup">
	<a class="btn ewShowAll" href="<?php echo $comprehensivewill_tb_list->PageUrl() ?>cmd=reset"><?php echo $Language->Phrase("ShowAll") ?></a>
</div>
<div id="xsr_2" class="ewRow">
	<label class="inline radio ewRadio" style="white-space: nowrap;"><input type="radio" name="<?php echo EW_TABLE_BASIC_SEARCH_TYPE ?>" value="="<?php if ($comprehensivewill_tb_list->BasicSearch->getType() == "=") { ?> checked="checked"<?php } ?>><?php echo $Language->Phrase("ExactPhrase") ?></label>
	<label class="inline radio ewRadio" style="white-space: nowrap;"><input type="radio" name="<?php echo EW_TABLE_BASIC_SEARCH_TYPE ?>" value="AND"<?php if ($comprehensivewill_tb_list->BasicSearch->getType() == "AND") { ?> checked="checked"<?php } ?>><?php echo $Language->Phrase("AllWord") ?></label>
	<label class="inline radio ewRadio" style="white-space: nowrap;"><input type="radio" name="<?php echo EW_TABLE_BASIC_SEARCH_TYPE ?>" value="OR"<?php if ($comprehensivewill_tb_list->BasicSearch->getType() == "OR") { ?> checked="checked"<?php } ?>><?php echo $Language->Phrase("AnyWord") ?></label>
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
<?php $comprehensivewill_tb_list->ShowPageHeader(); ?>
<?php
$comprehensivewill_tb_list->ShowMessage();
?>
<table cellspacing="0" class="ewGrid"><tr><td class="ewGridContent">
<form name="fcomprehensivewill_tblist" id="fcomprehensivewill_tblist" class="ewForm form-horizontal" action="<?php echo ew_CurrentPage() ?>" method="post">
<input type="hidden" name="t" value="comprehensivewill_tb">
<div id="gmp_comprehensivewill_tb" class="ewGridMiddlePanel">
<?php if ($comprehensivewill_tb_list->TotalRecs > 0) { ?>
<table id="tbl_comprehensivewill_tblist" class="ewTable ewTableSeparate">
<?php echo $comprehensivewill_tb->TableCustomInnerHtml ?>
<thead><!-- Table header -->
	<tr class="ewTableHeader">
<?php

// Render list options
$comprehensivewill_tb_list->RenderListOptions();

// Render list options (header, left)
$comprehensivewill_tb_list->ListOptions->Render("header", "left");
?>
<?php if ($comprehensivewill_tb->willtype->Visible) { // willtype ?>
	<?php if ($comprehensivewill_tb->SortUrl($comprehensivewill_tb->willtype) == "") { ?>
		<td><div id="elh_comprehensivewill_tb_willtype" class="comprehensivewill_tb_willtype"><div class="ewTableHeaderCaption"><?php echo $comprehensivewill_tb->willtype->FldCaption() ?></div></div></td>
	<?php } else { ?>
		<td><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $comprehensivewill_tb->SortUrl($comprehensivewill_tb->willtype) ?>',2);"><div id="elh_comprehensivewill_tb_willtype" class="comprehensivewill_tb_willtype">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $comprehensivewill_tb->willtype->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($comprehensivewill_tb->willtype->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($comprehensivewill_tb->willtype->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></td>
	<?php } ?>
<?php } ?>		
<?php if ($comprehensivewill_tb->fullname->Visible) { // fullname ?>
	<?php if ($comprehensivewill_tb->SortUrl($comprehensivewill_tb->fullname) == "") { ?>
		<td><div id="elh_comprehensivewill_tb_fullname" class="comprehensivewill_tb_fullname"><div class="ewTableHeaderCaption"><?php echo $comprehensivewill_tb->fullname->FldCaption() ?></div></div></td>
	<?php } else { ?>
		<td><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $comprehensivewill_tb->SortUrl($comprehensivewill_tb->fullname) ?>',2);"><div id="elh_comprehensivewill_tb_fullname" class="comprehensivewill_tb_fullname">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $comprehensivewill_tb->fullname->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($comprehensivewill_tb->fullname->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($comprehensivewill_tb->fullname->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></td>
	<?php } ?>
<?php } ?>		
<?php if ($comprehensivewill_tb->_email->Visible) { // email ?>
	<?php if ($comprehensivewill_tb->SortUrl($comprehensivewill_tb->_email) == "") { ?>
		<td><div id="elh_comprehensivewill_tb__email" class="comprehensivewill_tb__email"><div class="ewTableHeaderCaption"><?php echo $comprehensivewill_tb->_email->FldCaption() ?></div></div></td>
	<?php } else { ?>
		<td><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $comprehensivewill_tb->SortUrl($comprehensivewill_tb->_email) ?>',2);"><div id="elh_comprehensivewill_tb__email" class="comprehensivewill_tb__email">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $comprehensivewill_tb->_email->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($comprehensivewill_tb->_email->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($comprehensivewill_tb->_email->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></td>
	<?php } ?>
<?php } ?>		
<?php if ($comprehensivewill_tb->phoneno->Visible) { // phoneno ?>
	<?php if ($comprehensivewill_tb->SortUrl($comprehensivewill_tb->phoneno) == "") { ?>
		<td><div id="elh_comprehensivewill_tb_phoneno" class="comprehensivewill_tb_phoneno"><div class="ewTableHeaderCaption"><?php echo $comprehensivewill_tb->phoneno->FldCaption() ?></div></div></td>
	<?php } else { ?>
		<td><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $comprehensivewill_tb->SortUrl($comprehensivewill_tb->phoneno) ?>',2);"><div id="elh_comprehensivewill_tb_phoneno" class="comprehensivewill_tb_phoneno">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $comprehensivewill_tb->phoneno->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($comprehensivewill_tb->phoneno->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($comprehensivewill_tb->phoneno->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></td>
	<?php } ?>
<?php } ?>		
<?php if ($comprehensivewill_tb->aphoneno->Visible) { // aphoneno ?>
	<?php if ($comprehensivewill_tb->SortUrl($comprehensivewill_tb->aphoneno) == "") { ?>
		<td><div id="elh_comprehensivewill_tb_aphoneno" class="comprehensivewill_tb_aphoneno"><div class="ewTableHeaderCaption"><?php echo $comprehensivewill_tb->aphoneno->FldCaption() ?></div></div></td>
	<?php } else { ?>
		<td><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $comprehensivewill_tb->SortUrl($comprehensivewill_tb->aphoneno) ?>',2);"><div id="elh_comprehensivewill_tb_aphoneno" class="comprehensivewill_tb_aphoneno">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $comprehensivewill_tb->aphoneno->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($comprehensivewill_tb->aphoneno->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($comprehensivewill_tb->aphoneno->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></td>
	<?php } ?>
<?php } ?>		
<?php if ($comprehensivewill_tb->gender->Visible) { // gender ?>
	<?php if ($comprehensivewill_tb->SortUrl($comprehensivewill_tb->gender) == "") { ?>
		<td><div id="elh_comprehensivewill_tb_gender" class="comprehensivewill_tb_gender"><div class="ewTableHeaderCaption"><?php echo $comprehensivewill_tb->gender->FldCaption() ?></div></div></td>
	<?php } else { ?>
		<td><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $comprehensivewill_tb->SortUrl($comprehensivewill_tb->gender) ?>',2);"><div id="elh_comprehensivewill_tb_gender" class="comprehensivewill_tb_gender">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $comprehensivewill_tb->gender->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($comprehensivewill_tb->gender->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($comprehensivewill_tb->gender->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></td>
	<?php } ?>
<?php } ?>		
<?php if ($comprehensivewill_tb->dob->Visible) { // dob ?>
	<?php if ($comprehensivewill_tb->SortUrl($comprehensivewill_tb->dob) == "") { ?>
		<td><div id="elh_comprehensivewill_tb_dob" class="comprehensivewill_tb_dob"><div class="ewTableHeaderCaption"><?php echo $comprehensivewill_tb->dob->FldCaption() ?></div></div></td>
	<?php } else { ?>
		<td><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $comprehensivewill_tb->SortUrl($comprehensivewill_tb->dob) ?>',2);"><div id="elh_comprehensivewill_tb_dob" class="comprehensivewill_tb_dob">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $comprehensivewill_tb->dob->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($comprehensivewill_tb->dob->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($comprehensivewill_tb->dob->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></td>
	<?php } ?>
<?php } ?>		
<?php if ($comprehensivewill_tb->state->Visible) { // state ?>
	<?php if ($comprehensivewill_tb->SortUrl($comprehensivewill_tb->state) == "") { ?>
		<td><div id="elh_comprehensivewill_tb_state" class="comprehensivewill_tb_state"><div class="ewTableHeaderCaption"><?php echo $comprehensivewill_tb->state->FldCaption() ?></div></div></td>
	<?php } else { ?>
		<td><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $comprehensivewill_tb->SortUrl($comprehensivewill_tb->state) ?>',2);"><div id="elh_comprehensivewill_tb_state" class="comprehensivewill_tb_state">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $comprehensivewill_tb->state->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($comprehensivewill_tb->state->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($comprehensivewill_tb->state->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></td>
	<?php } ?>
<?php } ?>		
<?php if ($comprehensivewill_tb->nationality->Visible) { // nationality ?>
	<?php if ($comprehensivewill_tb->SortUrl($comprehensivewill_tb->nationality) == "") { ?>
		<td><div id="elh_comprehensivewill_tb_nationality" class="comprehensivewill_tb_nationality"><div class="ewTableHeaderCaption"><?php echo $comprehensivewill_tb->nationality->FldCaption() ?></div></div></td>
	<?php } else { ?>
		<td><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $comprehensivewill_tb->SortUrl($comprehensivewill_tb->nationality) ?>',2);"><div id="elh_comprehensivewill_tb_nationality" class="comprehensivewill_tb_nationality">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $comprehensivewill_tb->nationality->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($comprehensivewill_tb->nationality->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($comprehensivewill_tb->nationality->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></td>
	<?php } ?>
<?php } ?>		
<?php if ($comprehensivewill_tb->lga->Visible) { // lga ?>
	<?php if ($comprehensivewill_tb->SortUrl($comprehensivewill_tb->lga) == "") { ?>
		<td><div id="elh_comprehensivewill_tb_lga" class="comprehensivewill_tb_lga"><div class="ewTableHeaderCaption"><?php echo $comprehensivewill_tb->lga->FldCaption() ?></div></div></td>
	<?php } else { ?>
		<td><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $comprehensivewill_tb->SortUrl($comprehensivewill_tb->lga) ?>',2);"><div id="elh_comprehensivewill_tb_lga" class="comprehensivewill_tb_lga">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $comprehensivewill_tb->lga->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($comprehensivewill_tb->lga->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($comprehensivewill_tb->lga->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></td>
	<?php } ?>
<?php } ?>		
<?php if ($comprehensivewill_tb->employmentstatus->Visible) { // employmentstatus ?>
	<?php if ($comprehensivewill_tb->SortUrl($comprehensivewill_tb->employmentstatus) == "") { ?>
		<td><div id="elh_comprehensivewill_tb_employmentstatus" class="comprehensivewill_tb_employmentstatus"><div class="ewTableHeaderCaption"><?php echo $comprehensivewill_tb->employmentstatus->FldCaption() ?></div></div></td>
	<?php } else { ?>
		<td><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $comprehensivewill_tb->SortUrl($comprehensivewill_tb->employmentstatus) ?>',2);"><div id="elh_comprehensivewill_tb_employmentstatus" class="comprehensivewill_tb_employmentstatus">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $comprehensivewill_tb->employmentstatus->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($comprehensivewill_tb->employmentstatus->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($comprehensivewill_tb->employmentstatus->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></td>
	<?php } ?>
<?php } ?>		
<?php if ($comprehensivewill_tb->employerphone->Visible) { // employerphone ?>
	<?php if ($comprehensivewill_tb->SortUrl($comprehensivewill_tb->employerphone) == "") { ?>
		<td><div id="elh_comprehensivewill_tb_employerphone" class="comprehensivewill_tb_employerphone"><div class="ewTableHeaderCaption"><?php echo $comprehensivewill_tb->employerphone->FldCaption() ?></div></div></td>
	<?php } else { ?>
		<td><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $comprehensivewill_tb->SortUrl($comprehensivewill_tb->employerphone) ?>',2);"><div id="elh_comprehensivewill_tb_employerphone" class="comprehensivewill_tb_employerphone">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $comprehensivewill_tb->employerphone->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($comprehensivewill_tb->employerphone->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($comprehensivewill_tb->employerphone->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></td>
	<?php } ?>
<?php } ?>		
<?php if ($comprehensivewill_tb->maritalstatus->Visible) { // maritalstatus ?>
	<?php if ($comprehensivewill_tb->SortUrl($comprehensivewill_tb->maritalstatus) == "") { ?>
		<td><div id="elh_comprehensivewill_tb_maritalstatus" class="comprehensivewill_tb_maritalstatus"><div class="ewTableHeaderCaption"><?php echo $comprehensivewill_tb->maritalstatus->FldCaption() ?></div></div></td>
	<?php } else { ?>
		<td><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $comprehensivewill_tb->SortUrl($comprehensivewill_tb->maritalstatus) ?>',2);"><div id="elh_comprehensivewill_tb_maritalstatus" class="comprehensivewill_tb_maritalstatus">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $comprehensivewill_tb->maritalstatus->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($comprehensivewill_tb->maritalstatus->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($comprehensivewill_tb->maritalstatus->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></td>
	<?php } ?>
<?php } ?>		
<?php if ($comprehensivewill_tb->spname->Visible) { // spname ?>
	<?php if ($comprehensivewill_tb->SortUrl($comprehensivewill_tb->spname) == "") { ?>
		<td><div id="elh_comprehensivewill_tb_spname" class="comprehensivewill_tb_spname"><div class="ewTableHeaderCaption"><?php echo $comprehensivewill_tb->spname->FldCaption() ?></div></div></td>
	<?php } else { ?>
		<td><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $comprehensivewill_tb->SortUrl($comprehensivewill_tb->spname) ?>',2);"><div id="elh_comprehensivewill_tb_spname" class="comprehensivewill_tb_spname">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $comprehensivewill_tb->spname->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($comprehensivewill_tb->spname->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($comprehensivewill_tb->spname->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></td>
	<?php } ?>
<?php } ?>		
<?php if ($comprehensivewill_tb->spemail->Visible) { // spemail ?>
	<?php if ($comprehensivewill_tb->SortUrl($comprehensivewill_tb->spemail) == "") { ?>
		<td><div id="elh_comprehensivewill_tb_spemail" class="comprehensivewill_tb_spemail"><div class="ewTableHeaderCaption"><?php echo $comprehensivewill_tb->spemail->FldCaption() ?></div></div></td>
	<?php } else { ?>
		<td><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $comprehensivewill_tb->SortUrl($comprehensivewill_tb->spemail) ?>',2);"><div id="elh_comprehensivewill_tb_spemail" class="comprehensivewill_tb_spemail">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $comprehensivewill_tb->spemail->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($comprehensivewill_tb->spemail->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($comprehensivewill_tb->spemail->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></td>
	<?php } ?>
<?php } ?>		
<?php if ($comprehensivewill_tb->spphone->Visible) { // spphone ?>
	<?php if ($comprehensivewill_tb->SortUrl($comprehensivewill_tb->spphone) == "") { ?>
		<td><div id="elh_comprehensivewill_tb_spphone" class="comprehensivewill_tb_spphone"><div class="ewTableHeaderCaption"><?php echo $comprehensivewill_tb->spphone->FldCaption() ?></div></div></td>
	<?php } else { ?>
		<td><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $comprehensivewill_tb->SortUrl($comprehensivewill_tb->spphone) ?>',2);"><div id="elh_comprehensivewill_tb_spphone" class="comprehensivewill_tb_spphone">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $comprehensivewill_tb->spphone->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($comprehensivewill_tb->spphone->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($comprehensivewill_tb->spphone->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></td>
	<?php } ?>
<?php } ?>		
<?php if ($comprehensivewill_tb->sdob->Visible) { // sdob ?>
	<?php if ($comprehensivewill_tb->SortUrl($comprehensivewill_tb->sdob) == "") { ?>
		<td><div id="elh_comprehensivewill_tb_sdob" class="comprehensivewill_tb_sdob"><div class="ewTableHeaderCaption"><?php echo $comprehensivewill_tb->sdob->FldCaption() ?></div></div></td>
	<?php } else { ?>
		<td><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $comprehensivewill_tb->SortUrl($comprehensivewill_tb->sdob) ?>',2);"><div id="elh_comprehensivewill_tb_sdob" class="comprehensivewill_tb_sdob">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $comprehensivewill_tb->sdob->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($comprehensivewill_tb->sdob->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($comprehensivewill_tb->sdob->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></td>
	<?php } ?>
<?php } ?>		
<?php if ($comprehensivewill_tb->spcity->Visible) { // spcity ?>
	<?php if ($comprehensivewill_tb->SortUrl($comprehensivewill_tb->spcity) == "") { ?>
		<td><div id="elh_comprehensivewill_tb_spcity" class="comprehensivewill_tb_spcity"><div class="ewTableHeaderCaption"><?php echo $comprehensivewill_tb->spcity->FldCaption() ?></div></div></td>
	<?php } else { ?>
		<td><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $comprehensivewill_tb->SortUrl($comprehensivewill_tb->spcity) ?>',2);"><div id="elh_comprehensivewill_tb_spcity" class="comprehensivewill_tb_spcity">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $comprehensivewill_tb->spcity->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($comprehensivewill_tb->spcity->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($comprehensivewill_tb->spcity->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></td>
	<?php } ?>
<?php } ?>		
<?php if ($comprehensivewill_tb->spstate->Visible) { // spstate ?>
	<?php if ($comprehensivewill_tb->SortUrl($comprehensivewill_tb->spstate) == "") { ?>
		<td><div id="elh_comprehensivewill_tb_spstate" class="comprehensivewill_tb_spstate"><div class="ewTableHeaderCaption"><?php echo $comprehensivewill_tb->spstate->FldCaption() ?></div></div></td>
	<?php } else { ?>
		<td><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $comprehensivewill_tb->SortUrl($comprehensivewill_tb->spstate) ?>',2);"><div id="elh_comprehensivewill_tb_spstate" class="comprehensivewill_tb_spstate">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $comprehensivewill_tb->spstate->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($comprehensivewill_tb->spstate->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($comprehensivewill_tb->spstate->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></td>
	<?php } ?>
<?php } ?>		
<?php if ($comprehensivewill_tb->marriagetype->Visible) { // marriagetype ?>
	<?php if ($comprehensivewill_tb->SortUrl($comprehensivewill_tb->marriagetype) == "") { ?>
		<td><div id="elh_comprehensivewill_tb_marriagetype" class="comprehensivewill_tb_marriagetype"><div class="ewTableHeaderCaption"><?php echo $comprehensivewill_tb->marriagetype->FldCaption() ?></div></div></td>
	<?php } else { ?>
		<td><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $comprehensivewill_tb->SortUrl($comprehensivewill_tb->marriagetype) ?>',2);"><div id="elh_comprehensivewill_tb_marriagetype" class="comprehensivewill_tb_marriagetype">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $comprehensivewill_tb->marriagetype->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($comprehensivewill_tb->marriagetype->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($comprehensivewill_tb->marriagetype->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></td>
	<?php } ?>
<?php } ?>		
<?php if ($comprehensivewill_tb->marriageyear->Visible) { // marriageyear ?>
	<?php if ($comprehensivewill_tb->SortUrl($comprehensivewill_tb->marriageyear) == "") { ?>
		<td><div id="elh_comprehensivewill_tb_marriageyear" class="comprehensivewill_tb_marriageyear"><div class="ewTableHeaderCaption"><?php echo $comprehensivewill_tb->marriageyear->FldCaption() ?></div></div></td>
	<?php } else { ?>
		<td><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $comprehensivewill_tb->SortUrl($comprehensivewill_tb->marriageyear) ?>',2);"><div id="elh_comprehensivewill_tb_marriageyear" class="comprehensivewill_tb_marriageyear">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $comprehensivewill_tb->marriageyear->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($comprehensivewill_tb->marriageyear->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($comprehensivewill_tb->marriageyear->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></td>
	<?php } ?>
<?php } ?>		
<?php if ($comprehensivewill_tb->marriagecert->Visible) { // marriagecert ?>
	<?php if ($comprehensivewill_tb->SortUrl($comprehensivewill_tb->marriagecert) == "") { ?>
		<td><div id="elh_comprehensivewill_tb_marriagecert" class="comprehensivewill_tb_marriagecert"><div class="ewTableHeaderCaption"><?php echo $comprehensivewill_tb->marriagecert->FldCaption() ?></div></div></td>
	<?php } else { ?>
		<td><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $comprehensivewill_tb->SortUrl($comprehensivewill_tb->marriagecert) ?>',2);"><div id="elh_comprehensivewill_tb_marriagecert" class="comprehensivewill_tb_marriagecert">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $comprehensivewill_tb->marriagecert->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($comprehensivewill_tb->marriagecert->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($comprehensivewill_tb->marriagecert->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></td>
	<?php } ?>
<?php } ?>		
<?php if ($comprehensivewill_tb->marriagecity->Visible) { // marriagecity ?>
	<?php if ($comprehensivewill_tb->SortUrl($comprehensivewill_tb->marriagecity) == "") { ?>
		<td><div id="elh_comprehensivewill_tb_marriagecity" class="comprehensivewill_tb_marriagecity"><div class="ewTableHeaderCaption"><?php echo $comprehensivewill_tb->marriagecity->FldCaption() ?></div></div></td>
	<?php } else { ?>
		<td><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $comprehensivewill_tb->SortUrl($comprehensivewill_tb->marriagecity) ?>',2);"><div id="elh_comprehensivewill_tb_marriagecity" class="comprehensivewill_tb_marriagecity">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $comprehensivewill_tb->marriagecity->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($comprehensivewill_tb->marriagecity->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($comprehensivewill_tb->marriagecity->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></td>
	<?php } ?>
<?php } ?>		
<?php if ($comprehensivewill_tb->marriagecountry->Visible) { // marriagecountry ?>
	<?php if ($comprehensivewill_tb->SortUrl($comprehensivewill_tb->marriagecountry) == "") { ?>
		<td><div id="elh_comprehensivewill_tb_marriagecountry" class="comprehensivewill_tb_marriagecountry"><div class="ewTableHeaderCaption"><?php echo $comprehensivewill_tb->marriagecountry->FldCaption() ?></div></div></td>
	<?php } else { ?>
		<td><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $comprehensivewill_tb->SortUrl($comprehensivewill_tb->marriagecountry) ?>',2);"><div id="elh_comprehensivewill_tb_marriagecountry" class="comprehensivewill_tb_marriagecountry">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $comprehensivewill_tb->marriagecountry->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($comprehensivewill_tb->marriagecountry->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($comprehensivewill_tb->marriagecountry->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></td>
	<?php } ?>
<?php } ?>		
<?php if ($comprehensivewill_tb->divorce->Visible) { // divorce ?>
	<?php if ($comprehensivewill_tb->SortUrl($comprehensivewill_tb->divorce) == "") { ?>
		<td><div id="elh_comprehensivewill_tb_divorce" class="comprehensivewill_tb_divorce"><div class="ewTableHeaderCaption"><?php echo $comprehensivewill_tb->divorce->FldCaption() ?></div></div></td>
	<?php } else { ?>
		<td><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $comprehensivewill_tb->SortUrl($comprehensivewill_tb->divorce) ?>',2);"><div id="elh_comprehensivewill_tb_divorce" class="comprehensivewill_tb_divorce">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $comprehensivewill_tb->divorce->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($comprehensivewill_tb->divorce->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($comprehensivewill_tb->divorce->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></td>
	<?php } ?>
<?php } ?>		
<?php if ($comprehensivewill_tb->divorceyear->Visible) { // divorceyear ?>
	<?php if ($comprehensivewill_tb->SortUrl($comprehensivewill_tb->divorceyear) == "") { ?>
		<td><div id="elh_comprehensivewill_tb_divorceyear" class="comprehensivewill_tb_divorceyear"><div class="ewTableHeaderCaption"><?php echo $comprehensivewill_tb->divorceyear->FldCaption() ?></div></div></td>
	<?php } else { ?>
		<td><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $comprehensivewill_tb->SortUrl($comprehensivewill_tb->divorceyear) ?>',2);"><div id="elh_comprehensivewill_tb_divorceyear" class="comprehensivewill_tb_divorceyear">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $comprehensivewill_tb->divorceyear->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($comprehensivewill_tb->divorceyear->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($comprehensivewill_tb->divorceyear->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></td>
	<?php } ?>
<?php } ?>		
<?php if ($comprehensivewill_tb->addinfo->Visible) { // addinfo ?>
	<?php if ($comprehensivewill_tb->SortUrl($comprehensivewill_tb->addinfo) == "") { ?>
		<td><div id="elh_comprehensivewill_tb_addinfo" class="comprehensivewill_tb_addinfo"><div class="ewTableHeaderCaption"><?php echo $comprehensivewill_tb->addinfo->FldCaption() ?></div></div></td>
	<?php } else { ?>
		<td><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $comprehensivewill_tb->SortUrl($comprehensivewill_tb->addinfo) ?>',2);"><div id="elh_comprehensivewill_tb_addinfo" class="comprehensivewill_tb_addinfo">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $comprehensivewill_tb->addinfo->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($comprehensivewill_tb->addinfo->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($comprehensivewill_tb->addinfo->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></td>
	<?php } ?>
<?php } ?>		
<?php if ($comprehensivewill_tb->datecreated->Visible) { // datecreated ?>
	<?php if ($comprehensivewill_tb->SortUrl($comprehensivewill_tb->datecreated) == "") { ?>
		<td><div id="elh_comprehensivewill_tb_datecreated" class="comprehensivewill_tb_datecreated"><div class="ewTableHeaderCaption"><?php echo $comprehensivewill_tb->datecreated->FldCaption() ?></div></div></td>
	<?php } else { ?>
		<td><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $comprehensivewill_tb->SortUrl($comprehensivewill_tb->datecreated) ?>',2);"><div id="elh_comprehensivewill_tb_datecreated" class="comprehensivewill_tb_datecreated">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $comprehensivewill_tb->datecreated->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($comprehensivewill_tb->datecreated->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($comprehensivewill_tb->datecreated->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></td>
	<?php } ?>
<?php } ?>		
<?php

// Render list options (header, right)
$comprehensivewill_tb_list->ListOptions->Render("header", "right");
?>
	</tr>
</thead>
<tbody>
<?php
if ($comprehensivewill_tb->ExportAll && $comprehensivewill_tb->Export <> "") {
	$comprehensivewill_tb_list->StopRec = $comprehensivewill_tb_list->TotalRecs;
} else {

	// Set the last record to display
	if ($comprehensivewill_tb_list->TotalRecs > $comprehensivewill_tb_list->StartRec + $comprehensivewill_tb_list->DisplayRecs - 1)
		$comprehensivewill_tb_list->StopRec = $comprehensivewill_tb_list->StartRec + $comprehensivewill_tb_list->DisplayRecs - 1;
	else
		$comprehensivewill_tb_list->StopRec = $comprehensivewill_tb_list->TotalRecs;
}
$comprehensivewill_tb_list->RecCnt = $comprehensivewill_tb_list->StartRec - 1;
if ($comprehensivewill_tb_list->Recordset && !$comprehensivewill_tb_list->Recordset->EOF) {
	$comprehensivewill_tb_list->Recordset->MoveFirst();
	if (!$bSelectLimit && $comprehensivewill_tb_list->StartRec > 1)
		$comprehensivewill_tb_list->Recordset->Move($comprehensivewill_tb_list->StartRec - 1);
} elseif (!$comprehensivewill_tb->AllowAddDeleteRow && $comprehensivewill_tb_list->StopRec == 0) {
	$comprehensivewill_tb_list->StopRec = $comprehensivewill_tb->GridAddRowCount;
}

// Initialize aggregate
$comprehensivewill_tb->RowType = EW_ROWTYPE_AGGREGATEINIT;
$comprehensivewill_tb->ResetAttrs();
$comprehensivewill_tb_list->RenderRow();
while ($comprehensivewill_tb_list->RecCnt < $comprehensivewill_tb_list->StopRec) {
	$comprehensivewill_tb_list->RecCnt++;
	if (intval($comprehensivewill_tb_list->RecCnt) >= intval($comprehensivewill_tb_list->StartRec)) {
		$comprehensivewill_tb_list->RowCnt++;

		// Set up key count
		$comprehensivewill_tb_list->KeyCount = $comprehensivewill_tb_list->RowIndex;

		// Init row class and style
		$comprehensivewill_tb->ResetAttrs();
		$comprehensivewill_tb->CssClass = "";
		if ($comprehensivewill_tb->CurrentAction == "gridadd") {
		} else {
			$comprehensivewill_tb_list->LoadRowValues($comprehensivewill_tb_list->Recordset); // Load row values
		}
		$comprehensivewill_tb->RowType = EW_ROWTYPE_VIEW; // Render view

		// Set up row id / data-rowindex
		$comprehensivewill_tb->RowAttrs = array_merge($comprehensivewill_tb->RowAttrs, array('data-rowindex'=>$comprehensivewill_tb_list->RowCnt, 'id'=>'r' . $comprehensivewill_tb_list->RowCnt . '_comprehensivewill_tb', 'data-rowtype'=>$comprehensivewill_tb->RowType));

		// Render row
		$comprehensivewill_tb_list->RenderRow();

		// Render list options
		$comprehensivewill_tb_list->RenderListOptions();
?>
	<tr<?php echo $comprehensivewill_tb->RowAttributes() ?>>
<?php

// Render list options (body, left)
$comprehensivewill_tb_list->ListOptions->Render("body", "left", $comprehensivewill_tb_list->RowCnt);
?>
	<?php if ($comprehensivewill_tb->willtype->Visible) { // willtype ?>
		<td<?php echo $comprehensivewill_tb->willtype->CellAttributes() ?>>
<span<?php echo $comprehensivewill_tb->willtype->ViewAttributes() ?>>
<?php echo $comprehensivewill_tb->willtype->ListViewValue() ?></span>
<a id="<?php echo $comprehensivewill_tb_list->PageObjName . "_row_" . $comprehensivewill_tb_list->RowCnt ?>"></a></td>
	<?php } ?>
	<?php if ($comprehensivewill_tb->fullname->Visible) { // fullname ?>
		<td<?php echo $comprehensivewill_tb->fullname->CellAttributes() ?>>
<span<?php echo $comprehensivewill_tb->fullname->ViewAttributes() ?>>
<?php if (!ew_EmptyStr($comprehensivewill_tb->fullname->ListViewValue()) && $comprehensivewill_tb->fullname->LinkAttributes() <> "") { ?>
<a<?php echo $comprehensivewill_tb->fullname->LinkAttributes() ?>><?php echo $comprehensivewill_tb->fullname->ListViewValue() ?></a>
<?php } else { ?>
<?php echo $comprehensivewill_tb->fullname->ListViewValue() ?>
<?php } ?>
</span>
<a id="<?php echo $comprehensivewill_tb_list->PageObjName . "_row_" . $comprehensivewill_tb_list->RowCnt ?>"></a></td>
	<?php } ?>
	<?php if ($comprehensivewill_tb->_email->Visible) { // email ?>
		<td<?php echo $comprehensivewill_tb->_email->CellAttributes() ?>>
<span<?php echo $comprehensivewill_tb->_email->ViewAttributes() ?>>
<?php echo $comprehensivewill_tb->_email->ListViewValue() ?></span>
<a id="<?php echo $comprehensivewill_tb_list->PageObjName . "_row_" . $comprehensivewill_tb_list->RowCnt ?>"></a></td>
	<?php } ?>
	<?php if ($comprehensivewill_tb->phoneno->Visible) { // phoneno ?>
		<td<?php echo $comprehensivewill_tb->phoneno->CellAttributes() ?>>
<span<?php echo $comprehensivewill_tb->phoneno->ViewAttributes() ?>>
<?php echo $comprehensivewill_tb->phoneno->ListViewValue() ?></span>
<a id="<?php echo $comprehensivewill_tb_list->PageObjName . "_row_" . $comprehensivewill_tb_list->RowCnt ?>"></a></td>
	<?php } ?>
	<?php if ($comprehensivewill_tb->aphoneno->Visible) { // aphoneno ?>
		<td<?php echo $comprehensivewill_tb->aphoneno->CellAttributes() ?>>
<span<?php echo $comprehensivewill_tb->aphoneno->ViewAttributes() ?>>
<?php echo $comprehensivewill_tb->aphoneno->ListViewValue() ?></span>
<a id="<?php echo $comprehensivewill_tb_list->PageObjName . "_row_" . $comprehensivewill_tb_list->RowCnt ?>"></a></td>
	<?php } ?>
	<?php if ($comprehensivewill_tb->gender->Visible) { // gender ?>
		<td<?php echo $comprehensivewill_tb->gender->CellAttributes() ?>>
<span<?php echo $comprehensivewill_tb->gender->ViewAttributes() ?>>
<?php echo $comprehensivewill_tb->gender->ListViewValue() ?></span>
<a id="<?php echo $comprehensivewill_tb_list->PageObjName . "_row_" . $comprehensivewill_tb_list->RowCnt ?>"></a></td>
	<?php } ?>
	<?php if ($comprehensivewill_tb->dob->Visible) { // dob ?>
		<td<?php echo $comprehensivewill_tb->dob->CellAttributes() ?>>
<span<?php echo $comprehensivewill_tb->dob->ViewAttributes() ?>>
<?php echo $comprehensivewill_tb->dob->ListViewValue() ?></span>
<a id="<?php echo $comprehensivewill_tb_list->PageObjName . "_row_" . $comprehensivewill_tb_list->RowCnt ?>"></a></td>
	<?php } ?>
	<?php if ($comprehensivewill_tb->state->Visible) { // state ?>
		<td<?php echo $comprehensivewill_tb->state->CellAttributes() ?>>
<span<?php echo $comprehensivewill_tb->state->ViewAttributes() ?>>
<?php echo $comprehensivewill_tb->state->ListViewValue() ?></span>
<a id="<?php echo $comprehensivewill_tb_list->PageObjName . "_row_" . $comprehensivewill_tb_list->RowCnt ?>"></a></td>
	<?php } ?>
	<?php if ($comprehensivewill_tb->nationality->Visible) { // nationality ?>
		<td<?php echo $comprehensivewill_tb->nationality->CellAttributes() ?>>
<span<?php echo $comprehensivewill_tb->nationality->ViewAttributes() ?>>
<?php echo $comprehensivewill_tb->nationality->ListViewValue() ?></span>
<a id="<?php echo $comprehensivewill_tb_list->PageObjName . "_row_" . $comprehensivewill_tb_list->RowCnt ?>"></a></td>
	<?php } ?>
	<?php if ($comprehensivewill_tb->lga->Visible) { // lga ?>
		<td<?php echo $comprehensivewill_tb->lga->CellAttributes() ?>>
<span<?php echo $comprehensivewill_tb->lga->ViewAttributes() ?>>
<?php echo $comprehensivewill_tb->lga->ListViewValue() ?></span>
<a id="<?php echo $comprehensivewill_tb_list->PageObjName . "_row_" . $comprehensivewill_tb_list->RowCnt ?>"></a></td>
	<?php } ?>
	<?php if ($comprehensivewill_tb->employmentstatus->Visible) { // employmentstatus ?>
		<td<?php echo $comprehensivewill_tb->employmentstatus->CellAttributes() ?>>
<span<?php echo $comprehensivewill_tb->employmentstatus->ViewAttributes() ?>>
<?php echo $comprehensivewill_tb->employmentstatus->ListViewValue() ?></span>
<a id="<?php echo $comprehensivewill_tb_list->PageObjName . "_row_" . $comprehensivewill_tb_list->RowCnt ?>"></a></td>
	<?php } ?>
	<?php if ($comprehensivewill_tb->employerphone->Visible) { // employerphone ?>
		<td<?php echo $comprehensivewill_tb->employerphone->CellAttributes() ?>>
<span<?php echo $comprehensivewill_tb->employerphone->ViewAttributes() ?>>
<?php echo $comprehensivewill_tb->employerphone->ListViewValue() ?></span>
<a id="<?php echo $comprehensivewill_tb_list->PageObjName . "_row_" . $comprehensivewill_tb_list->RowCnt ?>"></a></td>
	<?php } ?>
	<?php if ($comprehensivewill_tb->maritalstatus->Visible) { // maritalstatus ?>
		<td<?php echo $comprehensivewill_tb->maritalstatus->CellAttributes() ?>>
<span<?php echo $comprehensivewill_tb->maritalstatus->ViewAttributes() ?>>
<?php echo $comprehensivewill_tb->maritalstatus->ListViewValue() ?></span>
<a id="<?php echo $comprehensivewill_tb_list->PageObjName . "_row_" . $comprehensivewill_tb_list->RowCnt ?>"></a></td>
	<?php } ?>
	<?php if ($comprehensivewill_tb->spname->Visible) { // spname ?>
		<td<?php echo $comprehensivewill_tb->spname->CellAttributes() ?>>
<span<?php echo $comprehensivewill_tb->spname->ViewAttributes() ?>>
<?php echo $comprehensivewill_tb->spname->ListViewValue() ?></span>
<a id="<?php echo $comprehensivewill_tb_list->PageObjName . "_row_" . $comprehensivewill_tb_list->RowCnt ?>"></a></td>
	<?php } ?>
	<?php if ($comprehensivewill_tb->spemail->Visible) { // spemail ?>
		<td<?php echo $comprehensivewill_tb->spemail->CellAttributes() ?>>
<span<?php echo $comprehensivewill_tb->spemail->ViewAttributes() ?>>
<?php echo $comprehensivewill_tb->spemail->ListViewValue() ?></span>
<a id="<?php echo $comprehensivewill_tb_list->PageObjName . "_row_" . $comprehensivewill_tb_list->RowCnt ?>"></a></td>
	<?php } ?>
	<?php if ($comprehensivewill_tb->spphone->Visible) { // spphone ?>
		<td<?php echo $comprehensivewill_tb->spphone->CellAttributes() ?>>
<span<?php echo $comprehensivewill_tb->spphone->ViewAttributes() ?>>
<?php echo $comprehensivewill_tb->spphone->ListViewValue() ?></span>
<a id="<?php echo $comprehensivewill_tb_list->PageObjName . "_row_" . $comprehensivewill_tb_list->RowCnt ?>"></a></td>
	<?php } ?>
	<?php if ($comprehensivewill_tb->sdob->Visible) { // sdob ?>
		<td<?php echo $comprehensivewill_tb->sdob->CellAttributes() ?>>
<span<?php echo $comprehensivewill_tb->sdob->ViewAttributes() ?>>
<?php echo $comprehensivewill_tb->sdob->ListViewValue() ?></span>
<a id="<?php echo $comprehensivewill_tb_list->PageObjName . "_row_" . $comprehensivewill_tb_list->RowCnt ?>"></a></td>
	<?php } ?>
	<?php if ($comprehensivewill_tb->spcity->Visible) { // spcity ?>
		<td<?php echo $comprehensivewill_tb->spcity->CellAttributes() ?>>
<span<?php echo $comprehensivewill_tb->spcity->ViewAttributes() ?>>
<?php echo $comprehensivewill_tb->spcity->ListViewValue() ?></span>
<a id="<?php echo $comprehensivewill_tb_list->PageObjName . "_row_" . $comprehensivewill_tb_list->RowCnt ?>"></a></td>
	<?php } ?>
	<?php if ($comprehensivewill_tb->spstate->Visible) { // spstate ?>
		<td<?php echo $comprehensivewill_tb->spstate->CellAttributes() ?>>
<span<?php echo $comprehensivewill_tb->spstate->ViewAttributes() ?>>
<?php echo $comprehensivewill_tb->spstate->ListViewValue() ?></span>
<a id="<?php echo $comprehensivewill_tb_list->PageObjName . "_row_" . $comprehensivewill_tb_list->RowCnt ?>"></a></td>
	<?php } ?>
	<?php if ($comprehensivewill_tb->marriagetype->Visible) { // marriagetype ?>
		<td<?php echo $comprehensivewill_tb->marriagetype->CellAttributes() ?>>
<span<?php echo $comprehensivewill_tb->marriagetype->ViewAttributes() ?>>
<?php echo $comprehensivewill_tb->marriagetype->ListViewValue() ?></span>
<a id="<?php echo $comprehensivewill_tb_list->PageObjName . "_row_" . $comprehensivewill_tb_list->RowCnt ?>"></a></td>
	<?php } ?>
	<?php if ($comprehensivewill_tb->marriageyear->Visible) { // marriageyear ?>
		<td<?php echo $comprehensivewill_tb->marriageyear->CellAttributes() ?>>
<span<?php echo $comprehensivewill_tb->marriageyear->ViewAttributes() ?>>
<?php echo $comprehensivewill_tb->marriageyear->ListViewValue() ?></span>
<a id="<?php echo $comprehensivewill_tb_list->PageObjName . "_row_" . $comprehensivewill_tb_list->RowCnt ?>"></a></td>
	<?php } ?>
	<?php if ($comprehensivewill_tb->marriagecert->Visible) { // marriagecert ?>
		<td<?php echo $comprehensivewill_tb->marriagecert->CellAttributes() ?>>
<span<?php echo $comprehensivewill_tb->marriagecert->ViewAttributes() ?>>
<?php echo $comprehensivewill_tb->marriagecert->ListViewValue() ?></span>
<a id="<?php echo $comprehensivewill_tb_list->PageObjName . "_row_" . $comprehensivewill_tb_list->RowCnt ?>"></a></td>
	<?php } ?>
	<?php if ($comprehensivewill_tb->marriagecity->Visible) { // marriagecity ?>
		<td<?php echo $comprehensivewill_tb->marriagecity->CellAttributes() ?>>
<span<?php echo $comprehensivewill_tb->marriagecity->ViewAttributes() ?>>
<?php echo $comprehensivewill_tb->marriagecity->ListViewValue() ?></span>
<a id="<?php echo $comprehensivewill_tb_list->PageObjName . "_row_" . $comprehensivewill_tb_list->RowCnt ?>"></a></td>
	<?php } ?>
	<?php if ($comprehensivewill_tb->marriagecountry->Visible) { // marriagecountry ?>
		<td<?php echo $comprehensivewill_tb->marriagecountry->CellAttributes() ?>>
<span<?php echo $comprehensivewill_tb->marriagecountry->ViewAttributes() ?>>
<?php echo $comprehensivewill_tb->marriagecountry->ListViewValue() ?></span>
<a id="<?php echo $comprehensivewill_tb_list->PageObjName . "_row_" . $comprehensivewill_tb_list->RowCnt ?>"></a></td>
	<?php } ?>
	<?php if ($comprehensivewill_tb->divorce->Visible) { // divorce ?>
		<td<?php echo $comprehensivewill_tb->divorce->CellAttributes() ?>>
<span<?php echo $comprehensivewill_tb->divorce->ViewAttributes() ?>>
<?php echo $comprehensivewill_tb->divorce->ListViewValue() ?></span>
<a id="<?php echo $comprehensivewill_tb_list->PageObjName . "_row_" . $comprehensivewill_tb_list->RowCnt ?>"></a></td>
	<?php } ?>
	<?php if ($comprehensivewill_tb->divorceyear->Visible) { // divorceyear ?>
		<td<?php echo $comprehensivewill_tb->divorceyear->CellAttributes() ?>>
<span<?php echo $comprehensivewill_tb->divorceyear->ViewAttributes() ?>>
<?php echo $comprehensivewill_tb->divorceyear->ListViewValue() ?></span>
<a id="<?php echo $comprehensivewill_tb_list->PageObjName . "_row_" . $comprehensivewill_tb_list->RowCnt ?>"></a></td>
	<?php } ?>
	<?php if ($comprehensivewill_tb->addinfo->Visible) { // addinfo ?>
		<td<?php echo $comprehensivewill_tb->addinfo->CellAttributes() ?>>
<span<?php echo $comprehensivewill_tb->addinfo->ViewAttributes() ?>>
<?php echo $comprehensivewill_tb->addinfo->ListViewValue() ?></span>
<a id="<?php echo $comprehensivewill_tb_list->PageObjName . "_row_" . $comprehensivewill_tb_list->RowCnt ?>"></a></td>
	<?php } ?>
	<?php if ($comprehensivewill_tb->datecreated->Visible) { // datecreated ?>
		<td<?php echo $comprehensivewill_tb->datecreated->CellAttributes() ?>>
<span<?php echo $comprehensivewill_tb->datecreated->ViewAttributes() ?>>
<?php echo $comprehensivewill_tb->datecreated->ListViewValue() ?></span>
<a id="<?php echo $comprehensivewill_tb_list->PageObjName . "_row_" . $comprehensivewill_tb_list->RowCnt ?>"></a></td>
	<?php } ?>
<?php

// Render list options (body, right)
$comprehensivewill_tb_list->ListOptions->Render("body", "right", $comprehensivewill_tb_list->RowCnt);
?>
	</tr>
<?php
	}
	if ($comprehensivewill_tb->CurrentAction <> "gridadd")
		$comprehensivewill_tb_list->Recordset->MoveNext();
}
?>
</tbody>
</table>
<?php } ?>
<?php if ($comprehensivewill_tb->CurrentAction == "") { ?>
<input type="hidden" name="a_list" id="a_list" value="">
<?php } ?>
</div>
</form>
<?php

// Close recordset
if ($comprehensivewill_tb_list->Recordset)
	$comprehensivewill_tb_list->Recordset->Close();
?>
<?php if ($comprehensivewill_tb->Export == "") { ?>
<div class="ewGridLowerPanel">
<?php if ($comprehensivewill_tb->CurrentAction <> "gridadd" && $comprehensivewill_tb->CurrentAction <> "gridedit") { ?>
<form name="ewPagerForm" class="ewForm form-horizontal" action="<?php echo ew_CurrentPage() ?>">
<table class="ewPager">
<tr><td>
<?php if (!isset($comprehensivewill_tb_list->Pager)) $comprehensivewill_tb_list->Pager = new cNumericPager($comprehensivewill_tb_list->StartRec, $comprehensivewill_tb_list->DisplayRecs, $comprehensivewill_tb_list->TotalRecs, $comprehensivewill_tb_list->RecRange) ?>
<?php if ($comprehensivewill_tb_list->Pager->RecordCount > 0) { ?>
<table cellspacing="0" class="ewStdTable"><tbody><tr><td>
<div class="pagination"><ul>
	<?php if ($comprehensivewill_tb_list->Pager->FirstButton->Enabled) { ?>
	<li><a href="<?php echo $comprehensivewill_tb_list->PageUrl() ?>start=<?php echo $comprehensivewill_tb_list->Pager->FirstButton->Start ?>"><?php echo $Language->Phrase("PagerFirst") ?></a></li>
	<?php } ?>
	<?php if ($comprehensivewill_tb_list->Pager->PrevButton->Enabled) { ?>
	<li><a href="<?php echo $comprehensivewill_tb_list->PageUrl() ?>start=<?php echo $comprehensivewill_tb_list->Pager->PrevButton->Start ?>"><?php echo $Language->Phrase("PagerPrevious") ?></a></li>
	<?php } ?>
	<?php foreach ($comprehensivewill_tb_list->Pager->Items as $PagerItem) { ?>
		<li<?php if (!$PagerItem->Enabled) { echo " class=\" active\""; } ?>><a href="<?php if ($PagerItem->Enabled) { echo $comprehensivewill_tb_list->PageUrl() . "start=" . $PagerItem->Start; } else { echo "#"; } ?>"><?php echo $PagerItem->Text ?></a></li>
	<?php } ?>
	<?php if ($comprehensivewill_tb_list->Pager->NextButton->Enabled) { ?>
	<li><a href="<?php echo $comprehensivewill_tb_list->PageUrl() ?>start=<?php echo $comprehensivewill_tb_list->Pager->NextButton->Start ?>"><?php echo $Language->Phrase("PagerNext") ?></a></li>
	<?php } ?>
	<?php if ($comprehensivewill_tb_list->Pager->LastButton->Enabled) { ?>
	<li><a href="<?php echo $comprehensivewill_tb_list->PageUrl() ?>start=<?php echo $comprehensivewill_tb_list->Pager->LastButton->Start ?>"><?php echo $Language->Phrase("PagerLast") ?></a></li>
	<?php } ?>
</ul></div>
</td>
<td>
	<?php if ($comprehensivewill_tb_list->Pager->ButtonCount > 0) { ?>&nbsp;&nbsp;&nbsp;&nbsp;<?php } ?>
	<?php echo $Language->Phrase("Record") ?>&nbsp;<?php echo $comprehensivewill_tb_list->Pager->FromIndex ?>&nbsp;<?php echo $Language->Phrase("To") ?>&nbsp;<?php echo $comprehensivewill_tb_list->Pager->ToIndex ?>&nbsp;<?php echo $Language->Phrase("Of") ?>&nbsp;<?php echo $comprehensivewill_tb_list->Pager->RecordCount ?>
</td>
</tr></tbody></table>
<?php } else { ?>
	<?php if ($comprehensivewill_tb_list->SearchWhere == "0=101") { ?>
	<p><?php echo $Language->Phrase("EnterSearchCriteria") ?></p>
	<?php } else { ?>
	<p><?php echo $Language->Phrase("NoRecord") ?></p>
	<?php } ?>
<?php } ?>
</td>
<?php if ($comprehensivewill_tb_list->TotalRecs > 0) { ?>
<td>
	&nbsp;&nbsp;&nbsp;&nbsp;
<input type="hidden" name="t" value="comprehensivewill_tb">
<select name="<?php echo EW_TABLE_REC_PER_PAGE ?>" class="input-small" onchange="this.form.submit();">
<option value="25"<?php if ($comprehensivewill_tb_list->DisplayRecs == 25) { ?> selected="selected"<?php } ?>>25</option>
<option value="50"<?php if ($comprehensivewill_tb_list->DisplayRecs == 50) { ?> selected="selected"<?php } ?>>50</option>
<option value="100"<?php if ($comprehensivewill_tb_list->DisplayRecs == 100) { ?> selected="selected"<?php } ?>>100</option>
<option value="200"<?php if ($comprehensivewill_tb_list->DisplayRecs == 200) { ?> selected="selected"<?php } ?>>200</option>
<option value="500"<?php if ($comprehensivewill_tb_list->DisplayRecs == 500) { ?> selected="selected"<?php } ?>>500</option>
<option value="ALL"<?php if ($comprehensivewill_tb->getRecordsPerPage() == -1) { ?> selected="selected"<?php } ?>><?php echo $Language->Phrase("AllRecords") ?></option>
</select>
</td>
<?php } ?>
</tr></table>
</form>
<?php } ?>
<div class="ewListOtherOptions">
<?php
	foreach ($comprehensivewill_tb_list->OtherOptions as &$option)
		$option->Render("body", "bottom");
?>
</div>
</div>
<?php } ?>
</td></tr></table>
<?php if ($comprehensivewill_tb->Export == "") { ?>
<script type="text/javascript">
fcomprehensivewill_tblistsrch.Init();
fcomprehensivewill_tblist.Init();
<?php if (EW_MOBILE_REFLOW && ew_IsMobile()) { ?>
ew_Reflow();
<?php } ?>
</script>
<?php } ?>
<?php
$comprehensivewill_tb_list->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<?php if ($comprehensivewill_tb->Export == "") { ?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php } ?>
<?php include_once "footer.php" ?>
<?php
$comprehensivewill_tb_list->Page_Terminate();
?>
