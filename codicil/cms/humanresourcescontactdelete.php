<?php
if (session_id() == "") session_start(); // Initialize Session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg10.php" ?>
<?php include_once "ewmysql10.php" ?>
<?php include_once "phpfn10.php" ?>
<?php include_once "humanresourcescontactinfo.php" ?>
<?php include_once "adminusersinfo.php" ?>
<?php include_once "userfn10.php" ?>
<?php

//
// Page class
//

$humanresourcescontact_delete = NULL; // Initialize page object first

class chumanresourcescontact_delete extends chumanresourcescontact {

	// Page ID
	var $PageID = 'delete';

	// Project ID
	var $ProjectID = "{D9B361E7-B2C1-4293-B9B3-B581986A15CC}";

	// Table name
	var $TableName = 'humanresourcescontact';

	// Page object name
	var $PageObjName = 'humanresourcescontact_delete';

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

		// Table object (humanresourcescontact)
		if (!isset($GLOBALS["humanresourcescontact"])) {
			$GLOBALS["humanresourcescontact"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["humanresourcescontact"];
		}

		// Table object (adminusers)
		if (!isset($GLOBALS['adminusers'])) $GLOBALS['adminusers'] = new cadminusers();

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'delete', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'humanresourcescontact', TRUE);

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
			$this->Page_Terminate("humanresourcescontactlist.php"); // Prevent SQL injection, return to list

