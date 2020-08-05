<?php
if (session_id() == "") session_start(); // Initialize Session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg10.php" ?>
<?php include_once "ewmysql10.php" ?>
<?php include_once "phpfn10.php" ?>
<?php include_once "reservetrust_tbinfo.php" ?>
<?php include_once "adminusersinfo.php" ?>
<?php include_once "userfn10.php" ?>
<?php

//
// Page class
//

$reservetrust_tb_list = NULL; // Initialize page object first

class creservetrust_tb_list extends creservetrust_tb {

	// Page ID
	var $PageID = 'list';

	// Project ID
	var $ProjectID = "{D9B361E7-B2C1-4293-B9B3-B581986A15CC}";

	// Table name
	var $TableName = 'reservetrust_tb';

	// Page object name
	var $PageObjName = 'reservetrust_tb_list';

	// Grid form hidden field names
	var $FormName = 'freservetrust_tblist';
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

		// Table object (reservetrust_tb)
		if (!isset($GLOBALS["reservetrust_tb"])) {
			$GLOBALS["reservetrust_tb"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["reservetrust_tb"];
		}

		// Initialize URLs
		$this->ExportPrintUrl = $this->PageUrl() . "export=print";
		$this->ExportExcelUrl = $this->PageUrl() . "export=excel";
		$this->ExportWordUrl = $this->PageUrl() . "export=word";
		$this->ExportHtmlUrl = $this->PageUrl() . "export=html";
		$this->ExportXmlUrl = $this->PageUrl() . "export=xml";
		$this->ExportCsvUrl = $this->PageUrl() . "export=csv";
		$this->ExportPdfUrl = $this->PageUrl() . "export=pdf";
		$this->AddUrl = "reservetrust_tbadd.php";
		$this->InlineAddUrl = $this->PageUrl() . "a=add";
		$this->GridAddUrl = $this->PageUrl() . "a=gridadd";
		$this->GridEditUrl = $this->PageUrl() . "a=gridedit";
		$this->MultiDeleteUrl = "reservetrust_tbdelete.php";
		$this->MultiUpdateUrl = "reservetrust_tbupdate.php";

		// Table object (adminusers)
		if (!isset($GLOBALS['adminusers'])) $GLOBALS['adminusers'] = new cadminusers();

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'list', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'reservetrust_tb', TRUE);

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
		$this->BuildBasicSearchSQL($sWhere, $this->marriagetype, $Keyword);
		$this->BuildBasicSearchSQL($sWhere, $this->marriageyear, $Keyword);
		$this->BuildBasicSearchSQL($sWhere, $this->marriagecert, $Keyword);
		$this->BuildBasicSearchSQL($sWhere, $this->divorce, $Keyword);
		$this->BuildBasicSearchSQL($sWhere, $this->divorceyear, $Keyword);
		$this->BuildBasicSearchSQL($sWhere, $this->maidenname, $Keyword);
		$this->BuildBasicSearchSQL($sWhere, $this->identificationtype, $Keyword);
		$this->BuildBasicSearchSQL($sWhere, $this->idnumber, $Keyword);
		$this->BuildBasicSearchSQL($sWhere, $this->issuedate, $Keyword);
		$this->BuildBasicSearchSQL($sWhere, $this->expirydate, $Keyword);
		$this->BuildBasicSearchSQL($sWhere, $this->issueplace, $Keyword);
		$this->BuildBasicSearchSQL($sWhere, $this->spousename, $Keyword);
		$this->BuildBasicSearchSQL($sWhere, $this->spouseemail, $Keyword);
		$this->BuildBasicSearchSQL($sWhere, $this->spousephone, $Keyword);
		$this->BuildBasicSearchSQL($sWhere, $this->spousedob, $Keyword);
		$this->BuildBasicSearchSQL($sWhere, $this->spouseaddr, $Keyword);
		$this->BuildBasicSearchSQL($sWhere, $this->spousecity, $Keyword);
		$this->BuildBasicSearchSQL($sWhere, $this->spousestate, $Keyword);
		$this->BuildBasicSearchSQL($sWhere, $this->cityofmarriage, $Keyword);
		$this->BuildBasicSearchSQL($sWhere, $this->countryofmarriage, $Keyword);
		$this->BuildBasicSearchSQL($sWhere, $this->nextofkinfullname, $Keyword);
		$this->BuildBasicSearchSQL($sWhere, $this->nextofkintelephone, $Keyword);
		$this->BuildBasicSearchSQL($sWhere, $this->nextofkinemail, $Keyword);
		$this->BuildBasicSearchSQL($sWhere, $this->nextofkinaddress, $Keyword);
		$this->BuildBasicSearchSQL($sWhere, $this->nameofcompany, $Keyword);
		$this->BuildBasicSearchSQL($sWhere, $this->humanresourcescontacttelephone, $Keyword);
		$this->BuildBasicSearchSQL($sWhere, $this->humanresourcescontactemailaddress, $Keyword);
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
			$this->UpdateSort($this->fullname, $bCtrl); // fullname
			$this->UpdateSort($this->_email, $bCtrl); // email
			$this->UpdateSort($this->phoneno, $bCtrl); // phoneno
			$this->UpdateSort($this->gender, $bCtrl); // gender
			$this->UpdateSort($this->dob, $bCtrl); // dob
			$this->UpdateSort($this->employmentstatus, $bCtrl); // employmentstatus
			$this->UpdateSort($this->maritalstatus, $bCtrl); // maritalstatus
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
				$this->fullname->setSort("");
				$this->_email->setSort("");
				$this->phoneno->setSort("");
				$this->gender->setSort("");
				$this->dob->setSort("");
				$this->employmentstatus->setSort("");
				$this->maritalstatus->setSort("");
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
		$item->Body = "<a class=\"ewAction ewMultiDelete\" href=\"\" onclick=\"ew_SubmitSelected(document.freservetrust_tblist, '" . $this->MultiDeleteUrl . "', ewLanguage.Phrase('DeleteMultiConfirmMsg'));return false;\">" . $Language->Phrase("DeleteSelectedLink") . "</a>";
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
				$item->Body = "<a class=\"ewAction ewCustomAction\" href=\"\" onclick=\"ew_SubmitSelected(document.freservetrust_tblist, '" . ew_CurrentUrl() . "', null, '" . $action . "');return false;\">" . $name . "</a>";
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
		$this->marriagetype->setDbValue($rs->fields('marriagetype'));
		$this->marriageyear->setDbValue($rs->fields('marriageyear'));
		$this->marriagecert->setDbValue($rs->fields('marriagecert'));
		$this->divorce->setDbValue($rs->fields('divorce'));
		$this->divorceyear->setDbValue($rs->fields('divorceyear'));
		$this->datecreated->setDbValue($rs->fields('datecreated'));
		$this->maidenname->setDbValue($rs->fields('maidenname'));
		$this->identificationtype->setDbValue($rs->fields('identificationtype'));
		$this->idnumber->setDbValue($rs->fields('idnumber'));
		$this->issuedate->setDbValue($rs->fields('issuedate'));
		$this->expirydate->setDbValue($rs->fields('expirydate'));
		$this->issueplace->setDbValue($rs->fields('issueplace'));
		$this->spousename->setDbValue($rs->fields('spousename'));
		$this->spouseemail->setDbValue($rs->fields('spouseemail'));
		$this->spousephone->setDbValue($rs->fields('spousephone'));
		$this->spousedob->setDbValue($rs->fields('spousedob'));
		$this->spouseaddr->setDbValue($rs->fields('spouseaddr'));
		$this->spousecity->setDbValue($rs->fields('spousecity'));
		$this->spousestate->setDbValue($rs->fields('spousestate'));
		$this->cityofmarriage->setDbValue($rs->fields('cityofmarriage'));
		$this->countryofmarriage->setDbValue($rs->fields('countryofmarriage'));
		$this->nextofkinfullname->setDbValue($rs->fields('nextofkinfullname'));
		$this->nextofkintelephone->setDbValue($rs->fields('nextofkintelephone'));
		$this->nextofkinemail->setDbValue($rs->fields('nextofkinemail'));
		$this->nextofkinaddress->setDbValue($rs->fields('nextofkinaddress'));
		$this->nameofcompany->setDbValue($rs->fields('nameofcompany'));
		$this->humanresourcescontacttelephone->setDbValue($rs->fields('humanresourcescontacttelephone'));
		$this->humanresourcescontactemailaddress->setDbValue($rs->fields('humanresourcescontactemailaddress'));
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
		$this->marriagetype->DbValue = $row['marriagetype'];
		$this->marriageyear->DbValue = $row['marriageyear'];
		$this->marriagecert->DbValue = $row['marriagecert'];
		$this->divorce->DbValue = $row['divorce'];
		$this->divorceyear->DbValue = $row['divorceyear'];
		$this->datecreated->DbValue = $row['datecreated'];
		$this->maidenname->DbValue = $row['maidenname'];
		$this->identificationtype->DbValue = $row['identificationtype'];
		$this->idnumber->DbValue = $row['idnumber'];
		$this->issuedate->DbValue = $row['issuedate'];
		$this->expirydate->DbValue = $row['expirydate'];
		$this->issueplace->DbValue = $row['issueplace'];
		$this->spousename->DbValue = $row['spousename'];
		$this->spouseemail->DbValue = $row['spouseemail'];
		$this->spousephone->DbValue = $row['spousephone'];
		$this->spousedob->DbValue = $row['spousedob'];
		$this->spouseaddr->DbValue = $row['spouseaddr'];
		$this->spousecity->DbValue = $row['spousecity'];
		$this->spousestate->DbValue = $row['spousestate'];
		$this->cityofmarriage->DbValue = $row['cityofmarriage'];
		$this->countryofmarriage->DbValue = $row['countryofmarriage'];
		$this->nextofkinfullname->DbValue = $row['nextofkinfullname'];
		$this->nextofkintelephone->DbValue = $row['nextofkintelephone'];
		$this->nextofkinemail->DbValue = $row['nextofkinemail'];
		$this->nextofkinaddress->DbValue = $row['nextofkinaddress'];
		$this->nameofcompany->DbValue = $row['nameofcompany'];
		$this->humanresourcescontacttelephone->DbValue = $row['humanresourcescontacttelephone'];
		$this->humanresourcescontactemailaddress->DbValue = $row['humanresourcescontactemailaddress'];
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
		// marriagetype
		// marriageyear
		// marriagecert
		// divorce
		// divorceyear
		// datecreated
		// maidenname
		// identificationtype
		// idnumber
		// issuedate
		// expirydate
		// issueplace
		// spousename
		// spouseemail
		// spousephone
		// spousedob
		// spouseaddr
		// spousecity
		// spousestate
		// cityofmarriage
		// countryofmarriage
		// nextofkinfullname
		// nextofkintelephone
		// nextofkinemail
		// nextofkinaddress
		// nameofcompany
		// humanresourcescontacttelephone
		// humanresourcescontactemailaddress

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

