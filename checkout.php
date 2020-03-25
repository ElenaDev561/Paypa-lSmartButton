
<!DOCTYPE html>

<head>
    <!-- Add meta tags for mobile and IE -->
    <meta name="viewport" content="width=device-width, initial-scale=1"> <!-- Ensures optimal rendering on mobile devices. -->
  <meta http-equiv="X-UA-Compatible" content="IE=edge" /> <!-- Optimal Internet Explorer compatibility -->
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
  <style>
    .amount-btn{
        min-width: 750 px;
        max-width: 750px;
        font-size: 18px;
    }
    .amount-div{
        min-width: 500px;
        max-width: 750px;
        font-size: 18px;
    }
    .amount-container{
        padding-top: 200px;
    }
    .disabled{
    pointer-events: none;
    }
  </style>
</head>

<body>
    <div class='container amount-container'>

        <div class="row amount-div">

        <table id="display-table" class="table table-bordered amount-table" >
            <tbody>
            <tr class="info">
                <td ><input type="hidden" name="first" value="50">$50</td>
                <td><input type="hidden" name="first" value="50">$100</td>
                <td><input type="hidden" name="first" value="50">$250</td>
                <td><input type="hidden" name="first" value="50">$500</td>
                <td id="tother_amount">other</td>
            </tr>
            </tbody>
        </table>
        <!-- Set up a container element for the button -->
        <div id="paypal-button-container"></div>

    <!-- Include the PayPal JavaScript SDK -->
    <script src="https://www.paypal.com/sdk/js?client-id=AR2beAMlmq6FSjI2dZaWPT3b25wXipbKu7f_J1Lc8V_E246S2f-nlFBhK-OIm-TN9GdAt8cVcWu_lLFE&currency=USD"></script>

    <script>       
    let amount = [];
    var amount_data=[50,100,250,500];
    var table = document.getElementById("display-table");
    var other_table = document.getElementById("tother_amount");
            if (table != null) {

                for (var j = 0; j < table.rows[0].cells.length; j++){

                    var len = table.rows[0].cells.length;
                    table.rows[0].cells[j].onclick = function () {


                        var NotSelected = table.getElementsByTagName('td');
                        var OtherID = document.getElementById("tother_amount");

                        if(OtherID==this){

                            for (var col = 0; col < NotSelected.length; col++) {
                                NotSelected[col].style.backgroundColor = "";
                                NotSelected[col].classList.remove('selected');
                                amount = 0;
                            
                            }
                            if($('#other_amount').length==0){

                                $("tr").append("<td  id = 'inputCell'style='width:150px;'><input  type='text' id='other_amount' name='other_amount' contentedittable='true' placeholder='$1000'></td>")
                            
                            }
                            
                            $(this).css("background-color","#0000ff");

                            $('#other_amount').bind('input', function () {
                            
                                amount [0] = 0;
                                amount [1] = $('#other_amount').val();

                                // $.post("index.php",
                                // {
                                //     request: "ajax",
                                //     amount : amount,
                                //     other  : "other"
                                // },
                                // function(data, status){
                                //     console.log("success-post");
                                // });
                            });
                            
                        }else{
                            
                            $('#inputCell').remove();
                            for (var col = 0; col < NotSelected.length; col++) {
                                NotSelected[col].style.backgroundColor = "";
                                NotSelected[col].classList.remove('selected');

                            }
                            $(this).css("background-color","#0000ff");

                            var order= $(this).index();

                            amount [1] = 0;
                            if(order == 0)
                                amount [0] = amount_data[0];
                            else if(order == 1)
                                amount [0] = amount_data[1];
                            else if(order == 2)
                                amount [0] = amount_data[2];
                            else if(order == 3)
                                amount [0] = amount_data[3];

                                // $.post("/samples/CaptureIntentExamples/CaptureOrder.php",
                                // {
                                //     request: "ajax",
                                //     amount : amount
                                // },
                                // function(data, status){
                                //     //location.reload(true);
                                // });
                        }

                    

                            // 
                    };
                    
                }
            }
            // Render the PayPal button into #paypal-button-container
        paypal.Buttons({

            // Set up the transaction
            createOrder: function(data, actions) {
                return fetch('/samples/CaptureIntentExamples/CreateOrder.php', {
                    method: 'post'
                }).then(function(res) {
                    return res.json();
                }).then(function(data) {
                    return data.id; // Use the same key name for order ID on the client and server
                });
            },

            // Finalize the transaction
            onApprove: function(data, actions) {

                return fetch('/samples/CaptureIntentExamples/CaptureOrder.php', {
                    method:'POST',
                    headers: {
                    'content-type': 'application/json'
                    },
                     body: JSON.stringify(data.orderID),
                // }).then(function(res) {
                //     console.log("DDDDDDDDDDDDDD");                    
                //     console.log(res);
                //     console.log(JSON.parse(res));
                //     return res.json();
                // }).then(function(details) {
                //     console.log("DDDDDDDDDDDDDD");                    
                //     console.log(details);
                //     alert('Transaction funds captured from ' + details.id);
                // })
                }).then(res=>res.text())
                  .then(text=>console.log(text))

            }
                ///' + data.orderID + '/capture/

        }).render('#paypal-button-container');
    </script>
</body>
    