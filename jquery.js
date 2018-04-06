//initilize the javascript when the page is fully loaded
$(document).ready(function(){
              //hide the add contact form
              $('#add-contact-form').hide();
              //hide the favourites
              $('#favourites').hide();
              //set the add contact form button event
              $('#add-contact-btn').click(function(){
                            //hide the favourites if its still there
                            $('#favourites').hide();
                            //show the add contact form slowly when button is clicked
                            $('#add-contact-form').show('slow');
              });
              //set the search button event
              $('#search-btn').click(function(){
                            $('#add-contact-form').hide('slow');
                            $('#favourites').hide();
              });
              //set all the delete button events
              setDeleteButtonEvents();
              //set the save button event
              setSaveButtonEvent();
              //load the address list now
              //call the ajax save function
                $.ajax({
                              url: 'addressbook.php',
                              data: '',
                              dataType: 'json',
                              type: 'post',
                              success: function (j) {
                                          //refresh the address list
                                          displayAddressList(j.contacts);
                            },});
});
