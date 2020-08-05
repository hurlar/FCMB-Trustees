<?php
if (session_id() == "") session_start(); // Initialize Session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg10.php" ?>
<?php include_once "ewmysql10.php" ?>
<?php include_once "phpfn10.php" ?>
<?php include_once "layoutinfo.php" ?>
<?php include_once "adminusersinfo.php" ?>
<?php include_once "userfn10.php" ?>
<?php

//
// Page class
//

$layout_delete = NULL; // Initialize page object first

class clayout_delete extends clayout {

	// Page ID
	var $PageID = 'delete';

	// Project ID
	var $ProjectID = "{D9B361E7-B2C1-4293-B9B3-B581986A15CC}";

	// Table name
	var $TableName = 'layout';

	// Page object name
	var $PageObjName = 'layout_delete';

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

		// Table object (layout)
		if (!isset($GLOBALS["layout"])) {
			$GLOBALS["layout"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["layout"];
		}

		// Table object (adminusers)
		if (!isset($GLOBALS['adminusers'])) $GLOBALS['adminusers'] = new cadminusers();

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'delete', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'layout', TRUE);

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
			$this->Page_Terminate("layoutlist.php"); // Prevent SQL injection, return to list

		// Set up filter (SQL WHHERE clause) and get return SQL
		// SQL constructor in layout class, layoutinfo.php

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
		$this->logo->setDbValue($rs->fields('logo'));
		$this->url->setDbValue($rs->fields('url'));
		$this->meta2Dtitle->setDbValue($rs->fields('meta-title'));
		$this->meta2Dkeywords->setDbValue($rs->fields('meta-keywords'));
		$this->meta2Ddescp->setDbValue($rs->fields('meta-descp'));
		$this->top2Dl->setDbValue($rs->fields('top-l'));
		$this->top2Dr->setDbValue($rs->fields('top-r'));
		$this->head2Dl->setDbValue($rs->fields('head-l'));
		$this->head2Dr->setDbValue($rs->fields('head-r'));
		$this->slide1->Upload->DbValue = $rs->fields('slide1');
		$this->slide2->Upload->DbValue = $rs->fields('slide2');
		$this->slide3->Upload->DbValue = $rs->fields('slide3');
		$this->slide4->Upload->DbValue = $rs->fields('slide4');
		$this->slide5->Upload->DbValue = $rs->fields('slide5');
		$this->slide6->Upload->DbValue = $rs->fields('slide6');
		$this->nav2Dtext->setDbValue($rs->fields('nav-text'));
		$this->slide2Dbox->setDbValue($rs->fields('slide-box'));
		$this->custom2Dcss->setDbValue($rs->fields('custom-css'));
		$this->home2Dcaption1->setDbValue($rs->fields('home-caption1'));
		$this->home2Dtext1->setDbValue($rs->fields('home-text1'));
		$this->home2Dcaption2->setDbValue($rs->fields('home-caption2'));
		$this->home2Dtext2->setDbValue($rs->fields('home-text2'));
		$this->home2Dcaption3->setDbValue($rs->fields('home-caption3'));
		$this->home2Dtext3->setDbValue($rs->fields('home-text3'));
		$this->home2Dcaption4->setDbValue($rs->fields('home-caption4'));
		$this->home2Dtext4->setDbValue($rs->fields('home-text4'));
		$this->home2Dcaption5->setDbValue($rs->fields('home-caption5'));
		$this->home2Dtext5->setDbValue($rs->fields('home-text5'));
		$this->home2Dcaption6->setDbValue($rs->fields('home-caption6'));
		$this->home2Dtext6->setDbValue($rs->fields('home-text6'));
		$this->footer2D1->setDbValue($rs->fields('footer-1'));
		$this->footer2D2->setDbValue($rs->fields('footer-2'));
		$this->footer2D3->setDbValue($rs->fields('footer-3'));
		$this->footer2D4->setDbValue($rs->fields('footer-4'));
		$this->base2Dl->setDbValue($rs->fields('base-l'));
		$this->base2Dr->setDbValue($rs->fields('base-r'));
		$this->contact2Demail->setDbValue($rs->fields('contact-email'));
		$this->contact2Dtext1->setDbValue($rs->fields('contact-text1'));
		$this->contact2Dtext2->setDbValue($rs->fields('contact-text2'));
		$this->contact2Dtext3->setDbValue($rs->fields('contact-text3'));
		$this->contact2Dtext4->setDbValue($rs->fields('contact-text4'));
		$this->google2Dmap->setDbValue($rs->fields('google-map'));
		$this->fb2Dlikebox->setDbValue($rs->fields('fb-likebox'));
	}

	// Load DbValue from recordset
	function LoadDbValues(&$rs) {
		if (!$rs || !is_array($rs) && $rs->EOF) return;
		$row = is_array($rs) ? $rs : $rs->fields;
		$this->id->DbValue = $row['id'];
		$this->logo->DbValue = $row['logo'];
		$this->url->DbValue = $row['url'];
		$this->meta2Dtitle->DbValue = $row['meta-title'];
		$this->meta2Dkeywords->DbValue = $row['meta-keywords'];
		$this->meta2Ddescp->DbValue = $row['meta-descp'];
		$this->top2Dl->DbValue = $row['top-l'];
		$this->top2Dr->DbValue = $row['top-r'];
		$this->head2Dl->DbValue = $row['head-l'];
		$this->head2Dr->DbValue = $row['head-r'];
		$this->slide1->Upload->DbValue = $row['slide1'];
		$this->slide2->Upload->DbValue = $row['slide2'];
		$this->slide3->Upload->DbValue = $row['slide3'];
		$this->slide4->Upload->DbValue = $row['slide4'];
		$this->slide5->Upload->DbValue = $row['slide5'];
		$this->slide6->Upload->DbValue = $row['slide6'];
		$this->nav2Dtext->DbValue = $row['nav-text'];
		$this->slide2Dbox->DbValue = $row['slide-box'];
		$this->custom2Dcss->DbValue = $row['custom-css'];
		$this->home2Dcaption1->DbValue = $row['home-caption1'];
		$this->home2Dtext1->DbValue = $row['home-text1'];
		$this->home2Dcaption2->DbValue = $row['home-caption2'];
		$this->home2Dtext2->DbValue = $row['home-text2'];
		$this->home2Dcaption3->DbValue = $row['home-caption3'];
		$this->home2Dtext3->DbValue = $row['home-text3'];
		$this->home2Dcaption4->DbValue = $row['home-caption4'];
		$this->home2Dtext4->DbValue = $row['home-text4'];
		$this->home2Dcaption5->DbValue = $row['home-caption5'];
		$this->home2Dtext5->DbValue = $row['home-text5'];
		$this->home2Dcaption6->DbValue = $row['home-caption6'];
		$this->home2Dtext6->DbValue = $row['home-text6'];
		$this->footer2D1->DbValue = $row['footer-1'];
		$this->footer2D2->DbValue = $row['footer-2'];
		$this->footer2D3->DbValue = $row['footer-3'];
		$this->footer2D4->DbValue = $row['footer-4'];
		$this->base2Dl->DbValue = $row['base-l'];
		$this->base2Dr->DbValue = $row['base-r'];
		$this->contact2Demail->DbValue = $row['contact-email'];
		$this->contact2Dtext1->DbValue = $row['contact-text1'];
		$this->contact2Dtext2->DbValue = $row['contact-text2'];
		$this->contact2Dtext3->DbValue = $row['contact-text3'];
		$this->contact2Dtext4->DbValue = $row['contact-text4'];
		$this->google2Dmap->DbValue = $row['google-map'];
		$this->fb2Dlikebox->DbValue = $row['fb-likebox'];
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
		// logo

		$this->logo->CellCssStyle = "white-space: nowrap;";

		// url
		$this->url->CellCssStyle = "white-space: nowrap;";

		// meta-title
		$this->meta2Dtitle->CellCssStyle = "white-space: nowrap;";

		// meta-keywords
		$this->meta2Dkeywords->CellCssStyle = "white-space: nowrap;";

		// meta-descp
		$this->meta2Ddescp->CellCssStyle = "white-space: nowrap;";

		// top-l
		// top-r
		// head-l
		// head-r
		// slide1
		// slide2
		// slide3
		// slide4
		// slide5
		// slide6
		// nav-text

		$this->nav2Dtext->CellCssStyle = "white-space: nowrap;";

		// slide-box
		$this->slide2Dbox->CellCssStyle = "white-space: nowrap;";

		// custom-css
		$this->custom2Dcss->CellCssStyle = "white-space: nowrap;";

		// home-caption1
		// home-text1
		// home-caption2
		// home-text2
		// home-caption3
		// home-text3
		// home-caption4
		// home-text4
		// home-caption5
		// home-text5
		// home-caption6
		// home-text6
		// footer-1
		// footer-2
		// footer-3
		// footer-4
		// base-l

		$this->base2Dl->CellCssStyle = "white-space: nowrap;";

		// base-r
		$this->base2Dr->CellCssStyle = "white-space: nowrap;";

		// contact-email
		// contact-text1
		// contact-text2
		// contact-text3
		// contact-text4
		// google-map
		// fb-likebox

		if ($this->RowType == EW_ROWTYPE_VIEW) { // View row

			// id
			$this->id->ViewValue = $this->id->CurrentValue;
			$this->id->ViewCustomAttributes = "";

			// logo
			$this->logo->ViewValue = $this->logo->CurrentValue;
			$this->logo->ViewCustomAttributes = "";

			// url
			$this->url->ViewValue = $this->url->CurrentValue;
			$this->url->ViewCustomAttributes = "";

			// meta-title
			$this->meta2Dtitle->ViewValue = $this->meta2Dtitle->CurrentValue;
			$this->meta2Dtitle->ViewCustomAttributes = "";

			// meta-keywords
			$this->meta2Dkeywords->ViewValue = $this->meta2Dkeywords->CurrentValue;
			$this->meta2Dkeywords->ViewCustomAttributes = "";

			// meta-descp
			$this->meta2Ddescp->ViewValue = $this->meta2Ddescp->CurrentValue;
			$this->meta2Ddescp->ViewCustomAttributes = "";

			// top-l
			$this->top2Dl->ViewValue = $this->top2Dl->CurrentValue;
			$this->top2Dl->ViewCustomAttributes = "";

			// top-r
			$this->top2Dr->ViewValue = $this->top2Dr->CurrentValue;
			$this->top2Dr->ViewCustomAttributes = "";

			// head-l
			$this->head2Dl->ViewValue = $this->head2Dl->CurrentValue;
			$this->head2Dl->ViewCustomAttributes = "";

			// head-r
			$this->head2Dr->ViewValue = $this->head2Dr->CurrentValue;
			$this->head2Dr->ViewCustomAttributes = "";

			// slide1
			$this->slide1->UploadPath = "../images/slides/";
			if (!ew_Empty($this->slide1->Upload->DbValue)) {
				$this->slide1->ViewValue = $this->slide1->Upload->DbValue;
			} else {
				$this->slide1->ViewValue = "";
			}
			$this->slide1->ViewCustomAttributes = "";

			// slide2
			$this->slide2->UploadPath = "../images/slides/";
			if (!ew_Empty($this->slide2->Upload->DbValue)) {
				$this->slide2->ViewValue = $this->slide2->Upload->DbValue;
			} else {
				$this->slide2->ViewValue = "";
			}
			$this->slide2->ViewCustomAttributes = "";

			// slide3
			$this->slide3->UploadPath = "../images/slides/";
			if (!ew_Empty($this->slide3->Upload->DbValue)) {
				$this->slide3->ViewValue = $this->slide3->Upload->DbValue;
			} else {
				$this->slide3->ViewValue = "";
			}
			$this->slide3->ViewCustomAttributes = "";

			// slide4
			$this->slide4->UploadPath = "../images/slides/";
			if (!ew_Empty($this->slide4->Upload->DbValue)) {
				$this->slide4->ViewValue = $this->slide4->Upload->DbValue;
			} else {
				$this->slide4->ViewValue = "";
			}
			$this->slide4->ViewCustomAttributes = "";

			// slide5
			$this->slide5->UploadPath = "../images/slides/";
			if (!ew_Empty($this->slide5->Upload->DbValue)) {
				$this->slide5->ViewValue = $this->slide5->Upload->DbValue;
			} else {
				$this->slide5->ViewValue = "";
			}
			$this->slide5->ViewCustomAttributes = "";

			// slide6
			$this->slide6->UploadPath = "../images/slides/";
			if (!ew_Empty($this->slide6->Upload->DbValue)) {
				$this->slide6->ViewValue = $this->slide6->Upload->DbValue;
			} else {
				$this->slide6->ViewValue = "";
			}
			$this->slide6->ViewCustomAttributes = "";

			// nav-text
			$this->nav2Dtext->ViewValue = $this->nav2Dtext->CurrentValue;
			$this->nav2Dtext->ViewCustomAttributes = "";

			// slide-box
			$this->slide2Dbox->ViewValue = $this->slide2Dbox->CurrentValue;
			$this->slide2Dbox->ViewCustomAttributes = "";

			// custom-css
			$this->custom2Dcss->ViewValue = $this->custom2Dcss->CurrentValue;
			$this->custom2Dcss->ViewCustomAttributes = "";

			// home-caption1
			$this->home2Dcaption1->ViewValue = $this->home2Dcaption1->CurrentValue;
			$this->home2Dcaption1->ViewCustomAttributes = "";

			// home-text1
			$this->home2Dtext1->ViewValue = $this->home2Dtext1->CurrentValue;
			$this->home2Dtext1->ViewCustomAttributes = "";

			// home-caption2
			$this->home2Dcaption2->ViewValue = $this->home2Dcaption2->CurrentValue;
			$this->home2Dcaption2->ViewCustomAttributes = "";

			// home-text2
			$this->home2Dtext2->ViewValue = $this->home2Dtext2->CurrentValue;
			$this->home2Dtext2->ViewCustomAttributes = "";

			// home-caption3
			$this->home2Dcaption3->ViewValue = $this->home2Dcaption3->CurrentValue;
			$this->home2Dcaption3->ViewCustomAttributes = "";

			// home-text3
			$this->home2Dtext3->ViewValue = $this->home2Dtext3->CurrentValue;
			$this->home2Dtext3->ViewCustomAttributes = "";

			// home-caption4
			$this->home2Dcaption4->ViewValue = $this->home2Dcaption4->CurrentValue;
			$this->home2Dcaption4->ViewCustomAttributes = "";

			// home-text4
			$this->home2Dtext4->ViewValue = $this->home2Dtext4->CurrentValue;
			$this->home2Dtext4->ViewCustomAttributes = "";

			// home-caption5
			$this->home2Dcaption5->ViewValue = $this->home2Dcaption5->CurrentValue;
			$this->home2Dcaption5->ViewCustomAttributes = "";

			// home-text5
			$this->home2Dtext5->ViewValue = $this->home2Dtext5->CurrentValue;
			$this->home2Dtext5->ViewCustomAttributes = "";

			// home-caption6
			$this->home2Dcaption6->ViewValue = $this->home2Dcaption6->CurrentValue;
			$this->home2Dcaption6->ViewCustomAttributes = "";

			// home-text6
			$this->home2Dtext6->ViewValue = $this->home2Dtext6->CurrentValue;
			$this->home2Dtext6->ViewCustomAttributes = "";

			// footer-1
			$this->footer2D1->ViewValue = $this->footer2D1->CurrentValue;
			$this->footer2D1->ViewCustomAttributes = "";

			// footer-2
			$this->footer2D2->ViewValue = $this->footer2D2->CurrentValue;
			$this->footer2D2->ViewCustomAttributes = "";

			// footer-3
			$this->footer2D3->ViewValue = $this->footer2D3->CurrentValue;
			$this->footer2D3->ViewCustomAttributes = "";

			// footer-4
			$this->footer2D4->ViewValue = $this->footer2D4->CurrentValue;
			$this->footer2D4->ViewCustomAttributes = "";

			// base-l
			$this->base2Dl->ViewValue = $this->base2Dl->CurrentValue;
			$this->base2Dl->ViewCustomAttributes = "";

			// base-r
			$this->base2Dr->ViewValue = $this->base2Dr->CurrentValue;
			$this->base2Dr->ViewCustomAttributes = "";

			// contact-email
			$this->contact2Demail->ViewValue = $this->contact2Demail->CurrentValue;
			$this->contact2Demail->ViewCustomAttributes = "";

			// contact-text1
			$this->contact2Dtext1->ViewValue = $this->contact2Dtext1->CurrentValue;
			$this->contact2Dtext1->ViewCustomAttributes = "";

			// contact-text2
			$this->contact2Dtext2->ViewValue = $this->contact2Dtext2->CurrentValue;
			$this->contact2Dtext2->ViewCustomAttributes = "";

			// contact-text3
			$this->contact2Dtext3->ViewValue = $this->contact2Dtext3->CurrentValue;
			$this->contact2Dtext3->ViewCustomAttributes = "";

			// contact-text4
			$this->contact2Dtext4->ViewValue = $this->contact2Dtext4->CurrentValue;
			$this->contact2Dtext4->ViewCustomAttributes = "";

			// google-map
			$this->google2Dmap->ViewValue = $this->google2Dmap->CurrentValue;
			$this->google2Dmap->ViewCustomAttributes = "";

			// fb-likebox
			$this->fb2Dlikebox->ViewValue = $this->fb2Dlikebox->CurrentValue;
			$this->fb2Dlikebox->ViewCustomAttributes = "";

			// top-l
			$this->top2Dl->LinkCustomAttributes = "";
			$this->top2Dl->HrefValue = "";
			$this->top2Dl->TooltipValue = "";

			// top-r
			$this->top2Dr->LinkCustomAttributes = "";
			$this->top2Dr->HrefValue = "";
			$this->top2Dr->TooltipValue = "";

			// head-l
			$this->head2Dl->LinkCustomAttributes = "";
			$this->head2Dl->HrefValue = "";
			$this->head2Dl->TooltipValue = "";

			// head-r
			$this->head2Dr->LinkCustomAttributes = "";
			$this->head2Dr->HrefValue = "";
			$this->head2Dr->TooltipValue = "";

			// slide1
			$this->slide1->LinkCustomAttributes = "";
			$this->slide1->UploadPath = "../images/slides/";
			if (!ew_Empty($this->slide1->Upload->DbValue)) {
				$this->slide1->HrefValue = ew_UploadPathEx(FALSE, $this->slide1->UploadPath) . $this->slide1->Upload->DbValue; // Add prefix/suffix
				$this->slide1->LinkAttrs["target"] = "_blank"; // Add target
				if ($this->Export <> "") $this->slide1->HrefValue = ew_ConvertFullUrl($this->slide1->HrefValue);
			} else {
				$this->slide1->HrefValue = "";
			}
			$this->slide1->HrefValue2 = $this->slide1->UploadPath . $this->slide1->Upload->DbValue;
			$this->slide1->TooltipValue = "";

			// slide2
			$this->slide2->LinkCustomAttributes = "";
			$this->slide2->UploadPath = "../images/slides/";
			if (!ew_Empty($this->slide2->Upload->DbValue)) {
				$this->slide2->HrefValue = ew_UploadPathEx(FALSE, $this->slide2->UploadPath) . $this->slide2->Upload->DbValue; // Add prefix/suffix
				$this->slide2->LinkAttrs["target"] = "_blank"; // Add target
				if ($this->Export <> "") $this->slide2->HrefValue = ew_ConvertFullUrl($this->slide2->HrefValue);
			} else {
				$this->slide2->HrefValue = "";
			}
			$this->slide2->HrefValue2 = $this->slide2->UploadPath . $this->slide2->Upload->DbValue;
			$this->slide2->TooltipValue = "";

			// slide3
			$this->slide3->LinkCustomAttributes = "";
			$this->slide3->UploadPath = "../images/slides/";
			if (!ew_Empty($this->slide3->Upload->DbValue)) {
				$this->slide3->HrefValue = ew_UploadPathEx(FALSE, $this->slide3->UploadPath) . $this->slide3->Upload->DbValue; // Add prefix/suffix
				$this->slide3->LinkAttrs["target"] = "_blank"; // Add target
				if ($this->Export <> "") $this->slide3->HrefValue = ew_ConvertFullUrl($this->slide3->HrefValue);
			} else {
				$this->slide3->HrefValue = "";
			}
			$this->slide3->HrefValue2 = $this->slide3->UploadPath . $this->slide3->Upload->DbValue;
			$this->slide3->TooltipValue = "";

			// slide4
			$this->slide4->LinkCustomAttributes = "";
			$this->slide4->UploadPath = "../images/slides/";
			if (!ew_Empty($this->slide4->Upload->DbValue)) {
				$this->slide4->HrefValue = ew_UploadPathEx(FALSE, $this->slide4->UploadPath) . $this->slide4->Upload->DbValue; // Add prefix/suffix
				$this->slide4->LinkAttrs["target"] = "_blank"; // Add target
				if ($this->Export <> "") $this->slide4->HrefValue = ew_ConvertFullUrl($this->slide4->HrefValue);
			} else {
				$this->slide4->HrefValue = "";
			}
			$this->slide4->HrefValue2 = $this->slide4->UploadPath . $this->slide4->Upload->DbValue;
			$this->slide4->TooltipValue = "";

			// slide5
			$this->slide5->LinkCustomAttributes = "";
			$this->slide5->UploadPath = "../images/slides/";
			if (!ew_Empty($this->slide5->Upload->DbValue)) {
				$this->slide5->HrefValue = ew_UploadPathEx(FALSE, $this->slide5->UploadPath) . $this->slide5->Upload->DbValue; // Add prefix/suffix
				$this->slide5->LinkAttrs["target"] = "_blank"; // Add target
				if ($this->Export <> "") $this->slide5->HrefValue = ew_ConvertFullUrl($this->slide5->HrefValue);
			} else {
				$this->slide5->HrefValue = "";
			}
			$this->slide5->HrefValue2 = $this->slide5->UploadPath . $this->slide5->Upload->DbValue;
			$this->slide5->TooltipValue = "";

			// slide6
			$this->slide6->LinkCustomAttributes = "";
			$this->slide6->UploadPath = "../images/slides/";
			if (!ew_Empty($this->slide6->Upload->DbValue)) {
				$this->slide6->HrefValue = ew_UploadPathEx(FALSE, $this->slide6->UploadPath) . $this->slide6->Upload->DbValue; // Add prefix/suffix
				$this->slide6->LinkAttrs["target"] = "_blank"; // Add target
				if ($this->Export <> "") $this->slide6->HrefValue = ew_ConvertFullUrl($this->slide6->HrefValue);
			} else {
				$this->slide6->HrefValue = "";
			}
			$this->slide6->HrefValue2 = $this->slide6->UploadPath . $this->slide6->Upload->DbValue;
			$this->slide6->TooltipValue = "";

			// home-caption1
			$this->home2Dcaption1->LinkCustomAttributes = "";
			$this->home2Dcaption1->HrefValue = "";
			$this->home2Dcaption1->TooltipValue = "";

			// home-caption2
			$this->home2Dcaption2->LinkCustomAttributes = "";
			$this->home2Dcaption2->HrefValue = "";
			$this->home2Dcaption2->TooltipValue = "";

			// home-caption3
			$this->home2Dcaption3->LinkCustomAttributes = "";
			$this->home2Dcaption3->HrefValue = "";
			$this->home2Dcaption3->TooltipValue = "";

			// home-caption4
			$this->home2Dcaption4->LinkCustomAttributes = "";
			$this->home2Dcaption4->HrefValue = "";
			$this->home2Dcaption4->TooltipValue = "";

			// home-caption5
			$this->home2Dcaption5->LinkCustomAttributes = "";
			$this->home2Dcaption5->HrefValue = "";
			$this->home2Dcaption5->TooltipValue = "";

			// home-caption6
			$this->home2Dcaption6->LinkCustomAttributes = "";
			$this->home2Dcaption6->HrefValue = "";
			$this->home2Dcaption6->TooltipValue = "";

			// home-text6
			$this->home2Dtext6->LinkCustomAttributes = "";
			$this->home2Dtext6->HrefValue = "";
			$this->home2Dtext6->TooltipValue = "";

			// footer-1
			$this->footer2D1->LinkCustomAttributes = "";
			$this->footer2D1->HrefValue = "";
			$this->footer2D1->TooltipValue = "";

			// footer-2
			$this->footer2D2->LinkCustomAttributes = "";
			$this->footer2D2->HrefValue = "";
			$this->footer2D2->TooltipValue = "";

			// footer-3
			$this->footer2D3->LinkCustomAttributes = "";
			$this->footer2D3->HrefValue = "";
			$this->footer2D3->TooltipValue = "";

			// footer-4
			$this->footer2D4->LinkCustomAttributes = "";
			$this->footer2D4->HrefValue = "";
			$this->footer2D4->TooltipValue = "";
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
				$this->slide1->OldUploadPath = "../images/slides/";
				@unlink(ew_UploadPathEx(TRUE, $this->slide1->OldUploadPath) . $row['slide1']);
				$this->slide2->OldUploadPath = "../images/slides/";
				@unlink(ew_UploadPathEx(TRUE, $this->slide2->OldUploadPath) . $row['slide2']);
				$this->slide3->OldUploadPath = "../images/slides/";
				@unlink(ew_UploadPathEx(TRUE, $this->slide3->OldUploadPath) . $row['slide3']);
				$this->slide4->OldUploadPath = "../images/slides/";
				@unlink(ew_UploadPathEx(TRUE, $this->slide4->OldUploadPath) . $row['slide4']);
				$this->slide5->OldUploadPath = "../images/slides/";
				@unlink(ew_UploadPathEx(TRUE, $this->slide5->OldUploadPath) . $row['slide5']);
				$this->slide6->OldUploadPath = "../images/slides/";
				@unlink(ew_UploadPathEx(TRUE, $this->slide6->OldUploadPath) . $row['slide6']);
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
		$Breadcrumb->Add("list", "<span id=\"ewPageCaption\">" . $PageCaption . "</span>", "layoutlist.php", $this->TableVar);
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
if (!isset($layout_delete)) $layout_delete = new clayout_delete();

// Page init
$layout_delete->Page_Init();

// Page main
$layout_delete->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$layout_delete->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Page object
var layout_delete = new ew_Page("layout_delete");
layout_delete.PageID = "delete"; // Page ID
var EW_PAGE_ID = layout_delete.PageID; // For backward compatibility

// Form object
var flayoutdelete = new ew_Form("flayoutdelete");

// Form_CustomValidate event
flayoutdelete.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
flayoutdelete.ValidateRequired = true;
<?php } else { ?>
flayoutdelete.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
// Form object for search

</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<?php

// Load records for display
if ($layout_delete->Recordset = $layout_delete->LoadRecordset())
	$layout_deleteTotalRecs = $layout_delete->Recordset->RecordCount(); // Get record count
if ($layout_deleteTotalRecs <= 0) { // No record found, exit
	if ($layout_delete->Recordset)
		$layout_delete->Recordset->Close();
	$layout_delete->Page_Terminate("layoutlist.php"); // Return to list
}
?>
<?php $Breadcrumb->Render(); ?>
<?php $layout_delete->ShowPageHeader(); ?>
<?php
$layout_delete->ShowMessage();
?>
<form name="flayoutdelete" id="flayoutdelete" class="ewForm form-horizontal" action="<?php echo ew_CurrentPage() ?>" method="post">
<input type="hidden" name="t" value="layout">
<input type="hidden" name="a_delete" id="a_delete" value="D">
<?php foreach ($layout_delete->RecKeys as $key) { ?>
<?php $keyvalue = is_array($key) ? implode($EW_COMPOSITE_KEY_SEPARATOR, $key) : $key; ?>
<input type="hidden" name="key_m[]" value="<?php echo ew_HtmlEncode($keyvalue) ?>">
<?php } ?>
<table cellspacing="0" class="ewGrid"><tr><td class="ewGridContent">
<div class="ewGridMiddlePanel">
<table id="tbl_layoutdelete" class="ewTable ewTableSeparate">
<?php echo $layout->TableCustomInnerHtml ?>
	<thead>
	<tr class="ewTableHeader">
<?php if ($layout->top2Dl->Visible) { // top-l ?>
		<td><span id="elh_layout_top2Dl" class="layout_top2Dl"><?php echo $layout->top2Dl->FldCaption() ?></span></td>
<?php } ?>
<?php if ($layout->top2Dr->Visible) { // top-r ?>
		<td><span id="elh_layout_top2Dr" class="layout_top2Dr"><?php echo $layout->top2Dr->FldCaption() ?></span></td>
<?php } ?>
<?php if ($layout->head2Dl->Visible) { // head-l ?>
		<td><span id="elh_layout_head2Dl" class="layout_head2Dl"><?php echo $layout->head2Dl->FldCaption() ?></span></td>
<?php } ?>
<?php if ($layout->head2Dr->Visible) { // head-r ?>
		<td><span id="elh_layout_head2Dr" class="layout_head2Dr"><?php echo $layout->head2Dr->FldCaption() ?></span></td>
<?php } ?>
<?php if ($layout->slide1->Visible) { // slide1 ?>
		<td><span id="elh_layout_slide1" class="layout_slide1"><?php echo $layout->slide1->FldCaption() ?></span></td>
<?php } ?>
<?php if ($layout->slide2->Visible) { // slide2 ?>
		<td><span id="elh_layout_slide2" class="layout_slide2"><?php echo $layout->slide2->FldCaption() ?></span></td>
<?php } ?>
<?php if ($layout->slide3->Visible) { // slide3 ?>
		<td><span id="elh_layout_slide3" class="layout_slide3"><?php echo $layout->slide3->FldCaption() ?></span></td>
<?php } ?>
<?php if ($layout->slide4->Visible) { // slide4 ?>
		<td><span id="elh_layout_slide4" class="layout_slide4"><?php echo $layout->slide4->FldCaption() ?></span></td>
<?php } ?>
<?php if ($layout->slide5->Visible) { // slide5 ?>
		<td><span id="elh_layout_slide5" class="layout_slide5"><?php echo $layout->slide5->FldCaption() ?></span></td>
<?php } ?>
<?php if ($layout->slide6->Visible) { // slide6 ?>
		<td><span id="elh_layout_slide6" class="layout_slide6"><?php echo $layout->slide6->FldCaption() ?></span></td>
<?php } ?>
<?php if ($layout->home2Dcaption1->Visible) { // home-caption1 ?>
		<td><span id="elh_layout_home2Dcaption1" class="layout_home2Dcaption1"><?php echo $layout->home2Dcaption1->FldCaption() ?></span></td>
<?php } ?>
<?php if ($layout->home2Dcaption2->Visible) { // home-caption2 ?>
		<td><span id="elh_layout_home2Dcaption2" class="layout_home2Dcaption2"><?php echo $layout->home2Dcaption2->FldCaption() ?></span></td>
<?php } ?>
<?php if ($layout->home2Dcaption3->Visible) { // home-caption3 ?>
		<td><span id="elh_layout_home2Dcaption3" class="layout_home2Dcaption3"><?php echo $layout->home2Dcaption3->FldCaption() ?></span></td>
<?php } ?>
<?php if ($layout->home2Dcaption4->Visible) { // home-caption4 ?>
		<td><span id="elh_layout_home2Dcaption4" class="layout_home2Dcaption4"><?php echo $layout->home2Dcaption4->FldCaption() ?></span></td>
<?php } ?>
<?php if ($layout->home2Dcaption5->Visible) { // home-caption5 ?>
		<td><span id="elh_layout_home2Dcaption5" class="layout_home2Dcaption5"><?php echo $layout->home2Dcaption5->FldCaption() ?></span></td>
<?php } ?>
<?php if ($layout->home2Dcaption6->Visible) { // home-caption6 ?>
		<td><span id="elh_layout_home2Dcaption6" class="layout_home2Dcaption6"><?php echo $layout->home2Dcaption6->FldCaption() ?></span></td>
<?php } ?>
<?php if ($layout->home2Dtext6->Visible) { // home-text6 ?>
		<td><span id="elh_layout_home2Dtext6" class="layout_home2Dtext6"><?php echo $layout->home2Dtext6->FldCaption() ?></span></td>
<?php } ?>
<?php if ($layout->footer2D1->Visible) { // footer-1 ?>
		<td><span id="elh_layout_footer2D1" class="layout_footer2D1"><?php echo $layout->footer2D1->FldCaption() ?></span></td>
<?php } ?>
<?php if ($layout->footer2D2->Visible) { // footer-2 ?>
		<td><span id="elh_layout_footer2D2" class="layout_footer2D2"><?php echo $layout->footer2D2->FldCaption() ?></span></td>
<?php } ?>
<?php if ($layout->footer2D3->Visible) { // footer-3 ?>
		<td><span id="elh_layout_footer2D3" class="layout_footer2D3"><?php echo $layout->footer2D3->FldCaption() ?></span></td>
<?php } ?>
<?php if ($layout->footer2D4->Visible) { // footer-4 ?>
		<td><span id="elh_layout_footer2D4" class="layout_footer2D4"><?php echo $layout->footer2D4->FldCaption() ?></span></td>
<?php } ?>
	</tr>
	</thead>
	<tbody>
<?php
$layout_delete->RecCnt = 0;
$i = 0;
while (!$layout_delete->Recordset->EOF) {
	$layout_delete->RecCnt++;
	$layout_delete->RowCnt++;

	// Set row properties
	$layout->ResetAttrs();
	$layout->RowType = EW_ROWTYPE_VIEW; // View

	// Get the field contents
	$layout_delete->LoadRowValues($layout_delete->Recordset);

	// Render row
	$layout_delete->RenderRow();
?>
	<tr<?php echo $layout->RowAttributes() ?>>
<?php if ($layout->top2Dl->Visible) { // top-l ?>
		<td<?php echo $layout->top2Dl->CellAttributes() ?>>
<span id="el<?php echo $layout_delete->RowCnt ?>_layout_top2Dl" class="control-group layout_top2Dl">
<span<?php echo $layout->top2Dl->ViewAttributes() ?>>
<?php echo $layout->top2Dl->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($layout->top2Dr->Visible) { // top-r ?>
		<td<?php echo $layout->top2Dr->CellAttributes() ?>>
<span id="el<?php echo $layout_delete->RowCnt ?>_layout_top2Dr" class="control-group layout_top2Dr">
<span<?php echo $layout->top2Dr->ViewAttributes() ?>>
<?php echo $layout->top2Dr->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($layout->head2Dl->Visible) { // head-l ?>
		<td<?php echo $layout->head2Dl->CellAttributes() ?>>
<span id="el<?php echo $layout_delete->RowCnt ?>_layout_head2Dl" class="control-group layout_head2Dl">
<span<?php echo $layout->head2Dl->ViewAttributes() ?>>
<?php echo $layout->head2Dl->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($layout->head2Dr->Visible) { // head-r ?>
		<td<?php echo $layout->head2Dr->CellAttributes() ?>>
<span id="el<?php echo $layout_delete->RowCnt ?>_layout_head2Dr" class="control-group layout_head2Dr">
<span<?php echo $layout->head2Dr->ViewAttributes() ?>>
<?php echo $layout->head2Dr->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($layout->slide1->Visible) { // slide1 ?>
		<td<?php echo $layout->slide1->CellAttributes() ?>>
<span id="el<?php echo $layout_delete->RowCnt ?>_layout_slide1" class="control-group layout_slide1">
<span<?php echo $layout->slide1->ViewAttributes() ?>>
<?php if ($layout->slide1->LinkAttributes() <> "") { ?>
<?php if (!empty($layout->slide1->Upload->DbValue)) { ?>
<a<?php echo $layout->slide1->LinkAttributes() ?>><?php echo $layout->slide1->ListViewValue() ?></a>
<?php } elseif (!in_array($layout->CurrentAction, array("I", "edit", "gridedit"))) { ?>	
&nbsp;
<?php } ?>
<?php } else { ?>
<?php if (!empty($layout->slide1->Upload->DbValue)) { ?>
<?php echo $layout->slide1->ListViewValue() ?>
<?php } elseif (!in_array($layout->CurrentAction, array("I", "edit", "gridedit"))) { ?>	
&nbsp;
<?php } ?>
<?php } ?>
</span>
</span>
</td>
<?php } ?>
<?php if ($layout->slide2->Visible) { // slide2 ?>
		<td<?php echo $layout->slide2->CellAttributes() ?>>
<span id="el<?php echo $layout_delete->RowCnt ?>_layout_slide2" class="control-group layout_slide2">
<span<?php echo $layout->slide2->ViewAttributes() ?>>
<?php if ($layout->slide2->LinkAttributes() <> "") { ?>
<?php if (!empty($layout->slide2->Upload->DbValue)) { ?>
<a<?php echo $layout->slide2->LinkAttributes() ?>><?php echo $layout->slide2->ListViewValue() ?></a>
<?php } elseif (!in_array($layout->CurrentAction, array("I", "edit", "gridedit"))) { ?>	
&nbsp;
<?php } ?>
<?php } else { ?>
<?php if (!empty($layout->slide2->Upload->DbValue)) { ?>
<?php echo $layout->slide2->ListViewValue() ?>
<?php } elseif (!in_array($layout->CurrentAction, array("I", "edit", "gridedit"))) { ?>	
&nbsp;
<?php } ?>
<?php } ?>
</span>
</span>
</td>
<?php } ?>
<?php if ($layout->slide3->Visible) { // slide3 ?>
		<td<?php echo $layout->slide3->CellAttributes() ?>>
<span id="el<?php echo $layout_delete->RowCnt ?>_layout_slide3" class="control-group layout_slide3">
<span<?php echo $layout->slide3->ViewAttributes() ?>>
<?php if ($layout->slide3->LinkAttributes() <> "") { ?>
<?php if (!empty($layout->slide3->Upload->DbValue)) { ?>
<a<?php echo $layout->slide3->LinkAttributes() ?>><?php echo $layout->slide3->ListViewValue() ?></a>
<?php } elseif (!in_array($layout->CurrentAction, array("I", "edit", "gridedit"))) { ?>	
&nbsp;
<?php } ?>
<?php } else { ?>
<?php if (!empty($layout->slide3->Upload->DbValue)) { ?>
<?php echo $layout->slide3->ListViewValue() ?>
<?php } elseif (!in_array($layout->CurrentAction, array("I", "edit", "gridedit"))) { ?>	
&nbsp;
<?php } ?>
<?php } ?>
</span>
</span>
</td>
<?php } ?>
<?php if ($layout->slide4->Visible) { // slide4 ?>
		<td<?php echo $layout->slide4->CellAttributes() ?>>
<span id="el<?php echo $layout_delete->RowCnt ?>_layout_slide4" class="control-group layout_slide4">
<span<?php echo $layout->slide4->ViewAttributes() ?>>
<?php if ($layout->slide4->LinkAttributes() <> "") { ?>
<?php if (!empty($layout->slide4->Upload->DbValue)) { ?>
<a<?php echo $layout->slide4->LinkAttributes() ?>><?php echo $layout->slide4->ListViewValue() ?></a>
<?php } elseif (!in_array($layout->CurrentAction, array("I", "edit", "gridedit"))) { ?>	
&nbsp;
<?php } ?>
<?php } else { ?>
<?php if (!empty($layout->slide4->Upload->DbValue)) { ?>
<?php echo $layout->slide4->ListViewValue() ?>
<?php } elseif (!in_array($layout->CurrentAction, array("I", "edit", "gridedit"))) { ?>	
&nbsp;
<?php } ?>
<?php } ?>
</span>
</span>
</td>
<?php } ?>
<?php if ($layout->slide5->Visible) { // slide5 ?>
		<td<?php echo $layout->slide5->CellAttributes() ?>>
<span id="el<?php echo $layout_delete->RowCnt ?>_layout_slide5" class="control-group layout_slide5">
<span<?php echo $layout->slide5->ViewAttributes() ?>>
<?php if ($layout->slide5->LinkAttributes() <> "") { ?>
<?php if (!empty($layout->slide5->Upload->DbValue)) { ?>
<a<?php echo $layout->slide5->LinkAttributes() ?>><?php echo $layout->slide5->ListViewValue() ?></a>
<?php } elseif (!in_array($layout->CurrentAction, array("I", "edit", "gridedit"))) { ?>	
&nbsp;
<?php } ?>
<?php } else { ?>
<?php if (!empty($layout->slide5->Upload->DbValue)) { ?>
<?php echo $layout->slide5->ListViewValue() ?>
<?php } elseif (!in_array($layout->CurrentAction, array("I", "edit", "gridedit"))) { ?>	
&nbsp;
<?php } ?>
<?php } ?>
</span>
</span>
</td>
<?php } ?>
<?php if ($layout->slide6->Visible) { // slide6 ?>
		<td<?php echo $layout->slide6->CellAttributes() ?>>
<span id="el<?php echo $layout_delete->RowCnt ?>_layout_slide6" class="control-group layout_slide6">
<span<?php echo $layout->slide6->ViewAttributes() ?>>
<?php if ($layout->slide6->LinkAttributes() <> "") { ?>
<?php if (!empty($layout->slide6->Upload->DbValue)) { ?>
<a<?php echo $layout->slide6->LinkAttributes() ?>><?php echo $layout->slide6->ListViewValue() ?></a>
<?php } elseif (!in_array($layout->CurrentAction, array("I", "edit", "gridedit"))) { ?>	
&nbsp;
<?php } ?>
<?php } else { ?>
<?php if (!empty($layout->slide6->Upload->DbValue)) { ?>
<?php echo $layout->slide6->ListViewValue() ?>
<?php } elseif (!in_array($layout->CurrentAction, array("I", "edit", "gridedit"))) { ?>	
&nbsp;
<?php } ?>
<?php } ?>
</span>
</span>
</td>
<?php } ?>
<?php if ($layout->home2Dcaption1->Visible) { // home-caption1 ?>
		<td<?php echo $layout->home2Dcaption1->CellAttributes() ?>>
<span id="el<?php echo $layout_delete->RowCnt ?>_layout_home2Dcaption1" class="control-group layout_home2Dcaption1">
<span<?php echo $layout->home2Dcaption1->ViewAttributes() ?>>
<?php echo $layout->home2Dcaption1->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($layout->home2Dcaption2->Visible) { // home-caption2 ?>
		<td<?php echo $layout->home2Dcaption2->CellAttributes() ?>>
<span id="el<?php echo $layout_delete->RowCnt ?>_layout_home2Dcaption2" class="control-group layout_home2Dcaption2">
<span<?php echo $layout->home2Dcaption2->ViewAttributes() ?>>
<?php echo $layout->home2Dcaption2->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($layout->home2Dcaption3->Visible) { // home-caption3 ?>
		<td<?php echo $layout->home2Dcaption3->CellAttributes() ?>>
<span id="el<?php echo $layout_delete->RowCnt ?>_layout_home2Dcaption3" class="control-group layout_home2Dcaption3">
<span<?php echo $layout->home2Dcaption3->ViewAttributes() ?>>
<?php echo $layout->home2Dcaption3->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($layout->home2Dcaption4->Visible) { // home-caption4 ?>
		<td<?php echo $layout->home2Dcaption4->CellAttributes() ?>>
<span id="el<?php echo $layout_delete->RowCnt ?>_layout_home2Dcaption4" class="control-group layout_home2Dcaption4">
<span<?php echo $layout->home2Dcaption4->ViewAttributes() ?>>
<?php echo $layout->home2Dcaption4->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($layout->home2Dcaption5->Visible) { // home-caption5 ?>
		<td<?php echo $layout->home2Dcaption5->CellAttributes() ?>>
<span id="el<?php echo $layout_delete->RowCnt ?>_layout_home2Dcaption5" class="control-group layout_home2Dcaption5">
<span<?php echo $layout->home2Dcaption5->ViewAttributes() ?>>
<?php echo $layout->home2Dcaption5->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($layout->home2Dcaption6->Visible) { // home-caption6 ?>
		<td<?php echo $layout->home2Dcaption6->CellAttributes() ?>>
<span id="el<?php echo $layout_delete->RowCnt ?>_layout_home2Dcaption6" class="control-group layout_home2Dcaption6">
<span<?php echo $layout->home2Dcaption6->ViewAttributes() ?>>
<?php echo $layout->home2Dcaption6->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($layout->home2Dtext6->Visible) { // home-text6 ?>
		<td<?php echo $layout->home2Dtext6->CellAttributes() ?>>
<span id="el<?php echo $layout_delete->RowCnt ?>_layout_home2Dtext6" class="control-group layout_home2Dtext6">
<span<?php echo $layout->home2Dtext6->ViewAttributes() ?>>
<?php echo $layout->home2Dtext6->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($layout->footer2D1->Visible) { // footer-1 ?>
		<td<?php echo $layout->footer2D1->CellAttributes() ?>>
<span id="el<?php echo $layout_delete->RowCnt ?>_layout_footer2D1" class="control-group layout_footer2D1">
<span<?php echo $layout->footer2D1->ViewAttributes() ?>>
<?php echo $layout->footer2D1->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($layout->footer2D2->Visible) { // footer-2 ?>
		<td<?php echo $layout->footer2D2->CellAttributes() ?>>
<span id="el<?php echo $layout_delete->RowCnt ?>_layout_footer2D2" class="control-group layout_footer2D2">
<span<?php echo $layout->footer2D2->ViewAttributes() ?>>
<?php echo $layout->footer2D2->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($layout->footer2D3->Visible) { // footer-3 ?>
		<td<?php echo $layout->footer2D3->CellAttributes() ?>>
<span id="el<?php echo $layout_delete->RowCnt ?>_layout_footer2D3" class="control-group layout_footer2D3">
<span<?php echo $layout->footer2D3->ViewAttributes() ?>>
<?php echo $layout->footer2D3->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($layout->footer2D4->Visible) { // footer-4 ?>
		<td<?php echo $layout->footer2D4->CellAttributes() ?>>
<span id="el<?php echo $layout_delete->RowCnt ?>_layout_footer2D4" class="control-group layout_footer2D4">
<span<?php echo $layout->footer2D4->ViewAttributes() ?>>
<?php echo $layout->footer2D4->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
	</tr>
<?php
	$layout_delete->Recordset->MoveNext();
}
$layout_delete->Recordset->Close();
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
flayoutdelete.Init();
</script>
<?php
$layout_delete->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$layout_delete->Page_Terminate();
?>
