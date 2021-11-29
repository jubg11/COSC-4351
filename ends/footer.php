	</main>
	<div id="footer">
		<footer class="footer-copyright">
			<div class="center">&copy; Copyright 2021 | University of Houston | COSC 4351</div>
		</footer>
	</div>

	<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
	<script type="text/javascript">
		$(document).ready(function() {
			$('.collapsible').collapsible();
		})


		$(document).ready(function() {
			$('select').formSelect();
		});

		var currYear = (new Date()).getFullYear();
		$(document).ready(function() {
			$(".datepicker").datepicker({
				yearRange: [1900, currYear - 18],
				format: "yyyy-mm-dd"
			});
		});

		var currYear2 = (new Date()).getFullYear();
		$(document).ready(function() {
			$(".datepicker2").datepicker({
				yearRange: [currYear, currYear + 50],
				format: "yyyy-mm-dd"
			});
		});

		$(document).ready(function() {
			$('.dropdown-trigger').dropdown();
		});

		$(document).ready(function() {
			$('input#input_text, textarea#textarea2').characterCounter();
		});


		$(document).ready(function() {
			$('.modal').modal();
		});

		$(document).ready(function() {
			$('.tabs').tabs();
		});
	</script>
	</body>

	</html>