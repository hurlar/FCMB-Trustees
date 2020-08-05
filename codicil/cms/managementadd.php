<?php
if (session_id() == "") session_start(); // Initialize Session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg10.php" ?>
<?php include_once "ewmysql10.php" ?>
<?php include_once "phpfn10.php" ?>
<?php include_once "managementinfo.php" ?>
<?php include_once "adminusersinfo.php" ?>
<?php include_once "userfn10.php" ?>
<?php

//
// Page class
//

$management_add = NULL; // Initialize page object first

class cmanagement_add extends cmanagement {

	// Page ID
	var $PageID = 'add';

	// Project ID
	var $ProjectID = "{D9B361E7-B2C1-4293-B9B3-B581986A15CC}";

	// Table name
	var $TableName = 'management';

	// Page object name
	var $PageObjName = 'management_add';

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

		// Table object (management)
		if (!isset($GLOBALS["management"])) {
			$GLOBALS["management"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["management"];
		}

		// Table object (adminusers)
		if (!isset($GLOBALS['adminusers'])) $GLOBALS['adminusers'] = new cadminusers();

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'add', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'management', TRUE);

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

		// Create form object
		$objForm = new cFormObj();
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
	var $DbMasterFilter = "";
	var $DbDetailFilter = "";
	var $Priv = 0;
	var $OldRecordset;
	var $CopyRecord;

	// 
	// Page main
	//
	function Page_Main() {
		global $objForm, $Language, $gsFormError;

		// Process form if post back
		if (@$_POST["a_add"] <> "") {
			$this->CurrentAction = $_POST["a_add"]; // Get form action
			$this->CopyRecord = $this->LoadOldRecord(); // Load old recordset
			$this->LoadFormValues(); // Load form values
		} else { // Not post back

			// Load key values from QueryString
			$this->CopyRecord = TRUE;
			if (@$_GET["id"] != "") {
				$this->id->setQueryStringValue($_GET["id"]);
				$this->setKey("id", $this->id->CurrentValue); // Set up key
			} else {
				$this->setKey("id", ""); // Clear key
				$this->CopyRecord = FALSE;
			}
			if ($this->CopyRecord) {
				$this->CurrentAction = "C"; // Copy record
			} else {
				$this->CurrentAction = "I"; // Display blank record
				$this->LoadDefaultValues(); // Load default values
			}
		}

		// Set up Breadcrumb
		$this->SetupBreadcrumb();

		// Validate form if post back
		if (@$_POST["a_add"] <> "") {
			if (!$this->ValidateForm()) {
				$this->CurrentAction = "I"; // Form error, reset action
				$this->EventCancelled = TRUE; // Event cancelled
				$this->RestoreFormValues(); // Restore form values
				$this->setFailureMessage($gsFormError);
			}
		}

		// Perform action based on action code
		switch ($this->CurrentAction) {
			case "I": // Blank record, no action required
				break;
			case "C": // Copy an existing record
				if (!$this->LoadRow()) { // Load record based on key
					if ($this->getFailureMessage() == "") $this->setFailureMessage($Language->Phrase("NoRecord")); // No record found
					$this->Page_Terminate("managementlist.php"); // No matching record, return to list
				}
				break;
			case "A": // Add new record
				$this->SendEmail = TRUE; // Send email on add success
				if ($this->AddRow($this->OldRecordset)) { // Add successful
					if ($this->getSuccessMessage() == "")
						$this->setSuccessMessage($Language->Phrase("AddSuccess")); // Set up success message
					$sReturnUrl = $this->getReturnUrl();
					if (ew_GetPageName($sReturnUrl) == "managementview.php")
						$sReturnUrl = $this->GetViewUrl(); // View paging, return to view page with keyurl directly
					$this->Page_Terminate($sReturnUrl); // Clean up and return
				} else {
					$this->EventCancelled = TRUE; // Event cancelled
					$this->RestoreFormValues(); // Add failed, restore form values
				}
		}

		// Render row based on row type
		$this->RowType = EW_ROWTYPE_ADD;  // Render add type

		// Render row
		$this->ResetAttrs();
		$this->RenderRow();
	}

