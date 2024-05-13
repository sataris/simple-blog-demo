<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?php echo $pageTitle; ?></title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.13.2/jquery-ui.min.js"></script>
    <link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.13.2/themes/smoothness/jquery-ui.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f9f9f9;
        }

        header {
            background-color: #f4f4f4;
            color: #666;
            padding: 10px 0;
            text-align: center;
        }

        nav {
            background-color: #333;
            color: #fff;
            display: flex;
            justify-content: flex-end;
            padding: 0 30px;
        }

        nav a {
            color: #fff;
            text-decoration: none;
            padding: 12px;
            margin-right: 10px;
        }

        main {
            padding: 20px;
            max-width: 800px;
            margin: 20px auto;
        }

        article {
            background-color: #fff;
            border-radius: 5px;
            padding: 20px;
            margin-bottom: 20px;
        }

        footer {
            background-color: #333;
            color: #fff;
            text-align: center;
            padding: 20px;
            bottom: 0;
            width: 100%;
        }

        /* The Modal (background) */
        .modal {
            display: none; /* Hidden by default */
            position: fixed; /* Stay in place */
            z-index: 1; /* Sit on top */
            left: 0;
            top: 0;
            width: 100%; /* Full width */
            height: 100%; /* Full height */
            overflow: auto; /* Enable scroll if needed */
            background-color: rgb(0, 0, 0); /* Fallback color */
            background-color: rgba(0, 0, 0, 0.4); /* Black w/ opacity */
        }

        /* Modal Content/Box */
        .modal-content {
            background-color: #fefefe;
            margin: 15% auto; /* 15% from the top and centered */
            padding: 20px;
            border: 1px solid #888;
            width: 80%; /* Could be more or less, depending on screen size */
        }

        /* Add to your existing CSS file or inside a <style> tag in the <head> secton of your HTML */

        .pagination-wrap {
            display: flex;
            justify-content: center;
            margin: 20px 0;
        }

        .pagination-wrap a {
            color: #333;
            padding: 10px 15px;
            text-decoration: none;
            margin: 0 2px;
            border: 1px solid #999;
            border-radius: 3px;
            transition: background-color 0.3s ease;
        }

        .pagination-wrap a.active-link {
            background-color: #555;
            color: #fff;
        }

        .pagination-wrap a:hover {
            background-color: #ddd;
        }

        .pagination-wrap a:first-child {
            margin-left: 0;
        }

        .pagination-wrap a:last-child {
            margin-right:
        }

        /* The Modal (background) */
        .modal {
            display: none; /* Hidden by default */
            position: fixed; /* Stay in place */
            z-index: 1; /* Sit on top */
            left: 0;
            top: 0;
            width: 100%; /* Full width */
            height: 100%; /* Full height */
            overflow: auto; /* Enable scroll if needed */
            background-color: rgb(0, 0, 0); /* Fallback color */
            background-color: rgba(0, 0, 0, 0.4); /* Black w/ opacity */
        }

        /* Modal Content/Box */
        .modal-content {
            background-color: #fefefe;
            margin: 15% auto; /* 15% from the top and centered */
            padding: 20px;
            border: 1px solid #888;
            width: 80%; /* Could be more or less, depending on screen size */
        }
    </style>
    <script type="text/javascript">
        $(document).ready(function () {
            var dialog = $("#dialog").dialog({
                autoOpen: false,
                modal: true,
                buttons: {
                    Ok: function () {
                        $(this).dialog("close");
                    }
                }
            });
            $('#searchform').submit(function (e) {
                var searchField = $('#searchform input[name="search"]');

                if ($.trim(searchField.val()) === '') {
                    e.preventDefault();
                    $("#modalMessage").html('Please enter a search term');
                    dialog.dialog("open");
                }
            });
            // When user clicks on Login or Register link
            $('.trigger-modal').click(function (e) {
                e.preventDefault();
                $('#modalBox').fadeIn(); // Show the modal box
            });

            // When user clicks anywhere outside of the modal, close it
            $(window).click(function (e) {
                if ($(e.target).is('.modal')) {
                    $('.modal').fadeOut();
                }
            });
        });
    </script>
</head>