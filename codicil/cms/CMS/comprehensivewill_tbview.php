<?php
if (session_id() == "") session_start(); // Initialize Session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg10.php" ?>
<?php include_once "ewmysql10.php" ?>
<?php include_once "phpfn10.php" ?>
<?php include_once "comprehensivewill_tbinfo.php" ?>
<?php include_once "adminusersinfo.php" ?>
<?php include_once "userfn10.php" ?>
<?php

//
// Page class
//

$comprehensivewill_tb_view = NULL; // Initialize page object first

class ccomprehensivewill_tb_view extends ccomprehensivewill_tb {

	// Page ID
	var $PageID = 'view';

	// Project ID
	var $ProjectID = "{D9B361E7-B2C1-4293-B9B3-B581986A15CC}";

	// Table name
	var $TableName = 'comprehensivewill_tb';

	// Page object name
	var $PageObjName = 'comprehensivewill_tb_view';

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
			define("EW_TABLE_NAME", 'comprehensivewill_tb', TRUE);

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
						$this->Page_Terminate("comprehensivewill_tblist.php"); // Return to list page
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
						$sReturnUrl = "comprehensivewill_tblist.php"; // No matching record, return to list
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
			$sReturnUrl = "comprehensivewill_tblist.php"; // Not page request, return to list
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

			// id
			$this->id->LinkCustomAttributes = "";
			$this->id->HrefValue = "";
			$this->id->TooltipValue = "";

			// uid
			$this->uid->LinkCustomAttributes = "";
			$this->uid->HrefValue = "";
			$this->uid->TooltipValue = "";

			// willtype
			$this->willtype->LinkCustomAttributes = "";
			$this->willtype->HrefValue = "";
			$this->willtype->TooltipValue = "";

			// fullname
			$this->fullname->LinkCustomAttributes = "";
			$this->fullname->HrefValue = "";
			$this->fullname->TooltipValue = "";

			// address
			$this->address->LinkCustomAttributes = "";
			$this->address->HrefValue = "";
			$this->address->TooltipValue = "";

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

			// employer
			$this->employer->LinkCustomAttributes = "";
			$this->employer->HrefValue = "";
			$this->employer->TooltipValue = "";

			// employerphone
			$this->employerphone->LinkCustomAttributes = "";
			$this->employerphone->HrefValue = "";
			$this->employerphone->TooltipValue = "";

			// employeraddr
			$this->employeraddr->LinkCustomAttributes = "";
			$this->employeraddr->HrefValue = "";
			$this->employeraddr->TooltipValue = "";

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

