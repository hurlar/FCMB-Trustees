<?php
if (session_id() == "") session_start(); // Initialize Session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg10.php" ?>
<?php include_once "ewmysql10.php" ?>
<?php include_once "phpfn10.php" ?>
<?php include_once "assets_tbinfo.php" ?>
<?php include_once "adminusersinfo.php" ?>
<?php include_once "beneficiary_dumpinfo.php" ?>
<?php include_once "personal_infoinfo.php" ?>
<?php include_once "comprehensivewill_tbinfo.php" ?>
<?php include_once "premiumwill_tbinfo.php" ?>
<?php include_once "privatetrust_tbinfo.php" ?>
<?php include_once "overall_assetgridcls.php" ?>
<?php include_once "userfn10.php" ?>
<?php

//
// Page class
//

$assets_tb_add = NULL; // Initialize page object first

class cassets_tb_add extends cassets_tb {

	// Page ID
	var $PageID = 'add';

	// Project ID
	var $ProjectID = "{D9B361E7-B2C1-4293-B9B3-B581986A15CC}";

	// Table name
	var $TableName = 'assets_tb';

	// Page object name
	var $PageObjName = 'assets_tb_add';

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

		// Table object (assets_tb)
		if (!isset($GLOBALS["assets_tb"])) {
			$GLOBALS["assets_tb"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["assets_tb"];
		}

		// Table object (adminusers)
		if (!isset($GLOBALS['adminusers'])) $GLOBALS['adminusers'] = new cadminusers();

		// Table object (beneficiary_dump)
		if (!isset($GLOBALS['beneficiary_dump'])) $GLOBALS['beneficiary_dump'] = new cbeneficiary_dump();

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
			define("EW_PAGE_ID", 'add', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'assets_tb', TRUE);

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
					$this->Page_Terminate("assets_tblist.php"); // No matching record, return to list
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
					if (ew_GetPageName($sReturnUrl) == "assets_tbview.php")
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
		$this->property_location->CurrentValue = NULL;
		$this->property_location->OldValue = $this->property_location->CurrentValue;
		$this->property_type->CurrentValue = NULL;
		$this->property_type->OldValue = $this->property_type->CurrentValue;
		$this->property_registered->CurrentValue = NULL;
		$this->property_registered->OldValue = $this->property_registered->CurrentValue;
		$this->shares_company->CurrentValue = NULL;
		$this->shares_company->OldValue = $this->shares_company->CurrentValue;
		$this->shares_volume->CurrentValue = NULL;
		$this->shares_volume->OldValue = $this->shares_volume->CurrentValue;
		$this->shares_percent->CurrentValue = NULL;
		$this->shares_percent->OldValue = $this->shares_percent->CurrentValue;
		$this->shares_cscs->CurrentValue = NULL;
		$this->shares_cscs->OldValue = $this->shares_cscs->CurrentValue;
		$this->shares_chn->CurrentValue = NULL;
		$this->shares_chn->OldValue = $this->shares_chn->CurrentValue;
		$this->insurance_company->CurrentValue = NULL;
		$this->insurance_company->OldValue = $this->insurance_company->CurrentValue;
		$this->insurance_type->CurrentValue = NULL;
		$this->insurance_type->OldValue = $this->insurance_type->CurrentValue;
		$this->insurance_owner->CurrentValue = NULL;
		$this->insurance_owner->OldValue = $this->insurance_owner->CurrentValue;
		$this->insurance_facevalue->CurrentValue = NULL;
		$this->insurance_facevalue->OldValue = $this->insurance_facevalue->CurrentValue;
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
		$this->pension_name->CurrentValue = NULL;
		$this->pension_name->OldValue = $this->pension_name->CurrentValue;
		$this->pension_owner->CurrentValue = NULL;
		$this->pension_owner->OldValue = $this->pension_owner->CurrentValue;
		$this->pension_plan->CurrentValue = NULL;
		$this->pension_plan->OldValue = $this->pension_plan->CurrentValue;
		$this->rsano->CurrentValue = NULL;
		$this->rsano->OldValue = $this->rsano->CurrentValue;
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
		if (!$this->property_location->FldIsDetailKey) {
			$this->property_location->setFormValue($objForm->GetValue("x_property_location"));
		}
		if (!$this->property_type->FldIsDetailKey) {
			$this->property_type->setFormValue($objForm->GetValue("x_property_type"));
		}
		if (!$this->property_registered->FldIsDetailKey) {
			$this->property_registered->setFormValue($objForm->GetValue("x_property_registered"));
		}
		if (!$this->shares_company->FldIsDetailKey) {
			$this->shares_company->setFormValue($objForm->GetValue("x_shares_company"));
		}
		if (!$this->shares_volume->FldIsDetailKey) {
			$this->shares_volume->setFormValue($objForm->GetValue("x_shares_volume"));
		}
		if (!$this->shares_percent->FldIsDetailKey) {
			$this->shares_percent->setFormValue($objForm->GetValue("x_shares_percent"));
		}
		if (!$this->shares_cscs->FldIsDetailKey) {
			$this->shares_cscs->setFormValue($objForm->GetValue("x_shares_cscs"));
		}
		if (!$this->shares_chn->FldIsDetailKey) {
			$this->shares_chn->setFormValue($objForm->GetValue("x_shares_chn"));
		}
		if (!$this->insurance_company->FldIsDetailKey) {
			$this->insurance_company->setFormValue($objForm->GetValue("x_insurance_company"));
		}
		if (!$this->insurance_type->FldIsDetailKey) {
			$this->insurance_type->setFormValue($objForm->GetValue("x_insurance_type"));
		}
		if (!$this->insurance_owner->FldIsDetailKey) {
			$this->insurance_owner->setFormValue($objForm->GetValue("x_insurance_owner"));
		}
		if (!$this->insurance_facevalue->FldIsDetailKey) {
			$this->insurance_facevalue->setFormValue($objForm->GetValue("x_insurance_facevalue"));
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
		if (!$this->pension_name->FldIsDetailKey) {
			$this->pension_name->setFormValue($objForm->GetValue("x_pension_name"));
		}
		if (!$this->pension_owner->FldIsDetailKey) {
			$this->pension_owner->setFormValue($objForm->GetValue("x_pension_owner"));
		}
		if (!$this->pension_plan->FldIsDetailKey) {
			$this->pension_plan->setFormValue($objForm->GetValue("x_pension_plan"));
		}
		if (!$this->rsano->FldIsDetailKey) {
			$this->rsano->setFormValue($objForm->GetValue("x_rsano"));
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
		$this->property_location->CurrentValue = $this->property_location->FormValue;
		$this->property_type->CurrentValue = $this->property_type->FormValue;
		$this->property_registered->CurrentValue = $this->property_registered->FormValue;
		$this->shares_company->CurrentValue = $this->shares_company->FormValue;
		$this->shares_volume->CurrentValue = $this->shares_volume->FormValue;
		$this->shares_percent->CurrentValue = $this->shares_percent->FormValue;
		$this->shares_cscs->CurrentValue = $this->shares_cscs->FormValue;
		$this->shares_chn->CurrentValue = $this->shares_chn->FormValue;
		$this->insurance_company->CurrentValue = $this->insurance_company->FormValue;
		$this->insurance_type->CurrentValue = $this->insurance_type->FormValue;
		$this->insurance_owner->CurrentValue = $this->insurance_owner->FormValue;
		$this->insurance_facevalue->CurrentValue = $this->insurance_facevalue->FormValue;
		$this->bvn->CurrentValue = $this->bvn->FormValue;
		$this->account_name->CurrentValue = $this->account_name->FormValue;
		$this->account_no->CurrentValue = $this->account_no->FormValue;
		$this->bankname->CurrentValue = $this->bankname->FormValue;
		$this->accounttype->CurrentValue = $this->accounttype->FormValue;
		$this->pension_name->CurrentValue = $this->pension_name->FormValue;
		$this->pension_owner->CurrentValue = $this->pension_owner->FormValue;
		$this->pension_plan->CurrentValue = $this->pension_plan->FormValue;
		$this->rsano->CurrentValue = $this->rsano->FormValue;
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
		$this->property_location->setDbValue($rs->fields('property_location'));
		$this->property_type->setDbValue($rs->fields('property_type'));
		$this->property_registered->setDbValue($rs->fields('property_registered'));
		$this->shares_company->setDbValue($rs->fields('shares_company'));
		$this->shares_volume->setDbValue($rs->fields('shares_volume'));
		$this->shares_percent->setDbValue($rs->fields('shares_percent'));
		$this->shares_cscs->setDbValue($rs->fields('shares_cscs'));
		$this->shares_chn->setDbValue($rs->fields('shares_chn'));
		$this->insurance_company->setDbValue($rs->fields('insurance_company'));
		$this->insurance_type->setDbValue($rs->fields('insurance_type'));
		$this->insurance_owner->setDbValue($rs->fields('insurance_owner'));
		$this->insurance_facevalue->setDbValue($rs->fields('insurance_facevalue'));
		$this->bvn->setDbValue($rs->fields('bvn'));
		$this->account_name->setDbValue($rs->fields('account_name'));
		$this->account_no->setDbValue($rs->fields('account_no'));
		$this->bankname->setDbValue($rs->fields('bankname'));
		$this->accounttype->setDbValue($rs->fields('accounttype'));
		$this->pension_name->setDbValue($rs->fields('pension_name'));
		$this->pension_owner->setDbValue($rs->fields('pension_owner'));
		$this->pension_plan->setDbValue($rs->fields('pension_plan'));
		$this->rsano->setDbValue($rs->fields('rsano'));
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
		$this->property_location->DbValue = $row['property_location'];
		$this->property_type->DbValue = $row['property_type'];
		$this->property_registered->DbValue = $row['property_registered'];
		$this->shares_company->DbValue = $row['shares_company'];
		$this->shares_volume->DbValue = $row['shares_volume'];
		$this->shares_percent->DbValue = $row['shares_percent'];
		$this->shares_cscs->DbValue = $row['shares_cscs'];
		$this->shares_chn->DbValue = $row['shares_chn'];
		$this->insurance_company->DbValue = $row['insurance_company'];
		$this->insurance_type->DbValue = $row['insurance_type'];
		$this->insurance_owner->DbValue = $row['insurance_owner'];
		$this->insurance_facevalue->DbValue = $row['insurance_facevalue'];
		$this->bvn->DbValue = $row['bvn'];
		$this->account_name->DbValue = $row['account_name'];
		$this->account_no->DbValue = $row['account_no'];
		$this->bankname->DbValue = $row['bankname'];
		$this->accounttype->DbValue = $row['accounttype'];
		$this->pension_name->DbValue = $row['pension_name'];
		$this->pension_owner->DbValue = $row['pension_owner'];
		$this->pension_plan->DbValue = $row['pension_plan'];
		$this->rsano->DbValue = $row['rsano'];
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
		// property_location
		// property_type
		// property_registered
		// shares_company
		// shares_volume
		// shares_percent
		// shares_cscs
		// shares_chn
		// insurance_company
		// insurance_type
		// insurance_owner
		// insurance_facevalue
		// bvn
		// account_name
		// account_no
		// bankname
		// accounttype
		// pension_name
		// pension_owner
		// pension_plan
		// rsano
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

			// property_location
			$this->property_location->ViewValue = $this->property_location->CurrentValue;
			$this->property_location->ViewCustomAttributes = "";

			// property_type
			$this->property_type->ViewValue = $this->property_type->CurrentValue;
			$this->property_type->ViewCustomAttributes = "";

			// property_registered
			$this->property_registered->ViewValue = $this->property_registered->CurrentValue;
			$this->property_registered->ViewCustomAttributes = "";

			// shares_company
			$this->shares_company->ViewValue = $this->shares_company->CurrentValue;
			$this->shares_company->ViewCustomAttributes = "";

			// shares_volume
			$this->shares_volume->ViewValue = $this->shares_volume->CurrentValue;
			$this->shares_volume->ViewCustomAttributes = "";

			// shares_percent
			$this->shares_percent->ViewValue = $this->shares_percent->CurrentValue;
			$this->shares_percent->ViewCustomAttributes = "";

			// shares_cscs
			$this->shares_cscs->ViewValue = $this->shares_cscs->CurrentValue;
			$this->shares_cscs->ViewCustomAttributes = "";

			// shares_chn
			$this->shares_chn->ViewValue = $this->shares_chn->CurrentValue;
			$this->shares_chn->ViewCustomAttributes = "";

			// insurance_company
			$this->insurance_company->ViewValue = $this->insurance_company->CurrentValue;
			$this->insurance_company->ViewCustomAttributes = "";

			// insurance_type
			$this->insurance_type->ViewValue = $this->insurance_type->CurrentValue;
			$this->insurance_type->ViewCustomAttributes = "";

			// insurance_owner
			$this->insurance_owner->ViewValue = $this->insurance_owner->CurrentValue;
			$this->insurance_owner->ViewCustomAttributes = "";

			// insurance_facevalue
			$this->insurance_facevalue->ViewValue = $this->insurance_facevalue->CurrentValue;
			$this->insurance_facevalue->ViewCustomAttributes = "";

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

			// pension_name
			$this->pension_name->ViewValue = $this->pension_name->CurrentValue;
			$this->pension_name->ViewCustomAttributes = "";

			// pension_owner
			$this->pension_owner->ViewValue = $this->pension_owner->CurrentValue;
			$this->pension_owner->ViewCustomAttributes = "";

			// pension_plan
			$this->pension_plan->ViewValue = $this->pension_plan->CurrentValue;
			$this->pension_plan->ViewCustomAttributes = "";

			// rsano
			$this->rsano->ViewValue = $this->rsano->CurrentValue;
			$this->rsano->ViewCustomAttributes = "";

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

			// property_location
			$this->property_location->LinkCustomAttributes = "";
			$this->property_location->HrefValue = "";
			$this->property_location->TooltipValue = "";

			// property_type
			$this->property_type->LinkCustomAttributes = "";
			$this->property_type->HrefValue = "";
			$this->property_type->TooltipValue = "";

			// property_registered
			$this->property_registered->LinkCustomAttributes = "";
			$this->property_registered->HrefValue = "";
			$this->property_registered->TooltipValue = "";

			// shares_company
			$this->shares_company->LinkCustomAttributes = "";
			$this->shares_company->HrefValue = "";
			$this->shares_company->TooltipValue = "";

			// shares_volume
			$this->shares_volume->LinkCustomAttributes = "";
			$this->shares_volume->HrefValue = "";
			$this->shares_volume->TooltipValue = "";

			// shares_percent
			$this->shares_percent->LinkCustomAttributes = "";
			$this->shares_percent->HrefValue = "";
			$this->shares_percent->TooltipValue = "";

			// shares_cscs
			$this->shares_cscs->LinkCustomAttributes = "";
			$this->shares_cscs->HrefValue = "";
			$this->shares_cscs->TooltipValue = "";

			// shares_chn
			$this->shares_chn->LinkCustomAttributes = "";
			$this->shares_chn->HrefValue = "";
			$this->shares_chn->TooltipValue = "";

			// insurance_company
			$this->insurance_company->LinkCustomAttributes = "";
			$this->insurance_company->HrefValue = "";
			$this->insurance_company->TooltipValue = "";

			// insurance_type
			$this->insurance_type->LinkCustomAttributes = "";
			$this->insurance_type->HrefValue = "";
			$this->insurance_type->TooltipValue = "";

			// insurance_owner
			$this->insurance_owner->LinkCustomAttributes = "";
			$this->insurance_owner->HrefValue = "";
			$this->insurance_owner->TooltipValue = "";

			// insurance_facevalue
			$this->insurance_facevalue->LinkCustomAttributes = "";
			$this->insurance_facevalue->HrefValue = "";
			$this->insurance_facevalue->TooltipValue = "";

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

			// pension_name
			$this->pension_name->LinkCustomAttributes = "";
			$this->pension_name->HrefValue = "";
			$this->pension_name->TooltipValue = "";

			// pension_owner
			$this->pension_owner->LinkCustomAttributes = "";
			$this->pension_owner->HrefValue = "";
			$this->pension_owner->TooltipValue = "";

			// pension_plan
			$this->pension_plan->LinkCustomAttributes = "";
			$this->pension_plan->HrefValue = "";
			$this->pension_plan->TooltipValue = "";

			// rsano
			$this->rsano->LinkCustomAttributes = "";
			$this->rsano->HrefValue = "";
			$this->rsano->TooltipValue = "";

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

			// property_location
			$this->property_location->EditCustomAttributes = "";
			$this->property_location->EditValue = $this->property_location->CurrentValue;
			$this->property_location->PlaceHolder = ew_HtmlEncode(ew_RemoveHtml($this->property_location->FldCaption()));

			// property_type
			$this->property_type->EditCustomAttributes = "";
			$this->property_type->EditValue = $this->property_type->CurrentValue;
			$this->property_type->PlaceHolder = ew_HtmlEncode(ew_RemoveHtml($this->property_type->FldCaption()));

			// property_registered
			$this->property_registered->EditCustomAttributes = "";
			$this->property_registered->EditValue = $this->property_registered->CurrentValue;
			$this->property_registered->PlaceHolder = ew_HtmlEncode(ew_RemoveHtml($this->property_registered->FldCaption()));

			// shares_company
			$this->shares_company->EditCustomAttributes = "";
			$this->shares_company->EditValue = $this->shares_company->CurrentValue;
			$this->shares_company->PlaceHolder = ew_HtmlEncode(ew_RemoveHtml($this->shares_company->FldCaption()));

			// shares_volume
			$this->shares_volume->EditCustomAttributes = "";
			$this->shares_volume->EditValue = $this->shares_volume->CurrentValue;
			$this->shares_volume->PlaceHolder = ew_HtmlEncode(ew_RemoveHtml($this->shares_volume->FldCaption()));

			// shares_percent
			$this->shares_percent->EditCustomAttributes = "";
			$this->shares_percent->EditValue = $this->shares_percent->CurrentValue;
			$this->shares_percent->PlaceHolder = ew_HtmlEncode(ew_RemoveHtml($this->shares_percent->FldCaption()));

			// shares_cscs
			$this->shares_cscs->EditCustomAttributes = "";
			$this->shares_cscs->EditValue = $this->shares_cscs->CurrentValue;
			$this->shares_cscs->PlaceHolder = ew_HtmlEncode(ew_RemoveHtml($this->shares_cscs->FldCaption()));

			// shares_chn
			$this->shares_chn->EditCustomAttributes = "";
			$this->shares_chn->EditValue = ew_HtmlEncode($this->shares_chn->CurrentValue);
			$this->shares_chn->PlaceHolder = ew_HtmlEncode(ew_RemoveHtml($this->shares_chn->FldCaption()));

			// insurance_company
			$this->insurance_company->EditCustomAttributes = "";
			$this->insurance_company->EditValue = $this->insurance_company->CurrentValue;
			$this->insurance_company->PlaceHolder = ew_HtmlEncode(ew_RemoveHtml($this->insurance_company->FldCaption()));

			// insurance_type
			$this->insurance_type->EditCustomAttributes = "";
			$this->insurance_type->EditValue = $this->insurance_type->CurrentValue;
			$this->insurance_type->PlaceHolder = ew_HtmlEncode(ew_RemoveHtml($this->insurance_type->FldCaption()));

			// insurance_owner
			$this->insurance_owner->EditCustomAttributes = "";
			$this->insurance_owner->EditValue = $this->insurance_owner->CurrentValue;
			$this->insurance_owner->PlaceHolder = ew_HtmlEncode(ew_RemoveHtml($this->insurance_owner->FldCaption()));

			// insurance_facevalue
			$this->insurance_facevalue->EditCustomAttributes = "";
			$this->insurance_facevalue->EditValue = $this->insurance_facevalue->CurrentValue;
			$this->insurance_facevalue->PlaceHolder = ew_HtmlEncode(ew_RemoveHtml($this->insurance_facevalue->FldCaption()));

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

			// pension_name
			$this->pension_name->EditCustomAttributes = "";
			$this->pension_name->EditValue = $this->pension_name->CurrentValue;
			$this->pension_name->PlaceHolder = ew_HtmlEncode(ew_RemoveHtml($this->pension_name->FldCaption()));

			// pension_owner
			$this->pension_owner->EditCustomAttributes = "";
			$this->pension_owner->EditValue = $this->pension_owner->CurrentValue;
			$this->pension_owner->PlaceHolder = ew_HtmlEncode(ew_RemoveHtml($this->pension_owner->FldCaption()));

			// pension_plan
			$this->pension_plan->EditCustomAttributes = "";
			$this->pension_plan->EditValue = $this->pension_plan->CurrentValue;
			$this->pension_plan->PlaceHolder = ew_HtmlEncode(ew_RemoveHtml($this->pension_plan->FldCaption()));

			// rsano
			$this->rsano->EditCustomAttributes = "";
			$this->rsano->EditValue = $this->rsano->CurrentValue;
			$this->rsano->PlaceHolder = ew_HtmlEncode(ew_RemoveHtml($this->rsano->FldCaption()));

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

			// property_location
			$this->property_location->HrefValue = "";

			// property_type
			$this->property_type->HrefValue = "";

			// property_registered
			$this->property_registered->HrefValue = "";

			// shares_company
			$this->shares_company->HrefValue = "";

			// shares_volume
			$this->shares_volume->HrefValue = "";

			// shares_percent
			$this->shares_percent->HrefValue = "";

			// shares_cscs
			$this->shares_cscs->HrefValue = "";

			// shares_chn
			$this->shares_chn->HrefValue = "";

			// insurance_company
			$this->insurance_company->HrefValue = "";

			// insurance_type
			$this->insurance_type->HrefValue = "";

			// insurance_owner
			$this->insurance_owner->HrefValue = "";

			// insurance_facevalue
			$this->insurance_facevalue->HrefValue = "";

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

			// pension_name
			$this->pension_name->HrefValue = "";

			// pension_owner
			$this->pension_owner->HrefValue = "";

			// pension_plan
			$this->pension_plan->HrefValue = "";

			// rsano
			$this->rsano->HrefValue = "";

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
		if (in_array("overall_asset", $DetailTblVar) && $GLOBALS["overall_asset"]->DetailAdd) {
			if (!isset($GLOBALS["overall_asset_grid"])) $GLOBALS["overall_asset_grid"] = new coverall_asset_grid(); // get detail page object
			$GLOBALS["overall_asset_grid"]->ValidateGridForm();
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

		// Check referential integrity for master table 'comprehensivewill_tb'
		$bValidMasterRecord = TRUE;
		$sMasterFilter = $this->SqlMasterFilter_comprehensivewill_tb();
		if (strval($this->uid->CurrentValue) <> "") {
			$sMasterFilter = str_replace("@uid@", ew_AdjustSql($this->uid->CurrentValue), $sMasterFilter);
		} else {
			$bValidMasterRecord = FALSE;
		}
		if ($bValidMasterRecord) {
			$rsmaster = $GLOBALS["comprehensivewill_tb"]->LoadRs($sMasterFilter);
			$bValidMasterRecord = ($rsmaster && !$rsmaster->EOF);
			$rsmaster->Close();
		}
		if (!$bValidMasterRecord) {
			$sRelatedRecordMsg = str_replace("%t", "comprehensivewill_tb", $Language->Phrase("RelatedRecordRequired"));
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

		// property_location
		$this->property_location->SetDbValueDef($rsnew, $this->property_location->CurrentValue, NULL, FALSE);

		// property_type
		$this->property_type->SetDbValueDef($rsnew, $this->property_type->CurrentValue, NULL, FALSE);

		// property_registered
		$this->property_registered->SetDbValueDef($rsnew, $this->property_registered->CurrentValue, NULL, FALSE);

		// shares_company
		$this->shares_company->SetDbValueDef($rsnew, $this->shares_company->CurrentValue, NULL, FALSE);

		// shares_volume
		$this->shares_volume->SetDbValueDef($rsnew, $this->shares_volume->CurrentValue, NULL, FALSE);

		// shares_percent
		$this->shares_percent->SetDbValueDef($rsnew, $this->shares_percent->CurrentValue, NULL, FALSE);

		// shares_cscs
		$this->shares_cscs->SetDbValueDef($rsnew, $this->shares_cscs->CurrentValue, NULL, FALSE);

		// shares_chn
		$this->shares_chn->SetDbValueDef($rsnew, $this->shares_chn->CurrentValue, NULL, FALSE);

		// insurance_company
		$this->insurance_company->SetDbValueDef($rsnew, $this->insurance_company->CurrentValue, NULL, FALSE);

		// insurance_type
		$this->insurance_type->SetDbValueDef($rsnew, $this->insurance_type->CurrentValue, NULL, FALSE);

		// insurance_owner
		$this->insurance_owner->SetDbValueDef($rsnew, $this->insurance_owner->CurrentValue, NULL, FALSE);

		// insurance_facevalue
		$this->insurance_facevalue->SetDbValueDef($rsnew, $this->insurance_facevalue->CurrentValue, NULL, FALSE);

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

		// pension_name
		$this->pension_name->SetDbValueDef($rsnew, $this->pension_name->CurrentValue, NULL, FALSE);

		// pension_owner
		$this->pension_owner->SetDbValueDef($rsnew, $this->pension_owner->CurrentValue, NULL, FALSE);

		// pension_plan
		$this->pension_plan->SetDbValueDef($rsnew, $this->pension_plan->CurrentValue, NULL, FALSE);

		// rsano
		$this->rsano->SetDbValueDef($rsnew, $this->rsano->CurrentValue, NULL, FALSE);

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
			if (in_array("overall_asset", $DetailTblVar) && $GLOBALS["overall_asset"]->DetailAdd) {
				$GLOBALS["overall_asset"]->uid->setSessionValue($this->uid->CurrentValue); // Set master key
				if (!isset($GLOBALS["overall_asset_grid"])) $GLOBALS["overall_asset_grid"] = new coverall_asset_grid(); // Get detail page object
				$AddRow = $GLOBALS["overall_asset_grid"]->GridInsert();
				if (!$AddRow)
					$GLOBALS["overall_asset"]->uid->setSessionValue(""); // Clear master key if insert failed
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
			if ($sMasterTblVar == "beneficiary_dump") {
				$bValidMaster = TRUE;
				if (@$_GET["uid"] <> "") {
					$GLOBALS["beneficiary_dump"]->uid->setQueryStringValue($_GET["uid"]);
					$this->uid->setQueryStringValue($GLOBALS["beneficiary_dump"]->uid->QueryStringValue);
					$this->uid->setSessionValue($this->uid->QueryStringValue);
					if (!is_numeric($GLOBALS["beneficiary_dump"]->uid->QueryStringValue)) $bValidMaster = FALSE;
				} else {
					$bValidMaster = FALSE;
				}
			}
			if ($sMasterTblVar == "comprehensivewill_tb") {
				$bValidMaster = TRUE;
				if (@$_GET["uid"] <> "") {
					$GLOBALS["comprehensivewill_tb"]->uid->setQueryStringValue($_GET["uid"]);
					$this->uid->setQueryStringValue($GLOBALS["comprehensivewill_tb"]->uid->QueryStringValue);
					$this->uid->setSessionValue($this->uid->QueryStringValue);
					if (!is_numeric($GLOBALS["comprehensivewill_tb"]->uid->QueryStringValue)) $bValidMaster = FALSE;
				} else {
					$bValidMaster = FALSE;
				}
			}
			if ($sMasterTblVar == "premiumwill_tb") {
				$bValidMaster = TRUE;
				if (@$_GET["uid"] <> "") {
					$GLOBALS["premiumwill_tb"]->uid->setQueryStringValue($_GET["uid"]);
					$this->uid->setQueryStringValue($GLOBALS["premiumwill_tb"]->uid->QueryStringValue);
					$this->uid->setSessionValue($this->uid->QueryStringValue);
					if (!is_numeric($GLOBALS["premiumwill_tb"]->uid->QueryStringValue)) $bValidMaster = FALSE;
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
			if ($sMasterTblVar == "privatetrust_tb") {
				$bValidMaster = TRUE;
				if (@$_GET["uid"] <> "") {
					$GLOBALS["privatetrust_tb"]->uid->setQueryStringValue($_GET["uid"]);
					$this->uid->setQueryStringValue($GLOBALS["privatetrust_tb"]->uid->QueryStringValue);
					$this->uid->setSessionValue($this->uid->QueryStringValue);
					if (!is_numeric($GLOBALS["privatetrust_tb"]->uid->QueryStringValue)) $bValidMaster = FALSE;
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
			if ($sMasterTblVar <> "beneficiary_dump") {
				if ($this->uid->QueryStringValue == "") $this->uid->setSessionValue("");
			}
			if ($sMasterTblVar <> "comprehensivewill_tb") {
				if ($this->uid->QueryStringValue == "") $this->uid->setSessionValue("");
			}
			if ($sMasterTblVar <> "premiumwill_tb") {
				if ($this->uid->QueryStringValue == "") $this->uid->setSessionValue("");
			}
			if ($sMasterTblVar <> "personal_info") {
				if ($this->uid->QueryStringValue == "") $this->uid->setSessionValue("");
			}
			if ($sMasterTblVar <> "privatetrust_tb") {
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
			if (in_array("overall_asset", $DetailTblVar)) {
				if (!isset($GLOBALS["overall_asset_grid"]))
					$GLOBALS["overall_asset_grid"] = new coverall_asset_grid;
				if ($GLOBALS["overall_asset_grid"]->DetailAdd) {
					if ($this->CopyRecord)
						$GLOBALS["overall_asset_grid"]->CurrentMode = "copy";
					else
						$GLOBALS["overall_asset_grid"]->CurrentMode = "add";
					$GLOBALS["overall_asset_grid"]->CurrentAction = "gridadd";

					// Save current master table to detail table
					$GLOBALS["overall_asset_grid"]->setCurrentMasterTable($this->TableVar);
					$GLOBALS["overall_asset_grid"]->setStartRecordNumber(1);
					$GLOBALS["overall_asset_grid"]->uid->FldIsDetailKey = TRUE;
					$GLOBALS["overall_asset_grid"]->uid->CurrentValue = $this->uid->CurrentValue;
					$GLOBALS["overall_asset_grid"]->uid->setSessionValue($GLOBALS["overall_asset_grid"]->uid->CurrentValue);
				}
			}
		}
	}

	// Set up Breadcrumb
	function SetupBreadcrumb() {
		global $Breadcrumb, $Language;
		$Breadcrumb = new cBreadcrumb();
		$PageCaption = $this->TableCaption();
		$Breadcrumb->Add("list", "<span id=\"ewPageCaption\">" . $PageCaption . "</span>", "assets_tblist.php", $this->TableVar);
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
if (!isset($assets_tb_add)) $assets_tb_add = new cassets_tb_add();

// Page init
$assets_tb_add->Page_Init();

// Page main
$assets_tb_add->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$assets_tb_add->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Page object
var assets_tb_add = new ew_Page("assets_tb_add");
assets_tb_add.PageID = "add"; // Page ID
var EW_PAGE_ID = assets_tb_add.PageID; // For backward compatibility

// Form object
var fassets_tbadd = new ew_Form("fassets_tbadd");

// Validate form
fassets_tbadd.Validate = function() {
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
				return this.OnError(elm, ewLanguage.Phrase("EnterRequiredField") + " - <?php echo ew_JsEncode2($assets_tb->uid->FldCaption()) ?>");
			elm = this.GetElements("x" + infix + "_uid");
			if (elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($assets_tb->uid->FldErrMsg()) ?>");

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
fassets_tbadd.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
fassets_tbadd.ValidateRequired = true;
<?php } else { ?>
fassets_tbadd.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
// Form object for search

</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<?php $Breadcrumb->Render(); ?>
<?php $assets_tb_add->ShowPageHeader(); ?>
<?php
$assets_tb_add->ShowMessage();
?>
<form name="fassets_tbadd" id="fassets_tbadd" class="ewForm form-horizontal" action="<?php echo ew_CurrentPage() ?>" method="post">
<input type="hidden" name="t" value="assets_tb">
<input type="hidden" name="a_add" id="a_add" value="A">
<table cellspacing="0" class="ewGrid"><tr><td>
<table id="tbl_assets_tbadd" class="table table-bordered table-striped">
<?php if ($assets_tb->uid->Visible) { // uid ?>
	<tr id="r_uid">
		<td><span id="elh_assets_tb_uid"><?php echo $assets_tb->uid->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></span></td>
		<td<?php echo $assets_tb->uid->CellAttributes() ?>>
<?php if ($assets_tb->uid->getSessionValue() <> "") { ?>
<span<?php echo $assets_tb->uid->ViewAttributes() ?>>
<?php echo $assets_tb->uid->ViewValue ?></span>
<input type="hidden" id="x_uid" name="x_uid" value="<?php echo ew_HtmlEncode($assets_tb->uid->CurrentValue) ?>">
<?php } else { ?>
<input type="text" data-field="x_uid" name="x_uid" id="x_uid" size="30" placeholder="<?php echo $assets_tb->uid->PlaceHolder ?>" value="<?php echo $assets_tb->uid->EditValue ?>"<?php echo $assets_tb->uid->EditAttributes() ?>>
<?php } ?>
<?php echo $assets_tb->uid->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($assets_tb->asset_type->Visible) { // asset_type ?>
	<tr id="r_asset_type">
		<td><span id="elh_assets_tb_asset_type"><?php echo $assets_tb->asset_type->FldCaption() ?></span></td>
		<td<?php echo $assets_tb->asset_type->CellAttributes() ?>>
<span id="el_assets_tb_asset_type" class="control-group">
<textarea data-field="x_asset_type" name="x_asset_type" id="x_asset_type" cols="35" rows="4" placeholder="<?php echo $assets_tb->asset_type->PlaceHolder ?>"<?php echo $assets_tb->asset_type->EditAttributes() ?>><?php echo $assets_tb->asset_type->EditValue ?></textarea>
</span>
<?php echo $assets_tb->asset_type->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($assets_tb->property_location->Visible) { // property_location ?>
	<tr id="r_property_location">
		<td><span id="elh_assets_tb_property_location"><?php echo $assets_tb->property_location->FldCaption() ?></span></td>
		<td<?php echo $assets_tb->property_location->CellAttributes() ?>>
<span id="el_assets_tb_property_location" class="control-group">
<textarea data-field="x_property_location" name="x_property_location" id="x_property_location" cols="35" rows="4" placeholder="<?php echo $assets_tb->property_location->PlaceHolder ?>"<?php echo $assets_tb->property_location->EditAttributes() ?>><?php echo $assets_tb->property_location->EditValue ?></textarea>
</span>
<?php echo $assets_tb->property_location->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($assets_tb->property_type->Visible) { // property_type ?>
	<tr id="r_property_type">
		<td><span id="elh_assets_tb_property_type"><?php echo $assets_tb->property_type->FldCaption() ?></span></td>
		<td<?php echo $assets_tb->property_type->CellAttributes() ?>>
<span id="el_assets_tb_property_type" class="control-group">
<textarea data-field="x_property_type" name="x_property_type" id="x_property_type" cols="35" rows="4" placeholder="<?php echo $assets_tb->property_type->PlaceHolder ?>"<?php echo $assets_tb->property_type->EditAttributes() ?>><?php echo $assets_tb->property_type->EditValue ?></textarea>
</span>
<?php echo $assets_tb->property_type->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($assets_tb->property_registered->Visible) { // property_registered ?>
	<tr id="r_property_registered">
		<td><span id="elh_assets_tb_property_registered"><?php echo $assets_tb->property_registered->FldCaption() ?></span></td>
		<td<?php echo $assets_tb->property_registered->CellAttributes() ?>>
<span id="el_assets_tb_property_registered" class="control-group">
<textarea data-field="x_property_registered" name="x_property_registered" id="x_property_registered" cols="35" rows="4" placeholder="<?php echo $assets_tb->property_registered->PlaceHolder ?>"<?php echo $assets_tb->property_registered->EditAttributes() ?>><?php echo $assets_tb->property_registered->EditValue ?></textarea>
</span>
<?php echo $assets_tb->property_registered->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($assets_tb->shares_company->Visible) { // shares_company ?>
	<tr id="r_shares_company">
		<td><span id="elh_assets_tb_shares_company"><?php echo $assets_tb->shares_company->FldCaption() ?></span></td>
		<td<?php echo $assets_tb->shares_company->CellAttributes() ?>>
<span id="el_assets_tb_shares_company" class="control-group">
<textarea data-field="x_shares_company" name="x_shares_company" id="x_shares_company" cols="35" rows="4" placeholder="<?php echo $assets_tb->shares_company->PlaceHolder ?>"<?php echo $assets_tb->shares_company->EditAttributes() ?>><?php echo $assets_tb->shares_company->EditValue ?></textarea>
</span>
<?php echo $assets_tb->shares_company->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($assets_tb->shares_volume->Visible) { // shares_volume ?>
	<tr id="r_shares_volume">
		<td><span id="elh_assets_tb_shares_volume"><?php echo $assets_tb->shares_volume->FldCaption() ?></span></td>
		<td<?php echo $assets_tb->shares_volume->CellAttributes() ?>>
<span id="el_assets_tb_shares_volume" class="control-group">
<textarea data-field="x_shares_volume" name="x_shares_volume" id="x_shares_volume" cols="35" rows="4" placeholder="<?php echo $assets_tb->shares_volume->PlaceHolder ?>"<?php echo $assets_tb->shares_volume->EditAttributes() ?>><?php echo $assets_tb->shares_volume->EditValue ?></textarea>
</span>
<?php echo $assets_tb->shares_volume->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($assets_tb->shares_percent->Visible) { // shares_percent ?>
	<tr id="r_shares_percent">
		<td><span id="elh_assets_tb_shares_percent"><?php echo $assets_tb->shares_percent->FldCaption() ?></span></td>
		<td<?php echo $assets_tb->shares_percent->CellAttributes() ?>>
<span id="el_assets_tb_shares_percent" class="control-group">
<textarea data-field="x_shares_percent" name="x_shares_percent" id="x_shares_percent" cols="35" rows="4" placeholder="<?php echo $assets_tb->shares_percent->PlaceHolder ?>"<?php echo $assets_tb->shares_percent->EditAttributes() ?>><?php echo $assets_tb->shares_percent->EditValue ?></textarea>
</span>
<?php echo $assets_tb->shares_percent->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($assets_tb->shares_cscs->Visible) { // shares_cscs ?>
	<tr id="r_shares_cscs">
		<td><span id="elh_assets_tb_shares_cscs"><?php echo $assets_tb->shares_cscs->FldCaption() ?></span></td>
		<td<?php echo $assets_tb->shares_cscs->CellAttributes() ?>>
<span id="el_assets_tb_shares_cscs" class="control-group">
<textarea data-field="x_shares_cscs" name="x_shares_cscs" id="x_shares_cscs" cols="35" rows="4" placeholder="<?php echo $assets_tb->shares_cscs->PlaceHolder ?>"<?php echo $assets_tb->shares_cscs->EditAttributes() ?>><?php echo $assets_tb->shares_cscs->EditValue ?></textarea>
</span>
<?php echo $assets_tb->shares_cscs->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($assets_tb->shares_chn->Visible) { // shares_chn ?>
	<tr id="r_shares_chn">
		<td><span id="elh_assets_tb_shares_chn"><?php echo $assets_tb->shares_chn->FldCaption() ?></span></td>
		<td<?php echo $assets_tb->shares_chn->CellAttributes() ?>>
<span id="el_assets_tb_shares_chn" class="control-group">
<input type="text" data-field="x_shares_chn" name="x_shares_chn" id="x_shares_chn" size="30" maxlength="100" placeholder="<?php echo $assets_tb->shares_chn->PlaceHolder ?>" value="<?php echo $assets_tb->shares_chn->EditValue ?>"<?php echo $assets_tb->shares_chn->EditAttributes() ?>>
</span>
<?php echo $assets_tb->shares_chn->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($assets_tb->insurance_company->Visible) { // insurance_company ?>
	<tr id="r_insurance_company">
		<td><span id="elh_assets_tb_insurance_company"><?php echo $assets_tb->insurance_company->FldCaption() ?></span></td>
		<td<?php echo $assets_tb->insurance_company->CellAttributes() ?>>
<span id="el_assets_tb_insurance_company" class="control-group">
<textarea data-field="x_insurance_company" name="x_insurance_company" id="x_insurance_company" cols="35" rows="4" placeholder="<?php echo $assets_tb->insurance_company->PlaceHolder ?>"<?php echo $assets_tb->insurance_company->EditAttributes() ?>><?php echo $assets_tb->insurance_company->EditValue ?></textarea>
</span>
<?php echo $assets_tb->insurance_company->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($assets_tb->insurance_type->Visible) { // insurance_type ?>
	<tr id="r_insurance_type">
		<td><span id="elh_assets_tb_insurance_type"><?php echo $assets_tb->insurance_type->FldCaption() ?></span></td>
		<td<?php echo $assets_tb->insurance_type->CellAttributes() ?>>
<span id="el_assets_tb_insurance_type" class="control-group">
<textarea data-field="x_insurance_type" name="x_insurance_type" id="x_insurance_type" cols="35" rows="4" placeholder="<?php echo $assets_tb->insurance_type->PlaceHolder ?>"<?php echo $assets_tb->insurance_type->EditAttributes() ?>><?php echo $assets_tb->insurance_type->EditValue ?></textarea>
</span>
<?php echo $assets_tb->insurance_type->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($assets_tb->insurance_owner->Visible) { // insurance_owner ?>
	<tr id="r_insurance_owner">
		<td><span id="elh_assets_tb_insurance_owner"><?php echo $assets_tb->insurance_owner->FldCaption() ?></span></td>
		<td<?php echo $assets_tb->insurance_owner->CellAttributes() ?>>
<span id="el_assets_tb_insurance_owner" class="control-group">
<textarea data-field="x_insurance_owner" name="x_insurance_owner" id="x_insurance_owner" cols="35" rows="4" placeholder="<?php echo $assets_tb->insurance_owner->PlaceHolder ?>"<?php echo $assets_tb->insurance_owner->EditAttributes() ?>><?php echo $assets_tb->insurance_owner->EditValue ?></textarea>
</span>
<?php echo $assets_tb->insurance_owner->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($assets_tb->insurance_facevalue->Visible) { // insurance_facevalue ?>
	<tr id="r_insurance_facevalue">
		<td><span id="elh_assets_tb_insurance_facevalue"><?php echo $assets_tb->insurance_facevalue->FldCaption() ?></span></td>
		<td<?php echo $assets_tb->insurance_facevalue->CellAttributes() ?>>
<span id="el_assets_tb_insurance_facevalue" class="control-group">
<textarea data-field="x_insurance_facevalue" name="x_insurance_facevalue" id="x_insurance_facevalue" cols="35" rows="4" placeholder="<?php echo $assets_tb->insurance_facevalue->PlaceHolder ?>"<?php echo $assets_tb->insurance_facevalue->EditAttributes() ?>><?php echo $assets_tb->insurance_facevalue->EditValue ?></textarea>
</span>
<?php echo $assets_tb->insurance_facevalue->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($assets_tb->bvn->Visible) { // bvn ?>
	<tr id="r_bvn">
		<td><span id="elh_assets_tb_bvn"><?php echo $assets_tb->bvn->FldCaption() ?></span></td>
		<td<?php echo $assets_tb->bvn->CellAttributes() ?>>
<span id="el_assets_tb_bvn" class="control-group">
<textarea data-field="x_bvn" name="x_bvn" id="x_bvn" cols="35" rows="4" placeholder="<?php echo $assets_tb->bvn->PlaceHolder ?>"<?php echo $assets_tb->bvn->EditAttributes() ?>><?php echo $assets_tb->bvn->EditValue ?></textarea>
</span>
<?php echo $assets_tb->bvn->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($assets_tb->account_name->Visible) { // account_name ?>
	<tr id="r_account_name">
		<td><span id="elh_assets_tb_account_name"><?php echo $assets_tb->account_name->FldCaption() ?></span></td>
		<td<?php echo $assets_tb->account_name->CellAttributes() ?>>
<span id="el_assets_tb_account_name" class="control-group">
<textarea data-field="x_account_name" name="x_account_name" id="x_account_name" cols="35" rows="4" placeholder="<?php echo $assets_tb->account_name->PlaceHolder ?>"<?php echo $assets_tb->account_name->EditAttributes() ?>><?php echo $assets_tb->account_name->EditValue ?></textarea>
</span>
<?php echo $assets_tb->account_name->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($assets_tb->account_no->Visible) { // account_no ?>
	<tr id="r_account_no">
		<td><span id="elh_assets_tb_account_no"><?php echo $assets_tb->account_no->FldCaption() ?></span></td>
		<td<?php echo $assets_tb->account_no->CellAttributes() ?>>
<span id="el_assets_tb_account_no" class="control-group">
<textarea data-field="x_account_no" name="x_account_no" id="x_account_no" cols="35" rows="4" placeholder="<?php echo $assets_tb->account_no->PlaceHolder ?>"<?php echo $assets_tb->account_no->EditAttributes() ?>><?php echo $assets_tb->account_no->EditValue ?></textarea>
</span>
<?php echo $assets_tb->account_no->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($assets_tb->bankname->Visible) { // bankname ?>
	<tr id="r_bankname">
		<td><span id="elh_assets_tb_bankname"><?php echo $assets_tb->bankname->FldCaption() ?></span></td>
		<td<?php echo $assets_tb->bankname->CellAttributes() ?>>
<span id="el_assets_tb_bankname" class="control-group">
<textarea data-field="x_bankname" name="x_bankname" id="x_bankname" cols="35" rows="4" placeholder="<?php echo $assets_tb->bankname->PlaceHolder ?>"<?php echo $assets_tb->bankname->EditAttributes() ?>><?php echo $assets_tb->bankname->EditValue ?></textarea>
</span>
<?php echo $assets_tb->bankname->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($assets_tb->accounttype->Visible) { // accounttype ?>
	<tr id="r_accounttype">
		<td><span id="elh_assets_tb_accounttype"><?php echo $assets_tb->accounttype->FldCaption() ?></span></td>
		<td<?php echo $assets_tb->accounttype->CellAttributes() ?>>
<span id="el_assets_tb_accounttype" class="control-group">
<textarea data-field="x_accounttype" name="x_accounttype" id="x_accounttype" cols="35" rows="4" placeholder="<?php echo $assets_tb->accounttype->PlaceHolder ?>"<?php echo $assets_tb->accounttype->EditAttributes() ?>><?php echo $assets_tb->accounttype->EditValue ?></textarea>
</span>
<?php echo $assets_tb->accounttype->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($assets_tb->pension_name->Visible) { // pension_name ?>
	<tr id="r_pension_name">
		<td><span id="elh_assets_tb_pension_name"><?php echo $assets_tb->pension_name->FldCaption() ?></span></td>
		<td<?php echo $assets_tb->pension_name->CellAttributes() ?>>
<span id="el_assets_tb_pension_name" class="control-group">
<textarea data-field="x_pension_name" name="x_pension_name" id="x_pension_name" cols="35" rows="4" placeholder="<?php echo $assets_tb->pension_name->PlaceHolder ?>"<?php echo $assets_tb->pension_name->EditAttributes() ?>><?php echo $assets_tb->pension_name->EditValue ?></textarea>
</span>
<?php echo $assets_tb->pension_name->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($assets_tb->pension_owner->Visible) { // pension_owner ?>
	<tr id="r_pension_owner">
		<td><span id="elh_assets_tb_pension_owner"><?php echo $assets_tb->pension_owner->FldCaption() ?></span></td>
		<td<?php echo $assets_tb->pension_owner->CellAttributes() ?>>
<span id="el_assets_tb_pension_owner" class="control-group">
<textarea data-field="x_pension_owner" name="x_pension_owner" id="x_pension_owner" cols="35" rows="4" placeholder="<?php echo $assets_tb->pension_owner->PlaceHolder ?>"<?php echo $assets_tb->pension_owner->EditAttributes() ?>><?php echo $assets_tb->pension_owner->EditValue ?></textarea>
</span>
<?php echo $assets_tb->pension_owner->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($assets_tb->pension_plan->Visible) { // pension_plan ?>
	<tr id="r_pension_plan">
		<td><span id="elh_assets_tb_pension_plan"><?php echo $assets_tb->pension_plan->FldCaption() ?></span></td>
		<td<?php echo $assets_tb->pension_plan->CellAttributes() ?>>
<span id="el_assets_tb_pension_plan" class="control-group">
<textarea data-field="x_pension_plan" name="x_pension_plan" id="x_pension_plan" cols="35" rows="4" placeholder="<?php echo $assets_tb->pension_plan->PlaceHolder ?>"<?php echo $assets_tb->pension_plan->EditAttributes() ?>><?php echo $assets_tb->pension_plan->EditValue ?></textarea>
</span>
<?php echo $assets_tb->pension_plan->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($assets_tb->rsano->Visible) { // rsano ?>
	<tr id="r_rsano">
		<td><span id="elh_assets_tb_rsano"><?php echo $assets_tb->rsano->FldCaption() ?></span></td>
		<td<?php echo $assets_tb->rsano->CellAttributes() ?>>
<span id="el_assets_tb_rsano" class="control-group">
<textarea data-field="x_rsano" name="x_rsano" id="x_rsano" cols="35" rows="4" placeholder="<?php echo $assets_tb->rsano->PlaceHolder ?>"<?php echo $assets_tb->rsano->EditAttributes() ?>><?php echo $assets_tb->rsano->EditValue ?></textarea>
</span>
<?php echo $assets_tb->rsano->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($assets_tb->pension_admin->Visible) { // pension_admin ?>
	<tr id="r_pension_admin">
		<td><span id="elh_assets_tb_pension_admin"><?php echo $assets_tb->pension_admin->FldCaption() ?></span></td>
		<td<?php echo $assets_tb->pension_admin->CellAttributes() ?>>
<span id="el_assets_tb_pension_admin" class="control-group">
<textarea data-field="x_pension_admin" name="x_pension_admin" id="x_pension_admin" cols="35" rows="4" placeholder="<?php echo $assets_tb->pension_admin->PlaceHolder ?>"<?php echo $assets_tb->pension_admin->EditAttributes() ?>><?php echo $assets_tb->pension_admin->EditValue ?></textarea>
</span>
<?php echo $assets_tb->pension_admin->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($assets_tb->datecreated->Visible) { // datecreated ?>
	<tr id="r_datecreated">
		<td><span id="elh_assets_tb_datecreated"><?php echo $assets_tb->datecreated->FldCaption() ?></span></td>
		<td<?php echo $assets_tb->datecreated->CellAttributes() ?>>
<span id="el_assets_tb_datecreated" class="control-group">
<input type="text" data-field="x_datecreated" name="x_datecreated" id="x_datecreated" placeholder="<?php echo $assets_tb->datecreated->PlaceHolder ?>" value="<?php echo $assets_tb->datecreated->EditValue ?>"<?php echo $assets_tb->datecreated->EditAttributes() ?>>
</span>
<?php echo $assets_tb->datecreated->CustomMsg ?></td>
	</tr>
<?php } ?>
</table>
</td></tr></table>
<?php
	if (in_array("overall_asset", explode(",", $assets_tb->getCurrentDetailTable())) && $overall_asset->DetailAdd) {
?>
<?php include_once "overall_assetgrid.php" ?>
<?php } ?>
<button class="btn btn-primary ewButton" name="btnAction" id="btnAction" type="submit"><?php echo $Language->Phrase("AddBtn") ?></button>
</form>
<script type="text/javascript">
fassets_tbadd.Init();
<?php if (EW_MOBILE_REFLOW && ew_IsMobile()) { ?>
ew_Reflow();
<?php } ?>
</script>
<?php
$assets_tb_add->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$assets_tb_add->Page_Terminate();
?>
