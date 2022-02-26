<!--<div class="box">  -->
<h4 class="white">
	<table>
		<tr>
			<td style="border: none; padding-right:5px">
				From Date :
			</td>
			<td style="border: none;">
				<label>
					<input name="fdate" id="fdate" class="txtbox-short-date" value="<?php echo  date('d-m-Y', strtotime($fdate)); ?>" autocomplete="off" readonly="readonly" onclick="javascript:NewCssCal ('fdate','ddMMyyyy', 'dropdown')">
				</label>
			</td>
			<td style="border: none; padding-left:20px">


				<select name="static_shours">
					<?php for ($i = 0; $i <= 23; $i++) { ?>
						<?php if ($_REQUEST['static_shours'] == $i) { ?>
							<option id="sh<?php echo $i; ?>" value="<?php echo $static_hours_array[$i]; ?>" selected><?php echo $static_hours_array[$i]; ?></option>
						<?php continue;
						} ?>
						<option id="sh<?php echo $i; ?>" value="<?php echo $static_hours_array[$i]; ?>"><?php echo $static_hours_array[$i]; ?></option>
					<?php } ?>
				</select>
				&nbsp;
				<select name="static_sminutes">
					<?php for ($i = 0; $i <= 59; $i++) { ?>
						<?php if ($_REQUEST['static_sminutes'] == $i) { ?>
							<option id="sm<?php echo $i; ?>" value="<?php echo $static_minutes_array[$i]; ?>" selected><?php echo $static_minutes_array[$i]; ?></option>
						<?php continue;
						} ?>
						<option id="sm<?php echo $i; ?>" value="<?php echo $static_minutes_array[$i]; ?>"><?php echo $static_minutes_array[$i]; ?></option>
					<?php } ?>
				</select>
				<!--</label>-->
			</td>
			<td style="border: none; padding-left:20px">
				<label>

				</label>
			</td>
		</tr>
		<tr>
			<td style="border: none;padding-top:10px">
				To Date :
			</td>
			<td style="border: none;">
				<label>
					<input name="tdate" id="tdate" class="txtbox-short-date" value="<?php echo  date('d-m-Y', strtotime($tdate)); ?>" autocomplete="off" readonly="readonly" onclick="javascript:NewCssCal ('tdate','ddMMyyyy', 'dropdown')">
				</label>
			</td>
			<td style="border: none;padding-left:20px">

				<select name="static_ehours">
					<?php for ($i = 1; $i <= 23; $i++) { ?>
						<?php if ($_REQUEST['static_ehours'] == $i) { ?>
							<option id="eh<?php echo $i; ?>" value="<?php echo $static_hours_array[$i]; ?>" selected><?php echo $static_hours_array[$i]; ?></option>
						<?php
						}
						if (!isset($_REQUEST['static_ehours'])) { ?>
							<option id="em<?php echo $i; ?>" value="<?php echo $static_hours_array[$i]; ?>" <?php echo ($static_hours_array[$i] == "23") ? "selected" : "" ?>><?php echo $static_hours_array[$i]; ?></option>
						<?php continue;
						} else { ?>
							<option id="eh<?php echo $i; ?>" value="<?php echo $static_hours_array[$i]; ?>"><?php echo $static_hours_array[$i]; ?></option>
					<?php
						}
					} ?>
				</select>
				&nbsp;
				<select name="static_eminutes">
					<?php for ($i = 1; $i <= 59; $i++) { ?>
						<?php if ($_REQUEST['static_eminutes'] == $i) { ?>
							<option id="em<?php echo $i; ?>" value="<?php echo $static_minutes_array[$i]; ?>" selected><?php echo $static_minutes_array[$i]; ?></option>
						<?php
						}
						if (!isset($_REQUEST['static_eminutes'])) { ?>
							<option id="em<?php echo $i; ?>" value="<?php echo $static_minutes_array[$i]; ?>" <?php echo ($static_minutes_array[$i] == "59") ? "selected" : "" ?>><?php echo $static_minutes_array[$i]; ?></option>
						<?php continue;
						} else {
						?>
							<option id="em<?php echo $i; ?>" value="<?php echo $static_minutes_array[$i]; ?>"><?php echo $static_minutes_array[$i]; ?></option>
					<?php
						}
					} ?>
				</select>
				<!--</label>-->
			</td>
			<td style="border: none;">
				<a class="button" href="javascript:document.xForm.submit();">
					<span>Search</span>
				</a>
				<input type="hidden" value="Search >>" id="search_date" name="search_date" />
			</td>
		</tr>
	</table>

</h4>
<!--</div>-->