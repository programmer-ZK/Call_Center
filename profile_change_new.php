<?php include_once("includes/config.php"); ?>
<?php
	$page_name = "profile_change_new.php";
	$page_title = "Add/Update Profile Change Settings";
	$page_level = "2";
	$page_group_id = "1";
	$page_menu_title = "Add/Update Profile Change Settings";
?>
<?php include_once($site_root."includes/check.auth.php"); ?>
<?php 	
	include_once("classes/tools_admin.php");
	$tools_admin = new tools_admin();
	
	include_once("classes/admin.php");
	$admin = new admin();
?>
<?php include($site_root."includes/header.php"); ?>
<script type="text/javascript">
function admin_validate(){

	var admin_id 		= this.document.getElementById('admin_id');
	var Name 			= this.document.getElementById('Name');
	var Gender 			= this.document.getElementById('Gender');
	var NICNo 			= this.document.getElementById('NICNo');
	var CNICExpiry 		= this.document.getElementById('CNICExpiry');
	var FHName			= this.document.getElementById('FHName');
	var MaritalName 	= this.document.getElementById('MaritalName');
	var DateOfBirth 	= this.document.getElementById('DateOfBirth');
	var OccupationName 	= this.document.getElementById('OccupationName');
	var AccountNumber 	= this.document.getElementById('AccountNumber');
	var TitleCode 		= this.document.getElementById('TitleCode');
	var Email 			= this.document.getElementById('Email');
	var PostalCode 		= this.document.getElementById('PostalCode');
	var CityName		= this.document.getElementById('CityName');
	var CountryName 	= this.document.getElementById('CountryName');
	var Remarks 		= this.document.getElementById('Remarks');
	var Address 		= this.document.getElementById('Address');
	var RegistrationDate= this.document.getElementById('RegistrationDate');
	var MailingAddress 	= this.document.getElementById('MailingAddress');
	var GuardianName 	= this.document.getElementById('GuardianName');
	var NTN 			= this.document.getElementById('NTN');
	var StatementName	= this.document.getElementById('StatementName');
	var StatementDays 	= this.document.getElementById('StatementDays');
	var TaxCode 		= this.document.getElementById('TaxCode');
	var TaxRate 		= this.document.getElementById('TaxRate');
	var ZakatReason 	= this.document.getElementById('ZakatReason');
	var SigningDetail 	= this.document.getElementById('SigningDetail');
	var CategoryType 	= this.document.getElementById('CategoryType');
	var RegionName 		= this.document.getElementById('RegionName');
	var EducationName	= this.document.getElementById('EducationName');
	var NationalityName = this.document.getElementById('NationalityName');
	var SubCat 			= this.document.getElementById('SubCat');
	var CurrencyName 	= this.document.getElementById('CurrencyName');
	var Fax 			= this.document.getElementById('Fax');
	var PassportNo 		= this.document.getElementById('PassportNo');
	var IssueDate 		= this.document.getElementById('IssueDate');
	var IssuePlace 		= this.document.getElementById('IssuePlace');
	var Validity		= this.document.getElementById('Validity');
	var GCNICExpiry 	= this.document.getElementById('GCNICExpiry');
	var SubAgentName 	= this.document.getElementById('SubAgentName');
	var SubAgentEmail 	= this.document.getElementById('SubAgentEmail');
	var CompanyExecutive= this.document.getElementById('CompanyExecutive');
	var AccountType 	= this.document.getElementById('AccountType');
	var flag 			= true;
	var err_msg = '';
	
	if(Name.value == ''){
		err_msg+= 'Missing Name\n';
		this.document.getElementById('Name_error').style.display="";
	}
	if(Gender.value == ''){
		err_msg+= 'Missing Gender\n';
		this.document.getElementById('Gender_error').style.display="";
	}
		
	if(NICNo.value == ''){
		err_msg+= 'Missing NICNo\n';C
		this.document.getElementById('NINo_error').style.display="";
	}
	
	if(CNICExpiry.value == ''){
		err_msg+= 'Missing CNICExpiry\n';
		this.document.getElementById('CNICExpiry_error').style.display="";
	}
	
	if(FHName.value == ''){
		err_msg+= 'Missing Father Name\n';
		this.document.getElementById('FHName_error').style.display="";
	}

	if(MaritalName.value == ''){
		err_msg+= 'Missing Marital Status\n';
		this.document.getElementById('MaritalName_error').style.display="";
	}
		
	if(DateOfBirth.value == ''){
		err_msg+= 'Missing Date of Birth\n';C
		this.document.getElementById('DateOfBirth_error').style.display="";
	}
	
	if(OccupationName.value == ''){
		err_msg+= 'Missing Occupation Name\n';
		this.document.getElementById('OccupationName_error').style.display="";
	}
	
	if(AccountNumber.value == ''){
		err_msg+= 'Missing Account Number\n';
		this.document.getElementById('AccountNumber_error').style.display="";
	}

	if(TitleCode.value == ''){
		err_msg+= 'Missing Title Code\n';
		this.document.getElementById('TitleCode_error').style.display="";
	}
		
	if(Email.value == ''){
		err_msg+= 'Missing Email\n';C
		this.document.getElementById('Email_error').style.display="";
	}
	
	if(PostalCode.value == ''){
		err_msg+= 'Missing Postal Code\n';
		this.document.getElementById('PostalCode_error').style.display="";
	}
	
	if(CityName.value == ''){
		err_msg+= 'Missing City Name\n';
		this.document.getElementById('CityName_error').style.display="";
	}

	if(CountryName.value == ''){
		err_msg+= 'Missing Country Name\n';
		this.document.getElementById('CountryName_error').style.display="";
	}

	if(Remarks.value == ''){
		err_msg+= 'Missing Remarks\n';
		this.document.getElementById('Remarks_error').style.display="";
	}
		
	if(Address.value == ''){
		err_msg+= 'Missing Address\n';C
		this.document.getElementById('Address_error').style.display="";
	}
	
	if(RegistrationDate.value == ''){
		err_msg+= 'Missing Registration Date\n';
		this.document.getElementById('RegistrationDate_error').style.display="";
	}
	
	if(MailingAddress.value == ''){
		err_msg+= 'Missing Mailing Address\n';
		this.document.getElementById('MailingAddress_error').style.display="";
	}

	if(GuardianName.value == ''){
		err_msg+= 'Missing Guardian Name\n';
		this.document.getElementById('GuardianName_error').style.display="";
	}

	if(NTN.value == ''){
		err_msg+= 'Missing NTN\n';
		this.document.getElementById('NTN_error').style.display="";
	}

	if(StatementName.value == ''){
		err_msg+= 'Missing Statement Name\n';
		this.document.getElementById('StatementName_error').style.display="";
	}
		
	if(StatementDays.value == ''){
		err_msg+= 'Missing Statement Days\n';C
		this.document.getElementById('StatementDays_error').style.display="";
	}
	
	if(TaxCode.value == ''){
		err_msg+= 'Missing Tax Code\n';
		this.document.getElementById('TaxCode_error').style.display="";
	}
	
	if(TaxRate.value == ''){
		err_msg+= 'Missing Tax Rate\n';
		this.document.getElementById('TaxRate_error').style.display="";
	}

	if(ZakatReason.value == ''){
		err_msg+= 'Missing Zakat Reason\n';
		this.document.getElementById('ZakatReason_error').style.display="";
	}

	if(SigningDetail.value == ''){
		err_msg+= 'Missing Signing Detail\n';
		this.document.getElementById('SigningDetail_error').style.display="";
	}

	if(CategoryType.value == ''){
		err_msg+= 'Missing Category Type\n';
		this.document.getElementById('CategoryType_error').style.display="";
	}
		
	if(RegionName.value == ''){
		err_msg+= 'Missing Region Name\n';C
		this.document.getElementById('RegionName_error').style.display="";
	}
	
	if(EducationName.value == ''){
		err_msg+= 'Missing Education Name\n';
		this.document.getElementById('EducationName_error').style.display="";
	}
	
	if(NationalityName.value == ''){
		err_msg+= 'Missing Nationality Name\n';
		this.document.getElementById('NationalityName_error').style.display="";
	}

	if(SubCat.value == ''){
		err_msg+= 'Missing Sub Category\n';
		this.document.getElementById('SubCat_error').style.display="";
	}

	if(CurrencyName.value == ''){
		err_msg+= 'Missing Currency Name\n';
		this.document.getElementById('CurrencyName_error').style.display="";
	}

	if(Fax.value == ''){
		err_msg+= 'Missing Fax\n';
		this.document.getElementById('Fax_error').style.display="";
	}
		
	if(PassportNo.value == ''){
		err_msg+= 'Missing Passport No\n';C
		this.document.getElementById('PassportNo_error').style.display="";
	}
	
	if(IssueDate.value == ''){
		err_msg+= 'Missing Issue Date\n';
		this.document.getElementById('IssueDate_error').style.display="";
	}
	
	if(IssuePlace.value == ''){
		err_msg+= 'Missing Issue Place\n';
		this.document.getElementById('IssuePlace_error').style.display="";
	}

	if(Validity.value == ''){
		err_msg+= 'Missing Validity\n';
		this.document.getElementById('Validity_error').style.display="";
	}
		
	if(GCNICExpiry.value == ''){
		err_msg+= 'Missing Guardian CNIC Expiry\n';C
		this.document.getElementById('GCNICExpiry_error').style.display="";
	}
	
	if(SubAgentName.value == ''){
		err_msg+= 'Missing Sub Agent Name\n';
		this.document.getElementById('SubAgentName_error').style.display="";
	}
	
	if(SubAgentEmail.value == ''){
		err_msg+= 'Missing Sub Agent Email\n';
		this.document.getElementById('SubAgentEmail_error').style.display="";
	}

	if(CompanyExecutive.value == ''){
		err_msg+= 'Missing Company Executive\n';
		this.document.getElementById('CompanyExecutive_error').style.display="";
	}

	if(AccountType.value == ''){
		err_msg+= 'Missing Account Type\n';
		this.document.getElementById('AccountType_error').style.display="";
	}

	if(err_msg == '' && IsEmpty(err_msg)){
		return true;
	}
	else{
		//alert(err_msg);
		return false;
	}
}
</script>
<script type="text/javascript">
$.validator.setDefaults({
	submitHandler: function() { alert("submitted!");  /*$("#xForm").submit(); */ }
});

