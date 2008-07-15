

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" >
<head>
<title><?php echo $title_for_layout?></title>
<link rel="stylesheet" type="text/css" href="/cake/app/webroot/css/default.css" media="screen" />
<meta http-equiv="Content-Type" content="text/html;charset=iso-8859-1" />
<?php echo $scripts_for_layout?>
</head>
<body>
    <div>
<div class="top">
				
	<div class="header">

		<div class="left">&nbsp;&nbsp;&nbsp;DISCOACUARIO </div>
		
		<div class="right">
		<div>
			Valid XHTML 1.1 Transitional, Valid CSS 2.</div>
		</div>

	</div>	

</div>

<div class="container">	

	<div class="navigation"><a href="#" title="Home">HOME</a><a href=<?php echo $html->url('/fishes/disco');?> >PECES DISCO</a><a href=<?php echo $html->url('/fishes/display');?> >PECES EN STOCK</a><a href="#" title="FAQs">BLUE PAGE</a><a href="#" title="Contact Us">CONTACT US</a> 

<div class="clearer"><span></span></div>
	</div>

	<div class="main">		
		
	  <div class="content">
	   <?php echo $content_for_layout ?>
	    
	 </div>

		<div class="sidenav">

			<h2>FlexCMS</h2>
			<ul>
		<li><a href="#" title="Home">Home </a></li><li><a href="#" title="Downloads">Forest Green </a></li>
		<li><a href="http://www.flexcms.co.uk/FlexCMS_Documentation.aspx" title="Documentation">Trees </a></li>
		<li><a href="#" title="FAQs">About Us </a></li>
		<li><a href="http://www.flexcms.co.uk/FlexCMS_ContactUs.aspx" title="Contact Us">Contact Us </a></li>
		</ul>

			<h2>Membership</h2>
			<ul>
				<li><a href=<?php echo $html->url('/users/login');?> >Login </a></li>
				<li><a href=<?php echo $html->url('/users/registrar');?> >Registrarse</a></li>
			
			</ul>

			<h2>FlexCMS Bespoke versions </h2>
			<ul>
				<li><a href="http://www.giant-systems.co.uk/">FlexCMS </a></li>
				<li><a href="http://www.giant-systems.co.uk/Ecommerce.aspx">FlexEcommerce</a></li>
				<li><a href="http://www.giant-systems.co.uk/casestudies.aspx">FlexCMS portal server </a></li>
                <li><a href="http://www.giant-systems.co.uk/casestudies.aspx">FlexCMS Intranet </a></li>
            </ul>
            <br />
            <br />
  
		
</div>

		<div class="clearer"><span></span></div>

	</div>

	<div class="footer">&copy; Your name here - Design by <a href="http://www.giant-systems.co.uk" title="Giant Systems Web design">Giant Systems Ltd</a>
	</div>

</div>

       
        
        
    </div>

<div style="font-size: 0.8em; text-align: center; margin-top: 1.0em; margin-bottom: 1.0em;">
Design downloaded from <a href="http://www.freewebtemplates.com/">Free Templates</a> - your source for free web templates
</div>
</body>
</html>