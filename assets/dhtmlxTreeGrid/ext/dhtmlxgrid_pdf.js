dhtmlXGridObject.prototype.toPDF=function(url,mode,header,footer,rows){
	mode = mode || "color";	
	var grid = this;
	eXcell_ch.prototype.getContent = function(){
		return this.getValue();
	}
	eXcell_ra.prototype.getContent = function(){
		return this.getValue();
	}
	function xml_top(profile) {
	    var xml = "<data profile='"+profile+"'";
	       if (header)
	          xml+=" header='"+header+"'";
	       if (footer)
	          xml+=" footer='"+footer+"'";
	    xml+=">";
	    xml+=grid._serialiseConfig();
	    return xml;
	}
	
	function xml_body() {
		var xml =[];
	    if (rows)
	    	for (var i=0; i<rows.length; i++)
	    		xml.push(xml_row(grid.getRowIndex(rows[i])));
	    else
	    	for (var i=0; i<grid.getRowsNum(); i++)
	    		xml.push(xml_row(i));
	    return xml.join("\n");
	}	    		
	function xml_row(ind){
		var r = grid.render_row(ind);
		if (r.style.display=="none") return "";
		var xml = "<row>";
		for (var i=0; i < grid._cCount; i++) {
			if ((!this._srClmn)||(this._srClmn[i])){
				var cell = grid.cells(r.idd, i);
				xml+="<cell><![CDATA["+(cell.getContent?cell.getContent():cell.getTitle())+"]]></cell>";
			}
		};
		return xml+"</row>";
	}
	function xml_end(){
	    var xml = "</data>";
	    return xml;
	}
	
	var win = window.open("", "_blank");
	win.document.open();
	win.document.write("<html><body>");
	win.document.write('<form id="mycollformname" method="post" action="'+url+'"><input type="hidden" name="mycoolxmlbody" id="mycoolxmlbody"/> </form>');
	// as long dash in post converts to some special symbols we need to convert it to simple dash by replacing using unicode \u2013
	win.document.getElementById("mycoolxmlbody").value = xml_top(mode).replace("\u2013", "-") + xml_body() + xml_end();
	win.document.write("</body></html>");
	win.document.getElementById("mycollformname").submit();
	win.document.close();
	grid = null;
}