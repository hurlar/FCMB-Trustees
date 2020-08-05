<?php
if (session_id() == "") session_start(); // Initialize Session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg10.php" ?>
<?php include_once "ewmysql10.php" ?>
<?php include_once "phpfn10.php" ?>
<?php include_once "will_tbinfo.php" ?>
<?php include_once "adminusersinfo.php" ?>
<?php include_once "userfn10.php" ?>
<?php

//
// Page class
//

$will_tb_delete = NULL; // Initialize page object first

class cwill_tb_delete extends cwill_tb {

	// Page ID
	var $PageID = 'delete';

	// Project ID
	var $ProjectID = "{D9B361E7-B2C1-4293-B9B3-B581986A15CC}";

	// Table name
	var $TableName = 'will_tb';

	// Page object name
	var $PageObjName = 'will_tb_delete';

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

		// Table object (will_tb)
		if (!isset($GLOBALS["will_tb"])) {
			$GLOBALS["will_tb"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["will_tb"];
		}

		// Table object (adminusers)
		if (!isset($GLOBALS['adminusers'])) $GLOBALS['adminusers'] = new cadminusers();

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'delete', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'will_tb', TRUE);

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
			$this->Page_Terminate("will_tblist.php"); // Prevent SQL injection, return to list

		// Set up filter (SQL WHHERE clause) and get return SQL
		// SQL constructor in will_tb class, will_tbinfo.php

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
		$this->name->setDbValue($rs->fields('name'));
		$this->pdflink->Upload->DbValue = $rs->fields('pdflink');
		$this->url_link->setDbValue($rs->fields('url_link'));
		$this->rating_order->setDbValue($rs->fields('rating_order'));
	}

	// Load DbValue from recordset
	function LoadDbValues(&$rs) {
		if (!$rs || !is_array($rs) && $rs->EOF) return;
		$row = is_array($rs) ? $rs : $rs->fields;
		$this->id->DbValue = $row['id'];
		$this->name->DbValue = $row['name'];
		$this->pdflink->Upload->DbValue = $row['pdflink'];
		$this->url_link->DbValue = $row['url_link'];
		$this->rating_order->DbValue = $row['rating_order'];
	}

	// Render row values based on field settings
	function RenderRow() {
		global $conn, $Security, $Language;
		global $gsLanguage;

		// Initialize URLs
		// Call Row_Rendering event

		$this->Row_Rendering();

		// Common render codes for all row types
		// id
		// name
		// pdflink
		// url_link
		// rating_order

		if ($this->RowType == EW_ROWTYPE_VIEW) { // View row

			// id
			$this->id->ViewValue = $this->id->CurrentValue;
			$this->id->ViewCustomAttributes = "";

			// name
			$this->name->ViewValue = $this->name->CurrentValue;
			$this->name->ViewCustomAttributes = "";

			// pdflink
			$this->pdflink->UploadPath = "uploads/forms";
			if (!ew_Empty($this->pdflink->Upload->DbValue)) {
				$this->pdflink->ViewValue = $this->pdflink->Upload->DbValue;
			} else {
				$this->pdflink->ViewValue = "";
			}
			$this->pdflink->ViewCustomAttributes = "";

			// url_link
			$this->url_link->ViewValue = $this->url_link->CurrentValue;
			$this->url_link->ViewCustomAttributes = "";

			// rating_order
			if (strval($this->rating_order->CurrentValue) <> "") {
				switch ($this->rating_order->CurrentValue) {
					case $this->rating_order->FldTagValue(1):
						$this->rating_order->ViewValue = $this->rating_order->FldTagCaption(1) <> "" ? $this->rating_order->FldTagCaption(1) : $this->rating_order->CurrentValue;
						break;
					case $this->rating_order->FldTagValue(2):
						$this->rating_order->ViewValue = $this->rating_order->FldTagCaption(2) <> "" ? $this->rating_order->FldTagCaption(2) : $this->rating_order->CurrentValue;
						break;
					case $this->rating_order->FldTagValue(3):
						$this->rating_order->ViewValue = $this->rating_order->FldTagCaption(3) <> "" ? $this->rating_order->FldTagCaption(3) : $this->rating_order->CurrentValue;
						break;
					case $this->rating_order->FldTagValue(4):
						$this->rating_order->ViewValue = $this->rating_order->FldTagCaption(4) <> "" ? $this->rating_order->FldTagCaption(4) : $this->rating_order->CurrentValue;
						break;
					case $this->rating_order->FldTagValue(5):
						$this->rating_order->ViewValue = $this->rating_order->FldTagCaption(5) <> "" ? $this->rating_order->FldTagCaption(5) : $this->rating_order->CurrentValue;
						break;
					case $this->rating_order->FldTagValue(6):
						$this->rating_order->ViewValue = $this->rating_order->FldTagCaption(6) <> "" ? $this->rating_order->FldTagCaption(6) : $this->rating_order->CurrentValue;
						break;
					case $this->rating_order->FldTagValue(7):
						$this->rating_order->ViewValue = $this->rating_order->FldTagCaption(7) <> "" ? $this->rating_order->FldTagCaption(7) : $this->rating_order->CurrentValue;
						break;
					case $this->rating_order->FldTagValue(8):
						$this->rating_order->ViewValue = $this->rating_order->FldTagCaption(8) <> "" ? $this->rating_order->FldTagCaption(8) : $this->rating_order->CurrentValue;
						break;
					case $this->rating_order->FldTagValue(9):
						$this->rating_order->ViewValue = $this->rating_order->FldTagCaption(9) <> "" ? $this->rating_order->FldTagCaption(9) : $this->rating_order->CurrentValue;
						break;
					case $this->rating_order->FldTagValue(10):
						$this->rating_order->ViewValue = $this->rating_order->FldTagCaption(10) <> "" ? $this->rating_order->FldTagCaption(10) : $this->rating_order->CurrentValue;
						break;
					case $this->rating_order->FldTagValue(11):
						$this->rating_order->ViewValue = $this->rating_order->FldTagCaption(11) <> "" ? $this->rating_order->FldTagCaption(11) : $this->rating_order->CurrentValue;
						break;
					default:
						$this->rating_order->ViewValue = $this->rating_order->CurrentValue;
				}
			} else {
				$this->rating_order->ViewValue = NULL;
			}
			$this->rating_order->ViewCustomAttributes = "";

			// name
			$this->name->LinkCustomAttributes = "";
			$this->name->HrefValue = "";
			$this->name->TooltipValue = "";

			// pdflink
			$this->pdflink->LinkCustomAttributes = "";
			$this->pdflink->UploadPath = "uploads/forms";
			if (!ew_Empty($this->pdflink->Upload->DbValue)) {
				$this->pdflink->HrefValue = ew_UploadPathEx(FALSE, $this->pdflink->UploadPath) . $this->pdflink->Upload->DbValue; // Add prefix/suffix
				$this->pdflink->LinkAttrs["target"] = "_blank"; // Add target
				if ($this->Export <> "") $this->pdflink->HrefValue = ew_ConvertFullUrl($this->pdflink->HrefValue);
			} else {
				$this->pdflink->HrefValue = "";
			}
			$this->pdflink->HrefValue2 = $this->pdflink->UploadPath . $this->pdflink->Upload->DbValue;
			$this->pdflink->TooltipValue = "";

			// url_link
			$this->url_link->LinkCustomAttributes = "";
			$this->url_link->HrefValue = "";
			$this->url_link->TooltipValue = "";

			// rating_order
			$this->rating_order->LinkCustomAttributes = "";
			$this->pdflink->UploadPath = "uploads/forms";
			if (!ew_Empty($this->pdflink->Upload->DbValue)) {
				$this->rating_order->HrefValue = ew_UploadPathEx(FALSE, $this->pdflink->UploadPath) . $this->pdflink->Upload->DbValue; // Add prefix/suffix
				$this->rating_order->LinkAttrs["target"] = ""; // Add target
				if ($this->Export <> "") $this->rating_order->HrefValue = ew_ConvertFullUrl($this->rating_order->HrefValue);
			} else {
				$this->rating_order->HrefValue = "";
			}
			$this->rating_order->TooltipValue = "";
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
				$this->pdflink->OldUploadPath = "uploads/forms";
				@unlink(ew_UploadPathEx(TRUE, $this->pdflink->OldUploadPath) . $row['pdflink']);
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
		$Breadcrumb->Add("list", "<span id=\"ewPageCaption\">" . $PageCaption . "</span>", "will_tblist.php", $this->TableVar);
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
if (!isset($will_tb_delete)) $will_tb_delete = new cwill_tb_delete();

// Page init
$will_tb_delete->Page_Init();

// Page main
$will_tb_delete->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$will_tb_delete->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Page object
var will_tb_delete = new ew_Page("will_tb_delete");
will_tb_delete.PageID = "delete"; // Page ID
var EW_PAGE_ID = will_tb_delete.PageID; // For backward compatibility

// Form object
var fwill_tbdelete = new ew_Form("fwill_tbdelete");

// Form_CustomValidate event
fwill_tbdelete.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
fwill_tbdelete.ValidateRequired = true;
<?php } else { ?>
fwill_tbdelete.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
// Form object for search

</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<?php

// Load records for display
if ($will_tb_delete->Recordset = $will_tb_delete->LoadRecordset())
	$will_tb_deleteTotalRecs = $will_tb_delete->Recordset->RecordCount(); // Get record count
if ($will_tb_deleteTotalRecs <= 0) { // No record found, exit
	if ($will_tb_delete->Recordset)
		$will_tb_delete->Recordset->Close();
	$will_tb_delete->Page_Terminate("will_tblist.php"); // Return to list
}
?>
<?php $Breadcrumb->Render(); ?>
<?php $will_tb_delete->ShowPageHeader(); ?>
<?php
$will_tb_delete->ShowMessage();
?>
<form name="fwill_tbdelete" id="fwill_tbdelete" class="ewForm form-horizontal" action="<?php echo ew_CurrentPage() ?>" method="post">
<input type="hidden" name="t" value="will_tb">
<input type="hidden" name="a_delete" id="a_delete" value="D">
<?php foreach ($will_tb_delete->RecKeys as $key) { ?>
<?php $keyvalue = is_array($key) ? implode($EW_COMPOSITE_KEY_SEPARATOR, $key) : $key; ?>
<input type="hidden" name="key_m[]" value="<?php echo ew_HtmlEncode($keyvalue) ?>">
<?php } ?>
<table cellspacing="0" class="ewGrid"><tr><td class="ewGridContent">
<div class="ewGridMiddlePanel">
<table id="tbl_will_tbdelete" class="ewTable ewTableSeparate">
<?php echo $will_tb->TableCustomInnerHtml ?>
	<thead>
	<tr class="ewTableHeader">
<?php if ($will_tb->name->Visible) { // name ?>
		<td><span id="elh_will_tb_name" class="will_tb_name"><?php echo $will_tb->name->FldCaption() ?></span></td>
<?php } ?>
<?php if ($will_tb->pdflink->Visible) { // pdflink ?>
		<td><span id="elh_will_tb_pdflink" class="will_tb_pdflink"><?php echo $will_tb->pdflink->FldCaption() ?></span></td>
<?php } ?>
<?php if ($will_tb->url_link->Visible) { // url_link ?>
		<td><span id="elh_will_tb_url_link" class="will_tb_url_link"><?php echo $will_tb->url_link->FldCaption() ?></span></td>
<?php } ?>
<?php if ($will_tb->rating_order->Visible) { // rating_order ?>
		<td><span id="elh_will_tb_rating_order" class="will_tb_rating_order"><?php echo $will_tb->rating_order->FldCaption() ?></span></td>
<?php } ?>
	</tr>
	</thead>
	<tbody>
<?php
$will_tb_delete->RecCnt = 0;
$i = 0;
while (!$will_tb_delete->Recordset->EOF) {
	$will_tb_delete->RecCnt++;
	$will_tb_delete->RowCnt++;

	// Set row properties
	$will_tb->ResetAttrs();
	$will_tb->RowType = EW_ROWTYPE_VIEW; // View

	// Get the field contents
	$will_tb_delete->LoadRowValues($will_tb_delete->Recordset);

	// Render row
	$will_tb_delete->RenderRow();
?>
	<tr<?php echo $will_tb->RowAttributes() ?>>
<?php if ($will_tb->name->Visible) { // name ?>
		<td<?php echo $will_tb->name->CellAttributes() ?>>
<span id="el<?php echo $will_tb_delete->RowCnt ?>_will_tb_name" class="control-group will_tb_name">
<span<?php echo $will_tb->name->ViewAttributes() ?>>
<?php echo $will_tb->name->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($will_tb->pdflink->Visible) { // pdflink ?>
		<td<?php echo $will_tb->pdflink->CellAttributes() ?>>
<span id="el<?php echo $will_tb_delete->RowCnt ?>_will_tb_pdflink" class="control-group will_tb_pdflink">
<span<?php echo $will_tb->pdflink->ViewAttributes() ?>>
<?php if ($will_tb->pdflink->LinkAttributes() <> "") { ?>
<?php if (!empty($will_tb->pdflink->Upload->DbValue)) { ?>
<a<?php echo $will_tb->pdflink->LinkAttributes() ?>><?php echo $will_tb->pdflink->ListViewValue() ?></a>
<?php } elseif (!in_array($will_tb->CurrentAction, array("I", "edit", "gridedit"))) { ?>	
&nbsp;
<?php } ?>
<?php } else { ?>
<?php if (!empty($will_tb->pdflink->Upload->DbValue)) { ?>
<?php echo $will_tb->pdflink->ListViewValue() ?>
<?php } elseif (!in_array($will_tb->CurrentAction, array("I", "edit", "gridedit"))) { ?>	
&nbsp;
<?php } ?>
<?php } ?>
</span>
</span>
</td>
<?php } ?>
<?php if ($will_tb->url_link->Visible) { // url_link ?>
		<td<?php echo $will_tb->url_link->CellAttributes() ?>>
<span id="el<?php echo $will_tb_delete->RowCnt ?>_will_tb_url_link" class="control-group will_tb_url_link">
<span<?php echo $will_tb->url_link->ViewAttributes() ?>>
<?php echo $will_tb->url_link->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($will_tb->rating_order->Visible) { // rating_order ?>
		<td<?php echo $will_tb->rating_order->CellAttributes() ?>>
<span id="el<?php echo $will_tb_delete->RowCnt ?>_will_tb_rating_order" class="control-group will_tb_rating_order">
<span<?php echo $will_tb->rating_order->ViewAttributes() ?>>
<?php if (!ew_EmptyStr($will_tb->rating_order->ListViewValue()) && $will_tb->rating_order->LinkAttributes() <> "") { ?>
<a<?php echo $will_tb->rating_order->LinkAttributes() ?>><?php echo $will_tb->rating_order->ListViewValue() ?></a>
<?php } else { ?>
<?php echo $will_tb->rating_order->ListViewValue() ?>
<?php } ?>
</span>
</span>
</td>
<?php } ?>
	</tr>
<?php
	$will_tb_delete->Recordset->MoveNext();
}
$will_tb_delete->Recordset->Close();
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
fwill_tbdelete.Init();
</script>
<?php
$will_tb_delete->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$will_tb_delete->Page_Terminate();
?>
