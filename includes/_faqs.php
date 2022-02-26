<script type="text/javascript">
$(document).ready(function(){
	//hide the all of the element with class msg_body
	$(".msg_body").hide();
	//toggle the componenet with class msg_body
	$(".msg_head").click(function(){
		$(this).next(".msg_body").slideToggle('fast');

		var contentPanelId = jQuery(this).attr("id");
		var sentence = document.getElementById('txtquery').value;
		if (sentence.indexOf(contentPanelId)==-1)
		{
			if(document.getElementById('txtquery').value == '')
			{
				 document.getElementById('txtquery').value+= contentPanelId ;
			}
			else
			{
				document.getElementById('txtquery').value+= ',' + contentPanelId ;
			}
		}
		//alert("contentPanelId: "+ contentPanelId + "sentence: " + sentence);

	});
});
</script>
<style type="text/css">
p {
	padding: 0 0 1em;
}
.msg_list {
	margin: 0px;
	padding: 3px 0px 0px;
	/*width: 383px;*/
}
.msg_head {
	padding: 5px 10px;
	cursor: pointer;
	position: relative;
	background-color:#F7E0C3;
	margin:1px;
	color: black;
}
.msg_body {
	padding: 5px 10px 15px;
	/*background-color:#F4F4F8;*/
	color: black;
}
</style>
<h1>FAQs</h1>
<div class="msg_list">
		<p class="msg_head" id="Q1">Q1: What are Mutual Funds? </p>
		<div class="msg_body">
			&raquo; A Mutual Fund is a pool of investments collected from INVESTORS like you and then invested into commercial ventures based on investment strategies of a Mutual Fund Company.</br></br> 
			&raquo; The pool is managed by a team of professionals known as fund managers.</br></br>
			&raquo; Investors who purchase units of a mutual fund are its unit-holders.</br></br>
			&raquo; Mutual funds distribute 90% of their realized income to its unit-holders at the time of dividend pay-out.</br></br>
		</div>

	
		<p class="msg_head" id="Q2">Q2: Types of Mutual Fund Investments?</p>
		<div class="msg_body">
			&raquo; Growth = Profit is compounded and re-invested</br></br>
			&raquo; Income = Profit is deposited in your account which you can withdraw anytime</br></br>
		</div>
	
		<p class="msg_head" id="Q3">Q3: Advantages of Mutual Funds</p>
		<div class="msg_body">
			&raquo; Competitive returns when compared to banks or other investment opportunities</br></br>
			&raquo; Profit on daily basis is distributed so you don.t lose on any day</br></br>
			&raquo; Minimum balance of Rs 150 is required to open an account unlike other investment opportunities.</br></br>
			&raquo; Easy encashment - no lock up period</br>
				- However, Constitutive Documents allow the upto 06 working days.
			&raquo; Secure investment avenues with no exposure to stock market</br></br>
				- Your investment in Money Market Funds is low risk with no direct or indirect exposure to shares/stock market, corporate bonds and long term debt securities. </br>
				- These funds aim to provide safe and consistent returns by investing in government securities and AA or above rated entities. </br>
				- These funds are regulated by the Securities &amp; Exchange Commission of Pakistan.</br></br>

			&raquo; Regular income options available</br>
				- Monthly
				- Quarterly
				- Semiannual</br></br>

			&raquo; Shariah compliant product option available, which invest only in </br>
				- Shariah compliant short term government Sukuks
				- Money market instruments
				- Islamic bank deposits.</br></br>

			&raquo; Tax efficient returns and tax credit</br>
				- As per applicable tax laws, your investment in Money Market Fund is tax exempt if your investment in held for more than one year. 
				- Moreover, under Section 62 of Income Tax Ordinance, 2001, you can avail tax credit uptoRs. 75,000 per annum if you are self employed individual and uptoRs. 60,000 per annum if you are salaried individual. </br></br>

		</div>
	
                <p class="msg_head" id="Q4">Q4: What are MONEY MARKET FUND?</p>
                <div class="msg_body">
                        &raquo; A money market fund is a mutual fund that invests its assets only in the most liquid of money instruments.</br></br>
			&raquo; The portfolio seeks stability by investing in very short term, interest- bearing instruments and other debt certificates that can be converted into cash readily, and can be considered as the equivalent of cash.</br></br>
			
			&raquo; Usually money market funds are considered as the safest for novice investors while being the easiest, least complicated to follow and understand. </br></br>
			&raquo; Money market funds are considered appropriate for investors seeking </br></br>
				&nbsp; - Stability of principal</br></br>
				&nbsp; - Total liquidity </br></br>
				&nbsp; - Earnings that are as high, or higher, than those available through bank certificates of deposits.</br></br> 

			&raquo; The money market mutual fund is recommended as an ideal investment for risk adverse investor due to the advantages they offer including:</br></br>
				&nbsp; - Safety of principal, through diversification and stability of the short-term portfolio investments.</br>
				&nbsp; - Total and immediate liquidity.</br></br>
				&nbsp; - Better yields than offered by banks.</br></br>
				&nbsp; - Low minimum investment.</br></br>
				&nbsp; - And unlike bank term deposits, money market funds have no early withdrawal penalties</br></br>
                </div>
                <p class="msg_head" id="Q5">Q5: What is MUFAP?</p>
                <div class="msg_body">
                        &raquo; Mutual Funds Association of Pakistan (MUFAP) is the trade body for Pakistan's multi billion rupees asset management industry. Their role is to ensure transparency, high ethical conduct and growth of the mutual fund industry.
                </div>
                <p class="msg_head" id="Q6">Q6: How can you invest in Money Market Funds?</p>
                <div class="msg_body">
                        It.s a simple 3 step process:</br></br>
			
			&raquo; Step 1 - Fill out an investment form at any of the participating institutions.</br></br>
			&raquo; Step 2 . Attach the NIC Copy, Zakat Declaration Form and a cheque of your desired investment amount.</br></br>
			&raquo; Step 3 . Submit the Form to the branch or representative of the participating institutions.</br></br>
                </div>
                <p class="msg_head" id="Q7">Q7: What is Tax Credit?</p>
                <div class="msg_body">

                        &raquo; A tax credit is a kind of tax saving that you can get on your income tax for the year if you invest in mutual fund schemes, investment plans and/or pension schemes provided you decide to hold your investment for a period of one year.</br></br> 
			&raquo; This tax savings facility can be availed by both salaried and self-employed individuals in accordance with the Income Tax Ordinance, 2001.</br></br>



                </div>

</div>
