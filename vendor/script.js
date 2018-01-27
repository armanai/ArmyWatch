function deleteEdit(id, deleteEdit) {
	if (deleteEdit == "delete") {

        if (window.XMLHttpRequest) {
            // code for IE7+, Firefox, Chrome, Opera, Safari
            xmlhttp = new XMLHttpRequest();
        } else {
            // code for IE6, IE5
            xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
        }
        xmlhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                   $('#deleteModal #id').val(this.responseText);
                   var so = this.responseText;
                   console.log(so);
            }
        };
        xmlhttp.open("GET","inc/adminHandeling.php?id=" + id + "&what="+deleteEdit,true);
        xmlhttp.send();
    }
    else if (deleteEdit == "edit") {
    	if (window.XMLHttpRequest) {
            // code for IE7+, Firefox, Chrome, Opera, Safari
            xmlhttp = new XMLHttpRequest();
        } else {
            // code for IE6, IE5
            xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
        }
        xmlhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
               var array = this.responseText.split("***");
               console.log(this.responseText);
               $('#editModal #name').val(array[1]);
               $('#editModal #description').val(array[2]);
               $('#editModal #price').val(array[3]);
               $('#editModal #quantity').val(array[4]);
               $('#editModal #saleprice').val(array[5]);
               $('#editModal #id').val(array[6]);

            }
        };
        xmlhttp.open("GET","inc/adminHandeling.php?id=" + id + "&what="+deleteEdit,true);
        xmlhttp.send();
    }
}