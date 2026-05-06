<?php

/* * *****************************************************************************
 * FPDF                                                                         *
 *                                                                              *
 * Version: 1.7                                                                 *
 * Date:    2011-06-18                                                          *
 * Author:  Olivier PLATHEY                                                     *
 * ***************************************************************************** */

define('FPDF_VERSION', '1.7');

class FPDF {

    var $page;               // current page number
    var $n;                  // current object number
    var $offsets;            // array of object offsets
    var $buffer;             // buffer holding in-memory PDF
    var $pages;              // array containing pages
    var $state;              // current document state
    var $compress;           // compression flag
    var $k;                  // scale factor (number of points in user unit)
    var $DefOrientation;     // default orientation
    var $CurOrientation;     // current orientation
    var $StdPageSizes;       // standard page sizes
    var $DefPageSize;        // default page size
    var $CurPageSize;        // current page size
    var $PageSizes;          // used for pages with non default sizes or orientations
    var $wPt, $hPt;          // dimensions of current page in points
    var $w, $h;              // dimensions of current page in user unit
    var $lMargin;            // left margin
    var $tMargin;            // top margin
    var $rMargin;            // right margin
    var $bMargin;            // page break margin
    var $cMargin;            // cell margin
    var $x, $y;              // current position in user unit
    var $lasth;              // height of last printed cell
    var $LineWidth;          // line width in user unit
    var $fontpath;           // path containing fonts
    var $CoreFonts;          // array of core font names
    var $fonts;              // array of used fonts
    var $FontFiles;          // array of font files
    var $diffs;              // array of encoding differences
    var $FontFamily;         // current font family
    var $FontStyle;          // current font style
    var $underline;          // underlining flag
    var $CurrentFont;        // current font info
    var $FontSizePt;         // current font size in points
    var $FontSize;           // current font size in user unit
    var $DrawColor;          // commands for drawing color
    var $FillColor;          // commands for filling color
    var $TextColor;          // commands for text color
    var $ColorFlag;          // indicates whether fill and text colors are different
    var $ws;                 // word spacing
    var $images;             // array of used images
    var $PageLinks;          // array of links in pages
    var $links;              // array of internal links
    var $AutoPageBreak;      // automatic page breaking
    var $PageBreakTrigger;   // threshold used to trigger page breaks
    var $InHeader;           // flag set when processing header
    var $InFooter;           // flag set when processing footer
    var $ZoomMode;           // zoom display mode
    var $LayoutMode;         // layout display mode
    var $title;              // title
    var $subject;            // subject
    var $author;             // author
    var $keywords;           // keywords
    var $creator;            // creator
    var $AliasNbPages;       // alias for total number of pages
    var $PDFVersion;         // PDF version number
    var $cell_height_ratio;
    protected $cell_padding = array('T' => 0, 'R' => 0, 'B' => 0, 'L' => 0);
    protected $cell_margin = array('T' => 0, 'R' => 0, 'B' => 0, 'L' => 0);
    protected $linestyleWidth = '';
    protected $linestyleCap = '0 J';
    protected $linestyleJoin = '0 j';
    protected $linestyleDash = '[] 0 d';
    protected $textrendermode = 0;
    protected $textstrokewidth = 0;
    protected $bgcolor;
    protected $fgcolor;
    protected $htmlvspace = 0;
    protected $listordered = array();
    protected $listcount = array();
    protected $listindent = 0;
    protected $listnum = 0;
    protected $listindentlevel = 0;
    protected $lispacer = '';
    protected $font_stretching = 100;
    protected $font_spacing = 0;
    protected $alpha = array('CA' => 1, 'ca' => 1, 'BM' => '/Normal', 'AIS' => false);
    protected $fwPt;
    protected $fhPt;
    protected $num_columns = 1;
    protected $current_column = 0;
    protected $check_page_regions = true;
    protected $rtl = false;

    /*     * *****************************************************************************
     *                                                                              *
     *                               Public methods                                 *
     *                                                                              *
     * ***************************************************************************** */

    public function character_limiter($str, $n = 500, $end_char = '...')
    {
        if (strlen($str) < $n)
        {
            return $str;
        }

        $str = preg_replace("/\s+/", ' ', str_replace(array("\r\n", "\r", "\n"), ' ', $str));

        if (strlen($str) <= $n)
        {
            return $str;
        }

        $out = array();
        $out[0]="";
        $out[1]="";
        $str=rtrim($str);
        $str=ltrim($str);
        $aaa=explode(' ', trim($str));
        foreach ( $aaa as $val)
        {
            if (strlen($out[0]) < $n)
            {
                $out[0] .= $val.' ';
                if (strlen($out[0]) == strlen($str)){
                    if(strlen($out[1])>0){
                        return $out;
                    }else{
                        return $out[0];
                    }
                }
                // return (strlen($out) == strlen($str)) ? $out : $out.$end_char;
            }elseif (strlen($out[0]) >= $n) {
                if($val!==' '){
                    $out[1] .= $val.' ';
                }
            }
        }
        if(strlen($out[1])>0){
            return $out;
        }else{
            return $out[0];
        }
    }

    public function write1DBarcode($code, $type, $x = '', $y = '', $w = '', $h = '', $xres = '', $style = '', $align = '') {
        if (TCPDF_STATIC::empty_string(trim($code))) {
            return;
        }
        require_once(dirname(__FILE__) . '/tcpdf_barcodes_1d.php');
        // save current graphic settings
        $gvars = $this->getGraphicVars();
        // create new barcode object
        $barcodeobj = new TCPDFBarcode($code, $type);
        $arrcode = $barcodeobj->getBarcodeArray();
        if (($arrcode === false) OR empty($arrcode) OR ( $arrcode['maxw'] <= 0)) {
            $this->Error('Error in 1D barcode string');
        }
        if ($arrcode['maxh'] <= 0) {
            $arrcode['maxh'] = 1;
        }
        // set default values
        if (!isset($style['position'])) {
            $style['position'] = '';
        } elseif ($style['position'] == 'S') {
            // keep this for backward compatibility
            $style['position'] = '';
            $style['stretch'] = true;
        }
        if (!isset($style['fitwidth'])) {
            if (!isset($style['stretch'])) {
                $style['fitwidth'] = true;
            } else {
                $style['fitwidth'] = false;
            }
        }
        if ($style['fitwidth']) {
            // disable stretch
            $style['stretch'] = false;
        }
        if (!isset($style['stretch'])) {
            if (($w === '') OR ( $w <= 0)) {
                $style['stretch'] = false;
            } else {
                $style['stretch'] = true;
            }
        }
        if (!isset($style['fgcolor'])) {
            $style['fgcolor'] = array(0, 0, 0); // default black
        }
        if (!isset($style['bgcolor'])) {
            $style['bgcolor'] = false; // default transparent
        }
        if (!isset($style['border'])) {
            $style['border'] = false;
        }
        $fontsize = 0;
        if (!isset($style['text'])) {
            $style['text'] = false;
        }
        if ($style['text'] AND isset($style['font'])) {
            if (isset($style['fontsize'])) {
                $fontsize = $style['fontsize'];
            }
            $this->SetFont($style['font'], '', $fontsize);
        }
        if (!isset($style['stretchtext'])) {
            $style['stretchtext'] = 4;
        }
        if ($x === '') {
            $x = $this->x;
        }
        if ($y === '') {
            $y = $this->y;
        }
        // check page for no-write regions and adapt page margins if necessary
        list($x, $y) = $this->checkPageRegions($h, $x, $y);
        if (($w === '') OR ( $w <= 0)) {
            if ($this->rtl) {
                $w = $x - $this->lMargin;
            } else {
                $w = $this->w - $this->rMargin - $x;
            }
        }
        // padding
        if (!isset($style['padding'])) {
            $padding = 0;
        } elseif ($style['padding'] === 'auto') {
            $padding = 10 * ($w / ($arrcode['maxw'] + 20));
        } else {
            $padding = floatval($style['padding']);
        }
        // horizontal padding
        if (!isset($style['hpadding'])) {
            $hpadding = $padding;
        } elseif ($style['hpadding'] === 'auto') {
            $hpadding = 10 * ($w / ($arrcode['maxw'] + 20));
        } else {
            $hpadding = floatval($style['hpadding']);
        }
        // vertical padding
        if (!isset($style['vpadding'])) {
            $vpadding = $padding;
        } elseif ($style['vpadding'] === 'auto') {
            $vpadding = ($hpadding / 2);
        } else {
            $vpadding = floatval($style['vpadding']);
        }
        // calculate xres (single bar width)
        $max_xres = ($w - (2 * $hpadding)) / $arrcode['maxw'];
        if ($style['stretch']) {
            $xres = $max_xres;
        } else {
            if (TCPDF_STATIC::empty_string($xres)) {
                $xres = (0.141 * $this->k); // default bar width = 0.4 mm
            }
            if ($xres > $max_xres) {
                // correct xres to fit on $w
                $xres = $max_xres;
            }
            if ((isset($style['padding']) AND ( $style['padding'] === 'auto'))
                    OR ( isset($style['hpadding']) AND ( $style['hpadding'] === 'auto'))) {
                $hpadding = 10 * $xres;
                if (isset($style['vpadding']) AND ( $style['vpadding'] === 'auto')) {
                    $vpadding = ($hpadding / 2);
                }
            }
        }
        if ($style['fitwidth']) {
            $wold = $w;
            $w = (($arrcode['maxw'] * $xres) + (2 * $hpadding));
            if (isset($style['cellfitalign'])) {
                switch ($style['cellfitalign']) {
                    case 'L': {
                            if ($this->rtl) {
                                $x -= ($wold - $w);
                            }
                            break;
                        }
                    case 'R': {
                            if (!$this->rtl) {
                                $x += ($wold - $w);
                            }
                            break;
                        }
                    case 'C': {
                            if ($this->rtl) {
                                $x -= (($wold - $w) / 2);
                            } else {
                                $x += (($wold - $w) / 2);
                            }
                            break;
                        }
                    default : {
                            break;
                        }
                }
            }
        }
        $text_height = $this->getCellHeight($fontsize / $this->k);
        // height
        if (($h === '') OR ( $h <= 0)) {
            // set default height
            $h = (($arrcode['maxw'] * $xres) / 3) + (2 * $vpadding) + $text_height;
        }
        $barh = $h - $text_height - (2 * $vpadding);
        if ($barh <= 0) {
            // try to reduce font or padding to fit barcode on available height
            if ($text_height > $h) {
                $fontsize = (($h * $this->k) / (4 * $this->cell_height_ratio));
                $text_height = $this->getCellHeight($fontsize / $this->k);
                $this->SetFont($style['font'], '', $fontsize);
            }
            if ($vpadding > 0) {
                $vpadding = (($h - $text_height) / 4);
            }
            $barh = $h - $text_height - (2 * $vpadding);
        }
        // fit the barcode on available space
        list($w, $h, $x, $y) = $this->fitBlock($w, $h, $x, $y, false);
        // set alignment
        $this->img_rb_y = $y + $h;
        // set alignment
        if ($this->rtl) {
            if ($style['position'] == 'L') {
                $xpos = $this->lMargin;
            } elseif ($style['position'] == 'C') {
                $xpos = ($this->w + $this->lMargin - $this->rMargin - $w) / 2;
            } elseif ($style['position'] == 'R') {
                $xpos = $this->w - $this->rMargin - $w;
            } else {
                $xpos = $x - $w;
            }
            $this->img_rb_x = $xpos;
        } else {
            if ($style['position'] == 'L') {
                $xpos = $this->lMargin;
            } elseif ($style['position'] == 'C') {
                $xpos = ($this->w + $this->lMargin - $this->rMargin - $w) / 2;
            } elseif ($style['position'] == 'R') {
                $xpos = $this->w - $this->rMargin - $w;
            } else {
                $xpos = $x;
            }
            $this->img_rb_x = $xpos + $w;
        }
        $xpos_rect = $xpos;
        if (!isset($style['align'])) {
            $style['align'] = 'C';
        }
        switch ($style['align']) {
            case 'L': {
                    $xpos = $xpos_rect + $hpadding;
                    break;
                }
            case 'R': {
                    $xpos = $xpos_rect + ($w - ($arrcode['maxw'] * $xres)) - $hpadding;
                    break;
                }
            case 'C':
            default : {
                    $xpos = $xpos_rect + (($w - ($arrcode['maxw'] * $xres)) / 2);
                    break;
                }
        }
        $xpos_text = $xpos;
        // barcode is always printed in LTR direction
        $tempRTL = $this->rtl;
        $this->rtl = false;
        // print background color
        if ($style['bgcolor']) {
            $this->Rect($xpos_rect, $y, $w, $h, $style['border'] ? 'DF' : 'F', '', $style['bgcolor']);
        } elseif ($style['border']) {
            $this->Rect($xpos_rect, $y, $w, $h, 'D');
        }
        // set foreground color
        $this->SetDrawColorArray($style['fgcolor']);
        $this->SetTextColorArray($style['fgcolor']);
        // print bars
        foreach ($arrcode['bcode'] as $k => $v) {
            $bw = ($v['w'] * $xres);
            if ($v['t']) {
                // draw a vertical bar
                $ypos = $y + $vpadding + ($v['p'] * $barh / $arrcode['maxh']);
                $this->Rect($xpos, $ypos, $bw, ($v['h'] * $barh / $arrcode['maxh']), 'F', array(), $style['fgcolor']);
            }
            $xpos += $bw;
        }
        // print text
        if ($style['text']) {
            if (isset($style['label']) AND ! TCPDF_STATIC::empty_string($style['label'])) {
                $label = $style['label'];
            } else {
                $label = $code;
            }
            $txtwidth = ($arrcode['maxw'] * $xres);
            if ($this->GetStringWidth($label) > $txtwidth) {
                $style['stretchtext'] = 2;
            }
            // print text
            $this->x = $xpos_text;
            $this->y = $y + $vpadding + $barh;
            $cellpadding = $this->cell_padding;
            $this->SetCellPadding(0);
            $this->Cell($txtwidth, '', $label, 0, 0, 'C', false, '', $style['stretchtext'], false, 'T', 'T');
            $this->cell_padding = $cellpadding;
        }
        // restore original direction
        $this->rtl = $tempRTL;
        // restore previous settings
        $this->setGraphicVars($gvars);
        // set pointer to align the next text/objects
        switch ($align) {
            case 'T': {
                    $this->y = $y;
                    $this->x = $this->img_rb_x;
                    break;
                }
            case 'M': {
                    $this->y = $y + round($h / 2);
                    $this->x = $this->img_rb_x;
                    break;
                }
            case 'B': {
                    $this->y = $this->img_rb_y;
                    $this->x = $this->img_rb_x;
                    break;
                }
            case 'N': {
                    $this->SetY($this->img_rb_y);
                    break;
                }
            default: {
                    break;
                }
        }
        $this->endlinex = $this->img_rb_x;
    }

