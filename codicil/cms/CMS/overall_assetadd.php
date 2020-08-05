<?php
if (session_id() == "") session_start(); // Initialize Session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg10.php" ?>
<?php include_once "ewmysql10.php" ?>
<?php include_once "phpfn10.php" ?>
<?php include_once "overall_assetinfo.php" ?>
<?php include_once "adminusersinfo.php" ?>
<?php include_once "assets_tbinfo.php" ?>
<?php include_once "personal_infoinfo.php" ?>
<?php include_once "userfn10.php" ?>
<?php

//
// Page class
//

$overall_asset_add = NULL; // Initialize page object first

class coverall_asset_add extends coverall_asset {

	// Page ID
	var $PageID = 'add';

	// Project ID
	var $ProjectID = "{D9B361E7-B2C1-4293-B9B3-B581986A15CC}";

	// Table name
	var $TableName = 'overall_asset';

	// Page object name
	var $PageObjName = 'overall_asset_add';

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

		// Table object (overall_asset)
		if (!isset($GLOBALS["overall_asset"])) {
			$GLOBALS["overall_asset"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["overall_asset"];
		}

		// Table object (adminusers)
		if (!isset($GLOBALS['adminusers'])) $GLOBALS['adminusers'] = new cadminusers();

		// Table object (assets_tb)
		if (!isset($GLOBALS['assets_tb'])) $GLOBALS['assets_tb'] = new cassets_tb();

		// Table object (personal_info)
		if (!isset($GLOBALS['personal_info'])) $GLOBALS['personal_info'] = new cpersonal_info();

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'add', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'overall_asset', TRUE);

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

