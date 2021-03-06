<?php
if (session_id() == "") session_start(); // Initialize Session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg10.php" ?>
<?php include_once "ewmysql10.php" ?>
<?php include_once "phpfn10.php" ?>
<?php include_once "usersinfo.php" ?>
<?php include_once "adminusersinfo.php" ?>
<?php include_once "userfn10.php" ?>
<?php

//
// Page class
//

$users_edit = NULL; // Initialize page object first

class cusers_edit extends cusers {

	// Page ID
	var $PageID = 'edit';

	// Project ID
	var $ProjectID = "{D9B361E7-B2C1-4293-B9B3-B581986A15CC}";

	// Table name
	var $TableName = 'users';

	// Page object name
	var $PageObjName = 'users_edit';

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

		// Table object (users)
		if (!isset($GLOBALS["users"])) {
			$GLOBALS["users"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["users"];
		}

		// Table object (adminusers)
		if (!isset($GLOBALS['adminusers'])) $GLOBALS['adminusers'] = new cadminusers();

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'edit', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'users', TRUE);

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
	var $DbMasterFilter;
	var $DbDetailFilter;
	var $DisplayRecs = 1;
	var $StartRec;
	var $StopRec;
	var $TotalRecs = 0;
	var $RecRange = 10;
	var $Pager;
	var $RecCnt;
	var $RecKey = array();
	var $Recordset;

	// 
	// Page main
	//
	function Page_Main() {
		global $objForm, $Language, $gsFormError;

		// Load current record
		$bLoadCurrentRecord = FALSE;
		$sReturnUrl = "";
		$bMatchRecord = FALSE;

		// Load key from QueryString
		if (@$_GET["id"] <> "") {
			$this->id->setQueryStringValue($_GET["id"]);
			$this->RecKey["id"] = $this->id->QueryStringValue;
		} else {
			$bLoadCurrentRecord = TRUE;
		}

		// Set up Breadcrumb
		$this->SetupBreadcrumb();

		// Load recordset
		$this->StartRec = 1; // Initialize start position
		if ($this->Recordset = $this->LoadRecordset()) // Load records
			$this->TotalRecs = $this->Recordset->RecordCount(); // Get record count
		if ($this->TotalRecs <= 0) { // No record found
			if ($this->getSuccessMessage() == "" && $this->getFailureMessage() == "")
				$this->setFailureMessage($Language->Phrase("NoRecord")); // Set no record message
			$this->Page_Terminate("userslist.php"); // Return to list page
		} elseif ($bLoadCurrentRecord) { // Load current record position
			$this->SetUpStartRec(); // Set up start record position

			// Point to current record
			if (intval($this->StartRec) <= intval($this->TotalRecs)) {
				$bMatchRecord = TRUE;
				$this->Recordset->Move($this->StartRec-1);
			}
		} else { // Match key values
			while (!$this->Recordset->EOF) {
				if (strval($this->id->CurrentValue) == strval($this->Recordset->fields('id'))) {
					$this->setStartRecordNumber($this->StartRec); // Save record position
					$bMatchRecord = TRUE;
					break;
				} else {
					$this->StartRec++;
					$this->Recordset->MoveNext();
				}
			}
		}

		// Process form if post back
		if (@$_POST["a_edit"] <> "") {
			$this->CurrentAction = $_POST["a_edit"]; // Get action code
			$this->LoadFormValues(); // Get form values
		} else {
			$this->CurrentAction = "I"; // Default action is display
		}

		// Validate form if post back
		if (@$_POST["a_edit"] <> "") {
			if (!$this->ValidateForm()) {
				$this->CurrentAction = ""; // Form error, reset action
				$this->setFailureMessage($gsFormError);
				$this->EventCancelled = TRUE; // Event cancelled
				$this->RestoreFormValues();
			}
		}
		switch ($this->CurrentAction) {
			case "I": // Get a record to display
				if (!$bMatchRecord) {
					if ($this->getSuccessMessage() == "" && $this->getFailureMessage() == "")
						$this->setFailureMessage($Language->Phrase("NoRecord")); // Set no record message
					$this->Page_Terminate("userslist.php"); // Return to list page
				} else {
					$this->LoadRowValues($this->Recordset); // Load row values
				}
				break;
			Case "U": // Update
				$this->SendEmail = TRUE; // Send email on update success
				if ($this->EditRow()) { // Update record based on key
					if ($this->getSuccessMessage() == "")
						$this->setSuccessMessage($Language->Phrase("UpdateSuccess")); // Update success
					$sReturnUrl = $this->getReturnUrl();
					if (ew_GetPageName($sReturnUrl) == "usersview.php")
						$sReturnUrl = $this->GetViewUrl(); // View paging, return to View page directly
					$this->Page_Terminate($sReturnUrl); // Return to caller
				} else {
					$this->EventCancelled = TRUE; // Event cancelled
					$this->RestoreFormValues(); // Restore form values if update failed
				}
		}

		// Render the record
		$this->RowType = EW_ROWTYPE_EDIT; // Render as Edit
		$this->ResetAttrs();
		$this->RenderRow();
	}

