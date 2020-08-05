<?php
if (session_id() == "") session_start(); // Initialize Session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg10.php" ?>
<?php include_once "ewmysql10.php" ?>
<?php include_once "phpfn10.php" ?>
<?php include_once "photosinfo.php" ?>
<?php include_once "adminusersinfo.php" ?>
<?php include_once "userfn10.php" ?>
<?php

//
// Page class
//

$photos_add = NULL; // Initialize page object first

class cphotos_add extends cphotos {

	// Page ID
	var $PageID = 'add';

	// Project ID
	var $ProjectID = "{D9B361E7-B2C1-4293-B9B3-B581986A15CC}";

	// Table name
	var $TableName = 'photos';

	// Page object name
	var $PageObjName = 'photos_add';

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

		// Table object (photos)
		if (!isset($GLOBALS["photos"])) {
			$GLOBALS["photos"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["photos"];
		}

		// Table object (adminusers)
		if (!isset($GLOBALS['adminusers'])) $GLOBALS['adminusers'] = new cadminusers();

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'add', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'photos', TRUE);

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
					$this->Page_Terminate("photoslist.php"); // No matching record, return to list
				}
				break;
			case "A": // Add new record
				$this->SendEmail = TRUE; // Send email on add success
				if ($this->AddRow($this->OldRecordset)) { // Add successful
					if ($this->getSuccessMessage() == "")
						$this->setSuccessMessage($Language->Phrase("AddSuccess")); // Set up success message
					$sReturnUrl = $this->getReturnUrl();
					if (ew_GetPageName($sReturnUrl) == "photosview.php")
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
		$this->img->Upload->Index = $objForm->Index;
		if ($this->img->Upload->UploadFile()) {

			// No action required
		} else {
			echo $this->img->Upload->Message;
			$this->Page_Terminate();
			exit();
		}
		$this->img->CurrentValue = $this->img->Upload->FileName;
	}

	// Load default values
	function LoadDefaultValues() {
		$this->img->Upload->DbValue = NULL;
		$this->img->OldValue = $this->img->Upload->DbValue;
		$this->img->CurrentValue = NULL; // Clear file related field
		$this->cat->CurrentValue = NULL;
		$this->cat->OldValue = $this->cat->CurrentValue;
		$this->sub->CurrentValue = NULL;
		$this->sub->OldValue = $this->sub->CurrentValue;
		$this->title->CurrentValue = NULL;
		$this->title->OldValue = $this->title->CurrentValue;
		$this->descp->CurrentValue = NULL;
		$this->descp->OldValue = $this->descp->CurrentValue;
		$this->location->CurrentValue = NULL;
		$this->location->OldValue = $this->location->CurrentValue;
		$this->datetaken->CurrentValue = NULL;
		$this->datetaken->OldValue = $this->datetaken->CurrentValue;
		$this->tags->CurrentValue = NULL;
		$this->tags->OldValue = $this->tags->CurrentValue;
		$this->photoby->CurrentValue = NULL;
		$this->photoby->OldValue = $this->photoby->CurrentValue;
		$this->active->CurrentValue = "1";
		$this->featured->CurrentValue = "0";
		$this->rate_ord->CurrentValue = "0";
	}

	// Load form values
	function LoadFormValues() {

		// Load from form
		global $objForm;
		$this->GetUploadFiles(); // Get upload files
		if (!$this->cat->FldIsDetailKey) {
			$this->cat->setFormValue($objForm->GetValue("x_cat"));
		}
		if (!$this->sub->FldIsDetailKey) {
			$this->sub->setFormValue($objForm->GetValue("x_sub"));
		}
		if (!$this->title->FldIsDetailKey) {
			$this->title->setFormValue($objForm->GetValue("x_title"));
		}
		if (!$this->descp->FldIsDetailKey) {
			$this->descp->setFormValue($objForm->GetValue("x_descp"));
		}
		if (!$this->location->FldIsDetailKey) {
			$this->location->setFormValue($objForm->GetValue("x_location"));
		}
		if (!$this->datetaken->FldIsDetailKey) {
			$this->datetaken->setFormValue($objForm->GetValue("x_datetaken"));
			$this->datetaken->CurrentValue = ew_UnFormatDateTime($this->datetaken->CurrentValue, 0);
		}
		if (!$this->tags->FldIsDetailKey) {
			$this->tags->setFormValue($objForm->GetValue("x_tags"));
		}
		if (!$this->photoby->FldIsDetailKey) {
			$this->photoby->setFormValue($objForm->GetValue("x_photoby"));
		}
		if (!$this->active->FldIsDetailKey) {
			$this->active->setFormValue($objForm->GetValue("x_active"));
		}
		if (!$this->featured->FldIsDetailKey) {
			$this->featured->setFormValue($objForm->GetValue("x_featured"));
		}
		if (!$this->rate_ord->FldIsDetailKey) {
			$this->rate_ord->setFormValue($objForm->GetValue("x_rate_ord"));
		}
	}

	// Restore form values
	function RestoreFormValues() {
		global $objForm;
		$this->LoadOldRecord();
		$this->cat->CurrentValue = $this->cat->FormValue;
		$this->sub->CurrentValue = $this->sub->FormValue;
		$this->title->CurrentValue = $this->title->FormValue;
		$this->descp->CurrentValue = $this->descp->FormValue;
		$this->location->CurrentValue = $this->location->FormValue;
		$this->datetaken->CurrentValue = $this->datetaken->FormValue;
		$this->datetaken->CurrentValue = ew_UnFormatDateTime($this->datetaken->CurrentValue, 0);
		$this->tags->CurrentValue = $this->tags->FormValue;
		$this->photoby->CurrentValue = $this->photoby->FormValue;
		$this->active->CurrentValue = $this->active->FormValue;
		$this->featured->CurrentValue = $this->featured->FormValue;
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
		$this->img->Upload->DbValue = $rs->fields('img');
		$this->uid->setDbValue($rs->fields('uid'));
		$this->cat->setDbValue($rs->fields('cat'));
		$this->sub->setDbValue($rs->fields('sub'));
		$this->title->setDbValue($rs->fields('title'));
		$this->descp->setDbValue($rs->fields('descp'));
		$this->location->setDbValue($rs->fields('location'));
		$this->datetaken->setDbValue($rs->fields('datetaken'));
		$this->tags->setDbValue($rs->fields('tags'));
		$this->views->setDbValue($rs->fields('views'));
		$this->photoby->setDbValue($rs->fields('photoby'));
		$this->active->setDbValue($rs->fields('active'));
		$this->featured->setDbValue($rs->fields('featured'));
		$this->rate_ord->setDbValue($rs->fields('rate_ord'));
		$this->datep->setDbValue($rs->fields('datep'));
	}

	// Load DbValue from recordset
	function LoadDbValues(&$rs) {
		if (!$rs || !is_array($rs) && $rs->EOF) return;
		$row = is_array($rs) ? $rs : $rs->fields;
		$this->id->DbValue = $row['id'];
		$this->img->Upload->DbValue = $row['img'];
		$this->uid->DbValue = $row['uid'];
		$this->cat->DbValue = $row['cat'];
		$this->sub->DbValue = $row['sub'];
		$this->title->DbValue = $row['title'];
		$this->descp->DbValue = $row['descp'];
		$this->location->DbValue = $row['location'];
		$this->datetaken->DbValue = $row['datetaken'];
		$this->tags->DbValue = $row['tags'];
		$this->views->DbValue = $row['views'];
		$this->photoby->DbValue = $row['photoby'];
		$this->active->DbValue = $row['active'];
		$this->featured->DbValue = $row['featured'];
		$this->rate_ord->DbValue = $row['rate_ord'];
		$this->datep->DbValue = $row['datep'];
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
		// img
		// uid
		// cat
		// sub
		// title
		// descp
		// location
		// datetaken
		// tags
		// views
		// photoby
		// active
		// featured
		// rate_ord
		// datep

		if ($this->RowType == EW_ROWTYPE_VIEW) { // View row

			// id
			$this->id->ViewValue = $this->id->CurrentValue;
			$this->id->ViewCustomAttributes = "";

			// img
			$this->img->UploadPath = "../uploads/photos";
			if (!ew_Empty($this->img->Upload->DbValue)) {
				$this->img->ImageWidth = 50;
				$this->img->ImageHeight = 40;
				$this->img->ImageAlt = $this->img->FldAlt();
				$this->img->ViewValue = ew_UploadPathEx(FALSE, $this->img->UploadPath) . $this->img->Upload->DbValue;
			} else {
				$this->img->ViewValue = "";
			}
			$this->img->ViewCustomAttributes = "";

			// uid
			$this->uid->ViewValue = $this->uid->CurrentValue;
			$this->uid->ViewCustomAttributes = "";

			// cat
			if (strval($this->cat->CurrentValue) <> "") {
				$sFilterWrk = "`id`" . ew_SearchString("=", $this->cat->CurrentValue, EW_DATATYPE_NUMBER);
			$sSqlWrk = "SELECT `id`, `category` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `gallery_cats`";
			$sWhereWrk = "";
			if ($sFilterWrk <> "") {
				ew_AddFilter($sWhereWrk, $sFilterWrk);
			}

			// Call Lookup selecting
			$this->Lookup_Selecting($this->cat, $sWhereWrk);
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
				$rswrk = $conn->Execute($sSqlWrk);
				if ($rswrk && !$rswrk->EOF) { // Lookup values found
					$this->cat->ViewValue = $rswrk->fields('DispFld');
					$rswrk->Close();
				} else {
					$this->cat->ViewValue = $this->cat->CurrentValue;
				}
			} else {
				$this->cat->ViewValue = NULL;
			}
			$this->cat->ViewCustomAttributes = "";

			// sub
			if (strval($this->sub->CurrentValue) <> "") {
				$sFilterWrk = "`id`" . ew_SearchString("=", $this->sub->CurrentValue, EW_DATATYPE_NUMBER);
			$sSqlWrk = "SELECT `id`, `subcat` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `gallery_subcat`";
			$sWhereWrk = "";
			if ($sFilterWrk <> "") {
				ew_AddFilter($sWhereWrk, $sFilterWrk);
			}

			// Call Lookup selecting
			$this->Lookup_Selecting($this->sub, $sWhereWrk);
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
				$rswrk = $conn->Execute($sSqlWrk);
				if ($rswrk && !$rswrk->EOF) { // Lookup values found
					$this->sub->ViewValue = $rswrk->fields('DispFld');
					$rswrk->Close();
				} else {
					$this->sub->ViewValue = $this->sub->CurrentValue;
				}
			} else {
				$this->sub->ViewValue = NULL;
			}
			$this->sub->ViewCustomAttributes = "";

			// title
			$this->title->ViewValue = $this->title->CurrentValue;
			$this->title->ViewCustomAttributes = "";

			// descp
			$this->descp->ViewValue = $this->descp->CurrentValue;
			$this->descp->ViewCustomAttributes = "";

			// location
			$this->location->ViewValue = $this->location->CurrentValue;
			$this->location->ViewCustomAttributes = "";

			// datetaken
			$this->datetaken->ViewValue = $this->datetaken->CurrentValue;
			$this->datetaken->ViewCustomAttributes = "";

			// tags
			$this->tags->ViewValue = $this->tags->CurrentValue;
			$this->tags->ViewCustomAttributes = "";

			// views
			$this->views->ViewValue = $this->views->CurrentValue;
			$this->views->ViewCustomAttributes = "";

			// photoby
			$this->photoby->ViewValue = $this->photoby->CurrentValue;
			$this->photoby->ViewCustomAttributes = "";

			// active
			if (ew_ConvertToBool($this->active->CurrentValue)) {
				$this->active->ViewValue = $this->active->FldTagCaption(2) <> "" ? $this->active->FldTagCaption(2) : "Visible";
			} else {
				$this->active->ViewValue = $this->active->FldTagCaption(1) <> "" ? $this->active->FldTagCaption(1) : "Disable";
			}
			$this->active->ViewCustomAttributes = "";

			// featured
			if (ew_ConvertToBool($this->featured->CurrentValue)) {
				$this->featured->ViewValue = $this->featured->FldTagCaption(2) <> "" ? $this->featured->FldTagCaption(2) : "Yes";
			} else {
				$this->featured->ViewValue = $this->featured->FldTagCaption(1) <> "" ? $this->featured->FldTagCaption(1) : "No";
			}
			$this->featured->ViewCustomAttributes = "";

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

			// datep
			$this->datep->ViewValue = $this->datep->CurrentValue;
			$this->datep->ViewCustomAttributes = "";

			// img
			$this->img->LinkCustomAttributes = "";
			$this->img->UploadPath = "../uploads/photos";
			if (!ew_Empty($this->img->Upload->DbValue)) {
				$this->img->HrefValue = ew_UploadPathEx(FALSE, $this->img->UploadPath) . $this->img->Upload->DbValue; // Add prefix/suffix
				$this->img->LinkAttrs["target"] = "_blank"; // Add target
				if ($this->Export <> "") $this->img->HrefValue = ew_ConvertFullUrl($this->img->HrefValue);
			} else {
				$this->img->HrefValue = "";
			}
			$this->img->HrefValue2 = $this->img->UploadPath . $this->img->Upload->DbValue;
			$this->img->TooltipValue = "";

			// cat
			$this->cat->LinkCustomAttributes = "";
			$this->cat->HrefValue = "";
			$this->cat->TooltipValue = "";

			// sub
			$this->sub->LinkCustomAttributes = "";
			$this->sub->HrefValue = "";
			$this->sub->TooltipValue = "";

			// title
			$this->title->LinkCustomAttributes = "";
			$this->title->HrefValue = "";
			$this->title->TooltipValue = "";

			// descp
			$this->descp->LinkCustomAttributes = "";
			$this->descp->HrefValue = "";
			$this->descp->TooltipValue = "";

			// location
			$this->location->LinkCustomAttributes = "";
			$this->location->HrefValue = "";
			$this->location->TooltipValue = "";

			// datetaken
			$this->datetaken->LinkCustomAttributes = "";
			$this->datetaken->HrefValue = "";
			$this->datetaken->TooltipValue = "";

			// tags
			$this->tags->LinkCustomAttributes = "";
			$this->tags->HrefValue = "";
			$this->tags->TooltipValue = "";

			// photoby
			$this->photoby->LinkCustomAttributes = "";
			$this->photoby->HrefValue = "";
			$this->photoby->TooltipValue = "";

			// active
			$this->active->LinkCustomAttributes = "";
			$this->active->HrefValue = "";
			$this->active->TooltipValue = "";

			// featured
			$this->featured->LinkCustomAttributes = "";
			$this->featured->HrefValue = "";
			$this->featured->TooltipValue = "";

			// rate_ord
			$this->rate_ord->LinkCustomAttributes = "";
			$this->rate_ord->HrefValue = "";
			$this->rate_ord->TooltipValue = "";
		} elseif ($this->RowType == EW_ROWTYPE_ADD) { // Add row

			// img
			$this->img->EditCustomAttributes = "";
			$this->img->UploadPath = "../uploads/photos";
			if (!ew_Empty($this->img->Upload->DbValue)) {
				$this->img->ImageWidth = 50;
				$this->img->ImageHeight = 40;
				$this->img->ImageAlt = $this->img->FldAlt();
				$this->img->EditValue = ew_UploadPathEx(FALSE, $this->img->UploadPath) . $this->img->Upload->DbValue;
			} else {
				$this->img->EditValue = "";
			}
			if (($this->CurrentAction == "I" || $this->CurrentAction == "C") && !$this->EventCancelled) ew_RenderUploadField($this->img);

			// cat
			$this->cat->EditCustomAttributes = "";
			if (trim(strval($this->cat->CurrentValue)) == "") {
				$sFilterWrk = "0=1";
			} else {
				$sFilterWrk = "`id`" . ew_SearchString("=", $this->cat->CurrentValue, EW_DATATYPE_NUMBER);
			}
			$sSqlWrk = "SELECT `id`, `category` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld`, '' AS `SelectFilterFld`, '' AS `SelectFilterFld2`, '' AS `SelectFilterFld3`, '' AS `SelectFilterFld4` FROM `gallery_cats`";
			$sWhereWrk = "";
			if ($sFilterWrk <> "") {
				ew_AddFilter($sWhereWrk, $sFilterWrk);
			}

			// Call Lookup selecting
			$this->Lookup_Selecting($this->cat, $sWhereWrk);
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = $conn->Execute($sSqlWrk);
			$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
			if ($rswrk) $rswrk->Close();
			array_unshift($arwrk, array("", $Language->Phrase("PleaseSelect"), "", "", "", "", "", "", ""));
			$this->cat->EditValue = $arwrk;

			// sub
			$this->sub->EditCustomAttributes = "";
			if (trim(strval($this->sub->CurrentValue)) == "") {
				$sFilterWrk = "0=1";
			} else {
				$sFilterWrk = "`id`" . ew_SearchString("=", $this->sub->CurrentValue, EW_DATATYPE_NUMBER);
			}
			$sSqlWrk = "SELECT `id`, `subcat` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld`, `category` AS `SelectFilterFld`, '' AS `SelectFilterFld2`, '' AS `SelectFilterFld3`, '' AS `SelectFilterFld4` FROM `gallery_subcat`";
			$sWhereWrk = "";
			if ($sFilterWrk <> "") {
				ew_AddFilter($sWhereWrk, $sFilterWrk);
			}

			// Call Lookup selecting
			$this->Lookup_Selecting($this->sub, $sWhereWrk);
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = $conn->Execute($sSqlWrk);
			$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
			if ($rswrk) $rswrk->Close();
			array_unshift($arwrk, array("", $Language->Phrase("PleaseSelect"), "", "", "", "", "", "", ""));
			$this->sub->EditValue = $arwrk;

			// title
			$this->title->EditCustomAttributes = "";
			$this->title->EditValue = ew_HtmlEncode($this->title->CurrentValue);
			$this->title->PlaceHolder = ew_HtmlEncode(ew_RemoveHtml($this->title->FldCaption()));

			// descp
			$this->descp->EditCustomAttributes = "";
			$this->descp->EditValue = $this->descp->CurrentValue;
			$this->descp->PlaceHolder = ew_HtmlEncode(ew_RemoveHtml($this->descp->FldCaption()));

			// location
			$this->location->EditCustomAttributes = "";
			$this->location->EditValue = ew_HtmlEncode($this->location->CurrentValue);
			$this->location->PlaceHolder = ew_HtmlEncode(ew_RemoveHtml($this->location->FldCaption()));

			// datetaken
			$this->datetaken->EditCustomAttributes = "";
			$this->datetaken->EditValue = ew_HtmlEncode($this->datetaken->CurrentValue);
			$this->datetaken->PlaceHolder = ew_HtmlEncode(ew_RemoveHtml($this->datetaken->FldCaption()));

			// tags
			$this->tags->EditCustomAttributes = "";
			$this->tags->EditValue = $this->tags->CurrentValue;
			$this->tags->PlaceHolder = ew_HtmlEncode(ew_RemoveHtml($this->tags->FldCaption()));

			// photoby
			$this->photoby->EditCustomAttributes = "";
			$this->photoby->EditValue = ew_HtmlEncode($this->photoby->CurrentValue);
			$this->photoby->PlaceHolder = ew_HtmlEncode(ew_RemoveHtml($this->photoby->FldCaption()));

			// active
			$this->active->EditCustomAttributes = "";
			$arwrk = array();
			$arwrk[] = array($this->active->FldTagValue(1), $this->active->FldTagCaption(1) <> "" ? $this->active->FldTagCaption(1) : $this->active->FldTagValue(1));
			$arwrk[] = array($this->active->FldTagValue(2), $this->active->FldTagCaption(2) <> "" ? $this->active->FldTagCaption(2) : $this->active->FldTagValue(2));
			array_unshift($arwrk, array("", $Language->Phrase("PleaseSelect")));
			$this->active->EditValue = $arwrk;

			// featured
			$this->featured->EditCustomAttributes = "";
			$arwrk = array();
			$arwrk[] = array($this->featured->FldTagValue(1), $this->featured->FldTagCaption(1) <> "" ? $this->featured->FldTagCaption(1) : $this->featured->FldTagValue(1));
			$arwrk[] = array($this->featured->FldTagValue(2), $this->featured->FldTagCaption(2) <> "" ? $this->featured->FldTagCaption(2) : $this->featured->FldTagValue(2));
			$this->featured->EditValue = $arwrk;

			// rate_ord
			$this->rate_ord->EditCustomAttributes = "";
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
			// img

			$this->img->UploadPath = "../uploads/photos";
			if (!ew_Empty($this->img->Upload->DbValue)) {
				$this->img->HrefValue = ew_UploadPathEx(FALSE, $this->img->UploadPath) . $this->img->Upload->DbValue; // Add prefix/suffix
				$this->img->LinkAttrs["target"] = "_blank"; // Add target
				if ($this->Export <> "") $this->img->HrefValue = ew_ConvertFullUrl($this->img->HrefValue);
			} else {
				$this->img->HrefValue = "";
			}
			$this->img->HrefValue2 = $this->img->UploadPath . $this->img->Upload->DbValue;

			// cat
			$this->cat->HrefValue = "";

			// sub
			$this->sub->HrefValue = "";

			// title
			$this->title->HrefValue = "";

			// descp
			$this->descp->HrefValue = "";

			// location
			$this->location->HrefValue = "";

			// datetaken
			$this->datetaken->HrefValue = "";

			// tags
			$this->tags->HrefValue = "";

			// photoby
			$this->photoby->HrefValue = "";

			// active
			$this->active->HrefValue = "";

			// featured
			$this->featured->HrefValue = "";

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
		if (is_null($this->img->Upload->Value)) {
			ew_AddMessage($gsFormError, $Language->Phrase("EnterRequiredField") . " - " . $this->img->FldCaption());
		}
		if (!$this->cat->FldIsDetailKey && !is_null($this->cat->FormValue) && $this->cat->FormValue == "") {
			ew_AddMessage($gsFormError, $Language->Phrase("EnterRequiredField") . " - " . $this->cat->FldCaption());
		}
		if (!ew_CheckEuroDate($this->datetaken->FormValue)) {
			ew_AddMessage($gsFormError, $this->datetaken->FldErrMsg());
		}
		if (!$this->active->FldIsDetailKey && !is_null($this->active->FormValue) && $this->active->FormValue == "") {
			ew_AddMessage($gsFormError, $Language->Phrase("EnterRequiredField") . " - " . $this->active->FldCaption());
		}
		if ($this->featured->FormValue == "") {
			ew_AddMessage($gsFormError, $Language->Phrase("EnterRequiredField") . " - " . $this->featured->FldCaption());
		}
		if (!$this->rate_ord->FldIsDetailKey && !is_null($this->rate_ord->FormValue) && $this->rate_ord->FormValue == "") {
			ew_AddMessage($gsFormError, $Language->Phrase("EnterRequiredField") . " - " . $this->rate_ord->FldCaption());
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
			$this->img->OldUploadPath = "../uploads/photos";
			$this->img->UploadPath = $this->img->OldUploadPath;
		}
		$rsnew = array();

		// img
		if (!$this->img->Upload->KeepFile) {
			if ($this->img->Upload->FileName == "") {
				$rsnew['img'] = NULL;
			} else {
				$rsnew['img'] = $this->img->Upload->FileName;
			}
		}

		// cat
		$this->cat->SetDbValueDef($rsnew, $this->cat->CurrentValue, "", FALSE);

		// sub
		$this->sub->SetDbValueDef($rsnew, $this->sub->CurrentValue, NULL, FALSE);

		// title
		$this->title->SetDbValueDef($rsnew, $this->title->CurrentValue, NULL, FALSE);

		// descp
		$this->descp->SetDbValueDef($rsnew, $this->descp->CurrentValue, NULL, FALSE);

		// location
		$this->location->SetDbValueDef($rsnew, $this->location->CurrentValue, NULL, FALSE);

		// datetaken
		$this->datetaken->SetDbValueDef($rsnew, $this->datetaken->CurrentValue, NULL, FALSE);

		// tags
		$this->tags->SetDbValueDef($rsnew, $this->tags->CurrentValue, NULL, FALSE);

		// photoby
		$this->photoby->SetDbValueDef($rsnew, $this->photoby->CurrentValue, NULL, FALSE);

		// active
		$this->active->SetDbValueDef($rsnew, ((strval($this->active->CurrentValue) == "1") ? "1" : "0"), 0, strval($this->active->CurrentValue) == "");

		// featured
		$this->featured->SetDbValueDef($rsnew, ((strval($this->featured->CurrentValue) == "1") ? "1" : "0"), 0, strval($this->featured->CurrentValue) == "");

		// rate_ord
		$this->rate_ord->SetDbValueDef($rsnew, $this->rate_ord->CurrentValue, NULL, strval($this->rate_ord->CurrentValue) == "");
		if (!$this->img->Upload->KeepFile) {
			$this->img->UploadPath = "../uploads/photos";
			if (!ew_Empty($this->img->Upload->Value)) {
				if ($this->img->Upload->FileName == $this->img->Upload->DbValue) { // Overwrite if same file name
					$this->img->Upload->DbValue = ""; // No need to delete any more
				} else {
					$rsnew['img'] = ew_UploadFileNameEx(ew_UploadPathEx(TRUE, $this->img->UploadPath), $rsnew['img']); // Get new file name
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
				if (!$this->img->Upload->KeepFile) {
					if (!ew_Empty($this->img->Upload->Value)) {
						$this->img->Upload->SaveToFile($this->img->UploadPath, $rsnew['img'], TRUE);
					}
					if ($this->img->Upload->DbValue <> "")
						@unlink(ew_UploadPathEx(TRUE, $this->img->OldUploadPath) . $this->img->Upload->DbValue);
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

		// img
		ew_CleanUploadTempPath($this->img, $this->img->Upload->Index);
		return $AddRow;
	}

	// Set up Breadcrumb
	function SetupBreadcrumb() {
		global $Breadcrumb, $Language;
		$Breadcrumb = new cBreadcrumb();
		$PageCaption = $this->TableCaption();
		$Breadcrumb->Add("list", "<span id=\"ewPageCaption\">" . $PageCaption . "</span>", "photoslist.php", $this->TableVar);
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
if (!isset($photos_add)) $photos_add = new cphotos_add();

// Page init
$photos_add->Page_Init();

// Page main
$photos_add->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$photos_add->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Page object
var photos_add = new ew_Page("photos_add");
photos_add.PageID = "add"; // Page ID
var EW_PAGE_ID = photos_add.PageID; // For backward compatibility

// Form object
var fphotosadd = new ew_Form("fphotosadd");

// Validate form
fphotosadd.Validate = function() {
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
			felm = this.GetElements("x" + infix + "_img");
			elm = this.GetElements("fn_x" + infix + "_img");
			if (felm && elm && !ew_HasValue(elm))
				return this.OnError(felm, ewLanguage.Phrase("EnterRequiredField") + " - <?php echo ew_JsEncode2($photos->img->FldCaption()) ?>");
			elm = this.GetElements("x" + infix + "_cat");
			if (elm && !ew_HasValue(elm))
				return this.OnError(elm, ewLanguage.Phrase("EnterRequiredField") + " - <?php echo ew_JsEncode2($photos->cat->FldCaption()) ?>");
			elm = this.GetElements("x" + infix + "_datetaken");
			if (elm && !ew_CheckEuroDate(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($photos->datetaken->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_active");
			if (elm && !ew_HasValue(elm))
				return this.OnError(elm, ewLanguage.Phrase("EnterRequiredField") + " - <?php echo ew_JsEncode2($photos->active->FldCaption()) ?>");
			elm = this.GetElements("x" + infix + "_featured");
			if (elm && !ew_HasValue(elm))
				return this.OnError(elm, ewLanguage.Phrase("EnterRequiredField") + " - <?php echo ew_JsEncode2($photos->featured->FldCaption()) ?>");
			elm = this.GetElements("x" + infix + "_rate_ord");
			if (elm && !ew_HasValue(elm))
				return this.OnError(elm, ewLanguage.Phrase("EnterRequiredField") + " - <?php echo ew_JsEncode2($photos->rate_ord->FldCaption()) ?>");

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
fphotosadd.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
fphotosadd.ValidateRequired = true;
<?php } else { ?>
fphotosadd.ValidateRequired = false; 
<?php } ?>

// Multi-Page properties
fphotosadd.MultiPage = new ew_MultiPage("fphotosadd",
	[["x_img",1],["x_cat",1],["x_sub",1],["x_title",1],["x_descp",2],["x_location",2],["x_datetaken",2],["x_tags",1],["x_photoby",2],["x_active",1],["x_featured",2],["x_rate_ord",2]]
);

// Dynamic selection lists
fphotosadd.Lists["x_cat"] = {"LinkField":"x_id","Ajax":true,"AutoFill":false,"DisplayFields":["x_category","","",""],"ParentFields":[],"FilterFields":[],"Options":[]};
fphotosadd.Lists["x_sub"] = {"LinkField":"x_id","Ajax":true,"AutoFill":false,"DisplayFields":["x_subcat","","",""],"ParentFields":["x_cat"],"FilterFields":["x_category"],"Options":[]};

// Form object for search
</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<?php $Breadcrumb->Render(); ?>
<?php $photos_add->ShowPageHeader(); ?>
<?php
$photos_add->ShowMessage();
?>
<form name="fphotosadd" id="fphotosadd" class="ewForm form-horizontal" action="<?php echo ew_CurrentPage() ?>" method="post">
<input type="hidden" name="t" value="photos">
<input type="hidden" name="a_add" id="a_add" value="A">
<table class="ewStdTable"><tbody><tr><td>
<div class="tabbable" id="photos_add">
	<ul class="nav nav-tabs">
		<li class="active"><a href="#tab_photos1" data-toggle="tab"><?php echo $photos->PageCaption(1) ?></a></li>
		<li><a href="#tab_photos2" data-toggle="tab"><?php echo $photos->PageCaption(2) ?></a></li>
	</ul>
	<div class="tab-content">
		<div class="tab-pane active" id="tab_photos1">
<table cellspacing="0" class="ewGrid" style="width: 100%"><tr><td>
<table id="tbl_photosadd1" class="table table-bordered table-striped">
<?php if ($photos->img->Visible) { // img ?>
	<tr id="r_img">
		<td><span id="elh_photos_img"><?php echo $photos->img->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></span></td>
		<td<?php echo $photos->img->CellAttributes() ?>>
<span id="el_photos_img" class="control-group">
<span id="fd_x_img">
<span class="btn btn-small fileinput-button">
	<span><?php echo $Language->Phrase("ChooseFile") ?></span>
	<input type="file" data-field="x_img" name="x_img" id="x_img">
</span>
<input type="hidden" name="fn_x_img" id= "fn_x_img" value="<?php echo $photos->img->Upload->FileName ?>">
<input type="hidden" name="fa_x_img" id= "fa_x_img" value="0">
<input type="hidden" name="fs_x_img" id= "fs_x_img" value="100">
</span>
<table id="ft_x_img" class="table table-condensed pull-left ewUploadTable"><tbody class="files"></tbody></table>
</span>
<?php echo $photos->img->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($photos->cat->Visible) { // cat ?>
	<tr id="r_cat">
		<td><span id="elh_photos_cat"><?php echo $photos->cat->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></span></td>
		<td<?php echo $photos->cat->CellAttributes() ?>>
<span id="el_photos_cat" class="control-group">
<?php $photos->cat->EditAttrs["onchange"] = "ew_UpdateOpt.call(this, ['x_sub']); " . @$photos->cat->EditAttrs["onchange"]; ?>
<select data-field="x_cat" id="x_cat" name="x_cat"<?php echo $photos->cat->EditAttributes() ?>>
<?php
if (is_array($photos->cat->EditValue)) {
	$arwrk = $photos->cat->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($photos->cat->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " selected=\"selected\"" : "";
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
<?php
$sSqlWrk = "SELECT `id`, `category` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `gallery_cats`";
$sWhereWrk = "";

// Call Lookup selecting
$photos->Lookup_Selecting($photos->cat, $sWhereWrk);
if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
?>
<input type="hidden" name="s_x_cat" id="s_x_cat" value="s=<?php echo ew_Encrypt($sSqlWrk) ?>&f0=<?php echo ew_Encrypt("`id` = {filter_value}"); ?>&t0=3">
</span>
<?php echo $photos->cat->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($photos->sub->Visible) { // sub ?>
	<tr id="r_sub">
		<td><span id="elh_photos_sub"><?php echo $photos->sub->FldCaption() ?></span></td>
		<td<?php echo $photos->sub->CellAttributes() ?>>
<span id="el_photos_sub" class="control-group">
<select data-field="x_sub" id="x_sub" name="x_sub"<?php echo $photos->sub->EditAttributes() ?>>
<?php
if (is_array($photos->sub->EditValue)) {
	$arwrk = $photos->sub->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($photos->sub->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " selected=\"selected\"" : "";
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
<?php
$sSqlWrk = "SELECT `id`, `subcat` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `gallery_subcat`";
$sWhereWrk = "{filter}";

// Call Lookup selecting
$photos->Lookup_Selecting($photos->sub, $sWhereWrk);
if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
?>
<input type="hidden" name="s_x_sub" id="s_x_sub" value="s=<?php echo ew_Encrypt($sSqlWrk) ?>&f0=<?php echo ew_Encrypt("`id` = {filter_value}"); ?>&t0=3&f1=<?php echo ew_Encrypt("`category` IN ({filter_value})"); ?>&t1=3">
</span>
<?php echo $photos->sub->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($photos->title->Visible) { // title ?>
	<tr id="r_title">
		<td><span id="elh_photos_title"><?php echo $photos->title->FldCaption() ?></span></td>
		<td<?php echo $photos->title->CellAttributes() ?>>
<span id="el_photos_title" class="control-group">
<input type="text" data-field="x_title" name="x_title" id="x_title" size="50" maxlength="200" placeholder="<?php echo $photos->title->PlaceHolder ?>" value="<?php echo $photos->title->EditValue ?>"<?php echo $photos->title->EditAttributes() ?>>
</span>
<?php echo $photos->title->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($photos->tags->Visible) { // tags ?>
	<tr id="r_tags">
		<td><span id="elh_photos_tags"><?php echo $photos->tags->FldCaption() ?></span></td>
		<td<?php echo $photos->tags->CellAttributes() ?>>
<span id="el_photos_tags" class="control-group">
<textarea data-field="x_tags" name="x_tags" id="x_tags" cols="50" rows="4" placeholder="<?php echo $photos->tags->PlaceHolder ?>"<?php echo $photos->tags->EditAttributes() ?>><?php echo $photos->tags->EditValue ?></textarea>
</span>
<?php echo $photos->tags->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($photos->active->Visible) { // active ?>
	<tr id="r_active">
		<td><span id="elh_photos_active"><?php echo $photos->active->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></span></td>
		<td<?php echo $photos->active->CellAttributes() ?>>
<span id="el_photos_active" class="control-group">
<select data-field="x_active" id="x_active" name="x_active"<?php echo $photos->active->EditAttributes() ?>>
<?php
if (is_array($photos->active->EditValue)) {
	$arwrk = $photos->active->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($photos->active->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " selected=\"selected\"" : "";
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
<?php echo $photos->active->CustomMsg ?></td>
	</tr>
<?php } ?>
</table>
</td></tr></table>
		</div>
		<div class="tab-pane" id="tab_photos2">
<table cellspacing="0" class="ewGrid" style="width: 100%"><tr><td>
<table id="tbl_photosadd2" class="table table-bordered table-striped">
<?php if ($photos->descp->Visible) { // descp ?>
	<tr id="r_descp">
		<td><span id="elh_photos_descp"><?php echo $photos->descp->FldCaption() ?></span></td>
		<td<?php echo $photos->descp->CellAttributes() ?>>
<span id="el_photos_descp" class="control-group">
<textarea data-field="x_descp" name="x_descp" id="x_descp" cols="50" rows="4" placeholder="<?php echo $photos->descp->PlaceHolder ?>"<?php echo $photos->descp->EditAttributes() ?>><?php echo $photos->descp->EditValue ?></textarea>
</span>
<?php echo $photos->descp->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($photos->location->Visible) { // location ?>
	<tr id="r_location">
		<td><span id="elh_photos_location"><?php echo $photos->location->FldCaption() ?></span></td>
		<td<?php echo $photos->location->CellAttributes() ?>>
<span id="el_photos_location" class="control-group">
<input type="text" data-field="x_location" name="x_location" id="x_location" size="50" maxlength="100" placeholder="<?php echo $photos->location->PlaceHolder ?>" value="<?php echo $photos->location->EditValue ?>"<?php echo $photos->location->EditAttributes() ?>>
</span>
<?php echo $photos->location->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($photos->datetaken->Visible) { // datetaken ?>
	<tr id="r_datetaken">
		<td><span id="elh_photos_datetaken"><?php echo $photos->datetaken->FldCaption() ?></span></td>
		<td<?php echo $photos->datetaken->CellAttributes() ?>>
<span id="el_photos_datetaken" class="control-group">
<input type="text" data-field="x_datetaken" name="x_datetaken" id="x_datetaken" placeholder="<?php echo $photos->datetaken->PlaceHolder ?>" value="<?php echo $photos->datetaken->EditValue ?>"<?php echo $photos->datetaken->EditAttributes() ?>>
<?php if (!$photos->datetaken->ReadOnly && !$photos->datetaken->Disabled && @$photos->datetaken->EditAttrs["readonly"] == "" && @$photos->datetaken->EditAttrs["disabled"] == "") { ?>
<button id="cal_x_datetaken" name="cal_x_datetaken" class="btn" type="button"><img src="phpimages/calendar.png" id="cal_x_datetaken" alt="<?php echo $Language->Phrase("PickDate") ?>" title="<?php echo $Language->Phrase("PickDate") ?>" style="border: 0;"></button><script type="text/javascript">
ew_CreateCalendar("fphotosadd", "x_datetaken", "%d/%m/%Y");
</script>
<?php } ?>
</span>
<?php echo $photos->datetaken->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($photos->photoby->Visible) { // photoby ?>
	<tr id="r_photoby">
		<td><span id="elh_photos_photoby"><?php echo $photos->photoby->FldCaption() ?></span></td>
		<td<?php echo $photos->photoby->CellAttributes() ?>>
<span id="el_photos_photoby" class="control-group">
<input type="text" data-field="x_photoby" name="x_photoby" id="x_photoby" size="50" maxlength="50" placeholder="<?php echo $photos->photoby->PlaceHolder ?>" value="<?php echo $photos->photoby->EditValue ?>"<?php echo $photos->photoby->EditAttributes() ?>>
</span>
<?php echo $photos->photoby->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($photos->featured->Visible) { // featured ?>
	<tr id="r_featured">
		<td><span id="elh_photos_featured"><?php echo $photos->featured->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></span></td>
		<td<?php echo $photos->featured->CellAttributes() ?>>
<span id="el_photos_featured" class="control-group">
<div id="tp_x_featured" class="<?php echo EW_ITEM_TEMPLATE_CLASSNAME ?>"><input type="radio" name="x_featured" id="x_featured" value="{value}"<?php echo $photos->featured->EditAttributes() ?>></div>
<div id="dsl_x_featured" data-repeatcolumn="5" class="ewItemList">
<?php
$arwrk = $photos->featured->EditValue;
if (is_array($arwrk)) {
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($photos->featured->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " checked=\"checked\"" : "";
		if ($selwrk <> "") $emptywrk = FALSE;

		// Note: No spacing within the LABEL tag
?>
<?php echo ew_RepeatColumnTable($rowswrk, $rowcntwrk, 5, 1) ?>
<label class="radio"><input type="radio" data-field="x_featured" name="x_featured" id="x_featured_<?php echo $rowcntwrk ?>" value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?><?php echo $photos->featured->EditAttributes() ?>><?php echo $arwrk[$rowcntwrk][1] ?></label>
<?php echo ew_RepeatColumnTable($rowswrk, $rowcntwrk, 5, 2) ?>
<?php
	}
}
?>
</div>
</span>
<?php echo $photos->featured->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($photos->rate_ord->Visible) { // rate_ord ?>
	<tr id="r_rate_ord">
		<td><span id="elh_photos_rate_ord"><?php echo $photos->rate_ord->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></span></td>
		<td<?php echo $photos->rate_ord->CellAttributes() ?>>
<span id="el_photos_rate_ord" class="control-group">
<select data-field="x_rate_ord" id="x_rate_ord" name="x_rate_ord"<?php echo $photos->rate_ord->EditAttributes() ?>>
<?php
if (is_array($photos->rate_ord->EditValue)) {
	$arwrk = $photos->rate_ord->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($photos->rate_ord->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " selected=\"selected\"" : "";
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
<?php echo $photos->rate_ord->CustomMsg ?></td>
	</tr>
<?php } ?>
</table>
</td></tr></table>
		</div>
	</div>
</div>
</td></tr></tbody></table>
<button class="btn btn-primary ewButton" name="btnAction" id="btnAction" type="submit"><?php echo $Language->Phrase("AddBtn") ?></button>
</form>
<script type="text/javascript">
fphotosadd.Init();
<?php if (EW_MOBILE_REFLOW && ew_IsMobile()) { ?>
ew_Reflow();
<?php } ?>
</script>
<?php
$photos_add->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$photos_add->Page_Terminate();
?>
