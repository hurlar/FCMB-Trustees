<?php

// Global variable for table object
$products = NULL;

//
// Table class for products
//
class cproducts extends cTable {
	var $id;
	var $price;
	var $img2;
	var $img3;
	var $img4;
	var $rate_ord;
	var $datep;
	var $oldprice;
	var $product_code;
	var $product_name;
	var $product_desc;
	var $product_img_name;
	var $img1;
	var $cat;
	var $sized;
	var $subcat;
	var $sales_status;

	//
	// Table class constructor
	//
	function __construct() {
		global $Language;

		// Language object
		if (!isset($Language)) $Language = new cLanguage();
		$this->TableVar = 'products';
		$this->TableName = 'products';
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
		$this->id = new cField('products', 'products', 'x_id', 'id', '`id`', '`id`', 3, -1, FALSE, '`id`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->id->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['id'] = &$this->id;

		// price
		$this->price = new cField('products', 'products', 'x_price', 'price', '`price`', '`price`', 131, -1, FALSE, '`price`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->price->FldDefaultErrMsg = $Language->Phrase("IncorrectFloat");
		$this->fields['price'] = &$this->price;

		// img2
		$this->img2 = new cField('products', 'products', 'x_img2', 'img2', '`img2`', '`img2`', 200, -1, TRUE, '`img2`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->fields['img2'] = &$this->img2;

		// img3
		$this->img3 = new cField('products', 'products', 'x_img3', 'img3', '`img3`', '`img3`', 200, -1, TRUE, '`img3`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->fields['img3'] = &$this->img3;

		// img4
		$this->img4 = new cField('products', 'products', 'x_img4', 'img4', '`img4`', '`img4`', 200, -1, TRUE, '`img4`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->fields['img4'] = &$this->img4;

		// rate_ord
		$this->rate_ord = new cField('products', 'products', 'x_rate_ord', 'rate_ord', '`rate_ord`', '`rate_ord`', 202, -1, FALSE, '`rate_ord`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->fields['rate_ord'] = &$this->rate_ord;

		// datep
		$this->datep = new cField('products', 'products', 'x_datep', 'datep', '`datep`', 'DATE_FORMAT(`datep`, \'%d/%m/%y\')', 135, -1, FALSE, '`datep`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->fields['datep'] = &$this->datep;

		// oldprice
		$this->oldprice = new cField('products', 'products', 'x_oldprice', 'oldprice', '`oldprice`', '`oldprice`', 200, -1, FALSE, '`oldprice`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->oldprice->FldDefaultErrMsg = $Language->Phrase("IncorrectFloat");
		$this->fields['oldprice'] = &$this->oldprice;

		// product_code
		$this->product_code = new cField('products', 'products', 'x_product_code', 'product_code', '`product_code`', '`product_code`', 200, -1, FALSE, '`product_code`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->fields['product_code'] = &$this->product_code;

		// product_name
		$this->product_name = new cField('products', 'products', 'x_product_name', 'product_name', '`product_name`', '`product_name`', 200, -1, FALSE, '`product_name`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->fields['product_name'] = &$this->product_name;

		// product_desc
		$this->product_desc = new cField('products', 'products', 'x_product_desc', 'product_desc', '`product_desc`', '`product_desc`', 201, -1, FALSE, '`product_desc`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->fields['product_desc'] = &$this->product_desc;

		// product_img_name
		$this->product_img_name = new cField('products', 'products', 'x_product_img_name', 'product_img_name', '`product_img_name`', '`product_img_name`', 200, -1, FALSE, '`product_img_name`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->fields['product_img_name'] = &$this->product_img_name;

		// img1
		$this->img1 = new cField('products', 'products', 'x_img1', 'img1', '`img1`', '`img1`', 200, -1, FALSE, '`img1`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->fields['img1'] = &$this->img1;

		// cat
		$this->cat = new cField('products', 'products', 'x_cat', 'cat', '`cat`', '`cat`', 200, -1, FALSE, '`cat`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->fields['cat'] = &$this->cat;

		// sized
		$this->sized = new cField('products', 'products', 'x_sized', 'sized', '`sized`', '`sized`', 201, -1, FALSE, '`sized`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->fields['sized'] = &$this->sized;

		// subcat
		$this->subcat = new cField('products', 'products', 'x_subcat', 'subcat', '`subcat`', '`subcat`', 200, -1, FALSE, '`subcat`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->fields['subcat'] = &$this->subcat;

		// sales_status
		$this->sales_status = new cField('products', 'products', 'x_sales_status', 'sales_status', '`sales_status`', '`sales_status`', 202, -1, FALSE, '`sales_status`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->sales_status->FldDataType = EW_DATATYPE_BOOLEAN;
		$this->fields['sales_status'] = &$this->sales_status;
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
		return "`products`";
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
	var $UpdateTable = "`products`";

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
			return "productslist.php";
		}
	}

	function setReturnUrl($v) {
		$_SESSION[EW_PROJECT_NAME . "_" . $this->TableVar . "_" . EW_TABLE_RETURN_URL] = $v;
	}

	// List URL
	function GetListUrl() {
		return "productslist.php";
	}

	// View URL
	function GetViewUrl($parm = "") {
		if ($parm <> "")
			return $this->KeyUrl("productsview.php", $this->UrlParm($parm));
		else
			return $this->KeyUrl("productsview.php", $this->UrlParm(EW_TABLE_SHOW_DETAIL . "="));
	}

	// Add URL
	function GetAddUrl() {
		return "productsadd.php";
	}

	// Edit URL
	function GetEditUrl($parm = "") {
		return $this->KeyUrl("productsedit.php", $this->UrlParm($parm));
	}

	// Inline edit URL
	function GetInlineEditUrl() {
		return $this->KeyUrl(ew_CurrentPage(), $this->UrlParm("a=edit"));
	}

	// Copy URL
	function GetCopyUrl($parm = "") {
		return $this->KeyUrl("productsadd.php", $this->UrlParm($parm));
	}

	// Inline copy URL
	function GetInlineCopyUrl() {
		return $this->KeyUrl(ew_CurrentPage(), $this->UrlParm("a=copy"));
	}

	// Delete URL
	function GetDeleteUrl() {
		return $this->KeyUrl("productsdelete.php", $this->UrlParm());
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
		$this->price->setDbValue($rs->fields('price'));
		$this->img2->Upload->DbValue = $rs->fields('img2');
		$this->img3->Upload->DbValue = $rs->fields('img3');
		$this->img4->Upload->DbValue = $rs->fields('img4');
		$this->rate_ord->setDbValue($rs->fields('rate_ord'));
		$this->datep->setDbValue($rs->fields('datep'));
		$this->oldprice->setDbValue($rs->fields('oldprice'));
		$this->product_code->setDbValue($rs->fields('product_code'));
		$this->product_name->setDbValue($rs->fields('product_name'));
		$this->product_desc->setDbValue($rs->fields('product_desc'));
		$this->product_img_name->setDbValue($rs->fields('product_img_name'));
		$this->img1->setDbValue($rs->fields('img1'));
		$this->cat->setDbValue($rs->fields('cat'));
		$this->sized->setDbValue($rs->fields('sized'));
		$this->subcat->setDbValue($rs->fields('subcat'));
		$this->sales_status->setDbValue($rs->fields('sales_status'));
	}

	// Render list row values
	function RenderListRow() {
		global $conn, $Security;

		// Call Row Rendering event
		$this->Row_Rendering();

   // Common render codes
		// id
		// price
		// img2
		// img3
		// img4
		// rate_ord
		// datep
		// oldprice
		// product_code
		// product_name
		// product_desc
		// product_img_name
		// img1
		// cat
		// sized
		// subcat
		// sales_status
		// id

		$this->id->ViewValue = $this->id->CurrentValue;
		$this->id->ViewCustomAttributes = "";

		// price
		$this->price->ViewValue = $this->price->CurrentValue;
		$this->price->ViewValue = ew_FormatCurrency($this->price->ViewValue, 2, -2, -2, -2);
		$this->price->ViewCustomAttributes = "";

		// img2
		$this->img2->UploadPath = "../uploads/products/";
		if (!ew_Empty($this->img2->Upload->DbValue)) {
			$this->img2->ViewValue = $this->img2->Upload->DbValue;
		} else {
			$this->img2->ViewValue = "";
		}
		$this->img2->ViewCustomAttributes = "";

		// img3
		$this->img3->UploadPath = "../uploads/products/";
		if (!ew_Empty($this->img3->Upload->DbValue)) {
			$this->img3->ViewValue = $this->img3->Upload->DbValue;
		} else {
			$this->img3->ViewValue = "";
		}
		$this->img3->ViewCustomAttributes = "";

		// img4
		$this->img4->UploadPath = "../uploads/products/";
		if (!ew_Empty($this->img4->Upload->DbValue)) {
			$this->img4->ViewValue = $this->img4->Upload->DbValue;
		} else {
			$this->img4->ViewValue = "";
		}
		$this->img4->ViewCustomAttributes = "";

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

		// oldprice
		$this->oldprice->ViewValue = $this->oldprice->CurrentValue;
		$this->oldprice->ViewCustomAttributes = "";

		// product_code
		$this->product_code->ViewValue = $this->product_code->CurrentValue;
		$this->product_code->ViewCustomAttributes = "";

		// product_name
		$this->product_name->ViewValue = $this->product_name->CurrentValue;
		$this->product_name->ViewCustomAttributes = "";

		// product_desc
		$this->product_desc->ViewValue = $this->product_desc->CurrentValue;
		$this->product_desc->ViewCustomAttributes = "";

		// product_img_name
		$this->product_img_name->ViewValue = $this->product_img_name->CurrentValue;
		$this->product_img_name->ViewCustomAttributes = "";

		// img1
		$this->img1->ViewValue = $this->img1->CurrentValue;
		$this->img1->ViewCustomAttributes = "";

		// cat
		$this->cat->ViewValue = $this->cat->CurrentValue;
		$this->cat->ViewCustomAttributes = "";

		// sized
		$this->sized->ViewValue = $this->sized->CurrentValue;
		$this->sized->ViewCustomAttributes = "";

		// subcat
		$this->subcat->ViewValue = $this->subcat->CurrentValue;
		$this->subcat->ViewCustomAttributes = "";

		// sales_status
		if (ew_ConvertToBool($this->sales_status->CurrentValue)) {
			$this->sales_status->ViewValue = $this->sales_status->FldTagCaption(2) <> "" ? $this->sales_status->FldTagCaption(2) : "1";
		} else {
			$this->sales_status->ViewValue = $this->sales_status->FldTagCaption(1) <> "" ? $this->sales_status->FldTagCaption(1) : "0";
		}
		$this->sales_status->ViewCustomAttributes = "";

		// id
		$this->id->LinkCustomAttributes = "";
		$this->id->HrefValue = "";
		$this->id->TooltipValue = "";

		// price
		$this->price->LinkCustomAttributes = "";
		$this->price->HrefValue = "";
		$this->price->TooltipValue = "";

		// img2
		$this->img2->LinkCustomAttributes = "";
		$this->img2->UploadPath = "../uploads/products/";
		if (!ew_Empty($this->img2->Upload->DbValue)) {
			$this->img2->HrefValue = ew_UploadPathEx(FALSE, $this->img2->UploadPath) . $this->img2->Upload->DbValue; // Add prefix/suffix
			$this->img2->LinkAttrs["target"] = ""; // Add target
			if ($this->Export <> "") $this->img2->HrefValue = ew_ConvertFullUrl($this->img2->HrefValue);
		} else {
			$this->img2->HrefValue = "";
		}
		$this->img2->HrefValue2 = $this->img2->UploadPath . $this->img2->Upload->DbValue;
		$this->img2->TooltipValue = "";

		// img3
		$this->img3->LinkCustomAttributes = "";
		$this->img3->UploadPath = "../uploads/products/";
		if (!ew_Empty($this->img3->Upload->DbValue)) {
			$this->img3->HrefValue = ew_UploadPathEx(FALSE, $this->img3->UploadPath) . $this->img3->Upload->DbValue; // Add prefix/suffix
			$this->img3->LinkAttrs["target"] = ""; // Add target
			if ($this->Export <> "") $this->img3->HrefValue = ew_ConvertFullUrl($this->img3->HrefValue);
		} else {
			$this->img3->HrefValue = "";
		}
		$this->img3->HrefValue2 = $this->img3->UploadPath . $this->img3->Upload->DbValue;
		$this->img3->TooltipValue = "";

		// img4
		$this->img4->LinkCustomAttributes = "";
		$this->img4->UploadPath = "../uploads/products/";
		if (!ew_Empty($this->img4->Upload->DbValue)) {
			$this->img4->HrefValue = ew_UploadPathEx(FALSE, $this->img4->UploadPath) . $this->img4->Upload->DbValue; // Add prefix/suffix
			$this->img4->LinkAttrs["target"] = ""; // Add target
			if ($this->Export <> "") $this->img4->HrefValue = ew_ConvertFullUrl($this->img4->HrefValue);
		} else {
			$this->img4->HrefValue = "";
		}
		$this->img4->HrefValue2 = $this->img4->UploadPath . $this->img4->Upload->DbValue;
		$this->img4->TooltipValue = "";

		// rate_ord
		$this->rate_ord->LinkCustomAttributes = "";
		$this->rate_ord->HrefValue = "";
		$this->rate_ord->TooltipValue = "";

		// datep
		$this->datep->LinkCustomAttributes = "";
		$this->datep->HrefValue = "";
		$this->datep->TooltipValue = "";

		// oldprice
		$this->oldprice->LinkCustomAttributes = "";
		$this->oldprice->HrefValue = "";
		$this->oldprice->TooltipValue = "";

		// product_code
		$this->product_code->LinkCustomAttributes = "";
		$this->product_code->HrefValue = "";
		$this->product_code->TooltipValue = "";

		// product_name
		$this->product_name->LinkCustomAttributes = "";
		$this->product_name->HrefValue = "";
		$this->product_name->TooltipValue = "";

		// product_desc
		$this->product_desc->LinkCustomAttributes = "";
		$this->product_desc->HrefValue = "";
		$this->product_desc->TooltipValue = "";

		// product_img_name
		$this->product_img_name->LinkCustomAttributes = "";
		$this->product_img_name->HrefValue = "";
		$this->product_img_name->TooltipValue = "";

		// img1
		$this->img1->LinkCustomAttributes = "";
		$this->img1->HrefValue = "";
		$this->img1->TooltipValue = "";

		// cat
		$this->cat->LinkCustomAttributes = "";
		$this->cat->HrefValue = "";
		$this->cat->TooltipValue = "";

		// sized
		$this->sized->LinkCustomAttributes = "";
		$this->sized->HrefValue = "";
		$this->sized->TooltipValue = "";

		// subcat
		$this->subcat->LinkCustomAttributes = "";
		$this->subcat->HrefValue = "";
		$this->subcat->TooltipValue = "";

		// sales_status
		$this->sales_status->LinkCustomAttributes = "";
		$this->sales_status->HrefValue = "";
		$this->sales_status->TooltipValue = "";

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
				if ($this->price->Exportable) $Doc->ExportCaption($this->price);
				if ($this->img2->Exportable) $Doc->ExportCaption($this->img2);
				if ($this->img3->Exportable) $Doc->ExportCaption($this->img3);
				if ($this->img4->Exportable) $Doc->ExportCaption($this->img4);
				if ($this->rate_ord->Exportable) $Doc->ExportCaption($this->rate_ord);
				if ($this->datep->Exportable) $Doc->ExportCaption($this->datep);
				if ($this->oldprice->Exportable) $Doc->ExportCaption($this->oldprice);
				if ($this->product_code->Exportable) $Doc->ExportCaption($this->product_code);
				if ($this->product_name->Exportable) $Doc->ExportCaption($this->product_name);
				if ($this->product_desc->Exportable) $Doc->ExportCaption($this->product_desc);
				if ($this->product_img_name->Exportable) $Doc->ExportCaption($this->product_img_name);
				if ($this->img1->Exportable) $Doc->ExportCaption($this->img1);
				if ($this->cat->Exportable) $Doc->ExportCaption($this->cat);
				if ($this->sized->Exportable) $Doc->ExportCaption($this->sized);
				if ($this->subcat->Exportable) $Doc->ExportCaption($this->subcat);
				if ($this->sales_status->Exportable) $Doc->ExportCaption($this->sales_status);
			} else {
				if ($this->id->Exportable) $Doc->ExportCaption($this->id);
				if ($this->price->Exportable) $Doc->ExportCaption($this->price);
				if ($this->img2->Exportable) $Doc->ExportCaption($this->img2);
				if ($this->img3->Exportable) $Doc->ExportCaption($this->img3);
				if ($this->img4->Exportable) $Doc->ExportCaption($this->img4);
				if ($this->rate_ord->Exportable) $Doc->ExportCaption($this->rate_ord);
				if ($this->datep->Exportable) $Doc->ExportCaption($this->datep);
				if ($this->oldprice->Exportable) $Doc->ExportCaption($this->oldprice);
				if ($this->product_code->Exportable) $Doc->ExportCaption($this->product_code);
				if ($this->product_name->Exportable) $Doc->ExportCaption($this->product_name);
				if ($this->product_img_name->Exportable) $Doc->ExportCaption($this->product_img_name);
				if ($this->img1->Exportable) $Doc->ExportCaption($this->img1);
				if ($this->cat->Exportable) $Doc->ExportCaption($this->cat);
				if ($this->subcat->Exportable) $Doc->ExportCaption($this->subcat);
				if ($this->sales_status->Exportable) $Doc->ExportCaption($this->sales_status);
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
					if ($this->price->Exportable) $Doc->ExportField($this->price);
					if ($this->img2->Exportable) $Doc->ExportField($this->img2);
					if ($this->img3->Exportable) $Doc->ExportField($this->img3);
					if ($this->img4->Exportable) $Doc->ExportField($this->img4);
					if ($this->rate_ord->Exportable) $Doc->ExportField($this->rate_ord);
					if ($this->datep->Exportable) $Doc->ExportField($this->datep);
					if ($this->oldprice->Exportable) $Doc->ExportField($this->oldprice);
					if ($this->product_code->Exportable) $Doc->ExportField($this->product_code);
					if ($this->product_name->Exportable) $Doc->ExportField($this->product_name);
					if ($this->product_desc->Exportable) $Doc->ExportField($this->product_desc);
					if ($this->product_img_name->Exportable) $Doc->ExportField($this->product_img_name);
					if ($this->img1->Exportable) $Doc->ExportField($this->img1);
					if ($this->cat->Exportable) $Doc->ExportField($this->cat);
					if ($this->sized->Exportable) $Doc->ExportField($this->sized);
					if ($this->subcat->Exportable) $Doc->ExportField($this->subcat);
					if ($this->sales_status->Exportable) $Doc->ExportField($this->sales_status);
				} else {
					if ($this->id->Exportable) $Doc->ExportField($this->id);
					if ($this->price->Exportable) $Doc->ExportField($this->price);
					if ($this->img2->Exportable) $Doc->ExportField($this->img2);
					if ($this->img3->Exportable) $Doc->ExportField($this->img3);
					if ($this->img4->Exportable) $Doc->ExportField($this->img4);
					if ($this->rate_ord->Exportable) $Doc->ExportField($this->rate_ord);
					if ($this->datep->Exportable) $Doc->ExportField($this->datep);
					if ($this->oldprice->Exportable) $Doc->ExportField($this->oldprice);
					if ($this->product_code->Exportable) $Doc->ExportField($this->product_code);
					if ($this->product_name->Exportable) $Doc->ExportField($this->product_name);
					if ($this->product_img_name->Exportable) $Doc->ExportField($this->product_img_name);
					if ($this->img1->Exportable) $Doc->ExportField($this->img1);
					if ($this->cat->Exportable) $Doc->ExportField($this->cat);
					if ($this->subcat->Exportable) $Doc->ExportField($this->subcat);
					if ($this->sales_status->Exportable) $Doc->ExportField($this->sales_status);
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
