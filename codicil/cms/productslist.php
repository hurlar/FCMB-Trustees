<?php
if (session_id() == "") session_start(); // Initialize Session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg10.php" ?>
<?php include_once "ewmysql10.php" ?>
<?php include_once "phpfn10.php" ?>
<?php include_once "productsinfo.php" ?>
<?php include_once "adminusersinfo.php" ?>
<?php include_once "userfn10.php" ?>
<?php

//
// Page class
//

$products_list = NULL; // Initialize page object first

class cproducts_list extends cproducts {

	// Page ID
	var $PageID = 'list';

	// Project ID
	var $ProjectID = "{D9B361E7-B2C1-4293-B9B3-B581986A15CC}";

	// Table name
	var $TableName = 'products';

	// Page object name
	var $PageObjName = 'products_list';

	// Grid form hidden field names
	var $FormName = 'fproductslist';
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

		// Table object (products)
		if (!isset($GLOBALS["products"])) {
			$GLOBALS["products"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["products"];
		}

		// Initialize URLs
		$this->ExportPrintUrl = $this->PageUrl() . "export=print";
		$this->ExportExcelUrl = $this->PageUrl() . "export=excel";
		$this->ExportWordUrl = $this->PageUrl() . "export=word";
		$this->ExportHtmlUrl = $this->PageUrl() . "export=html";
		$this->ExportXmlUrl = $this->PageUrl() . "export=xml";
		$this->ExportCsvUrl = $this->PageUrl() . "export=csv";
		$this->ExportPdfUrl = $this->PageUrl() . "export=pdf";
		$this->AddUrl = "productsadd.php";
		$this->InlineAddUrl = $this->PageUrl() . "a=add";
		$this->GridAddUrl = $this->PageUrl() . "a=gridadd";
		$this->GridEditUrl = $this->PageUrl() . "a=gridedit";
		$this->MultiDeleteUrl = "productsdelete.php";
		$this->MultiUpdateUrl = "productsupdate.php";

		// Table object (adminusers)
		if (!isset($GLOBALS['adminusers'])) $GLOBALS['adminusers'] = new cadminusers();

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'list', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'products', TRUE);

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

				// Switch to grid edit mode
				if ($this->CurrentAction == "gridedit")
					$this->GridEditMode();

				// Switch to inline edit mode
				if ($this->CurrentAction == "edit")
					$this->InlineEditMode();

				// Switch to inline add mode
				if ($this->CurrentAction == "add" || $this->CurrentAction == "copy")
					$this->InlineAddMode();

