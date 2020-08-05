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

$personal_info_list = NULL; // Initialize page object first

class cpersonal_info_list extends cpersonal_info {

	// Page ID
	var $PageID = 'list';

	// Project ID
	var $ProjectID = "{D9B361E7-B2C1-4293-B9B3-B581986A15CC}";

	// Table name
	var $TableName = 'personal_info';

	// Page object name
	var $PageObjName = 'personal_info_list';

	// Grid form hidden field names
	var $FormName = 'fpersonal_infolist';
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

		// Table object (personal_info)
		if (!isset($GLOBALS["personal_info"])) {
			$GLOBALS["personal_info"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["personal_info"];
		}

		// Initialize URLs
		$this->ExportPrintUrl = $this->PageUrl() . "export=print";
		$this->ExportExcelUrl = $this->PageUrl() . "export=excel";
		$this->ExportWordUrl = $this->PageUrl() . "export=word";
		$this->ExportHtmlUrl = $this->PageUrl() . "export=html";
		$this->ExportXmlUrl = $this->PageUrl() . "export=xml";
		$this->ExportCsvUrl = $this->PageUrl() . "export=csv";
		$this->ExportPdfUrl = $this->PageUrl() . "export=pdf";
		$this->AddUrl = "personal_infoadd.php?" . EW_TABLE_SHOW_DETAIL . "=";
		$this->InlineAddUrl = $this->PageUrl() . "a=add";
		$this->GridAddUrl = $this->PageUrl() . "a=gridadd";
		$this->GridEditUrl = $this->PageUrl() . "a=gridedit";
		$this->MultiDeleteUrl = "personal_infodelete.php";
		$this->MultiUpdateUrl = "personal_infoupdate.php";

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
			define("EW_PAGE_ID", 'list', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'personal_info', TRUE);

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

			// Set up master detail parameters
			$this->SetUpMasterParms();

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

		// Restore master/detail filter
		$this->DbMasterFilter = $this->GetMasterFilter(); // Restore master filter
		$this->DbDetailFilter = $this->GetDetailFilter(); // Restore detail filter
		ew_AddFilter($sFilter, $this->DbDetailFilter);
		ew_AddFilter($sFilter, $this->SearchWhere);

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
		$this->BuildBasicSearchSQL($sWhere, $this->salutation, $Keyword);
		$this->BuildBasicSearchSQL($sWhere, $this->fname, $Keyword);
		$this->BuildBasicSearchSQL($sWhere, $this->mname, $Keyword);
		$this->BuildBasicSearchSQL($sWhere, $this->lname, $Keyword);
		$this->BuildBasicSearchSQL($sWhere, $this->phone, $Keyword);
		$this->BuildBasicSearchSQL($sWhere, $this->aphone, $Keyword);
		$this->BuildBasicSearchSQL($sWhere, $this->msg, $Keyword);
		$this->BuildBasicSearchSQL($sWhere, $this->city, $Keyword);
		$this->BuildBasicSearchSQL($sWhere, $this->rstate, $Keyword);
		$this->BuildBasicSearchSQL($sWhere, $this->dob, $Keyword);
		$this->BuildBasicSearchSQL($sWhere, $this->gender, $Keyword);
		$this->BuildBasicSearchSQL($sWhere, $this->lga, $Keyword);
		$this->BuildBasicSearchSQL($sWhere, $this->nationality, $Keyword);
		$this->BuildBasicSearchSQL($sWhere, $this->state, $Keyword);
		$this->BuildBasicSearchSQL($sWhere, $this->employment_status, $Keyword);
		$this->BuildBasicSearchSQL($sWhere, $this->employer, $Keyword);
		$this->BuildBasicSearchSQL($sWhere, $this->employerphone, $Keyword);
		$this->BuildBasicSearchSQL($sWhere, $this->employeraddr, $Keyword);
		$this->BuildBasicSearchSQL($sWhere, $this->maidenname, $Keyword);
		$this->BuildBasicSearchSQL($sWhere, $this->passport, $Keyword);
		$this->BuildBasicSearchSQL($sWhere, $this->identification_type, $Keyword);
		$this->BuildBasicSearchSQL($sWhere, $this->identification_number, $Keyword);
		$this->BuildBasicSearchSQL($sWhere, $this->issuedplace, $Keyword);
		$this->BuildBasicSearchSQL($sWhere, $this->earning_type, $Keyword);
		$this->BuildBasicSearchSQL($sWhere, $this->earning_note, $Keyword);
		$this->BuildBasicSearchSQL($sWhere, $this->annual_income, $Keyword);
		$this->BuildBasicSearchSQL($sWhere, $this->nameofcompany, $Keyword);
		$this->BuildBasicSearchSQL($sWhere, $this->company_telephone, $Keyword);
		$this->BuildBasicSearchSQL($sWhere, $this->company_email, $Keyword);
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
			$this->UpdateSort($this->salutation, $bCtrl); // salutation
			$this->UpdateSort($this->fname, $bCtrl); // fname
			$this->UpdateSort($this->mname, $bCtrl); // mname
			$this->UpdateSort($this->lname, $bCtrl); // lname
			$this->UpdateSort($this->phone, $bCtrl); // phone
			$this->UpdateSort($this->aphone, $bCtrl); // aphone
			$this->UpdateSort($this->rstate, $bCtrl); // rstate
			$this->UpdateSort($this->gender, $bCtrl); // gender
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
			}

