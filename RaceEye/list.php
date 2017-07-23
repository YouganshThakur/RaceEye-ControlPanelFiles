<!DOCTYPE html>
<html>
    <head>
        <title></title>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <link rel="stylesheet" type="text/css" href="style.css"/>
        <link rel="stylesheet" type="text/css" href="bootstrap.css"/>
        
    </head>
    <body id="background">
        
        <h1 id="heading"><center>Camera Configuration</center></h1>
        
            
            <div> <br>
            <h3 style="color:#fff;margin-left: 270px;"><center>Media Server : <?php
$myfile = fopen("media_server_address.txt", "r") or print("Unable to open file!");
$mediaServerIp=fread($myfile,filesize("media_server_address.txt"));
echo $mediaServerIp;
fclose($myfile);
?></center></h3>
			<table id="add" style="width: 230px; height: 70px;"><tr>
           <td><form action="addmonitor.html"><input class="btn btn-danger" type="submit" name="add" value="Add Camera"></form></td>
            <td><Button class="btn btn-primary" value="Change" onClick="document.getElementById('ip_change_div').style.display='block';" >Change Media Server</Button></td>
            </tr>
            </table>
            <!-- media server ip cahange-->
            <div id="ip_change_div" style="display: none;"><input type="text" name="media_server_address" value="http://" id="media_server_address"></input>
            <button value="Save" onclick="saveIp(document.getElementById('media_server_address').value)">Save</button>
            <script type="text/javascript">
            	function saveIp(ip)
            	{
            		var oreq=new XMLHttpRequest();
   					oreq.onload=function()
   					{
   					 	location.replace("list.php");
    				}
   				 	oreq.open("get","functions.php?name=saveIp&ip="+ip,true);
   				 	oreq.send();
            	}
            </script>
			</div>

            <h2><center style="margin-left: 200px;color:#fff;">Connected live streams</center></h2>
            <table style="width: 100%; margin-left: 200px; cell-spacing: 0;" id="tablelist">
              <tr href="#" id="tablelistheader">
			  <th>Camera Name</th>
			  <th>IP Address</th>
			  <th>Port</th>
			  <th>Path</th>
			  <th>Enabled</th>
			  <th></th>
			  <th></th>
			  <th></th>
			  </tr>
			  <?php 
				
				$jsoncontent=file_get_contents("$mediaServerIp/api/monitors.json");
				$response = json_decode($jsoncontent,true);
				//print_r($response['monitors'][0]);
				//print_r($response['monitors'][0]['Monitor']['Name']);
				$len = sizeof($response['monitors'])-1;
				for( $len ; $len >= 0 ; $len-- ) {
					?><tr href="#" id="tablelistdetail">
					<td><a href="#"><?php print_r($response['monitors'][$len]['Monitor']['Name']);?></a></td>
					<td><?php print_r($response['monitors'][$len]['Monitor']['Host']);?></td>
					<td><?php print_r($response['monitors'][$len]['Monitor']['Port']);?></td>
					<td><?php print_r($response['monitors'][$len]['Monitor']['Path']);?></td>
					<td><input type='checkbox' onchange="changeState(<?php echo $response['monitors'][$len]['Monitor']['Id'];?>,<?php echo $response['monitors'][$len]['Monitor']['Enabled']?>)" name='isEnabled' <?php echo $response['monitors'][$len]['Monitor']['Enabled']==1?'checked':'';?>>

					</td>
					<td>
						<button  class="btn btn-primary" data-target="#View" data-toggle="modal" onclick="openStream('<?php echo $response['monitors'][$len]['Monitor']['Id'];?>')">View Stream</button></td>
					<td>
						<button id="<?php $len;?>" class="btn btn-primary" data-target="#View" data-toggle="modal" onclick="document.getElementById('View').style.display='block';document.getElementById('camera_name').innerHTML='<?php echo $response['monitors'][$len]['Monitor']['Name']?>';
							document.getElementById('camera_host').innerHTML='<?php echo $response['monitors'][$len]['Monitor']['Host']?>';
							document.getElementById('camera_port').innerHTML='<?php echo $response['monitors'][$len]['Monitor']['Port']?>';
							document.getElementById('camera_path').innerHTML='<?php echo $response['monitors'][$len]['Monitor']['Path']?>';
							document.getElementById('camera_width').innerHTML='<?php echo $response['monitors'][$len]['Monitor']['Width']?>';
							document.getElementById('camera_height').innerHTML='<?php echo $response['monitors'][$len]['Monitor']['Height']?>';
							document.getElementById('camera_maxfps').innerHTML='<?php echo $response['monitors'][$len]['Monitor']['MaxFPS']?>';
						">More Details</button></td>
					<td><button id="<?php $len;?>" class="btn btn-primary" onclick="delete_camera(<?php echo $response['monitors'][$len]['Monitor']['Id'];?>);">Delete</button></td>
					</tr>

				<?php  } ?>
			</table>
            
            <div id="View" class="modal">
            	<div class="modal-dialog">
            		<div class="modal-content">
            			<div class="modal-header">
            				<label>View Camera Details</label>
            			</div>
            			<div class="modal-body">
            				<form>
	            				<div class="form-group">
	            					<b><label>Camera Name: </label></b>
	            					<label id="camera_name"/>
	            				</div>
	            				<div class="form-group">	
	            					<b><label>Host: </label></b>
	            					<label id="camera_host"/>
	            				</div>
	            				<div class="form-group">	
	            					<b><label>Port: </label></b>
	            					<label id="camera_port"/>
	            				</div>
	            				<div class="form-group">	
	            					<b><label>Path: </label></b>
	            					<label id="camera_path"/>
	            				</div>
	            				<div class="form-group">
	            					<b><label>Width: </label></b>
	            					<label id="camera_width"/>
	            				</div>
	            				<div class="form-group">
	            					<b><label>Height: </label></b>
	            					<label id="camera_height"/>
	            				</div>
	            				<div class="form-group">
	            					<b><label>MaxFPS: </label></b>
	            					<label id="camera_maxfps"/>
	            				</div>
            				</form>
            			</div>
            			<div class="modal-footer">	
	            					<button type="button" name="delete" value="Cancel" onclick="document.getElementById('View').style.display='none';">  OK  </button>
	            		</div>
            		</div>
            	</div>
            </div>
          </div>
		<script type="text/javascript">
			
function view_details(a)
        	{

        	document.getElementById('camera_name').value="" ;
        	}


function delete_camera(id)
{
	//document.getElementById("loader").style.display = "block";
	//	document.getElementById("blackDiv").style.display="block";
	var oreq=new XMLHttpRequest();
		oreq.onload=function(){
		location.replace("list.php");
		}
		oreq.open("get","functions.php?name=deleteCamera&id="+id,true);
		oreq.send();
}
function changeState(id,enabled)
{
	var oreq=new XMLHttpRequest();
		oreq.onload=function(){
		location.replace("list.php");
		}
		oreq.open("get","functions.php?name=changeState&id="+id+"&enabled="+Math.abs(enabled-1),true);
		oreq.send();
}
function openStream(id)
{
	newwindow=window.open('<?php echo "$mediaServerIp"?>'+"/index.php?view=watch&mid="+id,"Camera Stream",'height=500,width=500');
       if (window.focus) {newwindow.focus()}
       
}
		</script>
		<script src="jquery-3.2.1.min.js"></script>
        <script src="bootstrap.css"></script>
    </body>
</html>