    public function write2DBarcode($code, $type, $x = '', $y = '', $w = '', $h = '', $style = '', $align = '', $distort = false) {
        if (TCPDF_STATIC::empty_string(trim($code))) {
            return;
        }
        require_once(dirname(__FILE__) . '/tcpdf_barcodes_2d.php');
        // save current graphic settings
        $gvars = $this->getGraphicVars();
        // create new barcode object
        $barcodeobj = new TCPDF2DBarcode($code, $type);
        $arrcode = $barcodeobj->getBarcodeArray();
        if (($arrcode === false) OR empty($arrcode) OR ! isset($arrcode['num_rows']) OR ( $arrcode['num_rows'] == 0) OR ! isset($arrcode['num_cols']) OR ( $arrcode['num_cols'] == 0)) {
            $this->Error('Error in 2D barcode string');
        }
        // set default values
        if (!isset($style['position'])) {
            $style['position'] = '';
        }
        if (!isset($style['fgcolor'])) {
            $style['fgcolor'] = array(0, 0, 0); // default black
        }
        if (!isset($style['bgcolor'])) {
            $style['bgcolor'] = false; // default transparent
        }
        if (!isset($style['border'])) {
            $style['border'] = false;
        }
        // padding
        if (!isset($style['padding'])) {
            $style['padding'] = 0;
        } elseif ($style['padding'] === 'auto') {
            $style['padding'] = 4;
        }
        if (!isset($style['hpadding'])) {
            $style['hpadding'] = $style['padding'];
        } elseif ($style['hpadding'] === 'auto') {
            $style['hpadding'] = 4;
        }
        if (!isset($style['vpadding'])) {
            $style['vpadding'] = $style['padding'];
        } elseif ($style['vpadding'] === 'auto') {
            $style['vpadding'] = 4;
        }
        $hpad = (2 * $style['hpadding']);
        $vpad = (2 * $style['vpadding']);
        // cell (module) dimension
        if (!isset($style['module_width'])) {
            $style['module_width'] = 1; // width of a single module in points
        }
        if (!isset($style['module_height'])) {
            $style['module_height'] = 1; // height of a single module in points
        }
        if ($x === '') {
            $x = $this->x;
        }
        if ($y === '') {
            $y = $this->y;
        }
        // check page for no-write regions and adapt page margins if necessary
        list($x, $y) = $this->checkPageRegions($h, $x, $y);
        // number of barcode columns and rows
        $rows = $arrcode['num_rows'];
        $cols = $arrcode['num_cols'];
        if (($rows <= 0) || ($cols <= 0)) {
            $this->Error('Error in 2D barcode string');
        }
        // module width and height
        $mw = $style['module_width'];
        $mh = $style['module_height'];
        if (($mw <= 0) OR ( $mh <= 0)) {
            $this->Error('Error in 2D barcode string');
        }
        // get max dimensions
        if ($this->rtl) {
            $maxw = $x - $this->lMargin;
        } else {
            $maxw = $this->w - $this->rMargin - $x;
        }
        $maxh = ($this->h - $this->tMargin - $this->bMargin);
        $ratioHW = ((($rows * $mh) + $hpad) / (($cols * $mw) + $vpad));
        $ratioWH = ((($cols * $mw) + $vpad) / (($rows * $mh) + $hpad));
        if (!$distort) {
            if (($maxw * $ratioHW) > $maxh) {
                $maxw = $maxh * $ratioWH;
            }
            if (($maxh * $ratioWH) > $maxw) {
                $maxh = $maxw * $ratioHW;
            }
        }
        // set maximum dimesions
        if ($w > $maxw) {
            $w = $maxw;
        }
        if ($h > $maxh) {
            $h = $maxh;
        }
        // set dimensions
        if ((($w === '') OR ( $w <= 0)) AND ( ($h === '') OR ( $h <= 0))) {
            $w = ($cols + $hpad) * ($mw / $this->k);
            $h = ($rows + $vpad) * ($mh / $this->k);
        } elseif (($w === '') OR ( $w <= 0)) {
            $w = $h * $ratioWH;
        } elseif (($h === '') OR ( $h <= 0)) {
            $h = $w * $ratioHW;
        }
        // barcode size (excluding padding)
        $bw = ($w * $cols) / ($cols + $hpad);
        $bh = ($h * $rows) / ($rows + $vpad);
        // dimension of single barcode cell unit
        $cw = $bw / $cols;
        $ch = $bh / $rows;
        if (!$distort) {
            if (($cw / $ch) > ($mw / $mh)) {
                // correct horizontal distortion
                $cw = $ch * $mw / $mh;
                $bw = $cw * $cols;
                $style['hpadding'] = ($w - $bw) / (2 * $cw);
            } else {
                // correct vertical distortion
                $ch = $cw * $mh / $mw;
                $bh = $ch * $rows;
                $style['vpadding'] = ($h - $bh) / (2 * $ch);
            }
        }
        // fit the barcode on available space
        list($w, $h, $x, $y) = $this->fitBlock($w, $h, $x, $y, false);
        // set alignment
        $this->img_rb_y = $y + $h;
        // set alignment
        if ($this->rtl) {
            if ($style['position'] == 'L') {
                $xpos = $this->lMargin;
            } elseif ($style['position'] == 'C') {
                $xpos = ($this->w + $this->lMargin - $this->rMargin - $w) / 2;
            } elseif ($style['position'] == 'R') {
                $xpos = $this->w - $this->rMargin - $w;
            } else {
                $xpos = $x - $w;
            }
            $this->img_rb_x = $xpos;
        } else {
            if ($style['position'] == 'L') {
                $xpos = $this->lMargin;
            } elseif ($style['position'] == 'C') {
                $xpos = ($this->w + $this->lMargin - $this->rMargin - $w) / 2;
            } elseif ($style['position'] == 'R') {
                $xpos = $this->w - $this->rMargin - $w;
            } else {
                $xpos = $x;
            }
            $this->img_rb_x = $xpos + $w;
        }
        $xstart = $xpos + ($style['hpadding'] * $cw);
        $ystart = $y + ($style['vpadding'] * $ch);
        // barcode is always printed in LTR direction
        $tempRTL = $this->rtl;
        $this->rtl = false;
        // print background color
        if ($style['bgcolor']) {
            $this->Rect($xpos, $y, $w, $h, $style['border'] ? 'DF' : 'F', '', $style['bgcolor']);
        } elseif ($style['border']) {
            $this->Rect($xpos, $y, $w, $h, 'D');
        }
        // set foreground color
        $this->SetDrawColorArray($style['fgcolor']);
        // print barcode cells
        // for each row
        for ($r = 0; $r < $rows; ++$r) {
            $xr = $xstart;
            // for each column
            for ($c = 0; $c < $cols; ++$c) {
                if ($arrcode['bcode'][$r][$c] == 1) {
                    // draw a single barcode cell
                    $this->Rect($xr, $ystart, $cw, $ch, 'F', array(), $style['fgcolor']);
                }
                $xr += $cw;
            }
            $ystart += $ch;
        }
        // restore original direction
        $this->rtl = $tempRTL;
        // restore previous settings
        $this->setGraphicVars($gvars);
        // set pointer to align the next text/objects
        switch ($align) {
            case 'T': {
                    $this->y = $y;
                    $this->x = $this->img_rb_x;
                    break;
                }
            case 'M': {
                    $this->y = $y + round($h / 2);
                    $this->x = $this->img_rb_x;
                    break;
                }
            case 'B': {
                    $this->y = $this->img_rb_y;
                    $this->x = $this->img_rb_x;
                    break;
                }
            case 'N': {
                    $this->SetY($this->img_rb_y);
                    break;
                }
            default: {
                    break;
                }
        }
        $this->endlinex = $this->img_rb_x;
    }

