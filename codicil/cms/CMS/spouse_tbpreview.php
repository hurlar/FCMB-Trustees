<?php
if (session_id() == "") session_start(); // Initialize Session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg10.php" ?>
<?php include_once "ewmysql10.php" ?>
<?php include_once "phpfn10.php" ?>
<?php include_once "spouse_tbinfo.php" ?>
<?php include_once "adminusersinfo.php" ?>
<?php include_once "personal_infoinfo.php" ?>
<?php include_once "userfn10.php" ?>
<?php

//
// Page class
//

$spouse_tb_preview = NULL; // Initialize page object first

class cspouse_tb_preview extends cspouse_tb {

	// Page ID
	var $PageID = 'preview';

	// Project ID
	var $ProjectID = "{D9B361E7-B2C1-4293-B9B3-B581986A15CC}";

	// Table name
	var $TableName = 'spouse_tb';

	// Page object name
	var $PageObjName = 'spouse_tb_preview';

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

		// Table object (spouse_tb)
		if (!isset($GLOBALS["spouse_tb"])) {
			$GLOBALS["spouse_tb"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["spouse_tb"];
		}

		// Table object (adminusers)
		if (!isset($GLOBALS['adminusers'])) $GLOBALS['adminusers'] = new cadminusers();

		// Table object (personal_info)
		if (!isset($GLOBALS['personal_info'])) $GLOBALS['personal_info'] = new cpersonal_info();

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'preview', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'spouse_tb', TRUE);

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
		if (is_null($Security)) $Security = new cAdvancedSecurity();
		if (!$Security->IsLoggedIn()) $Security->AutoLogin();
		if (!$Security->IsLoggedIn()) {
			echo $Language->Phrase("NoPermission");
			exit();
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
	var $Recordset;
	var $TotalRecs;
	var $RowCnt;
	var $RecCount;

	//
	// Page main
	//
	function Page_Main() {
		global $Language;

		// Load filter
		$filter = @$_GET["f"];
		$filter = ew_Decrypt($filter);
		if ($filter == "") $filter = "0=1";

		// Call Recordset Selecting event
		$this->Recordset_Selecting($filter);

		// Load recordset
		$filter = $this->ApplyUserIDFilters($filter);
		$this->Recordset = $this->LoadRs($filter);
		$this->TotalRecs = ($this->Recordset) ? $this->Recordset->RecordCount() : 0;

		// Call Recordset Selected event
		$this->Recordset_Selected($this->Recordset);
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
<?php ew_Header(FALSE, 'utf-8') ?>
<?php

// Create page object
if (!isset($spouse_tb_preview)) $spouse_tb_preview = new cspouse_tb_preview();

// Page init
$spouse_tb_preview->Page_Init();

// Page main
$spouse_tb_preview->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$spouse_tb_preview->Page_Render();
?>
<?php $spouse_tb_preview->ShowPageHeader(); ?>
<?php if ($spouse_tb_preview->TotalRecs > 0) { ?>
<table class="ewGrid"><tr><td class="ewGridContent">
<div class="ewGridMiddlePanel">
<table id="ewDetailsPreviewTable" class="ewTable ewTableSeparate">
	<thead><!-- Table header -->
		<tr class="ewTableHeader">
<?php if ($spouse_tb->title->Visible) { // title ?>
			<td><?php echo $spouse_tb->title->FldCaption() ?></td>
<?php } ?>
<?php if ($spouse_tb->fullname->Visible) { // fullname ?>
			<td><?php echo $spouse_tb->fullname->FldCaption() ?></td>
<?php } ?>
<?php if ($spouse_tb->_email->Visible) { // email ?>
			<td><?php echo $spouse_tb->_email->FldCaption() ?></td>
<?php } ?>
<?php if ($spouse_tb->phoneno->Visible) { // phoneno ?>
			<td><?php echo $spouse_tb->phoneno->FldCaption() ?></td>
<?php } ?>
<?php if ($spouse_tb->datecreated->Visible) { // datecreated ?>
			<td><?php echo $spouse_tb->datecreated->FldCaption() ?></td>
<?php } ?>
		</tr>
	</thead>
	<tbody><!-- Table body -->
<?php
$spouse_tb_preview->RecCount = 0;
$spouse_tb_preview->RowCnt = 0;
while ($spouse_tb_preview->Recordset && !$spouse_tb_preview->Recordset->EOF) {

	// Init row class and style
	$spouse_tb_preview->RecCount++;
	$spouse_tb_preview->RowCnt++;
	$spouse_tb->CssClass = "";
	$spouse_tb->CssStyle = "";
	$spouse_tb->LoadListRowValues($spouse_tb_preview->Recordset);

	// Render row
	$spouse_tb->RowType = EW_ROWTYPE_PREVIEW; // Preview record
	$spouse_tb->RenderListRow();
?>
	<tr<?php echo $spouse_tb->RowAttributes() ?>>
<?php if ($spouse_tb->title->Visible) { // title ?>
		<!-- title -->
		<td<?php echo $spouse_tb->title->CellAttributes() ?>>
<span<?php echo $spouse_tb->title->ViewAttributes() ?>>
<?php echo $spouse_tb->title->ListViewValue() ?></span>
</td>
<?php } ?>
<?php if ($spouse_tb->fullname->Visible) { // fullname ?>
		<!-- fullname -->
		<td<?php echo $spouse_tb->fullname->CellAttributes() ?>>
<span<?php echo $spouse_tb->fullname->ViewAttributes() ?>>
<?php echo $spouse_tb->fullname->ListViewValue() ?></span>
</td>
<?php } ?>
<?php if ($spouse_tb->_email->Visible) { // email ?>
		<!-- email -->
		<td<?php echo $spouse_tb->_email->CellAttributes() ?>>
<span<?php echo $spouse_tb->_email->ViewAttributes() ?>>
<?php echo $spouse_tb->_email->ListViewValue() ?></span>
</td>
<?php } ?>
<?php if ($spouse_tb->phoneno->Visible) { // phoneno ?>
		<!-- phoneno -->
		<td<?php echo $spouse_tb->phoneno->CellAttributes() ?>>
<span<?php echo $spouse_tb->phoneno->ViewAttributes() ?>>
<?php echo $spouse_tb->phoneno->ListViewValue() ?></span>
</td>
<?php } ?>
<?php if ($spouse_tb->datecreated->Visible) { // datecreated ?>
		<!-- datecreated -->
		<td<?php echo $spouse_tb->datecreated->CellAttributes() ?>>
<span<?php echo $spouse_tb->datecreated->ViewAttributes() ?>>
<?php echo $spouse_tb->datecreated->ListViewValue() ?></span>
</td>
<?php } ?>
	</tr>
<?php
	$spouse_tb_preview->Recordset->MoveNext();
}
?>
	</tbody>
</table>
</div>
</td></tr></table>
<?php if ($spouse_tb_preview->TotalRecs > 0) { ?>
<div class="ewDetailCount">(<?php echo $spouse_tb_preview->TotalRecs ?>&nbsp;<?php echo $Language->Phrase("Record") ?>)</div>
<?php } ?>
<?php
$spouse_tb_preview->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<?php
	if ($spouse_tb_preview->Recordset)
		$spouse_tb_preview->Recordset->Close();
} else { ?>
<div class="ewDetailCount">(<?php echo $Language->Phrase("NoRecord") ?>)</div>
<?php
}

// Output
$content = ob_get_contents();
ob_end_clean();
echo ew_ConvertToUtf8($content);
?>
<?php
$spouse_tb_preview->Page_Terminate();
?>
