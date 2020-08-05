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

$layout_view = NULL; // Initialize page object first

class clayout_view extends clayout {

	// Page ID
	var $PageID = 'view';

	// Project ID
	var $ProjectID = "{D9B361E7-B2C1-4293-B9B3-B581986A15CC}";

	// Table name
	var $TableName = 'layout';

	// Page object name
	var $PageObjName = 'layout_view';

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
			define("EW_TABLE_NAME", 'layout', TRUE);

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
						$this->Page_Terminate("layoutlist.php"); // Return to list page
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
						$sReturnUrl = "layoutlist.php"; // No matching record, return to list
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
			$sReturnUrl = "layoutlist.php"; // Not page request, return to list
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
		// logo
		// url
		// meta-title
		// meta-keywords
		// meta-descp
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
		// slide-box
		// custom-css
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
		// base-r
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

			// id
			$this->id->LinkCustomAttributes = "";
			$this->id->HrefValue = "";
			$this->id->TooltipValue = "";

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

			// home-text1
			$this->home2Dtext1->LinkCustomAttributes = "";
			$this->home2Dtext1->HrefValue = "";
			$this->home2Dtext1->TooltipValue = "";

			// home-caption2
			$this->home2Dcaption2->LinkCustomAttributes = "";
			$this->home2Dcaption2->HrefValue = "";
			$this->home2Dcaption2->TooltipValue = "";

			// home-text2
			$this->home2Dtext2->LinkCustomAttributes = "";
			$this->home2Dtext2->HrefValue = "";
			$this->home2Dtext2->TooltipValue = "";

			// home-caption3
			$this->home2Dcaption3->LinkCustomAttributes = "";
			$this->home2Dcaption3->HrefValue = "";
			$this->home2Dcaption3->TooltipValue = "";

			// home-text3
			$this->home2Dtext3->LinkCustomAttributes = "";
			$this->home2Dtext3->HrefValue = "";
			$this->home2Dtext3->TooltipValue = "";

			// home-caption4
			$this->home2Dcaption4->LinkCustomAttributes = "";
			$this->home2Dcaption4->HrefValue = "";
			$this->home2Dcaption4->TooltipValue = "";

			// home-text4
			$this->home2Dtext4->LinkCustomAttributes = "";
			$this->home2Dtext4->HrefValue = "";
			$this->home2Dtext4->TooltipValue = "";

			// home-caption5
			$this->home2Dcaption5->LinkCustomAttributes = "";
			$this->home2Dcaption5->HrefValue = "";
			$this->home2Dcaption5->TooltipValue = "";

			// home-text5
			$this->home2Dtext5->LinkCustomAttributes = "";
			$this->home2Dtext5->HrefValue = "";
			$this->home2Dtext5->TooltipValue = "";

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

			// contact-email
			$this->contact2Demail->LinkCustomAttributes = "";
			$this->contact2Demail->HrefValue = "";
			$this->contact2Demail->TooltipValue = "";

			// contact-text1
			$this->contact2Dtext1->LinkCustomAttributes = "";
			$this->contact2Dtext1->HrefValue = "";
			$this->contact2Dtext1->TooltipValue = "";

			// contact-text2
			$this->contact2Dtext2->LinkCustomAttributes = "";
			$this->contact2Dtext2->HrefValue = "";
			$this->contact2Dtext2->TooltipValue = "";

			// contact-text3
			$this->contact2Dtext3->LinkCustomAttributes = "";
			$this->contact2Dtext3->HrefValue = "";
			$this->contact2Dtext3->TooltipValue = "";