		// Set up master/detail parameters
		$this->SetUpMasterParms();

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
					$this->Page_Terminate("overall_assetlist.php"); // No matching record, return to list
				}
				break;
			case "A": // Add new record
				$this->SendEmail = TRUE; // Send email on add success
				if ($this->AddRow($this->OldRecordset)) { // Add successful
					if ($this->getSuccessMessage() == "")
						$this->setSuccessMessage($Language->Phrase("AddSuccess")); // Set up success message
					$sReturnUrl = $this->getReturnUrl();
					if (ew_GetPageName($sReturnUrl) == "overall_assetview.php")
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
	}

	// Load default values
	function LoadDefaultValues() {
		$this->uid->CurrentValue = NULL;
		$this->uid->OldValue = $this->uid->CurrentValue;
		$this->beneficiaryid->CurrentValue = NULL;
		$this->beneficiaryid->OldValue = $this->beneficiaryid->CurrentValue;
		$this->propertyid->CurrentValue = NULL;
		$this->propertyid->OldValue = $this->propertyid->CurrentValue;
		$this->property_type->CurrentValue = NULL;
		$this->property_type->OldValue = $this->property_type->CurrentValue;
		$this->percentage->CurrentValue = NULL;
		$this->percentage->OldValue = $this->percentage->CurrentValue;
		$this->datecreated->CurrentValue = NULL;
		$this->datecreated->OldValue = $this->datecreated->CurrentValue;
	}

	// Load form values
	function LoadFormValues() {

		// Load from form
		global $objForm;
		if (!$this->uid->FldIsDetailKey) {
			$this->uid->setFormValue($objForm->GetValue("x_uid"));
		}
		if (!$this->beneficiaryid->FldIsDetailKey) {
			$this->beneficiaryid->setFormValue($objForm->GetValue("x_beneficiaryid"));
		}
		if (!$this->propertyid->FldIsDetailKey) {
			$this->propertyid->setFormValue($objForm->GetValue("x_propertyid"));
		}
		if (!$this->property_type->FldIsDetailKey) {
			$this->property_type->setFormValue($objForm->GetValue("x_property_type"));
		}
		if (!$this->percentage->FldIsDetailKey) {
			$this->percentage->setFormValue($objForm->GetValue("x_percentage"));
		}
		if (!$this->datecreated->FldIsDetailKey) {
			$this->datecreated->setFormValue($objForm->GetValue("x_datecreated"));
			$this->datecreated->CurrentValue = ew_UnFormatDateTime($this->datecreated->CurrentValue, 0);
		}
	}

	// Restore form values
	function RestoreFormValues() {
		global $objForm;
		$this->LoadOldRecord();
		$this->uid->CurrentValue = $this->uid->FormValue;
		$this->beneficiaryid->CurrentValue = $this->beneficiaryid->FormValue;
		$this->propertyid->CurrentValue = $this->propertyid->FormValue;
		$this->property_type->CurrentValue = $this->property_type->FormValue;
		$this->percentage->CurrentValue = $this->percentage->FormValue;
		$this->datecreated->CurrentValue = $this->datecreated->FormValue;
		$this->datecreated->CurrentValue = ew_UnFormatDateTime($this->datecreated->CurrentValue, 0);
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

			// uid
			$this->uid->LinkCustomAttributes = "";
			$this->uid->HrefValue = "";
			$this->uid->TooltipValue = "";

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
		} elseif ($this->RowType == EW_ROWTYPE_ADD) { // Add row

			// uid
			$this->uid->EditCustomAttributes = "";
			if ($this->uid->getSessionValue() <> "") {
				$this->uid->CurrentValue = $this->uid->getSessionValue();
			$this->uid->ViewValue = $this->uid->CurrentValue;
			$this->uid->ViewCustomAttributes = "";
			} else {
			$this->uid->EditValue = ew_HtmlEncode($this->uid->CurrentValue);
			$this->uid->PlaceHolder = ew_HtmlEncode(ew_RemoveHtml($this->uid->FldCaption()));
			}

			// beneficiaryid
			$this->beneficiaryid->EditCustomAttributes = "";
			$this->beneficiaryid->EditValue = ew_HtmlEncode($this->beneficiaryid->CurrentValue);
			$this->beneficiaryid->PlaceHolder = ew_HtmlEncode(ew_RemoveHtml($this->beneficiaryid->FldCaption()));

			// propertyid
			$this->propertyid->EditCustomAttributes = "";
			$this->propertyid->EditValue = ew_HtmlEncode($this->propertyid->CurrentValue);
			$this->propertyid->PlaceHolder = ew_HtmlEncode(ew_RemoveHtml($this->propertyid->FldCaption()));

			// property_type
			$this->property_type->EditCustomAttributes = "";
			$this->property_type->EditValue = ew_HtmlEncode($this->property_type->CurrentValue);
			$this->property_type->PlaceHolder = ew_HtmlEncode(ew_RemoveHtml($this->property_type->FldCaption()));

			// percentage
			$this->percentage->EditCustomAttributes = "";
			$this->percentage->EditValue = ew_HtmlEncode($this->percentage->CurrentValue);
			$this->percentage->PlaceHolder = ew_HtmlEncode(ew_RemoveHtml($this->percentage->FldCaption()));

			// datecreated
			$this->datecreated->EditCustomAttributes = "";
			$this->datecreated->EditValue = ew_HtmlEncode($this->datecreated->CurrentValue);
			$this->datecreated->PlaceHolder = ew_HtmlEncode(ew_RemoveHtml($this->datecreated->FldCaption()));

			// Edit refer script
			// uid

			$this->uid->HrefValue = "";

			// beneficiaryid
			$this->beneficiaryid->HrefValue = "";

			// propertyid
			$this->propertyid->HrefValue = "";

			// property_type
			$this->property_type->HrefValue = "";

			// percentage
			$this->percentage->HrefValue = "";

			// datecreated
			$this->datecreated->HrefValue = "";
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
		if (!ew_CheckInteger($this->uid->FormValue)) {
			ew_AddMessage($gsFormError, $this->uid->FldErrMsg());
		}
		if (!ew_CheckInteger($this->beneficiaryid->FormValue)) {
			ew_AddMessage($gsFormError, $this->beneficiaryid->FldErrMsg());
		}
		if (!ew_CheckInteger($this->propertyid->FormValue)) {
			ew_AddMessage($gsFormError, $this->propertyid->FldErrMsg());
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

		// Check referential integrity for master table 'personal_info'
		$bValidMasterRecord = TRUE;
		$sMasterFilter = $this->SqlMasterFilter_personal_info();
		if (strval($this->uid->CurrentValue) <> "") {
			$sMasterFilter = str_replace("@uid@", ew_AdjustSql($this->uid->CurrentValue), $sMasterFilter);
		} else {
			$bValidMasterRecord = FALSE;
		}
		if ($bValidMasterRecord) {
			$rsmaster = $GLOBALS["personal_info"]->LoadRs($sMasterFilter);
			$bValidMasterRecord = ($rsmaster && !$rsmaster->EOF);
			$rsmaster->Close();
		}
		if (!$bValidMasterRecord) {
			$sRelatedRecordMsg = str_replace("%t", "personal_info", $Language->Phrase("RelatedRecordRequired"));
			$this->setFailureMessage($sRelatedRecordMsg);
			return FALSE;
		}

		// Load db values from rsold
		if ($rsold) {
			$this->LoadDbValues($rsold);
		}
		$rsnew = array();

		// uid
		$this->uid->SetDbValueDef($rsnew, $this->uid->CurrentValue, NULL, FALSE);

		// beneficiaryid
		$this->beneficiaryid->SetDbValueDef($rsnew, $this->beneficiaryid->CurrentValue, NULL, FALSE);

		// propertyid
		$this->propertyid->SetDbValueDef($rsnew, $this->propertyid->CurrentValue, NULL, FALSE);

		// property_type
		$this->property_type->SetDbValueDef($rsnew, $this->property_type->CurrentValue, NULL, FALSE);

		// percentage
		$this->percentage->SetDbValueDef($rsnew, $this->percentage->CurrentValue, NULL, FALSE);

		// datecreated
		$this->datecreated->SetDbValueDef($rsnew, $this->datecreated->CurrentValue, NULL, FALSE);

		// Call Row Inserting event
		$rs = ($rsold == NULL) ? NULL : $rsold->fields;
		$bInsertRow = $this->Row_Inserting($rs, $rsnew);
		if ($bInsertRow) {
			$conn->raiseErrorFn = 'ew_ErrorFn';
			$AddRow = $this->Insert($rsnew);
			$conn->raiseErrorFn = '';
			if ($AddRow) {
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
		return $AddRow;
	}

	// Set up master/detail based on QueryString
	function SetUpMasterParms() {
		$bValidMaster = FALSE;

		// Get the keys for master table
		if (isset($_GET[EW_TABLE_SHOW_MASTER])) {
			$sMasterTblVar = $_GET[EW_TABLE_SHOW_MASTER];
			if ($sMasterTblVar == "") {
				$bValidMaster = TRUE;
				$this->DbMasterFilter = "";
				$this->DbDetailFilter = "";
			}
			if ($sMasterTblVar == "assets_tb") {
				$bValidMaster = TRUE;
				if (@$_GET["uid"] <> "") {
					$GLOBALS["assets_tb"]->uid->setQueryStringValue($_GET["uid"]);
					$this->uid->setQueryStringValue($GLOBALS["assets_tb"]->uid->QueryStringValue);
					$this->uid->setSessionValue($this->uid->QueryStringValue);
					if (!is_numeric($GLOBALS["assets_tb"]->uid->QueryStringValue)) $bValidMaster = FALSE;
				} else {
					$bValidMaster = FALSE;
				}
			}
			if ($sMasterTblVar == "personal_info") {
				$bValidMaster = TRUE;
				if (@$_GET["uid"] <> "") {
					$GLOBALS["personal_info"]->uid->setQueryStringValue($_GET["uid"]);
					$this->uid->setQueryStringValue($GLOBALS["personal_info"]->uid->QueryStringValue);
					$this->uid->setSessionValue($this->uid->QueryStringValue);
					if (!is_numeric($GLOBALS["personal_info"]->uid->QueryStringValue)) $bValidMaster = FALSE;
				} else {
					$bValidMaster = FALSE;
				}
			}
		}
		if ($bValidMaster) {

			// Save current master table
			$this->setCurrentMasterTable($sMasterTblVar);

			// Reset start record counter (new master key)
			$this->StartRec = 1;
			$this->setStartRecordNumber($this->StartRec);

			// Clear previous master key from Session
			if ($sMasterTblVar <> "assets_tb") {
				if ($this->uid->QueryStringValue == "") $this->uid->setSessionValue("");
			}
			if ($sMasterTblVar <> "personal_info") {
				if ($this->uid->QueryStringValue == "") $this->uid->setSessionValue("");
			}
		}
		$this->DbMasterFilter = $this->GetMasterFilter(); //  Get master filter
		$this->DbDetailFilter = $this->GetDetailFilter(); // Get detail filter
	}

	// Set up Breadcrumb
	function SetupBreadcrumb() {
		global $Breadcrumb, $Language;
		$Breadcrumb = new cBreadcrumb();
		$PageCaption = $this->TableCaption();
		$Breadcrumb->Add("list", "<span id=\"ewPageCaption\">" . $PageCaption . "</span>", "overall_assetlist.php", $this->TableVar);
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
if (!isset($overall_asset_add)) $overall_asset_add = new coverall_asset_add();

// Page init
$overall_asset_add->Page_Init();

// Page main
$overall_asset_add->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$overall_asset_add->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Page object
var overall_asset_add = new ew_Page("overall_asset_add");
overall_asset_add.PageID = "add"; // Page ID
var EW_PAGE_ID = overall_asset_add.PageID; // For backward compatibility

// Form object
var foverall_assetadd = new ew_Form("foverall_assetadd");

// Validate form
foverall_assetadd.Validate = function() {
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
			elm = this.GetElements("x" + infix + "_uid");
			if (elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($overall_asset->uid->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_beneficiaryid");
			if (elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($overall_asset->beneficiaryid->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_propertyid");
			if (elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($overall_asset->propertyid->FldErrMsg()) ?>");

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
foverall_assetadd.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
foverall_assetadd.ValidateRequired = true;
<?php } else { ?>
foverall_assetadd.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
// Form object for search

</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<?php $Breadcrumb->Render(); ?>
<?php $overall_asset_add->ShowPageHeader(); ?>
<?php
$overall_asset_add->ShowMessage();
?>
<form name="foverall_assetadd" id="foverall_assetadd" class="ewForm form-horizontal" action="<?php echo ew_CurrentPage() ?>" method="post">
<input type="hidden" name="t" value="overall_asset">
<input type="hidden" name="a_add" id="a_add" value="A">
<table cellspacing="0" class="ewGrid"><tr><td>
<table id="tbl_overall_assetadd" class="table table-bordered table-striped">
<?php if ($overall_asset->uid->Visible) { // uid ?>
	<tr id="r_uid">
		<td><span id="elh_overall_asset_uid"><?php echo $overall_asset->uid->FldCaption() ?></span></td>
		<td<?php echo $overall_asset->uid->CellAttributes() ?>>
<?php if ($overall_asset->uid->getSessionValue() <> "") { ?>
<span<?php echo $overall_asset->uid->ViewAttributes() ?>>
<?php echo $overall_asset->uid->ViewValue ?></span>
<input type="hidden" id="x_uid" name="x_uid" value="<?php echo ew_HtmlEncode($overall_asset->uid->CurrentValue) ?>">
<?php } else { ?>
<input type="text" data-field="x_uid" name="x_uid" id="x_uid" size="30" placeholder="<?php echo $overall_asset->uid->PlaceHolder ?>" value="<?php echo $overall_asset->uid->EditValue ?>"<?php echo $overall_asset->uid->EditAttributes() ?>>
<?php } ?>
<?php echo $overall_asset->uid->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($overall_asset->beneficiaryid->Visible) { // beneficiaryid ?>
	<tr id="r_beneficiaryid">
		<td><span id="elh_overall_asset_beneficiaryid"><?php echo $overall_asset->beneficiaryid->FldCaption() ?></span></td>
		<td<?php echo $overall_asset->beneficiaryid->CellAttributes() ?>>
<span id="el_overall_asset_beneficiaryid" class="control-group">
<input type="text" data-field="x_beneficiaryid" name="x_beneficiaryid" id="x_beneficiaryid" size="30" placeholder="<?php echo $overall_asset->beneficiaryid->PlaceHolder ?>" value="<?php echo $overall_asset->beneficiaryid->EditValue ?>"<?php echo $overall_asset->beneficiaryid->EditAttributes() ?>>
</span>
<?php echo $overall_asset->beneficiaryid->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($overall_asset->propertyid->Visible) { // propertyid ?>
	<tr id="r_propertyid">
		<td><span id="elh_overall_asset_propertyid"><?php echo $overall_asset->propertyid->FldCaption() ?></span></td>
		<td<?php echo $overall_asset->propertyid->CellAttributes() ?>>
<span id="el_overall_asset_propertyid" class="control-group">
<input type="text" data-field="x_propertyid" name="x_propertyid" id="x_propertyid" size="30" placeholder="<?php echo $overall_asset->propertyid->PlaceHolder ?>" value="<?php echo $overall_asset->propertyid->EditValue ?>"<?php echo $overall_asset->propertyid->EditAttributes() ?>>
</span>
<?php echo $overall_asset->propertyid->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($overall_asset->property_type->Visible) { // property_type ?>
	<tr id="r_property_type">
		<td><span id="elh_overall_asset_property_type"><?php echo $overall_asset->property_type->FldCaption() ?></span></td>
		<td<?php echo $overall_asset->property_type->CellAttributes() ?>>
<span id="el_overall_asset_property_type" class="control-group">
<input type="text" data-field="x_property_type" name="x_property_type" id="x_property_type" size="30" maxlength="50" placeholder="<?php echo $overall_asset->property_type->PlaceHolder ?>" value="<?php echo $overall_asset->property_type->EditValue ?>"<?php echo $overall_asset->property_type->EditAttributes() ?>>
</span>
<?php echo $overall_asset->property_type->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($overall_asset->percentage->Visible) { // percentage ?>
	<tr id="r_percentage">
		<td><span id="elh_overall_asset_percentage"><?php echo $overall_asset->percentage->FldCaption() ?></span></td>
		<td<?php echo $overall_asset->percentage->CellAttributes() ?>>
<span id="el_overall_asset_percentage" class="control-group">
<input type="text" data-field="x_percentage" name="x_percentage" id="x_percentage" size="30" maxlength="5" placeholder="<?php echo $overall_asset->percentage->PlaceHolder ?>" value="<?php echo $overall_asset->percentage->EditValue ?>"<?php echo $overall_asset->percentage->EditAttributes() ?>>
</span>
<?php echo $overall_asset->percentage->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($overall_asset->datecreated->Visible) { // datecreated ?>
	<tr id="r_datecreated">
		<td><span id="elh_overall_asset_datecreated"><?php echo $overall_asset->datecreated->FldCaption() ?></span></td>
		<td<?php echo $overall_asset->datecreated->CellAttributes() ?>>
<span id="el_overall_asset_datecreated" class="control-group">
<input type="text" data-field="x_datecreated" name="x_datecreated" id="x_datecreated" placeholder="<?php echo $overall_asset->datecreated->PlaceHolder ?>" value="<?php echo $overall_asset->datecreated->EditValue ?>"<?php echo $overall_asset->datecreated->EditAttributes() ?>>
</span>
<?php echo $overall_asset->datecreated->CustomMsg ?></td>
	</tr>
<?php } ?>
</table>
</td></tr></table>
<button class="btn btn-primary ewButton" name="btnAction" id="btnAction" type="submit"><?php echo $Language->Phrase("AddBtn") ?></button>
</form>
<script type="text/javascript">
foverall_assetadd.Init();
<?php if (EW_MOBILE_REFLOW && ew_IsMobile()) { ?>
ew_Reflow();
<?php } ?>
</script>
<?php
$overall_asset_add->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$overall_asset_add->Page_Terminate();
?>
