<?php

class gridPdfGenerator {

	public $offsetTop = 25;
	public $offsetBottom = 25;
	public $offsetLeft = 25;
	public $offsetRight = 25;
	public $headerHeight = 20;
	public $rowHeight = 14;
	public $minColumnWidth = 30;
	public $pageNumberHeight = 10;

	public $fontFamily = 'Helvetica';
	public $headerFontSize = 9;
	public $gridFontSize = 8;
	public $pageFontSize = 8;
	
	public $bgColor = 'D1E5FE';
	public $lineColor = 'A4BED4';
	public $headerTextColor = '000000';
	public $scaleOneColor = 'FFFFFF';
	public $scaleTwoColor = 'E3EFFF';
	public $gridTextColor = '000000';
	public $pageTextColor = '000000';
	
	
	private $orientation = 'portrait';
	private $columns = Array();
	private $rows = Array();
	private $summaryWidth;
	private $profile;
	private $header = false;
	private $footer = false;
	private $headerFile;
	private $headerImgWidth = 0;
	private $headerImgHeight = 0;
	private $headerImgFileType;
	private $footerFile;
	private $footerImgWidth = 0;
	private $footerImgHeight = 0;
	private $footerImgFileType;
	private $pageHeader = false;
	private $pageFooter = false;
	
	public function printGrid($xml) {
		$this->headerParse($xml->head);
		$this->mainParse($xml);
		$this->rowsParse($xml->row);
		$this->printGridPdf();
	}
	
	
	private function setProfile() {
		switch ($this->profile) {
			case 'color':
				$this->bgColor = 'D1E5FE';
				$this->lineColor = 'A4BED4';
				$this->headerTextColor = '000000';
				$this->scaleOneColor = 'FFFFFF';
				$this->scaleTwoColor = 'E3EFFF';
				$this->gridTextColor = '000000';
				$this->pageTextColor = '000000';
				break;
			case 'gray':
				$this->bgColor = 'E3E3E3';
				$this->lineColor = 'B8B8B8';
				$this->headerTextColor = '000000';
				$this->scaleOneColor = 'FFFFFF';
				$this->scaleTwoColor = 'EDEDED';
				$this->gridTextColor = '000000';
				$this->pageTextColor = '000000';
				break;
			case 'bw':
				$this->bgColor = 'FFFFFF';
				$this->lineColor = '000000';
				$this->headerTextColor = '000000';
				$this->scaleOneColor = 'FFFFFF';
				$this->scaleTwoColor = 'FFFFFF';
				$this->gridTextColor = '000000';
				$this->pageTextColor = '000000';
				break;
		}
	}
	
	
	private function mainParse($xml) {
		$this->profile = (string) $xml->attributes()->profile;
		if ($xml->attributes()->header) {
			$this->header = (string) $xml->attributes()->header;
		}
		if ($xml->attributes()->footer) {
			$this->footer = (string) $xml->attributes()->footer;
		}
		if ($xml->attributes()->pageheader) {
			$this->pageHeader = (string) $xml->attributes()->pageheader;
		}
		if ($xml->attributes()->pagefooter) {
			$this->pageFooter = $xml->attributes()->pagefooter;
		}
		if ((($this->summaryWidth/count($this->columns))*100/$this->summaryWidth) < $this->minColumnWidth) {
			$this->orientation = 'landscape';
		}
		if ($xml->attributes()->orientation) {
			$this->orientation = (string) $xml->attributes()->orientation;
		}
		$this->setProfile();
	}
	
	
	private function headerParse($header) {
		$columns = $header->column;
		
		$summaryWidth = 0;
		foreach ($columns as $column) {
			$columnArr = Array();
			$columnArr['text'] = trim((string) $column);
			$columnArr['width'] = trim((string) $column->attributes()->width);
			$columnArr['type'] = trim((string) $column->attributes()->type);
			$columnArr['align'] = trim((string) $column->attributes()->align);
			$summaryWidth += $columnArr['width'];
			$this->columns[] = $columnArr;
		}		
		$this->summaryWidth = $summaryWidth;
	}
	
	
	private function rowsParse($rows) {
		foreach ($rows as $row) {
			$rowArr = Array();
			$cells = $row->cell;
			foreach ($cells as $cell) {
				$rowArr[] = trim((string) $cell);
			}
			$this->rows[] = $rowArr;
		}
	}
	
	
	private function headerImgInit() {
		if (file_exists('./imgs/header.jpg')) {
			$this->headerFile = './imgs/header.jpg';
			$this->headerFileType = 'jpg';
		} else {
			if (file_exists('./imgs/header.png')) {
				$this->headerFile = './imgs/header.png';
				$this->headerFileType = 'png';
			} else {
				return false;
			}
		}
		
		$imageSize = getimagesize($this->headerFile);
		$this->headerImgWidth = $imageSize[0];
		$this->headerImgHeight = $imageSize[1];
	}
	
	
	private function footerImgInit() {
		if (file_exists('./imgs/footer.jpg')) {
			$this->footerFile = './imgs/footer.jpg';
			$this->footerFileType = 'jpg';
		} else {
			if (file_exists('./imgs/footer.png')) {
				$this->footerFile = './imgs/footer.png';
				$this->footerFileType = 'png';
			} else {
				return false;
			}
		}
		$imageSize = getimagesize($this->footerFile);
		$this->footerImgWidth = $imageSize[0];
		$this->footerImgHeight = $imageSize[1];
	}
	
	
	public function printGridPdf() {
		if (($this->header)||($this->pageHeader)) {
			$this->headerImgInit();
		}
		if (($this->footer)||($this->pageFooter)) {
			$this->footerImgInit();
		}
		$this->wrapper = new gridPdfWrapper($this->offsetTop + $this->headerImgHeight, $this->offsetRight, $this->offsetBottom + $this->footerImgHeight, $this->offsetLeft, $this->pageNumberHeight, $this->fontFamily, $this->orientation);
		
		$pageHeight = $this->wrapper->getPageHeight();
		$numRows = floor(($pageHeight - $this->headerHeight)/$this->rowHeight);
		
		$rows = Array();
		$pageNumber = 1;
		for ($startRow = 0; $startRow < count($this->rows); $startRow += $numRows) {
			$this->printGridPage($startRow, $pageNumber);
			$pageHeight = $this->wrapper->getPageHeight();
			$numRows = floor(($pageHeight - $this->headerHeight)/$this->rowHeight);
			$pageNumber++;
		}
		$this->wrapper->pdfOut();
	}
	
