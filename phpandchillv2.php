<?php

    //Used to avoid the HTTP not found error (Error 404)
    try
    {
        //Checks if the request method is POST
        if ($_SERVER["REQUEST_METHOD"] === "POST") 
        {
            //Retrieves and reads the raw POST data
            $jsonData = file_get_contents("php://input");

            //Decodes the raw JSON string into an associative array
            $jsonObj = json_decode($jsonData, true);
    
            //This extracts the form data and associates it with a variable
            $fname = $jsonObj["fname"];
            $lname = $jsonObj["lname"];
            $gender = $jsonObj["gender"];
            $age = $jsonObj["age"];
            $address = $jsonObj["address"];

            //Declaring a vairable for the first letter of the last name using substring
            $first = strtoupper(substr($lname, 0, 1));

            //Determines the class of the user based on their inputs
            if($first >= "A" && $first <= "M")
                $class = ($gender === "Male") ? "A" : "B";
            else if($first >= "N" && $first <= "Z")
                $class = ($gender === "Male") ? "C" : "D";
            else
                $class = "Unclassified";

            //Returns the response as a JSON object
            echo json_encode
            ([
                "class" => $class, 
                "fname" => $fname, 
                "lname" => $lname, 
                "gender" => $gender, 
                "age" => $age, 
                "address" => $address
            ]);

            //Exits the script ensure no further code is executed
            exit;
        }
    }
    catch(Exception $e)
    {
        http_response_code(404);
    }

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PHP and Chill V2</title>

    <!-- Tab Icon -->
    <link rel="icon" type="image/x-icon" href="static.png">

    <!-- AJAX -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>


    <style>

        /* Imports the DM Serif Display font */
        @import url('https://fonts.googleapis.com/css2?family=DM+Serif+Display:ital@0;1&family=Roboto+Slab:wght@100..900&display=swap');

        /* Imports the Roboto Slab font */
        @import url('https://fonts.googleapis.com/css2?family=Roboto+Slab:wght@100..900&display=swap');
    
        *
        {
            margin: 0;
        }

        body
        {
            padding: 5%;
            display: flex;
            justify-content: center;
            align-items: center;
            background-color: #fee392;
            background-image: url("banner.png");
            background-repeat: repeat;
            background-size: 450px 150px;
        }

        #main-container
        {
            background-color: #e7e5b8;
            border: 5px solid #937416;
            display: flex;
            width: 90vw;
            height: auto;
            border-radius: 20px;
            box-shadow:  0 20px 25px -5px black; 
        }

        #left-container
        {
            width: 50%;
            height: auto;
            display: flex;
            align-items: flex-end;
        }

        #background 
        {
            width: 100%;
            height: 100%;
            border-radius: 15px 0 0 15px;
        }

        #animated
        {
            width: 50%;
        }

        #right-container
        {
            padding: 2%;
            width: 50%;
            height: 98%;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: space-between;
        }

        h1
        {
            font-family: "DM Serif Display";
        }

        legend
        {
            font-family: "Roboto Slab";
        }

        label
        {
            font-family: "Roboto Slab";
        }

        fieldset
        {
            width: 100%;
        }

        input, select
        {
            border: 3px solid black;
            border-radius: 5px;
            height: 40px;
            font-family: "Roboto Slab";
            width: 100%;
            outline: none;
        }

        button
        {
            font-family: "Roboto Slab";
            background-color: #fee392;
            color: #937416;
            font-weight: bold;
            border: 2px solid #937416;
            width: 100%;
            height: 40px;
            border-radius: 5px;
            transition: 0.3s ease;
        }

        button:hover
        {
            font-family: "Roboto Slab";
            background-color: #937416;
            color: #fee392;
            scale: 1.02;
            transition: 0.3s ease;
        }

        @media screen and (max-width: 1024px)
        {

            #main-container
            {
                display: flex;
                flex-direction: column;
                width: 90vw;
                height: auto;
                background-color: #e7e5b8;
                border-radius: 20px;
            }

            #left-container
            {
                display: none;
            }

            #background 
            {
                border-radius: 15px 15px 0 0;
            }

            #right-container
            {
                padding: 1%;
                height: 100%;
                width: 100%;
                justify-content: space-between;
            }

            fieldset, button
            {
                width: 85%;
            }
        }

    </style>

</head>