$().ready(function() {
	// validate the comment form when it is submitted
	$("#commentForm").validate();
	
	// validate signup form on keyup and submit
	$("#xForm").validate({
		rules: {
			full_name: "required",
			password: "required",
			re_password: "required",
            designation: "required",
            department: "required",
		},
		messages: {
			full_name: "Please enter user name",
			password: "Please enter password",
			re_password: "Please enter confirm password",
            designation: "Please enter designation",
            department: "Please enter department",
		}
	});
});
</script>
<?php
	$admin_id 					= $tools_admin->decryptId($_REQUEST['admin_id']);
	$Name 						= $_REQUEST['Name'];
	$Gender 					= $_REQUEST['Gender'];
	$NICNo 						= $_REQUEST['NICNo'];
	$CNICExpiry 				= $_REQUEST['CNICExpiry'];
	$FHName 	  				= $_REQUEST['FHName']; 
	$MaritalName 	  			= $_REQUEST['MaritalName']; 
	$DateOfBirth 				= $_REQUEST['DateOfBirth'];
	$OccupationName 			= $_REQUEST['OccupationName'];
	$AccountNumber 				= $_REQUEST['AccountNumber'];
	$TitleCode 					= $_REQUEST['TitleCode'];
	$Email 						= $_REQUEST['Email'];
	$PostalCode 	  			= $_REQUEST['PostalCode']; 
	$CityName 	  				= $_REQUEST['CityName']; 
	$CountryName 				= $_REQUEST['CountryName'];
	$Remarks 					= $_REQUEST['Remarks'];
	$Address 					= $_REQUEST['Address'];
	$RegistrationDate 			= $_REQUEST['RegistrationDate'];
	$MailingAddress 			= $_REQUEST['MailingAddress'];
	$GuardianName 	  			= $_REQUEST['GuardianName']; 
	$NTN 	  					= $_REQUEST['NTN']; 
	$StatementName 				= $_REQUEST['StatementName'];
	$StatementDays 				= $_REQUEST['StatementDays'];
	$TaxCode 					= $_REQUEST['TaxCode'];
	$TaxRate 					= $_REQUEST['TaxRate'];
	$ZakatReason 				= $_REQUEST['ZakatReason'];
	$SigningDetail 	  			= $_REQUEST['SigningDetail']; 
	$CategoryType 	  			= $_REQUEST['CategoryType']; 
	$RegionName 				= $_REQUEST['RegionName'];
	$EducationName 				= $_REQUEST['EducationName'];
	$NationalityName 			= $_REQUEST['NationalityName'];
	$SubCat 					= $_REQUEST['SubCat'];
	$CurrencyName 				= $_REQUEST['CurrencyName'];
	$Fax 	  					= $_REQUEST['Fax']; 
	$PassportNo 	  			= $_REQUEST['PassportNo']; 
	$IssueDate 					= $_REQUEST['IssueDate'];
	$IssuePlace 				= $_REQUEST['IssuePlace'];
	$Validity 					= $_REQUEST['Validity'];
	$GCNICExpiry 				= $_REQUEST['GCNICExpiry'];
	$SubAgentName 				= $_REQUEST['SubAgentName'];
	$SubAgentEmail 	  			= $_REQUEST['SubAgentEmail']; 
	$CompanyExecutive 	  		= $_REQUEST['CompanyExecutive']; 
	$AccountType 				= $_REQUEST['AccountType'];

	$Name_error 				= "display:none;";
	$Gender_error 				= "display:none;";
	$NICNo_error 				= "display:none;";
	$CNICExpiry_error 			= "display:none;";
	$FHName_error 				= "display:none;";
	$MaritalName_error 			= "display:none;";
	$DateOfBirth_error 			= "display:none;";
	$OccupationName_error 		= "display:none;";
	$AccountNumber_error 		= "display:none;";
	$TitleCode_error 			= "display:none;";
	$Email_error 				= "display:none;";
	$PostalCode_error 			= "display:none;";
	$CityName_error 			= "display:none;";
	$CountryName_error 			= "display:none;";
	$Remarks_error 				= "display:none;";
	$Address_error 				= "display:none;";
	$RegistrationDate_error 	= "display:none;";
	$MailingAddress_error 		= "display:none;";
	$GuardianName_error 		= "display:none;";
	$NTN_error 					= "display:none;";
	$StatementName_error 		= "display:none;";
	$StatementDays_error	 	= "display:none;";
	$TaxCode_error 				= "display:none;";
	$TaxRate_error 				= "display:none;";
	$ZakatReason_error 			= "display:none;";
	$SigningDetail_error 		= "display:none;";
	$CategoryType_error 		= "display:none;";
	$RegionName_error 			= "display:none;";
	$EducationName_error 		= "display:none;";
	$NationalityName_error 		= "display:none;";
	$SubCat_error 				= "display:none;";
	$CurrencyName_error 		= "display:none;";
	$Fax_error 					= "display:none;";
	$PassportNo_error		 	= "display:none;";
	$IssueDate_error			= "display:none;";
	$IssuePlace_error		 	= "display:none;";
	$Validity_error 			= "display:none;";
	$GCNICExpiry_error 			= "display:none;";
	$SubAgentName_error 		= "display:none;";
	$SubAgentEmail_error 		= "display:none;";
	$CompanyExecutive_error 	= "display:none;";
	$AccountType_error 			= "display:none;";


