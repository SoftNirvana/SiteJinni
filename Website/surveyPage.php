<?php
    include './Classes/DataAccess.php';
    include './Classes/Entities/EntityBase.php';
    include './Classes/Entities/Survey.php';
    
    if ($_SERVER["REQUEST_METHOD"] == "POST") {	
        //----------- POST Request - Save Header ----------------------
        if(isset($_POST["submitbtn"])) {
            
            
             $Id=0;
             
             $personname =isset($_POST["personname"])? $_POST["personname"]:"";            
             $personplace = isset($_POST["personplace"])? $_POST["personplace"]:"";
             $professionField = isset($_POST["professionField"])? $_POST["professionField"]:"";
             $industryField = isset($_POST["industryField"])? $_POST["industryField"]:"";
             $doescreate = isset($_POST["doescreate"])? ($_POST["doescreate"]=="on"? true: false): false;
             $creativetypeField = isset($_POST["creativetypeField"])? $_POST["creativetypeField"]:"";
             $localreach = isset($_POST["localreach"])? ($_POST["localreach"]=="on"? true: false): false;
             $cityreach = isset($_POST["cityreach"])? ($_POST["cityreach"]=="on"? true: false): false;
             $statereach =isset($_POST["statereach"])? ($_POST["statereach"]=="on"? true: false): false;
             $nationalreach = isset($_POST["nationalreach"])? ($_POST["nationalreach"]=="on"? true: false): false;
             $globalreach = isset($_POST["globalreach"])? ($_POST["globalreach"]=="on"? true: false): false;
             $globalreachTypeField = isset($_POST["globalreachTypeField"])? $_POST["globalreachTypeField"]:"";
             $needwebsite = isset($_POST["needwebsite"])? ($_POST["needwebsite"]=="on"? true: false): false;
             $wantsmicrosite = isset($_POST["wantsmicrosite"])? ($_POST["wantsmicrosite"]=="on"? true: false): false;
             $wantsfullwebsite = isset($_POST["wantsfullwebsite"])? ($_POST["wantsfullwebsite"]=="on"? true: false): false;
             $subdomain = isset($_POST["subdomain"])? ($_POST["subdomain"]=="on"? true: false): false;
             $fulldomain = isset($_POST["fulldomain"])? ($_POST["fulldomain"]=="on"? true: false): false;
             $diy = isset($_POST["diy"])? ($_POST["diy"]=="on"? true: false): false;
             $diywithtraining = isset($_POST["diywithtraining"])? ($_POST["diywithtraining"]=="on"? true: false): false;
             $webdesigner = isset($_POST["webdesigner"])? ($_POST["webdesigner"]=="on"? true: false): false;
             $nodiy = isset($_POST["nodiy"])? ($_POST["nodiy"]=="on"? true: false): false;
             $nodigimart = isset($_POST["nodigimart"])? ($_POST["nodigimart"]=="on"? true: false): false;
             $digimart = isset($_POST["digimart"])? ($_POST["digimart"]=="on"? true: false): false;
             $nomarketing = isset($_POST["nomarketing"])? ($_POST["nomarketing"]=="on"? true: false): false;
             $wantads = isset($_POST["wantads"])? ($_POST["wantads"]=="on"? true: false): false;
             $wantthemedtemplates = isset($_POST["wantthemedtemplates"])? ($_POST["wantthemedtemplates"]=="on"? true: false): false;
             $norecommend = isset($_POST["norecommend"])? ($_POST["norecommend"]=="on"? true: false): false;
             $willrecommendfree = isset($_POST["willrecommendfree"])? ($_POST["willrecommendfree"]=="on"? true: false): false;
             $willrecommendall = isset($_POST["willrecommendall"])? ($_POST["willrecommendall"]=="on"? true: false): false;
             $willrecommendforreturn = isset($_POST["willrecommendforreturn"])? ($_POST["willrecommendforreturn"]=="on"? true: false): false;
             $cantsay =isset($_POST["cantsay"])? ($_POST["cantsay"]=="on"? true: false): false; 
             $noadonpage = isset($_POST["noadonpage"])? ($_POST["noadonpage"]=="on"? true: false): false;
             $adonpagefree = isset($_POST["adonpagefree"])? ($_POST["adonpagefree"]=="on"? true: false): false;
             $adonpagediscount = isset($_POST["adonpagediscount"])? ($_POST["adonpagediscount"]=="on"? true: false): false;
             $adonpageprofit = isset($_POST["adonpageprofit"])? ($_POST["adonpageprofit"]=="on"? true: false): false;
             $adonpagead = isset($_POST["adonpagead"])? ($_POST["adonpagead"]=="on"? true: false): false;
             $adonpagespace = isset($_POST["adonpagespace"])? ($_POST["adonpagespace"]=="on"? true: false): false;
             $adonpagedisply = isset($_POST["adonpagedisply"])? ($_POST["adonpagedisply"]=="on"? true: false): false;
             $adonpageok = isset($_POST["adonpageok"])? ($_POST["adonpageok"]=="on"? true: false): false;
             $suggestions = isset($_POST["suggestions"])? $_POST["suggestions"]:"";
             
             $survey = new Survey($Id, $personname, $personplace, $professionField, $industryField, $doescreate, $creativetypeField, 
                     $localreach, $cityreach, $statereach, $nationalreach, $globalreach, $globalreachTypeField, $needwebsite, $wantsmicrosite, 
                     $wantsfullwebsite, $subdomain, $fulldomain, $diy, $diywithtraining, $webdesigner, $nodiy, $nodigimart, $digimart, 
                     $nomarketing, $wantads, $wantthemedtemplates, $norecommend, $willrecommendfree, $willrecommendall, $willrecommendforreturn, 
                     $cantsay, $noadonpage, $adonpagefree, $adonpagediscount, $adonpageprofit, $adonpagead, $adonpagespace, $adonpagedisply, $adonpageok,$suggestions);
             
             $survey->AddEntity();
    
        }
    }
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <META charset="utf-8">
    <META http-equiv="X-UA-Compatible" content="IE=edge">
    <META name="viewport" content="width=device-width, initial-scale=1">
    <META name="description" content="">
    <META name="author" content="">
    <TITLE>
        Sitejinni Survey
    </TITLE>
	
    <META name="GENERATOR" content="WDL-Website-Builder">     <!-- Bootstrap Core CSS -->
    <LINK href="vendor/twbs/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">     <!-- Custom CSS -->
    <LINK href="https://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,800italic,400,300,600,700,800" rel="stylesheet" type="text/css">
    <LINK href="https://fonts.googleapis.com/css?family=Josefin+Slab:100,300,400,600,700,100italic,300italic,400italic,600italic,700italic" rel="stylesheet" type="text/css">     <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
    <script src="vendor/twbs/bootstrap/dist/js/bootstrap.min.js"></script>

    <script  language="JavaScript" type="text/javascript">
        function fillField(from, to)
        {
            to.value = from.children[from.value-1].text;
        }
    </script>
