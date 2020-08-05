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

$products_delete = NULL; // Initialize page object first

class cproducts_delete extends cproducts {

	// Page ID
	var $PageID = 'delete';

	// Project ID
	var $ProjectID = "{D9B361E7-B2C1-4293-B9B3-B581986A15CC}";

	// Table name
	var $TableName = 'products';

	// Page object name
	var $PageObjName = 'products_delete';

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
			define("EW_PAGE_ID", 'delete', TRUE);

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
		$this->CurrentAction = (@$_GET["a"] <> "") ? $_GET["a"] : @$_POST["a_list"]; // Set up curent action

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
	var $TotalRecs = 0;
	var $RecCnt;
	var $RecKeys = array();
	var $Recordset;
	var $StartRowCnt = 1;
	var $RowCnt = 0;

	//
	// Page main
	//
	function Page_Main() {
		global $Language;

		// Set up Breadcrumb
		$this->SetupBreadcrumb();

		// Load key parameters
		$this->RecKeys = $this->GetRecordKeys(); // Load record keys
		$sFilter = $this->GetKeyFilter();
		if ($sFilter == "")
			$this->Page_Terminate("productslist.php"); // Prevent SQL injection, return to list

		// Set up filter (SQL WHHERE clause) and get return SQL
		// SQL constructor in products class, productsinfo.php

		$this->CurrentFilter = $sFilter;

		// Get action
		if (@$_POST["a_delete"] <> "") {
			$this->CurrentAction = $_POST["a_delete"];
		} else {
			$this->CurrentAction = "D"; // Delete record directly
		}
		switch ($this->CurrentAction) {
			case "D": // Delete
				$this->SendEmail = TRUE; // Send email on delete success
				if ($this->DeleteRows()) { // Delete rows
					if ($this->getSuccessMessage() == "")
						$this->setSuccessMessage($Language->Phrase("DeleteSuccess")); // Set up success message
					$this->Page_Terminate($this->getReturnUrl()); // Return to caller
				}
		}
	}

// No functions
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
		}

		// Call Row Rendered event
		if ($this->RowType <> EW_ROWTYPE_AGGREGATEINIT)
			$this->Row_Rendered();
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
		$conn->BeginTrans();

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
			$conn->CommitTrans(); // Commit the changes
		} else {
			$conn->RollbackTrans(); // Rollback changes
		}

		// Call Row Deleted event
		if ($DeleteRows) {
			foreach ($rsold as $row) {
				$this->Row_Deleted($row);
			}
		}
		return $DeleteRows;
	}

	// Set up Breadcrumb
	function SetupBreadcrumb() {
		global $Breadcrumb, $Language;
		$Breadcrumb = new cBreadcrumb();
		$PageCaption = $this->TableCaption();
		$Breadcrumb->Add("list", "<span id=\"ewPageCaption\">" . $PageCaption . "</span>", "productslist.php", $this->TableVar);
		$PageCaption = $Language->Phrase("delete");
		$Breadcrumb->Add("delete", "<span id=\"ewPageCaption\">" . $PageCaption . "</span>", ew_CurrentUrl(), $this->TableVar);
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
if (!isset($products_delete)) $products_delete = new cproducts_delete();

// Page init
$products_delete->Page_Init();

// Page main
$products_delete->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$products_delete->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Page object
var products_delete = new ew_Page("products_delete");
products_delete.PageID = "delete"; // Page ID
var EW_PAGE_ID = products_delete.PageID; // For backward compatibility

// Form object
var fproductsdelete = new ew_Form("fproductsdelete");

// Form_CustomValidate event
fproductsdelete.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
fproductsdelete.ValidateRequired = true;
<?php } else { ?>
fproductsdelete.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
// Form object for search

</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<?php

// Load records for display
if ($products_delete->Recordset = $products_delete->LoadRecordset())
	$products_deleteTotalRecs = $products_delete->Recordset->RecordCount(); // Get record count
if ($products_deleteTotalRecs <= 0) { // No record found, exit
	if ($products_delete->Recordset)
		$products_delete->Recordset->Close();
	$products_delete->Page_Terminate("productslist.php"); // Return to list
}
?>
<?php $Breadcrumb->Render(); ?>
<?php $products_delete->ShowPageHeader(); ?>
<?php
$products_delete->ShowMessage();
?>
<form name="fproductsdelete" id="fproductsdelete" class="ewForm form-horizontal" action="<?php echo ew_CurrentPage() ?>" method="post">
<input type="hidden" name="t" value="products">
<input type="hidden" name="a_delete" id="a_delete" value="D">
<?php foreach ($products_delete->RecKeys as $key) { ?>
<?php $keyvalue = is_array($key) ? implode($EW_COMPOSITE_KEY_SEPARATOR, $key) : $key; ?>
<input type="hidden" name="key_m[]" value="<?php echo ew_HtmlEncode($keyvalue) ?>">
<?php } ?>
<table cellspacing="0" class="ewGrid"><tr><td class="ewGridContent">
<div class="ewGridMiddlePanel">
<table id="tbl_productsdelete" class="ewTable ewTableSeparate">
<?php echo $products->TableCustomInnerHtml ?>
	<thead>
	<tr class="ewTableHeader">
<?php if ($products->price->Visible) { // price ?>
		<td><span id="elh_products_price" class="products_price"><?php echo $products->price->FldCaption() ?></span></td>
<?php } ?>
<?php if ($products->oldprice->Visible) { // oldprice ?>
		<td><span id="elh_products_oldprice" class="products_oldprice"><?php echo $products->oldprice->FldCaption() ?></span></td>
<?php } ?>
<?php if ($products->product_code->Visible) { // product_code ?>
		<td><span id="elh_products_product_code" class="products_product_code"><?php echo $products->product_code->FldCaption() ?></span></td>
<?php } ?>
<?php if ($products->product_name->Visible) { // product_name ?>
		<td><span id="elh_products_product_name" class="products_product_name"><?php echo $products->product_name->FldCaption() ?></span></td>
<?php } ?>
<?php if ($products->product_img_name->Visible) { // product_img_name ?>
		<td><span id="elh_products_product_img_name" class="products_product_img_name"><?php echo $products->product_img_name->FldCaption() ?></span></td>
<?php } ?>
<?php if ($products->img1->Visible) { // img1 ?>
		<td><span id="elh_products_img1" class="products_img1"><?php echo $products->img1->FldCaption() ?></span></td>
<?php } ?>
<?php if ($products->cat->Visible) { // cat ?>
		<td><span id="elh_products_cat" class="products_cat"><?php echo $products->cat->FldCaption() ?></span></td>
<?php } ?>
<?php if ($products->subcat->Visible) { // subcat ?>
		<td><span id="elh_products_subcat" class="products_subcat"><?php echo $products->subcat->FldCaption() ?></span></td>
<?php } ?>
<?php if ($products->sales_status->Visible) { // sales_status ?>
		<td><span id="elh_products_sales_status" class="products_sales_status"><?php echo $products->sales_status->FldCaption() ?></span></td>
<?php } ?>
	</tr>
	</thead>
	<tbody>
<?php
$products_delete->RecCnt = 0;
$i = 0;
while (!$products_delete->Recordset->EOF) {
	$products_delete->RecCnt++;
	$products_delete->RowCnt++;

	// Set row properties
	$products->ResetAttrs();
	$products->RowType = EW_ROWTYPE_VIEW; // View

	// Get the field contents
	$products_delete->LoadRowValues($products_delete->Recordset);

	// Render row
	$products_delete->RenderRow();
?>
	<tr<?php echo $products->RowAttributes() ?>>
<?php if ($products->price->Visible) { // price ?>
		<td<?php echo $products->price->CellAttributes() ?>>
<span id="el<?php echo $products_delete->RowCnt ?>_products_price" class="control-group products_price">
<span<?php echo $products->price->ViewAttributes() ?>>
<?php echo $products->price->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($products->oldprice->Visible) { // oldprice ?>
		<td<?php echo $products->oldprice->CellAttributes() ?>>
<span id="el<?php echo $products_delete->RowCnt ?>_products_oldprice" class="control-group products_oldprice">
<span<?php echo $products->oldprice->ViewAttributes() ?>>
<?php echo $products->oldprice->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($products->product_code->Visible) { // product_code ?>
		<td<?php echo $products->product_code->CellAttributes() ?>>
<span id="el<?php echo $products_delete->RowCnt ?>_products_product_code" class="control-group products_product_code">
<span<?php echo $products->product_code->ViewAttributes() ?>>
<?php echo $products->product_code->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($products->product_name->Visible) { // product_name ?>
		<td<?php echo $products->product_name->CellAttributes() ?>>
<span id="el<?php echo $products_delete->RowCnt ?>_products_product_name" class="control-group products_product_name">
<span<?php echo $products->product_name->ViewAttributes() ?>>
<?php echo $products->product_name->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($products->product_img_name->Visible) { // product_img_name ?>
		<td<?php echo $products->product_img_name->CellAttributes() ?>>
<span id="el<?php echo $products_delete->RowCnt ?>_products_product_img_name" class="control-group products_product_img_name">
<span<?php echo $products->product_img_name->ViewAttributes() ?>>
<?php echo $products->product_img_name->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($products->img1->Visible) { // img1 ?>
		<td<?php echo $products->img1->CellAttributes() ?>>
<span id="el<?php echo $products_delete->RowCnt ?>_products_img1" class="control-group products_img1">
<span<?php echo $products->img1->ViewAttributes() ?>>
<?php echo $products->img1->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($products->cat->Visible) { // cat ?>
		<td<?php echo $products->cat->CellAttributes() ?>>
<span id="el<?php echo $products_delete->RowCnt ?>_products_cat" class="control-group products_cat">
<span<?php echo $products->cat->ViewAttributes() ?>>
<?php echo $products->cat->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($products->subcat->Visible) { // subcat ?>
		<td<?php echo $products->subcat->CellAttributes() ?>>
<span id="el<?php echo $products_delete->RowCnt ?>_products_subcat" class="control-group products_subcat">
<span<?php echo $products->subcat->ViewAttributes() ?>>
<?php echo $products->subcat->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($products->sales_status->Visible) { // sales_status ?>
		<td<?php echo $products->sales_status->CellAttributes() ?>>
<span id="el<?php echo $products_delete->RowCnt ?>_products_sales_status" class="control-group products_sales_status">
<span<?php echo $products->sales_status->ViewAttributes() ?>>
<?php echo $products->sales_status->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
	</tr>
<?php
	$products_delete->Recordset->MoveNext();
}
$products_delete->Recordset->Close();
?>
</tbody>
</table>
</div>
</td></tr></table>
<div class="btn-group ewButtonGroup">
<button class="btn btn-primary ewButton" name="btnAction" id="btnAction" type="submit"><?php echo $Language->Phrase("DeleteBtn") ?></button>
</div>
</form>
<script type="text/javascript">
fproductsdelete.Init();
</script>
<?php
$products_delete->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$products_delete->Page_Terminate();
?>
