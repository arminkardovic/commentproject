<?php 


	class logoutModel extends baseModel{
		
		public function logoutUser(){
			if(!(session_id() == '')) {
    			session_destroy();
				return true;
            }
			return false;
		}
		
	}


?>