			// Reset sorting order
			if ($this->Command == "resetsort") {
				$sOrderBy = "";
				$this->setSessionOrderBy($sOrderBy);
				$this->salutation->setSort("");
				$this->fname->setSort("");
				$this->mname->setSort("");
				$this->lname->setSort("");
				$this->phone->setSort("");
				$this->aphone->setSort("");
				$this->rstate->setSort("");
				$this->gender->setSort("");
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
		$item->Visible = FALSE;
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
		$DetailViewTblVar = "";
		$DetailCopyTblVar = "";
		$DetailEditTblVar = "";

		// "detail_spouse_tb"
		$oListOpt = &$this->ListOptions->Items["detail_spouse_tb"];
		if ($Security->IsLoggedIn()) {
			$body = $Language->Phrase("DetailLink") . $Language->TablePhrase("spouse_tb", "TblCaption");
			$body = "<a class=\"btn btn-small ewRowLink ewDetailList\" data-action=\"list\" href=\"" . ew_HtmlEncode("spouse_tblist.php?" . EW_TABLE_SHOW_MASTER . "=personal_info&uid=" . strval($this->uid->CurrentValue) . "") . "\">" . $body . "</a>";
			$links = "";
			if ($GLOBALS["spouse_tb_grid"]->DetailView && $Security->IsLoggedIn() && $Security->IsLoggedIn()) {
				$links .= "<li><a class=\"ewRowLink ewDetailView\" data-action=\"view\" href=\"" . ew_HtmlEncode($this->GetViewUrl(EW_TABLE_SHOW_DETAIL . "=spouse_tb")) . "\">" . $Language->Phrase("MasterDetailViewLink") . "</a></li>";
				if ($DetailViewTblVar <> "") $DetailViewTblVar .= ",";
				$DetailViewTblVar .= "spouse_tb";
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
			$body = "<a class=\"btn btn-small ewRowLink ewDetailList\" data-action=\"list\" href=\"" . ew_HtmlEncode("divorce_tblist.php?" . EW_TABLE_SHOW_MASTER . "=personal_info&uid=" . strval($this->uid->CurrentValue) . "") . "\">" . $body . "</a>";
			$links = "";
			if ($GLOBALS["divorce_tb_grid"]->DetailView && $Security->IsLoggedIn() && $Security->IsLoggedIn()) {
				$links .= "<li><a class=\"ewRowLink ewDetailView\" data-action=\"view\" href=\"" . ew_HtmlEncode($this->GetViewUrl(EW_TABLE_SHOW_DETAIL . "=divorce_tb")) . "\">" . $Language->Phrase("MasterDetailViewLink") . "</a></li>";
				if ($DetailViewTblVar <> "") $DetailViewTblVar .= ",";
				$DetailViewTblVar .= "divorce_tb";
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
			$body = "<a class=\"btn btn-small ewRowLink ewDetailList\" data-action=\"list\" href=\"" . ew_HtmlEncode("children_detailslist.php?" . EW_TABLE_SHOW_MASTER . "=personal_info&uid=" . strval($this->uid->CurrentValue) . "") . "\">" . $body . "</a>";
			$links = "";
			if ($GLOBALS["children_details_grid"]->DetailView && $Security->IsLoggedIn() && $Security->IsLoggedIn()) {
				$links .= "<li><a class=\"ewRowLink ewDetailView\" data-action=\"view\" href=\"" . ew_HtmlEncode($this->GetViewUrl(EW_TABLE_SHOW_DETAIL . "=children_details")) . "\">" . $Language->Phrase("MasterDetailViewLink") . "</a></li>";
				if ($DetailViewTblVar <> "") $DetailViewTblVar .= ",";
				$DetailViewTblVar .= "children_details";
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
			$body = "<a class=\"btn btn-small ewRowLink ewDetailList\" data-action=\"list\" href=\"" . ew_HtmlEncode("beneficiary_dumplist.php?" . EW_TABLE_SHOW_MASTER . "=personal_info&uid=" . strval($this->uid->CurrentValue) . "") . "\">" . $body . "</a>";
			$links = "";
			if ($GLOBALS["beneficiary_dump_grid"]->DetailView && $Security->IsLoggedIn() && $Security->IsLoggedIn()) {
				$links .= "<li><a class=\"ewRowLink ewDetailView\" data-action=\"view\" href=\"" . ew_HtmlEncode($this->GetViewUrl(EW_TABLE_SHOW_DETAIL . "=beneficiary_dump")) . "\">" . $Language->Phrase("MasterDetailViewLink") . "</a></li>";
				if ($DetailViewTblVar <> "") $DetailViewTblVar .= ",";
				$DetailViewTblVar .= "beneficiary_dump";
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
			$body = "<a class=\"btn btn-small ewRowLink ewDetailList\" data-action=\"list\" href=\"" . ew_HtmlEncode("alt_beneficiarylist.php?" . EW_TABLE_SHOW_MASTER . "=personal_info&uid=" . strval($this->uid->CurrentValue) . "") . "\">" . $body . "</a>";
			$links = "";
			if ($GLOBALS["alt_beneficiary_grid"]->DetailView && $Security->IsLoggedIn() && $Security->IsLoggedIn()) {
				$links .= "<li><a class=\"ewRowLink ewDetailView\" data-action=\"view\" href=\"" . ew_HtmlEncode($this->GetViewUrl(EW_TABLE_SHOW_DETAIL . "=alt_beneficiary")) . "\">" . $Language->Phrase("MasterDetailViewLink") . "</a></li>";
				if ($DetailViewTblVar <> "") $DetailViewTblVar .= ",";
				$DetailViewTblVar .= "alt_beneficiary";
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
			$body = "<a class=\"btn btn-small ewRowLink ewDetailList\" data-action=\"list\" href=\"" . ew_HtmlEncode("assets_tblist.php?" . EW_TABLE_SHOW_MASTER . "=personal_info&uid=" . strval($this->uid->CurrentValue) . "") . "\">" . $body . "</a>";
			$links = "";
			if ($GLOBALS["assets_tb_grid"]->DetailView && $Security->IsLoggedIn() && $Security->IsLoggedIn()) {
				$links .= "<li><a class=\"ewRowLink ewDetailView\" data-action=\"view\" href=\"" . ew_HtmlEncode($this->GetViewUrl(EW_TABLE_SHOW_DETAIL . "=assets_tb")) . "\">" . $Language->Phrase("MasterDetailViewLink") . "</a></li>";
				if ($DetailViewTblVar <> "") $DetailViewTblVar .= ",";
				$DetailViewTblVar .= "assets_tb";
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
			$body = "<a class=\"btn btn-small ewRowLink ewDetailList\" data-action=\"list\" href=\"" . ew_HtmlEncode("overall_assetlist.php?" . EW_TABLE_SHOW_MASTER . "=personal_info&uid=" . strval($this->uid->CurrentValue) . "") . "\">" . $body . "</a>";
			$links = "";
			if ($GLOBALS["overall_asset_grid"]->DetailView && $Security->IsLoggedIn() && $Security->IsLoggedIn()) {
				$links .= "<li><a class=\"ewRowLink ewDetailView\" data-action=\"view\" href=\"" . ew_HtmlEncode($this->GetViewUrl(EW_TABLE_SHOW_DETAIL . "=overall_asset")) . "\">" . $Language->Phrase("MasterDetailViewLink") . "</a></li>";
				if ($DetailViewTblVar <> "") $DetailViewTblVar .= ",";
				$DetailViewTblVar .= "overall_asset";
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
			$body = "<a class=\"btn btn-small ewRowLink ewDetailList\" data-action=\"list\" href=\"" . ew_HtmlEncode("executor_tblist.php?" . EW_TABLE_SHOW_MASTER . "=personal_info&uid=" . strval($this->uid->CurrentValue) . "") . "\">" . $body . "</a>";
			$links = "";
			if ($GLOBALS["executor_tb_grid"]->DetailView && $Security->IsLoggedIn() && $Security->IsLoggedIn()) {
				$links .= "<li><a class=\"ewRowLink ewDetailView\" data-action=\"view\" href=\"" . ew_HtmlEncode($this->GetViewUrl(EW_TABLE_SHOW_DETAIL . "=executor_tb")) . "\">" . $Language->Phrase("MasterDetailViewLink") . "</a></li>";
				if ($DetailViewTblVar <> "") $DetailViewTblVar .= ",";
				$DetailViewTblVar .= "executor_tb";
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
			$body = "<a class=\"btn btn-small ewRowLink ewDetailList\" data-action=\"list\" href=\"" . ew_HtmlEncode("trustee_tblist.php?" . EW_TABLE_SHOW_MASTER . "=personal_info&uid=" . strval($this->uid->CurrentValue) . "") . "\">" . $body . "</a>";
			$links = "";
			if ($GLOBALS["trustee_tb_grid"]->DetailView && $Security->IsLoggedIn() && $Security->IsLoggedIn()) {
				$links .= "<li><a class=\"ewRowLink ewDetailView\" data-action=\"view\" href=\"" . ew_HtmlEncode($this->GetViewUrl(EW_TABLE_SHOW_DETAIL . "=trustee_tb")) . "\">" . $Language->Phrase("MasterDetailViewLink") . "</a></li>";
				if ($DetailViewTblVar <> "") $DetailViewTblVar .= ",";
				$DetailViewTblVar .= "trustee_tb";
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
			$body = "<a class=\"btn btn-small ewRowLink ewDetailList\" data-action=\"list\" href=\"" . ew_HtmlEncode("witness_tblist.php?" . EW_TABLE_SHOW_MASTER . "=personal_info&uid=" . strval($this->uid->CurrentValue) . "") . "\">" . $body . "</a>";
			$links = "";
			if ($GLOBALS["witness_tb_grid"]->DetailView && $Security->IsLoggedIn() && $Security->IsLoggedIn()) {
				$links .= "<li><a class=\"ewRowLink ewDetailView\" data-action=\"view\" href=\"" . ew_HtmlEncode($this->GetViewUrl(EW_TABLE_SHOW_DETAIL . "=witness_tb")) . "\">" . $Language->Phrase("MasterDetailViewLink") . "</a></li>";
				if ($DetailViewTblVar <> "") $DetailViewTblVar .= ",";
				$DetailViewTblVar .= "witness_tb";
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
			$body = "<a class=\"btn btn-small ewRowLink ewDetailList\" data-action=\"list\" href=\"" . ew_HtmlEncode("addinfo_tblist.php?" . EW_TABLE_SHOW_MASTER . "=personal_info&uid=" . strval($this->uid->CurrentValue) . "") . "\">" . $body . "</a>";
			$links = "";
			if ($GLOBALS["addinfo_tb_grid"]->DetailView && $Security->IsLoggedIn() && $Security->IsLoggedIn()) {
				$links .= "<li><a class=\"ewRowLink ewDetailView\" data-action=\"view\" href=\"" . ew_HtmlEncode($this->GetViewUrl(EW_TABLE_SHOW_DETAIL . "=addinfo_tb")) . "\">" . $Language->Phrase("MasterDetailViewLink") . "</a></li>";
				if ($DetailViewTblVar <> "") $DetailViewTblVar .= ",";
				$DetailViewTblVar .= "addinfo_tb";
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
		$option = $options["action"];

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
				$item->Body = "<a class=\"ewAction ewCustomAction\" href=\"\" onclick=\"ew_SubmitSelected(document.fpersonal_infolist, '" . ew_CurrentUrl() . "', null, '" . $action . "');return false;\">" . $name . "</a>";
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

		// Column "detail_spouse_tb"
		$link = "";
		$option = &$this->ListOptions->Items["detail_spouse_tb"];
		$url = "spouse_tbpreview.php?f=" . ew_Encrypt($sSqlWrk);
		$btngrp = "<div data-table=\"spouse_tb\" data-url=\"" . $url . "\" class=\"btn-group\">";
		if ($Security->IsLoggedIn()) {			
			$label = $Language->TablePhrase("spouse_tb", "TblCaption");
			$link = "<li><a href=\"#\" data-toggle=\"tab\" data-table=\"spouse_tb\" data-url=\"" . $url . "\">" . $label . "</a></li>";			
			$links .= $link;
			$detaillnk = ew_JsEncode3("spouse_tblist.php?" . EW_TABLE_SHOW_MASTER . "=personal_info&uid=" . urlencode(strval($this->uid->CurrentValue)) . "");
			$btngrp .= "<button type=\"button\" class=\"btn btn-small\" onclick=\"window.location='" . $detaillnk . "'\">" . $Language->TablePhrase("spouse_tb", "TblCaption") . "</button>";
		}
		if ($GLOBALS["spouse_tb_grid"]->DetailView && $Security->IsLoggedIn() && $Security->IsLoggedIn())
			$btngrp .= "<button type=\"button\" class=\"btn btn-small\" onclick=\"window.location='" . $this->GetViewUrl(EW_TABLE_SHOW_DETAIL . "=spouse_tb") . "'\">" . $Language->Phrase("MasterDetailViewLink") . "</button>";
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
			$detaillnk = ew_JsEncode3("divorce_tblist.php?" . EW_TABLE_SHOW_MASTER . "=personal_info&uid=" . urlencode(strval($this->uid->CurrentValue)) . "");
			$btngrp .= "<button type=\"button\" class=\"btn btn-small\" onclick=\"window.location='" . $detaillnk . "'\">" . $Language->TablePhrase("divorce_tb", "TblCaption") . "</button>";
		}
		if ($GLOBALS["divorce_tb_grid"]->DetailView && $Security->IsLoggedIn() && $Security->IsLoggedIn())
			$btngrp .= "<button type=\"button\" class=\"btn btn-small\" onclick=\"window.location='" . $this->GetViewUrl(EW_TABLE_SHOW_DETAIL . "=divorce_tb") . "'\">" . $Language->Phrase("MasterDetailViewLink") . "</button>";
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
			$detaillnk = ew_JsEncode3("children_detailslist.php?" . EW_TABLE_SHOW_MASTER . "=personal_info&uid=" . urlencode(strval($this->uid->CurrentValue)) . "");
			$btngrp .= "<button type=\"button\" class=\"btn btn-small\" onclick=\"window.location='" . $detaillnk . "'\">" . $Language->TablePhrase("children_details", "TblCaption") . "</button>";
		}
		if ($GLOBALS["children_details_grid"]->DetailView && $Security->IsLoggedIn() && $Security->IsLoggedIn())
			$btngrp .= "<button type=\"button\" class=\"btn btn-small\" onclick=\"window.location='" . $this->GetViewUrl(EW_TABLE_SHOW_DETAIL . "=children_details") . "'\">" . $Language->Phrase("MasterDetailViewLink") . "</button>";
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
			$detaillnk = ew_JsEncode3("beneficiary_dumplist.php?" . EW_TABLE_SHOW_MASTER . "=personal_info&uid=" . urlencode(strval($this->uid->CurrentValue)) . "");
			$btngrp .= "<button type=\"button\" class=\"btn btn-small\" onclick=\"window.location='" . $detaillnk . "'\">" . $Language->TablePhrase("beneficiary_dump", "TblCaption") . "</button>";
		}
		if ($GLOBALS["beneficiary_dump_grid"]->DetailView && $Security->IsLoggedIn() && $Security->IsLoggedIn())
			$btngrp .= "<button type=\"button\" class=\"btn btn-small\" onclick=\"window.location='" . $this->GetViewUrl(EW_TABLE_SHOW_DETAIL . "=beneficiary_dump") . "'\">" . $Language->Phrase("MasterDetailViewLink") . "</button>";
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
			$detaillnk = ew_JsEncode3("alt_beneficiarylist.php?" . EW_TABLE_SHOW_MASTER . "=personal_info&uid=" . urlencode(strval($this->uid->CurrentValue)) . "");
			$btngrp .= "<button type=\"button\" class=\"btn btn-small\" onclick=\"window.location='" . $detaillnk . "'\">" . $Language->TablePhrase("alt_beneficiary", "TblCaption") . "</button>";
		}
		if ($GLOBALS["alt_beneficiary_grid"]->DetailView && $Security->IsLoggedIn() && $Security->IsLoggedIn())
			$btngrp .= "<button type=\"button\" class=\"btn btn-small\" onclick=\"window.location='" . $this->GetViewUrl(EW_TABLE_SHOW_DETAIL . "=alt_beneficiary") . "'\">" . $Language->Phrase("MasterDetailViewLink") . "</button>";
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
			$detaillnk = ew_JsEncode3("assets_tblist.php?" . EW_TABLE_SHOW_MASTER . "=personal_info&uid=" . urlencode(strval($this->uid->CurrentValue)) . "");
			$btngrp .= "<button type=\"button\" class=\"btn btn-small\" onclick=\"window.location='" . $detaillnk . "'\">" . $Language->TablePhrase("assets_tb", "TblCaption") . "</button>";
		}
		if ($GLOBALS["assets_tb_grid"]->DetailView && $Security->IsLoggedIn() && $Security->IsLoggedIn())
			$btngrp .= "<button type=\"button\" class=\"btn btn-small\" onclick=\"window.location='" . $this->GetViewUrl(EW_TABLE_SHOW_DETAIL . "=assets_tb") . "'\">" . $Language->Phrase("MasterDetailViewLink") . "</button>";
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
			$detaillnk = ew_JsEncode3("overall_assetlist.php?" . EW_TABLE_SHOW_MASTER . "=personal_info&uid=" . urlencode(strval($this->uid->CurrentValue)) . "");
			$btngrp .= "<button type=\"button\" class=\"btn btn-small\" onclick=\"window.location='" . $detaillnk . "'\">" . $Language->TablePhrase("overall_asset", "TblCaption") . "</button>";
		}
		if ($GLOBALS["overall_asset_grid"]->DetailView && $Security->IsLoggedIn() && $Security->IsLoggedIn())
			$btngrp .= "<button type=\"button\" class=\"btn btn-small\" onclick=\"window.location='" . $this->GetViewUrl(EW_TABLE_SHOW_DETAIL . "=overall_asset") . "'\">" . $Language->Phrase("MasterDetailViewLink") . "</button>";
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
			$detaillnk = ew_JsEncode3("executor_tblist.php?" . EW_TABLE_SHOW_MASTER . "=personal_info&uid=" . urlencode(strval($this->uid->CurrentValue)) . "");
			$btngrp .= "<button type=\"button\" class=\"btn btn-small\" onclick=\"window.location='" . $detaillnk . "'\">" . $Language->TablePhrase("executor_tb", "TblCaption") . "</button>";
		}
		if ($GLOBALS["executor_tb_grid"]->DetailView && $Security->IsLoggedIn() && $Security->IsLoggedIn())
			$btngrp .= "<button type=\"button\" class=\"btn btn-small\" onclick=\"window.location='" . $this->GetViewUrl(EW_TABLE_SHOW_DETAIL . "=executor_tb") . "'\">" . $Language->Phrase("MasterDetailViewLink") . "</button>";
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
			$detaillnk = ew_JsEncode3("trustee_tblist.php?" . EW_TABLE_SHOW_MASTER . "=personal_info&uid=" . urlencode(strval($this->uid->CurrentValue)) . "");
			$btngrp .= "<button type=\"button\" class=\"btn btn-small\" onclick=\"window.location='" . $detaillnk . "'\">" . $Language->TablePhrase("trustee_tb", "TblCaption") . "</button>";
		}
		if ($GLOBALS["trustee_tb_grid"]->DetailView && $Security->IsLoggedIn() && $Security->IsLoggedIn())
			$btngrp .= "<button type=\"button\" class=\"btn btn-small\" onclick=\"window.location='" . $this->GetViewUrl(EW_TABLE_SHOW_DETAIL . "=trustee_tb") . "'\">" . $Language->Phrase("MasterDetailViewLink") . "</button>";
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
			$detaillnk = ew_JsEncode3("witness_tblist.php?" . EW_TABLE_SHOW_MASTER . "=personal_info&uid=" . urlencode(strval($this->uid->CurrentValue)) . "");
			$btngrp .= "<button type=\"button\" class=\"btn btn-small\" onclick=\"window.location='" . $detaillnk . "'\">" . $Language->TablePhrase("witness_tb", "TblCaption") . "</button>";
		}
		if ($GLOBALS["witness_tb_grid"]->DetailView && $Security->IsLoggedIn() && $Security->IsLoggedIn())
			$btngrp .= "<button type=\"button\" class=\"btn btn-small\" onclick=\"window.location='" . $this->GetViewUrl(EW_TABLE_SHOW_DETAIL . "=witness_tb") . "'\">" . $Language->Phrase("MasterDetailViewLink") . "</button>";
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
			$detaillnk = ew_JsEncode3("addinfo_tblist.php?" . EW_TABLE_SHOW_MASTER . "=personal_info&uid=" . urlencode(strval($this->uid->CurrentValue)) . "");
			$btngrp .= "<button type=\"button\" class=\"btn btn-small\" onclick=\"window.location='" . $detaillnk . "'\">" . $Language->TablePhrase("addinfo_tb", "TblCaption") . "</button>";
		}
		if ($GLOBALS["addinfo_tb_grid"]->DetailView && $Security->IsLoggedIn() && $Security->IsLoggedIn())
			$btngrp .= "<button type=\"button\" class=\"btn btn-small\" onclick=\"window.location='" . $this->GetViewUrl(EW_TABLE_SHOW_DETAIL . "=addinfo_tb") . "'\">" . $Language->Phrase("MasterDetailViewLink") . "</button>";
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

	// Load default values
	function LoadDefaultValues() {
		$this->salutation->CurrentValue = NULL;
		$this->salutation->OldValue = $this->salutation->CurrentValue;
		$this->fname->CurrentValue = NULL;
		$this->fname->OldValue = $this->fname->CurrentValue;
		$this->mname->CurrentValue = NULL;
		$this->mname->OldValue = $this->mname->CurrentValue;
		$this->lname->CurrentValue = NULL;
		$this->lname->OldValue = $this->lname->CurrentValue;
		$this->phone->CurrentValue = NULL;
		$this->phone->OldValue = $this->phone->CurrentValue;
		$this->aphone->CurrentValue = NULL;
		$this->aphone->OldValue = $this->aphone->CurrentValue;
		$this->rstate->CurrentValue = NULL;
		$this->rstate->OldValue = $this->rstate->CurrentValue;
		$this->gender->CurrentValue = NULL;
		$this->gender->OldValue = $this->gender->CurrentValue;
		$this->datecreated->CurrentValue = NULL;
		$this->datecreated->OldValue = $this->datecreated->CurrentValue;
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
		if (!$this->salutation->FldIsDetailKey) {
			$this->salutation->setFormValue($objForm->GetValue("x_salutation"));
		}
		if (!$this->fname->FldIsDetailKey) {
			$this->fname->setFormValue($objForm->GetValue("x_fname"));
		}
		if (!$this->mname->FldIsDetailKey) {
			$this->mname->setFormValue($objForm->GetValue("x_mname"));
		}
		if (!$this->lname->FldIsDetailKey) {
			$this->lname->setFormValue($objForm->GetValue("x_lname"));
		}
		if (!$this->phone->FldIsDetailKey) {
			$this->phone->setFormValue($objForm->GetValue("x_phone"));
		}
		if (!$this->aphone->FldIsDetailKey) {
			$this->aphone->setFormValue($objForm->GetValue("x_aphone"));
		}
		if (!$this->rstate->FldIsDetailKey) {
			$this->rstate->setFormValue($objForm->GetValue("x_rstate"));
		}
		if (!$this->gender->FldIsDetailKey) {
			$this->gender->setFormValue($objForm->GetValue("x_gender"));
		}
		if (!$this->datecreated->FldIsDetailKey) {
			$this->datecreated->setFormValue($objForm->GetValue("x_datecreated"));
			$this->datecreated->CurrentValue = ew_UnFormatDateTime($this->datecreated->CurrentValue, 0);
		}
		if (!$this->id->FldIsDetailKey && $this->CurrentAction <> "gridadd" && $this->CurrentAction <> "add")
			$this->id->setFormValue($objForm->GetValue("x_id"));
	}

	// Restore form values
	function RestoreFormValues() {
		global $objForm;
		if ($this->CurrentAction <> "gridadd" && $this->CurrentAction <> "add")
			$this->id->CurrentValue = $this->id->FormValue;
		$this->salutation->CurrentValue = $this->salutation->FormValue;
		$this->fname->CurrentValue = $this->fname->FormValue;
		$this->mname->CurrentValue = $this->mname->FormValue;
		$this->lname->CurrentValue = $this->lname->FormValue;
		$this->phone->CurrentValue = $this->phone->FormValue;
		$this->aphone->CurrentValue = $this->aphone->FormValue;
		$this->rstate->CurrentValue = $this->rstate->FormValue;
		$this->gender->CurrentValue = $this->gender->FormValue;
		$this->datecreated->CurrentValue = $this->datecreated->FormValue;
		$this->datecreated->CurrentValue = ew_UnFormatDateTime($this->datecreated->CurrentValue, 0);
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

			// rstate
			$this->rstate->LinkCustomAttributes = "";
			$this->rstate->HrefValue = "";
			$this->rstate->TooltipValue = "";

			// gender
			$this->gender->LinkCustomAttributes = "";
			$this->gender->HrefValue = "";
			$this->gender->TooltipValue = "";

			// datecreated
			$this->datecreated->LinkCustomAttributes = "";
			$this->datecreated->HrefValue = "";
			$this->datecreated->TooltipValue = "";
		} elseif ($this->RowType == EW_ROWTYPE_ADD) { // Add row

			// salutation
			$this->salutation->EditCustomAttributes = "style='width:97%' ";
			$this->salutation->EditValue = ew_HtmlEncode($this->salutation->CurrentValue);
			$this->salutation->PlaceHolder = ew_HtmlEncode(ew_RemoveHtml($this->salutation->FldCaption()));

			// fname
			$this->fname->EditCustomAttributes = "style='width:97%' ";
			$this->fname->EditValue = ew_HtmlEncode($this->fname->CurrentValue);
			$this->fname->PlaceHolder = ew_HtmlEncode(ew_RemoveHtml($this->fname->FldCaption()));

			// mname
			$this->mname->EditCustomAttributes = "style='width:97%' ";
			$this->mname->EditValue = ew_HtmlEncode($this->mname->CurrentValue);
			$this->mname->PlaceHolder = ew_HtmlEncode(ew_RemoveHtml($this->mname->FldCaption()));

			// lname
			$this->lname->EditCustomAttributes = "";
			$this->lname->EditValue = ew_HtmlEncode($this->lname->CurrentValue);
			$this->lname->PlaceHolder = ew_HtmlEncode(ew_RemoveHtml($this->lname->FldCaption()));

			// phone
			$this->phone->EditCustomAttributes = "style='width:97%' ";
			$this->phone->EditValue = ew_HtmlEncode($this->phone->CurrentValue);
			$this->phone->PlaceHolder = ew_HtmlEncode(ew_RemoveHtml($this->phone->FldCaption()));

			// aphone
			$this->aphone->EditCustomAttributes = "style='width:97%' ";
			$this->aphone->EditValue = ew_HtmlEncode($this->aphone->CurrentValue);
			$this->aphone->PlaceHolder = ew_HtmlEncode(ew_RemoveHtml($this->aphone->FldCaption()));

			// rstate
			$this->rstate->EditCustomAttributes = "style='width:97%' ";
			$this->rstate->EditValue = ew_HtmlEncode($this->rstate->CurrentValue);
			$this->rstate->PlaceHolder = ew_HtmlEncode(ew_RemoveHtml($this->rstate->FldCaption()));

			// gender
			$this->gender->EditCustomAttributes = "style='width:97%' ";
			$this->gender->EditValue = ew_HtmlEncode($this->gender->CurrentValue);
			$this->gender->PlaceHolder = ew_HtmlEncode(ew_RemoveHtml($this->gender->FldCaption()));

			// datecreated
			$this->datecreated->EditCustomAttributes = "";
			$this->datecreated->EditValue = ew_HtmlEncode($this->datecreated->CurrentValue);
			$this->datecreated->PlaceHolder = ew_HtmlEncode(ew_RemoveHtml($this->datecreated->FldCaption()));

			// Edit refer script
			// salutation

			$this->salutation->HrefValue = "";

			// fname
			$this->fname->HrefValue = "";

			// mname
			$this->mname->HrefValue = "";

			// lname
			$this->lname->HrefValue = "";

			// phone
			$this->phone->HrefValue = "";

			// aphone
			$this->aphone->HrefValue = "";

			// rstate
			$this->rstate->HrefValue = "";

			// gender
			$this->gender->HrefValue = "";

			// datecreated
			$this->datecreated->HrefValue = "";
		} elseif ($this->RowType == EW_ROWTYPE_EDIT) { // Edit row

			// salutation
			$this->salutation->EditCustomAttributes = "style='width:97%' ";
			$this->salutation->EditValue = ew_HtmlEncode($this->salutation->CurrentValue);
			$this->salutation->PlaceHolder = ew_HtmlEncode(ew_RemoveHtml($this->salutation->FldCaption()));

			// fname
			$this->fname->EditCustomAttributes = "style='width:97%' ";
			$this->fname->EditValue = ew_HtmlEncode($this->fname->CurrentValue);
			$this->fname->PlaceHolder = ew_HtmlEncode(ew_RemoveHtml($this->fname->FldCaption()));

			// mname
			$this->mname->EditCustomAttributes = "style='width:97%' ";
			$this->mname->EditValue = ew_HtmlEncode($this->mname->CurrentValue);
			$this->mname->PlaceHolder = ew_HtmlEncode(ew_RemoveHtml($this->mname->FldCaption()));

			// lname
			$this->lname->EditCustomAttributes = "";
			$this->lname->EditValue = ew_HtmlEncode($this->lname->CurrentValue);
			$this->lname->PlaceHolder = ew_HtmlEncode(ew_RemoveHtml($this->lname->FldCaption()));

			// phone
			$this->phone->EditCustomAttributes = "style='width:97%' ";
			$this->phone->EditValue = ew_HtmlEncode($this->phone->CurrentValue);
			$this->phone->PlaceHolder = ew_HtmlEncode(ew_RemoveHtml($this->phone->FldCaption()));

			// aphone
			$this->aphone->EditCustomAttributes = "style='width:97%' ";
			$this->aphone->EditValue = ew_HtmlEncode($this->aphone->CurrentValue);
			$this->aphone->PlaceHolder = ew_HtmlEncode(ew_RemoveHtml($this->aphone->FldCaption()));

			// rstate
			$this->rstate->EditCustomAttributes = "style='width:97%' ";
			$this->rstate->EditValue = ew_HtmlEncode($this->rstate->CurrentValue);
			$this->rstate->PlaceHolder = ew_HtmlEncode(ew_RemoveHtml($this->rstate->FldCaption()));

			// gender
			$this->gender->EditCustomAttributes = "style='width:97%' ";
			$this->gender->EditValue = ew_HtmlEncode($this->gender->CurrentValue);
			$this->gender->PlaceHolder = ew_HtmlEncode(ew_RemoveHtml($this->gender->FldCaption()));

			// datecreated
			$this->datecreated->EditCustomAttributes = "";
			$this->datecreated->EditValue = ew_HtmlEncode($this->datecreated->CurrentValue);
			$this->datecreated->PlaceHolder = ew_HtmlEncode(ew_RemoveHtml($this->datecreated->FldCaption()));

			// Edit refer script
			// salutation

			$this->salutation->HrefValue = "";

			// fname
			$this->fname->HrefValue = "";

			// mname
			$this->mname->HrefValue = "";

			// lname
			$this->lname->HrefValue = "";

			// phone
			$this->phone->HrefValue = "";

			// aphone
			$this->aphone->HrefValue = "";

			// rstate
			$this->rstate->HrefValue = "";

			// gender
			$this->gender->HrefValue = "";

			// datecreated
			$this->datecreated->HrefValue = "";
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
		if (!$this->salutation->FldIsDetailKey && !is_null($this->salutation->FormValue) && $this->salutation->FormValue == "") {
			ew_AddMessage($gsFormError, $Language->Phrase("EnterRequiredField") . " - " . $this->salutation->FldCaption());
		}
		if (!$this->datecreated->FldIsDetailKey && !is_null($this->datecreated->FormValue) && $this->datecreated->FormValue == "") {
			ew_AddMessage($gsFormError, $Language->Phrase("EnterRequiredField") . " - " . $this->datecreated->FldCaption());
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
			$rsnew = array();

			// salutation
			$this->salutation->SetDbValueDef($rsnew, $this->salutation->CurrentValue, NULL, $this->salutation->ReadOnly);

			// fname
			$this->fname->SetDbValueDef($rsnew, $this->fname->CurrentValue, NULL, $this->fname->ReadOnly);

			// mname
			$this->mname->SetDbValueDef($rsnew, $this->mname->CurrentValue, NULL, $this->mname->ReadOnly);

			// lname
			$this->lname->SetDbValueDef($rsnew, $this->lname->CurrentValue, NULL, $this->lname->ReadOnly);

			// phone
			$this->phone->SetDbValueDef($rsnew, $this->phone->CurrentValue, NULL, $this->phone->ReadOnly);

			// aphone
			$this->aphone->SetDbValueDef($rsnew, $this->aphone->CurrentValue, NULL, $this->aphone->ReadOnly);

			// rstate
			$this->rstate->SetDbValueDef($rsnew, $this->rstate->CurrentValue, NULL, $this->rstate->ReadOnly);

			// gender
			$this->gender->SetDbValueDef($rsnew, $this->gender->CurrentValue, NULL, $this->gender->ReadOnly);

			// datecreated
			$this->datecreated->SetDbValueDef($rsnew, $this->datecreated->CurrentValue, NULL, $this->datecreated->ReadOnly);

			// Check referential integrity for master table 'comprehensivewill_tb'
			$bValidMasterRecord = TRUE;
			$sMasterFilter = $this->SqlMasterFilter_comprehensivewill_tb();
			$KeyValue = isset($rsnew['uid']) ? $rsnew['uid'] : $rsold['uid'];
			if (strval($KeyValue) <> "") {
				$sMasterFilter = str_replace("@uid@", ew_AdjustSql($KeyValue), $sMasterFilter);
			} else {
				$bValidMasterRecord = FALSE;
			}
			if ($bValidMasterRecord) {
				$rsmaster = $GLOBALS["comprehensivewill_tb"]->LoadRs($sMasterFilter);
				$bValidMasterRecord = ($rsmaster && !$rsmaster->EOF);
				$rsmaster->Close();
			}
			if (!$bValidMasterRecord) {
				$sRelatedRecordMsg = str_replace("%t", "comprehensivewill_tb", $Language->Phrase("RelatedRecordRequired"));
				$this->setFailureMessage($sRelatedRecordMsg);
				$rs->Close();
				return FALSE;
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

		// Check referential integrity for master table 'comprehensivewill_tb'
		$bValidMasterRecord = TRUE;
		$sMasterFilter = $this->SqlMasterFilter_comprehensivewill_tb();
		if ($this->uid->getSessionValue() <> "") {
			$sMasterFilter = str_replace("@uid@", ew_AdjustSql($this->uid->getSessionValue()), $sMasterFilter);
		} else {
			$bValidMasterRecord = FALSE;
		}
		if ($bValidMasterRecord) {
			$rsmaster = $GLOBALS["comprehensivewill_tb"]->LoadRs($sMasterFilter);
			$bValidMasterRecord = ($rsmaster && !$rsmaster->EOF);
			$rsmaster->Close();
		}
		if (!$bValidMasterRecord) {
			$sRelatedRecordMsg = str_replace("%t", "comprehensivewill_tb", $Language->Phrase("RelatedRecordRequired"));
			$this->setFailureMessage($sRelatedRecordMsg);
			return FALSE;
		}

		// Load db values from rsold
		if ($rsold) {
			$this->LoadDbValues($rsold);
		}
		$rsnew = array();

		// salutation
		$this->salutation->SetDbValueDef($rsnew, $this->salutation->CurrentValue, NULL, FALSE);

		// fname
		$this->fname->SetDbValueDef($rsnew, $this->fname->CurrentValue, NULL, FALSE);

		// mname
		$this->mname->SetDbValueDef($rsnew, $this->mname->CurrentValue, NULL, FALSE);

		// lname
		$this->lname->SetDbValueDef($rsnew, $this->lname->CurrentValue, NULL, FALSE);

		// phone
		$this->phone->SetDbValueDef($rsnew, $this->phone->CurrentValue, NULL, FALSE);

		// aphone
		$this->aphone->SetDbValueDef($rsnew, $this->aphone->CurrentValue, NULL, FALSE);

		// rstate
		$this->rstate->SetDbValueDef($rsnew, $this->rstate->CurrentValue, NULL, FALSE);

		// gender
		$this->gender->SetDbValueDef($rsnew, $this->gender->CurrentValue, NULL, FALSE);

		// datecreated
		$this->datecreated->SetDbValueDef($rsnew, $this->datecreated->CurrentValue, NULL, FALSE);

		// uid
		if ($this->uid->getSessionValue() <> "") {
			$rsnew['uid'] = $this->uid->getSessionValue();
		}

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
		$item->Body = "<a id=\"emf_personal_info\" href=\"javascript:void(0);\" class=\"ewExportLink ewEmail\" data-caption=\"" . $Language->Phrase("ExportToEmailText") . "\" onclick=\"ew_EmailDialogShow({lnk:'emf_personal_info',hdr:ewLanguage.Phrase('ExportToEmail'),f:document.fpersonal_infolist,sel:false});\">" . $Language->Phrase("ExportToEmail") . "</a>";
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
			if ($sMasterTblVar <> "comprehensivewill_tb") {
				if ($this->uid->QueryStringValue == "") $this->uid->setSessionValue("");
			}
			if ($sMasterTblVar <> "premiumwill_tb") {
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
if (!isset($personal_info_list)) $personal_info_list = new cpersonal_info_list();

// Page init
$personal_info_list->Page_Init();

// Page main
$personal_info_list->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$personal_info_list->Page_Render();
?>
<?php include_once "header.php" ?>
<?php if ($personal_info->Export == "") { ?>
<script type="text/javascript">

// Page object
var personal_info_list = new ew_Page("personal_info_list");
personal_info_list.PageID = "list"; // Page ID
var EW_PAGE_ID = personal_info_list.PageID; // For backward compatibility

// Form object
var fpersonal_infolist = new ew_Form("fpersonal_infolist");
fpersonal_infolist.FormKeyCountName = '<?php echo $personal_info_list->FormKeyCountName ?>';

// Validate form
fpersonal_infolist.Validate = function() {
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
			elm = this.GetElements("x" + infix + "_salutation");
			if (elm && !ew_HasValue(elm))
				return this.OnError(elm, ewLanguage.Phrase("EnterRequiredField") + " - <?php echo ew_JsEncode2($personal_info->salutation->FldCaption()) ?>");
			elm = this.GetElements("x" + infix + "_datecreated");
			if (elm && !ew_HasValue(elm))
				return this.OnError(elm, ewLanguage.Phrase("EnterRequiredField") + " - <?php echo ew_JsEncode2($personal_info->datecreated->FldCaption()) ?>");

			// Set up row object
			ew_ElementsToRow(fobj);

			// Fire Form_CustomValidate event
			if (!this.Form_CustomValidate(fobj))
				return false;
	}
	return true;
}

// Form_CustomValidate event
fpersonal_infolist.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
fpersonal_infolist.ValidateRequired = true;
<?php } else { ?>
fpersonal_infolist.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
// Form object for search

var fpersonal_infolistsrch = new ew_Form("fpersonal_infolistsrch");
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
<?php if ($personal_info->Export == "") { ?>
<?php $Breadcrumb->Render(); ?>
<?php } ?>
<?php if ($personal_info->getCurrentMasterTable() == "" && $personal_info_list->ExportOptions->Visible()) { ?>
<div class="ewListExportOptions"><?php $personal_info_list->ExportOptions->Render("body") ?></div>
<?php } ?>
<?php if (($personal_info->Export == "") || (EW_EXPORT_MASTER_RECORD && $personal_info->Export == "print")) { ?>
<?php
$gsMasterReturnUrl = "comprehensivewill_tblist.php";
if ($personal_info_list->DbMasterFilter <> "" && $personal_info->getCurrentMasterTable() == "comprehensivewill_tb") {
	if ($personal_info_list->MasterRecordExists) {
		if ($personal_info->getCurrentMasterTable() == $personal_info->TableVar) $gsMasterReturnUrl .= "?" . EW_TABLE_SHOW_MASTER . "=";
?>
<?php if ($personal_info_list->ExportOptions->Visible()) { ?>
<div class="ewListExportOptions"><?php $personal_info_list->ExportOptions->Render("body") ?></div>
<?php } ?>
<?php include_once "comprehensivewill_tbmaster.php" ?>
<?php
	}
}
?>
<?php
$gsMasterReturnUrl = "premiumwill_tblist.php";
if ($personal_info_list->DbMasterFilter <> "" && $personal_info->getCurrentMasterTable() == "premiumwill_tb") {
	if ($personal_info_list->MasterRecordExists) {
		if ($personal_info->getCurrentMasterTable() == $personal_info->TableVar) $gsMasterReturnUrl .= "?" . EW_TABLE_SHOW_MASTER . "=";
?>
<?php if ($personal_info_list->ExportOptions->Visible()) { ?>
<div class="ewListExportOptions"><?php $personal_info_list->ExportOptions->Render("body") ?></div>
<?php } ?>
<?php include_once "premiumwill_tbmaster.php" ?>
<?php
	}
}
?>
<?php
$gsMasterReturnUrl = "privatetrust_tblist.php";
if ($personal_info_list->DbMasterFilter <> "" && $personal_info->getCurrentMasterTable() == "privatetrust_tb") {
	if ($personal_info_list->MasterRecordExists) {
		if ($personal_info->getCurrentMasterTable() == $personal_info->TableVar) $gsMasterReturnUrl .= "?" . EW_TABLE_SHOW_MASTER . "=";
?>
<?php if ($personal_info_list->ExportOptions->Visible()) { ?>
<div class="ewListExportOptions"><?php $personal_info_list->ExportOptions->Render("body") ?></div>
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
		$personal_info_list->TotalRecs = $personal_info->SelectRecordCount();
	} else {
		if ($personal_info_list->Recordset = $personal_info_list->LoadRecordset())
			$personal_info_list->TotalRecs = $personal_info_list->Recordset->RecordCount();
	}
	$personal_info_list->StartRec = 1;
	if ($personal_info_list->DisplayRecs <= 0 || ($personal_info->Export <> "" && $personal_info->ExportAll)) // Display all records
		$personal_info_list->DisplayRecs = $personal_info_list->TotalRecs;
	if (!($personal_info->Export <> "" && $personal_info->ExportAll))
		$personal_info_list->SetUpStartRec(); // Set up start record position
	if ($bSelectLimit)
		$personal_info_list->Recordset = $personal_info_list->LoadRecordset($personal_info_list->StartRec-1, $personal_info_list->DisplayRecs);
$personal_info_list->RenderOtherOptions();
?>
<?php if ($Security->IsLoggedIn()) { ?>
<?php if ($personal_info->Export == "" && $personal_info->CurrentAction == "") { ?>
<form name="fpersonal_infolistsrch" id="fpersonal_infolistsrch" class="ewForm form-inline" action="<?php echo ew_CurrentPage() ?>">
<table class="ewSearchTable"><tr><td>
<div class="accordion" id="fpersonal_infolistsrch_SearchGroup">
	<div class="accordion-group">
		<div class="accordion-heading">
<a class="accordion-toggle" data-toggle="collapse" data-parent="#fpersonal_infolistsrch_SearchGroup" href="#fpersonal_infolistsrch_SearchBody"><?php echo $Language->Phrase("Search") ?></a>
		</div>
		<div id="fpersonal_infolistsrch_SearchBody" class="accordion-body collapse in">
			<div class="accordion-inner">
<div id="fpersonal_infolistsrch_SearchPanel">
<input type="hidden" name="cmd" value="search">
<input type="hidden" name="t" value="personal_info">
<div class="ewBasicSearch">
<div id="xsr_1" class="ewRow">
	<div class="btn-group ewButtonGroup">
	<div class="input-append">
	<input type="text" name="<?php echo EW_TABLE_BASIC_SEARCH ?>" id="<?php echo EW_TABLE_BASIC_SEARCH ?>" class="input-large" value="<?php echo ew_HtmlEncode($personal_info_list->BasicSearch->getKeyword()) ?>" placeholder="<?php echo $Language->Phrase("Search") ?>">
	<button class="btn btn-primary ewButton" name="btnsubmit" id="btnsubmit" type="submit"><?php echo $Language->Phrase("QuickSearchBtn") ?></button>
	</div>
	</div>
	<div class="btn-group ewButtonGroup">
	<a class="btn ewShowAll" href="<?php echo $personal_info_list->PageUrl() ?>cmd=reset"><?php echo $Language->Phrase("ShowAll") ?></a>
</div>
<div id="xsr_2" class="ewRow">
	<label class="inline radio ewRadio" style="white-space: nowrap;"><input type="radio" name="<?php echo EW_TABLE_BASIC_SEARCH_TYPE ?>" value="="<?php if ($personal_info_list->BasicSearch->getType() == "=") { ?> checked="checked"<?php } ?>><?php echo $Language->Phrase("ExactPhrase") ?></label>
	<label class="inline radio ewRadio" style="white-space: nowrap;"><input type="radio" name="<?php echo EW_TABLE_BASIC_SEARCH_TYPE ?>" value="AND"<?php if ($personal_info_list->BasicSearch->getType() == "AND") { ?> checked="checked"<?php } ?>><?php echo $Language->Phrase("AllWord") ?></label>
	<label class="inline radio ewRadio" style="white-space: nowrap;"><input type="radio" name="<?php echo EW_TABLE_BASIC_SEARCH_TYPE ?>" value="OR"<?php if ($personal_info_list->BasicSearch->getType() == "OR") { ?> checked="checked"<?php } ?>><?php echo $Language->Phrase("AnyWord") ?></label>
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
<?php $personal_info_list->ShowPageHeader(); ?>
<?php
$personal_info_list->ShowMessage();
?>
<table cellspacing="0" class="ewGrid"><tr><td class="ewGridContent">
<form name="fpersonal_infolist" id="fpersonal_infolist" class="ewForm form-horizontal" action="<?php echo ew_CurrentPage() ?>" method="post">
<input type="hidden" name="t" value="personal_info">
<div id="gmp_personal_info" class="ewGridMiddlePanel">
<?php if ($personal_info_list->TotalRecs > 0) { ?>
<table id="tbl_personal_infolist" class="ewTable ewTableSeparate">
<?php echo $personal_info->TableCustomInnerHtml ?>
<thead><!-- Table header -->
	<tr class="ewTableHeader">
<?php

// Render list options
$personal_info_list->RenderListOptions();

// Render list options (header, left)
$personal_info_list->ListOptions->Render("header", "left");
?>
<?php if ($personal_info->salutation->Visible) { // salutation ?>
	<?php if ($personal_info->SortUrl($personal_info->salutation) == "") { ?>
		<td><div id="elh_personal_info_salutation" class="personal_info_salutation"><div class="ewTableHeaderCaption"><?php echo $personal_info->salutation->FldCaption() ?></div></div></td>
	<?php } else { ?>
		<td><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $personal_info->SortUrl($personal_info->salutation) ?>',2);"><div id="elh_personal_info_salutation" class="personal_info_salutation">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $personal_info->salutation->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($personal_info->salutation->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($personal_info->salutation->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></td>
	<?php } ?>
<?php } ?>		
<?php if ($personal_info->fname->Visible) { // fname ?>
	<?php if ($personal_info->SortUrl($personal_info->fname) == "") { ?>
		<td><div id="elh_personal_info_fname" class="personal_info_fname"><div class="ewTableHeaderCaption"><?php echo $personal_info->fname->FldCaption() ?></div></div></td>
	<?php } else { ?>
		<td><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $personal_info->SortUrl($personal_info->fname) ?>',2);"><div id="elh_personal_info_fname" class="personal_info_fname">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $personal_info->fname->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($personal_info->fname->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($personal_info->fname->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></td>
	<?php } ?>
<?php } ?>		
<?php if ($personal_info->mname->Visible) { // mname ?>
	<?php if ($personal_info->SortUrl($personal_info->mname) == "") { ?>
		<td><div id="elh_personal_info_mname" class="personal_info_mname"><div class="ewTableHeaderCaption"><?php echo $personal_info->mname->FldCaption() ?></div></div></td>
	<?php } else { ?>
		<td><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $personal_info->SortUrl($personal_info->mname) ?>',2);"><div id="elh_personal_info_mname" class="personal_info_mname">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $personal_info->mname->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($personal_info->mname->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($personal_info->mname->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></td>
	<?php } ?>
<?php } ?>		
<?php if ($personal_info->lname->Visible) { // lname ?>
	<?php if ($personal_info->SortUrl($personal_info->lname) == "") { ?>
		<td><div id="elh_personal_info_lname" class="personal_info_lname"><div class="ewTableHeaderCaption"><?php echo $personal_info->lname->FldCaption() ?></div></div></td>
	<?php } else { ?>
		<td><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $personal_info->SortUrl($personal_info->lname) ?>',2);"><div id="elh_personal_info_lname" class="personal_info_lname">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $personal_info->lname->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($personal_info->lname->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($personal_info->lname->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></td>
	<?php } ?>
<?php } ?>		
<?php if ($personal_info->phone->Visible) { // phone ?>
	<?php if ($personal_info->SortUrl($personal_info->phone) == "") { ?>
		<td><div id="elh_personal_info_phone" class="personal_info_phone"><div class="ewTableHeaderCaption"><?php echo $personal_info->phone->FldCaption() ?></div></div></td>
	<?php } else { ?>
		<td><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $personal_info->SortUrl($personal_info->phone) ?>',2);"><div id="elh_personal_info_phone" class="personal_info_phone">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $personal_info->phone->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($personal_info->phone->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($personal_info->phone->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></td>
	<?php } ?>
<?php } ?>		
<?php if ($personal_info->aphone->Visible) { // aphone ?>
	<?php if ($personal_info->SortUrl($personal_info->aphone) == "") { ?>
		<td><div id="elh_personal_info_aphone" class="personal_info_aphone"><div class="ewTableHeaderCaption"><?php echo $personal_info->aphone->FldCaption() ?></div></div></td>
	<?php } else { ?>
		<td><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $personal_info->SortUrl($personal_info->aphone) ?>',2);"><div id="elh_personal_info_aphone" class="personal_info_aphone">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $personal_info->aphone->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($personal_info->aphone->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($personal_info->aphone->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></td>
	<?php } ?>
<?php } ?>		
<?php if ($personal_info->rstate->Visible) { // rstate ?>
	<?php if ($personal_info->SortUrl($personal_info->rstate) == "") { ?>
		<td><div id="elh_personal_info_rstate" class="personal_info_rstate"><div class="ewTableHeaderCaption"><?php echo $personal_info->rstate->FldCaption() ?></div></div></td>
	<?php } else { ?>
		<td><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $personal_info->SortUrl($personal_info->rstate) ?>',2);"><div id="elh_personal_info_rstate" class="personal_info_rstate">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $personal_info->rstate->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($personal_info->rstate->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($personal_info->rstate->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></td>
	<?php } ?>
<?php } ?>		
<?php if ($personal_info->gender->Visible) { // gender ?>
	<?php if ($personal_info->SortUrl($personal_info->gender) == "") { ?>
		<td><div id="elh_personal_info_gender" class="personal_info_gender"><div class="ewTableHeaderCaption"><?php echo $personal_info->gender->FldCaption() ?></div></div></td>
	<?php } else { ?>
		<td><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $personal_info->SortUrl($personal_info->gender) ?>',2);"><div id="elh_personal_info_gender" class="personal_info_gender">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $personal_info->gender->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($personal_info->gender->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($personal_info->gender->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></td>
	<?php } ?>
<?php } ?>		
<?php if ($personal_info->datecreated->Visible) { // datecreated ?>
	<?php if ($personal_info->SortUrl($personal_info->datecreated) == "") { ?>
		<td><div id="elh_personal_info_datecreated" class="personal_info_datecreated"><div class="ewTableHeaderCaption"><?php echo $personal_info->datecreated->FldCaption() ?></div></div></td>
	<?php } else { ?>
		<td><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $personal_info->SortUrl($personal_info->datecreated) ?>',2);"><div id="elh_personal_info_datecreated" class="personal_info_datecreated">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $personal_info->datecreated->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($personal_info->datecreated->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($personal_info->datecreated->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></td>
	<?php } ?>
<?php } ?>		
<?php

// Render list options (header, right)
$personal_info_list->ListOptions->Render("header", "right");
?>
	</tr>
</thead>
<tbody>
<?php
if ($personal_info->ExportAll && $personal_info->Export <> "") {
	$personal_info_list->StopRec = $personal_info_list->TotalRecs;
} else {

	// Set the last record to display
	if ($personal_info_list->TotalRecs > $personal_info_list->StartRec + $personal_info_list->DisplayRecs - 1)
		$personal_info_list->StopRec = $personal_info_list->StartRec + $personal_info_list->DisplayRecs - 1;
	else
		$personal_info_list->StopRec = $personal_info_list->TotalRecs;
}

// Restore number of post back records
if ($objForm) {
	$objForm->Index = -1;
	if ($objForm->HasValue($personal_info_list->FormKeyCountName) && ($personal_info->CurrentAction == "gridadd" || $personal_info->CurrentAction == "gridedit" || $personal_info->CurrentAction == "F")) {
		$personal_info_list->KeyCount = $objForm->GetValue($personal_info_list->FormKeyCountName);
		$personal_info_list->StopRec = $personal_info_list->StartRec + $personal_info_list->KeyCount - 1;
	}
}
$personal_info_list->RecCnt = $personal_info_list->StartRec - 1;
if ($personal_info_list->Recordset && !$personal_info_list->Recordset->EOF) {
	$personal_info_list->Recordset->MoveFirst();
	if (!$bSelectLimit && $personal_info_list->StartRec > 1)
		$personal_info_list->Recordset->Move($personal_info_list->StartRec - 1);
} elseif (!$personal_info->AllowAddDeleteRow && $personal_info_list->StopRec == 0) {
	$personal_info_list->StopRec = $personal_info->GridAddRowCount;
}

// Initialize aggregate
$personal_info->RowType = EW_ROWTYPE_AGGREGATEINIT;
$personal_info->ResetAttrs();
$personal_info_list->RenderRow();
$personal_info_list->EditRowCnt = 0;
if ($personal_info->CurrentAction == "edit")
	$personal_info_list->RowIndex = 1;
while ($personal_info_list->RecCnt < $personal_info_list->StopRec) {
	$personal_info_list->RecCnt++;
	if (intval($personal_info_list->RecCnt) >= intval($personal_info_list->StartRec)) {
		$personal_info_list->RowCnt++;

		// Set up key count
		$personal_info_list->KeyCount = $personal_info_list->RowIndex;

		// Init row class and style
		$personal_info->ResetAttrs();
		$personal_info->CssClass = "";
		if ($personal_info->CurrentAction == "gridadd") {
			$personal_info_list->LoadDefaultValues(); // Load default values
		} else {
			$personal_info_list->LoadRowValues($personal_info_list->Recordset); // Load row values
		}
		$personal_info->RowType = EW_ROWTYPE_VIEW; // Render view
		if ($personal_info->CurrentAction == "edit") {
			if ($personal_info_list->CheckInlineEditKey() && $personal_info_list->EditRowCnt == 0) { // Inline edit
				$personal_info->RowType = EW_ROWTYPE_EDIT; // Render edit
			}
		}
		if ($personal_info->CurrentAction == "edit" && $personal_info->RowType == EW_ROWTYPE_EDIT && $personal_info->EventCancelled) { // Update failed
			$objForm->Index = 1;
			$personal_info_list->RestoreFormValues(); // Restore form values
		}
		if ($personal_info->RowType == EW_ROWTYPE_EDIT) // Edit row
			$personal_info_list->EditRowCnt++;

		// Set up row id / data-rowindex
		$personal_info->RowAttrs = array_merge($personal_info->RowAttrs, array('data-rowindex'=>$personal_info_list->RowCnt, 'id'=>'r' . $personal_info_list->RowCnt . '_personal_info', 'data-rowtype'=>$personal_info->RowType));

		// Render row
		$personal_info_list->RenderRow();

		// Render list options
		$personal_info_list->RenderListOptions();
?>
	<tr<?php echo $personal_info->RowAttributes() ?>>
<?php

// Render list options (body, left)
$personal_info_list->ListOptions->Render("body", "left", $personal_info_list->RowCnt);
?>
	<?php if ($personal_info->salutation->Visible) { // salutation ?>
		<td<?php echo $personal_info->salutation->CellAttributes() ?>>
<?php if ($personal_info->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $personal_info_list->RowCnt ?>_personal_info_salutation" class="control-group personal_info_salutation">
<input type="text" data-field="x_salutation" name="x<?php echo $personal_info_list->RowIndex ?>_salutation" id="x<?php echo $personal_info_list->RowIndex ?>_salutation" size="30" maxlength="20" placeholder="<?php echo $personal_info->salutation->PlaceHolder ?>" value="<?php echo $personal_info->salutation->EditValue ?>"<?php echo $personal_info->salutation->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($personal_info->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span<?php echo $personal_info->salutation->ViewAttributes() ?>>
<?php echo $personal_info->salutation->ListViewValue() ?></span>
<?php } ?>
<a id="<?php echo $personal_info_list->PageObjName . "_row_" . $personal_info_list->RowCnt ?>"></a></td>
	<?php } ?>
<?php if ($personal_info->RowType == EW_ROWTYPE_EDIT || $personal_info->CurrentMode == "edit") { ?>
<input type="hidden" data-field="x_id" name="x<?php echo $personal_info_list->RowIndex ?>_id" id="x<?php echo $personal_info_list->RowIndex ?>_id" value="<?php echo ew_HtmlEncode($personal_info->id->CurrentValue) ?>">
<?php } ?>
	<?php if ($personal_info->fname->Visible) { // fname ?>
		<td<?php echo $personal_info->fname->CellAttributes() ?>>
<?php if ($personal_info->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $personal_info_list->RowCnt ?>_personal_info_fname" class="control-group personal_info_fname">
<input type="text" data-field="x_fname" name="x<?php echo $personal_info_list->RowIndex ?>_fname" id="x<?php echo $personal_info_list->RowIndex ?>_fname" size="30" maxlength="50" placeholder="<?php echo $personal_info->fname->PlaceHolder ?>" value="<?php echo $personal_info->fname->EditValue ?>"<?php echo $personal_info->fname->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($personal_info->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span<?php echo $personal_info->fname->ViewAttributes() ?>>
<?php echo $personal_info->fname->ListViewValue() ?></span>
<?php } ?>
<a id="<?php echo $personal_info_list->PageObjName . "_row_" . $personal_info_list->RowCnt ?>"></a></td>
	<?php } ?>
	<?php if ($personal_info->mname->Visible) { // mname ?>
		<td<?php echo $personal_info->mname->CellAttributes() ?>>
<?php if ($personal_info->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $personal_info_list->RowCnt ?>_personal_info_mname" class="control-group personal_info_mname">
<input type="text" data-field="x_mname" name="x<?php echo $personal_info_list->RowIndex ?>_mname" id="x<?php echo $personal_info_list->RowIndex ?>_mname" size="30" maxlength="50" placeholder="<?php echo $personal_info->mname->PlaceHolder ?>" value="<?php echo $personal_info->mname->EditValue ?>"<?php echo $personal_info->mname->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($personal_info->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span<?php echo $personal_info->mname->ViewAttributes() ?>>
<?php echo $personal_info->mname->ListViewValue() ?></span>
<?php } ?>
<a id="<?php echo $personal_info_list->PageObjName . "_row_" . $personal_info_list->RowCnt ?>"></a></td>
	<?php } ?>
	<?php if ($personal_info->lname->Visible) { // lname ?>
		<td<?php echo $personal_info->lname->CellAttributes() ?>>
<?php if ($personal_info->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $personal_info_list->RowCnt ?>_personal_info_lname" class="control-group personal_info_lname">
<input type="text" data-field="x_lname" name="x<?php echo $personal_info_list->RowIndex ?>_lname" id="x<?php echo $personal_info_list->RowIndex ?>_lname" size="30" maxlength="50" placeholder="<?php echo $personal_info->lname->PlaceHolder ?>" value="<?php echo $personal_info->lname->EditValue ?>"<?php echo $personal_info->lname->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($personal_info->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span<?php echo $personal_info->lname->ViewAttributes() ?>>
<?php echo $personal_info->lname->ListViewValue() ?></span>
<?php } ?>
<a id="<?php echo $personal_info_list->PageObjName . "_row_" . $personal_info_list->RowCnt ?>"></a></td>
	<?php } ?>
	<?php if ($personal_info->phone->Visible) { // phone ?>
		<td<?php echo $personal_info->phone->CellAttributes() ?>>
<?php if ($personal_info->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $personal_info_list->RowCnt ?>_personal_info_phone" class="control-group personal_info_phone">
<input type="text" data-field="x_phone" name="x<?php echo $personal_info_list->RowIndex ?>_phone" id="x<?php echo $personal_info_list->RowIndex ?>_phone" size="30" maxlength="15" placeholder="<?php echo $personal_info->phone->PlaceHolder ?>" value="<?php echo $personal_info->phone->EditValue ?>"<?php echo $personal_info->phone->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($personal_info->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span<?php echo $personal_info->phone->ViewAttributes() ?>>
<?php echo $personal_info->phone->ListViewValue() ?></span>
<?php } ?>
<a id="<?php echo $personal_info_list->PageObjName . "_row_" . $personal_info_list->RowCnt ?>"></a></td>
	<?php } ?>
	<?php if ($personal_info->aphone->Visible) { // aphone ?>
		<td<?php echo $personal_info->aphone->CellAttributes() ?>>
<?php if ($personal_info->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $personal_info_list->RowCnt ?>_personal_info_aphone" class="control-group personal_info_aphone">
<input type="text" data-field="x_aphone" name="x<?php echo $personal_info_list->RowIndex ?>_aphone" id="x<?php echo $personal_info_list->RowIndex ?>_aphone" size="30" maxlength="15" placeholder="<?php echo $personal_info->aphone->PlaceHolder ?>" value="<?php echo $personal_info->aphone->EditValue ?>"<?php echo $personal_info->aphone->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($personal_info->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span<?php echo $personal_info->aphone->ViewAttributes() ?>>
<?php echo $personal_info->aphone->ListViewValue() ?></span>
<?php } ?>
<a id="<?php echo $personal_info_list->PageObjName . "_row_" . $personal_info_list->RowCnt ?>"></a></td>
	<?php } ?>
	<?php if ($personal_info->rstate->Visible) { // rstate ?>
		<td<?php echo $personal_info->rstate->CellAttributes() ?>>
<?php if ($personal_info->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $personal_info_list->RowCnt ?>_personal_info_rstate" class="control-group personal_info_rstate">
<input type="text" data-field="x_rstate" name="x<?php echo $personal_info_list->RowIndex ?>_rstate" id="x<?php echo $personal_info_list->RowIndex ?>_rstate" size="30" maxlength="20" placeholder="<?php echo $personal_info->rstate->PlaceHolder ?>" value="<?php echo $personal_info->rstate->EditValue ?>"<?php echo $personal_info->rstate->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($personal_info->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span<?php echo $personal_info->rstate->ViewAttributes() ?>>
<?php echo $personal_info->rstate->ListViewValue() ?></span>
<?php } ?>
<a id="<?php echo $personal_info_list->PageObjName . "_row_" . $personal_info_list->RowCnt ?>"></a></td>
	<?php } ?>
	<?php if ($personal_info->gender->Visible) { // gender ?>
		<td<?php echo $personal_info->gender->CellAttributes() ?>>
<?php if ($personal_info->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $personal_info_list->RowCnt ?>_personal_info_gender" class="control-group personal_info_gender">
<input type="text" data-field="x_gender" name="x<?php echo $personal_info_list->RowIndex ?>_gender" id="x<?php echo $personal_info_list->RowIndex ?>_gender" size="30" maxlength="10" placeholder="<?php echo $personal_info->gender->PlaceHolder ?>" value="<?php echo $personal_info->gender->EditValue ?>"<?php echo $personal_info->gender->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($personal_info->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span<?php echo $personal_info->gender->ViewAttributes() ?>>
<?php echo $personal_info->gender->ListViewValue() ?></span>
<?php } ?>
<a id="<?php echo $personal_info_list->PageObjName . "_row_" . $personal_info_list->RowCnt ?>"></a></td>
	<?php } ?>
	<?php if ($personal_info->datecreated->Visible) { // datecreated ?>
		<td<?php echo $personal_info->datecreated->CellAttributes() ?>>
<?php if ($personal_info->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $personal_info_list->RowCnt ?>_personal_info_datecreated" class="control-group personal_info_datecreated">
<input type="text" data-field="x_datecreated" name="x<?php echo $personal_info_list->RowIndex ?>_datecreated" id="x<?php echo $personal_info_list->RowIndex ?>_datecreated" placeholder="<?php echo $personal_info->datecreated->PlaceHolder ?>" value="<?php echo $personal_info->datecreated->EditValue ?>"<?php echo $personal_info->datecreated->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($personal_info->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span<?php echo $personal_info->datecreated->ViewAttributes() ?>>
<?php echo $personal_info->datecreated->ListViewValue() ?></span>
<?php } ?>
<a id="<?php echo $personal_info_list->PageObjName . "_row_" . $personal_info_list->RowCnt ?>"></a></td>
	<?php } ?>
<?php

// Render list options (body, right)
$personal_info_list->ListOptions->Render("body", "right", $personal_info_list->RowCnt);
?>
	</tr>
<?php if ($personal_info->RowType == EW_ROWTYPE_ADD || $personal_info->RowType == EW_ROWTYPE_EDIT) { ?>
<script type="text/javascript">
fpersonal_infolist.UpdateOpts(<?php echo $personal_info_list->RowIndex ?>);
</script>
<?php } ?>
<?php
	}
	if ($personal_info->CurrentAction <> "gridadd")
		$personal_info_list->Recordset->MoveNext();
}
?>
</tbody>
</table>
<?php } ?>
<?php if ($personal_info->CurrentAction == "edit") { ?>
<input type="hidden" name="<?php echo $personal_info_list->FormKeyCountName ?>" id="<?php echo $personal_info_list->FormKeyCountName ?>" value="<?php echo $personal_info_list->KeyCount ?>">
<?php } ?>
<?php if ($personal_info->CurrentAction == "") { ?>
<input type="hidden" name="a_list" id="a_list" value="">
<?php } ?>
</div>
</form>
<?php

// Close recordset
if ($personal_info_list->Recordset)
	$personal_info_list->Recordset->Close();
?>
<?php if ($personal_info->Export == "") { ?>
<div class="ewGridLowerPanel">
<?php if ($personal_info->CurrentAction <> "gridadd" && $personal_info->CurrentAction <> "gridedit") { ?>
<form name="ewPagerForm" class="ewForm form-horizontal" action="<?php echo ew_CurrentPage() ?>">
<table class="ewPager">
<tr><td>
<?php if (!isset($personal_info_list->Pager)) $personal_info_list->Pager = new cNumericPager($personal_info_list->StartRec, $personal_info_list->DisplayRecs, $personal_info_list->TotalRecs, $personal_info_list->RecRange) ?>
<?php if ($personal_info_list->Pager->RecordCount > 0) { ?>
<table cellspacing="0" class="ewStdTable"><tbody><tr><td>
<div class="pagination"><ul>
	<?php if ($personal_info_list->Pager->FirstButton->Enabled) { ?>
	<li><a href="<?php echo $personal_info_list->PageUrl() ?>start=<?php echo $personal_info_list->Pager->FirstButton->Start ?>"><?php echo $Language->Phrase("PagerFirst") ?></a></li>
	<?php } ?>
	<?php if ($personal_info_list->Pager->PrevButton->Enabled) { ?>
	<li><a href="<?php echo $personal_info_list->PageUrl() ?>start=<?php echo $personal_info_list->Pager->PrevButton->Start ?>"><?php echo $Language->Phrase("PagerPrevious") ?></a></li>
	<?php } ?>
	<?php foreach ($personal_info_list->Pager->Items as $PagerItem) { ?>
		<li<?php if (!$PagerItem->Enabled) { echo " class=\" active\""; } ?>><a href="<?php if ($PagerItem->Enabled) { echo $personal_info_list->PageUrl() . "start=" . $PagerItem->Start; } else { echo "#"; } ?>"><?php echo $PagerItem->Text ?></a></li>
	<?php } ?>
	<?php if ($personal_info_list->Pager->NextButton->Enabled) { ?>
	<li><a href="<?php echo $personal_info_list->PageUrl() ?>start=<?php echo $personal_info_list->Pager->NextButton->Start ?>"><?php echo $Language->Phrase("PagerNext") ?></a></li>
	<?php } ?>
	<?php if ($personal_info_list->Pager->LastButton->Enabled) { ?>
	<li><a href="<?php echo $personal_info_list->PageUrl() ?>start=<?php echo $personal_info_list->Pager->LastButton->Start ?>"><?php echo $Language->Phrase("PagerLast") ?></a></li>
	<?php } ?>
</ul></div>
</td>
<td>
	<?php if ($personal_info_list->Pager->ButtonCount > 0) { ?>&nbsp;&nbsp;&nbsp;&nbsp;<?php } ?>
	<?php echo $Language->Phrase("Record") ?>&nbsp;<?php echo $personal_info_list->Pager->FromIndex ?>&nbsp;<?php echo $Language->Phrase("To") ?>&nbsp;<?php echo $personal_info_list->Pager->ToIndex ?>&nbsp;<?php echo $Language->Phrase("Of") ?>&nbsp;<?php echo $personal_info_list->Pager->RecordCount ?>
</td>
</tr></tbody></table>
<?php } else { ?>
	<?php if ($personal_info_list->SearchWhere == "0=101") { ?>
	<p><?php echo $Language->Phrase("EnterSearchCriteria") ?></p>
	<?php } else { ?>
	<p><?php echo $Language->Phrase("NoRecord") ?></p>
	<?php } ?>
<?php } ?>
</td>
<?php if ($personal_info_list->TotalRecs > 0) { ?>
<td>
	&nbsp;&nbsp;&nbsp;&nbsp;
<input type="hidden" name="t" value="personal_info">
<select name="<?php echo EW_TABLE_REC_PER_PAGE ?>" class="input-small" onchange="this.form.submit();">
<option value="25"<?php if ($personal_info_list->DisplayRecs == 25) { ?> selected="selected"<?php } ?>>25</option>
<option value="50"<?php if ($personal_info_list->DisplayRecs == 50) { ?> selected="selected"<?php } ?>>50</option>
<option value="100"<?php if ($personal_info_list->DisplayRecs == 100) { ?> selected="selected"<?php } ?>>100</option>
<option value="200"<?php if ($personal_info_list->DisplayRecs == 200) { ?> selected="selected"<?php } ?>>200</option>
<option value="500"<?php if ($personal_info_list->DisplayRecs == 500) { ?> selected="selected"<?php } ?>>500</option>
<option value="ALL"<?php if ($personal_info->getRecordsPerPage() == -1) { ?> selected="selected"<?php } ?>><?php echo $Language->Phrase("AllRecords") ?></option>
</select>
</td>
<?php } ?>
</tr></table>
</form>
<?php } ?>
<div class="ewListOtherOptions">
<?php
	foreach ($personal_info_list->OtherOptions as &$option)
		$option->Render("body", "bottom");
?>
</div>
</div>
<?php } ?>
</td></tr></table>
<?php if ($personal_info->Export == "") { ?>
<script type="text/javascript">
fpersonal_infolistsrch.Init();
fpersonal_infolist.Init();
<?php if (EW_MOBILE_REFLOW && ew_IsMobile()) { ?>
ew_Reflow();
<?php } ?>
</script>
<?php } ?>
<?php
$personal_info_list->ShowPageFooter();
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
$personal_info_list->Page_Terminate();
?>