			// marriagetype
			$this->marriagetype->ViewValue = $this->marriagetype->CurrentValue;
			$this->marriagetype->ViewCustomAttributes = "";

			// marriageyear
			$this->marriageyear->ViewValue = $this->marriageyear->CurrentValue;
			$this->marriageyear->ViewCustomAttributes = "";

			// marriagecert
			$this->marriagecert->ViewValue = $this->marriagecert->CurrentValue;
			$this->marriagecert->ViewCustomAttributes = "";

			// divorce
			$this->divorce->ViewValue = $this->divorce->CurrentValue;
			$this->divorce->ViewCustomAttributes = "";

			// divorceyear
			$this->divorceyear->ViewValue = $this->divorceyear->CurrentValue;
			$this->divorceyear->ViewCustomAttributes = "";

			// datecreated
			$this->datecreated->ViewValue = $this->datecreated->CurrentValue;
			$this->datecreated->ViewCustomAttributes = "";

			// maidenname
			$this->maidenname->ViewValue = $this->maidenname->CurrentValue;
			$this->maidenname->ViewCustomAttributes = "";

			// identificationtype
			$this->identificationtype->ViewValue = $this->identificationtype->CurrentValue;
			$this->identificationtype->ViewCustomAttributes = "";

			// idnumber
			$this->idnumber->ViewValue = $this->idnumber->CurrentValue;
			$this->idnumber->ViewCustomAttributes = "";