	private function printGridPage($startRow, $pageNumber) {
		if ($startRow != 0) {
			$this->wrapper->createPage();
		}
		
		if ((($this->header)&&($pageNumber == 1))||($this->pageHeader)) {
			$offsetTop = $this->offsetTop + $this->headerImgHeight;
		} else {
			$offsetTop = $this->offsetTop;
		}

		if ((($this->footer)&&($lastPage))||($this->pageFooter)) {
			$offsetBottom = $this->offsetBottom + $this->footerImgHeight;
		} else {
			$offsetBottom = $this->offsetBottom;
		}
		$offsetRight = $this->offsetRight;
		$offsetLeft = $this->offsetLeft;
		$this->wrapper->setPageSize($offsetTop, $offsetRight, $offsetBottom, $offsetLeft);

		$pageHeight = $this->wrapper->getPageHeight();
		$numRows = floor(($pageHeight - $this->headerHeight)/$this->rowHeight);
		$lastPage = ((count($this->rows) - $startRow) < $numRows);

		$this->wrapper->drawContainer($this->bgColor, $this->lineColor, $pageNumber);
		$this->wrapper->drawGrid($this->headerHeight, $this->scaleOneColor, $this->scaleTwoColor, $this->rowHeight, $this->rows, $this->profile, $startRow);
		$this->wrapper->drawHeader($this->columns, $this->summaryWidth, $this->headerTextColor, $this->headerFontSize);
		$this->wrapper->drawValues($this->gridTextColor, $this->gridFontSize, $startRow);

		if (!(($pageNumber == 1)&&($lastPage))) {
			$this->wrapper->drawPageNumber($this->pageTextColor, $this->pageFontSize);
		}

		if ((($this->header)&&($pageNumber == 1))||($this->pageHeader)) {
			$this->wrapper->drawImgHeader($this->headerFile, $this->headerImgHeight, $this->headerImgWidth,  $this->headerFileType);
		}
		if (($this->pageFooter)||(($lastPage)&&($this->footer))) {
			$this->wrapper->drawImgFooter($this->footerFile, $this->footerImgHeight, $this->footerImgWidth,  $this->footerFileType);
		}
	}
}


?>