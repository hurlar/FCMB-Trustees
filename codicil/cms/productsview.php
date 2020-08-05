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

$products_view = NULL; // Initialize page object first

class cproducts_view extends cproducts {

	// Page ID
	var $PageID = 'view';

	// Project ID
	var $ProjectID = "{D9B361E7-B2C1-4293-B9B3-B581986A15CC}";

	// Table name
	var $TableName = 'products';

	// Page object name
	var $PageObjName = 'products_view';

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
			define("EW_TABLE_NAME", 'products', TRUE);

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
						$this->Page_Terminate("productslist.php"); // Return to list page
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
						$sReturnUrl = "productslist.php"; // No matching record, return to list
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
			$sReturnUrl = "productslist.php"; // Not page request, return to list
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

			// product_desc
			$this->product_desc->ViewValue = $this->product_desc->CurrentValue;
			$this->product_desc->ViewCustomAttributes = "";

			// product_img_name
			$this->product_img_name->ViewValue = $this->product_img_name->CurrentValue;
			$this->product_img_name->ViewCustomAttributes = "";

			// img1
			$this->img1->ViewValue = $this->img1->CurrentValue;
			$this->img1->ViewCustomAttributes = "";

			// cat
			$this->cat->ViewValue = $this->cat->CurrentValue;
			$this->cat->ViewCustomAttributes = "";

			// sized
			$this->sized->ViewValue = $this->sized->CurrentValue;
			$this->sized->ViewCustomAttributes = "";

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

			// id
			$this->id->LinkCustomAttributes = "";
			$this->id->HrefValue = "";
			$this->id->TooltipValue = "";

			// price
			$this->price->LinkCustomAttributes = "";
			$this->price->HrefValue = "";
			$this->price->TooltipValue = "";

			// img2
			$this->img2->LinkCustomAttributes = "";
			$this->img2->UploadPath = "../uploads/products/";
			if (!ew_Empty($this->img2->Upload->DbValue)) {
				$this->img2->HrefValue = ew_UploadPathEx(FALSE, $this->img2->UploadPath) . $this->img2->Upload->DbValue; // Add prefix/suffix
				$this->img2->LinkAttrs["target"] = ""; // Add target
				if ($this->Export <> "") $this->img2->HrefValue = ew_ConvertFullUrl($this->img2->HrefValue);
			} else {
				$this->img2->HrefValue = "";
			}
			$this->img2->HrefValue2 = $this->img2->UploadPath . $this->img2->Upload->DbValue;
			$this->img2->TooltipValue = "";

			// img3
			$this->img3->LinkCustomAttributes = "";
			$this->img3->UploadPath = "../uploads/products/";
			if (!ew_Empty($this->img3->Upload->DbValue)) {
				$this->img3->HrefValue = ew_UploadPathEx(FALSE, $this->img3->UploadPath) . $this->img3->Upload->DbValue; // Add prefix/suffix
				$this->img3->LinkAttrs["target"] = ""; // Add target
				if ($this->Export <> "") $this->img3->HrefValue = ew_ConvertFullUrl($this->img3->HrefValue);
			} else {
				$this->img3->HrefValue = "";
			}
			$this->img3->HrefValue2 = $this->img3->UploadPath . $this->img3->Upload->DbValue;
			$this->img3->TooltipValue = "";

			// img4
			$this->img4->LinkCustomAttributes = "";
			$this->img4->UploadPath = "../uploads/products/";
			if (!ew_Empty($this->img4->Upload->DbValue)) {
				$this->img4->HrefValue = ew_UploadPathEx(FALSE, $this->img4->UploadPath) . $this->img4->Upload->DbValue; // Add prefix/suffix
				$this->img4->LinkAttrs["target"] = ""; // Add target
				if ($this->Export <> "") $this->img4->HrefValue = ew_ConvertFullUrl($this->img4->HrefValue);
			} else {
				$this->img4->HrefValue = "";
			}
			$this->img4->HrefValue2 = $this->img4->UploadPath . $this->img4->Upload->DbValue;
			$this->img4->TooltipValue = "";

			// rate_ord
			$this->rate_ord->LinkCustomAttributes = "";
			$this->rate_ord->HrefValue = "";
			$this->rate_ord->TooltipValue = "";

			// datep
			$this->datep->LinkCustomAttributes = "";
			$this->datep->HrefValue = "";
			$this->datep->TooltipValue = "";

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

			// product_desc
			$this->product_desc->LinkCustomAttributes = "";
			$this->product_desc->HrefValue = "";
			$this->product_desc->TooltipValue = "";

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

			// sized
			$this->sized->LinkCustomAttributes = "";
			$this->sized->HrefValue = "";
			$this->sized->TooltipValue = "";

