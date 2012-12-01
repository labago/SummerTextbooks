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
                    <?php if($_SESSION['logged_in'] == 1){ ?>
                    <li><a href="books.php">My Book Queue</a></li>
                    <li><a href="orders.php">My Orders</a></li>
                    <?php } ?>
                    <li><a href="terms.php">Terms and Conditions</a></li>
                    </ul> 
				</div>
			</div>
			<!-- end three column -->

			
			
			
		</div>
		
	</div>
	
	<div id="footer">
		<p>&copy; 2009. Design by <a href="http://www.spyka.net">Free CSS Templates</a> &amp; <a href="http://www.justfreetemplates.com">Free Web Templates</a></p>
	</div>
</div>
</body>
</html>
