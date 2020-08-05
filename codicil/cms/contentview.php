<?php
if (session_id() == "") session_start(); // Initialize Session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg10.php" ?>
<?php include_once "ewmysql10.php" ?>
<?php include_once "phpfn10.php" ?>
<?php include_once "contentinfo.php" ?>
<?php include_once "adminusersinfo.php" ?>
<?php include_once "userfn10.php" ?>
<?php

//
// Page class
//

$content_view = NULL; // Initialize page object first

class ccontent_view extends ccontent {

	// Page ID
	var $PageID = 'view';

	// Project ID
	var $ProjectID = "{D9B361E7-B2C1-4293-B9B3-B581986A15CC}";

	// Table name
	var $TableName = 'content';

	// Page object name
	var $PageObjName = 'content_view';

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

		// Table object (content)
		if (!isset($GLOBALS["content"])) {
			$GLOBALS["content"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["content"];
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
			define("EW_TABLE_NAME", 'content', TRUE);

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
						$this->Page_Terminate("contentlist.php"); // Return to list page
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
						$sReturnUrl = "contentlist.php"; // No matching record, return to list
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
			$sReturnUrl = "contentlist.php"; // Not page request, return to list
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
		$this->pg_name->setDbValue($rs->fields('pg_name'));
		$this->pg_cat->setDbValue($rs->fields('pg_cat'));
		$this->content->setDbValue($rs->fields('content'));
		$this->pg_alias->setDbValue($rs->fields('pg_alias'));
		$this->pg_type->setDbValue($rs->fields('pg_type'));
		$this->pg_menu->setDbValue($rs->fields('pg_menu'));
		$this->pg_title->setDbValue($rs->fields('pg_title'));
		$this->keywords->setDbValue($rs->fields('keywords'));
		$this->pr_status->setDbValue($rs->fields('pr_status'));
		$this->pg_url->setDbValue($rs->fields('pg_url'));
		$this->secured_st->setDbValue($rs->fields('secured_st'));
		$this->rate_ord->setDbValue($rs->fields('rate_ord'));
		$this->uploads->Upload->DbValue = $rs->fields('uploads');
		$this->intro->setDbValue($rs->fields('intro'));
		$this->sidebar->setDbValue($rs->fields('sidebar'));
		$this->postdate->setDbValue($rs->fields('postdate'));
		$this->img1->setDbValue($rs->fields('img1'));
		$this->img2->setDbValue($rs->fields('img2'));
		$this->creator->setDbValue($rs->fields('creator'));
		$this->datep->setDbValue($rs->fields('datep'));
	}

	// Load DbValue from recordset
	function LoadDbValues(&$rs) {
		if (!$rs || !is_array($rs) && $rs->EOF) return;
		$row = is_array($rs) ? $rs : $rs->fields;
		$this->id->DbValue = $row['id'];
		$this->pg_name->DbValue = $row['pg_name'];
		$this->pg_cat->DbValue = $row['pg_cat'];
		$this->content->DbValue = $row['content'];
		$this->pg_alias->DbValue = $row['pg_alias'];
		$this->pg_type->DbValue = $row['pg_type'];
		$this->pg_menu->DbValue = $row['pg_menu'];
		$this->pg_title->DbValue = $row['pg_title'];
		$this->keywords->DbValue = $row['keywords'];
		$this->pr_status->DbValue = $row['pr_status'];
		$this->pg_url->DbValue = $row['pg_url'];
		$this->secured_st->DbValue = $row['secured_st'];
		$this->rate_ord->DbValue = $row['rate_ord'];
		$this->uploads->Upload->DbValue = $row['uploads'];
		$this->intro->DbValue = $row['intro'];
		$this->sidebar->DbValue = $row['sidebar'];
		$this->postdate->DbValue = $row['postdate'];
		$this->img1->DbValue = $row['img1'];
		$this->img2->DbValue = $row['img2'];
		$this->creator->DbValue = $row['creator'];
		$this->datep->DbValue = $row['datep'];
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
		// pg_name
		// pg_cat
		// content
		// pg_alias
		// pg_type
		// pg_menu
		// pg_title
		// keywords
		// pr_status
		// pg_url
		// secured_st
		// rate_ord
		// uploads
		// intro
		// sidebar
		// postdate
		// img1
		// img2
		// creator
		// datep

		if ($this->RowType == EW_ROWTYPE_VIEW) { // View row

			// id
			$this->id->ViewValue = $this->id->CurrentValue;
			$this->id->ViewCustomAttributes = "";

			// pg_name
			$this->pg_name->ViewValue = $this->pg_name->CurrentValue;
			$this->pg_name->ViewCustomAttributes = "";

			// pg_cat
			if (strval($this->pg_cat->CurrentValue) <> "") {
				$sFilterWrk = "`pg_cat`" . ew_SearchString("=", $this->pg_cat->CurrentValue, EW_DATATYPE_STRING);
			$sSqlWrk = "SELECT `pg_cat`, `pg_cat` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `page_cat`";
			$sWhereWrk = "";
			if ($sFilterWrk <> "") {
				ew_AddFilter($sWhereWrk, $sFilterWrk);
			}

			// Call Lookup selecting
			$this->Lookup_Selecting($this->pg_cat, $sWhereWrk);
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
				$rswrk = $conn->Execute($sSqlWrk);
				if ($rswrk && !$rswrk->EOF) { // Lookup values found
					$this->pg_cat->ViewValue = $rswrk->fields('DispFld');
					$rswrk->Close();
				} else {
					$this->pg_cat->ViewValue = $this->pg_cat->CurrentValue;
				}
			} else {
				$this->pg_cat->ViewValue = NULL;
			}
			$this->pg_cat->ViewCustomAttributes = "";

			// content
			$this->content->ViewValue = $this->content->CurrentValue;
			$this->content->ViewCustomAttributes = "";

			// pg_alias
			$this->pg_alias->ViewValue = $this->pg_alias->CurrentValue;
			$this->pg_alias->ViewCustomAttributes = "";

			// pg_type
			$this->pg_type->ViewValue = $this->pg_type->CurrentValue;
			if (strval($this->pg_type->CurrentValue) <> "") {
				$sFilterWrk = "`name`" . ew_SearchString("=", $this->pg_type->CurrentValue, EW_DATATYPE_STRING);
			$sSqlWrk = "SELECT `name`, `name` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `page_template`";
			$sWhereWrk = "";
			if ($sFilterWrk <> "") {
				ew_AddFilter($sWhereWrk, $sFilterWrk);
			}

			// Call Lookup selecting
			$this->Lookup_Selecting($this->pg_type, $sWhereWrk);
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
				$rswrk = $conn->Execute($sSqlWrk);
				if ($rswrk && !$rswrk->EOF) { // Lookup values found
					$this->pg_type->ViewValue = $rswrk->fields('DispFld');
					$rswrk->Close();
				} else {
					$this->pg_type->ViewValue = $this->pg_type->CurrentValue;
				}
			} else {
				$this->pg_type->ViewValue = NULL;
			}
			$this->pg_type->ViewCustomAttributes = "";

			// pg_menu
			$this->pg_menu->ViewValue = $this->pg_menu->CurrentValue;
			$this->pg_menu->ViewCustomAttributes = "";

			// pg_title
			$this->pg_title->ViewValue = $this->pg_title->CurrentValue;
			$this->pg_title->ViewCustomAttributes = "";

			// keywords
			$this->keywords->ViewValue = $this->keywords->CurrentValue;
			$this->keywords->ViewCustomAttributes = "";

			// pr_status
			if (strval($this->pr_status->CurrentValue) <> "") {
				switch ($this->pr_status->CurrentValue) {
					case $this->pr_status->FldTagValue(1):
						$this->pr_status->ViewValue = $this->pr_status->FldTagCaption(1) <> "" ? $this->pr_status->FldTagCaption(1) : $this->pr_status->CurrentValue;
						break;
					case $this->pr_status->FldTagValue(2):
						$this->pr_status->ViewValue = $this->pr_status->FldTagCaption(2) <> "" ? $this->pr_status->FldTagCaption(2) : $this->pr_status->CurrentValue;
						break;
					default:
						$this->pr_status->ViewValue = $this->pr_status->CurrentValue;
				}
			} else {
				$this->pr_status->ViewValue = NULL;
			}
			$this->pr_status->ViewCustomAttributes = "";

			// pg_url
			$this->pg_url->ViewValue = $this->pg_url->CurrentValue;
			$this->pg_url->ViewCustomAttributes = "";

			// secured_st
			if (ew_ConvertToBool($this->secured_st->CurrentValue)) {
				$this->secured_st->ViewValue = $this->secured_st->FldTagCaption(2) <> "" ? $this->secured_st->FldTagCaption(2) : "Secured";
			} else {
				$this->secured_st->ViewValue = $this->secured_st->FldTagCaption(1) <> "" ? $this->secured_st->FldTagCaption(1) : "Public";
			}
			$this->secured_st->ViewCustomAttributes = "";

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

			// uploads
			$this->uploads->UploadPath = "../uploads/";
			if (!ew_Empty($this->uploads->Upload->DbValue)) {
				$this->uploads->ViewValue = $this->uploads->Upload->DbValue;
			} else {
				$this->uploads->ViewValue = "";
			}
			$this->uploads->ViewCustomAttributes = "";

			// intro
			$this->intro->ViewValue = $this->intro->CurrentValue;
			$this->intro->ViewCustomAttributes = "";

			// sidebar
			$this->sidebar->ViewValue = $this->sidebar->CurrentValue;
			$this->sidebar->ViewCustomAttributes = "";

			// postdate
			$this->postdate->ViewValue = $this->postdate->CurrentValue;
			$this->postdate->ViewCustomAttributes = "";

			// img1
			$this->img1->ViewValue = $this->img1->CurrentValue;
			$this->img1->ViewCustomAttributes = "";

			// img2
			$this->img2->ViewValue = $this->img2->CurrentValue;
			$this->img2->ViewCustomAttributes = "";

			// creator
			$this->creator->ViewValue = $this->creator->CurrentValue;
			$this->creator->ViewCustomAttributes = "";

			// datep
			$this->datep->ViewValue = $this->datep->CurrentValue;
			$this->datep->ViewCustomAttributes = "";

			// id
			$this->id->LinkCustomAttributes = "";
			$this->id->HrefValue = "";
			$this->id->TooltipValue = "";

			// pg_name
			$this->pg_name->LinkCustomAttributes = "";
			$this->pg_name->HrefValue = "";
			$this->pg_name->TooltipValue = "";

			// pg_cat
			$this->pg_cat->LinkCustomAttributes = "";
			$this->pg_cat->HrefValue = "";
			$this->pg_cat->TooltipValue = "";

			// content
			$this->content->LinkCustomAttributes = "";
			$this->content->HrefValue = "";
			$this->content->TooltipValue = "";

			// pg_alias
			$this->pg_alias->LinkCustomAttributes = "";
			$this->pg_alias->HrefValue = "";
			$this->pg_alias->TooltipValue = "";

			// pg_type
			$this->pg_type->LinkCustomAttributes = "";
			$this->pg_type->HrefValue = "";
			$this->pg_type->TooltipValue = "";

			// pg_title
			$this->pg_title->LinkCustomAttributes = "";
			$this->pg_title->HrefValue = "";
			$this->pg_title->TooltipValue = "";

			// keywords
			$this->keywords->LinkCustomAttributes = "";
			$this->keywords->HrefValue = "";
			$this->keywords->TooltipValue = "";

			// pr_status
			$this->pr_status->LinkCustomAttributes = "";
			$this->pr_status->HrefValue = "";
			$this->pr_status->TooltipValue = "";

			// rate_ord
			$this->rate_ord->LinkCustomAttributes = "";
			$this->rate_ord->HrefValue = "";
			$this->rate_ord->TooltipValue = "";

			// uploads
			$this->uploads->LinkCustomAttributes = "";
			$this->uploads->HrefValue = "";
			$this->uploads->HrefValue2 = $this->uploads->UploadPath . $this->uploads->Upload->DbValue;
			$this->uploads->TooltipValue = "";

			// datep
			$this->datep->LinkCustomAttributes = "";
			$this->datep->HrefValue = "";
			$this->datep->TooltipValue = "";
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
		$item->Body = "<a id=\"emf_content\" href=\"javascript:void(0);\" class=\"ewExportLink ewEmail\" data-caption=\"" . $Language->Phrase("ExportToEmailText") . "\" onclick=\"ew_EmailDialogShow({lnk:'emf_content',hdr:ewLanguage.Phrase('ExportToEmail'),f:document.fcontentview,key:" . ew_ArrayToJsonAttr($this->RecKey) . ",sel:false});\">" . $Language->Phrase("ExportToEmail") . "</a>";
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
		$Breadcrumb->Add("list", "<span id=\"ewPageCaption\">" . $PageCaption . "</span>", "contentlist.php", $this->TableVar);
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
if (!isset($content_view)) $content_view = new ccontent_view();

// Page init
$content_view->Page_Init();

// Page main
$content_view->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$content_view->Page_Render();
?>
<?php include_once "header.php" ?>
<?php if ($content->Export == "") { ?>
<script type="text/javascript">

// Page object
var content_view = new ew_Page("content_view");
content_view.PageID = "view"; // Page ID
var EW_PAGE_ID = content_view.PageID; // For backward compatibility

// Form object
var fcontentview = new ew_Form("fcontentview");

// Form_CustomValidate event
fcontentview.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
fcontentview.ValidateRequired = true;
<?php } else { ?>
fcontentview.ValidateRequired = false; 
<?php } ?>

// Multi-Page properties
fcontentview.MultiPage = new ew_MultiPage("fcontentview",
	[["x_id",1],["x_pg_name",1],["x_pg_cat",1],["x_content",1],["x_pg_alias",1],["x_pg_type",1],["x_pg_title",2],["x_keywords",2],["x_pr_status",2],["x_rate_ord",2],["x_uploads",3],["x_datep",1]]
);

// Dynamic selection lists
fcontentview.Lists["x_pg_cat"] = {"LinkField":"x_pg_cat","Ajax":true,"AutoFill":false,"DisplayFields":["x_pg_cat","","",""],"ParentFields":[],"FilterFields":[],"Options":[]};
fcontentview.Lists["x_pg_type"] = {"LinkField":"x_name","Ajax":true,"AutoFill":false,"DisplayFields":["x_name","","",""],"ParentFields":[],"FilterFields":[],"Options":[]};

// Form object for search
</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<?php } ?>
<?php if ($content->Export == "") { ?>
<?php $Breadcrumb->Render(); ?>
<?php } ?>
<?php if ($content->Export == "") { ?>
<div class="ewViewExportOptions">
<?php $content_view->ExportOptions->Render("body") ?>
<?php if (!$content_view->ExportOptions->UseDropDownButton) { ?>
</div>
<div class="ewViewOtherOptions">
<?php } ?>
<?php
	foreach ($content_view->OtherOptions as &$option)
		$option->Render("body");
?>
</div>
<?php } ?>
<?php $content_view->ShowPageHeader(); ?>
<?php
$content_view->ShowMessage();
?>
<form name="fcontentview" id="fcontentview" class="ewForm form-horizontal" action="<?php echo ew_CurrentPage() ?>" method="post">
<input type="hidden" name="t" value="content">
<?php if ($content->Export == "") { ?>
<table class="ewStdTable"><tbody><tr><td>
<div class="tabbable" id="content_view">
	<ul class="nav nav-tabs">
		<li class="active"><a href="#tab_content1" data-toggle="tab"><?php echo $content->PageCaption(1) ?></a></li>
		<li><a href="#tab_content2" data-toggle="tab"><?php echo $content->PageCaption(2) ?></a></li>
		<li><a href="#tab_content3" data-toggle="tab"><?php echo $content->PageCaption(3) ?></a></li>
	</ul>
	<div class="tab-content">
<?php } ?>
		<div class="tab-pane active" id="tab_content1">
<table cellspacing="0" class="ewGrid" style="width: 100%"><tr><td>
<table id="tbl_contentview1" class="table table-bordered table-striped">
<?php if ($content->id->Visible) { // id ?>
	<tr id="r_id">
		<td><span id="elh_content_id"><?php echo $content->id->FldCaption() ?></span></td>
		<td<?php echo $content->id->CellAttributes() ?>>
<span id="el_content_id" class="control-group">
<span<?php echo $content->id->ViewAttributes() ?>>
<?php echo $content->id->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($content->pg_name->Visible) { // pg_name ?>
	<tr id="r_pg_name">
		<td><span id="elh_content_pg_name"><?php echo $content->pg_name->FldCaption() ?></span></td>
		<td<?php echo $content->pg_name->CellAttributes() ?>>
<span id="el_content_pg_name" class="control-group">
<span<?php echo $content->pg_name->ViewAttributes() ?>>
<?php echo $content->pg_name->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($content->pg_cat->Visible) { // pg_cat ?>
	<tr id="r_pg_cat">
		<td><span id="elh_content_pg_cat"><?php echo $content->pg_cat->FldCaption() ?></span></td>
		<td<?php echo $content->pg_cat->CellAttributes() ?>>
<span id="el_content_pg_cat" class="control-group">
<span<?php echo $content->pg_cat->ViewAttributes() ?>>
<?php echo $content->pg_cat->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($content->content->Visible) { // content ?>
	<tr id="r_content">
		<td><span id="elh_content_content"><?php echo $content->content->FldCaption() ?></span></td>
		<td<?php echo $content->content->CellAttributes() ?>>
<span id="el_content_content" class="control-group">
<span<?php echo $content->content->ViewAttributes() ?>>
<?php echo $content->content->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($content->pg_alias->Visible) { // pg_alias ?>
	<tr id="r_pg_alias">
		<td><span id="elh_content_pg_alias"><?php echo $content->pg_alias->FldCaption() ?></span></td>
		<td<?php echo $content->pg_alias->CellAttributes() ?>>
<span id="el_content_pg_alias" class="control-group">
<span<?php echo $content->pg_alias->ViewAttributes() ?>>
<?php echo $content->pg_alias->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($content->pg_type->Visible) { // pg_type ?>
	<tr id="r_pg_type">
		<td><span id="elh_content_pg_type"><?php echo $content->pg_type->FldCaption() ?></span></td>
		<td<?php echo $content->pg_type->CellAttributes() ?>>
<span id="el_content_pg_type" class="control-group">
<span<?php echo $content->pg_type->ViewAttributes() ?>>
<?php echo $content->pg_type->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($content->datep->Visible) { // datep ?>
	<tr id="r_datep">
		<td><span id="elh_content_datep"><?php echo $content->datep->FldCaption() ?></span></td>
		<td<?php echo $content->datep->CellAttributes() ?>>
<span id="el_content_datep" class="control-group">
<span<?php echo $content->datep->ViewAttributes() ?>>
<?php echo $content->datep->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
</table>
</td></tr></table>
		</div>
		<div class="tab-pane" id="tab_content2">
<table cellspacing="0" class="ewGrid" style="width: 100%"><tr><td>
<table id="tbl_contentview2" class="table table-bordered table-striped">
<?php if ($content->pg_title->Visible) { // pg_title ?>
	<tr id="r_pg_title">
		<td><span id="elh_content_pg_title"><?php echo $content->pg_title->FldCaption() ?></span></td>
		<td<?php echo $content->pg_title->CellAttributes() ?>>
<span id="el_content_pg_title" class="control-group">
<span<?php echo $content->pg_title->ViewAttributes() ?>>
<?php echo $content->pg_title->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($content->keywords->Visible) { // keywords ?>
	<tr id="r_keywords">
		<td><span id="elh_content_keywords"><?php echo $content->keywords->FldCaption() ?></span></td>
		<td<?php echo $content->keywords->CellAttributes() ?>>
<span id="el_content_keywords" class="control-group">
<span<?php echo $content->keywords->ViewAttributes() ?>>
<?php echo $content->keywords->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($content->pr_status->Visible) { // pr_status ?>
	<tr id="r_pr_status">
		<td><span id="elh_content_pr_status"><?php echo $content->pr_status->FldCaption() ?></span></td>
		<td<?php echo $content->pr_status->CellAttributes() ?>>
<span id="el_content_pr_status" class="control-group">
<span<?php echo $content->pr_status->ViewAttributes() ?>>
<?php echo $content->pr_status->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($content->rate_ord->Visible) { // rate_ord ?>
	<tr id="r_rate_ord">
		<td><span id="elh_content_rate_ord"><?php echo $content->rate_ord->FldCaption() ?></span></td>
		<td<?php echo $content->rate_ord->CellAttributes() ?>>
<span id="el_content_rate_ord" class="control-group">
<span<?php echo $content->rate_ord->ViewAttributes() ?>>
<?php echo $content->rate_ord->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
</table>
</td></tr></table>
		</div>
		<div class="tab-pane" id="tab_content3">
<table cellspacing="0" class="ewGrid" style="width: 100%"><tr><td>
<table id="tbl_contentview3" class="table table-bordered table-striped">
<?php if ($content->uploads->Visible) { // uploads ?>
	<tr id="r_uploads">
		<td><span id="elh_content_uploads"><?php echo $content->uploads->FldCaption() ?></span></td>
		<td<?php echo $content->uploads->CellAttributes() ?>>
<span id="el_content_uploads" class="control-group">
<span<?php echo $content->uploads->ViewAttributes() ?>>
<?php if ($content->uploads->LinkAttributes() <> "") { ?>
<?php if (!empty($content->uploads->Upload->DbValue)) { ?>
<?php echo $content->uploads->ViewValue ?>
<?php } elseif (!in_array($content->CurrentAction, array("I", "edit", "gridedit"))) { ?>	
&nbsp;
<?php } ?>
<?php } else { ?>
<?php if (!empty($content->uploads->Upload->DbValue)) { ?>
<?php echo $content->uploads->ViewValue ?>
<?php } elseif (!in_array($content->CurrentAction, array("I", "edit", "gridedit"))) { ?>	
&nbsp;
<?php } ?>
<?php } ?>
</span>
</span>
</td>
	</tr>
<?php } ?>
</table>
</td></tr></table>
		</div>
<?php if ($content->Export == "") { ?>
	</div>
</div>
</td></tr></tbody></table>
<?php } ?>
<?php if ($content->Export == "") { ?>
<table class="ewPager">
<tr><td>
<?php if (!isset($content_view->Pager)) $content_view->Pager = new cNumericPager($content_view->StartRec, $content_view->DisplayRecs, $content_view->TotalRecs, $content_view->RecRange) ?>
<?php if ($content_view->Pager->RecordCount > 0) { ?>
<table cellspacing="0" class="ewStdTable"><tbody><tr><td>
<div class="pagination"><ul>
	<?php if ($content_view->Pager->FirstButton->Enabled) { ?>
	<li><a href="<?php echo $content_view->PageUrl() ?>start=<?php echo $content_view->Pager->FirstButton->Start ?>"><?php echo $Language->Phrase("PagerFirst") ?></a></li>
	<?php } ?>
	<?php if ($content_view->Pager->PrevButton->Enabled) { ?>
	<li><a href="<?php echo $content_view->PageUrl() ?>start=<?php echo $content_view->Pager->PrevButton->Start ?>"><?php echo $Language->Phrase("PagerPrevious") ?></a></li>
	<?php } ?>
	<?php foreach ($content_view->Pager->Items as $PagerItem) { ?>
		<li<?php if (!$PagerItem->Enabled) { echo " class=\" active\""; } ?>><a href="<?php if ($PagerItem->Enabled) { echo $content_view->PageUrl() . "start=" . $PagerItem->Start; } else { echo "#"; } ?>"><?php echo $PagerItem->Text ?></a></li>
	<?php } ?>
	<?php if ($content_view->Pager->NextButton->Enabled) { ?>
	<li><a href="<?php echo $content_view->PageUrl() ?>start=<?php echo $content_view->Pager->NextButton->Start ?>"><?php echo $Language->Phrase("PagerNext") ?></a></li>
	<?php } ?>
	<?php if ($content_view->Pager->LastButton->Enabled) { ?>
	<li><a href="<?php echo $content_view->PageUrl() ?>start=<?php echo $content_view->Pager->LastButton->Start ?>"><?php echo $Language->Phrase("PagerLast") ?></a></li>
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
fcontentview.Init();
</script>
<?php
$content_view->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<?php if ($content->Export == "") { ?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php } ?>
<?php include_once "footer.php" ?>
<?php
$content_view->Page_Terminate();
?>
