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

$layout_list = NULL; // Initialize page object first

class clayout_list extends clayout {

	// Page ID
	var $PageID = 'list';

	// Project ID
	var $ProjectID = "{D9B361E7-B2C1-4293-B9B3-B581986A15CC}";

	// Table name
	var $TableName = 'layout';

	// Page object name
	var $PageObjName = 'layout_list';

	// Grid form hidden field names
	var $FormName = 'flayoutlist';
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

		// Table object (layout)
		if (!isset($GLOBALS["layout"])) {
			$GLOBALS["layout"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["layout"];
		}

		// Initialize URLs
		$this->ExportPrintUrl = $this->PageUrl() . "export=print";
		$this->ExportExcelUrl = $this->PageUrl() . "export=excel";
		$this->ExportWordUrl = $this->PageUrl() . "export=word";
		$this->ExportHtmlUrl = $this->PageUrl() . "export=html";
		$this->ExportXmlUrl = $this->PageUrl() . "export=xml";
		$this->ExportCsvUrl = $this->PageUrl() . "export=csv";
		$this->ExportPdfUrl = $this->PageUrl() . "export=pdf";
		$this->AddUrl = "layoutadd.php";
		$this->InlineAddUrl = $this->PageUrl() . "a=add";
		$this->GridAddUrl = $this->PageUrl() . "a=gridadd";
		$this->GridEditUrl = $this->PageUrl() . "a=gridedit";
		$this->MultiDeleteUrl = "layoutdelete.php";
		$this->MultiUpdateUrl = "layoutupdate.php";

		// Table object (adminusers)
		if (!isset($GLOBALS['adminusers'])) $GLOBALS['adminusers'] = new cadminusers();

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'list', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'layout', TRUE);

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
		$this->BuildBasicSearchSQL($sWhere, $this->top2Dl, $Keyword);
		$this->BuildBasicSearchSQL($sWhere, $this->top2Dr, $Keyword);
		$this->BuildBasicSearchSQL($sWhere, $this->head2Dl, $Keyword);
		$this->BuildBasicSearchSQL($sWhere, $this->head2Dr, $Keyword);
		$this->BuildBasicSearchSQL($sWhere, $this->slide1, $Keyword);
		$this->BuildBasicSearchSQL($sWhere, $this->slide2, $Keyword);
		$this->BuildBasicSearchSQL($sWhere, $this->slide3, $Keyword);
		$this->BuildBasicSearchSQL($sWhere, $this->slide4, $Keyword);
		$this->BuildBasicSearchSQL($sWhere, $this->slide5, $Keyword);
		$this->BuildBasicSearchSQL($sWhere, $this->slide6, $Keyword);
		$this->BuildBasicSearchSQL($sWhere, $this->home2Dcaption1, $Keyword);
		$this->BuildBasicSearchSQL($sWhere, $this->home2Dtext1, $Keyword);
		$this->BuildBasicSearchSQL($sWhere, $this->home2Dcaption2, $Keyword);
		$this->BuildBasicSearchSQL($sWhere, $this->home2Dtext2, $Keyword);
		$this->BuildBasicSearchSQL($sWhere, $this->home2Dcaption3, $Keyword);
		$this->BuildBasicSearchSQL($sWhere, $this->home2Dtext3, $Keyword);
		$this->BuildBasicSearchSQL($sWhere, $this->home2Dcaption4, $Keyword);
		$this->BuildBasicSearchSQL($sWhere, $this->home2Dtext4, $Keyword);
		$this->BuildBasicSearchSQL($sWhere, $this->home2Dcaption5, $Keyword);
		$this->BuildBasicSearchSQL($sWhere, $this->home2Dtext5, $Keyword);
		$this->BuildBasicSearchSQL($sWhere, $this->home2Dcaption6, $Keyword);
		$this->BuildBasicSearchSQL($sWhere, $this->footer2D1, $Keyword);
		$this->BuildBasicSearchSQL($sWhere, $this->footer2D2, $Keyword);
		$this->BuildBasicSearchSQL($sWhere, $this->footer2D3, $Keyword);
		$this->BuildBasicSearchSQL($sWhere, $this->footer2D4, $Keyword);
		$this->BuildBasicSearchSQL($sWhere, $this->contact2Demail, $Keyword);
		$this->BuildBasicSearchSQL($sWhere, $this->contact2Dtext1, $Keyword);
		$this->BuildBasicSearchSQL($sWhere, $this->contact2Dtext2, $Keyword);
		$this->BuildBasicSearchSQL($sWhere, $this->contact2Dtext3, $Keyword);
		$this->BuildBasicSearchSQL($sWhere, $this->contact2Dtext4, $Keyword);
		$this->BuildBasicSearchSQL($sWhere, $this->google2Dmap, $Keyword);
		$this->BuildBasicSearchSQL($sWhere, $this->fb2Dlikebox, $Keyword);
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
			$this->UpdateSort($this->top2Dl, $bCtrl); // top-l
			$this->UpdateSort($this->top2Dr, $bCtrl); // top-r
			$this->UpdateSort($this->head2Dl, $bCtrl); // head-l
			$this->UpdateSort($this->head2Dr, $bCtrl); // head-r
			$this->UpdateSort($this->slide1, $bCtrl); // slide1
			$this->UpdateSort($this->slide2, $bCtrl); // slide2
			$this->UpdateSort($this->slide3, $bCtrl); // slide3
			$this->UpdateSort($this->slide4, $bCtrl); // slide4
			$this->UpdateSort($this->slide5, $bCtrl); // slide5
			$this->UpdateSort($this->slide6, $bCtrl); // slide6
			$this->UpdateSort($this->home2Dcaption1, $bCtrl); // home-caption1
			$this->UpdateSort($this->home2Dcaption2, $bCtrl); // home-caption2
			$this->UpdateSort($this->home2Dcaption3, $bCtrl); // home-caption3
			$this->UpdateSort($this->home2Dcaption4, $bCtrl); // home-caption4
			$this->UpdateSort($this->home2Dcaption5, $bCtrl); // home-caption5
			$this->UpdateSort($this->home2Dcaption6, $bCtrl); // home-caption6
			$this->UpdateSort($this->home2Dtext6, $bCtrl); // home-text6
			$this->UpdateSort($this->footer2D1, $bCtrl); // footer-1
			$this->UpdateSort($this->footer2D2, $bCtrl); // footer-2
			$this->UpdateSort($this->footer2D3, $bCtrl); // footer-3
			$this->UpdateSort($this->footer2D4, $bCtrl); // footer-4
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
				$this->top2Dl->setSort("");
				$this->top2Dr->setSort("");
				$this->head2Dl->setSort("");
				$this->head2Dr->setSort("");
				$this->slide1->setSort("");
				$this->slide2->setSort("");
				$this->slide3->setSort("");
				$this->slide4->setSort("");
				$this->slide5->setSort("");
				$this->slide6->setSort("");
				$this->home2Dcaption1->setSort("");
				$this->home2Dcaption2->setSort("");
				$this->home2Dcaption3->setSort("");
				$this->home2Dcaption4->setSort("");
				$this->home2Dcaption5->setSort("");
				$this->home2Dcaption6->setSort("");
				$this->home2Dtext6->setSort("");
				$this->footer2D1->setSort("");
				$this->footer2D2->setSort("");
				$this->footer2D3->setSort("");
				$this->footer2D4->setSort("");
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
		$option = $options["action"];

