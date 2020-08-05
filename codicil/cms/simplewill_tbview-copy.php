<?php
if (session_id() == "") session_start(); // Initialize Session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg10.php" ?>
<?php include_once "ewmysql10.php" ?>
<?php include_once "phpfn10.php" ?>
<?php include_once "simplewill_tbinfo.php" ?>
<?php include_once "adminusersinfo.php" ?>
<?php include_once "simplewill_assets_tbgridcls.php" ?>
<?php include_once "simplewill_overall_assetgridcls.php" ?>
<?php include_once "userfn10.php" ?>
<?php

//
// Page class
//

$simplewill_tb_view = NULL; // Initialize page object first

class csimplewill_tb_view extends csimplewill_tb {

	// Page ID
	var $PageID = 'view';

	// Project ID
	var $ProjectID = "{D9B361E7-B2C1-4293-B9B3-B581986A15CC}";

	// Table name
	var $TableName = 'simplewill_tb';

	// Page object name
	var $PageObjName = 'simplewill_tb_view';

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

		// Table object (simplewill_tb)
		if (!isset($GLOBALS["simplewill_tb"])) {
			$GLOBALS["simplewill_tb"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["simplewill_tb"];
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
			define("EW_TABLE_NAME", 'simplewill_tb', TRUE);

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
						$this->Page_Terminate("simplewill_tblist.php"); // Return to list page
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
						$sReturnUrl = "simplewill_tblist.php"; // No matching record, return to list
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
			$sReturnUrl = "simplewill_tblist.php"; // Not page request, return to list
		}
		if ($sReturnUrl <> "")
			$this->Page_Terminate($sReturnUrl);

		// Render row
		$this->RowType = EW_ROWTYPE_VIEW;
		$this->ResetAttrs();
		$this->RenderRow();

		// Set up detail parameters
		$this->SetUpDetailParms();
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
		$DetailTableLink = "";
		$option = &$options["detail"];

		// Detail table 'simplewill_assets_tb'
		$body = $Language->TablePhrase("simplewill_assets_tb", "TblCaption");
		$body = "<a class=\"ewAction ewDetailList\" href=\"" . ew_HtmlEncode("simplewill_assets_tblist.php?" . EW_TABLE_SHOW_MASTER . "=simplewill_tb&uid=" . strval($this->uid->CurrentValue) . "") . "\">" . $body . "</a>";
		$item = &$option->Add("detail_simplewill_assets_tb");
		$item->Body = $body;
		$item->Visible = $Security->IsLoggedIn();
		if ($item->Visible) {
			if ($DetailTableLink <> "") $DetailTableLink .= ",";
			$DetailTableLink .= "simplewill_assets_tb";
		}

		// Detail table 'simplewill_overall_asset'
		$body = $Language->TablePhrase("simplewill_overall_asset", "TblCaption");
		$body = "<a class=\"ewAction ewDetailList\" href=\"" . ew_HtmlEncode("simplewill_overall_assetlist.php?" . EW_TABLE_SHOW_MASTER . "=simplewill_tb&uid=" . strval($this->uid->CurrentValue) . "") . "\">" . $body . "</a>";
		$item = &$option->Add("detail_simplewill_overall_asset");
		$item->Body = $body;
		$item->Visible = $Security->IsLoggedIn();
		if ($item->Visible) {
			if ($DetailTableLink <> "") $DetailTableLink .= ",";
			$DetailTableLink .= "simplewill_overall_asset";
		}

		// Multiple details
		if ($this->ShowMultipleDetails) {
			$body = $Language->Phrase("MultipleMasterDetails");
			$body = "<a class=\"ewAction ewDetailView\" data-action=\"view\" href=\"" . ew_HtmlEncode($this->GetViewUrl(EW_TABLE_SHOW_DETAIL . "=" . $DetailTableLink)) . "\">" . $body . "</a>";
			$item = &$option->Add("details");
			$item->Body = $body;
			$item->Visible = ($DetailTableLink <> "");

			// Hide single master/detail items
			$ar = explode(",", $DetailTableLink);
			$cnt = count($ar);
			for ($i = 0; $i < $cnt; $i++) {
				if ($item = &$option->GetItem("detail_" . $ar[$i]))
					$item->Visible = FALSE;
			}
		}

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
		$this->maidenname->setDbValue($rs->fields('maidenname'));
		$this->identificationtype->setDbValue($rs->fields('identificationtype'));
		$this->idnumber->setDbValue($rs->fields('idnumber'));
		$this->issuedate->setDbValue($rs->fields('issuedate'));
		$this->expirydate->setDbValue($rs->fields('expirydate'));
		$this->issueplace->setDbValue($rs->fields('issueplace'));
		$this->employmentstatus->setDbValue($rs->fields('employmentstatus'));
		$this->employer->setDbValue($rs->fields('employer'));
		$this->employerphone->setDbValue($rs->fields('employerphone'));
		$this->employeraddr->setDbValue($rs->fields('employeraddr'));
		$this->maritalstatus->setDbValue($rs->fields('maritalstatus'));
		$this->spousename->setDbValue($rs->fields('spousename'));
		$this->spouseemail->setDbValue($rs->fields('spouseemail'));
		$this->spousephone->setDbValue($rs->fields('spousephone'));
		$this->spousedob->setDbValue($rs->fields('spousedob'));
		$this->spouseaddr->setDbValue($rs->fields('spouseaddr'));
		$this->spousecity->setDbValue($rs->fields('spousecity'));
		$this->spousestate->setDbValue($rs->fields('spousestate'));
		$this->marriagetype->setDbValue($rs->fields('marriagetype'));
		$this->marriageyear->setDbValue($rs->fields('marriageyear'));
		$this->marriagecert->setDbValue($rs->fields('marriagecert'));
		$this->cityofmarriage->setDbValue($rs->fields('cityofmarriage'));
		$this->countryofmarriage->setDbValue($rs->fields('countryofmarriage'));
		$this->divorce->setDbValue($rs->fields('divorce'));
		$this->divorceyear->setDbValue($rs->fields('divorceyear'));
		$this->nextofkinfullname->setDbValue($rs->fields('nextofkinfullname'));
		$this->nextofkintelephone->setDbValue($rs->fields('nextofkintelephone'));
		$this->nextofkinemail->setDbValue($rs->fields('nextofkinemail'));
		$this->nextofkinaddress->setDbValue($rs->fields('nextofkinaddress'));
		$this->nameofcompany->setDbValue($rs->fields('nameofcompany'));
		$this->humanresourcescontacttelephone->setDbValue($rs->fields('humanresourcescontacttelephone'));
		$this->humanresourcescontactemailaddress->setDbValue($rs->fields('humanresourcescontactemailaddress'));
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
		$this->maidenname->DbValue = $row['maidenname'];
		$this->identificationtype->DbValue = $row['identificationtype'];
		$this->idnumber->DbValue = $row['idnumber'];
		$this->issuedate->DbValue = $row['issuedate'];
		$this->expirydate->DbValue = $row['expirydate'];
		$this->issueplace->DbValue = $row['issueplace'];
		$this->employmentstatus->DbValue = $row['employmentstatus'];
		$this->employer->DbValue = $row['employer'];
		$this->employerphone->DbValue = $row['employerphone'];
		$this->employeraddr->DbValue = $row['employeraddr'];
		$this->maritalstatus->DbValue = $row['maritalstatus'];
		$this->spousename->DbValue = $row['spousename'];
		$this->spouseemail->DbValue = $row['spouseemail'];
		$this->spousephone->DbValue = $row['spousephone'];
		$this->spousedob->DbValue = $row['spousedob'];
		$this->spouseaddr->DbValue = $row['spouseaddr'];
		$this->spousecity->DbValue = $row['spousecity'];
		$this->spousestate->DbValue = $row['spousestate'];
		$this->marriagetype->DbValue = $row['marriagetype'];
		$this->marriageyear->DbValue = $row['marriageyear'];
		$this->marriagecert->DbValue = $row['marriagecert'];
		$this->cityofmarriage->DbValue = $row['cityofmarriage'];
		$this->countryofmarriage->DbValue = $row['countryofmarriage'];
		$this->divorce->DbValue = $row['divorce'];
		$this->divorceyear->DbValue = $row['divorceyear'];
		$this->nextofkinfullname->DbValue = $row['nextofkinfullname'];
		$this->nextofkintelephone->DbValue = $row['nextofkintelephone'];
		$this->nextofkinemail->DbValue = $row['nextofkinemail'];
		$this->nextofkinaddress->DbValue = $row['nextofkinaddress'];
		$this->nameofcompany->DbValue = $row['nameofcompany'];
		$this->humanresourcescontacttelephone->DbValue = $row['humanresourcescontacttelephone'];
		$this->humanresourcescontactemailaddress->DbValue = $row['humanresourcescontactemailaddress'];
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
		// maidenname
		// identificationtype
		// idnumber
		// issuedate
		// expirydate
		// issueplace
		// employmentstatus
		// employer
		// employerphone
		// employeraddr
		// maritalstatus
		// spousename
		// spouseemail
		// spousephone
		// spousedob
		// spouseaddr
		// spousecity
		// spousestate
		// marriagetype
		// marriageyear
		// marriagecert
		// cityofmarriage
		// countryofmarriage
		// divorce
		// divorceyear
		// nextofkinfullname
		// nextofkintelephone
		// nextofkinemail
		// nextofkinaddress
		// nameofcompany
		// humanresourcescontacttelephone
		// humanresourcescontactemailaddress
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

			// marriagetype
			$this->marriagetype->ViewValue = $this->marriagetype->CurrentValue;
			$this->marriagetype->ViewCustomAttributes = "";

			// marriageyear
			$this->marriageyear->ViewValue = $this->marriageyear->CurrentValue;
			$this->marriageyear->ViewCustomAttributes = "";

			// marriagecert
			$this->marriagecert->ViewValue = $this->marriagecert->CurrentValue;
			$this->marriagecert->ViewCustomAttributes = "";

			// cityofmarriage
			$this->cityofmarriage->ViewValue = $this->cityofmarriage->CurrentValue;
			$this->cityofmarriage->ViewCustomAttributes = "";

			// countryofmarriage
			$this->countryofmarriage->ViewValue = $this->countryofmarriage->CurrentValue;
			$this->countryofmarriage->ViewCustomAttributes = "";

			// divorce
			$this->divorce->ViewValue = $this->divorce->CurrentValue;
			$this->divorce->ViewCustomAttributes = "";

			// divorceyear
			$this->divorceyear->ViewValue = $this->divorceyear->CurrentValue;
			$this->divorceyear->ViewCustomAttributes = "";

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
			if (!ew_Empty($this->uid->CurrentValue)) {
				$this->fullname->HrefValue = "http://tisvdigital.com/trustees/portal/adminsimplewill-preview.php?a=" . ((!empty($this->uid->ViewValue)) ? $this->uid->ViewValue : $this->uid->CurrentValue); // Add prefix/suffix
				$this->fullname->LinkAttrs["target"] = "_blank"; // Add target
				if ($this->Export <> "") $this->fullname->HrefValue = ew_ConvertFullUrl($this->fullname->HrefValue);
			} else {
				$this->fullname->HrefValue = "";
			}
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

			// maidenname
			$this->maidenname->LinkCustomAttributes = "";
			$this->maidenname->HrefValue = "";
			$this->maidenname->TooltipValue = "";

			// identificationtype
			$this->identificationtype->LinkCustomAttributes = "";
			$this->identificationtype->HrefValue = "";
			$this->identificationtype->TooltipValue = "";

			// idnumber
			$this->idnumber->LinkCustomAttributes = "";
			$this->idnumber->HrefValue = "";
			$this->idnumber->TooltipValue = "";

			// issuedate
			$this->issuedate->LinkCustomAttributes = "";
			$this->issuedate->HrefValue = "";
			$this->issuedate->TooltipValue = "";

			// expirydate
			$this->expirydate->LinkCustomAttributes = "";
			$this->expirydate->HrefValue = "";
			$this->expirydate->TooltipValue = "";

			// issueplace
			$this->issueplace->LinkCustomAttributes = "";
			$this->issueplace->HrefValue = "";
			$this->issueplace->TooltipValue = "";

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

			// spousename
			$this->spousename->LinkCustomAttributes = "";
			$this->spousename->HrefValue = "";
			$this->spousename->TooltipValue = "";

			// spouseemail
			$this->spouseemail->LinkCustomAttributes = "";
			$this->spouseemail->HrefValue = "";
			$this->spouseemail->TooltipValue = "";

			// spousephone
			$this->spousephone->LinkCustomAttributes = "";
			$this->spousephone->HrefValue = "";
			$this->spousephone->TooltipValue = "";

			// spousedob
			$this->spousedob->LinkCustomAttributes = "";
			$this->spousedob->HrefValue = "";
			$this->spousedob->TooltipValue = "";

			// spouseaddr
			$this->spouseaddr->LinkCustomAttributes = "";
			$this->spouseaddr->HrefValue = "";
			$this->spouseaddr->TooltipValue = "";

			// spousecity
			$this->spousecity->LinkCustomAttributes = "";
			$this->spousecity->HrefValue = "";
			$this->spousecity->TooltipValue = "";

			// spousestate
			$this->spousestate->LinkCustomAttributes = "";
			$this->spousestate->HrefValue = "";
			$this->spousestate->TooltipValue = "";

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

			// cityofmarriage
			$this->cityofmarriage->LinkCustomAttributes = "";
			$this->cityofmarriage->HrefValue = "";
			$this->cityofmarriage->TooltipValue = "";

			// countryofmarriage
			$this->countryofmarriage->LinkCustomAttributes = "";
			$this->countryofmarriage->HrefValue = "";
			$this->countryofmarriage->TooltipValue = "";

			// divorce
			$this->divorce->LinkCustomAttributes = "";
			$this->divorce->HrefValue = "";
			$this->divorce->TooltipValue = "";

			// divorceyear
			$this->divorceyear->LinkCustomAttributes = "";
			$this->divorceyear->HrefValue = "";
			$this->divorceyear->TooltipValue = "";

			// nextofkinfullname
			$this->nextofkinfullname->LinkCustomAttributes = "";
			$this->nextofkinfullname->HrefValue = "";
			$this->nextofkinfullname->TooltipValue = "";

			// nextofkintelephone
			$this->nextofkintelephone->LinkCustomAttributes = "";
			$this->nextofkintelephone->HrefValue = "";
			$this->nextofkintelephone->TooltipValue = "";

			// nextofkinemail
			$this->nextofkinemail->LinkCustomAttributes = "";
			$this->nextofkinemail->HrefValue = "";
			$this->nextofkinemail->TooltipValue = "";

			// nextofkinaddress
			$this->nextofkinaddress->LinkCustomAttributes = "";
			$this->nextofkinaddress->HrefValue = "";
			$this->nextofkinaddress->TooltipValue = "";

			// nameofcompany
			$this->nameofcompany->LinkCustomAttributes = "";
			$this->nameofcompany->HrefValue = "";
			$this->nameofcompany->TooltipValue = "";

			// humanresourcescontacttelephone
			$this->humanresourcescontacttelephone->LinkCustomAttributes = "";
			$this->humanresourcescontacttelephone->HrefValue = "";
			$this->humanresourcescontacttelephone->TooltipValue = "";

			// humanresourcescontactemailaddress
			$this->humanresourcescontactemailaddress->LinkCustomAttributes = "";
			$this->humanresourcescontactemailaddress->HrefValue = "";
			$this->humanresourcescontactemailaddress->TooltipValue = "";

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
		$item->Body = "<a id=\"emf_simplewill_tb\" href=\"javascript:void(0);\" class=\"ewExportLink ewEmail\" data-caption=\"" . $Language->Phrase("ExportToEmailText") . "\" onclick=\"ew_EmailDialogShow({lnk:'emf_simplewill_tb',hdr:ewLanguage.Phrase('ExportToEmail'),f:document.fsimplewill_tbview,key:" . ew_ArrayToJsonAttr($this->RecKey) . ",sel:false});\">" . $Language->Phrase("ExportToEmail") . "</a>";
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

	// Set up detail parms based on QueryString
	function SetUpDetailParms() {

		// Get the keys for master table
		if (isset($_GET[EW_TABLE_SHOW_DETAIL])) {
			$sDetailTblVar = $_GET[EW_TABLE_SHOW_DETAIL];
			$this->setCurrentDetailTable($sDetailTblVar);
		} else {
			$sDetailTblVar = $this->getCurrentDetailTable();
		}
		if ($sDetailTblVar <> "") {
			$DetailTblVar = explode(",", $sDetailTblVar);
			if (in_array("simplewill_assets_tb", $DetailTblVar)) {
				if (!isset($GLOBALS["simplewill_assets_tb_grid"]))
					$GLOBALS["simplewill_assets_tb_grid"] = new csimplewill_assets_tb_grid;
				if ($GLOBALS["simplewill_assets_tb_grid"]->DetailView) {
					$GLOBALS["simplewill_assets_tb_grid"]->CurrentMode = "view";

					// Save current master table to detail table
					$GLOBALS["simplewill_assets_tb_grid"]->setCurrentMasterTable($this->TableVar);
					$GLOBALS["simplewill_assets_tb_grid"]->setStartRecordNumber(1);
					$GLOBALS["simplewill_assets_tb_grid"]->uid->FldIsDetailKey = TRUE;
					$GLOBALS["simplewill_assets_tb_grid"]->uid->CurrentValue = $this->uid->CurrentValue;
					$GLOBALS["simplewill_assets_tb_grid"]->uid->setSessionValue($GLOBALS["simplewill_assets_tb_grid"]->uid->CurrentValue);
				}
			}
			if (in_array("simplewill_overall_asset", $DetailTblVar)) {
				if (!isset($GLOBALS["simplewill_overall_asset_grid"]))
					$GLOBALS["simplewill_overall_asset_grid"] = new csimplewill_overall_asset_grid;
				if ($GLOBALS["simplewill_overall_asset_grid"]->DetailView) {
					$GLOBALS["simplewill_overall_asset_grid"]->CurrentMode = "view";

					// Save current master table to detail table
					$GLOBALS["simplewill_overall_asset_grid"]->setCurrentMasterTable($this->TableVar);
					$GLOBALS["simplewill_overall_asset_grid"]->setStartRecordNumber(1);
					$GLOBALS["simplewill_overall_asset_grid"]->uid->FldIsDetailKey = TRUE;
					$GLOBALS["simplewill_overall_asset_grid"]->uid->CurrentValue = $this->uid->CurrentValue;
					$GLOBALS["simplewill_overall_asset_grid"]->uid->setSessionValue($GLOBALS["simplewill_overall_asset_grid"]->uid->CurrentValue);
				}
			}
		}
	}

	// Set up Breadcrumb
	function SetupBreadcrumb() {
		global $Breadcrumb, $Language;
		$Breadcrumb = new cBreadcrumb();
		$PageCaption = $this->TableCaption();
		$Breadcrumb->Add("list", "<span id=\"ewPageCaption\">" . $PageCaption . "</span>", "simplewill_tblist.php", $this->TableVar);
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
if (!isset($simplewill_tb_view)) $simplewill_tb_view = new csimplewill_tb_view();

// Page init
$simplewill_tb_view->Page_Init();

// Page main
$simplewill_tb_view->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$simplewill_tb_view->Page_Render();
?>
<?php include_once "header.php" ?>
<?php if ($simplewill_tb->Export == "") { ?>
<script type="text/javascript">

// Page object
var simplewill_tb_view = new ew_Page("simplewill_tb_view");
simplewill_tb_view.PageID = "view"; // Page ID
var EW_PAGE_ID = simplewill_tb_view.PageID; // For backward compatibility

// Form object
var fsimplewill_tbview = new ew_Form("fsimplewill_tbview");

// Form_CustomValidate event
fsimplewill_tbview.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
fsimplewill_tbview.ValidateRequired = true;
<?php } else { ?>
fsimplewill_tbview.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
// Form object for search

</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<?php } ?>
<?php if ($simplewill_tb->Export == "") { ?>
<?php $Breadcrumb->Render(); ?>
<?php } ?>
<?php if ($simplewill_tb->Export == "") { ?>
<div class="ewViewExportOptions">
<?php $simplewill_tb_view->ExportOptions->Render("body") ?>
<?php if (!$simplewill_tb_view->ExportOptions->UseDropDownButton) { ?>
</div>
<div class="ewViewOtherOptions">
<?php } ?>
<?php
	foreach ($simplewill_tb_view->OtherOptions as &$option)
		$option->Render("body");
?>
</div>
<?php } ?>
<?php $simplewill_tb_view->ShowPageHeader(); ?>
<?php
$simplewill_tb_view->ShowMessage();
?>
<form name="fsimplewill_tbview" id="fsimplewill_tbview" class="ewForm form-horizontal" action="<?php echo ew_CurrentPage() ?>" method="post">
<input type="hidden" name="t" value="simplewill_tb">
<table cellspacing="0" class="ewGrid"><tr><td>
<table id="tbl_simplewill_tbview" class="table table-bordered table-striped">
<?php if ($simplewill_tb->id->Visible) { // id ?>
	<tr id="r_id">
		<td><span id="elh_simplewill_tb_id"><?php echo $simplewill_tb->id->FldCaption() ?></span></td>
		<td<?php echo $simplewill_tb->id->CellAttributes() ?>>
<span id="el_simplewill_tb_id" class="control-group">
<span<?php echo $simplewill_tb->id->ViewAttributes() ?>>
<?php echo $simplewill_tb->id->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($simplewill_tb->uid->Visible) { // uid ?>
	<tr id="r_uid">
		<td><span id="elh_simplewill_tb_uid"><?php echo $simplewill_tb->uid->FldCaption() ?></span></td>
		<td<?php echo $simplewill_tb->uid->CellAttributes() ?>>
<span id="el_simplewill_tb_uid" class="control-group">
<span<?php echo $simplewill_tb->uid->ViewAttributes() ?>>
<?php echo $simplewill_tb->uid->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($simplewill_tb->willtype->Visible) { // willtype ?>
	<tr id="r_willtype">
		<td><span id="elh_simplewill_tb_willtype"><?php echo $simplewill_tb->willtype->FldCaption() ?></span></td>
		<td<?php echo $simplewill_tb->willtype->CellAttributes() ?>>
<span id="el_simplewill_tb_willtype" class="control-group">
<span<?php echo $simplewill_tb->willtype->ViewAttributes() ?>>
<?php echo $simplewill_tb->willtype->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($simplewill_tb->fullname->Visible) { // fullname ?>
	<tr id="r_fullname">
		<td><span id="elh_simplewill_tb_fullname"><?php echo $simplewill_tb->fullname->FldCaption() ?></span></td>
		<td<?php echo $simplewill_tb->fullname->CellAttributes() ?>>
<span id="el_simplewill_tb_fullname" class="control-group">
<span<?php echo $simplewill_tb->fullname->ViewAttributes() ?>>
<?php if (!ew_EmptyStr($simplewill_tb->fullname->ViewValue) && $simplewill_tb->fullname->LinkAttributes() <> "") { ?>
<a<?php echo $simplewill_tb->fullname->LinkAttributes() ?>><?php echo $simplewill_tb->fullname->ViewValue ?></a>
<?php } else { ?>
<?php echo $simplewill_tb->fullname->ViewValue ?>
<?php } ?>
</span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($simplewill_tb->address->Visible) { // address ?>
	<tr id="r_address">
		<td><span id="elh_simplewill_tb_address"><?php echo $simplewill_tb->address->FldCaption() ?></span></td>
		<td<?php echo $simplewill_tb->address->CellAttributes() ?>>
<span id="el_simplewill_tb_address" class="control-group">
<span<?php echo $simplewill_tb->address->ViewAttributes() ?>>
<?php echo $simplewill_tb->address->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($simplewill_tb->_email->Visible) { // email ?>
	<tr id="r__email">
		<td><span id="elh_simplewill_tb__email"><?php echo $simplewill_tb->_email->FldCaption() ?></span></td>
		<td<?php echo $simplewill_tb->_email->CellAttributes() ?>>
<span id="el_simplewill_tb__email" class="control-group">
<span<?php echo $simplewill_tb->_email->ViewAttributes() ?>>
<?php echo $simplewill_tb->_email->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($simplewill_tb->phoneno->Visible) { // phoneno ?>
	<tr id="r_phoneno">
		<td><span id="elh_simplewill_tb_phoneno"><?php echo $simplewill_tb->phoneno->FldCaption() ?></span></td>
		<td<?php echo $simplewill_tb->phoneno->CellAttributes() ?>>
<span id="el_simplewill_tb_phoneno" class="control-group">
<span<?php echo $simplewill_tb->phoneno->ViewAttributes() ?>>
<?php echo $simplewill_tb->phoneno->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($simplewill_tb->aphoneno->Visible) { // aphoneno ?>
	<tr id="r_aphoneno">
		<td><span id="elh_simplewill_tb_aphoneno"><?php echo $simplewill_tb->aphoneno->FldCaption() ?></span></td>
		<td<?php echo $simplewill_tb->aphoneno->CellAttributes() ?>>
<span id="el_simplewill_tb_aphoneno" class="control-group">
<span<?php echo $simplewill_tb->aphoneno->ViewAttributes() ?>>
<?php echo $simplewill_tb->aphoneno->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($simplewill_tb->gender->Visible) { // gender ?>
	<tr id="r_gender">
		<td><span id="elh_simplewill_tb_gender"><?php echo $simplewill_tb->gender->FldCaption() ?></span></td>
		<td<?php echo $simplewill_tb->gender->CellAttributes() ?>>
<span id="el_simplewill_tb_gender" class="control-group">
<span<?php echo $simplewill_tb->gender->ViewAttributes() ?>>
<?php echo $simplewill_tb->gender->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($simplewill_tb->dob->Visible) { // dob ?>
	<tr id="r_dob">
		<td><span id="elh_simplewill_tb_dob"><?php echo $simplewill_tb->dob->FldCaption() ?></span></td>
		<td<?php echo $simplewill_tb->dob->CellAttributes() ?>>
<span id="el_simplewill_tb_dob" class="control-group">
<span<?php echo $simplewill_tb->dob->ViewAttributes() ?>>
<?php echo $simplewill_tb->dob->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($simplewill_tb->state->Visible) { // state ?>
	<tr id="r_state">
		<td><span id="elh_simplewill_tb_state"><?php echo $simplewill_tb->state->FldCaption() ?></span></td>
		<td<?php echo $simplewill_tb->state->CellAttributes() ?>>
<span id="el_simplewill_tb_state" class="control-group">
<span<?php echo $simplewill_tb->state->ViewAttributes() ?>>
<?php echo $simplewill_tb->state->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($simplewill_tb->nationality->Visible) { // nationality ?>
	<tr id="r_nationality">
		<td><span id="elh_simplewill_tb_nationality"><?php echo $simplewill_tb->nationality->FldCaption() ?></span></td>
		<td<?php echo $simplewill_tb->nationality->CellAttributes() ?>>
<span id="el_simplewill_tb_nationality" class="control-group">
<span<?php echo $simplewill_tb->nationality->ViewAttributes() ?>>
<?php echo $simplewill_tb->nationality->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($simplewill_tb->lga->Visible) { // lga ?>
	<tr id="r_lga">
		<td><span id="elh_simplewill_tb_lga"><?php echo $simplewill_tb->lga->FldCaption() ?></span></td>
		<td<?php echo $simplewill_tb->lga->CellAttributes() ?>>
<span id="el_simplewill_tb_lga" class="control-group">
<span<?php echo $simplewill_tb->lga->ViewAttributes() ?>>
<?php echo $simplewill_tb->lga->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($simplewill_tb->maidenname->Visible) { // maidenname ?>
	<tr id="r_maidenname">
		<td><span id="elh_simplewill_tb_maidenname"><?php echo $simplewill_tb->maidenname->FldCaption() ?></span></td>
		<td<?php echo $simplewill_tb->maidenname->CellAttributes() ?>>
<span id="el_simplewill_tb_maidenname" class="control-group">
<span<?php echo $simplewill_tb->maidenname->ViewAttributes() ?>>
<?php echo $simplewill_tb->maidenname->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($simplewill_tb->identificationtype->Visible) { // identificationtype ?>
	<tr id="r_identificationtype">
		<td><span id="elh_simplewill_tb_identificationtype"><?php echo $simplewill_tb->identificationtype->FldCaption() ?></span></td>
		<td<?php echo $simplewill_tb->identificationtype->CellAttributes() ?>>
<span id="el_simplewill_tb_identificationtype" class="control-group">
<span<?php echo $simplewill_tb->identificationtype->ViewAttributes() ?>>
<?php echo $simplewill_tb->identificationtype->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($simplewill_tb->idnumber->Visible) { // idnumber ?>
	<tr id="r_idnumber">
		<td><span id="elh_simplewill_tb_idnumber"><?php echo $simplewill_tb->idnumber->FldCaption() ?></span></td>
		<td<?php echo $simplewill_tb->idnumber->CellAttributes() ?>>
<span id="el_simplewill_tb_idnumber" class="control-group">
<span<?php echo $simplewill_tb->idnumber->ViewAttributes() ?>>
<?php echo $simplewill_tb->idnumber->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($simplewill_tb->issuedate->Visible) { // issuedate ?>
	<tr id="r_issuedate">
		<td><span id="elh_simplewill_tb_issuedate"><?php echo $simplewill_tb->issuedate->FldCaption() ?></span></td>
		<td<?php echo $simplewill_tb->issuedate->CellAttributes() ?>>
<span id="el_simplewill_tb_issuedate" class="control-group">
<span<?php echo $simplewill_tb->issuedate->ViewAttributes() ?>>
<?php echo $simplewill_tb->issuedate->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($simplewill_tb->expirydate->Visible) { // expirydate ?>
	<tr id="r_expirydate">
		<td><span id="elh_simplewill_tb_expirydate"><?php echo $simplewill_tb->expirydate->FldCaption() ?></span></td>
		<td<?php echo $simplewill_tb->expirydate->CellAttributes() ?>>
<span id="el_simplewill_tb_expirydate" class="control-group">
<span<?php echo $simplewill_tb->expirydate->ViewAttributes() ?>>
<?php echo $simplewill_tb->expirydate->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($simplewill_tb->issueplace->Visible) { // issueplace ?>
	<tr id="r_issueplace">
		<td><span id="elh_simplewill_tb_issueplace"><?php echo $simplewill_tb->issueplace->FldCaption() ?></span></td>
		<td<?php echo $simplewill_tb->issueplace->CellAttributes() ?>>
<span id="el_simplewill_tb_issueplace" class="control-group">
<span<?php echo $simplewill_tb->issueplace->ViewAttributes() ?>>
<?php echo $simplewill_tb->issueplace->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($simplewill_tb->employmentstatus->Visible) { // employmentstatus ?>
	<tr id="r_employmentstatus">
		<td><span id="elh_simplewill_tb_employmentstatus"><?php echo $simplewill_tb->employmentstatus->FldCaption() ?></span></td>
		<td<?php echo $simplewill_tb->employmentstatus->CellAttributes() ?>>
<span id="el_simplewill_tb_employmentstatus" class="control-group">
<span<?php echo $simplewill_tb->employmentstatus->ViewAttributes() ?>>
<?php echo $simplewill_tb->employmentstatus->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($simplewill_tb->employer->Visible) { // employer ?>
	<tr id="r_employer">
		<td><span id="elh_simplewill_tb_employer"><?php echo $simplewill_tb->employer->FldCaption() ?></span></td>
		<td<?php echo $simplewill_tb->employer->CellAttributes() ?>>
<span id="el_simplewill_tb_employer" class="control-group">
<span<?php echo $simplewill_tb->employer->ViewAttributes() ?>>
<?php echo $simplewill_tb->employer->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($simplewill_tb->employerphone->Visible) { // employerphone ?>
	<tr id="r_employerphone">
		<td><span id="elh_simplewill_tb_employerphone"><?php echo $simplewill_tb->employerphone->FldCaption() ?></span></td>
		<td<?php echo $simplewill_tb->employerphone->CellAttributes() ?>>
<span id="el_simplewill_tb_employerphone" class="control-group">
<span<?php echo $simplewill_tb->employerphone->ViewAttributes() ?>>
<?php echo $simplewill_tb->employerphone->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($simplewill_tb->employeraddr->Visible) { // employeraddr ?>
	<tr id="r_employeraddr">
		<td><span id="elh_simplewill_tb_employeraddr"><?php echo $simplewill_tb->employeraddr->FldCaption() ?></span></td>
		<td<?php echo $simplewill_tb->employeraddr->CellAttributes() ?>>
<span id="el_simplewill_tb_employeraddr" class="control-group">
<span<?php echo $simplewill_tb->employeraddr->ViewAttributes() ?>>
<?php echo $simplewill_tb->employeraddr->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($simplewill_tb->maritalstatus->Visible) { // maritalstatus ?>
	<tr id="r_maritalstatus">
		<td><span id="elh_simplewill_tb_maritalstatus"><?php echo $simplewill_tb->maritalstatus->FldCaption() ?></span></td>
		<td<?php echo $simplewill_tb->maritalstatus->CellAttributes() ?>>
<span id="el_simplewill_tb_maritalstatus" class="control-group">
<span<?php echo $simplewill_tb->maritalstatus->ViewAttributes() ?>>
<?php echo $simplewill_tb->maritalstatus->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($simplewill_tb->spousename->Visible) { // spousename ?>
	<tr id="r_spousename">
		<td><span id="elh_simplewill_tb_spousename"><?php echo $simplewill_tb->spousename->FldCaption() ?></span></td>
		<td<?php echo $simplewill_tb->spousename->CellAttributes() ?>>
<span id="el_simplewill_tb_spousename" class="control-group">
<span<?php echo $simplewill_tb->spousename->ViewAttributes() ?>>
<?php echo $simplewill_tb->spousename->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($simplewill_tb->spouseemail->Visible) { // spouseemail ?>
	<tr id="r_spouseemail">
		<td><span id="elh_simplewill_tb_spouseemail"><?php echo $simplewill_tb->spouseemail->FldCaption() ?></span></td>
		<td<?php echo $simplewill_tb->spouseemail->CellAttributes() ?>>
<span id="el_simplewill_tb_spouseemail" class="control-group">
<span<?php echo $simplewill_tb->spouseemail->ViewAttributes() ?>>
<?php echo $simplewill_tb->spouseemail->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($simplewill_tb->spousephone->Visible) { // spousephone ?>
	<tr id="r_spousephone">
		<td><span id="elh_simplewill_tb_spousephone"><?php echo $simplewill_tb->spousephone->FldCaption() ?></span></td>
		<td<?php echo $simplewill_tb->spousephone->CellAttributes() ?>>
<span id="el_simplewill_tb_spousephone" class="control-group">
<span<?php echo $simplewill_tb->spousephone->ViewAttributes() ?>>
<?php echo $simplewill_tb->spousephone->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($simplewill_tb->spousedob->Visible) { // spousedob ?>
	<tr id="r_spousedob">
		<td><span id="elh_simplewill_tb_spousedob"><?php echo $simplewill_tb->spousedob->FldCaption() ?></span></td>
		<td<?php echo $simplewill_tb->spousedob->CellAttributes() ?>>
<span id="el_simplewill_tb_spousedob" class="control-group">
<span<?php echo $simplewill_tb->spousedob->ViewAttributes() ?>>
<?php echo $simplewill_tb->spousedob->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($simplewill_tb->spouseaddr->Visible) { // spouseaddr ?>
	<tr id="r_spouseaddr">
		<td><span id="elh_simplewill_tb_spouseaddr"><?php echo $simplewill_tb->spouseaddr->FldCaption() ?></span></td>
		<td<?php echo $simplewill_tb->spouseaddr->CellAttributes() ?>>
<span id="el_simplewill_tb_spouseaddr" class="control-group">
<span<?php echo $simplewill_tb->spouseaddr->ViewAttributes() ?>>
<?php echo $simplewill_tb->spouseaddr->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($simplewill_tb->spousecity->Visible) { // spousecity ?>
	<tr id="r_spousecity">
		<td><span id="elh_simplewill_tb_spousecity"><?php echo $simplewill_tb->spousecity->FldCaption() ?></span></td>
		<td<?php echo $simplewill_tb->spousecity->CellAttributes() ?>>
<span id="el_simplewill_tb_spousecity" class="control-group">
<span<?php echo $simplewill_tb->spousecity->ViewAttributes() ?>>
<?php echo $simplewill_tb->spousecity->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($simplewill_tb->spousestate->Visible) { // spousestate ?>
	<tr id="r_spousestate">
		<td><span id="elh_simplewill_tb_spousestate"><?php echo $simplewill_tb->spousestate->FldCaption() ?></span></td>
		<td<?php echo $simplewill_tb->spousestate->CellAttributes() ?>>
<span id="el_simplewill_tb_spousestate" class="control-group">
<span<?php echo $simplewill_tb->spousestate->ViewAttributes() ?>>
<?php echo $simplewill_tb->spousestate->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($simplewill_tb->marriagetype->Visible) { // marriagetype ?>
	<tr id="r_marriagetype">
		<td><span id="elh_simplewill_tb_marriagetype"><?php echo $simplewill_tb->marriagetype->FldCaption() ?></span></td>
		<td<?php echo $simplewill_tb->marriagetype->CellAttributes() ?>>
<span id="el_simplewill_tb_marriagetype" class="control-group">
<span<?php echo $simplewill_tb->marriagetype->ViewAttributes() ?>>
<?php echo $simplewill_tb->marriagetype->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($simplewill_tb->marriageyear->Visible) { // marriageyear ?>
	<tr id="r_marriageyear">
		<td><span id="elh_simplewill_tb_marriageyear"><?php echo $simplewill_tb->marriageyear->FldCaption() ?></span></td>
		<td<?php echo $simplewill_tb->marriageyear->CellAttributes() ?>>
<span id="el_simplewill_tb_marriageyear" class="control-group">
<span<?php echo $simplewill_tb->marriageyear->ViewAttributes() ?>>
<?php echo $simplewill_tb->marriageyear->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($simplewill_tb->marriagecert->Visible) { // marriagecert ?>
	<tr id="r_marriagecert">
		<td><span id="elh_simplewill_tb_marriagecert"><?php echo $simplewill_tb->marriagecert->FldCaption() ?></span></td>
		<td<?php echo $simplewill_tb->marriagecert->CellAttributes() ?>>
<span id="el_simplewill_tb_marriagecert" class="control-group">
<span<?php echo $simplewill_tb->marriagecert->ViewAttributes() ?>>
<?php echo $simplewill_tb->marriagecert->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($simplewill_tb->cityofmarriage->Visible) { // cityofmarriage ?>
	<tr id="r_cityofmarriage">
		<td><span id="elh_simplewill_tb_cityofmarriage"><?php echo $simplewill_tb->cityofmarriage->FldCaption() ?></span></td>
		<td<?php echo $simplewill_tb->cityofmarriage->CellAttributes() ?>>
<span id="el_simplewill_tb_cityofmarriage" class="control-group">
<span<?php echo $simplewill_tb->cityofmarriage->ViewAttributes() ?>>
<?php echo $simplewill_tb->cityofmarriage->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($simplewill_tb->countryofmarriage->Visible) { // countryofmarriage ?>
	<tr id="r_countryofmarriage">
		<td><span id="elh_simplewill_tb_countryofmarriage"><?php echo $simplewill_tb->countryofmarriage->FldCaption() ?></span></td>
		<td<?php echo $simplewill_tb->countryofmarriage->CellAttributes() ?>>
<span id="el_simplewill_tb_countryofmarriage" class="control-group">
<span<?php echo $simplewill_tb->countryofmarriage->ViewAttributes() ?>>
<?php echo $simplewill_tb->countryofmarriage->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($simplewill_tb->divorce->Visible) { // divorce ?>
	<tr id="r_divorce">
		<td><span id="elh_simplewill_tb_divorce"><?php echo $simplewill_tb->divorce->FldCaption() ?></span></td>
		<td<?php echo $simplewill_tb->divorce->CellAttributes() ?>>
<span id="el_simplewill_tb_divorce" class="control-group">
<span<?php echo $simplewill_tb->divorce->ViewAttributes() ?>>
<?php echo $simplewill_tb->divorce->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($simplewill_tb->divorceyear->Visible) { // divorceyear ?>
	<tr id="r_divorceyear">
		<td><span id="elh_simplewill_tb_divorceyear"><?php echo $simplewill_tb->divorceyear->FldCaption() ?></span></td>
		<td<?php echo $simplewill_tb->divorceyear->CellAttributes() ?>>
<span id="el_simplewill_tb_divorceyear" class="control-group">
<span<?php echo $simplewill_tb->divorceyear->ViewAttributes() ?>>
<?php echo $simplewill_tb->divorceyear->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($simplewill_tb->nextofkinfullname->Visible) { // nextofkinfullname ?>
	<tr id="r_nextofkinfullname">
		<td><span id="elh_simplewill_tb_nextofkinfullname"><?php echo $simplewill_tb->nextofkinfullname->FldCaption() ?></span></td>
		<td<?php echo $simplewill_tb->nextofkinfullname->CellAttributes() ?>>
<span id="el_simplewill_tb_nextofkinfullname" class="control-group">
<span<?php echo $simplewill_tb->nextofkinfullname->ViewAttributes() ?>>
<?php echo $simplewill_tb->nextofkinfullname->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($simplewill_tb->nextofkintelephone->Visible) { // nextofkintelephone ?>
	<tr id="r_nextofkintelephone">
		<td><span id="elh_simplewill_tb_nextofkintelephone"><?php echo $simplewill_tb->nextofkintelephone->FldCaption() ?></span></td>
		<td<?php echo $simplewill_tb->nextofkintelephone->CellAttributes() ?>>
<span id="el_simplewill_tb_nextofkintelephone" class="control-group">
<span<?php echo $simplewill_tb->nextofkintelephone->ViewAttributes() ?>>
<?php echo $simplewill_tb->nextofkintelephone->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($simplewill_tb->nextofkinemail->Visible) { // nextofkinemail ?>
	<tr id="r_nextofkinemail">
		<td><span id="elh_simplewill_tb_nextofkinemail"><?php echo $simplewill_tb->nextofkinemail->FldCaption() ?></span></td>
		<td<?php echo $simplewill_tb->nextofkinemail->CellAttributes() ?>>
<span id="el_simplewill_tb_nextofkinemail" class="control-group">
<span<?php echo $simplewill_tb->nextofkinemail->ViewAttributes() ?>>
<?php echo $simplewill_tb->nextofkinemail->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($simplewill_tb->nextofkinaddress->Visible) { // nextofkinaddress ?>
	<tr id="r_nextofkinaddress">
		<td><span id="elh_simplewill_tb_nextofkinaddress"><?php echo $simplewill_tb->nextofkinaddress->FldCaption() ?></span></td>
		<td<?php echo $simplewill_tb->nextofkinaddress->CellAttributes() ?>>
<span id="el_simplewill_tb_nextofkinaddress" class="control-group">
<span<?php echo $simplewill_tb->nextofkinaddress->ViewAttributes() ?>>
<?php echo $simplewill_tb->nextofkinaddress->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($simplewill_tb->nameofcompany->Visible) { // nameofcompany ?>
	<tr id="r_nameofcompany">
		<td><span id="elh_simplewill_tb_nameofcompany"><?php echo $simplewill_tb->nameofcompany->FldCaption() ?></span></td>
		<td<?php echo $simplewill_tb->nameofcompany->CellAttributes() ?>>
<span id="el_simplewill_tb_nameofcompany" class="control-group">
<span<?php echo $simplewill_tb->nameofcompany->ViewAttributes() ?>>
<?php echo $simplewill_tb->nameofcompany->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($simplewill_tb->humanresourcescontacttelephone->Visible) { // humanresourcescontacttelephone ?>
	<tr id="r_humanresourcescontacttelephone">
		<td><span id="elh_simplewill_tb_humanresourcescontacttelephone"><?php echo $simplewill_tb->humanresourcescontacttelephone->FldCaption() ?></span></td>
		<td<?php echo $simplewill_tb->humanresourcescontacttelephone->CellAttributes() ?>>
<span id="el_simplewill_tb_humanresourcescontacttelephone" class="control-group">
<span<?php echo $simplewill_tb->humanresourcescontacttelephone->ViewAttributes() ?>>
<?php echo $simplewill_tb->humanresourcescontacttelephone->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($simplewill_tb->humanresourcescontactemailaddress->Visible) { // humanresourcescontactemailaddress ?>
	<tr id="r_humanresourcescontactemailaddress">
		<td><span id="elh_simplewill_tb_humanresourcescontactemailaddress"><?php echo $simplewill_tb->humanresourcescontactemailaddress->FldCaption() ?></span></td>
		<td<?php echo $simplewill_tb->humanresourcescontactemailaddress->CellAttributes() ?>>
<span id="el_simplewill_tb_humanresourcescontactemailaddress" class="control-group">
<span<?php echo $simplewill_tb->humanresourcescontactemailaddress->ViewAttributes() ?>>
<?php echo $simplewill_tb->humanresourcescontactemailaddress->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($simplewill_tb->datecreated->Visible) { // datecreated ?>
	<tr id="r_datecreated">
		<td><span id="elh_simplewill_tb_datecreated"><?php echo $simplewill_tb->datecreated->FldCaption() ?></span></td>
		<td<?php echo $simplewill_tb->datecreated->CellAttributes() ?>>
<span id="el_simplewill_tb_datecreated" class="control-group">
<span<?php echo $simplewill_tb->datecreated->ViewAttributes() ?>>
<?php echo $simplewill_tb->datecreated->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
</table>
</td></tr></table>
<?php if ($simplewill_tb->Export == "") { ?>
<table class="ewPager">
<tr><td>
<?php if (!isset($simplewill_tb_view->Pager)) $simplewill_tb_view->Pager = new cNumericPager($simplewill_tb_view->StartRec, $simplewill_tb_view->DisplayRecs, $simplewill_tb_view->TotalRecs, $simplewill_tb_view->RecRange) ?>
<?php if ($simplewill_tb_view->Pager->RecordCount > 0) { ?>
<table cellspacing="0" class="ewStdTable"><tbody><tr><td>
<div class="pagination"><ul>
	<?php if ($simplewill_tb_view->Pager->FirstButton->Enabled) { ?>
	<li><a href="<?php echo $simplewill_tb_view->PageUrl() ?>start=<?php echo $simplewill_tb_view->Pager->FirstButton->Start ?>"><?php echo $Language->Phrase("PagerFirst") ?></a></li>
	<?php } ?>
	<?php if ($simplewill_tb_view->Pager->PrevButton->Enabled) { ?>
	<li><a href="<?php echo $simplewill_tb_view->PageUrl() ?>start=<?php echo $simplewill_tb_view->Pager->PrevButton->Start ?>"><?php echo $Language->Phrase("PagerPrevious") ?></a></li>
	<?php } ?>
	<?php foreach ($simplewill_tb_view->Pager->Items as $PagerItem) { ?>
		<li<?php if (!$PagerItem->Enabled) { echo " class=\" active\""; } ?>><a href="<?php if ($PagerItem->Enabled) { echo $simplewill_tb_view->PageUrl() . "start=" . $PagerItem->Start; } else { echo "#"; } ?>"><?php echo $PagerItem->Text ?></a></li>
	<?php } ?>
	<?php if ($simplewill_tb_view->Pager->NextButton->Enabled) { ?>
	<li><a href="<?php echo $simplewill_tb_view->PageUrl() ?>start=<?php echo $simplewill_tb_view->Pager->NextButton->Start ?>"><?php echo $Language->Phrase("PagerNext") ?></a></li>
	<?php } ?>
	<?php if ($simplewill_tb_view->Pager->LastButton->Enabled) { ?>
	<li><a href="<?php echo $simplewill_tb_view->PageUrl() ?>start=<?php echo $simplewill_tb_view->Pager->LastButton->Start ?>"><?php echo $Language->Phrase("PagerLast") ?></a></li>
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
<?php
	if (in_array("simplewill_assets_tb", explode(",", $simplewill_tb->getCurrentDetailTable())) && $simplewill_assets_tb->DetailView) {
?>
<?php include_once "simplewill_assets_tbgrid.php" ?>
<?php } ?>
<?php
	if (in_array("simplewill_overall_asset", explode(",", $simplewill_tb->getCurrentDetailTable())) && $simplewill_overall_asset->DetailView) {
?>
<?php include_once "simplewill_overall_assetgrid.php" ?>
<?php } ?>
</form>
<script type="text/javascript">
fsimplewill_tbview.Init();
</script>
<?php
$simplewill_tb_view->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<?php if ($simplewill_tb->Export == "") { ?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php } ?>
<?php include_once "footer.php" ?>
<?php
$simplewill_tb_view->Page_Terminate();
?>