    protected function setGraphicVars($gvars, $extended = false) {
        if ($this->state != 2) {
            return;
        }
        $this->FontFamily = $gvars['FontFamily'];
        $this->FontStyle = $gvars['FontStyle'];
        $this->FontSizePt = $gvars['FontSizePt'];
        $this->rMargin = $gvars['rMargin'];
        $this->lMargin = $gvars['lMargin'];
        $this->cell_padding = $gvars['cell_padding'];
        $this->cell_margin = $gvars['cell_margin'];
        $this->LineWidth = $gvars['LineWidth'];
        $this->linestyleWidth = $gvars['linestyleWidth'];
        $this->linestyleCap = $gvars['linestyleCap'];
        $this->linestyleJoin = $gvars['linestyleJoin'];
        $this->linestyleDash = $gvars['linestyleDash'];
        $this->textrendermode = $gvars['textrendermode'];
        $this->textstrokewidth = $gvars['textstrokewidth'];
        $this->DrawColor = $gvars['DrawColor'];
        $this->FillColor = $gvars['FillColor'];
        $this->TextColor = $gvars['TextColor'];
        $this->ColorFlag = $gvars['ColorFlag'];
        $this->bgcolor = $gvars['bgcolor'];
        $this->fgcolor = $gvars['fgcolor'];
        $this->htmlvspace = $gvars['htmlvspace'];
        $this->listindent = $gvars['listindent'];
        $this->listindentlevel = $gvars['listindentlevel'];
        $this->listnum = $gvars['listnum'];
        $this->listordered = $gvars['listordered'];
        $this->listcount = $gvars['listcount'];
        $this->lispacer = $gvars['lispacer'];
        $this->cell_height_ratio = $gvars['cell_height_ratio'];
        $this->font_stretching = $gvars['font_stretching'];
        $this->font_spacing = $gvars['font_spacing'];
        $this->alpha = $gvars['alpha'];
        if ($extended) {
            // restore extended values
            $this->lasth = $gvars['lasth'];
            $this->tMargin = $gvars['tMargin'];
            $this->bMargin = $gvars['bMargin'];
            $this->AutoPageBreak = $gvars['AutoPageBreak'];
            $this->PageBreakTrigger = $gvars['PageBreakTrigger'];
            $this->x = $gvars['x'];
            $this->y = $gvars['y'];
            $this->w = $gvars['w'];
            $this->h = $gvars['h'];
            $this->wPt = $gvars['wPt'];
            $this->hPt = $gvars['hPt'];
            $this->fwPt = $gvars['fwPt'];
            $this->fhPt = $gvars['fhPt'];
            $this->page = $gvars['page'];
            $this->current_column = $gvars['current_column'];
            $this->num_columns = $gvars['num_columns'];
        }
        $this->_out('' . $this->linestyleWidth . ' ' . $this->linestyleCap . ' ' . $this->linestyleJoin . ' ' . $this->linestyleDash . ' ' . $this->DrawColor . ' ' . $this->FillColor . '');
        if (!TCPDF_STATIC::empty_string($this->FontFamily)) {
            $this->SetFont($this->FontFamily, $this->FontStyle, $this->FontSizePt);
        }
    }

    protected function getGraphicVars() {
        $grapvars = array(
            'FontFamily' => $this->FontFamily,
            'FontStyle' => $this->FontStyle,
            'FontSizePt' => $this->FontSizePt,
            'rMargin' => $this->rMargin,
            'lMargin' => $this->lMargin,
            'cell_padding' => $this->cell_padding,
            'cell_margin' => $this->cell_margin,
            'LineWidth' => $this->LineWidth,
            'linestyleWidth' => $this->linestyleWidth,
            'linestyleCap' => $this->linestyleCap,
            'linestyleJoin' => $this->linestyleJoin,
            'linestyleDash' => $this->linestyleDash,
            'textrendermode' => $this->textrendermode,
            'textstrokewidth' => $this->textstrokewidth,
            'DrawColor' => $this->DrawColor,
            'FillColor' => $this->FillColor,
            'TextColor' => $this->TextColor,
            'ColorFlag' => $this->ColorFlag,
            'bgcolor' => $this->bgcolor,
            'fgcolor' => $this->fgcolor,
            'htmlvspace' => $this->htmlvspace,
            'listindent' => $this->listindent,
            'listindentlevel' => $this->listindentlevel,
            'listnum' => $this->listnum,
            'listordered' => $this->listordered,
            'listcount' => $this->listcount,
            'lispacer' => $this->lispacer,
            'cell_height_ratio' => $this->cell_height_ratio,
            'font_stretching' => $this->font_stretching,
            'font_spacing' => $this->font_spacing,
            'alpha' => $this->alpha,
            // extended
            'lasth' => $this->lasth,
            'tMargin' => $this->tMargin,
            'bMargin' => $this->bMargin,
            'AutoPageBreak' => $this->AutoPageBreak,
            'PageBreakTrigger' => $this->PageBreakTrigger,
            'x' => $this->x,
            'y' => $this->y,
            'w' => $this->w,
            'h' => $this->h,
            'wPt' => $this->wPt,
            'hPt' => $this->hPt,
            'fwPt' => $this->fwPt,
            'fhPt' => $this->fhPt,
            'page' => $this->page,
            'current_column' => $this->current_column,
            'num_columns' => $this->num_columns
        );
        return $grapvars;
    }

    protected function checkPageRegions($h, $x, $y) {
        // set default values
        if ($x === '') {
            $x = $this->x;
        }
        if ($y === '') {
            $y = $this->y;
        }
        if (!$this->check_page_regions OR empty($this->page_regions)) {
            // no page regions defined
            return array($x, $y);
        }
        if (empty($h)) {
            $h = $this->getCellHeight($this->FontSize);
        }
        // check for page break
        if ($this->checkPageBreak($h, $y)) {
            // the content will be printed on a new page
            $x = $this->x;
            $y = $this->y;
        }
        if ($this->num_columns > 1) {
            if ($this->rtl) {
                $this->lMargin = ($this->columns[$this->current_column]['x'] - $this->columns[$this->current_column]['w']);
            } else {
                $this->rMargin = ($this->w - $this->columns[$this->current_column]['x'] - $this->columns[$this->current_column]['w']);
            }
        } else {
            if ($this->rtl) {
                $this->lMargin = max($this->clMargin, $this->original_lMargin);
            } else {
                $this->rMargin = max($this->crMargin, $this->original_rMargin);
            }
        }
        // adjust coordinates and page margins
        foreach ($this->page_regions as $regid => $regdata) {
            if ($regdata['page'] == $this->page) {
                // check region boundaries
                if (($y > ($regdata['yt'] - $h)) AND ( $y <= $regdata['yb'])) {
                    // Y is inside the region
                    $minv = ($regdata['xb'] - $regdata['xt']) / ($regdata['yb'] - $regdata['yt']); // inverse of angular coefficient
                    $yt = max($y, $regdata['yt']);
                    $yb = min(($yt + $h), $regdata['yb']);
                    $xt = (($yt - $regdata['yt']) * $minv) + $regdata['xt'];
                    $xb = (($yb - $regdata['yt']) * $minv) + $regdata['xt'];
                    if ($regdata['side'] == 'L') { // left side
                        $new_margin = max($xt, $xb);
                        if ($this->lMargin < $new_margin) {
                            if ($this->rtl) {
                                // adjust left page margin
                                $this->lMargin = max(0, $new_margin);
                            }
                            if ($x < $new_margin) {
                                // adjust x position
                                $x = $new_margin;
                                if ($new_margin > ($this->w - $this->rMargin)) {
                                    // adjust y position
                                    $y = $regdata['yb'] - $h;
                                }
                            }
                        }
                    } elseif ($regdata['side'] == 'R') { // right side
                        $new_margin = min($xt, $xb);
                        if (($this->w - $this->rMargin) > $new_margin) {
                            if (!$this->rtl) {
                                // adjust right page margin
                                $this->rMargin = max(0, ($this->w - $new_margin));
                            }
                            if ($x > $new_margin) {
                                // adjust x position
                                $x = $new_margin;
                                if ($new_margin > $this->lMargin) {
                                    // adjust y position
                                    $y = $regdata['yb'] - $h;
                                }
                            }
                        }
                    }
                }
            }
        }
        return array($x, $y);
    }

    public function getCellHeight($fontsize, $padding = TRUE) {
        $height = ($fontsize * $this->cell_height_ratio);
        if ($padding) {
            $height += ($this->cell_padding['T'] + $this->cell_padding['B']);
        }
        return round($height, 6);
    }

    protected function fitBlock($w, $h, $x, $y, $fitonpage = false) {
        if ($w <= 0) {
            // set maximum width
            $w = ($this->w - $this->lMargin - $this->rMargin);
            if ($w <= 0) {
                $w = 1;
            }
        }
        if ($h <= 0) {
            // set maximum height
            $h = ($this->PageBreakTrigger - $this->tMargin);
            if ($h <= 0) {
                $h = 1;
            }
        }
        // resize the block to be vertically contained on a single page or single column
        if ($fitonpage OR $this->AutoPageBreak) {
            $ratio_wh = ($w / $h);
            if ($h > ($this->PageBreakTrigger - $this->tMargin)) {
                $h = $this->PageBreakTrigger - $this->tMargin;
                $w = ($h * $ratio_wh);
            }
            // resize the block to be horizontally contained on a single page or single column
            if ($fitonpage) {
                $maxw = ($this->w - $this->lMargin - $this->rMargin);
                if ($w > $maxw) {
                    $w = $maxw;
                    $h = ($w / $ratio_wh);
                }
            }
        }
        // Check whether we need a new page or new column first as this does not fit
        $prev_x = $this->x;
        $prev_y = $this->y;
        if ($this->checkPageBreak($h, $y) OR ( $this->y < $prev_y)) {
            $y = $this->y;
            if ($this->rtl) {
                $x += ($prev_x - $this->x);
            } else {
                $x += ($this->x - $prev_x);
            }
            $this->newline = true;
        }
        // resize the block to be contained on the remaining available page or column space
        if ($fitonpage) {
            $ratio_wh = ($w / $h);
            if (($y + $h) > $this->PageBreakTrigger) {
                $h = $this->PageBreakTrigger - $y;
                $w = ($h * $ratio_wh);
            }
            if ((!$this->rtl) AND ( ($x + $w) > ($this->w - $this->rMargin))) {
                $w = $this->w - $this->rMargin - $x;
                $h = ($w / $ratio_wh);
            } elseif (($this->rtl) AND ( ($x - $w) < ($this->lMargin))) {
                $w = $x - $this->lMargin;
                $h = ($w / $ratio_wh);
            }
        }
        return array($w, $h, $x, $y);
    }

    protected function checkPageBreak($h = 0, $y = '', $addpage = true) {
        if (TCPDF_STATIC::empty_string($y)) {
            $y = $this->y;
        }
        $current_page = $this->page;
        if ((($y + $h) > $this->PageBreakTrigger) AND ( $this->inPageBody()) AND ( $this->AcceptPageBreak())) {
            if ($addpage) {
                //Automatic page break
                $x = $this->x;
                $this->AddPage($this->CurOrientation);
                $this->y = $this->tMargin;
                $oldpage = $this->page - 1;
                if ($this->rtl) {
                    if ($this->pagedim[$this->page]['orm'] != $this->pagedim[$oldpage]['orm']) {
                        $this->x = $x - ($this->pagedim[$this->page]['orm'] - $this->pagedim[$oldpage]['orm']);
                    } else {
                        $this->x = $x;
                    }
                } else {
                    if ($this->pagedim[$this->page]['olm'] != $this->pagedim[$oldpage]['olm']) {
                        $this->x = $x + ($this->pagedim[$this->page]['olm'] - $this->pagedim[$oldpage]['olm']);
                    } else {
                        $this->x = $x;
                    }
                }
            }
            return true;
        }
        if ($current_page != $this->page) {
            // account for columns mode
            return true;
        }
        return false;
    }

    public function setColorArray($type, $color, $ret = false) {
        if (is_array($color)) {
            $color = array_values($color);
            // component: grey, RGB red or CMYK cyan
            $c = isset($color[0]) ? $color[0] : -1;
            // component: RGB green or CMYK magenta
            $m = isset($color[1]) ? $color[1] : -1;
            // component: RGB blue or CMYK yellow
            $y = isset($color[2]) ? $color[2] : -1;
            // component: CMYK black
            $k = isset($color[3]) ? $color[3] : -1;
            // color name
            $name = isset($color[4]) ? $color[4] : '';
            if ($c >= 0) {
                return $this->setColor($type, $c, $m, $y, $k, $ret, $name);
            }
        }
        return '';
    }