		// Add multi delete
		$item = &$option->Add("multidelete");
		$item->Body = "<a class=\"ewAction ewMultiDelete\" href=\"\" onclick=\"ew_SubmitSelected(document.flayoutlist, '" . $this->MultiDeleteUrl . "', ewLanguage.Phrase('DeleteMultiConfirmMsg'));return false;\">" . $Language->Phrase("DeleteSelectedLink") . "</a>";
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
				$item->Body = "<a class=\"ewAction ewCustomAction\" href=\"\" onclick=\"ew_SubmitSelected(document.flayoutlist, '" . ew_CurrentUrl() . "', null, '" . $action . "');return false;\">" . $name . "</a>";
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
		// logo

		$this->logo->CellCssStyle = "white-space: nowrap;";

		// url
		$this->url->CellCssStyle = "white-space: nowrap;";

		// meta-title
		$this->meta2Dtitle->CellCssStyle = "white-space: nowrap;";

		// meta-keywords
		$this->meta2Dkeywords->CellCssStyle = "white-space: nowrap;";

		// meta-descp
		$this->meta2Ddescp->CellCssStyle = "white-space: nowrap;";

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

		$this->nav2Dtext->CellCssStyle = "white-space: nowrap;";

		// slide-box
		$this->slide2Dbox->CellCssStyle = "white-space: nowrap;";

		// custom-css
		$this->custom2Dcss->CellCssStyle = "white-space: nowrap;";

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

		$this->base2Dl->CellCssStyle = "white-space: nowrap;";

		// base-r
		$this->base2Dr->CellCssStyle = "white-space: nowrap;";

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

			// home-caption2
			$this->home2Dcaption2->LinkCustomAttributes = "";
			$this->home2Dcaption2->HrefValue = "";
			$this->home2Dcaption2->TooltipValue = "";

			// home-caption3
			$this->home2Dcaption3->LinkCustomAttributes = "";
			$this->home2Dcaption3->HrefValue = "";
			$this->home2Dcaption3->TooltipValue = "";

			// home-caption4
			$this->home2Dcaption4->LinkCustomAttributes = "";
			$this->home2Dcaption4->HrefValue = "";
			$this->home2Dcaption4->TooltipValue = "";

