<!-- Modal -->
<div class="modal fade" id="checkEmail" role="dialog">
	<div class="modal-dialog">
      
	    <div class="modal-content">

    	    <div class="modal-header">
    		    <button type="button" class="close" data-dismiss="modal">&times;</button>
        		<h4 class="modal-title">Проверка существования Email</h4>
        	</div> <!-- Modal Header -->

        <div class="modal-body" id="checkPanel">
			<form action="emailValidator.php" method="post" id="getAccessForm" >

				<div class="input-group input-group-lg">
					<span class="input-group-addon" id="sizing-addon2"><i class="fa fa-inbox"></i></span>
			      	<input type="email" name="email" class="form-control" placeholder="EMAIL:">
			      	<span class="input-group-btn">
			        	<button class="btn btn-primary" type="submit"><i class="fa fa-check"></i> Ввод</button>
			      	</span>
			    </div>
			    <br/>

				<div id="result">
				</div><!-- Result div end -->

				<p class="button-right">
					<button type="reset" class="btn btn-default">
				    	<i class="fa fa-refresh"></i> Сброс
					</button>
					<button type="button" class="btn btn-default" data-dismiss="modal">
						<i class="fa fa-remove"></i> Закрыть
					</button>
				</p>		

			</form><!-- getAccessForm End -->

		</div><!-- Modal Body-->
        
        </div><!-- Modal Content -->
    </div><!-- Modal Dialog -->      
    
</div><!-- checkEmail end -->