    public function SetDrawColorArray($color, $ret = false) {
        return $this->setColorArray('draw', $color, $ret);
    }

    public function SetTextColorArray($color, $ret = false) {
        return $this->setColorArray('text', $color, $ret);
    }

    public function SetCellPadding($pad) {
        if ($pad >= 0) {
            $this->cell_padding['L'] = $pad;
            $this->cell_padding['T'] = $pad;
            $this->cell_padding['R'] = $pad;
            $this->cell_padding['B'] = $pad;
        }
    }

    public function setColor($type, $col1 = 0, $col2 = -1, $col3 = -1, $col4 = -1, $ret = false, $name = '') {
        // set default values
        if (!is_numeric($col1)) {
            $col1 = 0;
        }
        if (!is_numeric($col2)) {
            $col2 = -1;
        }
        if (!is_numeric($col3)) {
            $col3 = -1;
        }
        if (!is_numeric($col4)) {
            $col4 = -1;
        }
        // set color by case
        $suffix = '';
        if (($col2 == -1) AND ( $col3 == -1) AND ( $col4 == -1)) {
            // Grey scale
            $col1 = max(0, min(255, $col1));
            $intcolor = array('G' => $col1);
            $pdfcolor = sprintf('%F ', ($col1 / 255));
            $suffix = 'g';
        } elseif ($col4 == -1) {
            // RGB
            $col1 = max(0, min(255, $col1));
            $col2 = max(0, min(255, $col2));
            $col3 = max(0, min(255, $col3));
            $intcolor = array('R' => $col1, 'G' => $col2, 'B' => $col3);
            $pdfcolor = sprintf('%F %F %F ', ($col1 / 255), ($col2 / 255), ($col3 / 255));
            $suffix = 'rg';
        } else {
            $col1 = max(0, min(100, $col1));
            $col2 = max(0, min(100, $col2));
            $col3 = max(0, min(100, $col3));
            $col4 = max(0, min(100, $col4));
            if (empty($name)) {
                // CMYK
                $intcolor = array('C' => $col1, 'M' => $col2, 'Y' => $col3, 'K' => $col4);
                $pdfcolor = sprintf('%F %F %F %F ', ($col1 / 100), ($col2 / 100), ($col3 / 100), ($col4 / 100));
                $suffix = 'k';
            } else {
                // SPOT COLOR
                $intcolor = array('C' => $col1, 'M' => $col2, 'Y' => $col3, 'K' => $col4, 'name' => $name);
                $this->AddSpotColor($name, $col1, $col2, $col3, $col4);
                $pdfcolor = $this->setSpotColor($type, $name, 100);
            }
        }
        switch ($type) {
            case 'draw': {
                    $pdfcolor .= strtoupper($suffix);
                    $this->DrawColor = $pdfcolor;
                    $this->strokecolor = $intcolor;
                    break;
                }
            case 'fill': {
                    $pdfcolor .= $suffix;
                    $this->FillColor = $pdfcolor;
                    $this->bgcolor = $intcolor;
                    break;
                }
            case 'text': {
                    $pdfcolor .= $suffix;
                    $this->TextColor = $pdfcolor;
                    $this->fgcolor = $intcolor;
                    break;
                }
        }
        $this->ColorFlag = ($this->FillColor != $this->TextColor);
        if (($type != 'text') AND ( $this->state == 2)) {
            if (!$ret) {
                $this->_out($pdfcolor);
            }
            return $pdfcolor;
        }
        return '';
    }

    function __construct($orientation = 'P', $unit = 'mm', $size = 'A4') {
        // Some checks
        $this->_dochecks();
        // Initialization of properties
        $this->page = 0;
        $this->n = 2;
        $this->buffer = '';
        $this->pages = array();
        $this->PageSizes = array();
        $this->state = 0;
        $this->fonts = array();
        $this->FontFiles = array();
        $this->diffs = array();
        $this->images = array();
        $this->links = array();
        $this->InHeader = false;
        $this->InFooter = false;
        $this->lasth = 0;
        $this->FontFamily = '';
        $this->FontStyle = '';
        $this->FontSizePt = 12;
        $this->underline = false;
        $this->DrawColor = '0 G';
        $this->FillColor = '0 g';
        $this->TextColor = '0 g';
        $this->ColorFlag = false;
        $this->ws = 0;
        // Font path
        if (defined('FPDF_FONTPATH')) {
            $this->fontpath = FPDF_FONTPATH;
            if (substr($this->fontpath, -1) != '/' && substr($this->fontpath, -1) != '\\')
                $this->fontpath .= '/';
        }
        elseif (is_dir(dirname(__FILE__) . '/font'))
            $this->fontpath = dirname(__FILE__) . '/font/';
        else
            $this->fontpath = '';
        // Core fonts
        $this->CoreFonts = array('courier', 'helvetica', 'times', 'symbol', 'zapfdingbats');
        // Scale factor
        if ($unit == 'pt')
            $this->k = 1;
        elseif ($unit == 'mm')
            $this->k = 72 / 25.4;
        elseif ($unit == 'cm')
            $this->k = 72 / 2.54;
        elseif ($unit == 'in')
            $this->k = 72;
        else
            $this->Error('Incorrect unit: ' . $unit);
        // Page sizes
        $this->StdPageSizes = array('a3' => array(841.89, 1190.55), 'a4' => array(595.28, 841.89), 'a5' => array(420.94, 595.28),
            'letter' => array(612, 792), 'legal' => array(612, 1008));
        $size = $this->_getpagesize($size);
        $this->DefPageSize = $size;
        $this->CurPageSize = $size;
        // Page orientation
        $orientation = strtolower($orientation);
        if ($orientation == 'p' || $orientation == 'portrait') {
            $this->DefOrientation = 'P';
            $this->w = $size[0];
            $this->h = $size[1];
        } elseif ($orientation == 'l' || $orientation == 'landscape') {
            $this->DefOrientation = 'L';
            $this->w = $size[1];
            $this->h = $size[0];
        } else
            $this->Error('Incorrect orientation: ' . $orientation);
        $this->CurOrientation = $this->DefOrientation;
        $this->wPt = $this->w * $this->k;
        $this->hPt = $this->h * $this->k;
        // Page margins (1 cm)
        $margin = 28.35 / $this->k;
        $this->SetMargins($margin, $margin);
        // Interior cell margin (1 mm)
        $this->cMargin = $margin / 10;
        // Line width (0.2 mm)
        $this->LineWidth = .567 / $this->k;
        // Automatic page break
        $this->SetAutoPageBreak(true, 2 * $margin);
        // Default display mode
        $this->SetDisplayMode('default');
        // Enable compression
        $this->SetCompression(true);
        // Set default PDF version number
        $this->PDFVersion = '1.3';
    }

    function SetMargins($left, $top, $right = null) {
        // Set left, top and right margins
        $this->lMargin = $left;
        $this->tMargin = $top;
        if ($right === null)
            $right = $left;
        $this->rMargin = $right;
    }

    function SetLeftMargin($margin) {
        // Set left margin
        $this->lMargin = $margin;
        if ($this->page > 0 && $this->x < $margin)
            $this->x = $margin;
    }

    function SetTopMargin($margin) {
        // Set top margin
        $this->tMargin = $margin;
    }

    function SetRightMargin($margin) {
        // Set right margin
        $this->rMargin = $margin;
    }

    function SetAutoPageBreak($auto, $margin = 0) {
        // Set auto page break mode and triggering margin
        $this->AutoPageBreak = $auto;
        $this->bMargin = $margin;
        $this->PageBreakTrigger = $this->h - $margin;
    }

    function SetDisplayMode($zoom, $layout = 'default') {
        // Set display mode in viewer
        if ($zoom == 'fullpage' || $zoom == 'fullwidth' || $zoom == 'real' || $zoom == 'default' || !is_string($zoom))
            $this->ZoomMode = $zoom;
        else
            $this->Error('Incorrect zoom display mode: ' . $zoom);
        if ($layout == 'single' || $layout == 'continuous' || $layout == 'two' || $layout == 'default')
            $this->LayoutMode = $layout;
        else
            $this->Error('Incorrect layout display mode: ' . $layout);
    }

    function SetCompression($compress) {
        // Set page compression
        if (function_exists('gzcompress'))
            $this->compress = $compress;
        else
            $this->compress = false;
    }

    function SetTitle($title, $isUTF8 = false) {
        // Title of document
        if ($isUTF8)
            $title = $this->_UTF8toUTF16($title);
        $this->title = $title;
    }

    function SetSubject($subject, $isUTF8 = false) {
        // Subject of document
        if ($isUTF8)
            $subject = $this->_UTF8toUTF16($subject);
        $this->subject = $subject;
    }

    function SetAuthor($author, $isUTF8 = false) {
        // Author of document
        if ($isUTF8)
            $author = $this->_UTF8toUTF16($author);
        $this->author = $author;
    }

    function SetKeywords($keywords, $isUTF8 = false) {
        // Keywords of document
        if ($isUTF8)
            $keywords = $this->_UTF8toUTF16($keywords);
        $this->keywords = $keywords;
    }

    function SetCreator($creator, $isUTF8 = false) {
        // Creator of document
        if ($isUTF8)
            $creator = $this->_UTF8toUTF16($creator);
        $this->creator = $creator;
    }

    function AliasNbPages($alias = '{nb}') {
        // Define an alias for total number of pages
        $this->AliasNbPages = $alias;
    }

    function Error($msg) {
        // Fatal error
        die('<b>FPDF error:</b> ' . $msg);
    }

    function Open() {
        // Begin document
        $this->state = 1;
    }

    function Close() {
        // Terminate document
        if ($this->state == 3)
            return;
        if ($this->page == 0)
            $this->AddPage();
        // Page footer
        $this->InFooter = true;
        $this->Footer();
        $this->InFooter = false;
        // Close page
        $this->_endpage();
        // Close document
        $this->_enddoc();
    }

    function AddPage($orientation = '', $size = '') {
        // Start a new page
        if ($this->state == 0)
            $this->Open();
        $family = $this->FontFamily;
        $style = $this->FontStyle . ($this->underline ? 'U' : '');
        $fontsize = $this->FontSizePt;
        $lw = $this->LineWidth;
        $dc = $this->DrawColor;
        $fc = $this->FillColor;
        $tc = $this->TextColor;
        $cf = $this->ColorFlag;
        if ($this->page > 0) {
            // Page footer
            $this->InFooter = true;
            $this->Footer();
            $this->InFooter = false;
            // Close page
            $this->_endpage();
        }
        // Start new page
        $this->_beginpage($orientation, $size);
        // Set line cap style to square
        $this->_out('2 J');
        // Set line width
        $this->LineWidth = $lw;
        $this->_out(sprintf('%.2F w', $lw * $this->k));
        // Set font
        if ($family)
            $this->SetFont($family, $style, $fontsize);
        // Set colors
        $this->DrawColor = $dc;
        if ($dc != '0 G')
            $this->_out($dc);
        $this->FillColor = $fc;
        if ($fc != '0 g')
            $this->_out($fc);
        $this->TextColor = $tc;
        $this->ColorFlag = $cf;
        // Page header
        $this->InHeader = true;
        $this->Header();
        $this->InHeader = false;
        // Restore line width
        if ($this->LineWidth != $lw) {
            $this->LineWidth = $lw;
            $this->_out(sprintf('%.2F w', $lw * $this->k));
        }
        // Restore font
        if ($family)
            $this->SetFont($family, $style, $fontsize);
        // Restore colors
        if ($this->DrawColor != $dc) {
            $this->DrawColor = $dc;
            $this->_out($dc);
        }
        if ($this->FillColor != $fc) {
            $this->FillColor = $fc;
            $this->_out($fc);
        }
        $this->TextColor = $tc;
        $this->ColorFlag = $cf;
    }