			// home-caption5
			$this->home2Dcaption5->LinkCustomAttributes = "";
			$this->home2Dcaption5->HrefValue = "";
			$this->home2Dcaption5->TooltipValue = "";

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
		$item->Body = "<a id=\"emf_layout\" href=\"javascript:void(0);\" class=\"ewExportLink ewEmail\" data-caption=\"" . $Language->Phrase("ExportToEmailText") . "\" onclick=\"ew_EmailDialogShow({lnk:'emf_layout',hdr:ewLanguage.Phrase('ExportToEmail'),f:document.flayoutlist,sel:false});\">" . $Language->Phrase("ExportToEmail") . "</a>";
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
if (!isset($layout_list)) $layout_list = new clayout_list();

// Page init
$layout_list->Page_Init();

// Page main
$layout_list->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$layout_list->Page_Render();
?>
<?php include_once "header.php" ?>
<?php if ($layout->Export == "") { ?>
<script type="text/javascript">

// Page object
var layout_list = new ew_Page("layout_list");
layout_list.PageID = "list"; // Page ID
var EW_PAGE_ID = layout_list.PageID; // For backward compatibility

// Form object
var flayoutlist = new ew_Form("flayoutlist");
flayoutlist.FormKeyCountName = '<?php echo $layout_list->FormKeyCountName ?>';

// Form_CustomValidate event
flayoutlist.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
flayoutlist.ValidateRequired = true;
<?php } else { ?>
flayoutlist.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
// Form object for search

var flayoutlistsrch = new ew_Form("flayoutlistsrch");
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
<?php if ($layout->Export == "") { ?>
<?php $Breadcrumb->Render(); ?>
<?php } ?>
<?php if ($layout_list->ExportOptions->Visible()) { ?>
<div class="ewListExportOptions"><?php $layout_list->ExportOptions->Render("body") ?></div>
<?php } ?>
<?php
	$bSelectLimit = EW_SELECT_LIMIT;
	if ($bSelectLimit) {
		$layout_list->TotalRecs = $layout->SelectRecordCount();
	} else {
		if ($layout_list->Recordset = $layout_list->LoadRecordset())
			$layout_list->TotalRecs = $layout_list->Recordset->RecordCount();
	}
	$layout_list->StartRec = 1;
	if ($layout_list->DisplayRecs <= 0 || ($layout->Export <> "" && $layout->ExportAll)) // Display all records
		$layout_list->DisplayRecs = $layout_list->TotalRecs;
	if (!($layout->Export <> "" && $layout->ExportAll))
		$layout_list->SetUpStartRec(); // Set up start record position
	if ($bSelectLimit)
		$layout_list->Recordset = $layout_list->LoadRecordset($layout_list->StartRec-1, $layout_list->DisplayRecs);
$layout_list->RenderOtherOptions();
?>
<?php if ($Security->IsLoggedIn()) { ?>
<?php if ($layout->Export == "" && $layout->CurrentAction == "") { ?>
<form name="flayoutlistsrch" id="flayoutlistsrch" class="ewForm form-inline" action="<?php echo ew_CurrentPage() ?>">
<table class="ewSearchTable"><tr><td>
<div class="accordion" id="flayoutlistsrch_SearchGroup">
	<div class="accordion-group">
		<div class="accordion-heading">
<a class="accordion-toggle" data-toggle="collapse" data-parent="#flayoutlistsrch_SearchGroup" href="#flayoutlistsrch_SearchBody"><?php echo $Language->Phrase("Search") ?></a>
		</div>
		<div id="flayoutlistsrch_SearchBody" class="accordion-body collapse in">
			<div class="accordion-inner">
<div id="flayoutlistsrch_SearchPanel">
<input type="hidden" name="cmd" value="search">
<input type="hidden" name="t" value="layout">
<div class="ewBasicSearch">
<div id="xsr_1" class="ewRow">
	<div class="btn-group ewButtonGroup">
	<div class="input-append">
	<input type="text" name="<?php echo EW_TABLE_BASIC_SEARCH ?>" id="<?php echo EW_TABLE_BASIC_SEARCH ?>" class="input-large" value="<?php echo ew_HtmlEncode($layout_list->BasicSearch->getKeyword()) ?>" placeholder="<?php echo $Language->Phrase("Search") ?>">
	<button class="btn btn-primary ewButton" name="btnsubmit" id="btnsubmit" type="submit"><?php echo $Language->Phrase("QuickSearchBtn") ?></button>
	</div>
	</div>
	<div class="btn-group ewButtonGroup">
	<a class="btn ewShowAll" href="<?php echo $layout_list->PageUrl() ?>cmd=reset"><?php echo $Language->Phrase("ShowAll") ?></a>
</div>
<div id="xsr_2" class="ewRow">
	<label class="inline radio ewRadio" style="white-space: nowrap;"><input type="radio" name="<?php echo EW_TABLE_BASIC_SEARCH_TYPE ?>" value="="<?php if ($layout_list->BasicSearch->getType() == "=") { ?> checked="checked"<?php } ?>><?php echo $Language->Phrase("ExactPhrase") ?></label>
	<label class="inline radio ewRadio" style="white-space: nowrap;"><input type="radio" name="<?php echo EW_TABLE_BASIC_SEARCH_TYPE ?>" value="AND"<?php if ($layout_list->BasicSearch->getType() == "AND") { ?> checked="checked"<?php } ?>><?php echo $Language->Phrase("AllWord") ?></label>
	<label class="inline radio ewRadio" style="white-space: nowrap;"><input type="radio" name="<?php echo EW_TABLE_BASIC_SEARCH_TYPE ?>" value="OR"<?php if ($layout_list->BasicSearch->getType() == "OR") { ?> checked="checked"<?php } ?>><?php echo $Language->Phrase("AnyWord") ?></label>
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
<?php $layout_list->ShowPageHeader(); ?>
<?php
$layout_list->ShowMessage();
?>
<table cellspacing="0" class="ewGrid"><tr><td class="ewGridContent">
<form name="flayoutlist" id="flayoutlist" class="ewForm form-horizontal" action="<?php echo ew_CurrentPage() ?>" method="post">
<input type="hidden" name="t" value="layout">
<div id="gmp_layout" class="ewGridMiddlePanel">
<?php if ($layout_list->TotalRecs > 0) { ?>
<table id="tbl_layoutlist" class="ewTable ewTableSeparate">
<?php echo $layout->TableCustomInnerHtml ?>
<thead><!-- Table header -->
	<tr class="ewTableHeader">
<?php

// Render list options
$layout_list->RenderListOptions();

// Render list options (header, left)
$layout_list->ListOptions->Render("header", "left");
?>
<?php if ($layout->top2Dl->Visible) { // top-l ?>
	<?php if ($layout->SortUrl($layout->top2Dl) == "") { ?>
		<td><div id="elh_layout_top2Dl" class="layout_top2Dl"><div class="ewTableHeaderCaption"><?php echo $layout->top2Dl->FldCaption() ?></div></div></td>
	<?php } else { ?>
		<td><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $layout->SortUrl($layout->top2Dl) ?>',2);"><div id="elh_layout_top2Dl" class="layout_top2Dl">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $layout->top2Dl->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($layout->top2Dl->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($layout->top2Dl->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></td>
	<?php } ?>
<?php } ?>		
<?php if ($layout->top2Dr->Visible) { // top-r ?>
	<?php if ($layout->SortUrl($layout->top2Dr) == "") { ?>
		<td><div id="elh_layout_top2Dr" class="layout_top2Dr"><div class="ewTableHeaderCaption"><?php echo $layout->top2Dr->FldCaption() ?></div></div></td>
	<?php } else { ?>
		<td><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $layout->SortUrl($layout->top2Dr) ?>',2);"><div id="elh_layout_top2Dr" class="layout_top2Dr">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $layout->top2Dr->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($layout->top2Dr->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($layout->top2Dr->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></td>
	<?php } ?>
<?php } ?>		
<?php if ($layout->head2Dl->Visible) { // head-l ?>
	<?php if ($layout->SortUrl($layout->head2Dl) == "") { ?>
		<td><div id="elh_layout_head2Dl" class="layout_head2Dl"><div class="ewTableHeaderCaption"><?php echo $layout->head2Dl->FldCaption() ?></div></div></td>
	<?php } else { ?>
		<td><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $layout->SortUrl($layout->head2Dl) ?>',2);"><div id="elh_layout_head2Dl" class="layout_head2Dl">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $layout->head2Dl->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($layout->head2Dl->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($layout->head2Dl->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></td>
	<?php } ?>
<?php } ?>		
<?php if ($layout->head2Dr->Visible) { // head-r ?>
	<?php if ($layout->SortUrl($layout->head2Dr) == "") { ?>
		<td><div id="elh_layout_head2Dr" class="layout_head2Dr"><div class="ewTableHeaderCaption"><?php echo $layout->head2Dr->FldCaption() ?></div></div></td>
	<?php } else { ?>
		<td><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $layout->SortUrl($layout->head2Dr) ?>',2);"><div id="elh_layout_head2Dr" class="layout_head2Dr">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $layout->head2Dr->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($layout->head2Dr->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($layout->head2Dr->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></td>
	<?php } ?>
<?php } ?>		
<?php if ($layout->slide1->Visible) { // slide1 ?>
	<?php if ($layout->SortUrl($layout->slide1) == "") { ?>
		<td><div id="elh_layout_slide1" class="layout_slide1"><div class="ewTableHeaderCaption"><?php echo $layout->slide1->FldCaption() ?></div></div></td>
	<?php } else { ?>
		<td><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $layout->SortUrl($layout->slide1) ?>',2);"><div id="elh_layout_slide1" class="layout_slide1">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $layout->slide1->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($layout->slide1->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($layout->slide1->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></td>
	<?php } ?>
<?php } ?>		
<?php if ($layout->slide2->Visible) { // slide2 ?>
	<?php if ($layout->SortUrl($layout->slide2) == "") { ?>
		<td><div id="elh_layout_slide2" class="layout_slide2"><div class="ewTableHeaderCaption"><?php echo $layout->slide2->FldCaption() ?></div></div></td>
	<?php } else { ?>
		<td><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $layout->SortUrl($layout->slide2) ?>',2);"><div id="elh_layout_slide2" class="layout_slide2">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $layout->slide2->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($layout->slide2->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($layout->slide2->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></td>
	<?php } ?>
<?php } ?>		
<?php if ($layout->slide3->Visible) { // slide3 ?>
	<?php if ($layout->SortUrl($layout->slide3) == "") { ?>
		<td><div id="elh_layout_slide3" class="layout_slide3"><div class="ewTableHeaderCaption"><?php echo $layout->slide3->FldCaption() ?></div></div></td>
	<?php } else { ?>
		<td><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $layout->SortUrl($layout->slide3) ?>',2);"><div id="elh_layout_slide3" class="layout_slide3">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $layout->slide3->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($layout->slide3->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($layout->slide3->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></td>
	<?php } ?>
<?php } ?>		
<?php if ($layout->slide4->Visible) { // slide4 ?>
	<?php if ($layout->SortUrl($layout->slide4) == "") { ?>
		<td><div id="elh_layout_slide4" class="layout_slide4"><div class="ewTableHeaderCaption"><?php echo $layout->slide4->FldCaption() ?></div></div></td>
	<?php } else { ?>
		<td><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $layout->SortUrl($layout->slide4) ?>',2);"><div id="elh_layout_slide4" class="layout_slide4">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $layout->slide4->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($layout->slide4->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($layout->slide4->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></td>
	<?php } ?>
<?php } ?>		
<?php if ($layout->slide5->Visible) { // slide5 ?>
	<?php if ($layout->SortUrl($layout->slide5) == "") { ?>
		<td><div id="elh_layout_slide5" class="layout_slide5"><div class="ewTableHeaderCaption"><?php echo $layout->slide5->FldCaption() ?></div></div></td>
	<?php } else { ?>
		<td><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $layout->SortUrl($layout->slide5) ?>',2);"><div id="elh_layout_slide5" class="layout_slide5">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $layout->slide5->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($layout->slide5->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($layout->slide5->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></td>
	<?php } ?>
<?php } ?>		
<?php if ($layout->slide6->Visible) { // slide6 ?>
	<?php if ($layout->SortUrl($layout->slide6) == "") { ?>
		<td><div id="elh_layout_slide6" class="layout_slide6"><div class="ewTableHeaderCaption"><?php echo $layout->slide6->FldCaption() ?></div></div></td>
	<?php } else { ?>
		<td><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $layout->SortUrl($layout->slide6) ?>',2);"><div id="elh_layout_slide6" class="layout_slide6">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $layout->slide6->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($layout->slide6->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($layout->slide6->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></td>
	<?php } ?>
<?php } ?>		
<?php if ($layout->home2Dcaption1->Visible) { // home-caption1 ?>
	<?php if ($layout->SortUrl($layout->home2Dcaption1) == "") { ?>
		<td><div id="elh_layout_home2Dcaption1" class="layout_home2Dcaption1"><div class="ewTableHeaderCaption"><?php echo $layout->home2Dcaption1->FldCaption() ?></div></div></td>
	<?php } else { ?>
		<td><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $layout->SortUrl($layout->home2Dcaption1) ?>',2);"><div id="elh_layout_home2Dcaption1" class="layout_home2Dcaption1">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $layout->home2Dcaption1->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($layout->home2Dcaption1->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($layout->home2Dcaption1->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></td>
	<?php } ?>
<?php } ?>		
<?php if ($layout->home2Dcaption2->Visible) { // home-caption2 ?>
	<?php if ($layout->SortUrl($layout->home2Dcaption2) == "") { ?>
		<td><div id="elh_layout_home2Dcaption2" class="layout_home2Dcaption2"><div class="ewTableHeaderCaption"><?php echo $layout->home2Dcaption2->FldCaption() ?></div></div></td>
	<?php } else { ?>
		<td><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $layout->SortUrl($layout->home2Dcaption2) ?>',2);"><div id="elh_layout_home2Dcaption2" class="layout_home2Dcaption2">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $layout->home2Dcaption2->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($layout->home2Dcaption2->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($layout->home2Dcaption2->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></td>
	<?php } ?>
<?php } ?>		
<?php if ($layout->home2Dcaption3->Visible) { // home-caption3 ?>
	<?php if ($layout->SortUrl($layout->home2Dcaption3) == "") { ?>
		<td><div id="elh_layout_home2Dcaption3" class="layout_home2Dcaption3"><div class="ewTableHeaderCaption"><?php echo $layout->home2Dcaption3->FldCaption() ?></div></div></td>
	<?php } else { ?>
		<td><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $layout->SortUrl($layout->home2Dcaption3) ?>',2);"><div id="elh_layout_home2Dcaption3" class="layout_home2Dcaption3">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $layout->home2Dcaption3->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($layout->home2Dcaption3->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($layout->home2Dcaption3->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></td>
	<?php } ?>
<?php } ?>		
<?php if ($layout->home2Dcaption4->Visible) { // home-caption4 ?>
	<?php if ($layout->SortUrl($layout->home2Dcaption4) == "") { ?>
		<td><div id="elh_layout_home2Dcaption4" class="layout_home2Dcaption4"><div class="ewTableHeaderCaption"><?php echo $layout->home2Dcaption4->FldCaption() ?></div></div></td>
	<?php } else { ?>
		<td><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $layout->SortUrl($layout->home2Dcaption4) ?>',2);"><div id="elh_layout_home2Dcaption4" class="layout_home2Dcaption4">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $layout->home2Dcaption4->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($layout->home2Dcaption4->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($layout->home2Dcaption4->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></td>
	<?php } ?>
<?php } ?>		
<?php if ($layout->home2Dcaption5->Visible) { // home-caption5 ?>
	<?php if ($layout->SortUrl($layout->home2Dcaption5) == "") { ?>
		<td><div id="elh_layout_home2Dcaption5" class="layout_home2Dcaption5"><div class="ewTableHeaderCaption"><?php echo $layout->home2Dcaption5->FldCaption() ?></div></div></td>
	<?php } else { ?>
		<td><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $layout->SortUrl($layout->home2Dcaption5) ?>',2);"><div id="elh_layout_home2Dcaption5" class="layout_home2Dcaption5">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $layout->home2Dcaption5->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($layout->home2Dcaption5->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($layout->home2Dcaption5->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></td>
	<?php } ?>
<?php } ?>		
<?php if ($layout->home2Dcaption6->Visible) { // home-caption6 ?>
	<?php if ($layout->SortUrl($layout->home2Dcaption6) == "") { ?>
		<td><div id="elh_layout_home2Dcaption6" class="layout_home2Dcaption6"><div class="ewTableHeaderCaption"><?php echo $layout->home2Dcaption6->FldCaption() ?></div></div></td>
	<?php } else { ?>
		<td><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $layout->SortUrl($layout->home2Dcaption6) ?>',2);"><div id="elh_layout_home2Dcaption6" class="layout_home2Dcaption6">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $layout->home2Dcaption6->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($layout->home2Dcaption6->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($layout->home2Dcaption6->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></td>
	<?php } ?>
<?php } ?>		
<?php if ($layout->home2Dtext6->Visible) { // home-text6 ?>
	<?php if ($layout->SortUrl($layout->home2Dtext6) == "") { ?>
		<td><div id="elh_layout_home2Dtext6" class="layout_home2Dtext6"><div class="ewTableHeaderCaption"><?php echo $layout->home2Dtext6->FldCaption() ?></div></div></td>
	<?php } else { ?>
		<td><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $layout->SortUrl($layout->home2Dtext6) ?>',2);"><div id="elh_layout_home2Dtext6" class="layout_home2Dtext6">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $layout->home2Dtext6->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($layout->home2Dtext6->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($layout->home2Dtext6->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></td>
	<?php } ?>
<?php } ?>		
<?php if ($layout->footer2D1->Visible) { // footer-1 ?>
	<?php if ($layout->SortUrl($layout->footer2D1) == "") { ?>
		<td><div id="elh_layout_footer2D1" class="layout_footer2D1"><div class="ewTableHeaderCaption"><?php echo $layout->footer2D1->FldCaption() ?></div></div></td>
	<?php } else { ?>
		<td><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $layout->SortUrl($layout->footer2D1) ?>',2);"><div id="elh_layout_footer2D1" class="layout_footer2D1">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $layout->footer2D1->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($layout->footer2D1->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($layout->footer2D1->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></td>
	<?php } ?>
<?php } ?>		
<?php if ($layout->footer2D2->Visible) { // footer-2 ?>
	<?php if ($layout->SortUrl($layout->footer2D2) == "") { ?>
		<td><div id="elh_layout_footer2D2" class="layout_footer2D2"><div class="ewTableHeaderCaption"><?php echo $layout->footer2D2->FldCaption() ?></div></div></td>
	<?php } else { ?>
		<td><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $layout->SortUrl($layout->footer2D2) ?>',2);"><div id="elh_layout_footer2D2" class="layout_footer2D2">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $layout->footer2D2->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($layout->footer2D2->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($layout->footer2D2->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></td>
	<?php } ?>
<?php } ?>		
<?php if ($layout->footer2D3->Visible) { // footer-3 ?>
	<?php if ($layout->SortUrl($layout->footer2D3) == "") { ?>
		<td><div id="elh_layout_footer2D3" class="layout_footer2D3"><div class="ewTableHeaderCaption"><?php echo $layout->footer2D3->FldCaption() ?></div></div></td>
	<?php } else { ?>
		<td><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $layout->SortUrl($layout->footer2D3) ?>',2);"><div id="elh_layout_footer2D3" class="layout_footer2D3">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $layout->footer2D3->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($layout->footer2D3->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($layout->footer2D3->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></td>
	<?php } ?>
<?php } ?>		
<?php if ($layout->footer2D4->Visible) { // footer-4 ?>
	<?php if ($layout->SortUrl($layout->footer2D4) == "") { ?>
		<td><div id="elh_layout_footer2D4" class="layout_footer2D4"><div class="ewTableHeaderCaption"><?php echo $layout->footer2D4->FldCaption() ?></div></div></td>
	<?php } else { ?>
		<td><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $layout->SortUrl($layout->footer2D4) ?>',2);"><div id="elh_layout_footer2D4" class="layout_footer2D4">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $layout->footer2D4->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($layout->footer2D4->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($layout->footer2D4->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></td>
	<?php } ?>
<?php } ?>		
<?php

// Render list options (header, right)
$layout_list->ListOptions->Render("header", "right");
?>
	</tr>
</thead>
<tbody>
<?php
if ($layout->ExportAll && $layout->Export <> "") {
	$layout_list->StopRec = $layout_list->TotalRecs;
} else {

	// Set the last record to display
	if ($layout_list->TotalRecs > $layout_list->StartRec + $layout_list->DisplayRecs - 1)
		$layout_list->StopRec = $layout_list->StartRec + $layout_list->DisplayRecs - 1;
	else
		$layout_list->StopRec = $layout_list->TotalRecs;
}
$layout_list->RecCnt = $layout_list->StartRec - 1;
if ($layout_list->Recordset && !$layout_list->Recordset->EOF) {
	$layout_list->Recordset->MoveFirst();
	if (!$bSelectLimit && $layout_list->StartRec > 1)
		$layout_list->Recordset->Move($layout_list->StartRec - 1);
} elseif (!$layout->AllowAddDeleteRow && $layout_list->StopRec == 0) {
	$layout_list->StopRec = $layout->GridAddRowCount;
}

// Initialize aggregate
$layout->RowType = EW_ROWTYPE_AGGREGATEINIT;
$layout->ResetAttrs();
$layout_list->RenderRow();
while ($layout_list->RecCnt < $layout_list->StopRec) {
	$layout_list->RecCnt++;
	if (intval($layout_list->RecCnt) >= intval($layout_list->StartRec)) {
		$layout_list->RowCnt++;

		// Set up key count
		$layout_list->KeyCount = $layout_list->RowIndex;

		// Init row class and style
		$layout->ResetAttrs();
		$layout->CssClass = "";
		if ($layout->CurrentAction == "gridadd") {
		} else {
			$layout_list->LoadRowValues($layout_list->Recordset); // Load row values
		}
		$layout->RowType = EW_ROWTYPE_VIEW; // Render view

		// Set up row id / data-rowindex
		$layout->RowAttrs = array_merge($layout->RowAttrs, array('data-rowindex'=>$layout_list->RowCnt, 'id'=>'r' . $layout_list->RowCnt . '_layout', 'data-rowtype'=>$layout->RowType));

		// Render row
		$layout_list->RenderRow();

		// Render list options
		$layout_list->RenderListOptions();
?>
	<tr<?php echo $layout->RowAttributes() ?>>
<?php

// Render list options (body, left)
$layout_list->ListOptions->Render("body", "left", $layout_list->RowCnt);
?>
	<?php if ($layout->top2Dl->Visible) { // top-l ?>
		<td<?php echo $layout->top2Dl->CellAttributes() ?>>
<span<?php echo $layout->top2Dl->ViewAttributes() ?>>
<?php echo $layout->top2Dl->ListViewValue() ?></span>
<a id="<?php echo $layout_list->PageObjName . "_row_" . $layout_list->RowCnt ?>"></a></td>
	<?php } ?>
	<?php if ($layout->top2Dr->Visible) { // top-r ?>
		<td<?php echo $layout->top2Dr->CellAttributes() ?>>
<span<?php echo $layout->top2Dr->ViewAttributes() ?>>
<?php echo $layout->top2Dr->ListViewValue() ?></span>
<a id="<?php echo $layout_list->PageObjName . "_row_" . $layout_list->RowCnt ?>"></a></td>
	<?php } ?>
	<?php if ($layout->head2Dl->Visible) { // head-l ?>
		<td<?php echo $layout->head2Dl->CellAttributes() ?>>
<span<?php echo $layout->head2Dl->ViewAttributes() ?>>
<?php echo $layout->head2Dl->ListViewValue() ?></span>
<a id="<?php echo $layout_list->PageObjName . "_row_" . $layout_list->RowCnt ?>"></a></td>
	<?php } ?>
	<?php if ($layout->head2Dr->Visible) { // head-r ?>
		<td<?php echo $layout->head2Dr->CellAttributes() ?>>
<span<?php echo $layout->head2Dr->ViewAttributes() ?>>
<?php echo $layout->head2Dr->ListViewValue() ?></span>
<a id="<?php echo $layout_list->PageObjName . "_row_" . $layout_list->RowCnt ?>"></a></td>
	<?php } ?>
	<?php if ($layout->slide1->Visible) { // slide1 ?>
		<td<?php echo $layout->slide1->CellAttributes() ?>>
<span<?php echo $layout->slide1->ViewAttributes() ?>>
<?php if ($layout->slide1->LinkAttributes() <> "") { ?>
<?php if (!empty($layout->slide1->Upload->DbValue)) { ?>
<a<?php echo $layout->slide1->LinkAttributes() ?>><?php echo $layout->slide1->ListViewValue() ?></a>
<?php } elseif (!in_array($layout->CurrentAction, array("I", "edit", "gridedit"))) { ?>	
&nbsp;
<?php } ?>
<?php } else { ?>
<?php if (!empty($layout->slide1->Upload->DbValue)) { ?>
<?php echo $layout->slide1->ListViewValue() ?>
<?php } elseif (!in_array($layout->CurrentAction, array("I", "edit", "gridedit"))) { ?>	
&nbsp;
<?php } ?>
<?php } ?>
</span>
<a id="<?php echo $layout_list->PageObjName . "_row_" . $layout_list->RowCnt ?>"></a></td>
	<?php } ?>
	<?php if ($layout->slide2->Visible) { // slide2 ?>
		<td<?php echo $layout->slide2->CellAttributes() ?>>
<span<?php echo $layout->slide2->ViewAttributes() ?>>
<?php if ($layout->slide2->LinkAttributes() <> "") { ?>
<?php if (!empty($layout->slide2->Upload->DbValue)) { ?>
<a<?php echo $layout->slide2->LinkAttributes() ?>><?php echo $layout->slide2->ListViewValue() ?></a>
<?php } elseif (!in_array($layout->CurrentAction, array("I", "edit", "gridedit"))) { ?>	
&nbsp;
<?php } ?>
<?php } else { ?>
<?php if (!empty($layout->slide2->Upload->DbValue)) { ?>
<?php echo $layout->slide2->ListViewValue() ?>
<?php } elseif (!in_array($layout->CurrentAction, array("I", "edit", "gridedit"))) { ?>	
&nbsp;
<?php } ?>
<?php } ?>
</span>
<a id="<?php echo $layout_list->PageObjName . "_row_" . $layout_list->RowCnt ?>"></a></td>
	<?php } ?>
	<?php if ($layout->slide3->Visible) { // slide3 ?>
		<td<?php echo $layout->slide3->CellAttributes() ?>>
<span<?php echo $layout->slide3->ViewAttributes() ?>>
<?php if ($layout->slide3->LinkAttributes() <> "") { ?>
<?php if (!empty($layout->slide3->Upload->DbValue)) { ?>
<a<?php echo $layout->slide3->LinkAttributes() ?>><?php echo $layout->slide3->ListViewValue() ?></a>
<?php } elseif (!in_array($layout->CurrentAction, array("I", "edit", "gridedit"))) { ?>	
&nbsp;
<?php } ?>
<?php } else { ?>
<?php if (!empty($layout->slide3->Upload->DbValue)) { ?>
<?php echo $layout->slide3->ListViewValue() ?>
<?php } elseif (!in_array($layout->CurrentAction, array("I", "edit", "gridedit"))) { ?>	
&nbsp;
<?php } ?>
<?php } ?>
</span>
<a id="<?php echo $layout_list->PageObjName . "_row_" . $layout_list->RowCnt ?>"></a></td>
	<?php } ?>
	<?php if ($layout->slide4->Visible) { // slide4 ?>
		<td<?php echo $layout->slide4->CellAttributes() ?>>
<span<?php echo $layout->slide4->ViewAttributes() ?>>
<?php if ($layout->slide4->LinkAttributes() <> "") { ?>
<?php if (!empty($layout->slide4->Upload->DbValue)) { ?>
<a<?php echo $layout->slide4->LinkAttributes() ?>><?php echo $layout->slide4->ListViewValue() ?></a>
<?php } elseif (!in_array($layout->CurrentAction, array("I", "edit", "gridedit"))) { ?>	
&nbsp;
<?php } ?>
<?php } else { ?>
<?php if (!empty($layout->slide4->Upload->DbValue)) { ?>
<?php echo $layout->slide4->ListViewValue() ?>
<?php } elseif (!in_array($layout->CurrentAction, array("I", "edit", "gridedit"))) { ?>	
&nbsp;
<?php } ?>
<?php } ?>
</span>
<a id="<?php echo $layout_list->PageObjName . "_row_" . $layout_list->RowCnt ?>"></a></td>
	<?php } ?>
	<?php if ($layout->slide5->Visible) { // slide5 ?>
		<td<?php echo $layout->slide5->CellAttributes() ?>>
<span<?php echo $layout->slide5->ViewAttributes() ?>>
<?php if ($layout->slide5->LinkAttributes() <> "") { ?>
<?php if (!empty($layout->slide5->Upload->DbValue)) { ?>
<a<?php echo $layout->slide5->LinkAttributes() ?>><?php echo $layout->slide5->ListViewValue() ?></a>
<?php } elseif (!in_array($layout->CurrentAction, array("I", "edit", "gridedit"))) { ?>	
&nbsp;
<?php } ?>
<?php } else { ?>
<?php if (!empty($layout->slide5->Upload->DbValue)) { ?>
<?php echo $layout->slide5->ListViewValue() ?>
<?php } elseif (!in_array($layout->CurrentAction, array("I", "edit", "gridedit"))) { ?>	
&nbsp;
<?php } ?>
<?php } ?>
</span>
<a id="<?php echo $layout_list->PageObjName . "_row_" . $layout_list->RowCnt ?>"></a></td>
	<?php } ?>
	<?php if ($layout->slide6->Visible) { // slide6 ?>
		<td<?php echo $layout->slide6->CellAttributes() ?>>
<span<?php echo $layout->slide6->ViewAttributes() ?>>
<?php if ($layout->slide6->LinkAttributes() <> "") { ?>
<?php if (!empty($layout->slide6->Upload->DbValue)) { ?>
<a<?php echo $layout->slide6->LinkAttributes() ?>><?php echo $layout->slide6->ListViewValue() ?></a>
<?php } elseif (!in_array($layout->CurrentAction, array("I", "edit", "gridedit"))) { ?>	
&nbsp;
<?php } ?>
<?php } else { ?>
<?php if (!empty($layout->slide6->Upload->DbValue)) { ?>
<?php echo $layout->slide6->ListViewValue() ?>
<?php } elseif (!in_array($layout->CurrentAction, array("I", "edit", "gridedit"))) { ?>	
&nbsp;
<?php } ?>
<?php } ?>
</span>
<a id="<?php echo $layout_list->PageObjName . "_row_" . $layout_list->RowCnt ?>"></a></td>
	<?php } ?>
	<?php if ($layout->home2Dcaption1->Visible) { // home-caption1 ?>
		<td<?php echo $layout->home2Dcaption1->CellAttributes() ?>>
<span<?php echo $layout->home2Dcaption1->ViewAttributes() ?>>
<?php echo $layout->home2Dcaption1->ListViewValue() ?></span>
<a id="<?php echo $layout_list->PageObjName . "_row_" . $layout_list->RowCnt ?>"></a></td>
	<?php } ?>
	<?php if ($layout->home2Dcaption2->Visible) { // home-caption2 ?>
		<td<?php echo $layout->home2Dcaption2->CellAttributes() ?>>
<span<?php echo $layout->home2Dcaption2->ViewAttributes() ?>>
<?php echo $layout->home2Dcaption2->ListViewValue() ?></span>
<a id="<?php echo $layout_list->PageObjName . "_row_" . $layout_list->RowCnt ?>"></a></td>
	<?php } ?>
	<?php if ($layout->home2Dcaption3->Visible) { // home-caption3 ?>
		<td<?php echo $layout->home2Dcaption3->CellAttributes() ?>>
<span<?php echo $layout->home2Dcaption3->ViewAttributes() ?>>
<?php echo $layout->home2Dcaption3->ListViewValue() ?></span>
<a id="<?php echo $layout_list->PageObjName . "_row_" . $layout_list->RowCnt ?>"></a></td>
	<?php } ?>
	<?php if ($layout->home2Dcaption4->Visible) { // home-caption4 ?>
		<td<?php echo $layout->home2Dcaption4->CellAttributes() ?>>
<span<?php echo $layout->home2Dcaption4->ViewAttributes() ?>>
<?php echo $layout->home2Dcaption4->ListViewValue() ?></span>
<a id="<?php echo $layout_list->PageObjName . "_row_" . $layout_list->RowCnt ?>"></a></td>
	<?php } ?>
	<?php if ($layout->home2Dcaption5->Visible) { // home-caption5 ?>
		<td<?php echo $layout->home2Dcaption5->CellAttributes() ?>>
<span<?php echo $layout->home2Dcaption5->ViewAttributes() ?>>
<?php echo $layout->home2Dcaption5->ListViewValue() ?></span>
<a id="<?php echo $layout_list->PageObjName . "_row_" . $layout_list->RowCnt ?>"></a></td>
	<?php } ?>
	<?php if ($layout->home2Dcaption6->Visible) { // home-caption6 ?>
		<td<?php echo $layout->home2Dcaption6->CellAttributes() ?>>
<span<?php echo $layout->home2Dcaption6->ViewAttributes() ?>>
<?php echo $layout->home2Dcaption6->ListViewValue() ?></span>
<a id="<?php echo $layout_list->PageObjName . "_row_" . $layout_list->RowCnt ?>"></a></td>
	<?php } ?>
	<?php if ($layout->home2Dtext6->Visible) { // home-text6 ?>
		<td<?php echo $layout->home2Dtext6->CellAttributes() ?>>
<span<?php echo $layout->home2Dtext6->ViewAttributes() ?>>
<?php echo $layout->home2Dtext6->ListViewValue() ?></span>
<a id="<?php echo $layout_list->PageObjName . "_row_" . $layout_list->RowCnt ?>"></a></td>
	<?php } ?>
	<?php if ($layout->footer2D1->Visible) { // footer-1 ?>
		<td<?php echo $layout->footer2D1->CellAttributes() ?>>
<span<?php echo $layout->footer2D1->ViewAttributes() ?>>
<?php echo $layout->footer2D1->ListViewValue() ?></span>
<a id="<?php echo $layout_list->PageObjName . "_row_" . $layout_list->RowCnt ?>"></a></td>
	<?php } ?>
	<?php if ($layout->footer2D2->Visible) { // footer-2 ?>
		<td<?php echo $layout->footer2D2->CellAttributes() ?>>
<span<?php echo $layout->footer2D2->ViewAttributes() ?>>
<?php echo $layout->footer2D2->ListViewValue() ?></span>
<a id="<?php echo $layout_list->PageObjName . "_row_" . $layout_list->RowCnt ?>"></a></td>
	<?php } ?>
	<?php if ($layout->footer2D3->Visible) { // footer-3 ?>
		<td<?php echo $layout->footer2D3->CellAttributes() ?>>
<span<?php echo $layout->footer2D3->ViewAttributes() ?>>
<?php echo $layout->footer2D3->ListViewValue() ?></span>
<a id="<?php echo $layout_list->PageObjName . "_row_" . $layout_list->RowCnt ?>"></a></td>
	<?php } ?>
	<?php if ($layout->footer2D4->Visible) { // footer-4 ?>
		<td<?php echo $layout->footer2D4->CellAttributes() ?>>
<span<?php echo $layout->footer2D4->ViewAttributes() ?>>
<?php echo $layout->footer2D4->ListViewValue() ?></span>
<a id="<?php echo $layout_list->PageObjName . "_row_" . $layout_list->RowCnt ?>"></a></td>
	<?php } ?>
<?php

// Render list options (body, right)
$layout_list->ListOptions->Render("body", "right", $layout_list->RowCnt);
?>
	</tr>
<?php
	}
	if ($layout->CurrentAction <> "gridadd")
		$layout_list->Recordset->MoveNext();
}
?>
</tbody>
</table>
<?php } ?>
<?php if ($layout->CurrentAction == "") { ?>
<input type="hidden" name="a_list" id="a_list" value="">
<?php } ?>
</div>
</form>
<?php

// Close recordset
if ($layout_list->Recordset)
	$layout_list->Recordset->Close();
?>
<?php if ($layout->Export == "") { ?>
<div class="ewGridLowerPanel">
<?php if ($layout->CurrentAction <> "gridadd" && $layout->CurrentAction <> "gridedit") { ?>
<form name="ewPagerForm" class="ewForm form-horizontal" action="<?php echo ew_CurrentPage() ?>">
<table class="ewPager">
<tr><td>
<?php if (!isset($layout_list->Pager)) $layout_list->Pager = new cNumericPager($layout_list->StartRec, $layout_list->DisplayRecs, $layout_list->TotalRecs, $layout_list->RecRange) ?>
<?php if ($layout_list->Pager->RecordCount > 0) { ?>
<table cellspacing="0" class="ewStdTable"><tbody><tr><td>
<div class="pagination"><ul>
	<?php if ($layout_list->Pager->FirstButton->Enabled) { ?>
	<li><a href="<?php echo $layout_list->PageUrl() ?>start=<?php echo $layout_list->Pager->FirstButton->Start ?>"><?php echo $Language->Phrase("PagerFirst") ?></a></li>
	<?php } ?>
	<?php if ($layout_list->Pager->PrevButton->Enabled) { ?>
	<li><a href="<?php echo $layout_list->PageUrl() ?>start=<?php echo $layout_list->Pager->PrevButton->Start ?>"><?php echo $Language->Phrase("PagerPrevious") ?></a></li>
	<?php } ?>
	<?php foreach ($layout_list->Pager->Items as $PagerItem) { ?>
		<li<?php if (!$PagerItem->Enabled) { echo " class=\" active\""; } ?>><a href="<?php if ($PagerItem->Enabled) { echo $layout_list->PageUrl() . "start=" . $PagerItem->Start; } else { echo "#"; } ?>"><?php echo $PagerItem->Text ?></a></li>
	<?php } ?>
	<?php if ($layout_list->Pager->NextButton->Enabled) { ?>
	<li><a href="<?php echo $layout_list->PageUrl() ?>start=<?php echo $layout_list->Pager->NextButton->Start ?>"><?php echo $Language->Phrase("PagerNext") ?></a></li>
	<?php } ?>
	<?php if ($layout_list->Pager->LastButton->Enabled) { ?>
	<li><a href="<?php echo $layout_list->PageUrl() ?>start=<?php echo $layout_list->Pager->LastButton->Start ?>"><?php echo $Language->Phrase("PagerLast") ?></a></li>
	<?php } ?>
</ul></div>
</td>
<td>
	<?php if ($layout_list->Pager->ButtonCount > 0) { ?>&nbsp;&nbsp;&nbsp;&nbsp;<?php } ?>
	<?php echo $Language->Phrase("Record") ?>&nbsp;<?php echo $layout_list->Pager->FromIndex ?>&nbsp;<?php echo $Language->Phrase("To") ?>&nbsp;<?php echo $layout_list->Pager->ToIndex ?>&nbsp;<?php echo $Language->Phrase("Of") ?>&nbsp;<?php echo $layout_list->Pager->RecordCount ?>
</td>
</tr></tbody></table>
<?php } else { ?>
	<?php if ($layout_list->SearchWhere == "0=101") { ?>
	<p><?php echo $Language->Phrase("EnterSearchCriteria") ?></p>
	<?php } else { ?>
	<p><?php echo $Language->Phrase("NoRecord") ?></p>
	<?php } ?>
<?php } ?>
</td>
<?php if ($layout_list->TotalRecs > 0) { ?>
<td>
	&nbsp;&nbsp;&nbsp;&nbsp;
<input type="hidden" name="t" value="layout">
<select name="<?php echo EW_TABLE_REC_PER_PAGE ?>" class="input-small" onchange="this.form.submit();">
<option value="25"<?php if ($layout_list->DisplayRecs == 25) { ?> selected="selected"<?php } ?>>25</option>
<option value="50"<?php if ($layout_list->DisplayRecs == 50) { ?> selected="selected"<?php } ?>>50</option>
<option value="100"<?php if ($layout_list->DisplayRecs == 100) { ?> selected="selected"<?php } ?>>100</option>
<option value="200"<?php if ($layout_list->DisplayRecs == 200) { ?> selected="selected"<?php } ?>>200</option>
<option value="500"<?php if ($layout_list->DisplayRecs == 500) { ?> selected="selected"<?php } ?>>500</option>
<option value="ALL"<?php if ($layout->getRecordsPerPage() == -1) { ?> selected="selected"<?php } ?>><?php echo $Language->Phrase("AllRecords") ?></option>
</select>
</td>
<?php } ?>
</tr></table>
</form>
<?php } ?>
<div class="ewListOtherOptions">
<?php
	foreach ($layout_list->OtherOptions as &$option)
		$option->Render("body", "bottom");
?>
</div>
</div>
<?php } ?>
</td></tr></table>
<?php if ($layout->Export == "") { ?>
<script type="text/javascript">
flayoutlistsrch.Init();
flayoutlist.Init();
<?php if (EW_MOBILE_REFLOW && ew_IsMobile()) { ?>
ew_Reflow();
<?php } ?>
</script>
<?php } ?>
<?php
$layout_list->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<?php if ($layout->Export == "") { ?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php } ?>
<?php include_once "footer.php" ?>
<?php
$layout_list->Page_Terminate();
?>
