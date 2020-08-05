<?php
if (session_id() == "") session_start(); // Initialize Session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg10.php" ?>
<?php include_once "ewmysql10.php" ?>
<?php include_once "phpfn10.php" ?>
<?php include_once "processflow_tbinfo.php" ?>
<?php include_once "adminusersinfo.php" ?>
<?php include_once "userfn10.php" ?>
<?php

//
// Page class
//

$processflow_tb_delete = NULL; // Initialize page object first

class cprocessflow_tb_delete extends cprocessflow_tb {

	// Page ID
	var $PageID = 'delete';

	// Project ID
	var $ProjectID = "{D9B361E7-B2C1-4293-B9B3-B581986A15CC}";

	// Table name
	var $TableName = 'processflow_tb';

	// Page object name
	var $PageObjName = 'processflow_tb_delete';

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

		// Table object (processflow_tb)
		if (!isset($GLOBALS["processflow_tb"])) {
			$GLOBALS["processflow_tb"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["processflow_tb"];
		}

		// Table object (adminusers)
		if (!isset($GLOBALS['adminusers'])) $GLOBALS['adminusers'] = new cadminusers();

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'delete', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'processflow_tb', TRUE);

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
			$this->Page_Terminate("processflow_tblist.php"); // Prevent SQL injection, return to list

