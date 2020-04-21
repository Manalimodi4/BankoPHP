
 <?php  
 require_once 'connection.php';
 $query ="SELECT * FROM `accounts`";  
 $result = db_query($query);  
 ?>  
 <!DOCTYPE html>  
 <html>  
      <head>  
           <title>mm</title>  
           <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>  
           <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />  
           <script src="https://cdn.datatables.net/1.10.12/js/jquery.dataTables.min.js"></script>  
           <script src="https://cdn.datatables.net/1.10.12/js/dataTables.bootstrap.min.js"></script>            
           <link rel="stylesheet" href="https://cdn.datatables.net/1.10.12/css/dataTables.bootstrap.min.css" />  
      </head>  
      <body>  
           <br /><br />  
           <div class="container">    
                <br />  
                <div class="table-responsive">  
                     <table id="players_data" class="table table-striped table-bordered">  
                          <thead>  
                               <tr>  
                                    <td>id</td>  
                                    <td>username</td>  
                                    <td>password</td>  
                                    <td>amount</td>  
                                    <td>roomID</td>  
                               </tr>  
                          </thead>  
                          <?php  
                          while($row = mysqli_fetch_array($result))  
                          {  
                               echo '  
                               <tr>  
                                    <td>'.$row["id"].'</td>  
                                    <td>'.$row["username"].'</td>  
                                    <td>'.$row["password"].'</td>  
                                    <td>'.$row["amount"].'</td>  
                                    <td>'.$row["roomID"].'</td>  
                               </tr>  
                               ';  
                          }  
                          ?>  
                     </table>  
                </div>  
           </div>  
      </body>  
 </html>  
 <script>  
 $(document).ready(function(){  
      $('#players_data').DataTable();  
 });  
 </script> 