<?php
if (session_id() == "") session_start(); // Initialize Session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg10.php" ?>
<?php include_once "ewmysql10.php" ?>
<?php include_once "phpfn10.php" ?>
<?php include_once "customersinfo.php" ?>
<?php include_once "adminusersinfo.php" ?>
<?php include_once "userfn10.php" ?>
<?php

//
// Page class
//

$customers_delete = NULL; // Initialize page object first

class ccustomers_delete extends ccustomers {

	// Page ID
	var $PageID = 'delete';

	// Project ID
	var $ProjectID = "{D9B361E7-B2C1-4293-B9B3-B581986A15CC}";

	// Table name
	var $TableName = 'customers';

	// Page object name
	var $PageObjName = 'customers_delete';

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

		// Table object (customers)
		if (!isset($GLOBALS["customers"])) {
			$GLOBALS["customers"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["customers"];
		}

		// Table object (adminusers)
		if (!isset($GLOBALS['adminusers'])) $GLOBALS['adminusers'] = new cadminusers();

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'delete', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'customers', TRUE);

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
			$this->Page_Terminate("customerslist.php"); // Prevent SQL injection, return to list

		// Set up filter (SQL WHHERE clause) and get return SQL
		// SQL constructor in customers class, customersinfo.php

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
		$this->lname->setDbValue($rs->fields('lname'));
		$this->_email->setDbValue($rs->fields('email'));
		$this->password->setDbValue($rs->fields('password'));
		$this->address->setDbValue($rs->fields('address'));
		$this->phone->setDbValue($rs->fields('phone'));
		$this->city->setDbValue($rs->fields('city'));
		$this->state->setDbValue($rs->fields('state'));
		$this->country->setDbValue($rs->fields('country'));
		$this->datereg->setDbValue($rs->fields('datereg'));
		$this->deliveryopt->setDbValue($rs->fields('deliveryopt'));
		$this->paymentopt->setDbValue($rs->fields('paymentopt'));
	}

	// Load DbValue from recordset
	function LoadDbValues(&$rs) {
		if (!$rs || !is_array($rs) && $rs->EOF) return;
		$row = is_array($rs) ? $rs : $rs->fields;
		$this->id->DbValue = $row['id'];
		$this->name->DbValue = $row['name'];
		$this->lname->DbValue = $row['lname'];
		$this->_email->DbValue = $row['email'];
		$this->password->DbValue = $row['password'];
		$this->address->DbValue = $row['address'];
		$this->phone->DbValue = $row['phone'];
		$this->city->DbValue = $row['city'];
		$this->state->DbValue = $row['state'];
		$this->country->DbValue = $row['country'];
		$this->datereg->DbValue = $row['datereg'];
		$this->deliveryopt->DbValue = $row['deliveryopt'];
		$this->paymentopt->DbValue = $row['paymentopt'];
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
		// lname
		// email
		// password
		// address
		// phone
		// city
		// state
		// country
		// datereg
		// deliveryopt
		// paymentopt

		if ($this->RowType == EW_ROWTYPE_VIEW) { // View row

			// id
			$this->id->ViewValue = $this->id->CurrentValue;
			$this->id->ViewCustomAttributes = "";

			// name
			$this->name->ViewValue = $this->name->CurrentValue;
			$this->name->ViewCustomAttributes = "";

			// lname
			$this->lname->ViewValue = $this->lname->CurrentValue;
			$this->lname->ViewCustomAttributes = "";

			// email
			$this->_email->ViewValue = $this->_email->CurrentValue;
			$this->_email->ViewCustomAttributes = "";

			// password
			$this->password->ViewValue = $this->password->CurrentValue;
			$this->password->ViewCustomAttributes = "";

			// address
			$this->address->ViewValue = $this->address->CurrentValue;
			$this->address->ViewCustomAttributes = "";

			// phone
			$this->phone->ViewValue = $this->phone->CurrentValue;
			$this->phone->ViewCustomAttributes = "";

			// city
			$this->city->ViewValue = $this->city->CurrentValue;
			$this->city->ViewCustomAttributes = "";

			// state
			$this->state->ViewValue = $this->state->CurrentValue;
			$this->state->ViewCustomAttributes = "";

			// country
			$this->country->ViewValue = $this->country->CurrentValue;
			$this->country->ViewCustomAttributes = "";

			// datereg
			$this->datereg->ViewValue = $this->datereg->CurrentValue;
			$this->datereg->ViewValue = ew_FormatDateTime($this->datereg->ViewValue, 7);
			$this->datereg->ViewCustomAttributes = "";

			// deliveryopt
			$this->deliveryopt->ViewValue = $this->deliveryopt->CurrentValue;
			$this->deliveryopt->ViewCustomAttributes = "";

			// paymentopt
			$this->paymentopt->ViewValue = $this->paymentopt->CurrentValue;
			$this->paymentopt->ViewCustomAttributes = "";

			// name
			$this->name->LinkCustomAttributes = "";
			$this->name->HrefValue = "";
			$this->name->TooltipValue = "";

			// lname
			$this->lname->LinkCustomAttributes = "";
			$this->lname->HrefValue = "";
			$this->lname->TooltipValue = "";

			// email
			$this->_email->LinkCustomAttributes = "";
			$this->_email->HrefValue = "";
			$this->_email->TooltipValue = "";

			// phone
			$this->phone->LinkCustomAttributes = "";
			$this->phone->HrefValue = "";
			$this->phone->TooltipValue = "";

			// datereg
			$this->datereg->LinkCustomAttributes = "";
			$this->datereg->HrefValue = "";
			$this->datereg->TooltipValue = "";

			// deliveryopt
			$this->deliveryopt->LinkCustomAttributes = "";
			$this->deliveryopt->HrefValue = "";
			$this->deliveryopt->TooltipValue = "";

			// paymentopt
			$this->paymentopt->LinkCustomAttributes = "";
			$this->paymentopt->HrefValue = "";
			$this->paymentopt->TooltipValue = "";
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
		$Breadcrumb->Add("list", "<span id=\"ewPageCaption\">" . $PageCaption . "</span>", "customerslist.php", $this->TableVar);
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
if (!isset($customers_delete)) $customers_delete = new ccustomers_delete();

// Page init
$customers_delete->Page_Init();

// Page main
$customers_delete->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$customers_delete->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Page object
var customers_delete = new ew_Page("customers_delete");
customers_delete.PageID = "delete"; // Page ID
var EW_PAGE_ID = customers_delete.PageID; // For backward compatibility

// Form object
var fcustomersdelete = new ew_Form("fcustomersdelete");

// Form_CustomValidate event
fcustomersdelete.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
fcustomersdelete.ValidateRequired = true;
<?php } else { ?>
fcustomersdelete.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
// Form object for search

</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<?php

// Load records for display
if ($customers_delete->Recordset = $customers_delete->LoadRecordset())
	$customers_deleteTotalRecs = $customers_delete->Recordset->RecordCount(); // Get record count
if ($customers_deleteTotalRecs <= 0) { // No record found, exit
	if ($customers_delete->Recordset)
		$customers_delete->Recordset->Close();
	$customers_delete->Page_Terminate("customerslist.php"); // Return to list
}
?>
<?php $Breadcrumb->Render(); ?>
<?php $customers_delete->ShowPageHeader(); ?>
<?php
$customers_delete->ShowMessage();
?>
<form name="fcustomersdelete" id="fcustomersdelete" class="ewForm form-horizontal" action="<?php echo ew_CurrentPage() ?>" method="post">
<input type="hidden" name="t" value="customers">
<input type="hidden" name="a_delete" id="a_delete" value="D">
<?php foreach ($customers_delete->RecKeys as $key) { ?>
<?php $keyvalue = is_array($key) ? implode($EW_COMPOSITE_KEY_SEPARATOR, $key) : $key; ?>
<input type="hidden" name="key_m[]" value="<?php echo ew_HtmlEncode($keyvalue) ?>">
<?php } ?>
<table cellspacing="0" class="ewGrid"><tr><td class="ewGridContent">
<div class="ewGridMiddlePanel">
<table id="tbl_customersdelete" class="ewTable ewTableSeparate">
<?php echo $customers->TableCustomInnerHtml ?>
	<thead>
	<tr class="ewTableHeader">
<?php if ($customers->name->Visible) { // name ?>
		<td><span id="elh_customers_name" class="customers_name"><?php echo $customers->name->FldCaption() ?></span></td>
<?php } ?>
<?php if ($customers->lname->Visible) { // lname ?>
		<td><span id="elh_customers_lname" class="customers_lname"><?php echo $customers->lname->FldCaption() ?></span></td>
<?php } ?>
<?php if ($customers->_email->Visible) { // email ?>
		<td><span id="elh_customers__email" class="customers__email"><?php echo $customers->_email->FldCaption() ?></span></td>
<?php } ?>
<?php if ($customers->phone->Visible) { // phone ?>
		<td><span id="elh_customers_phone" class="customers_phone"><?php echo $customers->phone->FldCaption() ?></span></td>
<?php } ?>
<?php if ($customers->datereg->Visible) { // datereg ?>
		<td><span id="elh_customers_datereg" class="customers_datereg"><?php echo $customers->datereg->FldCaption() ?></span></td>
<?php } ?>
<?php if ($customers->deliveryopt->Visible) { // deliveryopt ?>
		<td><span id="elh_customers_deliveryopt" class="customers_deliveryopt"><?php echo $customers->deliveryopt->FldCaption() ?></span></td>
<?php } ?>
<?php if ($customers->paymentopt->Visible) { // paymentopt ?>
		<td><span id="elh_customers_paymentopt" class="customers_paymentopt"><?php echo $customers->paymentopt->FldCaption() ?></span></td>
<?php } ?>
	</tr>
	</thead>
	<tbody>
<?php
$customers_delete->RecCnt = 0;
$i = 0;
while (!$customers_delete->Recordset->EOF) {
	$customers_delete->RecCnt++;
	$customers_delete->RowCnt++;

	// Set row properties
	$customers->ResetAttrs();
	$customers->RowType = EW_ROWTYPE_VIEW; // View

	// Get the field contents
	$customers_delete->LoadRowValues($customers_delete->Recordset);

	// Render row
	$customers_delete->RenderRow();
?>
	<tr<?php echo $customers->RowAttributes() ?>>
<?php if ($customers->name->Visible) { // name ?>
		<td<?php echo $customers->name->CellAttributes() ?>>
<span id="el<?php echo $customers_delete->RowCnt ?>_customers_name" class="control-group customers_name">
<span<?php echo $customers->name->ViewAttributes() ?>>
<?php echo $customers->name->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($customers->lname->Visible) { // lname ?>
		<td<?php echo $customers->lname->CellAttributes() ?>>
<span id="el<?php echo $customers_delete->RowCnt ?>_customers_lname" class="control-group customers_lname">
<span<?php echo $customers->lname->ViewAttributes() ?>>
<?php echo $customers->lname->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($customers->_email->Visible) { // email ?>
		<td<?php echo $customers->_email->CellAttributes() ?>>
<span id="el<?php echo $customers_delete->RowCnt ?>_customers__email" class="control-group customers__email">
<span<?php echo $customers->_email->ViewAttributes() ?>>
<?php echo $customers->_email->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($customers->phone->Visible) { // phone ?>
		<td<?php echo $customers->phone->CellAttributes() ?>>
<span id="el<?php echo $customers_delete->RowCnt ?>_customers_phone" class="control-group customers_phone">
<span<?php echo $customers->phone->ViewAttributes() ?>>
<?php echo $customers->phone->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($customers->datereg->Visible) { // datereg ?>
		<td<?php echo $customers->datereg->CellAttributes() ?>>
<span id="el<?php echo $customers_delete->RowCnt ?>_customers_datereg" class="control-group customers_datereg">
<span<?php echo $customers->datereg->ViewAttributes() ?>>
<?php echo $customers->datereg->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($customers->deliveryopt->Visible) { // deliveryopt ?>
		<td<?php echo $customers->deliveryopt->CellAttributes() ?>>
<span id="el<?php echo $customers_delete->RowCnt ?>_customers_deliveryopt" class="control-group customers_deliveryopt">
<span<?php echo $customers->deliveryopt->ViewAttributes() ?>>
<?php echo $customers->deliveryopt->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($customers->paymentopt->Visible) { // paymentopt ?>
		<td<?php echo $customers->paymentopt->CellAttributes() ?>>
<span id="el<?php echo $customers_delete->RowCnt ?>_customers_paymentopt" class="control-group customers_paymentopt">
<span<?php echo $customers->paymentopt->ViewAttributes() ?>>
<?php echo $customers->paymentopt->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
	</tr>
<?php
	$customers_delete->Recordset->MoveNext();
}
$customers_delete->Recordset->Close();
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
fcustomersdelete.Init();
</script>
<?php
$customers_delete->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$customers_delete->Page_Terminate();
?>
