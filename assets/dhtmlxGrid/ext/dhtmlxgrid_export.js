//v.3.0 build 110707

/*
Copyright DHTMLX LTD. http://www.dhtmlx.com
You allowed to use this component or parts of it under GPL terms
To use it on other terms or get Professional edition of the component please contact us at sales@dhtmlx.com
*/
dhtmlXGridObject.prototype.toPDF=function(n,g,b,m,d,h){function l(u){for(var i=[],e=1;e<a.hdr.rows.length;e++){i[e]=[];for(var f=0;f<a._cCount;f++){var c=a.hdr.rows[e].childNodes[f];i[e][f]||(i[e][f]=[0,0]);c&&(i[e][c._cellIndexS]=[c.colSpan,c.rowSpan])}}var o="<rows profile='"+u+"'";b&&(o+=" header='"+b+"'");m&&(o+=" footer='"+m+"'");o+="><head>"+a._serialiseExportConfig(i).replace(/^<head/,"<columns").replace(/head>$/,"columns>");for(e=2;e<a.hdr.rows.length;e++){for(var g=0,d=a.hdr.rows[e],h="",
f=0;f<a._cCount;f++)if(a._srClmn&&!a._srClmn[f]||a._hrrar[f])g++;else{var j=i[e][f],l=j[0]&&j[0]>1?' colspan="'+j[0]+'" ':"";j[1]&&j[1]>1&&(l+=' rowspan="'+j[1]+'" ',g=-1);for(var k="",p=0;p<d.cells.length;p++)if(d.cells[p]._cellIndexS==f){k=d.cells[p].getElementsByTagName("SELECT").length?"":_isIE?d.cells[p].innerText:d.cells[p].textContent;k=k.replace(/[ \n\r\t\xA0]+/," ");break}(!k||k==" ")&&g++;h+="<column"+l+"><![CDATA["+k+"]]\></column>"}g!=a._cCount&&(o+="\n<columns>"+h+"</columns>")}o+="</head>\n";
o+=v();return o}function k(){var b=[];if(d)for(var i=0;i<d.length;i++)b.push(t(a.getRowIndex(d[i])));else for(i=0;i<a.getRowsNum();i++)b.push(t(i));return b.join("\n")}function v(){var b=["<foot>"];if(!a.ftr)return"";for(var i=1;i<a.ftr.rows.length;i++){b.push("<columns>");for(var e=a.ftr.rows[i],f=0;f<a._cCount;f++)if((!a._srClmn||a._srClmn[f])&&!a._hrrar[f]){for(var c=0;c<e.cells.length;c++){var d="",g="";if(e.cells[c]._cellIndexS==f){d=_isIE?e.cells[c].innerText:e.cells[c].textContent;d=d.replace(/[ \n\r\t\xA0]+/,
" ");e.cells[c].colSpan&&e.cells[c].colSpan!=1&&(g=" colspan='"+e.cells[c].colSpan+"' ");break}}b.push("<column"+g+"><![CDATA["+d+"]]\></column>")}b.push("</columns>")}b.push("</foot>");return b.join("\n")}function j(a,b){return(window.getComputedStyle?window.getComputedStyle(a,null)[b]:a.currentStyle?a.currentStyle[b]:null)||""}function t(b){if(!a.rowsBuffer[b])return"";var d=a.render_row(b);if(d.style.display=="none")return"";for(var e="<row>",f=0;f<a._cCount;f++)if((!a._srClmn||a._srClmn[f])&&
!a._hrrar[f]){var c=a.cells(d.idd,f);if(w){var g=j(c.cell,"color"),h=j(c.cell,"backgroundColor"),k=j(c.cell,"font-weight")||j(c.cell,"fontWeight"),l=j(c.cell,"font-style")||j(c.cell,"fontStyle"),m=j(c.cell,"text-align")||j(c.cell,"textAlign"),n=j(c.cell,"font-family")||j(c.cell,"fontFamily");if(h=="transparent"||h=="rgba(0, 0, 0, 0)")h="rgb(255,255,255)";e+="<cell bgColor='"+h+"' textColor='"+g+"' bold='"+k+"' italic='"+l+"' align='"+m+"' font='"+n+"'>"}else e+="<cell>";e+="<![CDATA["+(c.getContent?
c.getContent():c.getTitle())+"]]\></cell>"}return e+"</row>"}function x(){var a="</rows>";return a}var g=g||"color",w=g=="full_color",a=this;a._asCDATA=!0;this.target=typeof h==="undefined"?' target="_blank"':h;eXcell_ch.prototype.getContent=function(){return this.getValue()};eXcell_ra.prototype.getContent=function(){return this.getValue()};if(a._fake)for(var y=[].concat(a._hrrar),r=0;r<a._fake._cCount;r++)a._hrrar[r]=null;var q=document.createElement("div");q.style.display="none";document.body.appendChild(q);
var s="form_"+a.uid();q.innerHTML='<form id="'+s+'" method="post" action="'+n+'" accept-charset="utf-8"  enctype="application/x-www-form-urlencoded"'+this.target+'><input type="hidden" name="grid_xml" id="grid_xml"/> </form>';document.getElementById(s).firstChild.value=encodeURIComponent(l(g).replace("\u2013","-")+k()+x());document.getElementById(s).submit();q.parentNode.removeChild(q);if(a._fake)a._hrrar=y;a=null};
dhtmlXGridObject.prototype._serialiseExportConfig=function(n){for(var g="<head>",b=0;b<this.hdr.rows[0].cells.length;b++)if((!this._srClmn||this._srClmn[b])&&!this._hrrar[b]){var m=this.fldSort[b];m=="cus"&&(m=this._customSorts[b].toString(),m=m.replace(/function[\ ]*/,"").replace(/\([^\f]*/,""));var d=n[1][b],h=(d[1]&&d[1]>1?' rowspan="'+d[1]+'" ':"")+(d[0]&&d[0]>1?' colspan="'+d[0]+'" ':"");g+="<column "+h+" width='"+this.getColWidth(b)+"' align='"+this.cellAlign[b]+"' type='"+this.cellType[b]+
"' hidden='"+(this.isColumnHidden&&this.isColumnHidden(b)?"true":"false")+"' sort='"+(m||"na")+"' color='"+(this.columnColor[b]||"")+"'"+(this.columnIds[b]?" id='"+this.columnIds[b]+"'":"")+">";g+=this._asCDATA?"<![CDATA["+this.getHeaderCol(b)+"]]\>":this.getHeaderCol(b);var l=this.getCombo(b);if(l)for(var k=0;k<l.keys.length;k++)g+="<option value='"+l.keys[k]+"'>"+l.values[k]+"</option>";g+="</column>"}return g+="</head>"};
if(window.eXcell_sub_row_grid)window.eXcell_sub_row_grid.prototype.getContent=function(){return""};dhtmlXGridObject.prototype.toExcel=function(n,g,b,m,d){if(!document.getElementById("ifr")){var h=document.createElement("iframe");h.style.display="none";h.setAttribute("name","dhx_export_iframe");h.setAttribute("src","");h.setAttribute("id","dhx_export_iframe");document.body.appendChild(h)}var l=' target="dhx_export_iframe"';this.toPDF(n,g,b,m,d,l)};

//v.3.0 build 110707

/*
Copyright DHTMLX LTD. http://www.dhtmlx.com
You allowed to use this component or parts of it under GPL terms
To use it on other terms or get Professional edition of the component please contact us at sales@dhtmlx.com
*/