if(isset($_REQUEST['add']) || isset($_REQUEST['edit']))
{
//echo "yahya"; exit;
        $flag = true;
         if($_REQUEST['Name'] == ''){
                $Name_error = "display:inline;";//$tools->isEmpty('Caller ID');
                $flag = false;
         }
	if($_REQUEST['Gender'] == ''){
        	        $Gender_error = "display:inline;";//$tools->isEmpty('Caller ID');
	                $flag = false;
        	 }
	if($_REQUEST['NICNo'] == ''){
        	        $NICNo_error = "display:inline;";//$tools->isEmpty('Caller ID');
	                $flag = false;
        	 }
	if($_REQUEST['CNICExpiry'] == ''){
	                $CNICExpiry_error = "display:inline;";//$tools->isEmpty('Caller ID');
                	$flag = false;
        	 }
	if($_REQUEST['FHName'] == ''){
	                $FHName_error = "display:inline;";//$tools->isEmpty('Caller ID');
                	$flag = false;
        	 }
	if($_REQUEST['MaritalName'] == ''){
                	$MaritalName_error = "display:inline;";//$tools->isEmpty('Caller ID');
        	        $flag = false;
	         }
	if($_REQUEST['DateOfBirth'] == 'Please Select'){
                        $DateOfBirth_error = "display:inline;";//$tools->isEmpty('Caller ID');
                        $flag = false;
                 }

	if($_REQUEST['OccupationName'] == ''){
                $OccupationName_error = "display:inline;";//$tools->isEmpty('Caller ID');
                $flag = false;
         }
	if($_REQUEST['AccountNumber'] == ''){
        	        $AccountNumber_error = "display:inline;";//$tools->isEmpty('Caller ID');
	                $flag = false;
        	 }
	if($_REQUEST['TitleCode'] == ''){
        	        $TitleCode_error = "display:inline;";//$tools->isEmpty('Caller ID');
	                $flag = false;
        	 }
	if($_REQUEST['Email'] == ''){
	                $Email_error = "display:inline;";//$tools->isEmpty('Caller ID');
                	$flag = false;
        	 }
	if($_REQUEST['PostalCode'] == ''){
	                $PostalCode_error = "display:inline;";//$tools->isEmpty('Caller ID');
                	$flag = false;
        	 }
	if($_REQUEST['CityName'] == ''){
                	$CityName_error = "display:inline;";//$tools->isEmpty('Caller ID');
        	        $flag = false;
	         }
	if($_REQUEST['CountryName'] == 'Please Select'){
                    $CountryName_error = "display:inline;";//$tools->isEmpty('Caller ID');
                    $flag = false;
             }

	if($_REQUEST['Remarks'] == ''){
        	        $Remarks_error = "display:inline;";//$tools->isEmpty('Caller ID');
	                $flag = false;
        	 }
	if($_REQUEST['Address'] == ''){
	                $Address_error = "display:inline;";//$tools->isEmpty('Caller ID');
                	$flag = false;
        	 }
	if($_REQUEST['RegistrationDate'] == ''){
	                $RegistrationDate_error = "display:inline;";//$tools->isEmpty('Caller ID');
                	$flag = false;
        	 }
	if($_REQUEST['MailingAddress'] == ''){
                	$MailingAddress_error = "display:inline;";//$tools->isEmpty('Caller ID');
        	        $flag = false;
	         }
	if($_REQUEST['GuardianName'] == 'Please Select'){
                        $GuardianName_error = "display:inline;";//$tools->isEmpty('Caller ID');
                        $flag = false;
                 }
	if($_REQUEST['NTN'] == ''){
                $NTN_error = "display:inline;";//$tools->isEmpty('Caller ID');
                $flag = false;
         }
	if($_REQUEST['StatementName'] == ''){
        	        $StatementName_error = "display:inline;";//$tools->isEmpty('Caller ID');
	                $flag = false;
        	 }
	if($_REQUEST['StatementDays'] == ''){
        	        $StatementDays_error = "display:inline;";//$tools->isEmpty('Caller ID');
	                $flag = false;
        	 }
	if($_REQUEST['TaxCode'] == ''){
	                $TaxCode_error = "display:inline;";//$tools->isEmpty('Caller ID');
                	$flag = false;
        	 }
	if($_REQUEST['TaxRate'] == ''){
	                $TaxRate_error = "display:inline;";//$tools->isEmpty('Caller ID');
                	$flag = false;
        	 }
	if($_REQUEST['ZakatReason'] == ''){
                	$ZakatReason_error = "display:inline;";//$tools->isEmpty('Caller ID');
        	        $flag = false;
	         }
	if($_REQUEST['SigningDetail'] == 'Please Select'){
                    $SigningDetail_error = "display:inline;";//$tools->isEmpty('Caller ID');
                    $flag = false;
             }

	if($_REQUEST['CategoryType'] == 'Please Select'){
                        $CategoryType_error = "display:inline;";//$tools->isEmpty('Caller ID');
                        $flag = false;
                 }
	if($_REQUEST['RegionName'] == ''){
                $RegionName_error = "display:inline;";//$tools->isEmpty('Caller ID');
                $flag = false;
         }
	if($_REQUEST['EducationName'] == ''){
        	        $EducationName_error = "display:inline;";//$tools->isEmpty('Caller ID');
	                $flag = false;
        	 }
	if($_REQUEST['NationalityName'] == ''){
        	        $NationalityName_error = "display:inline;";//$tools->isEmpty('Caller ID');
	                $flag = false;
        	 }
	if($_REQUEST['SubCat'] == ''){
	                $SubCat_error = "display:inline;";//$tools->isEmpty('Caller ID');
                	$flag = false;
        	 }
	if($_REQUEST['CurrencyName'] == ''){
	                $CurrencyName_error = "display:inline;";//$tools->isEmpty('Caller ID');
                	$flag = false;
        	 }
	if($_REQUEST['Fax'] == ''){
                	$Fax_error = "display:inline;";//$tools->isEmpty('Caller ID');
        	        $flag = false;
	         }
	if($_REQUEST['PassportNo'] == 'Please Select'){
                    $PassportNo_error = "display:inline;";//$tools->isEmpty('Caller ID');
                    $flag = false;
             }
	if($_REQUEST['IssueDate'] == 'Please Select'){
                        $IssueDate_error = "display:inline;";//$tools->isEmpty('Caller ID');
                        $flag = false;
                 }
	if($_REQUEST['IssuePlace'] == ''){
                $IssuePlace_error = "display:inline;";//$tools->isEmpty('Caller ID');
                $flag = false;
         }
	if($_REQUEST['Validity'] == ''){
        	        $Validity_error = "display:inline;";//$tools->isEmpty('Caller ID');
	                $flag = false;
        	 }
	if($_REQUEST['GCNICExpiry'] == ''){
        	        $GCNICExpiry_error = "display:inline;";//$tools->isEmpty('Caller ID');
	                $flag = false;
        	 }
	if($_REQUEST['SubAgentName'] == ''){
	                $SubAgentName_error = "display:inline;";//$tools->isEmpty('Caller ID');
                	$flag = false;
        	 }
	if($_REQUEST['SubAgentEmail'] == ''){
	                $SubAgentEmail_error = "display:inline;";//$tools->isEmpty('Caller ID');
                	$flag = false;
        	 }
	if($_REQUEST['CompanyExecutive'] == ''){
                	$CompanyExecutive_error = "display:inline;";//$tools->isEmpty('Caller ID');
        	        $flag = false;
	         }
	if($_REQUEST['AccountType'] == 'Please Select'){
                    $AccountType_error = "display:inline;";//$tools->isEmpty('Caller ID');
                    $flag = false;
             }

   if($flag == true)
        {

		if(isset($_REQUEST["add"]) && !empty($_REQUEST["add"]))
		{
			$rsAdmUser = $admin->admin_user_name_exists($full_name);
			if($rsAdmUser->EOF)	{
				$admin->insert_admin_user($full_name, md5($password), $email, $designation, $department, $group_id, '1');
				$_SESSION[$db_prefix.'_SM'] = "[".$full_name."] for admin panel create successfully.";
				header ("Location: admin_new.php");
				exit();
			}
			else{
				$_SESSION[$db_prefix.'_EM'] = "[".$full_name."] for admin panel already exists.";
			}	
		}	
	
		if(isset($_REQUEST["edit"]) && !empty($_REQUEST["edit"]))
		{
			//echo $admin_id."  and  ".$_REQUEST['admin_id']; exit;	
			$rsAdmUser = $admin->admin_user_name_exists($full_name,$admin_id);
			if($rsAdmUser->EOF)	{
				
				if(isset($password) && !empty($password) && isset($cpassword) && !empty($cpassword) && ($password==$cpassword)){
					//echo "Condition 1.1";
					$admin->update_admin_user_password($admin_id,md5($password));
					$admin->update_admin_user($admin_id,$full_name, $email, $designation, $department, $group_id, '1');
					$_SESSION[$db_prefix.'_GM'] = "[".$full_name."] for admin panel updated successfully.";
					header ("Location: admin_list.php");
					exit();
				}
				else if(empty($password) && empty($cpassword)){
					//echo "Condition 1.2";
					$admin->update_admin_user($admin_id,$full_name, $email, $designation, $department, $group_id, '1');
					$_SESSION[$db_prefix.'_GM'] = "[".$full_name."] for admin panel updated successfully.";
					header ("Location: admin_list.php");
					exit();
				}
				else if((isset($password) && !empty($password)) || (isset($cpassword) && !empty($cpassword))){
					//echo "Condition 1.3";
					if($password != $cpassword){
						$_SESSION[$db_prefix.'_RM'] = "Both [passwords] not matched.";
					}
				}	

			}
			else{
			//echo  $full_name." ,".$password." ,".$email." ,".$designation." ,".$department." ,".$group_id.", ".$is_active.", ";
			//	echo "Condition 5"; exit;			
				$_SESSION[$db_prefix.'_EM'] = "[".$full_name."] for admin panel already exists.";
			}	
		}
	}	
}
		if(isset($admin_id) && !empty($admin_id))
		{
			$rsAdmin  		= 	$admin->get_admin_by_id($admin_id);
			if($rsAdmin->EOF){
				$_SESSION[$db_prefix.'_EM'] = "Admin panel user updation rejected or not found.";
				header ("Location: admin.php");
				exit();
			}
			$full_name 		= 	$rsAdmin->fields['full_name'];
			$password 		= 	$rsAdmin->fields['password'];
			$email 			= 	$rsAdmin->fields['email'];
			$designation  	= 	$rsAdmin->fields['designation'];
			$department 	= 	$rsAdmin->fields['department'];
			$group_id  		=	$rsAdmin->fields['group_id'];
			$is_active  	=	$rsAdmin->fields['is_active'];
		}		

