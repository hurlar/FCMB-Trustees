<?php
if (session_id() == "") session_start(); // Initialize Session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg10.php" ?>
<?php include_once "ewmysql10.php" ?>
<?php include_once "phpfn10.php" ?>
<?php include_once "simplewill_assets_tbinfo.php" ?>
<?php include_once "adminusersinfo.php" ?>
<?php include_once "simplewill_tbinfo.php" ?>
<?php include_once "simplewill_overall_assetgridcls.php" ?>
<?php include_once "userfn10.php" ?>
<?php

//
// Page class
//

$simplewill_assets_tb_add = NULL; // Initialize page object first

class csimplewill_assets_tb_add extends csimplewill_assets_tb {

	// Page ID
	var $PageID = 'add';

	// Project ID
	var $ProjectID = "{D9B361E7-B2C1-4293-B9B3-B581986A15CC}";

	// Table name
	var $TableName = 'simplewill_assets_tb';

	// Page object name
	var $PageObjName = 'simplewill_assets_tb_add';

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

		// Table object (simplewill_assets_tb)
		if (!isset($GLOBALS["simplewill_assets_tb"])) {
			$GLOBALS["simplewill_assets_tb"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["simplewill_assets_tb"];
		}

		// Table object (adminusers)
		if (!isset($GLOBALS['adminusers'])) $GLOBALS['adminusers'] = new cadminusers();

		// Table object (simplewill_tb)
		if (!isset($GLOBALS['simplewill_tb'])) $GLOBALS['simplewill_tb'] = new csimplewill_tb();

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'add', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'simplewill_assets_tb', TRUE);

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

