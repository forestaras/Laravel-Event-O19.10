CRUDBooster::redirect($_SERVER['HTTP_REFERER'],"Server Offline","warning");  //Назад з повідомленням
CRUDBooster::redirect('/',"Server Offline","warning");  // на сторінку з повідомленням 
$postdata['userid'] = CRUDBooster::myId();  //Мій ID