	// Get upload files
	function GetUploadFiles() {
		global $objForm;

		// Get upload data
		$this->image->Upload->Index = $objForm->Index;
		if ($this->image->Upload->UploadFile()) {

			// No action required
		} else {
			echo $this->image->Upload->Message;
			$this->Page_Terminate();
			exit();
		}
		$this->image->CurrentValue = $this->image->Upload->FileName;
	}

	// Load default values
	function LoadDefaultValues() {
		$this->name->CurrentValue = NULL;
		$this->name->OldValue = $this->name->CurrentValue;
		$this->position->CurrentValue = NULL;
		$this->position->OldValue = $this->position->CurrentValue;
		$this->image->Upload->DbValue = NULL;
		$this->image->OldValue = $this->image->Upload->DbValue;
		$this->image->CurrentValue = NULL; // Clear file related field
		$this->descrp->CurrentValue = NULL;
		$this->descrp->OldValue = $this->descrp->CurrentValue;
		$this->slug->CurrentValue = NULL;
		$this->slug->OldValue = $this->slug->CurrentValue;
		$this->category->CurrentValue = NULL;
		$this->category->OldValue = $this->category->CurrentValue;
		$this->rate_ord->CurrentValue = NULL;
		$this->rate_ord->OldValue = $this->rate_ord->CurrentValue;
	}

	// Load form values
	function LoadFormValues() {

		// Load from form
		global $objForm;
		$this->GetUploadFiles(); // Get upload files
		if (!$this->name->FldIsDetailKey) {
			$this->name->setFormValue($objForm->GetValue("x_name"));
		}
		if (!$this->position->FldIsDetailKey) {
			$this->position->setFormValue($objForm->GetValue("x_position"));
		}
		if (!$this->descrp->FldIsDetailKey) {
			$this->descrp->setFormValue($objForm->GetValue("x_descrp"));
		}
		if (!$this->slug->FldIsDetailKey) {
			$this->slug->setFormValue($objForm->GetValue("x_slug"));
		}
		if (!$this->category->FldIsDetailKey) {
			$this->category->setFormValue($objForm->GetValue("x_category"));
		}
		if (!$this->rate_ord->FldIsDetailKey) {
			$this->rate_ord->setFormValue($objForm->GetValue("x_rate_ord"));
		}
	}

	// Restore form values
	function RestoreFormValues() {
		global $objForm;
		$this->LoadOldRecord();
		$this->name->CurrentValue = $this->name->FormValue;
		$this->position->CurrentValue = $this->position->FormValue;
		$this->descrp->CurrentValue = $this->descrp->FormValue;
		$this->slug->CurrentValue = $this->slug->FormValue;
		$this->category->CurrentValue = $this->category->FormValue;
		$this->rate_ord->CurrentValue = $this->rate_ord->FormValue;
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
		$this->slug->setDbValue($rs->fields('slug'));
		$this->category->setDbValue($rs->fields('category'));
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
		$this->slug->DbValue = $row['slug'];
		$this->category->DbValue = $row['category'];
		$this->rate_ord->DbValue = $row['rate_ord'];
		$this->datecreated->DbValue = $row['datecreated'];
	}

