<?php
/**
* @project ApPHP Shopping Cart
* @copyright (c) 2012 ApPHP
* @author ApPHP <info@apphp.com>
* @license http://www.gnu.org/licenses/
*/

// *** Make sure the file isn't accessed directly
defined('APPHP_EXEC') or die('Restricted Access');
//--------------------------------------------------------------------------

if($objLogin->IsLoggedInAsAdmin() && Modules::IsModuleInstalled('shopping_cart')){

	// for uniquie prefix 
	$action 	= MicroGrid::GetParameter('action');
	$rid    	= MicroGrid::GetParameter('rid');
	$mode   	= 'view';
	$msg 		= '';
	
	$objDeliveries = new Deliveries();
	
	if($action=='add'){		
		$mode = 'add';
	}else if($action=='create'){
		if($objDeliveries->AddRecord()){
			$msg = draw_success_message(_ADDING_OPERATION_COMPLETED, false);
			$mode = 'view';
		}else{
			$msg = draw_important_message($objDeliveries->error, false);
			$mode = 'add';
		}
	}else if($action=='edit'){
		$mode = 'edit';
	}else if($action=='update'){
		if($objDeliveries->UpdateRecord($rid)){
			$msg = draw_success_message(_UPDATING_OPERATION_COMPLETED, false);
			$mode = 'view';
		}else{
			$msg = draw_important_message($objDeliveries->error, false);
			$mode = 'edit';
		}		
	}else if($action=='delete'){
		if($objDeliveries->DeleteRecord($rid)){
			$msg = draw_success_message(_DELETING_OPERATION_COMPLETED, false);
		}else{
			$msg = draw_important_message($objDeliveries->error, false);
		}
		$mode = 'view';
	}else if($action=='details'){		
		$mode = 'details';		
	}else if($action=='cancel_add'){		
		$mode = 'view';		
	}else if($action=='cancel_edit'){				
		$mode = 'view';
	}
	
	// Start main content
	draw_title_bar(
		prepare_breadcrumbs(
			array(_SHOPPING_CART=>'',_DELIVERY_SETTINGS=>'', ucfirst($action)=>'')
		)
	);
    	
	//if($objSession->IsMessage('notice')) echo $objSession->GetMessage('notice');
	echo $msg;

	draw_content_start();	
	if($mode == 'view'){		
		$objDeliveries->DrawViewMode();	
	}else if($mode == 'add'){		
		$objDeliveries->DrawAddMode();		
	}else if($mode == 'edit'){		
		$objDeliveries->DrawEditMode($rid);		
	}else if($mode == 'details'){		
		$objDeliveries->DrawDetailsMode($rid);		
	}
	draw_content_end();	

}else{
	draw_title_bar(_ADMIN);
	draw_important_message(_NOT_AUTHORIZED);
}
?>