	// Set up starting record parameters
	function SetUpStartRec() {
		if ($this->DisplayRecs == 0)
			return;
		if ($this->IsPageRequest()) { // Validate request
			if (@$_GET[EW_TABLE_START_REC] <> "") { // Check for "start" parameter
				$this->StartRec = $_GET[EW_TABLE_START_REC];
				$this->setStartRecordNumber($this->StartRec);
			} elseif (@$_GET[EW_TABLE_PAGE_NO] <> "") {
				$PageNo = $_GET[EW_TABLE_PAGE_NO];
				if (is_numeric($PageNo)) {
					$this->StartRec = ($PageNo-1)*$this->DisplayRecs+1;
					if ($this->StartRec <= 0) {
						$this->StartRec = 1;
					} elseif ($this->StartRec >= intval(($this->TotalRecs-1)/$this->DisplayRecs)*$this->DisplayRecs+1) {
						$this->StartRec = intval(($this->TotalRecs-1)/$this->DisplayRecs)*$this->DisplayRecs+1;
					}
					$this->setStartRecordNumber($this->StartRec);
				}
			}
		}
		$this->StartRec = $this->getStartRecordNumber();

		// Check if correct start record counter
		if (!is_numeric($this->StartRec) || $this->StartRec == "") { // Avoid invalid start record counter
			$this->StartRec = 1; // Reset start record counter
			$this->setStartRecordNumber($this->StartRec);
		} elseif (intval($this->StartRec) > intval($this->TotalRecs)) { // Avoid starting record > total records
			$this->StartRec = intval(($this->TotalRecs-1)/$this->DisplayRecs)*$this->DisplayRecs+1; // Point to last page first record
			$this->setStartRecordNumber($this->StartRec);
		} elseif (($this->StartRec-1) % $this->DisplayRecs <> 0) {
			$this->StartRec = intval(($this->StartRec-1)/$this->DisplayRecs)*$this->DisplayRecs+1; // Point to page boundary
			$this->setStartRecordNumber($this->StartRec);
		}
	}

	// Get upload files
	function GetUploadFiles() {
		global $objForm;

		// Get upload data
	}

	// Load form values
	function LoadFormValues() {

		// Load from form
		global $objForm;
		if (!$this->id->FldIsDetailKey)
			$this->id->setFormValue($objForm->GetValue("x_id"));
		if (!$this->oauth_provider->FldIsDetailKey) {
			$this->oauth_provider->setFormValue($objForm->GetValue("x_oauth_provider"));
		}
		if (!$this->oauth_uid->FldIsDetailKey) {
			$this->oauth_uid->setFormValue($objForm->GetValue("x_oauth_uid"));
		}
		if (!$this->fname->FldIsDetailKey) {
			$this->fname->setFormValue($objForm->GetValue("x_fname"));
		}
		if (!$this->lname->FldIsDetailKey) {
			$this->lname->setFormValue($objForm->GetValue("x_lname"));
		}
		if (!$this->_email->FldIsDetailKey) {
			$this->_email->setFormValue($objForm->GetValue("x__email"));
		}
		if (!$this->phone->FldIsDetailKey) {
			$this->phone->setFormValue($objForm->GetValue("x_phone"));
		}
		if (!$this->password->FldIsDetailKey) {
			$this->password->setFormValue($objForm->GetValue("x_password"));
		}
		if (!$this->state->FldIsDetailKey) {
			$this->state->setFormValue($objForm->GetValue("x_state"));
		}
		if (!$this->country->FldIsDetailKey) {
			$this->country->setFormValue($objForm->GetValue("x_country"));
		}
		if (!$this->gender->FldIsDetailKey) {
			$this->gender->setFormValue($objForm->GetValue("x_gender"));
		}
		if (!$this->locale->FldIsDetailKey) {
			$this->locale->setFormValue($objForm->GetValue("x_locale"));
		}
		if (!$this->picture->FldIsDetailKey) {
			$this->picture->setFormValue($objForm->GetValue("x_picture"));
		}
		if (!$this->img->FldIsDetailKey) {
			$this->img->setFormValue($objForm->GetValue("x_img"));
		}
		if (!$this->active->FldIsDetailKey) {
			$this->active->setFormValue($objForm->GetValue("x_active"));
		}
		if (!$this->created->FldIsDetailKey) {
			$this->created->setFormValue($objForm->GetValue("x_created"));
			$this->created->CurrentValue = ew_UnFormatDateTime($this->created->CurrentValue, 0);
		}
		if (!$this->modified->FldIsDetailKey) {
			$this->modified->setFormValue($objForm->GetValue("x_modified"));
			$this->modified->CurrentValue = ew_UnFormatDateTime($this->modified->CurrentValue, 0);
		}
	}

