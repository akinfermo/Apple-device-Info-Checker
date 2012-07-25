<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
		
        <title>Apple's device Info Checker</title>
		<style type="text/css">
				body{margin: 0;padding: 0;background-color: #f3f3f3;font-family: Arial, Helvetica, sans-serif;font-size: 14px;color: #333;}
				div#content{padding: 10px;text-align: center;}
				p{margin: 0 0 5px 0;}
				input{padding: 3px;border: 1px #ccc solid;border-radius: 3px;}
				input.button{padding: 5px 10px;cursor: pointer;background-color: #000;background-image: -webkit-gradient(linear, left bottom, left top, color-stop(0.07, rgb(0,0,0)), color-stop(1, rgb(85,85,85)));background-image: -moz-linear-gradient(center bottom, rgb(0,0,0) 7%, rgb(85,85,85) 100%);border-radius: 5px;color: #fff;margin: 5px 0 0 0;border-color: #444;}
				div.warning{border: 1px #555 solid;padding: 5px;font-weight: bold;border-radius: 3px;color: #fff;font-size: 12px;background-color: #C00;}
				div.success{text-align: center;}
				table.tbl tr td{padding: 5px;margin: 10px auto 0 auto;border: 1px #e3e3e3 solid;font-size: 12px;text-align: left;color: #555;}
		</style>
    </head>

    <body>
	
	
		<div id="content">
			<p>Type your iPhone IMEI</p>
			<form name="form1" action="" method="post" onsubmit="document.getElementById('btn').disabled=true;">
			<input type="text" name="imei" value="" size="22" autofocus="autofocus" />
			<input type="submit" name="btn" id="btn" value="Check" class="button" onclick="this.value='Please wait...';" />
			
			</form>
			
		</div>
	<?php 	
	
	
			if(isset($_POST['imei']) AND !empty($_POST['imei'])) //verify if the imei or serial number exists and It's not empty
			{
				
				$file = file_get_contents('https://selfsolve.apple.com/warrantyChecker.do?sn=' . $_POST['imei']); //fetch the URL's response body into a variable
						
				$replace_values = array('null(', ')');
				$file = str_replace($replace_values, '', $file);
					
				$file = json_decode($file, true); //decode the json object into an array
					
				if(array_key_exists('ERROR_CODE', $file)) //verify wether the server has sent an error or not
				{
				
					echo '<div id="wrong_number" > You entered a wrong Imei or Serial Number </div>';
					
				}
				
				
				else
				{
					?>
					
					<table>
					
						
						<tr>
							<td>Family</td>
							<td><?php echo $file['DEVICE_FAMILY']; ?></td>
						</tr>

						<tr>
							<td>Model</td>
							<td><?php echo $file['PART_DESCR']; ?></td>
						</tr>	
						
						<tr>
							<td><?php if($file['IS_IPHONE'] = 'Y') {echo 'iOS Version';} else{echo 'Version';} ?></td>
							<td><?php echo $file['PROD_VERSION']; ?></td>
						</tr>
						
						<tr>
							<td>Carrier</td>
							<td><?php if($file['CARRIER'] != '') {echo $file['CARRIER'];} else { echo'Not Available';} ?></td>
						</tr>
						
						<tr>
							<td>IMEI</td>
							<td><?php echo $file['AP_IMEI_NUM']; ?></td>
						</tr>
						
						<tr>
							<td>Country Code</td>
							<td><?php echo $file['COUNTRY_CODE']; ?></td>
						</tr>
						
						<tr>
							<td>Purchase Country</td>
							<td><?php echo $file['PURCH_COUNTRY']; ?></td>
						</tr>
						
						<tr>
							<td>Warranty Status</td>
							<td><?php echo $file['HW_COVERAGE_DESC'];?></td>
						</tr>
						
						<tr>
							<td>Warranty ends on</td>
							<td><?php echo $file['COV_END_DATE']; ?></td>
						</tr>
						
						<tr>
							<td>Activation Status</td>
							<td><?php if($file['ACTIVATION_STATUS'] = 'Y') { echo 'Activated';} else { echo 'Not Activated';} ?></td>
						</tr>
						
						<tr>
							<td>SIM Locked</td>
							<td><?php if($file['CARRIER'] = '') {echo 'NO';} else{ echo'YES';}; ?></td>
						</tr>
					
					
					
					</table>
					
				
			<?php	}
			
			
			

			}	
		
					
			?>
    
    </body>
</html>