<?php

// Global variable for table object
$layout = NULL;

//
// Table class for layout
//
class clayout extends cTable {
	var $id;
	var $logo;
	var $url;
	var $meta2Dtitle;
	var $meta2Dkeywords;
	var $meta2Ddescp;
	var $top2Dl;
	var $top2Dr;
	var $head2Dl;
	var $head2Dr;
	var $slide1;
	var $slide2;
	var $slide3;
	var $slide4;
	var $slide5;
	var $slide6;
	var $nav2Dtext;
	var $slide2Dbox;
	var $custom2Dcss;
	var $home2Dcaption1;
	var $home2Dtext1;
	var $home2Dcaption2;
	var $home2Dtext2;
	var $home2Dcaption3;
	var $home2Dtext3;
	var $home2Dcaption4;
	var $home2Dtext4;
	var $home2Dcaption5;
	var $home2Dtext5;
	var $home2Dcaption6;
	var $home2Dtext6;
	var $footer2D1;
	var $footer2D2;
	var $footer2D3;
	var $footer2D4;
	var $base2Dl;
	var $base2Dr;
	var $contact2Demail;
	var $contact2Dtext1;
	var $contact2Dtext2;
	var $contact2Dtext3;
	var $contact2Dtext4;
	var $google2Dmap;
	var $fb2Dlikebox;

