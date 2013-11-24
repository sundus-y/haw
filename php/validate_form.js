<script type="text/javascript">

	function validate()
	{
 
		if( document.new_form.s_name.value == "" )
		{
		 alert( "Please provide Sender Name!" );
		 document.new_form.s_name.focus() ;
		 return false;
		}
		if( document.new_form.s_number.value == "" )
		{
		 alert( "Please provide Sender Number!" );
		 document.new_form.S_number.focus() ;
		 return false;
		}
		if( document.new_form.amount.value == "" )
		{
		 alert( "Please provide Amount!" );
		 document.new_form.amount.focus() ;
		 return false;
		}
		if( document.new_form.rate.value == "" )
		{
		 alert( "Please provide Rate!" );
		 document.new_form.rate.focus() ;
		 return false;
		}
		if( document.new_form.r_name.value == "" )
		{
		 alert( "Please provide Reciver Name!" );
		 document.new_form.r_name.focus() ;
		 return false;
		}
		if( document.new_form.r_number.value == "" )
		{
		 alert( "Please provide Reciver Number!" );
		 document.new_form.r_number.focus() ;
		 return false;
		}
		if( document.new_form.location.value == "" )
		{
		 alert( "Please provide Location!" );
		 document.new_form.location.focus() ;
		 return false;
		}

		return( true );
	}
	
</script>