		// Set up filter (SQL WHHERE clause) and get return SQL
		// SQL constructor in processflow_tb class, processflow_tbinfo.php

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
		$this->name->setDbValue($rs->fields('name'));
		$this->_email->setDbValue($rs->fields('email'));
		$this->stage->setDbValue($rs->fields('stage'));
		$this->progress->setDbValue($rs->fields('progress'));
		$this->stage2->setDbValue($rs->fields('stage2'));
		$this->progress2->setDbValue($rs->fields('progress2'));
		$this->stage3->setDbValue($rs->fields('stage3'));
		$this->progress3->setDbValue($rs->fields('progress3'));
		$this->stage4->setDbValue($rs->fields('stage4'));
		$this->progress4->setDbValue($rs->fields('progress4'));
		$this->stage5->setDbValue($rs->fields('stage5'));
		$this->progress5->setDbValue($rs->fields('progress5'));
		$this->stage6->setDbValue($rs->fields('stage6'));
		$this->progress6->setDbValue($rs->fields('progress6'));
	}

	// Load DbValue from recordset
	function LoadDbValues(&$rs) {
		if (!$rs || !is_array($rs) && $rs->EOF) return;
		$row = is_array($rs) ? $rs : $rs->fields;
		$this->id->DbValue = $row['id'];
		$this->uid->DbValue = $row['uid'];
		$this->name->DbValue = $row['name'];
		$this->_email->DbValue = $row['email'];
		$this->stage->DbValue = $row['stage'];
		$this->progress->DbValue = $row['progress'];
		$this->stage2->DbValue = $row['stage2'];
		$this->progress2->DbValue = $row['progress2'];
		$this->stage3->DbValue = $row['stage3'];
		$this->progress3->DbValue = $row['progress3'];
		$this->stage4->DbValue = $row['stage4'];
		$this->progress4->DbValue = $row['progress4'];
		$this->stage5->DbValue = $row['stage5'];
		$this->progress5->DbValue = $row['progress5'];
		$this->stage6->DbValue = $row['stage6'];
		$this->progress6->DbValue = $row['progress6'];
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

		$this->uid->CellCssStyle = "white-space: nowrap;";

		// name
		// email
		// stage

		$this->stage->CellCssStyle = "white-space: nowrap;";

		// progress
		// stage2

		$this->stage2->CellCssStyle = "white-space: nowrap;";

		// progress2
		// stage3

		$this->stage3->CellCssStyle = "white-space: nowrap;";

		// progress3
		// stage4

		$this->stage4->CellCssStyle = "white-space: nowrap;";

		// progress4
		// stage5

		$this->stage5->CellCssStyle = "white-space: nowrap;";

		// progress5
		// stage6

		$this->stage6->CellCssStyle = "white-space: nowrap;";

		// progress6
		if ($this->RowType == EW_ROWTYPE_VIEW) { // View row

			// id
			$this->id->ViewValue = $this->id->CurrentValue;
			$this->id->ViewCustomAttributes = "";

			// name
			$this->name->ViewValue = $this->name->CurrentValue;
			$this->name->ViewCustomAttributes = "";

			// email
			$this->_email->ViewValue = $this->_email->CurrentValue;
			$this->_email->ViewCustomAttributes = "";

			// progress
			if (strval($this->progress->CurrentValue) <> "") {
				switch ($this->progress->CurrentValue) {
					case $this->progress->FldTagValue(1):
						$this->progress->ViewValue = $this->progress->FldTagCaption(1) <> "" ? $this->progress->FldTagCaption(1) : $this->progress->CurrentValue;
						break;
					case $this->progress->FldTagValue(2):
						$this->progress->ViewValue = $this->progress->FldTagCaption(2) <> "" ? $this->progress->FldTagCaption(2) : $this->progress->CurrentValue;
						break;
					case $this->progress->FldTagValue(3):
						$this->progress->ViewValue = $this->progress->FldTagCaption(3) <> "" ? $this->progress->FldTagCaption(3) : $this->progress->CurrentValue;
						break;
					default:
						$this->progress->ViewValue = $this->progress->CurrentValue;
				}
			} else {
				$this->progress->ViewValue = NULL;
			}
			$this->progress->ViewCustomAttributes = "";

			// progress2
			if (strval($this->progress2->CurrentValue) <> "") {
				switch ($this->progress2->CurrentValue) {
					case $this->progress2->FldTagValue(1):
						$this->progress2->ViewValue = $this->progress2->FldTagCaption(1) <> "" ? $this->progress2->FldTagCaption(1) : $this->progress2->CurrentValue;
						break;
					case $this->progress2->FldTagValue(2):
						$this->progress2->ViewValue = $this->progress2->FldTagCaption(2) <> "" ? $this->progress2->FldTagCaption(2) : $this->progress2->CurrentValue;
						break;
					case $this->progress2->FldTagValue(3):
						$this->progress2->ViewValue = $this->progress2->FldTagCaption(3) <> "" ? $this->progress2->FldTagCaption(3) : $this->progress2->CurrentValue;
						break;
					default:
						$this->progress2->ViewValue = $this->progress2->CurrentValue;
				}
			} else {
				$this->progress2->ViewValue = NULL;
			}
			$this->progress2->ViewCustomAttributes = "";

			// progress3
			if (strval($this->progress3->CurrentValue) <> "") {
				switch ($this->progress3->CurrentValue) {
					case $this->progress3->FldTagValue(1):
						$this->progress3->ViewValue = $this->progress3->FldTagCaption(1) <> "" ? $this->progress3->FldTagCaption(1) : $this->progress3->CurrentValue;
						break;
					case $this->progress3->FldTagValue(2):
						$this->progress3->ViewValue = $this->progress3->FldTagCaption(2) <> "" ? $this->progress3->FldTagCaption(2) : $this->progress3->CurrentValue;
						break;
					case $this->progress3->FldTagValue(3):
						$this->progress3->ViewValue = $this->progress3->FldTagCaption(3) <> "" ? $this->progress3->FldTagCaption(3) : $this->progress3->CurrentValue;
						break;
					default:
						$this->progress3->ViewValue = $this->progress3->CurrentValue;
				}
			} else {
				$this->progress3->ViewValue = NULL;
			}
			$this->progress3->ViewCustomAttributes = "";

			// progress4
			if (strval($this->progress4->CurrentValue) <> "") {
				switch ($this->progress4->CurrentValue) {
					case $this->progress4->FldTagValue(1):
						$this->progress4->ViewValue = $this->progress4->FldTagCaption(1) <> "" ? $this->progress4->FldTagCaption(1) : $this->progress4->CurrentValue;
						break;
					case $this->progress4->FldTagValue(2):
						$this->progress4->ViewValue = $this->progress4->FldTagCaption(2) <> "" ? $this->progress4->FldTagCaption(2) : $this->progress4->CurrentValue;
						break;
					case $this->progress4->FldTagValue(3):
						$this->progress4->ViewValue = $this->progress4->FldTagCaption(3) <> "" ? $this->progress4->FldTagCaption(3) : $this->progress4->CurrentValue;
						break;
					default:
						$this->progress4->ViewValue = $this->progress4->CurrentValue;
				}
			} else {
				$this->progress4->ViewValue = NULL;
			}
			$this->progress4->ViewCustomAttributes = "";

			// progress5
			if (strval($this->progress5->CurrentValue) <> "") {
				switch ($this->progress5->CurrentValue) {
					case $this->progress5->FldTagValue(1):
						$this->progress5->ViewValue = $this->progress5->FldTagCaption(1) <> "" ? $this->progress5->FldTagCaption(1) : $this->progress5->CurrentValue;
						break;
					case $this->progress5->FldTagValue(2):
						$this->progress5->ViewValue = $this->progress5->FldTagCaption(2) <> "" ? $this->progress5->FldTagCaption(2) : $this->progress5->CurrentValue;
						break;
					case $this->progress5->FldTagValue(3):
						$this->progress5->ViewValue = $this->progress5->FldTagCaption(3) <> "" ? $this->progress5->FldTagCaption(3) : $this->progress5->CurrentValue;
						break;
					default:
						$this->progress5->ViewValue = $this->progress5->CurrentValue;
				}
			} else {
				$this->progress5->ViewValue = NULL;
			}
			$this->progress5->ViewCustomAttributes = "";

			// progress6
			if (strval($this->progress6->CurrentValue) <> "") {
				switch ($this->progress6->CurrentValue) {
					case $this->progress6->FldTagValue(1):
						$this->progress6->ViewValue = $this->progress6->FldTagCaption(1) <> "" ? $this->progress6->FldTagCaption(1) : $this->progress6->CurrentValue;
						break;
					case $this->progress6->FldTagValue(2):
						$this->progress6->ViewValue = $this->progress6->FldTagCaption(2) <> "" ? $this->progress6->FldTagCaption(2) : $this->progress6->CurrentValue;
						break;
					case $this->progress6->FldTagValue(3):
						$this->progress6->ViewValue = $this->progress6->FldTagCaption(3) <> "" ? $this->progress6->FldTagCaption(3) : $this->progress6->CurrentValue;
						break;
					default:
						$this->progress6->ViewValue = $this->progress6->CurrentValue;
				}
			} else {
				$this->progress6->ViewValue = NULL;
			}
			$this->progress6->ViewCustomAttributes = "";

			// name
			$this->name->LinkCustomAttributes = "";
			$this->name->HrefValue = "";
			$this->name->TooltipValue = "";

			// email
			$this->_email->LinkCustomAttributes = "";
			$this->_email->HrefValue = "";
			$this->_email->TooltipValue = "";

			// progress
			$this->progress->LinkCustomAttributes = "";
			$this->progress->HrefValue = "";
			$this->progress->TooltipValue = "";

			// progress2
			$this->progress2->LinkCustomAttributes = "";
			$this->progress2->HrefValue = "";
			$this->progress2->TooltipValue = "";

			// progress3
			$this->progress3->LinkCustomAttributes = "";
			$this->progress3->HrefValue = "";
			$this->progress3->TooltipValue = "";

			// progress4
			$this->progress4->LinkCustomAttributes = "";
			$this->progress4->HrefValue = "";
			$this->progress4->TooltipValue = "";

			// progress5
			$this->progress5->LinkCustomAttributes = "";
			$this->progress5->HrefValue = "";
			$this->progress5->TooltipValue = "";

			// progress6
			$this->progress6->LinkCustomAttributes = "";
			$this->progress6->HrefValue = "";
			$this->progress6->TooltipValue = "";
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
		$Breadcrumb->Add("list", "<span id=\"ewPageCaption\">" . $PageCaption . "</span>", "processflow_tblist.php", $this->TableVar);
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
if (!isset($processflow_tb_delete)) $processflow_tb_delete = new cprocessflow_tb_delete();

// Page init
$processflow_tb_delete->Page_Init();

// Page main
$processflow_tb_delete->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$processflow_tb_delete->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Page object
var processflow_tb_delete = new ew_Page("processflow_tb_delete");
processflow_tb_delete.PageID = "delete"; // Page ID
var EW_PAGE_ID = processflow_tb_delete.PageID; // For backward compatibility

// Form object
var fprocessflow_tbdelete = new ew_Form("fprocessflow_tbdelete");

// Form_CustomValidate event
fprocessflow_tbdelete.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
fprocessflow_tbdelete.ValidateRequired = true;
<?php } else { ?>
fprocessflow_tbdelete.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
// Form object for search

</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<?php

// Load records for display
if ($processflow_tb_delete->Recordset = $processflow_tb_delete->LoadRecordset())
	$processflow_tb_deleteTotalRecs = $processflow_tb_delete->Recordset->RecordCount(); // Get record count
if ($processflow_tb_deleteTotalRecs <= 0) { // No record found, exit
	if ($processflow_tb_delete->Recordset)
		$processflow_tb_delete->Recordset->Close();
	$processflow_tb_delete->Page_Terminate("processflow_tblist.php"); // Return to list
}
?>
<?php $Breadcrumb->Render(); ?>
<?php $processflow_tb_delete->ShowPageHeader(); ?>
<?php
$processflow_tb_delete->ShowMessage();
?>
<form name="fprocessflow_tbdelete" id="fprocessflow_tbdelete" class="ewForm form-horizontal" action="<?php echo ew_CurrentPage() ?>" method="post">
<input type="hidden" name="t" value="processflow_tb">
<input type="hidden" name="a_delete" id="a_delete" value="D">
<?php foreach ($processflow_tb_delete->RecKeys as $key) { ?>
<?php $keyvalue = is_array($key) ? implode($EW_COMPOSITE_KEY_SEPARATOR, $key) : $key; ?>
<input type="hidden" name="key_m[]" value="<?php echo ew_HtmlEncode($keyvalue) ?>">
<?php } ?>
<table cellspacing="0" class="ewGrid"><tr><td class="ewGridContent">
<div class="ewGridMiddlePanel">
<table id="tbl_processflow_tbdelete" class="ewTable ewTableSeparate">
<?php echo $processflow_tb->TableCustomInnerHtml ?>
	<thead>
	<tr class="ewTableHeader">
<?php if ($processflow_tb->name->Visible) { // name ?>
		<td><span id="elh_processflow_tb_name" class="processflow_tb_name"><?php echo $processflow_tb->name->FldCaption() ?></span></td>
<?php } ?>
<?php if ($processflow_tb->_email->Visible) { // email ?>
		<td><span id="elh_processflow_tb__email" class="processflow_tb__email"><?php echo $processflow_tb->_email->FldCaption() ?></span></td>
<?php } ?>
<?php if ($processflow_tb->progress->Visible) { // progress ?>
		<td><span id="elh_processflow_tb_progress" class="processflow_tb_progress"><?php echo $processflow_tb->progress->FldCaption() ?></span></td>
<?php } ?>
<?php if ($processflow_tb->progress2->Visible) { // progress2 ?>
		<td><span id="elh_processflow_tb_progress2" class="processflow_tb_progress2"><?php echo $processflow_tb->progress2->FldCaption() ?></span></td>
<?php } ?>
<?php if ($processflow_tb->progress3->Visible) { // progress3 ?>
		<td><span id="elh_processflow_tb_progress3" class="processflow_tb_progress3"><?php echo $processflow_tb->progress3->FldCaption() ?></span></td>
<?php } ?>
<?php if ($processflow_tb->progress4->Visible) { // progress4 ?>
		<td><span id="elh_processflow_tb_progress4" class="processflow_tb_progress4"><?php echo $processflow_tb->progress4->FldCaption() ?></span></td>
<?php } ?>
<?php if ($processflow_tb->progress5->Visible) { // progress5 ?>
		<td><span id="elh_processflow_tb_progress5" class="processflow_tb_progress5"><?php echo $processflow_tb->progress5->FldCaption() ?></span></td>
<?php } ?>
<?php if ($processflow_tb->progress6->Visible) { // progress6 ?>
		<td><span id="elh_processflow_tb_progress6" class="processflow_tb_progress6"><?php echo $processflow_tb->progress6->FldCaption() ?></span></td>
<?php } ?>
	</tr>
	</thead>
	<tbody>
<?php
$processflow_tb_delete->RecCnt = 0;
$i = 0;
while (!$processflow_tb_delete->Recordset->EOF) {
	$processflow_tb_delete->RecCnt++;
	$processflow_tb_delete->RowCnt++;

	// Set row properties
	$processflow_tb->ResetAttrs();
	$processflow_tb->RowType = EW_ROWTYPE_VIEW; // View

	// Get the field contents
	$processflow_tb_delete->LoadRowValues($processflow_tb_delete->Recordset);

	// Render row
	$processflow_tb_delete->RenderRow();
?>
	<tr<?php echo $processflow_tb->RowAttributes() ?>>
<?php if ($processflow_tb->name->Visible) { // name ?>
		<td<?php echo $processflow_tb->name->CellAttributes() ?>>
<span id="el<?php echo $processflow_tb_delete->RowCnt ?>_processflow_tb_name" class="control-group processflow_tb_name">
<span<?php echo $processflow_tb->name->ViewAttributes() ?>>
<?php echo $processflow_tb->name->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($processflow_tb->_email->Visible) { // email ?>
		<td<?php echo $processflow_tb->_email->CellAttributes() ?>>
<span id="el<?php echo $processflow_tb_delete->RowCnt ?>_processflow_tb__email" class="control-group processflow_tb__email">
<span<?php echo $processflow_tb->_email->ViewAttributes() ?>>
<?php echo $processflow_tb->_email->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($processflow_tb->progress->Visible) { // progress ?>
		<td<?php echo $processflow_tb->progress->CellAttributes() ?>>
<span id="el<?php echo $processflow_tb_delete->RowCnt ?>_processflow_tb_progress" class="control-group processflow_tb_progress">
<span<?php echo $processflow_tb->progress->ViewAttributes() ?>>
<?php echo $processflow_tb->progress->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($processflow_tb->progress2->Visible) { // progress2 ?>
		<td<?php echo $processflow_tb->progress2->CellAttributes() ?>>
<span id="el<?php echo $processflow_tb_delete->RowCnt ?>_processflow_tb_progress2" class="control-group processflow_tb_progress2">
<span<?php echo $processflow_tb->progress2->ViewAttributes() ?>>
<?php echo $processflow_tb->progress2->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($processflow_tb->progress3->Visible) { // progress3 ?>
		<td<?php echo $processflow_tb->progress3->CellAttributes() ?>>
<span id="el<?php echo $processflow_tb_delete->RowCnt ?>_processflow_tb_progress3" class="control-group processflow_tb_progress3">
<span<?php echo $processflow_tb->progress3->ViewAttributes() ?>>
<?php echo $processflow_tb->progress3->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($processflow_tb->progress4->Visible) { // progress4 ?>
		<td<?php echo $processflow_tb->progress4->CellAttributes() ?>>
<span id="el<?php echo $processflow_tb_delete->RowCnt ?>_processflow_tb_progress4" class="control-group processflow_tb_progress4">
<span<?php echo $processflow_tb->progress4->ViewAttributes() ?>>
<?php echo $processflow_tb->progress4->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($processflow_tb->progress5->Visible) { // progress5 ?>
		<td<?php echo $processflow_tb->progress5->CellAttributes() ?>>
<span id="el<?php echo $processflow_tb_delete->RowCnt ?>_processflow_tb_progress5" class="control-group processflow_tb_progress5">
<span<?php echo $processflow_tb->progress5->ViewAttributes() ?>>
<?php echo $processflow_tb->progress5->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($processflow_tb->progress6->Visible) { // progress6 ?>
		<td<?php echo $processflow_tb->progress6->CellAttributes() ?>>
<span id="el<?php echo $processflow_tb_delete->RowCnt ?>_processflow_tb_progress6" class="control-group processflow_tb_progress6">
<span<?php echo $processflow_tb->progress6->ViewAttributes() ?>>
<?php echo $processflow_tb->progress6->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
	</tr>
<?php
	$processflow_tb_delete->Recordset->MoveNext();
}
$processflow_tb_delete->Recordset->Close();
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
fprocessflow_tbdelete.Init();
</script>
<?php
$processflow_tb_delete->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$processflow_tb_delete->Page_Terminate();
?>
