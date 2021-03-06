<?php
if (session_id() == "") session_start(); // Initialize Session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg10.php" ?>
<?php include_once "ewmysql10.php" ?>
<?php include_once "phpfn10.php" ?>
<?php include_once "simplewill_overall_assetinfo.php" ?>
<?php include_once "adminusersinfo.php" ?>
<?php include_once "simplewill_tbinfo.php" ?>
<?php include_once "simplewill_assets_tbinfo.php" ?>
<?php include_once "userfn10.php" ?>
<?php

//
// Page class
//

$simplewill_overall_asset_delete = NULL; // Initialize page object first

class csimplewill_overall_asset_delete extends csimplewill_overall_asset {

	// Page ID
	var $PageID = 'delete';

	// Project ID
	var $ProjectID = "{D9B361E7-B2C1-4293-B9B3-B581986A15CC}";

	// Table name
	var $TableName = 'simplewill_overall_asset';

	// Page object name
	var $PageObjName = 'simplewill_overall_asset_delete';

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

		// Table object (simplewill_overall_asset)
		if (!isset($GLOBALS["simplewill_overall_asset"])) {
			$GLOBALS["simplewill_overall_asset"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["simplewill_overall_asset"];
		}

		// Table object (adminusers)
		if (!isset($GLOBALS['adminusers'])) $GLOBALS['adminusers'] = new cadminusers();

		// Table object (simplewill_tb)
		if (!isset($GLOBALS['simplewill_tb'])) $GLOBALS['simplewill_tb'] = new csimplewill_tb();

		// Table object (simplewill_assets_tb)
		if (!isset($GLOBALS['simplewill_assets_tb'])) $GLOBALS['simplewill_assets_tb'] = new csimplewill_assets_tb();

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'delete', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'simplewill_overall_asset', TRUE);

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
			$this->Page_Terminate("simplewill_overall_assetlist.php"); // Prevent SQL injection, return to list