	// Load old record
	function LoadOldRecord() {

		// Load key values from Session
		$bValidKey = TRUE;
		if (strval($this->getKey("id")) <> "")
			$this->id->CurrentValue = $this->getKey("id"); // id
		else
			$bValidKey = FALSE;

		// Load old recordset
		if ($bValidKey) {
			$this->CurrentFilter = $this->KeyFilter();
			$sSql = $this->SQL();
			$this->OldRecordset = ew_LoadRecordset($sSql);
			$this->LoadRowValues($this->OldRecordset); // Load row values
		} else {
			$this->OldRecordset = NULL;
		}
		return $bValidKey;
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
		// slug
		// category
		// rate_ord
		// datecreated

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

			// slug
			$this->slug->ViewValue = $this->slug->CurrentValue;
			$this->slug->ViewCustomAttributes = "";

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

			// image
			$this->image->LinkCustomAttributes = "";
			$this->image->UploadPath = "../images/team/";
			if (!ew_Empty($this->image->Upload->DbValue)) {
				$this->image->HrefValue = ew_UploadPathEx(FALSE, $this->image->UploadPath) . $this->image->Upload->DbValue; // Add prefix/suffix
				$this->image->LinkAttrs["target"] = "_blank"; // Add target
				if ($this->Export <> "") $this->image->HrefValue = ew_ConvertFullUrl($this->image->HrefValue);
			} else {
				$this->image->HrefValue = "";
			}
			$this->image->HrefValue2 = $this->image->UploadPath . $this->image->Upload->DbValue;
			$this->image->TooltipValue = "";

			// descrp
			$this->descrp->LinkCustomAttributes = "";
			$this->descrp->HrefValue = "";
			$this->descrp->TooltipValue = "";

			// slug
			$this->slug->LinkCustomAttributes = "";
			$this->slug->HrefValue = "";
			$this->slug->TooltipValue = "";

			// category
			$this->category->LinkCustomAttributes = "";
			$this->category->HrefValue = "";
			$this->category->TooltipValue = "";

			// rate_ord
			$this->rate_ord->LinkCustomAttributes = "";
			$this->rate_ord->HrefValue = "";
			$this->rate_ord->TooltipValue = "";
		} elseif ($this->RowType == EW_ROWTYPE_ADD) { // Add row

			// name
			$this->name->EditCustomAttributes = "style='width:97%' ";
			$this->name->EditValue = ew_HtmlEncode($this->name->CurrentValue);
			$this->name->PlaceHolder = ew_HtmlEncode(ew_RemoveHtml($this->name->FldCaption()));

			// position
			$this->position->EditCustomAttributes = "style='width:97%' ";
			$this->position->EditValue = ew_HtmlEncode($this->position->CurrentValue);
			$this->position->PlaceHolder = ew_HtmlEncode(ew_RemoveHtml($this->position->FldCaption()));

			// image
			$this->image->EditCustomAttributes = "";
			$this->image->UploadPath = "../images/team/";
			if (!ew_Empty($this->image->Upload->DbValue)) {
				$this->image->EditValue = $this->image->Upload->DbValue;
			} else {
				$this->image->EditValue = "";
			}
			if (($this->CurrentAction == "I" || $this->CurrentAction == "C") && !$this->EventCancelled) ew_RenderUploadField($this->image);

			// descrp
			$this->descrp->EditCustomAttributes = "style='width:97%' ";
			$this->descrp->EditValue = $this->descrp->CurrentValue;
			$this->descrp->PlaceHolder = ew_HtmlEncode(ew_RemoveHtml($this->descrp->FldCaption()));

			// slug
			$this->slug->EditCustomAttributes = "style='width:97%' ";
			$this->slug->EditValue = ew_HtmlEncode($this->slug->CurrentValue);
			$this->slug->PlaceHolder = ew_HtmlEncode(ew_RemoveHtml($this->slug->FldCaption()));

			// category
			$this->category->EditCustomAttributes = "style='width:97%' ";
			$sFilterWrk = "";
			$sSqlWrk = "SELECT `category`, `category` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld`, '' AS `SelectFilterFld`, '' AS `SelectFilterFld2`, '' AS `SelectFilterFld3`, '' AS `SelectFilterFld4` FROM `mgt_cat`";
			$sWhereWrk = "";
			if ($sFilterWrk <> "") {
				ew_AddFilter($sWhereWrk, $sFilterWrk);
			}

			// Call Lookup selecting
			$this->Lookup_Selecting($this->category, $sWhereWrk);
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = $conn->Execute($sSqlWrk);
			$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
			if ($rswrk) $rswrk->Close();
			array_unshift($arwrk, array("", $Language->Phrase("PleaseSelect"), "", "", "", "", "", "", ""));
			$this->category->EditValue = $arwrk;

			// rate_ord
			$this->rate_ord->EditCustomAttributes = "style='width:97%' ";
			$arwrk = array();
			$arwrk[] = array($this->rate_ord->FldTagValue(1), $this->rate_ord->FldTagCaption(1) <> "" ? $this->rate_ord->FldTagCaption(1) : $this->rate_ord->FldTagValue(1));
			$arwrk[] = array($this->rate_ord->FldTagValue(2), $this->rate_ord->FldTagCaption(2) <> "" ? $this->rate_ord->FldTagCaption(2) : $this->rate_ord->FldTagValue(2));
			$arwrk[] = array($this->rate_ord->FldTagValue(3), $this->rate_ord->FldTagCaption(3) <> "" ? $this->rate_ord->FldTagCaption(3) : $this->rate_ord->FldTagValue(3));
			$arwrk[] = array($this->rate_ord->FldTagValue(4), $this->rate_ord->FldTagCaption(4) <> "" ? $this->rate_ord->FldTagCaption(4) : $this->rate_ord->FldTagValue(4));
			$arwrk[] = array($this->rate_ord->FldTagValue(5), $this->rate_ord->FldTagCaption(5) <> "" ? $this->rate_ord->FldTagCaption(5) : $this->rate_ord->FldTagValue(5));
			$arwrk[] = array($this->rate_ord->FldTagValue(6), $this->rate_ord->FldTagCaption(6) <> "" ? $this->rate_ord->FldTagCaption(6) : $this->rate_ord->FldTagValue(6));
			$arwrk[] = array($this->rate_ord->FldTagValue(7), $this->rate_ord->FldTagCaption(7) <> "" ? $this->rate_ord->FldTagCaption(7) : $this->rate_ord->FldTagValue(7));
			$arwrk[] = array($this->rate_ord->FldTagValue(8), $this->rate_ord->FldTagCaption(8) <> "" ? $this->rate_ord->FldTagCaption(8) : $this->rate_ord->FldTagValue(8));
			$arwrk[] = array($this->rate_ord->FldTagValue(9), $this->rate_ord->FldTagCaption(9) <> "" ? $this->rate_ord->FldTagCaption(9) : $this->rate_ord->FldTagValue(9));
			$arwrk[] = array($this->rate_ord->FldTagValue(10), $this->rate_ord->FldTagCaption(10) <> "" ? $this->rate_ord->FldTagCaption(10) : $this->rate_ord->FldTagValue(10));
			$arwrk[] = array($this->rate_ord->FldTagValue(11), $this->rate_ord->FldTagCaption(11) <> "" ? $this->rate_ord->FldTagCaption(11) : $this->rate_ord->FldTagValue(11));
			array_unshift($arwrk, array("", $Language->Phrase("PleaseSelect")));
			$this->rate_ord->EditValue = $arwrk;

			// Edit refer script
			// name

			$this->name->HrefValue = "";

			// position
			$this->position->HrefValue = "";

			// image
			$this->image->UploadPath = "../images/team/";
			if (!ew_Empty($this->image->Upload->DbValue)) {
				$this->image->HrefValue = ew_UploadPathEx(FALSE, $this->image->UploadPath) . $this->image->Upload->DbValue; // Add prefix/suffix
				$this->image->LinkAttrs["target"] = "_blank"; // Add target
				if ($this->Export <> "") $this->image->HrefValue = ew_ConvertFullUrl($this->image->HrefValue);
			} else {
				$this->image->HrefValue = "";
			}
			$this->image->HrefValue2 = $this->image->UploadPath . $this->image->Upload->DbValue;

			// descrp
			$this->descrp->HrefValue = "";

			// slug
			$this->slug->HrefValue = "";

			// category
			$this->category->HrefValue = "";

			// rate_ord
			$this->rate_ord->HrefValue = "";
		}
		if ($this->RowType == EW_ROWTYPE_ADD ||
			$this->RowType == EW_ROWTYPE_EDIT ||
			$this->RowType == EW_ROWTYPE_SEARCH) { // Add / Edit / Search row
			$this->SetupFieldTitles();
		}