			// issuedate
			$this->issuedate->ViewValue = $this->issuedate->CurrentValue;
			$this->issuedate->ViewCustomAttributes = "";

			// expirydate
			$this->expirydate->ViewValue = $this->expirydate->CurrentValue;
			$this->expirydate->ViewCustomAttributes = "";

			// issueplace
			$this->issueplace->ViewValue = $this->issueplace->CurrentValue;
			$this->issueplace->ViewCustomAttributes = "";

			// spousename
			$this->spousename->ViewValue = $this->spousename->CurrentValue;
			$this->spousename->ViewCustomAttributes = "";

			// spouseemail
			$this->spouseemail->ViewValue = $this->spouseemail->CurrentValue;
			$this->spouseemail->ViewCustomAttributes = "";

			// spousephone
			$this->spousephone->ViewValue = $this->spousephone->CurrentValue;
			$this->spousephone->ViewCustomAttributes = "";

			// spousedob
			$this->spousedob->ViewValue = $this->spousedob->CurrentValue;
			$this->spousedob->ViewCustomAttributes = "";

			// spouseaddr
			$this->spouseaddr->ViewValue = $this->spouseaddr->CurrentValue;
			$this->spouseaddr->ViewCustomAttributes = "";

			// spousecity
			$this->spousecity->ViewValue = $this->spousecity->CurrentValue;
			$this->spousecity->ViewCustomAttributes = "";

			// spousestate
			$this->spousestate->ViewValue = $this->spousestate->CurrentValue;
			$this->spousestate->ViewCustomAttributes = "";

			// cityofmarriage
			$this->cityofmarriage->ViewValue = $this->cityofmarriage->CurrentValue;
			$this->cityofmarriage->ViewCustomAttributes = "";

			// countryofmarriage
			$this->countryofmarriage->ViewValue = $this->countryofmarriage->CurrentValue;
			$this->countryofmarriage->ViewCustomAttributes = "";

			// nextofkinfullname
			$this->nextofkinfullname->ViewValue = $this->nextofkinfullname->CurrentValue;
			$this->nextofkinfullname->ViewCustomAttributes = "";

			// nextofkintelephone
			$this->nextofkintelephone->ViewValue = $this->nextofkintelephone->CurrentValue;
			$this->nextofkintelephone->ViewCustomAttributes = "";

			// nextofkinemail
			$this->nextofkinemail->ViewValue = $this->nextofkinemail->CurrentValue;
			$this->nextofkinemail->ViewCustomAttributes = "";

			// nextofkinaddress
			$this->nextofkinaddress->ViewValue = $this->nextofkinaddress->CurrentValue;
			$this->nextofkinaddress->ViewCustomAttributes = "";

			// nameofcompany
			$this->nameofcompany->ViewValue = $this->nameofcompany->CurrentValue;
			$this->nameofcompany->ViewCustomAttributes = "";

			// humanresourcescontacttelephone
			$this->humanresourcescontacttelephone->ViewValue = $this->humanresourcescontacttelephone->CurrentValue;
			$this->humanresourcescontacttelephone->ViewCustomAttributes = "";

			// humanresourcescontactemailaddress
			$this->humanresourcescontactemailaddress->ViewValue = $this->humanresourcescontactemailaddress->CurrentValue;
			$this->humanresourcescontactemailaddress->ViewCustomAttributes = "";

			// fullname
			$this->fullname->LinkCustomAttributes = "";
			$this->fullname->HrefValue = "";
			$this->fullname->TooltipValue = "";

			// email
			$this->_email->LinkCustomAttributes = "";
			$this->_email->HrefValue = "";
			$this->_email->TooltipValue = "";

			// phoneno
			$this->phoneno->LinkCustomAttributes = "";
			$this->phoneno->HrefValue = "";
			$this->phoneno->TooltipValue = "";

			// gender
			$this->gender->LinkCustomAttributes = "";
			$this->gender->HrefValue = "";
			$this->gender->TooltipValue = "";

			// dob
			$this->dob->LinkCustomAttributes = "";
			$this->dob->HrefValue = "";
			$this->dob->TooltipValue = "";

			// employmentstatus
			$this->employmentstatus->LinkCustomAttributes = "";
			$this->employmentstatus->HrefValue = "";
			$this->employmentstatus->TooltipValue = "";

