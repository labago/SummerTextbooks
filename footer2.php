				</div>
				<div id="sidebar" class="column column-240 column-right">
								<ul>	
                        <li>
        
                            <h4>Links</h4>
            
                            <ul>
                             <li><a href="index.php">Home</a></li>
                    <li><a href="contact-us.php">Contact Us</a></li>
                    <li><a href="search.php">Search</a></li>
                    <li><a href="account.php">My Account</a></li>
                    <?php if(isset($_SESSION['logged_in']) && $_SESSION['logged_in'] == 1){ ?>
                    <li><a href="books.php">My Book Queue</a></li>
                    <li><a href="orders.php">My Orders</a></li>
                    <?php } ?>
                    <li><a href="terms.php">Terms and Conditions</a></li>
                    </ul> 
                    <script type="text/javascript"><!--
					google_ad_client = "ca-pub-4650144714910120";
					/* Summer Textbooks */
					google_ad_slot = "3313755342";
					google_ad_width = 234;
					google_ad_height = 60;
					//-->
					</script>
					<script type="text/javascript"
					src="http://pagead2.googlesyndication.com/pagead/show_ads.js">
					</script>
				</div>
			</div>
			<!-- end three column -->

			
			
			
		</div>
		
	</div>
	
	<div id="footer">
		<p></p>
	</div>
</div>
</body>
</html>
