CREATE TABLE `contacts` (
`id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY ,
`names` VARCHAR( 200 ) NOT NULL ,
`phone` VARCHAR( 100 ) NOT NULL
);

# FileName="Connection_php_mysql.htm"
# Type="MYSQL"
# HTTP="true"
//configure the database paramaters
$hostname_packpub_addressbook = "YOUR-DATABASE-HOST";
$database_packpub_addressbook = "YOUR-DATABASE-NAME";
$username_packpub_addressbook = "YOUR-DATABASE-USERNAME";
$password_packpub_addressbook = "YOUR-DATABASE-PASSWORD";
//connect to the database server
$packpub_addressbook = mysql_pconnect($hostname_packpub_addressbook, $username_packpub_addressbook,
                       $password_packpub_addressbook) or trigger_error(mysql_error(),E_USER_ERROR);
//selete the database
mysql_select_db($database_packpub_addressbook);

//function to save new contact
/**
* @param <string> $name //name of the contact
* @param <string> $phone //the telephone number of the contact
*/
function saveContact($name,$phone){
              $sql="INSERT INTO contacts (names , phone ) VALUES ('".$name."','".$phone."');";
              $result=mysql_query($sql)or die(mysql_error());
}
//lets write a function to delete
/**
* @param <int> id //the contact id in database we wish to delete
*/
function deleteContact($id){
              $sql="DELETE FROM contacts where id=".$id;
              $result=mysql_query($sql);
}

//lets get all the contacts
function getContacts(){
              //execute the sql to get all the contacts in db
              $sql="SELECT * FROM contacts";
              $result=mysql_query($sql);
              //store the contacts in an array of objects
              $contacts=array();
              while($record=mysql_fetch_object($result)){
                            array_push($contacts,$record);
              }
              //return the contacts
              return $contacts;
}

//lets handle the Ajax calls now
$action=$_POST['action'];
//the action for now is either add or delete
if($action=="add"){
              //get the post variables for the new contact
              $name=$_POST['name'];
              $phone=$_POST['phone'];
              //save the new contact
              saveContact($name,$phone);
              $output['msg']=$name." has been saved successfully";
              //reload the contacts
              $output['contacts']=getContacts();
              echo json_encode($output);
}else if($action=="delete"){
              //collect the id we wish to delete
              $id=$_POST['id'];
              //delete the contact with that id
              deleteContact($id);
              $output['msg']="one entry has been deleted successfully";
              //reload the contacts
              $output['contacts']=getContacts();
              echo json_encode($output);
}else{
              $output['contacts']=getContacts();
              $output['msg']="list of all contacts";
              echo json_encode($output);
}