			// maritalstatus
			$this->maritalstatus->LinkCustomAttributes = "";
			$this->maritalstatus->HrefValue = "";
			$this->maritalstatus->TooltipValue = "";

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
		$item->Body = "<a id=\"emf_reservetrust_tb\" href=\"javascript:void(0);\" class=\"ewExportLink ewEmail\" data-caption=\"" . $Language->Phrase("ExportToEmailText") . "\" onclick=\"ew_EmailDialogShow({lnk:'emf_reservetrust_tb',hdr:ewLanguage.Phrase('ExportToEmail'),f:document.freservetrust_tblist,sel:false});\">" . $Language->Phrase("ExportToEmail") . "</a>";
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
if (!isset($reservetrust_tb_list)) $reservetrust_tb_list = new creservetrust_tb_list();

// Page init
$reservetrust_tb_list->Page_Init();

// Page main
$reservetrust_tb_list->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$reservetrust_tb_list->Page_Render();
?>
<?php include_once "header.php" ?>
<?php if ($reservetrust_tb->Export == "") { ?>
<script type="text/javascript">

// Page object
var reservetrust_tb_list = new ew_Page("reservetrust_tb_list");
reservetrust_tb_list.PageID = "list"; // Page ID
var EW_PAGE_ID = reservetrust_tb_list.PageID; // For backward compatibility

// Form object
var freservetrust_tblist = new ew_Form("freservetrust_tblist");
freservetrust_tblist.FormKeyCountName = '<?php echo $reservetrust_tb_list->FormKeyCountName ?>';

// Form_CustomValidate event
freservetrust_tblist.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
freservetrust_tblist.ValidateRequired = true;
<?php } else { ?>
freservetrust_tblist.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
// Form object for search

var freservetrust_tblistsrch = new ew_Form("freservetrust_tblistsrch");
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
<?php if ($reservetrust_tb->Export == "") { ?>
<?php $Breadcrumb->Render(); ?>
<?php } ?>
<?php if ($reservetrust_tb_list->ExportOptions->Visible()) { ?>
<div class="ewListExportOptions"><?php $reservetrust_tb_list->ExportOptions->Render("body") ?></div>
<?php } ?>
<?php
	$bSelectLimit = EW_SELECT_LIMIT;
	if ($bSelectLimit) {
		$reservetrust_tb_list->TotalRecs = $reservetrust_tb->SelectRecordCount();
	} else {
		if ($reservetrust_tb_list->Recordset = $reservetrust_tb_list->LoadRecordset())
			$reservetrust_tb_list->TotalRecs = $reservetrust_tb_list->Recordset->RecordCount();
	}
	$reservetrust_tb_list->StartRec = 1;
	if ($reservetrust_tb_list->DisplayRecs <= 0 || ($reservetrust_tb->Export <> "" && $reservetrust_tb->ExportAll)) // Display all records
		$reservetrust_tb_list->DisplayRecs = $reservetrust_tb_list->TotalRecs;
	if (!($reservetrust_tb->Export <> "" && $reservetrust_tb->ExportAll))
		$reservetrust_tb_list->SetUpStartRec(); // Set up start record position
	if ($bSelectLimit)
		$reservetrust_tb_list->Recordset = $reservetrust_tb_list->LoadRecordset($reservetrust_tb_list->StartRec-1, $reservetrust_tb_list->DisplayRecs);
$reservetrust_tb_list->RenderOtherOptions();
?>
<?php if ($Security->IsLoggedIn()) { ?>
<?php if ($reservetrust_tb->Export == "" && $reservetrust_tb->CurrentAction == "") { ?>
<form name="freservetrust_tblistsrch" id="freservetrust_tblistsrch" class="ewForm form-inline" action="<?php echo ew_CurrentPage() ?>">
<table class="ewSearchTable"><tr><td>
<div class="accordion" id="freservetrust_tblistsrch_SearchGroup">
	<div class="accordion-group">
		<div class="accordion-heading">
<a class="accordion-toggle" data-toggle="collapse" data-parent="#freservetrust_tblistsrch_SearchGroup" href="#freservetrust_tblistsrch_SearchBody"><?php echo $Language->Phrase("Search") ?></a>
		</div>
		<div id="freservetrust_tblistsrch_SearchBody" class="accordion-body collapse in">
			<div class="accordion-inner">
<div id="freservetrust_tblistsrch_SearchPanel">
<input type="hidden" name="cmd" value="search">
<input type="hidden" name="t" value="reservetrust_tb">
<div class="ewBasicSearch">
<div id="xsr_1" class="ewRow">
	<div class="btn-group ewButtonGroup">
	<div class="input-append">
	<input type="text" name="<?php echo EW_TABLE_BASIC_SEARCH ?>" id="<?php echo EW_TABLE_BASIC_SEARCH ?>" class="input-large" value="<?php echo ew_HtmlEncode($reservetrust_tb_list->BasicSearch->getKeyword()) ?>" placeholder="<?php echo $Language->Phrase("Search") ?>">
	<button class="btn btn-primary ewButton" name="btnsubmit" id="btnsubmit" type="submit"><?php echo $Language->Phrase("QuickSearchBtn") ?></button>
	</div>
	</div>
	<div class="btn-group ewButtonGroup">
	<a class="btn ewShowAll" href="<?php echo $reservetrust_tb_list->PageUrl() ?>cmd=reset"><?php echo $Language->Phrase("ShowAll") ?></a>
</div>
<div id="xsr_2" class="ewRow">
	<label class="inline radio ewRadio" style="white-space: nowrap;"><input type="radio" name="<?php echo EW_TABLE_BASIC_SEARCH_TYPE ?>" value="="<?php if ($reservetrust_tb_list->BasicSearch->getType() == "=") { ?> checked="checked"<?php } ?>><?php echo $Language->Phrase("ExactPhrase") ?></label>
	<label class="inline radio ewRadio" style="white-space: nowrap;"><input type="radio" name="<?php echo EW_TABLE_BASIC_SEARCH_TYPE ?>" value="AND"<?php if ($reservetrust_tb_list->BasicSearch->getType() == "AND") { ?> checked="checked"<?php } ?>><?php echo $Language->Phrase("AllWord") ?></label>
	<label class="inline radio ewRadio" style="white-space: nowrap;"><input type="radio" name="<?php echo EW_TABLE_BASIC_SEARCH_TYPE ?>" value="OR"<?php if ($reservetrust_tb_list->BasicSearch->getType() == "OR") { ?> checked="checked"<?php } ?>><?php echo $Language->Phrase("AnyWord") ?></label>
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
<?php $reservetrust_tb_list->ShowPageHeader(); ?>
<?php
$reservetrust_tb_list->ShowMessage();
?>
<table cellspacing="0" class="ewGrid"><tr><td class="ewGridContent">
<form name="freservetrust_tblist" id="freservetrust_tblist" class="ewForm form-horizontal" action="<?php echo ew_CurrentPage() ?>" method="post">
<input type="hidden" name="t" value="reservetrust_tb">
<div id="gmp_reservetrust_tb" class="ewGridMiddlePanel">
<?php if ($reservetrust_tb_list->TotalRecs > 0) { ?>
<table id="tbl_reservetrust_tblist" class="ewTable ewTableSeparate">
<?php echo $reservetrust_tb->TableCustomInnerHtml ?>
<thead><!-- Table header -->
	<tr class="ewTableHeader">
<?php

// Render list options
$reservetrust_tb_list->RenderListOptions();

// Render list options (header, left)
$reservetrust_tb_list->ListOptions->Render("header", "left");
?>
<?php if ($reservetrust_tb->fullname->Visible) { // fullname ?>
	<?php if ($reservetrust_tb->SortUrl($reservetrust_tb->fullname) == "") { ?>
		<td><div id="elh_reservetrust_tb_fullname" class="reservetrust_tb_fullname"><div class="ewTableHeaderCaption"><?php echo $reservetrust_tb->fullname->FldCaption() ?></div></div></td>
	<?php } else { ?>
		<td><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $reservetrust_tb->SortUrl($reservetrust_tb->fullname) ?>',2);"><div id="elh_reservetrust_tb_fullname" class="reservetrust_tb_fullname">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $reservetrust_tb->fullname->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($reservetrust_tb->fullname->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($reservetrust_tb->fullname->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></td>
	<?php } ?>
<?php } ?>		
<?php if ($reservetrust_tb->_email->Visible) { // email ?>
	<?php if ($reservetrust_tb->SortUrl($reservetrust_tb->_email) == "") { ?>
		<td><div id="elh_reservetrust_tb__email" class="reservetrust_tb__email"><div class="ewTableHeaderCaption"><?php echo $reservetrust_tb->_email->FldCaption() ?></div></div></td>
	<?php } else { ?>
		<td><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $reservetrust_tb->SortUrl($reservetrust_tb->_email) ?>',2);"><div id="elh_reservetrust_tb__email" class="reservetrust_tb__email">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $reservetrust_tb->_email->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($reservetrust_tb->_email->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($reservetrust_tb->_email->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></td>
	<?php } ?>
<?php } ?>		
<?php if ($reservetrust_tb->phoneno->Visible) { // phoneno ?>
	<?php if ($reservetrust_tb->SortUrl($reservetrust_tb->phoneno) == "") { ?>
		<td><div id="elh_reservetrust_tb_phoneno" class="reservetrust_tb_phoneno"><div class="ewTableHeaderCaption"><?php echo $reservetrust_tb->phoneno->FldCaption() ?></div></div></td>
	<?php } else { ?>
		<td><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $reservetrust_tb->SortUrl($reservetrust_tb->phoneno) ?>',2);"><div id="elh_reservetrust_tb_phoneno" class="reservetrust_tb_phoneno">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $reservetrust_tb->phoneno->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($reservetrust_tb->phoneno->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($reservetrust_tb->phoneno->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></td>
	<?php } ?>
<?php } ?>		
<?php if ($reservetrust_tb->gender->Visible) { // gender ?>
	<?php if ($reservetrust_tb->SortUrl($reservetrust_tb->gender) == "") { ?>
		<td><div id="elh_reservetrust_tb_gender" class="reservetrust_tb_gender"><div class="ewTableHeaderCaption"><?php echo $reservetrust_tb->gender->FldCaption() ?></div></div></td>
	<?php } else { ?>
		<td><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $reservetrust_tb->SortUrl($reservetrust_tb->gender) ?>',2);"><div id="elh_reservetrust_tb_gender" class="reservetrust_tb_gender">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $reservetrust_tb->gender->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($reservetrust_tb->gender->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($reservetrust_tb->gender->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></td>
	<?php } ?>
<?php } ?>		
<?php if ($reservetrust_tb->dob->Visible) { // dob ?>
	<?php if ($reservetrust_tb->SortUrl($reservetrust_tb->dob) == "") { ?>
		<td><div id="elh_reservetrust_tb_dob" class="reservetrust_tb_dob"><div class="ewTableHeaderCaption"><?php echo $reservetrust_tb->dob->FldCaption() ?></div></div></td>
	<?php } else { ?>
		<td><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $reservetrust_tb->SortUrl($reservetrust_tb->dob) ?>',2);"><div id="elh_reservetrust_tb_dob" class="reservetrust_tb_dob">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $reservetrust_tb->dob->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($reservetrust_tb->dob->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($reservetrust_tb->dob->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></td>
	<?php } ?>
<?php } ?>		
<?php if ($reservetrust_tb->employmentstatus->Visible) { // employmentstatus ?>
	<?php if ($reservetrust_tb->SortUrl($reservetrust_tb->employmentstatus) == "") { ?>
		<td><div id="elh_reservetrust_tb_employmentstatus" class="reservetrust_tb_employmentstatus"><div class="ewTableHeaderCaption"><?php echo $reservetrust_tb->employmentstatus->FldCaption() ?></div></div></td>
	<?php } else { ?>
		<td><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $reservetrust_tb->SortUrl($reservetrust_tb->employmentstatus) ?>',2);"><div id="elh_reservetrust_tb_employmentstatus" class="reservetrust_tb_employmentstatus">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $reservetrust_tb->employmentstatus->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($reservetrust_tb->employmentstatus->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($reservetrust_tb->employmentstatus->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></td>
	<?php } ?>
<?php } ?>		
<?php if ($reservetrust_tb->maritalstatus->Visible) { // maritalstatus ?>
	<?php if ($reservetrust_tb->SortUrl($reservetrust_tb->maritalstatus) == "") { ?>
		<td><div id="elh_reservetrust_tb_maritalstatus" class="reservetrust_tb_maritalstatus"><div class="ewTableHeaderCaption"><?php echo $reservetrust_tb->maritalstatus->FldCaption() ?></div></div></td>
	<?php } else { ?>
		<td><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $reservetrust_tb->SortUrl($reservetrust_tb->maritalstatus) ?>',2);"><div id="elh_reservetrust_tb_maritalstatus" class="reservetrust_tb_maritalstatus">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $reservetrust_tb->maritalstatus->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($reservetrust_tb->maritalstatus->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($reservetrust_tb->maritalstatus->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></td>
	<?php } ?>
<?php } ?>		
<?php if ($reservetrust_tb->datecreated->Visible) { // datecreated ?>
	<?php if ($reservetrust_tb->SortUrl($reservetrust_tb->datecreated) == "") { ?>
		<td><div id="elh_reservetrust_tb_datecreated" class="reservetrust_tb_datecreated"><div class="ewTableHeaderCaption"><?php echo $reservetrust_tb->datecreated->FldCaption() ?></div></div></td>
	<?php } else { ?>
		<td><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $reservetrust_tb->SortUrl($reservetrust_tb->datecreated) ?>',2);"><div id="elh_reservetrust_tb_datecreated" class="reservetrust_tb_datecreated">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $reservetrust_tb->datecreated->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($reservetrust_tb->datecreated->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($reservetrust_tb->datecreated->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></td>
	<?php } ?>
<?php } ?>		
<?php

// Render list options (header, right)
$reservetrust_tb_list->ListOptions->Render("header", "right");
?>
	</tr>
</thead>
<tbody>
<?php
if ($reservetrust_tb->ExportAll && $reservetrust_tb->Export <> "") {
	$reservetrust_tb_list->StopRec = $reservetrust_tb_list->TotalRecs;
} else {

	// Set the last record to display
	if ($reservetrust_tb_list->TotalRecs > $reservetrust_tb_list->StartRec + $reservetrust_tb_list->DisplayRecs - 1)
		$reservetrust_tb_list->StopRec = $reservetrust_tb_list->StartRec + $reservetrust_tb_list->DisplayRecs - 1;
	else
		$reservetrust_tb_list->StopRec = $reservetrust_tb_list->TotalRecs;
}
$reservetrust_tb_list->RecCnt = $reservetrust_tb_list->StartRec - 1;
if ($reservetrust_tb_list->Recordset && !$reservetrust_tb_list->Recordset->EOF) {
	$reservetrust_tb_list->Recordset->MoveFirst();
	if (!$bSelectLimit && $reservetrust_tb_list->StartRec > 1)
		$reservetrust_tb_list->Recordset->Move($reservetrust_tb_list->StartRec - 1);
} elseif (!$reservetrust_tb->AllowAddDeleteRow && $reservetrust_tb_list->StopRec == 0) {
	$reservetrust_tb_list->StopRec = $reservetrust_tb->GridAddRowCount;
}

// Initialize aggregate
$reservetrust_tb->RowType = EW_ROWTYPE_AGGREGATEINIT;
$reservetrust_tb->ResetAttrs();
$reservetrust_tb_list->RenderRow();
while ($reservetrust_tb_list->RecCnt < $reservetrust_tb_list->StopRec) {
	$reservetrust_tb_list->RecCnt++;
	if (intval($reservetrust_tb_list->RecCnt) >= intval($reservetrust_tb_list->StartRec)) {
		$reservetrust_tb_list->RowCnt++;

		// Set up key count
		$reservetrust_tb_list->KeyCount = $reservetrust_tb_list->RowIndex;

		// Init row class and style
		$reservetrust_tb->ResetAttrs();
		$reservetrust_tb->CssClass = "";
		if ($reservetrust_tb->CurrentAction == "gridadd") {
		} else {
			$reservetrust_tb_list->LoadRowValues($reservetrust_tb_list->Recordset); // Load row values
		}
		$reservetrust_tb->RowType = EW_ROWTYPE_VIEW; // Render view

		// Set up row id / data-rowindex
		$reservetrust_tb->RowAttrs = array_merge($reservetrust_tb->RowAttrs, array('data-rowindex'=>$reservetrust_tb_list->RowCnt, 'id'=>'r' . $reservetrust_tb_list->RowCnt . '_reservetrust_tb', 'data-rowtype'=>$reservetrust_tb->RowType));

		// Render row
		$reservetrust_tb_list->RenderRow();

		// Render list options
		$reservetrust_tb_list->RenderListOptions();
?>
	<tr<?php echo $reservetrust_tb->RowAttributes() ?>>
<?php

// Render list options (body, left)
$reservetrust_tb_list->ListOptions->Render("body", "left", $reservetrust_tb_list->RowCnt);
?>
	<?php if ($reservetrust_tb->fullname->Visible) { // fullname ?>
		<td<?php echo $reservetrust_tb->fullname->CellAttributes() ?>>
<span<?php echo $reservetrust_tb->fullname->ViewAttributes() ?>>
<?php echo $reservetrust_tb->fullname->ListViewValue() ?></span>
<a id="<?php echo $reservetrust_tb_list->PageObjName . "_row_" . $reservetrust_tb_list->RowCnt ?>"></a></td>
	<?php } ?>
	<?php if ($reservetrust_tb->_email->Visible) { // email ?>
		<td<?php echo $reservetrust_tb->_email->CellAttributes() ?>>
<span<?php echo $reservetrust_tb->_email->ViewAttributes() ?>>
<?php echo $reservetrust_tb->_email->ListViewValue() ?></span>
<a id="<?php echo $reservetrust_tb_list->PageObjName . "_row_" . $reservetrust_tb_list->RowCnt ?>"></a></td>
	<?php } ?>
	<?php if ($reservetrust_tb->phoneno->Visible) { // phoneno ?>
		<td<?php echo $reservetrust_tb->phoneno->CellAttributes() ?>>
<span<?php echo $reservetrust_tb->phoneno->ViewAttributes() ?>>
<?php echo $reservetrust_tb->phoneno->ListViewValue() ?></span>
<a id="<?php echo $reservetrust_tb_list->PageObjName . "_row_" . $reservetrust_tb_list->RowCnt ?>"></a></td>
	<?php } ?>
	<?php if ($reservetrust_tb->gender->Visible) { // gender ?>
		<td<?php echo $reservetrust_tb->gender->CellAttributes() ?>>
<span<?php echo $reservetrust_tb->gender->ViewAttributes() ?>>
<?php echo $reservetrust_tb->gender->ListViewValue() ?></span>
<a id="<?php echo $reservetrust_tb_list->PageObjName . "_row_" . $reservetrust_tb_list->RowCnt ?>"></a></td>
	<?php } ?>
	<?php if ($reservetrust_tb->dob->Visible) { // dob ?>
		<td<?php echo $reservetrust_tb->dob->CellAttributes() ?>>
<span<?php echo $reservetrust_tb->dob->ViewAttributes() ?>>
<?php echo $reservetrust_tb->dob->ListViewValue() ?></span>
<a id="<?php echo $reservetrust_tb_list->PageObjName . "_row_" . $reservetrust_tb_list->RowCnt ?>"></a></td>
	<?php } ?>
	<?php if ($reservetrust_tb->employmentstatus->Visible) { // employmentstatus ?>
		<td<?php echo $reservetrust_tb->employmentstatus->CellAttributes() ?>>
<span<?php echo $reservetrust_tb->employmentstatus->ViewAttributes() ?>>
<?php echo $reservetrust_tb->employmentstatus->ListViewValue() ?></span>
<a id="<?php echo $reservetrust_tb_list->PageObjName . "_row_" . $reservetrust_tb_list->RowCnt ?>"></a></td>
	<?php } ?>
	<?php if ($reservetrust_tb->maritalstatus->Visible) { // maritalstatus ?>
		<td<?php echo $reservetrust_tb->maritalstatus->CellAttributes() ?>>
<span<?php echo $reservetrust_tb->maritalstatus->ViewAttributes() ?>>
<?php echo $reservetrust_tb->maritalstatus->ListViewValue() ?></span>
<a id="<?php echo $reservetrust_tb_list->PageObjName . "_row_" . $reservetrust_tb_list->RowCnt ?>"></a></td>
	<?php } ?>
	<?php if ($reservetrust_tb->datecreated->Visible) { // datecreated ?>
		<td<?php echo $reservetrust_tb->datecreated->CellAttributes() ?>>
<span<?php echo $reservetrust_tb->datecreated->ViewAttributes() ?>>
<?php echo $reservetrust_tb->datecreated->ListViewValue() ?></span>
<a id="<?php echo $reservetrust_tb_list->PageObjName . "_row_" . $reservetrust_tb_list->RowCnt ?>"></a></td>
	<?php } ?>
<?php

// Render list options (body, right)
$reservetrust_tb_list->ListOptions->Render("body", "right", $reservetrust_tb_list->RowCnt);
?>
	</tr>
<?php
	}
	if ($reservetrust_tb->CurrentAction <> "gridadd")
		$reservetrust_tb_list->Recordset->MoveNext();
}
?>
</tbody>
</table>
<?php } ?>
<?php if ($reservetrust_tb->CurrentAction == "") { ?>
<input type="hidden" name="a_list" id="a_list" value="">
<?php } ?>
</div>
</form>
<?php

// Close recordset
if ($reservetrust_tb_list->Recordset)
	$reservetrust_tb_list->Recordset->Close();
?>
<?php if ($reservetrust_tb->Export == "") { ?>
<div class="ewGridLowerPanel">
<?php if ($reservetrust_tb->CurrentAction <> "gridadd" && $reservetrust_tb->CurrentAction <> "gridedit") { ?>
<form name="ewPagerForm" class="ewForm form-horizontal" action="<?php echo ew_CurrentPage() ?>">
<table class="ewPager">
<tr><td>
<?php if (!isset($reservetrust_tb_list->Pager)) $reservetrust_tb_list->Pager = new cNumericPager($reservetrust_tb_list->StartRec, $reservetrust_tb_list->DisplayRecs, $reservetrust_tb_list->TotalRecs, $reservetrust_tb_list->RecRange) ?>
<?php if ($reservetrust_tb_list->Pager->RecordCount > 0) { ?>
<table cellspacing="0" class="ewStdTable"><tbody><tr><td>
<div class="pagination"><ul>
	<?php if ($reservetrust_tb_list->Pager->FirstButton->Enabled) { ?>
	<li><a href="<?php echo $reservetrust_tb_list->PageUrl() ?>start=<?php echo $reservetrust_tb_list->Pager->FirstButton->Start ?>"><?php echo $Language->Phrase("PagerFirst") ?></a></li>
	<?php } ?>
	<?php if ($reservetrust_tb_list->Pager->PrevButton->Enabled) { ?>
	<li><a href="<?php echo $reservetrust_tb_list->PageUrl() ?>start=<?php echo $reservetrust_tb_list->Pager->PrevButton->Start ?>"><?php echo $Language->Phrase("PagerPrevious") ?></a></li>
	<?php } ?>
	<?php foreach ($reservetrust_tb_list->Pager->Items as $PagerItem) { ?>
		<li<?php if (!$PagerItem->Enabled) { echo " class=\" active\""; } ?>><a href="<?php if ($PagerItem->Enabled) { echo $reservetrust_tb_list->PageUrl() . "start=" . $PagerItem->Start; } else { echo "#"; } ?>"><?php echo $PagerItem->Text ?></a></li>
	<?php } ?>
	<?php if ($reservetrust_tb_list->Pager->NextButton->Enabled) { ?>
	<li><a href="<?php echo $reservetrust_tb_list->PageUrl() ?>start=<?php echo $reservetrust_tb_list->Pager->NextButton->Start ?>"><?php echo $Language->Phrase("PagerNext") ?></a></li>
	<?php } ?>
	<?php if ($reservetrust_tb_list->Pager->LastButton->Enabled) { ?>
	<li><a href="<?php echo $reservetrust_tb_list->PageUrl() ?>start=<?php echo $reservetrust_tb_list->Pager->LastButton->Start ?>"><?php echo $Language->Phrase("PagerLast") ?></a></li>
	<?php } ?>
</ul></div>
</td>
<td>
	<?php if ($reservetrust_tb_list->Pager->ButtonCount > 0) { ?>&nbsp;&nbsp;&nbsp;&nbsp;<?php } ?>
	<?php echo $Language->Phrase("Record") ?>&nbsp;<?php echo $reservetrust_tb_list->Pager->FromIndex ?>&nbsp;<?php echo $Language->Phrase("To") ?>&nbsp;<?php echo $reservetrust_tb_list->Pager->ToIndex ?>&nbsp;<?php echo $Language->Phrase("Of") ?>&nbsp;<?php echo $reservetrust_tb_list->Pager->RecordCount ?>
</td>
</tr></tbody></table>
<?php } else { ?>
	<?php if ($reservetrust_tb_list->SearchWhere == "0=101") { ?>
	<p><?php echo $Language->Phrase("EnterSearchCriteria") ?></p>
	<?php } else { ?>
	<p><?php echo $Language->Phrase("NoRecord") ?></p>
	<?php } ?>
<?php } ?>
</td>
<?php if ($reservetrust_tb_list->TotalRecs > 0) { ?>
<td>
	&nbsp;&nbsp;&nbsp;&nbsp;
<input type="hidden" name="t" value="reservetrust_tb">
<select name="<?php echo EW_TABLE_REC_PER_PAGE ?>" class="input-small" onchange="this.form.submit();">
<option value="25"<?php if ($reservetrust_tb_list->DisplayRecs == 25) { ?> selected="selected"<?php } ?>>25</option>
<option value="50"<?php if ($reservetrust_tb_list->DisplayRecs == 50) { ?> selected="selected"<?php } ?>>50</option>
<option value="100"<?php if ($reservetrust_tb_list->DisplayRecs == 100) { ?> selected="selected"<?php } ?>>100</option>
<option value="200"<?php if ($reservetrust_tb_list->DisplayRecs == 200) { ?> selected="selected"<?php } ?>>200</option>
<option value="500"<?php if ($reservetrust_tb_list->DisplayRecs == 500) { ?> selected="selected"<?php } ?>>500</option>
<option value="ALL"<?php if ($reservetrust_tb->getRecordsPerPage() == -1) { ?> selected="selected"<?php } ?>><?php echo $Language->Phrase("AllRecords") ?></option>
</select>
</td>
<?php } ?>
</tr></table>
</form>
<?php } ?>
<div class="ewListOtherOptions">
<?php
	foreach ($reservetrust_tb_list->OtherOptions as &$option)
		$option->Render("body", "bottom");
?>
</div>
</div>
<?php } ?>
</td></tr></table>
<?php if ($reservetrust_tb->Export == "") { ?>
<script type="text/javascript">
freservetrust_tblistsrch.Init();
freservetrust_tblist.Init();
<?php if (EW_MOBILE_REFLOW && ew_IsMobile()) { ?>
ew_Reflow();
<?php } ?>
</script>
<?php } ?>
<?php
$reservetrust_tb_list->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<?php if ($reservetrust_tb->Export == "") { ?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php } ?>
<?php include_once "footer.php" ?>
<?php
$reservetrust_tb_list->Page_Terminate();
?>