		// Set up detail parameters
		$this->SetUpDetailParms();

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
					$this->Page_Terminate("simplewill_assets_tblist.php"); // No matching record, return to list
				}

				// Set up detail parameters
				$this->SetUpDetailParms();
				break;
			case "A": // Add new record
				$this->SendEmail = TRUE; // Send email on add success
				if ($this->AddRow($this->OldRecordset)) { // Add successful
					if ($this->getSuccessMessage() == "")
						$this->setSuccessMessage($Language->Phrase("AddSuccess")); // Set up success message
					if ($this->getCurrentDetailTable() <> "") // Master/detail add
						$sReturnUrl = $this->GetDetailUrl();
					else
						$sReturnUrl = $this->getReturnUrl();
					if (ew_GetPageName($sReturnUrl) == "simplewill_assets_tbview.php")
						$sReturnUrl = $this->GetViewUrl(); // View paging, return to view page with keyurl directly
					$this->Page_Terminate($sReturnUrl); // Clean up and return
				} else {
					$this->EventCancelled = TRUE; // Event cancelled
					$this->RestoreFormValues(); // Add failed, restore form values

					// Set up detail parameters
					$this->SetUpDetailParms();
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
		$this->asset_type->CurrentValue = NULL;
		$this->asset_type->OldValue = $this->asset_type->CurrentValue;
		$this->bvn->CurrentValue = NULL;
		$this->bvn->OldValue = $this->bvn->CurrentValue;
		$this->account_name->CurrentValue = NULL;
		$this->account_name->OldValue = $this->account_name->CurrentValue;
		$this->account_no->CurrentValue = NULL;
		$this->account_no->OldValue = $this->account_no->CurrentValue;
		$this->bankname->CurrentValue = NULL;
		$this->bankname->OldValue = $this->bankname->CurrentValue;
		$this->accounttype->CurrentValue = NULL;
		$this->accounttype->OldValue = $this->accounttype->CurrentValue;
		$this->rsa->CurrentValue = NULL;
		$this->rsa->OldValue = $this->rsa->CurrentValue;
		$this->pension_admin->CurrentValue = NULL;
		$this->pension_admin->OldValue = $this->pension_admin->CurrentValue;
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
		if (!$this->asset_type->FldIsDetailKey) {
			$this->asset_type->setFormValue($objForm->GetValue("x_asset_type"));
		}
		if (!$this->bvn->FldIsDetailKey) {
			$this->bvn->setFormValue($objForm->GetValue("x_bvn"));
		}
		if (!$this->account_name->FldIsDetailKey) {
			$this->account_name->setFormValue($objForm->GetValue("x_account_name"));
		}
		if (!$this->account_no->FldIsDetailKey) {
			$this->account_no->setFormValue($objForm->GetValue("x_account_no"));
		}
		if (!$this->bankname->FldIsDetailKey) {
			$this->bankname->setFormValue($objForm->GetValue("x_bankname"));
		}
		if (!$this->accounttype->FldIsDetailKey) {
			$this->accounttype->setFormValue($objForm->GetValue("x_accounttype"));
		}
		if (!$this->rsa->FldIsDetailKey) {
			$this->rsa->setFormValue($objForm->GetValue("x_rsa"));
		}
		if (!$this->pension_admin->FldIsDetailKey) {
			$this->pension_admin->setFormValue($objForm->GetValue("x_pension_admin"));
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
		$this->asset_type->CurrentValue = $this->asset_type->FormValue;
		$this->bvn->CurrentValue = $this->bvn->FormValue;
		$this->account_name->CurrentValue = $this->account_name->FormValue;
		$this->account_no->CurrentValue = $this->account_no->FormValue;
		$this->bankname->CurrentValue = $this->bankname->FormValue;
		$this->accounttype->CurrentValue = $this->accounttype->FormValue;
		$this->rsa->CurrentValue = $this->rsa->FormValue;
		$this->pension_admin->CurrentValue = $this->pension_admin->FormValue;
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
		$this->asset_type->setDbValue($rs->fields('asset_type'));
		$this->bvn->setDbValue($rs->fields('bvn'));
		$this->account_name->setDbValue($rs->fields('account_name'));
		$this->account_no->setDbValue($rs->fields('account_no'));
		$this->bankname->setDbValue($rs->fields('bankname'));
		$this->accounttype->setDbValue($rs->fields('accounttype'));
		$this->rsa->setDbValue($rs->fields('rsa'));
		$this->pension_admin->setDbValue($rs->fields('pension_admin'));
		$this->datecreated->setDbValue($rs->fields('datecreated'));
	}

	// Load DbValue from recordset
	function LoadDbValues(&$rs) {
		if (!$rs || !is_array($rs) && $rs->EOF) return;
		$row = is_array($rs) ? $rs : $rs->fields;
		$this->id->DbValue = $row['id'];
		$this->uid->DbValue = $row['uid'];
		$this->asset_type->DbValue = $row['asset_type'];
		$this->bvn->DbValue = $row['bvn'];
		$this->account_name->DbValue = $row['account_name'];
		$this->account_no->DbValue = $row['account_no'];
		$this->bankname->DbValue = $row['bankname'];
		$this->accounttype->DbValue = $row['accounttype'];
		$this->rsa->DbValue = $row['rsa'];
		$this->pension_admin->DbValue = $row['pension_admin'];
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
		// asset_type
		// bvn
		// account_name
		// account_no
		// bankname
		// accounttype
		// rsa
		// pension_admin
		// datecreated

		if ($this->RowType == EW_ROWTYPE_VIEW) { // View row

			// id
			$this->id->ViewValue = $this->id->CurrentValue;
			$this->id->ViewCustomAttributes = "";

			// uid
			$this->uid->ViewValue = $this->uid->CurrentValue;
			$this->uid->ViewCustomAttributes = "";

			// asset_type
			$this->asset_type->ViewValue = $this->asset_type->CurrentValue;
			$this->asset_type->ViewCustomAttributes = "";

			// bvn
			$this->bvn->ViewValue = $this->bvn->CurrentValue;
			$this->bvn->ViewCustomAttributes = "";

			// account_name
			$this->account_name->ViewValue = $this->account_name->CurrentValue;
			$this->account_name->ViewCustomAttributes = "";

			// account_no
			$this->account_no->ViewValue = $this->account_no->CurrentValue;
			$this->account_no->ViewCustomAttributes = "";

			// bankname
			$this->bankname->ViewValue = $this->bankname->CurrentValue;
			$this->bankname->ViewCustomAttributes = "";

			// accounttype
			$this->accounttype->ViewValue = $this->accounttype->CurrentValue;
			$this->accounttype->ViewCustomAttributes = "";

			// rsa
			$this->rsa->ViewValue = $this->rsa->CurrentValue;
			$this->rsa->ViewCustomAttributes = "";

			// pension_admin
			$this->pension_admin->ViewValue = $this->pension_admin->CurrentValue;
			$this->pension_admin->ViewCustomAttributes = "";

			// datecreated
			$this->datecreated->ViewValue = $this->datecreated->CurrentValue;
			$this->datecreated->ViewCustomAttributes = "";

			// uid
			$this->uid->LinkCustomAttributes = "";
			$this->uid->HrefValue = "";
			$this->uid->TooltipValue = "";

			// asset_type
			$this->asset_type->LinkCustomAttributes = "";
			$this->asset_type->HrefValue = "";
			$this->asset_type->TooltipValue = "";

			// bvn
			$this->bvn->LinkCustomAttributes = "";
			$this->bvn->HrefValue = "";
			$this->bvn->TooltipValue = "";

			// account_name
			$this->account_name->LinkCustomAttributes = "";
			$this->account_name->HrefValue = "";
			$this->account_name->TooltipValue = "";

			// account_no
			$this->account_no->LinkCustomAttributes = "";
			$this->account_no->HrefValue = "";
			$this->account_no->TooltipValue = "";

			// bankname
			$this->bankname->LinkCustomAttributes = "";
			$this->bankname->HrefValue = "";
			$this->bankname->TooltipValue = "";

			// accounttype
			$this->accounttype->LinkCustomAttributes = "";
			$this->accounttype->HrefValue = "";
			$this->accounttype->TooltipValue = "";

			// rsa
			$this->rsa->LinkCustomAttributes = "";
			$this->rsa->HrefValue = "";
			$this->rsa->TooltipValue = "";

			// pension_admin
			$this->pension_admin->LinkCustomAttributes = "";
			$this->pension_admin->HrefValue = "";
			$this->pension_admin->TooltipValue = "";

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

			// asset_type
			$this->asset_type->EditCustomAttributes = "";
			$this->asset_type->EditValue = $this->asset_type->CurrentValue;
			$this->asset_type->PlaceHolder = ew_HtmlEncode(ew_RemoveHtml($this->asset_type->FldCaption()));

			// bvn
			$this->bvn->EditCustomAttributes = "";
			$this->bvn->EditValue = $this->bvn->CurrentValue;
			$this->bvn->PlaceHolder = ew_HtmlEncode(ew_RemoveHtml($this->bvn->FldCaption()));

			// account_name
			$this->account_name->EditCustomAttributes = "";
			$this->account_name->EditValue = $this->account_name->CurrentValue;
			$this->account_name->PlaceHolder = ew_HtmlEncode(ew_RemoveHtml($this->account_name->FldCaption()));

			// account_no
			$this->account_no->EditCustomAttributes = "";
			$this->account_no->EditValue = $this->account_no->CurrentValue;
			$this->account_no->PlaceHolder = ew_HtmlEncode(ew_RemoveHtml($this->account_no->FldCaption()));

			// bankname
			$this->bankname->EditCustomAttributes = "";
			$this->bankname->EditValue = $this->bankname->CurrentValue;
			$this->bankname->PlaceHolder = ew_HtmlEncode(ew_RemoveHtml($this->bankname->FldCaption()));

			// accounttype
			$this->accounttype->EditCustomAttributes = "";
			$this->accounttype->EditValue = $this->accounttype->CurrentValue;
			$this->accounttype->PlaceHolder = ew_HtmlEncode(ew_RemoveHtml($this->accounttype->FldCaption()));

			// rsa
			$this->rsa->EditCustomAttributes = "";
			$this->rsa->EditValue = $this->rsa->CurrentValue;
			$this->rsa->PlaceHolder = ew_HtmlEncode(ew_RemoveHtml($this->rsa->FldCaption()));

			// pension_admin
			$this->pension_admin->EditCustomAttributes = "";
			$this->pension_admin->EditValue = $this->pension_admin->CurrentValue;
			$this->pension_admin->PlaceHolder = ew_HtmlEncode(ew_RemoveHtml($this->pension_admin->FldCaption()));

			// datecreated
			$this->datecreated->EditCustomAttributes = "";
			$this->datecreated->EditValue = ew_HtmlEncode($this->datecreated->CurrentValue);
			$this->datecreated->PlaceHolder = ew_HtmlEncode(ew_RemoveHtml($this->datecreated->FldCaption()));

			// Edit refer script
			// uid

			$this->uid->HrefValue = "";

			// asset_type
			$this->asset_type->HrefValue = "";

			// bvn
			$this->bvn->HrefValue = "";

			// account_name
			$this->account_name->HrefValue = "";

			// account_no
			$this->account_no->HrefValue = "";

			// bankname
			$this->bankname->HrefValue = "";

			// accounttype
			$this->accounttype->HrefValue = "";

			// rsa
			$this->rsa->HrefValue = "";

			// pension_admin
			$this->pension_admin->HrefValue = "";

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
		if (!$this->uid->FldIsDetailKey && !is_null($this->uid->FormValue) && $this->uid->FormValue == "") {
			ew_AddMessage($gsFormError, $Language->Phrase("EnterRequiredField") . " - " . $this->uid->FldCaption());
		}
		if (!ew_CheckInteger($this->uid->FormValue)) {
			ew_AddMessage($gsFormError, $this->uid->FldErrMsg());
		}

		// Validate detail grid
		$DetailTblVar = explode(",", $this->getCurrentDetailTable());
		if (in_array("simplewill_overall_asset", $DetailTblVar) && $GLOBALS["simplewill_overall_asset"]->DetailAdd) {
			if (!isset($GLOBALS["simplewill_overall_asset_grid"])) $GLOBALS["simplewill_overall_asset_grid"] = new csimplewill_overall_asset_grid(); // get detail page object
			$GLOBALS["simplewill_overall_asset_grid"]->ValidateGridForm();
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

		// Check referential integrity for master table 'simplewill_tb'
		$bValidMasterRecord = TRUE;
		$sMasterFilter = $this->SqlMasterFilter_simplewill_tb();
		if (strval($this->uid->CurrentValue) <> "") {
			$sMasterFilter = str_replace("@uid@", ew_AdjustSql($this->uid->CurrentValue), $sMasterFilter);
		} else {
			$bValidMasterRecord = FALSE;
		}
		if ($bValidMasterRecord) {
			$rsmaster = $GLOBALS["simplewill_tb"]->LoadRs($sMasterFilter);
			$bValidMasterRecord = ($rsmaster && !$rsmaster->EOF);
			$rsmaster->Close();
		}
		if (!$bValidMasterRecord) {
			$sRelatedRecordMsg = str_replace("%t", "simplewill_tb", $Language->Phrase("RelatedRecordRequired"));
			$this->setFailureMessage($sRelatedRecordMsg);
			return FALSE;
		}

		// Begin transaction
		if ($this->getCurrentDetailTable() <> "")
			$conn->BeginTrans();

		// Load db values from rsold
		if ($rsold) {
			$this->LoadDbValues($rsold);
		}
		$rsnew = array();

		// uid
		$this->uid->SetDbValueDef($rsnew, $this->uid->CurrentValue, 0, FALSE);

		// asset_type
		$this->asset_type->SetDbValueDef($rsnew, $this->asset_type->CurrentValue, NULL, FALSE);

		// bvn
		$this->bvn->SetDbValueDef($rsnew, $this->bvn->CurrentValue, NULL, FALSE);

		// account_name
		$this->account_name->SetDbValueDef($rsnew, $this->account_name->CurrentValue, NULL, FALSE);

		// account_no
		$this->account_no->SetDbValueDef($rsnew, $this->account_no->CurrentValue, NULL, FALSE);

		// bankname
		$this->bankname->SetDbValueDef($rsnew, $this->bankname->CurrentValue, NULL, FALSE);

		// accounttype
		$this->accounttype->SetDbValueDef($rsnew, $this->accounttype->CurrentValue, NULL, FALSE);

		// rsa
		$this->rsa->SetDbValueDef($rsnew, $this->rsa->CurrentValue, NULL, FALSE);

		// pension_admin
		$this->pension_admin->SetDbValueDef($rsnew, $this->pension_admin->CurrentValue, NULL, FALSE);

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

		// Add detail records
		if ($AddRow) {
			$DetailTblVar = explode(",", $this->getCurrentDetailTable());
			if (in_array("simplewill_overall_asset", $DetailTblVar) && $GLOBALS["simplewill_overall_asset"]->DetailAdd) {
				$GLOBALS["simplewill_overall_asset"]->uid->setSessionValue($this->uid->CurrentValue); // Set master key
				if (!isset($GLOBALS["simplewill_overall_asset_grid"])) $GLOBALS["simplewill_overall_asset_grid"] = new csimplewill_overall_asset_grid(); // Get detail page object
				$AddRow = $GLOBALS["simplewill_overall_asset_grid"]->GridInsert();
				if (!$AddRow)
					$GLOBALS["simplewill_overall_asset"]->uid->setSessionValue(""); // Clear master key if insert failed
			}
		}

		// Commit/Rollback transaction
		if ($this->getCurrentDetailTable() <> "") {
			if ($AddRow) {
				$conn->CommitTrans(); // Commit transaction
			} else {
				$conn->RollbackTrans(); // Rollback transaction
			}
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
			if ($sMasterTblVar == "simplewill_tb") {
				$bValidMaster = TRUE;
				if (@$_GET["uid"] <> "") {
					$GLOBALS["simplewill_tb"]->uid->setQueryStringValue($_GET["uid"]);
					$this->uid->setQueryStringValue($GLOBALS["simplewill_tb"]->uid->QueryStringValue);
					$this->uid->setSessionValue($this->uid->QueryStringValue);
					if (!is_numeric($GLOBALS["simplewill_tb"]->uid->QueryStringValue)) $bValidMaster = FALSE;
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
			if ($sMasterTblVar <> "simplewill_tb") {
				if ($this->uid->QueryStringValue == "") $this->uid->setSessionValue("");
			}
		}
		$this->DbMasterFilter = $this->GetMasterFilter(); //  Get master filter
		$this->DbDetailFilter = $this->GetDetailFilter(); // Get detail filter
	}

	// Set up detail parms based on QueryString
	function SetUpDetailParms() {

		// Get the keys for master table
		if (isset($_GET[EW_TABLE_SHOW_DETAIL])) {
			$sDetailTblVar = $_GET[EW_TABLE_SHOW_DETAIL];
			$this->setCurrentDetailTable($sDetailTblVar);
		} else {
			$sDetailTblVar = $this->getCurrentDetailTable();
		}
		if ($sDetailTblVar <> "") {
			$DetailTblVar = explode(",", $sDetailTblVar);
			if (in_array("simplewill_overall_asset", $DetailTblVar)) {
				if (!isset($GLOBALS["simplewill_overall_asset_grid"]))
					$GLOBALS["simplewill_overall_asset_grid"] = new csimplewill_overall_asset_grid;
				if ($GLOBALS["simplewill_overall_asset_grid"]->DetailAdd) {
					if ($this->CopyRecord)
						$GLOBALS["simplewill_overall_asset_grid"]->CurrentMode = "copy";
					else
						$GLOBALS["simplewill_overall_asset_grid"]->CurrentMode = "add";
					$GLOBALS["simplewill_overall_asset_grid"]->CurrentAction = "gridadd";

					// Save current master table to detail table
					$GLOBALS["simplewill_overall_asset_grid"]->setCurrentMasterTable($this->TableVar);
					$GLOBALS["simplewill_overall_asset_grid"]->setStartRecordNumber(1);
					$GLOBALS["simplewill_overall_asset_grid"]->uid->FldIsDetailKey = TRUE;
					$GLOBALS["simplewill_overall_asset_grid"]->uid->CurrentValue = $this->uid->CurrentValue;
					$GLOBALS["simplewill_overall_asset_grid"]->uid->setSessionValue($GLOBALS["simplewill_overall_asset_grid"]->uid->CurrentValue);
				}
			}
		}
	}

	// Set up Breadcrumb
	function SetupBreadcrumb() {
		global $Breadcrumb, $Language;
		$Breadcrumb = new cBreadcrumb();
		$PageCaption = $this->TableCaption();
		$Breadcrumb->Add("list", "<span id=\"ewPageCaption\">" . $PageCaption . "</span>", "simplewill_assets_tblist.php", $this->TableVar);
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
if (!isset($simplewill_assets_tb_add)) $simplewill_assets_tb_add = new csimplewill_assets_tb_add();

// Page init
$simplewill_assets_tb_add->Page_Init();

// Page main
$simplewill_assets_tb_add->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$simplewill_assets_tb_add->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Page object
var simplewill_assets_tb_add = new ew_Page("simplewill_assets_tb_add");
simplewill_assets_tb_add.PageID = "add"; // Page ID
var EW_PAGE_ID = simplewill_assets_tb_add.PageID; // For backward compatibility

// Form object
var fsimplewill_assets_tbadd = new ew_Form("fsimplewill_assets_tbadd");

// Validate form
fsimplewill_assets_tbadd.Validate = function() {
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
			if (elm && !ew_HasValue(elm))
				return this.OnError(elm, ewLanguage.Phrase("EnterRequiredField") + " - <?php echo ew_JsEncode2($simplewill_assets_tb->uid->FldCaption()) ?>");
			elm = this.GetElements("x" + infix + "_uid");
			if (elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($simplewill_assets_tb->uid->FldErrMsg()) ?>");

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
fsimplewill_assets_tbadd.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
fsimplewill_assets_tbadd.ValidateRequired = true;
<?php } else { ?>
fsimplewill_assets_tbadd.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
// Form object for search

</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<?php $Breadcrumb->Render(); ?>
<?php $simplewill_assets_tb_add->ShowPageHeader(); ?>
<?php
$simplewill_assets_tb_add->ShowMessage();
?>
<form name="fsimplewill_assets_tbadd" id="fsimplewill_assets_tbadd" class="ewForm form-horizontal" action="<?php echo ew_CurrentPage() ?>" method="post">
<input type="hidden" name="t" value="simplewill_assets_tb">
<input type="hidden" name="a_add" id="a_add" value="A">
<table cellspacing="0" class="ewGrid"><tr><td>
<table id="tbl_simplewill_assets_tbadd" class="table table-bordered table-striped">
<?php if ($simplewill_assets_tb->uid->Visible) { // uid ?>
	<tr id="r_uid">
		<td><span id="elh_simplewill_assets_tb_uid"><?php echo $simplewill_assets_tb->uid->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></span></td>
		<td<?php echo $simplewill_assets_tb->uid->CellAttributes() ?>>
<?php if ($simplewill_assets_tb->uid->getSessionValue() <> "") { ?>
<span<?php echo $simplewill_assets_tb->uid->ViewAttributes() ?>>
<?php echo $simplewill_assets_tb->uid->ViewValue ?></span>
<input type="hidden" id="x_uid" name="x_uid" value="<?php echo ew_HtmlEncode($simplewill_assets_tb->uid->CurrentValue) ?>">
<?php } else { ?>
<input type="text" data-field="x_uid" name="x_uid" id="x_uid" size="30" placeholder="<?php echo $simplewill_assets_tb->uid->PlaceHolder ?>" value="<?php echo $simplewill_assets_tb->uid->EditValue ?>"<?php echo $simplewill_assets_tb->uid->EditAttributes() ?>>
<?php } ?>
<?php echo $simplewill_assets_tb->uid->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($simplewill_assets_tb->asset_type->Visible) { // asset_type ?>
	<tr id="r_asset_type">
		<td><span id="elh_simplewill_assets_tb_asset_type"><?php echo $simplewill_assets_tb->asset_type->FldCaption() ?></span></td>
		<td<?php echo $simplewill_assets_tb->asset_type->CellAttributes() ?>>
<span id="el_simplewill_assets_tb_asset_type" class="control-group">
<textarea data-field="x_asset_type" name="x_asset_type" id="x_asset_type" cols="35" rows="4" placeholder="<?php echo $simplewill_assets_tb->asset_type->PlaceHolder ?>"<?php echo $simplewill_assets_tb->asset_type->EditAttributes() ?>><?php echo $simplewill_assets_tb->asset_type->EditValue ?></textarea>
</span>
<?php echo $simplewill_assets_tb->asset_type->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($simplewill_assets_tb->bvn->Visible) { // bvn ?>
	<tr id="r_bvn">
		<td><span id="elh_simplewill_assets_tb_bvn"><?php echo $simplewill_assets_tb->bvn->FldCaption() ?></span></td>
		<td<?php echo $simplewill_assets_tb->bvn->CellAttributes() ?>>
<span id="el_simplewill_assets_tb_bvn" class="control-group">
<textarea data-field="x_bvn" name="x_bvn" id="x_bvn" cols="35" rows="4" placeholder="<?php echo $simplewill_assets_tb->bvn->PlaceHolder ?>"<?php echo $simplewill_assets_tb->bvn->EditAttributes() ?>><?php echo $simplewill_assets_tb->bvn->EditValue ?></textarea>
</span>
<?php echo $simplewill_assets_tb->bvn->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($simplewill_assets_tb->account_name->Visible) { // account_name ?>
	<tr id="r_account_name">
		<td><span id="elh_simplewill_assets_tb_account_name"><?php echo $simplewill_assets_tb->account_name->FldCaption() ?></span></td>
		<td<?php echo $simplewill_assets_tb->account_name->CellAttributes() ?>>
<span id="el_simplewill_assets_tb_account_name" class="control-group">
<textarea data-field="x_account_name" name="x_account_name" id="x_account_name" cols="35" rows="4" placeholder="<?php echo $simplewill_assets_tb->account_name->PlaceHolder ?>"<?php echo $simplewill_assets_tb->account_name->EditAttributes() ?>><?php echo $simplewill_assets_tb->account_name->EditValue ?></textarea>
</span>
<?php echo $simplewill_assets_tb->account_name->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($simplewill_assets_tb->account_no->Visible) { // account_no ?>
	<tr id="r_account_no">
		<td><span id="elh_simplewill_assets_tb_account_no"><?php echo $simplewill_assets_tb->account_no->FldCaption() ?></span></td>
		<td<?php echo $simplewill_assets_tb->account_no->CellAttributes() ?>>
<span id="el_simplewill_assets_tb_account_no" class="control-group">
<textarea data-field="x_account_no" name="x_account_no" id="x_account_no" cols="35" rows="4" placeholder="<?php echo $simplewill_assets_tb->account_no->PlaceHolder ?>"<?php echo $simplewill_assets_tb->account_no->EditAttributes() ?>><?php echo $simplewill_assets_tb->account_no->EditValue ?></textarea>
</span>
<?php echo $simplewill_assets_tb->account_no->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($simplewill_assets_tb->bankname->Visible) { // bankname ?>
	<tr id="r_bankname">
		<td><span id="elh_simplewill_assets_tb_bankname"><?php echo $simplewill_assets_tb->bankname->FldCaption() ?></span></td>
		<td<?php echo $simplewill_assets_tb->bankname->CellAttributes() ?>>
<span id="el_simplewill_assets_tb_bankname" class="control-group">
<textarea data-field="x_bankname" name="x_bankname" id="x_bankname" cols="35" rows="4" placeholder="<?php echo $simplewill_assets_tb->bankname->PlaceHolder ?>"<?php echo $simplewill_assets_tb->bankname->EditAttributes() ?>><?php echo $simplewill_assets_tb->bankname->EditValue ?></textarea>
</span>
<?php echo $simplewill_assets_tb->bankname->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($simplewill_assets_tb->accounttype->Visible) { // accounttype ?>
	<tr id="r_accounttype">
		<td><span id="elh_simplewill_assets_tb_accounttype"><?php echo $simplewill_assets_tb->accounttype->FldCaption() ?></span></td>
		<td<?php echo $simplewill_assets_tb->accounttype->CellAttributes() ?>>
<span id="el_simplewill_assets_tb_accounttype" class="control-group">
<textarea data-field="x_accounttype" name="x_accounttype" id="x_accounttype" cols="35" rows="4" placeholder="<?php echo $simplewill_assets_tb->accounttype->PlaceHolder ?>"<?php echo $simplewill_assets_tb->accounttype->EditAttributes() ?>><?php echo $simplewill_assets_tb->accounttype->EditValue ?></textarea>
</span>
<?php echo $simplewill_assets_tb->accounttype->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($simplewill_assets_tb->rsa->Visible) { // rsa ?>
	<tr id="r_rsa">
		<td><span id="elh_simplewill_assets_tb_rsa"><?php echo $simplewill_assets_tb->rsa->FldCaption() ?></span></td>
		<td<?php echo $simplewill_assets_tb->rsa->CellAttributes() ?>>
<span id="el_simplewill_assets_tb_rsa" class="control-group">
<textarea data-field="x_rsa" name="x_rsa" id="x_rsa" cols="35" rows="4" placeholder="<?php echo $simplewill_assets_tb->rsa->PlaceHolder ?>"<?php echo $simplewill_assets_tb->rsa->EditAttributes() ?>><?php echo $simplewill_assets_tb->rsa->EditValue ?></textarea>
</span>
<?php echo $simplewill_assets_tb->rsa->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($simplewill_assets_tb->pension_admin->Visible) { // pension_admin ?>
	<tr id="r_pension_admin">
		<td><span id="elh_simplewill_assets_tb_pension_admin"><?php echo $simplewill_assets_tb->pension_admin->FldCaption() ?></span></td>
		<td<?php echo $simplewill_assets_tb->pension_admin->CellAttributes() ?>>
<span id="el_simplewill_assets_tb_pension_admin" class="control-group">
<textarea data-field="x_pension_admin" name="x_pension_admin" id="x_pension_admin" cols="35" rows="4" placeholder="<?php echo $simplewill_assets_tb->pension_admin->PlaceHolder ?>"<?php echo $simplewill_assets_tb->pension_admin->EditAttributes() ?>><?php echo $simplewill_assets_tb->pension_admin->EditValue ?></textarea>
</span>
<?php echo $simplewill_assets_tb->pension_admin->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($simplewill_assets_tb->datecreated->Visible) { // datecreated ?>
	<tr id="r_datecreated">
		<td><span id="elh_simplewill_assets_tb_datecreated"><?php echo $simplewill_assets_tb->datecreated->FldCaption() ?></span></td>
		<td<?php echo $simplewill_assets_tb->datecreated->CellAttributes() ?>>
<span id="el_simplewill_assets_tb_datecreated" class="control-group">
<input type="text" data-field="x_datecreated" name="x_datecreated" id="x_datecreated" placeholder="<?php echo $simplewill_assets_tb->datecreated->PlaceHolder ?>" value="<?php echo $simplewill_assets_tb->datecreated->EditValue ?>"<?php echo $simplewill_assets_tb->datecreated->EditAttributes() ?>>
</span>
<?php echo $simplewill_assets_tb->datecreated->CustomMsg ?></td>
	</tr>
<?php } ?>
</table>
</td></tr></table>
<?php
	if (in_array("simplewill_overall_asset", explode(",", $simplewill_assets_tb->getCurrentDetailTable())) && $simplewill_overall_asset->DetailAdd) {
?>
<?php include_once "simplewill_overall_assetgrid.php" ?>
<?php } ?>
<button class="btn btn-primary ewButton" name="btnAction" id="btnAction" type="submit"><?php echo $Language->Phrase("AddBtn") ?></button>
</form>
<script type="text/javascript">
fsimplewill_assets_tbadd.Init();
<?php if (EW_MOBILE_REFLOW && ew_IsMobile()) { ?>
ew_Reflow();
<?php } ?>
</script>
<?php
$simplewill_assets_tb_add->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$simplewill_assets_tb_add->Page_Terminate();
?>
