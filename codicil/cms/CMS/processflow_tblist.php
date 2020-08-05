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

$processflow_tb_list = NULL; // Initialize page object first

class cprocessflow_tb_list extends cprocessflow_tb {

	// Page ID
	var $PageID = 'list';

	// Project ID
	var $ProjectID = "{D9B361E7-B2C1-4293-B9B3-B581986A15CC}";

	// Table name
	var $TableName = 'processflow_tb';

	// Page object name
	var $PageObjName = 'processflow_tb_list';

	// Grid form hidden field names
	var $FormName = 'fprocessflow_tblist';
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

		// Table object (processflow_tb)
		if (!isset($GLOBALS["processflow_tb"])) {
			$GLOBALS["processflow_tb"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["processflow_tb"];
		}

		// Initialize URLs
		$this->ExportPrintUrl = $this->PageUrl() . "export=print";
		$this->ExportExcelUrl = $this->PageUrl() . "export=excel";
		$this->ExportWordUrl = $this->PageUrl() . "export=word";
		$this->ExportHtmlUrl = $this->PageUrl() . "export=html";
		$this->ExportXmlUrl = $this->PageUrl() . "export=xml";
		$this->ExportCsvUrl = $this->PageUrl() . "export=csv";
		$this->ExportPdfUrl = $this->PageUrl() . "export=pdf";
		$this->AddUrl = "processflow_tbadd.php";
		$this->InlineAddUrl = $this->PageUrl() . "a=add";
		$this->GridAddUrl = $this->PageUrl() . "a=gridadd";
		$this->GridEditUrl = $this->PageUrl() . "a=gridedit";
		$this->MultiDeleteUrl = "processflow_tbdelete.php";
		$this->MultiUpdateUrl = "processflow_tbupdate.php";

		// Table object (adminusers)
		if (!isset($GLOBALS['adminusers'])) $GLOBALS['adminusers'] = new cadminusers();

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'list', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'processflow_tb', TRUE);

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

		// Create form object
		$objForm = new cFormObj();

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

			// Check QueryString parameters
			if (@$_GET["a"] <> "") {
				$this->CurrentAction = $_GET["a"];

				// Clear inline mode
				if ($this->CurrentAction == "cancel")
					$this->ClearInlineMode();

				// Switch to inline edit mode
				if ($this->CurrentAction == "edit")
					$this->InlineEditMode();
			} else {
				if (@$_POST["a_list"] <> "") {
					$this->CurrentAction = $_POST["a_list"]; // Get action

					// Inline Update
					if (($this->CurrentAction == "update" || $this->CurrentAction == "overwrite") && @$_SESSION[EW_SESSION_INLINE_MODE] == "edit")
						$this->InlineUpdate();
				}
			}

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

	//  Exit inline mode
	function ClearInlineMode() {
		$this->setKey("id", ""); // Clear inline edit key
		$this->LastAction = $this->CurrentAction; // Save last action
		$this->CurrentAction = ""; // Clear action
		$_SESSION[EW_SESSION_INLINE_MODE] = ""; // Clear inline mode
	}

	// Switch to Inline Edit mode
	function InlineEditMode() {
		global $Security, $Language;
		$bInlineEdit = TRUE;
		if (@$_GET["id"] <> "") {
			$this->id->setQueryStringValue($_GET["id"]);
		} else {
			$bInlineEdit = FALSE;
		}
		if ($bInlineEdit) {
			if ($this->LoadRow()) {
				$this->setKey("id", $this->id->CurrentValue); // Set up inline edit key
				$_SESSION[EW_SESSION_INLINE_MODE] = "edit"; // Enable inline edit
			}
		}
	}

	// Perform update to Inline Edit record
	function InlineUpdate() {
		global $Language, $objForm, $gsFormError;
		$objForm->Index = 1; 
		$this->LoadFormValues(); // Get form values

		// Validate form
		$bInlineUpdate = TRUE;
		if (!$this->ValidateForm()) {	
			$bInlineUpdate = FALSE; // Form error, reset action
			$this->setFailureMessage($gsFormError);
		} else {
			$bInlineUpdate = FALSE;
			$rowkey = strval($objForm->GetValue("k_key"));
			if ($this->SetupKeyValues($rowkey)) { // Set up key values
				if ($this->CheckInlineEditKey()) { // Check key
					$this->SendEmail = TRUE; // Send email on update success
					$bInlineUpdate = $this->EditRow(); // Update record
				} else {
					$bInlineUpdate = FALSE;
				}
			}
		}
		if ($bInlineUpdate) { // Update success
			if ($this->getSuccessMessage() == "")
				$this->setSuccessMessage($Language->Phrase("UpdateSuccess")); // Set up success message
			$this->ClearInlineMode(); // Clear inline edit mode
		} else {
			if ($this->getFailureMessage() == "")
				$this->setFailureMessage($Language->Phrase("UpdateFailed")); // Set update failed message
			$this->EventCancelled = TRUE; // Cancel event
			$this->CurrentAction = "edit"; // Stay in edit mode
		}
	}