		// Call Row Rendered event
		if ($this->RowType <> EW_ROWTYPE_AGGREGATEINIT)
			$this->Row_Rendered();
	}

	// Validate form
	function ValidateForm() {
		global $Language, $gsFormError;

		// Initialize form error message
		$gsFormError = "";

		// Check if validation required
		if (!EW_SERVER_VALIDATE)
			return ($gsFormError == "");
		if (!$this->name->FldIsDetailKey && !is_null($this->name->FormValue) && $this->name->FormValue == "") {
			ew_AddMessage($gsFormError, $Language->Phrase("EnterRequiredField") . " - " . $this->name->FldCaption());
		}
		if (!$this->slug->FldIsDetailKey && !is_null($this->slug->FormValue) && $this->slug->FormValue == "") {
			ew_AddMessage($gsFormError, $Language->Phrase("EnterRequiredField") . " - " . $this->slug->FldCaption());
		}
		if (!$this->category->FldIsDetailKey && !is_null($this->category->FormValue) && $this->category->FormValue == "") {
			ew_AddMessage($gsFormError, $Language->Phrase("EnterRequiredField") . " - " . $this->category->FldCaption());
		}

		// Return validate result
		$ValidateForm = ($gsFormError == "");

		// Call Form_CustomValidate event
		$sFormCustomError = "";
		$ValidateForm = $ValidateForm && $this->Form_CustomValidate($sFormCustomError);
		if ($sFormCustomError <> "") {
			ew_AddMessage($gsFormError, $sFormCustomError);
		}
		return $ValidateForm;
	}

	// Add record
	function AddRow($rsold = NULL) {
		global $conn, $Language, $Security;

		// Load db values from rsold
		if ($rsold) {
			$this->LoadDbValues($rsold);
			$this->image->OldUploadPath = "../images/team/";
			$this->image->UploadPath = $this->image->OldUploadPath;
		}
		$rsnew = array();

		// name
		$this->name->SetDbValueDef($rsnew, $this->name->CurrentValue, "", FALSE);

		// position
		$this->position->SetDbValueDef($rsnew, $this->position->CurrentValue, NULL, FALSE);

		// image
		if (!$this->image->Upload->KeepFile) {
			if ($this->image->Upload->FileName == "") {
				$rsnew['image'] = NULL;
			} else {
				$rsnew['image'] = $this->image->Upload->FileName;
			}
		}

		// descrp
		$this->descrp->SetDbValueDef($rsnew, $this->descrp->CurrentValue, NULL, FALSE);

		// slug
		$this->slug->SetDbValueDef($rsnew, $this->slug->CurrentValue, "", FALSE);

		// category
		$this->category->SetDbValueDef($rsnew, $this->category->CurrentValue, "", FALSE);

		// rate_ord
		$this->rate_ord->SetDbValueDef($rsnew, $this->rate_ord->CurrentValue, NULL, FALSE);
		if (!$this->image->Upload->KeepFile) {
			$this->image->UploadPath = "../images/team/";
			if (!ew_Empty($this->image->Upload->Value)) {
				if ($this->image->Upload->FileName == $this->image->Upload->DbValue) { // Overwrite if same file name
					$this->image->Upload->DbValue = ""; // No need to delete any more
				} else {
					$rsnew['image'] = ew_UploadFileNameEx(ew_UploadPathEx(TRUE, $this->image->UploadPath), $rsnew['image']); // Get new file name
				}
			}
		}

		// Call Row Inserting event
		$rs = ($rsold == NULL) ? NULL : $rsold->fields;
		$bInsertRow = $this->Row_Inserting($rs, $rsnew);
		if ($bInsertRow) {
			$conn->raiseErrorFn = 'ew_ErrorFn';
			$AddRow = $this->Insert($rsnew);
			$conn->raiseErrorFn = '';
			if ($AddRow) {
				if (!$this->image->Upload->KeepFile) {
					if (!ew_Empty($this->image->Upload->Value)) {
						$this->image->Upload->SaveToFile($this->image->UploadPath, $rsnew['image'], TRUE);
					}
					if ($this->image->Upload->DbValue <> "")
						@unlink(ew_UploadPathEx(TRUE, $this->image->OldUploadPath) . $this->image->Upload->DbValue);
				}
			}
		} else {
			if ($this->getSuccessMessage() <> "" || $this->getFailureMessage() <> "") {

				// Use the message, do nothing
			} elseif ($this->CancelMessage <> "") {
				$this->setFailureMessage($this->CancelMessage);
				$this->CancelMessage = "";
			} else {
				$this->setFailureMessage($Language->Phrase("InsertCancelled"));
			}
			$AddRow = FALSE;
		}

		// Get insert id if necessary
		if ($AddRow) {
			$this->id->setDbValue($conn->Insert_ID());
			$rsnew['id'] = $this->id->DbValue;
		}
		if ($AddRow) {

			// Call Row Inserted event
			$rs = ($rsold == NULL) ? NULL : $rsold->fields;
			$this->Row_Inserted($rs, $rsnew);
		}

		// image
		ew_CleanUploadTempPath($this->image, $this->image->Upload->Index);
		return $AddRow;
	}

	// Set up Breadcrumb
	function SetupBreadcrumb() {
		global $Breadcrumb, $Language;
		$Breadcrumb = new cBreadcrumb();
		$PageCaption = $this->TableCaption();
		$Breadcrumb->Add("list", "<span id=\"ewPageCaption\">" . $PageCaption . "</span>", "managementlist.php", $this->TableVar);
		$PageCaption = ($this->CurrentAction == "C") ? $Language->Phrase("Copy") : $Language->Phrase("Add");
		$Breadcrumb->Add("add", "<span id=\"ewPageCaption\">" . $PageCaption . "</span>", ew_CurrentUrl(), $this->TableVar);
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

	// Form Custom Validate event
	function Form_CustomValidate(&$CustomError) {

		// Return error message in CustomError
		return TRUE;
	}
}
?>
<?php ew_Header(FALSE) ?>
<?php