?>

      	<div class="box">      
      		<h4 class="white">Admin Settings</h4>
        <div class="box-container">
      		<form action="<? echo $_SERVER['PHP_SELF'] ?>" method="post" class="middle-forms cmxform" name="xForm" id="xForm" onsubmit="javascript:return admin_validate(this);">
		<input type="hidden" id="admin_id" name="admin_id" value="<?php echo $tools_admin->encryptId($admin_id); ?>">
      			<h3>Add / Update</h3>
      			<p>Please complete the form below. Mandatory fields marked <em>*</em></p>
      				<fieldset>
      					<legend>Fieldset Title</legend>
      					<ol>
						
						<li class="even"><label class="field-title">Name <em>*</em>:</label> <label><input name="Name" id="Name" class="txtbox-short" value="<?php echo $Name; ?>"><span id="Name_error" class="form-error-inline" title = "Please Enter Name" style="<?php echo($Name_error); ?>"></span></label><span class="clearFix">&nbsp;</span></li>
						
                        <li ><label class="field-title">Gender <em>*</em>:</label> <label><input name="Gender" id="Gender" class="txtbox-short" value="<?php echo $Gender; ?>"><span id="Gender_error" class="form-error-inline" title = "Please Enter Gender" style="<?php echo($Gender_error); ?>"></span></label><span class="clearFix">&nbsp;</span></li>
												
                        <li class="even"><label class="field-title">NIC No <em>*</em>:</label> <label><input name="NICNo" id="NICNo" class="txtbox-short" value="<?php echo $NICNo; ?>"><span  id="NICNo_error" class="form-error-inline" title = "Please Enter NIC No" style="<?php echo($NICNo_error); ?>"></span></label><span class="clearFix">&nbsp;</span></li>  
						
					    <li><label class="field-title">CNIC Expiry <em>*</em>:</label> <label><input name="CNICExpiry" id="CNICExpiry" class="txtbox-short" value="<?php echo $CNICExpiry; ?>"><span id="CNICExpiry_error" class="form-error-inline" title = "Please Enter CNIC Expiry" style="<?php echo($CNICExpiry_error); ?>"></span></label><span class="clearFix">&nbsp;</span></li>
					
                        <li class="even"><label class="field-title">Father Name <em>*</em>:</label> <label><input name="FHName" id="FHName" class="txtbox-short" value="<?php echo $FHName; ?>"><span id="FHName_error" class="form-error-inline" title = "Please Enter Father Name" style="<?php echo($FHName_error); ?>"></span></label><span class="clearFix">&nbsp;</span></li>
						
                        <li ><label class="field-title">Marital Name <em>*</em>:</label> <label><input name="MaritalName" id="MaritalName" class="txtbox-short" value="<?php echo $MaritalName; ?>"><span id="MaritalName_error" class="form-error-inline" title = "Please Enter Marital Name" style="<?php echo($MaritalName_error); ?>"></span></label><span class="clearFix">&nbsp;</span></li>
												
                        <li class="even"><label class="field-title">Date of Birth <em>*</em>:</label> <label><input name="DateOfBirth" id="DateOfBirth" class="txtbox-short" value="<?php echo $DateOfBirth; ?>"><span  id="DateOfBirth_error" class="form-error-inline" title = "Please Enter Date of Birth" style="<?php echo($DateOfBirth_error); ?>"></span></label><span class="clearFix">&nbsp;</span></li>  
						
					    <li><label class="field-title">Occupation Name <em>*</em>:</label> <label><input name="OccupationName" id="OccupationName" class="txtbox-short" value="<?php echo $OccupationName; ?>"><span id="OccupationName_error" class="form-error-inline" title = "Please Enter Occupation Name" style="<?php echo($OccupationName_error); ?>"></span></label><span class="clearFix">&nbsp;</span></li>

						<li class="even"><label class="field-title">Account Number <em>*</em>:</label> <label><input name="AccountNumber" id="AccountNumber" class="txtbox-short" value="<?php echo $AccountNumber; ?>"><span id="AccountNumber_error" class="form-error-inline" title = "Please Enter Account Number" style="<?php echo($AccountNumber_error); ?>"></span></label><span class="clearFix">&nbsp;</span></li>
						
                        <li ><label class="field-title">Title Code <em>*</em>:</label> <label><input name="TitleCode" id="TitleCode" class="txtbox-short" value="<?php echo $TitleCode; ?>"><span id="TitleCode_error" class="form-error-inline" title = "Please Enter Title Code" style="<?php echo($TitleCode_error); ?>"></span></label><span class="clearFix">&nbsp;</span></li>
												
                        <li class="even"><label class="field-title">Email <em>*</em>:</label> <label><input name="Email" id="Email" class="txtbox-short" value="<?php echo $Email; ?>"><span  id="Email_error" class="form-error-inline" title = "Please Enter Email" style="<?php echo($Email_error); ?>"></span></label><span class="clearFix">&nbsp;</span></li>  
						
					    <li><label class="field-title">Postal Code <em>*</em>:</label> <label><input name="PostalCode" id="PostalCode" class="txtbox-short" value="<?php echo $PostalCode; ?>"><span id="PostalCode_error" class="form-error-inline" title = "Please Enter Postal Code" style="<?php echo($PostalCode_error); ?>"></span></label><span class="clearFix">&nbsp;</span></li>
					
                        <li class="even"><label class="field-title">City Name <em>*</em>:</label> <label><input name="CityName" id="CityName" class="txtbox-short" value="<?php echo $CityName; ?>"><span id="CityName_error" class="form-error-inline" title = "Please Enter City Name" style="<?php echo($CityName_error); ?>"></span></label><span class="clearFix">&nbsp;</span></li>
						
                        <li ><label class="field-title">Country Name <em>*</em>:</label> <label><input name="CountryName" id="CountryName" class="txtbox-short" value="<?php echo $CountryName; ?>"><span id="CountryName_error" class="form-error-inline" title = "Please Enter Country Name" style="<?php echo($CountryName_error); ?>"></span></label><span class="clearFix">&nbsp;</span></li>
												
                        <li class="even"><label class="field-title">Remarks <em>*</em>:</label> <label><input name="Remarks" id="Remarks" class="txtbox-short" value="<?php echo $Remarks; ?>"><span  id="Remarks_error" class="form-error-inline" title = "Please Enter Remarks" style="<?php echo($Remarks_error); ?>"></span></label><span class="clearFix">&nbsp;</span></li>  
						
					    <li><label class="field-title">Address <em>*</em>:</label> <label><input name="Address" id="Address" class="txtbox-short" value="<?php echo $Address; ?>"><span id="Address_error" class="form-error-inline" title = "Please Enter Address" style="<?php echo($Address_error); ?>"></span></label><span class="clearFix">&nbsp;</span></li>
					     
						<li class="even"><label class="field-title">Registration Date <em>*</em>:</label> <label><input name="RegistrationDate" id="RegistrationDate" class="txtbox-short" value="<?php echo $RegistrationDate; ?>"><span id="RegistrationDate_error" class="form-error-inline" title = "Please Enter Registration Date" style="<?php echo($RegistrationDate_error); ?>"></span></label><span class="clearFix">&nbsp;</span></li>
						
                        <li ><label class="field-title">Mailing Address <em>*</em>:</label> <label><input name="MailingAddress" id="MailingAddress" class="txtbox-short" value="<?php echo $MailingAddress; ?>"><span id="TitleCode_error" class="form-error-inline" title = "Please Enter Mailing Address" style="<?php echo($MailingAddress_error); ?>"></span></label><span class="clearFix">&nbsp;</span></li>
												
                        <li class="even"><label class="field-title">Guardian Name <em>*</em>:</label> <label><input name="GuardianName" id="GuardianName" class="txtbox-short" value="<?php echo $GuardianName; ?>"><span  id="GuardianName_error" class="form-error-inline" title = "Please Enter Guardian Name" style="<?php echo($GuardianName_error); ?>"></span></label><span class="clearFix">&nbsp;</span></li>  
						
					    <li><label class="field-title">NTN <em>*</em>:</label> <label><input name="NTN" id="NTN" class="txtbox-short" value="<?php echo $NTN; ?>"><span id="PostalCode_error" class="form-error-inline" title = "Please Enter NTN" style="<?php echo($NTN_error); ?>"></span></label><span class="clearFix">&nbsp;</span></li>
					
                        <li class="even"><label class="field-title">Statement Name <em>*</em>:</label> <label><input name="StatementName" id="StatementName" class="txtbox-short" value="<?php echo $StatementName; ?>"><span id="StatementName_error" class="form-error-inline" title = "Please Enter City Statement Name" style="<?php echo($StatementName_error); ?>"></span></label><span class="clearFix">&nbsp;</span></li>
						
                        <li ><label class="field-title">Statement Days <em>*</em>:</label> <label><input name="StatementDays" id="StatementDays" class="txtbox-short" value="<?php echo $StatementDays; ?>"><span id="StatementDays_error" class="form-error-inline" title = "Please Enter Statement Days" style="<?php echo($StatementDays_error); ?>"></span></label><span class="clearFix">&nbsp;</span></li>
												
                        <li class="even"><label class="field-title">Tax Code <em>*</em>:</label> <label><input name="TaxCode" id="TaxCode" class="txtbox-short" value="<?php echo $TaxCode; ?>"><span  id="TaxCode_error" class="form-error-inline" title = "Please Enter Tax Code" style="<?php echo($TaxCode_error); ?>"></span></label><span class="clearFix">&nbsp;</span></li>  
						
					    <li><label class="field-title">Tax Rate <em>*</em>:</label> <label><input name="TaxRate" id="TaxRate" class="txtbox-short" value="<?php echo $TaxRate; ?>"><span id="TaxRate_error" class="form-error-inline" title = "Please Enter Tax Rate" style="<?php echo($TaxRate_error); ?>"></span></label><span class="clearFix">&nbsp;</span></li>
					     
						<li ><label class="field-title">Zakat Reason <em>*</em>:</label> <label><input name="ZakatReason" id="ZakatReason" class="txtbox-short" value="<?php echo $ZakatReason; ?>"><span id="ZakatReason_error" class="form-error-inline" title = "Please Enter Zakat Reason" style="<?php echo($ZakatReason_error); ?>"></span></label><span class="clearFix">&nbsp;</span></li>
												
                        <li class="even"><label class="field-title">Signing Detail <em>*</em>:</label> <label><input name="SigningDetail" id="SigningDetail" class="txtbox-short" value="<?php echo $SigningDetail; ?>"><span  id="SigningDetail_error" class="form-error-inline" title = "Please Enter Signing Detail" style="<?php echo($SigningDetail_error); ?>"></span></label><span class="clearFix">&nbsp;</span></li>  
						
					    <li><label class="field-title">Category Type <em>*</em>:</label> <label><input name="CategoryType" id="CategoryType" class="txtbox-short" value="<?php echo $CategoryType; ?>"><span id="CategoryType_error" class="form-error-inline" title = "Please Enter Category Type" style="<?php echo($CategoryType_error); ?>"></span></label><span class="clearFix">&nbsp;</span></li>
					     
						<li class="even"><label class="field-title">Region Name <em>*</em>:</label> <label><input name="RegionName" id="RegionName" class="txtbox-short" value="<?php echo $RegionName; ?>"><span id="RegionName_error" class="form-error-inline" title = "Please Enter Region Namee" style="<?php echo($RegionName_error); ?>"></span></label><span class="clearFix">&nbsp;</span></li>
						
                        <li ><label class="field-title">Education Name <em>*</em>:</label> <label><input name="EducationName" id="EducationName" class="txtbox-short" value="<?php echo $EducationName; ?>"><span id="EducationName_error" class="form-error-inline" title = "Please Enter Education Name" style="<?php echo($EducationName_error); ?>"></span></label><span class="clearFix">&nbsp;</span></li>
												
                        <li class="even"><label class="field-title">Nationality Name <em>*</em>:</label> <label><input name="NationalityName" id="NationalityName" class="txtbox-short" value="<?php echo $NationalityName; ?>"><span  id="NationalityName_error" class="form-error-inline" title = "Please Enter Nationality Name" style="<?php echo($NationalityName_error); ?>"></span></label><span class="clearFix">&nbsp;</span></li>  
						
					    <li><label class="field-title">NTN <em>*</em>:</label> <label><input name="NTN" id="NTN" class="txtbox-short" value="<?php echo $NTN; ?>"><span id="PostalCode_error" class="form-error-inline" title = "Please Enter NTN" style="<?php echo($NTN_error); ?>"></span></label><span class="clearFix">&nbsp;</span></li>
					
                        <li class="even"><label class="field-title">Statement Name <em>*</em>:</label> <label><input name="StatementName" id="StatementName" class="txtbox-short" value="<?php echo $StatementName; ?>"><span id="StatementName_error" class="form-error-inline" title = "Please Enter City Statement Name" style="<?php echo($StatementName_error); ?>"></span></label><span class="clearFix">&nbsp;</span></li>
						
                        <li ><label class="field-title">Statement Days <em>*</em>:</label> <label><input name="StatementDays" id="StatementDays" class="txtbox-short" value="<?php echo $StatementDays; ?>"><span id="StatementDays_error" class="form-error-inline" title = "Please Enter Statement Days" style="<?php echo($StatementDays_error); ?>"></span></label><span class="clearFix">&nbsp;</span></li>
												
                        <li class="even"><label class="field-title">Tax Code <em>*</em>:</label> <label><input name="TaxCode" id="TaxCode" class="txtbox-short" value="<?php echo $TaxCode; ?>"><span  id="TaxCode_error" class="form-error-inline" title = "Please Enter Tax Code" style="<?php echo($TaxCode_error); ?>"></span></label><span class="clearFix">&nbsp;</span></li>  
						
					    <li><label class="field-title">Tax Rate <em>*</em>:</label> <label><input name="TaxRate" id="TaxRate" class="txtbox-short" value="<?php echo $TaxRate; ?>"><span id="TaxRate_error" class="form-error-inline" title = "Please Enter Tax Rate" style="<?php echo($TaxRate_error); ?>"></span></label><span class="clearFix">&nbsp;</span></li>
					     


					     
      					</ol>
      				</fieldset> 
      				<p class="align-right">
					<?php   if(isset($admin_id) && !empty($admin_id)){?>
						<a class="button" href="javascript:document.xForm.submit();"  ><span>Update</span></a>
						<input type="hidden" value="UPDATE ADMIN >>" id="edit" name="edit"/>
                			<?php    }
                			else{
                			?>
                    				<a class="button" href="javascript:document.xForm.submit();" onclick="javascript:return admin_validate('xForm');"><span>Add</span></a>
						<input type="hidden" value="CREATE NEW ADMIN >>" id="add" name="add" />
               				<?php    }?>					
					<!--<input type="image" src="images/bt-send-form.gif" />-->
				</p>
      				<span class="clearFix">&nbsp;</span>
      		</form>
        </div><!-- end of div.box-container -->
      	</div><!-- end of div.box -->
<?php include($site_root."includes/footer.php"); ?> 