<body>

    <!-- Main Container -->
    <div id="main-container">

        <!-- Animation Container -->
        <div id="left-container">

            <img id="background" src="gudetama.gif" alt="gudetama.gif">

        </div>

        <!-- Form Container -->
        <form id="right-container">

            <!-- Form Header -->
            <img id="animated" src="animated.gif" alt="animated.gif">

            <fieldset>

                <legend>Name</legend>

                <!-- First Name Section -->
                <label id="fname-label" for="fname">First Name <span style="color: red">*</span></label>
                <input id="fname" type="text" maxlength=30 placeholder="30 Maximum Characters" required>

                <br><br>

                <!-- Last Name Section -->
                <label id="lname-label" for="lname">Last Name <span style="color: red">*</span></label>
                <input id="lname" type="text" maxlength=30 placeholder="30 Maximum Characters" required>

            </fieldset>

            <br>

            <fieldset>

                <legend>Details</legend>

                <!-- Gender Section -->
                <label id="gender-label" for="gender">Gender <span style="color: red">*</span></label>
                <select id="gender" required>

                    <option value="" disabled selected>Select an option</option>
                    <option value="Male">Male</option>
                    <option value="Female">Female</option>

                </select>

                <br><br>

                <!-- Age Section -->
                <label id="age-label" for="age">Age <span style="color: red">*</span></label>
                <input id="age" type="number" min=13 max=150 onkeypress="return event.charCode>=48 && event.charCode<=57" placeholder="13 - 150 Years Old" required>

                <br><br>
                
                <!-- Address Section -->
                <label id="address-label" for="address">Address <span style="color: red">*</span></label>
                <input id="address" type="text" maxlength=100 placeholder="100 Maximum Characters" required>

            </fieldset>

            <br>

            <!-- Submit Button -->
            <button id="submit" type="submit">Submit</button>

            <br>

        </form>

    </div>

    <script>

        //Declaration of variables
        submit = document.getElementById("right-container");
        fname = document.getElementById("fname");
        lname = document.getElementById("lname");
        gender = document.getElementById("gender");
        age = document.getElementById("age");
        address = document.getElementById("address");

        //Validation Variables (Default True)
        let fnameValid = true;
        let lnameValid = true;
        let genderValid = true;
        let ageValid = true;
        let addressValid = true;

        //Function to verify first name every key press
        fname.addEventListener("keyup", fnameFunc);
        function fnameFunc()
        {
            for (let i = 0; i < fname.value.length; i++) 
            {
                let char = fname.value[i];
                fnameValid = true;
            }
            fname.style.borderColor = fnameValid ? "green" : "red";
        }

        //Function to verify last name every key press
        lname.addEventListener("keyup", lnameFunc);
        function lnameFunc()
        {
            for (let i = 0; i < lname.value.length; i++) 
            {
                let char = lname.value[i];
                lnameValid = true;
            }
            lname.style.borderColor = lnameValid ? "green" : "red";
        }

        //Function to verify if a gender is selected
        gender.addEventListener("change", genderFunc);
        function genderFunc()
        {
            genderValid = true;
            if(gender.value === "")
                genderValid = false;
            gender.style.borderColor = genderValid ? "green" : "red";
        }

        //Function to verify if the age is within range
        age.addEventListener("change", ageFunc);
        age.addEventListener("keyup", ageFunc);

        function ageFunc() 
        {
            let ageValid = true;

            if(age.value < 13 || age.value > 150)
                ageValid = false;

            age.style.borderColor = ageValid ? "green" : "red";
        }


        //Function to verify if the address field has value
        address.addEventListener("keyup", addressFunc);
        function addressFunc()
        {
            addressValid = true;
            address.style.borderColor = addressValid ? "green" : "red";
        }

        //Function to submit the form
        submit.addEventListener("submit", function(event)
        {

            //Prevents the button from reloading the page
            event.preventDefault();

            //Creating an object containing the user inputs
            let formData = {
                fname: document.getElementById("fname").value.trim(),
                lname: document.getElementById("lname").value.trim(),
                gender: document.getElementById("gender").value,
                age: parseInt(document.getElementById("age").value.trim(), 10),
                address: document.getElementById("address").value.trim()
            }

            //Converting the object into a JSON String
            let jsonData = JSON.stringify(formData);

            //Double-checking if all fields are valid
            if(fnameValid && lnameValid && genderValid && ageValid && addressValid)
            {
                //AJAX request using a jQuery function
                $.ajax 
                ({
                    //Specifies where the data should be sent
                    url: "phpandchillv2.php",
                    //Specifies the type of request method
                    type: "POST",
                    //Indicates which data is to be sent
                    data: jsonData,
                    //Informs the server of what datatype it should expect to parse
                    contentType: "application/json",
                    //The expected format of the response from the server
                    dataType: "json",
                    //This executes if the request is successful
                    success: function (response) 
                    {
                        //Sweet Alert 2 Success Message
                        Swal.fire
                        ({
                        icon: "success",
                        //The reference to the JSON object variable
                        title: "Class " + response.class,
                        html: 
                        //Backtick is used in order to embed variables directly
                        `
                        <div style="text-align: left">

                            Name: ${response.lname}, ${response.fname}<br>
                            Gender: ${response.gender}<br>
                            Age: ${response.age}<br>
                            Address: ${response.address}

                        </div>
                        `
                        });
                    },
                    //This executes if the request is unsuccessful
                    error: function (response) 
                    {
                        Swal.fire
                        ({
                            icon: "error",
                            title: "Something went wrong!",
                            text: "Please check your inputs.",
                        });
                    }
                });
            }
            else
            {
                //Sweet Alert 2 Message that executes if any of the inputs are invalid
                Swal.fire
                ({
                    icon: "error",
                    title: "Something went wrong!",
                    text: "Please check your inputs.",
                });
            }
            
        });

    </script>
    
</body>

</html>