// Create page object
if (!isset($management_add)) $management_add = new cmanagement_add();

// Page init
$management_add->Page_Init();

// Page main
$management_add->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$management_add->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Page object
var management_add = new ew_Page("management_add");
management_add.PageID = "add"; // Page ID
var EW_PAGE_ID = management_add.PageID; // For backward compatibility

// Form object
var fmanagementadd = new ew_Form("fmanagementadd");

// Validate form
fmanagementadd.Validate = function() {
	if (!this.ValidateRequired)
		return true; // Ignore validation
	var $ = jQuery, fobj = this.GetForm(), $fobj = $(fobj);
	this.PostAutoSuggest();
	if ($fobj.find("#a_confirm").val() == "F")
		return true;
	var elm, felm, uelm, addcnt = 0;
	var $k = $fobj.find("#" + this.FormKeyCountName); // Get key_count
	var rowcnt = ($k[0]) ? parseInt($k.val(), 10) : 1;
	var startcnt = (rowcnt == 0) ? 0 : 1; // Check rowcnt == 0 => Inline-Add
	var gridinsert = $fobj.find("#a_list").val() == "gridinsert";
	for (var i = startcnt; i <= rowcnt; i++) {
		var infix = ($k[0]) ? String(i) : "";
		$fobj.data("rowindex", infix);
			elm = this.GetElements("x" + infix + "_name");
			if (elm && !ew_HasValue(elm))
				return this.OnError(elm, ewLanguage.Phrase("EnterRequiredField") + " - <?php echo ew_JsEncode2($management->name->FldCaption()) ?>");
			elm = this.GetElements("x" + infix + "_slug");
			if (elm && !ew_HasValue(elm))
				return this.OnError(elm, ewLanguage.Phrase("EnterRequiredField") + " - <?php echo ew_JsEncode2($management->slug->FldCaption()) ?>");
			elm = this.GetElements("x" + infix + "_category");
			if (elm && !ew_HasValue(elm))
				return this.OnError(elm, ewLanguage.Phrase("EnterRequiredField") + " - <?php echo ew_JsEncode2($management->category->FldCaption()) ?>");

			// Set up row object
			ew_ElementsToRow(fobj);

			// Fire Form_CustomValidate event
			if (!this.Form_CustomValidate(fobj))
				return false;
	}

	// Process detail forms
	var dfs = $fobj.find("input[name='detailpage']").get();
	for (var i = 0; i < dfs.length; i++) {
		var df = dfs[i], val = df.value;
		if (val && ewForms[val])
			if (!ewForms[val].Validate())
				return false;
	}
	return true;
}