	//
	// Table class constructor
	//
	function __construct() {
		global $Language;

		// Language object
		if (!isset($Language)) $Language = new cLanguage();
		$this->TableVar = 'layout';
		$this->TableName = 'layout';
		$this->TableType = 'TABLE';
		$this->ExportAll = TRUE;
		$this->ExportPageBreakCount = 0; // Page break per every n record (PDF only)
		$this->ExportPageOrientation = "portrait"; // Page orientation (PDF only)
		$this->ExportPageSize = "a4"; // Page size (PDF only)
		$this->DetailAdd = FALSE; // Allow detail add
		$this->DetailEdit = FALSE; // Allow detail edit
		$this->DetailView = FALSE; // Allow detail view
		$this->ShowMultipleDetails = FALSE; // Show multiple details
		$this->GridAddRowCount = 5;
		$this->AllowAddDeleteRow = ew_AllowAddDeleteRow(); // Allow add/delete row
		$this->UserIDAllowSecurity = 0; // User ID Allow
		$this->BasicSearch = new cBasicSearch($this->TableVar);

		// id
		$this->id = new cField('layout', 'layout', 'x_id', 'id', '`id`', '`id`', 3, -1, FALSE, '`id`', FALSE, FALSE, FALSE, 'IMAGE');
		$this->id->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['id'] = &$this->id;

		// logo
		$this->logo = new cField('layout', 'layout', 'x_logo', 'logo', '`logo`', '`logo`', 200, -1, FALSE, '`logo`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->fields['logo'] = &$this->logo;

		// url
		$this->url = new cField('layout', 'layout', 'x_url', 'url', '`url`', '`url`', 200, -1, FALSE, '`url`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->fields['url'] = &$this->url;

		// meta-title
		$this->meta2Dtitle = new cField('layout', 'layout', 'x_meta2Dtitle', 'meta-title', '`meta-title`', '`meta-title`', 200, -1, FALSE, '`meta-title`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->fields['meta-title'] = &$this->meta2Dtitle;

		// meta-keywords
		$this->meta2Dkeywords = new cField('layout', 'layout', 'x_meta2Dkeywords', 'meta-keywords', '`meta-keywords`', '`meta-keywords`', 200, -1, FALSE, '`meta-keywords`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->fields['meta-keywords'] = &$this->meta2Dkeywords;

		// meta-descp
		$this->meta2Ddescp = new cField('layout', 'layout', 'x_meta2Ddescp', 'meta-descp', '`meta-descp`', '`meta-descp`', 200, -1, FALSE, '`meta-descp`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->fields['meta-descp'] = &$this->meta2Ddescp;

		// top-l
		$this->top2Dl = new cField('layout', 'layout', 'x_top2Dl', 'top-l', '`top-l`', '`top-l`', 201, -1, FALSE, '`top-l`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->fields['top-l'] = &$this->top2Dl;

		// top-r
		$this->top2Dr = new cField('layout', 'layout', 'x_top2Dr', 'top-r', '`top-r`', '`top-r`', 201, -1, FALSE, '`top-r`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->fields['top-r'] = &$this->top2Dr;

		// head-l
		$this->head2Dl = new cField('layout', 'layout', 'x_head2Dl', 'head-l', '`head-l`', '`head-l`', 201, -1, FALSE, '`head-l`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->fields['head-l'] = &$this->head2Dl;

		// head-r
		$this->head2Dr = new cField('layout', 'layout', 'x_head2Dr', 'head-r', '`head-r`', '`head-r`', 201, -1, FALSE, '`head-r`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->fields['head-r'] = &$this->head2Dr;

		// slide1
		$this->slide1 = new cField('layout', 'layout', 'x_slide1', 'slide1', '`slide1`', '`slide1`', 200, -1, TRUE, '`slide1`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->fields['slide1'] = &$this->slide1;

		// slide2
		$this->slide2 = new cField('layout', 'layout', 'x_slide2', 'slide2', '`slide2`', '`slide2`', 200, -1, TRUE, '`slide2`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->fields['slide2'] = &$this->slide2;

		// slide3
		$this->slide3 = new cField('layout', 'layout', 'x_slide3', 'slide3', '`slide3`', '`slide3`', 200, -1, TRUE, '`slide3`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->fields['slide3'] = &$this->slide3;

		// slide4
		$this->slide4 = new cField('layout', 'layout', 'x_slide4', 'slide4', '`slide4`', '`slide4`', 200, -1, TRUE, '`slide4`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->fields['slide4'] = &$this->slide4;

		// slide5
		$this->slide5 = new cField('layout', 'layout', 'x_slide5', 'slide5', '`slide5`', '`slide5`', 200, -1, TRUE, '`slide5`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->fields['slide5'] = &$this->slide5;

		// slide6
		$this->slide6 = new cField('layout', 'layout', 'x_slide6', 'slide6', '`slide6`', '`slide6`', 200, -1, TRUE, '`slide6`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->fields['slide6'] = &$this->slide6;

		// nav-text
		$this->nav2Dtext = new cField('layout', 'layout', 'x_nav2Dtext', 'nav-text', '`nav-text`', '`nav-text`', 201, -1, FALSE, '`nav-text`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->fields['nav-text'] = &$this->nav2Dtext;

		// slide-box
		$this->slide2Dbox = new cField('layout', 'layout', 'x_slide2Dbox', 'slide-box', '`slide-box`', '`slide-box`', 201, -1, FALSE, '`slide-box`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->fields['slide-box'] = &$this->slide2Dbox;

		// custom-css
		$this->custom2Dcss = new cField('layout', 'layout', 'x_custom2Dcss', 'custom-css', '`custom-css`', '`custom-css`', 201, -1, FALSE, '`custom-css`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->fields['custom-css'] = &$this->custom2Dcss;

		// home-caption1
		$this->home2Dcaption1 = new cField('layout', 'layout', 'x_home2Dcaption1', 'home-caption1', '`home-caption1`', '`home-caption1`', 200, -1, FALSE, '`home-caption1`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->fields['home-caption1'] = &$this->home2Dcaption1;

		// home-text1
		$this->home2Dtext1 = new cField('layout', 'layout', 'x_home2Dtext1', 'home-text1', '`home-text1`', '`home-text1`', 201, -1, FALSE, '`home-text1`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->fields['home-text1'] = &$this->home2Dtext1;

		// home-caption2
		$this->home2Dcaption2 = new cField('layout', 'layout', 'x_home2Dcaption2', 'home-caption2', '`home-caption2`', '`home-caption2`', 200, -1, FALSE, '`home-caption2`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->fields['home-caption2'] = &$this->home2Dcaption2;

		// home-text2
		$this->home2Dtext2 = new cField('layout', 'layout', 'x_home2Dtext2', 'home-text2', '`home-text2`', '`home-text2`', 201, -1, FALSE, '`home-text2`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->fields['home-text2'] = &$this->home2Dtext2;

		// home-caption3
		$this->home2Dcaption3 = new cField('layout', 'layout', 'x_home2Dcaption3', 'home-caption3', '`home-caption3`', '`home-caption3`', 200, -1, FALSE, '`home-caption3`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->fields['home-caption3'] = &$this->home2Dcaption3;

		// home-text3
		$this->home2Dtext3 = new cField('layout', 'layout', 'x_home2Dtext3', 'home-text3', '`home-text3`', '`home-text3`', 201, -1, FALSE, '`home-text3`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->fields['home-text3'] = &$this->home2Dtext3;

		// home-caption4
		$this->home2Dcaption4 = new cField('layout', 'layout', 'x_home2Dcaption4', 'home-caption4', '`home-caption4`', '`home-caption4`', 201, -1, FALSE, '`home-caption4`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->fields['home-caption4'] = &$this->home2Dcaption4;

		// home-text4
		$this->home2Dtext4 = new cField('layout', 'layout', 'x_home2Dtext4', 'home-text4', '`home-text4`', '`home-text4`', 201, -1, FALSE, '`home-text4`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->fields['home-text4'] = &$this->home2Dtext4;

		// home-caption5
		$this->home2Dcaption5 = new cField('layout', 'layout', 'x_home2Dcaption5', 'home-caption5', '`home-caption5`', '`home-caption5`', 200, -1, FALSE, '`home-caption5`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->fields['home-caption5'] = &$this->home2Dcaption5;

		// home-text5
		$this->home2Dtext5 = new cField('layout', 'layout', 'x_home2Dtext5', 'home-text5', '`home-text5`', '`home-text5`', 201, -1, FALSE, '`home-text5`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->fields['home-text5'] = &$this->home2Dtext5;

		// home-caption6
		$this->home2Dcaption6 = new cField('layout', 'layout', 'x_home2Dcaption6', 'home-caption6', '`home-caption6`', '`home-caption6`', 200, -1, FALSE, '`home-caption6`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->fields['home-caption6'] = &$this->home2Dcaption6;

		// home-text6
		$this->home2Dtext6 = new cField('layout', 'layout', 'x_home2Dtext6', 'home-text6', '`home-text6`', '`home-text6`', 201, -1, FALSE, '`home-text6`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->home2Dtext6->FldDefaultErrMsg = $Language->Phrase("IncorrectTime");
		$this->fields['home-text6'] = &$this->home2Dtext6;

		// footer-1
		$this->footer2D1 = new cField('layout', 'layout', 'x_footer2D1', 'footer-1', '`footer-1`', '`footer-1`', 201, -1, FALSE, '`footer-1`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->fields['footer-1'] = &$this->footer2D1;

		// footer-2
		$this->footer2D2 = new cField('layout', 'layout', 'x_footer2D2', 'footer-2', '`footer-2`', '`footer-2`', 201, -1, FALSE, '`footer-2`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->fields['footer-2'] = &$this->footer2D2;

		// footer-3
		$this->footer2D3 = new cField('layout', 'layout', 'x_footer2D3', 'footer-3', '`footer-3`', '`footer-3`', 201, -1, FALSE, '`footer-3`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->fields['footer-3'] = &$this->footer2D3;

		// footer-4
		$this->footer2D4 = new cField('layout', 'layout', 'x_footer2D4', 'footer-4', '`footer-4`', '`footer-4`', 201, -1, FALSE, '`footer-4`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->fields['footer-4'] = &$this->footer2D4;

		// base-l
		$this->base2Dl = new cField('layout', 'layout', 'x_base2Dl', 'base-l', '`base-l`', '`base-l`', 200, -1, FALSE, '`base-l`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->fields['base-l'] = &$this->base2Dl;

		// base-r
		$this->base2Dr = new cField('layout', 'layout', 'x_base2Dr', 'base-r', '`base-r`', '`base-r`', 200, -1, FALSE, '`base-r`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->fields['base-r'] = &$this->base2Dr;

		// contact-email
		$this->contact2Demail = new cField('layout', 'layout', 'x_contact2Demail', 'contact-email', '`contact-email`', '`contact-email`', 200, -1, FALSE, '`contact-email`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->fields['contact-email'] = &$this->contact2Demail;

		// contact-text1
		$this->contact2Dtext1 = new cField('layout', 'layout', 'x_contact2Dtext1', 'contact-text1', '`contact-text1`', '`contact-text1`', 201, -1, FALSE, '`contact-text1`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->fields['contact-text1'] = &$this->contact2Dtext1;

		// contact-text2
		$this->contact2Dtext2 = new cField('layout', 'layout', 'x_contact2Dtext2', 'contact-text2', '`contact-text2`', '`contact-text2`', 201, -1, FALSE, '`contact-text2`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->fields['contact-text2'] = &$this->contact2Dtext2;

		// contact-text3
		$this->contact2Dtext3 = new cField('layout', 'layout', 'x_contact2Dtext3', 'contact-text3', '`contact-text3`', '`contact-text3`', 201, -1, FALSE, '`contact-text3`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->fields['contact-text3'] = &$this->contact2Dtext3;

		// contact-text4
		$this->contact2Dtext4 = new cField('layout', 'layout', 'x_contact2Dtext4', 'contact-text4', '`contact-text4`', '`contact-text4`', 201, -1, FALSE, '`contact-text4`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->fields['contact-text4'] = &$this->contact2Dtext4;

		// google-map
		$this->google2Dmap = new cField('layout', 'layout', 'x_google2Dmap', 'google-map', '`google-map`', '`google-map`', 201, -1, FALSE, '`google-map`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->fields['google-map'] = &$this->google2Dmap;

		// fb-likebox
		$this->fb2Dlikebox = new cField('layout', 'layout', 'x_fb2Dlikebox', 'fb-likebox', '`fb-likebox`', '`fb-likebox`', 201, -1, FALSE, '`fb-likebox`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->fields['fb-likebox'] = &$this->fb2Dlikebox;
	}

	// Multiple column sort
	function UpdateSort(&$ofld, $ctrl) {
		if ($this->CurrentOrder == $ofld->FldName) {
			$sSortField = $ofld->FldExpression;
			$sLastSort = $ofld->getSort();
			if ($this->CurrentOrderType == "ASC" || $this->CurrentOrderType == "DESC") {
				$sThisSort = $this->CurrentOrderType;
			} else {
				$sThisSort = ($sLastSort == "ASC") ? "DESC" : "ASC";
			}
			$ofld->setSort($sThisSort);
			if ($ctrl) {
				$sOrderBy = $this->getSessionOrderBy();
				if (strpos($sOrderBy, $sSortField . " " . $sLastSort) !== FALSE) {
					$sOrderBy = str_replace($sSortField . " " . $sLastSort, $sSortField . " " . $sThisSort, $sOrderBy);
				} else {
					if ($sOrderBy <> "") $sOrderBy .= ", ";
					$sOrderBy .= $sSortField . " " . $sThisSort;
				}
				$this->setSessionOrderBy($sOrderBy); // Save to Session
			} else {
				$this->setSessionOrderBy($sSortField . " " . $sThisSort); // Save to Session
			}
		} else {
			if (!$ctrl) $ofld->setSort("");
		}
	}

	// Table level SQL
	function SqlFrom() { // From
		return "`layout`";
	}

	function SqlSelect() { // Select
		return "SELECT * FROM " . $this->SqlFrom();
	}

	function SqlWhere() { // Where
		$sWhere = "";
		$this->TableFilter = "";
		ew_AddFilter($sWhere, $this->TableFilter);
		return $sWhere;
	}

	function SqlGroupBy() { // Group By
		return "";
	}

	function SqlHaving() { // Having
		return "";
	}

	function SqlOrderBy() { // Order By
		return "";
	}

	// Check if Anonymous User is allowed
	function AllowAnonymousUser() {
		switch (@$this->PageID) {
			case "add":
			case "register":
			case "addopt":
				return FALSE;
			case "edit":
			case "update":
			case "changepwd":
			case "forgotpwd":
				return FALSE;
			case "delete":
				return FALSE;
			case "view":
				return FALSE;
			case "search":
				return FALSE;
			default:
				return FALSE;
		}
	}

	// Apply User ID filters
	function ApplyUserIDFilters($sFilter) {
		return $sFilter;
	}

	// Check if User ID security allows view all
	function UserIDAllow($id = "") {
		$allow = EW_USER_ID_ALLOW;
		switch ($id) {
			case "add":
			case "copy":
			case "gridadd":
			case "register":
			case "addopt":
				return (($allow & 1) == 1);
			case "edit":
			case "gridedit":
			case "update":
			case "changepwd":
			case "forgotpwd":
				return (($allow & 4) == 4);
			case "delete":
				return (($allow & 2) == 2);
			case "view":
				return (($allow & 32) == 32);
			case "search":
				return (($allow & 64) == 64);
			default:
				return (($allow & 8) == 8);
		}
	}

	// Get SQL
	function GetSQL($where, $orderby) {
		return ew_BuildSelectSql($this->SqlSelect(), $this->SqlWhere(),
			$this->SqlGroupBy(), $this->SqlHaving(), $this->SqlOrderBy(),
			$where, $orderby);
	}

	// Table SQL
	function SQL() {
		$sFilter = $this->CurrentFilter;
		$sFilter = $this->ApplyUserIDFilters($sFilter);
		$sSort = $this->getSessionOrderBy();
		return ew_BuildSelectSql($this->SqlSelect(), $this->SqlWhere(),
			$this->SqlGroupBy(), $this->SqlHaving(), $this->SqlOrderBy(),
			$sFilter, $sSort);
	}

	// Table SQL with List page filter
	function SelectSQL() {
		$sFilter = $this->getSessionWhere();
		ew_AddFilter($sFilter, $this->CurrentFilter);
		$sFilter = $this->ApplyUserIDFilters($sFilter);
		$sSort = $this->getSessionOrderBy();
		return ew_BuildSelectSql($this->SqlSelect(), $this->SqlWhere(), $this->SqlGroupBy(),
			$this->SqlHaving(), $this->SqlOrderBy(), $sFilter, $sSort);
	}

	// Get ORDER BY clause
	function GetOrderBy() {
		$sSort = $this->getSessionOrderBy();
		return ew_BuildSelectSql("", "", "", "", $this->SqlOrderBy(), "", $sSort);
	}

	// Try to get record count
	function TryGetRecordCount($sSql) {
		global $conn;
		$cnt = -1;
		if ($this->TableType == 'TABLE' || $this->TableType == 'VIEW') {
			$sSql = "SELECT COUNT(*) FROM" . substr($sSql, 13);
			$sOrderBy = $this->GetOrderBy();
			if (substr($sSql, strlen($sOrderBy) * -1) == $sOrderBy)
				$sSql = substr($sSql, 0, strlen($sSql) - strlen($sOrderBy)); // Remove ORDER BY clause
		} else {
			$sSql = "SELECT COUNT(*) FROM (" . $sSql . ") EW_COUNT_TABLE";
		}
		if ($rs = $conn->Execute($sSql)) {
			if (!$rs->EOF && $rs->FieldCount() > 0) {
				$cnt = $rs->fields[0];
				$rs->Close();
			}
		}
		return intval($cnt);
	}

	// Get record count based on filter (for detail record count in master table pages)
	function LoadRecordCount($sFilter) {
		$origFilter = $this->CurrentFilter;
		$this->CurrentFilter = $sFilter;
		$this->Recordset_Selecting($this->CurrentFilter);

		//$sSql = $this->SQL();
		$sSql = $this->GetSQL($this->CurrentFilter, "");
		$cnt = $this->TryGetRecordCount($sSql);
		if ($cnt == -1) {
			if ($rs = $this->LoadRs($this->CurrentFilter)) {
				$cnt = $rs->RecordCount();
				$rs->Close();
			}
		}
		$this->CurrentFilter = $origFilter;
		return intval($cnt);
	}

	// Get record count (for current List page)
	function SelectRecordCount() {
		global $conn;
		$origFilter = $this->CurrentFilter;
		$this->Recordset_Selecting($this->CurrentFilter);
		$sSql = $this->SelectSQL();
		$cnt = $this->TryGetRecordCount($sSql);
		if ($cnt == -1) {
			if ($rs = $conn->Execute($sSql)) {
				$cnt = $rs->RecordCount();
				$rs->Close();
			}
		}
		$this->CurrentFilter = $origFilter;
		return intval($cnt);
	}

	// Update Table
	var $UpdateTable = "`layout`";

	// INSERT statement
	function InsertSQL(&$rs) {
		global $conn;
		$names = "";
		$values = "";
		foreach ($rs as $name => $value) {
			if (!isset($this->fields[$name]))
				continue;
			$names .= $this->fields[$name]->FldExpression . ",";
			$values .= ew_QuotedValue($value, $this->fields[$name]->FldDataType) . ",";
		}
		while (substr($names, -1) == ",")
			$names = substr($names, 0, -1);
		while (substr($values, -1) == ",")
			$values = substr($values, 0, -1);
		return "INSERT INTO " . $this->UpdateTable . " ($names) VALUES ($values)";
	}

	// Insert
	function Insert(&$rs) {
		global $conn;
		return $conn->Execute($this->InsertSQL($rs));
	}

	// UPDATE statement
	function UpdateSQL(&$rs, $where = "") {
		$sql = "UPDATE " . $this->UpdateTable . " SET ";
		foreach ($rs as $name => $value) {
			if (!isset($this->fields[$name]))
				continue;
			$sql .= $this->fields[$name]->FldExpression . "=";
			$sql .= ew_QuotedValue($value, $this->fields[$name]->FldDataType) . ",";
		}
		while (substr($sql, -1) == ",")
			$sql = substr($sql, 0, -1);
		$filter = $this->CurrentFilter;
		ew_AddFilter($filter, $where);
		if ($filter <> "")	$sql .= " WHERE " . $filter;
		return $sql;
	}

	// Update
	function Update(&$rs, $where = "", $rsold = NULL) {
		global $conn;
		return $conn->Execute($this->UpdateSQL($rs, $where));
	}

	// DELETE statement
	function DeleteSQL(&$rs, $where = "") {
		$sql = "DELETE FROM " . $this->UpdateTable . " WHERE ";
		if ($rs) {
			if (array_key_exists('id', $rs))
				ew_AddFilter($where, ew_QuotedName('id') . '=' . ew_QuotedValue($rs['id'], $this->id->FldDataType));
		}
		$filter = $this->CurrentFilter;
		ew_AddFilter($filter, $where);
		if ($filter <> "")
			$sql .= $filter;
		else
			$sql .= "0=1"; // Avoid delete
		return $sql;
	}

	// Delete
	function Delete(&$rs, $where = "") {
		global $conn;
		return $conn->Execute($this->DeleteSQL($rs, $where));
	}

	// Key filter WHERE clause
	function SqlKeyFilter() {
		return "`id` = @id@";
	}

	// Key filter
	function KeyFilter() {
		$sKeyFilter = $this->SqlKeyFilter();
		if (!is_numeric($this->id->CurrentValue))
			$sKeyFilter = "0=1"; // Invalid key
		$sKeyFilter = str_replace("@id@", ew_AdjustSql($this->id->CurrentValue), $sKeyFilter); // Replace key value
		return $sKeyFilter;
	}

	// Return page URL
	function getReturnUrl() {
		$name = EW_PROJECT_NAME . "_" . $this->TableVar . "_" . EW_TABLE_RETURN_URL;

		// Get referer URL automatically
		if (ew_ServerVar("HTTP_REFERER") <> "" && ew_ReferPage() <> ew_CurrentPage() && ew_ReferPage() <> "login.php") // Referer not same page or login page
			$_SESSION[$name] = ew_ServerVar("HTTP_REFERER"); // Save to Session
		if (@$_SESSION[$name] <> "") {
			return $_SESSION[$name];
		} else {
			return "layoutlist.php";
		}
	}

	function setReturnUrl($v) {
		$_SESSION[EW_PROJECT_NAME . "_" . $this->TableVar . "_" . EW_TABLE_RETURN_URL] = $v;
	}

	// List URL
	function GetListUrl() {
		return "layoutlist.php";
	}

	// View URL
	function GetViewUrl($parm = "") {
		if ($parm <> "")
			return $this->KeyUrl("layoutview.php", $this->UrlParm($parm));
		else
			return $this->KeyUrl("layoutview.php", $this->UrlParm(EW_TABLE_SHOW_DETAIL . "="));
	}

	// Add URL
	function GetAddUrl() {
		return "layoutadd.php";
	}

	// Edit URL
	function GetEditUrl($parm = "") {
		return $this->KeyUrl("layoutedit.php", $this->UrlParm($parm));
	}

	// Inline edit URL
	function GetInlineEditUrl() {
		return $this->KeyUrl(ew_CurrentPage(), $this->UrlParm("a=edit"));
	}

	// Copy URL
	function GetCopyUrl($parm = "") {
		return $this->KeyUrl("layoutadd.php", $this->UrlParm($parm));
	}

	// Inline copy URL
	function GetInlineCopyUrl() {
		return $this->KeyUrl(ew_CurrentPage(), $this->UrlParm("a=copy"));
	}

	// Delete URL
	function GetDeleteUrl() {
		return $this->KeyUrl("layoutdelete.php", $this->UrlParm());
	}

	// Add key value to URL
	function KeyUrl($url, $parm = "") {
		$sUrl = $url . "?";
		if ($parm <> "") $sUrl .= $parm . "&";
		if (!is_null($this->id->CurrentValue)) {
			$sUrl .= "id=" . urlencode($this->id->CurrentValue);
		} else {
			return "javascript:alert(ewLanguage.Phrase('InvalidRecord'));";
		}
		return $sUrl;
	}

	// Sort URL
	function SortUrl(&$fld) {
		if ($this->CurrentAction <> "" || $this->Export <> "" ||
			in_array($fld->FldType, array(128, 204, 205))) { // Unsortable data type
				return "";
		} elseif ($fld->Sortable) {
			$sUrlParm = $this->UrlParm("order=" . urlencode($fld->FldName) . "&ordertype=" . $fld->ReverseSort());
			return ew_CurrentPage() . "?" . $sUrlParm;
		} else {
			return "";
		}
	}

	// Get record keys from $_POST/$_GET/$_SESSION
	function GetRecordKeys() {
		global $EW_COMPOSITE_KEY_SEPARATOR;
		$arKeys = array();
		$arKey = array();
		if (isset($_POST["key_m"])) {
			$arKeys = ew_StripSlashes($_POST["key_m"]);
			$cnt = count($arKeys);
		} elseif (isset($_GET["key_m"])) {
			$arKeys = ew_StripSlashes($_GET["key_m"]);
			$cnt = count($arKeys);
		} elseif (isset($_GET)) {
			$arKeys[] = @$_GET["id"]; // id

			//return $arKeys; // Do not return yet, so the values will also be checked by the following code
		}

		// Check keys
		$ar = array();
		foreach ($arKeys as $key) {
			if (!is_numeric($key))
				continue;
			$ar[] = $key;
		}
		return $ar;
	}

	// Get key filter
	function GetKeyFilter() {
		$arKeys = $this->GetRecordKeys();
		$sKeyFilter = "";
		foreach ($arKeys as $key) {
			if ($sKeyFilter <> "") $sKeyFilter .= " OR ";
			$this->id->CurrentValue = $key;
			$sKeyFilter .= "(" . $this->KeyFilter() . ")";
		}
		return $sKeyFilter;
	}

	// Load rows based on filter
	function &LoadRs($sFilter) {
		global $conn;

		// Set up filter (SQL WHERE clause) and get return SQL
		//$this->CurrentFilter = $sFilter;
		//$sSql = $this->SQL();

		$sSql = $this->GetSQL($sFilter, "");
		$rs = $conn->Execute($sSql);
		return $rs;
	}

	// Load row values from recordset
	function LoadListRowValues(&$rs) {
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

	// Render list row values
	function RenderListRow() {
		global $conn, $Security;

		// Call Row Rendering event
		$this->Row_Rendering();

   // Common render codes
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

		// id
		$this->id->LinkCustomAttributes = "";
		$this->id->HrefValue = "";
		$this->id->TooltipValue = "";

		// logo
		$this->logo->LinkCustomAttributes = "";
		$this->logo->HrefValue = "";
		$this->logo->TooltipValue = "";

		// url
		$this->url->LinkCustomAttributes = "";
		$this->url->HrefValue = "";
		$this->url->TooltipValue = "";

		// meta-title
		$this->meta2Dtitle->LinkCustomAttributes = "";
		$this->meta2Dtitle->HrefValue = "";
		$this->meta2Dtitle->TooltipValue = "";

		// meta-keywords
		$this->meta2Dkeywords->LinkCustomAttributes = "";
		$this->meta2Dkeywords->HrefValue = "";
		$this->meta2Dkeywords->TooltipValue = "";

		// meta-descp
		$this->meta2Ddescp->LinkCustomAttributes = "";
		$this->meta2Ddescp->HrefValue = "";
		$this->meta2Ddescp->TooltipValue = "";

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

		// nav-text
		$this->nav2Dtext->LinkCustomAttributes = "";
		$this->nav2Dtext->HrefValue = "";
		$this->nav2Dtext->TooltipValue = "";

		// slide-box
		$this->slide2Dbox->LinkCustomAttributes = "";
		$this->slide2Dbox->HrefValue = "";
		$this->slide2Dbox->TooltipValue = "";

		// custom-css
		$this->custom2Dcss->LinkCustomAttributes = "";
		$this->custom2Dcss->HrefValue = "";
		$this->custom2Dcss->TooltipValue = "";

		// home-caption1
		$this->home2Dcaption1->LinkCustomAttributes = "";
		$this->home2Dcaption1->HrefValue = "";
		$this->home2Dcaption1->TooltipValue = "";

		// home-text1
		$this->home2Dtext1->LinkCustomAttributes = "";
		$this->home2Dtext1->HrefValue = "";
		$this->home2Dtext1->TooltipValue = "";

		// home-caption2
		$this->home2Dcaption2->LinkCustomAttributes = "";
		$this->home2Dcaption2->HrefValue = "";
		$this->home2Dcaption2->TooltipValue = "";

		// home-text2
		$this->home2Dtext2->LinkCustomAttributes = "";
		$this->home2Dtext2->HrefValue = "";
		$this->home2Dtext2->TooltipValue = "";

		// home-caption3
		$this->home2Dcaption3->LinkCustomAttributes = "";
		$this->home2Dcaption3->HrefValue = "";
		$this->home2Dcaption3->TooltipValue = "";

		// home-text3
		$this->home2Dtext3->LinkCustomAttributes = "";
		$this->home2Dtext3->HrefValue = "";
		$this->home2Dtext3->TooltipValue = "";

		// home-caption4
		$this->home2Dcaption4->LinkCustomAttributes = "";
		$this->home2Dcaption4->HrefValue = "";
		$this->home2Dcaption4->TooltipValue = "";

		// home-text4
		$this->home2Dtext4->LinkCustomAttributes = "";
		$this->home2Dtext4->HrefValue = "";
		$this->home2Dtext4->TooltipValue = "";

		// home-caption5
		$this->home2Dcaption5->LinkCustomAttributes = "";
		$this->home2Dcaption5->HrefValue = "";
		$this->home2Dcaption5->TooltipValue = "";

		// home-text5
		$this->home2Dtext5->LinkCustomAttributes = "";
		$this->home2Dtext5->HrefValue = "";
		$this->home2Dtext5->TooltipValue = "";

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

		// base-l
		$this->base2Dl->LinkCustomAttributes = "";
		$this->base2Dl->HrefValue = "";
		$this->base2Dl->TooltipValue = "";

		// base-r
		$this->base2Dr->LinkCustomAttributes = "";
		$this->base2Dr->HrefValue = "";
		$this->base2Dr->TooltipValue = "";

		// contact-email
		$this->contact2Demail->LinkCustomAttributes = "";
		$this->contact2Demail->HrefValue = "";
		$this->contact2Demail->TooltipValue = "";

		// contact-text1
		$this->contact2Dtext1->LinkCustomAttributes = "";
		$this->contact2Dtext1->HrefValue = "";
		$this->contact2Dtext1->TooltipValue = "";

		// contact-text2
		$this->contact2Dtext2->LinkCustomAttributes = "";
		$this->contact2Dtext2->HrefValue = "";
		$this->contact2Dtext2->TooltipValue = "";

		// contact-text3
		$this->contact2Dtext3->LinkCustomAttributes = "";
		$this->contact2Dtext3->HrefValue = "";
		$this->contact2Dtext3->TooltipValue = "";

		// contact-text4
		$this->contact2Dtext4->LinkCustomAttributes = "";
		$this->contact2Dtext4->HrefValue = "";
		$this->contact2Dtext4->TooltipValue = "";

		// google-map
		$this->google2Dmap->LinkCustomAttributes = "";
		$this->google2Dmap->HrefValue = "";
		$this->google2Dmap->TooltipValue = "";

		// fb-likebox
		$this->fb2Dlikebox->LinkCustomAttributes = "";
		$this->fb2Dlikebox->HrefValue = "";
		$this->fb2Dlikebox->TooltipValue = "";

		// Call Row Rendered event
		$this->Row_Rendered();
	}

	// Aggregate list row values
	function AggregateListRowValues() {
	}

	// Aggregate list row (for rendering)
	function AggregateListRow() {
	}

	// Export data in HTML/CSV/Word/Excel/Email/PDF format
	function ExportDocument(&$Doc, &$Recordset, $StartRec, $StopRec, $ExportPageType = "") {
		if (!$Recordset || !$Doc)
			return;

		// Write header
		$Doc->ExportTableHeader();
		if ($Doc->Horizontal) { // Horizontal format, write header
			$Doc->BeginExportRow();
			if ($ExportPageType == "view") {
				if ($this->id->Exportable) $Doc->ExportCaption($this->id);
				if ($this->top2Dl->Exportable) $Doc->ExportCaption($this->top2Dl);
				if ($this->top2Dr->Exportable) $Doc->ExportCaption($this->top2Dr);
				if ($this->head2Dl->Exportable) $Doc->ExportCaption($this->head2Dl);
				if ($this->head2Dr->Exportable) $Doc->ExportCaption($this->head2Dr);
				if ($this->slide1->Exportable) $Doc->ExportCaption($this->slide1);
				if ($this->slide2->Exportable) $Doc->ExportCaption($this->slide2);
				if ($this->slide3->Exportable) $Doc->ExportCaption($this->slide3);
				if ($this->slide4->Exportable) $Doc->ExportCaption($this->slide4);
				if ($this->slide5->Exportable) $Doc->ExportCaption($this->slide5);
				if ($this->slide6->Exportable) $Doc->ExportCaption($this->slide6);
				if ($this->home2Dcaption1->Exportable) $Doc->ExportCaption($this->home2Dcaption1);
				if ($this->home2Dtext1->Exportable) $Doc->ExportCaption($this->home2Dtext1);
				if ($this->home2Dcaption2->Exportable) $Doc->ExportCaption($this->home2Dcaption2);
				if ($this->home2Dtext2->Exportable) $Doc->ExportCaption($this->home2Dtext2);
				if ($this->home2Dcaption3->Exportable) $Doc->ExportCaption($this->home2Dcaption3);
				if ($this->home2Dtext3->Exportable) $Doc->ExportCaption($this->home2Dtext3);
				if ($this->home2Dcaption4->Exportable) $Doc->ExportCaption($this->home2Dcaption4);
				if ($this->home2Dtext4->Exportable) $Doc->ExportCaption($this->home2Dtext4);
				if ($this->home2Dcaption5->Exportable) $Doc->ExportCaption($this->home2Dcaption5);
				if ($this->home2Dtext5->Exportable) $Doc->ExportCaption($this->home2Dtext5);
				if ($this->home2Dcaption6->Exportable) $Doc->ExportCaption($this->home2Dcaption6);
				if ($this->home2Dtext6->Exportable) $Doc->ExportCaption($this->home2Dtext6);
				if ($this->footer2D1->Exportable) $Doc->ExportCaption($this->footer2D1);
				if ($this->footer2D2->Exportable) $Doc->ExportCaption($this->footer2D2);
				if ($this->footer2D3->Exportable) $Doc->ExportCaption($this->footer2D3);
				if ($this->footer2D4->Exportable) $Doc->ExportCaption($this->footer2D4);
				if ($this->contact2Demail->Exportable) $Doc->ExportCaption($this->contact2Demail);
				if ($this->contact2Dtext1->Exportable) $Doc->ExportCaption($this->contact2Dtext1);
				if ($this->contact2Dtext2->Exportable) $Doc->ExportCaption($this->contact2Dtext2);
				if ($this->contact2Dtext3->Exportable) $Doc->ExportCaption($this->contact2Dtext3);
				if ($this->contact2Dtext4->Exportable) $Doc->ExportCaption($this->contact2Dtext4);
			} else {
				if ($this->id->Exportable) $Doc->ExportCaption($this->id);
				if ($this->logo->Exportable) $Doc->ExportCaption($this->logo);
				if ($this->url->Exportable) $Doc->ExportCaption($this->url);
				if ($this->meta2Dtitle->Exportable) $Doc->ExportCaption($this->meta2Dtitle);
				if ($this->meta2Dkeywords->Exportable) $Doc->ExportCaption($this->meta2Dkeywords);
				if ($this->meta2Ddescp->Exportable) $Doc->ExportCaption($this->meta2Ddescp);
				if ($this->top2Dl->Exportable) $Doc->ExportCaption($this->top2Dl);
				if ($this->top2Dr->Exportable) $Doc->ExportCaption($this->top2Dr);
				if ($this->head2Dl->Exportable) $Doc->ExportCaption($this->head2Dl);
				if ($this->head2Dr->Exportable) $Doc->ExportCaption($this->head2Dr);
				if ($this->slide1->Exportable) $Doc->ExportCaption($this->slide1);
				if ($this->slide2->Exportable) $Doc->ExportCaption($this->slide2);
				if ($this->slide3->Exportable) $Doc->ExportCaption($this->slide3);
				if ($this->slide4->Exportable) $Doc->ExportCaption($this->slide4);
				if ($this->slide5->Exportable) $Doc->ExportCaption($this->slide5);
				if ($this->slide6->Exportable) $Doc->ExportCaption($this->slide6);
				if ($this->nav2Dtext->Exportable) $Doc->ExportCaption($this->nav2Dtext);
				if ($this->slide2Dbox->Exportable) $Doc->ExportCaption($this->slide2Dbox);
				if ($this->custom2Dcss->Exportable) $Doc->ExportCaption($this->custom2Dcss);
				if ($this->home2Dcaption1->Exportable) $Doc->ExportCaption($this->home2Dcaption1);
				if ($this->home2Dtext1->Exportable) $Doc->ExportCaption($this->home2Dtext1);
				if ($this->home2Dcaption2->Exportable) $Doc->ExportCaption($this->home2Dcaption2);
				if ($this->home2Dtext2->Exportable) $Doc->ExportCaption($this->home2Dtext2);
				if ($this->home2Dcaption3->Exportable) $Doc->ExportCaption($this->home2Dcaption3);
				if ($this->home2Dtext3->Exportable) $Doc->ExportCaption($this->home2Dtext3);
				if ($this->home2Dcaption4->Exportable) $Doc->ExportCaption($this->home2Dcaption4);
				if ($this->home2Dtext4->Exportable) $Doc->ExportCaption($this->home2Dtext4);
				if ($this->home2Dcaption5->Exportable) $Doc->ExportCaption($this->home2Dcaption5);
				if ($this->home2Dtext5->Exportable) $Doc->ExportCaption($this->home2Dtext5);
				if ($this->home2Dcaption6->Exportable) $Doc->ExportCaption($this->home2Dcaption6);
				if ($this->home2Dtext6->Exportable) $Doc->ExportCaption($this->home2Dtext6);
				if ($this->footer2D1->Exportable) $Doc->ExportCaption($this->footer2D1);
				if ($this->footer2D2->Exportable) $Doc->ExportCaption($this->footer2D2);
				if ($this->footer2D3->Exportable) $Doc->ExportCaption($this->footer2D3);
				if ($this->footer2D4->Exportable) $Doc->ExportCaption($this->footer2D4);
				if ($this->base2Dl->Exportable) $Doc->ExportCaption($this->base2Dl);
				if ($this->base2Dr->Exportable) $Doc->ExportCaption($this->base2Dr);
				if ($this->contact2Demail->Exportable) $Doc->ExportCaption($this->contact2Demail);
				if ($this->contact2Dtext1->Exportable) $Doc->ExportCaption($this->contact2Dtext1);
				if ($this->contact2Dtext2->Exportable) $Doc->ExportCaption($this->contact2Dtext2);
				if ($this->contact2Dtext3->Exportable) $Doc->ExportCaption($this->contact2Dtext3);
				if ($this->contact2Dtext4->Exportable) $Doc->ExportCaption($this->contact2Dtext4);
				if ($this->google2Dmap->Exportable) $Doc->ExportCaption($this->google2Dmap);
				if ($this->fb2Dlikebox->Exportable) $Doc->ExportCaption($this->fb2Dlikebox);
			}
			$Doc->EndExportRow();
		}

		// Move to first record
		$RecCnt = $StartRec - 1;
		if (!$Recordset->EOF) {
			$Recordset->MoveFirst();
			if ($StartRec > 1)
				$Recordset->Move($StartRec - 1);
		}
		while (!$Recordset->EOF && $RecCnt < $StopRec) {
			$RecCnt++;
			if (intval($RecCnt) >= intval($StartRec)) {
				$RowCnt = intval($RecCnt) - intval($StartRec) + 1;

				// Page break
				if ($this->ExportPageBreakCount > 0) {
					if ($RowCnt > 1 && ($RowCnt - 1) % $this->ExportPageBreakCount == 0)
						$Doc->ExportPageBreak();
				}
				$this->LoadListRowValues($Recordset);

				// Render row
				$this->RowType = EW_ROWTYPE_VIEW; // Render view
				$this->ResetAttrs();
				$this->RenderListRow();
				$Doc->BeginExportRow($RowCnt); // Allow CSS styles if enabled
				if ($ExportPageType == "view") {
					if ($this->id->Exportable) $Doc->ExportField($this->id);
					if ($this->top2Dl->Exportable) $Doc->ExportField($this->top2Dl);
					if ($this->top2Dr->Exportable) $Doc->ExportField($this->top2Dr);
					if ($this->head2Dl->Exportable) $Doc->ExportField($this->head2Dl);
					if ($this->head2Dr->Exportable) $Doc->ExportField($this->head2Dr);
					if ($this->slide1->Exportable) $Doc->ExportField($this->slide1);
					if ($this->slide2->Exportable) $Doc->ExportField($this->slide2);
					if ($this->slide3->Exportable) $Doc->ExportField($this->slide3);
					if ($this->slide4->Exportable) $Doc->ExportField($this->slide4);
					if ($this->slide5->Exportable) $Doc->ExportField($this->slide5);
					if ($this->slide6->Exportable) $Doc->ExportField($this->slide6);
					if ($this->home2Dcaption1->Exportable) $Doc->ExportField($this->home2Dcaption1);
					if ($this->home2Dtext1->Exportable) $Doc->ExportField($this->home2Dtext1);
					if ($this->home2Dcaption2->Exportable) $Doc->ExportField($this->home2Dcaption2);
					if ($this->home2Dtext2->Exportable) $Doc->ExportField($this->home2Dtext2);
					if ($this->home2Dcaption3->Exportable) $Doc->ExportField($this->home2Dcaption3);
					if ($this->home2Dtext3->Exportable) $Doc->ExportField($this->home2Dtext3);
					if ($this->home2Dcaption4->Exportable) $Doc->ExportField($this->home2Dcaption4);
					if ($this->home2Dtext4->Exportable) $Doc->ExportField($this->home2Dtext4);
					if ($this->home2Dcaption5->Exportable) $Doc->ExportField($this->home2Dcaption5);
					if ($this->home2Dtext5->Exportable) $Doc->ExportField($this->home2Dtext5);
					if ($this->home2Dcaption6->Exportable) $Doc->ExportField($this->home2Dcaption6);
					if ($this->home2Dtext6->Exportable) $Doc->ExportField($this->home2Dtext6);
					if ($this->footer2D1->Exportable) $Doc->ExportField($this->footer2D1);
					if ($this->footer2D2->Exportable) $Doc->ExportField($this->footer2D2);
					if ($this->footer2D3->Exportable) $Doc->ExportField($this->footer2D3);
					if ($this->footer2D4->Exportable) $Doc->ExportField($this->footer2D4);
					if ($this->contact2Demail->Exportable) $Doc->ExportField($this->contact2Demail);
					if ($this->contact2Dtext1->Exportable) $Doc->ExportField($this->contact2Dtext1);
					if ($this->contact2Dtext2->Exportable) $Doc->ExportField($this->contact2Dtext2);
					if ($this->contact2Dtext3->Exportable) $Doc->ExportField($this->contact2Dtext3);
					if ($this->contact2Dtext4->Exportable) $Doc->ExportField($this->contact2Dtext4);
				} else {
					if ($this->id->Exportable) $Doc->ExportField($this->id);
					if ($this->logo->Exportable) $Doc->ExportField($this->logo);
					if ($this->url->Exportable) $Doc->ExportField($this->url);
					if ($this->meta2Dtitle->Exportable) $Doc->ExportField($this->meta2Dtitle);
					if ($this->meta2Dkeywords->Exportable) $Doc->ExportField($this->meta2Dkeywords);
					if ($this->meta2Ddescp->Exportable) $Doc->ExportField($this->meta2Ddescp);
					if ($this->top2Dl->Exportable) $Doc->ExportField($this->top2Dl);
					if ($this->top2Dr->Exportable) $Doc->ExportField($this->top2Dr);
					if ($this->head2Dl->Exportable) $Doc->ExportField($this->head2Dl);
					if ($this->head2Dr->Exportable) $Doc->ExportField($this->head2Dr);
					if ($this->slide1->Exportable) $Doc->ExportField($this->slide1);
					if ($this->slide2->Exportable) $Doc->ExportField($this->slide2);
					if ($this->slide3->Exportable) $Doc->ExportField($this->slide3);
					if ($this->slide4->Exportable) $Doc->ExportField($this->slide4);
					if ($this->slide5->Exportable) $Doc->ExportField($this->slide5);
					if ($this->slide6->Exportable) $Doc->ExportField($this->slide6);
					if ($this->nav2Dtext->Exportable) $Doc->ExportField($this->nav2Dtext);
					if ($this->slide2Dbox->Exportable) $Doc->ExportField($this->slide2Dbox);
					if ($this->custom2Dcss->Exportable) $Doc->ExportField($this->custom2Dcss);
					if ($this->home2Dcaption1->Exportable) $Doc->ExportField($this->home2Dcaption1);
					if ($this->home2Dtext1->Exportable) $Doc->ExportField($this->home2Dtext1);
					if ($this->home2Dcaption2->Exportable) $Doc->ExportField($this->home2Dcaption2);
					if ($this->home2Dtext2->Exportable) $Doc->ExportField($this->home2Dtext2);
					if ($this->home2Dcaption3->Exportable) $Doc->ExportField($this->home2Dcaption3);
					if ($this->home2Dtext3->Exportable) $Doc->ExportField($this->home2Dtext3);
					if ($this->home2Dcaption4->Exportable) $Doc->ExportField($this->home2Dcaption4);
					if ($this->home2Dtext4->Exportable) $Doc->ExportField($this->home2Dtext4);
					if ($this->home2Dcaption5->Exportable) $Doc->ExportField($this->home2Dcaption5);
					if ($this->home2Dtext5->Exportable) $Doc->ExportField($this->home2Dtext5);
					if ($this->home2Dcaption6->Exportable) $Doc->ExportField($this->home2Dcaption6);
					if ($this->home2Dtext6->Exportable) $Doc->ExportField($this->home2Dtext6);
					if ($this->footer2D1->Exportable) $Doc->ExportField($this->footer2D1);
					if ($this->footer2D2->Exportable) $Doc->ExportField($this->footer2D2);
					if ($this->footer2D3->Exportable) $Doc->ExportField($this->footer2D3);
					if ($this->footer2D4->Exportable) $Doc->ExportField($this->footer2D4);
					if ($this->base2Dl->Exportable) $Doc->ExportField($this->base2Dl);
					if ($this->base2Dr->Exportable) $Doc->ExportField($this->base2Dr);
					if ($this->contact2Demail->Exportable) $Doc->ExportField($this->contact2Demail);
					if ($this->contact2Dtext1->Exportable) $Doc->ExportField($this->contact2Dtext1);
					if ($this->contact2Dtext2->Exportable) $Doc->ExportField($this->contact2Dtext2);
					if ($this->contact2Dtext3->Exportable) $Doc->ExportField($this->contact2Dtext3);
					if ($this->contact2Dtext4->Exportable) $Doc->ExportField($this->contact2Dtext4);
					if ($this->google2Dmap->Exportable) $Doc->ExportField($this->google2Dmap);
					if ($this->fb2Dlikebox->Exportable) $Doc->ExportField($this->fb2Dlikebox);
				}
				$Doc->EndExportRow();
			}
			$Recordset->MoveNext();
		}
		$Doc->ExportTableFooter();
	}

	// Table level events
	// Recordset Selecting event
	function Recordset_Selecting(&$filter) {

		// Enter your code here	
	}

	// Recordset Selected event
	function Recordset_Selected(&$rs) {

		//echo "Recordset Selected";
	}

	// Recordset Search Validated event
	function Recordset_SearchValidated() {

		// Example:
		//$this->MyField1->AdvancedSearch->SearchValue = "your search criteria"; // Search value

	}

	// Recordset Searching event
	function Recordset_Searching(&$filter) {

		// Enter your code here	
	}

	// Row_Selecting event
	function Row_Selecting(&$filter) {

		// Enter your code here	
	}

	// Row Selected event
	function Row_Selected(&$rs) {

		//echo "Row Selected";
	}

	// Row Inserting event
	function Row_Inserting($rsold, &$rsnew) {

		// Enter your code here
		// To cancel, set return value to FALSE

		return TRUE;
	}

	// Row Inserted event
	function Row_Inserted($rsold, &$rsnew) {

		//echo "Row Inserted"
	}

	// Row Updating event
	function Row_Updating($rsold, &$rsnew) {

		// Enter your code here
		// To cancel, set return value to FALSE

		return TRUE;
	}

	// Row Updated event
	function Row_Updated($rsold, &$rsnew) {

		//echo "Row Updated";
	}

	// Row Update Conflict event
	function Row_UpdateConflict($rsold, &$rsnew) {

		// Enter your code here
		// To ignore conflict, set return value to FALSE

		return TRUE;
	}

	// Row Deleting event
	function Row_Deleting(&$rs) {

		// Enter your code here
		// To cancel, set return value to False

		return TRUE;
	}

	// Row Deleted event
	function Row_Deleted(&$rs) {

		//echo "Row Deleted";
	}

	// Email Sending event
	function Email_Sending(&$Email, &$Args) {

		//var_dump($Email); var_dump($Args); exit();
		return TRUE;
	}

	// Lookup Selecting event
	function Lookup_Selecting($fld, &$filter) {

		// Enter your code here
	}

	// Row Rendering event
	function Row_Rendering() {

		// Enter your code here	
	}

	// Row Rendered event
	function Row_Rendered() {

		// To view properties of field class, use:
		//var_dump($this-><FieldName>); 

	}

	// User ID Filtering event
	function UserID_Filtering(&$filter) {

		// Enter your code here
	}
}
?>