    function Header() {
        // To be implemented in your own inherited class
    }

    function Footer() {
        // To be implemented in your own inherited class
    }

    function PageNo() {
        // Get current page number
        return $this->page;
    }

    function SetDrawColor($r, $g = null, $b = null) {
        // Set color for all stroking operations
        if (($r == 0 && $g == 0 && $b == 0) || $g === null)
            $this->DrawColor = sprintf('%.3F G', $r / 255);
        else
            $this->DrawColor = sprintf('%.3F %.3F %.3F RG', $r / 255, $g / 255, $b / 255);
        if ($this->page > 0)
            $this->_out($this->DrawColor);
    }

    function SetFillColor($r, $g = null, $b = null) {
        // Set color for all filling operations
        if (($r == 0 && $g == 0 && $b == 0) || $g === null)
            $this->FillColor = sprintf('%.3F g', $r / 255);
        else
            $this->FillColor = sprintf('%.3F %.3F %.3F rg', $r / 255, $g / 255, $b / 255);
        $this->ColorFlag = ($this->FillColor != $this->TextColor);
        if ($this->page > 0)
            $this->_out($this->FillColor);
    }

    function SetTextColor($r, $g = null, $b = null) {
        // Set color for text
        if (($r == 0 && $g == 0 && $b == 0) || $g === null)
            $this->TextColor = sprintf('%.3F g', $r / 255);
        else
            $this->TextColor = sprintf('%.3F %.3F %.3F rg', $r / 255, $g / 255, $b / 255);
        $this->ColorFlag = ($this->FillColor != $this->TextColor);
    }

    function GetStringWidth($s) {
        // Get width of a string in the current font
        $s = (string) $s;
        $cw = &$this->CurrentFont['cw'];
        $w = 0;
        $l = strlen($s);
        for ($i = 0; $i < $l; $i++)
            $w += $cw[$s[$i]];
        return $w * $this->FontSize / 1000;
    }

    function SetLineWidth($width) {
        // Set line width
        $this->LineWidth = $width;
        if ($this->page > 0)
            $this->_out(sprintf('%.2F w', $width * $this->k));
    }

    function Line($x1, $y1, $x2, $y2) {
        // Draw a line
        $this->_out(sprintf('%.2F %.2F m %.2F %.2F l S', $x1 * $this->k, ($this->h - $y1) * $this->k, $x2 * $this->k, ($this->h - $y2) * $this->k));
    }

    function Rect($x, $y, $w, $h, $style = '') {
        // Draw a rectangle
        if ($style == 'F')
            $op = 'f';
        elseif ($style == 'FD' || $style == 'DF')
            $op = 'B';
        else
            $op = 'S';
        $this->_out(sprintf('%.2F %.2F %.2F %.2F re %s', $x * $this->k, ($this->h - $y) * $this->k, $w * $this->k, -$h * $this->k, $op));
    }

    function AddFont($family, $style = '', $file = '') {
        // Add a TrueType, OpenType or Type1 font
        $family = strtolower($family);
        if ($file == '')
            $file = str_replace(' ', '', $family) . strtolower($style) . '.php';
        $style = strtoupper($style);
        if ($style == 'IB')
            $style = 'BI';
        $fontkey = $family . $style;
        if (isset($this->fonts[$fontkey]))
            return;
        $info = $this->_loadfont($file);
        $info['i'] = count($this->fonts) + 1;
        if (!empty($info['diff'])) {
            // Search existing encodings
            $n = array_search($info['diff'], $this->diffs);
            if (!$n) {
                $n = count($this->diffs) + 1;
                $this->diffs[$n] = $info['diff'];
            }
            $info['diffn'] = $n;
        }
        if (!empty($info['file'])) {
            // Embedded font
            if ($info['type'] == 'TrueType')
                $this->FontFiles[$info['file']] = array('length1' => $info['originalsize']);
            else
                $this->FontFiles[$info['file']] = array('length1' => $info['size1'], 'length2' => $info['size2']);
        }
        $this->fonts[$fontkey] = $info;
    }

    function SetFont($family, $style = '', $size = 0) {
        // Select a font; size given in points
        if ($family == '')
            $family = $this->FontFamily;
        else
            $family = strtolower($family);
        $style = strtoupper($style);
        if (strpos($style, 'U') !== false) {
            $this->underline = true;
            $style = str_replace('U', '', $style);
        } else
            $this->underline = false;
        if ($style == 'IB')
            $style = 'BI';
        if ($size == 0)
            $size = $this->FontSizePt;
        // Test if font is already selected
        if ($this->FontFamily == $family && $this->FontStyle == $style && $this->FontSizePt == $size)
            return;
        // Test if font is already loaded
        $fontkey = $family . $style;
        if (!isset($this->fonts[$fontkey])) {
            // Test if one of the core fonts
            if ($family == 'arial')
                $family = 'helvetica';
            if (in_array($family, $this->CoreFonts)) {
                if ($family == 'symbol' || $family == 'zapfdingbats')
                    $style = '';
                $fontkey = $family . $style;
                if (!isset($this->fonts[$fontkey]))
                    $this->AddFont($family, $style);
            } else
                $this->Error('Undefined font: ' . $family . ' ' . $style);
        }
        // Select it
        $this->FontFamily = $family;
        $this->FontStyle = $style;
        $this->FontSizePt = $size;
        $this->FontSize = $size / $this->k;
        $this->CurrentFont = &$this->fonts[$fontkey];
        if ($this->page > 0)
            $this->_out(sprintf('BT /F%d %.2F Tf ET', $this->CurrentFont['i'], $this->FontSizePt));
    }

    function SetFontSize($size) {
        // Set font size in points
        if ($this->FontSizePt == $size)
            return;
        $this->FontSizePt = $size;
        $this->FontSize = $size / $this->k;
        if ($this->page > 0)
            $this->_out(sprintf('BT /F%d %.2F Tf ET', $this->CurrentFont['i'], $this->FontSizePt));
    }

    function AddLink() {
        // Create a new internal link
        $n = count($this->links) + 1;
        $this->links[$n] = array(0, 0);
        return $n;
    }

    function SetLink($link, $y = 0, $page = -1) {
        // Set destination of internal link
        if ($y == -1)
            $y = $this->y;
        if ($page == -1)
            $page = $this->page;
        $this->links[$link] = array($page, $y);
    }

    function Link($x, $y, $w, $h, $link) {
        // Put a link on the page
        $this->PageLinks[$this->page][] = array($x * $this->k, $this->hPt - $y * $this->k, $w * $this->k, $h * $this->k, $link);
    }

    function Text($x, $y, $txt) {
        // Output a string
        $s = sprintf('BT %.2F %.2F Td (%s) Tj ET', $x * $this->k, ($this->h - $y) * $this->k, $this->_escape($txt));
        if ($this->underline && $txt != '')
            $s .= ' ' . $this->_dounderline($x, $y, $txt);
        if ($this->ColorFlag)
            $s = 'q ' . $this->TextColor . ' ' . $s . ' Q';
        $this->_out($s);
    }

    function AcceptPageBreak() {
        // Accept automatic page break or not
        return $this->AutoPageBreak;
    }

    function Cell($w, $h = 0, $txt = '', $border = 0, $ln = 0, $align = '', $fill = false, $link = '') {
        // Output a cell
        $k = $this->k;
        if ($this->y + $h > $this->PageBreakTrigger && !$this->InHeader && !$this->InFooter && $this->AcceptPageBreak()) {
            // Automatic page break
            $x = $this->x;
            $ws = $this->ws;
            if ($ws > 0) {
                $this->ws = 0;
                $this->_out('0 Tw');
            }
            $this->AddPage($this->CurOrientation, $this->CurPageSize);
            $this->x = $x;
            if ($ws > 0) {
                $this->ws = $ws;
                $this->_out(sprintf('%.3F Tw', $ws * $k));
            }
        }
        if ($w == 0)
            $w = $this->w - $this->rMargin - $this->x;
        $s = '';
        if ($fill || $border == 1) {
            if ($fill)
                $op = ($border == 1) ? 'B' : 'f';
            else
                $op = 'S';
            $s = sprintf('%.2F %.2F %.2F %.2F re %s ', $this->x * $k, ($this->h - $this->y) * $k, $w * $k, -$h * $k, $op);
        }
        if (is_string($border)) {
            $x = $this->x;
            $y = $this->y;
            if (strpos($border, 'L') !== false)
                $s .= sprintf('%.2F %.2F m %.2F %.2F l S ', $x * $k, ($this->h - $y) * $k, $x * $k, ($this->h - ($y + $h)) * $k);
            if (strpos($border, 'T') !== false)
                $s .= sprintf('%.2F %.2F m %.2F %.2F l S ', $x * $k, ($this->h - $y) * $k, ($x + $w) * $k, ($this->h - $y) * $k);
            if (strpos($border, 'R') !== false)
                $s .= sprintf('%.2F %.2F m %.2F %.2F l S ', ($x + $w) * $k, ($this->h - $y) * $k, ($x + $w) * $k, ($this->h - ($y + $h)) * $k);
            if (strpos($border, 'B') !== false)
                $s .= sprintf('%.2F %.2F m %.2F %.2F l S ', $x * $k, ($this->h - ($y + $h)) * $k, ($x + $w) * $k, ($this->h - ($y + $h)) * $k);
        }
        if ($txt !== '') {
            if ($align == 'R')
                $dx = $w - $this->cMargin - $this->GetStringWidth($txt);
            elseif ($align == 'C')
                $dx = ($w - $this->GetStringWidth($txt)) / 2;
            else
                $dx = $this->cMargin;
            if ($this->ColorFlag)
                $s .= 'q ' . $this->TextColor . ' ';
            $txt2 = str_replace(')', '\\)', str_replace('(', '\\(', str_replace('\\', '\\\\', $txt)));
            $s .= sprintf('BT %.2F %.2F Td (%s) Tj ET', ($this->x + $dx) * $k, ($this->h - ($this->y + .5 * $h + .3 * $this->FontSize)) * $k, $txt2);
            if ($this->underline)
                $s .= ' ' . $this->_dounderline($this->x + $dx, $this->y + .5 * $h + .3 * $this->FontSize, $txt);
            if ($this->ColorFlag)
                $s .= ' Q';
            if ($link)
                $this->Link($this->x + $dx, $this->y + .5 * $h - .5 * $this->FontSize, $this->GetStringWidth($txt), $this->FontSize, $link);
        }
        if ($s)
            $this->_out($s);
        $this->lasth = $h;
        if ($ln > 0) {
            // Go to next line
            $this->y += $h;
            if ($ln == 1)
                $this->x = $this->lMargin;
        } else
            $this->x += $w;
    }