				// Switch to grid add mode
				if ($this->CurrentAction == "gridadd")
					$this->GridAddMode();
			} else {
				if (@$_POST["a_list"] <> "") {
					$this->CurrentAction = $_POST["a_list"]; // Get action

					// Grid Update
					if (($this->CurrentAction == "gridupdate" || $this->CurrentAction == "gridoverwrite") && @$_SESSION[EW_SESSION_INLINE_MODE] == "gridedit") {
						if ($this->ValidateGridForm()) {
							$this->GridUpdate();
						} else {
							$this->setFailureMessage($gsFormError);
							$this->EventCancelled = TRUE;
							$this->CurrentAction = "gridedit"; // Stay in Grid Edit mode
						}
					}

					// Inline Update
					if (($this->CurrentAction == "update" || $this->CurrentAction == "overwrite") && @$_SESSION[EW_SESSION_INLINE_MODE] == "edit")
						$this->InlineUpdate();

					// Insert Inline
					if ($this->CurrentAction == "insert" && @$_SESSION[EW_SESSION_INLINE_MODE] == "add")
						$this->InlineInsert();

					// Grid Insert
					if ($this->CurrentAction == "gridinsert" && @$_SESSION[EW_SESSION_INLINE_MODE] == "gridadd") {
						if ($this->ValidateGridForm()) {
							$this->GridInsert();
						} else {
							$this->setFailureMessage($gsFormError);
							$this->EventCancelled = TRUE;
							$this->CurrentAction = "gridadd"; // Stay in Grid Add mode
						}
					}
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

			// Show grid delete link for grid add / grid edit
			if ($this->AllowAddDeleteRow) {
				if ($this->CurrentAction == "gridadd" || $this->CurrentAction == "gridedit") {
					$item = $this->ListOptions->GetItem("griddelete");
					if ($item) $item->Visible = TRUE;
				}
			}

			// Get basic search values
			$this->LoadBasicSearchValues();

			// Get and validate search values for advanced search
			$this->LoadSearchValues(); // Get search values
			if (!$this->ValidateSearch())
				$this->setFailureMessage($gsSearchError);

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

			// Get search criteria for advanced search
			if ($gsSearchError == "")
				$sSrchAdvanced = $this->AdvancedSearchWhere();
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

			// Load advanced search from default
			if ($this->LoadAdvancedSearchDefault()) {
				$sSrchAdvanced = $this->AdvancedSearchWhere();
			}
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

	// Switch to Grid Add mode
	function GridAddMode() {
		$_SESSION[EW_SESSION_INLINE_MODE] = "gridadd"; // Enabled grid add
	}

	// Switch to Grid Edit mode
	function GridEditMode() {
		$_SESSION[EW_SESSION_INLINE_MODE] = "gridedit"; // Enable grid edit
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

	// Switch to Inline Add mode
	function InlineAddMode() {
		global $Security, $Language;
		$this->CurrentAction = "add";
		$_SESSION[EW_SESSION_INLINE_MODE] = "add"; // Enable inline add
	}

	// Perform update to Inline Add/Copy record
	function InlineInsert() {
		global $Language, $objForm, $gsFormError;
		$this->LoadOldRecord(); // Load old recordset
		$objForm->Index = 0;
		$this->LoadFormValues(); // Get form values

		// Validate form
		if (!$this->ValidateForm()) {
			$this->setFailureMessage($gsFormError); // Set validation error message
			$this->EventCancelled = TRUE; // Set event cancelled
			$this->CurrentAction = "add"; // Stay in add mode
			return;
		}
		$this->SendEmail = TRUE; // Send email on add success
		if ($this->AddRow($this->OldRecordset)) { // Add record
			if ($this->getSuccessMessage() == "")
				$this->setSuccessMessage($Language->Phrase("AddSuccess")); // Set up add success message
			$this->ClearInlineMode(); // Clear inline add mode
		} else { // Add failed
			$this->EventCancelled = TRUE; // Set event cancelled
			$this->CurrentAction = "add"; // Stay in add mode
		}
	}

	// Perform update to grid
	function GridUpdate() {
		global $conn, $Language, $objForm, $gsFormError;
		$bGridUpdate = TRUE;

		// Begin transaction
		$conn->BeginTrans();

		// Get old recordset
		$this->CurrentFilter = $this->BuildKeyFilter();
		$sSql = $this->SQL();
		if ($rs = $conn->Execute($sSql)) {
			$rsold = $rs->GetRows();
			$rs->Close();
		}
		$sKey = "";

		// Update row index and get row key
		$objForm->Index = -1;
		$rowcnt = strval($objForm->GetValue($this->FormKeyCountName));
		if ($rowcnt == "" || !is_numeric($rowcnt))
			$rowcnt = 0;

		// Update all rows based on key
		for ($rowindex = 1; $rowindex <= $rowcnt; $rowindex++) {
			$objForm->Index = $rowindex;
			$rowkey = strval($objForm->GetValue($this->FormKeyName));
			$rowaction = strval($objForm->GetValue($this->FormActionName));

			// Load all values and keys
			if ($rowaction <> "insertdelete") { // Skip insert then deleted rows
				$this->LoadFormValues(); // Get form values
				if ($rowaction == "" || $rowaction == "edit" || $rowaction == "delete") {
					$bGridUpdate = $this->SetupKeyValues($rowkey); // Set up key values
				} else {
					$bGridUpdate = TRUE;
				}

				// Skip empty row
				if ($rowaction == "insert" && $this->EmptyRow()) {

					// No action required
				// Validate form and insert/update/delete record

				} elseif ($bGridUpdate) {
					if ($rowaction == "delete") {
						$this->CurrentFilter = $this->KeyFilter();
						$bGridUpdate = $this->DeleteRows(); // Delete this row
					} else if (!$this->ValidateForm()) {
						$bGridUpdate = FALSE; // Form error, reset action
						$this->setFailureMessage($gsFormError);
					} else {
						if ($rowaction == "insert") {
							$bGridUpdate = $this->AddRow(); // Insert this row
						} else {
							if ($rowkey <> "") {
								$this->SendEmail = FALSE; // Do not send email on update success
								$bGridUpdate = $this->EditRow(); // Update this row
							}
						} // End update
					}
				}
				if ($bGridUpdate) {
					if ($sKey <> "") $sKey .= ", ";
					$sKey .= $rowkey;
				} else {
					break;
				}
			}
		}
		if ($bGridUpdate) {
			$conn->CommitTrans(); // Commit transaction

			// Get new recordset
			if ($rs = $conn->Execute($sSql)) {
				$rsnew = $rs->GetRows();
				$rs->Close();
			}
			if ($this->getSuccessMessage() == "")
				$this->setSuccessMessage($Language->Phrase("UpdateSuccess")); // Set up update success message
			$this->ClearInlineMode(); // Clear inline edit mode
		} else {
			$conn->RollbackTrans(); // Rollback transaction
			if ($this->getFailureMessage() == "")
				$this->setFailureMessage($Language->Phrase("UpdateFailed")); // Set update failed message
			$this->EventCancelled = TRUE; // Set event cancelled
			$this->CurrentAction = "gridedit"; // Stay in Grid Edit mode
		}
		return $bGridUpdate;
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

	// Perform Grid Add
	function GridInsert() {
		global $conn, $Language, $objForm, $gsFormError;
		$rowindex = 1;
		$bGridInsert = FALSE;

		// Begin transaction
		$conn->BeginTrans();

		// Init key filter
		$sWrkFilter = "";
		$addcnt = 0;
		$sKey = "";

		// Get row count
		$objForm->Index = -1;
		$rowcnt = strval($objForm->GetValue($this->FormKeyCountName));
		if ($rowcnt == "" || !is_numeric($rowcnt))
			$rowcnt = 0;

		// Insert all rows
		for ($rowindex = 1; $rowindex <= $rowcnt; $rowindex++) {

			// Load current row values
			$objForm->Index = $rowindex;
			$rowaction = strval($objForm->GetValue($this->FormActionName));
			if ($rowaction <> "" && $rowaction <> "insert")
				continue; // Skip
			$this->LoadFormValues(); // Get form values
			if (!$this->EmptyRow()) {
				$addcnt++;
				$this->SendEmail = FALSE; // Do not send email on insert success

				// Validate form
				if (!$this->ValidateForm()) {
					$bGridInsert = FALSE; // Form error, reset action
					$this->setFailureMessage($gsFormError);
				} else {
					$bGridInsert = $this->AddRow($this->OldRecordset); // Insert this row
				}
				if ($bGridInsert) {
					if ($sKey <> "") $sKey .= $GLOBALS["EW_COMPOSITE_KEY_SEPARATOR"];
					$sKey .= $this->id->CurrentValue;

					// Add filter for this record
					$sFilter = $this->KeyFilter();
					if ($sWrkFilter <> "") $sWrkFilter .= " OR ";
					$sWrkFilter .= $sFilter;
				} else {
					break;
				}
			}
		}
		if ($addcnt == 0) { // No record inserted
			$this->setFailureMessage($Language->Phrase("NoAddRecord"));
			$bGridInsert = FALSE;
		}
		if ($bGridInsert) {
			$conn->CommitTrans(); // Commit transaction

			// Get new recordset
			$this->CurrentFilter = $sWrkFilter;
			$sSql = $this->SQL();
			if ($rs = $conn->Execute($sSql)) {
				$rsnew = $rs->GetRows();
				$rs->Close();
			}
			if ($this->getSuccessMessage() == "")
				$this->setSuccessMessage($Language->Phrase("InsertSuccess")); // Set up insert success message
			$this->ClearInlineMode(); // Clear grid add mode
		} else {
			$conn->RollbackTrans(); // Rollback transaction
			if ($this->getFailureMessage() == "") {
				$this->setFailureMessage($Language->Phrase("InsertFailed")); // Set insert failed message
			}
			$this->EventCancelled = TRUE; // Set event cancelled
			$this->CurrentAction = "gridadd"; // Stay in gridadd mode
		}
		return $bGridInsert;
	}

	// Check if empty row
	function EmptyRow() {
		global $objForm;
		if ($objForm->HasValue("x_price") && $objForm->HasValue("o_price") && $this->price->CurrentValue <> $this->price->OldValue)
			return FALSE;
		if ($objForm->HasValue("x_oldprice") && $objForm->HasValue("o_oldprice") && $this->oldprice->CurrentValue <> $this->oldprice->OldValue)
			return FALSE;
		if ($objForm->HasValue("x_product_code") && $objForm->HasValue("o_product_code") && $this->product_code->CurrentValue <> $this->product_code->OldValue)
			return FALSE;
		if ($objForm->HasValue("x_product_name") && $objForm->HasValue("o_product_name") && $this->product_name->CurrentValue <> $this->product_name->OldValue)
			return FALSE;
		if ($objForm->HasValue("x_product_img_name") && $objForm->HasValue("o_product_img_name") && $this->product_img_name->CurrentValue <> $this->product_img_name->OldValue)
			return FALSE;
		if ($objForm->HasValue("x_img1") && $objForm->HasValue("o_img1") && $this->img1->CurrentValue <> $this->img1->OldValue)
			return FALSE;
		if ($objForm->HasValue("x_cat") && $objForm->HasValue("o_cat") && $this->cat->CurrentValue <> $this->cat->OldValue)
			return FALSE;
		if ($objForm->HasValue("x_subcat") && $objForm->HasValue("o_subcat") && $this->subcat->CurrentValue <> $this->subcat->OldValue)
			return FALSE;
		if ($objForm->HasValue("x_sales_status") && $objForm->HasValue("o_sales_status") && ew_ConvertToBool($this->sales_status->CurrentValue) <> ew_ConvertToBool($this->sales_status->OldValue))
			return FALSE;
		return TRUE;
	}

	// Validate grid form
	function ValidateGridForm() {
		global $objForm;

		// Get row count
		$objForm->Index = -1;
		$rowcnt = strval($objForm->GetValue($this->FormKeyCountName));
		if ($rowcnt == "" || !is_numeric($rowcnt))
			$rowcnt = 0;

		// Validate all records
		for ($rowindex = 1; $rowindex <= $rowcnt; $rowindex++) {

			// Load current row values
			$objForm->Index = $rowindex;
			$rowaction = strval($objForm->GetValue($this->FormActionName));
			if ($rowaction <> "delete" && $rowaction <> "insertdelete") {
				$this->LoadFormValues(); // Get form values
				if ($rowaction == "insert" && $this->EmptyRow()) {

					// Ignore
				} else if (!$this->ValidateForm()) {
					return FALSE;
				}
			}
		}
		return TRUE;
	}

	// Restore form values for current row
	function RestoreCurrentRowFormValues($idx) {
		global $objForm;

		// Get row based on current index
		$objForm->Index = $idx;
		$this->LoadFormValues(); // Load form values
	}

	// Advanced search WHERE clause based on QueryString
	function AdvancedSearchWhere() {
		global $Security;
		$sWhere = "";
		$this->BuildSearchSql($sWhere, $this->id, FALSE); // id
		$this->BuildSearchSql($sWhere, $this->price, FALSE); // price
		$this->BuildSearchSql($sWhere, $this->img2, FALSE); // img2
		$this->BuildSearchSql($sWhere, $this->img3, FALSE); // img3
		$this->BuildSearchSql($sWhere, $this->img4, FALSE); // img4
		$this->BuildSearchSql($sWhere, $this->rate_ord, FALSE); // rate_ord
		$this->BuildSearchSql($sWhere, $this->datep, FALSE); // datep
		$this->BuildSearchSql($sWhere, $this->oldprice, FALSE); // oldprice
		$this->BuildSearchSql($sWhere, $this->product_code, FALSE); // product_code
		$this->BuildSearchSql($sWhere, $this->product_name, FALSE); // product_name
		$this->BuildSearchSql($sWhere, $this->product_desc, FALSE); // product_desc
		$this->BuildSearchSql($sWhere, $this->product_img_name, FALSE); // product_img_name
		$this->BuildSearchSql($sWhere, $this->img1, FALSE); // img1
		$this->BuildSearchSql($sWhere, $this->cat, FALSE); // cat
		$this->BuildSearchSql($sWhere, $this->sized, FALSE); // sized
		$this->BuildSearchSql($sWhere, $this->subcat, FALSE); // subcat
		$this->BuildSearchSql($sWhere, $this->sales_status, FALSE); // sales_status

		// Set up search parm
		if ($sWhere <> "") {
			$this->Command = "search";
		}
		if ($this->Command == "search") {
			$this->id->AdvancedSearch->Save(); // id
			$this->price->AdvancedSearch->Save(); // price
			$this->img2->AdvancedSearch->Save(); // img2
			$this->img3->AdvancedSearch->Save(); // img3
			$this->img4->AdvancedSearch->Save(); // img4
			$this->rate_ord->AdvancedSearch->Save(); // rate_ord
			$this->datep->AdvancedSearch->Save(); // datep
			$this->oldprice->AdvancedSearch->Save(); // oldprice
			$this->product_code->AdvancedSearch->Save(); // product_code
			$this->product_name->AdvancedSearch->Save(); // product_name
			$this->product_desc->AdvancedSearch->Save(); // product_desc
			$this->product_img_name->AdvancedSearch->Save(); // product_img_name
			$this->img1->AdvancedSearch->Save(); // img1
			$this->cat->AdvancedSearch->Save(); // cat
			$this->sized->AdvancedSearch->Save(); // sized
			$this->subcat->AdvancedSearch->Save(); // subcat
			$this->sales_status->AdvancedSearch->Save(); // sales_status
		}
		return $sWhere;
	}

	// Build search SQL
	function BuildSearchSql(&$Where, &$Fld, $MultiValue) {
		$FldParm = substr($Fld->FldVar, 2);
		$FldVal = $Fld->AdvancedSearch->SearchValue; // @$_GET["x_$FldParm"]
		$FldOpr = $Fld->AdvancedSearch->SearchOperator; // @$_GET["z_$FldParm"]
		$FldCond = $Fld->AdvancedSearch->SearchCondition; // @$_GET["v_$FldParm"]
		$FldVal2 = $Fld->AdvancedSearch->SearchValue2; // @$_GET["y_$FldParm"]
		$FldOpr2 = $Fld->AdvancedSearch->SearchOperator2; // @$_GET["w_$FldParm"]
		$sWrk = "";

		//$FldVal = ew_StripSlashes($FldVal);
		if (is_array($FldVal)) $FldVal = implode(",", $FldVal);

		//$FldVal2 = ew_StripSlashes($FldVal2);
		if (is_array($FldVal2)) $FldVal2 = implode(",", $FldVal2);
		$FldOpr = strtoupper(trim($FldOpr));
		if ($FldOpr == "") $FldOpr = "=";
		$FldOpr2 = strtoupper(trim($FldOpr2));
		if ($FldOpr2 == "") $FldOpr2 = "=";
		if (EW_SEARCH_MULTI_VALUE_OPTION == 1 || $FldOpr <> "LIKE" ||
			($FldOpr2 <> "LIKE" && $FldVal2 <> ""))
			$MultiValue = FALSE;
		if ($MultiValue) {
			$sWrk1 = ($FldVal <> "") ? ew_GetMultiSearchSql($Fld, $FldOpr, $FldVal) : ""; // Field value 1
			$sWrk2 = ($FldVal2 <> "") ? ew_GetMultiSearchSql($Fld, $FldOpr2, $FldVal2) : ""; // Field value 2
			$sWrk = $sWrk1; // Build final SQL
			if ($sWrk2 <> "")
				$sWrk = ($sWrk <> "") ? "($sWrk) $FldCond ($sWrk2)" : $sWrk2;
		} else {
			$FldVal = $this->ConvertSearchValue($Fld, $FldVal);
			$FldVal2 = $this->ConvertSearchValue($Fld, $FldVal2);
			$sWrk = ew_GetSearchSql($Fld, $FldVal, $FldOpr, $FldCond, $FldVal2, $FldOpr2);
		}
		ew_AddFilter($Where, $sWrk);
	}

	// Convert search value
	function ConvertSearchValue(&$Fld, $FldVal) {
		if ($FldVal == EW_NULL_VALUE || $FldVal == EW_NOT_NULL_VALUE)
			return $FldVal;
		$Value = $FldVal;
		if ($Fld->FldDataType == EW_DATATYPE_BOOLEAN) {
			if ($FldVal <> "") $Value = ($FldVal == "1" || strtolower(strval($FldVal)) == "y" || strtolower(strval($FldVal)) == "t") ? $Fld->TrueValue : $Fld->FalseValue;
		} elseif ($Fld->FldDataType == EW_DATATYPE_DATE) {
			if ($FldVal <> "") $Value = ew_UnFormatDateTime($FldVal, $Fld->FldDateTimeFormat);
		}
		return $Value;
	}

	// Return basic search SQL
	function BasicSearchSQL($Keyword) {
		$sKeyword = ew_AdjustSql($Keyword);
		$sWhere = "";
		$this->BuildBasicSearchSQL($sWhere, $this->img2, $Keyword);
		$this->BuildBasicSearchSQL($sWhere, $this->img3, $Keyword);
		$this->BuildBasicSearchSQL($sWhere, $this->img4, $Keyword);
		$this->BuildBasicSearchSQL($sWhere, $this->product_code, $Keyword);
		$this->BuildBasicSearchSQL($sWhere, $this->product_name, $Keyword);
		$this->BuildBasicSearchSQL($sWhere, $this->product_desc, $Keyword);
		$this->BuildBasicSearchSQL($sWhere, $this->product_img_name, $Keyword);
		$this->BuildBasicSearchSQL($sWhere, $this->img1, $Keyword);
		$this->BuildBasicSearchSQL($sWhere, $this->cat, $Keyword);
		$this->BuildBasicSearchSQL($sWhere, $this->sized, $Keyword);
		$this->BuildBasicSearchSQL($sWhere, $this->subcat, $Keyword);
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
		if ($this->id->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->price->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->img2->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->img3->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->img4->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->rate_ord->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->datep->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->oldprice->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->product_code->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->product_name->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->product_desc->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->product_img_name->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->img1->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->cat->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->sized->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->subcat->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->sales_status->AdvancedSearch->IssetSession())
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

		// Clear advanced search parameters
		$this->ResetAdvancedSearchParms();
	}

	// Load advanced search default values
	function LoadAdvancedSearchDefault() {
		return FALSE;
	}

	// Clear all basic search parameters
	function ResetBasicSearchParms() {
		$this->BasicSearch->UnsetSession();
	}

	// Clear all advanced search parameters
	function ResetAdvancedSearchParms() {
		$this->id->AdvancedSearch->UnsetSession();
		$this->price->AdvancedSearch->UnsetSession();
		$this->img2->AdvancedSearch->UnsetSession();
		$this->img3->AdvancedSearch->UnsetSession();
		$this->img4->AdvancedSearch->UnsetSession();
		$this->rate_ord->AdvancedSearch->UnsetSession();
		$this->datep->AdvancedSearch->UnsetSession();
		$this->oldprice->AdvancedSearch->UnsetSession();
		$this->product_code->AdvancedSearch->UnsetSession();
		$this->product_name->AdvancedSearch->UnsetSession();
		$this->product_desc->AdvancedSearch->UnsetSession();
		$this->product_img_name->AdvancedSearch->UnsetSession();
		$this->img1->AdvancedSearch->UnsetSession();
		$this->cat->AdvancedSearch->UnsetSession();
		$this->sized->AdvancedSearch->UnsetSession();
		$this->subcat->AdvancedSearch->UnsetSession();
		$this->sales_status->AdvancedSearch->UnsetSession();
	}

	// Restore all search parameters
	function RestoreSearchParms() {
		$this->RestoreSearch = TRUE;

		// Restore basic search values
		$this->BasicSearch->Load();

		// Restore advanced search values
		$this->id->AdvancedSearch->Load();
		$this->price->AdvancedSearch->Load();
		$this->img2->AdvancedSearch->Load();
		$this->img3->AdvancedSearch->Load();
		$this->img4->AdvancedSearch->Load();
		$this->rate_ord->AdvancedSearch->Load();
		$this->datep->AdvancedSearch->Load();
		$this->oldprice->AdvancedSearch->Load();
		$this->product_code->AdvancedSearch->Load();
		$this->product_name->AdvancedSearch->Load();
		$this->product_desc->AdvancedSearch->Load();
		$this->product_img_name->AdvancedSearch->Load();
		$this->img1->AdvancedSearch->Load();
		$this->cat->AdvancedSearch->Load();
		$this->sized->AdvancedSearch->Load();
		$this->subcat->AdvancedSearch->Load();
		$this->sales_status->AdvancedSearch->Load();
	}

	// Set up sort parameters
	function SetUpSortOrder() {

		// Check for Ctrl pressed
		$bCtrl = (@$_GET["ctrl"] <> "");

		// Check for "order" parameter
		if (@$_GET["order"] <> "") {
			$this->CurrentOrder = ew_StripSlashes(@$_GET["order"]);
			$this->CurrentOrderType = @$_GET["ordertype"];
			$this->UpdateSort($this->price, $bCtrl); // price
			$this->UpdateSort($this->oldprice, $bCtrl); // oldprice
			$this->UpdateSort($this->product_code, $bCtrl); // product_code
			$this->UpdateSort($this->product_name, $bCtrl); // product_name
			$this->UpdateSort($this->product_img_name, $bCtrl); // product_img_name
			$this->UpdateSort($this->img1, $bCtrl); // img1
			$this->UpdateSort($this->cat, $bCtrl); // cat
			$this->UpdateSort($this->subcat, $bCtrl); // subcat
			$this->UpdateSort($this->sales_status, $bCtrl); // sales_status
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
				$this->price->setSort("");
				$this->oldprice->setSort("");
				$this->product_code->setSort("");
				$this->product_name->setSort("");
				$this->product_img_name->setSort("");
				$this->img1->setSort("");
				$this->cat->setSort("");
				$this->subcat->setSort("");
				$this->sales_status->setSort("");
			}

			// Reset start position
			$this->StartRec = 1;
			$this->setStartRecordNumber($this->StartRec);
		}
	}

	// Set up list options
	function SetupListOptions() {
		global $Security, $Language;

		// "griddelete"
		if ($this->AllowAddDeleteRow) {
			$item = &$this->ListOptions->Add("griddelete");
			$item->CssStyle = "white-space: nowrap;";
			$item->OnLeft = FALSE;
			$item->Visible = FALSE; // Default hidden
		}

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

		// "delete"
		if ($this->AllowAddDeleteRow) {
			if ($this->CurrentAction == "gridadd" || $this->CurrentAction == "gridedit") {
				$option = &$this->ListOptions;
				$option->UseButtonGroup = TRUE; // Use button group for grid delete button
				$option->UseImageAndText = TRUE; // Use image and text for grid delete button
				$oListOpt = &$option->Items["griddelete"];
				$oListOpt->Body = "<a class=\"ewGridLink ewGridDelete\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("DeleteLink")) . "\" href=\"javascript:void(0);\" onclick=\"ew_DeleteGridRow(this, " . $this->RowIndex . ");\">" . $Language->Phrase("DeleteLink") . "</a>";
			}
		}

		// "sequence"
		$oListOpt = &$this->ListOptions->Items["sequence"];
		$oListOpt->Body = ew_FormatSeqNo($this->RecCnt);

		// "copy"
		$oListOpt = &$this->ListOptions->Items["copy"];
		if (($this->CurrentAction == "add" || $this->CurrentAction == "copy") && $this->RowType == EW_ROWTYPE_ADD) { // Inline Add/Copy
			$this->ListOptions->CustomItem = "copy"; // Show copy column only
			$oListOpt->Body = "<div" . (($oListOpt->OnLeft) ? " style=\"text-align: right\"" : "") . ">" .
				"<a class=\"ewGridLink ewInlineInsert\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("InsertLink")) . "\" href=\"\" onclick=\"return ewForms(this).Submit();\">" . $Language->Phrase("InsertLink") . "</a>&nbsp;" .
				"<a class=\"ewGridLink ewInlineCancel\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("CancelLink")) . "\" href=\"" . $this->PageUrl() . "a=cancel\">" . $Language->Phrase("CancelLink") . "</a>" .
				"<input type=\"hidden\" name=\"a_list\" id=\"a_list\" value=\"insert\"></div>";
			return;
		}

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
			$oListOpt->Body = "<a class=\"ewRowLink ewEdit\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("EditLink")) . "\" href=\"" . ew_HtmlEncode($this->EditUrl) . "\">" . $Language->Phrase("EditLink") . "</a>";
			$oListOpt->Body .= "<span class=\"ewSeparator\">&nbsp;|&nbsp;</span>";
			$oListOpt->Body .= "<a class=\"ewRowLink ewInlineEdit\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("InlineEditLink")) . "\" href=\"" . ew_HtmlEncode(ew_GetHashUrl($this->InlineEditUrl, $this->PageObjName . "_row_" . $this->RowCnt)) . "\">" . $Language->Phrase("InlineEditLink") . "</a>";
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
		if ($this->CurrentAction == "gridedit" && is_numeric($this->RowIndex)) {
			$this->MultiSelectKey .= "<input type=\"hidden\" name=\"" . $KeyName . "\" id=\"" . $KeyName . "\" value=\"" . $this->id->CurrentValue . "\">";
		}
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

		// Inline Add
		$item = &$option->Add("inlineadd");
		$item->Body = "<a class=\"ewAddEdit ewInlineAdd\" href=\"" . ew_HtmlEncode($this->InlineAddUrl) . "\">" .$Language->Phrase("InlineAddLink") . "</a>";
		$item->Visible = ($this->InlineAddUrl <> "" && $Security->IsLoggedIn());
		$item = &$option->Add("gridadd");
		$item->Body = "<a class=\"ewAddEdit ewGridAdd\" href=\"" . ew_HtmlEncode($this->GridAddUrl) . "\">" . $Language->Phrase("GridAddLink") . "</a>";
		$item->Visible = ($this->GridAddUrl <> "" && $Security->IsLoggedIn());

		// Add grid edit
		$option = $options["addedit"];
		$item = &$option->Add("gridedit");
		$item->Body = "<a class=\"ewAddEdit ewGridEdit\" href=\"" . ew_HtmlEncode($this->GridEditUrl) . "\">" . $Language->Phrase("GridEditLink") . "</a>";
		$item->Visible = ($this->GridEditUrl <> "" && $Security->IsLoggedIn());
		$option = $options["action"];

		// Add multi delete
		$item = &$option->Add("multidelete");
		$item->Body = "<a class=\"ewAction ewMultiDelete\" href=\"\" onclick=\"ew_SubmitSelected(document.fproductslist, '" . $this->MultiDeleteUrl . "', ewLanguage.Phrase('DeleteMultiConfirmMsg'));return false;\">" . $Language->Phrase("DeleteSelectedLink") . "</a>";
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
		if ($this->CurrentAction <> "gridadd" && $this->CurrentAction <> "gridedit") { // Not grid add/edit mode
			$option = &$options["action"];
			foreach ($this->CustomActions as $action => $name) {

				// Add custom action
				$item = &$option->Add("custom_" . $action);
				$item->Body = "<a class=\"ewAction ewCustomAction\" href=\"\" onclick=\"ew_SubmitSelected(document.fproductslist, '" . ew_CurrentUrl() . "', null, '" . $action . "');return false;\">" . $name . "</a>";
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
		} else { // Grid add/edit mode

			// Hide all options first
			foreach ($options as &$option)
				$option->HideAllOptions();
			if ($this->CurrentAction == "gridadd") {
				if ($this->AllowAddDeleteRow) {

					// Add add blank row
					$option = &$options["addedit"];
					$option->UseDropDownButton = FALSE;
					$option->UseImageAndText = TRUE;
					$item = &$option->Add("addblankrow");
					$item->Body = "<a class=\"ewAddEdit ewAddBlankRow\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("AddBlankRow")) . "\" href=\"javascript:void(0);\" onclick=\"ew_AddGridRow(this);\">" . $Language->Phrase("AddBlankRow") . "</a>";
					$item->Visible = $Security->IsLoggedIn();
				}
				$option = &$options["action"];
				$option->UseDropDownButton = FALSE;
				$option->UseImageAndText = TRUE;

				// Add grid insert
				$item = &$option->Add("gridinsert");
				$item->Body = "<a class=\"ewAction ewGridInsert\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("GridInsertLink")) . "\" href=\"\" onclick=\"return ewForms(this).Submit();\">" . $Language->Phrase("GridInsertLink") . "</a>";

				// Add grid cancel
				$item = &$option->Add("gridcancel");
				$item->Body = "<a class=\"ewAction ewGridCancel\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("GridCancelLink")) . "\" href=\"" . $this->PageUrl() . "a=cancel\">" . $Language->Phrase("GridCancelLink") . "</a>";
			}
			if ($this->CurrentAction == "gridedit") {
				if ($this->AllowAddDeleteRow) {

					// Add add blank row
					$option = &$options["addedit"];
					$option->UseDropDownButton = FALSE;
					$option->UseImageAndText = TRUE;
					$item = &$option->Add("addblankrow");
					$item->Body = "<a class=\"ewAddEdit ewAddBlankRow\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("AddBlankRow")) . "\" href=\"javascript:void(0);\" onclick=\"ew_AddGridRow(this);\">" . $Language->Phrase("AddBlankRow") . "</a>";
					$item->Visible = $Security->IsLoggedIn();
				}
				$option = &$options["action"];
				$option->UseDropDownButton = FALSE;
				$option->UseImageAndText = TRUE;
					$item = &$option->Add("gridsave");
					$item->Body = "<a class=\"ewAction ewGridSave\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("GridSaveLink")) . "\" href=\"\" onclick=\"return ewForms(this).Submit();\">" . $Language->Phrase("GridSaveLink") . "</a>";
					$item = &$option->Add("gridcancel");
					$item->Body = "<a class=\"ewAction ewGridCancel\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("GridCancelLink")) . "\" href=\"" . $this->PageUrl() . "a=cancel\">" . $Language->Phrase("GridCancelLink") . "</a>";
			}
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
		$this->price->CurrentValue = NULL;
		$this->price->OldValue = $this->price->CurrentValue;
		$this->oldprice->CurrentValue = NULL;
		$this->oldprice->OldValue = $this->oldprice->CurrentValue;
		$this->product_code->CurrentValue = NULL;
		$this->product_code->OldValue = $this->product_code->CurrentValue;
		$this->product_name->CurrentValue = NULL;
		$this->product_name->OldValue = $this->product_name->CurrentValue;
		$this->product_img_name->CurrentValue = NULL;
		$this->product_img_name->OldValue = $this->product_img_name->CurrentValue;
		$this->img1->CurrentValue = NULL;
		$this->img1->OldValue = $this->img1->CurrentValue;
		$this->cat->CurrentValue = NULL;
		$this->cat->OldValue = $this->cat->CurrentValue;
		$this->subcat->CurrentValue = NULL;
		$this->subcat->OldValue = $this->subcat->CurrentValue;
		$this->sales_status->CurrentValue = "0";
		$this->sales_status->OldValue = $this->sales_status->CurrentValue;
	}

	// Load basic search values
	function LoadBasicSearchValues() {
		$this->BasicSearch->Keyword = @$_GET[EW_TABLE_BASIC_SEARCH];
		if ($this->BasicSearch->Keyword <> "") $this->Command = "search";
		$this->BasicSearch->Type = @$_GET[EW_TABLE_BASIC_SEARCH_TYPE];
	}

	//  Load search values for validation
	function LoadSearchValues() {
		global $objForm;

		// Load search values
		// id

		$this->id->AdvancedSearch->SearchValue = ew_StripSlashes(@$_GET["x_id"]);
		if ($this->id->AdvancedSearch->SearchValue <> "") $this->Command = "search";
		$this->id->AdvancedSearch->SearchOperator = @$_GET["z_id"];

		// price
		$this->price->AdvancedSearch->SearchValue = ew_StripSlashes(@$_GET["x_price"]);
		if ($this->price->AdvancedSearch->SearchValue <> "") $this->Command = "search";
		$this->price->AdvancedSearch->SearchOperator = @$_GET["z_price"];

		// img2
		$this->img2->AdvancedSearch->SearchValue = ew_StripSlashes(@$_GET["x_img2"]);
		if ($this->img2->AdvancedSearch->SearchValue <> "") $this->Command = "search";
		$this->img2->AdvancedSearch->SearchOperator = @$_GET["z_img2"];

		// img3
		$this->img3->AdvancedSearch->SearchValue = ew_StripSlashes(@$_GET["x_img3"]);
		if ($this->img3->AdvancedSearch->SearchValue <> "") $this->Command = "search";
		$this->img3->AdvancedSearch->SearchOperator = @$_GET["z_img3"];

		// img4
		$this->img4->AdvancedSearch->SearchValue = ew_StripSlashes(@$_GET["x_img4"]);
		if ($this->img4->AdvancedSearch->SearchValue <> "") $this->Command = "search";
		$this->img4->AdvancedSearch->SearchOperator = @$_GET["z_img4"];

		// rate_ord
		$this->rate_ord->AdvancedSearch->SearchValue = ew_StripSlashes(@$_GET["x_rate_ord"]);
		if ($this->rate_ord->AdvancedSearch->SearchValue <> "") $this->Command = "search";
		$this->rate_ord->AdvancedSearch->SearchOperator = @$_GET["z_rate_ord"];

		// datep
		$this->datep->AdvancedSearch->SearchValue = ew_StripSlashes(@$_GET["x_datep"]);
		if ($this->datep->AdvancedSearch->SearchValue <> "") $this->Command = "search";
		$this->datep->AdvancedSearch->SearchOperator = @$_GET["z_datep"];

		// oldprice
		$this->oldprice->AdvancedSearch->SearchValue = ew_StripSlashes(@$_GET["x_oldprice"]);
		if ($this->oldprice->AdvancedSearch->SearchValue <> "") $this->Command = "search";
		$this->oldprice->AdvancedSearch->SearchOperator = @$_GET["z_oldprice"];

		// product_code
		$this->product_code->AdvancedSearch->SearchValue = ew_StripSlashes(@$_GET["x_product_code"]);
		if ($this->product_code->AdvancedSearch->SearchValue <> "") $this->Command = "search";
		$this->product_code->AdvancedSearch->SearchOperator = @$_GET["z_product_code"];

		// product_name
		$this->product_name->AdvancedSearch->SearchValue = ew_StripSlashes(@$_GET["x_product_name"]);
		if ($this->product_name->AdvancedSearch->SearchValue <> "") $this->Command = "search";
		$this->product_name->AdvancedSearch->SearchOperator = @$_GET["z_product_name"];

		// product_desc
		$this->product_desc->AdvancedSearch->SearchValue = ew_StripSlashes(@$_GET["x_product_desc"]);
		if ($this->product_desc->AdvancedSearch->SearchValue <> "") $this->Command = "search";
		$this->product_desc->AdvancedSearch->SearchOperator = @$_GET["z_product_desc"];

		// product_img_name
		$this->product_img_name->AdvancedSearch->SearchValue = ew_StripSlashes(@$_GET["x_product_img_name"]);
		if ($this->product_img_name->AdvancedSearch->SearchValue <> "") $this->Command = "search";
		$this->product_img_name->AdvancedSearch->SearchOperator = @$_GET["z_product_img_name"];

		// img1
		$this->img1->AdvancedSearch->SearchValue = ew_StripSlashes(@$_GET["x_img1"]);
		if ($this->img1->AdvancedSearch->SearchValue <> "") $this->Command = "search";
		$this->img1->AdvancedSearch->SearchOperator = @$_GET["z_img1"];

		// cat
		$this->cat->AdvancedSearch->SearchValue = ew_StripSlashes(@$_GET["x_cat"]);
		if ($this->cat->AdvancedSearch->SearchValue <> "") $this->Command = "search";
		$this->cat->AdvancedSearch->SearchOperator = @$_GET["z_cat"];

		// sized
		$this->sized->AdvancedSearch->SearchValue = ew_StripSlashes(@$_GET["x_sized"]);
		if ($this->sized->AdvancedSearch->SearchValue <> "") $this->Command = "search";
		$this->sized->AdvancedSearch->SearchOperator = @$_GET["z_sized"];

		// subcat
		$this->subcat->AdvancedSearch->SearchValue = ew_StripSlashes(@$_GET["x_subcat"]);
		if ($this->subcat->AdvancedSearch->SearchValue <> "") $this->Command = "search";
		$this->subcat->AdvancedSearch->SearchOperator = @$_GET["z_subcat"];

		// sales_status
		$this->sales_status->AdvancedSearch->SearchValue = ew_StripSlashes(@$_GET["x_sales_status"]);
		if ($this->sales_status->AdvancedSearch->SearchValue <> "") $this->Command = "search";
		$this->sales_status->AdvancedSearch->SearchOperator = @$_GET["z_sales_status"];
	}

	// Load form values
	function LoadFormValues() {

		// Load from form
		global $objForm;
		if (!$this->price->FldIsDetailKey) {
			$this->price->setFormValue($objForm->GetValue("x_price"));
		}
		$this->price->setOldValue($objForm->GetValue("o_price"));
		if (!$this->oldprice->FldIsDetailKey) {
			$this->oldprice->setFormValue($objForm->GetValue("x_oldprice"));
		}
		$this->oldprice->setOldValue($objForm->GetValue("o_oldprice"));
		if (!$this->product_code->FldIsDetailKey) {
			$this->product_code->setFormValue($objForm->GetValue("x_product_code"));
		}
		$this->product_code->setOldValue($objForm->GetValue("o_product_code"));
		if (!$this->product_name->FldIsDetailKey) {
			$this->product_name->setFormValue($objForm->GetValue("x_product_name"));
		}
		$this->product_name->setOldValue($objForm->GetValue("o_product_name"));
		if (!$this->product_img_name->FldIsDetailKey) {
			$this->product_img_name->setFormValue($objForm->GetValue("x_product_img_name"));
		}
		$this->product_img_name->setOldValue($objForm->GetValue("o_product_img_name"));
		if (!$this->img1->FldIsDetailKey) {
			$this->img1->setFormValue($objForm->GetValue("x_img1"));
		}
		$this->img1->setOldValue($objForm->GetValue("o_img1"));
		if (!$this->cat->FldIsDetailKey) {
			$this->cat->setFormValue($objForm->GetValue("x_cat"));
		}
		$this->cat->setOldValue($objForm->GetValue("o_cat"));
		if (!$this->subcat->FldIsDetailKey) {
			$this->subcat->setFormValue($objForm->GetValue("x_subcat"));
		}
		$this->subcat->setOldValue($objForm->GetValue("o_subcat"));
		if (!$this->sales_status->FldIsDetailKey) {
			$this->sales_status->setFormValue($objForm->GetValue("x_sales_status"));
		}
		$this->sales_status->setOldValue($objForm->GetValue("o_sales_status"));
		if (!$this->id->FldIsDetailKey && $this->CurrentAction <> "gridadd" && $this->CurrentAction <> "add")
			$this->id->setFormValue($objForm->GetValue("x_id"));
	}

	// Restore form values
	function RestoreFormValues() {
		global $objForm;
		if ($this->CurrentAction <> "gridadd" && $this->CurrentAction <> "add")
			$this->id->CurrentValue = $this->id->FormValue;
		$this->price->CurrentValue = $this->price->FormValue;
		$this->oldprice->CurrentValue = $this->oldprice->FormValue;
		$this->product_code->CurrentValue = $this->product_code->FormValue;
		$this->product_name->CurrentValue = $this->product_name->FormValue;
		$this->product_img_name->CurrentValue = $this->product_img_name->FormValue;
		$this->img1->CurrentValue = $this->img1->FormValue;
		$this->cat->CurrentValue = $this->cat->FormValue;
		$this->subcat->CurrentValue = $this->subcat->FormValue;
		$this->sales_status->CurrentValue = $this->sales_status->FormValue;
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
		$this->price->setDbValue($rs->fields('price'));
		$this->img2->Upload->DbValue = $rs->fields('img2');
		$this->img3->Upload->DbValue = $rs->fields('img3');
		$this->img4->Upload->DbValue = $rs->fields('img4');
		$this->rate_ord->setDbValue($rs->fields('rate_ord'));
		$this->datep->setDbValue($rs->fields('datep'));
		$this->oldprice->setDbValue($rs->fields('oldprice'));
		$this->product_code->setDbValue($rs->fields('product_code'));
		$this->product_name->setDbValue($rs->fields('product_name'));
		$this->product_desc->setDbValue($rs->fields('product_desc'));
		$this->product_img_name->setDbValue($rs->fields('product_img_name'));
		$this->img1->setDbValue($rs->fields('img1'));
		$this->cat->setDbValue($rs->fields('cat'));
		$this->sized->setDbValue($rs->fields('sized'));
		$this->subcat->setDbValue($rs->fields('subcat'));
		$this->sales_status->setDbValue($rs->fields('sales_status'));
	}

	// Load DbValue from recordset
	function LoadDbValues(&$rs) {
		if (!$rs || !is_array($rs) && $rs->EOF) return;
		$row = is_array($rs) ? $rs : $rs->fields;
		$this->id->DbValue = $row['id'];
		$this->price->DbValue = $row['price'];
		$this->img2->Upload->DbValue = $row['img2'];
		$this->img3->Upload->DbValue = $row['img3'];
		$this->img4->Upload->DbValue = $row['img4'];
		$this->rate_ord->DbValue = $row['rate_ord'];
		$this->datep->DbValue = $row['datep'];
		$this->oldprice->DbValue = $row['oldprice'];
		$this->product_code->DbValue = $row['product_code'];
		$this->product_name->DbValue = $row['product_name'];
		$this->product_desc->DbValue = $row['product_desc'];
		$this->product_img_name->DbValue = $row['product_img_name'];
		$this->img1->DbValue = $row['img1'];
		$this->cat->DbValue = $row['cat'];
		$this->sized->DbValue = $row['sized'];
		$this->subcat->DbValue = $row['subcat'];
		$this->sales_status->DbValue = $row['sales_status'];
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

		// Convert decimal values if posted back
		if ($this->price->FormValue == $this->price->CurrentValue && is_numeric(ew_StrToFloat($this->price->CurrentValue)))
			$this->price->CurrentValue = ew_StrToFloat($this->price->CurrentValue);

		// Call Row_Rendering event
		$this->Row_Rendering();

		// Common render codes for all row types
		// id
		// price
		// img2
		// img3
		// img4
		// rate_ord
		// datep
		// oldprice
		// product_code
		// product_name
		// product_desc
		// product_img_name
		// img1
		// cat
		// sized
		// subcat
		// sales_status

		if ($this->RowType == EW_ROWTYPE_VIEW) { // View row

			// id
			$this->id->ViewValue = $this->id->CurrentValue;
			$this->id->ViewCustomAttributes = "";

			// price
			$this->price->ViewValue = $this->price->CurrentValue;
			$this->price->ViewValue = ew_FormatCurrency($this->price->ViewValue, 2, -2, -2, -2);
			$this->price->ViewCustomAttributes = "";

			// img2
			$this->img2->UploadPath = "../uploads/products/";
			if (!ew_Empty($this->img2->Upload->DbValue)) {
				$this->img2->ViewValue = $this->img2->Upload->DbValue;
			} else {
				$this->img2->ViewValue = "";
			}
			$this->img2->ViewCustomAttributes = "";

			// img3
			$this->img3->UploadPath = "../uploads/products/";
			if (!ew_Empty($this->img3->Upload->DbValue)) {
				$this->img3->ViewValue = $this->img3->Upload->DbValue;
			} else {
				$this->img3->ViewValue = "";
			}
			$this->img3->ViewCustomAttributes = "";

			// img4
			$this->img4->UploadPath = "../uploads/products/";
			if (!ew_Empty($this->img4->Upload->DbValue)) {
				$this->img4->ViewValue = $this->img4->Upload->DbValue;
			} else {
				$this->img4->ViewValue = "";
			}
			$this->img4->ViewCustomAttributes = "";

			// rate_ord
			if (strval($this->rate_ord->CurrentValue) <> "") {
				switch ($this->rate_ord->CurrentValue) {
					case $this->rate_ord->FldTagValue(1):
						$this->rate_ord->ViewValue = $this->rate_ord->FldTagCaption(1) <> "" ? $this->rate_ord->FldTagCaption(1) : $this->rate_ord->CurrentValue;
						break;
					case $this->rate_ord->FldTagValue(2):
						$this->rate_ord->ViewValue = $this->rate_ord->FldTagCaption(2) <> "" ? $this->rate_ord->FldTagCaption(2) : $this->rate_ord->CurrentValue;
						break;
					case $this->rate_ord->FldTagValue(3):
						$this->rate_ord->ViewValue = $this->rate_ord->FldTagCaption(3) <> "" ? $this->rate_ord->FldTagCaption(3) : $this->rate_ord->CurrentValue;
						break;
					case $this->rate_ord->FldTagValue(4):
						$this->rate_ord->ViewValue = $this->rate_ord->FldTagCaption(4) <> "" ? $this->rate_ord->FldTagCaption(4) : $this->rate_ord->CurrentValue;
						break;
					case $this->rate_ord->FldTagValue(5):
						$this->rate_ord->ViewValue = $this->rate_ord->FldTagCaption(5) <> "" ? $this->rate_ord->FldTagCaption(5) : $this->rate_ord->CurrentValue;
						break;
					case $this->rate_ord->FldTagValue(6):
						$this->rate_ord->ViewValue = $this->rate_ord->FldTagCaption(6) <> "" ? $this->rate_ord->FldTagCaption(6) : $this->rate_ord->CurrentValue;
						break;
					case $this->rate_ord->FldTagValue(7):
						$this->rate_ord->ViewValue = $this->rate_ord->FldTagCaption(7) <> "" ? $this->rate_ord->FldTagCaption(7) : $this->rate_ord->CurrentValue;
						break;
					case $this->rate_ord->FldTagValue(8):
						$this->rate_ord->ViewValue = $this->rate_ord->FldTagCaption(8) <> "" ? $this->rate_ord->FldTagCaption(8) : $this->rate_ord->CurrentValue;
						break;
					case $this->rate_ord->FldTagValue(9):
						$this->rate_ord->ViewValue = $this->rate_ord->FldTagCaption(9) <> "" ? $this->rate_ord->FldTagCaption(9) : $this->rate_ord->CurrentValue;
						break;
					case $this->rate_ord->FldTagValue(10):
						$this->rate_ord->ViewValue = $this->rate_ord->FldTagCaption(10) <> "" ? $this->rate_ord->FldTagCaption(10) : $this->rate_ord->CurrentValue;
						break;
					case $this->rate_ord->FldTagValue(11):
						$this->rate_ord->ViewValue = $this->rate_ord->FldTagCaption(11) <> "" ? $this->rate_ord->FldTagCaption(11) : $this->rate_ord->CurrentValue;
						break;
					default:
						$this->rate_ord->ViewValue = $this->rate_ord->CurrentValue;
				}
			} else {
				$this->rate_ord->ViewValue = NULL;
			}
			$this->rate_ord->ViewCustomAttributes = "";

			// datep
			$this->datep->ViewValue = $this->datep->CurrentValue;
			$this->datep->ViewCustomAttributes = "";

			// oldprice
			$this->oldprice->ViewValue = $this->oldprice->CurrentValue;
			$this->oldprice->ViewCustomAttributes = "";

			// product_code
			$this->product_code->ViewValue = $this->product_code->CurrentValue;
			$this->product_code->ViewCustomAttributes = "";

			// product_name
			$this->product_name->ViewValue = $this->product_name->CurrentValue;
			$this->product_name->ViewCustomAttributes = "";

			// product_img_name
			$this->product_img_name->ViewValue = $this->product_img_name->CurrentValue;
			$this->product_img_name->ViewCustomAttributes = "";

			// img1
			$this->img1->ViewValue = $this->img1->CurrentValue;
			$this->img1->ViewCustomAttributes = "";

			// cat
			$this->cat->ViewValue = $this->cat->CurrentValue;
			$this->cat->ViewCustomAttributes = "";

			// subcat
			$this->subcat->ViewValue = $this->subcat->CurrentValue;
			$this->subcat->ViewCustomAttributes = "";

			// sales_status
			if (ew_ConvertToBool($this->sales_status->CurrentValue)) {
				$this->sales_status->ViewValue = $this->sales_status->FldTagCaption(2) <> "" ? $this->sales_status->FldTagCaption(2) : "1";
			} else {
				$this->sales_status->ViewValue = $this->sales_status->FldTagCaption(1) <> "" ? $this->sales_status->FldTagCaption(1) : "0";
			}
			$this->sales_status->ViewCustomAttributes = "";

			// price
			$this->price->LinkCustomAttributes = "";
			$this->price->HrefValue = "";
			$this->price->TooltipValue = "";

			// oldprice
			$this->oldprice->LinkCustomAttributes = "";
			$this->oldprice->HrefValue = "";
			$this->oldprice->TooltipValue = "";

			// product_code
			$this->product_code->LinkCustomAttributes = "";
			$this->product_code->HrefValue = "";
			$this->product_code->TooltipValue = "";

			// product_name
			$this->product_name->LinkCustomAttributes = "";
			$this->product_name->HrefValue = "";
			$this->product_name->TooltipValue = "";

			// product_img_name
			$this->product_img_name->LinkCustomAttributes = "";
			$this->product_img_name->HrefValue = "";
			$this->product_img_name->TooltipValue = "";

			// img1
			$this->img1->LinkCustomAttributes = "";
			$this->img1->HrefValue = "";
			$this->img1->TooltipValue = "";

			// cat
			$this->cat->LinkCustomAttributes = "";
			$this->cat->HrefValue = "";
			$this->cat->TooltipValue = "";

			// subcat
			$this->subcat->LinkCustomAttributes = "";
			$this->subcat->HrefValue = "";
			$this->subcat->TooltipValue = "";

			// sales_status
			$this->sales_status->LinkCustomAttributes = "";
			$this->sales_status->HrefValue = "";
			$this->sales_status->TooltipValue = "";
		} elseif ($this->RowType == EW_ROWTYPE_ADD) { // Add row

			// price
			$this->price->EditCustomAttributes = "";
			$this->price->EditValue = ew_HtmlEncode($this->price->CurrentValue);
			$this->price->PlaceHolder = ew_HtmlEncode(ew_RemoveHtml($this->price->FldCaption()));
			if (strval($this->price->EditValue) <> "" && is_numeric($this->price->EditValue)) {
			$this->price->EditValue = ew_FormatNumber($this->price->EditValue, -2, -2, -2, -2);
			$this->price->OldValue = $this->price->EditValue;
			}

			// oldprice
			$this->oldprice->EditCustomAttributes = "";
			$this->oldprice->EditValue = ew_HtmlEncode($this->oldprice->CurrentValue);
			$this->oldprice->PlaceHolder = ew_HtmlEncode(ew_RemoveHtml($this->oldprice->FldCaption()));

			// product_code
			$this->product_code->EditCustomAttributes = "";
			$this->product_code->EditValue = ew_HtmlEncode($this->product_code->CurrentValue);
			$this->product_code->PlaceHolder = ew_HtmlEncode(ew_RemoveHtml($this->product_code->FldCaption()));

			// product_name
			$this->product_name->EditCustomAttributes = "";
			$this->product_name->EditValue = ew_HtmlEncode($this->product_name->CurrentValue);
			$this->product_name->PlaceHolder = ew_HtmlEncode(ew_RemoveHtml($this->product_name->FldCaption()));

			// product_img_name
			$this->product_img_name->EditCustomAttributes = "";
			$this->product_img_name->EditValue = ew_HtmlEncode($this->product_img_name->CurrentValue);
			$this->product_img_name->PlaceHolder = ew_HtmlEncode(ew_RemoveHtml($this->product_img_name->FldCaption()));

			// img1
			$this->img1->EditCustomAttributes = "";
			$this->img1->EditValue = ew_HtmlEncode($this->img1->CurrentValue);
			$this->img1->PlaceHolder = ew_HtmlEncode(ew_RemoveHtml($this->img1->FldCaption()));

			// cat
			$this->cat->EditCustomAttributes = "";
			$this->cat->EditValue = ew_HtmlEncode($this->cat->CurrentValue);
			$this->cat->PlaceHolder = ew_HtmlEncode(ew_RemoveHtml($this->cat->FldCaption()));

			// subcat
			$this->subcat->EditCustomAttributes = "";
			$this->subcat->EditValue = ew_HtmlEncode($this->subcat->CurrentValue);
			$this->subcat->PlaceHolder = ew_HtmlEncode(ew_RemoveHtml($this->subcat->FldCaption()));

			// sales_status
			$this->sales_status->EditCustomAttributes = "";
			$arwrk = array();
			$arwrk[] = array($this->sales_status->FldTagValue(1), $this->sales_status->FldTagCaption(1) <> "" ? $this->sales_status->FldTagCaption(1) : $this->sales_status->FldTagValue(1));
			$arwrk[] = array($this->sales_status->FldTagValue(2), $this->sales_status->FldTagCaption(2) <> "" ? $this->sales_status->FldTagCaption(2) : $this->sales_status->FldTagValue(2));
			$this->sales_status->EditValue = $arwrk;

			// Edit refer script
			// price

			$this->price->HrefValue = "";

			// oldprice
			$this->oldprice->HrefValue = "";

			// product_code
			$this->product_code->HrefValue = "";

			// product_name
			$this->product_name->HrefValue = "";

			// product_img_name
			$this->product_img_name->HrefValue = "";

			// img1
			$this->img1->HrefValue = "";

			// cat
			$this->cat->HrefValue = "";

			// subcat
			$this->subcat->HrefValue = "";

			// sales_status
			$this->sales_status->HrefValue = "";
		} elseif ($this->RowType == EW_ROWTYPE_EDIT) { // Edit row

			// price
			$this->price->EditCustomAttributes = "";
			$this->price->EditValue = ew_HtmlEncode($this->price->CurrentValue);
			$this->price->PlaceHolder = ew_HtmlEncode(ew_RemoveHtml($this->price->FldCaption()));
			if (strval($this->price->EditValue) <> "" && is_numeric($this->price->EditValue)) {
			$this->price->EditValue = ew_FormatNumber($this->price->EditValue, -2, -2, -2, -2);
			$this->price->OldValue = $this->price->EditValue;
			}

			// oldprice
			$this->oldprice->EditCustomAttributes = "";
			$this->oldprice->EditValue = ew_HtmlEncode($this->oldprice->CurrentValue);
			$this->oldprice->PlaceHolder = ew_HtmlEncode(ew_RemoveHtml($this->oldprice->FldCaption()));

			// product_code
			$this->product_code->EditCustomAttributes = "";
			$this->product_code->EditValue = ew_HtmlEncode($this->product_code->CurrentValue);
			$this->product_code->PlaceHolder = ew_HtmlEncode(ew_RemoveHtml($this->product_code->FldCaption()));

			// product_name
			$this->product_name->EditCustomAttributes = "";
			$this->product_name->EditValue = ew_HtmlEncode($this->product_name->CurrentValue);
			$this->product_name->PlaceHolder = ew_HtmlEncode(ew_RemoveHtml($this->product_name->FldCaption()));

			// product_img_name
			$this->product_img_name->EditCustomAttributes = "";
			$this->product_img_name->EditValue = ew_HtmlEncode($this->product_img_name->CurrentValue);
			$this->product_img_name->PlaceHolder = ew_HtmlEncode(ew_RemoveHtml($this->product_img_name->FldCaption()));

			// img1
			$this->img1->EditCustomAttributes = "";
			$this->img1->EditValue = ew_HtmlEncode($this->img1->CurrentValue);
			$this->img1->PlaceHolder = ew_HtmlEncode(ew_RemoveHtml($this->img1->FldCaption()));

			// cat
			$this->cat->EditCustomAttributes = "";
			$this->cat->EditValue = ew_HtmlEncode($this->cat->CurrentValue);
			$this->cat->PlaceHolder = ew_HtmlEncode(ew_RemoveHtml($this->cat->FldCaption()));

			// subcat
			$this->subcat->EditCustomAttributes = "";
			$this->subcat->EditValue = ew_HtmlEncode($this->subcat->CurrentValue);
			$this->subcat->PlaceHolder = ew_HtmlEncode(ew_RemoveHtml($this->subcat->FldCaption()));

			// sales_status
			$this->sales_status->EditCustomAttributes = "";
			$arwrk = array();
			$arwrk[] = array($this->sales_status->FldTagValue(1), $this->sales_status->FldTagCaption(1) <> "" ? $this->sales_status->FldTagCaption(1) : $this->sales_status->FldTagValue(1));
			$arwrk[] = array($this->sales_status->FldTagValue(2), $this->sales_status->FldTagCaption(2) <> "" ? $this->sales_status->FldTagCaption(2) : $this->sales_status->FldTagValue(2));
			$this->sales_status->EditValue = $arwrk;

			// Edit refer script
			// price

			$this->price->HrefValue = "";

			// oldprice
			$this->oldprice->HrefValue = "";

			// product_code
			$this->product_code->HrefValue = "";

			// product_name
			$this->product_name->HrefValue = "";

			// product_img_name
			$this->product_img_name->HrefValue = "";

			// img1
			$this->img1->HrefValue = "";

			// cat
			$this->cat->HrefValue = "";

			// subcat
			$this->subcat->HrefValue = "";

			// sales_status
			$this->sales_status->HrefValue = "";
		} elseif ($this->RowType == EW_ROWTYPE_SEARCH) { // Search row

			// price
			$this->price->EditCustomAttributes = "";
			$this->price->EditValue = ew_HtmlEncode($this->price->AdvancedSearch->SearchValue);
			$this->price->PlaceHolder = ew_HtmlEncode(ew_RemoveHtml($this->price->FldCaption()));

			// oldprice
			$this->oldprice->EditCustomAttributes = "";
			$this->oldprice->EditValue = ew_HtmlEncode($this->oldprice->AdvancedSearch->SearchValue);
			$this->oldprice->PlaceHolder = ew_HtmlEncode(ew_RemoveHtml($this->oldprice->FldCaption()));

			// product_code
			$this->product_code->EditCustomAttributes = "";
			$this->product_code->EditValue = ew_HtmlEncode($this->product_code->AdvancedSearch->SearchValue);
			$this->product_code->PlaceHolder = ew_HtmlEncode(ew_RemoveHtml($this->product_code->FldCaption()));

			// product_name
			$this->product_name->EditCustomAttributes = "";
			$this->product_name->EditValue = ew_HtmlEncode($this->product_name->AdvancedSearch->SearchValue);
			$this->product_name->PlaceHolder = ew_HtmlEncode(ew_RemoveHtml($this->product_name->FldCaption()));

			// product_img_name
			$this->product_img_name->EditCustomAttributes = "";
			$this->product_img_name->EditValue = ew_HtmlEncode($this->product_img_name->AdvancedSearch->SearchValue);
			$this->product_img_name->PlaceHolder = ew_HtmlEncode(ew_RemoveHtml($this->product_img_name->FldCaption()));

			// img1
			$this->img1->EditCustomAttributes = "";
			$this->img1->EditValue = ew_HtmlEncode($this->img1->AdvancedSearch->SearchValue);
			$this->img1->PlaceHolder = ew_HtmlEncode(ew_RemoveHtml($this->img1->FldCaption()));

			// cat
			$this->cat->EditCustomAttributes = "";
			$this->cat->EditValue = ew_HtmlEncode($this->cat->AdvancedSearch->SearchValue);
			$this->cat->PlaceHolder = ew_HtmlEncode(ew_RemoveHtml($this->cat->FldCaption()));

			// subcat
			$this->subcat->EditCustomAttributes = "";
			$this->subcat->EditValue = ew_HtmlEncode($this->subcat->AdvancedSearch->SearchValue);
			$this->subcat->PlaceHolder = ew_HtmlEncode(ew_RemoveHtml($this->subcat->FldCaption()));

			// sales_status
			$this->sales_status->EditCustomAttributes = "";
			$arwrk = array();
			$arwrk[] = array($this->sales_status->FldTagValue(1), $this->sales_status->FldTagCaption(1) <> "" ? $this->sales_status->FldTagCaption(1) : $this->sales_status->FldTagValue(1));
			$arwrk[] = array($this->sales_status->FldTagValue(2), $this->sales_status->FldTagCaption(2) <> "" ? $this->sales_status->FldTagCaption(2) : $this->sales_status->FldTagValue(2));
			$this->sales_status->EditValue = $arwrk;
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

	// Validate search
	function ValidateSearch() {
		global $gsSearchError;

		// Initialize
		$gsSearchError = "";

		// Check if validation required
		if (!EW_SERVER_VALIDATE)
			return TRUE;

		// Return validate result
		$ValidateSearch = ($gsSearchError == "");

		// Call Form_CustomValidate event
		$sFormCustomError = "";
		$ValidateSearch = $ValidateSearch && $this->Form_CustomValidate($sFormCustomError);
		if ($sFormCustomError <> "") {
			ew_AddMessage($gsSearchError, $sFormCustomError);
		}
		return $ValidateSearch;
	}

	// Validate form
	function ValidateForm() {
		global $Language, $gsFormError;

		// Initialize form error message
		$gsFormError = "";

		// Check if validation required
		if (!EW_SERVER_VALIDATE)
			return ($gsFormError == "");
		if (!$this->price->FldIsDetailKey && !is_null($this->price->FormValue) && $this->price->FormValue == "") {
			ew_AddMessage($gsFormError, $Language->Phrase("EnterRequiredField") . " - " . $this->price->FldCaption());
		}
		if (!ew_CheckNumber($this->price->FormValue)) {
			ew_AddMessage($gsFormError, $this->price->FldErrMsg());
		}
		if (!ew_CheckNumber($this->oldprice->FormValue)) {
			ew_AddMessage($gsFormError, $this->oldprice->FldErrMsg());
		}
		if (!$this->product_code->FldIsDetailKey && !is_null($this->product_code->FormValue) && $this->product_code->FormValue == "") {
			ew_AddMessage($gsFormError, $Language->Phrase("EnterRequiredField") . " - " . $this->product_code->FldCaption());
		}
		if (!$this->product_name->FldIsDetailKey && !is_null($this->product_name->FormValue) && $this->product_name->FormValue == "") {
			ew_AddMessage($gsFormError, $Language->Phrase("EnterRequiredField") . " - " . $this->product_name->FldCaption());
		}
		if (!$this->product_img_name->FldIsDetailKey && !is_null($this->product_img_name->FormValue) && $this->product_img_name->FormValue == "") {
			ew_AddMessage($gsFormError, $Language->Phrase("EnterRequiredField") . " - " . $this->product_img_name->FldCaption());
		}
		if ($this->sales_status->FormValue == "") {
			ew_AddMessage($gsFormError, $Language->Phrase("EnterRequiredField") . " - " . $this->sales_status->FldCaption());
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

	//
	// Delete records based on current filter
	//
	function DeleteRows() {
		global $conn, $Language, $Security;
		$DeleteRows = TRUE;
		$sSql = $this->SQL();
		$conn->raiseErrorFn = 'ew_ErrorFn';
		$rs = $conn->Execute($sSql);
		$conn->raiseErrorFn = '';
		if ($rs === FALSE) {
			return FALSE;
		} elseif ($rs->EOF) {
			$this->setFailureMessage($Language->Phrase("NoRecord")); // No record found
			$rs->Close();
			return FALSE;

		//} else {
		//	$this->LoadRowValues($rs); // Load row values

		}

		// Clone old rows
		$rsold = ($rs) ? $rs->GetRows() : array();
		if ($rs)
			$rs->Close();

		// Call row deleting event
		if ($DeleteRows) {
			foreach ($rsold as $row) {
				$DeleteRows = $this->Row_Deleting($row);
				if (!$DeleteRows) break;
			}
		}
		if ($DeleteRows) {
			$sKey = "";
			foreach ($rsold as $row) {
				$sThisKey = "";
				if ($sThisKey <> "") $sThisKey .= $GLOBALS["EW_COMPOSITE_KEY_SEPARATOR"];
				$sThisKey .= $row['id'];
				$this->LoadDbValues($row);
				$this->img2->OldUploadPath = "../uploads/products/";
				@unlink(ew_UploadPathEx(TRUE, $this->img2->OldUploadPath) . $row['img2']);
				$this->img3->OldUploadPath = "../uploads/products/";
				@unlink(ew_UploadPathEx(TRUE, $this->img3->OldUploadPath) . $row['img3']);
				$this->img4->OldUploadPath = "../uploads/products/";
				@unlink(ew_UploadPathEx(TRUE, $this->img4->OldUploadPath) . $row['img4']);
				$conn->raiseErrorFn = 'ew_ErrorFn';
				$DeleteRows = $this->Delete($row); // Delete
				$conn->raiseErrorFn = '';
				if ($DeleteRows === FALSE)
					break;
				if ($sKey <> "") $sKey .= ", ";
				$sKey .= $sThisKey;
			}
		} else {

			// Set up error message
			if ($this->getSuccessMessage() <> "" || $this->getFailureMessage() <> "") {

				// Use the message, do nothing
			} elseif ($this->CancelMessage <> "") {
				$this->setFailureMessage($this->CancelMessage);
				$this->CancelMessage = "";
			} else {
				$this->setFailureMessage($Language->Phrase("DeleteCancelled"));
			}
		}
		if ($DeleteRows) {
		} else {
		}

		// Call Row Deleted event
		if ($DeleteRows) {
			foreach ($rsold as $row) {
				$this->Row_Deleted($row);
			}
		}
		return $DeleteRows;
	}

	// Update record based on key values
	function EditRow() {
		global $conn, $Security, $Language;
		$sFilter = $this->KeyFilter();
			if ($this->product_code->CurrentValue <> "") { // Check field with unique index
			$sFilterChk = "(`product_code` = '" . ew_AdjustSql($this->product_code->CurrentValue) . "')";
			$sFilterChk .= " AND NOT (" . $sFilter . ")";
			$this->CurrentFilter = $sFilterChk;
			$sSqlChk = $this->SQL();
			$conn->raiseErrorFn = 'ew_ErrorFn';
			$rsChk = $conn->Execute($sSqlChk);
			$conn->raiseErrorFn = '';
			if ($rsChk === FALSE) {
				return FALSE;
			} elseif (!$rsChk->EOF) {
				$sIdxErrMsg = str_replace("%f", $this->product_code->FldCaption(), $Language->Phrase("DupIndex"));
				$sIdxErrMsg = str_replace("%v", $this->product_code->CurrentValue, $sIdxErrMsg);
				$this->setFailureMessage($sIdxErrMsg);
				$rsChk->Close();
				return FALSE;
			}
			$rsChk->Close();
		}
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
			$this->img2->OldUploadPath = "../uploads/products/";
			$this->img2->UploadPath = $this->img2->OldUploadPath;
			$this->img3->OldUploadPath = "../uploads/products/";
			$this->img3->UploadPath = $this->img3->OldUploadPath;
			$this->img4->OldUploadPath = "../uploads/products/";
			$this->img4->UploadPath = $this->img4->OldUploadPath;
			$rsnew = array();

			// price
			$this->price->SetDbValueDef($rsnew, $this->price->CurrentValue, 0, $this->price->ReadOnly);

			// oldprice
			$this->oldprice->SetDbValueDef($rsnew, $this->oldprice->CurrentValue, NULL, $this->oldprice->ReadOnly);

			// product_code
			$this->product_code->SetDbValueDef($rsnew, $this->product_code->CurrentValue, "", $this->product_code->ReadOnly);

			// product_name
			$this->product_name->SetDbValueDef($rsnew, $this->product_name->CurrentValue, "", $this->product_name->ReadOnly);

			// product_img_name
			$this->product_img_name->SetDbValueDef($rsnew, $this->product_img_name->CurrentValue, "", $this->product_img_name->ReadOnly);

			// img1
			$this->img1->SetDbValueDef($rsnew, $this->img1->CurrentValue, NULL, $this->img1->ReadOnly);

			// cat
			$this->cat->SetDbValueDef($rsnew, $this->cat->CurrentValue, NULL, $this->cat->ReadOnly);

			// subcat
			$this->subcat->SetDbValueDef($rsnew, $this->subcat->CurrentValue, NULL, $this->subcat->ReadOnly);

			// sales_status
			$this->sales_status->SetDbValueDef($rsnew, ((strval($this->sales_status->CurrentValue) == "1") ? "1" : "0"), 0, $this->sales_status->ReadOnly);

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
		if ($this->product_code->CurrentValue <> "") { // Check field with unique index
			$sFilter = "(product_code = '" . ew_AdjustSql($this->product_code->CurrentValue) . "')";
			$rsChk = $this->LoadRs($sFilter);
			if ($rsChk && !$rsChk->EOF) {
				$sIdxErrMsg = str_replace("%f", $this->product_code->FldCaption(), $Language->Phrase("DupIndex"));
				$sIdxErrMsg = str_replace("%v", $this->product_code->CurrentValue, $sIdxErrMsg);
				$this->setFailureMessage($sIdxErrMsg);
				$rsChk->Close();
				return FALSE;
			}
		}

		// Load db values from rsold
		if ($rsold) {
			$this->LoadDbValues($rsold);
			$this->img2->OldUploadPath = "../uploads/products/";
			$this->img2->UploadPath = $this->img2->OldUploadPath;
			$this->img3->OldUploadPath = "../uploads/products/";
			$this->img3->UploadPath = $this->img3->OldUploadPath;
			$this->img4->OldUploadPath = "../uploads/products/";
			$this->img4->UploadPath = $this->img4->OldUploadPath;
		}
		$rsnew = array();

		// price
		$this->price->SetDbValueDef($rsnew, $this->price->CurrentValue, 0, FALSE);

		// oldprice
		$this->oldprice->SetDbValueDef($rsnew, $this->oldprice->CurrentValue, NULL, FALSE);

		// product_code
		$this->product_code->SetDbValueDef($rsnew, $this->product_code->CurrentValue, "", FALSE);

		// product_name
		$this->product_name->SetDbValueDef($rsnew, $this->product_name->CurrentValue, "", FALSE);

		// product_img_name
		$this->product_img_name->SetDbValueDef($rsnew, $this->product_img_name->CurrentValue, "", FALSE);

		// img1
		$this->img1->SetDbValueDef($rsnew, $this->img1->CurrentValue, NULL, FALSE);

		// cat
		$this->cat->SetDbValueDef($rsnew, $this->cat->CurrentValue, NULL, FALSE);

		// subcat
		$this->subcat->SetDbValueDef($rsnew, $this->subcat->CurrentValue, NULL, FALSE);

		// sales_status
		$this->sales_status->SetDbValueDef($rsnew, ((strval($this->sales_status->CurrentValue) == "1") ? "1" : "0"), 0, strval($this->sales_status->CurrentValue) == "");

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

	// Load advanced search
	function LoadAdvancedSearch() {
		$this->id->AdvancedSearch->Load();
		$this->price->AdvancedSearch->Load();
		$this->img2->AdvancedSearch->Load();
		$this->img3->AdvancedSearch->Load();
		$this->img4->AdvancedSearch->Load();
		$this->rate_ord->AdvancedSearch->Load();
		$this->datep->AdvancedSearch->Load();
		$this->oldprice->AdvancedSearch->Load();
		$this->product_code->AdvancedSearch->Load();
		$this->product_name->AdvancedSearch->Load();
		$this->product_desc->AdvancedSearch->Load();
		$this->product_img_name->AdvancedSearch->Load();
		$this->img1->AdvancedSearch->Load();
		$this->cat->AdvancedSearch->Load();
		$this->sized->AdvancedSearch->Load();
		$this->subcat->AdvancedSearch->Load();
		$this->sales_status->AdvancedSearch->Load();
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
		$item->Body = "<a id=\"emf_products\" href=\"javascript:void(0);\" class=\"ewExportLink ewEmail\" data-caption=\"" . $Language->Phrase("ExportToEmailText") . "\" onclick=\"ew_EmailDialogShow({lnk:'emf_products',hdr:ewLanguage.Phrase('ExportToEmail'),f:document.fproductslist,sel:false});\">" . $Language->Phrase("ExportToEmail") . "</a>";
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
		$this->AddSearchQueryString($sQry, $this->id); // id
		$this->AddSearchQueryString($sQry, $this->price); // price
		$this->AddSearchQueryString($sQry, $this->rate_ord); // rate_ord
		$this->AddSearchQueryString($sQry, $this->datep); // datep
		$this->AddSearchQueryString($sQry, $this->oldprice); // oldprice
		$this->AddSearchQueryString($sQry, $this->product_code); // product_code
		$this->AddSearchQueryString($sQry, $this->product_name); // product_name
		$this->AddSearchQueryString($sQry, $this->product_desc); // product_desc
		$this->AddSearchQueryString($sQry, $this->product_img_name); // product_img_name
		$this->AddSearchQueryString($sQry, $this->img1); // img1
		$this->AddSearchQueryString($sQry, $this->cat); // cat
		$this->AddSearchQueryString($sQry, $this->sized); // sized
		$this->AddSearchQueryString($sQry, $this->subcat); // subcat
		$this->AddSearchQueryString($sQry, $this->sales_status); // sales_status

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
if (!isset($products_list)) $products_list = new cproducts_list();

// Page init
$products_list->Page_Init();

// Page main
$products_list->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$products_list->Page_Render();
?>
<?php include_once "header.php" ?>
<?php if ($products->Export == "") { ?>
<script type="text/javascript">

// Page object
var products_list = new ew_Page("products_list");
products_list.PageID = "list"; // Page ID
var EW_PAGE_ID = products_list.PageID; // For backward compatibility

// Form object
var fproductslist = new ew_Form("fproductslist");
fproductslist.FormKeyCountName = '<?php echo $products_list->FormKeyCountName ?>';

// Validate form
fproductslist.Validate = function() {
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
		var checkrow = (gridinsert) ? !this.EmptyRow(infix) : true;
		if (checkrow) {
			addcnt++;
			elm = this.GetElements("x" + infix + "_price");
			if (elm && !ew_HasValue(elm))
				return this.OnError(elm, ewLanguage.Phrase("EnterRequiredField") + " - <?php echo ew_JsEncode2($products->price->FldCaption()) ?>");
			elm = this.GetElements("x" + infix + "_price");
			if (elm && !ew_CheckNumber(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($products->price->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_oldprice");
			if (elm && !ew_CheckNumber(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($products->oldprice->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_product_code");
			if (elm && !ew_HasValue(elm))
				return this.OnError(elm, ewLanguage.Phrase("EnterRequiredField") + " - <?php echo ew_JsEncode2($products->product_code->FldCaption()) ?>");
			elm = this.GetElements("x" + infix + "_product_name");
			if (elm && !ew_HasValue(elm))
				return this.OnError(elm, ewLanguage.Phrase("EnterRequiredField") + " - <?php echo ew_JsEncode2($products->product_name->FldCaption()) ?>");
			elm = this.GetElements("x" + infix + "_product_img_name");
			if (elm && !ew_HasValue(elm))
				return this.OnError(elm, ewLanguage.Phrase("EnterRequiredField") + " - <?php echo ew_JsEncode2($products->product_img_name->FldCaption()) ?>");
			elm = this.GetElements("x" + infix + "_sales_status");
			if (elm && !ew_HasValue(elm))
				return this.OnError(elm, ewLanguage.Phrase("EnterRequiredField") + " - <?php echo ew_JsEncode2($products->sales_status->FldCaption()) ?>");

			// Set up row object
			ew_ElementsToRow(fobj);

			// Fire Form_CustomValidate event
			if (!this.Form_CustomValidate(fobj))
				return false;
		} // End Grid Add checking
	}
	if (gridinsert && addcnt == 0) { // No row added
		alert(ewLanguage.Phrase("NoAddRecord"));
		return false;
	}
	return true;
}

// Check empty row
fproductslist.EmptyRow = function(infix) {
	var fobj = this.Form;
	if (ew_ValueChanged(fobj, infix, "price", false)) return false;
	if (ew_ValueChanged(fobj, infix, "oldprice", false)) return false;
	if (ew_ValueChanged(fobj, infix, "product_code", false)) return false;
	if (ew_ValueChanged(fobj, infix, "product_name", false)) return false;
	if (ew_ValueChanged(fobj, infix, "product_img_name", false)) return false;
	if (ew_ValueChanged(fobj, infix, "img1", false)) return false;
	if (ew_ValueChanged(fobj, infix, "cat", false)) return false;
	if (ew_ValueChanged(fobj, infix, "subcat", false)) return false;
	if (ew_ValueChanged(fobj, infix, "sales_status", true)) return false;
	return true;
}

// Form_CustomValidate event
fproductslist.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
fproductslist.ValidateRequired = true;
<?php } else { ?>
fproductslist.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
// Form object for search

var fproductslistsrch = new ew_Form("fproductslistsrch");

// Validate function for search
fproductslistsrch.Validate = function(fobj) {
	if (!this.ValidateRequired)
		return true; // Ignore validation
	fobj = fobj || this.Form;
	this.PostAutoSuggest();
	var infix = "";

	// Set up row object
	ew_ElementsToRow(fobj);

	// Fire Form_CustomValidate event
	if (!this.Form_CustomValidate(fobj))
		return false;
	return true;
}

// Form_CustomValidate event
fproductslistsrch.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
fproductslistsrch.ValidateRequired = true; // Use JavaScript validation
<?php } else { ?>
fproductslistsrch.ValidateRequired = false; // No JavaScript validation
<?php } ?>

// Dynamic selection lists
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
<?php if ($products->Export == "") { ?>
<?php $Breadcrumb->Render(); ?>
<?php } ?>
<?php if ($products_list->ExportOptions->Visible()) { ?>
<div class="ewListExportOptions"><?php $products_list->ExportOptions->Render("body") ?></div>
<?php } ?>
<?php
if ($products->CurrentAction == "gridadd") {
	$products->CurrentFilter = "0=1";
	$products_list->StartRec = 1;
	$products_list->DisplayRecs = $products->GridAddRowCount;
	$products_list->TotalRecs = $products_list->DisplayRecs;
	$products_list->StopRec = $products_list->DisplayRecs;
} else {
	$bSelectLimit = EW_SELECT_LIMIT;
	if ($bSelectLimit) {
		$products_list->TotalRecs = $products->SelectRecordCount();
	} else {
		if ($products_list->Recordset = $products_list->LoadRecordset())
			$products_list->TotalRecs = $products_list->Recordset->RecordCount();
	}
	$products_list->StartRec = 1;
	if ($products_list->DisplayRecs <= 0 || ($products->Export <> "" && $products->ExportAll)) // Display all records
		$products_list->DisplayRecs = $products_list->TotalRecs;
	if (!($products->Export <> "" && $products->ExportAll))
		$products_list->SetUpStartRec(); // Set up start record position
	if ($bSelectLimit)
		$products_list->Recordset = $products_list->LoadRecordset($products_list->StartRec-1, $products_list->DisplayRecs);
}
$products_list->RenderOtherOptions();
?>
<?php if ($Security->IsLoggedIn()) { ?>
<?php if ($products->Export == "" && $products->CurrentAction == "") { ?>
<form name="fproductslistsrch" id="fproductslistsrch" class="ewForm form-inline" action="<?php echo ew_CurrentPage() ?>">
<table class="ewSearchTable"><tr><td>
<div class="accordion" id="fproductslistsrch_SearchGroup">
	<div class="accordion-group">
		<div class="accordion-heading">
<a class="accordion-toggle" data-toggle="collapse" data-parent="#fproductslistsrch_SearchGroup" href="#fproductslistsrch_SearchBody"><?php echo $Language->Phrase("Search") ?></a>
		</div>
		<div id="fproductslistsrch_SearchBody" class="accordion-body collapse in">
			<div class="accordion-inner">
<div id="fproductslistsrch_SearchPanel">
<input type="hidden" name="cmd" value="search">
<input type="hidden" name="t" value="products">
<div class="ewBasicSearch">
<?php
if ($gsSearchError == "")
	$products_list->LoadAdvancedSearch(); // Load advanced search

// Render for search
$products->RowType = EW_ROWTYPE_SEARCH;

// Render row
$products->ResetAttrs();
$products_list->RenderRow();
?>
<div id="xsr_1" class="ewRow">
<?php if ($products->sales_status->Visible) { // sales_status ?>
	<span id="xsc_sales_status" class="ewCell">
		<span class="ewSearchCaption"><?php echo $products->sales_status->FldCaption() ?></span>
		<span class="ewSearchOperator"><?php echo $Language->Phrase("=") ?><input type="hidden" name="z_sales_status" id="z_sales_status" value="="></span>
		<span class="control-group ewSearchField">
<div id="tp_x_sales_status" class="<?php echo EW_ITEM_TEMPLATE_CLASSNAME ?>"><input type="radio" name="x_sales_status" id="x_sales_status" value="{value}"<?php echo $products->sales_status->EditAttributes() ?>></div>
<div id="dsl_x_sales_status" data-repeatcolumn="5" class="ewItemList">
<?php
$arwrk = $products->sales_status->EditValue;
if (is_array($arwrk)) {
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($products->sales_status->AdvancedSearch->SearchValue) == strval($arwrk[$rowcntwrk][0])) ? " checked=\"checked\"" : "";
		if ($selwrk <> "") $emptywrk = FALSE;

		// Note: No spacing within the LABEL tag
?>
<?php echo ew_RepeatColumnTable($rowswrk, $rowcntwrk, 5, 1) ?>
<label class="radio"><input type="radio" data-field="x_sales_status" name="x_sales_status" id="x_sales_status_<?php echo $rowcntwrk ?>" value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?><?php echo $products->sales_status->EditAttributes() ?>><?php echo $arwrk[$rowcntwrk][1] ?></label>
<?php echo ew_RepeatColumnTable($rowswrk, $rowcntwrk, 5, 2) ?>
<?php
	}
}
if (@$emptywrk) $products->sales_status->OldValue = "";
?>
</div>
</span>
	</span>
<?php } ?>
</div>
<div id="xsr_2" class="ewRow">
	<div class="btn-group ewButtonGroup">
	<div class="input-append">
	<input type="text" name="<?php echo EW_TABLE_BASIC_SEARCH ?>" id="<?php echo EW_TABLE_BASIC_SEARCH ?>" class="input-large" value="<?php echo ew_HtmlEncode($products_list->BasicSearch->getKeyword()) ?>" placeholder="<?php echo $Language->Phrase("Search") ?>">
	<button class="btn btn-primary ewButton" name="btnsubmit" id="btnsubmit" type="submit"><?php echo $Language->Phrase("QuickSearchBtn") ?></button>
	</div>
	</div>
	<div class="btn-group ewButtonGroup">
	<a class="btn ewShowAll" href="<?php echo $products_list->PageUrl() ?>cmd=reset"><?php echo $Language->Phrase("ShowAll") ?></a>
</div>
<div id="xsr_3" class="ewRow">
	<label class="inline radio ewRadio" style="white-space: nowrap;"><input type="radio" name="<?php echo EW_TABLE_BASIC_SEARCH_TYPE ?>" value="="<?php if ($products_list->BasicSearch->getType() == "=") { ?> checked="checked"<?php } ?>><?php echo $Language->Phrase("ExactPhrase") ?></label>
	<label class="inline radio ewRadio" style="white-space: nowrap;"><input type="radio" name="<?php echo EW_TABLE_BASIC_SEARCH_TYPE ?>" value="AND"<?php if ($products_list->BasicSearch->getType() == "AND") { ?> checked="checked"<?php } ?>><?php echo $Language->Phrase("AllWord") ?></label>
	<label class="inline radio ewRadio" style="white-space: nowrap;"><input type="radio" name="<?php echo EW_TABLE_BASIC_SEARCH_TYPE ?>" value="OR"<?php if ($products_list->BasicSearch->getType() == "OR") { ?> checked="checked"<?php } ?>><?php echo $Language->Phrase("AnyWord") ?></label>
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
<?php $products_list->ShowPageHeader(); ?>
<?php
$products_list->ShowMessage();
?>
<table cellspacing="0" class="ewGrid"><tr><td class="ewGridContent">
<form name="fproductslist" id="fproductslist" class="ewForm form-horizontal" action="<?php echo ew_CurrentPage() ?>" method="post">
<input type="hidden" name="t" value="products">
<div id="gmp_products" class="ewGridMiddlePanel">
<?php if ($products_list->TotalRecs > 0 || $products->CurrentAction == "add" || $products->CurrentAction == "copy") { ?>
<table id="tbl_productslist" class="ewTable ewTableSeparate">
<?php echo $products->TableCustomInnerHtml ?>
<thead><!-- Table header -->
	<tr class="ewTableHeader">
<?php

// Render list options
$products_list->RenderListOptions();

// Render list options (header, left)
$products_list->ListOptions->Render("header", "left");
?>
<?php if ($products->price->Visible) { // price ?>
	<?php if ($products->SortUrl($products->price) == "") { ?>
		<td><div id="elh_products_price" class="products_price"><div class="ewTableHeaderCaption"><?php echo $products->price->FldCaption() ?></div></div></td>
	<?php } else { ?>
		<td><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $products->SortUrl($products->price) ?>',2);"><div id="elh_products_price" class="products_price">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $products->price->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($products->price->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($products->price->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></td>
	<?php } ?>
<?php } ?>		
<?php if ($products->oldprice->Visible) { // oldprice ?>
	<?php if ($products->SortUrl($products->oldprice) == "") { ?>
		<td><div id="elh_products_oldprice" class="products_oldprice"><div class="ewTableHeaderCaption"><?php echo $products->oldprice->FldCaption() ?></div></div></td>
	<?php } else { ?>
		<td><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $products->SortUrl($products->oldprice) ?>',2);"><div id="elh_products_oldprice" class="products_oldprice">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $products->oldprice->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($products->oldprice->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($products->oldprice->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></td>
	<?php } ?>
<?php } ?>		
<?php if ($products->product_code->Visible) { // product_code ?>
	<?php if ($products->SortUrl($products->product_code) == "") { ?>
		<td><div id="elh_products_product_code" class="products_product_code"><div class="ewTableHeaderCaption"><?php echo $products->product_code->FldCaption() ?></div></div></td>
	<?php } else { ?>
		<td><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $products->SortUrl($products->product_code) ?>',2);"><div id="elh_products_product_code" class="products_product_code">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $products->product_code->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($products->product_code->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($products->product_code->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></td>
	<?php } ?>
<?php } ?>		
<?php if ($products->product_name->Visible) { // product_name ?>
	<?php if ($products->SortUrl($products->product_name) == "") { ?>
		<td><div id="elh_products_product_name" class="products_product_name"><div class="ewTableHeaderCaption"><?php echo $products->product_name->FldCaption() ?></div></div></td>
	<?php } else { ?>
		<td><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $products->SortUrl($products->product_name) ?>',2);"><div id="elh_products_product_name" class="products_product_name">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $products->product_name->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($products->product_name->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($products->product_name->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></td>
	<?php } ?>
<?php } ?>		
<?php if ($products->product_img_name->Visible) { // product_img_name ?>
	<?php if ($products->SortUrl($products->product_img_name) == "") { ?>
		<td><div id="elh_products_product_img_name" class="products_product_img_name"><div class="ewTableHeaderCaption"><?php echo $products->product_img_name->FldCaption() ?></div></div></td>
	<?php } else { ?>
		<td><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $products->SortUrl($products->product_img_name) ?>',2);"><div id="elh_products_product_img_name" class="products_product_img_name">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $products->product_img_name->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($products->product_img_name->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($products->product_img_name->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></td>
	<?php } ?>
<?php } ?>		
<?php if ($products->img1->Visible) { // img1 ?>
	<?php if ($products->SortUrl($products->img1) == "") { ?>
		<td><div id="elh_products_img1" class="products_img1"><div class="ewTableHeaderCaption"><?php echo $products->img1->FldCaption() ?></div></div></td>
	<?php } else { ?>
		<td><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $products->SortUrl($products->img1) ?>',2);"><div id="elh_products_img1" class="products_img1">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $products->img1->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($products->img1->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($products->img1->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></td>
	<?php } ?>
<?php } ?>		
<?php if ($products->cat->Visible) { // cat ?>
	<?php if ($products->SortUrl($products->cat) == "") { ?>
		<td><div id="elh_products_cat" class="products_cat"><div class="ewTableHeaderCaption"><?php echo $products->cat->FldCaption() ?></div></div></td>
	<?php } else { ?>
		<td><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $products->SortUrl($products->cat) ?>',2);"><div id="elh_products_cat" class="products_cat">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $products->cat->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($products->cat->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($products->cat->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></td>
	<?php } ?>
<?php } ?>		
<?php if ($products->subcat->Visible) { // subcat ?>
	<?php if ($products->SortUrl($products->subcat) == "") { ?>
		<td><div id="elh_products_subcat" class="products_subcat"><div class="ewTableHeaderCaption"><?php echo $products->subcat->FldCaption() ?></div></div></td>
	<?php } else { ?>
		<td><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $products->SortUrl($products->subcat) ?>',2);"><div id="elh_products_subcat" class="products_subcat">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $products->subcat->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($products->subcat->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($products->subcat->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></td>
	<?php } ?>
<?php } ?>		
<?php if ($products->sales_status->Visible) { // sales_status ?>
	<?php if ($products->SortUrl($products->sales_status) == "") { ?>
		<td><div id="elh_products_sales_status" class="products_sales_status"><div class="ewTableHeaderCaption"><?php echo $products->sales_status->FldCaption() ?></div></div></td>
	<?php } else { ?>
		<td><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $products->SortUrl($products->sales_status) ?>',2);"><div id="elh_products_sales_status" class="products_sales_status">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $products->sales_status->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($products->sales_status->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($products->sales_status->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></td>
	<?php } ?>
<?php } ?>		
<?php

// Render list options (header, right)
$products_list->ListOptions->Render("header", "right");
?>
	</tr>
</thead>
<tbody>
<?php
	if ($products->CurrentAction == "add" || $products->CurrentAction == "copy") {
		$products_list->RowIndex = 0;
		$products_list->KeyCount = $products_list->RowIndex;
		if ($products->CurrentAction == "add")
			$products_list->LoadDefaultValues();
		if ($products->EventCancelled) // Insert failed
			$products_list->RestoreFormValues(); // Restore form values

		// Set row properties
		$products->ResetAttrs();
		$products->RowAttrs = array_merge($products->RowAttrs, array('data-rowindex'=>0, 'id'=>'r0_products', 'data-rowtype'=>EW_ROWTYPE_ADD));
		$products->RowType = EW_ROWTYPE_ADD;

		// Render row
		$products_list->RenderRow();

		// Render list options
		$products_list->RenderListOptions();
		$products_list->StartRowCnt = 0;
?>
	<tr<?php echo $products->RowAttributes() ?>>
<?php

// Render list options (body, left)
$products_list->ListOptions->Render("body", "left", $products_list->RowCnt);
?>
	<?php if ($products->price->Visible) { // price ?>
		<td>
<span id="el<?php echo $products_list->RowCnt ?>_products_price" class="control-group products_price">
<input type="text" data-field="x_price" name="x<?php echo $products_list->RowIndex ?>_price" id="x<?php echo $products_list->RowIndex ?>_price" size="30" placeholder="<?php echo $products->price->PlaceHolder ?>" value="<?php echo $products->price->EditValue ?>"<?php echo $products->price->EditAttributes() ?>>
</span>
<input type="hidden" data-field="x_price" name="o<?php echo $products_list->RowIndex ?>_price" id="o<?php echo $products_list->RowIndex ?>_price" value="<?php echo ew_HtmlEncode($products->price->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($products->oldprice->Visible) { // oldprice ?>
		<td>
<span id="el<?php echo $products_list->RowCnt ?>_products_oldprice" class="control-group products_oldprice">
<input type="text" data-field="x_oldprice" name="x<?php echo $products_list->RowIndex ?>_oldprice" id="x<?php echo $products_list->RowIndex ?>_oldprice" size="30" maxlength="10" placeholder="<?php echo $products->oldprice->PlaceHolder ?>" value="<?php echo $products->oldprice->EditValue ?>"<?php echo $products->oldprice->EditAttributes() ?>>
</span>
<input type="hidden" data-field="x_oldprice" name="o<?php echo $products_list->RowIndex ?>_oldprice" id="o<?php echo $products_list->RowIndex ?>_oldprice" value="<?php echo ew_HtmlEncode($products->oldprice->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($products->product_code->Visible) { // product_code ?>
		<td>
<span id="el<?php echo $products_list->RowCnt ?>_products_product_code" class="control-group products_product_code">
<input type="text" data-field="x_product_code" name="x<?php echo $products_list->RowIndex ?>_product_code" id="x<?php echo $products_list->RowIndex ?>_product_code" size="30" maxlength="60" placeholder="<?php echo $products->product_code->PlaceHolder ?>" value="<?php echo $products->product_code->EditValue ?>"<?php echo $products->product_code->EditAttributes() ?>>
</span>
<input type="hidden" data-field="x_product_code" name="o<?php echo $products_list->RowIndex ?>_product_code" id="o<?php echo $products_list->RowIndex ?>_product_code" value="<?php echo ew_HtmlEncode($products->product_code->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($products->product_name->Visible) { // product_name ?>
		<td>
<span id="el<?php echo $products_list->RowCnt ?>_products_product_name" class="control-group products_product_name">
<input type="text" data-field="x_product_name" name="x<?php echo $products_list->RowIndex ?>_product_name" id="x<?php echo $products_list->RowIndex ?>_product_name" size="30" maxlength="60" placeholder="<?php echo $products->product_name->PlaceHolder ?>" value="<?php echo $products->product_name->EditValue ?>"<?php echo $products->product_name->EditAttributes() ?>>
</span>
<input type="hidden" data-field="x_product_name" name="o<?php echo $products_list->RowIndex ?>_product_name" id="o<?php echo $products_list->RowIndex ?>_product_name" value="<?php echo ew_HtmlEncode($products->product_name->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($products->product_img_name->Visible) { // product_img_name ?>
		<td>
<span id="el<?php echo $products_list->RowCnt ?>_products_product_img_name" class="control-group products_product_img_name">
<input type="text" data-field="x_product_img_name" name="x<?php echo $products_list->RowIndex ?>_product_img_name" id="x<?php echo $products_list->RowIndex ?>_product_img_name" size="30" maxlength="60" placeholder="<?php echo $products->product_img_name->PlaceHolder ?>" value="<?php echo $products->product_img_name->EditValue ?>"<?php echo $products->product_img_name->EditAttributes() ?>>
</span>
<input type="hidden" data-field="x_product_img_name" name="o<?php echo $products_list->RowIndex ?>_product_img_name" id="o<?php echo $products_list->RowIndex ?>_product_img_name" value="<?php echo ew_HtmlEncode($products->product_img_name->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($products->img1->Visible) { // img1 ?>
		<td>
<span id="el<?php echo $products_list->RowCnt ?>_products_img1" class="control-group products_img1">
<input type="text" data-field="x_img1" name="x<?php echo $products_list->RowIndex ?>_img1" id="x<?php echo $products_list->RowIndex ?>_img1" size="30" maxlength="200" placeholder="<?php echo $products->img1->PlaceHolder ?>" value="<?php echo $products->img1->EditValue ?>"<?php echo $products->img1->EditAttributes() ?>>
</span>
<input type="hidden" data-field="x_img1" name="o<?php echo $products_list->RowIndex ?>_img1" id="o<?php echo $products_list->RowIndex ?>_img1" value="<?php echo ew_HtmlEncode($products->img1->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($products->cat->Visible) { // cat ?>
		<td>
<span id="el<?php echo $products_list->RowCnt ?>_products_cat" class="control-group products_cat">
<input type="text" data-field="x_cat" name="x<?php echo $products_list->RowIndex ?>_cat" id="x<?php echo $products_list->RowIndex ?>_cat" size="30" maxlength="50" placeholder="<?php echo $products->cat->PlaceHolder ?>" value="<?php echo $products->cat->EditValue ?>"<?php echo $products->cat->EditAttributes() ?>>
</span>
<input type="hidden" data-field="x_cat" name="o<?php echo $products_list->RowIndex ?>_cat" id="o<?php echo $products_list->RowIndex ?>_cat" value="<?php echo ew_HtmlEncode($products->cat->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($products->subcat->Visible) { // subcat ?>
		<td>
<span id="el<?php echo $products_list->RowCnt ?>_products_subcat" class="control-group products_subcat">
<input type="text" data-field="x_subcat" name="x<?php echo $products_list->RowIndex ?>_subcat" id="x<?php echo $products_list->RowIndex ?>_subcat" size="30" maxlength="50" placeholder="<?php echo $products->subcat->PlaceHolder ?>" value="<?php echo $products->subcat->EditValue ?>"<?php echo $products->subcat->EditAttributes() ?>>
</span>
<input type="hidden" data-field="x_subcat" name="o<?php echo $products_list->RowIndex ?>_subcat" id="o<?php echo $products_list->RowIndex ?>_subcat" value="<?php echo ew_HtmlEncode($products->subcat->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($products->sales_status->Visible) { // sales_status ?>
		<td>
<span id="el<?php echo $products_list->RowCnt ?>_products_sales_status" class="control-group products_sales_status">
<div id="tp_x<?php echo $products_list->RowIndex ?>_sales_status" class="<?php echo EW_ITEM_TEMPLATE_CLASSNAME ?>"><input type="radio" name="x<?php echo $products_list->RowIndex ?>_sales_status" id="x<?php echo $products_list->RowIndex ?>_sales_status" value="{value}"<?php echo $products->sales_status->EditAttributes() ?>></div>
<div id="dsl_x<?php echo $products_list->RowIndex ?>_sales_status" data-repeatcolumn="5" class="ewItemList">
<?php
$arwrk = $products->sales_status->EditValue;
if (is_array($arwrk)) {
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($products->sales_status->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " checked=\"checked\"" : "";
		if ($selwrk <> "") $emptywrk = FALSE;

		// Note: No spacing within the LABEL tag
?>
<?php echo ew_RepeatColumnTable($rowswrk, $rowcntwrk, 5, 1) ?>
<label class="radio"><input type="radio" data-field="x_sales_status" name="x<?php echo $products_list->RowIndex ?>_sales_status" id="x<?php echo $products_list->RowIndex ?>_sales_status_<?php echo $rowcntwrk ?>" value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?><?php echo $products->sales_status->EditAttributes() ?>><?php echo $arwrk[$rowcntwrk][1] ?></label>
<?php echo ew_RepeatColumnTable($rowswrk, $rowcntwrk, 5, 2) ?>
<?php
	}
}
if (@$emptywrk) $products->sales_status->OldValue = "";
?>
</div>
</span>
<input type="hidden" data-field="x_sales_status" name="o<?php echo $products_list->RowIndex ?>_sales_status" id="o<?php echo $products_list->RowIndex ?>_sales_status" value="<?php echo ew_HtmlEncode($products->sales_status->OldValue) ?>">
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$products_list->ListOptions->Render("body", "right", $products_list->RowCnt);
?>
<script type="text/javascript">
fproductslist.UpdateOpts(<?php echo $products_list->RowIndex ?>);
</script>
	</tr>
<?php
}
?>
<?php
if ($products->ExportAll && $products->Export <> "") {
	$products_list->StopRec = $products_list->TotalRecs;
} else {

	// Set the last record to display
	if ($products_list->TotalRecs > $products_list->StartRec + $products_list->DisplayRecs - 1)
		$products_list->StopRec = $products_list->StartRec + $products_list->DisplayRecs - 1;
	else
		$products_list->StopRec = $products_list->TotalRecs;
}

// Restore number of post back records
if ($objForm) {
	$objForm->Index = -1;
	if ($objForm->HasValue($products_list->FormKeyCountName) && ($products->CurrentAction == "gridadd" || $products->CurrentAction == "gridedit" || $products->CurrentAction == "F")) {
		$products_list->KeyCount = $objForm->GetValue($products_list->FormKeyCountName);
		$products_list->StopRec = $products_list->StartRec + $products_list->KeyCount - 1;
	}
}
$products_list->RecCnt = $products_list->StartRec - 1;
if ($products_list->Recordset && !$products_list->Recordset->EOF) {
	$products_list->Recordset->MoveFirst();
	if (!$bSelectLimit && $products_list->StartRec > 1)
		$products_list->Recordset->Move($products_list->StartRec - 1);
} elseif (!$products->AllowAddDeleteRow && $products_list->StopRec == 0) {
	$products_list->StopRec = $products->GridAddRowCount;
}

// Initialize aggregate
$products->RowType = EW_ROWTYPE_AGGREGATEINIT;
$products->ResetAttrs();
$products_list->RenderRow();
$products_list->EditRowCnt = 0;
if ($products->CurrentAction == "edit")
	$products_list->RowIndex = 1;
if ($products->CurrentAction == "gridadd")
	$products_list->RowIndex = 0;
if ($products->CurrentAction == "gridedit")
	$products_list->RowIndex = 0;
while ($products_list->RecCnt < $products_list->StopRec) {
	$products_list->RecCnt++;
	if (intval($products_list->RecCnt) >= intval($products_list->StartRec)) {
		$products_list->RowCnt++;
		if ($products->CurrentAction == "gridadd" || $products->CurrentAction == "gridedit" || $products->CurrentAction == "F") {
			$products_list->RowIndex++;
			$objForm->Index = $products_list->RowIndex;
			if ($objForm->HasValue($products_list->FormActionName))
				$products_list->RowAction = strval($objForm->GetValue($products_list->FormActionName));
			elseif ($products->CurrentAction == "gridadd")
				$products_list->RowAction = "insert";
			else
				$products_list->RowAction = "";
		}

		// Set up key count
		$products_list->KeyCount = $products_list->RowIndex;

		// Init row class and style
		$products->ResetAttrs();
		$products->CssClass = "";
		if ($products->CurrentAction == "gridadd") {
			$products_list->LoadDefaultValues(); // Load default values
		} else {
			$products_list->LoadRowValues($products_list->Recordset); // Load row values
		}
		$products->RowType = EW_ROWTYPE_VIEW; // Render view
		if ($products->CurrentAction == "gridadd") // Grid add
			$products->RowType = EW_ROWTYPE_ADD; // Render add
		if ($products->CurrentAction == "gridadd" && $products->EventCancelled && !$objForm->HasValue("k_blankrow")) // Insert failed
			$products_list->RestoreCurrentRowFormValues($products_list->RowIndex); // Restore form values
		if ($products->CurrentAction == "edit") {
			if ($products_list->CheckInlineEditKey() && $products_list->EditRowCnt == 0) { // Inline edit
				$products->RowType = EW_ROWTYPE_EDIT; // Render edit
			}
		}
		if ($products->CurrentAction == "gridedit") { // Grid edit
			if ($products->EventCancelled) {
				$products_list->RestoreCurrentRowFormValues($products_list->RowIndex); // Restore form values
			}
			if ($products_list->RowAction == "insert")
				$products->RowType = EW_ROWTYPE_ADD; // Render add
			else
				$products->RowType = EW_ROWTYPE_EDIT; // Render edit
		}
		if ($products->CurrentAction == "edit" && $products->RowType == EW_ROWTYPE_EDIT && $products->EventCancelled) { // Update failed
			$objForm->Index = 1;
			$products_list->RestoreFormValues(); // Restore form values
		}
		if ($products->CurrentAction == "gridedit" && ($products->RowType == EW_ROWTYPE_EDIT || $products->RowType == EW_ROWTYPE_ADD) && $products->EventCancelled) // Update failed
			$products_list->RestoreCurrentRowFormValues($products_list->RowIndex); // Restore form values
		if ($products->RowType == EW_ROWTYPE_EDIT) // Edit row
			$products_list->EditRowCnt++;

		// Set up row id / data-rowindex
		$products->RowAttrs = array_merge($products->RowAttrs, array('data-rowindex'=>$products_list->RowCnt, 'id'=>'r' . $products_list->RowCnt . '_products', 'data-rowtype'=>$products->RowType));

		// Render row
		$products_list->RenderRow();

		// Render list options
		$products_list->RenderListOptions();

		// Skip delete row / empty row for confirm page
		if ($products_list->RowAction <> "delete" && $products_list->RowAction <> "insertdelete" && !($products_list->RowAction == "insert" && $products->CurrentAction == "F" && $products_list->EmptyRow())) {
?>
	<tr<?php echo $products->RowAttributes() ?>>
<?php

// Render list options (body, left)
$products_list->ListOptions->Render("body", "left", $products_list->RowCnt);
?>
	<?php if ($products->price->Visible) { // price ?>
		<td<?php echo $products->price->CellAttributes() ?>>
<?php if ($products->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $products_list->RowCnt ?>_products_price" class="control-group products_price">
<input type="text" data-field="x_price" name="x<?php echo $products_list->RowIndex ?>_price" id="x<?php echo $products_list->RowIndex ?>_price" size="30" placeholder="<?php echo $products->price->PlaceHolder ?>" value="<?php echo $products->price->EditValue ?>"<?php echo $products->price->EditAttributes() ?>>
</span>
<input type="hidden" data-field="x_price" name="o<?php echo $products_list->RowIndex ?>_price" id="o<?php echo $products_list->RowIndex ?>_price" value="<?php echo ew_HtmlEncode($products->price->OldValue) ?>">
<?php } ?>
<?php if ($products->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $products_list->RowCnt ?>_products_price" class="control-group products_price">
<input type="text" data-field="x_price" name="x<?php echo $products_list->RowIndex ?>_price" id="x<?php echo $products_list->RowIndex ?>_price" size="30" placeholder="<?php echo $products->price->PlaceHolder ?>" value="<?php echo $products->price->EditValue ?>"<?php echo $products->price->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($products->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span<?php echo $products->price->ViewAttributes() ?>>
<?php echo $products->price->ListViewValue() ?></span>
<?php } ?>
<a id="<?php echo $products_list->PageObjName . "_row_" . $products_list->RowCnt ?>"></a></td>
	<?php } ?>
<?php if ($products->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<input type="hidden" data-field="x_id" name="x<?php echo $products_list->RowIndex ?>_id" id="x<?php echo $products_list->RowIndex ?>_id" value="<?php echo ew_HtmlEncode($products->id->CurrentValue) ?>">
<input type="hidden" data-field="x_id" name="o<?php echo $products_list->RowIndex ?>_id" id="o<?php echo $products_list->RowIndex ?>_id" value="<?php echo ew_HtmlEncode($products->id->OldValue) ?>">
<?php } ?>
<?php if ($products->RowType == EW_ROWTYPE_EDIT || $products->CurrentMode == "edit") { ?>
<input type="hidden" data-field="x_id" name="x<?php echo $products_list->RowIndex ?>_id" id="x<?php echo $products_list->RowIndex ?>_id" value="<?php echo ew_HtmlEncode($products->id->CurrentValue) ?>">
<?php } ?>
	<?php if ($products->oldprice->Visible) { // oldprice ?>
		<td<?php echo $products->oldprice->CellAttributes() ?>>
<?php if ($products->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $products_list->RowCnt ?>_products_oldprice" class="control-group products_oldprice">
<input type="text" data-field="x_oldprice" name="x<?php echo $products_list->RowIndex ?>_oldprice" id="x<?php echo $products_list->RowIndex ?>_oldprice" size="30" maxlength="10" placeholder="<?php echo $products->oldprice->PlaceHolder ?>" value="<?php echo $products->oldprice->EditValue ?>"<?php echo $products->oldprice->EditAttributes() ?>>
</span>
<input type="hidden" data-field="x_oldprice" name="o<?php echo $products_list->RowIndex ?>_oldprice" id="o<?php echo $products_list->RowIndex ?>_oldprice" value="<?php echo ew_HtmlEncode($products->oldprice->OldValue) ?>">
<?php } ?>
<?php if ($products->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $products_list->RowCnt ?>_products_oldprice" class="control-group products_oldprice">
<input type="text" data-field="x_oldprice" name="x<?php echo $products_list->RowIndex ?>_oldprice" id="x<?php echo $products_list->RowIndex ?>_oldprice" size="30" maxlength="10" placeholder="<?php echo $products->oldprice->PlaceHolder ?>" value="<?php echo $products->oldprice->EditValue ?>"<?php echo $products->oldprice->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($products->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span<?php echo $products->oldprice->ViewAttributes() ?>>
<?php echo $products->oldprice->ListViewValue() ?></span>
<?php } ?>
<a id="<?php echo $products_list->PageObjName . "_row_" . $products_list->RowCnt ?>"></a></td>
	<?php } ?>
	<?php if ($products->product_code->Visible) { // product_code ?>
		<td<?php echo $products->product_code->CellAttributes() ?>>
<?php if ($products->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $products_list->RowCnt ?>_products_product_code" class="control-group products_product_code">
<input type="text" data-field="x_product_code" name="x<?php echo $products_list->RowIndex ?>_product_code" id="x<?php echo $products_list->RowIndex ?>_product_code" size="30" maxlength="60" placeholder="<?php echo $products->product_code->PlaceHolder ?>" value="<?php echo $products->product_code->EditValue ?>"<?php echo $products->product_code->EditAttributes() ?>>
</span>
<input type="hidden" data-field="x_product_code" name="o<?php echo $products_list->RowIndex ?>_product_code" id="o<?php echo $products_list->RowIndex ?>_product_code" value="<?php echo ew_HtmlEncode($products->product_code->OldValue) ?>">
<?php } ?>
<?php if ($products->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $products_list->RowCnt ?>_products_product_code" class="control-group products_product_code">
<input type="text" data-field="x_product_code" name="x<?php echo $products_list->RowIndex ?>_product_code" id="x<?php echo $products_list->RowIndex ?>_product_code" size="30" maxlength="60" placeholder="<?php echo $products->product_code->PlaceHolder ?>" value="<?php echo $products->product_code->EditValue ?>"<?php echo $products->product_code->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($products->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span<?php echo $products->product_code->ViewAttributes() ?>>
<?php echo $products->product_code->ListViewValue() ?></span>
<?php } ?>
<a id="<?php echo $products_list->PageObjName . "_row_" . $products_list->RowCnt ?>"></a></td>
	<?php } ?>
	<?php if ($products->product_name->Visible) { // product_name ?>
		<td<?php echo $products->product_name->CellAttributes() ?>>
<?php if ($products->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $products_list->RowCnt ?>_products_product_name" class="control-group products_product_name">
<input type="text" data-field="x_product_name" name="x<?php echo $products_list->RowIndex ?>_product_name" id="x<?php echo $products_list->RowIndex ?>_product_name" size="30" maxlength="60" placeholder="<?php echo $products->product_name->PlaceHolder ?>" value="<?php echo $products->product_name->EditValue ?>"<?php echo $products->product_name->EditAttributes() ?>>
</span>
<input type="hidden" data-field="x_product_name" name="o<?php echo $products_list->RowIndex ?>_product_name" id="o<?php echo $products_list->RowIndex ?>_product_name" value="<?php echo ew_HtmlEncode($products->product_name->OldValue) ?>">
<?php } ?>
<?php if ($products->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $products_list->RowCnt ?>_products_product_name" class="control-group products_product_name">
<input type="text" data-field="x_product_name" name="x<?php echo $products_list->RowIndex ?>_product_name" id="x<?php echo $products_list->RowIndex ?>_product_name" size="30" maxlength="60" placeholder="<?php echo $products->product_name->PlaceHolder ?>" value="<?php echo $products->product_name->EditValue ?>"<?php echo $products->product_name->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($products->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span<?php echo $products->product_name->ViewAttributes() ?>>
<?php echo $products->product_name->ListViewValue() ?></span>
<?php } ?>
<a id="<?php echo $products_list->PageObjName . "_row_" . $products_list->RowCnt ?>"></a></td>
	<?php } ?>
	<?php if ($products->product_img_name->Visible) { // product_img_name ?>
		<td<?php echo $products->product_img_name->CellAttributes() ?>>
<?php if ($products->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $products_list->RowCnt ?>_products_product_img_name" class="control-group products_product_img_name">
<input type="text" data-field="x_product_img_name" name="x<?php echo $products_list->RowIndex ?>_product_img_name" id="x<?php echo $products_list->RowIndex ?>_product_img_name" size="30" maxlength="60" placeholder="<?php echo $products->product_img_name->PlaceHolder ?>" value="<?php echo $products->product_img_name->EditValue ?>"<?php echo $products->product_img_name->EditAttributes() ?>>
</span>
<input type="hidden" data-field="x_product_img_name" name="o<?php echo $products_list->RowIndex ?>_product_img_name" id="o<?php echo $products_list->RowIndex ?>_product_img_name" value="<?php echo ew_HtmlEncode($products->product_img_name->OldValue) ?>">
<?php } ?>
<?php if ($products->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $products_list->RowCnt ?>_products_product_img_name" class="control-group products_product_img_name">
<input type="text" data-field="x_product_img_name" name="x<?php echo $products_list->RowIndex ?>_product_img_name" id="x<?php echo $products_list->RowIndex ?>_product_img_name" size="30" maxlength="60" placeholder="<?php echo $products->product_img_name->PlaceHolder ?>" value="<?php echo $products->product_img_name->EditValue ?>"<?php echo $products->product_img_name->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($products->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span<?php echo $products->product_img_name->ViewAttributes() ?>>
<?php echo $products->product_img_name->ListViewValue() ?></span>
<?php } ?>
<a id="<?php echo $products_list->PageObjName . "_row_" . $products_list->RowCnt ?>"></a></td>
	<?php } ?>
	<?php if ($products->img1->Visible) { // img1 ?>
		<td<?php echo $products->img1->CellAttributes() ?>>
<?php if ($products->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $products_list->RowCnt ?>_products_img1" class="control-group products_img1">
<input type="text" data-field="x_img1" name="x<?php echo $products_list->RowIndex ?>_img1" id="x<?php echo $products_list->RowIndex ?>_img1" size="30" maxlength="200" placeholder="<?php echo $products->img1->PlaceHolder ?>" value="<?php echo $products->img1->EditValue ?>"<?php echo $products->img1->EditAttributes() ?>>
</span>
<input type="hidden" data-field="x_img1" name="o<?php echo $products_list->RowIndex ?>_img1" id="o<?php echo $products_list->RowIndex ?>_img1" value="<?php echo ew_HtmlEncode($products->img1->OldValue) ?>">
<?php } ?>
<?php if ($products->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $products_list->RowCnt ?>_products_img1" class="control-group products_img1">
<input type="text" data-field="x_img1" name="x<?php echo $products_list->RowIndex ?>_img1" id="x<?php echo $products_list->RowIndex ?>_img1" size="30" maxlength="200" placeholder="<?php echo $products->img1->PlaceHolder ?>" value="<?php echo $products->img1->EditValue ?>"<?php echo $products->img1->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($products->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span<?php echo $products->img1->ViewAttributes() ?>>
<?php echo $products->img1->ListViewValue() ?></span>
<?php } ?>
<a id="<?php echo $products_list->PageObjName . "_row_" . $products_list->RowCnt ?>"></a></td>
	<?php } ?>
	<?php if ($products->cat->Visible) { // cat ?>
		<td<?php echo $products->cat->CellAttributes() ?>>
<?php if ($products->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $products_list->RowCnt ?>_products_cat" class="control-group products_cat">
<input type="text" data-field="x_cat" name="x<?php echo $products_list->RowIndex ?>_cat" id="x<?php echo $products_list->RowIndex ?>_cat" size="30" maxlength="50" placeholder="<?php echo $products->cat->PlaceHolder ?>" value="<?php echo $products->cat->EditValue ?>"<?php echo $products->cat->EditAttributes() ?>>
</span>
<input type="hidden" data-field="x_cat" name="o<?php echo $products_list->RowIndex ?>_cat" id="o<?php echo $products_list->RowIndex ?>_cat" value="<?php echo ew_HtmlEncode($products->cat->OldValue) ?>">
<?php } ?>
<?php if ($products->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $products_list->RowCnt ?>_products_cat" class="control-group products_cat">
<input type="text" data-field="x_cat" name="x<?php echo $products_list->RowIndex ?>_cat" id="x<?php echo $products_list->RowIndex ?>_cat" size="30" maxlength="50" placeholder="<?php echo $products->cat->PlaceHolder ?>" value="<?php echo $products->cat->EditValue ?>"<?php echo $products->cat->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($products->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span<?php echo $products->cat->ViewAttributes() ?>>
<?php echo $products->cat->ListViewValue() ?></span>
<?php } ?>
<a id="<?php echo $products_list->PageObjName . "_row_" . $products_list->RowCnt ?>"></a></td>
	<?php } ?>
	<?php if ($products->subcat->Visible) { // subcat ?>
		<td<?php echo $products->subcat->CellAttributes() ?>>
<?php if ($products->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $products_list->RowCnt ?>_products_subcat" class="control-group products_subcat">
<input type="text" data-field="x_subcat" name="x<?php echo $products_list->RowIndex ?>_subcat" id="x<?php echo $products_list->RowIndex ?>_subcat" size="30" maxlength="50" placeholder="<?php echo $products->subcat->PlaceHolder ?>" value="<?php echo $products->subcat->EditValue ?>"<?php echo $products->subcat->EditAttributes() ?>>
</span>
<input type="hidden" data-field="x_subcat" name="o<?php echo $products_list->RowIndex ?>_subcat" id="o<?php echo $products_list->RowIndex ?>_subcat" value="<?php echo ew_HtmlEncode($products->subcat->OldValue) ?>">
<?php } ?>
<?php if ($products->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $products_list->RowCnt ?>_products_subcat" class="control-group products_subcat">
<input type="text" data-field="x_subcat" name="x<?php echo $products_list->RowIndex ?>_subcat" id="x<?php echo $products_list->RowIndex ?>_subcat" size="30" maxlength="50" placeholder="<?php echo $products->subcat->PlaceHolder ?>" value="<?php echo $products->subcat->EditValue ?>"<?php echo $products->subcat->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($products->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span<?php echo $products->subcat->ViewAttributes() ?>>
<?php echo $products->subcat->ListViewValue() ?></span>
<?php } ?>
<a id="<?php echo $products_list->PageObjName . "_row_" . $products_list->RowCnt ?>"></a></td>
	<?php } ?>
	<?php if ($products->sales_status->Visible) { // sales_status ?>
		<td<?php echo $products->sales_status->CellAttributes() ?>>
<?php if ($products->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $products_list->RowCnt ?>_products_sales_status" class="control-group products_sales_status">
<div id="tp_x<?php echo $products_list->RowIndex ?>_sales_status" class="<?php echo EW_ITEM_TEMPLATE_CLASSNAME ?>"><input type="radio" name="x<?php echo $products_list->RowIndex ?>_sales_status" id="x<?php echo $products_list->RowIndex ?>_sales_status" value="{value}"<?php echo $products->sales_status->EditAttributes() ?>></div>
<div id="dsl_x<?php echo $products_list->RowIndex ?>_sales_status" data-repeatcolumn="5" class="ewItemList">
<?php
$arwrk = $products->sales_status->EditValue;
if (is_array($arwrk)) {
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($products->sales_status->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " checked=\"checked\"" : "";
		if ($selwrk <> "") $emptywrk = FALSE;

		// Note: No spacing within the LABEL tag
?>
<?php echo ew_RepeatColumnTable($rowswrk, $rowcntwrk, 5, 1) ?>
<label class="radio"><input type="radio" data-field="x_sales_status" name="x<?php echo $products_list->RowIndex ?>_sales_status" id="x<?php echo $products_list->RowIndex ?>_sales_status_<?php echo $rowcntwrk ?>" value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?><?php echo $products->sales_status->EditAttributes() ?>><?php echo $arwrk[$rowcntwrk][1] ?></label>
<?php echo ew_RepeatColumnTable($rowswrk, $rowcntwrk, 5, 2) ?>
<?php
	}
}
if (@$emptywrk) $products->sales_status->OldValue = "";
?>
</div>
</span>
<input type="hidden" data-field="x_sales_status" name="o<?php echo $products_list->RowIndex ?>_sales_status" id="o<?php echo $products_list->RowIndex ?>_sales_status" value="<?php echo ew_HtmlEncode($products->sales_status->OldValue) ?>">
<?php } ?>
<?php if ($products->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $products_list->RowCnt ?>_products_sales_status" class="control-group products_sales_status">
<div id="tp_x<?php echo $products_list->RowIndex ?>_sales_status" class="<?php echo EW_ITEM_TEMPLATE_CLASSNAME ?>"><input type="radio" name="x<?php echo $products_list->RowIndex ?>_sales_status" id="x<?php echo $products_list->RowIndex ?>_sales_status" value="{value}"<?php echo $products->sales_status->EditAttributes() ?>></div>
<div id="dsl_x<?php echo $products_list->RowIndex ?>_sales_status" data-repeatcolumn="5" class="ewItemList">
<?php
$arwrk = $products->sales_status->EditValue;
if (is_array($arwrk)) {
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($products->sales_status->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " checked=\"checked\"" : "";
		if ($selwrk <> "") $emptywrk = FALSE;

		// Note: No spacing within the LABEL tag
?>
<?php echo ew_RepeatColumnTable($rowswrk, $rowcntwrk, 5, 1) ?>
<label class="radio"><input type="radio" data-field="x_sales_status" name="x<?php echo $products_list->RowIndex ?>_sales_status" id="x<?php echo $products_list->RowIndex ?>_sales_status_<?php echo $rowcntwrk ?>" value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?><?php echo $products->sales_status->EditAttributes() ?>><?php echo $arwrk[$rowcntwrk][1] ?></label>
<?php echo ew_RepeatColumnTable($rowswrk, $rowcntwrk, 5, 2) ?>
<?php
	}
}
if (@$emptywrk) $products->sales_status->OldValue = "";
?>
</div>
</span>
<?php } ?>
<?php if ($products->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span<?php echo $products->sales_status->ViewAttributes() ?>>
<?php echo $products->sales_status->ListViewValue() ?></span>
<?php } ?>
<a id="<?php echo $products_list->PageObjName . "_row_" . $products_list->RowCnt ?>"></a></td>
	<?php } ?>
<?php

// Render list options (body, right)
$products_list->ListOptions->Render("body", "right", $products_list->RowCnt);
?>
	</tr>
<?php if ($products->RowType == EW_ROWTYPE_ADD || $products->RowType == EW_ROWTYPE_EDIT) { ?>
<script type="text/javascript">
fproductslist.UpdateOpts(<?php echo $products_list->RowIndex ?>);
</script>
<?php } ?>
<?php
	}
	} // End delete row checking
	if ($products->CurrentAction <> "gridadd")
		if (!$products_list->Recordset->EOF) $products_list->Recordset->MoveNext();
}
?>
<?php
	if ($products->CurrentAction == "gridadd" || $products->CurrentAction == "gridedit") {
		$products_list->RowIndex = '$rowindex$';
		$products_list->LoadDefaultValues();

		// Set row properties
		$products->ResetAttrs();
		$products->RowAttrs = array_merge($products->RowAttrs, array('data-rowindex'=>$products_list->RowIndex, 'id'=>'r0_products', 'data-rowtype'=>EW_ROWTYPE_ADD));
		ew_AppendClass($products->RowAttrs["class"], "ewTemplate");
		$products->RowType = EW_ROWTYPE_ADD;

		// Render row
		$products_list->RenderRow();

		// Render list options
		$products_list->RenderListOptions();
		$products_list->StartRowCnt = 0;
?>
	<tr<?php echo $products->RowAttributes() ?>>
<?php

// Render list options (body, left)
$products_list->ListOptions->Render("body", "left", $products_list->RowIndex);
?>
	<?php if ($products->price->Visible) { // price ?>
		<td>
<span id="el$rowindex$_products_price" class="control-group products_price">
<input type="text" data-field="x_price" name="x<?php echo $products_list->RowIndex ?>_price" id="x<?php echo $products_list->RowIndex ?>_price" size="30" placeholder="<?php echo $products->price->PlaceHolder ?>" value="<?php echo $products->price->EditValue ?>"<?php echo $products->price->EditAttributes() ?>>
</span>
<input type="hidden" data-field="x_price" name="o<?php echo $products_list->RowIndex ?>_price" id="o<?php echo $products_list->RowIndex ?>_price" value="<?php echo ew_HtmlEncode($products->price->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($products->oldprice->Visible) { // oldprice ?>
		<td>
<span id="el$rowindex$_products_oldprice" class="control-group products_oldprice">
<input type="text" data-field="x_oldprice" name="x<?php echo $products_list->RowIndex ?>_oldprice" id="x<?php echo $products_list->RowIndex ?>_oldprice" size="30" maxlength="10" placeholder="<?php echo $products->oldprice->PlaceHolder ?>" value="<?php echo $products->oldprice->EditValue ?>"<?php echo $products->oldprice->EditAttributes() ?>>
</span>
<input type="hidden" data-field="x_oldprice" name="o<?php echo $products_list->RowIndex ?>_oldprice" id="o<?php echo $products_list->RowIndex ?>_oldprice" value="<?php echo ew_HtmlEncode($products->oldprice->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($products->product_code->Visible) { // product_code ?>
		<td>
<span id="el$rowindex$_products_product_code" class="control-group products_product_code">
<input type="text" data-field="x_product_code" name="x<?php echo $products_list->RowIndex ?>_product_code" id="x<?php echo $products_list->RowIndex ?>_product_code" size="30" maxlength="60" placeholder="<?php echo $products->product_code->PlaceHolder ?>" value="<?php echo $products->product_code->EditValue ?>"<?php echo $products->product_code->EditAttributes() ?>>
</span>
<input type="hidden" data-field="x_product_code" name="o<?php echo $products_list->RowIndex ?>_product_code" id="o<?php echo $products_list->RowIndex ?>_product_code" value="<?php echo ew_HtmlEncode($products->product_code->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($products->product_name->Visible) { // product_name ?>
		<td>
<span id="el$rowindex$_products_product_name" class="control-group products_product_name">
<input type="text" data-field="x_product_name" name="x<?php echo $products_list->RowIndex ?>_product_name" id="x<?php echo $products_list->RowIndex ?>_product_name" size="30" maxlength="60" placeholder="<?php echo $products->product_name->PlaceHolder ?>" value="<?php echo $products->product_name->EditValue ?>"<?php echo $products->product_name->EditAttributes() ?>>
</span>
<input type="hidden" data-field="x_product_name" name="o<?php echo $products_list->RowIndex ?>_product_name" id="o<?php echo $products_list->RowIndex ?>_product_name" value="<?php echo ew_HtmlEncode($products->product_name->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($products->product_img_name->Visible) { // product_img_name ?>
		<td>
<span id="el$rowindex$_products_product_img_name" class="control-group products_product_img_name">
<input type="text" data-field="x_product_img_name" name="x<?php echo $products_list->RowIndex ?>_product_img_name" id="x<?php echo $products_list->RowIndex ?>_product_img_name" size="30" maxlength="60" placeholder="<?php echo $products->product_img_name->PlaceHolder ?>" value="<?php echo $products->product_img_name->EditValue ?>"<?php echo $products->product_img_name->EditAttributes() ?>>
</span>
<input type="hidden" data-field="x_product_img_name" name="o<?php echo $products_list->RowIndex ?>_product_img_name" id="o<?php echo $products_list->RowIndex ?>_product_img_name" value="<?php echo ew_HtmlEncode($products->product_img_name->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($products->img1->Visible) { // img1 ?>
		<td>
<span id="el$rowindex$_products_img1" class="control-group products_img1">
<input type="text" data-field="x_img1" name="x<?php echo $products_list->RowIndex ?>_img1" id="x<?php echo $products_list->RowIndex ?>_img1" size="30" maxlength="200" placeholder="<?php echo $products->img1->PlaceHolder ?>" value="<?php echo $products->img1->EditValue ?>"<?php echo $products->img1->EditAttributes() ?>>
</span>
<input type="hidden" data-field="x_img1" name="o<?php echo $products_list->RowIndex ?>_img1" id="o<?php echo $products_list->RowIndex ?>_img1" value="<?php echo ew_HtmlEncode($products->img1->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($products->cat->Visible) { // cat ?>
		<td>
<span id="el$rowindex$_products_cat" class="control-group products_cat">
<input type="text" data-field="x_cat" name="x<?php echo $products_list->RowIndex ?>_cat" id="x<?php echo $products_list->RowIndex ?>_cat" size="30" maxlength="50" placeholder="<?php echo $products->cat->PlaceHolder ?>" value="<?php echo $products->cat->EditValue ?>"<?php echo $products->cat->EditAttributes() ?>>
</span>
<input type="hidden" data-field="x_cat" name="o<?php echo $products_list->RowIndex ?>_cat" id="o<?php echo $products_list->RowIndex ?>_cat" value="<?php echo ew_HtmlEncode($products->cat->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($products->subcat->Visible) { // subcat ?>
		<td>
<span id="el$rowindex$_products_subcat" class="control-group products_subcat">
<input type="text" data-field="x_subcat" name="x<?php echo $products_list->RowIndex ?>_subcat" id="x<?php echo $products_list->RowIndex ?>_subcat" size="30" maxlength="50" placeholder="<?php echo $products->subcat->PlaceHolder ?>" value="<?php echo $products->subcat->EditValue ?>"<?php echo $products->subcat->EditAttributes() ?>>
</span>
<input type="hidden" data-field="x_subcat" name="o<?php echo $products_list->RowIndex ?>_subcat" id="o<?php echo $products_list->RowIndex ?>_subcat" value="<?php echo ew_HtmlEncode($products->subcat->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($products->sales_status->Visible) { // sales_status ?>
		<td>
<span id="el$rowindex$_products_sales_status" class="control-group products_sales_status">
<div id="tp_x<?php echo $products_list->RowIndex ?>_sales_status" class="<?php echo EW_ITEM_TEMPLATE_CLASSNAME ?>"><input type="radio" name="x<?php echo $products_list->RowIndex ?>_sales_status" id="x<?php echo $products_list->RowIndex ?>_sales_status" value="{value}"<?php echo $products->sales_status->EditAttributes() ?>></div>
<div id="dsl_x<?php echo $products_list->RowIndex ?>_sales_status" data-repeatcolumn="5" class="ewItemList">
<?php
$arwrk = $products->sales_status->EditValue;
if (is_array($arwrk)) {
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($products->sales_status->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " checked=\"checked\"" : "";
		if ($selwrk <> "") $emptywrk = FALSE;

		// Note: No spacing within the LABEL tag
?>
<?php echo ew_RepeatColumnTable($rowswrk, $rowcntwrk, 5, 1) ?>
<label class="radio"><input type="radio" data-field="x_sales_status" name="x<?php echo $products_list->RowIndex ?>_sales_status" id="x<?php echo $products_list->RowIndex ?>_sales_status_<?php echo $rowcntwrk ?>" value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?><?php echo $products->sales_status->EditAttributes() ?>><?php echo $arwrk[$rowcntwrk][1] ?></label>
<?php echo ew_RepeatColumnTable($rowswrk, $rowcntwrk, 5, 2) ?>
<?php
	}
}
if (@$emptywrk) $products->sales_status->OldValue = "";
?>
</div>
</span>
<input type="hidden" data-field="x_sales_status" name="o<?php echo $products_list->RowIndex ?>_sales_status" id="o<?php echo $products_list->RowIndex ?>_sales_status" value="<?php echo ew_HtmlEncode($products->sales_status->OldValue) ?>">
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$products_list->ListOptions->Render("body", "right", $products_list->RowCnt);
?>
<script type="text/javascript">
fproductslist.UpdateOpts(<?php echo $products_list->RowIndex ?>);
</script>
	</tr>
<?php
}
?>
</tbody>
</table>
<?php } ?>
<?php if ($products->CurrentAction == "add" || $products->CurrentAction == "copy") { ?>
<input type="hidden" name="<?php echo $products_list->FormKeyCountName ?>" id="<?php echo $products_list->FormKeyCountName ?>" value="<?php echo $products_list->KeyCount ?>">
<?php } ?>
<?php if ($products->CurrentAction == "gridadd") { ?>
<input type="hidden" name="a_list" id="a_list" value="gridinsert">
<input type="hidden" name="<?php echo $products_list->FormKeyCountName ?>" id="<?php echo $products_list->FormKeyCountName ?>" value="<?php echo $products_list->KeyCount ?>">
<?php echo $products_list->MultiSelectKey ?>
<?php } ?>
<?php if ($products->CurrentAction == "edit") { ?>
<input type="hidden" name="<?php echo $products_list->FormKeyCountName ?>" id="<?php echo $products_list->FormKeyCountName ?>" value="<?php echo $products_list->KeyCount ?>">
<?php } ?>
<?php if ($products->CurrentAction == "gridedit") { ?>
<input type="hidden" name="a_list" id="a_list" value="gridupdate">
<input type="hidden" name="<?php echo $products_list->FormKeyCountName ?>" id="<?php echo $products_list->FormKeyCountName ?>" value="<?php echo $products_list->KeyCount ?>">
<?php echo $products_list->MultiSelectKey ?>
<?php } ?>
<?php if ($products->CurrentAction == "") { ?>
<input type="hidden" name="a_list" id="a_list" value="">
<?php } ?>
</div>
</form>
<?php

// Close recordset
if ($products_list->Recordset)
	$products_list->Recordset->Close();
?>
<?php if ($products->Export == "") { ?>
<div class="ewGridLowerPanel">
<?php if ($products->CurrentAction <> "gridadd" && $products->CurrentAction <> "gridedit") { ?>
<form name="ewPagerForm" class="ewForm form-horizontal" action="<?php echo ew_CurrentPage() ?>">
<table class="ewPager">
<tr><td>
<?php if (!isset($products_list->Pager)) $products_list->Pager = new cNumericPager($products_list->StartRec, $products_list->DisplayRecs, $products_list->TotalRecs, $products_list->RecRange) ?>
<?php if ($products_list->Pager->RecordCount > 0) { ?>
<table cellspacing="0" class="ewStdTable"><tbody><tr><td>
<div class="pagination"><ul>
	<?php if ($products_list->Pager->FirstButton->Enabled) { ?>
	<li><a href="<?php echo $products_list->PageUrl() ?>start=<?php echo $products_list->Pager->FirstButton->Start ?>"><?php echo $Language->Phrase("PagerFirst") ?></a></li>
	<?php } ?>
	<?php if ($products_list->Pager->PrevButton->Enabled) { ?>
	<li><a href="<?php echo $products_list->PageUrl() ?>start=<?php echo $products_list->Pager->PrevButton->Start ?>"><?php echo $Language->Phrase("PagerPrevious") ?></a></li>
	<?php } ?>
	<?php foreach ($products_list->Pager->Items as $PagerItem) { ?>
		<li<?php if (!$PagerItem->Enabled) { echo " class=\" active\""; } ?>><a href="<?php if ($PagerItem->Enabled) { echo $products_list->PageUrl() . "start=" . $PagerItem->Start; } else { echo "#"; } ?>"><?php echo $PagerItem->Text ?></a></li>
	<?php } ?>
	<?php if ($products_list->Pager->NextButton->Enabled) { ?>
	<li><a href="<?php echo $products_list->PageUrl() ?>start=<?php echo $products_list->Pager->NextButton->Start ?>"><?php echo $Language->Phrase("PagerNext") ?></a></li>
	<?php } ?>
	<?php if ($products_list->Pager->LastButton->Enabled) { ?>
	<li><a href="<?php echo $products_list->PageUrl() ?>start=<?php echo $products_list->Pager->LastButton->Start ?>"><?php echo $Language->Phrase("PagerLast") ?></a></li>
	<?php } ?>
</ul></div>
</td>
<td>
	<?php if ($products_list->Pager->ButtonCount > 0) { ?>&nbsp;&nbsp;&nbsp;&nbsp;<?php } ?>
	<?php echo $Language->Phrase("Record") ?>&nbsp;<?php echo $products_list->Pager->FromIndex ?>&nbsp;<?php echo $Language->Phrase("To") ?>&nbsp;<?php echo $products_list->Pager->ToIndex ?>&nbsp;<?php echo $Language->Phrase("Of") ?>&nbsp;<?php echo $products_list->Pager->RecordCount ?>
</td>
</tr></tbody></table>
<?php } else { ?>
	<?php if ($products_list->SearchWhere == "0=101") { ?>
	<p><?php echo $Language->Phrase("EnterSearchCriteria") ?></p>
	<?php } else { ?>
	<p><?php echo $Language->Phrase("NoRecord") ?></p>
	<?php } ?>
<?php } ?>
</td>
<?php if ($products_list->TotalRecs > 0) { ?>
<td>
	&nbsp;&nbsp;&nbsp;&nbsp;
<input type="hidden" name="t" value="products">
<select name="<?php echo EW_TABLE_REC_PER_PAGE ?>" class="input-small" onchange="this.form.submit();">
<option value="25"<?php if ($products_list->DisplayRecs == 25) { ?> selected="selected"<?php } ?>>25</option>
<option value="50"<?php if ($products_list->DisplayRecs == 50) { ?> selected="selected"<?php } ?>>50</option>
<option value="100"<?php if ($products_list->DisplayRecs == 100) { ?> selected="selected"<?php } ?>>100</option>
<option value="200"<?php if ($products_list->DisplayRecs == 200) { ?> selected="selected"<?php } ?>>200</option>
<option value="500"<?php if ($products_list->DisplayRecs == 500) { ?> selected="selected"<?php } ?>>500</option>
<option value="ALL"<?php if ($products->getRecordsPerPage() == -1) { ?> selected="selected"<?php } ?>><?php echo $Language->Phrase("AllRecords") ?></option>
</select>
</td>
<?php } ?>
</tr></table>
</form>
<?php } ?>
<div class="ewListOtherOptions">
<?php
	foreach ($products_list->OtherOptions as &$option)
		$option->Render("body", "bottom");
?>
</div>
</div>
<?php } ?>
</td></tr></table>
<?php if ($products->Export == "") { ?>
<script type="text/javascript">
fproductslistsrch.Init();
fproductslist.Init();
<?php if (EW_MOBILE_REFLOW && ew_IsMobile()) { ?>
ew_Reflow();
<?php } ?>
</script>
<?php } ?>
<?php
$products_list->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<?php if ($products->Export == "") { ?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php } ?>
<?php include_once "footer.php" ?>
<?php
$products_list->Page_Terminate();
?>