			// contact-text4
			$this->contact2Dtext4->LinkCustomAttributes = "";
			$this->contact2Dtext4->HrefValue = "";
			$this->contact2Dtext4->TooltipValue = "";
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
		$item->Body = "<a id=\"emf_layout\" href=\"javascript:void(0);\" class=\"ewExportLink ewEmail\" data-caption=\"" . $Language->Phrase("ExportToEmailText") . "\" onclick=\"ew_EmailDialogShow({lnk:'emf_layout',hdr:ewLanguage.Phrase('ExportToEmail'),f:document.flayoutview,key:" . ew_ArrayToJsonAttr($this->RecKey) . ",sel:false});\">" . $Language->Phrase("ExportToEmail") . "</a>";
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
		$Breadcrumb->Add("list", "<span id=\"ewPageCaption\">" . $PageCaption . "</span>", "layoutlist.php", $this->TableVar);
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
if (!isset($layout_view)) $layout_view = new clayout_view();

// Page init
$layout_view->Page_Init();

// Page main
$layout_view->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$layout_view->Page_Render();
?>
<?php include_once "header.php" ?>
<?php if ($layout->Export == "") { ?>
<script type="text/javascript">

// Page object
var layout_view = new ew_Page("layout_view");
layout_view.PageID = "view"; // Page ID
var EW_PAGE_ID = layout_view.PageID; // For backward compatibility

// Form object
var flayoutview = new ew_Form("flayoutview");

// Form_CustomValidate event
flayoutview.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
flayoutview.ValidateRequired = true;
<?php } else { ?>
flayoutview.ValidateRequired = false; 
<?php } ?>

// Multi-Page properties
flayoutview.MultiPage = new ew_MultiPage("flayoutview",
	[["x_id",1],["x_top2Dl",1],["x_top2Dr",1],["x_head2Dl",1],["x_head2Dr",1],["x_slide1",1],["x_slide2",1],["x_slide3",1],["x_slide4",1],["x_slide5",1],["x_slide6",1],["x_home2Dcaption1",3],["x_home2Dtext1",3],["x_home2Dcaption2",3],["x_home2Dtext2",3],["x_home2Dcaption3",3],["x_home2Dtext3",3],["x_home2Dcaption4",3],["x_home2Dtext4",3],["x_home2Dcaption5",3],["x_home2Dtext5",3],["x_home2Dcaption6",3],["x_home2Dtext6",3],["x_footer2D1",4],["x_footer2D2",4],["x_footer2D3",4],["x_footer2D4",4],["x_contact2Demail",5],["x_contact2Dtext1",5],["x_contact2Dtext2",5],["x_contact2Dtext3",5],["x_contact2Dtext4",5]]
);

// Dynamic selection lists
// Form object for search

</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<?php } ?>
<?php if ($layout->Export == "") { ?>
<?php $Breadcrumb->Render(); ?>
<?php } ?>
<?php if ($layout->Export == "") { ?>
<div class="ewViewExportOptions">
<?php $layout_view->ExportOptions->Render("body") ?>
<?php if (!$layout_view->ExportOptions->UseDropDownButton) { ?>
</div>
<div class="ewViewOtherOptions">
<?php } ?>
<?php
	foreach ($layout_view->OtherOptions as &$option)
		$option->Render("body");
?>
</div>
<?php } ?>
<?php $layout_view->ShowPageHeader(); ?>
<?php
$layout_view->ShowMessage();
?>
<form name="flayoutview" id="flayoutview" class="ewForm form-horizontal" action="<?php echo ew_CurrentPage() ?>" method="post">
<input type="hidden" name="t" value="layout">
<?php if ($layout->Export == "") { ?>
<table class="ewStdTable"><tbody><tr><td>
<div class="tabbable" id="layout_view">
	<ul class="nav nav-tabs">
		<li class="active"><a href="#tab_layout1" data-toggle="tab"><?php echo $layout->PageCaption(1) ?></a></li>
		<li style="display: none"><a href="#tab_layout2" data-toggle="tab"></a></li>
		<li><a href="#tab_layout3" data-toggle="tab"><?php echo $layout->PageCaption(3) ?></a></li>
		<li><a href="#tab_layout4" data-toggle="tab"><?php echo $layout->PageCaption(4) ?></a></li>
		<li><a href="#tab_layout5" data-toggle="tab"><?php echo $layout->PageCaption(5) ?></a></li>
	</ul>
	<div class="tab-content">
<?php } ?>
		<div class="tab-pane active" id="tab_layout1">
