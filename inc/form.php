	<script type="text/javascript">
		$(document).ready(function() {
		  $("select").select2({
		  	    tags: "true",
  				placeholder: "От",
  				allowClear: true
		  });
		 

		});
	</script>

	<p>Сохранить id пользователей по числу лайков в файл
 <form method="post" action="">
 <select style="width: 6%"  data-tags="true" data-placeholder="От" data-allow-clear="true" name="likeFrom">

	
	
	  	<option></option>
<?php 
		for ($i=0; $i < 1000; $i++) { 
			echo "<option>$i</option>";
		}


?>
	
</select>

- <select style="width: 6%"  data-tags="true" data-placeholder="До" data-allow-clear="true" name="likeTo">

	
	
	  	<option></option>
<?php 
		for ($i=0; $i < 1000; $i++) { 
			echo "<option>$i</option>";
		}


?>
	
</select>

  
	<input type="submit" class="btn btn-info" name="submitSelectTxt" value="Скачать txt">
	<input type="submit" class="btn btn-info" name="submitSelectExcel" value="Скачать Excel">

 </form>