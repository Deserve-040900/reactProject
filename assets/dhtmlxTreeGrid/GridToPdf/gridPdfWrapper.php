<?php

class gridPdfWrapper {

	private $imgChOnColor = './imgs/ChOnColor.png';
	private $imgChOnGray = './imgs/ChOnGray.png';
	private $imgChOnBw = './imgs/ChOnBw.png';
	
	private $imgChOffColor = './imgs/ChOffColor.png';
	private $imgChOffGray = './imgs/ChOffGray.png';
	private $imgChOffBw = './imgs/ChOffBw.png';
	
	private $imgRaOnColor = './imgs/RaOnColor.png';
	private $imgRaOnGray = './imgs/RaOnGray.png';
	private $imgRaOnBw = './imgs/RaOnBw.png';
	
	private $imgRaOffColor = './imgs/RaOffColor.png';
	private $imgRaOffGray = './imgs/RaOffGray.png';
	private $imgRaOffBw = './imgs/RaOffBw.png';
	
	private $chWidth = 12;
	private $chHeight = 12;
	private $raWidth = 12;
	private $raHeight = 12;

	private $pageWidth;
	private $pageHeight;
	private $offsetTop;
	private $offsetBottom;
	private $offsetLeft;
	private $offsetRight;
	private $cb;
	private $rows;
	private $columns;
	private $rowsNum;
	
	private $headerHeight;
	private $summaryWidth;
	private $rowHeader;
	private $gridHeight;
	private $pageNumberHeight;
	
	private $orientation;

	private $fontFamily;
	private $headerFontSize;
	private $pageFontSize;
	private $gridFontSize;
	
	
	private $bgColor;
	private $lineColor;
	private $headerTextColor;
	private $scaleOneColor;
	private $scaleTwoColor;
	private $gridTextColor;
	private $pageTextColor;
	private $profile;
	
	public function gridPdfWrapper($offsetTop, $offsetRight, $offsetBottom, $offsetLeft, $pageNumberHeight, $fontFamily, $orientation='portrait') {
		$this->orientation = $orientation;
		$this->cb = new Cezpdf('a4', $this->orientation);
		$this->fontFamily = $fontFamily;
		$this->pageNumberHeight = $pageNumberHeight;

		$this->offsetTop = $offsetTop;
		$this->offsetRight = $offsetRight;
		$this->offsetBottom = $offsetBottom;
		$this->offsetLeft = $offsetLeft;
		$this->cb->selectFont('./lib/fonts/'.$this->fontFamily.'.afm'/*, 'WinAnsiEncoding'*/); 	// fontFamily
		$this->pageWidth = $this->cb->ez['pageWidth'] - $this->offsetLeft - $this->offsetRight;	// Scheduler container Width
		$this->pageHeight = $this->cb->ez['pageHeight'] - $this->offsetTop - $this->offsetBottom - $this->pageNumberHeight;
	}

	
	public function setPageSize($offsetTop, $offsetRight, $offsetBottom, $offsetLeft) {
		$this->offsetTop = $offsetTop;
		$this->offsetLeft = $offsetLeft;
		$this->offsetBottom = $offsetBottom;
		$this->offsetRight = $offsetRight;
		$this->pageWidth = $this->cb->ez['pageWidth'] - $this->offsetLeft - $this->offsetRight;
		$this->pageHeight = $this->cb->ez['pageHeight'] - $this->offsetTop - $this->offsetBottom;
	}
	
	public function pdfOut() {
		$this->cb->ezStream();
	}
	
	
	public function setImgChNames($imgChOnColor = '', $imgChOffColor = '', $imgChOnGray = '', $imgChOffGray = '', $imgChOnBw = '', $imgChOffBw = '') {
		if ($imgChOnColor != '') {
			$this->imgChOnColor = $imgChOnColor;
		}
		if ($imgChOffColor != '') {
			$this->imgChOffColor = $imgChOffColor;
		}
		
		if ($imgChOnGray != '') {
			$this->imgChOnGray = $imgChOnGray;
		}
		if ($imgChOffGray != '') {
			$this->imgChOffGray = $imgChOffGray;
		}
		
		if ($imgChOnBw != '') {
			$this->imgChOnBw = $imgChOnBw;
		}
		if ($imgChOffBw != '') {
			$this->imgChOffBw = $imgChOffBw;
		}
	}
	
	
	public function setImgRaNames($imgRaOnColor = '', $imgRaOffColor = '', $imgRaOnGray = '', $imgRaOffGray = '', $imgRaOnBw = '', $imgRaOffBw = '') {
		if ($imgRaOnColor != '') {
			$this->imgRaOnColor = $imgRaOnColor;
		}
		if ($imgRaOffColor != '') {
			$this->imgRaOffColor = $imgRaOffColor;
		}
		
		if ($imgRaOnGray != '') {
			$this->imgRaOnGray = $imgRaOnGray;
		}
		if ($imgRaOffGray != '') {
			$this->imgRaOffGray = $imgRaOffGray;
		}
		
		if ($imgRaOnBw != '') {
			$this->imgRaOnBw = $imgRaOnBw;
		}
		if ($imgRaOffBw != '') {
			$this->imgRaOffBw = $imgRaOffBw;
		}
	}
		