<table cellspacing="0" class="ewGrid" style="width: 100%"><tr><td>
<table id="tbl_layoutview1" class="table table-bordered table-striped">
<?php if ($layout->id->Visible) { // id ?>
	<tr id="r_id">
		<td><span id="elh_layout_id"><?php echo $layout->id->FldCaption() ?></span></td>
		<td<?php echo $layout->id->CellAttributes() ?>>
<span id="el_layout_id" class="control-group">
<span>
<?php if (!ew_EmptyStr($layout->id->ViewValue)) { ?><img src="<?php echo $layout->id->ViewValue ?>" alt="" style="border: 0;"<?php echo $layout->id->ViewAttributes() ?>><?php } ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($layout->top2Dl->Visible) { // top-l ?>
	<tr id="r_top2Dl">
		<td><span id="elh_layout_top2Dl"><?php echo $layout->top2Dl->FldCaption() ?></span></td>
		<td<?php echo $layout->top2Dl->CellAttributes() ?>>
<span id="el_layout_top2Dl" class="control-group">
<span<?php echo $layout->top2Dl->ViewAttributes() ?>>
<?php echo $layout->top2Dl->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($layout->top2Dr->Visible) { // top-r ?>
	<tr id="r_top2Dr">
		<td><span id="elh_layout_top2Dr"><?php echo $layout->top2Dr->FldCaption() ?></span></td>
		<td<?php echo $layout->top2Dr->CellAttributes() ?>>
<span id="el_layout_top2Dr" class="control-group">
<span<?php echo $layout->top2Dr->ViewAttributes() ?>>
<?php echo $layout->top2Dr->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($layout->head2Dl->Visible) { // head-l ?>
	<tr id="r_head2Dl">
		<td><span id="elh_layout_head2Dl"><?php echo $layout->head2Dl->FldCaption() ?></span></td>
		<td<?php echo $layout->head2Dl->CellAttributes() ?>>
<span id="el_layout_head2Dl" class="control-group">
<span<?php echo $layout->head2Dl->ViewAttributes() ?>>
<?php echo $layout->head2Dl->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($layout->head2Dr->Visible) { // head-r ?>
	<tr id="r_head2Dr">
		<td><span id="elh_layout_head2Dr"><?php echo $layout->head2Dr->FldCaption() ?></span></td>
		<td<?php echo $layout->head2Dr->CellAttributes() ?>>
<span id="el_layout_head2Dr" class="control-group">
<span<?php echo $layout->head2Dr->ViewAttributes() ?>>
<?php echo $layout->head2Dr->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($layout->slide1->Visible) { // slide1 ?>
	<tr id="r_slide1">
		<td><span id="elh_layout_slide1"><?php echo $layout->slide1->FldCaption() ?></span></td>
		<td<?php echo $layout->slide1->CellAttributes() ?>>
<span id="el_layout_slide1" class="control-group">
<span<?php echo $layout->slide1->ViewAttributes() ?>>
<?php if ($layout->slide1->LinkAttributes() <> "") { ?>
<?php if (!empty($layout->slide1->Upload->DbValue)) { ?>
<a<?php echo $layout->slide1->LinkAttributes() ?>><?php echo $layout->slide1->ViewValue ?></a>
<?php } elseif (!in_array($layout->CurrentAction, array("I", "edit", "gridedit"))) { ?>	
&nbsp;
<?php } ?>
<?php } else { ?>
<?php if (!empty($layout->slide1->Upload->DbValue)) { ?>
<?php echo $layout->slide1->ViewValue ?>
<?php } elseif (!in_array($layout->CurrentAction, array("I", "edit", "gridedit"))) { ?>	
&nbsp;
<?php } ?>
<?php } ?>
</span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($layout->slide2->Visible) { // slide2 ?>
	<tr id="r_slide2">
		<td><span id="elh_layout_slide2"><?php echo $layout->slide2->FldCaption() ?></span></td>
		<td<?php echo $layout->slide2->CellAttributes() ?>>
<span id="el_layout_slide2" class="control-group">
<span<?php echo $layout->slide2->ViewAttributes() ?>>
<?php if ($layout->slide2->LinkAttributes() <> "") { ?>
<?php if (!empty($layout->slide2->Upload->DbValue)) { ?>
<a<?php echo $layout->slide2->LinkAttributes() ?>><?php echo $layout->slide2->ViewValue ?></a>
<?php } elseif (!in_array($layout->CurrentAction, array("I", "edit", "gridedit"))) { ?>	
&nbsp;
<?php } ?>
<?php } else { ?>
<?php if (!empty($layout->slide2->Upload->DbValue)) { ?>
<?php echo $layout->slide2->ViewValue ?>
<?php } elseif (!in_array($layout->CurrentAction, array("I", "edit", "gridedit"))) { ?>	
&nbsp;
<?php } ?>
<?php } ?>
</span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($layout->slide3->Visible) { // slide3 ?>
	<tr id="r_slide3">
		<td><span id="elh_layout_slide3"><?php echo $layout->slide3->FldCaption() ?></span></td>
		<td<?php echo $layout->slide3->CellAttributes() ?>>
<span id="el_layout_slide3" class="control-group">
<span<?php echo $layout->slide3->ViewAttributes() ?>>
<?php if ($layout->slide3->LinkAttributes() <> "") { ?>
<?php if (!empty($layout->slide3->Upload->DbValue)) { ?>
<a<?php echo $layout->slide3->LinkAttributes() ?>><?php echo $layout->slide3->ViewValue ?></a>
<?php } elseif (!in_array($layout->CurrentAction, array("I", "edit", "gridedit"))) { ?>	
&nbsp;
<?php } ?>
<?php } else { ?>
<?php if (!empty($layout->slide3->Upload->DbValue)) { ?>
<?php echo $layout->slide3->ViewValue ?>
<?php } elseif (!in_array($layout->CurrentAction, array("I", "edit", "gridedit"))) { ?>	
&nbsp;
<?php } ?>
<?php } ?>
</span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($layout->slide4->Visible) { // slide4 ?>
	<tr id="r_slide4">
		<td><span id="elh_layout_slide4"><?php echo $layout->slide4->FldCaption() ?></span></td>
		<td<?php echo $layout->slide4->CellAttributes() ?>>
<span id="el_layout_slide4" class="control-group">
<span<?php echo $layout->slide4->ViewAttributes() ?>>
<?php if ($layout->slide4->LinkAttributes() <> "") { ?>
<?php if (!empty($layout->slide4->Upload->DbValue)) { ?>
<a<?php echo $layout->slide4->LinkAttributes() ?>><?php echo $layout->slide4->ViewValue ?></a>
<?php } elseif (!in_array($layout->CurrentAction, array("I", "edit", "gridedit"))) { ?>	
&nbsp;
<?php } ?>
<?php } else { ?>
<?php if (!empty($layout->slide4->Upload->DbValue)) { ?>
<?php echo $layout->slide4->ViewValue ?>
<?php } elseif (!in_array($layout->CurrentAction, array("I", "edit", "gridedit"))) { ?>	
&nbsp;
<?php } ?>
<?php } ?>
</span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($layout->slide5->Visible) { // slide5 ?>
	<tr id="r_slide5">
		<td><span id="elh_layout_slide5"><?php echo $layout->slide5->FldCaption() ?></span></td>
		<td<?php echo $layout->slide5->CellAttributes() ?>>
<span id="el_layout_slide5" class="control-group">
<span<?php echo $layout->slide5->ViewAttributes() ?>>
<?php if ($layout->slide5->LinkAttributes() <> "") { ?>
<?php if (!empty($layout->slide5->Upload->DbValue)) { ?>
<a<?php echo $layout->slide5->LinkAttributes() ?>><?php echo $layout->slide5->ViewValue ?></a>
<?php } elseif (!in_array($layout->CurrentAction, array("I", "edit", "gridedit"))) { ?>	
&nbsp;
<?php } ?>
<?php } else { ?>
<?php if (!empty($layout->slide5->Upload->DbValue)) { ?>
<?php echo $layout->slide5->ViewValue ?>
<?php } elseif (!in_array($layout->CurrentAction, array("I", "edit", "gridedit"))) { ?>	
&nbsp;
<?php } ?>
<?php } ?>
</span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($layout->slide6->Visible) { // slide6 ?>
	<tr id="r_slide6">
		<td><span id="elh_layout_slide6"><?php echo $layout->slide6->FldCaption() ?></span></td>
		<td<?php echo $layout->slide6->CellAttributes() ?>>
<span id="el_layout_slide6" class="control-group">
<span<?php echo $layout->slide6->ViewAttributes() ?>>
<?php if ($layout->slide6->LinkAttributes() <> "") { ?>
<?php if (!empty($layout->slide6->Upload->DbValue)) { ?>
<a<?php echo $layout->slide6->LinkAttributes() ?>><?php echo $layout->slide6->ViewValue ?></a>
<?php } elseif (!in_array($layout->CurrentAction, array("I", "edit", "gridedit"))) { ?>	
&nbsp;
<?php } ?>
<?php } else { ?>
<?php if (!empty($layout->slide6->Upload->DbValue)) { ?>
<?php echo $layout->slide6->ViewValue ?>
<?php } elseif (!in_array($layout->CurrentAction, array("I", "edit", "gridedit"))) { ?>	
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
		<div class="tab-pane" id="tab_layout2">
		</div>
		<div class="tab-pane" id="tab_layout3">
<table cellspacing="0" class="ewGrid" style="width: 100%"><tr><td>
<table id="tbl_layoutview3" class="table table-bordered table-striped">
<?php if ($layout->home2Dcaption1->Visible) { // home-caption1 ?>
	<tr id="r_home2Dcaption1">
		<td><span id="elh_layout_home2Dcaption1"><?php echo $layout->home2Dcaption1->FldCaption() ?></span></td>
		<td<?php echo $layout->home2Dcaption1->CellAttributes() ?>>
<span id="el_layout_home2Dcaption1" class="control-group">
<span<?php echo $layout->home2Dcaption1->ViewAttributes() ?>>
<?php echo $layout->home2Dcaption1->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($layout->home2Dtext1->Visible) { // home-text1 ?>
	<tr id="r_home2Dtext1">
		<td><span id="elh_layout_home2Dtext1"><?php echo $layout->home2Dtext1->FldCaption() ?></span></td>
		<td<?php echo $layout->home2Dtext1->CellAttributes() ?>>
<span id="el_layout_home2Dtext1" class="control-group">
<span<?php echo $layout->home2Dtext1->ViewAttributes() ?>>
<?php echo $layout->home2Dtext1->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($layout->home2Dcaption2->Visible) { // home-caption2 ?>
	<tr id="r_home2Dcaption2">
		<td><span id="elh_layout_home2Dcaption2"><?php echo $layout->home2Dcaption2->FldCaption() ?></span></td>
		<td<?php echo $layout->home2Dcaption2->CellAttributes() ?>>
<span id="el_layout_home2Dcaption2" class="control-group">
<span<?php echo $layout->home2Dcaption2->ViewAttributes() ?>>
<?php echo $layout->home2Dcaption2->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($layout->home2Dtext2->Visible) { // home-text2 ?>
	<tr id="r_home2Dtext2">
		<td><span id="elh_layout_home2Dtext2"><?php echo $layout->home2Dtext2->FldCaption() ?></span></td>
		<td<?php echo $layout->home2Dtext2->CellAttributes() ?>>
<span id="el_layout_home2Dtext2" class="control-group">
<span<?php echo $layout->home2Dtext2->ViewAttributes() ?>>
<?php echo $layout->home2Dtext2->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($layout->home2Dcaption3->Visible) { // home-caption3 ?>
	<tr id="r_home2Dcaption3">
		<td><span id="elh_layout_home2Dcaption3"><?php echo $layout->home2Dcaption3->FldCaption() ?></span></td>
		<td<?php echo $layout->home2Dcaption3->CellAttributes() ?>>
<span id="el_layout_home2Dcaption3" class="control-group">
<span<?php echo $layout->home2Dcaption3->ViewAttributes() ?>>
<?php echo $layout->home2Dcaption3->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($layout->home2Dtext3->Visible) { // home-text3 ?>
	<tr id="r_home2Dtext3">
		<td><span id="elh_layout_home2Dtext3"><?php echo $layout->home2Dtext3->FldCaption() ?></span></td>
		<td<?php echo $layout->home2Dtext3->CellAttributes() ?>>
<span id="el_layout_home2Dtext3" class="control-group">
<span<?php echo $layout->home2Dtext3->ViewAttributes() ?>>
<?php echo $layout->home2Dtext3->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($layout->home2Dcaption4->Visible) { // home-caption4 ?>
	<tr id="r_home2Dcaption4">
		<td><span id="elh_layout_home2Dcaption4"><?php echo $layout->home2Dcaption4->FldCaption() ?></span></td>
		<td<?php echo $layout->home2Dcaption4->CellAttributes() ?>>
<span id="el_layout_home2Dcaption4" class="control-group">
<span<?php echo $layout->home2Dcaption4->ViewAttributes() ?>>
<?php echo $layout->home2Dcaption4->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($layout->home2Dtext4->Visible) { // home-text4 ?>
	<tr id="r_home2Dtext4">
		<td><span id="elh_layout_home2Dtext4"><?php echo $layout->home2Dtext4->FldCaption() ?></span></td>
		<td<?php echo $layout->home2Dtext4->CellAttributes() ?>>
<span id="el_layout_home2Dtext4" class="control-group">
<span<?php echo $layout->home2Dtext4->ViewAttributes() ?>>
<?php echo $layout->home2Dtext4->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($layout->home2Dcaption5->Visible) { // home-caption5 ?>
	<tr id="r_home2Dcaption5">
		<td><span id="elh_layout_home2Dcaption5"><?php echo $layout->home2Dcaption5->FldCaption() ?></span></td>
		<td<?php echo $layout->home2Dcaption5->CellAttributes() ?>>
<span id="el_layout_home2Dcaption5" class="control-group">
<span<?php echo $layout->home2Dcaption5->ViewAttributes() ?>>
<?php echo $layout->home2Dcaption5->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($layout->home2Dtext5->Visible) { // home-text5 ?>
	<tr id="r_home2Dtext5">
		<td><span id="elh_layout_home2Dtext5"><?php echo $layout->home2Dtext5->FldCaption() ?></span></td>
		<td<?php echo $layout->home2Dtext5->CellAttributes() ?>>
<span id="el_layout_home2Dtext5" class="control-group">
<span<?php echo $layout->home2Dtext5->ViewAttributes() ?>>
<?php echo $layout->home2Dtext5->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($layout->home2Dcaption6->Visible) { // home-caption6 ?>
	<tr id="r_home2Dcaption6">
		<td><span id="elh_layout_home2Dcaption6"><?php echo $layout->home2Dcaption6->FldCaption() ?></span></td>
		<td<?php echo $layout->home2Dcaption6->CellAttributes() ?>>
<span id="el_layout_home2Dcaption6" class="control-group">
<span<?php echo $layout->home2Dcaption6->ViewAttributes() ?>>
<?php echo $layout->home2Dcaption6->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($layout->home2Dtext6->Visible) { // home-text6 ?>
	<tr id="r_home2Dtext6">
		<td><span id="elh_layout_home2Dtext6"><?php echo $layout->home2Dtext6->FldCaption() ?></span></td>
		<td<?php echo $layout->home2Dtext6->CellAttributes() ?>>
<span id="el_layout_home2Dtext6" class="control-group">
<span<?php echo $layout->home2Dtext6->ViewAttributes() ?>>
<?php echo $layout->home2Dtext6->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
</table>
</td></tr></table>
		</div>
		<div class="tab-pane" id="tab_layout4">
<table cellspacing="0" class="ewGrid" style="width: 100%"><tr><td>
<table id="tbl_layoutview4" class="table table-bordered table-striped">
<?php if ($layout->footer2D1->Visible) { // footer-1 ?>
	<tr id="r_footer2D1">
		<td><span id="elh_layout_footer2D1"><?php echo $layout->footer2D1->FldCaption() ?></span></td>
		<td<?php echo $layout->footer2D1->CellAttributes() ?>>
<span id="el_layout_footer2D1" class="control-group">
<span<?php echo $layout->footer2D1->ViewAttributes() ?>>
<?php echo $layout->footer2D1->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($layout->footer2D2->Visible) { // footer-2 ?>
	<tr id="r_footer2D2">
		<td><span id="elh_layout_footer2D2"><?php echo $layout->footer2D2->FldCaption() ?></span></td>
		<td<?php echo $layout->footer2D2->CellAttributes() ?>>
<span id="el_layout_footer2D2" class="control-group">
<span<?php echo $layout->footer2D2->ViewAttributes() ?>>
<?php echo $layout->footer2D2->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($layout->footer2D3->Visible) { // footer-3 ?>
	<tr id="r_footer2D3">
		<td><span id="elh_layout_footer2D3"><?php echo $layout->footer2D3->FldCaption() ?></span></td>
		<td<?php echo $layout->footer2D3->CellAttributes() ?>>
<span id="el_layout_footer2D3" class="control-group">
<span<?php echo $layout->footer2D3->ViewAttributes() ?>>
<?php echo $layout->footer2D3->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($layout->footer2D4->Visible) { // footer-4 ?>
	<tr id="r_footer2D4">
		<td><span id="elh_layout_footer2D4"><?php echo $layout->footer2D4->FldCaption() ?></span></td>
		<td<?php echo $layout->footer2D4->CellAttributes() ?>>
<span id="el_layout_footer2D4" class="control-group">
<span<?php echo $layout->footer2D4->ViewAttributes() ?>>
<?php echo $layout->footer2D4->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
</table>
</td></tr></table>
		</div>
		<div class="tab-pane" id="tab_layout5">
<table cellspacing="0" class="ewGrid" style="width: 100%"><tr><td>
<table id="tbl_layoutview5" class="table table-bordered table-striped">
<?php if ($layout->contact2Demail->Visible) { // contact-email ?>
	<tr id="r_contact2Demail">
		<td><span id="elh_layout_contact2Demail"><?php echo $layout->contact2Demail->FldCaption() ?></span></td>
		<td<?php echo $layout->contact2Demail->CellAttributes() ?>>
<span id="el_layout_contact2Demail" class="control-group">
<span<?php echo $layout->contact2Demail->ViewAttributes() ?>>
<?php echo $layout->contact2Demail->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($layout->contact2Dtext1->Visible) { // contact-text1 ?>
	<tr id="r_contact2Dtext1">
		<td><span id="elh_layout_contact2Dtext1"><?php echo $layout->contact2Dtext1->FldCaption() ?></span></td>
		<td<?php echo $layout->contact2Dtext1->CellAttributes() ?>>
<span id="el_layout_contact2Dtext1" class="control-group">
<span<?php echo $layout->contact2Dtext1->ViewAttributes() ?>>
<?php echo $layout->contact2Dtext1->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($layout->contact2Dtext2->Visible) { // contact-text2 ?>
	<tr id="r_contact2Dtext2">
		<td><span id="elh_layout_contact2Dtext2"><?php echo $layout->contact2Dtext2->FldCaption() ?></span></td>
		<td<?php echo $layout->contact2Dtext2->CellAttributes() ?>>
<span id="el_layout_contact2Dtext2" class="control-group">
<span<?php echo $layout->contact2Dtext2->ViewAttributes() ?>>
<?php echo $layout->contact2Dtext2->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($layout->contact2Dtext3->Visible) { // contact-text3 ?>
	<tr id="r_contact2Dtext3">
		<td><span id="elh_layout_contact2Dtext3"><?php echo $layout->contact2Dtext3->FldCaption() ?></span></td>
		<td<?php echo $layout->contact2Dtext3->CellAttributes() ?>>
<span id="el_layout_contact2Dtext3" class="control-group">
<span<?php echo $layout->contact2Dtext3->ViewAttributes() ?>>
<?php echo $layout->contact2Dtext3->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($layout->contact2Dtext4->Visible) { // contact-text4 ?>
	<tr id="r_contact2Dtext4">
		<td><span id="elh_layout_contact2Dtext4"><?php echo $layout->contact2Dtext4->FldCaption() ?></span></td>
		<td<?php echo $layout->contact2Dtext4->CellAttributes() ?>>
<span id="el_layout_contact2Dtext4" class="control-group">
<span<?php echo $layout->contact2Dtext4->ViewAttributes() ?>>
<?php echo $layout->contact2Dtext4->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
</table>
</td></tr></table>
		</div>
<?php if ($layout->Export == "") { ?>
	</div>
</div>
</td></tr></tbody></table>
<?php } ?>
<?php if ($layout->Export == "") { ?>
<table class="ewPager">
<tr><td>
<?php if (!isset($layout_view->Pager)) $layout_view->Pager = new cNumericPager($layout_view->StartRec, $layout_view->DisplayRecs, $layout_view->TotalRecs, $layout_view->RecRange) ?>
<?php if ($layout_view->Pager->RecordCount > 0) { ?>
<table cellspacing="0" class="ewStdTable"><tbody><tr><td>
<div class="pagination"><ul>
	<?php if ($layout_view->Pager->FirstButton->Enabled) { ?>
	<li><a href="<?php echo $layout_view->PageUrl() ?>start=<?php echo $layout_view->Pager->FirstButton->Start ?>"><?php echo $Language->Phrase("PagerFirst") ?></a></li>
	<?php } ?>
	<?php if ($layout_view->Pager->PrevButton->Enabled) { ?>
	<li><a href="<?php echo $layout_view->PageUrl() ?>start=<?php echo $layout_view->Pager->PrevButton->Start ?>"><?php echo $Language->Phrase("PagerPrevious") ?></a></li>
	<?php } ?>
	<?php foreach ($layout_view->Pager->Items as $PagerItem) { ?>
		<li<?php if (!$PagerItem->Enabled) { echo " class=\" active\""; } ?>><a href="<?php if ($PagerItem->Enabled) { echo $layout_view->PageUrl() . "start=" . $PagerItem->Start; } else { echo "#"; } ?>"><?php echo $PagerItem->Text ?></a></li>
	<?php } ?>
	<?php if ($layout_view->Pager->NextButton->Enabled) { ?>
	<li><a href="<?php echo $layout_view->PageUrl() ?>start=<?php echo $layout_view->Pager->NextButton->Start ?>"><?php echo $Language->Phrase("PagerNext") ?></a></li>
	<?php } ?>
	<?php if ($layout_view->Pager->LastButton->Enabled) { ?>
	<li><a href="<?php echo $layout_view->PageUrl() ?>start=<?php echo $layout_view->Pager->LastButton->Start ?>"><?php echo $Language->Phrase("PagerLast") ?></a></li>
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
flayoutview.Init();
</script>
<?php
$layout_view->ShowPageFooter();
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
$layout_view->Page_Terminate();
?>
