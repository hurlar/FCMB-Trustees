<?php
if (session_id() == "") session_start(); // Initialize Session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg10.php" ?>
<?php include_once "ewmysql10.php" ?>
<?php include_once "phpfn10.php" ?>
<?php include_once "directorsinfo.php" ?>
<?php include_once "adminusersinfo.php" ?>
<?php include_once "userfn10.php" ?>
<?php

//
// Page class
//

$directors_delete = NULL; // Initialize page object first

class cdirectors_delete extends cdirectors {

	// Page ID
	var $PageID = 'delete';

	// Project ID
	var $ProjectID = "{D9B361E7-B2C1-4293-B9B3-B581986A15CC}";

	// Table name
	var $TableName = 'directors';

	// Page object name
	var $PageObjName = 'directors_delete';

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

		// Table object (directors)
		if (!isset($GLOBALS["directors"])) {
			$GLOBALS["directors"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["directors"];
		}

		// Table object (adminusers)
		if (!isset($GLOBALS['adminusers'])) $GLOBALS['adminusers'] = new cadminusers();

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'delete', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'directors', TRUE);

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
			$this->Page_Terminate("directorslist.php"); // Prevent SQL injection, return to list

		// Set up filter (SQL WHHERE clause) and get return SQL
		// SQL constructor in directors class, directorsinfo.php

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
		$this->position->setDbValue($rs->fields('position'));
		$this->image->Upload->DbValue = $rs->fields('image');
		$this->descrp->setDbValue($rs->fields('descrp'));
		$this->category->setDbValue($rs->fields('category'));
		$this->slug->setDbValue($rs->fields('slug'));
		$this->rate_ord->setDbValue($rs->fields('rate_ord'));
		$this->datecreated->setDbValue($rs->fields('datecreated'));
	}

	// Load DbValue from recordset
	function LoadDbValues(&$rs) {
		if (!$rs || !is_array($rs) && $rs->EOF) return;
		$row = is_array($rs) ? $rs : $rs->fields;
		$this->id->DbValue = $row['id'];
		$this->name->DbValue = $row['name'];
		$this->position->DbValue = $row['position'];
		$this->image->Upload->DbValue = $row['image'];
		$this->descrp->DbValue = $row['descrp'];
		$this->category->DbValue = $row['category'];
		$this->slug->DbValue = $row['slug'];
		$this->rate_ord->DbValue = $row['rate_ord'];
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
		// name
		// position
		// image
		// descrp
		// category
		// slug
		// rate_ord
		// datecreated

		$this->datecreated->CellCssStyle = "white-space: nowrap;";
		if ($this->RowType == EW_ROWTYPE_VIEW) { // View row

			// id
			$this->id->ViewValue = $this->id->CurrentValue;
			$this->id->ViewCustomAttributes = "";

			// name
			$this->name->ViewValue = $this->name->CurrentValue;
			$this->name->ViewCustomAttributes = "";

			// position
			$this->position->ViewValue = $this->position->CurrentValue;
			$this->position->ViewCustomAttributes = "";

			// image
			$this->image->UploadPath = "../images/team/";
			if (!ew_Empty($this->image->Upload->DbValue)) {
				$this->image->ViewValue = $this->image->Upload->DbValue;
			} else {
				$this->image->ViewValue = "";
			}
			$this->image->ViewCustomAttributes = "";

			// descrp
			$this->descrp->ViewValue = $this->descrp->CurrentValue;
			$this->descrp->ViewCustomAttributes = "";

			// category
			if (strval($this->category->CurrentValue) <> "") {
				$sFilterWrk = "`category`" . ew_SearchString("=", $this->category->CurrentValue, EW_DATATYPE_STRING);
			$sSqlWrk = "SELECT `category`, `category` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `mgt_cat`";
			$sWhereWrk = "";
			if ($sFilterWrk <> "") {
				ew_AddFilter($sWhereWrk, $sFilterWrk);
			}

			// Call Lookup selecting
			$this->Lookup_Selecting($this->category, $sWhereWrk);
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
				$rswrk = $conn->Execute($sSqlWrk);
				if ($rswrk && !$rswrk->EOF) { // Lookup values found
					$this->category->ViewValue = $rswrk->fields('DispFld');
					$rswrk->Close();
				} else {
					$this->category->ViewValue = $this->category->CurrentValue;
				}
			} else {
				$this->category->ViewValue = NULL;
			}
			$this->category->ViewCustomAttributes = "";

			// slug
			$this->slug->ViewValue = $this->slug->CurrentValue;
			$this->slug->ViewCustomAttributes = "";

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

			// datecreated
			$this->datecreated->ViewValue = $this->datecreated->CurrentValue;
			$this->datecreated->ViewCustomAttributes = "";

			// name
			$this->name->LinkCustomAttributes = "";
			$this->name->HrefValue = "";
			$this->name->TooltipValue = "";

			// position
			$this->position->LinkCustomAttributes = "";
			$this->position->HrefValue = "";
			$this->position->TooltipValue = "";

			// category
			$this->category->LinkCustomAttributes = "";
			$this->category->HrefValue = "";
			$this->category->TooltipValue = "";

			// slug
			$this->slug->LinkCustomAttributes = "";
			$this->slug->HrefValue = "";
			$this->slug->TooltipValue = "";

			// rate_ord
			$this->rate_ord->LinkCustomAttributes = "";
			$this->rate_ord->HrefValue = "";
			$this->rate_ord->TooltipValue = "";
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
				$this->image->OldUploadPath = "../images/team/";
				@unlink(ew_UploadPathEx(TRUE, $this->image->OldUploadPath) . $row['image']);
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
		$Breadcrumb->Add("list", "<span id=\"ewPageCaption\">" . $PageCaption . "</span>", "directorslist.php", $this->TableVar);
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
if (!isset($directors_delete)) $directors_delete = new cdirectors_delete();

// Page init
$directors_delete->Page_Init();

// Page main
$directors_delete->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$directors_delete->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Page object
var directors_delete = new ew_Page("directors_delete");
directors_delete.PageID = "delete"; // Page ID
var EW_PAGE_ID = directors_delete.PageID; // For backward compatibility

// Form object
var fdirectorsdelete = new ew_Form("fdirectorsdelete");

// Form_CustomValidate event
fdirectorsdelete.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
fdirectorsdelete.ValidateRequired = true;
<?php } else { ?>
fdirectorsdelete.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
fdirectorsdelete.Lists["x_category"] = {"LinkField":"x_category","Ajax":null,"AutoFill":false,"DisplayFields":["x_category","","",""],"ParentFields":[],"FilterFields":[],"Options":[]};

// Form object for search
</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<?php

// Load records for display
if ($directors_delete->Recordset = $directors_delete->LoadRecordset())
	$directors_deleteTotalRecs = $directors_delete->Recordset->RecordCount(); // Get record count
if ($directors_deleteTotalRecs <= 0) { // No record found, exit
	if ($directors_delete->Recordset)
		$directors_delete->Recordset->Close();
	$directors_delete->Page_Terminate("directorslist.php"); // Return to list
}
?>
<?php $Breadcrumb->Render(); ?>
<?php $directors_delete->ShowPageHeader(); ?>
<?php
$directors_delete->ShowMessage();
?>
<form name="fdirectorsdelete" id="fdirectorsdelete" class="ewForm form-horizontal" action="<?php echo ew_CurrentPage() ?>" method="post">
<input type="hidden" name="t" value="directors">
<input type="hidden" name="a_delete" id="a_delete" value="D">
<?php foreach ($directors_delete->RecKeys as $key) { ?>
<?php $keyvalue = is_array($key) ? implode($EW_COMPOSITE_KEY_SEPARATOR, $key) : $key; ?>
<input type="hidden" name="key_m[]" value="<?php echo ew_HtmlEncode($keyvalue) ?>">
<?php } ?>
<table cellspacing="0" class="ewGrid"><tr><td class="ewGridContent">
<div class="ewGridMiddlePanel">
<table id="tbl_directorsdelete" class="ewTable ewTableSeparate">
<?php echo $directors->TableCustomInnerHtml ?>
	<thead>
	<tr class="ewTableHeader">
<?php if ($directors->name->Visible) { // name ?>
		<td><span id="elh_directors_name" class="directors_name"><?php echo $directors->name->FldCaption() ?></span></td>
<?php } ?>
<?php if ($directors->position->Visible) { // position ?>
		<td><span id="elh_directors_position" class="directors_position"><?php echo $directors->position->FldCaption() ?></span></td>
<?php } ?>
<?php if ($directors->category->Visible) { // category ?>
		<td><span id="elh_directors_category" class="directors_category"><?php echo $directors->category->FldCaption() ?></span></td>
<?php } ?>
<?php if ($directors->slug->Visible) { // slug ?>
		<td><span id="elh_directors_slug" class="directors_slug"><?php echo $directors->slug->FldCaption() ?></span></td>
<?php } ?>
<?php if ($directors->rate_ord->Visible) { // rate_ord ?>
		<td><span id="elh_directors_rate_ord" class="directors_rate_ord"><?php echo $directors->rate_ord->FldCaption() ?></span></td>
<?php } ?>
	</tr>
	</thead>
	<tbody>
<?php
$directors_delete->RecCnt = 0;
$i = 0;
while (!$directors_delete->Recordset->EOF) {
	$directors_delete->RecCnt++;
	$directors_delete->RowCnt++;

	// Set row properties
	$directors->ResetAttrs();
	$directors->RowType = EW_ROWTYPE_VIEW; // View

	// Get the field contents
	$directors_delete->LoadRowValues($directors_delete->Recordset);

	// Render row
	$directors_delete->RenderRow();
?>
	<tr<?php echo $directors->RowAttributes() ?>>
<?php if ($directors->name->Visible) { // name ?>
		<td<?php echo $directors->name->CellAttributes() ?>>
<span id="el<?php echo $directors_delete->RowCnt ?>_directors_name" class="control-group directors_name">
<span<?php echo $directors->name->ViewAttributes() ?>>
<?php echo $directors->name->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($directors->position->Visible) { // position ?>
		<td<?php echo $directors->position->CellAttributes() ?>>
<span id="el<?php echo $directors_delete->RowCnt ?>_directors_position" class="control-group directors_position">
<span<?php echo $directors->position->ViewAttributes() ?>>
<?php echo $directors->position->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($directors->category->Visible) { // category ?>
		<td<?php echo $directors->category->CellAttributes() ?>>
<span id="el<?php echo $directors_delete->RowCnt ?>_directors_category" class="control-group directors_category">
<span<?php echo $directors->category->ViewAttributes() ?>>
<?php echo $directors->category->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($directors->slug->Visible) { // slug ?>
		<td<?php echo $directors->slug->CellAttributes() ?>>
<span id="el<?php echo $directors_delete->RowCnt ?>_directors_slug" class="control-group directors_slug">
<span<?php echo $directors->slug->ViewAttributes() ?>>
<?php echo $directors->slug->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($directors->rate_ord->Visible) { // rate_ord ?>
		<td<?php echo $directors->rate_ord->CellAttributes() ?>>
<span id="el<?php echo $directors_delete->RowCnt ?>_directors_rate_ord" class="control-group directors_rate_ord">
<span<?php echo $directors->rate_ord->ViewAttributes() ?>>
<?php echo $directors->rate_ord->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
	</tr>
<?php
	$directors_delete->Recordset->MoveNext();
}
$directors_delete->Recordset->Close();
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
fdirectorsdelete.Init();
</script>
<?php
$directors_delete->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$directors_delete->Page_Terminate();
?>
