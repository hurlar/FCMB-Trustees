<?php
if (session_id() == "") session_start(); // Initialize Session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg10.php" ?>
<?php include_once "ewmysql10.php" ?>
<?php include_once "phpfn10.php" ?>
<?php include_once "trustee_tbinfo.php" ?>
<?php include_once "adminusersinfo.php" ?>
<?php include_once "personal_infoinfo.php" ?>
<?php include_once "comprehensivewill_tbinfo.php" ?>
<?php include_once "premiumwill_tbinfo.php" ?>
<?php include_once "privatetrust_tbinfo.php" ?>
<?php include_once "userfn10.php" ?>
<?php

//
// Page class
//

$trustee_tb_delete = NULL; // Initialize page object first

class ctrustee_tb_delete extends ctrustee_tb {

	// Page ID
	var $PageID = 'delete';

	// Project ID
	var $ProjectID = "{D9B361E7-B2C1-4293-B9B3-B581986A15CC}";

	// Table name
	var $TableName = 'trustee_tb';

	// Page object name
	var $PageObjName = 'trustee_tb_delete';

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

		// Table object (trustee_tb)
		if (!isset($GLOBALS["trustee_tb"])) {
			$GLOBALS["trustee_tb"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["trustee_tb"];
		}

		// Table object (adminusers)
		if (!isset($GLOBALS['adminusers'])) $GLOBALS['adminusers'] = new cadminusers();

		// Table object (personal_info)
		if (!isset($GLOBALS['personal_info'])) $GLOBALS['personal_info'] = new cpersonal_info();

		// Table object (comprehensivewill_tb)
		if (!isset($GLOBALS['comprehensivewill_tb'])) $GLOBALS['comprehensivewill_tb'] = new ccomprehensivewill_tb();

		// Table object (premiumwill_tb)
		if (!isset($GLOBALS['premiumwill_tb'])) $GLOBALS['premiumwill_tb'] = new cpremiumwill_tb();

		// Table object (privatetrust_tb)
		if (!isset($GLOBALS['privatetrust_tb'])) $GLOBALS['privatetrust_tb'] = new cprivatetrust_tb();

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'delete', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'trustee_tb', TRUE);

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
			$this->Page_Terminate("trustee_tblist.php"); // Prevent SQL injection, return to list