		// Set up filter (SQL WHHERE clause) and get return SQL
		// SQL constructor in simplewill_overall_asset class, simplewill_overall_assetinfo.php

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
		$this->uid->setDbValue($rs->fields('uid'));
		$this->beneficiaryid->setDbValue($rs->fields('beneficiaryid'));
		$this->propertyid->setDbValue($rs->fields('propertyid'));
		$this->property_type->setDbValue($rs->fields('property_type'));
		$this->percentage->setDbValue($rs->fields('percentage'));
		$this->datecreated->setDbValue($rs->fields('datecreated'));
	}

	// Load DbValue from recordset
	function LoadDbValues(&$rs) {
		if (!$rs || !is_array($rs) && $rs->EOF) return;
		$row = is_array($rs) ? $rs : $rs->fields;
		$this->id->DbValue = $row['id'];
		$this->uid->DbValue = $row['uid'];
		$this->beneficiaryid->DbValue = $row['beneficiaryid'];
		$this->propertyid->DbValue = $row['propertyid'];
		$this->property_type->DbValue = $row['property_type'];
		$this->percentage->DbValue = $row['percentage'];
		$this->datecreated->DbValue = $row['datecreated'];
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
		// uid
		// beneficiaryid
		// propertyid
		// property_type
		// percentage
		// datecreated

		if ($this->RowType == EW_ROWTYPE_VIEW) { // View row

			// id
			$this->id->ViewValue = $this->id->CurrentValue;
			$this->id->ViewCustomAttributes = "";

			// uid
			$this->uid->ViewValue = $this->uid->CurrentValue;
			$this->uid->ViewCustomAttributes = "";

			// beneficiaryid
			$this->beneficiaryid->ViewValue = $this->beneficiaryid->CurrentValue;
			$this->beneficiaryid->ViewCustomAttributes = "";

			// propertyid
			$this->propertyid->ViewValue = $this->propertyid->CurrentValue;
			$this->propertyid->ViewCustomAttributes = "";

			// property_type
			$this->property_type->ViewValue = $this->property_type->CurrentValue;
			$this->property_type->ViewCustomAttributes = "";

			// percentage
			$this->percentage->ViewValue = $this->percentage->CurrentValue;
			$this->percentage->ViewCustomAttributes = "";

			// datecreated
			$this->datecreated->ViewValue = $this->datecreated->CurrentValue;
			$this->datecreated->ViewCustomAttributes = "";

			// beneficiaryid
			$this->beneficiaryid->LinkCustomAttributes = "";
			$this->beneficiaryid->HrefValue = "";
			$this->beneficiaryid->TooltipValue = "";

			// propertyid
			$this->propertyid->LinkCustomAttributes = "";
			$this->propertyid->HrefValue = "";
			$this->propertyid->TooltipValue = "";

			// property_type
			$this->property_type->LinkCustomAttributes = "";
			$this->property_type->HrefValue = "";
			$this->property_type->TooltipValue = "";

			// percentage
			$this->percentage->LinkCustomAttributes = "";
			$this->percentage->HrefValue = "";
			$this->percentage->TooltipValue = "";

			// datecreated
			$this->datecreated->LinkCustomAttributes = "";
			$this->datecreated->HrefValue = "";
			$this->datecreated->TooltipValue = "";
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
		$Breadcrumb->Add("list", "<span id=\"ewPageCaption\">" . $PageCaption . "</span>", "simplewill_overall_assetlist.php", $this->TableVar);
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
if (!isset($simplewill_overall_asset_delete)) $simplewill_overall_asset_delete = new csimplewill_overall_asset_delete();

// Page init
$simplewill_overall_asset_delete->Page_Init();

// Page main
$simplewill_overall_asset_delete->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$simplewill_overall_asset_delete->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Page object
var simplewill_overall_asset_delete = new ew_Page("simplewill_overall_asset_delete");
simplewill_overall_asset_delete.PageID = "delete"; // Page ID
var EW_PAGE_ID = simplewill_overall_asset_delete.PageID; // For backward compatibility

// Form object
var fsimplewill_overall_assetdelete = new ew_Form("fsimplewill_overall_assetdelete");

// Form_CustomValidate event
fsimplewill_overall_assetdelete.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
fsimplewill_overall_assetdelete.ValidateRequired = true;
<?php } else { ?>
fsimplewill_overall_assetdelete.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
// Form object for search

</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<?php

// Load records for display
if ($simplewill_overall_asset_delete->Recordset = $simplewill_overall_asset_delete->LoadRecordset())
	$simplewill_overall_asset_deleteTotalRecs = $simplewill_overall_asset_delete->Recordset->RecordCount(); // Get record count
if ($simplewill_overall_asset_deleteTotalRecs <= 0) { // No record found, exit
	if ($simplewill_overall_asset_delete->Recordset)
		$simplewill_overall_asset_delete->Recordset->Close();
	$simplewill_overall_asset_delete->Page_Terminate("simplewill_overall_assetlist.php"); // Return to list
}
?>
<?php $Breadcrumb->Render(); ?>
<?php $simplewill_overall_asset_delete->ShowPageHeader(); ?>
<?php
$simplewill_overall_asset_delete->ShowMessage();
?>
<form name="fsimplewill_overall_assetdelete" id="fsimplewill_overall_assetdelete" class="ewForm form-horizontal" action="<?php echo ew_CurrentPage() ?>" method="post">
<input type="hidden" name="t" value="simplewill_overall_asset">
<input type="hidden" name="a_delete" id="a_delete" value="D">
<?php foreach ($simplewill_overall_asset_delete->RecKeys as $key) { ?>
<?php $keyvalue = is_array($key) ? implode($EW_COMPOSITE_KEY_SEPARATOR, $key) : $key; ?>
<input type="hidden" name="key_m[]" value="<?php echo ew_HtmlEncode($keyvalue) ?>">
<?php } ?>
<table cellspacing="0" class="ewGrid"><tr><td class="ewGridContent">
<div class="ewGridMiddlePanel">
<table id="tbl_simplewill_overall_assetdelete" class="ewTable ewTableSeparate">
<?php echo $simplewill_overall_asset->TableCustomInnerHtml ?>
	<thead>
	<tr class="ewTableHeader">
<?php if ($simplewill_overall_asset->beneficiaryid->Visible) { // beneficiaryid ?>
		<td><span id="elh_simplewill_overall_asset_beneficiaryid" class="simplewill_overall_asset_beneficiaryid"><?php echo $simplewill_overall_asset->beneficiaryid->FldCaption() ?></span></td>
<?php } ?>
<?php if ($simplewill_overall_asset->propertyid->Visible) { // propertyid ?>
		<td><span id="elh_simplewill_overall_asset_propertyid" class="simplewill_overall_asset_propertyid"><?php echo $simplewill_overall_asset->propertyid->FldCaption() ?></span></td>
<?php } ?>
<?php if ($simplewill_overall_asset->property_type->Visible) { // property_type ?>
		<td><span id="elh_simplewill_overall_asset_property_type" class="simplewill_overall_asset_property_type"><?php echo $simplewill_overall_asset->property_type->FldCaption() ?></span></td>
<?php } ?>
<?php if ($simplewill_overall_asset->percentage->Visible) { // percentage ?>
		<td><span id="elh_simplewill_overall_asset_percentage" class="simplewill_overall_asset_percentage"><?php echo $simplewill_overall_asset->percentage->FldCaption() ?></span></td>
<?php } ?>
<?php if ($simplewill_overall_asset->datecreated->Visible) { // datecreated ?>
		<td><span id="elh_simplewill_overall_asset_datecreated" class="simplewill_overall_asset_datecreated"><?php echo $simplewill_overall_asset->datecreated->FldCaption() ?></span></td>
<?php } ?>
	</tr>
	</thead>
	<tbody>
<?php
$simplewill_overall_asset_delete->RecCnt = 0;
$i = 0;
while (!$simplewill_overall_asset_delete->Recordset->EOF) {
	$simplewill_overall_asset_delete->RecCnt++;
	$simplewill_overall_asset_delete->RowCnt++;

	// Set row properties
	$simplewill_overall_asset->ResetAttrs();
	$simplewill_overall_asset->RowType = EW_ROWTYPE_VIEW; // View

	// Get the field contents
	$simplewill_overall_asset_delete->LoadRowValues($simplewill_overall_asset_delete->Recordset);

	// Render row
	$simplewill_overall_asset_delete->RenderRow();
?>
	<tr<?php echo $simplewill_overall_asset->RowAttributes() ?>>
<?php if ($simplewill_overall_asset->beneficiaryid->Visible) { // beneficiaryid ?>
		<td<?php echo $simplewill_overall_asset->beneficiaryid->CellAttributes() ?>>
<span id="el<?php echo $simplewill_overall_asset_delete->RowCnt ?>_simplewill_overall_asset_beneficiaryid" class="control-group simplewill_overall_asset_beneficiaryid">
<span<?php echo $simplewill_overall_asset->beneficiaryid->ViewAttributes() ?>>
<?php echo $simplewill_overall_asset->beneficiaryid->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($simplewill_overall_asset->propertyid->Visible) { // propertyid ?>
		<td<?php echo $simplewill_overall_asset->propertyid->CellAttributes() ?>>
<span id="el<?php echo $simplewill_overall_asset_delete->RowCnt ?>_simplewill_overall_asset_propertyid" class="control-group simplewill_overall_asset_propertyid">
<span<?php echo $simplewill_overall_asset->propertyid->ViewAttributes() ?>>
<?php echo $simplewill_overall_asset->propertyid->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($simplewill_overall_asset->property_type->Visible) { // property_type ?>
		<td<?php echo $simplewill_overall_asset->property_type->CellAttributes() ?>>
<span id="el<?php echo $simplewill_overall_asset_delete->RowCnt ?>_simplewill_overall_asset_property_type" class="control-group simplewill_overall_asset_property_type">
<span<?php echo $simplewill_overall_asset->property_type->ViewAttributes() ?>>
<?php echo $simplewill_overall_asset->property_type->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($simplewill_overall_asset->percentage->Visible) { // percentage ?>
		<td<?php echo $simplewill_overall_asset->percentage->CellAttributes() ?>>
<span id="el<?php echo $simplewill_overall_asset_delete->RowCnt ?>_simplewill_overall_asset_percentage" class="control-group simplewill_overall_asset_percentage">
<span<?php echo $simplewill_overall_asset->percentage->ViewAttributes() ?>>
<?php echo $simplewill_overall_asset->percentage->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($simplewill_overall_asset->datecreated->Visible) { // datecreated ?>
		<td<?php echo $simplewill_overall_asset->datecreated->CellAttributes() ?>>
<span id="el<?php echo $simplewill_overall_asset_delete->RowCnt ?>_simplewill_overall_asset_datecreated" class="control-group simplewill_overall_asset_datecreated">
<span<?php echo $simplewill_overall_asset->datecreated->ViewAttributes() ?>>
<?php echo $simplewill_overall_asset->datecreated->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
	</tr>
<?php
	$simplewill_overall_asset_delete->Recordset->MoveNext();
}
$simplewill_overall_asset_delete->Recordset->Close();
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
fsimplewill_overall_assetdelete.Init();
</script>
<?php
$simplewill_overall_asset_delete->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$simplewill_overall_asset_delete->Page_Terminate();
?>
