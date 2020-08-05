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

$products_edit = NULL; // Initialize page object first

class cproducts_edit extends cproducts {

	// Page ID
	var $PageID = 'edit';

	// Project ID
	var $ProjectID = "{D9B361E7-B2C1-4293-B9B3-B581986A15CC}";

	// Table name
	var $TableName = 'products';

	// Page object name
	var $PageObjName = 'products_edit';

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

		// Table object (adminusers)
		if (!isset($GLOBALS['adminusers'])) $GLOBALS['adminusers'] = new cadminusers();

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'edit', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'products', TRUE);

		// Start timer
		if (!isset($GLOBALS["gTimer"])) $GLOBALS["gTimer"] = new cTimer();

		// Open connection
		if (!isset($conn)) $conn = ew_Connect();
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
		$this->CurrentAction = (@$_GET["a"] <> "") ? $_GET["a"] : @$_POST["a_list"]; // Set up curent action
		$this->id->Visible = !$this->IsAdd() && !$this->IsCopy() && !$this->IsGridAdd();

		// Global Page Loading event (in userfn*.php)
		Page_Loading();

		// Page Load event
		$this->Page_Load();
	}

	//
	// Page_Terminate
	//
	function Page_Terminate($url = "") {
		global $conn;

		// Page Unload event
		$this->Page_Unload();

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
	var $DbMasterFilter;
	var $DbDetailFilter;
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
		global $objForm, $Language, $gsFormError;

		// Load current record
		$bLoadCurrentRecord = FALSE;
		$sReturnUrl = "";
		$bMatchRecord = FALSE;

		// Load key from QueryString
		if (@$_GET["id"] <> "") {
			$this->id->setQueryStringValue($_GET["id"]);
			$this->RecKey["id"] = $this->id->QueryStringValue;
		} else {
			$bLoadCurrentRecord = TRUE;
		}

		// Set up Breadcrumb
		$this->SetupBreadcrumb();

		// Load recordset
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

		// Process form if post back
		if (@$_POST["a_edit"] <> "") {
			$this->CurrentAction = $_POST["a_edit"]; // Get action code
			$this->LoadFormValues(); // Get form values
		} else {
			$this->CurrentAction = "I"; // Default action is display
		}

		// Validate form if post back
		if (@$_POST["a_edit"] <> "") {
			if (!$this->ValidateForm()) {
				$this->CurrentAction = ""; // Form error, reset action
				$this->setFailureMessage($gsFormError);
				$this->EventCancelled = TRUE; // Event cancelled
				$this->RestoreFormValues();
			}
		}
		switch ($this->CurrentAction) {
			case "I": // Get a record to display
				if (!$bMatchRecord) {
					if ($this->getSuccessMessage() == "" && $this->getFailureMessage() == "")
						$this->setFailureMessage($Language->Phrase("NoRecord")); // Set no record message
					$this->Page_Terminate("productslist.php"); // Return to list page
				} else {
					$this->LoadRowValues($this->Recordset); // Load row values
				}
				break;
			Case "U": // Update
				$this->SendEmail = TRUE; // Send email on update success
				if ($this->EditRow()) { // Update record based on key
					if ($this->getSuccessMessage() == "")
						$this->setSuccessMessage($Language->Phrase("UpdateSuccess")); // Update success
					$sReturnUrl = $this->getReturnUrl();
					if (ew_GetPageName($sReturnUrl) == "productsview.php")
						$sReturnUrl = $this->GetViewUrl(); // View paging, return to View page directly
					$this->Page_Terminate($sReturnUrl); // Return to caller
				} else {
					$this->EventCancelled = TRUE; // Event cancelled
					$this->RestoreFormValues(); // Restore form values if update failed
				}
		}

		// Render the record
		$this->RowType = EW_ROWTYPE_EDIT; // Render as Edit
		$this->ResetAttrs();
		$this->RenderRow();
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

	// Get upload files
	function GetUploadFiles() {
		global $objForm;

		// Get upload data
		$this->img2->Upload->Index = $objForm->Index;
		if ($this->img2->Upload->UploadFile()) {

			// No action required
		} else {
			echo $this->img2->Upload->Message;
			$this->Page_Terminate();
			exit();
		}
		$this->img2->CurrentValue = $this->img2->Upload->FileName;
		$this->img3->Upload->Index = $objForm->Index;
		if ($this->img3->Upload->UploadFile()) {

			// No action required
		} else {
			echo $this->img3->Upload->Message;
			$this->Page_Terminate();
			exit();
		}
		$this->img3->CurrentValue = $this->img3->Upload->FileName;
		$this->img4->Upload->Index = $objForm->Index;
		if ($this->img4->Upload->UploadFile()) {

			// No action required
		} else {
			echo $this->img4->Upload->Message;
			$this->Page_Terminate();
			exit();
		}
		$this->img4->CurrentValue = $this->img4->Upload->FileName;
	}

	// Load form values
	function LoadFormValues() {

		// Load from form
		global $objForm;
		$this->GetUploadFiles(); // Get upload files
		if (!$this->id->FldIsDetailKey)
			$this->id->setFormValue($objForm->GetValue("x_id"));
		if (!$this->price->FldIsDetailKey) {
			$this->price->setFormValue($objForm->GetValue("x_price"));
		}
		if (!$this->rate_ord->FldIsDetailKey) {
			$this->rate_ord->setFormValue($objForm->GetValue("x_rate_ord"));
		}
		if (!$this->oldprice->FldIsDetailKey) {
			$this->oldprice->setFormValue($objForm->GetValue("x_oldprice"));
		}
		if (!$this->product_code->FldIsDetailKey) {
			$this->product_code->setFormValue($objForm->GetValue("x_product_code"));
		}
		if (!$this->product_name->FldIsDetailKey) {
			$this->product_name->setFormValue($objForm->GetValue("x_product_name"));
		}
		if (!$this->product_desc->FldIsDetailKey) {
			$this->product_desc->setFormValue($objForm->GetValue("x_product_desc"));
		}
		if (!$this->product_img_name->FldIsDetailKey) {
			$this->product_img_name->setFormValue($objForm->GetValue("x_product_img_name"));
		}
		if (!$this->img1->FldIsDetailKey) {
			$this->img1->setFormValue($objForm->GetValue("x_img1"));
		}
		if (!$this->cat->FldIsDetailKey) {
			$this->cat->setFormValue($objForm->GetValue("x_cat"));
		}
		if (!$this->sized->FldIsDetailKey) {
			$this->sized->setFormValue($objForm->GetValue("x_sized"));
		}
		if (!$this->subcat->FldIsDetailKey) {
			$this->subcat->setFormValue($objForm->GetValue("x_subcat"));
		}
		if (!$this->sales_status->FldIsDetailKey) {
			$this->sales_status->setFormValue($objForm->GetValue("x_sales_status"));
		}
	}

	// Restore form values
	function RestoreFormValues() {
		global $objForm;
		$this->LoadRow();
		$this->id->CurrentValue = $this->id->FormValue;
		$this->price->CurrentValue = $this->price->FormValue;
		$this->rate_ord->CurrentValue = $this->rate_ord->FormValue;
		$this->oldprice->CurrentValue = $this->oldprice->FormValue;
		$this->product_code->CurrentValue = $this->product_code->FormValue;
		$this->product_name->CurrentValue = $this->product_name->FormValue;
		$this->product_desc->CurrentValue = $this->product_desc->FormValue;
		$this->product_img_name->CurrentValue = $this->product_img_name->FormValue;
		$this->img1->CurrentValue = $this->img1->FormValue;
		$this->cat->CurrentValue = $this->cat->FormValue;
		$this->sized->CurrentValue = $this->sized->FormValue;
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

	// Render row values based on field settings
	function RenderRow() {
		global $conn, $Security, $Language;
		global $gsLanguage;

		// Initialize URLs
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
		} elseif ($this->RowType == EW_ROWTYPE_EDIT) { // Edit row

			// id
			$this->id->EditCustomAttributes = "";
			$this->id->EditValue = $this->id->CurrentValue;
			$this->id->ViewCustomAttributes = "";

			// price
			$this->price->EditCustomAttributes = "";
			$this->price->EditValue = ew_HtmlEncode($this->price->CurrentValue);
			$this->price->PlaceHolder = ew_HtmlEncode(ew_RemoveHtml($this->price->FldCaption()));
			if (strval($this->price->EditValue) <> "" && is_numeric($this->price->EditValue)) $this->price->EditValue = ew_FormatNumber($this->price->EditValue, -2, -2, -2, -2);

			// img2
			$this->img2->EditCustomAttributes = "";
			$this->img2->UploadPath = "../uploads/products/";
			if (!ew_Empty($this->img2->Upload->DbValue)) {
				$this->img2->EditValue = $this->img2->Upload->DbValue;
			} else {
				$this->img2->EditValue = "";
			}
			if ($this->CurrentAction == "I" && !$this->EventCancelled) ew_RenderUploadField($this->img2);

			// img3
			$this->img3->EditCustomAttributes = "";
			$this->img3->UploadPath = "../uploads/products/";
			if (!ew_Empty($this->img3->Upload->DbValue)) {
				$this->img3->EditValue = $this->img3->Upload->DbValue;
			} else {
				$this->img3->EditValue = "";
			}
			if ($this->CurrentAction == "I" && !$this->EventCancelled) ew_RenderUploadField($this->img3);

			// img4
			$this->img4->EditCustomAttributes = "";
			$this->img4->UploadPath = "../uploads/products/";
			if (!ew_Empty($this->img4->Upload->DbValue)) {
				$this->img4->EditValue = $this->img4->Upload->DbValue;
			} else {
				$this->img4->EditValue = "";
			}
			if ($this->CurrentAction == "I" && !$this->EventCancelled) ew_RenderUploadField($this->img4);

			// rate_ord
			$this->rate_ord->EditCustomAttributes = "";
			$arwrk = array();
			$arwrk[] = array($this->rate_ord->FldTagValue(1), $this->rate_ord->FldTagCaption(1) <> "" ? $this->rate_ord->FldTagCaption(1) : $this->rate_ord->FldTagValue(1));
			$arwrk[] = array($this->rate_ord->FldTagValue(2), $this->rate_ord->FldTagCaption(2) <> "" ? $this->rate_ord->FldTagCaption(2) : $this->rate_ord->FldTagValue(2));
			$arwrk[] = array($this->rate_ord->FldTagValue(3), $this->rate_ord->FldTagCaption(3) <> "" ? $this->rate_ord->FldTagCaption(3) : $this->rate_ord->FldTagValue(3));
			$arwrk[] = array($this->rate_ord->FldTagValue(4), $this->rate_ord->FldTagCaption(4) <> "" ? $this->rate_ord->FldTagCaption(4) : $this->rate_ord->FldTagValue(4));
			$arwrk[] = array($this->rate_ord->FldTagValue(5), $this->rate_ord->FldTagCaption(5) <> "" ? $this->rate_ord->FldTagCaption(5) : $this->rate_ord->FldTagValue(5));
			$arwrk[] = array($this->rate_ord->FldTagValue(6), $this->rate_ord->FldTagCaption(6) <> "" ? $this->rate_ord->FldTagCaption(6) : $this->rate_ord->FldTagValue(6));
			$arwrk[] = array($this->rate_ord->FldTagValue(7), $this->rate_ord->FldTagCaption(7) <> "" ? $this->rate_ord->FldTagCaption(7) : $this->rate_ord->FldTagValue(7));
			$arwrk[] = array($this->rate_ord->FldTagValue(8), $this->rate_ord->FldTagCaption(8) <> "" ? $this->rate_ord->FldTagCaption(8) : $this->rate_ord->FldTagValue(8));
			$arwrk[] = array($this->rate_ord->FldTagValue(9), $this->rate_ord->FldTagCaption(9) <> "" ? $this->rate_ord->FldTagCaption(9) : $this->rate_ord->FldTagValue(9));
			$arwrk[] = array($this->rate_ord->FldTagValue(10), $this->rate_ord->FldTagCaption(10) <> "" ? $this->rate_ord->FldTagCaption(10) : $this->rate_ord->FldTagValue(10));
			$arwrk[] = array($this->rate_ord->FldTagValue(11), $this->rate_ord->FldTagCaption(11) <> "" ? $this->rate_ord->FldTagCaption(11) : $this->rate_ord->FldTagValue(11));
			array_unshift($arwrk, array("", $Language->Phrase("PleaseSelect")));
			$this->rate_ord->EditValue = $arwrk;

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

			// product_desc
			$this->product_desc->EditCustomAttributes = "";
			$this->product_desc->EditValue = $this->product_desc->CurrentValue;
			$this->product_desc->PlaceHolder = ew_HtmlEncode(ew_RemoveHtml($this->product_desc->FldCaption()));

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

			// sized
			$this->sized->EditCustomAttributes = "";
			$this->sized->EditValue = $this->sized->CurrentValue;
			$this->sized->PlaceHolder = ew_HtmlEncode(ew_RemoveHtml($this->sized->FldCaption()));

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
			// id

			$this->id->HrefValue = "";

			// price
			$this->price->HrefValue = "";

			// img2
			$this->img2->UploadPath = "../uploads/products/";
			if (!ew_Empty($this->img2->Upload->DbValue)) {
				$this->img2->HrefValue = ew_UploadPathEx(FALSE, $this->img2->UploadPath) . $this->img2->Upload->DbValue; // Add prefix/suffix
				$this->img2->LinkAttrs["target"] = ""; // Add target
				if ($this->Export <> "") $this->img2->HrefValue = ew_ConvertFullUrl($this->img2->HrefValue);
			} else {
				$this->img2->HrefValue = "";
			}
			$this->img2->HrefValue2 = $this->img2->UploadPath . $this->img2->Upload->DbValue;

			// img3
			$this->img3->UploadPath = "../uploads/products/";
			if (!ew_Empty($this->img3->Upload->DbValue)) {
				$this->img3->HrefValue = ew_UploadPathEx(FALSE, $this->img3->UploadPath) . $this->img3->Upload->DbValue; // Add prefix/suffix
				$this->img3->LinkAttrs["target"] = ""; // Add target
				if ($this->Export <> "") $this->img3->HrefValue = ew_ConvertFullUrl($this->img3->HrefValue);
			} else {
				$this->img3->HrefValue = "";
			}
			$this->img3->HrefValue2 = $this->img3->UploadPath . $this->img3->Upload->DbValue;

			// img4
			$this->img4->UploadPath = "../uploads/products/";
			if (!ew_Empty($this->img4->Upload->DbValue)) {
				$this->img4->HrefValue = ew_UploadPathEx(FALSE, $this->img4->UploadPath) . $this->img4->Upload->DbValue; // Add prefix/suffix
				$this->img4->LinkAttrs["target"] = ""; // Add target
				if ($this->Export <> "") $this->img4->HrefValue = ew_ConvertFullUrl($this->img4->HrefValue);
			} else {
				$this->img4->HrefValue = "";
			}
			$this->img4->HrefValue2 = $this->img4->UploadPath . $this->img4->Upload->DbValue;

			// rate_ord
			$this->rate_ord->HrefValue = "";

			// oldprice
			$this->oldprice->HrefValue = "";

			// product_code
			$this->product_code->HrefValue = "";

			// product_name
			$this->product_name->HrefValue = "";

			// product_desc
			$this->product_desc->HrefValue = "";

			// product_img_name
			$this->product_img_name->HrefValue = "";

			// img1
			$this->img1->HrefValue = "";

			// cat
			$this->cat->HrefValue = "";

			// sized
			$this->sized->HrefValue = "";

			// subcat
			$this->subcat->HrefValue = "";

			// sales_status
			$this->sales_status->HrefValue = "";
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
		if (!$this->price->FldIsDetailKey && !is_null($this->price->FormValue) && $this->price->FormValue == "") {
			ew_AddMessage($gsFormError, $Language->Phrase("EnterRequiredField") . " - " . $this->price->FldCaption());
		}
		if (!ew_CheckNumber($this->price->FormValue)) {
			ew_AddMessage($gsFormError, $this->price->FldErrMsg());
		}
		if (!$this->rate_ord->FldIsDetailKey && !is_null($this->rate_ord->FormValue) && $this->rate_ord->FormValue == "") {
			ew_AddMessage($gsFormError, $Language->Phrase("EnterRequiredField") . " - " . $this->rate_ord->FldCaption());
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
		if (!$this->product_desc->FldIsDetailKey && !is_null($this->product_desc->FormValue) && $this->product_desc->FormValue == "") {
			ew_AddMessage($gsFormError, $Language->Phrase("EnterRequiredField") . " - " . $this->product_desc->FldCaption());
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

			// img2
			if (!($this->img2->ReadOnly) && !$this->img2->Upload->KeepFile) {
				$this->img2->Upload->DbValue = $rs->fields('img2'); // Get original value
				if ($this->img2->Upload->FileName == "") {
					$rsnew['img2'] = NULL;
				} else {
					$rsnew['img2'] = $this->img2->Upload->FileName;
				}
			}

			// img3
			if (!($this->img3->ReadOnly) && !$this->img3->Upload->KeepFile) {
				$this->img3->Upload->DbValue = $rs->fields('img3'); // Get original value
				if ($this->img3->Upload->FileName == "") {
					$rsnew['img3'] = NULL;
				} else {
					$rsnew['img3'] = $this->img3->Upload->FileName;
				}
			}

			// img4
			if (!($this->img4->ReadOnly) && !$this->img4->Upload->KeepFile) {
				$this->img4->Upload->DbValue = $rs->fields('img4'); // Get original value
				if ($this->img4->Upload->FileName == "") {
					$rsnew['img4'] = NULL;
				} else {
					$rsnew['img4'] = $this->img4->Upload->FileName;
				}
			}

			// rate_ord
			$this->rate_ord->SetDbValueDef($rsnew, $this->rate_ord->CurrentValue, "", $this->rate_ord->ReadOnly);

			// oldprice
			$this->oldprice->SetDbValueDef($rsnew, $this->oldprice->CurrentValue, NULL, $this->oldprice->ReadOnly);

			// product_code
			$this->product_code->SetDbValueDef($rsnew, $this->product_code->CurrentValue, "", $this->product_code->ReadOnly);

			// product_name
			$this->product_name->SetDbValueDef($rsnew, $this->product_name->CurrentValue, "", $this->product_name->ReadOnly);

			// product_desc
			$this->product_desc->SetDbValueDef($rsnew, $this->product_desc->CurrentValue, "", $this->product_desc->ReadOnly);

			// product_img_name
			$this->product_img_name->SetDbValueDef($rsnew, $this->product_img_name->CurrentValue, "", $this->product_img_name->ReadOnly);

			// img1
			$this->img1->SetDbValueDef($rsnew, $this->img1->CurrentValue, NULL, $this->img1->ReadOnly);

			// cat
			$this->cat->SetDbValueDef($rsnew, $this->cat->CurrentValue, NULL, $this->cat->ReadOnly);

			// sized
			$this->sized->SetDbValueDef($rsnew, $this->sized->CurrentValue, NULL, $this->sized->ReadOnly);

			// subcat
			$this->subcat->SetDbValueDef($rsnew, $this->subcat->CurrentValue, NULL, $this->subcat->ReadOnly);

			// sales_status
			$this->sales_status->SetDbValueDef($rsnew, ((strval($this->sales_status->CurrentValue) == "1") ? "1" : "0"), 0, $this->sales_status->ReadOnly);
			if (!$this->img2->Upload->KeepFile) {
				$this->img2->UploadPath = "../uploads/products/";
				if (!ew_Empty($this->img2->Upload->Value)) {
					if ($this->img2->Upload->FileName == $this->img2->Upload->DbValue) { // Overwrite if same file name
						$this->img2->Upload->DbValue = ""; // No need to delete any more
					} else {
						$rsnew['img2'] = ew_UploadFileNameEx(ew_UploadPathEx(TRUE, $this->img2->UploadPath), $rsnew['img2']); // Get new file name
					}
				}
			}
			if (!$this->img3->Upload->KeepFile) {
				$this->img3->UploadPath = "../uploads/products/";
				if (!ew_Empty($this->img3->Upload->Value)) {
					if ($this->img3->Upload->FileName == $this->img3->Upload->DbValue) { // Overwrite if same file name
						$this->img3->Upload->DbValue = ""; // No need to delete any more
					} else {
						$rsnew['img3'] = ew_UploadFileNameEx(ew_UploadPathEx(TRUE, $this->img3->UploadPath), $rsnew['img3']); // Get new file name
					}
				}
			}
			if (!$this->img4->Upload->KeepFile) {
				$this->img4->UploadPath = "../uploads/products/";
				if (!ew_Empty($this->img4->Upload->Value)) {
					if ($this->img4->Upload->FileName == $this->img4->Upload->DbValue) { // Overwrite if same file name
						$this->img4->Upload->DbValue = ""; // No need to delete any more
					} else {
						$rsnew['img4'] = ew_UploadFileNameEx(ew_UploadPathEx(TRUE, $this->img4->UploadPath), $rsnew['img4']); // Get new file name
					}
				}
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
					if (!$this->img2->Upload->KeepFile) {
						if (!ew_Empty($this->img2->Upload->Value)) {
							$this->img2->Upload->SaveToFile($this->img2->UploadPath, $rsnew['img2'], TRUE);
						}
						if ($this->img2->Upload->DbValue <> "")
							@unlink(ew_UploadPathEx(TRUE, $this->img2->OldUploadPath) . $this->img2->Upload->DbValue);
					}
					if (!$this->img3->Upload->KeepFile) {
						if (!ew_Empty($this->img3->Upload->Value)) {
							$this->img3->Upload->SaveToFile($this->img3->UploadPath, $rsnew['img3'], TRUE);
						}
						if ($this->img3->Upload->DbValue <> "")
							@unlink(ew_UploadPathEx(TRUE, $this->img3->OldUploadPath) . $this->img3->Upload->DbValue);
					}
					if (!$this->img4->Upload->KeepFile) {
						if (!ew_Empty($this->img4->Upload->Value)) {
							$this->img4->Upload->SaveToFile($this->img4->UploadPath, $rsnew['img4'], TRUE);
						}
						if ($this->img4->Upload->DbValue <> "")
							@unlink(ew_UploadPathEx(TRUE, $this->img4->OldUploadPath) . $this->img4->Upload->DbValue);
					}
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

		// img2
		ew_CleanUploadTempPath($this->img2, $this->img2->Upload->Index);

		// img3
		ew_CleanUploadTempPath($this->img3, $this->img3->Upload->Index);

		// img4
		ew_CleanUploadTempPath($this->img4, $this->img4->Upload->Index);
		return $EditRow;
	}

	// Set up Breadcrumb
	function SetupBreadcrumb() {
		global $Breadcrumb, $Language;
		$Breadcrumb = new cBreadcrumb();
		$PageCaption = $this->TableCaption();
		$Breadcrumb->Add("list", "<span id=\"ewPageCaption\">" . $PageCaption . "</span>", "productslist.php", $this->TableVar);
		$PageCaption = $Language->Phrase("edit");
		$Breadcrumb->Add("edit", "<span id=\"ewPageCaption\">" . $PageCaption . "</span>", ew_CurrentUrl(), $this->TableVar);
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
}
?>
<?php ew_Header(FALSE) ?>
<?php

// Create page object
if (!isset($products_edit)) $products_edit = new cproducts_edit();

// Page init
$products_edit->Page_Init();

// Page main
$products_edit->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$products_edit->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Page object
var products_edit = new ew_Page("products_edit");
products_edit.PageID = "edit"; // Page ID
var EW_PAGE_ID = products_edit.PageID; // For backward compatibility

// Form object
var fproductsedit = new ew_Form("fproductsedit");

// Validate form
fproductsedit.Validate = function() {
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
			elm = this.GetElements("x" + infix + "_price");
			if (elm && !ew_HasValue(elm))
				return this.OnError(elm, ewLanguage.Phrase("EnterRequiredField") + " - <?php echo ew_JsEncode2($products->price->FldCaption()) ?>");
			elm = this.GetElements("x" + infix + "_price");
			if (elm && !ew_CheckNumber(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($products->price->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_rate_ord");
			if (elm && !ew_HasValue(elm))
				return this.OnError(elm, ewLanguage.Phrase("EnterRequiredField") + " - <?php echo ew_JsEncode2($products->rate_ord->FldCaption()) ?>");
			elm = this.GetElements("x" + infix + "_oldprice");
			if (elm && !ew_CheckNumber(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($products->oldprice->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_product_code");
			if (elm && !ew_HasValue(elm))
				return this.OnError(elm, ewLanguage.Phrase("EnterRequiredField") + " - <?php echo ew_JsEncode2($products->product_code->FldCaption()) ?>");
			elm = this.GetElements("x" + infix + "_product_name");
			if (elm && !ew_HasValue(elm))
				return this.OnError(elm, ewLanguage.Phrase("EnterRequiredField") + " - <?php echo ew_JsEncode2($products->product_name->FldCaption()) ?>");
			elm = this.GetElements("x" + infix + "_product_desc");
			if (elm && !ew_HasValue(elm))
				return this.OnError(elm, ewLanguage.Phrase("EnterRequiredField") + " - <?php echo ew_JsEncode2($products->product_desc->FldCaption()) ?>");
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
	}

	// Process detail forms
	var dfs = $fobj.find("input[name='detailpage']").get();
	for (var i = 0; i < dfs.length; i++) {
		var df = dfs[i], val = df.value;
		if (val && ewForms[val])
			if (!ewForms[val].Validate())
				return false;
	}
	return true;
}

// Form_CustomValidate event
fproductsedit.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
fproductsedit.ValidateRequired = true;
<?php } else { ?>
fproductsedit.ValidateRequired = false; 
<?php } ?>

// Multi-Page properties
fproductsedit.MultiPage = new ew_MultiPage("fproductsedit",
	[["x_id",1],["x_price",1],["x_img2",2],["x_img3",2],["x_img4",2],["x_rate_ord",1],["x_oldprice",1],["x_product_code",1],["x_product_name",1],["x_product_desc",1],["x_product_img_name",1],["x_img1",1],["x_cat",1],["x_sized",1],["x_subcat",1],["x_sales_status",1]]
);

// Dynamic selection lists
// Form object for search

</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<?php $Breadcrumb->Render(); ?>
<?php $products_edit->ShowPageHeader(); ?>
<?php
$products_edit->ShowMessage();
?>
<form name="fproductsedit" id="fproductsedit" class="ewForm form-horizontal" action="<?php echo ew_CurrentPage() ?>" method="post">
<input type="hidden" name="t" value="products">
<input type="hidden" name="a_edit" id="a_edit" value="U">
<table class="ewStdTable"><tbody><tr><td>
<div class="tabbable" id="products_edit">
	<ul class="nav nav-tabs">
		<li class="active"><a href="#tab_products1" data-toggle="tab"><?php echo $products->PageCaption(1) ?></a></li>
		<li><a href="#tab_products2" data-toggle="tab"><?php echo $products->PageCaption(2) ?></a></li>
	</ul>
	<div class="tab-content">
		<div class="tab-pane active" id="tab_products1">
<table cellspacing="0" class="ewGrid" style="width: 100%"><tr><td>
<table id="tbl_productsedit1" class="table table-bordered table-striped">
<?php if ($products->id->Visible) { // id ?>
	<tr id="r_id">
		<td><span id="elh_products_id"><?php echo $products->id->FldCaption() ?></span></td>
		<td<?php echo $products->id->CellAttributes() ?>>
<span id="el_products_id" class="control-group">
<span<?php echo $products->id->ViewAttributes() ?>>
<?php echo $products->id->EditValue ?></span>
</span>
<input type="hidden" data-field="x_id" name="x_id" id="x_id" value="<?php echo ew_HtmlEncode($products->id->CurrentValue) ?>">
<?php echo $products->id->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($products->price->Visible) { // price ?>
	<tr id="r_price">
		<td><span id="elh_products_price"><?php echo $products->price->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></span></td>
		<td<?php echo $products->price->CellAttributes() ?>>
<span id="el_products_price" class="control-group">
<input type="text" data-field="x_price" name="x_price" id="x_price" size="30" placeholder="<?php echo $products->price->PlaceHolder ?>" value="<?php echo $products->price->EditValue ?>"<?php echo $products->price->EditAttributes() ?>>
</span>
<?php echo $products->price->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($products->rate_ord->Visible) { // rate_ord ?>
	<tr id="r_rate_ord">
		<td><span id="elh_products_rate_ord"><?php echo $products->rate_ord->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></span></td>
		<td<?php echo $products->rate_ord->CellAttributes() ?>>
<span id="el_products_rate_ord" class="control-group">
<select data-field="x_rate_ord" id="x_rate_ord" name="x_rate_ord"<?php echo $products->rate_ord->EditAttributes() ?>>
<?php
if (is_array($products->rate_ord->EditValue)) {
	$arwrk = $products->rate_ord->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($products->rate_ord->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " selected=\"selected\"" : "";
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
<?php echo $products->rate_ord->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($products->oldprice->Visible) { // oldprice ?>
	<tr id="r_oldprice">
		<td><span id="elh_products_oldprice"><?php echo $products->oldprice->FldCaption() ?></span></td>
		<td<?php echo $products->oldprice->CellAttributes() ?>>
<span id="el_products_oldprice" class="control-group">
<input type="text" data-field="x_oldprice" name="x_oldprice" id="x_oldprice" size="30" maxlength="10" placeholder="<?php echo $products->oldprice->PlaceHolder ?>" value="<?php echo $products->oldprice->EditValue ?>"<?php echo $products->oldprice->EditAttributes() ?>>
</span>
<?php echo $products->oldprice->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($products->product_code->Visible) { // product_code ?>
	<tr id="r_product_code">
		<td><span id="elh_products_product_code"><?php echo $products->product_code->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></span></td>
		<td<?php echo $products->product_code->CellAttributes() ?>>
<span id="el_products_product_code" class="control-group">
<input type="text" data-field="x_product_code" name="x_product_code" id="x_product_code" size="30" maxlength="60" placeholder="<?php echo $products->product_code->PlaceHolder ?>" value="<?php echo $products->product_code->EditValue ?>"<?php echo $products->product_code->EditAttributes() ?>>
</span>
<?php echo $products->product_code->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($products->product_name->Visible) { // product_name ?>
	<tr id="r_product_name">
		<td><span id="elh_products_product_name"><?php echo $products->product_name->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></span></td>
		<td<?php echo $products->product_name->CellAttributes() ?>>
<span id="el_products_product_name" class="control-group">
<input type="text" data-field="x_product_name" name="x_product_name" id="x_product_name" size="30" maxlength="60" placeholder="<?php echo $products->product_name->PlaceHolder ?>" value="<?php echo $products->product_name->EditValue ?>"<?php echo $products->product_name->EditAttributes() ?>>
</span>
<?php echo $products->product_name->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($products->product_desc->Visible) { // product_desc ?>
	<tr id="r_product_desc">
		<td><span id="elh_products_product_desc"><?php echo $products->product_desc->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></span></td>
		<td<?php echo $products->product_desc->CellAttributes() ?>>
<span id="el_products_product_desc" class="control-group">
<textarea data-field="x_product_desc" name="x_product_desc" id="x_product_desc" cols="35" rows="4" placeholder="<?php echo $products->product_desc->PlaceHolder ?>"<?php echo $products->product_desc->EditAttributes() ?>><?php echo $products->product_desc->EditValue ?></textarea>
</span>
<?php echo $products->product_desc->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($products->product_img_name->Visible) { // product_img_name ?>
	<tr id="r_product_img_name">
		<td><span id="elh_products_product_img_name"><?php echo $products->product_img_name->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></span></td>
		<td<?php echo $products->product_img_name->CellAttributes() ?>>
<span id="el_products_product_img_name" class="control-group">
<input type="text" data-field="x_product_img_name" name="x_product_img_name" id="x_product_img_name" size="30" maxlength="60" placeholder="<?php echo $products->product_img_name->PlaceHolder ?>" value="<?php echo $products->product_img_name->EditValue ?>"<?php echo $products->product_img_name->EditAttributes() ?>>
</span>
<?php echo $products->product_img_name->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($products->img1->Visible) { // img1 ?>
	<tr id="r_img1">
		<td><span id="elh_products_img1"><?php echo $products->img1->FldCaption() ?></span></td>
		<td<?php echo $products->img1->CellAttributes() ?>>
<span id="el_products_img1" class="control-group">
<input type="text" data-field="x_img1" name="x_img1" id="x_img1" size="30" maxlength="200" placeholder="<?php echo $products->img1->PlaceHolder ?>" value="<?php echo $products->img1->EditValue ?>"<?php echo $products->img1->EditAttributes() ?>>
</span>
<?php echo $products->img1->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($products->cat->Visible) { // cat ?>
	<tr id="r_cat">
		<td><span id="elh_products_cat"><?php echo $products->cat->FldCaption() ?></span></td>
		<td<?php echo $products->cat->CellAttributes() ?>>
<span id="el_products_cat" class="control-group">
<input type="text" data-field="x_cat" name="x_cat" id="x_cat" size="30" maxlength="50" placeholder="<?php echo $products->cat->PlaceHolder ?>" value="<?php echo $products->cat->EditValue ?>"<?php echo $products->cat->EditAttributes() ?>>
</span>
<?php echo $products->cat->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($products->sized->Visible) { // sized ?>
	<tr id="r_sized">
		<td><span id="elh_products_sized"><?php echo $products->sized->FldCaption() ?></span></td>
		<td<?php echo $products->sized->CellAttributes() ?>>
<span id="el_products_sized" class="control-group">
<textarea data-field="x_sized" name="x_sized" id="x_sized" cols="35" rows="4" placeholder="<?php echo $products->sized->PlaceHolder ?>"<?php echo $products->sized->EditAttributes() ?>><?php echo $products->sized->EditValue ?></textarea>
</span>
<?php echo $products->sized->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($products->subcat->Visible) { // subcat ?>
	<tr id="r_subcat">
		<td><span id="elh_products_subcat"><?php echo $products->subcat->FldCaption() ?></span></td>
		<td<?php echo $products->subcat->CellAttributes() ?>>
<span id="el_products_subcat" class="control-group">
<input type="text" data-field="x_subcat" name="x_subcat" id="x_subcat" size="30" maxlength="50" placeholder="<?php echo $products->subcat->PlaceHolder ?>" value="<?php echo $products->subcat->EditValue ?>"<?php echo $products->subcat->EditAttributes() ?>>
</span>
<?php echo $products->subcat->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($products->sales_status->Visible) { // sales_status ?>
	<tr id="r_sales_status">
		<td><span id="elh_products_sales_status"><?php echo $products->sales_status->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></span></td>
		<td<?php echo $products->sales_status->CellAttributes() ?>>
<span id="el_products_sales_status" class="control-group">
<div id="tp_x_sales_status" class="<?php echo EW_ITEM_TEMPLATE_CLASSNAME ?>"><input type="radio" name="x_sales_status" id="x_sales_status" value="{value}"<?php echo $products->sales_status->EditAttributes() ?>></div>
<div id="dsl_x_sales_status" data-repeatcolumn="5" class="ewItemList">
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
<label class="radio"><input type="radio" data-field="x_sales_status" name="x_sales_status" id="x_sales_status_<?php echo $rowcntwrk ?>" value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?><?php echo $products->sales_status->EditAttributes() ?>><?php echo $arwrk[$rowcntwrk][1] ?></label>
<?php echo ew_RepeatColumnTable($rowswrk, $rowcntwrk, 5, 2) ?>
<?php
	}
}
?>
</div>
</span>
<?php echo $products->sales_status->CustomMsg ?></td>
	</tr>
<?php } ?>
</table>
</td></tr></table>
		</div>
		<div class="tab-pane" id="tab_products2">
<table cellspacing="0" class="ewGrid" style="width: 100%"><tr><td>
<table id="tbl_productsedit2" class="table table-bordered table-striped">
<?php if ($products->img2->Visible) { // img2 ?>
	<tr id="r_img2">
		<td><span id="elh_products_img2"><?php echo $products->img2->FldCaption() ?></span></td>
		<td<?php echo $products->img2->CellAttributes() ?>>
<span id="el_products_img2" class="control-group">
<span id="fd_x_img2">
<span class="btn btn-small fileinput-button">
	<span><?php echo $Language->Phrase("ChooseFile") ?></span>
	<input type="file" data-field="x_img2" name="x_img2" id="x_img2">
</span>
<input type="hidden" name="fn_x_img2" id= "fn_x_img2" value="<?php echo $products->img2->Upload->FileName ?>">
<?php if (@$_POST["fa_x_img2"] == "0") { ?>
<input type="hidden" name="fa_x_img2" id= "fa_x_img2" value="0">
<?php } else { ?>
<input type="hidden" name="fa_x_img2" id= "fa_x_img2" value="1">
<?php } ?>
<input type="hidden" name="fs_x_img2" id= "fs_x_img2" value="200">
</span>
<table id="ft_x_img2" class="table table-condensed pull-left ewUploadTable"><tbody class="files"></tbody></table>
</span>
<?php echo $products->img2->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($products->img3->Visible) { // img3 ?>
	<tr id="r_img3">
		<td><span id="elh_products_img3"><?php echo $products->img3->FldCaption() ?></span></td>
		<td<?php echo $products->img3->CellAttributes() ?>>
<span id="el_products_img3" class="control-group">
<span id="fd_x_img3">
<span class="btn btn-small fileinput-button">
	<span><?php echo $Language->Phrase("ChooseFile") ?></span>
	<input type="file" data-field="x_img3" name="x_img3" id="x_img3">
</span>
<input type="hidden" name="fn_x_img3" id= "fn_x_img3" value="<?php echo $products->img3->Upload->FileName ?>">
<?php if (@$_POST["fa_x_img3"] == "0") { ?>
<input type="hidden" name="fa_x_img3" id= "fa_x_img3" value="0">
<?php } else { ?>
<input type="hidden" name="fa_x_img3" id= "fa_x_img3" value="1">
<?php } ?>
<input type="hidden" name="fs_x_img3" id= "fs_x_img3" value="200">
</span>
<table id="ft_x_img3" class="table table-condensed pull-left ewUploadTable"><tbody class="files"></tbody></table>
</span>
<?php echo $products->img3->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($products->img4->Visible) { // img4 ?>
	<tr id="r_img4">
		<td><span id="elh_products_img4"><?php echo $products->img4->FldCaption() ?></span></td>
		<td<?php echo $products->img4->CellAttributes() ?>>
<span id="el_products_img4" class="control-group">
<span id="fd_x_img4">
<span class="btn btn-small fileinput-button">
	<span><?php echo $Language->Phrase("ChooseFile") ?></span>
	<input type="file" data-field="x_img4" name="x_img4" id="x_img4">
</span>
<input type="hidden" name="fn_x_img4" id= "fn_x_img4" value="<?php echo $products->img4->Upload->FileName ?>">
<?php if (@$_POST["fa_x_img4"] == "0") { ?>
<input type="hidden" name="fa_x_img4" id= "fa_x_img4" value="0">
<?php } else { ?>
<input type="hidden" name="fa_x_img4" id= "fa_x_img4" value="1">
<?php } ?>
<input type="hidden" name="fs_x_img4" id= "fs_x_img4" value="200">
</span>
<table id="ft_x_img4" class="table table-condensed pull-left ewUploadTable"><tbody class="files"></tbody></table>
</span>
<?php echo $products->img4->CustomMsg ?></td>
	</tr>
<?php } ?>
</table>
</td></tr></table>
		</div>
	</div>
</div>
</td></tr></tbody></table>
<table class="ewPager">
<tr><td>
<?php if (!isset($products_edit->Pager)) $products_edit->Pager = new cNumericPager($products_edit->StartRec, $products_edit->DisplayRecs, $products_edit->TotalRecs, $products_edit->RecRange) ?>
<?php if ($products_edit->Pager->RecordCount > 0) { ?>
<table cellspacing="0" class="ewStdTable"><tbody><tr><td>
<div class="pagination"><ul>
	<?php if ($products_edit->Pager->FirstButton->Enabled) { ?>
	<li><a href="<?php echo $products_edit->PageUrl() ?>start=<?php echo $products_edit->Pager->FirstButton->Start ?>"><?php echo $Language->Phrase("PagerFirst") ?></a></li>
	<?php } ?>
	<?php if ($products_edit->Pager->PrevButton->Enabled) { ?>
	<li><a href="<?php echo $products_edit->PageUrl() ?>start=<?php echo $products_edit->Pager->PrevButton->Start ?>"><?php echo $Language->Phrase("PagerPrevious") ?></a></li>
	<?php } ?>
	<?php foreach ($products_edit->Pager->Items as $PagerItem) { ?>
		<li<?php if (!$PagerItem->Enabled) { echo " class=\" active\""; } ?>><a href="<?php if ($PagerItem->Enabled) { echo $products_edit->PageUrl() . "start=" . $PagerItem->Start; } else { echo "#"; } ?>"><?php echo $PagerItem->Text ?></a></li>
	<?php } ?>
	<?php if ($products_edit->Pager->NextButton->Enabled) { ?>
	<li><a href="<?php echo $products_edit->PageUrl() ?>start=<?php echo $products_edit->Pager->NextButton->Start ?>"><?php echo $Language->Phrase("PagerNext") ?></a></li>
	<?php } ?>
	<?php if ($products_edit->Pager->LastButton->Enabled) { ?>
	<li><a href="<?php echo $products_edit->PageUrl() ?>start=<?php echo $products_edit->Pager->LastButton->Start ?>"><?php echo $Language->Phrase("PagerLast") ?></a></li>
	<?php } ?>
</ul></div>
</td>
</tr></tbody></table>
<?php } else { ?>
	<p><?php echo $Language->Phrase("NoRecord") ?></p>
<?php } ?>
</td>
</tr></table>
<button class="btn btn-primary ewButton" name="btnAction" id="btnAction" type="submit"><?php echo $Language->Phrase("EditBtn") ?></button>
</form>
<script type="text/javascript">
fproductsedit.Init();
<?php if (EW_MOBILE_REFLOW && ew_IsMobile()) { ?>
ew_Reflow();
<?php } ?>
</script>
<?php
$products_edit->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$products_edit->Page_Terminate();
?>
