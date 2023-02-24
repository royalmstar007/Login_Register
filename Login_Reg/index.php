<?php
    session_start();
    if(!isset($_SESSION["user"])){
        header("Location: login.php");  //session code to provide access to logined users only
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dynamic Rows</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <style>
        ._table :is(th,td){
                border: 1px solid #0003;
                padding: 8px 10px;
                background-color: white;
            }
        .form_control{
                border: 1px solid #0003;
                background-color: transparent;
                outline: none;
                padding: 8px 12px;
                width: 100%;
            }
    </style>
</head>
<body class="bg-red-700 p-6">
    <div class="text-center text-lg"><?php echo 'welcome ' .$_SESSION["user"];?></div>
    <div class="max-w-4xl w-full bg-blue-500 m-auto p-4 shadow-xl rounded-md overflow-auto">
        <table class="_table w-full border-collapse">
            <thead>
                <tr>
                    <th>Item</th>
                    <th>Quantity</th>
                    <th>Price</th>
                    <th>
                        <div class="action_container">
                            <button onclick="create_tr('table_body')">
                                <i class="fa-solid fa-plus"></i>
                            </button>
                        </div>
                    </th>
                </tr>
            </thead>
            <tbody id="table_body">
                <tr>
                    <td>
                        <input type="text" class="form_control" placeholder="Enter the Item" autocomplete="off">
                    </td>
                    <td>
                        <input type="text" class="form_control" placeholder="Enter the Quantity" autocomplete="off">
                    </td>
                    <td>
                        <input type="number" class="form_control" placeholder="Enter the Item price" autocomplete="off">
                    </td>
                    <td>
                        <div class="action_container">
                            <button onclick="remove_tr(this)">
                                <i class="fa-solid fa-trash"></i>
                            </button>
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
    <a href="logout.php" class="btn btn-warning mx-6">Logout</a>

    <!--Javascript code-->
    <script>
        //for creating and adding dynamic rows
       function create_tr(table_id) {
        let table_body = document.getElementById(table_id),
        first_tr   = table_body.firstElementChild
        tr_clone   = first_tr.cloneNode(true);

        table_body.append(tr_clone);
        
       
       // clean_first_tr(table_body.firstElementChild);
        }
         //for making first row clear for adding another row
        function clean_first_tr(firstTr) {
        let children = firstTr.children;
    
        children = Array.isArray(children) ? children : Object.values(children);
        children.forEach(x=>{
                if(x !== firstTr.lastElementChild)
                {
                    x.firstElementChild.value = '';
                }
            });
        }   

        function remove_tr(This) {
            if(This.closest('tbody').childElementCount == 1)
            {
                alert("You Don't have Permission to Delete This !");
            }
            else
            {
            This.closest('tr').remove();
            }
        }

        
    </script> 
</body>
</html>