    function MultiCell($w, $h, $txt, $border = 0, $align = 'J', $fill = false) {
        // Output text with automatic or explicit line breaks
        $cw = &$this->CurrentFont['cw'];
        if ($w == 0)
            $w = $this->w - $this->rMargin - $this->x;
        $wmax = ($w - 2 * $this->cMargin) * 1000 / $this->FontSize;
        $s = str_replace("\r", '', $txt);
        $nb = strlen($s);
        if ($nb > 0 && $s[$nb - 1] == "\n")
            $nb--;
        $b = 0;
        if ($border) {
            if ($border == 1) {
                $border = 'LTRB';
                $b = 'LRT';
                $b2 = 'LR';
            } else {
                $b2 = '';
                if (strpos($border, 'L') !== false)
                    $b2 .= 'L';
                if (strpos($border, 'R') !== false)
                    $b2 .= 'R';
                $b = (strpos($border, 'T') !== false) ? $b2 . 'T' : $b2;
            }
        }
        $sep = -1;
        $i = 0;
        $j = 0;
        $l = 0;
        $ns = 0;
        $nl = 1;
        while ($i < $nb) {
            // Get next character
            $c = $s[$i];
            if ($c == "\n") {
                // Explicit line break
                if ($this->ws > 0) {
                    $this->ws = 0;
                    $this->_out('0 Tw');
                }
                $this->Cell($w, $h, substr($s, $j, $i - $j), $b, 2, $align, $fill);
                $i++;
                $sep = -1;
                $j = $i;
                $l = 0;
                $ns = 0;
                $nl++;
                if ($border && $nl == 2)
                    $b = $b2;
                continue;
            }
            if ($c == ' ') {
                $sep = $i;
                $ls = $l;
                $ns++;
            }
            $l += $cw[$c];
            if ($l > $wmax) {
                // Automatic line break
                if ($sep == -1) {
                    if ($i == $j)
                        $i++;
                    if ($this->ws > 0) {
                        $this->ws = 0;
                        $this->_out('0 Tw');
                    }
                    $this->Cell($w, $h, substr($s, $j, $i - $j), $b, 2, $align, $fill);
                } else {
                    if ($align == 'J') {
                        $this->ws = ($ns > 1) ? ($wmax - $ls) / 1000 * $this->FontSize / ($ns - 1) : 0;
                        $this->_out(sprintf('%.3F Tw', $this->ws * $this->k));
                    }
                    $this->Cell($w, $h, substr($s, $j, $sep - $j), $b, 2, $align, $fill);
                    $i = $sep + 1;
                }
                $sep = -1;
                $j = $i;
                $l = 0;
                $ns = 0;
                $nl++;
                if ($border && $nl == 2)
                    $b = $b2;
            } else
                $i++;
        }
        // Last chunk
        if ($this->ws > 0) {
            $this->ws = 0;
            $this->_out('0 Tw');
        }
        if ($border && strpos($border, 'B') !== false)
            $b .= 'B';
        $this->Cell($w, $h, substr($s, $j, $i - $j), $b, 2, $align, $fill);
        $this->x = $this->lMargin;
    }

    function Write($h, $txt, $link = '') {
        // Output text in flowing mode
        $cw = &$this->CurrentFont['cw'];
        $w = $this->w - $this->rMargin - $this->x;
        $wmax = ($w - 2 * $this->cMargin) * 1000 / $this->FontSize;
        $s = str_replace("\r", '', $txt);
        $nb = strlen($s);
        $sep = -1;
        $i = 0;
        $j = 0;
        $l = 0;
        $nl = 1;
        while ($i < $nb) {
            // Get next character
            $c = $s[$i];
            if ($c == "\n") {
                // Explicit line break
                $this->Cell($w, $h, substr($s, $j, $i - $j), 0, 2, '', 0, $link);
                $i++;
                $sep = -1;
                $j = $i;
                $l = 0;
                if ($nl == 1) {
                    $this->x = $this->lMargin;
                    $w = $this->w - $this->rMargin - $this->x;
                    $wmax = ($w - 2 * $this->cMargin) * 1000 / $this->FontSize;
                }
                $nl++;
                continue;
            }
            if ($c == ' ')
                $sep = $i;
            $l += $cw[$c];
            if ($l > $wmax) {
                // Automatic line break
                if ($sep == -1) {
                    if ($this->x > $this->lMargin) {
                        // Move to next line
                        $this->x = $this->lMargin;
                        $this->y += $h;
                        $w = $this->w - $this->rMargin - $this->x;
                        $wmax = ($w - 2 * $this->cMargin) * 1000 / $this->FontSize;
                        $i++;
                        $nl++;
                        continue;
                    }
                    if ($i == $j)
                        $i++;
                    $this->Cell($w, $h, substr($s, $j, $i - $j), 0, 2, '', 0, $link);
                }
                else {
                    $this->Cell($w, $h, substr($s, $j, $sep - $j), 0, 2, '', 0, $link);
                    $i = $sep + 1;
                }
                $sep = -1;
                $j = $i;
                $l = 0;
                if ($nl == 1) {
                    $this->x = $this->lMargin;
                    $w = $this->w - $this->rMargin - $this->x;
                    $wmax = ($w - 2 * $this->cMargin) * 1000 / $this->FontSize;
                }
                $nl++;
            } else
                $i++;
        }
        // Last chunk
        if ($i != $j)
            $this->Cell($l / 1000 * $this->FontSize, $h, substr($s, $j), 0, 0, '', 0, $link);
    }

    function Ln($h = null) {
        // Line feed; default value is last cell height
        $this->x = $this->lMargin;
        if ($h === null)
            $this->y += $this->lasth;
        else
            $this->y += $h;
    }

    function Image($file, $x = null, $y = null, $w = 0, $h = 0, $type = '', $link = '') {
        // Put an image on the page
        if (!isset($this->images[$file])) {
            // First use of this image, get info
            if ($type == '') {
                $pos = strrpos($file, '.');
                if (!$pos)
                    $this->Error('Image file has no extension and no type was specified: ' . $file);
                $type = substr($file, $pos + 1);
            }
            $type = strtolower($type);
            if ($type == 'jpeg')
                $type = 'jpg';
            $mtd = '_parse' . $type;
            if (!method_exists($this, $mtd))
                $this->Error('Unsupported image type: ' . $type);
            $info = $this->$mtd($file);
            $info['i'] = count($this->images) + 1;
            $this->images[$file] = $info;
        } else
            $info = $this->images[$file];

        // Automatic width and height calculation if needed
        if ($w == 0 && $h == 0) {
            // Put image at 96 dpi
            $w = -96;
            $h = -96;
        }
        if ($w < 0)
            $w = -$info['w'] * 72 / $w / $this->k;
        if ($h < 0)
            $h = -$info['h'] * 72 / $h / $this->k;
        if ($w == 0)
            $w = $h * $info['w'] / $info['h'];
        if ($h == 0)
            $h = $w * $info['h'] / $info['w'];

        // Flowing mode
        if ($y === null) {
            if ($this->y + $h > $this->PageBreakTrigger && !$this->InHeader && !$this->InFooter && $this->AcceptPageBreak()) {
                // Automatic page break
                $x2 = $this->x;
                $this->AddPage($this->CurOrientation, $this->CurPageSize);
                $this->x = $x2;
            }
            $y = $this->y;
            $this->y += $h;
        }

        if ($x === null)
            $x = $this->x;
        $this->_out(sprintf('q %.2F 0 0 %.2F %.2F %.2F cm /I%d Do Q', $w * $this->k, $h * $this->k, $x * $this->k, ($this->h - ($y + $h)) * $this->k, $info['i']));
        if ($link)
            $this->Link($x, $y, $w, $h, $link);
    }

    function GetX() {
        // Get x position
        return $this->x;
    }

    function SetX($x) {
        // Set x position
        if ($x >= 0)
            $this->x = $x;
        else
            $this->x = $this->w + $x;
    }

    function GetY() {
        // Get y position
        return $this->y;
    }

    function SetY($y) {
        // Set y position and reset x
        $this->x = $this->lMargin;
        if ($y >= 0)
            $this->y = $y;
        else
            $this->y = $this->h + $y;
    }

    function SetXY($x, $y) {
        // Set x and y positions
        $this->SetY($y);
        $this->SetX($x);
    }

    function Output($name = '', $dest = '') {
        // Output PDF to some destination
        if ($this->state < 3)
            $this->Close();
        $dest = strtoupper($dest);
        if ($dest == '') {
            if ($name == '') {
                $name = 'doc.pdf';
                $dest = 'I';
            } else
                $dest = 'F';
        }
        switch ($dest) {
            case 'I':
                // Send to standard output
                $this->_checkoutput();
                if (PHP_SAPI != 'cli') {
                    // We send to a browser
                    header('Content-Type: application/pdf');
                    header('Content-Disposition: inline; filename="' . $name . '"');
                    header('Cache-Control: private, max-age=0, must-revalidate');
                    header('Pragma: public');
                }
                echo $this->buffer;
                break;
            case 'D':
                // Download file
                $this->_checkoutput();
                header('Content-Type: application/x-download');
                header('Content-Disposition: attachment; filename="' . $name . '"');
                header('Cache-Control: private, max-age=0, must-revalidate');
                header('Pragma: public');
                echo $this->buffer;
                break;
            case 'F':
                // Save to local file
                $f = fopen($name, 'wb');
                if (!$f)
                    $this->Error('Unable to create output file: ' . $name);
                fwrite($f, $this->buffer, strlen($this->buffer));
                fclose($f);
                break;
            case 'S':
                // Return as a string
                return $this->buffer;
            default:
                $this->Error('Incorrect output destination: ' . $dest);
        }
        return '';
    }

    /*     * *****************************************************************************
     *                                                                              *
     *                              Protected methods                               *
     *                                                                              *
     * ***************************************************************************** */

    function _dochecks() {
        // Check availability of %F
        if (sprintf('%.1F', 1.0) != '1.0')
            $this->Error('This version of PHP is not supported');
        // Check mbstring overloading
        if (ini_get('mbstring.func_overload') & 2)
            $this->Error('mbstring overloading must be disabled');
        // Ensure runtime magic quotes are disabled
    }

    function _checkoutput() {
        if (PHP_SAPI != 'cli') {
            if (headers_sent($file, $line))
                $this->Error("Some data has already been output, can't send PDF file (output started at $file:$line)");
        }
        if (ob_get_length()) {
            // The output buffer is not empty
            if (preg_match('/^(\xEF\xBB\xBF)?\s*$/', ob_get_contents())) {
                // It contains only a UTF-8 BOM and/or whitespace, let's clean it
                ob_clean();
            } else
                $this->Error("Some data has already been output, can't send PDF file");
        }
    }

    function _getpagesize($size) {
        if (is_string($size)) {
            $size = strtolower($size);
            if (!isset($this->StdPageSizes[$size]))
                $this->Error('Unknown page size: ' . $size);
            $a = $this->StdPageSizes[$size];
            return array($a[0] / $this->k, $a[1] / $this->k);
        }
        else {
            if ($size[0] > $size[1])
                return array($size[1], $size[0]);
            else
                return $size;
        }
    }

    function _beginpage($orientation, $size) {
        $this->page++;
        $this->pages[$this->page] = '';
        $this->state = 2;
        $this->x = $this->lMargin;
        $this->y = $this->tMargin;
        $this->FontFamily = '';
        // Check page size and orientation
        if ($orientation == '')
            $orientation = $this->DefOrientation;
        else
            $orientation = strtoupper($orientation[0]);
        if ($size == '')
            $size = $this->DefPageSize;
        else
            $size = $this->_getpagesize($size);
        if ($orientation != $this->CurOrientation || $size[0] != $this->CurPageSize[0] || $size[1] != $this->CurPageSize[1]) {
            // New size or orientation
            if ($orientation == 'P') {
                $this->w = $size[0];
                $this->h = $size[1];
            } else {
                $this->w = $size[1];
                $this->h = $size[0];
            }
            $this->wPt = $this->w * $this->k;
            $this->hPt = $this->h * $this->k;
            $this->PageBreakTrigger = $this->h - $this->bMargin;
            $this->CurOrientation = $orientation;
            $this->CurPageSize = $size;
        }
        if ($orientation != $this->DefOrientation || $size[0] != $this->DefPageSize[0] || $size[1] != $this->DefPageSize[1])
            $this->PageSizes[$this->page] = array($this->wPt, $this->hPt);
    }

