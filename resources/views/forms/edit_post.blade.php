<!DOCTYPE html>
<html>
<head>
    <title></title>
    <link rel="stylesheet" type="text/css" href="/css/reset.css">

    <style>
        body { font-family: Arial, Helvetica, sans-serif;}
        /* Modal Content */
        .modal-content {
            display: flex;
            justify-content: center;
            border-radius:10px;
            background-color: #242526;
            margin: auto;
            height: 300px;
            padding: 20px;
            border: 1px solid #888;
            /*width: 90vw;*/
        }

        .modal-forms{
            text-align: left;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-content: center;
            align-items: center;
        }
        .modal-forms p{
            font-family: sans-serif;
            font-weight: bold;
            font-size: 15px;
            color:white;
        }
        .modal-forms textarea{
            border:none;
            width: 400px;
            height: 150px;
            outline: none !important;
            border-radius: 10px;
            background:#3a3b3c;
            color:white;
            padding: 5px;
            font-size: 15px;
            padding-left: 10px;
        }
        .modal-forms textarea:hover{
            background:#3e4042;
        }
        .file{
            visibility: hidden;
        }
        .modal-forms label{
            color:white;
            padding: 5px;
            font-size: 15px;
            border-radius: 15px;
            width: 80px;
            text-align: center;
            background:#3a3b3c;
        }
        .modal-forms label:hover{
            background:#3e4042;
        }
        .update{
            margin-top: 5px;
            border: none;
            color: white;
            width: 80px;
            padding: 5px;
            font-size: 15px;
            border-radius: 15px;
            background: #3a3b3c;
        }
        .update:hover{
            background: #3e4042;
        }

        .iframes{
            display: none;
            position: fixed;
            z-index: 1;
            padding-top: 100px;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
        }
        .button-wrapper{
            display:flex;
            flex-direction:row;
            justify-content: space-around;
        }
        .button-wrapper button {
            margin: 5px;
        }
    </style>
</head>
<body>


<div id="myModal" class="modal">

    <!-- Modal content -->
    <div class="modal-content">
        <div class = 'modal-forms'>

            <div class = 'button-wrapper'>
                <form action="{{ route("updatePost", ["post_id" => $post->id])}}" method="POST" enctype="multipart/form-data" class='modal-forms'>
                    @csrf
                    <p>Post Description</p>
                    <textarea name="description" placeholder="Write Something..." required>{{ $post->description }}</textarea>
                    <input type="file" name="image" id='file' class='file'>
                    <label for='file' class = 'filelabel'>Choose File</label>
                    <button class='update submit'>Update</button>
                </form>
            </div>
            <button class='update' onclick="document.location.href='/iframe/{{ $post->id }}';">Cancel</button>

        </div>
    </div>
</div>
<script>
    // Get the modal
    var modal = document.getElementById("myModal");

    // Get the button that opens the modal
    var btn = document.getElementById("myBtn");

    // Get the <span> element that closes the modal
    var span = document.getElementsByClassName("close")[0];

    // When the user clicks the button, open the modal
    btn.onclick = function() {
        modal.style.display = "block";
    }

    // When the user clicks on <span> (x), close the modal
    span.onclick = function() {
        modal.style.display = "none";
    }

    // When the user clicks anywhere outside of the modal, close it
    window.onclick = function(event) {
        if (event.target == modal) {
            modal.style.display = "none";
        }
    }
</script>
</body>
</html>
