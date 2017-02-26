@extends('base')

@section('head')
<title>Insert</title>

<link href="res/dropzone/css/dropzone.css" rel="stylesheet">
@stop

@section('style')

.tmfiles{
	position: relative;
	font-size: 0.9em;	
	width:150px;
	height:150px;
	background: none repeat scroll 0 0 rgba(0, 0, 0, 0.03);
	border-radius: 3px;
    border: 1px solid rgba(0, 0, 0, 0.03);
    border-radius: 4px;
    padding: 10px 5px 5px 0px;
	margin: 15px 10px;
	cursor: default;
	display: inline-block;
}
.tmfilesok{	
	background: none repeat scroll 0 0 rgba(0, 255, 0, 0.20);
}
.tmfiles img{
	height: 85%;
}
.tmfiles .glyphicon{
	position: absolute;
	right: 8px;
	top: 8px;
	color: activeborder;
    font-size: 1.5em;
}
.tmfiles .glyphicon-ok{
	color: #008080;	
}
.tmfilespart{
	background: -moz-linear-gradient(bottom, #CCFFCC 0%, #CCFFCC 51%, #f7f7f7 51%, #f7f7f7 100%); /* FF3.6+ */
	background: -webkit-gradient(linear, bottom center, right top, color-stop(0%,#CCFFCC), color-stop(51%,#CCFFCC), color-stop(51%,#f7f7f7), color-stop(100%,#f7f7f7)); /* Chrome,Safari4+ */
	background: -webkit-linear-gradient(bottom, #CCFFCC 0%,#CCFFCC 51%,#f7f7f7 51%,#f7f7f7 100%); /* Chrome10+,Safari5.1+ */
	background: -o-linear-gradient(bottom, #CCFFCC 0%,#CCFFCC 51%,#f7f7f7 51%,#f7f7f7 100%); /* Opera11.10+ */
	background: -ms-linear-gradient(bottom, #ff3232 0%,#CCFFCC 51%,#f7f7f7 51%,#f7f7f7 100%); /* IE10+ */
	filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#ff3232', endColorstr='#f7f7f7',GradientType=1 ); /* IE6-9 */
	background: linear-gradient(bottom, #ff3232 0%,#CCFFCC 51%,#f7f7f7 51%,#f7f7f7 100%); /* W3C */
	background-clip: border-box;
	background-repeat: repeat-x;
}
code{
	white-space: initial;
}
@stop

@section('content')
<script src="res/dropzone/dropzone.js"></script>
<script>
	Dropzone.options.myAwesomeDropzone = {
		paramName: "file", // The name that will be used to transfer the file
		maxFilesize: 100, // MB
		init: function() {
			this.on("success", function(file, response) {				
				if(response.m){
					console.log(response);
					$('#showdata').html(response.m);
				}
			});
		}	
	};
	
</script>
<div class="row">
	<div class="container">
		<div class="col-sm-12">
			<div class="page-header" >	
				<h1 class="h">Insert XML files from TM-Master v2</h1>
			</div>
		</div>
	</div>
</div>
<div class="row">
	<div class="container">
		<p><b>Paste the following SQL querys into the "SQL" part of TM-Master <b>one at the time</b>. Call the file whatever you want, and upload it using the droparea below</b></p>
		<p><b>1. </b><CODE>
		<?php /* SELECT *, GETDATE() as date FROM tmdue
INNER JOIN tmcomponentjob
ON tmcomponentjob.TmComponentJobID = tmdue.ComponentJobID
INNER JOIN tmcomponent
ON tmcomponentjob.ComponentID = tmcomponent.TmComponentID
INNER JOIN tmcomponentjobinterval
ON tmdue.TmComponentJobIntervalID = tmcomponentjobinterval.TmComponentJobIntervalID
				WHERE

      (tmdue.RowDeleted           !=  'true'   OR tmdue.RowDeleted IS NULL)
AND   (tmcomponent.RowDeleted     !=  'true'   OR tmcomponent.RowDeleted IS NULL)
AND   (tmcomponentjob.RowDeleted  !=  'true'   OR tmcomponentjob.RowDeleted  IS NULL)
AND   (tmdue.Disabled             !=  'true'   OR tmdue.Disabled  IS NULL)

				 AND

((tmdue.Postponed            !=  'true' OR tmdue.Postponed IS NULL)
				 OR
(  	tmdue.Postponed               =  'true'									
AND tmdue.TmJobListID             IS NULL
))

				 AND   
				
((	  tmdue.DueAtEnd              <  ' <?php echo Date('Y-m-d');?>T00:00:00'
AND   tmdue.DueAtEnd             IS NOT NULL
AND TmComponentJobInterval.IntervalType = 'I')
				OR
(     tmcomponent.RunningHours   IS NOT NULL
AND   tmdue.DueCounter           IS NOT NULL
AND   tmcomponent.RunningHours    > tmdue.DueCounter
AND TmComponentJobInterval.IntervalType = 'C'))

ORDER BY tmcomponent.Code ASC
*/ ?>
SELECT *,GETDATE() as date FROM tmdue INNER JOIN tmcomponentjob
ON tmcomponentjob.TmComponentJobID = tmdue.ComponentJobID</br>
INNER JOIN tmcomponent ON tmcomponentjob.ComponentID = tmcomponent.TmComponentID
INNER JOIN tmcomponentjobinterval ON </br>
tmdue.TmComponentJobIntervalID = tmcomponentjobinterval.TmComponentJobIntervalID
WHERE(tmdue.RowDeleted != 'true' OR tmdue.RowDeleted IS NULL) AND</br>
(tmcomponent.RowDeleted != 'true' OR tmcomponent.RowDeleted IS NULL)
AND(tmcomponentjob.RowDeleted != 'true' OR tmcomponentjob.RowDeleted IS NULL)</br>
AND(tmdue.Disabled != 'true' OR tmdue.Disabled IS NULL) AND ((tmdue.Postponed
!= 'true' OR tmdue.Postponed IS NULL) OR (tmdue.Postponed = 'true' AND</br>
tmdue.TmJobListID IS NULL)) AND((tmdue.DueAtEnd < '<?php echo Date('Y-m-d');?>T00:00:00'
AND tmdue.DueAtEnd IS NOT NULL AND TmComponentJobInterval.IntervalType = 'I') OR</br>
(tmcomponent.RunningHours IS NOT NULL AND tmdue.DueCounter IS NOT NULL AND
tmcomponent.RunningHours > tmdue.DueCounter AND</br>
TmComponentJobInterval.IntervalType = 'C'))ORDER BY tmcomponent.Code ASC
</CODE></p>
		</br>
<b>2. </b><CODE>SELECT *, GETDATE() AS date FROM tmcomponentjob
</CODE>
</br></br>
	</div>
</div>
<div class="row">
	<div class="container">
		<form action="{{ url('fileupload')}}" class="dropzone" id="myAwesomeDropzone"></form>
	</div>
</div>

<!--
<script>
$(document).ready(function(){
	var xmlhttp;
	if (window.XMLHttpRequest)
	  {// code for IE7+, Firefox, Chrome, Opera, Safari
	  xmlhttp=new XMLHttpRequest();
	  }
	else
	  {// code for IE6, IE5
	  xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
	  }
	  console.log(xmlhttp);
	xmlhttp.onreadystatechange=function()
	{
		console.log(xmlhttp);
		if (xmlhttp.status==200)
		{
		console.log(xmlhttp);
			document.getElementById("showdata").innerHTML=xmlhttp.responseText;
		}
	}
  
});
</script>
-->
@stop