    function _endpage() {
        $this->state = 1;
    }

    function _loadfont($font) {
        // Load a font definition file from the font directory
        include($this->fontpath . $font);
        $a = get_defined_vars();
        if (!isset($a['name']))
            $this->Error('Could not include font definition file');
        return $a;
    }

    function _escape($s) {
        // Escape special characters in strings
        $s = str_replace('\\', '\\\\', $s);
        $s = str_replace('(', '\\(', $s);
        $s = str_replace(')', '\\)', $s);
        $s = str_replace("\r", '\\r', $s);
        return $s;
    }

    function _textstring($s) {
        // Format a text string
        return '(' . $this->_escape($s) . ')';
    }

    function _UTF8toUTF16($s) {
        // Convert UTF-8 to UTF-16BE with BOM
        $res = "\xFE\xFF";
        $nb = strlen($s);
        $i = 0;
        while ($i < $nb) {
            $c1 = ord($s[$i++]);
            if ($c1 >= 224) {
                // 3-byte character
                $c2 = ord($s[$i++]);
                $c3 = ord($s[$i++]);
                $res .= chr((($c1 & 0x0F) << 4) + (($c2 & 0x3C) >> 2));
                $res .= chr((($c2 & 0x03) << 6) + ($c3 & 0x3F));
            } elseif ($c1 >= 192) {
                // 2-byte character
                $c2 = ord($s[$i++]);
                $res .= chr(($c1 & 0x1C) >> 2);
                $res .= chr((($c1 & 0x03) << 6) + ($c2 & 0x3F));
            } else {
                // Single-byte character
                $res .= "\0" . chr($c1);
            }
        }
        return $res;
    }

    function _dounderline($x, $y, $txt) {
        // Underline text
        $up = $this->CurrentFont['up'];
        $ut = $this->CurrentFont['ut'];
        $w = $this->GetStringWidth($txt) + $this->ws * substr_count($txt, ' ');
        return sprintf('%.2F %.2F %.2F %.2F re f', $x * $this->k, ($this->h - ($y - $up / 1000 * $this->FontSize)) * $this->k, $w * $this->k, -$ut / 1000 * $this->FontSizePt);
    }

    function _parsejpg($file) {
        // Extract info from a JPEG file
        $a = getimagesize($file);
        if (!$a)
            $this->Error('Missing or incorrect image file: ' . $file);
        if ($a[2] != 2)
            $this->Error('Not a JPEG file: ' . $file);
        if (!isset($a['channels']) || $a['channels'] == 3)
            $colspace = 'DeviceRGB';
        elseif ($a['channels'] == 4)
            $colspace = 'DeviceCMYK';
        else
            $colspace = 'DeviceGray';
        $bpc = isset($a['bits']) ? $a['bits'] : 8;
        $data = file_get_contents($file);
        return array('w' => $a[0], 'h' => $a[1], 'cs' => $colspace, 'bpc' => $bpc, 'f' => 'DCTDecode', 'data' => $data);
    }

    function _parsepng($file) {
        // Extract info from a PNG file
        $f = fopen($file, 'rb');
        if (!$f)
            $this->Error('Can\'t open image file: ' . $file);
        $info = $this->_parsepngstream($f, $file);
        fclose($f);
        return $info;
    }

    function _parsepngstream($f, $file) {
        // Check signature
        if ($this->_readstream($f, 8) != chr(137) . 'PNG' . chr(13) . chr(10) . chr(26) . chr(10))
            $this->Error('Not a PNG file: ' . $file);

        // Read header chunk
        $this->_readstream($f, 4);
        if ($this->_readstream($f, 4) != 'IHDR')
            $this->Error('Incorrect PNG file: ' . $file);
        $w = $this->_readint($f);
        $h = $this->_readint($f);
        $bpc = ord($this->_readstream($f, 1));
        if ($bpc > 8)
            $this->Error('16-bit depth not supported: ' . $file);
        $ct = ord($this->_readstream($f, 1));
        if ($ct == 0 || $ct == 4)
            $colspace = 'DeviceGray';
        elseif ($ct == 2 || $ct == 6)
            $colspace = 'DeviceRGB';
        elseif ($ct == 3)
            $colspace = 'Indexed';
        else
            $this->Error('Unknown color type: ' . $file);
        if (ord($this->_readstream($f, 1)) != 0)
            $this->Error('Unknown compression method: ' . $file);
        if (ord($this->_readstream($f, 1)) != 0)
            $this->Error('Unknown filter method: ' . $file);
        if (ord($this->_readstream($f, 1)) != 0)
            $this->Error('Interlacing not supported: ' . $file);
        $this->_readstream($f, 4);
        $dp = '/Predictor 15 /Colors ' . ($colspace == 'DeviceRGB' ? 3 : 1) . ' /BitsPerComponent ' . $bpc . ' /Columns ' . $w;

        // Scan chunks looking for palette, transparency and image data
        $pal = '';
        $trns = '';
        $data = '';
        do {
            $n = $this->_readint($f);
            $type = $this->_readstream($f, 4);
            if ($type == 'PLTE') {
                // Read palette
                $pal = $this->_readstream($f, $n);
                $this->_readstream($f, 4);
            } elseif ($type == 'tRNS') {
                // Read transparency info
                $t = $this->_readstream($f, $n);
                if ($ct == 0)
                    $trns = array(ord(substr($t, 1, 1)));
                elseif ($ct == 2)
                    $trns = array(ord(substr($t, 1, 1)), ord(substr($t, 3, 1)), ord(substr($t, 5, 1)));
                else {
                    $pos = strpos($t, chr(0));
                    if ($pos !== false)
                        $trns = array($pos);
                }
                $this->_readstream($f, 4);
            }
            elseif ($type == 'IDAT') {
                // Read image data block
                $data .= $this->_readstream($f, $n);
                $this->_readstream($f, 4);
            } elseif ($type == 'IEND')
                break;
            else
                $this->_readstream($f, $n + 4);
        }
        while ($n);

        if ($colspace == 'Indexed' && empty($pal))
            $this->Error('Missing palette in ' . $file);
        $info = array('w' => $w, 'h' => $h, 'cs' => $colspace, 'bpc' => $bpc, 'f' => 'FlateDecode', 'dp' => $dp, 'pal' => $pal, 'trns' => $trns);
        if ($ct >= 4) {
            // Extract alpha channel
            if (!function_exists('gzuncompress'))
                $this->Error('Zlib not available, can\'t handle alpha channel: ' . $file);
            $data = gzuncompress($data);
            $color = '';
            $alpha = '';
            if ($ct == 4) {
                // Gray image
                $len = 2 * $w;
                for ($i = 0; $i < $h; $i++) {
                    $pos = (1 + $len) * $i;
                    $color .= $data[$pos];
                    $alpha .= $data[$pos];
                    $line = substr($data, $pos + 1, $len);
                    $color .= preg_replace('/(.)./s', '$1', $line);
                    $alpha .= preg_replace('/.(.)/s', '$1', $line);
                }
            } else {
                // RGB image
                $len = 4 * $w;
                for ($i = 0; $i < $h; $i++) {
                    $pos = (1 + $len) * $i;
                    $color .= $data[$pos];
                    $alpha .= $data[$pos];
                    $line = substr($data, $pos + 1, $len);
                    $color .= preg_replace('/(.{3})./s', '$1', $line);
                    $alpha .= preg_replace('/.{3}(.)/s', '$1', $line);
                }
            }
            unset($data);
            $data = gzcompress($color);
            $info['smask'] = gzcompress($alpha);
            if ($this->PDFVersion < '1.4')
                $this->PDFVersion = '1.4';
        }
        $info['data'] = $data;
        return $info;
    }

    function _readstream($f, $n) {
        // Read n bytes from stream
        $res = '';
        while ($n > 0 && !feof($f)) {
            $s = fread($f, $n);
            if ($s === false)
                $this->Error('Error while reading stream');
            $n -= strlen($s);
            $res .= $s;
        }
        if ($n > 0)
            $this->Error('Unexpected end of stream');
        return $res;
    }

    function _readint($f) {
        // Read a 4-byte integer from stream
        $a = unpack('Ni', $this->_readstream($f, 4));
        return $a['i'];
    }

    function _parsegif($file) {
        // Extract info from a GIF file (via PNG conversion)
        if (!function_exists('imagepng'))
            $this->Error('GD extension is required for GIF support');
        if (!function_exists('imagecreatefromgif'))
            $this->Error('GD has no GIF read support');
        $im = imagecreatefromgif($file);
        if (!$im)
            $this->Error('Missing or incorrect image file: ' . $file);
        imageinterlace($im, 0);
        $f = @fopen('php://temp', 'rb+');
        if ($f) {
            // Perform conversion in memory
            ob_start();
            imagepng($im);
            $data = ob_get_clean();
            imagedestroy($im);
            fwrite($f, $data);
            rewind($f);
            $info = $this->_parsepngstream($f, $file);
            fclose($f);
        } else {
            // Use temporary file
            $tmp = tempnam('.', 'gif');
            if (!$tmp)
                $this->Error('Unable to create a temporary file');
            if (!imagepng($im, $tmp))
                $this->Error('Error while saving to temporary file');
            imagedestroy($im);
            $info = $this->_parsepng($tmp);
            unlink($tmp);
        }
        return $info;
    }

    function _newobj() {
        // Begin a new object
        $this->n++;
        $this->offsets[$this->n] = strlen($this->buffer);
        $this->_out($this->n . ' 0 obj');
    }

    function _putstream($s) {
        $this->_out('stream');
        $this->_out($s);
        $this->_out('endstream');
    }

    function _out($s) {
        // Add a line to the document
        if ($this->state == 2)
            $this->pages[$this->page] .= $s . "\n";
        else
            $this->buffer .= $s . "\n";
    }

    function _putpages() {
        $nb = $this->page;
        if (!empty($this->AliasNbPages)) {
            // Replace number of pages
            for ($n = 1; $n <= $nb; $n++)
                $this->pages[$n] = str_replace($this->AliasNbPages, $nb, $this->pages[$n]);
        }
        if ($this->DefOrientation == 'P') {
            $wPt = $this->DefPageSize[0] * $this->k;
            $hPt = $this->DefPageSize[1] * $this->k;
        } else {
            $wPt = $this->DefPageSize[1] * $this->k;
            $hPt = $this->DefPageSize[0] * $this->k;
        }
        $filter = ($this->compress) ? '/Filter /FlateDecode ' : '';
        for ($n = 1; $n <= $nb; $n++) {
            // Page
            $this->_newobj();
            $this->_out('<</Type /Page');
            $this->_out('/Parent 1 0 R');
            if (isset($this->PageSizes[$n]))
                $this->_out(sprintf('/MediaBox [0 0 %.2F %.2F]', $this->PageSizes[$n][0], $this->PageSizes[$n][1]));
            $this->_out('/Resources 2 0 R');
            if (isset($this->PageLinks[$n])) {
                // Links
                $annots = '/Annots [';
                foreach ($this->PageLinks[$n] as $pl) {
                    $rect = sprintf('%.2F %.2F %.2F %.2F', $pl[0], $pl[1], $pl[0] + $pl[2], $pl[1] - $pl[3]);
                    $annots .= '<</Type /Annot /Subtype /Link /Rect [' . $rect . '] /Border [0 0 0] ';
                    if (is_string($pl[4]))
                        $annots .= '/A <</S /URI /URI ' . $this->_textstring($pl[4]) . '>>>>';
                    else {
                        $l = $this->links[$pl[4]];
                        $h = isset($this->PageSizes[$l[0]]) ? $this->PageSizes[$l[0]][1] : $hPt;
                        $annots .= sprintf('/Dest [%d 0 R /XYZ 0 %.2F null]>>', 1 + 2 * $l[0], $h - $l[1] * $this->k);
                    }
                }
                $this->_out($annots . ']');
            }
            if ($this->PDFVersion > '1.3')
                $this->_out('/Group <</Type /Group /S /Transparency /CS /DeviceRGB>>');
            $this->_out('/Contents ' . ($this->n + 1) . ' 0 R>>');
            $this->_out('endobj');
            // Page content
            $p = ($this->compress) ? gzcompress($this->pages[$n]) : $this->pages[$n];
            $this->_newobj();
            $this->_out('<<' . $filter . '/Length ' . strlen($p) . '>>');
            $this->_putstream($p);
            $this->_out('endobj');
        }
        // Pages root
        $this->offsets[1] = strlen($this->buffer);
        $this->_out('1 0 obj');
        $this->_out('<</Type /Pages');
        $kids = '/Kids [';
        for ($i = 0; $i < $nb; $i++)
            $kids .= (3 + 2 * $i) . ' 0 R ';
        $this->_out($kids . ']');
        $this->_out('/Count ' . $nb);
        $this->_out(sprintf('/MediaBox [0 0 %.2F %.2F]', $wPt, $hPt));
        $this->_out('>>');
        $this->_out('endobj');
    }

