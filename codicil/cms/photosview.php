<?php
if (session_id() == "") session_start(); // Initialize Session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg10.php" ?>
<?php include_once "ewmysql10.php" ?>
<?php include_once "phpfn10.php" ?>
<?php include_once "photosinfo.php" ?>
<?php include_once "adminusersinfo.php" ?>
<?php include_once "userfn10.php" ?>
<?php

//
// Page class
//

$photos_view = NULL; // Initialize page object first

class cphotos_view extends cphotos {

	// Page ID
	var $PageID = 'view';

	// Project ID
	var $ProjectID = "{D9B361E7-B2C1-4293-B9B3-B581986A15CC}";

	// Table name
	var $TableName = 'photos';

	// Page object name
	var $PageObjName = 'photos_view';

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

		// Table object (photos)
		if (!isset($GLOBALS["photos"])) {
			$GLOBALS["photos"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["photos"];
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
			define("EW_TABLE_NAME", 'photos', TRUE);

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
						$this->Page_Terminate("photoslist.php"); // Return to list page
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
						$sReturnUrl = "photoslist.php"; // No matching record, return to list
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
			$sReturnUrl = "photoslist.php"; // Not page request, return to list
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
		$this->img->Upload->DbValue = $rs->fields('img');
		$this->uid->setDbValue($rs->fields('uid'));
		$this->cat->setDbValue($rs->fields('cat'));
		$this->sub->setDbValue($rs->fields('sub'));
		$this->title->setDbValue($rs->fields('title'));
		$this->descp->setDbValue($rs->fields('descp'));
		$this->location->setDbValue($rs->fields('location'));
		$this->datetaken->setDbValue($rs->fields('datetaken'));
		$this->tags->setDbValue($rs->fields('tags'));
		$this->views->setDbValue($rs->fields('views'));
		$this->photoby->setDbValue($rs->fields('photoby'));
		$this->active->setDbValue($rs->fields('active'));
		$this->featured->setDbValue($rs->fields('featured'));
		$this->rate_ord->setDbValue($rs->fields('rate_ord'));
		$this->datep->setDbValue($rs->fields('datep'));
	}

	// Load DbValue from recordset
	function LoadDbValues(&$rs) {
		if (!$rs || !is_array($rs) && $rs->EOF) return;
		$row = is_array($rs) ? $rs : $rs->fields;
		$this->id->DbValue = $row['id'];
		$this->img->Upload->DbValue = $row['img'];
		$this->uid->DbValue = $row['uid'];
		$this->cat->DbValue = $row['cat'];
		$this->sub->DbValue = $row['sub'];
		$this->title->DbValue = $row['title'];
		$this->descp->DbValue = $row['descp'];
		$this->location->DbValue = $row['location'];
		$this->datetaken->DbValue = $row['datetaken'];
		$this->tags->DbValue = $row['tags'];
		$this->views->DbValue = $row['views'];
		$this->photoby->DbValue = $row['photoby'];
		$this->active->DbValue = $row['active'];
		$this->featured->DbValue = $row['featured'];
		$this->rate_ord->DbValue = $row['rate_ord'];
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
		// img
		// uid
		// cat
		// sub
		// title
		// descp
		// location
		// datetaken
		// tags
		// views
		// photoby
		// active
		// featured
		// rate_ord
		// datep

		if ($this->RowType == EW_ROWTYPE_VIEW) { // View row

			// id
			$this->id->ViewValue = $this->id->CurrentValue;
			$this->id->ViewCustomAttributes = "";

			// img
			$this->img->UploadPath = "../uploads/photos";
			if (!ew_Empty($this->img->Upload->DbValue)) {
				$this->img->ImageWidth = 50;
				$this->img->ImageHeight = 40;
				$this->img->ImageAlt = $this->img->FldAlt();
				$this->img->ViewValue = ew_UploadPathEx(FALSE, $this->img->UploadPath) . $this->img->Upload->DbValue;
			} else {
				$this->img->ViewValue = "";
			}
			$this->img->ViewCustomAttributes = "";

			// uid
			$this->uid->ViewValue = $this->uid->CurrentValue;
			$this->uid->ViewCustomAttributes = "";

			// cat
			if (strval($this->cat->CurrentValue) <> "") {
				$sFilterWrk = "`id`" . ew_SearchString("=", $this->cat->CurrentValue, EW_DATATYPE_NUMBER);
			$sSqlWrk = "SELECT `id`, `category` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `gallery_cats`";
			$sWhereWrk = "";
			if ($sFilterWrk <> "") {
				ew_AddFilter($sWhereWrk, $sFilterWrk);
			}

			// Call Lookup selecting
			$this->Lookup_Selecting($this->cat, $sWhereWrk);
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
				$rswrk = $conn->Execute($sSqlWrk);
				if ($rswrk && !$rswrk->EOF) { // Lookup values found
					$this->cat->ViewValue = $rswrk->fields('DispFld');
					$rswrk->Close();
				} else {
					$this->cat->ViewValue = $this->cat->CurrentValue;
				}
			} else {
				$this->cat->ViewValue = NULL;
			}
			$this->cat->ViewCustomAttributes = "";

			// sub
			if (strval($this->sub->CurrentValue) <> "") {
				$sFilterWrk = "`id`" . ew_SearchString("=", $this->sub->CurrentValue, EW_DATATYPE_NUMBER);
			$sSqlWrk = "SELECT `id`, `subcat` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `gallery_subcat`";
			$sWhereWrk = "";
			if ($sFilterWrk <> "") {
				ew_AddFilter($sWhereWrk, $sFilterWrk);
			}

			// Call Lookup selecting
			$this->Lookup_Selecting($this->sub, $sWhereWrk);
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
				$rswrk = $conn->Execute($sSqlWrk);
				if ($rswrk && !$rswrk->EOF) { // Lookup values found
					$this->sub->ViewValue = $rswrk->fields('DispFld');
					$rswrk->Close();
				} else {
					$this->sub->ViewValue = $this->sub->CurrentValue;
				}
			} else {
				$this->sub->ViewValue = NULL;
			}
			$this->sub->ViewCustomAttributes = "";

			// title
			$this->title->ViewValue = $this->title->CurrentValue;
			$this->title->ViewCustomAttributes = "";

			// descp
			$this->descp->ViewValue = $this->descp->CurrentValue;
			$this->descp->ViewCustomAttributes = "";

			// location
			$this->location->ViewValue = $this->location->CurrentValue;
			$this->location->ViewCustomAttributes = "";

			// datetaken
			$this->datetaken->ViewValue = $this->datetaken->CurrentValue;
			$this->datetaken->ViewCustomAttributes = "";

			// tags
			$this->tags->ViewValue = $this->tags->CurrentValue;
			$this->tags->ViewCustomAttributes = "";

			// views
			$this->views->ViewValue = $this->views->CurrentValue;
			$this->views->ViewCustomAttributes = "";

			// photoby
			$this->photoby->ViewValue = $this->photoby->CurrentValue;
			$this->photoby->ViewCustomAttributes = "";

			// active
			if (ew_ConvertToBool($this->active->CurrentValue)) {
				$this->active->ViewValue = $this->active->FldTagCaption(2) <> "" ? $this->active->FldTagCaption(2) : "Visible";
			} else {
				$this->active->ViewValue = $this->active->FldTagCaption(1) <> "" ? $this->active->FldTagCaption(1) : "Disable";
			}
			$this->active->ViewCustomAttributes = "";

			// featured
			if (ew_ConvertToBool($this->featured->CurrentValue)) {
				$this->featured->ViewValue = $this->featured->FldTagCaption(2) <> "" ? $this->featured->FldTagCaption(2) : "Yes";
			} else {
				$this->featured->ViewValue = $this->featured->FldTagCaption(1) <> "" ? $this->featured->FldTagCaption(1) : "No";
			}
			$this->featured->ViewCustomAttributes = "";

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

			// img
			$this->img->LinkCustomAttributes = "";
			$this->img->UploadPath = "../uploads/photos";
			if (!ew_Empty($this->img->Upload->DbValue)) {
				$this->img->HrefValue = ew_UploadPathEx(FALSE, $this->img->UploadPath) . $this->img->Upload->DbValue; // Add prefix/suffix
				$this->img->LinkAttrs["target"] = "_blank"; // Add target
				if ($this->Export <> "") $this->img->HrefValue = ew_ConvertFullUrl($this->img->HrefValue);
			} else {
				$this->img->HrefValue = "";
			}
			$this->img->HrefValue2 = $this->img->UploadPath . $this->img->Upload->DbValue;
			$this->img->TooltipValue = "";

			// uid
			$this->uid->LinkCustomAttributes = "";
			$this->uid->HrefValue = "";
			$this->uid->TooltipValue = "";

			// cat
			$this->cat->LinkCustomAttributes = "";
			$this->cat->HrefValue = "";
			$this->cat->TooltipValue = "";

			// sub
			$this->sub->LinkCustomAttributes = "";
			$this->sub->HrefValue = "";
			$this->sub->TooltipValue = "";

			// title
			$this->title->LinkCustomAttributes = "";
			$this->title->HrefValue = "";
			$this->title->TooltipValue = "";

			// descp
			$this->descp->LinkCustomAttributes = "";
			$this->descp->HrefValue = "";
			$this->descp->TooltipValue = "";

			// location
			$this->location->LinkCustomAttributes = "";
			$this->location->HrefValue = "";
			$this->location->TooltipValue = "";

			// datetaken
			$this->datetaken->LinkCustomAttributes = "";
			$this->datetaken->HrefValue = "";
			$this->datetaken->TooltipValue = "";

			// tags
			$this->tags->LinkCustomAttributes = "";
			$this->tags->HrefValue = "";
			$this->tags->TooltipValue = "";

			// views
			$this->views->LinkCustomAttributes = "";
			$this->views->HrefValue = "";
			$this->views->TooltipValue = "";

			// photoby
			$this->photoby->LinkCustomAttributes = "";
			$this->photoby->HrefValue = "";
			$this->photoby->TooltipValue = "";

			// active
			$this->active->LinkCustomAttributes = "";
			$this->active->HrefValue = "";
			$this->active->TooltipValue = "";

			// featured
			$this->featured->LinkCustomAttributes = "";
			$this->featured->HrefValue = "";
			$this->featured->TooltipValue = "";

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
		$item->Body = "<a id=\"emf_photos\" href=\"javascript:void(0);\" class=\"ewExportLink ewEmail\" data-caption=\"" . $Language->Phrase("ExportToEmailText") . "\" onclick=\"ew_EmailDialogShow({lnk:'emf_photos',hdr:ewLanguage.Phrase('ExportToEmail'),f:document.fphotosview,key:" . ew_ArrayToJsonAttr($this->RecKey) . ",sel:false});\">" . $Language->Phrase("ExportToEmail") . "</a>";
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
		$Breadcrumb->Add("list", "<span id=\"ewPageCaption\">" . $PageCaption . "</span>", "photoslist.php", $this->TableVar);
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
if (!isset($photos_view)) $photos_view = new cphotos_view();

// Page init
$photos_view->Page_Init();

// Page main
$photos_view->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$photos_view->Page_Render();
?>
<?php include_once "header.php" ?>
<?php if ($photos->Export == "") { ?>
<script type="text/javascript">

// Page object
var photos_view = new ew_Page("photos_view");
photos_view.PageID = "view"; // Page ID
var EW_PAGE_ID = photos_view.PageID; // For backward compatibility

// Form object
var fphotosview = new ew_Form("fphotosview");

// Form_CustomValidate event
fphotosview.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
fphotosview.ValidateRequired = true;
<?php } else { ?>
fphotosview.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
fphotosview.Lists["x_cat"] = {"LinkField":"x_id","Ajax":true,"AutoFill":false,"DisplayFields":["x_category","","",""],"ParentFields":[],"FilterFields":[],"Options":[]};
fphotosview.Lists["x_sub"] = {"LinkField":"x_id","Ajax":true,"AutoFill":false,"DisplayFields":["x_subcat","","",""],"ParentFields":[],"FilterFields":[],"Options":[]};

// Form object for search
</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<?php } ?>
<?php if ($photos->Export == "") { ?>
<?php $Breadcrumb->Render(); ?>
<?php } ?>
<?php if ($photos->Export == "") { ?>
<div class="ewViewExportOptions">
<?php $photos_view->ExportOptions->Render("body") ?>
<?php if (!$photos_view->ExportOptions->UseDropDownButton) { ?>
</div>
<div class="ewViewOtherOptions">
<?php } ?>
<?php
	foreach ($photos_view->OtherOptions as &$option)
		$option->Render("body");
?>
</div>
<?php } ?>
<?php $photos_view->ShowPageHeader(); ?>
<?php
$photos_view->ShowMessage();
?>
<form name="fphotosview" id="fphotosview" class="ewForm form-horizontal" action="<?php echo ew_CurrentPage() ?>" method="post">
<input type="hidden" name="t" value="photos">
<table cellspacing="0" class="ewGrid"><tr><td>
<table id="tbl_photosview" class="table table-bordered table-striped">
<?php if ($photos->img->Visible) { // img ?>
	<tr id="r_img">
		<td><span id="elh_photos_img"><?php echo $photos->img->FldCaption() ?></span></td>
		<td<?php echo $photos->img->CellAttributes() ?>>
<span id="el_photos_img" class="control-group">
<span>
<?php if ($photos->img->LinkAttributes() <> "") { ?>
<?php if (!empty($photos->img->Upload->DbValue)) { ?>
<a<?php echo $photos->img->LinkAttributes() ?>><img src="<?php echo $photos->img->ViewValue ?>" alt="" style="border: 0;"<?php echo $photos->img->ViewAttributes() ?>></a>
<?php } elseif (!in_array($photos->CurrentAction, array("I", "edit", "gridedit"))) { ?>	
&nbsp;
<?php } ?>
<?php } else { ?>
<?php if (!empty($photos->img->Upload->DbValue)) { ?>
<img src="<?php echo $photos->img->ViewValue ?>" alt="" style="border: 0;"<?php echo $photos->img->ViewAttributes() ?>>
<?php } elseif (!in_array($photos->CurrentAction, array("I", "edit", "gridedit"))) { ?>	
&nbsp;
<?php } ?>
<?php } ?>
</span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($photos->uid->Visible) { // uid ?>
	<tr id="r_uid">
		<td><span id="elh_photos_uid"><?php echo $photos->uid->FldCaption() ?></span></td>
		<td<?php echo $photos->uid->CellAttributes() ?>>
<span id="el_photos_uid" class="control-group">
<span<?php echo $photos->uid->ViewAttributes() ?>>
<?php echo $photos->uid->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($photos->cat->Visible) { // cat ?>
	<tr id="r_cat">
		<td><span id="elh_photos_cat"><?php echo $photos->cat->FldCaption() ?></span></td>
		<td<?php echo $photos->cat->CellAttributes() ?>>
<span id="el_photos_cat" class="control-group">
<span<?php echo $photos->cat->ViewAttributes() ?>>
<?php echo $photos->cat->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($photos->sub->Visible) { // sub ?>
	<tr id="r_sub">
		<td><span id="elh_photos_sub"><?php echo $photos->sub->FldCaption() ?></span></td>
		<td<?php echo $photos->sub->CellAttributes() ?>>
<span id="el_photos_sub" class="control-group">
<span<?php echo $photos->sub->ViewAttributes() ?>>
<?php echo $photos->sub->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($photos->title->Visible) { // title ?>
	<tr id="r_title">
		<td><span id="elh_photos_title"><?php echo $photos->title->FldCaption() ?></span></td>
		<td<?php echo $photos->title->CellAttributes() ?>>
<span id="el_photos_title" class="control-group">
<span<?php echo $photos->title->ViewAttributes() ?>>
<?php echo $photos->title->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($photos->descp->Visible) { // descp ?>
	<tr id="r_descp">
		<td><span id="elh_photos_descp"><?php echo $photos->descp->FldCaption() ?></span></td>
		<td<?php echo $photos->descp->CellAttributes() ?>>
<span id="el_photos_descp" class="control-group">
<span<?php echo $photos->descp->ViewAttributes() ?>>
<?php echo $photos->descp->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($photos->location->Visible) { // location ?>
	<tr id="r_location">
		<td><span id="elh_photos_location"><?php echo $photos->location->FldCaption() ?></span></td>
		<td<?php echo $photos->location->CellAttributes() ?>>
<span id="el_photos_location" class="control-group">
<span<?php echo $photos->location->ViewAttributes() ?>>
<?php echo $photos->location->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($photos->datetaken->Visible) { // datetaken ?>
	<tr id="r_datetaken">
		<td><span id="elh_photos_datetaken"><?php echo $photos->datetaken->FldCaption() ?></span></td>
		<td<?php echo $photos->datetaken->CellAttributes() ?>>
<span id="el_photos_datetaken" class="control-group">
<span<?php echo $photos->datetaken->ViewAttributes() ?>>
<?php echo $photos->datetaken->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($photos->tags->Visible) { // tags ?>
	<tr id="r_tags">
		<td><span id="elh_photos_tags"><?php echo $photos->tags->FldCaption() ?></span></td>
		<td<?php echo $photos->tags->CellAttributes() ?>>
<span id="el_photos_tags" class="control-group">
<span<?php echo $photos->tags->ViewAttributes() ?>>
<?php echo $photos->tags->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($photos->views->Visible) { // views ?>
	<tr id="r_views">
		<td><span id="elh_photos_views"><?php echo $photos->views->FldCaption() ?></span></td>
		<td<?php echo $photos->views->CellAttributes() ?>>
<span id="el_photos_views" class="control-group">
<span<?php echo $photos->views->ViewAttributes() ?>>
<?php echo $photos->views->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($photos->photoby->Visible) { // photoby ?>
	<tr id="r_photoby">
		<td><span id="elh_photos_photoby"><?php echo $photos->photoby->FldCaption() ?></span></td>
		<td<?php echo $photos->photoby->CellAttributes() ?>>
<span id="el_photos_photoby" class="control-group">
<span<?php echo $photos->photoby->ViewAttributes() ?>>
<?php echo $photos->photoby->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($photos->active->Visible) { // active ?>
	<tr id="r_active">
		<td><span id="elh_photos_active"><?php echo $photos->active->FldCaption() ?></span></td>
		<td<?php echo $photos->active->CellAttributes() ?>>
<span id="el_photos_active" class="control-group">
<span<?php echo $photos->active->ViewAttributes() ?>>
<?php echo $photos->active->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($photos->featured->Visible) { // featured ?>
	<tr id="r_featured">
		<td><span id="elh_photos_featured"><?php echo $photos->featured->FldCaption() ?></span></td>
		<td<?php echo $photos->featured->CellAttributes() ?>>
<span id="el_photos_featured" class="control-group">
<span<?php echo $photos->featured->ViewAttributes() ?>>
<?php echo $photos->featured->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($photos->datep->Visible) { // datep ?>
	<tr id="r_datep">
		<td><span id="elh_photos_datep"><?php echo $photos->datep->FldCaption() ?></span></td>
		<td<?php echo $photos->datep->CellAttributes() ?>>
<span id="el_photos_datep" class="control-group">
<span<?php echo $photos->datep->ViewAttributes() ?>>
<?php echo $photos->datep->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
</table>
</td></tr></table>
<?php if ($photos->Export == "") { ?>
<table class="ewPager">
<tr><td>
<?php if (!isset($photos_view->Pager)) $photos_view->Pager = new cNumericPager($photos_view->StartRec, $photos_view->DisplayRecs, $photos_view->TotalRecs, $photos_view->RecRange) ?>
<?php if ($photos_view->Pager->RecordCount > 0) { ?>
<table cellspacing="0" class="ewStdTable"><tbody><tr><td>
<div class="pagination"><ul>
	<?php if ($photos_view->Pager->FirstButton->Enabled) { ?>
	<li><a href="<?php echo $photos_view->PageUrl() ?>start=<?php echo $photos_view->Pager->FirstButton->Start ?>"><?php echo $Language->Phrase("PagerFirst") ?></a></li>
	<?php } ?>
	<?php if ($photos_view->Pager->PrevButton->Enabled) { ?>
	<li><a href="<?php echo $photos_view->PageUrl() ?>start=<?php echo $photos_view->Pager->PrevButton->Start ?>"><?php echo $Language->Phrase("PagerPrevious") ?></a></li>
	<?php } ?>
	<?php foreach ($photos_view->Pager->Items as $PagerItem) { ?>
		<li<?php if (!$PagerItem->Enabled) { echo " class=\" active\""; } ?>><a href="<?php if ($PagerItem->Enabled) { echo $photos_view->PageUrl() . "start=" . $PagerItem->Start; } else { echo "#"; } ?>"><?php echo $PagerItem->Text ?></a></li>
	<?php } ?>
	<?php if ($photos_view->Pager->NextButton->Enabled) { ?>
	<li><a href="<?php echo $photos_view->PageUrl() ?>start=<?php echo $photos_view->Pager->NextButton->Start ?>"><?php echo $Language->Phrase("PagerNext") ?></a></li>
	<?php } ?>
	<?php if ($photos_view->Pager->LastButton->Enabled) { ?>
	<li><a href="<?php echo $photos_view->PageUrl() ?>start=<?php echo $photos_view->Pager->LastButton->Start ?>"><?php echo $Language->Phrase("PagerLast") ?></a></li>
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
fphotosview.Init();
</script>
<?php
$photos_view->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<?php if ($photos->Export == "") { ?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php } ?>
<?php include_once "footer.php" ?>
<?php
$photos_view->Page_Terminate();
?>