	// Check Inline Edit key
	function CheckInlineEditKey() {

		//CheckInlineEditKey = True
		if (strval($this->getKey("id")) <> strval($this->id->CurrentValue))
			return FALSE;
		return TRUE;
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
		$this->BuildBasicSearchSQL($sWhere, $this->name, $Keyword);
		$this->BuildBasicSearchSQL($sWhere, $this->_email, $Keyword);
		$this->BuildBasicSearchSQL($sWhere, $this->progress, $Keyword);
		$this->BuildBasicSearchSQL($sWhere, $this->progress2, $Keyword);
		$this->BuildBasicSearchSQL($sWhere, $this->progress3, $Keyword);
		$this->BuildBasicSearchSQL($sWhere, $this->progress4, $Keyword);
		$this->BuildBasicSearchSQL($sWhere, $this->progress5, $Keyword);
		$this->BuildBasicSearchSQL($sWhere, $this->progress6, $Keyword);
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
			$this->UpdateSort($this->name, $bCtrl); // name
			$this->UpdateSort($this->_email, $bCtrl); // email
			$this->UpdateSort($this->progress, $bCtrl); // progress
			$this->UpdateSort($this->progress2, $bCtrl); // progress2
			$this->UpdateSort($this->progress3, $bCtrl); // progress3
			$this->UpdateSort($this->progress4, $bCtrl); // progress4
			$this->UpdateSort($this->progress5, $bCtrl); // progress5
			$this->UpdateSort($this->progress6, $bCtrl); // progress6
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
				$this->name->setSort("");
				$this->_email->setSort("");
				$this->progress->setSort("");
				$this->progress2->setSort("");
				$this->progress3->setSort("");
				$this->progress4->setSort("");
				$this->progress5->setSort("");
				$this->progress6->setSort("");
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

		// Set up row action and key
		if (is_numeric($this->RowIndex) && $this->CurrentMode <> "view") {
			$objForm->Index = $this->RowIndex;
			$ActionName = str_replace("k_", "k" . $this->RowIndex . "_", $this->FormActionName);
			$OldKeyName = str_replace("k_", "k" . $this->RowIndex . "_", $this->FormOldKeyName);
			$KeyName = str_replace("k_", "k" . $this->RowIndex . "_", $this->FormKeyName);
			$BlankRowName = str_replace("k_", "k" . $this->RowIndex . "_", $this->FormBlankRowName);
			if ($this->RowAction <> "")
				$this->MultiSelectKey .= "<input type=\"hidden\" name=\"" . $ActionName . "\" id=\"" . $ActionName . "\" value=\"" . $this->RowAction . "\">";
			if ($this->RowAction == "delete") {
				$rowkey = $objForm->GetValue($this->FormKeyName);
				$this->SetupKeyValues($rowkey);
			}
			if ($this->RowAction == "insert" && $this->CurrentAction == "F" && $this->EmptyRow())
				$this->MultiSelectKey .= "<input type=\"hidden\" name=\"" . $BlankRowName . "\" id=\"" . $BlankRowName . "\" value=\"1\">";
		}

		// "sequence"
		$oListOpt = &$this->ListOptions->Items["sequence"];
		$oListOpt->Body = ew_FormatSeqNo($this->RecCnt);

		// "edit"
		$oListOpt = &$this->ListOptions->Items["edit"];
		if ($this->CurrentAction == "edit" && $this->RowType == EW_ROWTYPE_EDIT) { // Inline-Edit
			$this->ListOptions->CustomItem = "edit"; // Show edit column only
				$oListOpt->Body = "<div" . (($oListOpt->OnLeft) ? " style=\"text-align: right\"" : "") . ">" .
					"<a class=\"ewGridLink ewInlineUpdate\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("UpdateLink")) . "\" href=\"\" onclick=\"return ewForms(this).Submit('" . ew_GetHashUrl($this->PageName(), $this->PageObjName . "_row_" . $this->RowCnt) . "');\">" . $Language->Phrase("UpdateLink") . "</a>&nbsp;" .
					"<a class=\"ewGridLink ewInlineCancel\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("CancelLink")) . "\" href=\"" . $this->PageUrl() . "a=cancel\">" . $Language->Phrase("CancelLink") . "</a>" .
					"<input type=\"hidden\" name=\"a_list\" id=\"a_list\" value=\"update\"></div>";
			$oListOpt->Body .= "<input type=\"hidden\" name=\"k" . $this->RowIndex . "_key\" id=\"k" . $this->RowIndex . "_key\" value=\"" . ew_HtmlEncode($this->id->CurrentValue) . "\">";
			return;
		}

		// "view"
		$oListOpt = &$this->ListOptions->Items["view"];
		if ($Security->IsLoggedIn())
			$oListOpt->Body = "<a class=\"ewRowLink ewView\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("ViewLink")) . "\" href=\"" . ew_HtmlEncode($this->ViewUrl) . "\">" . $Language->Phrase("ViewLink") . "</a>";
		else
			$oListOpt->Body = "";

		// "edit"
		$oListOpt = &$this->ListOptions->Items["edit"];
		if ($Security->IsLoggedIn()) {
			$oListOpt->Body .= "<a class=\"ewRowLink ewInlineEdit\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("InlineEditLink")) . "\" href=\"" . ew_HtmlEncode(ew_GetHashUrl($this->InlineEditUrl, $this->PageObjName . "_row_" . $this->RowCnt)) . "\">" . $Language->Phrase("InlineEditLink") . "</a>";
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
		$option = $options["action"];

		// Add multi delete
		$item = &$option->Add("multidelete");
		$item->Body = "<a class=\"ewAction ewMultiDelete\" href=\"\" onclick=\"ew_SubmitSelected(document.fprocessflow_tblist, '" . $this->MultiDeleteUrl . "', ewLanguage.Phrase('DeleteMultiConfirmMsg'));return false;\">" . $Language->Phrase("DeleteSelectedLink") . "</a>";
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
				$item->Body = "<a class=\"ewAction ewCustomAction\" href=\"\" onclick=\"ew_SubmitSelected(document.fprocessflow_tblist, '" . ew_CurrentUrl() . "', null, '" . $action . "');return false;\">" . $name . "</a>";
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

	// Load default values
	function LoadDefaultValues() {
		$this->name->CurrentValue = NULL;
		$this->name->OldValue = $this->name->CurrentValue;
		$this->_email->CurrentValue = NULL;
		$this->_email->OldValue = $this->_email->CurrentValue;
		$this->progress->CurrentValue = "No";
		$this->progress2->CurrentValue = "No";
		$this->progress3->CurrentValue = "No";
		$this->progress4->CurrentValue = "No";
		$this->progress5->CurrentValue = "No";
		$this->progress6->CurrentValue = "No";
	}

	// Load basic search values
	function LoadBasicSearchValues() {
		$this->BasicSearch->Keyword = @$_GET[EW_TABLE_BASIC_SEARCH];
		if ($this->BasicSearch->Keyword <> "") $this->Command = "search";
		$this->BasicSearch->Type = @$_GET[EW_TABLE_BASIC_SEARCH_TYPE];
	}

	// Load form values
	function LoadFormValues() {

		// Load from form
		global $objForm;
		if (!$this->name->FldIsDetailKey) {
			$this->name->setFormValue($objForm->GetValue("x_name"));
		}
		if (!$this->_email->FldIsDetailKey) {
			$this->_email->setFormValue($objForm->GetValue("x__email"));
		}
		if (!$this->progress->FldIsDetailKey) {
			$this->progress->setFormValue($objForm->GetValue("x_progress"));
		}
		if (!$this->progress2->FldIsDetailKey) {
			$this->progress2->setFormValue($objForm->GetValue("x_progress2"));
		}
		if (!$this->progress3->FldIsDetailKey) {
			$this->progress3->setFormValue($objForm->GetValue("x_progress3"));
		}
		if (!$this->progress4->FldIsDetailKey) {
			$this->progress4->setFormValue($objForm->GetValue("x_progress4"));
		}
		if (!$this->progress5->FldIsDetailKey) {
			$this->progress5->setFormValue($objForm->GetValue("x_progress5"));
		}
		if (!$this->progress6->FldIsDetailKey) {
			$this->progress6->setFormValue($objForm->GetValue("x_progress6"));
		}
		if (!$this->id->FldIsDetailKey && $this->CurrentAction <> "gridadd" && $this->CurrentAction <> "add")
			$this->id->setFormValue($objForm->GetValue("x_id"));
	}

	// Restore form values
	function RestoreFormValues() {
		global $objForm;
		if ($this->CurrentAction <> "gridadd" && $this->CurrentAction <> "add")
			$this->id->CurrentValue = $this->id->FormValue;
		$this->name->CurrentValue = $this->name->FormValue;
		$this->_email->CurrentValue = $this->_email->FormValue;
		$this->progress->CurrentValue = $this->progress->FormValue;
		$this->progress2->CurrentValue = $this->progress2->FormValue;
		$this->progress3->CurrentValue = $this->progress3->FormValue;
		$this->progress4->CurrentValue = $this->progress4->FormValue;
		$this->progress5->CurrentValue = $this->progress5->FormValue;
		$this->progress6->CurrentValue = $this->progress6->FormValue;
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

		$this->uid->CellCssStyle = "white-space: nowrap;";

		// name
		// email
		// stage

		$this->stage->CellCssStyle = "white-space: nowrap;";

		// progress
		// stage2

		$this->stage2->CellCssStyle = "white-space: nowrap;";

		// progress2
		// stage3

		$this->stage3->CellCssStyle = "white-space: nowrap;";

		// progress3
		// stage4

		$this->stage4->CellCssStyle = "white-space: nowrap;";

		// progress4
		// stage5

		$this->stage5->CellCssStyle = "white-space: nowrap;";

		// progress5
		// stage6

		$this->stage6->CellCssStyle = "white-space: nowrap;";

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
		} elseif ($this->RowType == EW_ROWTYPE_ADD) { // Add row

			// name
			$this->name->EditCustomAttributes = "style='width:97%' ";
			$this->name->EditValue = ew_HtmlEncode($this->name->CurrentValue);
			$this->name->PlaceHolder = ew_HtmlEncode(ew_RemoveHtml($this->name->FldCaption()));

			// email
			$this->_email->EditCustomAttributes = "style='width:97%' ";
			$this->_email->EditValue = ew_HtmlEncode($this->_email->CurrentValue);
			$this->_email->PlaceHolder = ew_HtmlEncode(ew_RemoveHtml($this->_email->FldCaption()));

			// progress
			$this->progress->EditCustomAttributes = "style='width:97%' ";
			$arwrk = array();
			$arwrk[] = array($this->progress->FldTagValue(1), $this->progress->FldTagCaption(1) <> "" ? $this->progress->FldTagCaption(1) : $this->progress->FldTagValue(1));
			$arwrk[] = array($this->progress->FldTagValue(2), $this->progress->FldTagCaption(2) <> "" ? $this->progress->FldTagCaption(2) : $this->progress->FldTagValue(2));
			$arwrk[] = array($this->progress->FldTagValue(3), $this->progress->FldTagCaption(3) <> "" ? $this->progress->FldTagCaption(3) : $this->progress->FldTagValue(3));
			array_unshift($arwrk, array("", $Language->Phrase("PleaseSelect")));
			$this->progress->EditValue = $arwrk;

			// progress2
			$this->progress2->EditCustomAttributes = "style='width:97%' ";
			$arwrk = array();
			$arwrk[] = array($this->progress2->FldTagValue(1), $this->progress2->FldTagCaption(1) <> "" ? $this->progress2->FldTagCaption(1) : $this->progress2->FldTagValue(1));
			$arwrk[] = array($this->progress2->FldTagValue(2), $this->progress2->FldTagCaption(2) <> "" ? $this->progress2->FldTagCaption(2) : $this->progress2->FldTagValue(2));
			$arwrk[] = array($this->progress2->FldTagValue(3), $this->progress2->FldTagCaption(3) <> "" ? $this->progress2->FldTagCaption(3) : $this->progress2->FldTagValue(3));
			array_unshift($arwrk, array("", $Language->Phrase("PleaseSelect")));
			$this->progress2->EditValue = $arwrk;

			// progress3
			$this->progress3->EditCustomAttributes = "style='width:97%' ";
			$arwrk = array();
			$arwrk[] = array($this->progress3->FldTagValue(1), $this->progress3->FldTagCaption(1) <> "" ? $this->progress3->FldTagCaption(1) : $this->progress3->FldTagValue(1));
			$arwrk[] = array($this->progress3->FldTagValue(2), $this->progress3->FldTagCaption(2) <> "" ? $this->progress3->FldTagCaption(2) : $this->progress3->FldTagValue(2));
			$arwrk[] = array($this->progress3->FldTagValue(3), $this->progress3->FldTagCaption(3) <> "" ? $this->progress3->FldTagCaption(3) : $this->progress3->FldTagValue(3));
			array_unshift($arwrk, array("", $Language->Phrase("PleaseSelect")));
			$this->progress3->EditValue = $arwrk;

			// progress4
			$this->progress4->EditCustomAttributes = "style='width:97%' ";
			$arwrk = array();
			$arwrk[] = array($this->progress4->FldTagValue(1), $this->progress4->FldTagCaption(1) <> "" ? $this->progress4->FldTagCaption(1) : $this->progress4->FldTagValue(1));
			$arwrk[] = array($this->progress4->FldTagValue(2), $this->progress4->FldTagCaption(2) <> "" ? $this->progress4->FldTagCaption(2) : $this->progress4->FldTagValue(2));
			$arwrk[] = array($this->progress4->FldTagValue(3), $this->progress4->FldTagCaption(3) <> "" ? $this->progress4->FldTagCaption(3) : $this->progress4->FldTagValue(3));
			array_unshift($arwrk, array("", $Language->Phrase("PleaseSelect")));
			$this->progress4->EditValue = $arwrk;

			// progress5
			$this->progress5->EditCustomAttributes = "style='width:97%' ";
			$arwrk = array();
			$arwrk[] = array($this->progress5->FldTagValue(1), $this->progress5->FldTagCaption(1) <> "" ? $this->progress5->FldTagCaption(1) : $this->progress5->FldTagValue(1));
			$arwrk[] = array($this->progress5->FldTagValue(2), $this->progress5->FldTagCaption(2) <> "" ? $this->progress5->FldTagCaption(2) : $this->progress5->FldTagValue(2));
			$arwrk[] = array($this->progress5->FldTagValue(3), $this->progress5->FldTagCaption(3) <> "" ? $this->progress5->FldTagCaption(3) : $this->progress5->FldTagValue(3));
			array_unshift($arwrk, array("", $Language->Phrase("PleaseSelect")));
			$this->progress5->EditValue = $arwrk;

			// progress6
			$this->progress6->EditCustomAttributes = "style='width:97%' ";
			$arwrk = array();
			$arwrk[] = array($this->progress6->FldTagValue(1), $this->progress6->FldTagCaption(1) <> "" ? $this->progress6->FldTagCaption(1) : $this->progress6->FldTagValue(1));
			$arwrk[] = array($this->progress6->FldTagValue(2), $this->progress6->FldTagCaption(2) <> "" ? $this->progress6->FldTagCaption(2) : $this->progress6->FldTagValue(2));
			$arwrk[] = array($this->progress6->FldTagValue(3), $this->progress6->FldTagCaption(3) <> "" ? $this->progress6->FldTagCaption(3) : $this->progress6->FldTagValue(3));
			array_unshift($arwrk, array("", $Language->Phrase("PleaseSelect")));
			$this->progress6->EditValue = $arwrk;

			// Edit refer script
			// name

			$this->name->HrefValue = "";

			// email
			$this->_email->HrefValue = "";

			// progress
			$this->progress->HrefValue = "";

			// progress2
			$this->progress2->HrefValue = "";

			// progress3
			$this->progress3->HrefValue = "";

			// progress4
			$this->progress4->HrefValue = "";

			// progress5
			$this->progress5->HrefValue = "";

			// progress6
			$this->progress6->HrefValue = "";
		} elseif ($this->RowType == EW_ROWTYPE_EDIT) { // Edit row

			// name
			$this->name->EditCustomAttributes = "style='width:97%' ";
			$this->name->EditValue = ew_HtmlEncode($this->name->CurrentValue);
			$this->name->PlaceHolder = ew_HtmlEncode(ew_RemoveHtml($this->name->FldCaption()));

			// email
			$this->_email->EditCustomAttributes = "style='width:97%' ";
			$this->_email->EditValue = ew_HtmlEncode($this->_email->CurrentValue);
			$this->_email->PlaceHolder = ew_HtmlEncode(ew_RemoveHtml($this->_email->FldCaption()));

			// progress
			$this->progress->EditCustomAttributes = "style='width:97%' ";
			$arwrk = array();
			$arwrk[] = array($this->progress->FldTagValue(1), $this->progress->FldTagCaption(1) <> "" ? $this->progress->FldTagCaption(1) : $this->progress->FldTagValue(1));
			$arwrk[] = array($this->progress->FldTagValue(2), $this->progress->FldTagCaption(2) <> "" ? $this->progress->FldTagCaption(2) : $this->progress->FldTagValue(2));
			$arwrk[] = array($this->progress->FldTagValue(3), $this->progress->FldTagCaption(3) <> "" ? $this->progress->FldTagCaption(3) : $this->progress->FldTagValue(3));
			array_unshift($arwrk, array("", $Language->Phrase("PleaseSelect")));
			$this->progress->EditValue = $arwrk;

			// progress2
			$this->progress2->EditCustomAttributes = "style='width:97%' ";
			$arwrk = array();
			$arwrk[] = array($this->progress2->FldTagValue(1), $this->progress2->FldTagCaption(1) <> "" ? $this->progress2->FldTagCaption(1) : $this->progress2->FldTagValue(1));
			$arwrk[] = array($this->progress2->FldTagValue(2), $this->progress2->FldTagCaption(2) <> "" ? $this->progress2->FldTagCaption(2) : $this->progress2->FldTagValue(2));
			$arwrk[] = array($this->progress2->FldTagValue(3), $this->progress2->FldTagCaption(3) <> "" ? $this->progress2->FldTagCaption(3) : $this->progress2->FldTagValue(3));
			array_unshift($arwrk, array("", $Language->Phrase("PleaseSelect")));
			$this->progress2->EditValue = $arwrk;

			// progress3
			$this->progress3->EditCustomAttributes = "style='width:97%' ";
			$arwrk = array();
			$arwrk[] = array($this->progress3->FldTagValue(1), $this->progress3->FldTagCaption(1) <> "" ? $this->progress3->FldTagCaption(1) : $this->progress3->FldTagValue(1));
			$arwrk[] = array($this->progress3->FldTagValue(2), $this->progress3->FldTagCaption(2) <> "" ? $this->progress3->FldTagCaption(2) : $this->progress3->FldTagValue(2));
			$arwrk[] = array($this->progress3->FldTagValue(3), $this->progress3->FldTagCaption(3) <> "" ? $this->progress3->FldTagCaption(3) : $this->progress3->FldTagValue(3));
			array_unshift($arwrk, array("", $Language->Phrase("PleaseSelect")));
			$this->progress3->EditValue = $arwrk;

			// progress4
			$this->progress4->EditCustomAttributes = "style='width:97%' ";
			$arwrk = array();
			$arwrk[] = array($this->progress4->FldTagValue(1), $this->progress4->FldTagCaption(1) <> "" ? $this->progress4->FldTagCaption(1) : $this->progress4->FldTagValue(1));
			$arwrk[] = array($this->progress4->FldTagValue(2), $this->progress4->FldTagCaption(2) <> "" ? $this->progress4->FldTagCaption(2) : $this->progress4->FldTagValue(2));
			$arwrk[] = array($this->progress4->FldTagValue(3), $this->progress4->FldTagCaption(3) <> "" ? $this->progress4->FldTagCaption(3) : $this->progress4->FldTagValue(3));
			array_unshift($arwrk, array("", $Language->Phrase("PleaseSelect")));
			$this->progress4->EditValue = $arwrk;

			// progress5
			$this->progress5->EditCustomAttributes = "style='width:97%' ";
			$arwrk = array();
			$arwrk[] = array($this->progress5->FldTagValue(1), $this->progress5->FldTagCaption(1) <> "" ? $this->progress5->FldTagCaption(1) : $this->progress5->FldTagValue(1));
			$arwrk[] = array($this->progress5->FldTagValue(2), $this->progress5->FldTagCaption(2) <> "" ? $this->progress5->FldTagCaption(2) : $this->progress5->FldTagValue(2));
			$arwrk[] = array($this->progress5->FldTagValue(3), $this->progress5->FldTagCaption(3) <> "" ? $this->progress5->FldTagCaption(3) : $this->progress5->FldTagValue(3));
			array_unshift($arwrk, array("", $Language->Phrase("PleaseSelect")));
			$this->progress5->EditValue = $arwrk;

			// progress6
			$this->progress6->EditCustomAttributes = "style='width:97%' ";
			$arwrk = array();
			$arwrk[] = array($this->progress6->FldTagValue(1), $this->progress6->FldTagCaption(1) <> "" ? $this->progress6->FldTagCaption(1) : $this->progress6->FldTagValue(1));
			$arwrk[] = array($this->progress6->FldTagValue(2), $this->progress6->FldTagCaption(2) <> "" ? $this->progress6->FldTagCaption(2) : $this->progress6->FldTagValue(2));
			$arwrk[] = array($this->progress6->FldTagValue(3), $this->progress6->FldTagCaption(3) <> "" ? $this->progress6->FldTagCaption(3) : $this->progress6->FldTagValue(3));
			array_unshift($arwrk, array("", $Language->Phrase("PleaseSelect")));
			$this->progress6->EditValue = $arwrk;

			// Edit refer script
			// name

			$this->name->HrefValue = "";

			// email
			$this->_email->HrefValue = "";

			// progress
			$this->progress->HrefValue = "";

			// progress2
			$this->progress2->HrefValue = "";

			// progress3
			$this->progress3->HrefValue = "";

			// progress4
			$this->progress4->HrefValue = "";

			// progress5
			$this->progress5->HrefValue = "";

			// progress6
			$this->progress6->HrefValue = "";
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
			$rsnew = array();

			// name
			$this->name->SetDbValueDef($rsnew, $this->name->CurrentValue, NULL, $this->name->ReadOnly);

			// email
			$this->_email->SetDbValueDef($rsnew, $this->_email->CurrentValue, NULL, $this->_email->ReadOnly);

			// progress
			$this->progress->SetDbValueDef($rsnew, $this->progress->CurrentValue, NULL, $this->progress->ReadOnly);

			// progress2
			$this->progress2->SetDbValueDef($rsnew, $this->progress2->CurrentValue, NULL, $this->progress2->ReadOnly);

			// progress3
			$this->progress3->SetDbValueDef($rsnew, $this->progress3->CurrentValue, NULL, $this->progress3->ReadOnly);

			// progress4
			$this->progress4->SetDbValueDef($rsnew, $this->progress4->CurrentValue, NULL, $this->progress4->ReadOnly);

			// progress5
			$this->progress5->SetDbValueDef($rsnew, $this->progress5->CurrentValue, NULL, $this->progress5->ReadOnly);

			// progress6
			$this->progress6->SetDbValueDef($rsnew, $this->progress6->CurrentValue, NULL, $this->progress6->ReadOnly);

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
		return $EditRow;
	}

	// Add record
	function AddRow($rsold = NULL) {
		global $conn, $Language, $Security;

		// Load db values from rsold
		if ($rsold) {
			$this->LoadDbValues($rsold);
		}
		$rsnew = array();

		// name
		$this->name->SetDbValueDef($rsnew, $this->name->CurrentValue, NULL, FALSE);

		// email
		$this->_email->SetDbValueDef($rsnew, $this->_email->CurrentValue, NULL, FALSE);

		// progress
		$this->progress->SetDbValueDef($rsnew, $this->progress->CurrentValue, NULL, strval($this->progress->CurrentValue) == "");

		// progress2
		$this->progress2->SetDbValueDef($rsnew, $this->progress2->CurrentValue, NULL, strval($this->progress2->CurrentValue) == "");

		// progress3
		$this->progress3->SetDbValueDef($rsnew, $this->progress3->CurrentValue, NULL, strval($this->progress3->CurrentValue) == "");

		// progress4
		$this->progress4->SetDbValueDef($rsnew, $this->progress4->CurrentValue, NULL, strval($this->progress4->CurrentValue) == "");

		// progress5
		$this->progress5->SetDbValueDef($rsnew, $this->progress5->CurrentValue, NULL, strval($this->progress5->CurrentValue) == "");

		// progress6
		$this->progress6->SetDbValueDef($rsnew, $this->progress6->CurrentValue, NULL, strval($this->progress6->CurrentValue) == "");

		// Call Row Inserting event
		$rs = ($rsold == NULL) ? NULL : $rsold->fields;
		$bInsertRow = $this->Row_Inserting($rs, $rsnew);
		if ($bInsertRow) {
			$conn->raiseErrorFn = 'ew_ErrorFn';
			$AddRow = $this->Insert($rsnew);
			$conn->raiseErrorFn = '';
			if ($AddRow) {
			}
		} else {
			if ($this->getSuccessMessage() <> "" || $this->getFailureMessage() <> "") {

				// Use the message, do nothing
			} elseif ($this->CancelMessage <> "") {
				$this->setFailureMessage($this->CancelMessage);
				$this->CancelMessage = "";
			} else {
				$this->setFailureMessage($Language->Phrase("InsertCancelled"));
			}
			$AddRow = FALSE;
		}

		// Get insert id if necessary
		if ($AddRow) {
			$this->id->setDbValue($conn->Insert_ID());
			$rsnew['id'] = $this->id->DbValue;
		}
		if ($AddRow) {

			// Call Row Inserted event
			$rs = ($rsold == NULL) ? NULL : $rsold->fields;
			$this->Row_Inserted($rs, $rsnew);
		}
		return $AddRow;
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
		$item->Body = "<a id=\"emf_processflow_tb\" href=\"javascript:void(0);\" class=\"ewExportLink ewEmail\" data-caption=\"" . $Language->Phrase("ExportToEmailText") . "\" onclick=\"ew_EmailDialogShow({lnk:'emf_processflow_tb',hdr:ewLanguage.Phrase('ExportToEmail'),f:document.fprocessflow_tblist,sel:false});\">" . $Language->Phrase("ExportToEmail") . "</a>";
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
if (!isset($processflow_tb_list)) $processflow_tb_list = new cprocessflow_tb_list();

// Page init
$processflow_tb_list->Page_Init();

// Page main
$processflow_tb_list->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$processflow_tb_list->Page_Render();
?>
<?php include_once "header.php" ?>
<?php if ($processflow_tb->Export == "") { ?>
<script type="text/javascript">

// Page object
var processflow_tb_list = new ew_Page("processflow_tb_list");
processflow_tb_list.PageID = "list"; // Page ID
var EW_PAGE_ID = processflow_tb_list.PageID; // For backward compatibility

// Form object
var fprocessflow_tblist = new ew_Form("fprocessflow_tblist");
fprocessflow_tblist.FormKeyCountName = '<?php echo $processflow_tb_list->FormKeyCountName ?>';

// Validate form
fprocessflow_tblist.Validate = function() {
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
	return true;
}

// Form_CustomValidate event
fprocessflow_tblist.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
fprocessflow_tblist.ValidateRequired = true;
<?php } else { ?>
fprocessflow_tblist.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
// Form object for search

var fprocessflow_tblistsrch = new ew_Form("fprocessflow_tblistsrch");
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
<?php if ($processflow_tb->Export == "") { ?>
<?php $Breadcrumb->Render(); ?>
<?php } ?>
<?php if ($processflow_tb_list->ExportOptions->Visible()) { ?>
<div class="ewListExportOptions"><?php $processflow_tb_list->ExportOptions->Render("body") ?></div>
<?php } ?>
<?php
	$bSelectLimit = EW_SELECT_LIMIT;
	if ($bSelectLimit) {
		$processflow_tb_list->TotalRecs = $processflow_tb->SelectRecordCount();
	} else {
		if ($processflow_tb_list->Recordset = $processflow_tb_list->LoadRecordset())
			$processflow_tb_list->TotalRecs = $processflow_tb_list->Recordset->RecordCount();
	}
	$processflow_tb_list->StartRec = 1;
	if ($processflow_tb_list->DisplayRecs <= 0 || ($processflow_tb->Export <> "" && $processflow_tb->ExportAll)) // Display all records
		$processflow_tb_list->DisplayRecs = $processflow_tb_list->TotalRecs;
	if (!($processflow_tb->Export <> "" && $processflow_tb->ExportAll))
		$processflow_tb_list->SetUpStartRec(); // Set up start record position
	if ($bSelectLimit)
		$processflow_tb_list->Recordset = $processflow_tb_list->LoadRecordset($processflow_tb_list->StartRec-1, $processflow_tb_list->DisplayRecs);
$processflow_tb_list->RenderOtherOptions();
?>
<?php if ($Security->IsLoggedIn()) { ?>
<?php if ($processflow_tb->Export == "" && $processflow_tb->CurrentAction == "") { ?>
<form name="fprocessflow_tblistsrch" id="fprocessflow_tblistsrch" class="ewForm form-inline" action="<?php echo ew_CurrentPage() ?>">
<table class="ewSearchTable"><tr><td>
<div class="accordion" id="fprocessflow_tblistsrch_SearchGroup">
	<div class="accordion-group">
		<div class="accordion-heading">
<a class="accordion-toggle" data-toggle="collapse" data-parent="#fprocessflow_tblistsrch_SearchGroup" href="#fprocessflow_tblistsrch_SearchBody"><?php echo $Language->Phrase("Search") ?></a>
		</div>
		<div id="fprocessflow_tblistsrch_SearchBody" class="accordion-body collapse in">
			<div class="accordion-inner">
<div id="fprocessflow_tblistsrch_SearchPanel">
<input type="hidden" name="cmd" value="search">
<input type="hidden" name="t" value="processflow_tb">
<div class="ewBasicSearch">
<div id="xsr_1" class="ewRow">
	<div class="btn-group ewButtonGroup">
	<div class="input-append">
	<input type="text" name="<?php echo EW_TABLE_BASIC_SEARCH ?>" id="<?php echo EW_TABLE_BASIC_SEARCH ?>" class="input-large" value="<?php echo ew_HtmlEncode($processflow_tb_list->BasicSearch->getKeyword()) ?>" placeholder="<?php echo $Language->Phrase("Search") ?>">
	<button class="btn btn-primary ewButton" name="btnsubmit" id="btnsubmit" type="submit"><?php echo $Language->Phrase("QuickSearchBtn") ?></button>
	</div>
	</div>
	<div class="btn-group ewButtonGroup">
	<a class="btn ewShowAll" href="<?php echo $processflow_tb_list->PageUrl() ?>cmd=reset"><?php echo $Language->Phrase("ShowAll") ?></a>
</div>
<div id="xsr_2" class="ewRow">
	<label class="inline radio ewRadio" style="white-space: nowrap;"><input type="radio" name="<?php echo EW_TABLE_BASIC_SEARCH_TYPE ?>" value="="<?php if ($processflow_tb_list->BasicSearch->getType() == "=") { ?> checked="checked"<?php } ?>><?php echo $Language->Phrase("ExactPhrase") ?></label>
	<label class="inline radio ewRadio" style="white-space: nowrap;"><input type="radio" name="<?php echo EW_TABLE_BASIC_SEARCH_TYPE ?>" value="AND"<?php if ($processflow_tb_list->BasicSearch->getType() == "AND") { ?> checked="checked"<?php } ?>><?php echo $Language->Phrase("AllWord") ?></label>
	<label class="inline radio ewRadio" style="white-space: nowrap;"><input type="radio" name="<?php echo EW_TABLE_BASIC_SEARCH_TYPE ?>" value="OR"<?php if ($processflow_tb_list->BasicSearch->getType() == "OR") { ?> checked="checked"<?php } ?>><?php echo $Language->Phrase("AnyWord") ?></label>
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
<?php $processflow_tb_list->ShowPageHeader(); ?>
<?php
$processflow_tb_list->ShowMessage();
?>
<table cellspacing="0" class="ewGrid"><tr><td class="ewGridContent">
<form name="fprocessflow_tblist" id="fprocessflow_tblist" class="ewForm form-horizontal" action="<?php echo ew_CurrentPage() ?>" method="post">
<input type="hidden" name="t" value="processflow_tb">
<div id="gmp_processflow_tb" class="ewGridMiddlePanel">
<?php if ($processflow_tb_list->TotalRecs > 0) { ?>
<table id="tbl_processflow_tblist" class="ewTable ewTableSeparate">
<?php echo $processflow_tb->TableCustomInnerHtml ?>
<thead><!-- Table header -->
	<tr class="ewTableHeader">
<?php

// Render list options
$processflow_tb_list->RenderListOptions();

// Render list options (header, left)
$processflow_tb_list->ListOptions->Render("header", "left");
?>
<?php if ($processflow_tb->name->Visible) { // name ?>
	<?php if ($processflow_tb->SortUrl($processflow_tb->name) == "") { ?>
		<td><div id="elh_processflow_tb_name" class="processflow_tb_name"><div class="ewTableHeaderCaption"><?php echo $processflow_tb->name->FldCaption() ?></div></div></td>
	<?php } else { ?>
		<td><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $processflow_tb->SortUrl($processflow_tb->name) ?>',2);"><div id="elh_processflow_tb_name" class="processflow_tb_name">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $processflow_tb->name->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($processflow_tb->name->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($processflow_tb->name->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></td>
	<?php } ?>
<?php } ?>		
<?php if ($processflow_tb->_email->Visible) { // email ?>
	<?php if ($processflow_tb->SortUrl($processflow_tb->_email) == "") { ?>
		<td><div id="elh_processflow_tb__email" class="processflow_tb__email"><div class="ewTableHeaderCaption"><?php echo $processflow_tb->_email->FldCaption() ?></div></div></td>
	<?php } else { ?>
		<td><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $processflow_tb->SortUrl($processflow_tb->_email) ?>',2);"><div id="elh_processflow_tb__email" class="processflow_tb__email">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $processflow_tb->_email->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($processflow_tb->_email->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($processflow_tb->_email->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></td>
	<?php } ?>
<?php } ?>		
<?php if ($processflow_tb->progress->Visible) { // progress ?>
	<?php if ($processflow_tb->SortUrl($processflow_tb->progress) == "") { ?>
		<td><div id="elh_processflow_tb_progress" class="processflow_tb_progress"><div class="ewTableHeaderCaption"><?php echo $processflow_tb->progress->FldCaption() ?></div></div></td>
	<?php } else { ?>
		<td><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $processflow_tb->SortUrl($processflow_tb->progress) ?>',2);"><div id="elh_processflow_tb_progress" class="processflow_tb_progress">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $processflow_tb->progress->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($processflow_tb->progress->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($processflow_tb->progress->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></td>
	<?php } ?>
<?php } ?>		
<?php if ($processflow_tb->progress2->Visible) { // progress2 ?>
	<?php if ($processflow_tb->SortUrl($processflow_tb->progress2) == "") { ?>
		<td><div id="elh_processflow_tb_progress2" class="processflow_tb_progress2"><div class="ewTableHeaderCaption"><?php echo $processflow_tb->progress2->FldCaption() ?></div></div></td>
	<?php } else { ?>
		<td><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $processflow_tb->SortUrl($processflow_tb->progress2) ?>',2);"><div id="elh_processflow_tb_progress2" class="processflow_tb_progress2">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $processflow_tb->progress2->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($processflow_tb->progress2->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($processflow_tb->progress2->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></td>
	<?php } ?>
<?php } ?>		
<?php if ($processflow_tb->progress3->Visible) { // progress3 ?>
	<?php if ($processflow_tb->SortUrl($processflow_tb->progress3) == "") { ?>
		<td><div id="elh_processflow_tb_progress3" class="processflow_tb_progress3"><div class="ewTableHeaderCaption"><?php echo $processflow_tb->progress3->FldCaption() ?></div></div></td>
	<?php } else { ?>
		<td><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $processflow_tb->SortUrl($processflow_tb->progress3) ?>',2);"><div id="elh_processflow_tb_progress3" class="processflow_tb_progress3">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $processflow_tb->progress3->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($processflow_tb->progress3->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($processflow_tb->progress3->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></td>
	<?php } ?>
<?php } ?>		
<?php if ($processflow_tb->progress4->Visible) { // progress4 ?>
	<?php if ($processflow_tb->SortUrl($processflow_tb->progress4) == "") { ?>
		<td><div id="elh_processflow_tb_progress4" class="processflow_tb_progress4"><div class="ewTableHeaderCaption"><?php echo $processflow_tb->progress4->FldCaption() ?></div></div></td>
	<?php } else { ?>
		<td><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $processflow_tb->SortUrl($processflow_tb->progress4) ?>',2);"><div id="elh_processflow_tb_progress4" class="processflow_tb_progress4">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $processflow_tb->progress4->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($processflow_tb->progress4->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($processflow_tb->progress4->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></td>
	<?php } ?>
<?php } ?>		
<?php if ($processflow_tb->progress5->Visible) { // progress5 ?>
	<?php if ($processflow_tb->SortUrl($processflow_tb->progress5) == "") { ?>
		<td><div id="elh_processflow_tb_progress5" class="processflow_tb_progress5"><div class="ewTableHeaderCaption"><?php echo $processflow_tb->progress5->FldCaption() ?></div></div></td>
	<?php } else { ?>
		<td><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $processflow_tb->SortUrl($processflow_tb->progress5) ?>',2);"><div id="elh_processflow_tb_progress5" class="processflow_tb_progress5">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $processflow_tb->progress5->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($processflow_tb->progress5->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($processflow_tb->progress5->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></td>
	<?php } ?>
<?php } ?>		
<?php if ($processflow_tb->progress6->Visible) { // progress6 ?>
	<?php if ($processflow_tb->SortUrl($processflow_tb->progress6) == "") { ?>
		<td><div id="elh_processflow_tb_progress6" class="processflow_tb_progress6"><div class="ewTableHeaderCaption"><?php echo $processflow_tb->progress6->FldCaption() ?></div></div></td>
	<?php } else { ?>
		<td><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $processflow_tb->SortUrl($processflow_tb->progress6) ?>',2);"><div id="elh_processflow_tb_progress6" class="processflow_tb_progress6">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $processflow_tb->progress6->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($processflow_tb->progress6->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($processflow_tb->progress6->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></td>
	<?php } ?>
<?php } ?>		
<?php

// Render list options (header, right)
$processflow_tb_list->ListOptions->Render("header", "right");
?>
	</tr>
</thead>
<tbody>
<?php
if ($processflow_tb->ExportAll && $processflow_tb->Export <> "") {
	$processflow_tb_list->StopRec = $processflow_tb_list->TotalRecs;
} else {

	// Set the last record to display
	if ($processflow_tb_list->TotalRecs > $processflow_tb_list->StartRec + $processflow_tb_list->DisplayRecs - 1)
		$processflow_tb_list->StopRec = $processflow_tb_list->StartRec + $processflow_tb_list->DisplayRecs - 1;
	else
		$processflow_tb_list->StopRec = $processflow_tb_list->TotalRecs;
}

// Restore number of post back records
if ($objForm) {
	$objForm->Index = -1;
	if ($objForm->HasValue($processflow_tb_list->FormKeyCountName) && ($processflow_tb->CurrentAction == "gridadd" || $processflow_tb->CurrentAction == "gridedit" || $processflow_tb->CurrentAction == "F")) {
		$processflow_tb_list->KeyCount = $objForm->GetValue($processflow_tb_list->FormKeyCountName);
		$processflow_tb_list->StopRec = $processflow_tb_list->StartRec + $processflow_tb_list->KeyCount - 1;
	}
}
$processflow_tb_list->RecCnt = $processflow_tb_list->StartRec - 1;
if ($processflow_tb_list->Recordset && !$processflow_tb_list->Recordset->EOF) {
	$processflow_tb_list->Recordset->MoveFirst();
	if (!$bSelectLimit && $processflow_tb_list->StartRec > 1)
		$processflow_tb_list->Recordset->Move($processflow_tb_list->StartRec - 1);
} elseif (!$processflow_tb->AllowAddDeleteRow && $processflow_tb_list->StopRec == 0) {
	$processflow_tb_list->StopRec = $processflow_tb->GridAddRowCount;
}

// Initialize aggregate
$processflow_tb->RowType = EW_ROWTYPE_AGGREGATEINIT;
$processflow_tb->ResetAttrs();
$processflow_tb_list->RenderRow();
$processflow_tb_list->EditRowCnt = 0;
if ($processflow_tb->CurrentAction == "edit")
	$processflow_tb_list->RowIndex = 1;
while ($processflow_tb_list->RecCnt < $processflow_tb_list->StopRec) {
	$processflow_tb_list->RecCnt++;
	if (intval($processflow_tb_list->RecCnt) >= intval($processflow_tb_list->StartRec)) {
		$processflow_tb_list->RowCnt++;

		// Set up key count
		$processflow_tb_list->KeyCount = $processflow_tb_list->RowIndex;

		// Init row class and style
		$processflow_tb->ResetAttrs();
		$processflow_tb->CssClass = "";
		if ($processflow_tb->CurrentAction == "gridadd") {
			$processflow_tb_list->LoadDefaultValues(); // Load default values
		} else {
			$processflow_tb_list->LoadRowValues($processflow_tb_list->Recordset); // Load row values
		}
		$processflow_tb->RowType = EW_ROWTYPE_VIEW; // Render view
		if ($processflow_tb->CurrentAction == "edit") {
			if ($processflow_tb_list->CheckInlineEditKey() && $processflow_tb_list->EditRowCnt == 0) { // Inline edit
				$processflow_tb->RowType = EW_ROWTYPE_EDIT; // Render edit
			}
		}
		if ($processflow_tb->CurrentAction == "edit" && $processflow_tb->RowType == EW_ROWTYPE_EDIT && $processflow_tb->EventCancelled) { // Update failed
			$objForm->Index = 1;
			$processflow_tb_list->RestoreFormValues(); // Restore form values
		}
		if ($processflow_tb->RowType == EW_ROWTYPE_EDIT) // Edit row
			$processflow_tb_list->EditRowCnt++;

		// Set up row id / data-rowindex
		$processflow_tb->RowAttrs = array_merge($processflow_tb->RowAttrs, array('data-rowindex'=>$processflow_tb_list->RowCnt, 'id'=>'r' . $processflow_tb_list->RowCnt . '_processflow_tb', 'data-rowtype'=>$processflow_tb->RowType));

		// Render row
		$processflow_tb_list->RenderRow();

		// Render list options
		$processflow_tb_list->RenderListOptions();
?>
	<tr<?php echo $processflow_tb->RowAttributes() ?>>
<?php

// Render list options (body, left)
$processflow_tb_list->ListOptions->Render("body", "left", $processflow_tb_list->RowCnt);
?>
	<?php if ($processflow_tb->name->Visible) { // name ?>
		<td<?php echo $processflow_tb->name->CellAttributes() ?>>
<?php if ($processflow_tb->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $processflow_tb_list->RowCnt ?>_processflow_tb_name" class="control-group processflow_tb_name">
<input type="text" data-field="x_name" name="x<?php echo $processflow_tb_list->RowIndex ?>_name" id="x<?php echo $processflow_tb_list->RowIndex ?>_name" size="30" maxlength="100" placeholder="<?php echo $processflow_tb->name->PlaceHolder ?>" value="<?php echo $processflow_tb->name->EditValue ?>"<?php echo $processflow_tb->name->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($processflow_tb->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span<?php echo $processflow_tb->name->ViewAttributes() ?>>
<?php echo $processflow_tb->name->ListViewValue() ?></span>
<?php } ?>
<a id="<?php echo $processflow_tb_list->PageObjName . "_row_" . $processflow_tb_list->RowCnt ?>"></a></td>
	<?php } ?>
<?php if ($processflow_tb->RowType == EW_ROWTYPE_EDIT || $processflow_tb->CurrentMode == "edit") { ?>
<input type="hidden" data-field="x_id" name="x<?php echo $processflow_tb_list->RowIndex ?>_id" id="x<?php echo $processflow_tb_list->RowIndex ?>_id" value="<?php echo ew_HtmlEncode($processflow_tb->id->CurrentValue) ?>">
<?php } ?>
	<?php if ($processflow_tb->_email->Visible) { // email ?>
		<td<?php echo $processflow_tb->_email->CellAttributes() ?>>
<?php if ($processflow_tb->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $processflow_tb_list->RowCnt ?>_processflow_tb__email" class="control-group processflow_tb__email">
<input type="text" data-field="x__email" name="x<?php echo $processflow_tb_list->RowIndex ?>__email" id="x<?php echo $processflow_tb_list->RowIndex ?>__email" size="30" maxlength="50" placeholder="<?php echo $processflow_tb->_email->PlaceHolder ?>" value="<?php echo $processflow_tb->_email->EditValue ?>"<?php echo $processflow_tb->_email->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($processflow_tb->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span<?php echo $processflow_tb->_email->ViewAttributes() ?>>
<?php echo $processflow_tb->_email->ListViewValue() ?></span>
<?php } ?>
<a id="<?php echo $processflow_tb_list->PageObjName . "_row_" . $processflow_tb_list->RowCnt ?>"></a></td>
	<?php } ?>
	<?php if ($processflow_tb->progress->Visible) { // progress ?>
		<td<?php echo $processflow_tb->progress->CellAttributes() ?>>
<?php if ($processflow_tb->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $processflow_tb_list->RowCnt ?>_processflow_tb_progress" class="control-group processflow_tb_progress">
<select data-field="x_progress" id="x<?php echo $processflow_tb_list->RowIndex ?>_progress" name="x<?php echo $processflow_tb_list->RowIndex ?>_progress"<?php echo $processflow_tb->progress->EditAttributes() ?>>
<?php
if (is_array($processflow_tb->progress->EditValue)) {
	$arwrk = $processflow_tb->progress->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($processflow_tb->progress->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " selected=\"selected\"" : "";
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
<?php } ?>
<?php if ($processflow_tb->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span<?php echo $processflow_tb->progress->ViewAttributes() ?>>
<?php echo $processflow_tb->progress->ListViewValue() ?></span>
<?php } ?>
<a id="<?php echo $processflow_tb_list->PageObjName . "_row_" . $processflow_tb_list->RowCnt ?>"></a></td>
	<?php } ?>
	<?php if ($processflow_tb->progress2->Visible) { // progress2 ?>
		<td<?php echo $processflow_tb->progress2->CellAttributes() ?>>
<?php if ($processflow_tb->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $processflow_tb_list->RowCnt ?>_processflow_tb_progress2" class="control-group processflow_tb_progress2">
<select data-field="x_progress2" id="x<?php echo $processflow_tb_list->RowIndex ?>_progress2" name="x<?php echo $processflow_tb_list->RowIndex ?>_progress2"<?php echo $processflow_tb->progress2->EditAttributes() ?>>
<?php
if (is_array($processflow_tb->progress2->EditValue)) {
	$arwrk = $processflow_tb->progress2->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($processflow_tb->progress2->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " selected=\"selected\"" : "";
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
<?php } ?>
<?php if ($processflow_tb->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span<?php echo $processflow_tb->progress2->ViewAttributes() ?>>
<?php echo $processflow_tb->progress2->ListViewValue() ?></span>
<?php } ?>
<a id="<?php echo $processflow_tb_list->PageObjName . "_row_" . $processflow_tb_list->RowCnt ?>"></a></td>
	<?php } ?>
	<?php if ($processflow_tb->progress3->Visible) { // progress3 ?>
		<td<?php echo $processflow_tb->progress3->CellAttributes() ?>>
<?php if ($processflow_tb->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $processflow_tb_list->RowCnt ?>_processflow_tb_progress3" class="control-group processflow_tb_progress3">
<select data-field="x_progress3" id="x<?php echo $processflow_tb_list->RowIndex ?>_progress3" name="x<?php echo $processflow_tb_list->RowIndex ?>_progress3"<?php echo $processflow_tb->progress3->EditAttributes() ?>>
<?php
if (is_array($processflow_tb->progress3->EditValue)) {
	$arwrk = $processflow_tb->progress3->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($processflow_tb->progress3->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " selected=\"selected\"" : "";
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
<?php } ?>
<?php if ($processflow_tb->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span<?php echo $processflow_tb->progress3->ViewAttributes() ?>>
<?php echo $processflow_tb->progress3->ListViewValue() ?></span>
<?php } ?>
<a id="<?php echo $processflow_tb_list->PageObjName . "_row_" . $processflow_tb_list->RowCnt ?>"></a></td>
	<?php } ?>
	<?php if ($processflow_tb->progress4->Visible) { // progress4 ?>
		<td<?php echo $processflow_tb->progress4->CellAttributes() ?>>
<?php if ($processflow_tb->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $processflow_tb_list->RowCnt ?>_processflow_tb_progress4" class="control-group processflow_tb_progress4">
<select data-field="x_progress4" id="x<?php echo $processflow_tb_list->RowIndex ?>_progress4" name="x<?php echo $processflow_tb_list->RowIndex ?>_progress4"<?php echo $processflow_tb->progress4->EditAttributes() ?>>
<?php
if (is_array($processflow_tb->progress4->EditValue)) {
	$arwrk = $processflow_tb->progress4->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($processflow_tb->progress4->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " selected=\"selected\"" : "";
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
<?php } ?>
<?php if ($processflow_tb->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span<?php echo $processflow_tb->progress4->ViewAttributes() ?>>
<?php echo $processflow_tb->progress4->ListViewValue() ?></span>
<?php } ?>
<a id="<?php echo $processflow_tb_list->PageObjName . "_row_" . $processflow_tb_list->RowCnt ?>"></a></td>
	<?php } ?>
	<?php if ($processflow_tb->progress5->Visible) { // progress5 ?>
		<td<?php echo $processflow_tb->progress5->CellAttributes() ?>>
<?php if ($processflow_tb->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $processflow_tb_list->RowCnt ?>_processflow_tb_progress5" class="control-group processflow_tb_progress5">
<select data-field="x_progress5" id="x<?php echo $processflow_tb_list->RowIndex ?>_progress5" name="x<?php echo $processflow_tb_list->RowIndex ?>_progress5"<?php echo $processflow_tb->progress5->EditAttributes() ?>>
<?php
if (is_array($processflow_tb->progress5->EditValue)) {
	$arwrk = $processflow_tb->progress5->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($processflow_tb->progress5->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " selected=\"selected\"" : "";
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
<?php } ?>
<?php if ($processflow_tb->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span<?php echo $processflow_tb->progress5->ViewAttributes() ?>>
<?php echo $processflow_tb->progress5->ListViewValue() ?></span>
<?php } ?>
<a id="<?php echo $processflow_tb_list->PageObjName . "_row_" . $processflow_tb_list->RowCnt ?>"></a></td>
	<?php } ?>
	<?php if ($processflow_tb->progress6->Visible) { // progress6 ?>
		<td<?php echo $processflow_tb->progress6->CellAttributes() ?>>
<?php if ($processflow_tb->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $processflow_tb_list->RowCnt ?>_processflow_tb_progress6" class="control-group processflow_tb_progress6">
<select data-field="x_progress6" id="x<?php echo $processflow_tb_list->RowIndex ?>_progress6" name="x<?php echo $processflow_tb_list->RowIndex ?>_progress6"<?php echo $processflow_tb->progress6->EditAttributes() ?>>
<?php
if (is_array($processflow_tb->progress6->EditValue)) {
	$arwrk = $processflow_tb->progress6->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($processflow_tb->progress6->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " selected=\"selected\"" : "";
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
<?php } ?>
<?php if ($processflow_tb->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span<?php echo $processflow_tb->progress6->ViewAttributes() ?>>
<?php echo $processflow_tb->progress6->ListViewValue() ?></span>
<?php } ?>
<a id="<?php echo $processflow_tb_list->PageObjName . "_row_" . $processflow_tb_list->RowCnt ?>"></a></td>
	<?php } ?>
<?php

// Render list options (body, right)
$processflow_tb_list->ListOptions->Render("body", "right", $processflow_tb_list->RowCnt);
?>
	</tr>
<?php if ($processflow_tb->RowType == EW_ROWTYPE_ADD || $processflow_tb->RowType == EW_ROWTYPE_EDIT) { ?>
<script type="text/javascript">
fprocessflow_tblist.UpdateOpts(<?php echo $processflow_tb_list->RowIndex ?>);
</script>
<?php } ?>
<?php
	}
	if ($processflow_tb->CurrentAction <> "gridadd")
		$processflow_tb_list->Recordset->MoveNext();
}
?>
</tbody>
</table>
<?php } ?>
<?php if ($processflow_tb->CurrentAction == "edit") { ?>
<input type="hidden" name="<?php echo $processflow_tb_list->FormKeyCountName ?>" id="<?php echo $processflow_tb_list->FormKeyCountName ?>" value="<?php echo $processflow_tb_list->KeyCount ?>">
<?php } ?>
<?php if ($processflow_tb->CurrentAction == "") { ?>
<input type="hidden" name="a_list" id="a_list" value="">
<?php } ?>
</div>
</form>
<?php

// Close recordset
if ($processflow_tb_list->Recordset)
	$processflow_tb_list->Recordset->Close();
?>
<?php if ($processflow_tb->Export == "") { ?>
<div class="ewGridLowerPanel">
<?php if ($processflow_tb->CurrentAction <> "gridadd" && $processflow_tb->CurrentAction <> "gridedit") { ?>
<form name="ewPagerForm" class="ewForm form-horizontal" action="<?php echo ew_CurrentPage() ?>">
<table class="ewPager">
<tr><td>
<?php if (!isset($processflow_tb_list->Pager)) $processflow_tb_list->Pager = new cNumericPager($processflow_tb_list->StartRec, $processflow_tb_list->DisplayRecs, $processflow_tb_list->TotalRecs, $processflow_tb_list->RecRange) ?>
<?php if ($processflow_tb_list->Pager->RecordCount > 0) { ?>
<table cellspacing="0" class="ewStdTable"><tbody><tr><td>
<div class="pagination"><ul>
	<?php if ($processflow_tb_list->Pager->FirstButton->Enabled) { ?>
	<li><a href="<?php echo $processflow_tb_list->PageUrl() ?>start=<?php echo $processflow_tb_list->Pager->FirstButton->Start ?>"><?php echo $Language->Phrase("PagerFirst") ?></a></li>
	<?php } ?>
	<?php if ($processflow_tb_list->Pager->PrevButton->Enabled) { ?>
	<li><a href="<?php echo $processflow_tb_list->PageUrl() ?>start=<?php echo $processflow_tb_list->Pager->PrevButton->Start ?>"><?php echo $Language->Phrase("PagerPrevious") ?></a></li>
	<?php } ?>
	<?php foreach ($processflow_tb_list->Pager->Items as $PagerItem) { ?>
		<li<?php if (!$PagerItem->Enabled) { echo " class=\" active\""; } ?>><a href="<?php if ($PagerItem->Enabled) { echo $processflow_tb_list->PageUrl() . "start=" . $PagerItem->Start; } else { echo "#"; } ?>"><?php echo $PagerItem->Text ?></a></li>
	<?php } ?>
	<?php if ($processflow_tb_list->Pager->NextButton->Enabled) { ?>
	<li><a href="<?php echo $processflow_tb_list->PageUrl() ?>start=<?php echo $processflow_tb_list->Pager->NextButton->Start ?>"><?php echo $Language->Phrase("PagerNext") ?></a></li>
	<?php } ?>
	<?php if ($processflow_tb_list->Pager->LastButton->Enabled) { ?>
	<li><a href="<?php echo $processflow_tb_list->PageUrl() ?>start=<?php echo $processflow_tb_list->Pager->LastButton->Start ?>"><?php echo $Language->Phrase("PagerLast") ?></a></li>
	<?php } ?>
</ul></div>
</td>
<td>
	<?php if ($processflow_tb_list->Pager->ButtonCount > 0) { ?>&nbsp;&nbsp;&nbsp;&nbsp;<?php } ?>
	<?php echo $Language->Phrase("Record") ?>&nbsp;<?php echo $processflow_tb_list->Pager->FromIndex ?>&nbsp;<?php echo $Language->Phrase("To") ?>&nbsp;<?php echo $processflow_tb_list->Pager->ToIndex ?>&nbsp;<?php echo $Language->Phrase("Of") ?>&nbsp;<?php echo $processflow_tb_list->Pager->RecordCount ?>
</td>
</tr></tbody></table>
<?php } else { ?>
	<?php if ($processflow_tb_list->SearchWhere == "0=101") { ?>
	<p><?php echo $Language->Phrase("EnterSearchCriteria") ?></p>
	<?php } else { ?>
	<p><?php echo $Language->Phrase("NoRecord") ?></p>
	<?php } ?>
<?php } ?>
</td>
<?php if ($processflow_tb_list->TotalRecs > 0) { ?>
<td>
	&nbsp;&nbsp;&nbsp;&nbsp;
<input type="hidden" name="t" value="processflow_tb">
<select name="<?php echo EW_TABLE_REC_PER_PAGE ?>" class="input-small" onchange="this.form.submit();">
<option value="25"<?php if ($processflow_tb_list->DisplayRecs == 25) { ?> selected="selected"<?php } ?>>25</option>
<option value="50"<?php if ($processflow_tb_list->DisplayRecs == 50) { ?> selected="selected"<?php } ?>>50</option>
<option value="100"<?php if ($processflow_tb_list->DisplayRecs == 100) { ?> selected="selected"<?php } ?>>100</option>
<option value="200"<?php if ($processflow_tb_list->DisplayRecs == 200) { ?> selected="selected"<?php } ?>>200</option>
<option value="500"<?php if ($processflow_tb_list->DisplayRecs == 500) { ?> selected="selected"<?php } ?>>500</option>
<option value="ALL"<?php if ($processflow_tb->getRecordsPerPage() == -1) { ?> selected="selected"<?php } ?>><?php echo $Language->Phrase("AllRecords") ?></option>
</select>
</td>
<?php } ?>
</tr></table>
</form>
<?php } ?>
<div class="ewListOtherOptions">
<?php
	foreach ($processflow_tb_list->OtherOptions as &$option)
		$option->Render("body", "bottom");
?>
</div>
</div>
<?php } ?>
</td></tr></table>
<?php if ($processflow_tb->Export == "") { ?>
<script type="text/javascript">
fprocessflow_tblistsrch.Init();
fprocessflow_tblist.Init();
<?php if (EW_MOBILE_REFLOW && ew_IsMobile()) { ?>
ew_Reflow();
<?php } ?>
</script>
<?php } ?>
<?php
$processflow_tb_list->ShowPageFooter();
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
$processflow_tb_list->Page_Terminate();
?>