</head>

<body>
<header>
	<h2><text>Market Survey</text></h2>
</header>
<hr />
<p>
	<form name="surveyForm" id="surveyForm" method="POST" action="#">
		<div >
			<div class="row">
				<div class="col-lg-12">
					<span style="width: 100%; margin:1%"><h4>Q1. What is your name?</h4></span>
				</div>
				<div class="col-lg-12">
					<span style="width: 100%; margin:1%"><input type="text" name="personname" style="width: 97%;"/></span>
				</div>
			</div>
			<div class="row">
				<div class="col-lg-12">
					<span style="width: 100%; margin:1%"><h4>Q2. Where do you live?</h4></span>
				</div>
				<div class="col-lg-12">
					<span style="width: 100%; margin:1%"><input type="text" name="personplace" style="width: 97%;"/></span>
				</div>
			</div>
			<div class="row">
				<div class="col-lg-12">
					<span style="width: 100%; margin:1%"><h4>Q3. What is your profession?</h4></span>
				</div>
				<div class="col-lg-12">
					<span style="width: 100%; margin:1%">
						  <select name="profession" id="professionSelect" placeholder="select" onchange="fillField(professionSelect,professionField)">
						  		  <option value="1" SELECTED>Employed</option>
								  <option value="2">Self Employed</option>
								  <option value="3">Student</option>
						  </select>
						  <input name="professionField" id="professionField" value="Employed" placeholder="Specify if not in list" type="hidden" style="width: 45%"/>
					</span>
				</div>
			</div>
			<div class="row">
				<div class="col-lg-12">
					<span style="width: 100%; margin:1%"><h4>Q4. How would you categorize your profession?</h4></span>
				</div>
				<div class="col-lg-12">
					<span style="width: 100%; margin:1%">
						  <select id="industrySelect" name="industry" style="width: 45%" onchange="fillField(industrySelect,industryField)">
						  		  <option value="1" SELECTED>Manufacturing</option>
								  <option value="2">IT Enabled Services</option>
								  <option value="3">Software Development</option>
								  <option value="4">Mass Communication</option>
								  <option value="5">Entertainment</option>
								  <option value="6">Realestate</option>
								  <option value="7">Financial</option>
								  <option value="8">Transport</option>
								  <option value="9">Public Sector Services</option>
								  <option value="9">Creative/Art</option>
								  <option value="9">Architecture</option>
								  <option value="9">Gallery/Exhibition</option>
								  <option value="9">Event Management</option>
								  <option value="9">Other Services</option>
						  </select>
                                            <input id="industryField" name="industryField" value="Manufacturing" placeholder="Specify if not in list" type="text" style="width: 45%"/>
					</span>
				</div>
			</div>
			<div class="row">
				<div class="col-lg-12">
					<span style="width: 100%; margin:1%"><h4>Q5. Do you have creative/entrepreneurial inclination?</h4></span>
				</div>
				<div class="col-lg-12">
                                    <span style="width: 100%; margin:1%"><input type="checkbox" name="doescreate"    /></span>					
				</div>
			</div>
			<div class="row">
				<div class="col-lg-12">
					<span style="width: 100%; margin:1%"><h4>Q6. What is your inclination?</h4></span>
				</div>
				<div class="col-lg-12">
					<span style="width: 100%; margin:1%"    >
						  <select id="creativetypeSelect" name="creativetype" style="width: 45%" onchange="fillField(creativetypeSelect,creativetypeField)">
						  		  <option value="1" SELECTED>Visual Art (painting/photography/video/filmmaking etc.)</option>
								  <option value="2">Performing Art (dance/music/theatre etc.)</option>
								  <option value="3">Multidisciplinary Art Forms (Video Games/Gastronomy etc.)</option>
								  <option value="4">Product/Graphic/Fashion Design</option>
								  <option value="5">Software/IT Services</option>
								  <option value="6">Printing/Publishing</option>
								  <option value="7">Other</option>
						  </select>
                                            <input id="creativetypeField" name="creativetypeField" value="Visual Art (painting/photography/video/filmmaking etc.)" placeholder="Specify if not in list" type="text" style="width: 45%"/>
					</span>
				</div>
			</div>
			<div class="row">
				<div class="col-lg-12">
					<span style="width: 100%; margin:1%"><h4>Q7. How much reach do you think suits your business?</h4></span>
				</div>
				<div class="col-lg-12">
					<span style="width: 100%; margin:1%">Locality: </span><input type="checkbox" name="localreach"  /><br>
					<span style="width: 100%; margin:1%">Town/City: </span><input type="checkbox" name="cityreach"    /><br>
					<span style="width: 100%; margin:1%">Region/State: </span><input type="checkbox" name="statereach"    /><br>
					<span style="width: 100%; margin:1%">National: </span><input type="checkbox" name="nationalreach"    /><br>
					<span style="width: 100%; margin:1%">Global: </span><input type="checkbox" name="globalreach"    /><br>
				</div>
			</div>
			<div class="row">
				<div class="col-lg-12">
					<span style="width: 100%; margin:1%"><h4>Q8. What is the best way to maximize you reach you can think of?</h4></span>
				</div>
				<div class="col-lg-12">
					<span style="width: 100%; margin:1%">
						<select id="globalreachTypeSelect" name="globalreachType" style="width: 45%" onchange="fillField(globalreachTypeSelect,globalreachTypeField)">
							<option value="1" SELECTED>Own Website</option>
							<option value="2">Social Networks</option>
							<option value="3">Print or Electronic Media</option>
							<option value="4">Direct Contacts</option>
							<option value="5">Other</option>
						</select>
                                            <input id="globalreachTypeField" name="globalreachTypeField" value="Own Website" placeholder="Specify if not in list" type="text" style="width: 45%"/>
					</span>
				</div>
			</div>
			<div class="row">
				<div class="col-lg-12">
					<span style="width: 100%; margin:1%"><h4>Q9. Do you think you could do with a website?</h4></span><br><text sstyle="font-size: 12px">(Personal website can help you publicize your creations, your resume, your views and discussions and many more)</text>
				</div>
				<div class="col-lg-12">
					<span style="width: 100%; margin:1%"><input type="checkbox" name="needwebsite"    /></span>					
				</div>
			</div>
			<div class="row">
				<div class="col-lg-12">
					<span style="width: 100%; margin:1%"><h4>Q10. Would you like a small 1/2 page compact website or a full scale web application?</h4></span>
				</div>
				<div class="col-lg-12">
					<span style="width: 100%; margin:1%">small: </span><input type="checkbox" name="wantsmicrosite"    />
					<span style="width: 100%; margin:1%">full: </span><input type="checkbox" name="wantsfullwebsite"    />
				</div>
			</div>
			<div class="row">
				<div class="col-lg-12">
					<span style="width: 100%; margin:1%"><h4>Q11. What kind of website name would you prefer?</h4></span>
				</div>
				<div class="col-lg-12">
					<span style="width: 100%; margin:1%">I can do with  a name like <b>website.hostsite.com</b> if it is free: </span><input type="checkbox" name="subdomain"    /><br>
					<span style="width: 100%; margin:1%">I would rather pay for a name like <b>website.com/website.net</b>: </span><input type="checkbox" name="fulldomain"    />
				</div>
			</div>
			<div class="row">
				<div class="col-lg-12">
					<span style="width: 100%; margin:1%"><h4>Q12. Would you like to DIY?</h4></span>
				</div>
				<div class="col-lg-12">
					<span style="width: 100%; margin:1%">I would prefer to make the website myself if the process is fast and simple enough: </span><input type="checkbox" name="diy"    /><br>
					<span style="width: 100%; margin:1%">I would prefer make the website myself if a training material/tutorial/video is provided: </span><input type="checkbox" name="diywithtraining"    /><br>
					<span style="width: 100%; margin:1%">I would prefer a professional to make the website: </span><input type="checkbox" name="webdesigner"    /><br>
					<span style="width: 100%; margin:1%">I know web-development I can do it myself, I do not care how much time it takes: </span><input type="checkbox" name="nodiy"    />
				</div>
			</div>
			<div class="row">
				<div class="col-lg-12">
					<span style="width: 100%; margin:1%"><h4>Q13. How would you like to publicize your website?</h4></span>
				</div>
				<div class="col-lg-12">
					<span style="width: 100%; margin:1%">I do not. Normal Google search  would do / I will publicize it my self by sharing with other people and social media: </span><input type="checkbox" name="nodigimart"    /><br>
					<span style="width: 100%; margin:1%">I would like my website to feature on the first page in google searches, I would also like my website to be featured on various social media: </span><input type="checkbox" name="digimart"    />
				</div>
			</div>
			<div class="row">
				<div class="col-lg-12">
					<span style="width: 100%; margin:1%"><h4>Q14. What kind of online marketing/publicity would you like apart from the ones in previous question?</h4></span>
				</div>
				<div class="col-lg-12">
					<span style="width: 100%; margin:1%">None: </span><input type="checkbox" name="wantsmicrosite"/><br>
					<span style="width: 100%; margin:1%">I would pay to place Ads on other people's website: </span><input type="checkbox" name="wantads"    /><br>
					<span style="width: 100%; margin:1%">I would pay for a way to make themes (for publicity of my product/service) that other people would use in their websites: </span><input type="checkbox" name="wantthemedtemplates"    />
				</div>
			</div>
			<div class="row">
				<div class="col-lg-12">
					<span style="width: 100%; margin:1%"><h4>Q15. Would you recommend others to create free and fast websites?</h4></span>
				</div>
				<div class="col-lg-12">
					<span style="width: 100%; margin:1%">No way: </span><input type="checkbox" name="norecommend"    /><br>
					<span style="width: 100%; margin:1%">Yes but not for paid services: </span><input type="checkbox" name="willrecommendfree"    /><br>
					<span style="width: 100%; margin:1%">Yes and also for paid services: </span><input type="checkbox" name="willrecommendall"    /><br>
					<span style="width: 100%; margin:1%">Yes but want some benefit out of it: </span><input type="checkbox" name="willrecommendforreturn"    /><br>
					<span style="width: 100%; margin:1%">Can't say until I use the services: </span><input type="checkbox" name="cantsay"    />
				</div>
			</div>
			<div class="row">
				<div class="col-lg-12">
					<span style="width: 100%; margin:1%"><h4>Q16. If you are making a website, would you mind if Ad Sections were placed on the pages?</h4></span>
				</div>
				<div class="col-lg-12">
					<span style="width: 100%; margin:1%">Of Course I will mind: </span><input type="checkbox" name="noadonpage"    /><br>
					<span style="width: 100%; margin:1%">I won't mind if my website is free: </span><input type="checkbox" name="adonpagefree"    /><br>
					<span style="width: 100%; margin:1%">I won't mind if I am getting some discounts on paid services: </span><input type="checkbox" name="adonpagediscount"    /><br>
					<span style="width: 100%; margin:1%">I won't mind if I am getting a share of the Ad's profit even on free website: </span><input type="checkbox" name="adonpageprofit"    /><br>
					<span style="width: 100%; margin:1%">I won't mind if my Ad is also placed on other's websites: </span><input type="checkbox" name="adonpagead"    /><br>
					<span style="width: 100%; margin:1%">I won't mind as long as it does not take too much space: </span><input type="checkbox" name="adonpagespace"    /><br>
					<span style="width: 100%; margin:1%">I won't mind if I can choose where on the page to display it: </span><input type="checkbox" name="adonpagespace"    /><br>
					<span style="width: 100%; margin:1%">I won't mind at all: </span><input type="checkbox" name="adonpageok"    />
				</div>
			</div>
			<div class="row">
				<div class="col-lg-12">
					<span style="width: 100%; margin:1%"><h4>Q16. Any suggestions regarding the above?</h4></span>
				</div>
				<div class="col-lg-12">
					<span style="width: 100%; margin:1%"><input type="text" name="suggestions" style="width: 97%;"/></span>
				</div>
			</div>
			<p>
			<hr>
			<p>
			<div class="row">
				<div class="col-lg-12">
					<span style="width: 100%; margin:1%"><input type="submit" id="submitbtn" name="submitbtn" value="Submit Survey" style="width: 97%"/></span>
				</div>
			</div
		</div>
	</form>

<hr />
</body>
</html>