// Form_CustomValidate event
fmanagementadd.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
fmanagementadd.ValidateRequired = true;
<?php } else { ?>
fmanagementadd.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
fmanagementadd.Lists["x_category"] = {"LinkField":"x_category","Ajax":null,"AutoFill":false,"DisplayFields":["x_category","","",""],"ParentFields":[],"FilterFields":[],"Options":[]};

// Form object for search
</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<?php $Breadcrumb->Render(); ?>
<?php $management_add->ShowPageHeader(); ?>
<?php
$management_add->ShowMessage();
?>
<form name="fmanagementadd" id="fmanagementadd" class="ewForm form-horizontal" action="<?php echo ew_CurrentPage() ?>" method="post">
<input type="hidden" name="t" value="management">
<input type="hidden" name="a_add" id="a_add" value="A">
<table cellspacing="0" class="ewGrid"><tr><td>
<table id="tbl_managementadd" class="table table-bordered table-striped">
<?php if ($management->name->Visible) { // name ?>
	<tr id="r_name">
		<td><span id="elh_management_name"><?php echo $management->name->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></span></td>
		<td<?php echo $management->name->CellAttributes() ?>>
<span id="el_management_name" class="control-group">
<input type="text" data-field="x_name" name="x_name" id="x_name" size="30" maxlength="100" placeholder="<?php echo $management->name->PlaceHolder ?>" value="<?php echo $management->name->EditValue ?>"<?php echo $management->name->EditAttributes() ?>>
</span>
<?php echo $management->name->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($management->position->Visible) { // position ?>
	<tr id="r_position">
		<td><span id="elh_management_position"><?php echo $management->position->FldCaption() ?></span></td>
		<td<?php echo $management->position->CellAttributes() ?>>
<span id="el_management_position" class="control-group">
<input type="text" data-field="x_position" name="x_position" id="x_position" size="30" maxlength="100" placeholder="<?php echo $management->position->PlaceHolder ?>" value="<?php echo $management->position->EditValue ?>"<?php echo $management->position->EditAttributes() ?>>
</span>
<?php echo $management->position->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($management->image->Visible) { // image ?>
	<tr id="r_image">
		<td><span id="elh_management_image"><?php echo $management->image->FldCaption() ?></span></td>
		<td<?php echo $management->image->CellAttributes() ?>>
<span id="el_management_image" class="control-group">
<span id="fd_x_image">
<span class="btn btn-small fileinput-button">
	<span><?php echo $Language->Phrase("ChooseFile") ?></span>
	<input type="file" data-field="x_image" name="x_image" id="x_image">
</span>
<input type="hidden" name="fn_x_image" id= "fn_x_image" value="<?php echo $management->image->Upload->FileName ?>">
<input type="hidden" name="fa_x_image" id= "fa_x_image" value="0">
<input type="hidden" name="fs_x_image" id= "fs_x_image" value="200">
</span>
<table id="ft_x_image" class="table table-condensed pull-left ewUploadTable"><tbody class="files"></tbody></table>
</span>
<?php echo $management->image->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($management->descrp->Visible) { // descrp ?>
	<tr id="r_descrp">
		<td><span id="elh_management_descrp"><?php echo $management->descrp->FldCaption() ?></span></td>
		<td<?php echo $management->descrp->CellAttributes() ?>>
<span id="el_management_descrp" class="control-group">
<textarea data-field="x_descrp" class="editor" name="x_descrp" id="x_descrp" cols="35" rows="4" placeholder="<?php echo $management->descrp->PlaceHolder ?>"<?php echo $management->descrp->EditAttributes() ?>><?php echo $management->descrp->EditValue ?></textarea>
<script type="text/javascript">
ew_CreateEditor("fmanagementadd", "x_descrp", 35, 4, <?php echo ($management->descrp->ReadOnly || FALSE) ? "true" : "false" ?>);
</script>
</span>
<?php echo $management->descrp->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($management->slug->Visible) { // slug ?>
	<tr id="r_slug">
		<td><span id="elh_management_slug"><?php echo $management->slug->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></span></td>
		<td<?php echo $management->slug->CellAttributes() ?>>
<span id="el_management_slug" class="control-group">
<input type="text" data-field="x_slug" name="x_slug" id="x_slug" size="30" maxlength="100" placeholder="<?php echo $management->slug->PlaceHolder ?>" value="<?php echo $management->slug->EditValue ?>"<?php echo $management->slug->EditAttributes() ?>>
</span>
<?php echo $management->slug->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($management->category->Visible) { // category ?>
	<tr id="r_category">
		<td><span id="elh_management_category"><?php echo $management->category->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></span></td>
		<td<?php echo $management->category->CellAttributes() ?>>
<span id="el_management_category" class="control-group">
<select data-field="x_category" id="x_category" name="x_category"<?php echo $management->category->EditAttributes() ?>>
<?php
if (is_array($management->category->EditValue)) {
	$arwrk = $management->category->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($management->category->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " selected=\"selected\"" : "";
		if ($selwrk <> "") $emptywrk = FALSE;
?>
<option value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?>>
<?php echo $arwrk[$rowcntwrk][1] ?>
</option>
<?php
	}
}
?>
</select>
<script type="text/javascript">
fmanagementadd.Lists["x_category"].Options = <?php echo (is_array($management->category->EditValue)) ? ew_ArrayToJson($management->category->EditValue, 1) : "[]" ?>;
</script>
</span>
<?php echo $management->category->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($management->rate_ord->Visible) { // rate_ord ?>
	<tr id="r_rate_ord">
		<td><span id="elh_management_rate_ord"><?php echo $management->rate_ord->FldCaption() ?></span></td>
		<td<?php echo $management->rate_ord->CellAttributes() ?>>
<span id="el_management_rate_ord" class="control-group">
<select data-field="x_rate_ord" id="x_rate_ord" name="x_rate_ord"<?php echo $management->rate_ord->EditAttributes() ?>>
<?php
if (is_array($management->rate_ord->EditValue)) {
	$arwrk = $management->rate_ord->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($management->rate_ord->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " selected=\"selected\"" : "";
		if ($selwrk <> "") $emptywrk = FALSE;
?>
<option value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?>>
<?php echo $arwrk[$rowcntwrk][1] ?>
</option>
<?php
	}
}
?>
</select>
</span>
<?php echo $management->rate_ord->CustomMsg ?></td>
	</tr>
<?php } ?>
</table>
</td></tr></table>
<button class="btn btn-primary ewButton" name="btnAction" id="btnAction" type="submit"><?php echo $Language->Phrase("AddBtn") ?></button>
</form>
<script type="text/javascript">
fmanagementadd.Init();
<?php if (EW_MOBILE_REFLOW && ew_IsMobile()) { ?>
ew_Reflow();
<?php } ?>
</script>
<?php
$management_add->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$management_add->Page_Terminate();
?>