			// subcat
			$this->subcat->LinkCustomAttributes = "";
			$this->subcat->HrefValue = "";
			$this->subcat->TooltipValue = "";

			// sales_status
			$this->sales_status->LinkCustomAttributes = "";
			$this->sales_status->HrefValue = "";
			$this->sales_status->TooltipValue = "";
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
		$item->Body = "<a id=\"emf_products\" href=\"javascript:void(0);\" class=\"ewExportLink ewEmail\" data-caption=\"" . $Language->Phrase("ExportToEmailText") . "\" onclick=\"ew_EmailDialogShow({lnk:'emf_products',hdr:ewLanguage.Phrase('ExportToEmail'),f:document.fproductsview,key:" . ew_ArrayToJsonAttr($this->RecKey) . ",sel:false});\">" . $Language->Phrase("ExportToEmail") . "</a>";
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
		$Breadcrumb->Add("list", "<span id=\"ewPageCaption\">" . $PageCaption . "</span>", "productslist.php", $this->TableVar);
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
if (!isset($products_view)) $products_view = new cproducts_view();

// Page init
$products_view->Page_Init();

// Page main
$products_view->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$products_view->Page_Render();
?>
<?php include_once "header.php" ?>
<?php if ($products->Export == "") { ?>
<script type="text/javascript">

// Page object
var products_view = new ew_Page("products_view");
products_view.PageID = "view"; // Page ID
var EW_PAGE_ID = products_view.PageID; // For backward compatibility

// Form object
var fproductsview = new ew_Form("fproductsview");

// Form_CustomValidate event
fproductsview.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
fproductsview.ValidateRequired = true;
<?php } else { ?>
fproductsview.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
// Form object for search

</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<?php } ?>
<?php if ($products->Export == "") { ?>
<?php $Breadcrumb->Render(); ?>
<?php } ?>
<?php if ($products->Export == "") { ?>
<div class="ewViewExportOptions">
<?php $products_view->ExportOptions->Render("body") ?>
<?php if (!$products_view->ExportOptions->UseDropDownButton) { ?>
</div>
<div class="ewViewOtherOptions">
<?php } ?>
<?php
	foreach ($products_view->OtherOptions as &$option)
		$option->Render("body");
?>
</div>
<?php } ?>
<?php $products_view->ShowPageHeader(); ?>
<?php
$products_view->ShowMessage();
?>
<form name="fproductsview" id="fproductsview" class="ewForm form-horizontal" action="<?php echo ew_CurrentPage() ?>" method="post">
<input type="hidden" name="t" value="products">
<table cellspacing="0" class="ewGrid"><tr><td>
<table id="tbl_productsview" class="table table-bordered table-striped">
<?php if ($products->id->Visible) { // id ?>
	<tr id="r_id">
		<td><span id="elh_products_id"><?php echo $products->id->FldCaption() ?></span></td>
		<td<?php echo $products->id->CellAttributes() ?>>
<span id="el_products_id" class="control-group">
<span<?php echo $products->id->ViewAttributes() ?>>
<?php echo $products->id->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($products->price->Visible) { // price ?>
	<tr id="r_price">
		<td><span id="elh_products_price"><?php echo $products->price->FldCaption() ?></span></td>
		<td<?php echo $products->price->CellAttributes() ?>>
<span id="el_products_price" class="control-group">
<span<?php echo $products->price->ViewAttributes() ?>>
<?php echo $products->price->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($products->img2->Visible) { // img2 ?>
	<tr id="r_img2">
		<td><span id="elh_products_img2"><?php echo $products->img2->FldCaption() ?></span></td>
		<td<?php echo $products->img2->CellAttributes() ?>>
<span id="el_products_img2" class="control-group">
<span<?php echo $products->img2->ViewAttributes() ?>>
<?php if ($products->img2->LinkAttributes() <> "") { ?>
<?php if (!empty($products->img2->Upload->DbValue)) { ?>
<a<?php echo $products->img2->LinkAttributes() ?>><?php echo $products->img2->ViewValue ?></a>
<?php } elseif (!in_array($products->CurrentAction, array("I", "edit", "gridedit"))) { ?>	
&nbsp;
<?php } ?>
<?php } else { ?>
<?php if (!empty($products->img2->Upload->DbValue)) { ?>
<?php echo $products->img2->ViewValue ?>
<?php } elseif (!in_array($products->CurrentAction, array("I", "edit", "gridedit"))) { ?>	
&nbsp;
<?php } ?>
<?php } ?>
</span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($products->img3->Visible) { // img3 ?>
	<tr id="r_img3">
		<td><span id="elh_products_img3"><?php echo $products->img3->FldCaption() ?></span></td>
		<td<?php echo $products->img3->CellAttributes() ?>>
<span id="el_products_img3" class="control-group">
<span<?php echo $products->img3->ViewAttributes() ?>>
<?php if ($products->img3->LinkAttributes() <> "") { ?>
<?php if (!empty($products->img3->Upload->DbValue)) { ?>
<a<?php echo $products->img3->LinkAttributes() ?>><?php echo $products->img3->ViewValue ?></a>
<?php } elseif (!in_array($products->CurrentAction, array("I", "edit", "gridedit"))) { ?>	
&nbsp;
<?php } ?>
<?php } else { ?>
<?php if (!empty($products->img3->Upload->DbValue)) { ?>
<?php echo $products->img3->ViewValue ?>
<?php } elseif (!in_array($products->CurrentAction, array("I", "edit", "gridedit"))) { ?>	
&nbsp;
<?php } ?>
<?php } ?>
</span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($products->img4->Visible) { // img4 ?>
	<tr id="r_img4">
		<td><span id="elh_products_img4"><?php echo $products->img4->FldCaption() ?></span></td>
		<td<?php echo $products->img4->CellAttributes() ?>>
<span id="el_products_img4" class="control-group">
<span<?php echo $products->img4->ViewAttributes() ?>>
<?php if ($products->img4->LinkAttributes() <> "") { ?>
<?php if (!empty($products->img4->Upload->DbValue)) { ?>
<a<?php echo $products->img4->LinkAttributes() ?>><?php echo $products->img4->ViewValue ?></a>
<?php } elseif (!in_array($products->CurrentAction, array("I", "edit", "gridedit"))) { ?>	
&nbsp;
<?php } ?>
<?php } else { ?>
<?php if (!empty($products->img4->Upload->DbValue)) { ?>
<?php echo $products->img4->ViewValue ?>
<?php } elseif (!in_array($products->CurrentAction, array("I", "edit", "gridedit"))) { ?>	
&nbsp;
<?php } ?>
<?php } ?>
</span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($products->rate_ord->Visible) { // rate_ord ?>
	<tr id="r_rate_ord">
		<td><span id="elh_products_rate_ord"><?php echo $products->rate_ord->FldCaption() ?></span></td>
		<td<?php echo $products->rate_ord->CellAttributes() ?>>
<span id="el_products_rate_ord" class="control-group">
<span<?php echo $products->rate_ord->ViewAttributes() ?>>
<?php echo $products->rate_ord->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($products->datep->Visible) { // datep ?>
	<tr id="r_datep">
		<td><span id="elh_products_datep"><?php echo $products->datep->FldCaption() ?></span></td>
		<td<?php echo $products->datep->CellAttributes() ?>>
<span id="el_products_datep" class="control-group">
<span<?php echo $products->datep->ViewAttributes() ?>>
<?php echo $products->datep->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($products->oldprice->Visible) { // oldprice ?>
	<tr id="r_oldprice">
		<td><span id="elh_products_oldprice"><?php echo $products->oldprice->FldCaption() ?></span></td>
		<td<?php echo $products->oldprice->CellAttributes() ?>>
<span id="el_products_oldprice" class="control-group">
<span<?php echo $products->oldprice->ViewAttributes() ?>>
<?php echo $products->oldprice->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($products->product_code->Visible) { // product_code ?>
	<tr id="r_product_code">
		<td><span id="elh_products_product_code"><?php echo $products->product_code->FldCaption() ?></span></td>
		<td<?php echo $products->product_code->CellAttributes() ?>>
<span id="el_products_product_code" class="control-group">
<span<?php echo $products->product_code->ViewAttributes() ?>>
<?php echo $products->product_code->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($products->product_name->Visible) { // product_name ?>
	<tr id="r_product_name">
		<td><span id="elh_products_product_name"><?php echo $products->product_name->FldCaption() ?></span></td>
		<td<?php echo $products->product_name->CellAttributes() ?>>
<span id="el_products_product_name" class="control-group">
<span<?php echo $products->product_name->ViewAttributes() ?>>
<?php echo $products->product_name->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($products->product_desc->Visible) { // product_desc ?>
	<tr id="r_product_desc">
		<td><span id="elh_products_product_desc"><?php echo $products->product_desc->FldCaption() ?></span></td>
		<td<?php echo $products->product_desc->CellAttributes() ?>>
<span id="el_products_product_desc" class="control-group">
<span<?php echo $products->product_desc->ViewAttributes() ?>>
<?php echo $products->product_desc->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($products->product_img_name->Visible) { // product_img_name ?>
	<tr id="r_product_img_name">
		<td><span id="elh_products_product_img_name"><?php echo $products->product_img_name->FldCaption() ?></span></td>
		<td<?php echo $products->product_img_name->CellAttributes() ?>>
<span id="el_products_product_img_name" class="control-group">
<span<?php echo $products->product_img_name->ViewAttributes() ?>>
<?php echo $products->product_img_name->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($products->img1->Visible) { // img1 ?>
	<tr id="r_img1">
		<td><span id="elh_products_img1"><?php echo $products->img1->FldCaption() ?></span></td>
		<td<?php echo $products->img1->CellAttributes() ?>>
<span id="el_products_img1" class="control-group">
<span<?php echo $products->img1->ViewAttributes() ?>>
<?php echo $products->img1->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($products->cat->Visible) { // cat ?>
	<tr id="r_cat">
		<td><span id="elh_products_cat"><?php echo $products->cat->FldCaption() ?></span></td>
		<td<?php echo $products->cat->CellAttributes() ?>>
<span id="el_products_cat" class="control-group">
<span<?php echo $products->cat->ViewAttributes() ?>>
<?php echo $products->cat->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($products->sized->Visible) { // sized ?>
	<tr id="r_sized">
		<td><span id="elh_products_sized"><?php echo $products->sized->FldCaption() ?></span></td>
		<td<?php echo $products->sized->CellAttributes() ?>>
<span id="el_products_sized" class="control-group">
<span<?php echo $products->sized->ViewAttributes() ?>>
<?php echo $products->sized->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($products->subcat->Visible) { // subcat ?>
	<tr id="r_subcat">
		<td><span id="elh_products_subcat"><?php echo $products->subcat->FldCaption() ?></span></td>
		<td<?php echo $products->subcat->CellAttributes() ?>>
<span id="el_products_subcat" class="control-group">
<span<?php echo $products->subcat->ViewAttributes() ?>>
<?php echo $products->subcat->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($products->sales_status->Visible) { // sales_status ?>
	<tr id="r_sales_status">
		<td><span id="elh_products_sales_status"><?php echo $products->sales_status->FldCaption() ?></span></td>
		<td<?php echo $products->sales_status->CellAttributes() ?>>
<span id="el_products_sales_status" class="control-group">
<span<?php echo $products->sales_status->ViewAttributes() ?>>
<?php echo $products->sales_status->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
</table>
</td></tr></table>
<?php if ($products->Export == "") { ?>
<table class="ewPager">
<tr><td>
<?php if (!isset($products_view->Pager)) $products_view->Pager = new cNumericPager($products_view->StartRec, $products_view->DisplayRecs, $products_view->TotalRecs, $products_view->RecRange) ?>
<?php if ($products_view->Pager->RecordCount > 0) { ?>
<table cellspacing="0" class="ewStdTable"><tbody><tr><td>
<div class="pagination"><ul>
	<?php if ($products_view->Pager->FirstButton->Enabled) { ?>
	<li><a href="<?php echo $products_view->PageUrl() ?>start=<?php echo $products_view->Pager->FirstButton->Start ?>"><?php echo $Language->Phrase("PagerFirst") ?></a></li>
	<?php } ?>
	<?php if ($products_view->Pager->PrevButton->Enabled) { ?>
	<li><a href="<?php echo $products_view->PageUrl() ?>start=<?php echo $products_view->Pager->PrevButton->Start ?>"><?php echo $Language->Phrase("PagerPrevious") ?></a></li>
	<?php } ?>
	<?php foreach ($products_view->Pager->Items as $PagerItem) { ?>
		<li<?php if (!$PagerItem->Enabled) { echo " class=\" active\""; } ?>><a href="<?php if ($PagerItem->Enabled) { echo $products_view->PageUrl() . "start=" . $PagerItem->Start; } else { echo "#"; } ?>"><?php echo $PagerItem->Text ?></a></li>
	<?php } ?>
	<?php if ($products_view->Pager->NextButton->Enabled) { ?>
	<li><a href="<?php echo $products_view->PageUrl() ?>start=<?php echo $products_view->Pager->NextButton->Start ?>"><?php echo $Language->Phrase("PagerNext") ?></a></li>
	<?php } ?>
	<?php if ($products_view->Pager->LastButton->Enabled) { ?>
	<li><a href="<?php echo $products_view->PageUrl() ?>start=<?php echo $products_view->Pager->LastButton->Start ?>"><?php echo $Language->Phrase("PagerLast") ?></a></li>
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
fproductsview.Init();
</script>
<?php
$products_view->ShowPageFooter();
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
$products_view->Page_Terminate();
?>