			// spaddr
			$this->spaddr->LinkCustomAttributes = "";
			$this->spaddr->HrefValue = "";
			$this->spaddr->TooltipValue = "";

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
		$item->Body = "<a id=\"emf_comprehensivewill_tb\" href=\"javascript:void(0);\" class=\"ewExportLink ewEmail\" data-caption=\"" . $Language->Phrase("ExportToEmailText") . "\" onclick=\"ew_EmailDialogShow({lnk:'emf_comprehensivewill_tb',hdr:ewLanguage.Phrase('ExportToEmail'),f:document.fcomprehensivewill_tbview,key:" . ew_ArrayToJsonAttr($this->RecKey) . ",sel:false});\">" . $Language->Phrase("ExportToEmail") . "</a>";
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
		$Breadcrumb->Add("list", "<span id=\"ewPageCaption\">" . $PageCaption . "</span>", "comprehensivewill_tblist.php", $this->TableVar);
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
if (!isset($comprehensivewill_tb_view)) $comprehensivewill_tb_view = new ccomprehensivewill_tb_view();

// Page init
$comprehensivewill_tb_view->Page_Init();

// Page main
$comprehensivewill_tb_view->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$comprehensivewill_tb_view->Page_Render();
?>
<?php include_once "header.php" ?>
<?php if ($comprehensivewill_tb->Export == "") { ?>
<script type="text/javascript">

// Page object
var comprehensivewill_tb_view = new ew_Page("comprehensivewill_tb_view");
comprehensivewill_tb_view.PageID = "view"; // Page ID
var EW_PAGE_ID = comprehensivewill_tb_view.PageID; // For backward compatibility

// Form object
var fcomprehensivewill_tbview = new ew_Form("fcomprehensivewill_tbview");

// Form_CustomValidate event
fcomprehensivewill_tbview.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
fcomprehensivewill_tbview.ValidateRequired = true;
<?php } else { ?>
fcomprehensivewill_tbview.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
// Form object for search

</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<?php } ?>
<?php if ($comprehensivewill_tb->Export == "") { ?>
<?php $Breadcrumb->Render(); ?>
<?php } ?>
<?php if ($comprehensivewill_tb->Export == "") { ?>
<div class="ewViewExportOptions">
<?php $comprehensivewill_tb_view->ExportOptions->Render("body") ?>
<?php if (!$comprehensivewill_tb_view->ExportOptions->UseDropDownButton) { ?>
</div>
<div class="ewViewOtherOptions">
<?php } ?>
<?php
	foreach ($comprehensivewill_tb_view->OtherOptions as &$option)
		$option->Render("body");
?>
</div>
<?php } ?>
<?php $comprehensivewill_tb_view->ShowPageHeader(); ?>
<?php
$comprehensivewill_tb_view->ShowMessage();
?>
<form name="fcomprehensivewill_tbview" id="fcomprehensivewill_tbview" class="ewForm form-horizontal" action="<?php echo ew_CurrentPage() ?>" method="post">
<input type="hidden" name="t" value="comprehensivewill_tb">
<table cellspacing="0" class="ewGrid"><tr><td>
<table id="tbl_comprehensivewill_tbview" class="table table-bordered table-striped">
<?php if ($comprehensivewill_tb->id->Visible) { // id ?>
	<tr id="r_id">
		<td><span id="elh_comprehensivewill_tb_id"><?php echo $comprehensivewill_tb->id->FldCaption() ?></span></td>
		<td<?php echo $comprehensivewill_tb->id->CellAttributes() ?>>
<span id="el_comprehensivewill_tb_id" class="control-group">
<span<?php echo $comprehensivewill_tb->id->ViewAttributes() ?>>
<?php echo $comprehensivewill_tb->id->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($comprehensivewill_tb->uid->Visible) { // uid ?>
	<tr id="r_uid">
		<td><span id="elh_comprehensivewill_tb_uid"><?php echo $comprehensivewill_tb->uid->FldCaption() ?></span></td>
		<td<?php echo $comprehensivewill_tb->uid->CellAttributes() ?>>
<span id="el_comprehensivewill_tb_uid" class="control-group">
<span<?php echo $comprehensivewill_tb->uid->ViewAttributes() ?>>
<?php echo $comprehensivewill_tb->uid->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($comprehensivewill_tb->willtype->Visible) { // willtype ?>
	<tr id="r_willtype">
		<td><span id="elh_comprehensivewill_tb_willtype"><?php echo $comprehensivewill_tb->willtype->FldCaption() ?></span></td>
		<td<?php echo $comprehensivewill_tb->willtype->CellAttributes() ?>>
<span id="el_comprehensivewill_tb_willtype" class="control-group">
<span<?php echo $comprehensivewill_tb->willtype->ViewAttributes() ?>>
<?php echo $comprehensivewill_tb->willtype->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($comprehensivewill_tb->fullname->Visible) { // fullname ?>
	<tr id="r_fullname">
		<td><span id="elh_comprehensivewill_tb_fullname"><?php echo $comprehensivewill_tb->fullname->FldCaption() ?></span></td>
		<td<?php echo $comprehensivewill_tb->fullname->CellAttributes() ?>>
<span id="el_comprehensivewill_tb_fullname" class="control-group">
<span<?php echo $comprehensivewill_tb->fullname->ViewAttributes() ?>>
<?php echo $comprehensivewill_tb->fullname->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($comprehensivewill_tb->address->Visible) { // address ?>
	<tr id="r_address">
		<td><span id="elh_comprehensivewill_tb_address"><?php echo $comprehensivewill_tb->address->FldCaption() ?></span></td>
		<td<?php echo $comprehensivewill_tb->address->CellAttributes() ?>>
<span id="el_comprehensivewill_tb_address" class="control-group">
<span<?php echo $comprehensivewill_tb->address->ViewAttributes() ?>>
<?php echo $comprehensivewill_tb->address->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($comprehensivewill_tb->_email->Visible) { // email ?>
	<tr id="r__email">
		<td><span id="elh_comprehensivewill_tb__email"><?php echo $comprehensivewill_tb->_email->FldCaption() ?></span></td>
		<td<?php echo $comprehensivewill_tb->_email->CellAttributes() ?>>
<span id="el_comprehensivewill_tb__email" class="control-group">
<span<?php echo $comprehensivewill_tb->_email->ViewAttributes() ?>>
<?php echo $comprehensivewill_tb->_email->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($comprehensivewill_tb->phoneno->Visible) { // phoneno ?>
	<tr id="r_phoneno">
		<td><span id="elh_comprehensivewill_tb_phoneno"><?php echo $comprehensivewill_tb->phoneno->FldCaption() ?></span></td>
		<td<?php echo $comprehensivewill_tb->phoneno->CellAttributes() ?>>
<span id="el_comprehensivewill_tb_phoneno" class="control-group">
<span<?php echo $comprehensivewill_tb->phoneno->ViewAttributes() ?>>
<?php echo $comprehensivewill_tb->phoneno->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($comprehensivewill_tb->aphoneno->Visible) { // aphoneno ?>
	<tr id="r_aphoneno">
		<td><span id="elh_comprehensivewill_tb_aphoneno"><?php echo $comprehensivewill_tb->aphoneno->FldCaption() ?></span></td>
		<td<?php echo $comprehensivewill_tb->aphoneno->CellAttributes() ?>>
<span id="el_comprehensivewill_tb_aphoneno" class="control-group">
<span<?php echo $comprehensivewill_tb->aphoneno->ViewAttributes() ?>>
<?php echo $comprehensivewill_tb->aphoneno->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($comprehensivewill_tb->gender->Visible) { // gender ?>
	<tr id="r_gender">
		<td><span id="elh_comprehensivewill_tb_gender"><?php echo $comprehensivewill_tb->gender->FldCaption() ?></span></td>
		<td<?php echo $comprehensivewill_tb->gender->CellAttributes() ?>>
<span id="el_comprehensivewill_tb_gender" class="control-group">
<span<?php echo $comprehensivewill_tb->gender->ViewAttributes() ?>>
<?php echo $comprehensivewill_tb->gender->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($comprehensivewill_tb->dob->Visible) { // dob ?>
	<tr id="r_dob">
		<td><span id="elh_comprehensivewill_tb_dob"><?php echo $comprehensivewill_tb->dob->FldCaption() ?></span></td>
		<td<?php echo $comprehensivewill_tb->dob->CellAttributes() ?>>
<span id="el_comprehensivewill_tb_dob" class="control-group">
<span<?php echo $comprehensivewill_tb->dob->ViewAttributes() ?>>
<?php echo $comprehensivewill_tb->dob->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($comprehensivewill_tb->state->Visible) { // state ?>
	<tr id="r_state">
		<td><span id="elh_comprehensivewill_tb_state"><?php echo $comprehensivewill_tb->state->FldCaption() ?></span></td>
		<td<?php echo $comprehensivewill_tb->state->CellAttributes() ?>>
<span id="el_comprehensivewill_tb_state" class="control-group">
<span<?php echo $comprehensivewill_tb->state->ViewAttributes() ?>>
<?php echo $comprehensivewill_tb->state->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($comprehensivewill_tb->nationality->Visible) { // nationality ?>
	<tr id="r_nationality">
		<td><span id="elh_comprehensivewill_tb_nationality"><?php echo $comprehensivewill_tb->nationality->FldCaption() ?></span></td>
		<td<?php echo $comprehensivewill_tb->nationality->CellAttributes() ?>>
<span id="el_comprehensivewill_tb_nationality" class="control-group">
<span<?php echo $comprehensivewill_tb->nationality->ViewAttributes() ?>>
<?php echo $comprehensivewill_tb->nationality->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($comprehensivewill_tb->lga->Visible) { // lga ?>
	<tr id="r_lga">
		<td><span id="elh_comprehensivewill_tb_lga"><?php echo $comprehensivewill_tb->lga->FldCaption() ?></span></td>
		<td<?php echo $comprehensivewill_tb->lga->CellAttributes() ?>>
<span id="el_comprehensivewill_tb_lga" class="control-group">
<span<?php echo $comprehensivewill_tb->lga->ViewAttributes() ?>>
<?php echo $comprehensivewill_tb->lga->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($comprehensivewill_tb->employmentstatus->Visible) { // employmentstatus ?>
	<tr id="r_employmentstatus">
		<td><span id="elh_comprehensivewill_tb_employmentstatus"><?php echo $comprehensivewill_tb->employmentstatus->FldCaption() ?></span></td>
		<td<?php echo $comprehensivewill_tb->employmentstatus->CellAttributes() ?>>
<span id="el_comprehensivewill_tb_employmentstatus" class="control-group">
<span<?php echo $comprehensivewill_tb->employmentstatus->ViewAttributes() ?>>
<?php echo $comprehensivewill_tb->employmentstatus->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($comprehensivewill_tb->employer->Visible) { // employer ?>
	<tr id="r_employer">
		<td><span id="elh_comprehensivewill_tb_employer"><?php echo $comprehensivewill_tb->employer->FldCaption() ?></span></td>
		<td<?php echo $comprehensivewill_tb->employer->CellAttributes() ?>>
<span id="el_comprehensivewill_tb_employer" class="control-group">
<span<?php echo $comprehensivewill_tb->employer->ViewAttributes() ?>>
<?php echo $comprehensivewill_tb->employer->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($comprehensivewill_tb->employerphone->Visible) { // employerphone ?>
	<tr id="r_employerphone">
		<td><span id="elh_comprehensivewill_tb_employerphone"><?php echo $comprehensivewill_tb->employerphone->FldCaption() ?></span></td>
		<td<?php echo $comprehensivewill_tb->employerphone->CellAttributes() ?>>
<span id="el_comprehensivewill_tb_employerphone" class="control-group">
<span<?php echo $comprehensivewill_tb->employerphone->ViewAttributes() ?>>
<?php echo $comprehensivewill_tb->employerphone->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($comprehensivewill_tb->employeraddr->Visible) { // employeraddr ?>
	<tr id="r_employeraddr">
		<td><span id="elh_comprehensivewill_tb_employeraddr"><?php echo $comprehensivewill_tb->employeraddr->FldCaption() ?></span></td>
		<td<?php echo $comprehensivewill_tb->employeraddr->CellAttributes() ?>>
<span id="el_comprehensivewill_tb_employeraddr" class="control-group">
<span<?php echo $comprehensivewill_tb->employeraddr->ViewAttributes() ?>>
<?php echo $comprehensivewill_tb->employeraddr->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($comprehensivewill_tb->maritalstatus->Visible) { // maritalstatus ?>
	<tr id="r_maritalstatus">
		<td><span id="elh_comprehensivewill_tb_maritalstatus"><?php echo $comprehensivewill_tb->maritalstatus->FldCaption() ?></span></td>
		<td<?php echo $comprehensivewill_tb->maritalstatus->CellAttributes() ?>>
<span id="el_comprehensivewill_tb_maritalstatus" class="control-group">
<span<?php echo $comprehensivewill_tb->maritalstatus->ViewAttributes() ?>>
<?php echo $comprehensivewill_tb->maritalstatus->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($comprehensivewill_tb->spname->Visible) { // spname ?>
	<tr id="r_spname">
		<td><span id="elh_comprehensivewill_tb_spname"><?php echo $comprehensivewill_tb->spname->FldCaption() ?></span></td>
		<td<?php echo $comprehensivewill_tb->spname->CellAttributes() ?>>
<span id="el_comprehensivewill_tb_spname" class="control-group">
<span<?php echo $comprehensivewill_tb->spname->ViewAttributes() ?>>
<?php echo $comprehensivewill_tb->spname->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($comprehensivewill_tb->spemail->Visible) { // spemail ?>
	<tr id="r_spemail">
		<td><span id="elh_comprehensivewill_tb_spemail"><?php echo $comprehensivewill_tb->spemail->FldCaption() ?></span></td>
		<td<?php echo $comprehensivewill_tb->spemail->CellAttributes() ?>>
<span id="el_comprehensivewill_tb_spemail" class="control-group">
<span<?php echo $comprehensivewill_tb->spemail->ViewAttributes() ?>>
<?php echo $comprehensivewill_tb->spemail->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($comprehensivewill_tb->spphone->Visible) { // spphone ?>
	<tr id="r_spphone">
		<td><span id="elh_comprehensivewill_tb_spphone"><?php echo $comprehensivewill_tb->spphone->FldCaption() ?></span></td>
		<td<?php echo $comprehensivewill_tb->spphone->CellAttributes() ?>>
<span id="el_comprehensivewill_tb_spphone" class="control-group">
<span<?php echo $comprehensivewill_tb->spphone->ViewAttributes() ?>>
<?php echo $comprehensivewill_tb->spphone->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($comprehensivewill_tb->sdob->Visible) { // sdob ?>
	<tr id="r_sdob">
		<td><span id="elh_comprehensivewill_tb_sdob"><?php echo $comprehensivewill_tb->sdob->FldCaption() ?></span></td>
		<td<?php echo $comprehensivewill_tb->sdob->CellAttributes() ?>>
<span id="el_comprehensivewill_tb_sdob" class="control-group">
<span<?php echo $comprehensivewill_tb->sdob->ViewAttributes() ?>>
<?php echo $comprehensivewill_tb->sdob->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($comprehensivewill_tb->spaddr->Visible) { // spaddr ?>
	<tr id="r_spaddr">
		<td><span id="elh_comprehensivewill_tb_spaddr"><?php echo $comprehensivewill_tb->spaddr->FldCaption() ?></span></td>
		<td<?php echo $comprehensivewill_tb->spaddr->CellAttributes() ?>>
<span id="el_comprehensivewill_tb_spaddr" class="control-group">
<span<?php echo $comprehensivewill_tb->spaddr->ViewAttributes() ?>>
<?php echo $comprehensivewill_tb->spaddr->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($comprehensivewill_tb->spcity->Visible) { // spcity ?>
	<tr id="r_spcity">
		<td><span id="elh_comprehensivewill_tb_spcity"><?php echo $comprehensivewill_tb->spcity->FldCaption() ?></span></td>
		<td<?php echo $comprehensivewill_tb->spcity->CellAttributes() ?>>
<span id="el_comprehensivewill_tb_spcity" class="control-group">
<span<?php echo $comprehensivewill_tb->spcity->ViewAttributes() ?>>
<?php echo $comprehensivewill_tb->spcity->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($comprehensivewill_tb->spstate->Visible) { // spstate ?>
	<tr id="r_spstate">
		<td><span id="elh_comprehensivewill_tb_spstate"><?php echo $comprehensivewill_tb->spstate->FldCaption() ?></span></td>
		<td<?php echo $comprehensivewill_tb->spstate->CellAttributes() ?>>
<span id="el_comprehensivewill_tb_spstate" class="control-group">
<span<?php echo $comprehensivewill_tb->spstate->ViewAttributes() ?>>
<?php echo $comprehensivewill_tb->spstate->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($comprehensivewill_tb->marriagetype->Visible) { // marriagetype ?>
	<tr id="r_marriagetype">
		<td><span id="elh_comprehensivewill_tb_marriagetype"><?php echo $comprehensivewill_tb->marriagetype->FldCaption() ?></span></td>
		<td<?php echo $comprehensivewill_tb->marriagetype->CellAttributes() ?>>
<span id="el_comprehensivewill_tb_marriagetype" class="control-group">
<span<?php echo $comprehensivewill_tb->marriagetype->ViewAttributes() ?>>
<?php echo $comprehensivewill_tb->marriagetype->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($comprehensivewill_tb->marriageyear->Visible) { // marriageyear ?>
	<tr id="r_marriageyear">
		<td><span id="elh_comprehensivewill_tb_marriageyear"><?php echo $comprehensivewill_tb->marriageyear->FldCaption() ?></span></td>
		<td<?php echo $comprehensivewill_tb->marriageyear->CellAttributes() ?>>
<span id="el_comprehensivewill_tb_marriageyear" class="control-group">
<span<?php echo $comprehensivewill_tb->marriageyear->ViewAttributes() ?>>
<?php echo $comprehensivewill_tb->marriageyear->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($comprehensivewill_tb->marriagecert->Visible) { // marriagecert ?>
	<tr id="r_marriagecert">
		<td><span id="elh_comprehensivewill_tb_marriagecert"><?php echo $comprehensivewill_tb->marriagecert->FldCaption() ?></span></td>
		<td<?php echo $comprehensivewill_tb->marriagecert->CellAttributes() ?>>
<span id="el_comprehensivewill_tb_marriagecert" class="control-group">
<span<?php echo $comprehensivewill_tb->marriagecert->ViewAttributes() ?>>
<?php echo $comprehensivewill_tb->marriagecert->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($comprehensivewill_tb->marriagecity->Visible) { // marriagecity ?>
	<tr id="r_marriagecity">
		<td><span id="elh_comprehensivewill_tb_marriagecity"><?php echo $comprehensivewill_tb->marriagecity->FldCaption() ?></span></td>
		<td<?php echo $comprehensivewill_tb->marriagecity->CellAttributes() ?>>
<span id="el_comprehensivewill_tb_marriagecity" class="control-group">
<span<?php echo $comprehensivewill_tb->marriagecity->ViewAttributes() ?>>
<?php echo $comprehensivewill_tb->marriagecity->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($comprehensivewill_tb->marriagecountry->Visible) { // marriagecountry ?>
	<tr id="r_marriagecountry">
		<td><span id="elh_comprehensivewill_tb_marriagecountry"><?php echo $comprehensivewill_tb->marriagecountry->FldCaption() ?></span></td>
		<td<?php echo $comprehensivewill_tb->marriagecountry->CellAttributes() ?>>
<span id="el_comprehensivewill_tb_marriagecountry" class="control-group">
<span<?php echo $comprehensivewill_tb->marriagecountry->ViewAttributes() ?>>
<?php echo $comprehensivewill_tb->marriagecountry->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($comprehensivewill_tb->divorce->Visible) { // divorce ?>
	<tr id="r_divorce">
		<td><span id="elh_comprehensivewill_tb_divorce"><?php echo $comprehensivewill_tb->divorce->FldCaption() ?></span></td>
		<td<?php echo $comprehensivewill_tb->divorce->CellAttributes() ?>>
<span id="el_comprehensivewill_tb_divorce" class="control-group">
<span<?php echo $comprehensivewill_tb->divorce->ViewAttributes() ?>>
<?php echo $comprehensivewill_tb->divorce->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($comprehensivewill_tb->divorceyear->Visible) { // divorceyear ?>
	<tr id="r_divorceyear">
		<td><span id="elh_comprehensivewill_tb_divorceyear"><?php echo $comprehensivewill_tb->divorceyear->FldCaption() ?></span></td>
		<td<?php echo $comprehensivewill_tb->divorceyear->CellAttributes() ?>>
<span id="el_comprehensivewill_tb_divorceyear" class="control-group">
<span<?php echo $comprehensivewill_tb->divorceyear->ViewAttributes() ?>>
<?php echo $comprehensivewill_tb->divorceyear->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($comprehensivewill_tb->addinfo->Visible) { // addinfo ?>
	<tr id="r_addinfo">
		<td><span id="elh_comprehensivewill_tb_addinfo"><?php echo $comprehensivewill_tb->addinfo->FldCaption() ?></span></td>
		<td<?php echo $comprehensivewill_tb->addinfo->CellAttributes() ?>>
<span id="el_comprehensivewill_tb_addinfo" class="control-group">
<span<?php echo $comprehensivewill_tb->addinfo->ViewAttributes() ?>>
<?php echo $comprehensivewill_tb->addinfo->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($comprehensivewill_tb->datecreated->Visible) { // datecreated ?>
	<tr id="r_datecreated">
		<td><span id="elh_comprehensivewill_tb_datecreated"><?php echo $comprehensivewill_tb->datecreated->FldCaption() ?></span></td>
		<td<?php echo $comprehensivewill_tb->datecreated->CellAttributes() ?>>
<span id="el_comprehensivewill_tb_datecreated" class="control-group">
<span<?php echo $comprehensivewill_tb->datecreated->ViewAttributes() ?>>
<?php echo $comprehensivewill_tb->datecreated->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
</table>
</td></tr></table>
<?php if ($comprehensivewill_tb->Export == "") { ?>
<table class="ewPager">
<tr><td>
<?php if (!isset($comprehensivewill_tb_view->Pager)) $comprehensivewill_tb_view->Pager = new cNumericPager($comprehensivewill_tb_view->StartRec, $comprehensivewill_tb_view->DisplayRecs, $comprehensivewill_tb_view->TotalRecs, $comprehensivewill_tb_view->RecRange) ?>
<?php if ($comprehensivewill_tb_view->Pager->RecordCount > 0) { ?>
<table cellspacing="0" class="ewStdTable"><tbody><tr><td>
<div class="pagination"><ul>
	<?php if ($comprehensivewill_tb_view->Pager->FirstButton->Enabled) { ?>
	<li><a href="<?php echo $comprehensivewill_tb_view->PageUrl() ?>start=<?php echo $comprehensivewill_tb_view->Pager->FirstButton->Start ?>"><?php echo $Language->Phrase("PagerFirst") ?></a></li>
	<?php } ?>
	<?php if ($comprehensivewill_tb_view->Pager->PrevButton->Enabled) { ?>
	<li><a href="<?php echo $comprehensivewill_tb_view->PageUrl() ?>start=<?php echo $comprehensivewill_tb_view->Pager->PrevButton->Start ?>"><?php echo $Language->Phrase("PagerPrevious") ?></a></li>
	<?php } ?>
	<?php foreach ($comprehensivewill_tb_view->Pager->Items as $PagerItem) { ?>
		<li<?php if (!$PagerItem->Enabled) { echo " class=\" active\""; } ?>><a href="<?php if ($PagerItem->Enabled) { echo $comprehensivewill_tb_view->PageUrl() . "start=" . $PagerItem->Start; } else { echo "#"; } ?>"><?php echo $PagerItem->Text ?></a></li>
	<?php } ?>
	<?php if ($comprehensivewill_tb_view->Pager->NextButton->Enabled) { ?>
	<li><a href="<?php echo $comprehensivewill_tb_view->PageUrl() ?>start=<?php echo $comprehensivewill_tb_view->Pager->NextButton->Start ?>"><?php echo $Language->Phrase("PagerNext") ?></a></li>
	<?php } ?>
	<?php if ($comprehensivewill_tb_view->Pager->LastButton->Enabled) { ?>
	<li><a href="<?php echo $comprehensivewill_tb_view->PageUrl() ?>start=<?php echo $comprehensivewill_tb_view->Pager->LastButton->Start ?>"><?php echo $Language->Phrase("PagerLast") ?></a></li>
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
fcomprehensivewill_tbview.Init();
</script>
<?php
$comprehensivewill_tb_view->ShowPageFooter();
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
$comprehensivewill_tb_view->Page_Terminate();
?>