	// Restore form values
	function RestoreFormValues() {
		global $objForm;
		$this->LoadRow();
		$this->id->CurrentValue = $this->id->FormValue;
		$this->oauth_provider->CurrentValue = $this->oauth_provider->FormValue;
		$this->oauth_uid->CurrentValue = $this->oauth_uid->FormValue;
		$this->fname->CurrentValue = $this->fname->FormValue;
		$this->lname->CurrentValue = $this->lname->FormValue;
		$this->_email->CurrentValue = $this->_email->FormValue;
		$this->phone->CurrentValue = $this->phone->FormValue;
		$this->password->CurrentValue = $this->password->FormValue;
		$this->state->CurrentValue = $this->state->FormValue;
		$this->country->CurrentValue = $this->country->FormValue;
		$this->gender->CurrentValue = $this->gender->FormValue;
		$this->locale->CurrentValue = $this->locale->FormValue;
		$this->picture->CurrentValue = $this->picture->FormValue;
		$this->img->CurrentValue = $this->img->FormValue;
		$this->active->CurrentValue = $this->active->FormValue;
		$this->created->CurrentValue = $this->created->FormValue;
		$this->created->CurrentValue = ew_UnFormatDateTime($this->created->CurrentValue, 0);
		$this->modified->CurrentValue = $this->modified->FormValue;
		$this->modified->CurrentValue = ew_UnFormatDateTime($this->modified->CurrentValue, 0);
	}

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
		$this->oauth_provider->setDbValue($rs->fields('oauth_provider'));
		$this->oauth_uid->setDbValue($rs->fields('oauth_uid'));
		$this->fname->setDbValue($rs->fields('fname'));
		$this->lname->setDbValue($rs->fields('lname'));
		$this->_email->setDbValue($rs->fields('email'));
		$this->phone->setDbValue($rs->fields('phone'));
		$this->password->setDbValue($rs->fields('password'));
		$this->state->setDbValue($rs->fields('state'));
		$this->country->setDbValue($rs->fields('country'));
		$this->gender->setDbValue($rs->fields('gender'));
		$this->locale->setDbValue($rs->fields('locale'));
		$this->picture->setDbValue($rs->fields('picture'));
		$this->img->setDbValue($rs->fields('img'));
		$this->active->setDbValue($rs->fields('active'));
		$this->created->setDbValue($rs->fields('created'));
		$this->modified->setDbValue($rs->fields('modified'));
	}

	// Load DbValue from recordset
	function LoadDbValues(&$rs) {
		if (!$rs || !is_array($rs) && $rs->EOF) return;
		$row = is_array($rs) ? $rs : $rs->fields;
		$this->id->DbValue = $row['id'];
		$this->oauth_provider->DbValue = $row['oauth_provider'];
		$this->oauth_uid->DbValue = $row['oauth_uid'];
		$this->fname->DbValue = $row['fname'];
		$this->lname->DbValue = $row['lname'];
		$this->_email->DbValue = $row['email'];
		$this->phone->DbValue = $row['phone'];
		$this->password->DbValue = $row['password'];
		$this->state->DbValue = $row['state'];
		$this->country->DbValue = $row['country'];
		$this->gender->DbValue = $row['gender'];
		$this->locale->DbValue = $row['locale'];
		$this->picture->DbValue = $row['picture'];
		$this->img->DbValue = $row['img'];
		$this->active->DbValue = $row['active'];
		$this->created->DbValue = $row['created'];
		$this->modified->DbValue = $row['modified'];
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
		// oauth_provider
		// oauth_uid
		// fname
		// lname
		// email
		// phone
		// password
		// state
		// country
		// gender
		// locale
		// picture
		// img
		// active
		// created
		// modified

		if ($this->RowType == EW_ROWTYPE_VIEW) { // View row

			// id
			$this->id->ViewValue = $this->id->CurrentValue;
			$this->id->ViewCustomAttributes = "";

			// oauth_provider
			$this->oauth_provider->ViewValue = $this->oauth_provider->CurrentValue;
			$this->oauth_provider->ViewCustomAttributes = "";

			// oauth_uid
			$this->oauth_uid->ViewValue = $this->oauth_uid->CurrentValue;
			$this->oauth_uid->ViewCustomAttributes = "";

			// fname
			$this->fname->ViewValue = $this->fname->CurrentValue;
			$this->fname->ViewCustomAttributes = "";

			// lname
			$this->lname->ViewValue = $this->lname->CurrentValue;
			$this->lname->ViewCustomAttributes = "";

			// email
			$this->_email->ViewValue = $this->_email->CurrentValue;
			$this->_email->ViewCustomAttributes = "";

			// phone
			$this->phone->ViewValue = $this->phone->CurrentValue;
			$this->phone->ViewCustomAttributes = "";

			// password
			$this->password->ViewValue = "********";
			$this->password->ViewCustomAttributes = "";

			// state
			$this->state->ViewValue = $this->state->CurrentValue;
			$this->state->ViewCustomAttributes = "";

			// country
			$this->country->ViewValue = $this->country->CurrentValue;
			$this->country->ViewCustomAttributes = "";

			// gender
			$this->gender->ViewValue = $this->gender->CurrentValue;
			$this->gender->ViewCustomAttributes = "";

			// locale
			$this->locale->ViewValue = $this->locale->CurrentValue;
			$this->locale->ViewCustomAttributes = "";

			// picture
			$this->picture->ViewValue = $this->picture->CurrentValue;
			$this->picture->ViewCustomAttributes = "";

			// img
			$this->img->ViewValue = $this->img->CurrentValue;
			$this->img->ViewCustomAttributes = "";

			// active
			if (strval($this->active->CurrentValue) <> "") {
				switch ($this->active->CurrentValue) {
					case $this->active->FldTagValue(1):
						$this->active->ViewValue = $this->active->FldTagCaption(1) <> "" ? $this->active->FldTagCaption(1) : $this->active->CurrentValue;
						break;
					default:
						$this->active->ViewValue = $this->active->CurrentValue;
				}
			} else {
				$this->active->ViewValue = NULL;
			}
			$this->active->ViewCustomAttributes = "";

			// created
			$this->created->ViewValue = $this->created->CurrentValue;
			$this->created->ViewCustomAttributes = "";

			// modified
			$this->modified->ViewValue = $this->modified->CurrentValue;
			$this->modified->ViewCustomAttributes = "";

			// id
			$this->id->LinkCustomAttributes = "";
			$this->id->HrefValue = "";
			$this->id->TooltipValue = "";

			// oauth_provider
			$this->oauth_provider->LinkCustomAttributes = "";
			$this->oauth_provider->HrefValue = "";
			$this->oauth_provider->TooltipValue = "";

			// oauth_uid
			$this->oauth_uid->LinkCustomAttributes = "";
			$this->oauth_uid->HrefValue = "";
			$this->oauth_uid->TooltipValue = "";

			// fname
			$this->fname->LinkCustomAttributes = "";
			$this->fname->HrefValue = "";
			$this->fname->TooltipValue = "";

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

			// password
			$this->password->LinkCustomAttributes = "";
			$this->password->HrefValue = "";
			$this->password->TooltipValue = "";

			// state
			$this->state->LinkCustomAttributes = "";
			$this->state->HrefValue = "";
			$this->state->TooltipValue = "";

			// country
			$this->country->LinkCustomAttributes = "";
			$this->country->HrefValue = "";
			$this->country->TooltipValue = "";

			// gender
			$this->gender->LinkCustomAttributes = "";
			$this->gender->HrefValue = "";
			$this->gender->TooltipValue = "";

			// locale
			$this->locale->LinkCustomAttributes = "";
			$this->locale->HrefValue = "";
			$this->locale->TooltipValue = "";

			// picture
			$this->picture->LinkCustomAttributes = "";
			$this->picture->HrefValue = "";
			$this->picture->TooltipValue = "";

			// img
			$this->img->LinkCustomAttributes = "";
			$this->img->HrefValue = "";
			$this->img->TooltipValue = "";

			// active
			$this->active->LinkCustomAttributes = "";
			$this->active->HrefValue = "";
			$this->active->TooltipValue = "";

			// created
			$this->created->LinkCustomAttributes = "";
			$this->created->HrefValue = "";
			$this->created->TooltipValue = "";

			// modified
			$this->modified->LinkCustomAttributes = "";
			$this->modified->HrefValue = "";
			$this->modified->TooltipValue = "";
		} elseif ($this->RowType == EW_ROWTYPE_EDIT) { // Edit row

			// id
			$this->id->EditCustomAttributes = "";
			$this->id->EditValue = $this->id->CurrentValue;
			$this->id->ViewCustomAttributes = "";

			// oauth_provider
			$this->oauth_provider->EditCustomAttributes = "";
			$this->oauth_provider->EditValue = ew_HtmlEncode($this->oauth_provider->CurrentValue);
			$this->oauth_provider->PlaceHolder = ew_HtmlEncode(ew_RemoveHtml($this->oauth_provider->FldCaption()));

			// oauth_uid
			$this->oauth_uid->EditCustomAttributes = "";
			$this->oauth_uid->EditValue = ew_HtmlEncode($this->oauth_uid->CurrentValue);
			$this->oauth_uid->PlaceHolder = ew_HtmlEncode(ew_RemoveHtml($this->oauth_uid->FldCaption()));

			// fname
			$this->fname->EditCustomAttributes = "style='width:97%' ";
			$this->fname->EditValue = ew_HtmlEncode($this->fname->CurrentValue);
			$this->fname->PlaceHolder = ew_HtmlEncode(ew_RemoveHtml($this->fname->FldCaption()));

			// lname
			$this->lname->EditCustomAttributes = "style='width:97%' ";
			$this->lname->EditValue = ew_HtmlEncode($this->lname->CurrentValue);
			$this->lname->PlaceHolder = ew_HtmlEncode(ew_RemoveHtml($this->lname->FldCaption()));

			// email
			$this->_email->EditCustomAttributes = "style='width:97%' ";
			$this->_email->EditValue = ew_HtmlEncode($this->_email->CurrentValue);
			$this->_email->PlaceHolder = ew_HtmlEncode(ew_RemoveHtml($this->_email->FldCaption()));

			// phone
			$this->phone->EditCustomAttributes = "style='width:97%' ";
			$this->phone->EditValue = ew_HtmlEncode($this->phone->CurrentValue);
			$this->phone->PlaceHolder = ew_HtmlEncode(ew_RemoveHtml($this->phone->FldCaption()));

			// password
			$this->password->EditCustomAttributes = "style='width:97%' ";
			$this->password->EditValue = ew_HtmlEncode($this->password->CurrentValue);

			// state
			$this->state->EditCustomAttributes = "";
			$this->state->EditValue = ew_HtmlEncode($this->state->CurrentValue);
			$this->state->PlaceHolder = ew_HtmlEncode(ew_RemoveHtml($this->state->FldCaption()));

			// country
			$this->country->EditCustomAttributes = "";
			$this->country->EditValue = ew_HtmlEncode($this->country->CurrentValue);
			$this->country->PlaceHolder = ew_HtmlEncode(ew_RemoveHtml($this->country->FldCaption()));

			// gender
			$this->gender->EditCustomAttributes = "";
			$this->gender->EditValue = ew_HtmlEncode($this->gender->CurrentValue);
			$this->gender->PlaceHolder = ew_HtmlEncode(ew_RemoveHtml($this->gender->FldCaption()));

			// locale
			$this->locale->EditCustomAttributes = "";
			$this->locale->EditValue = ew_HtmlEncode($this->locale->CurrentValue);
			$this->locale->PlaceHolder = ew_HtmlEncode(ew_RemoveHtml($this->locale->FldCaption()));

			// picture
			$this->picture->EditCustomAttributes = "";
			$this->picture->EditValue = $this->picture->CurrentValue;
			$this->picture->PlaceHolder = ew_HtmlEncode(ew_RemoveHtml($this->picture->FldCaption()));

			// img
			$this->img->EditCustomAttributes = "";
			$this->img->EditValue = ew_HtmlEncode($this->img->CurrentValue);
			$this->img->PlaceHolder = ew_HtmlEncode(ew_RemoveHtml($this->img->FldCaption()));

			// active
			$this->active->EditCustomAttributes = "";
			$arwrk = array();
			$arwrk[] = array($this->active->FldTagValue(1), $this->active->FldTagCaption(1) <> "" ? $this->active->FldTagCaption(1) : $this->active->FldTagValue(1));
			$this->active->EditValue = $arwrk;

			// created
			$this->created->EditCustomAttributes = "";
			$this->created->EditValue = ew_HtmlEncode($this->created->CurrentValue);
			$this->created->PlaceHolder = ew_HtmlEncode(ew_RemoveHtml($this->created->FldCaption()));

			// modified
			$this->modified->EditCustomAttributes = "";
			$this->modified->EditValue = ew_HtmlEncode($this->modified->CurrentValue);
			$this->modified->PlaceHolder = ew_HtmlEncode(ew_RemoveHtml($this->modified->FldCaption()));

			// Edit refer script
			// id

			$this->id->HrefValue = "";

			// oauth_provider
			$this->oauth_provider->HrefValue = "";

			// oauth_uid
			$this->oauth_uid->HrefValue = "";

			// fname
			$this->fname->HrefValue = "";

			// lname
			$this->lname->HrefValue = "";

			// email
			$this->_email->HrefValue = "";

			// phone
			$this->phone->HrefValue = "";

			// password
			$this->password->HrefValue = "";

			// state
			$this->state->HrefValue = "";

			// country
			$this->country->HrefValue = "";

			// gender
			$this->gender->HrefValue = "";

			// locale
			$this->locale->HrefValue = "";

			// picture
			$this->picture->HrefValue = "";

			// img
			$this->img->HrefValue = "";

			// active
			$this->active->HrefValue = "";

			// created
			$this->created->HrefValue = "";

			// modified
			$this->modified->HrefValue = "";
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

	// Update record based on key values
	function EditRow() {
		global $conn, $Security, $Language;
		$sFilter = $this->KeyFilter();
		$this->CurrentFilter = $sFilter;
		$sSql = $this->SQL();
		$conn->raiseErrorFn = 'ew_ErrorFn';
		$rs = $conn->Execute($sSql);
		$conn->raiseErrorFn = '';
		if ($rs === FALSE)
			return FALSE;
		if ($rs->EOF) {
			$EditRow = FALSE; // Update Failed
		} else {

			// Save old values
			$rsold = &$rs->fields;
			$this->LoadDbValues($rsold);
			$rsnew = array();

			// oauth_provider
			$this->oauth_provider->SetDbValueDef($rsnew, $this->oauth_provider->CurrentValue, NULL, $this->oauth_provider->ReadOnly);

			// oauth_uid
			$this->oauth_uid->SetDbValueDef($rsnew, $this->oauth_uid->CurrentValue, NULL, $this->oauth_uid->ReadOnly);

			// fname
			$this->fname->SetDbValueDef($rsnew, $this->fname->CurrentValue, NULL, $this->fname->ReadOnly);

			// lname
			$this->lname->SetDbValueDef($rsnew, $this->lname->CurrentValue, NULL, $this->lname->ReadOnly);

			// email
			$this->_email->SetDbValueDef($rsnew, $this->_email->CurrentValue, NULL, $this->_email->ReadOnly);

			// phone
			$this->phone->SetDbValueDef($rsnew, $this->phone->CurrentValue, NULL, $this->phone->ReadOnly);

			// password
			$this->password->SetDbValueDef($rsnew, $this->password->CurrentValue, NULL, $this->password->ReadOnly);

			// state
			$this->state->SetDbValueDef($rsnew, $this->state->CurrentValue, NULL, $this->state->ReadOnly);

			// country
			$this->country->SetDbValueDef($rsnew, $this->country->CurrentValue, NULL, $this->country->ReadOnly);

			// gender
			$this->gender->SetDbValueDef($rsnew, $this->gender->CurrentValue, NULL, $this->gender->ReadOnly);

			// locale
			$this->locale->SetDbValueDef($rsnew, $this->locale->CurrentValue, NULL, $this->locale->ReadOnly);

			// picture
			$this->picture->SetDbValueDef($rsnew, $this->picture->CurrentValue, NULL, $this->picture->ReadOnly);

			// img
			$this->img->SetDbValueDef($rsnew, $this->img->CurrentValue, NULL, $this->img->ReadOnly);

			// active
			$this->active->SetDbValueDef($rsnew, $this->active->CurrentValue, NULL, $this->active->ReadOnly);

			// created
			$this->created->SetDbValueDef($rsnew, $this->created->CurrentValue, NULL, $this->created->ReadOnly);

			// modified
			$this->modified->SetDbValueDef($rsnew, $this->modified->CurrentValue, NULL, $this->modified->ReadOnly);

			// Call Row Updating event
			$bUpdateRow = $this->Row_Updating($rsold, $rsnew);
			if ($bUpdateRow) {
				$conn->raiseErrorFn = 'ew_ErrorFn';
				if (count($rsnew) > 0)
					$EditRow = $this->Update($rsnew, "", $rsold);
				else
					$EditRow = TRUE; // No field to update
				$conn->raiseErrorFn = '';
				if ($EditRow) {
				}
			} else {
				if ($this->getSuccessMessage() <> "" || $this->getFailureMessage() <> "") {

					// Use the message, do nothing
				} elseif ($this->CancelMessage <> "") {
					$this->setFailureMessage($this->CancelMessage);
					$this->CancelMessage = "";
				} else {
					$this->setFailureMessage($Language->Phrase("UpdateCancelled"));
				}
				$EditRow = FALSE;
			}
		}

		// Call Row_Updated event
		if ($EditRow)
			$this->Row_Updated($rsold, $rsnew);
		$rs->Close();
		return $EditRow;
	}

	// Set up Breadcrumb
	function SetupBreadcrumb() {
		global $Breadcrumb, $Language;
		$Breadcrumb = new cBreadcrumb();
		$PageCaption = $this->TableCaption();
		$Breadcrumb->Add("list", "<span id=\"ewPageCaption\">" . $PageCaption . "</span>", "userslist.php", $this->TableVar);
		$PageCaption = $Language->Phrase("edit");
		$Breadcrumb->Add("edit", "<span id=\"ewPageCaption\">" . $PageCaption . "</span>", ew_CurrentUrl(), $this->TableVar);
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
if (!isset($users_edit)) $users_edit = new cusers_edit();

// Page init
$users_edit->Page_Init();

// Page main
$users_edit->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$users_edit->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Page object
var users_edit = new ew_Page("users_edit");
users_edit.PageID = "edit"; // Page ID
var EW_PAGE_ID = users_edit.PageID; // For backward compatibility

// Form object
var fusersedit = new ew_Form("fusersedit");

// Validate form
fusersedit.Validate = function() {
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
fusersedit.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
fusersedit.ValidateRequired = true;
<?php } else { ?>
fusersedit.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
// Form object for search

</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<?php $Breadcrumb->Render(); ?>
<?php $users_edit->ShowPageHeader(); ?>
<?php
$users_edit->ShowMessage();
?>
<form name="fusersedit" id="fusersedit" class="ewForm form-horizontal" action="<?php echo ew_CurrentPage() ?>" method="post">
<input type="hidden" name="t" value="users">
<input type="hidden" name="a_edit" id="a_edit" value="U">
<table cellspacing="0" class="ewGrid"><tr><td>
<table id="tbl_usersedit" class="table table-bordered table-striped">
<?php if ($users->id->Visible) { // id ?>
	<tr id="r_id">
		<td><span id="elh_users_id"><?php echo $users->id->FldCaption() ?></span></td>
		<td<?php echo $users->id->CellAttributes() ?>>
<span id="el_users_id" class="control-group">
<span<?php echo $users->id->ViewAttributes() ?>>
<?php echo $users->id->EditValue ?></span>
</span>
<input type="hidden" data-field="x_id" name="x_id" id="x_id" value="<?php echo ew_HtmlEncode($users->id->CurrentValue) ?>">
<?php echo $users->id->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($users->oauth_provider->Visible) { // oauth_provider ?>
	<tr id="r_oauth_provider">
		<td><span id="elh_users_oauth_provider"><?php echo $users->oauth_provider->FldCaption() ?></span></td>
		<td<?php echo $users->oauth_provider->CellAttributes() ?>>
<span id="el_users_oauth_provider" class="control-group">
<input type="text" data-field="x_oauth_provider" name="x_oauth_provider" id="x_oauth_provider" size="30" maxlength="255" placeholder="<?php echo $users->oauth_provider->PlaceHolder ?>" value="<?php echo $users->oauth_provider->EditValue ?>"<?php echo $users->oauth_provider->EditAttributes() ?>>
</span>
<?php echo $users->oauth_provider->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($users->oauth_uid->Visible) { // oauth_uid ?>
	<tr id="r_oauth_uid">
		<td><span id="elh_users_oauth_uid"><?php echo $users->oauth_uid->FldCaption() ?></span></td>
		<td<?php echo $users->oauth_uid->CellAttributes() ?>>
<span id="el_users_oauth_uid" class="control-group">
<input type="text" data-field="x_oauth_uid" name="x_oauth_uid" id="x_oauth_uid" size="30" maxlength="255" placeholder="<?php echo $users->oauth_uid->PlaceHolder ?>" value="<?php echo $users->oauth_uid->EditValue ?>"<?php echo $users->oauth_uid->EditAttributes() ?>>
</span>
<?php echo $users->oauth_uid->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($users->fname->Visible) { // fname ?>
	<tr id="r_fname">
		<td><span id="elh_users_fname"><?php echo $users->fname->FldCaption() ?></span></td>
		<td<?php echo $users->fname->CellAttributes() ?>>
<span id="el_users_fname" class="control-group">
<input type="text" data-field="x_fname" name="x_fname" id="x_fname" size="30" maxlength="50" placeholder="<?php echo $users->fname->PlaceHolder ?>" value="<?php echo $users->fname->EditValue ?>"<?php echo $users->fname->EditAttributes() ?>>
</span>
<?php echo $users->fname->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($users->lname->Visible) { // lname ?>
	<tr id="r_lname">
		<td><span id="elh_users_lname"><?php echo $users->lname->FldCaption() ?></span></td>
		<td<?php echo $users->lname->CellAttributes() ?>>
<span id="el_users_lname" class="control-group">
<input type="text" data-field="x_lname" name="x_lname" id="x_lname" size="30" maxlength="50" placeholder="<?php echo $users->lname->PlaceHolder ?>" value="<?php echo $users->lname->EditValue ?>"<?php echo $users->lname->EditAttributes() ?>>
</span>
<?php echo $users->lname->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($users->_email->Visible) { // email ?>
	<tr id="r__email">
		<td><span id="elh_users__email"><?php echo $users->_email->FldCaption() ?></span></td>
		<td<?php echo $users->_email->CellAttributes() ?>>
<span id="el_users__email" class="control-group">
<input type="text" data-field="x__email" name="x__email" id="x__email" size="30" maxlength="50" placeholder="<?php echo $users->_email->PlaceHolder ?>" value="<?php echo $users->_email->EditValue ?>"<?php echo $users->_email->EditAttributes() ?>>
</span>
<?php echo $users->_email->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($users->phone->Visible) { // phone ?>
	<tr id="r_phone">
		<td><span id="elh_users_phone"><?php echo $users->phone->FldCaption() ?></span></td>
		<td<?php echo $users->phone->CellAttributes() ?>>
<span id="el_users_phone" class="control-group">
<input type="text" data-field="x_phone" name="x_phone" id="x_phone" size="30" maxlength="20" placeholder="<?php echo $users->phone->PlaceHolder ?>" value="<?php echo $users->phone->EditValue ?>"<?php echo $users->phone->EditAttributes() ?>>
</span>
<?php echo $users->phone->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($users->password->Visible) { // password ?>
	<tr id="r_password">
		<td><span id="elh_users_password"><?php echo $users->password->FldCaption() ?></span></td>
		<td<?php echo $users->password->CellAttributes() ?>>
<span id="el_users_password" class="control-group">
<input type="password" data-field="x_password" name="x_password" id="x_password" value="<?php echo $users->password->EditValue ?>" size="30" maxlength="32"<?php echo $users->password->EditAttributes() ?>>
</span>
<?php echo $users->password->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($users->state->Visible) { // state ?>
	<tr id="r_state">
		<td><span id="elh_users_state"><?php echo $users->state->FldCaption() ?></span></td>
		<td<?php echo $users->state->CellAttributes() ?>>
<span id="el_users_state" class="control-group">
<input type="text" data-field="x_state" name="x_state" id="x_state" size="30" maxlength="20" placeholder="<?php echo $users->state->PlaceHolder ?>" value="<?php echo $users->state->EditValue ?>"<?php echo $users->state->EditAttributes() ?>>
</span>
<?php echo $users->state->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($users->country->Visible) { // country ?>
	<tr id="r_country">
		<td><span id="elh_users_country"><?php echo $users->country->FldCaption() ?></span></td>
		<td<?php echo $users->country->CellAttributes() ?>>
<span id="el_users_country" class="control-group">
<input type="text" data-field="x_country" name="x_country" id="x_country" size="30" maxlength="20" placeholder="<?php echo $users->country->PlaceHolder ?>" value="<?php echo $users->country->EditValue ?>"<?php echo $users->country->EditAttributes() ?>>
</span>
<?php echo $users->country->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($users->gender->Visible) { // gender ?>
	<tr id="r_gender">
		<td><span id="elh_users_gender"><?php echo $users->gender->FldCaption() ?></span></td>
		<td<?php echo $users->gender->CellAttributes() ?>>
<span id="el_users_gender" class="control-group">
<input type="text" data-field="x_gender" name="x_gender" id="x_gender" size="30" maxlength="10" placeholder="<?php echo $users->gender->PlaceHolder ?>" value="<?php echo $users->gender->EditValue ?>"<?php echo $users->gender->EditAttributes() ?>>
</span>
<?php echo $users->gender->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($users->locale->Visible) { // locale ?>
	<tr id="r_locale">
		<td><span id="elh_users_locale"><?php echo $users->locale->FldCaption() ?></span></td>
		<td<?php echo $users->locale->CellAttributes() ?>>
<span id="el_users_locale" class="control-group">
<input type="text" data-field="x_locale" name="x_locale" id="x_locale" size="30" maxlength="10" placeholder="<?php echo $users->locale->PlaceHolder ?>" value="<?php echo $users->locale->EditValue ?>"<?php echo $users->locale->EditAttributes() ?>>
</span>
<?php echo $users->locale->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($users->picture->Visible) { // picture ?>
	<tr id="r_picture">
		<td><span id="elh_users_picture"><?php echo $users->picture->FldCaption() ?></span></td>
		<td<?php echo $users->picture->CellAttributes() ?>>
<span id="el_users_picture" class="control-group">
<textarea data-field="x_picture" name="x_picture" id="x_picture" cols="35" rows="4" placeholder="<?php echo $users->picture->PlaceHolder ?>"<?php echo $users->picture->EditAttributes() ?>><?php echo $users->picture->EditValue ?></textarea>
</span>
<?php echo $users->picture->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($users->img->Visible) { // img ?>
	<tr id="r_img">
		<td><span id="elh_users_img"><?php echo $users->img->FldCaption() ?></span></td>
		<td<?php echo $users->img->CellAttributes() ?>>
<span id="el_users_img" class="control-group">
<input type="text" data-field="x_img" name="x_img" id="x_img" size="30" maxlength="50" placeholder="<?php echo $users->img->PlaceHolder ?>" value="<?php echo $users->img->EditValue ?>"<?php echo $users->img->EditAttributes() ?>>
</span>
<?php echo $users->img->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($users->active->Visible) { // active ?>
	<tr id="r_active">
		<td><span id="elh_users_active"><?php echo $users->active->FldCaption() ?></span></td>
		<td<?php echo $users->active->CellAttributes() ?>>
<span id="el_users_active" class="control-group">
<div id="tp_x_active" class="<?php echo EW_ITEM_TEMPLATE_CLASSNAME ?>"><input type="radio" name="x_active" id="x_active" value="{value}"<?php echo $users->active->EditAttributes() ?>></div>
<div id="dsl_x_active" data-repeatcolumn="5" class="ewItemList">
<?php
$arwrk = $users->active->EditValue;
if (is_array($arwrk)) {
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($users->active->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " checked=\"checked\"" : "";
		if ($selwrk <> "") $emptywrk = FALSE;

		// Note: No spacing within the LABEL tag
?>
<?php echo ew_RepeatColumnTable($rowswrk, $rowcntwrk, 5, 1) ?>
<label class="radio"><input type="radio" data-field="x_active" name="x_active" id="x_active_<?php echo $rowcntwrk ?>" value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?><?php echo $users->active->EditAttributes() ?>><?php echo $arwrk[$rowcntwrk][1] ?></label>
<?php echo ew_RepeatColumnTable($rowswrk, $rowcntwrk, 5, 2) ?>
<?php
	}
}
?>
</div>
</span>
<?php echo $users->active->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($users->created->Visible) { // created ?>
	<tr id="r_created">
		<td><span id="elh_users_created"><?php echo $users->created->FldCaption() ?></span></td>
		<td<?php echo $users->created->CellAttributes() ?>>
<span id="el_users_created" class="control-group">
<input type="text" data-field="x_created" name="x_created" id="x_created" placeholder="<?php echo $users->created->PlaceHolder ?>" value="<?php echo $users->created->EditValue ?>"<?php echo $users->created->EditAttributes() ?>>
</span>
<?php echo $users->created->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($users->modified->Visible) { // modified ?>
	<tr id="r_modified">
		<td><span id="elh_users_modified"><?php echo $users->modified->FldCaption() ?></span></td>
		<td<?php echo $users->modified->CellAttributes() ?>>
<span id="el_users_modified" class="control-group">
<input type="text" data-field="x_modified" name="x_modified" id="x_modified" placeholder="<?php echo $users->modified->PlaceHolder ?>" value="<?php echo $users->modified->EditValue ?>"<?php echo $users->modified->EditAttributes() ?>>
</span>
<?php echo $users->modified->CustomMsg ?></td>
	</tr>
<?php } ?>
</table>
</td></tr></table>
<table class="ewPager">
<tr><td>
<?php if (!isset($users_edit->Pager)) $users_edit->Pager = new cNumericPager($users_edit->StartRec, $users_edit->DisplayRecs, $users_edit->TotalRecs, $users_edit->RecRange) ?>
<?php if ($users_edit->Pager->RecordCount > 0) { ?>
<table cellspacing="0" class="ewStdTable"><tbody><tr><td>
<div class="pagination"><ul>
	<?php if ($users_edit->Pager->FirstButton->Enabled) { ?>
	<li><a href="<?php echo $users_edit->PageUrl() ?>start=<?php echo $users_edit->Pager->FirstButton->Start ?>"><?php echo $Language->Phrase("PagerFirst") ?></a></li>
	<?php } ?>
	<?php if ($users_edit->Pager->PrevButton->Enabled) { ?>
	<li><a href="<?php echo $users_edit->PageUrl() ?>start=<?php echo $users_edit->Pager->PrevButton->Start ?>"><?php echo $Language->Phrase("PagerPrevious") ?></a></li>
	<?php } ?>
	<?php foreach ($users_edit->Pager->Items as $PagerItem) { ?>
		<li<?php if (!$PagerItem->Enabled) { echo " class=\" active\""; } ?>><a href="<?php if ($PagerItem->Enabled) { echo $users_edit->PageUrl() . "start=" . $PagerItem->Start; } else { echo "#"; } ?>"><?php echo $PagerItem->Text ?></a></li>
	<?php } ?>
	<?php if ($users_edit->Pager->NextButton->Enabled) { ?>
	<li><a href="<?php echo $users_edit->PageUrl() ?>start=<?php echo $users_edit->Pager->NextButton->Start ?>"><?php echo $Language->Phrase("PagerNext") ?></a></li>
	<?php } ?>
	<?php if ($users_edit->Pager->LastButton->Enabled) { ?>
	<li><a href="<?php echo $users_edit->PageUrl() ?>start=<?php echo $users_edit->Pager->LastButton->Start ?>"><?php echo $Language->Phrase("PagerLast") ?></a></li>
	<?php } ?>
</ul></div>
</td>
</tr></tbody></table>
<?php } else { ?>
	<p><?php echo $Language->Phrase("NoRecord") ?></p>
<?php } ?>
</td>
</tr></table>
<button class="btn btn-primary ewButton" name="btnAction" id="btnAction" type="submit"><?php echo $Language->Phrase("EditBtn") ?></button>
</form>
<script type="text/javascript">
fusersedit.Init();
<?php if (EW_MOBILE_REFLOW && ew_IsMobile()) { ?>
ew_Reflow();
<?php } ?>
</script>
<?php
$users_edit->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$users_edit->Page_Terminate();
?>