    function _putfonts() {
        $nf = $this->n;
        foreach ($this->diffs as $diff) {
            // Encodings
            $this->_newobj();
            $this->_out('<</Type /Encoding /BaseEncoding /WinAnsiEncoding /Differences [' . $diff . ']>>');
            $this->_out('endobj');
        }
        foreach ($this->FontFiles as $file => $info) {
            // Font file embedding
            $this->_newobj();
            $this->FontFiles[$file]['n'] = $this->n;
            $font = file_get_contents($this->fontpath . $file, true);
            if (!$font)
                $this->Error('Font file not found: ' . $file);
            $compressed = (substr($file, -2) == '.z');
            if (!$compressed && isset($info['length2']))
                $font = substr($font, 6, $info['length1']) . substr($font, 6 + $info['length1'] + 6, $info['length2']);
            $this->_out('<</Length ' . strlen($font));
            if ($compressed)
                $this->_out('/Filter /FlateDecode');
            $this->_out('/Length1 ' . $info['length1']);
            if (isset($info['length2']))
                $this->_out('/Length2 ' . $info['length2'] . ' /Length3 0');
            $this->_out('>>');
            $this->_putstream($font);
            $this->_out('endobj');
        }
        foreach ($this->fonts as $k => $font) {
            // Font objects
            $this->fonts[$k]['n'] = $this->n + 1;
            $type = $font['type'];
            $name = $font['name'];
            if ($type == 'Core') {
                // Core font
                $this->_newobj();
                $this->_out('<</Type /Font');
                $this->_out('/BaseFont /' . $name);
                $this->_out('/Subtype /Type1');
                if ($name != 'Symbol' && $name != 'ZapfDingbats')
                    $this->_out('/Encoding /WinAnsiEncoding');
                $this->_out('>>');
                $this->_out('endobj');
            }
            elseif ($type == 'Type1' || $type == 'TrueType') {
                // Additional Type1 or TrueType/OpenType font
                $this->_newobj();
                $this->_out('<</Type /Font');
                $this->_out('/BaseFont /' . $name);
                $this->_out('/Subtype /' . $type);
                $this->_out('/FirstChar 32 /LastChar 255');
                $this->_out('/Widths ' . ($this->n + 1) . ' 0 R');
                $this->_out('/FontDescriptor ' . ($this->n + 2) . ' 0 R');
                if (isset($font['diffn']))
                    $this->_out('/Encoding ' . ($nf + $font['diffn']) . ' 0 R');
                else
                    $this->_out('/Encoding /WinAnsiEncoding');
                $this->_out('>>');
                $this->_out('endobj');
                // Widths
                $this->_newobj();
                $cw = &$font['cw'];
                $s = '[';
                for ($i = 32; $i <= 255; $i++)
                    $s .= $cw[chr($i)] . ' ';
                $this->_out($s . ']');
                $this->_out('endobj');
                // Descriptor
                $this->_newobj();
                $s = '<</Type /FontDescriptor /FontName /' . $name;
                foreach ($font['desc'] as $k => $v)
                    $s .= ' /' . $k . ' ' . $v;
                if (!empty($font['file']))
                    $s .= ' /FontFile' . ($type == 'Type1' ? '' : '2') . ' ' . $this->FontFiles[$font['file']]['n'] . ' 0 R';
                $this->_out($s . '>>');
                $this->_out('endobj');
            }
            else {
                // Allow for additional types
                $mtd = '_put' . strtolower($type);
                if (!method_exists($this, $mtd))
                    $this->Error('Unsupported font type: ' . $type);
                $this->$mtd($font);
            }
        }
    }

    function _putimages() {
        foreach (array_keys($this->images) as $file) {
            $this->_putimage($this->images[$file]);
            unset($this->images[$file]['data']);
            unset($this->images[$file]['smask']);
        }
    }

    function _putimage(&$info) {
        $this->_newobj();
        $info['n'] = $this->n;
        $this->_out('<</Type /XObject');
        $this->_out('/Subtype /Image');
        $this->_out('/Width ' . $info['w']);
        $this->_out('/Height ' . $info['h']);
        if ($info['cs'] == 'Indexed')
            $this->_out('/ColorSpace [/Indexed /DeviceRGB ' . (strlen($info['pal']) / 3 - 1) . ' ' . ($this->n + 1) . ' 0 R]');
        else {
            $this->_out('/ColorSpace /' . $info['cs']);
            if ($info['cs'] == 'DeviceCMYK')
                $this->_out('/Decode [1 0 1 0 1 0 1 0]');
        }
        $this->_out('/BitsPerComponent ' . $info['bpc']);
        if (isset($info['f']))
            $this->_out('/Filter /' . $info['f']);
        if (isset($info['dp']))
            $this->_out('/DecodeParms <<' . $info['dp'] . '>>');
        if (isset($info['trns']) && is_array($info['trns'])) {
            $trns = '';
            for ($i = 0; $i < count($info['trns']); $i++)
                $trns .= $info['trns'][$i] . ' ' . $info['trns'][$i] . ' ';
            $this->_out('/Mask [' . $trns . ']');
        }
        if (isset($info['smask']))
            $this->_out('/SMask ' . ($this->n + 1) . ' 0 R');
        $this->_out('/Length ' . strlen($info['data']) . '>>');
        $this->_putstream($info['data']);
        $this->_out('endobj');
        // Soft mask
        if (isset($info['smask'])) {
            $dp = '/Predictor 15 /Colors 1 /BitsPerComponent 8 /Columns ' . $info['w'];
            $smask = array('w' => $info['w'], 'h' => $info['h'], 'cs' => 'DeviceGray', 'bpc' => 8, 'f' => $info['f'], 'dp' => $dp, 'data' => $info['smask']);
            $this->_putimage($smask);
        }
        // Palette
        if ($info['cs'] == 'Indexed') {
            $filter = ($this->compress) ? '/Filter /FlateDecode ' : '';
            $pal = ($this->compress) ? gzcompress($info['pal']) : $info['pal'];
            $this->_newobj();
            $this->_out('<<' . $filter . '/Length ' . strlen($pal) . '>>');
            $this->_putstream($pal);
            $this->_out('endobj');
        }
    }

    function _putxobjectdict() {
        foreach ($this->images as $image)
            $this->_out('/I' . $image['i'] . ' ' . $image['n'] . ' 0 R');
    }

    function _putresourcedict() {
        $this->_out('/ProcSet [/PDF /Text /ImageB /ImageC /ImageI]');
        $this->_out('/Font <<');
        foreach ($this->fonts as $font)
            $this->_out('/F' . $font['i'] . ' ' . $font['n'] . ' 0 R');
        $this->_out('>>');
        $this->_out('/XObject <<');
        $this->_putxobjectdict();
        $this->_out('>>');
    }

    function _putresources() {
        $this->_putfonts();
        $this->_putimages();
        // Resource dictionary
        $this->offsets[2] = strlen($this->buffer);
        $this->_out('2 0 obj');
        $this->_out('<<');
        $this->_putresourcedict();
        $this->_out('>>');
        $this->_out('endobj');
    }

    function _putinfo() {
        $this->_out('/Producer ' . $this->_textstring('FPDF ' . FPDF_VERSION));
        if (!empty($this->title))
            $this->_out('/Title ' . $this->_textstring($this->title));
        if (!empty($this->subject))
            $this->_out('/Subject ' . $this->_textstring($this->subject));
        if (!empty($this->author))
            $this->_out('/Author ' . $this->_textstring($this->author));
        if (!empty($this->keywords))
            $this->_out('/Keywords ' . $this->_textstring($this->keywords));
        if (!empty($this->creator))
            $this->_out('/Creator ' . $this->_textstring($this->creator));
        $this->_out('/CreationDate ' . $this->_textstring('D:' . @date('YmdHis')));
    }

    function _putcatalog() {
        $this->_out('/Type /Catalog');
        $this->_out('/Pages 1 0 R');
        if ($this->ZoomMode == 'fullpage')
            $this->_out('/OpenAction [3 0 R /Fit]');
        elseif ($this->ZoomMode == 'fullwidth')
            $this->_out('/OpenAction [3 0 R /FitH null]');
        elseif ($this->ZoomMode == 'real')
            $this->_out('/OpenAction [3 0 R /XYZ null null 1]');
        elseif (!is_string($this->ZoomMode))
            $this->_out('/OpenAction [3 0 R /XYZ null null ' . sprintf('%.2F', $this->ZoomMode / 100) . ']');
        if ($this->LayoutMode == 'single')
            $this->_out('/PageLayout /SinglePage');
        elseif ($this->LayoutMode == 'continuous')
            $this->_out('/PageLayout /OneColumn');
        elseif ($this->LayoutMode == 'two')
            $this->_out('/PageLayout /TwoColumnLeft');
    }

    function _putheader() {
        $this->_out('%PDF-' . $this->PDFVersion);
    }

    function _puttrailer() {
        $this->_out('/Size ' . ($this->n + 1));
        $this->_out('/Root ' . $this->n . ' 0 R');
        $this->_out('/Info ' . ($this->n - 1) . ' 0 R');
    }

    function _enddoc() {
        $this->_putheader();
        $this->_putpages();
        $this->_putresources();
        // Info
        $this->_newobj();
        $this->_out('<<');
        $this->_putinfo();
        $this->_out('>>');
        $this->_out('endobj');
        // Catalog
        $this->_newobj();
        $this->_out('<<');
        $this->_putcatalog();
        $this->_out('>>');
        $this->_out('endobj');
        // Cross-ref
        $o = strlen($this->buffer);
        $this->_out('xref');
        $this->_out('0 ' . ($this->n + 1));
        $this->_out('0000000000 65535 f ');
        for ($i = 1; $i <= $this->n; $i++)
            $this->_out(sprintf('%010d 00000 n ', $this->offsets[$i]));
        // Trailer
        $this->_out('trailer');
        $this->_out('<<');
        $this->_puttrailer();
        $this->_out('>>');
        $this->_out('startxref');
        $this->_out($o);
        $this->_out('%%EOF');
        $this->state = 3;
    }

// End of class
}

// Handle special IE contype request
if (isset($_SERVER['HTTP_USER_AGENT']) && $_SERVER['HTTP_USER_AGENT'] == 'contype') {
    header('Content-Type: application/pdf');
    exit;
}
?>
