
<!DOCTYPE html>

<head>
    <!-- Add meta tags for mobile and IE -->
    <meta name="viewport" content="width=device-width, initial-scale=1"> <!-- Ensures optimal rendering on mobile devices. -->
  <meta http-equiv="X-UA-Compatible" content="IE=edge" /> <!-- Optimal Internet Explorer compatibility -->
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
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
    <div id ="main-container"class='container amount-container'>
    <div class = "row" >
        
   
    <div class="row amount-div">

        <table id="display-table" class="table table-bordered amount-table" >
            <tbody>
            <tr class="info">
                <td id="onetd"><input type="hidden" name="first" value="50">$50</td>
                <td id="twotd"><input type="hidden" name="first" value="100">$100</td>
                <td id="threetd"><input type="hidden" name="first" value="250">$250</td>
                <td id="fourtd"><input type="hidden" name="first" value="500">$500</td>
                <td id="othertd">other</td>
                <td  id = 'inputCell'style='width:70px;'><input  type='number' id='donateamount' name='donateamount' contentedittable='true' placeholder='$'></td>
            </tr>
            </tbody>
        </table>
        <script>
        var table = document.getElementById("display-table");
            $(document).ready(function(){
                $("tr:even").css("background-color", "#F4F4F8");
                $("tr:odd").css("background-color", "#EFF1F1");

                $("td").click(function () {
                    var NotSelected = table.getElementsByTagName('td');
                    for (var col = 0; col < NotSelected.length; col++) {
                                 NotSelected[col].style.backgroundColor = "";
                                 NotSelected[col].classList.remove('selected');
                                 amount = 0;                         
                    }
                    $('.selected').removeClass('selected');
                    $(this).addClass("selected");
                    $(this).css('background-color','#0066ff');
                    $('#inputCell').css('background-color','#d9edf7');                   
                    $('#donateamount').val($(this).children().val());
                    if($(this)==$('#othertd'))
                         $('#donateamount').attr('placeholder', 'Please input'); 
                });
                $("#othertd").click(function(){
                    $('#donateamount').attr('placeholder', 'Please input');
                });
            });
           
        </script>
        <!-- Set up a container element for the button -->
        <div id="paypal-button-container"></div>

    <!-- Include the PayPal JavaScript SDK -->
    <script src="https://www.paypal.com/sdk/js?client-id=AR2beAMlmq6FSjI2dZaWPT3b25wXipbKu7f_J1Lc8V_E246S2f-nlFBhK-OIm-TN9GdAt8cVcWu_lLFE&currency=USD"></script>
    </div>
    <script>      
    //&merchant-id=RYSDSB6BDKP5G
     
        paypal.Buttons({

            // Set up the transaction
            createOrder: function(data, actions) {
                return fetch('/samples/CaptureIntentExamples/CreateOrder.php', {
                    method: 'post',
                    body:JSON.stringify($('#donateamount').val()),
                    headers: {
                        'content-type': 'application/json'
                    },
                }).then(function(res) {
                    return res.json();
                 })
                .then(function(data) {
                    return data.id;
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

                }).then(function(res) {
                    return res.json();
                 })
                .then(function(details) {
                    
                    actions.redirect('https://localhost/success.php');
                    return details.id;
                });             
              
            },
            onCancel: function(data,actions){
                actions.redirect('https://localhost/error.php');
            }
            
        }).render('#paypal-button-container');
    </script>
</body>
    