		// Set up filter (SQL WHHERE clause) and get return SQL
		// SQL constructor in humanresourcescontact class, humanresourcescontactinfo.php

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
		$this->nameofcompany->setDbValue($rs->fields('nameofcompany'));
		$this->telephone->setDbValue($rs->fields('telephone'));
		$this->emailaddress->setDbValue($rs->fields('emailaddress'));
	}

	// Load DbValue from recordset
	function LoadDbValues(&$rs) {
		if (!$rs || !is_array($rs) && $rs->EOF) return;
		$row = is_array($rs) ? $rs : $rs->fields;
		$this->id->DbValue = $row['id'];
		$this->uid->DbValue = $row['uid'];
		$this->nameofcompany->DbValue = $row['nameofcompany'];
		$this->telephone->DbValue = $row['telephone'];
		$this->emailaddress->DbValue = $row['emailaddress'];
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
		// nameofcompany
		// telephone
		// emailaddress

		if ($this->RowType == EW_ROWTYPE_VIEW) { // View row

			// id
			$this->id->ViewValue = $this->id->CurrentValue;
			$this->id->ViewCustomAttributes = "";

			// uid
			$this->uid->ViewValue = $this->uid->CurrentValue;
			$this->uid->ViewCustomAttributes = "";

			// nameofcompany
			$this->nameofcompany->ViewValue = $this->nameofcompany->CurrentValue;
			$this->nameofcompany->ViewCustomAttributes = "";

			// telephone
			$this->telephone->ViewValue = $this->telephone->CurrentValue;
			$this->telephone->ViewCustomAttributes = "";

			// emailaddress
			$this->emailaddress->ViewValue = $this->emailaddress->CurrentValue;
			$this->emailaddress->ViewCustomAttributes = "";

			// id
			$this->id->LinkCustomAttributes = "";
			$this->id->HrefValue = "";
			$this->id->TooltipValue = "";

			// uid
			$this->uid->LinkCustomAttributes = "";
			$this->uid->HrefValue = "";
			$this->uid->TooltipValue = "";

			// nameofcompany
			$this->nameofcompany->LinkCustomAttributes = "";
			$this->nameofcompany->HrefValue = "";
			$this->nameofcompany->TooltipValue = "";

			// telephone
			$this->telephone->LinkCustomAttributes = "";
			$this->telephone->HrefValue = "";
			$this->telephone->TooltipValue = "";

			// emailaddress
			$this->emailaddress->LinkCustomAttributes = "";
			$this->emailaddress->HrefValue = "";
			$this->emailaddress->TooltipValue = "";
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
		$Breadcrumb->Add("list", "<span id=\"ewPageCaption\">" . $PageCaption . "</span>", "humanresourcescontactlist.php", $this->TableVar);
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
if (!isset($humanresourcescontact_delete)) $humanresourcescontact_delete = new chumanresourcescontact_delete();

// Page init
$humanresourcescontact_delete->Page_Init();

// Page main
$humanresourcescontact_delete->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$humanresourcescontact_delete->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Page object
var humanresourcescontact_delete = new ew_Page("humanresourcescontact_delete");
humanresourcescontact_delete.PageID = "delete"; // Page ID
var EW_PAGE_ID = humanresourcescontact_delete.PageID; // For backward compatibility

// Form object
var fhumanresourcescontactdelete = new ew_Form("fhumanresourcescontactdelete");

// Form_CustomValidate event
fhumanresourcescontactdelete.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
fhumanresourcescontactdelete.ValidateRequired = true;
<?php } else { ?>
fhumanresourcescontactdelete.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
// Form object for search

</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<?php

// Load records for display
if ($humanresourcescontact_delete->Recordset = $humanresourcescontact_delete->LoadRecordset())
	$humanresourcescontact_deleteTotalRecs = $humanresourcescontact_delete->Recordset->RecordCount(); // Get record count
if ($humanresourcescontact_deleteTotalRecs <= 0) { // No record found, exit
	if ($humanresourcescontact_delete->Recordset)
		$humanresourcescontact_delete->Recordset->Close();
	$humanresourcescontact_delete->Page_Terminate("humanresourcescontactlist.php"); // Return to list
}
?>
<?php $Breadcrumb->Render(); ?>
<?php $humanresourcescontact_delete->ShowPageHeader(); ?>
<?php
$humanresourcescontact_delete->ShowMessage();
?>
<form name="fhumanresourcescontactdelete" id="fhumanresourcescontactdelete" class="ewForm form-horizontal" action="<?php echo ew_CurrentPage() ?>" method="post">
<input type="hidden" name="t" value="humanresourcescontact">
<input type="hidden" name="a_delete" id="a_delete" value="D">
<?php foreach ($humanresourcescontact_delete->RecKeys as $key) { ?>
<?php $keyvalue = is_array($key) ? implode($EW_COMPOSITE_KEY_SEPARATOR, $key) : $key; ?>
<input type="hidden" name="key_m[]" value="<?php echo ew_HtmlEncode($keyvalue) ?>">
<?php } ?>
<table cellspacing="0" class="ewGrid"><tr><td class="ewGridContent">
<div class="ewGridMiddlePanel">
<table id="tbl_humanresourcescontactdelete" class="ewTable ewTableSeparate">
<?php echo $humanresourcescontact->TableCustomInnerHtml ?>
	<thead>
	<tr class="ewTableHeader">
<?php if ($humanresourcescontact->id->Visible) { // id ?>
		<td><span id="elh_humanresourcescontact_id" class="humanresourcescontact_id"><?php echo $humanresourcescontact->id->FldCaption() ?></span></td>
<?php } ?>
<?php if ($humanresourcescontact->uid->Visible) { // uid ?>
		<td><span id="elh_humanresourcescontact_uid" class="humanresourcescontact_uid"><?php echo $humanresourcescontact->uid->FldCaption() ?></span></td>
<?php } ?>
<?php if ($humanresourcescontact->nameofcompany->Visible) { // nameofcompany ?>
		<td><span id="elh_humanresourcescontact_nameofcompany" class="humanresourcescontact_nameofcompany"><?php echo $humanresourcescontact->nameofcompany->FldCaption() ?></span></td>
<?php } ?>
<?php if ($humanresourcescontact->telephone->Visible) { // telephone ?>
		<td><span id="elh_humanresourcescontact_telephone" class="humanresourcescontact_telephone"><?php echo $humanresourcescontact->telephone->FldCaption() ?></span></td>
<?php } ?>
<?php if ($humanresourcescontact->emailaddress->Visible) { // emailaddress ?>
		<td><span id="elh_humanresourcescontact_emailaddress" class="humanresourcescontact_emailaddress"><?php echo $humanresourcescontact->emailaddress->FldCaption() ?></span></td>
<?php } ?>
	</tr>
	</thead>
	<tbody>
<?php
$humanresourcescontact_delete->RecCnt = 0;
$i = 0;
while (!$humanresourcescontact_delete->Recordset->EOF) {
	$humanresourcescontact_delete->RecCnt++;
	$humanresourcescontact_delete->RowCnt++;

	// Set row properties
	$humanresourcescontact->ResetAttrs();
	$humanresourcescontact->RowType = EW_ROWTYPE_VIEW; // View

	// Get the field contents
	$humanresourcescontact_delete->LoadRowValues($humanresourcescontact_delete->Recordset);

	// Render row
	$humanresourcescontact_delete->RenderRow();
?>
	<tr<?php echo $humanresourcescontact->RowAttributes() ?>>
<?php if ($humanresourcescontact->id->Visible) { // id ?>
		<td<?php echo $humanresourcescontact->id->CellAttributes() ?>>
<span id="el<?php echo $humanresourcescontact_delete->RowCnt ?>_humanresourcescontact_id" class="control-group humanresourcescontact_id">
<span<?php echo $humanresourcescontact->id->ViewAttributes() ?>>
<?php echo $humanresourcescontact->id->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($humanresourcescontact->uid->Visible) { // uid ?>
		<td<?php echo $humanresourcescontact->uid->CellAttributes() ?>>
<span id="el<?php echo $humanresourcescontact_delete->RowCnt ?>_humanresourcescontact_uid" class="control-group humanresourcescontact_uid">
<span<?php echo $humanresourcescontact->uid->ViewAttributes() ?>>
<?php echo $humanresourcescontact->uid->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($humanresourcescontact->nameofcompany->Visible) { // nameofcompany ?>
		<td<?php echo $humanresourcescontact->nameofcompany->CellAttributes() ?>>
<span id="el<?php echo $humanresourcescontact_delete->RowCnt ?>_humanresourcescontact_nameofcompany" class="control-group humanresourcescontact_nameofcompany">
<span<?php echo $humanresourcescontact->nameofcompany->ViewAttributes() ?>>
<?php echo $humanresourcescontact->nameofcompany->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($humanresourcescontact->telephone->Visible) { // telephone ?>
		<td<?php echo $humanresourcescontact->telephone->CellAttributes() ?>>
<span id="el<?php echo $humanresourcescontact_delete->RowCnt ?>_humanresourcescontact_telephone" class="control-group humanresourcescontact_telephone">
<span<?php echo $humanresourcescontact->telephone->ViewAttributes() ?>>
<?php echo $humanresourcescontact->telephone->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($humanresourcescontact->emailaddress->Visible) { // emailaddress ?>
		<td<?php echo $humanresourcescontact->emailaddress->CellAttributes() ?>>
<span id="el<?php echo $humanresourcescontact_delete->RowCnt ?>_humanresourcescontact_emailaddress" class="control-group humanresourcescontact_emailaddress">
<span<?php echo $humanresourcescontact->emailaddress->ViewAttributes() ?>>
<?php echo $humanresourcescontact->emailaddress->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
	</tr>
<?php
	$humanresourcescontact_delete->Recordset->MoveNext();
}
$humanresourcescontact_delete->Recordset->Close();
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
fhumanresourcescontactdelete.Init();
</script>
<?php
$humanresourcescontact_delete->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$humanresourcescontact_delete->Page_Terminate();
?>
