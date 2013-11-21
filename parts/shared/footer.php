	</div> <!-- /#wrap_outer -->
    
	<footer class="align_left text_center width_full test_bg_blue">
		&copy; <?php echo date("Y"); ?> <?php bloginfo( 'name' ); ?>. All rights reserved.
	</footer>
    
    <!-- Container to hold notifications, and default templates -->
    <!-- @source:  https://github.com/ehynds/jquery-notify/tree/master/src -->
	<section id="container_notify" style="display:none">
		
		<div id="default">
			<h1>#{title}</h1>
			<p>#{text}</p>
		</div>
		
		<div id="sticky">
			<a class="ui-notify-close ui-notify-cross" href="#">x</a>
			<h1>#{title}</h1>
			<p>#{text}</p>
		</div>
		
		<div id="themeroller" class="ui-state-error" style="padding:10px; -moz-box-shadow:0 0 6px #980000; -webkit-box-shadow:0 0 6px #980000; box-shadow:0 0 6px #980000;">
			<a class="ui-notify-close" href="#"><span class="ui-icon ui-icon-close" style="float:right"></span></a>
			<span style="float:left; margin:0 5px 0 0;" class="ui-icon ui-icon-alert"></span>
			<h1>#{title}</h1>
			<p>#{text}</p>
			<p style="text-align:center"><a class="ui-notify-close" href="#">Close Me</a></p>
		</div>
		
		<div id="withIcon">
			<a class="ui-notify-close ui-notify-cross" href="#">x</a>
			<div style="float:left;margin:0 10px 0 0"><img src="#{icon}" alt="warning" /></div>
			<h1>#{title}</h1>
			<p>#{text}</p>
		</div>
		
		<div id="buttons">
			<h1>#{title}</h1>
			<p>#{text}</p>
			<p style="margin-top:10px;text-align:center">
				<input type="button" class="confirm" value="Close Dialog" />
			</p>
		</div>
	</section> <!-- /#container -->
    
    <!-- second container -  bottom notifications -->
	<section id="container-bottom" style="display:none; top:auto; left:0; bottom:0; margin:0 0 10px 10px">
		<div>
			<h1>#{title}</h1>
			<p>#{text}</p>
			<p style="margin-top:10px;text-align:center">
				<input type="button" class="confirm" value="Create Another Notification!" />
			</p>
		</div>
		
		<div>
			<h1>#{title}</h1>
			<p>#{text}</p>
		</div>
	</section>
    
	<!-- third container -  bottom-right notifications -->
	<section id="container-bottom-right" style="display:none; top:0; right:360px; margin:10px 10px 0 0">
		<div id="queueing">
			<h1>#{title}</h1>
			<p>#{text}</p>
		</div>   
	</section>
