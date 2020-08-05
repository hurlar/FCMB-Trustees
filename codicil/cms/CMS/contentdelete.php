<?php
if (session_id() == "") session_start(); // Initialize Session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg10.php" ?>
<?php include_once "ewmysql10.php" ?>
<?php include_once "phpfn10.php" ?>
<?php include_once "contentinfo.php" ?>
<?php include_once "adminusersinfo.php" ?>
<?php include_once "userfn10.php" ?>
<?php

//
// Page class
//

$content_delete = NULL; // Initialize page object first

class ccontent_delete extends ccontent {

	// Page ID
	var $PageID = 'delete';

	// Project ID
	var $ProjectID = "{D9B361E7-B2C1-4293-B9B3-B581986A15CC}";

	// Table name
	var $TableName = 'content';

	// Page object name
	var $PageObjName = 'content_delete';

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

		// Table object (content)
		if (!isset($GLOBALS["content"])) {
			$GLOBALS["content"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["content"];
		}

		// Table object (adminusers)
		if (!isset($GLOBALS['adminusers'])) $GLOBALS['adminusers'] = new cadminusers();

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'delete', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'content', TRUE);

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
			$this->Page_Terminate("contentlist.php"); // Prevent SQL injection, return to list

		// Set up filter (SQL WHHERE clause) and get return SQL
		// SQL constructor in content class, contentinfo.php

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
		$this->pg_name->setDbValue($rs->fields('pg_name'));
		$this->pg_cat->setDbValue($rs->fields('pg_cat'));
		$this->content->setDbValue($rs->fields('content'));
		$this->pg_alias->setDbValue($rs->fields('pg_alias'));
		$this->pg_type->setDbValue($rs->fields('pg_type'));
		$this->pg_menu->setDbValue($rs->fields('pg_menu'));
		$this->pg_title->setDbValue($rs->fields('pg_title'));
		$this->keywords->setDbValue($rs->fields('keywords'));
		$this->pr_status->setDbValue($rs->fields('pr_status'));
		$this->pg_url->setDbValue($rs->fields('pg_url'));
		$this->secured_st->setDbValue($rs->fields('secured_st'));
		$this->rate_ord->setDbValue($rs->fields('rate_ord'));
		$this->uploads->Upload->DbValue = $rs->fields('uploads');
		$this->intro->setDbValue($rs->fields('intro'));
		$this->sidebar->setDbValue($rs->fields('sidebar'));
		$this->postdate->setDbValue($rs->fields('postdate'));
		$this->img1->setDbValue($rs->fields('img1'));
		$this->img2->setDbValue($rs->fields('img2'));
		$this->creator->setDbValue($rs->fields('creator'));
		$this->datep->setDbValue($rs->fields('datep'));
	}

	// Load DbValue from recordset
	function LoadDbValues(&$rs) {
		if (!$rs || !is_array($rs) && $rs->EOF) return;
		$row = is_array($rs) ? $rs : $rs->fields;
		$this->id->DbValue = $row['id'];
		$this->pg_name->DbValue = $row['pg_name'];
		$this->pg_cat->DbValue = $row['pg_cat'];
		$this->content->DbValue = $row['content'];
		$this->pg_alias->DbValue = $row['pg_alias'];
		$this->pg_type->DbValue = $row['pg_type'];
		$this->pg_menu->DbValue = $row['pg_menu'];
		$this->pg_title->DbValue = $row['pg_title'];
		$this->keywords->DbValue = $row['keywords'];
		$this->pr_status->DbValue = $row['pr_status'];
		$this->pg_url->DbValue = $row['pg_url'];
		$this->secured_st->DbValue = $row['secured_st'];
		$this->rate_ord->DbValue = $row['rate_ord'];
		$this->uploads->Upload->DbValue = $row['uploads'];
		$this->intro->DbValue = $row['intro'];
		$this->sidebar->DbValue = $row['sidebar'];
		$this->postdate->DbValue = $row['postdate'];
		$this->img1->DbValue = $row['img1'];
		$this->img2->DbValue = $row['img2'];
		$this->creator->DbValue = $row['creator'];
		$this->datep->DbValue = $row['datep'];
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
		// pg_name
		// pg_cat
		// content
		// pg_alias
		// pg_type
		// pg_menu
		// pg_title
		// keywords
		// pr_status
		// pg_url
		// secured_st

		$this->secured_st->CellCssStyle = "white-space: nowrap;";

		// rate_ord
		// uploads
		// intro
		// sidebar
		// postdate
		// img1
		// img2
		// creator
		// datep

		if ($this->RowType == EW_ROWTYPE_VIEW) { // View row

			// id
			$this->id->ViewValue = $this->id->CurrentValue;
			$this->id->ViewCustomAttributes = "";

			// pg_name
			$this->pg_name->ViewValue = $this->pg_name->CurrentValue;
			$this->pg_name->ViewCustomAttributes = "";

			// pg_cat
			if (strval($this->pg_cat->CurrentValue) <> "") {
				$sFilterWrk = "`pg_cat`" . ew_SearchString("=", $this->pg_cat->CurrentValue, EW_DATATYPE_STRING);
			$sSqlWrk = "SELECT `pg_cat`, `pg_cat` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `page_cat`";
			$sWhereWrk = "";
			if ($sFilterWrk <> "") {
				ew_AddFilter($sWhereWrk, $sFilterWrk);
			}

			// Call Lookup selecting
			$this->Lookup_Selecting($this->pg_cat, $sWhereWrk);
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
				$rswrk = $conn->Execute($sSqlWrk);
				if ($rswrk && !$rswrk->EOF) { // Lookup values found
					$this->pg_cat->ViewValue = $rswrk->fields('DispFld');
					$rswrk->Close();
				} else {
					$this->pg_cat->ViewValue = $this->pg_cat->CurrentValue;
				}
			} else {
				$this->pg_cat->ViewValue = NULL;
			}
			$this->pg_cat->ViewCustomAttributes = "";

			// content
			$this->content->ViewValue = $this->content->CurrentValue;
			$this->content->ViewCustomAttributes = "";

			// pg_alias
			$this->pg_alias->ViewValue = $this->pg_alias->CurrentValue;
			$this->pg_alias->ViewCustomAttributes = "";

			// pg_type
			$this->pg_type->ViewValue = $this->pg_type->CurrentValue;
			if (strval($this->pg_type->CurrentValue) <> "") {
				$sFilterWrk = "`name`" . ew_SearchString("=", $this->pg_type->CurrentValue, EW_DATATYPE_STRING);
			$sSqlWrk = "SELECT `name`, `name` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `page_template`";
			$sWhereWrk = "";
			if ($sFilterWrk <> "") {
				ew_AddFilter($sWhereWrk, $sFilterWrk);
			}

			// Call Lookup selecting
			$this->Lookup_Selecting($this->pg_type, $sWhereWrk);
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
				$rswrk = $conn->Execute($sSqlWrk);
				if ($rswrk && !$rswrk->EOF) { // Lookup values found
					$this->pg_type->ViewValue = $rswrk->fields('DispFld');
					$rswrk->Close();
				} else {
					$this->pg_type->ViewValue = $this->pg_type->CurrentValue;
				}
			} else {
				$this->pg_type->ViewValue = NULL;
			}
			$this->pg_type->ViewCustomAttributes = "";

			// pg_menu
			$this->pg_menu->ViewValue = $this->pg_menu->CurrentValue;
			$this->pg_menu->ViewCustomAttributes = "";

			// pg_title
			$this->pg_title->ViewValue = $this->pg_title->CurrentValue;
			$this->pg_title->ViewCustomAttributes = "";

			// keywords
			$this->keywords->ViewValue = $this->keywords->CurrentValue;
			$this->keywords->ViewCustomAttributes = "";

			// pr_status
			if (strval($this->pr_status->CurrentValue) <> "") {
				switch ($this->pr_status->CurrentValue) {
					case $this->pr_status->FldTagValue(1):
						$this->pr_status->ViewValue = $this->pr_status->FldTagCaption(1) <> "" ? $this->pr_status->FldTagCaption(1) : $this->pr_status->CurrentValue;
						break;
					case $this->pr_status->FldTagValue(2):
						$this->pr_status->ViewValue = $this->pr_status->FldTagCaption(2) <> "" ? $this->pr_status->FldTagCaption(2) : $this->pr_status->CurrentValue;
						break;
					default:
						$this->pr_status->ViewValue = $this->pr_status->CurrentValue;
				}
			} else {
				$this->pr_status->ViewValue = NULL;
			}
			$this->pr_status->ViewCustomAttributes = "";

			// pg_url
			$this->pg_url->ViewValue = $this->pg_url->CurrentValue;
			$this->pg_url->ViewCustomAttributes = "";

			// secured_st
			if (ew_ConvertToBool($this->secured_st->CurrentValue)) {
				$this->secured_st->ViewValue = $this->secured_st->FldTagCaption(2) <> "" ? $this->secured_st->FldTagCaption(2) : "Secured";
			} else {
				$this->secured_st->ViewValue = $this->secured_st->FldTagCaption(1) <> "" ? $this->secured_st->FldTagCaption(1) : "Public";
			}
			$this->secured_st->ViewCustomAttributes = "";

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

			// uploads
			$this->uploads->UploadPath = "../uploads/";
			if (!ew_Empty($this->uploads->Upload->DbValue)) {
				$this->uploads->ViewValue = $this->uploads->Upload->DbValue;
			} else {
				$this->uploads->ViewValue = "";
			}
			$this->uploads->ViewCustomAttributes = "";

			// intro
			$this->intro->ViewValue = $this->intro->CurrentValue;
			$this->intro->ViewCustomAttributes = "";

			// sidebar
			$this->sidebar->ViewValue = $this->sidebar->CurrentValue;
			$this->sidebar->ViewCustomAttributes = "";

			// postdate
			$this->postdate->ViewValue = $this->postdate->CurrentValue;
			$this->postdate->ViewCustomAttributes = "";

			// img1
			$this->img1->ViewValue = $this->img1->CurrentValue;
			$this->img1->ViewCustomAttributes = "";

			// img2
			$this->img2->ViewValue = $this->img2->CurrentValue;
			$this->img2->ViewCustomAttributes = "";

			// creator
			$this->creator->ViewValue = $this->creator->CurrentValue;
			$this->creator->ViewCustomAttributes = "";

			// datep
			$this->datep->ViewValue = $this->datep->CurrentValue;
			$this->datep->ViewCustomAttributes = "";

			// pg_name
			$this->pg_name->LinkCustomAttributes = "";
			$this->pg_name->HrefValue = "";
			$this->pg_name->TooltipValue = "";

			// pg_cat
			$this->pg_cat->LinkCustomAttributes = "";
			$this->pg_cat->HrefValue = "";
			$this->pg_cat->TooltipValue = "";

			// pg_alias
			$this->pg_alias->LinkCustomAttributes = "";
			$this->pg_alias->HrefValue = "";
			$this->pg_alias->TooltipValue = "";

			// pg_type
			$this->pg_type->LinkCustomAttributes = "";
			$this->pg_type->HrefValue = "";
			$this->pg_type->TooltipValue = "";
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
				$this->uploads->OldUploadPath = "../uploads/";
				@unlink(ew_UploadPathEx(TRUE, $this->uploads->OldUploadPath) . $row['uploads']);
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
		$Breadcrumb->Add("list", "<span id=\"ewPageCaption\">" . $PageCaption . "</span>", "contentlist.php", $this->TableVar);
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
if (!isset($content_delete)) $content_delete = new ccontent_delete();

// Page init
$content_delete->Page_Init();

// Page main
$content_delete->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$content_delete->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Page object
var content_delete = new ew_Page("content_delete");
content_delete.PageID = "delete"; // Page ID
var EW_PAGE_ID = content_delete.PageID; // For backward compatibility

// Form object
var fcontentdelete = new ew_Form("fcontentdelete");

// Form_CustomValidate event
fcontentdelete.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
fcontentdelete.ValidateRequired = true;
<?php } else { ?>
fcontentdelete.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
fcontentdelete.Lists["x_pg_cat"] = {"LinkField":"x_pg_cat","Ajax":true,"AutoFill":false,"DisplayFields":["x_pg_cat","","",""],"ParentFields":[],"FilterFields":[],"Options":[]};
fcontentdelete.Lists["x_pg_type"] = {"LinkField":"x_name","Ajax":true,"AutoFill":false,"DisplayFields":["x_name","","",""],"ParentFields":[],"FilterFields":[],"Options":[]};

// Form object for search
</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<?php

// Load records for display
if ($content_delete->Recordset = $content_delete->LoadRecordset())
	$content_deleteTotalRecs = $content_delete->Recordset->RecordCount(); // Get record count
if ($content_deleteTotalRecs <= 0) { // No record found, exit
	if ($content_delete->Recordset)
		$content_delete->Recordset->Close();
	$content_delete->Page_Terminate("contentlist.php"); // Return to list
}
?>
<?php $Breadcrumb->Render(); ?>
<?php $content_delete->ShowPageHeader(); ?>
<?php
$content_delete->ShowMessage();
?>
<form name="fcontentdelete" id="fcontentdelete" class="ewForm form-horizontal" action="<?php echo ew_CurrentPage() ?>" method="post">
<input type="hidden" name="t" value="content">
<input type="hidden" name="a_delete" id="a_delete" value="D">
<?php foreach ($content_delete->RecKeys as $key) { ?>
<?php $keyvalue = is_array($key) ? implode($EW_COMPOSITE_KEY_SEPARATOR, $key) : $key; ?>
<input type="hidden" name="key_m[]" value="<?php echo ew_HtmlEncode($keyvalue) ?>">
<?php } ?>
<table cellspacing="0" class="ewGrid"><tr><td class="ewGridContent">
<div class="ewGridMiddlePanel">
<table id="tbl_contentdelete" class="ewTable ewTableSeparate">
<?php echo $content->TableCustomInnerHtml ?>
	<thead>
	<tr class="ewTableHeader">
<?php if ($content->pg_name->Visible) { // pg_name ?>
		<td><span id="elh_content_pg_name" class="content_pg_name"><?php echo $content->pg_name->FldCaption() ?></span></td>
<?php } ?>
<?php if ($content->pg_cat->Visible) { // pg_cat ?>
		<td><span id="elh_content_pg_cat" class="content_pg_cat"><?php echo $content->pg_cat->FldCaption() ?></span></td>
<?php } ?>
<?php if ($content->pg_alias->Visible) { // pg_alias ?>
		<td><span id="elh_content_pg_alias" class="content_pg_alias"><?php echo $content->pg_alias->FldCaption() ?></span></td>
<?php } ?>
<?php if ($content->pg_type->Visible) { // pg_type ?>
		<td><span id="elh_content_pg_type" class="content_pg_type"><?php echo $content->pg_type->FldCaption() ?></span></td>
<?php } ?>
	</tr>
	</thead>
	<tbody>
<?php
$content_delete->RecCnt = 0;
$i = 0;
while (!$content_delete->Recordset->EOF) {
	$content_delete->RecCnt++;
	$content_delete->RowCnt++;

	// Set row properties
	$content->ResetAttrs();
	$content->RowType = EW_ROWTYPE_VIEW; // View

	// Get the field contents
	$content_delete->LoadRowValues($content_delete->Recordset);

	// Render row
	$content_delete->RenderRow();
?>
	<tr<?php echo $content->RowAttributes() ?>>
<?php if ($content->pg_name->Visible) { // pg_name ?>
		<td<?php echo $content->pg_name->CellAttributes() ?>>
<span id="el<?php echo $content_delete->RowCnt ?>_content_pg_name" class="control-group content_pg_name">
<span<?php echo $content->pg_name->ViewAttributes() ?>>
<?php echo $content->pg_name->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($content->pg_cat->Visible) { // pg_cat ?>
		<td<?php echo $content->pg_cat->CellAttributes() ?>>
<span id="el<?php echo $content_delete->RowCnt ?>_content_pg_cat" class="control-group content_pg_cat">
<span<?php echo $content->pg_cat->ViewAttributes() ?>>
<?php echo $content->pg_cat->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($content->pg_alias->Visible) { // pg_alias ?>
		<td<?php echo $content->pg_alias->CellAttributes() ?>>
<span id="el<?php echo $content_delete->RowCnt ?>_content_pg_alias" class="control-group content_pg_alias">
<span<?php echo $content->pg_alias->ViewAttributes() ?>>
<?php echo $content->pg_alias->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($content->pg_type->Visible) { // pg_type ?>
		<td<?php echo $content->pg_type->CellAttributes() ?>>
<span id="el<?php echo $content_delete->RowCnt ?>_content_pg_type" class="control-group content_pg_type">
<span<?php echo $content->pg_type->ViewAttributes() ?>>
<?php echo $content->pg_type->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
	</tr>
<?php
	$content_delete->Recordset->MoveNext();
}
$content_delete->Recordset->Close();
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
fcontentdelete.Init();
</script>
<?php
$content_delete->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$content_delete->Page_Terminate();
?>