	public function setImgsSizes($chWidth, $chHeight, $raWidth, $raHeight) {
		if ($imgChOn != '') {
			$this->imgChOn = $imgChOn;
		}
		if ($imgChOff != '') {
			$this->imgChOff = $imgChOff;
		}
		
		if ($imgRaOn != '') {
			$this->imgRaOn = $imgRaOn;
		}
		if ($imgRaOff != '') {
			$this->imgRaOff = $imgRaOff;
		}
	}
	
	public function drawContainer($bgColor, $lineColor) {
		$this->bgColor = $this->convertColor($bgColor);
		$this->lineColor = $this->convertColor($lineColor);
		
		$this->cb->setStrokeColor($this->lineColor['R'], $this->lineColor['G'], $this->lineColor['B']);
		$this->cb->setColor($this->bgColor['R'], $this->bgColor['G'], $this->bgColor['B']);
		$this->cb->filledRectangle($this->offsetLeft, $this->offsetBottom, $this->pageWidth, $this->pageHeight);
	}
	
	
	public function drawHeader($columns, $summaryWidth, $headerTextColor, $headerFontSize) {
		$this->summaryWidth = $summaryWidth;
		$this->headerFontSize = $headerFontSize;
		$this->headerTextColor = $this->convertColor($headerTextColor);
		$this->columns = $columns;
		
		$headerX = $this->offsetLeft;
		$headerY = $this->offsetBottom + $this->pageHeight - $this->headerHeight;
		
		
		$this->cb->setColor($this->lineColor['R'], $this->lineColor['G'], $this->lineColor['B']);
		for ($i = 0; $i < count($columns); $i++) {
			$colWidth = (int) $columns[$i]['width']*$this->pageWidth/$this->summaryWidth;
			$this->cb->setColor($this->lineColor['R'], $this->lineColor['G'], $this->lineColor['B']);
			$this->cb->rectangle($headerX, $headerY, $colWidth, $this->headerHeight);
			$fontHeight = $this->cb->getFontHeight($this->headerFontSize);
			$this->cb->setColor($this->headerTextColor['R'], $this->headerTextColor['G'], $this->headerTextColor['B']);
			$this->cb->AddTextWrap($headerX, $headerY +$this->headerHeight/2 - $fontHeight/2, $colWidth, $this->headerFontSize, $columns[$i]['text'], 'center');
			
			if ($this->profile == 'bw') {
				$yStart = $this->offsetBottom + $this->pageHeight - $this->headerHeight - $this->gridHeight;
				$yEnd = $this->offsetBottom + $this->pageHeight - $this->headerHeight;
				$x = $headerX + $colWidth;
				$this->cb->line($x, $yStart, $x, $yEnd);
			}
			$headerX += $colWidth;
		}
	}
	
	
	public function drawGrid($headerHeight, $scaleOneColor, $scaleTwoColor, $rowHeight, $rows, $profile, $startRow) {
		$this->scaleOneColor = $this->convertColor($scaleOneColor);
		$this->scaleTwoColor = $this->convertColor($scaleTwoColor);
		$this->rowHeight = $rowHeight;
		$this->headerHeight = $headerHeight;
		$this->rows = $rows;
		$this->profile = $profile;
		$this->rowsNum = floor(($this->pageHeight - $this->headerHeight)/$this->rowHeight);
		if ($this->rowsNum > (count($this->rows) - $startRow)) {
			$this->rowsNum = count($this->rows) - $startRow;
		}
		$this->gridHeight = $this->rowHeight*$this->rowsNum;
		
		$this->cb->setColor($this->scaleOneColor['R'], $this->scaleOneColor['G'], $this->scaleOneColor['B']);
		$this->cb->filledRectangle($this->offsetLeft, $this->offsetBottom, $this->pageWidth, $this->pageHeight - $this->headerHeight);

		$rowX = $this->offsetLeft;
		$rowY = $this->offsetBottom + $this->pageHeight - $this->headerHeight - $this->rowHeight*2;
		for ($i = 0; $i < $this->rowsNum - 1; $i++) {
			if ($i%2 == 0) {
				$this->cb->setColor($this->scaleTwoColor['R'], $this->scaleTwoColor['G'], $this->scaleTwoColor['B']);
				$this->cb->filledRectangle($rowX, $rowY, $this->pageWidth, $this->rowHeight);
				}
			if ($this->profile == 'bw') {
				$this->cb->setColor($this->lineColor['R'], $this->lineColor['G'], $this->lineColor['B']);
				$this->cb->line($rowX, $rowY + $this->rowHeight, $rowX + $this->pageWidth, $rowY + $this->rowHeight);
			}
			$rowY -= $this->rowHeight;
		}
		$this->cb->setColor($this->lineColor['R'], $this->lineColor['G'], $this->lineColor['B']);
		if ($this->gridHeight > $this->pageHeight) {
			$this->gridHeight = $this->rowHeight*($this->rowsNum - 1);
		}
		$borderY = $this->offsetBottom + $this->pageHeight - $this->headerHeight - $this->gridHeight;
		$this->cb->rectangle($this->offsetLeft, $borderY, $this->pageWidth, $this->gridHeight);
	}
	
	
	public function drawValues($gridTextColor, $gridFontSize, $startRow, $offsetTextH = 4, $offsetTextV = 1) {
		$this->gridTextColor = $this->convertColor($gridTextColor);
		$this->gridFontSize = $gridFontSize;
		
//		echo $startRow."<br>";
		
		$this->cb->setColor($this->gridTextColor['R'], $this->gridTextColor['G'], $this->gridTextColor['B']);
		
		$cellY = $this->offsetBottom + $this->pageHeight - $this->headerHeight - $this->rowHeight;
		for ($i = 0; $i < $this->rowsNum; $i++) {
			$cellX = $this->offsetLeft;
			for ($j = 0; $j < count($this->rows[$i]); $j++) {
				$rowNumber = $i + $startRow;
				$cellWidth = $this->columns[$j]['width']*$this->pageWidth/$this->summaryWidth;
				$fontHeight = $this->cb->getFontHeight($this->gridFontSize);
				switch ($this->columns[$j]['type']) {
					case 'ch':
						$this->drawValueCh($this->rows[$rowNumber][$j], $cellX, $cellY, $cellWidth);
						break;
					case 'ra':
						$this->drawValueRa($this->rows[$rowNumber][$j], $cellX, $cellY, $cellWidth);
						break;
					default:
						$text = $this->wrapText($this->rows[$rowNumber][$j], $cellWidth - $offsetTextH*2, $this->gridFontSize);
						$this->cb->AddTextWrap($cellX + $offsetTextH, $cellY + $this->rowHeight/2 - $fontHeight/2 + $offsetTextV, $cellWidth - $offsetTextH*2, $this->gridFontSize, $text, $this->columns[$j]['align']);
						break;
				}
				$cellX += $cellWidth;
			}
			$cellY -= $this->rowHeight;
		}
	}
	
	
	private function drawValueCh($value, $cellX, $cellY, $cellWidth) {
		if ($value == '1') {
			switch ($this->profile) {
				case 'color':
					$imageName = $this->imgChOnColor;
					break;
				case 'gray':
					$imageName = $this->imgChOnGray;
					break;
				case 'bw':
					$imageName = $this->imgChOnBw;
					break;
				default:
					$imageName = $this->imgChOnGray;
					break;
			}

		} else {
			switch ($this->profile) {
				case 'color':
					$imageName = $this->imgChOffColor;
					break;
				case 'gray':
					$imageName = $this->imgChOffGray;
					break;
				case 'bw':
					$imageName = $this->imgChOffBw;
					break;
				default:
					$imageName = $this->imgChOffGray;
					break;
			}
		}
		
		$cellX += $cellWidth/2 - $this->chWidth/2;
		$cellY += $this->rowHeight/2 - $this->chHeight/2;
		$this->cb->addPngFromFile($imageName, $cellX, $cellY, $this->chWidth, $this->chHeight);
	}
	
	
	private function drawValueRa($value, $cellX, $cellY, $cellWidth) {
		if ($value == '1') {
			switch ($this->profile) {
				case 'color':
					$imageName = $this->imgRaOnColor;
					break;
				case 'gray':
					$imageName = $this->imgRaOnGray;
					break;
				case 'bw':
					$imageName = $this->imgRaOnBw;
					break;
				default:
					$imageName = $this->imgRaOnGray;
					break;
			}
		} else {
			switch ($this->profile) {
				case 'color':
					$imageName = $this->imgRaOffColor;
					break;
				case 'gray':
					$imageName = $this->imgRaOffGray;
					break;
				case 'bw':
					$imageName = $this->imgRaOffBw;
					break;
				default:
					$imageName = $this->imgRaOffGray;
					break;
			}
		}
		
		$cellX += $cellWidth/2 - $this->raWidth/2;
		$cellY += $this->rowHeight/2 - $this->raHeight/2;
		$this->cb->addPngFromFile($imageName, $cellX, $cellY, $this->raWidth, $this->raHeight);
	}
	
	
	public function drawImgHeader($fileName, $headerHeight, $headerWidth, $fileType) {
		switch ($fileType) {
			case 'jpg':
				$this->cb->addJpegFromFile($fileName, $this->offsetLeft, $this->offsetBottom + $this->pageHeight + 1);
				break;
			case 'png':
				$this->cb->addPngFromFile($fileName, $this->offsetLeft, $this->offsetBottom + $this->pageHeight + 1, $headerWidth, $headerHeight);
				break;
			default:
				break;
		}
	}
	
	
	public function drawImgFooter($fileName, $footerHeight, $footerWidth, $fileType) {
		switch ($fileType) {
			case 'jpg':
				$this->cb->addJpegFromFile($fileName, $this->offsetLeft, $this->offsetBottom + $this->pageHeight - $this->headerHeight - $this->gridHeight - $this->pageNumberHeight - $footerHeight - 1);
				break;
			case 'png':
				$this->cb->addPngFromFile($fileName, $this->offsetLeft, $this->offsetBottom + $this->pageHeight - $this->headerHeight - $this->gridHeight - $this->pageNumberHeight - $footerHeight - 1, $footerWidth, $footerHeight);
				break;
			default:
				break;
		}
	}
	
	
	public function drawPageNumber($pageTextColor, $pageFontSize) {
		$this->pageFontSize = $pageFontSize;
		$this->pageTextColor = $this->convertColor($pageTextColor);
		$textY = $this->offsetBottom + $this->pageHeight - $this->headerHeight - $this->gridHeight - $this->pageNumberHeight;
		$textX = $this->offsetLeft + $this->pageWidth;
		$this->cb->setColor($this->pageTextColor['R'], $this->pageTextColor['G'], $this->pageTextColor['B']);
		$this->cb->ezStopPageNumbers(0, 0, 1);
		$this->cb->ezStartPageNumbers($textX, $textY, $this->pageFontSize, 'left', 'Page {PAGENUM} from {TOTALPAGENUM}'); 
		
	}
	
	
	public function getPageHeight() {
		return $this->pageHeight;
	}
	
	
	public function createPage() {
		$this->cb->ezNewPage();
	}
	
	
	private function convertColor($colorHex) { // convert color from "ffffff" to Array('R' => 1, 'G' => 1, 'B' => 1)
		$r = hexdec(substr($colorHex, 0, 2));
		$g = hexdec(substr($colorHex, 2, 2));
		$b = hexdec(substr($colorHex, 4, 2));
		$final = Array();
		$final['R'] = $r/255;
		$final['G'] = $g/255;
		$final['B'] = $b/255;
		return $final;
	}


	private function wrapText($text, $width, $size) {
		$result = '';
		if ($this->cb->getTextWidth($size, $text) < $width) {
			return $text;
		}
		$dotesW = $this->cb->getTextWidth($size, "...");
		for ($i = 0; $i < strlen($text); $i++) {
			if ($this->cb->getTextWidth($size, $result.$text[$i]) < $width - $dotesW) {
				$result .= $text[$i];
			}
			else {
			break;
			}
		}
		return $result."...";
	}
}


?>