		// Set up filter (SQL WHHERE clause) and get return SQL
		// SQL constructor in trustee_tb class, trustee_tbinfo.php

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
		$this->title->setDbValue($rs->fields('title'));
		$this->fullname->setDbValue($rs->fields('fullname'));
		$this->rtionship->setDbValue($rs->fields('rtionship'));
		$this->_email->setDbValue($rs->fields('email'));
		$this->phone->setDbValue($rs->fields('phone'));
		$this->addr->setDbValue($rs->fields('addr'));
		$this->city->setDbValue($rs->fields('city'));
		$this->state->setDbValue($rs->fields('state'));
		$this->datecreated->setDbValue($rs->fields('datecreated'));
	}

	// Load DbValue from recordset
	function LoadDbValues(&$rs) {
		if (!$rs || !is_array($rs) && $rs->EOF) return;
		$row = is_array($rs) ? $rs : $rs->fields;
		$this->id->DbValue = $row['id'];
		$this->uid->DbValue = $row['uid'];
		$this->title->DbValue = $row['title'];
		$this->fullname->DbValue = $row['fullname'];
		$this->rtionship->DbValue = $row['rtionship'];
		$this->_email->DbValue = $row['email'];
		$this->phone->DbValue = $row['phone'];
		$this->addr->DbValue = $row['addr'];
		$this->city->DbValue = $row['city'];
		$this->state->DbValue = $row['state'];
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
		// title
		// fullname
		// rtionship
		// email
		// phone
		// addr
		// city
		// state
		// datecreated

		if ($this->RowType == EW_ROWTYPE_VIEW) { // View row

			// id
			$this->id->ViewValue = $this->id->CurrentValue;
			$this->id->ViewCustomAttributes = "";

			// uid
			$this->uid->ViewValue = $this->uid->CurrentValue;
			$this->uid->ViewCustomAttributes = "";

			// title
			$this->title->ViewValue = $this->title->CurrentValue;
			$this->title->ViewCustomAttributes = "";

			// fullname
			$this->fullname->ViewValue = $this->fullname->CurrentValue;
			$this->fullname->ViewCustomAttributes = "";

			// rtionship
			$this->rtionship->ViewValue = $this->rtionship->CurrentValue;
			$this->rtionship->ViewCustomAttributes = "";

			// email
			$this->_email->ViewValue = $this->_email->CurrentValue;
			$this->_email->ViewCustomAttributes = "";

			// phone
			$this->phone->ViewValue = $this->phone->CurrentValue;
			$this->phone->ViewCustomAttributes = "";

			// city
			$this->city->ViewValue = $this->city->CurrentValue;
			$this->city->ViewCustomAttributes = "";

			// state
			$this->state->ViewValue = $this->state->CurrentValue;
			$this->state->ViewCustomAttributes = "";

			// datecreated
			$this->datecreated->ViewValue = $this->datecreated->CurrentValue;
			$this->datecreated->ViewCustomAttributes = "";

			// id
			$this->id->LinkCustomAttributes = "";
			$this->id->HrefValue = "";
			$this->id->TooltipValue = "";

			// title
			$this->title->LinkCustomAttributes = "";
			$this->title->HrefValue = "";
			$this->title->TooltipValue = "";

			// fullname
			$this->fullname->LinkCustomAttributes = "";
			$this->fullname->HrefValue = "";
			$this->fullname->TooltipValue = "";

			// rtionship
			$this->rtionship->LinkCustomAttributes = "";
			$this->rtionship->HrefValue = "";
			$this->rtionship->TooltipValue = "";

			// email
			$this->_email->LinkCustomAttributes = "";
			$this->_email->HrefValue = "";
			$this->_email->TooltipValue = "";

			// phone
			$this->phone->LinkCustomAttributes = "";
			$this->phone->HrefValue = "";
			$this->phone->TooltipValue = "";

			// city
			$this->city->LinkCustomAttributes = "";
			$this->city->HrefValue = "";
			$this->city->TooltipValue = "";

			// state
			$this->state->LinkCustomAttributes = "";
			$this->state->HrefValue = "";
			$this->state->TooltipValue = "";

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
		$Breadcrumb->Add("list", "<span id=\"ewPageCaption\">" . $PageCaption . "</span>", "trustee_tblist.php", $this->TableVar);
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
if (!isset($trustee_tb_delete)) $trustee_tb_delete = new ctrustee_tb_delete();

// Page init
$trustee_tb_delete->Page_Init();

// Page main
$trustee_tb_delete->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$trustee_tb_delete->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Page object
var trustee_tb_delete = new ew_Page("trustee_tb_delete");
trustee_tb_delete.PageID = "delete"; // Page ID
var EW_PAGE_ID = trustee_tb_delete.PageID; // For backward compatibility

// Form object
var ftrustee_tbdelete = new ew_Form("ftrustee_tbdelete");

// Form_CustomValidate event
ftrustee_tbdelete.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
ftrustee_tbdelete.ValidateRequired = true;
<?php } else { ?>
ftrustee_tbdelete.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
// Form object for search

</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<?php

// Load records for display
if ($trustee_tb_delete->Recordset = $trustee_tb_delete->LoadRecordset())
	$trustee_tb_deleteTotalRecs = $trustee_tb_delete->Recordset->RecordCount(); // Get record count
if ($trustee_tb_deleteTotalRecs <= 0) { // No record found, exit
	if ($trustee_tb_delete->Recordset)
		$trustee_tb_delete->Recordset->Close();
	$trustee_tb_delete->Page_Terminate("trustee_tblist.php"); // Return to list
}
?>
<?php $Breadcrumb->Render(); ?>
<?php $trustee_tb_delete->ShowPageHeader(); ?>
<?php
$trustee_tb_delete->ShowMessage();
?>
<form name="ftrustee_tbdelete" id="ftrustee_tbdelete" class="ewForm form-horizontal" action="<?php echo ew_CurrentPage() ?>" method="post">
<input type="hidden" name="t" value="trustee_tb">
<input type="hidden" name="a_delete" id="a_delete" value="D">
<?php foreach ($trustee_tb_delete->RecKeys as $key) { ?>
<?php $keyvalue = is_array($key) ? implode($EW_COMPOSITE_KEY_SEPARATOR, $key) : $key; ?>
<input type="hidden" name="key_m[]" value="<?php echo ew_HtmlEncode($keyvalue) ?>">
<?php } ?>
<table cellspacing="0" class="ewGrid"><tr><td class="ewGridContent">
<div class="ewGridMiddlePanel">
<table id="tbl_trustee_tbdelete" class="ewTable ewTableSeparate">
<?php echo $trustee_tb->TableCustomInnerHtml ?>
	<thead>
	<tr class="ewTableHeader">
<?php if ($trustee_tb->id->Visible) { // id ?>
		<td><span id="elh_trustee_tb_id" class="trustee_tb_id"><?php echo $trustee_tb->id->FldCaption() ?></span></td>
<?php } ?>
<?php if ($trustee_tb->title->Visible) { // title ?>
		<td><span id="elh_trustee_tb_title" class="trustee_tb_title"><?php echo $trustee_tb->title->FldCaption() ?></span></td>
<?php } ?>
<?php if ($trustee_tb->fullname->Visible) { // fullname ?>
		<td><span id="elh_trustee_tb_fullname" class="trustee_tb_fullname"><?php echo $trustee_tb->fullname->FldCaption() ?></span></td>
<?php } ?>
<?php if ($trustee_tb->rtionship->Visible) { // rtionship ?>
		<td><span id="elh_trustee_tb_rtionship" class="trustee_tb_rtionship"><?php echo $trustee_tb->rtionship->FldCaption() ?></span></td>
<?php } ?>
<?php if ($trustee_tb->_email->Visible) { // email ?>
		<td><span id="elh_trustee_tb__email" class="trustee_tb__email"><?php echo $trustee_tb->_email->FldCaption() ?></span></td>
<?php } ?>
<?php if ($trustee_tb->phone->Visible) { // phone ?>
		<td><span id="elh_trustee_tb_phone" class="trustee_tb_phone"><?php echo $trustee_tb->phone->FldCaption() ?></span></td>
<?php } ?>
<?php if ($trustee_tb->city->Visible) { // city ?>
		<td><span id="elh_trustee_tb_city" class="trustee_tb_city"><?php echo $trustee_tb->city->FldCaption() ?></span></td>
<?php } ?>
<?php if ($trustee_tb->state->Visible) { // state ?>
		<td><span id="elh_trustee_tb_state" class="trustee_tb_state"><?php echo $trustee_tb->state->FldCaption() ?></span></td>
<?php } ?>
<?php if ($trustee_tb->datecreated->Visible) { // datecreated ?>
		<td><span id="elh_trustee_tb_datecreated" class="trustee_tb_datecreated"><?php echo $trustee_tb->datecreated->FldCaption() ?></span></td>
<?php } ?>
	</tr>
	</thead>
	<tbody>
<?php
$trustee_tb_delete->RecCnt = 0;
$i = 0;
while (!$trustee_tb_delete->Recordset->EOF) {
	$trustee_tb_delete->RecCnt++;
	$trustee_tb_delete->RowCnt++;

	// Set row properties
	$trustee_tb->ResetAttrs();
	$trustee_tb->RowType = EW_ROWTYPE_VIEW; // View

	// Get the field contents
	$trustee_tb_delete->LoadRowValues($trustee_tb_delete->Recordset);

	// Render row
	$trustee_tb_delete->RenderRow();
?>
	<tr<?php echo $trustee_tb->RowAttributes() ?>>
<?php if ($trustee_tb->id->Visible) { // id ?>
		<td<?php echo $trustee_tb->id->CellAttributes() ?>>
<span id="el<?php echo $trustee_tb_delete->RowCnt ?>_trustee_tb_id" class="control-group trustee_tb_id">
<span<?php echo $trustee_tb->id->ViewAttributes() ?>>
<?php echo $trustee_tb->id->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($trustee_tb->title->Visible) { // title ?>
		<td<?php echo $trustee_tb->title->CellAttributes() ?>>
<span id="el<?php echo $trustee_tb_delete->RowCnt ?>_trustee_tb_title" class="control-group trustee_tb_title">
<span<?php echo $trustee_tb->title->ViewAttributes() ?>>
<?php echo $trustee_tb->title->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($trustee_tb->fullname->Visible) { // fullname ?>
		<td<?php echo $trustee_tb->fullname->CellAttributes() ?>>
<span id="el<?php echo $trustee_tb_delete->RowCnt ?>_trustee_tb_fullname" class="control-group trustee_tb_fullname">
<span<?php echo $trustee_tb->fullname->ViewAttributes() ?>>
<?php echo $trustee_tb->fullname->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($trustee_tb->rtionship->Visible) { // rtionship ?>
		<td<?php echo $trustee_tb->rtionship->CellAttributes() ?>>
<span id="el<?php echo $trustee_tb_delete->RowCnt ?>_trustee_tb_rtionship" class="control-group trustee_tb_rtionship">
<span<?php echo $trustee_tb->rtionship->ViewAttributes() ?>>
<?php echo $trustee_tb->rtionship->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($trustee_tb->_email->Visible) { // email ?>
		<td<?php echo $trustee_tb->_email->CellAttributes() ?>>
<span id="el<?php echo $trustee_tb_delete->RowCnt ?>_trustee_tb__email" class="control-group trustee_tb__email">
<span<?php echo $trustee_tb->_email->ViewAttributes() ?>>
<?php echo $trustee_tb->_email->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($trustee_tb->phone->Visible) { // phone ?>
		<td<?php echo $trustee_tb->phone->CellAttributes() ?>>
<span id="el<?php echo $trustee_tb_delete->RowCnt ?>_trustee_tb_phone" class="control-group trustee_tb_phone">
<span<?php echo $trustee_tb->phone->ViewAttributes() ?>>
<?php echo $trustee_tb->phone->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($trustee_tb->city->Visible) { // city ?>
		<td<?php echo $trustee_tb->city->CellAttributes() ?>>
<span id="el<?php echo $trustee_tb_delete->RowCnt ?>_trustee_tb_city" class="control-group trustee_tb_city">
<span<?php echo $trustee_tb->city->ViewAttributes() ?>>
<?php echo $trustee_tb->city->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($trustee_tb->state->Visible) { // state ?>
		<td<?php echo $trustee_tb->state->CellAttributes() ?>>
<span id="el<?php echo $trustee_tb_delete->RowCnt ?>_trustee_tb_state" class="control-group trustee_tb_state">
<span<?php echo $trustee_tb->state->ViewAttributes() ?>>
<?php echo $trustee_tb->state->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($trustee_tb->datecreated->Visible) { // datecreated ?>
		<td<?php echo $trustee_tb->datecreated->CellAttributes() ?>>
<span id="el<?php echo $trustee_tb_delete->RowCnt ?>_trustee_tb_datecreated" class="control-group trustee_tb_datecreated">
<span<?php echo $trustee_tb->datecreated->ViewAttributes() ?>>
<?php echo $trustee_tb->datecreated->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
	</tr>
<?php
	$trustee_tb_delete->Recordset->MoveNext();
}
$trustee_tb_delete->Recordset->Close();
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
ftrustee_tbdelete.Init();
</script>
<?php
$trustee_tb_delete->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$trustee_tb_delete->Page_Terminate();
?>
